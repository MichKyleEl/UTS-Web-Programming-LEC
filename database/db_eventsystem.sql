-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 08:42 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_eventsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_event`
--

CREATE TABLE `tb_event` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` text DEFAULT NULL,
  `event_date` varchar(50) NOT NULL,
  `event_time` varchar(50) NOT NULL,
  `event_location` varchar(100) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `event_image` varchar(200) DEFAULT NULL,
  `event_banner` varchar(200) DEFAULT NULL,
  `event_status` enum('open','closed','canceled') DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_event`
--

INSERT INTO `tb_event` (`event_id`, `event_name`, `event_description`, `event_date`, `event_time`, `event_location`, `max_participants`, `event_image`, `event_banner`, `event_status`) VALUES
(1, 'AYCE Wingstop', 'Makan sepuasnya 2 jam', '27 September 2024', '13:00', 'Jakarta', 50, 'fotomakan.jpg', 'ayce.jpg', 'open'),
(2, 'HUT TNI', 'Bakal bikin macet seJakarta', '05 Oktober 2024', '08:00', 'Monumen Nasional', 2000, 'tnijaya.jpg', 'tni.png', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `tb_registration`
--

CREATE TABLE `tb_registration` (
  `registration_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_registration`
--

INSERT INTO `tb_registration` (`registration_id`, `user_id`, `event_id`, `registration_date`) VALUES
(1, 2, 1, '2024-10-05 19:50:31'),
(3, 4, 2, '2024-10-05 19:56:22'),
(5, 3, 1, '2024-10-21 17:30:48'),
(6, 3, 2, '2024-10-21 17:31:33'),
(7, 6, 2, '2024-10-21 18:40:33');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(100) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_name`, `user_email`, `user_password`, `role`, `created_at`, `foto`, `reset_token`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admingrup5thebest', 'admin', '2024-10-05 18:01:28', NULL, NULL),
(2, 'David Garcia Saragih', 'david@gmail.com', '$2y$10$h435hyEwytoitrPnHTFIZ.E8RksR.P1RE9sSNNShAKyZy10k6Bi2C', 'user', '2024-10-05 18:43:13', 'ASEAN.png', NULL),
(3, 'Michael Elbert', 'michael@gmail.com', '$2y$10$FwOzxf9B0CGr09tQCo9C5eA11nkzoYjWYFBGRU5pZtQOOo/8fYIyO', 'user', '2024-10-05 19:09:08', NULL, NULL),
(4, 'Ben Arief Sihotang', 'benarief@gmail.com', '$2y$10$sX49QKcCQPBPw3pbIKFuk.IgdFoDFuz8pfaPRGvskOf7t03XkLdCu', 'user', '2024-10-05 19:09:23', NULL, NULL),
(5, 'Calvi', 'calvin@gmail.com', '$2y$10$3KpaxdFso58DDWaTW.ZeuOY0zf34ZWe.KWKT8K.4A5xy0NmE9Z8Sm', 'user', '2024-10-20 13:27:46', 'channels4_profile.jpg', NULL),
(6, 'David Garcia Saragih', 'davidajagaraa94@gmail.com', '$2y$10$YqOSy4vl0k5d4BbrfuZTVefoKzW6mj31feNV0VpgR/fUXLxt1N8La', 'user', '2024-10-21 18:02:36', NULL, 'eab72bd0ad3518f1fa2f5b7ff8342eda55ff981f643a726ae74ec52866c4beac4aaf7029d84c46890b56327d9ef88ba13d06'),
(7, 'Ben Arifin', 'ben.arief@student.umn.ac.id', '$2y$10$OOtXEiiwaQlP52ibKxw/..FQUnf2PMRq9LEX8sdcQXrcFsxN7/3lG', 'user', '2024-10-21 18:39:23', NULL, '7ed4a78efe147882f548c1dfadab13ab613a1548fe48b30d844b8baac4a5c67970eaad54fa5a788bf87d4acab8ff3f85282b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tb_registration`
--
ALTER TABLE `tb_registration`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_registration`
--
ALTER TABLE `tb_registration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_registration`
--
ALTER TABLE `tb_registration`
  ADD CONSTRAINT `tb_registration_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_registration_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `tb_event` (`event_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
