<?php
session_start();
include('includes/config.php');
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
include('includes/header.php');

$id_peminjaman = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    $sql = "DELETE FROM peminjaman WHERE id_peminjaman = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_peminjaman);
    if ($stmt->execute()) {
        header("Location: peminjaman.php");
        exit;
    } else {
        $error = "Gagal menghapus peminjaman.";
    }
}
?>

<h2>Hapus Peminjaman</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php else: ?>
    <div class="alert alert-warning">
        <p>Apakah Anda yakin ingin menghapus peminjaman ini?</p>
        <form method="post" action="hapus_peminjaman.php?id=<?php echo $id_peminjaman; ?>">
            <button type="submit" name="confirm_delete" class="btn btn-danger">Hapus</button>
            <a href="peminjaman.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
<?php endif; ?>

<?php include('includes/footer.php'); ?>
