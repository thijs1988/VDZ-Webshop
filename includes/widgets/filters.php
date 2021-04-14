<?php


   $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
   $price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
   $min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
   $max_price = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');
   $b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
   $brandQ = $db->query("SELECT * from brand order by brand");
?>

<div class="con-filter container col-md-2 no-float" style="background-color:darkgrey;">


<form action="search.php" method="post" class="form-filters" style="color:white;">
<hr><h4 class="text-center" style="color:white;">Prijs</h4>
<input type="hidden" name="cat" value="<?=$cat_id;?>">
<input type="hidden" name="price_sort" value="0">

  <input type="checkbox" name="price_sort" class="searchHLLH" style="color:white;"  value="low"<?=(($price_sort == 'low')?' checked':'');?>> Laag naar Hoog<br class="br">
  <input type="checkbox" name="price_sort" class="searchHLLH" value="high"<?=(($price_sort == 'high')?' checked':'');?>>  Hoog naar Laag<br><br>
	<input type="text" name="min_price" class="price-range"  placeholder="Min" value="<?=$min_price;?>">Tot
	<input type="text" name="max_price" class="price-range" placeholder="Max" value="<?=$max_price;?>"><hr>
	<h4 class="text-center" style="color:white;">Soort</h4>
	<input type="checkbox" name="brand" class="searchHLLH" style="color:white;" value=""<?=(($b == '')?' checked':'');?>>  All<br class="br">
	<?php while($brand = mysqli_fetch_assoc($brandQ)): ?>
		<input type="checkbox" name="brand" class="searchHLLH" style="color:white;" value="<?=$brand['id'];?>"<?=(($b == $brand['id'])?' checked':'');?>><?php echo "  ".$brand['brand'];?><br class="br">
	<?php endwhile; ?>
  <br>
  <button type="submit" name="search" value="Search" style="background-color:white;color:black" class="btn btn-dark btn-small">Zoeken</button><hr>
</form>
</div>
