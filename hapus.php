<?php
require_once('config.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM buku WHERE buku_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: daftar_buku.php");
        exit;
    } else {
        echo "Gagal menghapus buku.";
    }
}
?>
