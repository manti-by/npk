<?php
/**
 * JComments - Joomla Comment System
 *
 * Service functions for JComments system plugin
 *
 * @version 2.0
 * @package JComments
 * @subpackage Helpers
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project, 
 * please make a reference to JComments someplace in your code 
 * and provide a link to http://www.joomlatune.ru
 **/

/**
 * JComments System Plugin Helper
 * 
 * @static
 * @package JComments
 * @subpackage Helpers
 */
class JCommentsSystemPluginHelper
{
	/**
	 *
	 * @access private
	 * @return string
	 */
	function getCompressedJS()
	{
		$link = JCommentsFactory::getLink('gzip');
		$html = '<script src="' . $link . '&amp;target=js' . '" type="text/javascript"></script>';
		return $html;
	}

	/**
	 *
	 * @access private
	 * @return string
	 */
	function getCoreJS()
	{
	        global $mainframe;

		$html = '<script src="' . $mainframe->getCfg('live_site') . '/components/com_jcomments/js/jcomments-v2.0.js" type="text/javascript"></script>';
		return $html;
	}

	/**
	 *
	 * @access private
	 * @return string
	 */
	function getAjaxJS()
	{
	        global $mainframe;

		$html = '<script src="' . $mainframe->getCfg('live_site') . '/components/com_jcomments/libraries/joomlatune/ajax.js" type="text/javascript"></script>';
		return $html;
	}
}
?>