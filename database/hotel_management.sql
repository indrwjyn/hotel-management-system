-- Hotel Management System
-- Import lewat phpMyAdmin atau: mysql -u root < database/hotel_management.sql
-- Seed data bersifat fiktif.

CREATE DATABASE IF NOT EXISTS `hotel_management`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hotel_management`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `kamar` (
  `id_kamar` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_kamar` varchar(10) DEFAULT NULL,
  `tipe_kamar` varchar(50) DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT NULL,
  `status_kamar` enum('tersedia','terisi') DEFAULT NULL,
  PRIMARY KEY (`id_kamar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `layanan` (
  `id_layanan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_layanan` varchar(100) DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id_layanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pegawai` varchar(100) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tamu` (
  `id_tamu` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `kamar` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `total_hari` int(11) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_tamu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `reservasi` (
  `id_reservasi` int(11) NOT NULL AUTO_INCREMENT,
  `id_tamu` int(11) DEFAULT NULL,
  `id_kamar` int(11) DEFAULT NULL,
  `tanggal_pesan` date DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `total_harga` decimal(12,2) DEFAULT NULL,
  `status_reservasi` enum('booking','checkin','checkout') DEFAULT NULL,
  PRIMARY KEY (`id_reservasi`),
  KEY `id_tamu` (`id_tamu`),
  KEY `id_kamar` (`id_kamar`),
  CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`id_tamu`) REFERENCES `tamu` (`id_tamu`) ON DELETE CASCADE,
  CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`id_kamar`) REFERENCES `kamar` (`id_kamar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_reservasi` int(11) DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `total_bayar` decimal(12,2) DEFAULT NULL,
  `status_bayar` enum('lunas','belum') DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `id_reservasi` (`id_reservasi`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_reservasi`) REFERENCES `reservasi` (`id_reservasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','resepsionis') DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Seed data (fiktif)
INSERT INTO `kamar` (`nomor_kamar`, `tipe_kamar`, `harga`, `status_kamar`) VALUES
('101', 'Standard Room', 300000.00, 'tersedia'),
('201', 'Deluxe Room', 500000.00, 'tersedia'),
('301', 'Suite Room', 800000.00, 'tersedia');

INSERT INTO `layanan` (`nama_layanan`, `harga`) VALUES
('Laundry', 50000.00),
('Breakfast', 30000.00),
('Spa', 150000.00);

INSERT INTO `pegawai` (`nama_pegawai`, `jabatan`, `no_hp`, `alamat`) VALUES
('Contoh Pegawai', 'Manajer', '081200000000', 'Jl. Contoh No. 1, Klaten');

INSERT INTO `tamu` (`id_tamu`, `nama`, `hp`, `kamar`, `alamat`, `check_in`, `check_out`) VALUES
(1, 'Budi Santoso', '081211112222', 'Standard Room', 'Jl. Merdeka No. 10, Solo', '2026-05-26', '2026-05-29');

INSERT INTO `reservasi` (`id_reservasi`, `id_tamu`, `id_kamar`, `tanggal_pesan`, `check_in`, `check_out`, `total_harga`, `status_reservasi`) VALUES
(1, 1, 1, '2026-05-26', '2026-05-26', '2026-05-29', 900000.00, 'booking');

INSERT INTO `transaksi` (`id_reservasi`, `tanggal_bayar`, `metode_bayar`, `total_bayar`, `status_bayar`) VALUES
(1, '2026-05-26', 'Transfer', 900000.00, 'lunas');

-- Akun demo: admin / admin123 (hash bcrypt). Ganti sebelum dipakai sungguhan.
INSERT INTO `users` (`nama`, `username`, `password`, `role`) VALUES
('Administrator', 'admin', '$2b$10$kCVJmXwJawWTVuarlbPDR.vFVehEB8GSE5EhR0szGoG6sG6kti/P6', 'admin');

COMMIT;
