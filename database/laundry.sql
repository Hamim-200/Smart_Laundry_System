-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2025 at 11:48 AM
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
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `laundry_items`
--

CREATE TABLE `laundry_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laundry_items`
--

INSERT INTO `laundry_items` (`id`, `name`, `price`) VALUES
(5, 'Pant', 150.00),
(6, 'Shirt', 100.00),
(7, 'Saree', 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `laundry_locations`
--

CREATE TABLE `laundry_locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laundry_locations`
--

INSERT INTO `laundry_locations` (`id`, `name`, `address`, `phone`) VALUES
(4, 'Asha Laundry House', 'Uttara Sector - 5, Dhaka', '01914681243');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `laundry_location_id` int(11) NOT NULL,
  `status` enum('Pending','Picked Up','In Process','Completed','Delivered') DEFAULT 'Pending',
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `deadline` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `laundry_location_id`, `status`, `total_price`, `order_date`, `deadline`) VALUES
(1, 2, 4, 'Completed', 450.00, '2025-03-08 09:53:48', '2025-03-10 18:00:00'),
(2, 2, 4, 'Pending', 350.00, '2025-03-08 09:53:48', '2025-03-11 15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `laundry_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `laundry_item_id`, `quantity`, `price`) VALUES
(1, 1, 5, 2, 150.00),
(2, 1, 6, 1, 100.00),
(3, 2, 7, 1, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('Cash','Card','Online') NOT NULL,
  `payment_status` enum('Pending','Completed') DEFAULT 'Pending',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `customer_id`, `amount`, `payment_method`, `payment_status`, `transaction_date`) VALUES
(1, 1, 2, 450.00, 'Cash', 'Completed', '2025-03-08 09:55:51'),
(2, 2, 2, 350.00, 'Card', 'Pending', '2025-03-08 09:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `order_id`, `customer_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 2, 5, 'Excellent service! Clothes were perfectly cleaned and delivered on time.', '2025-03-08 09:55:51'),
(2, 2, 2, 4, 'Good service, but the delivery took a little longer than expected.', '2025-03-08 09:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `rider_assignments`
--

CREATE TABLE `rider_assignments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rider_id` int(11) NOT NULL,
  `status` enum('Assigned','Picked Up','Delivered') DEFAULT 'Assigned',
  `pickup_time` datetime DEFAULT NULL,
  `delivery_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rider_assignments`
--

INSERT INTO `rider_assignments` (`id`, `order_id`, `rider_id`, `status`, `pickup_time`, `delivery_time`) VALUES
(3, 1, 3, 'Assigned', '2025-03-08 15:58:30', '2025-03-10 18:00:00'),
(4, 2, 3, 'Picked Up', '2025-03-08 14:00:00', '2025-03-11 15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('Customer','Rider','Admin') NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `phone`, `address`, `email`, `password`) VALUES
(1, 'Admin', 'Hamim', '01560000654', 'Uttara, Dhaka', 'hamim.ahmed541@gmail.com', '$2y$10$XmwVfzMB/BedBpETce3FGOYjVnr5Ti7QGvWDE9dxRYPXC9UB69dfG'),
(2, 'Customer', 'Rafi', '01780900234', 'Mirpur, Dhaka', 'rafi123@mail.com', '$2y$10$/2BQ8RIJb/5Tmxq7nLjQYeFClQUc4IhiZSW4Hv3cFDg.G3.7dyWwC'),
(3, 'Rider', 'Rakib', '01301234567', 'Basundhora, Dhaka', 'rakib123@gmail.com', '$2y$10$QcFWHALdaUk6wXJLT6bD8uTESEAkbDLdx/680hw3Nnbfn1B.fngDC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laundry_items`
--
ALTER TABLE `laundry_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laundry_locations`
--
ALTER TABLE `laundry_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `laundry_location_id` (`laundry_location_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `laundry_item_id` (`laundry_item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `rider_assignments`
--
ALTER TABLE `rider_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `rider_id` (`rider_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laundry_items`
--
ALTER TABLE `laundry_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `laundry_locations`
--
ALTER TABLE `laundry_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rider_assignments`
--
ALTER TABLE `rider_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`laundry_location_id`) REFERENCES `laundry_locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`laundry_item_id`) REFERENCES `laundry_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rider_assignments`
--
ALTER TABLE `rider_assignments`
  ADD CONSTRAINT `rider_assignments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rider_assignments_ibfk_2` FOREIGN KEY (`rider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
