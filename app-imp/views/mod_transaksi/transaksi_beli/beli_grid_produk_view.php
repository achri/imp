<?php 
if (isset($extraSubHeaderContent)) 
	//echo $extraSubHeaderContent;
?>
<script type="text/javascript">	
var progrid_content = jQuery("#newapi_produk");

function switch_cabang(val) {
	progrid_content.jqGrid('setGridParam',{
		url:"<?php echo site_url($link_controller);?>/get_data/produk_daftar",
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
			var ids = progrid_content.jqGrid('getDataIDs'); 
			for(var i=0;i < ids.length;i++){ 
				var cl = ids[i],
					produk = progrid_content.getRowData(cl).produk_nama;
				be = "<a alt='Edit' style='cursor:pointer' onclick=\"tabs_edit('"+cl+"');\" class='ui-icon ui-icon-document'></a>"; 
				de = "<a alt='Delete' style='cursor:pointer' onclick=\"hapus_produk('"+cl+"');\" class='ui-icon ui-icon-trash'></a>";//<img border='0' src='<?php echo base_url()?>asset/images/icons/trash.png'></a>"; 
				//ce = "<input style='height:22px;width:20px;' type='button' value='C' onclick=\"jQuery('#rowed2').restoreRow('"+cl+"');\" />"; 
				progrid_content.jqGrid('setRowData',ids[i],{act:be+de}); 
			} 
			return;
		},
		onSelectRow:function(produk_id) {	
			
			return;
		},
		ondblClickRow: function(id){
			
			return;
		},
		colModel: [ 
			{name:"produk_id",key:true,hidden:true},
			{name:"produk_kode",label:"<?php echo $this->lang->line('code')?>",width:65,align:'center'},
			{name:"kat_nama",label:"<?php echo $this->lang->line('category')?>",width:200},
			{name:"produk_nama",label:"<?php echo $this->lang->line('product')?>",width:150},
			{name:"satuan_nama",label:"<?php echo $this->lang->line('unit')?>",width:80},
			{name:"produk_min_stok",label:"<?php echo $this->lang->line('minstock')?>",width:55,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}},
			{name:"harga_beli",label:"<?php echo $this->lang->line('buying')?>",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"harga_jual",label:"<?php echo $this->lang->line('selling')?>",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"keterangan",label:"<?php echo $this->lang->line('description')?>",width:150,hidden:true},
			{name:"act",label:"@",width:20,align:'center'},
			/*
			{name:"beli_tgl",label:"Date",width:70,align:"center",formatter:'date',formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d-M-Y H:i:s"}},
			*/
		],
		url:"<?php echo site_url($link_controller)?>/get_data/produk_daftar",    
		pager: "#pnewapi_produk", 
		sortname: 'produk_kode', 
		sortorder: "ASC",
		datatype:'json',
		rowNum:'10',
		rowList:[5,10,20],
		rownumbers:true,
		hiddengrid:false,
		autowidth:true,
		forceFit:true,
		sortable:true,
		shrinkToFit:true,
		viewrecords:true,
		//scroll:0,
		//scrollrows:true,
		//viewsortcols:true,
		toolbar: [true,'top'],
		//footerrow:true,
		//userDataOnFooter:true,
		height:'100%',
		caption:'<?php echo $this->lang->line('product_grid')?>'
	});
	
	progrid_content.jqGrid('navGrid',"#pnewapi_produk",
		{view:true,edit:false, add:false,del:false,search:false,refresh:false},
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
			caption:"<?php echo $this->lang->line('btn_search')?>",
			title:"<?php echo $this->lang->line('txt_search')?>", 
			buttonicon :'ui-icon-pin-s', 
			onClickButton:function(){ 
				progrid_content[0].toggleToolbar() 
			}
		}
	);
	
	progrid_content.jqGrid('navButtonAdd',"#pnewapi_produk",
		{
			caption:"<?php echo $this->lang->line('btn_clear')?>",
			title:"<?php echo $this->lang->line('txt_clear')?>",
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
		t_protb = "<div style='float:right'>Pilih Cabang : <select onchange='switch_cabang(this.value);'><?php echo $this->lang->line('opt_cabang');?></select></div>";
		
	protb.append(t_protb);//.addClass('ui-priority-secondary');
	
	// HIDE FIELD
	jQuery("#gs_kat_nama,#gs_act").hide();
});
</script>

<table id="newapi_produk"></table>
<div id="pnewapi_produk"></div>

<BR>
