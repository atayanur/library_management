-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jun 2025 pada 17.43
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_management`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `anggota_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`anggota_id`, `nama`, `email`) VALUES
(11, 'mila', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `buku_id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `tahun_publikasi` year(4) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`buku_id`, `judul`, `penulis`, `tahun_publikasi`, `kategori`, `cover`, `stok`) VALUES
(4, 'MADILOG TAN MALAKA', 'Tan Malaka', '1951', 'filsafat', '1749818502_madilog_tan_malaka.jpg', 5),
(5, 'BAHASA INDONESIA', 'Heny Mawarti dan K. Waskitaningtyas', '2021', 'pendidikan', '1749908395_bahasa_indo.jpg', 10),
(7, 'REKAYASA PERANGKAT LUNAK', 'Rosa A.S dan M. Shalahuddin', '2018', 'pendidikan', '1749908572_buku_rpl.jpg', 9),
(8, 'PENDIDIKAN KEWARGANEGARAAN XI', 'Asroni, Hatim Gazali, Abdul Waidl, Ali Usman', '2021', 'pendidikan', '1749908739_pkn.jpg', 10),
(9, 'CANTIK ITU LUKA', 'Eka Kurniawan', '2018', 'novel', '1749908863_cantik_itu_luka.jpg', 5),
(10, 'SEJARAH XI', 'Martina Safitri, Indah Wahyu P.U. dan Zein Ilyas', '2023', 'pendidikan', '1749908989_sejarah.jpg', 7),
(11, 'BASIS DATA', 'Fathansyah', '2018', 'pendidikan', '1749909096_basis_data.jpg', 9),
(12, 'HARRY POTTER dan KAMAR RAHASIA', 'J.K. Rowling', '2017', 'fantasi', '1749909292_harry_potter2.jpg', 5),
(13, 'TENTANG KAMU', 'Tere Liye', '2016', 'novel', '1749909379_tentang_kamu.jpg', 10),
(14, 'LAUT BERCERITA', 'Leila S. Chudori', '2017', 'novel', '1749909448_laut_bercerita.jpg', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `peminjaman_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `tgl_peminjaman` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','kembali') NOT NULL DEFAULT 'dipinjam',
  `tgl_deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`peminjaman_id`, `user_id`, `buku_id`, `tgl_peminjaman`, `tgl_kembali`, `status`, `tgl_deadline`) VALUES
(21, 11, 4, '2025-06-14', '2025-06-14', 'kembali', '2025-06-09'),
(22, 11, 11, '2025-06-14', NULL, 'dipinjam', '2025-06-09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','anggota') NOT NULL DEFAULT 'anggota',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `created_at`) VALUES
(9, 'Administrator', 'admin', '$2y$10$Abl9dC2UvY836oQ/bBRzi.7ePymnqvVUzUmFOmmDEBbJB234PCilG', 'admin', '2025-06-12 16:10:49'),
(11, 'mila', 'mila', '$2y$10$J346KH38d14XI6ZAPmkPweV05G7VKPYuK8L6SEM2ScDKdFssYoBSW', 'anggota', '2025-06-13 14:19:28');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`anggota_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`buku_id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`peminjaman_id`),
  ADD KEY `anggota_id` (`user_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `anggota_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `buku_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `peminjaman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `anggota` (`anggota_id`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`buku_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
