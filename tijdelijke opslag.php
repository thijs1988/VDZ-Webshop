<?php


   $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
   $price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
   $min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
   $max_price = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');
   $b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
   $brandQ = $db->query("SELECT * from brand order by brand");
?>

  <div class="container" style="background-color:darkgrey;margin-left:-45px;width:125%;height:100vh;">
<h2 class="text-center" style="color:white;">SEARCH BY:</h2><hr>
<h4 class="text-center" style="color:white;">Price</h4>
<form action="search.php" method="post" style="color:white;margin-left:20px;">

<input type="hidden" name="cat" value="<?=$cat_id;?>">
<input type="hidden" name="price_sort" value="0">
	<input type="radio" name="price_sort" class="searchHLLH" style="color:white;"  value="low"<?=(($price_sort == 'low')?' checked':'');?>> Low to High<br>
	<input type="radio" name="price_sort" class="searchHLLH" value="high"<?=(($price_sort == 'high')?' checked':'');?>>  High to Low<br><br>
	<input type="text" name="min_price" class="price-range"  placeholder="Min" value="<?=$min_price;?>">To
	<input type="text" name="max_price" class="price-range" placeholder="Max" value="<?=$max_price;?>"><hr>
	<h4 class="text-center" style="color:white;">Brand</h4>
	<input type="radio" name="brand" class="searchHLLH" style="color:white;" value=""<?=(($b == '')?' checked':'');?>>  All<br>
	<?php while($brand = mysqli_fetch_assoc($brandQ)): ?>
		<input type="radio" name="brand" class="searchHLLH" style="color:white;" value="<?=$brand['id'];?>"<?=(($b == $brand['id'])?' checked':'');?>><?php echo "  ".$brand['brand'];?><br>
	<?php endwhile; ?>
  <br>
  <button type="submit" name="search" value="Search" style="background-color:white;color:black" class="btn btn-dark btn-small">Search</button>
</form>
</div>


if ($emailErr = ""){
$voornaam = $_POST['voornaam'];
$achternaam = $_POST['achternaam'];
$voornaam_klant = $_POST['voornaam_klant'];
$achternaam_klant = $_POST['achternaam_klant'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$adres = $_POST['adres'];
$postcode = $_POST['postcode'];
$plaats = $_POST['plaats'];
$leverdata = $_POST['leverdata'];
$opmerkingen = $_POST['opmerkingen'];
$bedrijfsnaam = $_POST['bedrijfsnaam'];

echo "het is gelukt";
}
