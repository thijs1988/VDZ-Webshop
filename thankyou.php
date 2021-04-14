<?php
require_once 'core/init.php';
include 'mollie-api-php/vendor/autoload.php';
// Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
// Token is created using Stripe Checkout or Elements!
// Get the payment token ID submitted by the form:
//get the rest of post data
if(isset($_GET['order_id']))
        {
            $orderId = $_GET['order_id'];
        }

  $full_name = $_SESSION['full_name'];
  $phone = $_SESSION['phone'];
  $email = $_SESSION['email'];
  $description = $_SESSION['description'];
  $street = $_SESSION['street'];
  $state = $_SESSION['state'];
  $city = $_SESSION['city'];
  $zip_code = $_SESSION['zip_code'];
  $grand_total = $_SESSION['grand_total'];
  $country = $_SESSION['country'];
  $tax = $_SESSION['tax'];
  $sub_total = $_SESSION['sub_total'];
  $cart_id = $_SESSION['cart_id'];
  $payment_id = $_SESSION['payment_id'];

try{
  require "mollie-api-php/examples/initialize.php";

  $protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
  $hostname = $_SERVER['HTTP_HOST'];
  $path = dirname(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']);

  $payment = $mollie->payments->get($payment_id);

  if ($payment->isPaid())
  {
//adjust inventory
$itemQ = $db->query("SELECT * from cart where id = '{$cart_id}'");
$iresults = mysqli_fetch_assoc($itemQ);
$items = json_decode($iresults['items'], true);
foreach ($items as $item) {
  $newSizes = array();
  $item_id = $item['id'];
  $productQ = $db->query("SELECT sizes from products WHERE id = '{$item_id}'");
  $product = mysqli_fetch_assoc($productQ);
  $sizes = sizesToArray($product['sizes']);
  foreach ($sizes as $size) {
    if ($size['size'] == $item['size']){
      $q = $size['quantity'] - $item['quantity'];
      $newSizes[] = array('size' => $size['size'], 'quantity' => $q, 'threshold' => $size['threshold']);

    }else{
      $newSizes[] = array('size' => $size['size'], 'quantity' => $size['quantity'], 'threshold' => $size['threshold']);
    }
    // code...
  }
  $sizeString = sizesToString($newSizes);
  $db->query("UPDATE products set sizes = '{$sizeString}' where id= '{$item_id}'");
}

foreach((array) $items as $item) {
  $product_id = $item['id'];
  $productQ = $db->query("select * from products where id = '{$product_id}'");
  $product = mysqli_fetch_assoc($productQ);
  $table = '<table class="table table-bordered" rules="all" style="border-color: black;">
  <thead>
  <th>Items</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub Total</th>
  </thead>
  <tbody>
  <tr>
  <td>'. $product['title'] .'</td>
  <td>'. money($product['price']) .'</td>
  <td>'. $item['quantity'] .'</td>
  <td>'. $item['size'] .'</td>
  <td>'. money($item['quantity'] * $product['price']) .'</td>
  </tr>
  </tbody>
  </table>';
}

$to = "thijsdw1@gmail.com"; // this is your Email address
$from = $email; // this is the sender's Email address
$subject = "Webshop bestelling van $full_name";
$subject2 = "Orderbevestiging van uw bestelling";
$message = $full_name. " heeft de volgende bestelling geplaatst: " . "<br><br>" . $table . "<br><br>" . "Voor een totaalbedrag van: " . money($grand_total) . "<br>" . "Naam klant: " . $full_name . "<br>" . "Telefoonnummer: " . $phone . "<br>" . "Email: " . $email .
"<br>" . "Straat: " . $street . "<br>" . "Postcode: " . $zip_code . "<br>" . "Plaats: " . $city;
$message2 = "Hier volgt de orderbevestiging betreffende de bestelling van de volgende artikelen. " . "<br><br>" . $table . "<br>" . "Voor een totaalbedrag van: " . money($grand_total) . "<br><br>" .
 "Uw ordernummer is: " . $cart_id . "<br><br>" . "De bestelling wordt zo spoedig mogelijk verzonden naar het volgende adres: " . "<br>" . $full_name . "<br>" . $street .
"<br>" . $zip_code . ", " . $city . "<br><br>" . "Mocht er iets mis zijn met uw bestelling dat kunt u contact opnemen met onze klantenservice." . "<br>" . "Met Vriendelijke Groet, " . "<br><br>" . "Walther Dingemans" .
"<br>" . "Jo van Ammerstraat 3" . "<br>" . "5122 CK, Rijen" . "<br>" . "06-23238247" . "<br>" . "info@vdzprojecten.nl";

// To send HTML mail, the Content-type header must be set
// To send HTML mail, the Content-type header must be set
$headers = "From:" . $from . "\r\n";
$headers2 = "From:" . $to . "\r\n";
$headers  .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers2  .= 'MIME-Version: 1.0' . "\r\n";
$headers2 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

mail($to,$subject,$message,$headers);
mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
// You can also use header('Location: thank_you.php'); to redirect to another page.
// You cannot use header and echo together. It's one or the other.

//update cart
  $db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
  $db->query("INSERT INTO transactions
    (order_id,cart_id,full_name,email,street,city,state,zip_code,country,sub_total,tax,grand_total,description)
    VALUES ('$orderId','$cart_id','$full_name','$email','$street','$city','$state','$zip_code','$country','$sub_total','$tax','$grand_total','$description')");

  $domain = ($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST']:false;
  setcookie(CART_COOKIE,'',1,"/",false);


  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';


  ?>
<h1 class="text-center text-success">Bedankt voor uw bestelling!</h1>
  <P>De overboeking van <?=money($grand_total); ?> is voldaan. Een kopie van de orderbevestiging kunt u vinden in uw mailbox, controleer uw spam folder als hij zich niet in uw inbox bevindt. Anders kunt u een screenshot maken van dit scherm als bevestiging.</p>
    <p>Your receipt number is: <strong><?=$cart_id;?></strong></p>
    <p>Your order will be delivered to the address below.</p>
    <address>
      <?=$full_name?><br>
      <?=$street?><br>
      <?=$city. ', '.$state. ' '.$zip_code;?><br>
      <?=$country;?><br>
    </address>
<?php
session_destroy();
} elseif ($payment->isOpen()) {
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  session_destroy();
  echo '<span style="color:#FF0000;text-align:center;"><h3>The payment is open!</h3></span>';
    /*
     * The payment is open.
     */
} elseif ($payment->isPending()) {
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  session_destroy();
  echo '<span style="color:#FF0000;text-align:center;"><h3>The payment is pending!</h3></span>';
    /*
     * The payment is pending.
     */
} elseif ($payment->isFailed()) {
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  session_destroy();
  echo '<span style="color:#FF0000;text-align:center;"><h3>The payment has failed!</h3></span>';
  /*
     * The payment has failed.
     */
} elseif ($payment->isExpired()) {
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  session_destroy();
  echo '<span style="color:#FF0000;text-align:center;"><h3>The payment is expired!</h3></span>';
    /*
     * The payment is expired.
     */
} elseif ($payment->isCanceled()) {
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  session_destroy();
  echo '<span style="color:#FF0000;text-align:center;"><h3>The payment has been canceled!</h3></span>';
    /*
     * The payment has been canceled.
     */
} elseif ($payment->hasRefunds()) {
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  session_destroy();
  echo '<span style="color:#FF0000;text-align:center;"><h3>The payment has been (partially) refunded.
  The status of the payment is still "paid"!</h3></span>';
    /*
     * The payment has been (partially) refunded.
     * The status of the payment is still "paid"
     */
} elseif ($payment->hasChargebacks()) {
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  session_destroy();

  echo '<span style="color:#FF0000;text-align:center;"><h3>The payment has been (partially) charged back.
   The status of the payment is still "paid"!</h3></span>';
    /*
     * The payment has been (partially) charged back.
     * The status of the payment is still "paid"
     */
}

}catch (\Mollie\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . htmlspecialchars($e->getMessage());
}
 ?>



<?php include 'includes/footer.php';
?>
