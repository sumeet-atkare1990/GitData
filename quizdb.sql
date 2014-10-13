-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 13, 2014 at 02:30 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quizdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

DROP TABLE IF EXISTS `choices`;
CREATE TABLE IF NOT EXISTS `choices` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `q_id` int(11) DEFAULT NULL,
  `answer` varchar(200) NOT NULL,
  `correct` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`c_id`),
  KEY `q_id` (`q_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`c_id`, `q_id`, `answer`, `correct`) VALUES
(1, 1, 'After being driven to the museum, Professor Kumar was dropped at his hotel.', 1),
(2, 1, 'Professor Kumar was being driven dropped at his hotel.', 0),
(3, 1, 'After she had driven Professor Kumar to the museum she had dropped him at his hotel.', 0),
(5, 2, 'I remember I was taken to the museum by my sister.', 0),
(6, 2, 'I remember being taken to the museum by my sister.', 1),
(7, 2, 'I remember myself being taken to the museum by my sister.', 0),
(8, 3, 'By whom has this mess been created?', 0),
(9, 3, 'By whom is this mess being created?', 1),
(11, 4, 'Every morning I was greeted cheerfully.', 0),
(12, 4, 'I am greeted cheerfully by them every morning.', 1),
(13, 4, 'I am being greeted cheerfully by them every morning.', 0),
(14, 4, 'Cheerful greeting is done by them every morning to me.', 0),
(15, 5, 'Tea is being grown in Darjeeling.', 0),
(16, 5, 'Let the tea be grown in Darjeeling.', 0),
(17, 5, 'Tea is grown in Darjeeling.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `q_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL,
  PRIMARY KEY (`q_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`q_id`, `question`) VALUES
(1, 'After driving professor Kumar to the museum she dropped him at his hotel.'),
(2, 'I remember my sister taking me to the museum.'),
(3, 'Who is creating this mess?'),
(4, 'They greet me cheerfully every morning.'),
(5, 'Darjeeling grows tea.');

-- --------------------------------------------------------

--
-- Table structure for table `user_test`
--

DROP TABLE IF EXISTS `user_test`;
CREATE TABLE IF NOT EXISTS `user_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) DEFAULT NULL,
  `q_id` int(11) DEFAULT NULL,
  `u_answer` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `q_id` (`q_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `user_test`
--

INSERT INTO `user_test` (`id`, `u_id`, `q_id`, `u_answer`) VALUES
(50, 4, 1, 'Professor Kumar was being driven dropped at his hotel.'),
(51, 4, 2, 'I remember myself being taken to the museum by my sister.'),
(52, 4, 3, 'By whom is this mess being created?'),
(53, 4, 4, 'Cheerful greeting is done by them every morning to me.'),
(54, 4, 5, 'Tea is grown in Darjeeling.'),
(55, 2, 1, 'After she had driven Professor Kumar to the museum she had dropped him at his hotel.'),
(56, 2, 2, 'I remember myself being taken to the museum by my sister.'),
(57, 2, 3, 'By whom has this mess been created?'),
(58, 2, 4, 'Cheerful greeting is done by them every morning to me.'),
(59, 2, 5, 'Tea is grown in Darjeeling.'),
(60, 3, 1, 'After being driven to the museum, Professor Kumar was dropped at his hotel.'),
(61, 3, 2, 'I remember being taken to the museum by my sister.'),
(62, 3, 3, 'By whom is this mess being created?'),
(63, 3, 4, 'Every morning I was greeted cheerfully.'),
(64, 3, 5, 'Tea is grown in Darjeeling.'),
(65, 1, 1, 'Professor Kumar was being driven dropped at his hotel.'),
(66, 1, 2, 'I remember myself being taken to the museum by my sister.'),
(67, 1, 3, 'By whom is this mess being created?'),
(68, 1, 4, 'Cheerful greeting is done by them every morning to me.'),
(69, 1, 5, 'Tea is being grown in Darjeeling.');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `choices`
--
ALTER TABLE `choices`
  ADD CONSTRAINT `choices_ibfk_1` FOREIGN KEY (`q_id`) REFERENCES `questions` (`q_id`);

--
-- Constraints for table `user_test`
--
ALTER TABLE `user_test`
  ADD CONSTRAINT `user_test_ibfk_1` FOREIGN KEY (`q_id`) REFERENCES `questions` (`q_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
