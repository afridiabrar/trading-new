-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 14, 2021 at 11:47 AM
-- Server version: 10.3.31-MariaDB-log-cll-lve
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `custmayi_rchive`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_role_id` bigint(20) NOT NULL DEFAULT 2,
  `image` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'def.png',
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `phone`, `admin_role_id`, `image`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Muhammad Shahab', '03453368866', 1, 'def.png', 'shahab@inoviotech.com', NULL, '$2y$10$9OsUdaR6UyxVtZz6Ln9Zo.7vDp.zgQRYcmtqu9OFVX47qi5XgPENi', NULL, '2021-09-07 22:19:37', '2021-09-07 22:19:37'),
(2, 'Muhammad Shahab', '03453368866', 7, '2021-09-07-61377b8a5c5d3.png', 'shahab@sharklasers.com', NULL, '$2y$10$A.hmXiFcFcklTiM0TLlh7OCCx3Aj9vRagr3kMG6xy9JrNR0shzhN.', NULL, '2021-09-08 00:47:38', '2021-09-08 00:57:47'),
(3, 'William', '123456789', 7, '2021-09-09-613a3ffb4624b.png', 'william@rchive.com', NULL, '$2y$10$YvkbF57T.nNMEz.F/Ok/0eHcXnIoZKmLJ2t.klCOiwB0wHUtzaOD.', NULL, '2021-09-10 03:10:19', '2021-09-10 03:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_access` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `module_access`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Master Admin', NULL, 1, NULL, NULL),
(7, 'Sub Admin', '[\"product\"]', 1, '2021-09-08 00:46:28', '2021-09-08 01:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `admin_wallets`
--

CREATE TABLE `admin_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `withdrawn` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_wallets`
--

INSERT INTO `admin_wallets` (`id`, `admin_id`, `balance`, `withdrawn`, `created_at`, `updated_at`) VALUES
(1, 1, 214.8, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_wallet_histories`
--

CREATE TABLE `admin_wallet_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `payment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'received',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Size', '2021-09-14 02:45:01', '2021-09-14 02:45:01'),
(2, 'Tagline', '2021-09-14 19:52:06', '2021-09-14 19:52:06'),
(3, 'Condition', '2021-09-14 19:52:25', '2021-09-14 19:52:25');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'def.png',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Air', '2021-09-14-6140709dbdb5a.png', 1, '2021-09-14 19:51:25', '2021-09-14 19:51:25'),
(2, 'Jordan', '2021-09-14-614070ab49b2e.png', 1, '2021-09-14 19:51:39', '2021-09-14 19:51:39'),
(3, 'Palm', '2021-09-14-614070b5cc756.png', 1, '2021-09-14 19:51:49', '2021-09-14 19:51:49');

-- --------------------------------------------------------

--
-- Table structure for table `business_settings`
--

CREATE TABLE `business_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_settings`
--

INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'system_default_currency', '1', '2020-10-11 16:43:44', '2021-06-05 03:25:29'),
(2, 'language', '[{\"id\":\"1\",\"name\":\"english\",\"code\":\"en\",\"status\":1},{\"id\":4,\"name\":\"Hindi\",\"code\":\"hn\",\"status\":0}]', '2020-10-11 16:53:02', '2021-09-07 22:34:42'),
(3, 'mail_config', '{\"name\":\"Rechive\",\"host\":\"smtp.mailtrap.io\",\"driver\":\"smtp\",\"port\":\"2525\",\"username\":\"55b7452773998a\",\"email_id\":\"info@rchive.pk\",\"encryption\":\"tls\",\"password\":\"6e6999eeaac74f\"}', '2020-10-12 19:29:18', '2021-09-09 22:17:24'),
(4, 'cash_on_delivery', '{\"status\":\"1\"}', NULL, '2021-05-26 06:21:15'),
(6, 'ssl_commerz_payment', '{\"status\":\"0\",\"store_id\":null,\"store_password\":null}', '2020-11-09 18:36:51', '2021-07-06 21:29:46'),
(7, 'paypal', '{\"status\":\"0\",\"paypal_client_id\":null,\"paypal_secret\":null}', '2020-11-09 18:51:39', '2021-07-06 21:29:57'),
(8, 'stripe', '{\"status\":\"0\",\"api_key\":null,\"published_key\":null}', '2020-11-09 19:01:47', '2021-07-06 21:30:05'),
(9, 'paytm', '{\"status\":\"0\",\"paytm_merchant_id\":\"dbzfb\",\"paytm_merchant_key\":\"sdfbsdfb\",\"paytm_merchant_website\":\"dsfbsdf\",\"paytm_channel\":\"sdfbsdf\",\"paytm_industry_type\":\"sdfb\"}', '2020-11-09 19:19:08', '2020-11-09 19:19:56'),
(10, 'company_phone', '+88017 33 66 88 44', NULL, '2020-12-09 00:15:01'),
(11, 'company_name', 'Rchive', NULL, '2021-02-28 04:11:53'),
(12, 'company_web_logo', '2021-09-09-613a2e5215b89.png', NULL, '2021-09-10 01:54:58'),
(13, 'company_mobile_logo', '2021-02-20-6030c88c91911.png', NULL, '2021-02-21 00:30:04'),
(14, 'terms_condition', '<p>eeverferfervtsS</p>', NULL, '2021-06-11 10:51:36'),
(15, 'about_us', '<p>this is about us page. hello and hi from about page description..</p>', NULL, '2021-06-11 10:42:53'),
(16, 'sms_nexmo', '{\"status\":\"0\",\"nexmo_key\":\"custo5cc042f7abf4c\",\"nexmo_secret\":\"custo5cc042f7abf4c@ssl\"}', NULL, NULL),
(17, 'company_email', 'info@rchive.com', NULL, '2021-09-10 01:57:50'),
(18, 'colors', '{\"primary\":\"#86b672\",\"secondary\":\"#061fe0\"}', '2020-10-11 22:53:02', '2021-05-26 06:43:11'),
(19, 'company_footer_logo', '2021-02-20-6030c8a02a5f9.png', NULL, '2021-02-21 00:30:24'),
(20, 'company_copyright_text', '2021', NULL, '2021-09-10 01:57:09'),
(21, 'download_app_apple_stroe', '{\"status\":\"1\",\"link\":\"https:\\/\\/www.target.com\\/s\\/apple+store++now?ref=tgt_adv_XS000000&AFID=msn&fndsrc=tgtao&DFA=71700000012505188&CPNG=Electronics_Portable+Computers&adgroup=Portable+Computers&LID=700000001176246&LNM=apple+store+near+me+now&MT=b&network=s&device=c&location=12&targetid=kwd-81913773633608:loc-12&ds_rl=1246978&ds_rl=1248099&gclsrc=ds\"}', NULL, '2021-09-10 01:59:53'),
(22, 'download_app_google_stroe', '{\"status\":\"0\",\"link\":\"https:\\/\\/play.google.com\\/store?hl=en_US&gl=US\"}', NULL, '2021-09-10 01:59:48'),
(23, 'company_fav_icon', '2021-03-02-603df1634614f.png', '2020-10-11 22:53:02', '2021-03-03 00:03:48'),
(24, 'fcm_topic', '', NULL, NULL),
(25, 'fcm_project_id', '', NULL, NULL),
(26, 'push_notification_key', 'Put your firebase server key here.', NULL, NULL),
(27, 'order_pending_message', '{\"status\":\"1\",\"message\":\"order pen message\"}', NULL, NULL),
(28, 'order_confirmation_msg', '{\"status\":\"1\",\"message\":\"Order con Message\"}', NULL, NULL),
(29, 'order_processing_message', '{\"status\":\"1\",\"message\":\"Order pro Message\"}', NULL, NULL),
(30, 'out_for_delivery_message', '{\"status\":\"1\",\"message\":\"Order ouut Message\"}', NULL, NULL),
(31, 'order_delivered_message', '{\"status\":\"1\",\"message\":\"Order del Message\"}', NULL, NULL),
(32, 'razor_pay', '{\"status\":\"0\",\"razor_key\":null,\"razor_secret\":null}', NULL, '2021-07-06 21:30:14'),
(33, 'sales_commission', '0', NULL, '2021-06-12 03:13:13'),
(34, 'seller_registration', '0', NULL, '2021-09-07 22:36:15'),
(35, 'pnc_language', '[\"en\",\"af\"]', NULL, NULL),
(36, 'order_returned_message', '{\"status\":\"1\",\"message\":\"Order hh Message\"}', NULL, NULL),
(37, 'order_failed_message', '{\"status\":null,\"message\":\"Order fa Message\"}', NULL, NULL),
(40, 'delivery_boy_assign_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(41, 'delivery_boy_start_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(42, 'delivery_boy_delivered_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(43, 'terms_and_conditions', '', NULL, NULL),
(44, 'minimum_order_value', '1', NULL, NULL),
(45, 'privacy_policy', '<p>my privacy policy</p>\r\n\r\n<p>&nbsp;</p>', NULL, '2021-07-06 20:09:07'),
(46, 'paystack', '{\"status\":\"0\",\"publicKey\":null,\"secretKey\":null,\"paymentUrl\":\"https:\\/\\/api.paystack.co\",\"merchantEmail\":null}', NULL, '2021-07-06 21:30:35'),
(47, 'senang_pay', '{\"status\":\"0\",\"secret_key\":null,\"merchant_id\":null}', NULL, '2021-07-06 21:30:23'),
(48, 'maintenance_mode', '0', '2021-09-08 01:47:56', '2021-09-08 20:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `home_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `parent_id`, `position`, `created_at`, `updated_at`, `home_status`) VALUES
(1, 'Men', 'men', 'def.png', 0, 0, '2021-09-14 02:40:42', '2021-09-14 02:44:05', 1),
(2, 'Women', 'women', 'def.png', 0, 0, '2021-09-14 02:40:46', '2021-09-14 02:40:46', 0),
(3, 'Style', 'style', 'def.png', 0, 0, '2021-09-14 02:40:50', '2021-09-14 02:40:50', 0),
(4, 'Accessories', 'accessories', NULL, 1, 1, '2021-09-14 02:41:04', '2021-09-14 02:41:04', 0),
(5, 'Tops', 'tops', NULL, 1, 1, '2021-09-14 02:41:08', '2021-09-14 02:41:08', 0),
(6, 'Bottoms', 'bottoms', NULL, 1, 1, '2021-09-14 02:41:12', '2021-09-14 02:41:12', 0),
(7, 'Caps', 'caps', NULL, 1, 1, '2021-09-14 02:41:16', '2021-09-14 02:41:16', 0),
(9, 'Shoes', 'shoes', NULL, 1, 1, '2021-09-14 02:41:45', '2021-09-14 02:41:45', 0),
(10, 'Accessories', 'accessories', NULL, 2, 1, '2021-09-14 02:41:55', '2021-09-14 02:41:55', 0),
(11, 'Tops', 'tops', NULL, 2, 1, '2021-09-14 02:42:01', '2021-09-14 02:42:01', 0),
(12, 'Bottoms', 'bottoms', NULL, 2, 1, '2021-09-14 02:42:07', '2021-09-14 02:42:07', 0),
(13, 'Outerwear', 'outerwear', NULL, 2, 1, '2021-09-14 02:42:15', '2021-09-14 02:42:15', 0),
(14, 'Shoes', 'shoes', NULL, 2, 1, '2021-09-14 02:42:20', '2021-09-14 02:42:20', 0),
(15, 'Vintage', 'vintage', NULL, 3, 1, '2021-09-14 02:42:26', '2021-09-14 02:42:26', 0),
(16, 'Modest', 'modest', NULL, 3, 1, '2021-09-14 02:42:30', '2021-09-14 02:42:30', 0),
(17, 'Streetwear', 'streetwear', NULL, 3, 1, '2021-09-14 02:42:44', '2021-09-14 02:42:44', 0),
(18, 'Designer', 'designer', NULL, 3, 1, '2021-09-14 02:42:51', '2021-09-14 02:42:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `chattings`
--

CREATE TABLE `chattings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `seller_id` bigint(20) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_by_customer` tinyint(1) NOT NULL DEFAULT 0,
  `sent_by_seller` tinyint(1) NOT NULL DEFAULT 0,
  `seen_by_customer` tinyint(1) NOT NULL DEFAULT 1,
  `seen_by_seller` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shop_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'IndianRed', '#CD5C5C', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(2, 'LightCoral', '#F08080', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(3, 'Salmon', '#FA8072', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(4, 'DarkSalmon', '#E9967A', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(5, 'LightSalmon', '#FFA07A', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(6, 'Crimson', '#DC143C', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(7, 'Red', '#FF0000', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(8, 'FireBrick', '#B22222', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(9, 'DarkRed', '#8B0000', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(10, 'Pink', '#FFC0CB', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(11, 'LightPink', '#FFB6C1', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(12, 'HotPink', '#FF69B4', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(13, 'DeepPink', '#FF1493', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(14, 'MediumVioletRed', '#C71585', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(15, 'PaleVioletRed', '#DB7093', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(16, 'LightSalmon', '#FFA07A', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(17, 'Coral', '#FF7F50', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(18, 'Tomato', '#FF6347', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(19, 'OrangeRed', '#FF4500', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(20, 'DarkOrange', '#FF8C00', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(21, 'Orange', '#FFA500', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(22, 'Gold', '#FFD700', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(23, 'Yellow', '#FFFF00', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(24, 'LightYellow', '#FFFFE0', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(25, 'LemonChiffon', '#FFFACD', '2018-11-05 12:12:26', '2018-11-05 12:12:26'),
(26, 'LightGoldenrodYellow', '#FAFAD2', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(27, 'PapayaWhip', '#FFEFD5', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(28, 'Moccasin', '#FFE4B5', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(29, 'PeachPuff', '#FFDAB9', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(30, 'PaleGoldenrod', '#EEE8AA', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(31, 'Khaki', '#F0E68C', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(32, 'DarkKhaki', '#BDB76B', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(33, 'Lavender', '#E6E6FA', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(34, 'Thistle', '#D8BFD8', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(35, 'Plum', '#DDA0DD', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(36, 'Violet', '#EE82EE', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(37, 'Orchid', '#DA70D6', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(38, 'Fuchsia', '#FF00FF', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(39, 'Magenta', '#FF00FF', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(40, 'MediumOrchid', '#BA55D3', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(41, 'MediumPurple', '#9370DB', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(42, 'Amethyst', '#9966CC', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(43, 'BlueViolet', '#8A2BE2', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(44, 'DarkViolet', '#9400D3', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(45, 'DarkOrchid', '#9932CC', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(46, 'DarkMagenta', '#8B008B', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(47, 'Purple', '#800080', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(48, 'Indigo', '#4B0082', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(49, 'SlateBlue', '#6A5ACD', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(50, 'DarkSlateBlue', '#483D8B', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(51, 'MediumSlateBlue', '#7B68EE', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(52, 'GreenYellow', '#ADFF2F', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(53, 'Chartreuse', '#7FFF00', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(54, 'LawnGreen', '#7CFC00', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(55, 'Lime', '#00FF00', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(56, 'LimeGreen', '#32CD32', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(57, 'PaleGreen', '#98FB98', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(58, 'LightGreen', '#90EE90', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(59, 'MediumSpringGreen', '#00FA9A', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(60, 'SpringGreen', '#00FF7F', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(61, 'MediumSeaGreen', '#3CB371', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(62, 'SeaGreen', '#2E8B57', '2018-11-05 12:12:27', '2018-11-05 12:12:27'),
(63, 'ForestGreen', '#228B22', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(64, 'Green', '#008000', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(65, 'DarkGreen', '#006400', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(66, 'YellowGreen', '#9ACD32', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(67, 'OliveDrab', '#6B8E23', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(68, 'Olive', '#808000', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(69, 'DarkOliveGreen', '#556B2F', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(70, 'MediumAquamarine', '#66CDAA', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(71, 'DarkSeaGreen', '#8FBC8F', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(72, 'LightSeaGreen', '#20B2AA', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(73, 'DarkCyan', '#008B8B', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(74, 'Teal', '#008080', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(75, 'Aqua', '#00FFFF', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(76, 'Cyan', '#00FFFF', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(77, 'LightCyan', '#E0FFFF', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(78, 'PaleTurquoise', '#AFEEEE', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(79, 'Aquamarine', '#7FFFD4', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(80, 'Turquoise', '#40E0D0', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(81, 'MediumTurquoise', '#48D1CC', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(82, 'DarkTurquoise', '#00CED1', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(83, 'CadetBlue', '#5F9EA0', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(84, 'SteelBlue', '#4682B4', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(85, 'LightSteelBlue', '#B0C4DE', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(86, 'PowderBlue', '#B0E0E6', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(87, 'LightBlue', '#ADD8E6', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(88, 'SkyBlue', '#87CEEB', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(89, 'LightSkyBlue', '#87CEFA', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(90, 'DeepSkyBlue', '#00BFFF', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(91, 'DodgerBlue', '#1E90FF', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(92, 'CornflowerBlue', '#6495ED', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(93, 'MediumSlateBlue', '#7B68EE', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(94, 'RoyalBlue', '#4169E1', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(95, 'Blue', '#0000FF', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(96, 'MediumBlue', '#0000CD', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(97, 'DarkBlue', '#00008B', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(98, 'Navy', '#000080', '2018-11-05 12:12:28', '2018-11-05 12:12:28'),
(99, 'MidnightBlue', '#191970', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(100, 'Cornsilk', '#FFF8DC', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(101, 'BlanchedAlmond', '#FFEBCD', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(102, 'Bisque', '#FFE4C4', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(103, 'NavajoWhite', '#FFDEAD', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(104, 'Wheat', '#F5DEB3', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(105, 'BurlyWood', '#DEB887', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(106, 'Tan', '#D2B48C', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(107, 'RosyBrown', '#BC8F8F', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(108, 'SandyBrown', '#F4A460', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(109, 'Goldenrod', '#DAA520', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(110, 'DarkGoldenrod', '#B8860B', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(111, 'Peru', '#CD853F', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(112, 'Chocolate', '#D2691E', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(113, 'SaddleBrown', '#8B4513', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(114, 'Sienna', '#A0522D', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(115, 'Brown', '#A52A2A', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(116, 'Maroon', '#800000', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(117, 'White', '#FFFFFF', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(118, 'Snow', '#FFFAFA', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(119, 'Honeydew', '#F0FFF0', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(120, 'MintCream', '#F5FFFA', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(121, 'Azure', '#F0FFFF', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(122, 'AliceBlue', '#F0F8FF', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(123, 'GhostWhite', '#F8F8FF', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(124, 'WhiteSmoke', '#F5F5F5', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(125, 'Seashell', '#FFF5EE', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(126, 'Beige', '#F5F5DC', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(127, 'OldLace', '#FDF5E6', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(128, 'FloralWhite', '#FFFAF0', '2018-11-05 12:12:29', '2018-11-05 12:12:29'),
(129, 'Ivory', '#FFFFF0', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(130, 'AntiqueWhite', '#FAEBD7', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(131, 'Linen', '#FAF0E6', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(132, 'LavenderBlush', '#FFF0F5', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(133, 'MistyRose', '#FFE4E1', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(134, 'Gainsboro', '#DCDCDC', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(135, 'LightGrey', '#D3D3D3', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(136, 'Silver', '#C0C0C0', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(137, 'DarkGray', '#A9A9A9', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(138, 'Gray', '#808080', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(139, 'DimGray', '#696969', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(140, 'LightSlateGray', '#778899', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(141, 'SlateGray', '#708090', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(142, 'DarkSlateGray', '#2F4F4F', '2018-11-05 12:12:30', '2018-11-05 12:12:30'),
(143, 'Black', '#000000', '2018-11-05 12:12:30', '2018-11-05 12:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `feedback` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reply` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `min_purchase` decimal(8,2) NOT NULL DEFAULT 0.00,
  `max_discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `code`, `exchange_rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'USD', 'USD', 'USD', '1', 1, NULL, '2021-06-27 22:39:37'),
(2, 'BDT', '৳', 'BDT', '84', 1, NULL, '2021-07-06 20:52:58'),
(3, 'Indian Rupi', '₹', 'INR', '60', 1, '2020-10-16 02:23:04', '2021-06-05 03:26:38'),
(4, 'Euro', '€', 'EUR', '100', 1, '2021-05-26 06:00:23', '2021-06-05 03:25:29'),
(5, 'YEN', '¥', 'JPY', '110', 1, '2021-06-11 07:08:31', '2021-06-26 23:21:10'),
(6, 'Ringgit', 'RM', 'MYR', '4.16', 1, '2021-07-03 20:08:33', '2021-07-03 20:10:37'),
(7, 'Rand', 'R', 'ZAR', '14.26', 1, '2021-07-03 20:12:38', '2021-07-03 20:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `customer_wallets`
--

CREATE TABLE `customer_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `balance` decimal(8,2) NOT NULL DEFAULT 0.00,
  `royality_points` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_wallet_histories`
--

CREATE TABLE `customer_wallet_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `transaction_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `transaction_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_method` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deal_of_the_days`
--

CREATE TABLE `deal_of_the_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'amount',
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `feature_deals`
--

CREATE TABLE `feature_deals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flash_deals`
--

CREATE TABLE `flash_deals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `deal_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flash_deal_products`
--

CREATE TABLE `flash_deal_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flash_deal_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `help_topics`
--

CREATE TABLE `help_topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ranking` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_09_08_105159_create_admins_table', 1),
(5, '2020_09_08_111837_create_admin_roles_table', 1),
(6, '2020_09_16_142451_create_categories_table', 2),
(7, '2020_09_16_181753_create_categories_table', 3),
(8, '2020_09_17_134238_create_brands_table', 4),
(9, '2020_09_17_203054_create_attributes_table', 5),
(10, '2020_09_19_112509_create_coupons_table', 6),
(11, '2020_09_19_161802_create_curriencies_table', 7),
(12, '2020_09_20_114509_create_sellers_table', 8),
(13, '2020_09_23_113454_create_shops_table', 9),
(14, '2020_09_23_115615_create_shops_table', 10),
(15, '2020_09_23_153822_create_shops_table', 11),
(16, '2020_09_21_122817_create_products_table', 12),
(17, '2020_09_22_140800_create_colors_table', 12),
(18, '2020_09_28_175020_create_products_table', 13),
(19, '2020_09_28_180311_create_products_table', 14),
(20, '2020_10_04_105041_create_search_functions_table', 15),
(21, '2020_10_05_150730_create_customers_table', 15),
(22, '2020_10_08_133548_create_wishlists_table', 16),
(23, '2016_06_01_000001_create_oauth_auth_codes_table', 17),
(24, '2016_06_01_000002_create_oauth_access_tokens_table', 17),
(25, '2016_06_01_000003_create_oauth_refresh_tokens_table', 17),
(26, '2016_06_01_000004_create_oauth_clients_table', 17),
(27, '2016_06_01_000005_create_oauth_personal_access_clients_table', 17),
(28, '2020_10_06_133710_create_product_stocks_table', 17),
(29, '2020_10_06_134636_create_flash_deals_table', 17),
(30, '2020_10_06_134719_create_flash_deal_products_table', 17),
(31, '2020_10_08_115439_create_orders_table', 17),
(32, '2020_10_08_115453_create_order_details_table', 17),
(33, '2020_10_08_121135_create_shipping_addresses_table', 17),
(34, '2020_10_10_171722_create_business_settings_table', 17),
(35, '2020_09_19_161802_create_currencies_table', 18),
(36, '2020_10_12_152350_create_reviews_table', 18),
(37, '2020_10_12_161834_create_reviews_table', 19),
(38, '2020_10_12_180510_create_support_tickets_table', 20),
(39, '2020_10_14_140130_create_transactions_table', 21),
(40, '2020_10_14_143553_create_customer_wallets_table', 21),
(41, '2020_10_14_143607_create_customer_wallet_histories_table', 21),
(42, '2020_10_22_142212_create_support_ticket_convs_table', 21),
(43, '2020_10_24_234813_create_banners_table', 22),
(44, '2020_10_27_111557_create_shipping_methods_table', 23),
(45, '2020_10_27_114154_add_url_to_banners_table', 24),
(46, '2020_10_28_170308_add_shipping_id_to_order_details', 25),
(47, '2020_11_02_140528_add_discount_to_order_table', 26),
(48, '2020_11_03_162723_add_column_to_order_details', 27),
(49, '2020_11_08_202351_add_url_to_banners_table', 28),
(50, '2020_11_10_112713_create_help_topic', 29),
(51, '2020_11_10_141513_create_contacts_table', 29),
(52, '2020_11_15_180036_add_address_column_user_table', 30),
(53, '2020_11_18_170209_add_status_column_to_product_table', 31),
(54, '2020_11_19_115453_add_featured_status_product', 32),
(55, '2020_11_21_133302_create_deal_of_the_days_table', 33),
(56, '2020_11_20_172332_add_product_id_to_products', 34),
(57, '2020_11_27_234439_add__state_to_shipping_addresses', 34),
(58, '2020_11_28_091929_create_chattings_table', 35),
(59, '2020_12_02_011815_add_bank_info_to_sellers', 36),
(60, '2020_12_08_193234_create_social_medias_table', 37),
(61, '2020_12_13_122649_shop_id_to_chattings', 37),
(62, '2020_12_14_145116_create_seller_wallet_histories_table', 38),
(63, '2020_12_14_145127_create_seller_wallets_table', 38),
(64, '2020_12_15_174804_create_admin_wallets_table', 39),
(65, '2020_12_15_174821_create_admin_wallet_histories_table', 39),
(66, '2020_12_15_214312_create_feature_deals_table', 40),
(67, '2020_12_17_205712_create_withdraw_requests_table', 41),
(68, '2021_02_22_161510_create_notifications_table', 42),
(69, '2021_02_24_154706_add_deal_type_to_flash_deals', 43),
(70, '2021_03_03_204349_add_cm_firebase_token_to_users', 44),
(71, '2021_04_17_134848_add_column_to_order_details_stock', 45),
(72, '2021_05_12_155401_add_auth_token_seller', 46),
(73, '2021_06_03_104531_ex_rate_update', 47),
(74, '2021_06_03_222413_amount_withdraw_req', 48),
(75, '2021_06_04_154501_seller_wallet_withdraw_bal', 49),
(76, '2021_06_04_195853_product_dis_tax', 50),
(77, '2021_05_27_103505_create_product_translations_table', 51),
(78, '2021_06_17_054551_create_soft_credentials_table', 51),
(79, '2021_06_29_212549_add_active_col_user_table', 52),
(80, '2021_06_30_212619_add_col_to_contact', 53),
(81, '2021_07_01_160828_add_col_daily_needs_products', 54),
(82, '2021_07_04_182331_add_col_seller_sales_commission', 55),
(83, '2021_08_07_190655_add_seo_columns_to_products', 56),
(84, '2021_08_07_205913_add_col_to_category_table', 56),
(85, '2021_08_07_210808_add_col_to_shops_table', 56),
(86, '2021_08_14_205216_change_product_price_col_type', 56),
(87, '2021_08_16_201505_change_order_price_col', 56),
(88, '2021_08_16_201552_change_order_details_price_col', 56),
(89, '2021_08_17_213934_change_col_type_seller_earning_history', 57),
(90, '2021_08_17_214109_change_col_type_admin_earning_history', 57),
(91, '2021_08_17_214232_change_col_type_admin_wallet', 57),
(92, '2021_08_17_214405_change_col_type_seller_wallet', 57);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('6840b7d4ed685bf2e0dc593affa0bd3b968065f47cc226d39ab09f1422b5a1d9666601f3f60a79c1', 98, 1, 'LaravelAuthApp', '[]', 1, '2021-07-05 18:25:41', '2021-07-05 18:25:41', '2022-07-05 15:25:41'),
('c42cdd5ae652b8b2cbac4f2f4b496e889e1a803b08672954c8bbe06722b54160e71dce3e02331544', 98, 1, 'LaravelAuthApp', '[]', 1, '2021-07-05 18:24:36', '2021-07-05 18:24:36', '2022-07-05 15:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, '6amtech', 'GEUx5tqkviM6AAQcz4oi1dcm1KtRdJPgw41lj0eI', 'http://localhost', 1, 0, 0, '2020-10-22 03:27:22', '2020-10-22 03:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-10-22 03:27:23', '2020-10-22 03:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `order_status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_ref` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_amount` double NOT NULL DEFAULT 0,
  `shipping_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount_amount` double NOT NULL DEFAULT 0,
  `discount_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `product_details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `tax` double NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `delivery_status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shipping_method_id` bigint(20) DEFAULT NULL,
  `variant` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_stock_decreased` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('salman@sharklasers.com', '14lUcQshzInvTHQOY1lTz8NFjngCzn01t8GyAjEDDkmEAUwOWHsb6enH2X4SFitoaq5Cofnn7OvCdZMftqzqRo2061BaN4RWFfURGGMg6k6JLcIathUzEQUM', '2021-09-09 22:19:52'),
('shahab@inoviotech.com', '4qsayyrZ9btUNLSrJNUyGwocQjc10oHDSI3KoEz4S0PHIcZp44aVgitfATJUWk3WaZG5ZuPJdHUpF8MUAOwoTz9t61SJSt2MKu54e1ZqaAr4NBytJLXdbp3B', '2021-09-10 01:13:37'),
('shahab@inoviotech.com', 'wjWwxrQX1PHFD8uDDuiZwVXxBowBqG03m7xsYUEirn5KJvXdbfjjWIOBzei13OIVUxUEknTrnOG84JzAQf0dl6xX6CCcELI0XpN3a7xj0HeGqXVJhEfIfNJY', '2021-09-10 01:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `added_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_ids` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` bigint(20) DEFAULT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_qty` int(11) NOT NULL DEFAULT 1,
  `refundable` tinyint(1) NOT NULL DEFAULT 1,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flash_deal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_provider` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colors` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant_product` tinyint(1) NOT NULL DEFAULT 0,
  `attributes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `choice_options` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `purchase_price` double NOT NULL DEFAULT 0,
  `tax` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.00',
  `tax_type` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.00',
  `discount_type` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_stock` int(11) DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `free_shipping` tinyint(1) NOT NULL DEFAULT 0,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `featured_status` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `added_by`, `user_id`, `name`, `slug`, `category_ids`, `brand_id`, `unit`, `min_qty`, `refundable`, `images`, `thumbnail`, `featured`, `flash_deal`, `video_provider`, `video_url`, `colors`, `variant_product`, `attributes`, `choice_options`, `variation`, `published`, `unit_price`, `purchase_price`, `tax`, `tax_type`, `discount`, `discount_type`, `current_stock`, `details`, `free_shipping`, `attachment`, `created_at`, `updated_at`, `status`, `featured_status`, `meta_title`, `meta_description`, `meta_image`) VALUES
(82, 'admin', 1, 'NATIVE LIGHTNING TEE', 'native-lightning-tee-wYxWnD', '[{\"id\":\"1\",\"position\":1},{\"id\":\"5\",\"position\":2}]', NULL, 'kg', 1, 1, '[\"2021-09-13-613f80a053d78.png\",\"2021-09-13-613f80a054314.png\"]', '2021-09-13-613f80a0544d9.png', NULL, NULL, 'youtube', NULL, '[]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"Large\"]}]', '[{\"type\":\"Large\",\"price\":185,\"sku\":\"NLT-Large\",\"qty\":\"5\"}]', 0, 185, 150, '0', 'percent', '0', 'flat', 5, '<p><strong>Materials and Features</strong></p>\r\n\r\n<p>Vintage rib knit crewneck collar tee in washed black. Item features a native chief and skull graphic printed at the chest. Lightning graphic printed throughout the front and back. Good condition, item shows some signs of wear. Made of cotton.</p>\r\n\r\n<p><strong>Size and Fit</strong></p>\r\n\r\n<p>Boxy fit. Fits true to size.</p>', 0, NULL, '2021-09-14 02:47:28', '2021-09-14 02:47:28', 1, 1, NULL, NULL, '2021-09-13-613f80a05595c.png'),
(83, 'admin', 1, 'TSA HOODIE', 'tsa-hoodie-mP5QYZ', '[{\"id\":\"1\",\"position\":1},{\"id\":\"5\",\"position\":2}]', NULL, 'kg', 1, 1, '[\"2021-09-13-613f80e6ac56b.png\"]', '2021-09-13-613f80e6acaa4.png', NULL, NULL, 'youtube', NULL, '[]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"Large\"]}]', '[{\"type\":\"Large\",\"price\":250,\"sku\":\"TH-Large\",\"qty\":\"1\"}]', 0, 250, 200, '0', 'percent', '0', 'flat', 1, '<p><strong>Materials and Features</strong></p>\r\n\r\n<p>Heavyweight cut and sewn pullover hooded sweatshirt in black. Item features infrared graphic printed across the front. Perfect condition, item comes in original packaging. 12oz/340g cotton.</p>\r\n\r\n<p><strong>Size and Fit</strong></p>\r\n\r\n<p>Fits true to size.</p>', 0, NULL, '2021-09-14 02:48:38', '2021-09-14 02:48:38', 1, 1, NULL, NULL, '2021-09-13-613f80e6adf74.png'),
(84, 'admin', 1, 'MOTM3 SWEATSHIRT', 'motm3-sweatshirt-weJUQ8', '[{\"id\":\"1\",\"position\":1},{\"id\":\"5\",\"position\":2}]', NULL, 'kg', 1, 1, '[\"2021-09-13-613f812d9d7b7.png\",\"2021-09-13-613f812d9df4d.png\"]', '2021-09-13-613f812d9e113.png', NULL, NULL, 'youtube', NULL, '[]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"Medium\"]}]', '[{\"type\":\"Medium\",\"price\":350,\"sku\":\"MS-Medium\",\"qty\":\"5\"}]', 0, 350, 300, '0', 'percent', '0', 'flat', 5, '<p><strong>Materials and Features</strong></p>\r\n\r\n<p>A collaboration between Cactus Plant Flea Market x Kid Cudi. Rib knit collar crewneck sweatshirt in yelow. Item features very special Man on the Moon 3 artwork and text across the front and back and sleeves. Perfect condition, item comes with original packaging.</p>\r\n\r\n<p><strong>Size and Fit</strong></p>\r\n\r\n<p>Fits true to size.</p>', 0, NULL, '2021-09-14 02:49:49', '2021-09-14 02:49:49', 1, 1, NULL, NULL, '2021-09-13-613f812d9f0a0.png'),
(85, 'admin', 1, 'RETRO HIGH ROYAL TOE', 'retro-high-royal-toe-9QDvpd', '[{\"id\":\"2\",\"position\":1},{\"id\":\"14\",\"position\":2}]', NULL, 'kg', 1, 1, '[\"2021-09-13-613f81aa36313.png\",\"2021-09-13-613f81aa368fc.png\"]', '2021-09-13-613f81aa36b86.png', NULL, NULL, 'youtube', NULL, '[]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"9.5\",\"US 7W\"]}]', '[{\"type\":\"9.5\",\"price\":55,\"sku\":\"RHRT-9.5\",\"qty\":\"1\"},{\"type\":\"US7W\",\"price\":55,\"sku\":\"RHRT-US7W\",\"qty\":\"1\"}]', 0, 550, 500, '0', 'percent', '0', 'flat', 2, '<p><strong>Materials and Features</strong></p>\r\n\r\n<p>Released in 2020, the Nike and Jordan collaboration brings a new colourway to the classic Retro High Jordan 1 sneaker. The item features white leather base with blue leather upper and toe. Black leather overlays. White midsole and royal blue outsole. Perfect condition, comes with original box and tags.</p>\r\n\r\n<p><strong>Size and Fit</strong></p>\r\n\r\n<p>Fits true to size.</p>', 0, NULL, '2021-09-14 02:51:54', '2021-09-14 02:51:54', 1, 1, NULL, NULL, '2021-09-13-613f81aa37f19.png'),
(86, 'admin', 1, 'LOW GAME ROYAL', 'low-game-royal-1bkeME', '[{\"id\":\"2\",\"position\":1},{\"id\":\"14\",\"position\":2}]', NULL, 'kg', 1, 1, '[\"2021-09-13-613f823139307.png\",\"2021-09-13-613f82313979d.png\",\"2021-09-13-613f823139922.png\"]', '2021-09-13-613f823139af7.png', NULL, NULL, 'youtube', NULL, '[]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"10\",\"9.5\"]}]', '[{\"type\":\"10\",\"price\":300,\"sku\":\"LGR-10\",\"qty\":\"1\"},{\"type\":\"9.5\",\"price\":300,\"sku\":\"LGR-9.5\",\"qty\":\"1\"}]', 0, 300, 250, '0', 'percent', '0', 'flat', 2, '<p><strong>Materials and Features</strong></p>\r\n\r\n<p>Released in 2020, the Nike and Jordan collaboration brings a new colourway to the classic low Jordan 1 sneaker. A versatille sneaker that looks as good in a street fit as it does with a modest blazer. The item features white leather side panels and toe with royal blue overlays. Black Jordan embroidery at back. White midsole and black outsole. Perfect condition, comes with original box and tags.</p>\r\n\r\n<p><strong>Size and Fit</strong></p>\r\n\r\n<p>Fits true to size.</p>', 0, NULL, '2021-09-14 02:54:09', '2021-09-14 02:54:09', 1, 1, NULL, NULL, '2021-09-13-613f82313a563.png'),
(87, 'admin', 1, 'LOW WHITE CAMO', 'low-white-camo-v0xzAD', '[{\"id\":\"2\",\"position\":1},{\"id\":\"14\",\"position\":2}]', NULL, 'kg', 1, 1, '[\"2021-09-13-613f82809151a.png\",\"2021-09-13-613f828091abe.png\",\"2021-09-13-613f828091c8e.png\"]', '2021-09-13-613f828091e78.png', NULL, NULL, 'youtube', NULL, '[]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"10\",\"9.5\"]}]', '[{\"type\":\"10\",\"price\":395,\"sku\":\"LWC-10\",\"qty\":\"1\"},{\"type\":\"9.5\",\"price\":395,\"sku\":\"LWC-9.5\",\"qty\":\"1\"}]', 0, 395, 349.99, '0', 'percent', '0', 'flat', 2, '<p><strong>Materials and Features</strong></p>\r\n\r\n<p>The Nike and Jordan collaboration brings a special colourway to the classic low Jordan 1 sneaker. A versatille sneaker that looks as good in a street fit as it does with a suit. The item features off-white canvas side panels and light grey leather toe. Light grey overlays and white camo signature check. Black Jordan embroidery at back. White midsole and light grey outsole. Perfect condition, comes with original box and tags.</p>\r\n\r\n<p><strong>Size and Fit</strong></p>\r\n\r\n<p>Fits true to size.</p>', 0, NULL, '2021-09-14 02:55:28', '2021-09-14 02:55:28', 1, 1, NULL, NULL, '2021-09-13-613f828093393.png'),
(88, 'admin', 3, 'Jordan Sneakers', 'jordan-sneakers-lf9vrY', '[{\"id\":\"1\",\"position\":1},{\"id\":\"9\",\"position\":2}]', 2, 'pc', 1, 1, '[\"2021-09-14-6140745383c93.png\",\"2021-09-14-6140745384cd9.png\",\"2021-09-14-6140745385476.png\"]', '2021-09-14-6140745385c98.png', NULL, NULL, 'youtube', 'http://localhost/charity/user/campaign/create', '[\"#D3D3D3\"]', 0, '[\"3\",\"1\",\"2\"]', '[{\"name\":\"choice_3\",\"title\":\"Condition\",\"options\":[\"Perfect\"]},{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"5.5Y\"]},{\"name\":\"choice_2\",\"title\":\"Tagline\",\"options\":[\"Light\"]}]', '[{\"type\":\"LightGrey-Perfect-5.5Y-Light\",\"price\":400,\"sku\":\"JS-LightGrey-Perfect-5.5Y-Light\",\"qty\":\"1\"}]', 0, 400, 10, '5', 'percent', '0', 'flat', 1, '<p>Released in 2020, the Nike and Jordan collaboration brings a new colourway to the classic low Jordan 1 sneaker. A versatille sneaker that looks as good in a street fit as it does with a modest blazer. The item features white leather side panels and toe with smoke grey overlays and black signature check. Red Jordan embroidery at back. White midsole and black outsole. Perfect condition, comes with original box and tags.</p>', 0, NULL, '2021-09-14 20:07:15', '2021-09-14 20:07:15', 1, 1, NULL, NULL, '2021-09-14-6140745387374.png'),
(89, 'admin', 3, 'Air', 'air-cKO0cd', '[{\"id\":\"1\",\"position\":1},{\"id\":\"9\",\"position\":2}]', 1, 'kg', 1, 1, '[\"2021-09-14-614075a10f9d8.png\",\"2021-09-14-614075a110694.png\",\"2021-09-14-614075a110d4a.png\"]', '2021-09-14-614075a111429.png', NULL, NULL, 'youtube', NULL, '[\"#800080\"]', 0, '[\"3\",\"1\",\"2\"]', '[{\"name\":\"choice_3\",\"title\":\"Condition\",\"options\":[\"Perfect\"]},{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"9.5M\",\"10M\",\"11M\"]},{\"name\":\"choice_2\",\"title\":\"Tagline\",\"options\":[\"Low Court\"]}]', '[{\"type\":\"Purple-Perfect-9.5M-LowCourt\",\"price\":325,\"sku\":\"A-Purple-Perfect-9.5M-LowCourt\",\"qty\":\"1\"},{\"type\":\"Purple-Perfect-10M-LowCourt\",\"price\":325,\"sku\":\"A-Purple-Perfect-10M-LowCourt\",\"qty\":\"1\"},{\"type\":\"Purple-Perfect-11M-LowCourt\",\"price\":325,\"sku\":\"A-Purple-Perfect-11M-LowCourt\",\"qty\":\"1\"}]', 0, 325, 250, '5', 'percent', '0', 'flat', 3, '<p>Released in 2020, the Nike and Jordan collaboration brings a new colourway to the classic low Jordan 1 sneaker. A versatille sneaker that looks as good in a street fit as it does with a modest blazer. The item features white leather side panels and toe with court purple overlays and black signature check. Black Jordan embroidery at back. White midsole and court purple outsole. Perfect condition, comes with original box and tags.</p>', 0, NULL, '2021-09-14 20:12:49', '2021-09-14 20:12:49', 1, 1, NULL, NULL, '2021-09-14-614075a11421d.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `variant` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `qty` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `customer_id`, `comment`, `attachment`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 23, 97, 'good', '[\"review\\/GZznygozmDapxWtpb1jmFucm51aoRTzAVu4iQyDK.jpg\"]', 5, 1, '2021-06-04 20:55:16', '2021-06-04 20:55:16'),
(2, 34, 97, 'good', '[]', 1, 1, '2021-06-05 01:47:53', '2021-06-05 01:47:53'),
(3, 34, 97, 'okay', '[]', 5, 1, '2021-06-05 06:24:51', '2021-06-05 06:24:51'),
(4, 41, 97, 'oka', '[]', 1, 1, '2021-06-05 06:34:09', '2021-06-05 06:34:09'),
(5, 40, 97, 'great', '[\"review\\/pqXIjC40O8rYU7WFBwQaMUD32ObIObvKCRssLdF6.jpg\"]', 1, 1, '2021-06-05 06:36:56', '2021-06-05 06:36:56'),
(6, 1, 101, 'Nice', '[\"review\\/DQh9xsD7fiyjheN9qOI6gXmFwEXrRebHzuliR4lY.jpg\"]', 1, 1, '2021-06-05 06:42:05', '2021-06-05 06:42:05'),
(7, 40, 97, 'very 5', '[]', 5, 1, '2021-06-05 06:42:41', '2021-06-05 06:42:41'),
(8, 40, 97, 'okaaaa', '[]', 4, 1, '2021-06-05 07:27:09', '2021-06-05 07:27:09'),
(9, 41, 97, 'abcd123', '[]', 4, 1, '2021-06-05 07:28:31', '2021-06-05 07:28:31');

-- --------------------------------------------------------

--
-- Table structure for table `search_functions`
--

CREATE TABLE `search_functions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visible_for` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `search_functions`
--

INSERT INTO `search_functions` (`id`, `key`, `url`, `visible_for`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'admin/dashboard', 'admin', NULL, NULL),
(2, 'Order All', 'admin/orders/list/all', 'admin', NULL, NULL),
(3, 'Order Pending', 'admin/orders/list/pending', 'admin', NULL, NULL),
(4, 'Order Processed', 'admin/orders/list/processed', 'admin', NULL, NULL),
(5, 'Order Delivered', 'admin/orders/list/delivered', 'admin', NULL, NULL),
(6, 'Order Returned', 'admin/orders/list/returned', 'admin', NULL, NULL),
(7, 'Order Failed', 'admin/orders/list/failed', 'admin', NULL, NULL),
(8, 'Brand Add', 'admin/brand/add-new', 'admin', NULL, NULL),
(9, 'Brand List', 'admin/brand/list', 'admin', NULL, NULL),
(10, 'Banner', 'admin/banner/list', 'admin', NULL, NULL),
(11, 'Category', 'admin/category/view', 'admin', NULL, NULL),
(12, 'Sub Category', 'admin/category/sub-category/view', 'admin', NULL, NULL),
(13, 'Sub sub category', 'admin/category/sub-sub-category/view', 'admin', NULL, NULL),
(14, 'Attribute', 'admin/attribute/view', 'admin', NULL, NULL),
(15, 'Product', 'admin/product/list', 'admin', NULL, NULL),
(16, 'Coupon', 'admin/coupon/add-new', 'admin', NULL, NULL),
(17, 'Custom Role', 'admin/custom-role/create', 'admin', NULL, NULL),
(18, 'Employee', 'admin/employee/add-new', 'admin', NULL, NULL),
(19, 'Seller', 'admin/sellers/seller-list', 'admin', NULL, NULL),
(20, 'Contacts', 'admin/contact/list', 'admin', NULL, NULL),
(21, 'Flash Deal', 'admin/deal/flash', 'admin', NULL, NULL),
(22, 'Deal of the day', 'admin/deal/day', 'admin', NULL, NULL),
(23, 'Language', 'admin/business-settings/language', 'admin', NULL, NULL),
(24, 'Mail', 'admin/business-settings/mail', 'admin', NULL, NULL),
(25, 'Shipping method', 'admin/business-settings/shipping-method/add', 'admin', NULL, NULL),
(26, 'Currency', 'admin/currency/view', 'admin', NULL, NULL),
(27, 'Payment method', 'admin/business-settings/payment-method', 'admin', NULL, NULL),
(28, 'SMS Gateway', 'admin/business-settings/sms-gateway', 'admin', NULL, NULL),
(29, 'Support Ticket', 'admin/support-ticket/view', 'admin', NULL, NULL),
(30, 'FAQ', 'admin/helpTopic/list', 'admin', NULL, NULL),
(31, 'About Us', 'admin/business-settings/about-us', 'admin', NULL, NULL),
(32, 'Terms and Conditions', 'admin/business-settings/terms-condition', 'admin', NULL, NULL),
(33, 'Web Config', 'admin/business-settings/web-config', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `f_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'def.png',
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holder_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_commission_percentage` double(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_wallets`
--

CREATE TABLE `seller_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `withdrawn` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_wallet_histories`
--

CREATE TABLE `seller_wallet_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `payment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'received',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) DEFAULT NULL,
  `creator_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` decimal(8,2) NOT NULL DEFAULT 0.00,
  `duration` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_methods`
--

INSERT INTO `shipping_methods` (`id`, `creator_id`, `creator_type`, `title`, `cost`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'Courier', 0.00, '4-6 days', 0, '2020-10-27 23:44:01', '2020-12-22 00:01:29'),
(2, 1, 'admin', 'Company Vehicle', 5.00, '2 Week', 1, '2021-05-26 05:57:04', '2021-05-26 05:57:04'),
(4, 1, 'admin', 'Slow shipping', 10.00, '40 days', 1, '2020-12-14 22:43:46', '2021-02-28 05:17:48'),
(5, 1, 'admin', 'by air', 100.00, '2 days', 1, '2021-05-26 05:57:40', '2021-05-26 05:57:40'),
(6, 10, 'seller', 'by air', 100.00, '4 days', 1, '2021-05-30 01:12:40', '2021-05-30 01:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'def.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_medias`
--

CREATE TABLE `social_medias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_medias`
--

INSERT INTO `social_medias` (`id`, `name`, `link`, `icon`, `active_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'twitter', 'https://www.w3schools.com/howto/howto_css_table_responsive.asp', 'fa fa-twitter', 1, 1, '2021-01-01 07:18:03', '2021-01-01 07:18:25'),
(2, 'linkedin', 'https://dev.6amtech.com/', 'fa fa-linkedin', 1, 1, '2021-02-28 02:23:01', '2021-02-28 02:23:05'),
(3, 'google-plus', 'https://dev.6amtech.com/', 'fa fa-google-plus-square', 1, 1, '2021-02-28 02:23:30', '2021-02-28 02:23:33'),
(4, 'pinterest', 'https://dev.6amtech.com/', 'fa fa-pinterest', 1, 1, '2021-02-28 02:24:14', '2021-02-28 02:24:26'),
(5, 'instagram', 'https://dev.6amtech.com/', 'fa fa-instagram', 1, 1, '2021-02-28 02:24:36', '2021-02-28 02:24:41'),
(6, 'facebook', 'facebook.com', 'fa fa-facebook', 1, 1, '2021-02-28 05:19:42', '2021-06-12 02:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `soft_credentials`
--

CREATE TABLE `soft_credentials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `subject` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'low',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_convs`
--

CREATE TABLE `support_ticket_convs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `customer_message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `payment_for` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payer_id` bigint(20) DEFAULT NULL,
  `payment_receiver_id` bigint(20) DEFAULT NULL,
  `paid_by` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_to` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'success',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) NOT NULL,
  `translationable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translationable_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'def.png',
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `street_address` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `house_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apartment_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cm_firebase_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `f_name`, `l_name`, `phone`, `image`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `street_address`, `country`, `city`, `zip`, `house_no`, `apartment_no`, `cm_firebase_token`, `is_active`) VALUES
(1, NULL, 'Muhammad', 'Salman', '03453368866', 'def.png', 'salman@sharklasers.com', NULL, '$2y$10$Wkygbv8RnipCO.Mlz.jb6.LT0M1P8LZwglbQft2ZmOkN9jAJri1j6', 'gXHIDZdah1Bw8pOkpHYYva9RkQCYbsiv10bRu5Xftf3LSZtM3dUTunEGSRvs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, NULL, 'Muhammad', 'Shahab', '03453368866', 'def.png', 'shahab@inoviotech.com', NULL, '$2y$10$LFoQ6M7ek7WuXGuBxtvbmOWvn7ASJcX2efdkzaYkOPrXmL00Gmwa6', NULL, NULL, '2021-09-09 19:05:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, NULL, 'Muhammad', 'Sajid', '03453368866', '1631188425-6139f5c9a2d7b.png', 'sajid@inoviotech.com', NULL, '$2y$10$EV/koJi4t29AEc0IZugFN.h9RN0mhNqN0lIs2L//RrwsvTtS2vcGS', NULL, NULL, '2021-09-09 21:53:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_requests`
--

CREATE TABLE `withdraw_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.00',
  `transaction_note` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_wallets`
--
ALTER TABLE `admin_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_wallet_histories`
--
ALTER TABLE `admin_wallet_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_settings`
--
ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chattings`
--
ALTER TABLE `chattings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_wallets`
--
ALTER TABLE `customer_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_wallet_histories`
--
ALTER TABLE `customer_wallet_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deal_of_the_days`
--
ALTER TABLE `deal_of_the_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feature_deals`
--
ALTER TABLE `feature_deals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deals`
--
ALTER TABLE `flash_deals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help_topics`
--
ALTER TABLE `help_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search_functions`
--
ALTER TABLE `search_functions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sellers_email_unique` (`email`);

--
-- Indexes for table `seller_wallets`
--
ALTER TABLE `seller_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_wallet_histories`
--
ALTER TABLE `seller_wallet_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_medias`
--
ALTER TABLE `social_medias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soft_credentials`
--
ALTER TABLE `soft_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_ticket_convs`
--
ALTER TABLE `support_ticket_convs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD UNIQUE KEY `transactions_id_unique` (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD KEY `translations_translationable_id_index` (`translationable_id`),
  ADD KEY `translations_locale_index` (`locale`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_requests`
--
ALTER TABLE `withdraw_requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin_wallets`
--
ALTER TABLE `admin_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_wallet_histories`
--
ALTER TABLE `admin_wallet_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `chattings`
--
ALTER TABLE `chattings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer_wallets`
--
ALTER TABLE `customer_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_wallet_histories`
--
ALTER TABLE `customer_wallet_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deal_of_the_days`
--
ALTER TABLE `deal_of_the_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feature_deals`
--
ALTER TABLE `feature_deals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flash_deals`
--
ALTER TABLE `flash_deals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `help_topics`
--
ALTER TABLE `help_topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `search_functions`
--
ALTER TABLE `search_functions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_wallets`
--
ALTER TABLE `seller_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_wallet_histories`
--
ALTER TABLE `seller_wallet_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_medias`
--
ALTER TABLE `social_medias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `soft_credentials`
--
ALTER TABLE `soft_credentials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_ticket_convs`
--
ALTER TABLE `support_ticket_convs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_requests`
--
ALTER TABLE `withdraw_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
