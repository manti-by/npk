<?php
/**
 * JTHelpers - JoomlaTune Helpers
 *
 * Route helper
 *
 * @version 1.0
 * @package JTHelpers
 * @filename route.php
 * @author Sergey M. Litvinov (smart@joomlatune.ru) & Dmitriy V. Smirnov (mitrich@joomlaportal.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JoomlaTune someplace in your code
 * and provide a link to http://www.joomlatune.ru
 **/

// ensure this file is being included by a parent file
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');
class JTRoute
{
    // version of helper to compare in future
    var $version = '1.0';

	function _($value,$msg = '')
	{
		if (JOOMLA_JVERSION == '1.5') {
			// Replace all &amp; with & as the router doesn't understand &amp;
			$url = str_replace('&amp;', '&', $value);
			$url = str_replace('&no_html=1', '&tmpl=component', $url);
			if(substr(strtolower($url),0,9) != "index.php") return $url;
			$uri    = JURI::getInstance();
			$prefix = $uri->toString(array('scheme', 'host', 'port'));
			return $prefix.JRoute::_($url);
		} else {
			return sefRelToAbs($value,$msg);
		}
	}
}
?>