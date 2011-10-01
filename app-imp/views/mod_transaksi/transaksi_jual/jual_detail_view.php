<?php 
if (isset($extraSubHeaderContent)) 
	//echo $extraSubHeaderContent;
?>
<script type="text/javascript">
var jualdetgrid_content = jQuery("#newapi_jual_detail"),
		lastsel,jual_ids;

function jual_refresh() {
	$tab.tabs('select',1);
	$tab.tabs('load',1);
	return false;
}

function jual_bersihkan() {
	$('form .jual_form').val('');
	$('select.satuan_id option:not(:first)').remove();
	$('#produk_kode').focus();
	return false;
}

function jual_unlocked() {
	$('form .jual_form').attr('disabled',false);
	$('#produk_kode').focus();
	return false;
}

function jual_locked() {
	$('form .jual_form').attr('disabled','disabled');
	return false;
}

/* SET DEFAULT CONDITION */
function jual_kondisi_awal(status,lock) {
	$('#jual_tambah').val("ADD");
	$('#jual_ubah').val("EDIT");
	$('#jual_tambah').show();
	$('#jual_ubah, #jual_hapus, #jual_batal').hide();
	jualdetgrid_content.trigger('reloadGrid');
	
	if (status){
		jual_bersihkan();
	}
	
	if (!lock) {
		jual_locked();
	}
	
	masking('.number');
	return false;
}

/* CALL AUTOCOMPLATE WITH NATIF AJAX */
function jual_getData() {
	var produk_kode = $('#produk_kode').val();
	if (produk_kode) {
		$.get('<?php echo site_url($link_controller)?>/list_autocomplate',{'tipe':'produk_kode','q':produk_kode},function(data){
			var item = data.split('|');
			
			// CASE OF RESULT ARRAY
			$('#produk_id').val(item[1]);
			$('#produk_nama').val(item[2]);
			$('#kat_id').val(item[4]);
			$('#kat_nama').val(item[5]);
			$('#inv_hrg_jual').val(item[7]);
			
			// POPULATE MULTI UNIT
			var produk_id = item[1],
				satuan_id = item[6];
					
			$('#satuan_id').load('<?php echo site_url($link_controller)?>/set_multi_satuan/'+produk_id+'/'+satuan_id);
			
			masking_reload('.number');			
			return false;
		});
	}
	return false;
}

/* BIND EVENT SELECTED GRID */
function jual_selrow() {
	$('#jual_tambah, #jual_ubah, #jual_hapus').show();
	$('#jual_tambah').val("ADD");
	$('#jual_ubah').val("EDIT");
	$('#jual_batal').hide();
	jual_locked();
	jual_getData();
	return false;
}

/* ADD RECORD */
function jual_add(status) {
	$('#jual_ubah, #jual_hapus').hide();
	$('#jual_batal').show();
	
	if (status == "ADD"){
		jual_bersihkan();
		jual_unlocked();
		$('#new_password').attr('checked','checked');
		$('#jual_tambah').val("SAVE");
	} else {
		if (validasi("form#jual_form")) {
			unmasking('.number');
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/tambah_jual',
				type: 'POST',
				data: $('form#jual_form').formSerialize(),
				success: function(data) {
					masking_reload('.number');
					if (data == 'sukses') {
						jual_kondisi_awal();
					}else if (data == 'stok'){
						informasi("Not enough stock in iventory !!!");
					} else {
						informasi("Product already registered for selling !!!");
					}
				}
			});
		}
	}
	return false;
}

/* EDIT RECORD */
function jual_edit(status) {
	$('#jual_tambah, #jual_hapus').hide();
	$('#jual_batal').show();
	if (status == "EDIT"){
		jual_unlocked();
		$('#jual_ubah').val("UPDATE");
	} else {
		if (validasi("form#jual_form")) {
			unmasking('.number');
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/tambah_jual/edit',
				type: 'POST',
				data: $('form#jual_form').formSerialize(),
				success: function(data) {
					//alert(data);
					masking_reload('.number')
					if (data) {
						jual_kondisi_awal();
					} else {
						informasi("ERROR CONNECTION");
					}
				}
			});
		}
	}
	return false;
}

/* DELETE RECORD */
function jual_delete() {
	var jual_id = $('#jual_id').val(),
		produk_id = $('#produk_id').val(),
		$dlg_btn = {
			"AGREE" : function() {
				$.ajax({
					url: 'index.php/<?php echo $link_controller?>/hapus_jual/'+jual_id+'/'+produk_id,
					type: 'POST',
					success: function(data) {
						$dlg_content.dialog('close');
						jual_kondisi_awal(true);
					}
				});	
			},
			"CANCEL" : function() {
				$(this).dialog('close');
			}
		};
		
	if (produk_id) {
		konfirmasi("This Produk will be removed in list ???",$dlg_btn);
	} 
	return false;
}

/* PROCESS JUAL */
function proses_jual() {
	var $dlg_btn = {
		"Agree" : function() {
			var trans_jenis_id = $('#trans_jenis_id').val();
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/proses_jual/',
				type: 'POST',
				data: {'trans_jenis_id':trans_jenis_id},
				success: function(data) {
					//alert(data);
					if (data) {
						$dlg_content.dialog('close'); 
						//jual_kondisi_awal(true);
						jual_refresh();
						var url = '<?php echo site_url('mod_laporan/laporan_jual');?>/cetak_detail/'+data+'/false',
							print = $('#print_jual:checked').length;
						
						if (print > 0)
							open(url,'Win1','toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width=800,height=600,left=30,top=30');
					} else {
						informasi('Failed to process !!!');
					}
				}
			});
		},
		"Wait" : function() {
			$dlg_content.dialog('close');
		}
	};

	konfirmasi("Process to Sell ???",$dlg_btn);
	
	return false;
}

function hapus_jual(jual_id,produk_id) {
	var $dlg_btn = {
		"Delete" : function() {
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/hapus_jual/'+jual_id+'/'+produk_id,
				type: 'POST',
				success: function(data) { 
					if (data=='beli') {
						$dlg_content.dialog('close'); 
						//jual_kondisi_awal(true);
						jual_refresh();
					} else if (data=='items') {
						$dlg_content.dialog('close');						
					}	
				}
			});
		},
		"Cancel" : function() {
			$dlg_content.dialog('close');
		}
	}, $dlg_close = function(){ beligrid_content.trigger('reloadGrid'); };
	
	konfirmasi("Item will be delete ???",$dlg_btn,$dlg_close);
	return false;
}

jual_kondisi_awal(true);
</script>

<table width="100%">
<tr>
	<td align="center" valign="top"><?php $this->load->view($link_view.'/jual_detail_form_view')?></td>
</tr>
<tr>
	<td align="center" valign="top"><?php $this->load->view($link_view.'/jual_detail_grid_view')?></tr>
</tr>
</table>