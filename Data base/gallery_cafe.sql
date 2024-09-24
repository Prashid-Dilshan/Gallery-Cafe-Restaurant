-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 10, 2024 at 10:12 AM
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
-- Database: `gallery_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner_details`
--

CREATE TABLE `banner_details` (
  `id` int(11) NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner_details`
--

INSERT INTO `banner_details` (`id`, `photo_path`, `title`, `subtitle`, `created_at`) VALUES
(55, '../uploads/ed2bad04cf57c98ebb5044b2c2563ac3.jpg', '.', '.', '2024-08-03 19:37:15'),
(56, '../uploads/b7a5e12d2bed8ea4b570ec4f948e6d38.avif', '.', '.', '2024-08-03 19:37:26'),
(57, '../uploads/7db4d4ec8b02cf3456d5b312c30245f1.avif', '.', '.', '2024-08-03 19:37:32'),
(58, '../uploads/d993b48f7ccb1083e2ec4dadd9cf5523.avif', '.', '.', '2024-08-03 19:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_item_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `food_photo` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(24, 'Burger'),
(25, 'Desserts'),
(1, 'Drinks'),
(26, 'Pasta'),
(23, 'Pizza');

-- --------------------------------------------------------

--
-- Table structure for table `cus_delivery_details`
--

CREATE TABLE `cus_delivery_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `name`, `category`, `image`, `price`) VALUES
(54, '1.5l Coca-Cola', 'Drinks', '66b27ab06c31b9.14737875.jpg', 450.00),
(55, 'Sausage Delightjpg', 'Pizza', '66b27e4acbec20.45161330.jpg', 1450.00),
(56, '1.5l Sprite', 'Drinks', '66b683ad9c1fc4.82973541.jpg', 200.00),
(57, 'Chocolate Melt Lava Cake', 'Desserts', '66b683c88bfb23.78594623.jpg', 400.00),
(58, 'Cinnamon Swirls', 'Desserts', '66b683e1154942.29150654.jpg', 300.00),
(59, 'Coca Cola Can', 'Drinks', '66b683f39a4ad8.32679531.jpg', 250.00),
(60, 'Coke Zero 400ml', 'Drinks', '66b6840a63bf88.59540626.jpg', 200.00),
(61, 'Creamy Seafood Pasta', 'Pasta', '66b684238bd9f2.43568364.jpg', 1000.00),
(62, 'Macaroni & Cheese', 'Pasta', '66b6843f1ff707.58970696.jpg', 900.00),
(63, 'Pet coca cola', 'Drinks', '66b68456af0b42.62028132.jpg', 150.00),
(64, 'Pet Sprite', 'Drinks', '66b6846fde2911.94206491.jpg', 200.00),
(65, 'Sausage Delightjpg', 'Pizza', '66b684899b1999.77127206.jpg', 700.00),
(66, 'Spicy fish pizza', 'Pizza', '66b6849f0b5295.32024627.jpg', 1120.00),
(67, 'Thandoori Chiken Pizza', 'Pizza', '66b684b4a3f184.27216806.jpg', 1400.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_item_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `food_photo` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parking_reservations`
--

CREATE TABLE `parking_reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `spot_id` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `duration` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preorder_details`
--

CREATE TABLE `preorder_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preorder_details`
--

INSERT INTO `preorder_details` (`id`, `user_id`, `name`, `email`, `phone`, `address`, `city`) VALUES
(25, 40, 'p.l prashid dilshan', 'customer1@gmail.com', '0765683395', 'kalubowilla,dehiwala ,22/1', 'kalubowila'),
(26, 40, 'p.l prashid dilshan', 'customer1@gmail.com', '0765683395', 'kalubowilla,dehiwala ,22/1', 'kalubowila'),
(27, 40, 'p.l prashid dilshan', 'customer1@gmail.com', '0765683395', 'kalubowilla,dehiwala ,22/1', 'kalubowila');

-- --------------------------------------------------------

--
-- Table structure for table `preorder_items`
--

CREATE TABLE `preorder_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `food_photo` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preorder_items`
--

INSERT INTO `preorder_items` (`id`, `order_id`, `food_name`, `food_photo`, `price`, `quantity`) VALUES
(19, 25, 'Sausage Delightjpg', '66b27e4acbec20.45161330.jpg', 1450.00, 1),
(20, 25, '1.5l Coca-Cola', '66b27ab06c31b9.14737875.jpg', 450.00, 1),
(21, 26, '1.5l Coca-Cola', '66b27ab06c31b9.14737875.jpg', 450.00, 1),
(22, 26, 'Sausage Delightjpg', '66b27e4acbec20.45161330.jpg', 1450.00, 1),
(23, 27, '1.5l Coca-Cola', '66b27ab06c31b9.14737875.jpg', 450.00, 1),
(24, 27, 'Sausage Delightjpg', '66b27e4acbec20.45161330.jpg', 1450.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `guests` int(11) NOT NULL,
  `table_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `email`, `phone`, `date`, `time`, `guests`, `table_number`) VALUES
(10, 'prashid', 'prashiddilshan0710@gmail.com', '0765683395', '2024-08-10', '14:20:00', 4, 'Table 1');

-- --------------------------------------------------------

--
-- Table structure for table `staff_details`
--

CREATE TABLE `staff_details` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `staff_id_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_details`
--

INSERT INTO `staff_details` (`id`, `email`, `password`, `address`, `mobile_number`, `staff_id_number`) VALUES
(7, 'staff1@gmail.com', '$2y$10$5pwW/8ZMe1suzLkczQDT9.eW0Wyg5Ylh9q7Zsy4u.EIE3bv1L2Dri', 'No58 Minipuragama, maligawila,monaragala', '17564543', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(36, 'customer2@gmail.com', '$2y$10$6pjxsm/pETD4Da0ZcVxJVu38mi2rCjPih9dpRikR40Z.7/jFqpRRC'),
(37, 'customer3@gmail.com', '$2y$10$Lbpp8ta19UgAgZlVsWp/BudfTawW//kSoRWdqex4Poc81llp8opni'),
(38, 'customer4@gmail.com', '$2y$10$yjY2qZrpaHk.QK.wr.4maeL6JS8JUOPE.pHinkPIQKvnsbnXnjJOy'),
(39, 'customer5@gmail.com', '$2y$10$Ns6YHwN/vrw.c5Tq.yeHLuGSLEqOX2YM2O7mMr1rRMeoYIWa4dKqO'),
(40, 'customer1@gmail.com', '$2y$10$LcL8A6eg4oqcaLtVBNvTnOnsjvncZI7a0Bg.M/6ASGfz4oURHlhR2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner_details`
--
ALTER TABLE `banner_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `food_item_id` (`food_item_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `cus_delivery_details`
--
ALTER TABLE `cus_delivery_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking_reservations`
--
ALTER TABLE `parking_reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reservation` (`user_id`,`spot_id`,`reservation_date`,`reservation_time`);

--
-- Indexes for table `preorder_details`
--
ALTER TABLE `preorder_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `preorder_items`
--
ALTER TABLE `preorder_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_details`
--
ALTER TABLE `staff_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `staff_id_number` (`staff_id_number`);

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
-- AUTO_INCREMENT for table `banner_details`
--
ALTER TABLE `banner_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `cus_delivery_details`
--
ALTER TABLE `cus_delivery_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `parking_reservations`
--
ALTER TABLE `parking_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `preorder_details`
--
ALTER TABLE `preorder_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `preorder_items`
--
ALTER TABLE `preorder_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff_details`
--
ALTER TABLE `staff_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`food_item_id`) REFERENCES `food_items` (`id`);

--
-- Constraints for table `cus_delivery_details`
--
ALTER TABLE `cus_delivery_details`
  ADD CONSTRAINT `cus_delivery_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `parking_reservations`
--
ALTER TABLE `parking_reservations`
  ADD CONSTRAINT `parking_reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `preorder_details`
--
ALTER TABLE `preorder_details`
  ADD CONSTRAINT `preorder_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `preorder_items`
--
ALTER TABLE `preorder_items`
  ADD CONSTRAINT `preorder_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `preorder_details` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
