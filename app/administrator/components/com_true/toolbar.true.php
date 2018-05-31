<?php
/***************************************************\
**   True gallery - A Joomla! Gallery Component    **
**   Copyright (C) 2008  by JoomlaForum **
**   Version    : 2.0                              **
**   Homepage   : http://true.palpalych.ru              **
**   License    : Copyright, don't distribute      **
**   Based on   : AkoGallery -> PonyGallery -> DatsoGallery Datso gallery 1.6**
\***************************************************/

defined('_VALID_MOS') or defined('_JEXEC') or die('Direct Access to this location is not allowed.');
require_once ($mainframe->getPath('toolbar_html'));
require_once ($mainframe->getPath('toolbar_default'));
if($act)
	$task = $act;
switch ($task) {
	case "movepic":
		menutrue::MOVE_PIC_MENU();
		break;
	case "newcatg":
		menutrue::NEW_CTG_MENU();
		break;
	case "showcatg":
		menutrue::CTG_MENU();
		break;
	case "edit":
		menutrue::EDIT_MENU();
		break;
	case "editcatg":
		menutrue::EDIT_CTG_MENU();
		break;
	case "settings":
		menutrue::CONFIG_MENU();
		break;
	case "new":
	case "upload":
	case "uploadhandler":
	case "batchupload":
	case "batchuploadhandler":
	case "batchimport":
	case "batchimporthandler":
	case "rebuild":
	case "resetvotes":
		break;
	case "comments":
		menutrue::COMMENTS_MENU();
		break;
	default:
		menutrue::DATSOMAIN_MENU();
		break;
}
?>
