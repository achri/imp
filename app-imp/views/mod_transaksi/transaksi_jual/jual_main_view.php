<?php 
if (isset($extraSubHeaderContent)) 
	echo $extraSubHeaderContent;

if (isset($page_title)) 
	echo $page_title;
	
?>
<script language="javascript">
var $tab = $('#tabs');

function jual_refresh() {
	$tab.tabs('select',1);
	$tab.tabs('load',1);
	return false;
}

function tabs_awal() {
	$.ajax({
		url: 'index.php/<?php echo $link_controller?>/cek_tabs_jual',
		type: 'POST',
		success: function(data) {
			if (data) {
				tabs_tambah(data);
			} else {
				hapus_tabs();
			}
		}
	});
}

function tabs_tambah(count) {
	var tcount = '('+count+' item)';
	if (count > 1)
		tcount = '('+count+' items)';
	$tab.tabs('select',0);
	$tab.tabs('remove',1);
	$tab.tabs('add' ,'index.php/<?php echo $link_controller;?>/daftar_jual','LIST SELLING '+tcount,1);
	//$tab.tabs('select',1);
	return false;
}

function hapus_tabs() {
	$tab.tabs('select',0);
	$tab.tabs('remove',1);
	//$tab.tabs('select',1);
}

function tambah_jual(produk_id) {
	$.ajax({
		url: 'index.php/<?php echo $link_controller?>/tambah_jual/add/'+produk_id,
		type: 'POST',
		success: function(data) {
			if (data=='sukses') {
				//tabs_awal();
				//$tab.tabs('select',1);
			} else if (data=='duplikasi') {
				informasi("Product already exist in list !!!");
			} else if (data=='stok') {
				informasi("Not enough Stock in inventory !!!");
			} else {
				jual_refresh(); // SMARTY ADD DITOLAK
			}
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
		<li><a href="index.php/<?php echo $link_controller;?>/daftar_jual">LIST SELLING</a></li>
	</ul>
</div>