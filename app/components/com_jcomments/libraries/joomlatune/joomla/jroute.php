<?php
/**
 * JTHelpers - JoomlaTune Helpers
 *
 * Route helper
 *
 * @version 1.0
 * @package JTHelpers
 * @filename route.php
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/
class JoomlaTuneRoute
{
	function _( $value, $msg = '' )
	{
		if (JOOMLATUNE_JVERSION === '1.5') {
			$url = str_replace('&amp;', '&', $value);
			$url = str_replace('&no_html=1', '&tmpl=component', $url);
			if (substr(strtolower($url),0,9) != "index.php") {
				return $url;
			}
			$uri = JURI::getInstance();
			$prefix = $uri->toString(array('scheme', 'host', 'port'));
			return $prefix.JRoute::_($url);
		} else {
			return sefRelToAbs($value,$msg);
		}
	}
}
?>