-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jan 2026 pada 08.56
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lpjs`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `created_at`, `updated_at`) VALUES
(9, NULL, 'banners/F5Jucc1dxtHgRUppNtrZfA18stOmpNddLfLIqSdD.png', '2026-01-11 13:14:41', '2026-01-11 13:14:41'),
(12, NULL, 'banners/PGkraFKxtpfSgL7oDgXSw1PxF7troplcE4oE7ZbX.png', '2026-01-13 03:03:49', '2026-01-13 03:03:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `is_featured`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Pendidikan', 'pendidikan', 'category-icons/3ZbPuogHZH81AUvrMOHum0Ha9k6JlfPKDo8gYlgE.jpg', 1, NULL, '2025-11-28 08:17:09', '2026-01-13 05:22:34'),
(2, 'Kendaraan Roda 4', 'kendaraan-roda-4', 'category-icons/7g7WhnrZYNosbnxy0oIoqZBlj98dHKpgJHTh3ARu.jpg', 1, NULL, '2025-11-28 08:17:09', '2026-01-13 05:22:35'),
(3, 'Kendaraan Roda 2', 'kendaraan-roda-2', 'category-icons/OajxRegoU8H2aymdrVEMeQtTsiirCYeLWi5VdLYR.jpg', 1, NULL, '2025-11-28 08:17:09', '2026-01-13 05:22:37'),
(4, 'Perbaikan Bangunan', 'perbaikan-bangunan', 'category-icons/oENIZvegI553oDHiY9usPRuoqM3eWay73P4ZYPEc.jpg', 1, NULL, '2025-11-28 08:17:09', '2026-01-13 05:22:38'),
(5, 'Desain Grafis', 'desain-grafis', 'category-icons/rhMChuFqbMdO9PHmNU9BqOsbjMN1kUjme4J26fSE.png', 0, NULL, '2025-11-28 08:17:09', '2026-01-13 05:22:16'),
(6, 'Teknologi Informasi', 'teknologi-informasi', NULL, 0, NULL, '2025-11-28 08:17:09', '2025-11-28 08:17:09'),
(10, 'videogames', 'videogames', 'category-icons/IwaDRDJAq4VNu5nibQyXEE8NZODuhXFoMnP0CjvS.jpg', 1, NULL, '2025-12-07 13:27:13', '2026-01-13 05:22:33'),
(15, 'nigga', 'nigga', 'category-icons/a8TWofnNblMGdCTZrcajr5LszKhoIK2YhJDGyxeS.jpg', 0, NULL, '2026-01-13 05:22:05', '2026-01-13 05:22:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `job_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Full Time',
  `location` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_job` varchar(100) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jobs`
--

INSERT INTO `jobs` (`id`, `user_id`, `title`, `company`, `job_image`, `description`, `type`, `location`, `is_active`, `is_job`, `category_id`, `created_at`, `updated_at`) VALUES
(5, 2, 'jasa service coli', 'azkia ganteng', 'job_images/hFM9m59YQk2YjOtsjM3lgDf7E6zL70o0YRIQwEuC.jpg', 'waowkowawjdogwkawogjawogwa', 'Harian', 'bandung kabupaten', 1, 'tidak tersedia', 2, '2025-12-14 08:05:30', '2026-01-06 06:33:03'),
(6, 8, 'Jasa membuat miniatur 3D khas sunda', 'Akbar Ginanjar', 'job_images/JAADXAXfZEE7p2c5oHNrFPbX2UlUmPOWiF63oJWx.jpg', 'Saya bisa membuat kerajinan miniatur 3D khas SUNDA dengan realistis anjayyy >.<', 'Borongan', 'Bandung', 1, 'tersedia', 5, '2025-12-17 18:28:27', '2026-01-01 06:42:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2025_11_28_141951_create_categories_table', 1),
(4, '2025_11_28_142251_jobs', 1),
(5, '2025_12_05_190002_modify_users_table_for_profile', 2),
(6, '2025_12_11_201755_create_mitras_table', 3),
(7, '2025_12_13_191638_add_user_id_to_jobs_table', 4),
(8, '2025_12_14_140320_add_job_image_to_jobs_table', 5),
(9, '2026_01_10_163336_create_banners_table', 6),
(10, '2026_01_13_092252_add_icon_to_categories_table', 7),
(11, '2026_01_13_110557_add_is_featured_to_categories_table', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mitra`
--

CREATE TABLE `mitra` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mitra`
--

INSERT INTO `mitra` (`id`, `user_id`, `nik`, `alamat`, `foto_ktp`, `status`, `created_at`, `updated_at`) VALUES
(7, 2, '2312556672313', 'bandung jaya', 'ktp_images/B2AzcEmVecjrBPJn7D2DJvnibvyjvMzjYf2wLB5f.jpg', 'approved', '2025-12-14 08:04:53', '2025-12-14 08:04:53'),
(8, 8, '1234567890123456', 'Jl. mochtoha perbas cibiuk gg. margaluyu 1', 'ktp_images/lDXO9GVFuiwCPLulFwppVzACb7wv9KzgMGxA6kpZ.jpg', 'approved', '2025-12-17 18:24:59', '2025-12-17 18:26:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dM2J5W7HaChiXL0TsxEgq1r8egWIRiIUOvk3LYff', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoianZWR2hWU3RwcDkxRWd3QUVha2RMOXZwVUQ4UUtvZFRuWllNb1ZkVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMjoiaG9tZS5sYW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1768306959);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_jasa`
--

CREATE TABLE `transaksi_jasa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kode_transaksi` varchar(50) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `status` enum('pending','diterima','diperjalanan','berlangsung','dibatalkan','proses','selesai','ditolak') NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `alamat_tujuan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi_jasa`
--

INSERT INTO `transaksi_jasa` (`id`, `job_id`, `user_id`, `kode_transaksi`, `tanggal_transaksi`, `tanggal_selesai`, `status`, `bukti_bayar`, `alamat_tujuan`, `created_at`, `updated_at`) VALUES
(1, 6, 8, 'TRX-GWFYUBHL', '2025-12-18 03:13:30', NULL, 'dibatalkan', NULL, 'Jl. Mochtoha perbas cibiuk margaluyu 1', '2025-12-17 20:13:30', '2025-12-17 21:13:34'),
(2, 6, 8, 'TRX-FDRU13OK', '2025-12-18 04:08:35', NULL, 'dibatalkan', NULL, 'Jl. Mochtoha perbas cibiuk margaluyu 1', '2025-12-17 21:08:35', '2025-12-17 21:08:35'),
(3, 6, 8, 'TRX-YUJTA3DI', '2025-12-18 04:13:55', NULL, 'dibatalkan', NULL, 'Jl. Mochtoha perbas cibiuk margaluyu 1', '2025-12-17 21:13:55', '2025-12-18 06:53:19'),
(4, 6, 8, 'TRX-TS6H7W3U', '2025-12-18 13:53:13', NULL, 'diterima', NULL, 'Jl. Mochtoha perbas cibiuk margaluyu 1', '2025-12-18 06:53:13', '2025-12-22 06:30:30'),
(5, 6, 8, 'TRX-A1KNPQAB', '2026-01-01 13:42:24', NULL, 'diterima', NULL, 'Jl. Mochtoha perbas cibiuk margaluyu 1', '2026-01-01 06:42:24', '2026-01-01 06:42:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `roles` varchar(255) NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `no_hp`, `alamat`, `foto_profil`, `password`, `roles`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, NULL, NULL, '$2y$12$hNstw/ubYvPxBi9MTwrHx.qBPBdy6Jp887zbYKZOhH2RxnIEpsfMK', 'admin', '2025-11-28 08:17:36', '2025-12-17 18:18:06'),
(2, 'azkia ganteng', 'reines3212@gmail.com', '083879245167', 'jl sunda empire ngger', 'profiles/5rG79DZgznEoENzi58Y3tNYTVhQqA3XLJRRKLYcy.jpg', '$2y$12$5F5xJarTcpM4ZekTRyjpB.Sqbts0kjcPfypijWPD9C5XoYWN6vx/G', 'user', '2025-12-05 12:48:57', '2025-12-13 09:47:16'),
(3, 'hanifa', 'untukgame3212@gmail.com', '0864597123', 'jl sunda jaya', 'profiles/6IjVsm5Im5npV3p2z3oYEvJlkDt45SmgDqXHmR0j.jpg', '$2y$12$VR5Cc0NV5BGN7/OxgONF/eDwh91/UWD6oN.m30XPHG0B4cRaKTa96', 'user', '2025-12-05 13:42:20', '2026-01-13 01:59:14'),
(8, 'Akbar Ginanjar', 'akbarginanjar0@gmail.com', '083180112238', 'Jl. Mochtoha perbas cibiuk margaluyu 1', NULL, '$2y$12$wtJKbPbj.gNEzHuvg8k0QOgYn/Ms2hhezY5PYeYV7eLhtlUO2GaKS', 'user', '2025-12-17 18:19:37', '2025-12-17 18:22:44'),
(9, 'Dedi Mulyadi', 'dedimulyadi@gmail.com', '081237288288', 'Jawabarat', NULL, '$2y$12$FzSRWgexgTsKMpeOlTZ3UuYDSWC1RgtVaMVcoXEJVGAbhhfGxFZ3K', 'user', '2025-12-17 19:26:42', '2025-12-17 19:27:54'),
(10, 'aski', 'john123@gmail.com', NULL, NULL, NULL, '$2y$12$fg9KbZDPuri7tjz/ZVOIeeWyjmWH0M2/dRusJ26jhpRv8vWLF1gwW', 'user', '2026-01-11 13:26:52', '2026-01-11 13:26:52');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_category_id_foreign` (`category_id`),
  ADD KEY `jobs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mitra_nik_unique` (`nik`),
  ADD KEY `mitra_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transaksi_jasa`
--
ALTER TABLE `transaksi_jasa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `fk_transaksi_job` (`job_id`),
  ADD KEY `fk_transaksi_user` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `transaksi_jasa`
--
ALTER TABLE `transaksi_jasa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mitra`
--
ALTER TABLE `mitra`
  ADD CONSTRAINT `mitra_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_jasa`
--
ALTER TABLE `transaksi_jasa`
  ADD CONSTRAINT `fk_transaksi_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
