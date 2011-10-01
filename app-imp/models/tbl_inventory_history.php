<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_inventory_history extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_inventory_history($where=false) {
		
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;			
		endif;
		
		$this->db->order_by("inv");
		
		return $this->db->get("inventory_stok_history");
	}
	
	function tambah_inventory_history($data) {
		return $this->db->insert("inventory_stok_history",$data);
	}
	
	function ubah_inventory_history($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("inventory_stok_history",$data);
	}
	
	function hapus_inventory_history($where) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		else:
			$this->db->where("id",$where);
		endif;
		return $this->db->delete("inventory_stok_history");
	}	

}

/* End of file .php */
/* Location: ./../.php */