<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce website/core/init.php';
if (!is_logged_in()) {
  login_error_redirect();
  //header('Location: login.php');
  }
   include 'includes/head.php';
   include 'includes/navigation.php';


   //sql query to select everything from the product table get_child
   $sql = "select * from products where deleted = '1'";
   $p_result = $db->query($sql);

   //restore back
   if (isset($_GET['restore'])) {
   	$restore_id = (int)$_GET['restore'];
   	$db->query("update products set deleted = '0' where id='$restore_id'");
   	header('Location: deleted.php');
   }
?>

   <h2 class="text-center">Deleted Products</h2>

   <hr>
   <table class="table table-bordered table-condensed table-striped">
   	<thead>
   		<th></th><th>Product</th><th>Price</th><th>Category</th><th>Sold</th>
   	</thead>
   	<tbody>
   		<?php while($product=mysqli_fetch_assoc($p_result)):
   		//for the category in the table
   		 $childId = $product['categories'];
   		$catsql ="select * from categories where id='$childId'";
        $catresult = $db->query($catsql);
        $cat = mysqli_fetch_assoc($catresult);
        $parentId = $cat['parent'];
        $psql = "select * from categories where id='$parentId'";
        $presult = $db->query($psql);
        $parent = mysqli_fetch_assoc($presult);
        $category = $parent['category'].'-'.$cat['category'];
   		 ?>
   			<tr>
   				<td>
   					<a href="deleted.php?restore=<?=$product['id']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Restore back"><span class="glyphicon glyphicon-asterisk"></span></a>
   				</td>
   				<td><?=$product['title']; ?></td>
   				<td><?=money($product['price']); ?></td>
   				<td><?=$category; ?></td>

   				<td><?=$product['id']; ?></td>
   			</tr>
   		<?php endwhile; ?>
   	</tbody>
   </table>
<?php
   include 'includes/footer.php';
?>

<script type="text/javascript">
  $('document').ready(function(){
    get_child_options('<?=$category;?>');
  });
</script>
