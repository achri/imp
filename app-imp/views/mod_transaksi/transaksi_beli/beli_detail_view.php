<?php 
if (isset($extraSubHeaderContent)) 
	//echo $extraSubHeaderContent;
?>
<script type="text/javascript">
var jualdetgrid_content = jQuery("#newapi_beli_detail"),
		lastsel,beli_ids;

function beli_refresh() {
	$tab.tabs('select',1);
	$tab.tabs('load',1);
	return false;
}
		
function beli_bersihkan() {
	$('form .beli_form').val('');
	$('select#satuan_id option:not(:first)').remove();
	$('#produk_kode').focus();
	return false;
}

function beli_unlocked() {
	$('form .beli_form').attr('disabled',false);
	$('#produk_kode').focus();
	return false;
}

function beli_locked() {
	$('form .beli_form').attr('disabled','disabled');
	return false;
}

/* SET DEFAULT CONDITION */
function beli_kondisi_awal(status,lock) {
	$('#beli_tambah').val("ADD");
	$('#beli_ubah').val("EDIT");
	$('#beli_tambah').show();
	$('#beli_ubah, #beli_hapus, #beli_batal').hide();
	jualdetgrid_content.trigger('reloadGrid');
	
	if (status){
		beli_bersihkan();
	}
	
	if (!lock) {
		beli_locked();
	}
	
	masking('.number');
	return false;
}

/* CALL AUTOCOMPLATE WITH NATIF AJAX */
function beli_getData() {
	var produk_kode = $('#produk_kode').val();
	if (produk_kode) {
		$.get('<?php echo site_url($link_controller)?>/list_autocomplate',{'tipe':'produk_kode','q':produk_kode},function(data){
			var item = data.split('|');
			
			// CASE OF RESULT ARRAY
			$('#produk_id').val(item[1]);
			$('#produk_nama').val(item[2]);
			$('#kat_id').val(item[4]);
			$('#kat_nama').val(item[5]);
			$('#inv_hrg_beli').val(item[7]);
			
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
function beli_selrow() {
	$('#beli_tambah, #beli_ubah, #beli_hapus').show();
	$('#beli_tambah').val("ADD");
	$('#beli_ubah').val("EDIT");
	$('#beli_batal').hide();
	beli_locked();
	beli_getData();
	return false;
}

/* ADD RECORD */
function beli_add(status) {
	$('#beli_ubah, #beli_hapus').hide();
	$('#beli_batal').show();
	
	if (status == "ADD"){
		beli_bersihkan();
		beli_unlocked();
		$('#new_password').attr('checked','checked');
		$('#beli_tambah').val("SAVE");
	} else {
		if (validasi("form#beli_form")) {
			unmasking('.number');
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/tambah_beli',
				type: 'POST',
				data: $('form#beli_form').formSerialize(),
				success: function(data) {
					masking_reload('.number');
					if (data == 'sukses') {
						beli_kondisi_awal();
					}else if (data == 'stok'){
						informasi("Not enough stock in iventory !!!");
					}else {
						informasi("Product already registered for selling !!!");
					}
				}
			});
		}
	}
	return false;
}

/* EDIT RECORD */
function beli_edit(status) {
	$('#beli_tambah, #beli_hapus').hide();
	$('#beli_batal').show();
	if (status == "EDIT"){
		beli_unlocked();
		$('#beli_ubah').val("UPDATE");
	} else {
		if (validasi("form#beli_form")) {
			unmasking('.number');
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/tambah_beli/edit',
				type: 'POST',
				data: $('form#beli_form').formSerialize(),
				success: function(data) {
					//alert(data);
					masking_reload('.number')
					if (data) {
						beli_kondisi_awal();
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
function beli_delete() {
	var beli_id = $('#beli_id').val(),
		produk_id = $('#produk_id').val(),
		$dlg_btn = {
			"AGREE" : function() {
				$.ajax({
					url: 'index.php/<?php echo $link_controller?>/hapus_beli/'+beli_id+'/'+produk_id,
					type: 'POST',
					success: function(data) {
						$dlg_content.dialog('close');
						beli_kondisi_awal(true);
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
function proses_beli() {
	var $dlg_btn = {
		"Agree" : function() {
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/proses_beli/',
				type: 'POST',
				success: function(data) {
					//alert(data);
					if (data) {
						$dlg_content.dialog('close'); 
						beli_refresh();
						//beli_kondisi_awal(true);
						
						// PRINT TRANSAKSI
						var url = '<?php echo site_url('mod_laporan/laporan_beli');?>/cetak_detail/'+data+'/false',
							print = $('#print_beli:checked').length;
						
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

	konfirmasi("Process to Buy ???",$dlg_btn);
	
	return false;
}

function hapus_beli(beli_id,produk_id) {
	var $dlg_btn = {
		"Delete" : function() {
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/hapus_beli/'+beli_id+'/'+produk_id,
				type: 'POST',
				success: function(data) { 
					if (data=='beli') {
						$dlg_content.dialog('close'); 
						//beli_kondisi_awal(true);
						beli_refresh_();
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

beli_kondisi_awal(true);
</script>

<?php //$this->load->view($link_view.'/beli_list_view')?>

<table width="100%">
<tr>
	<td align="center" valign="top"><?php $this->load->view($link_view.'/beli_detail_form_view')?></td>
</tr>
<tr>
	<td align="center" valign="top"><?php $this->load->view($link_view.'/beli_detail_grid_view')?></tr>
</tr>
</table>