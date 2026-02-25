<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = nl2br(htmlspecialchars(trim($_POST["message"])));
    
    // Capture the current date and time
    $date_sent = date("F j, Y, g:i a");

    $recipient = "dost.asenxo@gmail.com";
    $email_subject = "ASENXO Inquiry: " . ($subject ?: "New Message from $name");

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: <$email>" . "\r\n";

    // Design following the ASENXO template
    $email_body = "
    <html>
    <head>
        <link href='https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;700&display=swap' rel='stylesheet'>
        <style>
            body { font-family: 'Bricolage Grotesque', sans-serif; margin: 0; padding: 0; background-color: #ffffff; }
            .header { background-color: #000000; padding: 40px; text-align: center; }
            .header img { width: 250px; height: auto; }
            .content { padding: 60px 40px; text-align: center; color: #171717; }
            .intro-text { font-size: 24px; line-height: 1.4; margin-bottom: 50px; color: #333; }
            .details-table { width: 100%; max-width: 500px; margin: 0 auto; text-align: left; font-size: 18px; border-collapse: collapse; }
            .details-table td { padding: 10px 0; vertical-align: top; }
            .label { font-weight: 700; width: 120px; }
            .footer { padding: 20px; font-size: 12px; color: #999; text-align: center; }
        </style>
    </head>
    <body>
        <div class='header'>
            <img src='https://yourwebsite.com/src/img/logo-name.png' alt='Asenxo'>
        </div>
        
        <div class='content'>
            <p class='intro-text'>You have received a new message from your<br>website contact form.</p>
            
            <table class='details-table'>
                <tr>
                    <td class='label'>Name:</td>
                    <td>$name</td>
                </tr>
                <tr>
                    <td class='label'>Email:</td>
                    <td>$email</td>
                </tr>
                <tr>
                    <td class='label'>Sent On:</td>
                    <td>$date_sent</td>
                </tr>
                <tr>
                    <td class='label'>Message:</td>
                    <td>$message</td>
                </tr>
            </table>
        </div>

        <div class='footer'>
            &copy; 2026 DOST Region VI - ASENXO Project
        </div>
    </body>
    </html>";

    if (mail($recipient, $email_subject, $email_body, $headers)) {
        header("Location: index.html?status=success#contact");
    } else {
        header("Location: index.html?status=error#contact");
    }
}
?>