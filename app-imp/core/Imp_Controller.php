<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 @author		Achri
 @date creation	
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

class IMP_Controller extends CI_Controller {
	private $IMP;
	function __construct() 
	{
		parent::__construct();
		$this->IMP =& get_instance();
		
		$this->load->library(array("lib_login","lib_lang"));
		
		$unlocked = $this->IMP->config->item('class_unlocked');
		if ( ! $this->IMP->lib_login->is_logged_in() AND ! in_array(strtolower(get_class($this)), $unlocked))
		{
			redirect(site_url('mod_core/core_login/index'),'location');
		} 
		
		/* ROUTINE FUNCTION */
		$this->_cek_backup();
		//$this->_routine();
	}
	
	private function _cek_backup()
	{
		$tgl = date('Y');
	}
	
	private function _routine()
	{
		$preg = $this->IMP->config->item('odata');//md5("48f163008c1985f433b6c76cf1ecb89e");
		if (!file_exists($preg))
			die();
	}
}

/* End of file Security.php */
/* Location: ./application/libraries/security.php */