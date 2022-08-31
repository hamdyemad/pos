-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2022 at 11:33 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `approval_histories`
--

CREATE TABLE `approval_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(29, 'الدقى', 'asdasdlasdk;asd', '01560456460', '2022-08-26 16:28:36', '2022-08-26 16:28:36'),
(30, 'المهندسين', 'شس4ي5شس6يشسي', '54465', '2022-08-26 16:28:51', '2022-08-26 16:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `branches_categories`
--

CREATE TABLE `branches_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches_categories`
--

INSERT INTO `branches_categories` (`id`, `category_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(20, 37, 29, '2022-08-27 10:11:53', '2022-08-27 10:11:53'),
(21, 37, 30, '2022-08-27 10:11:53', '2022-08-27 10:11:53'),
(22, 38, 29, '2022-08-27 10:12:01', '2022-08-27 10:12:01'),
(23, 39, 30, '2022-08-27 10:12:09', '2022-08-27 10:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('expense','income') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`id`, `branch_id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(18, 29, 'مصروفات الموظفين', 'income', '2022-08-30 18:20:27', '2022-08-30 18:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewed_number` int(11) DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `viewed_number`, `photo`, `active`, `created_at`, `updated_at`) VALUES
(37, 'صنف لكل الفروع', NULL, NULL, 1, '2022-08-27 10:11:53', '2022-08-27 10:11:53'),
(38, 'صنف فرع الدقى', NULL, NULL, 1, '2022-08-27 10:12:01', '2022-08-27 10:12:01'),
(39, 'صنف المهندسين', NULL, NULL, 1, '2022-08-27 10:12:09', '2022-08-27 10:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `categories_products`
--

CREATE TABLE `categories_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories_products`
--

INSERT INTO `categories_products` (`id`, `category_id`, `product_id`, `created_at`, `updated_at`) VALUES
(22, 38, 44, '2022-08-27 10:13:40', '2022-08-27 10:13:40'),
(23, 39, 45, '2022-08-27 10:14:19', '2022-08-27 10:14:19'),
(24, 38, 45, '2022-08-27 10:14:19', '2022-08-27 10:14:19'),
(25, 39, 46, '2022-08-27 10:16:03', '2022-08-27 10:16:03'),
(26, 37, 47, '2022-08-27 12:06:57', '2022-08-27 12:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(16, 14, 'cairo', 30, '2022-08-20 12:30:24', '2022-08-20 12:32:48'),
(17, 14, 'alexandria', 100, '2022-08-20 12:32:58', '2022-08-20 12:32:58');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `active`, `created_at`, `updated_at`) VALUES
(14, 'مصر', 'ُEG', 1, '2022-08-20 12:26:53', '2022-08-20 12:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` int(11) NOT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('percent','price') COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid_before` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `count`, `price`, `type`, `valid_before`, `created_at`, `updated_at`) VALUES
(5, '308241', 20, '50', 'price', '2022-08-31', '2022-08-27 13:06:49', '2022-08-27 13:06:49');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('regular','special') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `email`, `type`, `created_at`, `updated_at`) VALUES
(6, 'kareem ragab`', '01152059120', 'addresasdasdas', 'asd@asd.com', 'regular', '2022-08-28 20:02:14', '2022-08-28 20:02:14');

-- --------------------------------------------------------

--
-- Table structure for table `customer_cards`
--

CREATE TABLE `customer_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_last_4` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_month` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_year` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` bigint(20) UNSIGNED NOT NULL,
  `expense_for` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `name`, `type`, `expense_for`, `phone`, `price`, `notes`, `created_at`, `updated_at`) VALUES
(14, 'moza', 18, 'شيشسيشس', '5456456', 500, 'asdasdas;ldkas', '2022-08-30 18:20:43', '2022-08-30 18:20:43');

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
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regional` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rtl` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `regional`, `rtl`, `created_at`, `updated_at`) VALUES
(3, 'English', 'en', 'en-US', 0, '2022-03-23 21:44:53', '2022-03-23 21:44:53'),
(4, 'Arabic', 'ar', 'ar_AE', 1, '2022-03-23 21:45:16', '2022-03-23 21:45:16');

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
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2022_02_08_214244_create_branch_table', 1),
(4, '2022_02_08_214245_create_currencies_table', 1),
(5, '2022_02_08_214245_create_users_table', 1),
(6, '2022_02_09_101308_create_categories_table', 1),
(7, '2022_02_09_120301_create_products_table', 1),
(8, '2022_02_09_120302_create_product_prices_table', 1),
(9, '2022_02_09_120303_create_products_variations_table', 1),
(10, '2022_02_09_120304_create_products_variations_prices_table', 1),
(11, '2022_02_10_114834_create_businesses_table', 1),
(12, '2022_02_10_114844_create_expenses_table', 1),
(13, '2022_02_10_115931_create_settings_table', 1),
(14, '2022_02_10_143109_create_countries_table', 1),
(15, '2022_02_10_143302_create_cities_table', 1),
(16, '2022_02_10_143303_create_cities_prices_table', 1),
(17, '2022_02_11_143944_create_permessions_table', 1),
(18, '2022_02_11_144056_create_roles_table', 1),
(19, '2022_02_11_144149_create_roles_permessions_table', 1),
(20, '2022_02_11_144255_create_users_roles_table', 1),
(21, '2022_02_15_121001_create_statuses_table', 1),
(22, '2022_02_15_121002_create_orders_table', 1),
(23, '2022_02_15_121154_create_orders_details_table', 1),
(24, '2022_02_16_102912_create_statuses_histroy_table', 1),
(25, '2022_03_20_105253_create_payments_table', 1),
(26, '2022_03_20_113346_create_payment_customers_table', 1),
(27, '2022_03_22_161612_create_customer_cards_table', 1),
(28, '2022_03_23_132138_create_languages_table', 1),
(29, '2022_03_23_132316_create_translations_table', 1),
(31, '2022_07_31_150011_create_orders_views_table', 2),
(32, '2022_08_17_103057_create_branches_categories_table', 3),
(34, '2022_08_20_130907_categories_products_table', 4),
(36, '2022_08_20_141225_create_coupons_table', 5),
(37, '2022_08_27_114533_create_customers_table', 6),
(38, '2022_08_30_204129_create_approval_histories_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) NOT NULL,
  `bin_code` int(11) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `under_approve` tinyint(1) NOT NULL DEFAULT 0,
  `payment_method` enum('cash','credit','','') COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('inhouse','online') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` enum('amount','percent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_discount` double DEFAULT NULL,
  `shipping` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `branch_id`, `status_id`, `city_id`, `user_id`, `coupon_id`, `customer_id`, `bin_code`, `paid`, `under_approve`, `payment_method`, `type`, `notes`, `discount_type`, `total_discount`, `shipping`, `grand_total`, `created_at`, `updated_at`) VALUES
(202, 29, 17, NULL, 5, NULL, 6, NULL, 0, 0, 'cash', 'inhouse', NULL, 'amount', NULL, NULL, 290, '2022-08-30 17:19:37', '2022-08-30 17:19:37'),
(203, 30, 17, NULL, 5, NULL, 6, NULL, 0, 0, 'cash', 'inhouse', NULL, 'amount', NULL, NULL, 180, '2022-08-30 17:20:02', '2022-08-30 17:20:02'),
(204, NULL, 17, 16, 16, NULL, 6, NULL, 0, 0, 'cash', 'online', NULL, 'amount', NULL, 30, 320, '2022-08-30 17:20:15', '2022-08-31 07:32:29'),
(205, NULL, 18, 16, 5, NULL, 6, NULL, 0, 0, 'cash', 'online', NULL, 'amount', NULL, 30, 320, '2022-08-30 17:20:30', '2022-08-30 17:27:48'),
(206, 29, 17, NULL, 5, 5, 6, 6042, 0, 1, 'cash', 'inhouse', NULL, 'amount', 90, NULL, 150, '2022-08-30 17:43:40', '2022-08-30 18:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE `orders_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant_type` enum('extra','size') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `files` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `discount` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`id`, `order_id`, `product_id`, `variant`, `variant_type`, `files`, `notes`, `price`, `qty`, `discount`, `total_price`, `created_at`, `updated_at`) VALUES
(436, 202, 44, NULL, NULL, NULL, NULL, 290, 1, NULL, 290, '2022-08-30 17:19:37', '2022-08-30 17:19:37'),
(437, 203, 46, 'large', 'size', NULL, NULL, 180, 1, NULL, 180, '2022-08-30 17:20:02', '2022-08-30 17:20:02'),
(439, 205, 44, NULL, NULL, NULL, NULL, 290, 1, NULL, 290, '2022-08-30 17:20:30', '2022-08-30 17:20:30'),
(440, 206, 44, NULL, NULL, NULL, NULL, 290, 1, NULL, 290, '2022-08-30 17:43:40', '2022-08-30 17:43:40'),
(441, 204, 44, NULL, NULL, NULL, NULL, 290, 1, NULL, 290, '2022-08-31 07:32:29', '2022-08-31 07:32:29');

-- --------------------------------------------------------

--
-- Table structure for table `orders_views`
--

CREATE TABLE `orders_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders_views`
--

INSERT INTO `orders_views` (`id`, `order_id`, `user_id`, `created_at`, `updated_at`) VALUES
(37, 204, 15, '2022-08-30 17:27:56', '2022-08-30 17:27:56'),
(38, 205, 5, '2022-08-30 17:39:21', '2022-08-30 17:39:21'),
(39, 203, 5, '2022-08-30 17:39:52', '2022-08-30 17:39:52'),
(40, 206, 5, '2022-08-30 18:47:01', '2022-08-30 18:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_customers`
--

CREATE TABLE `payment_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_integration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permessions`
--

CREATE TABLE `permessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permessions`
--

INSERT INTO `permessions` (`id`, `name`, `key`, `group_by`, `created_at`, `updated_at`) VALUES
(1, 'الأعدادات العامة', 'settings.edit', 'الأعدادات العامة', NULL, NULL),
(2, 'كل المعاملات المالية', 'business.index', 'المعاملات المالية', NULL, NULL),
(3, 'الأيرادات والمصروفات', 'business.all', 'المعاملات المالية', NULL, NULL),
(4, 'تعديل المعاملات المالية', 'business.edit', 'المعاملات المالية', NULL, NULL),
(5, 'انشاء المعاملات المالية', 'business.create', 'المعاملات المالية', NULL, NULL),
(6, 'ازالة المعاملات المالية', 'business.destroy', 'المعاملات المالية', NULL, NULL),
(7, 'العملات', 'currencies.index', 'المعاملات المالية', NULL, NULL),
(8, 'كل الأيرادات والمصروفات', 'expenses.index', 'الأيرادات والمصروفات', NULL, NULL),
(9, 'انشاء الأيرادات والمصروفات', 'expenses.create', 'الأيرادات والمصروفات', NULL, NULL),
(10, 'تعديل الأيرادات والمصروفات', 'expenses.edit', 'الأيرادات والمصروفات', NULL, NULL),
(11, 'ازالة الأيرادات والمصروفات', 'expenses.destroy', 'الأيرادات والمصروفات', NULL, NULL),
(12, 'كل الفروع', 'branches.index', 'الفروع', NULL, NULL),
(13, 'انشاء فرع', 'branches.create', 'الفروع', NULL, NULL),
(14, 'تعديل الفرع', 'branches.edit', 'الفروع', NULL, NULL),
(15, 'ازالة الفرع', 'branches.destroy', 'الفروع', NULL, NULL),
(16, 'كل الاصناف', 'categories.index', 'الأصناف', NULL, NULL),
(17, 'انشاء الاصناف', 'categories.create', 'الأصناف', NULL, NULL),
(18, 'اظهار الاصناف', 'categories.show', 'الأصناف', NULL, NULL),
(19, 'تعديل الاصناف', 'categories.edit', 'الأصناف', NULL, NULL),
(20, 'ازالة الاصناف', 'categories.destroy', 'الأصناف', NULL, NULL),
(21, 'كل المنتجات', 'products.index', 'المنتجات', NULL, NULL),
(22, 'انشاء المنتجات', 'products.create', 'المنتجات', NULL, NULL),
(23, 'اظهار المنتجات', 'products.show', 'المنتجات', NULL, NULL),
(24, 'تعديل المنتجات', 'products.edit', 'المنتجات', NULL, NULL),
(25, 'ازالة المنتجات', 'products.destroy', 'المنتجات', NULL, NULL),
(26, 'كل الشحن والدول', 'countries.index', 'الشحن والدول', NULL, NULL),
(27, 'انشاء الشحن والدول', 'countries.create', 'الشحن والدول', NULL, NULL),
(28, 'تعديل الشحن والدول', 'countries.edit', 'الشحن والدول', NULL, NULL),
(29, 'ازالة الشحن والدول', 'countries.destroy', 'الشحن والدول', NULL, NULL),
(30, 'كل المستخدمين', 'users.index', 'المستخدمين', NULL, NULL),
(31, 'انشاء المستخدمين', 'users.create', 'المستخدمين', NULL, NULL),
(32, 'تعديل المستخدمين', 'users.edit', 'المستخدمين', NULL, NULL),
(33, 'ازالة المستخدمين', 'users.destroy', 'المستخدمين', NULL, NULL),
(34, 'كل الصلاحيات', 'roles.index', 'الصلاحيات', NULL, NULL),
(35, 'انشاء الصلاحيات', 'roles.create', 'الصلاحيات', NULL, NULL),
(36, 'تعديل الصلاحيات', 'roles.edit', 'الصلاحيات', NULL, NULL),
(37, 'ازالة الصلاحيات', 'roles.destroy', 'الصلاحيات', NULL, NULL),
(38, 'كل الطلبات', 'orders.index', 'الطلبات', NULL, NULL),
(39, 'ظهور الطلب', 'orders.show', 'الطلبات', NULL, NULL),
(40, 'انشاء الطلبات', 'orders.create', 'الطلبات', NULL, NULL),
(41, 'تعديل الطلبات', 'orders.edit', 'الطلبات', NULL, NULL),
(42, 'ازالة الطلبات', 'orders.destroy', 'الطلبات', NULL, NULL),
(43, 'كل الحالات', 'statuses.index', 'حالات الطلبات', NULL, NULL),
(44, 'انشاء حالة الطلبات', 'statuses.create', 'حالات الطلبات', NULL, NULL),
(45, 'تعديل حالة الطلبات', 'statuses.edit', 'حالات الطلبات', NULL, NULL),
(46, 'ازالة حالة الطلبات', 'statuses.destroy', 'حالات الطلبات', NULL, NULL),
(47, 'كل اللغات', 'languages.index', 'اللغات', NULL, NULL),
(48, 'انشاء لغة', 'languages.create', 'اللغات', NULL, NULL),
(49, 'ازالة لغة', 'languages.destroy', 'اللغات', NULL, NULL),
(52, 'كل الكوبونات', 'coupons.index', 'الكوبونات', '2022-08-26 17:35:26', '2022-08-26 17:35:26'),
(53, 'انشاء الكوبونات', 'coupons.create', 'الكوبونات', '2022-08-26 17:35:43', '2022-08-26 17:35:43'),
(54, 'ازالة الكوبونات', 'coupons.destroy', 'الكوبونات', '2022-08-26 17:35:52', '2022-08-26 17:35:52'),
(55, 'موافقة الطلبات', 'orders.approve', 'الطلبات', '2022-08-26 17:37:37', '2022-08-26 17:37:37'),
(56, 'كل الزبائن', 'customers.index', 'الزبائن', '2022-08-27 09:48:54', '2022-08-27 09:48:54'),
(57, 'انشاء الزبائن', 'customers.create', 'الزبائن', '2022-08-27 09:49:08', '2022-08-27 09:49:08'),
(58, 'تعديل الزبائن', 'customers.edit', 'الزبائن', '2022-08-27 09:49:16', '2022-08-27 09:49:16'),
(59, 'ازالة الزبائن', 'customers.destroy', 'الزبائن', '2022-08-27 09:49:28', '2022-08-27 09:49:28'),
(64, 'صفحة طلبات الموافقة', 'approval_orders.index', 'الطلبات', '2022-08-28 15:41:10', '2022-08-28 15:41:10'),
(70, 'طلب جديد', '17', 'الحالات', '2022-08-29 11:57:51', '2022-08-29 11:57:51'),
(71, 'جارى الأستعلام', '18', 'الحالات', '2022-08-29 12:00:46', '2022-08-29 12:00:46'),
(72, 'مدفوع', '19', 'الحالات', '2022-08-29 12:00:59', '2022-08-29 12:00:59'),
(73, 'تحت المراجعة', '20', 'الحالات', '2022-08-29 12:01:18', '2022-08-29 12:01:18'),
(74, 'مرتجع', '21', 'الحالات', '2022-08-29 12:01:25', '2022-08-29 12:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photos` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `viewed_number` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `count`, `sku`, `photos`, `description`, `active`, `viewed_number`, `created_at`, `updated_at`) VALUES
(44, 'منتج بدون اى شئ', '0', 'sku-651778', '[\"uploads\\/products\\/123456789630a0a745a967-1661602420.webp\"]', 'dss\'kf\';kasf\'a\'kasfaafas', 1, NULL, '2022-08-27 10:13:40', '2022-08-27 10:13:40'),
(45, 'منتج مع اضافة', '0', 'sku-576912', NULL, NULL, 1, NULL, '2022-08-27 10:14:19', '2022-08-27 10:14:19'),
(46, 'منتج مقاسات', '0', 'sku-778714', '[\"uploads\\/products\\/123456789630a0b03059d2-1661602563.jpg\",\"uploads\\/products\\/123456789630a0b0305e98-1661602563.jpg\"]', 'asdasdasdasda', 1, NULL, '2022-08-27 10:16:03', '2022-08-27 10:16:03'),
(47, 'مقاسات مع اضافات', '200', 'sku-360608', NULL, NULL, 1, NULL, '2022-08-27 12:06:57', '2022-08-27 12:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `products_prices`
--

CREATE TABLE `products_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `discount` double DEFAULT NULL,
  `price_after_discount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_prices`
--

INSERT INTO `products_prices` (`id`, `product_id`, `price`, `discount`, `price_after_discount`, `created_at`, `updated_at`) VALUES
(41, 39, 200, 10, 190, '2022-08-20 11:18:05', '2022-08-20 11:18:05'),
(44, 41, 200, 50, 150, '2022-08-26 11:17:07', '2022-08-26 11:17:07'),
(48, 42, 200, 50, 150, '2022-08-26 17:04:21', '2022-08-26 17:04:21'),
(49, 44, 300, 10, 290, '2022-08-27 10:13:40', '2022-08-27 10:13:40'),
(50, 45, 300, 10, 290, '2022-08-27 10:14:19', '2022-08-27 10:14:19');

-- --------------------------------------------------------

--
-- Table structure for table `products_variations`
--

CREATE TABLE `products_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('extra','size') COLLATE utf8mb4_unicode_ci NOT NULL,
  `variant` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_variations`
--

INSERT INTO `products_variations` (`id`, `product_id`, `type`, `variant`, `created_at`, `updated_at`) VALUES
(41, 45, 'extra', 'صوص', '2022-08-27 10:14:19', '2022-08-27 10:14:19'),
(42, 46, 'size', 'xxlarge', '2022-08-27 10:16:03', '2022-08-27 10:16:03'),
(43, 46, 'size', 'large', '2022-08-27 10:16:03', '2022-08-27 10:16:03'),
(44, 47, 'extra', 'جبنة', '2022-08-27 12:06:57', '2022-08-27 12:06:57'),
(45, 47, 'extra', 'صوص', '2022-08-27 12:06:57', '2022-08-27 12:06:57'),
(46, 47, 'size', 'xlarge', '2022-08-27 12:06:57', '2022-08-27 12:06:57'),
(47, 47, 'size', 'large', '2022-08-27 12:06:57', '2022-08-27 12:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `products_variations_prices`
--

CREATE TABLE `products_variations_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `discount` double DEFAULT NULL,
  `price_after_discount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_variations_prices`
--

INSERT INTO `products_variations_prices` (`id`, `product_id`, `variant_id`, `price`, `discount`, `price_after_discount`, `created_at`, `updated_at`) VALUES
(51, 45, 41, 10, NULL, 10, '2022-08-27 10:14:19', '2022-08-27 10:14:19'),
(52, 46, 42, 300, 0, 300, '2022-08-27 10:16:03', '2022-08-27 10:16:03'),
(53, 46, 43, 200, 20, 180, '2022-08-27 10:16:03', '2022-08-27 10:16:03'),
(54, 47, 44, 20, NULL, 20, '2022-08-27 12:06:57', '2022-08-27 12:06:57'),
(55, 47, 45, 50, NULL, 50, '2022-08-27 12:06:57', '2022-08-27 12:06:57'),
(56, 47, 46, 400, 0, 400, '2022-08-27 12:06:57', '2022-08-27 12:06:57'),
(57, 47, 47, 200, 0, 200, '2022-08-27 12:06:57', '2022-08-27 12:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(6, 'مدير', '2022-02-22 08:05:10', '2022-02-22 08:05:10'),
(7, 'منفذ طلبات', '2022-02-22 09:24:17', '2022-02-22 09:24:17'),
(9, 'منفذ منتجات', '2022-02-22 09:28:53', '2022-02-22 09:28:53');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permessions`
--

CREATE TABLE `roles_permessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permession_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_permessions`
--

INSERT INTO `roles_permessions` (`id`, `role_id`, `permession_id`, `created_at`, `updated_at`) VALUES
(1, 7, 38, '2022-07-31 13:14:36', '2022-07-31 13:14:36'),
(2, 7, 39, '2022-07-31 13:14:36', '2022-07-31 13:14:36'),
(3, 7, 40, '2022-07-31 13:14:36', '2022-07-31 13:14:36'),
(4, 7, 41, '2022-07-31 13:14:36', '2022-07-31 13:14:36'),
(5, 7, 42, '2022-07-31 13:14:36', '2022-07-31 13:14:36'),
(6, 9, 21, '2022-08-17 10:11:50', '2022-08-17 10:11:50'),
(7, 9, 22, '2022-08-17 10:11:50', '2022-08-17 10:11:50'),
(8, 9, 23, '2022-08-17 10:11:50', '2022-08-17 10:11:50'),
(9, 9, 24, '2022-08-17 10:11:50', '2022-08-17 10:11:50'),
(10, 9, 25, '2022-08-17 10:11:50', '2022-08-17 10:11:50'),
(60, 6, 1, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(61, 6, 2, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(62, 6, 3, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(63, 6, 4, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(64, 6, 5, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(65, 6, 6, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(66, 6, 7, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(67, 6, 8, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(68, 6, 9, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(69, 6, 10, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(70, 6, 11, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(71, 6, 12, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(72, 6, 13, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(73, 6, 14, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(74, 6, 15, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(75, 6, 16, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(76, 6, 17, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(77, 6, 18, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(78, 6, 19, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(79, 6, 20, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(80, 6, 21, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(81, 6, 22, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(82, 6, 23, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(83, 6, 24, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(84, 6, 25, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(85, 6, 26, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(86, 6, 27, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(87, 6, 28, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(88, 6, 29, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(89, 6, 30, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(90, 6, 31, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(91, 6, 32, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(92, 6, 33, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(93, 6, 34, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(94, 6, 35, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(95, 6, 36, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(96, 6, 37, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(97, 6, 38, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(98, 6, 39, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(99, 6, 40, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(100, 6, 41, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(101, 6, 42, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(102, 6, 43, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(103, 6, 44, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(104, 6, 45, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(105, 6, 46, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(106, 6, 47, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(107, 6, 48, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(108, 6, 49, '2022-08-30 17:11:59', '2022-08-30 17:11:59'),
(109, 6, 70, '2022-08-30 17:11:59', '2022-08-30 17:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'logo', 'uploads/settings/123456789630657ee4f109-1661360110.png', '2022-08-24 14:55:10', '2022-08-24 14:55:10'),
(2, 'project_name', 'sports way', '2022-08-24 14:55:10', '2022-08-26 11:59:47'),
(3, 'header', NULL, '2022-08-24 14:55:10', '2022-08-24 14:55:10'),
(4, 'facebook', NULL, '2022-08-24 14:55:10', '2022-08-24 14:55:10'),
(5, 'instagram', NULL, '2022-08-24 14:55:10', '2022-08-24 14:55:10'),
(6, 'youtube', NULL, '2022-08-24 14:55:10', '2022-08-24 14:55:10'),
(7, 'description', NULL, '2022-08-24 14:55:10', '2022-08-24 14:55:10'),
(8, 'keywords', NULL, '2022-08-24 14:55:10', '2022-08-24 14:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_val` tinyint(1) NOT NULL DEFAULT 0,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `returned` tinyint(1) NOT NULL DEFAULT 0,
  `under_collection` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `default_val`, `paid`, `returned`, `under_collection`, `created_at`, `updated_at`) VALUES
(17, 'طلب جديد', 1, 0, 0, 0, '2022-08-29 11:56:44', '2022-08-29 11:57:56'),
(18, 'جارى الأستعلام', 0, 0, 0, 0, '2022-08-29 12:00:46', '2022-08-29 12:00:46'),
(19, 'مدفوع', 0, 1, 0, 0, '2022-08-29 12:00:59', '2022-08-29 12:00:59'),
(20, 'تحت المراجعة', 0, 0, 0, 0, '2022-08-29 12:01:18', '2022-08-29 12:01:18'),
(21, 'مرتجع', 0, 0, 1, 0, '2022-08-29 12:01:25', '2022-08-29 12:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `statuses_histroy`
--

CREATE TABLE `statuses_histroy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses_histroy`
--

INSERT INTO `statuses_histroy` (`id`, `user_id`, `order_id`, `status_id`, `created_at`, `updated_at`) VALUES
(73, 5, 202, 17, '2022-08-30 17:19:37', '2022-08-30 17:19:37'),
(74, 5, 203, 17, '2022-08-30 17:20:02', '2022-08-30 17:20:02'),
(75, 5, 204, 17, '2022-08-30 17:20:15', '2022-08-30 17:20:15'),
(76, 5, 205, 17, '2022-08-30 17:20:30', '2022-08-30 17:20:30'),
(77, 5, 205, 18, '2022-08-30 17:27:48', '2022-08-30 17:27:48'),
(78, 5, 206, 17, '2022-08-30 17:43:40', '2022-08-30 17:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lang_id` bigint(20) UNSIGNED NOT NULL,
  `lang_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `lang_id`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(1, 4, 'dashboard', 'لوحة التحكم', '2022-07-28 11:10:11', '2022-07-28 11:16:45'),
(2, 4, 'branches', 'الفروع', '2022-07-28 11:10:11', '2022-07-28 11:16:22'),
(3, 4, 'categories', 'الأصناف', '2022-07-28 11:10:11', '2022-07-28 11:20:33'),
(4, 4, 'foods', 'الأطعمة', '2022-07-28 11:10:11', '2022-07-28 11:20:50'),
(5, 4, 'orders', 'الطلبات', '2022-07-28 11:10:11', '2022-07-28 11:19:13'),
(6, 4, 'total orders of statuses', 'كل حالات الطلبات', '2022-07-28 11:10:11', '2022-07-28 11:19:28'),
(7, 4, 'profile', 'الصفحة الشخصية', '2022-07-28 11:12:20', '2022-07-28 11:23:20'),
(8, 4, 'logout', 'تسجيل الخروج', '2022-07-28 11:12:20', '2022-07-28 11:23:32'),
(9, 4, 'the main', 'الرئيسية', '2022-07-28 11:12:20', '2022-07-28 11:27:02'),
(10, 4, 'general settings', 'الأعدادات العامة', '2022-07-28 11:12:20', '2022-07-28 11:16:57'),
(11, 4, 'financial transactions', 'المعاملات المالية', '2022-07-28 11:12:20', '2022-07-28 11:17:17'),
(12, 4, 'currencies', 'العملات', '2022-07-28 11:12:20', '2022-07-28 11:17:30'),
(13, 4, 'revenues and expenses', 'الأيرادات  والمصروفات', '2022-07-28 11:12:20', '2022-07-28 11:17:51'),
(14, 4, 'all financial transactions', 'كل المعاملات المالية', '2022-07-28 11:12:20', '2022-07-28 11:17:17'),
(15, 4, 'all branches', 'كل الفروع', '2022-07-28 11:12:20', '2022-07-28 11:16:27'),
(16, 4, 'create branch', 'انشاء فرع', '2022-07-28 11:12:20', '2022-07-28 11:18:07'),
(17, 4, 'all orders', 'كل الطلبات', '2022-07-28 11:12:20', '2022-07-28 11:19:01'),
(18, 4, 'create order', 'انشاء طلب', '2022-07-28 11:12:20', '2022-07-28 11:20:01'),
(19, 4, 'orders statuses', 'حالات الطلبات', '2022-07-28 11:12:20', '2022-07-28 11:19:18'),
(20, 4, 'create orders statuses', 'انشاء حالات الطلبات', '2022-07-28 11:12:20', '2022-07-28 11:19:10'),
(21, 4, 'all categories', 'كل الأصناف', '2022-07-28 11:12:20', '2022-07-28 11:20:33'),
(22, 4, 'create category', 'انشاء صنف', '2022-07-28 11:12:20', '2022-07-28 11:19:50'),
(23, 4, 'all foods', 'كل الأطعمة', '2022-07-28 11:12:20', '2022-07-28 11:20:50'),
(24, 4, 'create food', 'انشاء طعام', '2022-07-28 11:12:20', '2022-07-28 11:19:56'),
(25, 4, 'shipping and countries', 'الدول والشحن', '2022-07-28 11:12:20', '2022-07-28 11:21:02'),
(26, 4, 'all countries', 'كل الدول', '2022-07-28 11:12:20', '2022-07-28 11:21:32'),
(27, 4, 'create country', 'انشاء دولة', '2022-07-28 11:12:20', '2022-07-28 11:19:50'),
(28, 4, 'staff and users', 'الموظفين والمستخدمين', '2022-07-28 11:12:20', '2022-07-28 11:21:55'),
(29, 4, 'all staff', 'كل الموظفين', '2022-07-28 11:12:20', '2022-07-28 11:21:55'),
(30, 4, 'all users', 'كل المستخدمين', '2022-07-28 11:12:20', '2022-07-28 11:22:10'),
(31, 4, 'permessions', 'الصلاحيات', '2022-07-28 11:12:20', '2022-07-28 11:22:33'),
(32, 4, 'all permessions', 'كل الصلاحيات', '2022-07-28 11:12:20', '2022-07-28 11:22:33'),
(33, 4, 'create permession', 'انشاء صلاحيات', '2022-07-28 11:12:20', '2022-07-28 11:20:10'),
(34, 4, 'langs ​​and translation', 'اللغات والترجمة', '2022-07-28 11:12:20', '2022-07-28 11:22:49'),
(35, 4, 'settings', 'الأعدادات', '2022-07-28 11:12:20', '2022-07-28 11:23:45'),
(36, 4, 'choose layouts', 'أختر القالب', '2022-07-28 11:12:20', '2022-07-28 11:23:56'),
(37, 4, 'light mode', 'مود الفاتح', '2022-07-28 11:12:20', '2022-07-28 11:28:51'),
(38, 4, 'dark mode', 'مود الداكن', '2022-07-28 11:12:20', '2022-07-28 11:26:32'),
(39, 3, 'dashboard', 'dashboard', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(40, 3, 'branches', 'branches', '2022-07-28 11:12:45', '2022-07-28 11:15:53'),
(41, 3, 'categories', 'categories', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(42, 3, 'foods', 'foods', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(43, 3, 'orders', 'orders', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(44, 3, 'total orders of statuses', 'total orders of statuses', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(45, 3, 'profile', 'profile', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(46, 3, 'logout', 'logout', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(47, 3, 'the main', 'the main', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(48, 3, 'general settings', 'general settings', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(49, 3, 'financial transactions', 'financial transactions', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(50, 3, 'currencies', 'currencies', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(51, 3, 'revenues and expenses', 'revenues and expenses', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(52, 3, 'all financial transactions', 'all financial transactions', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(53, 3, 'all branches', 'all branches', '2022-07-28 11:12:45', '2022-07-28 11:15:49'),
(54, 3, 'create branch', 'create branch', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(55, 3, 'all orders', 'all orders', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(56, 3, 'create order', 'create order', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(57, 3, 'orders statuses', 'orders statuses', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(58, 3, 'create orders statuses', 'create orders statuses', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(59, 3, 'all categories', 'all categories', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(60, 3, 'create category', 'create category', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(61, 3, 'all foods', 'all foods', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(62, 3, 'create food', 'create food', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(63, 3, 'shipping and countries', 'shipping and countries', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(64, 3, 'all countries', 'all countries', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(65, 3, 'create country', 'create country', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(66, 3, 'staff and users', 'staff and users', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(67, 3, 'all staff', 'all staff', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(68, 3, 'all users', 'all users', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(69, 3, 'permessions', 'permessions', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(70, 3, 'all permessions', 'all permessions', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(71, 3, 'create permession', 'create permession', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(72, 3, 'langs ​​and translation', 'langs ​​and translation', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(73, 3, 'settings', 'settings', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(74, 3, 'choose layouts', 'choose layouts', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(75, 3, 'light mode', 'light mode', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(76, 3, 'dark mode', 'dark mode', '2022-07-28 11:12:45', '2022-07-28 11:12:45'),
(77, 3, 'employees', 'employees', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(78, 3, 'create employee', 'create employee', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(79, 3, 'employee name', 'employee name', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(80, 3, 'email', 'email', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(81, 3, 'phone', 'phone', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(82, 3, 'the branch', 'the branch', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(83, 3, 'choose', 'choose', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(84, 3, 'banned', 'banned', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(85, 3, 'not banned', 'not banned', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(86, 3, 'search', 'search', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(87, 3, 'branch', 'branch', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(88, 3, 'address', 'address', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(89, 3, 'creation date', 'creation date', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(90, 3, 'last update date', 'last update date', '2022-07-28 11:13:09', '2022-07-28 11:13:09'),
(91, 3, 'users', 'users', '2022-07-28 11:13:13', '2022-07-28 11:13:13'),
(92, 3, 'name', 'name', '2022-07-28 11:13:13', '2022-07-28 11:13:13'),
(93, 3, 'languages', 'languages', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(94, 3, 'create new language', 'create new language', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(95, 3, 'language name', 'language name', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(96, 3, 'translations link', 'translations link', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(97, 3, 'translation name', 'translation name', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(98, 3, 'translation code', 'translation code', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(99, 3, 'translation region', 'translation region', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(100, 3, 'delete', 'delete', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(101, 3, 'remove item', 'remove item', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(102, 3, 'are you sure to remove it', 'are you sure to remove it', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(103, 3, 'no', 'no', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(104, 3, 'yes', 'yes', '2022-07-28 11:13:15', '2022-07-28 11:13:15'),
(105, 3, 'translations', 'translations', '2022-07-28 11:13:24', '2022-07-28 11:13:24'),
(106, 3, 'translation key', 'translation key', '2022-07-28 11:13:24', '2022-07-28 11:13:24'),
(107, 3, 'translation value', 'translation value', '2022-07-28 11:13:24', '2022-07-28 11:13:24'),
(108, 3, 'translations updated', 'translations updated', '2022-07-28 11:14:45', '2022-07-28 11:14:45'),
(109, 3, 'create new permession', 'create new permession', '2022-07-28 11:16:03', '2022-07-28 11:16:03'),
(110, 3, 'permession name', 'permession name', '2022-07-28 11:16:03', '2022-07-28 11:16:03'),
(111, 3, 'permessions count', 'permessions count', '2022-07-28 11:16:03', '2022-07-28 11:16:03'),
(112, 3, 'edit', 'edit', '2022-07-28 11:16:03', '2022-07-28 11:16:03'),
(113, 4, 'edit general settings', 'تعديل الأعدادات العامة', '2022-07-28 11:24:09', '2022-07-28 11:24:30'),
(114, 4, 'project name', 'أسم المشروع', '2022-07-28 11:24:09', '2022-07-28 11:24:46'),
(115, 4, 'the logo', 'صورة الموقع', '2022-07-28 11:24:09', '2022-07-28 11:25:05'),
(116, 4, 'header title', 'معلومات الصفحة الرئيسية', '2022-07-28 11:24:09', '2022-07-28 11:25:28'),
(117, 4, 'facebook link', 'لينك الفيسبوك', '2022-07-28 11:24:09', '2022-07-28 11:25:56'),
(118, 4, 'instagram link', 'لينك الأنستاجرام', '2022-07-28 11:24:09', '2022-07-28 11:25:56'),
(119, 4, 'youtube channel link', 'لينك قناه اليوتيوب', '2022-07-28 11:24:09', '2022-07-28 11:25:56'),
(120, 4, 'description', 'المواصفات', '2022-07-28 11:24:09', '2022-07-28 11:26:09'),
(121, 4, 'google search keywords', 'كلمات جوجل المفتاحية', '2022-07-28 11:24:09', '2022-07-28 11:26:48'),
(122, 4, 'edit', 'تعديل', '2022-07-28 11:24:09', '2022-07-28 11:24:30'),
(123, 4, 'currency name', 'أسم العملة', '2022-07-28 11:27:20', '2022-07-28 11:28:00'),
(124, 4, 'currency code', 'كود العملة', '2022-07-28 11:27:20', '2022-07-28 11:27:55'),
(125, 4, 'search', 'بحث', '2022-07-28 11:27:20', '2022-07-28 11:29:07'),
(126, 4, 'name', 'الأسم', '2022-07-28 11:27:20', '2022-07-30 20:43:54'),
(127, 4, 'symbol', 'رمز', '2022-07-28 11:27:20', '2022-07-28 11:29:21'),
(128, 4, 'code', 'code', '2022-07-28 11:27:20', '2022-07-28 11:27:20'),
(129, 4, 'exchange to default currency', 'التبديل الى العملة الأفتراضية', '2022-07-28 11:27:20', '2022-07-28 11:28:30'),
(130, 4, 'default', 'الأفتراضية', '2022-07-28 11:27:20', '2022-07-28 11:28:08'),
(131, 4, 'creation date', 'تاريخ الأضافة', '2022-07-28 11:27:20', '2022-07-28 11:27:48'),
(132, 4, 'last update date', 'تاريخ أخر أضافة', '2022-07-28 11:27:20', '2022-07-28 11:28:42'),
(133, 4, 'yes', 'نعم', '2022-07-28 11:27:20', '2022-07-28 11:29:26'),
(134, 4, 'no', 'لا', '2022-07-28 11:27:20', '2022-07-28 11:28:58'),
(135, 4, 'incomes', 'الأيرادات', '2022-07-28 11:30:36', '2022-07-28 11:31:00'),
(136, 4, 'there is no incomes yet', 'لا يوجد ايرادات', '2022-07-28 11:30:36', '2022-07-28 11:31:08'),
(137, 4, 'expenses', 'المصروفات', '2022-07-28 11:30:36', '2022-07-28 11:31:23'),
(138, 4, 'there is no expenses yet', 'لا يوجد مصروفات', '2022-07-28 11:30:36', '2022-07-28 11:31:33'),
(139, 4, 'create financial transactions', 'إنشاء المعاملات المالية', '2022-07-28 11:31:45', '2022-07-28 11:33:07'),
(140, 4, 'financial name', 'اسم المعاملة المالية', '2022-07-28 11:31:45', '2022-07-28 11:34:16'),
(141, 4, 'type', 'النوع', '2022-07-28 11:31:45', '2022-07-30 10:31:44'),
(142, 4, 'choose', 'أختر', '2022-07-28 11:31:45', '2022-07-28 11:35:07'),
(143, 4, 'income', 'ايراد', '2022-07-28 11:31:45', '2022-07-30 10:31:19'),
(144, 4, 'the branch', 'الفرع', '2022-07-28 11:31:45', '2022-07-28 11:34:57'),
(145, 4, 'financial type', 'نوع المعاملة المالية', '2022-07-28 11:31:45', '2022-07-28 11:34:29'),
(146, 4, 'branch', 'الفرع', '2022-07-28 11:31:45', '2022-07-28 11:34:52'),
(147, 4, 'delete', 'ازالة', '2022-07-28 11:31:45', '2022-07-28 11:33:23'),
(148, 4, 'remove item', 'ازالة العنصر', '2022-07-28 11:31:45', '2022-07-28 12:03:41'),
(149, 4, 'are you sure to remove it', 'هل أنت متأكد من الأزالة', '2022-07-28 11:31:45', '2022-07-28 12:04:03'),
(150, 4, 'create', 'انشاء', '2022-07-28 11:31:49', '2022-07-28 11:32:56'),
(151, 4, 'income name', 'أسم الايراد', '2022-07-28 11:31:49', '2022-07-28 11:32:00'),
(152, 4, 'incomes owner\'s name', 'أسم صاحب الأيراد', '2022-07-28 11:31:49', '2022-07-28 11:32:11'),
(153, 4, 'phone', 'الموبيل', '2022-07-28 11:31:49', '2022-07-28 11:32:21'),
(154, 4, 'the amount', 'الكمية', '2022-07-28 11:31:49', '2022-07-28 11:32:36'),
(155, 4, 'the phone', 'الموبيل', '2022-07-28 11:31:49', '2022-07-28 11:32:25'),
(156, 4, 'the notes', 'الملاحظات', '2022-07-28 11:31:49', '2022-07-28 11:33:35'),
(157, 4, 'back to', 'الرجوع الى', '2022-07-28 11:33:27', '2022-07-28 12:01:02'),
(158, 4, 'edit financial transactions', 'تعديل المعاملات المالية', '2022-07-28 11:33:40', '2022-07-28 11:34:05'),
(159, 4, 'back to financial transactions', 'الرجوع الى المعاملات المالية', '2022-07-28 11:33:40', '2022-07-28 11:33:57'),
(160, 4, 'expenses name', 'أسم المصروف', '2022-07-28 11:59:38', '2022-07-28 12:00:48'),
(161, 4, 'expenses owner\'s name', 'أسم صاحب المصروف', '2022-07-28 11:59:38', '2022-07-28 12:00:12'),
(162, 4, 'expense name', 'أسم المصروف', '2022-07-28 11:59:38', '2022-07-28 12:00:24'),
(163, 4, 'the name is required', 'الأسم مطلوب', '2022-07-28 12:01:45', '2022-07-30 11:12:30'),
(164, 4, 'the price is required', 'السعر مطلوب', '2022-07-28 12:01:45', '2022-07-28 13:38:35'),
(165, 4, 'the price should be a number', 'السعر يجب أن يكون رقم', '2022-07-28 12:01:45', '2022-07-28 13:38:41'),
(166, 4, 'created successfully', 'تم الأنشاء بنجاح', '2022-07-28 12:01:45', '2022-07-28 12:02:05'),
(167, 4, 'branch name', 'أسم الفرع', '2022-07-28 12:02:16', '2022-07-28 12:02:34'),
(168, 4, 'branch phone', 'رقم موبيل الفرع', '2022-07-28 12:02:16', '2022-07-28 12:02:45'),
(169, 4, 'branch address', 'عنوان الفرع', '2022-07-28 12:02:16', '2022-07-28 12:02:56'),
(170, 4, 'create new branch', 'انشاء فرع جديد', '2022-07-28 12:03:02', '2022-07-28 12:03:13'),
(171, 4, 'back to branches', 'الرجوع الى الفروع', '2022-07-28 12:03:02', '2022-07-28 12:03:25'),
(172, 4, 'edit branches', 'تعديل الفروع', '2022-07-28 12:03:29', '2022-07-30 11:01:52'),
(173, 4, 'customer name', 'أسم الزبون', '2022-07-28 12:04:13', '2022-07-28 12:04:23'),
(174, 4, 'customer phone', 'رقم موبيل الزبون', '2022-07-28 12:04:13', '2022-07-28 12:04:45'),
(175, 4, 'customer address', 'عنوان الزبون', '2022-07-28 12:04:13', '2022-07-28 12:04:36'),
(176, 4, 'order status', 'حالة الطلب', '2022-07-28 12:04:13', '2022-07-28 12:06:16'),
(177, 4, 'order type', 'نوع الطلب', '2022-07-28 12:04:13', '2022-07-28 12:04:56'),
(178, 4, 'receipt request from the branch', 'طلب استلام من الفرع', '2022-07-28 12:04:13', '2022-07-28 12:05:48'),
(179, 4, 'online order', 'طلب عبر الأنترنت', '2022-07-28 12:04:13', '2022-07-28 12:05:17'),
(180, 4, 'order number', 'رقم الطلب', '2022-07-28 12:04:13', '2022-07-28 12:06:16'),
(181, 4, 'currency', 'العملة', '2022-07-28 12:04:13', '2022-07-28 12:10:39'),
(182, 4, 'city', 'المدينة', '2022-07-28 12:04:13', '2022-07-28 12:06:28'),
(183, 4, 'paid', 'مدفوع', '2022-07-28 12:04:13', '2022-07-28 12:10:53'),
(184, 4, 'order branch', 'فرع الطلب', '2022-07-28 12:04:13', '2022-07-31 11:05:18'),
(185, 4, 'a default status must be set', 'يجب أختيار حالة أفتراضية', '2022-07-28 12:06:33', '2022-07-28 12:06:52'),
(186, 4, 'statuses', 'الحالات', '2022-07-28 12:06:58', '2022-07-28 12:07:11'),
(187, 4, 'status name', 'أسم الحالة', '2022-07-28 12:06:58', '2022-07-28 12:07:32'),
(188, 4, 'default status', 'الحالة الأفتراضية', '2022-07-28 12:06:58', '2022-07-28 12:07:26'),
(189, 4, 'create new status', 'انشاء حالة جديدة', '2022-07-28 12:07:37', '2022-07-28 12:07:47'),
(190, 4, 'back to statuses', 'الرجوع الى الحالات', '2022-07-28 12:07:37', '2022-07-28 12:08:58'),
(191, 4, 'the name is already exists', 'the name is already exists', '2022-07-28 12:09:17', '2022-07-28 12:09:17'),
(192, 4, 'show orders', 'اظهار الطلبات', '2022-07-28 12:09:17', '2022-07-28 13:24:08'),
(193, 4, 'edit status', 'تعديل الحالة', '2022-07-28 12:09:32', '2022-07-31 11:10:15'),
(194, 4, 'updated successfully', 'تم التعديل بنجاح', '2022-07-28 12:09:35', '2022-07-28 12:09:49'),
(195, 3, 'show orders', 'show orders', '2022-07-28 12:09:43', '2022-07-28 12:09:43'),
(196, 4, 'create new order', 'انشاء طلب جديد', '2022-07-28 12:11:00', '2022-07-28 12:13:12'),
(197, 4, 'order branch creation', 'فرع انشاء الطلب', '2022-07-28 12:11:00', '2022-07-28 12:11:20'),
(198, 4, 'receipt from the branch', 'طلب استلام من الفرع', '2022-07-28 12:11:00', '2022-07-28 12:11:39'),
(199, 4, 'products', 'المنتجات', '2022-07-28 12:11:00', '2022-08-15 15:16:36'),
(200, 4, 'notes', 'الملاحظات', '2022-07-28 12:11:00', '2022-07-28 12:13:41'),
(201, 4, 'summary', 'الملخص', '2022-07-28 12:11:00', '2022-07-30 20:47:36'),
(202, 4, 'total price', 'السعر الكلى', '2022-07-28 12:11:00', '2022-07-28 13:38:48'),
(203, 4, 'shipping', 'الشحن', '2022-07-28 12:11:00', '2022-07-31 10:35:14'),
(204, 4, 'discount', 'الخصم', '2022-07-28 12:11:00', '2022-07-28 13:39:30'),
(205, 4, 'price after discount', 'السعر بعد الخصم', '2022-07-28 12:11:00', '2022-07-28 13:38:29'),
(206, 4, 'back to orders', 'الرجوع الى الطلبات', '2022-07-28 12:11:00', '2022-07-28 12:13:58'),
(207, 4, 'country', 'الدولة', '2022-07-28 12:11:00', '2022-07-28 13:41:34'),
(208, 4, 'quantity', 'العدد', '2022-07-28 12:11:00', '2022-07-30 20:35:07'),
(209, 4, 'food name', 'اسم الطعام', '2022-07-28 12:11:00', '2022-07-28 13:38:01'),
(210, 4, 'sizes', 'المقاسات', '2022-07-28 12:11:00', '2022-07-28 13:40:06'),
(211, 4, 'price', 'السعر', '2022-07-28 12:11:00', '2022-07-28 13:38:29'),
(212, 4, 'extras', 'الأضافات', '2022-07-28 12:11:00', '2022-07-28 13:39:52'),
(213, 4, 'size', 'المقاس', '2022-07-28 12:11:00', '2022-07-28 13:40:06'),
(214, 4, 'extra', 'الأضافة', '2022-07-28 12:11:00', '2022-07-28 13:39:52'),
(215, 4, 'there is no price', 'لا يوجد سعر', '2022-07-28 12:11:00', '2022-07-28 12:12:16'),
(216, 4, 'there is no quantity', 'لا يوجد كمية', '2022-07-28 12:11:00', '2022-07-28 12:12:30'),
(217, 4, 'there is no total price', 'لا يوجد سعر كلى', '2022-07-28 12:11:00', '2022-07-28 12:12:45'),
(218, 4, 'there is no sizes', 'لا يوجد مقاسات', '2022-07-28 12:11:00', '2022-07-28 12:12:39'),
(219, 4, 'there is no extras', 'لا يوجد اضافات', '2022-07-28 12:11:00', '2022-07-28 12:12:03'),
(220, 4, 'there is no foods in the branch yet', 'لا يوجد اطعمة فى الفرع', '2022-07-28 12:11:46', '2022-07-28 12:12:12'),
(221, 4, 'create new food', 'انشاء طعام  جديد', '2022-07-28 13:20:54', '2022-07-28 13:22:49'),
(222, 4, 'choose category', 'أختر الصنف', '2022-07-28 13:20:54', '2022-07-28 13:38:13'),
(223, 4, 'appearance number', 'رقم الظهور', '2022-07-28 13:20:54', '2022-07-28 13:22:30'),
(224, 4, 'available', 'متوفر', '2022-07-28 13:20:54', '2022-07-28 13:23:03'),
(225, 4, 'not available', 'غير متوفر', '2022-07-28 13:20:54', '2022-07-28 13:23:08'),
(226, 4, 'from', 'من', '2022-07-28 13:20:54', '2022-07-28 13:38:58'),
(227, 4, 'to', 'الى', '2022-07-28 13:20:54', '2022-07-28 13:39:07'),
(228, 4, 'category', 'الصنف', '2022-07-28 13:20:54', '2022-07-28 13:39:18'),
(229, 4, 'show', 'اظهار', '2022-07-28 13:20:54', '2022-07-28 13:24:08'),
(230, 4, 'create new category', 'انشاء صنف جديد', '2022-07-28 13:20:56', '2022-07-28 13:22:49'),
(231, 4, 'category name', 'أسم الصنف', '2022-07-28 13:20:56', '2022-07-28 13:21:54'),
(232, 4, 'products count', 'عدد المنتجات', '2022-07-28 13:20:56', '2022-08-15 15:16:36'),
(233, 4, 'category image', 'صورة الصنف', '2022-07-28 13:23:16', '2022-07-28 13:23:29'),
(234, 4, 'back to categories', 'الرجوع الى الأصناف', '2022-07-28 13:23:16', '2022-07-28 13:23:46'),
(235, 4, 'edit category', 'تعديل الصنف', '2022-07-28 13:37:29', '2022-07-28 13:37:40'),
(236, 4, 'food images', 'صور الطعام', '2022-07-28 13:40:12', '2022-07-30 11:35:16'),
(237, 4, 'you should choose maximum 5 images', 'يجب عليك أختيار أقل من 5 صور', '2022-07-28 13:40:12', '2022-07-30 10:59:09'),
(238, 4, 'back to foods', 'الرجوع الى الأطعمة', '2022-07-28 13:40:12', '2022-07-28 13:40:37'),
(239, 4, 'add', 'اضافة', '2022-07-28 13:40:12', '2022-07-30 12:42:39'),
(240, 4, 'there is something error', 'يوجد خطأ ما', '2022-07-28 13:40:12', '2022-08-08 11:35:03'),
(241, 4, 'remove', 'ازالة', '2022-07-28 13:40:12', '2022-07-28 13:41:11'),
(242, 4, 'edit food', 'تعديل الطعام', '2022-07-28 13:40:44', '2022-07-28 13:40:55'),
(243, 4, 'countries', 'الدول', '2022-07-28 13:41:18', '2022-07-28 13:41:34'),
(244, 4, 'create new country', 'انشاء دولة جديدة', '2022-07-28 13:41:18', '2022-07-28 13:42:03'),
(245, 4, 'country name', 'اسم الدولة', '2022-07-28 13:41:18', '2022-07-28 13:41:56'),
(246, 4, 'country code', 'كود الدولة', '2022-07-28 13:41:18', '2022-07-28 13:41:51'),
(247, 4, 'country cities', 'مدن الدولة', '2022-07-28 13:41:18', '2022-07-28 13:41:43'),
(248, 4, 'back to countries', 'الرجوع الى الدول', '2022-07-28 13:42:08', '2022-07-28 13:42:22'),
(249, 4, 'edit country', 'تعديل الدولة', '2022-07-28 13:42:28', '2022-07-28 13:42:43'),
(250, 4, 'employees', 'الموظفين', '2022-07-28 13:42:49', '2022-07-28 13:43:09'),
(251, 4, 'create employee', 'انشاء موظفين', '2022-07-28 13:42:49', '2022-07-28 13:43:09'),
(252, 4, 'employee name', 'أسم الموظف', '2022-07-28 13:42:49', '2022-07-28 13:43:14'),
(253, 4, 'email', 'البريد الألكترونى', '2022-07-28 13:42:49', '2022-07-28 13:43:48'),
(254, 4, 'banned', 'محذور', '2022-07-28 13:42:49', '2022-07-28 13:43:31'),
(255, 4, 'not banned', 'غير محذور', '2022-07-28 13:42:49', '2022-07-28 13:43:35'),
(256, 4, 'address', 'العنوان', '2022-07-28 13:42:49', '2022-07-28 13:43:57'),
(257, 4, 'create new employee', 'انشاء موظف جديد', '2022-07-28 13:44:01', '2022-07-28 13:44:25'),
(258, 4, 'all employees', 'كل الموظفين', '2022-07-28 13:44:01', '2022-07-28 13:46:01'),
(259, 4, 'profile picture', 'الصورة الشخصية', '2022-07-28 13:44:01', '2022-07-28 13:44:12'),
(260, 4, 'password', 'الرقم السرى', '2022-07-28 13:44:01', '2022-07-28 13:44:37'),
(261, 4, 'password confirmation', 'تأكيد الرقم السرى', '2022-07-28 13:44:01', '2022-07-28 13:44:42'),
(262, 4, 'register', 'تسجيل الحساب', '2022-07-28 13:44:01', '2022-07-28 13:45:11'),
(263, 4, 'back to employees', 'الرجوع الى الموظفين', '2022-07-28 13:44:01', '2022-07-28 13:44:57'),
(264, 4, 'the type is required', 'النوع مطلوب', '2022-07-28 13:45:34', '2022-07-30 10:31:41'),
(265, 4, 'the name should be letters', 'the name should be letters', '2022-07-28 13:45:34', '2022-07-28 13:45:34'),
(266, 4, 'you should enter a letters at least 255', 'يجب عليك ان لا تتعدى ال 225 حرف', '2022-07-28 13:45:34', '2022-07-30 10:59:36'),
(267, 4, 'the email is required', 'البريد الألكترونى مطلوب', '2022-07-28 13:45:34', '2022-07-30 11:12:26'),
(268, 4, 'the email sould be letters', 'the email sould be letters', '2022-07-28 13:45:34', '2022-07-28 13:45:34'),
(269, 4, 'the email is already exists', 'the email is already exists', '2022-07-28 13:45:34', '2022-07-28 13:45:34'),
(270, 4, 'the password is required', 'الرقم السرى مطلوب', '2022-07-28 13:45:34', '2022-07-30 11:12:35'),
(271, 4, 'the password sould be letters', 'the password sould be letters', '2022-07-28 13:45:34', '2022-07-28 13:45:34'),
(272, 4, 'you should enter a password bigger than 8 letters', 'يجب عليك ان تكتب رقم سرى اكبر من 8 حروف', '2022-07-28 13:45:34', '2022-07-30 10:59:50'),
(273, 4, 'the password should be matches', 'the password should be matches', '2022-07-28 13:45:34', '2022-07-28 13:45:34'),
(274, 4, 'you should choose branch', 'يجب عليك أختيار فرع', '2022-07-28 13:45:34', '2022-07-30 10:59:09'),
(275, 4, 'the permessions is required', 'التصاريح مطلوبة', '2022-07-28 13:45:34', '2022-07-28 13:47:10'),
(276, 4, 'the permessions is not in the infos', 'التصاريح ليست في بقية المقال', '2022-07-28 13:45:34', '2022-07-28 13:47:10'),
(277, 4, 'employee in', 'موظف فى', '2022-07-28 13:45:36', '2022-08-17 10:17:06'),
(278, 4, 'edit employee', 'تعديل الموظف', '2022-07-28 13:45:41', '2022-07-28 13:45:52'),
(279, 4, 'users', 'المستخدمين', '2022-07-28 13:46:11', '2022-07-28 13:46:17'),
(280, 4, 'create new permession', 'انشاء صلاحيات', '2022-07-28 13:46:25', '2022-07-28 13:46:41'),
(281, 4, 'permession name', 'أسم الصلاحية', '2022-07-28 13:46:25', '2022-07-28 13:46:41'),
(282, 4, 'permessions count', 'عدد الصلاحيات', '2022-07-28 13:46:25', '2022-07-28 13:46:47'),
(283, 4, 'edit permession', 'تعديل الصلاحية', '2022-07-28 13:47:15', '2022-07-28 13:47:26'),
(284, 4, 'back to permessions', 'الرجوع الى الصلاحيات', '2022-07-28 13:47:15', '2022-07-28 13:47:45'),
(285, 4, 'deleted successfully', 'تمت الأزالة بنجاح', '2022-07-28 13:48:21', '2022-07-28 13:48:35'),
(286, 4, 'languages', 'اللغات', '2022-07-30 10:23:13', '2022-07-30 10:24:03'),
(287, 4, 'create new language', 'انشاء لغة جديدة', '2022-07-30 10:23:13', '2022-07-30 10:24:32'),
(288, 4, 'language name', 'أسم اللغة', '2022-07-30 10:23:13', '2022-07-30 10:24:15'),
(289, 4, 'translations link', 'لينك الترجمات', '2022-07-30 10:23:13', '2022-07-30 10:24:58'),
(290, 4, 'translation name', 'أسم الترجمة', '2022-07-30 10:23:13', '2022-07-30 10:29:00'),
(291, 4, 'translation code', 'كود الترجمة', '2022-07-30 10:23:13', '2022-07-30 10:29:00'),
(292, 4, 'translation region', 'الترجمةاللغة', '2022-07-30 10:23:13', '2022-07-30 10:29:00'),
(293, 4, 'translations', 'الترجمات', '2022-07-30 10:23:50', '2022-07-30 10:24:58'),
(294, 4, 'translation key', 'مفتاح الترجمة', '2022-07-30 10:23:50', '2022-07-30 10:29:00'),
(295, 4, 'translation value', 'قيمة الترجمة', '2022-07-30 10:23:50', '2022-07-30 10:29:00'),
(296, 4, 'language', 'لغة', '2022-07-30 10:25:54', '2022-07-30 10:26:11'),
(297, 4, 'back to languages', 'الرجوع الى اللغات', '2022-07-30 10:25:54', '2022-07-30 10:26:07'),
(298, 4, 'there is no financial', 'لا يوجد معاملات مالية', '2022-07-30 10:34:22', '2022-07-30 10:35:09'),
(299, 4, 'you should create category first', 'يجب عليك أنشاء صنف أولا', '2022-07-30 10:58:25', '2022-07-30 10:59:18'),
(300, 4, 'translations updated', 'تم تعديل الترجمة', '2022-07-30 10:59:09', '2022-07-30 19:56:18'),
(301, 4, 'you should create branch', 'يجب عليك انشاء فرع', '2022-07-30 11:00:36', '2022-07-30 11:00:55'),
(302, 4, 'you should choose a name is not already exists', 'يجب عليك أختيار أسم غير موجود', '2022-07-30 11:01:20', '2022-07-31 11:49:15'),
(303, 4, 'the address is required', 'العنوان مطلوب', '2022-07-30 11:01:20', '2022-07-30 11:12:12'),
(304, 4, 'the phone is required', 'رقم الموبيل مطلوب', '2022-07-30 11:01:20', '2022-07-30 11:12:41'),
(305, 4, 'there is no branches', 'لا يوجد فروع', '2022-07-30 11:05:21', '2022-07-30 11:05:30'),
(306, 4, 'the branch is required', 'الفرع مطلوب', '2022-07-30 11:10:39', '2022-07-30 11:12:17'),
(307, 4, 'the branch should be exists', 'the branch should be exists', '2022-07-30 11:10:39', '2022-07-30 11:10:39'),
(308, 4, 'there is no foods', 'لا يوجد اطعمة', '2022-07-30 11:34:39', '2022-07-30 11:34:58'),
(309, 3, 'create', 'create', '2022-07-30 12:19:34', '2022-07-30 12:19:34'),
(310, 3, 'branch name', 'branch name', '2022-07-30 12:19:34', '2022-07-30 12:19:34'),
(311, 3, 'branch phone', 'branch phone', '2022-07-30 12:19:34', '2022-07-30 12:19:34'),
(312, 3, 'branch address', 'branch address', '2022-07-30 12:19:34', '2022-07-30 12:19:34'),
(313, 3, 'there is no branches', 'there is no branches', '2022-07-30 12:29:00', '2022-07-30 12:29:00'),
(314, 4, 'eldokki', 'الدقى', '2022-07-30 12:30:24', '2022-07-30 12:30:37'),
(315, 4, 'elddokki behind station', 'الدقى جنب المترو', '2022-07-30 12:30:57', '2022-07-30 12:31:05'),
(316, 3, 'eldokki', 'eldokki', '2022-07-30 12:31:09', '2022-07-30 12:31:09'),
(317, 3, 'elddokki behind station', 'elddokki behind station', '2022-07-30 12:31:09', '2022-07-30 12:31:09'),
(318, 4, 'elmohandesen', 'المهندسين', '2022-07-30 12:31:36', '2022-07-30 12:31:46'),
(319, 4, 'elmohandeses after staion park', 'المهندسين بعد الجنينة', '2022-07-30 12:31:36', '2022-07-30 12:32:05'),
(320, 3, 'create new category', 'create new category', '2022-07-30 12:33:43', '2022-07-30 12:33:43'),
(321, 3, 'category name', 'category name', '2022-07-30 12:33:43', '2022-07-30 12:33:43'),
(322, 3, 'elmohandesen', 'elmohandesen', '2022-07-30 12:33:43', '2022-07-30 12:33:43'),
(323, 3, 'products count', 'products count', '2022-07-30 12:33:43', '2022-07-30 12:33:43'),
(324, 3, 'available', 'available', '2022-07-30 12:33:43', '2022-07-30 12:33:43'),
(325, 3, 'appearance number', 'appearance number', '2022-07-30 12:33:43', '2022-07-30 12:33:43'),
(326, 3, 'category image', 'category image', '2022-07-30 12:34:13', '2022-07-30 12:34:13'),
(327, 3, 'back to categories', 'back to categories', '2022-07-30 12:34:13', '2022-07-30 12:34:13'),
(328, 4, 'the category is required', 'الصنف مطلوب', '2022-07-30 12:43:00', '2022-08-15 15:34:00'),
(329, 4, 'the category should be exists', 'the category should be exists', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(330, 4, 'the discount should be a number', 'الخصم يجب ان يكون من نوع رقم', '2022-07-30 12:43:00', '2022-08-15 15:39:23'),
(331, 4, 'the viewed number should be a number', 'the viewed number should be a number', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(332, 4, 'the extra is required', 'الأضافة مطلوبة', '2022-07-30 12:43:00', '2022-08-15 17:42:08'),
(333, 4, 'currency required', 'currency required', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(334, 4, 'currency should be in the currencies', 'currency should be in the currencies', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(335, 4, 'the size is required', 'المقاس مطلوب', '2022-07-30 13:39:36', '2022-08-15 17:20:04'),
(336, 4, 'filter', 'تصفية', '2022-07-30 13:52:28', '2022-07-30 13:54:08'),
(337, 3, 'password', 'password', '2022-07-30 19:28:58', '2022-07-30 19:28:58'),
(338, 3, 'remember me', 'remember me', '2022-07-30 19:28:58', '2022-07-30 19:28:58'),
(339, 3, 'login', 'login', '2022-07-30 19:28:58', '2022-07-30 19:28:58'),
(340, 4, 'remember me', 'تذكرنى', '2022-07-30 19:29:02', '2022-08-17 17:03:51'),
(341, 4, 'login', 'تسجيل الدخول', '2022-07-30 19:29:02', '2022-08-17 17:04:00'),
(342, 4, 'choose branch', 'أختر الفرع', '2022-07-30 19:38:49', '2022-07-30 19:39:17'),
(343, 4, 'edit profile', 'تعديل الملف الشخصى', '2022-07-30 19:55:35', '2022-07-30 19:55:48'),
(344, 4, 'back to dashboard', 'الرجوع الى لوحة التحكم', '2022-07-30 19:55:35', '2022-07-30 19:56:03'),
(345, 4, 'there is no orders', 'لا يوجد طلبات', '2022-07-30 20:07:30', '2022-07-30 20:10:00'),
(346, 4, 'you should choose a type from the stock', 'you should choose a type from the stock', '2022-07-30 20:35:15', '2022-07-30 20:35:15'),
(347, 4, 'you should choose a minmum 1 product', 'يجب أختيار منتج واحد على الأقل', '2022-07-30 20:35:15', '2022-08-15 15:16:41'),
(348, 4, 'the amount is required', 'the amount is required', '2022-07-30 20:35:15', '2022-07-30 20:35:15'),
(349, 4, 'the amount should be at least 1', 'the amount should be at least 1', '2022-07-30 20:35:15', '2022-07-30 20:35:15'),
(350, 4, 'new order', 'طلب جديد', '2022-07-30 20:38:11', '2022-07-31 10:52:58'),
(351, 4, 'status', 'الحالة', '2022-07-30 20:38:11', '2022-07-31 11:10:22'),
(352, 4, 'foods count', 'عدد الأطعمة', '2022-07-30 20:38:11', '2022-07-31 10:52:45'),
(353, 4, 'there is no name', 'لا يوجد أسم', '2022-07-30 20:38:22', '2022-08-08 11:34:13'),
(354, 4, 'there is no address', 'لا يوجد عنوان', '2022-07-30 20:38:22', '2022-08-08 11:34:05'),
(355, 4, 'there is no city', 'there is no city', '2022-07-30 20:38:22', '2022-07-30 20:38:22'),
(356, 4, 'there is no phone', 'لا يوجد موبيل', '2022-07-30 20:38:22', '2022-08-08 11:34:18'),
(357, 4, 'final price', 'السعر النهائى', '2022-07-30 20:38:22', '2022-07-30 20:42:26'),
(358, 4, 'order show', 'اظهار الطلب', '2022-07-30 20:45:23', '2022-07-31 11:08:30'),
(359, 4, 'order summary', 'ملخص الطلب', '2022-07-30 20:45:23', '2022-07-30 20:47:26'),
(360, 4, 'count', 'العدد', '2022-07-30 20:45:23', '2022-07-30 20:52:37'),
(361, 4, 'order quantity', 'order quantity', '2022-07-30 20:45:23', '2022-07-30 20:45:23'),
(362, 4, 'total price withoud extras', 'السعر الكلى بدون اضافات', '2022-07-30 20:45:23', '2022-07-30 20:46:57'),
(363, 4, 'total price of extras', 'سعر الأضافات الكلى', '2022-07-30 20:45:23', '2022-07-30 20:47:11'),
(364, 4, 'order status history', 'تاريخ حالات الطلب', '2022-07-30 20:45:23', '2022-07-30 20:46:38'),
(365, 4, 'name of the user who changed the status', 'أسم المستخدم الذى غير حالة الطلب', '2022-07-30 20:45:23', '2022-07-30 20:46:21'),
(366, 4, 'edit order', 'تعديل الطلب', '2022-07-30 20:52:59', '2022-08-25 14:45:43'),
(367, 4, 'the city is required', 'المدينة مطلوبة', '2022-07-31 10:36:27', '2022-07-31 10:36:39'),
(368, 4, 'there is no countries', 'لا يوجد دول', '2022-07-31 10:38:34', '2022-07-31 10:38:42'),
(369, 4, 'you should choose a name is not exists', 'يجب عليك أختيار أسم غير موجود', '2022-07-31 10:39:07', '2022-07-31 11:49:37'),
(370, 4, 'cities', 'المدن', '2022-07-31 10:39:24', '2022-07-31 10:39:50'),
(371, 4, 'create new city', 'انشاء مدينة جديدة', '2022-07-31 10:39:24', '2022-07-31 10:39:38'),
(372, 4, 'city name', 'أسم المدينة', '2022-07-31 10:39:24', '2022-07-31 10:40:00'),
(373, 4, 'shipping price', 'سعر الشحن', '2022-07-31 10:40:21', '2022-07-31 10:40:59'),
(374, 4, 'back to cities', 'الرجوع الى المدن', '2022-07-31 10:40:21', '2022-07-31 10:41:13'),
(375, 4, 'the country is required', 'the country is required', '2022-07-31 10:41:33', '2022-07-31 10:41:33'),
(376, 4, 'edit city', 'تعديل المدينة', '2022-07-31 10:43:35', '2022-07-31 10:43:47'),
(377, 3, 'filter', 'filter', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(378, 3, 'customer name', 'customer name', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(379, 3, 'customer phone', 'customer phone', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(380, 3, 'customer address', 'customer address', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(381, 3, 'order status', 'order status', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(382, 3, 'order type', 'order type', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(383, 3, 'receipt request from the branch', 'receipt request from the branch', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(384, 3, 'online order', 'online order', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(385, 3, 'order number', 'order number', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(386, 3, 'currency', 'currency', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(387, 3, 'city', 'city', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(388, 3, 'paid', 'paid', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(389, 3, 'order branch', 'order branch', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(390, 3, 'show', 'show', '2022-07-31 11:05:03', '2022-07-31 11:05:03'),
(391, 3, 'price', 'price', '2022-07-31 11:05:04', '2022-07-31 11:05:04'),
(392, 3, 'quantity', 'quantity', '2022-07-31 11:05:04', '2022-07-31 11:05:04'),
(393, 3, 'total price', 'total price', '2022-07-31 11:05:04', '2022-07-31 11:05:04'),
(394, 3, 'extra', 'extra', '2022-07-31 11:05:04', '2022-07-31 11:05:04'),
(395, 3, 'discount', 'discount', '2022-07-31 11:05:04', '2022-07-31 11:05:04'),
(396, 3, 'final price', 'final price', '2022-07-31 11:05:04', '2022-07-31 11:05:04'),
(397, 3, 'size', 'size', '2022-07-31 11:05:04', '2022-07-31 11:05:04'),
(398, 4, 'order details', 'تفاصيل الطلب', '2022-07-31 11:07:27', '2022-07-31 11:08:12'),
(399, 4, 'quick edit', 'تحرير سريع', '2022-07-31 11:30:35', '2022-07-31 11:32:03'),
(400, 3, 'quick edit', 'quick edit', '2022-07-31 11:38:29', '2022-07-31 11:38:29'),
(401, 4, 'shipping invoice', 'بوليصة الشحن', '2022-07-31 11:42:21', '2022-07-31 11:50:05'),
(402, 4, 'you should choose a 1 minimum of orders', 'يجب عليك أختيار طلب واحد على الأقل', '2022-07-31 11:48:31', '2022-07-31 11:49:02'),
(403, 4, 'order invoice', 'بوليصة الطلب', '2022-07-31 11:50:25', '2022-07-31 11:50:35'),
(404, 3, 'new order', 'new order', '2022-07-31 13:14:48', '2022-07-31 13:14:48'),
(405, 3, 'status', 'status', '2022-07-31 13:14:48', '2022-07-31 13:14:48'),
(406, 3, 'foods count', 'foods count', '2022-07-31 13:14:48', '2022-07-31 13:14:48'),
(407, 4, 'change order status', 'تعديل حالة الطلب', '2022-07-31 13:23:01', '2022-07-31 13:24:03'),
(408, 4, 'Close', 'اغلاق', '2022-07-31 13:27:24', '2022-07-31 13:27:43'),
(409, 4, 'Save', 'حفظ', '2022-07-31 13:27:24', '2022-07-31 13:27:51'),
(410, 4, 'you should choose status', 'يجب أختيار الحالة', '2022-07-31 18:26:29', '2022-07-31 18:26:46'),
(411, 4, 'updated successfuly', 'updated successfuly', '2022-07-31 18:29:07', '2022-07-31 18:29:07'),
(412, 4, 'unpaid', 'غير مدفوع', '2022-08-06 11:09:03', '2022-08-06 11:10:25'),
(413, 4, 'inhouse', 'أستلام من الفرع', '2022-08-06 12:20:53', '2022-08-06 12:21:14'),
(414, 4, 'asd', 'asd', '2022-08-06 12:38:22', '2022-08-06 12:38:22'),
(415, 4, 'qty', 'qty', '2022-08-06 12:44:04', '2022-08-06 12:44:04'),
(416, 4, 'main', 'الرئيسية', '2022-08-08 10:50:36', '2022-08-08 10:52:23'),
(417, 4, 'account', 'حسابى', '2022-08-08 10:52:44', '2022-08-08 10:52:58'),
(418, 4, 'cart', 'السلة', '2022-08-08 10:53:54', '2022-08-08 10:54:00'),
(419, 3, 'main', 'main', '2022-08-08 11:01:37', '2022-08-08 11:01:37'),
(420, 3, 'account', 'account', '2022-08-08 11:01:37', '2022-08-08 11:01:37'),
(421, 3, 'cart', 'cart', '2022-08-08 11:01:37', '2022-08-08 11:01:37'),
(422, 3, 'search for foods', 'search for foods', '2022-08-08 11:05:42', '2022-08-08 11:05:42'),
(423, 3, 'search by food name', 'search by food name', '2022-08-08 11:05:42', '2022-08-08 11:05:42'),
(424, 4, 'search for foods', 'بحث عن طعام', '2022-08-08 11:05:50', '2022-08-08 11:06:03'),
(425, 4, 'search by food name', 'بحث بأسم الطعام', '2022-08-08 11:05:50', '2022-08-08 11:06:16'),
(428, 3, 'cart is empty', 'cart is empty', '2022-08-08 11:38:39', '2022-08-08 11:38:39'),
(429, 3, 'cart is empty', 'cart is empty', '2022-08-08 11:51:02', '2022-08-08 11:51:02'),
(430, 4, 'cart is empty', 'السلة فارغة', '2022-08-08 11:51:41', '2022-08-08 11:51:53'),
(431, 4, 'edit successfully', 'edit successfully', '2022-08-08 12:09:30', '2022-08-08 12:09:30'),
(432, 4, 'the transaction must be an expense or income', 'the transaction must be an expense or income', '2022-08-09 13:07:58', '2022-08-09 13:07:58'),
(433, 4, 'there is no categories', 'there is no categories', '2022-08-15 15:11:03', '2022-08-15 15:11:03'),
(434, 4, 'all products', 'كل المنتجات', '2022-08-15 15:16:02', '2022-08-15 15:16:36'),
(435, 4, 'create product', 'انشاء منتج', '2022-08-15 15:16:02', '2022-08-15 15:16:36'),
(436, 4, 'product name', 'أسم المنتج', '2022-08-15 15:17:18', '2022-08-15 15:17:45'),
(437, 4, 'there is no products', 'لا يوجد منتجات', '2022-08-15 15:17:58', '2022-08-15 15:18:09'),
(438, 4, 'create new product', 'انشاء منتج جديد', '2022-08-15 15:18:39', '2022-08-15 15:18:50'),
(439, 4, 'product images', 'صور المنتج', '2022-08-15 15:19:19', '2022-08-15 15:19:35'),
(440, 4, 'you should create branch and currency first', 'you should create branch and currency first', '2022-08-15 15:22:05', '2022-08-15 15:22:05'),
(441, 4, 'back to products', 'الرجوع الى المنتجات', '2022-08-17 09:01:19', '2022-08-17 09:01:50'),
(442, 4, 'product count', 'كمية المنتج', '2022-08-17 09:51:56', '2022-08-17 09:52:13'),
(443, 4, 'information about', 'معلومات عن', '2022-08-17 09:59:21', '2022-08-17 09:59:31'),
(444, 4, 'asdasdasdas', 'asdasdasdas', '2022-08-17 17:11:03', '2022-08-17 17:11:03'),
(445, 4, '7st ahmed shbeb', '7st ahmed shbeb', '2022-08-17 17:11:03', '2022-08-17 17:11:03'),
(446, 4, 'asdasdasxc', 'asdasdasxc', '2022-08-17 17:11:35', '2022-08-17 17:11:35'),
(447, 4, 'asdkjasl', 'asdkjasl', '2022-08-17 17:11:35', '2022-08-17 17:11:35'),
(448, 4, 'there is no results', 'لا يوجد نتائج', '2022-08-20 08:51:53', '2022-08-20 08:57:09'),
(449, 4, 'staff', 'الموظفين', '2022-08-20 08:54:53', '2022-08-20 08:55:06'),
(450, 4, 'role_type', 'role_type', '2022-08-20 09:05:43', '2022-08-20 09:05:43'),
(451, 4, 'online', 'عبر الأنترنت', '2022-08-20 09:05:43', '2022-08-20 09:06:26'),
(452, 4, 'role type', 'صلاحية الأستخدام', '2022-08-20 09:05:52', '2022-08-20 09:06:08'),
(453, 4, 'username', 'أسم المستخدم', '2022-08-20 09:08:57', '2022-08-20 09:09:06'),
(454, 4, 'the username is required', 'أسم المستخدم مطلوب', '2022-08-20 09:09:12', '2022-08-20 09:09:31'),
(455, 4, 'the username sould be letters', 'the username sould be letters', '2022-08-20 09:09:12', '2022-08-20 09:09:12'),
(456, 4, 'the username is already exists', 'the username is already exists', '2022-08-20 09:09:12', '2022-08-20 09:09:12'),
(457, 4, 'role type is required', 'role type is required', '2022-08-20 09:09:12', '2022-08-20 09:09:12'),
(458, 4, 'role type is not exists', 'role type is not exists', '2022-08-20 09:09:12', '2022-08-20 09:09:12'),
(459, 4, 'city price', 'city price', '2022-08-20 12:27:45', '2022-08-20 12:27:45'),
(460, 4, 'employee order', 'موظف الطلب', '2022-08-20 14:34:09', '2022-08-20 14:35:41'),
(461, 4, 'payment method', 'طريقة الدفع', '2022-08-20 14:57:25', '2022-08-20 14:57:46'),
(462, 4, 'cash', 'cash', '2022-08-20 14:57:25', '2022-08-20 14:57:25'),
(463, 4, 'credit', 'credit', '2022-08-20 14:57:25', '2022-08-20 14:57:25'),
(464, 4, 'bin code', 'كود الموظف', '2022-08-20 14:59:51', '2022-08-22 15:25:11'),
(465, 4, 'coupons', 'coupons', '2022-08-22 17:08:02', '2022-08-22 17:08:02'),
(466, 4, 'all coupons', 'all coupons', '2022-08-22 17:08:32', '2022-08-22 17:08:32'),
(467, 4, 'create coupon', 'create coupon', '2022-08-22 17:09:36', '2022-08-22 17:09:36'),
(468, 4, 'create new coupon', 'create new coupon', '2022-08-22 17:16:39', '2022-08-22 17:16:39'),
(469, 4, 'coupon name', 'coupon name', '2022-08-22 17:16:54', '2022-08-22 17:16:54'),
(470, 4, 'back to coupons', 'back to coupons', '2022-08-22 17:16:54', '2022-08-22 17:16:54'),
(471, 4, 'valid before', 'صالح حتى', '2022-08-22 17:17:50', '2022-08-22 17:20:06'),
(472, 4, 'created at', 'created at', '2022-08-22 17:36:39', '2022-08-22 17:36:39'),
(473, 4, 'options', 'options', '2022-08-22 17:36:39', '2022-08-22 17:36:39'),
(474, 4, 'there is no coupons', 'there is no coupons', '2022-08-22 17:42:01', '2022-08-22 17:42:01'),
(475, 4, 'percent', 'percent', '2022-08-22 17:45:07', '2022-08-22 17:45:07'),
(476, 4, 'price or percent', 'price or percent', '2022-08-22 17:46:02', '2022-08-22 17:46:02'),
(477, 3, 'create new order', 'create new order', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(478, 3, 'payment method', 'payment method', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(479, 3, 'cash', 'cash', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(480, 3, 'credit', 'credit', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(481, 3, 'receipt from the branch', 'receipt from the branch', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(482, 3, 'order branch creation', 'order branch creation', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(483, 3, 'products', 'products', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(484, 3, 'bin code', 'bin code', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(485, 3, 'notes', 'notes', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(486, 3, 'summary', 'summary', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(487, 3, 'shipping', 'shipping', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(488, 3, 'price after discount', 'price after discount', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(489, 3, 'back to orders', 'back to orders', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(490, 3, 'country', 'country', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(491, 3, 'food name', 'food name', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(492, 3, 'sizes', 'sizes', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(493, 3, 'extras', 'extras', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(494, 3, 'there is no price', 'there is no price', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(495, 3, 'there is no quantity', 'there is no quantity', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(496, 3, 'there is no total price', 'there is no total price', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(497, 3, 'there is no sizes', 'there is no sizes', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(498, 3, 'there is no extras', 'there is no extras', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(499, 3, 'coupons', 'coupons', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(500, 3, 'all coupons', 'all coupons', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(501, 3, 'create coupon', 'create coupon', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(502, 3, 'all products', 'all products', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(503, 3, 'create product', 'create product', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(504, 3, 'staff', 'staff', '2022-08-22 17:52:46', '2022-08-22 17:52:46'),
(505, 3, 'coupon', 'coupon', '2022-08-22 17:53:57', '2022-08-22 17:53:57'),
(506, 3, 'submit coupon', 'submit coupon', '2022-08-22 17:58:27', '2022-08-22 17:58:27'),
(507, 4, 'coupon', 'coupon', '2022-08-22 18:01:23', '2022-08-22 18:01:23'),
(508, 4, 'submit coupon', 'submit coupon', '2022-08-22 18:01:23', '2022-08-22 18:01:23'),
(509, 3, 'coupon is invalid', 'coupon is invalid', '2022-08-22 18:02:57', '2022-08-22 18:02:57'),
(510, 3, 'remove', 'remove', '2022-08-22 18:11:52', '2022-08-22 18:11:52'),
(511, 3, 'percent', 'percent', '2022-08-22 18:26:25', '2022-08-22 18:26:25'),
(512, 3, 'the type is required', 'the type is required', '2022-08-22 18:46:57', '2022-08-22 18:46:57'),
(513, 3, 'the branch is required', 'the branch is required', '2022-08-22 18:46:57', '2022-08-22 18:46:57'),
(514, 3, 'the branch should be exists', 'the branch should be exists', '2022-08-22 18:46:57', '2022-08-22 18:46:57'),
(515, 3, 'you should choose a type from the stock', 'you should choose a type from the stock', '2022-08-22 18:46:57', '2022-08-22 18:46:57'),
(516, 3, 'you should choose a minmum 1 product', 'you should choose a minmum 1 product', '2022-08-22 18:46:57', '2022-08-22 18:46:57'),
(517, 3, 'the amount is required', 'the amount is required', '2022-08-22 18:46:57', '2022-08-22 18:46:57'),
(518, 3, 'the amount should be at least 1', 'the amount should be at least 1', '2022-08-22 18:46:57', '2022-08-22 18:46:57'),
(519, 3, 'there is something error', 'there is something error', '2022-08-22 18:46:57', '2022-08-22 18:46:57'),
(520, 3, 'created successfully', 'created successfully', '2022-08-22 18:50:20', '2022-08-22 18:50:20'),
(521, 3, 'change order status', 'change order status', '2022-08-22 18:50:25', '2022-08-22 18:50:25'),
(522, 3, 'Close', 'Close', '2022-08-22 18:50:25', '2022-08-22 18:50:25'),
(523, 3, 'Save', 'Save', '2022-08-22 18:50:25', '2022-08-22 18:50:25'),
(524, 3, 'order invoice', 'order invoice', '2022-08-22 18:50:25', '2022-08-22 18:50:25'),
(525, 3, 'employee order', 'employee order', '2022-08-22 18:50:25', '2022-08-22 18:50:25'),
(526, 3, 'coupon discount', 'coupon discount', '2022-08-22 18:52:58', '2022-08-22 18:52:58'),
(527, 3, 'deleted successfully', 'deleted successfully', '2022-08-22 18:55:01', '2022-08-22 18:55:01'),
(528, 4, 'coupon discount', 'كوبون الخصم', '2022-08-22 19:00:29', '2022-08-24 15:03:22'),
(529, 4, 'times of use', 'عدد مرات الأستخدام', '2022-08-22 19:06:26', '2022-08-22 19:06:51'),
(530, 4, 'coupon is invalid', 'coupon is invalid', '2022-08-22 19:12:56', '2022-08-22 19:12:56'),
(531, 3, 'order show', 'order show', '2022-08-24 14:49:17', '2022-08-24 14:49:17'),
(532, 3, 'inhouse', 'inhouse', '2022-08-24 14:49:17', '2022-08-24 14:49:17'),
(533, 3, 'count', 'count', '2022-08-24 14:49:17', '2022-08-24 14:49:17'),
(534, 3, 'total price withoud extras', 'total price withoud extras', '2022-08-24 14:49:17', '2022-08-24 14:49:17'),
(535, 3, 'order status history', 'order status history', '2022-08-24 14:49:17', '2022-08-24 14:49:17'),
(536, 3, 'name of the user who changed the status', 'name of the user who changed the status', '2022-08-24 14:49:17', '2022-08-24 14:49:17'),
(537, 3, 'order summary', 'order summary', '2022-08-24 14:52:31', '2022-08-24 14:52:31'),
(538, 3, 'there is no discount', 'there is no discount', '2022-08-24 18:08:39', '2022-08-24 18:08:39'),
(539, 3, 'the name is required', 'the name is required', '2022-08-24 18:21:28', '2022-08-24 18:21:28'),
(540, 3, 'the address is required', 'the address is required', '2022-08-24 18:21:28', '2022-08-24 18:21:28'),
(541, 3, 'the phone is required', 'the phone is required', '2022-08-24 18:21:28', '2022-08-24 18:21:28'),
(542, 3, 'the city is required', 'the city is required', '2022-08-24 18:21:28', '2022-08-24 18:21:28'),
(543, 4, 'there is no discount', 'there is no discount', '2022-08-25 13:31:52', '2022-08-25 13:31:52'),
(544, 4, 'custom file', 'custom file', '2022-08-25 13:42:24', '2022-08-25 13:42:24'),
(545, 4, 'custom files', 'custom files', '2022-08-25 14:02:57', '2022-08-25 14:02:57'),
(546, 3, 'order information', 'order information', '2022-08-25 15:39:18', '2022-08-25 15:39:18'),
(547, 3, 'all files', 'all files', '2022-08-25 15:39:51', '2022-08-25 15:39:51'),
(548, 3, 'Delivery Information', 'Delivery Information', '2022-08-25 15:40:32', '2022-08-25 15:40:32'),
(549, 4, 'order information', 'معلومات الطلب', '2022-08-25 15:40:42', '2022-08-26 09:09:15'),
(550, 4, 'Delivery Information', 'معلومات التوصيل', '2022-08-25 15:40:42', '2022-08-26 09:09:05'),
(551, 4, 'all files', 'كل الملفات', '2022-08-25 15:40:42', '2022-08-26 09:08:17'),
(552, 4, 'all orders given to employees', 'all orders given to employees', '2022-08-25 15:48:20', '2022-08-25 15:48:20'),
(553, 4, 'orders given to employees', 'طلبات اكواد الموظفين', '2022-08-25 15:48:31', '2022-08-25 15:49:10'),
(554, 4, 'bin codes orders', 'طلبات كود الموظف', '2022-08-25 15:50:39', '2022-08-25 15:53:47'),
(555, 4, 'employee attached order', 'الموظف المربوط بالطلب', '2022-08-25 15:52:35', '2022-08-25 15:52:50'),
(556, 4, 'creation from', 'creation from', '2022-08-25 15:58:40', '2022-08-25 15:58:40'),
(557, 4, 'creation to', 'creation to', '2022-08-25 16:01:46', '2022-08-25 16:01:46'),
(558, 4, 'reset', 'reset', '2022-08-25 16:03:58', '2022-08-25 16:03:58'),
(559, 4, 'approval', 'approval', '2022-08-25 16:42:22', '2022-08-25 16:42:22');
INSERT INTO `translations` (`id`, `lang_id`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(560, 4, 'approved', 'approved', '2022-08-25 16:42:22', '2022-08-25 16:42:22'),
(561, 4, 'not approved', 'not approved', '2022-08-25 16:42:22', '2022-08-25 16:42:22'),
(562, 4, 'n.o', 'n.o', '2022-08-26 09:54:00', '2022-08-26 09:54:00'),
(563, 4, 'date', 'date', '2022-08-26 09:54:25', '2022-08-26 09:54:25'),
(564, 3, 'n.o', 'n.o', '2022-08-26 09:55:32', '2022-08-26 09:55:32'),
(565, 3, 'date', 'date', '2022-08-26 09:55:32', '2022-08-26 09:55:32'),
(566, 3, 'Desc.', 'Desc.', '2022-08-26 09:58:35', '2022-08-26 09:58:35'),
(567, 3, 'QTY', 'QTY', '2022-08-26 09:58:35', '2022-08-26 09:58:35'),
(568, 3, 'Total', 'Total', '2022-08-26 09:58:35', '2022-08-26 09:58:35'),
(569, 4, 'pos invoice', 'pos invoice', '2022-08-26 11:13:56', '2022-08-26 11:13:56'),
(570, 4, 'Desc.', 'Desc.', '2022-08-26 11:13:59', '2022-08-26 11:13:59'),
(571, 4, 'Total', 'Total', '2022-08-26 11:13:59', '2022-08-26 11:13:59'),
(572, 3, 'pos invoice', 'pos invoice', '2022-08-26 11:14:08', '2022-08-26 11:14:08'),
(573, 3, 'online', 'online', '2022-08-26 11:14:08', '2022-08-26 11:14:08'),
(574, 3, 'orders given to employees', 'orders given to employees', '2022-08-26 11:14:08', '2022-08-26 11:14:08'),
(575, 4, 'online invoice', 'online invoice', '2022-08-26 11:14:42', '2022-08-26 11:14:42'),
(576, 3, 'total price of extras', 'total price of extras', '2022-08-26 11:26:14', '2022-08-26 11:26:14'),
(577, 3, 'extras price', 'extras price', '2022-08-26 11:26:25', '2022-08-26 11:26:25'),
(578, 4, 'you should create branch first', 'you should create branch first', '2022-08-26 12:01:32', '2022-08-26 12:01:32'),
(579, 4, 'employee code', 'كود الموظف', '2022-08-26 16:26:16', '2022-08-26 16:26:30'),
(580, 4, 'المهندسين', 'المهندسين', '2022-08-26 16:28:53', '2022-08-26 16:28:53'),
(581, 4, 'شس4ي5شس6يشسي', 'شس4ي5شس6يشسي', '2022-08-26 16:28:53', '2022-08-26 16:28:53'),
(582, 4, 'الدقى', 'الدقى', '2022-08-26 16:28:53', '2022-08-26 16:28:53'),
(583, 4, 'asdasdlasdk;asd', 'asdasdlasdk;asd', '2022-08-26 16:28:53', '2022-08-26 16:28:53'),
(584, 3, 'المهندسين', 'المهندسين', '2022-08-26 16:28:59', '2022-08-26 16:28:59'),
(585, 3, 'شس4ي5شس6يشسي', 'شس4ي5شس6يشسي', '2022-08-26 16:28:59', '2022-08-26 16:28:59'),
(586, 3, 'الدقى', 'الدقى', '2022-08-26 16:28:59', '2022-08-26 16:28:59'),
(587, 3, 'asdasdlasdk;asd', 'asdasdlasdk;asd', '2022-08-26 16:28:59', '2022-08-26 16:28:59'),
(588, 3, 'there is no categories', 'there is no categories', '2022-08-26 16:29:06', '2022-08-26 16:29:06'),
(589, 3, 'create new product', 'create new product', '2022-08-26 16:30:37', '2022-08-26 16:30:37'),
(590, 3, 'product name', 'product name', '2022-08-26 16:30:37', '2022-08-26 16:30:37'),
(591, 3, 'there is no products', 'there is no products', '2022-08-26 16:31:24', '2022-08-26 16:31:24'),
(592, 3, 'description', 'description', '2022-08-26 16:31:37', '2022-08-26 16:31:37'),
(593, 3, 'choose category', 'choose category', '2022-08-26 16:31:37', '2022-08-26 16:31:37'),
(594, 3, 'not available', 'not available', '2022-08-26 16:31:37', '2022-08-26 16:31:37'),
(595, 3, 'from', 'from', '2022-08-26 16:31:37', '2022-08-26 16:31:37'),
(596, 3, 'to', 'to', '2022-08-26 16:31:37', '2022-08-26 16:31:37'),
(597, 3, 'category', 'category', '2022-08-26 16:31:39', '2022-08-26 16:31:39'),
(598, 3, 'product count', 'product count', '2022-08-26 16:31:39', '2022-08-26 16:31:39'),
(599, 3, 'product images', 'product images', '2022-08-26 16:31:39', '2022-08-26 16:31:39'),
(600, 3, 'you should choose maximum 5 images', 'you should choose maximum 5 images', '2022-08-26 16:31:39', '2022-08-26 16:31:39'),
(601, 3, 'back to products', 'back to products', '2022-08-26 16:31:39', '2022-08-26 16:31:39'),
(602, 3, 'add', 'add', '2022-08-26 16:31:39', '2022-08-26 16:31:39'),
(603, 3, 'the category is required', 'the category is required', '2022-08-26 16:31:53', '2022-08-26 16:31:53'),
(604, 3, 'the category should be exists', 'the category should be exists', '2022-08-26 16:31:53', '2022-08-26 16:31:53'),
(605, 3, 'the price is required', 'the price is required', '2022-08-26 16:31:53', '2022-08-26 16:31:53'),
(606, 3, 'the price should be a number', 'the price should be a number', '2022-08-26 16:31:53', '2022-08-26 16:31:53'),
(607, 3, 'the discount should be a number', 'the discount should be a number', '2022-08-26 16:31:53', '2022-08-26 16:31:53'),
(608, 3, 'the viewed number should be a number', 'the viewed number should be a number', '2022-08-26 16:31:53', '2022-08-26 16:31:53'),
(609, 3, 'information about', 'information about', '2022-08-26 16:32:26', '2022-08-26 16:32:26'),
(610, 3, 'online invoice', 'online invoice', '2022-08-26 16:33:17', '2022-08-26 16:33:17'),
(611, 3, 'creation from', 'creation from', '2022-08-26 16:33:17', '2022-08-26 16:33:17'),
(612, 3, 'creation to', 'creation to', '2022-08-26 16:33:17', '2022-08-26 16:33:17'),
(613, 3, 'there is no orders', 'there is no orders', '2022-08-26 16:33:17', '2022-08-26 16:33:17'),
(614, 3, 'custom files', 'custom files', '2022-08-26 16:33:18', '2022-08-26 16:33:18'),
(615, 3, 'edit order', 'edit order', '2022-08-26 16:45:26', '2022-08-26 16:45:26'),
(616, 3, 'edit food', 'edit food', '2022-08-26 17:02:44', '2022-08-26 17:02:44'),
(617, 3, 'food images', 'food images', '2022-08-26 17:02:44', '2022-08-26 17:02:44'),
(618, 3, 'back to foods', 'back to foods', '2022-08-26 17:02:44', '2022-08-26 17:02:44'),
(619, 3, 'updated successfully', 'updated successfully', '2022-08-26 17:02:50', '2022-08-26 17:02:50'),
(620, 3, 'the extra is required', 'the extra is required', '2022-08-26 17:04:21', '2022-08-26 17:04:21'),
(621, 3, 'total price without extras', 'total price without extras', '2022-08-26 17:17:54', '2022-08-26 17:17:54'),
(622, 3, 'the size is required', 'the size is required', '2022-08-26 17:22:40', '2022-08-26 17:22:40'),
(623, 3, 'pin code', 'pin code', '2022-08-26 17:29:37', '2022-08-26 17:29:37'),
(624, 3, 'pincode', 'pincode', '2022-08-26 17:29:45', '2022-08-26 17:29:45'),
(625, 3, 'back to permessions', 'back to permessions', '2022-08-26 17:33:55', '2022-08-26 17:33:55'),
(626, 3, 'code', 'code', '2022-08-26 17:39:40', '2022-08-26 17:39:40'),
(627, 3, 'there is no coupons', 'there is no coupons', '2022-08-26 17:39:40', '2022-08-26 17:39:40'),
(628, 3, 'create new coupon', 'create new coupon', '2022-08-26 17:40:30', '2022-08-26 17:40:30'),
(629, 3, 'type', 'type', '2022-08-26 17:40:30', '2022-08-26 17:40:30'),
(630, 3, 'price or percent', 'price or percent', '2022-08-26 17:40:30', '2022-08-26 17:40:30'),
(631, 3, 'valid before', 'valid before', '2022-08-26 17:40:30', '2022-08-26 17:40:30'),
(632, 3, 'back to coupons', 'back to coupons', '2022-08-26 17:40:30', '2022-08-26 17:40:30'),
(633, 3, 'times of use', 'times of use', '2022-08-26 17:41:51', '2022-08-26 17:41:51'),
(634, 3, 'created at', 'created at', '2022-08-26 17:41:51', '2022-08-26 17:41:51'),
(635, 3, 'bin codes orders', 'bin codes orders', '2022-08-26 17:42:47', '2022-08-26 17:42:47'),
(636, 3, 'role type', 'role type', '2022-08-26 17:43:43', '2022-08-26 17:43:43'),
(637, 3, 'there is no results', 'there is no results', '2022-08-26 17:43:43', '2022-08-26 17:43:43'),
(638, 3, 'create new employee', 'create new employee', '2022-08-26 17:43:45', '2022-08-26 17:43:45'),
(639, 3, 'all employees', 'all employees', '2022-08-26 17:43:45', '2022-08-26 17:43:45'),
(640, 3, 'username', 'username', '2022-08-26 17:43:45', '2022-08-26 17:43:45'),
(641, 3, 'profile picture', 'profile picture', '2022-08-26 17:43:45', '2022-08-26 17:43:45'),
(642, 3, 'password confirmation', 'password confirmation', '2022-08-26 17:43:45', '2022-08-26 17:43:45'),
(643, 3, 'register', 'register', '2022-08-26 17:43:45', '2022-08-26 17:43:45'),
(644, 3, 'back to employees', 'back to employees', '2022-08-26 17:43:45', '2022-08-26 17:43:45'),
(645, 3, 'employee code', 'employee code', '2022-08-26 17:43:53', '2022-08-26 17:43:53'),
(646, 3, 'statuses', 'statuses', '2022-08-26 17:44:29', '2022-08-26 17:44:29'),
(647, 3, 'status name', 'status name', '2022-08-26 17:44:29', '2022-08-26 17:44:29'),
(648, 3, 'default status', 'default status', '2022-08-26 17:44:29', '2022-08-26 17:44:29'),
(649, 3, 'default', 'default', '2022-08-26 17:44:29', '2022-08-26 17:44:29'),
(650, 3, 'employee attached order', 'employee attached order', '2022-08-26 17:48:33', '2022-08-26 17:48:33'),
(651, 3, 'approval', 'approval', '2022-08-26 17:48:33', '2022-08-26 17:48:33'),
(652, 3, 'not approved', 'not approved', '2022-08-26 17:48:33', '2022-08-26 17:48:33'),
(653, 3, 'updated successfuly', 'updated successfuly', '2022-08-26 17:48:38', '2022-08-26 17:48:38'),
(654, 3, 'approved', 'approved', '2022-08-26 17:48:39', '2022-08-26 17:48:39'),
(655, 3, 'edit employee', 'edit employee', '2022-08-26 17:51:10', '2022-08-26 17:51:10'),
(656, 3, 'the name should be letters', 'the name should be letters', '2022-08-26 17:55:53', '2022-08-26 17:55:53'),
(657, 3, 'you should enter a letters at least 255', 'you should enter a letters at least 255', '2022-08-26 17:55:53', '2022-08-26 17:55:53'),
(658, 3, 'the email is required', 'the email is required', '2022-08-26 17:55:53', '2022-08-26 17:55:53'),
(659, 3, 'the email sould be letters', 'the email sould be letters', '2022-08-26 17:55:53', '2022-08-26 17:55:53'),
(660, 3, 'the email is already exists', 'the email is already exists', '2022-08-26 17:55:53', '2022-08-26 17:55:53'),
(661, 3, 'you should choose branch', 'you should choose branch', '2022-08-26 17:55:53', '2022-08-26 17:55:53'),
(662, 3, 'the permessions is required', 'the permessions is required', '2022-08-26 17:55:53', '2022-08-26 17:55:53'),
(663, 3, 'the permessions is not in the infos', 'the permessions is not in the infos', '2022-08-26 17:55:53', '2022-08-26 17:55:53'),
(664, 4, 'returned', 'returned', '2022-08-27 09:26:40', '2022-08-27 09:26:40'),
(665, 4, 'under collection', 'under collection', '2022-08-27 09:26:40', '2022-08-27 09:26:40'),
(666, 4, 'there is no statuses', 'there is no statuses', '2022-08-27 09:27:49', '2022-08-27 09:27:49'),
(667, 4, 'status type', 'status type', '2022-08-27 09:30:20', '2022-08-27 09:30:20'),
(668, 4, 'there is some thing error', 'there is some thing error', '2022-08-27 09:33:37', '2022-08-27 09:33:37'),
(669, 4, 'all customers', 'all customers', '2022-08-27 09:51:01', '2022-08-27 09:51:01'),
(670, 4, 'create customer', 'create customer', '2022-08-27 09:51:01', '2022-08-27 09:51:01'),
(671, 4, 'customers', 'customers', '2022-08-27 09:51:07', '2022-08-27 09:51:07'),
(672, 4, 'there is no customers', 'there is no customers', '2022-08-27 09:54:28', '2022-08-27 09:54:28'),
(673, 4, 'create new customer', 'create new customer', '2022-08-27 09:55:11', '2022-08-27 09:55:11'),
(674, 4, 'customeres', 'customeres', '2022-08-27 09:55:11', '2022-08-27 09:55:11'),
(675, 4, 'back to customers', 'back to customers', '2022-08-27 09:56:10', '2022-08-27 09:56:10'),
(676, 4, 'عميل جديد', 'عميل جديد', '2022-08-27 09:57:35', '2022-08-27 09:57:35'),
(677, 4, 'asdasdasd67aa75s6da', 'asdasdasd67aa75s6da', '2022-08-27 09:57:35', '2022-08-27 09:57:35'),
(678, 4, 'edit customer', 'edit customer', '2022-08-27 10:01:50', '2022-08-27 10:01:50'),
(679, 4, 'قديم جدا', 'قديم جدا', '2022-08-27 10:03:12', '2022-08-27 10:03:12'),
(680, 4, 'asd;lkas\'dlas', 'asd;lkas\'dlas', '2022-08-27 10:03:12', '2022-08-27 10:03:12'),
(681, 4, 'asdkljas;jads', 'asdkljas;jads', '2022-08-27 10:03:12', '2022-08-27 10:03:12'),
(682, 4, 'sku', 'sku', '2022-08-27 10:08:05', '2022-08-27 10:08:05'),
(683, 4, 'pincode', 'pincode', '2022-08-27 10:16:36', '2022-08-27 10:16:36'),
(684, 3, 'customers', 'customers', '2022-08-27 10:18:33', '2022-08-27 10:18:33'),
(685, 3, 'all customers', 'all customers', '2022-08-27 10:18:33', '2022-08-27 10:18:33'),
(686, 3, 'create customer', 'create customer', '2022-08-27 10:18:33', '2022-08-27 10:18:33'),
(687, 3, 'search form customer', 'search form customer', '2022-08-27 10:25:42', '2022-08-27 10:25:42'),
(688, 3, 'add new customer', 'add new customer', '2022-08-27 10:29:13', '2022-08-27 10:29:13'),
(689, 3, 'search for customer', 'search for customer', '2022-08-27 10:30:39', '2022-08-27 10:30:39'),
(690, 3, 'create new customer', 'create new customer', '2022-08-27 10:37:54', '2022-08-27 10:37:54'),
(691, 3, 'exit', 'exit', '2022-08-27 10:37:54', '2022-08-27 10:37:54'),
(692, 3, 'files', 'files', '2022-08-27 10:51:26', '2022-08-27 10:51:26'),
(693, 3, 'sku', 'sku', '2022-08-27 12:06:21', '2022-08-27 12:06:21'),
(694, 3, 'customer', 'customer', '2022-08-27 13:29:03', '2022-08-27 13:29:03'),
(695, 4, 'customer', 'customer', '2022-08-27 13:29:20', '2022-08-27 13:29:20'),
(696, 4, 'total price without extras', 'total price without extras', '2022-08-27 13:29:20', '2022-08-27 13:29:20'),
(697, 4, 'search for customer', 'search for customer', '2022-08-27 18:09:37', '2022-08-27 18:09:37'),
(698, 4, 'add new customer', 'add new customer', '2022-08-27 18:09:37', '2022-08-27 18:09:37'),
(699, 4, 'files', 'files', '2022-08-27 18:09:37', '2022-08-27 18:09:37'),
(700, 3, 'file removed successfully', 'file removed successfully', '2022-08-27 21:15:17', '2022-08-27 21:15:17'),
(701, 3, 'employee in', 'employee in', '2022-08-27 21:45:48', '2022-08-27 21:45:48'),
(702, 3, 'edit profile', 'edit profile', '2022-08-27 22:06:10', '2022-08-27 22:06:10'),
(703, 3, 'back to dashboard', 'back to dashboard', '2022-08-27 22:06:10', '2022-08-27 22:06:10'),
(704, 3, 'قديم جدا', 'قديم جدا', '2022-08-28 15:19:18', '2022-08-28 15:19:18'),
(705, 3, 'asd;lkas\'dlas', 'asd;lkas\'dlas', '2022-08-28 15:19:18', '2022-08-28 15:19:18'),
(706, 3, 'عميل جديد', 'عميل جديد', '2022-08-28 15:19:18', '2022-08-28 15:19:18'),
(707, 3, 'asdkljas;jads', 'asdkljas;jads', '2022-08-28 15:19:18', '2022-08-28 15:19:18'),
(708, 3, 'order id', 'order id', '2022-08-28 15:20:48', '2022-08-28 15:20:48'),
(709, 3, 'back to customers', 'back to customers', '2022-08-28 15:22:28', '2022-08-28 15:22:28'),
(710, 3, 'regular', 'regular', '2022-08-28 15:25:11', '2022-08-28 15:25:11'),
(711, 3, 'special', 'special', '2022-08-28 15:25:11', '2022-08-28 15:25:11'),
(712, 3, 'you should choose a name is not already exists', 'you should choose a name is not already exists', '2022-08-28 15:26:47', '2022-08-28 15:26:47'),
(713, 3, 'asdasda', 'asdasda', '2022-08-28 15:26:53', '2022-08-28 15:26:53'),
(714, 3, 'asd45as6d456as', 'asd45as6d456as', '2022-08-28 15:26:53', '2022-08-28 15:26:53'),
(715, 3, 'edit customer', 'edit customer', '2022-08-28 15:26:57', '2022-08-28 15:26:57'),
(716, 3, 'there is no customers', 'there is no customers', '2022-08-28 15:29:41', '2022-08-28 15:29:41'),
(717, 3, 'orders count', 'orders count', '2022-08-28 15:33:04', '2022-08-28 15:33:04'),
(718, 4, 'customer email', 'customer email', '2022-08-28 19:30:22', '2022-08-28 19:30:22'),
(719, 4, 'customer type', 'customer type', '2022-08-28 19:30:22', '2022-08-28 19:30:22'),
(720, 4, 'regular', 'regular', '2022-08-28 19:30:22', '2022-08-28 19:30:22'),
(721, 4, 'special', 'special', '2022-08-28 19:30:22', '2022-08-28 19:30:22'),
(722, 3, 'customer email', 'customer email', '2022-08-28 19:32:43', '2022-08-28 19:32:43'),
(723, 3, 'customer type', 'customer type', '2022-08-28 19:32:43', '2022-08-28 19:32:43'),
(724, 3, 'discount type', 'discount type', '2022-08-28 19:34:01', '2022-08-28 19:34:01'),
(725, 3, 'amount', 'amount', '2022-08-28 19:34:01', '2022-08-28 19:34:01'),
(726, 3, 'total orders of branches', 'total orders of branches', '2022-08-29 04:35:19', '2022-08-29 04:35:19'),
(727, 3, 'total orders of online', 'total orders of online', '2022-08-29 04:36:05', '2022-08-29 04:36:05'),
(728, 4, 'order id', 'order id', '2022-08-29 04:39:15', '2022-08-29 04:39:15'),
(729, 4, 'total orders of online', 'total orders of online', '2022-08-29 04:58:49', '2022-08-29 04:58:49'),
(730, 4, 'total orders of branches', 'total orders of branches', '2022-08-29 04:58:49', '2022-08-29 04:58:49'),
(731, 3, 'staff type', 'staff type', '2022-08-29 05:02:33', '2022-08-29 05:02:33'),
(732, 3, 'sub admin', 'sub admin', '2022-08-29 05:02:33', '2022-08-29 05:02:33'),
(733, 3, 'user', 'user', '2022-08-29 05:02:33', '2022-08-29 05:02:33'),
(734, 3, 'the username is required', 'the username is required', '2022-08-29 05:09:34', '2022-08-29 05:09:34'),
(735, 3, 'the username sould be letters', 'the username sould be letters', '2022-08-29 05:09:34', '2022-08-29 05:09:34'),
(736, 3, 'the username is already exists', 'the username is already exists', '2022-08-29 05:09:34', '2022-08-29 05:09:34'),
(737, 3, 'role type is required', 'role type is required', '2022-08-29 05:09:34', '2022-08-29 05:09:34'),
(738, 3, 'role type is not exists', 'role type is not exists', '2022-08-29 05:09:34', '2022-08-29 05:09:34'),
(739, 3, 'the password is required', 'the password is required', '2022-08-29 05:09:34', '2022-08-29 05:09:34'),
(740, 3, 'the password sould be letters', 'the password sould be letters', '2022-08-29 05:09:34', '2022-08-29 05:09:34'),
(741, 3, 'you should enter a password bigger than 8 letters', 'you should enter a password bigger than 8 letters', '2022-08-29 05:09:34', '2022-08-29 05:09:34'),
(742, 3, 'the password should be matches', 'the password should be matches', '2022-08-29 05:09:35', '2022-08-29 05:09:35'),
(743, 4, 'staff type', 'staff type', '2022-08-30 17:12:15', '2022-08-30 17:12:15'),
(744, 4, 'sub admin', 'sub admin', '2022-08-30 17:12:15', '2022-08-30 17:12:15'),
(745, 4, 'user', 'user', '2022-08-30 17:12:15', '2022-08-30 17:12:15'),
(746, 4, 'discount type', 'discount type', '2022-08-30 17:17:18', '2022-08-30 17:17:18'),
(747, 4, 'amount', 'amount', '2022-08-30 17:17:18', '2022-08-30 17:17:18'),
(748, 4, 'export excel', 'export excel', '2022-08-30 17:46:40', '2022-08-30 17:46:40'),
(749, 3, 'export excel', 'export excel', '2022-08-30 18:41:07', '2022-08-30 18:41:07'),
(750, 4, 'approval history', 'approval history', '2022-08-30 18:51:56', '2022-08-30 18:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bin_code` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_type` enum('online','inhouse','','') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('admin','user','sub-admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `branch_id`, `bin_code`, `name`, `username`, `role_type`, `type`, `phone`, `address`, `email`, `avatar`, `banned`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, NULL, NULL, 'admin name', 'admin', NULL, 'admin', '015460456', NULL, 'admin@admin.com', NULL, 0, NULL, '$2y$10$xLvNcTEnsi.y/riSn1/8Eu52rKH0evXAx/5scAl/.demPFyhBwv.a', 'FyomV97NCbzeYHX2nUZnSDCmNXSrkoKVFofNYPrKNQMF76sNz4S4mEnZ5fVX', '2022-07-30 10:38:55', '2022-08-26 12:04:48'),
(14, NULL, 3046, 'moza', 'moza', 'online', 'user', '0150465546', 'asdasdasd', 'moza@gmail.com', NULL, 0, NULL, '$2y$10$scGrTcs/UVatLfbN9Qe/heQqj6dAIclOG6eJ3By4RQA3m01xE2vBG', NULL, '2022-08-26 16:25:22', '2022-08-26 17:58:41'),
(15, 29, 6343, 'asd', 'asd', 'inhouse', 'user', '4054056456', '5456', 'asd@asd.com', NULL, 0, NULL, '$2y$10$GFXE0zbnNKVgTNYI3feTheWbhHBFjl.NeIZ3pqL5ytlkC35G93iH2', NULL, '2022-08-27 21:39:57', '2022-08-27 21:39:57'),
(16, NULL, 6042, 'kareem', 'kareem', NULL, 'sub-admin', 'as5f54asf456asa', 'as546f456a4564fas', 'kareem@gmail.com', NULL, 0, NULL, '$2y$10$YXWzd.F0ivZdWMqkO.a4c.Ezg50UFkErKiihMbq/SQ6QCT/yqwSJu', NULL, '2022-08-29 05:12:01', '2022-08-29 05:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(19, 14, 6, '2022-08-26 17:58:41', '2022-08-26 17:58:41'),
(20, 15, 6, '2022-08-27 21:39:57', '2022-08-27 21:39:57'),
(21, 16, 6, '2022-08-29 05:12:01', '2022-08-29 05:12:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval_histories`
--
ALTER TABLE `approval_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches_categories`
--
ALTER TABLE `branches_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branches_categories_category_id_foreign` (`category_id`),
  ADD KEY `branches_categories_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `businesses_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_products`
--
ALTER TABLE `categories_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_products_category_id_foreign` (`category_id`),
  ADD KEY `categories_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_name_unique` (`name`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`),
  ADD UNIQUE KEY `countries_code_unique` (`code`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_cards`
--
ALTER TABLE `customer_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_cards_card_id_unique` (`card_id`),
  ADD KEY `customer_cards_user_id_foreign` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_type_foreign` (`type`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_code_unique` (`code`),
  ADD UNIQUE KEY `languages_regional_unique` (`regional`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_city_id_foreign` (`city_id`),
  ADD KEY `orders_status_id_foreign` (`status_id`),
  ADD KEY `orders_branch_id_foreign` (`branch_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_details_order_id_foreign` (`order_id`),
  ADD KEY `orders_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `orders_views`
--
ALTER TABLE `orders_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_views_order_id_foreign` (`order_id`),
  ADD KEY `orders_views_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_user_id_order_id_unique` (`user_id`,`order_id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `payment_customers`
--
ALTER TABLE `payment_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_customers_user_id_unique` (`user_id`);

--
-- Indexes for table `permessions`
--
ALTER TABLE `permessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permessions_name_key_unique` (`name`,`key`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_prices`
--
ALTER TABLE `products_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_variations`
--
ALTER TABLE `products_variations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_variations_product_id_variant_unique` (`product_id`,`variant`);

--
-- Indexes for table `products_variations_prices`
--
ALTER TABLE `products_variations_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_variations_prices_product_id_foreign` (`product_id`),
  ADD KEY `products_variations_prices_variant_id_foreign` (`variant_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `roles_permessions`
--
ALTER TABLE `roles_permessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_permessions_role_id_permession_id_unique` (`role_id`,`permession_id`),
  ADD KEY `roles_permessions_permession_id_foreign` (`permession_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_type_unique` (`type`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses_histroy`
--
ALTER TABLE `statuses_histroy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statuses_histroy_user_id_foreign` (`user_id`),
  ADD KEY `statuses_histroy_status_id_foreign` (`status_id`),
  ADD KEY `statuses_histroy_order_id_foreign` (`order_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_lang_id_foreign` (`lang_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `users_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_roles_user_id_role_id_unique` (`user_id`,`role_id`),
  ADD KEY `users_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approval_histories`
--
ALTER TABLE `approval_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `branches_categories`
--
ALTER TABLE `branches_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `categories_products`
--
ALTER TABLE `categories_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_cards`
--
ALTER TABLE `customer_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=442;

--
-- AUTO_INCREMENT for table `orders_views`
--
ALTER TABLE `orders_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_customers`
--
ALTER TABLE `payment_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permessions`
--
ALTER TABLE `permessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `products_prices`
--
ALTER TABLE `products_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `products_variations`
--
ALTER TABLE `products_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `products_variations_prices`
--
ALTER TABLE `products_variations_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles_permessions`
--
ALTER TABLE `roles_permessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `statuses_histroy`
--
ALTER TABLE `statuses_histroy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=751;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches_categories`
--
ALTER TABLE `branches_categories`
  ADD CONSTRAINT `branches_categories_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branches_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `businesses`
--
ALTER TABLE `businesses`
  ADD CONSTRAINT `businesses_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `categories_products`
--
ALTER TABLE `categories_products`
  ADD CONSTRAINT `categories_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_cards`
--
ALTER TABLE `customer_cards`
  ADD CONSTRAINT `customer_cards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_type_foreign` FOREIGN KEY (`type`) REFERENCES `businesses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD CONSTRAINT `orders_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_views`
--
ALTER TABLE `orders_views`
  ADD CONSTRAINT `orders_views_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_customers`
--
ALTER TABLE `payment_customers`
  ADD CONSTRAINT `payment_customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products_variations`
--
ALTER TABLE `products_variations`
  ADD CONSTRAINT `products_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_variations_prices`
--
ALTER TABLE `products_variations_prices`
  ADD CONSTRAINT `products_variations_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_variations_prices_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `products_variations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles_permessions`
--
ALTER TABLE `roles_permessions`
  ADD CONSTRAINT `roles_permessions_permession_id_foreign` FOREIGN KEY (`permession_id`) REFERENCES `permessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_permessions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `statuses_histroy`
--
ALTER TABLE `statuses_histroy`
  ADD CONSTRAINT `statuses_histroy_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `statuses_histroy_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `statuses_histroy_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `translations`
--
ALTER TABLE `translations`
  ADD CONSTRAINT `translations_lang_id_foreign` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
