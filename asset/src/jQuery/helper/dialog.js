var $dlg_content = $('div.dialog-content');
$dlg_content.dialog('destroy')
.dialog({
	title: 'INFORMATION',
	autoOpen: false,
	bgiframe: true,
	width: 'auto',
	height: 'auto',
	resizable: false,
	draggable: false,
	modal:true,
	/*position:['right','top'],*/
	position:'center'
});

function show_dialog(content,title,func_button,func_close) {
	$dlg_content.html(content)
	.dialog('option',{
		title : title,
		buttons: func_button,
		close: func_close
	}).dialog('open');
}

function show_confirmation(content,title,dlg_button,dlg_close) {
	$dlg_content.html(content)
	.dialog('option',{
		title : title,
		buttons: dlg_button,
		close: dlg_close
	}).dialog('open');
	return false;
}

function informasi(title,dlg_close) {
	$dlg_content.html(title)
	.dialog('option',{
		title : 'INFORMATION',
		buttons: {
			'OK' : function() {
				$dlg_content.dialog('close');
			}	
		},
		close: dlg_close
	}).dialog('open');
	return false;
}

function konfirmasi(title,dlg_button,dlg_close) {
	$dlg_content.html(title)
	.dialog('option',{
		title : 'CONFIRMATION',
		buttons: dlg_button,
		close: dlg_close
	}).dialog('open');
	return false;
}
