<?php
session_start();
include('includes/config.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
?>

<div class="container-fluid" style="margin-top: 56px;">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Daftar Buku</h2>
            </div>
            <a href="tambah_buku.php" class="btn btn-primary mb-3">Tambah Buku</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Genre</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM buku";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id_buku']}</td>
                                <td>{$row['judul']}</td>
                                <td>{$row['penulis']}</td>
                                <td>{$row['penerbit']}</td>
                                <td>{$row['tahun']}</td>
                                <td>{$row['genre']}</td>
                                <td>{$row['stok']}</td>
                                <td>
                                    <a href='edit_buku.php?id={$row['id_buku']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='hapus_buku.php?id={$row['id_buku']}' class='btn btn-danger btn-sm'>Hapus</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tidak ada buku</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<?php include('includes/footer.php'); ?>
