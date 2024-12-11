-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el7.remi
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 10, 2024 at 11:25 PM
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
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `Volunteer_ID` int(11) NOT NULL,
  `Volunteer_fname` varchar(255) NOT NULL,
  `Volunteer_lname` varchar(255) NOT NULL,
  `Volunteer_phone_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`Volunteer_ID`, `Volunteer_fname`, `Volunteer_lname`, `Volunteer_phone_number`) VALUES
(222222, 'John', 'FakePerson', 2147483647),
(333333, 'Mary', 'Elliot', 2147483647),
(444444, 'Emma', 'Lei', 2147483647),
(555555, 'Taylor', 'Sift', 2147483647),
(666666, 'Aaron', 'Parsons', 2147483647),
(743658, 'Lucy', 'Ball', 2147483647),
(777777, 'Joe', 'Swole', 2147483647),
(888888, 'Paul', 'Person', 2147483647),
(999999, 'John', 'Volunteer', 2147483647),
(2147483647, 'B', 'LLL', 1235235365);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`Volunteer_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
