<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
include 'mollie-api-php/vendor/autoload.php';
session_destroy();

if ($cart_id != '') {
   $cartQuery = $db->query("select * from cart where id = '{$cart_id}'");
   $result = mysqli_fetch_assoc($cartQuery);
   $items = json_decode($result['items'],true);
   $i = 1;
   $sub_total = 0;
   $item_count = 0;
 }

 ?>


 <div class="cart-phone col-md-12">
 	<div class="row">
 		<h2 class="text-center">Mijn Winkelwagentje</h2><hr>
 		<?php if ($cart_id == ''): ?>
               <div class="bg-danger">
               	<p class="text-center text-danger">
               		Je winkelwagentje is leeg!
               	</p>
                <div class="white-space"></div>
               </div>
 		<?php else: ?>
 		<table class="table table-bordered table-condensed table-striped">
 			<thead>
 				<th>#</th><th>Items</th><th>Prijs</th><th>Aantal</th><th>Maat</th><th>Sub Totaal</th>
 			</thead>
 			<tbody>
 				<?php foreach((array) $items as $item) {
 					$product_id = $item['id'];
 					$productQ = $db->query("select * from products where id = '{$product_id}'");
 					$product = mysqli_fetch_assoc($productQ);
 					$sArray = explode(',',$product['sizes']);
 					foreach ($sArray as $sizeString) {
 						$s = explode(':',$sizeString);
 						if ($s[0] == $item['size']) {
 							$available = $s[1];
 						}
 					}
 					?>
 					<tr>
 						<td><?=$i; ?></td>
 						<td><?=$product['title']; ?></td>
 						<td><?=money($product['price']); ?></td>
 						<td>
 						    <button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?=$product['id'];?>','<?=$item['size'];?>')">-</button>
 							<?=$item['quantity']; ?>
 							<?php if($item['quantity'] < $available): ?>
 							<button class="btn btn-xs btn-default" onclick="update_cart('addone','<?=$product['id'];?>','<?=$item['size'];?>')">+</button>
 						<?php else: ?>
 							<span class="text-danger">Max</span>
 						<?php endif; ?>
 						</td>
 						<td><?=$item['size']; ?></td>
 						<td><?=money($item['quantity'] * $product['price']); ?></td>
 					</tr>
 					<?php
 					$i++;
 					$item_count += $item['quantity'];
 					$sub_total += ($product['price'] * $item['quantity']);
 				}
 				$tax = TAXRATE * $sub_total;
 				$tax = number_format($tax,2);
 				$grand_total = $tax + $sub_total;
 				?>
 			</tbody>
 		</table>
 				<table class="table table-bordered table-condensed text-right">
 				<legend>Totalen</legend>
 					<thead class="totals-table-header">
 						<th>Totaal Items</th><th>Sub Totaal</th><th>Btw</th><th>Totaal</th>
 					</thead>
 					<tbody>
 						<tr>
 							<td><?=$item_count; ?></td>
 							<td><?=money($sub_total); ?></td>
 							<td><?=money($tax); ?></td>
 							<td class="bg-success"><?=money($grand_total); ?></td>
 						</tr>
 					</tbody>
 				</table>

 <!-- Check Out Button trigger modal -->
 <button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#checkoutModal">
  <span class="glyphicon glyphicon-shopping-cart"></span> Afrekenen >>
 </button>
<br><br>



 <!-- Modal -->
 <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="myModalLabel">Bezorgadres</h4>
       </div>
       <div class="modal-body">
         <div class="row">
         	<form action="checkout.php" id="payment-form" method="post">
         	<span class="bg-danger" id="payment-errors"></span>
           <input type="hidden" name="tax" value="<?=$tax;?>">
           <input type="hidden" name="sub_total" value="<?=$sub_total;?>">
           <input type="hidden" name="grand_total" value="<?=$grand_total;?>">
           <input type="hidden" name="cart_id" value="<?=$cart_id;?>">
           <input type="hidden" name="description" value="<?=$item_count.' Item'.(($item_count>1)?'s':'').' from VDZ shop.';?>">
         		<div id="step1" style="display: block;">
         			<div class="form-group col-md-6">
         				<label for="full_name">Naam:</label>
         				<input type="text" name="full_name" id="full_name" class="form-control">
         			</div>
         			<div class="form-group col-md-6">
         				<label for="email">Email:</label>
         				<input type="email" name="email" id="email" class="form-control">
         			</div>
         			<div class="form-group col-md-6">
         				<label for="phone">Telefoonnummer:</label>
         				<input type="text" name="phone" id="phone" class="form-control">
         			</div>
         			<div class="form-group col-md-6">
         				<label for="street">Adres:</label>
         				<input type="text" name="street" id="street" class="form-control" data-stripe="address_line1">
         			</div>
         			<div class="form-group col-md-6">
         				<label for="zip_code">Postcode:</label>
         				<input type="text" name="zip_code" id="zip_code" class="form-control" data-stripe="address_zip">
         			</div>
         			<div class="form-group col-md-6">
         				<label for="city">Plaats:</label>
         				<input type="text" name="city" id="city" class="form-control" data-stripe="address_city">
         			</div>
              <div class="form-group col-md-6">
         				<label for="state">Provincie:</label>
         				<input type="text" name="state" id="state" class="form-control" data-stripe="address_state">
         			</div>
              <div class="form-group col-md-6">
         				<label for="country">Land:</label>
         				<input type="text" name="country" id="country" class="form-control" data-stripe="address_country">
         			</div>

         		</div>
         		<div id="step2" style="display: none;">
                <h1 class="text-center"><?= money($grand_total)?></h1>
         		</div>

         </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
         <button type="button" class="btn btn-primary" onclick="check_address();" id="next_button">Volgende >></button>
         <button type="button" class="btn btn-primary" onclick="back_address();" id="back_button" style="display: none;"><< Terug</button>
         <button type="submit" class="btn btn-primary" id="check_out_button" style="display: none;">Afrekenen >></button>
         </form>
       </div>
     </div>
   </div>
 </div>

 	<?php endif; ?>
 	</div>
 </div>




 <script>

     function back_address() {
     	$('#payment-errors').html("");
 					$('#step1').css({display: "block"});
 					$('#step2').css({display:"none"});
 					$('#next_button').css({display: "inline-block"});
 					$('#back_button').css({display:"none"});
 					$('#check_out_button').css({display:"none"});
 					$('#myModalLabel').html("Bezorgadres");
     }

 	function check_address() {
 		var data = {
 			'full_name' : $('#full_name').val(),
 			'email' : $('#email').val(),
 			'phone' : $('#phone').val(),
 			'street' : $('#street').val(),
 			'zip_code' : $('#zip_code').val(),
 			'city' : $('#city').val(),
      'state' : $('#state').val(),
      'country' : $('#country').val(),
 		};

 		$.ajax({
 			url : '/ecommerce website/admin/parsers/check_address.php',
 			method : "post",
 			data : data,
 			success : function(data){
 				if (data != 'passed') {
 					$('#payment-errors').html(data);

 				}
 				if (data == 'passed') {
 					$('#payment-errors').html("");
 					$('#step1').css({display: "none"});
 					$('#step2').css({display:"block"});
 					$('#next_button').css({display: "none"});
 					$('#back_button').css({display:"inline-block"});
 					$('#check_out_button').css({display:"inline-block"});
 					$('#myModalLabel').html("Totaal");
 				}
 			},
 			error : function(){
         alert('Something went wrong');},
 		});
 	}




// Get payment form element
var form = document.getElementById('payment-form');

// Create a token when the form is submitted.
form.addEventListener('submit', function(e) {
  form.submit('payment-form');
});

// Create single-use token to charge the user



</script>


 <?php include 'includes/footer.php'; ?>
