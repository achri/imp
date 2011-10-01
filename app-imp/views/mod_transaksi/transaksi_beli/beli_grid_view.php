<script type="text/javascript">	

function switch_cabang(val) {
	progrid_content.jqGrid('setGridParam',{
		url:"<?php echo site_url($link_controller);?>/get_data",
		postData:{"cb_id": val},
		page:1,
	});
	progrid_content.trigger('reloadGrid');
	return false;
}

$(document).ready(function() {
	var progrid = progrid_content.jqGrid({
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
			var ids = progrid_content.jqGrid('getDataIDs'),
				arrPng = new Array('030.png','012.png','014.png','011.png');
				//arrIcon = new Array('ui-icon ui-icon-circle-arrow-n','ui-icon ui-icon-circle-arrow-s'),
				//arrStat = new Array('in','out');
			for(var i=0;i < ids.length;i++){ 
				var cl = ids[i],
					stats = progrid_content.getRowData(cl).status_item;
				stats = "<img src='<?php echo base_url()?>/asset/images/icons/modern/"+arrPng[stats]+"' width='10' height='10'/>";
				//stats = "<a class='"+arrIcon[stats]+"'></a>";
				//stats = arrstat[stats];
				be = "<a alt='Add' style='cursor:pointer' onclick=\"tambah_beli('"+cl+"');\" class='ui-icon ui-icon-cart'></a>"; 
				progrid_content.jqGrid('setRowData',ids[i],{act:be,status_item:stats}); 
			} 
			return;
		},
		onSelectRow:function(produk_id) {	
			//var gsr = progrid_content.jqGrid('getGridParam','selrow'); 
			var produk_nama = progrid_content.getRowData(produk_id).produk_nama;			
			//if( pricegrid_content.jqGrid('getGridParam','records') > 0 )
			//{
				pricegrid_content.jqGrid('setGridParam',{
					url:"<?php echo site_url($link_controller);?>/get_data/price",
					postData:{"produk_id": produk_id},
					page:1,
				});
				pricegrid_content.jqGrid('setCaption',"LAST PRICE PRODUCT ( "+produk_nama+" )")
				.trigger('reloadGrid');
			//}
			return;
		},
		ondblClickRow: function(id){
			
			return;
		},
		colModel: [ 
			{name:"produk_id",key:true,hidden:true},
			{name:"produk_kode",label:"Code",width:60,align:'center'},
			{name:"kat_nama",label:"Category",width:200},
			{name:"produk_nama",label:"Product",width:150},
			{name:"status_item",label:"@",width:20,align:'center'},
			{name:"inv_akhir",label:"Stock",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}},
			{name:"inv_hrg_beli",label:"@Buying",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			//{name:"inv_hrg_jual",label:"@Selling",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"inv_dokumen",label:"Document",width:60,align:"center"},
			{name:"act",label:"Add",width:20,align:'center'},
			/*
			{name:"beli_tgl",label:"Date",width:70,align:"center",formatter:'date',formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d-M-Y H:i:s"}},
			*/
		],
		url:"<?php echo site_url($link_controller)?>/get_data/produk",    
		pager: "#pnewapi_produk", 
		sortname: 'produk_kode', 
		sortorder: "ASC",
		datatype:'json',
		rowNum:'5',
		rowList:[5,10,20],
		rownumbers:true,
		hiddengrid:false,
		autowidth:true,
		forceFit:true,
		sortable:true,
		shrinkToFit:true,
		viewrecords:true,
		//scroll:true,
		//scrollrows:true,
		//viewsortcols:true,
		toolbar: [true,'top'],
		//footerrow:true,
		//userDataOnFooter:true,
		height:'100%',
		caption:'LIST STOCK PRODUCT'
	});
	
	progrid_content.jqGrid('navGrid',"#pnewapi_produk",
		{view:false,edit:false, add:false,del:false,search:false,refresh:false},
		{closeAfterEdit:true,mtype: 'POST'},
		{closeAfterAdd:true,mtype: 'POST'}, 
		{mtype: 'POST'}, 
		{
			//odata : ['=', '!=', '<', '<=','>','>=', 'begins with','ends with','contains' ],
			sopt:['eq','cn','ge','le'],
			overlay:false,mtype: 'POST'
		}
	);
	
	progrid_content.jqGrid('navButtonAdd',"#pnewapi_produk",
		{
			caption:"Search",
			title:"Toggle Search Toolbar", 
			buttonicon :'ui-icon-pin-s', 
			onClickButton:function(){ 
				progrid_content[0].toggleToolbar() 
			}
		}
	);
	
	progrid_content.jqGrid('navButtonAdd',"#pnewapi_produk",
		{
			caption:"Refresh",
			title:"Clear Search",
			buttonicon :'ui-icon-refresh', 
			onClickButton:function(){ 
				progrid_content[0].clearToolbar() 
			} 
		}
	);
	
	progrid_content.jqGrid('filterToolbar',
		{stringResult: true,searchOnEnter : false}
	)[0].toggleToolbar();
	
	var protb = $("#t_newapi_produk"),
		t_protb = "<div style='float:right'>Pilih Cabang : <select onchange='switch_cabang(this.value);'><?php echo $opt_cabang;?></select></div>";
		
	protb.append(t_protb);//.addClass('ui-priority-secondary');
	
	// HIDE FIELD
	jQuery("#gs_kat_nama,#gs_status_item,#gs_act").hide();
});
</script>

<table id="newapi_produk"></table>
<div id="pnewapi_produk"></div>

<BR>
