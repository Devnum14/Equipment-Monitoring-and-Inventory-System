-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2023 at 12:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smi_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar_event_master`
--

CREATE TABLE `calendar_event_master` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_start_date` date DEFAULT NULL,
  `event_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `calendar_event_master`
--

INSERT INTO `calendar_event_master` (`event_id`, `event_name`, `event_start_date`, `event_end_date`) VALUES
(1, 'adwadwad', '2023-11-06', '2023-11-29'),
(2, 'adwadwad', '2023-11-07', '2023-11-28'),
(3, 'adwadwad', '2023-11-06', '2023-11-01'),
(4, 'adwadwad', '2023-11-27', '2023-11-28'),
(5, 'adwadad', '2023-11-08', '2023-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `smi_borrowed_tbl`
--

CREATE TABLE `smi_borrowed_tbl` (
  `smi_borrowed_id` int(11) NOT NULL,
  `smi_borrowed_transid` int(11) NOT NULL,
  `smi_borrowed_equipmentName` varchar(255) NOT NULL,
  `smi_borrowed_qty` int(11) NOT NULL,
  `smi_borrowed_studentName` varchar(255) NOT NULL,
  `smi_borrowed_studentId` int(11) NOT NULL,
  `smi_borrowed_department` varchar(255) NOT NULL,
  `smi_borrowed_dateBorrow` datetime NOT NULL,
  `smi_borrowed_expReturn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smi_borrowed_tbl`
--

INSERT INTO `smi_borrowed_tbl` (`smi_borrowed_id`, `smi_borrowed_transid`, `smi_borrowed_equipmentName`, `smi_borrowed_qty`, `smi_borrowed_studentName`, `smi_borrowed_studentId`, `smi_borrowed_department`, `smi_borrowed_dateBorrow`, `smi_borrowed_expReturn`) VALUES
(100, 6037445, 'Basketball', 2, 'Emmanuel Lastimado', 0, 'DAS', '2023-12-26 18:51:08', '2023-12-27 23:59:59'),
(101, 1085637, 'Basketball', 1, 'Emmanuel Lastimado', 0, 'DAS', '2023-12-26 18:51:31', '2023-12-28 23:59:59'),
(102, 1085637, 'Volleyball', 1, 'Emmanuel Lastimado', 0, 'DAS', '2023-12-26 18:51:31', '2023-12-28 23:59:59');

-- --------------------------------------------------------

--
-- Table structure for table `smi_delete_tbl`
--

CREATE TABLE `smi_delete_tbl` (
  `smi_delete_id` int(11) NOT NULL,
  `smi_delete_equipmentName` varchar(255) NOT NULL,
  `smi_delete_reason` varchar(255) NOT NULL,
  `smi_delete_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smi_dispose_tbl`
--

CREATE TABLE `smi_dispose_tbl` (
  `smi_dispose_id` int(11) NOT NULL,
  `smi_dispose_equipmentName` varchar(255) NOT NULL,
  `smi_dispose_equipmentQty` int(11) NOT NULL,
  `smi_dispose_studentName` varchar(255) NOT NULL,
  `smi_dispose_studentId` int(11) NOT NULL,
  `smi_dispose_reason` varchar(255) NOT NULL,
  `smi_dispose_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smi_dispose_tbl`
--

INSERT INTO `smi_dispose_tbl` (`smi_dispose_id`, `smi_dispose_equipmentName`, `smi_dispose_equipmentQty`, `smi_dispose_studentName`, `smi_dispose_studentId`, `smi_dispose_reason`, `smi_dispose_date`) VALUES
(12, 'Basketball', 1, 'Criswel', 58821, 'rolandadwa', '2023-11-24 15:01:14'),
(13, 'Basketball', 12, 'Mae Flor', 52818, 'LOSLOSLOSLOSLOSLOSLOSLOSLOSLOSLOSLOS LOSLOSLOSLOSLOSLOSLOSLOS', '2023-11-24 15:58:09'),
(14, 'Basketball', 12, 'Mae Flor', 52818, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2023-11-24 15:59:11'),
(15, 'Basketball', 2, 'Mae Flor', 52818, 'Reason', '2023-11-24 17:28:53'),
(16, 'Basketball', 4, 'Criswel', 52818, 'adwad', '2023-11-26 02:04:51'),
(17, 'Basketball', 5, 'roland', 52818, 'adwadwad', '2023-11-28 13:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `smi_equipmentlist_tbl`
--

CREATE TABLE `smi_equipmentlist_tbl` (
  `smi_equipmentlist_id` int(11) NOT NULL,
  `smi_equipmentlist_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smi_equipmentlist_tbl`
--

INSERT INTO `smi_equipmentlist_tbl` (`smi_equipmentlist_id`, `smi_equipmentlist_name`) VALUES
(1, 'Basketball'),
(2, 'Volleyball'),
(4, 'Chess board'),
(5, 'Chess mat'),
(6, 'Takraw net'),
(7, 'Takraw ball'),
(8, 'Volleyball Net'),
(9, 'Badminton Net'),
(10, 'Basketball Ring'),
(11, 'Basketball Ring Net'),
(3, 'Body armour taekwando');

-- --------------------------------------------------------

--
-- Table structure for table `smi_equipment_tbl`
--

CREATE TABLE `smi_equipment_tbl` (
  `equipment_id` int(11) NOT NULL,
  `equipment_name` varchar(255) NOT NULL,
  `equipment_brand` varchar(255) NOT NULL,
  `equipment_stock` int(11) NOT NULL,
  `equipment_borrowed` int(11) NOT NULL,
  `equipment_dateadd` datetime NOT NULL,
  `equipment_dateupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smi_equipment_tbl`
--

INSERT INTO `smi_equipment_tbl` (`equipment_id`, `equipment_name`, `equipment_brand`, `equipment_stock`, `equipment_borrowed`, `equipment_dateadd`, `equipment_dateupdate`) VALUES
(88, 'Basketball', 'Molten', 20, 2, '2023-12-19 13:46:06', '2023-12-19 13:46:06'),
(89, 'Volleyball', 'adawdad', 20, 1, '2023-12-19 14:28:38', '2023-12-19 14:28:38'),
(90, 'Body armour taekwando', '', 24, 0, '2023-12-20 14:08:07', '2023-12-20 14:08:07'),
(91, 'Chess board', '', 12, 0, '2023-12-20 14:08:45', '2023-12-20 14:08:45'),
(92, 'Chess mat', '', 23, 0, '2023-12-20 14:08:50', '2023-12-20 14:08:50'),
(93, 'Takraw net', '', 24, 0, '2023-12-20 14:08:58', '2023-12-20 14:08:58'),
(94, 'Takraw ball', '', 25, 0, '2023-12-20 14:11:11', '2023-12-20 14:11:11'),
(95, 'Volleyball Net', '', 24, 0, '2023-12-20 14:11:21', '2023-12-20 14:11:21'),
(96, 'Badminton Net', '', 21, 0, '2023-12-20 14:11:29', '2023-12-20 14:11:29'),
(97, 'Basketball Ring', '', 27, 0, '2023-12-20 14:11:39', '2023-12-20 14:11:39'),
(98, 'Basketball Ring Net', '', 16, 0, '2023-12-20 14:11:45', '2023-12-20 14:11:45');

-- --------------------------------------------------------

--
-- Table structure for table `smi_return_tbl`
--

CREATE TABLE `smi_return_tbl` (
  `smi_return_id` int(11) NOT NULL,
  `smi_return_equipment` varchar(255) NOT NULL,
  `smi_return_qty` int(11) NOT NULL,
  `smi_return_borrower` varchar(255) NOT NULL,
  `smi_return_studentId` int(11) NOT NULL,
  `smi_return_department` varchar(255) NOT NULL,
  `smi_return_condition` varchar(255) NOT NULL,
  `smi_return_dateBorrow` datetime NOT NULL,
  `smi_return_dateReturn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smi_return_tbl`
--

INSERT INTO `smi_return_tbl` (`smi_return_id`, `smi_return_equipment`, `smi_return_qty`, `smi_return_borrower`, `smi_return_studentId`, `smi_return_department`, `smi_return_condition`, `smi_return_dateBorrow`, `smi_return_dateReturn`) VALUES
(107, 'Volleyball', 2, 'Emmanuel Lastimado', 0, '', 'Lost', '2023-12-26 18:51:31', '2023-12-26 18:55:19');

-- --------------------------------------------------------

--
-- Table structure for table `smi_user_tbl`
--

CREATE TABLE `smi_user_tbl` (
  `smi_user_id` int(11) NOT NULL,
  `smi_user_username` varchar(255) NOT NULL,
  `smi_user_name` varchar(255) NOT NULL,
  `smi_user_email` varchar(255) NOT NULL,
  `smi_user_password` varchar(255) NOT NULL,
  `smi_user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smi_user_tbl`
--

INSERT INTO `smi_user_tbl` (`smi_user_id`, `smi_user_username`, `smi_user_name`, `smi_user_email`, `smi_user_password`, `smi_user_type`) VALUES
(18, 'admin', 'administrator', 'admin@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 3);

-- --------------------------------------------------------

--
-- Table structure for table `testing`
--

CREATE TABLE `testing` (
  `smi_borrowed_id` int(11) NOT NULL,
  `smi_borrowed_equipmentName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testing`
--

INSERT INTO `testing` (`smi_borrowed_id`, `smi_borrowed_equipmentName`) VALUES
(35, 'Basketball  - 2\r\nVolleyball  - 2'),
(36, 'Basketball  - 2\r\nVolleyball  - 2'),
(37, 'Basketball  - 2\r\nVolleyball  - 2'),
(38, 'Basketball  - 2\r\nVolleyball  - 2'),
(39, 'Basketball  - 2\r\nVolleyball  - 2'),
(40, 'Basketball  - 2\r\nVolleyball  - 2'),
(41, 'Basketball  - 2\r\nVolleyball  - 2'),
(42, 'Basketball  - 2\nVolleyball  - 2\nBasketball  - 2\nVolleyball  - 2'),
(43, 'Basketball  - 2\r\nVolleyball  - 2\r\nBasketball  - 2\r\nVolleyball  - 2'),
(44, 'Basketball  - 2\nVolleyball  - 2\nBasketball  - 2\nVolleyball  - 2'),
(45, 'Basketball  - 2\r\nVolleyball  - 2\r\nBasketball  - 2\r\nVolleyball  - 2'),
(46, 'Basketball  - 2\nVolleyball  - 2\nBasketball  - 2\nVolleyball  - 2'),
(47, 'Basketball  - 2\r\nVolleyball  - 2\r\nBasketball  - 2\r\nVolleyball  - 2'),
(48, 'Basketball  - 2\nVolleyball  - 2\nBasketball  - 2\nVolleyball  - 2'),
(49, 'Basketball  - 2\r\nVolleyball  - 2'),
(50, 'Basketball  - 3\r\nVolleyball  - 4'),
(51, 'Volleyball  - 3'),
(52, 'Basketball  - 6\r\nVolleyball  - 3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar_event_master`
--
ALTER TABLE `calendar_event_master`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `smi_borrowed_tbl`
--
ALTER TABLE `smi_borrowed_tbl`
  ADD PRIMARY KEY (`smi_borrowed_id`);

--
-- Indexes for table `smi_delete_tbl`
--
ALTER TABLE `smi_delete_tbl`
  ADD PRIMARY KEY (`smi_delete_id`);

--
-- Indexes for table `smi_dispose_tbl`
--
ALTER TABLE `smi_dispose_tbl`
  ADD PRIMARY KEY (`smi_dispose_id`);

--
-- Indexes for table `smi_equipment_tbl`
--
ALTER TABLE `smi_equipment_tbl`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `smi_return_tbl`
--
ALTER TABLE `smi_return_tbl`
  ADD PRIMARY KEY (`smi_return_id`);

--
-- Indexes for table `smi_user_tbl`
--
ALTER TABLE `smi_user_tbl`
  ADD PRIMARY KEY (`smi_user_id`);

--
-- Indexes for table `testing`
--
ALTER TABLE `testing`
  ADD PRIMARY KEY (`smi_borrowed_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar_event_master`
--
ALTER TABLE `calendar_event_master`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `smi_borrowed_tbl`
--
ALTER TABLE `smi_borrowed_tbl`
  MODIFY `smi_borrowed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `smi_delete_tbl`
--
ALTER TABLE `smi_delete_tbl`
  MODIFY `smi_delete_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `smi_dispose_tbl`
--
ALTER TABLE `smi_dispose_tbl`
  MODIFY `smi_dispose_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `smi_equipment_tbl`
--
ALTER TABLE `smi_equipment_tbl`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `smi_return_tbl`
--
ALTER TABLE `smi_return_tbl`
  MODIFY `smi_return_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `smi_user_tbl`
--
ALTER TABLE `smi_user_tbl`
  MODIFY `smi_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `testing`
--
ALTER TABLE `testing`
  MODIFY `smi_borrowed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
