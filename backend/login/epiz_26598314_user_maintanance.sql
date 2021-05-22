-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql212.epizy.com
-- Generation Time: Mar 18, 2021 at 06:00 AM
-- Server version: 5.6.48-88.0
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_26598314_user_maintanance`
--

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `logid` int(11) NOT NULL,
  `mode` varchar(8) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `login_attempt` int(2) DEFAULT NULL,
  `last_login_date` date DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `creation_time` time DEFAULT NULL,
  `creation_user` varchar(100) NOT NULL,
  `last_modified_date` date DEFAULT NULL,
  `modified_time` time DEFAULT NULL,
  `last_modified_user` varchar(100) DEFAULT NULL,
  `current_session_id` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `contact_num` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
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

INSERT INTO `users` (`id`, `username`, `password`, `role`, `login_attempt`, `last_login_date`, `creation_date`, `creation_time`, `creation_user`, `last_modified_date`, `modified_time`, `last_modified_user`, `current_session_id`, `status`, `contact_num`, `email`, `filler1`, `filler2`, `filler3`, `filler4`, `filler5`, `filler6`, `filler7`, `filler8`, `filler9`) VALUES
(1, 'admin', '$2y$10$7ZnYtD8qDBnB9oH5kTVTaOfVNU3ZVZP9sNVVlCIsbFKHXKsKjvpaa', 'administrator', 0, '2021-03-16', '2021-03-16', '17:00:13', '', NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 'nightcattest', '$2y$10$efB8.4CgYYi.3FMWEq0wWubn1bLeH1NAeRCQA3XuU8raNz4YIOtqS', 'administrator', 1, '2021-03-16', '2021-03-16', '17:00:13', '', NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `logid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
