<script type="text/javascript">
$(document).ready(function() {	
	var kat_kode,kat_del;
	dtgLoadButton();
	
	var katgrid = katgrid_content.jqGrid({
		ajaxGridOptions : {
			type:"POST"
		},
		jsonReader : {
			root:"data",
			repeatitems: false
		},
		ondblClickRow: function(id){
			var gridwidth = katgrid_content.width();
			
			gridwidth = gridwidth / 2;
			katgrid.editGridRow(id, {
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
		postData: {'kat_level': 1},
		loadComplete: function() {
			$.ajax({
				url: 'index.php/<?php echo $link_controller;?>/set_kat_kode/kategori/0',
				type: 'POST',
				success: function(data) {
					if (data) { 
						kat_kode = data;
					}
				}
			});
		},
		onSelectRow: function(kat_id){
			var kat_nama = katgrid_content.getRowData(kat_id).kat_nama;			
			if(kat_id == null) {
				kat_id=0;
				if(kelasgrid_content.jqGrid('getGridParam','records') > 0 )
				{
					kelasgrid_content.jqGrid('setGridParam',{
						url:"<?php echo site_url($link_controller);?>/get_data/"+kat_id,
						postData:{"kat_master": kat_id},
						page:1,
					});
					kelasgrid_content.jqGrid('setCaption',"<?php echo $class_grid .' '.$of_grid?> ( "+kat_nama+" )")
					.trigger('reloadGrid');
					
					grupgrid_content.jqGrid('setGridParam',{
						url:"<?php echo site_url($link_controller);?>/get_data/",
						postData:{"kat_master": "99"},
						page:1,
					});
					grupgrid_content.jqGrid('setCaption',"<?php echo $group_grid?>")
					.trigger('reloadGrid');
				}
			} else {				
				kelasgrid_content.jqGrid('setGridParam',{
					url:"<?php echo site_url($link_controller);?>/get_data/"+kat_id,
					postData:{"kat_master": kat_id},
					page:1,
				});
				kelasgrid_content.jqGrid('setCaption',"<?php echo $class_grid .' '.$of_grid?> ( "+kat_nama+" )")
				.trigger('reloadGrid');		

				grupgrid_content.jqGrid('setGridParam',{
						url:"<?php echo site_url($link_controller);?>/get_data/",
						postData:{"kat_master": "99"},
						page:1,
					});
					grupgrid_content.jqGrid('setCaption',"<?php echo $group_grid?>")
					.trigger('reloadGrid');
			}
			
		}
		<?php echo $kategori_grid['table'];?>
	});
	<?php //echo $kategori_grid['pager'];?>;
	
	/* NAV BUTTON */
	katgrid_content.jqGrid('navGrid',
		'#pnewapi<?php echo $kategori_grid['gridname'];?>',
		{view:false,edit:false, add:true,del:true,search:false,refresh:false},
		{closeAfterEdit:true,mtype: 'POST'}/*edit options*/,
		{closeAfterAdd:true,mtype: 'POST',
			onclickSubmit: function(eparams) {
				var retarr = {}; 
				retarr = {"kat_kode":kat_kode};
				return retarr;
			}
		} /*add options*/,
		{mtype: 'POST',
			beforeSubmit: function(id) {
				return cek_hapus_kategori('kategori',id);
			}
		} /*delete options*/,
		{sopt:['eq','cn','ge','le'],overlay:false,mtype: 'POST'}/*search options*/
	);
	<?php echo $kategori_grid['showsearch'];?>;
});
</script>

<table id="newapi<?php echo $kategori_grid['gridname'];?>"></table>
<div id="pnewapi<?php echo $kategori_grid['gridname'];?>"></div>
