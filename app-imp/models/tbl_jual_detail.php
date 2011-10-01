<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_jual_detail extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_jual_detail($where=false) {
		
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;			
		endif;
		
		$this->db->order_by("jual_id");
		
		return $this->db->get("trans_jual_detail");
	}
	
	function tambah_jual_detail($data) {
		return $this->db->insert("trans_jual_detail",$data);
	}
	
	function ubah_jual_detail($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("trans_jual_detail",$data);
	}
	
	function hapus_jual_detail($where) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		return $this->db->delete("trans_jual_detail");
	}	

}

/* End of file .php */
/* Location: ./../.php */