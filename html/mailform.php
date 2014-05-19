<?php
$mailto    = "michael.palotas@gridfusion.net";


$send_msg    = "";
$name_err    = "";
$email_err   = "";
$msg_err     = "";
$betreff_err = "";
$wedding_err = "";


if (!empty($_POST['send'])) {


	//read data fields from form
	$date = $_POST['datepicker'];
	$fromtime = $_POST['fromtime'];
	$untiltime = $_POST['untiltime'];
	$kind = $_POST['kind'];
		
	$company = $_POST['company'];
	$lastname = $_POST['lastname'];
	$firstname = $_POST['firstname'];
	$phone = $_POST['phonenumber'];
	$email = $_POST['email'];
	$message = utf8_decode($_POST['message']);




    $error = 0;
	
	/*
    if (empty($_POST['from_name'])) {
        $name_err = "Please enter your name!";
        $error = 1;
    } else {
        $from_name = filter($_POST['from_name']);
    }
    if (empty($_POST['from_email']) || !preg_match("/^[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}$/", $_POST['from_email'])) {
        $email_err = "Please enter your email address!";
        $error = 1;
    } else {
        $from_email = $_POST['from_email'];
    }
    if (empty($_POST['from_betreff'])) {
        $betreff_err = "Please enter a subject!";
        $error = 1;
    } else {
        $from_betreff = filter($_POST['from_betreff']);
    }
    if (empty($_POST['from_msg'])) {
        $msg_err = "Please enter a message!";
        $error = 1;
    } 
	*/
	/*
    if (isset($_POST['from_wedding'])) {
        $from_wedding = "yes";
    } 
	 */   
    
    
    /*
    else {
        $from_msg = preg_replace("/(content-type:|bcc:|cc:|to:|from:)/im", "",  $_POST['from_msg']);
    }
	
	 */

    if (!$error) {
        if (@mail($mailto, "Auftrittsanfrage von $firstname $lastname", 
        									"DATUM: $date\n
        									UHRZEIT VON: $fromtime\n
        									UHRZEIT BIS: $untiltime\n
        									ART DES AUFTRITTS: $kind\n
        									FIRMA: $company\n
        									NACHNAME: $lastname\n
        									VORNAME: $firstname\n
        									TELEFON: $phone\n
        									Email: $email\n 
        									NACHRICHT: $message\n", 
        									
        									"From: <$mailto>")) 
        {
            $send_msg = "IHRE NACHRICHT WURDE ERFOLGREICH AN UNS WEITERGELEITET. WIR SETZEN UNS BALDMÖGLICHST MIT IHNEN IN VERBINDUNG.<br><br>";
            unset($_POST['from_name']);
            unset($_POST['from_email']);
            unset($_POST['from_betreff']);
            unset($_POST['from_msg']);
            unset($_POST['from_wedding']);
            header('Location: thankyou.html');
        } else {
            $send_msg = "ES IST EIN FEHLER AUFGETRETEN. BITTE VERSUCHEN SIE ES NOCH EINMAL ODER SENDEN SIE EINE EMAIL AN INFO@DOWNTOWNBAND.CH";
        }
    }
}

function filter($input) {
    $result = preg_replace("/[^a-z0-9äöüß !?:;,.\\/_\\-=+@#$&\\*\\(\\)]/im", "",  $input);
    return preg_replace("/(content-type:|bcc:|cc:|to:|from:)/im", "",  $result);
}

?>

<?=$send_msg ?>
<form action="<?=$_SERVER['PHP_SELF']?>" method=post>
<input type="hidden" name="send" value="1">


<style type="text/css">
    table#contactForm td {
       vertical-align:top;
       padding:5px 0;
       font-size: 10px;
    }
    .error_txt{
       color:#FE2E2E;
       font-weight:bold;
    }
    h3.contactFormHeading{
       color:black;
       font-size:14px;
       font-weight:bold;
    }
    input.contactFormInput{
       border: solid 1px #CCCCCC;
       width: 220px;
       font-size: 12px;
       line-height: 17px;
       padding: 2px 0;
    }
    textarea.contactFormTextarea{
       border: solid 1px #CCCCCC;
       padding:0px 5px;
       width: 300px;
       height:100px;

    }
    
    label
    {
    	float:left;
    	line-height:120%;
    	width:200px;
    	cursor:pointer;
    }
</style>


<h3 class="contactFormHeading">Anfrage für einen Auftritt</h3>

		<fieldset>
			<legend></legend>
			<fieldset>
			<legend>Veranstaltungsdaten</legend>
			
			<div>
				<label for="datepicker">Datum:</label>
			    <input type="text" id="datepicker" name="datepicker">
			</div>
			
			<div>
				<label for="fromtime">Uhrzeit von:</label>
			 	<input type="text" name="fromtime" size="10"> Uhr bis:<input type="text" name="untiltime" size="10"> Uhr</p>
			</div>	
			
			<div>
				<label for="kind">Art der Veranstaltung:</label>
				<select name="kind">
					<option>+BITTE WAEHLEN+</option>
					<option>Kundenfest</option>
					<option>Party</option>
					<option>Betriebsfest</option>
					<option>Stadt/Gemeinde/Ortsfest</option>
					<option>Ball</option>
					<option>Jubiläum</option>			
					<option>Sonstige</option>			
				</select>
			</div>
			
			</fieldset>
			
			
			<fieldset>
			<legend>Ihre Kontaktdaten</legend>
			
			<div>
				<label for="name">Firma:</label>
				<input type="text" name="company"</p>
			</div>
			
			<div>
				<label for="name">Nachname:</label>
				<input type="text" name="lastname"</p>
			</div>
			
			<div>
				<label for="firstname">Vorname:</label>
				<input type="text" name="firstname"</p>
			</div>
			
			<div>
				<label for="phonenumber">Telefonnummer:</label>
				<input type="text" name="phonenumber"</p>
			</div>
			
			<div>
				<label for"email">Email:</label>
				<input type="text" name="email"</p>
			</div>
			</fieldset>
			
			<fieldset>
				<legend>Ihre Nachricht an uns:</legend>
				<textarea name="message" cols="50"></textarea>
			</fieldset>
			
			<input type="submit" value="Absenden"/>
			
		</fieldset>


<!--
<table id="contactForm">
<tr>
    <td style="text-align:right;"><b>Name:</b></td>
    <td><input type="text" name="from_name" value="<? if (!empty($_POST['from_name'])) echo $_POST['from_name']; ?>"> <font color='red' size=-1><?=$name_err?></font></td>
</tr>
<tr>
    <td style="text-align:right;"><b>E-Mail:</b></td>
    <td><input type="text" name="from_email" value="<? if (!empty($_POST['from_email'])) echo $_POST['from_email']; ?>"> <font color='red' size=-1><?=$email_err?></font></td>
</tr>
<tr>
    <td style="text-align:right;"><b>Subject:</b></td>
    <td><input type="text" name="from_betreff" value="<? if (!empty($_POST['from_betreff'])) echo $_POST['from_betreff']; ?>"> <font color='red' size=-1><?=$betreff_err?></font></td>
</tr>

<tr>
    <td style="text-align:right;"><b>Wedding:</b></td>
    <td><input type="checkbox" name="from_wedding" value="<? if (!empty($_POST['from_wedding'])) echo $_POST['from_wedding']; ?>"> <font color='red' size=-1><?=$wedding_err?></font></td>
</tr>

<tr>
    <td><b>Message:</b></td>
    <td><textarea class="contactFormTextarea" name="from_msg" cols=50 rows=10><? if (!empty($_POST['from_msg'])) echo $_POST['from_msg']; ?></textarea>
    <br><span class="error_txt"><?=$msg_err?></span></td>
</tr>
<tr>
    <td></td>
    <td><input type=submit value="Send"></td>
</tr>
</table>
-->

</form>
