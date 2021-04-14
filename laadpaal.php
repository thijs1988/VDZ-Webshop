<?php
require_once 'core/init.php';
include  'includes/head.php';


$voornaamErr = "";
$achternaamErr = "";
$voornaam_klantErr = "";
$achternaam_klantErr = "";
$emailErr = "";
$telErr = "";
$postcodeErr = "";
$plaatsErr = "";
$adresErr = "";
$leverdataErr = "";
$formErr = "";
$opmerkingenErr = "";

if (isset($_POST['voornaam']) && isset($_POST['achternaam']) && isset($_POST['bedrijfsnaam']) && isset($_POST['voornaam_klant']) && isset($_POST['achternaam_klant']) && isset($_POST['email']) && isset($_POST['tel'])
&& isset($_POST['adres']) && isset($_POST['postcode']) && isset($_POST['plaats']) && isset($_POST['leverdata']) && isset($_POST['opmerkingen']) ) {


  if (empty($_POST['voornaam'])) {
    $voornaamErr = "Voornaam contactpersoon is een vereiste.";
  } elseif (!preg_match("/^[a-zA-Z-' ]*$/",$_POST['voornaam'])) {
  $voornaamErr = "Alleen letters en spaties worden geregistreerd.";
  }else{
    $voornaam = htmlentities($_POST['voornaam']);
  }

  if (empty($_POST['achternaam'])) {
    $achternaamErr = "Achternaam contactpersoon is een vereiste.";
  }
  elseif (!preg_match("/^[a-zA-Z-' ]*$/",$_POST['achternaam'])) {
  $achternaamErr = "Alleen letters en spaties worden geregistreerd.";
  }else{
    $achternaam = htmlentities($_POST['achternaam']);
  }

  if (empty($_POST['voornaam_klant'])) {
    $voornaam_klantErr = "Voornaam klant is een vereiste.";
  }
  elseif (!preg_match("/^[a-zA-Z-' ]*$/",$_POST['voornaam_klant'])) {
  $voornaam_klantErr = "Alleen letters en spaties worden geregistreerd.";
  }else{
    $voornaam_klant = htmlentities($_POST['voornaam_klant']);
  }

  if (empty($_POST['achternaam_klant'])) {
    $achternaam_klantErr = "Achternaam klant is een vereiste.";
  }
  elseif (!preg_match("/^[a-zA-Z-' ]*$/",$_POST['achternaam_klant'])) {
  $achternaam_klantErr = "Alleen letters en spaties worden geregistreerd.";
  }else{
    $achternaam_klant = htmlentities($_POST['achternaam_klant']);
  }

  if (empty($_POST['email'])) {
    $emailErr = "Email is een vereiste.";
  }
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Email is onjuist.";
  }else {
    $email = htmlentities($_POST['email']);
  }

  if (empty($_POST['tel'])) {
    $telErr = "Telefoonnummer is een vereiste.";
  }
  elseif (preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $_POST['tel'])){
        $telErr = "U heeft een onjuist telefoonnummer opgegeven, het nummer mag alleen uit cijfers bestaan.";
      }else {
        $tel = htmlentities($_POST['tel']);
      }

  if (empty($_POST['adres'])) {
    $adresErr = "Adres is een vereiste.";
  }else {
    $adres = htmlentities($_POST['adres']);
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
    $plaats = htmlentities($_POST['plaats']);
  }
  if (empty($_POST['leverdata'])) {
    $leverdataErr = "Leverdata is een vereiste.";
  }elseif (strlen($_POST['leverdata']) >10) {
    $leverdataErr = "Leverdata is onjuist, mag niet meer dan 10 tekens bevatten. ";
  }
  else {
    $leverdata = htmlentities($_POST['leverdata']);
  }
  if (strlen($_POST['opmerkingen']) >500){
    $opmerkingenErr = "Opmerkingen mogen niet meer dan 500 tekens bevatten.";
  } else {
    $opmerkingen = htmlentities($_POST['opmerkingen']);
  }

  $bedrijfsnaam = htmlentities($_POST['bedrijfsnaam']);

  if (empty($voornaamErr) && empty($achternaamErr) && empty($voornaam_klantErr) && empty($achternaam_klantErr) && empty($emailErr)
  && empty($telErr) && empty($postcodeErr) && empty($plaatsErr) && empty($adresErr) && empty($leverdataErr) && empty($formErr) && empty($opmerkingenErr)){
    $contactpersoon = $voornaam. ' ' .$achternaam;
    $naam_klant = $voornaam_klant. ' ' .$achternaam_klant;

    $bron = "thijs_d_w@hotmail.com";
    $to = "thijsdw1@gmail.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $subject = "Aanvraag laadpaal $naam_klant";
    $subject2 = "Kopie van uw aanvraag";
    $message = $naam_klant. " heeft de volgende aanvraag ingediend: " . "\n\n" . "Contactpersoon: " . $contactpersoon . "\n" . "Bedrijfsnaam: " . $bedrijfsnaam . "\n" . "Naam klant: " . $naam_klant .
    "\n" . "Email: " . $email . "\n" . "Telefoonnummer: " . $tel . "\n" . "Adres: " . $adres . " " . $postcode . " " . $plaats . "\n" . "Leverdatum auto: " . $leverdata . "Opmerkingen: " . $opmerkingen;
    $message2 = "Hier volgt de informatie betreffende de aanvraag van een laadpaal. " . "\n\n" . "Contactpersoon: " . $contactpersoon . "\n" . "Bedrijfsnaam: " . $bedrijfsnaam . "\n" . "Naam klant: " . $naam_klant .
    "\n" . "Email: " . $email . "\n" . "Telefoonnummer: " . $tel . "\n" . "Adres: " . $adres . " " . $postcode . " " . $plaats . "\n" . "Leverdatum auto: " . $leverdata . "\n" . "Opmerkingen: "
     . $opmerkingen;

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    $headers3 = "From:" . $bron;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    mail($bron,$subject,$message,$headers3);
    // You can also use header('Location: thank_you.php'); to redirect to another page.
    // You cannot use header and echo together. It's one or the other.


    $sql = "INSERT INTO laadpalen (contactpersoon, bedrijfsnaam, naam, email, telefoon, adres, postcode, plaats, leverdata, opmerkingen) VALUES
    ('$contactpersoon', '$bedrijfsnaam', '$naam_klant', '$email', '$tel', '$adres', '$postcode', '$plaats', '$leverdata', '$opmerkingen')";
    if (mysqli_query($db, $sql)) {
        header('location:laadpaal_data.php');
        return;
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
      }


  }else{
    $formErr = "vul alle data op de juiste manier in aub.";
  }
}




  ?>
<style media="screen">
  body{
    background-color:#d3d3d3;
  }
</style>
 <div class="container-fluid">
   <div class="col-md-11">
     <img src="afbeeldingen/vd-bron.jpeg" class="laadpaal-image center-block" alt="">
     <div class="laadpaal-tekstvak col-md-11">
       <div class="col-md-9" style="margin-left: 5%; margin-top:5%;">

      <span style="color:red;font-size:12px;"> <?php echo  "$formErr"; ?></span>
       <h1>VDZ Projecten | Vandebron</h1>
       <h2 class="text-muted">Laadpaal aanvraagformulier</h2><br><hr>
        <form method="post">
          <div class="form-row">
            <h3>Contactpersoon VDZ Projecten <span class="text-danger">*</span> </h3><br>
            <div class="col-md-4">
              <input type="text" name="voornaam" class="input-align form-control" placeholder="Voornaam">
              <span style="color:red;font-size:12px;"> <?php echo  "$voornaamErr"; ?></span>
            </div>
            <div class="col-md-5">
              <input type="text" name="achternaam" class="input-align form-control" placeholder="Achternaam">
              <span style="color:red;font-size:12px;"><?=$achternaamErr;?></span>
            </div><br><br><br>
          </div>
          <div class="form-row">
            <h3>Bedrijfsnaam</h3><br>
            <input type="text" name="bedrijfsnaam" class="style-bedrijfsnaam form-control" placeholder="Indien klant een zakelijk account wil." >
          </div>
          <div class="form-row">
            <br><h3>Naam klant <span class="text-danger">*</span> </h3><br>
            <div class="col-md-4">
              <input type="text" name="voornaam_klant" class="input-align form-control" placeholder="Voornaam">
              <span style="color:red;font-size:12px;"> <?=$voornaam_klantErr;?></span>
            </div>
            <div class="col-md-5">
              <input type="text" name="achternaam_klant" class="input-align form-control" placeholder="Achternaam">
              <span style="color:red;font-size:12px;"> <?=$achternaam_klantErr;?></span>
            </div>
          </div>
          <div class="form-row"><br><br><br>
            <h3>Email <span class="text-danger">*</span></h3><br>
            <input type="text" name="email" class="style-bedrijfsnaam form-control" id="email" placeholder="Email" >
            <span style="color:red;font-size:12px;margin-left:2%;"> <?=$emailErr;?></span>
          </div>
          <div class="form-row">
            <h3>Telefoonnummer <span class="text-danger">*</span></h3><br>
            <input type="text" name="tel" class="style-bedrijfsnaam form-control"  placeholder="06 12345678" >
            <span style="color:red;font-size:12px;margin-left:2%;"><?=$telErr;?></span>
          </div>
          <div class="form-row">
            <h3>Adres <span class="text-danger">*</span></h3><br>
            <span style="color:red;font-size:12px;margin-left:2%;"> <?=$adresErr;?></span>
            <input type="text" name="adres" class="style-bedrijfsnaam form-control"  placeholder="Straat en huisnummer" <br>

            <div class="col-md-4">
              <input type="text" name="postcode" class="input-align form-control" placeholder="Postcode">
              <span style="color:red;font-size:12px;"> <?=$postcodeErr;?></span>
            </div>
            <div class="col-md-5">
              <input type="text" name="plaats" class="input-align form-control" placeholder="Plaats">
              <span style="color:red;font-size:12px;"> <?=$plaatsErr;?></span>
            </div>
          </div><br><br>
          <div class="form-row">
            <h3>Wanneer ontvangt de klant zijn/haar auto <span class="text-danger">*</span></h3><br>
            <input type="text" name="leverdata" class="style-bedrijfsnaam form-control"  placeholder="mm-dd-yyyy" >
            <span style="color:red;font-size:12px;margin-left:2%;"> <?= $leverdataErr;?></span>
          </div>
          <div class="form-row">
            <h3>Heb je nog opmerkingen over- of wensen voor de plaatsing van het laadpunt? Geef die dan hieronder aan.</h3><br>
            <textarea class="style-bedrijfsnaam form-control" name="opmerkingen" id="exampleFormControlTextarea1" rows="3" ></textarea>
            <span style="color:red;font-size:12px;margin-left:2%;"> <?=$opmerkingenErr;?></span>
          </div><br><br><br>
          <button type="submit" name="button" class="btn btn-dark btn-lg">Submit</button>

          <br><br><br><br>
        </form>
     </div>
     </div>
   </div>

 </div>
