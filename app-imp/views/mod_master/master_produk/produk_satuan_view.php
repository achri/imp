<script language="javascript">
var sat_row_id,sat_row_num = <?php echo ($status=='edit')?($list_produk_satuan->num_rows()+1):(1)?>,
	sat_table = $('#TblSatuan'),i=1;
function satuan_id_change(val) {
	var sat,digit;
	sat = val.split('_');
	val = sat[0];
	digit = sat[1];
	
	$('.satuan_id2').val(val);
	
	return false;
}

function addRowSatToTable() {
	var um_val = $('#satuan_id').val();
	var digit = um_val.split('_');
	digit = digit[1];
	
	if (um_val != '0'){
		if (sat_table.hide()) {
			sat_table.show();
		}
		if(sat_row_num <= 5) {
			$('#TblSatuan').append(tr_sat_content(sat_row_num,digit));	
			sat_row_num = sat_row_num + 1;
			var mas_unit = $('#satuan_id').val();
			satuan_id_change(mas_unit);
			masking('.number');
		}
	} else {
		alert('Unit satuan belum dipilih');
	}
	return false;
}

function removeRowSatFromTable(sat_row_id) {
	$('#sat_row_'+sat_row_id).remove();
	if (sat_row_num > 0){
		sat_row_num = sat_row_num - 1;
	}else {
		sat_row_num = 1;
		sat_table.hide();
	}
	return false;			
}

function tr_sat_content(sat_row_id,digit) {
	var row_content = '<tr baris="'+sat_row_id+'" id="sat_row_'+sat_row_id+'"><td width="150" align="center" class="fieldcell">'+
  	'<select name="satuan_sub[]" id="satuan_sub" class="satuan_sub required select" title="Sub Unit">'+
  	'<option value="">--<?php echo $selunit?>--</option>'+
  	<?php 
	if ($list_satuan->num_rows()>0): 
		foreach ($list_satuan->result() as $row_unit):
	?>
   	'<option value="<?php echo $row_unit->satuan_id?>"><?php echo $row_unit->satuan_nama?></option>'+
   	<?php 
		endforeach;
	endif;
	?>
    '</select></td>'+
  	'<td width="20" align="center">=</td>'+
  	'<td width="60" align="center" class="fieldcell">'+
  	'<input id="satuan_sub_val_'+sat_row_id+'" name="satuan_sub_val[]" class="required satuan_sub_val number" type="text" size="10" title="Sub Unit Volume"></td>'+
  	'<td class="fieldcell">'+
  	'<select disabled="disabled" class="satuan_id2"><option value="0">--Select Unit--</option>'+
  	<?php 
	if ($list_satuan->num_rows()>0): 
  		foreach ($list_satuan->result() as $row_unit):
	?>
   	'<option value="<?php echo $row_unit->satuan_id?>" <?php echo (isset($satuan_id)&&($satuan_id == $row_unit->satuan_id))?('SELECTED'):('')?>><?php echo $row_unit->satuan_nama?></option>'+
    <?php 
    	endforeach;
    endif;
	?>
    '</select></td>'+
	'<td><INPUT TYPE="button" value="<?php echo $delunit?>" onclick="removeRowSatFromTable('+sat_row_id+')"></td>'+
    '</tr>';
   return row_content;
}

</script>

<table border="0" cellspacing="2" cellpadding="2">
<!--tr>
	<td width="80px" class="labelcell">Unit</td>
	<td valign="top">:</td>
	<td class="fieldcell">
		
	</td>
</tr-->
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><INPUT TYPE="button" value="<?php echo $addunit?>" onclick="addRowSatToTable();"></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>
		<table class="" width="80%" border="0" cellspacing="0" cellpadding="0" id="TblSatuan" >
		<?php 
		if($status=='edit'):
			if ($list_produk_satuan->num_rows() > 0):
				$i=1;
				foreach ($list_produk_satuan->result() as $data_unit):
					if ($satuan_id != $data_unit->satuan_unit_id):
		?>
		<tr id="sat_row_<?php echo $i?>">
			<td width="150" align="center" class="fieldcell">
				<select name="satuan_sub[]" id="satuan_sub" class="required select satuan_sub" title="Sub Unit"><option value="">--<?php echo $selunit?>--</option>
				<?php 
				if ($list_satuan->num_rows()>0):
					foreach ($list_satuan->result() as $row_unit):
				?>
			   		<option value="<?php echo $row_unit->satuan_id?>" <?php echo($data_unit->satuan_unit_id==$row_unit->satuan_id)?('SELECTED'):('')?>><?php echo $row_unit->satuan_nama?></option>
				<?php 
					endforeach;
			   	endif;
				?>
			   </select>
			</td>
			<td width="20" align="center">=</td>
			<td width="70" align="center" class="fieldcell"><input id="satuan_sub_val_<?php echo $i?>" name="satuan_sub_val[]" class="required satuan_sub_val number" type="text" size="10" value="<?php echo($status=='edit')?($data_unit->volume):('')?>" title="Sub Unit Volume"></td>
			<td class="fieldcell">
				<select disabled="disabled" class="satuan_id2">
					<option value="">--<?php echo $selunit?>--</option>
					<?php 
					if ($list_satuan->num_rows()>0):
						foreach ($list_satuan->result() as $row_unit):
					?>
					<option value="<?php echo $row_unit->satuan_id?>" <?php echo($data_unit->satuan_id==$row_unit->satuan_id)?('SELECTED'):('')?>><?php echo $row_unit->satuan_nama?></option>
					<?php 
						endforeach;
			   		endif;
					?>
				</select>
				</td>
			<td><INPUT TYPE="button" value="<?php echo $delunit?>" onclick="removeRowSatFromTable(<?php echo $i?>)"></td>
		</tr>
		<?php 
					$i++;
					endif;
				endforeach;
			endif;
		endif;
		?>
		</table>
	</td>
</tr>
</table>