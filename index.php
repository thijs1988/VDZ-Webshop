
<?php
require_once 'core/init.php';
?>
<?php
include 'includes/head.php';
include 'includes/navigation.php';


$sql = "SELECT * FROM products WhERE featured = 1";
$featured = $db->query($sql);
?>


<section id="main">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="afbeeldingen/IMG_6725.jpg" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1 class="h1 text-right title-color" >Doe de duurzaamheidscheck!</h1>
              <p class="text1 text-right lead">Bent u van plan aanpassingen aan uw woning te gaan maken, of bent u benieuwd naar de status van uw woning doe dan de duurzaamheidscheck.</p>
              <p class="text-right"><a class="btn btn-color slide-btn btn-lg" href="https://www.vdzprojecten.nl/duurzaamheidscheck/" role="button">Meer informatie!</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="second-slide" src="afbeeldingen/IMG_6718.jpg" alt="Second slide">
          <div class="container">
            <div class="carousel-caption d-none d-sm-block md-5">
              <h1 class="h1 title-color">Wilt u ecologisch gaan bouwen?</h1>
              <p class="text1 lead">Wij kunnen u helpen met deskundig advies en/of maken uw wensen realiteit.</p>
              <p><a class="btn btn-color slide-btn btn-lg" href="https://www.vdzprojecten.nl/ecologisch-bouwen/" role="button">Meer informatie!</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="third-slide" src="afbeeldingen/IMG_6763.jpg" alt="Third slide">
          <div class="container">
            <div class="carousel-caption d-none d-sm-block md-5">
              <h1 class="h1 text-left title-color">Duurzaam advies op maat</h1>
              <p class="text1 text-left lead">Kom in contact met een specialist.</p>
              <p class="text-left"><a class="btn btn-color slide-btn btn-lg" href="https://www.vdzprojecten.nl/contact/" role="button">Contact</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
</section>



<section class="services py-5 text-center">
<div class="container marketing">
     <!-- Three columns of text below the carousel -->
     <div class="row">
       <div class="icons-index col-10 mx-auto col-md-6 col-lg-4 my-3">
         <span class="service-icon">
           <i class="fas fa-medal"></i>
        </span>
         <h3 class="font-weight-bold text-uppercase">vakjury award</h3>
         <p>Winnaar van de "Vakjury Awards 2020" voor duurzaam bouwen. Award voor innovatief en duurzaam bouwen. </p>
         <p><a class="btn btn-default" href="https://vakwerk-awards.nl" role="button">Meer informatie &raquo;</a></p>
       </div><!-- /.col-lg-4 -->
       <div class="icons-index col-10 mx-auto col-md-6 col-lg-4 my-3">
         <span class="service-icon">
           <i class="fas fa-hammer"></i>
        </span>
         <h3 class="font-weight-bold text-uppercase">25 jaar ervaring</h3>
         <p>Met meer dan 25 jaar ervaring zijn wij de specialist in duurzaam bouwen waar u naar op zoek bent.</p>
         <p><a class="btn btn-default" href="https://vdzprojecten.nl" role="button">Meer informatie &raquo;</a></p>
       </div><!-- /.col-lg-4 -->
       <div class="icons-index col-10 mx-auto col-md-6 col-lg-4 my-3">
         <span class="service-icon">
           <i class="fas fa-file-signature"></i>
        </span>
         <h3 class="font-weight-bold text-uppercase">Garantie</h3>
         <p>Niet goed geld terug garantie en 10 jaar garantie op producten.</p>
         <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div><!-- /.col-lg-4 -->
     </div><!-- /.row -->
   </div>
</section>
<br>
<br>

<hr class="featurette-divider">

      <div class="row featurette">
        <div class="c1 col-md-6">
          <div class="j1 jumbotron">
          <h2 class="f1 featurette-heading" >Nu ook leverancier van laadpalen. <span class="text-muted">Inclusief aansluiting en technische ondersteuning</span></h2>
          <p class="l1 lead" >Wij doen alles om maatschapppelijk verantwoord te ondernemen. In samenwerking met Van de Bron zijn wij nu in staat laadpalen van hoogwaardige
            kwaliteit te leveren, installeren en ondersteunen. Heeft u vragen, of wilt u advies op maat? Neem dan gerust <a href="https://www.vdzprojecten.nl/contact/" class="contact">contact</a> met ons op...
            <a href="afbeeldingen/Laadpaal VDZ Projecten Brochure.pdf">Meer informatie...</a></p>
        </div>
      </div>
        <div class="col-md-5">
          <img class="i1 featurette-image img-responsive" src="afbeeldingen/vd-bron.jpeg">
        </div>
      </div>
      <br>
      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 col-md-push-5"> <br><br><br>
          <div class="j2 jumbotron" >
          <h2 class="f2 featurette-heading" >Vakwerk Awards, <span class="text-muted">Innovatief en Duurzaam bouwen.</span></h2>
          <p class="l2 lead" >Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.
          <a href="https://vakwerk-awards.nl">Meer informatie...</a> of bekijk de
          <a href="https://www.youtube.com/watch?time_continue=73&v=U0fNQBa8oV4&feature=emb_logo" class="prijs">prijsuitreiking!</a></p>
        </div>
      </div>
        <div class="col-md-5 col-md-pull-7" >
          <video class="p1" poster="afbeeldingen/vakwerk2.jpg" controls>
            <source class="v1" src="afbeeldingen/Walther dingemans.mp4" type="video/mp4">
                  Your browser does not support the video tag.
            </video>
        </div>
      </div>

      <hr class="featurette-divider">
      <br><br>
      <div class="row featurette">
        <div class="c3 col-md-6">
          <div class="j3 jumbotron" >
          <h2 class="f3 featurette-heading" >Specialist in alle facetten van het bouwen. <span class="text-muted">Supply, Construct and Support</span></h2>
          <p class="l3 lead" >Naast het leveren van materialen kunt u ook bij ons terecht voor de relealisatie van uw wensen. Denk hierbij aan volledige bouwprojecten of aanpassingen aan uw woning, ook helpen wij u graag met technische vragen en/of ondersteuning.
          <a href="https://www.vdzprojecten.nl/projecten/">Bekijk onze projecten</a> of kom in <a href="https://www.vdzprojecten.nl/contact/" class="contact">contact</a> met een specialist. </p>
        </div>
      </div>
        <div class="colimg3 col-md-6">
          <img class="i3 featurette-image img-responsive center-block" src="afbeeldingen/tiny-house.jpeg" alt="Generic placeholder image">
        </div>
      </div>

      <hr class="featurette-divider">



<div class="jumbotron">
      <div class="container">
        <h1 class="text-center"><span class="text-muted">Aanbevolen Producten</span></h1>
      </div>
    </div>



<div id="mainContainer" class="container">
  <div class="panel panel-default">

    <div class="panel-body">
      <div class="row">
        <?php while($products = mysqli_fetch_assoc($featured)) : ?>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">

          <div class="panel panel-default my_panel">


            <div class="panel-body">
              <?php $photos = explode(',', $products['image']); ?>
              <img src="<?= $photos[0]; ?>" alt="<?= $products['title']; ?>" class="img-responsive center-block panel-photo" />
            </div>
            <div class="panel-footer">
              <h4 class="h-settings"><strong><?= $products['title']; ?></strong></h4>
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


      <?php
          include 'includes/footer.php';
      ?>
