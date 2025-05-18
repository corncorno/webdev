-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 03:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accountsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `created_at`, `image`, `quantity`) VALUES
(4, 'Johnnie Walker - Black Label', 1649.00, 'Black has class!', '2025-04-17 05:48:33', 'images/blacklabel.jpg', 0),
(5, 'Bud Light', 60.00, 'Class Buddy!', '2025-04-17 05:56:23', 'images/budlight.jpg', 0),
(6, 'Gin', 65.00, 'Classy Drink for Classy people', '2025-04-17 06:19:37', 'images/gin.jpg', 0),
(7, 'Heineken', 75.00, '', '2025-04-17 06:54:25', 'images/heineken.jpg', 0),
(8, 'Red Horse', 110.00, '', '2025-04-19 12:30:11', 'images\\redhorse.jpg', 0),
(9, 'Red Label - Johnnie Walker', 1149.00, '', '2025-04-19 12:31:14', 'images\\redlabel.jpg', 0),
(10, 'San Miguel Light', 70.00, '', '2025-04-19 12:32:09', 'images\\sanmig.jpg', 0),
(11, 'Soju - Jinro Chamisul', 130.00, '', '2025-04-19 12:33:08', 'images\\soju.jpg', 0),
(12, 'Boost In Class Wine Glass', 60.00, '', '2025-04-19 12:38:53', 'images\\glass1.jpg', 0),
(14, 'Boost in Class Sigma Glass', 89.00, '', '2025-04-19 12:45:00', 'images\\glass2.jpg', 0),
(15, 'Boost in Class Coupe Glass', 300.00, '', '2025-04-19 12:45:00', 'images\\glass3.jpg', 0),
(16, 'Boost in Class Diamond Luxury Glass', 190.00, '', '2025-04-19 12:46:09', 'images\\glass4.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `username`, `password`, `date`) VALUES
(1, 'admin', 'admin', 'admin', '2025-05-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
