<script language="javascript">
function cek() {
	var a= beligrid_content.parent().parent().parent().html();
	var b = $('.ui-jqgrid-ftable').html();
	var qty = $('.ui-jqgrid-ftable tbody tr td').eq(8).html();
	var harga = $('.ui-jqgrid-ftable tbody tr td').eq(9).html();
	var total = $('.ui-jqgrid-ftable tbody tr td').eq(10).html();
	
	$('#ww').text(harga);
	return false;
}
function imp_debug() {
	var selector = $('input#debug-cmd').val(),
		get = $(selector).html();
		
	$('#debug-text').text(get);
	return false;
}
</script>

<input type="text" id="debug-cmd">
<input type="button" value="go" onclick="imp_debug()">
<textarea id="debug-text"></textarea>