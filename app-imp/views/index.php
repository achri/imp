<!--DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <title><?php echo $site_title;?></title>

    <?php 
		if (isset($extraHeaderContent)) echo $extraHeaderContent;
		if (isset($extraSubHeaderContent)) echo $extraSubHeaderContent;
	?>
	<base href="<?php echo base_url(); ?>">
	<link type="text/css" rel="stylesheet" media="print" href="<?php echo base_url()?>asset/css/print/print_template.css" />
	<link type="text/css" rel="stylesheet" media="screen" href="<?php echo base_url()?>asset/css/print/normal_template.css" />
	
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
	<div class="dialog-content" title="DIALOG"></div>
	<div class="dialog-validasi" title="DIALOG"></div>
	<?php 
	if (isset($layout_switch)):
		$this->load->view('mod_layout/'.$layout_switch.'/layout_index.php');
	else:
		exit('Application terminated !!!');
	endif;
	?>
</body>
</html>
