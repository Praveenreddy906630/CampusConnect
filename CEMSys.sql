-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 06, 2025 at 11:37 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cemsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coordinators`
--

CREATE TABLE `coordinators` (
  `coordinator_id` int NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `mobile` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `school` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `profile_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinators`
--

INSERT INTO `coordinators` (`coordinator_id`, `user_id`, `mobile`, `ext`, `school`, `profile_pic`, `created_at`, `updated_at`) VALUES
(11, 32, '9834343434', '983', 'SDS', NULL, '2025-12-06 05:14:15', '2025-12-06 05:14:15');

-- --------------------------------------------------------

--
-- Table structure for table `coordinator_event`
--

CREATE TABLE `coordinator_event` (
  `id` int UNSIGNED NOT NULL,
  `coordinator_id` int NOT NULL,
  `event_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinator_event`
--

INSERT INTO `coordinator_event` (`id`, `coordinator_id`, `event_id`, `created_at`, `updated_at`) VALUES
(9, 11, 12, NULL, NULL),
(10, 11, 26, NULL, NULL),
(11, 11, 27, NULL, NULL),
(12, 11, 37, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int NOT NULL,
  `event_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('indoor','outdoor','cultural') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `venue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thumbnail_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `is_group` tinyint(1) NOT NULL DEFAULT '0',
  `max_participants` int DEFAULT NULL,
  `registration_open` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `carousel_image_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `carousel_image_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `carousel_image_3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `carousel_image_4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `carousel_image_5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `max_group_size` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `type`, `description`, `venue`, `thumbnail_image`, `event_date`, `event_time`, `is_group`, `max_participants`, `registration_open`, `created_at`, `updated_at`, `carousel_image_1`, `carousel_image_2`, `carousel_image_3`, `carousel_image_4`, `carousel_image_5`, `max_group_size`) VALUES
(12, 'Check 2', 'indoor', 'Hey', 'Sports Ground', 'events/sFkArVjFUZYwCPnVSz7ZmZrjQyoSmfSoYSEXJHSb.jpg', '2025-09-10', '18:50:00', 0, 2, 1, '2025-09-09 07:50:37', '2025-10-08 08:04:23', 'events/YoRqNGbL6lh3gxVnrTjSBbAAj2BdVHRxDI6D7ckw.jpg', NULL, NULL, NULL, NULL, NULL),
(13, 'Check 15', 'cultural', 'Hey', 'Sports Ground', 'events/UMs9lNU3rQ8E8hdDQfocvnLCPJtmyY3YL4paXMrj.jpg', '2025-09-12', '19:00:00', 0, 50, 1, '2025-09-10 09:00:16', '2025-10-08 09:00:19', NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'Football', 'outdoor', '5v5 football match', 'Ground A', 'events/6yyVW9k6CSDZFT1vl5qw8p0yhlnjKc63OLHqoV1o.jpg', '2025-10-20', '09:00:00', 1, 50, 1, '2025-10-06 21:51:46', '2025-10-06 21:51:46', 'events/0JC2FDRgeUBp3Kpzm9RDh2hTbxUEtf8y9sWmrAGV.png', '', '', '', '', 5),
(27, 'Drama', 'cultural', 'Stage play event', 'Auditorium', 'events/Py1NcnAFeXbyMCImHyNNz3OFCVLo1T3r61ArO6uQ.jpg', '2025-10-21', '14:00:00', 0, 100, 1, '2025-10-06 21:51:46', '2025-10-07 01:41:26', '', '', '', '', '', NULL),
(37, 'check 818', 'indoor', 'check events', NULL, NULL, NULL, NULL, 0, 1000, 1, '2025-10-09 23:14:13', '2025-10-09 23:14:13', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

CREATE TABLE `event_registrations` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `leader_enrolment` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `participant_enrolment` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_registrations`
--

INSERT INTO `event_registrations` (`id`, `event_id`, `leader_enrolment`, `participant_enrolment`, `created_at`, `updated_at`) VALUES
(45, 13, '23SDSCE01161', '23SDSCE01161', '2025-10-06 02:23:41', '2025-10-06 02:23:41'),
(49, 27, '23SDSCE01040', '23SDSCE01040', '2025-10-08 06:34:07', '2025-10-08 06:34:07'),
(50, 13, '23SDSCE01040', '23SDSCE01040', '2025-10-08 07:13:38', '2025-10-08 07:13:38'),
(51, 37, '23SDSCE01040', '23SDSCE01040', '2025-10-09 23:33:50', '2025-10-09 23:33:50'),
(52, 12, 'TEAM81801', 'TEAM81801', '2025-12-06 03:56:56', '2025-12-06 03:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1ZqKLe34zJcsksbdrwcCyDSjOg7qtOlSBW57uMwZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS29LemxtT2ZiQTFTT3RQV0V4Tnl5S09sNWsxOU1SRW9RS25pcW5oWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vY2Vtc3lzLnRlc3QvY29udGFjdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765019255),
('39KXcXAQqiK76LwZaxJrHB8BtQgx5FzccKrZEEua', 32, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTHMyUGpPNUlmMTRlZ3loQXc4M0tJb2JRRFd4ZWhnQTczSURsOE4wNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vY2Vtc3lzLnRlc3QvY29vcmRpbmF0b3IvZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MzI7fQ==', 1765019372),
('jkfjZfRluMpfpQvB3Dj6h1sAReJhfnIbepG4QLdc', 24, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM3NiNG1idXc2TVMwY01YSTFnaDNrSGYwc3FMenNoVGUyZjJaN21YNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vY2Vtc3lzLnRlc3QvZXZlbnRzLzI3L3JlZ2lzdGVyIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjQ7fQ==', 1765019664),
('waawoTUUDJEbYZOmyd0WhRilhjVNVAPngLPuwn4a', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWFrQzRWdnRoRFhYc1VweVBncTdlOWNvNEdxZkxQOVJuZjlvV2dkWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vY2Vtc3lzLnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765018571);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `registration_start` date NOT NULL,
  `registration_end` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `max_outdoor_events` int UNSIGNED NOT NULL DEFAULT '0',
  `max_indoor_events` int UNSIGNED NOT NULL DEFAULT '0',
  `max_cultural_events` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `registration_start`, `registration_end`, `created_at`, `updated_at`, `max_outdoor_events`, `max_indoor_events`, `max_cultural_events`) VALUES
(1, '2025-07-25', '2050-04-06', '2025-09-06 13:42:52', '2025-12-06 03:55:54', 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `soty`
--

CREATE TABLE `soty` (
  `soty_id` int NOT NULL,
  `enrolment_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `even_attendance` decimal(5,2) NOT NULL,
  `odd_attendance` decimal(5,2) NOT NULL,
  `even_cgpa` decimal(4,2) NOT NULL,
  `odd_cgpa` decimal(4,2) NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soty`
--

INSERT INTO `soty` (`soty_id`, `enrolment_no`, `even_attendance`, `odd_attendance`, `even_cgpa`, `odd_cgpa`, `details`, `question`, `file_location`, `created_at`, `updated_at`) VALUES
(14, '23SDSCE01161', 80.00, 80.00, 8.00, 8.00, 'Hey', 'Hey', 'soty/23SDSCE01161_JAINIL_AMITBHAI_LATHIGARA_documents.zip', '2025-09-19 02:39:02', '2025-09-19 02:39:02');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `enroll_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `program_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dept_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `school_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `school_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `semester` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_tms` int NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `enroll_no`, `full_name`, `program_code`, `gender`, `mobile`, `email`, `dept_code`, `school_code`, `school_name`, `semester`, `password`, `is_tms`, `createdAt`, `updatedAt`) VALUES
(3, 'TEAM81801', 'Nirad Patel', 'CE', 'M', '8200656818', 'dccord3+student@gmail.com', 'CE', 'SDS', 'SCHOOL OF DIPLOMA STUDIES', '1', '0', 0, '2025-10-10 06:42:55', '2025-10-10 06:42:55'),
(4, 'TEAM81804', 'SHARMA ANIKET RAJESH', 'ME', 'M', '9876543211', 'asharma404@team.ac.in', 'ME', 'SOT', 'SCHOOL OF TECHNOLOGY', '4', '0', 0, '2025-10-13 11:25:50', '2025-10-13 11:25:50'),
(5, 'TEAM81805', 'PATEL KIYA DINESH', 'CE', 'F', '9898765433', 'kpatel505@team.ac.in', 'CE', 'SDS', 'SCHOOL OF DIPLOMA STUDIES', '1', '0', 0, '2025-10-14 12:30:55', '2025-10-14 12:30:55'),
(6, 'TEAM81806', 'GUPTA RAHUL SANTOSH', 'CS', 'M', '9765432110', 'rgupta606@team.ac.in', 'CS', 'SOT', 'SCHOOL OF TECHNOLOGY', '6', '0', 0, '2025-10-15 13:35:00', '2025-10-15 13:35:00'),
(7, 'TEAM81807', 'MISHRA SONALI VINAY', 'EE', 'F', '9988776656', 'smishra707@team.ac.in', 'EE', 'SOT', 'SCHOOL OF TECHNOLOGY', '5', '0', 0, '2025-10-16 14:40:05', '2025-10-16 14:40:05'),
(8, 'TEAM81808', 'REDDY VIVEK KUMAR', 'BT', 'M', '9321654988', 'vreddy808@team.ac.in', 'BT', 'SOT', 'SCHOOL OF TECHNOLOGY', '3', '0', 0, '2025-10-17 15:45:10', '2025-10-17 15:45:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `enrolment_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_type` enum('student','coordinator','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `enrolment_no`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `user_type`) VALUES
(24, 'TEAM81801', 'Nirad Patel', 'campusconnect.corporate+student@gmail.com', NULL, '$2y$12$AmY13e/fW7aCRVw6MExuZerC7t7K9gcBTY6jg7y7N3nAg633dYuc2', NULL, '2025-10-08 05:16:56', '2025-10-08 05:16:56', 'student'),
(31, NULL, 'Admin CampusConnect', 'campusconnect.corporate+admin@gmail.com', NULL, '$2y$12$ArbvtWSIiz4cVZXgW4EWKO5ZKqpmP1Zq8IjpBZnxYrKcS1etjoR16', NULL, '2025-12-06 05:11:57', '2025-12-06 05:11:57', 'admin'),
(32, NULL, 'Coordinator CampusConnect', 'campusconnect.corporate+co@gmail.com', NULL, '$2y$12$luCgBn1W12s8tygLQIfcvOuREeED5JubikJxMwTMYjoBWtjxUTnWG', NULL, '2025-12-06 05:14:15', '2025-12-06 05:14:15', 'coordinator');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `coordinators`
--
ALTER TABLE `coordinators`
  ADD PRIMARY KEY (`coordinator_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `coordinator_event`
--
ALTER TABLE `coordinator_event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_coordinator_event` (`coordinator_id`,`event_id`),
  ADD KEY `fk_coordinator_event_event` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event` (`event_id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soty`
--
ALTER TABLE `soty`
  ADD PRIMARY KEY (`soty_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `enrolment_no` (`enrolment_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coordinators`
--
ALTER TABLE `coordinators`
  MODIFY `coordinator_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `coordinator_event`
--
ALTER TABLE `coordinator_event`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `soty`
--
ALTER TABLE `soty`
  MODIFY `soty_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coordinators`
--
ALTER TABLE `coordinators`
  ADD CONSTRAINT `coordinators_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coordinator_event`
--
ALTER TABLE `coordinator_event`
  ADD CONSTRAINT `fk_coordinator_event_coordinator` FOREIGN KEY (`coordinator_id`) REFERENCES `coordinators` (`coordinator_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_coordinator_event_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD CONSTRAINT `fk_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
