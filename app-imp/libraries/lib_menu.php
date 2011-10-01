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

class Lib_menu 
{
	private $IMP,$arrAkses,$menu,$wewenang;
	
	function __construct()
	{
		$this->IMP =& get_instance();
		$this->menu = "";
		$this->wewenang = "";
		
		$this->arrAkses = array_merge($this->IMP->config->item('arrAkses'),$this->IMP->config->item('arrAdmin'));
	}
	
	function get_menu() {
		$this->menu = "";
		$this->get_allMenu();
		return $this->menu;
	}
	
	function get_allMenu($menu_parent = 0, $lvl = 0, $slvl = 0) {
		$usrid = $this->IMP->session->userdata('usr_id');
		$ucat_id = $this->IMP->session->userdata('ucat_id');
		
		$lvl++;	
		
		//$sql_p = "select * from sys_menu where menu_parent = $menu_parent";
		if (in_array($ucat_id,$this->arrAkses)):
			$SQL = "SELECT sm.menu_id, sm.menu_parent, sm.menu_level, sm.menu_nama, sm.menu_icon, sm.menu_module
				FROM sys_menu AS sm
				WHERE sm.menu_parent = '$menu_parent' 
				ORDER BY sm.menu_sort, sm.menu_id";
		else:
			$SQL = "SELECT sum.usr_id, sum.menu_id, sm.menu_parent, sm.menu_level, sm.menu_nama, sm.menu_icon, sm.menu_module
				FROM sys_user_menu AS sum
				INNER JOIN sys_menu AS sm ON sum.menu_id = sm.menu_id
				WHERE sum.usr_id = '$usrid' AND sm.menu_parent = '$menu_parent' 
				ORDER BY sm.menu_sort, sum.menu_id";
			
		endif;
		
		$get_p = $this->IMP->db->query($SQL);
		
		foreach ($get_p->result() as $r_p):
			$set_child = '';
			$folder = '';
			if ($this->cek_level($r_p->menu_id) > 0 ):
				$set_child = "\n<ul>";
				$slvl = $r_p->menu_id;
			else:
				$slvl = 0;
			endif;
			
			if ($r_p->menu_module!=""):
				$module = "module='".$r_p->menu_module."'";
			else:
				$module = "";
			endif;
			
			if ($r_p->menu_parent==0):
				$this->menu .= "<li><a href='#' ".$module."><span class='l'></span><span class='r'></span><span class='t'>".$r_p->menu_nama."</span></a>\n".$set_child;
			else:
				$this->menu .= "<li><a href='' ".$module.">".$r_p->menu_nama."</a>\n".$set_child;
			endif;
			
			//$this->menu .= "\n<li>".$r_p->menu_nama.$set_child;
			$this->get_allMenu($r_p->menu_id, $lvl, $slvl);
			
			if ($r_p->menu_id == $slvl):
				$this->menu .= "</ul>\n";
			else:
				$this->menu .= "</li>\n";
			endif;
		endforeach;
	}
	
	/*
	function get_allMenu($parentid=0, $i=1){
		
		$usrid = $this->IMP->session->userdata('usr_id');
		$ucat_id = $this->IMP->session->userdata('ucat_id');
		
		if ($ucat_id != 1):
			$SQL = "SELECT sum.usr_id, sum.menu_id, sm.menu_parent, sm.menu_level, sm.menu_nama, sm.menu_icon, sm.menu_module
				FROM sys_user_menu AS sum
				INNER JOIN sys_menu AS sm ON sum.menu_id = sm.menu_id
				WHERE sum.usr_id = '$usrid' AND sm.menu_parent = '$parentid' 
				ORDER BY sm.menu_sort, sum.menu_id";
		else:
			$SQL = "SELECT sm.menu_id, sm.menu_parent, sm.menu_level, sm.menu_nama, sm.menu_icon, sm.menu_module
				FROM sys_menu AS sm
				WHERE sm.menu_parent = '$parentid' 
				ORDER BY sm.menu_sort, sm.menu_id";
		endif;
		
		$get_data = $this->IMP->db->query($SQL);
		$maxrow = $get_data->num_rows();
				
        foreach($get_data->result() as $rows):				
			if ($rows->menu_module!=""):
				$module = "module='".$rows->menu_module."'";
			else:
				$module = "";
			endif;
			
			if ($rows->menu_parent==0):
				$item = "<li><a href='#' ".$module."><span class='l'></span><span class='r'></span><span class='t'>".$rows->menu_nama."</span></a>\n";
			else:
				$item = "<li><a href='' ".$module.">".$rows->menu_nama."</a>\n";
			endif;
			
			if ($rows->menu_level >= 1 && $rows->menu_module == "")
				$item .= '<ul>';
			
			$this->menu .= $item;
			
			if ($rows->menu_level >= 2) $i++;
			else $i = 1;
				
			$this->get_allMenu($rows->menu_id,$i);
			
			$this->menu .= "</li>\n";
			
			if ($rows->menu_level >= 2 && $i > $maxrow):
				$this->menu .= '</ul>';
			endif;
						
		endforeach;
	}
	*/
	
	function get_wewenang($usrid,$ucatid) {
		$this->wewenang = "";
		$this->get_allWewenang($usrid,$ucatid);
		return $this->wewenang;
	}
	
	function cek_level($menu_id) {
		$this->IMP->db->select('count(menu_id) as record_count');
		$this->IMP->db->where('menu_parent',$menu_id);
		$this->IMP->db->from('sys_menu');
		return $this->IMP->db->get()->row()->record_count;
	}
	
	function get_allWewenang($usrid, $ucat_id, $menu_parent = 0, $lvl = 0, $slvl = 0) {
		$br = '';
		$lvl++;	
		$sql_p = "select * from sys_menu where menu_parent = $menu_parent";
		$get_p = $this->IMP->db->query($sql_p);
		foreach ($get_p->result() as $r_p):
			$set_child = '';
			$folder = '';
			if ($this->cek_level($r_p->menu_id) > 0 ):
				$set_child = ', children: ['.$br;
				$slvl = $r_p->menu_id;
				$folder = ', isFolder: true';
			else:
				$slvl = 0;
			endif;
			
			$selected = (in_array($ucat_id,$this->arrAkses))?('select: true, '):('');
			$sql_u = "select * from sys_user_menu where usr_id = '".$usrid."' and menu_id = '".$r_p->menu_id."'";
			$get_u = $this->IMP->db->query($sql_u);
			if($get_u->num_rows() > 0):
				$selected = 'select: true, ';
			endif;

			$this->wewenang .= '{'.$selected.'title: "'.$r_p->menu_nama.'", key: "'.$r_p->menu_id.'"'.$folder.$set_child;
			$this->get_allWewenang($usrid, $ucat_id, $r_p->menu_id, $lvl, $slvl);
			
			if ($r_p->menu_id == $slvl):
				$this->wewenang .= ']},'.$br;
			else:
				$this->wewenang .= '},'.$br;
			endif;
		endforeach;
	}

}