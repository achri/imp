<script type="text/javascript">
$(document).ready(function() {
	var kelas_kode,kelas_del;
	dtgLoadButton();
	
	var kelasgrid = kelasgrid_content.jqGrid({
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
			kelasgrid.editGridRow(id, {
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
		postData: {'kat_level': 2},
		loadComplete: function() {
			var kat_id = katgrid_content.getGridParam('selrow'); 
			if (kat_id > 0) {
				$.ajax({
					url: 'index.php/<?php echo $link_controller;?>/set_kat_kode/kelas/'+kat_id,
					type: 'POST',
					success: function(data) {
						if (data) { 
							kelas_kode = data;
						}
					}
				});
			}
		},
		onSelectRow: function(kelas_id){
			var kelas_nama = kelasgrid_content.getRowData(kelas_id).kat_nama;			
			if(kelas_id == null) {
				kelas_id=0;
				if(grupgrid_content.jqGrid('getGridParam','records') > 0 )
				{
					grupgrid_content.jqGrid('setGridParam',{
						url:"<?php echo site_url($link_controller);?>/get_data/"+kelas_id,
						postData:{"kat_master": kelas_id},
						page:1,
					});
					grupgrid_content.jqGrid('setCaption',"<?php echo $group_grid .' '.$of_grid?> ( "+kelas_nama+" )")
					.trigger('reloadGrid');
				}
			} else {				
				grupgrid_content.jqGrid('setGridParam',{
					url:"<?php echo site_url($link_controller);?>/get_data/"+kelas_id,
					postData:{"kat_master": kelas_id},
					page:1,
				});
				grupgrid_content.jqGrid('setCaption',"<?php echo $group_grid .' '.$of_grid?> ( "+kelas_nama+" )")
				.trigger('reloadGrid');			
			}
		}
		<?php echo $kelas_grid['table'];?>
	});
	
	/* NAV BUTTON */
	kelasgrid_content.jqGrid('navGrid',
		'#pnewapi<?php echo $kelas_grid['gridname'];?>',
		{view:false,edit:false, add:true,del:true,search:false,refresh:false},
		{closeAfterEdit:true,mtype: 'POST'}/*edit options*/,
		{closeAfterAdd:true,mtype: 'POST',
			beforeSubmit: function(id) {
				var retarr = {}; 
				var kat_id = katgrid_content.getGridParam('selrow'); 
				if(!kat_id > 0) { 
					return [false,"<?php echo $category_sel?>"];
				}else {
					return [true];
				}
			},
			onclickSubmit: function(eparams) {
				var retarr = {}; 
				var kat_id = katgrid_content.getGridParam('selrow'); 
				if(kat_id > 0) { 
					retarr = {"kat_kode":kelas_kode,"kat_master":kat_id,"kat_level":2};
				}
				return retarr;
			}
		} /*add options*/,
		{mtype: 'POST',
			beforeSubmit: function(id) {
				return cek_hapus_kategori('kelas',id);
			}
		} /*delete options*/,
		{sopt:['eq','cn','ge','le'],overlay:false,mtype: 'POST'}/*search options*/
	);
	<?php echo $kelas_grid['showsearch'];?>;
});

</script>

<table id="newapi<?php echo $kelas_grid['gridname'];?>"></table>
<div id="pnewapi<?php echo $kelas_grid['gridname'];?>"></div>
