<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?php

$loanid = $_REQUEST['id'];
$email = $_REQUEST['email'];

if ($email == '' ) {
	echo 0;
	return;
}

include '../include/database.php';
$db = new Database();
$db->connect();

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$ip = get_client_ip();


// require 'class.phpmailer.php';
require_once('../mailler/class.phpmailer.php');
require_once('../mailler/class.smtp.php');

$mail = new PHPMailer;

$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.server';                 // Specify main and backup server

$mail->Port = PORT;                                   // Set the SMTP port
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'email@example.com';

$mail->Password = 'PASSWORD';

$mail->From = 'FROM EMAIL';
$mail->setFrom($mail->Username, 'FROM_EMAIL');

$mail->AddAddress($email,$email);  


$mail->IsHTML(true);                                  // Set email format to HTML

$content = file_get_contents("../mailtemplate/documents_approve.html");


$mail->Subject = 'Your documents has been approved';
$mail->Body    = $content; 

//'<strong>Please login to Gets System with audit and legal account to approve all waiting documents.</strong><br> Don\'t worry, ignore this if you are not request.';
$mail->AltBody = 'Your documents has been approved';

if(!$mail->Send()) {
   // echo 'Message could not be sent.';
   // echo 'Mailer Error: ' . $mail->ErrorInfo;
   echo 0;
   exit;
}

// echo 'Message has been sent';
echo 1;

?>