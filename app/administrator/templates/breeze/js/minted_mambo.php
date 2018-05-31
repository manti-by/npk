<?php 
/*
// "Breeze" Administrator Template for Joomla 1.0.x - Version 1.0
// Based on "Minted One-Point-Five" Administrator Template for Joomla 1.0.x & Mambo 4.6.x - Version 2.3 http://www.joomlaworks.gr
// License: http://www.gnu.org/copyleft/gpl.html
// Author: venz
// Copyright (c) 2008 venzdesign.com - http://www.venzdesign.com
// *** Last update: April 9th, 2008 ***
*/

ob_start ("ob_gzhandler"); 
header("Content-type: text/javascript; charset: UTF-8"); 
header("Cache-Control: must-revalidate"); 
$offset = 60 * 60 ; 
$ExpStr = "Expires: " .  
gmdate("D, d M Y H:i:s", 
time() + $offset) . " GMT"; 
header($ExpStr);
include("mambo.javascript.js");
include("../../../../includes/js/JSCookMenu.js");
include("../../../../includes/js/tabs/tabpane.js");
include("../../../includes/js/ThemeOffice/theme.js");
include("../../../../includes/js/overlib_mini.js");
//include("../../../../includes/js/overlib_hideform_mini.js");
include("minted.js");
include("fat.js");
ob_flush();
?>
