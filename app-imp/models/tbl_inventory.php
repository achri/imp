<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_inventory extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_inventory($where=false) {
		
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;			
		endif;
		
		$this->db->order_by("inv_id");
		
		return $this->db->get("inventory_stok");
	}
	
	function tambah_inventory($data) {
		return $this->db->insert("inventory_stok",$data);
	}
	
	function ubah_inventory($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("inventory_stok",$data);
	}
	
	function hapus_inventory($inventory_id) {
		$this->db->where("inv_id",$inventory_id);
		return $this->db->delete("inventory_stok");
	}	

}

/* End of file .php */
/* Location: ./../.php */