-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 05, 2011 at 07:35 AM
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
('6ee4eba779ba7830a02ec595639f25ad', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100', '838:59:59', 'a:1:{s:8:"set_lang";s:9:"indonesia";}'),
('a758ba0d125acdbc9298b0b51d8e2172', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100', '838:59:59', 'a:11:{s:8:"set_lang";s:9:"indonesia";s:6:"usr_id";s:1:"2";s:9:"usr_login";b:0;s:12:"login_number";i:0;s:8:"usr_nama";s:13:"Administrator";s:7:"ucat_id";s:1:"1";s:9:"logged_in";i:1;s:9:"usr_akses";s:13:"Administrator";s:9:"usr_alias";s:3:"Adm";s:9:"dtgFields";a:3:{s:5:"field";a:4:{s:5:"cb_id";s:5:"cb_id";s:7:"cb_nama";s:7:"cb_nama";s:9:"cb_alamat";s:9:"cb_alamat";s:7:"cb_telp";s:7:"cb_telp";}s:5:"label";a:4:{s:5:"cb_id";s:2:"ID";s:7:"cb_nama";s:11:"Nama Cabang";s:9:"cb_alamat";s:6:"Alamat";s:7:"cb_telp";s:7:"Telepon";}s:6:"params";a:4:{s:5:"cb_id";a:2:{s:6:"hidden";s:4:"true";s:3:"key";s:4:"true";}s:7:"cb_nama";a:5:{s:5:"width";i:200;s:8:"editable";s:4:"true";s:8:"sortable";s:4:"true";s:8:"edittype";s:6:"''text''";s:9:"editrules";s:15:"{required:true}";}s:9:"cb_alamat";a:4:{s:5:"width";i:300;s:8:"editable";s:4:"true";s:8:"sortable";s:4:"true";s:8:"edittype";s:6:"''text''";}s:7:"cb_telp";a:4:{s:5:"width";i:200;s:8:"editable";s:4:"true";s:8:"sortable";s:4:"true";s:8:"edittype";s:6:"''text''";}}}s:8:"dtgQuery";s:1660:"\r\n					select \r\n					p.produk_id,p.produk_kode,p.produk_nama,\r\n					s.inv_akhir,\r\n					s.inv_hrg_beli as last_buying,\r\n					tj.beli_id,\r\n					tjd.satuan_id,tjd.jumlah,tjd.diskon,tjd.tot_diskon,tjd.harga,tjd.tot_harga, tjd.jumlah_multi,\r\n					u.satuan_nama,\r\n					pem.pemasok_id,concat(pem.pemasok_nama,'', '',leg.legal_nama) as pemasok_nama,\r\n					\r\n					(\r\n						select concat(mk.kat_nama,'' / '',mk1.kat_nama,'' / '',mk2.kat_nama)\r\n						from master_kategori as mk\r\n						left join master_kategori as mk1 on mk1.kat_master = mk.kat_id\r\n						left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id\r\n						where mk2.kat_id = p.kat_id\r\n					) as kat_nama,\r\n					\r\n					(select sum(jumlah) from trans_beli_detail where beli_id = tj.beli_id)as udata_jumlah,\r\n					(select sum(harga) from trans_beli_detail where beli_id = tj.beli_id)as udata_harga,\r\n					(select sum(tot_harga) from trans_beli_detail where beli_id = tj.beli_id)as udata_tot_harga\r\n					\r\n					 \r\n					from trans_beli_detail as tjd\r\n					inner join trans_beli as tj on tj.beli_id = tjd.beli_id\r\n					inner join master_satuan as u on u.satuan_id = tjd.satuan_id\r\n					inner join master_produk as p on p.produk_id = tjd.produk_id\r\n					inner join master_kategori as k on k.kat_id = p.kat_id\r\n					left join inventory_stok as s on s.produk_id = p.produk_id\r\n					left join master_produk_satuan as ps on ps.satuan_unit_id = tjd.satuan_id and ps.produk_id = tjd.produk_id\r\n					left join master_pemasok as pem on pem.pemasok_id = tjd.pemasok_id\r\n					left join master_legality as leg on leg.legal_id = pem.legal_id\r\n					where tj.beli_user = 2 and tj.beli_status = 0\r\n				 and p.cb_id = 1 LIMIT 0,10";}'),
('b5fd3f2b4f1a2c0a078c6e31b04c6c24', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100', '838:59:59', 'a:10:{s:8:"set_lang";s:9:"indonesia";s:6:"usr_id";s:1:"2";s:9:"usr_login";b:0;s:12:"login_number";i:0;s:8:"usr_nama";s:13:"Administrator";s:7:"ucat_id";s:1:"1";s:9:"logged_in";i:1;s:9:"usr_akses";s:13:"Administrator";s:9:"usr_alias";s:3:"Adm";s:8:"dtgQuery";s:973:"\r\n					select\r\n					mp.produk_id,mp.produk_kode,mp.produk_nama,mp.kat_id,\r\n					s.inv_dokumen,\r\n					s.inv_akhir,\r\n					s.inv_hrg_beli,\r\n					s.inv_hrg_jual,\r\n					(\r\n						select concat(mk.kat_nama,'' / '',mk1.kat_nama,'' / '',mk2.kat_nama)\r\n						from master_kategori as mk\r\n						left join master_kategori as mk1 on mk1.kat_master = mk.kat_id\r\n						left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id\r\n						where mk2.kat_id = kk.kat_id\r\n					) as kat_nama,\r\n					\r\n					(\r\n					case\r\n						when s.inv_akhir = 0 or s.inv_akhir IS NULL then 0\r\n						when s.inv_dokumen LIKE ''%PR%'' then 1\r\n						when s.inv_dokumen LIKE ''%SL%'' then 2\r\n						when s.inv_dokumen = ''SETUP'' or s.inv_akhir!=0 then 3\r\n					end\r\n					) as status_item\r\n					\r\n					 \r\n					from master_produk as mp\r\n					left join inventory_stok as s on s.produk_id = mp.produk_id\r\n					inner join master_kategori as kk on kk.kat_id = mp.kat_id\r\n				 where mp.cb_id = 2 ORDER BY produk_kode asc LIMIT 0,5";}'),
('ffd2b624d4709d57ad287bd8a790473f', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100', '838:59:59', 'a:10:{s:8:"set_lang";s:9:"indonesia";s:6:"usr_id";s:1:"2";s:9:"usr_login";b:0;s:12:"login_number";i:0;s:8:"usr_nama";s:13:"Administrator";s:7:"ucat_id";s:1:"1";s:9:"logged_in";i:1;s:9:"usr_akses";s:13:"Administrator";s:9:"usr_alias";s:3:"Adm";s:8:"dtgQuery";s:168:"\r\n					select * \r\n					 \r\n					from inventory_stok_history as ihis\r\n					\r\n					where ihis.produk_id = 0 and ihis.inv_hrg_jual = 0\r\n				 ORDER BY inv_tgl desc LIMIT 0,2";}'),
('7f79ab693cca93453b45d00a50268fdd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100', '838:59:59', 'a:11:{s:8:"set_lang";s:9:"indonesia";s:6:"usr_id";s:1:"2";s:9:"usr_login";b:0;s:12:"login_number";i:0;s:8:"usr_nama";s:13:"Administrator";s:7:"ucat_id";s:1:"1";s:9:"logged_in";i:1;s:9:"usr_akses";s:13:"Administrator";s:9:"usr_alias";s:3:"Adm";s:9:"dtgFields";a:3:{s:5:"field";a:4:{s:5:"cb_id";s:5:"cb_id";s:7:"cb_nama";s:7:"cb_nama";s:9:"cb_alamat";s:9:"cb_alamat";s:7:"cb_telp";s:7:"cb_telp";}s:5:"label";a:4:{s:5:"cb_id";s:2:"ID";s:7:"cb_nama";s:11:"Nama Cabang";s:9:"cb_alamat";s:6:"Alamat";s:7:"cb_telp";s:7:"Telepon";}s:6:"params";a:4:{s:5:"cb_id";a:2:{s:6:"hidden";s:4:"true";s:3:"key";s:4:"true";}s:7:"cb_nama";a:5:{s:5:"width";i:200;s:8:"editable";s:4:"true";s:8:"sortable";s:4:"true";s:8:"edittype";s:6:"''text''";s:9:"editrules";s:15:"{required:true}";}s:9:"cb_alamat";a:4:{s:5:"width";i:300;s:8:"editable";s:4:"true";s:8:"sortable";s:4:"true";s:8:"edittype";s:6:"''text''";}s:7:"cb_telp";a:4:{s:5:"width";i:200;s:8:"editable";s:4:"true";s:8:"sortable";s:4:"true";s:8:"edittype";s:6:"''text''";}}}s:8:"dtgQuery";s:653:"\r\n			select\r\n			mp.produk_id,mp.produk_kode,mp.produk_nama,mp.kat_id,mp.produk_min_stok,mp.satuan_id,mp.keterangan,\r\n			\r\n			(\r\n				select concat(mk.kat_nama,'' / '',mk1.kat_nama,'' / '',mk2.kat_nama)\r\n				from master_kategori as mk\r\n				left join master_kategori as mk1 on mk1.kat_master = mk.kat_id\r\n				left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id\r\n				where mk2.kat_id = mp.kat_id\r\n			) as kat_nama,\r\n			\r\n			sat.satuan_nama\r\n			\r\n			 \r\n			from master_produk as mp\r\n			inner join master_kategori as kk on kk.kat_id = mp.kat_id\r\n			inner join master_satuan as sat on sat.satuan_id = mp.satuan_id\r\n		 ORDER BY produk_kode asc LIMIT 0,10";}'),
('e40240ca03adfd3187ecef271528d1e6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100', '838:59:59', 'a:11:{s:8:"set_lang";s:9:"indonesia";s:6:"usr_id";s:1:"2";s:9:"usr_login";b:0;s:12:"login_number";i:0;s:8:"usr_nama";s:13:"Administrator";s:7:"ucat_id";s:1:"1";s:9:"logged_in";i:1;s:9:"usr_akses";s:13:"Administrator";s:9:"usr_alias";s:3:"Adm";s:8:"dtgQuery";s:1644:"\r\n					select \r\n					p.produk_id,p.produk_kode,p.produk_nama,\r\n					s.inv_akhir,\r\n					s.inv_hrg_beli as last_buying,\r\n					tj.beli_id,\r\n					tjd.satuan_id,tjd.jumlah,tjd.diskon,tjd.tot_diskon,tjd.harga,tjd.tot_harga, tjd.jumlah_multi,\r\n					u.satuan_nama,\r\n					pem.pemasok_id,concat(pem.pemasok_nama,'', '',leg.legal_nama) as pemasok_nama,\r\n					\r\n					(\r\n						select concat(mk.kat_nama,'' / '',mk1.kat_nama,'' / '',mk2.kat_nama)\r\n						from master_kategori as mk\r\n						left join master_kategori as mk1 on mk1.kat_master = mk.kat_id\r\n						left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id\r\n						where mk2.kat_id = p.kat_id\r\n					) as kat_nama,\r\n					\r\n					(select sum(jumlah) from trans_beli_detail where beli_id = tj.beli_id)as udata_jumlah,\r\n					(select sum(harga) from trans_beli_detail where beli_id = tj.beli_id)as udata_harga,\r\n					(select sum(tot_harga) from trans_beli_detail where beli_id = tj.beli_id)as udata_tot_harga\r\n					\r\n					 \r\n					from trans_beli_detail as tjd\r\n					inner join trans_beli as tj on tj.beli_id = tjd.beli_id\r\n					inner join master_satuan as u on u.satuan_id = tjd.satuan_id\r\n					inner join master_produk as p on p.produk_id = tjd.produk_id\r\n					inner join master_kategori as k on k.kat_id = p.kat_id\r\n					left join inventory_stok as s on s.produk_id = p.produk_id\r\n					left join master_produk_satuan as ps on ps.satuan_unit_id = tjd.satuan_id and ps.produk_id = tjd.produk_id\r\n					left join master_pemasok as pem on pem.pemasok_id = tjd.pemasok_id\r\n					left join master_legality as leg on leg.legal_id = pem.legal_id\r\n					where tj.beli_user = 2 and tj.beli_status = 0\r\n				 LIMIT 0,10";s:9:"dtgFields";a:3:{s:5:"field";a:2:{s:9:"satuan_id";s:9:"satuan_id";s:11:"satuan_nama";s:11:"satuan_nama";}s:5:"label";a:2:{s:9:"satuan_id";s:2:"ID";s:11:"satuan_nama";s:11:"Nama Satuan";}s:6:"params";a:2:{s:9:"satuan_id";a:2:{s:6:"hidden";s:4:"true";s:3:"key";s:4:"true";}s:11:"satuan_nama";a:5:{s:5:"width";i:300;s:8:"editable";s:4:"true";s:8:"sortable";s:4:"true";s:8:"edittype";s:6:"''text''";s:9:"editrules";s:15:"{required:true}";}}}}'),
('eac2321e497f750ec5bece57e1617e51', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100', '838:59:59', 'a:1:{s:8:"set_lang";s:9:"indonesia";}'),
('f0fd4256110c9faeb410c3e340994949', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100', '838:59:59', 'a:11:{s:8:"set_lang";s:9:"indonesia";s:6:"usr_id";s:1:"2";s:9:"usr_login";b:0;s:12:"login_number";i:0;s:8:"usr_nama";s:13:"Administrator";s:7:"ucat_id";s:1:"1";s:9:"logged_in";i:1;s:9:"usr_akses";s:13:"Administrator";s:9:"usr_alias";s:3:"Adm";s:8:"dtgQuery";s:1660:"\r\n					select \r\n					p.produk_id,p.produk_kode,p.produk_nama,\r\n					s.inv_akhir,\r\n					s.inv_hrg_beli as last_buying,\r\n					tj.beli_id,\r\n					tjd.satuan_id,tjd.jumlah,tjd.diskon,tjd.tot_diskon,tjd.harga,tjd.tot_harga, tjd.jumlah_multi,\r\n					u.satuan_nama,\r\n					pem.pemasok_id,concat(pem.pemasok_nama,'', '',leg.legal_nama) as pemasok_nama,\r\n					\r\n					(\r\n						select concat(mk.kat_nama,'' / '',mk1.kat_nama,'' / '',mk2.kat_nama)\r\n						from master_kategori as mk\r\n						left join master_kategori as mk1 on mk1.kat_master = mk.kat_id\r\n						left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id\r\n						where mk2.kat_id = p.kat_id\r\n					) as kat_nama,\r\n					\r\n					(select sum(jumlah) from trans_beli_detail where beli_id = tj.beli_id)as udata_jumlah,\r\n					(select sum(harga) from trans_beli_detail where beli_id = tj.beli_id)as udata_harga,\r\n					(select sum(tot_harga) from trans_beli_detail where beli_id = tj.beli_id)as udata_tot_harga\r\n					\r\n					 \r\n					from trans_beli_detail as tjd\r\n					inner join trans_beli as tj on tj.beli_id = tjd.beli_id\r\n					inner join master_satuan as u on u.satuan_id = tjd.satuan_id\r\n					inner join master_produk as p on p.produk_id = tjd.produk_id\r\n					inner join master_kategori as k on k.kat_id = p.kat_id\r\n					left join inventory_stok as s on s.produk_id = p.produk_id\r\n					left join master_produk_satuan as ps on ps.satuan_unit_id = tjd.satuan_id and ps.produk_id = tjd.produk_id\r\n					left join master_pemasok as pem on pem.pemasok_id = tjd.pemasok_id\r\n					left join master_legality as leg on leg.legal_id = pem.legal_id\r\n					where tj.beli_user = 2 and tj.beli_status = 0\r\n				 and p.cb_id = 1 LIMIT 0,10";s:5:"cb_id";s:1:"1";}');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `master_kategori`
--

INSERT INTO `master_kategori` (`kat_id`, `kat_kode`, `kat_master`, `kat_level`, `kat_nama`) VALUES
(1, '01', 0, 1, 'FURNITURE'),
(2, '01.01', 1, 2, 'ETALASE'),
(3, '01.01.01', 2, 3, 'STANDAR'),
(4, '01.01.02', 2, 3, 'HP'),
(5, '01.02', 1, 2, 'RAK PIRING'),
(6, '01.02.01', 5, 3, '2 PNTU'),
(7, '01.02.02', 5, 3, '3 PINTU'),
(8, '01.03', 1, 2, 'JEMURAN'),
(9, '01.03.01', 8, 3, 'BIASA'),
(10, '01.03.02', 8, 3, 'WARNA'),
(11, '01.04', 1, 2, 'LEMARI PAKAIAN'),
(12, '01.04.01', 11, 3, '2 PINTU'),
(13, '01.04.02', 11, 3, '3 PINTU'),
(14, '01.05', 1, 2, 'MEJA RIAS'),
(15, '01.05.01', 14, 3, 'BINTANG PERKASA');

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
  `cb_id` int(11) NOT NULL DEFAULT '1',
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `master_produk`
--

INSERT INTO `master_produk` (`produk_id`, `produk_tgl`, `produk_kode`, `produk_nama`, `kat_id`, `cb_id`, `satuan_id`, `produk_min_stok`, `keterangan`, `status`, `tgl_akses`, `user_akses`, `stok_awal`, `harga_beli`, `harga_jual`) VALUES
(1, '2011-05-02 01:50:37', '01.01.01.001', '1,5 M', 3, 1, 13, 0.00, '', 1, '2011-05-02 00:50:37', 1, 0, 600000, 700000),
(2, '2011-05-02 01:52:09', '01.01.01.002', '2 M', 3, 1, 13, 0.00, '', 0, '2011-05-02 00:51:36', 1, 0, 700000, 800000),
(3, '2011-05-01 02:09:16', '01.01.01.003', '1M', 3, 1, 13, 0.00, '', 1, '2011-05-01 01:07:37', 1, 0, 430000, 500000),
(4, '2011-05-01 02:12:30', '01.01.01.004', 'ROKOK', 3, 1, 13, 0.00, '', 0, '2011-05-01 01:12:30', 1, 0, 140000, 200000),
(5, '2011-05-01 02:16:00', '01.01.02.001', '1M', 4, 1, 13, 0.00, '', 1, '2011-05-01 01:15:37', 1, 0, 430000, 500000),
(6, '2011-05-01 10:04:28', '01.01.02.002', '1,5', 4, 1, 13, 0.00, '', 0, '2011-05-01 01:18:33', 1, 0, 600000, 700000),
(7, '2011-05-01 02:23:22', '01.02.01.001', '2 PNTU MGC GMB', 6, 1, 13, 0.00, '', 0, '2011-05-01 01:23:22', 1, 0, 360000, 450000),
(8, '2011-05-01 02:24:24', '01.02.01.002', '2 PNTU RATA', 6, 1, 13, 0.00, '', 0, '2011-05-01 01:24:24', 1, 0, 350000, 430000),
(9, '2011-05-01 02:26:27', '01.02.02.001', '3 PNTU MGC GMB', 7, 1, 13, 0.00, '', 0, '2011-05-01 01:26:27', 1, 0, 460000, 550000),
(10, '2011-05-01 02:29:19', '01.02.02.002', '3 PNTU RATA', 7, 1, 13, 0.00, '', 0, '2011-05-01 01:29:19', 1, 0, 435000, 450000),
(11, '2011-05-01 02:30:30', '01.02.02.003', '3 PNTU GENDONG', 7, 1, 13, 0.00, '', 0, '2011-05-01 01:30:30', 1, 0, 460000, 550000),
(12, '2011-05-01 02:32:35', '01.02.02.004', 'KOMPOR', 7, 1, 13, 0.00, '', 0, '2011-05-01 01:32:35', 1, 0, 300000, 400000),
(13, '2011-05-01 02:33:41', '01.02.02.005', '3 PNTU GNDONG', 7, 1, 13, 0.00, '', 0, '2011-05-01 01:33:41', 1, 0, 460000, 500000),
(14, '2011-05-01 02:34:47', '01.02.01.003', 'FULL BOX PLOS', 6, 1, 13, 0.00, '', 0, '2011-05-01 01:34:47', 1, 0, 240000, 320000),
(15, '2011-05-01 02:35:58', '01.02.01.004', 'FULL BOX GMB', 6, 1, 13, 0.00, '', 0, '2011-05-01 01:35:58', 1, 0, 255000, 330000),
(16, '2011-05-01 02:39:18', '01.03.01.001', 'BIASA STANDAR', 9, 1, 13, 0.00, '', 0, '2011-05-01 01:39:18', 1, 0, 140000, 180000),
(17, '2011-05-01 02:40:14', '01.03.01.002', 'ALFA', 9, 1, 13, 0.00, '', 0, '2011-05-01 01:40:14', 1, 0, 65000, 80000),
(18, '2011-05-01 02:41:37', '01.03.02.001', 'KECIL', 10, 1, 13, 0.00, '', 0, '2011-05-01 01:41:10', 1, 0, 180000, 220000),
(19, '2011-05-01 02:42:46', '01.03.02.002', 'BESAR', 10, 1, 13, 0.00, '', 0, '2011-05-01 01:42:27', 1, 0, 325000, 400000),
(20, '2011-05-01 02:47:48', '01.04.01.001', 'SEVILIA', 12, 1, 13, 0.00, '', 0, '2011-05-01 01:47:48', 1, 0, 1100000, 1400000),
(21, '2011-05-01 02:49:54', '01.04.02.001', 'SEVILIA', 13, 1, 13, 0.00, '', 0, '2011-05-01 01:49:54', 1, 0, 1450000, 1900000),
(22, '2011-05-01 02:54:51', '01.04.01.002', 'CRYSYAN', 12, 1, 13, 0.00, '', 0, '2011-05-01 01:54:51', 1, 0, 750000, 900000),
(23, '2011-05-01 10:04:52', '01.04.02.002', 'SLIDING BULGARY SLIDE', 13, 1, 13, 0.00, '', 0, '2011-05-01 01:56:32', 1, 0, 1600000, 1900000),
(24, '2011-05-01 10:03:29', '01.04.01.003', 'ASTER', 12, 1, 13, 0.00, '', 0, '2011-05-01 02:01:25', 1, 0, 1100000, 1300000),
(25, '2011-05-01 10:05:16', '01.04.02.003', 'ASTER', 13, 1, 13, 0.00, '', 0, '2011-05-01 02:02:48', 1, 0, 1400000, 1800000),
(26, '2011-05-01 03:05:14', '01.04.01.004', 'LAVENDER', 12, 1, 13, 0.00, '', 0, '2011-05-01 02:05:14', 1, 0, 1150000, 1300000),
(27, '2011-05-01 09:48:40', '01.04.02.004', 'LAVENDER', 13, 1, 13, 0.00, '', 0, '2011-05-01 08:48:40', 1, 0, 1550000, 1900000),
(30, '2011-05-01 10:03:00', '01.05.01.003', 'LAENDER', 15, 1, 3, 0.00, '', 0, '2011-05-01 09:03:00', 1, 0, 575000, 700000),
(29, '2011-05-01 09:52:37', '01.05.01.002', 'ASTER', 15, 1, 3, 0.00, '', 0, '2011-05-01 08:52:37', 1, 0, 575000, 700000),
(32, '2011-05-01 10:14:34', '01.05.01.004', 'MONACO', 15, 1, 3, 0.00, '', 0, '2011-05-01 09:14:34', 1, 0, 575000, 700000),
(33, '2011-05-14 10:32:26', '01.01.02.003', 'NOKIA NGEDE', 4, 2, 1, 0.00, '', 1, '2011-05-14 15:32:26', 1, 0, 0, 0),
(34, '2011-05-14 10:46:42', '01.03.01.003', 'JEMURAN 1/2', 9, 2, 1, 0.00, '', 1, '2011-05-14 15:46:42', 1, 0, 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `master_satuan`
--

INSERT INTO `master_satuan` (`satuan_id`, `satuan_nama`, `satuan_format`, `satuan_default`) VALUES
(1, 'DUS', 0, '1'),
(3, 'SET', 0, '0'),
(13, 'PCS', 2, '0');

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
(2, 'admin', '202cb962ac59075b964b07152d234b70', 'caf1a3dfb505ffed0d024130f58c5cfa', 'Administrator', NULL, 1, '2011-04-23 09:50:40', '::1', '2011-06-05 06:55:14', '127.0.0.1', '2011-05-04 14:40:31', '::1', 1),
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `trans_beli`
--

INSERT INTO `trans_beli` (`beli_id`, `cb_id`, `beli_no`, `beli_tgl`, `beli_tot_jml`, `beli_tot_hrg`, `beli_tot_bayar`, `beli_session`, `beli_status`, `beli_user`, `cetak_rekap`, `cetak_user`) VALUES
(1, 0, '', '2011-05-22 06:06:17', 0.00, 0.00, 0.00, '', 0, 2, 0, 0);

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

INSERT INTO `trans_beli_detail` (`produk_id`, `beli_id`, `pemasok_id`, `satuan_id`, `jumlah`, `jumlah_multi`, `diskon`, `tot_diskon`, `harga`, `tot_harga`) VALUES
(1, 1, 1, 13, 10.00, 0.00, 0.00, 0.00, 1100000.00, 11000000.00),
(5, 1, 1, 13, 15.00, 15.00, 0.00, 0.00, 1400000.00, 21000000.00),
(4, 1, 1, 13, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);

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

