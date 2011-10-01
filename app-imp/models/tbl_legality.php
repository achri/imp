<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_legality extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_legality($where=false) {
		
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;			
		endif;
		
		$this->db->order_by("legal_nama");
		
		return $this->db->get("master_legality");
	}
	
	function tambah_legality($data) {
		return $this->db->insert("master_legality",$data);
	}
	
	function ubah_legality($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("master_legality",$data);
	}
	
	function hapus_legality($legal_id) {
		$this->db->where("legal_id",$legal_id);
		return $this->db->delete("master_legality");
	}	

}

/* End of file .php */
/* Location: ./../.php */