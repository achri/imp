<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_beli_detail extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_beli_detail($where=false) {
		
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;			
		endif;
		
		$this->db->order_by("beli_id");
		
		return $this->db->get("trans_beli_detail");
	}
	
	function tambah_beli_detail($data) {
		return $this->db->insert("trans_beli_detail",$data);
	}
	
	function ubah_beli_detail($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("trans_beli_detail",$data);
	}
	
	function hapus_beli_detail($where) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		return $this->db->delete("trans_beli_detail");
	}	

}

/* End of file .php */
/* Location: ./../.php */