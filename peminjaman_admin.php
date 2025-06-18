<?php
require_once('config.php');
include('.includes/header.php');
include('.includes/toast_notification.php');

$title = "Peminjaman Melewati Deadline";

// Ambil daftar peminjaman yang sudah melewati deadline dan belum dikembalikan
$index = 1;
$query = "SELECT p.peminjaman_id, p.tgl_peminjaman, p.tgl_deadline, p.status, a.nama AS nama_anggota, b.judul AS judul_buku
          FROM peminjaman p
          JOIN anggota a ON p.user_id = a.anggota_id
          JOIN buku b ON p.buku_id = b.buku_id
          WHERE p.tgl_kembali IS NULL AND p.tgl_deadline IS NOT NULL AND p.tgl_deadline < CURDATE()
          ORDER BY p.tgl_deadline ASC";
$peminjaman = $conn->query($query);
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
      <h5 class="mb-0 fw-bold">Peminjaman Melewati Deadline</h5>
    </div>
    <div class="card-body">
      <?php if ($peminjaman && $peminjaman->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Peminjam</th>
              <th>Judul Buku</th>
              <th>Tanggal Peminjaman</th>
              <th>Deadline</th>
              <th>Hari Telat</th>
              <th>Total Denda (Rp)</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($row = $peminjaman->fetch_assoc()):
              $deadline_str = $row['tgl_deadline'];
              $hari_telat = 0;
              $denda = 0;

              if (!empty($deadline_str) && $deadline_str !== '0000-00-00') {
                  $deadline = new DateTime($deadline_str);
                  $today = new DateTime();
                  if ($today > $deadline) {
                      $hari_telat = $today->diff($deadline)->days;
                      $denda = $hari_telat * 1000;
                  }
              }
          ?>
          <tr>
            <td><?= $index++; ?></td>
            <td><?= htmlspecialchars($row['nama_anggota']); ?></td>
            <td><?= htmlspecialchars($row['judul_buku']); ?></td>
            <td><?= htmlspecialchars($row['tgl_peminjaman']); ?></td>
            <td><?= $deadline_str ? htmlspecialchars($deadline_str) : '-'; ?></td>
            <td><?= $hari_telat > 0 ? $hari_telat : '-'; ?></td>
            <td><?= $denda > 0 ? number_format($denda, 0, ',', '.') : '-'; ?></td>
            <td>
              <?php if ($row['status'] === 'dipinjam'): ?>
                <span class="badge bg-warning text-dark">Dipinjam</span>
              <?php elseif ($row['status'] === 'dikembalikan'): ?>
                <span class="badge bg-success">Dikembalikan</span>
              <?php else: ?>
                <span class="badge bg-secondary"><?= htmlspecialchars($row['status']); ?></span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($row['status'] === 'dipinjam'): ?>
                <a href="kembalikan_admin.php?id=<?= $row['peminjaman_id']; ?>" class="btn btn-sm btn-success" onclick="return confirm('Tandai sebagai dikembalikan?')">
                  Tandai Kembali
                </a>
              <?php else: ?>
                <span class="text-muted">-</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <p class="text-center text-muted">Tidak ada peminjaman yang lewat deadline.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
$conn->close();
include('.includes/footer.php');
?>
