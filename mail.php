<?php

use  PHPMailer\PHPMailer\PHPMailer;
use  PHPMailer\PHPMailer\SMTP;
use  PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

$mail = new PHPMailer(true);


$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$subject = $_POST['subject'];
header('Content-Type: application/json');
if ($name === ''){
print json_encode(array('message' => 'El nombre no puede estar vacío', 'code' => 0));
exit();
}
if ($email === ''){
print json_encode(array('message' => 'El correo electrónico no puede estar vacío', 'code' => 0));
exit();
} else {
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
print json_encode(array('message' => 'Formato de correo electrónico no válido.', 'code' => 0));
exit();
}
}
if ($subject === ''){
print json_encode(array('message' => 'El asunto no puede estar vacío', 'code' => 0));
exit();
}
if ($message === ''){
print json_encode(array('message' => 'El mensaje no puede estar vacío', 'code' => 0));
exit();
}
$content="From: $name \nEmail: $email \nMessage: $message";
$recipient = "federico@welabs.com.ar";
$mailheader = "From: $email \r\n";
//mail($recipient, $subject, $content, $mailheader) or die("Error!");

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                        // Enable verbose debug output
    $mail->isSMTP();                                                // Send using SMTP
    $mail->Host       = 'c1851187.ferozo.com';                     // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                     // Enable SMTP authentication
    $mail->Username   = 'federico@welabs.com.ar';           // SMTP username
    $mail->Password   = 'Fede1909';                            // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;              // Enable TLS encryption; `PHPMailer::ENCRYPTION_STARTTLS;`   encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress('federico@welabs.com.ar', 'Federico Lemaire');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo($email, $name);
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = $message;

    $mail->send();
    echo json_encode(array('message' => 'Mensaje enviado con exito!', 'code' => 1));
} catch (Exception $e) {
    echo json_encode(array('message' => 'El mensaje no se pudo enviar', 'code' => 0));
}
exit();
?>