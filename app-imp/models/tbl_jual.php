<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_jual extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_jual($where=false) {
		
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;			
		endif;
		
		$this->db->order_by("jual_id");
		
		return $this->db->get("trans_jual");
	}
	
	function tambah_jual($data) {
		return $this->db->insert("trans_jual",$data);
	}
	
	function ubah_jual($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("trans_jual",$data);
	}
	
	function hapus_jual($where) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		return $this->db->delete("trans_jual");
	}	

}

/* End of file .php */
/* Location: ./../.php */