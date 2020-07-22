<?php
declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'phpmailer/PHPMailerAutoload.php';
//conditions before sending mail
$fullForm = !empty($_SESSION['email']) & !empty($_SESSION['street']) & !empty($_SESSION['streetnumber']) & !empty($_SESSION['city']) & !empty($_SESSION['zipcode']) & isset($_POST['products']);

if ($fullForm) {
    //send mail to
    if (isset($_SESSION['email'])) {
        $sendTo = $_SESSION['email'];
    }
    //message in mail
    $msg = 'Your email: '.$_SESSION['email'].'\n
    Address:\n'.$_SESSION['street'].' '.$_SESSION['streetnumber'].'\n
    '.$_SESSION['zipcode'].' '.$_SESSION['city'].'\n
    Your order will be delivered around '.$deliTime.'\n
    Total price = '.$orderValue.'&euro;';

    $mail = new PHPMailer();
    $mail->Host = "smtp.gmail.com";

// Settings
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug = 1;    // enables SMTP debug information (for testing)
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Username = 'USER';
    $mail->Password = 'PASS';

// Content
    $mail->isHTML(true);  // Set email format to HTML
    $mail->AddAddress($sendTo);
    $mail->SetFrom('USER');
    $mail->Subject = 'Order confirmation';

    $mail->MsgHTML($msg);
    if(!$mail->Send()) {
        var_dump("Error while sending email");
    } else {
        var_dump("Email sent successfully");
    }
}

