<?php
require_once('config.php');
include('.includes/header.php');
include('.includes/toast_notification.php');

$title = "Riwayat Peminjaman";

$user_id = $_SESSION['user_id'];
$index = 1;

$query = "SELECT peminjaman.peminjaman_id, buku.judul AS judul_buku, peminjaman.tgl_peminjaman, peminjaman.tgl_kembali
          FROM peminjaman
          JOIN buku ON peminjaman.buku_id = buku.buku_id
          WHERE peminjaman.user_id = ?
          ORDER BY peminjaman.tgl_peminjaman DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$riwayat = $stmt->get_result();
?>

<!-- Styling dan Tampilan -->
<style>
  .container-xxl.container-p-y { padding-top: 1rem !important; padding-bottom: 1rem !important; }
  .card .card-header { padding: 0.75rem 1rem; }
  .card .card-body { padding: 0.75rem; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card shadow-sm">
    <div class="card-header bg-light text-dark">
      <h5 class="mb-0 fw-bold">Riwayat Peminjaman</h5>
    </div>
    <div class="card-body">
      <?php if ($riwayat->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Judul Buku</th>
              <th>Tanggal Peminjaman</th>
              <th>Tanggal Pengembalian</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $riwayat->fetch_assoc()): ?>
            <tr>
              <td><?= $index++;?></td>
              <td><?= htmlspecialchars($row['judul_buku']); ?></td>
              <td><?= htmlspecialchars($row['tgl_peminjaman']); ?></td>
              <td><?= $row['tgl_kembali'] ?? 'Belum dikembalikan'; ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <p class="text-center text-muted">Belum ada riwayat peminjaman.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
$stmt->close();
$conn->close();
include('.includes/footer.php');
?>
