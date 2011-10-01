<script type="text/javascript">
var dlg_list = $('#list-content');

$('.btn-list').click(function() {
	var klik = $('.btn-list').index(this);
	switch (klik) {
		case 0 :
			// LIST PRODUK
			dlg_list.load('index.php/mod_master/master_produk/daftar_produk',function(data){
				alert(data);
				$(this).dialog('open');
			});
			
		break;
		case 1 :
			// LIST PEMASOK
		break;
	}
	return false;
});
$(document).ready(function() {
	
	dlg_list.dialog({
		autoOpen: false,
		bgiframe: true,
		width: 'auto',
		height: 'auto',
		resizable: false,
		draggable: false,
		modal:true,
		position:['right','top'],
		//position:'center'
	});
});
</script>

<div id="list-content"></div>