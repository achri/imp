<table width="40%" align="center" cellspacing=2 cellpadding=2 class="ui-corner-all" style="border:1px solid"> <!--style="font-size:8px"-->
<tr class="ui-state-active"><td colspan=3><?php echo $user_information;?></td></tr>
<?php foreach ($list_user->result() as $row):?>
<tr class="ui-widget-content">
	<td width="120px"><?php echo $last_time_login?></td><td width=5>:</td><td width="150px"><?php echo date_format(date_create($row->lastTime_log),'d-M-Y H:i:s');?></td>
</tr>
<tr class="ui-widget-content">
	<td width="120px"><?php echo $last_ip_login?></td><td>:</td><td width="150px"><?php echo $row->lastIP_log;?></td>
</tr>
<tr class="ui-widget-content">
	<td><?php echo $off_time_login?></td><td>:</td><td><?php echo date_format(date_create($row->offTime_log),'d-M-Y H:i:s');?></td>
</tr>
<tr class="ui-widget-content">
	<td><?php echo $off_ip_login?></td><td>:</td><td width="150px"><?php echo $row->offIP_log;?></td>
</tr>
<tr class="ui-widget-content">
	<td><?php echo $new_time_login?></td><td>:</td><td><?php echo date_format(date_create($row->newTime_log),'d-M-Y H:i:s');?></td>
</tr>
<tr class="ui-widget-content">
	<td><?php echo $new_ip_login?></td><td>:</td><td width="150px"><?php echo $row->newIP_log;?></td>
</tr>
<?php endforeach;?>
</table>