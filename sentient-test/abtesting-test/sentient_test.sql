-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2017 at 03:05 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sentient_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `sentient_design`
--

CREATE TABLE `sentient_design` (
  `design_id` int(10) UNSIGNED NOT NULL,
  `design_name` text,
  `split_percent` float NOT NULL,
  `design_template` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sentient_design`
--

INSERT INTO `sentient_design` (`design_id`, `design_name`, `split_percent`, `design_template`) VALUES
(1, 'Design 1', 50, 'template_one'),
(2, 'Design 2', 25, 'template_two'),
(3, 'Design 3', 25, 'template_three');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sentient_design`
--
ALTER TABLE `sentient_design`
  ADD PRIMARY KEY (`design_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sentient_design`
--
ALTER TABLE `sentient_design`
  MODIFY `design_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
