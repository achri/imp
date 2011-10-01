<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	
 @library
	- 
 @comment
	- 
*/

class Tbl_produk_satuan extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function data_produk_satuan($where=false,$like=false,$join=false,$field_sort='bs.produk_id',$sort='ASC')
	{
		if (is_array($where)):
			foreach ($where as $field=>$value):
				$this->db->where($field,$value);
			endforeach;
		elseif ($where!=false):
			$this->db->where("bs.produk_id",$where);
		endif;
		
		if (is_array($like)):
			foreach ($like as $field=>$value):
				$this->db->like($field,$value,"after");
			endforeach;
		elseif ($like!=false):
			$this->db->like("bs.produk_id",$like,"after");
		endif;
		
		if (is_array($field_sort)):
			foreach ($field_sort as $field):
				$this->db->order_by($field,$sort);
			endforeach;
		else:
			$this->db->order_by($field_sort,$sort);
		endif;
		
		$this->db->from("master_produk_satuan as bs");
		
		if (is_array($join)):
			foreach($join as $tbl=>$relasi):
				$this->db->join($tbl,$relasi);
			endforeach;
		endif;
		
		return $this->db->get();
	}
	
	function tambah_produk_satuan($data) {
		return $this->db->insert("master_produk_satuan",$data);
	}
	
	function ubah_produk_satuan($where,$data) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update("master_produk_satuan",$data);
	}
	
	function hapus_produk_satuan($where) {
		if (is_array($where)):
			foreach ($where as $field => $value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		return $this->db->delete("master_produk_satuan");
	}	

}

/* End of file .php */
/* Location: ./../.php */