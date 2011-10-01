<?php if (isset($extraSubHeaderContent)) 
	echo $extraSubHeaderContent;?>
<script type="text/javascript">
$(document).ready(function() {
	var grid_content = $("#newapi_jual");
	
	var grid = grid_content.jqGrid({
		ajaxGridOptions : {
			type:"POST"
		},
		jsonReader : {
			root:"data",
			repeatitems: false
		},
		ondblClickRow: function(id){
			
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
		onSelectRow: function(pro_id){	
			
		},
		gridComplete: function() {
			// SET QUERY SESSION PRINT
			$.post("<?php echo site_url($link_controller)?>/cetak_session/grid");
		},
		colModel: [ 
			{name:"jual_id",key:true,hidden:true},
			{name:"jual_tgl",label:"Date",width:70,align:"center",formatter:'date',formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d-M-Y H:i:s"},searchoptions:{dataInit:function(el){$(el).datepicker({dateFormat:'yy-mm-dd'});} }},
			{name:"jual_no",label:"Document",width:70,align:"center"},
			{name:"jual_tot_jml",label:"Tot.Qty",width:70,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}}, 
			{name:"jual_tot_hrg",label:"Tot.Price",width:70,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			//{name:"jual_tot_bayar",label:"Paying",width:70,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"jenis_transaksi",label:"Type",width:40,align:"center"},
			{name:"usr_nama",label:"User",width:70,align:"left"}
		],
		url:"<?php echo site_url($link_controller)?>/get_data/trans",  
		pager: 'pnewapi_jual', 
		sortname: 'jual_tgl', 
		sortorder: "DESC",
		viewrecords: true,
		datatype:'json',
		rowNum:'10',
		rowList:[5,10,20,50],
		rownumbers:true,
		hiddengrid:false,
		autowidth:true,
		height:'auto',
		caption:'List Selling Transaction',
				
		multiselect: false,
		subGrid: true,
		subGridRowExpanded: function(subgrid_id, row_id) { 			
			var subgrid_table_id, 
				pager_id; 
				subgrid_table_id = subgrid_id+"_t"; 
				pager_id = "p_"+subgrid_table_id; 
				
			$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>"); 
				
			jQuery("#"+subgrid_table_id).jqGrid({ 
				url:"<?php echo site_url($link_controller)?>/get_data/hist/"+row_id,  
				colModel: [ 
					{name:"jual_id",hidden:true},
					{name:"produk_kode",label:"Code",width:50,align:"center"},
					{name:"kat_id",label:"Category",width:100,align:"left"},
					{name:"produk_nama",label:"Product",width:100,align:"left"},
					{name:"prosat",label:"Unit",width:30,align:"center"},
					{name:"reqsat",label:"(Unit)",width:30,align:"center"},
					{name:"jumlah",label:"Qty",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}}, 
					{name:"jumlah_multi",label:"(Qty)",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}}, 
					{name:"diskon",label:"Disc (%)",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}}, 
					{name:"tot_diskon",label:"Disc (Rp)",width:70,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
					{name:"harga",label:"Price",width:70,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
					{name:"tot_harga",label:"Total",width:70,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
					{name:"kat_nama",hidden:true},
				],
				jsonReader : {
					root:"data",
					repeatitems: false
				},
				pager: pager_id, 
				sortname: 'produk_kode', 
				sortorder: "asc",
				viewrecords: true,
				loadError :function(xhr,status, err){ 
					try {
						jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class="ui-state-error">'+ xhr.responseText +'</div>', jQuery.jgrid.edit.bClose,{buttonalign:'right'});
					} 
					catch(e) { alert(xhr.responseText);} 
				},
				gridComplete: function(){ 
					var ids = jQuery("#"+subgrid_table_id).jqGrid('getDataIDs'); 
					for(var i=0;i < ids.length;i++){ 
						var cl = ids[i], 
							kat_nama = jQuery("#"+subgrid_table_id).jqGrid('getRowData',ids[i]).kat_nama; 
						jQuery("#"+subgrid_table_id).jqGrid('setRowData',ids[i],{kat_id:kat_nama}); 	
					} 
					
					// SET QUERY SESSION PRINT
					$.post("<?php echo site_url($link_controller)?>/cetak_session/detail/"+row_id);
					return;
				},
				datatype:'json',
				rowNum:'10',
				rowList:[5,10,20,50],
				rownumbers:true,
				hiddengrid:false,
				autowidth:true,
				footerrow:true,
				userDataOnFooter:true,
				height:'100%',
				//toolbar : [true,"top"],
				//caption:'List Buying Transaction History'
			}); 
			
			jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,
				{view:false,edit:false,add:false,del:false,refresh:false,search:false},
				{closeAfterEdit:true,reloadAfterSubmit:true,mtype: 'POST'},
				{closeAfterAdd:true,reloadAfterSubmit:true,mtype: 'POST'},
				{reloadAfterSubmit:true,mtype: 'POST'},
				{sopt:['eq','cn','ge','le'], overlay:false,mtype: 'POST'}
			); 
			
			/* GRID TOOLBAR 
			jQuery("#t_"+subgrid_table_id).height(25).hide().jqGrid('filterGrid',subgrid_table_id,
				{gridModel:true,gridToolbar:true}
			);
			
			jQuery("#sg_kat_id, #sg_tot_harga").hide();
			
			jQuery("#"+subgrid_table_id).jqGrid('navButtonAdd',"#"+pager_id,
				{caption:"Search",
					title:"Toggle Search", 
					onClickButton:function(){ 
						if(jQuery("#t_"+subgrid_table_id).css("display")=="none") { 
							jQuery("#t_"+subgrid_table_id).css("display",""); 
						} else { 
							jQuery("#t_"+subgrid_table_id).css("display","none"); 
						} 
					}
				}
			);
				
			*/
			jQuery("#"+subgrid_table_id).jqGrid('navButtonAdd',
				"#"+pager_id,
				{
					caption:"Print",
					title:"Print",
					buttonicon :'ui-icon-print', 
					onClickButton:function(){ 
						//var jual_id = jQuery("#"+subgrid_table_id).getGridParam('selrow'); 
						if (row_id) {
							var url = '<?php echo site_url($link_controller);?>/cetak_detail/'+row_id;
							//window.open(url,'_Blank');
							open(url,'Win1','toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width=800,height=600,left=30,top=30');
							
						}else {
							informasi("Select transaction first !!!");
						}
						return false;
					} 
				}
			);
			
			
			jQuery("#"+subgrid_table_id)
				.jqGrid('navButtonAdd',
				'#'+pager_id,
				{
					caption:"Search",
					title:"Toggle Search Toolbar",
					buttonicon :'ui-icon-pin-s', 
					onClickButton:function(){ 
						jQuery("#"+subgrid_table_id)[0].toggleToolbar() 
					} 
				}
			);
			
			jQuery("#"+subgrid_table_id)
				.jqGrid('navButtonAdd',
				'#'+pager_id,
				{
					caption:"Clear",
					title:"Clear Search",
					buttonicon :'ui-icon-refresh', 
					onClickButton:function(){ 
						jQuery("#"+subgrid_table_id)[0].clearToolbar() 
					} 
				}
			); 
			jQuery("#"+subgrid_table_id).jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false})[0].toggleToolbar();
			jQuery("#gs_kat_id, #gs_prosat, #gs_reqsat, #gs_jumlah, #gs_tot_jumlah, #gs_harga, #gs_tot_harga").hide();
		}, 
		subGridRowColapsed: function(subgrid_id, row_id) { 
			var subgrid_table_id; 
			subgrid_table_id = subgrid_id+"_t"; 
			jQuery("#"+subgrid_table_id).remove(); 
		}
		
	});
	
	grid_content.jqGrid('navGrid',"#pnewapi_jual",
		{view:false,edit:false,add:false,del:false,refresh:false,search:false},
		{closeAfterEdit:true,reloadAfterSubmit:true,mtype: 'POST'},
		{closeAfterAdd:true,reloadAfterSubmit:true,mtype: 'POST'},
		{reloadAfterSubmit:true,mtype: 'POST'},
		{sopt:['eq','cn','ge','le'], overlay:false,mtype: 'POST'}
	);
	
	grid_content.jqGrid('navButtonAdd',
		"#pnewapi_jual",
		{
			caption:"Print",
			title:"Print",
			buttonicon :'ui-icon-print', 
			onClickButton:function(){
				var url = '<?php echo site_url($link_controller);?>/cetak';
				open(url,'Win1','toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,copyhistory=0,width=900,height=600,left=30,top=30');
				return false;
			} 
		}
	);
	
	grid_content.jqGrid('navButtonAdd',
		"#pnewapi_jual",
		{
			caption:"Search",
			title:"Toggle Search Toolbar",
			buttonicon :'ui-icon-pin-s', 
			onClickButton:function(){ 
				grid_content[0].toggleToolbar() 
			} 
		}
	);
			
	grid_content
		.jqGrid('navButtonAdd',
		"#pnewapi_jual",
		{
			caption:"Clear",
			title:"Clear Search",
			buttonicon :'ui-icon-refresh', 
			onClickButton:function(){ 
				grid_content[0].clearToolbar() 
			} 
		}
	); 
	grid_content.jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false})[0].toggleToolbar();
	//jQuery("#gs_kat_id, #gs_prosat, #gs_reqsat, #gs_jumlah, #gs_tot_jumlah, #gs_harga, #gs_tot_harga").hide();
	
});
</script>

<table id="newapi_jual"></table>
<div id="pnewapi_jual"></div>
