<?php
include 'config.php';
session_start();

// Pastikan user login sebagai anggota
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'anggota') {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Anda harus login sebagai anggota untuk meminjam buku.'];
    header("Location: login.php");
    exit;
}

$anggota_id = $_SESSION['user_id'];
$buku_id = $_GET['buku_id'] ?? null;
$tgl_peminjaman = date('Y-m-d');
$tgl_deadline = date('Y-m-d', strtotime('+7 days')); // ➕ Deadline otomatis 7 hari ke depan

// Validasi input
if (!$buku_id || !is_numeric($buku_id)) {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'ID buku tidak valid.'];
    header("Location: buku.php");
    exit;
}

// Cek apakah stok buku masih tersedia
$cekStok = $conn->prepare("SELECT stok FROM buku WHERE buku_id = ?");
$cekStok->bind_param("i", $buku_id);
$cekStok->execute();
$stokResult = $cekStok->get_result();

if ($stokResult->num_rows === 0) {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Buku tidak ditemukan.'];
    header("Location: buku.php");
    exit;
}

$stok = $stokResult->fetch_assoc()['stok'];
if ($stok <= 0) {
    $_SESSION['notification'] = ['type' => 'warning', 'message' => 'Stok buku habis.'];
    header("Location: buku.php");
    exit;
}

// Cek apakah user sudah meminjam buku yang sama dan belum dikembalikan
$cekPinjam = $conn->prepare("SELECT * FROM peminjaman WHERE user_id = ? AND buku_id = ? AND status = 'dipinjam'");
$cekPinjam->bind_param("ii", $anggota_id, $buku_id);
$cekPinjam->execute();
$cekResult = $cekPinjam->get_result();

if ($cekResult->num_rows > 0) {
    $_SESSION['notification'] = ['type' => 'warning', 'message' => 'Anda sudah meminjam buku ini dan belum mengembalikannya.'];
    header("Location: buku.php");
    exit;
}

// Tambahkan data peminjaman dengan tgl_deadline
$insert = $conn->prepare("INSERT INTO peminjaman (user_id, buku_id, tgl_peminjaman, tgl_deadline, status) VALUES (?, ?, ?, ?, 'dipinjam')");
$insert->bind_param("iiss", $anggota_id, $buku_id, $tgl_peminjaman, $tgl_deadline);
$insertSuccess = $insert->execute();

if ($insertSuccess) {
    // Kurangi stok buku
    $updateStok = $conn->prepare("UPDATE buku SET stok = stok - 1 WHERE buku_id = ?");
    $updateStok->bind_param("i", $buku_id);
    $updateStok->execute();

    $_SESSION['notification'] = ['type' => 'success', 'message' => 'Buku berhasil dipinjam!'];
} else {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal meminjam buku.'];
}

header("Location: daftar_buku.php");
exit;
?>
