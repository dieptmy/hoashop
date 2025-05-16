-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 11:31 PM
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
-- Database: `c10db`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Burberry'),
(2, 'Chanel'),
(3, 'Gucci');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `volume_product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `volume_product_id`, `quantity`, `added_at`) VALUES
(1, 1, 27, 4, '2025-05-05 18:22:26'),
(2, 5, 13, 4, '2025-05-05 18:22:26'),
(3, 5, 22, 2, '2025-05-05 18:22:26'),
(4, 2, 5, 4, '2025-05-05 18:22:26'),
(5, 2, 20, 5, '2025-05-05 18:22:26'),
(6, 3, 9, 5, '2025-05-05 18:22:26'),
(7, 5, 3, 1, '2025-05-05 18:22:26'),
(8, 2, 15, 2, '2025-05-05 18:22:26'),
(9, 5, 20, 1, '2025-05-05 18:22:26'),
(10, 1, 18, 3, '2025-05-05 18:22:26'),
(11, 6, 12, 4, '2025-05-05 18:22:26'),
(12, 1, 10, 5, '2025-05-05 18:22:26'),
(13, 5, 16, 3, '2025-05-05 18:22:26'),
(14, 1, 23, 1, '2025-05-05 18:22:26'),
(15, 4, 5, 5, '2025-05-05 18:22:26'),
(16, 3, 4, 4, '2025-05-05 18:22:26'),
(17, 1, 4, 4, '2025-05-05 18:22:26'),
(18, 3, 24, 4, '2025-05-05 18:22:26'),
(19, 1, 7, 5, '2025-05-05 18:22:26'),
(20, 3, 8, 4, '2025-05-05 18:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'nam'),
(2, 'nữ'),
(3, 'unisex');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
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
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `city_id` int(11) DEFAULT NULL
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
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `total_qty` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT '',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address`, `payment_method`, `total_price`, `total_qty`, `status`, `created_at`) VALUES
(1, 1, '123 Đường ABC, Ba Đình, Hà Nội', 'cod', 18279000, 6, 'pending', '2025-04-05 00:00:00'),
(2, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'paypal', 42772860, 6, 'pending', '2025-04-06 00:00:00'),
(3, 3, '789 Đường DEF, Hoàn Kiếm, Hà Nội', 'cod', 13450000, 3, 'pending', '2025-04-07 00:00:00'),
(4, 4, '101 Đường GHI, Hoàn Kiếm, Hà Nội', 'paypal', 32859900, 7, 'pending', '2025-04-08 00:00:00'),
(5, 5, '202 Đường JKL, Cầu Giấy, Hà Nội', 'credit_card', 19984620, 4, 'pending', '2025-04-09 00:00:00'),
(6, 6, '111 Đường MNO, Quận 1, TP. Hồ Chí Minh', 'paypal', 20799100, 5, 'confirmed', '2025-04-10 00:00:00'),
(7, 1, '123 Đường ABC, Ba Đình, Hà Nội', 'cod', 29504100, 5, 'confirmed', '2025-04-25 00:00:00'),
(8, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'paypal', 24748200, 6, 'confirmed', '2025-04-26 00:00:00'),
(9, 3, '789 Đường DEF, Hoàn Kiếm, Hà Nội', 'paypal', 12048300, 2, 'confirmed', '2025-04-27 00:00:00'),
(10, 4, '101 Đường GHI, Hoàn Kiếm, Hà Nội', 'cod', 23364000, 4, 'confirmed', '2025-04-28 00:00:00'),
(11, 5, '202 Đường JKL, Cầu Giấy, Hà Nội', 'cod', 17720200, 3, 'confirmed', '2025-04-29 00:00:00'),
(12, 6, '111 Đường MNO, Quận 1, TP. Hồ Chí Minh', 'cod', 11221200, 3, 'confirmed', '2025-04-30 00:00:00'),
(13, 1, '123 Đường ABC, Ba Đình, Hà Nội', 'credit_card', 27126000, 5, 'confirmed', '2025-04-14 00:00:00'),
(14, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'cod', 23997600, 3, 'confirmed', '2025-04-15 00:00:00'),
(15, 3, '789 Đường DEF, Hoàn Kiếm, Hà Nội', 'cod', 19836000, 4, 'confirmed', '2025-04-16 00:00:00'),
(16, 4, '101 Đường GHI, Hoàn Kiếm, Hà Nội', 'credit_card', 16632660, 5, 'delivered', '2025-04-17 00:00:00'),
(17, 5, '202 Đường JKL, Cầu Giấy, Hà Nội', 'cod', 18370620, 4, 'delivered', '2025-04-18 00:00:00'),
(18, 6, '111 Đường MNO, Quận 1, TP. Hồ Chí Minh', 'paypal', 23285340, 3, 'delivered', '2025-04-19 00:00:00'),
(19, 1, '123 Đường ABC, Ba Đình, Hà Nội', 'cod', 25960900, 5, 'delivered', '2025-04-12 00:00:00'),
(20, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'cod', 9990000, 2, 'delivered', '2025-04-13 00:00:00'),
(21, 3, '789 Đường DEF, Hoàn Kiếm, Hà Nội', 'paypal', 12220200, 2, 'delivered', '2025-04-14 00:00:00'),
(22, 4, '101 Đường GHI, Hoàn Kiếm, Hà Nội', 'credit_card', 11340000, 2, 'delivered', '2025-04-15 00:00:00'),
(23, 5, '202 Đường JKL, Cầu Giấy, Hà Nội', 'credit_card', 18330300, 3, 'delivered', '2025-04-16 00:00:00'),
(24, 6, '111 Đường MNO, Quận 1, TP. Hồ Chí Minh', 'credit_card', 2700000, 1, 'delivered', '2025-04-17 00:00:00'),
(25, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'credit_card', 17175240, 2, 'delivered', '2025-04-29 00:00:00'),
(26, 2, '456 Đường XYZ, Ba Đình, Hà Nội', 'cod', 11205000, 3, 'cancel', '2025-04-13 00:00:00'),
(27, 3, '789 Đường DEF, Hoàn Kiếm, Hà Nội', 'paypal', 8100000, 3, 'cancel', '2025-04-14 00:00:00'),
(28, 4, '101 Đường GHI, Hoàn Kiếm, Hà Nội', 'paypal', 5814000, 2, 'cancel', '2025-04-15 00:00:00'),
(29, 5, '202 Đường JKL, Cầu Giấy, Hà Nội', 'credit_card', 11270880, 3, 'cancel', '2025-04-16 00:00:00'),
(30, 6, '111 Đường MNO, Quận 1, TP. Hồ Chí Minh', 'cod', 5103000, 1, 'cancel', '2025-04-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `volume_product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` int(11) DEFAULT NULL
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
(52, 30, 61, 1, 5103000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_urf` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `brand_id`, `category_id`, `image_urf`, `description`) VALUES
(1, 'Alien Goddess', 1, 2, 'assets/image/perfume-Img/img.in.canva/slide34-removebg-preview.png', 'Nước hoa nữ cao cấp với hương thơm quyến rũ'),
(2, 'N°5', 2, 2, 'assets/image/perfume-Img/img.in.canva/slide25-removebg-preview.png', 'Nước hoa nữ kinh điển của Chanel'),
(3, 'Coco Mademoiselle', 2, 2, 'assets/image/perfume-Img/img.in.canva/slide27-removebg-preview.png', 'Nước hoa nữ sang trọng và quyến rũ'),
(4, 'The Voice', 3, 3, 'assets/image/perfume-Img/img.in.canva/slide6-removebg-preview.png', 'Nước hoa unisex với hương thơm độc đáo'),
(5, 'Her', 1, 2, 'assets/image/perfume-Img/img.in.canva/slide16-removebg-preview.png', 'Nước hoa nữ thanh lịch'),
(6, 'Midnight Journey', 2, 1, 'assets/image/perfume-Img/img.in.canva/slide29-removebg-preview.png', 'Nước hoa nam mạnh mẽ'),
(7, 'Gucci Bloom', 3, 2, 'assets/image/perfume-Img/img.in.canva/slide11-removebg-preview.png', 'Nước hoa nữ tươi mới'),
(8, 'Burberry Goddess', 1, 2, 'assets/image/perfume-Img/img.in.canva/slide14-removebg-preview.png', 'Nước hoa nữ sang trọng'),
(9, 'Lancôme Belle Rose', 3, 2, 'assets/image/perfume-Img/img.in.canva/slide31-removebg-preview.png', 'Nước hoa nữ với hương hoa hồng'),
(10, 'Gucci Guilty Pour Homme Eau De Parfum', 3, 1, 'images/1.webp', 'Nước hoa nam cao cấp từ thương hiệu Gucci'),
(11, 'Gucci Guilty Black Pour Homme EDT', 3, 1, 'images/43.webp', 'Phiên bản đặc biệt của dòng Gucci Guilty dành cho nam'),
(12, 'A Song for the Rose', 3, 2, 'images/nu1.jpg', 'Nước hoa nữ với hương thơm của hoa hồng'),
(13, 'The Voice of the Snake', 3, 2, 'images/nu3.jpg', 'Nước hoa nữ độc đáo từ bộ sưu tập The Alchemist\'s Garden'),
(14, 'YSL MYSLF EDP', 1, 1, 'images/21.webp', 'Nước hoa nam từ YSL'),
(15, 'Burberry Hero EDT', 1, 1, 'images/15.png', 'Nước hoa nam mạnh mẽ và nam tính'),
(16, 'Burberry Brit Rhythm For Men EDT', 1, 1, 'images/17.webp', 'Nước hoa nam với hương thơm rock\'n\'roll'),
(17, 'Thierry Mugler Alien Goddess', 1, 2, 'images/nu29.jpg', 'Nước hoa nữ với hương thơm quyến rũ'),
(18, 'Charme Good Girl', 2, 2, 'images/nu27.jpg', 'Nước hoa nữ sang trọng và gợi cảm'),
(19, 'Dior Sauvage Elixir', 3, 1, 'images/35.webp', 'Nước hoa nam đẳng cấp từ Dior'),
(20, 'Yves Saint Laurent YSL Y EDP', 3, 1, 'images/23.webp', 'Nước hoa nam hiện đại và nam tính'),
(21, 'CHANEL CRISTALLE', 2, 2, 'images/nu17.jpg', 'Nước hoa nữ thanh lịch từ Chanel'),
(22, 'Victoria\'s Secret Very Sexy 2018', 1, 2, 'images/nu35.jpg', 'Nước hoa nữ gợi cảm và quyến rũ'),
(23, 'Dior Homme Intense EDP', 3, 1, 'images/33.webp', 'Nước hoa nam sang trọng từ Dior'),
(24, 'Lancome Roses Berberanza', 2, 3, 'images/uni13.jpg', 'Nước hoa unisex với hương hoa hồng'),
(25, 'Dolce & Gabbana The Only One 2', 1, 2, 'images/nu37.jpg', 'Nước hoa nữ độc đáo và sang trọng'),
(26, 'Chanel Allure Homme Sport EDT', 2, 1, 'images/31.webp', 'Nước hoa nam thể thao từ Chanel'),
(27, 'Hermès Terre D\'Hermès EDT H Bottle Limited Edition', 2, 1, 'images/45.png', 'Phiên bản giới hạn của Terre D\'Hermès');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `role` varchar(30) NOT NULL,
  `district_id` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `status` enum('active', 'lock') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `address`, `number`, `role`, `district_id`, `fullname`) VALUES
(1, 'user1', 'user1@example.com', '123456', '123 Đường ABC', '0123456789', 'user', 1, 'Nguyễn Văn A'),
(2, 'user2', 'user2@example.com', '123456', '456 Đường XYZ', '0987654321', 'user', 1, 'Nguyễn Văn B'),
(3, 'user3', 'user3@example.com', '123456', '789 Đường DEF', '0369852147', 'user', 2, 'Nguyễn Văn C'),
(4, 'user4', 'user4@example.com', '123456', '101 Đường GHI', '0587412369', 'user', 2, 'Nguyễn Văn D'),
(5, 'user5', 'user5@example.com', '123456', '202 Đường JKL', '0741258963', 'user', 3, 'Nguyễn Văn E'),
(6, 'user6', 'user6@example.com', '123456', '111 Đường MNO', '0865141312', 'user', 4, 'Nguyễn Văn F'),
(7, 'user7', 'user7@example.com', '123456', NULL, '0987774321', 'user', NULL, NULL),
(8, 'user8', 'user8@example.com', '123456', NULL, '0587987369', 'user', NULL, NULL),
(9, 'user9', 'user9@example.com', '123456', NULL, '0587412119', 'user', NULL, NULL),
(10, 'user10', 'user10@example.com', '123456', NULL, '0587412369', 'user', NULL, NULL),
(11, 'admin1', 'admin1@example.com', '123456', NULL, '0587412369', 'admin', NULL, 'Lê Văn A'),
(12, 'admin2', 'admin2@example.com', '123456', NULL, '0587412369', 'admin', NULL, 'Lê Văn B'),
(13, 'admin3', 'admin3@example.com', '123456', NULL, '0587412369', 'admin', NULL, 'Lê Văn C');

-- --------------------------------------------------------

--
-- Table structure for table `volume`
--

CREATE TABLE `volume` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL
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
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `volume_id` int(11) DEFAULT NULL,
  `available_qty` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL
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
(59, 1, 2, 20, 3780000),
(60, 2, 2, 20, 4950000),
(61, 3, 2, 20, 5103000),
(62, 4, 2, 20, 8587620),
(63, 5, 2, 20, 4743810),
(64, 6, 2, 20, 4950000),
(65, 7, 2, 20, 3756960),
(66, 8, 2, 20, 4926330),
(67, 9, 2, 20, 3123000),
(68, 10, 2, 20, 3735000),
(69, 11, 2, 20, 3419100),
(70, 12, 2, 20, 8587620),
(71, 13, 2, 20, 8587620),
(72, 14, 2, 20, 2907000),
(73, 15, 2, 20, 4049100),
(74, 16, 2, 20, 2034000),
(75, 17, 2, 20, 3825000),
(76, 18, 2, 20, 6012000),
(77, 19, 2, 20, 3780000),
(78, 20, 2, 20, 4995000),
(79, 21, 2, 20, 7999200),
(80, 22, 2, 20, 8999999),
(81, 23, 2, 20, 2970000),
(82, 24, 2, 20, 6138000),
(83, 25, 2, 20, 4200300),
(84, 26, 2, 20, 6110100),
(85, 27, 2, 20, 2700000),
(90, 1, 1, 20, 3780000),
(91, 2, 1, 20, 4950000),
(92, 3, 1, 20, 5103000),
(93, 4, 1, 20, 8587620),
(94, 5, 1, 20, 4743810),
(95, 6, 1, 20, 4950000),
(96, 7, 1, 20, 3756960),
(97, 8, 1, 20, 4926330),
(98, 9, 1, 20, 3123000),
(99, 10, 1, 20, 3735000),
(100, 11, 1, 20, 3419100),
(101, 12, 1, 20, 8587620),
(102, 13, 1, 20, 8587620),
(103, 14, 1, 20, 2907000),
(104, 15, 1, 20, 4049100),
(105, 16, 1, 20, 2034000),
(106, 17, 1, 20, 3825000),
(107, 18, 1, 20, 6012000),
(108, 19, 1, 20, 3780000),
(109, 20, 1, 20, 4995000),
(110, 21, 1, 20, 7999200),
(111, 22, 1, 20, 8999999),
(112, 23, 1, 20, 2970000),
(113, 24, 1, 20, 6138000),
(114, 25, 1, 20, 4200300),
(115, 26, 1, 20, 6110100),
(116, 27, 1, 20, 2700000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
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
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1151;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `volume`
--
ALTER TABLE `volume`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `volume_product`
--
ALTER TABLE `volume_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`volume_product_id`) REFERENCES `volume_product` (`id`);

--
-- Constraints for table `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `district_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`volume_product_id`) REFERENCES `volume_product` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`);

--
-- Constraints for table `volume_product`
--
ALTER TABLE `volume_product`
  ADD CONSTRAINT `volume_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `volume_product_ibfk_2` FOREIGN KEY (`volume_id`) REFERENCES `volume` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
