-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2026 at 10:01 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dvpets`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Admin DV Pets', 'mindvpets@gmail.com', '$2y$12$kbxoPPfsRCfw.aPx5hJ3G.o/1Y3MqVoV2gr40nb5HTLSgq3Ga8JgW', NULL, '2025-11-06 20:00:16', '2025-11-06 20:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pemilik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_hewan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_hewan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ras` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `umur` int NOT NULL,
  `dokter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `layanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_jam` datetime NOT NULL,
  `keluhan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `nama_pemilik`, `email`, `telepon`, `nama_hewan`, `jenis_hewan`, `ras`, `umur`, `dokter`, `layanan`, `tanggal_jam`, `keluhan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Raple', 'Rafly33@gmail.com', '08634284286238', 'adi', 'Kucing', 'persian', 3, 'drh. Sari Dewi', 'Konsultasi Umum', '2025-10-28 15:00:00', 'batuk dan pilek', 'pending', '2025-10-26 23:59:20', '2025-10-26 23:59:20'),
(2, 'Raple', 'Rafly33@gmail.com', '08634284286238', 'adi', 'Burung', 'persian', 3, 'drh. Andi Wijaya', 'Konsultasi Umum', '2025-10-29 14:36:00', 'tes aja dulu', 'pending', '2025-10-29 00:38:20', '2025-10-29 00:38:20');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('article','education') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'article',
  `category` enum('kesehatan','perilaku','nutrisi','grooming','training') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kesehatan',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reading_time` int NOT NULL DEFAULT '5',
  `views` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `excerpt`, `content`, `image`, `type`, `category`, `author`, `reading_time`, `views`, `is_featured`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 'persib', 'persib', 'sdafosfjfa', 'Konten lengkap tentang perawatan kucing...', 'articles/x9egdhEOgDXE2i69miBcJnnULSeUqV6iAhGi5erP.png', 'article', 'kesehatan', 'rafly', 8, 3, 1, 1, '2025-11-06 19:25:50', '2025-11-06 20:47:37'),
(3, 'hallo', 'hallo', 'halloword', 'asjfkasfhueihudfjfafhkjeuireikkmcvxknkjgjigrgjmgmlkakkmksfjgknnvm,xvieioroirofkgfsm', 'articles/LmTrkHT5pGmearZJnIBCRc6UgeyhCWD06K1p03sV.png', 'article', 'nutrisi', 'saya sendiri', 10, 0, 1, 1, '2025-11-06 21:00:20', '2025-11-06 21:00:20');

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
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_user` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `message`, `is_user`, `created_at`, `updated_at`) VALUES
(1, 26, 'tes', 1, '2026-04-18 22:50:33', '2026-04-18 22:50:33'),
(2, 26, 'tes', 1, '2026-04-18 22:52:36', '2026-04-18 22:52:36'),
(3, 26, 'tes', 1, '2026-04-18 23:02:40', '2026-04-18 23:02:40'),
(4, 36, 'tes', 1, '2026-04-20 00:02:34', '2026-04-20 00:02:34'),
(5, 26, 'kucing saya demam dan luka', 1, '2026-04-27 22:14:58', '2026-04-27 22:14:58'),
(6, 26, '🔍 Saya mendeteksi gejala: **demam, luka**\n\n📋 **Hasil Diagnosis:**\n┌ Kemungkinan utama: **Rabies**\n└ Probabilitas: **39.3%**\n\n📊 **Top 3 kemungkinan:**\n  1. Rabies (39.3%)\n  2. Luka Infeksi (23.0%)\n  3. Luka Ringan (14.6%)\n\n💡 **Saran:** DARURAT — jangan sentuh hewan tanpa sarung tangan. Hubungi dokter hewan dan dinas terkait.\n\n🚨 DARURAT — Model AI DVPets (Random Forest, akurasi 94.97%)', 0, '2026-04-27 22:15:02', '2026-04-27 22:15:02'),
(7, 26, 'kucing saya sakit hati', 1, '2026-04-27 22:15:22', '2026-04-27 22:15:22'),
(8, 26, 'Halo! 😊 Saya adalah asisten diagnosis penyakit hewan DVPets.\n\nCeritakan gejala hewan kesayangan kamu, misalnya:\n• \"Kucing saya demam dan tidak mau makan\"\n• \"Anjing saya muntah, lemas, dan diare sejak kemarin\"\n• \"Kelinci saya ada luka dan terlihat lesu\"\n\nSaya akan membantu mendiagnosa kemungkinan penyakitnya! 🐾', 0, '2026-04-27 22:15:22', '2026-04-27 22:15:22'),
(9, 26, 'haiii', 1, '2026-04-27 22:15:28', '2026-04-27 22:15:28'),
(10, 26, 'Halo! 😊 Saya adalah asisten diagnosis penyakit hewan DVPets.\n\nCeritakan gejala hewan kesayangan kamu, misalnya:\n• \"Kucing saya demam dan tidak mau makan\"\n• \"Anjing saya muntah, lemas, dan diare sejak kemarin\"\n• \"Kelinci saya ada luka dan terlihat lesu\"\n\nSaya akan membantu mendiagnosa kemungkinan penyakitnya! 🐾', 0, '2026-04-27 22:15:28', '2026-04-27 22:15:28'),
(11, 26, 'kucing saya demam', 1, '2026-04-27 22:15:36', '2026-04-27 22:15:36'),
(12, 26, '🔍 Saya mendeteksi gejala: **demam**\n\n📋 **Hasil Diagnosis:**\n┌ Kemungkinan utama: **Demam Berdarah**\n└ Probabilitas: **42.7%**\n\n📊 **Top 3 kemungkinan:**\n  1. Demam Berdarah (42.7%)\n  2. Pneumonia (23.0%)\n  3. Tifus (11.7%)\n\n💡 **Saran:** Segera ke dokter hewan. Cek trombosit. Jaga hidrasi, hindari aspirin.\n\n⚠️ Perlu perhatian segera — Model AI DVPets (Random Forest, akurasi 94.97%)', 0, '2026-04-27 22:15:37', '2026-04-27 22:15:37'),
(13, 26, 'anjing saya gamau makan dan panas', 1, '2026-04-27 22:18:55', '2026-04-27 22:18:55'),
(14, 26, '🔍 Saya mendeteksi gejala: **demam**\n\n📋 **Hasil Diagnosis:**\n┌ Kemungkinan utama: **Demam Berdarah**\n└ Probabilitas: **42.7%**\n\n📊 **Top 3 kemungkinan:**\n  1. Demam Berdarah (42.7%)\n  2. Pneumonia (23.0%)\n  3. Tifus (11.7%)\n\n💡 **Saran:** Segera ke dokter hewan. Cek trombosit. Jaga hidrasi, hindari aspirin.\n\n⚠️ Perlu perhatian segera — Model AI DVPets (Random Forest, akurasi 94.97%)', 0, '2026-04-27 22:18:56', '2026-04-27 22:18:56'),
(15, 26, 'kucing saya demam dan bersin trus kenapa ya', 1, '2026-04-27 22:28:48', '2026-04-27 22:28:48'),
(16, 26, 'kucing saya luka dan demam', 1, '2026-04-27 22:32:34', '2026-04-27 22:32:34'),
(17, 26, 'Berdasarkan gejala yang kamu ceritakan (demam, luka), model AI kami menganalisis kemungkinan penyakitnya.\n\nHasil diagnosis:\nKemungkinan utama: Rabies (39.3%)\n\nTop 3 kemungkinan:\n1. Rabies (39.3%)\n2. Luka infeksi (23%)\n3. Luka ringan (14.6%)\n\nSaran penanganan:\nDARURAT — jangan sentuh hewan tanpa sarung tangan. Hubungi dokter hewan dan dinas terkait.\n\nIni merupakan kondisi DARURAT. Segera bawa hewan kamu ke dokter hewan sekarang!', 0, '2026-04-27 22:32:35', '2026-04-27 22:32:35'),
(18, 26, 'kalo di tambah bersin', 1, '2026-04-27 22:34:17', '2026-04-27 22:34:17'),
(19, 26, 'Berdasarkan gejala yang kamu ceritakan (batuk), model AI kami menganalisis kemungkinan penyakitnya.\n\nHasil diagnosis:\nKemungkinan utama: Flu Kucing (100%)\n\nTop 3 kemungkinan:\n1. Flu kucing (100%)\n2. Anemia (0%)\n3. Demam berdarah (0%)\n\nSaran penanganan:\nIsolasi kucing, jaga kehangatan. Konsultasi dokter jika tidak membaik dalam 2 hari.\n\nDisarankan untuk memeriksakan hewan kamu ke dokter hewan sesegera mungkin.', 0, '2026-04-27 22:34:18', '2026-04-27 22:34:18'),
(20, 26, 'kucing saya sakit dan muntah', 1, '2026-04-27 23:27:39', '2026-04-27 23:27:39'),
(21, 26, 'Berdasarkan gejala yang kamu ceritakan (muntah), model AI kami menganalisis kemungkinan penyakitnya.\n\nHasil diagnosis:\nKemungkinan utama: Keracunan (32.3%)\n\nTop 3 kemungkinan:\n1. Keracunan (32.3%)\n2. Flu kucing (25.7%)\n3. Tifus (12%)\n\nSaran penanganan:\nDARURAT — identifikasi sumber racun. Jangan beri makan, segera ke dokter hewan.\n\nIni merupakan kondisi DARURAT. Segera bawa hewan kamu ke dokter hewan sekarang!', 0, '2026-04-27 23:27:41', '2026-04-27 23:27:41'),
(22, 26, 'kucing saya kejang', 1, '2026-04-27 23:28:06', '2026-04-27 23:28:06'),
(23, 26, 'Halo! Saya adalah DVPets AI, asisten kesehatan hewan peliharaan kamu.\n\nCeritakan gejala hewan kesayanganmu secara spesifik agar saya bisa membantu mendiagnosa, misalnya:\nKucing saya demam dan tidak mau makan sejak kemarin\nAnjing saya muntah, lemas, dan diare\nKelinci saya ada luka dan terlihat lesu\n\nSaya akan menganalisa gejala tersebut menggunakan model AI kami dan memberikan saran penanganan awal. Untuk diagnosis resmi, tetap konsultasikan ke dokter hewan ya!', 0, '2026-04-27 23:28:07', '2026-04-27 23:28:07'),
(24, 26, 'kucing saya kutuan', 1, '2026-04-27 23:30:34', '2026-04-27 23:30:34'),
(25, 26, 'Halo! Saya adalah DVPets AI, asisten kesehatan hewan peliharaan kamu.\n\nCeritakan gejala hewan kesayanganmu secara spesifik agar saya bisa membantu mendiagnosa, misalnya:\nKucing saya demam dan tidak mau makan sejak kemarin\nAnjing saya muntah, lemas, dan diare\nKelinci saya ada luka dan terlihat lesu\n\nSaya akan menganalisa gejala tersebut menggunakan model AI kami dan memberikan saran penanganan awal. Untuk diagnosis resmi, tetap konsultasikan ke dokter hewan ya!', 0, '2026-04-27 23:30:35', '2026-04-27 23:30:35'),
(26, 36, 'kucing saya gamau makan', 1, '2026-04-27 23:36:50', '2026-04-27 23:36:50'),
(27, 36, 'Halo! Saya adalah DVPets AI, asisten kesehatan hewan peliharaan kamu.\n\nCeritakan gejala hewan kesayanganmu secara spesifik agar saya bisa membantu mendiagnosa, misalnya:\nKucing saya demam dan tidak mau makan sejak kemarin\nAnjing saya muntah, lemas, dan diare\nKelinci saya ada luka dan terlihat lesu\n\nSaya akan menganalisa gejala tersebut menggunakan model AI kami dan memberikan saran penanganan awal. Untuk diagnosis resmi, tetap konsultasikan ke dokter hewan ya!', 0, '2026-04-27 23:36:51', '2026-04-27 23:36:51'),
(28, 36, 'kucing saya demam dan luka', 1, '2026-04-27 23:37:14', '2026-04-27 23:37:14'),
(29, 36, 'Berdasarkan gejala yang kamu ceritakan (demam, luka), model AI kami menganalisis kemungkinan penyakitnya.\n\nHasil diagnosis:\nKemungkinan utama: Rabies (39.3%)\n\nTop 3 kemungkinan:\n1. Rabies (39.3%)\n2. Luka infeksi (23%)\n3. Luka ringan (14.6%)\n\nSaran penanganan:\nDARURAT — jangan sentuh hewan tanpa sarung tangan. Hubungi dokter hewan dan dinas terkait.\n\nIni merupakan kondisi DARURAT. Segera bawa hewan kamu ke dokter hewan sekarang!', 0, '2026-04-27 23:37:16', '2026-04-27 23:37:16'),
(30, 36, 'halo', 1, '2026-04-27 23:53:04', '2026-04-27 23:53:04'),
(31, 36, 'Halo! Saya DVPets AI, asisten kesehatan hewan peliharaan kamu.\n\nCeritakan gejala hewan kesayanganmu secara spesifik agar saya bisa membantu mendiagnosa, misalnya:\nKucing saya demam dan tidak mau makan sejak kemarin\nAnjing saya muntah, lemas, dan diare\nKelinci saya ada luka dan terlihat lesu\n\nSaya akan menganalisa menggunakan model AI kami. Untuk diagnosis resmi, tetap konsultasikan ke dokter hewan ya!', 0, '2026-04-27 23:53:12', '2026-04-27 23:53:12'),
(32, 36, 'kucing saya panas dan kejang', 1, '2026-04-27 23:53:34', '2026-04-27 23:53:34'),
(33, 36, 'Berdasarkan gejala yang kamu ceritakan (demam), berikut hasil analisis AI kami.\n\nKemungkinan utama: Demam Berdarah (42.7%)\n\nTop 3 kemungkinan:\n1. Demam berdarah (42.7%)\n2. Pneumonia (23%)\n3. Tifus (11.7%)\n\nSaran penanganan:\nSegera ke dokter hewan. Cek trombosit. Jaga hidrasi, hindari aspirin.\n\nKondisi ini perlu penanganan segera. Jangan tunda untuk ke dokter hewan.', 0, '2026-04-27 23:53:42', '2026-04-27 23:53:42'),
(34, 38, 'Tips merawat bulu hewan agar tidak rontok', 1, '2026-04-27 23:54:52', '2026-04-27 23:54:52'),
(35, 38, 'Halo! Saya DVPets AI, asisten kesehatan hewan peliharaan kamu.\n\nCeritakan gejala hewan kesayanganmu secara spesifik agar saya bisa membantu mendiagnosa, misalnya:\nKucing saya demam dan tidak mau makan sejak kemarin\nAnjing saya muntah, lemas, dan diare\nKelinci saya ada luka dan terlihat lesu\n\nSaya akan menganalisa menggunakan model AI kami. Untuk diagnosis resmi, tetap konsultasikan ke dokter hewan ya!', 0, '2026-04-27 23:54:59', '2026-04-27 23:54:59'),
(36, 38, 'halo', 1, '2026-04-28 19:53:58', '2026-04-28 19:53:58'),
(37, 38, 'Halo Selamat datang di DVPets! Saya adalah asisten kesehatan hewan dari klinik DVPets yang siap membantu Anda. Jika ada pertanyaan tentang kesehatan hewan peliharaan Anda atau butuh informasi umum, jangan ragu untuk bertanya. Kami di sini untuk membantu menjaga hewan kesayangan Anda tetap sehat dan bahagia!', 0, '2026-04-28 19:54:08', '2026-04-28 19:54:08'),
(38, 38, 'kucing saya demam dan bulunya rontok itu kenapa ya', 1, '2026-04-28 19:54:37', '2026-04-28 19:54:37'),
(39, 38, 'Berdasarkan gejala yang kamu ceritakan (demam, rambut rontok), berikut hasil analisis AI kami.\n\nKemungkinan utama: Jamur Kulit (53.8%)\n\nTop 3 kemungkinan:\n1. Jamur kulit (53.8%)\n2. Kerontokan bulu (46.2%)\n3. Abses (0%)\n\nSaran penanganan:\nKe dokter untuk obat antijamur (topikal atau oral). Jaga area tetap kering, gunakan sarung tangan saat merawat.\n\nDisarankan segera periksakan hewan kamu ke dokter hewan.', 0, '2026-04-28 19:55:08', '2026-04-28 19:55:08'),
(40, 38, 'kalo gejala kaya gitu sebaiknya di mandiin atau engga ya kucingnya soalnya kutuan juga', 1, '2026-04-28 19:55:46', '2026-04-28 19:55:46'),
(41, 38, 'Aku ngerti kamu khawatir dengan kondisi kucingmu. Kutu yang terdeteksi di tubuh kucingmu memang perlu perhatian karena bisa jadi gejala masalah telinga atau infeksi kulit. Kemungkinan besar kucingmu sedang mengalami infeksi telinga atau kutu pinjal yang perlu penanganan khusus. Sebaiknya mandi dulu dengan sampo khusus hewan, tapi hindari korek telinga sendiri dan segera ke dokter hewan untuk pemeriksaan lebih lanjut. Jangan khawatir, dokter hewan akan membantu kucingmu sembuh!', 0, '2026-04-28 19:56:11', '2026-04-28 19:56:11'),
(42, 36, 'tes', 1, '2026-04-28 20:10:15', '2026-04-28 20:10:15'),
(43, 36, 'Halo! Selamat datang di DVPets AI. Saya siap membantu Anda dengan pertanyaan tentang kesehatan hewan peliharaan Anda. Jika Anda memiliki masalah atau gejala pada hewan Anda, jangan ragu untuk menceritakan lebih detail. Terima kasih telah menghubungi kami!', 0, '2026-04-28 20:10:22', '2026-04-28 20:10:22'),
(44, 36, 'kucing saya kenapa', 1, '2026-04-28 21:34:53', '2026-04-28 21:34:53'),
(45, 36, 'Maaf karena terjadi keseluruhan riwayat rekam medis. Kucing Anda, dggg, yang dirawat pada 29 April 2026, mengalami kejang dan demam. Dokter telah menetapkan diagnosa epilepsi idiopatik dan sekarang mengawasi kondisinya lebih lanjut. Untuk mendapatkan informasi paling akurat, mohon dapat mengungkapkan lebih spesifik gejala yang sedang dialami kucing Anda, seperti demam, muntah, atau kejang?', 0, '2026-04-28 21:35:10', '2026-04-28 21:35:10'),
(46, 36, 'kucing saya kejang lagi saya harus ngapain', 1, '2026-04-28 21:35:51', '2026-04-28 21:35:51'),
(47, 36, 'Maaf kamu sedang melewati momen yang sulit dengan kucingmu. Aku melihat bahwa kucingmu lagi kejang, itu memang sangat mengkhawatirkan. Menurut analisisku, kucingmu ini mungkin sedang mengalami epilepsi kejang, itu adalah kondisi yang perlu diatasi segera oleh dokter.\n\nAku tahu kamu mungkin penasaran tentang apa yang bisa menjadi penyebabnya, tapi untuk sekarang, yang penting adalah kita menangani kondisi kejang ini. Selain epilepsi kejang, kemungkinan paling tinggi lainnya adalah rabies atau infeksi kulit. Tapi itu bukanlah alasan untuk panik, karena kita bisa mengatasinya jika kita pergi ke dokter hewan sekarang juga.\n\nSaran yang paling penting adalah bawa kucingmu ke dokter hewan segera! Biarkan dokter memeriksa dan merawat kucingmu. Ingatlah untuk jangan pegang kucingmu saat kejang, dan pastikan kucingmu tidak mengganggu benda-benda yang bisa menyebabkan cedera. Mari kita lakukan yang terbaik untuk kucingmu, tidak lama lagi dia akan baik-baik saja!', 0, '2026-04-28 21:36:09', '2026-04-28 21:36:09'),
(48, 39, 'Hewan saya demam dan batuk sudah 2 hari', 1, '2026-04-28 22:03:13', '2026-04-28 22:03:13'),
(49, 39, 'Jangan khawatir, saya telah menjelajahi kondisi hewan Anda. Gejala yang muncul seperti demam dan batuk sudah 2 hari, pastinya sangat tidak nyaman buat hewan Anda.\n\nSaya menduga hewan Anda mungkin mengalami masalah dengan sistem pernapasan, seperti bronkitis yang sering menyebabkan batuk dan demam. Ada juga kemungkinan lain seperti pneumonia atau flu kucing, tapi saya akan melakukan pemeriksaan lebih lanjut untuk memastikan diagnosis yang akurat.\n\nSaran saya, jaga hewan Anda tetap hangat dan hindari asap untuk membantu pernapasan. Jika gejala tidak membaik, sebaiknya Anda membawa hewan Anda ke dokter hewan saya untuk pemeriksaan lebih lanjut dan jika perlu, memberikan bronkodilator atau antibiotik.\n\nJangan takut, saya akan membantu hewan Anda pulih kembali secepatnya!', 0, '2026-04-28 22:03:33', '2026-04-28 22:03:33'),
(50, 39, 'hewan saya batuk dan demam itu kenapa ya dokterpaw?', 1, '2026-04-28 22:04:17', '2026-04-28 22:04:17'),
(51, 39, 'Maaf kalau hewanmu tidak merasa baik. Aku melihat ada gejala batuk dan demam. Gejala ini sepertinya ada karena hewanmu mengalami iritasi pada saluran pernapasan. Saya pikir hewanmu mungkin terkena radang paru-paru, tapi masih ada kemungkinan lain seperti pneumonia atau flu kucing. Jangan khawatir, kondisi ini masih bisa diobati dengan bronkodilator atau antibiotik jika diperlukan. Saya sarankan jangan membuat hewanmu keluar jika cuaca tidak baik, tetapi jaga hewanmu tetap hangat dan hindari asap. Aku yakin hewanmu akan baik-baik saja!', 0, '2026-04-28 22:04:33', '2026-04-28 22:04:33'),
(52, 39, 'dokterpaw tolong saya ini kucing saya kejang dan panas', 1, '2026-04-28 22:15:03', '2026-04-28 22:15:03'),
(53, 39, 'Hai deh, Pak/Pak Nanti! DokterPaw sini 🐾👋. Kita punya kasus yang serius, nih! Kucing kamu kejang dan panas? 🤯 DokterPaw langsung terbayang beberapa kemungkinan penyakit, sih. Berikut adalah analisis DokterPaw:\n\nDokterPaw mengidentifikasi dua gejala utama: demam dan kejang. Saya melakukan analisis, Pak/Pak Nanti, dan menemukan beberapa kemungkinan penyakit. Berikut adalah 3 kemungkinan yang paling mungkin:\n\n1. Rabies (92,2% 🐾😱): Saya rasa ini merupakan kemungkinan utama, Pak. Rabies bisa menyebabkan gejala kejang dan demam. Saya mengingatkanmu, Rabies sangat berbahaya, dan kita harus sangat berhati-hati. Kalau kamu curiga hewanmu memiliki kontak dengan hewan yang terinfeksi Rabies, maka ini bisa menjadi kemungkinan yang sangat besar.\n2. Heat stroke (5,9% ☀️😓): Kucing mungkin terkena heat stroke karena cuaca panas, Pak. Namun, ini hanya kemungkinan kedua, dan saya masih curiga bahwa ada kemungkinan lain yang lebih serius.\n3. Epilepsi kejang (1,8% 🤯😕): Kemungkinan ini juga mungkin, namun saya curiga bahwa kemungkinan pertama dan kedua lebih mungkin.\n\nDokterPaw menyarankanmu, Pak/Pak Nanti, bahwa kasus ini adalah DARURAT ⚠️. Saya sangat mengingatkanmu untuk JANGAN sentuh hewan tanpa sarung tangan! Kalau kamu tidak yakin, hubungi dokter hewan atau dinas terkait untuk bantuan. Yang paling penting, SEGERA bawa kucingmu ke klinik untuk periksa lebih lanjut. DokterPaw sangat mengharapkan agar kucingmu segera mendapatkan perawatan yang tepat. 💕 DokterPaw sangat meminta perhatianmu, Pak. Kucingmu butuh bantuan sekarang juga! 🐾💕', 0, '2026-04-28 22:15:21', '2026-04-28 22:15:21'),
(54, 39, 'lebay dih dokterpaw apaan lebay gajelas', 1, '2026-04-28 22:16:45', '2026-04-28 22:16:45'),
(55, 39, 'Haha, gak apa-apa sih! 😊 Lebay gajelas cuma artinya kamu belum pernah datang ke dokterku sebelumnya, dan itu tidak apa-apa! 👍\n\nKamu ingin buat rekam medis hewan buatnya? Jangan khawatir, Dokterpaw siap membantu kamu membuat rekam medis yang aman dan sehat untuk hewanmu! 🐾💉\n\nTapi, sebelumnya, tolong kamu ceritain Dokterpaw tentang hewanmu nih! 🐶🐱 Cuma butuh informasi singkat aja, seperti usia hewan, jenis hewan, gejala apa yang terjadi, dan lain-lain. Dokterpaw akan membantu kamu dengan senang hati! 😊', 0, '2026-04-28 22:17:01', '2026-04-28 22:17:01'),
(56, 39, 'jadi tadi hewan saya kenapa dokterpaw yang sehabis saya periksa', 1, '2026-04-28 22:25:20', '2026-04-28 22:25:20'),
(57, 39, 'Halo hai! Ini DokterPaw! 😊 Wah, sepertinya Amau sedang tidak enak-enak nih, kucing imutmu batuk-batuk dan sesak... itu biasanya gejala bronkitis lho! 🐱💨\n\nBronkitis itu seperti radang di saluran napas Amau, jadi dia merasa sesak dan batuk-batuk. Dokternya memberinya suntik vitamin mungkin untuk memperkuat sistem kekebalan tubuhnya biar lebih cepat sembuh ya! 💪💉\n\nDan yang paling penting, dokter bilang jangan kena asap apapun itu... itu super penting! 😱 Asap rokok, dupa, bahkan asap masakan bisa bikin bronkitis Amau parah lagi. Jadi pastikan lingkungannya bersih dan segar! 🌬️\n\nKalau Amau masih batuk atau sesak setelah minum obat, sebaiknya segera bawa lagi ke dokter ya! Jangan sampak kambuh lagi... Amau pasti ingin segera sembuh dan main-main lagi kan? 🎾✨\n\nAda yang lain bisa DokterPaw bantu? 🐾', 0, '2026-04-28 22:25:39', '2026-04-28 22:25:39'),
(58, 39, 'dokterpaw ini kenapa kucingnya', 1, '2026-04-28 22:32:05', '2026-04-28 22:32:05'),
(59, 39, 'Maau terima kasih telah memercayakan kesehatannya padaku! 🐱 Selamat, kucing Anda, Maau, masih dalam perawatan! \n\nDiketahui sekarang, Maau didiagnosis memiliki bronkitis, yang menunjukkan adanya inflamasi pada saluran pernapasan bagian bawah. Penyebabnya bisa bervariasi, tetapi gejala yang paling umum adalah sesak napas, batuk, dan kadang-kadang suhu badan meningkat. \n\nPertama-tama, kita harus menjaga Maau tetap di rumah dan tidak terkena udara polusi atau asap yang bisa memperburuk kondisi penyakitnya. Selain itu, Maau akan menerima suntikan vitamin untuk membantu meningkatkan kesihatan umumnya.', 0, '2026-04-28 22:32:08', '2026-04-28 22:32:08'),
(60, 39, 'dokterpaw kucing itu di atas kenapa dia kejang', 1, '2026-04-28 22:32:37', '2026-04-28 22:32:37'),
(61, 39, 'Maaf, aku rasa ada kekhawatiran dengan keadaan Amau, ya. Menurut catatan DokterPaw, Amau telah mengalami kejang. DokterPaw sangat khawatir karena kondisi ini mengindikasikan adanya masalah yang serius.\n\nDokterPaw ingin memberitahu bahwa Diagnosis Utama yang mungkin terjadi adalah Epilepsi Kejang dengan kemungkinan 86,2%. Selain itu, DokterPaw juga menemukan kemungkinan lain yang harus dipertimbangkan, yaitu:\n\n1. Epilepsi kejang (86,2%) 🐾\n2. Rabies (13,1%) 🐾\n3. Infeksi kulit (0,7%) 🐾\n\nNamun, DokterPaw ingin menekankan bahwa kondisi kejang Amau sangat berisiko dan perlu penanganan darurat. Jadi, silakan untuk langsung menuju klinik DVPets bersama Amau sekarang juga. Jangan lupa untuk menjauhkan Amau dari benda berbahaya dan tidak memegangnya paksa saat kejang. Catat juga durasi kejang untuk membantu DokterPaw merumuskan rencana penanganan yang lebih tepat.\n\nDokterPaw sangat peduli dengan kesehatan Amau dan berharap Anda dapat segera membawa Amau ke klinik untuk penanganan yang memadai. Kami akan menunggu Anda dengan hati yang terbuka dan siap membantu Amau kembali menjalaninya dengan sehat.', 0, '2026-04-28 22:33:04', '2026-04-28 22:33:04'),
(62, 39, 'Kucing saya tidak mau makan dan lemas', 1, '2026-04-28 22:33:40', '2026-04-28 22:33:40'),
(63, 39, 'Halo lagi, User! DokterPaw senang menjawab pertanyaan Anda tentang amau, kucing cantik Anda 🐱.\n\nDokterPaw tahu bahwa amau tidak mau makan dan lemas, dan kita sudah perhatikan kondisinya sebelumnya. Setelah analisis lebih lanjut, DokterPaw menemukan beberapa kemungkinan penyebab. Berikut adalah hasilnya:\n\nGejala yang ditemukan:\n\n Lemas\n Nafsu makan turun\n\nTop 3 Kemungkinan Penyebab:\n\n1. Anemia (45.9%): DokterPaw curiga bahwa amau mungkin mengalami kekurangan sel darah merah, yang dapat disebabkan oleh beberapa faktor, seperti kutu, cacing, atau penyakit serius lainnya.\n2. Diabetes hewan (38.7%): Kondisi ini dapat menyebabkan kekurangan gula dalam darah, yang dapat membuat amau merasa lemas dan kehilangan nafsu makan.\n3. Tokso toxoplasma (6.2%): Penyakit ini dapat menyebabkan infeksi pada system kekebalan amau, yang dapat membuatnya merasa lelah dan kehilangan nafsu makan.\n\nSaran DokterPaw: DokterPaw sarankan Anda membawa amau ke dokter hewan agar dapat melakukan pemeriksaan lebih lanjut, terutama cek darah. Dengan demikian, kita dapat mengetahui penyebab lebih akurat dan memberikan perawatan yang tepat.\n\nKondisi stabil: Sekarang, amau sedang dalam kondisi stabil, dan tidak ada tanda-tanda kegawatdaruratan. Namun, DokterPaw masih ingin meminta Anda untuk waspada dan membawa amau ke dokter hewan secepatnya jika gejala-gejalanya memburuk.\n\nJika Anda memiliki pertanyaan atau kekhawatiran, jangan ragu untuk bertanya. DokterPaw akan selalu berada di sini untuk membantu.', 0, '2026-04-28 22:34:07', '2026-04-28 22:34:07'),
(66, 40, 'Halo', 1, '2026-04-30 06:43:36', '2026-04-30 06:43:36'),
(67, 40, 'Halo! Selamat datang di DVPets 👋 Saya DokterPaw, asisten virtual siap membantu Anda merawat hewan peliharaan yang sayang. 😊 \n\nApa yang bisa saya bantu hari ini? Apakah Anda memiliki pertanyaan tentang kesehatan, perawatan, atau masalah umum mengenai hewan peliharaan Anda? 🐶🐱🐰', 0, '2026-04-30 06:43:49', '2026-04-30 06:43:49'),
(68, 40, 'Kucing saya sedang demam, apa solusinya?', 1, '2026-04-30 06:44:20', '2026-04-30 06:44:20'),
(69, 40, 'Hai kawan! DokterPaw sedih mendengar kucingmu sedang demam 🐱. Saya paham kekhawatiranmu dan ingin memberikan informasi yang tepat untuk membantu kucingmu sembuh secepatnya.\n\nSetelah menganalisis gejala yang terdeteksi, DokterPaw mengeluarkan beberapa kemungkinan penyakit yang mungkin menyebabkan demam pada kucingmu. Berikut adalah Top 3 kemungkinan:\n\n1. Demam Berdarah (28.9%): Ini adalah kemungkinan terbesar. Demam berdarah adalah penyakit menular yang disebabkan oleh virus. Gejala umumnya termasuk demam, kelelahan, dan gangguan pada sistem pencernaannya.\n2. Rabies (19.4%): Ini adalah penyakit menular yang juga berbahaya dan disebabkan oleh virus. Gejala umumnya termasuk perubahan perilaku, demam, dan gejala neurologis seperti kelumpuhan.\n3. Heat stroke (13.3%): Ini adalah kondisi ketika kucingmu kepanasan dan tidak dapat menyesuaikan diri dengan suhu lingkungan. Gejala umumnya termasuk demam, kelelahan, dan gangguan pada sistem pencernaannya.\n\nDokterPaw sangat khawatir karena kondisi ini sangat serius 🙏. Saya sarankan kamu segera membawa kucingmu ke dokter hewan untuk diperiksa dengan lebih lanjut. Kucingmu mungkin memerlukan cek trombosit dan perawatan lainnya. Selain itu, pastikan kamu menjaga hidrasi kucingmu dengan baik dan hindari pemberian aspirin karena bisa membuat kondisinya buruk.\n\nJangan ragu untuk menghubungi kami jika kamu memiliki pertanyaan atau kekhawatiran lebih lanjut. Kami siap membantu!', 0, '2026-04-30 06:44:49', '2026-04-30 06:44:49'),
(76, 41, 'Cara pemberian obat cacing yang benar?', 1, '2026-04-30 06:53:37', '2026-04-30 06:53:37'),
(77, 41, 'Halo! 😊 Pemberian obat cacing sangat penting untuk menjaga kesehatan hewan peliharaanmu ya. Berikut cara pemberiannya yang benar:\n\nLangkah-langkah pemberian obat cacing:\n1️⃣ Konsultasi dulu dengan dokter hewan - Setiap hewan membutuhkan dosis dan jenis obat yang berbeda sesuai usia, berat badan, dan kondisi kesehatannya.\n\n2️⃣ Baca petunjuk dosis dengan teliti - Dosis biasanya dihitung berdasarkan berat badan hewan.\n\n3️⃣ Beri obat sesuai jadwal - Umumnya deworming dilakukan setiap 3-6 bulan untuk hewan dewasa, dan lebih sering untuk anak-anak hewan.\n\n4️⃣ Cara pemberian:\n   - Obat bentuk tablet bisa diberikan langsung atau disembunyikan dalam makanan\n   - Untuk obat cair, gunakan pipet atau dispenser yang disediakan\n   - Pastikan hewan menelan seluruh dosis\n\n5️⃣ Perhatikan reaksi hewan - Beberapa hewan mungkin mengalami efek samping ringan seperti mual atau diare.\n\nJangan lupa untuk membersihkan lingkungan sekitar hewan secara rutin juga, ya! 🧹 Setelah deworming, selama 24 jam pertama usahakan untuk membersihkan kotoran hewan secara berkala.\n\nAda pertanyaan lain seputar perawatan hewanmu? Saya siap membantu! 🐾', 0, '2026-04-30 06:53:56', '2026-04-30 06:53:56');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pet_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `services` json DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultation_messages`
--

CREATE TABLE `consultation_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `sender_type` enum('user','doctor') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultation_messages`
--

INSERT INTO `consultation_messages` (`id`, `session_id`, `sender_type`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'user', 'halo dokter', 1, '2026-04-29 03:34:54', '2026-04-29 11:59:36'),
(2, 1, 'doctor', 'iya kenapa', 1, '2026-04-29 03:35:50', '2026-04-29 12:10:06'),
(3, 1, 'user', 'dokter orang mana', 1, '2026-04-29 03:36:51', '2026-04-29 11:59:36'),
(4, 1, 'user', 'dokter saya mau nanya', 1, '2026-04-29 03:41:13', '2026-04-29 11:59:36'),
(5, 1, 'user', 'dokter orang mana si dok', 1, '2026-04-29 10:49:56', '2026-04-29 11:59:36'),
(6, 1, 'doctor', 'ehh iya saya orang ini Panyindangan wetan hehe', 1, '2026-04-29 10:50:48', '2026-04-29 12:10:06'),
(7, 3, 'user', 'dokter Ali ganteng bangettt', 1, '2026-04-29 10:52:08', '2026-04-29 11:51:09'),
(8, 3, 'user', 'halo dokter', 1, '2026-04-29 11:49:26', '2026-04-29 11:51:09'),
(9, 3, 'doctor', 'haiii saiff', 0, '2026-04-29 11:50:37', '2026-04-29 11:50:37'),
(10, 1, 'user', 'gg dokter', 1, '2026-04-29 11:52:02', '2026-04-29 11:59:36'),
(11, 1, 'user', 'hehe keren dokter', 1, '2026-04-29 11:58:08', '2026-04-29 11:59:36'),
(12, 1, 'doctor', 'iyaa kenapa yaa', 1, '2026-04-29 11:59:34', '2026-04-29 12:10:06'),
(13, 1, 'user', 'haii', 0, '2026-04-29 12:00:11', '2026-04-29 12:00:11'),
(14, 1, 'user', 'halo dok', 0, '2026-04-29 12:10:04', '2026-04-29 12:10:04'),
(15, 5, 'user', 'MuachAw', 1, '2026-04-30 06:49:57', '2026-04-30 06:50:23'),
(16, 5, 'doctor', 'ayo cod sapi', 1, '2026-04-30 06:50:21', '2026-04-30 06:51:01'),
(17, 5, 'user', 'sehat', 0, '2026-04-30 06:50:54', '2026-04-30 06:50:54'),
(18, 5, 'user', 'Alhamdulillah', 0, '2026-04-30 06:50:58', '2026-04-30 06:50:58'),
(19, 7, 'user', 'ip basis data', 0, '2026-04-30 06:51:25', '2026-04-30 06:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `consultation_sessions`
--

CREATE TABLE `consultation_sessions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `doctor_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultation_sessions`
--

INSERT INTO `consultation_sessions` (`id`, `user_id`, `doctor_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 30, 8, 'active', '2026-04-29 03:34:36', '2026-04-29 12:10:04'),
(2, 30, 7, 'active', '2026-04-29 03:37:03', '2026-04-29 03:37:03'),
(3, 27, 8, 'active', '2026-04-29 10:51:54', '2026-04-29 11:50:37'),
(4, 27, 7, 'active', '2026-04-29 11:09:00', '2026-04-29 11:09:00'),
(5, 41, 9, 'active', '2026-04-30 06:49:51', '2026-04-30 06:50:58'),
(6, 41, 1, 'active', '2026-04-30 06:51:08', '2026-04-30 06:51:08'),
(7, 41, 8, 'active', '2026-04-30 06:51:17', '2026-04-30 06:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialization` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `email`, `specialization`, `schedule`, `photo`, `description`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'drh. Roza Albate Chandra Adila', NULL, 'Umum', '11.00 - 19.00 wib', 'doctors/rHW46dWBcJdnPEZwJ8hcGlmAmKlhjuQhNnr42YRC.jpg', NULL, '2025-11-27 19:00:53', '2025-12-22 03:22:35', NULL),
(2, 'drh. Arundhina Girishanta M.Si', NULL, 'Umum', '17.00 - 22.00 Wib', 'doctors/Fri4bshVgD5Lp4ezQqOi9iMvaXIct9HxVwPJqPkK.jpg', NULL, '2025-12-20 20:07:57', '2025-12-21 05:47:51', NULL),
(6, 'Saif Ali Mushaddiq', NULL, 'm', '777', 'doctors/xrEJCB7xHYrhnDamz327vYy21wVSdgmrIcTHbfCt.jpg', NULL, '2026-04-08 23:50:43', '2026-04-08 23:50:43', NULL),
(7, 'project3 sensor jarak ultrasonic(HC-SR04)', NULL, 'hewan', 'pukul 09.00-12.00', 'doctors/Af6pfZ1vYPv1IQ8D7fIXaHej9VdY7QgRHjENdOvP.jpg', NULL, '2026-04-15 20:34:55', '2026-04-15 20:34:55', NULL),
(8, 'Saif Ali Mushaddiq', 'alimushaddiq13@gmail.com', 'hewan', 'pukul 09.00-12.00', 'doctors/nvl9yqBIMOTdbjQyczYLxtcv920hNVc3QADfVY5l.jpg', 'spesialis hewan', '2026-04-29 03:28:11', '2026-04-29 03:28:41', 36),
(9, 'azhar', 'kasur0865@gmail.com', 'hewan', 'pukul 09.00-12.00', 'doctors/SjZDHSomvW0KOG4Xy6MvrupmVJIBrH6kGOz1heQM.png', NULL, '2026-04-30 06:48:04', '2026-04-30 06:49:21', 40);

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('article','video','guide') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reading_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `view` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `title`, `category`, `type`, `content`, `description`, `thumbnail`, `video_url`, `duration`, `level`, `reading_time`, `is_published`, `view`, `created_at`, `updated_at`) VALUES
(2, 'Pentingnya Pemeliharaan Hewan yang Baik dan Bertanggung Jawab', 'kesehatan', 'guide', 'Masing-masing jenis hewan memiliki kebutuhan perawatan yang berbeda, sehingga pemilik harus memahami karakter dan kebiasaan hewan tersebut.\r\nPrinsip Dasar Pemeliharaan Hewan\r\nAgar pemeliharaan hewan berjalan dengan baik, ada beberapa prinsip dasar yang perlu diperhatikan:\r\n- Pemberian pakan yang sesuai, baik dari segi jumlah, kualitas, maupun jadwal.\r\n- Kebersihan kandang atau tempat tinggal, untuk mencegah berkembangnya bakteri dan penyakit.\r\n- Perawatan kesehatan, seperti vaksinasi, pemeriksaan rutin, dan penanganan saat hewan sakit.\r\n- Lingkungan yang nyaman, termasuk sirkulasi udara yang baik dan ruang gerak yang cukup.\r\nManfaat Pemeliharaan Hewan\r\nPemeliharaan hewan yang baik memberikan banyak manfaat, di antaranya:\r\n- Hewan menjadi lebih sehat dan produktif.\r\n- Mengurangi risiko penularan penyakit.\r\n- Meningkatkan hubungan emosional antara manusia dan hewan.\r\n- Memberikan nilai ekonomi, khususnya pada hewan ternak.\r\nKesimpulan\r\nPemeliharaan hewan bukan sekadar aktivitas rutin, melainkan bentuk tanggung jawab dan kepedulian terhadap makhluk hidup. Dengan perawatan yang tepat dan berkelanjutan, hewan dapat hidup lebih sejahtera dan memberikan manfaat yang optimal bagi manusia. Oleh karena itu, setiap pemilik hewan perlu memahami cara pemeliharaan yang benar agar tercipta keseimbangan antara manusia, hewan, dan lingkungan.', 'Pemeliharaan hewan adalah serangkaian kegiatan yang dilakukan untuk memenuhi kebutuhan dasar hewan, seperti makanan, tempat tinggal, kesehatan, dan kebersihan. Tujuan utama dari pemeliharaan hewan adalah menjaga kualitas hidup hewan sekaligus mencegah munculnya penyakit yang dapat merugikan hewan maupun manusia.\r\nJenis-Jenis Hewan yang Dipelihara\r\n- Hewan yang dipelihara umumnya terbagi menjadi dua kelompok, yaitu:\r\n- Hewan peliharaan, seperti kucing, anjing, burung, dan ikan, yang dipelihara untuk hiburan atau sebagai teman.\r\n- Hewan ternak, seperti sapi, kambing, ayam, dan ikan konsumsi, yang dipelihara untuk diambil hasilnya seperti daging, susu, atau telur.', 'education/thumbnails/QFmYByNPG16ZCkksNWaNp454JRn9kbx6sHA4QRKy.png', NULL, NULL, 'Pemula', '30', 1, 10, '2025-12-22 02:20:57', '2026-04-29 13:16:21'),
(3, 'Perawatan Anak Kucing: Panduan Dasar untuk Tumbuh Sehat', 'kesehatan', 'guide', 'Anak kucing merupakan fase paling rentan dalam kehidupan kucing. Pada usia ini, sistem kekebalan tubuh mereka masih belum sempurna, sehingga sangat mudah terserang penyakit. Oleh karena itu, perawatan yang tepat sangat penting untuk memastikan pertumbuhan yang optimal.\r\n\r\nPada minggu-minggu pertama, anak kucing sangat bergantung pada induknya, terutama untuk mendapatkan nutrisi dari susu. Jika anak kucing tidak memiliki induk, maka pemilik harus memberikan susu khusus kucing sebagai pengganti, karena susu sapi tidak cocok dan dapat menyebabkan gangguan pencernaan.\r\n\r\nSeiring bertambahnya usia, anak kucing mulai belajar makan makanan padat. Proses ini harus dilakukan secara bertahap dengan memberikan makanan khusus kitten yang mudah dicerna dan kaya nutrisi. Pastikan juga anak kucing selalu memiliki akses ke air bersih.\r\n\r\nKebersihan menjadi faktor penting dalam perawatan anak kucing. Tempat tidur harus selalu bersih dan hangat, karena anak kucing belum mampu mengatur suhu tubuhnya dengan baik. Selain itu, lingkungan yang bersih dapat mencegah infeksi dan penyakit.\r\n\r\nVaksinasi dan pemeriksaan kesehatan juga perlu dilakukan sejak dini. Anak kucing biasanya mulai mendapatkan vaksin pada usia tertentu sesuai anjuran dokter hewan. Hal ini penting untuk melindungi mereka dari penyakit berbahaya.\r\n\r\nSebagai pemilik, penting untuk memperhatikan perilaku anak kucing. Anak kucing yang sehat biasanya aktif, suka bermain, dan memiliki nafsu makan yang baik. Jika terlihat lemas, tidak mau makan, atau menunjukkan gejala tidak biasa, segera lakukan pemeriksaan ke dokter hewan.\r\n\r\nDengan perawatan yang penuh perhatian dan kasih sayang, anak kucing dapat tumbuh menjadi kucing dewasa yang sehat, kuat, dan aktif.', 'Anak kucing membutuhkan perhatian dan perawatan khusus agar dapat tumbuh sehat dan kuat. Pemahaman yang tepat sejak dini akan membantu mencegah berbagai masalah kesehatan.', 'education/thumbnails/1DWt0oT0T0oD7kVdIwO1PR6JNj1xek8BLPXV4Wgr.jpg', NULL, NULL, 'Pemula', NULL, 1, 5, '2026-03-01 23:31:33', '2026-04-29 13:20:33'),
(4, 'Pemeriksaan Rutin Anjing: Kunci Menjaga Kesehatan Hewan Peliharaan', 'training', 'video', 'Pemeriksaan rutin adalah langkah penting dalam menjaga kesehatan anjing peliharaan. Banyak penyakit pada anjing tidak langsung menunjukkan gejala yang jelas, sehingga sering kali baru terdeteksi saat kondisinya sudah cukup parah. Dengan pemeriksaan berkala, potensi masalah kesehatan dapat diketahui lebih awal dan ditangani dengan cepat.\r\n\r\nDalam pemeriksaan rutin, dokter hewan biasanya akan mengecek kondisi fisik anjing secara menyeluruh. Hal ini meliputi pemeriksaan berat badan, suhu tubuh, kondisi mata, telinga, gigi, serta kulit dan bulu. Selain itu, dokter juga dapat memeriksa detak jantung dan pernapasan untuk memastikan semuanya dalam kondisi normal.\r\n\r\nVaksinasi juga menjadi bagian penting dari pemeriksaan rutin. Vaksin membantu melindungi anjing dari berbagai penyakit berbahaya seperti rabies, distemper, dan parvovirus. Selain itu, pemberian obat cacing dan pencegahan kutu juga sering dilakukan secara berkala.\r\n\r\nFrekuensi pemeriksaan dapat disesuaikan dengan usia dan kondisi anjing. Anak anjing biasanya memerlukan pemeriksaan lebih sering, sementara anjing dewasa cukup diperiksa setiap 6 hingga 12 bulan sekali. Untuk anjing yang sudah tua, pemeriksaan rutin sangat dianjurkan agar kondisi kesehatannya tetap terpantau.\r\n\r\nSebagai pemilik, kamu juga memiliki peran penting dalam memantau kesehatan anjing di rumah. Perhatikan perubahan perilaku, nafsu makan, atau aktivitas harian. Jika terdapat hal yang tidak biasa, segera konsultasikan ke dokter hewan.\r\n\r\nDengan melakukan pemeriksaan rutin secara konsisten, kamu tidak hanya menjaga kesehatan anjing, tetapi juga meningkatkan kualitas hidupnya dalam jangka panjang.', 'Pemeriksaan rutin pada anjing sangat penting untuk mendeteksi penyakit sejak dini dan menjaga kesehatan secara keseluruhan. Dengan perawatan yang tepat, anjing dapat hidup lebih sehat, aktif, dan bahagia.', 'education/thumbnails/hkCU83Fdm9vUCUKKOK8WYvw8KDGh6N8cPpOB3K6e.jpg', 'https://youtu.be/nWXrEkdelTw?si=tHaSofLEMqWVVZc3', '6:19', 'Pemula', NULL, 1, 5, '2026-03-01 23:33:05', '2026-04-29 13:18:27'),
(5, 'Kucing Kutuan? Kenali Gejala dan Cara Mengatasinya', 'kesehatan', 'guide', 'Kutu adalah parasit kecil yang hidup di kulit dan bulu kucing dengan cara menghisap darah. Meskipun ukurannya sangat kecil, keberadaan kutu dapat menimbulkan ketidaknyamanan yang besar bagi kucing.\r\n\r\nSalah satu tanda paling umum kucing kutuan adalah sering menggaruk tubuhnya secara berlebihan. Selain itu, kucing juga bisa terlihat gelisah, sering menjilat atau menggigit bagian tubuh tertentu, terutama di area leher, punggung, dan pangkal ekor.\r\n\r\nJika diperhatikan lebih dekat, kamu mungkin akan menemukan bintik-bintik hitam kecil di kulit atau bulu kucing, yang merupakan kotoran kutu. Pada kasus yang lebih parah, kulit kucing bisa mengalami iritasi, kemerahan, bahkan luka akibat garukan terus-menerus.\r\n\r\nKucing yang mengalami infestasi kutu dalam jumlah banyak juga berisiko mengalami anemia, terutama pada anak kucing. Hal ini terjadi karena kutu menghisap darah secara terus-menerus.\r\n\r\nUntuk mengatasi masalah ini, penting menjaga kebersihan kucing dan lingkungannya. Mandikan kucing dengan sampo khusus anti-kutu, gunakan obat tetes atau obat kutu yang direkomendasikan oleh dokter hewan, serta rutin membersihkan tempat tidur dan area bermain kucing.\r\n\r\nPencegahan adalah langkah terbaik. Dengan perawatan rutin dan kebersihan yang terjaga, kucing dapat terhindar dari kutu dan tetap sehat serta aktif.', 'Kutu pada kucing adalah masalah umum yang dapat menyebabkan rasa gatal, iritasi kulit, hingga infeksi. Penting untuk mengenali tanda-tandanya sejak dini agar kucing tetap sehat dan nyaman.', 'education/thumbnails/4c0V9V6hOvg1DpjhDsl70sle73ijVkVM2N8dVAuD.png', NULL, NULL, 'Pemula', NULL, 1, 11, '2026-03-02 00:51:10', '2026-04-29 13:15:22'),
(6, 'Gejala yang ada pada anjing rabies', 'perilaku', 'video', 'Rabies adalah penyakit berbahaya yang menyerang sistem saraf dan dapat menular ke manusia. Penyakit ini disebabkan oleh virus yang biasanya ditularkan melalui gigitan hewan yang terinfeksi, seperti anjing.\r\n\r\nPada tahap awal, anjing yang terkena rabies biasanya menunjukkan perubahan perilaku. Anjing yang biasanya jinak bisa menjadi lebih agresif, mudah marah, atau justru menjadi pendiam dan menyendiri. Nafsu makan juga dapat menurun, dan hewan terlihat gelisah.\r\n\r\nSeiring perkembangan penyakit, gejala menjadi lebih jelas. Anjing dapat mengalami kesulitan menelan, sehingga air liur keluar secara berlebihan (terlihat seperti mulut berbusa). Selain itu, anjing bisa menunjukkan perilaku menggigit tanpa sebab dan takut terhadap air (hidrofobia).\r\n\r\nPada tahap lanjut, anjing akan mengalami kelumpuhan, terutama pada bagian kaki belakang, yang kemudian menyebar ke seluruh tubuh. Jika tidak ditangani, kondisi ini hampir selalu berujung pada kematian.\r\n\r\nKarena rabies sangat berbahaya dan menular, sangat penting untuk segera menjauh dari hewan yang menunjukkan gejala tersebut dan melaporkannya kepada pihak berwenang atau dokter hewan. Vaksinasi secara rutin adalah langkah terbaik untuk mencegah rabies pada hewan peliharaan.', 'Gejala apa saja si yang dimiliki oleh anjing yang terkena rabies', 'education/thumbnails/S7Pfe1ljquhix2YJrwHRPGFfVyLbj2ucBANULuDN.jpg', 'https://youtu.be/g856w2MLLLY?si=4VhPHNOmeu1WrEEa', '2:18', 'Menengah', '30', 1, 1, '2026-04-29 02:17:46', '2026-04-29 13:10:14');

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
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'consultation',
  `consultation_id` bigint UNSIGNED DEFAULT NULL,
  `service_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `name`, `rating`, `message`, `source`, `consultation_id`, `service_type`, `transaction_id`, `is_verified`, `created_at`, `updated_at`) VALUES
(2, 'davi', 5, 'kliniknya bagus', 'consultation', NULL, NULL, NULL, 1, '2025-12-23 02:52:32', '2025-12-23 02:52:32'),
(5, 'Saif Ali Mushaddiq', 5, 'keren bang', 'consultation', NULL, NULL, NULL, 1, '2026-04-12 19:44:06', '2026-04-12 19:44:06'),
(9, 'ali', 4, 'tggfgdfgdgsggdfgdgdf', 'consultation', NULL, NULL, NULL, 1, '2026-04-14 08:49:56', '2026-04-14 08:49:56');

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
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_rekam_medis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_booking_id` bigint UNSIGNED NOT NULL,
  `nama_pemilik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_hewan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_hewan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ras` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciri_warna` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur` int NOT NULL,
  `berat_badan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suhu_tubuh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keluhan_utama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnosa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prognosa` text COLLATE utf8mb4_unicode_ci,
  `tindakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `resep_obat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `catatan_dokter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dokter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pemeriksaan` date NOT NULL,
  `kunjungan_berikutnya` date DEFAULT NULL,
  `status` enum('selesai','rawat','kontrol') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'selesai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`id`, `kode_rekam_medis`, `service_booking_id`, `nama_pemilik`, `alamat`, `telepon`, `nama_hewan`, `jenis_hewan`, `ras`, `ciri_warna`, `jenis_kelamin`, `umur`, `berat_badan`, `suhu_tubuh`, `keluhan_utama`, `diagnosa`, `prognosa`, `tindakan`, `resep_obat`, `catatan_dokter`, `dokter`, `tanggal_pemeriksaan`, `kunjungan_berikutnya`, `status`, `created_at`, `updated_at`) VALUES
(3, 'RM20260414001', 31, 'Saif Ali Mushaddiq', 'Tenajar Lor, Kec. Kertasemaya, Kab Indramayu', '083101498510', 'amau', 'Kucing', 'persia', 'oren', 'Jantan', 2, '22', '22.1', 'nn', 'kk', '', NULL, NULL, NULL, 'drh. Roza Albate Chandra Adila - Umum', '2026-04-14', NULL, 'selesai', '2026-04-14 09:00:15', '2026-04-14 09:00:15'),
(4, 'RM20260416001', 45, 'lukman', 'ddddddddddddddddddddddd', '00000008888', 'yy', 'Kucing', 'indian', 'dsadsa', 'Jantan', 6, '32', '44', 'dsfsd', 'fdssfdsf', 'fdsfds', 'fdsf', 'fdsfs', NULL, 'project3 sensor jarak ultrasonic(HC-SR04) - hewan', '2026-04-16', NULL, 'selesai', '2026-04-15 20:36:05', '2026-04-15 20:36:05'),
(5, 'RM20260419001', 55, 'hhhhhh', 'sjdhhdjdnmsj', '6494884', 'jshsvvd', 'Kucing', 'hshsbbd', 'gsshsb', 'Betina', 3, '0.1', '0.2', 'jj', 'jkk', 'n', 'm', 'nn', 'nnnn', 'drh. Arundhina Girishanta M.Si - Umum', '2026-04-19', '2026-04-20', 'selesai', '2026-04-18 22:36:22', '2026-04-18 22:36:22'),
(6, 'RM20260419002', 62, 'iii', 'hhggbbmn', '3333333', 'hhbbb', 'Kucing', 'hbb', 'hbbv', 'Betina', 3, '8', '6.8', 'j', 'n', 'j', 'k', 'n', 'b', 'drh. Roza Albate Chandra Adila - Umum', '2026-04-19', NULL, 'selesai', '2026-04-18 22:51:37', '2026-04-18 22:51:37'),
(7, 'RM20260420001', 65, 'Saif Ali Mushaddiq', 'fvgbbbbb', '0525588855455', 'hhggb', 'Anjing', 'hhh', 'ggh', 'Betina', 55, '8.8', '8', 'uu', 'j', 'k', 'h', 'k', 'n', 'project3 sensor jarak ultrasonic(HC-SR04) - hewan', '2026-04-20', '2026-04-22', 'selesai', '2026-04-20 06:11:28', '2026-04-20 06:11:28'),
(8, 'RM20260420002', 66, 'Saif Ali Mushaddiq', 'uuyu', '999', 'hhbb', 'Kucing', 'hbb', 'vvbb', 'Jantan', 3, '0', '0', 'jkkkkkkkkk', 'kena kangkener', 'ululuuu', NULL, NULL, NULL, 'drh. Arundhina Girishanta M.Si - Umum', '2026-04-20', '2026-04-16', 'selesai', '2026-04-20 06:36:09', '2026-04-20 06:36:09'),
(9, 'RM20260420003', 67, 'Saif Ali Mushaddiq', 'yyyy', '999', 'yyy', 'Kucing', 'ggg', 'gggg', 'Betina', 3, '80', '90', 'sakit tulang', 'kronis', 'huiii', 'makan', 'yakult', 'bio', 'Saif Ali Mushaddiq - m', '2026-04-20', NULL, 'selesai', '2026-04-20 06:57:52', '2026-04-20 06:57:52'),
(10, 'RM20260429001', 68, 'ali', 'alatvvc', '3333333', 'dggg', 'Kucing', 'dgvc', 'dggf', 'Jantan', 5, '4.8', '34.6', 'kejang dan panas', 'epilepsi idiopatik', '', NULL, NULL, 'jangan di mandikan dulu', 'drh. Roza Albate Chandra Adila - Umum', '2026-04-29', NULL, 'selesai', '2026-04-28 21:33:35', '2026-04-28 21:33:35'),
(11, 'RM20260429002', 69, 'zero ber', 'gggbnn', '0888888', 'amau', 'Kucing', 'persia', 'coklat', 'Jantan', 5, '40', '90', 'sesak dan batuk', 'bronkitis', 'alveolus', 'suntik vitamin', NULL, 'jangan kena asap apapun itu', 'Saif Ali Mushaddiq - m', '2026-04-29', NULL, 'selesai', '2026-04-28 22:24:49', '2026-04-28 22:24:49'),
(12, 'RM20260429003', 63, 'xxx', 'ggc', '3333333333', 'ggh', 'Kucing', 'hhbb', 'c', 'Jantan', 3, '2', '3', 'ww', 'ww', 'w', 'w', 'w', 'w', 'drh. Arundhina Girishanta M.Si - Umum', '2026-04-29', NULL, 'selesai', '2026-04-28 22:49:44', '2026-04-28 22:49:44'),
(13, 'RM20260429004', 70, 'zero ber', 'hhsjjd', '3666', 'jejsh', 'Kucing', 'isjshsh', 'jdhdb', 'Jantan', 659595, '3', '3', '3', '3', '3', '3', '3', NULL, 'drh. Roza Albate Chandra Adila - Umum', '2026-04-29', NULL, 'selesai', '2026-04-28 22:53:03', '2026-04-28 22:53:03'),
(14, 'RM20260429005', 71, 'Saif Ali', 'yhhhh', '083101498510', 'hbbb', 'Kucing', 'hhh', 'hhh', 'Jantan', 6, '0', '7', 'i', 'h', 'k', 'lllllllll', NULL, NULL, 'drh. Roza Albate Chandra Adila - Umum', '2026-04-29', NULL, 'selesai', '2026-04-28 22:59:38', '2026-04-28 22:59:38');

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
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_03_111839_create_pelanggan_table', 1),
(5, '2025_10_15_113650_create_consultations_table', 1),
(6, '2025_10_15_141211_create_appointments_table', 1),
(7, '2025_10_17_125428_create_service_bookings_table', 1),
(8, '2025_10_18_122458_create_medical_records_table', 1),
(9, '2025_10_18_122711_create_vaccination_records_table', 1),
(10, '2025_10_20_110526_create_feedbacks_table', 2),
(11, '2025_10_24_020359_create_admins_table', 3),
(12, '2025_11_07_020422_create_articles_table', 4),
(13, '2025_11_16_035517_create_doctors_table', 5),
(14, '2025_11_16_062009_create_education_table', 5),
(15, '2025_11_20_200802_create_services_table', 6),
(16, '2025_12_05_010850_create_services_table', 7),
(17, '2025_12_08_171753_create_services_table', 8),
(18, '2025_12_10_035443_add_service_slug_and_price_to_service_bookings', 9),
(19, '2025_12_10_071442_add_missing_columns_to_service_bookings_table', 10),
(20, '2025_12_11_100200_add_status_to_service_bookings', 11),
(21, '2025_12_14_061415_add_is_read_to_feedbacks_table', 12),
(22, '2025_12_18_104050_create_services_table', 13),
(23, '2025_12_18_113544_create_services_table', 14),
(24, '2025_12_19_013459_add_service_id_to_service_bookings', 15),
(25, '2025_12_19_014407_add_service_id_and_total_price_to_service_bookings', 16),
(26, '2025_12_19_042942_add_service_fields_to_service_bookings', 17),
(27, '2025_12_20_212208_add_is_active_to_doctors_table', 18),
(28, '2025_12_21_194355_create_consultations_table', 19),
(29, '2025_12_21_194432_create_feedbacks_table', 19),
(30, '2026_02_16_091937_add_doctor_id_to_service_bookings_table', 20),
(31, '2026_02_16_093936_drop_doctor_column_from_service_bookings_table', 20),
(32, '2026_04_14_141800_add_details_to_service_bookings_table', 21),
(33, '2026_04_14_141803_add_details_to_medical_records_table', 21),
(34, '2026_04_16_000000_add_google_id_to_users_table', 22),
(35, '2026_04_16_041811_create_personal_access_tokens_table', 23),
(36, '2026_04_16_000001_add_phone_to_users_table', 24),
(37, '2026_04_19_111500_add_otp_code_to_users_table', 25),
(38, '2026_04_19_120600_add_user_id_to_service_bookings', 26),
(39, '2026_04_19_120700_create_chat_messages_table', 26),
(40, '2026_04_20_000000_add_fcm_token_to_users_table', 27),
(41, '2026_04_29_170100_add_role_to_users_and_link_to_doctors', 28),
(42, '2026_04_29_170500_create_consultation_sessions_and_messages', 28),
(43, '2026_04_29_172300_add_email_to_doctors_table', 29);

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
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(9, 'App\\Models\\User', 35, 'auth_token', '68b35e4de7dbffdd14d2f1cc3895c9383f808dc8fb3a1be8f255e855eb36e8a9', '[\"*\"]', '2026-04-18 21:52:45', NULL, '2026-04-18 21:51:53', '2026-04-18 21:52:45'),
(43, 'App\\Models\\User', 30, 'auth_token', '068f38ec26073cd5f485e1f7423768a64441cd03eb7a58a3238b4d43c256f8c7', '[\"*\"]', '2026-04-29 14:41:12', NULL, '2026-04-29 11:59:47', '2026-04-29 14:41:12'),
(50, 'App\\Models\\User', 41, 'auth_token', '5bb386cecbf85446002b20d7169ba1d4bdc660e00272103e34fe8bbd842fddd9', '[\"*\"]', '2026-04-30 07:11:09', NULL, '2026-04-30 06:59:31', '2026-04-30 07:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL COMMENT 'Durasi dalam menit',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Detail lengkap layanan',
  `service_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `slug`, `description`, `icon`, `price`, `duration_minutes`, `details`, `service_type`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Vaksinasi', 'vaksinasi', 'Program vaksinasi lengkapuntuk melindungi hewan dari berbagai penyakit', 'fas fa-stethoscope', '150000.00', 30, 'Layanan Program Vaksinasi Lengkap bertujuan untuk melindungi hewan peliharaan Anda dari berbagai penyakit menular yang berbahaya serta membantu menjaga daya tahan tubuh hewan agar tetap sehat dan kuat.\r\n\r\nMelalui vaksinasi yang terjadwal dan tepat, kami membantu mencegah penyakit serius yang dapat mengancam kesehatan dan keselamatan hewan kesayangan Anda.', 'vaccination', 1, 1, '2025-12-18 04:56:41', '2025-12-21 05:42:15'),
(2, 'Perawatan Gigi', 'perawatan-gigi', 'Pembersihan gigi dan perawatan kesehatan mulut untuk hewan kesayangan', 'fas fa-tooth', '250000.00', 45, 'Layanan Perawatan Gigi dan Kesehatan Mulut bertujuan untuk menjaga kebersihan gigi serta kesehatan mulut hewan kesayangan Anda agar terhindar dari masalah seperti penumpukan karang gigi, bau mulut, radang gusi, hingga infeksi yang dapat memengaruhi kesehatan tubuh secara keseluruhan.', 'dental', 1, 1, '2025-12-20 23:05:26', '2025-12-21 05:39:15'),
(3, 'Konsultasi Umum', 'konsultasi-umum', 'Pemeriksaan kesehatan rutin dan Konsultasi untuk hewan peliharaan Anda', 'fas fa-stethoscope', '80000.00', 45, 'Layanan Konsultasi Umum Hewan kami hadir untuk membantu Anda menjaga kesehatan dan kesejahteraan hewan peliharaan secara menyeluruh. Melalui pemeriksaan kesehatan rutin dan konsultasi langsung, kami membantu mendeteksi masalah kesehatan sejak dini serta memberikan solusi yang tepat sesuai kondisi hewan Anda.', 'general', 1, 1, '2025-12-21 05:34:56', '2025-12-21 05:35:30'),
(4, 'Grooming', 'grooming', 'Perawatan kebersihan lengkap mandi, potong kuku, dan sisir bulu', 'fas fa-shower', '120000.00', 40, 'Layanan Grooming atau Perawatan Kebersihan Lengkap kami dirancang untuk menjaga kebersihan, kesehatan, dan penampilan hewan kesayangan Anda agar tetap nyaman, sehat, dan terlihat terawat.', 'grooming', 1, 0, '2025-12-21 05:53:57', '2025-12-23 02:36:15'),
(5, 'Pemeriksaan Darah', 'pemeriksaan-darah', 'Tes darah lengkap untuk mendiagnosis kondisi kesehatan hewan', 'fas fa-heartbeat', '250000.00', 40, 'Layanan Tes Darah Lengkap bertujuan untuk membantu mendiagnosis kondisi kesehatan hewan peliharaan secara akurat dan menyeluruh. Pemeriksaan ini sangat penting untuk mendeteksi penyakit sejak dini, memantau kondisi kesehatan, serta mendukung penanganan medis yang tepat.', 'general', 1, 0, '2025-12-21 05:57:16', '2025-12-21 05:57:16'),
(6, 'sterilisasi', 'sterilisasi', 'Tindakan sterilisasi untuk mengontrol populasi dan kesehatan hewan', 'fas fa-cut', '200000.00', 120, 'Tindakan sterilisasi untuk mengontrol populasi dan kesehatan hewan', 'general', 1, 0, '2025-12-21 07:07:05', '2025-12-21 13:01:19');

-- --------------------------------------------------------

--
-- Table structure for table `service_bookings`
--

CREATE TABLE `service_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama_pemilik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_hewan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_hewan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ras` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciri_warna` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur` int NOT NULL,
  `service_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `doctor_id` bigint UNSIGNED DEFAULT NULL,
  `service_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_price` decimal(10,2) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `booking_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `booking_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_antrian` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_bookings`
--

INSERT INTO `service_bookings` (`id`, `user_id`, `nama_pemilik`, `email`, `telepon`, `alamat`, `nama_hewan`, `jenis_hewan`, `ras`, `ciri_warna`, `jenis_kelamin`, `umur`, `service_type`, `service_id`, `doctor_id`, `service_slug`, `service_price`, `booking_date`, `booking_time`, `catatan`, `total_price`, `status`, `booking_code`, `nomor_antrian`, `created_at`, `updated_at`) VALUES
(27, NULL, 'fasido', 'fd@gmail.com', '745375784787', NULL, 'tr', 'Anjing', 'retvier', NULL, NULL, 12, 'general', 6, NULL, NULL, NULL, '2025-12-24', '11:00', 'kjhhhkhk', '200000.00', 'cancelled', 'KON20251224001', 1, '2025-12-22 03:16:13', '2025-12-22 03:17:22'),
(29, NULL, 'Davi', 'davi@gmail.com', '0897647483', NULL, 'Rabith', 'Kucing', 'Persian', NULL, NULL, 6, 'general', 6, NULL, NULL, NULL, '2025-12-25', '11:00', 'ga mau makan', '200000.00', 'completed', 'KON20251225001', 1, '2025-12-23 02:55:14', '2025-12-23 02:57:30'),
(31, 36, 'Saif Ali Mushaddiq', 'alimushaddiq13@gmail.com', '083101498510', NULL, 'amau', 'Kucing', 'persia', NULL, NULL, 2, 'vaccination', 1, 1, NULL, NULL, '2026-04-17', '13:00', 'dd', '150000.00', 'completed', 'VKS20260417001', 1, '2026-04-01 08:53:58', '2026-04-27 23:36:16'),
(33, 36, 'Saif Ali Mushaddiq', 'alimushaddiq13@gmail.com', '083101498510', NULL, 'amau', 'Kucing', 'persia', NULL, NULL, 6, 'dental', 2, 1, NULL, NULL, '2026-04-03', '13:00', 'gigi', '250000.00', 'pending', 'GIG20260403001', 1, '2026-04-01 09:01:08', '2026-04-27 23:36:16'),
(35, 36, 'Saif Ali', 'alimushaddiq13@gmail.com', '0831014498510', NULL, 'karin', 'Kucing', 'persia', NULL, NULL, 2, 'grooming', 4, 2, NULL, NULL, '2026-04-09', '10:00', 'sakit', '120000.00', 'pending', 'BK-20260406-001', 1, '2026-04-06 01:02:17', '2026-04-27 23:36:16'),
(42, 36, 'saif', 'alimushaddiq13@gmail.com', '6666666666', NULL, 'hh', 'Kucing', 'persia', NULL, NULL, 6, 'grooming', 4, 1, NULL, NULL, '2026-04-08', '13:00', 'sakit bu', '120000.00', 'pending', 'BK-20260406-002', 1, '2026-04-06 01:22:27', '2026-04-27 23:36:16'),
(43, 36, 'azhar', 'alimushaddiq13@gmail.com', '666666666', NULL, 'rapli', 'Kucing', 'polindra', NULL, NULL, 3, 'general', 5, 2, NULL, NULL, '2026-04-07', '10:00', 'demam', '250000.00', 'pending', 'BK-20260406-003', 1, '2026-04-06 01:34:06', '2026-04-27 23:36:16'),
(45, 36, 'lukman', 'alimushaddiq13@gmail.com', '00000008888', NULL, 'yy', 'Kucing', 'indian', NULL, NULL, 6, 'grooming', 4, 6, NULL, NULL, '2026-04-16', '09:00', 'gg', '120000.00', 'completed', 'BK-20260414-001', 1, '2026-04-13 21:27:54', '2026-04-27 23:36:16'),
(46, NULL, 'karin', 'karinasiti2101@gmail.com', '083110050163', NULL, 'saif', 'Kucing', 'persia', NULL, NULL, 3, 'grooming', 4, 1, NULL, NULL, '2026-04-15', '09:00', 'vzhags', '120000.00', 'pending', 'BK-20260414-002', 1, '2026-04-13 21:33:16', '2026-04-13 21:33:16'),
(50, 36, 'Saif Ali Mushaddiq', 'alimushaddiq13@gmail.com', '083101498510', 'Tenajar Lor, Kec. Kertasemaya, Kab Indramayu', 'amau', 'Anjing', 'sdsadas', 'oren', 'Jantan', 3, 'general', 5, 1, NULL, NULL, '2026-04-16', '14:00', NULL, '250000.00', 'pending', 'KON20260416001', 1, '2026-04-14 08:49:23', '2026-04-27 23:36:16'),
(51, NULL, 'fff', 'ali@ghnndc.com', '58875887880', NULL, 'yyyy', 'Kucing', 'fggg', NULL, NULL, 2, 'general', 5, 6, NULL, NULL, '2026-04-17', '10:00', 'ffgcxggg', '250000.00', 'confirmed', 'BK-20260415-001', 1, '2026-04-15 05:25:09', '2026-04-15 05:26:53'),
(52, 36, 'Saif Ali Mushaddiq', 'alimushaddiq13@gmail.com', '083101498510', 'Tenajar Lor, Kec. Kertasemaya, Kab Indramayu', 'sdsajkdlhsiaa', 'Kucing', 'sdsadas', 'oren', 'Jantan', 7, 'general', 6, 6, NULL, NULL, '2026-04-17', '13:00', NULL, '200000.00', 'pending', 'KON20260417001', 1, '2026-04-15 06:02:03', '2026-04-27 23:36:16'),
(53, NULL, 'f', 'ffgg@hhbb', '55558', NULL, 'fgf', 'Kucing', 'fgg', NULL, NULL, 2, 'general', 5, 1, NULL, NULL, '2026-04-16', '11:00', NULL, '250000.00', 'pending', 'BK-20260415-002', 2, '2026-04-15 06:05:00', '2026-04-15 06:05:00'),
(54, NULL, 'j', 'j@mkn', '3699', 'hhh', 'nnn', 'Kucing', 'nnn', 'nnn', 'Jantan', 3, 'vaccination', 1, 1, NULL, NULL, '2026-04-16', '09:00', NULL, '150000.00', 'pending', 'BK-20260415-003', 3, '2026-04-15 06:22:40', '2026-04-15 06:22:40'),
(55, NULL, 'hhhhhh', 'hgsga@gmsislkdnn', '6494884', 'sjdhhdjdnmsj', 'jshsvvd', 'Kucing', 'hshsbbd', 'gsshsb', 'Betina', 3, 'grooming', 4, 7, NULL, NULL, '2026-04-20', '11:00', 'hhhh', '120000.00', 'completed', 'BK-20260419-001', 1, '2026-04-18 21:02:46', '2026-04-18 22:35:40'),
(56, NULL, 'h', 'hsns@gmaik.com', '319484840', 'jshsvsvbsbs', 'ishshsb', 'Kucing', 'hshsbsb', 'bajagvs', 'Betina', 3, 'grooming', 4, 6, NULL, NULL, '2026-04-20', '09:00', NULL, '120000.00', 'pending', 'BK-20260419-002', 2, '2026-04-18 22:34:03', '2026-04-18 22:34:03'),
(62, NULL, 'iii', 'i@gmail.com', '3333333', 'hhggbbmn', 'hhbbb', 'Kucing', 'hbb', 'hbbv', 'Betina', 3, 'grooming', 4, 1, NULL, NULL, '2026-04-21', '10:00', NULL, '120000.00', 'completed', 'BK-20260421-001', 1, '2026-04-18 22:50:08', '2026-04-18 22:51:12'),
(63, NULL, 'xxx', 'x@gmail.com', '3333333333', 'ggc', 'ggh', 'Kucing', 'hhbb', 'c', 'Jantan', 3, 'vaccination', 1, 1, NULL, NULL, '2026-04-21', '14:00', NULL, '150000.00', 'completed', 'BK-20260421-002', 2, '2026-04-18 23:03:51', '2026-04-28 22:49:11'),
(64, NULL, 'amet kopling', 'ametkopling@gmail.com', '085797460885', 'Indramayu barat dayak', 'momol', 'Kucing', 'mongolia', 'coklat', 'Jantan', 2, 'vaccination', 1, 1, NULL, NULL, '2026-04-21', '14:00', 'sering tidur', '150000.00', 'pending', 'BK-20260421-003', 3, '2026-04-20 01:14:57', '2026-04-20 01:14:57'),
(65, 30, 'Saif Ali Mushaddiq', 'saifali.musy@gmail.com', '0525588855455', 'fvgbbbbb', 'hhggb', 'Anjing', 'hhh', 'ggh', 'Betina', 55, 'general', 5, 1, NULL, NULL, '2026-04-21', '11:00', 'hhg', '250000.00', 'completed', 'BK-20260421-004', 4, '2026-04-20 06:08:11', '2026-04-20 06:26:00'),
(66, 30, 'Saif Ali Mushaddiq', 'saifali.musy@gmail.com', '999', 'uuyu', 'hhbb', 'Kucing', 'hbb', 'vvbb', 'Jantan', 3, 'general', 6, 1, NULL, NULL, '2026-04-21', '09:00', NULL, '200000.00', 'completed', 'BK-20260421-005', 5, '2026-04-20 06:34:32', '2026-04-20 06:36:18'),
(67, 30, 'Saif Ali Mushaddiq', 'saifali.musy@gmail.com', '999', 'yyyy', 'yyy', 'Kucing', 'ggg', 'gggg', 'Betina', 3, 'vaccination', 1, 6, NULL, NULL, '2026-04-21', '10:00', 'haii', '150000.00', 'completed', 'BK-20260421-006', 6, '2026-04-20 06:55:29', '2026-04-20 06:58:18'),
(68, 36, 'ali', 'alimushaddiq13@gmail.com', '3333333', 'alatvvc', 'dggg', 'Kucing', 'dgvc', 'dggf', 'Jantan', 5, 'grooming', 4, 1, NULL, NULL, '2026-04-30', '09:00', NULL, '120000.00', 'completed', 'BK-20260430-001', 1, '2026-04-28 21:29:39', '2026-04-28 21:33:49'),
(69, 39, 'zero ber', 'zeerober77@gmail.com', '0888888', 'gggbnn', 'amau', 'Kucing', 'persia', 'coklat', 'Jantan', 5, 'general', 3, 1, NULL, NULL, '2026-04-30', '15:00', NULL, '80000.00', 'completed', 'BK-20260430-002', 2, '2026-04-28 22:21:35', '2026-04-28 22:24:52'),
(70, 39, 'zero ber', 'zeerober77@gmail.com', '3666', 'hhsjjd', 'jejsh', 'Kucing', 'isjshsh', 'jdhdb', 'Jantan', 659595, 'vaccination', 1, 1, NULL, NULL, '2026-04-30', '09:00', NULL, '150000.00', 'completed', 'BK-20260430-003', 3, '2026-04-28 22:52:01', '2026-04-28 22:56:59'),
(71, 27, 'Saif Ali', 'mrzone44@gmail.com', '083101498510', 'yhhhh', 'hbbb', 'Kucing', 'hhh', 'hhh', 'Jantan', 6, 'vaccination', 1, 1, NULL, NULL, '2026-04-30', '09:00', NULL, '150000.00', 'completed', 'BK-20260430-004', 4, '2026-04-28 22:58:35', '2026-04-29 02:04:26');

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
('3ZdEuvawiHAp5QPKGb6j39VSV5tIMTmXKkXS3Ijb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUjhkQnVIY0U4VGlOWmJNZndVbURPZmJzODBPWGtFdUhQd0dxbkJHTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777629548),
('JjcSONbMUBsQBpqlnUX2EN334HxezgE4cog4NjO2', 3, '10.126.95.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMXBUR3FUOE9HeUlCZlB4REFXSVZWNDhrVEJJbmhmMFBpb2hTeWhJVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMC4xMjYuOTUuOTA6ODAwMC9hZG1pbi9kb2N0b3JzIjt9czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1777468994),
('rOFiKTNhzLNNWb4MEEAwe2o7fNOW7OaOXmcKLxfj', 3, '10.0.164.95', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMTNXU1hMdGxXY2p1YzlEY3R4QVl4OWZ5dXBOZFJNUGtSMHNSYzJoQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMC4wLjE2NC45NTo4MDAwL2FkbWluL2RvY3RvcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1777532050);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcm_token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `otp_code` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `google_id`, `avatar`, `email_verified_at`, `password`, `remember_token`, `fcm_token`, `created_at`, `updated_at`, `otp_code`) VALUES
(26, 'Saif Ali', 'saifaliiii802@gmail.com', '083101498510', 'doctor', '116384854872778738858', 'http://10.126.95.90:8000/storage/avatars/yPsVrJFGoRhO7udkXFyPGbtxNVJxtmBovlta2VEm.jpg', NULL, '$2y$12$7ZCBg5eCxO825dlnikW7ZusGIlYfOTXAqp8ouKVnJ4YtqSj.e03sC', NULL, NULL, '2026-04-15 21:12:31', '2026-04-29 11:57:29', NULL),
(27, 'Saif Ali', 'mrzone44@gmail.com', '083101498510', 'user', '113649091032644969356', 'http://10.126.95.90:8000/storage/avatars/72FjEsjIuSRvmDH1h9VWBET2hONHsS0TfRt3riRd.jpg', NULL, '$2y$12$oFobLjNFUDadMlLDRoskpeIiWZNBtkwQWJVJc3wz/tbhDSkxfbNDq', NULL, NULL, '2026-04-18 20:24:22', '2026-04-29 11:57:29', NULL),
(28, 'Ali Aja', 'ali@gmail.com', '646948484', 'user', NULL, 'http://192.168.1.8:8000/storage/avatars/I6MUHKQxq6UOVeLaQY2X5sEFZJo7Jpzxw5hZ144F.jpg', NULL, '$2y$12$13HVHrJA3XiLTH5jGxpWEOz3M7VwR7lwPwk4417Fk3/4vm27OkMAi', NULL, NULL, '2026-04-18 20:51:31', '2026-04-18 20:52:18', NULL),
(30, 'Saif Ali Mushaddiq', 'saifali.musy@gmail.com', '08888', 'user', '104576581296830160979', 'http://10.126.95.90:8000/storage/avatars/03Gefbk9C2NRwSyK8DKUiiLKg6uRP2kFwPwDuN5D.jpg', NULL, '$2y$12$UTtMFd.4KOJ33O0vXiGWd.TdSlzJknXQgl9UP4TX07Nnsu/Y5yNQq', NULL, 'dCVFXCtGQ76GYx3yHLvkmW:APA91bFQRTg0lEHiOUx1JqMb5x8MTmRGivMXF0p3sAsnqkAC43DBBsTDiZeV5OLZbPpXvbl1gGkGxCNXGJtd5eJP6a5yrajVD9a63Ds8cLPSEUpm5YuDn5c', '2026-04-18 21:18:02', '2026-04-29 11:59:48', NULL),
(36, 'ali', 'alimushaddiq13@gmail.com', '3333333', 'doctor', '114568845379898358161', 'https://lh3.googleusercontent.com/a/ACg8ocL4bsBOb_JuYr_45Ji84mN5vqR4jTwfFePsD4Gc1c75gu4YFg=s96-c', NULL, '$2y$12$J9SJFhe0T293WpDwNQvR1e0bSOafs0l4QBzMoxWOTeRKv4injce2i', NULL, NULL, '2026-04-20 00:01:55', '2026-04-29 11:59:39', NULL),
(37, 'Hafiz Nugraha', 'hafiz@gmail.com', NULL, 'user', NULL, 'http://10.0.164.95:8000/storage/avatars/KYZcvfYnO3N06Qu6FtjpeVNspTFoTywj3JFN1X2Y.jpg', '2026-04-20 00:05:09', '$2y$12$lAlzw4s/pvASE/Bt.G/bHe1vVdT9aPN4XDPSd7d4U7J5eevKyP2PK', NULL, NULL, '2026-04-20 00:04:38', '2026-04-20 00:08:53', NULL),
(38, 'Saif Ali Mushaddiq', 'sfali24@student.polindra.ac.id', NULL, 'user', '114373558361646603508', 'http://10.126.95.90:8000/storage/avatars/t8LLd6liggYKrspmA0jfb9JRzrx1C1lu7GhXeXZN.jpg', NULL, '$2y$12$TCOGW4koTG/X4mHXpaGUo.n7WHZJLKWgkYgklS7MR3ninwAJ.hnBu', NULL, NULL, '2026-04-27 23:54:32', '2026-04-28 20:04:57', NULL),
(39, 'zero ber', 'zeerober77@gmail.com', NULL, 'user', '106601645172663402600', 'https://lh3.googleusercontent.com/a/ACg8ocLdzoZVRv4mKFjI9vEItkG-ODDfUOr2_Yc5ajhuadYRY4i3_g=s96-c', NULL, '$2y$12$nYxdQojQeTRoquZ6csut3.2HuoJyaEZq4qlnnDIQH0JfgOfP42xny', NULL, NULL, '2026-04-28 21:39:32', '2026-04-28 21:39:32', NULL),
(40, 'Kasur', 'kasur0865@gmail.com', NULL, 'doctor', '115541865431657623308', 'https://lh3.googleusercontent.com/a/ACg8ocLrju5m4-h_y2sxbSg8niehs_Q7OjCZYt3a9NrKb4_yXZGUEQ=s96-c', NULL, '$2y$12$3/qzkpWO6x6P7HhNr/9cMu3ELnvhpPRj1g.reDkXdc6eF3PwR6MNm', NULL, NULL, '2026-04-30 06:43:08', '2026-04-30 06:50:30', NULL),
(41, 'azhr', 'garpuku9876@gmail.com', NULL, 'user', '108265634887088789611', 'http://10.0.164.95:8000/storage/avatars/5uzeGFl3rHFXHAE8ijicOi3qCmgl9s6RSjLvYwJc.png', NULL, '$2y$12$jXDVwCQrheedZT3AJ1yjwOH/2i378mWbbKIJjTU0mYa3rhylaxLgK', NULL, 'c7zESwTAS1q5pMsHOVAELP:APA91bFL58Qv_o-47vv-4hrtkV_7o_QdlAJN3kQWtGLRtrHSoVbV7M2yy1HxecvgxvoIZCeV0xtcapCgeC5euhAAlowPEYouI0tTbbYr5O1KDM1V-HuDv_Y', '2026-04-30 06:45:45', '2026-04-30 06:59:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_records`
--

CREATE TABLE `vaccination_records` (
  `id` bigint UNSIGNED NOT NULL,
  `medical_record_id` bigint UNSIGNED NOT NULL,
  `nama_vaksin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_vaksin` date NOT NULL,
  `tanggal_booster` date DEFAULT NULL,
  `dokter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vaccination_records`
--

INSERT INTO `vaccination_records` (`id`, `medical_record_id`, `nama_vaksin`, `dosis`, `tanggal_vaksin`, `tanggal_booster`, `dokter`, `catatan`, `created_at`, `updated_at`) VALUES
(3, 7, 'hh', '8\\/7', '2026-04-20', NULL, 'project3 sensor jarak ultrasonic(HC-SR04) - hewan', NULL, '2026-04-20 06:11:28', '2026-04-20 06:11:28');

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
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`);

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
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultations_email_index` (`email`),
  ADD KEY `consultations_created_at_index` (`created_at`);

--
-- Indexes for table `consultation_messages`
--
ALTER TABLE `consultation_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultation_messages_session_id_foreign` (`session_id`);

--
-- Indexes for table `consultation_sessions`
--
ALTER TABLE `consultation_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultation_sessions_user_id_foreign` (`user_id`),
  ADD KEY `consultation_sessions_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctors_email_unique` (`email`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedbacks_consultation_id_foreign` (`consultation_id`),
  ADD KEY `feedbacks_rating_index` (`rating`),
  ADD KEY `feedbacks_source_index` (`source`),
  ADD KEY `feedbacks_created_at_index` (`created_at`),
  ADD KEY `feedbacks_is_verified_index` (`is_verified`);

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
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medical_records_kode_rekam_medis_unique` (`kode_rekam_medis`),
  ADD KEY `medical_records_service_booking_id_foreign` (`service_booking_id`);

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
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pelanggan_email_unique` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`);

--
-- Indexes for table `service_bookings`
--
ALTER TABLE `service_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_bookings_booking_code_unique` (`booking_code`),
  ADD KEY `service_bookings_booking_date_status_index` (`booking_date`,`status`),
  ADD KEY `service_bookings_service_slug_booking_date_index` (`service_slug`,`booking_date`),
  ADD KEY `service_bookings_service_id_foreign` (`service_id`),
  ADD KEY `service_bookings_doctor_id_foreign` (`doctor_id`),
  ADD KEY `service_bookings_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vaccination_records`
--
ALTER TABLE `vaccination_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vaccination_records_medical_record_id_foreign` (`medical_record_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `consultation_messages`
--
ALTER TABLE `consultation_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `consultation_sessions`
--
ALTER TABLE `consultation_sessions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_bookings`
--
ALTER TABLE `service_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `vaccination_records`
--
ALTER TABLE `vaccination_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultation_messages`
--
ALTER TABLE `consultation_messages`
  ADD CONSTRAINT `consultation_messages_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `consultation_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultation_sessions`
--
ALTER TABLE `consultation_sessions`
  ADD CONSTRAINT `consultation_sessions_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultation_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_consultation_id_foreign` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_service_booking_id_foreign` FOREIGN KEY (`service_booking_id`) REFERENCES `service_bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_bookings`
--
ALTER TABLE `service_bookings`
  ADD CONSTRAINT `service_bookings_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `service_bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `service_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `vaccination_records`
--
ALTER TABLE `vaccination_records`
  ADD CONSTRAINT `vaccination_records_medical_record_id_foreign` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
