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

class Lib_lang
{
	private $IMP;
	
	function __construct()
	{
		$this->IMP =& get_instance();
		$this->_set_lang();
	}
	
	// @function: set session lang
	// @access	: public
	// @return	: void
	function _set_lang()
	{
		if ($this->IMP->session):
			if (!$this->IMP->session->userdata('set_lang')):
				$this->IMP->session->set_userdata(array('set_lang'=>'indonesia'));
			endif;
		endif;
	} 
}

/* End of file lib_lang.php */
/* Location: ./application/libraries/lib_lang.php */