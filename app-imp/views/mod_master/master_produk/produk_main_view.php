<?php 
if (isset($extraSubHeaderContent)) 
	echo $extraSubHeaderContent;

if (isset($page_title)) 
	echo content_title($page_title,$path_themes);
	
?>
<script language="javascript">
var $tab = $('#tabs');

function tabs_awal() {
	$tab.tabs();
	$tab.tabs('add' ,'index.php/<?php echo $link_controller;?>/tabs_tambah_produk','<?php echo $tabs_add?>',1);
	$tab.tabs('select',0);
	return false;
}

function tabs_edit(id) {
	$tab.tabs('select',0);
	$tab.tabs('remove',1);
	$tab.tabs('add' ,'index.php/<?php echo $link_controller;?>/tabs_edit_produk/'+id ,'<?php echo $tabs_edit?>',1);	
	$tab.tabs('select',1);
	return false;
}

function buat_produk() {
	unmasking('.number');
	
	var produk_nama = $('#produk_nama').val(),
		produk_kat = $('#kat_nama').text(),
		val = '('+produk_kat+') '+produk_nama;
	
	
	if (validasi('form#form_produk')){
		
		$.ajax({
			url: 'index.php/<?php echo $link_controller;?>/tambah_produk',
			type: 'POST',
			data: $('form#form_produk').serialize(),
			success: function(data){
				//alert(data);
				if (data == 'sukses') {
					batal_tambah_produk();
					/*show_dialog("Add product <strong>"+val.toUpperCase()+"</strong> successfull !!!", "INFORMATION", {
						"OK":function(){ $dlg_content.dialog('close'); }
					},batal_tambah_produk);
					*/
				} else if (data == 'duplikasi') {
					show_dialog("<?php echo $product?> <strong>"+val.toUpperCase()+"</strong> <?php echo $already?> !!!", "<?php echo $information?>", {
						"<?php echo $btn_ok?>":function(){ $dlg_content.dialog('close'); }
					});
				} else {
					show_dialog("<?php echo $btn_add.' '.$product?> <strong>"+val.toUpperCase()+"</strong> <?php echo $failed?> !!!", "<?php echo $information?>", {
						"<?php echo $btn_ok?>":function(){ $dlg_content.dialog('close'); }
					},batal_tambah_produk);
				}
				
				return false;
			},
			error: function() {
				//alert('wew');
				return false;
			}
		});
		
	}
	return false;
}

function edit_produk() {
	unmasking('.number');
	var val = $('#produk_nama').val();
	if (validasi('form#form_produk')){
		$.ajax({
			url: 'index.php/<?php echo $link_controller?>/edit_produk',
			type: 'POST',
			data: $('form#form_produk').serialize(),
			success: function(data){
				//alert(data);
				if (data == 'sukses') {
					batal_tambah_produk();
					//show_dialog("Edit product <strong>"+val.toUpperCase()+"</strong> successfull !!!", "INFORMATION", {
					//	"OK":function(){ $dlg_content.dialog('close'); }
					//},batal_tambah_produk);
				} else if (data == 'duplikasi') {
					show_dialog("<?php echo $btn_edit.' '.$product?> <strong>"+val.toUpperCase()+"</strong> <?php echo $already?> !!!", "<?php echo $information?>", {
						"<?php echo $btn_ok?>":function(){ $dlg_content.dialog('close'); }
					});
				} else {
					show_dialog("<?php echo $btn_edit.' '.$product?> <strong>"+val.toUpperCase()+"</strong> <?php echo $failed?> !!!", "<?php echo $information?>", {
						"<?php echo $btn_ok?>":function(){ $dlg_content.dialog('close'); }
					},batal_tambah_produk);
				}
				
			}
		});
	}
	return false;
}

function hapus_produk(produk_id) {
	var $dlg_button = {
		"<?php echo $btn_delete?>" : function() {
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/hapus_produk/'+produk_id,
				type: 'POST',
				success: function(data){
					refresh_table();
					$dlg_content.dialog('close');
				}
			});
		},
		"<?php echo $btn_cancel?>" : function() {
			$dlg_content.dialog('close');
		}
	};
	
	show_confirmation("<?php echo $btn_delete.' '.$product?> ???","<?php echo $confirmation?>",$dlg_button);
	return false;
}

function batal_tambah_produk() {
	$tab.tabs('enable',0);
	$tab.tabs('select',0);
	$tab.tabs('remove',1);
	tabs_awal();
	//$tab.tabs('add' ,'index.php/<?php echo $link_controller;?>/tabs_tambah_produk','TAMBAH produk',1);
	return false;
}

tabs_awal();

</script>
<!-- Tabs -->
<div id="tabs">
	<ul>
		<li><a href="index.php/<?php echo $link_controller;?>/daftar_produk"><?php echo $tabs_list?></a></li>
	</ul>
</div>