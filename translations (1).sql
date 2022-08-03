-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2022 at 01:46 PM
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
-- Database: `resturant`
--

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
(199, 4, 'products', 'الأطعمة', '2022-07-28 12:11:00', '2022-07-28 12:12:57'),
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
(232, 4, 'products count', 'عدد الأطعمة', '2022-07-28 13:20:56', '2022-07-28 13:22:22'),
(233, 4, 'category image', 'صورة الصنف', '2022-07-28 13:23:16', '2022-07-28 13:23:29'),
(234, 4, 'back to categories', 'الرجوع الى الأصناف', '2022-07-28 13:23:16', '2022-07-28 13:23:46'),
(235, 4, 'edit category', 'تعديل الصنف', '2022-07-28 13:37:29', '2022-07-28 13:37:40'),
(236, 4, 'food images', 'صور الطعام', '2022-07-28 13:40:12', '2022-07-30 11:35:16'),
(237, 4, 'you should choose maximum 5 images', 'يجب عليك أختيار أقل من 5 صور', '2022-07-28 13:40:12', '2022-07-30 10:59:09'),
(238, 4, 'back to foods', 'الرجوع الى الأطعمة', '2022-07-28 13:40:12', '2022-07-28 13:40:37'),
(239, 4, 'add', 'اضافة', '2022-07-28 13:40:12', '2022-07-30 12:42:39'),
(240, 4, 'there is something error', 'there is something error', '2022-07-28 13:40:12', '2022-07-28 13:40:12'),
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
(277, 4, 'employee in', 'employee in', '2022-07-28 13:45:36', '2022-07-28 13:45:36'),
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
(328, 4, 'the category is required', 'the category is required', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(329, 4, 'the category should be exists', 'the category should be exists', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(330, 4, 'the discount should be a number', 'the discount should be a number', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(331, 4, 'the viewed number should be a number', 'the viewed number should be a number', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(332, 4, 'the extra is required', 'the extra is required', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(333, 4, 'currency required', 'currency required', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(334, 4, 'currency should be in the currencies', 'currency should be in the currencies', '2022-07-30 12:43:00', '2022-07-30 12:43:00'),
(335, 4, 'the size is required', 'the size is required', '2022-07-30 13:39:36', '2022-07-30 13:39:36'),
(336, 4, 'filter', 'تصفية', '2022-07-30 13:52:28', '2022-07-30 13:54:08'),
(337, 3, 'password', 'password', '2022-07-30 19:28:58', '2022-07-30 19:28:58'),
(338, 3, 'remember me', 'remember me', '2022-07-30 19:28:58', '2022-07-30 19:28:58'),
(339, 3, 'login', 'login', '2022-07-30 19:28:58', '2022-07-30 19:28:58'),
(340, 4, 'remember me', 'remember me', '2022-07-30 19:29:02', '2022-07-30 19:29:02'),
(341, 4, 'login', 'login', '2022-07-30 19:29:02', '2022-07-30 19:29:02'),
(342, 4, 'choose branch', 'أختر الفرع', '2022-07-30 19:38:49', '2022-07-30 19:39:17'),
(343, 4, 'edit profile', 'تعديل الملف الشخصى', '2022-07-30 19:55:35', '2022-07-30 19:55:48'),
(344, 4, 'back to dashboard', 'الرجوع الى لوحة التحكم', '2022-07-30 19:55:35', '2022-07-30 19:56:03'),
(345, 4, 'there is no orders', 'لا يوجد طلبات', '2022-07-30 20:07:30', '2022-07-30 20:10:00'),
(346, 4, 'you should choose a type from the stock', 'you should choose a type from the stock', '2022-07-30 20:35:15', '2022-07-30 20:35:15'),
(347, 4, 'you should choose a minmum 1 product', 'يجب أختيار طعام واحد على الأقل', '2022-07-30 20:35:15', '2022-07-31 10:37:08'),
(348, 4, 'the amount is required', 'the amount is required', '2022-07-30 20:35:15', '2022-07-30 20:35:15'),
(349, 4, 'the amount should be at least 1', 'the amount should be at least 1', '2022-07-30 20:35:15', '2022-07-30 20:35:15'),
(350, 4, 'new order', 'طلب جديد', '2022-07-30 20:38:11', '2022-07-31 10:52:58'),
(351, 4, 'status', 'الحالة', '2022-07-30 20:38:11', '2022-07-31 11:10:22'),
(352, 4, 'foods count', 'عدد الأطعمة', '2022-07-30 20:38:11', '2022-07-31 10:52:45'),
(353, 4, 'there is no name', 'there is no name', '2022-07-30 20:38:22', '2022-07-30 20:38:22'),
(354, 4, 'there is no address', 'there is no address', '2022-07-30 20:38:22', '2022-07-30 20:38:22'),
(355, 4, 'there is no city', 'there is no city', '2022-07-30 20:38:22', '2022-07-30 20:38:22'),
(356, 4, 'there is no phone', 'there is no phone', '2022-07-30 20:38:22', '2022-07-30 20:38:22'),
(357, 4, 'final price', 'السعر النهائى', '2022-07-30 20:38:22', '2022-07-30 20:42:26'),
(358, 4, 'order show', 'اظهار الطلب', '2022-07-30 20:45:23', '2022-07-31 11:08:30'),
(359, 4, 'order summary', 'ملخص الطلب', '2022-07-30 20:45:23', '2022-07-30 20:47:26'),
(360, 4, 'count', 'العدد', '2022-07-30 20:45:23', '2022-07-30 20:52:37'),
(361, 4, 'order quantity', 'order quantity', '2022-07-30 20:45:23', '2022-07-30 20:45:23'),
(362, 4, 'total price withoud extras', 'السعر الكلى بدون اضافات', '2022-07-30 20:45:23', '2022-07-30 20:46:57'),
(363, 4, 'total price of extras', 'سعر الأضافات الكلى', '2022-07-30 20:45:23', '2022-07-30 20:47:11'),
(364, 4, 'order status history', 'تاريخ حالات الطلب', '2022-07-30 20:45:23', '2022-07-30 20:46:38'),
(365, 4, 'name of the user who changed the status', 'أسم المستخدم الذى غير حالة الطلب', '2022-07-30 20:45:23', '2022-07-30 20:46:21'),
(366, 4, 'edit order', 'edit order', '2022-07-30 20:52:59', '2022-07-30 20:52:59'),
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
(411, 4, 'updated successfuly', 'updated successfuly', '2022-07-31 18:29:07', '2022-07-31 18:29:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_lang_id_foreign` (`lang_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `translations`
--
ALTER TABLE `translations`
  ADD CONSTRAINT `translations_lang_id_foreign` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;