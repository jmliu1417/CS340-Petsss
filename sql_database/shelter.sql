-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el7.remi
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 10, 2024 at 11:24 PM
-- Server version: 10.6.19-MariaDB-log
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs340_soma`
--

-- --------------------------------------------------------

--
-- Table structure for table `shelter`
--

CREATE TABLE `shelter` (
  `Shelter_ID` int(11) NOT NULL,
  `Shelter_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `State` varchar(255) NOT NULL,
  `Zip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `shelter`
--

INSERT INTO `shelter` (`Shelter_ID`, `Shelter_name`, `phone_number`, `Street`, `City`, `State`, `Zip`) VALUES
(1, 'Humane Corvallis', '5030000001', 'Washington Lane', 'Corvallis', 'OR', 97330),
(3, 'Humane Eugene', '5030000003', 'Jefferson Lane', 'Eugene', 'OR', 97402),
(4, 'Humane Bend', '5030000004', 'Madison Lane', 'Benddd', 'OR', 97701),
(5, 'Humane Albany', '5030000005', 'Monroe Lane', 'Albany', 'OR', 97322),
(6, 'Humane Beaverton', '5030000006', 'Quincy Lane', 'Beaverton', 'OR', 97076),
(7, 'Humane Hillsboro', '5030000007', 'Jackson Lane', 'Hillsboro', 'OR', 97129),
(8, 'Humane Happy Valley', '5030000008', 'Van Buren Lane', 'Happy Valley', 'OR', 97089),
(9, 'Humane Canby', '5030000009', 'Harrison Lane', 'Canby', 'OR', 97013),
(10, 'Lovely Pet', '3467778888', 'SE Street', 'Corvallis', 'Oregon', 88333),
(12, 'We love pets', '111111111', 'somethwere', 'Corvallis', 'OR', 97330);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shelter`
--
ALTER TABLE `shelter`
  ADD PRIMARY KEY (`Shelter_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
