<?php

class Tbl_produk extends CI_Model {

	function __construct() 
	{
		parent::__construct();
	}	
	
	function data_produk($select=false,$where=false,$like=false,$join=false,$field_sort=false,$sort=false)
	{
		if ($field_sort == false):
			$field_sort = 'produk.produk_id';
			$sort = 'ASC';
		endif;
		
		// SELECT
		if (is_array($select)):
			$this->db->select($select);
		elseif ($select!=false):
			$this->db->select('*');
		endif;
		
		// WHERE
		if (is_array($where)):
			foreach ($where as $field=>$value):
				$this->db->where($field,$value);
			endforeach;
		elseif ($where!=false):
			$this->db->where("produk.produk_id",$where);
		endif;
		
		// LIKE
		if (is_array($like)):
			foreach ($like as $field=>$value):
				$this->db->like($field,$value,"after");
			endforeach;
		elseif ($like!=false):
			$this->db->like("produk.produk_nama",$like,"after");
		endif;
		
		// SORT
		if (is_array($field_sort)):
			foreach ($field_sort as $field):
				$this->db->order_by($field,$sort);
			endforeach;
		else:
			$this->db->order_by($field_sort,$sort);
		endif;
		
		$this->db->from("master_produk as produk");
		
		// JOIN
		if (is_array($join)):
			foreach($join as $tbl=>$inner):
				if (is_array($inner)):
					foreach($inner as $type=>$relasi):
						$this->db->join($tbl,$relasi,$type);
					endforeach;
				else:
					$this->db->join($tbl,$inner);
				endif;
			endforeach;
		endif;
		
		return $this->db->get();
	}
	
	function cek_produk($produk_id,$produk_nama="") 
	{
		$this->db->select("produk_id");
		if ($produk_nama!="")
			$this->db->where("produk_nama",$produk_nama);
		$this->db->where("produk_id",$produk_id);
		return $this->db->get("master_produk")->num_rows();
	}
	
	function nomor_kategori($kat_master) {
		$this->db->select_max('kat_kode','nomor');
		$this->db->where('kat_master',$kat_master);
		$query = $this->db->get('master_kategori');
		$query_rows = $query->row();
		return $query_rows->nomor;
	}
	
	function tambah_produk($data)
	{
		return $this->db->insert("master_produk",$data);
	}
	
	function hapus_produk($where=false)
	{
		if (is_array($where)):
			foreach ($where as $field=>$value):
				$this->db->where($field,$value);
			endforeach;
		elseif ($where!=false):
			$this->db->where("produk_id",$where);
		endif;
		
		return $this->db->delete("master_produk");
	}
	
	function ubah_produk($where=false,$data)
	{
		if (is_array($where)):
			foreach ($where as $field=>$value):
				$this->db->where($field,$value);
			endforeach;
		elseif ($where!=false):
			$this->db->where("produk_id",$where);
		endif;
		
		return $this->db->update("master_produk",$data);
	}

}