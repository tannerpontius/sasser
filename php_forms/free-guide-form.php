<?php
/* Who should this form be sent to? */
$EmailTo = "hello@tannerpontius.com";

/* If an email address is not required in the form, then you must use yours as the FROM */
/* To do this, UNcomment the line below and use your email address.*/
$Email = "hello@tannerpontius.com";

/* The subject of the email */
$Subject = "Wells Pools: Free Guide Contact Form";

/* The thank you page upon success, and error on spam or missing fields. */
/* If you don't want to let the spammer know you caught them, just send them to the normal thank you page. */
/* Their junk email will still not be sent if caught by the honeybpot */
$Thanks = "thank-you.html";
$error = "error.html";
$spambot = "error.html";


function clean_string($string) {
	$bad = array("content-type","bcc:","to:","cc:","href");
	return str_replace($bad,"",$string);
}

$fullname = clean_string($_POST['full-name']);
// $telephone = clean_string($_POST['telephone']);
$email = clean_string($_POST['email']);
$zip = clean_string($_POST['zip']);


/* Hidden honeypot field from the form */
$human = $_REQUEST['question'];

/* No need to edit this section */
$success = ""; /* clear field */
$headers = "From: <$Email>\r\n";
$headers .= "Reply-To: <$Email>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

/* Body of the email */
$Body = '<html><body>';
$Body .= '<strong>Name: </strong>'.$fullname.'<br />';
// $Body .= '<strong>Telephone: </strong>'.$telephone.'<br />';
$Body .= '<strong>Email: </strong>'.$email.'<br />';
$Body .= '<strong>Zip: </strong>'.$zip.'<br />';
// $Body .= '<strong>How May We Help You: </strong>'.$howMay.'<br />';
$Body .= '</body></html>';

/* First, test the honeypot field, then your required fields */
if ($human != "") {print "<meta http-equiv=\"refresh\" content=\"0;URL=$spambot\">";}
else {
	if($fullname == '') {print "<meta http-equiv=\"refresh\" content=\"0;URL=$error\">";} 
	else {
		if($zip == '') {print "<meta http-equiv=\"refresh\" content=\"0;URL=$error\">";} 
		else { 
			$success = mail($EmailTo, $Subject, $Body, $headers);
		
		}
	}
}
/* Thank you page for successful submission and passes the tests. */
if ($success){
print "<meta http-equiv=\"refresh\" content=\"0;URL=$Thanks\">";
}

?>