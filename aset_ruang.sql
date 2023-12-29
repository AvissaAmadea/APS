-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2023 at 01:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aset_ruang`
--

-- --------------------------------------------------------

--
-- Table structure for table `aset`
--

CREATE TABLE `aset` (
  `id_aset` int(11) NOT NULL,
  `id_dinas` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_aset` varchar(100) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `status_aset` varchar(100) NOT NULL DEFAULT 'Tersedia',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aset`
--

INSERT INTO `aset` (`id_aset`, `id_dinas`, `id_kategori`, `nama_aset`, `detail`, `status_aset`, `create_at`, `update_at`) VALUES
(31, 3, 1, 'Mobil', 'K123QL', 'Tersedia', '2023-12-27 01:26:24', '2023-12-28 07:08:18'),
(32, 3, 1, 'Motor', 'K123QL', 'Tersedia', '2023-12-27 01:29:02', '2023-12-28 07:08:31'),
(33, 3, 3, 'Kursi', '20', 'Tersedia', '2023-12-27 04:39:11', '2023-12-27 15:28:10'),
(34, 3, 3, 'LCD', 'LED', 'Tersedia', '2023-12-27 14:52:01', '2023-12-28 07:08:56'),
(35, 3, 2, 'Ruang Rapat', 'Lt. 2', 'Tersedia', '2023-12-27 15:15:14', '2023-12-28 07:09:40'),
(36, 1, 3, 'Laptop', 'acer', 'Tersedia', '2023-12-28 02:06:41', '2023-12-28 02:06:41');

-- --------------------------------------------------------

--
-- Table structure for table `dinas`
--

CREATE TABLE `dinas` (
  `id_dinas` int(11) NOT NULL,
  `nama_dinas` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dinas`
--

INSERT INTO `dinas` (`id_dinas`, `nama_dinas`, `alamat`) VALUES
(1, 'Dinas Komunikasi dan Informatika', 'Jl. Kartini No 1'),
(2, 'Dinas Sosial Pemberdayaan Masyarakat dan Desa', 'Jl. Kartini No. 1'),
(3, 'Dinas Pekerjaan Umum dan Penataan Ruang', 'Jl. Kartini No.27'),
(4, 'Dinas Kesehatan', 'Jl. Kartini No. 44'),
(5, 'Dinas Kependudukan dan Pencatatan Sipil ', 'Jl. Ki Mangunsarkoro No.37, Panggang V, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59411'),
(6, 'Dinas Koperasi, UKM, Tenaga Kerja dan Transmigrasi', 'Jl. Pesajen, Demaan IV, Demaan, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59419'),
(7, 'Dinas Koperasi, UKM, Tenaga Kerja dan Transmigrasi', 'Jl. Pesajen, Demaan IV, Demaan, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59419'),
(8, 'Dinas Pariwisata Dan Kebudayaan ', 'Jl. Abdul Rahman Hakim. No. 51, Kauman, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59417'),
(9, 'Dinas Pariwisata Dan Kebudayaan ', 'Jl. Abdul Rahman Hakim. No. 51, Kauman, Kec. Jepara, Kabupaten Jepara, Jawa Tengah 59417');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `create_at`, `update_at`) VALUES
(1, 'Kendaraan', '2023-12-06 02:00:27', '2023-12-12 00:38:00'),
(2, 'Ruang', '2023-12-06 02:00:27', '2023-12-12 00:38:00'),
(3, 'Barang', '2023-12-06 02:00:32', '2023-12-12 00:38:00');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_aset`
--

CREATE TABLE `peminjaman_aset` (
  `id_pinjam` int(11) NOT NULL,
  `kodePeminjaman` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_aset` int(11) NOT NULL,
  `tgl_kembali` date NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tujuan` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_peminjaman` varchar(200) NOT NULL DEFAULT 'Menunggu Verifikasi',
  `alasan_penolakan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman_aset`
--

INSERT INTO `peminjaman_aset` (`id_pinjam`, `kodePeminjaman`, `id_user`, `id_aset`, `tgl_kembali`, `tgl_pinjam`, `tujuan`, `create_at`, `update_at`, `status_peminjaman`, `alasan_penolakan`) VALUES
(22, 'P8974096M', 2, 31, '2023-12-31', '2023-12-31', 'dinas', '2023-12-28 00:46:42', '2023-12-28 01:11:44', 'Menunggu Pembayaran', ''),
(23, 'P3325052M', 2, 31, '2023-12-31', '2023-12-31', 'hh', '2023-12-28 01:13:04', '2023-12-28 01:14:34', 'Batal', ''),
(24, 'P1292069M', 2, 31, '2023-12-31', '2023-12-31', 'hh', '2023-12-28 01:14:24', '2023-12-28 01:16:43', 'Batal', ''),
(25, 'P7121518M', 2, 33, '2023-12-31', '2023-12-31', 'us', '2023-12-28 01:17:35', '2023-12-28 01:18:34', 'Batal', ''),
(26, 'P9684856M', 1, 35, '2023-12-31', '2023-12-31', 'nyaleg', '2023-12-28 02:17:58', '2023-12-28 07:27:44', 'Selesai', ''),
(27, 'P1992471M', 1, 31, '2024-01-02', '2024-01-02', 'te', '2023-12-28 07:22:37', '2023-12-28 07:24:36', 'Peminjaman Diterima', '');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian_aset`
--

CREATE TABLE `pengembalian_aset` (
  `id_kembali` int(11) NOT NULL,
  `id_pinjam` int(11) NOT NULL,
  `tgl_kembali` date NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `keadaanAset` varchar(255) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `bukti_img` text NOT NULL,
  `Denda` int(100) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Menunggu Verifikasi',
  `alasan_penolakan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian_aset`
--

INSERT INTO `pengembalian_aset` (`id_kembali`, `id_pinjam`, `tgl_kembali`, `create_at`, `keadaanAset`, `detail`, `bukti_img`, `Denda`, `status`, `alasan_penolakan`) VALUES
(9, 22, '0000-00-00', '2023-12-28 00:47:30', 'Baik', 'gaga', '', 0, 'Selesai', '-'),
(10, 26, '0000-00-00', '2023-12-28 07:26:39', 'Baik', '-', '', 0, 'Selesai', '-');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nama_roles` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nama_roles`) VALUES
(1, 'Admin'),
(2, 'OPD'),
(3, 'Sekda');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `nama_status` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`nama_status`, `id`) VALUES
('Menunggu Verifikasi', 1),
('Diterima', 2),
('Menunggu Pembayaran', 3),
('Dibatalkan', 4),
('Tersedia', 5),
('Tidak Tersedia', 6),
('Tersedia', 7),
('Tidak Tersedia', 8),
('Sedang Diperbaiki', 9);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `id_dinas` int(11) NOT NULL,
  `nip` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL DEFAULT 2,
  `status` varchar(100) NOT NULL DEFAULT 'Active',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `salt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `id_dinas`, `nip`, `email`, `username`, `password`, `id_role`, `status`, `create_at`, `update_at`, `salt`) VALUES
(1, 'jasmine', 1, 'ggfchc', 'jasmineidp.espentura@gmail.com', 'jasmine', '62e73a033580cb6d5f04c0d8e65812b64cfd5c312567b50a4ef111ceadd369d6', 1, 'Active', '2023-12-27 00:50:15', '2023-12-27 00:50:15', '4c336b95efa98f161f84a92c71b720ca'),
(2, 'chika', 1, 'ufufh', 'kgjfuv@gmail.com', 'chila', '3688ccf17ade31aaf2418c5c1ac483d4cd93e7248b6ca35891610d889861f079', 3, 'Aktif', '2023-12-27 00:57:27', '2023-12-27 00:57:27', '6039c1edeb32c3f95ae0dfd3504a53d1'),
(3, 'jasmine', 5, '123456', 'jasmineiswarini@gmail.com', 'jasmine123', '6f8509ef370952c3b6f897b69dd03c7ac946c3ab3ced53f48f2545a32c0baefd', 2, 'Active', '2023-12-28 07:20:32', '2023-12-28 07:20:32', 'a23bcb79c363730f1a9835a0748d8241');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aset`
--
ALTER TABLE `aset`
  ADD PRIMARY KEY (`id_aset`),
  ADD KEY `id_dinas` (`id_dinas`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `dinas`
--
ALTER TABLE `dinas`
  ADD PRIMARY KEY (`id_dinas`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `peminjaman_aset`
--
ALTER TABLE `peminjaman_aset`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_aset` (`id_aset`);

--
-- Indexes for table `pengembalian_aset`
--
ALTER TABLE `pengembalian_aset`
  ADD PRIMARY KEY (`id_kembali`),
  ADD KEY `id_pinjam` (`id_pinjam`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_dinas` (`id_dinas`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aset`
--
ALTER TABLE `aset`
  MODIFY `id_aset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `dinas`
--
ALTER TABLE `dinas`
  MODIFY `id_dinas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peminjaman_aset`
--
ALTER TABLE `peminjaman_aset`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `pengembalian_aset`
--
ALTER TABLE `pengembalian_aset`
  MODIFY `id_kembali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aset`
--
ALTER TABLE `aset`
  ADD CONSTRAINT `aset_ibfk_1` FOREIGN KEY (`id_dinas`) REFERENCES `dinas` (`id_dinas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aset_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `peminjaman_aset`
--
ALTER TABLE `peminjaman_aset`
  ADD CONSTRAINT `peminjaman_aset_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_aset_ibfk_2` FOREIGN KEY (`id_aset`) REFERENCES `aset` (`id_aset`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengembalian_aset`
--
ALTER TABLE `pengembalian_aset`
  ADD CONSTRAINT `pengembalian_aset_ibfk_1` FOREIGN KEY (`id_pinjam`) REFERENCES `peminjaman_aset` (`id_pinjam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_dinas`) REFERENCES `dinas` (`id_dinas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
