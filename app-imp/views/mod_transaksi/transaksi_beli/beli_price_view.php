<script type="text/javascript">	
$(document).ready(function() {
	var pricegrid = pricegrid_content.jqGrid({
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
			var ids = pricegrid_content.jqGrid('getDataIDs'); 
			for(var i=0;i < ids.length;i++){ 
				var cl = ids[i]; 
				be = "<a alt='Add' style='cursor:pointer' onclick=\"tambah_beli('"+cl+"');\" class='ui-icon ui-icon-cart'></a>"; 
				pricegrid_content.jqGrid('setRowData',ids[i],{act:be}); 
			} 
			return;
		},
		onSelectRow:function(id) {	
			var gsr = pricegrid_content.jqGrid('getGridParam','selrow'); 
			
			return;
		},
		ondblClickRow: function(id){
			
			return;
		},
		colModel: [ 
			{name:"inv_id",key:true,hidden:true},
			{name:"inv_tgl",label:"Date",width:70,align:"center",formatter:'date',formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d-M-Y H:i:s"}},
			{name:"inv_dokumen",label:"Document",width:60,align:'center'},
			{name:"inv_hrg_beli",label:"@Buying",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			//{name:"inv_hrg_jual",label:"@Selling",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			
			/*
			{name:"beli_tgl",label:"Date",width:70,align:"center",formatter:'date',formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d-M-Y H:i:s"}},
			*/
		],
		url:"<?php echo site_url($link_controller)?>/get_data/price",    
		postData:{"produk_id": 0},
		//pager: "#pnewapi_price", 
		sortname: 'inv_tgl', 
		sortorder: "DESC",
		datatype:'json',
		rowNum:'2',
		rowList:[2],
		rownumbers:true,
		hiddengrid:false,
		autowidth:true,
		forceFit:true,
		//scroll:true,
		//scrollrows:true,
		//viewsortcols:true,
		sortable:true,
		shrinkToFit:true,
		viewrecords:true,
		//toolbar: [true,'bottom'],
		//footerrow:true,
		//userDataOnFooter:true,
		height:'100%',
		caption:'LAST PRICE PRODUCT'
	});
	
	pricegrid_content.jqGrid('navGrid',"#pnewapi_price",{view:true,edit:false, add:false,del:false,search:true,refresh:true},
		{closeAfterEdit:true,mtype: 'POST'},
		{closeAfterAdd:true,mtype: 'POST'}, 
		{mtype: 'POST'}, 
		{
			//odata : ['=', '!=', '<', '<=','>','>=', 'begins with','ends with','contains' ],
			sopt:['eq','cn','ge','le'],
			overlay:false,mtype: 'POST'
		}
	);
	
	var protb = $("#t_newapi_price"),
		t_protb = "";
		
	protb.append(t_protb);//.addClass('ui-priority-secondary');
});
</script>

<table id="newapi_price"></table>
<div id="pnewapi_price"></div>

<BR>
