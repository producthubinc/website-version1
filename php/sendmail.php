<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/php/phpmailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/php/phpmailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/php/phpmailer/src/SMTP.php';

function SendMail($user, $orderid, $quantity, $amount, $paymode, $email, $address)
{

  $mail = new PHPMailer;
  $mail->isSMTP();
  $mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
  $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
  $mail->Port = 587; // TLS only
  $mail->SMTPSecure = 'tls'; // ssl is deprecated
  $mail->SMTPAuth = true;
  $mail->Username = 'producthub.in@gmail.com'; // email
  $mail->Password = 'lithophane@1'; // password
  $mail->setFrom('producthub.in@gmail.com', 'Product Hub'); // From email and name
  $mail->addAddress($email, $user); // to email and name
  $mail->addReplyTo("producthub.in@gmail.com", "Product Hub");
  $mail->addBCC("producthub.in@gmail.com", "Product Hub");
  $mail->Subject = 'ProductHUB Order Placed: ' . $orderid;
  $mail->AltBody = 'HTML messaging not supported'; // If html emails is not supported by the receiver, show this body
  
  $body = "
  Dear " . $user . ", 
  
  <br>Your order has been placed with order Id " . $orderid . ". 
  <br>The work will start within 2 days after you receive this mail. 
  <br>We will communicate as and when necessary with you. 
  
  <br>Your order summary is as follows: 
  <br>Quantity: " . $quantity . "
  <br>Payable Amount: " . $amount . "
  <br>Payment mode: " . $paymode . "
  <br>Delivery Address: " . $address . "
  <br>
  <br>
  <br>Please feel free to revert back for any queries. 
  <br>
  <br>Cheers,
  <br>ProductHub, Pune
  ";
  
  $mail->msgHTML($body); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
  
  // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );
  if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
    echo "Message sent!";
  }
}
