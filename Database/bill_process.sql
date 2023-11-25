-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2023 at 02:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bill_process`
--

-- --------------------------------------------------------



-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `bill_number` varchar(20) NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `vendor_company` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'pending',
  `user_id` varchar(50) DEFAULT NULL,
  `budget_head` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `bill_number`, `vendor_name`, `vendor_company`, `phone_number`, `amount`, `department`, `invoice_date`, `created_at`, `status`, `user_id`, `budget_head`) VALUES
(26, '3', 'Hari', 'Hari Traders', '6745891230', 2000.00, 'DoSR IN MICROBIOLOGY', '2023-11-15', '2023-11-17 09:27:36', 'Processing', 'CW2001', 'Others'),
(27, '3', 'Hari', 'Hari Traders', '6745891230', 2000.00, 'DoSR IN MICROBIOLOGY', '2023-11-15', '2023-11-17 09:49:28', 'Processing', 'CW2001', 'Others'),
(28, '6', 'Haricharan', 'Hari Traders', '6745891230', 2000.00, 'DOSR IN MCA', '2023-11-15', '2023-11-17 09:51:26', 'Processing', 'CW2001', 'Electricity'),
(29, '6369', 'Krishna', 'jhhj', '6745891230', 2000.00, 'DOSR IN MCA', '2023-11-14', '2023-11-17 09:54:33', 'Processing', 'CW1002', 'Electricity'),
(30, '5', 'Jayram', 'Hari Traders', '6361978486', 5000.00, 'DOSR IN MCA', '2023-11-15', '2023-11-17 12:20:44', 'Processing', 'CW1002', 'Others'),
(31, '8', 'Harsha', 'Harsha Electricals', '6312406089', 10000.00, 'DoSR IN Botony ', '2023-11-16', '2023-11-17 12:37:38', 'Processing', 'CW1002', 'Electricity'),
(32, '9', 'hkzdgh', 'lcksjhcjh', '7836987654', 10000.00, 'DoSR IN Botony ', '2023-11-16', '2023-11-17 12:45:36', 'Processing', 'CW1002', 'Electricity'),
(33, '69', 'Hari', 'Hari Furnitures', '6969784123', 100000.00, 'DOSR IN MCA', '2023-11-16', '2023-11-17 12:57:01', 'Processing', 'CW5002', 'Furniture'),
(34, '69', 'Hari', 'Hari Furnitures', '6969784123', 100000.00, 'DOSR IN MCA', '2023-11-16', '2023-11-17 13:01:17', 'Pending', 'CW5002', 'Furniture');

-- --------------------------------------------------------

--
-- Table structure for table `budget_heads`
--

CREATE TABLE `budget_heads` (
  `id` int(11) NOT NULL,
  `budget_head` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_heads`
--

INSERT INTO `budget_heads` (`id`, `budget_head`) VALUES
(1, 'Electricity'),
(2, 'Furniture'),
(3, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `case_workers`
--

CREATE TABLE `case_workers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `user_id` varchar(6) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_workers`
--

INSERT INTO `case_workers` (`id`, `name`, `email`, `phone`, `user_id`, `password`) VALUES
(5, 'Manikya J M', 'mani@gmail.com', '7689451230', 'CW1002', '$2y$10$KH1cGNI7YiBuPzL1ancPDevbT6.gU6cPMRTYXDaGDIDDxUwkong6S'),
(6, 'Ajay S R', 'ajay@gmail.com', '9036124530', 'CW2001', '$2y$10$gYxvkxG9KawVuWImiAzwBOHcUeDy0rXy7fV0.8dbRC5XRkBBDSFQa'),
(7, 'Paramatma', 'param@gmail.com', '8974562310', 'CW3001', '$2y$10$IBh2Q8JPW2x7ADz0ltHY7.R69.UsoeXmm1XB1q1fe0LMi6W8P8cG2'),
(10, 'Chandra', 'chandra@gmail.com', '89745612301', 'CW5001', '$2y$10$lLkWy8uV8SgklThz9zsKJ.GApfA85H7cb739PIiIshwKcElr/.fUy'),
(11, 'rajesh 1', 'rajesh@gmail.com', '7894561230', 'CW5002', '$2y$10$vRCD.d8vtnh1nurfZrLbeur63CYy6I6zWWR6M9ca5TG2gI0DgCd7C'),
(13, 'Chandra', 'chandrahasa@gmail.com', '8794561230', 'CW6001', '$2y$10$3/cwtqe5toYLKuKEpO8lZuXSIwwXLYea8ZTSAOSZ.h68kdF1OFMm2'),
(14, 'Nagesh', 'nagesh1@gmail.com', '6361938496', 'CW7001', '$2y$10$BhCcNNhLVvT9RoaANrqaXevbMgspfyBY.tW845TaJpMgd2L/PQc4a'),
(15, 'Haricharan', 'charan@gmail.com', '9393150398', 'CW8001', '$2y$10$nyaeRUVsrvRt6TlctUq/Wu8if5RTKBD4UIg4jSK0PwH/pvRjxLAbS');

--
-- Triggers `case_workers`
--
DELIMITER $$
CREATE TRIGGER `before_insert_case_worker` BEFORE INSERT ON `case_workers` FOR EACH ROW BEGIN
    DECLARE next_id INT;
    SET next_id = NEXT VALUE FOR user_id_sequence;
    SET NEW.user_id = CONCAT('CW', LPAD(next_id, 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `case_worker_id_seq`
--

CREATE TABLE `case_worker_id_seq` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB;

--
-- Dumping data for table `case_worker_id_seq`
--

INSERT INTO `case_worker_id_seq` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(1, 1, 9999, 1, 1, 1000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cw_accepted_bills`
--

CREATE TABLE `cw_accepted_bills` (
  `ID` int(11) NOT NULL,
  `Bill_Number` varchar(255) NOT NULL,
  `Vendor_Name` varchar(255) NOT NULL,
  `Vendor_Company` varchar(255) DEFAULT NULL,
  `Vendor_Phone_Number` varchar(20) DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Department` varchar(50) DEFAULT NULL,
  `Invoice_Date` date DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `Budget_Head` varchar(255) DEFAULT NULL,
  `Actions` varchar(255) DEFAULT NULL,
  `Remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cw_accepted_bills`
--

INSERT INTO `cw_accepted_bills` (`ID`, `Bill_Number`, `Vendor_Name`, `Vendor_Company`, `Vendor_Phone_Number`, `Amount`, `Department`, `Invoice_Date`, `Created_At`, `Status`, `user_id`, `Budget_Head`, `Actions`, `Remarks`) VALUES
(31, '8', 'Harsha', 'Harsha Electricals', '6312406089', 10000.00, 'DoSR IN Botony ', '2023-11-16', '2023-11-17 12:37:38', 'processing', 0, 'Electricity', 'Processing', 'ok'),
(32, '9', 'hkzdgh', 'lcksjhcjh', '7836987654', 10000.00, 'DoSR IN Botony ', '2023-11-16', '2023-11-17 12:45:36', 'processing', 0, 'Electricity', 'Processing', 'ok'),
(33, '69', 'Hari', 'Hari Furnitures', '6969784123', 100000.00, 'DOSR IN MCA', '2023-11-16', '2023-11-17 12:57:01', 'processing', 0, 'Furniture', 'Processing', 'ok');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department`) VALUES
(1, 'DOSR IN MCA'),
(5, 'DoSR IN MBA'),
(6, 'DoSR IN BIO-CHEMISTRY'),
(7, 'DoSR IN MICROBIOLOGY'),
(8, 'DoSR IN Botony ');

-- --------------------------------------------------------

--
-- Table structure for table `dfo_accepted_bills`
--

CREATE TABLE `dfo_accepted_bills` (
  `ID` int(11) NOT NULL,
  `Bill_Number` varchar(255) NOT NULL,
  `Vendor_Name` varchar(255) NOT NULL,
  `Vendor_Company` varchar(255) DEFAULT NULL,
  `Vendor_Phone_Number` varchar(20) DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Invoice_Date` date DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(20) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `Budget_Head` varchar(255) DEFAULT NULL,
  `Actions` varchar(255) DEFAULT NULL,
  `Remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dfo_accepted_bills`
--

INSERT INTO `dfo_accepted_bills` (`ID`, `Bill_Number`, `Vendor_Name`, `Vendor_Company`, `Vendor_Phone_Number`, `Amount`, `Department`, `Invoice_Date`, `Created_At`, `Status`, `user_id`, `Budget_Head`, `Actions`, `Remarks`) VALUES
(14, '8', 'Harsha', 'Harsha Electricals', '6312406089', 10000.00, 'DoSR IN Botony ', '2023-11-16', '2023-11-17 12:39:21', 'Approved', '0', 'Electricity', 'Moved', 'ok'),
(15, '9', 'hkzdgh', 'lcksjhcjh', '7836987654', 10000.00, 'DoSR IN Botony ', '2023-11-16', '2023-11-17 12:47:11', 'Approved', '0', 'Electricity', 'Moved', 'ok'),
(16, '69', 'Hari', 'Hari Furnitures', '6969784123', 100000.00, 'DOSR IN MCA', '2023-11-16', '2023-11-17 12:58:13', 'Approved', '0', 'Furniture', 'Moved', 'ok');

-- --------------------------------------------------------

--
-- Table structure for table `fo_accepted_bills`
--

CREATE TABLE `fo_accepted_bills` (
  `ID` int(11) NOT NULL,
  `Bill_Number` varchar(255) NOT NULL,
  `Vendor_Name` varchar(255) NOT NULL,
  `Vendor_Company` varchar(255) DEFAULT NULL,
  `Vendor_Phone_Number` varchar(20) DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Invoice_Date` date DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(20) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `Budget_Head` varchar(255) DEFAULT NULL,
  `Actions` varchar(255) DEFAULT NULL,
  `Remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fo_accepted_bills`
--

INSERT INTO `fo_accepted_bills` (`ID`, `Bill_Number`, `Vendor_Name`, `Vendor_Company`, `Vendor_Phone_Number`, `Amount`, `Department`, `Invoice_Date`, `Created_At`, `Status`, `user_id`, `Budget_Head`, `Actions`, `Remarks`) VALUES
(14, '8', 'Harsha', 'Harsha Electricals', '6312406089', 10000.00, 'DoSR IN Botony ', '2023-11-16', '2023-11-17 12:39:50', 'Approved', '0', 'Electricity', 'Moved', 'ok'),
(15, '9', 'hkzdgh', 'lcksjhcjh', '7836987654', 10000.00, 'DoSR IN Botony ', '2023-11-16', '2023-11-17 12:47:30', 'Approved', '0', 'Electricity', 'Moved', 'ok'),
(16, '69', 'Hari', 'Hari Furnitures', '6969784123', 100000.00, 'DOSR IN MCA', '2023-11-16', '2023-11-17 12:58:37', 'Approved', '0', 'Furniture', 'Moved', 'ok');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `user_id` varchar(6) DEFAULT concat('FD',lpad(floor(rand() * 9000) + 1000,4,'0')),
  `phone_number` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `images` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `os_accepted_bills`
--

CREATE TABLE `os_accepted_bills` (
  `ID` int(11) NOT NULL,
  `Bill_Number` varchar(255) NOT NULL,
  `Vendor_Name` varchar(255) NOT NULL,
  `Vendor_Company` varchar(255) DEFAULT NULL,
  `Vendor_Phone_Number` varchar(15) DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Department` varchar(255) DEFAULT NULL,
  `Invoice_Date` date DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(20) DEFAULT 'Accepted',
  `user_id` varchar(255) NOT NULL,
  `Budget_Head` varchar(255) DEFAULT NULL,
  `Actions` varchar(255) DEFAULT NULL,
  `Remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `os_accepted_bills`
--

INSERT INTO `os_accepted_bills` (`ID`, `Bill_Number`, `Vendor_Name`, `Vendor_Company`, `Vendor_Phone_Number`, `Amount`, `Department`, `Invoice_Date`, `Created_At`, `Status`, `user_id`, `Budget_Head`, `Actions`, `Remarks`) VALUES
(15, '8', 'Harsha', 'Harsha Electricals', '6312406089', 10000.00, 'DoSR IN Botony ', '2023-11-16', '2023-11-17 12:39:04', 'processing', '0', 'Electricity', 'Moved', 'ok'),
(16, '9', 'hkzdgh', 'lcksjhcjh', '7836987654', 10000.00, 'DoSR IN Botony ', '2023-11-16', '2023-11-17 12:46:57', 'processing', '0', 'Electricity', 'Moved', 'ok'),
(17, '69', 'Hari', 'Hari Furnitures', '6969784123', 100000.00, 'DOSR IN MCA', '2023-11-16', '2023-11-17 12:57:59', 'processing', '0', 'Furniture', 'Moved', 'ok');

-- --------------------------------------------------------

--
-- Table structure for table `sanctioned_amounts`
--

CREATE TABLE `sanctioned_amounts` (
  `id` int(11) NOT NULL,
  `budget_head` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remaining_amount` float DEFAULT 0 CHECK (`remaining_amount` >= 0),
  `total_expenses` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sanctioned_amounts`
--

INSERT INTO `sanctioned_amounts` (`id`, `budget_head`, `department`, `amount`, `remaining_amount`, `total_expenses`) VALUES
(17, 'Electricity', 'DoSR IN Botony ', 1000000.00, 980000, 20000.00),
(19, 'Furniture', 'DOSR IN MCA', 500000.00, 400000, 100000.00),
(20, 'Electricity', 'DOSR IN MCA', 1000000.00, 0, NULL),
(21, 'Electricity', 'DOSR IN MCA', 1000000.00, 0, NULL),
(22, 'Others', 'DOSR IN MCA', 250000.00, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_id_sequence`
--

CREATE TABLE `user_id_sequence` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB;

--
-- Dumping data for table `user_id_sequence`
--

INSERT INTO `user_id_sequence` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(9001, 1, 9999, 1, 1, 1000, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_bills`
--
ALTER TABLE `accepted_bills`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `budget_heads`
--
ALTER TABLE `budget_heads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_workers`
--
ALTER TABLE `case_workers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cw_accepted_bills`
--
ALTER TABLE `cw_accepted_bills`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dfo_accepted_bills`
--
ALTER TABLE `dfo_accepted_bills`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `fo_accepted_bills`
--
ALTER TABLE `fo_accepted_bills`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `os_accepted_bills`
--
ALTER TABLE `os_accepted_bills`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sanctioned_amounts`
--
ALTER TABLE `sanctioned_amounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accepted_bills`
--
ALTER TABLE `accepted_bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `budget_heads`
--
ALTER TABLE `budget_heads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `case_workers`
--
ALTER TABLE `case_workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cw_accepted_bills`
--
ALTER TABLE `cw_accepted_bills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dfo_accepted_bills`
--
ALTER TABLE `dfo_accepted_bills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `fo_accepted_bills`
--
ALTER TABLE `fo_accepted_bills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `os_accepted_bills`
--
ALTER TABLE `os_accepted_bills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sanctioned_amounts`
--
ALTER TABLE `sanctioned_amounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
