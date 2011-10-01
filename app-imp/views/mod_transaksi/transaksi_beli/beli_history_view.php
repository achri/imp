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
			{name:"beli_id",key:true,hidden:true},
			{name:"beli_tgl",label:"Date",width:70,align:"center",formatter:'date',formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d-M-Y H:i:s"},searchoptions:{dataInit:function(el){$(el).datepicker({dateFormat:'yy-mm-dd'});} }},
			{name:"beli_no",label:"Document",width:120, align:'center'},
			{name:"beli_tot_jml",label:"Tot.Qty",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}},
			{name:"beli_tot_hrg",label:"Tot.Price",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"usr_nama",label:"User",width:120},
			/*
			
			*/
		],
		url:"<?php echo site_url($link_controller)?>/get_data/history",    
		pager: "#pnewapi_history", 
		sortname: 'beli_tgl', 
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
		caption:'BUYING HISTORY'
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
});
</script>

<table id="newapi_history"></table>
<div id="pnewapi_history"></div>
