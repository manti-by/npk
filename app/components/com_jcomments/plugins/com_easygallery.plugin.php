<?php
/**
 * JComments plugin for EasyGallery photo objects support
 *
 * @version 1.4
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

class jc_com_easygallery extends JCommentsPlugin {

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT name FROM #__easygallery WHERE state = 1 AND id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid('com_easygallery');
		$link = JoomlaTuneRoute::_('index.php?option=com_easygallery&amp;act=photos&amp;cid=' . $id . '&amp;Itemid=' . $_Itemid);
		return $link;
	}
}
?>