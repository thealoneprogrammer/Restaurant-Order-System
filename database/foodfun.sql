-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2019 at 08:33 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodfun`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `food_image` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT '1',
  `price` int(11) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`) VALUES
(1, 'veg'),
(2, 'non-veg'),
(3, 'juice');

-- --------------------------------------------------------

--
-- Table structure for table `cookcart`
--

CREATE TABLE `cookcart` (
  `cook_id` int(11) NOT NULl,
  `cat_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `food_image` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `food_id` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `food_image` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `dep_cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`food_id`, `cat_id`, `food_name`, `food_image`, `price`, `dep_cost`) VALUES
(2, 1, 'Alu Matter', 'aluMatter.jpg', '100', 130),
(3, 1, 'Carrot Halwa', 'carotHalwa.jpg', '150', 180),
(4, 1, 'Chapathi', 'chapathi.jpg', '100', 120),
(5, 1, 'Gulab Jamun', 'gulabjamun.jpg', '200', 230),
(6, 2, 'Chiken 65', 'chicken65.jpg', '250', 280),
(7, 2, 'Chicken Biriyani', 'chickenBiriyani.jpg', '150', 180),
(8, 2, 'Chilli Chicken', 'chilliChicken.jpg', '200', 220),
(9, 2, 'Pizza', 'pizza.jpg', '150', 170),
(10, 2, 'Thandoori Chicken', 'thandooriChicken.jpg', '300', 320);

-- --------------------------------------------------------

--
-- Table structure for table `managercart`
--

CREATE TABLE `managercart` (
  `cart_id` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `food_image` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email_address`, `password`) VALUES
(1, 'sujithsuji1098@gmail.com', 'hello'),
(2, 'manager@foodfun.com', 'manager'),
(3, 'cook@foodfun.com', 'cook'),
(4, 'raosubramanya@outlook.com', '1509');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `cookcart`
--
ALTER TABLE `cookcart`
  ADD KEY `cook_id` (`cook_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `managercart`
--
ALTER TABLE `managercart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `managercart`
--
ALTER TABLE `managercart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
