-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 22, 2020 at 09:57 AM
-- Server version: 5.7.19
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mycompany`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `userType` varchar(50) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `firstName`, `lastName`, `email`, `password`, `userType`) VALUES
(23, 'Konstantina', 'iliopoulou', 'k.iliopoulou1@gmail.com', '0000', 'admin'),
(24, 'Kon', 'Iliop', 'iliopkon.1@gmail.com', '', 'employee'),
(28, 'john', 'papadop', 'john@something.gr', '', 'employee'),
(29, 'maria', 'eleutheriou', 'maria@something.com', '123', 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `vacation`
--

DROP TABLE IF EXISTS `vacation`;
CREATE TABLE IF NOT EXISTS `vacation` (
  `vID` int(100) NOT NULL AUTO_INCREMENT,
  `startingDate` date NOT NULL,
  `endDate` date NOT NULL,
  `reason` text NOT NULL,
  `submitDate` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `uID` int(11) NOT NULL,
  PRIMARY KEY (`vID`),
  KEY `uID` (`uID`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vacation`
--

INSERT INTO `vacation` (`vID`, `startingDate`, `endDate`, `reason`, `submitDate`, `status`, `uID`) VALUES
(49, '2020-06-01', '2020-06-04', '', '2020-6-21', 'rejected', 24),
(50, '2020-06-01', '2020-06-03', '', '2020-6-21', 'approved', 24),
(51, '2020-06-17', '2020-06-24', '', '2020-6-21', 'approved', 24),
(52, '2020-06-17', '2020-06-24', '', '2020-6-21', 'approved', 24),
(53, '2020-06-01', '2020-06-10', '', '2020-6-22', 'pending', 24),
(54, '2020-06-15', '2020-06-19', '', '2020-6-22', 'pending', 24),
(55, '2020-06-16', '2020-06-24', '', '2020-6-22', 'rejected', 24),
(56, '2020-06-16', '2020-06-24', '', '2020-6-22', 'rejected', 24),
(57, '2020-06-16', '2020-06-24', '', '2020-6-22', 'rejected', 24),
(58, '2020-06-16', '2020-06-24', '', '2020-6-22', 'rejected', 24),
(59, '2020-06-16', '2020-06-24', '', '2020-6-22', 'rejected', 24),
(60, '2020-06-16', '2020-06-24', '', '2020-6-22', 'rejected', 24);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vacation`
--
ALTER TABLE `vacation`
  ADD CONSTRAINT `vacation_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
