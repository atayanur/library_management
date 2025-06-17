<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validasi apakah user sudah login
if (empty($_SESSION["user_id"]) || empty($_SESSION["role"])) {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Silahkan Login Terlebih Dahulu!'
    ];
    header('Location: ./auth/login.php');
    exit();
}

// Ambil data dari session
$userId = $_SESSION["user_id"];
$name = $_SESSION["name"]; 
$role = $_SESSION["role"];

// Ambil notifikasi jika ada, lalu hapus
$notification = $_SESSION['notification'] ?? null;
if ($notification) {
    unset($_SESSION['notification']);
}
?>
