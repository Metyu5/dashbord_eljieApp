-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2025 at 07:08 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_eljie`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bookings`
--

CREATE TABLE `tb_bookings` (
  `id_bookings` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `id_room` int DEFAULT NULL,
  `id` int DEFAULT NULL,
  `kode_booking` varchar(10) NOT NULL,
  `booking_date` date DEFAULT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `total_amount` decimal(10,3) DEFAULT NULL,
  `status` enum('terpesan','dibatalkan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'terpesan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_bookings`
--

INSERT INTO `tb_bookings` (`id_bookings`, `id_user`, `id_room`, `id`, `kode_booking`, `booking_date`, `check_in_date`, `check_out_date`, `total_amount`, `status`) VALUES
(114, 20, 5, 2, 'KB427', '2025-05-12', '2025-05-12', '2025-05-13', '168.000', 'terpesan'),
(115, 20, 6, NULL, 'KB437', '2025-05-12', '2025-05-12', '2025-05-13', '270.000', 'terpesan'),
(116, 20, 7, NULL, 'KB398', '2025-05-12', '2025-05-12', '2025-05-13', '331.000', 'terpesan'),
(117, 20, 9, NULL, 'KB045', '2025-05-12', '2025-05-12', '2025-05-13', '100.000', 'terpesan'),
(118, 20, 11, NULL, 'KB942', '2025-05-12', '2025-05-12', '2025-05-13', '200.000', 'terpesan'),
(119, 1, 5, NULL, 'KB309', '2025-05-12', '2025-05-12', '2025-05-13', '210.000', 'terpesan'),
(120, 1, 6, NULL, 'KB739', '2025-05-12', '2025-05-12', '2025-05-13', '270.000', 'terpesan'),
(121, 1, 7, NULL, 'KB044', '2025-05-12', '2025-05-12', '2025-05-13', '331.000', 'terpesan'),
(122, 1, 9, NULL, 'KB147', '2025-05-12', '2025-05-12', '2025-05-13', '100.000', 'terpesan'),
(123, 1, 11, NULL, 'KB523', '2025-05-12', '2025-05-12', '2025-05-13', '200.000', 'terpesan'),
(124, 21, 5, NULL, 'KB864', '2025-05-13', '2025-05-13', '2025-05-14', '210.000', 'dibatalkan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_history`
--

CREATE TABLE `tb_history` (
  `id_history` int NOT NULL,
  `kode_booking` varchar(10) NOT NULL,
  `id_booking` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_history`
--

INSERT INTO `tb_history` (`id_history`, `kode_booking`, `id_booking`, `created_at`) VALUES
(97, 'KB427', 114, '2025-05-12 03:06:36'),
(98, 'KB437', 115, '2025-05-12 03:26:58'),
(99, 'KB398', 116, '2025-05-12 03:27:11'),
(100, 'KB045', 117, '2025-05-12 03:27:32'),
(101, 'KB942', 118, '2025-05-12 03:27:41'),
(102, 'KB309', 119, '2025-05-12 03:30:50'),
(103, 'KB739', 120, '2025-05-12 03:31:00'),
(104, 'KB044', 121, '2025-05-12 03:31:09'),
(105, 'KB147', 122, '2025-05-12 03:31:18'),
(106, 'KB523', 123, '2025-05-12 03:31:26'),
(107, 'KB864', 124, '2025-05-13 07:59:18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_promo`
--

CREATE TABLE `tb_promo` (
  `id` int NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` enum('fixed','percentage') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_promo`
--

INSERT INTO `tb_promo` (`id`, `code`, `type`, `value`, `start_date`, `end_date`) VALUES
(2, 'ELJIEHOTEL7', 'percentage', '20.00', '2025-05-03', '2026-02-25'),
(4, 'ELJIEPROMO9', 'percentage', '9.00', '2025-05-03', '2026-05-14'),
(5, 'ELJIEPROMO10', 'percentage', '10.00', '2025-05-03', '2026-02-03'),
(6, 'ELJIEPROMO1', 'percentage', '12.00', '2025-05-03', '2026-02-28'),
(7, 'ELJIEPROMO2', 'percentage', '14.00', '2025-05-08', '2026-06-09');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rooms`
--

CREATE TABLE `tb_rooms` (
  `id_room` int NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `price` decimal(10,3) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('tersedia','terisi','maintenance') NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_rooms`
--

INSERT INTO `tb_rooms` (`id_room`, `room_type`, `price`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Deluxe', '210.000', 'frames-for-your-heart-FqqiAvJejto-unsplash (1).jpg', 'tersedia', '2025-04-30 02:42:16', '2025-05-01 09:27:29'),
(6, 'Suite', '270.000', 'moksha-jain-PoSPwUpv9IY-unsplash.jpg', 'tersedia', '2025-04-30 02:44:32', '2025-05-01 09:27:22'),
(7, 'VIP', '331.000', 'jenevy-vergara-8hGJaAJyzIg-unsplash.jpg', 'tersedia', '2025-04-30 02:45:15', '2025-05-01 09:27:16'),
(9, 'Standard', '100.000', 'sasha-kaunas-67-sOi7mVIk-unsplash.jpg', 'tersedia', '2025-04-30 02:50:14', '2025-05-03 13:04:53'),
(11, 'Deluxe Primary', '200.000', 'alex-muzenhardt-4MQ0T4zBIys-unsplash.jpg', 'tersedia', '2025-05-06 05:57:38', '2025-05-06 05:57:38');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id_user`, `username`, `password`, `email`, `no_hp`) VALUES
(1, 'SuciAwalia', 'suciawalia12', 'suciawalia@gmail.com', '081244323544'),
(20, 'Moh. Benny Irawan', 'benny12', 'benny@gmail.com', '081244323544'),
(21, 'matthew', 'metyu12', 'metyutupamahu84@gmail.com', '083344223535');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tb_bookings`
--
ALTER TABLE `tb_bookings`
  ADD PRIMARY KEY (`id_bookings`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_room` (`id_room`),
  ADD KEY `fk_id_promo` (`id`);

--
-- Indexes for table `tb_history`
--
ALTER TABLE `tb_history`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `tb_history_ibfk_1` (`id_booking`);

--
-- Indexes for table `tb_promo`
--
ALTER TABLE `tb_promo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_rooms`
--
ALTER TABLE `tb_rooms`
  ADD PRIMARY KEY (`id_room`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_bookings`
--
ALTER TABLE `tb_bookings`
  MODIFY `id_bookings` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `tb_history`
--
ALTER TABLE `tb_history`
  MODIFY `id_history` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `tb_promo`
--
ALTER TABLE `tb_promo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_rooms`
--
ALTER TABLE `tb_rooms`
  MODIFY `id_room` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_bookings`
--
ALTER TABLE `tb_bookings`
  ADD CONSTRAINT `fk_id_promo` FOREIGN KEY (`id`) REFERENCES `tb_promo` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tb_bookings_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_bookings_ibfk_2` FOREIGN KEY (`id_room`) REFERENCES `tb_rooms` (`id_room`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_bookings_ibfk_3` FOREIGN KEY (`id`) REFERENCES `tb_promo` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tb_history`
--
ALTER TABLE `tb_history`
  ADD CONSTRAINT `tb_history_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `tb_bookings` (`id_bookings`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
