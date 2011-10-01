<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_beli extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_beli($where=false) {
		
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;			
		endif;
		
		$this->db->order_by("beli_id");
		
		return $this->db->get("trans_beli");
	}
	
	function tambah_beli($data) {
		return $this->db->insert("trans_beli",$data);
	}
	
	function ubah_beli($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("trans_beli",$data);
	}
	
	function hapus_beli($where) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		return $this->db->delete("trans_beli");
	}	

}

/* End of file .php */
/* Location: ./../.php */