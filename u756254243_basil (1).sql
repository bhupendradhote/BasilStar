-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 08, 2025 at 07:43 AM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u756254243_basil`
--

-- --------------------------------------------------------

--
-- Table structure for table `baskets`
--

CREATE TABLE `baskets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `basket_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `baskets`
--

INSERT INTO `baskets` (`id`, `basket_type`, `created_at`, `updated_at`) VALUES
(3, 'Intraday', '2025-06-26 11:31:13', '2025-06-26 11:31:13'),
(5, 'Long Term', '2025-06-26 11:33:29', '2025-06-26 11:33:29'),
(8, 'Short Term', '2025-06-30 16:52:56', '2025-06-30 16:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `basket_stocks`
--

CREATE TABLE `basket_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `basket_id` bigint(20) UNSIGNED NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `buy_price` decimal(10,2) NOT NULL,
  `target_price` decimal(10,2) NOT NULL,
  `stop_loss` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basket_stocks`
--

INSERT INTO `basket_stocks` (`id`, `basket_id`, `symbol`, `buy_price`, `target_price`, `stop_loss`, `created_at`, `updated_at`) VALUES
(36, 8, 'CASTROLIND', 224.00, 244.00, 210.00, '2025-06-30 16:52:56', '2025-06-30 16:52:56'),
(37, 8, 'ABFRL', 74.00, 81.00, 70.00, '2025-06-30 16:52:56', '2025-06-30 16:52:56'),
(38, 8, 'KPIT', 1283.00, 1350.00, 1256.00, '2025-06-30 16:52:56', '2025-06-30 16:52:56'),
(43, 5, 'Grasim industries', 2780.00, 3200.00, 2700.00, '2025-07-06 13:10:06', '2025-07-06 13:10:06'),
(44, 5, 'Aut voluptate in aut', 499.00, 413.00, 15.00, '2025-07-06 13:10:06', '2025-07-06 13:10:06'),
(45, 5, 'Qui modi magna imped', 986.00, 84.00, 56.00, '2025-07-06 13:10:06', '2025-07-06 13:10:06'),
(46, 5, 'Animi eius consequa', 16.00, 552.00, 19.00, '2025-07-06 13:10:06', '2025-07-06 13:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `market_predictions`
--

CREATE TABLE `market_predictions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `market_sentiment` varchar(255) DEFAULT NULL,
  `global_cues` text DEFAULT NULL,
  `volatility_alert` text DEFAULT NULL,
  `support_levels` varchar(255) DEFAULT NULL,
  `resistance_levels` varchar(255) DEFAULT NULL,
  `range` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `market_predictions`
--

INSERT INTO `market_predictions` (`id`, `title`, `image_url`, `description`, `market_sentiment`, `global_cues`, `volatility_alert`, `support_levels`, `resistance_levels`, `range`, `created_at`, `updated_at`) VALUES
(1, 'SUMICHEM technical analysis', 'uploads/market_predictions/1750940789_Screenshot (100).png', 'This gauge displays a technical analysis overview for your selected timeframe. The summary of SUMITOMO CHEM INDIA LTD is based on the most popular technical indicators, such as Moving Averages, Oscillators and Pivots', 'Bullish', 'Technical Ratings is a technical analysis tool that combines the ratings of several technical indicators to make it easier for traders and investors to spot profitable trades.\r\nIn addition to technical analysis, it\'s always best to use as much data as possible — to stay on top of everything that can potentially influence SUMITOMO CHEM INDIA LTD stock price, keep an eye on', 'to stay on top of everything that can potentially influence SUMITOMO CHEM INDIA LTD stock price, keep an eye on', '133 / 127.5', '140/150', NULL, '2025-06-26 12:26:29', '2025-06-26 12:26:29'),
(2, 'Soluta irure quod al', 'uploads/market_predictions/1751455209_Screenshot (96).png', 'Consequatur ipsam mi', 'Neutral', 'Earum animi facere', 'Fugiat expedita dolo', 'Sed voluptatibus ex', 'Totam adipisicing iu', 'Temporibus tempore', '2025-07-02 11:20:09', '2025-07-02 11:20:09');

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
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_04_04_072924_create_users_table', 1),
(4, '2025_04_04_073829_create_subscriptions_table', 1),
(5, '2025_04_14_081201_create_payments_table', 1),
(6, '2025_04_19_084750_create_products_table', 1),
(7, '2025_04_24_093656_create_personal_access_tokens_table', 1),
(8, '2025_05_19_110105_create_registered_users_table', 1),
(9, '2025_06_26_061658_create_market_predictions_table', 1),
(10, '2025_06_26_093357_create_strategies_table', 1),
(11, '2025_06_26_112117_create_baskets_table', 2),
(12, '2025_06_26_112121_create_basket_stocks_table', 2);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `email` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `be_event_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_users`
--

CREATE TABLE `registered_users` (
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
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`, `created_at`, `updated_at`) VALUES
('6HY6ZpL47JjyLvPSLXFAhwN81Z78QZA9l4HHEpe9', NULL, '2401:4900:8822:d10a:8847:bd5e:f7c3:f4f6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTdQOXo3UHVIOUVRUVdTZWZ5ZE1YTnZYR2xHTEl6clZEWW55OXZaUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbS9UcmFkaW5nRGFzaGJvYXJkIjt9fQ==', 1751952059, NULL, NULL),
('6xnfOq5AyjxvGqiuDa1In9cxHtAK8fRLUfoUFve1', NULL, '52.11.171.106', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:109.0) Gecko/20100101 Firefox/110.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibVo1YU1xS2RsS2dXaFdKUmpkQ0xPd2xkQ0x0TzRoR05RNmtVamhTNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751891644, NULL, NULL),
('A9yYxbF8EYVWAGW2BlRMlZgHao762AtVU6DCwLrI', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiclZMdnBJc3ZPUnBuaVRJR2VEQ0ZBdTQyVWdFUFM4dFJwRUhWNEpVSyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751939714, NULL, NULL),
('B9lxRVllwAnU01Tcid9oiYdpEJlHOtw3rVATkxYj', NULL, '2401:4900:8820:9f9e:eda1:979e:924f:11e8', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic3E4ZFkwUEU0Y1lrcW5hREZ3MlRHRW5mZmE3VmJDUzlsU3Y1OTc3byI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbS9saXZlQ2hhcnQiO319', 1751888420, NULL, NULL),
('bTnEAbDA7USSaZFJv7L3tGDvFPVPyG28yUC60T0z', NULL, '18.97.14.83', 'CCBot/2.0 (https://commoncrawl.org/faq/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmFjZHNHUkNuZ1gzNTZkS2dvamhJVGdPMVg2VnFHeTROY3dQOHFjUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751952151, NULL, NULL),
('de2B2pQfHWvee4Ubv6X0SRhGINnhcOqZmBqeGURZ', NULL, '134.122.23.114', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia0FKdGZuT28wZUFMVnhMZkJtb0lMTnBCb29WQlhsdDN4U0hQZk1zayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751913755, NULL, NULL),
('EagNDfgYWGkQZNtql1lKiY9ZMgJ3bF01xX1i1IAY', 1, '2401:4900:8820:9f9e:113e:9ced:c30b:a1e8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYmNYYmtrRVpxd1h2Rk5Ydnh5bm1oRWNicGcwWFE1dlNXVWJkMVRHdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbS9jb250YWN0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1751884755, NULL, NULL),
('ebaN9g5krjWisEE2VyRspQvJdHtMkKiVvrDp1OZg', NULL, '51.222.253.9', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidHFhbzhVQThQczA4S2p6eVZzMVlKZ200NmlmOTVCZFRjVWtTUFUxUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751932235, NULL, NULL),
('eoZgZXTyo2QwLcAFdXmCuNaT4X2UoRL8J7Grpz9R', NULL, '51.68.107.161', 'Mozilla/5.0 (compatible; MJ12bot/v2.0.2; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHpUU2o3RDVRVm9NN21nN3FCQWRjMEVYYUhqYzNVQmdVQlNqS3pLNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751949310, NULL, NULL),
('ezs3t0QujiJHAjHQTcHnDVSSWNvstGyXj739WMRS', NULL, '51.222.253.7', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0FHR1dONnp6S2g4bTFoWjlQRWRSdDFndzFsMTE5OERxbHlXSWpkZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbS9hbGxfbmV3cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751957718, NULL, NULL),
('FKTAJrfAym9LvXXPX4sgJTrD6jckY8HdDPHODqE2', NULL, '1.187.218.35', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/137.0.7151.107 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWkxpRm5lek1DWTZzcXZQMHdTUTBkZ0ZrVU1GNnc5YkZiUzlycEF6MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbS9UcmFkaW5nRGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751886174, NULL, NULL),
('IZTTWLVUvvU9752chFdm4b3uiWjNP2DizXXKFtxt', NULL, '2409:4081:ae82:af75:9059:3961:96e:7585', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/137.0.7151.107 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiemNuVVJhWXVxTkhqWEczSjVMOHZ0WnpiaVRSdFhUbVBPalVZR2FBNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751960283, NULL, NULL),
('kqSYpk2NaqyFggMnYL1wR0kQO9oyFTMQ6ebC3Pxw', NULL, '58.49.233.126', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaFhGY21iYXNyODl1MDZzb3BvQ2hmVldpejZ0OTZTcE9qWmlGWUh3UyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vd3d3LmJhc2lsc3Rhci5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1751941431, NULL, NULL),
('Kvlu0rCVaOxbzZ9qHbFGMYlBZ1CirsPiMSiRZLVr', NULL, '63.35.211.220', 'Mozilla/5.0 (compatible; NetcraftSurveyAgent/1.0; +info@netcraft.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicFNwV3BXSE1pWmpsbWpGVGg4SnFvQ2VjeDJqNzhOMnpDM0NKUW9TcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751906836, NULL, NULL),
('mvzKwbcswpWaC6fBWIsGlLyztYMukBOCN72JuIu4', NULL, '2402:8100:2701:5c41:a07f:2845:a94d:abd9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/137.0.7151.107 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRFA4YldDazdDd1l1dm9ETFVxMnFkTkpVbmF4ZXFERDNRT3RMVHB1SyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751909130, NULL, NULL),
('O8CcIU9LBeHIGDLR8piQmL80rlfXNKethQp4BQs9', NULL, '2401:4900:1c9a:f3d7:9170:92dc:accf:e1ac', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3hzM3U4a0dWM2FUTUZ0SDZhOExucHFrQXVkejUwVmJIYmhMbmZOdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751888539, NULL, NULL),
('t0AUfZsu3RNmUXJb43arIA2OQHiHRJmSPET0S1yG', NULL, '2a03:2880:f806:1c::', 'meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMG40R1JocXpVZFpCamViTk9haVdWS1NBTHRlR0JGR3JiM2h1aEowTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbS9hbGwtYmFza2V0cz9maWx0ZXJfdHlwZT1TaG9ydCUyMFRlcm0iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1751957362, NULL, NULL),
('Wc15oKZzyBJvFp3Pke5kPdRPpYxKsoWfP6IiX7Wv', NULL, '124.222.142.44', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU3JsNzV3WlRBc3JqNDkzTGVueWNwajhUZFk5WmVRQ3B5TFNBaXZuYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751887137, NULL, NULL),
('wCz3lRpMwD3pcYMKZ1VJl2AqZQeSh4fRWCeIFJ1S', NULL, '51.222.253.3', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN3pta1kyU3h5N3NIT3VKMG5acGk3aUY1VGNLM3BTeTF5TWhLM3BvbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbS9zdWJzY3JpYmUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1751951492, NULL, NULL),
('wY3ij9zVAs1zR1g3sx42npONw5SV9o4VjZIesq9t', NULL, '45.41.133.117', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTllnQjFwZ1dZR0ZiS0doTjVqbzd5QWpxM0d1VE1EcUNOcWpJd0VoWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbS9jb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751921437, NULL, NULL),
('X1FBKXKsumDcaFcKW8HTmPBnTNVzrPFTvFgByGwm', NULL, '52.209.116.141', 'Mozilla/5.0 (compatible; NetcraftSurveyAgent/1.0; +info@netcraft.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieXFURFZadDByZ1N4T3lxSWNZWlNSVDd2bGNPN25XQlVTNDNQcWhpZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vd3d3LmJhc2lsc3Rhci5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1751907922, NULL, NULL),
('xH9oTE2ihJPe8vfkNblAm9KRABqhTFscRLxHZBW1', NULL, '49.35.174.250', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/137.0.7151.107 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicldIV3MybG56cWpzQU01U1luTGFRYVBRUDRmSWdlOUJYcFFBUzJudSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751960265, NULL, NULL),
('xHNDYRXpTGxlDFO9hRhWfEn9M6iCym5Wv2CanEYW', NULL, '2401:4900:8820:9f9e:113e:9ced:c30b:a1e8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVXdLSzRVaTJkdllwUmJSQTJTdnQ1M1VXSnZOa2I3Zk81OHFxVkhhQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbS9hZG1pbi9kYXNoYm9hcmQiO319', 1751892167, NULL, NULL),
('xmajZTAb2t2KNn7p4CKIfi7i6T9k0E2SR3DQ4BiL', NULL, '172.241.20.9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0VqRU9xWkRwS01QQmRyQjZxUmdMR3dOejlWb0NtbzRON0dTT2p6QSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vd3d3LmJhc2lsc3Rhci5jb20vY29udGFjdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751887321, NULL, NULL),
('YrDyGHmn567x101mibXermo1psFHzJH7s82gC3p7', NULL, '143.110.248.255', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaThhekNGUjBRNGlrVGh1MHc4OElQUnVoakhZemp0RUxKUGVaM1ZlaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751915328, NULL, NULL),
('zwB4crxmPy0qv3n0UzRaYfSSYGz5YxvhDUBenALY', NULL, '40.87.128.174', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkRJdjZPT0tUM2hER01sWTF6WWdtZlViRkxhVXVvbE5jNXFyNVpKSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vYmFzaWxzdGFyLmNvbS9wdWJsaWMvaW5kZXgucGhwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751901619, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `strategies`
--

CREATE TABLE `strategies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strategies`
--

INSERT INTO `strategies` (`id`, `title`, `description`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'VISHAL MEGA MART – Breakout Above Resistance', 'Vishal Mega Mart has broken out above a key resistance at 133–134 with strong follow-through. Price is now sustaining above the prior range high, confirming a bullish structure.\r\n\r\nKey Levels:\r\n\r\n* Support: 133 / 127.5\r\n* Indicators: MACD in bullish territory, RSI near breakout zone (67)\r\n\r\nView: Bullish bias intact. Sustained move above 134 could lead to momentum continuation toward 145+ levels in the short term.', 'uploads/market_predictions/1750940854_Screenshot (98).png', '2025-06-26 12:27:34', '2025-06-26 12:29:18'),
(2, 'Molestias assumenda', 'Laborum Animi prov Laborum Animi provLaborum Animi provLaborum Animi provLaborum Animi prov', 'uploads/market_predictions/1751456262_Screenshot (94).png', '2025-07-02 11:37:42', '2025-07-02 11:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id_active` bigint(20) UNSIGNED GENERATED ALWAYS AS (if(`status` = 'active',`user_id`,NULL)) VIRTUAL
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
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Bhupendra Dhote', 'bhudhote998@gmail.com', NULL, '$2y$12$TxfWXrBiKCFMoCv/KrSTzeMWGB3HIUPASAir.XhousToj1J/99uai', 1, NULL, '2025-06-26 11:19:23', '2025-06-26 11:19:23'),
(2, 'MOHAMMAD RAZA', 'razamohammad0589@gmail.com', NULL, '$2y$12$QWabvbQUxByVEhXeKAqIhe4EJLq0AFxT7pw7ZR8jUlgmAy29uHshy', 1, NULL, '2025-06-26 11:25:03', '2025-06-26 11:25:03'),
(3, 'test', 'Vicky21ind@gmail.com', NULL, '$2y$12$t4.orTYQxmlJS5RcQ3ufN.veW3Xy9ufolA2rGD7y22yeP0IE/yLqO', 1, NULL, '2025-06-26 12:46:21', '2025-06-26 12:46:21'),
(4, 'shrihari laddha', 'laddhashrihari612@gmail.com', NULL, '$2y$12$fHYlPdG31.r/Xv/.GTO/bOTIUSJITPF0jzWXkVlDDNmGw1k.SwDJm', 1, NULL, '2025-06-26 13:08:32', '2025-06-26 13:08:32'),
(5, 'lkjdretlvssss www.yandex.ru', 'john@protdskeit.ru', NULL, '$2y$12$uGFzrQp5EDjw0dvAx.OD8..L2foD95unuxIoFdUiuSWxYWtlP.jKC', 1, NULL, '2025-07-06 17:06:39', '2025-07-06 17:06:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baskets`
--
ALTER TABLE `baskets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basket_stocks`
--
ALTER TABLE `basket_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `basket_stocks_basket_id_foreign` (`basket_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `market_predictions`
--
ALTER TABLE `market_predictions`
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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_payment_id_unique` (`payment_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_users`
--
ALTER TABLE `registered_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registered_users_email_unique` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `strategies`
--
ALTER TABLE `strategies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_active_unique` (`user_id_active`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baskets`
--
ALTER TABLE `baskets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `basket_stocks`
--
ALTER TABLE `basket_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `market_predictions`
--
ALTER TABLE `market_predictions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_users`
--
ALTER TABLE `registered_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strategies`
--
ALTER TABLE `strategies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `basket_stocks`
--
ALTER TABLE `basket_stocks`
  ADD CONSTRAINT `basket_stocks_basket_id_foreign` FOREIGN KEY (`basket_id`) REFERENCES `baskets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
