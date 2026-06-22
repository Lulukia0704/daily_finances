-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2026 at 11:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daily_finances`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis` enum('Kebutuhan','Keinginan','Tabungan') NOT NULL,
  `anggaran_bulanan` int(11) DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `jenis`, `anggaran_bulanan`, `is_default`) VALUES
(1, 'Makan & Minum', 'Kebutuhan', 0, 1),
(2, 'Transportasi', 'Kebutuhan', 0, 1),
(3, 'Kebutuhan Rumah', 'Kebutuhan', 0, 1),
(4, 'Tagihan & Utilitas', 'Kebutuhan', 0, 1),
(5, 'Kesehatan', 'Kebutuhan', 0, 1),
(6, 'Pakaian', 'Kebutuhan', 0, 1),
(7, 'Hiburan', 'Keinginan', 0, 1),
(8, 'Perawatan Diri', 'Keinginan', 0, 1),
(9, 'Pendidikan & Buku', 'Keinginan', 0, 1),
(10, 'Tabungan', 'Tabungan', 0, 1),
(11, 'Cicilan & Hutang', 'Kebutuhan', 0, 1),
(12, 'Lain-lain', 'Keinginan', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_piutang`
--

CREATE TABLE `pembayaran_piutang` (
  `id` int(11) NOT NULL,
  `piutang_id` int(11) NOT NULL,
  `jumlah_bayar` bigint(20) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `piutang`
--

CREATE TABLE `piutang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_peminjam` varchar(100) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `jumlah_pinjam` bigint(20) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `target`
--

CREATE TABLE `target` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_goal` varchar(100) NOT NULL,
  `target_nominal` bigint(20) NOT NULL,
  `target_selesai` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `jumlah` bigint(20) NOT NULL,
  `tipe` enum('Pemasukan','Pengeluaran') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `tanggal`, `kategori_id`, `target_id`, `keterangan`, `jumlah`, `tipe`, `created_at`) VALUES
(2, 3, '2026-06-14', 12, NULL, 'traktir nda kopi', 30000, 'Pengeluaran', '2026-06-14 14:05:09'),
(5, 3, '2026-06-14', NULL, NULL, 'uang jajan dari ibuk ', 150000, 'Pemasukan', '2026-06-14 14:08:10'),
(7, 3, '2026-06-13', 1, NULL, 'beli mie ayam', 30000, 'Pengeluaran', '2026-06-14 14:44:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `created_at`) VALUES
(3, 'Levia', 'lulukastiqomariah@gmail.com', '$2y$10$mDCFS7SiLVD2.lOBMUtGb.QUD0SNb7GnTig8i0kEx59HPe0dn4YtO', '2026-06-09 12:18:49'),
(4, 'Levia', 'astiqomariah@gmail.com', '$2y$10$bgYYNbC8rYQYcAYz1wUe/.Zg2.xLsKi0LLum8q/mDxY9WP4TmdCjG', '2026-06-09 12:29:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_kategori`
--

CREATE TABLE `user_kategori` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'NONAKTIF',
  `anggaran_bulanan` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_kategori`
--

INSERT INTO `user_kategori` (`id`, `user_id`, `kategori_id`, `status`, `anggaran_bulanan`, `created_at`) VALUES
(2, 3, 11, 'AKTIF', 500000, '2026-06-10 18:25:32'),
(3, 3, 3, 'AKTIF', 0, '2026-06-10 18:25:37'),
(4, 3, 5, 'AKTIF', 0, '2026-06-10 18:25:40'),
(5, 3, 1, 'AKTIF', 0, '2026-06-10 18:25:44'),
(6, 3, 6, 'NONAKTIF', 0, '2026-06-10 18:25:46'),
(7, 3, 4, 'AKTIF', 500000, '2026-06-10 18:55:58'),
(8, 3, 10, 'AKTIF', 0, '2026-06-14 14:04:34'),
(9, 3, 8, 'AKTIF', 0, '2026-06-14 14:04:35'),
(10, 3, 12, 'AKTIF', 0, '2026-06-14 14:04:37'),
(11, 3, 7, 'AKTIF', 0, '2026-06-14 14:04:38'),
(12, 3, 9, 'AKTIF', 0, '2026-06-14 14:04:41'),
(13, 3, 2, 'AKTIF', 0, '2026-06-14 14:04:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran_piutang`
--
ALTER TABLE `pembayaran_piutang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `piutang_id` (`piutang_id`);

--
-- Indexes for table `piutang`
--
ALTER TABLE `piutang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `target`
--
ALTER TABLE `target`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `target_id` (`target_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_kategori`
--
ALTER TABLE `user_kategori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pembayaran_piutang`
--
ALTER TABLE `pembayaran_piutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `piutang`
--
ALTER TABLE `piutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `target`
--
ALTER TABLE `target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_kategori`
--
ALTER TABLE `user_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran_piutang`
--
ALTER TABLE `pembayaran_piutang`
  ADD CONSTRAINT `pembayaran_piutang_ibfk_1` FOREIGN KEY (`piutang_id`) REFERENCES `piutang` (`id`);

--
-- Constraints for table `piutang`
--
ALTER TABLE `piutang`
  ADD CONSTRAINT `piutang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `target`
--
ALTER TABLE `target`
  ADD CONSTRAINT `target_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`target_id`) REFERENCES `target` (`id`);

--
-- Constraints for table `user_kategori`
--
ALTER TABLE `user_kategori`
  ADD CONSTRAINT `user_kategori_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`),
  ADD CONSTRAINT `user_kategori_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
