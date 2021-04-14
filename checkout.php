<?php
require_once 'core/init.php';
require "mollie-api-php/examples/initialize.php";
$grand_total = sanitize($_POST['grand_total']);
 /*
  * How to prepare an iDEAL payment with the Mollie API.
  */
 try {
   $mollie = new \Mollie\Api\MollieApiClient();
   $mollie->setApiKey("test_mv2225pJvFCuTVrB8MQrRyjx37D59g");

      if ($_SERVER["REQUEST_METHOD"] != "POST") {
          $method = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);

          echo '<div class="form-group col-md-6">Select your bank: <select name="issuer">';

          foreach ($method->issuers() as $issuer) {
              echo '<option value=' . htmlspecialchars($issuer->id) . '>' . htmlspecialchars($issuer->name) . '</option>';
          }

          echo '<option value="">or select later</option>';
          echo '</select><button>OK</button></div>';
          exit;
      }

     $orderId = time();

     /*
      * Determine the url parts to these example files.
      */
     $grand_total = number_format($grand_total, 2);
     $protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
     $hostname = $_SERVER['HTTP_HOST'];
     $path = dirname(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']);
     /*
      * Payment parameters:
      *   amount        Amount in EUROs. This example creates a € 27.50 payment.
      *   method        Payment method "ideal".
      *   description   Description of the payment.
      *   redirectUrl   Redirect location. The customer will be redirected there after the payment.
      *   webhookUrl    Webhook location, used to report when the payment changes state.
      *   metadata      Custom metadata that is stored with the payment.
      *   issuer        The customer's bank. If empty the customer can select it later.
      */
     $payment = $mollie->payments->create([
         "amount" => [
             "currency" => "EUR",
             "value" => "$grand_total" // You must send the correct number of decimals, thus we enforce the use of strings
         ],
         "method" => \Mollie\Api\Types\PaymentMethod::IDEAL,
         "description" => "{$orderId}",
         "redirectUrl" => "https://shaggy-insect-48.loca.lt/ecommerce%20website/thankyou.php?order_id={$orderId}",
         "webhookUrl" => "https://shaggy-insect-48.loca.lt/ecommerce%20website/webhook.php",
         "metadata" => [
            "payment_id" => $payment->id,
             "order_id" => $orderId,
             "cart_id" => $cart_id,
         ],
         "issuer" => !empty($_POST["issuer"]) ? $_POST["issuer"] : null
     ]);
     /*
      * In this example we store the order with its payment status in a database.
      */
     database_write($orderId, $payment->status);

     $full_name = sanitize($_POST['full_name']);
     $email = sanitize($_POST['email']);
     $phone = sanitize($_POST['phone']);
     $street = sanitize($_POST['street']);
     $city = sanitize($_POST['city']);
     $state = sanitize($_POST['state']);
     $zip_code = sanitize($_POST['zip_code']);
     $country = sanitize($_POST['country']);
     $tax = sanitize($_POST['tax']);
     $sub_total = sanitize($_POST['sub_total']);
     $cart_id = sanitize($_POST['cart_id']);
     $description = sanitize($_POST['description']);

     session_destroy();
     session_start();
       $_SESSION['payment_id'] = $payment->id;
       $orderId = $_SESSION['order_id'];
       $_SESSION['full_name'] = $full_name;
       $_SESSION['phone'] = $phone;
       $_SESSION['email'] = $email;
       $_SESSION['description'] = $description;
       $_SESSION['street'] = $street;
       $_SESSION['state'] = $state;
       $_SESSION['city'] = $city;
       $_SESSION['zip_code'] = $zip_code;
       $_SESSION['grand_total'] = $grand_total;
       $_SESSION['country'] = $country;
       $_SESSION['tax'] = $tax;
       $_SESSION['sub_total'] = $sub_total;
       $_SESSION['cart_id'] = $cart_id;

     /*
      * Send the customer off to complete the payment.
      * This request should always be a GET, thus we enforce 303 http response code
      */
     header("Location: " . $payment->getCheckoutUrl(), true, 303);die;
 } catch (\Mollie\Api\Exceptions\ApiException $e) {
     echo "API call failed: " . htmlspecialchars($e->getMessage());
 }




 ?>
