<?php
/**
 * Joomla version defines
 *
 * @version 1.0
 * @package JoomlaTune.Framework
 * @subpackage Joomla
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 * @access public
 */

if (!defined('JOOMLATUNE_JVERSION')) {
	if (defined('_JEXEC') && class_exists('JApplication')) {
		define('JOOMLATUNE_JVERSION', '1.5');

		if (!defined('_ISO')) {
			define('_ISO', 'charset=utf-8');
		}

		$config = & JFactory::getConfig();

		if (!$config->getValue('config.legacy')) {
			$config->setValue('config.live_site', substr_replace(JURI::root(), '', -1, 1));
			$config->setValue('config.absolute_path', JPATH_SITE);
			$config->setValue('config.cachepath', JPATH_BASE . DS . 'cache');

			$lang = & JFactory::getLanguage();
			$config->setValue('config.lang', $lang->getBackwardLang());

			if (!class_exists('mosDBTable')) {
				class mosDBTable extends JTable
				{
					function mosDBTable( $table, $key, &$db )
					{
						parent::__construct($table, $key, $db);
					}
				}
			}
		} else {
			$config->setValue('config.cachepath', JPATH_BASE . DS . 'cache');
		}

		if (empty($GLOBALS['my'])) {
			$user	=& JFactory::getUser();
			$GLOBALS['my'] = (object)$user->getProperties();
			$GLOBALS['my']->gid = $user->get('aid', 0);
		}
	} else {
		define('JOOMLATUNE_JVERSION', '1.0');
	}
}
?>