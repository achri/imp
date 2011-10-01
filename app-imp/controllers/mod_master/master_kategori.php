<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	13/12/2010
 @model
	- dynatree_model
	- tbl_kategori
 @view
	- main_view
	- kategori_list_view
	- kategori_form_view
	- kategori_add_view
 @library
    - JS
		- dynatree
		- jquery.form
    - PHP
 @comment
	- 
	
*/

class Master_kategori extends IMP_Controller {
	public static $link_view, $link_controller, $link_controller_kategori, $link_controller_kelas, $link_controller_grup;
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
		$this->load->library(array("dynatree","jqcontent"));
		$this->load->model(array(
			"dynatree_model","jqgrid_model",
			"tbl_kategori","tbl_kelas","tbl_grup","tbl_produk"
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
		//'asset/src/jQuery/themes/ui-darkness/jquery.ui.all.css',
		
		//"asset/src/jQuery/plugins/tree/dynatree/skin-vista/ui.dynatree.css",
		'asset/src/jQuery/plugins/tables/jquery.jqGrid/css/ui.jqgrid.css',
		'asset/src/jQuery/plugins/tables/datagrid/datagrid.css',
		'asset/css/jqgrid.patch.css',
		);
		
		$arrayJS = array (
		//'asset/src/jQuery/core/jquery-1.5.1.js',
		//'asset/src/jQuery/ui/jquery-ui-1.8.11.custom.js',
			
		'asset/src/jQuery/plugins/tables/jquery.jqGrid/src/i18n/grid.locale-en.js',
		'asset/src/jQuery/plugins/tables/jquery.jqGrid/js/jquery.jqGrid.min.js',
		'asset/src/jQuery/plugins/tables/datagrid/datagrid.js',
		'asset/src/jQuery/plugins/form/jquery.form.js',
		'asset/src/jQuery/plugins/form/jquery.jeditable.js',
		'asset/src/jQuery/plugins/jquery.cookie.js',
		//'asset/src/jQuery/plugins/tree/dynatree/jquery.dynatree.js',
		'asset/src/jQuery/general/tabs.js',
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
		self::$link_controller = 'mod_master/master_kategori';
		self::$link_controller_kategori = 'mod_master/master_kategori';
		self::$link_controller_kelas = 'mod_master/master_kelas';
		self::$link_controller_grup = 'mod_master/master_grup';
		self::$link_view = 'mod_master/master_kategori';
		$output['link_view'] = self::$link_view;
		$output['link_controller'] = self::$link_controller;
		$output['link_controller_kategori'] = self::$link_controller_kategori;
		$output['link_controller_kelas'] = self::$link_controller_kelas;
		$output['link_controller_grup'] = self::$link_controller_grup;	
		
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
		$this->lang->load("master_category", $set_lang);
	
		$lang['page_title'] = $this->lang->line("page_title");
		
		$lang['category_grid'] = $this->lang->line("category_grid");
		$lang['class_grid'] = $this->lang->line("class_grid");
		$lang['group_grid'] = $this->lang->line("group_grid");
		$lang['of_grid'] = $this->lang->line("of_grid");
		
		$lang['category_sel'] = $this->lang->line("category_sel");
		$lang['class_sel'] = $this->lang->line("class_sel");
		
		$lang['class_use'] = $this->lang->line("class_use");
		$lang['group_use'] = $this->lang->line("group_use");
		$lang['product_use'] = $this->lang->line("product_use");
		
		$lang['code'] = $this->lang->line("code");
		$lang['category'] = $this->lang->line("category");
		$lang['class'] = $this->lang->line("class");
		$lang['group'] = $this->lang->line("group");
		
		$this->get_lang = $lang;
		return $lang;
	}
	
	function jqGrid_ajax($status="kategori")
	{
		$this->load->library('datagrid');
		$grid  = $this->datagrid;
		
		$id['search'] = 'false';
		$id['hidden'] = 'true';
		$id['key'] = 'true';
		$grid->addField('kat_id');
		$grid->label('id');
		$grid->params($id);
		
		$kode['width'] = 50;
		$kode['sortable'] = 'true';
		$grid->addField('kat_kode');
		$grid->label($this->get_lang['code']);
		$grid->params($kode);
			
		$nama['width'] = 300;
		$nama['editable'] = 'true';
		$nama['sortable'] = 'true';
		$nama['edittype'] = "'text'";
		$nama['editrules'] = '{required:true}';
		$grid->addField('kat_nama');
		$grid->params($nama);
		
		switch ($status):
			case "kategori" : 
				$grid->label($this->get_lang['category']);
				#table title
				$grid->setTitle($this->get_lang['category_grid']);
				$grid->setgridName('kategori');
				//$grid->setHiddenGrid('true');
			break;
			case "kelas" : 
				$grid->label($this->get_lang['class']);
				#table title
				$grid->setTitle($this->get_lang['class_grid']);
				$grid->setgridName('kelas');
				//$grid->setHiddenGrid('true');
			break;
			case "grup" : 
				$grid->label($this->get_lang['group']);
				#table title
				$grid->setTitle($this->get_lang['group_grid']);
				$grid->setgridName('grup');
				//$grid->setHiddenGrid('true');
			break;
		endswitch;
		
		$grid->dnd('#newapi_kategori,#newapi_kelas');
		
		#show paginator
		$grid->showpager(true);
		$grid->showsearch(true);

		#width
		//$grid->setWidth('670');
            
		#height
		//$grid->setHeight('150');

		#show/hide navigations buttons
		$grid->setAdd(true);
		//$grid->setEdit(false);
		$grid->setDelete(true);
		
		//$grid->setView(true);
		//$grid->setSearch(false);
		$grid->setRefresh(false);

		$grid->setRowNum(5);
		
		$grid->setRowList('5,10,20,50');

		#export buttons
		//$grid->setExcel(false);
		//$grid->setPdf(true,array('title' => 'Unit Measure'));
		
		#GET url
		$grid->setUrlget(site_url(self::$link_controller.'/get_data'));

		#Set url
		$grid->setUrlput(site_url(self::$link_controller.'/set_data'));

		return $grid->deploy();
	}
	
	// @info	: Populate data json to grid
	// @access	: public
	// @params	: POST string
	// @params	: string	$kat_id
	// @return	: JSON array string
	public function get_data($kat_id = FALSE)
	{
		$kat_level = $this->input->get_post('kat_level');
		
		$where['kat_level'] = $kat_level;
		
		$table = "master_kategori";		
		if (FALSE === $kat_id):
			if ($kat_level > 1):
				$rs = $this->jqgrid_model->get_data($table,FALSE,array('kat_level'=>99));
			else:
				$rs = $this->jqgrid_model->get_data($table,FALSE,$where);
			endif;
		else:
			$where['kat_master'] = $kat_id;
			$rs = $this->jqgrid_model->get_data($table,FALSE,$where);
		endif;
			
		echo json_encode($rs);
	}
	
	// @info	: Manipulate data from grid
	// @access	: public
	// @params	: POST string
	// @params	: string	$kat_id
	// @return	: JSON array string
	public function set_data()
	{
		$id_field = "kat_id";
		$table = "master_kategori";	
		echo $this->jqgrid_model->set_data($table,$id_field);
	}
	
	// @info	: Indexing Layout
	// @access	: public
	// @params	: null
	// @return	: [object]
	function index() {
		$data['kategori_grid'] = $this->jqGrid_ajax("kategori");
		$data['kelas_grid'] = $this->jqGrid_ajax("kelas");
		$data['grup_grid'] = $this->jqGrid_ajax("grup");
		$this->load->view(self::$link_view."/kategori_main_view",$data);
	}
	
	function set_kat_kode($status,$kat_master=FALSE) {
		$set_kode = 0;
		switch ($status):
			case 'kategori':
				$numcode = $this->tbl_kategori->nomor_kategori($kat_master);
				$numcode++;
				$set_kode = str_pad($numcode, 2, "0", STR_PAD_LEFT);
			break;
			case 'kelas':
				$where['kat_id'] = $kat_master;
				$kat_kode= $this->tbl_kelas->data_kelas($where)->row()->kat_kode;
				$numcode = $this->tbl_kelas->nomor_kelas($kat_master);
				$numcode = substr($numcode,3,2);
				if ($numcode == 0)
					$numcode = 0;
				$numcode++;
				
				$numcode = str_pad($numcode, 2, "0", STR_PAD_LEFT);
				$set_kode = $kat_kode.'.'.$numcode;
			break;
			case 'grup':
				$where['kat_id'] = $kat_master;
				$kat_kode= $this->tbl_grup->data_grup($where)->row()->kat_kode;
				$numcode = $this->tbl_grup->nomor_grup($kat_master);
				$numcode = substr($numcode,6,2);
				if ($numcode == 0)
					$numcode = 0;
				$numcode++;
				
				$numcode = str_pad($numcode, 2, "0", STR_PAD_LEFT);
				$set_kode = $kat_kode.'.'.$numcode;
			break;
		endswitch;
		
		echo $set_kode;
	}
	
	function cek_hapus_kategori($status,$kat_master=FALSE) {
		switch ($status):
			case 'kategori':
				$where['kat_master'] = $kat_master;
				$get_kelas = $this->tbl_kelas->data_kelas($where);
				if ($get_kelas->num_rows() > 0)
					echo 'terpakai';
			break;
			case 'kelas':
				$where['kat_master'] = $kat_master;
				$get_grup = $this->tbl_grup->data_grup($where);
				if ($get_grup->num_rows() > 0)
					echo 'terpakai';
			break;
			case 'grup':
				$where['kat_id'] = $kat_master;
				$get_produk= $this->tbl_produk->data_produk(false,$where);
				if ($get_produk->num_rows() > 0)
					echo 'terpakai';
			break;
		endswitch;	
	}
	
	function dynatree_lazy() {
		$kat_id = $this->input->get('key',0);
		$kat_jenis = $this->input->get('jenis','kategori');
		if ($kat_jenis == 'kat'):
			$arr_katjen = array('1');
		elseif ($kat_jenis == 'all'):
			$arr_katjen = array('1','2','3');
		else:
			$arr_katjen = array('1','2');
		endif;
		echo $this->dynatree->generate_kategori_tree($kat_id,$arr_katjen);
	}
	
	function get_last_id() {
		$this->db->order_by('kat_id','DESC');
		$get = $this->db->get('master_kategori');
		if ($get->num_rows() > 0):
			echo $get->row()->kat_id;
		endif;
	}

}

/* End of file master_kategori.php */
/* Location: ./app/controllers/mod_master/master_kategori.php */