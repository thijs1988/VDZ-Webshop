<?php
   require_once '../core/init.php';
   if (!is_logged_in()) {
	header('Location: login.php');
}
   include 'includes/head.php';
   include 'includes/navigation.php';

   if (isset($_GET['edit'])){
   $edit_id = sanitize((int)$_GET['edit']);
 }
   if(isset($_POST["cancel"]))
   {
   	header("Location: index.php");
   	return;
   }

   $contactErr = "";
   $naam_klantErr = "";
   $emailErr = "";
   $telErr = "";
   $postcodeErr = "";
   $plaatsErr = "";
   $adresErr = "";
   $leverdataErr = "";
   $formErr = "";
   $opmerkingenErr = "";

   if (isset($_POST['contactpersoon']) && isset($_POST['bedrijfsnaam']) && isset($_POST['naam_klant']) && isset($_POST['email']) && isset($_POST['tel'])
   && isset($_POST['adres']) && isset($_POST['postcode']) && isset($_POST['plaats']) && isset($_POST['leverdata']) && isset($_POST['opmerkingen']) ) {


     if (empty($_POST['contactpersoon'])) {
       $contactErr = "Voornaam contactpersoon is een vereiste.";
     } elseif (!preg_match("/^[a-zA-Z-' ]*$/",$_POST['contactpersoon'])) {
     $contactErr = "Alleen letters en spaties worden geregistreerd.";
     }else{
       $contactpersoon = $_POST['contactpersoon'];
     }


     if (empty($_POST['naam_klant'])) {
       $naam_klantErr = "Voornaam klant is een vereiste.";
     }
     elseif (!preg_match("/^[a-zA-Z-' ]*$/",$_POST['naam_klant'])) {
     $naam_klantErr = "Alleen letters en spaties worden geregistreerd.";
     }else{
       $naam_klant = $_POST['naam_klant'];
     }

     if (empty($_POST['email'])) {
       $emailErr = "Email is een vereiste.";
     }
       elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
       $emailErr = "Email is onjuist.";
     }else {
       $email = $_POST['email'];
     }

     if (empty($_POST['tel'])) {
       $telErr = "Telefoonnummer is een vereiste.";
     }
     elseif (preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $_POST['tel'])){
           $telErr = "U heeft een onjuist telefoonnummer opgegeven, het nummer mag alleen uit cijfers bestaan.";
         }else {
           $tel = $_POST['tel'];
         }

     if (empty($_POST['adres'])) {
       $adresErr = "Adres is een vereiste.";
     }else {
       $adres = $_POST['adres'];
     }
     if (empty($_POST['postcode'])) {
       $postcodeErr = "Postcode is een vereiste.";
     }
     elseif (strlen($_POST['postcode']) >7){
       $postcodeErr = "Postcode is onjuist.";
     }else {
       $postcode = htmlentities($_POST['postcode']);
     }
     if (empty($_POST['plaats'])) {
       $plaatsErr = "Plaats is een vereiste.";
     }else {
       $plaats = $_POST['plaats'];
     }
     if (empty($_POST['leverdata'])) {
       $leverdataErr = "Leverdata is een vereiste.";
     }elseif (strlen($_POST['leverdata']) >10) {
       $leverdataErr = "Leverdata is onjuist, mag niet meer dan 10 tekens bevatten. ";
     }
     else {
       $leverdata = $_POST['leverdata'];
     }
     if (strlen($_POST['opmerkingen']) >500){
       $opmerkingenErr = "Opmerkingen mogen niet meer dan 500 tekens bevatten.";
     } else {
       $opmerkingen = $_POST['opmerkingen'];
     }

     $bedrijfsnaam = $_POST['bedrijfsnaam'];

     if (empty($contactErr) && empty($naam_klantErr) && empty($emailErr) && empty($telErr) && empty($postcodeErr)
     && empty($plaatsErr) && empty($adresErr) && empty($leverdataErr) && empty($formErr) && empty($opmerkingenErr)){


       $sql = "UPDATE laadpalen SET contactpersoon = '$contactpersoon', bedrijfsnaam = '$bedrijfsnaam', naam = '$naam_klant', email = '$email', telefoon = '$tel',
       adres = '$adres', postcode = '$postcode', plaats = '$plaats', leverdata = '$leverdata', opmerkingen = '$opmerkingen' WHERE id = '$edit_id'";
       if (mysqli_query($db, $sql)) {
           header('location:index.php');
           return;
         } else {
           echo "Error: " . $sql . "<br>" . mysqli_error($db);
         }


     }else{
       $formErr = "vul alle data op de juiste manier in aub.";
     }
   }
?>

<?php
if (isset($_GET['delete'])){
  $delete_id=sanitize((int)$_GET['delete']);
  $lpQuery = "SELECT * FROM laadpalen where id = '{$delete_id}'";
  $lpResults = $db->query($lpQuery);
}
if (isset($_GET['lp_id'])){
  $lp_id = sanitize((int)$_GET['lp_id']);
  $lpQuery = "SELECT * FROM laadpalen where id = '{$lp_id}'";
  $lpResults = $db->query($lpQuery);
}
if (isset($_GET['edit'])){
  $edit_id = sanitize((int)$_GET['edit']);
  $lpQuery = "SELECT * FROM laadpalen where id = '{$edit_id}'";
  $lpResults = $db->query($lpQuery);
}

?>
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Laadpaal Orders</h3>
		<table class="table table-condensed table-bordered table-striped">
			<thead>
				<th>Contactpersoon</th><th>Bedrijfsnaam</th><th>Naam</th><th>Email</th><th>Telefoonnummer</th><th>Adres</th><th>Leverdatum auto</th><th>Opmerkingen</th>
			</thead>
			<tbody>
			<?php while($lpOrder = mysqli_fetch_assoc($lpResults)): ?>
				<tr>
					<td><?=$lpOrder['contactpersoon']; ?></td>
					<td><?=$lpOrder['bedrijfsnaam']; ?></td>
          <td><?=$lpOrder['naam'];?></td>
          <td><?=$lpOrder['email'];?></td>
          <td><?=$lpOrder['telefoon'];?></td>
					<td><?=$lpOrder['adres'].', '.$lpOrder['postcode'].', '.$lpOrder['plaats']; ?></td>
					<td><?=$lpOrder['leverdata']; ?></td>
					<td><?=$lpOrder['opmerkingen']; ?></td>
				</tr>
			<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>

<?php
if (isset($_GET['delete'])):
  $delete_id=sanitize((int)$_GET['delete']);
  $lpQuery = "SELECT * FROM laadpalen where id = '{$delete_id}'";
  $lpResults = $db->query($lpQuery);
?>
<form method="post">
  <div class="form-row">
    <label for="delete_lp">Are you sure you wish to delete?</label>
    <button type="submit" name="delete_lp" class="btn btn-danger btn-lg" >delete</button>
    <a href="index.php" class="btn btn-success btn-lg">cancel</a>
  </div>
</form>
<?php
endif;
 ?>
<?php
if (isset($_POST['delete_lp'])) {
  $delete = (int)$_GET['delete'];
  $delete = sanitize($delete);
  $db->query("DELETE FROM laadpalen where id = '{$delete}'");
  header('Location: index.php');
}
 ?>
<?php if (isset($_GET['edit'])):
  $edit_id = (int)$_GET['edit'];
  $editSql = "SELECT * from laadpalen Where id = '$edit_id'";
  $edit_result = $db->query($editSql);
  $row = mysqli_fetch_assoc($edit_result);

  $contactEdit = $row['contactpersoon'];
  $bedrijfEdit = $row['bedrijfsnaam'];
  $klantEdit = $row['naam'];
  $emailEdit = $row['email'];
  $telEdit = $row['telefoon'];
  $adresEdit = $row['adres'];
  $postcodeEdit = $row['postcode'];
  $plaatsEdit = $row['plaats'];
  $leverdataEdit = $row['leverdata'];
  $opmerkingenEdit = $row['opmerkingen'];
  ?>

 <div class="col-md-11" style="background-color:white;height:120%;margin-top:1%;margin-left:5%;width:90%;">
   <div class="col-md-9" style="margin-left: 5%; margin-top:5%;">

  <span style="color:red;font-size:12px;"> <?php echo  "$formErr"; ?></span>
   <h1>Aanpassen aanvraagformulier</h1>
   <br><hr>
    <form method="post">
      <div class="form-row">
        <h3>Contactpersoon VDZ Projecten <span class="text-danger">*</span> </h3><br>
        <div class="col-md-6">
          <input type="text" name="contactpersoon" class="form-control" value="<?= $contactEdit; ?>">
          <span style="color:red;font-size:12px;"> <?php echo  "$contactErr"; ?></span>
        </div>
        <br><br><br>
      </div>
      <div class="form-row">
        <h3>Bedrijfsnaam</h3><br>
        <input type="text" name="bedrijfsnaam" class="form-control" id="bedrijfsnaam" value="<?= $bedrijfEdit; ?>" style="margin-left:2%;width:71%;">
      </div>
      <div class="form-row">
        <br><h3>Naam klant <span class="text-danger">*</span> </h3><br>
        <div class="col-md-4">
          <input type="text" name="naam_klant" class="form-control" value="<?= $klantEdit; ?>">
          <span style="color:red;font-size:12px;"> <?=$naam_klantErr;?></span>
        </div>
      </div>
      <div class="form-row"><br><br><br>
        <h3>Email <span class="text-danger">*</span></h3><br>
        <input type="text" name="email" class="form-control" id="email" value="<?= $emailEdit; ?>" style="margin-left:2%;width:71%;">
        <span style="color:red;font-size:12px;margin-left:2%;"> <?=$emailErr;?></span>
      </div>
      <div class="form-row">
        <h3>Telefoonnummer <span class="text-danger">*</span></h3><br>
        <input type="text" name="tel" class="form-control" id="bedrijfsnaam" value="<?= $telEdit; ?>" style="margin-left:2%;width:71%;">
        <span style="color:red;font-size:12px;margin-left:2%;"><?=$telErr;?></span>
      </div>
      <div class="form-row">
        <h3>Adres <span class="text-danger">*</span></h3><br>
        <span style="color:red;font-size:12px;margin-left:2%;"> <?=$adresErr;?></span>
        <input type="text" name="adres" class="form-control" id="bedrijfsnaam" value="<?= $adresEdit; ?>" style="margin-left:2%;width:71%;"><br>

        <div class="col-md-4">
          <input type="text" name="postcode" class="form-control" value="<?= $postcodeEdit; ?>">
          <span style="color:red;font-size:12px;"> <?=$postcodeErr;?></span>
        </div>
        <div class="col-md-5">
          <input type="text" name="plaats" class="form-control" value="<?= $plaatsEdit; ?>">
          <span style="color:red;font-size:12px;"> <?=$plaatsErr;?></span>
        </div>
      </div><br><br>
      <div class="form-row">
        <h3>Wanneer ontvangt de klant zijn/haar auto <span class="text-danger">*</span></h3><br>
        <input type="text" name="leverdata" class="form-control" id="bedrijfsnaam" value="<?= $leverdataEdit; ?>" style="margin-left:2%;width:71%;">
        <span style="color:red;font-size:12px;margin-left:2%;"> <?= $leverdataErr;?></span>
      </div>
      <div class="form-row">
        <h3>Heb je nog opmerkingen over- of wensen voor de plaatsing van het laadpunt? Geef die dan hieronder aan.</h3><br>
        <textarea class="form-control" name="opmerkingen" id="exampleFormControlTextarea1" rows="3" style="margin-left:2%;width:71%;"><?= $opmerkingenEdit; ?></textarea>
        <span style="color:red;font-size:12px;margin-left:2%;"> <?=$opmerkingenErr;?></span>
      </div><br><br><br>
      <button type="submit" name="button" class="btn btn-dark btn-lg">Save</button>
      <button type="cancel" name="cancel" class="btn btn-dark btn-lg">Cancel</button>

      <br><br><br><br>
    </form>
 </div>
 </div>
 <?php endif; ?>
