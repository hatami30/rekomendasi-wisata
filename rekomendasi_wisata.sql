-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 05 Bulan Mei 2024 pada 03.29
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rekomendasi_wisata`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama_kategori`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Pantai', 'pantai', '2024-03-08 05:11:24', '2024-03-08 05:11:24'),
(5, 'Makam', 'makam', '2024-03-09 02:49:32', '2024-03-09 02:49:32'),
(6, 'Air Terjun', 'air-terjun', '2024-03-09 02:56:03', '2024-03-09 02:56:03'),
(7, 'Danau', 'danau', '2024-03-10 04:45:04', '2024-03-10 04:45:04'),
(8, 'Air Panas', 'air-panas', '2024-03-14 07:28:40', '2024-03-14 07:28:40'),
(9, 'Penangkaran', 'penangkaran', '2024-03-18 01:36:14', '2024-03-18 01:36:14'),
(10, 'Mangrove', 'mangrove', '2024-03-18 05:48:36', '2024-03-18 05:48:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(35, '2024_03_06_150525_create_kategoris', 1),
(40, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(41, '2024_02_17_091716_create_users_table', 2),
(42, '2024_02_17_092218_add_role_to_users_table', 2),
(43, '2024_03_06_104228_create_wisatas_table', 2),
(44, '2024_03_08_114548_create_kategoris_table', 2),
(45, '2024_03_31_101145_create_ratings_table', 3),
(46, '2024_04_02_101302_add_average_column_to_ratings_table', 4),
(47, '2024_04_02_102303_truncate_ratings_table', 5),
(48, '2024_04_02_114359_truncate_ratings_table', 6),
(49, '2024_04_02_174149_add_coordinates_to_wisatas_table', 7),
(50, '2024_04_02_181911_add_coordinates_to_wisatas_table', 8),
(51, '2024_04_02_182353_drop_latitude_longitude_from_wisatas_table', 8),
(52, '2024_04_02_182517_add_coordinates_to_wisatas_table', 9),
(53, '2024_04_04_141217_truncate_ratings_table', 10),
(54, '2024_04_05_001825_create_password_reset_tokens_table', 11),
(55, '2024_04_05_023513_drop_password_reset_tokens_table', 12),
(56, '2024_04_05_023642_drop_password_reset_tokens_table', 13),
(57, '2024_04_05_023847_create_password_reset_tokens_table', 14),
(58, '2024_04_05_164452_create_password_reset_tokens_table', 15),
(59, '2024_04_09_072601_create_similarities_table', 16),
(60, '2024_04_09_072749_create_predictions_table', 17),
(61, '2024_05_01_093046_remove_timestamps_from_predictions_table', 18),
(62, '2024_05_01_093150_remove_timestamps_from_similarities_table', 18);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('anan@gmail.com', '2ptibNYSP4q1JpxeQghNucVoecOz571aDObiRruAm5QNvZGDP9CKEX67Iufp', '2024-04-05 18:55:19'),
('emailpremyt@gmail.com', 'h6LfrQ2eZ2O2wW2ht3IxuH3azOf9q9z3U0fOu3tMhpSndGed7ixYNFk8O0TJ', '2024-04-18 12:44:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `predictions`
--

CREATE TABLE `predictions` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_wisata` bigint UNSIGNED NOT NULL,
  `predicted` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `predictions`
--

INSERT INTO `predictions` (`id`, `id_user`, `id_wisata`, `predicted`) VALUES
(1, 7, 3, 0.00),
(2, 7, 10, 0.00),
(3, 7, 14, 0.00),
(4, 3, 9, 0.00),
(5, 3, 16, 0.00),
(6, 3, 25, 0.00),
(7, 3, 2, 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_wisata` bigint UNSIGNED NOT NULL,
  `harga` int DEFAULT NULL,
  `fasilitas` int DEFAULT NULL,
  `keamanan` int DEFAULT NULL,
  `kenyamanan` int DEFAULT NULL,
  `kebersihan` int DEFAULT NULL,
  `keindahan` int DEFAULT NULL,
  `pelayanan` int DEFAULT NULL,
  `average` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ratings`
--

INSERT INTO `ratings` (`id`, `id_user`, `id_wisata`, `harga`, `fasilitas`, `keamanan`, `kenyamanan`, `kebersihan`, `keindahan`, `pelayanan`, `average`, `created_at`, `updated_at`) VALUES
(1, 9, 10, 4, 5, 3, 4, 5, 5, 2, 4.00, '2024-05-01 02:54:03', '2024-05-01 02:54:03'),
(2, 9, 17, 4, 5, 4, 5, 4, 5, 3, 4.29, '2024-05-01 02:54:24', '2024-05-01 02:54:24'),
(3, 9, 23, 4, 4, 5, 4, 3, 5, 2, 3.86, '2024-05-01 02:54:43', '2024-05-01 02:54:43'),
(4, 9, 22, 4, 5, 4, 5, 3, 5, 3, 4.14, '2024-05-01 02:55:01', '2024-05-01 02:55:01'),
(5, 2, 2, 4, 5, 4, 3, 4, 5, 2, 3.86, '2024-05-01 02:55:28', '2024-05-01 02:55:28'),
(6, 2, 10, 3, 4, 5, 3, 5, 5, 2, 3.86, '2024-05-01 02:55:50', '2024-05-01 02:55:50'),
(7, 2, 25, 4, 5, 4, 5, 4, 5, 3, 4.29, '2024-05-01 02:56:16', '2024-05-01 02:56:16'),
(8, 4, 2, 4, 5, 4, 5, 4, 5, 3, 4.29, '2024-05-01 02:56:48', '2024-05-01 02:56:48'),
(9, 4, 14, 4, 5, 3, 4, 3, 5, 2, 3.71, '2024-05-01 02:57:06', '2024-05-01 02:57:06'),
(10, 4, 10, 4, 4, 3, 4, 4, 5, 3, 3.86, '2024-05-01 03:04:08', '2024-05-01 03:04:08'),
(11, 4, 23, 4, 5, 4, 5, 4, 5, 2, 4.14, '2024-05-01 03:10:00', '2024-05-01 03:10:00'),
(12, 7, 3, 4, 5, 3, 4, 5, 5, 2, 4.00, '2024-05-01 03:13:09', '2024-05-01 03:13:09'),
(13, 7, 14, 4, 4, 5, 5, 4, 5, 3, 4.29, '2024-05-01 03:13:24', '2024-05-01 03:13:24'),
(14, 7, 10, 4, 5, 4, 5, 3, 4, 3, 4.00, '2024-05-01 03:20:06', '2024-05-01 03:20:06'),
(15, 3, 9, 4, 5, 3, 5, 3, 4, 3, 3.86, '2024-05-01 10:33:15', '2024-05-01 10:33:15'),
(16, 3, 16, 4, 5, 3, 4, 3, 5, 3, 3.86, '2024-05-01 10:33:47', '2024-05-01 10:33:47'),
(17, 3, 25, 4, 3, 4, 3, 4, 5, 2, 3.57, '2024-05-01 10:34:17', '2024-05-01 10:34:17'),
(18, 3, 2, 4, 5, 5, 5, 4, 5, 2, 4.29, '2024-05-01 11:16:35', '2024-05-01 11:16:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `similarities`
--

CREATE TABLE `similarities` (
  `id` bigint UNSIGNED NOT NULL,
  `id_wisata1` bigint UNSIGNED NOT NULL,
  `id_wisata2` bigint UNSIGNED NOT NULL,
  `similarity` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `similarities`
--

INSERT INTO `similarities` (`id`, `id_wisata1`, `id_wisata2`, `similarity`) VALUES
(1, 10, 17, 0.95),
(2, 10, 23, 0.91),
(3, 10, 22, 0.91),
(4, 2, 10, 0.23),
(5, 10, 25, 0.79),
(6, 10, 14, 0.75),
(7, 17, 23, 0.99),
(8, 17, 22, 0.99),
(9, 2, 17, 0.19),
(10, 17, 25, 0.93),
(11, 14, 17, 0.88),
(12, 22, 23, 1.00),
(13, 2, 23, 0.22),
(14, 23, 25, 0.96),
(15, 14, 23, 0.91),
(16, 2, 22, 0.21),
(17, 22, 25, 0.96),
(18, 14, 22, 0.93),
(19, 2, 25, 0.31),
(20, 2, 14, 0.40),
(21, 14, 25, 0.96),
(22, 3, 10, 0.45),
(23, 3, 17, 0.45),
(24, 3, 23, 0.47),
(25, 3, 22, 0.49),
(26, 2, 3, 0.64),
(27, 3, 25, 0.50),
(28, 3, 14, 0.67);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'hatami', 'hatami@gmail.com', NULL, '$2y$12$z8rnhk1MB/HazdhSxAtreueAwJyYeO/YDBLMNRTmc.PnWpi.KrQnu', 'admin', NULL, '2024-03-08 05:06:40', '2024-04-06 23:10:11'),
(2, 'anan', 'anan@gmail.com', NULL, '$2y$12$6VDFW24.zCQiRza71EEwDeHmFnzDpVj0Pd2waAGK2g.YwCXb78EDK', 'user', NULL, '2024-03-09 01:36:36', '2024-03-09 01:36:36'),
(3, 'firdaus', 'firdaus@gmail.com', NULL, '$2y$12$3xxw5I.3clHfbQzN3Z56guI0OwK9KF3hab1gu9ITamWFavCUSay1O', 'user', NULL, '2024-03-31 12:38:44', '2024-03-31 12:38:44'),
(4, 'fidya', 'fidya@gmail.com', NULL, '$2y$12$nVzsbRskIPNFQFLVMI6TLuWSOg3HiN.Q6ZfH0NbZ75bhFjDwbVw8K', 'user', NULL, '2024-04-01 03:58:02', '2024-04-01 03:58:02'),
(5, 'ytprem', 'emailpremyt@gmail.com', NULL, '$2y$12$VVFGI72hcWCnNmWx0tlaFOTT5SFyZ0C4EBfqt47Tog196E6ToFeLC', 'user', NULL, '2024-04-04 17:15:16', '2024-04-06 23:21:23'),
(6, 'andani', 'andani@gmail.com', NULL, '$2y$12$KI7IaECOn.rtc.ypxFAoL.jvdtfkxk72y1ScpPVJQNKcxZT40g7Vq', 'user', NULL, '2024-04-25 16:51:38', '2024-04-25 16:51:38'),
(7, 'haikal', 'haikal@gmail.com', NULL, '$2y$12$nVEHC7rGYqsvFg94vFO0IOK8pU48IE3CcrqoA2OzlJvEGJTTmXJXa', 'user', NULL, '2024-04-28 06:10:38', '2024-04-28 06:10:38'),
(8, 'bayu', 'bayu@gmail.com', NULL, '$2y$12$VHHS2WeCN7lktlg1IZqNEO9F1aBSPljFHphrB3TT7bPNkw8h9as/K', 'user', NULL, '2024-04-28 06:48:32', '2024-04-28 06:48:32'),
(9, 'diqi', 'diqi@gmail.com', NULL, '$2y$12$us3x5KoyBTB5oh9ax7OLlOrCVMjIHWLy6ORGK/c9SgduizheQbZeS', 'user', NULL, '2024-04-28 12:49:57', '2024-04-28 12:49:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisatas`
--

CREATE TABLE `wisatas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_kategori` bigint UNSIGNED DEFAULT NULL,
  `nama_wisata` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_wisata` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(18,15) DEFAULT NULL,
  `longitude` decimal(18,15) DEFAULT NULL,
  `desk_wisata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_wisata` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `wisatas`
--

INSERT INTO `wisatas` (`id`, `id_kategori`, `nama_wisata`, `lokasi_wisata`, `latitude`, `longitude`, `desk_wisata`, `gambar_wisata`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pantai Selayar', 'Jl. Selayar Indah, Sungairujing, Kec. Sangkapura, Kabupaten Gresik, Jawa Timur', -5.855551636692007, 112.684884516549640, 'Pantai Selayar adalah salah satu pantai di Pulau Bawean. Pantai ini terkenal dengan pulau kecil yang berbentuk hati dan berada di tengah air laut.', 'wisata_photos/tyf2TfxG9Ptgy13DnR9eH7yWAmQaLimZtikTdeTd.webp', '2024-03-08 05:13:18', '2024-04-02 11:29:22'),
(2, 5, 'Makam Waliyah Zainab', 'Jl. Waliyah Zainab, Diponggo, Tambak, Kabupaten Gresik, Jawa Timur', -5.735870989674299, 112.699465973151690, 'Makam Waliyah Zaenab merupakan suatu situs budaya religi yang berada di Desa Diponggo, Kecamatan Tambak, Pulau Bawean, Kota Gresik, Jawa Timur. Makam ini berlokasi sekitar 18 km dari Pelabuhan Sangkapura dan 3 km dari Bandara Harun Thohir.', 'wisata_photos/Bm2xihZpJmWhThuhtCwGc4wsWk4tQe0ULkZEN6LX.jpg', '2024-03-10 04:44:01', '2024-04-02 11:31:33'),
(3, 7, 'Danau Kastoba', 'Pulau Bawean, Paromaan, Danau/Waduk, Kec. Sangkapura, Kabupaten Gresik, Jawa Timur', -5.771915024940752, 112.672473661984900, 'Danau Kastoba merupakan satu di antara sekian banyak wisata alam yang menjadi unggulan di Pulau Bawean. Danau Kastoba terletak di Dusun Candi, Desa Paromaan, Kecamatan Tambak, Pulau Bawean, Gresik, Jawa Timur. Danau Kastoba menjadi salah satu icon wisata favorit Pulau Bawean, danau yang berada di tengah-tengah Pulau Bawean ini menjadi pembatas antara kecamatan Sangkapura dan Tambak.', 'wisata_photos/xQDEqpOxD4ke1RXGRTLVEYaHjDvIUEC4QWY22ClH.webp', '2024-03-10 04:48:01', '2024-04-02 11:32:45'),
(4, 1, 'Pulau Cina', 'Jatidawang, Tambak, Kabupaten Gresik, Jawa Timur', -5.772059411634114, 112.586670136517600, 'Pulau Cina merupakan salah satu andalan wisata bawah air di Pulau Bawean. Berada di wilayah Desa Teluk Jati Dawang Kecamatan Tambak, letaknya dekat dengan jalan lingkar Bawean.', 'wisata_photos/su7G0EMCrhRFQhALk886E9S5J4j701D4BBnJFNih.jpg', '2024-03-14 07:16:49', '2024-04-02 11:34:30'),
(5, 1, 'Pantai Labuhan', 'Tanjungori, Tambak, Kabupaten Gresik, Jawa Timur', -5.735363177432253, 112.673557994186480, 'Pantai Labuhan berada di sebelah utara Pulau Bawean, sehingga para wisatawan dapat menikmati suasana pantai sambil berjemur di atas hamparan pasir putih yang lembut serta menikmati keindahan pemandangan matahari tenggelam. Pantai labuhan terletak di Desa Tanjungori, Kecamatan Tambak, Bawean – Gresik dan berjarak sekitar 30 Km dari Pelabuhan Sangkapura serta 1.5 Km dari Bandara Bawean.', 'wisata_photos/jNBWhlJC8DsQFlCFS6u9M6TKpNYonRZRSAaYqVgL.webp', '2024-03-14 07:20:40', '2024-04-02 11:35:42'),
(8, 1, 'Mayangkara', 'Diponggo, Tambak, Kabupaten Gresik, Jawa Timur', -5.736018777941784, 112.718249033537150, 'Pantai Mayangkara adalah salah satu pantai yang berada di Pulau Bawean, di sana bisa melihat pemandangan yang indah berupa hamparan pasir pantai berwarna putih berpadu dengan air laut jernih yang berwarna biru kehijauan.', 'wisata_photos/YOFg6j0SXNxksKb5kcb8IzlQCT4uD6C7AkkAkKJK.jpg', '2024-03-14 07:27:53', '2024-04-02 11:37:28'),
(9, 8, 'Air Panas Kepuh', 'Desa Kepuhlegundi, Kecamatan Tambak, Bawean Kabupaten Gresik', -5.765136687454200, 112.722909836220000, 'Air Panas Kepuh Legundi adalah salah satu wahana wisata alam yang ditawarkan oleh Pulau Bawean. Lokasi air panas ini berada di Desa Kepuhlegundi, Kecamatan Tambak, Bawean Kabupaten Gresik.', 'wisata_photos/Lkp5vAEc5M00ZhvZL8cOofS7ifMtaBTXHQAwxx8s.jpg', '2024-03-14 07:32:04', '2024-04-02 11:41:53'),
(10, 8, 'Air Panas Sawahmulya', 'Sawahmulya, Kec. Sangkapura, Kabupaten Gresik, Jawa Timur', -5.843201959701222, 112.662630811977520, 'Air Panas ini terletak di Desa Sawahmulya Kecamatan Sangkapura, Bawean – Gresik dan berada di tengah kota sekitar 200 m dari jalan raya (4 Km dari Pelabuhan Sangkapura) sehingga sangat mudah untuk mencapai lokasinya. Menurut hasil beberapa penelitian, Sumber air panas berupa air panas artesis ini berasal dari sisa gunung api purba yang tidak aktif.', 'wisata_photos/zqT4Qm8NkIfREdfhnd65JKfAquZGYnRtk2rfeb75.png', '2024-03-18 01:02:02', '2024-04-02 11:45:06'),
(11, 8, 'Air Panas Sungai Rujing', 'Dusun Taubat Desa Sungairujing Kecamatan Sangkapura', -5.852638501892000, 112.681099326150000, 'Pemandian air panas ini berada di kawasan Dusun Taubat Desa Sungairujing Kecamatan Sangkapura, berjarak 5 kilometer dari Pelabuhan Sangkapura atau dikenal juga dengan Bawean. Sumber mata air dari pemandian ini tergolong cukup besar. Selain digunakan untuk pemandian, air panas taubat juga dimanfaatkan oleh penduduk lokal untuk kebutuhan air rumah tangga sehari-hari dan juga sebagai sumber air irigasi pertanian di kawasan tersebut. Sumber air panas ini sangat jarang dikunjungi oleh para wisatawan.', 'wisata_photos/V54Z4yWLBUlRRziDU9mNhoNgOcSA3wSqdKtux8ym.jpg', '2024-03-18 01:06:10', '2024-04-02 11:46:39'),
(12, 6, 'Air Terjun Teluk Jati Dawang', 'Desa Teluk Jati Dawang Kecamatan Sangkapura Bawean', -5.780462332099924, 112.633904316424300, 'Air terjun di desa Teluk Jati Dawang ini sudah tidak aktif/tutup permanen dikarenakan akses jalan yang sulit dan rusak sehingga hanya bisa diakses melalui jalan kaki.', 'wisata_photos/A0Kj6pL8aQwfRNo3wKahDxHX5PEZCpPGLFGtzCfz.jpg', '2024-03-18 01:10:02', '2024-04-02 11:59:56'),
(13, 6, 'Air Terjun Kuduk-Kuduk', 'Desa Patar Selamat Kecamatan Sangkapura Bawean', -5.814615225744180, 112.650468238358710, 'Air terjun Kuduk-Kuduk atau Patar Selamat ini terletak di Dusun Kuduk-Kuduk, Desa Patar Selamat, Kecamatan Sangkapura, Bawean – Gresik.  Seperti halnya air terjun pada umumnya, kondisi medan atau lokasinya berupa jalan setapak sehingga dapat dilalui oleh kendaraan roda dua. Waktu tempuhnya sekitar 40 menit melalui jalan Desa Patar Selamat. Air Terjun Kuduk-Kuduk memiliki ketinggian sekitar 12 m dari permukaan dan kondisinya masih alami.', 'wisata_photos/7YEmRuC3vVjUhiCWZavFPHMOEYGM7wET038bzTyy.jpg', '2024-03-18 01:14:04', '2024-04-02 12:11:29'),
(14, 6, 'Air Terjun Laccar', 'Desa Kebun Teluk Dalam Kecamatan Sangkapura Bawean', -5.807034126838600, 112.692950738880000, 'Air terjun Laccar berada di kawasan Desa Kebun Teluk Dalam Kecamatan Sangkapura. Sekitar 15 KM dari pusat Kecamatan Sangkapura. Air terjun ini memiliki ketinggian 25M dengan latar belakang tebing yang artistik. Air Terjun Laccar merupakan salah satu obyek wisata yang wajib dikunjungi karena akses menuju destinasi wisata ini tergolong mudah. Wisatawan dapat menggunakan kendaraan roda empat maupun roda dua. Dengan menyusuri jalan setapak sekitar 15 menit, wisatawan dapat menikmati air terjun tertinggi di Bawean ini.', 'wisata_photos/LTIAs13aljJwNe8WedCcThVvd0TwmYzobPdoG5Z3.jpg', '2024-03-18 01:16:30', '2024-04-02 12:13:50'),
(15, 1, 'Pulau Gili Timur', 'Desa Sidogedungbatu Kecamatan Sangkapura Bawean', -5.804167130145900, 112.770820281730000, 'Pulau Gili terletak di sebelah timur Pulau Noko Gili itu sendiri.  Pulau ini menyerupai sebuah pulau kecil di tengah-tengah laut dengan hamparan pasir putih dan berpenghuni. Untuk mencapainya, dapat menggunakan perahu (jika air pasang) dan berjalan dari Pulau Gili (jika air surut). Di Pulau Gili terdapat penduduk dengan mata pencaharian sebagai nelayan dan sebagian bekerja di luar negeri. Selain itu Pulau Gili sendiri biasanya dijadikan untuk tempat transit para wisatawan yang sedang berkunjung, tak hanya itu Pulau Gili juga menyajikan berbagai atraksi seperti halnya tarian daerah setempat untuk menyambut tamu yang datang berkunjung ke Pulau Gili.', 'wisata_photos/I1xlRE0WJGtp6GupFMNAG5hm4hKMQoB1eTBjJVND.jpg', '2024-03-18 01:21:31', '2024-04-04 07:37:01'),
(16, 1, 'Pulau Noko Gili Timur', 'Dusun Pamona, Desa Sidogedungbatu, Kecamatan Sangkapura, Kabupaten Gresik', -5.811361584692138, 112.768705293253360, 'Pulau & Pantai Noko Gili terletak di sebelah barat Pulau Gili itu sendiri. Pantai ini menyerupai sebuah pulau kecil di tengah-tengah laut dengan hamparan pasir putih nan indah. Sama halnya Pulau Noko Selayar, Pulau Noko Gili berupa hamparan pasir putih yang membentang sekitar 600m dengan lebar 25m. Letaknya bersebelahan dengan Pulau Gili Timur. Untuk mencapainya, dapat menggunakan perahu (jika air pasang) dan berjalan dari Pulau Gili (jika air surut). Selain hamparan pasir putih yang mempesona, Noko Gili juga menyajikan panorama wisata bahari bawah air. Bahkan, wisatawan juga bisa melihat habitat laut dengan mata telanjang.', 'wisata_photos/K5xCWaJlq9m0eY8vnpTMFxYtdNqQRWU3UOrDG1VB.jpg', '2024-03-18 01:23:21', '2024-04-04 07:40:21'),
(17, 5, 'Makam Mulana Umar Mas\'ud', 'Komplek Masjid Jami\' Desa Kotakusuma Kecamatan Sangkapura Bawean', -5.845186582828367, 112.657794527556040, 'Syech Maulana Umar Mas’ud merupakan tokoh Ulama Penyebar Islam di pulau Bawean. Maulana Umar Mas’ud (nama asalnya adalah Pangeran Perigi) yang mengunjungi pulau Bawean dan wafat disana. Beliau adalah cucu Sunan Drajat (Sayyid Zainal ‘Alim), yaitu anak kedua dari Susuhunan Mojoagung (putera Sayyid Zainal ‘Alim yang tertua). Maulana Umar Mas’ud datang ke pulau Bawean sekembalinya dari pulau Madura. Beliau datang ke Madura bersama saudaranya bernama Pangeran Sekara. Namun Pangeran Sekara menetap di Madura dan berkeluarga disana (di Arosbaya). Sedangkan Pangeran Perigi meneruskan perjalanan menuju utara hingga mendarat di pulau Bawean.', 'wisata_photos/fFraokHSrI9vuHg5G9vHr9mvcP8zPaijqebPLqgM.jpg', '2024-03-18 01:26:15', '2024-04-04 07:42:29'),
(18, 5, 'Makam Pangeran Purbonegoro', 'Dusun Gunung Malokok Desa Sawahmulya Kecamatan Sangkapura Bawean', -5.840897740401600, 112.659427464660000, 'Makam Pangeran Purbonegoro terletak di kaki bukit Malokok, Desa Sawah Mulya, Kecamatan Sangkapura Bawean, Gresik, sekitar 2,5 KM dari pelabuhan Sangkapura. Pangeran Purbonegoro adalah keturunan ke V dari Syekh Maulana Umar Mas’ud atau Pangeran Perigi. Beliau selain terkenal sangat bijaksana dalam memerintah, juga sangat khusyu’ dalam menjalankan ibadah. Konon hampir setiap hari, beliau bangun tidur menjelang subuh karena kesibukannya. Alhasil, shalat tahajjud sering terabaikan. Oleh karena itu, beliau memerintahkan kepada penjaga masjid jami’ Sangkapura agar membuyikan bedug tepat pukul 00.00. Tujuannya, agar beliau bisa bangun tengah malam untuk mengerjakan sholat tahajud. Bedug tersebut dikenal orang dengan sebutan ‘GENDENG DEBE’. Namun sejak masa penjajahan Jepang hingga kini, ‘GENDENG DEBE’ sudah tidak terdengar lagi. Dimasa pemerintahan Pangeran Purbonegoro (1720-1747 M), pulau Bawean masih berdiri sendiri dan belum masuk dibawah pemerintahan penjajah namun berafiliasi langsung dengan Keraton Surakarta.', 'wisata_photos/eLFqH2R8wSSC24aAb64FiVFly1fcKoOHtVdhulPC.jpg', '2024-03-18 01:28:57', '2024-04-04 07:43:43'),
(19, 5, 'Makam Cokrokusumo', 'Dusun Nagasari Desa Sungaiteluk Kecamatan Sangkapura Bawean', -5.845404287578006, 112.652878109626830, 'Kanjeng Rahadian Tumenggung (R.T.) Panji Cokrokusumo merupakan keturunan dari Pangeran Perigi atau yang lebih dikenal dengan Syech Maulana Umar Mas’ud. Beliau juga pernah memerintah Bawean dibawah kekuasaan Cakraningrat di Madura. Makam R.T. Cokrokusumo berada di Desa Sungai Teluk Kecamatan Sangkapura, tepatnya di area pemakaman umum Nagasare, berjarak kurang lebih 1,5 Km dari pelabuhan Sangkapura. Makam tersebut berada dalam bangunan berarsitektur Jawa (joglo). Di dalam bangunan tersebut terdapat tiga cungkup utama. Makam R.T. Cokrokusumo berada di posisi tengah, diapit dua cungkup lainnya. Selain itu, makam Cokrokusumo juga diberi cungkup dan kelambu berwarna merah muda. Dua sisi nisan bertuliskan aksara arab (kaligrafi) dengan inkripsi yang berbeda.', 'wisata_photos/z2QB6UkdshEIzlL1jMchNl44ACw2XQYgMJA0IjPV.jpg', '2024-03-18 01:30:19', '2024-04-04 07:46:37'),
(20, 5, 'Makam Jujuk Campa', 'Desa Kumalasa Kecamatan Sangkapura Bawean', -5.828909690082700, 112.594791553130000, 'Makam Jujuk Campa terletak di Desa Kumalasa, Kecamatan Sangkapura. Sekitar 4 KM dari pelabuhan Sangkapura dan 1,5 KM dari jalan lingkar Bawean. Makam Jujuk Campa merupakan makam tunggal dengan bangunan yang sudah direnovasi. Berada di area perkampungan penduduk, membuat makam Jujuk Campa sangat gampang dijangkau. Menurut cerita yang berkembang, Jujuk Campa adalah seorang kepala rombongan dari negeri Campa (Kamboja) yang melakukan perjalanan ke Jawa. Ditengah perjalanan, puteri Campa yang turut serta dalam rombongan sakit dan meninggal di Pulau Bawean, tepatnya di desa Kumalasa. Penduduk setempat menyebutnya dengan kuburan “Mbah Putri”. Sementara pimpinan rombongan tidak meneruskan perjalanan dan memilih menghabiskan usianya di Pulau Bawean. Penduduk setempat sering menyebutnya dengan kuburan “Jujuk Campa”. Barang-barang peninggalan Jujuk Campa sampai saat ini masih ada dan disimpan rapi dirumah salah satu warga Desa Kumalasa.', 'wisata_photos/iLsI6NitsQATwGMOahsahAPAHmZ1dr5bSoSYE69U.jpg', '2024-03-18 01:32:17', '2024-04-22 14:02:43'),
(21, 5, 'Makam Jujuk Tampo', 'Desa Pudakit Barat Kecamatan Sangkapura Bawean', -5.807690930012400, 112.612261160800000, 'Makam Jujuk Tampo terletak di Dusun Tampo Desa Pudakit Barat, Kecamatan Sangkapura, Bawean-Gresik, sekitar 4 Km dari pelabuhan Sangkapura dan 1 KM dari jalan lingkar Bawean. Letaknya yang berada di area persawahan dan jauh dari pemukiman penduduk, pemakaman ini termasuk berdiri sendiri. Area makam Jujuk Tampo terdiri dari dua bangunan utama. Bangunan Utama berupa makam Jujuk Tampo dan istrinya. Berjarak 10 meter dari bangunan utama, terdapat bangunan peristirahatan yang memiliki fasilitas kamar mandi, tempat wudhu dan aula peristirahatan bagi peziarah. Tidak hanya menawarkan wisata religi, makam Jujuk Tampo juga menyajikan pemandangan alam berupa hamparan sawah yang berundak-undak dan luas. Untuk mencapai lokasi, peziarah dapat menggunakan sepeda motor atau mobil. Khusus peziarah yang memilih menggunakan mobil, maka pejizarah harus turun di batas akhir jalan poros desa. Selanjutnya harus bejalan kaki sekitar 100 meter untuk mencapai area pemakanan Jujuk Tampo.', 'wisata_photos/9hpVDGMSJayYLTvLIF3As4PDE26hQVkcqC44foHF.webp', '2024-03-18 01:34:12', '2024-04-22 14:03:47'),
(22, 9, 'Penangkaran Rusa', 'Desa Pudakit Timur Kecamatan Sangkapura Bawean', -5.802904980264200, 112.611370661890000, 'Destinasi wisata ini terletak di Desa Pudakit Timur Kecamatan Sangkapura dengan jarak 6 KM dari pelabuhan Sangkapura dan berbatasan dengan kawasan hutan suaka alam Bawean. Jenis rusa yang mendiami tempat ini adalah axis kuhli, jenis rusa endemik Pulau Bawean. Kawasan yang dihuni sekitar 32 ekor rusa ini tidak hanya menawarkan kelincahan rusa, lokasinya yang berada di atas bukit dan dipenuhi pohon memberikan nuansa pegunungan yang menakjubkan. Bahkan, dari satu sudut, wisatawan bisa memandang laut dan sungai kecil yang berbatasan dengan hutan. Selain penangkaran rusa, area ini juga mempunyai potensi lain seperti: Bumi Perkemahan (camping site), outbond spot, dll.', 'wisata_photos/lBghkSFk9qxFlfuNqRFa05NgYPQFiX0RFvxuXtxa.jpg', '2024-03-18 01:38:50', '2024-04-22 14:04:41'),
(23, 1, 'Pantai Kerrong Mombhul', 'Sidogedungbatu, Kabupaten Gresik, Jawa Timur', -5.788716402658300, 112.740981952260000, 'Pantai Mombhul adalah salah satu Daya Tarik Wisata buatan baru yang ada di Kecamatan Sangkapura Bawean – Gresik. Meskipun tergolong pendatang baru namun pesona wahana wisata buatan ini mampu menarik minat wisatawan sehingga tidak heran di musim liburan sekolah, Hari Raya, dan Hari Besar Nasional lainnya selalu ramai di kunjungi wisatawan lokal maupun dari luar pulau Bawean. Selain gencarnya promosi yang dilakukan juga lokasi yang berdekatan dengan Dermaga Pamona menuju Pulau Gili, Noko Gili, dan Selayar membuat pantai Mombhul cepat dikenal luas oleh wisatawan. Pantai Mombhul memiliki luas 45 hektare dan saat ini masih dalam tahap pengembangan baik dari sisi sarana penunjangnya maupun SDM pengelolanya. Rencananya wahana wisata buatan ini akan dilengkapi dengan berbagai wahana/spot seperti penangkaran rusa mini, penyu, water boom kolam air laut dan sebagainya.', 'wisata_photos/5sY17H3lC7XhaYVRZCeMEbBwVJT05WrC750zkTvu.jpg', '2024-03-18 01:44:00', '2024-04-22 14:07:57'),
(24, 1, 'Tanjung Ghe\'en', 'Desa Kumalasa Kecamatan Sangkapura Bawean', -5.844175573232900, 112.577404970900000, 'Tanjung Ghe’en atau disebut juga dengan Tanjung Gaang berada di dusun Somor-Somor Tanjung Kima yang berada di desa Komalasa, Tanjung Ge’en letaknya kurang lebih 8 kilometer dari Sangkapura. Untuk menuju ke Somor-Somor disarankan untuk menggunakan sepeda motor, karena jalan menuju ke sana berkelok-kelok.Tanjung Gaang merupakan hamparan batu karang yang sangat luas di atas laut jernih berwarna biru hingga kita bisa melihat karang dan berbagai jenis ikan diantara terumbu karang di dalam laut.', 'wisata_photos/xNpMu78FsgVfFvAqXJUzkb3G8mz1lDc9sfSHts2j.jpg', '2024-03-18 04:56:32', '2024-04-22 14:08:46'),
(25, 10, 'Mangrove Hijau Daun', 'Daun, Kec. Sangkapura, Kabupaten Gresik, Jawa Timur', -5.846853189203518, 112.706442490030580, 'Mangrove Daun terletak di Dusun Daun Laut, Desa Daun, Kecamatan Sangkapura, Bawean – Gresik. Wisata Mangrove Daun ini dikelola oleh Desa melalui Kelompok Masyarakat (Pokmas) “Hijau Daun”. Dulunya wilayah hutan mangrove ini merupakan area penambangan pasir pantai yang dilakukan oleh masyarakat untuk kebutuhan bahan bangunan yang menyebabkan abrasi yang sangat parah sehingga sebuah kelompok masyarakat tergerak untuk melindungi area tersebut. Dalam rangka pencegahan abrasi dan peremajaan tepian pantai mereka menanaminya dengan mangrove. Seiring berjalannya waktu dan trend ekowisata mangrove, masyarakat Daun sepakat untuk mengembangkan area tersebut menjadi Ekowisata Mangrove Daun sebagaimana saat ini.', 'wisata_photos/SrxsIMMoJ7KaG1kpDAXPbLKbIXbRO9qNN2xVyrQE.jpg', '2024-03-18 05:10:51', '2024-04-02 11:27:30'),
(26, 5, 'Kuburan Panjang', 'Lebak, Kec. Sangkapura, Kabupaten Gresik, Jawa Timur', -5.860789706580141, 112.622670778851840, 'Makam Kubur Panjang ini berada di pinggir laut yang disebut sebagai Pantai Kubur Panjang. Hal ini karena di lokasi itu terdapat sebuah makam panjang yang konon merupakan makam salah satu abdi setia Sang Adji Saka (Duro) yang meninggal dunia di pantai tersebut.', 'wisata_photos/3WnDTjtuwFkQownsEJxco2zwuq8DWqq3r1JHENwn.jpg', '2024-03-18 05:18:17', '2024-04-22 14:11:18'),
(27, 1, 'Pulau Noko Selayar', 'Desa Sungairujing Kecamatan Sangkapura Bawean', -5.871241184539100, 112.705970588820000, 'Pulau tak berpenghuni ini namun menyimpan begitu banyak keindahaan yang tak ada duanya di pulau bawean. Pasirnya yang putih bersih, air lautnya yang biru dan bening seakan selalu menjadi primadona pulau ini. Di Pulau eksotis ini para pengunjung akan dimanjakan dengan hiasan alam bawah lautnya yang mempesona, bunga karang yang indah serta ikan ikan hias yang berenang bebas di bawah laut ini bisa kita lihat secara langsung. Dan ketika air laut sedang surut para pengunjung bisa berjalan kaki mengelilingi pulau ini sambil menunggu senja tiba, karena sunset di pulau ini sangat sayang untuk dilewatkan.', 'wisata_photos/El2BO5HXzgr8ZjHE7omepBjijhaCNetVaUl3DKoo.webp', '2024-03-18 05:24:04', '2024-04-22 14:13:57'),
(28, 1, 'Pulau Gili Barat', 'Desa Dekatagung Kecamatan Sangkapura Bawean', -5.806887634396000, 112.575959035590000, 'Pulau yang berada di Bawean tepatnya di desa dekatagung kecamatan sangkapura. Pulai ini terkenal dengan keindahan pantai pasir putihnya, masih bersih dan asri. Selain itu, banyak spot bagus untuk dijadikan sebagai tempat foto bagi wisatawan. Salah satu wisata yang dapat ditemukan di pulau gili barat adalah wisata magrove dengan wahan air pertama yang beroprasi di desa tersebut.', 'wisata_photos/WYNZQQzkIxaZGBtqVeH0mvdYouWpSDWSq6iW9sYI.jpg', '2024-03-18 05:29:45', '2024-04-22 14:15:13'),
(29, 1, 'Pantai Riya', 'Desa Dekatagung Kecamatan Sangkapura Bawean', -5.795367534665500, 112.584702104930000, 'Pantai Ria merupakan satu dari beberapa pesisir yang berada di Pulau Bawean. Pantai ini sedikit berbeda dengan pantai-pantai lain di pulau tersebut. Di pinggir pantainya bisa dijumpai bebatuan karang hitam yang menjulang tinggi. Selain itu, tidak terdapat hamparan pasir putih atau debur ombak. Air lautnya sendiri jernih dan berwarna biru kehijauan. Pemandangan yang terlihat ketika bermain ke objek wisata ini adalah kapal-kapal nelayan yang berlabuh di pinggiran dan terkadang mereka dibawa berlayar ke tengah samudera.', 'wisata_photos/A5Vo4OGbWZz2upibnmPpIt5G31MDXpsIzqeYN96q.jpg', '2024-03-18 05:32:56', '2024-04-22 14:16:01'),
(30, 10, 'Mangrove Pasir Putih Sukaoneng', 'Desa Sukaoneng Kecamatan tambak Bawean', -5.749433463823567, 112.615793138923640, 'Pesona wisata yang terletak di Desa Sukaoneng Kecamatan tambak Gresik Jawa Timur.ini memiliki keindahan alami pada tepi pantai, selain pasirnya berwarna putih, pantai ini kondisinya landai sehingga memungkinkan pelancong dapat berjalan santai sambil menikmati pemandangan sekitar yang masih alami.', 'wisata_photos/kRXRWIPCR78oP8uvDKt1fTX6PaznnekQJ5M4NC57.jpg', '2024-03-18 05:34:56', '2024-04-22 14:17:06');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategoris_slug_unique` (`slug`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `predictions`
--
ALTER TABLE `predictions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `predictions_id_user_foreign` (`id_user`),
  ADD KEY `predictions_id_wisata_foreign` (`id_wisata`);

--
-- Indeks untuk tabel `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_id_user_foreign` (`id_user`),
  ADD KEY `ratings_id_wisata_foreign` (`id_wisata`);

--
-- Indeks untuk tabel `similarities`
--
ALTER TABLE `similarities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `similarities_id_wisata1_foreign` (`id_wisata1`),
  ADD KEY `similarities_id_wisata2_foreign` (`id_wisata2`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `wisatas`
--
ALTER TABLE `wisatas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `predictions`
--
ALTER TABLE `predictions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `similarities`
--
ALTER TABLE `similarities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `wisatas`
--
ALTER TABLE `wisatas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `predictions`
--
ALTER TABLE `predictions`
  ADD CONSTRAINT `predictions_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `predictions_id_wisata_foreign` FOREIGN KEY (`id_wisata`) REFERENCES `wisatas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `ratings_id_wisata_foreign` FOREIGN KEY (`id_wisata`) REFERENCES `wisatas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ketidakleluasaan untuk tabel `similarities`
--
ALTER TABLE `similarities`
  ADD CONSTRAINT `similarities_id_wisata1_foreign` FOREIGN KEY (`id_wisata1`) REFERENCES `wisatas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `similarities_id_wisata2_foreign` FOREIGN KEY (`id_wisata2`) REFERENCES `wisatas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
