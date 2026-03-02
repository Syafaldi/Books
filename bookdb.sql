-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2026 at 04:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `booktable`
--

CREATE TABLE `booktable` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(50) NOT NULL,
  `book_author` varchar(50) NOT NULL,
  `pub_date` date NOT NULL,
  `book_pub` varchar(50) NOT NULL,
  `book_pages` int(11) NOT NULL,
  `book_cat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booktable`
--

INSERT INTO `booktable` (`book_id`, `book_title`, `book_author`, `pub_date`, `book_pub`, `book_pages`, `book_cat`) VALUES
(6, 'The Wings', 'Yi Sang', '1936-01-01', 'Magazine Publication (Joseon Literary Circle)', 40, 6),
(7, 'Faust', 'Johann Wolfgang von Goethe', '1808-01-01', 'Cotta', 158, 7),
(8, 'Don Quixote', 'Miguel de Cervantes', '1605-01-16', 'Francisco de Robles', 863, 8),
(9, 'Hell Screen', 'Ryunosuke Akutagawa', '1918-01-01', 'Chuo Koron', 35, 9),
(10, 'The Stranger', 'Albert Camus', '1942-05-01', 'Gallimard', 123, 10),
(11, 'Dream of the Red Chamber', 'Cao Xueqin', '1791-01-01', 'Cheng Weiyuan & Gao E', 2500, 11),
(12, 'Wuthering Heights', 'Emily Bronte', '1847-12-01', 'Thomas Cautley Newby', 416, 3),
(13, 'Moby Dick', 'Herman Melville', '1851-10-18', 'Harper & Brothers', 635, 13),
(14, 'Crime and Punishment', 'Fyodor Dostoevsky', '1866-01-01', 'The Russian Messenger', 671, 3),
(15, 'Demian', 'Hermann Hesse', '1919-01-01', 'S. Fischer Verlag', 176, 16),
(16, 'The Odyssey', 'Homer', '0800-01-01', 'Oral Tradition', 500, 15),
(17, 'The Metamorphosis', 'Franz Kafka', '1915-01-01', 'Kurt Wolff Verlag', 55, 3),
(18, 'The Divine Comedy', 'Dante Alighieri', '1320-01-01', 'Manuscript circulation', 798, 15);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat`) VALUES
(3, 'Fiction'),
(6, 'Modernism'),
(7, 'Tragedy'),
(8, 'Classic Literature'),
(9, 'Japanese Literature'),
(10, 'Existensialism'),
(11, 'Chinese Classic'),
(13, 'Adventure'),
(15, 'Epic Poetry'),
(16, 'Coming of Age');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booktable`
--
ALTER TABLE `booktable`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `categ` (`book_cat`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booktable`
--
ALTER TABLE `booktable`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booktable`
--
ALTER TABLE `booktable`
  ADD CONSTRAINT `categ` FOREIGN KEY (`book_cat`) REFERENCES `category` (`cat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
