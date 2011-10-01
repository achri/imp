<script type="text/javascript">
$(document).ready(function() {
	//dtgLoadButton();

	var usergrid = usergrid_content.jqGrid({   
		url: "index.php/<?php echo $link_controller;?>/get_data",
		//editurl: "",
		colModel: [ 
			{name:"usr_id",key:true,hidden:true},
			{name:"usr_login",label:"<?php echo $user_id?>",width:80,align:"left"},
			{name:"usr_nama",label:"<?php echo $user_name?>",width:100,align:"left"},
			//{name:"usr_pwd1",label:"PASS1",width:100,align:"left"},
			//{name:"usr_pwd2",label:"PASS2",width:100,align:"left"},
			{name:"akses",label:"<?php echo $user_access?>",width:50,align:"center"},
			{name:"ucat_id",hidden:true}
		],
		gridComplete: function(){ 
			
			var id = usergrid_content.jqGrid('getDataIDs'); 
			for(var i=0;i < id.length;i++){ 
				var cl = id[i],
					ucat_id = usergrid_content.getRowData(cl).ucat_id,
					arr_stat = new Array('null','Administrator','Operator');
				usergrid_content.jqGrid('setRowData',cl,{akses:arr_stat[ucat_id]});
			}
			
			return;
		},
		jsonReader : {
			root:"data",
			repeatitems: false
		},
		pager: "#pnewapi_user", 
		sortname: 'usr_login', 
		sortorder: "ASC",
		//viewrecords: true,
		loadError :function(xhr,status, err){ 
			try {
				jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class="ui-state-error">'+ xhr.responseText +'</div>', jQuery.jgrid.edit.bClose,{buttonalign:'right'});
			} 
			catch(e) { alert(xhr.responseText);} 
		},
		onSelectRow: function(id) {
			var gsr = usergrid_content.jqGrid('getGridParam','selrow'); 
			usergrid_content.jqGrid('GridToForm',gsr,"#user_form"); 
			user_selrow();
			return;
		},
		/*ondblClickRow: function(id){
			var gridwidth = usergrid_content.width();
			
			gridwidth = gridwidth / 2;
			usergrid.editGridRow(id, {
				closeAfterEdit:true,
				mtype:'POST'
			});
			return;
		},*/
		datatype:'json',
		rowNum:10,
		rowList:[10,20,30,40],
		rownumbers:true,
		hiddengrid:false,
		autowidth:true,
		forceFit:true,
		shrinkToFit:true,
		height:'75%',
		caption:'<?php echo $user_grid?>',
		
	}); 
	
	usergrid_content.jqGrid('navGrid',"#pnewapi_user",{view:true,edit:false, add:false,del:false,search:true,refresh:true},
		{closeAfterEdit:true,mtype: 'POST'},
		{closeAfterAdd:true,mtype: 'POST'}, 
		{mtype: 'POST'}, 
		{sopt:['eq','cn','ge','le'],overlay:false,mtype: 'POST'}
	);
	
	//usergrid_content.jqGrid('gridResize',{minWidth:635,maxWidth:635,minHeight:80, maxHeight:350});
	/*
	$("#savedata").click(function(){ 
		var kirim_id= $("#order_form #kirim_id").val(); 
		if(kirim_id) { 
			usergrid_content.jqGrid('FormToGrid',kirim_id,"#order_form"); 
		} 
	})
	*/;
});
</script>
<table id="newapi_user" class="scroll"></table>
<div id="pnewapi_user" class="scroll" style="text-align:center;"></div>
