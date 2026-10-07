-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2026 at 06:30 AM
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
-- Database: `myprojdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES
(1, 'Spongeboy', 'spongebob@gmail.com', '09171234567', '2026-10-01 03:15:31'),
(2, 'Sandy Cheels', 'sandycheeks@gmail.com', '09182345678', '2026-10-01 03:15:31'),
(3, 'Patrick Star', 'starpatrick@gmail.com', '09193456789', '2026-10-01 03:15:31'),
(4, 'Plankton', 'planktonton@gmail.com', '09204567890', '2026-10-01 03:15:31'),
(5, 'Squiward Tentacles', 'squidwardtentacles@gmail.com', '09215678901', '2026-10-01 03:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `avatar`, `created_at`) VALUES
(1, 'rarmy', '$2y$10$MbWnDvyzzoTyCjFEn.qIMO2Dm1sFCIRwt/0ojwGZe72Hm5ZRge.JW', 'Carmy Berzatto', 'avatar_cfe26378db9d22ee382512e6bff3d48b.jpg', '2026-10-01 03:15:31'),
(2, 'richie', '$2y$10$6RTVmb0gIuMNQJUmR.HnEep3RzFMXhGf7fWdxcofdC./JebwSfH2W', 'Richie Jerimovich', 'avatar_a897488534eacc6a1c4dd4e845b8cd46.jpg', '2026-10-01 03:15:31'),
(3, 'syd', '$2y$10$xp6G4Y6nE7Cc4rKV9LPqaenz7lHHpjgRhJfklPA/huspf2UsJ3Y/K', 'Sydney Adamu', 'avatar_78c6eec31a28ab3080e9146b97ac7427.jpg', '2026-10-01 03:15:31'),
(4, 'marcus', '$2y$10$5T.CzXUYqfh8QC1meXp7cuUAlH/9vwNwHrEGkmLVYCyJC.S.VdRPi', 'Marcus Brooks', 'avatar_add7d9ad3986165830aa35e8c72b8d36.jpg', '2026-10-01 03:15:31'),
(5, 'natalie', '$2y$10$PiEjzkCFfehkrN1QEKLrKOeb76cMSW27YBPiMd6OPaTkBIf02HjUa', 'Natalie Berzatto', 'avatar_1046d999ed0d939f09c5357b9cadac87.jpg', '2026-10-01 03:15:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
