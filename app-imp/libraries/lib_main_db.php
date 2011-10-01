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

class Lib_main_db
{
	private $IMP,$backupPath;
	
	function __construct()
	{
		$this->IMP =& get_instance();
		$this->backupPath = $this->IMP->config->item('backupPath');
		
		$this->IMP->load->dbutil();
		$this->IMP->load->helper('file');
		$this->IMP->load->helper('download');
	}
	
	function backup()
	{
		$tgl = date('Y');
		
		$prefs = array(
                'tables'      => array(),
                'ignore'      => array('ci_sessions','sys_menu','sys_client','master_legality','master_jenis_trans','master_akses'),
                'format'      => 'gzip',             
                'filename'    => 'mip_'.$tgl.'.sql',    
                'add_drop'    => TRUE,              
                'add_insert'  => TRUE,              
                'newline'     => "\n"
              );

		$backup =& $this->IMP->dbutil->backup($prefs);
		
		write_file($this->backupPath.'/mip_'.$tgl.'.gz', $backup);
		force_download('mip_'.$tgl.'.gz', $backup); 
	}
}