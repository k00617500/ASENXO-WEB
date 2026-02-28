<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$otp = $data['otp'] ?? '';

if (!$email || !$otp) {
    echo json_encode(['success' => false, 'error' => 'Missing email or OTP']);
    exit;
}

$mail = new PHPMailer(true);

try {
   
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'dost.asenxo@gmail.com'; 
    $mail->Password   = 'qkoczbdhdfcmqnoi'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom('noreply@yourdomain.com', 'ASENXO');
    $mail->addAddress($email);

    // Content
    $mail->isHTML(false);
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = "Your OTP code is: $otp";

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error'   => $mail->ErrorInfo
    ]);
}