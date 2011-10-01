<?php 
if (isset($extraSubHeaderContent)) 
	echo $extraSubHeaderContent;

if (isset($page_title)) 
	echo content_title($page_title,$path_themes);
	
?>

<script language="javascript">
var usergrid_content = $("#newapi_user"),
	block_opt = {
		//message: 'Blocked',
		//theme: true,
		//draggable: false,
		//title: 'Loading',
		//forceIframe: true,
		//fadeIn:  0,
		//fadeOut:  0,
		//timeout: 0,
		//showOverlay: true,
		//focusInput: false,
		//quirksmodeOffsetHack: 4,
		//baseZ: 99999999
	}		

function user_bersihkan() {
	$('form .user_form').val('');
	$('#user_nama').focus();
	return false;
}

function user_unlocked() {
	$('form .user_form').attr('disabled',false);
	//$('div#menu_tree').unblock();
	return false;
}

function user_locked() {
	$('form .user_form').attr('disabled','disabled');
	$('.password').hide();
	$('.pwd').removeClass('required');
	$('#new_password').removeAttr('checked');
	//$('div#menu_tree').block(block_opt);
	return false;
}

/* SET DEFAULT CONDITION */
function user_kondisi_awal(status) {
	$('#user_tambah').val("<?php echo $btn_add?>");
	$('#user_ubah').val("<?php echo $btn_edit?>");
	$('#user_tambah').show();
	$('#user_ubah, #user_hapus, #user_batal').hide();
	user_locked();
	usergrid_content.trigger('reloadGrid');
	
	if (status){
		user_bersihkan();
	}
		
	return false;
}

/* BIND EVENT SELECTED GRID */
function user_selrow() {
	$('#user_tambah, #user_ubah, #user_hapus').show();
	$('#user_tambah').val("<?php echo $btn_add?>");
	$('#user_batal').hide();
	user_locked();
	
	// GET MENU
	var usr_id = $('#usr_id').val(),
		ucat_id = $('#ucat_id').val();
	if (usr_id) {
		user_tree_show(usr_id,ucat_id);	// WANT TO GET TREE FROM USER
		$.ajax({
			url: 'index.php/<?php echo $link_controller?>/get_user_menu/'+usr_id+'/'+ucat_id,
			type:'POST',
			success: function(data) {
				$('#menu').val(data);
			}
		});
		
		$('.pwd').val('');
	}
	
	return false;
}

function change_password() {
	var sel = $('input:checked').length;
	
	if (sel > 0) {
		$('.password').show();
		$('.pwd').addClass('required');
	} else {
		$('.password').hide();
		$('.pwd').removeClass('required');
	}
	return false;
}

/* ADD RECORD */
function tambah_user(status) {
	$('#user_ubah, #user_hapus').hide();
	$('#user_batal').show();
	
	if (status == "<?php echo $btn_add?>"){
		user_bersihkan();
		user_unlocked();
		$('#new_password').attr('checked','checked');
		change_password();
		$('#user_tambah').val("<?php echo $btn_save?>");
	} else {
		if (validasi("form#user_form")) {
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/tambah_user',
				type: 'POST',
				data: $('form#user_form').formSerialize(),
				success: function(data) {
					if (data) {
						user_kondisi_awal();
					} else {
						informasi("<?php echo $user_exist?>");
					}
				}
			});
		}
	}
	return false;
}

/* EDIT RECORD */
function ubah_user(status) {
	$('#user_tambah, #user_hapus').hide();
	$('#user_batal').show();
	if (status == "<?php echo $btn_edit?>"){
		user_unlocked();
		$('#user_ubah').val("<?php echo $btn_update?>");
	} else {
		if (validasi("form#user_form")) {
			$.ajax({
				url: 'index.php/<?php echo $link_controller?>/ubah_user',
				type: 'POST',
				data: $('form#user_form').formSerialize(),
				success: function(data) {
					if (data) {
						user_kondisi_awal();
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
function hapus_user() {
	var user_id = $('#usr_id').val(),
		ucat_id = $('#ucat_id').val(),
		user_cat = '<?php echo $this->session->userdata('ucat_id')?>';
		$dlg_btn = {
			"AGREE" : function() {
				$.ajax({
					url: 'index.php/<?php echo $link_controller?>/hapus_user/'+user_id+'/'+ucat_id+'/'+user_cat,
					type: 'POST',
					success: function(data) {
						$dlg_content.dialog('close');
						user_kondisi_awal(true);
					}
				});	
			},
			"CANCEL" : function() {
				$(this).dialog('close');
			}
		};
		
	if (user_id) {
		konfirmasi("<?php echo $user_delete?>",$dlg_btn);
	} 
	return false;
}

function user_tree_show(usr_id,ucat_id) {
	if (!usr_id)
		usr_id = 0;
		
	$.ajax({
		url: 'index.php/<?php echo $link_controller?>/get_menu_tree/'+usr_id+'/'+ucat_id,
		type:'POST',
		success: function (data) {
			$('#menu_tree').html(data);
		}
	});
	return false;
}

user_kondisi_awal(true);
user_tree_show();

</script>

<table width="100%">
<tr>
	<td width="48%"><?php $this->load->view($link_view.'/user_form_view')?></td>
	<td width="48%" align="center" valign="top"><?php $this->load->view($link_view.'/user_grid_view')?></tr>
</tr>
</table>