<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_cabang extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_cabang($where=false) {
		
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;			
		endif;
		
		$this->db->order_by("cb_nama");
		
		return $this->db->get("master_cabang");
	}
	
	function tambah_cabang($data) {
		return $this->db->insert("master_cabang",$data);
	}
	
	function ubah_cabang($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("master_cabang",$data);
	}
	
	function hapus_cabang($where) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		else:
			$this->db->where("cb_id",$satuan_id);
		endif;
		return $this->db->delete("master_cabang");
	}	

}

/* End of file .php */
/* Location: ./../.php */