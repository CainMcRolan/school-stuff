-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2024 at 05:11 AM
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
-- Database: `ledgerdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acc_num` int(11) NOT NULL,
  `acc_name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acc_num`, `acc_name`) VALUES
(1, 'Shimi'),
(2, 'Shania'),
(3, 'Lourdes');

-- --------------------------------------------------------

--
-- Table structure for table `chart`
--

CREATE TABLE `chart` (
  `acc_type` varchar(16) NOT NULL,
  `acc_name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chart`
--

INSERT INTO `chart` (`acc_type`, `acc_name`) VALUES
('Nathaniel', 'liability');

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `acc_number` int(11) NOT NULL,
  `acc_username` varchar(16) NOT NULL,
  `acc_date` date NOT NULL,
  `acc_desc` varchar(50) NOT NULL,
  `acc_debit` int(11) NOT NULL,
  `acc_credit` int(11) NOT NULL,
  `acc_balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`acc_number`, `acc_username`, `acc_date`, `acc_desc`, `acc_debit`, `acc_credit`, `acc_balance`) VALUES
(1, 'Shimi', '2024-02-01', 'Owners Account', 1000, 0, 1000),
(1, 'Shimi', '2024-02-01', 'Liability', 0, 100, 900),
(2, 'Shania', '2024-02-01', 'Owners Equity', 1000, 0, 1000),
(3, 'Lourdes', '2024-02-02', 'Owners Equity', 1000, 0, 1000),
(3, 'Lourdes', '2024-02-02', 'Owners Equity', 200, 0, 1200),
(3, 'Lourdes', '2024-02-02', 'Liability', 0, 300, 900);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD UNIQUE KEY `acc_num` (`acc_num`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
