<?php
require_once('config.php');
session_start();

// Pastikan hanya bisa diakses via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anggota_id = $_SESSION['user_id']; // diasumsikan user login = anggota
    $buku_id = $_POST['buku_id'];
    $tgl_peminjaman = $_POST['tgl_peminjaman'];
    $tgl_kembali = $_POST['tgl_kembali'];

    // Validasi sederhana
    if (empty($buku_id) || empty($tgl_peminjaman) || empty($tgl_kembali)) {
        $_SESSION['error'] = "Semua data peminjaman harus diisi.";
        header("Location: peminjaman_anggota.php");
        exit();
    }

    // Simpan ke database
    $query = "INSERT INTO peminjaman (anggota_id, buku_id, tgl_peminjaman, tgl_kembali)
              VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $anggota_id, $buku_id, $tgl_peminjaman, $tgl_kembali);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Peminjaman berhasil disimpan.";
    } else {
        $_SESSION['error'] = "Gagal memproses peminjaman.";
    }

    $stmt->close();
    $conn->close();

    // Kembali ke halaman peminjaman
    header("Location: peminjaman_anggota.php");
    exit();
} else {
    // Jika diakses langsung tanpa POST
    header("Location: ../dashboard.php");
    exit();
}
