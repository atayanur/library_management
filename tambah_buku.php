<?php
require_once('config.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$title = "Tambah Buku";

// Cek apakah user sudah login dan berperan sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Akses ditolak. Hanya admin yang bisa menambahkan buku.'];
    header('Location: ./auth/login.php');
    exit;
}

// Proses form tambah buku
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];

    // Upload cover
    $cover_name = '';
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $cover_tmp = $_FILES['cover']['tmp_name'];
        $cover_name = time() . '_' . basename($_FILES['cover']['name']);
        $target_path = $upload_dir . $cover_name;

        move_uploaded_file($cover_tmp, $target_path);
    }

    $query = "INSERT INTO buku (judul, penulis, tahun_publikasi, kategori, cover, stok) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssissi", $judul, $penulis, $tahun, $kategori, $cover_name, $stok);


    if ($stmt->execute()) {
        $_SESSION['notification'] = ['type' => 'success', 'message' => 'Buku berhasil ditambahkan!'];
        header('Location: daftar_buku.php');
        exit;
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal menambahkan buku!'];
    }
}

include('./.includes/header.php');
include('./.includes/toast_notification.php');
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <h1 class="my-4">Tambah Buku Baru</h1>

  <?php if (isset($_SESSION['notification'])): ?>
    <div class="alert alert-<?php echo $_SESSION['notification']['type']; ?> text-center" role="alert">
      <?php echo $_SESSION['notification']['message']; ?>
    </div>
    <?php unset($_SESSION['notification']); ?>
  <?php endif; ?>

  <div class="card shadow-sm">
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="judul" class="form-label">Judul Buku</label>
          <input type="text" class="form-control" id="judul" name="judul" required>
        </div>
        <div class="mb-3">
          <label for="penulis" class="form-label">Penulis</label>
          <input type="text" class="form-control" id="penulis" name="penulis" required>
        </div>
        <div class="mb-3">
          <label for="penerbit" class="form-label">Penerbit</label>
          <input type="text" class="form-control" id="penerbit" name="penerbit" required>
        </div>
        <div class="mb-3">
  <label for="tahun" class="form-label">Tahun Publikasi</label>
  <input type="number" class="form-control" id="tahun" name="tahun" required min="1000" max="2100">
</div>
        <div class="mb-3">
          <label for="kategori" class="form-label">Kategori</label>
          <input type="text" class="form-control" id="kategori" name="kategori" required>
        </div>
        <div class="mb-3">
          <label for="stok" class="form-label">Stok</label>
          <input type="number" class="form-control" id="stok" name="stok" required min="1" value="1">
        </div>
        <div class="mb-3">
          <label for="cover" class="form-label">Cover Buku (gambar)</label>
          <input type="file" class="form-control" id="cover" name="cover" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Tambah Buku</button>
      </form>
    </div>
  </div>
</div>

<?php include('./.includes/footer.php'); ?>
