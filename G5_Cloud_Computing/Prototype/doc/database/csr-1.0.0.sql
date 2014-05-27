-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2014 at 02:51 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `csr`
--
CREATE DATABASE IF NOT EXISTS `csr` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `csr`;

-- --------------------------------------------------------

--
-- Table structure for table `csr_usr_account`
--

CREATE TABLE IF NOT EXISTS `csr_usr_account` (
  `usr_id` int(11) NOT NULL,
  `usr_name_first` int(11) NOT NULL,
  `usr_name_middle` int(11) NOT NULL,
  `usr_name_last` int(11) NOT NULL,
  `usr_email` int(11) NOT NULL,
  `usr_pwd_salt` int(11) NOT NULL,
  `usr_pwd_hash` int(11) NOT NULL,
  `usr_phone_country` int(11) NOT NULL,
  `usr_phone_area` int(11) NOT NULL,
  `usr_phone_number` int(11) NOT NULL,
  `usr_phone_ext` int(11) NOT NULL,
  `usr_dob_stamp` int(11) NOT NULL,
  `usr_dob_epoch` int(11) NOT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_id` (`usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `csr_usr_permission`
--

CREATE TABLE IF NOT EXISTS `csr_usr_permission` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT,
  `per_id_self` int(11) NOT NULL,
  `per_id_target` int(11) NOT NULL,
  `per_access_read` tinyint(1) NOT NULL,
  `per_access_write` tinyint(1) NOT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `csr_usr_token`
--

CREATE TABLE IF NOT EXISTS `csr_usr_token` (
  `tok_id` int(11) NOT NULL,
  `tok_str_salt` int(11) NOT NULL,
  `tok_str_hash` int(11) NOT NULL,
  `tok_dob` int(11) NOT NULL,
  `tok_usr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
