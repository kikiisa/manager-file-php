-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 07:55 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manager_file`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `username` varchar(75) NOT NULL,
  `name` varchar(75) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `name`, `password`) VALUES
(1, 'jodi', 'Jodi Binolombangan', '8d9a90a08e1fd8de1a1efe902016d02e');

-- --------------------------------------------------------

--
-- Table structure for table `file_upload`
--

CREATE TABLE `file_upload` (
  `id` int(255) NOT NULL,
  `nama_file` varchar(75) NOT NULL,
  `path_file` varchar(75) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_upload`
--

INSERT INTO `file_upload` (`id`, `nama_file`, `path_file`, `keterangan`) VALUES
(17, 'Ngobrol Engineer \"Di Balik Teknologi CHAT GPT\"', '656fdc2980e2b_baner_yayasan.jpg', 'testing'),
(18, 'dkfdjfkj', '656fdca7e00d4_biodata_ibu_teti.docx', 'kdfjdkfjk'),
(19, 'Testtt', '656fdcf45b2f7_GCCITXME_Pweb1.pdf', 'jodi bgst'),
(20, 'foto sexi', '6571f277ab222_Screenshot_28.png', 'salahudin sexi'),
(21, '', '6571f2a29c72c_', ''),
(22, 'Fiksi', '6572106e06e9c_aldi-proposal-print.pdf', 'sdjskdjskjk');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_upload`
--
ALTER TABLE `file_upload`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `file_upload`
--
ALTER TABLE `file_upload`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
