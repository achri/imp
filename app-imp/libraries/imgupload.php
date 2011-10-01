<?php
class Imgupload {
	function __construct() {
		$this->CI =& get_instance();
		$CI->load->library(array('pictures'));
		$CI->load->helper(array('file'));
	}
	
	function upload_this($imgname,$img_path) {
		$thumb_folder	= $img_path;
		$temp_folder	= './uploaded/temp/';
		if ($CI->upload->do_upload()):
			$image = $CI->upload->data();
			$imgfile = $imgname.$image['file_ext'];
			$config['source_image'] = $temp_folder.$image['file_name'];
			$config['new_image'] = $thumb_folder.$imgfile ;
			$CI->image_lib->initialize($config);
			if ($CI->image_lib->resize()):
				unlink($temp_folder.$image['file_name']);
				return $imgfile;
			endif;
		endif;
	}

}
?>