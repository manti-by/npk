<?php
/**
 * JComments plugin for Joomla com_poll component
 *
 * @version 1.4
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

class jc_com_poll extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title FROM #__polls WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			$db = & JCommentsFactory::getDBO();
			$db->setQuery( 'SELECT alias FROM #__polls WHERE id = ' . $id );
			$alias = $db->loadResult();

			$link = 'index.php?option=com_poll&id='. $id.':'.$alias;

			require_once(JPATH_SITE.DS.'includes'.DS.'application.php');

			$component = & JComponentHelper::getComponent('com_poll');
			$menus	= & JSite::getMenu();
			$items	= $menus->getItems('componentid', $component->id);

			if (count($items)) {
				$link .= "&Itemid=" . $items[0]->id;
			}

			$link = JRoute::_($link);

		} else {
			$_Itemid = JCommentsPlugin::getItemid( 'com_poll' );
			$link = sefRelToAbs( 'index.php?option=com_poll&amp;task=results&amp;id=' . $id . '&amp;Itemid=' . $_Itemid );
		}
		return $link;
	}
}
?>