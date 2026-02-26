<?php

$host = 'db.your-project-id.supabase.co';  // e.g., db.abcdefghijklm.supabase.co
$port = '5432';
$dbname = 'postgres';        // Default database name (or your custom name)
$username = 'postgres';       // Default user
$password = 'your-supabase-password'; // Your Supabase database password

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>