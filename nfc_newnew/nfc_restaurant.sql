-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2026 at 10:46 AM
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
-- Database: `nfc_restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'Rheena Fauziana', 'rheenafauziana@gmail.com', '0183506907', '$2y$10$Mg9UipF34n1Dd8O5o/yK3Oq/mmWRqWhYDZO4iJWhnq8yh2HfegE7a', '2026-06-11 16:08:54');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `price`, `old_price`, `category_id`, `description`, `image`, `is_available`) VALUES
(1, 'Classic Chicken Burger', 8.90, 12.90, 1, 'Crispy chicken fillet served with mayonnaise.', 'img/menu/classic_burger.jpg', 1),
(2, 'Spicy Chicken Burger', 9.90, 13.90, 1, 'Crispy spicy fillet topped with mayonnaise.', 'img/menu/spicy_burger.jpg', 1),
(3, 'Cheese Chicken Burger', 10.90, 14.90, 1, 'Crispy fillet topped with melted cheese.', 'img/menu/cheese_burger.jpg', 1),
(4, 'BBQ Chicken Burger', 11.90, 15.90, 1, 'Crispy fillet coated with smoky BBQ sauce.', 'img/menu/bbq_burger.jpg', 1),
(5, '2-pc Fried Chicken', 12.90, 16.90, 2, 'Two pieces of crispy golden fried chicken.', 'img/menu/chicken_2pc.jpg', 1),
(6, '3-pc Fried Chicken', 16.90, 20.90, 2, 'Three pieces of crispy golden fried chicken.', 'img/menu/chicken_3pc.jpg', 1),
(7, 'Spicy Fried Chicken', 13.90, 17.90, 2, 'Crispy fried chicken seasoned with spicy herbs and spices.', 'img/menu/chicken_spicy.jpg', 1),
(8, 'Popcorn Chicken', 8.90, 12.90, 2, 'Bite-sized crispy chicken pieces seasoned with spices.', 'img/menu/popcorn_chicken.jpg', 1),
(9, 'Crispy Chicken Wrap', 9.90, NULL, 3, 'Crispy chicken wrapped with fresh vegetables and sauce.', 'img/menu/crispy_wrap.jpg', 1),
(10, 'Spicy Chicken Wrap', 10.90, NULL, 3, 'Spicy crispy chicken wrapped with lettuce and sauce.', 'img/menu/spicy_wrap.jpg', 1),
(11, 'Cheese Chicken Wrap', 11.90, NULL, 3, 'Chicken wrapped with fresh vegetables and melted cheese.', 'img/menu/cheese_wrap.jpg', 1),
(12, 'Coca-Cola', 3.90, NULL, 4, 'Iconic refreshing carbonated soft drink served chilled.', 'img/menu/cola.jpg', 1),
(13, 'Sprite', 3.90, NULL, 4, 'Famous lemon-lime flavored soft drink served chilled.', 'img/menu/sprite.jpg', 1),
(14, 'Iced Lemon Tea', 4.90, NULL, 4, 'Refreshing tea blended with a hint of lemon flavor.', 'img/menu/lemon_tea.jpg', 1),
(15, 'Mineral Water', 2.50, NULL, 4, 'Pure bottled drinking water.', 'img/menu/mineral.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_category`
--

CREATE TABLE `menu_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_category`
--

INSERT INTO `menu_category` (`category_id`, `category_name`, `display_order`) VALUES
(1, 'Burgers', 1),
(2, 'Chicken', 2),
(3, 'Wraps', 3),
(4, 'Beverages', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_status` enum('pending','preparing','ready','completed','cancelled') DEFAULT 'pending',
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `total_price`, `order_status`, `order_date`) VALUES
(1, 1, 54.90, 'completed', '2026-06-11 16:08:54');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `menu_id`, `item_name`, `quantity`, `unit_price`, `subtotal`) VALUES
(1, 1, 7, 'Spicy Fried Chicken', 2, 13.90, 27.80),
(2, 1, 11, 'Cheese Chicken Wrap', 1, 11.90, 11.90),
(3, 1, 12, 'Coca-Cola', 1, 3.90, 3.90),
(4, 1, 15, 'Mineral Water', 1, 2.50, 2.50),
(5, 1, 14, 'Iced Lemon Tea', 1, 4.90, 4.90),
(6, 1, 13, 'Sprite', 1, 3.90, 3.90);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `username`, `password`, `full_name`, `email`, `role`, `created_at`) VALUES
(1, 'admin', 'admin123', 'Administrator', 'admin@nfc.com', 'admin', '2026-06-11 08:07:04'),
(2, 'staff', 'staff123', 'Kitchen Staff', 'staff@nfc.com', 'staff', '2026-06-11 08:07:04');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `info_id` int(11) NOT NULL,
  `info_key` varchar(100) NOT NULL,
  `info_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`info_id`, `info_key`, `info_value`) VALUES
(1, 'restaurant_name', 'Nandawgs Fried Chicken'),
(2, 'restaurant_address', 'No. 12, Jalan Tuanku Abdul Halim, 50480 Kuala Lumpur'),
(3, 'restaurant_phone', '+603-2612 3456'),
(4, 'restaurant_email', 'hello@nfc.com.my'),
(5, 'restaurant_hours', 'Wed-Thu: 9AM-10PM | Fri: 9AM-11PM | Sat: 10AM-11:30PM | Sun: 11AM-9PM'),
(6, 'currency', 'RM'),
(7, 'tax_rate', '0'),
(8, 'footer_text', '© 2026 Nandawgs Fried Chicken. Distributed by Group 4(WP) / 5(DB)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `menu_category`
--
ALTER TABLE `menu_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`info_id`),
  ADD UNIQUE KEY `info_key` (`info_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `menu_category`
--
ALTER TABLE `menu_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `menu_category` (`category_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
