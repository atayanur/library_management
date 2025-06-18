<?php
require_once('config.php');
include('.includes/header.php');
include('.includes/toast_notification.php');

$title = "Laporan Peminjaman";

// Ambil data laporan: jumlah peminjaman per buku
$query = "
    SELECT b.judul, COUNT(p.peminjaman_id) AS total_dipinjam
    FROM peminjaman p
    JOIN buku b ON p.buku_id = b.buku_id
    GROUP BY p.buku_id
    ORDER BY total_dipinjam DESC
";

$result = mysqli_query($conn, $query);
?>

<style>
.container-xxl.container-p-y {
  padding-top: 1rem !important;
  padding-bottom: 1rem !important;
}
.card .card-header {
  padding: 0.75rem 1rem;
}
.card .card-body {
  padding: 0.75rem;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card shadow-sm">
    <div class="card-header bg-light text-dark">
      <h5 class="mb-0 fw-bold">Laporan Peminjaman Buku</h5>
    </div>
    <div class="card-body">
      <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Judul Buku</th>
              <th>Jumlah Dipinjam</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['judul']); ?></td>
              <td><?= $row['total_dipinjam']; ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <p class="text-muted text-center">Tidak ada data peminjaman.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
mysqli_close($conn);
include('.includes/footer.php');
?>
