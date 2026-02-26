<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['signup'])) {
    header('Location: register.php');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$terms = isset($_POST['terms']);

// Validation
$errors = [];
if (empty($name)) $errors[] = 'Name is required.';
if (empty($email)) $errors[] = 'Email is required.';
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';
if (empty($password)) $errors[] = 'Password is required.';
elseif (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
if (!$terms) $errors[] = 'You must agree to the Terms and Conditions.';

if (!empty($errors)) {
    $_SESSION['reg_error'] = implode(' ', $errors);
    header('Location: register.php');
    exit;
}

// Check if email already exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    $_SESSION['reg_error'] = 'Email already registered. Please log in.';
    header('Location: register.php');
    exit;
}

$otp = rand(100000, 999999);
$_SESSION['reg_name'] = $name;
$_SESSION['reg_email'] = $email;
$_SESSION['reg_password'] = password_hash($password, PASSWORD_DEFAULT);
$_SESSION['reg_otp'] = $otp;
$_SESSION['reg_otp_expiry'] = time() + 600; 

// Send OTP email
$to = $email;
$subject = "Your OTP for ASENXO Registration";
$message = "Hello $name,\n\nYour OTP is: $otp\nIt expires in 10 minutes.\n\nThank you for registering with ASENXO.";
$headers = "From: no-reply@asenxo.com\r\n";

if (mail($to, $subject, $message, $headers)) {

    header('Location: register.php');
    exit;
} else {
    $_SESSION['reg_error'] = 'Failed to send OTP email. Please try again.';
    header('Location: register.php');
    exit;
}