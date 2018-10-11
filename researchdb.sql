-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2016 at 07:58 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `researchdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `id` int(11) NOT NULL,
  `grade` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `grade`) VALUES
(1, 'Pre-K'),
(2, 'Kindergartten'),
(3, '1st Grade'),
(4, '2nd Grade'),
(5, '3rd Grade'),
(6, '4th Grade'),
(7, '5th Grade'),
(8, '6th Grade'),
(9, '7th Grade'),
(10, '8th Grade'),
(11, '9th Grade'),
(12, '10th Grade'),
(13, '11th Grade'),
(14, '12th Grade');

-- --------------------------------------------------------

--
-- Table structure for table `searchlinks`
--

CREATE TABLE `searchlinks` (
  `id` int(11) NOT NULL,
  `sessionid` int(11) DEFAULT NULL,
  `searchid` int(11) DEFAULT NULL,
  `linkclicked` text,
  `timeclicked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `guid` varchar(40) DEFAULT NULL,
  `datevisited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gradeid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessionsearch`
--

CREATE TABLE `sessionsearch` (
  `id` int(11) NOT NULL,
  `userquery` text,
  `searchuid` varchar(50) DEFAULT NULL,
  `sessionid` int(11) DEFAULT NULL,
  `timesearched` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `searchlinks`
--
ALTER TABLE `searchlinks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitorid` (`sessionid`),
  ADD KEY `searchid` (`searchid`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessionsearch`
--
ALTER TABLE `sessionsearch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitorid` (`sessionid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `searchlinks`
--
ALTER TABLE `searchlinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `sessionsearch`
--
ALTER TABLE `sessionsearch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `searchlinks`
--
ALTER TABLE `searchlinks`
  ADD CONSTRAINT `searchlinks_ibfk_1` FOREIGN KEY (`sessionid`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `searchlinks_ibfk_2` FOREIGN KEY (`searchid`) REFERENCES `sessionsearch` (`id`);

--
-- Constraints for table `sessionsearch`
--
ALTER TABLE `sessionsearch`
  ADD CONSTRAINT `sessionsearch_ibfk_2` FOREIGN KEY (`sessionid`) REFERENCES `session` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
