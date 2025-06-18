<?php
session_start();
include 'config.php';

$anggota_id = $_SESSION['user_id'] ?? null;

// Ambil semua data buku
$query = "SELECT * FROM buku";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            padding: 10px;
        }
        img {
            height: 150px;
        }
        .notification.success {
            background-color: #d4edda;
            padding: 10px;
            margin: 10px 0;
            color: green;
        }
        .notification.danger {
            background-color: #f8d7da;
            padding: 10px;
            margin: 10px 0;
            color: red;
        }
    </style>
</head>
<body>

<?php
// Tampilkan notifikasi dari session
if (isset($_SESSION['notification'])) {
    $notif = $_SESSION['notification'];
    echo '<div class="notification ' . $notif['type'] . '">' . $notif['message'] . '</div>';
    unset($_SESSION['notification']);
}
?>

<h1>Daftar Buku</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Tahun Publikasi</th>
        <th>Kategori</th>
        <th>Cover</th>
        <th>Aksi</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= $row['buku_id'] ?></td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['penulis']) ?></td>
            <td><?= $row['tahun_publikasi'] ?></td>
            <td><?= htmlspecialchars($row['kategori'] ?? '-') ?></td>
            <td>
                <?php if (!empty($row['cover'])): ?>
                    <img src="uploads/<?= $row['cover'] ?>" alt="cover">
                <?php else: ?>
                    Tidak ada cover
                <?php endif; ?>
            </td>
            <td>
                <?php
                // Cek apakah buku ini sedang dipinjam oleh user
                if ($anggota_id) {
                    $cek = $conn->prepare("SELECT status FROM peminjaman WHERE anggota_id = ? AND buku_id = ? ORDER BY peminjaman_id DESC LIMIT 1");
                    $cek->bind_param("ii", $anggota_id, $row['buku_id']);
                    $cek->execute();
                    $res = $cek->get_result();
                    $status = $res->fetch_assoc()['status'] ?? null;

                    if ($status === 'dipinjam') {
                        echo '<a href="kembali.php?buku_id=' . $row['buku_id'] . '">Kembalikan</a>';
                    } else {
                        echo '<a href="pinjam.php?buku_id=' . $row['buku_id'] . '">Pinjam</a>';
                    }
                } else {
                    echo '<a href="login.php">Login untuk Pinjam</a>';
                }
                ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
