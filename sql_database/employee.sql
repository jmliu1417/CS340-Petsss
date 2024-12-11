-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el7.remi
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 10, 2024 at 11:21 PM
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
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `Employee_ID` int(11) NOT NULL,
  `Employee_fname` varchar(255) NOT NULL,
  `Employee_lname` varchar(255) NOT NULL,
  `Employee_pos` varchar(255) NOT NULL,
  `Employee_salary` int(11) NOT NULL,
  `Employee_Phone_number` int(11) NOT NULL,
  `Employee_Age` int(11) NOT NULL,
  `Manager_id` int(11) DEFAULT NULL,
  `Shelter_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Employee_ID`, `Employee_fname`, `Employee_lname`, `Employee_pos`, `Employee_salary`, `Employee_Phone_number`, `Employee_Age`, `Manager_id`, `Shelter_ID`) VALUES
(1, 'Nicola', 'Star', 'Manager', 70000, 123123123, 26, NULL, 5),
(2, 'Sara', 'Sara', 'caretaker', 40000, 556567234, 30, 1, 6),
(4, 'Paige', 'Jeffry', 'Manager', 70000, 971395678, 24, NULL, 1),
(7, 'Liam', 'Wilson', 'caretaker', 42000, 2147483647, 29, 4, 5),
(8, 'Moira', 'Jana', 'veterinarian', 70000, 503987465, 31, 4, 6),
(9, 'Farrah', 'Aled', 'caretaker', 40000, 724485193, 22, 4, 8),
(10, 'Sophia', 'Brown', 'receptionist', 40000, 2147483647, 35, 4, 9),
(12, 'Emily', 'White', 'Manager', 70000, 123123123, 24, NULL, 5),
(13, 'HI', 'HI', 'HI', 20000, 1122334456, 39, 1, 12),
(122, 'UwU', 'IvI', 'idk', 70000, 1011010101, 23, 12, 5),
(18888, 'Lo', 'Lf', 'Asda', 70000, 1233748212, 20, 4, 1),
(1231233, 'PO', 'BO', 'asad', 70000, 1234728391, 39, NULL, 1);

--
-- Triggers `employee`
--
DELIMITER $$
CREATE TRIGGER `restrict_manager_id` BEFORE INSERT ON `employee` FOR EACH ROW BEGIN
    IF NEW.Manager_id = NEW.Employee_ID THEN
        SET NEW.Manager_id = NULL;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `restrict_manger_id_update` BEFORE UPDATE ON `employee` FOR EACH ROW BEGIN
    IF NEW.Manager_id = NEW.Employee_ID THEN
        SET NEW.Manager_id = NULL;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `restrict_money` BEFORE UPDATE ON `employee` FOR EACH ROW BEGIN
    IF NEW.Employee_salary > 70000 THEN
        SET NEW.Employee_salary = 70000;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `restrict_salary` BEFORE INSERT ON `employee` FOR EACH ROW BEGIN
    IF NEW.Employee_salary > 70000 THEN
        SET NEW.Employee_salary = 70000;
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`Employee_ID`),
  ADD KEY `Manager_id` (`Manager_id`),
  ADD KEY `fk_Shelter_ID` (`Shelter_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`Manager_id`) REFERENCES `employee` (`Employee_ID`),
  ADD CONSTRAINT `fk_Shelter_ID` FOREIGN KEY (`Shelter_ID`) REFERENCES `shelter` (`Shelter_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
