-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2025 at 12:47 AM
-- Server version: 8.0.42-0ubuntu0.22.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c10db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `volume_product_id` int DEFAULT NULL,
  `quantity` int DEFAULT '1',
  `added_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `volume_product_id`, `quantity`, `added_at`) VALUES
(2, 5, 13, 4, '2025-05-05 18:22:26'),
(3, 5, 22, 2, '2025-05-05 18:22:26'),
(4, 2, 5, 4, '2025-05-05 18:22:26'),
(5, 2, 20, 5, '2025-05-05 18:22:26'),
(6, 3, 9, 5, '2025-05-05 18:22:26'),
(7, 5, 3, 1, '2025-05-05 18:22:26'),
(8, 2, 15, 2, '2025-05-05 18:22:26'),
(9, 5, 20, 1, '2025-05-05 18:22:26'),
(11, 6, 12, 4, '2025-05-05 18:22:26'),
(13, 5, 16, 3, '2025-05-05 18:22:26'),
(15, 35, 5, 5, '2025-05-05 18:22:26'),
(16, 3, 4, 4, '2025-05-05 18:22:26'),
(18, 3, 24, 4, '2025-05-05 18:22:26'),
(20, 3, 8, 4, '2025-05-05 18:22:26'),
(57, 8, 61, 1, '2025-05-10 08:10:59'),
(58, 8, 90, 2, '2025-05-10 08:18:50'),
(60, 8, 95, 1, '2025-05-10 08:19:28'),
(62, 9, 65, 1, '2025-05-10 09:54:25'),
(63, 9, 67, 1, '2025-05-10 09:54:32'),
(64, 9, 90, 2, '2025-05-10 15:19:40'),
(65, 9, 59, 1, '2025-05-10 15:23:14'),
(70, 9, 60, 2, '2025-05-17 06:35:17'),
(71, 1, 64, 3, '2025-05-18 11:17:50'),
(72, 1, 10, 4, '2025-05-18 11:21:51'),
(74, 1, 63, 2, '2025-05-18 16:55:57'),
(75, 1, 33, 2, '2025-05-18 17:54:30'),
(76, 1, 91, 2, '2025-05-18 17:54:39'),
(77, 1, 5, 2, '2025-05-18 17:54:48'),
(78, 1, 29, 1, '2025-05-18 18:21:32'),
(79, 1, 3, 2, '2025-05-18 18:31:56'),
(80, 36, 60, 2, '2025-05-18 22:33:35'),
(81, 36, 61, 2, '2025-05-18 22:33:42'),
(82, 8, 63, 2, '2025-05-19 00:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `type`) VALUES
(1, 'Nam', 'type'),
(2, 'Nữ', 'type'),
(3, 'Unisex', 'type'),
(4, 'Chanel', 'brand'),
(5, 'Gucci', 'brand'),
(6, 'Burberry', 'brand');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(5, 'Cần Thơ'),
(3, 'Đà Nẵng'),
(1, 'Hà Nội'),
(4, 'Hải Phòng'),
(2, 'TP. Hồ Chí Minh');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `name`, `city_id`) VALUES
(1, 'Ba Đình', 1),
(2, 'Hoàn Kiếm', 1),
(3, 'Cầu Giấy', 1),
(4, 'Quận 1', 2),
(5, 'Quận 3', 2),
(6, 'Tân Bình', 2),
(7, 'Hải Châu', 3),
(8, 'Thanh Khê', 3),
(9, 'Đống Đa', 1),
(10, 'Thanh Xuân', 1),
(11, 'Quận 2', 2),
(12, 'Quận 4', 2),
(13, 'Quận 5', 2),
(14, 'Quận 6', 2),
(15, 'Quận 7', 2),
(16, 'Quận 8', 2),
(17, 'Quận 9', 2),
(18, 'Quận 10', 2),
(19, 'Thủ Đức', 2),
(20, 'Gò Vấp', 2),
(21, 'Liên Chiểu', 3),
(22, 'Sơn Trà', 3),
(23, 'Ngũ Hành Sơn', 3),
(24, 'Hồng Bàng', 4),
(25, 'Lê Chân', 4),
(26, 'Ngô Quyền', 4),
(27, 'Kiến An', 4),
(28, 'An Dương', 4),
(29, 'Ninh Kiều', 5),
(30, 'Cái Răng', 5),
(31, 'Bình Thủy', 5),
(32, 'Ô Môn', 5),
(33, 'Thốt Nốt', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` int DEFAULT NULL,
  `total_qty` int DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `note` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address`, `payment_method`, `total_price`, `total_qty`, `status`, `created_at`, `note`) VALUES
(1, 1, '123 Đường ABC, Ba Đình, Hà Nội', 'cod', 18279000, 6, 'pending', '2025-04-05 00:00:00', NULL),
(2, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'paypal', 42772860, 6, 'pending', '2025-04-06 00:00:00', NULL),
(3, 3, '789 Đường DEF, Hoàn Kiếm, Hà Nội', 'cod', 13450000, 3, 'pending', '2025-04-07 00:00:00', NULL),
(4, 7, '101 Đường GHI, Hoàn Kiếm, Hà Nội', 'paypal', 32859900, 7, 'pending', '2025-04-08 00:00:00', NULL),
(5, 5, '202 Đường JKL, Cầu Giấy, Hà Nội', 'credit_card', 19984620, 4, 'pending', '2025-04-09 00:00:00', NULL),
(6, 6, '111 Đường MNO, Quận 1, TP. Hồ Chí Minh', 'paypal', 20799100, 5, 'confirmed', '2025-04-10 00:00:00', NULL),
(7, 1, '123 Đường ABC, Ba Đình, Hà Nội', 'cod', 29504100, 5, 'confirmed', '2025-04-25 00:00:00', NULL),
(8, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'paypal', 24748200, 6, 'confirmed', '2025-04-26 00:00:00', NULL),
(9, 3, '789 Đường DEF, Hoàn Kiếm, Hà Nội', 'paypal', 12048300, 2, 'confirmed', '2025-04-27 00:00:00', NULL),
(10, 7, '101 Đường GHI, Hoàn Kiếm, Hà Nội', 'cod', 23364000, 4, 'confirmed', '2025-04-28 00:00:00', NULL),
(11, 5, '202 Đường JKL, Cầu Giấy, Hà Nội', 'cod', 17720200, 3, 'confirmed', '2025-04-29 00:00:00', NULL),
(12, 6, '111 Đường MNO, Quận 1, TP. Hồ Chí Minh', 'cod', 11221200, 3, 'confirmed', '2025-04-30 00:00:00', ''),
(13, 1, '123 Đường ABC, Ba Đình, Hà Nội', 'credit_card', 27126000, 5, 'confirmed', '2025-04-14 00:00:00', NULL),
(14, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'cod', 23997600, 3, 'confirmed', '2025-04-15 00:00:00', NULL),
(15, 3, '789 Đường DEF, Hoàn Kiếm, Hà Nội', 'cod', 19836000, 4, 'confirmed', '2025-04-16 00:00:00', NULL),
(16, 7, '101 Đường GHI, Hoàn Kiếm, Hà Nội', 'credit_card', 16632660, 5, 'delivered', '2025-04-17 00:00:00', NULL),
(17, 5, '202 Đường JKL, Cầu Giấy, Hà Nội', 'cod', 18370620, 4, 'delivered', '2025-04-18 00:00:00', NULL),
(18, 6, '111 Đường MNO, Quận 1, TP. Hồ Chí Minh', 'paypal', 23285340, 3, 'delivered', '2025-04-19 00:00:00', NULL),
(19, 1, '123 Đường ABC, Ba Đình, Hà Nội', 'cod', 25960900, 5, 'delivered', '2025-04-12 00:00:00', NULL),
(20, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'cod', 9990000, 2, 'delivered', '2025-04-13 00:00:00', NULL),
(21, 3, '789 Đường DEF, Hoàn Kiếm, Hà Nội', 'paypal', 12220200, 2, 'delivered', '2025-04-14 00:00:00', NULL),
(22, 7, '101 Đường GHI, Hoàn Kiếm, Hà Nội', 'credit_card', 11340000, 2, 'delivered', '2025-04-15 00:00:00', NULL),
(23, 5, '202 Đường JKL, Cầu Giấy, Hà Nội', 'credit_card', 18330300, 3, 'delivered', '2025-04-16 00:00:00', NULL),
(24, 6, '111 Đường MNO, Quận 1, TP. Hồ Chí Minh', 'credit_card', 2700000, 1, 'delivered', '2025-04-17 00:00:00', NULL),
(25, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'credit_card', 17175240, 2, 'delivered', '2025-04-29 00:00:00', ''),
(26, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'cod', 11205000, 3, 'cancel', '2025-04-13 00:00:00', NULL),
(27, 3, '789 Đường DEF, Hoàn Kiếm, Hà Nội', 'paypal', 8100000, 3, 'cancel', '2025-04-14 00:00:00', NULL),
(28, 7, '101 Đường GHI, Hoàn Kiếm, Hà Nội', 'paypal', 5814000, 2, 'cancel', '2025-04-15 00:00:00', NULL),
(29, 5, '202 Đường JKL, Cầu Giấy, Hà Nội', 'credit_card', 11270880, 3, 'cancel', '2025-04-16 00:00:00', NULL),
(30, 6, '111 Đường MNO, Quận 1, TP. Hồ Chí Minh', 'cod', 5103000, 1, 'cancel', '2025-04-17 00:00:00', NULL),
(99, 1, '123 Đường ABC, Quận 1, TP. Hồ Chí Minh', 'cod', 44819300, 12, 'shipped', '2025-05-10 22:31:02', ''),
(100, 1, '123 Lê Lợi, P.Bến Thành, Quận 1, TP.HCM, Hải Châu, Đà Nẵng', 'cod', 28360000, 7, 'shipped', '2025-05-16 18:39:00', ''),
(101, 9, '22 Phạm Văn Đồng, Hoàn Kiếm, Hà Nội', 'credit_card', 4400000, 1, 'pending', '2025-05-17 07:05:09', NULL),
(102, 9, '22 Phạm Văn Đồng, Hoàn Kiếm, Hà Nội', 'cod', 14915520, 4, 'pending', '2025-05-17 08:41:44', NULL),
(103, 9, '22 Phạm Văn Đồng, Hoàn Kiếm, Hà Nội', 'cod', 14915520, 0, 'pending', '2025-05-17 08:46:10', NULL),
(104, 9, '22 Phạm Văn Đồng, Hoàn Kiếm, Hà Nội', 'cod', 6115520, 2, 'pending', '2025-05-17 08:46:36', NULL),
(105, 1, '123 Lê Lợi, P.Bến Thành, Liên Chiểu, Đà Nẵng', 'credit_card', 13250000, 3, 'delivered', '2025-05-18 12:15:12', ''),
(106, 1, '123 Lê Lợi, P.Bến Thành, Liên Chiểu, Đà Nẵng', 'cod', 18150000, 4, 'delivered', '2025-05-18 16:44:21', ''),
(107, 1, '123 Lê Lợi, P.Bến Thành, Liên Chiểu, Đà Nẵng', 'cod', 13200000, 3, 'pending', '2025-05-18 18:14:29', NULL),
(108, 1, '123 Lê Lợi, P.Bến Thành, Liên Chiểu, Đà Nẵng', 'cod', 4950000, 1, 'pending', '2025-05-18 18:25:20', NULL),
(109, 1, '123 Lê Lợi, P.Bến Thành, Liên Chiểu, Đà Nẵng', 'cod', 9900000, 2, 'pending', '2025-05-18 18:31:35', NULL),
(110, 1, '123 Lê Lợi, P.Bến Thành, Liên Chiểu, Đà Nẵng', 'cod', 11340000, 2, 'pending', '2025-05-18 18:32:11', NULL),
(111, 1, '123 Lê Lợi, P.Bến Thành, Liên Chiểu, Đà Nẵng', 'cod', 10206000, 2, 'pending', '2025-05-18 18:39:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `volume_product_id` int DEFAULT NULL,
  `quantity` int DEFAULT '1',
  `price` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `volume_product_id`, `quantity`, `price`) VALUES
(1, 1, 112, 3, 2970000),
(2, 1, 67, 3, 3123000),
(3, 2, 3, 3, 5670000),
(4, 2, 71, 3, 8587620),
(5, 3, 17, 2, 4250000),
(6, 3, 64, 1, 4950000),
(7, 4, 52, 3, 4200300),
(8, 4, 29, 1, 4950000),
(9, 4, 30, 3, 5103000),
(10, 5, 11, 3, 3799000),
(11, 5, 39, 1, 8587620),
(12, 6, 5, 2, 5270900),
(13, 6, 38, 3, 3419100),
(14, 7, 78, 1, 4995000),
(15, 7, 24, 3, 6820000),
(16, 7, 42, 1, 4049100),
(17, 8, 73, 3, 4049100),
(18, 8, 83, 3, 4200300),
(19, 9, 110, 1, 7999200),
(20, 9, 42, 1, 4049100),
(21, 10, 113, 3, 6138000),
(22, 10, 95, 1, 4950000),
(23, 11, 115, 2, 6110100),
(24, 11, 2, 1, 5500000),
(25, 12, 36, 1, 3123000),
(26, 12, 104, 2, 4049100),
(27, 13, 113, 2, 6138000),
(28, 13, 33, 3, 4950000),
(29, 14, 110, 1, 7999200),
(30, 14, 48, 2, 7999200),
(31, 15, 113, 2, 6138000),
(32, 15, 59, 2, 3780000),
(33, 16, 16, 3, 2260000),
(34, 16, 66, 2, 4926330),
(35, 17, 32, 2, 4743810),
(36, 17, 28, 1, 3780000),
(37, 17, 92, 1, 5103000),
(38, 18, 84, 1, 6110100),
(39, 18, 71, 2, 8587620),
(40, 19, 18, 2, 6680000),
(41, 19, 114, 3, 4200300),
(42, 20, 109, 2, 4995000),
(43, 21, 53, 2, 6110100),
(44, 22, 3, 2, 5670000),
(45, 23, 84, 3, 6110100),
(46, 24, 85, 1, 2700000),
(47, 25, 31, 2, 8587620),
(48, 26, 99, 3, 3735000),
(49, 27, 54, 3, 2700000),
(50, 28, 72, 2, 2907000),
(51, 29, 96, 3, 3756960),
(52, 30, 61, 1, 5103000),
(1151, 99, 60, 5, 4400000),
(1152, 99, 100, 1, 2659300),
(1153, 99, 59, 6, 3360000),
(1154, 100, 27, 5, 3000000),
(1155, 100, 18, 2, 6680000),
(1156, 101, 60, 1, 4400000),
(1157, 102, 65, 1, 3339520),
(1158, 102, 67, 1, 2776000),
(1159, 102, 60, 2, 4400000),
(1160, 104, 65, 1, 3339520),
(1161, 104, 67, 1, 2776000),
(1162, 105, 10, 2, 4150000),
(1163, 105, 29, 1, 4950000),
(1164, 106, 64, 3, 4400000),
(1165, 106, 29, 1, 4950000),
(1166, 107, 64, 3, 4400000),
(1167, 108, 29, 1, 4950000),
(1168, 109, 29, 2, 4950000),
(1169, 110, 3, 2, 5670000),
(1170, 111, 30, 2, 5103000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_urf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','hidden') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image_urf`, `description`, `status`, `category_id`) VALUES
(1, 'Alien Godness', 'images/nu30.jpg', 'Nước hoa nữ cao cấp với hương thơm quyến rũ', 'hidden', 2),
(2, 'asf asdfs dfdsf 333', 'assets/image/perfume-Img/img.in.canva/slide25-removebg-preview.png', 'Nước hoa nữ kinh điển của Chanel', 'active', 5),
(3, 'Coco Mademoiselle', 'assets/image/perfume-Img/img.in.canva/slide27-removebg-preview.png', 'Nước hoa nữ sang trọng và quyến rũ', 'active', 2),
(4, 'The Voice', 'assets/image/perfume-Img/img.in.canva/slide6-removebg-preview.png', 'Nước hoa unisex với hương thơm độc đáo', 'active', 3),
(5, 'Her', 'assets/image/perfume-Img/img.in.canva/slide16-removebg-preview.png', 'Nước hoa nữ thanh lịch', 'active', 2),
(6, 'Midnight Journey', 'assets/image/perfume-Img/img.in.canva/slide29-removebg-preview.png', 'Nước hoa nam mạnh mẽ', 'active', 1),
(7, 'Gucci Bloom', 'assets/image/perfume-Img/img.in.canva/slide11-removebg-preview.png', 'Nước hoa nữ tươi mới', 'active', 2),
(8, 'Burberry Goddess', 'assets/image/perfume-Img/img.in.canva/slide14-removebg-preview.png', 'Nước hoa nữ sang trọng', 'active', 2),
(9, 'Lancôme Belle Rose', 'assets/image/perfume-Img/img.in.canva/slide31-removebg-preview.png', 'Nước hoa nữ với hương hoa hồng', 'active', 2),
(10, 'Gucci Guilty Pour Homme Eau De Parfum', 'images/1.webp', 'Nước hoa nam cao cấp từ thương hiệu Gucci', 'active', 1),
(11, 'Gucci Guilty Black Pour Homme EDT', 'images/43.webp', 'Phiên bản đặc biệt của dòng Gucci Guilty dành cho nam', 'active', 1),
(12, 'A Song for the Rose', 'images/nu1.jpg', 'Nước hoa nữ với hương thơm của hoa hồng', 'active', 2),
(13, 'The Voice of the Snake', 'images/nu3.jpg', 'Nước hoa nữ độc đáo từ bộ sưu tập The Alchemist\'s Garden', 'active', 2),
(14, 'YSL MYSLF EDP', 'images/21.webp', 'Nước hoa nam từ YSL', 'active', 1),
(15, 'Burberry Hero EDT', 'images/15.png', 'Nước hoa nam mạnh mẽ và nam tính', 'active', 1),
(16, 'Burberry Brit Rhythm For Men EDT', 'images/17.webp', 'Nước hoa nam với hương thơm rock\'n\'roll', 'active', 1),
(17, 'Thierry Mugler Alien Goddes', 'images/nu29.jpg', 'Nước hoa nữ với hương thơm quyến rũ', 'active', 2),
(18, 'Charme Good Girl', 'images/nu27.jpg', 'Nước hoa nữ sang trọng và gợi cảm', 'active', 2),
(19, 'Dior Sauvage Elixir', 'images/35.webp', 'Nước hoa nam đẳng cấp từ Dior', 'active', 1),
(20, 'Yves Saint Laurent YSL Y EDP', 'images/23.webp', 'Nước hoa nam hiện đại và nam tính', 'active', 1),
(21, 'CHANEL CRISTALLE', 'images/nu17.jpg', 'Nước hoa nữ thanh lịch từ Chanel', 'active', 2),
(22, 'Victoria\'s Secret Very Sexy 2018', 'images/nu35.jpg', 'Nước hoa nữ gợi cảm và quyến rũ', 'active', 2),
(23, 'Dior Homme Intense EDP', 'images/33.webp', 'Nước hoa nam sang trọng từ Dior', 'active', 1),
(24, 'Lancome Roses Berberanza', 'images/uni13.jpg', 'Nước hoa unisex với hương hoa hồng', 'active', 3),
(25, 'Dolce & Gabbana The Only One 2', 'images/nu37.jpg', 'Nước hoa nữ độc đáo và sang trọng', 'active', 2),
(26, 'Chanel Allure Homme Sport EDT', 'images/31.webp', 'Nước hoa nam thể thao từ Chanel', 'active', 1),
(27, 'Hermès Terre D\'Hermès EDT H Bottle Limited Edition', 'images/45.png', 'Phiên bản giới hạn của Terre D\'Hermès', 'active', 1),
(78, '3333', 'images/1747515227_s111.webp', '', 'active', 3),
(79, '3333', 'images/1747515282_s111.webp', '', 'active', 4),
(80, '22222', 'images/1747527353_s111.webp', '', 'active', 0),
(81, 'asfdsdf', 'images/1747528235_s111.webp', '', 'active', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `product_id`, `category_id`) VALUES
(1, 6, 1),
(2, 10, 1),
(3, 11, 1),
(4, 14, 1),
(5, 15, 1),
(6, 16, 1),
(7, 19, 1),
(8, 20, 1),
(9, 23, 1),
(10, 26, 1),
(11, 27, 1),
(16, 1, 2),
(17, 2, 2),
(18, 3, 2),
(19, 5, 2),
(20, 7, 2),
(21, 8, 2),
(22, 9, 2),
(23, 12, 2),
(24, 13, 2),
(25, 17, 2),
(26, 18, 2),
(27, 21, 2),
(28, 22, 2),
(29, 25, 2),
(31, 4, 3),
(32, 24, 3),
(34, 1, 6),
(35, 5, 6),
(36, 8, 6),
(37, 14, 6),
(38, 15, 6),
(39, 16, 6),
(40, 17, 6),
(41, 22, 6),
(42, 25, 6),
(43, 2, 4),
(44, 3, 4),
(45, 6, 4),
(46, 18, 4),
(47, 21, 4),
(48, 24, 4),
(49, 26, 4),
(50, 27, 4),
(51, 4, 5),
(52, 7, 5),
(53, 9, 5),
(54, 10, 5),
(55, 11, 5),
(56, 12, 5),
(57, 13, 5),
(58, 19, 5),
(59, 20, 5),
(60, 23, 5),
(65, 78, 3),
(66, 79, 4),
(67, 81, 2),
(68, 81, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','lock') COLLATE utf8mb4_unicode_ci DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `address`, `number`, `role`, `district_id`, `fullname`, `status`) VALUES
(1, 'nguyenvana', 'vana@example.com', '$2y$10$VUbKqv6XMMLoeEYsbV09BOV7jKvxKUd1XkSlFZhAZxG.CKdMCEiZO', '123 Lê Lợi, P.Bến Thành', '0911000001', 'user', 21, 'Nguyễn Văn b', 'active'),
(2, 'tranthib', 'thib@example.com', '$2y$10$spwF.ZVtAKQy0SM6oTcJfebOHz/gSrK1bgXG4ld1Rq4XFzcGUvoFm', '45 Trần Hưng Đạo, P.Nguyễn Cư Trinh', '0911000002', 'user', 5, 'Trần Thị B', 'active'),
(3, 'levanc', 'vanc@example.com', '$2y$10$euVjovZnA9zi7xgJyzkG0u5dZ1BTm8irmAEpiTZhGS/GLuo5u2Vo6', '78 Cách Mạng Tháng 8, P.4', '0911000003', 'user', 18, 'Lê Văn C', 'active'),
(5, 'hoangvanh', 'vanh@example.com', '$2y$10$vq2tvwSrQDlMIqqJhIKXKe4CVmIi28NQtBh.gQ5YxCa7WBzY222Hy', '102 Nguyễn Đình Chiểu, P.6', '0911000005', 'user', 18, 'Hoàng Văn H', 'active'),
(6, 'dinhtif', 'tif@example.com', '$2y$10$zCSGPgSD6TA2c7aLADaVrukOd873aBFyJc0LtJEzY.V5bxI2LqU2q', '11 Lý Thường Kiệt, P.12', '0911000006', 'user', 5, 'Đinh Thị F', 'active'),
(7, 'ngovang', 'vang@example.com', '$2y$10$1dwcKYU0oaT9i2cuoZIy8eT7Cgh8TZy13X0UXcFS8f/mjSKtnmwNO', '67 Lạc Long Quân, P.5', '0911000007', 'user', 12, 'Ngô Văn G', 'active'),
(8, 'tothih', 'thih@example.com', '$2y$10$DeCsl8lqG9gyudPnN6.Bf.5AYjT81nZlN/gohNpFs4DimZCyqRVx.', '99 Nguyễn Văn Cừ, P.1', '0911000008', 'user', 13, 'Tô Thị H', 'active'),
(9, 'lyvani', 'vani@example.com', '$2y$10$o2HMF.aciQu/xvw6.ki5pOYexc/uUW/YkmQkPztt.wcz9GSPSyAYC', '22 Phạm Văn Đồng', '0911000009', 'user', 2, 'Lý Văn Lương', 'active'),
(10, 'vuthij', 'thij@example.com', '$2y$10$qiUeCrHGwX9KPQ9rw3WRCuwuJeOs8ZBsx.DGKrGSBGkQgnIQajTeW', '35 Võ Văn Ngân, P.Bình Thọ', '0911000010', 'user', 17, 'Vũ Thị J', 'active'),
(11, 'admin_lan', 'lan.admin@example.com', '$2y$10$pT.xVUwC0s8Smg8DetTOt.BP352w2MlfSTfRSYGAsxOz2dp4UEBce', '1A Nguyễn Huệ', '0988000011', 'admin', 3, 'Nguyễn Lan', 'active'),
(12, 'admin_quan', 'quan.admin@example.com', '$2y$10$leJXA.SwDNGcH7XzH3N6.OpeUhH/pnLul2Nv8JGltIDubpA45zUGu', '2B Võ Văn Tần', '0988000012', 'admin', 1, 'Lê Quốc Quân', 'active'),
(13, 'admin_hoa', 'hoa.admin@example.com', '$2y$10$VMT8UIpAvKFSV9sA5gnDV.sRQMH6r6EKS4DfBy5panJ.BSc8rqKfq', '3C Điện Biên Phủ', '0988000013', 'admin', 5, 'Trần Thị Hoa', 'active'),
(14, 'superadmin', 'superadmin@example.com', '$2y$10$JvbjUctZIaSQkxwDXnWKR.vvjegb3k5PcSeb1b8TW4XiNGayLPyZ.', 'Trụ sở chính', '0912345678', 'super_admin', NULL, 'Super Admin', 'active'),
(35, 'mii', 'mi@gmail.com', '$2y$10$/bEAGaVEClAENXzp6s/.3e4HqPnnAbV1025XMZtdYDPNlvTP.gmuW', NULL, '1231234567', 'user', NULL, NULL, 'active'),
(36, 'tieumy', 'tieumy@gmail.com', '$2y$10$x3MBbmrsLVf/KosHuxcLFurQSQt.dhlAZGtujTdj6g5eCS4stxewS', NULL, '1515161718', 'user', NULL, NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `volume`
--

CREATE TABLE `volume` (
  `id` int NOT NULL,
  `value` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `volume`
--

INSERT INTO `volume` (`id`, `value`) VALUES
(1, 10),
(2, 30),
(3, 50),
(4, 100);

-- --------------------------------------------------------

--
-- Table structure for table `volume_product`
--

CREATE TABLE `volume_product` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `volume_id` int DEFAULT NULL,
  `available_qty` int DEFAULT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `volume_product`
--

INSERT INTO `volume_product` (`id`, `product_id`, `volume_id`, `available_qty`, `price`) VALUES
(1, 1, 4, 20, 4200000),
(2, 2, 4, 20, 5500000),
(3, 3, 4, 20, 5670000),
(4, 4, 4, 20, 9541800),
(5, 5, 4, 20, 5270900),
(6, 6, 4, 20, 5500000),
(7, 7, 4, 20, 4174400),
(8, 8, 4, 20, 5473700),
(9, 9, 4, 20, 3470000),
(10, 10, 4, 20, 4150000),
(11, 11, 4, 20, 3799000),
(12, 12, 4, 20, 9541800),
(13, 13, 4, 20, 9541800),
(14, 14, 4, 20, 3230000),
(15, 15, 4, 20, 4499000),
(16, 16, 4, 20, 2260000),
(17, 17, 4, 20, 4250000),
(18, 18, 4, 20, 6680000),
(19, 19, 4, 20, 4200000),
(20, 20, 4, 20, 5550000),
(21, 21, 4, 20, 8888000),
(22, 22, 4, 20, 9999999),
(23, 23, 4, 20, 3300000),
(24, 24, 4, 20, 6820000),
(25, 25, 4, 20, 4667000),
(26, 26, 4, 20, 6789000),
(27, 27, 4, 20, 3000000),
(28, 1, 3, 20, 3780000),
(29, 2, 3, 20, 4950000),
(30, 3, 3, 20, 5103000),
(31, 4, 3, 20, 8587620),
(32, 5, 3, 20, 4743810),
(33, 6, 3, 20, 4950000),
(34, 7, 3, 20, 3756960),
(35, 8, 3, 20, 4926330),
(36, 9, 3, 20, 3123000),
(37, 10, 3, 20, 3735000),
(38, 11, 3, 20, 3419100),
(39, 12, 3, 20, 8587620),
(40, 13, 3, 20, 8587620),
(41, 14, 3, 20, 2907000),
(42, 15, 3, 20, 4049100),
(43, 16, 3, 20, 2034000),
(44, 17, 3, 20, 3825000),
(45, 18, 3, 20, 6012000),
(46, 19, 3, 20, 3780000),
(47, 20, 3, 20, 4995000),
(48, 21, 3, 20, 7999200),
(49, 22, 3, 20, 8999999),
(50, 23, 3, 20, 2970000),
(51, 24, 3, 20, 6138000),
(52, 25, 3, 20, 4200300),
(53, 26, 3, 20, 6110100),
(54, 27, 3, 20, 2700000),
(59, 1, 2, 20, 3360000),
(60, 2, 2, 20, 4400000),
(61, 3, 2, 20, 4536000),
(62, 4, 2, 20, 7633440),
(63, 5, 2, 20, 4216720),
(64, 6, 2, 20, 4400000),
(65, 7, 2, 20, 3339520),
(66, 8, 2, 20, 4378960),
(67, 9, 2, 20, 2776000),
(68, 10, 2, 20, 3320000),
(69, 11, 2, 20, 3039200),
(70, 12, 2, 20, 7633440),
(71, 13, 2, 20, 7633440),
(72, 14, 2, 20, 2584000),
(73, 15, 2, 20, 3599200),
(74, 16, 2, 20, 1808000),
(75, 17, 2, 20, 3400000),
(76, 18, 2, 20, 5344000),
(77, 19, 2, 20, 3360000),
(78, 20, 2, 20, 4440000),
(79, 21, 2, 20, 7110400),
(80, 22, 2, 20, 7999999),
(81, 23, 2, 20, 2640000),
(82, 24, 2, 20, 5456000),
(83, 25, 2, 20, 3733600),
(84, 26, 2, 20, 5431200),
(85, 27, 2, 20, 2400000),
(90, 1, 1, 20, 2940000),
(91, 2, 1, 20, 3850000),
(92, 3, 1, 20, 3969000),
(93, 4, 1, 20, 6679260),
(94, 5, 1, 20, 3689630),
(95, 6, 1, 20, 3850000),
(96, 7, 1, 20, 2922080),
(97, 8, 1, 20, 3831590),
(98, 9, 1, 20, 2429000),
(99, 10, 1, 20, 2905000),
(100, 11, 1, 20, 2659300),
(101, 12, 1, 20, 6679260),
(102, 13, 1, 20, 6679260),
(103, 14, 1, 20, 2261000),
(104, 15, 1, 20, 3149300),
(105, 16, 1, 20, 1582000),
(106, 17, 1, 20, 2975000),
(107, 18, 1, 20, 4676000),
(108, 19, 1, 20, 2940000),
(109, 20, 1, 20, 3885000),
(110, 21, 1, 20, 6221600),
(111, 22, 1, 20, 6999999),
(112, 23, 1, 20, 2310000),
(113, 24, 1, 20, 4774000),
(114, 25, 1, 20, 3266900),
(115, 26, 1, 20, 4752300),
(116, 27, 1, 20, 2100000),
(117, 29, 4, 20, 12323),
(118, 30, 4, 20, 1232323),
(119, 31, 1, 20, 1111),
(120, 31, 4, 20, 1232323999),
(121, 77, 4, 20, 12121212),
(122, 78, 2, 20, 3000000),
(123, 78, 4, 20, 5000000),
(124, 79, 2, 20, 3000000),
(125, 79, 4, 20, 5000000),
(126, 80, 2, 20, 3000000),
(127, 80, 4, 20, 5000000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `volume_product_id` (`volume_product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `volume_product_id` (`volume_product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `volume`
--
ALTER TABLE `volume`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `value` (`value`);

--
-- Indexes for table `volume_product`
--
ALTER TABLE `volume_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `volume_id` (`volume_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1171;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `volume_product`
--
ALTER TABLE `volume_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
