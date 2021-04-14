<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecommerce website/core/init.php';
if (!is_logged_in()) {
    login_error_redirect();
   }

   include 'includes/head.php';
   include 'includes/navigation.php';

   $hashed = $user_data['password'];
   $old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
   $old_password = rtrim($old_password);
   $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
   $password = rtrim($password);
   $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
   $confirm = rtrim($confirm);
   $new_hashed =password_hash($password, PASSWORD_DEFAULT);
   $user_id = $user_data['id'];


   $errors = array();
?>
<style type="text/css">
#logout-form{
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
<div id="logout-form">
  <div>
  	<?php
       if ($_POST) {
       	 //form validation
       	if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
       		$errors[] = 'You must provide email and password';
       	}

       	//validating password
       	if (strlen($password)<6) {
       		$errors[] = 'Password must be more than 6 characters';
       	}

       	//checking new password matches
        if ($password != $confirm) {
          $errors[] = 'The new password and the confirmed password do not match.';
        }

       	if (!password_verify($old_password, $hashed)) {
       		$errors[] = 'The password does not match our records. Please try again.';
       	}

       	//check for errors
       	if (!empty($errors)) {
       		echo display_errors($errors);
       	} else {
       		//change password
          $db->query("UPDATE users set password='$new_hashed' where id='$user_id'");
          $_SESSION['success_flash'] = 'Your password has been updated successfully.';
          header('Location: index.php');
       	}
       }
  	?>
  </div>
  <h2 class="text-center">Change Password</h2><hr>
	<form method="POST" action="change_password.php">
		<div class="form-group">
			<label for="old_password">Old Password:</label>
			<input type="password" name="old_password" class="form-control"  value="<?=$old_password; ?>" />
		</div>
			<div class="form-group">
			<label for="password">New Password:</label>
			<input type="password" name="password" class="form-control" value="<?=$password; ?>" />
		</div>
    <div class="form-group">
      <label for="confirm">Confirm New Password:</label>
      <input type="password" name="confirm" class="form-control" value="<?=$confirm; ?>" />
    </div>
		<div class="form-group">
			<input type="submit" name="change_password" class="btn btn-primary" value="Change password" />
      <a href="index.php" class="btn btn-default">Cancel</a>
		</div>
	</form>
	<p class="text-right"><a href="/ecommerce/index.php">Visit Site</a></p>
</div>
<?php include 'includes/footer.php'; ?>
