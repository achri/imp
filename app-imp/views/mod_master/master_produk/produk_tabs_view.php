<?php
	if (isset($extraSubHeaderContent)) {
		echo $extraSubHeaderContent;
	}
?>
<script type="text/javascript">
var $tab_sub = $('#tab_sub'), tab_pos = $tab_sub.tabs('option', 'selected');
masking('.number');
$('.number').blur();
$tab.tabs('disable',0);
$tab_sub.tabs('select',0);

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
	
	$.getJSON('index.php/<?php echo $link_controller?>/tree_kat_detail/'+kat_id+'/'+<?php echo (isset($kat_id))?($kat_id):(0)?>,function(data){
		if (data.kat_nama) {
			$('#kat_id').val(kat_id);
			$('#kat_kode').val(data.kat_kode);
			$('#kat_nama').text(data.kat_nama);
			$('#produk_kode').text(data.kat_kode+'.'+data.produk_no);
		} else {
			$('#kat_id').val('');
			$('#kat_kode').val('');
			$('#kat_nama').text('-');
			$('#produk_kode').text('-');
		}
		
		$('#produk_nama').focus();
	});
	
	$('input#produk_nama').autocomplete('index.php/<?php echo $link_controller?>/list_autocomplate/'+kat_id,{
		minChars: 2,
		matchCase: true,
		max: 10,
	}).result(function(event,item) {
		
	});
	return false;
}

</script>
<form id="form_produk" onsubmit="return <?php echo ($status=='edit')?('edit_produk()'):('buat_produk()')?>">
<input type="hidden" name="produk_id" value="<?php echo (isset($produk_id))?($produk_id):('')?>">

<div id="tab_sub">	
	<ul>
		<li><a href="#form_general_produk"><?php echo $tabs_general?></a></li>
		<li><a href="#form_satuan_produk"><?php echo $tabs_unit?></a></li>
	</ul>
	
	<div id="form_general_produk">
		<?php $this->load->view($link_view.'/produk_general_view')?>
	</div>
	<div id="form_satuan_produk">
		<?php $this->load->view($link_view.'/produk_satuan_view')?>
	</div>
</div>
<br>
<div class="ui-widget-content ui-corner-all" style="height:30px" align="center">
	<input type="submit" value="<?php echo ($status!='edit')?($btn_save):($btn_update)?>">
	<input type="button" value="<?php echo $btn_cancel?>" onclick="batal_tambah_produk();">
</div>

</form>