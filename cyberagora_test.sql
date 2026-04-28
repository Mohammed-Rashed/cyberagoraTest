-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2026 at 12:45 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cyberagora_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `approval_actions`
--

CREATE TABLE `approval_actions` (
  `id` bigint UNSIGNED NOT NULL,
  `approval_request_id` bigint UNSIGNED NOT NULL,
  `approval_workflow_step_id` bigint UNSIGNED NOT NULL,
  `approver_id` bigint UNSIGNED NOT NULL,
  `action` tinyint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `acted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_actions`
--

INSERT INTO `approval_actions` (`id`, `approval_request_id`, `approval_workflow_step_id`, `approver_id`, `action`, `comment`, `acted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 1, 'approved from my side', '2026-04-28 08:37:22', '2026-04-28 08:37:22', '2026-04-28 08:37:22'),
(2, 2, 1, 4, 1, 'approved with notes', '2026-04-28 09:17:10', '2026-04-28 09:17:10', '2026-04-28 09:17:10');

-- --------------------------------------------------------

--
-- Table structure for table `approval_requests`
--

CREATE TABLE `approval_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` bigint UNSIGNED NOT NULL,
  `requested_by` bigint UNSIGNED NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `current_step_order` int UNSIGNED NOT NULL DEFAULT '1',
  `submitted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_requests`
--

INSERT INTO `approval_requests` (`id`, `form_id`, `requested_by`, `status`, `current_step_order`, `submitted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 3, 4, 2, '2026-04-28 08:30:04', '2026-04-28 08:30:04', '2026-04-28 09:21:30'),
(2, 3, 3, 2, 1, '2026-04-28 09:16:47', '2026-04-28 09:16:47', '2026-04-28 09:17:10'),
(3, 1, 3, 4, 1, '2026-04-28 09:24:47', '2026-04-28 09:24:47', '2026-04-28 09:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `approval_request_steps`
--

CREATE TABLE `approval_request_steps` (
  `id` bigint UNSIGNED NOT NULL,
  `approval_request_id` bigint UNSIGNED NOT NULL,
  `approval_workflow_step_id` bigint UNSIGNED NOT NULL,
  `approver_id` bigint UNSIGNED NOT NULL,
  `step_order` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_request_steps`
--

INSERT INTO `approval_request_steps` (`id`, `approval_request_id`, `approval_workflow_step_id`, `approver_id`, `step_order`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 1, '2026-04-28 09:15:39', '2026-04-28 09:15:39'),
(2, 2, 1, 4, 1, '2026-04-28 09:16:47', '2026-04-28 09:16:47'),
(3, 3, 3, 4, 1, '2026-04-28 09:24:47', '2026-04-28 09:24:47'),
(4, 3, 4, 5, 2, '2026-04-28 09:24:47', '2026-04-28 09:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `approval_request_values`
--

CREATE TABLE `approval_request_values` (
  `id` bigint UNSIGNED NOT NULL,
  `approval_request_id` bigint UNSIGNED NOT NULL,
  `form_field_id` bigint UNSIGNED NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_request_values`
--

INSERT INTO `approval_request_values` (`id`, `approval_request_id`, `form_field_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Hedy Mckee', '2026-04-28 08:30:04', '2026-04-28 08:30:04'),
(2, 1, 2, '2023-10-27', '2026-04-28 08:30:04', '2026-04-28 08:30:04'),
(3, 1, 3, 'Provident aut exerc', '2026-04-28 08:30:04', '2026-04-28 08:30:04'),
(4, 2, 1, 'Regan Fuller', '2026-04-28 09:16:47', '2026-04-28 09:16:47'),
(5, 2, 2, '1974-09-12', '2026-04-28 09:16:47', '2026-04-28 09:16:47'),
(6, 2, 3, 'Doloremque quibusdam', '2026-04-28 09:16:47', '2026-04-28 09:16:47'),
(7, 3, 4, '1', '2026-04-28 09:24:47', '2026-04-28 09:24:47'),
(8, 3, 5, '2026-04-13', '2026-04-28 09:24:47', '2026-04-28 09:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `approval_workflow_steps`
--

CREATE TABLE `approval_workflow_steps` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` bigint UNSIGNED NOT NULL,
  `approver_id` bigint UNSIGNED NOT NULL,
  `step_order` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_workflow_steps`
--

INSERT INTO `approval_workflow_steps` (`id`, `form_id`, `approver_id`, `step_order`, `created_at`, `updated_at`) VALUES
(1, 3, 4, 1, '2026-04-28 08:14:09', '2026-04-28 08:14:09'),
(3, 1, 4, 1, '2026-04-28 09:23:25', '2026-04-28 09:23:25'),
(4, 1, 5, 2, '2026-04-28 09:23:25', '2026-04-28 09:23:37');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`, `description`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Lillian Pratt', 'Aspernatur itaque qu', 1, 1, '2026-04-28 08:09:05', '2026-04-28 08:16:45'),
(2, 'Indira Palmer1', 'Enim corrupti elit', 1, 1, '2026-04-28 08:09:36', '2026-04-28 08:12:09'),
(3, 'Leave Request', 'Request approval for employee leave.', 1, 2, '2026-04-28 08:14:09', '2026-04-28 08:14:09');

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` bigint UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `options` json DEFAULT NULL,
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `form_id`, `label`, `name`, `type`, `is_required`, `options`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 3, 'Employee Name', 'employee_name', 1, 1, NULL, 1, '2026-04-28 08:14:09', '2026-04-28 08:14:09'),
(2, 3, 'Leave Date', 'leave_date', 3, 1, NULL, 2, '2026-04-28 08:14:09', '2026-04-28 08:14:09'),
(3, 3, 'Reason', 'reason', 4, 1, NULL, 3, '2026-04-28 08:14:09', '2026-04-28 08:14:09'),
(4, 1, 'Eum anim rerum dolor', 'jeremy_graham', 5, 1, '[\"1\", \"2\", \"3\"]', 1, '2026-04-28 08:16:45', '2026-04-28 08:16:45'),
(5, 1, 'Leave Date', 'leave_date', 3, 1, NULL, 2, '2026-04-28 09:23:16', '2026-04-28 09:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
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
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_28_000001_add_role_to_users_table', 2),
(5, '2026_04_28_000002_create_forms_table', 2),
(6, '2026_04_28_000003_create_form_fields_table', 2),
(7, '2026_04_28_000004_create_approval_workflow_steps_table', 2),
(8, '2026_04_28_000005_create_approval_requests_table', 2),
(9, '2026_04_28_000006_create_approval_request_values_table', 2),
(10, '2026_04_28_000007_create_approval_actions_table', 2),
(11, '2026_04_28_000008_add_is_active_to_users_table', 3),
(12, '2026_04_28_000009_create_approval_request_steps_table', 4),
(13, '2026_04_28_000010_add_constraints_and_indexes_to_approval_workflow_tables', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint NOT NULL DEFAULT '2',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-04-28 07:41:26', '$2y$12$pGcWiaGaThhDq2Ne8/ARj.G.a2jnmFTbhGFHPW46PqtiSsMf.8m..', 1, 1, 'Q1euNjLLRTm79nIamSlHG6GrOxRGN7QhyIF8eCV2TSIMZinmduLK9OXHLRHf', '2026-04-28 07:41:27', '2026-04-28 07:41:27'),
(2, 'Admin User', 'admin@example.com', NULL, '$2y$12$L5LVuak7dsDwd/VPV2MKO.9vtI1fDXlrqccZmW1VJnc7BsI/sgtRm', 1, 1, NULL, '2026-04-28 08:14:09', '2026-04-28 08:14:09'),
(3, 'Normal User', 'user@example.com', NULL, '$2y$12$nu23692EoE59UlvEaUSih.AZvoWBUZDu7r4mg8FgLLH5bsZ6liVgC', 2, 1, NULL, '2026-04-28 08:14:09', '2026-04-28 08:53:59'),
(4, 'First Approver', 'approver@example.com', NULL, '$2y$12$mSCs3tkXrWNZjg1dQMpnO.1RZToONWxhfbvTvbzArPI48V4cMauqi', 3, 1, NULL, '2026-04-28 08:14:09', '2026-04-28 08:14:09'),
(5, 'Second Approver', 'approver2@example.com', NULL, '$2y$12$FUDIeV1SrN2reHVSQDbcgePEW9KsBmxGorVIezS1kMwUUzamidKBy', 3, 1, NULL, '2026-04-28 08:14:09', '2026-04-28 08:14:09'),
(6, 'Paloma Riggs', 'xony@mailinator.com', NULL, '$2y$12$d/o/YwS2ixofEiqMVR7xiO5fO3oQeYOrLihrvhrjzBUYrXECBLGJ.', 2, 1, NULL, '2026-04-28 08:46:59', '2026-04-28 08:53:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval_actions`
--
ALTER TABLE `approval_actions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `approval_actions_request_step_unique` (`approval_request_id`,`approval_workflow_step_id`),
  ADD KEY `approval_actions_workflow_step_id_fk` (`approval_workflow_step_id`),
  ADD KEY `approval_actions_approver_id_fk` (`approver_id`);

--
-- Indexes for table `approval_requests`
--
ALTER TABLE `approval_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approval_requests_form_id_fk` (`form_id`),
  ADD KEY `approval_requests_requested_by_fk` (`requested_by`);

--
-- Indexes for table `approval_request_steps`
--
ALTER TABLE `approval_request_steps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `request_steps_request_order_unique` (`approval_request_id`,`step_order`),
  ADD KEY `request_steps_approver_id_fk` (`approver_id`);

--
-- Indexes for table `approval_request_values`
--
ALTER TABLE `approval_request_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `request_values_request_field_unique` (`approval_request_id`,`form_field_id`),
  ADD KEY `request_values_form_field_id_fk` (`form_field_id`);

--
-- Indexes for table `approval_workflow_steps`
--
ALTER TABLE `approval_workflow_steps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `workflow_steps_form_order_unique` (`form_id`,`step_order`),
  ADD KEY `workflow_steps_approver_id_fk` (`approver_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forms_created_by_fk` (`created_by`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_fields_form_id_fk` (`form_id`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approval_actions`
--
ALTER TABLE `approval_actions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `approval_requests`
--
ALTER TABLE `approval_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `approval_request_steps`
--
ALTER TABLE `approval_request_steps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `approval_request_values`
--
ALTER TABLE `approval_request_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `approval_workflow_steps`
--
ALTER TABLE `approval_workflow_steps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approval_actions`
--
ALTER TABLE `approval_actions`
  ADD CONSTRAINT `approval_actions_approver_id_fk` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `approval_actions_request_id_fk` FOREIGN KEY (`approval_request_id`) REFERENCES `approval_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `approval_actions_workflow_step_id_fk` FOREIGN KEY (`approval_workflow_step_id`) REFERENCES `approval_workflow_steps` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `approval_requests`
--
ALTER TABLE `approval_requests`
  ADD CONSTRAINT `approval_requests_form_id_fk` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `approval_requests_requested_by_fk` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `approval_request_steps`
--
ALTER TABLE `approval_request_steps`
  ADD CONSTRAINT `request_steps_approver_id_fk` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `request_steps_request_id_fk` FOREIGN KEY (`approval_request_id`) REFERENCES `approval_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `approval_request_values`
--
ALTER TABLE `approval_request_values`
  ADD CONSTRAINT `request_values_form_field_id_fk` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `request_values_request_id_fk` FOREIGN KEY (`approval_request_id`) REFERENCES `approval_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `approval_workflow_steps`
--
ALTER TABLE `approval_workflow_steps`
  ADD CONSTRAINT `workflow_steps_approver_id_fk` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `workflow_steps_form_id_fk` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD CONSTRAINT `form_fields_form_id_fk` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
