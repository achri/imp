<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <title><?php if (isset($title)) echo $title;?></title>

    <?php 
		if (isset($extraHeadContent)) echo $extraHeadContent;
		if (isset($extraSubHeadContent)) echo $extraSubHeadContent;
	?>
	<base href="<?php echo base_url(); ?>">
	
	<script type=\"text/javascript\">
	$(document).ready(function () {
		$('#usr_id').focus();
	});
	</script>
	
	<style type="text/css">
	/* INPUT UPPERCASE */
	.uppercase { text-transform: uppercase}

	/* TAB SMALL */
	.tab_small {
		font-size: 14px;
	}
	</style>
</head>
<body>
	<div id="art-page-background-gradient" style="height:100%"></div>
	<div id="art-page-background-glare">
	   <div id="art-page-background-glare-image"></div>
	</div>

	<div style="height:100%; width:100%;" class="tfont">

	<div id="headerdiv" >
	<font size="10pt">
	<?php echo $page_title?> <br>
<span><img src="<?php echo base_url()?>/asset/images/logo/logo_newest.png" width="80px"/> CV. Yulia Jaya Supplier</span>
	</font>
	</div>

	<?php $this->load->view($link_view.'/login_form_view')?>

	<div id="footerdiv" >
	Copyright &copy; aCe&trade; 2011. All Rights Reserved
	<br>
	<center><i><strong>IMP&nbsp;Release</strong>&nbsp;v1.1.2</i></center>
	</div>

	</div>
	<div class="dialog-content" title="DIALOG"></div>
</body>
</html>
