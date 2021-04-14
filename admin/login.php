<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce website/core/init.php';
   include 'includes/head.php';
 //  include 'includes/navigation.php';




$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = rtrim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$hashed = password_hash($password,PASSWORD_DEFAULT);
$password = rtrim($password);
$errors = array();
?>
<style>
body{
  background-image:url("/ecommerce website/afbeeldingen/IMG_6763.jpg");
  background-size: 100vw 100vh;
  background-attatchment: fixed;
  }

  #login-form{
    width: 50%;
    height: 60%;
    border: 2px solid #000;
    border-radius: 15px;
    box-shadow: 7px 7px 15px rgba(0,0,0,0.6);
    margin: 8% auto;
    padding: 15px;
    background-color: white;
    }
</style>
<div id="login-form">
<div>
 <?php
    if ($_POST) {
      //form validation
     if (empty($_POST['email']) || empty($_POST['password'])) {
       $errors[] = 'You must provide email and password.';
     }

     //email validation
     if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
       $errors[] = 'You must enter a valid email.';
     }

     //validating password
     if (strlen($password)<6) {
       $errors[] = 'Password must be more than 6 characters.';
     }

     //checking email exits in database or not
     $usersquery = $db->query("select * from users where email='$email'");
     $users = mysqli_fetch_assoc($usersquery);
     $userscount = mysqli_num_rows($usersquery);
     if($userscount < 1) {
       $errors[] = 'The entered email does not exist in our database.';
     }
     if (!password_verify($password, $users['password'])) {
       $errors[] = 'The password doesnot match our records. Please try again.';
     }

     //check for errors
     if (!empty($errors)) {
       echo display_errors($errors);
     } else {
       //login user
       $user_id = $users['id'];
       login($user_id);
     }
    }
 ?>
</div>
<h2 class="text-center">Login</h2><hr>
<form method="POST" action="login.php">
 <div class="form-group">
   <label for="email">Email:</label>
   <input type="text" name="email" id="email" class="form-control col-md-6" width="50%"  value="<?=$email; ?>" />
 </div>
   <div class="form-group">
   <label for="password">Password:</label>
   <input type="password" name="password" id="password" class="form-control" value="<?=$password; ?>" />
 </div>
 <div class="form-group">
   <input type="submit" name="login" class="btn btn-primary" value="Log in" />
 </div>
</form>
<p class="text-right"><a href="/ecommerce website/index.php" alt="home">Visit Site</a></p>
</div>
<?php include 'includes/footer.php'; ?>
