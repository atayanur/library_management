<?php
require_once('config.php');
include('.includes/header.php');

$title = "Daftar Pengguna / Anggota";

// Ambil data anggota dari database
$query = "SELECT anggota_id, nama, email FROM anggota ORDER BY nama ASC";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-4">
  <h3 class="mb-4"><?= $title ?></h3>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['anggota_id']) ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php
include('.includes/footer.php');
mysqli_close($conn);
?>
