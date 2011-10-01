<?php  if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

/*
 @author		Achri
 @date creation	22/03/2011
 @model
	- 
 @view
	- 
 @library
    - JS		
    - PHP
 @comment
	- Helper Layout
*/
	
// @info	: Themes content
// @access	: private
// @params	: string
// @return	: array	
function set_layout($layout='content',$themes='default')
{
	$content = '';
	switch ($layout):
		case 'content' : 
			$content .= "<link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"".base_url()."asset/themes/content/".$themes."/style.css\"/>\n";
			$content .= "<!--[if IE 6]><link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"".base_url()."asset/themes/content/".$themes."/style.ie6.css\" type=\"text/css\" media=\"screen\" /><![endif]-->\n";
			$content .= "<!--[if IE 7]><link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"".base_url()."asset/themes/content/".$themes."/style.ie7.css\" type=\"text/css\" media=\"screen\" /><![endif]-->\n";
			$content .= "<script type=\"text/javascript\" src=\"".base_url()."asset/themes/content/".$themes."/script.js\"/></script>\n";
			$content .= "<script type=\"text/javascript\" src=\"".base_url()."asset/themes/content/".$themes."/swfobject.js\"/></script>\n";
		break;
		case 'body' :
			$content = "<script type=\"text/javascript\" src=\"".base_url()."asset/src/jQuery/plugins/layout/jquery.layout.js\"/></script>\n";
			$content .= "<script type=\"text/javascript\" src=\"".base_url()."asset/js/layout.js\"/></script>\n";
		break;
	endswitch;
	return $content;
}

// @info	: SET TITLE FOR CONTENT
// @access	: public
// @params	: string
// @return	: string
function content_title($title,$path_themes)
{
	return "
		<div class=\"art-postmetadataheader ui-corner-all\">
			<h2 class=\"art-postheader\">
				<img src=\"$path_themes/images/postheadericon.png\" width=\"30\" height=\"31\" alt=\"postheadericon\" />
				$title
			</h2>
		</div>
		<br>
	";
}

/* End of file layout_helper.php */
/* Location: ./app-imp/helpers/layout_helper.php */