-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 30, 2026 at 06:09 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trackio`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `attendance_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'present',
  `source_type` enum('biometric','qr','manual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`attendance_id`),
  KEY `attendance_emp_id_foreign` (`emp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `emp_id`, `date`, `check_in`, `check_out`, `status`, `source_type`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-12-01', '08:23:00', '17:23:00', 'Present', 'manual', '2025-12-06 11:23:35', '2025-12-06 11:23:35'),
(2, 1, '2025-12-02', NULL, NULL, 'Absent', 'manual', '2025-12-06 11:23:42', '2025-12-06 11:23:42'),
(3, 1, '2025-12-03', NULL, NULL, 'Leave', 'manual', '2025-12-06 11:23:50', '2025-12-06 11:23:50'),
(4, 1, '2025-12-04', '08:24:00', '13:02:00', 'Half-day', 'manual', '2025-12-06 11:24:26', '2025-12-06 11:24:26'),
(5, 1, '2025-12-05', '08:27:00', '17:24:00', 'Present', 'manual', '2025-12-06 11:24:49', '2025-12-06 11:24:49'),
(6, 2, '2025-12-08', '10:00:00', NULL, 'Present', 'manual', '2025-12-08 08:00:41', '2025-12-08 08:00:41'),
(7, 1, '2025-12-09', NULL, NULL, 'Leave', 'manual', '2025-12-08 09:09:58', '2025-12-08 09:09:58'),
(8, 2, '2025-12-09', '11:00:36', '12:00:51', 'Present', 'qr', '2025-12-09 06:00:36', '2025-12-09 07:00:51'),
(9, 3, '2025-12-11', '08:18:00', NULL, 'Present', 'manual', '2025-12-11 04:24:43', '2025-12-11 04:24:43'),
(10, 3, '2025-12-11', '08:18:00', NULL, 'Present', 'manual', '2025-12-11 04:24:43', '2025-12-11 04:24:43'),
(11, 1, '2025-12-11', '08:26:00', '09:27:00', 'Present', 'manual', '2025-12-11 04:26:36', '2025-12-11 04:27:17'),
(12, 2, '2025-12-11', '09:28:00', NULL, 'Present', 'manual', '2025-12-11 04:28:22', '2025-12-11 04:28:22'),
(13, 5, '2025-12-23', NULL, NULL, 'present', 'manual', '2025-12-26 06:21:27', '2025-12-26 06:21:27'),
(14, 1, '2026-01-09', '08:11:00', '17:11:00', 'Present', 'manual', '2026-01-12 05:11:20', '2026-01-12 05:11:20'),
(15, 1, '2026-01-08', NULL, NULL, 'Leave', 'manual', '2026-01-12 05:11:37', '2026-01-12 05:11:37'),
(16, 1, '2026-01-12', NULL, NULL, 'Half-day', 'manual', '2026-01-12 05:11:43', '2026-01-12 05:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_adjustments`
--

DROP TABLE IF EXISTS `attendance_adjustments`;
CREATE TABLE IF NOT EXISTS `attendance_adjustments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` bigint UNSIGNED NOT NULL,
  `adjustment_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adjustment_date` date NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_remark` text COLLATE utf8mb4_unicode_ci,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendance_adjustments_employee_id_foreign` (`employee_id`),
  KEY `attendance_adjustments_approved_by_foreign` (`approved_by`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_adjustments`
--

INSERT INTO `attendance_adjustments` (`id`, `employee_id`, `adjustment_type`, `adjustment_date`, `reason`, `attachment`, `status`, `admin_remark`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 7, 'Late In Adjustment', '2025-12-25', 'traffic jam', NULL, 'rejected', 'not approved', 2, '2025-12-26 06:23:42', '2025-12-26 06:16:07', '2025-12-26 06:23:42'),
(2, 7, 'Forgot to Mark Attendance', '2025-12-23', 'forget to mark attendance', NULL, 'approved', NULL, 2, '2025-12-26 06:21:27', '2025-12-26 06:21:02', '2025-12-26 06:21:27'),
(3, 3, 'Forgot to Mark Attendance', '2026-01-11', 'forget to mark attendance', NULL, 'pending', NULL, NULL, NULL, '2026-01-12 05:09:11', '2026-01-12 05:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `audit_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`audit_id`),
  KEY `audit_logs_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biometric_devices`
--

DROP TABLE IF EXISTS `biometric_devices`;
CREATE TABLE IF NOT EXISTS `biometric_devices` (
  `device_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `device_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`device_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biometric_logs`
--

DROP TABLE IF EXISTS `biometric_logs`;
CREATE TABLE IF NOT EXISTS `biometric_logs` (
  `log_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_id` bigint UNSIGNED NOT NULL,
  `device_id` bigint UNSIGNED NOT NULL,
  `timestamp` timestamp NOT NULL,
  `type` enum('finger','face') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `biometric_logs_emp_id_foreign` (`emp_id`),
  KEY `biometric_logs_device_id_foreign` (`device_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-soha@gmail.com|127.0.0.1:timer', 'i:1766730717;', 1766730717),
('laravel-cache-soha@gmail.com|127.0.0.1', 'i:1;', 1766730717);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `created_at`, `updated_at`) VALUES
(1, 'Xolva', '2025-12-06 11:15:42', '2025-12-06 11:15:42'),
(2, 'Copy Editing', '2025-12-06 11:15:45', '2025-12-06 11:15:45'),
(3, 'Web/XML', '2025-12-06 11:15:49', '2025-12-06 11:15:49'),
(4, 'Finance', '2025-12-06 11:15:54', '2025-12-06 11:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

DROP TABLE IF EXISTS `designations`;
CREATE TABLE IF NOT EXISTS `designations` (
  `designation_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`designation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`designation_id`, `designation_name`, `created_at`, `updated_at`) VALUES
(1, 'Software Engineer', '2025-12-06 11:16:02', '2025-12-06 11:16:02'),
(2, 'Tester', '2025-12-06 11:16:05', '2025-12-06 11:16:05'),
(3, 'Marketing Specialist', '2025-12-11 05:05:36', '2025-12-11 05:05:36'),
(4, 'Financial Analyst', '2025-12-11 05:05:58', '2025-12-11 05:05:58'),
(5, 'Data Scientist', '2025-12-11 05:06:11', '2025-12-11 05:06:11'),
(6, 'Payroll Specialist', '2025-12-11 05:06:34', '2025-12-11 05:06:34'),
(7, 'Senior Data Analyst', '2025-12-11 05:06:50', '2025-12-11 05:06:50'),
(8, 'Quality Assurance Tester', '2025-12-11 05:07:08', '2025-12-11 05:07:08');

-- --------------------------------------------------------

--
-- Table structure for table `employee_profiles`
--

DROP TABLE IF EXISTS `employee_profiles`;
CREATE TABLE IF NOT EXISTS `employee_profiles` (
  `emp_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `employee_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `designation_id` bigint UNSIGNED NOT NULL,
  `joining_date` date NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shift_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `qr_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`emp_id`),
  UNIQUE KEY `employee_profiles_employee_code_unique` (`employee_code`),
  UNIQUE KEY `employee_profiles_email_unique` (`email`),
  UNIQUE KEY `employee_profiles_qr_code_unique` (`qr_code`),
  KEY `employee_profiles_user_id_foreign` (`user_id`),
  KEY `employee_profiles_department_id_foreign` (`department_id`),
  KEY `employee_profiles_designation_id_foreign` (`designation_id`),
  KEY `employee_profiles_shift_id_foreign` (`shift_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_profiles`
--

INSERT INTO `employee_profiles` (`emp_id`, `user_id`, `employee_code`, `name`, `department_id`, `designation_id`, `joining_date`, `email`, `phone`, `shift_id`, `status`, `address`, `created_at`, `updated_at`, `qr_code`, `qr_code_path`) VALUES
(1, 3, 'EMP001', 'Yousuf Ali Khan', 1, 1, '2025-12-01', 'yousuf@gmail.com', '03208306536', 1, 1, 'B-122 gulshan Karachi', '2025-12-06 11:23:03', '2025-12-06 11:23:03', 'EMP0001', 'storage/qr-cards/EMP0001.svg'),
(2, 4, 'EMP002', 'Asma Aslam', 1, 1, '2025-12-01', 'aslamasma486@gmail.com', '03208306536', 1, 1, 'B-122 gulshan Karachi', '2025-12-08 07:59:38', '2025-12-08 08:00:02', 'EMP0002', 'storage/qr-cards/EMP0002.svg'),
(3, 5, 'EMP003', 'Sameen', 1, 1, '2025-11-03', 'sameenn@gmail.com', 'sohamansab@gmail.com', 1, 1, 'B-122 gulshan Karachi', '2025-12-09 06:02:29', '2025-12-09 06:02:29', 'EMP0003', 'storage/qr-cards/EMP0003.svg'),
(4, 6, 'EMP004', 'Fatima Khan', 3, 2, '2025-12-01', 'fatima@gmail.com', 'sohamansab@gmail.com', 1, 1, 'B-122 gulshan Karachi', '2025-12-11 04:37:22', '2025-12-11 04:37:22', 'EMP0004', 'storage/qr-cards/EMP0004.svg'),
(5, 7, 'EMP009', 'Rabia Ali', 1, 5, '2025-12-01', 'rabia@gmail.com', 'rabia@gmail.com', 1, 1, 'B-122 gulshan Karachi', '2025-12-26 06:13:34', '2025-12-26 06:13:34', 'EMP0005', 'storage/qr-cards/EMP0005.svg');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
CREATE TABLE IF NOT EXISTS `holidays` (
  `holiday_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `late_exemption_requests`
--

DROP TABLE IF EXISTS `late_exemption_requests`;
CREATE TABLE IF NOT EXISTS `late_exemption_requests` (
  `exemption_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_id` bigint UNSIGNED NOT NULL,
  `attendance_id` bigint UNSIGNED NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`exemption_id`),
  KEY `late_exemption_requests_emp_id_foreign` (`emp_id`),
  KEY `late_exemption_requests_attendance_id_foreign` (`attendance_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_approval_log`
--

DROP TABLE IF EXISTS `leave_approval_log`;
CREATE TABLE IF NOT EXISTS `leave_approval_log` (
  `log_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `leave_id` bigint UNSIGNED NOT NULL,
  `approved_by` bigint UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`log_id`),
  KEY `leave_approval_log_leave_id_foreign` (`leave_id`),
  KEY `leave_approval_log_approved_by_foreign` (`approved_by`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_approval_log`
--

INSERT INTO `leave_approval_log` (`log_id`, `leave_id`, `approved_by`, `status`, `timestamp`, `comment`) VALUES
(1, 1, 2, 'Approved', '2025-12-06 11:29:55', 'Added manually by admin'),
(2, 2, 2, 'Rejected', '2025-12-06 11:31:29', NULL),
(3, 3, 2, 'Approved', '2025-12-08 09:09:58', NULL),
(4, 4, 2, 'Approved', '2025-12-16 04:29:43', 'Added manually by admin');

-- --------------------------------------------------------

--
-- Table structure for table `leave_balance`
--

DROP TABLE IF EXISTS `leave_balance`;
CREATE TABLE IF NOT EXISTS `leave_balance` (
  `balance_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_id` bigint UNSIGNED NOT NULL,
  `leave_type_id` bigint UNSIGNED NOT NULL,
  `remaining_leaves` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`balance_id`),
  KEY `leave_balance_emp_id_foreign` (`emp_id`),
  KEY `leave_balance_leave_type_id_foreign` (`leave_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

DROP TABLE IF EXISTS `leave_requests`;
CREATE TABLE IF NOT EXISTS `leave_requests` (
  `leave_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_id` bigint UNSIGNED NOT NULL,
  `leave_type_id` bigint UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`leave_id`),
  KEY `leave_requests_emp_id_foreign` (`emp_id`),
  KEY `leave_requests_leave_type_id_foreign` (`leave_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`leave_id`, `emp_id`, `leave_type_id`, `start_date`, `end_date`, `status`, `reason`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-12-08', '2025-12-10', 'Approved', 'trip', '2025-12-06 11:29:55', '2025-12-06 11:29:55'),
(3, 1, 1, '2025-12-09', '2025-12-09', 'Approved', 'personal work', '2025-12-08 09:09:28', '2025-12-08 09:09:58'),
(4, 2, 1, '2025-12-16', '2025-12-16', 'Approved', NULL, '2025-12-16 04:29:43', '2025-12-16 04:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

DROP TABLE IF EXISTS `leave_types`;
CREATE TABLE IF NOT EXISTS `leave_types` (
  `leave_type_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annual_allowed` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`leave_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`leave_type_id`, `name`, `annual_allowed`, `created_at`, `updated_at`) VALUES
(1, 'Annual Leave', 24, '2025-12-06 11:27:27', '2025-12-06 11:27:27'),
(2, 'Unpaid Leave Contractual', 40, '2025-12-06 11:27:27', '2025-12-06 11:27:27'),
(3, 'Unpaid Leave', 10, '2025-12-06 11:27:27', '2025-12-06 11:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_03_093225_create_employee_profiles_table', 1),
(5, '2025_12_03_093226_create_departments_table', 1),
(6, '2025_12_03_093226_create_designations_table', 1),
(7, '2025_12_03_093227_create_attendances_table', 1),
(8, '2025_12_03_093228_create_late_exemption_requests_table', 1),
(9, '2025_12_03_093228_create_leave_types_table', 1),
(10, '2025_12_03_093229_create_leave_requests_table', 1),
(11, '2025_12_03_093230_create_holidays_table', 1),
(12, '2025_12_03_093230_create_office_timings_table', 1),
(13, '2025_12_03_093231_create_biometric_devices_table', 1),
(14, '2025_12_03_093231_create_biometric_logs_table', 1),
(15, '2025_12_03_093232_create_qr_logs_table', 1),
(16, '2025_12_03_093233_create_leave_balances_table', 1),
(17, '2025_12_03_093233_create_notifications_table', 1),
(18, '2025_12_03_093234_create_shifts_table', 1),
(19, '2025_12_03_093235_create_leave_approval_log_table', 1),
(20, '2025_12_03_093235_create_shift_assignments_table', 1),
(21, '2025_12_03_093236_create_audit_logs_table', 1),
(22, '2025_12_03_093236_create_qr_cards_table', 1),
(23, '2025_12_05_000001_add_qr_code_to_employee_profiles_table', 1),
(24, '2025_12_06_000000_add_name_to_users_table', 1),
(25, '2025_12_06_161059_fix_shift_id_nullable_in_employee_profiles_table', 1),
(26, '2025_12_26_091412_create_attendance_adjustments_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`notification_id`),
  KEY `notifications_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'New Leave Request', '  has submitted a leave request from 2025-12-08 to 2025-12-10.', 'leave_request', 0, '2025-12-06 11:31:02', '2025-12-06 11:31:02'),
(2, 3, 'New Leave Request', '  has submitted a leave request from 2025-12-08 to 2025-12-10.', 'leave_request', 0, '2025-12-06 11:31:02', '2025-12-06 11:31:02'),
(3, 1, 'New Leave Request', '  has submitted a leave request from 2025-12-09 to 2025-12-09.', 'leave_request', 0, '2025-12-08 09:09:28', '2025-12-08 09:09:28'),
(4, 3, 'New Leave Request', '  has submitted a leave request from 2025-12-09 to 2025-12-09.', 'leave_request', 0, '2025-12-08 09:09:28', '2025-12-08 09:09:28'),
(5, 4, 'New Leave Request', '  has submitted a leave request from 2025-12-09 to 2025-12-09.', 'leave_request', 0, '2025-12-08 09:09:28', '2025-12-08 09:09:28'),
(6, 3, 'Leave Approved', 'Your leave request from 2025-12-09 to 2025-12-09 has been approved.', 'leave_approval', 0, '2025-12-08 09:09:58', '2025-12-08 09:09:58');

-- --------------------------------------------------------

--
-- Table structure for table `office_timings`
--

DROP TABLE IF EXISTS `office_timings`;
CREATE TABLE IF NOT EXISTS `office_timings` (
  `office_timing_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `break_minutes` int NOT NULL DEFAULT '0',
  `grace_minutes` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`office_timing_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qr_cards`
--

DROP TABLE IF EXISTS `qr_cards`;
CREATE TABLE IF NOT EXISTS `qr_cards` (
  `qr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_id` bigint UNSIGNED NOT NULL,
  `qr_code_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`qr_id`),
  KEY `qr_cards_emp_id_foreign` (`emp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qr_cards`
--

INSERT INTO `qr_cards` (`qr_id`, `emp_id`, `qr_code_path`, `created_at`, `updated_at`) VALUES
(1, 1, 'storage/qr-cards/EMP0001.svg', '2025-12-06 11:23:03', '2025-12-06 11:23:03'),
(2, 2, 'storage/qr-cards/EMP0002.svg', '2025-12-08 07:59:38', '2025-12-08 07:59:38'),
(3, 3, 'storage/qr-cards/EMP0003.svg', '2025-12-09 06:02:29', '2025-12-09 06:02:29'),
(4, 4, 'storage/qr-cards/EMP0004.svg', '2025-12-11 04:37:22', '2025-12-11 04:37:22'),
(5, 5, 'storage/qr-cards/EMP0005.svg', '2025-12-26 06:13:36', '2025-12-26 06:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `qr_logs`
--

DROP TABLE IF EXISTS `qr_logs`;
CREATE TABLE IF NOT EXISTS `qr_logs` (
  `qr_log_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_id` bigint UNSIGNED NOT NULL,
  `timestamp` timestamp NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`qr_log_id`),
  KEY `qr_logs_emp_id_foreign` (`emp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qr_logs`
--

INSERT INTO `qr_logs` (`qr_log_id`, `emp_id`, `timestamp`, `type`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-12-09 06:00:36', 'public-scan', '2025-12-09 06:00:36', '2025-12-09 06:00:36'),
(2, 2, '2025-12-09 07:00:51', 'public-scan', '2025-12-09 07:00:51', '2025-12-09 07:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('frHkIYo1qfZtmV5SAeNzmcug6Z3oikfLnMWQp7nu', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR3JnMEtnRUJFemVCT3E4OHlCQm5xZ2NWMkVQeFJUUk5lY2lEYzhUdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsb3llZS9hdHRlbmRhbmNlL3RvZGF5IjtzOjU6InJvdXRlIjtzOjI1OiJlbXBsb3llZS5hdHRlbmRhbmNlLnRvZGF5Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1768194760);

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

DROP TABLE IF EXISTS `shifts`;
CREATE TABLE IF NOT EXISTS `shifts` (
  `shift_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `shift_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `grace_minutes` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`shift_id`, `shift_name`, `start_time`, `end_time`, `grace_minutes`, `created_at`, `updated_at`) VALUES
(1, 'Morning', '08:45:00', '17:00:00', 10, '2025-12-06 11:16:42', '2025-12-06 11:16:42'),
(2, 'Afternoon', '14:00:00', '21:00:00', 10, '2025-12-06 11:17:11', '2025-12-06 11:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `shift_assignments`
--

DROP TABLE IF EXISTS `shift_assignments`;
CREATE TABLE IF NOT EXISTS `shift_assignments` (
  `assignment_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_id` bigint UNSIGNED NOT NULL,
  `shift_id` bigint UNSIGNED NOT NULL,
  `effective_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`assignment_id`),
  KEY `shift_assignments_emp_id_foreign` (`emp_id`),
  KEY `shift_assignments_shift_id_foreign` (`shift_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint NOT NULL DEFAULT '0',
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `last_login`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Test Employee', 'test@example.com', '$2y$12$1BdX0faSy7.hnqXNBEc9X.42Q/46ynxHA81aK5HAKYQ3Li0fX7z/G', 0, NULL, 1, '2025-12-06 11:12:24', '2025-12-06 11:12:24'),
(2, 'Soha Mansab', 'sohamansab@gmail.com', '$2y$12$xO2X02OmWTEyV7yXCz8wheWKS2r1MFOmfKKqU7MpxE5QIXBMZ6rwi', 1, NULL, 1, '2025-12-06 11:14:18', '2025-12-06 11:14:18'),
(3, 'Yousuf Ali Khan', 'yousuf@gmail.com', '$2y$12$9I3iR0anMR40ffZvqs7z8uk50t/Bhcmsti.XX49cHDbMJNP33mDe2', 0, NULL, 1, '2025-12-06 11:23:03', '2025-12-06 11:23:03'),
(4, 'asma aslam', 'aslamasma486@gmail.com', '$2y$12$AHntC2oEZ1vXtsaonI2b6.qkVmDBfFgRsoecVlLlFpbtOGw1QDM2m', 0, NULL, 1, '2025-12-08 07:59:38', '2025-12-08 07:59:38'),
(5, 'Sameen', 'sameenn@gmail.com', '$2y$12$rtBiscPpLndoDKRe0pyCD.mc58WQpyZspCC5HSHT75gxjOwjxL/LW', 0, NULL, 1, '2025-12-09 06:02:29', '2025-12-09 06:02:29'),
(6, 'Fatima Khan', 'fatima@gmail.com', '$2y$12$I7IAwuIvp3xRq3Etsgm6vuhwiFvobAlZZmN5Wwdgk7wsovGodP0Aq', 0, NULL, 1, '2025-12-11 04:37:22', '2025-12-11 04:37:22'),
(7, 'Rabia Ali', 'rabia@gmail.com', '$2y$12$uSpdx61qcQoSOPD5T1PEoOD2FIe.mcJvTLaKwyN/JnlmTfcYmDMQ6', 0, NULL, 1, '2025-12-26 06:13:34', '2025-12-26 06:13:34');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
