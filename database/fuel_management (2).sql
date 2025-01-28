-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2025 at 12:36 PM
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
-- Database: `fuel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$J7rcIGXe65tuUNpE.7rcxekgmMJ1YfgnhPHZbMLXjACoTa5SHS5vy', '2025-01-20 11:32:18', '2025-01-20 11:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `customer_masterdatas`
--

CREATE TABLE `customer_masterdatas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_type` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `customer_mobile_no` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_masterdatas`
--

INSERT INTO `customer_masterdatas` (`id`, `customer_type`, `customer_name`, `customer_address`, `customer_mobile_no`, `customer_email`, `created_at`, `updated_at`) VALUES
(1, 'Individual', 'NIkewsh', 'bharuvj', '1234569870', 'jnikeshjaja@gmail.com', '2025-01-27 23:30:17', '2025-01-28 01:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `customer_type`
--

CREATE TABLE `customer_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_type`
--

INSERT INTO `customer_type` (`id`, `customer_type`, `created_at`, `updated_at`) VALUES
(1, 'Compaines', NULL, NULL),
(2, 'Individual', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `driver_name`, `created_at`, `updated_at`) VALUES
(1, 'rajesh', '2025-01-27 23:09:47', '2025-01-28 01:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_fillings`
--

CREATE TABLE `fuel_fillings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) NOT NULL,
  `driver_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `filling_date` date NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `kilometers` decimal(8,2) NOT NULL,
  `average_fuel_consumption` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fuel_fillings`
--

INSERT INTO `fuel_fillings` (`id`, `vehicle_id`, `driver_id`, `customer_id`, `filling_date`, `quantity`, `kilometers`, `average_fuel_consumption`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 1, '1988-07-30', 423.00, 100.00, 0.00, '2025-01-28 01:22:49', '2025-01-28 01:22:49'),
(2, 7, 1, 1, '2025-01-04', 100.00, 50.00, 49.00, '2025-01-28 01:37:57', '2025-01-28 01:37:57'),
(3, 7, 1, 1, '2025-01-28', 100.00, 60.00, 59.50, '2025-01-28 01:42:52', '2025-01-28 01:42:52'),
(4, 7, 1, 1, '2025-01-28', 20.00, 20.00, 59.00, '2025-01-28 01:47:04', '2025-01-28 01:47:04');

-- --------------------------------------------------------

--
-- Table structure for table `masterdata`
--

CREATE TABLE `masterdata` (
  `id` int(11) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `asset_make_model` varchar(255) NOT NULL,
  `segment` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `yom` varchar(255) NOT NULL,
  `finance_by` varchar(255) NOT NULL,
  `loan_amount` varchar(255) NOT NULL,
  `loan_account` varchar(255) NOT NULL,
  `emi_amount` varchar(255) NOT NULL,
  `total_emi` varchar(255) NOT NULL,
  `emi_paid` varchar(255) NOT NULL,
  `pending_emi` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `roi` float NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `masterdatas`
--

CREATE TABLE `masterdatas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `vehicle_id` bigint(20) NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `asset_make_model` varchar(255) NOT NULL,
  `segment` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `yom` date NOT NULL,
  `finance_by` varchar(255) NOT NULL,
  `loan_amount` varchar(255) NOT NULL,
  `loan_account` varchar(255) NOT NULL,
  `emi_amount` varchar(255) NOT NULL,
  `total_emi` varchar(255) NOT NULL,
  `emi_paid` varchar(255) NOT NULL,
  `pending_emi` varchar(255) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `rate_of_interest` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_01_20_112510_create_vehicles_table', 1),
(6, '2025_01_20_112838_create_admins_table', 1),
(24, '2025_01_27_092028_create_customer_type', 2),
(29, '2025_01_27_051714_create_masterdatas_table', 3),
(30, '2025_01_27_052757_create_fuel_fillings_table', 3),
(31, '2025_01_27_054425_create_customer_masterdatas_table', 3),
(32, '2025_01_27_120609_create_drivers_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_no` varchar(255) DEFAULT NULL,
  `vehicle_engine_no` varchar(255) NOT NULL,
  `vehicle_chassis_no` varchar(255) NOT NULL,
  `vehicle_policy_no` varchar(255) NOT NULL,
  `vehicle_policy_expiry_date` date DEFAULT NULL,
  `average` double(8,2) DEFAULT NULL,
  `vehicle_fitness_expiry_date` date DEFAULT NULL,
  `vehicle_puc_expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_no`, `vehicle_engine_no`, `vehicle_chassis_no`, `vehicle_policy_no`, `vehicle_policy_expiry_date`, `average`, `vehicle_fitness_expiry_date`, `vehicle_puc_expiry_date`, `created_at`, `updated_at`) VALUES
(7, 'GJ16CS4405', 'DF4544554DS454', 'M4G55GFG5H4H4', '32145687', '2025-02-02', 50.00, '2025-02-02', '2025-02-02', '2025-01-24 05:04:58', '2025-01-27 05:59:38');

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
-- Indexes for table `customer_masterdatas`
--
ALTER TABLE `customer_masterdatas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_type`
--
ALTER TABLE `customer_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fuel_fillings`
--
ALTER TABLE `fuel_fillings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masterdata`
--
ALTER TABLE `masterdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masterdatas`
--
ALTER TABLE `masterdatas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_masterdatas`
--
ALTER TABLE `customer_masterdatas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_type`
--
ALTER TABLE `customer_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuel_fillings`
--
ALTER TABLE `fuel_fillings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `masterdata`
--
ALTER TABLE `masterdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `masterdatas`
--
ALTER TABLE `masterdatas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
