<?php
// Include PHPMailer classes (Ensure these files are in the 'php/PHPMailer/src/' folder)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = nl2br(htmlspecialchars(trim($_POST["message"])));
    $date_sent = date("F j, Y, g:i a");

    $mail = new PHPMailer(true);

    try {
        // --- SERVER SETTINGS ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dost.asenxo@gmail.com';
       
        $mail->Password   = 'your-app-password'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // --- RECIPIENTS ---
        $mail->setFrom('dost.asenxo@gmail.com', 'ASENXO Portal');
        $mail->addAddress('dost.asenxo@gmail.com');
        $mail->addReplyTo($email, $name); 

        // --- CONTENT ---
        $mail->isHTML(true);
        $mail->Subject = "ASENXO Inquiry: " . ($subject ?: "New Message from $name");

        $mail->Body = "
        <html>
        <head>
            <link href='https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;700&display=swap' rel='stylesheet'>
            <style>
                body { font-family: 'Bricolage Grotesque', sans-serif; margin: 0; padding: 0; background-color: #ffffff; }
                .header { background-color: #000000; padding: 40px; text-align: center; }
                .header img { width: 250px; height: auto; display: block; margin: 0 auto; }
                .content { padding: 60px 40px; text-align: center; color: #171717; }
                .intro-text { font-size: 24px; line-height: 1.4; margin-bottom: 50px; color: #171717; }
                .details-table { width: 100%; max-width: 500px; margin: 0 auto; text-align: left; font-size: 18px; border-collapse: collapse; }
                .details-table td { padding: 12px 0; vertical-align: top; border-bottom: 1px solid #f0f0f0; }
                .label { font-weight: 700; width: 120px; color: #171717; }
                .footer { padding: 40px 20px; font-size: 12px; color: #999; text-align: center; background-color: #ffffff; }
            </style>
        </head>
        <body>
            <div class='header'>
                <img src='http://localhost/ASENXO-WEB/src/img/services/logo-header.png' alt='ASENXO'>
            </div>
            <div class='content'>
                <p class='intro-text'>You have received a new message from your<br>website contact form.</p>
                <table class='details-table'>
                    <tr><td class='label'>Name:</td><td>$name</td></tr>
                    <tr><td class='label'>Email:</td><td>$email</td></tr>
                    <tr><td class='label'>Date:</td><td>$date_sent</td></tr>
                    <tr><td class='label'>Message:</td><td style='line-height: 1.6;'>$message</td></tr>
                </table>
            </div>
            <div class='footer'>
                &copy; " . date("Y") . " DOST Region VI - ASENXO Project. All rights reserved.
            </div>
        </body>
        </html>";

        $mail->send();
        header("Location: ../index.php?status=success#contact");
    } catch (Exception $e) {
        header("Location: ../index.php?status=error#contact");
    }
} else {
    header("Location: ../index.php");
}
?>