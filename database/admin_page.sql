-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2021 at 08:46 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_page`
--

-- --------------------------------------------------------

--
-- Table structure for table `customerlog`
--

CREATE TABLE `customerlog` (
  `customerlog_id` int(11) NOT NULL,
  `mode` varchar(20) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_account` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reg_num` varchar(255) NOT NULL,
  `outstanding` decimal(10,2) DEFAULT NULL,
  `points` decimal(10,2) DEFAULT NULL,
  `status` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postcode` varchar(15) NOT NULL,
  `state` varchar(20) NOT NULL,
  `salutation` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `website` varchar(30) NOT NULL,
  `biz_nature` varchar(50) NOT NULL,
  `salesperson` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(30) NOT NULL,
  `attention` varchar(30) NOT NULL,
  `introducer` varchar(30) NOT NULL,
  `reg_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `telephone1` varchar(20) NOT NULL,
  `telephone2` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `handphone` varchar(20) NOT NULL,
  `skype` varchar(20) NOT NULL,
  `nric` varchar(15) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `race` varchar(20) NOT NULL,
  `religion` varchar(10) NOT NULL,
  `info1` varchar(255) DEFAULT NULL,
  `info2` varchar(255) DEFAULT NULL,
  `info3` varchar(255) DEFAULT NULL,
  `info4` varchar(255) DEFAULT NULL,
  `info5` varchar(255) DEFAULT NULL,
  `info6` varchar(255) DEFAULT NULL,
  `info7` varchar(255) DEFAULT NULL,
  `info8` varchar(255) DEFAULT NULL,
  `info9` varchar(255) DEFAULT NULL,
  `info10` varchar(255) DEFAULT NULL,
  `control_ac` varchar(30) NOT NULL,
  `accounting_account` varchar(255) NOT NULL,
  `creation_date` date DEFAULT NULL,
  `creation_time` time DEFAULT NULL,
  `creation_user` varchar(255) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customerlog`
--

INSERT INTO `customerlog` (`customerlog_id`, `mode`, `customer_id`, `customer_account`, `name`, `reg_num`, `outstanding`, `points`, `status`, `address`, `postcode`, `state`, `salutation`, `email`, `website`, `biz_nature`, `salesperson`, `category`, `city`, `country`, `attention`, `introducer`, `reg_date`, `expiry_date`, `telephone1`, `telephone2`, `fax`, `handphone`, `skype`, `nric`, `gender`, `dob`, `race`, `religion`, `info1`, `info2`, `info3`, `info4`, `info5`, `info6`, `info7`, `info8`, `info9`, `info10`, `control_ac`, `accounting_account`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(1, 'Add', NULL, 'cus1', 'name1', 'regname', '0.00', '0.00', 'status', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-05-22', '19:01:46', 'admin', NULL, NULL, NULL),
(2, 'Update', 1, 'cus1', 'name1', 'regname', '0.00', '0.00', 'status', '222', '333', '555', '777', 'nightcatdigitalsolutions@gmail', 'qwe', 'qwe', '', '', '444', '666', '888', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-05-22', '19:01:46', 'admin', '2021-05-22', '19:02:17', 'admin'),
(3, 'Update', 1, 'cus1', 'name1', 'regname', '0.00', '0.00', 'status', '222', '333', '555', '777', 'nightcatdigitalsolutions@gmail', 'qwe', 'qwe', '', '', '444', '666', '888', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '11111', '11111', '11111', '11111', '11111', '11111', '11111', '11111', '11111', '11111', '', '', '2021-05-22', '19:01:46', 'admin', '2021-05-22', '19:02:35', 'admin'),
(4, 'Delete', 1, 'cus1', 'name1', 'regname', '0.00', '0.00', 'status', '222', '333', '555', '777', 'nightcatdigitalsolutions@gmail', 'qwe', 'qwe', '', '', '444', '666', '888', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '11111', '11111', '11111', '11111', '11111', '11111', '11111', '11111', '11111', '11111', '', '', '2021-05-22', '19:01:46', 'admin', '2021-05-22', '19:03:23', 'admin'),
(5, 'Add', NULL, 'tester1', 'tester1', 'tester1', '0.00', '0.00', 'tester1', 'tester1,\r\ntester1tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', '0000-00-00', '0000-00-00', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', '2021-05-22', '20:55:55', 'tester1', NULL, NULL, NULL),
(6, 'Add', NULL, 'tester2', 'tester2', 'tester2', '0.00', '0.00', 'tester2', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-05-22', '20:56:09', 'tester1', NULL, NULL, NULL),
(7, 'Update', 3, 'tester2', 'tester2', 'tester2', '1.10', '1.10', 'tester2', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-05-22', '20:56:09', 'tester1', '2021-06-10', '20:52:06', 'admin'),
(8, 'Update', 3, 'tester2', 'tester2', 'tester2', '0.00', '0.00', 'tester2', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-05-22', '20:56:09', 'tester1', '2021-06-10', '20:52:40', 'admin'),
(9, 'Add', NULL, 'test3', '', '', '1.10', '1.10', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-06-10', '20:54:25', 'admin', NULL, NULL, NULL),
(10, 'Delete', 4, 'test3', '', '', '1.10', '1.10', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-06-10', '20:54:25', 'admin', '2021-06-10', '20:54:37', 'admin'),
(11, 'Add', NULL, 'nightcattest', 'nightcattest', '', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-03', '16:24:48', 'admin', NULL, NULL, NULL),
(12, 'Add', NULL, 'Nightcat Test 2', 'Nightcat Test 2', '', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-21', '2021-07-22', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-21', '09:25:52', 'admin', NULL, NULL, NULL),
(13, 'Add', NULL, 'Nightcat Test 3', 'Nightcat Test 3', 'Nightcat Test 3', '0.00', '0.00', 'Nightcat Test 3', 'Nightcat Test 3', 'Nightcat Test 3', 'Nightcat Test 3', 'Nightcat Test 3', 'Nightcat Test 3', '', '', 'Nightcat Test 3', '', 'Nightcat Test 3', 'Nightcat Test 3', '', '', '2021-07-21', '2021-07-22', 'Nightcat Test 3', 'Nightcat Test 3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-23', '13:16:31', 'admin', NULL, NULL, NULL),
(14, 'Add', NULL, 'testing', 'testing', '', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1990-01-01', '1990-01-01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-23', '15:20:14', 'admin', NULL, NULL, NULL),
(15, 'Delete', 8, 'testing', 'testing', '', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1990-01-01', '1990-01-01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-23', '15:20:14', 'admin', '2021-07-23', '15:20:36', 'admin'),
(16, 'Add', NULL, 'nightcat5', 'nightcat5', 'nightcat5', '0.00', '0.00', 'nightcat5', 'nightcat5', 'nightcat5', 'nightcat5', 'nightcat5', '', '', '', '', '', '', '', '', '', '1990-01-01', '1990-01-01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-23', '17:19:36', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_account` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reg_num` varchar(255) NOT NULL,
  `outstanding` decimal(10,2) DEFAULT NULL,
  `points` decimal(10,2) DEFAULT NULL,
  `status` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postcode` varchar(15) NOT NULL,
  `state` varchar(20) NOT NULL,
  `salutation` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `website` varchar(30) NOT NULL,
  `biz_nature` varchar(50) NOT NULL,
  `salesperson` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(30) NOT NULL,
  `attention` varchar(30) NOT NULL,
  `introducer` varchar(30) NOT NULL,
  `reg_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `telephone1` varchar(20) NOT NULL,
  `telephone2` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `handphone` varchar(20) NOT NULL,
  `skype` varchar(20) NOT NULL,
  `nric` varchar(15) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `race` varchar(20) NOT NULL,
  `religion` varchar(10) NOT NULL,
  `info1` varchar(255) DEFAULT NULL,
  `info2` varchar(255) DEFAULT NULL,
  `info3` varchar(255) DEFAULT NULL,
  `info4` varchar(255) DEFAULT NULL,
  `info5` varchar(255) DEFAULT NULL,
  `info6` varchar(255) DEFAULT NULL,
  `info7` varchar(255) DEFAULT NULL,
  `info8` varchar(255) DEFAULT NULL,
  `info9` varchar(255) DEFAULT NULL,
  `info10` varchar(255) DEFAULT NULL,
  `control_ac` varchar(30) NOT NULL,
  `accounting_account` varchar(255) NOT NULL,
  `creation_date` date DEFAULT NULL,
  `creation_time` time DEFAULT NULL,
  `creation_user` varchar(255) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_account`, `name`, `reg_num`, `outstanding`, `points`, `status`, `address`, `postcode`, `state`, `salutation`, `email`, `website`, `biz_nature`, `salesperson`, `category`, `city`, `country`, `attention`, `introducer`, `reg_date`, `expiry_date`, `telephone1`, `telephone2`, `fax`, `handphone`, `skype`, `nric`, `gender`, `dob`, `race`, `religion`, `info1`, `info2`, `info3`, `info4`, `info5`, `info6`, `info7`, `info8`, `info9`, `info10`, `control_ac`, `accounting_account`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(2, 'tester1', 'tester1', 'tester1', '0.00', '0.00', 'tester1', 'tester1,\r\ntester1tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', '0000-00-00', '0000-00-00', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', 'tester1', '2021-05-22', '20:55:55', 'tester1', NULL, NULL, NULL),
(3, 'tester2', 'tester2', 'tester2', '0.00', '0.00', 'tester2', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-05-22', '20:56:09', 'tester1', '2021-06-10', '20:52:40', 'admin'),
(5, 'nightcattest', 'nightcattest', '', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-03', '16:24:48', 'admin', NULL, NULL, NULL),
(6, 'Nightcat Test 2', 'Nightcat Test 2', '', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-21', '2021-07-22', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-21', '09:25:52', 'admin', NULL, NULL, NULL),
(7, 'Nightcat Test 3', 'Nightcat Test 3', 'Nightcat Test 3', '0.00', '0.00', 'Nightcat Test 3', 'Nightcat Test 3', 'Nightcat Test 3', 'Nightcat Test 3', 'Nightcat Test 3', 'Nightcat Test 3', '', '', 'Nightcat Test 3', '', 'Nightcat Test 3', 'Nightcat Test 3', '', '', '2021-07-21', '2021-07-22', 'Nightcat Test 3', 'Nightcat Test 3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-23', '13:16:31', 'admin', NULL, NULL, NULL),
(9, 'nightcat5', 'nightcat5', 'nightcat5', '0.00', '0.00', 'nightcat5', 'nightcat5', 'nightcat5', 'nightcat5', 'nightcat5', '', '', '', '', '', '', '', '', '', '1990-01-01', '1990-01-01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2021-07-23', '17:19:36', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `invoice_detail_id` int(11) NOT NULL,
  `invoice_id_header` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_no` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `uom` varchar(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `base_cost` decimal(10,2) NOT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`invoice_detail_id`, `invoice_id_header`, `item_id`, `item_no`, `description`, `quantity`, `uom`, `price`, `discount`, `amount`, `base_cost`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(3, 'iv20210724064537', 28060, '9556618180104', 'wafercho*30', 2, '', '12.00', '0.00', '24.00', '0.00', '2021-07-24', '06:46:15', 'admin', '2021-07-24', '06:46:15', 'admin'),
(5, 'iv20210724064503', 28062, '8888010200618', 'SCSORIGINALCHEESESLICE200G*32', 1, '', '2.15', '0.00', '2.15', '0.00', '2021-07-24', '07:46:35', 'admin', '2021-07-24', '07:46:35', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail_log`
--

CREATE TABLE `invoice_detail_log` (
  `invoice_detail_id_log` int(11) NOT NULL,
  `mode` varchar(20) NOT NULL,
  `invoice_id_header_log` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_no` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `uom` varchar(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `base_cost` decimal(10,2) NOT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_detail_log`
--

INSERT INTO `invoice_detail_log` (`invoice_detail_id_log`, `mode`, `invoice_id_header_log`, `item_id`, `item_no`, `description`, `quantity`, `uom`, `price`, `discount`, `amount`, `base_cost`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(1, 'Add', 'iv20210724063840', 28062, '8888010200618', 'SCSORIGINALCHEESESLICE200G*32', 1, 'unit', '2.15', '0.00', '2.15', '0.00', '2021-07-24', '06:38:40', 'admin', NULL, NULL, NULL),
(2, 'Add', 'iv20210724063909', 28060, '9556618180104', 'wafercho*30', 10, 'unit', '12.00', '0.00', '120.00', '0.00', '2021-07-24', '06:39:09', 'admin', NULL, NULL, NULL),
(3, 'Update', 'iv20210724063909', 28060, '9556618180104', 'wafercho*30', 10, '', '12.00', '0.00', '120.00', '0.00', '2021-07-24', '06:39:51', 'admin', '2021-07-24', '06:39:51', 'admin'),
(4, 'Add', 'iv20210724064503', 28062, '8888010200618', 'SCSORIGINALCHEESESLICE200G*32', 1, 'unit', '2.15', '0.00', '2.15', '0.00', '2021-07-24', '06:45:03', 'admin', NULL, NULL, NULL),
(5, 'Add', 'iv20210724064537', 28060, '9556618180104', 'wafercho*30', 1, 'unit', '12.00', '0.00', '12.00', '0.00', '2021-07-24', '06:45:37', 'admin', NULL, NULL, NULL),
(6, 'Update', 'iv20210724064537', 28060, '9556618180104', 'wafercho*30', 2, '', '12.00', '0.00', '24.00', '0.00', '2021-07-24', '06:46:15', 'admin', '2021-07-24', '06:46:15', 'admin'),
(7, 'Update', 'iv20210724064503', 28062, '8888010200618', 'SCSORIGINALCHEESESLICE200G*32', 1, '', '2.15', '0.00', '2.15', '0.00', '2021-07-24', '06:48:44', 'admin', '2021-07-24', '06:48:44', 'admin'),
(8, 'Update', 'iv20210724064503', 28062, '8888010200618', 'SCSORIGINALCHEESESLICE200G*32', 1, '', '2.15', '0.00', '2.15', '0.00', '2021-07-24', '07:46:35', 'admin', '2021-07-24', '07:46:35', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_header`
--

CREATE TABLE `invoice_header` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(255) NOT NULL,
  `in_account` varchar(255) NOT NULL,
  `in_name` varchar(255) NOT NULL,
  `invoice_num` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_remark` varchar(255) NOT NULL,
  `doc_no` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `subtotal_ex` decimal(10,2) NOT NULL,
  `discount_header` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `outstanding` decimal(10,2) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_header`
--

INSERT INTO `invoice_header` (`id`, `invoice_id`, `in_account`, `in_name`, `invoice_num`, `invoice_date`, `invoice_remark`, `doc_no`, `due_date`, `subtotal_ex`, `discount_header`, `total_amount`, `outstanding`, `payment`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(1, 'iv20210724064503', 'tester2', 'tester2', 'update latest', '1990-01-01', '', '', '1990-01-01', '2.15', '0.00', '2.15', '0.15', '2.00', '2021-07-24', '06:45:03', 'admin', '2021-07-24', '07:46:35', 'admin'),
(2, 'iv20210724064537', 'tester2', 'tester2', 'update', '1990-01-01', '', '', '1990-01-01', '24.00', '0.00', '24.00', '24.00', '0.00', '2021-07-24', '06:45:37', 'admin', '2021-07-24', '07:14:33', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_header_log`
--

CREATE TABLE `invoice_header_log` (
  `id` int(11) NOT NULL,
  `mode` varchar(255) NOT NULL,
  `invoice_id_log` varchar(255) NOT NULL,
  `in_account` varchar(255) NOT NULL,
  `in_name` varchar(255) NOT NULL,
  `invoice_num` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_remark` varchar(255) NOT NULL,
  `doc_no` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `subtotal_ex` decimal(10,2) NOT NULL,
  `discount_header` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `outstanding` decimal(10,2) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_header_log`
--

INSERT INTO `invoice_header_log` (`id`, `mode`, `invoice_id_log`, `in_account`, `in_name`, `invoice_num`, `invoice_date`, `invoice_remark`, `doc_no`, `due_date`, `subtotal_ex`, `discount_header`, `total_amount`, `outstanding`, `payment`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(1, 'Add', 'iv20210724063840', 'tester2', 'tester2', '', '1990-01-01', '', '', '1990-01-01', '14.15', '0.00', '14.15', '14.15', '0.00', '2021-07-24', '06:38:40', 'admin', NULL, NULL, NULL),
(2, 'Add', 'iv20210724063909', 'tester2', 'tester2', '', '1990-01-01', '', '', '1990-01-01', '120.00', '0.00', '120.00', '120.00', '0.00', '2021-07-24', '06:39:09', 'admin', NULL, NULL, NULL),
(3, 'Update', 'iv20210724063909', 'tester2', 'tester2', 'update', '1990-01-01', '', '', '1990-01-01', '120.00', '0.00', '120.00', '120.00', '0.00', '2021-07-24', '06:39:09', 'admin', '2021-07-24', '06:39:51', 'admin'),
(4, 'Pay', 'iv20210724063840', 'tester2', 'tester2', '', '1990-01-01', '', '', '1990-01-01', '14.15', '0.00', '14.15', '0.15', '14.00', '2021-07-24', '06:38:40', 'admin', '2021-07-24', '06:41:16', 'admin'),
(5, 'Add', 'iv20210724064503', 'tester2', 'tester2', '', '1990-01-01', '', '', '1990-01-01', '2.15', '0.00', '2.15', '2.15', '0.00', '2021-07-24', '06:45:03', 'admin', NULL, NULL, NULL),
(6, 'Add', 'iv20210724064537', 'tester2', 'tester2', '', '1990-01-01', '', '', '1990-01-01', '12.00', '0.00', '12.00', '12.00', '0.00', '2021-07-24', '06:45:37', 'admin', NULL, NULL, NULL),
(7, 'Update', 'iv20210724064537', 'tester2', 'tester2', 'update', '1990-01-01', '', '', '1990-01-01', '24.00', '0.00', '24.00', '24.00', '0.00', '2021-07-24', '06:45:37', 'admin', '2021-07-24', '06:46:15', 'admin'),
(8, 'Pay', 'iv20210724064503', 'tester2', 'tester2', '', '1990-01-01', '', '', '1990-01-01', '2.15', '0.00', '2.15', '0.15', '2.00', '2021-07-24', '06:45:03', 'admin', '2021-07-24', '06:47:36', 'admin'),
(9, 'Update', 'iv20210724064503', 'tester2', 'tester2', 'update 1', '1990-01-01', '', '', '1990-01-01', '2.15', '0.00', '2.15', '0.15', '2.00', '2021-07-24', '06:45:03', 'admin', '2021-07-24', '06:48:44', 'admin'),
(10, 'Pay', 'iv20210724064537', 'tester2', 'tester2', 'update', '1990-01-01', '', '', '1990-01-01', '24.00', '0.00', '24.00', '4.15', '19.85', '2021-07-24', '06:45:37', 'admin', '2021-07-24', '07:13:17', 'admin'),
(11, 'Pay', 'iv20210724064503', 'tester2', 'tester2', 'update 1', '1990-01-01', '', '', '1990-01-01', '2.15', '0.00', '2.15', '0.00', '2.15', '2021-07-24', '06:45:03', 'admin', '2021-07-24', '07:13:17', 'admin'),
(12, 'Delete Payment', 'iv20210724064503', 'tester2', 'tester2', 'update 1', '1990-01-01', '', '', '1990-01-01', '2.15', '0.00', '2.15', '0.00', '2.15', '2021-07-24', '06:45:03', 'admin', '2021-07-24', '07:14:09', 'admin'),
(13, 'Delete Payment', 'iv20210724064537', 'tester2', 'tester2', 'update', '1990-01-01', '', '', '1990-01-01', '24.00', '0.00', '24.00', '4.15', '19.85', '2021-07-24', '06:45:37', 'admin', '2021-07-24', '07:14:33', 'admin'),
(14, 'Delete Payment', 'iv20210724064503', 'tester2', 'tester2', 'update 1', '1990-01-01', '', '', '1990-01-01', '2.15', '0.00', '2.15', '2.00', '0.15', '2021-07-24', '06:45:03', 'admin', '2021-07-24', '07:14:33', 'admin'),
(15, 'Pay', 'iv20210724064503', 'tester2', 'tester2', 'update 1', '1990-01-01', '', '', '1990-01-01', '2.15', '0.00', '2.15', '0.15', '2.00', '2021-07-24', '06:45:03', 'admin', '2021-07-24', '07:46:13', 'admin'),
(16, 'Update', 'iv20210724064503', 'tester2', 'tester2', 'update latest', '1990-01-01', '', '', '1990-01-01', '2.15', '0.00', '2.15', '0.15', '2.00', '2021-07-24', '06:45:03', 'admin', '2021-07-24', '07:46:35', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `itemlog`
--

CREATE TABLE `itemlog` (
  `itemlog_id` int(11) NOT NULL,
  `mode` varchar(20) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_no` varchar(255) NOT NULL,
  `doc_key` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `description2` varchar(255) DEFAULT NULL,
  `description3` varchar(255) DEFAULT NULL,
  `master_vendor` varchar(50) DEFAULT NULL,
  `vendor_item` varchar(50) DEFAULT NULL,
  `item_type` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `item_group` varchar(50) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `selling_price1` decimal(10,2) DEFAULT NULL,
  `qty_hand` int(11) DEFAULT NULL,
  `qty_hold` int(11) DEFAULT NULL,
  `qty_available` int(11) DEFAULT NULL,
  `qty_reorder_available` int(11) DEFAULT NULL,
  `qty_max` int(11) DEFAULT NULL,
  `vendor` varchar(50) DEFAULT NULL,
  `vendor_company` varchar(50) DEFAULT NULL,
  `item_picture` longtext DEFAULT NULL,
  `plu` varchar(255) DEFAULT NULL,
  `info1` varchar(255) DEFAULT NULL,
  `info2` varchar(255) DEFAULT NULL,
  `info3` varchar(255) DEFAULT NULL,
  `info4` varchar(255) DEFAULT NULL,
  `info5` varchar(255) DEFAULT NULL,
  `info6` varchar(255) DEFAULT NULL,
  `info7` varchar(255) DEFAULT NULL,
  `info8` varchar(255) DEFAULT NULL,
  `info9` varchar(255) DEFAULT NULL,
  `info10` varchar(255) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `creation_time` time DEFAULT NULL,
  `creation_user` varchar(100) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `itemlog`
--

INSERT INTO `itemlog` (`itemlog_id`, `mode`, `item_id`, `item_no`, `doc_key`, `description`, `description2`, `description3`, `master_vendor`, `vendor_item`, `item_type`, `category`, `item_group`, `unit_cost`, `selling_price1`, `qty_hand`, `qty_hold`, `qty_available`, `qty_reorder_available`, `qty_max`, `vendor`, `vendor_company`, `item_picture`, `plu`, `info1`, `info2`, `info3`, `info4`, `info5`, `info6`, `info7`, `info8`, `info9`, `info10`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(1, 'Add', NULL, 'test', 1, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', '1.00', '1.00', 1, 1, 1, 1, 1, 'test', 'test', NULL, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', '', '', '2021-05-08', '03:53:22', 'admin', NULL, NULL, NULL),
(2, 'Update', 28063, 'test', 1, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', '0.00', '1.00', 0, 0, 0, 0, 0, 'test', 'test', NULL, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', '', '', '2021-05-08', '03:53:22', 'admin', '2021-05-08', '04:00:59', 'admin'),
(3, 'Update', 28063, 'test', 1, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', '1.00', '1.00', 1, 1, 1, 1, 1, 'test', 'test', NULL, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', '2021-05-08', '03:53:22', 'admin', '2021-05-08', '04:30:21', 'admin'),
(4, 'Delete', 28063, 'test', 1, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', '1.00', '1.00', 1, 1, 1, 1, 1, 'test', 'test', NULL, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', '2021-05-08', '03:53:22', 'admin', '2021-05-08', '04:31:34', 'admin'),
(5, 'Update', 28051, '9555222610304', 456930, 'GLDAUTOSPRAYSTR175G-PEONY&BERRY*4', '310867', '2150251B-3FEE-4598-A5DE-2995A7AFB914', '110', 'NULL', 'NULL', 'NULL', 'FOODS', '0.00', '0.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '36:54:00', 'AMYRAH', '2021-05-10', '03:48:38', 'admin'),
(6, 'Update', 28062, '8888010200618', 295472, 'SCSORIGINALCHEESESLICE200G*32', '', '296872EB-AE8C-407C-928B-12E2C2B5F061', 'NULL', '', 'NULL', 'NULL', 'NULL', '0.00', '0.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:47:00', 'ADMIN', '2021-05-10', '03:49:07', 'admin'),
(7, 'Update', 28062, '8888010200618', 295472, 'SCSORIGINALCHEESESLICE200G*32', '', '296872EB-AE8C-407C-928B-12E2C2B5F061', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', '0.00', '0.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:47:00', 'ADMIN', '2021-05-10', '03:50:03', 'admin'),
(8, 'Update', 28062, '8888010200618', 295472, 'SCSORIGINALCHEESESLICE200G*32', '', '296872EB-AE8C-407C-928B-12E2C2B5F061', 'NULL', 'Null', 'NULL', 'NULL', 'NULL', '0.00', '0.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:47:00', 'ADMIN', '2021-05-10', '04:06:40', 'admin'),
(9, 'Update', 28062, '8888010200618', 295472, 'SCSORIGINALCHEESESLICE200G*32', '', '296872EB-AE8C-407C-928B-12E2C2B5F061', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '0.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:47:00', 'ADMIN', '2021-05-10', '04:07:06', 'admin'),
(10, 'Add', NULL, 'abc123', 111, '222', '333', '444', '666', '777', '888', '999', '', '0.00', '555.00', 0, 0, 0, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-05-11', '17:01:30', 'admin', NULL, NULL, NULL),
(11, 'Update', 28064, 'abc123', 111, '222bbb', '333ccc', '444ddd', '666ee', '777ff', '888gg', '999hh', 'iiiii', '0.00', '555.00', 0, 0, 0, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-05-11', '17:01:30', 'admin', '2021-05-11', '17:04:02', 'admin'),
(12, 'Delete', 28064, 'abc123', 111, '222bbb', '333ccc', '444ddd', '666ee', '777ff', '888gg', '999hh', 'iiiii', '0.00', '555.00', 0, 0, 0, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-05-11', '17:01:30', 'admin', '2021-05-11', '17:04:18', 'admin'),
(13, 'Update', 28062, '8888010200618', 295472, 'SCSORIGINALCHEESESLICE200G*32', '', '296872EB-AE8C-407C-928B-12E2C2B5F061', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '0.00', 0, 0, 1, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:47:00', 'ADMIN', '2021-06-06', '13:43:57', 'admin'),
(14, 'Update', 28062, '8888010200618', 295472, 'SCSORIGINALCHEESESLICE200G*32', '', '296872EB-AE8C-407C-928B-12E2C2B5F061', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '0.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:47:00', 'ADMIN', '2021-06-06', '13:45:19', 'admin'),
(15, 'Update', 25, '9555654804326', 53084, 'KARTACOCONUTWATER330MLX24(ORIGINAL', 'NULL', '74BEB06D-16AB-485E-909B-697E9887545E', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '0.00', 0, 0, 200, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '47:10:00', 'ADMIN', '2021-06-09', '10:23:14', 'admin'),
(16, 'Update', 2, '12276798', 71194, 'MILOACTIV-GOUHT5(8X125ML)PR6+2MY', 'NULL', '148D7F31-5C3B-48D8-9F34-D3AA3069EA0B', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '3.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '32:18:00', 'ADMIN', '2021-06-10', '18:52:26', 'admin'),
(17, 'Update', 6, '12328598', 68283, 'MILOACTIV-GONUTRIUP24X225MLMY', 'NULL', 'DAEE6DFB-3CC4-4883-8643-20438051B84A', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '3.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '35:16:00', 'ADMIN', '2021-06-10', '18:52:40', 'admin'),
(18, 'Update', 6, '12328598', 68283, 'MILOACTIV-GONUTRIUP24X225MLMY', 'NULL', 'DAEE6DFB-3CC4-4883-8643-20438051B84A', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '3.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '35:16:00', 'ADMIN', '2021-06-10', '18:52:55', 'admin'),
(19, 'Update', 28062, '8888010200618', 295472, 'SCSORIGINALCHEESESLICE200G*32', '', '296872EB-AE8C-407C-928B-12E2C2B5F061', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '3.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:47:00', 'ADMIN', '2021-06-10', '18:54:22', 'admin'),
(20, 'Update', 6, '12328598', 68283, 'MILOACTIV-GONUTRIUP24X225MLMY', 'NULL', 'DAEE6DFB-3CC4-4883-8643-20438051B84A', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '3.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '35:16:00', 'ADMIN', '2021-06-10', '18:56:12', 'admin'),
(21, 'Update', 6, '12328598', 68283, 'MILOACTIV-GONUTRIUP24X225MLMY', 'NULL', 'DAEE6DFB-3CC4-4883-8643-20438051B84A', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '3.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '35:16:00', 'ADMIN', '2021-06-10', '19:01:46', 'admin'),
(22, 'Update', 28061, '9556618180371', 462036, 'waferyam*30', 'NULL', '737EE496-6975-4F45-8D02-2E6057084AC8', '188', 'null', 'NULL', 'NULL', 'FOODS', '0.00', '3.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '24:58:00', 'SAM', '2021-06-10', '19:02:19', 'admin'),
(23, 'Update', 28061, '9556618180371', 462036, 'waferyam*30', 'NULL', '737EE496-6975-4F45-8D02-2E6057084AC8', '188', 'null', 'NULL', 'NULL', 'FOODS', '0.00', '2.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '24:58:00', 'SAM', '2021-06-10', '19:03:24', 'admin'),
(24, 'Update', 28062, '8888010200618', 295472, 'SCSORIGINALCHEESESLICE200G*32', '', '296872EB-AE8C-407C-928B-12E2C2B5F061', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '2.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:47:00', 'ADMIN', '2021-06-10', '19:04:39', 'admin'),
(25, 'Update', 6, '12328598', 68283, 'MILOACTIV-GONUTRIUP24X225MLMY', 'NULL', 'DAEE6DFB-3CC4-4883-8643-20438051B84A', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '3.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '35:16:00', 'ADMIN', '2021-06-10', '19:49:03', 'admin'),
(26, 'Update', 28062, '8888010200618', 295472, 'SCSORIGINALCHEESESLICE200G*32', '', '296872EB-AE8C-407C-928B-12E2C2B5F061', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '2.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:47:00', 'ADMIN', '2021-06-10', '20:06:56', 'tester1'),
(27, 'Add', NULL, '99999999', 9999999, '', '', '', '', '', '', '', '', '9.90', '1.23', 0, 0, 0, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-06-10', '20:55:59', 'admin', NULL, NULL, NULL),
(28, 'Update', 28065, '99999999', 9999999, '', '', '', '', '', '', '', '', '9.99', '1.55', 0, 0, 0, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-06-10', '20:55:59', 'admin', '2021-06-10', '20:57:46', 'admin'),
(29, 'Delete', 28065, '99999999', 9999999, '', '', '', '', '', '', '', '', '9.99', '1.55', 0, 0, 0, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-06-10', '20:55:59', 'admin', '2021-06-10', '20:58:12', 'admin'),
(30, 'Add', NULL, '111', 111, '', '', '', '', '', '', '', '', '1.11', '1.11', 0, 0, 0, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-06-10', '20:59:48', 'admin', NULL, NULL, NULL),
(31, 'Update', 28066, '111', 111, 'try test cuba', '', '', '', '', '', '', '', '1.11', '1.11', 0, 0, 0, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-06-10', '20:59:48', 'admin', '2021-06-10', '21:01:08', 'admin'),
(32, 'Delete', 28066, '111', 111, 'try test cuba', '', '', '', '', '', '', '', '1.11', '1.11', 0, 0, 0, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-06-10', '20:59:48', 'admin', '2021-06-10', '21:05:53', 'admin'),
(33, 'Update', 28062, '8888010200618', 295472, 'SCSORIGINALCHEESESLICE200G*32', '', '296872EB-AE8C-407C-928B-12E2C2B5F061', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '2.15', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:47:00', 'ADMIN', '2021-06-11', '12:11:55', 'admin'),
(34, 'Update', 28060, '9556618180104', 461992, 'wafercho*30', 'NULL', '81FA7B7A-D8D7-42EF-A2AF-EC85B39598B2', 'NULL', 'null', 'NULL', 'NULL', 'FOODS', '0.00', '12.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '23:10:00', 'SAM', '2021-07-03', '07:04:27', 'admin'),
(35, 'Update', 25, '9555654804326', 53084, 'KARTACOCONUTWATER330MLX24(ORIGINAL', 'NULL', '74BEB06D-16AB-485E-909B-697E9887545E', 'NULL', 'null', 'NULL', 'NULL', 'NULL', '0.00', '3.17', 0, 0, 200, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '47:10:00', 'ADMIN', '2021-07-03', '16:26:31', 'admin'),
(36, 'Update', 2051, '2661', 291364, 'MEDIPROHCGPREGNANCYTESTS', '', '8B756674-CC0D-4A60-88F1-357B7A43DB48', '64', 'null', 'NULL', 'MEDICINE', 'MEDICINE', '0.00', '30.00', 0, 0, 0, 0, 0, 'NULL', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '13:44:00', 'ADMIN', '2021-08-06', '21:19:29', 'admin'),
(37, 'Add', NULL, '001', 0, 'Test Item 1', '', '', '', '', '', '', '', '0.00', '30.00', 0, 0, 10, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-08-20', '20:32:05', 'admin', NULL, NULL, NULL),
(38, 'Add', NULL, '002', 0, 'Test Item 2', '', '', '', '', '', '', '', '0.00', '20.00', 0, 0, 10, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-08-20', '20:32:27', 'admin', NULL, NULL, NULL),
(39, 'Add', NULL, '003', 0, 'Test Item 3', '', '', '', '', '', '', '', '0.00', '15.00', 0, 0, 10, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-08-20', '20:32:42', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_no` varchar(255) NOT NULL,
  `doc_key` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `description2` varchar(255) DEFAULT NULL,
  `description3` varchar(255) DEFAULT NULL,
  `master_vendor` varchar(50) DEFAULT NULL,
  `vendor_item` varchar(50) DEFAULT NULL,
  `item_type` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `item_group` varchar(50) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `selling_price1` decimal(10,2) DEFAULT NULL,
  `qty_hand` int(11) DEFAULT NULL,
  `qty_hold` int(11) DEFAULT NULL,
  `qty_available` int(11) DEFAULT NULL,
  `qty_reorder_available` int(11) DEFAULT NULL,
  `qty_max` int(11) DEFAULT NULL,
  `vendor` varchar(50) DEFAULT NULL,
  `vendor_company` varchar(50) DEFAULT NULL,
  `item_picture` longtext DEFAULT NULL,
  `plu` varchar(255) DEFAULT NULL,
  `info1` varchar(255) DEFAULT NULL,
  `info2` varchar(255) DEFAULT NULL,
  `info3` varchar(255) DEFAULT NULL,
  `info4` varchar(255) DEFAULT NULL,
  `info5` varchar(255) DEFAULT NULL,
  `info6` varchar(255) DEFAULT NULL,
  `info7` varchar(255) DEFAULT NULL,
  `info8` varchar(255) DEFAULT NULL,
  `info9` varchar(255) DEFAULT NULL,
  `info10` varchar(255) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `creation_time` time DEFAULT NULL,
  `creation_user` varchar(100) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_no`, `doc_key`, `description`, `description2`, `description3`, `master_vendor`, `vendor_item`, `item_type`, `category`, `item_group`, `unit_cost`, `selling_price1`, `qty_hand`, `qty_hold`, `qty_available`, `qty_reorder_available`, `qty_max`, `vendor`, `vendor_company`, `item_picture`, `plu`, `info1`, `info2`, `info3`, `info4`, `info5`, `info6`, `info7`, `info8`, `info9`, `info10`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(28069, '003', 0, 'Test Item 3', '', '', '', '', '', '', '', '0.00', '15.00', 0, 0, -18, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-08-20', '20:32:42', 'admin', NULL, NULL, NULL),
(28067, '001', 0, 'Test Item 1', '', '', '', '', '', '', '', '0.00', '30.00', 0, 0, 7, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-08-20', '20:32:05', 'admin', NULL, NULL, NULL),
(28068, '002', 0, 'Test Item 2', '', '', '', '', '', '', '', '0.00', '20.00', 0, 0, 10, 0, 0, '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '2021-08-20', '20:32:27', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parameter`
--

CREATE TABLE `parameter` (
  `parameter_id` int(11) NOT NULL,
  `para_code` varchar(100) NOT NULL,
  `para_description` varchar(255) NOT NULL,
  `para_description2` varchar(255) NOT NULL,
  `para_description3` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `para_image` longtext DEFAULT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(100) NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL,
  `filler1` varchar(10) DEFAULT NULL,
  `filler2` varchar(10) DEFAULT NULL,
  `filler3` varchar(10) DEFAULT NULL,
  `filler4` varchar(10) DEFAULT NULL,
  `filler5` varchar(10) DEFAULT NULL,
  `filler6` varchar(10) DEFAULT NULL,
  `filler7` varchar(10) DEFAULT NULL,
  `filler8` varchar(10) DEFAULT NULL,
  `filler9` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parameter`
--

INSERT INTO `parameter` (`parameter_id`, `para_code`, `para_description`, `para_description2`, `para_description3`, `start_date`, `end_date`, `start_time`, `end_time`, `quantity`, `amount`, `para_image`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`, `filler1`, `filler2`, `filler3`, `filler4`, `filler5`, `filler6`, `filler7`, `filler8`, `filler9`) VALUES
(1, 'bank_name', 'Affin Bank Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:41:35', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'bank_name', 'Al Rajhi Banking And Investment Corporation', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:41:44', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'bank_name', 'Alliance Bank Malaysia Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:41:54', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'bank_name', 'AmBank (M) Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:42:31', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'bank_name', 'BNP Paribas (Malaysia) Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:42:42', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'bank_name', 'Bank Islam Malaysia Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:42:53', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'bank_name', 'Bank Kerjasama Rakyat Malaysia Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:43:07', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'bank_name', 'Bank Muamalat (Malaysia) Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:43:15', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'bank_name', 'Bank Of America Malaysia Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:43:23', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'bank_name', 'Bank Pertanian Malaysia Berhad (Agrobank)', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:43:30', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'bank_name', 'Bank Simpanan Nasional Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:43:37', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'bank_name', 'Bank of China (Malaysia) Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:43:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'bank_name', 'CIMB Bank Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:43:52', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'bank_name', 'Citibank Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:44:01', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'bank_name', 'Deutsche Bank (Malaysia) Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:44:09', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'bank_name', 'Finexus Cards Sdn. Bhd.', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:44:16', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'bank_name', 'HSBC Bank Malaysia Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:44:23', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'bank_name', 'Hong Leong Bank Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:44:31', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'bank_name', 'Industrial And Commercial Bank of China (ICBC)', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:44:39', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'bank_name', 'JP Morgan Chase Bank Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:44:47', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'bank_name', 'Kuwait Finance House (Malaysia) Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:44:55', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'bank_name', 'MBSB Bank', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:45:10', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'bank_name', 'MUFG Bank (Malaysia) Bhd', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:45:18', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'bank_name', 'Maybank Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:45:25', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'bank_name', 'Mizuho Bank (Malaysia) Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:45:33', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'bank_name', 'OCBC Bank (Malaysia) Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:45:41', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'bank_name', 'RHB Bank Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:45:49', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'bank_name', 'Standard Chartered Bank (Malaysia) Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:45:57', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'bank_name', 'Sumitomo Mitsui Banking Corporation', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:46:05', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'bank_name', 'United Overseas Bank (Malaysia) Berhad', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:46:13', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'payment_type', 'Cheque', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:46:53', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'payment_type', 'Cash', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:47:02', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'payment_type', 'IBG', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:47:10', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'payment_type', 'Instant Transfer', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:47:18', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'payment_type', 'Others', '', '', '2021-03-30', '2021-03-30', '12:41:00', '12:41:00', 0, '0.00', '', '2021-03-30', '12:47:27', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'state_name', 'Johor', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:49:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'state_name', 'Penang', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:50:18', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'state_name', 'Kedah', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:50:26', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'state_name', 'Perak', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:50:34', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'state_name', 'Kelantan	', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:50:41', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'state_name', 'Perlis', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:50:49', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'state_name', 'Kuala Lumpur	', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:50:56', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'state_name', 'Putrajaya', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:51:04', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'state_name', 'Labuan', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:51:14', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'state_name', 'Sabah', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:51:21', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'state_name', 'Melaka', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:51:28', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'state_name', 'Sarawak', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:51:35', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'state_name', 'Negeri Sembilan', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:51:42', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'state_name', 'Selangor', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:51:50', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'state_name', 'Pahang', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:51:57', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'state_name', 'Terengganu', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:52:09', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'currency_code', 'CNY', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:53:19', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'currency_code', 'HKD', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:53:26', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'currency_code', 'MYR', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:53:33', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'currency_code', 'SGD', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:53:40', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'currency_code', 'THB', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:53:47', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'currency_code', 'TWD', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:53:53', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'currency_code', 'USD', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:54:01', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'account_desc', 'Trade Debtors	', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 1000, '0.00', '', '2021-04-02', '14:56:35', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'account_desc', 'Trade Creditors', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 2000, '0.00', '', '2021-04-02', '14:58:40', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'account_desc', 'Expenses	', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 3000, '0.00', '', '2021-04-02', '14:58:56', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'account_desc', 'Bank', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 1000, '0.00', '', '2021-04-02', '14:59:11', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'account_desc', 'Revenue', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:59:21', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'account_desc', 'Bad debt', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '14:59:28', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'account_desc', 'GST -Input Tax	', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 6000, '0.00', '', '2021-04-02', '14:59:47', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'account_desc', 'GST -Output Tax', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 6000, '0.00', '', '2021-04-02', '15:00:00', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'account_desc', 'GST -Disallow Input Tax', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 6000, '0.00', '', '2021-04-02', '15:00:10', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'account_desc', 'GST -Disallow Output Tax', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 6000, '0.00', '', '2021-04-02', '15:00:21', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'company_name', 'NIGHTCAT', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:01:56', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'company_c_name', '夜猫', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:02:12', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'company_address1', '46 , Jalan Anggerik 2', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:02:36', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'company_address2', 'Taman Kulai Utama', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:03:02', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'company_poscode', '81000', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:03:28', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'company_state', 'Johor', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:03:42', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'company_country', 'Malaysia', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:04:02', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'company_phonenumber', '0126113810', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:04:23', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'company_regno', 'JM0663046-U', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:04:36', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'expenses_category', 'Repair & Maintenance', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:05:38', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'expenses_category', 'Road Tax', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:05:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 'expenses_category', 'Insurance', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:05:52', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'expenses_category', 'Fuel', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:05:58', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 'expenses_category', 'Tol', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:06:05', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 'expenses_category', 'Transport', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:06:12', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 'expenses_category', 'Goods', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:06:18', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 'expenses_category', 'Rental', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:06:25', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 'expenses_category', 'Water', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:06:31', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 'expenses_category', 'Electricity', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:06:38', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 'expenses_category', 'Food & Refreshment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:06:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 'expenses_category', 'Printing & Stationery', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:06:52', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 'expenses_category', 'Asset', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:07:00', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 'expenses_category', 'Courier Fee', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:07:06', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 'expenses_category', 'Phone', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:07:12', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 'expenses_category', 'Cukai Harta', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:07:18', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 'expenses_category', 'Medical', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:07:26', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 'expenses_category', 'Travel', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:07:39', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 'expenses_category', 'Sundries', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:07:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 'expenses_category', 'Bank', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:07:52', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 'expenses_category', 'Indah Water', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:07:58', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 'expenses_category', 'Loose Tools', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:08:04', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 'expenses_category', 'Gift', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:08:10', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 'expenses_category', 'Donation', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:08:17', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 'expenses_category', 'License Fee', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:08:23', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 'expenses_category', 'Compound', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:08:30', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 'expenses_category', 'Inspection', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:08:37', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 'expenses_category', 'Equipment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:08:43', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 'tax_category', 'Fixed Asset', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:21:38', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 'tax_category', 'Accumulated Depreciation', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:21:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 'tax_category', 'Other Asset', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:21:52', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 'tax_category', 'Current Asset', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:21:58', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 'tax_category', 'Current Liability', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:22:07', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 'tax_category', 'Long Term Liabilities', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:22:13', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 'tax_category', 'Other Liabilities', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:22:20', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 'tax_category', 'Capital', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:22:25', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 'tax_category', 'Retained Earning', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:22:31', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 'tax_category', 'Sales', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:22:37', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 'tax_category', 'Sales Adjustment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:22:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 'tax_category', 'Cost of Good Sold', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:22:51', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 'tax_category', 'Other Income', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:22:57', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 'tax_category', 'Expenses', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:23:04', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 'tax_category', 'Taxation', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:23:10', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 'tax_category', 'Extra Ordinary Income/ Expenses', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:23:17', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 'tax_category', 'Apropriation Account', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:23:23', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 'tax_detail', 'Building', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:25:00', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 'tax_detail', 'Freehold Land & Building', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:25:07', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 'tax_detail', 'Furniture & Fitting', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:25:13', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 'tax_detail', 'Motor Vehicles', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:25:19', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 'tax_detail', 'Office Equipment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:25:28', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 'tax_detail', 'Plant &  Machineries', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:26:07', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 'tax_detail', 'Electrical Installation', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:26:14', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 'tax_detail', 'Software', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:26:22', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 'tax_detail', 'Accum. Depn. For Building', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:26:30', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(133, 'tax_detail', 'Accum. Depn. For Furniture & Fitting', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:26:36', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 'tax_detail', 'Accum. Depn. For M/vehicles', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:26:43', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(135, 'tax_detail', 'Accum. Depn. For Office Equipment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:26:50', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(136, 'tax_detail', 'Accum. Depn. For Plant/ Machineries', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:26:56', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, 'tax_detail', 'Accum. Depn. For Electrical Installation', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:27:03', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(138, 'tax_detail', 'Accum. Depn. For Software', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:27:09', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 'tax_detail', 'GST Input Tax', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:27:18', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 'tax_detail', 'Alliance Bank', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:27:24', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 'tax_detail', 'Cash in Hand', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:27:32', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 'tax_detail', 'Deposit', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:27:42', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 'tax_detail', 'Fixed Deposit', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:27:49', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 'tax_detail', 'Customer Deposit', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:28:00', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 'tax_detail', 'Income Tax', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:28:06', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 'tax_detail', 'GST Claimable-AP', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:28:13', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 'tax_detail', 'Trade Debtor', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:28:19', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(148, 'tax_detail', 'Stock', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:28:26', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(149, 'tax_detail', 'Goodwill', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:28:33', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(150, 'tax_detail', 'Accruals', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:28:39', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(151, 'tax_detail', 'B. A. Loan', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:28:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(152, 'tax_detail', 'Fixed Load', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:28:52', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(153, 'tax_detail', 'Provision for Taxation', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:29:00', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(154, 'tax_detail', 'GST Payable-AR', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:29:20', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(155, 'tax_detail', 'Trade Creditor', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:29:27', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(156, 'tax_detail', 'Long Term Liabilities', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:29:34', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 'tax_detail', 'GST Output Tax', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:29:42', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 'tax_detail', 'GST Control Acount', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:29:49', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 'tax_detail', 'Capital Reserve', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:29:55', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(160, 'tax_detail', 'Share Capital', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:30:01', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(161, 'tax_detail', 'This year Profit /(Loss)', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:30:14', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(162, 'tax_detail', 'Profit & Loss account', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:30:20', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(163, 'tax_detail', 'Sales of Rice/Dedak/ Temekut', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:30:27', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(164, 'tax_detail', 'Cash Sales', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:30:33', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(165, 'tax_detail', 'Discount Allowed', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:30:42', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(166, 'tax_detail', 'Sale Rounding Adjustment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:30:48', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(167, 'tax_detail', 'Opening Stock', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:30:53', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(168, 'tax_detail', 'Obsolete Stock', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:30:59', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(169, 'tax_detail', 'Purchase of Rice', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:31:05', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(170, 'tax_detail', 'Cash Purchase of Rice', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:31:12', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(171, 'tax_detail', 'Discount Received', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:31:20', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(172, 'tax_detail', 'Purchase Rounding Adjustment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:31:26', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(173, 'tax_detail', 'Closing Stock', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:31:32', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(174, 'tax_detail', 'Interest Receivable', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:31:38', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(175, 'tax_detail', 'Fixed Deposit Interest', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:31:46', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(176, 'tax_detail', 'GST Expenses', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:32:02', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(177, 'tax_detail', 'Audit Fees', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:32:10', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(178, 'tax_detail', 'Assessment Fees', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:32:17', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(179, 'tax_detail', 'Advertisement', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:32:24', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(180, 'tax_detail', 'Application Fees', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:32:31', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(181, 'tax_detail', 'Bank Charges', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:32:38', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(183, 'tax_detail', 'Bank Commitement Fees', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:32:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(184, 'tax_detail', 'Bank Interest', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:32:53', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(185, 'tax_detail', 'B. A. Interest', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:33:00', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(187, 'tax_detail', 'B. A. Commision', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:33:06', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(188, 'tax_detail', 'Bad Debt Written Off', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:33:13', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(189, 'tax_detail', 'Bonus', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:33:19', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(190, 'tax_detail', 'Diesel', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:33:26', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(191, 'tax_detail', 'Director Fee', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:33:33', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(192, 'tax_detail', 'Director Salaries', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:33:41', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(193, 'tax_detail', 'Dividends Paid', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:33:48', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(194, 'tax_detail', 'Donation & Subscription', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:33:54', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(195, 'tax_detail', 'Depn. for Building', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:34:00', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(196, 'tax_detail', 'Depn. for Electrical Maintenance', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:34:09', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(197, 'tax_detail', 'Depn. for Furniture & Fitting', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:34:18', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(198, 'tax_detail', 'Depn. for M/Vehicles', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:34:24', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(199, 'tax_detail', 'Depn. for Office Equipment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:34:31', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(200, 'tax_detail', 'Depn. for Plant & Machineries', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:34:37', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(201, 'tax_detail', 'Depn. for Software', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:34:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(202, 'tax_detail', 'E.P.F.', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:34:51', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(203, 'tax_detail', 'Electricity', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:34:58', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(204, 'tax_detail', 'Electrical Maintenance', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:35:05', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(205, 'tax_detail', 'Food & Refrestment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:35:12', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(206, 'tax_detail', 'Handling Charges', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:35:19', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(207, 'tax_detail', 'Insurance', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:35:26', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(208, 'tax_detail', 'Inspection of Weight Machine', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:35:33', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(209, 'tax_detail', 'Jumbo bag/ Plastic Bag', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:35:41', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(210, 'tax_detail', 'Land Tax', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:35:48', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211, 'tax_detail', 'Licenses Fee', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:35:55', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(212, 'tax_detail', 'Lease Rental-Forklift', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:36:02', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(213, 'tax_detail', 'Newspaper', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:36:09', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(214, 'tax_detail', 'Overtime Paid', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:36:18', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(215, 'tax_detail', 'Postage & Stamp', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:36:23', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(216, 'tax_detail', 'Printing & Stationeries', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:36:29', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(217, 'tax_detail', 'Packing Materials', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:36:35', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(218, 'tax_detail', 'Penalty', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:36:42', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(219, 'tax_detail', 'P.C.B.', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:36:49', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(220, 'tax_detail', 'Professional Fees', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:36:55', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(221, 'tax_detail', 'Petrol', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:37:01', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(222, 'tax_detail', 'Processing Fees', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:37:07', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(223, 'tax_detail', 'Road Tax and Carriage License', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:37:13', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(224, 'tax_detail', 'SOCSO', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:37:19', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(225, 'tax_detail', 'Salaries', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:37:27', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(226, 'tax_detail', 'Sundries Expenses', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:37:33', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(227, 'tax_detail', 'Secretarial Fees', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:37:39', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `parameter` (`parameter_id`, `para_code`, `para_description`, `para_description2`, `para_description3`, `start_date`, `end_date`, `start_time`, `end_time`, `quantity`, `amount`, `para_image`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`, `filler1`, `filler2`, `filler3`, `filler4`, `filler5`, `filler6`, `filler7`, `filler8`, `filler9`) VALUES
(228, 'tax_detail', 'Staff Medical Allowance', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:37:46', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(229, 'tax_detail', 'Obsolete Stock /2nd Hand Stock', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:37:52', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(230, 'tax_detail', 'Telephone Charges', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:37:59', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(231, 'tax_detail', 'Transport Charges', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:38:05', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(232, 'tax_detail', 'Upkeep for Building', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:38:11', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(233, 'tax_detail', 'Upkeep for Furniture & Fitting', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:38:18', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(234, 'tax_detail', 'Upkeep for M/Vehicles', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:38:25', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(235, 'tax_detail', 'Upkeep for Office Equipment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:38:33', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(236, 'tax_detail', 'Upkeep for Plant & Machineries', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:38:39', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(237, 'tax_detail', 'Wages', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:38:45', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(238, 'tax_detail', 'Water Rate', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:38:51', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(239, 'tax_detail', 'Expenses Rounding Adjustment', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:38:57', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(240, 'tax_detail', 'Taxation', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:39:03', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(241, 'tax_detail', 'Extra Ordinary Income/ Expenses', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:39:10', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(242, 'tax_detail', 'Apropriation Account', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:39:17', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(243, 'homepage', 'https://nightcatdigitalsolutions.com/winys/menu.php', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:47:38', 'admin', '2021-09-13', '19:33:16', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(244, 'menu_button', 'User Maintenance', 'userMaintenance.php', 'administrator', '2021-04-02', '2021-04-02', '17:47:00', '17:47:00', 300, '0.00', '', '2021-04-02', '17:50:39', 'admin', '2021-05-03', '18:01:05', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(245, 'menu_button', 'Parameter Maintenance', 'parameterMaintenance.php', 'administrator, staff', '2021-04-02', '2021-04-02', '17:47:00', '17:47:00', 200, '0.00', '', '2021-04-02', '17:51:05', 'admin', '2021-05-03', '18:00:51', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(248, 'payment_type', 'nightcattetst', 'qwe', '', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-05', '23:19:05', 'nightcattest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(247, 'payment_type', 'nightcatpaymen444', 'nightcatpaymen444555', 'nightcatpaymen444666', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-05', '23:10:16', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(249, 'payment_type', 'qweqweasdasd', 'qweqweasdasd', 'qweqweasdasd', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-05', '23:21:19', 'nightcattest', '2021-04-05', '23:21:49', 'nightcattest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(252, 'menu_button', 'Item Maintenance', 'itemMaintenance.php', 'administrator, staff', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 100, '0.00', '', '2021-04-14', '10:06:18', 'admin', '2021-05-03', '18:00:29', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(253, 'menu_button', 'Customer Maintenance', 'customerMaintenance.php', 'administrator, staff', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 101, '0.00', '', '2021-05-22', '12:18:42', 'tester1', '2021-06-21', '12:35:55', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(254, 'menu_button', 'Invoice Maintenance', 'invoiceMaintenance.php', 'administrator', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 102, '0.00', '', '2021-06-06', '12:15:31', 'tester1', '2021-06-21', '12:36:06', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(255, 'menu_button', 'Payment Maintenance', 'paymentMaintenance.php', 'administrator', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-07-02', '22:40:43', 'tester1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(256, 'menu_button', 'Sale Maintenance', 'saleMaintenance.php', 'administrator', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-08-02', '19:47:09', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parameterlog`
--

CREATE TABLE `parameterlog` (
  `para_logid` int(11) NOT NULL,
  `parameter_id` int(11) DEFAULT NULL,
  `mode` varchar(20) NOT NULL,
  `para_code` varchar(100) NOT NULL,
  `para_description` varchar(255) NOT NULL,
  `para_description2` varchar(255) NOT NULL,
  `para_description3` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `para_image` longtext DEFAULT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(100) NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(100) DEFAULT NULL,
  `filler1` varchar(10) DEFAULT NULL,
  `filler2` varchar(10) DEFAULT NULL,
  `filler3` varchar(10) DEFAULT NULL,
  `filler4` varchar(10) DEFAULT NULL,
  `filler5` varchar(10) DEFAULT NULL,
  `filler6` varchar(10) DEFAULT NULL,
  `filler7` varchar(10) DEFAULT NULL,
  `filler8` varchar(10) DEFAULT NULL,
  `filler9` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parameterlog`
--

INSERT INTO `parameterlog` (`para_logid`, `parameter_id`, `mode`, `para_code`, `para_description`, `para_description2`, `para_description3`, `start_date`, `end_date`, `start_time`, `end_time`, `quantity`, `amount`, `para_image`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`, `filler1`, `filler2`, `filler3`, `filler4`, `filler5`, `filler6`, `filler7`, `filler8`, `filler9`) VALUES
(1, NULL, 'Add', 'nightcat_type', 'tes1', '', '', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 111, '222.00', '', '2021-04-02', '13:18:32', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 65, 'Update', 'nightcat_type', 'tes122', '', '', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 11122, '222.00', '', '2021-04-02', '13:18:32', 'admin', '2021-04-02', '13:48:37', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, 'Add', 'nightcat_type', 'tes333', '', '', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 333, '333.00', '', '2021-04-02', '13:48:54', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, 'Add', 'payment_type', 'nightcatpayment1', 'nightcatpaymen2', 'nightcatpaymen3', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-05', '23:08:59', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, 'Add', 'payment_type', 'nightcatpaymen444', 'nightcatpaymen444555', 'nightcatpaymen444666', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-05', '23:10:16', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 246, 'Delete', 'payment_type', 'nightcatpayment1', 'nightcatpaymen2', 'nightcatpaymen3', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-05', '23:08:59', 'admin', '2021-04-05', '23:11:02', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, 'Add', 'payment_type', 'nightcattetst', 'qwe', '', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-05', '23:19:05', 'nightcattest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, NULL, 'Add', 'payment_type', 'qweqwe', 'qweqwe', 'qweqwe', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-05', '23:21:19', 'nightcattest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 249, 'Update', 'payment_type', 'qweqweasdasd', 'qweqweasdasd', 'qweqweasdasd', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-05', '23:21:19', 'nightcattest', '2021-04-05', '23:21:49', 'nightcattest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, 'Clone', 'payment_type', 'cloning', '', '', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-06', '01:40:05', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 250, 'Delete', 'payment_type', 'cloning', '', '', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-06', '01:40:05', 'admin', '2021-04-06', '01:52:40', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, NULL, 'Add', 'test', '', '', '', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-09', '04:54:48', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 251, 'Delete', 'test', '', '', '', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-09', '04:54:48', 'admin', '2021-04-09', '04:56:04', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, 'Add', 'menu_button', 'Item Maintenance', 'itemMaintenance.php', 'admin, staff', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-14', '10:06:18', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 252, 'Update', 'menu_button', 'Item Maintenance', 'itemMaintenance.php', 'administrator, staff', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-04-14', '10:06:18', 'admin', '2021-04-14', '10:06:52', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 244, 'Update', 'menu_button', 'User Maintenance', 'userMaintenance.php', 'administrator', '2021-04-02', '2021-04-02', '17:47:00', '17:47:00', 100, '0.00', '', '2021-04-02', '17:50:39', 'admin', '2021-05-03', '17:55:47', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 252, 'Update', 'menu_button', 'Item Maintenance', 'itemMaintenance.php', 'administrator, staff', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 200, '0.00', '', '2021-04-14', '10:06:18', 'admin', '2021-05-03', '17:56:11', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 245, 'Update', 'menu_button', 'Parameter Maintenance', 'parameterMaintenance.php', 'administrator, staff', '2021-04-02', '2021-04-02', '17:47:00', '17:47:00', 300, '0.00', '', '2021-04-02', '17:51:05', 'admin', '2021-05-03', '17:56:20', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 252, 'Update', 'menu_button', 'Item Maintenance', 'itemMaintenance.php', 'administrator, staff', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 100, '0.00', '', '2021-04-14', '10:06:18', 'admin', '2021-05-03', '18:00:29', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 245, 'Update', 'menu_button', 'Parameter Maintenance', 'parameterMaintenance.php', 'administrator, staff', '2021-04-02', '2021-04-02', '17:47:00', '17:47:00', 200, '0.00', '', '2021-04-02', '17:51:05', 'admin', '2021-05-03', '18:00:51', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 244, 'Update', 'menu_button', 'User Maintenance', 'userMaintenance.php', 'administrator', '2021-04-02', '2021-04-02', '17:47:00', '17:47:00', 300, '0.00', '', '2021-04-02', '17:50:39', 'admin', '2021-05-03', '18:01:05', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, NULL, 'Add', 'menu_button', 'Customer Maintenance', 'customerMaintenance.php', 'administrator, staff', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-05-22', '12:18:42', 'tester1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, NULL, 'Add', 'menu_button', 'Invoice Maintenance', 'invoiceMaintenance.php', 'administrator', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-06-06', '12:15:31', 'tester1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 253, 'Update', 'menu_button', 'Customer Maintenance', 'customerMaintenance.php', 'administrator, staff', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 101, '0.00', '', '2021-05-22', '12:18:42', 'tester1', '2021-06-21', '12:35:55', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 254, 'Update', 'menu_button', 'Invoice Maintenance', 'invoiceMaintenance.php', 'administrator', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 102, '0.00', '', '2021-06-06', '12:15:31', 'tester1', '2021-06-21', '12:36:06', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, NULL, 'Add', 'menu_button', 'Payment Maintenance', 'paymentMaintenance.php', 'administrator', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-07-02', '22:40:43', 'tester1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, NULL, 'Add', 'menu_button', 'Sale Maintenance', 'sale_maintenance.php', 'administrator', '0000-00-00', '0000-00-00', '00:00:00', '00:00:00', 0, '0.00', '', '2021-08-02', '19:47:09', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 243, 'Update', 'homepage', 'https://nightcatdigitalsolutions.com/winys/menu.php', '', '', '2021-04-02', '2021-04-02', '14:49:00', '14:49:00', 0, '0.00', '', '2021-04-02', '15:47:38', 'admin', '2021-09-13', '19:33:16', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_detail`
--

CREATE TABLE `payment_detail` (
  `payment_detail_id` int(11) NOT NULL,
  `payment_identifier` varchar(255) NOT NULL,
  `invoice_id` varchar(255) NOT NULL,
  `amount_pay` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_detail`
--

INSERT INTO `payment_detail` (`payment_detail_id`, `payment_identifier`, `invoice_id`, `amount_pay`) VALUES
(4, 'p20210724074613', 'iv20210724064503', '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `payment_header`
--

CREATE TABLE `payment_header` (
  `payment_id` int(11) NOT NULL,
  `payment_identifier` varchar(255) NOT NULL,
  `customer_account` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_mode` varchar(20) NOT NULL,
  `payment_salesperson` varchar(50) NOT NULL,
  `payment_remark` varchar(255) NOT NULL,
  `total_payment_amount` decimal(10,2) NOT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_header`
--

INSERT INTO `payment_header` (`payment_id`, `payment_identifier`, `customer_account`, `customer_name`, `payment_date`, `payment_mode`, `payment_salesperson`, `payment_remark`, `total_payment_amount`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(3, 'p20210724074613', 'tester2', 'tester2', '1990-01-01', '', '', '', '2.00', '2021-07-24', '07:46:13', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sale_detail`
--

CREATE TABLE `sale_detail` (
  `sale_detail_id` int(11) NOT NULL,
  `sale_id_header` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_detail`
--

INSERT INTO `sale_detail` (`sale_detail_id`, `sale_id_header`, `item_id`, `item_no`, `description`, `uom`, `qty`, `price`, `discount`, `amount`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(70, 'SO20210830210359', 28069, '003', 'Test Item 3', 'unit', 2, '30.00', '0.00', '15.00', '2021-08-30', '21:03:59', 'admin', NULL, NULL, NULL),
(71, 'SO20210830211313', 28069, '003', 'Test Item 3', 'unit', 1, '15.00', '0.00', '15.00', '2021-08-30', '21:13:13', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sale_detail_log`
--

CREATE TABLE `sale_detail_log` (
  `sale_detail_id` int(11) NOT NULL,
  `mode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_id_header` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_detail_log`
--

INSERT INTO `sale_detail_log` (`sale_detail_id`, `mode`, `sale_id_header`, `item_id`, `item_no`, `description`, `uom`, `qty`, `price`, `discount`, `amount`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(75, 'Add', 'SO20210821105259', 28069, '003', 'Test Item 3', 'unit', 2, '30.00', '0.00', '15.00', '2021-08-21', '10:52:59', 'admin', NULL, NULL, NULL),
(76, 'Add', 'SO20210821105502', 28067, '001', 'Test Item 1', 'unit', 1, '30.00', '0.00', '30.00', '2021-08-21', '10:55:02', 'admin', NULL, NULL, NULL),
(77, 'Add', 'SO20210821105502', 28068, '002', 'Test Item 2', 'unit', 1, '20.00', '0.00', '20.00', '2021-08-21', '10:55:02', 'admin', NULL, NULL, NULL),
(78, 'Update', 'SO20210821105502', 28067, '001', 'Test Item 1', '', 1, '30.00', '0.00', '30.00', '2021-08-21', '11:13:47', 'admin', '2021-08-21', '11:13:47', 'admin'),
(79, 'Update', 'SO20210821105502', 28068, '002', 'Test Item 2', '', 1, '20.00', '0.00', '20.00', '2021-08-21', '11:13:47', 'admin', '2021-08-21', '11:13:47', 'admin'),
(80, 'Update', 'SO20210821105502', 28069, '003', 'Test Item 3', 'unit', 1, '15.00', '0.00', '15.00', '2021-08-21', '11:13:47', 'admin', '2021-08-21', '11:13:47', 'admin'),
(81, 'Add', 'SO20210821114436', 28067, '001', 'Test Item 1', 'unit', 1, '29.10', '3.00', '30.00', '2021-08-21', '11:44:36', 'admin', NULL, NULL, NULL),
(82, 'Add', 'SO20210821114436', 28068, '002', 'Test Item 2', 'unit', 1, '19.60', '2.00', '20.00', '2021-08-21', '11:44:36', 'admin', NULL, NULL, NULL),
(83, 'Add', 'SO20210821135138', 28069, '003', 'Test Item 3', 'unit', 1, '14.85', '1.00', '15.00', '2021-08-21', '13:51:38', 'admin', NULL, NULL, NULL),
(84, 'Add', 'SO20210824194245', 28069, '003', 'Test Item 3', 'unit', 1, '15.00', '0.00', '15.00', '2021-08-24', '19:42:45', 'admin', NULL, NULL, NULL),
(85, 'Add', 'SO20210830195657', 28069, '003', 'Test Item 3', 'unit', 3, '45.00', '0.00', '15.00', '2021-08-30', '19:56:57', 'admin', NULL, NULL, NULL),
(86, 'Update', 'SO20210830195657', 28069, '003', 'Test Item 3', '', 2, '30.00', '0.00', '15.00', '2021-08-30', '20:14:21', 'admin', '2021-08-30', '20:14:21', 'admin'),
(87, 'Add', 'SO20210830204439', 28069, '003', 'Test Item 3', 'unit', 2, '30.00', '0.00', '15.00', '2021-08-30', '20:44:39', 'admin', NULL, NULL, NULL),
(88, 'Add', 'SO20210830204700', 28069, '003', 'Test Item 3', 'unit', 2, '30.00', '0.00', '15.00', '2021-08-30', '20:47:00', 'admin', NULL, NULL, NULL),
(89, 'Add', 'SO20210830210359', 28069, '003', 'Test Item 3', 'unit', 2, '30.00', '0.00', '15.00', '2021-08-30', '21:03:59', 'admin', NULL, NULL, NULL),
(90, 'Add', 'SO20210830211313', 28069, '003', 'Test Item 3', 'unit', 1, '15.00', '0.00', '15.00', '2021-08-30', '21:13:13', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sale_header`
--

CREATE TABLE `sale_header` (
  `id` int(11) NOT NULL,
  `sale_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_date` date NOT NULL,
  `sale_phone_num` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_salesperson` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_subtotal` decimal(10,2) NOT NULL,
  `sale_discount_header` decimal(10,2) NOT NULL,
  `sale_total_amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isOnHold` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_header`
--

INSERT INTO `sale_header` (`id`, `sale_id`, `customer_account`, `customer_name`, `sale_date`, `sale_phone_num`, `sale_salesperson`, `sale_subtotal`, `sale_discount_header`, `sale_total_amount`, `payment_status`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`, `isOnHold`) VALUES
(47, 'SO20210830210359', 'CASH', 'CASH', '2021-08-30', ' ', '', '30.00', '0.00', '30.00', 'Paid', '2021-08-30', '21:03:59', 'admin', NULL, NULL, NULL, 0),
(48, 'SO20210830211313', 'CASH', 'CASH', '2021-08-30', ' ', '', '15.00', '0.00', '15.00', 'UnPaid', '2021-08-30', '21:13:13', 'admin', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_header_log`
--

CREATE TABLE `sale_header_log` (
  `id` int(11) NOT NULL,
  `mode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_date` date NOT NULL,
  `sale_phone_num` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_salesperson` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_subtotal` decimal(10,2) NOT NULL,
  `sale_discount_header` decimal(10,2) NOT NULL,
  `sale_total_amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isOnHold` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_header_log`
--

INSERT INTO `sale_header_log` (`id`, `mode`, `sale_id`, `customer_account`, `customer_name`, `sale_date`, `sale_phone_num`, `sale_salesperson`, `sale_subtotal`, `sale_discount_header`, `sale_total_amount`, `payment_status`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`, `isOnHold`) VALUES
(74, 'Add', 'SO20210821105259', 'CASH', 'CASH', '2021-08-21', ' ', 'tester1', '0.00', '0.00', '30.00', 'Paid', '2021-08-21', '10:52:59', 'admin', NULL, NULL, NULL, 0),
(75, 'Add', 'SO20210821105502', 'CASH', 'CASH', '2021-08-21', ' ', 'tester1', '0.00', '0.00', '50.00', 'UnPaid', '2021-08-21', '10:55:02', 'admin', NULL, NULL, NULL, 1),
(76, 'Update', 'SO20210821105502', 'CASH', 'CASH', '2021-08-21', ' ', 'tester1', '0.00', '0.00', '65.00', 'UnPaid', '2021-08-21', '10:55:02', 'admin', '2021-08-21', '11:13:47', 'admin', 1),
(77, 'Add', 'SO20210821105502', 'CASH', 'CASH', '2021-08-21', ' ', 'tester1', '0.00', '0.00', '65.00', 'Paid', '2021-08-21', '10:55:02', 'admin', NULL, NULL, NULL, 0),
(78, 'Add', 'SO20210821114436', 'CASH', 'CASH', '2021-08-21', ' ', '', '0.00', '1.30', '48.70', 'UnPaid', '2021-08-21', '11:44:36', 'admin', NULL, NULL, NULL, 1),
(79, 'Add', 'SO20210821114436', 'CASH', 'CASH', '2021-08-21', ' ', '', '0.00', '1.30', '48.70', 'Paid', '2021-08-21', '11:44:36', 'admin', NULL, NULL, NULL, 0),
(80, 'Add', 'SO20210821135138', 'CASH', 'CASH', '2021-08-21', ' ', 'tester1', '15.00', '0.15', '14.85', 'Paid', '2021-08-21', '13:51:38', 'admin', NULL, NULL, NULL, 0),
(81, 'Add', 'SO20210824194245', 'CASH', 'CASH', '2021-08-24', ' ', 'tester1', '15.00', '0.00', '15.00', 'UnPaid', '2021-08-24', '19:42:45', 'admin', NULL, NULL, NULL, 1),
(82, 'Add', 'SO20210824194245', 'CASH', 'CASH', '2021-08-24', ' ', 'tester1', '15.00', '0.00', '15.00', 'Paid', '2021-08-24', '19:42:45', 'admin', NULL, NULL, NULL, 0),
(83, 'Add', 'SO20210830195657', 'CASH', 'CASH', '2021-08-30', ' ', '', '45.00', '0.00', '45.00', 'UnPaid', '2021-08-30', '19:56:57', 'admin', NULL, NULL, NULL, 1),
(84, 'Update', 'SO20210830195657', 'CASH', 'CASH', '2021-08-30', ' ', '', '30.00', '0.00', '30.00', 'UnPaid', '2021-08-30', '19:56:57', 'admin', '2021-08-30', '20:14:21', 'admin', 1),
(85, 'Add', 'SO20210830204439', 'CASH', 'CASH', '2021-08-30', ' ', '', '30.00', '0.00', '30.00', 'UnPaid', '2021-08-30', '20:44:39', 'admin', NULL, NULL, NULL, 1),
(86, 'Add', 'SO20210830204439', 'CASH', 'CASH', '2021-08-30', ' ', '', '30.00', '0.00', '30.00', 'Paid', '2021-08-30', '20:44:39', 'admin', NULL, NULL, NULL, 0),
(87, 'Add', 'SO20210830204700', 'CASH', 'CASH', '2021-08-30', ' ', '', '30.00', '0.00', '30.00', 'UnPaid', '2021-08-30', '20:47:00', 'admin', NULL, NULL, NULL, 1),
(88, 'Add', 'SO20210830204700', 'CASH', 'CASH', '2021-08-30', ' ', '', '30.00', '0.00', '30.00', 'Paid', '2021-08-30', '20:47:00', 'admin', NULL, NULL, NULL, 0),
(89, 'Add', 'SO20210830210359', 'CASH', 'CASH', '2021-08-30', ' ', '', '30.00', '0.00', '30.00', 'UnPaid', '2021-08-30', '21:03:59', 'admin', NULL, NULL, NULL, 1),
(90, 'Add', 'SO20210830210359', 'CASH', 'CASH', '2021-08-30', ' ', '', '30.00', '0.00', '30.00', 'Paid', '2021-08-30', '21:03:59', 'admin', NULL, NULL, NULL, 0),
(91, 'Add', 'SO20210830211313', 'CASH', 'CASH', '2021-08-30', ' ', '', '15.00', '0.00', '15.00', 'UnPaid', '2021-08-30', '21:13:13', 'admin', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_payment`
--

CREATE TABLE `sale_payment` (
  `sale_payment_id` int(11) NOT NULL,
  `sale_id_header` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_payment_date` date NOT NULL,
  `sale_payment_time` time NOT NULL,
  `payment_method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_amount` decimal(10,2) NOT NULL,
  `sale_payment` decimal(10,2) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_payment`
--

INSERT INTO `sale_payment` (`sale_payment_id`, `sale_id_header`, `sale_payment_date`, `sale_payment_time`, `payment_method`, `customer_name`, `sale_amount`, `sale_payment`, `reference`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(19, 'SO20210830210359', '2021-08-30', '21:04:08', 'cash', 'CASH', '30.00', '30.00', '', '2021-08-30', '21:04:08', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sale_payment_log`
--

CREATE TABLE `sale_payment_log` (
  `sale_payment_id` int(11) NOT NULL,
  `sale_id_header` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_payment_date` date NOT NULL,
  `sale_payment_time` time NOT NULL,
  `payment_method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_amount` decimal(10,2) NOT NULL,
  `sale_payment` decimal(10,2) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `modified_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_payment_log`
--

INSERT INTO `sale_payment_log` (`sale_payment_id`, `sale_id_header`, `mode`, `sale_payment_date`, `sale_payment_time`, `payment_method`, `customer_name`, `sale_amount`, `sale_payment`, `reference`, `creation_date`, `creation_time`, `creation_user`, `modified_date`, `modified_time`, `modified_user`) VALUES
(13, 'SO20210821105259', 'Add', '2021-08-21', '10:52:59', 'cash', 'CASH', '30.00', '30.00', 'tester101', '2021-08-21', '10:52:59', 'admin', NULL, NULL, NULL),
(14, 'SO20210821105502', 'Add', '2021-08-21', '11:14:01', 'cash', 'CASH', '85.00', '85.00', 'test101', '2021-08-21', '11:14:01', 'admin', NULL, NULL, NULL),
(15, 'SO20210821114436', 'Add', '2021-08-21', '13:48:39', 'cash', 'CASH', '48.70', '50.00', 'test101', '2021-08-21', '13:48:39', 'admin', NULL, NULL, NULL),
(16, 'SO20210821135138', 'Add', '2021-08-21', '13:51:38', 'cash', 'CASH', '14.85', '15.00', 'tester101', '2021-08-21', '13:51:38', 'admin', NULL, NULL, NULL),
(17, 'SO20210824194245', 'Add', '2021-08-30', '19:56:11', 'cash', 'CASH', '0.00', '300.00', '', '2021-08-30', '19:56:11', 'admin', NULL, NULL, NULL),
(18, 'SO20210830204439', 'Add', '2021-08-30', '20:44:50', 'cash', 'CASH', '0.00', '35.00', '', '2021-08-30', '20:44:50', 'admin', NULL, NULL, NULL),
(19, 'SO20210830204700', 'Add', '2021-08-30', '21:02:12', 'cash', 'CASH', '0.00', '0.00', '', '2021-08-30', '21:02:12', 'admin', NULL, NULL, NULL),
(20, 'SO20210830210359', 'Add', '2021-08-30', '21:04:08', 'cash', 'CASH', '30.00', '30.00', '', '2021-08-30', '21:04:08', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `logid` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mode` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `login_attempt` int(2) DEFAULT NULL,
  `last_login_date` date DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `creation_time` time DEFAULT NULL,
  `creation_user` varchar(100) DEFAULT NULL,
  `last_modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `last_modified_user` varchar(100) DEFAULT NULL,
  `current_session_id` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `contact_num` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `filler1` varchar(10) DEFAULT NULL,
  `filler2` varchar(10) DEFAULT NULL,
  `filler3` varchar(10) DEFAULT NULL,
  `filler4` varchar(10) DEFAULT NULL,
  `filler5` varchar(10) DEFAULT NULL,
  `filler6` varchar(10) DEFAULT NULL,
  `filler7` varchar(10) DEFAULT NULL,
  `filler8` varchar(10) DEFAULT NULL,
  `filler9` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`logid`, `user_id`, `mode`, `username`, `password`, `role`, `login_attempt`, `last_login_date`, `creation_date`, `creation_time`, `creation_user`, `last_modified_date`, `modified_time`, `last_modified_user`, `current_session_id`, `status`, `contact_num`, `email`, `ip_address`, `browser`, `filler1`, `filler2`, `filler3`, `filler4`, `filler5`, `filler6`, `filler7`, `filler8`, `filler9`) VALUES
(1, NULL, 'Update', 'tester1', '$2y$10$cMQrIbQQoVyA4QiPSOl9OO./3HWRZgpwG7IhAgIH0LgJ4r382IJFm', 'staff', 0, '2021-03-19', '2021-03-19', '12:52:56', 'admin', '2021-03-22', '20:40:06', 'admin', '34d5c57b3123ca7d54700e7051f12a41', 'active', '123456789', 'tester@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'Update', 'admin', '$2y$10$Lx79E0T9hkJ4WsjH5/4YNelpZMEuKFrpvdpIh23gN4RUIRYvYyali', 'administrator', 0, '2021-03-22', '2021-03-16', '17:00:13', '', '2021-03-22', '20:42:05', 'admin', '59ba4cc4410ee8ec676e2d8bca114658', 'active', '1234567', 'admin@admin.com', '110.159.20.140', 'Chrome', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, 'Update', 'nightcattest', '$2y$10$/ACiAvFXej/9zfGKApo/tONC77LsRwC5ZYso9XEN5SRsNN6kNhAoq', 'administrator', 6, '2021-03-21', '2021-03-16', '17:00:13', '', '2021-03-22', '20:56:50', 'admin', '', 'disabled', 'contact', 'email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, 'Update', 'nightcattest', '$2y$10$/ACiAvFXej/9zfGKApo/tONC77LsRwC5ZYso9XEN5SRsNN6kNhAoq', 'administrator', 0, '2021-03-21', '2021-03-16', '17:00:13', '', '2021-03-22', '20:57:40', 'admin', '', 'active', 'contact', 'email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, 'Update', 'nightcattest2', '$2y$10$NUSK8CBFqfmldJXWQdQi9.EMcRRijbKASJzZRWn6XsxRQm/glYc3K', '', 0, NULL, '2021-03-21', '09:52:34', 'admin', '2021-03-22', '20:58:02', 'nightcattest', '', 'active', '0126113810', 'nightcat@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, 'Add', 'tester2', '$2y$10$7NaSH8whyqLlmVn0IfMhW.PREEc5CEeZoEzCY3O6isuBHeZbjUWCm', 'staff', 0, NULL, '2021-03-31', '17:09:35', 'admin', NULL, NULL, NULL, NULL, 'active', '123456789', 'tesster2@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, 'Update', 'tester1', '$2y$10$sAFCZkfZNJTAUyis509SSe/0doctaUjYre.xzhnJoCP5rBJyEnsXa', 'staff', 0, '2021-03-19', '2021-03-19', '12:52:56', 'admin', '2021-04-01', '19:57:17', 'admin', '34d5c57b3123ca7d54700e7051f12a41', 'active', '123456789', 'tester@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, NULL, 'Add', 'testing', '$2y$10$S32wKxuFOf/ovKk.652rLOksOvVKQwHyw77PMfp2p5Gk2u6R6guVu', 'administrator', 0, NULL, '2021-04-06', '01:05:25', 'admin', NULL, NULL, NULL, NULL, 'active', '011160444567', 'testing@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, NULL, 'Delete', 'testing', '$2y$10$S32wKxuFOf/ovKk.652rLOksOvVKQwHyw77PMfp2p5Gk2u6R6guVu', 'administrator', 0, NULL, '2021-04-06', '01:05:25', 'admin', '2021-04-06', '01:05:35', 'admin', '', 'active', '011160444567', 'testing@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, 'Update', 'tester1', '$2y$10$uShbzgql0qEQBYsLctUDFu7jqSqiMHlJwCPzR/tXtAI20E1YNrAyi', 'staff', 0, '2021-04-01', '2021-03-19', '12:52:56', 'admin', '2021-04-24', '14:04:44', 'admin', '966f9974bd12e7856c1c79c0d54dab24', 'active', '123456789', 'tester@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, NULL, 'Update', 'tester1', '$2y$10$uShbzgql0qEQBYsLctUDFu7jqSqiMHlJwCPzR/tXtAI20E1YNrAyi', 'administrator', 0, '2021-04-24', '2021-03-19', '12:52:56', 'admin', '2021-04-24', '14:06:06', 'admin', '', 'active', '123456789', 'tester@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, NULL, 'login reject', 'tester1', '$2y$10$g.B50BtCaGeAFBLDXm8eNehPcf.eaIe0Mx2auApLNoQ8D/XfCmYUG', NULL, NULL, NULL, '2021-04-26', '19:14:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '115.164.219.152', 'Microsoft Edge', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, 'login reject', 'tester1', '$2y$10$5TAVmYVYktG2Ko1senhQuOFsVUzs71RnGoGADkHHRE7LpYCAvIXWm', NULL, NULL, NULL, '2021-05-01', '15:33:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '115.164.177.58', 'Chrome', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, 'login reject', 'tester1', '$2y$10$uOZ8mO.XOzsv1MXn/aj9semH.94z4OhhFYaX.mJ.BqpoaRqTtzIf6', NULL, NULL, NULL, '2021-05-01', '15:33:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '115.164.177.58', 'Chrome', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, NULL, 'login reject', 'tester1', '$2y$10$hEYMrAQZ/JyjzT0AO69Gxe7P4xiBrLH.1ZwF.gpS3i3A3uGS18HS2', NULL, NULL, NULL, '2021-05-02', '15:48:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '115.164.177.58', 'Chrome', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, NULL, 'Update', 'tester1', '$2y$10$.TvXueHmloKBS9ZdghatP.uru3wYqtu9WiypfGqw/Lq5oND4J.mMi', 'administrator', 4, '2021-04-24', '2021-03-19', '12:52:56', 'admin', '2021-05-02', '15:48:35', 'admin', 'd0819a152245c728febe6374d9a88821', 'active', '123456789', 'tester@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, NULL, 'login reject', 'tester1', '$2y$10$0aygtX6FQnkoRaSnSTSWt.27cfVxQTXAqSEe2cVFxbEIT8X3xB.au', NULL, NULL, NULL, '2021-05-06', '21:04:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '110.159.20.43', 'Chrome', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `login_attempt` int(2) DEFAULT NULL,
  `last_login_date` date DEFAULT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL,
  `creation_user` varchar(100) NOT NULL,
  `last_modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `last_modified_user` varchar(100) NOT NULL,
  `current_session_id` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `contact_num` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `browser` varchar(30) DEFAULT NULL,
  `filler1` varchar(10) DEFAULT NULL,
  `filler2` varchar(10) DEFAULT NULL,
  `filler3` varchar(10) DEFAULT NULL,
  `filler4` varchar(10) DEFAULT NULL,
  `filler5` varchar(10) DEFAULT NULL,
  `filler6` varchar(10) DEFAULT NULL,
  `filler7` varchar(10) DEFAULT NULL,
  `filler8` varchar(10) DEFAULT NULL,
  `filler9` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `login_attempt`, `last_login_date`, `creation_date`, `creation_time`, `creation_user`, `last_modified_date`, `modified_time`, `last_modified_user`, `current_session_id`, `status`, `contact_num`, `email`, `ip_address`, `browser`, `filler1`, `filler2`, `filler3`, `filler4`, `filler5`, `filler6`, `filler7`, `filler8`, `filler9`) VALUES
(1, 'admin', '$2y$10$Lx79E0T9hkJ4WsjH5/4YNelpZMEuKFrpvdpIh23gN4RUIRYvYyali', 'administrator', 0, '2021-09-19', '2021-03-16', '17:00:13', '', '2021-03-22', '20:42:05', 'admin', '', 'active', '1234567', 'admin@admin.com', '::1', 'Chrome', '', '', '', '', '', '', '', '', ''),
(2, 'nightcattest', '$2y$10$/ACiAvFXej/9zfGKApo/tONC77LsRwC5ZYso9XEN5SRsNN6kNhAoq', 'administrator', 0, '2021-04-05', '2021-03-16', '17:00:13', '', '2021-03-22', '20:57:40', 'admin', 'd4fadb0878c9f9af612fceb30ca273b1', 'active', 'contact', 'email', '115.135.104.41', 'Chrome', '', '', '', '', '', '', '', '', ''),
(3, 'tester1', '$2y$10$.TvXueHmloKBS9ZdghatP.uru3wYqtu9WiypfGqw/Lq5oND4J.mMi', 'administrator', 0, '2021-07-23', '2021-03-19', '12:52:56', 'admin', '2021-05-02', '15:48:35', 'admin', '65f15710287b46ca5421ec08b9138a47', 'active', '123456789', 'tester@test.com', '115.164.184.182', 'Chrome', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'nightcattest2', '$2y$10$NUSK8CBFqfmldJXWQdQi9.EMcRRijbKASJzZRWn6XsxRQm/glYc3K', '', 0, '2021-03-22', '2021-03-21', '09:52:34', 'admin', '2021-03-22', '20:58:02', 'nightcattest', '', 'active', '0126113810', 'nightcat@gmail.com', '210.187.188.27', 'Chrome', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'tester2', '$2y$10$7NaSH8whyqLlmVn0IfMhW.PREEc5CEeZoEzCY3O6isuBHeZbjUWCm', 'staff', 0, NULL, '2021-03-31', '17:09:35', 'admin', NULL, NULL, '', '', 'active', '123456789', 'tesster2@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customerlog`
--
ALTER TABLE `customerlog`
  ADD PRIMARY KEY (`customerlog_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`invoice_detail_id`);

--
-- Indexes for table `invoice_detail_log`
--
ALTER TABLE `invoice_detail_log`
  ADD PRIMARY KEY (`invoice_detail_id_log`);

--
-- Indexes for table `invoice_header`
--
ALTER TABLE `invoice_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_header_log`
--
ALTER TABLE `invoice_header_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itemlog`
--
ALTER TABLE `itemlog`
  ADD PRIMARY KEY (`itemlog_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `parameter`
--
ALTER TABLE `parameter`
  ADD PRIMARY KEY (`parameter_id`);

--
-- Indexes for table `parameterlog`
--
ALTER TABLE `parameterlog`
  ADD PRIMARY KEY (`para_logid`);

--
-- Indexes for table `payment_detail`
--
ALTER TABLE `payment_detail`
  ADD PRIMARY KEY (`payment_detail_id`);

--
-- Indexes for table `payment_header`
--
ALTER TABLE `payment_header`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `sale_detail`
--
ALTER TABLE `sale_detail`
  ADD PRIMARY KEY (`sale_detail_id`);

--
-- Indexes for table `sale_detail_log`
--
ALTER TABLE `sale_detail_log`
  ADD PRIMARY KEY (`sale_detail_id`);

--
-- Indexes for table `sale_header`
--
ALTER TABLE `sale_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_header_log`
--
ALTER TABLE `sale_header_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_payment`
--
ALTER TABLE `sale_payment`
  ADD PRIMARY KEY (`sale_payment_id`);

--
-- Indexes for table `sale_payment_log`
--
ALTER TABLE `sale_payment_log`
  ADD PRIMARY KEY (`sale_payment_id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`logid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customerlog`
--
ALTER TABLE `customerlog`
  MODIFY `customerlog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `invoice_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoice_detail_log`
--
ALTER TABLE `invoice_detail_log`
  MODIFY `invoice_detail_id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoice_header`
--
ALTER TABLE `invoice_header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice_header_log`
--
ALTER TABLE `invoice_header_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `itemlog`
--
ALTER TABLE `itemlog`
  MODIFY `itemlog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28070;

--
-- AUTO_INCREMENT for table `parameter`
--
ALTER TABLE `parameter`
  MODIFY `parameter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `parameterlog`
--
ALTER TABLE `parameterlog`
  MODIFY `para_logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `payment_detail`
--
ALTER TABLE `payment_detail`
  MODIFY `payment_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_header`
--
ALTER TABLE `payment_header`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_detail`
--
ALTER TABLE `sale_detail`
  MODIFY `sale_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `sale_detail_log`
--
ALTER TABLE `sale_detail_log`
  MODIFY `sale_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `sale_header`
--
ALTER TABLE `sale_header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `sale_header_log`
--
ALTER TABLE `sale_header_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `sale_payment`
--
ALTER TABLE `sale_payment`
  MODIFY `sale_payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sale_payment_log`
--
ALTER TABLE `sale_payment_log`
  MODIFY `sale_payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
