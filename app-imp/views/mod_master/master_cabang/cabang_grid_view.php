<script type="text/javascript">
$(document).ready(function() {

	var grid_content = jQuery("#newapi<?php echo $grid['gridname'];?>"),
		lastsel;
		
	dtgLoadButton();
	
	var grid = grid_content.jqGrid({
		ajaxGridOptions : {
			type:"POST"
		},
		jsonReader : {
			root:"data",
			repeatitems: false
		},
		ondblClickRow: function(id){
			var gridwidth = grid_content.width();
			
			gridwidth = gridwidth / 2;
			grid.editGridRow(id, {
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
		onSelectRow: function(id){
			if(id && id!==lastsel){ 
				grid_content.jqGrid('restoreRow',lastsel); 
				grid_content.jqGrid('editRow',id,true); 
				lastsel=id; 
			} 
		},
		gridComplete: function(){ 
			var ids = grid_content.jqGrid('getDataIDs'); 
			for(var i=0;i < ids.length;i++){ 
				var cl = ids[i],
					legal_nama = grid_content.getRowData(cl).legal_nama;
				grid_content.jqGrid('setRowData',ids[i],{legal_id:legal_nama});
			} 
			
		}
		<?php echo $grid['table'];?>
	})
	<?php echo $grid['pager'];?>;
});
</script>

<div align="center">
<table id="newapi<?php echo $grid['gridname'];?>"></table>
<div id="pnewapi<?php echo $grid['gridname'];?>"></div>
</div>
