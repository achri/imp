<script type="text/javascript">	
var grid_content = jQuery("#newapi"),
		lastsel,jual_ids;
$(document).ready(function() {
	var grid = grid_content.jqGrid({
		ajaxGridOptions : {
			type:"POST"
		},
		jsonReader : {
			root:"data",
			repeatitems: false
		},
		loadError :function(xhr,status, err){ 
			try {
				jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class="ui-state-error">'+ xhr.responseText +'</div>', jQuery.jgrid.edit.bClose,{buttonalign:'right'});
			} 
			catch(e) { alert(xhr.responseText);} 
		},
		loadComplete: function() {
			
			return;
		},
		gridComplete: function(){ 
			// FOR GET ALL ID IN GRID
			var ids = grid_content.jqGrid('getDataIDs'); 
			for(var i=0;i < ids.length;i++){ 
				var cl = ids[i],
					// FOR GET DATA IN FIELD BY ID
					data = grid_content.getRowData(cl).field_name;
				button_extra = "<input type='button' value='Button Extra'/>"; 
				
				// FOR SET DATA IN ROW
				grid_content.jqGrid('setRowData',ids[i],{field1:button_extra,field2:data});
			} 
			return;
		},
		onSelectRow:function(id) {	
			// FOR GET ID IN SEL ROW
			var gsr = grid_content.jqGrid('getGridParam','selrow'); 
			
			// FOR CONVERT GRID RECORD TO FORM
			grid_content.jqGrid('GridToForm',gsr,"form_id"); 
			
			// FOR CHANGE DATA IN ROW
			grid_content.setColProp('field',{editoptions:{value:"data"}});	
			
			// FOR RESTORE ROW IF CANCEL
			grid_content.jqGrid('restoreRow',lastsel); 
			
			// FOR EDIT ROW
			grid_content.jqGrid('editRow',id,true,
				function(){ 
							
					return true; 
				} /* on edit */,
				function(){
					// REFRESH GRID DATA
					grid_content.trigger('reloadGrid');
					return true;
				} /* sukses func */
			); 
			return;
		},
		ondblClickRow: function(id){
			return;
		},
		colModel: [ 
			{name:"produk_id",key:true,hidden:true},
			{name:"produk_kode",label:"Code"},
			{name:"produk_nama",label:"Product"},
			{name:"satuan_id",label:"Unit"},
			{name:"inv_akhir",label:"Stock"},
			{name:"jumlah",label:"Qty"},
			{name:"diskon",label:"Disc"},
			{name:"tot_harga",label:"Price"},
			/*
			{name:"jual_tgl",label:"Date",width:70,align:"center",formatter:'date',formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d-M-Y H:i:s"}},
			{name:"jual_no",label:"No",width:70,align:"center"},
			{name:"jual_tot_jml",label:"Qty",width:70,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}}, 
			{name:"jual_tot_hrg",label:"Price",width:70,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"jual_tot_bayar",label:"Paying",width:70,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			*/
		],
		url:"<?php echo site_url($link_controller)?>/get_data",  
		editUrl:"<?php echo site_url($link_controller)?>/set_data",  
		pager: "#pnewapi", 
		//sortname: 'jual_tgl', 
		//sortorder: "ASC",
		datatype:'json',
		rowNum:'10',
		rowList:[5,10,20],
		rownumbers:true,	// NUMBERING ROW
		hiddengrid:false,	// HIDE GRID
		autowidth:true,
		footerrow : true,
		userDataOnFooter : true,
		shrinkToFit : true,
		viewrecords: true,	// SEE PAGINATION RECORD TOTAL
		autowidth: true,
		height:'100%',
		caption:'JQGRID',
		toolbar: [true,"bottom"],
	});
	
	
	
	var toolbar = jQuery("#t_newapi"),
		t_content = "CONTENT";
		
	toolbar.append(t_content).addClass('ui-priority-secondary');
});
</script>

<table id="newapi"></table>
<div id="pnewapi"></div>


