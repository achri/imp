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
	- Class First Loader
*/

class Master_user extends IMP_Controller {
	// public variable
	public static $link_controller, $link_view;
	private $layout,$arrAkses,$arrAdmin;
	
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
		
		log_message('debug', "Class $class init success");
	}
	
	// @info	: Loader class model,helper,config,library
	// @params	: null
	// @return	: null
	function _loader_class()
	{
		$this->load->library(array(
			"lib_menu",
		));
		$this->load->model(array(
			"metadata","jqgrid_model",
			"tbl_user",
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
			'asset/src/jQuery/plugins/tables/jquery.jqGrid/css/ui.jqgrid.css',
			'asset/src/jQuery/plugins/tree/dynatree/skin-vista/ui.dynatree.css',
		);
		
		$arrayJS = array (
			'asset/src/jQuery/plugins/tree/dynatree/jquery.dynatree.js',
			'asset/src/jQuery/plugins/tables/jquery.jqGrid/src/i18n/grid.locale-en.js',
			'asset/src/jQuery/plugins/tables/jquery.jqGrid/js/jquery.jqGrid.min.js',
			'asset/src/jQuery/plugins/form/jquery.form.js',
			'asset/src/jQuery/plugins/form/ajaxupload/ajaxupload.js',
			'asset/src/jQuery/plugins/content/jquery.blockui.js',
			
			'asset/src/jQuery/helper/validasi.js',
			'asset/src/jQuery/helper/dialog.js',
		);
				
		if (is_array($arrayCSS))
		foreach ($arrayCSS as $css):
			$content .= "<link type=\"text/css\" rel=\"stylesheet\" href=\"".base_url().$css."\"/>\n";
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
		self::$link_controller = 'mod_master/master_user';
		self::$link_view = 'mod_master/master_user';
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
		
		//$output['list_wewenang'] = $this->lib_menu->get_wewenang();
		
		$this->arrAkses = $this->config->item('arrAkses');
		$this->arrAdmin = $this->config->item('arrAdmin');
		
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
		$this->lang->load("master_user", $set_lang);
	
		$lang['page_title'] = $this->lang->line("page_title");
		
		$lang['user_exist'] = $this->lang->line("user_exist");
		$lang['user_delete'] = $this->lang->line("user_delete");
		$lang['user_grid'] = $this->lang->line("user_grid");
		$lang['user_id'] = $this->lang->line("user_id");
		$lang['user_name'] = $this->lang->line("user_name");
		$lang['user_access'] = $this->lang->line("user_access");
		$lang['user_form'] = $this->lang->line("user_form");
		$lang['user_maccess'] = $this->lang->line("user_maccess");
		$lang['user_npwd'] = $this->lang->line("user_npwd");
		$lang['user_pwd1'] = $this->lang->line("user_pwd1");
		$lang['user_pwd2'] = $this->lang->line("user_pwd2");
		
		// GENERAL
		$lang['btn_add'] = $this->lang->line("btn_add");
		$lang['btn_save'] = $this->lang->line("btn_save");
		$lang['btn_edit'] = $this->lang->line("btn_edit");
		$lang['btn_update'] = $this->lang->line("btn_update");
		$lang['btn_delete'] = $this->lang->line("btn_delete");
		$lang['btn_cancel'] = $this->lang->line("btn_cancel");
		$lang['btn_clear'] = $this->lang->line("btn_clear");
		
		return $lang;
	}
	
	// @info	: Indexing Layout Default
	// @access	: public
	// @params	: null
	// @return	: [object]
	function index()
	{
		$output[''] = '';
		$this->load->view(self::$link_view.'/user_main_view',$output);
	}
	
	function get_data()
	{
		$SQL = "select * {COUNT_STR} from sys_user where ucat_id != 99 and login_status = 1";	
				
		$rs = $this->jqgrid_model->get_data_query($SQL,'usr_id');	
		echo json_encode($rs);
	}
	
	function get_user_menu($usr_id)
	{
		$set_menu = '';
		$get_menu = array();
		
		$where['usr_id'] = $usr_id;
		$get_data = $this->tbl_user->data_user_menu($where);
		if ($get_data->num_rows() > 0):
			foreach ($get_data->result() as $row)
				$get_menu[] = $row->menu_id;
			$set_menu = implode(',',$get_menu);
		endif;
		
		echo $set_menu;
	}
	
	function get_menu_tree($usr_id = '', $ucat_id = '')
	{
		$data['usrid'] = $usr_id;
		$data['ucatid'] = $ucat_id;
		$this->load->view(self::$link_view.'/user_tree_view',$data);
	}
	
	function user_menu($usr_id,$menu)
	{
		$where['usr_id'] = $usr_id;
		$this->tbl_user->hapus_user_menu($where);
		$set_menu = explode(',',$menu);
		foreach ($set_menu as $menu_id):
			$data['usr_id'] = $usr_id;
			$data['menu_id'] = $menu_id;
			$this->tbl_user->tambah_user_menu($data);
		endforeach;
	}
	
	function tambah_user()
	{		
		$cek_user = array();
		
		// METADATA FIELDs TABLE
		$get_field = $this->metadata->list_field('sys_user');
		foreach ($_POST as $name=>$value):
			$value = trim($value);
			// SYNC POSTs AND FIELDs
			if ($value != '' && in_array($name,$get_field)):
				switch ($name):
					case "usr_login": 
						$data[$name] = strtolower($value); 
						$cek_user[$name] = $value; 
					break;
					case "usr_pwd1" : $data[$name] = md5($value); break;
					case "usr_pwd2" : $data[$name] = md5($value); break;
					default: $data[$name] = $value; break;
				endswitch;
			endif;
		endforeach;
		
		// CEK DUPLIKASI
		foreach ($cek_user as $sel=>$val):
			$this->db->where($sel,$val);
		endforeach;
		
		if ($this->db->get('sys_user')->num_rows() <= 0):
			if ($this->tbl_user->tambah_user($data)):
				$usr_id = $this->db->insert_ID();
				$set_menu = $this->input->post('menu');
				$ucat_id = $this->input->post('ucat_id');
				
				if ($ucat_id != 1)
					$this->user_menu($usr_id,$set_menu);
					
				echo "sukses";
			endif;
		endif;
	}
	
	function ubah_user()
	{
		// METADATA FIELDs TABLE
		$get_field = $this->metadata->list_field('sys_user');
		foreach ($_POST as $name=>$value):
			$value = trim($value);
			// SYNC POSTs AND FIELDs
			if ($value != '' && in_array($name,$get_field)):
				switch ($name):
					case "usr_login": $data[$name] = strtolower($value); break;
					case "usr_pwd1" : $data[$name] = md5($value); break;
					case "usr_pwd2" : $data[$name] = md5($value); break;
					default: $data[$name] = $value; break;
				endswitch;
			endif;
		endforeach;
		
		$where['usr_id'] = $data['usr_id'];
		
		// SET USER MENU
		$set_menu = $this->input->post('menu');
		$ucat_id = $this->input->post('ucat_id');
		if ($ucat_id != 1)
			$this->user_menu($data['usr_id'],$set_menu);
				
		unset ($data['usr_id']);
		
		if ($this->tbl_user->ubah_user($where,$data)):
			echo "sukses";
		endif;
	}
	
	function hapus_user($usr_id,$ucat_id,$usr_cat)
	{
		if (!in_array($ucat_id,$this->arrAdmin)):
			if (in_array($usr_cat,$this->arrAdmin)):
				$where['usr_id'] = $usr_id;
				$this->tbl_user->hapus_user($where);
				$this->tbl_user->hapus_user_menu($where);
			else:
				$where['usr_id'] = $usr_id;
				$data['login_status'] = 0;
				$this->tbl_user->ubah_user($where,$data);
			endif;
			echo "sukses";
		endif;
		
	}
	
}

/* End of file master_user.php */
/* Location: ./app-imp/controllers/mod_master/master_user.php */