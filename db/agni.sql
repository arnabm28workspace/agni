-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 16, 2022 at 02:22 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agni`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '2' COMMENT '1:Admin 2:Others',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT 1 COMMENT '1:Active 0:Inactive',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `type`, `email`, `mobile`, `email_verified_at`, `status`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Abhinav Gupta', '1', 'fortunetools570@yandex.com', '9674030434', NULL, 1, '$2y$10$fdGD3yrhs/u/BCXDl22HgOT/kJM2KVE1sEN.mD5.6BA9sXV2KAYiC', NULL, '2022-11-15 08:37:09', '2022-09-15 11:48:41'),
(8, 'Mayank Gupta', '1', 'trgtoolspvtltd@gmail.com', '9674905534', NULL, 1, '$2y$10$vSi.yb4LdI72wLgtIQsf5uM99Jwebf7OPw48j97wAohTjz7otYyQa', NULL, '2022-07-19 06:28:03', '2022-07-19 06:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(11) NOT NULL,
  `website_name` varchar(255) DEFAULT NULL,
  `website_link` varchar(255) DEFAULT NULL,
  `po_order_address` text DEFAULT NULL,
  `po_order_city` varchar(255) DEFAULT NULL,
  `po_order_state` varchar(255) DEFAULT NULL,
  `po_order_country` varchar(255) DEFAULT NULL,
  `po_order_pin` varchar(255) DEFAULT NULL,
  `staff_payment_incentive` varchar(255) DEFAULT NULL COMMENT 'percentage val',
  `order_collector_commission` varchar(255) DEFAULT NULL COMMENT 'percentage val;',
  `payment_collector_commission` varchar(255) DEFAULT NULL COMMENT 'percentage val;',
  `product_sales_price_threshold_percentage` varchar(255) NOT NULL DEFAULT '10',
  `investment_percentage` varchar(255) NOT NULL DEFAULT '70' COMMENT 'pnl',
  `withdraw_percentage` varchar(255) NOT NULL DEFAULT '30' COMMENT 'pnl',
  `google_api_key` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `website_name`, `website_link`, `po_order_address`, `po_order_city`, `po_order_state`, `po_order_country`, `po_order_pin`, `staff_payment_incentive`, `order_collector_commission`, `payment_collector_commission`, `product_sales_price_threshold_percentage`, `investment_percentage`, `withdraw_percentage`, `google_api_key`, `created_at`, `updated_at`) VALUES
(1, 'Agni Inventory', 'https://agni-inventory.demo91.co.in/', '2 B, Rani Sankari Ln, Jatin Das Park, Patuapara, Bhowanipore, Kolkata, West Bengal 700025', 'Kolkata', 'West Bengal', 'India', '700025', '0.2', '30', '70', '10', '70', '30', 'AIzaSyAkwlSsaYwOB0T79ZgKI7_vgQNbRxzD1xc', '2022-07-05 10:13:58', '2022-10-11 12:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_locations`
--

CREATE TABLE `attendance_locations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `attendance_id` int(11) NOT NULL DEFAULT 0,
  `latitude` varchar(150) DEFAULT NULL,
  `longitude` varchar(150) DEFAULT NULL,
  `distance_value` varchar(250) DEFAULT NULL,
  `distance` varchar(250) NOT NULL,
  `entry_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance_locations`
--

INSERT INTO `attendance_locations` (`id`, `user_id`, `attendance_id`, `latitude`, `longitude`, `distance_value`, `distance`, `entry_date`, `created_at`, `updated_at`) VALUES
(1, 6, 1, '22.570943', '88.432554', NULL, '0', '2022-12-12', '2022-12-16 12:20:37', '2022-12-16 12:20:37'),
(2, 6, 1, '22.5706829', '88.4327069', '18', '18m', '2022-12-12', '2022-12-16 12:20:37', '2022-12-16 12:20:37'),
(3, 6, 1, '22.5706978', '88.4333667', '150', '0.2 km', '2022-12-12', '2022-12-12 18:01:37', '2022-12-12 18:01:37'),
(4, 6, 1, '22.5707034', '88.4351396', '202', '0.2 km', '2022-12-12', '2022-12-12 18:02:28', '2022-12-12 18:02:28'),
(5, 6, 1, '22.5709504', '88.4353334', '39', '39 m', '2022-12-12', '2022-12-12 18:02:59', '2022-12-12 18:02:59'),
(6, 6, 1, '22.5712836', '88.4355071', '41', '41 m', '2022-12-12', '2022-12-12 18:03:28', '2022-12-12 18:03:28'),
(7, 6, 1, '22.5715764', '88.435611', '34', '34 m', '2022-12-12', '2022-12-12 18:03:50', '2022-12-12 18:03:50'),
(8, 6, 1, '22.5715764', '88.435611', '0', '1 m', '2022-12-12', '2022-12-12 18:06:03', '2022-12-12 18:06:03');

-- --------------------------------------------------------

--
-- Table structure for table `bank_lists`
--

CREATE TABLE `bank_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Public-sector banks, Private-sector banks',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_lists`
--

INSERT INTO `bank_lists` (`id`, `name`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Bank of Baroda', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(2, 'Vijaya Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(3, 'Dena Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(4, 'Bank of India', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(5, 'Bank of Maharashtra', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(6, 'Canara Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(7, 'Syndicate Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(8, 'Central Bank of India', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(9, 'Indian Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(10, 'Allahabad Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(11, 'Indian Overseas Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(12, 'Punjab and Sind Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(13, 'Punjab National Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(14, 'Oriental Bank of Commerce', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(15, 'United Bank of India', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(16, 'State Bank of India', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(17, 'State Bank of Bikaner & Jaipur', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(18, 'State Bank of Hyderabad', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(19, 'State Bank of Indore', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(20, 'State Bank of Mysore', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(21, 'State Bank of Patiala', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(22, 'State Bank of Saurashtra', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(23, 'State Bank of Travancore', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(24, 'Bhartiya Mahila Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(25, 'UCO Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(26, 'Union Bank of India', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(27, 'Andhra Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(28, 'Corporation Bank', 'Public-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(29, 'Axis Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(30, 'Bandhan Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(31, 'CSB Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(32, 'City Union Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(33, 'DCB Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(34, 'Dhanlaxmi Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(35, 'Federal Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(36, 'HDFC Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(37, 'ICICI Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(38, 'IDBI Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(39, 'IDFC First Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(40, 'IndusInd Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(41, 'Jammu & Kashmir Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(42, 'Karnataka Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(43, 'Karur Vysya Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(44, 'Kotak Mahindra Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(45, 'Nainital Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(46, 'RBL Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(47, 'South Indian Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(48, 'Tamilnad Mercantile Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(49, 'Yes Bank', 'Private-sector banks', NULL, '2022-02-18 05:08:57', '2022-07-07 09:57:26'),
(78, ' - OTHERS -', 'others', NULL, '2022-07-07 11:02:11', '2022-07-07 11:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `store_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` bigint(20) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(10,2) NOT NULL DEFAULT 0.00,
  `piece_price` double(10,2) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1 COMMENT 'no of cartons',
  `pcs` int(11) NOT NULL DEFAULT 0 COMMENT 'total pieces',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sketch_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `position`, `name`, `parent`, `icon_path`, `sketch_icon`, `image_path`, `banner_image`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'Test Category', NULL, 'uploads/category/1659340400.1616406864.agnilogo.jpg', NULL, NULL, NULL, 'test-category-2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, '2022-05-24 04:24:52', '2022-08-11 06:32:55'),
(2, 0, 'Electronics', NULL, 'uploads/category/1659340600.1582150836.electronics.jpg', NULL, NULL, NULL, 'electronics-2', NULL, 1, '2022-07-05 02:22:40', '2022-08-01 07:56:40'),
(3, 0, 'Groceries', NULL, 'uploads/category/1659340611.1190154300.grocery.jpg', NULL, NULL, NULL, 'groceries', 'Groceries', 1, '2022-07-07 00:03:18', '2022-08-11 06:32:44'),
(4, 0, 'Accessories', NULL, 'uploads/category/1659340621.1265644165.accessories.jpeg', NULL, NULL, NULL, 'accessories-2', 'Accessories', 1, '2022-07-07 00:03:46', '2022-08-11 06:32:41'),
(5, 0, 'Test 2', NULL, NULL, NULL, NULL, NULL, 'test-2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, '2022-08-11 05:20:53', '2022-08-11 06:32:55');

-- --------------------------------------------------------

--
-- Table structure for table `category_parents`
--

CREATE TABLE `category_parents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_parents`
--

INSERT INTO `category_parents` (`id`, `name`, `slug`, `position`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Innerwear', 'innerwear', 1, 1, '2022-05-04 12:29:09', '2022-05-30 13:49:44'),
(2, 'Outerwear', 'outerwear', 2, 1, '2022-05-04 12:29:09', '2022-05-30 13:49:44'),
(3, 'Winter wear', 'winter-wear', 3, 1, '2022-05-04 12:29:09', '2022-05-30 13:49:44'),
(4, 'Footkins', 'footkins', 4, 1, '2022-05-04 12:29:09', '2022-05-30 13:49:44');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Salesman', 1, '2022-08-11 19:52:31', '2022-08-11 19:52:31'),
(2, 'Depot Accountant', 1, '2022-08-11 19:52:31', '2022-11-16 15:29:03'),
(3, 'Head Accountant', 1, '2022-08-11 19:52:31', '2022-11-21 10:19:34'),
(5, 'Godown Manager', 1, '2022-08-11 19:52:31', '2022-08-11 19:52:31'),
(11, 'Test One', 0, '2022-12-06 16:34:56', '2022-12-06 16:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `for_debit` tinyint(1) NOT NULL DEFAULT 0,
  `for_credit` tinyint(1) NOT NULL DEFAULT 0,
  `for_staff` tinyint(1) NOT NULL DEFAULT 0,
  `for_store` tinyint(1) NOT NULL DEFAULT 0,
  `for_partner` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `parent_id`, `title`, `slug`, `description`, `for_debit`, `for_credit`, `for_staff`, `for_store`, `for_partner`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'Recurring', 'recurring', 'Recurring', 0, 0, 0, 0, 0, 1, '2022-07-01 10:33:19', '2022-07-01 10:33:19'),
(2, 0, 'Non-recurring', 'non-recurring', 'Non-recurring', 0, 0, 0, 0, 0, 1, '2022-07-01 10:33:19', '2022-07-01 10:33:19'),
(4, 1, 'Salary', 'salary', 'Salary', 1, 0, 1, 0, 0, 0, '2022-07-01 10:33:19', '2022-11-16 13:46:44'),
(5, 1, 'Internet', 'internet', 'Internet', 1, 0, 0, 1, 0, 0, '2022-07-01 10:33:19', '2022-11-16 13:46:44'),
(6, 2, 'Incentive', 'incentive', 'Incentive', 1, 0, 1, 0, 0, 1, '2022-07-01 10:35:28', '2022-07-27 15:32:26'),
(7, 2, 'Electricity', 'electricity', 'Electricity', 1, 0, 0, 1, 0, 1, '2022-07-01 10:35:28', '2022-07-04 13:16:19'),
(8, 2, 'Water', 'water', 'Water', 1, 0, 0, 1, 0, 1, '2022-07-01 10:35:28', '2022-07-04 13:16:33'),
(9, 2, 'Allowance', 'allowance', 'Allowance', 1, 0, 1, 0, 0, 1, '2022-07-01 10:35:28', '2022-07-04 13:16:42'),
(20, 2, 'Business Capital', 'business-capital', 'Business Capital as Business Partners', 1, 0, 0, 0, 1, 1, '2022-07-18 15:20:02', '2022-08-11 14:23:32'),
(21, 2, 'Business Investment', 'business-investment', 'Business Investment as business partner', 0, 1, 0, 0, 1, 1, '2022-07-18 18:50:02', '2022-07-18 18:50:02'),
(25, 2, 'Monthly Payment', 'monthly-payment', 'Salary + Allowance + Commission', 1, 0, 1, 0, 0, 1, '2022-08-26 15:48:00', '2022-08-26 15:48:00'),
(26, 2, 'Partner Withdrawl', 'partner-withdrawl', 'Partner Withdrawl', 1, 0, 0, 0, 1, 1, '2022-09-20 13:13:54', '2022-09-20 13:13:54'),
(27, 2, 'Others', 'others', 'Others', 1, 0, 0, 0, 1, 1, '2022-11-04 13:53:08', '2022-11-04 13:53:08'),
(28, 2, 'Supplier Payment', 'supplier-payment', 'Supplier Payment', 1, 0, 0, 0, 1, 1, '2022-11-04 18:04:13', '2022-11-04 18:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `net_price` double(10,2) NOT NULL COMMENT 'total with gst',
  `order_id` int(11) NOT NULL DEFAULT 0,
  `order_no` varchar(255) DEFAULT NULL,
  `slip_no` varchar(255) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL COMMENT 'store personal info',
  `store_whatsapp` varchar(255) DEFAULT NULL COMMENT 'store personal info',
  `store_contact` varchar(255) DEFAULT NULL COMMENT 'store personal info',
  `store_billing_address` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_billing_latitude` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_billing_longitude` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_billing_landmark` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_billing_state` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_billing_city` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_billing_pin` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_shipping_address` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_shipping_longitude` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_shipping_latitude` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_shipping_landmark` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_shipping_state` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_shipping_city` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_shipping_pin` varchar(255) DEFAULT NULL COMMENT 'store address info',
  `store_address_outstation` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'store address info',
  `user_id` int(11) DEFAULT NULL COMMENT 'order placed by whom or staff_id',
  `product_id_arr` text DEFAULT NULL,
  `trn_file` varchar(255) DEFAULT NULL COMMENT 'upload trn file if store has outstation address',
  `payment_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:pending;1:half_paid;2:full_paid',
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `is_gst` tinyint(1) NOT NULL DEFAULT 1,
  `required_payment_amount` double(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoice_no`, `net_price`, `order_id`, `order_no`, `slip_no`, `store_id`, `store_name`, `store_whatsapp`, `store_contact`, `store_billing_address`, `store_billing_latitude`, `store_billing_longitude`, `store_billing_landmark`, `store_billing_state`, `store_billing_city`, `store_billing_pin`, `store_shipping_address`, `store_shipping_longitude`, `store_shipping_latitude`, `store_shipping_landmark`, `store_shipping_state`, `store_shipping_city`, `store_shipping_pin`, `store_address_outstation`, `user_id`, `product_id_arr`, `trn_file`, `payment_status`, `is_paid`, `is_gst`, `required_payment_amount`, `created_at`, `updated_at`) VALUES
(1, '0000000001', 8250.00, 1, 'AGNI815477884', '20221122121207', 5, 'Mohan Agarwal', '9000343434', '9000343434', 'Dumdum', NULL, NULL, 'Station', 'West Bengal', 'Kolkata', '700110', 'Dumdum', NULL, NULL, 'Station', 'West Bengal', 'Kolkata', '700110', 0, 6, '[\"3\"]', '', 1, 0, 0, 7240.00, '2022-11-22 12:29:07', '2022-11-22 12:29:07'),
(2, '0000000002', 8250.00, 3, 'AGNI1483422099', '20221129141832', 7, 'Kamal Sharma', '7787687878', '7787687878', 'Sodepur', NULL, NULL, 'Readymade Center', 'West Bengal', 'Kolkata', '700114', 'Sodepur', NULL, NULL, 'Readymade Center', 'West Bengal', 'Kolkata', '700114', 0, 3, '[\"3\"]', '', 0, 0, 0, 8250.00, '2022-11-29 14:19:50', '2022-11-29 14:19:50'),
(3, '0000000003', 8250.00, 2, 'AGNI1690519356', '20221129142156', 7, 'Kamal Sharma', '7787687878', '7787687878', 'Sodepur', NULL, NULL, 'Readymade Center', 'West Bengal', 'Kolkata', '700114', 'Sodepur', NULL, NULL, 'Readymade Center', 'West Bengal', 'Kolkata', '700114', 0, 3, '[\"3\"]', '', 0, 0, 1, 8250.00, '2022-11-29 14:22:46', '2022-11-29 14:22:46');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments`
--

CREATE TABLE `invoice_payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `voucher_no` varchar(255) DEFAULT NULL COMMENT 'payment_receipt',
  `invoice_amount` double(10,2) NOT NULL COMMENT 'invoice''s net amount',
  `vouchar_amount` double(10,2) NOT NULL,
  `paid_amount` double(10,2) NOT NULL COMMENT 'payment amount',
  `rest_amount` double(10,2) NOT NULL,
  `is_commisionable` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'for staff',
  `commission_amount` double(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='payments (vouchar_no of payment_receipt) covers which invoices at a time';

--
-- Dumping data for table `invoice_payments`
--

INSERT INTO `invoice_payments` (`id`, `invoice_id`, `invoice_no`, `voucher_no`, `invoice_amount`, `vouchar_amount`, `paid_amount`, `rest_amount`, `is_commisionable`, `commission_amount`, `created_at`, `updated_at`) VALUES
(1, 1, '0000000001', 'PAYRECEIPT1669705947', 8250.00, 100.00, 100.00, 8150.00, 0, 0.00, '2022-11-29 12:43:21', '2022-11-29 12:43:21'),
(3, 1, '0000000001', 'PAYRECEIPT1669706363', 8250.00, 200.00, 200.00, 7950.00, 0, 0.00, '2022-11-29 12:54:15', '2022-11-29 12:54:15'),
(4, 1, '0000000001', 'PAYRECEIPT1669707125', 8250.00, 203.00, 203.00, 7747.00, 0, 0.00, '2022-11-29 13:02:48', '2022-11-29 13:02:48'),
(5, 1, '0000000001', 'PAYRECEIPT1669707321', 8250.00, 206.00, 206.00, 7541.00, 0, 0.00, '2022-11-29 13:05:48', '2022-11-29 13:05:48'),
(6, 1, '0000000001', 'PAYRECEIPT1669708417', 8250.00, 301.00, 301.00, 7240.00, 0, 0.00, '2022-11-29 13:28:48', '2022-11-29 13:28:48');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_products`
--

CREATE TABLE `invoice_products` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL COMMENT 'no of cartons',
  `pcs` int(11) NOT NULL DEFAULT 0 COMMENT 'total pieces',
  `price` double(10,2) NOT NULL COMMENT 'each ctn price',
  `count_price` double(10,2) NOT NULL,
  `total_price` double(10,2) NOT NULL COMMENT 'with gst price',
  `is_store_address_outstation` tinyint(1) NOT NULL DEFAULT 0,
  `hsn_code` varchar(255) DEFAULT NULL,
  `igst` varchar(255) DEFAULT NULL,
  `cgst` varchar(255) DEFAULT NULL,
  `sgst` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_products`
--

INSERT INTO `invoice_products` (`id`, `invoice_id`, `product_id`, `product_name`, `quantity`, `pcs`, `price`, `count_price`, `total_price`, `is_store_address_outstation`, `hsn_code`, `igst`, `cgst`, `sgst`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Agni Super Cut Off Wheel', 5, 50, 139.83, 6991.53, 8250.00, 0, '1122334473', '18', '9', '9', '2022-11-22 12:29:07', '2022-11-22 12:29:07'),
(2, 2, 3, 'Agni Super Cut Off Wheel', 5, 50, 139.83, 6991.53, 8250.00, 0, '1122334473', '18', '9', '9', '2022-11-29 14:19:50', '2022-11-29 14:19:50'),
(3, 3, 3, 'Agni Super Cut Off Wheel', 5, 50, 139.83, 6991.53, 8250.00, 0, '1122334473', '18', '9', '9', '2022-11-29 14:22:46', '2022-11-29 14:22:46');

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE `journal` (
  `id` int(11) NOT NULL,
  `transaction_amount` double(10,2) NOT NULL,
  `is_credit` tinyint(1) NOT NULL DEFAULT 0,
  `is_debit` tinyint(1) NOT NULL DEFAULT 0,
  `bank_cash` varchar(255) NOT NULL DEFAULT 'bank',
  `purpose` varchar(255) DEFAULT NULL,
  `purpose_description` text DEFAULT NULL,
  `purpose_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'invoice_no / vouchar_no',
  `payment_id` int(11) NOT NULL DEFAULT 0,
  `entry_date` date DEFAULT NULL,
  `is_gst` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='revenue / profit n loss';

--
-- Dumping data for table `journal`
--

INSERT INTO `journal` (`id`, `transaction_amount`, `is_credit`, `is_debit`, `bank_cash`, `purpose`, `purpose_description`, `purpose_id`, `payment_id`, `entry_date`, `is_gst`, `created_at`, `updated_at`) VALUES
(1, 100.00, 1, 0, 'bank', 'payment_receipt', 'store payment receipt from sales invoice', 'PAYRECEIPT1669705947', 1, '2022-11-29', 1, '2022-11-29 12:43:21', '2022-11-29 12:43:21'),
(3, 200.00, 1, 0, 'bank', 'payment_receipt', 'store payment receipt from sales invoice', 'PAYRECEIPT1669706363', 3, '2022-11-29', 1, '2022-11-29 12:54:15', '2022-11-29 12:54:15'),
(4, 203.00, 1, 0, 'bank', 'payment_receipt', 'store payment receipt from sales invoice', 'PAYRECEIPT1669707125', 4, '2022-11-29', 1, '2022-11-29 13:02:48', '2022-11-29 13:02:48'),
(5, 206.00, 1, 0, 'bank', 'payment_receipt', 'store payment receipt from sales invoice', 'PAYRECEIPT1669707321', 5, '2022-11-29', 1, '2022-11-29 13:05:48', '2022-11-29 13:05:48'),
(6, 301.00, 1, 0, 'cash', 'payment_receipt', 'store payment receipt from sales invoice', 'PAYRECEIPT1669708417', 6, '2022-11-29', 1, '2022-11-29 13:28:48', '2022-11-29 13:28:48'),
(7, 1000.00, 0, 1, 'cash', 'expense', 'expense for staff. Incentive', 'EXPENSE1669710497', 7, '2022-11-10', 1, '2022-11-29 14:00:01', '2022-11-29 14:00:01'),
(8, 1500.00, 0, 1, 'cash', 'expense', 'expense for staff. Incentive', 'EXPENSE1669710602', 8, '2022-11-20', 1, '2022-11-29 14:01:34', '2022-11-29 14:01:34'),
(9, 30000.00, 0, 1, 'bank', 'expense', 'expense for staff. Monthly Payment', 'EXPENSE1669710694', 9, '2022-11-29', 1, '2022-11-29 14:03:18', '2022-11-29 14:03:18'),
(10, 15000.00, 0, 1, 'bank', 'expense', 'expense for supplier. Supplier Payment', 'EXPENSE1669710798', 10, '2022-11-29', 1, '2022-11-29 14:05:04', '2022-11-29 14:05:04');

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `id` int(11) NOT NULL,
  `user_type` enum('staff','store','partner','supplier') NOT NULL DEFAULT 'staff',
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `transaction_id` varchar(244) CHARACTER SET utf8 DEFAULT NULL COMMENT 'invoice_no / vouchar_no',
  `payment_id` int(11) NOT NULL DEFAULT 0,
  `bank_cash` enum('bank','cash') NOT NULL DEFAULT 'bank',
  `transaction_amount` double(10,2) NOT NULL,
  `is_credit` tinyint(1) NOT NULL DEFAULT 0,
  `is_debit` tinyint(1) NOT NULL DEFAULT 0,
  `entry_date` date DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `purpose_description` text DEFAULT NULL,
  `is_gst` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='staff ledger';

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`id`, `user_type`, `staff_id`, `store_id`, `supplier_id`, `admin_id`, `transaction_id`, `payment_id`, `bank_cash`, `transaction_amount`, `is_credit`, `is_debit`, `entry_date`, `purpose`, `purpose_description`, `is_gst`, `created_at`, `updated_at`) VALUES
(1, 'supplier', 0, 0, 1, 0, 'SHZECY9DKRKZKAH7', 0, 'bank', 15000.00, 1, 0, '2022-11-22', 'goods_received_note', 'Goods Received Note', 1, '2022-11-22 12:08:52', '2022-11-22 12:08:52'),
(3, 'store', 0, 5, 0, 0, '0000000001', 0, 'cash', 8250.00, 0, 1, '2022-11-22', 'invoice', 'invoice raised of sales order for store', 0, '2022-11-22 12:29:07', '2022-11-22 12:29:07'),
(4, 'store', 6, 5, 0, 0, 'PAYRECEIPT1669705947', 1, 'bank', 100.00, 1, 0, '2022-11-29', 'payment_receipt', 'store payment receipt from sales invoice', 1, '2022-11-29 12:43:21', '2022-11-29 12:43:21'),
(6, 'store', 0, 5, 0, 1, 'PAYRECEIPT1669706363', 3, 'bank', 200.00, 1, 0, '2022-11-29', 'payment_receipt', 'store payment receipt from sales invoice', 1, '2022-11-29 12:54:15', '2022-11-29 12:54:15'),
(7, 'store', 0, 5, 0, 1, 'PAYRECEIPT1669707125', 4, 'bank', 203.00, 1, 0, '2022-11-29', 'payment_receipt', 'store payment receipt from sales invoice', 1, '2022-11-29 13:02:47', '2022-11-29 13:02:47'),
(8, 'store', 0, 5, 0, 1, 'PAYRECEIPT1669707321', 5, 'bank', 206.00, 1, 0, '2022-11-29', 'payment_receipt', 'store payment receipt from sales invoice', 1, '2022-11-29 13:05:48', '2022-11-29 13:05:48'),
(9, 'store', 0, 5, 0, 1, 'PAYRECEIPT1669708417', 6, 'cash', 301.00, 1, 0, '2022-11-29', 'payment_receipt', 'store payment receipt from sales invoice', 1, '2022-11-29 13:28:48', '2022-11-29 13:28:48'),
(10, 'staff', 3, 0, 0, 0, 'SAL3202211291669710064', 0, 'bank', 500.00, 1, 0, '2022-11-01', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:51:04', '2022-11-29 13:51:04'),
(11, 'staff', 4, 0, 0, 0, 'SAL4202211291669710064', 0, 'bank', 1166.67, 1, 0, '2022-11-01', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:51:04', '2022-11-29 13:51:04'),
(12, 'staff', 5, 0, 0, 0, 'SAL5202211291669710064', 0, 'bank', 1166.67, 1, 0, '2022-11-01', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:51:04', '2022-11-29 13:51:04'),
(13, 'staff', 6, 0, 0, 0, 'SAL6202211291669710065', 0, 'bank', 833.33, 1, 0, '2022-11-01', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:51:05', '2022-11-29 13:51:05'),
(14, 'staff', 7, 0, 0, 0, 'SAL7202211291669710065', 0, 'bank', 666.67, 1, 0, '2022-11-01', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:51:05', '2022-11-29 13:51:05'),
(15, 'staff', 3, 0, 0, 0, 'SAL3202211291669710294', 0, 'bank', 500.00, 1, 0, '2022-11-02', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:54:54', '2022-11-29 13:54:54'),
(16, 'staff', 4, 0, 0, 0, 'SAL4202211291669710294', 0, 'bank', 1166.67, 1, 0, '2022-11-02', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:54:54', '2022-11-29 13:54:54'),
(17, 'staff', 5, 0, 0, 0, 'SAL5202211291669710294', 0, 'bank', 1166.67, 1, 0, '2022-11-02', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:54:54', '2022-11-29 13:54:54'),
(18, 'staff', 6, 0, 0, 0, 'SAL6202211291669710294', 0, 'bank', 833.33, 1, 0, '2022-11-02', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:54:54', '2022-11-29 13:54:54'),
(19, 'staff', 7, 0, 0, 0, 'SAL7202211291669710294', 0, 'bank', 666.67, 1, 0, '2022-11-02', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:54:54', '2022-11-29 13:54:54'),
(20, 'staff', 3, 0, 0, 0, 'SAL3202211291669710297', 0, 'bank', 500.00, 1, 0, '2022-11-03', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:54:57', '2022-11-29 13:54:57'),
(21, 'staff', 4, 0, 0, 0, 'SAL4202211291669710297', 0, 'bank', 1166.67, 1, 0, '2022-11-03', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:54:57', '2022-11-29 13:54:57'),
(22, 'staff', 5, 0, 0, 0, 'SAL5202211291669710298', 0, 'bank', 1166.67, 1, 0, '2022-11-03', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:54:58', '2022-11-29 13:54:58'),
(23, 'staff', 6, 0, 0, 0, 'SAL6202211291669710298', 0, 'bank', 833.33, 1, 0, '2022-11-03', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:54:58', '2022-11-29 13:54:58'),
(24, 'staff', 7, 0, 0, 0, 'SAL7202211291669710298', 0, 'bank', 666.67, 1, 0, '2022-11-03', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:54:58', '2022-11-29 13:54:58'),
(25, 'staff', 3, 0, 0, 0, 'SAL3202211291669710300', 0, 'bank', 500.00, 1, 0, '2022-11-04', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:00', '2022-11-29 13:55:00'),
(26, 'staff', 4, 0, 0, 0, 'SAL4202211291669710300', 0, 'bank', 1166.67, 1, 0, '2022-11-04', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:00', '2022-11-29 13:55:00'),
(27, 'staff', 5, 0, 0, 0, 'SAL5202211291669710300', 0, 'bank', 1166.67, 1, 0, '2022-11-04', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:00', '2022-11-29 13:55:00'),
(28, 'staff', 6, 0, 0, 0, 'SAL6202211291669710300', 0, 'bank', 833.33, 1, 0, '2022-11-04', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:00', '2022-11-29 13:55:00'),
(29, 'staff', 7, 0, 0, 0, 'SAL7202211291669710300', 0, 'bank', 666.67, 1, 0, '2022-11-04', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:00', '2022-11-29 13:55:00'),
(30, 'staff', 3, 0, 0, 0, 'SAL3202211291669710303', 0, 'bank', 500.00, 1, 0, '2022-11-05', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:03', '2022-11-29 13:55:03'),
(31, 'staff', 4, 0, 0, 0, 'SAL4202211291669710303', 0, 'bank', 1166.67, 1, 0, '2022-11-05', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:03', '2022-11-29 13:55:03'),
(32, 'staff', 5, 0, 0, 0, 'SAL5202211291669710303', 0, 'bank', 1166.67, 1, 0, '2022-11-05', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:03', '2022-11-29 13:55:03'),
(33, 'staff', 6, 0, 0, 0, 'SAL6202211291669710303', 0, 'bank', 833.33, 1, 0, '2022-11-05', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:03', '2022-11-29 13:55:03'),
(34, 'staff', 7, 0, 0, 0, 'SAL7202211291669710303', 0, 'bank', 666.67, 1, 0, '2022-11-05', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:03', '2022-11-29 13:55:03'),
(35, 'staff', 3, 0, 0, 0, 'SAL3202211291669710305', 0, 'bank', 500.00, 1, 0, '2022-11-06', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:05', '2022-11-29 13:55:05'),
(36, 'staff', 4, 0, 0, 0, 'SAL4202211291669710305', 0, 'bank', 1166.67, 1, 0, '2022-11-06', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:05', '2022-11-29 13:55:05'),
(37, 'staff', 5, 0, 0, 0, 'SAL5202211291669710305', 0, 'bank', 1166.67, 1, 0, '2022-11-06', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:05', '2022-11-29 13:55:05'),
(38, 'staff', 6, 0, 0, 0, 'SAL6202211291669710305', 0, 'bank', 833.33, 1, 0, '2022-11-06', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:05', '2022-11-29 13:55:05'),
(39, 'staff', 7, 0, 0, 0, 'SAL7202211291669710305', 0, 'bank', 666.67, 1, 0, '2022-11-06', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:05', '2022-11-29 13:55:05'),
(40, 'staff', 3, 0, 0, 0, 'SAL3202211291669710308', 0, 'bank', 500.00, 1, 0, '2022-11-07', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:08', '2022-11-29 13:55:08'),
(41, 'staff', 4, 0, 0, 0, 'SAL4202211291669710308', 0, 'bank', 1166.67, 1, 0, '2022-11-07', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:08', '2022-11-29 13:55:08'),
(42, 'staff', 5, 0, 0, 0, 'SAL5202211291669710308', 0, 'bank', 1166.67, 1, 0, '2022-11-07', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:08', '2022-11-29 13:55:08'),
(43, 'staff', 6, 0, 0, 0, 'SAL6202211291669710308', 0, 'bank', 833.33, 1, 0, '2022-11-07', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:08', '2022-11-29 13:55:08'),
(44, 'staff', 7, 0, 0, 0, 'SAL7202211291669710308', 0, 'bank', 666.67, 1, 0, '2022-11-07', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:08', '2022-11-29 13:55:08'),
(45, 'staff', 3, 0, 0, 0, 'SAL3202211291669710310', 0, 'bank', 500.00, 1, 0, '2022-11-08', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:10', '2022-11-29 13:55:10'),
(46, 'staff', 4, 0, 0, 0, 'SAL4202211291669710310', 0, 'bank', 1166.67, 1, 0, '2022-11-08', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:10', '2022-11-29 13:55:10'),
(47, 'staff', 5, 0, 0, 0, 'SAL5202211291669710310', 0, 'bank', 1166.67, 1, 0, '2022-11-08', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:10', '2022-11-29 13:55:10'),
(48, 'staff', 6, 0, 0, 0, 'SAL6202211291669710310', 0, 'bank', 833.33, 1, 0, '2022-11-08', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:10', '2022-11-29 13:55:10'),
(49, 'staff', 7, 0, 0, 0, 'SAL7202211291669710310', 0, 'bank', 666.67, 1, 0, '2022-11-08', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:10', '2022-11-29 13:55:10'),
(50, 'staff', 3, 0, 0, 0, 'SAL3202211291669710312', 0, 'bank', 500.00, 1, 0, '2022-11-09', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:12', '2022-11-29 13:55:12'),
(51, 'staff', 4, 0, 0, 0, 'SAL4202211291669710312', 0, 'bank', 1166.67, 1, 0, '2022-11-09', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:12', '2022-11-29 13:55:12'),
(52, 'staff', 5, 0, 0, 0, 'SAL5202211291669710312', 0, 'bank', 1166.67, 1, 0, '2022-11-09', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:12', '2022-11-29 13:55:12'),
(53, 'staff', 6, 0, 0, 0, 'SAL6202211291669710312', 0, 'bank', 833.33, 1, 0, '2022-11-09', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:12', '2022-11-29 13:55:12'),
(54, 'staff', 7, 0, 0, 0, 'SAL7202211291669710312', 0, 'bank', 666.67, 1, 0, '2022-11-09', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:12', '2022-11-29 13:55:12'),
(55, 'staff', 3, 0, 0, 0, 'SAL3202211291669710314', 0, 'bank', 500.00, 1, 0, '2022-11-10', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:14', '2022-11-29 13:55:14'),
(56, 'staff', 4, 0, 0, 0, 'SAL4202211291669710315', 0, 'bank', 1166.67, 1, 0, '2022-11-10', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:15', '2022-11-29 13:55:15'),
(57, 'staff', 5, 0, 0, 0, 'SAL5202211291669710315', 0, 'bank', 1166.67, 1, 0, '2022-11-10', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:15', '2022-11-29 13:55:15'),
(58, 'staff', 6, 0, 0, 0, 'SAL6202211291669710315', 0, 'bank', 833.33, 1, 0, '2022-11-10', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:15', '2022-11-29 13:55:15'),
(59, 'staff', 7, 0, 0, 0, 'SAL7202211291669710315', 0, 'bank', 666.67, 1, 0, '2022-11-10', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:15', '2022-11-29 13:55:15'),
(60, 'staff', 3, 0, 0, 0, 'SAL3202211291669710317', 0, 'bank', 500.00, 1, 0, '2022-11-11', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:17', '2022-11-29 13:55:17'),
(61, 'staff', 4, 0, 0, 0, 'SAL4202211291669710317', 0, 'bank', 1166.67, 1, 0, '2022-11-11', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:17', '2022-11-29 13:55:17'),
(62, 'staff', 5, 0, 0, 0, 'SAL5202211291669710317', 0, 'bank', 1166.67, 1, 0, '2022-11-11', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:17', '2022-11-29 13:55:17'),
(63, 'staff', 6, 0, 0, 0, 'SAL6202211291669710317', 0, 'bank', 833.33, 1, 0, '2022-11-11', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:17', '2022-11-29 13:55:17'),
(64, 'staff', 7, 0, 0, 0, 'SAL7202211291669710317', 0, 'bank', 666.67, 1, 0, '2022-11-11', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:17', '2022-11-29 13:55:17'),
(65, 'staff', 3, 0, 0, 0, 'SAL3202211291669710319', 0, 'bank', 500.00, 1, 0, '2022-11-12', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:19', '2022-11-29 13:55:19'),
(66, 'staff', 4, 0, 0, 0, 'SAL4202211291669710319', 0, 'bank', 1166.67, 1, 0, '2022-11-12', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:19', '2022-11-29 13:55:19'),
(67, 'staff', 5, 0, 0, 0, 'SAL5202211291669710319', 0, 'bank', 1166.67, 1, 0, '2022-11-12', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:19', '2022-11-29 13:55:19'),
(68, 'staff', 6, 0, 0, 0, 'SAL6202211291669710319', 0, 'bank', 833.33, 1, 0, '2022-11-12', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:19', '2022-11-29 13:55:19'),
(69, 'staff', 7, 0, 0, 0, 'SAL7202211291669710319', 0, 'bank', 666.67, 1, 0, '2022-11-12', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:19', '2022-11-29 13:55:19'),
(70, 'staff', 3, 0, 0, 0, 'SAL3202211291669710322', 0, 'bank', 500.00, 1, 0, '2022-11-13', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:22', '2022-11-29 13:55:22'),
(71, 'staff', 4, 0, 0, 0, 'SAL4202211291669710322', 0, 'bank', 1166.67, 1, 0, '2022-11-13', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:22', '2022-11-29 13:55:22'),
(72, 'staff', 5, 0, 0, 0, 'SAL5202211291669710322', 0, 'bank', 1166.67, 1, 0, '2022-11-13', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:22', '2022-11-29 13:55:22'),
(73, 'staff', 6, 0, 0, 0, 'SAL6202211291669710322', 0, 'bank', 833.33, 1, 0, '2022-11-13', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:22', '2022-11-29 13:55:22'),
(74, 'staff', 7, 0, 0, 0, 'SAL7202211291669710322', 0, 'bank', 666.67, 1, 0, '2022-11-13', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:22', '2022-11-29 13:55:22'),
(75, 'staff', 3, 0, 0, 0, 'SAL3202211291669710324', 0, 'bank', 500.00, 1, 0, '2022-11-14', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:24', '2022-11-29 13:55:24'),
(76, 'staff', 4, 0, 0, 0, 'SAL4202211291669710324', 0, 'bank', 1166.67, 1, 0, '2022-11-14', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:24', '2022-11-29 13:55:24'),
(77, 'staff', 5, 0, 0, 0, 'SAL5202211291669710324', 0, 'bank', 1166.67, 1, 0, '2022-11-14', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:24', '2022-11-29 13:55:24'),
(78, 'staff', 6, 0, 0, 0, 'SAL6202211291669710325', 0, 'bank', 833.33, 1, 0, '2022-11-14', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:25', '2022-11-29 13:55:25'),
(79, 'staff', 7, 0, 0, 0, 'SAL7202211291669710325', 0, 'bank', 666.67, 1, 0, '2022-11-14', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:25', '2022-11-29 13:55:25'),
(80, 'staff', 3, 0, 0, 0, 'SAL3202211291669710327', 0, 'bank', 500.00, 1, 0, '2022-11-15', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:27', '2022-11-29 13:55:27'),
(81, 'staff', 4, 0, 0, 0, 'SAL4202211291669710327', 0, 'bank', 1166.67, 1, 0, '2022-11-15', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:27', '2022-11-29 13:55:27'),
(82, 'staff', 5, 0, 0, 0, 'SAL5202211291669710327', 0, 'bank', 1166.67, 1, 0, '2022-11-15', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:27', '2022-11-29 13:55:27'),
(83, 'staff', 6, 0, 0, 0, 'SAL6202211291669710327', 0, 'bank', 833.33, 1, 0, '2022-11-15', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:27', '2022-11-29 13:55:27'),
(84, 'staff', 7, 0, 0, 0, 'SAL7202211291669710327', 0, 'bank', 666.67, 1, 0, '2022-11-15', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:27', '2022-11-29 13:55:27'),
(85, 'staff', 3, 0, 0, 0, 'SAL3202211291669710329', 0, 'bank', 500.00, 1, 0, '2022-11-16', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:29', '2022-11-29 13:55:29'),
(86, 'staff', 4, 0, 0, 0, 'SAL4202211291669710329', 0, 'bank', 1166.67, 1, 0, '2022-11-16', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:29', '2022-11-29 13:55:29'),
(87, 'staff', 5, 0, 0, 0, 'SAL5202211291669710329', 0, 'bank', 1166.67, 1, 0, '2022-11-16', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:29', '2022-11-29 13:55:29'),
(88, 'staff', 6, 0, 0, 0, 'SAL6202211291669710329', 0, 'bank', 833.33, 1, 0, '2022-11-16', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:29', '2022-11-29 13:55:29'),
(89, 'staff', 7, 0, 0, 0, 'SAL7202211291669710329', 0, 'bank', 666.67, 1, 0, '2022-11-16', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:29', '2022-11-29 13:55:29'),
(90, 'staff', 3, 0, 0, 0, 'SAL3202211291669710331', 0, 'bank', 500.00, 1, 0, '2022-11-17', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:31', '2022-11-29 13:55:31'),
(91, 'staff', 4, 0, 0, 0, 'SAL4202211291669710332', 0, 'bank', 1166.67, 1, 0, '2022-11-17', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:32', '2022-11-29 13:55:32'),
(92, 'staff', 5, 0, 0, 0, 'SAL5202211291669710332', 0, 'bank', 1166.67, 1, 0, '2022-11-17', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:32', '2022-11-29 13:55:32'),
(93, 'staff', 6, 0, 0, 0, 'SAL6202211291669710332', 0, 'bank', 833.33, 1, 0, '2022-11-17', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:32', '2022-11-29 13:55:32'),
(94, 'staff', 7, 0, 0, 0, 'SAL7202211291669710332', 0, 'bank', 666.67, 1, 0, '2022-11-17', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:32', '2022-11-29 13:55:32'),
(95, 'staff', 3, 0, 0, 0, 'SAL3202211291669710334', 0, 'bank', 500.00, 1, 0, '2022-11-18', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:34', '2022-11-29 13:55:34'),
(96, 'staff', 4, 0, 0, 0, 'SAL4202211291669710334', 0, 'bank', 1166.67, 1, 0, '2022-11-18', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:34', '2022-11-29 13:55:34'),
(97, 'staff', 5, 0, 0, 0, 'SAL5202211291669710334', 0, 'bank', 1166.67, 1, 0, '2022-11-18', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:34', '2022-11-29 13:55:34'),
(98, 'staff', 6, 0, 0, 0, 'SAL6202211291669710334', 0, 'bank', 833.33, 1, 0, '2022-11-18', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:34', '2022-11-29 13:55:34'),
(99, 'staff', 7, 0, 0, 0, 'SAL7202211291669710334', 0, 'bank', 666.67, 1, 0, '2022-11-18', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:34', '2022-11-29 13:55:34'),
(100, 'staff', 3, 0, 0, 0, 'SAL3202211291669710337', 0, 'bank', 500.00, 1, 0, '2022-11-19', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:37', '2022-11-29 13:55:37'),
(101, 'staff', 4, 0, 0, 0, 'SAL4202211291669710338', 0, 'bank', 1166.67, 1, 0, '2022-11-19', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:38', '2022-11-29 13:55:38'),
(102, 'staff', 5, 0, 0, 0, 'SAL5202211291669710338', 0, 'bank', 1166.67, 1, 0, '2022-11-19', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:38', '2022-11-29 13:55:38'),
(103, 'staff', 6, 0, 0, 0, 'SAL6202211291669710338', 0, 'bank', 833.33, 1, 0, '2022-11-19', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:38', '2022-11-29 13:55:38'),
(104, 'staff', 7, 0, 0, 0, 'SAL7202211291669710338', 0, 'bank', 666.67, 1, 0, '2022-11-19', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:38', '2022-11-29 13:55:38'),
(105, 'staff', 3, 0, 0, 0, 'SAL3202211291669710341', 0, 'bank', 500.00, 1, 0, '2022-11-20', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:41', '2022-11-29 13:55:41'),
(106, 'staff', 4, 0, 0, 0, 'SAL4202211291669710341', 0, 'bank', 1166.67, 1, 0, '2022-11-20', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:41', '2022-11-29 13:55:41'),
(107, 'staff', 5, 0, 0, 0, 'SAL5202211291669710341', 0, 'bank', 1166.67, 1, 0, '2022-11-20', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:41', '2022-11-29 13:55:41'),
(108, 'staff', 6, 0, 0, 0, 'SAL6202211291669710341', 0, 'bank', 833.33, 1, 0, '2022-11-20', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:41', '2022-11-29 13:55:41'),
(109, 'staff', 7, 0, 0, 0, 'SAL7202211291669710341', 0, 'bank', 666.67, 1, 0, '2022-11-20', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:55:41', '2022-11-29 13:55:41'),
(110, 'staff', 3, 0, 0, 0, 'SAL3202211291669710362', 0, 'bank', 500.00, 1, 0, '2022-11-21', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:02', '2022-11-29 13:56:02'),
(111, 'staff', 4, 0, 0, 0, 'SAL4202211291669710362', 0, 'bank', 1166.67, 1, 0, '2022-11-21', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:02', '2022-11-29 13:56:02'),
(112, 'staff', 5, 0, 0, 0, 'SAL5202211291669710362', 0, 'bank', 1166.67, 1, 0, '2022-11-21', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:02', '2022-11-29 13:56:02'),
(113, 'staff', 6, 0, 0, 0, 'SAL6202211291669710362', 0, 'bank', 833.33, 1, 0, '2022-11-21', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:02', '2022-11-29 13:56:02'),
(114, 'staff', 7, 0, 0, 0, 'SAL7202211291669710362', 0, 'bank', 666.67, 1, 0, '2022-11-21', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:02', '2022-11-29 13:56:02'),
(115, 'staff', 3, 0, 0, 0, 'SAL3202211291669710364', 0, 'bank', 500.00, 1, 0, '2022-11-22', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:04', '2022-11-29 13:56:04'),
(116, 'staff', 4, 0, 0, 0, 'SAL4202211291669710364', 0, 'bank', 1166.67, 1, 0, '2022-11-22', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:04', '2022-11-29 13:56:04'),
(117, 'staff', 5, 0, 0, 0, 'SAL5202211291669710364', 0, 'bank', 1166.67, 1, 0, '2022-11-22', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:04', '2022-11-29 13:56:04'),
(118, 'staff', 6, 0, 0, 0, 'SAL6202211291669710364', 0, 'bank', 833.33, 1, 0, '2022-11-22', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:04', '2022-11-29 13:56:04'),
(119, 'staff', 7, 0, 0, 0, 'SAL7202211291669710365', 0, 'bank', 666.67, 1, 0, '2022-11-22', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:05', '2022-11-29 13:56:05'),
(120, 'staff', 3, 0, 0, 0, 'SAL3202211291669710367', 0, 'bank', 500.00, 1, 0, '2022-11-23', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:07', '2022-11-29 13:56:07'),
(121, 'staff', 4, 0, 0, 0, 'SAL4202211291669710367', 0, 'bank', 1166.67, 1, 0, '2022-11-23', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:07', '2022-11-29 13:56:07'),
(122, 'staff', 5, 0, 0, 0, 'SAL5202211291669710367', 0, 'bank', 1166.67, 1, 0, '2022-11-23', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:07', '2022-11-29 13:56:07'),
(123, 'staff', 6, 0, 0, 0, 'SAL6202211291669710367', 0, 'bank', 833.33, 1, 0, '2022-11-23', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:07', '2022-11-29 13:56:07'),
(124, 'staff', 7, 0, 0, 0, 'SAL7202211291669710367', 0, 'bank', 666.67, 1, 0, '2022-11-23', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:07', '2022-11-29 13:56:07'),
(125, 'staff', 3, 0, 0, 0, 'SAL3202211291669710370', 0, 'bank', 500.00, 1, 0, '2022-11-24', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:10', '2022-11-29 13:56:10'),
(126, 'staff', 4, 0, 0, 0, 'SAL4202211291669710370', 0, 'bank', 1166.67, 1, 0, '2022-11-24', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:10', '2022-11-29 13:56:10'),
(127, 'staff', 5, 0, 0, 0, 'SAL5202211291669710370', 0, 'bank', 1166.67, 1, 0, '2022-11-24', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:10', '2022-11-29 13:56:10'),
(128, 'staff', 6, 0, 0, 0, 'SAL6202211291669710370', 0, 'bank', 833.33, 1, 0, '2022-11-24', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:10', '2022-11-29 13:56:10'),
(129, 'staff', 7, 0, 0, 0, 'SAL7202211291669710370', 0, 'bank', 666.67, 1, 0, '2022-11-24', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:10', '2022-11-29 13:56:10'),
(130, 'staff', 3, 0, 0, 0, 'SAL3202211291669710372', 0, 'bank', 500.00, 1, 0, '2022-11-25', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:12', '2022-11-29 13:56:12'),
(131, 'staff', 4, 0, 0, 0, 'SAL4202211291669710373', 0, 'bank', 1166.67, 1, 0, '2022-11-25', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:13', '2022-11-29 13:56:13'),
(132, 'staff', 5, 0, 0, 0, 'SAL5202211291669710373', 0, 'bank', 1166.67, 1, 0, '2022-11-25', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:13', '2022-11-29 13:56:13'),
(133, 'staff', 6, 0, 0, 0, 'SAL6202211291669710373', 0, 'bank', 833.33, 1, 0, '2022-11-25', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:13', '2022-11-29 13:56:13'),
(134, 'staff', 7, 0, 0, 0, 'SAL7202211291669710373', 0, 'bank', 666.67, 1, 0, '2022-11-25', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:13', '2022-11-29 13:56:13'),
(135, 'staff', 3, 0, 0, 0, 'SAL3202211291669710375', 0, 'bank', 500.00, 1, 0, '2022-11-26', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:15', '2022-11-29 13:56:15'),
(136, 'staff', 4, 0, 0, 0, 'SAL4202211291669710375', 0, 'bank', 1166.67, 1, 0, '2022-11-26', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:15', '2022-11-29 13:56:15'),
(137, 'staff', 5, 0, 0, 0, 'SAL5202211291669710375', 0, 'bank', 1166.67, 1, 0, '2022-11-26', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:15', '2022-11-29 13:56:15'),
(138, 'staff', 6, 0, 0, 0, 'SAL6202211291669710375', 0, 'bank', 833.33, 1, 0, '2022-11-26', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:15', '2022-11-29 13:56:15'),
(139, 'staff', 7, 0, 0, 0, 'SAL7202211291669710375', 0, 'bank', 666.67, 1, 0, '2022-11-26', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:15', '2022-11-29 13:56:15'),
(140, 'staff', 3, 0, 0, 0, 'SAL3202211291669710379', 0, 'bank', 500.00, 1, 0, '2022-11-27', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:19', '2022-11-29 13:56:19'),
(141, 'staff', 4, 0, 0, 0, 'SAL4202211291669710379', 0, 'bank', 1166.67, 1, 0, '2022-11-27', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:19', '2022-11-29 13:56:19'),
(142, 'staff', 5, 0, 0, 0, 'SAL5202211291669710379', 0, 'bank', 1166.67, 1, 0, '2022-11-27', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:19', '2022-11-29 13:56:19'),
(143, 'staff', 6, 0, 0, 0, 'SAL6202211291669710379', 0, 'bank', 833.33, 1, 0, '2022-11-27', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:19', '2022-11-29 13:56:19'),
(144, 'staff', 7, 0, 0, 0, 'SAL7202211291669710379', 0, 'bank', 666.67, 1, 0, '2022-11-27', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:19', '2022-11-29 13:56:19'),
(145, 'staff', 3, 0, 0, 0, 'SAL3202211291669710381', 0, 'bank', 500.00, 1, 0, '2022-11-28', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:21', '2022-11-29 13:56:21'),
(146, 'staff', 4, 0, 0, 0, 'SAL4202211291669710381', 0, 'bank', 1166.67, 1, 0, '2022-11-28', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:21', '2022-11-29 13:56:21'),
(147, 'staff', 5, 0, 0, 0, 'SAL5202211291669710382', 0, 'bank', 1166.67, 1, 0, '2022-11-28', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:22', '2022-11-29 13:56:22'),
(148, 'staff', 6, 0, 0, 0, 'SAL6202211291669710382', 0, 'bank', 833.33, 1, 0, '2022-11-28', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:22', '2022-11-29 13:56:22'),
(149, 'staff', 7, 0, 0, 0, 'SAL7202211291669710382', 0, 'bank', 666.67, 1, 0, '2022-11-28', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:22', '2022-11-29 13:56:22'),
(150, 'staff', 3, 0, 0, 0, 'SAL3202211291669710384', 0, 'bank', 500.00, 1, 0, '2022-11-29', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:24', '2022-11-29 13:56:24'),
(151, 'staff', 4, 0, 0, 0, 'SAL4202211291669710384', 0, 'bank', 1166.67, 1, 0, '2022-11-29', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:24', '2022-11-29 13:56:24'),
(152, 'staff', 5, 0, 0, 0, 'SAL5202211291669710384', 0, 'bank', 1166.67, 1, 0, '2022-11-29', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:24', '2022-11-29 13:56:24'),
(153, 'staff', 6, 0, 0, 0, 'SAL6202211291669710384', 0, 'bank', 833.33, 1, 0, '2022-11-29', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:24', '2022-11-29 13:56:24'),
(154, 'staff', 7, 0, 0, 0, 'SAL7202211291669710384', 0, 'bank', 666.67, 1, 0, '2022-11-29', 'salary', 'Staff Daily Salary', 1, '2022-11-29 13:56:24', '2022-11-29 13:56:24'),
(155, 'staff', 3, 0, 0, 0, 'EXPENSE1669710497', 7, 'cash', 1000.00, 0, 1, '2022-11-10', 'expense', 'expense for staff. Incentive', 1, '2022-11-29 14:00:01', '2022-11-29 14:00:01'),
(156, 'staff', 3, 0, 0, 0, 'EXPENSE1669710602', 8, 'cash', 1500.00, 0, 1, '2022-11-20', 'expense', 'expense for staff. Incentive', 1, '2022-11-29 14:01:34', '2022-11-29 14:01:34'),
(157, 'staff', 5, 0, 0, 0, 'EXPENSE1669710694', 9, 'bank', 30000.00, 0, 1, '2022-11-29', 'expense', 'expense for staff. Monthly Payment', 1, '2022-11-29 14:03:18', '2022-11-29 14:03:18'),
(158, 'supplier', 0, 0, 1, 0, 'EXPENSE1669710798', 10, 'bank', 15000.00, 0, 1, '2022-11-29', 'expense', 'expense for supplier. Supplier Payment', 1, '2022-11-29 14:05:04', '2022-11-29 14:05:04'),
(159, 'store', 0, 7, 0, 0, '0000000002', 0, 'cash', 8250.00, 0, 1, '2022-11-29', 'invoice', 'invoice raised of sales order for store', 0, '2022-11-29 14:19:51', '2022-11-29 14:19:51'),
(160, 'supplier', 0, 0, 1, 0, 'I1RKK92HVZ5QTEOH', 0, 'bank', 15000.00, 1, 0, '2022-11-29', 'goods_received_note', 'Goods Received Note', 1, '2022-11-29 14:21:31', '2022-11-29 14:21:31'),
(161, 'store', 0, 7, 0, 0, '0000000003', 0, 'bank', 8250.00, 0, 1, '2022-11-29', 'invoice', 'invoice raised of sales order for store', 1, '2022-11-29 14:22:46', '2022-11-29 14:22:46'),
(162, 'staff', 6, 0, 0, 0, 'TA20221212180604', 0, 'bank', 0.00, 1, 0, '2022-12-12', 'travelling_allowance', 'Travelling Allowance', 1, '2022-12-12 18:06:04', '2022-12-12 18:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(14, '2014_10_12_000000_create_users_table', 1),
(15, '2014_10_12_100000_create_password_resets_table', 1),
(16, '2019_08_19_000000_create_failed_jobs_table', 1),
(17, '2022_02_28_100529_create_categories_table', 1),
(18, '2022_03_01_060945_create_admins_table', 1),
(19, '2022_03_01_113157_create_sub_categories_table', 1),
(20, '2022_03_01_113259_create_collections_table', 1),
(21, '2022_03_01_131758_create_coupons_table', 1),
(24, '2022_03_02_075005_create_products_table', 2),
(25, '2022_03_02_120938_create_addresses_table', 3),
(26, '2022_03_02_132406_create_faqs_table', 4),
(27, '2022_03_02_134321_create_settings_table', 5),
(28, '2022_03_02_140807_create_product_images_table', 6),
(49, '2022_03_03_084615_create_product_colors_table', 7),
(50, '2022_03_03_084729_create_product_color_sizes_table', 7),
(51, '2022_03_03_085246_create_colors_table', 7),
(52, '2022_03_03_112136_create_sizes_table', 7),
(53, '2022_03_04_080922_create_orders_table', 8),
(54, '2022_03_04_080937_create_transactions_table', 8),
(55, '2022_03_04_081901_create_order_products_table', 8),
(56, '2022_03_04_082329_create_carts_table', 8),
(58, '2022_03_07_151020_add_banner_image_to_categories_table', 9),
(59, '2022_03_07_163254_add_banner_image_to_collections_table', 10),
(60, '2022_03_08_114708_add_column_to_carts_table', 11),
(66, '2022_03_08_154736_add_columns_to_orders_table', 12),
(67, '2022_03_09_121714_add_columns_to_addresses_table', 13),
(69, '2022_03_09_173649_create_subscription_mails_table', 14),
(70, '2022_03_10_124914_add_columns_to_categories_and_collections_table', 15),
(72, '2022_03_11_152029_create_mail_logs_table', 16),
(74, '2022_03_16_115151_add_new_columns_to_categories_and_collections_table', 17),
(75, '2022_03_16_193141_create_galleries_table', 18),
(76, '2022_03_16_193356_create_wishlists_table', 18),
(77, '2022_03_17_114435_add_new_column_to_galleries_table', 19),
(79, '2022_03_21_171424_add_columns_to_products_table', 20),
(82, '2022_03_22_165852_add_new_column_to_transactions_table', 21),
(83, '2022_03_23_181303_add_new_column_to_carts_table', 22),
(84, '2022_03_24_121204_add_more_columns_to_categories_and_collections_table', 23),
(85, '2022_03_24_195535_create_coupon_usages_table', 24),
(86, '2022_03_31_145730_add_column_to_products_table', 25),
(87, '2022_03_07_065136_create_table_offers', 26),
(94, '2022_05_25_062356_create_suppliers_table', 27),
(95, '2022_05_25_062344_create_customers_table', 28),
(98, '2022_05_25_105311_create_staff_post_details_table', 29),
(100, '2022_05_27_113941_create_purchase_orders_table', 30),
(102, '2022_06_13_045945_create_payment_collections_table', 31),
(104, '2022_06_17_050408_create_units_table', 32);

-- --------------------------------------------------------

--
-- Table structure for table `no_order_reasons`
--

CREATE TABLE `no_order_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `noorderreason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `no_order_reasons`
--

INSERT INTO `no_order_reasons` (`id`, `noorderreason`, `created_at`, `updated_at`) VALUES
(1, 'Product related issue', '2022-04-26 18:08:43', '2022-05-30 13:49:45'),
(2, 'Product related issue', '2022-04-26 18:08:43', '2022-05-30 13:49:45'),
(3, 'Distributor related issue', '2022-04-26 18:08:43', '2022-05-30 13:49:45'),
(4, 'Competitor related issue', '2022-04-26 18:08:43', '2022-05-30 13:49:45'),
(5, 'Company related issue', '2022-04-26 18:08:43', '2022-05-30 13:49:45'),
(6, 'Shop related issue', '2022-04-26 18:08:43', '2022-05-30 13:49:45'),
(7, 'More Factor', '2022-04-26 18:08:43', '2022-05-30 13:49:45');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 0 COMMENT 'staff_id or order placed by whom',
  `store_id` bigint(20) DEFAULT NULL,
  `amount` double(10,2) NOT NULL DEFAULT 0.00,
  `final_amount` double(10,2) DEFAULT 0.00,
  `paid_amount` double NOT NULL,
  `is_paid` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1: paid, 0: not paid',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:Received;2:Pending;3:Cancelled;4:Completed',
  `order_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'signature image base64',
  `is_gst` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_no`, `ip`, `user_id`, `store_id`, `amount`, `final_amount`, `paid_amount`, `is_paid`, `status`, `order_type`, `order_location`, `order_lat`, `order_lng`, `comment`, `signature`, `is_gst`, `created_at`, `updated_at`) VALUES
(1, 'AGNI815477884', '', 6, 5, 8250.00, 8250.00, 0, 0, 4, NULL, '', '', '', '', '', 0, '2022-11-22 06:41:40', '2022-11-22 06:42:07'),
(2, 'AGNI1690519356', '', 3, 7, 8250.00, 8250.00, 0, 0, 4, NULL, '', '', '', '', '', 1, '2022-11-29 08:47:26', '2022-11-29 08:51:57'),
(3, 'AGNI1483422099', '', 3, 7, 8250.00, 8250.00, 0, 0, 4, NULL, '', '', '', '', '', 0, '2022-11-29 08:47:45', '2022-11-29 08:48:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_cancelled_products`
--

CREATE TABLE `order_cancelled_products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(10,2) NOT NULL DEFAULT 0.00 COMMENT 'each carton price',
  `piece_price` double(10,2) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1 COMMENT 'carton',
  `pcs` int(11) NOT NULL DEFAULT 0 COMMENT 'total pieces for cartons',
  `release_qty` int(11) NOT NULL DEFAULT 0,
  `release_pcs` int(11) NOT NULL DEFAULT 0 COMMENT 'total released pieces for cartons',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `product_name`, `product_image`, `price`, `piece_price`, `qty`, `pcs`, `release_qty`, `release_pcs`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Agni Super Cut Off Wheel', 'uploads/product/1653395020.img2.jpg', 1650.00, 165.00, 5, 50, 5, 50, '2022-11-22 06:41:40', '2022-11-22 06:42:07'),
(2, 2, 3, 'Agni Super Cut Off Wheel', 'uploads/product/1653395020.img2.jpg', 1650.00, 165.00, 5, 50, 5, 50, '2022-11-29 08:47:26', '2022-11-29 08:51:57'),
(3, 3, 3, 'Agni Super Cut Off Wheel', 'uploads/product/1653395020.img2.jpg', 1650.00, 165.00, 5, 50, 5, 50, '2022-11-29 08:47:45', '2022-11-29 08:48:33');

-- --------------------------------------------------------

--
-- Table structure for table `packing_slip`
--

CREATE TABLE `packing_slip` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `slip_no` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `barcode_arr` text DEFAULT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `is_invoice_raised` tinyint(1) NOT NULL DEFAULT 0,
  `is_disbursed` tinyint(1) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0 COMMENT 'carton',
  `pcs` int(11) NOT NULL DEFAULT 0 COMMENT 'total pieces for carton',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packing_slip`
--

INSERT INTO `packing_slip` (`id`, `order_id`, `product_id`, `slip_no`, `barcode_arr`, `invoice_no`, `is_invoice_raised`, `is_disbursed`, `quantity`, `pcs`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '20221122121207', '[\"221399317066\",\"36171689120\",\"327399181454\",\"681572192623\",\"728088650375\"]', '0000000001', 1, 1, 5, 50, '2022-11-22 12:12:07', '2022-11-22 12:12:07'),
(2, 3, 3, '20221129141832', '[\"58261803149\",\"413783240528\",\"535092950820\",\"751731332940\",\"592250836777\"]', '0000000002', 1, 1, 5, 50, '2022-11-29 14:18:32', '2022-11-29 14:18:32'),
(3, 2, 3, '20221129142156', '[\"787949988760\",\"228997197169\",\"186427598154\",\"797817620116\",\"142370613719\"]', '0000000003', 1, 1, 5, 50, '2022-11-29 14:21:56', '2022-11-29 14:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `packing_slip_boxes`
--

CREATE TABLE `packing_slip_boxes` (
  `id` int(11) NOT NULL,
  `packing_slip_id` int(11) NOT NULL DEFAULT 0,
  `slip_no` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `pcs` int(11) DEFAULT NULL,
  `barcode_no` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `code_html` longtext DEFAULT NULL,
  `code_base64_img` longtext DEFAULT NULL,
  `is_disbursed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packing_slip_boxes`
--

INSERT INTO `packing_slip_boxes` (`id`, `packing_slip_id`, `slip_no`, `product_id`, `pcs`, `barcode_no`, `code_html`, `code_base64_img`, `is_disbursed`, `created_at`, `updated_at`) VALUES
(1, 1, '20221122121207', 3, 10, '221399317066', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:104px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:114px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:170px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+PBnHps/xp//fD7w2YaZx4Df4L/BB3vjAwyjUqNSo1IwKQAX2JcsdQQZzgAAAABJRU5ErkJggg==', 1, '2022-11-22 12:12:07', '2022-11-22 12:12:07'),
(2, 1, '20221122121207', 3, 10, '36171689120', '<div style=\"font-size:0;position:relative;width:224px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:180px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:208px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:216px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:220px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAOAAAAAeAQMAAAAPe4DLAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAADBJREFUKJFj+MzDfNie589/GwOew2eYGQ6f/3zexuDPGRvmA3/OM4xKjkqOSlIuCQBRObAizSMRZAAAAABJRU5ErkJggg==', 1, '2022-11-22 12:12:07', '2022-11-22 12:12:07'),
(3, 1, '20221122121207', 3, 10, '327399181454', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:54px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+MDnM8xnjD//+fDHmJ///JkPBn8+fLA3PsAwKjUqNSoFkwIA3dHm+neVhuMAAAAASUVORK5CYII=', 1, '2022-11-22 12:12:07', '2022-11-22 12:12:07'),
(4, 1, '20221122121207', 3, 10, '681572192623', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:158px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:164px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/mOHwmT82Bh94Ppw//OHw+fP2xucPfLA3PsAwKjUqNSoFkwIAKLDWdOt5B70AAAAASUVORK5CYII=', 1, '2022-11-22 12:12:07', '2022-11-22 12:12:07'),
(5, 1, '20221122121207', 3, 10, '728088650375', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:54px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:98px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:170px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mJ/hzOE/9od5Dtsw89jwMxy2+W/zwd74AMOo1KjUqBRMCgDnYE4MnzHHEAAAAABJRU5ErkJggg==', 1, '2022-11-22 12:12:07', '2022-11-22 12:12:07'),
(6, 2, '20221129141832', 3, 10, '58261803149', '<div style=\"font-size:0;position:relative;width:224px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:114px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:184px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:188px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:208px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:216px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:220px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAOAAAAAeAQMAAAAPe4DLAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAADBJREFUKJFj+MzDfP4wz5//Bof/fDhgbPCf34bf5sCfA+c/H/hznmFUclRyVJJySQDLwv16SNCyoQAAAABJRU5ErkJggg==', 1, '2022-11-29 14:18:33', '2022-11-29 14:18:33'),
(7, 2, '20221129141832', 3, 10, '413783240528', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+MCBM/wGxn8M/hw+zMzPf/iMgc2BD/bGBxhGpUalRqVgUgCvRYuS3rSoVAAAAABJRU5ErkJggg==', 1, '2022-11-29 14:18:33', '2022-11-29 14:18:33'),
(8, 2, '20221129141832', 3, 10, '535092950820', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:36px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:54px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+Pz588z2xvYHzn9mZj7Mz2NvYPPng73xAYZRqVGpUSmYFAC0v2qGPScv0AAAAABJRU5ErkJggg==', 1, '2022-11-29 14:18:33', '2022-11-29 14:18:33'),
(9, 2, '20221129141832', 3, 10, '751731332940', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:128px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+IDBGXt+mw82Z/iZP3w4z2xg8+HDB3vjAwyjUqNSo1IwKQB/z4xGrFEyjwAAAABJRU5ErkJggg==', 1, '2022-11-29 14:18:33', '2022-11-29 14:18:33'),
(10, 2, '20221129141832', 3, 10, '592250836777', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:76px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:80px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:104px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:158px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+IPNef4zNjx/zn84zHCe//Nn488HPtgbH2AYlRqVGpWCSQEAJn/HVl3WUwAAAAAASUVORK5CYII=', 1, '2022-11-29 14:18:33', '2022-11-29 14:18:33'),
(11, 3, '20221129142156', 3, 10, '787949988760', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:62px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:80px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:98px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:170px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+IAxD/9nmwN//hsY/zHmP//Z3sbgg73xAYZRqVGpUSmYFAARHYPW8vmOIAAAAABJRU5ErkJggg==', 1, '2022-11-29 14:21:56', '2022-11-29 14:21:56'),
(12, 3, '20221129142156', 3, 10, '228997197169', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:76px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:80px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:136px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:164px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+PBnfpv/9mcOfDh/mN+A58MB+zN/PtgbH2AYlRqVGpWCSQEAX/jIZAleY40AAAAASUVORK5CYII=', 1, '2022-11-29 14:21:56', '2022-11-29 14:21:56'),
(13, 3, '20221129142156', 3, 10, '186427598154', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:172px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+PCHMwds7G0M/vAb8/znP/PBxoDng73xAYZRqVGpUSmYFACmlnn+uIoBLgAAAABJRU5ErkJggg==', 1, '2022-11-29 14:21:56', '2022-11-29 14:21:56'),
(14, 3, '20221129142156', 3, 10, '797817620116', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mPnPeYYzBn9s/jMbHz7PY29jY/zhg73xAYZRqVGpUSmYFAAtenmkLlOgXwAAAABJRU5ErkJggg==', 1, '2022-11-29 14:21:56', '2022-11-29 14:21:56');
INSERT INTO `packing_slip_boxes` (`id`, `packing_slip_id`, `slip_no`, `product_id`, `pcs`, `barcode_no`, `code_html`, `code_base64_img`, `is_disbursed`, `created_at`, `updated_at`) VALUES
(15, 3, '20221129142156', 3, 10, '142370613719', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:36px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAACxJREFUKJFj+Mx/mJ///Hl74wMGHw4YM5/h5/ljYPznA5DPMCo1KjUqBZMCAMSObVY7sumRAAAAAElFTkSuQmCC', 1, '2022-11-29 14:21:56', '2022-11-29 14:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('diptitrader@gmail.com', 'baIln4TDv8yNSceJK6ASng2Pd2qij7e78YJU0rVczvyzAjHc8sqgLV9pD4f5gy45', '2022-04-26 06:32:05'),
('diptitrader@gmail.com', 'z3nRp39pUcaaEwYEBvzQMM1RbXn8zbQ6lKE1GHTvGhYeAPncrHaTj1xXkmAR5VYg', '2022-04-26 06:32:56'),
('ravishankar20@gmail.com', 'aWE08aZwjCye6onVnPZsvpCOIrugCRJCXfFO1CDVsXRD2m0qYOtXrcrJB3Z09nYa', '2022-04-26 06:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `payment_for` varchar(255) NOT NULL DEFAULT 'credit',
  `payment_in` varchar(255) NOT NULL DEFAULT 'bank',
  `bank_cash` varchar(255) NOT NULL DEFAULT 'cash',
  `expense_id` int(11) NOT NULL DEFAULT 0,
  `service_slip_id` int(11) NOT NULL DEFAULT 0,
  `voucher_no` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `chq_utr_no` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `created_from` enum('web','app') NOT NULL DEFAULT 'web',
  `is_gst` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='added to ledger transaction';

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `store_id`, `staff_id`, `admin_id`, `supplier_id`, `payment_for`, `payment_in`, `bank_cash`, `expense_id`, `service_slip_id`, `voucher_no`, `payment_date`, `payment_mode`, `amount`, `chq_utr_no`, `bank_name`, `narration`, `created_from`, `is_gst`, `created_at`, `updated_at`) VALUES
(1, 5, 6, 0, 0, 'credit', 'bank', 'bank', 0, 0, 'PAYRECEIPT1669705947', '2022-11-29', 'cheque', 100.00, '1221324566521', 'State bank of india', NULL, 'web', 1, '2022-11-29 12:43:21', '2022-11-29 12:43:21'),
(3, 5, 0, 1, 0, 'credit', 'bank', 'bank', 0, 0, 'PAYRECEIPT1669706363', '2022-11-29', 'neft', 200.00, '34343', 'Axis Bank', NULL, 'web', 1, '2022-11-29 12:54:15', '2022-11-29 12:54:15'),
(4, 5, 0, 1, 0, 'credit', 'bank', 'bank', 0, 0, 'PAYRECEIPT1669707125', '2022-11-29', 'neft', 203.00, '3453534545', 'Axis Bank', NULL, 'web', 1, '2022-11-29 13:02:47', '2022-11-29 13:02:47'),
(5, 5, 0, 1, 0, 'credit', 'bank', 'bank', 0, 0, 'PAYRECEIPT1669707321', '2022-11-29', 'cheque', 206.00, '68676576767', 'Axis Bank', NULL, 'web', 1, '2022-11-29 13:05:48', '2022-11-29 13:05:48'),
(6, 5, 0, 1, 0, 'credit', 'cash', 'cash', 0, 0, 'PAYRECEIPT1669708417', '2022-11-29', 'cash', 301.00, '', '', NULL, 'web', 1, '2022-11-29 13:28:47', '2022-11-29 13:28:47'),
(7, 0, 3, 0, 0, 'debit', 'cash', 'cash', 6, 0, 'EXPENSE1669710497', '2022-11-10', 'cash', 1000.00, NULL, NULL, '1000 cash incentive', 'web', 1, '2022-11-29 14:00:01', '2022-11-29 14:00:01'),
(8, 0, 3, 0, 0, 'debit', 'cash', 'cash', 6, 0, 'EXPENSE1669710602', '2022-11-20', 'cash', 1500.00, NULL, NULL, '1500 cash incentive', 'web', 1, '2022-11-29 14:01:34', '2022-11-29 14:01:34'),
(9, 0, 5, 0, 0, 'debit', 'bank', 'bank', 25, 0, 'EXPENSE1669710694', '2022-11-29', 'cheque', 30000.00, '3233224434', NULL, NULL, 'web', 1, '2022-11-29 14:03:18', '2022-11-29 14:03:18'),
(10, 0, 0, 0, 1, 'debit', 'bank', 'bank', 28, 0, 'EXPENSE1669710798', '2022-11-29', 'cheque', 15000.00, '54545454', 'ICICI Bank', 'Supplier payment 15000 cheque', 'web', 1, '2022-11-29 14:05:04', '2022-11-29 14:05:04');

-- --------------------------------------------------------

--
-- Table structure for table `payment_collections`
--

CREATE TABLE `payment_collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `collection_amount` double(10,2) UNSIGNED DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cheque' COMMENT 'cheque,neft,cash',
  `is_ledger_added` tinyint(1) NOT NULL DEFAULT 0,
  `vouchar_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'payemt receipt voucher no',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approve` int(11) NOT NULL COMMENT '1=approved',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_collections`
--

INSERT INTO `payment_collections` (`id`, `store_id`, `user_id`, `collection_amount`, `bank_name`, `cheque_number`, `cheque_date`, `payment_type`, `is_ledger_added`, `vouchar_no`, `image`, `is_approve`, `created_at`, `updated_at`) VALUES
(1, 5, 6, 100.00, 'State bank of india', '1221324566521', '2022-11-29', 'cheque', 1, 'PAYRECEIPT1669705947', NULL, 0, '2022-11-29 10:43:21', '2022-11-29 12:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) NOT NULL,
  `sub_cat_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_price` double(10,2) NOT NULL COMMENT 'per piece (as per last PO)',
  `sell_price` double(10,2) NOT NULL COMMENT 'per piece (as per last PO)',
  `threshold_price` double(10,2) NOT NULL COMMENT 'per carton (as per last PO)',
  `pcs` int(11) NOT NULL DEFAULT 0 COMMENT 'as per last PO',
  `product_sales_price_threshold_percentage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '10' COMMENT 'threshold price percentage controlled from settings',
  `hsn_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `igst` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '18' COMMENT 'gst values',
  `sgst` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '9' COMMENT 'gst values',
  `cgst` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '9' COMMENT 'gst values',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `cat_id`, `sub_cat_id`, `name`, `image`, `short_desc`, `desc`, `cost_price`, `sell_price`, `threshold_price`, `pcs`, `product_sales_price_threshold_percentage`, `hsn_code`, `slug`, `igst`, `sgst`, `cgst`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 'Agni Super Cut Off Wheel', 'uploads/product/1653395020.img2.jpg', '<p><a href=\"https://www.indiamart.com/proddetail/agni-super-cut-off-wheel-20921936433.html\">Agni Super Cut Off Wheel</a>…</p>', '<h2><a href=\"https://www.indiamart.com/proddetail/agni-super-cut-off-wheel-20921936433.html\">Agni Super Cut Off Wheel</a></h2>', 150.00, 165.00, 1500.00, 10, '10', '1122334473', 'agni-super-cut-off-wheel', '18', '9', '9', 1, '2022-05-24 06:53:40', '2022-11-24 08:47:59'),
(22, 2, 5, 'Agni Power Tools 2', 'public/uploads/product/1668663475.no-image.jpg', '<p>Agni Power Tools 2</p>', '<p>Agni Power Tools 2</p>', 0.00, 0.00, 0.00, 10, '10', '3434', 'agni-power-tools-2', '18', '9', '9', 1, '2022-11-16 12:04:17', '2022-11-17 05:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 19, 'uploads/product/723172572-1662008852.realme-5i.jpg', 1, '2022-09-01 05:07:32', '2022-09-01 05:07:32'),
(2, 19, 'uploads/product/1727910833-1662008852.oppo-f21.jpg', 1, '2022-09-01 05:07:32', '2022-09-01 05:07:32');

-- --------------------------------------------------------

--
-- Table structure for table `product_threshold_request`
--

CREATE TABLE `product_threshold_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'staff_id / placed by',
  `store_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `threshold_price` double(10,2) NOT NULL COMMENT 'product threshold price as per last PO',
  `sell_price` double(10,2) NOT NULL COMMENT 'product sell price as per last PO',
  `pcs` int(11) NOT NULL DEFAULT 0,
  `price` double(10,2) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:pending;1:approved;2:denied',
  `customer_approve_note` text DEFAULT NULL,
  `customer_approval` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:pending;1:approved;2:denied',
  `order_no` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unique_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `supplier_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) NOT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL COMMENT 'no of cartons',
  `pcs` int(11) NOT NULL DEFAULT 0 COMMENT 'no of pieces',
  `unit_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'price per carton',
  `piece_price` double(10,2) NOT NULL COMMENT 'price per piece / product cost price',
  `total_price` double(10,2) NOT NULL,
  `hsn_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'in gram (calculated)',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1:pending;2:received',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `unique_id`, `supplier_id`, `product_id`, `product`, `address`, `state`, `city`, `country`, `pin`, `qty`, `pcs`, `unit_price`, `piece_price`, `total_price`, `hsn_code`, `weight`, `weight_unit`, `weight_value`, `status`, `created_at`, `updated_at`) VALUES
(1, '1669099020044', 1, 3, 'Agni Super Cut Off Wheel', '2 B, Rani Sankari Ln, Jatin Das Park, Patuapara, Bhowanipore, Kolkata, West Bengal 700025', 'West Bengal', 'Kolkata', 'India', '700025', 10, 10, '1500', 150.00, 15000.00, '1122334473', '1', 'kg', '1000', 2, '2022-11-22 06:37:16', '2022-11-22 06:37:16'),
(2, '1669279662420', 1, 3, 'Agni Super Cut Off Wheel', '2 B, Rani Sankari Ln, Jatin Das Park, Patuapara, Bhowanipore, Kolkata, West Bengal 700025', 'West Bengal', 'Kolkata', 'India', '700025', 10, 10, '1500', 150.00, 15000.00, '1122334473', '1', 'kg', '1000', 2, '2022-11-24 08:47:59', '2022-11-24 08:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_archived_boxes`
--

CREATE TABLE `purchase_order_archived_boxes` (
  `id` int(11) NOT NULL,
  `barcode_no` varchar(255) DEFAULT NULL,
  `code_html` longtext DEFAULT NULL,
  `code_base64_img` longtext DEFAULT NULL,
  `po_id` int(11) NOT NULL DEFAULT 0,
  `po_uniquie_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `po_weight_val` varchar(255) NOT NULL DEFAULT '' COMMENT 'in gram (calculated)',
  `pcs` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_boxes`
--

CREATE TABLE `purchase_order_boxes` (
  `id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL DEFAULT 0,
  `po_uniquie_id` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `product_id` int(11) NOT NULL DEFAULT 0,
  `pcs` int(11) DEFAULT NULL,
  `product_description` longtext DEFAULT NULL,
  `barcode_no` varchar(255) NOT NULL DEFAULT '',
  `code_html` longtext DEFAULT NULL,
  `code_base64_img` longtext DEFAULT NULL,
  `is_scanned` tinyint(1) NOT NULL DEFAULT 0,
  `scan_no` varchar(255) DEFAULT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `po_weight_val` varchar(255) DEFAULT NULL COMMENT 'in gram (calculated)',
  `scanned_weight_val` varchar(255) DEFAULT NULL COMMENT 'in gram (calculated)',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_order_boxes`
--

INSERT INTO `purchase_order_boxes` (`id`, `po_id`, `po_uniquie_id`, `product_id`, `pcs`, `product_description`, `barcode_no`, `code_html`, `code_base64_img`, `is_scanned`, `scan_no`, `is_new`, `po_weight_val`, `scanned_weight_val`, `created_at`, `updated_at`) VALUES
(1, 1, '1669099020044', 3, 10, NULL, '592250836777', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:76px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:80px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:104px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:158px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+IPNef4zNjx/zn84zHCe//Nn488HPtgbH2AYlRqVGpWCSQEAJn/HVl3WUwAAAAAASUVORK5CYII=', 1, NULL, 0, '1000', '1000', '2022-11-22 12:07:16', '2022-11-22 12:08:46'),
(2, 1, '1669099020044', 3, 10, NULL, '751731332940', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:128px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+IDBGXt+mw82Z/iZP3w4z2xg8+HDB3vjAwyjUqNSo1IwKQB/z4xGrFEyjwAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-22 12:07:16', '2022-11-22 12:08:40'),
(3, 1, '1669099020044', 3, 10, NULL, '535092950820', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:36px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:54px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+Pz588z2xvYHzn9mZj7Mz2NvYPPng73xAYZRqVGpUSmYFAC0v2qGPScv0AAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-22 12:07:16', '2022-11-22 12:08:35'),
(4, 1, '1669099020044', 3, 10, NULL, '413783240528', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+MCBM/wGxn8M/hw+zMzPf/iMgc2BD/bGBxhGpUalRqVgUgCvRYuS3rSoVAAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-22 12:07:16', '2022-11-22 12:08:30'),
(5, 1, '1669099020044', 3, 10, NULL, '58261803149', '<div style=\"font-size:0;position:relative;width:224px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:114px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:184px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:188px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:208px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:216px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:220px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAOAAAAAeAQMAAAAPe4DLAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAADBJREFUKJFj+MzDfP4wz5//Bof/fDhgbPCf34bf5sCfA+c/H/hznmFUclRyVJJySQDLwv16SNCyoQAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-22 12:07:16', '2022-11-22 12:08:23'),
(6, 1, '1669099020044', 3, 10, NULL, '728088650375', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:54px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:98px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:170px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mJ/hzOE/9od5Dtsw89jwMxy2+W/zwd74AMOo1KjUqBRMCgDnYE4MnzHHEAAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-22 12:07:16', '2022-11-22 12:08:17'),
(7, 1, '1669099020044', 3, 10, NULL, '681572192623', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:158px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:164px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/mOHwmT82Bh94Ppw//OHw+fP2xucPfLA3PsAwKjUqNSoFkwIAKLDWdOt5B70AAAAASUVORK5CYII=', 1, NULL, 0, '1000', '1000', '2022-11-22 12:07:16', '2022-11-22 12:08:11'),
(8, 1, '1669099020044', 3, 10, NULL, '327399181454', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:54px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+MDnM8xnjD//+fDHmJ///JkPBn8+fLA3PsAwKjUqNSoFkwIA3dHm+neVhuMAAAAASUVORK5CYII=', 1, NULL, 0, '1000', '1000', '2022-11-22 12:07:16', '2022-11-22 12:08:06'),
(9, 1, '1669099020044', 3, 10, NULL, '36171689120', '<div style=\"font-size:0;position:relative;width:224px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:180px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:208px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:216px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:220px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAOAAAAAeAQMAAAAPe4DLAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAADBJREFUKJFj+MzDfNie589/GwOew2eYGQ6f/3zexuDPGRvmA3/OM4xKjkqOSlIuCQBRObAizSMRZAAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-22 12:07:16', '2022-11-22 12:08:00'),
(10, 1, '1669099020044', 3, 10, NULL, '221399317066', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:104px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:114px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:170px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+PBnHps/xp//fD7w2YaZx4Df4L/BB3vjAwyjUqNSo1IwKQAX2JcsdQQZzgAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-22 12:07:16', '2022-11-22 12:07:54'),
(11, 2, '1669279662420', 3, 10, NULL, '161503403512', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:36px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:98px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:136px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:172px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mP88zx8bg8MHPhgzMzOf+fDH5g/PB3vjAwyjUqNSo1IwKQC244LIdxvKPAAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-24 14:17:59', '2022-11-29 14:21:26'),
(12, 2, '1669279662420', 3, 10, NULL, '281859076855', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:62px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:104px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+MNnfv7D9sxnDh84zHD4/Bl+gw9/PtgbH2AYlRqVGpWCSQEApbW0APMDglEAAAAASUVORK5CYII=', 1, NULL, 0, '1000', '1000', '2022-11-24 14:17:59', '2022-11-29 14:21:20'),
(13, 2, '1669279662420', 3, 10, NULL, '741674436792', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:76px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:136px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:164px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mOHDGXsbA36e88yfGc7znP9gw/Png73xAYZRqVGpUSmYFABNOWl4LorL/AAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-24 14:17:59', '2022-11-29 14:21:11'),
(14, 2, '1669279662420', 3, 10, NULL, '370076158739', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:36px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:158px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mPkMv42NjTHD+cOH/xjzGxgYH2b4YG98gGFUalRqVAomBQBK2z2GwFfVowAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-24 14:17:59', '2022-11-29 14:21:05');
INSERT INTO `purchase_order_boxes` (`id`, `po_id`, `po_uniquie_id`, `product_id`, `pcs`, `product_description`, `barcode_no`, `code_html`, `code_base64_img`, `is_scanned`, `scan_no`, `is_new`, `po_weight_val`, `scanned_weight_val`, `created_at`, `updated_at`) VALUES
(15, 2, '1669279662420', 3, 10, NULL, '225946619372', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:62px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:114px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+PBn/gOfjT/YfDhgbGB/xobZ4PCfD/bGBxhGpUalRqVgUgCXu6U8zvoV6gAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-24 14:17:59', '2022-11-29 14:20:57'),
(16, 2, '1669279662420', 3, 10, NULL, '142370613719', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:36px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAACxJREFUKJFj+Mx/mJ///Hl74wMGHw4YM5/h5/ljYPznA5DPMCo1KjUqBZMCAMSObVY7sumRAAAAAElFTkSuQmCC', 1, NULL, 0, '1000', '1000', '2022-11-24 14:17:59', '2022-11-29 14:20:50'),
(17, 2, '1669279662420', 3, 10, NULL, '797817620116', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mPnPeYYzBn9s/jMbHz7PY29jY/zhg73xAYZRqVGpUSmYFAAtenmkLlOgXwAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-24 14:17:59', '2022-11-29 14:20:45'),
(18, 2, '1669279662420', 3, 10, NULL, '186427598154', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:172px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+PCHMwds7G0M/vAb8/znP/PBxoDng73xAYZRqVGpUSmYFACmlnn+uIoBLgAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-24 14:18:00', '2022-11-29 14:20:39'),
(19, 2, '1669279662420', 3, 10, NULL, '228997197169', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:76px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:80px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:136px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:164px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+PBnfpv/9mcOfDh/mN+A58MB+zN/PtgbH2AYlRqVGpWCSQEAX/jIZAleY40AAAAASUVORK5CYII=', 1, NULL, 0, '1000', '1000', '2022-11-24 14:18:00', '2022-11-29 14:20:34'),
(20, 2, '1669279662420', 3, 10, NULL, '787949988760', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:62px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:80px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:98px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:170px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+IAxD/9nmwN//hsY/zHmP//Z3sbgg73xAYZRqVGpUSmYFAARHYPW8vmOIAAAAABJRU5ErkJggg==', 1, NULL, 0, '1000', '1000', '2022-11-24 14:18:00', '2022-11-29 14:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Customer', 'customer', 'customer', '2022-11-15 05:33:56', '2022-11-15 05:33:56'),
(2, 'Category', 'category', 'category', '2022-11-15 05:33:56', '2022-11-15 05:33:56'),
(3, 'Subcategory', 'subcategory', 'subcategory', '2022-11-15 05:33:56', '2022-11-15 05:33:56'),
(4, 'Product', 'product', 'product', '2022-11-15 05:33:56', '2022-11-15 05:33:56'),
(5, 'Expense', 'expense', 'expense', '2022-11-15 05:33:56', '2022-11-15 05:33:56'),
(6, 'Supplier', 'supplier', 'supplier', '2022-11-15 05:33:56', '2022-11-15 05:33:56'),
(7, 'Staff', 'staff', 'staff', '2022-11-15 05:33:56', '2022-11-15 05:33:56'),
(8, 'PO', 'po', 'po', '2022-11-15 05:33:56', '2022-11-15 05:33:56'),
(9, 'Sales', 'sales', 'sales', '2022-11-15 05:33:56', '2022-11-15 05:33:56'),
(10, 'Accounting', 'accounting', 'accounting', '2022-11-15 05:33:56', '2022-11-15 05:33:56'),
(11, 'Report', 'report', 'report', '2022-11-15 05:33:56', '2022-11-15 05:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `service_slip`
--

CREATE TABLE `service_slip` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `voucher_no` varchar(255) DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `narration` longtext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `set_product_ctns_pcs_ps`
--

CREATE TABLE `set_product_ctns_pcs_ps` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `barcode_no` varchar(255) DEFAULT NULL,
  `pcs` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='set op ctn pcs for generate ps temporary';

-- --------------------------------------------------------

--
-- Table structure for table `staff_commision`
--

CREATE TABLE `staff_commision` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `paid_as` varchar(255) DEFAULT NULL COMMENT 'order_creator;payment_collector',
  `commission_percentage_val` varchar(255) DEFAULT '''30''' COMMENT 'order_creator or payment_collector',
  `commission_amount` double NOT NULL,
  `vouchar_no` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `invoice_payment_id` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `staff_salary`
--

CREATE TABLE `staff_salary` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `monthly_salary` double(10,2) DEFAULT NULL,
  `daily_salary` double(10,2) DEFAULT NULL,
  `travelling_allowance` double(10,2) DEFAULT NULL,
  `is_current` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_salary`
--

INSERT INTO `staff_salary` (`id`, `user_id`, `monthly_salary`, `daily_salary`, `travelling_allowance`, `is_current`, `created_at`, `updated_at`) VALUES
(1, 3, 15000.00, 500.00, 100.00, 0, '2022-11-15 18:24:49', '2022-11-15 18:24:49'),
(2, 3, 15000.00, 500.00, NULL, 1, '2022-11-15 18:34:10', '2022-11-15 18:34:10'),
(3, 4, 35000.00, 1166.67, 0.00, 1, '2022-11-15 18:39:44', '2022-11-15 18:39:44'),
(4, 5, 35000.00, 1166.67, 0.00, 1, '2022-11-15 18:42:21', '2022-11-15 18:42:21'),
(5, 6, 25000.00, 833.33, 0.00, 1, '2022-11-15 18:44:49', '2022-11-15 18:44:49'),
(6, 7, 20000.00, 666.67, 0.00, 1, '2022-11-16 12:16:43', '2022-11-16 12:16:43');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `po_unique_id` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `grn_no` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='inventory';

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `po_unique_id`, `grn_no`, `created_at`, `updated_at`) VALUES
(1, '1669099020044', 'SHZECY9DKRKZKAH7', '2022-11-22 12:08:51', '2022-11-22 12:08:51'),
(2, '1669279662420', 'I1RKK92HVZ5QTEOH', '2022-11-29 14:21:30', '2022-11-29 14:21:30');

-- --------------------------------------------------------

--
-- Table structure for table `stock_boxes`
--

CREATE TABLE `stock_boxes` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `pcs` int(11) DEFAULT NULL,
  `barcode_no` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `code_html` longtext DEFAULT NULL,
  `code_base64_img` longtext DEFAULT NULL,
  `is_scanned` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'scan for packing slip',
  `scan_no` varchar(255) DEFAULT NULL COMMENT 'for stockout; validate the same barcode here',
  `packing_slip_box_id` int(11) DEFAULT NULL,
  `stock_in_weight_val` varchar(255) DEFAULT NULL COMMENT 'stock in time scanned weight; in gram (calculated); from api',
  `stock_out_weight_val` varchar(255) DEFAULT NULL COMMENT 'stock out time scanned weight; in gram (calculated); from api',
  `is_set_for_ps` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'is set for packing slip for holding purpose the box or ctn',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_boxes`
--

INSERT INTO `stock_boxes` (`id`, `stock_id`, `product_id`, `pcs`, `barcode_no`, `code_html`, `code_base64_img`, `is_scanned`, `scan_no`, `packing_slip_box_id`, `stock_in_weight_val`, `stock_out_weight_val`, `is_set_for_ps`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 10, '221399317066', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:104px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:114px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:170px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+PBnHps/xp//fD7w2YaZx4Df4L/BB3vjAwyjUqNSo1IwKQAX2JcsdQQZzgAAAABJRU5ErkJggg==', 1, '221399317066', NULL, '1000', '1000', 0, '2022-11-22 12:08:51', '2022-11-22 12:12:47'),
(2, 1, 3, 10, '36171689120', '<div style=\"font-size:0;position:relative;width:224px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:180px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:208px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:216px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:220px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAOAAAAAeAQMAAAAPe4DLAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAADBJREFUKJFj+MzDfNie589/GwOew2eYGQ6f/3zexuDPGRvmA3/OM4xKjkqOSlIuCQBRObAizSMRZAAAAABJRU5ErkJggg==', 1, '36171689120', NULL, '1000', '1000', 0, '2022-11-22 12:08:51', '2022-11-22 12:12:54'),
(3, 1, 3, 10, '327399181454', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:54px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+MDnM8xnjD//+fDHmJ///JkPBn8+fLA3PsAwKjUqNSoFkwIA3dHm+neVhuMAAAAASUVORK5CYII=', 1, '327399181454', NULL, '1000', '1000', 0, '2022-11-22 12:08:51', '2022-11-22 12:13:04'),
(4, 1, 3, 10, '681572192623', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:158px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:164px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/mOHwmT82Bh94Ppw//OHw+fP2xucPfLA3PsAwKjUqNSoFkwIAKLDWdOt5B70AAAAASUVORK5CYII=', 1, '681572192623', NULL, '1000', '1000', 0, '2022-11-22 12:08:52', '2022-11-22 12:13:11'),
(5, 1, 3, 10, '728088650375', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:54px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:98px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:170px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mJ/hzOE/9od5Dtsw89jwMxy2+W/zwd74AMOo1KjUqBRMCgDnYE4MnzHHEAAAAABJRU5ErkJggg==', 1, '728088650375', NULL, '1000', '1000', 0, '2022-11-22 12:08:52', '2022-11-22 12:13:16'),
(6, 1, 3, 10, '58261803149', '<div style=\"font-size:0;position:relative;width:224px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:114px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:184px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:188px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:208px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:216px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:220px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAOAAAAAeAQMAAAAPe4DLAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAADBJREFUKJFj+MzDfP4wz5//Bof/fDhgbPCf34bf5sCfA+c/H/hznmFUclRyVJJySQDLwv16SNCyoQAAAABJRU5ErkJggg==', 1, '58261803149', NULL, '1000', '1000', 0, '2022-11-22 12:08:52', '2022-11-29 14:18:55'),
(7, 1, 3, 10, '413783240528', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+MCBM/wGxn8M/hw+zMzPf/iMgc2BD/bGBxhGpUalRqVgUgCvRYuS3rSoVAAAAABJRU5ErkJggg==', 1, '413783240528', NULL, '1000', '1000', 0, '2022-11-22 12:08:52', '2022-11-29 14:19:00'),
(8, 1, 3, 10, '535092950820', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:36px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:54px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+Pz588z2xvYHzn9mZj7Mz2NvYPPng73xAYZRqVGpUSmYFAC0v2qGPScv0AAAAABJRU5ErkJggg==', 1, '535092950820', NULL, '1000', '1000', 0, '2022-11-22 12:08:52', '2022-11-29 14:19:06'),
(9, 1, 3, 10, '751731332940', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:128px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+IDBGXt+mw82Z/iZP3w4z2xg8+HDB3vjAwyjUqNSo1IwKQB/z4xGrFEyjwAAAABJRU5ErkJggg==', 1, '751731332940', NULL, '1000', '1000', 0, '2022-11-22 12:08:52', '2022-11-29 14:19:11'),
(10, 1, 3, 10, '592250836777', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:76px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:80px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:104px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:142px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:158px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+IPNef4zNjx/zn84zHCe//Nn488HPtgbH2AYlRqVGpWCSQEAJn/HVl3WUwAAAAAASUVORK5CYII=', 1, '592250836777', NULL, '1000', '1000', 0, '2022-11-22 12:08:52', '2022-11-29 14:19:17'),
(11, 2, 3, 10, '787949988760', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:34px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:62px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:80px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:98px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:170px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+IAxD/9nmwN//hsY/zHmP//Z3sbgg73xAYZRqVGpUSmYFAARHYPW8vmOIAAAAABJRU5ErkJggg==', 1, '787949988760', NULL, '1000', '1000', 0, '2022-11-29 14:21:30', '2022-11-29 14:22:08'),
(12, 2, 3, 10, '228997197169', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:76px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:80px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:136px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:164px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+PBnfpv/9mcOfDh/mN+A58MB+zN/PtgbH2AYlRqVGpWCSQEAX/jIZAleY40AAAAASUVORK5CYII=', 1, '228997197169', NULL, '1000', '1000', 0, '2022-11-29 14:21:31', '2022-11-29 14:22:13'),
(13, 2, 3, 10, '186427598154', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:100px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:116px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:172px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+PCHMwds7G0M/vAb8/znP/PBxoDng73xAYZRqVGpUSmYFACmlnn+uIoBLgAAAABJRU5ErkJggg==', 1, '186427598154', NULL, '1000', '1000', 0, '2022-11-29 14:21:31', '2022-11-29 14:22:18'),
(14, 2, 3, 10, '797817620116', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:60px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mPnPeYYzBn9s/jMbHz7PY29jY/zhg73xAYZRqVGpUSmYFAAtenmkLlOgXwAAAABJRU5ErkJggg==', 1, '797817620116', NULL, '1000', '1000', 0, '2022-11-29 14:21:31', '2022-11-29 14:22:25');
INSERT INTO `stock_boxes` (`id`, `stock_id`, `product_id`, `pcs`, `barcode_no`, `code_html`, `code_base64_img`, `is_scanned`, `scan_no`, `packing_slip_box_id`, `stock_in_weight_val`, `stock_out_weight_val`, `is_set_for_ps`, `created_at`, `updated_at`) VALUES
(15, 2, 3, 10, '142370613719', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:36px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:162px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAACxJREFUKJFj+Mx/mJ///Hl74wMGHw4YM5/h5/ljYPznA5DPMCo1KjUqBZMCAMSObVY7sumRAAAAAElFTkSuQmCC', 1, '142370613719', NULL, '1000', '1000', 0, '2022-11-29 14:21:31', '2022-11-29 14:22:30'),
(16, 2, 3, 10, '225946619372', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:56px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:62px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:70px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:82px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:96px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:106px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:114px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:150px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/+PBn/gOfjT/YfDhgbGB/xobZ4PCfD/bGBxhGpUalRqVgUgCXu6U8zvoV6gAAAABJRU5ErkJggg==', 0, NULL, NULL, '1000', NULL, 0, '2022-11-29 14:21:31', '2022-11-29 14:21:31'),
(17, 2, 3, 10, '370076158739', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:30px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:36px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:74px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:122px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:138px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:146px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:158px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:166px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mPkMv42NjTHD+cOH/xjzGxgYH2b4YG98gGFUalRqVAomBQBK2z2GwFfVowAAAABJRU5ErkJggg==', 0, NULL, NULL, '1000', NULL, 0, '2022-11-29 14:21:31', '2022-11-29 14:21:31'),
(18, 2, 3, 10, '741674436792', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:40px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:50px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:76px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:92px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:124px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:136px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:8px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:164px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mOHDGXsbA36e88yfGc7znP9gw/Png73xAYZRqVGpUSmYFABNOWl4LorL/AAAAABJRU5ErkJggg==', 0, NULL, NULL, '1000', NULL, 0, '2022-11-29 14:21:31', '2022-11-29 14:21:31'),
(19, 2, 3, 10, '281859076855', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:32px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:38px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:52px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:62px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:84px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:94px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:104px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:120px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:140px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:148px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:168px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC5JREFUKJFj+Mx/+MNnfv7D9sxnDh84zHD4/Bl+gw9/PtgbH2AYlRqVGpWCSQEApbW0APMDglEAAAAASUVORK5CYII=', 0, NULL, NULL, '1000', NULL, 0, '2022-11-29 14:21:31', '2022-11-29 14:21:31'),
(20, 2, 3, 10, '161503403512', '<div style=\"font-size:0;position:relative;width:202px;height:30px;\">\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:0px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:6px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:12px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:22px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:28px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:36px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:44px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:48px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:58px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:66px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:72px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:78px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:88px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:98px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:102px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:110px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:118px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:126px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:132px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:136px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:144px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:154px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:160px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:172px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:176px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:6px;height:30px;position:absolute;left:186px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:2px;height:30px;position:absolute;left:194px;top:0\">&nbsp;</div>\n<div style=\"background-color:black;width:4px;height:30px;position:absolute;left:198px;top:0\">&nbsp;</div>\n</div>\n', 'iVBORw0KGgoAAAANSUhEUgAAAMoAAAAeAQMAAABXBBPSAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAC1JREFUKJFj+Mx/mP88zx8bg8MHPhgzMzOf+fDH5g/PB3vjAwyjUqNSo1IwKQC244LIdxvKPAAAAABJRU5ErkJggg==', 0, NULL, NULL, '1000', NULL, 0, '2022-11-29 14:21:31', '2022-11-29 14:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `stock_products`
--

CREATE TABLE `stock_products` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `product_description` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_products`
--

INSERT INTO `stock_products` (`id`, `stock_id`, `product_id`, `quantity`, `product_description`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 10, '', '2022-11-22 12:08:51', '2022-11-22 12:08:51'),
(2, 2, 3, 10, '', '2022-11-29 14:21:30', '2022-11-29 14:21:30');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bussiness_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_OCC_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_wa_same` tinyint(1) NOT NULL DEFAULT 0,
  `whatsapp` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_outstation` tinyint(1) NOT NULL DEFAULT 0,
  `billing_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_pin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_billing_shipping_same` tinyint(1) NOT NULL DEFAULT 0,
  `shipping_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_pin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visit_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_limit` int(11) DEFAULT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `no_order_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive, 2: pending\r\n',
  `created_from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `created_by` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='or customers';

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `user_id`, `store_name`, `slug`, `bussiness_name`, `store_OCC_number`, `email`, `contact`, `is_wa_same`, `whatsapp`, `address`, `lat`, `lng`, `area`, `state`, `city`, `pin`, `address_outstation`, `billing_address`, `billing_landmark`, `billing_state`, `billing_city`, `billing_pin`, `billing_country`, `is_billing_shipping_same`, `shipping_address`, `shipping_landmark`, `shipping_state`, `shipping_city`, `shipping_pin`, `shipping_country`, `gst_number`, `gst_file`, `visit_image`, `credit_limit`, `credit_days`, `no_order_reason`, `image`, `status`, `created_from`, `created_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Sundar Lal Seth', 'sample-store-1', 'Sundar Stores', NULL, 'sl.seth@gmail.com', '9876543213', 1, '9876543213', 'Plot-A1-4 Block EP &GP, 804, Street Number 23, GP Block, Sector V, Bidhannagar, Kolkata, West Bengal 700091, India', '22.5706249', '88.4324954', NULL, 'West Bengal', 'Kolkata', '700091', 0, 'Sodepur', 'Readymade Center', 'West Bengal', 'Kolkata', '700110', 'India', 1, 'Sodepur', 'Readymade Center', 'West Bengal', 'Kolkata', '700110', 'India', '45454545454545', 'uploads/store/1658230873.1396655948.gstfile-1.png', NULL, 1000000, 30, NULL, NULL, 1, 'admin', NULL, '2022-06-11 01:04:01', '2022-11-21 10:12:58'),
(2, NULL, 'Shyamal Sen', 'sample-store-1', 'Sen Stores', NULL, 's.sen@test.com', '9876543212', 1, '9876543212', 'Plot-A1-4 Block EP &GP, 804, Street Number 23, GP Block, Sector V, Bidhannagar, Kolkata, West Bengal 700091, India', '22.570943', '88.432554', NULL, 'West Bengal', 'Kolkata', '700091', 1, 'Bidhan Nagar', 'Airport', 'West Bengal', 'Kolkata', '700114', 'India', 1, 'Bidhan Nagar', 'Airport', 'West Bengal', 'Kolkata', '700114', 'India', '65656456', 'uploads/store/1658230938.700969406.gstfile-1.png', NULL, 1000000, 30, NULL, NULL, 1, 'admin', NULL, '2022-06-11 01:04:01', '2022-11-21 10:11:17'),
(3, NULL, 'Prakash Jain', 'sample-store-3', 'Jain Bhai Shop', NULL, 'p.jain02@test.com', '9876543211', 1, '9876543211', 'Plot-A1-4 Block EP &GP, 804, Street Number 23, GP Block, Sector V, Bidhannagar, Kolkata, West Bengal 700091, India', '22.570943', '88.432554', NULL, 'West Bengal', 'Kolkata', '700092', 0, 'Barrackpore', 'Station', 'West Bengal', 'Kolkata', '700110', 'India', 1, 'Barrackpore', 'Station', 'West Bengal', 'Kolkata', '700110', 'India', '767657567', 'uploads/store/1658230967.897813568.gstfile-1.png', NULL, 1000000, 30, NULL, NULL, 1, 'admin', NULL, '2022-07-11 01:04:01', '2022-11-21 10:10:18'),
(4, NULL, 'Jignesh Sethi', 'sample-store-4', 'JS Enterprise', NULL, 'jse@gmail.com', '9876543210', 1, '9876543210', 'Plot-A1-4 Block EP &GP, 804, Street Number 23, GP Block, Sector V, Bidhannagar, Kolkata, West Bengal 700091, India', '22.570943', '88.432554', NULL, 'West Bengal', 'Kolkata', '700093', 0, 'Bidhan Nagar', 'Block EP', 'West Bengal', 'Kolkata', '700114', 'India', 1, 'Bidhan Nagar', 'Block EP', 'West Bengal', 'Kolkata', '700114', 'India', '64654654', 'uploads/store/1658231043.1411377555.gstfile-1.png', NULL, 1000000, 30, NULL, NULL, 1, 'admin', NULL, '2022-07-11 01:04:01', '2022-11-21 10:08:14'),
(5, NULL, 'Mohan Agarwal', 'gdfgfgfgfg', 'Agarwal Stores', NULL, 'm.agarwal125@test.com', '9000343434', 1, '9000343434', 'H2QV+XPQ, Pocket 7, Sector 12 Dwarka, Dwarka, New Delhi, Delhi 110075, India', '28.5899619', '77.0443591', NULL, 'Delhi', 'New Delhi', '110075', 0, 'Dumdum', 'Station', 'West Bengal', 'Kolkata', '700110', 'India', 1, 'Dumdum', 'Station', 'West Bengal', 'Kolkata', '700110', 'India', '656546546', 'public/uploads/store/1668600773.1000396308.gstfile-1.png', NULL, 1000000, 30, NULL, NULL, 1, 'admin', NULL, '2022-07-14 08:32:21', '2022-11-21 10:08:56'),
(6, NULL, 'Ayan Banerjee', 'fggdfgdfgdfg', 'Banerjee House & Stores', NULL, 'ayan.b@test.com', '9843242342', 1, '9843242342', NULL, '', '', NULL, NULL, NULL, NULL, 1, 'Dumdum', 'Readymade Center', 'WB', 'Kolkata', '700111', 'India', 1, 'Dumdum', 'Readymade Center', 'WB', 'Kolkata', '700111', 'India', '534534534', 'uploads/store/1658230266.1665122259.gstfile-1.png', NULL, 1000000, 30, NULL, NULL, 1, 'admin', NULL, '2022-07-19 11:18:43', '2022-11-21 10:09:17'),
(7, NULL, 'Kamal Sharma', 'kamal', 'Kamal Enterprise', NULL, NULL, '7787687878', 0, '7787687878', NULL, '', '', NULL, NULL, NULL, NULL, 0, 'Sodepur', 'Readymade Center', 'West Bengal', 'Kolkata', '700114', 'India', 1, 'Sodepur', 'Readymade Center', 'West Bengal', 'Kolkata', '700114', 'India', NULL, '', NULL, NULL, NULL, NULL, NULL, 1, 'admin', 2, '2022-11-16 12:34:15', '2022-11-21 10:06:09'),
(8, NULL, 'Sample Store 10', 'sample-store-10', '', NULL, '', '9988787887', 1, '9988787887', NULL, '', '', NULL, NULL, NULL, NULL, 0, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', 0, 0, NULL, NULL, 2, 'staff', 3, '2022-12-07 11:34:18', '2022-12-07 11:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `store_visits`
--

CREATE TABLE `store_visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `start_date` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_latitude` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_longitude` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_distance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'in meter',
  `total_distance_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_ledger_added` int(1) NOT NULL DEFAULT 0,
  `convenience_per_km` double(10,2) NOT NULL,
  `staff_convenience_amount` double(10,2) NOT NULL,
  `visit_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_visits`
--

INSERT INTO `store_visits` (`id`, `user_id`, `store_id`, `start_date`, `start_time`, `end_date`, `end_time`, `type`, `comment`, `start_location`, `start_latitude`, `start_longitude`, `end_location`, `end_latitude`, `end_longitude`, `total_distance`, `total_distance_text`, `remarks`, `is_ledger_added`, `convenience_per_km`, `staff_convenience_amount`, `visit_image`, `created_at`, `updated_at`) VALUES
(1, 6, 4, '2022-12-12', '05:50', '2022-12-12', '18:00', NULL, NULL, 'Plot-A1-4 Block EP &GP, 804, Street Number 23, GP Block, Sector V, Bidhannagar, Kolkata, West Bengal 700091', '22.570943', '88.432554', 'Sector 5 Block EP, Bidhannagar 700091, West Bengal\nSector 5 Block EP Bidhannagar India', '22.5715764', '88.435611', '484', '0.484 km', NULL, 1, 0.00, 0.00, '', '2022-12-12 12:28:47', '2022-12-12 12:36:04');

-- --------------------------------------------------------

--
-- Table structure for table `store_visit_details`
--

CREATE TABLE `store_visit_details` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `distance_value` varchar(255) DEFAULT NULL,
  `distance` varchar(255) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_visit_details`
--

INSERT INTO `store_visit_details` (`id`, `visit_id`, `latitude`, `longitude`, `distance_value`, `distance`, `created_at`, `updated_at`) VALUES
(1, 1, '22.570943', '88.432554', NULL, '0', '2022-12-12 17:58:47', '2022-12-12 17:58:47'),
(2, 1, '22.5706829', '88.4327069', '18', '18 m', '2022-12-12 18:00:12', '2022-12-12 18:00:12'),
(3, 1, '22.5706978', '88.4333667', '150', '0.2 km', '2022-12-12 18:01:37', '2022-12-12 18:01:37'),
(4, 1, '22.5707034', '88.4351396', '202', '0.2 km', '2022-12-12 18:02:28', '2022-12-12 18:02:28'),
(5, 1, '22.5709504', '88.4353334', '39', '39 m', '2022-12-12 18:02:59', '2022-12-12 18:02:59'),
(6, 1, '22.5712836', '88.4355071', '41', '41 m', '2022-12-12 18:03:28', '2022-12-12 18:03:28'),
(7, 1, '22.5715764', '88.435611', '34', '34 m', '2022-12-12 18:03:50', '2022-12-12 18:03:50'),
(8, 1, '22.5715764', '88.435611', '0', '1 m', '2022-12-12 18:06:03', '2022-12-12 18:06:03');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_mails`
--

CREATE TABLE `subscription_mails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `cat_id`, `name`, `image_path`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sub category 1', 'uploads/sub-category/1653386718.img2.jpg', 'sub-category-1', 'This is sub category 1', 1, '2022-05-24 04:35:18', '2022-08-11 06:23:32'),
(2, 2, 'Mobile Phones', 'uploads/sub-category/1657007584.dummy.png', 'mobile-phones', NULL, 1, '2022-07-05 02:23:04', '2022-07-05 02:23:04'),
(3, 2, 'Laptops', 'uploads/sub-category/1657007596.dummy.png', 'laptops', NULL, 1, '2022-07-05 02:23:16', '2022-07-05 02:23:16'),
(4, 2, 'Headphones', 'uploads/sub-category/1657007608.dummy.png', 'headphones', NULL, 1, '2022-07-05 02:23:28', '2022-07-05 02:23:28'),
(5, 2, 'Earbuds', 'uploads/sub-category/1657173422.images.jpeg', 'earbuds', NULL, 1, '2022-07-07 00:27:02', '2022-07-13 08:30:38'),
(6, 2, 'Data Cables', 'uploads/sub-category/1657173501.images.jpeg', 'data-cables', 'Data Cables', 1, '2022-07-07 00:28:21', '2022-07-07 00:28:21'),
(7, 3, 'Bakery and Bread', 'uploads/sub-category/1657708473.images.jpeg', 'bakery-and-bread', NULL, 1, '2022-07-13 10:34:33', '2022-07-13 10:34:33'),
(8, 3, 'Meat and Seafood.', 'uploads/sub-category/1659340932.145760656.meat-n-seafood.png', 'meat-and-seafood-2', NULL, 1, '2022-07-13 10:34:48', '2022-08-01 08:02:12'),
(9, 3, 'Pasta and Rice', 'uploads/sub-category/1659340883.1027016326.pasta-n-rice.jpg', 'pasta-and-rice-2', NULL, 1, '2022-07-13 10:35:01', '2022-08-01 08:01:23'),
(10, 3, 'Oils, Sauces, Salad Dressings, and Condiments.', 'uploads/sub-category/1659340841.1943268974.oil-sauce-salad.jpeg', 'oils-sauces-salad-dressings-and-condiments-2', NULL, 1, '2022-07-13 10:35:15', '2022-08-01 08:00:41'),
(11, 3, 'Cereals and Breakfast Foods.', 'uploads/sub-category/1659340789.931944161.Cereals.jpg', 'cereals-and-breakfast-foods-2', NULL, 1, '2022-07-13 10:35:34', '2022-08-11 06:28:20'),
(12, 3, 'Soups and Canned Goods', 'uploads/sub-category/1659340749.559822031.soups.jpg', 'soups-and-canned-goods-2', NULL, 1, '2022-07-13 10:35:48', '2022-08-11 06:28:19'),
(13, 3, 'Frozen Foods.', 'uploads/sub-category/1659340711.1335780877.frozen-food.jpg', 'frozen-foods-2', NULL, 1, '2022-07-13 10:36:07', '2022-08-11 06:28:17'),
(14, 3, 'Dairy, Cheese, and Eggs.', 'uploads/sub-category/1659340663.1917263425.dairy.png', 'dairy-cheese-and-eggs', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2022-07-13 10:36:20', '2022-08-11 06:26:18'),
(15, 1, 'Test Sub Category', '', 'test-sub-category', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, '2022-08-11 06:22:58', '2022-08-11 06:26:11'),
(16, 2, 'Power Tool', '', 'power-tool', NULL, 1, '2022-09-22 12:27:20', '2022-09-22 12:27:20');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` bigint(20) DEFAULT NULL,
  `is_wa_same` tinyint(1) NOT NULL DEFAULT 0,
  `whatsapp_no` bigint(20) DEFAULT NULL,
  `billing_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_pin` int(11) DEFAULT NULL,
  `billing_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_pin` int(11) DEFAULT NULL,
  `shipping_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_billing_shipping_same` tinyint(1) NOT NULL DEFAULT 0,
  `gst_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_limit` int(11) DEFAULT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0 COMMENT '1: verified, 0: not verified',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `mobile`, `is_wa_same`, `whatsapp_no`, `billing_address`, `billing_landmark`, `billing_state`, `billing_city`, `billing_pin`, `billing_country`, `shipping_address`, `shipping_landmark`, `shipping_state`, `shipping_city`, `shipping_pin`, `shipping_country`, `is_billing_shipping_same`, `gst_number`, `gst_file`, `credit_limit`, `credit_days`, `email_verified_at`, `is_verified`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ARNAB SUPPLIER', NULL, 8962200000, 1, 8962200000, 'Sodepur', 'Readymade Center', 'West Bengal', 'Kolkata', 700114, 'India', 'Sodepur', 'Readymade Center', 'West Bengal', 'Kolkata', 700114, 'India', 1, '12213231', 'public/uploads/user/1669098839.gstfile-1.png', NULL, NULL, NULL, 0, 1, NULL, '2022-11-22 06:33:59', '2022-11-22 06:33:59');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 6, '2022-12-11', '2022-12-17', '2022-12-12 12:26:03', '2022-12-12 12:26:03');

-- --------------------------------------------------------

--
-- Table structure for table `task_details`
--

CREATE TABLE `task_details` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `no_of_visit` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_details`
--

INSERT INTO `task_details` (`id`, `task_id`, `store_id`, `no_of_visit`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, NULL, '2022-12-12 17:56:03', '2022-12-12 17:56:03');

-- --------------------------------------------------------

--
-- Table structure for table `test_cron`
--

CREATE TABLE `test_cron` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT '',
  `value` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'unit value',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:Active;0:Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `description`, `value`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Pieces', 'Pieces', 'pieces', 1, '2022-06-17 02:01:31', '2022-08-08 08:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `whatsapp_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_wa_same` tinyint(1) NOT NULL DEFAULT 0,
  `mobile` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aadhar_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1:Admin(Partner);2:Staff(Any)' COMMENT '1:Staff',
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id_back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id_front` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_limit` int(11) DEFAULT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `designation` int(11) NOT NULL DEFAULT 1,
  `account_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'banking cred',
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'banking cred',
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'banking cred',
  `bank_account_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'banking cred',
  `ifsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'banking cred',
  `monthly_salary` double(10,2) DEFAULT NULL COMMENT 'salary & allowance',
  `daily_salary` double(10,2) DEFAULT NULL COMMENT 'salary & allowance',
  `travelling_allowance` double(10,2) DEFAULT NULL COMMENT 'salary & allowance',
  `is_verified` int(11) NOT NULL DEFAULT 0 COMMENT '1: verified, 0: not verified',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `admin_id`, `whatsapp_no`, `is_wa_same`, `mobile`, `address`, `landmark`, `state`, `city`, `pin`, `country`, `aadhar_no`, `pan_no`, `type`, `otp`, `image`, `gst_number`, `gst_file`, `user_id_back`, `user_id_front`, `credit_limit`, `credit_days`, `designation`, `account_holder_name`, `bank_name`, `branch_name`, `bank_account_no`, `ifsc`, `monthly_salary`, `daily_salary`, `travelling_allowance`, `is_verified`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Abhinav Gupta', 'fortunetools570@yandex.com', '$2y$10$fdGD3yrhs/u/BCXDl22HgOT/kJM2KVE1sEN.mD5.6BA9sXV2KAYiC', NULL, 0, '9674030434', 1, '9674030434', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '1', '1234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2022-11-15 09:32:27', '2022-11-16 06:31:52'),
(2, 'Mayank Gupta', 'trgtoolspvtltd@gmail.com', '$2y$10$1Sh/2uI2H5FIp/w43gFn3.PIn.euZCYAwOa4YcwVZi0C2W1UKMjze', NULL, 0, '9674905534', 1, '9674905534', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2022-11-15 09:32:27', '2022-11-15 10:36:22'),
(3, 'A Jaiswal', NULL, '$2y$10$/0eO4wXDdJ9rsgqrFxMWQeo4lxwsElZA3lOgsgb/J8h8toDiMNnBO', NULL, 0, '8989989989', 1, '8989989989', 'Salt Lake', 'City Centre', 'West Bengal', 'Kolkata', '434', '23423', '43434', NULL, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'A J', 'Axis', 'Salt Lake', '43234', '433243', 15000.00, 500.00, NULL, 0, 1, '2022-11-15 12:54:49', '2022-11-15 13:15:33'),
(4, 'Prabir', 'prabir@gmail.com', '$2y$10$lA1Gt6YEeSjK83zUpa47m.VoTQ8ZE6hacrIcQNwXFHqQ9uRrnbCtK', NULL, 0, '8565656566', 1, '8565656566', 'Baguiati', 'Baguiati', 'West Bengal', 'Kolkata', '700114', 'India', '323232323', NULL, '2', NULL, 'uploads/staff/1668517814.1614726356.maxresdefault.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 3, 'Prabir D', 'Canara Bank', 'Bidhan Nagar', '2112121212', '43434', 35000.00, 1166.67, 0.00, 0, 1, '2022-11-15 13:09:44', '2022-11-15 13:15:36'),
(5, 'Sourav P', NULL, '$2y$10$vwlMAuDhhtrKHOoGkv8gcOHB9VWOFVrONG7n1lmB588e8qqEywgmm', NULL, 0, '8984323323', 1, '8984323323', 'Baguiati', 'Baguiati', 'West Bengal', 'Kolkata', '700110', 'India', '32323', NULL, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'Sourav Paul', 'Axis Bank', 'Salt Lake', '121212', '32323', 35000.00, 1166.67, 0.00, 0, 1, '2022-11-15 13:12:21', '2022-11-15 13:15:38'),
(6, 'Shreyan Das', NULL, '$2y$10$fdGD3yrhs/u/BCXDl22HgOT/kJM2KVE1sEN.mD5.6BA9sXV2KAYiC', NULL, 0, '7887878787', 1, '7887878787', 'Salt Lake', 'Salt Lake', 'West Bengal', 'Kolkata', '700114', 'India', '4343243434', NULL, '2', '1234', 'uploads/staff/1668593597.741583816.1653544138.id-card-1.jpg', NULL, NULL, 'uploads/staff/1668518089.Aadhaar_card.jpg', 'uploads/staff/1668518089.aadhar-front.jpg', NULL, NULL, 1, 'Shreyan D', 'Axis Bank', 'Salt Lake', '423432434', '343434', 25000.00, 833.33, 0.00, 0, 1, '2022-11-15 13:14:49', '2022-11-16 10:13:17'),
(7, 'Manoj Sharma', NULL, '$2y$10$oNXzQZ4JNjWFziU1MjQ4o.EWd7nQXKPQb16Fa45EkBXKqpK0J1rkO', NULL, 0, '8888888888', 1, '8888888888', 'Kolkata, Salt Lake', 'City Centre', 'West Bengal', 'Kolkata', '700007', 'India', '4343434', NULL, '2', '1234', 'public/uploads/staff/1668600005.1194059894.maxresdefault.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 5, 'Manoj Sharma', 'Axis Bank', 'Salt Lake', '3232323', '323232', 20000.00, 666.67, 0.00, 0, 1, '2022-11-16 06:46:43', '2022-11-16 12:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `users_old`
--

CREATE TABLE `users_old` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `official_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_wa_same` tinyint(1) NOT NULL DEFAULT 0,
  `mobile` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aadhar_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT '1:Staff',
  `dob` date DEFAULT NULL,
  `anniversary_date` date DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id_back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id_front` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_limit` int(11) DEFAULT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `designation` int(11) NOT NULL DEFAULT 1,
  `bank_account_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'banking cred',
  `ifsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'banking cred',
  `account_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'banking cred',
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'banking cred',
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'banking cred',
  `monthly_salary` double(10,2) NOT NULL,
  `daily_salary` double(10,2) NOT NULL,
  `travelling_allowance` double(10,2) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0 COMMENT '1: verified, 0: not verified',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1: active, 0: inactive',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_old`
--

INSERT INTO `users_old` (`id`, `name`, `fname`, `lname`, `alias`, `official_name`, `business_name`, `email`, `employee_id`, `whatsapp_no`, `is_wa_same`, `mobile`, `email_verified_at`, `password`, `address`, `landmark`, `state`, `city`, `pin`, `country`, `aadhar_no`, `pan_no`, `type`, `dob`, `anniversary_date`, `otp`, `image`, `gender`, `social_id`, `gst_number`, `gst_file`, `user_id_back`, `user_id_front`, `credit_limit`, `credit_days`, `designation`, `bank_account_no`, `ifsc`, `account_holder_name`, `bank_name`, `branch_name`, `monthly_salary`, `daily_salary`, `travelling_allowance`, `is_verified`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(8, 'Staff One', NULL, NULL, 'staff1', 'staff1', NULL, 'staff1@user.com', NULL, '7845999661', 0, '7845999661', NULL, '$2y$10$nJdffrROX7rGXdbX56SFCuamVeBJCKeJHryJ9Na.84u6GT/LA.QKO', 'Kolkata, sector v', 'Bidhanagar', 'West Bengal', 'Kolkata', '700091', 'India', '187455612478', NULL, '1', NULL, NULL, '1234', 'uploads/staff/1660126766.835044712.maxresdefault.jpg', NULL, NULL, NULL, NULL, 'uploads/staff/1660126766.1719210516.Aadhaar_card.jpg', 'uploads/staff/1660126766.1592839510.aadhar-front.jpg', NULL, NULL, 1, '5689784561', NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0, 1, NULL, '2022-05-26 00:30:04', '2022-08-16 10:37:51'),
(11, 'Staff Two', NULL, NULL, 'staff2', 'staff2', NULL, 'staff2@user.com', NULL, '7845999662', 0, '7845999662', NULL, '$2y$10$nJdffrROX7rGXdbX56SFCuamVeBJCKeJHryJ9Na.84u6GT/LA.QKO', 'Kolkata, sector v', 'Bidhanagar', 'West Bengal', 'Kolkata', '700091', 'India', '187455612478', NULL, '1', NULL, NULL, '1234', 'uploads/user/1653544804.default-user-image.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '5689784561', NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0, 1, NULL, '2022-05-26 00:30:04', '2022-08-16 10:36:04'),
(21, 'Staff Three', NULL, NULL, 'staff3', 'Staff 3', NULL, 'staff3@user.com', NULL, '9856666666', 0, '9856666666', NULL, '$2y$10$MHqBLoBnlHwlAbY5/tikIewVPb8CZT0hUcdOCe0Izkacjo1vVLOCS', '2121', '2121', '1212', '1212', '21212', '1212', '32323232323', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '12220000', NULL, NULL, NULL, NULL, 0.00, 0.00, 0.00, 0, 1, NULL, '2022-07-06 23:45:15', '2022-08-16 10:31:41'),
(22, 'Test Staff', NULL, NULL, 'teststaff', 'teststaff', NULL, NULL, NULL, '4554545454', 1, '4554545454', NULL, '$2y$10$dkwSqV9qwkiyL9sl5gydE.ck1VHUchSersnR/DyLf7/zpsmXIYVzy', '800', '506', '485', '954', '94', '476', '5345345345', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, '5543543545', '33434', NULL, NULL, NULL, 0.00, 0.00, 0.00, 0, 1, NULL, '2022-08-05 05:44:23', '2022-08-18 06:54:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_attendances`
--

CREATE TABLE `user_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `mac_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_distance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'in meter	',
  `total_distance_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_attendances`
--

INSERT INTO `user_attendances` (`id`, `user_id`, `mac_address`, `start_date`, `start_time`, `end_date`, `end_time`, `start_location`, `start_latitude`, `start_longitude`, `end_location`, `end_latitude`, `end_longitude`, `total_distance`, `total_distance_text`, `created_at`, `updated_at`) VALUES
(1, 6, NULL, '2022-12-12', '05:50', '2022-12-12', '18:00', 'Plot-A1-4 Block EP &GP, 804, Street Number 23, GP Block, Sector V, Bidhannagar, Kolkata, West Bengal 700091', '22.570943', '88.432554', 'Sector 5 Block EP, Bidhannagar 700091, West Bengal\r\nSector 5 Block EP Bidhannagar India', '22.5715764', '88.435611', '484', '0.484 km', '2022-12-15 06:48:13', '2022-12-15 06:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_noorderreasons`
--

CREATE TABLE `user_noorderreasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visit_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_noorderreasons`
--

INSERT INTO `user_noorderreasons` (`id`, `store_id`, `user_id`, `comment`, `location`, `lat`, `lng`, `visit_image`, `created_at`, `updated_at`) VALUES
(1, 7, 3, 'Not interested in placing order at the moment', 'Burrabazar', '80.2564798', '52.2314583', 'public/uploads/store/1669033900.maxresdefault.jpg', '2022-11-21 12:31:40', '2022-11-21 12:31:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL DEFAULT 0,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `designation_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 3, 6, '2022-11-15 16:59:14', '2022-11-15 16:59:14'),
(2, 3, 8, '2022-11-15 16:59:14', '2022-11-15 16:59:14'),
(3, 3, 10, '2022-11-15 16:59:14', '2022-11-15 16:59:14'),
(19, 2, 8, '2022-11-16 15:29:03', '2022-11-16 15:29:03'),
(20, 2, 6, '2022-11-16 15:29:03', '2022-11-16 15:29:03'),
(21, 3, 2, '2022-11-16 15:44:52', '2022-11-16 15:44:52'),
(22, 3, 1, '2022-11-16 15:44:52', '2022-11-16 15:44:52'),
(23, 3, 5, '2022-11-16 15:44:53', '2022-11-16 15:44:53'),
(24, 3, 4, '2022-11-16 15:44:53', '2022-11-16 15:44:53'),
(26, 3, 9, '2022-11-16 15:44:53', '2022-11-16 15:44:53'),
(27, 3, 7, '2022-11-16 15:44:53', '2022-11-16 15:44:53'),
(28, 3, 3, '2022-11-16 15:44:53', '2022-11-16 15:44:53'),
(29, 3, 11, '2022-11-21 10:19:34', '2022-11-21 10:19:34'),
(30, 11, 9, '2022-12-06 16:35:13', '2022-12-06 16:35:13'),
(31, 11, 6, '2022-12-06 16:35:13', '2022-12-06 16:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawls`
--

CREATE TABLE `withdrawls` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `entry_date` date DEFAULT NULL,
  `withdrawable_percentage` varchar(255) NOT NULL DEFAULT '30' COMMENT 'as per settings',
  `withdrawl_amount` double(10,2) NOT NULL,
  `reserved_amount` double(10,2) NOT NULL,
  `withdrawable_amount` double(10,2) NOT NULL,
  `required_amount` double(10,2) NOT NULL COMMENT 'withdrawable_amount-withdrawl_amount',
  `net_profit` double(10,2) NOT NULL,
  `net_profit_margin` varchar(255) NOT NULL,
  `profit_in_hand` double(10,2) NOT NULL,
  `is_disbursed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='partner withdrawls and requests';

-- --------------------------------------------------------

--
-- Table structure for table `_wishlists`
--

CREATE TABLE `_wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `product_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_locations`
--
ALTER TABLE `attendance_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_lists`
--
ALTER TABLE `bank_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_parents`
--
ALTER TABLE `category_parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_products`
--
ALTER TABLE `invoice_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `no_order_reasons`
--
ALTER TABLE `no_order_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_cancelled_products`
--
ALTER TABLE `order_cancelled_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packing_slip`
--
ALTER TABLE `packing_slip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packing_slip_boxes`
--
ALTER TABLE `packing_slip_boxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_collections`
--
ALTER TABLE `payment_collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_threshold_request`
--
ALTER TABLE `product_threshold_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order_archived_boxes`
--
ALTER TABLE `purchase_order_archived_boxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order_boxes`
--
ALTER TABLE `purchase_order_boxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_slip`
--
ALTER TABLE `service_slip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `set_product_ctns_pcs_ps`
--
ALTER TABLE `set_product_ctns_pcs_ps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_commision`
--
ALTER TABLE `staff_commision`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_salary`
--
ALTER TABLE `staff_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_boxes`
--
ALTER TABLE `stock_boxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_products`
--
ALTER TABLE `stock_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `whatsapp` (`whatsapp`);

--
-- Indexes for table `store_visits`
--
ALTER TABLE `store_visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_visit_details`
--
ALTER TABLE `store_visit_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_mails`
--
ALTER TABLE `subscription_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `whatsapp_no` (`whatsapp_no`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_details`
--
ALTER TABLE `task_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_cron`
--
ALTER TABLE `test_cron`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `users_old`
--
ALTER TABLE `users_old`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `whatsapp_no` (`whatsapp_no`);

--
-- Indexes for table `user_attendances`
--
ALTER TABLE `user_attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_noorderreasons`
--
ALTER TABLE `user_noorderreasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawls`
--
ALTER TABLE `withdrawls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_wishlists`
--
ALTER TABLE `_wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_locations`
--
ALTER TABLE `attendance_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bank_lists`
--
ALTER TABLE `bank_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category_parents`
--
ALTER TABLE `category_parents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoice_products`
--
ALTER TABLE `invoice_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `journal`
--
ALTER TABLE `journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `no_order_reasons`
--
ALTER TABLE `no_order_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_cancelled_products`
--
ALTER TABLE `order_cancelled_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `packing_slip`
--
ALTER TABLE `packing_slip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `packing_slip_boxes`
--
ALTER TABLE `packing_slip_boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_collections`
--
ALTER TABLE `payment_collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_threshold_request`
--
ALTER TABLE `product_threshold_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_order_archived_boxes`
--
ALTER TABLE `purchase_order_archived_boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_boxes`
--
ALTER TABLE `purchase_order_boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `service_slip`
--
ALTER TABLE `service_slip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `set_product_ctns_pcs_ps`
--
ALTER TABLE `set_product_ctns_pcs_ps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `staff_commision`
--
ALTER TABLE `staff_commision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_salary`
--
ALTER TABLE `staff_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_boxes`
--
ALTER TABLE `stock_boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `stock_products`
--
ALTER TABLE `stock_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `store_visits`
--
ALTER TABLE `store_visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_visit_details`
--
ALTER TABLE `store_visit_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subscription_mails`
--
ALTER TABLE `subscription_mails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_details`
--
ALTER TABLE `task_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `test_cron`
--
ALTER TABLE `test_cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_old`
--
ALTER TABLE `users_old`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_attendances`
--
ALTER TABLE `user_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_noorderreasons`
--
ALTER TABLE `user_noorderreasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `withdrawls`
--
ALTER TABLE `withdrawls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `_wishlists`
--
ALTER TABLE `_wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
