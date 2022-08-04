-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2019 at 06:07 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pcs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `pcs_accounts`
--

CREATE TABLE `pcs_accounts` (
  `ID` int(11) NOT NULL,
  `User_ID` varchar(255) NOT NULL,
  `User_name` varchar(255) NOT NULL,
  `Full_name` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Level_db` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pcs_accounts`
--

INSERT INTO `pcs_accounts` (`ID`, `User_ID`, `User_name`, `Full_name`, `Password`, `Level_db`) VALUES
(1, '18-03686', 'Russel', 'Russel Masangkay', '-', 'User Account'),
(2, '123', 'Russel', 'Russel Masangkay', '-', 'User Account');

-- --------------------------------------------------------

--
-- Table structure for table `pcs_ircs_line`
--

CREATE TABLE `pcs_ircs_line` (
  `ID` int(11) NOT NULL,
  `line_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ircs_line` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pcs_ircs_line`
--

INSERT INTO `pcs_ircs_line` (`ID`, `line_name`, `ircs_line`) VALUES
(1, '6101', 'NISSAN_01'),
(2, '6102', 'NISSAN_02'),
(3, '6103', 'NISSAN_03'),
(4, '3110', 'HONDA_10'),
(5, '2107', 'DAIHATSU_07'),
(6, '1115', 'MAZDA_15'),
(7, '1130', 'MAZDA_30');

-- --------------------------------------------------------

--
-- Table structure for table `pcs_plan`
--

CREATE TABLE `pcs_plan` (
  `ID` int(11) NOT NULL,
  `Carmodel` varchar(255) NOT NULL,
  `Line` varchar(255) NOT NULL,
  `ID_No` varchar(255) NOT NULL,
  `Target` varchar(255) NOT NULL DEFAULT '0',
  `Actual_Target` varchar(255) NOT NULL DEFAULT '0',
  `Remaining_Target` varchar(255) NOT NULL DEFAULT '0',
  `date_db` varchar(255) NOT NULL,
  `time_db` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `old_target_DB` varchar(255) NOT NULL,
  `takt_time_DB` varchar(255) NOT NULL,
  `backup_date_time_DB` varchar(255) NOT NULL,
  `takt_time_minutes_DB` varchar(255) NOT NULL COMMENT 'seconds',
  `hh_DB` varchar(255) NOT NULL,
  `mm_DB` varchar(255) NOT NULL,
  `ss_DB` varchar(255) NOT NULL,
  `rem_status_DB` varchar(255) NOT NULL,
  `IRCS_Line` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pcs_plan`
--

INSERT INTO `pcs_plan` (`ID`, `Carmodel`, `Line`, `ID_No`, `Target`, `Actual_Target`, `Remaining_Target`, `date_db`, `time_db`, `Status`, `name`, `old_target_DB`, `takt_time_DB`, `backup_date_time_DB`, `takt_time_minutes_DB`, `hh_DB`, `mm_DB`, `ss_DB`, `rem_status_DB`, `IRCS_Line`) VALUES
(19, 'MAZDA MERGE', '1130', '', '650', '1649', '+999', '04/03/2019', '11:34:14 AM', 'Done', '123', '650', '00:00:00', '2019-4-03 11:34:14 AM', '0', '00', '00', '00', '', 'MAZDA_30'),
(20, 'Daihatsu', '2107', '', '50', '1429', '+1379', '04/03/2019', '05:46:15 PM', 'Done', '18-03686', '50', '00:00:00', '2019-4-03 05:46:15 PM', '0', '00', '00', '00', '', 'DAIHATSU_07'),
(21, 'MAZDA MERGE', '1130', '', '288', '729', '+445', '04/04/2019', '08:14:28 AM', 'Done', '123', '250', '00:01:00', '2019-4-04 08:14:29 AM', '1', '00', '01', '00', 'REMAINING: ', 'MAZDA_30'),
(22, 'MAZDA MERGE', '1130', '', '50', '0', '0', '04/04/2019', '05:20:28 PM', 'Done', '123', '50', '00:00:00', '2019-4-04 05:20:29 PM', '0', '00', '00', '00', '', 'MAZDA_30'),
(23, 'MAZDA MERGE', '1130', '', '60', '8669', '+8609', '04/04/2019', '05:20:48 PM', 'Done', '123', '60', '00:00:30', '2019-4-04 05:20:48 PM', '10', '00', '00', '30', '', 'MAZDA_30'),
(34, 'Mazda Merge', '1130', '', '4', '7', '+3', '04/10/2019', '02:48:46 PM', 'Done', '', '', '00:00:00', '2019-04-10 02:48:46 PM', '0', '00', '00', '00', '', 'MAZDA_30'),
(35, 'Mazda Merge', '1130', '', '77', '9', '68', '04/10/2019', '02:55:12 PM', 'Done', '', '', '00:00:00', '2019-04-10 02:55:12 PM', '0', '00', '00', '00', '', 'MAZDA_30'),
(36, 'Mazda Merge', '1130', '', '9', '0', '9', '04/10/2019', '03:16:39 PM', 'Done', '', '', '00:00:20', '2019-04-10 03:16:39 PM', '20', '00', '00', '20', '', 'MAZDA_30'),
(37, 'Mazda Merge', '1130', '', '1', '0', '1', '04/10/2019', '03:19:36 PM', 'Done', '', '', '00:00:00', '2019-04-10 03:19:36 PM', '0', '00', '00', '00', '', 'MAZDA_30'),
(38, 'Mazda Merge', '1130', '', '12', '0', '12', '04/10/2019', '03:19:54 PM', 'Done', '', '', '00:00:00', '2019-04-10 03:19:54 PM', '0', '00', '00', '00', '', 'MAZDA_30'),
(39, 'Mazda Merge', '1130', '', '6', '0', '6', '04/10/2019', '03:23:25 PM', 'Done', '', '', '00:00:00', '2019-04-10 03:23:25 PM', '0', '00', '00', '00', '', 'MAZDA_30'),
(40, 'Mazda Merge', '1130', '', '1', '0', '1', '04/10/2019', '03:25:07 PM', 'Done', '', '', '00:00:00', '2019-04-10 03:25:07 PM', '0', '00', '00', '00', '', 'MAZDA_30'),
(41, 'Mazda Merge', '1130', '', '224', '30', '194', '04/10/2019', '03:32:28 PM', 'Done', '', '', '00:00:05', '2019-04-10 03:32:28 PM', '5', '00', '00', '05', '', 'MAZDA_30'),
(42, 'Mazda Merge', '1130', '', '0', '12', '+12', '04/10/2019', '03:54:24 PM', 'Done', '', '', '00:00:00', '2019-04-10 03:54:24 PM', '0', '00', '00', '00', '', 'MAZDA_30'),
(43, 'Mazda Merge', '1130', '', '0', '144', '+144', '04/10/2019', '04:02:16 PM', 'Done', '', '', '00:00:00', '2019-04-10 04:02:16 PM', '0', '00', '00', '00', '', 'MAZDA_30'),
(44, 'Mazda Merge', '1130', '', '0', '0', '0', '04/10/2019', '05:35:30 PM', 'Done', '', '', '00:00:00', '2019-04-10 05:35:30 PM', '0', '00', '00', '00', '', 'MAZDA_30'),
(45, 'Mazda Merge', '1130', '', '1944', '1629', '315', '04/10/2019', '05:36:06 PM', 'Done', '', '', '00:00:05', '2019-04-10 05:36:06 PM', '5', '00', '00', '05', '', 'MAZDA_30'),
(46, 'Mazda Merge', '1130', '', '30', '2', '+2', '04/11/2019', '11:52:06 AM', 'Pending', '', '', '00:00:00', '2019-04-11 11:52:06 AM', '0', '00', '00', '00', '', 'MAZDA_30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pcs_accounts`
--
ALTER TABLE `pcs_accounts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pcs_ircs_line`
--
ALTER TABLE `pcs_ircs_line`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pcs_plan`
--
ALTER TABLE `pcs_plan`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pcs_accounts`
--
ALTER TABLE `pcs_accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pcs_ircs_line`
--
ALTER TABLE `pcs_ircs_line`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `pcs_plan`
--
ALTER TABLE `pcs_plan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
