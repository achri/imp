<?php 
if ($status == 'edit'):
	if ($produk_status != 0):
?>
<script language="javascript">
$(".edited").hide();
</script>
<?php 
	endif;
endif;?>
<input type="hidden" name="produk_status" value="<?php echo (isset($produk_status))?($produk_status):(0)?>">
<div style="width:100%;display: table">
	<div style="width:50%;float: left;">
		<fieldset style="height:245px;" class="ui-widget-content ui-corner-all">
		<legend class="ui-state-default ui-corner-all"><?php echo $category?></legend>
		<?php
			$data['kat_tipe'] = "produk";
			$data['tree_id'] = "produk_tree";
			$this->load->view($link_controller.'/produk_tree_view',$data);
		?>
		</fieldset>
		<br>
		<fieldset style="" class="ui-widget-content ui-corner-all">
		<legend class="ui-state-default ui-corner-all"><?php echo $cabang?></legend>
			<SELECT NAME="cb_id" ID="cb_id" class="required select null" title="<?php echo $cabang?>">
				<option value="">--<?php echo $selcb?>--</option>
				<?php
				if ($list_cabang->num_rows()>0):
					foreach ($list_cabang->result() as $row_cb):
				?>
					<option value="<?php echo $row_cb->cb_id?>" <?php echo ((isset($cb_id)&&($cb_id == $row_cb->cb_id)))?('SELECTED'):('')?>><?php echo $row_cb->cb_nama?></option>
				<?php 
					endforeach;
				endif;?>
			</SELECT>
		</fieldset>
	</div>
	<div style="width:48%;float: right;" id="grup_list_content">
		<fieldset class="ui-widget-content ui-corner-all">
		<legend class="ui-state-default ui-corner-all"><?php echo $pro_form?></legend>
		<!--?php $this->load->view($link_view.'/produk_general_form_view');?-->
			<table width="100%">
			<tbody valign="top">
			<tr>
				<td width="100px"><?php echo $category?></td>
				<td width="5px">:</td>
				<td id="kat_nama">
					<?php echo (isset($split_kat_nama))?($split_kat_nama):('-');?>
				</td>
			</tr>
			<tr>
				<td><?php echo $pro_code?></td>
				<td>:</td>
				<td id="produk_kode">
					<?php echo (isset($produk_kode))?($produk_kode):('-');?>
				</td>
			</tr>
			<tr>
				<td><?php echo $pro_name?></td>
				<td>:</td>
				<td>
					<input type="hidden" name="kat_id_old" value="<?php echo (isset($kat_id))?($kat_id):('')?>">
					<input type="hidden" id="kat_id" name="kat_id" value="<?php echo (isset($kat_id))?($kat_id):('')?>" class="required" title="Category">
					<input type="hidden" id="kat_kode" name="kat_kode" value="<?php echo (isset($produk_kode))?($produk_kode):('')?>">
					<input type="text" id="produk_nama" name="produk_nama" value="<?php echo (isset($produk_nama))?($produk_nama):('')?>" class="required uppercase produk_nama" title="Product Name">
				</td>
			</tr>
			</tbody>
			</table>
		</fieldset>
		<br>
		<fieldset class="ui-widget-content ui-corner-all">
			<legend class="ui-state-default ui-corner-all"><?php echo $pro_det?></legend>
			<table width="100%">
			<tbody valign="top">
			<tr>
				<td width="100px"><?php echo $unit?></td>
				<td width="5px">:</td>
				<td>
				<SELECT NAME="satuan_id" ID="satuan_id" class="required select null" onkeyup="satuan_id_change(this.value);" onchange="satuan_id_change(this.value);" title="Unit">
					<option value="">--<?php echo $selunit?>--</option>
					<?php 
					if ($list_satuan->num_rows()>0):
						foreach ($list_satuan->result() as $row_unit):
					?>
						<option value="<?php echo $row_unit->satuan_id?>" <?php echo ((isset($satuan_id)&&($satuan_id == $row_unit->satuan_id))||($row_unit->satuan_default == 1))?('SELECTED'):('')?>><?php echo $row_unit->satuan_nama?></option>
					<?php 
						endforeach;
					endif;?>
				</SELECT>
				</td>
			</tr>
			<tr class="edited">
				<td width="100px"><?php echo $stock?></td>
				<td width="5px">:</td>
				<td><input digit_decimal=2 name="produk_stok" id="produk_stok" class="number" title="Stock Product" value="<?php echo (isset($produk_stok)?($produk_stok):(0))?>"></td>
			</tr>
			<tr>
				<td><?php echo $minstock?></td>
				<td>:</td>
				<td><input digit_decimal=2 class="number" name="produk_min_stok" id="produk_min_stok" value="<?php echo (isset($produk_min_stok)?($produk_min_stok):(0))?>"></td>
			</tr>
			<tr class="edited">
				<td><?php echo $buying?> (Rp)</td>
				<td>:</td>
				<td><input digit_decimal=2 name="produk_harga_beli" id="produk_harga_beli" class="number null" title="Price Buying" value="<?php echo (isset($produk_harga_beli)?($produk_harga_beli):(0))?>"></td>
			</tr>
			<tr class="edited">
				<td><?php echo $selling?> (Rp)</td>
				<td>:</td>
				<td><input digit_decimal=2 name="produk_harga_jual" id="produk_harga_jual" class="number null" title="Price Selling" value="<?php echo (isset($produk_harga_jual)?($produk_harga_jual):(0))?>"></td>
			</tr>
			<tr>
				<td><?php echo $description?></td>
				<td>:</td>
				<td><textarea name="keterangan"><?php echo (isset($keterangan)?($keterangan):(''))?></textarea></td>
			</tr>
			</tbody>
			</table>
		</fieldset>
	</div>
	<div id="grup_add_content" style="width:45%;height:340px;float: right; display:none" class="ui-widget-content ui-corner-all">		
	</div>
</div>