-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 22, 2020 at 03:31 PM
-- Server version: 5.7.22-log
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tavex_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(20) NOT NULL,
  `service_name` varchar(120) NOT NULL COMMENT 'Service Name',
  `owner` varchar(120) NOT NULL COMMENT 'Owner',
  `description` text NOT NULL COMMENT 'Description',
  `created_at` bigint(20) NOT NULL COMMENT 'Created date',
  `updated_at` bigint(20) NOT NULL COMMENT 'Modified Date',
  `created_by` int(20) NOT NULL COMMENT 'Creator ID',
  `status` int(1) NOT NULL COMMENT 'Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `service_name`, `owner`, `description`, `created_at`, `updated_at`, `created_by`, `status`) VALUES
(1, 'edited_daily_cron_01', 'Joey Wong', 'this is a cron service', 1608564657, 1608606790, 6, 0),
(2, 'Edited_Service_201221113115', 'Test Editor', 'Edited by test editor', 1608564675, 1608564675, 1, 1),
(3, 'Edited_Service_201221113150', 'Edited_Service_201221113150', 'Edited by test editor', 1608564710, 1608569483, 6, 0),
(6, 'Edited_Service_201222013157', 'Codeception', 'Edited by test editor', 1608571917, 1608571918, 10, 1),
(7, 'test_service_01', 'test_service_01', 'test_service_01', 1608602985, 1608603531, 3, 1),
(8, 'test_service_02345', 'test_service_02345', '312312', 1608603027, 1608604314, 6, 0),
(9, 'Joey_service', 'Joey_service', 'joey description\n', 1608604403, 1608604403, 6, 1),
(10, 'daily_cron_01', 'Joey Wong', 'this is a cron service', 1608606526, 1608606526, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(20) NOT NULL COMMENT 'Id',
  `display_name` varchar(120) NOT NULL COMMENT 'Display Name',
  `created_at` bigint(20) NOT NULL COMMENT 'Created Date',
  `updated_at` bigint(20) NOT NULL COMMENT 'Update Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'Anna', 20201220094354, 20201220094354),
(2, 'Bill', 20201220094539, 20201220094539),
(3, 'Darja', 20201220094539, 20201220094539),
(4, 'Eliise', 20201220094737, 20201220094737),
(5, 'Gaabriel', 20201220094737, 20201220094737),
(6, 'Hillar', 20201220094812, 20201220094812),
(7, 'Jaak', 20201220094812, 20201220094812),
(8, 'Mihkel', 20201220094906, 20201220094906),
(9, 'Priit', 20201220094906, 20201220094906),
(10, 'Taevas', 20201220094932, 20201220094932);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_name_idx` (`service_name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
