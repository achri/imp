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
	- CETAK REKAP BELUM
	
*/

class Laporan_jual extends IMP_Controller {
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
			"jqgrid_export","lib_split",
		));
		$this->load->model(array(
			"jqgrid_model","tbl_kategori",
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
		
		/* ADDITIONAL JS PLUGINS */
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
		self::$link_controller = 'mod_laporan/laporan_jual';
		self::$link_view = 'mod_laporan/laporan_jual';
		$output['link_view'] = self::$link_view;
		$output['link_controller'] = self::$link_controller;
		
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
		$output['page_title'] = content_title("SELLING REPORT",$path_themes);
		
		$output['arrArt'] = $this->config->item('arrDivArt');
		
		return $output;
	}
	
	// @info	: Load data in database on init
	// @access	: private
	// @params	: null
	// @return	: array
	function _data_init()
	{
		$output[''] = '';
		
		// SESSION FOR QUERY DATAGRID FROM JQGRID SQL
		//$output['dtgQuery'] = $this->session->userdata('dtgQuery');
		
		return $output;
	}
	
	function set_sql($type="jual",$jual_id=FALSE)
	{
		switch ($type):
			case "jual":
			$SQL = "
				select tb.jual_id,tb.jual_tgl,tb.jual_no,tb.jual_tot_jml,tb.jual_tot_hrg,tb.jual_tot_bayar,mjt.jenis_transaksi,su.usr_nama {COUNT_STR} 
				from trans_jual as tb 
				inner join sys_user as su on su.usr_id = tb.jual_user and tb.jual_status != 0
				inner join master_jenis_trans as mjt on mjt.trans_jenis_id = tb.trans_jenis_id
			";	
			break;
			
			case "jual_detail":
			$SQL = "
				select mp.kat_id,mp.produk_kode,mp.produk_nama,tb.jumlah,tb.jumlah_multi,tb.harga,tb.tot_harga,tb.diskon,tb.tot_diskon,
				(select satuan_nama from master_satuan where satuan_id = tb.satuan_id) as reqsat,
				(select satuan_nama from master_satuan where satuan_id = mp.satuan_id) as prosat,
				
				(select sum(jumlah) from trans_jual_detail where jual_id = tb.jual_id)as udata_jumlah,
				(select sum(harga) from trans_jual_detail where jual_id = tb.jual_id)as udata_harga,
				(select sum(tot_harga) from trans_jual_detail where jual_id = tb.jual_id)as udata_tot_harga
				
				{COUNT_STR} 
				from trans_jual_detail as tb
				left join master_produk_satuan as mps on mps.produk_id = tb.produk_id and mps.satuan_unit_id = tb.satuan_id
				inner join master_produk as mp on mp.produk_id = tb.produk_id
				inner join trans_jual as tbs on tbs.jual_id = tb.jual_id
				where tb.jual_id = $jual_id and tbs.jual_status != 0
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
	public function get_data($grid = 'trans',$jual_id = false)
	{
		//$user_id = $this->session->userdata('usr_id');
		if ($grid == 'trans'):
			$rs = $this->jqgrid_model->get_data_query($this->set_sql('jual'),'tb.jual_id');
		else:
			$summary['jumlah'] = 'udata_jumlah';
			$summary['harga'] = 'udata_harga';
			$summary['tot_harga'] = 'udata_tot_harga';
			$rs = $this->jqgrid_model->get_data_query($this->set_sql('jual_detail',$jual_id),'tb.produk_id',TRUE,TRUE,$summary);
		endif;	
		
		if ($grid != 'trans'):
			$get_data = $rs['raw_data'];
			if ($get_data->num_rows() > 0):
				foreach ($get_data->result_array() as $records=>$rows):
					$row_data['kat_nama'] = $this->lib_split->split_kategori($rows['kat_id']);
					foreach ($rows as $field=>$value):
						$row_data[$field] = $value;
					endforeach;
					$set_data[] = $row_data;
				endforeach;
				// ARRAY DATA RESULT 
				if (sizeOf($set_data) > 0):
					$rs['data'] = $set_data;
				else:
					$rs['data'] = $get_data;
				endif;
			endif;
			unset($rs['raw_data']);
		endif;
		
		echo json_encode($rs);
	}
	
	function index() 
	{
		$data[''] = '';
		$this->load->view(self::$link_view."/jual_main_view",$data);
	}
	
	function cetak_session($grid='detail',$jual_id=FALSE)
	{
		switch($grid):
			case 'detail':
				$this->session->unset_userdata('qjual_detail_'.$jual_id);
				$get_last = $this->session->userdata('dtgQuery');
				$this->session->set_userdata('qjual_detail_'.$jual_id,$get_last);
			break;
			default:
				$this->session->unset_userdata('qbeli');
				$get_last = $this->session->userdata('dtgQuery');
				$this->session->set_userdata('qbeli',$get_last);
			break;
		endswitch;
	}
	
	function cetak()
	{
		$SSes_jual = $this->session->userdata('qbeli');		
		$output['data_jual'] = $this->db->query($SSes_jual);
		$this->load->view(self::$link_view.'/jual_print_view',$output);
	}
	
	function cetak_detail($jual_id,$type='query')
	{
		if ($type == 'query'):
			$SSes_jual = $this->session->userdata('qbeli');
			$SSes_jual_detail = $this->session->userdata('qjual_detail_'.$jual_id);
		else:
			$SSes_jual = str_replace("{COUNT_STR}"," ",$this->set_sql('jual'));
			$SSes_jual_detail = str_replace("{COUNT_STR}"," ",$this->set_sql('jual_detail',$jual_id));
		endif;
		$output['data_jual'] = $this->db->query($SSes_jual);		
		$output['data_jual_detail'] = $this->db->query($SSes_jual_detail);
		$this->load->view(self::$link_view.'/jual_print_detail_view',$output);
	}
	
}

/* End of file master_kategori.php */
/* Location: ./app/controllers/mod_master/master_kategori.php */