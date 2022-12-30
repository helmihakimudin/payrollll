-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Agu 2021 pada 12.28
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payroll`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `account_lists`
--

CREATE TABLE `account_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initial_balance` int(11) NOT NULL,
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_branch` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `allowances`
--

CREATE TABLE `allowances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `allowance_option` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `allowances`
--

INSERT INTO `allowances` (`id`, `employee_id`, `allowance_option`, `title`, `amount`, `created_by`, `created_at`, `updated_at`) VALUES
(7, 188, 4, '', 500000, 1, '2021-05-21 02:37:50', '2021-05-21 02:37:50'),
(8, 188, 4, '', 500000, 1, '2021-05-21 02:38:54', '2021-05-21 02:38:54'),
(11, 188, 7, '-', 45000, 1, '2021-08-09 03:11:47', '2021-08-09 03:11:47'),
(12, 188, 6, '-', 15000, 1, '2021-08-12 07:01:14', '2021-08-12 07:01:14'),
(13, 186, 4, '-', 10000, 1, '2021-08-12 11:03:00', '2021-08-12 11:03:00'),
(14, 186, 5, '-', 17000, 1, '2021-08-12 11:03:12', '2021-08-12 11:03:12'),
(15, 186, 6, '-', 5000, 1, '2021-08-12 11:03:20', '2021-08-12 11:03:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `allowance_options`
--

CREATE TABLE `allowance_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `allowance_options`
--

INSERT INTO `allowance_options` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(4, 'Tunjangan Kerajinan', 1, '2021-05-06 02:31:11', '2021-05-06 02:31:11'),
(5, 'Tunjangan OP', 1, '2021-05-06 02:31:39', '2021-05-24 21:39:15'),
(6, 'Tunjangan Lembur', 1, '2021-05-06 02:32:06', '2021-05-24 21:39:46'),
(7, 'Komisi', 1, '2021-05-24 21:40:06', '2021-05-24 21:40:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `branch_id` int(11) NOT NULL,
  `department_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `announcement_employees`
--

CREATE TABLE `announcement_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendance_employees`
--

CREATE TABLE `attendance_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clock_in` time NOT NULL,
  `clock_out` time NOT NULL,
  `late` time NOT NULL,
  `early_leaving` time NOT NULL,
  `overtime` time NOT NULL,
  `total_rest` time NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `attendance_employees`
--

INSERT INTO `attendance_employees` (`id`, `employee_id`, `date`, `status`, `clock_in`, `clock_out`, `late`, `early_leaving`, `overtime`, `total_rest`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 83, '2021-06-16', 'Present', '08:15:50', '08:15:59', '-00:00:01', '10:44:01', '00:00:00', '00:00:00', 83, '2021-06-16 01:15:50', '2021-06-16 01:15:59'),
(2, 83, '2021-06-16', 'Present', '08:19:18', '00:00:00', '-00:00:01', '00:00:00', '00:00:00', '00:00:00', 83, '2021-06-16 01:19:18', '2021-06-16 01:19:18'),
(3, 20, '2021-06-16', 'Present', '08:23:08', '19:00:00', '-00:00:01', '00:00:00', '00:00:00', '00:00:00', 20, '2021-06-16 01:23:08', '2021-06-16 01:23:08'),
(4, 20, '2021-06-16', 'Present', '08:23:08', '08:56:23', '-00:00:01', '10:03:37', '00:00:00', '00:00:00', 20, '2021-06-16 01:23:08', '2021-06-16 01:56:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `awards`
--

CREATE TABLE `awards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `award_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `gift` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `award_types`
--

CREATE TABLE `award_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `award_types`
--

INSERT INTO `award_types` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Kerajinan', 1, '2020-05-07 23:03:12', '2020-05-07 23:03:12'),
(2, 'Reward', 1, '2021-04-08 00:33:41', '2021-04-08 00:33:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `branches`
--

INSERT INTO `branches` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'HPS', 1, '2020-05-07 22:58:57', '2020-05-07 22:58:57'),
(2, 'TADS', 1, '2020-05-07 22:58:57', '2020-05-07 22:58:57'),
(3, 'DSS', 1, '2020-05-07 22:58:57', '2020-05-07 22:58:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `commissions`
--

INSERT INTO `commissions` (`id`, `employee_id`, `title`, `amount`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 2, '-', 0, 1, '2021-04-09 01:03:02', '2021-04-09 01:03:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `complaint_from` int(11) NOT NULL,
  `complaint_against` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complaint_date` date NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `contract`
--

CREATE TABLE `contract` (
  `id` int(6) NOT NULL,
  `contract_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `contract`
--

INSERT INTO `contract` (`id`, `contract_name`, `created_at`, `updated_at`) VALUES
(1, 'Kontrak 1 Tahun', '2021-05-28 02:59:31', '2021-05-28 02:59:31'),
(3, 'Tetap', '2021-05-28 10:15:20', '2021-05-28 03:07:57'),
(4, 'Probation', '2021-05-28 04:23:16', '2021-05-28 04:23:16'),
(5, 'Probation SPV', '2021-05-28 04:24:05', '2021-05-28 04:24:05'),
(6, 'Kontrak 3 Bulan', '2021-05-28 04:27:28', '2021-05-28 04:27:28'),
(7, 'Kontrak 6 Bulan', '2021-05-28 04:29:36', '2021-05-28 04:29:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `deduction_options`
--

CREATE TABLE `deduction_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `deduction_options`
--

INSERT INTO `deduction_options` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 'PPh 21', 1, '2021-05-06 02:32:37', '2021-06-26 23:16:26'),
(4, 'BPJS Kesehatan', 1, '2021-05-06 02:32:54', '2021-05-06 02:32:54'),
(5, 'BPJS Ketenagakerjaan', 1, '2021-05-06 02:33:10', '2021-05-06 02:33:10'),
(6, 'Keterlambatan', 1, '2021-05-06 02:33:18', '2021-05-06 02:33:18'),
(7, 'Potongan Denda dll', 1, '2021-05-24 21:40:35', '2021-05-24 21:40:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `departments`
--

INSERT INTO `departments` (`id`, `branch_id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 3, 'TELE', 1, '2020-05-07 23:04:52', '2021-05-24 21:19:53'),
(2, 3, 'CRM', 1, '2020-05-07 23:05:14', '2021-05-24 21:20:01'),
(6, 2, 'IT', 1, '2021-05-24 21:36:33', '2021-05-24 21:36:33'),
(7, 3, 'Admin WA', 1, '2021-05-25 01:15:19', '2021-05-25 01:15:19'),
(8, 3, 'HRD/Management', 1, '2021-05-25 01:16:31', '2021-05-27 21:06:56'),
(9, 1, 'SEO', 1, '2021-05-25 01:16:55', '2021-05-25 01:16:55'),
(10, 1, 'Sosmed', 1, '2021-05-25 01:17:10', '2021-05-25 01:17:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `income_category_id` int(11) NOT NULL,
  `payer_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `referal_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `designations`
--

INSERT INTO `designations` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Staff', 1, '2020-05-07 23:20:37', '2020-06-11 05:05:26'),
(2, 'SPV', 1, '2020-05-07 23:20:55', '2020-06-11 05:05:32'),
(5, 'Karyawan', 1, '2021-04-28 21:54:17', '2021-04-28 21:54:17'),
(6, 'Head of Division', 1, '2021-05-06 21:36:19', '2021-05-06 21:36:19'),
(7, 'Manager', 1, '2021-05-25 01:18:37', '2021-05-25 01:18:37'),
(8, 'Direktur', 1, '2021-05-25 01:18:53', '2021-05-25 01:18:53'),
(9, 'OB & Messenger', 1, '2021-05-25 01:20:24', '2021-05-25 01:20:24'),
(10, 'Back Link', 1, '2021-05-27 02:16:07', '2021-05-27 02:16:07'),
(11, 'Web Designer', 1, '2021-05-27 02:16:18', '2021-05-27 02:16:18'),
(12, 'SEO', 1, '2021-05-27 02:16:28', '2021-05-27 02:16:28'),
(13, 'Graphic Designer', 1, '2021-05-27 02:16:41', '2021-05-27 02:16:41'),
(14, 'Content Writer', 1, '2021-05-27 02:16:54', '2021-05-27 02:16:54'),
(15, 'Videographer', 1, '2021-05-27 02:17:16', '2021-05-27 02:17:16'),
(16, 'Programmer', 1, '2021-05-27 02:17:25', '2021-05-27 02:17:25'),
(17, 'Technical Support', 1, '2021-05-27 02:17:36', '2021-05-27 02:17:36'),
(18, 'UI/UX Designer', 1, '2021-05-27 02:17:53', '2021-05-27 02:17:53'),
(19, 'Web Designer', 1, '2021-05-27 21:20:12', '2021-05-27 21:20:12'),
(20, 'Marketing Staff', 1, '2021-06-25 21:49:23', '2021-06-25 21:49:23'),
(21, 'Admin Advertising', 1, '2021-06-25 21:49:35', '2021-06-25 21:49:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `documents`
--

INSERT INTO `documents` (`id`, `name`, `is_required`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'KTP', '0', 1, '2020-05-07 23:11:58', '2020-06-11 05:57:24'),
(2, 'KK', '0', 1, '2020-05-07 23:12:06', '2020-06-11 05:57:21'),
(3, 'NPWP', '0', 1, '2020-05-07 23:12:16', '2020-06-11 05:57:16'),
(4, 'Photo', '0', 1, '2020-05-07 23:12:27', '2020-05-07 23:12:27'),
(5, 'Ijazah', '0', 1, '2020-05-07 23:12:27', '2020-05-07 23:12:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_card` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merriage_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_card` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_card_address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_children` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `department_id` int(11) NOT NULL DEFAULT 0,
  `designation_id` int(11) NOT NULL DEFAULT 0,
  `company_doj` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_identifier_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_payer_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_type` int(11) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `calculate_work` bigint(11) DEFAULT NULL,
  `amount_work` bigint(11) DEFAULT NULL,
  `net_salary` bigint(11) DEFAULT NULL,
  `keterangan` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `name`, `dob`, `gender`, `phone`, `id_card`, `employee_status`, `merriage_status`, `family_card`, `id_card_address`, `number_children`, `address`, `email`, `password`, `contract_status`, `employee_id`, `branch_id`, `department_id`, `designation_id`, `company_doj`, `documents`, `account_holder_name`, `account_number`, `bank_name`, `bank_identifier_code`, `branch_location`, `tax_payer_id`, `salary_type`, `salary`, `calculate_work`, `amount_work`, `net_salary`, `keterangan`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(183, 0, 'sakti tua petrus', '2021-08-04', 'Perempuan', '32423432', '324324234', 'Aktif', 'Belum Menikah', '3432423', 'fasdfads', '2342', 'faddasfasdf', 'dafasd@gmail.com', '$2y$10$NOE1GXY02PoROlZqbM7jee2jl5OGFKEihHywU6HQ9BmOST3N8eh6W', 'Kontrak 1 Tahun', '0', 0, 0, 0, '2021-08-24', NULL, 'fdsafasfasdfasd', '324324234', 'fsfadasd', NULL, NULL, '324432', 2, 700000, NULL, NULL, 700000, NULL, 1, 0, '2021-08-05 12:38:33', '2021-08-10 06:49:54'),
(184, 0, 'santi', '2021-08-11', 'Perempuan', '324324', '3243242', 'Tidak Aktif', 'Belum Menikah', '324324', 'dfasfds', '324324', 'fasdfas', 'fdsfasdf@gmail.com', '$2y$10$TcxPa5vidERe9YfXlDdAkuS82WQvTpZGB9NQZaiAH0seuADfJJJjG', 'Kontrak 1 Tahun', '0', 0, 0, 0, '2021-08-18', NULL, 'fdasfasd', '324324234', 'fdasfas', NULL, NULL, '423423', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-05 12:38:33', '2021-08-05 12:38:33'),
(185, 0, 'lukas', '2021-08-19', 'Laki-Laki', '32432432', '32432432', 'Tidak Aktif', 'Belum Menikah', '324324', 'fadsfasdf', '3', 'fdsasdfaf', 'dsafds@gmail.com', '$2y$10$JeTqiUpylj6Y29gbCgVQ4OxS90BFKgMToVDUFhVoUz48wKrHDkmc6', 'Kontrak 1 Tahun', '0', 0, 0, 0, '2021-09-18', NULL, 'fsadfasdf', '32432423', 'faasdf', NULL, NULL, '324324', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-05 12:38:33', '2021-08-05 12:38:33'),
(186, 0, 'martina', '2021-08-11', 'Perempuan', '534534534', '32432432', 'Aktif', 'Belum Menikah', '3', 'fadsfsadf', '0', 'fsadfsadfasdf', 'gfdsg@gmail.com', '$2y$10$FouuSCbuhXNvKHNv6xk7Q.6kJgnooFRaWdPnO6aS5BB9/FD21Ly66', 'Kontrak 1 Tahun', '0', 0, 0, 0, '2021-08-24', NULL, 'fasdfsadf', '324324324324', 'fasfasdfasdf', NULL, NULL, '5345345', 3, 8000000, NULL, NULL, 8000000, NULL, 1, 0, '2021-08-05 12:38:34', '2021-08-10 06:49:54'),
(187, 0, 'surti', '2021-08-19', 'Laki-Laki', '32432432', '3243242', 'Aktif', 'Belum Menikah', '32423423', 'fasfdfafas', '2', 'fdasfdsfads', 'fdsafsd@gmail.com', '$2y$10$POVKdmzD9uXkGJblri880O796FCp6bvOFlN.LNs7uiU5j.SzYMdmO', 'Kontrak 1 Tahun', '0', 0, 0, 0, '2021-08-23', NULL, 'fdsafasfasdfasd', '32432432432', '3r432423', NULL, NULL, '324324', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-05 12:38:34', '2021-08-05 12:38:34'),
(188, 1, 'Sri Rahayu', '2021-08-11', 'Perempuan', '34234324', '3245244234', 'Tidak Aktif', 'Belum Menikah', '3234423', 'fdasf', '432432423', 'fadfdssadfdsaf', 'srirahayu@gmail.com', '$2a$12$YJZiSThhsIGxaw3GCFrEsucv5QIo52sGhhYHZO49BZAk2O8q//p/a', 'Kontrak 1 Tahun', '0', 3, 1, 1, '2021-08-18', '[{\"document1\":null,\"document2\":null,\"document3\":null,\"document4\":\"4827655210WhatsApp Image 2021-06-02 at 14.07.23.jpeg\",\"document5\":null}]', 'fadsfasdfas', '234234324', 'fasdfasd', NULL, NULL, '324324', 3, 5500000, 20, 20, 5500000, NULL, 1, 1, '2021-08-05 12:38:34', '2021-08-16 09:37:58'),
(189, 1, 'excel', '2021-08-11', 'Laki-Laki', '34234324', '3245244234', 'Tidak Aktif', 'Belum Menikah', '3234423', 'fdasf', '432432423', 'fadfdssadfdsaf', 'anton@gmail.com', '$2y$10$MTkqtO7SFZVVuRaxrlVqRe4o2a.wBTAd7z6iAYjkjnFtnMPMAT0A2', 'Kontrak 1 Tahun', '0', 1, 2, 5, '2021-08-18', '[{\"document1\":null,\"document2\":null,\"document3\":null,\"document4\":\"74103jokowi.jpg\",\"document5\":null}]', 'fadsfasdfas', '234234324', 'fasdfasd', NULL, NULL, '324324', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2021-08-05 12:38:34', '2021-08-05 12:39:49'),
(190, 0, 'word', '2021-08-04', 'Perempuan', '32423432', '324324234', 'Aktif', 'Belum Menikah', '3432423', 'fasdfads', '2342', 'faddasfasdf', 'dimas@gmail.com', '$2y$10$L4U6KIk5uexa.NIvQA5y/.muJFcO58jIA1QenUmwmpgIBsets3wNu', 'Kontrak 1 Tahun', '0', 0, 0, 0, '2021-08-24', NULL, 'fdsafasfasdfasd', '324324234', 'fsfadasd', NULL, NULL, '324432', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-05 12:38:44', '2021-08-05 12:38:44'),
(191, 0, 'sammy', '2021-08-04', 'Perempuan', '32423432', '324324234', 'Aktif', 'Belum Menikah', '3432423', 'fasdfads', '2342', 'faddasfasdf', 'santi@gmail.com', '$2y$10$kFkZ6PDINdOR8n8bmJIpROpdj2a74/QuUjE6UJu0oAWOpdmeYydaW', 'Kontrak 1 Tahun', '0', 0, 0, 0, '2021-08-24', NULL, 'fdsafasfasdfasd', '324324234', 'fsfadasd', NULL, NULL, '324432', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2021-08-06 10:44:12', '2021-08-06 10:44:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_documents`
--

CREATE TABLE `employee_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `document_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `department_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `events`
--

INSERT INTO `events` (`id`, `branch_id`, `department_id`, `employee_id`, `title`, `start_date`, `end_date`, `color`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '[\"4\"]', '[\"0\"]', 'Team Audit', '2021-04-17', '2021-04-17', '#3abaf4', 'kkk', 1, '2021-04-15 20:42:21', '2021-04-15 20:42:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `event_employees`
--

CREATE TABLE `event_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `payee_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `referal_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `expense_types`
--

CREATE TABLE `expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `genrate_payslip_options`
--

CREATE TABLE `genrate_payslip_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `income_types`
--

CREATE TABLE `income_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `income_types`
--

INSERT INTO `income_types` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Bonus', 1, '2020-05-07 23:13:35', '2020-05-07 23:13:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kasbon`
--

CREATE TABLE `kasbon` (
  `id` int(6) NOT NULL,
  `employee_id` int(6) NOT NULL,
  `department_id` int(6) NOT NULL,
  `amount` int(100) NOT NULL,
  `remark` text NOT NULL,
  `date_kasbon` date NOT NULL,
  `approval_check` int(3) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kasbon`
--

INSERT INTO `kasbon` (`id`, `employee_id`, `department_id`, `amount`, `remark`, `date_kasbon`, `approval_check`, `created_at`, `updated_at`) VALUES
(1, 188, 1, 1400000, 'bayar utang', '2021-08-13', 2, '2021-08-13 10:52:43', '2021-08-13 10:52:43'),
(3, 188, 1, 1400000, 'kebutuhan hidup', '2021-08-18', 1, '2021-08-13 10:52:47', '2021-08-13 10:52:47'),
(4, 188, 1, 3424324, 'faasdfa', '2021-08-25', 2, '2021-08-13 12:03:45', '2021-08-13 12:03:45'),
(5, 188, 1, 450000, 'beli handphone', '2021-08-16', 1, '2021-08-16 08:20:30', '2021-08-16 08:20:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `applied_on` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_leave_days` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_reason` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `leave_types`
--

INSERT INTO `leave_types` (`id`, `title`, `days`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Cuti Tahunan', 12, 1, '2020-05-07 23:14:05', '2020-05-07 23:14:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `loan_option` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `loans`
--

INSERT INTO `loans` (`id`, `employee_id`, `loan_option`, `title`, `amount`, `start_date`, `end_date`, `reason`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 2, 0, '-', 0, '0000-00-00', '0000-00-00', '-', 1, '2021-04-09 01:03:02', '2021-04-09 01:03:02'),
(4, 2, 0, '-', 0, '0000-00-00', '0000-00-00', '-', 1, '2021-04-09 01:03:38', '2021-04-09 01:03:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `loan_customs`
--

CREATE TABLE `loan_customs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `loan_type` enum('salary','bonus') COLLATE utf8mb4_unicode_ci NOT NULL,
  `loan_amount` int(11) NOT NULL,
  `tenor` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `loan_options`
--

CREATE TABLE `loan_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `loan_options`
--

INSERT INTO `loan_options` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Potong Gaji Bulanan', 1, '2020-05-07 23:14:22', '2020-06-19 01:22:21'),
(2, 'Potong Bonus Tahunan', 1, '2020-06-19 01:22:30', '2020-06-19 01:22:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `department_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `meeting_employees`
--

CREATE TABLE `meeting_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_12_24_083734_create_permission_tables', 1),
(4, '2019_12_26_073332_create_settings_table', 1),
(5, '2019_12_26_101754_create_departments_table', 1),
(6, '2019_12_26_101814_create_designations_table', 1),
(7, '2019_12_26_105721_create_documents_table', 1),
(8, '2019_12_27_083751_create_branches_table', 1),
(9, '2019_12_27_090831_create_employees_table', 1),
(10, '2019_12_27_112922_create_employee_documents_table', 1),
(11, '2019_12_28_050508_create_awards_table', 1),
(12, '2019_12_28_050919_create_award_types_table', 1),
(13, '2019_12_31_060916_create_termination_types_table', 1),
(14, '2019_12_31_062259_create_terminations_table', 1),
(15, '2019_12_31_070521_create_resignations_table', 1),
(16, '2019_12_31_072252_create_travels_table', 1),
(17, '2019_12_31_090637_create_promotions_table', 1),
(18, '2019_12_31_092838_create_transfers_table', 1),
(19, '2019_12_31_100319_create_warnings_table', 1),
(20, '2019_12_31_103019_create_complaints_table', 1),
(21, '2020_01_02_090837_create_payslip_types_table', 1),
(22, '2020_01_02_093331_create_allowance_options_table', 1),
(23, '2020_01_02_102558_create_loan_options_table', 1),
(24, '2020_01_02_103822_create_deduction_options_table', 1),
(25, '2020_01_02_110828_create_genrate_payslip_options_table', 1),
(26, '2020_01_02_111807_create_set_salaries_table', 1),
(27, '2020_01_03_084302_create_allowances_table', 1),
(28, '2020_01_03_101735_create_commissions_table', 1),
(29, '2020_01_03_105019_create_loans_table', 1),
(30, '2020_01_03_105046_create_saturation_deductions_table', 1),
(31, '2020_01_03_105100_create_other_payments_table', 1),
(32, '2020_01_03_105111_create_overtimes_table', 1),
(33, '2020_01_04_072527_create_pay_slips_table', 1),
(34, '2020_01_06_045425_create_account_lists_table', 1),
(35, '2020_01_06_062213_create_payees_table', 1),
(36, '2020_01_06_070037_create_payers_table', 1),
(37, '2020_01_06_072939_create_income_types_table', 1),
(38, '2020_01_06_073055_create_expense_types_table', 1),
(39, '2020_01_06_085218_create_deposits_table', 1),
(40, '2020_01_06_090709_create_payment_types_table', 1),
(41, '2020_01_06_121442_create_expenses_table', 1),
(42, '2020_01_06_124036_create_transfer_balances_table', 1),
(43, '2020_01_13_084720_create_events_table', 1),
(44, '2020_01_16_041720_create_announcements_table', 1),
(45, '2020_01_16_090747_create_leave_types_table', 1),
(46, '2020_01_16_093256_create_leaves_table', 1),
(47, '2020_01_16_110357_create_meetings_table', 1),
(48, '2020_01_17_051906_create_tickets_table', 1),
(49, '2020_01_17_112647_create_ticket_replies_table', 1),
(50, '2020_01_23_101613_create_meeting_employees_table', 1),
(51, '2020_01_23_123844_create_event_employees_table', 1),
(52, '2020_01_24_062752_create_announcement_employees_table', 1),
(53, '2020_01_27_052503_create_attendance_employees_table', 1),
(54, '2020_02_28_051636_create_time_sheets_table', 1),
(55, '2020_06_23_165127_create_yearly_bonuses_table', 2),
(56, '2020_06_24_185700_create_loan_customs_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2),
(3, 'App\\User', 4),
(3, 'App\\User', 5),
(3, 'App\\User', 6),
(3, 'App\\User', 7),
(3, 'App\\User', 8),
(3, 'App\\User', 9),
(3, 'App\\User', 10),
(3, 'App\\User', 11),
(3, 'App\\User', 13),
(3, 'App\\User', 15),
(3, 'App\\User', 17),
(3, 'App\\User', 18),
(3, 'App\\User', 19),
(3, 'App\\User', 20),
(3, 'App\\User', 21),
(3, 'App\\User', 22),
(3, 'App\\User', 23),
(3, 'App\\User', 24),
(3, 'App\\User', 25),
(3, 'App\\User', 26),
(3, 'App\\User', 27),
(3, 'App\\User', 28),
(3, 'App\\User', 29),
(3, 'App\\User', 30),
(3, 'App\\User', 31),
(3, 'App\\User', 32),
(3, 'App\\User', 33),
(3, 'App\\User', 34),
(3, 'App\\User', 35),
(3, 'App\\User', 36),
(3, 'App\\User', 37),
(3, 'App\\User', 38),
(3, 'App\\User', 39),
(3, 'App\\User', 40),
(3, 'App\\User', 41),
(3, 'App\\User', 42),
(3, 'App\\User', 43),
(3, 'App\\User', 44),
(3, 'App\\User', 45),
(3, 'App\\User', 46),
(3, 'App\\User', 47),
(3, 'App\\User', 48),
(3, 'App\\User', 49),
(3, 'App\\User', 50),
(3, 'App\\User', 51),
(3, 'App\\User', 52),
(3, 'App\\User', 53),
(3, 'App\\User', 54),
(3, 'App\\User', 55),
(3, 'App\\User', 56),
(3, 'App\\User', 57),
(3, 'App\\User', 58),
(3, 'App\\User', 59),
(3, 'App\\User', 60),
(3, 'App\\User', 61),
(3, 'App\\User', 62),
(3, 'App\\User', 63),
(3, 'App\\User', 64),
(3, 'App\\User', 65),
(3, 'App\\User', 66),
(3, 'App\\User', 67),
(3, 'App\\User', 68),
(3, 'App\\User', 69),
(3, 'App\\User', 70),
(3, 'App\\User', 71),
(3, 'App\\User', 72),
(3, 'App\\User', 73),
(3, 'App\\User', 74),
(3, 'App\\User', 75),
(3, 'App\\User', 76),
(3, 'App\\User', 77),
(3, 'App\\User', 78),
(3, 'App\\User', 79),
(3, 'App\\User', 80),
(3, 'App\\User', 81),
(3, 'App\\User', 82),
(3, 'App\\User', 83),
(3, 'App\\User', 84),
(3, 'App\\User', 85),
(3, 'App\\User', 86),
(3, 'App\\User', 87),
(3, 'App\\User', 88),
(3, 'App\\User', 89),
(3, 'App\\User', 90),
(3, 'App\\User', 91),
(3, 'App\\User', 92),
(3, 'App\\User', 93),
(3, 'App\\User', 94),
(3, 'App\\User', 95),
(3, 'App\\User', 96),
(3, 'App\\User', 97),
(3, 'App\\User', 98),
(3, 'App\\User', 99),
(3, 'App\\User', 100),
(3, 'App\\User', 101),
(3, 'App\\User', 102),
(3, 'App\\User', 103),
(3, 'App\\User', 104),
(3, 'App\\User', 105),
(3, 'App\\User', 106),
(3, 'App\\User', 107),
(3, 'App\\User', 108),
(3, 'App\\User', 109),
(3, 'App\\User', 110),
(3, 'App\\User', 111),
(3, 'App\\User', 112),
(3, 'App\\User', 113),
(3, 'App\\User', 114),
(3, 'App\\User', 115),
(3, 'App\\User', 116),
(3, 'App\\User', 117),
(3, 'App\\User', 118),
(3, 'App\\User', 119),
(3, 'App\\User', 120),
(3, 'App\\User', 121),
(3, 'App\\User', 122),
(3, 'App\\User', 123),
(3, 'App\\User', 124),
(3, 'App\\User', 125),
(3, 'App\\User', 126),
(3, 'App\\User', 127),
(3, 'App\\User', 128),
(3, 'App\\User', 129),
(3, 'App\\User', 130),
(3, 'App\\User', 131),
(3, 'App\\User', 132),
(3, 'App\\User', 133),
(3, 'App\\User', 134),
(3, 'App\\User', 135),
(3, 'App\\User', 136),
(3, 'App\\User', 137),
(3, 'App\\User', 138),
(3, 'App\\User', 139),
(3, 'App\\User', 140),
(3, 'App\\User', 141),
(3, 'App\\User', 142),
(3, 'App\\User', 143),
(3, 'App\\User', 144),
(3, 'App\\User', 145),
(3, 'App\\User', 146),
(3, 'App\\User', 147),
(3, 'App\\User', 148),
(3, 'App\\User', 149),
(3, 'App\\User', 150),
(3, 'App\\User', 151),
(3, 'App\\User', 152),
(3, 'App\\User', 153),
(3, 'App\\User', 154),
(3, 'App\\User', 155),
(3, 'App\\User', 156),
(3, 'App\\User', 157),
(3, 'App\\User', 158),
(3, 'App\\User', 159),
(3, 'App\\User', 160),
(3, 'App\\User', 161),
(3, 'App\\User', 162),
(3, 'App\\User', 163),
(3, 'App\\User', 164),
(3, 'App\\User', 165),
(3, 'App\\User', 166),
(3, 'App\\User', 167),
(3, 'App\\User', 168),
(3, 'App\\User', 169),
(3, 'App\\User', 170),
(3, 'App\\User', 171),
(3, 'App\\User', 172),
(3, 'App\\User', 173),
(3, 'App\\User', 174),
(3, 'App\\User', 175),
(3, 'App\\User', 176),
(3, 'App\\User', 177),
(3, 'App\\User', 178),
(3, 'App\\User', 179),
(3, 'App\\User', 180),
(3, 'App\\User', 181),
(3, 'App\\User', 182),
(3, 'App\\User', 183),
(3, 'App\\User', 184),
(3, 'App\\User', 185),
(3, 'App\\User', 186),
(3, 'App\\User', 187),
(3, 'App\\User', 188),
(3, 'App\\User', 189),
(3, 'App\\User', 190),
(3, 'App\\User', 191),
(3, 'App\\User', 192),
(3, 'App\\User', 193),
(3, 'App\\User', 194),
(3, 'App\\User', 195),
(3, 'App\\User', 196),
(3, 'App\\User', 197),
(3, 'App\\User', 198),
(3, 'App\\User', 199),
(3, 'App\\User', 200),
(3, 'App\\User', 201),
(3, 'App\\User', 202),
(3, 'App\\User', 203),
(3, 'App\\User', 204),
(3, 'App\\User', 205),
(3, 'App\\User', 206),
(3, 'App\\User', 207),
(3, 'App\\User', 208),
(3, 'App\\User', 209),
(3, 'App\\User', 210),
(3, 'App\\User', 211),
(3, 'App\\User', 212),
(3, 'App\\User', 213),
(3, 'App\\User', 214),
(3, 'App\\User', 215),
(3, 'App\\User', 216),
(3, 'App\\User', 217),
(3, 'App\\User', 218),
(3, 'App\\User', 219),
(3, 'App\\User', 220),
(3, 'App\\User', 221),
(3, 'App\\User', 222),
(3, 'App\\User', 223),
(3, 'App\\User', 224),
(3, 'App\\User', 225),
(3, 'App\\User', 226),
(3, 'App\\User', 227),
(3, 'App\\User', 228),
(3, 'App\\User', 229),
(3, 'App\\User', 230),
(3, 'App\\User', 231),
(3, 'App\\User', 232),
(3, 'App\\User', 233),
(3, 'App\\User', 234),
(3, 'App\\User', 235),
(3, 'App\\User', 236),
(3, 'App\\User', 237),
(3, 'App\\User', 238),
(3, 'App\\User', 239),
(3, 'App\\User', 240),
(3, 'App\\User', 241),
(3, 'App\\User', 242),
(3, 'App\\User', 243),
(3, 'App\\User', 244),
(3, 'App\\User', 245),
(3, 'App\\User', 246),
(3, 'App\\User', 247),
(3, 'App\\User', 248),
(3, 'App\\User', 249),
(3, 'App\\User', 250),
(3, 'App\\User', 251),
(3, 'App\\User', 252),
(3, 'App\\User', 253),
(3, 'App\\User', 254),
(3, 'App\\User', 255),
(3, 'App\\User', 256),
(3, 'App\\User', 257),
(3, 'App\\User', 258),
(3, 'App\\User', 259),
(3, 'App\\User', 260),
(3, 'App\\User', 261),
(3, 'App\\User', 262),
(3, 'App\\User', 263),
(3, 'App\\User', 264),
(3, 'App\\User', 265),
(3, 'App\\User', 266),
(3, 'App\\User', 267),
(3, 'App\\User', 268),
(3, 'App\\User', 269),
(3, 'App\\User', 270),
(3, 'App\\User', 271),
(3, 'App\\User', 272),
(3, 'App\\User', 273),
(3, 'App\\User', 274),
(3, 'App\\User', 275),
(3, 'App\\User', 276),
(3, 'App\\User', 277),
(3, 'App\\User', 278),
(3, 'App\\User', 279),
(3, 'App\\User', 280),
(3, 'App\\User', 281),
(3, 'App\\User', 282),
(3, 'App\\User', 283),
(3, 'App\\User', 284),
(3, 'App\\User', 285),
(3, 'App\\User', 286),
(3, 'App\\User', 287),
(3, 'App\\User', 288),
(3, 'App\\User', 289),
(3, 'App\\User', 290),
(3, 'App\\User', 291),
(3, 'App\\User', 292),
(3, 'App\\User', 293),
(3, 'App\\User', 294),
(3, 'App\\User', 295),
(3, 'App\\User', 296),
(3, 'App\\User', 297),
(3, 'App\\User', 298),
(3, 'App\\User', 299),
(3, 'App\\User', 300),
(3, 'App\\User', 301),
(3, 'App\\User', 302),
(3, 'App\\User', 303),
(3, 'App\\User', 304),
(3, 'App\\User', 305),
(3, 'App\\User', 306),
(3, 'App\\User', 307),
(3, 'App\\User', 308),
(3, 'App\\User', 309),
(3, 'App\\User', 310),
(3, 'App\\User', 311),
(3, 'App\\User', 312),
(3, 'App\\User', 313),
(3, 'App\\User', 314),
(3, 'App\\User', 315),
(3, 'App\\User', 316),
(3, 'App\\User', 317),
(3, 'App\\User', 318),
(3, 'App\\User', 319),
(3, 'App\\User', 320),
(3, 'App\\User', 321),
(3, 'App\\User', 322),
(3, 'App\\User', 323),
(3, 'App\\User', 324),
(3, 'App\\User', 325),
(3, 'App\\User', 326),
(3, 'App\\User', 327),
(3, 'App\\User', 328),
(3, 'App\\User', 329),
(3, 'App\\User', 330),
(3, 'App\\User', 331),
(3, 'App\\User', 332),
(3, 'App\\User', 333),
(3, 'App\\User', 334),
(3, 'App\\User', 335),
(3, 'App\\User', 336),
(3, 'App\\User', 337),
(3, 'App\\User', 338),
(3, 'App\\User', 339),
(3, 'App\\User', 340),
(3, 'App\\User', 341),
(3, 'App\\User', 342),
(3, 'App\\User', 343),
(3, 'App\\User', 344),
(3, 'App\\User', 345),
(3, 'App\\User', 346),
(3, 'App\\User', 347),
(3, 'App\\User', 348),
(3, 'App\\User', 349),
(3, 'App\\User', 350),
(3, 'App\\User', 351),
(3, 'App\\User', 352),
(3, 'App\\User', 353),
(3, 'App\\User', 354),
(3, 'App\\User', 355),
(3, 'App\\User', 356),
(3, 'App\\User', 357),
(3, 'App\\User', 358),
(3, 'App\\User', 359),
(3, 'App\\User', 360),
(3, 'App\\User', 361),
(3, 'App\\User', 362),
(3, 'App\\User', 363),
(3, 'App\\User', 364),
(3, 'App\\User', 365),
(3, 'App\\User', 366),
(3, 'App\\User', 367),
(3, 'App\\User', 368),
(3, 'App\\User', 369),
(3, 'App\\User', 370),
(3, 'App\\User', 371),
(3, 'App\\User', 372),
(3, 'App\\User', 373),
(3, 'App\\User', 374),
(3, 'App\\User', 375),
(3, 'App\\User', 376),
(3, 'App\\User', 377),
(3, 'App\\User', 378),
(3, 'App\\User', 379),
(3, 'App\\User', 380),
(3, 'App\\User', 381),
(3, 'App\\User', 382),
(3, 'App\\User', 383),
(3, 'App\\User', 384),
(3, 'App\\User', 385),
(3, 'App\\User', 386),
(3, 'App\\User', 387),
(3, 'App\\User', 388),
(3, 'App\\User', 389),
(3, 'App\\User', 390),
(3, 'App\\User', 391),
(3, 'App\\User', 392),
(3, 'App\\User', 393),
(3, 'App\\User', 394),
(3, 'App\\User', 395),
(3, 'App\\User', 396),
(3, 'App\\User', 397),
(3, 'App\\User', 398),
(3, 'App\\User', 399),
(3, 'App\\User', 400),
(3, 'App\\User', 401),
(3, 'App\\User', 402),
(3, 'App\\User', 403),
(3, 'App\\User', 404),
(3, 'App\\User', 405),
(3, 'App\\User', 406),
(3, 'App\\User', 407),
(3, 'App\\User', 408),
(3, 'App\\User', 409),
(3, 'App\\User', 410),
(3, 'App\\User', 411),
(3, 'App\\User', 412),
(3, 'App\\User', 413),
(3, 'App\\User', 414),
(3, 'App\\User', 415),
(3, 'App\\User', 416),
(3, 'App\\User', 417),
(3, 'App\\User', 418),
(3, 'App\\User', 419),
(3, 'App\\User', 420),
(3, 'App\\User', 421),
(3, 'App\\User', 422),
(3, 'App\\User', 423),
(3, 'App\\User', 424),
(3, 'App\\User', 425),
(3, 'App\\User', 426),
(3, 'App\\User', 427),
(3, 'App\\User', 428),
(3, 'App\\User', 429),
(3, 'App\\User', 430),
(3, 'App\\User', 431),
(3, 'App\\User', 432),
(3, 'App\\User', 433),
(3, 'App\\User', 434),
(3, 'App\\User', 435),
(3, 'App\\User', 436),
(3, 'App\\User', 437),
(3, 'App\\User', 438),
(3, 'App\\User', 439),
(3, 'App\\User', 440),
(3, 'App\\User', 441),
(3, 'App\\User', 442),
(3, 'App\\User', 443),
(3, 'App\\User', 444),
(3, 'App\\User', 445),
(3, 'App\\User', 446),
(3, 'App\\User', 447),
(3, 'App\\User', 448),
(3, 'App\\User', 449),
(3, 'App\\User', 450),
(3, 'App\\User', 451),
(3, 'App\\User', 452),
(3, 'App\\User', 453),
(3, 'App\\User', 454),
(3, 'App\\User', 455),
(3, 'App\\User', 456),
(3, 'App\\User', 457),
(3, 'App\\User', 458),
(3, 'App\\User', 459),
(3, 'App\\User', 460),
(3, 'App\\User', 461),
(3, 'App\\User', 462),
(3, 'App\\User', 463),
(3, 'App\\User', 464),
(3, 'App\\User', 465),
(3, 'App\\User', 466),
(3, 'App\\User', 467),
(3, 'App\\User', 468),
(3, 'App\\User', 469),
(3, 'App\\User', 470),
(3, 'App\\User', 471),
(3, 'App\\User', 472),
(3, 'App\\User', 473),
(3, 'App\\User', 474),
(3, 'App\\User', 475),
(3, 'App\\User', 476),
(3, 'App\\User', 477),
(3, 'App\\User', 478),
(3, 'App\\User', 479),
(3, 'App\\User', 480),
(3, 'App\\User', 481),
(3, 'App\\User', 482),
(3, 'App\\User', 483),
(3, 'App\\User', 484),
(3, 'App\\User', 485),
(3, 'App\\User', 486),
(3, 'App\\User', 487),
(3, 'App\\User', 488),
(3, 'App\\User', 489),
(3, 'App\\User', 490),
(3, 'App\\User', 491),
(3, 'App\\User', 492),
(3, 'App\\User', 493),
(3, 'App\\User', 494),
(3, 'App\\User', 495),
(3, 'App\\User', 496),
(3, 'App\\User', 497),
(3, 'App\\User', 498),
(3, 'App\\User', 499),
(3, 'App\\User', 500),
(3, 'App\\User', 501),
(3, 'App\\User', 502),
(3, 'App\\User', 503),
(3, 'App\\User', 504),
(3, 'App\\User', 505),
(3, 'App\\User', 506),
(3, 'App\\User', 507),
(3, 'App\\User', 508),
(3, 'App\\User', 509),
(3, 'App\\User', 510),
(3, 'App\\User', 511),
(3, 'App\\User', 512),
(3, 'App\\User', 513),
(3, 'App\\User', 514),
(3, 'App\\User', 515),
(3, 'App\\User', 516),
(3, 'App\\User', 517),
(3, 'App\\User', 518),
(3, 'App\\User', 519),
(3, 'App\\User', 520),
(3, 'App\\User', 521),
(3, 'App\\User', 522),
(3, 'App\\User', 523),
(3, 'App\\User', 524),
(3, 'App\\User', 525),
(3, 'App\\User', 526),
(3, 'App\\User', 527),
(3, 'App\\User', 528),
(3, 'App\\User', 529),
(3, 'App\\User', 530),
(3, 'App\\User', 531),
(3, 'App\\User', 532),
(3, 'App\\User', 533),
(3, 'App\\User', 534),
(3, 'App\\User', 535),
(3, 'App\\User', 536),
(3, 'App\\User', 537),
(3, 'App\\User', 538),
(3, 'App\\User', 539),
(3, 'App\\User', 540),
(3, 'App\\User', 541),
(3, 'App\\User', 542),
(3, 'App\\User', 543),
(3, 'App\\User', 544),
(3, 'App\\User', 545),
(3, 'App\\User', 546),
(3, 'App\\User', 547),
(3, 'App\\User', 548),
(3, 'App\\User', 549),
(3, 'App\\User', 550),
(3, 'App\\User', 551),
(3, 'App\\User', 552),
(3, 'App\\User', 553),
(3, 'App\\User', 554),
(3, 'App\\User', 555),
(3, 'App\\User', 556),
(3, 'App\\User', 557),
(3, 'App\\User', 558),
(3, 'App\\User', 559),
(3, 'App\\User', 560),
(3, 'App\\User', 561),
(3, 'App\\User', 562),
(3, 'App\\User', 563),
(3, 'App\\User', 564),
(3, 'App\\User', 565),
(3, 'App\\User', 566),
(3, 'App\\User', 567),
(3, 'App\\User', 568),
(3, 'App\\User', 569),
(3, 'App\\User', 570),
(3, 'App\\User', 571),
(3, 'App\\User', 572),
(3, 'App\\User', 573),
(3, 'App\\User', 574),
(3, 'App\\User', 575),
(3, 'App\\User', 576),
(3, 'App\\User', 577),
(3, 'App\\User', 578),
(3, 'App\\User', 579),
(3, 'App\\User', 580),
(3, 'App\\User', 581),
(3, 'App\\User', 582),
(3, 'App\\User', 583),
(3, 'App\\User', 584),
(3, 'App\\User', 585),
(3, 'App\\User', 586),
(3, 'App\\User', 587),
(3, 'App\\User', 588),
(3, 'App\\User', 589),
(3, 'App\\User', 590),
(3, 'App\\User', 591),
(3, 'App\\User', 592),
(3, 'App\\User', 593),
(3, 'App\\User', 594),
(3, 'App\\User', 595),
(3, 'App\\User', 596),
(3, 'App\\User', 597),
(3, 'App\\User', 598),
(3, 'App\\User', 599),
(3, 'App\\User', 600),
(3, 'App\\User', 601),
(3, 'App\\User', 602),
(3, 'App\\User', 603),
(3, 'App\\User', 604),
(3, 'App\\User', 605),
(3, 'App\\User', 606),
(3, 'App\\User', 607),
(3, 'App\\User', 608),
(3, 'App\\User', 609),
(3, 'App\\User', 610),
(3, 'App\\User', 611),
(3, 'App\\User', 612),
(3, 'App\\User', 613),
(3, 'App\\User', 614),
(3, 'App\\User', 615),
(3, 'App\\User', 616),
(3, 'App\\User', 617),
(3, 'App\\User', 618),
(3, 'App\\User', 619),
(3, 'App\\User', 620),
(3, 'App\\User', 621),
(3, 'App\\User', 622),
(3, 'App\\User', 623),
(3, 'App\\User', 624),
(3, 'App\\User', 625),
(3, 'App\\User', 626),
(3, 'App\\User', 627),
(3, 'App\\User', 628),
(3, 'App\\User', 629),
(3, 'App\\User', 630),
(3, 'App\\User', 631),
(3, 'App\\User', 632),
(3, 'App\\User', 633),
(3, 'App\\User', 634),
(3, 'App\\User', 635),
(3, 'App\\User', 636),
(3, 'App\\User', 637),
(3, 'App\\User', 638),
(3, 'App\\User', 639),
(3, 'App\\User', 640),
(3, 'App\\User', 641),
(3, 'App\\User', 642),
(3, 'App\\User', 643),
(3, 'App\\User', 644),
(3, 'App\\User', 645),
(3, 'App\\User', 646),
(3, 'App\\User', 647),
(3, 'App\\User', 648),
(3, 'App\\User', 649),
(3, 'App\\User', 650),
(3, 'App\\User', 651),
(3, 'App\\User', 652),
(3, 'App\\User', 653),
(3, 'App\\User', 654),
(3, 'App\\User', 655),
(3, 'App\\User', 656),
(3, 'App\\User', 657),
(3, 'App\\User', 658),
(3, 'App\\User', 659),
(3, 'App\\User', 660),
(3, 'App\\User', 661),
(3, 'App\\User', 662),
(3, 'App\\User', 663),
(3, 'App\\User', 664),
(3, 'App\\User', 665),
(3, 'App\\User', 666),
(3, 'App\\User', 667),
(3, 'App\\User', 668),
(3, 'App\\User', 669),
(3, 'App\\User', 670),
(3, 'App\\User', 671),
(3, 'App\\User', 672),
(3, 'App\\User', 673),
(3, 'App\\User', 674),
(3, 'App\\User', 675),
(3, 'App\\User', 676),
(3, 'App\\User', 677),
(3, 'App\\User', 678),
(3, 'App\\User', 679),
(3, 'App\\User', 680),
(3, 'App\\User', 681),
(3, 'App\\User', 682),
(3, 'App\\User', 683),
(3, 'App\\User', 684),
(3, 'App\\User', 685),
(3, 'App\\User', 686),
(3, 'App\\User', 687),
(3, 'App\\User', 688),
(3, 'App\\User', 689),
(3, 'App\\User', 690),
(3, 'App\\User', 691),
(3, 'App\\User', 692),
(3, 'App\\User', 693),
(3, 'App\\User', 694),
(3, 'App\\User', 695),
(3, 'App\\User', 696),
(3, 'App\\User', 697),
(3, 'App\\User', 698),
(3, 'App\\User', 699),
(3, 'App\\User', 700),
(3, 'App\\User', 701),
(3, 'App\\User', 702),
(3, 'App\\User', 703),
(3, 'App\\User', 704),
(3, 'App\\User', 705),
(3, 'App\\User', 706),
(3, 'App\\User', 707),
(3, 'App\\User', 708),
(3, 'App\\User', 709),
(3, 'App\\User', 710),
(3, 'App\\User', 711),
(3, 'App\\User', 712),
(3, 'App\\User', 713),
(3, 'App\\User', 714),
(3, 'App\\User', 715),
(3, 'App\\User', 716),
(3, 'App\\User', 717),
(3, 'App\\User', 718),
(3, 'App\\User', 719),
(3, 'App\\User', 720),
(3, 'App\\User', 721),
(3, 'App\\User', 722),
(3, 'App\\User', 723),
(3, 'App\\User', 724),
(3, 'App\\User', 725),
(3, 'App\\User', 726),
(3, 'App\\User', 727),
(3, 'App\\User', 728),
(3, 'App\\User', 729),
(3, 'App\\User', 730),
(3, 'App\\User', 731),
(3, 'App\\User', 732),
(3, 'App\\User', 733),
(3, 'App\\User', 734),
(3, 'App\\User', 735),
(3, 'App\\User', 736),
(3, 'App\\User', 737),
(3, 'App\\User', 738),
(3, 'App\\User', 739),
(3, 'App\\User', 740),
(3, 'App\\User', 741),
(3, 'App\\User', 742),
(3, 'App\\User', 743),
(3, 'App\\User', 744),
(3, 'App\\User', 745),
(3, 'App\\User', 746),
(3, 'App\\User', 747),
(3, 'App\\User', 748),
(3, 'App\\User', 749),
(3, 'App\\User', 750),
(3, 'App\\User', 751),
(3, 'App\\User', 752),
(3, 'App\\User', 753),
(3, 'App\\User', 754),
(3, 'App\\User', 755),
(3, 'App\\User', 756),
(3, 'App\\User', 757),
(3, 'App\\User', 758),
(3, 'App\\User', 759),
(3, 'App\\User', 760),
(3, 'App\\User', 761),
(3, 'App\\User', 762),
(3, 'App\\User', 763),
(3, 'App\\User', 764),
(3, 'App\\User', 765),
(3, 'App\\User', 766),
(3, 'App\\User', 767),
(3, 'App\\User', 768),
(3, 'App\\User', 769),
(3, 'App\\User', 770),
(3, 'App\\User', 771),
(3, 'App\\User', 772),
(3, 'App\\User', 773),
(3, 'App\\User', 774),
(3, 'App\\User', 775),
(3, 'App\\User', 776),
(3, 'App\\User', 777),
(3, 'App\\User', 778),
(3, 'App\\User', 779),
(3, 'App\\User', 780),
(3, 'App\\User', 781),
(3, 'App\\User', 782),
(3, 'App\\User', 783),
(3, 'App\\User', 784),
(3, 'App\\User', 785),
(3, 'App\\User', 786),
(3, 'App\\User', 787),
(3, 'App\\User', 788),
(3, 'App\\User', 789),
(3, 'App\\User', 790),
(3, 'App\\User', 791),
(3, 'App\\User', 792),
(3, 'App\\User', 793),
(3, 'App\\User', 794),
(3, 'App\\User', 795),
(3, 'App\\User', 796),
(3, 'App\\User', 797),
(3, 'App\\User', 798),
(3, 'App\\User', 799),
(3, 'App\\User', 800),
(3, 'App\\User', 801),
(3, 'App\\User', 802),
(3, 'App\\User', 803),
(3, 'App\\User', 804),
(3, 'App\\User', 805),
(3, 'App\\User', 806),
(3, 'App\\User', 807),
(3, 'App\\User', 808),
(3, 'App\\User', 809),
(3, 'App\\User', 810),
(3, 'App\\User', 811),
(3, 'App\\User', 812),
(3, 'App\\User', 813),
(3, 'App\\User', 814),
(3, 'App\\User', 815),
(3, 'App\\User', 816),
(3, 'App\\User', 817),
(3, 'App\\User', 818),
(3, 'App\\User', 819),
(3, 'App\\User', 820),
(3, 'App\\User', 821),
(3, 'App\\User', 822),
(3, 'App\\User', 823),
(3, 'App\\User', 824),
(3, 'App\\User', 825),
(3, 'App\\User', 826),
(3, 'App\\User', 827),
(3, 'App\\User', 828),
(3, 'App\\User', 829),
(3, 'App\\User', 830),
(3, 'App\\User', 831),
(3, 'App\\User', 832),
(3, 'App\\User', 833),
(3, 'App\\User', 834),
(3, 'App\\User', 835),
(3, 'App\\User', 836),
(3, 'App\\User', 837),
(3, 'App\\User', 838),
(3, 'App\\User', 839),
(3, 'App\\User', 840),
(3, 'App\\User', 841),
(3, 'App\\User', 842),
(3, 'App\\User', 843),
(3, 'App\\User', 844),
(3, 'App\\User', 845),
(3, 'App\\User', 846),
(3, 'App\\User', 847),
(3, 'App\\User', 848),
(3, 'App\\User', 849),
(3, 'App\\User', 850),
(3, 'App\\User', 851),
(3, 'App\\User', 852),
(3, 'App\\User', 853),
(3, 'App\\User', 854),
(3, 'App\\User', 855),
(3, 'App\\User', 856),
(3, 'App\\User', 857),
(3, 'App\\User', 858),
(3, 'App\\User', 859),
(3, 'App\\User', 860),
(3, 'App\\User', 861),
(3, 'App\\User', 862),
(3, 'App\\User', 863),
(3, 'App\\User', 864),
(3, 'App\\User', 865),
(3, 'App\\User', 866),
(3, 'App\\User', 867),
(3, 'App\\User', 868),
(3, 'App\\User', 869),
(3, 'App\\User', 870),
(3, 'App\\User', 871),
(3, 'App\\User', 872),
(3, 'App\\User', 873),
(3, 'App\\User', 874),
(3, 'App\\User', 875),
(3, 'App\\User', 876),
(3, 'App\\User', 877),
(3, 'App\\User', 878),
(3, 'App\\User', 879),
(3, 'App\\User', 880),
(3, 'App\\User', 881),
(3, 'App\\User', 882),
(3, 'App\\User', 883),
(3, 'App\\User', 884),
(3, 'App\\User', 885),
(3, 'App\\User', 886),
(3, 'App\\User', 887),
(3, 'App\\User', 888),
(3, 'App\\User', 889),
(3, 'App\\User', 890),
(3, 'App\\User', 891),
(3, 'App\\User', 892),
(3, 'App\\User', 893),
(3, 'App\\User', 894),
(3, 'App\\User', 895),
(3, 'App\\User', 896),
(3, 'App\\User', 897),
(3, 'App\\User', 898),
(3, 'App\\User', 899),
(3, 'App\\User', 900),
(3, 'App\\User', 901),
(3, 'App\\User', 902),
(3, 'App\\User', 903),
(3, 'App\\User', 904),
(3, 'App\\User', 905),
(3, 'App\\User', 906),
(3, 'App\\User', 907),
(3, 'App\\User', 908),
(3, 'App\\User', 909),
(3, 'App\\User', 910),
(3, 'App\\User', 911),
(3, 'App\\User', 912),
(3, 'App\\User', 913),
(3, 'App\\User', 914),
(3, 'App\\User', 915),
(3, 'App\\User', 916),
(3, 'App\\User', 917),
(3, 'App\\User', 918),
(3, 'App\\User', 919),
(3, 'App\\User', 920),
(3, 'App\\User', 921),
(3, 'App\\User', 922),
(3, 'App\\User', 923),
(3, 'App\\User', 924),
(3, 'App\\User', 925),
(3, 'App\\User', 926),
(3, 'App\\User', 927),
(3, 'App\\User', 928),
(3, 'App\\User', 929),
(3, 'App\\User', 930),
(3, 'App\\User', 931),
(3, 'App\\User', 932),
(3, 'App\\User', 933),
(3, 'App\\User', 934),
(3, 'App\\User', 935),
(3, 'App\\User', 936),
(3, 'App\\User', 937),
(3, 'App\\User', 938),
(3, 'App\\User', 939),
(3, 'App\\User', 940),
(3, 'App\\User', 941),
(3, 'App\\User', 942),
(3, 'App\\User', 943),
(3, 'App\\User', 944),
(3, 'App\\User', 945),
(3, 'App\\User', 946),
(3, 'App\\User', 947),
(3, 'App\\User', 948),
(3, 'App\\User', 949),
(3, 'App\\User', 950),
(3, 'App\\User', 951),
(3, 'App\\User', 952),
(3, 'App\\User', 953),
(3, 'App\\User', 954),
(3, 'App\\User', 955),
(3, 'App\\User', 956),
(3, 'App\\User', 957),
(3, 'App\\User', 958),
(3, 'App\\User', 959),
(3, 'App\\User', 960),
(3, 'App\\User', 961),
(3, 'App\\User', 962),
(3, 'App\\User', 963),
(3, 'App\\User', 964),
(3, 'App\\User', 965),
(3, 'App\\User', 966),
(3, 'App\\User', 967),
(3, 'App\\User', 968),
(3, 'App\\User', 969),
(3, 'App\\User', 970),
(3, 'App\\User', 971),
(3, 'App\\User', 972),
(3, 'App\\User', 973),
(3, 'App\\User', 974),
(3, 'App\\User', 975),
(3, 'App\\User', 976),
(3, 'App\\User', 977),
(3, 'App\\User', 978),
(3, 'App\\User', 979),
(3, 'App\\User', 980),
(3, 'App\\User', 981),
(3, 'App\\User', 982),
(3, 'App\\User', 983),
(3, 'App\\User', 984),
(3, 'App\\User', 985),
(3, 'App\\User', 986),
(3, 'App\\User', 987),
(3, 'App\\User', 988),
(3, 'App\\User', 989),
(3, 'App\\User', 990),
(3, 'App\\User', 991),
(3, 'App\\User', 992),
(3, 'App\\User', 993),
(3, 'App\\User', 994),
(3, 'App\\User', 995),
(3, 'App\\User', 996),
(3, 'App\\User', 997),
(3, 'App\\User', 998),
(3, 'App\\User', 999),
(3, 'App\\User', 1000),
(3, 'App\\User', 1001),
(3, 'App\\User', 1002),
(3, 'App\\User', 1003),
(3, 'App\\User', 1004),
(3, 'App\\User', 1005),
(3, 'App\\User', 1006),
(3, 'App\\User', 1007),
(3, 'App\\User', 1008),
(3, 'App\\User', 1009),
(3, 'App\\User', 1010),
(3, 'App\\User', 1011),
(3, 'App\\User', 1012),
(3, 'App\\User', 1013),
(3, 'App\\User', 1014),
(3, 'App\\User', 1015),
(3, 'App\\User', 1016),
(3, 'App\\User', 1017),
(3, 'App\\User', 1018),
(3, 'App\\User', 1019),
(3, 'App\\User', 1020),
(3, 'App\\User', 1021),
(3, 'App\\User', 1022),
(3, 'App\\User', 1023),
(3, 'App\\User', 1024),
(3, 'App\\User', 1025),
(3, 'App\\User', 1026),
(3, 'App\\User', 1027),
(3, 'App\\User', 1028),
(3, 'App\\User', 1029),
(3, 'App\\User', 1030),
(3, 'App\\User', 1031),
(3, 'App\\User', 1032),
(3, 'App\\User', 1033),
(3, 'App\\User', 1034),
(3, 'App\\User', 1035),
(3, 'App\\User', 1036),
(3, 'App\\User', 1037),
(3, 'App\\User', 1038),
(3, 'App\\User', 1039),
(3, 'App\\User', 1040),
(3, 'App\\User', 1041),
(3, 'App\\User', 1042),
(3, 'App\\User', 1043),
(3, 'App\\User', 1044),
(3, 'App\\User', 1045),
(3, 'App\\User', 1046),
(3, 'App\\User', 1047),
(3, 'App\\User', 1048),
(3, 'App\\User', 1049),
(3, 'App\\User', 1050),
(3, 'App\\User', 1051),
(3, 'App\\User', 1052),
(3, 'App\\User', 1053),
(3, 'App\\User', 1054),
(3, 'App\\User', 1055),
(3, 'App\\User', 1056),
(3, 'App\\User', 1057),
(3, 'App\\User', 1058),
(3, 'App\\User', 1059),
(3, 'App\\User', 1060),
(3, 'App\\User', 1061),
(3, 'App\\User', 1062),
(3, 'App\\User', 1063),
(3, 'App\\User', 1064),
(3, 'App\\User', 1065),
(3, 'App\\User', 1066),
(3, 'App\\User', 1067),
(3, 'App\\User', 1068),
(3, 'App\\User', 1069),
(3, 'App\\User', 1070),
(3, 'App\\User', 1071),
(3, 'App\\User', 1072),
(3, 'App\\User', 1073),
(3, 'App\\User', 1074),
(3, 'App\\User', 1075),
(3, 'App\\User', 1076),
(3, 'App\\User', 1077),
(3, 'App\\User', 1078),
(3, 'App\\User', 1079),
(3, 'App\\User', 1080),
(3, 'App\\User', 1081),
(3, 'App\\User', 1082),
(3, 'App\\User', 1083),
(3, 'App\\User', 1084),
(3, 'App\\User', 1085),
(3, 'App\\User', 1086),
(3, 'App\\User', 1087),
(3, 'App\\User', 1088),
(3, 'App\\User', 1089),
(3, 'App\\User', 1090),
(3, 'App\\User', 1091),
(3, 'App\\User', 1092),
(3, 'App\\User', 1093),
(3, 'App\\User', 1094),
(3, 'App\\User', 1095),
(3, 'App\\User', 1096),
(3, 'App\\User', 1097),
(3, 'App\\User', 1098),
(3, 'App\\User', 1099),
(3, 'App\\User', 1100),
(3, 'App\\User', 1101),
(3, 'App\\User', 1102),
(3, 'App\\User', 1103),
(3, 'App\\User', 1104),
(3, 'App\\User', 1105),
(3, 'App\\User', 1106),
(3, 'App\\User', 1107),
(3, 'App\\User', 1108),
(3, 'App\\User', 1109),
(3, 'App\\User', 1110),
(3, 'App\\User', 1111),
(3, 'App\\User', 1112),
(3, 'App\\User', 1113),
(3, 'App\\User', 1114),
(3, 'App\\User', 1115),
(3, 'App\\User', 1116),
(3, 'App\\User', 1117),
(3, 'App\\User', 1118),
(3, 'App\\User', 1119),
(3, 'App\\User', 1120);

-- --------------------------------------------------------

--
-- Struktur dari tabel `other_payments`
--

CREATE TABLE `other_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `overtimes`
--

CREATE TABLE `overtimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_days` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `paid_leave`
--

CREATE TABLE `paid_leave` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(100) NOT NULL,
  `type_leave` varchar(100) NOT NULL,
  `remark` text NOT NULL DEFAULT '-',
  `start_at` date NOT NULL,
  `end_at` date NOT NULL,
  `approval_check` int(3) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `paid_leave`
--

INSERT INTO `paid_leave` (`id`, `employee_id`, `type_leave`, `remark`, `start_at`, `end_at`, `approval_check`, `created_at`, `updated_at`) VALUES
(1, '188', 'IZIN', 'izin pulang kampung', '2021-08-09', '2021-08-16', 1, '2021-08-09 09:15:07', '2021-08-09 09:15:07'),
(2, '188', 'cuti', 'ambil cuti', '2021-08-13', '2021-08-16', 2, '2021-08-13 10:05:21', '2021-08-13 10:05:21'),
(3, '188', 'fdasfsd', 'fasdfsad', '2021-08-10', '2021-08-20', 2, '2021-08-13 10:06:16', '2021-08-13 10:06:16'),
(4, '188', 'fadadsfas', 'fdadas', '2021-08-28', '2021-08-18', 1, '2021-08-13 10:13:30', '2021-08-13 10:13:30'),
(5, '188', 'fdasfas', 'fsadfasd', '2021-08-06', '2021-08-13', 2, '2021-08-13 10:17:33', '2021-08-13 10:17:33'),
(6, '188', 'dsafas', 'fasdfas', '2021-08-10', '2021-09-03', 2, '2021-08-13 12:02:49', '2021-08-13 12:02:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payees`
--

CREATE TABLE `payees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payee_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payers`
--

CREATE TABLE `payers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_types`
--

CREATE TABLE `payment_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payment_types`
--

INSERT INTO `payment_types` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Cash', 1, '2020-05-07 23:19:09', '2020-05-07 23:19:09'),
(2, 'Transfer', 1, '2020-05-07 23:19:20', '2020-05-07 23:19:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payslip_types`
--

CREATE TABLE `payslip_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payslip_types`
--

INSERT INTO `payslip_types` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Harian', 1, '2020-05-07 23:14:46', '2020-05-07 23:14:46'),
(2, 'Mingguan', 1, '2020-05-07 23:14:51', '2020-05-07 23:14:51'),
(3, 'Bulanan', 1, '2020-05-07 23:14:56', '2020-05-07 23:14:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pay_slips`
--

CREATE TABLE `pay_slips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `net_payble` int(11) DEFAULT NULL,
  `salary_month` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `basic_salary` int(11) DEFAULT NULL,
  `allowance` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saturation_deduction` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_payment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `overtime` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pay_slips`
--

INSERT INTO `pay_slips` (`id`, `employee_id`, `net_payble`, `salary_month`, `status`, `basic_salary`, `allowance`, `commission`, `loan`, `saturation_deduction`, `other_payment`, `overtime`, `created_by`, `created_at`, `updated_at`) VALUES
(139, 183, 700000, '2021-01', 1, 700000, '[]', '-', '-', '[]', '-', '-', 1, '2021-08-16 07:53:50', '2021-08-16 07:54:02'),
(140, 186, 7986000, '2021-01', 1, 8000000, '[{\"id\":13,\"employee_id\":186,\"allowance_option\":4,\"title\":\"-\",\"amount\":10000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:00.000000Z\",\"updated_at\":\"2021-08-12T11:03:00.000000Z\"},{\"id\":14,\"employee_id\":186,\"allowance_option\":5,\"title\":\"-\",\"amount\":17000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:12.000000Z\",\"updated_at\":\"2021-08-12T11:03:12.000000Z\"},{\"id\":15,\"employee_id\":186,\"allowance_option\":6,\"title\":\"-\",\"amount\":5000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:20.000000Z\",\"updated_at\":\"2021-08-12T11:03:20.000000Z\"}]', '-', '-', '[{\"id\":12,\"employee_id\":186,\"deduction_option\":3,\"title\":\"-\",\"amount\":20000,\"created_by\":1,\"created_at\":\"2021-08-12T11:02:44.000000Z\",\"updated_at\":\"2021-08-12T11:02:44.000000Z\"},{\"id\":13,\"employee_id\":186,\"deduction_option\":4,\"title\":\"-\",\"amount\":12000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:33.000000Z\",\"updated_at\":\"2021-08-12T11:03:33.000000Z\"},{\"id\":14,\"employee_id\":186,\"deduction_option\":5,\"title\":\"-\",\"amount\":14000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:41.000000Z\",\"updated_at\":\"2021-08-12T11:03:41.000000Z\"}]', '-', '-', 1, '2021-08-16 07:53:50', '2021-08-16 07:54:02'),
(141, 188, 5432800, '2021-01', 1, 5500000, '[{\"id\":7,\"employee_id\":188,\"allowance_option\":4,\"title\":\"\",\"amount\":500000,\"created_by\":1,\"created_at\":\"2021-05-21T02:37:50.000000Z\",\"updated_at\":\"2021-05-21T02:37:50.000000Z\"},{\"id\":8,\"employee_id\":188,\"allowance_option\":4,\"title\":\"\",\"amount\":500000,\"created_by\":1,\"created_at\":\"2021-05-21T02:38:54.000000Z\",\"updated_at\":\"2021-05-21T02:38:54.000000Z\"},{\"id\":11,\"employee_id\":188,\"allowance_option\":7,\"title\":\"-\",\"amount\":45000,\"created_by\":1,\"created_at\":\"2021-08-09T03:11:47.000000Z\",\"updated_at\":\"2021-08-09T03:11:47.000000Z\"},{\"id\":12,\"employee_id\":188,\"allowance_option\":6,\"title\":\"-\",\"amount\":15000,\"created_by\":1,\"created_at\":\"2021-08-12T07:01:14.000000Z\",\"updated_at\":\"2021-08-12T07:01:14.000000Z\"}]', '-', '-', '[{\"id\":9,\"employee_id\":188,\"deduction_option\":4,\"title\":\"-\",\"amount\":1200,\"created_by\":1,\"created_at\":\"2021-08-09T06:30:02.000000Z\",\"updated_at\":\"2021-08-09T06:30:02.000000Z\"},{\"id\":10,\"employee_id\":188,\"deduction_option\":5,\"title\":\"-\",\"amount\":24000,\"created_by\":1,\"created_at\":\"2021-08-09T06:30:21.000000Z\",\"updated_at\":\"2021-08-09T06:30:21.000000Z\"},{\"id\":11,\"employee_id\":188,\"deduction_option\":6,\"title\":\"-\",\"amount\":2000,\"created_by\":1,\"created_at\":\"2021-08-12T07:01:30.000000Z\",\"updated_at\":\"2021-08-12T07:01:30.000000Z\"}]', '-', '-', 1, '2021-08-16 07:53:50', '2021-08-16 07:54:02'),
(142, 183, 700000, '2021-02', 1, 700000, '[]', '-', '-', '[]', '-', '-', 1, '2021-08-16 07:56:29', '2021-08-16 07:56:50'),
(143, 186, 7986000, '2021-02', 1, 8000000, '[{\"id\":13,\"employee_id\":186,\"allowance_option\":4,\"title\":\"-\",\"amount\":10000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:00.000000Z\",\"updated_at\":\"2021-08-12T11:03:00.000000Z\"},{\"id\":14,\"employee_id\":186,\"allowance_option\":5,\"title\":\"-\",\"amount\":17000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:12.000000Z\",\"updated_at\":\"2021-08-12T11:03:12.000000Z\"},{\"id\":15,\"employee_id\":186,\"allowance_option\":6,\"title\":\"-\",\"amount\":5000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:20.000000Z\",\"updated_at\":\"2021-08-12T11:03:20.000000Z\"}]', '-', '-', '[{\"id\":12,\"employee_id\":186,\"deduction_option\":3,\"title\":\"-\",\"amount\":20000,\"created_by\":1,\"created_at\":\"2021-08-12T11:02:44.000000Z\",\"updated_at\":\"2021-08-12T11:02:44.000000Z\"},{\"id\":13,\"employee_id\":186,\"deduction_option\":4,\"title\":\"-\",\"amount\":12000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:33.000000Z\",\"updated_at\":\"2021-08-12T11:03:33.000000Z\"},{\"id\":14,\"employee_id\":186,\"deduction_option\":5,\"title\":\"-\",\"amount\":14000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:41.000000Z\",\"updated_at\":\"2021-08-12T11:03:41.000000Z\"}]', '-', '-', 1, '2021-08-16 07:56:29', '2021-08-16 07:56:50'),
(144, 188, 5432800, '2021-02', 1, 5500000, '[{\"id\":7,\"employee_id\":188,\"allowance_option\":4,\"title\":\"\",\"amount\":500000,\"created_by\":1,\"created_at\":\"2021-05-21T02:37:50.000000Z\",\"updated_at\":\"2021-05-21T02:37:50.000000Z\"},{\"id\":8,\"employee_id\":188,\"allowance_option\":4,\"title\":\"\",\"amount\":500000,\"created_by\":1,\"created_at\":\"2021-05-21T02:38:54.000000Z\",\"updated_at\":\"2021-05-21T02:38:54.000000Z\"},{\"id\":11,\"employee_id\":188,\"allowance_option\":7,\"title\":\"-\",\"amount\":45000,\"created_by\":1,\"created_at\":\"2021-08-09T03:11:47.000000Z\",\"updated_at\":\"2021-08-09T03:11:47.000000Z\"},{\"id\":12,\"employee_id\":188,\"allowance_option\":6,\"title\":\"-\",\"amount\":15000,\"created_by\":1,\"created_at\":\"2021-08-12T07:01:14.000000Z\",\"updated_at\":\"2021-08-12T07:01:14.000000Z\"}]', '-', '-', '[{\"id\":9,\"employee_id\":188,\"deduction_option\":4,\"title\":\"-\",\"amount\":1200,\"created_by\":1,\"created_at\":\"2021-08-09T06:30:02.000000Z\",\"updated_at\":\"2021-08-09T06:30:02.000000Z\"},{\"id\":10,\"employee_id\":188,\"deduction_option\":5,\"title\":\"-\",\"amount\":24000,\"created_by\":1,\"created_at\":\"2021-08-09T06:30:21.000000Z\",\"updated_at\":\"2021-08-09T06:30:21.000000Z\"},{\"id\":11,\"employee_id\":188,\"deduction_option\":6,\"title\":\"-\",\"amount\":2000,\"created_by\":1,\"created_at\":\"2021-08-12T07:01:30.000000Z\",\"updated_at\":\"2021-08-12T07:01:30.000000Z\"}]', '-', '-', 1, '2021-08-16 07:56:29', '2021-08-16 07:56:50'),
(148, 183, 700000, '2021-03', 1, 700000, '[]', '-', '-', '[]', '-', '-', 1, '2021-08-16 09:44:46', '2021-08-16 09:45:11'),
(149, 186, 7986000, '2021-03', 1, 8000000, '[{\"id\":13,\"employee_id\":186,\"allowance_option\":4,\"title\":\"-\",\"amount\":10000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:00.000000Z\",\"updated_at\":\"2021-08-12T11:03:00.000000Z\"},{\"id\":14,\"employee_id\":186,\"allowance_option\":5,\"title\":\"-\",\"amount\":17000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:12.000000Z\",\"updated_at\":\"2021-08-12T11:03:12.000000Z\"},{\"id\":15,\"employee_id\":186,\"allowance_option\":6,\"title\":\"-\",\"amount\":5000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:20.000000Z\",\"updated_at\":\"2021-08-12T11:03:20.000000Z\"}]', '-', '-', '[{\"id\":12,\"employee_id\":186,\"deduction_option\":3,\"title\":\"-\",\"amount\":20000,\"created_by\":1,\"created_at\":\"2021-08-12T11:02:44.000000Z\",\"updated_at\":\"2021-08-12T11:02:44.000000Z\"},{\"id\":13,\"employee_id\":186,\"deduction_option\":4,\"title\":\"-\",\"amount\":12000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:33.000000Z\",\"updated_at\":\"2021-08-12T11:03:33.000000Z\"},{\"id\":14,\"employee_id\":186,\"deduction_option\":5,\"title\":\"-\",\"amount\":14000,\"created_by\":1,\"created_at\":\"2021-08-12T11:03:41.000000Z\",\"updated_at\":\"2021-08-12T11:03:41.000000Z\"}]', '-', '-', 1, '2021-08-16 09:44:46', '2021-08-16 09:45:11'),
(150, 188, 6532800, '2021-03', 1, 5500000, '[{\"id\":7,\"employee_id\":188,\"allowance_option\":4,\"title\":\"\",\"amount\":500000,\"created_by\":1,\"created_at\":\"2021-05-21T02:37:50.000000Z\",\"updated_at\":\"2021-05-21T02:37:50.000000Z\"},{\"id\":8,\"employee_id\":188,\"allowance_option\":4,\"title\":\"\",\"amount\":500000,\"created_by\":1,\"created_at\":\"2021-05-21T02:38:54.000000Z\",\"updated_at\":\"2021-05-21T02:38:54.000000Z\"},{\"id\":11,\"employee_id\":188,\"allowance_option\":7,\"title\":\"-\",\"amount\":45000,\"created_by\":1,\"created_at\":\"2021-08-09T03:11:47.000000Z\",\"updated_at\":\"2021-08-09T03:11:47.000000Z\"},{\"id\":12,\"employee_id\":188,\"allowance_option\":6,\"title\":\"-\",\"amount\":15000,\"created_by\":1,\"created_at\":\"2021-08-12T07:01:14.000000Z\",\"updated_at\":\"2021-08-12T07:01:14.000000Z\"}]', '-', '-', '[{\"id\":9,\"employee_id\":188,\"deduction_option\":4,\"title\":\"-\",\"amount\":1200,\"created_by\":1,\"created_at\":\"2021-08-09T06:30:02.000000Z\",\"updated_at\":\"2021-08-09T06:30:02.000000Z\"},{\"id\":10,\"employee_id\":188,\"deduction_option\":5,\"title\":\"-\",\"amount\":24000,\"created_by\":1,\"created_at\":\"2021-08-09T06:30:21.000000Z\",\"updated_at\":\"2021-08-09T06:30:21.000000Z\"},{\"id\":11,\"employee_id\":188,\"deduction_option\":6,\"title\":\"-\",\"amount\":2000,\"created_by\":1,\"created_at\":\"2021-08-12T07:01:30.000000Z\",\"updated_at\":\"2021-08-12T07:01:30.000000Z\"}]', '-', '-', 1, '2021-08-16 09:44:46', '2021-08-16 09:45:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Manage User', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(2, 'Create User', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(3, 'Edit User', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(4, 'Delete User', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(5, 'Manage Role', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(6, 'Create Role', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(7, 'Delete Role', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(8, 'Edit Role', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(9, 'Manage Award', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(10, 'Create Award', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(11, 'Delete Award', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(12, 'Edit Award', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(13, 'Manage Transfer', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(14, 'Create Transfer', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(15, 'Delete Transfer', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(16, 'Edit Transfer', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(17, 'Manage Resignation', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(18, 'Create Resignation', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(19, 'Edit Resignation', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(20, 'Delete Resignation', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(21, 'Manage Travel', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(22, 'Create Travel', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(23, 'Edit Travel', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(24, 'Delete Travel', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(25, 'Manage Promotion', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(26, 'Create Promotion', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(27, 'Edit Promotion', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(28, 'Delete Promotion', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(29, 'Manage Complaint', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(30, 'Create Complaint', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(31, 'Edit Complaint', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(32, 'Delete Complaint', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(33, 'Manage Warning', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(34, 'Create Warning', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(35, 'Edit Warning', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(36, 'Delete Warning', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(37, 'Manage Termination', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(38, 'Create Termination', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(39, 'Edit Termination', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(40, 'Delete Termination', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(41, 'Manage Department', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(42, 'Create Department', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(43, 'Edit Department', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(44, 'Delete Department', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(45, 'Manage Designation', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(46, 'Create Designation', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(47, 'Edit Designation', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(48, 'Delete Designation', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(49, 'Manage Document Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(50, 'Create Document Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(51, 'Edit Document Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(52, 'Delete Document Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(53, 'Manage Branch', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(54, 'Create Branch', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(55, 'Edit Branch', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(56, 'Delete Branch', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(57, 'Manage Award Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(58, 'Create Award Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(59, 'Edit Award Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(60, 'Delete Award Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(61, 'Manage Termination Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(62, 'Create Termination Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(63, 'Edit Termination Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(64, 'Delete Termination Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(65, 'Manage Employee', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(66, 'Create Employee', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(67, 'Edit Employee', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(68, 'Delete Employee', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(69, 'Manage Payslip Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(70, 'Create Payslip Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(71, 'Edit Payslip Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(72, 'Delete Payslip Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(73, 'Manage Allowance Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(74, 'Create Allowance Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(75, 'Edit Allowance Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(76, 'Delete Allowance Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(77, 'Manage Loan Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(78, 'Create Loan Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(79, 'Edit Loan Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(80, 'Delete Loan Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(81, 'Manage Deduction Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(82, 'Create Deduction Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(83, 'Edit Deduction Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(84, 'Delete Deduction Option', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(85, 'Manage Set Salary', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(86, 'Create Set Salary', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(87, 'Edit Set Salary', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(88, 'Delete Set Salary', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(89, 'Manage Allowances', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(90, 'Create Allowance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(91, 'Edit Allowance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(92, 'Delete Allowance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(93, 'Create Commission', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(94, 'Create Loan', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(95, 'Create Saturation Deduction', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(96, 'Create Other Payment', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(97, 'Create Overtime', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(98, 'Edit Commission', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(99, 'Delete Commission', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(100, 'Edit Loan', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(101, 'Delete Loan', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(102, 'Edit Saturation Deduction', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(103, 'Delete Saturation Deduction', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(104, 'Edit Other Payment', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(105, 'Delete Other Payment', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(106, 'Edit Overtime', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(107, 'Delete Overtime', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(108, 'Manage Pay Slip', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(109, 'Create Pay Slip', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(110, 'Edit Pay Slip', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(111, 'Delete Pay Slip', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(112, 'Manage Account List', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(113, 'Create Account List', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(114, 'Edit Account List', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(115, 'Delete Account List', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(116, 'View Balance Account List', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(117, 'Manage Payee', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(118, 'Create Payee', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(119, 'Edit Payee', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(120, 'Delete Payee', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(121, 'Manage Payer', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(122, 'Create Payer', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(123, 'Edit Payer', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(124, 'Delete Payer', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(125, 'Manage Expense Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(126, 'Create Expense Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(127, 'Edit Expense Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(128, 'Delete Expense Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(129, 'Manage Income Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(130, 'Edit Income Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(131, 'Delete Income Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(132, 'Create Income Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(133, 'Manage Payment Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(134, 'Create Payment Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(135, 'Edit Payment Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(136, 'Delete Payment Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(137, 'Manage Deposit', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(138, 'Create Deposit', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(139, 'Edit Deposit', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(140, 'Delete Deposit', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(141, 'Manage Expense', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(142, 'Create Expense', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(143, 'Edit Expense', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(144, 'Delete Expense', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(145, 'Manage Transfer Balance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(146, 'Create Transfer Balance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(147, 'Edit Transfer Balance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(148, 'Delete Transfer Balance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(149, 'Manage Event', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(150, 'Create Event', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(151, 'Edit Event', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(152, 'Delete Event', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(153, 'Manage Announcement', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(154, 'Create Announcement', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(155, 'Edit Announcement', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(156, 'Delete Announcement', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(157, 'Manage Leave Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(158, 'Create Leave Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(159, 'Edit Leave Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(160, 'Delete Leave Type', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(161, 'Manage Leave', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(162, 'Create Leave', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(163, 'Edit Leave', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(164, 'Delete Leave', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(165, 'Manage Meeting', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(166, 'Create Meeting', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(167, 'Edit Meeting', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(168, 'Delete Meeting', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(169, 'Manage Ticket', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(170, 'Create Ticket', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(171, 'Edit Ticket', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(172, 'Delete Ticket', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(173, 'Manage Attendance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(174, 'Create Attendance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(175, 'Edit Attendance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(176, 'Delete Attendance', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(177, 'Manage Language', 'web', '2020-05-07 22:43:40', '2020-05-07 22:43:40'),
(178, 'Create Language', 'web', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(179, 'Manage System Settings', 'web', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(180, 'Manage Company Settings', 'web', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(181, 'Manage Profile', 'web', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(182, 'Update Profile', 'web', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(183, 'Change Password', 'web', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(184, 'Manage TimeSheet', 'web', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(185, 'Create TimeSheet', 'web', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(186, 'Edit TimeSheet', 'web', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(187, 'Delete TimeSheet', 'web', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(188, 'Manage Contract', 'web', '2021-05-28 10:33:19', '2021-05-28 10:33:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `promotion_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promotion_date` date NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `resignations`
--

CREATE TABLE `resignations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `notice_date` date NOT NULL,
  `resignation_date` date NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'company', 'web', '0', '2020-05-07 22:43:41', '2020-05-07 22:43:41'),
(2, 'hr', 'web', '1', '2020-05-07 22:43:43', '2020-05-07 22:43:43'),
(3, 'employee', 'web', '1', '2020-05-07 22:43:45', '2020-05-07 22:43:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(9, 2),
(9, 3),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(13, 3),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(17, 2),
(17, 3),
(18, 1),
(18, 2),
(18, 3),
(19, 1),
(19, 2),
(19, 3),
(20, 1),
(20, 2),
(20, 3),
(21, 1),
(21, 2),
(21, 3),
(22, 1),
(22, 2),
(23, 1),
(23, 2),
(24, 1),
(24, 2),
(25, 1),
(25, 2),
(25, 3),
(26, 1),
(26, 2),
(27, 1),
(27, 2),
(28, 1),
(28, 2),
(29, 1),
(29, 2),
(29, 3),
(30, 1),
(30, 2),
(30, 3),
(31, 1),
(31, 2),
(31, 3),
(32, 1),
(32, 2),
(32, 3),
(33, 1),
(33, 2),
(33, 3),
(34, 1),
(34, 2),
(34, 3),
(35, 1),
(35, 2),
(35, 3),
(36, 1),
(36, 2),
(36, 3),
(37, 1),
(37, 2),
(37, 3),
(38, 1),
(38, 2),
(39, 1),
(39, 2),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(42, 2),
(43, 1),
(43, 2),
(44, 1),
(44, 2),
(45, 1),
(45, 2),
(46, 1),
(46, 2),
(47, 1),
(47, 2),
(48, 1),
(48, 2),
(49, 1),
(49, 2),
(50, 1),
(50, 2),
(51, 1),
(51, 2),
(52, 1),
(52, 2),
(53, 1),
(53, 2),
(54, 1),
(54, 2),
(55, 1),
(55, 2),
(56, 1),
(56, 2),
(57, 1),
(57, 2),
(58, 1),
(58, 2),
(59, 1),
(59, 2),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(62, 2),
(63, 1),
(63, 2),
(64, 1),
(64, 2),
(65, 1),
(65, 2),
(65, 3),
(66, 1),
(66, 2),
(67, 1),
(67, 2),
(68, 1),
(68, 2),
(69, 1),
(69, 2),
(70, 1),
(70, 2),
(71, 1),
(71, 2),
(72, 1),
(72, 2),
(73, 1),
(73, 2),
(74, 1),
(74, 2),
(75, 1),
(75, 2),
(76, 1),
(76, 2),
(77, 1),
(77, 2),
(78, 1),
(78, 2),
(79, 1),
(79, 2),
(80, 1),
(80, 2),
(81, 1),
(81, 2),
(82, 1),
(82, 2),
(83, 1),
(83, 2),
(84, 1),
(84, 2),
(85, 1),
(85, 2),
(86, 1),
(86, 2),
(87, 1),
(87, 2),
(88, 1),
(88, 2),
(89, 1),
(90, 1),
(90, 2),
(91, 1),
(91, 2),
(92, 1),
(92, 2),
(93, 1),
(93, 2),
(94, 1),
(94, 2),
(95, 1),
(95, 2),
(96, 1),
(96, 2),
(97, 1),
(97, 2),
(98, 1),
(98, 2),
(99, 1),
(99, 2),
(100, 1),
(100, 2),
(101, 1),
(101, 2),
(102, 1),
(102, 2),
(103, 1),
(103, 2),
(104, 1),
(104, 2),
(105, 1),
(105, 2),
(106, 1),
(106, 2),
(107, 1),
(107, 2),
(108, 1),
(108, 2),
(109, 1),
(109, 2),
(110, 1),
(110, 2),
(111, 1),
(111, 2),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(149, 2),
(149, 3),
(150, 1),
(150, 2),
(151, 1),
(151, 2),
(152, 1),
(152, 2),
(153, 1),
(153, 2),
(153, 3),
(154, 1),
(154, 2),
(155, 1),
(155, 2),
(156, 1),
(156, 2),
(157, 1),
(157, 2),
(158, 1),
(158, 2),
(159, 1),
(159, 2),
(160, 1),
(160, 2),
(161, 1),
(161, 2),
(161, 3),
(162, 1),
(162, 2),
(162, 3),
(163, 1),
(163, 2),
(163, 3),
(164, 1),
(164, 2),
(164, 3),
(165, 1),
(165, 2),
(165, 3),
(166, 1),
(166, 2),
(167, 1),
(167, 2),
(168, 1),
(168, 2),
(169, 1),
(169, 2),
(169, 3),
(170, 1),
(170, 2),
(170, 3),
(171, 1),
(171, 2),
(171, 3),
(172, 1),
(172, 2),
(172, 3),
(173, 1),
(173, 2),
(173, 3),
(174, 1),
(174, 2),
(175, 1),
(175, 2),
(176, 1),
(176, 2),
(177, 1),
(177, 2),
(179, 1),
(180, 1),
(181, 1),
(181, 2),
(181, 3),
(182, 1),
(182, 2),
(182, 3),
(183, 1),
(183, 2),
(183, 3),
(184, 1),
(184, 2),
(184, 3),
(185, 1),
(185, 2),
(185, 3),
(186, 1),
(186, 2),
(186, 3),
(187, 1),
(187, 2),
(187, 3),
(188, 1),
(188, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `saturation_deductions`
--

CREATE TABLE `saturation_deductions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `deduction_option` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `saturation_deductions`
--

INSERT INTO `saturation_deductions` (`id`, `employee_id`, `deduction_option`, `title`, `amount`, `created_by`, `created_at`, `updated_at`) VALUES
(9, 188, 4, '-', 1200, 1, '2021-08-09 06:30:02', '2021-08-09 06:30:02'),
(10, 188, 5, '-', 24000, 1, '2021-08-09 06:30:21', '2021-08-09 06:30:21'),
(11, 188, 6, '-', 2000, 1, '2021-08-12 07:01:30', '2021-08-12 07:01:30'),
(12, 186, 3, '-', 20000, 1, '2021-08-12 11:02:44', '2021-08-12 11:02:44'),
(13, 186, 4, '-', 12000, 1, '2021-08-12 11:03:33', '2021-08-12 11:03:33'),
(14, 186, 5, '-', 14000, 1, '2021-08-12 11:03:41', '2021-08-12 11:03:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'company_name', 'PT Dua Sisi Sejahtera', 1, NULL, NULL),
(2, 'company_address', 'Jl Lapangan Bola No. 9C', 1, NULL, NULL),
(3, 'company_city', 'Jakarta Barat', 1, NULL, NULL),
(4, 'company_state', 'DKI Jakarta', 1, NULL, NULL),
(5, 'company_zipcode', '11520', 1, NULL, NULL),
(6, 'company_country', 'Indonesia', 1, NULL, NULL),
(7, 'company_telephone', '081327924475', 1, NULL, NULL),
(8, 'company_email', 'payroll@duasisi.id', 1, NULL, NULL),
(9, 'company_email_from_name', 'Payroll Duasisi', 1, NULL, NULL),
(10, 'company_start_time', '9:00', 1, NULL, NULL),
(11, 'company_end_time', '19:00', 1, NULL, NULL),
(12, 'site_currency', 'IDR', 1, '2020-05-07 22:49:27', '2020-05-07 22:49:27'),
(13, 'site_currency_symbol', 'IDR', 1, '2020-05-07 22:49:27', '2020-05-07 22:49:27'),
(14, 'site_currency_symbol_position', 'pre', 1, '2020-05-07 22:49:27', '2020-05-07 22:49:27'),
(15, 'site_date_format', 'd-m-Y', 1, '2020-05-07 22:49:27', '2020-05-07 22:49:27'),
(16, 'site_time_format', 'g:i A', 1, '2020-05-07 22:49:27', '2020-05-07 22:49:27'),
(17, 'employee_prefix', '#CG00', 1, '2020-05-07 22:49:27', '2020-05-07 22:49:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `set_salaries`
--

CREATE TABLE `set_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tab`
--

CREATE TABLE `tab` (
  `id` int(6) NOT NULL,
  `tab` int(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tab`
--

INSERT INTO `tab` (`id`, `tab`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-06-27 05:35:56', '2021-06-26 22:35:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `terminations`
--

CREATE TABLE `terminations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `notice_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `termination_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `termination_types`
--

CREATE TABLE `termination_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` int(11) NOT NULL,
  `priority` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `time_sheets`
--

CREATE TABLE `time_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `hours` double(8,2) NOT NULL DEFAULT 0.00,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `time_sheets`
--

INSERT INTO `time_sheets` (`id`, `employee_id`, `date`, `hours`, `remark`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 3, '2021-04-09', 20.00, 'tes', 1, '2021-04-09 00:52:04', '2021-04-09 00:52:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transfer_balances`
--

CREATE TABLE `transfer_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_account_id` int(11) NOT NULL,
  `to_account_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `referal_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `travel`
--

CREATE TABLE `travel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `purpose_of_visit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_of_visit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `branch_id`, `name`, `no_telp`, `email`, `email_verified_at`, `password`, `type`, `avatar`, `signature`, `lang`, `is_active`, `created_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 3, 'Ara', '02147483647', 'admin@duasisi.id', NULL, '$2a$12$H1mLej5Amf5tcqdW426gtOADd5u/X7JYU42xu9CI/BDWisNNEh15O', 'company', '55210WhatsApp Image 2021-06-02 at 14.07.23_1628769599.jpeg', 'Tanda_tangan_bapak_1628769724.png', 'id', 1, '0', '68O5VQypI37YgOQXAsiVS6q3PqiVPSK8YUjc9ZnUQH9lqvCtJoaomzpU8PFj', '2020-05-07 22:43:43', '2021-08-12 12:02:19'),
(2, NULL, 'HRD', NULL, 'hr@duasisi.id', NULL, '$2y$12$4FVQhhtHb7iCsWFiU/YCa.b4Ry0es.29nErO4SH6H8/VWfeQzFtye', 'hr', '', NULL, 'id', 1, '1', 'xSSr8hIerBypwfRkxGmN5RflBFuZ7FFzS41rmyIafkDUkdrM8FIipWKxadVQ', '2020-05-07 22:43:45', '2020-09-24 00:27:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `warnings`
--

CREATE TABLE `warnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warning_to` int(11) NOT NULL,
  `warning_by` int(11) NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warning_date` date NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `yearly_bonuses`
--

CREATE TABLE `yearly_bonuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `bonus_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bonus_amount` int(11) NOT NULL,
  `date_disbursement` date NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `account_lists`
--
ALTER TABLE `account_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `allowance_options`
--
ALTER TABLE `allowance_options`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `announcement_employees`
--
ALTER TABLE `announcement_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `attendance_employees`
--
ALTER TABLE `attendance_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `award_types`
--
ALTER TABLE `award_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `deduction_options`
--
ALTER TABLE `deduction_options`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `event_employees`
--
ALTER TABLE `event_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `expense_types`
--
ALTER TABLE `expense_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `genrate_payslip_options`
--
ALTER TABLE `genrate_payslip_options`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `income_types`
--
ALTER TABLE `income_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kasbon`
--
ALTER TABLE `kasbon`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `loan_customs`
--
ALTER TABLE `loan_customs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `loan_options`
--
ALTER TABLE `loan_options`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `meeting_employees`
--
ALTER TABLE `meeting_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `other_payments`
--
ALTER TABLE `other_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `overtimes`
--
ALTER TABLE `overtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `paid_leave`
--
ALTER TABLE `paid_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `payees`
--
ALTER TABLE `payees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payers`
--
ALTER TABLE `payers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payslip_types`
--
ALTER TABLE `payslip_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pay_slips`
--
ALTER TABLE `pay_slips`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `resignations`
--
ALTER TABLE `resignations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `saturation_deductions`
--
ALTER TABLE `saturation_deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_name_created_by_unique` (`name`,`created_by`);

--
-- Indeks untuk tabel `set_salaries`
--
ALTER TABLE `set_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tab`
--
ALTER TABLE `tab`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `terminations`
--
ALTER TABLE `terminations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `termination_types`
--
ALTER TABLE `termination_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `time_sheets`
--
ALTER TABLE `time_sheets`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transfer_balances`
--
ALTER TABLE `transfer_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `travel`
--
ALTER TABLE `travel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `warnings`
--
ALTER TABLE `warnings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `yearly_bonuses`
--
ALTER TABLE `yearly_bonuses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `account_lists`
--
ALTER TABLE `account_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `allowance_options`
--
ALTER TABLE `allowance_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `announcement_employees`
--
ALTER TABLE `announcement_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `attendance_employees`
--
ALTER TABLE `attendance_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `awards`
--
ALTER TABLE `awards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `award_types`
--
ALTER TABLE `award_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `contract`
--
ALTER TABLE `contract`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `deduction_options`
--
ALTER TABLE `deduction_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT untuk tabel `employee_documents`
--
ALTER TABLE `employee_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `event_employees`
--
ALTER TABLE `event_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `expense_types`
--
ALTER TABLE `expense_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `genrate_payslip_options`
--
ALTER TABLE `genrate_payslip_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `income_types`
--
ALTER TABLE `income_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kasbon`
--
ALTER TABLE `kasbon`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `loan_customs`
--
ALTER TABLE `loan_customs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `loan_options`
--
ALTER TABLE `loan_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `meeting_employees`
--
ALTER TABLE `meeting_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `other_payments`
--
ALTER TABLE `other_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT untuk tabel `overtimes`
--
ALTER TABLE `overtimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `paid_leave`
--
ALTER TABLE `paid_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `payees`
--
ALTER TABLE `payees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payers`
--
ALTER TABLE `payers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `payslip_types`
--
ALTER TABLE `payslip_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pay_slips`
--
ALTER TABLE `pay_slips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT untuk tabel `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `resignations`
--
ALTER TABLE `resignations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `saturation_deductions`
--
ALTER TABLE `saturation_deductions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `set_salaries`
--
ALTER TABLE `set_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tab`
--
ALTER TABLE `tab`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `terminations`
--
ALTER TABLE `terminations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `termination_types`
--
ALTER TABLE `termination_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `time_sheets`
--
ALTER TABLE `time_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transfer_balances`
--
ALTER TABLE `transfer_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `travel`
--
ALTER TABLE `travel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT untuk tabel `warnings`
--
ALTER TABLE `warnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `yearly_bonuses`
--
ALTER TABLE `yearly_bonuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
