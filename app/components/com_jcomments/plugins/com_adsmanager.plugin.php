<?php
/**
 * JComments plugin for AdsManager ads objects support
 *
 * @version 1.4
 * @package jComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

class jc_com_adsmanager extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT ad_headline FROM #__adsmanager_ads WHERE id = $id" );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_adsmanager' );
		$link = JoomlaTuneRoute::_("index.php?option=com_adsmanager&amp;page=show_ad&amp;adid=" . $id . "&amp;Itemid=" . $_Itemid);
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT userid FROM #__adsmanager_ads WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return intval($userid);
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();

		$query = "SELECT c.id as `value`, name AS `text`"
			. "\n FROM #__adsmanager_categories AS c"
			. (($filter != '') ? "\n WHERE c.id IN ( ".$filter." )" : '')
			. "\n ORDER BY c.ordering"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>