<script language="javascript">
	$.ajax({
		url : 'index.php/mod_info/info_stok/cek_stok',
		type: 'POST',
		success: function(data){
			$('#info-stok-min').html(data);
		}		
	});
</script>

<div id="info-stok-min">

</div>