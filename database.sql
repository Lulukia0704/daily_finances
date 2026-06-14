-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: daily_finances
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jenis` enum('Kebutuhan','Keinginan','Tabungan') NOT NULL,
  `anggaran_bulanan` int(11) DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Makan & Minum','Kebutuhan',0,1),(2,'Transportasi','Kebutuhan',0,1),(3,'Kebutuhan Rumah','Kebutuhan',0,1),(4,'Tagihan & Utilitas','Kebutuhan',0,1),(5,'Kesehatan','Kebutuhan',0,1),(6,'Pakaian','Kebutuhan',0,1),(7,'Hiburan','Keinginan',0,1),(8,'Perawatan Diri','Keinginan',0,1),(9,'Pendidikan & Buku','Keinginan',0,1),(10,'Tabungan','Tabungan',0,1),(11,'Cicilan & Hutang','Kebutuhan',0,1),(12,'Lain-lain','Keinginan',0,1);
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran_piutang`
--

DROP TABLE IF EXISTS `pembayaran_piutang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pembayaran_piutang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `piutang_id` int(11) NOT NULL,
  `jumlah_bayar` bigint(20) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `piutang_id` (`piutang_id`),
  CONSTRAINT `pembayaran_piutang_ibfk_1` FOREIGN KEY (`piutang_id`) REFERENCES `piutang` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran_piutang`
--

LOCK TABLES `pembayaran_piutang` WRITE;
/*!40000 ALTER TABLE `pembayaran_piutang` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembayaran_piutang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `piutang`
--

DROP TABLE IF EXISTS `piutang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piutang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_peminjam` varchar(100) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `jumlah_pinjam` bigint(20) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `piutang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piutang`
--

LOCK TABLES `piutang` WRITE;
/*!40000 ALTER TABLE `piutang` DISABLE KEYS */;
/*!40000 ALTER TABLE `piutang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `target`
--

DROP TABLE IF EXISTS `target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `target` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nama_goal` varchar(100) NOT NULL,
  `target_nominal` bigint(20) NOT NULL,
  `target_selesai` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `target_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `target`
--

LOCK TABLES `target` WRITE;
/*!40000 ALTER TABLE `target` DISABLE KEYS */;
/*!40000 ALTER TABLE `target` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `jumlah` bigint(20) NOT NULL,
  `tipe` enum('Pemasukan','Pengeluaran') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `kategori_id` (`kategori_id`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi`
--

LOCK TABLES `transaksi` WRITE;
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_kategori`
--

DROP TABLE IF EXISTS `user_kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'NONAKTIF',
  `anggaran_bulanan` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `kategori_id` (`kategori_id`),
  CONSTRAINT `user_kategori_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `user_kategori_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_kategori`
--

LOCK TABLES `user_kategori` WRITE;
/*!40000 ALTER TABLE `user_kategori` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-08 16:34:14
