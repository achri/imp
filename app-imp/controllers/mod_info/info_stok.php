<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	03/04/2011
 @model
	- 
 @view
	- 
 @library
    - JS
    - PHP
 @comment
	- 
	
*/

class Info_stok extends IMP_Controller {
	public static $link_view, $link_controller;
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
		$this->load->helper(array());
		$this->load->library(array());
		$this->load->model(array());

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
		);
		
		$arrayJS = array (
		//'asset/src/jQuery/core/jquery-1.5.1.js',
		//'asset/src/jQuery/ui/jquery-ui-1.8.11.custom.js',
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
		$content .= "";
		
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
		self::$link_controller = 'mod_info/info_stok';
		self::$link_view = 'mod_info/info_stok';
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
		$output['page_title'] = content_title("STOCK INFORMATION",$path_themes);
		
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
		return $output;
	}
	
	// INDEX
	function index()
	{
	
	}
	
	function cek_stok() {
		$SQL = "select 
		pro.produk_kode, pro.produk_nama,
		pro.produk_min_stok, 
		stok.inv_akhir, 
		
		if(((stok.inv_akhir - pro.produk_min_stok) <= pro.produk_min_stok),0,1) as info 
			
		from master_produk as pro 
		inner join inventory_stok as stok on stok.produk_id = pro.produk_id
		where pro.produk_min_stok != 0 and (stok.inv_akhir - pro.produk_min_stok) <= pro.produk_min_stok
		";
		
		$get_stok = $this->db->query($SQL);
		if ($get_stok->num_rows() > 0):
			$output['list_stok'] = $get_stok;
			$this->load->view(self::$link_view.'/stok_min_view',$output);
		endif;
	}
}

/* End of file info_stok.php */
/* Location: ./app/controllers/mod_info/info_stok.php */