<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';

$queryResult = '';

 ?>


 <?php
   if (isset($_POST['submit-search'])) {
     $search = mysqli_real_escape_string($db, $_POST['search']);
     $sql = "SELECT * from products WHERE title Like '%$search%' OR description LIKE '%$search%' OR categories LIKE '%$search%'";
     $result = mysqli_query($db, $sql);
     $queryResult = mysqli_num_rows($result);
   }

   ?>


  <div class="head-search container" style="background-color:lightgrey;">
    <h2 class="text-center"><span class="text-muted">Er zijn <?php echo (isset($queryResult) && $queryResult != '')? $queryResult : 'geen';?> resultaten!</span></h2>
  </div><br><br>



 <div id="mainContainer" class="container">
   <div class="panel panel-default">

     <div class="panel-body">
       <div class="row">
         <?php
         if ($queryResult > 0) :
           while ($row = mysqli_fetch_assoc($result)): ?>
         <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">

           <div class="panel panel-default my_panel">


             <div class="panel-body">
               <?php $photos = explode(',', $row['image']); ?>
               <img src="<?= $photos[0]; ?>" alt="<?= $row['title']; ?>" class="img-responsive center-block panel-photo" />
             </div>
             <div class="panel-footer">
               <h4 class="h-settings"><strong><?= $row['title']; ?></strong></h4>
               <p type="text" class="p-settings"><?= $row['description'];?></p>
               <p>Prijs: <?= money($row['price']); ?></p>
               <a data-toggle="modal" onclick="detailsmodal(<?= $row['id']; ?>)" data-target="#details">Meer Informatie</a>
             </div>
           </div>
         </div>
           <?php endwhile; ?>
           <?php
            else :
             echo "Uw zoekopdracht heeft geen resultaten opgeleverd!";
           ?>
           <div class="white-space2"></div>
           <?php endif;?>

       </div>
     </div>

   </div>

 </div>
 <br><br><br><br>

<?php include 'includes/footer.php';?>
