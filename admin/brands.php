<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce website/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
  //header('Location: login.php');
  }
   include 'includes/head.php';
   include 'includes/navigation.php';
   //get brands from database
   $sql= "select * from brand order by brand";
   $result = $db->query($sql);

   $errors = array();
//edit brands
   if(isset($_GET['edit']) && !empty($_GET['edit'])) {
     $edit_id = (int)$_GET['edit'];
     $edit_id = sanitize($edit_id);
   //  echo $edit_id;
     $sql = "select * from brand where id='$edit_id'";
     $edit_result=$db->query($sql);
     $eBrand = mysqli_fetch_assoc($edit_result);
   }

   //DELETE Brands
   if(isset($_GET['delete'])&&!empty($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
//    echo "The entered brand id ".$delete_id;
    $sql = "delete from brand where id='$delete_id'";
    $db->query($sql);
    header('Location:brands.php');
   }
   //submit brands
   if(isset($_POST['add_submit']))
   {
   if($_POST['brand']=='')
   {
   	$errors[].= 'You must enter a brand';
   }
   $brand = sanitize($_POST['brand']);

   $sql = "select * from brand where brand= '$brand'";
   if(isset($_GET['edit'])) {
    $sql = "select * from brand where brand= '$brand' and id!='$edit_id'";
   }
   $result = $db->query($sql);
   $count = mysqli_num_rows($result);
   if($count > 0){
   	$errors[] .= $brand. ' already exists. Please choose another name';
   }
   //display errors
   if(!empty($errors)){
   	echo display_errors($errors);

   }else{
    $sql = "insert into brand (brand) values ('$brand')";
    if(isset($_GET['edit'])){
      $sql = "update brand set brand = '$brand' where id = '$edit_id'";
    }
    $db->query($sql);
    header('Location: brands.php');
   }
}
?>
<h2 class="text-center">Brands</h2><hr>
<div>
	<form action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" method="POST" class="form-inline">
    <div class="form-control">


     <?php
     $brand_value= '';
      if(isset($_GET['edit'])) {
        $brand_value = $eBrand['brand'];
      }else{
        if(isset($_POST['brand'])) {
          $brand_value = sanitize($_POST['brand']);
        }
      }
     ?>
			<label for="brand"><?=((isset($_GET['edit']))?'Edit':'Add a'); ?> brand</label>
			<input type="text" name="brand" style="height:10px;" id="brand" value="<?=$brand_value;?>">
			<input type="submit" name="add_submit" style="height:23px;" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?> Brand" class="btn btn-success btn-xs">
      <?php
         if(isset($_GET['edit'])):      ?>
         <a href="brands.php" style="height:23px;" class="btn btn-default btn-xs">Cancel</a>
      <?php endif; ?>
      </div>
	</form>
</div><br><br><br>
<table class="table table-bordered table-striped">
	<thead>
		<th></th><th>Brand</th><th></th>
	</thead>
	<tbody>
	<?php while( $brand=mysqli_fetch_assoc($result)): ?>
		<tr>
			<td><a href="brands.php?edit=<?= $brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
			<td><?= $brand['brand']; ?></td>
			<td><a href="brands.php?delete=<?= $brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
		</tr>
	<?php endwhile; ?>
	</tbody>
</table>
<?php
   include 'includes/footer.php';
?>
