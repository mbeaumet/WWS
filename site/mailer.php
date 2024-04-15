<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("vendor/autoload.php");

function mailer($to, $subject, $body)
{
    $mail = new PHPMailer();

    try {
        $mail->IsHTML(true);
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = false;
        $mail->SMTPSecure = "tls";
        $mail->Host = "smtp-mail.outlook.com";
        $mail->Port = 587;
        $mail->Username = "Max.beaumet@imie-paris.fr";
        $mail->Password = "Papa2002!";
        $mail->SetFrom("max.beaumet@imie-paris.fr", "Bienvenu");
       
        $mail->Subject = 'Bienvenu dans la famille World Wide Sneakers';

        $body = "<html>\n"; 
        $body = "<body style=\"font-family:Verdana, Verdana, Geneva, sans-serif; font-size:12px; color:#666666;\">\n"; 
        $body = "<img src='../logo.png'> <p>Bienvenu dans le famille ! Tu vas maintenant pouvoir vendre et acheter les meilleures sneakers du momant</p>"; 
        $body = "</body>\n"; 
        $body = "</html>\n"; 
        
        $mail->$body;


        $mail->AddAddress($to);

        $mail->send();
    } catch (Exception $e) {
        echo "error: $e";
    }
}
