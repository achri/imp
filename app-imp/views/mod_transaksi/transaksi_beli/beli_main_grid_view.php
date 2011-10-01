<script type="text/javascript">
var progrid_content = jQuery("#newapi_produk"),
	pricegrid_content = jQuery("#newapi_price"),
	histgrid_content = jQuery("#newapi_history");
</script>
<table width="100%">
<tr>
	<td align="center" valign="top"><?php $this->load->view($link_view.'/beli_grid_view')?></td>
</tr>
<tr>
	<td align="center" valign="top"><?php $this->load->view($link_view.'/beli_price_view')?></tr>
</tr>
<tr>
	<td align="center" valign="top"><?php $this->load->view($link_view.'/beli_history_view')?></tr>
</tr>
</table>