-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 06, 2021 at 06:28 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurants`
--

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_details`
--

DROP TABLE IF EXISTS `restaurant_details`;
CREATE TABLE IF NOT EXISTS `restaurant_details` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `imageCreator` varchar(255) NOT NULL,
  `imageSourceURL` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_details`
--

INSERT INTO `restaurant_details` (`ID`, `name`, `address`, `description`, `imagePath`, `imageCreator`, `imageSourceURL`) VALUES
(3, 'Ristorante Tartufo', '1000 Ann St, Fortitude Valley QLD 4006', 'Refined Neapolitan-inspired classics with seasonal produce in a smart red and black dining room.', 'uploads/calum-lewis-rPkgYDh2bmo-unsplash.jpg', 'Calum Lewis', 'https://unsplash.com/photos/rPkgYDh2bmo'),
(6, 'Fasta Pasta', 'Cnr South Terrace Street &, Pulteney St, Adelaide SA 5000', 'Traditional pizza, pasta and Italian mains presented in an enduring chain with an easygoing vibe.', 'uploads/tom-dillon-9eIbwtyl4Xs-unsplash.jpg', 'Tom Dillon', 'https://unsplash.com/photos/9eIbwtyl4Xs'),
(8, 'Il Gambero', '166 Lygon St, Carlton VIC 3053', 'Thin-crust pizza, plus pasta and mains, in a sleek venue with exposed-brick walls and outdoor seats.', 'uploads/inna-podolska-JspLKUauwSI-unsplash.jpg', 'Inna Podolska', 'https://unsplash.com/photos/JspLKUauwSI'),
(17, 'The Spaghetti Tree', '59 Bourke St, Melbourne VIC 3000', 'The Spaghetti Tree has a welcoming and comfortable environment for your dining pleasure, and is a special place to visit for a walk down memory lane with pictures and photos of movie stars and entertainers from the Classical Hollywood era.', 'uploads/bruna-branco-t8hTmte4O_g-unsplash.jpg', 'Bruna Branco', 'https://unsplash.com/photos/t8hTmte4O_g'),
(21, 'Foglia Di Fico', '585 La Trobe St, Melbourne VIC 3000', 'Polished, warm restaurant featuring Italian cuisine & handmade pasta, plus a robust wine list.', 'uploads/karthik-garikapati-oBbTc1VoT-0-unsplash (1).jpg', 'Karthik Garikapati', 'https://unsplash.com/s/photos/pizza?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
