-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2024 at 11:57 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cahaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_merk` int(11) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `harga_beli` varchar(150) NOT NULL,
  `harga_jual` varchar(150) NOT NULL,
  `setelah_diskon` varchar(150) NOT NULL,
  `stok` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `id_kategori`, `id_merk`, `id_suplier`, `harga_beli`, `harga_jual`, `setelah_diskon`, `stok`) VALUES
(14, 1, 1, 1, '120000', '180000', '180000', '24'),
(15, 1, 2, 1, '140000', '210000', '210000', '21'),
(16, 2, 3, 2, '90000', '170000', '170000', '24'),
(17, 2, 4, 2, '150000', '320000', '320000', '18'),
(18, 3, 5, 1, '50000', '120000', '120000', '41');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Sprei'),
(2, 'Karpet'),
(3, 'Handuk'),
(4, 'Sarung'),
(5, 'Kasur'),
(6, 'Bantal'),
(7, 'Guling');

-- --------------------------------------------------------

--
-- Table structure for table `merk`
--

CREATE TABLE `merk` (
  `id_merk` int(11) NOT NULL,
  `merk` varchar(150) NOT NULL,
  `bahan` varchar(150) NOT NULL,
  `ukuran` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `merk`
--

INSERT INTO `merk` (`id_merk`, `merk`, `bahan`, `ukuran`) VALUES
(1, 'Bonita', 'katun', '200x180'),
(2, 'jovanka', 'katun', '200x200'),
(3, 'Duta Mada', 'Sisal', '95x120'),
(4, 'Duta Mada', 'Sisal', '150x190'),
(5, 'Mikrofiber', 'katun', '140x70');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(150) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `telepon` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `telepon`, `email`) VALUES
(1, 'pelanggan', '-', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `id_barang` varchar(100) NOT NULL,
  `jumlah` varchar(150) NOT NULL,
  `harga_beli` varchar(150) NOT NULL,
  `total` varchar(150) NOT NULL,
  `tanggal_input` datetime NOT NULL,
  `penambah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_suplier`, `id_barang`, `jumlah`, `harga_beli`, `total`, `tanggal_input`, `penambah`) VALUES
(1, 1, '4\"4\"5', '4\"2\"5', '', '820000', '2024-07-24 16:06:55', 1),
(2, 1, '4', '10', '', '1550000', '2024-07-24 17:40:47', 1),
(3, 1, '4', '2', '', '310000', '2024-07-24 17:41:27', 1),
(4, 1, '9\"10', '20\"10', '', '4900000', '2024-07-31 07:16:00', 1),
(5, 2, '11\"12', '30\"20', '', '5500000', '2024-07-31 07:16:45', 1),
(6, 2, '13', '15', '', '750000', '2024-07-31 07:17:02', 1),
(7, 1, '14', '50', '', '6000000', '2024-08-05 20:46:55', 1),
(8, 1, '15', '30', '', '4200000', '2024-08-05 20:47:09', 1),
(9, 2, '18', '50', '', '2500000', '2024-08-05 20:47:28', 1),
(10, 2, '16', '30', '', '2700000', '2024-08-05 20:47:46', 1),
(11, 2, '17', '20', '', '3000000', '2024-08-05 20:47:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `keterangan` varchar(150) NOT NULL,
  `harga` varchar(150) NOT NULL,
  `tgl_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id_pengeluaran`, `keterangan`, `harga`, `tgl_input`) VALUES
(1, 'Biaya Listrik', '500000', '2024-07-17 20:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `jumlah` varchar(150) NOT NULL,
  `harga_jual` varchar(150) NOT NULL,
  `diskon` varchar(150) NOT NULL,
  `total` varchar(150) NOT NULL,
  `status` varchar(150) NOT NULL,
  `tanggal_input` datetime NOT NULL,
  `penambah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_pelanggan`, `id_barang`, `jumlah`, `harga_jual`, `diskon`, `total`, `status`, `tanggal_input`, `penambah`) VALUES
(59, 1, '9', '1', '170000', 'Tidak ada diskon', '170000', 'Selesai', '2024-08-03 14:57:33', 1),
(62, 1, '9\"10\"11', '3\"1\"1', '161500\"350000\"165000', '49975.00', '949525.00', 'Selesai', '2024-08-03 20:57:18', 1),
(69, 1, '9\"10\"13', '3\"1\"1', '161500\"350000\"80000', '45725.00', '868775.00', 'Selesai', '2024-08-03 20:57:18', 1),
(72, 1, '11\"13', '1\"1', '165000\"80000', 'Tidak ada diskon', '245000.00', 'Selesai', '2024-08-03 22:04:34', 1),
(73, 1, '10\"11', '1\"1', '350000\"165000', '25750.00', '489250.00', 'Selesai', '2024-08-03 22:07:49', 1),
(74, 1, '13\"13', '1\"1', '80000\"80000', 'Tidak ada diskon', '160000.00', 'Selesai', '2024-08-03 22:09:44', 1),
(75, 1, '13\"12', '1\"2', '80000\"145000', 'Tidak ada diskon', '370000.00', 'Selesai', '2024-08-03 22:12:48', 1),
(76, 1, '10\"13', '1\"5', '350000\"80000', '37500.00', '712500.00', 'Selesai', '2024-08-03 22:16:24', 1),
(77, 1, '12\"13', '1\"3', '145000\"80000', 'Tidak ada diskon', '385000.00', 'Selesai', '2024-08-03 22:16:35', 1),
(78, 1, '14\"18', '2\"3', '180000\"120000', 'Diskon 5% = 36000', '684000', 'Selesai', '2024-08-05 21:42:11', 1),
(79, 1, '14', '20', '180000', 'Diskon 5% = 180000', '3420000', 'Selesai', '2024-08-05 21:43:08', 1),
(80, 1, '18\"15', '2\"1', '120000\"210000', 'Tidak ada diskon', '450000', 'Selesai', '2024-08-05 22:21:56', 1),
(81, 1, '18\"15', '2\"1', '120000\"210000', 'Tidak ada diskon', '450000', 'Selesai', '2024-08-05 22:21:56', 1),
(82, 1, '17', '1', '320000', 'Tidak ada diskon', '320000', 'Selesai', '2024-08-05 22:52:25', 1),
(83, 1, '17', '1', '320000', 'Tidak ada diskon', '320000', 'Selesai', '2024-08-05 22:58:04', 1),
(84, 1, '16', '1', '170000', 'Tidak ada diskon', '170000', 'Selesai', '2024-08-05 22:59:49', 1),
(85, 1, '16', '1', '170000', 'Tidak ada diskon', '170000', 'Selesai', '2024-08-05 22:59:49', 1),
(86, 1, '18', '1', '120000', 'Tidak ada diskon', '120000', 'Selesai', '2024-08-05 23:06:45', 1),
(87, 1, '18', '1', '120000', 'Tidak ada diskon', '120000', 'Selesai', '2024-08-05 23:06:45', 1),
(88, 1, '15', '1', '210000', 'Tidak ada diskon', '210000', 'Selesai', '2024-08-05 23:07:41', 1),
(89, 1, '15', '1', '210000', 'Tidak ada diskon', '210000', 'Selesai', '2024-08-05 23:07:41', 1),
(90, 1, '16', '2', '170000', 'Tidak ada diskon', '340000', 'Selesai', '2024-08-05 23:08:43', 1),
(91, 1, '16', '2', '170000', 'Tidak ada diskon', '340000', 'Selesai', '2024-08-05 23:08:43', 1),
(92, 1, '15', '1', '210000', 'Tidak ada diskon', '210000', 'Selesai', '2024-08-05 23:18:00', 1),
(93, 1, '15', '1', '210000', 'Tidak ada diskon', '210000', 'Selesai', '2024-08-05 23:18:52', 1),
(94, 1, '15', '1', '210000', 'Tidak ada diskon', '210000', 'Selesai', '2024-08-05 23:19:05', 1),
(95, 1, '14', '1', '180000', 'Tidak ada diskon', '180000', 'Selesai', '2024-08-05 23:19:16', 1),
(96, 1, '14', '1', '180000', 'Tidak ada diskon', '180000', 'Selesai', '2024-08-05 23:19:16', 1),
(97, 1, '15', '1', '210000', 'Tidak ada diskon', '210000', 'Selesai', '2024-08-05 23:19:59', 1),
(98, 1, '15', '1', '210000', 'Tidak ada diskon', '210000', 'Selesai', '2024-08-05 23:19:59', 1),
(99, 1, '14', '1', '180000', 'Tidak ada diskon', '180000', 'Selesai', '2024-08-05 23:20:52', 1),
(100, 1, '14', '1', '180000', 'Tidak ada diskon', '180000', 'Selesai', '2024-08-05 23:20:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `suplier`
--

CREATE TABLE `suplier` (
  `id_suplier` int(11) NOT NULL,
  `nama_suplier` varchar(150) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `telepon` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suplier`
--

INSERT INTO `suplier` (`id_suplier`, `nama_suplier`, `alamat`, `telepon`, `email`) VALUES
(1, 'PT. Solaris Jaya', 'Jl. Sasaran', '053589098', 'solarisjaya@gmail.com'),
(2, 'CV. Makmur Abadi', 'Jl. A Yani', '089685258866', 'makmurabadi@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` int(11) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `telepon` varchar(150) NOT NULL,
  `login_terakhir` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`, `nama_lengkap`, `alamat`, `telepon`, `login_terakhir`) VALUES
(1, 'admin', '1', 1, 'rosada', 'rosada', '08952584', '2024-08-06 09:24:11'),
(3, 'pegawai', '1', 2, 'Tegar Seicar L', 'Banjarbaru', '083150186922', '2024-08-06 09:20:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `merk`
--
ALTER TABLE `merk`
  ADD PRIMARY KEY (`id_merk`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`id_suplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `merk`
--
ALTER TABLE `merk`
  MODIFY `id_merk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `suplier`
--
ALTER TABLE `suplier`
  MODIFY `id_suplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
