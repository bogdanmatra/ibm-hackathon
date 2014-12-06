-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 06 Dec 2014 la 01:17
-- Server version: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ibm_db`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `driver_details`
--

CREATE TABLE IF NOT EXISTS `driver_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `make` varchar(55) NOT NULL,
  `model` varchar(55) NOT NULL,
  `license` varchar(10) NOT NULL,
  `completed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Salvarea datelor din tabel `driver_details`
--

INSERT INTO `driver_details` (`id`, `user_id`, `make`, `model`, `license`, `completed`) VALUES
(1, 3, 'dsgfndsj', 'sfjksdf', '04.12.2014', 0),
(2, 5, 'dfn sn', 'jdfnsdjf', '04.12.2014', 0);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `start` varchar(55) NOT NULL,
  `finish` varchar(55) NOT NULL,
  `date` varchar(10) NOT NULL,
  `intermediate` text NOT NULL,
  `passenger` int(11) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Salvarea datelor din tabel `routes`
--

INSERT INTO `routes` (`id`, `driver_id`, `start`, `finish`, `date`, `intermediate`, `passenger`, `added`) VALUES
(1, 3, 'bucuresti', 'iasi', '09.12.2014', 'bacau', 3, '2014-12-05 23:48:09');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `route_passengers`
--

CREATE TABLE IF NOT EXISTS `route_passengers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pickup` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(75) NOT NULL,
  `password` varchar(125) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `first_name` varchar(75) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `driver_flag` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Salvarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `last_name`, `first_name`, `telephone`, `driver_flag`) VALUES
(1, 'iocty@yahoo.com', '12344321', 'Iacob', 'Ștefan', '', 0),
(2, 'idocs@xhfsd.com', '238432', 'sdjfnsd', 'sadas', '', 0),
(3, 'dfdsfsd@dfhbd.com', '23432', 'sdfsdhf', 'sdjasd', '', 1),
(4, 'irowe@sad.com', '2412421', 'jdsfnjsd', 'sfjsdfj', '', 0),
(5, 'fsdjfn@sdjfnds.com', 'jfdsnfs', 'dhfbhds', 'sdjfbdjs', '', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
