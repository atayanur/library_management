<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input
    if (empty($name) || empty($username) || empty($password)) {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Semua kolom harus diisi!'];
        header("Location: register.php");
        exit();
    }

    // Cek apakah username sudah digunakan
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Username sudah digunakan!'];
        header("Location: register.php");
        exit();
    }

    // Simpan ke tabel users
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'anggota'; // default role
    $stmt_insert = $conn->prepare("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt_insert->bind_param("ssss", $name, $username, $hashed_password, $role);

    if ($stmt_insert->execute()) {
        // Dapatkan user_id terakhir yang dimasukkan
        $user_id = $stmt_insert->insert_id;

        // Simpan ke tabel anggota (pastikan struktur tabelnya sesuai)
        $stmt_anggota = $conn->prepare("INSERT INTO anggota (anggota_id, nama) VALUES (?, ?)");
        $stmt_anggota->bind_param("is", $user_id, $name);

        if ($stmt_anggota->execute()) {
            $_SESSION['notification'] = ['type' => 'success', 'message' => 'Pendaftaran berhasil! Silakan login.'];
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal menambahkan data ke tabel anggota.'];
            header("Location: register.php");
            exit();
        }
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Terjadi kesalahan saat mendaftar!'];
        header("Location: register.php");
        exit();
    }
}
?>
