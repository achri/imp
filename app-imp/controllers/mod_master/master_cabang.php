<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	22/03/2011
 @model
	- 
 @view
	- 
 @library
    - JS		
    - PHP
 @comment
	- Class Master Unit
*/

class Master_cabang extends IMP_Controller {
	// public variable
	public static $link_controller, $link_view;
	private $get_lang;
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
		$output += $this->_language();
		
		$this->load->vars($output);
		
		log_message('debug', "IMP -> Class $class init success");
	}
	
	// @info	: Loader class model,helper,config,library
	// @params	: null
	// @return	: null
	function _loader_class()
	{
		$this->load->library('datagrid');
		$this->load->model(array("jqgrid_model"));	
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
		'asset/css/jqgrid.patch.css',
		);
		
		$arrayJS = array (
		'asset/src/jQuery/plugins/tables/jquery.jqGrid/src/i18n/grid.locale-en.js',
		'asset/src/jQuery/plugins/tables/jquery.jqGrid/js/jquery.jqGrid.min.js',
		'asset/src/jQuery/plugins/tables/datagrid/datagrid.js',
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
		self::$link_controller = 'mod_master/master_cabang';
		self::$link_view = 'mod_master/master_cabang';
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
		$output['path_themes'] = $path_themes;
		
		$output['arrArt'] = $this->config->item('arrDivArt');
		
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
		$this->lang->load("master_cabang", $set_lang);
	
		$lang['page_title'] = $this->lang->line("page_title");
		
		$lang['cabang_grid'] = $this->lang->line("cabang_grid");
		$lang['cabang'] = $this->lang->line("cabang");
		$lang['address'] = $this->lang->line("address");
		$lang['telphone'] = $this->lang->line("telphone");
		
		$this->get_lang = $lang;
		return $lang;
	}
	
	function jqgrid_ajax()
	{
		$grid  = $this->datagrid;
		
		$sat_id['hidden'] = 'true';
		$sat_id['key'] = 'true';
		$grid->addField('cb_id');
		$grid->label('ID');
		$grid->params($sat_id);
		
		$nama['width'] = 200;
		$nama['editable'] = 'true';
		$nama['sortable'] = 'true';
		$nama['edittype'] = "'text'";
		$nama['editrules'] = '{required:true}';
		$grid->addField('cb_nama');
		$grid->label($this->get_lang['cabang']);
		$grid->params($nama);
		
		$address['width'] = 300;
		$address['editable'] = 'true';
		$address['sortable'] = 'true';
		$address['edittype'] = "'text'";
		$grid->addField('cb_alamat');
		$grid->label($this->get_lang['address']);
		$grid->params($address);
		
		$telp['width'] = 200;
		$telp['editable'] = 'true';
		$telp['sortable'] = 'true';
		$telp['edittype'] = "'text'";
		//$telp['editrules'] = '{required:true}';
		$grid->addField('cb_telp');
		$grid->label($this->get_lang['telphone']);
		$grid->params($telp);
		
		#show paginator
		$grid->showpager(true);

		#width
		//$grid->setWidth('670');
            
		#height
		//$grid->setHeight('200');
         
		#table title
		$grid->setTitle($this->get_lang['cabang_grid']);

		#show/hide navigations buttons
		$grid->setAdd(true);
		//$grid->setEdit(false);
		$grid->setDelete(true);
		
		//$grid->setView(true);
		$grid->setSearch(true);

		$grid->setRowNum(10);
		
		$grid->setRowList('5,10,20,50');

		#export buttons
		$grid->setPdf(true,array('title' => 'cabang'));

		#GET url
		$grid->setUrlget(site_url(self::$link_controller.'/get_data'));

		#Set url
		$grid->setUrlput(site_url(self::$link_controller.'/set_data'));

		return $grid->deploy();
	}
	
	function get_data()
	{
		$table = "master_cabang";		
		echo json_encode($this->jqgrid_model->get_data($table));
	}
   
	function set_data()
	{
		$id_field = "cb_id";
		$table = "master_cabang";	
		$this->jqgrid_model->set_data($table,$id_field);
	}
	
	// @info	: Indexing Layout
	// @access	: public
	// @params	: null
	// @return	: [object]
	function index() {
		$data['grid'] = $this->jqgrid_ajax();
		$this->load->view(self::$link_view."/cabang_main_view",$data);
	}
	
}

/* End of file app_init.php */
/* Location: ./app-imp/controllers/app_init.php */