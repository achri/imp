<script type="text/javascript">
$(document).ready(function() {
	var grup_kode,grup_del;
	dtgLoadButton();
	
	var grupgrid = grupgrid_content.jqGrid({
		ajaxGridOptions : {
			type:"POST"
		},
		jsonReader : {
			root:"data",
			repeatitems: false
		},
		ondblClickRow: function(id){
			var gridwidth = kelasgrid_content.width();
			
			gridwidth = gridwidth / 2;
			grupgrid.editGridRow(id, {
				closeAfterEdit:true,
				mtype:'POST'
			});
			return;
		},
		viewrecords: true,
		autowidth: true,
		loadError :function(xhr,status, err){ 
			try {
				jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class="ui-state-error">'+ xhr.responseText +'</div>', jQuery.jgrid.edit.bClose,{buttonalign:'right'});
			} 
			catch(e) { alert(xhr.responseText);} 
		},
		postData: {'kat_level': 3},
		loadComplete: function() {
			var kelas_id = kelasgrid_content.getGridParam('selrow'); 
			if (kelas_id > 0) {
				$.ajax({
					url: 'index.php/<?php echo $link_controller;?>/set_kat_kode/grup/'+kelas_id,
					type: 'POST',
					success: function(data) {
						if (data) { 
							grup_kode = data;
						}
					}
				});
			}
		},
		onSelectRow: function(grup_id){
			
		}
		<?php echo $grup_grid['table'];?>
	});
	
	/* NAV BUTTON */
	grupgrid_content.jqGrid('navGrid',
		'#pnewapi<?php echo $grup_grid['gridname'];?>',
		{view:false,edit:false, add:true,del:true,search:false,refresh:false},
		{closeAfterEdit:true,mtype: 'POST'}/*edit options*/,
		{closeAfterAdd:true,mtype: 'POST',
			beforeSubmit: function(id) {
				var retarr = {}; 
				var kelas_id = kelasgrid_content.getGridParam('selrow'); 
				if(!kelas_id > 0) { 
					return [false,"<?php echo $class_sel?>"];
				}else {
					return [true];
				}
			},
			onclickSubmit: function(eparams) {
				var retarr = {}; 
				var kelas_id = kelasgrid_content.getGridParam('selrow'); 
				if(kelas_id > 0) { 
					retarr = {"kat_kode":grup_kode,"kat_master":kelas_id,"kat_level":3};
				}
				return retarr;
			}
		} /*add options*/,
		{mtype: 'POST',
			beforeSubmit: function(id) {
				return cek_hapus_kategori('grup',id);
			}
		} /*delete options*/,
		{sopt:['eq','cn','ge','le'],overlay:false,mtype: 'POST'}/*search options*/
	);
	<?php echo $grup_grid['showsearch'];?>;
});

</script>

<table id="newapi<?php echo $grup_grid['gridname'];?>"></table>
<div id="pnewapi<?php echo $grup_grid['gridname'];?>"></div>
