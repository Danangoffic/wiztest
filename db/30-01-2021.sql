-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2021 at 11:41 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_quicktestdev`
--

-- --------------------------------------------------------

--
-- Table structure for table `afiliasi`
--

CREATE TABLE `afiliasi` (
  `id` int(11) NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `value` varchar(10) DEFAULT NULL,
  `is_disount` enum('yes','no') NOT NULL DEFAULT 'no',
  `discount` float DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alat_pemeriksaan`
--

CREATE TABLE `alat_pemeriksaan` (
  `id` int(11) NOT NULL,
  `nama_alat` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alat_pemeriksaan`
--

INSERT INTO `alat_pemeriksaan` (`id`, `nama_alat`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'ZYBIO', 1, 1, '2021-01-11 00:00:00', NULL),
(2, 'Tianlong', 1, 1, '2021-01-11 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bilik_swabber`
--

CREATE TABLE `bilik_swabber` (
  `id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `jenis_test` int(11) NOT NULL,
  `nomor_bilik` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `jenis_test` int(2) NOT NULL,
  `jenis_pemeriksaan` int(2) NOT NULL,
  `jenis_layanan` int(2) NOT NULL,
  `faskes_asal` int(2) NOT NULL,
  `customer_unique` varchar(255) NOT NULL,
  `invoice_number` varchar(30) DEFAULT NULL,
  `pemeriksa` int(11) DEFAULT NULL,
  `status_peserta` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `instansi` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_test` varchar(20) DEFAULT NULL,
  `tahap` int(11) DEFAULT NULL,
  `kehadiran` int(11) NOT NULL,
  `no_antrian` int(11) DEFAULT NULL,
  `jam_kunjungan` time NOT NULL,
  `tgl_kunjungan` date NOT NULL,
  `status_pembayaran` varchar(30) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `url_pdf` varchar(255) DEFAULT NULL,
  `is_hs` enum('no','yes') NOT NULL,
  `id_hs` int(11) DEFAULT NULL,
  `is_printed` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `jenis_test`, `jenis_pemeriksaan`, `jenis_layanan`, `faskes_asal`, `customer_unique`, `invoice_number`, `pemeriksa`, `status_peserta`, `email`, `nama`, `nik`, `phone`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_marketing`, `instansi`, `created_at`, `updated_at`, `status_test`, `tahap`, `kehadiran`, `no_antrian`, `jam_kunjungan`, `tgl_kunjungan`, `status_pembayaran`, `token`, `catatan`, `url_pdf`, `is_hs`, `id_hs`, `is_printed`) VALUES
(1, 1, 1, 1, 1, 'SPS2101031', 'INV-210103001', NULL, 20, 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan Jakarta', 1, 1, '2021-01-03 21:50:30', '2021-01-03 21:50:31', 'menunggu', 1, 22, 1, '12:00:00', '2021-01-04', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(2, 1, 1, 1, 1, 'SPS2101031', 'INV-210103002', NULL, 20, 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan Jakarta', 1, 1, '2021-01-03 21:54:03', '2021-01-03 21:54:03', 'menunggu', 1, 22, 2, '12:00:00', '2021-01-04', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(3, 3, 1, 1, 1, 'RTB2101031', 'INV-210103001', NULL, 20, 'danang.a.rahmanda@danangoffic.xyz', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan rawa bahagia', 1, 1, '2021-01-03 21:54:32', '2021-01-03 21:54:32', 'menunggu', 1, 22, 1, '11:00:00', '2021-01-07', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(4, 4, 1, 1, 1, 'SAB21010312001', 'INV-210103001', NULL, 20, 'haibisnisdotcom@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan apa aja', 1, 1, '2021-01-03 21:56:50', '2021-01-03 21:56:50', 'menunggu', 1, 22, 1, '12:00:00', '2021-01-06', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(5, 1, 1, 1, 2, 'SPS21010913001', 'INV-210109001', NULL, 20, 'risleda.lalusu@mail.com', 'Riselda Lalusu', '3232618321321232', '085261641500', 'pria', 'Sleman', '2021-01-01', 'Jl Jogja', 1, 1, '2021-01-09 12:23:50', '2021-01-09 12:23:50', 'menunggu', 1, 22, 1, '13:00:00', '2021-01-11', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(6, 1, 1, 1, 2, 'SPS21010913001', 'INV-210109001', NULL, 20, 'risleda.lalusu@mail.com', 'Riselda Lalusu', '3232618321321232', '085261641500', 'wanita', 'Sleman', '2021-01-01', 'Jl Jogja', 1, 1, '2021-01-09 12:25:18', '2021-01-09 12:25:18', 'menunggu', 1, 22, 1, '13:00:00', '2021-01-11', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(7, 1, 1, 1, 2, 'SPS21010913001', 'INV-210109001', NULL, 20, 'risleda.lalusu@mail.com', 'Riselda Lalusu', '3232618321321232', '085261641500', 'pria', 'Sleman', '2021-01-01', 'Jl Jogja', 1, 1, '2021-01-09 12:26:11', '2021-01-09 12:26:11', 'menunggu', 1, 22, 1, '13:00:00', '2021-01-11', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(8, 1, 1, 1, 2, 'SPS21010913001', 'INV-210109001', NULL, 20, 'risleda.lalusu@mail.com', 'Riselda Lalusu', '3232618321321232', '085261641500', 'pria', 'Sleman', '2021-01-01', 'Jl Jogja', 1, 1, '2021-01-09 12:29:07', '2021-01-09 12:29:07', 'menunggu', 1, 22, 1, '13:00:00', '2021-01-11', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(9, 1, 1, 1, 2, 'SPS21010913001', 'INV-210109001', 1, 20, 'risleda.lalusu@mail.com', 'Riselda Rahma', '3232618321321232', '085261641500', 'wanita', 'Sleman', '2021-01-01', 'Jl Jogja', 1, 1, '2021-01-09 12:29:26', '2021-01-09 16:12:36', 'menunggu', 1, 22, 1, '13:00:00', '2021-01-11', 'settlement', NULL, NULL, NULL, 'no', NULL, 0),
(10, 1, 1, 1, 1, 'SPS21011012001', 'INV-210110001', NULL, 20, 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '2021-01-01', 'jalan', 1, 1, '2021-01-10 16:28:12', '2021-01-10 16:28:12', 'menunggu', 1, 22, 1, '12:00:00', '2021-01-11', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(11, 3, 1, 1, 1, 'RTB21011015001', 'INV-210110001', NULL, 20, 'isel.lalusu@gmail.com', 'Riselda Lalusu', '7201044707960005', '085261641500', 'pria', 'Cilacap', '2021-01-01', 'jln sagan', 1, 1, '2021-01-10 17:01:51', '2021-01-10 17:01:51', 'menunggu', 1, 22, 1, '15:00:00', '2021-01-11', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(12, 2, 1, 1, 1, 'SPB21011412001', 'INV-210114001', NULL, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:00:09', '2021-01-14 00:00:09', 'menunggu', 1, 22, 1, '12:00:00', '2021-01-13', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(13, 2, 1, 1, 1, 'SPB21011413013', 'INV-210114013', NULL, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:01:02', '2021-01-14 00:01:02', 'menunggu', 1, 22, 13, '13:00:00', '2021-01-13', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(14, 2, 1, 1, 1, 'SPB21011413014', 'INV-210114014', NULL, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:03:27', '2021-01-14 00:03:27', 'menunggu', 1, 22, 14, '13:00:00', '2021-01-13', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(15, 2, 1, 1, 1, 'SPB21011413015', 'INV-210114015', NULL, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:04:39', '2021-01-14 00:04:39', 'menunggu', 1, 22, 15, '13:00:00', '2021-01-13', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(16, 2, 1, 1, 1, 'SPB21011413016', 'INV-210114016', NULL, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:05:12', '2021-01-14 00:05:12', 'menunggu', 1, 22, 16, '13:00:00', '2021-01-13', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(17, 2, 1, 1, 1, 'SPB21011413017', 'INV-210114017', NULL, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:06:37', '2021-01-14 00:06:37', 'menunggu', 1, 22, 17, '13:00:00', '2021-01-13', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(18, 2, 1, 1, 1, 'SPB21011413018', 'INV-210114018', NULL, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:07:23', '2021-01-14 00:07:23', 'menunggu', 1, 22, 18, '13:00:00', '2021-01-13', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(19, 2, 1, 1, 1, 'SPB21011413019', 'INV-210114019', NULL, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:08:01', '2021-01-14 00:08:01', 'menunggu', 1, 22, 19, '13:00:00', '2021-01-13', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(20, 2, 1, 1, 1, 'SPB21011413020', 'INV-210114020', NULL, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:09:12', '2021-01-14 00:09:12', 'menunggu', 1, 22, 20, '13:00:00', '2021-01-13', 'expire', NULL, NULL, NULL, 'no', NULL, 0),
(21, 2, 1, 1, 1, 'SPB21011413021', 'INV-210114021', NULL, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:10:08', '2021-01-14 00:10:15', 'menunggu', 1, 22, 21, '13:00:00', '2021-01-13', 'expire', NULL, NULL, 'https://app.sandbox.midtrans.com/snap/v1/transactions/27e8feac-6c20-49bc-9016-a9dff500b091/pdf', 'no', NULL, 0),
(22, 2, 1, 2, 2, 'SPB21011413022', 'INV-210114022', 1, 20, 'danangrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Depok', '2021-01-01', 'jl depok 1', 1, 1, '2021-01-14 00:15:13', '2021-01-14 02:37:38', 'menunggu', 1, 23, 1, '13:00:00', '2021-01-13', 'settlement', NULL, NULL, 'https://app.sandbox.midtrans.com/snap/v1/transactions/76b186af-149c-4a66-a96b-2cdbced889cb/pdf', 'no', NULL, 0),
(25, 2, 1, 1, 1, 'SPB21011713001', 'INV-210117001', NULL, 20, 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Sleman', '1995-05-09', 'Jl rw bahagia raya 14', 1, 1, '2021-01-17 05:40:57', '2021-01-17 05:44:19', 'menunggu', 1, 22, 1, '13:00:00', '2021-01-17', 'settlement', NULL, NULL, 'https://app.sandbox.midtrans.com/snap/v1/transactions/b02485df-2fc6-41bb-9fb2-395243c8bbac/pdf', 'yes', 1, 0),
(27, 1, 1, 1, 3, 'SPS21012709001', 'INV-210127001', 1, 20, 'prima@mail.com', 'Prima A', '1234567898765432', '0887652772938', 'pria', 'Depok', '2021-01-01', 'jalan aja', 1, 1, '2021-01-27 22:31:19', '2021-01-29 05:05:15', '-', 1, 22, 1, '09:00:00', '2021-01-28', 'settlement', NULL, NULL, NULL, 'no', NULL, 0),
(29, 2, 1, 2, 2, 'SPS21012911001', 'INV-210129001', 1, 21, 'isel@mail.com', 'Risela Lalusu', '1234123412341234', '085261641500', 'wanita', 'Cilacap', '2021-01-01', 'jl in aja', 1, 1, '2021-01-29 06:11:34', '2021-01-29 06:11:34', '', 1, 22, 1, '11:00:00', '2021-01-30', 'Invoice', NULL, NULL, NULL, 'no', NULL, 0),
(30, 1, 1, 1, 2, 'SPS21012912001', 'INV-210129001', 1, 21, 'rafif@mail.com', 'Rafif Lalusu', '4321432143214321', '0876543212588', 'pria', 'Luwuk', '2021-01-02', 'jl aja ya', 1, 1, '2021-01-29 06:12:58', '2021-01-29 06:12:58', '', 1, 22, 1, '12:00:00', '2021-01-30', 'Invoice', NULL, NULL, NULL, 'no', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers_home_service`
--

CREATE TABLE `customers_home_service` (
  `id` int(11) NOT NULL,
  `jenis_test` int(2) NOT NULL,
  `jenis_pemeriksaan` int(2) NOT NULL,
  `jenis_layanan` int(2) NOT NULL,
  `faskes_asal` int(2) NOT NULL,
  `invoice_number` varchar(30) DEFAULT NULL,
  `pemeriksa` int(11) DEFAULT NULL,
  `status_peserta` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `instansi` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_test` varchar(20) DEFAULT NULL,
  `tahap` int(11) DEFAULT NULL,
  `kehadiran` int(11) NOT NULL,
  `no_antrian` int(11) DEFAULT NULL,
  `jam_kunjungan` time NOT NULL,
  `tgl_kunjungan` date NOT NULL,
  `status_pembayaran` varchar(30) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `url_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers_home_service`
--

INSERT INTO `customers_home_service` (`id`, `jenis_test`, `jenis_pemeriksaan`, `jenis_layanan`, `faskes_asal`, `invoice_number`, `pemeriksa`, `status_peserta`, `email`, `nama`, `nik`, `phone`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_marketing`, `instansi`, `created_at`, `updated_at`, `status_test`, `tahap`, `kehadiran`, `no_antrian`, `jam_kunjungan`, `tgl_kunjungan`, `status_pembayaran`, `token`, `catatan`, `url_pdf`) VALUES
(1, 2, 1, 1, 1, 'INV-210117001', NULL, 0, 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '7201044707960005', '081230759128', 'pria', 'Sleman', '1995-05-09', 'Jl rw bahagia raya 14', 1, 1, '2021-01-17 05:40:57', '2021-01-17 05:44:19', 'menunggu', 1, 22, 1, '13:00:00', '2021-01-17', 'settlement', NULL, NULL, 'https://app.sandbox.midtrans.com/snap/v1/transactions/b02485df-2fc6-41bb-9fb2-395243c8bbac/pdf');

-- --------------------------------------------------------

--
-- Table structure for table `customers_overload`
--

CREATE TABLE `customers_overload` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `jenis_test` int(2) NOT NULL,
  `jenis_pemeriksaan` int(2) NOT NULL,
  `jenis_layanan` int(2) NOT NULL,
  `faskes_asal` int(2) NOT NULL,
  `customer_unique` varchar(255) NOT NULL,
  `invoice_number` varchar(30) DEFAULT NULL,
  `pemeriksa` int(11) DEFAULT NULL,
  `status_peserta` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `instansi` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_test` varchar(20) DEFAULT NULL,
  `tahap` int(11) DEFAULT NULL,
  `kehadiran` int(11) NOT NULL,
  `no_antrian` int(11) DEFAULT NULL,
  `jam_kunjungan` time NOT NULL,
  `tgl_kunjungan` date NOT NULL,
  `status_pembayaran` varchar(30) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers_overload`
--

INSERT INTO `customers_overload` (`id`, `id_customer`, `jenis_test`, `jenis_pemeriksaan`, `jenis_layanan`, `faskes_asal`, `customer_unique`, `invoice_number`, `pemeriksa`, `status_peserta`, `email`, `nama`, `nik`, `phone`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_marketing`, `instansi`, `created_at`, `updated_at`, `status_test`, `tahap`, `kehadiran`, `no_antrian`, `jam_kunjungan`, `tgl_kunjungan`, `status_pembayaran`, `token`, `catatan`) VALUES
(1, 29, 2, 1, 2, 2, 'SPS21012911001', 'INV-210129001', 1, 21, 'isel@mail.com', 'Risela Lalusu', '1234123412341234', '085261641500', 'wanita', 'Cilacap', '2021-01-01', 'jl in aja', 1, 1, '2021-01-29 06:11:34', '2021-01-29 06:11:34', '', 1, 22, 1, '11:00:00', '2021-01-30', 'Invoice', NULL, NULL),
(2, 30, 1, 1, 1, 2, 'SPS21012912001', 'INV-210129001', 1, 21, 'rafif@mail.com', 'Rafif Lalusu', '4321432143214321', '0876543212588', 'pria', 'Luwuk', '2021-01-02', 'jl aja ya', 1, 1, '2021-01-29 06:12:58', '2021-01-29 06:12:58', '', 1, 22, 1, '12:00:00', '2021-01-30', 'Invoice', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_layanan_test`
--

CREATE TABLE `data_layanan_test` (
  `id` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `id_test` int(11) NOT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
  `id_segmen` int(11) NOT NULL,
  `biaya` int(11) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_layanan_test`
--

INSERT INTO `data_layanan_test` (`id`, `id_layanan`, `id_test`, `id_pemeriksaan`, `id_segmen`, `biaya`, `time_start`, `time_end`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1100000, '07:00:00', '12:00:00', 1, 1, '2021-01-01 00:00:00', '2021-01-19 21:31:27'),
(2, 2, 1, 1, 1, 875000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', '2021-01-19 21:31:28'),
(3, 2, 2, 1, 1, 125000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', '2021-01-19 21:31:28'),
(4, 2, 3, 1, 1, 270000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', '2021-01-19 21:31:28'),
(5, 1, 1, 2, 1, 1100000, '09:00:00', '18:00:00', 1, 1, '2021-01-16 00:00:00', NULL),
(6, 2, 1, 2, 1, 1100000, '09:00:00', '18:00:00', 1, 1, '2021-01-16 00:00:00', NULL),
(7, 1, 1, 1, 2, 1100000, '07:00:00', '12:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(8, 2, 1, 1, 2, 875000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(9, 2, 2, 1, 2, 125000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(10, 2, 3, 1, 2, 250000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(12, 2, 1, 2, 2, 1100000, '09:00:00', '18:00:00', 1, 1, '2021-01-16 00:00:00', NULL),
(13, 1, 1, 1, 3, 1100000, '07:00:00', '12:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(14, 2, 1, 1, 3, 875000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(15, 2, 2, 1, 3, 125000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(16, 2, 3, 1, 3, 250000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(17, 1, 1, 2, 3, 1100000, '09:00:00', '18:00:00', 1, 1, '2021-01-16 00:00:00', NULL),
(18, 2, 1, 2, 3, 1100000, '09:00:00', '18:00:00', 1, 1, '2021-01-16 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_pembayaran`
--

CREATE TABLE `data_pembayaran` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `tipe_pembayaran` varchar(10) NOT NULL DEFAULT 'midtrans',
  `amount` varchar(255) DEFAULT NULL,
  `jenis_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pembayaran`
--

INSERT INTO `data_pembayaran` (`id`, `id_customer`, `tipe_pembayaran`, `amount`, `jenis_pembayaran`, `status_pembayaran`, `created_at`, `updated_at`) VALUES
(1, 1, 'midtrans', '', NULL, 'expire', '2021-01-03 21:50:31', '2021-01-03 21:50:31'),
(2, 2, 'midtrans', '', NULL, 'expire', '2021-01-03 21:54:03', '2021-01-03 21:54:03'),
(3, 3, 'midtrans', '', NULL, 'expire', '2021-01-03 21:54:32', '2021-01-03 21:54:32'),
(4, 4, 'midtrans', '', NULL, 'expire', '2021-01-03 21:56:51', '2021-01-03 21:56:51'),
(5, 8, 'midtrans', '', NULL, 'expire', '2021-01-09 12:29:07', '2021-01-09 12:29:07'),
(7, 10, 'midtrans', '', NULL, 'expire', '2021-01-10 16:28:13', '2021-01-10 16:28:13'),
(8, 11, 'midtrans', '', NULL, 'expire', '2021-01-10 17:01:51', '2021-01-10 17:01:51'),
(9, 12, 'midtrans', NULL, NULL, 'expire', '2021-01-14 00:00:10', '2021-01-14 00:00:10'),
(10, 13, 'midtrans', NULL, NULL, 'expire', '2021-01-14 00:01:02', '2021-01-14 00:01:02'),
(11, 14, 'midtrans', NULL, NULL, 'expire', '2021-01-14 00:03:28', '2021-01-14 00:03:28'),
(12, 15, 'midtrans', NULL, NULL, 'expire', '2021-01-14 00:04:39', '2021-01-14 00:04:39'),
(13, 16, 'midtrans', NULL, NULL, 'expire', '2021-01-14 00:05:12', '2021-01-14 00:05:12'),
(14, 17, 'midtrans', NULL, NULL, 'expire', '2021-01-14 00:06:37', '2021-01-14 00:06:37'),
(15, 18, 'midtrans', NULL, NULL, 'expire', '2021-01-14 00:07:23', '2021-01-14 00:07:23'),
(16, 19, 'midtrans', NULL, NULL, 'expire', '2021-01-14 00:08:02', '2021-01-14 00:08:02'),
(17, 20, 'midtrans', NULL, NULL, 'expire', '2021-01-14 00:09:13', '2021-01-14 00:09:13'),
(18, 21, 'midtrans', '1100000.00', NULL, 'expire', '2021-01-14 00:10:08', '2021-01-14 00:10:15'),
(19, 22, 'midtrans', '1100000.00', 'bank_transfer', 'settlement', '2021-01-14 00:15:13', '2021-01-14 00:34:29'),
(20, 9, 'midtrans', '1100000.00', 'bank_transfer', 'settlement', '2021-01-14 00:00:00', NULL),
(21, 25, 'midtrans', '1100000.00', 'bank_transfer', 'settlement', '2021-01-17 05:40:57', '2021-01-17 05:44:19'),
(22, 27, 'langsung', '1100000', 'invoice', 'settlement', '2021-01-27 22:31:19', '2021-01-27 22:31:19'),
(23, 29, 'langsung', '875000', 'Invoice', 'Invoice', '2021-01-29 06:11:34', '2021-01-29 06:11:34'),
(24, 30, 'langsung', '1100000', 'Invoice', 'Invoice', '2021-01-29 06:12:58', '2021-01-29 06:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `data_trafik_gudang`
--

CREATE TABLE `data_trafik_gudang` (
  `id` int(11) NOT NULL,
  `id_barang_gudang` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `img_ttd` text DEFAULT NULL,
  `qrcode_ttd` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `id_user`, `nama`, `phone`, `img_ttd`, `qrcode_ttd`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 5, 'abc', '0824983948932', '', 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http://localhost:8080/assets/dokter&choe=UTF-8', 0, 0, '2021-01-19 19:45:36', '2021-01-19 20:48:36'),
(5, 6, 'waru', '080804548594', '', 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http://localhost:8080/assets/dokter&choe=UTF-8', 0, 0, '2021-01-19 20:43:47', '2021-01-19 20:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `faskes`
--

CREATE TABLE `faskes` (
  `id` int(11) NOT NULL,
  `nama_faskes` varchar(255) NOT NULL,
  `health_facility` varchar(255) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `email` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `kota` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faskes`
--

INSERT INTO `faskes` (`id`, `nama_faskes`, `health_facility`, `phone`, `email`, `alamat`, `kota`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'ABC', 'DEF', '081230759128', 'abcdef@mail.com', 'Jl Cendrawasih 15B', 1, 1, 1, '2021-01-09 02:35:37', '2021-01-09 02:35:37'),
(3, 'Def', 'DEFDEF', '0909887766123', 'def@mail.com', 'jl om om aja', 2, 1, 1, '2021-01-29 04:30:48', '2021-01-29 04:30:48');

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id` int(11) NOT NULL,
  `kategori_gudang` int(11) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `image_barang` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `status_barang` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id`, `kategori_gudang`, `kode_barang`, `nama_barang`, `image_barang`, `stock`, `status_barang`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'QT-60009200592e1', 'Printer HP', '1610650112_89269457420401ab72cd.webp', 5, 15, 1, 1, '2021-01-15 01:48:32', '2021-01-15 02:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_laboratorium`
--

CREATE TABLE `hasil_laboratorium` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_alat` int(11) DEFAULT NULL,
  `id_sample` int(11) DEFAULT NULL,
  `id_dokter` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `status_cov` int(11) DEFAULT NULL,
  `status_gene` int(11) DEFAULT NULL,
  `status_orf` int(11) DEFAULT NULL,
  `detail_ic` varchar(255) DEFAULT NULL,
  `status_igg` int(11) DEFAULT NULL,
  `status_igm` int(11) DEFAULT NULL,
  `status_antigen` int(11) DEFAULT NULL,
  `status_molecular` int(11) DEFAULT NULL,
  `status_pemeriksaan` int(11) NOT NULL,
  `status_kirim` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `waktu_ambil_sampling` datetime DEFAULT NULL,
  `waktu_periksa_sampling` datetime DEFAULT NULL,
  `waktu_selesai_periksa` datetime DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil_laboratorium`
--

INSERT INTO `hasil_laboratorium` (`id`, `id_customer`, `id_alat`, `id_sample`, `id_dokter`, `id_petugas`, `status_cov`, `status_gene`, `status_orf`, `detail_ic`, `status_igg`, `status_igm`, `status_antigen`, `status_molecular`, `status_pemeriksaan`, `status_kirim`, `created_by`, `updated_by`, `created_at`, `updated_at`, `waktu_ambil_sampling`, `waktu_periksa_sampling`, `waktu_selesai_periksa`, `catatan`) VALUES
(1, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 9, 1, 1, '2021-01-25 18:52:26', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `id` int(11) NOT NULL,
  `kota` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tgl_lahir` date NOT NULL,
  `phone` varchar(13) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_discounted` enum('yes','no') NOT NULL DEFAULT 'no',
  `discount` float DEFAULT NULL,
  `pic_marketing` int(11) DEFAULT NULL,
  `afiliated` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`id`, `kota`, `nama`, `alamat`, `nama_user`, `tempat_lahir`, `tgl_lahir`, `phone`, `email`, `is_discounted`, `discount`, `pic_marketing`, `afiliated`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 0, 'Umum', NULL, NULL, NULL, '0000-00-00', '', '', 'no', NULL, NULL, 'no', '2021-01-03 00:00:00', '2021-01-03 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_layanan`
--

CREATE TABLE `jenis_layanan` (
  `id` int(11) NOT NULL,
  `nama_layanan` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_layanan`
--

INSERT INTO `jenis_layanan` (`id`, `nama_layanan`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'SAMEDAY', 1, 1, '2021-01-01 00:00:00', NULL),
(2, 'BASIC', 1, 1, '2021-01-01 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pemeriksaan`
--

CREATE TABLE `jenis_pemeriksaan` (
  `id` int(11) NOT NULL,
  `nama_pemeriksaan` varchar(30) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_pemeriksaan`
--

INSERT INTO `jenis_pemeriksaan` (`id`, `nama_pemeriksaan`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'WALK IN', 1, 1, '2021-01-01 00:00:00', NULL),
(2, 'HOME SERVICE', 1, 1, '2021-01-01 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_sample`
--

CREATE TABLE `jenis_sample` (
  `id` int(11) NOT NULL,
  `nama_sample` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_sample`
--

INSERT INTO `jenis_sample` (`id`, `nama_sample`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Orofaring & Nasofaring', 1, 1, '2021-01-11 00:00:00', NULL),
(2, 'Sputum', 1, 1, '2021-01-11 00:00:00', NULL),
(3, 'Saliva', 1, 1, '2021-01-11 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_test`
--

CREATE TABLE `jenis_test` (
  `id` int(11) NOT NULL,
  `nama_test` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_test`
--

INSERT INTO `jenis_test` (`id`, `nama_test`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'SWAB PCR', 1, 1, '2021-01-01 00:00:00', NULL),
(2, 'RAPID TEST', 1, 1, '2021-01-01 00:00:00', NULL),
(3, 'SWAB ANTIGEN', 1, 1, '2021-01-01 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_gudang`
--

CREATE TABLE `kategori_gudang` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `status_kategori_gudang` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_gudang`
--

INSERT INTO `kategori_gudang` (`id`, `nama_kategori`, `status_kategori_gudang`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Printer', 16, 1, 1, '2021-01-15 01:13:33', '2021-01-15 02:11:02'),
(2, 'Komputer', 16, 1, 1, '2021-01-15 01:21:53', '2021-01-15 02:11:10'),
(3, 'Kertas', 16, 1, 1, '2021-01-15 02:10:20', '2021-01-15 02:10:20');

-- --------------------------------------------------------

--
-- Table structure for table `kehadiran`
--

CREATE TABLE `kehadiran` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kode_referal`
--

CREATE TABLE `kode_referal` (
  `id` int(11) NOT NULL,
  `kode_referal` varchar(10) NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id` int(11) NOT NULL,
  `nama_kota` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id`, `nama_kota`, `city`, `province`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Jakarta Utara', 'North Jakarta', 'DKI Jakarta', 1, 1, '2021-01-08 23:59:16', '2021-01-09 00:07:04'),
(2, 'Jakarta Selatan', 'South Jakarta', 'DKI Jakarta', 1, 1, '2021-01-16 23:22:39', '2021-01-16 23:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `kuota_customer`
--

CREATE TABLE `kuota_customer` (
  `id` int(11) NOT NULL,
  `jenis_test_layanan` int(11) NOT NULL,
  `jam` time NOT NULL,
  `kuota` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuota_customer`
--

INSERT INTO `kuota_customer` (`id`, `jenis_test_layanan`, `jam`, `kuota`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:29'),
(2, 1, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:29'),
(3, 1, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:29'),
(4, 1, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:29'),
(5, 1, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:29'),
(6, 1, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:29'),
(7, 1, '07:00:00', 50, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:29'),
(8, 1, '08:00:00', 50, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(9, 1, '09:00:00', 50, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(10, 1, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(11, 1, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(12, 1, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(13, 1, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(14, 1, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(15, 1, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(16, 1, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(17, 1, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(18, 1, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(19, 1, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(20, 1, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(21, 1, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(22, 1, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(23, 1, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(24, 1, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:30'),
(25, 2, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(26, 2, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(27, 2, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(28, 2, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(29, 2, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(30, 2, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(31, 2, '07:00:00', 50, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(32, 2, '08:00:00', 50, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(33, 2, '09:00:00', 50, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(34, 2, '10:00:00', 50, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(35, 2, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(36, 2, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(37, 2, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(38, 2, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(39, 2, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(40, 2, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(41, 2, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(42, 2, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(43, 2, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(44, 2, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(45, 2, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(46, 2, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(47, 2, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:50'),
(48, 2, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-25 18:44:51'),
(49, 3, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(50, 3, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(51, 3, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(52, 3, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(53, 3, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(54, 3, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(55, 3, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(56, 3, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(57, 3, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(58, 3, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(59, 3, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(60, 3, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(61, 3, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(62, 3, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(63, 3, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(64, 3, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(65, 3, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(66, 3, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(67, 3, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(68, 3, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(69, 3, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(70, 3, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(71, 3, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(72, 3, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(73, 4, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(74, 4, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(75, 4, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(76, 4, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(77, 4, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(78, 4, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(79, 4, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(80, 4, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(81, 4, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(82, 4, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(83, 4, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(84, 4, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(85, 4, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(86, 4, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(87, 4, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(88, 4, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(89, 4, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(90, 4, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(91, 4, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(92, 4, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(93, 4, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(94, 4, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(95, 4, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(96, 4, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(97, 5, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(98, 5, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(99, 5, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(100, 5, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(101, 5, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(102, 5, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(103, 5, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(104, 5, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(105, 5, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(106, 5, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(107, 5, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(108, 5, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(109, 5, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(110, 5, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(111, 5, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(112, 5, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(113, 5, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(114, 5, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(115, 5, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(116, 5, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(117, 5, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(118, 5, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(119, 5, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(120, 5, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:06', '2021-01-21 04:26:06'),
(121, 6, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(122, 6, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(123, 6, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(124, 6, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(125, 6, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(126, 6, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(127, 6, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(128, 6, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(129, 6, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(130, 6, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(131, 6, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(132, 6, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(133, 6, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(134, 6, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(135, 6, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(136, 6, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(137, 6, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(138, 6, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(139, 6, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(140, 6, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(141, 6, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(142, 6, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(143, 6, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(144, 6, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(145, 7, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(146, 7, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(147, 7, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(148, 7, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(149, 7, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(150, 7, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(151, 7, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(152, 7, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(153, 7, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(154, 7, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(155, 7, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(156, 7, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(157, 7, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(158, 7, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(159, 7, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(160, 7, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(161, 7, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(162, 7, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(163, 7, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(164, 7, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(165, 7, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(166, 7, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(167, 7, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(168, 7, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(169, 8, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(170, 8, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(171, 8, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(172, 8, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(173, 8, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(174, 8, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(175, 8, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(176, 8, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(177, 8, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(178, 8, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(179, 8, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(180, 8, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(181, 8, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(182, 8, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(183, 8, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(184, 8, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(185, 8, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(186, 8, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(187, 8, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(188, 8, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(189, 8, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(190, 8, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(191, 8, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(192, 8, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(193, 9, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(194, 9, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(195, 9, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(196, 9, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(197, 9, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(198, 9, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(199, 9, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(200, 9, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(201, 9, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(202, 9, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(203, 9, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(204, 9, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(205, 9, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(206, 9, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(207, 9, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(208, 9, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(209, 9, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(210, 9, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(211, 9, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(212, 9, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(213, 9, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(214, 9, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(215, 9, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(216, 9, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(217, 10, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(218, 10, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(219, 10, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(220, 10, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(221, 10, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(222, 10, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(223, 10, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(224, 10, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(225, 10, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(226, 10, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(227, 10, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(228, 10, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(229, 10, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(230, 10, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(231, 10, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(232, 10, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(233, 10, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(234, 10, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(235, 10, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(236, 10, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(237, 10, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(238, 10, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(239, 10, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(240, 10, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(241, 12, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(242, 12, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(243, 12, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(244, 12, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(245, 12, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(246, 12, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(247, 12, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(248, 12, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(249, 12, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(250, 12, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(251, 12, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(252, 12, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(253, 12, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(254, 12, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(255, 12, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(256, 12, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(257, 12, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(258, 12, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(259, 12, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(260, 12, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(261, 12, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(262, 12, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(263, 12, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(264, 12, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(265, 13, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(266, 13, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(267, 13, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(268, 13, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(269, 13, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(270, 13, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(271, 13, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(272, 13, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(273, 13, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(274, 13, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(275, 13, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(276, 13, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(277, 13, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(278, 13, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(279, 13, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(280, 13, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(281, 13, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(282, 13, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(283, 13, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(284, 13, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(285, 13, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(286, 13, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(287, 13, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(288, 13, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(289, 14, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(290, 14, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(291, 14, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(292, 14, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(293, 14, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(294, 14, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(295, 14, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(296, 14, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(297, 14, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(298, 14, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(299, 14, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(300, 14, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(301, 14, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(302, 14, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(303, 14, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(304, 14, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(305, 14, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(306, 14, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(307, 14, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(308, 14, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(309, 14, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(310, 14, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(311, 14, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(312, 14, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(313, 15, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(314, 15, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(315, 15, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(316, 15, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(317, 15, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(318, 15, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(319, 15, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(320, 15, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(321, 15, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(322, 15, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(323, 15, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(324, 15, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(325, 15, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(326, 15, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(327, 15, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(328, 15, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(329, 15, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(330, 15, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(331, 15, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(332, 15, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(333, 15, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(334, 15, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(335, 15, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(336, 15, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(337, 16, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(338, 16, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(339, 16, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(340, 16, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(341, 16, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(342, 16, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(343, 16, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(344, 16, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(345, 16, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(346, 16, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(347, 16, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(348, 16, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(349, 16, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(350, 16, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(351, 16, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(352, 16, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(353, 16, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(354, 16, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(355, 16, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(356, 16, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(357, 16, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(358, 16, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(359, 16, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(360, 16, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(361, 17, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(362, 17, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(363, 17, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(364, 17, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(365, 17, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(366, 17, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(367, 17, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(368, 17, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(369, 17, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(370, 17, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(371, 17, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(372, 17, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(373, 17, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(374, 17, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(375, 17, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(376, 17, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(377, 17, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(378, 17, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(379, 17, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(380, 17, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(381, 17, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(382, 17, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(383, 17, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(384, 17, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(385, 18, '01:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(386, 18, '02:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(387, 18, '03:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(388, 18, '04:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(389, 18, '05:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(390, 18, '06:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(391, 18, '07:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(392, 18, '08:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(393, 18, '09:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(394, 18, '10:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(395, 18, '11:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(396, 18, '12:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(397, 18, '13:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(398, 18, '14:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(399, 18, '15:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(400, 18, '16:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(401, 18, '17:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(402, 18, '18:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(403, 18, '19:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(404, 18, '20:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(405, 18, '21:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(406, 18, '22:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(407, 18, '23:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07'),
(408, 18, '24:00:00', 0, 1, 1, 1, '2021-01-21 04:26:07', '2021-01-21 04:26:07');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_input`
--

CREATE TABLE `lokasi_input` (
  `id` int(11) NOT NULL,
  `id_kota` int(11) NOT NULL,
  `url_kop` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi_input`
--

INSERT INTO `lokasi_input` (`id`, `id_kota`, `url_kop`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'http://speedlab.galeritekno.com/asset/kop.png', 1, 1, '2021-01-09 01:21:20', '2021-01-09 01:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `marketing`
--

CREATE TABLE `marketing` (
  `id` int(11) NOT NULL,
  `id_kota` int(11) NOT NULL,
  `nama_marketing` varchar(255) NOT NULL,
  `is_afiliated_hs` varchar(3) DEFAULT 'no',
  `is_afiliated_rujukan` varchar(3) DEFAULT 'no',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marketing`
--

INSERT INTO `marketing` (`id`, `id_kota`, `nama_marketing`, `is_afiliated_hs`, `is_afiliated_rujukan`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Atas Permintaan Sendiri', 'no', 'no', 1, 1, '2021-01-01 00:00:00', '2021-01-30 17:24:15');

-- --------------------------------------------------------

--
-- Table structure for table `master_peminjaman`
--

CREATE TABLE `master_peminjaman` (
  `id` int(11) NOT NULL,
  `nama_peminjam` varchar(100) NOT NULL,
  `status_peminjaman` int(11) NOT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_segmen`
--

CREATE TABLE `master_segmen` (
  `id` int(11) NOT NULL,
  `nama_segmen` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_segmen`
--

INSERT INTO `master_segmen` (`id`, `nama_segmen`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'APS', 1, 1, '2021-01-16 00:00:00', NULL),
(2, 'CORPORATE', 1, 1, '2021-01-16 00:00:00', NULL),
(3, 'RUJUKAN', 1, 1, '2021-01-16 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `id_jenis_test` int(11) NOT NULL,
  `jenis_menu` varchar(30) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `id_jenis_test`, `jenis_menu`, `keterangan`, `img_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'swab', 'SWAB PCR', 'swab.jpg', '2021-01-02 00:00:00', NULL),
(2, 2, 'rapid', 'RAPID TEST', 'rapid.jpg', '2021-01-02 00:00:00', NULL),
(3, 3, 'swab', 'SWAB ANTIGEN', 'swab.jpg', '2021-01-02 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nav`
--

CREATE TABLE `nav` (
  `id` int(11) NOT NULL,
  `nama_nav` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pemanggilan`
--

CREATE TABLE `pemanggilan` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_layanan_test` int(11) NOT NULL,
  `status_pemanggilan` int(11) NOT NULL DEFAULT 11,
  `tgl_kunjungan` date NOT NULL,
  `jam_kunjungan` time NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemanggilan`
--

INSERT INTO `pemanggilan` (`id`, `id_customer`, `id_layanan_test`, `status_pemanggilan`, `tgl_kunjungan`, `jam_kunjungan`, `created_at`, `updated_at`) VALUES
(1, 25, 2, 11, '0000-00-00', '00:00:00', '2021-01-17 05:41:14', '2021-01-17 05:41:14'),
(2, 25, 2, 11, '0000-00-00', '00:00:00', '2021-01-17 05:43:31', '2021-01-17 05:43:31'),
(3, 25, 2, 11, '0000-00-00', '00:00:00', '2021-01-17 05:43:36', '2021-01-17 05:43:36'),
(4, 25, 2, 11, '0000-00-00', '00:00:00', '2021-01-17 05:44:19', '2021-01-17 05:44:19');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `nama`, `phone`, `email`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Dananggg', '081230759128', 'danangrahmanda@mail.com', 1, 1, '2021-01-09 01:47:37', '2021-01-19 20:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `status_hasil`
--

CREATE TABLE `status_hasil` (
  `id` int(11) NOT NULL,
  `jenis_status` varchar(255) NOT NULL,
  `nama_status` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_hasil`
--

INSERT INTO `status_hasil` (`id`, `jenis_status`, `nama_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'status_cov', 'Negatif', 1, 1, '2021-01-11 00:00:00', NULL),
(2, 'status_cov', 'Positif', 1, 1, '2021-01-11 00:00:00', NULL),
(3, 'status_gene', 'Undetection', 1, 1, '2021-01-11 00:00:00', NULL),
(4, 'status_gene', 'Detection', 1, 1, '2021-01-11 00:00:00', NULL),
(5, 'status_orf', 'Undetection', 1, 1, '2021-01-11 00:00:00', NULL),
(6, 'status_orf', 'Detection', 1, 1, '2021-01-11 00:00:00', NULL),
(7, 'status_pemeriksaan', 'Pemeriksaan Sample', 1, 1, '2021-01-11 00:00:00', NULL),
(8, 'status_pemeriksaan', 'Selesai', 1, 1, '2021-01-11 00:00:00', NULL),
(9, 'status_kirim', 'Belum Dikirim', 1, 1, '2021-01-11 00:00:00', NULL),
(10, 'status_kirim', 'Sudah Dikirim', 1, 1, '2021-01-11 00:00:00', NULL),
(11, 'status_pemanggilan', 'Dalam Antrian', 1, 1, '2021-01-14 00:00:00', NULL),
(12, 'status_pemanggilan', 'Dalam Panggilan', 1, 1, '2021-01-14 00:00:00', NULL),
(13, 'status_pemanggilan', 'Sudah Terpanggil', 1, 1, '2021-01-14 00:00:00', NULL),
(14, 'status_barang', 'out', 1, 1, '2021-01-14 00:00:00', NULL),
(15, 'status_barang', 'in', 1, 1, '2021-01-14 00:00:00', NULL),
(16, 'status_kategori_gudang', 'active', 1, 1, '2021-01-14 00:00:00', NULL),
(17, 'status_kategori_gudang', 'inactive', 1, 1, '2021-01-14 00:00:00', NULL),
(18, 'status_peminjaman', 'keluar', 1, 1, '2021-01-15 00:00:00', NULL),
(19, 'status_peminjaman', 'masuk', 1, 1, '2021-01-15 00:00:00', NULL),
(20, 'status_peserta', 'normal', 1, 1, '2021-01-16 00:00:00', NULL),
(21, 'status_peserta', 'overload', 1, 1, '2021-01-16 00:00:00', NULL),
(22, 'status_kehadiran', 'belum hadir', 1, 1, '2021-01-16 00:00:00', NULL),
(23, 'status_kehadiran', 'hadir', 1, 1, '2021-01-16 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_parameter`
--

CREATE TABLE `system_parameter` (
  `id` int(11) NOT NULL,
  `vgroup` varchar(255) NOT NULL,
  `parameter` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_parameter`
--

INSERT INTO `system_parameter` (`id`, `vgroup`, `parameter`, `value`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'MIDTRANS_KEY', 'SERVER_KEY', 'TWlkLXNlcnZlci16aUJXZ01JTXZkWTZYZDdQc1RnQmRuRXo=', '1', 1, 1, '2021-01-02 00:00:00', NULL),
(2, 'MIDTRANS_KEY', 'CLIENT_KEY', 'TWlkLWNsaWVudC1jb3EtSXVKVEYxblpMcVRF', '1', 1, 1, '2021-01-02 00:00:00', NULL),
(3, 'URL', 'APP_REGISTRATION', 'aHR0cHM6Ly9yZWcucXVpY2t0ZXN0Lmlk', '1', 1, 1, '2021-01-30 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `user_level`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'admin@admiin2.com', '0192023a7bbd73250516f069df18b500', 1, 1, 1, '2020-12-31 23:18:05', '2020-12-31 23:18:05'),
(2, 'isel.lalusu@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 3, 1, 1, '2021-01-18 21:36:25', '2021-01-18 21:36:25'),
(3, 'isel.lalusu@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 3, 1, 1, '2021-01-18 21:36:50', '2021-01-18 21:36:50'),
(5, 'abc@mail.com', '9a361ed860ec2617da5af72079594a21', 0, 0, 0, '2021-01-19 19:45:36', '2021-01-19 20:48:36'),
(6, 'waru@mail.com', 'dc6c6619484ec67307f873ea552d59ae', 7, 1, 1, '2021-01-19 20:43:47', '2021-01-19 20:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `users_detail`
--

CREATE TABLE `users_detail` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_detail`
--

INSERT INTO `users_detail` (`id`, `id_user`, `id_lokasi`, `nama`, `alamat`, `phone`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Wisnu', NULL, NULL, '2020-12-31 23:18:05', NULL),
(2, 3, 0, 'isel lalusu', NULL, '085261641500', '2021-01-18 21:36:50', '2021-01-18 21:36:50'),
(4, 5, 1, 'abc', NULL, '0824983948932', '2021-01-19 19:45:36', '2021-01-19 19:45:36'),
(5, 6, 1, 'waru', NULL, '080804548594', '2021-01-19 20:43:47', '2021-01-19 20:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `users_level`
--

CREATE TABLE `users_level` (
  `id` int(11) NOT NULL,
  `level` varchar(30) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_level`
--

INSERT INTO `users_level` (`id`, `level`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'manager marketing', NULL, NULL),
(3, 'marketing', NULL, NULL),
(4, 'front office', NULL, NULL),
(5, 'instansi', NULL, NULL),
(6, 'petugas', NULL, NULL),
(7, 'dokter', NULL, NULL),
(8, 'admin hasil', NULL, NULL),
(99, 'super admin', NULL, NULL),
(100, 'swabber', NULL, NULL),
(101, 'finance', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_login`
--

CREATE TABLE `users_login` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_nav` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `afiliasi`
--
ALTER TABLE `afiliasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `value` (`value`);

--
-- Indexes for table `alat_pemeriksaan`
--
ALTER TABLE `alat_pemeriksaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bilik_swabber`
--
ALTER TABLE `bilik_swabber`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_bilik` (`nomor_bilik`),
  ADD KEY `asigned_to_Fk` (`assigned_to`),
  ADD KEY `jenis_test_fk1` (`jenis_test`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_status_peserta_fk` (`status_peserta`);

--
-- Indexes for table `customers_home_service`
--
ALTER TABLE `customers_home_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers_overload`
--
ALTER TABLE `customers_overload`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cust_over_fk` (`id_customer`);

--
-- Indexes for table `data_layanan_test`
--
ALTER TABLE `data_layanan_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_layanan_fk` (`id_layanan`),
  ADD KEY `id_test` (`id_test`),
  ADD KEY `id_pemeriksaan_fk` (`id_pemeriksaan`),
  ADD KEY `id_segmen_fk` (`id_segmen`);

--
-- Indexes for table `data_pembayaran`
--
ALTER TABLE `data_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_trafik_gudang`
--
ALTER TABLE `data_trafik_gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faskes`
--
ALTER TABLE `faskes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `hasil_laboratorium`
--
ALTER TABLE `hasil_laboratorium`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_status_kirim_fk` (`status_kirim`),
  ADD KEY `id_cust_fk` (`id_customer`),
  ADD KEY `status_cov_fk` (`status_cov`),
  ADD KEY `status_gene_fk` (`status_gene`),
  ADD KEY `status_igg_fk` (`status_igg`),
  ADD KEY `status_igm_fk` (`status_igm`),
  ADD KEY `alat_fk` (`id_alat`),
  ADD KEY `dokter_fk` (`id_dokter`),
  ADD KEY `petugas_fk` (`id_petugas`),
  ADD KEY `antigen_fk` (`status_antigen`),
  ADD KEY `molecular_fk` (`status_molecular`),
  ADD KEY `orf_fk` (`status_orf`),
  ADD KEY `pemeriksaan_fk` (`status_pemeriksaan`);

--
-- Indexes for table `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_pemeriksaan`
--
ALTER TABLE `jenis_pemeriksaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_sample`
--
ALTER TABLE `jenis_sample`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_test`
--
ALTER TABLE `jenis_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_gudang`
--
ALTER TABLE `kategori_gudang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_kategori_fk` (`status_kategori_gudang`);

--
-- Indexes for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kode_referal`
--
ALTER TABLE `kode_referal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_referal` (`kode_referal`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kuota_customer`
--
ALTER TABLE `kuota_customer`
  ADD PRIMARY KEY (`id`,`updated_at`);

--
-- Indexes for table `lokasi_input`
--
ALTER TABLE `lokasi_input`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketing`
--
ALTER TABLE `marketing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_peminjaman`
--
ALTER TABLE `master_peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_segmen`
--
ALTER TABLE `master_segmen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nav`
--
ALTER TABLE `nav`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemanggilan`
--
ALTER TABLE `pemanggilan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_hasil`
--
ALTER TABLE `status_hasil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_parameter`
--
ALTER TABLE `system_parameter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_detail`
--
ALTER TABLE `users_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_fk` (`id_user`);

--
-- Indexes for table `users_level`
--
ALTER TABLE `users_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_login`
--
ALTER TABLE `users_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nav_fk` (`id_nav`),
  ADD KEY `id_user_fk_login` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `afiliasi`
--
ALTER TABLE `afiliasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alat_pemeriksaan`
--
ALTER TABLE `alat_pemeriksaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bilik_swabber`
--
ALTER TABLE `bilik_swabber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `customers_home_service`
--
ALTER TABLE `customers_home_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers_overload`
--
ALTER TABLE `customers_overload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_layanan_test`
--
ALTER TABLE `data_layanan_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `data_pembayaran`
--
ALTER TABLE `data_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `data_trafik_gudang`
--
ALTER TABLE `data_trafik_gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faskes`
--
ALTER TABLE `faskes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hasil_laboratorium`
--
ALTER TABLE `hasil_laboratorium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jenis_pemeriksaan`
--
ALTER TABLE `jenis_pemeriksaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenis_sample`
--
ALTER TABLE `jenis_sample`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenis_test`
--
ALTER TABLE `jenis_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori_gudang`
--
ALTER TABLE `kategori_gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_referal`
--
ALTER TABLE `kode_referal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kota`
--
ALTER TABLE `kota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kuota_customer`
--
ALTER TABLE `kuota_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=409;

--
-- AUTO_INCREMENT for table `lokasi_input`
--
ALTER TABLE `lokasi_input`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `marketing`
--
ALTER TABLE `marketing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `master_peminjaman`
--
ALTER TABLE `master_peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_segmen`
--
ALTER TABLE `master_segmen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nav`
--
ALTER TABLE `nav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemanggilan`
--
ALTER TABLE `pemanggilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_hasil`
--
ALTER TABLE `status_hasil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `system_parameter`
--
ALTER TABLE `system_parameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_detail`
--
ALTER TABLE `users_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_level`
--
ALTER TABLE `users_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `users_login`
--
ALTER TABLE `users_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bilik_swabber`
--
ALTER TABLE `bilik_swabber`
  ADD CONSTRAINT `asigned_to_Fk` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jenis_test_fk1` FOREIGN KEY (`jenis_test`) REFERENCES `data_layanan_test` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customers_overload`
--
ALTER TABLE `customers_overload`
  ADD CONSTRAINT `id_cust_over_fk` FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_layanan_test`
--
ALTER TABLE `data_layanan_test`
  ADD CONSTRAINT `data_layanan_test_ibfk_1` FOREIGN KEY (`id_test`) REFERENCES `jenis_test` (`id`),
  ADD CONSTRAINT `id_layanan_fk` FOREIGN KEY (`id_layanan`) REFERENCES `jenis_layanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_pemeriksaan_fk` FOREIGN KEY (`id_pemeriksaan`) REFERENCES `jenis_pemeriksaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_segmen_fk` FOREIGN KEY (`id_segmen`) REFERENCES `master_segmen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hasil_laboratorium`
--
ALTER TABLE `hasil_laboratorium`
  ADD CONSTRAINT `alat_fk` FOREIGN KEY (`id_alat`) REFERENCES `alat_pemeriksaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `antigen_fk` FOREIGN KEY (`status_antigen`) REFERENCES `status_hasil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dokter_fk` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_cust_fk` FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_status_kirim_fk` FOREIGN KEY (`status_kirim`) REFERENCES `status_hasil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `molecular_fk` FOREIGN KEY (`status_molecular`) REFERENCES `status_hasil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orf_fk` FOREIGN KEY (`status_orf`) REFERENCES `status_hasil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemeriksaan_fk` FOREIGN KEY (`status_pemeriksaan`) REFERENCES `status_hasil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `petugas_fk` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `status_cov_fk` FOREIGN KEY (`status_cov`) REFERENCES `status_hasil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `status_gene_fk` FOREIGN KEY (`status_gene`) REFERENCES `status_hasil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `status_igg_fk` FOREIGN KEY (`status_igg`) REFERENCES `status_hasil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `status_igm_fk` FOREIGN KEY (`status_igm`) REFERENCES `status_hasil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kategori_gudang`
--
ALTER TABLE `kategori_gudang`
  ADD CONSTRAINT `status_kategori_fk` FOREIGN KEY (`status_kategori_gudang`) REFERENCES `status_hasil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_detail`
--
ALTER TABLE `users_detail`
  ADD CONSTRAINT `id_user_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_login`
--
ALTER TABLE `users_login`
  ADD CONSTRAINT `id_nav_fk` FOREIGN KEY (`id_nav`) REFERENCES `nav` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_user_fk_login` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
