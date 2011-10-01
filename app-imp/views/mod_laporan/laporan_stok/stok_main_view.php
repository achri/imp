<?php 
if (isset($extraSubHeaderContent)) 
	echo $extraSubHeaderContent;

if (isset($page_title)) 
	echo $page_title;
	
?>
<script language="javascript">
var $tab = $('#tabs');
</script>
<!-- Tabs -->
<div id="tabs">
	<ul>
		<li><a href="index.php/<?php echo $link_controller;?>/daftar_gudang">INVENTORY</a></li>
	</ul>
</div>