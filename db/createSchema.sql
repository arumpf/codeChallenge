-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: db5000095468.hosting-data.io
-- Generation Time: Jun 06, 2019 at 04:07 PM
-- Server version: 5.7.25-log
-- PHP Version: 7.0.33-0+deb9u3



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbs90026`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees_master`
--

CREATE TABLE `employees_master` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `pw` varchar(400) NOT NULL,
  `role` int(11) NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees_master`
--

INSERT INTO `employees_master` (`id`, `name`, `username`, `pw`, `role`, `phone`, `email`) VALUES
(1, 'Bob Belcher', 'bobb', '2A0E6567DC5A7017F1CF7CA3783C2DA6', 3, 8675309, 'burgerbob@bobsburgs.net'),
(2, 'Linda Belcher', 'lalalinda', '1745230E0BEFECD07051867501832059', 2, 8675309, 'lindabelcher@gmail.com'),
(3, 'Patrick Starr', 'starrman', '135D95ADA55582F26FD197C2679ADA03', 1, 5551001, 'underarock@ocean.net');

-- --------------------------------------------------------

--
-- Table structure for table `emp_role_names`
--

CREATE TABLE `emp_role_names` (
  `id` int(11) NOT NULL,
  `role_name` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emp_role_names`
--

INSERT INTO `emp_role_names` (`id`, `role_name`) VALUES
(3, 'Owner'),
(2, 'Manager'),
(1, 'Fry Cook');

-- --------------------------------------------------------

--
-- Table structure for table `shifts_master`
--

CREATE TABLE `shifts_master` (
  `id` int(11) NOT NULL,
  `emp_name` varchar(30) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `length` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees_master`
--
ALTER TABLE `employees_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shifts_master`
--
ALTER TABLE `shifts_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees_master`
--
ALTER TABLE `employees_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `shifts_master`
--
ALTER TABLE `shifts_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
