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
header("Content-type: text/css; charset=windows-1251");
header("Cache-Control: must-revalidate");
$offset = 60 * 60 ;
$ExpStr = "Expires: " . 
gmdate("D, d M Y H:i:s",
time() + $offset) . " GMT";
header($ExpStr);
include("template_css.css");
include("theme.css");
ob_flush();
?>