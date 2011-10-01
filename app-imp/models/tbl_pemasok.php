<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_pemasok extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_pemasok($where=false) {
		
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;			
		endif;
		
		$this->db->order_by("pemasok_nama");
		
		return $this->db->get("master_pemasok");
	}
	
	function tambah_pemasok($data) {
		return $this->db->insert("master_pemasok",$data);
	}
	
	function ubah_pemasok($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("master_pemasok",$data);
	}
	
	function hapus_pemasok($satuan_id) {
		$this->db->where("pemasok_id",$satuan_id);
		return $this->db->delete("master_pemasok");
	}	

}

/* End of file .php */
/* Location: ./../.php */