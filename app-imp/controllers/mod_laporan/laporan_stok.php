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

class Laporan_stok extends IMP_Controller {
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
			//"flexigrid","flexi_engine"
		));
		$this->load->model(array(
			"jqgrid_model","tbl_produk","tbl_produk_satuan",
			"tbl_inventory","tbl_inventory_history",
			"tbl_kategori","tbl_satuan",//"flexi_model","metadata"
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
		//'asset/src/jQuery/themes/ui-darkness/jquery.ui.all.css',
		
		'asset/src/jQuery/plugins/tables/jquery.jqGrid/css/ui.jqgrid.css',
		'asset/src/jQuery/plugins/tables/datagrid/datagrid.css',
		'asset/src/jQuery/plugins/form/autocomplete/jquery.autocomplete.css',
		
		'asset/src/jQuery/plugins/tree/dynatree/skin-vista/ui.dynatree.css',
		//"asset/src/jQuery/plugins/tables/flexigrid/css/flexigrid.css",
		
		/* ADDITIONAL CSS PLUGINS */
		//'asset/css/jqgrid.patch.css',
		);
		
		$arrayJS = array (
		//'asset/src/jQuery/core/jquery-1.5.1.js',
		//'asset/src/jQuery/ui/jquery-ui-1.8.11.custom.js',
		
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
		self::$link_controller = 'mod_laporan/laporan_stok';
		self::$link_controller_kategori = 'mod_master/master_kategori';
		self::$link_view = 'mod_laporan/laporan_stok';
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
		$output['page_title'] = content_title("INVENTORY STOCK REPORT",$path_themes);
		
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
		
		return $output;
	}
	
	function set_sql($type="inventory",$produk_id=FALSE)
	{
		switch ($type):
			case 'inventory':
				$SQL = "
					select
					mp.produk_id,mp.produk_kode,mp.produk_nama,mp.kat_id,mp.produk_min_stok,
					inv.inv_tgl,
					inv.inv_akhir,
					inv.inv_hrg_beli,
					inv.inv_hrg_jual,
					sat.satuan_nama,
					(
						select concat(mk.kat_nama,' / ',mk1.kat_nama,' / ',mk2.kat_nama)
						from master_kategori as mk
						left join master_kategori as mk1 on mk1.kat_master = mk.kat_id
						left join master_kategori as mk2 on mk2.kat_master = mk1.kat_id
						where mk2.kat_id = kk.kat_id
					) as kat_nama,
					
					(
					case
						when inv.inv_akhir=0 then 0
						when inv.inv_dokumen LIKE '%PR%' then 1
						when inv.inv_dokumen LIKE '%SL%' then 2
						when inv.inv_dokumen = 'SETUP' or inv.inv_akhir!=0 then 3
					end
					) as status_item,
					
					(select sum(inv_hrg_beli) from inventory_stok) as udata_inv_hrg_beli,
					(select sum(inv_hrg_jual) from inventory_stok) as udata_inv_hrg_jual
					
					{COUNT_STR}
					from master_produk as mp
					left join inventory_stok as inv on inv.produk_id = mp.produk_id
					inner join master_kategori as kk on kk.kat_id = mp.kat_id
					inner join master_satuan as sat on sat.satuan_id = mp.satuan_id
				";	
			break;
			case 'inv_history':
				$SQL = "
					select
					inv_hist.inv_id,inv_hist.inv_tgl,inv_hist.inv_mulai,inv_hist.inv_masuk,inv_hist.inv_keluar,inv_hist.inv_akhir,inv_hist.inv_hrg_beli,inv_hist.inv_hrg_jual,inv_hist.inv_dokumen,
					su.usr_nama
					{COUNT_STR}
					from inventory_stok_history as inv_hist
					inner join sys_user as su on su.usr_id = inv_hist.inv_usr
					where inv_hist.produk_id = $produk_id
				";	
			break;
		endswitch;
		return $SQL;
	}
		
	
	// @info	: Populate data json to grid
	// @access	: public
	// @params	: POST string
	// @params	: string	$kat_id
	// @return	: JSON array string
	public function get_data($gridType='inventory',$produk_id = FALSE)
	{
		//$produk_id = $this->input->get_post('produk_id');
		if(!$produk_id)
			$produk_id = 0;
			
		switch($gridType):
			case 'inventory':
				// FOOTER SUMMARY FIELD
				$summary['inv_hrg_beli'] = 'udata_inv_hrg_beli';
				$summary['inv_hrg_jual'] = 'udata_inv_hrg_jual';
				
				//$rs = $this->jqgrid_model->get_data_query($SQL,'mp.produk_id');
				$rs = $this->jqgrid_model->get_data_query($this->set_sql('inventory'),'mp.produk_id',TRUE,FALSE,$summary);
			break;
			
			case 'inv_history':
				$rs = $this->jqgrid_model->get_data_query($this->set_sql('inv_history',$produk_id),'inv_hist.inv_id');
			break;
		endswitch;
		echo json_encode($rs);
	}
	
	function index() 
	{
		$data[] = "";
		$this->load->view(self::$link_view."/stok_main_view",$data);
	}
	
	function daftar_gudang() {	
		$data[''] = '';
		$this->load->view(self::$link_view."/stok_inv_main_view",$data);
	}
	
	function cetak_session($grid='inventory',$produk_id=FALSE)
	{
		switch($grid):
			case 'inv_history':
				$this->session->unset_userdata('qinv_history_'.$produk_id);
				$get_last = $this->session->userdata('dtgQuery');
				$this->session->set_userdata('qinv_history_'.$produk_id,$get_last);
			break;
			default:
				$this->session->unset_userdata('qinventory');
				$get_last = $this->session->userdata('dtgQuery');
				$this->session->set_userdata('qinventory',$get_last);
			break;
		endswitch;
	}
	
	function cetak()
	{
		$SSes_inventory = $this->session->userdata('qinventory');		
		$output['data_inventory'] = $this->db->query($SSes_inventory);
		$this->load->view(self::$link_view.'/stok_print_view',$output);
	}
	
	function cetak_detail($produk_id,$type='query')
	{
		if ($type == 'query'):
			$SSes_inventory = $this->session->userdata('qinventory');
			$SSes_inv_history = $this->session->userdata('qinv_history_'.$produk_id);
		else:
			$SSes_inventory = str_replace("{COUNT_STR}"," ",$this->set_sql('inventory'));
			$SSes_inv_history = str_replace("{COUNT_STR}"," ",$this->set_sql('inv_history',$produk_id));
		endif;
		$output['data_inventory'] = $this->db->query($SSes_inventory);		
		$output['data_inv_history'] = $this->db->query($SSes_inv_history);
		$this->load->view(self::$link_view.'/stok_print_detail_view',$output);
	}
	
}

/* End of file master_kategori.php */
/* Location: ./app/controllers/mod_master/master_kategori.php */