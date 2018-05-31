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

class menutrue {
	function NEW_CTG_MENU() {
		mosMenuBar::startTable();
		mosMenuBar::save('savecatg', JText::_('TG_SAVEPIC_TB'));
		mosMenuBar::spacer();
		mosMenuBar::cancel('cancelcatg', JText::_('TG_CANCEL_TB'));
		mosMenuBar::endTable();
	}

	function EDIT_MENU() {
		mosMenuBar::startTable();
		mosMenuBar::save('save', JText::_('TG_SAVEPIC_TB'));
		mosMenuBar::spacer();
		mosMenuBar::cancel('cancel', JText::_('TG_CANCEL_TB'));
		mosMenuBar::endTable();
	}

	function MOVE_PIC_MENU() {
		mosMenuBar::startTable();
		mosMenuBar::save('movepicres', JText::_('TG_SAVEPIC_TB'));
		mosMenuBar::spacer();
		mosMenuBar::cancel('cancel', JText::_('TG_CANCEL_TB'));
		mosMenuBar::endTable();
	}

	function EDIT_CTG_MENU() {
		mosMenuBar::startTable();
		mosMenuBar::save('savecatg', JText::_('TG_SAVEPIC_TB'));
		mosMenuBar::spacer();
		mosMenuBar::cancel('cancelcatg', JText::_('TG_CANCEL_TB'));
		mosMenuBar::endTable();
	}

	function CTG_MENU() {
		mosMenuBar::startTable();
		mosMenuBar::publishList('publishcatg', JText::_('TG_PUBLISHCAT_TB'));
		mosMenuBar::spacer();
		mosMenuBar::unpublishList('unpublishcatg', JText::_('TG_UNPUBLISHCAT_TB'));
		mosMenuBar::spacer();
		mosMenuBar::addNew('newcatg', JText::_('TG_ADDNEWCAT_TB'));
		mosMenuBar::spacer();
		mosMenuBar::editList('editcatg', JText::_('TG_EDITCAT_TB'));
		mosMenuBar::spacer();
		mosMenuBar::deleteList('', 'removecatg', JText::_('TG_REMOVECAT_TB'));
		mosMenuBar::endTable();
	}

	function DATSOMAIN_MENU() {
		mosMenuBar::startTable();
		mosMenuBar::publishList('publish', JText::_('TG_PUBLISHPIC_TB'));
		mosMenuBar::spacer();
		mosMenuBar::unpublishList('unpublish', JText::_('TG_UNPUBLISHPIC_TB'));
		mosMenuBar::spacer();
		mosMenuBar::custom('movepic', 'move_f2.png', 'move_f2.png', JText::_('TG_MOVE_PICS'));
		mosMenuBar::spacer();
		mosMenuBar::custom('approvepic', 'apply_f2.png', 'apply_f2.png', JText::_('TG_APPROVEPIC_TB'));
		mosMenuBar::spacer();
		mosMenuBar::addNew('new', JText::_('TG_ADDNEWPIC_TB'));
		mosMenuBar::spacer();
		mosMenuBar::editList('edit', JText::_('TG_EDITPIC_TB'));
		mosMenuBar::spacer();
		mosMenuBar::deleteList('', 'remove', JText::_('TG_DELETEPIC_TB'));
		mosMenuBar::endTable();
	}

	function CONFIG_MENU() {
		mosMenuBar::startTable();
		mosMenuBar::save('savesettings', JText::_('TG_SAVESETTINGS_TB'));
		mosMenuBar::spacer();
		//mosMenuBar::apply('savelaguage', JText::_('TG_LANG'));
		//mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}

	function COMMENTS_MENU() {
		mosMenuBar::startTable();
		mosMenuBar::publishList('publishcmt', JText::_('TG_PUBLISHCMT_TB'));
		mosMenuBar::spacer();
		mosMenuBar::unpublishList('unpublishcmt', JText::_('TG_UNPUBLISHCMT_TB'));
		mosMenuBar::spacer();
		mosMenuBar::deleteList('', 'removecmt', JText::_('TG_REMOVECMT_TB'));
		mosMenuBar::endTable();
	}
}
?>
