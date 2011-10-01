<?php 
if (isset($extraSubHeaderContent)) 
	echo $extraSubHeaderContent;

if (isset($page_title)) 
	echo $page_title;
	
?>

<?php $this->load->view($link_view.'/jual_grid_view')?>