<?php
	if (isset($extraSubHeaderContent)) {
		echo $extraSubHeaderContent;
	}
?>
<script type="text/javascript">
var $tab = $('#tabs'), tab_pos = $tab.tabs('option', 'selected');
masking('.number');
$('.number').blur();
$tab.tabs('disable',0);

/*
if ($('li',$tab).length == 4)
	$tab.tabs('add' ,'index.php/<?php echo $link_controller_kategori;?>/','LINK KATEGORI',2);
*/

function tambah_kategori() {
	$dlg_content.load('index.php/<?php echo $link_controller_kategori;?>/index')
	.dialog('option','buttons',{
		"OK" : function() {
		
		}
	}).dialog('open');
	return false;
}

function get_kat_nama(kat_id) {
	
	$.getJSON('index.php/<?php echo $link_controller?>/tree_kat_detail/'+kat_id,function(data){
		if (data.kat_nama) {
			$('#kat_id').val(kat_id);
			$('#kat_kode').val(data.kat_kode);
			$('#kat_nama').text(data.kat_nama);
			$('#gudang_kode').text(data.kat_kode+'.'+data.gudang_no);
		} else {
			$('#kat_id').val('');
			$('#kat_kode').val('');
			$('#kat_nama').text('-');
			$('#gudang_kode').text('-');
		}
		
		$('#gudang_nama').focus();
	});
	
	$('input#gudang_nama').autocomplete('index.php/<?php echo $link_controller?>/list_autocomplate/'+kat_id,{
		minChars: 2,
		matchCase: true,
		max: 10,
	}).result(function(event,item) {
		
	});
	return false;
}

</script>
<form id="form_gudang" onsubmit="return <?php echo ($status=='edit')?('edit_gudang()'):('buat_gudang()')?>">
<input type="hidden" name="gudang_id" value="<?php echo (isset($gudang_id))?($gudang_id):('')?>">

<div id="tabs">	
	<ul>
		<li><a href="#form_general_gudang">GENERAL</a></li>
		<li><a href="#form_detail_gudang">DETAIL</a></li>
		<li><a href="#form_satuan_gudang">SATUAN</a></li>
		<!--li><a href="#form_shortcut">OPSI</a></li-->
	</ul>
	
	<div id="form_general_gudang">
		<?php $this->load->view($link_view.'/stok_general_view')?>
	</div>
	<div id="form_detail_gudang">
		<?php $this->load->view($link_view.'/stok_detail_view')?>
	</div>
	<div id="form_satuan_gudang">
		<?php $this->load->view($link_view.'/stok_satuan_view')?>
	</div>
	<!--div id="form_shortcut" align="center">
		<input type="button" value="Tambah Data Kategori" onclick="tambah_kategori();">
		<input type="button" value="Tambah Data Satuan" onclick="tambah_satuan();">
	</div-->
</div>
<br>
<div class="ui-widget-content ui-corner-all" style="height:30px" align="center">
	<input type="submit" value="Tambah gudang">
	<input type="button" value="Batal" onclick="batal_tambah_gudang();">
</div>

</form>