<?php
/**
 * JComments plugin for Remository objects support
 *
 * @version 1.4
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

class jc_com_remository extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT filetitle FROM #__downloads_files WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_remository' );
		$link = sefRelToAbs( 'index.php?option=com_remository&amp;func=fileinfo&amp;id=' . $id . '&amp;Itemid=' . $_Itemid );
		return $link;
	}
}
?>