<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 @author		Achri
 @date creation	
 @model
	- 
 @view
	- 
 @library
    - JS		
    - PHP
 @comment
	- 
*/

class Tbl_menu extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function data_menu($where=false,$like=false)
	{
		if (is_array($where)):
			foreach ($where as $field=>$value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		$this->db->order_by('menu_id');
		
		return $this->db->get('sys_menu');
	}
	
	function update_menu($where,$data)
	{
		if (is_array($where)):
			foreach ($where as $field=>$value):
				$this->db->where($field,$value);
			endforeach;
		endif;
		
		return $this->db->update('sys_menu',$data);
	}
	
}