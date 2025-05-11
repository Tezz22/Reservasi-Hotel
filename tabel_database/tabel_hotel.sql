-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_hotel.kamar
CREATE TABLE IF NOT EXISTS `kamar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomor_kamar` varchar(10) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `harga` decimal(10,2) DEFAULT NULL,
  `status` enum('tersedia','dipesan','perbaikan') DEFAULT 'tersedia',
  `gambar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_hotel.kamar: ~1 rows (approximately)
INSERT INTO `kamar` (`id`, `nomor_kamar`, `tipe`, `deskripsi`, `harga`, `status`, `gambar`) VALUES
	(6, '003', 'Reguler', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 150000.00, 'dipesan', '681ef1e47bdc3_sh-terate-or-id-padepokan-sh-terate-madiun-1-1-scaled.jpg'),
	(7, '002', 'VIP', 'awawawawa', 300000.00, 'tersedia', '68208d8bd0bb2_1200618.jpg');

-- Dumping structure for table db_hotel.laporan
CREATE TABLE IF NOT EXISTS `laporan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dibuat_oleh` int DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `parameter` text,
  `reservasi_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dibuat_oleh` (`dibuat_oleh`),
  KEY `reservasi_id` (`reservasi_id`),
  CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id`),
  CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`reservasi_id`) REFERENCES `reservasi` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_hotel.laporan: ~0 rows (approximately)
INSERT INTO `laporan` (`id`, `dibuat_oleh`, `dibuat_pada`, `parameter`, `reservasi_id`) VALUES
	(1, 2, '2025-05-11 11:47:14', 'Reservasi dengan status menunggu', 2);

-- Dumping structure for table db_hotel.pengguna
CREATE TABLE IF NOT EXISTS `pengguna` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `peran` enum('admin','tamu') DEFAULT 'tamu',
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_hotel.pengguna: ~1 rows (approximately)
INSERT INTO `pengguna` (`id`, `nama`, `email`, `password`, `peran`, `dibuat_pada`) VALUES
	(2, 'yuda', 'aryateja100@gmail.com', '$2y$12$6.5X62c17nVIU1k4Qd/.GOCoUpdSfKPgGA6te3iOY6n1Xfh2n9BsK', 'tamu', '2025-05-07 16:32:59'),
	(5, 'Admin', 'admin@example.com', '$2y$12$iK4zmGhMMF8hGgzur7HHaOPcVCqMRahmZ.JTyaIeF.GKCpiJ/C5f6', 'admin', '2025-05-08 05:57:25'),
	(6, 'Hu Tao', 'hutao44@gmail.com', '$2y$12$JaaFPA8m5MQfLqYaptxaSO.oMaAfQwgkinOSQJZu.rFvveQIQEVR2', 'tamu', '2025-05-11 15:21:23');

-- Dumping structure for table db_hotel.reservasi
CREATE TABLE IF NOT EXISTS `reservasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pengguna_id` int DEFAULT NULL,
  `kamar_id` int DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `status` enum('menunggu','terkonfirmasi','dibatalkan') DEFAULT 'menunggu',
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pengguna_id` (`pengguna_id`),
  KEY `kamar_id` (`kamar_id`),
  CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`),
  CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`kamar_id`) REFERENCES `kamar` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_hotel.reservasi: ~0 rows (approximately)
INSERT INTO `reservasi` (`id`, `pengguna_id`, `kamar_id`, `check_in`, `check_out`, `status`, `dibuat_pada`) VALUES
	(1, 2, 6, '2025-05-10', '2025-05-11', 'terkonfirmasi', '2025-05-10 15:41:21'),
	(2, 2, 7, '2025-05-11', '2025-05-12', 'menunggu', '2025-05-11 11:47:14');

-- Dumping structure for trigger db_hotel.after_insert_reservasi
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `after_insert_reservasi` AFTER INSERT ON `reservasi` FOR EACH ROW BEGIN
  INSERT INTO laporan (dibuat_oleh, reservasi_id, parameter)
  VALUES (NEW.pengguna_id, NEW.id, CONCAT('Reservasi baru ID ', NEW.id));
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
