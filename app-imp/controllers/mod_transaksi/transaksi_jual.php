<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	13/12/2010
 @model
	- flexigrid
	- tbl_gudang
	- tbl_kategori
 @view
	- main_view
 @library
    - JS
    - PHP
 @comment
	- 
	
*/

class Transaksi_jual extends IMP_Controller {
	public static $link_view, $link_controller, $link_controller_kategori;
	// constructor
	function __construct () 
	{
		parent::__construct();	
	
		$class = get_class($this);
		
		$this->_loader_class();
		
		$output = array();
		$output += $this->_content_init();
		$output += $this->_public_init();
		$output += $this->_variable_init();
		$output += $this->_data_init();
		
		$this->load->vars($output);
		
		log_message('debug', "IMP -> Class $class init success");
	}
	
	// @info	: Loader class model,helper,config,library
	// @params	: null
	// @return	: null
	function _loader_class()
	{
		$this->load->library(array(
			"datagrid","lib_split",
		));
		$this->load->model(array(
			"jqgrid_model","tbl_produk","tbl_produk_satuan",
			"tbl_inventory","tbl_inventory_history",
			"tbl_kategori","tbl_satuan",
			"tbl_jual","tbl_jual_detail"
		));

		return false;
	}
	
	// @info	: Extra Sub Header Content for JS & CSS
	// @access	: private
	// @params	: null
	// @return	: array	
	function _content_init()
	{
		$content = doctype('xhtml1-trans')."\n"; // XML TRADITIONAL
		
		$arrayCSS = array (		
		'asset/src/jQuery/themes/ui-darkness/jquery.ui.all.css',
		
		'asset/src/jQuery/plugins/tables/jquery.jqGrid/css/ui.jqgrid.css',
		'asset/src/jQuery/plugins/tables/datagrid/datagrid.css',
		'asset/src/jQuery/plugins/form/autocomplete/jquery.autocomplete.css',
		
		'asset/src/jQuery/plugins/tree/dynatree/skin-vista/ui.dynatree.css',
		//"asset/src/jQuery/plugins/tables/flexigrid/css/flexigrid.css",
		
		/* ADDITIONAL CSS PLUGINS */
		//'asset/css/jqgrid.patch.css',
		);
		
		$arrayJS = array (
		'asset/src/jQuery/core/jquery-1.5.1.js',
		'asset/src/jQuery/ui/jquery-ui-1.8.11.custom.js',
		
		'asset/src/jQuery/plugins/tables/jquery.jqGrid/src/i18n/grid.locale-en.js',
		'asset/src/jQuery/plugins/tables/jquery.jqGrid/js/jquery.jqGrid.min.js',
		'asset/src/jQuery/plugins/tables/datagrid/datagrid.js',
		'asset/src/jQuery/plugins/form/autocomplete/jquery.autocomplete.js',
		
		'asset/src/jQuery/plugins/form/jquery.form.js',
		'asset/src/jQuery/plugins/form/jquery.autoNumeric.js',
		
		'asset/src/jQuery/plugins/jquery.cookie.js',
		'asset/src/jQuery/plugins/tree/dynatree/jquery.dynatree.js',
		//'asset/src/jQuery/plugins/tables/flexigrid/js/flexigrid.js',
		
		/* ADDITIONAL JS PLUGINS */
		'asset/src/jQuery/general/tabs.js',
		'asset/src/jQuery/helper/autoNumeric.js',
		'asset/src/jQuery/helper/validasi.js',
		'asset/src/jQuery/helper/dialog.js',
		);
				
		if (is_array($arrayCSS))
		foreach ($arrayCSS as $css):
			$content .= "<link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"".base_url().$css."\"/>\n";
		endforeach;
		
		if (is_array($arrayJS))
		foreach ($arrayJS as $js):
			$content .= "<script type=\"text/javascript\" src=\"".base_url().$js."\"/></script>\n";
		endforeach;
		
		// BIND OPTIONAL JS HERE =========>
		$content .= "
			<script type=\"text/javascript\">
				$.jgrid.no_legacy_api = true;
				$.jgrid.useJSON = true;
				$.jgrid.defaults = $.extend($.jgrid.defaults,{loadui:\"enable\"});
			</script>";
		
		$output['extraSubHeaderContent'] = $content;
		
		return $output;
	}
	
	// @info	: Load public variable
	// @access	: private
	// @params	: null
	// @return	: array
	function _public_init()
	{
		// public variable
		self::$link_controller = 'mod_transaksi/transaksi_jual';
		self::$link_controller_kategori = 'mod_transaksi/transaksi_jual';
		self::$link_view = 'mod_transaksi/transaksi_jual';
		$output['link_view'] = self::$link_view;
		$output['link_controller'] = self::$link_controller;
		$output['link_controller_kategori'] = self::$link_controller_kategori;	
		
		return $output;
	}
	
	// @info	: Load local variable
	// @access	: private
	// @params	: null
	// @return	: array
	function _variable_init()
	{
		// private variable
		$path_themes = $this->config->item('path_themes');
		$output['page_title'] = content_title("SELLING TRANSACTION",$path_themes);
		
		$output['arrArt'] = $this->config->item('arrDivArt');
		
		return $output;
	}
	
	// @info	: Load data in database on init
	// @access	: private
	// @params	: null
	// @return	: array
	function _data_init()
	{
		$output['list_kategori'] = $this->tbl_kategori->data_kategori();
		$output['list_satuan'] = $this->tbl_satuan->data_satuan();
		
		$SQL = "select * from master_jenis_trans";
		$output['list_tipe_bayar'] = $this->db->query($SQL);
		
		return $output;
	}
	
	function index() 
	{
		$data[] = "";
		$this->load->view(self::$link_view."/jual_main_view",$data);
	}
	
	function daftar_produk() {	
		$data[''] = '';
		$this->load->view(self::$link_view."/jual_main_grid_view",$data);
	}
	
	function daftar_jual() {
		$data[''] = '';
		$this->load->view(self::$link_view."/jual_detail_view",$data);
	}	
	
	function get_data($gridType='produk') {
		$user_id = $this->session->userdata('usr_id');
		
		switch ($gridType):
			case 'produk':
				$SQL = "
					select
					mp.produk_id,mp.produk_kode,mp.produk_nama,mp.kat_id,
					s.inv_akhir,
					s.inv_dokumen,
					s.inv_hrg_beli,
					s.inv_hrg_jual,
					
					(
						select concat(mk.kat_nama,' / ',mk1.kat_nama,' / ',mk2.kat_nama)
						from master_kategori as mk
						left join master_kategori as mk1 on mk1.kat_master = mk.kat_id
						left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id
						where mk2.kat_id = kk.kat_id
					) as kat_nama,
					
					(
					case
						when s.inv_akhir=0 then 0
						when s.inv_dokumen LIKE '%PR%' then 1
						when s.inv_dokumen LIKE '%SL%' then 2
						when s.inv_dokumen = 'SETUP' or s.inv_akhir!=0 then 3
					end
					) as status_item
					
					{COUNT_STR}
					from master_produk as mp
					inner join inventory_stok as s on s.produk_id = mp.produk_id
					inner join master_kategori as kk on kk.kat_id = mp.kat_id
				";
				$rs = $this->jqgrid_model->get_data_query($SQL,'mp.produk_id');
			break;
			
			case 'price':
				$produk_id = $this->input->get_post('produk_id');
				$SQL = "
					select * 
					{COUNT_STR}
					from inventory_stok_history as ihis
					
					where ihis.produk_id = $produk_id and ihis.inv_hrg_beli = 0
				";
				$rs = $this->jqgrid_model->get_data_query($SQL,'ihis.inv_id');
			break;
			
			case 'history':
				$SQL = "
					select
					*
					{COUNT_STR}
					from trans_jual as tj
					inner join sys_user as su on su.usr_id = tj.jual_user
					inner join master_jenis_trans as mjt on mjt.trans_jenis_id = tj.trans_jenis_id
					where tj.jual_user = $user_id and tj.jual_status = 1
				";
				$rs = $this->jqgrid_model->get_data_query($SQL,'tj.jual_id');
			break;
			
			case 'selling':
				$SQL = "
					select 
					p.produk_id,p.produk_kode,p.produk_nama,
					s.inv_akhir,
					s.inv_hrg_beli as last_buying,
					s.inv_hrg_jual as last_selling,
					
					tj.jual_id,
					tjd.satuan_id,tjd.jumlah,tjd.diskon,tjd.tot_diskon,tjd.harga,tjd.tot_harga, tjd.jumlah_multi,
					u.satuan_nama,
					
					(
						select concat(mk.kat_nama,' / ',mk1.kat_nama,' / ',mk2.kat_nama)
						from master_kategori as mk
						left join master_kategori as mk1 on mk1.kat_master = mk.kat_id
						left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id
						where mk2.kat_id = p.kat_id
					) as kat_nama,
					
					(select sum(jumlah) from trans_jual_detail where jual_id = tj.jual_id)as udata_jumlah,
					(select sum(harga) from trans_jual_detail where jual_id = tj.jual_id)as udata_harga,
					(select sum(tot_harga) from trans_jual_detail where jual_id = tj.jual_id)as udata_tot_harga
					
					{COUNT_STR}
					from trans_jual_detail as tjd
					inner join trans_jual as tj on tj.jual_id = tjd.jual_id
					inner join master_satuan as u on u.satuan_id = tjd.satuan_id
					inner join master_produk as p on p.produk_id = tjd.produk_id
					inner join master_kategori as k on k.kat_id = p.kat_id
					inner join inventory_stok as s on s.produk_id = p.produk_id
					left join master_produk_satuan as ps on ps.satuan_unit_id = tjd.satuan_id and ps.produk_id = tjd.produk_id
					where tj.jual_user = $user_id and tj.jual_status = 0
				";
				
				// FOOTER SUMMARY FIELD
				$summary['jumlah'] = 'udata_jumlah';
				$summary['harga'] = 'udata_harga';
				$summary['tot_harga'] = 'udata_tot_harga';
				
				$rs = $this->jqgrid_model->get_data_query($SQL,'p.produk_id',TRUE,FALSE,$summary);
			break;
		endswitch;
		
		echo json_encode($rs);
	}
	
	function cek_tabs_jual() {
		$user_id= $this->session->userdata('usr_id');
		
		$SQL = "select tbd.produk_id 
		from trans_jual_detail as tbd 
		inner join trans_jual as tb on tbd.jual_id = tb.jual_id
		where tb.jual_user = $user_id and tb.jual_status = 0
		";
		
		$get_jual = $this->db->query($SQL);//$this->tbl_jual->data_jual($where);
		$count = $get_jual->num_rows();
		if ($count > 0)
			echo $count;
	}
	
	function tambah_jual($type = 'add', $smartAdd = FALSE) {
		// GET POST
		$arrCek = array();
		$user_id = $this->session->userdata('usr_id');
		
		if (!$smartAdd):
			$produk_id = $this->input->post('produk_id');
			$satuan_id = $this->input->post('satuan_id');
			$jumlah = $this->input->post('jumlah');
			$jumlah_multi = $this->input->post('jumlah_multi');
			$kat_id = $this->input->post('kat_id');
			$inv_hrg_jual = $this->input->post('inv_hrg_jual');
			$diskon = $this->input->post('diskon');
			$tot_diskon = $this->input->post('tot_diskon');
			$harga = $this->input->post('harga');
			$tot_harga = $this->input->post('tot_harga');
		else:
			$produk_id = $smartAdd;
		endif;
		
		// INSERT TRANSAKSI JUAL
		$wbeli['jual_user'] = $user_id;
		$wbeli['jual_status'] = 0;
		$gbeli = $this->tbl_jual->data_jual($wbeli);
		if ($gbeli->num_rows() > 0):
			$rbeli = $gbeli->row();
			$jual_id = $rbeli->jual_id;
		else:
			$dbeli['jual_user'] = $user_id;
			$dbeli['jual_tgl'] = date('Y-m-d H:i:s');
			if ($this->tbl_jual->tambah_jual($dbeli))
				$jual_id = $this->db->insert_ID();
		endif;
		
		// CEK DUPLIKASI ITEM
		$wjual_detail['produk_id'] = $produk_id;
		$wjual_detail['jual_id'] = $jual_id;
		$gjual_detail = $this->tbl_jual_detail->data_jual_detail($wjual_detail);
		if ($gjual_detail->num_rows() > 0): 
			$arrCek = 'duplikasi';
		endif;
		
		// PREPARE INSERT TRANSAKSI JUAL DETAIL
		if (!$smartAdd):
			$djual_detail['produk_id'] = $produk_id;
			
			$djual_detail['jual_id'] = $jual_id;
			$djual_detail['satuan_id'] = $satuan_id;
			$djual_detail['jumlah'] = $jumlah;
			$djual_detail['jumlah_multi'] = $jumlah_multi*$jumlah;
			$djual_detail['diskon'] = $diskon;
			$djual_detail['tot_diskon'] = $tot_diskon;
			$djual_detail['harga'] = $harga;
			$djual_detail['tot_harga'] = $tot_harga;
			
			$arrCek = $this->cek_tambah_jual($type,$arrCek,$wjual_detail,$djual_detail);
		else:
			// GET PRODUK DATA
			$wproduk['produk_id'] = $produk_id;
			$gproduk = $this->tbl_produk->data_produk(false,$wproduk);
			$gsatuan_id = $gproduk->row()->satuan_id;
			//$gharga = $gproduk->row()->harga_beli;	// COMPARE WITH BUYING PRICE
			
			// GET STOK
			$wstok['produk_id'] = $produk_id;
			$gstok = $this->tbl_inventory->data_inventory($wstok);
			if ($gstok->num_rows() > 0)
				if ($gstok->row()->inv_hrg_beli != 0)
					$gharga = $gstok->row()->inv_hrg_beli;	// COMPARE WITH BUYING PRICE
					
			// JIKA TIDAK ADA RELASI HARGA SMARTY ADD DITOLAK
			if ($gharga == 0):
				$arrCek = 'manual';
				return false;
			endif;
			
			$sjual_detail['produk_id'] = $produk_id;
			$sjual_detail['jual_id'] = $jual_id;
			$sjual_detail['satuan_id'] = $gsatuan_id;
			$sjual_detail['jumlah'] = 1;
			$sjual_detail['jumlah_multi'] = 1;
			$sjual_detail['diskon'] = 0;
			$sjual_detail['tot_diskon'] = 0;
			$sjual_detail['harga'] = $gharga;
			$sjual_detail['tot_harga'] = $gharga;
			
			$arrCek = $this->cek_tambah_jual($type,$arrCek,$wjual_detail,$sjual_detail);
		endif;
	
		echo $arrCek;
	}
	
	function cek_tambah_jual($type,$arrCek,$wjual_detail,$djual_detail) {
		// INSERT TRANSAKSI JUAL DETAIL
		if ($type=='add'):	
			if ($arrCek != 'duplikasi'):
				if ( $this->tbl_jual_detail->tambah_jual_detail($djual_detail)):
					$arrCek = 'sukses';	
				endif;
			endif;
		else:
			unset ($djual_detail['produk_id'],$djual_detail['jual_id']);
			$this->tbl_jual_detail->ubah_jual_detail($wjual_detail,$djual_detail);
			$arrCek = 'sukses';
		endif;
		
		return $arrCek;
	}
	
	function proses_jual() {
		$user_id = $this->session->userdata('usr_id');
		
		$thn     = date("Y");
		$str_thn = date("y");
		$bln     = date("n");
		$str_bln = date("m");
		
		// GET JUAL ID
		$wbeli['jual_user'] = $user_id;
		$wbeli['jual_status'] = 0;
		$gbeli = $this->tbl_jual->data_jual($wbeli);
		if ($gbeli->num_rows() > 0):
			$rbeli = $gbeli->row();
			$jual_id = $rbeli->jual_id;
		else:
			return false;
		endif;
	
		$where_counter['bln'] = $bln;
		$where_counter['thn'] = $thn;
		$get_counter = $this->tbl_sys_counter->data_sys_counter($where_counter);
		
		if ($get_counter->num_rows() > 0):
			$set_jual_no = $get_counter->row()->jual_no;
		else:
			$set_jual_no  = 0;
			$insert_counter['thn']=$thn;
			$insert_counter['bln']=$bln;
			$this->tbl_sys_counter->tambah_sys_counter($insert_counter);
		endif;
		
		$set_jual_no++;
		
		$update_counter['jual_no'] = $set_jual_no;
		if ($this->tbl_sys_counter->ubah_sys_counter($where_counter,$update_counter)):
			$jual_no     =  str_pad($set_jual_no, 4, "0", STR_PAD_LEFT);
		
			// BELI NUMBER
			$str_jual_no =  $str_thn."/".$str_bln."/SL".$jual_no;
			
			// UPDATE STOK
			$rdata = $this->satuan_stok($jual_id,$str_jual_no);
			
			$where['jual_id'] = $jual_id;
			$data['jual_no'] = $str_jual_no;
			$data['jual_tot_jml'] = $rdata['tot_jumlah'];
			$data['jual_tot_hrg'] = $rdata['tot_harga'];
			//$data['jual_tot_bayar'] = $this->input->post('total_bayar');
			$data['jual_status'] = 1;
			$data['jual_session'] = '';
			$data['trans_jenis_id'] = $this->input->post('trans_jenis_id');;
			$this->tbl_jual->ubah_jual($where,$data);
			echo $jual_id;
			//endif;
		endif;
	}
	
	function satuan_stok($jual_id,$jual_no=0) {
		$user_id = $this->session->userdata('usr_id');
		
		$proses = array();
		$arrProduk = array();
		$rdata['tot_jumlah'] = 0;
		$rdata['tot_harga'] = 0;
		
		// KONVERSI MULTI SATUAN QUERY EASY USING FIELD T_T
		$SQL = "select 
		tjd.produk_id,tjd.harga,
		tjd.jumlah,
		tjd.jumlah_multi as tot_jumlah,
		tjd.tot_harga
		from trans_jual as tj
		inner join trans_jual_detail as tjd on tjd.jual_id = tj.jual_id
		where tj.jual_id = $jual_id and tj.jual_user = $user_id and tj.jual_status = 0
		";
		
		$get_data = $this->db->query($SQL);
		if ($get_data->num_rows() > 0):
			foreach ($get_data->result() as $row):
				// SET ARR PRODUK
				$arrProduk[] = $row->produk_id;
				
				// SUM ALL TOTAL
				$rdata['tot_jumlah'] += $row->jumlah;
				$rdata['tot_harga'] += $row->tot_harga;
				
				// GET STOK
				$winv['produk_id'] = $row->produk_id;
				$ginv = $this->tbl_inventory->data_inventory($winv);
				if ($ginv->num_rows() > 0):
					// UPDATE STOK
					$inv_id = $ginv->row()->inv_id;
					$inv_akhir = $ginv->row()->inv_akhir;
					$dinv['inv_mulai'] = $inv_akhir;
					$dinv['inv_keluar'] = $row->tot_jumlah;
					$dinv['inv_akhir'] = $inv_akhir - $row->tot_jumlah;
					//$dinv['inv_harga'] = $row->harga; 
					$dinv['inv_hrg_jual'] = $row->harga; 
					$dinv['inv_dokumen'] = $jual_no; 
					$dinv['inv_usr'] = $user_id; 
					$this->tbl_inventory->ubah_inventory($winv,$dinv);
					
					// INSERT STOK HISTORY
					$dinv_hist['inv_id'] = $inv_id; 
					$dinv_hist['produk_id'] = $row->produk_id; 
					$adinv_hist = array_merge($dinv,$dinv_hist);
					if ($this->tbl_inventory_history->tambah_inventory_history($adinv_hist)):
						$proses[] = true;
					else:
						$proses[] = false;
					endif;
					
					unset($dinv,$dinv_hist); // DON'T FORGET WE USE ONE VARIABLE IN ONE FUNCTION
				else:
					// INSERT STOK
					$dinv['produk_id'] = $row->produk_id;
					$dinv['inv_mulai'] = 0;
					$dinv['inv_masuk'] = 0;
					$dinv['inv_keluar'] = $row->tot_jumlah;
					$dinv['inv_akhir'] = $row->tot_jumlah;
					//$dinv['inv_harga'] = $row->harga; 
					$dinv['inv_hrg_jual'] = $row->harga; 
					$dinv['inv_dokumen'] = $jual_no; 
					$dinv['inv_usr'] = $user_id; 
					if ($this->tbl_inventory->tambah_inventory($dinv)):
						$inv_id = $this->db->insert_ID();
						// INSERT STOK HISTORY
						$dinv_hist['inv_id'] = $inv_id; 
						$adinv_hist = array_merge($dinv,$dinv_hist);
						if ($this->tbl_inventory_history->tambah_inventory_history($adinv_hist)):
							$proses[] = true;
						else:
							$proses[] = false;
						endif;
					endif;
					unset($dinv,$dinv_hist); // DON'T FORGET WE USE ONE VARIABLE IN ONE FUNCTION
				endif;
			endforeach;
			
			// UPDATE STATUS PRODUK
			if (sizeOf($arrProduk) > 0)
				$this->db->query("update master_produk set status = 1 where produk_id in (".implode(",",$arrProduk).")");
		endif;
		
		if (in_array(true,$proses)):
			return $rdata;
		else:
			return false;
		endif;			
	}
	
	function hapus_jual($jual_id,$produk_id = false) {
		$wjual_detail['jual_id'] = $jual_id;
		$gjual_detail = $this->tbl_jual_detail->data_jual_detail($wjual_detail);
		if (is_numeric($produk_id) && $gjual_detail->num_rows() > 1):
			$wjual_detail['produk_id'] = $produk_id;
			$this->tbl_jual_detail->hapus_jual_detail($wjual_detail);
			echo 'items';
		else:
			$this->tbl_jual->hapus_jual($wjual_detail);
			$this->tbl_jual_detail->hapus_jual_detail($wjual_detail);
			echo 'beli';
		endif;
	}
	
	function set_multi_satuan($produk_id,$satuan_id)
	{
		$qsat = "select * from master_satuan where satuan_id = $satuan_id"; 
		$qmulti = "select ms.satuan_id,ms.satuan_nama,ps.volume 
		from master_satuan as ms
		inner join master_produk_satuan as ps on ps.satuan_unit_id = ms.satuan_id 
		and ps.produk_id = $produk_id"; 
		
		$get_multi = $this->db->query($qmulti);
		if ($get_multi->num_rows() <= 0)
			$get_multi = $this->db->query($qsat);
		
		echo "<option value='' volume=1>-= Select =-</option>";
		if ($get_multi->num_rows() > 0):
			foreach ($get_multi->result() as $rows):
				$volume = ($rows->volume!=0)?($rows->volume):(1);
				$volume_str = ($volume!=1)?('('.$volume.')'):('');
				$selected = ($rows->satuan_id == $satuan_id)?('SELECTED'):('');
				echo "<option value='".$rows->satuan_id."' ".$selected." volume='".$volume."'>".$rows->satuan_nama.' '.$volume_str."</option>";
			endforeach;
		endif;
	}
	
	function list_autocomplate($type=FALSE,$q=FALSE) 
	{		
		if (!$type || !$q):
			$type	= $this->input->get('tipe');
			$value 	= $this->input->get('q');
		endif;
		
		$qproduk = "
			select p.produk_id,p.produk_kode,p.produk_nama,p.satuan_id,k.kat_id,
			s.inv_akhir,
			s.inv_hrg_beli as last_buying,
			s.inv_hrg_jual as last_selling,
			(
				select concat(mk.kat_nama,' / ',mk1.kat_nama,' / ',mk2.kat_nama)
				from master_kategori as mk
				left join master_kategori as mk1 on mk1.kat_master = mk.kat_id
				left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id
				where mk2.kat_id = p.kat_id
			) as kat_nama
			from master_produk as p
			inner join master_kategori as k on k.kat_id = p.kat_id
			left join inventory_stok as s on s.produk_id = p.produk_id
		";
		
		switch ($type):
			case 'produk_kode':
				$qproduk .= "where p.produk_kode like '".$value."%'";
				$qres = $this->db->query($qproduk);
			break;
			case 'produk_nama':
				$qproduk .= "where p.produk_nama like '".$value."%'";
				$qres = $this->db->query($qproduk);
			break;
		endswitch;
		
		if (!isset($qres))
			return false;
			
		if ($qres->num_rows() > 0):
			foreach ($qres->result() as $rows):
				switch ($type):
					case 'produk_kode' :
						$check = $rows->produk_kode;
						$res = "$rows->produk_kode|$rows->produk_id|$rows->produk_nama|$rows->produk_kode|$rows->kat_id|$rows->kat_nama|$rows->satuan_id|$rows->last_buying|$rows->last_selling|$rows->inv_akhir\n";
					break;
					case 'produk_nama' :
						$check = $rows->produk_nama;
						$res = "$rows->produk_nama|$rows->produk_id|$rows->produk_nama|$rows->produk_kode|$rows->kat_id|$rows->kat_nama|$rows->satuan_id|$rows->last_buying|$rows->last_selling|$rows->inv_akhir\n";
					break;
				endswitch;
				
				if (strpos(strtolower($check), strtolower($value)) !== false):
					echo $res;
				endif;
			endforeach;
		endif;	
	}
	
}

/* End of file master_kategori.php */
/* Location: ./app/controllers/mod_master/master_kategori.php */