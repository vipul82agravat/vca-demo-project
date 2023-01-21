<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '4bcdff21785e96';                     //SMTP username
    $mail->Password   = '1a801316744641';                               //SMTP password
    $mail->SMTPSecure = 'TLS';//PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('vipulagravat@aum.bz', 'LibMailer');
    $mail->addAddress('vipulagravat@aum.bz', 'vip');     //Add a recipient
    $message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'First composer test Mail';
    $mail->Body    = $message;
    $mail->AltBody = 'Mail Send';

    $mail->send();
    echo 'Eamil Message has been sent';
} catch (Exception $e) {
    echo "Email Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}