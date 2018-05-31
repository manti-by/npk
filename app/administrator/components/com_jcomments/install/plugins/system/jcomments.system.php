<?php
/**
 * JComments - Joomla Comment System
 *
 * System mambot for attaching JComments CSS to HEAD tag
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project, 
 * please make a reference to JComments someplace in your code 
 * and provide a link to http://www.joomlatune.ru
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

if (defined('JPATH_ROOT') && defined('JPATH_LIBRARIES')) {
	global $mainframe;
	$mainframe->registerEvent('onAfterRoute', 'plgSystemJComments');
} else {
	global $_MAMBOTS;
	$_MAMBOTS->registerFunction('onAfterStart', 'plgSystemJComments');
}

function plgSystemJComments()
{
	if (defined('JPATH_ROOT') && defined('JPATH_LIBRARIES') && (!defined('_BF_PLATFORM'))) {
		include_once (JPATH_ROOT . DS . 'components' . DS . 'com_jcomments' . DS . 'jcomments.legacy.php');
	} else {
		global $mosConfig_absolute_path;
		include_once ($mosConfig_absolute_path . DS . 'components' . DS . 'com_jcomments' . DS . 'jcomments.legacy.php');
	}
	
	// if component doesnt exists (may be already uninstalled) - return
	if (!defined('JCOMMENTS_JVERSION')) {
		return;
	}
	
	if (JCOMMENTS_JVERSION == '1.5') {
		$mainframe = & JFactory::getApplication('site');
		$mainframe->getRouter();
		$document = & JFactory::getDocument();

		if($document->getType() == 'pdf') {
			return;
		}

		if ($mainframe->isAdmin()) {
			$document->addStyleSheet(JURI::root() . 'administrator/components/com_jcomments/images/icon.css');
		} else {
			include_once (JCOMMENTS_BASE . DS . 'jcomments.class.php');
			include_once (JCOMMENTS_BASE . DS . 'jcomments.config.php');
		
			$config = & JCommentsCfg::getInstance();
			$template = $config->get('template');
			
			$cssPath = $mainframe->getCfg('absolute_path') . DS . 'templates' . DS . $mainframe->getTemplate() . DS . 'jcomments' . DS . $template . DS . 'style.css';
			$cssUrl = JURI::root() . 'templates/' . $mainframe->getTemplate() . '/jcomments/' . $template . '/style.css';
			
			if (!is_file($cssPath)) {
				$cssUrl = JURI::root() . 'components/com_jcomments/tpl/' . $template . '/style.css';
			}
			
			// include JComments CSS
			$document->addStyleSheet($cssUrl);
		}
	} else {
		global $mosConfig_live_site, $mainframe;
		
		include_once (JCOMMENTS_BASE . DS . 'jcomments.class.php');
		include_once (JCOMMENTS_BASE . DS . 'jcomments.config.php');
		
		$config = & JCommentsCfg::getInstance();
		$template = $config->get('template');
		$cssUrl = $mosConfig_live_site . '/components/com_jcomments/tpl/' . $template . '/style.css';
		
		// include JComments CSS
		$mainframe->addCustomHeadTag('<link href="' . $cssUrl . '" rel="stylesheet" type="text/css" />');
	}

	if (!defined('JCOMMENTS_CSS')) {
		define('JCOMMENTS_CSS', 1);
	}

	if (!$mainframe->isAdmin()) {
		include_once (JCOMMENTS_HELPERS . DS . 'systemplugin.php');

		// include JComments JavaScript library
		if ($config->getInt('gzip_js') == 1) {
			$mainframe->addCustomHeadTag(JCommentsSystemPluginHelper::getCompressedJS());
		} else {
			$mainframe->addCustomHeadTag(JCommentsSystemPluginHelper::getCoreJS());
			if (!defined('JOOMLATUNE_AJAX_JS')) {
				$mainframe->addCustomHeadTag(JCommentsSystemPluginHelper::getAjaxJS());
				define('JOOMLATUNE_AJAX_JS', 1);
			}
		}
	
		if (!defined('JCOMMENTS_JS')) {
			define('JCOMMENTS_JS', 1);
		}
	}
} 
?>