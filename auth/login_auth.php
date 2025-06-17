<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;
            $_SESSION["name"]     = $row["name"];
            $_SESSION["role"]     = $row["role"];
            $_SESSION["user_id"]  = $row["id"];
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Selamat Datang Kembali!'
            ];
            header("Location: /library_management/dashboard.php"); //  path absolut
            exit();
        }
    }

    // Jika gagal login
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Username atau Password salah'
    ];
    // Jika role anggota, pastikan ada di tabel anggota
if ($row["role"] === "anggota") {
    $checkAnggota = $conn->prepare("SELECT 1 FROM anggota WHERE anggota_id = ?");
    $checkAnggota->bind_param("i", $row["id"]);
    $checkAnggota->execute();
    $checkAnggota->store_result();

    if ($checkAnggota->num_rows == 0) {
        // Auto insert jika belum ada di tabel anggota
        $insertAnggota = $conn->prepare("INSERT INTO anggota (anggota_id, nama) VALUES (?, ?)");
        $insertAnggota->bind_param("is", $row["id"], $row["name"]);
        $insertAnggota->execute();
    }
}
    header("Location: /library_management/auth/login.php"); // sesuaikan lokasi form login
    exit;
}

$conn->close();
?>
