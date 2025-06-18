<?php
require_once('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Update status dan tgl_kembali
    $query = "UPDATE peminjaman 
              SET status = 'dikembalikan', tgl_kembali = CURDATE()
              WHERE peminjaman_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Tambah stok buku
    $updateStok = "UPDATE buku 
                   JOIN peminjaman ON buku.buku_id = peminjaman.buku_id
                   SET buku.stok = buku.stok + 1 
                   WHERE peminjaman.peminjaman_id = ?";
    $stmt2 = $conn->prepare($updateStok);
    $stmt2->bind_param("i", $id);
    $stmt2->execute();

    $_SESSION['notification'] = ['type' => 'success', 'message' => 'Buku berhasil ditandai dikembalikan.'];
}

header("Location: peminjaman_admin.php");
exit;
