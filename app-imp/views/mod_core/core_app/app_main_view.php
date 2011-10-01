<?php 
if (isset($extraSubHeaderContent)) 
	echo $extraSubHeaderContent;

if (isset($page_title)) 
	echo content_title($page_title,$path_themes);
	
?>

<?php $this->load->view($link_view.'/app_user_view')?>
<br>