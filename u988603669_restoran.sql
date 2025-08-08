-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Agu 2025 pada 10.38
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
-- Database: `u988603669_restoran`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `harga` int(11) DEFAULT 0,
  `gambar` varchar(255) DEFAULT 'default.jpg',
  `jenis` enum('Makanan Berat','Makanan Ringan','Minuman') DEFAULT 'Makanan Berat',
  `tersedia` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `name`, `harga`, `gambar`, `jenis`, `tersedia`) VALUES
(9, 'Rendang', 40000, 'p2.jpg', 'Makanan Berat', 1),
(10, 'Sate', 25000, 'p3.jpg', 'Makanan Berat', 1),
(11, 'Bakso', 30000, 'p4.jpg', 'Makanan Berat', 1),
(12, 'Dendeng Balado', 35000, 'p5.jpg', 'Makanan Berat', 1),
(13, 'Nasi Goreng', 25000, 'p6.jpg', 'Makanan Berat', 1),
(14, 'Mojito', 50000, 'd1.jpg', 'Minuman', 1),
(15, 'Coffee ', 50000, 'd3.jpg', 'Minuman', 1),
(16, 'Mojito Jeruk Nipis', 50000, 'd5.jpg', 'Minuman', 1),
(17, 'Jus Strawberry', 50000, 'd2.jpg', 'Minuman', 1),
(18, 'Jus Alpukat', 50000, 'd4.jpg', 'Minuman', 1),
(19, 'Cheesecake Strawberry', 50000, 's1.jpg', 'Makanan Ringan', 1),
(20, 'Ice Cream Lotus', 50000, 's2.jpg', 'Makanan Ringan', 1),
(21, 'Tiramisu Cake', 50000, 's3.jpg', 'Makanan Ringan', 1),
(22, 'Blueberry Cake ', 50000, 's4.jpg', 'Makanan Ringan', 1),
(23, 'Cheesecake Bisscoff', 50000, 's5.jpg', 'Makanan Ringan', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `food` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `status` enum('belum','diproses','selesai') NOT NULL DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `reservation_id`, `food`, `qty`, `status`) VALUES
(153, 52, 'Rendang', 1, 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `waktu_bayar` datetime DEFAULT current_timestamp(),
  `uang_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `nama`, `reservation_id`, `total`, `waktu_bayar`, `uang_bayar`, `kembalian`, `metode`, `keterangan`) VALUES
(41, 'jey nintho', 51, 100000, '2025-08-07 07:51:50', 100000, 0, 'QRIS', ''),
(42, 'labib', 54, 170000, '2025-08-07 09:03:37', 200000, 30000, 'QRIS', ''),
(43, 'putra', 56, 70000, '2025-08-07 09:17:33', 70000, 0, 'QRIS', ''),
(44, 'yusuf', 57, 170000, '2025-08-07 09:23:10', 200000, 30000, 'Tunai', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `table_number` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `status` enum('belum','selesai','dibayar') DEFAULT 'belum',
  `status_meja` enum('belum selesai','selesai','dibatalkan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `email`, `table_number`, `reservation_date`, `reservation_time`, `guest_count`, `status`, `status_meja`) VALUES
(51, 'jey nintho', 'jeynintho4@gmail.com', 1, '2025-08-07', '17:00:00', 2, 'selesai', 'selesai'),
(52, 'jey', 'jey@gmail.com', 1, '2025-08-07', '17:00:00', 2, 'selesai', 'belum selesai'),
(53, 'fachri', 'fachri@gmail.com', 2, '2025-08-07', '17:00:00', 2, 'belum', 'belum selesai'),
(54, 'labib', 'labib@gmail.com', 3, '2025-08-07', '17:00:00', 2, 'selesai', 'selesai'),
(55, 'hilman', 'hilman@gmail.com', 3, '2025-08-07', '17:00:00', 2, 'belum', 'belum selesai'),
(56, 'putra', 'putra@gmail.com', 4, '2025-08-07', '17:00:00', 2, 'selesai', 'selesai'),
(57, 'yusuf', 'yusuf@gmail.com', 5, '2025-08-07', '17:00:00', 2, 'selesai', 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `table_number` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `uang_bayar` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `status_meja` enum('selesai','dibatalkan') DEFAULT 'selesai',
  `waktu_selesai` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`id`, `reservation_id`, `table_number`, `nama`, `reservation_date`, `reservation_time`, `metode`, `uang_bayar`, `kembalian`, `total`, `status_meja`, `waktu_selesai`) VALUES
(9, 51, 1, 'jey nintho', '2025-08-07', '17:00:00', 'QRIS', 100000, 0, 100000, 'selesai', '2025-08-07 07:51:50'),
(10, 54, 3, 'labib', '2025-08-07', '17:00:00', 'QRIS', 200000, 30000, 170000, 'selesai', '2025-08-07 09:03:37'),
(11, 56, 4, 'putra', '2025-08-07', '17:00:00', 'QRIS', 70000, 0, 70000, 'selesai', '2025-08-07 09:17:33'),
(12, 57, 5, 'yusuf', '2025-08-07', '17:00:00', 'Tunai', 200000, 30000, 170000, 'selesai', '2025-08-07 09:23:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tables`
--

INSERT INTO `tables` (`id`, `capacity`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 4),
(5, 4),
(6, 4),
(7, 6),
(8, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pelayan','kasir','koki') DEFAULT 'pelayan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(10, 'admin', 'admin1@gmail.com', '$2y$10$1yoqqeVU89RPkwXJpc4TQONHNifp4Ph2G2Z3RqBMpTwSwo9sZhAmy', 'admin'),
(11, 'pelayan', 'pelayan1@gmail.com', '$2y$10$ogYraNwmrYWhyJHHkQNt6e31W6Wb7RV0HjhPh5Vna1ek9zaKGuqSC', 'pelayan'),
(12, 'koki', 'koki1@gmail.com', '$2y$10$yYW/xL1Ifb9uoqNqFh2CQONEtPXdYZm2gdFVTET3eujWjDLxlD5Ay', 'koki'),
(13, 'kasir', 'kasir1@gmai.com', '$2y$10$4jHv22WiSfqOommuE/FPUOyLgXceFXmuto/WbDFjtVVY3A0C7ptk2', 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indeks untuk tabel `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
