-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2014 at 11:11 AM
-- Server version: 5.5.36
-- PHP Version: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `csr`
--

-- --------------------------------------------------------

--
-- Table structure for table `csr_mfa_account`
--

CREATE TABLE IF NOT EXISTS `csr_mfa_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mfa_device_id` text COLLATE utf8_unicode_ci NOT NULL,
  `mfa_device_date` int(11) NOT NULL,
  `mfa_device_pin` text COLLATE utf8_unicode_ci NOT NULL,
  `mfa_device_salt` text COLLATE utf8_unicode_ci NOT NULL,
  `mfa_device_pepper` text COLLATE utf8_unicode_ci NOT NULL,
  `mfa_device_owner_id` int(11) NOT NULL,
  `mfa_device_attempt` int(11) NOT NULL,
  `mfa_device_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `csr_usr_account`
--

CREATE TABLE IF NOT EXISTS `csr_usr_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_name_first` text COLLATE utf8_unicode_ci,
  `usr_name_middle` text COLLATE utf8_unicode_ci,
  `usr_name_last` text COLLATE utf8_unicode_ci,
  `usr_email` text COLLATE utf8_unicode_ci,
  `usr_pwd_salt` text COLLATE utf8_unicode_ci,
  `usr_pwd_hash` text COLLATE utf8_unicode_ci,
  `usr_phone_country` text COLLATE utf8_unicode_ci,
  `usr_phone_area` text COLLATE utf8_unicode_ci,
  `usr_phone_number` text COLLATE utf8_unicode_ci,
  `usr_phone_ext` text COLLATE utf8_unicode_ci,
  `usr_dob_epoch` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usr_id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `csr_usr_permission`
--

CREATE TABLE IF NOT EXISTS `csr_usr_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `per_id_self` int(11) NOT NULL,
  `per_id_target` int(11) NOT NULL,
  `per_access_read` tinyint(1) NOT NULL,
  `per_access_write` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `csr_usr_token`
--

CREATE TABLE IF NOT EXISTS `csr_usr_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tok_usr_id` int(11) NOT NULL,
  `tok_usr_ip` text COLLATE utf8_unicode_ci NOT NULL,
  `tok_epoch` int(11) NOT NULL,
  `tok_string` text COLLATE utf8_unicode_ci NOT NULL,
  `tok_valid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=92 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
