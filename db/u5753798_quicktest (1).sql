-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2021 at 04:55 AM
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
-- Database: `u5753798_quicktest`
--

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
  `pemeriksa` int(11) DEFAULT NULL,
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
  `kehadiran` enum('0','1') NOT NULL DEFAULT '0',
  `no_antrian` int(11) DEFAULT NULL,
  `jam_kunjungan` time NOT NULL,
  `tgl_kunjungan` date NOT NULL,
  `status_pembayaran` varchar(30) DEFAULT 'pending',
  `token` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `jenis_test`, `jenis_pemeriksaan`, `jenis_layanan`, `faskes_asal`, `customer_unique`, `invoice_number`, `pemeriksa`, `email`, `nama`, `nik`, `phone`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_marketing`, `instansi`, `created_at`, `updated_at`, `status_test`, `tahap`, `kehadiran`, `no_antrian`, `jam_kunjungan`, `tgl_kunjungan`, `status_pembayaran`, `token`, `catatan`) VALUES
(1, 1, 1, 1, 1, 'SPS2101031', 'INV-210103001', NULL, 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan Jakarta', 1, 1, '2021-01-03 21:50:30', '2021-01-03 21:50:31', 'menunggu', 1, '1', 1, '12:00:00', '2021-01-04', 'settlement', NULL, NULL),
(2, 1, 1, 1, 1, 'SPS2101031', 'INV-210103002', NULL, 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan Jakarta', 1, 1, '2021-01-03 21:54:03', '2021-01-03 21:54:03', 'menunggu', 1, '0', 2, '12:00:00', '2021-01-04', 'pending', NULL, NULL),
(3, 3, 1, 1, 1, 'RTB2101031', 'INV-210103001', NULL, 'danang.a.rahmanda@danangoffic.xyz', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan rawa bahagia', 1, 1, '2021-01-03 21:54:32', '2021-01-03 21:54:32', 'menunggu', 1, '0', 1, '11:00:00', '2021-01-07', 'pending', NULL, NULL),
(4, 4, 1, 1, 1, 'SAB21010312001', 'INV-210103001', NULL, 'haibisnisdotcom@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan apa aja', 1, 1, '2021-01-03 21:56:50', '2021-01-03 21:56:50', 'menunggu', 1, '0', 1, '12:00:00', '2021-01-06', 'pending', NULL, NULL),
(5, 1, 1, 1, 2, 'SPS21010913001', 'INV-210109001', NULL, 'risleda.lalusu@mail.com', 'Riselda Lalusu', '3232618321321232', '085261641500', 'pria', 'Sleman', '2021-01-01', 'Jl Jogja', 1, 1, '2021-01-09 12:23:50', '2021-01-09 12:23:50', 'menunggu', 1, '', 1, '13:00:00', '2021-01-11', '', NULL, NULL),
(6, 1, 1, 1, 2, 'SPS21010913001', 'INV-210109001', NULL, 'risleda.lalusu@mail.com', 'Riselda Lalusu', '3232618321321232', '085261641500', 'wanita', 'Sleman', '2021-01-01', 'Jl Jogja', 1, 1, '2021-01-09 12:25:18', '2021-01-09 12:25:18', 'menunggu', 1, '', 1, '13:00:00', '2021-01-11', '', NULL, NULL),
(7, 1, 1, 1, 2, 'SPS21010913001', 'INV-210109001', NULL, 'risleda.lalusu@mail.com', 'Riselda Lalusu', '3232618321321232', '085261641500', 'pria', 'Sleman', '2021-01-01', 'Jl Jogja', 1, 1, '2021-01-09 12:26:11', '2021-01-09 12:26:11', 'menunggu', 1, '', 1, '13:00:00', '2021-01-11', '', NULL, NULL),
(8, 1, 1, 1, 2, 'SPS21010913001', 'INV-210109001', NULL, 'risleda.lalusu@mail.com', 'Riselda Lalusu', '3232618321321232', '085261641500', 'pria', 'Sleman', '2021-01-01', 'Jl Jogja', 1, 1, '2021-01-09 12:29:07', '2021-01-09 12:29:07', 'menunggu', 1, '', 1, '13:00:00', '2021-01-11', '', NULL, NULL),
(9, 1, 1, 1, 2, 'SPS21010913001', 'INV-210109001', 1, 'risleda.lalusu@mail.com', 'Riselda Rahma', '3232618321321232', '085261641500', 'wanita', 'Sleman', '2021-01-01', 'Jl Jogja', 1, 1, '2021-01-09 12:29:26', '2021-01-09 16:12:36', 'menunggu', 1, '1', 1, '13:00:00', '2021-01-11', 'settlement', NULL, NULL),
(10, 1, 1, 1, 1, 'SPS21011012001', 'INV-210110001', NULL, 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '2021-01-01', 'jalan', 1, 1, '2021-01-10 16:28:12', '2021-01-10 16:28:12', 'menunggu', 1, '0', 1, '12:00:00', '2021-01-11', 'pending', NULL, NULL),
(11, 3, 1, 1, 1, 'RTB21011015001', 'INV-210110001', NULL, 'isel.lalusu@gmail.com', 'Riselda Lalusu', '7201044707960005', '085261641500', 'pria', 'Cilacap', '2021-01-01', 'jln sagan', 1, 1, '2021-01-10 17:01:51', '2021-01-10 17:01:51', 'menunggu', 1, '0', 1, '15:00:00', '2021-01-11', 'pending', NULL, NULL);

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
  `customer_unique` varchar(255) NOT NULL,
  `invoice_number` varchar(30) DEFAULT NULL,
  `pemeriksa` int(11) DEFAULT NULL,
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
-- Dumping data for table `customers_overload`
--

INSERT INTO `customers_overload` (`id`, `jenis_test`, `jenis_pemeriksaan`, `jenis_layanan`, `faskes_asal`, `customer_unique`, `invoice_number`, `pemeriksa`, `email`, `nama`, `nik`, `phone`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_marketing`, `instansi`, `created_at`, `updated_at`, `status_test`, `tahap`, `kehadiran`, `no_antrian`, `jam_kunjungan`, `tgl_kunjungan`, `status_pembayaran`, `token`, `catatan`) VALUES
(1, 1, 1, 1, 1, 'SPS2101031', 'INV-210103001', NULL, 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan Jakarta', 1, 1, '2021-01-03 21:50:30', '2021-01-03 21:50:31', 'menunggu', 1, '1', 1, '12:00:00', '2021-01-04', 'paid', NULL, NULL),
(2, 1, 1, 1, 1, 'SPS2101031', 'INV-210103002', NULL, 'darifrahmanda@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan Jakarta', 1, 1, '2021-01-03 21:54:03', '2021-01-03 21:54:03', 'menunggu', 1, '0', 2, '12:00:00', '2021-01-04', 'unpaid', NULL, NULL),
(3, 3, 1, 1, 1, 'RTB2101031', 'INV-210103001', NULL, 'danang.a.rahmanda@danangoffic.xyz', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan rawa bahagia', 1, 1, '2021-01-03 21:54:32', '2021-01-03 21:54:32', 'menunggu', 1, '0', 1, '11:00:00', '2021-01-07', 'unpaid', NULL, NULL),
(4, 4, 1, 1, 1, 'SAB21010312001', 'INV-210103001', NULL, 'haibisnisdotcom@gmail.com', 'Danang Arif Rahmanda', '3232132132132132', '081230759128', 'pria', 'Sleman', '0000-00-00', 'Jalan apa aja', 1, 1, '2021-01-03 21:56:50', '2021-01-03 21:56:50', 'menunggu', 1, '0', 1, '12:00:00', '2021-01-06', 'unpaid', NULL, NULL);

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
  `status_pembayaran` varchar(30) DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pembayaran`
--

INSERT INTO `data_pembayaran` (`id`, `id_customer`, `nama`, `jenis_test`, `nama_test`, `jenis_pembayaran`, `status_pembayaran`, `created_at`, `updated_at`) VALUES
(1, 1, 'Danang Arif Rahmanda', 1, 'SWAB PCR', NULL, 'pending', '2021-01-03 21:50:31', '2021-01-03 21:50:31'),
(2, 2, 'Danang Arif Rahmanda', 1, 'SWAB PCR', NULL, 'pending', '2021-01-03 21:54:03', '2021-01-03 21:54:03'),
(3, 3, 'Danang Arif Rahmanda', 3, 'SWAB PCR', NULL, 'pending', '2021-01-03 21:54:32', '2021-01-03 21:54:32'),
(4, 4, 'Danang Arif Rahmanda', 4, 'SWAB PCR', NULL, 'pending', '2021-01-03 21:56:51', '2021-01-03 21:56:51'),
(5, 8, 'Riselda Lalusu', 1, 'SWAB PCR', NULL, 'pending', '2021-01-09 12:29:07', '2021-01-09 12:29:07'),
(6, 0, 'Riselda Rahma', 1, 'SWAB PCR', NULL, '', '2021-01-09 12:29:26', '2021-01-09 12:29:26'),
(7, 10, 'Danang Arif Rahmanda', 1, 'SWAB PCR', NULL, 'pending', '2021-01-10 16:28:13', '2021-01-10 16:28:13'),
(8, 11, 'Riselda Lalusu', 3, 'SWAB PCR', NULL, 'pending', '2021-01-10 17:01:51', '2021-01-10 17:01:51');

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
(2, 11, 'Riselda', '085261641500', '', 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http://localhost:8080/assets/dokter&choe=UTF-8', 0, 0, '2021-01-09 02:36:23', '2021-01-11 01:05:54');

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
(2, 'ABC', 'DEF', '081230759128', 'abcdef@mail.com', 'Jl Cendrawasih 15B', 1, 1, 1, '2021-01-09 02:35:37', '2021-01-09 02:35:37');

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
  `pic_marketing` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`id`, `kota`, `nama`, `alamat`, `nama_user`, `tempat_lahir`, `tgl_lahir`, `phone`, `email`, `pic_marketing`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 0, 'Umum', NULL, NULL, NULL, '0000-00-00', '', '', NULL, '2021-01-03 00:00:00', '2021-01-03 00:00:00', 1, 1),
(2, 0, 'Rujukan', NULL, NULL, NULL, '0000-00-00', '', '', NULL, '2021-01-03 00:00:00', '2021-01-03 00:00:00', 1, 1);

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
(2, 'HOME SERVICE', 1, 1, '2021-01-01 00:00:00', NULL),
(3, 'CORPORATE', 1, 1, '2021-01-06 00:00:00', NULL),
(4, 'RUJUKAN', 1, 1, '2021-01-06 00:00:00', NULL),
(5, 'OVERLOAD', 1, 1, '2021-01-07 00:00:00', NULL);

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
(1, 'Jakarta Utara', 'North Jakarta', 'DKI Jakarta', 1, 1, '2021-01-08 23:59:16', '2021-01-09 00:07:04');

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
(5, 1, 'http://speedlab.galeritekno.com/asset/kop.png', 1, 1, '2021-01-09 01:21:20', '2021-01-09 01:24:28');

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
(1, 'Dananggg', '081230759128', 'danangrahmanda@mail.com', 1, 1, '2021-01-09 01:47:37', '2021-01-09 02:19:01');

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
(10, 'status_kirim', 'Sudah Dikirim', 1, 1, '2021-01-11 00:00:00', NULL);

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
(2, 'darifrahmanda@gmail.com', '4a695374e3296f670f3789ebbb050ba1', 0, 1, 0, '2021-01-08 22:00:37', '2021-01-08 22:00:37'),
(3, 'darifrahmanda@gmail.com', '4a695374e3296f670f3789ebbb050ba1', 0, 1, 0, '2021-01-08 22:00:51', '2021-01-08 22:00:51'),
(4, 'danangrahmanda@gmail.com', '4a695374e3296f670f3789ebbb050ba1', 0, 1, 0, '2021-01-08 22:05:06', '2021-01-08 22:05:06'),
(5, 'darifrahmanda@gmail.com', '4a695374e3296f670f3789ebbb050ba1', 0, 1, 0, '2021-01-08 22:06:02', '2021-01-08 22:06:02'),
(6, 'isel@mail.com', '9c0e98885486450aeece88107a8f2e67', 0, 1, 0, '2021-01-08 22:07:23', '2021-01-08 22:07:23'),
(7, 'isel@mail.com', '9c0e98885486450aeece88107a8f2e67', 0, 1, 0, '2021-01-08 22:07:32', '2021-01-08 22:07:32'),
(8, 'ddaassww@mail.com', '0c3c41103f0f42a196fdc5a1c2b6e8f9', 0, 1, 0, '2021-01-08 22:10:37', '2021-01-08 22:10:37'),
(9, 'danangrahmanda@gmail.com', '4a695374e3296f670f3789ebbb050ba1', 0, 1, 0, '2021-01-08 22:12:33', '2021-01-08 22:12:33'),
(10, 'danangrahmanda@gmail.com', '4a695374e3296f670f3789ebbb050ba1', 0, 0, 0, '2021-01-08 22:14:27', '2021-01-08 23:35:25'),
(11, 'riselda@mail.com', 'f4f1e057ec2914c10b9f900ea89c350e', 0, 0, 0, '2021-01-09 02:36:23', '2021-01-11 01:05:54');

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
(4, 'front office', NULL, NULL),
(5, 'instansi', NULL, NULL),
(6, 'petugas', NULL, NULL),
(7, 'dokter', NULL, NULL);

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
-- Indexes for table `alat_pemeriksaan`
--
ALTER TABLE `alat_pemeriksaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers_overload`
--
ALTER TABLE `customers_overload`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `faskes`
--
ALTER TABLE `faskes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hasil_laboratorium`
--
ALTER TABLE `hasil_laboratorium`
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
-- AUTO_INCREMENT for table `alat_pemeriksaan`
--
ALTER TABLE `alat_pemeriksaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers_overload`
--
ALTER TABLE `customers_overload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_layanan_test`
--
ALTER TABLE `data_layanan_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_pembayaran`
--
ALTER TABLE `data_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faskes`
--
ALTER TABLE `faskes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hasil_laboratorium`
--
ALTER TABLE `hasil_laboratorium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kota`
--
ALTER TABLE `kota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kuota_customer`
--
ALTER TABLE `kuota_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `lokasi_input`
--
ALTER TABLE `lokasi_input`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT for table `nav`
--
ALTER TABLE `nav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_hasil`
--
ALTER TABLE `status_hasil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `system_parameter`
--
ALTER TABLE `system_parameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users_detail`
--
ALTER TABLE `users_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_level`
--
ALTER TABLE `users_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
