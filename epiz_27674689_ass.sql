-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql300.epizy.com
-- Generation Time: Feb 08, 2021 at 05:13 AM
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
-- Database: `epiz_27674689_ass`
--

-- --------------------------------------------------------

--
-- Table structure for table `adharno`
--

CREATE TABLE `adharno` (
  `adhar` bigint(20) NOT NULL,
  `valid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `name` varchar(30) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `posttitle` varchar(150) DEFAULT NULL,
  `post` varchar(500) DEFAULT NULL,
  `postid` bigint(20) DEFAULT NULL,
  `posted_at` datetime DEFAULT NULL,
  `img_paaht` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `name` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `about` varchar(200) DEFAULT NULL,
  `dppath` varchar(200) DEFAULT NULL,
  `instalink` varchar(200) DEFAULT NULL,
  `fblink` varchar(200) DEFAULT NULL,
  `isset` int(11) DEFAULT NULL,
  `birthdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `postid` bigint(20) DEFAULT NULL,
  `posttitle` varchar(150) DEFAULT NULL,
  `post` varchar(500) DEFAULT NULL,
  `reportcount` int(11) DEFAULT NULL,
  `reportedby` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reportuser`
--

CREATE TABLE `reportuser` (
  `username` varchar(50) DEFAULT NULL,
  `postid` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `sr_no` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `contact_numbe` bigint(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(12) DEFAULT NULL,
  `seckey` bigint(20) DEFAULT NULL,
  `otp` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adharno`
--
ALTER TABLE `adharno`
  ADD PRIMARY KEY (`adhar`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD KEY `username` (`username`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD KEY `username` (`username`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD KEY `postid` (`postid`),
  ADD KEY `reportedby` (`reportedby`);

--
-- Indexes for table `reportuser`
--
ALTER TABLE `reportuser`
  ADD KEY `username` (`username`),
  ADD KEY `postid` (`postid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
