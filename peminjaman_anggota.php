<?php
require_once('config.php');
include('.includes/header.php');
include('.includes/toast_notification.php');

$title = "Peminjaman Aktif";
$user_id = $_SESSION['user_id']; 
$index = 1;

// Ambil data peminjaman aktif
$query = "SELECT peminjaman.peminjaman_id, peminjaman.tgl_peminjaman, peminjaman.tgl_kembali, peminjaman.tgl_deadline, buku.judul AS judul_buku
          FROM peminjaman
          JOIN buku ON peminjaman.buku_id = buku.buku_id
          WHERE peminjaman.user_id = ? AND peminjaman.status = 'dipinjam'
          ORDER BY peminjaman.tgl_deadline ASC";

$stmt = $conn->prepare($query);
if (!$stmt) {
    echo "SQL Error: " . $conn->error;
    exit;
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$peminjaman = $stmt->get_result();
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
    <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center">
      <h5 class="mb-0 fw-bold">Peminjaman Aktif</h5>
    </div>
    <div class="card-body">
      <?php if ($peminjaman->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Judul Buku</th>
              <th>Tgl Peminjaman</th>
              <th>Perkiraan Kembali</th>
              <th>Deadline</th>
              <th>Hari Telat</th>
              <th>Denda (Rp)</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $peminjaman->fetch_assoc()): 
              $deadline_str = $row['tgl_deadline'];
              $today = new DateTime();
              $telat = 0;
              $denda = 0;

              if (!empty($deadline_str) && $deadline_str !== '0000-00-00') {
                  $deadline = new DateTime($deadline_str);
                  if ($today > $deadline) {
                      $telat = $today->diff($deadline)->days;
                      $denda = $telat * 1000;
                  }
              }
            ?>
            <tr>
              <td><?= $index++; ?></td>
              <td><?= htmlspecialchars($row['judul_buku']); ?></td>
              <td><?= htmlspecialchars($row['tgl_peminjaman']); ?></td>
              <td><?= $row['tgl_kembali'] ? htmlspecialchars($row['tgl_kembali']) : 'Belum dikembalikan'; ?></td>
              <td><?= !empty($deadline_str) && $deadline_str !== '0000-00-00' ? htmlspecialchars($deadline_str) : '-'; ?></td>
              <td><?= $telat > 0 ? $telat : '-'; ?></td>
              <td><?= $telat > 0 ? number_format($denda, 0, ',', '.') : '-'; ?></td>
              <td>
                <?php if ($telat > 0): ?>
                    <span class="badge bg-danger">Terlambat</span>
                <?php else: ?>
                    <span class="badge bg-success">Dipinjam</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <p class="text-center text-muted">Tidak ada peminjaman aktif.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
$stmt->close();
$conn->close();
include('.includes/footer.php');
?>
