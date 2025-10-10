-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2025 at 02:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`category_id`, `category_name`) VALUES
(1, 'เครื่องดื่ม'),
(2, 'อาหารแห้ง'),
(3, 'ขนม'),
(4, 'ของใช้ส่วนตัว'),
(5, 'ผลิตภัณฑ์ทำความสะอาด'),
(6, 'เครื่องเขียน');

-- --------------------------------------------------------

--
-- Table structure for table `tb_products`
--

CREATE TABLE `tb_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `is_active` enum('Available','Not Available') DEFAULT 'Available',
  `product_pic` varchar(100) DEFAULT NULL,
  `product_num` int(11) NOT NULL,
  `stock_qty` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_products`
--

INSERT INTO `tb_products` (`product_id`, `product_name`, `category_id`, `cost_price`, `sell_price`, `is_active`, `product_pic`, `product_num`, `stock_qty`) VALUES
(3, 'บะหมี่กึ่งสำเร็จรูป', 2, 12.00, 15.00, 'Not Available', 'p3.jpg', 500, 0),
(4, 'เป็ปซี่', 1, 15.00, 20.00, 'Available', 'p4.jpg', 80, 95),
(10, 'เบียร์สิงห์', 1, 45.00, 60.00, 'Available', 'p10.jpg', 100, 40);

-- --------------------------------------------------------

--
-- Table structure for table `tb_roles`
--

CREATE TABLE `tb_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_roles`
--

INSERT INTO `tb_roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `tb_sales`
--

CREATE TABLE `tb_sales` (
  `sale_id` int(11) NOT NULL,
  `sale_no` bigint(20) DEFAULT NULL,
  `sale_datetime` datetime NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_sales`
--

INSERT INTO `tb_sales` (`sale_id`, `sale_no`, `sale_datetime`, `subtotal`, `tax`, `total`, `user_id`) VALUES
(8, 1760094829, '2025-10-10 18:13:49', 200.00, 14.00, 214.00, 1),
(9, 1760095309, '2025-10-10 18:21:49', 700.00, 49.00, 749.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_salestime`
--

CREATE TABLE `tb_salestime` (
  `sale_time_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `line_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_salestime`
--

INSERT INTO `tb_salestime` (`sale_time_id`, `sale_id`, `product_id`, `qty`, `unit_price`, `line_total`) VALUES
(8, 8, 4, 10, 20.00, 200.00),
(9, 9, 4, 5, 20.00, 100.00),
(10, 9, 10, 10, 60.00, 600.00);

-- --------------------------------------------------------

--
-- Table structure for table `tb_stock_movement`
--

CREATE TABLE `tb_stock_movement` (
  `movement_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `movement_type` varchar(100) DEFAULT NULL,
  `qty_signed` char(1) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `stock_qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_stock_movement`
--

INSERT INTO `tb_stock_movement` (`movement_id`, `product_id`, `movement_type`, `qty_signed`, `note`, `user_id`, `created_at`, `stock_qty`) VALUES
(5, 10, 'เพิ่มสินค้าใหม่', '+', 'เพิ่มสินค้า เบียร์สิงห์ จำนวน 120 ชิ้น', 1, '2025-10-08 21:52:53', NULL),
(26, 4, 'เบิกสินค้า', '-', 'เบิกสินค้า เป็ปซี่ จำนวน 120 ชิ้น จากคลังเข้าหน้าร้าน', 1, '2025-10-10 18:08:01', 120),
(27, 10, 'เบิกสินค้า', '-', 'เบิกสินค้า เบียร์สิงห์ จำนวน 50 ชิ้น จากคลังเข้าหน้าร้าน', 1, '2025-10-10 18:08:46', 50);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `user_id` int(11) NOT NULL,
  `name_user` varchar(100) NOT NULL,
  `sname_user` varchar(100) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `name_user`, `sname_user`, `tel`, `username`, `password`, `role_id`) VALUES
(1, 'James', 'Browns', '0547214430', 'Admin1', 'password123', 1),
(2, 'Alex', 'Morgan', '0641248966', 'Staff1', 'password456', 2),
(3, 'Dexter', 'Morgan', '0819875412', 'Admin2', 'password123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tb_products`
--
ALTER TABLE `tb_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tb_sales`
--
ALTER TABLE `tb_sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD UNIQUE KEY `sale_no` (`sale_no`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_salestime`
--
ALTER TABLE `tb_salestime`
  ADD PRIMARY KEY (`sale_time_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tb_stock_movement`
--
ALTER TABLE `tb_stock_movement`
  ADD PRIMARY KEY (`movement_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `tel` (`tel`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_products`
--
ALTER TABLE `tb_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_sales`
--
ALTER TABLE `tb_sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_salestime`
--
ALTER TABLE `tb_salestime`
  MODIFY `sale_time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_stock_movement`
--
ALTER TABLE `tb_stock_movement`
  MODIFY `movement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_products`
--
ALTER TABLE `tb_products`
  ADD CONSTRAINT `tb_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tb_category` (`category_id`);

--
-- Constraints for table `tb_sales`
--
ALTER TABLE `tb_sales`
  ADD CONSTRAINT `tb_sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`);

--
-- Constraints for table `tb_salestime`
--
ALTER TABLE `tb_salestime`
  ADD CONSTRAINT `tb_salestime_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `tb_sales` (`sale_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_salestime_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tb_products` (`product_id`);

--
-- Constraints for table `tb_stock_movement`
--
ALTER TABLE `tb_stock_movement`
  ADD CONSTRAINT `tb_stock_movement_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tb_products` (`product_id`),
  ADD CONSTRAINT `tb_stock_movement_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`);

--
-- Constraints for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD CONSTRAINT `tb_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tb_roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
