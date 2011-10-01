<!--div class="art-header-jpeg"></div-->
<div class="art-logo noprint">
	<span id="logo"><img src="<?php echo base_url()?>/asset/images/logo/logo_newest.png"/></span>
	<div id="logo_text" style="margin: -35px 0 0 26%; position:absolute;">
	<h1 id="name-text" class="art-logo-name"><a href="#"><?php echo $header_title?></a></h1>
	<div id="slogan-text" class="art-logo-text"><?php echo $header_subtitle?></div>
	</div>
</div>
<span style="float:right;padding-top:5px;padding-right:5px;font-size: 11px !important;zoom=0" class="noprint">
	<?php $this->load->view('mod_layout/body_layout/layout_user_view')?>
	<select style="margin-left:150px; margin-top:-1px" onchange="change_layout(this.value);" class="ui-widget-content ui-corner-bl ui-corner-br">
		<option value='content' <?php echo (isset($layout_switch)&&($layout_type == 'content'))?('SELECTED'):('')?>>Flat</option>
		<option value='body' <?php echo (isset($layout_switch)&&($layout_type == 'body'))?('SELECTED'):('')?>>Layout</option>
	</select>
</span>
