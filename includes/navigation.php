<!-- top nav bar -->

<?php
$sql = "SELECT * FROM categories WHERE parent = 0";
$pquery = $db->query($sql);
?>

<nav class="navbar navbar-default navbar-fixed-top" >
  <a class="navbar-image pull-left" href="index.php">
    <img class="imnav"  src="afbeeldingen/PastedGraphic-3.png">
  </a>
    <div class="con1 container">

    <ul class="nav navbar-nav">
      <li style="margin-right:-10px"><a href="laadpaal.php">Laadpaal Form</a></li>
      <?php while($parent = mysqli_fetch_assoc($pquery)) :
          $parent_id = $parent['id'];
          $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
          $cquery = $db->query($sql2); ?>
      <!-- Categorie 1 -->
      <li class="dropdown" style="margin-right:-10px">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category']?><span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <?php while($child = mysqli_fetch_assoc($cquery)) : ?>
            <li><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category']?></a></li>
          <?php endwhile; ?>
        </ul>
      </li>
      <?php endwhile; ?>
      <li style="margin-right:-10px"><a href="cart.php" ><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a></li>
    </ul>
  </div>
</nav>
