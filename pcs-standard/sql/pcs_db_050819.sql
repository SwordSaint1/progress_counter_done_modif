-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2019 at 06:40 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

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
(7, '1130', 'MAZDA_30'),
(8, '2102', 'DAIHATSU_02');

-- --------------------------------------------------------

--
-- Table structure for table `pcs_plan`
--

CREATE TABLE `pcs_plan` (
  `ID` int(11) NOT NULL,
  `Carmodel` varchar(255) NOT NULL,
  `Line` varchar(255) NOT NULL,
  `ID_No` varchar(255) NOT NULL,
  `Target` int(255) NOT NULL DEFAULT '0',
  `Actual_Target` int(255) NOT NULL DEFAULT '0',
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
(1, 'Mazda Merge', '1130', '', 16, 0, '16', '04/11/2019', '01:07:57 PM', 'Done', '', '', '00:00:05', '2019-04-11 01:07:57 PM', '5', '00', '00', '05', '', 'MAZDA_30'),
(2, 'Daihatsu', '2102', '', 0, 10, '+10', '04/26/2019', '08:25:32 AM', 'Done', '', '', '00:00:00', '2019-04-26 08:25:32 AM', '0', '00', '00', '00', '', 'DAIHATSU_02'),
(3, 'Daihatsu', '2102', '', 39, 7, '32', '04/26/2019', '08:34:13 AM', 'Done', '', '', '00:00:05', '2019-04-26 08:34:13 AM', '5', '00', '00', '05', '', 'DAIHATSU_02'),
(4, 'Daihatsu', '2102', '', 0, 0, '0', '04/26/2019', '08:38:53 AM', 'Done', '', '', '00:00:00', '2019-04-26 08:38:53 AM', '0', '00', '00', '00', '', 'DAIHATSU_02'),
(5, 'Daihatsu', '2102', '', 0, 0, '0', '04/26/2019', '08:39:19 AM', 'Done', '', '', '00:00:00', '2019-04-26 08:39:19 AM', '0', '00', '00', '00', '', 'DAIHATSU_02'),
(6, 'Mazda Merge', '1130', '', 0, 11, '+11', '04/26/2019', '08:40:05 AM', 'Done', '', '', '00:00:00', '2019-04-26 08:40:05 AM', '0', '00', '00', '00', '', 'MAZDA_30'),
(7, 'Daihatsu', '2102', '', 213, 18, '195', '04/26/2019', '08:40:34 AM', 'Done', '', '', '00:00:05', '2019-04-26 08:40:34 AM', '5', '00', '00', '05', '', 'DAIHATSU_02'),
(8, 'Mazda Merge', '1130', '', 48, 12, '36', '04/26/2019', '08:57:56 AM', 'Done', '', '', '00:00:05', '2019-04-26 08:57:56 AM', '5', '00', '00', '05', '', 'MAZDA_30'),
(9, 'Mazda Merge', '1130', '', 49, 0, '49', '04/26/2019', '03:15:07 PM', 'Done', '', '', '00:00:05', '2019-04-26 03:15:07 PM', '5', '00', '00', '05', '', 'MAZDA_30'),
(10, 'Daihatsu', '2102', '', 24, 3, '21', '04/26/2019', '03:21:36 PM', 'Done', '', '', '00:00:05', '2019-04-26 03:21:36 PM', '5', '00', '00', '05', '', 'DAIHATSU_02'),
(11, 'Daihatsu', '2102', '', 6, 2807, '+2801', '04/26/2019', '03:25:14 PM', 'Done', '', '', '00:00:05', '2019-04-26 03:25:14 PM', '5', '00', '00', '05', '', 'DAIHATSU_02'),
(12, 'Daihatsu', '2102', '', 202, 5, '197', '05/02/2019', '01:25:34 PM', 'Done', '', '', '00:00:05', '2019-05-02 01:25:34 PM', '5', '00', '00', '05', '', 'DAIHATSU_02'),
(13, 'Daihatsu', '2102', '', 1, 3, '+2', '05/02/2019', '01:51:44 PM', 'Done', '', '', '00:02:17', '2019-05-02 01:51:44 PM', '137', '00', '02', '17', '', 'DAIHATSU_02'),
(14, 'Daihatsu', '2102', '', 0, 0, '0', '05/02/2019', '01:54:35 PM', 'Done', '', '', '00:00:10', '2019-05-02 01:54:35 PM', '10', '00', '00', '10', '', 'DAIHATSU_02'),
(15, 'Daihatsu', '2102', '', 7, 1, '6', '05/02/2019', '01:58:12 PM', 'Done', '', '', '00:00:10', '2019-05-02 01:58:12 PM', '10', '00', '00', '10', '', 'DAIHATSU_02'),
(16, 'Daihatsu', '2102', '', 12, 0, '12', '05/02/2019', '01:58:40 PM', 'Done', '', '', '00:00:10', '2019-05-02 01:58:40 PM', '10', '00', '00', '10', '', 'DAIHATSU_02'),
(17, 'Daihatsu', '2102', '', 12, 1, '11', '05/02/2019', '01:59:33 PM', 'Done', '', '', '00:00:10', '2019-05-02 01:59:33 PM', '10', '00', '00', '10', '', 'DAIHATSU_02'),
(18, 'Daihatsu', '2102', '', 8, 0, '8', '05/02/2019', '02:00:45 PM', 'Done', '', '', '00:00:10', '2019-05-02 02:00:45 PM', '10', '00', '00', '10', '', 'DAIHATSU_02'),
(19, 'Daihatsu', '2102', '', 9, 0, '9', '05/02/2019', '02:00:52 PM', 'Done', '', '', '00:00:00', '2019-05-02 02:00:52 PM', '0', '00', '00', '00', '', 'DAIHATSU_02'),
(20, 'Daihatsu', '2102', '', 2, 0, '2', '05/06/2019', '08:28:20 AM', 'Done', '', '', '00:00:05', '2019-05-06 08:28:20 AM', '5', '00', '00', '05', '', 'DAIHATSU_02'),
(21, 'Daihatsu', '2102', '', 30, 2, '27', '05/06/2019', '08:28:57 AM', 'Done', '', '', '00:00:05', '2019-05-06 08:28:57 AM', '5', '00', '00', '05', '', 'DAIHATSU_02'),
(23, 'Daihatsu', '2102', '', 9, 480, '+471', '05/06/2019', '', 'Done', '', '', '00:00:10', '2019-05-06 11:26:45 AM', '10', '00', '00', '10', '', 'DAIHATSU_02'),
(24, 'Daihatsu', '2102', '', 0, 482, '+482', '05/06/2019', '', 'Done', '', '', '00:00:00', '2019-05-06 11:31:56 AM', '0', '00', '00', '00', '', 'DAIHATSU_02'),
(25, 'Nissan', '6101', '', 168, 90, '78', '05/06/2019', '', 'Done', '', '', '00:00:20', '2019-05-06 03:29:23 PM', '20', '00', '00', '20', '', 'NISSAN_01'),
(26, 'Nissan', '6101', '', 22, 7, '15', '05/08/2019', '', 'Done', '', '', '00:00:05', '2019-05-08 09:48:31 AM', '5', '00', '00', '05', '', 'NISSAN_01'),
(27, 'Nissan', '6101', '', 144, 41, '103', '05/08/2019', '', 'Pending', '', '', '00:01:00', '2019-05-08 09:51:55 AM', '60', '00', '01', '00', '', 'NISSAN_01');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pcs_plan`
--
ALTER TABLE `pcs_plan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
