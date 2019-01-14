<?php
// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "No arguments Provided!";
   return false;
   }
   
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));
   
// Create the email and send the message
$to = 'klirowski.s@gmail.com; komon.s@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Formularz kontaktowy (szymonkomon.pl):  $name";
$email_body = "Otrzymałeś nową wiadomość z formularza kontaktowego swojej witryny.\n\n"."Oto szczegóły:\nImie: $name\nEmail: $email_address\nTelefon: $phone\nWiadomość:\n$message";
$headers = "From: noreply@szymonkomon.pl\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";   
mail($to,$email_subject,$email_body,$headers);

/* E-MAIL CONFIRMATION TO USER */

// email subject
$subject_user = "Potwierdzenie Kontaktu";

// prepare email body text (import HTML)
$body_user = file_get_contents('../templates/contact_conf_email_top.html');
$body_user .= html_entity_decode($name);
$body_user .= ",</p>
<p>Dziękujemy za skontaktowanie się z nami. Wkrótce skontaktujemy się z Tobą.</p>
<p><strong>Twoje dane kontaktowe i wiadomość</strong>
    <br />Imie i Nazwisko: ";
$body_user .= html_entity_decode($name);
$body_user .= "<br />Wiadomość: ";
$body_user .= html_entity_decode($message);
$body_user .= "<br />E-mail: ";
$body_user .= html_entity_decode($email_address);
$body_user .= "<br />Telefon: ";
$body_user .= html_entity_decode($phone);
$body_user .= file_get_contents('../templates/conf_email_bottom.html');


// To send HTML mail, the Content-type header must be set
$headers_user[] = 'MIME-Version: 1.0';
$headers_user[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers_user[] = 'From: noreply@szymonkomon.pl';

// send email
mail($email_address, $subject_user, $body_user, implode("\r\n", $headers_user));

return true;         
?>