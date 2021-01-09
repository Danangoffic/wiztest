-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2021 at 09:58 AM
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
-- Database: `wizlab`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `jenis_test` int(11) NOT NULL,
  `jenis_pemeriksaan` int(11) NOT NULL,
  `jenis_layanan` int(11) NOT NULL,
  `faskes_asal` int(11) NOT NULL,
  `customer_unique` varchar(255) NOT NULL,
  `invoice_number` varchar(30) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `phone` char(13) NOT NULL,
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
  `kehadiran` enum('0','1') NOT NULL DEFAULT '0',
  `no_antrian` int(11) DEFAULT NULL,
  `jam_kunjungan` time NOT NULL,
  `tgl_kunjungan` date NOT NULL,
  `status_pembayaran` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `token` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `jenis_test`, `jenis_pemeriksaan`, `jenis_layanan`, `faskes_asal`, `customer_unique`, `invoice_number`, `email`, `nama`, `nik`, `phone`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_marketing`, `instansi`, `created_at`, `updated_at`, `status_test`, `tahap`, `kehadiran`, `no_antrian`, `jam_kunjungan`, `tgl_kunjungan`, `status_pembayaran`, `token`, `catatan`) VALUES
(1, 1, 1, 1, 1, 'SPS2101031', 'INV-210103001', 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan Jakarta', 1, 1, '2021-01-03 21:50:30', '2021-01-03 21:50:31', 'menunggu', 1, '1', 1, '12:00:00', '2021-01-04', 'paid', NULL, NULL),
(2, 1, 1, 1, 1, 'SPS2101031', 'INV-210103002', 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan Jakarta', 1, 1, '2021-01-03 21:54:03', '2021-01-03 21:54:03', 'menunggu', 1, '0', 2, '12:00:00', '2021-01-04', 'unpaid', NULL, NULL),
(3, 3, 1, 1, 1, 'RTB2101031', 'INV-210103001', 'danang.a.rahmanda@danangoffic.xyz', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan rawa bahagia', 1, 1, '2021-01-03 21:54:32', '2021-01-03 21:54:32', 'menunggu', 1, '0', 1, '11:00:00', '2021-01-07', 'unpaid', NULL, NULL),
(4, 4, 1, 1, 1, 'SAB21010312001', 'INV-210103001', 'haibisnisdotcom@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan apa aja', 1, 1, '2021-01-03 21:56:50', '2021-01-03 21:56:50', 'menunggu', 1, '0', 1, '12:00:00', '2021-01-06', 'unpaid', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers_overload`
--

CREATE TABLE `customers_overload` (
  `id` int(11) NOT NULL,
  `jenis_test` int(11) NOT NULL,
  `jenis_pemeriksaan` int(11) NOT NULL,
  `jenis_layanan` int(11) NOT NULL,
  `faskes_asal` int(11) NOT NULL,
  `customer_unique` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `phone` char(13) NOT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `instansi` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `status_pembayaran` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_test` varchar(20) DEFAULT NULL,
  `tahap` int(11) DEFAULT NULL,
  `kehadiran` enum('0','1','2') NOT NULL DEFAULT '0',
  `no_antrian` int(11) DEFAULT NULL,
  `jam_kunjungan` int(11) NOT NULL,
  `tgl_kunjungan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_layanan_test`
--

CREATE TABLE `data_layanan_test` (
  `id` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `id_test` int(11) NOT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
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

INSERT INTO `data_layanan_test` (`id`, `id_layanan`, `id_test`, `id_pemeriksaan`, `biaya`, `time_start`, `time_end`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1100000, '07:00:00', '12:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(2, 2, 1, 1, 875000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(3, 2, 2, 1, 125000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', NULL),
(4, 2, 3, 1, 250000, '07:00:00', '22:00:00', 1, 1, '2021-01-01 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_pembayaran`
--

CREATE TABLE `data_pembayaran` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_test` int(11) NOT NULL,
  `nama_test` varchar(255) NOT NULL,
  `jenis_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pembayaran`
--

INSERT INTO `data_pembayaran` (`id`, `id_customer`, `nama`, `jenis_test`, `nama_test`, `jenis_pembayaran`, `status_pembayaran`, `created_at`, `updated_at`) VALUES
(1, 1, 'Danang Arif Rahmanda', 1, 'SWAB PCR', NULL, 'unpaid', '2021-01-03 21:50:31', '2021-01-03 21:50:31'),
(2, 2, 'Danang Arif Rahmanda', 1, 'SWAB PCR', NULL, 'unpaid', '2021-01-03 21:54:03', '2021-01-03 21:54:03'),
(3, 3, 'Danang Arif Rahmanda', 3, 'SWAB PCR', NULL, 'unpaid', '2021-01-03 21:54:32', '2021-01-03 21:54:32'),
(4, 4, 'Danang Arif Rahmanda', 4, 'SWAB PCR', NULL, 'unpaid', '2021-01-03 21:56:51', '2021-01-03 21:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama` int(11) NOT NULL,
  `alamat` int(11) DEFAULT NULL,
  `img_ttd` int(11) DEFAULT NULL,
  `qrcode_ttd` text DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT 'NULL',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`id`, `nama`, `alamat`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Umum', NULL, '2021-01-03 00:00:00', '2021-01-03 00:00:00', 1, 1);

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
-- Table structure for table `kehadiran`
--

CREATE TABLE `kehadiran` (
  `id` int(11) NOT NULL,
  `jenis_test` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
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
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 1, '01:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(2, 1, '02:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(3, 1, '03:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(4, 1, '04:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(5, 1, '05:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(6, 1, '06:00:00', 0, 0, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(7, 1, '07:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(8, 1, '08:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(9, 1, '09:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(10, 1, '10:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(11, 1, '11:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(12, 1, '12:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(13, 1, '13:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(14, 1, '14:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(15, 1, '15:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(16, 1, '16:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(17, 1, '17:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(18, 1, '18:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(19, 1, '19:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(20, 1, '20:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(21, 1, '21:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(22, 1, '22:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(23, 1, '23:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(24, 1, '24:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(25, 2, '01:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(26, 2, '02:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(27, 2, '03:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(28, 2, '04:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(29, 2, '05:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(30, 2, '06:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(31, 2, '07:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(32, 2, '08:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(33, 2, '09:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(34, 2, '10:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(35, 2, '11:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(36, 2, '12:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(37, 2, '13:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(38, 2, '14:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(39, 2, '15:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(40, 2, '16:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(41, 2, '17:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(42, 2, '18:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(43, 2, '19:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(44, 2, '20:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(45, 2, '21:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(46, 2, '22:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(47, 2, '23:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(48, 2, '24:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(49, 3, '01:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(50, 3, '02:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(51, 3, '03:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(52, 3, '04:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(53, 3, '05:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(54, 3, '06:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(55, 3, '07:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(56, 3, '08:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(57, 3, '09:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(58, 3, '10:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(59, 3, '11:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(60, 3, '12:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(61, 3, '13:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(62, 3, '14:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(63, 3, '15:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(64, 3, '16:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(65, 3, '17:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(66, 3, '18:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(67, 3, '19:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(68, 3, '20:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(69, 3, '21:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(70, 3, '22:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(71, 3, '23:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(72, 3, '24:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(73, 4, '01:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(74, 4, '02:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(75, 4, '03:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(76, 4, '04:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(77, 4, '05:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(78, 4, '06:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(79, 4, '07:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(80, 4, '08:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(81, 4, '09:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(82, 4, '10:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(83, 4, '11:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(84, 4, '12:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(85, 4, '13:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(86, 4, '14:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(87, 4, '15:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(88, 4, '16:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(89, 4, '17:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(90, 4, '18:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(91, 4, '19:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(92, 4, '20:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(93, 4, '21:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(94, 4, '22:00:00', 50, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(95, 4, '23:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10'),
(96, 4, '24:00:00', 0, 1, 1, 1, '2021-01-01 23:04:10', '2021-01-01 23:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `marketing`
--

CREATE TABLE `marketing` (
  `id` int(11) NOT NULL,
  `nama_marketing` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marketing`
--

INSERT INTO `marketing` (`id`, `nama_marketing`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Atas Permintaan Sendiri', 1, 1, '2021-01-01 00:00:00', NULL);

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
(1, 'MIDTRANS_KEY', 'SERVER_KEY', 'TWlkLXNlcnZlci1lZkg4dzh0QndGS2hyVVM3b19LeWxHVGs=', '1', 1, 1, '2021-01-02 00:00:00', NULL),
(2, 'MIDTRANS_KEY', 'CLIENT_KEY', 'TWlkLWNsaWVudC1tLWtaQktLZ1paMmVzQ056', '1', 1, 1, '2021-01-02 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `user_level`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'admin@admiin2.com', '0192023a7bbd73250516f069df18b500', 1, 'admin', '2020-12-31 23:18:05', '2020-12-31 23:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `users_detail`
--

CREATE TABLE `users_detail` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_detail`
--

INSERT INTO `users_detail` (`id`, `id_user`, `nama`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 1, 'Wisnu', NULL, '2020-12-31 23:18:05', NULL);

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
(4, 'front office', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_login`
--

CREATE TABLE `users_login` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `page` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers_overload`
--
ALTER TABLE `customers_overload`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_unique` (`customer_unique`);

--
-- Indexes for table `data_layanan_test`
--
ALTER TABLE `data_layanan_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_layanan_fk` (`id_layanan`),
  ADD KEY `id_test` (`id_test`),
  ADD KEY `id_pemeriksaan_fk` (`id_pemeriksaan`);

--
-- Indexes for table `data_pembayaran`
--
ALTER TABLE `data_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `jenis_test`
--
ALTER TABLE `jenis_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `marketing`
--
ALTER TABLE `marketing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
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
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers_overload`
--
ALTER TABLE `customers_overload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_layanan_test`
--
ALTER TABLE `data_layanan_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_pembayaran`
--
ALTER TABLE `data_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jenis_test`
--
ALTER TABLE `jenis_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kota`
--
ALTER TABLE `kota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kuota_customer`
--
ALTER TABLE `kuota_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `marketing`
--
ALTER TABLE `marketing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_parameter`
--
ALTER TABLE `system_parameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_detail`
--
ALTER TABLE `users_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_level`
--
ALTER TABLE `users_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_login`
--
ALTER TABLE `users_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_layanan_test`
--
ALTER TABLE `data_layanan_test`
  ADD CONSTRAINT `data_layanan_test_ibfk_1` FOREIGN KEY (`id_test`) REFERENCES `jenis_test` (`id`),
  ADD CONSTRAINT `id_layanan_fk` FOREIGN KEY (`id_layanan`) REFERENCES `jenis_layanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_pemeriksaan_fk` FOREIGN KEY (`id_pemeriksaan`) REFERENCES `jenis_pemeriksaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
