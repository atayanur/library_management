<?php
require_once('.includes/init_session.php');
require_once("config.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$role    = $_SESSION["role"];
$user_id = $_SESSION["user_id"];
$name    = $_SESSION["name"];

include("./.includes/header.php");

if ($role === "admin") {
    $query_pinjam = "SELECT COUNT(*) AS total_pinjam FROM peminjaman WHERE status = 'dipinjam'";
    $result_pinjam = mysqli_query($conn, $query_pinjam);
    $total_pinjam = mysqli_fetch_assoc($result_pinjam)['total_pinjam'] ?? 0;

    $query_buku = "SELECT COUNT(*) AS total_buku FROM buku";
    $result_buku = mysqli_query($conn, $query_buku);
    $total_buku = mysqli_fetch_assoc($result_buku)['total_buku'] ?? 0;

    $query_users = "SELECT COUNT(*) AS total_users FROM users WHERE role = 'user'";
    $result_users = mysqli_query($conn, $query_users);
    $total_users = mysqli_fetch_assoc($result_users)['total_users'] ?? 0;

    $query_transaksi = "SELECT COUNT(*) AS total_transaksi FROM peminjaman";
    $result_transaksi = mysqli_query($conn, $query_transaksi);
    $total_transaksi = mysqli_fetch_assoc($result_transaksi)['total_transaksi'] ?? 0;

    // logika denda: berdasarkan tgl_deadline, bukan tgl_kembali
    $query_denda = "SELECT SUM(DATEDIFF(CURDATE(), tgl_deadline) * 1000) AS total_denda
                    FROM peminjaman 
                    WHERE status = 'dipinjam' AND tgl_deadline < CURDATE()";
    $result_denda = mysqli_query($conn, $query_denda);
    $total_denda = mysqli_fetch_assoc($result_denda)['total_denda'] ?? 0;
}
?>

<div class="container-xxl flex-grow-1 container-p-y">

<?php if ($role === "admin"): ?>
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-4">
            <div class="card"><div class="card-body">
                <span class="fw-semibold d-block mb-1">Buku Dipinjam</span>
                <h3 class="card-title mb-2"><?= $total_pinjam; ?></h3>
                <small class="text-info fw-semibold"><i class="bx bx-book-bookmark"></i> Update</small>
            </div></div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="card"><div class="card-body">
                <span class="fw-semibold d-block mb-1">Total Buku</span>
                <h3 class="card-title mb-2"><?= $total_buku; ?></h3>
                <small class="text-primary fw-semibold"><i class="bx bx-book"></i> Data</small>
            </div></div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="card"><div class="card-body">
                <span class="fw-semibold d-block mb-1">Anggota</span>
                <h3 class="card-title mb-2"><?= $total_users; ?></h3>
                <small class="text-success fw-semibold"><i class="bx bx-user"></i> Registered</small>
            </div></div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="card"><div class="card-body">
                <span class="fw-semibold d-block mb-1">Transaksi</span>
                <h3 class="card-title mb-2"><?= $total_transaksi; ?></h3>
                <small class="text-warning fw-semibold"><i class="bx bx-transfer-alt"></i> Total</small>
            </div></div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="card"><div class="card-body">
                <span class="fw-semibold d-block mb-1">Total Denda</span>
                <h3 class="card-title mb-2">Rp<?= number_format($total_denda, 0, ',', '.'); ?></h3>
                <small class="text-danger fw-semibold"><i class="bx bx-error-circle"></i> Terlambat</small>
            </div></div>
        </div>
    </div>

    <div class="card-body">
        <h5 class="mb-3 fw-semibold">Buku Paling Sering Dipinjam</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Jumlah Dipinjam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_populer = "SELECT b.judul, COUNT(*) AS jumlah 
                                      FROM peminjaman p 
                                      JOIN buku b ON p.buku_id = b.buku_id 
                                      GROUP BY p.buku_id 
                                      ORDER BY jumlah DESC 
                                      LIMIT 5";
                    $result_populer = mysqli_query($conn, $query_populer);
                    while ($row = mysqli_fetch_assoc($result_populer)) {
                        echo "<tr><td>" . htmlspecialchars($row['judul']) . "</td><td>" . $row['jumlah'] . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include("./.includes/footer.php"); ?>
