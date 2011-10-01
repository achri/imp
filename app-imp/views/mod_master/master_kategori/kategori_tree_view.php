<script type="text/javascript">
$(document).ready(function() {

	var treedata_content = jQuery("#newapi<?php echo $grid['gridname'];?>"),
		lastsel;
		
	dtgLoadButton();
	
	var tree = treedata_content.jqGrid({
		ajaxGridOptions : {
			type:"POST"
		},
		jsonReader : {
			root:"data",
			repeatitems: false
		},
		autowidth: true,
		loadError :function(xhr,status, err){ 
			try {
				jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class="ui-state-error">'+ xhr.responseText +'</div>', jQuery.jgrid.edit.bClose,{buttonalign:'right'});
			} 
			catch(e) { alert(xhr.responseText);} 
		},
		ExpandColClick: true,
        treeIcons: {leaf:'ui-icon-document-b'},
		treeGrid: true,
		caption: "jqGrid Demos",
        ExpandColumn: "menu",
		pager: false,
        loadui: "disable",
		onSelectRow: function(rowid) {
            var treedata = treedata_content.jqGrid('getRowData',rowid);
            if(treedata.isLeaf=="true") {
                //treedata.url
                /*
				var st = "#t"+treedata.id;
				if($(st).html() != null ) {
					maintab.tabs('select',st);
				} else {
					maintab.tabs('add',st, treedata.menu);
					$(st,"#tabs").load(treedata.url);
				}
				*/
            }
        }
		/*
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
		onSelectRow: function(id){
			if(id && id!==lastsel){ 
				grid_content.jqGrid('restoreRow',lastsel); 
				grid_content.jqGrid('editRow',id,true); 
				lastsel=id; 
			} 
		}
		*/
		<?php echo $grid['table'];?>
	})
	<?php echo $grid['pager'];?>;
});
</script>

<div align="center">
<table id="newapi<?php echo $grid['gridname'];?>"></table>
<div id="pnewapi<?php echo $grid['gridname'];?>"></div>
</div>
