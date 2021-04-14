<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce website/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
  //header('Location: login.php');
  }
   include 'includes/head.php';
   include 'includes/navigation.php';

   $sql = "select * from Categories where parent = 0";
   $result =$db->query($sql);

   $errors = array();
   $category = '';
   $post_parent = '';

   //edit  category from the table
   if (isset($_GET['edit']) && !empty($_GET['edit'])) {
     $edit_id = (int)$_GET['edit'];
     $edit_id = sanitize($edit_id);
     $Esql = "select * from categories where id = '$edit_id'";
   	$Eresult = $db->query($Esql);
   	$Ecategory = mysqli_fetch_assoc($Eresult);
   }

   //delete from the table
   if (isset($_GET['delete']) && !empty($_GET['delete'])) {
   	$delete_id = (int)$_GET['delete'];
   	$delete_id = sanitize($delete_id);
   	$sql = "select * from categories where id = '$delete_id'";
   	$result = $db->query($sql);
   	$category = mysqli_fetch_assoc($result);
   	if($category['parent'] == 0) {
   		$sql = "delete from categories where parent = '$delete_id'";
   		$db->query($sql);
   	}
   	$dsql = "delete from categories where id = '$delete_id'";
   	$db->query($dsql);
   	header('Location: categories.php');
   }


   //form processing or all about form
   if(isset($_POST)&& !empty($_POST)) {
   	$post_parent = sanitize($_POST['parent']);
   	$category = sanitize($_POST['category']);
   	$sqlf="select * from categories where category = '$category' and parent = '$post_parent'";

    if (isset($_GET['edit'])) {
      $id=$Ecategory['id'];
      $sqlf = "select * from categories where category = '$category' and parent = '$post_parent' and id != '$id'";
    }
   	$fresult = $db->query($sqlf);
   	$count = mysqli_num_rows($fresult);
   	//if category is blank
   	if($category == ''){
   		$errors[] .= 'The category should be filled';
   	}
    //if exits in the database
    if($count > 0) {
    	$errors[] .= $category. ' already exists. Please choose a new category';
    }
   	//Displayong error or update database
   	if (!empty($errors)) {
   		//display errors
   		$display = display_errors($errors); ?>
        <script type="text/javascript">
        	$('document').ready(function(){
        		$('#errors').html('<?=$display; ?>');
        	});
        </script>
   	<?php }else{
      //update database
   		$updatesql = "insert into categories (category,parent) values ('$category','$post_parent')";
      if (isset($_GET['edit'])) {
        $updatesql = "update categories set category = '$category', parent = '$post_parent' where id='$edit_id'";
      }
   		$db->query($updatesql);
   		header('Location:categories.php');
   	}
   }

   	//updating or editing the category
   	$category_value = '';
   	$parent_value = 0;
   	if (isset($_GET['edit'])) {
   		$category_value = $Ecategory['category'];
      $parent_value = $Ecategory['parent'];
   	}else{
   		if (isset($_POST)) {
   			$category_value = $category;
   			$parent_value = $post_parent;
   		}
   	}
   ?>

<h2 class="text-center">Categories</h2><hr>
   <div class="row">
   <!--Form-->
   	<div class="col-md-6">
   		<form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" method="POST">
   		<legend><?=((isset($_GET['edit']))?'Edit ':'Add A '); ?>Category</legend>
   		<div id="errors"></div>
   			<div class="form-group">
   				<label for="parent">Parent</label>
   				<select class="form-control" name="parent" id="parent">
   					<option value="0"<?=(($parent_value == 0)?' selected="selected"':''); ?>>Parent</option>
   					<?php while($parent = mysqli_fetch_assoc($result)): ?>
   						<option value="<?=$parent['id'];?>"<?=(($parent_value == $parent['id'])?' selected="selected"':''); ?>><?=$parent['category']; ?></option>
   					<?php endwhile; ?>

   				</select>
   			</div>
   			<div class="form-group">
   				<label for="category">Category</label>
   				<input type="text" name="category" id="category" class="form-control" value="<?=$category_value; ?>" />

   			</div>
   			<div class="form-group">
   				<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?> category" class="btn btn-success"/>
   				<?php if(isset($_GET['edit'])): ?>
         <a href="categories.php" class="btn btn-default">Cancel</a>
      <?php endif; ?>
   			</div>
   		</form>
   	</div>
   <!--Category table-->
   	<div class="col-md-6">
   		<table class="table table-bordered">
   			<thead>
   				<th>Category</th><th>Parent</th>
   			</thead>
   			<tbody>
   			<?php
   			$sql = "select * from Categories where parent = 0";
            $result =$db->query($sql);


   			 while ($parent = mysqli_fetch_assoc($result)):
                $parent_id = (int)$parent['id'];
                $sql0 = "select * from categories where parent = '$parent_id'";
                $cresult = $db->query($sql0);
   	        ?>
   				<tr class="bg-primary">
   					<td><?=$parent['category']; ?></td>
   					<td>Parent</td>
   					<td>
   						<a href="Categories.php?edit=<?=$parent['id'];?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
   						<a href="Categories.php?delete=<?=$parent['id'];?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
   					</td>
   				</tr>
   				<?php while ($child = mysqli_fetch_assoc($cresult)):?>
   				<tr class="bg-info">
   					<td><?=$child['category']; ?></td>
   					<td><?=$parent['category'];?></td>
   					<td>
   						<a href="Categories.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
   						<a href="Categories.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
   					</td>
   				</tr>
   				<?php endwhile;?>
   			<?php endwhile; ?>
   			</tbody>
   		</table>
   	</div>
   </div>

   <?php
   include 'includes/footer.php';
   ?>
