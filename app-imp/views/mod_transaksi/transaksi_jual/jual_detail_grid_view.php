<script type="text/javascript">	
$(document).ready(function() {
	var jualdetgrid = jualdetgrid_content.jqGrid({
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
			var gsr = jualdetgrid_content.jqGrid('getGridParam','selrow'); 
			jualdetgrid_content.jqGrid('GridToForm',gsr,"#jual_form"); 
			jual_selrow();
			change_tot_harga();
			return;
		},
		ondblClickRow: function(id){
			
			return;
		},
		colModel: [ 
			{name:"produk_id",key:true,hidden:true},
			{name:"jual_id",hidden:true},
			{name:"jumlah_multi",hidden:true},
			{name:"last_buying",hidden:true},
			{name:"last_selling",hidden:true},
			
			{name:"produk_kode",label:"Code",width:60,align:'center'},
			{name:"kat_nama",label:"Category",width:120},
			{name:"produk_nama",label:"Product",width:120},
			{name:"satuan_id",hidden:true},
			{name:"satuan_nama",label:"Unit",width:50},
			{name:"inv_akhir",label:"Stock",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}},
			{name:"jumlah",label:"Qty",width:30,align:"right",formatter:'number', formatoptions:{thousandsSeparator:","}},
			{name:"diskon",label:"Disc", width:30,align:'center'},
			{name:"tot_diskon",label:"Disc (Rp)",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"harga",label:"Selling",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"tot_harga",label:"Total",width:80,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			/*
			{name:"jual_tgl",label:"Date",width:70,align:"center",formatter:'date',formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d-M-Y H:i:s"}},
			*/
		],
		url:"<?php echo site_url($link_controller)?>/get_data/selling",  
		//editUrl:"<?php echo site_url($link_controller)?>/set_data",  
		pager: "#pnewapi_jual_detail", 
		//sortname: 'jual_tgl', 
		//sortorder: "ASC",
		datatype:'json',
		rowNum:'10',
		rowList:[5,10,20],
		rownumbers:true,
		hiddengrid:false,
		autowidth:true,
		footerrow:true,
		userDataOnFooter:true,
		forceFit:true,
		//scroll:true,
		//scrollrows:true,
		//viewsortcols:true,
		sortable:true,
		shrinkToFit:true,
		viewrecords:true,
		autowidth:true,
		toolbar: [true,'bottom'],
		height:'100%',
		caption:'LIST SELLING PRODUCT'
	});
	
	jualdetgrid_content.jqGrid('navGrid',"#pnewapi_jual_detail",{view:false,edit:false, add:false,del:false,search:false,refresh:false},
		{closeAfterEdit:true,mtype: 'POST'},
		{closeAfterAdd:true,mtype: 'POST'}, 
		{mtype: 'POST'}, 
		{
			//odata : ['=', '!=', '<', '<=','>','>=', 'begins with','ends with','contains' ],
			sopt:['eq','cn','ge','le'],
			overlay:false,mtype: 'POST'
		}
	);

	jualdetgrid_content.jqGrid('navButtonAdd',"#pnewapi_jual_detail",
		{
			caption:"Search",
			title:"Toggle Search Toolbar", 
			buttonicon :'ui-icon-pin-s', 
			onClickButton:function(){ 
				jualdetgrid_content[0].toggleToolbar() 
			}
		}
	);
	
	jualdetgrid_content.jqGrid('navButtonAdd',"#pnewapi_jual_detail",
		{
			caption:"Refresh",
			title:"Clear Search",
			buttonicon :'ui-icon-refresh', 
			onClickButton:function(){ 
				jualdetgrid_content[0].clearToolbar() 
			} 
		}
	);
	
	jualdetgrid_content.jqGrid('filterToolbar',
		{stringResult: true,searchOnEnter : false}
	)[0].toggleToolbar();
	
	// HIDE FIELD
	jQuery("input#gs_kat_nama").hide();
	
	/*var toolbar = $("#t_newapi_jual_detail"),
		t_content = "Payment type : <select>"+
		<?php 
		if($list_tipe_bayar->num_rows() > 0):
			foreach ($list_tipe_bayar->result() as $rbyr):
		?>
			"<option value='<?php echo $rbyr->trans_jenis_id?>'><?php echo $rbyr->jenis_transaksi?></option>"+
		<?php
			endforeach;
		endif;
		?>
		"</select>";
		
	toolbar.append(t_content);//.addClass('ui-priority-secondary');
	*/
});
</script>

<table id="newapi_jual_detail"></table>
<div id="pnewapi_jual_detail"></div>

<br>

Payment type : <select id="trans_jenis_id">
<?php 
if($list_tipe_bayar->num_rows() > 0):
	foreach ($list_tipe_bayar->result() as $rbyr):
?>
	<option value='<?php echo $rbyr->trans_jenis_id?>'><?php echo $rbyr->jenis_transaksi?></option>
<?php
	endforeach;
endif;
?>
</select>

<input type='button' value='Process Selling' onclick='proses_jual();'>
<input type='checkbox' id="print_jual"> Print