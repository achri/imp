-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 01, 2011 at 06:08 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_imp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` text,
  `ip_address` varchar(100) DEFAULT NULL,
  `user_agent` varchar(100) DEFAULT NULL,
  `last_activity` time DEFAULT NULL,
  `user_data` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `inventory_stok`
--

CREATE TABLE IF NOT EXISTS `inventory_stok` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `produk_id` int(11) NOT NULL,
  `pemasok_id` int(11) NOT NULL DEFAULT '0',
  `inv_tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inv_mulai` decimal(6,2) NOT NULL DEFAULT '0.00',
  `inv_masuk` decimal(6,2) NOT NULL DEFAULT '0.00',
  `inv_keluar` decimal(6,2) NOT NULL DEFAULT '0.00',
  `inv_akhir` decimal(6,2) NOT NULL DEFAULT '0.00',
  `inv_hrg_beli` decimal(20,2) NOT NULL DEFAULT '0.00',
  `inv_hrg_jual` decimal(20,2) NOT NULL DEFAULT '0.00',
  `inv_hrg_rbeli` decimal(20,2) NOT NULL DEFAULT '0.00',
  `inv_hrg_rjual` decimal(20,2) NOT NULL DEFAULT '0.00',
  `inv_dokumen` varchar(50) NOT NULL DEFAULT 'SETUP',
  `inv_usr` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `inventory_stok`
--


-- --------------------------------------------------------

--
-- Table structure for table `inventory_stok_history`
--

CREATE TABLE IF NOT EXISTS `inventory_stok_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `pemasok_id` int(11) NOT NULL DEFAULT '0',
  `inv_tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inv_mulai` decimal(6,2) NOT NULL DEFAULT '0.00',
  `inv_masuk` decimal(6,2) NOT NULL DEFAULT '0.00',
  `inv_keluar` decimal(6,2) NOT NULL DEFAULT '0.00',
  `inv_akhir` decimal(6,2) NOT NULL DEFAULT '0.00',
  `inv_hrg_beli` decimal(20,2) NOT NULL DEFAULT '0.00',
  `inv_hrg_jual` decimal(20,2) NOT NULL DEFAULT '0.00',
  `inv_hrg_rbeli` decimal(20,2) NOT NULL DEFAULT '0.00',
  `inv_hrg_rjual` decimal(20,2) NOT NULL DEFAULT '0.00',
  `inv_dokumen` varchar(50) NOT NULL DEFAULT 'SETUP',
  `inv_usr` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `inventory_stok_history`
--


-- --------------------------------------------------------

--
-- Table structure for table `master_akses`
--

CREATE TABLE IF NOT EXISTS `master_akses` (
  `ucat_id` int(11) NOT NULL AUTO_INCREMENT,
  `ucat_nama` varchar(50) NOT NULL,
  `ucat_alias` varchar(50) NOT NULL,
  PRIMARY KEY (`ucat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `master_akses`
--

INSERT INTO `master_akses` (`ucat_id`, `ucat_nama`, `ucat_alias`) VALUES
(1, 'Administrator', 'Adm'),
(2, 'Operator', 'OP'),
(99, 'Super Administrator', 'SA'),
(98, 'Admin', 'SADM');

-- --------------------------------------------------------

--
-- Table structure for table `master_jenis_trans`
--

CREATE TABLE IF NOT EXISTS `master_jenis_trans` (
  `trans_jenis_id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_transaksi` varchar(50) NOT NULL,
  PRIMARY KEY (`trans_jenis_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `master_jenis_trans`
--

INSERT INTO `master_jenis_trans` (`trans_jenis_id`, `jenis_transaksi`) VALUES
(1, 'CASH'),
(2, 'CREDIT');

-- --------------------------------------------------------

--
-- Table structure for table `master_kategori`
--

CREATE TABLE IF NOT EXISTS `master_kategori` (
  `kat_id` int(11) NOT NULL AUTO_INCREMENT,
  `kat_kode` varchar(100) NOT NULL,
  `kat_master` int(11) NOT NULL DEFAULT '0',
  `kat_level` int(11) NOT NULL DEFAULT '1',
  `kat_nama` varchar(255) NOT NULL,
  PRIMARY KEY (`kat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `master_kategori`
--


-- --------------------------------------------------------

--
-- Table structure for table `master_legality`
--

CREATE TABLE IF NOT EXISTS `master_legality` (
  `legal_id` int(11) NOT NULL AUTO_INCREMENT,
  `legal_nama` varchar(50) NOT NULL,
  PRIMARY KEY (`legal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `master_legality`
--

INSERT INTO `master_legality` (`legal_id`, `legal_nama`) VALUES
(1, 'etc'),
(2, 'PT'),
(3, 'CV');

-- --------------------------------------------------------

--
-- Table structure for table `master_pemasok`
--

CREATE TABLE IF NOT EXISTS `master_pemasok` (
  `pemasok_id` int(11) NOT NULL AUTO_INCREMENT,
  `legal_id` int(11) NOT NULL,
  `pemasok_nama` varchar(50) NOT NULL,
  `pemasok_alamat` text NOT NULL,
  `pemasok_telp` varchar(50) NOT NULL,
  `pemasok_email` varchar(50) NOT NULL,
  `pemasok_npwp` varchar(50) NOT NULL,
  `kat_id` int(11) NOT NULL,
  PRIMARY KEY (`pemasok_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `master_pemasok`
--


-- --------------------------------------------------------

--
-- Table structure for table `master_produk`
--

CREATE TABLE IF NOT EXISTS `master_produk` (
  `produk_id` int(11) NOT NULL AUTO_INCREMENT,
  `produk_tgl` datetime NOT NULL,
  `produk_kode` varchar(50) NOT NULL,
  `produk_nama` varchar(50) NOT NULL,
  `kat_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `produk_min_stok` decimal(6,2) NOT NULL DEFAULT '0.00',
  `harga_beli` decimal(20,2) NOT NULL DEFAULT '0.00',
  `harga_jual` decimal(20,2) NOT NULL DEFAULT '0.00',
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `tgl_akses` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_akses` int(11) NOT NULL,
  PRIMARY KEY (`produk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `master_produk`
--


-- --------------------------------------------------------

--
-- Table structure for table `master_produk_pemasok`
--

CREATE TABLE IF NOT EXISTS `master_produk_pemasok` (
  `produk_id` int(11) NOT NULL,
  `pemasok_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_produk_pemasok`
--


-- --------------------------------------------------------

--
-- Table structure for table `master_produk_satuan`
--

CREATE TABLE IF NOT EXISTS `master_produk_satuan` (
  `produk_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `satuan_unit_id` int(11) NOT NULL,
  `volume` decimal(6,2) NOT NULL DEFAULT '1.00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_produk_satuan`
--


-- --------------------------------------------------------

--
-- Table structure for table `master_satuan`
--

CREATE TABLE IF NOT EXISTS `master_satuan` (
  `satuan_id` int(11) NOT NULL AUTO_INCREMENT,
  `satuan_nama` varchar(255) NOT NULL,
  `satuan_format` int(11) NOT NULL DEFAULT '2',
  `satuan_default` set('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`satuan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `master_satuan`
--


-- --------------------------------------------------------

--
-- Table structure for table `sys_client`
--

CREATE TABLE IF NOT EXISTS `sys_client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(50) NOT NULL,
  `client_legal` varchar(10) NOT NULL,
  `module_program` varchar(50) NOT NULL,
  `module_type` varchar(50) NOT NULL,
  `module_version` varchar(6) NOT NULL,
  `module_revision` int(11) NOT NULL,
  `module_package` varchar(50) NOT NULL DEFAULT 'Development',
  `image` varchar(50) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sys_client`
--

INSERT INTO `sys_client` (`client_id`, `client_name`, `client_legal`, `module_program`, `module_type`, `module_version`, `module_revision`, `module_package`, `image`) VALUES
(1, '', '', 'INVENTORY MANAGEMENT PRODUCT', 'NON PPN', '1.2.0', 343, 'Release', '');

-- --------------------------------------------------------

--
-- Table structure for table `sys_counter`
--

CREATE TABLE IF NOT EXISTS `sys_counter` (
  `thn` year(4) NOT NULL,
  `bln` int(2) NOT NULL,
  `beli_no` int(2) NOT NULL DEFAULT '1',
  `jual_no` int(11) NOT NULL DEFAULT '1',
  `last_backup` year(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_counter`
--

INSERT INTO `sys_counter` (`thn`, `bln`, `beli_no`, `jual_no`, `last_backup`) VALUES
(2011, 5, 1, 2, 0000);

-- --------------------------------------------------------

--
-- Table structure for table `sys_menu`
--

CREATE TABLE IF NOT EXISTS `sys_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_parent` int(11) NOT NULL DEFAULT '0',
  `menu_level` int(11) NOT NULL DEFAULT '1',
  `menu_nama` varchar(150) NOT NULL,
  `menu_icon` varchar(100) NOT NULL,
  `menu_module` varchar(150) NOT NULL,
  `menu_sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `sys_menu`
--

INSERT INTO `sys_menu` (`menu_id`, `menu_parent`, `menu_level`, `menu_nama`, `menu_icon`, `menu_module`, `menu_sort`) VALUES
(1, 0, 1, 'Master Data', '', '', 0),
(2, 1, 2, 'User', '', 'master_user', 0),
(3, 1, 2, 'Unit', '', 'master_satuan', 1),
(4, 1, 2, 'Category', '', 'master_kategori', 2),
(5, 1, 2, 'Supplier', '', 'master_pemasok', 3),
(6, 1, 2, 'Product', '', 'master_produk', 4),
(7, 11, 1, 'Inventory', '', 'laporan_stok', 0),
(8, 0, 1, 'Transaction', '', '', 2),
(9, 8, 2, 'Buying', '', 'transaksi_beli', 0),
(10, 8, 2, 'Selling', '', 'transaksi_jual', 1),
(11, 0, 1, 'Report', '', '', 3),
(12, 11, 2, 'Transaction', '', '', 0),
(13, 12, 3, 'Buying', '', 'laporan_beli', 0),
(14, 12, 3, 'Selling', '', 'laporan_jual', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_user`
--

CREATE TABLE IF NOT EXISTS `sys_user` (
  `usr_id` int(4) NOT NULL AUTO_INCREMENT,
  `usr_login` varchar(20) NOT NULL DEFAULT '',
  `usr_pwd1` varchar(50) DEFAULT NULL,
  `usr_pwd2` varchar(50) NOT NULL DEFAULT '',
  `usr_nama` varchar(100) DEFAULT NULL,
  `usr_image` varchar(100) DEFAULT NULL,
  `ucat_id` int(11) NOT NULL DEFAULT '2',
  `lastTime_log` datetime DEFAULT NULL,
  `lastIP_log` varchar(50) DEFAULT NULL,
  `newTime_log` datetime DEFAULT NULL,
  `newIP_log` varchar(50) DEFAULT NULL,
  `offTime_log` datetime DEFAULT NULL,
  `offIP_log` varchar(50) DEFAULT NULL,
  `login_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_login` (`usr_login`),
  KEY `usr_name` (`usr_nama`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sys_user`
--

INSERT INTO `sys_user` (`usr_id`, `usr_login`, `usr_pwd1`, `usr_pwd2`, `usr_nama`, `usr_image`, `ucat_id`, `lastTime_log`, `lastIP_log`, `newTime_log`, `newIP_log`, `offTime_log`, `offIP_log`, `login_status`) VALUES
(1, 'su', 'cb3bae31bb1c443fbf3db8889055f2fe', 'cb3bae31bb1c443fbf3db8889055f2fe', 'Super Admin', NULL, 99, '2011-04-23 09:31:43', '::1', '2011-05-01 12:21:48', '::1', '2011-05-01 12:24:08', '::1', 1),
(3, 'admin', '202cb962ac59075b964b07152d234b70', 'caf1a3dfb505ffed0d024130f58c5cfa', 'Administrator', NULL, 98, '2011-05-01 12:24:12', '::1', '2011-05-01 17:08:02', '::1', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_user_menu`
--

CREATE TABLE IF NOT EXISTS `sys_user_menu` (
  `usr_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_user_menu`
--


-- --------------------------------------------------------

--
-- Table structure for table `trans_beli`
--

CREATE TABLE IF NOT EXISTS `trans_beli` (
  `beli_id` int(11) NOT NULL AUTO_INCREMENT,
  `beli_no` varchar(20) NOT NULL,
  `beli_tgl` datetime NOT NULL,
  `beli_tot_jml` decimal(6,2) NOT NULL DEFAULT '0.00',
  `beli_tot_hrg` decimal(20,2) NOT NULL DEFAULT '0.00',
  `beli_tot_bayar` decimal(20,2) NOT NULL DEFAULT '0.00',
  `beli_session` text NOT NULL,
  `beli_status` int(11) NOT NULL DEFAULT '0',
  `beli_user` int(11) NOT NULL DEFAULT '0',
  `cetak_rekap` int(11) NOT NULL DEFAULT '0',
  `cetak_user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`beli_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `trans_beli`
--


-- --------------------------------------------------------

--
-- Table structure for table `trans_beli_detail`
--

CREATE TABLE IF NOT EXISTS `trans_beli_detail` (
  `produk_id` int(11) NOT NULL DEFAULT '0',
  `beli_id` int(11) NOT NULL DEFAULT '0',
  `pemasok_id` int(11) NOT NULL DEFAULT '1',
  `satuan_id` int(11) NOT NULL DEFAULT '0',
  `jumlah` decimal(5,2) NOT NULL DEFAULT '0.00',
  `jumlah_multi` decimal(6,2) NOT NULL DEFAULT '1.00',
  `diskon` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tot_diskon` decimal(20,2) NOT NULL DEFAULT '0.00',
  `harga` decimal(20,2) NOT NULL DEFAULT '0.00',
  `tot_harga` decimal(20,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trans_beli_detail`
--


-- --------------------------------------------------------

--
-- Table structure for table `trans_jual`
--

CREATE TABLE IF NOT EXISTS `trans_jual` (
  `jual_id` int(11) NOT NULL AUTO_INCREMENT,
  `jual_no` varchar(20) NOT NULL,
  `jual_tgl` datetime NOT NULL,
  `jual_tot_jml` decimal(6,2) NOT NULL DEFAULT '0.00',
  `jual_tot_hrg` decimal(20,2) NOT NULL DEFAULT '0.00',
  `jual_tot_bayar` decimal(20,2) NOT NULL DEFAULT '0.00',
  `jual_session` text NOT NULL,
  `jual_status` int(11) NOT NULL DEFAULT '0',
  `jual_user` int(11) NOT NULL DEFAULT '0',
  `trans_jenis_id` int(11) NOT NULL DEFAULT '1',
  `cetak_rekap` int(11) NOT NULL DEFAULT '0',
  `cetak_user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`jual_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `trans_jual`
--


-- --------------------------------------------------------

--
-- Table structure for table `trans_jual_detail`
--

CREATE TABLE IF NOT EXISTS `trans_jual_detail` (
  `produk_id` int(11) NOT NULL DEFAULT '0',
  `jual_id` int(11) NOT NULL DEFAULT '0',
  `satuan_id` int(11) NOT NULL DEFAULT '0',
  `jumlah` decimal(5,2) NOT NULL DEFAULT '0.00',
  `jumlah_multi` decimal(6,2) NOT NULL DEFAULT '1.00',
  `diskon` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tot_diskon` decimal(20,2) NOT NULL DEFAULT '0.00',
  `harga` decimal(20,2) NOT NULL DEFAULT '0.00',
  `tot_harga` decimal(20,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trans_jual_detail`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
