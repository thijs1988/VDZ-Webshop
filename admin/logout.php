<?php
   require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce website/core/init.php';
   unset($_SESSION['VDZUser']);
   header('Location: login.php');

?>
