-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2023 at 06:52 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `binstalls1`
--

-- --------------------------------------------------------

--
-- Table structure for table `collectionreport_tbl`
--

CREATE TABLE `collectionreport_tbl` (
  `reportyear` int(11) NOT NULL,
  `jan` float NOT NULL,
  `feb` float NOT NULL,
  `mar` float NOT NULL,
  `apr` float NOT NULL,
  `may` float NOT NULL,
  `jun` float NOT NULL,
  `jul` float NOT NULL,
  `aug` float NOT NULL,
  `sept` float NOT NULL,
  `oct` float NOT NULL,
  `nov` float NOT NULL,
  `dece` float NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collectionreport_tbl`
--

INSERT INTO `collectionreport_tbl` (`reportyear`, `jan`, `feb`, `mar`, `apr`, `may`, `jun`, `jul`, `aug`, `sept`, `oct`, `nov`, `dece`, `total`) VALUES
(2023, 0, 0, 0, 0, 0, 0, 0, 1600, 0, 0, 0, 0, 1600);

-- --------------------------------------------------------

--
-- Table structure for table `market`
--

CREATE TABLE `market` (
  `market_id` int(11) NOT NULL,
  `market_name` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `market`
--

INSERT INTO `market` (`market_id`, `market_name`) VALUES
(2, 'payao'),
(3, 'Binalbagan');

-- --------------------------------------------------------

--
-- Table structure for table `payments_tbl`
--

CREATE TABLE `payments_tbl` (
  `paymentid` int(11) NOT NULL,
  `tenantid` int(11) NOT NULL,
  `ornumber` int(9) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `paymentdate` date NOT NULL,
  `paymenttime` time NOT NULL DEFAULT current_timestamp(),
  `holder` varchar(125) NOT NULL,
  `stallname` varchar(255) NOT NULL,
  `stallno1` int(11) NOT NULL,
  `stallno2` int(11) NOT NULL,
  `marketfee` float NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments_tbl`
--

INSERT INTO `payments_tbl` (`paymentid`, `tenantid`, `ornumber`, `timestamp`, `paymentdate`, `paymenttime`, `holder`, `stallname`, `stallno1`, `stallno2`, `marketfee`, `total`) VALUES
(32, 46, 1234567, '2023-08-05 17:16:40', '2023-08-06', '13:16:40', 'TEST, TEST', 'FRUITS AND VEGETABLE SECTION (INSIDE)', 1, 1, 1600, 1600);

-- --------------------------------------------------------

--
-- Table structure for table `rental_tbl`
--

CREATE TABLE `rental_tbl` (
  `rentalid` int(11) NOT NULL,
  `stallname` varchar(255) NOT NULL,
  `stallno` int(11) NOT NULL,
  `marketfee` float NOT NULL,
  `size` varchar(35) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(455) NOT NULL,
  `status` varchar(255) NOT NULL,
  `pmarket_id` int(30) NOT NULL,
  `tenantid` int(11) NOT NULL,
  `renter` varchar(255) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rental_tbl`
--

INSERT INTO `rental_tbl` (`rentalid`, `stallname`, `stallno`, `marketfee`, `size`, `location`, `description`, `status`, `pmarket_id`, `tenantid`, `renter`, `image`) VALUES
(2, 'Fish Section (Inside)', 1, 40, '10x10 ft', 'Public Market, Fish section', 'Involves any kinds of varieties of fish', 'Occupied', 3, 67, 'GENABE', 'fish section.jpg'),
(5, 'Fish Section (Inside)', 2, 40, '10x10 ft', 'test', 'test', 'Occupied', 3, 67, 'GENABE', 'fish section.jpg'),
(6, 'Fish Section (Inside)', 3, 40, '10x10 ft', 'test', 'test', 'Occupied', 3, 67, 'GENABE', 'fish section.jpg'),
(7, 'Fish Section (Inside)', 4, 40, '15x15 ft', 'test', 'test', 'Available', 0, 0, '', 'fish section.jpg'),
(8, 'Fish Section (Inside)', 5, 50, '15x15 ft', 'test', 'test', 'Available', 0, 0, '', 'fish section.jpg'),
(10, 'Meat Section (Outside)', 1, 50, '15x15 ft', 'DASDSA', 'hehehe', 'Available', 3, 0, '', 'Dariusz_Zawadzki.jpg'),
(18, 'Miscellaneous Section (Inside)', 2, 50, '15x15 ft', 'Plaza Veranda', 'dsadsadsa', 'Available', 2, 0, '', 'h3h3.jpg'),
(19, 'Miscellaneous Section (Inside)', 3, 50, '20x20 ft', 'dsadsa', 'dsadsa', 'Available', 3, 0, '', 'h3h3.jpg'),
(20, 'Fish Section (Inside)', 1, 50, '10x10 ft', 'dsadsa', 'dsadas', 'Available', 2, 0, '', 'h3h3.jpg'),
(21, 'Miscellaneous Section (Inside)', 1, 50, '10x10 ft', 'dasdas', 'dsadsa', 'Available', 3, 0, '', 'h3h3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `request_tbl`
--

CREATE TABLE `request_tbl` (
  `req_id` int(11) NOT NULL,
  `req_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(60) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `stallname` varchar(255) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `rentalid` int(11) NOT NULL,
  `stallno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sms_tbl`
--

CREATE TABLE `sms_tbl` (
  `msg_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `req_id` int(11) NOT NULL,
  `contact_no` varchar(30) NOT NULL,
  `date_time_sent` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `message` text NOT NULL,
  `tname` varchar(255) NOT NULL,
  `rname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sms_tbl`
--

INSERT INTO `sms_tbl` (`msg_id`, `tenant_id`, `req_id`, `contact_no`, `date_time_sent`, `message`, `tname`, `rname`) VALUES
(6, 0, 0, '09672958595', '2023-04-10 11:59:14', 'try', '', ''),
(7, 0, 0, '09672958595', '2023-04-11 16:04:58', 'hatdog', '', ''),
(8, 0, 0, '09672958595', '2023-04-12 13:26:05', 'test test 1', '', ''),
(9, 0, 0, '12345678901', '2023-04-18 00:35:49', 'want', '', ''),
(10, 0, 0, '96729585953', '2023-05-04 09:39:10', 'test', '', ''),
(11, 0, 0, '96729585953', '2023-05-10 14:55:18', 'Hi mister cristobal\nhere is your account ID\n2\nlogin with your contact number', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tconcerns`
--

CREATE TABLE `tconcerns` (
  `concernid` int(11) NOT NULL,
  `tenantid` int(11) NOT NULL,
  `tenantname` varchar(255) NOT NULL,
  `tenantgender` varchar(255) NOT NULL,
  `stallname` varchar(125) NOT NULL,
  `stallno` varchar(125) NOT NULL,
  `concerns` longtext NOT NULL,
  `concern_type` varchar(125) NOT NULL,
  `status` varchar(35) NOT NULL,
  `date_time_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tconcerns`
--

INSERT INTO `tconcerns` (`concernid`, `tenantid`, `tenantname`, `tenantgender`, `stallname`, `stallno`, `concerns`, `concern_type`, `status`, `date_time_created`) VALUES
(15, 54, 'GENABE, DON', 'MALE', 'FISH SECTION (INSIDE)', '1 - 1', 'test', 'Electricity', 'In process', '2023-08-09 07:10:27'),
(17, 54, 'GENABE, DON', 'MALE', 'FISH SECTION (INSIDE)', '1 - 1', 'dsadsas tests testse', 'Stalls', 'closed', '2023-09-04 02:08:54');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `tenantid` int(11) NOT NULL,
  `tenant_lname` varchar(255) NOT NULL,
  `tenant_fname` varchar(255) NOT NULL,
  `tenant_midname` varchar(255) NOT NULL,
  `tenant_gender` varchar(255) NOT NULL,
  `age` varchar(30) NOT NULL,
  `civil_status` varchar(30) NOT NULL,
  `birthdate` date NOT NULL,
  `phoneno` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `tmarket_id` int(11) NOT NULL,
  `date_registered` date NOT NULL,
  `stallno1` int(11) NOT NULL,
  `stallno2` int(11) NOT NULL,
  `marketfee` float NOT NULL,
  `stallname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`tenantid`, `tenant_lname`, `tenant_fname`, `tenant_midname`, `tenant_gender`, `age`, `civil_status`, `birthdate`, `phoneno`, `address`, `tmarket_id`, `date_registered`, `stallno1`, `stallno2`, `marketfee`, `stallname`) VALUES
(67, 'GENABE', 'DON', 'CRISTOBAL', 'MALE', '35', 'Single', '2002-12-31', '967295859', 'TEST', 3, '2023-09-04', 1, 3, 40, 'FISH SECTION (INSIDE)');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `pwd` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `lname`, `fname`, `username`, `usertype`, `email`, `phone`, `pwd`) VALUES
(1, 'Genabe', 'Don', 'admin', 'Admin', 'genabedoncristobal@gmail.com', '09672958595', '$2y$10$PgwHv1NLqe6Qhj4b0PrZd.jTuDs6OL7PIS7TIDOr.mZWsJBbQo1Tq'),
(11, 'impure', 'kin', 'staff', 'Staff', 'kingimpure1@gmail.com', '12345678901', '$2y$10$RdcM22NaBa8Mdv7kGKU/tOcD8cB0K7p2FDArr3Cd./rGt8K3oxWW.'),
(12, 'Tabia', 'John Michael', 'staff123', 'Staff', 'johnmichaeltabia@gmail.com', '09672958595', '$2y$10$RLl4ZKyy8rVwIow6tCC/1uwZnEjq40zNtpx9AE2IyeKRFOMpU.xua');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `market`
--
ALTER TABLE `market`
  ADD PRIMARY KEY (`market_id`);

--
-- Indexes for table `payments_tbl`
--
ALTER TABLE `payments_tbl`
  ADD PRIMARY KEY (`paymentid`);

--
-- Indexes for table `rental_tbl`
--
ALTER TABLE `rental_tbl`
  ADD PRIMARY KEY (`rentalid`);

--
-- Indexes for table `request_tbl`
--
ALTER TABLE `request_tbl`
  ADD PRIMARY KEY (`req_id`);

--
-- Indexes for table `sms_tbl`
--
ALTER TABLE `sms_tbl`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `tconcerns`
--
ALTER TABLE `tconcerns`
  ADD PRIMARY KEY (`concernid`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`tenantid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `market`
--
ALTER TABLE `market`
  MODIFY `market_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments_tbl`
--
ALTER TABLE `payments_tbl`
  MODIFY `paymentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `rental_tbl`
--
ALTER TABLE `rental_tbl`
  MODIFY `rentalid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `request_tbl`
--
ALTER TABLE `request_tbl`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `sms_tbl`
--
ALTER TABLE `sms_tbl`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tconcerns`
--
ALTER TABLE `tconcerns`
  MODIFY `concernid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `tenantid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
