<script type="text/javascript">	
$(document).ready(function() {
	var histgrid = histgrid_content.jqGrid({
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
			
			return;
		},
		onSelectRow:function(id) {	
			var gsr = histgrid_content.jqGrid('getGridParam','selrow'); 
			
			return;
		},
		ondblClickRow: function(id){
			
			return;
		},
		colModel: [ 
			{name:"inv_id",key:true,hidden:true},
			{name:"inv_tgl",label:"Date",width:100,align:"center",formatter:'date',formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d-M-Y H:i:s"},searchoptions:{dataInit:function(el){$(el).datepicker({dateFormat:'yy-mm-dd'});} }},
			{name:"inv_mulai",label:"Begin",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}},
			{name:"inv_masuk",label:"In",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}},
			{name:"inv_keluar",label:"Out",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}},
			{name:"inv_akhir",label:"End",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}},
			{name:"inv_hrg_beli",label:"@Buying",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"inv_hrg_jual",label:"@Selling",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"inv_dokumen",label:"Document",width:80, align:'center'},
			{name:"usr_nama",label:"User",width:120},
		],
		url:"<?php echo site_url($link_controller)?>/get_data/inv_history",    
		pager: "#pnewapi_history", 
		sortname: 'inv_tgl', 
		sortorder: "DESC",
		datatype:'json',
		rowNum:'5',
		rowList:[5,10,20],
		rownumbers:true,
		hiddengrid:false,
		autowidth:true,
		forceFit:true,
		//viewsortcols:true,
		sortable:true,
		shrinkToFit:true,
		viewrecords:true,
		//scroll:true,
		//scrollrows:true,
		//footerrow:true,
		//userDataOnFooter:true,
		//toolbar: [true,'bottom'],
		height:'100%',
		caption:'INVENTORY HISTORY'
	});
	
	histgrid_content.jqGrid('navGrid',"#pnewapi_history",{view:false,edit:false, add:false,del:false,search:false,refresh:false},
		{closeAfterEdit:true,mtype: 'POST'},
		{closeAfterAdd:true,mtype: 'POST'}, 
		{mtype: 'POST'}, 
		{
			//odata : ['=', '!=', '<', '<=','>','>=', 'begins with','ends with','contains' ],
			sopt:['eq','cn','ge','le'],
			overlay:false,mtype: 'POST'
		}
	);
	
	histgrid_content.jqGrid('navButtonAdd',"#pnewapi_history",
		{
			caption:"Search",
			title:"Toggle Search Toolbar", 
			buttonicon :'ui-icon-pin-s', 
			onClickButton:function(){ 
				histgrid_content[0].toggleToolbar() 
			}
		}
	);
	
	histgrid_content.jqGrid('navButtonAdd',"#pnewapi_history",
		{
			caption:"Refresh",
			title:"Clear Search",
			buttonicon :'ui-icon-refresh', 
			onClickButton:function(){ 
				histgrid_content[0].clearToolbar() 
			} 
		}
	);
	
	histgrid_content.jqGrid('filterToolbar',
		{stringResult: true,searchOnEnter : false}
	)[0].toggleToolbar();
	
	var histtb = $("#t_newapi_produk"),
		t_histtb = "";
		
	histtb.append(t_histtb);//.addClass('ui-priority-secondary');
	
	// HIDE FIELD
	jQuery("#gs_kat_nama,#gs_act").hide();
});
</script>

<table id="newapi_history"></table>
<div id="pnewapi_history"></div>
