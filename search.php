<?php
require_once 'core/init.php';
?>
<?php
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';

$sql = "SELECT * from products";
if (isset($_GET['cat'])) {
  $cat_id = sanitize($_GET['cat']);
}else {
  $cat_id = '';
}


if ($cat_id == '') {
  $sql .= ' WHERE deleted = 0';
} else {
  $sql .= " WHERE categories = '{$cat_id}' AND deleted = 0";
}
$price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
$min_price = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):'');
$max_price = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):'');
$brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):'');
if ($min_price != '') {
  $sql .= " AND price >= '{$min_price}'";
}
if ($max_price != '') {
  $sql .= " AND price <= '{$max_price}'";
}
if ($brand != '') {
  $sql .= " AND brand = '{$brand}'";
}
if ($price_sort == 'low') {
  $sql .= " ORDER BY price";
}
if ($price_sort == 'high') {
  $sql .= " ORDER BY price desc";
}

$categoryQ = $db->query($sql);
$category = get_category($cat_id);

?>

        <div class="container-fluid">

           <!--this is going to be main content showing products-->
        <div class="col-md-12">
          <?php if($cat_id != ''): ?>
            <div class="cat-header container-fluid" style="background-color:#74c87d;" >
            <h2 class="text-center text-uppercase" style="color:white;"><?=$category['parent'].' '. $category['child']; ?></h2>
            </div>
          <?php else: ?>
            <div class="cat-header container-fluid" style="background-color:#74c87d;" >
            <h2 class="text-center text-uppercase" style="color:white;">VDZ Webshop</h2>
            </div>
          <?php endif; ?>
        </div>

        <?php
        include 'includes/leftbar.php';
        ?>

        <div class="col-size col-md-8">
          <form action="searchbar.php" method="post">
            <p class="t1 text-center"><input class="input-search" type="text" name="search" placeholder="Zoeken">
            <button class="input-button btn" type="submit" name="submit-search">Zoeken</button></p>
          </form>

          <div class="article container">

          </div>

           <div id="mainContainer" class="container-fluid" style="margin-left:-5%; margin-top:1%; margin-right:-5%;">

             <div class="panel panel-default">
               <div class="panel-body">
                 <div class="row">

                   <?php while($products = mysqli_fetch_assoc($categoryQ)) : ?>
                   <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                     <div class="panel panel-default my_panel">
                       <div class="panel-body">
                         <?php $photos = explode(',', $products['image']); ?>
                         <img src="<?= $photos[0]; ?>" alt="<?= $products['title']; ?>" class="img-responsive center-block panel-photo" />
                       </div>
                       <div class="panel-footer">
                         <h4 class="h-settings fs"><strong><?= $products['title']; ?></strong></h4>
                         <p type="text" class="p-settings"><?= $products['description'];?></p>
                         <p>Prijs: <?= money($products['price']); ?></p>
                         <a data-toggle="modal" onclick="detailsmodal(<?= $products['id']; ?>)" data-target="#details">Meer Informatie</a>
                       </div>
                     </div>
                   </div>
                     <?php endwhile; ?>
                 </div>
               </div>
             </div>
           </div>
        </div>

           <?php
           include 'includes/rightbar.php';
           ?>
      </div>
      <?php
          include 'includes/footer.php';
      ?>
