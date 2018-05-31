<?php
/*
// "breeze" Administrator Template for Joomla 1.0.x - Version 1.0
// License: http://www.gnu.org/copyleft/gpl.html
// Author: venz
// Copyright (c) 2008 venzdesign.com - http://www.venzdesign.com
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

// Settings
$usenewloader		= 1;				// set to 1 to use the new loader or 0 to restore the default one
$simplemode 		= 0; 				// set to 1 to enable simplified content item editing mode
$init_translation 	= 0; 				// set to 1 to initiate admin translation
$target_language 	= 'greek';			// target translation language (only Greek for now)
$minted_version		= '2.3';			// Minted One-Point-Five version
$extra_security		= 0;				// enable the pre-login security code (adds extra layer of security)
$password			= 'joomla';			// your pre-login security code





/* -------------------------- DO NOT CHANGE BELOW -------------------------- */
global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_lang, $mosConfig_sitename, $mainframe, $version;


// The magic!
$old_html = array (
"",
"",
"<script language=\"javascript\" type=\"text/javascript\" src=\"".$mosConfig_live_site."/includes/js/overlib_mini.js\"></script>",
"<script language=\"javascript\" type=\"text/javascript\" src=\"".$mosConfig_live_site."/includes/js/overlib_hideform_mini.js\"></script>",
"",
"<!-- Tooltip -->",
"includes/js/ThemeOffice/tooltip.png",
"<!-- Warning -->",
".helpIndex {",
".helpFrame {",
"<iframe height=\"360\" src=\"index3.php?option=com_media&amp;task=list&amp;listdir=\" name=\"imgManager\" id=\"imgManager\" width=\"100%\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"auto\" frameborder=\"0\"></iframe>",
"<iframe name=\"previewFrame\" src=\"".$mosConfig_live_site."/index.php?tp=0\" class=\"previewFrame\" /></iframe>",
"<iframe name=\"previewFrame\" src=\"".$mosConfig_live_site."/index.php?tp=1\" class=\"previewFrame\" /></iframe>",
"<br /><br /><br />\r<div style=\"border: 1px dotted gray; width: 80px; padding: 10px; margin-left: 50px;\">",
"<br /><br /><br />\r<div style=\"border: 1px dotted gray; width: 70px; padding: 10px; margin-left: 50px;\">",
"<img src=\"../includes/js/ThemeOffice",
"<img src=\"images/publish",
"<img src=\"images/tick.png",
"<img src=\"images/nomail.png",
"<img src=\"images/users.png",
"<img src=\"../images/tick.png\" />",
"src=\"images/preview_f2.png\"",
"<img src=\"images/uparrow.png\"",
"<img src=\"images/downarrow.png\"",
",'images/",
"src=\"images/restore.png\"",
"src=\"images/delete.png\"",
"src=\"images/filesave.png\"",
);

$new_html = array (
"",
"",
"",
"",
"",
"&nbsp;&nbsp;<!-- Tooltip -->",
"administrator/templates/breeze/images/info.png",
"&nbsp;&nbsp;<!-- Warning -->",
".helpIndex-disabled {",
".helpFrame-disabled {",
"<iframe height=\"380\" src=\"index3.php?option=com_media&amp;task=list&amp;listdir=\" name=\"imgManager\" id=\"imgManager\" width=\"100%\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"auto\" frameborder=\"0\"></iframe>",
"<iframe id=\"previewFrame\" name=\"previewFrame\" src=\"".$mosConfig_live_site."/index.php?tp=0\" class=\"previewFrame-off\" style=\"padding:0px 5px;margin:0px auto 20px auto;width:98%;\" frameborder=\"0\" scrolling=\"no\" height=\"1000\" onLoad=\"calcHeight();\" /></iframe>
<script type=\"text/javascript\" language=\"JavaScript\">
function calcHeight() {
	var change_height = document.getElementById(\"previewFrame\").contentWindow.document.body.scrollHeight;
	if(change_height==0) { change_height=2500; }
	document.getElementById(\"previewFrame\").height = change_height+50;
}
</script>",
"<iframe id=\"previewFrame\" name=\"previewFrame\" src=\"".$mosConfig_live_site."/index.php?tp=1\" class=\"previewFrame-off\" style=\"padding:0px 5px;margin:0px auto 20px auto;width:98%;\" frameborder=\"0\" scrolling=\"no\" height=\"1000\" onLoad=\"calcHeight();\" /></iframe>
<script type=\"text/javascript\" language=\"JavaScript\">
function calcHeight() {
	var change_height = document.getElementById(\"previewFrame\").contentWindow.document.body.scrollHeight;
	if(change_height==0) { change_height=2500; }
	document.getElementById(\"previewFrame\").height = change_height+50;
}
</script>",
"<div class=\"trashbutton\">",
"<div class=\"trashbutton\">",
"<img src=\"templates/breeze/ThemeOffice",
"<img src=\"templates/breeze/images/publish",
"<img src=\"templates/breeze/images/tick.png",
"<img src=\"templates/breeze/images/nomail.png",
"<img src=\"templates/breeze/images/users.png",
"<img src=\"templates/breeze/images/tick.png\" />",
"src=\"templates/breeze/images/preview_f2.png\"",
"<img src=\"templates/breeze/images/uparrow.png\"",
"<img src=\"templates/breeze/images/downarrow.png\"",
",'templates/breeze/images/",
"src=\"templates/breeze/images/restore.png\"",
"src=\"templates/breeze/images/delete.png\"",
"src=\"templates/breeze/images/filesave.png\"",
// Mambo
"<td style=\"width:100%;vertical-align:top;\">\r<table width=\"100%\" class=\"adminform\">\r<tr>\r<td>",
"<td style=\"vertical-align:top;\"><table width=\"100%\">",
"<input type =\"hidden\" name=\"simple_editing\" value=''>\r<table>\r<tr>\r<td style=\"width:100%;vertical-align:top;\">\r",
"<td style=\"vertical-align:top;\"><div id=\"simpleediting\" style=\"display:block\">",
"",
"</td>\r",
"src=\"templates/breeze/images/move.png\"",
"src=\"templates/breeze/images/copy.png\"",
"src=\"templates/breeze/images/edit.png\"",
"src=\"templates/breeze/images/upload.png\"",
"src=\"templates/breeze/images/new.png\"",
"src=\"templates/breeze/images/publish.png\"",
"src=\"templates/breeze/images/cancel.png\"",
"src=\"templates/breeze/images/save.png\"",
"src=\"templates/breeze/images/next.png\"",
"src=\"templates/breeze/images/preview.png\"",
);

// Simplified mode for content item editing
$old_html_sm = array (
"\r<td width=\"60%\" valign=\"top\">\r",
"\r<td valign=\"top\" width=\"40%\">\r",
"\r<td width=\"40%\" valign=\"top\">\r",
"<h2 class=\"tab\">Images</h2>",
"<h2 class=\"tab\">Meta Info</h2>",
"<h2 class=\"tab\">Link to Menu</h2>",
);
$new_html_sm = array (
"\r<td class=\"cip-leftpane\">\r",
"\r<td class=\"cip-rightpane\">\r",
"\r<td class=\"cip-rightpane\">\r",
"<h2 class=\"tab\" style=\"display:none;\">Images</h2>",
"<h2 class=\"tab\" style=\"display:none;\">Meta Info</h2>",
"<h2 class=\"tab\" style=\"display:none;\">Link to Menu</h2>"
);

// Mambo Control Panel only
$old_html_mambo = array ("src=\"images/");
$new_html_mambo = array ("src=\"templates/breeze/images/");

if(!function_exists("jw_minted")) {
	function jw_minted($buffer) {
		global $_VERSION,$option,$old_html,$new_html,$simplemode,$old_html_sm,$new_html_sm,$old_html_mambo,$new_html_mambo,$init_translation;
		$oldcode = array("/\r\n|\r|\n|\t/","/\r\r\r/","/\r\r/","/\s\s+/");
		$newcode = array("\r","\r","\r","\r");
		$buffer = preg_replace($oldcode, $newcode, $buffer);
		$buffer = str_replace($old_html, $new_html, $buffer);
		if ($simplemode && ($option=="com_content" || $option=="com_typedcontent")) {
			$buffer = str_replace($old_html_sm, $new_html_sm, $buffer);
		}

		return $buffer;
	}
}

?>