<script language="javascript">
$(document).ready(function() {
	/* USER FOTO TOOLTIP */
	/*$(".usr_photo img").tooltip({
		delay: 200,
		showURL: false,
		track:true,
		fixPNG: true,
		extraClass:'ui-widget-header ui-corner-all',
		bodyHandler: function() {
			return $("<img/>").css({
				width: 'auto', height: 'auto'
			}).attr("src", this.src);
		}
		//,top: -10,
		//left: '-100%'
	});
	*/
	/* TANGGAL DAN JAM */
	var jam = $('#hit_wkt'), interval;
	interval = window.setInterval(function(){
		var dd,d,m,y,h,i,s,hit_jam;
		dd = new Date();
		d = dd.getDate();
		if (d < 10) { d = '0'+ d; }
		m = (dd.getMonth()+1);
		if (m < 10) { m = '0'+ m; }
		y = dd.getFullYear();
		h = dd.getHours();
		if (h < 10) { h = '0'+ h; }
		i = dd.getMinutes();
		if (i < 10) { i = '0'+ i; }
		s = dd.getSeconds();
		if (s < 10) { s = '0'+ s; }
		hit_jam = d+'/'+m+'/'+y+' '+h+':'+i+':'+s+' ';
		jam.text(hit_jam);
	}, 100);
});
</script>

<?php
if ($login_id = $this->session->userdata('usr_id')):
?>
<span style="float:left">
<table style="margin-top:-1px;" width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" class="ui-widget-content ui-corner-tl">
	<tr>
	<td><strong>User</strong>&nbsp;</td><td>:&nbsp;<i><?php echo strtoupper($this->session->userdata('usr_nama'))?></i>&nbsp;</td>
	<td><strong>Access</strong>&nbsp;</td><td>:&nbsp;<i><?php echo strtoupper($this->session->userdata('usr_akses'))?></i>&nbsp;</td>
	<td colspan="2" align="right" valign="bottom" style="font:15px;font-style:italic" id="hit_wkt">&nbsp;</td>
	</tr>
</table>
</span>
<?php 
endif;?>