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

class Core_app extends IMP_Controller {
	// public variable
	public static $link_controller, $link_view;
	private $layout;
	
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
		$output += $this->_themes();
		$output += $this->_language();
		
		$this->load->vars($output);
		
		
		$this->layout = 'body';
		
		log_message('debug', "Class $class init success");
	}
	
	// @info	: Loader class model,helper,config,library
	// @params	: null
	// @return	: null
	function _loader_class()
	{
		$this->load->library(array(
			"lib_menu","lib_login","lib_main_db",
		));
		$this->load->model(array(
			"tbl_menu",
		));
		return false;
	}
	
	// @info	: Extra Sub Header Content for JS & CSS
	// @access	: private
	// @params	: null
	// @return	: array	
	function _content_init()
	{
		$arrayCSS = array (
			'asset/src/jQuery/themes/ui-darkness/jquery.ui.all.css',
			'asset/css/layout.css',
		);
		
		$arrayJS = array (
			'asset/src/jQuery/core/jquery-1.5.1.js',
			'asset/src/jQuery/ui/jquery-ui-1.8.11.custom.js',
			'asset/src/jQuery/plugins/layout/jquery.layout.js',
			'asset/src/jQuery/helper/dialog.js',
			'asset/js/layout.js',
			'asset/js/general.js',
			'asset/js/menu.js',
		);
		
		$content = "";
		
		if (is_array($arrayCSS))
		foreach ($arrayCSS as $css):
			$content .= "<link type=\"text/css\" rel=\"stylesheet\" href=\"".base_url().$css."\"/>\n";
		endforeach;
		
		if (is_array($arrayJS))
		foreach ($arrayJS as $js):
			$content .= "<script type=\"text/javascript\" src=\"".base_url().$js."\"/></script>\n";
		endforeach;
		
		$output['extraHeaderContent'] = $content;
		
		return $output;
	}
	
	// @info	: Load public variable
	// @access	: private
	// @params	: null
	// @return	: array
	function _public_init()
	{
		// public variable
		self::$link_controller = 'mod_core/core_app';
		self::$link_view = 'mod_core/core_app';
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
		$output['title'] = "INVENTORY MANAGEMENT";
		$output['header_title'] = "INVENTORY MANAGEMENT";
		$output['header_subtitle'] = "Yulia Jaya Supplier";//"solution for your bussiness";
		
		$output['arrArt'] = $this->config->item('arrDivArt');
		
		// lib menu
		$output['list_menu'] = $this->lib_menu->get_menu();
		
		$where['usr_id'] = $this->session->userdata('usr_id');
		$output['list_user'] = $this->tbl_user->data_user($where);
		
		return $output;
	}
	
	// @info	: Themes Switch
	// @access	: privte
	// @params	: string
	// @return	: array
	function _themes($themes='default')
	{
		$path_themes = base_url().'asset/themes/content/'.$themes;	
		$this->config->set_item('path_themes',$path_themes);
		
		$content = "<link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"".base_url()."asset/themes/content/".$themes."/style.css\"/>\n";
		$content .= "<!--[if IE 6]><link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"".base_url()."asset/themes/content/".$themes."/style.ie6.css\" type=\"text/css\" media=\"screen\" /><![endif]-->\n";
		$content .= "<!--[if IE 7]><link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"".base_url()."asset/themes/content/".$themes."/style.ie7.css\" type=\"text/css\" media=\"screen\" /><![endif]-->\n";
		$content .= "<script type=\"text/javascript\" src=\"".base_url()."asset/themes/content/".$themes."/script.js\"/></script>\n";
		$content .= "<script type=\"text/javascript\" src=\"".base_url()."asset/themes/content/".$themes."/swfobject.js\"/></script>\n";
		
		$output['extraSubHeaderContent'] = $content;
		$output['path_themes'] = $path_themes;
		
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
		$this->lang->load("core_app", $set_lang);
		
		$lang['site_title'] 		= $this->lang->line("site_title");
	
		$lang['page_title'] 		= $this->lang->line("page_title");
		$lang['user_information'] 	= $this->lang->line("user_information");
		$lang['last_time_login'] 	= $this->lang->line("last_time_login");
		$lang['last_ip_login'] 		= $this->lang->line("last_ip_login");
		$lang['off_time_login'] 	= $this->lang->line("off_time_login");
		$lang['off_ip_login']		= $this->lang->line("off_ip_login");
		$lang['new_time_login'] 	= $this->lang->line("new_time_login");
		$lang['new_ip_login'] 		= $this->lang->line("new_ip_login");
		
		return $lang;
	}
	
	// @info	: Indexing Layout Default
	// @access	: public
	// @params	: null
	// @return	: [object]
	function index($layout='body') 
	{		
		$this->layout = $layout;
		
		if ($layout != 'body'):
			$output['extraSubHeaderContent'] = "
				<script type='text/javascript'>
				$(document).ready(function(){
					$('body, html').css({ overflow:'auto' });
					$('#art-page-background-gradient').css({ height: 'auto'});
				});
				</script>
			";
		endif;
		
		$output['layout_type'] = $this->layout;
		$output['layout_switch'] = $this->layout.'_layout';
		$this->load->view('/index',$output);
	}
	
	function home()
	{
		$output[''] = '';
		$this->load->view(self::$link_view.'/app_main_view',$output);
	}
	
	function log_out()
	{
		$this->lib_login->log_out();
	}
	
	function backup()
	{
		$this->lib_main_db->backup();
	}
	
}

/* End of file app_init.php */
/* Location: ./app-imp/controllers/app_init.php */