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
-- Table structure for table `adopter`
--

CREATE TABLE `adopter` (
  `Adopter_ID` int(11) NOT NULL,
  `Adopter_fname` varchar(255) NOT NULL,
  `Adopter_lname` varchar(255) NOT NULL,
  `Adopter_dob` date NOT NULL,
  `Street` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `State` varchar(255) NOT NULL,
  `Zip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `adopter`
--

INSERT INTO `adopter` (`Adopter_ID`, `Adopter_fname`, `Adopter_lname`, `Adopter_dob`, `Street`, `City`, `State`, `Zip`) VALUES
(1, 'Jamie', 'Liu', '2004-02-09', '1300 NW captain STT', 'Newberg', 'OR', 92548),
(3, 'Chied', 'Bu', '2004-01-10', '4500 SE Chaselon St', 'Newport', 'OR', 97884),
(4, 'Kelly', 'Lam', '1998-02-17', '1250 SW Wintom St', 'Vancouver', 'WA', 93500),
(5, 'Cale', 'Shu', '2004-06-19', '1300 NE Kely St', 'Portland', 'OR', 97001),
(6, 'Sandra', 'Castillo', '2005-11-07', '1700 NE Angel St', 'Woodburn', 'OR', 94552),
(8, 'Barbara', 'Helfrich', '2000-12-02', '948 Peoria Drive', 'Carson City', 'Nevadaq', 84729),
(19, 'Bessie', 'Hahaha', '2024-12-08', '123NW', 'C', 'OR', 97330),
(238, 'Brad', 'ddf', '2025-01-04', '12463 Ne Carleis', 'Corva', 'Oregon', 34444),
(373, 'Carlw', 'she', '2024-10-30', '14432 EF Car', 'Corvallis', 'Oregon', 22222),
(377, 'Carlie', 'she', '2024-11-14', '14432 EF Car', 'Corvallis', 'Oregon', 55555);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adopter`
--
ALTER TABLE `adopter`
  ADD PRIMARY KEY (`Adopter_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
