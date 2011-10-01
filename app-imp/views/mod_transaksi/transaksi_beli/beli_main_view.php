<?php 
if (isset($extraSubHeaderContent)) 
	echo $extraSubHeaderContent;

if (isset($page_title)) 
	echo $page_title;
	
?>
<script language="javascript">
var $tab = $('#tabs');

function beli_refresh() {
	$tab.tabs('select',1);
	$tab.tabs('load',1);
	return false;
}

function tambah_beli(produk_id) {
	$.ajax({
		url: '<?php echo site_url($link_controller)?>/tambah_beli/add/'+produk_id,
		type: 'POST',
		success: function(data) {
			//alert(data);
			if (data=='sukses') {
				//tabs_awal();
				//$tab.tabs('select',1);
			} else if (data=='duplikasi') {
				informasi("Product already exist in list !!!");
			} else if (data=='stok') {
				informasi("Not enough Stock in inventory !!!");	
			} else {
				beli_refresh(); // SMARTY ADD DITOLAK
			}
		},
		error: function() {
			alert('error');
		}
	});
	return false;
}

//tabs_awal();
</script>
<!-- Tabs -->
<div id="tabs">
	<ul>
		<li><a href="index.php/<?php echo $link_controller;?>/daftar_produk">LIST PRODUCT</a></li>
		<li><a href="index.php/<?php echo $link_controller;?>/daftar_beli">LIST BUYING</a></li>
	</ul>
</div>