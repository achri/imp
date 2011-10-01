<script type="text/javascript">		
function bersihkan() {
	$('form .form').val('');
	return false;
}

function unlocked() {
	$('form .form').attr('disabled',false);
	return false;
}

function locked() {
	$('form .form').attr('disabled','disabled');
	return false;
}

/* SET DEFAULT CONDITION */
function kondisi_awal(status) {
	$('#tambah').val("ADD");
	$('#ubah').val("EDIT");
	$('#tambah').show();
	$('#ubah, #jual_hapus, #jual_batal').hide();
	locked();
	grid_content.trigger('reloadGrid');
	
	if (status){
		bersihkan();
	}
		
	return false;
}

/* BIND EVENT SELECTED GRID */
function selrow() {
	$('#tambah, #ubah, #hapus').show();
	$('#tambah').val("ADD");
	$('#batal').hide();
	locked();
	
	return false;
}

/* ADD RECORD */
function tambah(status) {
	$('#ubah, #hapus').hide();
	$('#batal').show();
	
	if (status == "ADD"){
		bersihkan();
		unlocked();
		$('#new_password').attr('checked','checked');
		change_password();
		$('#tambah').val("SAVE");
	} else {
		if (validasi("form#form")) {
			/* POST AJAX */
		}
	}
	return false;
}

/* EDIT RECORD */
function jual(status) {
	$('#tambah, #hapus').hide();
	$('#batal').show();
	if (status == "EDIT"){
		unlocked();
		$('#ubah').val("UPDATE");
	} else {
		if (validasi("form#form")) {
			/* POST AJAX */
		}
	}
	return false;
}

/* DELETE RECORD */
function hapus() {
	var id = $('#id').val(),
		$dlg_btn = {
			"AGREE" : function() {
				/* POST AJAX */
				$(this).dialog('close');
			},
			"CANCEL" : function() {
				$(this).dialog('close');
			}
		};
		
	if (id) {
		konfirmasi("This User will be deleted ???",$dlg_btn);
	} 
	return false;
}

kondisi_awal(true);
</script>

<form id="form"> 
	<fieldset class="ui-widget-content ui-corner-all"> 
		<legend class="ui-corner-all ui-state-active">FORM</legend> 
		<table width="100%" class="ui-widget-content" border=0 style="border:0px"> 
			<tbody valign="top"> 
				<tr>
					<td>FIELD</td>
					<td>:</td>
					<td>
						<input class="form required number" type="text" name="field" id="field" title="field"/>
					</td>
				</tr>
				<tr><td colspan=7><hr></td></tr>
				<tr> 
					<td>
						<input onclick="tambah(this.value);" type="button" id="tambah" value="ADD" />
					</td>
					<td></td>
					<td>
						<input onclick="ubah(this.value);" type="button" id="ubah" value="EDIT" />
						<input onclick="hapus(this.value);" type="button" id="hapus" value="DELETE" />
						<input onclick="kondisi_awal();" type="button" id="batal" value="CANCEL" />
						<input type="reset" value="CLEAR" />
					</td> 
				</tr> 
			</tbody> 
		</table> 
	</fieldset> 
</form>