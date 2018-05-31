<?php
/**
 * JComments plugin for VirtueMart objects support
 *
 * @version 1.4
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

class jc_com_virtuemart extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT product_name FROM #__vm_product WHERE product_id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_virtuemart' );

		$db = & JCommentsFactory::getDBO();

		$query = "SELECT CONCAT('index.php?option=com_virtuemart&page=shop.product_details&flypage=', c.category_flypage,'&category_id=',c.category_id,'&product_id=', a.product_id, '&Itemid=".$_Itemid."' )"
			. "\n FROM #__vm_product AS a"
			. "\n LEFT JOIN #__vm_product_category_xref AS b ON b.product_id = a.product_id"
			. "\n LEFT JOIN #__vm_category AS c ON b.category_id = c.category_id"
			. "\n WHERE a.product_id = '$id'"
			;
		$db->setQuery($query);
		$link = JoomlaTuneRoute::_($db->loadResult());
		return $link;
	}
}
?>