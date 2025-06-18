<?php
include 'config.php';
session_start();

// Pastikan user login sebagai anggota
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'anggota') {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Anda harus login sebagai anggota untuk mengembalikan buku.'];
    header("Location: login.php");
    exit;
}

$anggota_id = $_SESSION['user_id'];
$buku_id = $_GET['buku_id'] ?? null;
$tgl_kembali = date('Y-m-d');

// Validasi input
if (!$buku_id || !is_numeric($buku_id)) {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'ID buku tidak valid.'];
    header("Location: buku.php");
    exit;
}

// Cek apakah data peminjaman valid dan belum dikembalikan
$cek = $conn->prepare("SELECT * FROM peminjaman WHERE user_id = ? AND buku_id = ? AND status = 'dipinjam'");
$cek->bind_param("ii", $anggota_id, $buku_id);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows === 0) {
    $_SESSION['notification'] = ['type' => 'warning', 'message' => 'Data peminjaman tidak ditemukan atau buku sudah dikembalikan.'];
    header("Location: buku.php");
    exit;
}

// Update status dan tanggal kembali
$update = $conn->prepare("UPDATE peminjaman SET status = 'kembali', tgl_kembali = ? WHERE user_id = ? AND buku_id = ? AND status = 'dipinjam'");
$update->bind_param("sii", $tgl_kembali, $anggota_id, $buku_id);
$updateSuccess = $update->execute();

if ($updateSuccess) {
    // Tambahkan stok buku kembali
    $updateStok = $conn->prepare("UPDATE buku SET stok = stok + 1 WHERE buku_id = ?");
    $updateStok->bind_param("i", $buku_id);
    $updateStok->execute();

    $_SESSION['notification'] = ['type' => 'success', 'message' => 'Buku berhasil dikembalikan.'];
} else {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal mengembalikan buku.'];
}

header("Location: daftar_buku.php");
exit;
?>
