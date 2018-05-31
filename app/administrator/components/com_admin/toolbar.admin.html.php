<?php
/**
* @version $Id: toolbar.admin.html.php 85 2005-09-15 23:12:03Z eddieajau $
* @package Joomla
* @subpackage Admin
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

/**
* @package Joomla
* @subpackage Admin
*/
class TOOLBAR_admin {
	function _SYSINFO() {
		mosMenuBar::startTable();
		mosMenuBar::help( 'screen.system.info' );
		mosMenuBar::endTable();
	}
	/**
	* Draws the menu for a New category
	*/
	function _CPANEL() {
		mosMenuBar::startTable();
		mosMenuBar::help( 'screen.cpanel' );
		mosMenuBar::endTable();
	}
	/**
	* Draws the menu for a New category
	*/
	function _DEFAULT() {
		mosMenuBar::startTable();
		//mosMenuBar::help( 'screen.cpanel' );
		mosMenuBar::endTable();
	}
}
?>