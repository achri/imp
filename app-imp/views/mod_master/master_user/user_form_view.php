<form id="user_form"> 
<fieldset class="ui-widget-content ui-corner-all"> 
	<legend class="ui-corner-all ui-state-active"><?php echo $user_form?></legend> 
	<table width="100%" class="ui-widget-content" border=0 style="border:0px"> 
		<tbody valign="top"> 
			<tr> 
				<td width="100px"><?php echo $user_id?></td> 
				<td width="5px">:</td>
				<td>
					<input class="user_form" type="hidden" name="usr_id" id="usr_id"/>
					<input class="user_form required" type="text" name="usr_login" title="<?php echo $user_id?>"/>
					&nbsp;<input class="user_form" type="checkbox" id="new_password" onclick="change_password(this.id)"> <?php echo $user_npwd?>
				</td>
			</tr> 
			<tr class="password"> 
				<td ><?php echo $user_pwd1?></td> 
				<td>:</td>
				<td>
					<input class="user_form required pwd" type="text" name="usr_pwd1" title="<?php echo $user_pwd1?>"/>
				</td>
			</tr> 
			<tr class="password"> 
				<td ><?php echo $user_pwd2?></td> 
				<td>:</td>
				<td>
					<input class="user_form required pwd" type="text" name="usr_pwd2" title="<?php echo $user_pwd2?>"/>
				</td>
			</tr> 
			<tr> 
				<td ><?php echo $user_name?></td> 
				<td>:</td>
				<td>
					<input class="user_form required" type="text" name="usr_nama" title="<?php echo $user_name?>"/>
				</td>
			</tr> 
			<tr> 
				<td ><?php echo $user_access?></td> 
				<td>:</td>
				<td>
					<select class="user_form required" name="ucat_id" title="<?php echo $user_access?>">
						<option value="">-= Select =-</option>
						<option value=1>Administrator</option>
						<option value=2>Operator</option>
					</select>
				</td>
			</tr>
			<tr>
				<td> <?php echo $user_maccess?></td>
				<td>:</td>
				<td>
				<div style="height: 150px; overflow: auto; margin-left:-28px; padding-top:0px">
					<div id="menu_tree"><!-- MENU TREE --></div>
				</div>
				<input type="" id="menu" name="menu">
				</td>
			</tr>
			<tr><td colspan=7><hr></td></tr>
			<tr> 
				<td>
					<input class="user_btn" onclick="tambah_user(this.value);" type="button" id="user_tambah" value="<?php echo $btn_add?>" />
				</td>
				<td></td>
				<td>
					<input class="user_btn" onclick="ubah_user(this.value);" type="button" id="user_ubah" value="<?php echo $btn_edit?>" />
					<input class="user_btn" onclick="hapus_user(this.value);" type="button" id="user_hapus" value="<?php echo $btn_delete?>" />
					
					<input class="user_btn" onclick="user_kondisi_awal();" type="button" id="user_batal" value="<?php echo $btn_cancel?>" />
					<input type="reset" value="<?php echo $btn_clear?>" />
				</td> 
			</tr> 
		</tbody> 
	</table> 
</fieldset> 
</form>