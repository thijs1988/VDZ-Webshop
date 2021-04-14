<?php
   require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce website/core/init.php';
   $name = sanitize($_POST['full_name']);
   $email = sanitize($_POST['email']);
   $phone = sanitize($_POST['phone']);
   $street = sanitize($_POST['street']);
   $zip_code = sanitize($_POST['zip_code']);
   $city = sanitize($_POST['city']);
   $provincie = sanitize($_POST['state']);
   $country = sanitize($_POST['country']);
   $errors = array();
   $required = array(
   	'full_name' => 'Naam',
   	'email'     => 'Email',
   	'phone'     => 'Telefoonnummer',
   	'street'    => 'Adres',
   	'zip_code'  => 'Postcode',
   	'city'      => 'Plaats',
    'state'     => 'Provincie',
    'country'   => 'Land',
   );

   //check if all required fields are filled validation and
   foreach ($required as $f => $d) {
   	if (empty($_POST[$f]) || $_POST[$f] == '' ) {
   		$errors[] = $d.' is required.';
   	}
   }

   ///email varification
   if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
   	$errors[] = 'Please enter a valid email address';
   }

   if (!empty($errors)) {
   	echo display_errors($errors);
   } else {
   	echo 'passed';
   }
?>
