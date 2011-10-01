<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	13/12/2010
 @model
	- flexigrid
	- tbl_produk
	- tbl_kategori
 @view
	- main_view
 @library
    - JS
    - PHP
 @comment
	- 
	
*/

class Master_produk extends IMP_Controller {
	public static $link_view, $link_controller, $link_controller_kategori;
	private $user_id,$get_lang;
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
		$output += $this->_language();
		
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
			//"flexigrid","flexi_engine"
		));
		$this->load->model(array(
			"jqgrid_model","tbl_produk","tbl_produk_satuan",
			"tbl_inventory","tbl_inventory_history",
			"tbl_kategori","tbl_satuan","tbl_cabang",//"flexi_model","metadata"
		));
		$this->load->helper(array('flexigrid'));
		$this->config->load("flexigrid");

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
		'asset/src/jQuery/plugins/tables/jquery.jqGrid/css/ui.jqgrid.css',
		'asset/src/jQuery/plugins/tables/datagrid/datagrid.css',
		'asset/src/jQuery/plugins/form/autocomplete/jquery.autocomplete.css',
		
		'asset/src/jQuery/plugins/tree/dynatree/skin-vista/ui.dynatree.css',
		//"asset/src/jQuery/plugins/tables/flexigrid/css/flexigrid.css",
		
		/* ADDITIONAL CSS PLUGINS */
		//'asset/css/jqgrid.patch.css',
		);
		
		$arrayJS = array (
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
		self::$link_controller = 'mod_master/master_produk';
		self::$link_controller_kategori = 'mod_master/master_kategori';
		self::$link_view = 'mod_master/master_produk';
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
		$this->user_id = $this->session->userdata('usr_id');
		$path_themes = $this->config->item('path_themes');
		$output['path_themes'] = $path_themes;
		
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
		$output['list_cabang'] = $this->tbl_cabang->data_cabang();
		
		$arrOpt = array();
		$gcb = $this->tbl_cabang->data_cabang();
		if ($gcb->num_rows() > 0):
			foreach ($gcb->result() as $row):
				$default = ($row->cb_default)?('SELECTED'):('');
				$arrOpt[] = "<option value='".$row->cb_id."' ".$default.">".$row->cb_nama."</option>";
			endforeach;
		endif;
		
		$output['opt_cabang'] = implode('',$arrOpt);
		
		return $output;
	}
	
	// @info	: Language Switch
	// @access	: privte
	// @params	: string
	// @return	: array
	function _language()
	{
		// LOAD LANG FILE
		$set_lang = $this->session->userdata('set_lang');
		$this->lang->load("general", $set_lang);
		$this->lang->load("master_product", $set_lang);
	
		$lang['page_title'] = $this->lang->line("page_title");
		$lang['tabs_list'] = $this->lang->line("tabs_list");
		$lang['tabs_add'] = $this->lang->line("tabs_add");
		$lang['tabs_edit'] = $this->lang->line("tabs_edit");
		$lang['tabs_general'] = $this->lang->line("tabs_general");
		$lang['tabs_unit'] = $this->lang->line("tabs_unit");
		
		//GRID
		$lang['product_grid'] = $this->lang->line("product_grid");
		$lang['code'] = $this->lang->line("code");
		$lang['category'] = $this->lang->line("category");
		$lang['product'] = $this->lang->line("product");
		$lang['unit'] = $this->lang->line("unit");
		$lang['minstock'] = $this->lang->line("minstock");
		$lang['buying'] = $this->lang->line("buying");
		$lang['selling'] = $this->lang->line("selling");
		$lang['description'] = $this->lang->line("description");
		$lang['txt_search'] = $this->lang->line("txt_search");
		$lang['txt_clear'] = $this->lang->line("txt_clear");
		// FORM
		$lang['pro_code'] = $this->lang->line("pro_code");
		$lang['pro_name'] = $this->lang->line("pro_name");
		$lang['pro_form'] = $this->lang->line("pro_form");
		$lang['pro_det'] = $this->lang->line("pro_det");
		$lang['stock'] = $this->lang->line("stock");
		$lang['addunit'] = $this->lang->line("addunit");
		$lang['delunit'] = $this->lang->line("delunit");
		$lang['selunit'] = $this->lang->line("selunit");
		$lang['selcb'] = $this->lang->line("selcb");
		$lang['cabang'] = $this->lang->line("cabang");
		// INFO
		$lang['information'] = $this->lang->line("information");
		$lang['confirmation'] = $this->lang->line("confirmation");
		$lang['already'] = $this->lang->line("already");
		$lang['failed'] = $this->lang->line("failed");
		$lang['success'] = $this->lang->line("success");
		//BUTTON
		$lang['btn_ok'] = $this->lang->line("btn_ok");
		$lang['btn_add'] = $this->lang->line("btn_add");
		$lang['btn_save'] = $this->lang->line("btn_save");
		$lang['btn_edit'] = $this->lang->line("btn_edit");
		$lang['btn_update'] = $this->lang->line("btn_update");
		$lang['btn_delete'] = $this->lang->line("btn_delete");
		$lang['btn_cancel'] = $this->lang->line("btn_cancel");
		$lang['btn_clear'] = $this->lang->line("btn_clear");
		$lang['btn_search'] = $this->lang->line("btn_search");
		
		$this->get_lang = $lang;
		return $lang;
	}
	
	// @info	: Populate data json to grid
	// @access	: public
	// @params	: POST string
	// @params	: string	$kat_id
	// @return	: JSON array string
	public function get_data()
	{
		$SQL = "
			select
			mp.produk_id,mp.produk_kode,mp.produk_nama,mp.kat_id,mp.produk_min_stok,mp.satuan_id,mp.keterangan,
			
			(
				select concat(mk.kat_nama,' / ',mk1.kat_nama,' / ',mk2.kat_nama)
				from master_kategori as mk
				left join master_kategori as mk1 on mk1.kat_master = mk.kat_id
				left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id
				where mk2.kat_id = mp.kat_id
			) as kat_nama,
			
			sat.satuan_nama
			
			{COUNT_STR}
			from master_produk as mp
			inner join master_kategori as kk on kk.kat_id = mp.kat_id
			inner join master_satuan as sat on sat.satuan_id = mp.satuan_id
		";		
		
		$cb_id = $this->input->get_post('cb_id');
		if ($cb_id)
			$SQL .= " where mp.cb_id = $cb_id";
		
		$rs = $this->jqgrid_model->get_data_query($SQL,'mp.produk_id');
		echo json_encode($rs);
	}
	
	// @info	: Manipulate data from grid
	// @access	: public
	// @params	: POST string
	// @params	: string	$kat_id
	// @return	: JSON array string
	public function set_data()
	{
		$id_field = "produk_id";
		$table = "master_produk";	
		echo $this->jqgrid_model->set_data($table,$id_field);
	}
	
	function index() 
	{
		$data[''] = '';
		$this->load->view(self::$link_view."/produk_main_view",$data);
	}
	
	function daftar_produk() {	
		$data[''] = '';
		$this->load->view(self::$link_view."/produk_grid_view",$data);
	}
	
	function tabs_tambah_produk() {
		$data['status'] = "tambah";
		$this->load->view(self::$link_view."/produk_tabs_view",$data);
	}
	
	function tabs_edit_produk($produk_id) {
		$data['status'] = "edit";
		
		$where['produk_id'] = $produk_id;
		$join['master_satuan as sat'] = "sat.satuan_id = produk.satuan_id";
		$get_produk = $this->tbl_produk->data_produk(false,$where,false,$join);
		if ($get_produk->num_rows() > 0):
			$data_produk = $get_produk->row();
			$data['produk_status'] = $data_produk->status;
			
			$data['produk_id'] = $data_produk->produk_id;
			$data['produk_nama'] = $data_produk->produk_nama;
			$data['kat_id'] = $data_produk->kat_id;
			$data['cb_id'] = $data_produk->cb_id; // CABANG
			$data['split_kat_id'] = $this->lib_split->split_kategori($data_produk->kat_id,"kat_id");
			$data['split_kat_nama'] = $this->lib_split->split_kategori($data_produk->kat_id);
			$data['satuan_id'] = $data_produk->satuan_id;
			
			$data['produk_kode'] = $data_produk->produk_kode;
			$data['produk_min_stok'] = $data_produk->produk_min_stok;
			$data['keterangan'] = $data_produk->keterangan;
			
			$get_stok = $this->tbl_inventory->data_inventory($where);
			if ($get_stok->num_rows() > 0):
				$data['produk_stok'] = $get_stok->row()->inv_akhir;
				$data['produk_harga_beli'] = $get_stok->row()->inv_hrg_beli;
				$data['produk_harga_jual'] = $get_stok->row()->inv_hrg_jual;
			endif;
		endif;
		
		$data['list_produk_satuan'] = $this->tbl_produk_satuan->data_produk_satuan($where);
		
		$this->load->view(self::$link_view."/produk_tabs_view",$data);
	}
	
	function view_kategori($status,$kat_id = 'root') {
		$data["status"] = $status;
		if ($status == "edit") {
			if ($kat_id == 'root')
				$kat_id = 0;
			$where["kat_id"] = $kat_id;
			$where["kat_level"] = '1';
			$data['kat_list'] = $this->tbl_kategori->data_kategori($where);
		} 
		$this->load->view(self::$link_view.'/produk_form_view',$data);
	}
	
	function upload_produk() {
		$image = 'empty';
		$pro_code = $this->input->post('pro_code');
		$img_file = $this->imgupload->upload_this($pro_code,'./uploads/produk/');
		if ($img_file != false):
			$image = $img_file;
		endif;
		echo $image;
	}
	
	function update_stok($status,$produk_id) {
		$proses = false;
		
		$produk_stok = $this->input->post('produk_stok');
		$produk_harga_beli = $this->input->post('produk_harga_beli');
		$produk_harga_jual = $this->input->post('produk_harga_jual');
		
		// INVENTORY
		if ($status == "tambah"):
			// INSERT
			$data_inv['produk_id'] = $produk_id;
			$data_inv['inv_mulai'] = $produk_stok;
			$data_inv['inv_akhir'] = $produk_stok;
			$data_inv['inv_hrg_beli'] = $produk_harga_beli;
			$data_inv['inv_hrg_jual'] = $produk_harga_jual;
			$data_inv['inv_usr'] = $this->user_id;
			$data_inv['inv_dokumen'] = 'SETUP';
			if ($this->tbl_inventory->tambah_inventory($data_inv)):
				$inv_id = $this->db->insert_ID();
				$proses = true;
			endif;
		else:
			// UPDATE
			$where_inv['produk_id'] = $produk_id;			
			$data_inv['inv_mulai'] = $produk_stok;
			$data_inv['inv_akhir'] = $produk_stok;
			$data_inv['inv_hrg_beli'] = $produk_harga_beli;
			$data_inv['inv_hrg_jual'] = $produk_harga_jual;
			$data_inv['inv_usr'] = $this->user_id;
			$data_inv['inv_dokumen'] = 'SETUP';
			
			// CEK INVENTORY
			if($this->tbl_inventory->data_inventory($where_inv)->num_rows() > 0):
				if($this->tbl_inventory->ubah_inventory($where_inv,$data_inv)):
					$inv_id = $this->tbl_inventory->data_inventory($where_inv)->row()->inv_id;
					$proses = true;
				endif;
			else:
				$data_inv['produk_id'] = $produk_id;
				if ($this->tbl_inventory->tambah_inventory($data_inv)):
					$inv_id = $this->db->insert_ID();
					$proses = true;
				endif;
			endif;
		endif;
		
		// INVENTORY HISTORY
		if ($proses):
			// clear history
			$where_invhist['produk_id'] = $produk_id;	
			$this->tbl_inventory_history->hapus_inventory_history($where_invhist);
			// insert history
			$data_invhist['inv_id'] = $inv_id;
			$data_invhist['produk_id'] = $produk_id;
			$data_invhist['inv_mulai'] = $produk_stok;
			$data_invhist['inv_akhir'] = $produk_stok;
			$data_invhist['inv_hrg_beli'] = $produk_harga_beli;
			$data_invhist['inv_hrg_jual'] = $produk_harga_jual;
			$data_invhist['inv_usr'] = $this->user_id;
			$data_invhist['inv_dokumen'] = 'SETUP';
			if($this->tbl_inventory_history->tambah_inventory_history($data_invhist)):
				return true;
			endif;
		endif;
	}
	
	function tambah_produk() {
		$proses = false;	
		
		$produk_nama = strtoupper($this->input->post('produk_nama'));
		$produk_min_stok = $this->input->post('produk_min_stok');
		$keterangan = $this->input->post('keterangan');
		$kat_id = $this->input->post('kat_id');
		$kat_kode = $this->input->post('kat_kode');
		
		// CABANG
		$cb_id = $this->input->post('cb_id');
		$data['cb_id'] = $cb_id;
		
		// MULTI SATUAN
		$satuan_sub = $this->input->post('satuan_sub');
		
		$sql = "select max(produk_kode) as get_id from master_produk where produk_kode like '$kat_kode%'";
		
		$get_produk_no = $this->db->query($sql);
		
		$produk_no = 1;
		if ($get_produk_no->num_rows() > 0):
			if ($get_produk_no->row()->get_id != ''):
				$aproduk_no = explode('.',$get_produk_no->row()->get_id);
				$produk_no = $aproduk_no[3] + 1;
			endif;
		endif;
		
		$data['produk_kode'] = $kat_kode.'.'.str_pad($produk_no,3,0,STR_PAD_LEFT);
		$data['produk_tgl'] = date('Y-m-d H:i:s'); //date_format(date_create($delivery_date[$i]),'Y-m-d');
		$data['produk_nama'] = $produk_nama;
		$data['produk_min_stok'] = $produk_min_stok;
		$data['keterangan'] = $keterangan;
		
		$data['kat_id'] = $kat_id;
			
		//$data['pro_image'] = $this->input->post('gambar');
		
		// AKSES USER
		$data['user_akses'] = 1;
		
		$satuan = explode('_',$this->input->post('satuan_id'));
		$data['satuan_id'] = $satuan[0];
		
		$where['produk_nama'] = $produk_nama;
		$where['kat_id'] = $kat_id;
		
		$get_produk = $this->tbl_produk->data_produk(false,$where);
		if ($get_produk->num_rows() <= 0):
			if ($this->tbl_produk->tambah_produk($data)):
				$produk_id = $this->db->insert_ID();
				$this->produk_satuan($produk_id);
				$this->update_stok("tambah",$produk_id);
				$proses = 'sukses';
			endif;
		else:
			$proses = 'duplikasi';
		endif;
		
		echo $proses;
	}
	
	function edit_produk() {
		$proses = false;
		
		$produk_id = $this->input->post('produk_id');
		$produk_nama = strtoupper($this->input->post('produk_nama'));
		$produk_min_stok = $this->input->post('produk_min_stok');
		$keterangan = $this->input->post('keterangan');
		$kat_id = $this->input->post('kat_id');
		$kat_id_old = $this->input->post('kat_id_old');
		$kat_kode = $this->input->post('kat_kode');
		
		// CABANG
		$cb_id = $this->input->post('cb_id');
		$data['cb_id'] = $cb_id;
		
		// MULTI SATUAN
		$satuan_sub = $this->input->post('satuan_sub');
		
		$sql = "select max(produk_kode) as get_id from master_produk where produk_kode like '$kat_kode%'";
		
		$get_produk_no = $this->db->query($sql);
		
		$produk_no = 1;
		if ($get_produk_no->num_rows() > 0):
			if ($get_produk_no->row()->get_id != ''):
				$aproduk_no = explode('.',$get_produk_no->row()->get_id);
				$produk_no = $aproduk_no[3] + 1;
			endif;
		endif;
		
		if ($kat_id != $kat_id_old)
			$data['produk_kode'] = $kat_kode.'.'.str_pad($produk_no,3,0,STR_PAD_LEFT);
		$data['produk_tgl'] = date('Y-m-d H:i:s'); //date_format(date_create($delivery_date[$i]),'Y-m-d');
		$data['produk_nama'] = $produk_nama;
		$data['produk_min_stok'] = $produk_min_stok;
		$data['keterangan'] = $keterangan;
		$data['kat_id'] = $kat_id;
		
		$satuan = explode('_',$this->input->post('satuan_id'));
		$data['satuan_id'] = $satuan[0];
		
		$where['produk_id'] = $produk_id;
		
		if ($this->tbl_produk->ubah_produk($where,$data)):
			$this->produk_satuan($produk_id);
			
			// CEK STATUS PRODUK BELUM AKTIF
			$produk_status = $this->input->post('produk_status');
			if ($produk_status == 0)	
				$this->update_stok("ubah",$produk_id);
				
			$proses = 'sukses';
		endif;
		
		echo $proses;
	}
	
	function produk_satuan($produk_id=false) {	
		$return = false;
		$satuan_sub = $this->input->post('satuan_sub');
		$satuan_sub_val = $this->input->post('satuan_sub_val');
		
		if ($satuan_sub[0] != ''):
			$where['produk_id'] = $produk_id;
			$this->tbl_produk_satuan->hapus_produk_satuan($where);
			$data_sat['produk_id'] = $produk_id;
			$data_sat['satuan_id'] = $this->input->post('satuan_id');
			$data_sat['satuan_unit_id'] = $this->input->post('satuan_id');
			$data_sat['volume']	= 1;
			$this->tbl_produk_satuan->tambah_produk_satuan($data_sat);
			for ($i = 0; $i < sizeof($satuan_sub); $i++):
				if ($satuan_sub[$i]!='' && $satuan_sub_val[$i]!=''):
					$data_sat['produk_id'] = $produk_id;
					$satuan = explode('_',$this->input->post('satuan_id'));
					$data_sat['satuan_id'] = $satuan[0];
					$data_sat['satuan_unit_id'] = $satuan_sub[$i];
					$data_sat['volume']	= $satuan_sub_val[$i];	
					$this->tbl_produk_satuan->tambah_produk_satuan($data_sat);
					$return = true;
				endif;
			endfor;
		else:
			$where['produk_id'] = $produk_id;
			$this->tbl_produk_satuan->hapus_produk_satuan($where);	
		endif;
		
		//return $return;
	}
	
	function update_produk($stats) {
		$kat_id =  $this->input->post('kat_id');
		$kat_nama =  $this->input->post('value');
		$kat_nama = strtoupper($kat_nama);
		$this->tbl_kategori->ubah_kategori($kat_id, $kat_nama);
		echo "ok";
	}
	
	function cek_produk($produk_id) {
		$data = $this->tbl_produk->cek_produk($produk_id);
		if ($data > 0){
			echo "ada";
		}
	}
	
	function hapus_produk($produk_id){
		$where['produk_id'] = $produk_id;
		$this->tbl_produk->hapus_produk($where);
		$this->tbl_produk_satuan->hapus_produk_satuan($where);
		echo "ok";
	}
	
	function tree_kat_nama($kat_id) {
		echo $this->lib_split->split_kategori($kat_id);
	}
	
	function tree_kat_detail($kat_id,$kat_id_old=false) {
		$arr['kat_nama'] = $this->lib_split->split_kategori($kat_id);
		$arr['kat_kode'] = $this->lib_split->split_kategori($kat_id,"kat_kode");
		
		$like['produk_kode']= $arr['kat_kode'];
		$get_pro = $this->tbl_produk->data_produk(false,false,$like,false,'produk_kode','DESC');
		if ($get_pro->num_rows()>0):
			$no = 0;
			if ($kat_id != $kat_id_old)
				$no = 1;
			$pro_id = substr($get_pro->row()->produk_kode,9,3)+$no;
			$zero='';
			if(strlen($pro_id)>=1):
				$zero='00';	
			elseif (strlen($pro_id)==2):
				$zero='0';
			endif;
			$arr['produk_no'] = str_pad($pro_id,3,$zero,STR_PAD_LEFT);
		else:
			$arr['produk_no'] = "001";
		endif;
					
		echo json_encode($arr);
	}
	
	function list_autocomplate($kat_id=0) 
	{		
		$q = $this->input->get('q');
		
		$like['produk_nama']=$q;
			
		if ($kat_id != 0):
			$where['kat_id'] = $kat_id;
			$qres = $this->tbl_produk->data_produk(false,$where,$like);
		else:
			$qres = $this->tbl_produk->data_produk(false,false,$like);
		endif;
		
		if ($qres->num_rows() > 0):
			foreach ($qres->result() as $rows):
				if (strpos(strtolower($rows->produk_nama), strtolower($q)) !== false):
					echo "$rows->produk_nama|$rows->produk_id\n";
				endif;
			endforeach;
		endif;	
	}
	
}

/* End of file master_kategori.php */
/* Location: ./app/controllers/mod_master/master_kategori.php */