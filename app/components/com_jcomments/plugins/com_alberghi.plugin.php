<?php
/**
 * JComments plugin for Alberghi objects support
 *
 * @version 1.4
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

class jc_com_alberghi extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT title FROM #__alberghi WHERE id = ' . $id);
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid('com_alberghi');
		$_Itemid = (intval($_Itemid) ? '&amp;Itemid=' . $_Itemid : '');

		$link = JoomlaTuneRoute::_('index.php?option=com_alberghi&amp;task=detail&amp;id=' . $id . $_Itemid);
		return $link;
	}
}
?>