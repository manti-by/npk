<?php
/**
 * JTHelpers - JoomlaTune Helpers
 *
 * Input Legacy Helper
 *
 * @version 1.0
 * @package JTHelpers
 * @filename input.php
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
class JTInput
{
    // version of helper to compare in future
    var $version = '1.0';

	function getParam( &$arr, $name, $def=null, $mask=0 )
	{
		if (JOOMLA_JVERSION == '1.5')
		{
			// Static input filters for specific settings
			static $noHtmlFilter	= null;
			static $safeHtmlFilter	= null;

			$var = JArrayHelper::getValue( $arr, $name, $def, '' );

			// If the no trim flag is not set, trim the variable
			if (!($mask & 1) && is_string($var)) {
				$var = trim($var);
			}

			// Now we handle input filtering
			if ($mask & 2) {
				// If the allow html flag is set, apply a safe html filter to the variable
				if (is_null($safeHtmlFilter)) {
					$safeHtmlFilter = & JFilterInput::getInstance(null, null, 1, 1);
				}
				$var = $safeHtmlFilter->clean($var, 'none');
			} elseif ($mask & 4) {
				// If the allow raw flag is set, do not modify the variable
				$var = $var;
			} else {
				// Since no allow flags were set, we will apply the most strict filter to the variable
				if (is_null($noHtmlFilter)) {
					$noHtmlFilter = & JFilterInput::getInstance(/* $tags, $attr, $tag_method, $attr_method, $xss_auto */);
				}
				$var = $noHtmlFilter->clean($var, 'none');
			}
			return $var;
		}
		return mosGetParam($arr, $name, $def, $mask);
	}
}
?>