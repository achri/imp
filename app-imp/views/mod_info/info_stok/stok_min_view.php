<?php
$icon = array('030','023');
if (isset($list_stok)):
?>
<table width="100%" cellspacing=1 style="font-size:8px">
<tbody valign="top">
<tr class="ui-widget-header"><td colspan=3>Notify</td></tr>
<tr class="ui-widget-header ui-priority-secondary" align="center">
	<td width="50px">Code</td>
	<td>Name</td>
	<!--td>Qty</td-->
	<td width="6px">Stats</td>
</tr>
<?php foreach ($list_stok->result() as $row):?>
<tr class="ui-widget-content">
	<td><?php echo $row->produk_kode;?></td>
	<td><?php echo $row->produk_nama;?></td>
	<!--td><?php //echo $row->inv_akhir;?></td-->
	<td align="center"><img src="<?php echo base_url().'asset/images/icons/classic/'.$icon[$row->info].'.png';?>" border=0 width="15px" height="15px"></td>
</tr>
<?php endforeach;?>
</tbody>
</table>
<?php endif;?>