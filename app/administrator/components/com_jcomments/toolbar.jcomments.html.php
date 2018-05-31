<?php
/**
 * JComments - Joomla Comment System
 *
 * Backend toolbar viewer
 *
 * @version 2.0
 * @package JComments
 * @subpackage	Admin
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project, 
 * please make a reference to JComments someplace in your code 
 * and provide a link to http://www.joomlatune.ru
 **/

// ensure this file is being included by a parent file
(defined('_VALID_MOS') or defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

class menucomments
{
	function IMPORT_MENU()
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			JToolBarHelper::title(JText::_('A_IMPORT'), 'jcomments-import');
			JToolBarHelper::cancel();
		} else {
			mosMenuBar::startTable();
			mosMenuBar::spacer();
			mosMenuBar::cancel();
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		}
	}

	function CONFIG_MENU()
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			JToolBarHelper::title(JText::_('A_SETTINGS'), 'jcomments-settings');
			JToolBarHelper::custom('savesettings', 'save.png', 'save_f2.png', JText::_('A_SAVE'), false);
		} else {
			mosMenuBar::startTable();
			mosMenuBar::save('savesettings', JText::_('A_SAVE'));
			mosMenuBar::spacer();
			mosMenuBar::cancel();
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		}
	}

	function SMILES_MENU()
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			JToolBarHelper::title(JText::_('A_SMILES'), 'jcomments-smiles');
			JToolBarHelper::custom('savesmiles', 'save.png', 'save_f2.png', JText::_('A_SAVE'), false);
			JToolBarHelper::cancel();
		} else {
			mosMenuBar::startTable();
			mosMenuBar::save('savesmiles', JText::_('A_SAVE'));
			mosMenuBar::spacer();
			mosMenuBar::cancel();
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		}
	}

	function POSTINSTALL_MENU()
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			//			JToolBarHelper::customX( 'edit', 'forward.png', 'forward_f2.png', JText::_('AI_NEXT'), true );
		} else {
			mosMenuBar::startTable();
			mosMenuBar::custom('settings', 'next.png', 'next_f2.png', JText::_('AI_NEXT'), false);
			mosMenuBar::endTable();
		}
	}

	function SYSINFO_MENU()
	{
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function ABOUT_MENU()
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			JToolBarHelper::title(JText::_('AI_MENU_ABOUT'), 'jcomments-logo');
			JToolBarHelper::cancel();
		} else {
			mosMenuBar::startTable();
			mosMenuBar::spacer();
			mosMenuBar::cancel();
			mosMenuBar::spacer();
			mosMenuBar::endTable();
		}
	}

	function VIEW_MENU()
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			JToolBarHelper::title(JText::_('AI_MENU_COMMENTS'), 'jcomments-logo');
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::editList();
			JToolBarHelper::deleteList();
		} else {
			mosMenuBar::startTable();
			mosMenuBar::spacer();
			mosMenuBar::publishList();
			mosMenuBar::spacer();
			mosMenuBar::unpublishList();
			mosMenuBar::spacer();
			mosMenuBar::editList();
			mosMenuBar::spacer();
			mosMenuBar::deleteList();
			mosMenuBar::endTable();
		}
	}

	function EDIT_MENU()
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			JToolBarHelper::title(JText::_('EDIT'), 'jcomments-logo');
			JToolBarHelper::save();
			JToolBarHelper::apply();
			JToolBarHelper::cancel();
		} else {
			mosMenuBar::startTable();
			mosMenuBar::spacer();
			mosMenuBar::save();
			mosMenuBar::spacer();
			mosMenuBar::apply();
			mosMenuBar::spacer();
			mosMenuBar::cancel();
			mosMenuBar::endTable();
		}
	}
}
?>