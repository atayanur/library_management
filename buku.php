<?php
session_start();
include 'config.php';

$anggota_id = $_SESSION['user_id'] ?? null;

// Ambil semua data buku
$query = "SELECT * FROM buku";

$highlight_id = $_GET['highlight_id'] ?? null;

// Ambil data buku
if ($highlight_id) {
    $query = "SELECT * FROM buku WHERE buku_id = $highlight_id";
} else {
    $query = "SELECT * FROM buku";
}

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

        body {
            font-family: Arial, sans-serif;
            padding: 20px;

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
        .book-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        }
        .book-cover {
            height: 180px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .book-title {
            font-size: 18px;
            font-weight: bold;
        }
        .book-info {
            margin: 5px 0;
        }
        .action-btn {
            margin-top: 10px;
        }
        .action-btn a {
            background-color: #007bff;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
        }
        .action-btn a:hover {
            background-color: #0056b3;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 15px;
            display: inline-block;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
>>>>>>> 4fbe24f (memperbaiki)
    </style>
</head>
<body>

<?php

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
<?php if ($highlight_id): ?>
    <a href="buku.php" class="btn-back">Lihat Semua Buku</a>
<?php endif; ?>

<?php while ($row = $result->fetch_assoc()) : ?>
    <div class="book-card">
        <?php if (!empty($row['cover'])): ?>
            <img class="book-cover" src="uploads/<?= $row['cover'] ?>" alt="cover">
        <?php else: ?>
            <p>Tidak ada cover</p>
        <?php endif; ?>

        <div class="book-title"><?= htmlspecialchars($row['judul']) ?></div>
        <div class="book-info"><strong>Penulis:</strong> <?= htmlspecialchars($row['penulis']) ?></div>
        <div class="book-info"><strong>Tahun Publikasi:</strong> <?= $row['tahun_publikasi'] ?></div>
        <div class="book-info"><strong>Kategori:</strong> <?= htmlspecialchars($row['kategori'] ?? '-') ?></div>

        <div class="action-btn">
            <a href="edit.php?id=<?= $row['buku_id'] ?>">Update</a>
        </div>
    </div>
<?php endwhile; ?>

</body>
</html>
