<?php

const EMAIL_ADDRESS = 'parsdamian@gmail.com';
const PASSWORD = 'olomcmwoywxgsfvn';
const FORBIDDEN_EMAILS = ['franciszek.szeptycki@gmail.com', 'fszeptycki@gmail.com'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

if (isset($_POST['send'])) {

    try {

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_ADDRESS;
        $mail->Password = PASSWORD;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom(EMAIL_ADDRESS);

        $mail->addAddress($_POST['email']);

        $mail->IsHTML(true);

        $mail->Subject = "Pigeon Attack";

        $obrazek = './image.png';
        $content_id = $mail->addEmbeddedImage($obrazek, 'obrazek', 'obrazek.png', 'base64', 'image/png');
        $mail->Body = '<html><body><img src="cid:' . $content_id . '"></body></html>';

        if (in_array($_POST['email'], FORBIDDEN_EMAILS)) {
            throw new Exception('Forbiden email address - nie będziesz mi tu gołębiem spamić leszczu 🐟');
        }

        for ($i = 0; $i < $_POST['number']; $i++) {
            $mail->send();
        }

        echo "<script>
            alert('Pigeon attack carried out: " . $i . " times');
            window.location.href='index.php';
        </script>";
    } catch (Exception $e) {
        echo "<script>
            alert('Pigeon attack failed: " . $e->getMessage() . "');
            window.location.href='index.php';
        </script>";
    }
}
