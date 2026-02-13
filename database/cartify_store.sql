-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 05:05 AM
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
-- Database: `cartify_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Electronics'),
(2, 'Fashion'),
(3, 'Home & Kitchen'),
(4, 'Beauty & Personal Care'),
(5, 'Books'),
(6, 'Sports & Fitness');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `payment_method` enum('cashon') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `user_id`, `total_amount`, `payment_method`, `created_at`, `status`) VALUES
(22, 23, 2, 249, '', '2026-01-05 03:18:11', 'Processing'),
(23, 24, 2, 799, '', '2026-01-05 03:18:18', 'Processing'),
(24, 25, 2, 89999, '', '2026-01-05 03:18:22', 'Processing'),
(25, 26, 2, 999, '', '2026-01-05 03:15:08', 'Pending'),
(26, 27, 2, 1999, '', '2026-01-05 03:15:08', 'Pending'),
(27, 28, 2, 5999, '', '2026-01-05 03:17:25', 'Pending'),
(28, 29, 8, 699, '', '2026-01-05 06:57:04', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `category_id`, `subcategory_id`, `category_name`, `created_at`) VALUES
(116, 'Samsung Galaxy S23', 'Flagship Android smartphone', 74999.00, 20, 'mobile1.jpg', 1, 1, 'Electronics', '2025-12-13 13:59:19'),
(117, 'iPhone 14', 'Apple iOS smartphone', 69999.00, 14, 'mobile2.jpg', 1, 1, 'Electronics', '2026-01-05 03:11:16'),
(118, 'OnePlus Nord CE', 'Mid-range performance phone', 24999.00, 30, 'mobile3.jpg', 1, 1, 'Electronics', '2025-12-13 13:59:19'),
(119, 'Redmi Note 12', 'Affordable smartphone', 15999.00, 35, 'mobile4.jpg', 1, 1, 'Electronics', '2026-01-05 03:08:35'),
(120, 'Realme Narzo', 'Gaming budget phone', 13999.00, 35, 'mobile5.jpg', 1, 1, 'Electronics', '2025-12-13 13:59:19'),
(121, 'Vivo V25', 'Camera focused phone', 27999.00, 18, 'mobile6.jpg', 1, 1, 'Electronics', '2025-12-13 13:59:19'),
(126, 'HP Pavilion', 'Everyday laptop', 58999.00, 10, 'laptop1.jpg', 1, 2, 'Electronics', '2025-12-13 13:59:19'),
(127, 'Dell Inspiron', 'Business laptop', 62999.00, 12, 'laptop2.jpg', 1, 2, 'Electronics', '2025-12-13 13:59:19'),
(128, 'Lenovo IdeaPad', 'Student laptop', 45999.00, 15, 'laptop3.jpg', 1, 2, 'Electronics', '2025-12-13 13:59:19'),
(129, 'Asus VivoBook', 'Lightweight laptop', 49999.00, 18, 'laptop4.jpg', 1, 2, 'Electronics', '2025-12-13 13:59:19'),
(130, 'MacBook Air M1', 'Apple laptop', 89999.00, 6, 'laptop5.jpg', 1, 2, 'Electronics', '2026-01-05 03:15:08'),
(136, 'Men T-Shirt', 'Cotton round neck', 799.00, 100, 'men1.jpg', 2, 6, 'Fashion', '2025-12-13 13:59:19'),
(137, 'Formal Shirt', 'Office wear shirt', 1299.00, 80, 'men2.jpg', 2, 6, 'Fashion', '2025-12-13 13:59:19'),
(138, 'Casual Shirt', 'Daily wear', 999.00, 90, 'men3.jpg', 2, 6, 'Fashion', '2025-12-13 13:59:19'),
(139, 'Jeans', 'Slim fit jeans', 1599.00, 70, 'men4.jpg', 2, 6, 'Fashion', '2025-12-13 13:59:19'),
(140, 'Track Pants', 'Comfort wear', 1199.00, 60, 'men5.jpg', 2, 6, 'Fashion', '2025-12-13 13:59:19'),
(146, 'Mixer Grinder', '500W mixer', 2499.00, 30, 'kitchen1.jpg', 3, 12, 'Home & Kitchen', '2025-12-13 13:59:19'),
(147, 'Electric Kettle', 'Fast boiling kettle', 1499.00, 34, 'kitchen2.jpg', 3, 12, 'Home & Kitchen', '2026-01-05 03:11:17'),
(148, 'Microwave Oven', '20L oven', 6999.00, 10, 'kitchen3.jpg', 3, 12, 'Home & Kitchen', '2025-12-13 13:59:19'),
(149, 'Toaster', '2-slice toaster', 1999.00, 25, 'kitchen4.jpg', 3, 12, 'Home & Kitchen', '2025-12-13 13:59:19'),
(150, 'Induction Cooktop', 'Energy efficient', 3499.00, 18, 'kitchen5.jpg', 3, 12, 'Home & Kitchen', '2025-12-13 13:59:19'),
(156, 'Yoga Mat', 'Anti slip mat', 999.00, 49, 'fitness1.jpg', 6, 24, 'Sports & Fitness', '2026-01-05 03:15:08'),
(157, 'Dumbbells', '5kg dumbbells', 1999.00, 40, 'fitness2.jpg', 6, 24, 'Sports & Fitness', '2025-12-13 13:59:19'),
(158, 'Resistance Bands', 'Workout bands', 699.00, 60, 'fitness3.jpg', 6, 24, 'Sports & Fitness', '2025-12-13 13:59:19'),
(159, 'Skipping Rope', 'Speed rope', 399.00, 79, 'fitness4.jpg', 6, 24, 'Sports & Fitness', '2025-12-14 06:56:35'),
(160, 'Foam Roller', 'Muscle recovery', 899.00, 30, 'fitness5.jpg', 6, 24, 'Sports & Fitness', '2025-12-13 13:59:19'),
(166, 'Face Wash for Oily Skin', 'Gentle face wash for oily skin\r\nBeauty & Personal Care', 249.00, 24, 'facewash.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-05 03:15:08'),
(167, 'Aloe Vera Gel', 'Natural aloe vera gel for skin and hair', 199.00, 35, 'aloevera.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:42:20'),
(168, 'Vitamin C Face Serum', 'Brightening vitamin C serum', 499.00, 56, 'vitamincserum.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:46:35'),
(169, 'Herbal Shampoo', 'Herbal shampoo for smooth hair', 349.00, 54, 'herbalshampoo.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:47:22'),
(170, 'Anti-Dandruff Shampoo', 'Removes dandruff effectively', 349.00, 50, 'antidandruff.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:48:06'),
(171, 'Hair Conditioner', 'Smooth and shine conditioner', 299.00, 50, 'conditioner.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:48:57'),
(172, 'Body Lotion', 'Moisturizing body lotion', 299.00, 50, 'bodylotion.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:49:36'),
(173, 'Sunscreen SPF 50', 'High protection sunscreen', 499.00, 50, 'sunscreen.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:50:08'),
(174, 'Charcoal Face Mask', '\'Deep cleansing charcoal mask\'', 399.00, 50, 'charcoalmask.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:52:21'),
(175, 'Kajal', 'Long-lasting kajal', 199.00, 50, 'kajal.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:52:59'),
(176, 'Compact Powder', 'Matte compact powder', 249.00, 50, 'compact.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:53:38'),
(177, 'Perfume for Men', 'Long-lasting fragrance', 799.00, 48, 'menperfume.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-05 03:15:08'),
(178, 'Perfume for Women', 'Refreshing fragrance', 799.00, 50, 'womenperfume.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:55:15'),
(179, 'Beard Oil', 'Promotes beard growth', 299.00, 50, 'beardoil.jpg', NULL, NULL, 'Beauty & Personal Care', '2026-01-04 15:55:49'),
(180, 'Non Stick Pan', 'Non-stick frying pan', 999.00, 50, 'pan.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:01:26'),
(181, 'Pressure Cooker', 'Aluminium Cooker', 1999.00, 50, 'cooker.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:02:01'),
(182, 'Electric Kettle', 'Fast-Boiling Kettle', 1299.00, 50, 'kettle.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:02:45'),
(183, 'Mixer Grinder', 'Kitchen Mixer', 3499.00, 50, 'grinder.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:03:26'),
(184, 'Gas Stove', '2 burner gas stove', 2999.00, 50, 'stove.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:03:58'),
(185, 'Cookware Set', 'Complete cookware set', 2499.00, 50, 'cookware.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:04:37'),
(186, 'Steel water bottle', 'Eco-Friendly bottle', 499.00, 50, 'bottle.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:05:15'),
(187, 'Lunch Box', 'Leak proof lunch box', 699.00, 50, 'box.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:06:15'),
(188, 'Storage Containers', 'Kitcher Container', 999.00, 50, 'container.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:06:54'),
(189, 'Chopping Board', 'Wooden board', 399.00, 50, 'chboard.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:07:45'),
(190, 'Knife set', 'Sharp knife set', 899.00, 50, 'knife.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:08:22'),
(191, 'Hand Blender', 'Hand Blender', 899.00, 50, 'blender.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:08:49'),
(192, 'Coffee Mug', 'Ceramic mugs', 599.00, 50, 'coffee.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:09:23'),
(193, 'Double Bedsheet', 'Cotton Bedsheet', 1499.00, 50, 'bedsheet.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:10:05'),
(194, 'Pillow set', 'Soft pillows', 999.00, 50, 'pillow.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:10:37'),
(195, 'Table Lamp', 'Decorative lamp', 899.00, 50, 'lamp.jpg', NULL, NULL, 'Home & Kitchen', '2026-01-04 16:11:06'),
(196, 'Atomic Habits', 'Build good habits easily', 399.00, 50, 'atomic.jpg', NULL, NULL, 'Books', '2026-01-04 16:20:30'),
(197, 'Rcih Dad Poor Dad', 'Personal finance bestseller', 349.00, 50, 'richdad.jpg', NULL, NULL, 'Books', '2026-01-04 16:20:58'),
(198, 'Think and Grow Rich', 'Success mindset book', 299.00, 50, 'think.jpg', NULL, NULL, 'Books', '2026-01-04 16:21:26'),
(199, 'The Alchemist', 'Inspirational novel', 299.00, 50, 'The Alchemist.jpg', NULL, NULL, 'Books', '2026-01-04 16:21:53'),
(200, 'Subconscious Mind', 'Power of subconscious mind', 299.00, 49, 'Subconscious Mind.webp', NULL, NULL, 'Books', '2026-01-05 03:11:16'),
(201, 'Deep Work', 'Focus and productivity', 399.00, 60, 'Deep Work.webp', NULL, NULL, 'Books', '2026-01-04 16:22:47'),
(202, 'Ikigai', 'Purpose of life', 349.00, 50, 'Ikigai.jpg', NULL, NULL, 'Books', '2026-01-04 16:23:15'),
(203, 'Do Epic Shit', 'Motivational book', 299.00, 50, 'Do Epic Shit.webp', NULL, NULL, 'Books', '2026-01-04 16:23:51'),
(204, 'Python for Beginners', 'Learn Python easily', 499.00, 50, 'Python for Beginners.webp', NULL, NULL, 'Books', '2026-01-04 16:24:18'),
(205, 'Let Us C', 'C programming bible', 499.00, 50, 'Let Us C.webp', NULL, NULL, 'Books', '2026-01-04 16:24:52'),
(206, 'Data Structures in C', 'Data structures concepts', 499.00, 50, 'Data Structures in C.webp', NULL, NULL, 'Books', '2026-01-04 16:25:17'),
(207, 'OOP with Java', 'Object oriented programming', 549.00, 50, 'OOP with Java.webp', NULL, NULL, 'Books', '2026-01-04 16:25:43'),
(208, 'DBMS', '\'Database management systems\'', 499.00, 50, 'dbms.webp', NULL, NULL, 'Books', '2026-01-04 16:26:09'),
(209, 'Operating System', 'Operating system concepts', 549.00, 50, 'Operating System.webp', NULL, NULL, 'Books', '2026-01-04 16:27:00'),
(210, 'Computer Networks', 'Networking fundamentals', 599.00, 50, 'Computer Networks.webp', NULL, NULL, 'Books', '2026-01-04 16:27:26'),
(211, 'Clean Code', 'Writing clean code', 649.00, 40, 'Clean Code.webp', NULL, NULL, 'Books', '2026-01-04 16:27:54'),
(212, 'You Can Win', 'Motivational book', 299.00, 50, 'You Can Win.jpg', NULL, NULL, 'Books', '2026-01-04 16:28:28'),
(213, 'Psychology of Money', 'Money mindset', 399.00, 49, 'Psychology of Money.webp', NULL, NULL, 'Books', '2026-01-05 03:11:16'),
(214, 'Men Casual Shirt', 'Cotton casual shirt', 599.00, 20, 'cshirt.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:30:42'),
(215, 'Men Formal Shirt\'', 'Formal wear shirt', 899.00, 20, 'fshirt.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:31:12'),
(216, 'Women Kurti', 'Stylish kurti', 799.00, 20, 'kurti.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:32:31'),
(217, 'Women Top', 'Trendy top', 699.00, 20, 'top.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:32:57'),
(218, ' Men Jeans ', 'Slim fit jeans', 566.00, 20, 'jeans.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:35:25'),
(219, 'Track Pants', 'Comfortable track pants', 2999.00, 23, 'trackpants.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:36:21'),
(220, 'Hoodie', 'Winter hoodie', 599.00, 24, 'hoodie.webp', NULL, NULL, 'Fashion', '2026-01-04 16:37:13'),
(222, 'Formal Trousers', 'Office wear', 1299.00, 25, 'trouser.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:38:17'),
(223, 'Casual Shorts', 'Summer shorts', 699.00, 66, 'shorts.jpg', NULL, NULL, 'Fashion', '2026-01-05 06:57:04'),
(224, 'Cotton Saree', 'Traditional saree', 1099.00, 23, 'saree.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:39:15'),
(225, 'Air Jordan', 'Running shoes', 5999.00, 44, 'jordan.jpg', NULL, NULL, 'Fashion', '2026-01-05 03:17:25'),
(226, 'Sneakers', 'Casual sneakers', 1999.00, 23, 'sneakers.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:40:21'),
(227, 'Flip Flops', 'Comfort slippers', 499.00, 24, 'flipflop.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:40:48'),
(228, 'Sunglasses', 'UV protected', 999.00, 45, 'glasses.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:41:11'),
(229, 'Leather Belt', 'Genuine leather belt', 699.00, 34, 'belt.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:41:43'),
(230, 'Men Wallet', 'Leather wallet', 799.00, 45, 'wallet.jpg', NULL, NULL, 'Fashion', '2026-01-04 16:42:09'),
(231, 'Bluetooth Earbuds', 'Wireless earbuds', 1499.00, 25, 'earbuds.jpeg', NULL, NULL, 'Electronics', '2026-01-05 02:58:59'),
(232, 'Bluetooth Speaker', 'Portable speaker', 1999.00, 25, 'speaker.jpeg', NULL, NULL, 'Electronics', '2026-01-05 02:59:35'),
(233, 'Power Bank 10000mAh', 'Fast charging power bank', 1299.00, 25, 'onics.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:00:31'),
(234, 'Laptop Backpack', 'Stylish laptop bag', 1399.00, 25, 'laptop bag.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:01:10'),
(235, 'Fast Charger', 'Quick charger', 699.00, 25, 'charger.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:01:41'),
(236, '\'Wireless Mouse', 'Ergonomic wireless mouse', 599.00, 25, 'mouse.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:02:18'),
(237, 'Mechanical Keyboard', 'Gaming keyboard', 2499.00, 25, 'keyboard.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:02:52'),
(238, 'Cooling Pad', 'Laptop cooling pad', 999.00, 25, 'cooling pad.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:03:25'),
(239, 'LED Desk Lamp', 'Study lamp', 799.00, 25, 'table lamp.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:04:00'),
(240, 'External Hard Disk 1TB', 'Portable storage', 3999.00, 25, 'hdd.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:04:28'),
(241, 'Pendrive 64GB', 'USB flash drive', 699.00, 25, 'pendrive.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:04:57'),
(242, 'Mobile Stand', 'Phone holder', 299.00, 25, 'mobilestand.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:05:24'),
(243, 'Headphones', 'Noise cancelling', 1999.00, 24, 'headphone.jpeg', NULL, NULL, 'Electronics', '2026-01-05 03:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `single_order`
--

CREATE TABLE `single_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `single_order`
--

INSERT INTO `single_order` (`id`, `user_id`, `product_id`, `total_amount`, `quantity`) VALUES
(18, 2, 177, 799.00, 1),
(19, 2, 213, 399.00, 1),
(20, 2, 200, 299.00, 1),
(21, 2, 117, 69999.00, 1),
(22, 2, 147, 1499.00, 1),
(23, 2, 166, 249.00, 1),
(24, 2, 177, 799.00, 1),
(25, 2, 130, 89999.00, 1),
(26, 2, 156, 999.00, 1),
(27, 2, 243, 1999.00, 1),
(28, 2, 225, 5999.00, 1),
(29, 8, 223, 699.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`) VALUES
(1, 1, 'Mobiles'),
(2, 1, 'Laptops'),
(3, 1, 'Headphones'),
(4, 1, 'Smart Watches'),
(5, 1, 'Accessories'),
(6, 2, 'Men Clothing'),
(7, 2, 'Women Clothing'),
(8, 2, 'Footwear'),
(9, 2, 'Watches'),
(10, 2, 'Bags'),
(11, 3, 'Furniture'),
(12, 3, 'Kitchen Appliances'),
(13, 3, 'Home Decor'),
(14, 3, 'Lighting'),
(15, 4, 'Skin Care'),
(16, 4, 'Hair Care'),
(17, 4, 'Makeup'),
(18, 4, 'Fragrances'),
(19, 5, 'Academic'),
(20, 5, 'Fiction'),
(21, 5, 'Non-Fiction'),
(22, 5, 'Competitive Exams'),
(23, 6, 'Gym Equipment'),
(24, 6, 'Sports Wear'),
(25, 6, 'Outdoor Sports'),
(26, 6, 'Yoga & Fitness Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_img` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `role`, `created_at`, `profile_img`) VALUES
(1, 'MOHD SARIM KHAN', 'khansarim2211@gmail.com', 'sarimkhan6440', '08765806440', 'S-4/32 A, Ulfat Compound, Orderly Bazar, Varanasi', 'user', '2025-12-11 17:48:24', 'default.png'),
(2, 'sarim', 'sarim2255@gmail.com', 'sarimkhan6440', '8765806440', 'orderly bazar, varanasi', 'user', '2025-12-11 17:48:24', 'default.png'),
(4, 'fuzail', 'fz01@gmail.com', 'fuzail', '0987654433', 'naisarak', 'user', '2025-12-11 17:48:24', 'default.png'),
(5, 'fuzail', 'fz01@gmail.com', 'fuzail', '0987654433', 'naisarak', 'user', '2025-12-11 17:48:24', 'default.png'),
(6, 'fuzail', 'fz01@gmail.com', 'fuzail', '0987654433', 'naisarak', 'user', '2025-12-11 17:48:24', 'default.png'),
(8, 'admin', 'admin@gmail.com', '12345', '12345678', 'admin panel', 'admin', '2025-12-11 17:48:24', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 2, 213, '2026-01-05 03:15:23'),
(2, 2, 243, '2026-01-05 03:15:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_category` (`category_id`),
  ADD KEY `fk_products_subcategory` (`subcategory_id`);

--
-- Indexes for table `single_order`
--
ALTER TABLE `single_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `single_order`
--
ALTER TABLE `single_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_products_subcategory` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
