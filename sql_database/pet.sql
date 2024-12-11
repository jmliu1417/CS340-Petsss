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
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `Pet_ID` int(11) NOT NULL,
  `Pet_name` varchar(255) NOT NULL,
  `Pet_type` varchar(255) NOT NULL,
  `Pet_breed` varchar(255) NOT NULL,
  `Pet_age` int(11) NOT NULL,
  `Pet_time` date NOT NULL,
  `Pet_status` varchar(255) NOT NULL,
  `Shelter_ID` int(11) DEFAULT NULL,
  `Adopter_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`Pet_ID`, `Pet_name`, `Pet_type`, `Pet_breed`, `Pet_age`, `Pet_time`, `Pet_status`, `Shelter_ID`, `Adopter_ID`) VALUES
(5, 'Garfield', 'cat', 'siamese', 1, '2024-12-08', 'Adopted', NULL, 1),
(7, 'Molly', 'collie', 'f', 4, '2024-01-14', 'Adopted', NULL, 3),
(8, 'Orange', 'guinea pig', 'small', 2, '0000-00-00', 'Sheltered', 9, NULL),
(9, 'Mila', 'dog', 'poodle', 14, '2024-07-26', 'Adopted', NULL, 4),
(10, 'Sarah', 'cat', 'tabby', 9, '0000-00-00', 'Sheltered', 3, NULL),
(17, 'Joe', 'Dog', 'Lab', 2, '0000-00-00', 'Adopted', NULL, 3),
(28, 'H', 'H', 'H', 3, '0000-00-00', 'Sheltered', 10, NULL),
(100, 'Jessie', 'Cat', 'domestic shorthair', 5, '0000-00-00', 'Adopted', NULL, 4),
(123, 'JIII', 'Cat', 'Shorthair', 1, '2024-12-08', 'Adopted', NULL, 1),
(5858, 'OIOO', 'Cat', 'longhair', 2, '0000-00-00', 'Sheltered', 1, NULL),
(12331, 'Asda', 'Cat', 'Cat', 12, '0000-00-00', 'Sheltered', 1, NULL),
(123123, 'HHH', 'HHH', 'HHH', 13, '0000-00-00', 'Adopted', 1, NULL),
(12314123, 'Missy', 'Cat', 'domestic shorthair', 11, '0000-00-00', 'Adopted', NULL, 1);

--
-- Triggers `pet`
--
DELIMITER $$
CREATE TRIGGER `remove_shelter_id_insert` BEFORE INSERT ON `pet` FOR EACH ROW BEGIN
    IF NEW.Pet_status = 'Adopted' THEN
        SET NEW.Shelter_id = NULL;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `remove_shelter_id_update` BEFORE UPDATE ON `pet` FOR EACH ROW BEGIN
    IF NEW.Pet_status = 'Adopted' THEN
        SET NEW.Shelter_id = NULL;
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`Pet_ID`),
  ADD KEY `Shelter_ID` (`Shelter_ID`),
  ADD KEY `Adopter_ID` (`Adopter_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `pet_ibfk_1` FOREIGN KEY (`Shelter_ID`) REFERENCES `shelter` (`Shelter_ID`),
  ADD CONSTRAINT `pet_ibfk_2` FOREIGN KEY (`Adopter_ID`) REFERENCES `adopter` (`Adopter_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
