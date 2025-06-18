<?php
session_start();
ob_start();
require_once('config.php');
include('.includes/header.php');
$title = "Manajemen Buku";

// Tampilkan notifikasi jika ada
if (isset($_SESSION['notification'])) {
    echo '<div class="alert alert-' . $_SESSION['notification']['type'] . ' text-center">'
         . $_SESSION['notification']['message'] . '</div>';
    unset($_SESSION['notification']);
}

include('./.includes/toast_notification.php');

// Ambil filter kategori dari URL (jika ada)
$filterCat = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Pagination untuk daftar buku
$limit = 7; // Jumlah buku per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Query untuk mengambil kategori unik dari tabel buku
$cat_query = "SELECT DISTINCT kategori FROM buku";
$cat_stmt = $conn->prepare($cat_query);
$cat_stmt->execute();
$cat_result = $cat_stmt->get_result();

// Query untuk mengambil buku berdasarkan filter & pagination
$query = !empty($filterCat) ? "SELECT * FROM buku WHERE kategori = ? LIMIT $start, $limit" : "SELECT * FROM buku LIMIT $start, $limit";
$stmt = $conn->prepare($query);
if (!empty($filterCat)) {
    $stmt->bind_param("s", $filterCat);
}
$stmt->execute();
$result = $stmt->get_result();

// Hitung total buku untuk pagination
$total_query = !empty($filterCat) ? "SELECT COUNT(*) FROM buku WHERE kategori = ?" : "SELECT COUNT(*) FROM buku";
$total_stmt = $conn->prepare($total_query);
if (!empty($filterCat)) {
    $total_stmt->bind_param("s", $filterCat);
}
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_buku = $total_result->fetch_array()[0];
$total_pages = ceil($total_buku / $limit);

// Proses update stok buku
if (isset($_POST['update_stok'])) {
    $buku_id = $_POST['buku_id'];
    $stok_baru = $_POST['stok'];

    $query = "UPDATE buku SET stok = ? WHERE buku_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $stok_baru, $buku_id);

    if ($stmt->execute()) {
        $_SESSION['notification'] = ['type' => 'success', 'message' => 'Stok berhasil diperbarui!'];
        ob_end_clean();
        header("Location: buku.php?page=" . $page);
        exit;
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal memperbarui stok.'];
    }
}
?>

<div class="container-fluid flex-grow-1 px-4 mt-3">
  <!-- Filter kategori -->
  <div class="row mb-4">
    <div class="col">
      <div class="btn-group" role="group" aria-label="Filter berdasarkan kategori">
        <a href="daftar_buku.php" class="btn btn-outline-primary <?= empty($filterCat) ? 'active' : '' ?>">Semua</a>
        <?php while ($cat = $cat_result->fetch_assoc()): ?>
          <a href="daftar_buku.php?kategori=<?= urlencode($cat['kategori']) ?>" 
             class="btn btn-outline-primary <?= ($filterCat == $cat['kategori']) ? 'active' : '' ?>">
            <?= $cat['kategori'] ?>
          </a>
        <?php endwhile; ?>
      </div>
    </div>
  </div>

  <!-- Grid buku -->
  <div class="row g-4">
    <!-- Tambah buku -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <a href="tambah_buku.php" style="text-decoration: none; color: inherit;">
        <div class="card shadow-md h-100 d-flex justify-content-center align-items-center border" 
             style="border-radius: 15px; overflow: hidden;">
          <div class="d-flex flex-column align-items-center justify-content-center" style="height:200px;">
            <i class="bx bx-plus" style="font-size: 2rem;"></i>
            <h5 class="mt-2 card-tambah-menu">Tambah Buku</h5>
          </div>
        </div>
      </a>
    </div>

    <?php while ($buku = $result->fetch_assoc()): ?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card shadow-md h-100 border" 
             style="border-radius: 15px; overflow: hidden; padding: 15px; text-align: center; position: relative;">
          
          <!-- Dropdown -->
          <div class="position-absolute top-0 end-0 p-2">
            <button class="btn btn-sm btn-icon py-0" data-bs-toggle="dropdown">
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="edit.php?id=<?= $buku['buku_id']; ?>">
                <i class="bx bx-edit-alt me-2"></i> Edit
              </a></li>
              <li><a class="dropdown-item text-danger" href="hapus.php?id=<?= $buku['buku_id']; ?>">
                <i class="bx bx-trash me-2"></i> Hapus
              </a></li>
            </ul>
          </div>

          <img src="uploads/<?= $buku['cover']; ?>" class="card-img-top img-fluid" 
               alt="<?= $buku['judul']; ?>" style="height: 220px; object-fit: cover; border-radius: 10px;">
          
          <div class="card-body">
            <h5 class="card-title"><?= $buku['judul']; ?></h5>
            <p class="card-text text-muted small"><?= $buku['kategori']; ?></p>
            <p class="card-text text-muted small"><?= $buku['penulis']; ?></p>
            <p class="card-text <?= ($buku['stok'] > 0) ? 'text-warning' : 'text-danger'; ?>">
                <?= ($buku['stok'] > 0) ? '📚 Stok: ' . $buku['stok'] . ' tersedia' : '❌ Stok: Habis'; ?>
            </p>

            <!-- Form update stok -->
            <div class="text-center mt-2">
<?php
  $role = $_SESSION['role'] ?? 'guest';
  $user_id = $_SESSION['user_id'] ?? 0;

  if ($role === 'admin') {
?>
    <!-- Admin: Form update stok -->
    <form method="POST">
        <input type="hidden" name="buku_id" value="<?= $buku['buku_id']; ?>">
        <input type="number" name="stok" value="<?= $buku['stok']; ?>" min="0" class="form-control text-center mb-2">
        <button type="submit" name="update_stok" class="btn btn-primary btn-custom w-100">
          <i class="bx bx-refresh me-2"></i> Update Stok
        </button>
    </form>

<?php
  } elseif ($role === 'anggota') {
    // Cek apakah buku sedang dipinjam oleh user
    $cekPeminjaman = $conn->prepare("SELECT * FROM peminjaman WHERE buku_id = ? AND user_id = ? AND status = 'dipinjam'");
    $cekPeminjaman->bind_param("ii", $buku['buku_id'], $user_id);
    $cekPeminjaman->execute();
    $isPinjam = $cekPeminjaman->get_result()->num_rows > 0;

    if ($isPinjam) {
?>
    <a href="kembalikan.php?buku_id=<?= $buku['buku_id'] ?>" class="btn btn-warning w-100">
      <i class="bx bx-undo"></i> Kembalikan
    </a>
<?php } else { ?>
    <?php if ($buku['stok'] > 0): ?>
      <a href="pinjam.php?buku_id=<?= $buku['buku_id'] ?>" class="btn btn-success w-100">
        <i class="bx bx-book"></i> Pinjam
      </a>
    <?php else: ?>
      <button class="btn btn-secondary w-100" disabled>
        <i class="bx bx-block"></i> Tidak Tersedia
      </button>
    <?php endif; ?>
<?php
    }
  } else {
    echo '<span class="text-muted">Login untuk pinjam</span>';
  }
?>
</div>
</div> 
        </div> 
      </div> 
    <?php endwhile; ?>
  </div> 
</div> 

<?php include('.includes/footer.php'); ?>

