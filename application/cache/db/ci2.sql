-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 09, 2012 at 06:59 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ci`
--

-- --------------------------------------------------------

--
-- Table structure for table `register_token`
--

CREATE TABLE IF NOT EXISTS `register_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `token` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `email` varchar(20) NOT NULL,
  `cookie` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(10) NOT NULL,
  `accessed_at` varchar(10) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`name`,`pass`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `name`, `pass`, `email`, `cookie`, `status`, `created_at`, `accessed_at`) VALUES
(1, 'admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'admin@example.com', 'ce63d392de3e54d207e763995a035926', 1, '1348063724', '1349758672'),
(3, 'test1', 'b444ac06613fc8d63795be9ad0beaf55011936ac', 'test1@example.com', '', 1, '1348064399', ''),
(4, 'test2', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'test2@example.com', 'c716c5e026dc4693fa965eb1e59fb5ce', 1, '1348064579', '1348065009'),
(5, 'test3', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'test3@example.com', '', 1, '1348064628', ''),
(6, 'test4', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'test4@example.com', '', 1, '1348064848', ''),
(7, 'test5', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'test5@example.com', '', 1, '1348064897', ''),
(8, 'test6', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'test6@example.com', 'ad317cf0565317c9aeee1350be64a737', 1, '1348064949', '1348064966');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
