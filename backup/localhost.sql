-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 01, 2011 at 11:46 
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_imp`
--
CREATE DATABASE `db_imp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_imp`;

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

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('697f224aa54c0c20c266740e67610686', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100', '838:59:59', 'a:11:{s:8:"set_lang";s:9:"indonesia";s:6:"usr_id";s:1:"2";s:9:"usr_login";b:0;s:12:"login_number";i:0;s:8:"usr_nama";s:13:"Administrator";s:7:"ucat_id";s:1:"1";s:9:"logged_in";i:1;s:9:"usr_akses";s:13:"Administrator";s:9:"usr_alias";s:3:"Adm";s:8:"dtgQuery";s:653:"\r\n			select\r\n			mp.produk_id,mp.produk_kode,mp.produk_nama,mp.kat_id,mp.produk_min_stok,mp.satuan_id,mp.keterangan,\r\n			\r\n			(\r\n				select concat(mk.kat_nama,'' / '',mk1.kat_nama,'' / '',mk2.kat_nama)\r\n				from master_kategori as mk\r\n				left join master_kategori as mk1 on mk1.kat_master = mk.kat_id\r\n				left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id\r\n				where mk2.kat_id = mp.kat_id\r\n			) as kat_nama,\r\n			\r\n			sat.satuan_nama\r\n			\r\n			 \r\n			from master_produk as mp\r\n			inner join master_kategori as kk on kk.kat_id = mp.kat_id\r\n			inner join master_satuan as sat on sat.satuan_id = mp.satuan_id\r\n		 ORDER BY produk_kode asc LIMIT 0,10";s:9:"dtgFields";a:3:{s:5:"field";a:4:{s:5:"cb_id";s:5:"cb_id";s:7:"cb_nama";s:7:"cb_nama";s:9:"cb_alamat";s:9:"cb_alamat";s:7:"cb_telp";s:7:"cb_telp";}s:5:"label";a:4:{s:5:"cb_id";s:2:"ID";s:7:"cb_nama";s:11:"Nama Cabang";s:9:"cb_alamat";s:6:"Alamat";s:7:"cb_telp";s:7:"Telepon";}s:6:"params";a:4:{s:5:"cb_id";a:2:{s:6:"hidden";s:4:"true";s:3:"key";s:4:"true";}s:7:"cb_nama";a:5:{s:5:"width";i:200;s:8:"editable";s:4:"true";s:8:"sortable";s:4:"true";s:8:"edittype";s:6:"''text''";s:9:"editrules";s:15:"{required:true}";}s:9:"cb_alamat";a:4:{s:5:"width";i:300;s:8:"editable";s:4:"true";s:8:"sortable";s:4:"true";s:8:"edittype";s:6:"''text''";}s:7:"cb_telp";a:4:{s:5:"width";i:200;s:8:"editable";s:4:"true";s:8:"sortable";s:4:"true";s:8:"edittype";s:6:"''text''";}}}}'),
('ca3756db404d2b23421b66c1760da956', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100', '838:59:59', 'a:1:{s:8:"set_lang";s:9:"indonesia";}');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `inventory_stok`
--

INSERT INTO `inventory_stok` (`inv_id`, `produk_id`, `pemasok_id`, `inv_tgl`, `inv_mulai`, `inv_masuk`, `inv_keluar`, `inv_akhir`, `inv_hrg_beli`, `inv_hrg_jual`, `inv_hrg_rbeli`, `inv_hrg_rjual`, `inv_dokumen`, `inv_usr`) VALUES
(1, 1, 0, '2011-06-05 12:41:04', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'SETUP', 2);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `inventory_stok_history`
--

INSERT INTO `inventory_stok_history` (`id`, `inv_id`, `produk_id`, `pemasok_id`, `inv_tgl`, `inv_mulai`, `inv_masuk`, `inv_keluar`, `inv_akhir`, `inv_hrg_beli`, `inv_hrg_jual`, `inv_hrg_rbeli`, `inv_hrg_rjual`, `inv_dokumen`, `inv_usr`) VALUES
(1, 1, 1, 0, '2011-06-05 12:41:04', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'SETUP', 2);

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
(99, 'Super Administrator', 'SA');

-- --------------------------------------------------------

--
-- Table structure for table `master_cabang`
--

CREATE TABLE IF NOT EXISTS `master_cabang` (
  `cb_id` int(11) NOT NULL AUTO_INCREMENT,
  `cb_nama` varchar(50) NOT NULL,
  `cb_alamat` text NOT NULL,
  `cb_telp` varchar(20) NOT NULL,
  `cb_default` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cb_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `master_cabang`
--

INSERT INTO `master_cabang` (`cb_id`, `cb_nama`, `cb_alamat`, `cb_telp`, `cb_default`) VALUES
(1, 'Pusat', 'Sukabumi no.4', '', 1),
(2, 'Pelabuhan Ratu', 'Sukabumi no.8c', '', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `master_kategori`
--

INSERT INTO `master_kategori` (`kat_id`, `kat_kode`, `kat_master`, `kat_level`, `kat_nama`) VALUES
(1, '01', 0, 1, 'ATK'),
(2, '01.01', 1, 2, 'Alat tulis'),
(4, '01.01.01', 2, 3, 'Balpoin');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `master_pemasok`
--

INSERT INTO `master_pemasok` (`pemasok_id`, `legal_id`, `pemasok_nama`, `pemasok_alamat`, `pemasok_telp`, `pemasok_email`, `pemasok_npwp`, `kat_id`) VALUES
(1, 1, 'General (Warung)', '', '', '', '', 0);

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
  `cb_id` int(11) NOT NULL DEFAULT '0',
  `satuan_id` int(11) NOT NULL,
  `produk_min_stok` decimal(6,2) NOT NULL DEFAULT '0.00',
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `tgl_akses` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_akses` int(11) NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  PRIMARY KEY (`produk_id`),
  KEY `kat_id` (`kat_id`),
  KEY `satuan_id` (`satuan_id`),
  KEY `cb_id` (`cb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `master_produk`
--

INSERT INTO `master_produk` (`produk_id`, `produk_tgl`, `produk_kode`, `produk_nama`, `kat_id`, `cb_id`, `satuan_id`, `produk_min_stok`, `keterangan`, `status`, `tgl_akses`, `user_akses`, `stok_awal`, `harga_beli`, `harga_jual`) VALUES
(1, '2011-06-05 07:41:04', '01.01.01.001', 'PILOT MERAH', 4, 1, 1, 0.00, 'WEW', 0, '2011-06-05 12:41:04', 1, 0, 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `master_satuan`
--

INSERT INTO `master_satuan` (`satuan_id`, `satuan_nama`, `satuan_format`, `satuan_default`) VALUES
(1, 'PCS', 2, '0');

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
  `jual_no` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_counter`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `sys_menu`
--

INSERT INTO `sys_menu` (`menu_id`, `menu_parent`, `menu_level`, `menu_nama`, `menu_icon`, `menu_module`, `menu_sort`) VALUES
(1, 0, 1, 'Master Data', '', '', 0),
(2, 1, 2, 'User', '', 'master_user', 0),
(3, 1, 2, 'Unit', '', 'master_satuan', 1),
(4, 1, 2, 'Category', '', 'master_kategori', 2),
(5, 1, 2, 'Supplier', '', 'master_pemasok', 3),
(6, 1, 2, 'Product', '', 'master_produk', 5),
(7, 11, 1, 'Inventory', '', 'laporan_stok', 0),
(8, 0, 1, 'Transaction', '', '', 2),
(9, 8, 2, 'Buying', '', 'transaksi_beli', 0),
(10, 8, 2, 'Selling', '', 'transaksi_jual', 1),
(11, 0, 1, 'Report', '', '', 3),
(12, 11, 2, 'Transaction', '', '', 0),
(13, 12, 3, 'Buying', '', 'laporan_beli', 0),
(14, 12, 3, 'Selling', '', 'laporan_jual', 1),
(15, 1, 2, 'Cabang', '', 'master_cabang', 4);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sys_user`
--

INSERT INTO `sys_user` (`usr_id`, `usr_login`, `usr_pwd1`, `usr_pwd2`, `usr_nama`, `usr_image`, `ucat_id`, `lastTime_log`, `lastIP_log`, `newTime_log`, `newIP_log`, `offTime_log`, `offIP_log`, `login_status`) VALUES
(1, 'su', 'cb3bae31bb1c443fbf3db8889055f2fe', 'cb3bae31bb1c443fbf3db8889055f2fe', 'Super Admin', NULL, 99, '2011-04-23 09:31:43', '::1', '2011-04-25 11:03:39', '::1', '2011-04-23 09:49:42', '::1', 1),
(2, 'admin', '202cb962ac59075b964b07152d234b70', 'caf1a3dfb505ffed0d024130f58c5cfa', 'Administrator', NULL, 1, '2011-04-23 09:50:40', '::1', '2011-06-05 07:36:31', '127.0.0.1', '2011-05-04 14:40:31', '::1', 1),
(3, 'ahrie', '202cb962ac59075b964b07152d234b70', 'caf1a3dfb505ffed0d024130f58c5cfa', 'OP', NULL, 2, '2011-05-01 06:01:00', '127.0.0.1', '2011-05-01 06:01:00', '127.0.0.1', '2011-05-01 06:01:44', '127.0.0.1', 1),
(4, 'aa', '202cb962ac59075b964b07152d234b70', 'caf1a3dfb505ffed0d024130f58c5cfa', 'ffas', NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1);

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

INSERT INTO `sys_user_menu` (`usr_id`, `menu_id`) VALUES
(3, 8),
(3, 9),
(3, 10),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 8),
(4, 9),
(4, 10);

-- --------------------------------------------------------

--
-- Table structure for table `trans_beli`
--

CREATE TABLE IF NOT EXISTS `trans_beli` (
  `beli_id` int(11) NOT NULL AUTO_INCREMENT,
  `cb_id` int(11) NOT NULL DEFAULT '1',
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
  PRIMARY KEY (`beli_id`),
  KEY `cb_id` (`cb_id`)
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
  `tot_harga` decimal(20,2) NOT NULL DEFAULT '0.00',
  KEY `produk_id` (`produk_id`),
  KEY `beli_id` (`beli_id`),
  KEY `pemasok_id` (`pemasok_id`),
  KEY `satuan_id` (`satuan_id`)
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

