<?php

session_start(); // WAJIB supaya bisa pakai $_SESSION

include 'config.php';

$id = $_POST['id'];
$judul = mysqli_real_escape_string($conn, $_POST['judul']);
$penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
$tahun = (int) $_POST['tahun_publikasi']; 
$kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
$stok = (int) $_POST['stok'];

if (!empty($_FILES['cover']['name'])) {
    $cover = $_FILES['cover']['name'];
    $tmp = $_FILES['cover']['tmp_name'];
    $path = "uploads/" . $cover;


    // Upload file baru
    move_uploaded_file($tmp, $path);

    // Update semua data termasuk cover

    move_uploaded_file($tmp, $path);

    $query = "UPDATE buku 
              SET judul='$judul', penulis='$penulis', tahun_publikasi=$tahun, kategori='$kategori', stok=$stok, cover='$cover' 
              WHERE buku_id=$id";
} else {

    // Update tanpa ganti cover

    $query = "UPDATE buku 
              SET judul='$judul', penulis='$penulis', tahun_publikasi=$tahun, kategori='$kategori', stok=$stok 
              WHERE buku_id=$id";
}


mysqli_query($conn, $query);

// Redirect kembali ke halaman daftar buku
header("Location: daftar_buku.php");

if (mysqli_query($conn, $query)) {
    $_SESSION['notification'] = [
        'type' => 'success',
        'message' => 'Data buku berhasil diperbarui!'
    ];
} else {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Gagal memperbarui data buku.'
    ];
}

header("Location: daftar_buku.php"); // balik ke tampilan buku yang sudah diubah model ke bawah

exit;
?>
