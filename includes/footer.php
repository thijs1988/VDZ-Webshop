</div>
<footer class="page-footer font-small pt-4" id="footer" style="background-color:black;"><br>

  <!-- Footer Links -->
  <div class="container text-center text-md-left">

    <!-- Footer links -->
    <div class="row text-center text-md-left mt-3 pb-3" >

      <!-- Grid column -->
      <div class="footer-col col-md-4 col-lg-3 col-xl-3 mt-3" style="color:white;text-align:left;"><br>
        <h5 class="text-uppercase mb-4 font-weight-bold">VDZ Projecten</h5>
        <hr class="accent-2 mb-4 mt-0 d-inline-block pull-left" style="width:60px;color:white;margin-top:-5px;"><br>
        <p>Bedankt voor het bezoeken van onze website! Hopelijk heeft u alles kunnen vinden wat u wilt,
           anders vindt u hier nog aanvullende informatie. </p>
      </div>
      <!-- Grid column -->



      <!-- Grid column -->
      <div class="footer-col col-md-4 col-lg-3 col-xl-3 mx-auto mt-3" style="color:white;text-align:left;"><br>
        <h5 class="text-uppercase mb-4 font-weight-bold">Producten & Diensten</h5>
        <hr class="accent-2 mb-4 mt-0 d-inline-block pull-left" style="width:60px;color:white;margin-top:-5px;"><br>
        <p>
          <a href="https://www.vdzprojecten.nl/duurzaamheidscheck/" style="color:white;">Duurzaamheidscheck</a>
        </p>
        <p>
          <a href="https://www.vdzprojecten.nl/ecologisch-bouwen/" style="color:white;">Ecologisch bouwen</a>
        </p>
        <p>
          <a href="https://www.vdzprojecten.nl/projecten/" style="color:white;">Projecten</a>
        </p>
        <p>
          <a href="https://www.vdzprojecten.nl/bouw-uw-eigen-woning/" style="color:white;">Bouw uw eigen woning</a>
        </p>
      </div>
      <!-- Grid column -->



      <!-- Grid column -->
      <div class="footer-col col-md-4 col-lg-3 col-xl-3 mx-auto mt-3" style="color:white;text-align:left;"><br>
        <h5 class="text-uppercase mb-4 font-weight-bold">relevante links</h5>
        <hr class="accent-2 mb-4 mt-0 d-inline-block pull-left" style="width:60px;color:white;margin-top:-5px;"><br>
        <p>
          <a href="https://www.vdzprojecten.nl/over-ons/" style="color:white;">Over ons</a>
        </p>
        <p>
          <a href="#!" style="color:white;">Levering</a>
        </p>
        <p>
          <a href="#!" style="color:white;">Bezorgkosten</a>
        </p>
      </div>

      <!-- Grid column -->


      <!-- Grid column -->
      <div class="footer-col col-md-4 col-lg-3 col-xl-3 mx-auto mt-3" style="color:white;text-align:left;"><br>
        <h5 class="text-uppercase mb-4 font-weight-bold">Contact</h5>
        <hr class="accent-2 mb-4 mt-0 d-inline-block pull-left" style="width:60px;color:white;margin-top:-5px;"><br>
        <p>
          <i class="fas fa-home mr-3"></i> Jo van Ammerstraat 3,<br>5122 CK Rijen</p>
        <p>
          <i class="fas fa-envelope mr-3"></i> info@vdzprojecten.nl</p>
        <p>
          <i class="fas fa-phone mr-3"></i> +31 6-23238247</p>
      </div>
      <!-- Grid column -->

    </div>
    <!-- Footer links -->

    <hr>

    <!-- Grid row -->
    <div class="row d-flex align-items-left">

      <!-- Grid column -->
      <div class="col-md-7 col-lg-8" style="color:white;text-align:left;">

        <!--Copyright-->
        <p class="text-center pull-left">© 2020 Copyright:
          <a href="http://www.vdzprojecten.nl" style="color:white;">
            <strong>www.vdzprojecten.nl</strong>
          </a>
        </p>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-5 col-lg-4 ml-lg-0">

        <!-- Social buttons -->
        <div class="text-center text-md-right" >
          <ul class="list-unstyled list-inline">
            <li class="list-inline-item">
              <a class="btn-floating btn-sm rgba-white-slight mx-1" href="https://www.facebook.com/VDZ-Projecten-795247634208176/" style="color:white;">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a class="btn-floating btn-sm rgba-white-slight mx-1" href="https://www.instagram.com/projectenvdz/" style="color:white;">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </li>
          </ul>
        </div>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

</footer>
<!-- Footer -->


<script>
  jQuery(window).scroll(function(){
    var vscroll = jQuery(this).scrollTop();
    console.log(vscroll);
    jQuery('#logotext').css({
      "transform" : "translate(0px, "+vscroll/2+"px)"
    });
  });

function detailsmodal(id){
  var data = {"id" : id};
  jQuery.ajax({
    url : '/ecommerce website/includes/detailsmodal.php',
    method : "post",
    data : data,
    success: function(data){
      jQuery('body').append(data);
      jQuery('#details-modal').modal('toggle');
    },
    error: function(){
      alert("Something went wrong!");
    }
  });
}

function update_cart(mode,edit_id,edit_size){ //extra pains
   var data = {"mode": mode, "edit_id" : edit_id, "edit_size" : edit_size};
   $.ajax({
      url : '/ecommerce website/admin/parsers/update_cart.php',
      method : "post",
      data : data,
      success : function(){
         location.reload();
      },
      error : function(){alert("Something went wrong")},
   });
}

function add_to_cart(){
  jQuery('#modal_errors').html("");
  var size = jQuery('#size').val();
  var quantity = jQuery('#quantity').val();
  var available = jQuery('#available').val();
  console.log(available);
  var error = '';
  var data = jQuery('#add_product_form').serialize();
  if(size == '' || quantity == '' || quantity == 0){
    error += '<p class="text-danger text-center">You must choose a size and quantity.</p>';
    jQuery('#modal_errors').html(error);
    return;
  }else if(quantity > available){
    error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
    jQuery('#modal_errors').html(error);
    return;
  }else{
    jQuery.ajax({
      url : '/ecommerce website/admin/parsers/add_cart.php',
      method : "post",
      data : data,
      success : function(){
        location.reload();
      },
      error : function(){alert("someting went wrong");}
    });
  }
}
</script>
</body>
</html>
