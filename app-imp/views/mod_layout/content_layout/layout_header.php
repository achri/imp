<!-- NAV MENU -->
<div class="art-nav noprint">
	<div class="l"></div>
	<div class="r"></div>
	<ul class="art-menu">
		<li>
			<a href="#" class="active" module="home"><span class="l"></span><span class="r"></span><span class="t">Home</span></a>
		</li>	
		<li>
			<a href="#"><span class="l"></span><span class="r"></span><span class="t">About</span></a>
		</li>
	</ul>
	<span style="position:static;float:right;margin-top:-25px;margin-right:5px;">
		<?php $this->load->view('mod_layout/content_layout/layout_user_view')?>&nbsp;
		<select style="float:right" onchange="change_layout(this.value);" class="ui-widget-content ui-corner-tr">
			<option value='content' <?php echo (isset($layout_switch)&&($layout_type == 'content'))?('SELECTED'):('')?>>Flat</option>
			<option value='body' <?php echo (isset($layout_switch)&&($layout_type == 'body'))?('SELECTED'):('')?>>Layout</option>
		</select>
	</span>
</div>
	
<!-- HEADER CONTENT -->
<div class="art-header noprint">
	<div class="art-header-jpeg"></div>
	<script type="text/javascript" src="swfobject.js"></script>
	<div id="art-flash-area">
		<div id="art-flash-container">
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="897" height="224" id="art-flash-object">
				<param name="movie" value="<?php echo $path_themes?>/images/flash.swf" />
				<param name="quality" value="best" />
				<param name="scale" value="exactfit" />
				<param name="wmode" value="transparent" />
				<param name="flashvars" value="color1=0xFFFFFF&amp;alpha1=.30&amp;framerate1=24" />
				<param name="swfliveconnect" value="true" />
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="<?php echo $path_themes?>/images/flash.swf" width="897" height="224">
					<param name="quality" value="best" />
					<param name="scale" value="exactfit" />
					<param name="wmode" value="transparent" />
					<param name="flashvars" value="color1=0xFFFFFF&amp;alpha1=.30&amp;framerate1=24" />
					<param name="swfliveconnect" value="true" />
				<!--<![endif]-->
					<div class="art-flash-alt"><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></div>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</div>
	</div>
	
	<!-- FLASH -->
	<script type="text/javascript">swfobject.switchOffAutoHideShow();swfobject.registerObject("art-flash-object", "9.0.0", "<?php echo $path_themes?>/expressInstall.swf");</script>
	
	<!-- HEADER -->
    <div class="art-logo">
		<h1 id="name-text" class="art-logo-name"><a href="#"><?php echo $header_title?></a></h1>
		<div id="slogan-text" class="art-logo-text"><?php echo $header_subtitle?></div>
	</div>
</div>