-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2023 at 05:26 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aps`
--

-- --------------------------------------------------------

--
-- Table structure for table `asets`
--

CREATE TABLE `asets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_aset` varchar(255) NOT NULL,
  `kategori_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dinas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `detail` varchar(255) NOT NULL,
  `status_aset` enum('Tersedia','Tidak Tersedia') NOT NULL DEFAULT 'Tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asets`
--

INSERT INTO `asets` (`id`, `nama_aset`, `kategori_id`, `dinas_id`, `detail`, `status_aset`, `created_at`, `updated_at`) VALUES
(3, 'Ruang Rapat', 1, 8, 'Ruangan dengan kapasitas 20 orang terletak di Gedung OPD lantai 2.', 'Tidak Tersedia', '2023-12-11 20:21:19', '2023-12-25 06:10:26'),
(4, 'CCTV', 3, 8, 'CCTV dengan merk ***', 'Tidak Tersedia', '2023-12-11 20:53:13', NULL),
(6, 'Aula DPMPTSP', 1, 11, 'Ruangan dengan kapasitas hingga 50 orang dapat digunakan untuk sosialisasi, rapat, hiburan, ataupun kegiatan dinas lainnya.', 'Tersedia', '2023-12-18 17:44:05', NULL),
(7, 'Gedung Shima', 1, 7, 'Ruangan dengan kapasitas hingga 60 orang dapat digunakan untuk acara pemerintahan. Terletak di Jl. Kartini, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59411', 'Tidak Tersedia', '2023-12-18 17:45:54', '2023-12-26 20:06:07'),
(9, 'Mobil Dinas', 2, 1, 'Mobil merek Honda CRV dengan plat nomor K 123 JP berwarna Hitam.', 'Tidak Tersedia', '2023-12-18 19:30:05', '2023-12-28 00:03:25'),
(10, 'Ruang Rapat', 1, 8, 'Ruangan dengan kapasitas hingga 30 orang yang terletak di Gedung DPUPR Lantai 1 Jl. Kartini No.27, Kauman, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59417', 'Tersedia', '2023-12-25 20:42:46', '2023-12-26 09:46:41'),
(11, 'Bus Dinas', 2, 15, 'Bus PO Sinar Jaya warna hitam merah dengan kapasitas hingga 50 orang dengan plat nomor K 1735 JH', 'Tersedia', '2023-12-25 20:48:02', NULL),
(12, 'Handy Talkie (HT)', 3, 6, '1 set handy talkie dengan merek Baofeng', 'Tersedia', '2023-12-25 20:52:24', NULL),
(13, 'LCD Proyektor', 3, 8, 'LCD Proyektor dengan brand Epson Proyektor XGA EB E-500 warna putih', 'Tersedia', '2023-12-25 21:12:42', '2023-12-26 09:47:13'),
(14, 'Mobil Mini Bus', 2, 14, 'Mobil mini bus dengan kapasitas hingga 8 orang dengan brand Daihatsu Gran Max warna hitam, plat nomor K 777 PJ', 'Tersedia', '2023-12-25 21:14:41', NULL),
(15, 'Mobil Dinas', 2, 9, 'Mobil berkapasitas hingga 6 orang warna abu-abu muda dengan plat nomor K 2167 QK', 'Tersedia', '2023-12-25 21:18:50', NULL),
(16, 'Mobil Dinas', 2, 12, 'K 2023 RL', 'Tersedia', '2023-12-28 00:10:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dinas`
--

CREATE TABLE `dinas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_dinas` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dinas`
--

INSERT INTO `dinas` (`id`, `nama_dinas`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'Bagian Tata Pemerintahan', 'Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(2, 'Bagian Protokol dan Komunikasi Publik', 'Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(3, 'Bagian Pengelolaan Data dan Dokumentasi', 'Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(4, 'Bagian Perencanaan dan Evaluasi', 'Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(5, 'Bagian Hukum', 'Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(6, 'Bagian Keamanan dan Ketertiban', 'Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(7, 'Bagian Administrasi Umum', 'Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(8, 'Dinas Komunikasi dan Informatika', 'Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(9, 'Dinas Sosial Pemberdayaan Masyarakat dan Desa', 'Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(10, 'Dinas Kesehatan', 'Jalan Kartini No.44, Kauman, Jepara, Panggang III, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59417', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(11, 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', 'Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah', '2023-12-07 20:42:20', '2023-12-07 20:42:20'),
(12, 'Dinas Perhubungan', 'Jalan Jenderal, Jl.Hugeng Imam Santoso No.1, Ngabul, Kec. Tahunan, Kabupaten Jepara, Jawa Tengah 59428', '2023-12-26 03:25:17', NULL),
(13, 'Dinas Pekerjaan Umum dan Tata Ruang', 'Jl. Kartini No.27, Kauman, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59417', '2023-12-26 03:25:41', NULL),
(14, 'Dinas Pariwisata dan Kebudayaan', 'Jl. Abdul Rahman Hakim. No. 51, Kauman, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59417', '2023-12-26 03:25:41', NULL),
(15, 'Dinas Pendidikan, Pemuda dan Olahraga', 'Jl. Ratu Kalinyamat No.1, Demaan VI, Demaan, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59419', '2023-12-26 03:28:26', NULL),
(16, 'Dinas Kearsiapan dan Perpustakaan', 'Jl. Ratu Kalinyamat, kompleks perkantoran, Demaan, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59419', '2023-12-26 03:28:26', NULL),
(17, 'Dinas Perumahan Rakyat dan Kawasan Permukiman', 'Jl. Ki Mangunsarkoro, Panggang V, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59411', '2023-12-26 03:29:53', NULL),
(18, 'Dinas Perindustrian dan Perdagangan', 'Jl. Pemuda No.37, Potroyudan IX, Potroyudan, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59412', '2023-12-26 03:29:53', NULL),
(19, 'Dinas Kependudukan dan Catatan Sipil', 'Jl. Ki Mangunsarkoro No. 37, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59411', '2023-12-26 03:31:27', NULL),
(20, 'Dinas Ketahanan Pangan dan Pertanian', 'Jl. Ki Mangunsarkoro No. 03, Panggang III, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59411', '2023-12-26 03:31:27', NULL),
(21, 'Dinas Koperasi, Usaha Kecil Menengah, Tenaga Kerja dan Transmigrasi', 'Jl. Pesajen, Demaan IV, Demaan, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59419', '2023-12-26 03:33:51', NULL),
(22, 'Dinas Lingkungan Hidup', 'Jl. Sidik Harun, RT.2/RW.2, II, Ujungbatu, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59416', '2023-12-26 03:33:51', NULL),
(23, 'Dinas Pemberdayaan Perempuan, Perlindungan Anak, Pengendalian Penduduk dan Keluarga Berencana', 'Jalan Shima No.1A, Pengkol, Kecamatan Jepara, Pengkol I, Pengkol, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59415', '2023-12-26 03:35:05', NULL),
(24, 'Dinas Perikanan', 'Jl. RMP. Sosrokartono No.2, Pengkol I, Pengkol, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59415', '2023-12-26 03:35:05', NULL),
(25, 'Badan Kepegawaian Daerah', 'Jl. Kartini No.1, Kauman, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59411', '2023-12-26 03:36:55', NULL),
(26, 'Badan Kesatuan Bangsa dan Politik', 'Jl. Boto Putih No.7, Demaan VI, Demaan, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59419', '2023-12-26 03:36:55', NULL),
(27, 'Badan Penanggulangan Bencana Daerah', 'Jl. Ki Mangunsarkoro No.41, Panggang V, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59411', '2023-12-26 03:38:20', NULL),
(28, 'Badan Pengelola Keuangan dan Aset Daerah', 'Jln. Kartini No 1 Jepara , Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59411', '2023-12-26 03:38:20', NULL),
(29, 'Badan Perencanaan Pembangunan Daerah', 'Jl. Patimura, Jobokuto II, Jobokuto, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59416', '2023-12-26 03:39:56', NULL);

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
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 'Ruang', '2023-12-11 18:31:32', NULL),
(2, 'Kendaraan', '2023-12-11 18:31:55', NULL),
(3, 'Barang', '2023-12-11 18:32:04', NULL);

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
(1, '2013_12_06_115540_create_dinas_table', 1),
(2, '2013_12_06_115615_create_roles_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 1),
(6, '2019_08_19_000000_create_failed_jobs_table', 1),
(7, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(8, '2023_12_07_165133_create_kategoris_table', 1),
(9, '2023_12_08_023342_add_deleted_at_to_users_table', 1),
(10, '2023_12_08_033403_add_status_to_users_table', 1),
(11, '2023_12_11_074600_create_kategoris_table', 2),
(12, '2023_12_11_074858_create_asets_table', 2),
(13, '2023_12_12_004733_create_kategoris_table', 3),
(14, '2023_12_12_004754_create_asets_table', 3),
(15, '2023_12_12_075944_create_peminjaman_table', 4),
(16, '2023_12_26_045538_create_pengembalian_table', 5),
(17, '2023_12_26_100718_create_pengembalian_table', 6),
(18, '2023_12_27_072354_add_deleted_at_to_peminjaman_table', 7),
(19, '2023_12_27_073207_add_sanksi_n_bukti_pelunasan_n_status_bayar_to_pengembalian_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_pinjam` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `aset_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `tgl_kembali` datetime NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `surat_pinjam` varchar(255) NOT NULL,
  `status_pinjam` enum('Diterima','Menunggu Verifikasi','Ditolak') NOT NULL DEFAULT 'Menunggu Verifikasi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `kode_pinjam`, `user_id`, `aset_id`, `tgl_pinjam`, `tgl_kembali`, `tujuan`, `surat_pinjam`, `status_pinjam`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'tCHH', 1, 3, '2024-12-02 09:23:00', '2024-12-02 11:23:00', 'Rapat evaluasi tahunan', '1702884232.pdf', 'Diterima', '2023-12-18 00:23:52', '2023-12-25 13:10:26', NULL),
(11, 'tUkx', 1, 6, '2024-01-10 07:30:00', '2024-01-10 13:00:00', 'Kegiatan Forum Diskusi Publik bersama DPMPTSP', '1702950863.pdf', 'Menunggu Verifikasi', '2023-12-18 18:54:23', '2023-12-18 18:54:23', NULL),
(12, 'jyqy', 1, 3, '2023-12-22 09:00:00', '2023-12-22 12:00:00', 'Rapat mengenai Kegiatan Launching aplikasi', '1702951267.pdf', 'Ditolak', '2023-12-18 19:01:07', '2023-12-25 13:30:35', NULL),
(13, 'm0XV', 1, 7, '2024-01-04 07:04:00', '2024-01-04 14:04:00', 'Diskusi bersama tokoh masyarakat', '1702951519.pdf', 'Diterima', '2023-12-18 19:05:19', '2023-12-26 13:54:19', NULL),
(14, 'SW63', 1, 9, '2024-01-05 07:31:00', '2024-01-05 14:05:00', 'Mengantarkan KaBid dinas ke luar kota', '1702953120.pdf', 'Menunggu Verifikasi', '2023-12-18 19:32:00', '2023-12-18 19:32:00', NULL),
(20, 'mZqM', 2, 7, '2024-01-08 07:29:00', '2024-01-08 14:29:00', 'Rapat Evaluasi launching aplikasi', '1703003446.pdf', 'Menunggu Verifikasi', '2023-12-19 16:30:46', '2023-12-26 22:48:17', NULL),
(21, '4kZf', 2, 9, '2024-01-11 08:41:00', '2024-01-12 09:42:00', 'Mengantarkan SekDa mengikuti kegiatan dinas di luar kota', '1703004145.pdf', 'Menunggu Verifikasi', '2023-12-19 16:42:25', NULL, NULL),
(22, 'zadf', 3, 7, '2024-01-01 07:00:00', '2024-01-02 07:04:00', 'Diskusi mengenai acara tahunan pemerintahan kabupaten jepara', '1703646367.pdf', 'Diterima', '2023-12-27 03:06:07', '2023-12-28 07:15:08', NULL),
(23, 'uEgO', 1, 9, '2024-01-02 13:58:00', '2024-01-03 14:02:00', 'Keperluan dinas ke luar kota', '1703747005.pdf', 'Menunggu Verifikasi', '2023-12-28 07:03:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_pinjam` varchar(255) DEFAULT NULL,
  `rusak` enum('Ya','Tidak') NOT NULL DEFAULT 'Tidak',
  `hilang` enum('Ya','Tidak') NOT NULL DEFAULT 'Tidak',
  `ket_rusak` varchar(255) DEFAULT NULL,
  `ket_hilang` varchar(255) DEFAULT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `status_kembali` enum('Menunggu Verifikasi','Menunggu Pembayaran','Diterima','Ditolak') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sanksi` decimal(10,2) DEFAULT NULL,
  `bukti_pelunasan` varchar(255) DEFAULT NULL,
  `status_pelunasan` enum('Lunas','Belum Lunas') NOT NULL DEFAULT 'Belum Lunas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id`, `kode_pinjam`, `rusak`, `hilang`, `ket_rusak`, `ket_hilang`, `bukti`, `status_kembali`, `created_at`, `updated_at`, `sanksi`, `bukti_pelunasan`, `status_pelunasan`) VALUES
(1, 'm0XV', 'Tidak', 'Tidak', NULL, NULL, NULL, 'Menunggu Verifikasi', '2023-12-26 13:55:21', NULL, NULL, NULL, 'Belum Lunas'),
(2, 'mZqM', 'Ya', 'Tidak', 'Terdapat beberapa kursi di ruangan yang patah kakinya', NULL, '1703648201.jpg', 'Menunggu Verifikasi', '2023-12-27 03:36:41', NULL, NULL, NULL, 'Belum Lunas');

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
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', '2023-12-07 20:42:27', '2023-12-07 20:42:27'),
(2, 'SekDa', '2023-12-07 20:42:27', '2023-12-07 20:42:27'),
(3, 'OPD', '2023-12-07 20:42:27', '2023-12-07 20:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `telp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `dinas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `nip`, `jabatan`, `telp`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `status`, `dinas_id`, `role_id`) VALUES
(1, 'Person Admin', '119119119', 'Staf Ahli', '081123456789', 'avissaamadea21@gmail.com', NULL, '$2y$12$v5qfvshaQ8yCDvfK5GA3WuUsaofYxXEJt3ERaAoY1af8kaO/ic85C', NULL, '2023-12-08 03:44:33', '2023-12-08 06:44:33', NULL, 1, 8, 1),
(2, 'Person Sekda', '19911991', 'Sekretaris Daerah', '089123456789', 'avissamadea02@gmail.com', NULL, '$2y$12$HqNVdDEoLYMh5KKbwb6IbejiVev3A0aGuo32GSCpxnSW4/UfJ0Y5K', NULL, '2023-12-11 03:47:02', NULL, NULL, 1, 7, 2),
(3, 'Person OPD', '16161616', 'Staf', '081987654321', 'avissaamadea06@gmail.com', NULL, '$2y$12$PNz8HDe7mtECYboFS9pr6O2.OcOhYLfkg2e93WZr4EylFLzHqEh6W', NULL, '2023-12-11 07:49:25', NULL, NULL, 1, 9, 3),
(4, 'Person 1', '18181818', 'Staf', '08918181818', 'amadea2106@gmail.com', NULL, '$2y$12$1jj3eYersTZbv3k0LsTlwOc9nfKv.hx/ZmasiWgBFefgiHyrrk/Ia', NULL, '2023-12-10 17:50:25', '2023-12-10 18:49:57', '2023-12-10 18:49:57', 0, 10, 3),
(5, 'Person 2', '118818181', 'Staf', '0812345678', '111202012572@mhs.dinus.ac.id', NULL, '$2y$12$XmlUqmgsSMuJQWgkP7scMOx36MX2FUW/7OLIX1mHGQt44AoiQUoci', NULL, '2023-12-13 02:58:58', NULL, NULL, 1, 6, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asets`
--
ALTER TABLE `asets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asets_kategori_id_foreign` (`kategori_id`),
  ADD KEY `asets_dinas_id_foreign` (`dinas_id`);

--
-- Indexes for table `dinas`
--
ALTER TABLE `dinas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peminjaman_kode_pinjam_unique` (`kode_pinjam`),
  ADD KEY `peminjaman_user_id_foreign` (`user_id`),
  ADD KEY `peminjaman_aset_id_foreign` (`aset_id`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengembalian_kode_pinjam_unique` (`kode_pinjam`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_nip_unique` (`nip`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_password_unique` (`password`),
  ADD KEY `users_dinas_id_foreign` (`dinas_id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asets`
--
ALTER TABLE `asets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `dinas`
--
ALTER TABLE `dinas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asets`
--
ALTER TABLE `asets`
  ADD CONSTRAINT `asets_dinas_id_foreign` FOREIGN KEY (`dinas_id`) REFERENCES `dinas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `asets_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_aset_id_foreign` FOREIGN KEY (`aset_id`) REFERENCES `asets` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_kode_pinjam_foreign` FOREIGN KEY (`kode_pinjam`) REFERENCES `peminjaman` (`kode_pinjam`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_dinas_id_foreign` FOREIGN KEY (`dinas_id`) REFERENCES `dinas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
