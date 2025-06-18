<?php
include 'config.php';
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM buku WHERE buku_id = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h3>Edit Data Buku</h3>

  <form method="POST" action="proses_edit.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $data['buku_id'] ?>">

    <div class="mb-3">
      <label for="judul" class="form-label">Judul</label>
      <input type="text" name="judul" class="form-control" value="<?= $data['judul'] ?>" required>
    </div>

    <div class="mb-3">
      <label for="penulis" class="form-label">Penulis</label>
      <input type="text" name="penulis" class="form-control" value="<?= $data['penulis'] ?>" required>
    </div>

    <div class="mb-3">
      <label for="kategori" class="form-label">Kategori</label>
      <input type="text" name="kategori" class="form-control" value="<?= $data['kategori'] ?>" required>
    </div>
    <div class="mb-3">
  <label for="tahun" class="form-label">Tahun Publikasi</label>
  <input type="number" class="form-control" id="tahun_publikasi" name="tahun_publikasi" value="<?= $data['tahun_publikasi'] ?>" required min="1000" max="2100">
</div>
    <div class="mb-3">
      <label for="stok" class="form-label">Stok</label>
      <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>" required>
    </div>

    <div class="mb-3">
      <label for="cover" class="form-label">Ganti Cover (opsional)</label>
      <input type="file" name="cover" class="form-control">
      <?php if (!empty($data['cover'])): ?>
        <img src="uploads/<?= $data['cover'] ?>" width="100" class="mt-2">
      <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Update Buku</button>
    <a href="daftar_buku.php" class="btn btn-secondary">Batal</a>
  </form>
</body>
</html>
