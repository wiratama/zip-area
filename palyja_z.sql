-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2016 at 09:14 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_palyja`
--

-- --------------------------------------------------------

--
-- Table structure for table `palyja_z`
--

DROP TABLE IF EXISTS `palyja_z`;
CREATE TABLE IF NOT EXISTS `palyja_z` (
`ID` int(11) NOT NULL,
  `street_name` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `area_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `palyja_z`
--
ALTER TABLE `palyja_z`
 ADD PRIMARY KEY (`ID`), ADD KEY `z_id` (`ID`), ADD KEY `zip` (`zip`), ADD KEY `area_id` (`area_id`), ADD KEY `street_name` (`street_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `palyja_z`
--
ALTER TABLE `palyja_z`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
