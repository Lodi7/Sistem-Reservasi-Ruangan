-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20251106.b3c3f5e025
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2026 at 07:22 PM
-- Server version: 8.0.40
-- PHP Version: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ruangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int NOT NULL,
  `lab_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `sesi` varchar(50) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_nonaktif`
--

CREATE TABLE `jadwal_nonaktif` (
  `id` int NOT NULL,
  `lab_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `id` int NOT NULL,
  `nama_lab` varchar(100) NOT NULL,
  `kode_lab` varchar(10) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `luas` int DEFAULT NULL,
  `kapasitas` int DEFAULT '0',
  `fasilitas` text,
  `deskripsi` text,
  `gambar` varchar(255) DEFAULT NULL,
  `jam_buka` time NOT NULL,
  `jam_tutup` time NOT NULL,
  `status` enum('Tersedia','Perbaikan','Non-aktif') DEFAULT 'Tersedia',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`id`, `nama_lab`, `kode_lab`, `kategori`, `lokasi`, `luas`, `kapasitas`, `fasilitas`, `deskripsi`, `gambar`, `jam_buka`, `jam_tutup`, `status`, `created_at`) VALUES
(1, 'Lab PPSTI', 'PPSTI', 'Lab Fasilkom', 'Gedung FIK-II, Lantai 2 UPNVJT', 60, 30, ' 2 Wi-Fi, 30 Komputer,2 AC, 1 Proyektor', 'Laboratorium PPSTI memiliki kapasitas hingga 30 orang dengan luas ruangan sebesar 60 m². Dilengkapi fasilitas seperti komputer, koneksi Wi-Fi, AC, serta lingkungan laboratorium yang nyaman untuk mendukung kegiatan pembelajaran, praktikum, maupun workshop akademik. Lab ini berlokasi di Gedung FIK II, Lantai 2 dan beroperasi mulai pukul 07.00–15.30 WIB.', 'assets/images/uploads/labs/Lab-PPSTI.png', '07:00:00', '15:30:00', 'Tersedia', '2026-05-25 17:26:53'),
(2, 'Lab SCR', 'SCR', 'Lab Fasilkom', 'Gedung FIK-II, Lantai 2 UPNVJT', 55, 25, ' 2 Wi-Fi, 25 Komputer,4 AC, 1 CCTV', 'Laboratorium SCR memiliki kapasitas hingga 25 orang dengan luas ruangan sebesar 55 m². Dilengkapi fasilitas komputer, koneksi Wi-Fi stabil, AC, dan area belajar yang mendukung kegiatan praktikum serta diskusi akademik mahasiswa. Lab ini berlokasi di Gedung FIK II, Lantai 2 dan beroperasi mulai pukul 07.00–15.30 WIB.', 'assets/images/uploads/labs/Lab-SCR.png', '07:00:00', '15:30:00', 'Perbaikan', '2026-05-25 17:26:53'),
(3, 'Lab Solusi', 'SOLUSI', 'Lab Fasilkom', 'Gedung FIK II, Lantai 2 UPNVJT', 70, 35, '3 Wi-Fi, 35 Komputer,6 AC, 1 Proyektor', 'Laboratorium Solusi memiliki kapasitas hingga 35 orang dengan luas ruangan sebesar 70 m². Laboratorium ini dilengkapi fasilitas komputer, koneksi internet, AC, proyektor, dan speaker untuk menunjang kegiatan pembelajaran, presentasi, maupun workshop akademik. Lab ini berlokasi di Gedung FIK II, Lantai 2 dan beroperasi mulai pukul 07.00–15.30 WIB.', 'assets/images/uploads/labs/Lab-Solusi.png', '07:00:00', '15:30:00', 'Perbaikan', '2026-05-25 17:26:53'),
(4, 'Lab Rekayasa dan Bisnis Digital', 'RBD', 'Lab FASILKOM', 'Gedung FIK II, Lantai 3 UPNVJT', 65, 32, '2 Wi-Fi, 32 Komputer, 2 AC,  1 Proyektor, 2 Speaker', 'Laboratorium Rekayasa dan Bisnis Digital memiliki kapasitas hingga 32 orang dengan luas ruangan sebesar 65 m². Dilengkapi fasilitas komputer, koneksi internet, AC, proyektor, dan speaker untuk mendukung kegiatan pembelajaran, praktikum, serta pengembangan bisnis digital mahasiswa. Lab ini berlokasi di Gedung FIK II, Lantai 3 dan beroperasi mulai pukul 07.00–15.30 WIB.', 'assets/images/uploads/labs/Rekayasa-Data-dan-Bisnis-Digital.png', '07:00:00', '15:30:00', 'Tersedia', '2026-05-25 18:37:30'),
(5, 'Lab MSI', 'MSI', 'Lab FASILKOM', 'Gedung FIK II, Lantai 2 UPNVJT', 55, 28, '2 WiFi, 28 Komputer, AC,  1 Proyektor', 'Laboratorium MSI memiliki kapasitas hingga 28 orang dengan luas ruangan sebesar 55 m². Laboratorium ini digunakan untuk menunjang kegiatan praktikum sistem informasi dan analisis data mahasiswa. Dilengkapi fasilitas komputer, Wi-Fi, AC, dan proyektor untuk mendukung kegiatan akademik secara optimal. Lab ini berlokasi di Gedung FIK II, Lantai 2 dan beroperasi mulai pukul 07.00–15.30 WIB.', 'assets/images/uploads/labs/Lab-MSI.png', '07:00:00', '15:30:00', 'Tersedia', '2026-05-25 18:37:30'),
(6, 'Lab Sains Data', 'SD', 'Lab FASILKOM', 'Gedung FIK II, Lantai 2 UPNVJT', 70, 35, '3 Wi-Fi, 35 Komputer,2 AC, 2 Proyektor, 1 Smart TV', 'Laboratorium Sains Data memiliki kapasitas hingga 35 orang dengan luas ruangan sebesar 70 m². Laboratorium ini difokuskan untuk kegiatan pembelajaran data science, machine learning, dan analisis data mahasiswa. Dilengkapi fasilitas komputer, internet, AC, proyektor, dan Smart TV untuk menunjang kegiatan akademik dan workshop teknologi. Lab ini berlokasi di Gedung FIK II, Lantai 1 dan beroperasi mulai pukul 07.00–15.30 WIB.', 'assets/images/uploads/labs/Lab-Sain-Data.png', '07:00:00', '15:30:00', 'Non-aktif', '2026-05-25 18:37:30');

-- --------------------------------------------------------

--
-- Table structure for table `program_studi`
--

CREATE TABLE `program_studi` (
  `id` int NOT NULL,
  `nama_prodi` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `kode_prodi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `program_studi`
--

INSERT INTO `program_studi` (`id`, `nama_prodi`, `slug`, `kode_prodi`) VALUES
(1, 'Informatika', 'informatika', '10'),
(2, 'Sistem Informasi', 'sistem_informasi', '20'),
(3, 'Sains Data', 'sains_data', '30'),
(4, 'Bisnis Digital', 'bisnis_digital', '40');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `jadwal_id` int NOT NULL,
  `kode_reservasi` varchar(100) DEFAULT NULL,
  `dosen_penanggung_jawab` varchar(100) NOT NULL,
  `kontak` varchar(30) NOT NULL,
  `keperluan` text NOT NULL,
  `berkas` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak','Dibatalkan','Belum Ambil Kunci','Sedang Berlangsung','Selesai') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profile` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `status` enum('mahasiswa','dosen') NOT NULL,
  `npm` varchar(20) DEFAULT NULL,
  `program_studi_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `reset_otp` varchar(10) DEFAULT NULL,
  `reset_otp_expired` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `foto_profile`, `role`, `status`, `npm`, `program_studi_id`, `created_at`, `reset_otp`, `reset_otp_expired`, `reset_token`) VALUES
(1, 'Lodi Galang Putra Sugianto', '24081010193@student.upnjatim.ac.id', '$2y$12$.VaJC2YRWwFTiHarcKTRjeViFRg4pm0L/sI6SXMHOkGlzZm84AgJe', 'assets/images/uploads/profile/1779731249_6a148b31a2c7c.png', 'user', 'mahasiswa', '24081010193', 1, '2026-05-24 08:13:41', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lab_id` (`lab_id`,`tanggal`,`sesi`);

--
-- Indexes for table `jadwal_nonaktif`
--
ALTER TABLE `jadwal_nonaktif`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lab_id` (`lab_id`,`tanggal`);

--
-- Indexes for table `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_lab` (`kode_lab`);

--
-- Indexes for table `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `kode_prodi` (`kode_prodi`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_reservasi` (`kode_reservasi`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `jadwal_id` (`jadwal_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_program_studi` (`program_studi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_nonaktif`
--
ALTER TABLE `jadwal_nonaktif`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labs`
--
ALTER TABLE `labs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `program_studi`
--
ALTER TABLE `program_studi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `labs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_nonaktif`
--
ALTER TABLE `jadwal_nonaktif`
  ADD CONSTRAINT `jadwal_nonaktif_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `labs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_program_studi` FOREIGN KEY (`program_studi_id`) REFERENCES `program_studi` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
