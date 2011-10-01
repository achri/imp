<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_sys_counter extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_sys_counter($where=false) {
		
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;			
		endif;
		
		return $this->db->get("sys_counter");
	}
	
	function tambah_sys_counter($data) {
		return $this->db->insert("sys_counter",$data);
	}
	
	function ubah_sys_counter($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("sys_counter",$data);
	}
	
	function hapus_sys_counter($where) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		return $this->db->delete("sys_counter");
	}	

}

/* End of file .php */
/* Location: ./../.php */