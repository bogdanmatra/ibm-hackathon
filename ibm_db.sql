-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09 Dec 2014 la 10:23
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
CREATE DATABASE IF NOT EXISTS `ibm_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `ibm_db`;

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `driver_details`
--

DROP TABLE IF EXISTS `driver_details`;
CREATE TABLE IF NOT EXISTS `driver_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `make` varchar(55) NOT NULL,
  `model` varchar(55) NOT NULL,
  `license` varchar(10) NOT NULL,
  `completed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Salvarea datelor din tabel `driver_details`
--

INSERT INTO `driver_details` (`id`, `user_id`, `make`, `model`, `license`, `completed`) VALUES
(1, 1, 'dsgfndsj', 'sfjksdf', '04.12.2014', 0),
(2, 5, 'dfn sn', 'jdfnsdjf', '04.12.2014', 0),
(3, 6, 'asdasd', 'asdasd', '05.12.2014', 0),
(4, 7, 'dfsfs', 'wrewr', '05.12.2014', 0);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `routes`
--

DROP TABLE IF EXISTS `routes`;
CREATE TABLE IF NOT EXISTS `routes` (
  `route_id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `start` varchar(55) NOT NULL,
  `finish` varchar(55) NOT NULL,
  `date` varchar(10) NOT NULL,
  `intermediate` text NOT NULL,
  `passenger` int(11) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(25) DEFAULT 'In Progress',
  PRIMARY KEY (`route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1007 ;

--
-- Salvarea datelor din tabel `routes`
--

INSERT INTO `routes` (`route_id`, `driver_id`, `start`, `finish`, `date`, `intermediate`, `passenger`, `added`, `status`) VALUES
(4, 5, 'Municipiul Bucuresti', 'iasi', '12.12.2014', '', 3, '2014-12-06 04:14:21', 'In Progress'),
(1000, 5, 'Municipiul București', 'iasi', '06.12.2014', 'București,România,Spătaru,Buzău,Râmnicu Sărat,Focșani,Tișița,Bârlad,Crasna,Vaslui,Podeni,Iași,Bulevardul Profesor Dimitrie Mangeron', 1, '2014-12-06 02:05:03', 'Complete'),
(1001, 1, 'suceava', 'bacau', '12.12.2014', 'suceava,,bacau', 1, '2014-12-06 09:55:13', 'Complete'),
(1002, 1, 'bucuresti', 'iasi', '19.12.2014', 'bucuresti,București,România,Spătaru,Buzău,Râmnicu Sărat,Focșani,Tișița,Bârlad,Crasna,Vaslui,Podeni,Iași,Bulevardul Profesor Dimitrie Mangeron,iasi', 0, '2014-12-06 09:58:59', 'Complete'),
(1003, 1, 'bucuresti', 'iasi', '12.12.2014', 'bucuresti,București,România,Spătaru,Buzău,Râmnicu Sărat,Focșani,Tișița,Bârlad,Crasna,Vaslui,Podeni,Iași,Bulevardul Profesor Dimitrie Mangeron,iasi', 0, '2014-12-06 15:08:50', 'Complete'),
(1004, 1, 'Municipiul Bucuresti', 'cluj', '13.12.2014', 'Municipiul Bucuresti,București,Chiajna,Râmnicu Vâlcea,România,Alba Iulia,Turda,Cluj-Napoca,cluj', 3, '2014-12-06 18:02:59', 'Complete'),
(1005, 1, 'Municipiul Bucuresti', 'timisoara', '12.12.2014', 'Municipiul Bucuresti,București,Chiajna,Râmnicu Vâlcea,România,Șoimuș,Deva,Săcămaș,Păru,Coșteiu,Ghiroda,Timișoara,timisoara', 2, '2014-12-07 13:17:43', 'In Progress'),
(1006, 1, 'Municipiul Bucuresti', 'iasi', '18.12.2014', 'Municipiul Bucuresti,,iasi', 3, '2014-12-08 09:47:06', 'In Progress');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `route_passengers`
--

DROP TABLE IF EXISTS `route_passengers`;
CREATE TABLE IF NOT EXISTS `route_passengers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Salvarea datelor din tabel `route_passengers`
--

INSERT INTO `route_passengers` (`id`, `route_id`, `user_id`) VALUES
(13, 4, 1),
(14, 1001, 9),
(15, 1002, 9),
(16, 4, 10),
(17, 4, 11),
(18, 1003, 11);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(75) NOT NULL,
  `password` varchar(125) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `first_name` varchar(75) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `driver_flag` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Salvarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `last_name`, `first_name`, `telephone`, `driver_flag`) VALUES
(1, 'iocty@yahoo.com', '12344321', 'Iacob', 'Ștefan', '00000234324', 1),
(2, 'idocs@xhfsd.com', '238432', 'sdjfnsd', 'sadas', '', 0),
(3, 'dfdsfsd@dfhbd.com', '23432', 'sdfsdhf', 'sdjasd', '', 1),
(4, 'irowe@sad.com', '2412421', 'jdsfnjsd', 'sfjsdfj', '', 0),
(5, 'fsdjfn@sdjfnds.com', 'jfdsnfs', 'dhfbhds', 'sdjfbdjs', '', 1),
(6, 'sjfnsd@sadas.com', '23423', 'fdsfs', 'asda', '342342', 1),
(7, 'dsjfns@sfmsd.com', '42342', 'dfsjfs', 'ceav', '032423', 1),
(8, 'mfnsdm@yada.com', 'sdfsdf', 'jd sfjsd ', 'jdngjds', '9889', 0),
(9, 'ion@ion.ro', 'ion', 'ion', 'ion', '218934', 0),
(10, 'ceva@yahoo.com', 'ceva', 'ceva', 'ceva', '324324', 0),
(11, 'ion@ion.com', 'ion', 'ion', 'ion', '2423423', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
