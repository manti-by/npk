<?php
/**
* @version $Id: content_archive_section.menu.php 10002 2008-02-08 10:56:57Z willebil $
* @package Joomla
* @subpackage Menus
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( '������ ��������' );

mosAdminMenus::menuItem( $type );

switch ($task) {
	case 'content_archive_section':
		// this is the new item, ie, the same name as the menu `type`
		content_archive_section_menu::editSection( 0, $menutype, $option );
		break;

	case 'edit':
		content_archive_section_menu::editSection( $cid[0], $menutype, $option );
		break;

	case 'save':
	case 'apply':
		saveMenu( $option, $task );
		break;
}
?>