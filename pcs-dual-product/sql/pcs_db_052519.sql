-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2019 at 07:22 AM
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
(8, '2102', 'DAIHATSU_02'),
(9, '3107', 'HONDA_05'),
(10, '3129', 'HONDA_32'),
(11, '3128', 'HONDA_33'),
(12, '3126', 'HONDA_34'),
(13, '1008', 'MAZDA_16_1'),
(14, '1032', 'MAZDA_53'),
(15, '5105', 'SUZUKI_04'),
(16, '5006', 'SUZUKI_24'),
(17, '5108', 'SUZUKI_12'),
(18, '5110', 'SUZUKI_19'),
(19, '5111', 'SUZUKI_20'),
(20, '5112', 'SUZUKI_21'),
(21, '5015', 'SUZUKI_33'),
(22, '5121', 'SUZUKI_51'),
(23, '5022', 'SUZUKI_54');

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
  `Status` varchar(255) NOT NULL,
  `IRCS_Line` varchar(255) NOT NULL,
  `lot_no` varchar(1024) NOT NULL,
  `datetime_DB` datetime DEFAULT NULL,
  `ended_DB` datetime DEFAULT NULL,
  `takt_secs_DB` int(11) NOT NULL,
  `last_takt_DB` int(11) NOT NULL,
  `last_update_DB` datetime NOT NULL,
  `actual_start_DB` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pcs_plan`
--

INSERT INTO `pcs_plan` (`ID`, `Carmodel`, `Line`, `ID_No`, `Target`, `Actual_Target`, `Remaining_Target`, `Status`, `IRCS_Line`, `lot_no`, `datetime_DB`, `ended_DB`, `takt_secs_DB`, `last_takt_DB`, `last_update_DB`, `actual_start_DB`) VALUES
(30, 'Nissan', '6101', '', 9, 62, '+53', 'Done', 'NISSAN_01', '', '2019-05-08 14:25:05', NULL, 5, 5, '2019-05-08 14:26:07', '2019-05-08 08:00:00'),
(31, 'Nissan', '6101', '', 8, 62, '+54', 'Done', 'NISSAN_01', '', '2019-05-08 14:26:12', NULL, 5, 5, '2019-05-08 14:26:57', '2019-05-08 08:00:00'),
(32, 'Nissan', '6101', '', 44, 65, '+21', 'Done', 'NISSAN_01', '', '2019-05-08 14:27:01', NULL, 5, 5, '2019-05-08 14:32:39', '2019-05-08 08:00:00'),
(33, 'Nissan', '6101', '', 51, 79, '28', 'Done', 'NISSAN_01', '', '2019-05-08 14:48:41', '2019-05-08 15:30:51', 20, 11, '2019-05-08 15:30:49', '2019-05-08 08:00:00'),
(34, 'Nissan', '6101', '', 1318, 142, '-1176', 'Done', 'NISSAN_01', '', '2019-05-08 16:48:21', '2019-05-09 08:01:39', 20, 17, '2019-05-09 08:01:39', '2019-05-08 08:00:00'),
(35, 'Nissan', '6101', '', 178, 90, '-88', 'Done', 'NISSAN_01', '59UN65,59UH11,59UH18,59UH31,59UN66,59UN67,59UT42,', '2019-05-09 08:06:27', '2019-05-14 14:19:22', 10, 3, '2019-05-09 16:38:40', '2019-05-09 08:00:00'),
(38, 'Daihatsu', '2102', '', 61, 87, '26', 'Done', 'DAIHATSU_02', '59WU10,59WZ42,', '2019-05-25 09:28:48', '2019-05-25 10:39:15', 10, 10, '2019-05-25 10:39:13', '2019-05-25 08:00:00'),
(39, 'Nissan', '6101', '', 16, 12, '-4', 'Pending', 'NISSAN_01', '59WX17,59WR71,', '2019-05-25 09:34:51', NULL, 30, 4, '2019-05-25 09:34:57', '2019-05-25 08:00:00'),
(40, 'Nissan', '6102', '', 10, 17, '7', 'Pending', 'NISSAN_02', '59XC22,', '2019-05-25 09:35:14', NULL, 25, 1, '2019-05-25 09:35:17', '2019-05-25 08:00:00'),
(41, 'Mazda Merge', '1130', '', 137, 139, '-1', 'Pending', 'MAZDA_30', '59WX90,', '2019-05-25 09:35:34', NULL, 120, 1, '2019-05-25 09:35:47', '2019-05-25 08:00:00'),
(42, 'Suzuki', '5110', '', 29, 30, '-5', 'Pending', 'SUZUKI_19', '59XB19,', '2019-05-25 09:36:46', NULL, 60, 0, '2019-05-25 09:37:02', '2019-05-25 08:00:00'),
(43, 'Honda', '3107', '', 33, 34, '-1', 'Pending', 'HONDA_05', '59WZ90,59XH65,', '2019-05-25 09:39:55', NULL, 30, 9, '2019-05-25 09:40:18', '2019-05-25 08:00:00'),
(47, 'Mazda Merge', '1115', '', 227, 228, '1', 'Pending', 'MAZDA_15', '59XD89,59WY30,59WX98,59WX99,59XD83,59XD85,59WY08,59WX96,59WY04,', '2019-05-25 09:53:34', NULL, 60, 9, '2019-05-25 09:53:45', '2019-05-25 08:00:00'),
(48, 'Mazda Merge', '1008', '', 249, 544, '295', 'Pending', 'MAZDA_16_1', '59WX91,59XE38,59WY25,59XD69,', '2019-05-25 09:53:57', NULL, 45, 20, '2019-05-25 11:19:46', '2019-05-25 08:00:00'),
(50, 'Honda TKRA', '3129', '', 15, 5, '-10', 'Pending', 'HONDA_32', '59WU22,59WU23,', '2019-05-25 09:56:05', NULL, 45, 0, '2019-05-25 09:56:05', '2019-05-25 08:00:00'),
(51, 'Honda TKRA', '3128', '', 7, 8, '1', 'Pending', 'HONDA_33', '59WU11,', '2019-05-25 09:56:21', NULL, 49, 12, '2019-05-25 09:56:35', '2019-05-25 08:00:00'),
(52, 'Mazda Merge', '1032', '', 49, 104, '55', 'Done', 'MAZDA_53', '59WX42,59WX71,', '2019-05-25 09:57:11', '2019-05-25 10:58:42', 120, 13, '2019-05-25 10:58:41', '2019-05-25 08:00:00'),
(55, 'Mazda Merge', '1032', '', 150, 108, '-42', 'Done', 'MAZDA_53', '59WX42,59WX71,', '2019-05-25 11:00:37', '2019-05-25 11:01:08', 0, 15, '2019-05-25 11:01:06', '2019-05-25 08:00:00'),
(56, 'Mazda Merge', '1032', '', 200, 114, '-86', 'Done', 'MAZDA_53', '59WX42,59WX71,', '2019-05-25 11:01:13', '2019-05-25 11:05:50', 0, 69, '2019-05-25 11:05:49', '2019-05-25 08:00:00'),
(57, 'Mazda Merge', '1032', '', 193, 128, '-65', 'Done', 'MAZDA_53', '59WX42,59WX71,', '2019-05-25 11:06:06', '2019-05-25 11:15:56', 5, 0, '2019-05-25 11:15:55', '2019-05-25 08:00:00'),
(58, 'Suzuki', '5112', '', 118, 1, '-117', 'Pending', 'SUZUKI_21', '59WW93,', '2019-05-25 11:16:41', NULL, 5, 0, '2019-05-25 11:18:31', '2019-05-25 08:00:00'),
(59, 'Mazda Merge', '1032', '', 102, 150, '48', 'Pending', 'MAZDA_53', '59WX42,59WX71,', '2019-05-25 11:34:19', NULL, 25, 3, '2019-05-25 11:36:11', '2019-05-25 08:00:00');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pcs_plan`
--
ALTER TABLE `pcs_plan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
