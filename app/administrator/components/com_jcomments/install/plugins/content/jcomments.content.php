<?php
/**
 * JComments - Joomla Comment System
 *
 * Mambot for attaching comments list and form to content item
 *
 * @version 2.0
 * @package JComments
 * @subpackage Content
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project, 
 * please make a reference to JComments someplace in your code 
 * and provide a link to http://www.joomlatune.ru
 **/

// ensure this file is being included by a parent file
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

global $mainframe;

if (defined('JPATH_ROOT')) {
	include_once (JPATH_ROOT . DS . 'components' . DS . 'com_jcomments' . DS . 'jcomments.legacy.php');
} else {
	include_once ($mainframe->getCfg('absolute_path') . DS . 'components' . DS . 'com_jcomments' . DS . 'jcomments.legacy.php');
}

// if component doesnt exists (may be already uninstalled) - return
if (!defined('JCOMMENTS_JVERSION')) {
	return;
}

if (JCOMMENTS_JVERSION == '1.0') {
	$_MAMBOTS->registerFunction('onAfterDisplayContent', 'plgContentJCommentsViewJ10');
	$_MAMBOTS->registerFunction('onPrepareContent', 'plgContentJCommentsLinksJ10');
} else if (JCOMMENTS_JVERSION == '1.5') {
	$mainframe->registerEvent('onAfterDisplayContent', 'plgContentJCommentsViewJ15');
	$mainframe->registerEvent('onPrepareContent', 'plgContentJCommentsLinksJ15');
	$GLOBALS['JC_CONTENT_TASK'] = JRequest::getCmd('view') == 'article' ? 'view' : '';
}

function plgContentJCommentsViewJ10( &$row, &$params, $page = 0)
{
	global $task, $option;

	if (!isset($params)) {
		$params = new mosParameters('');
	}

	$pvars = array_keys(get_object_vars($params->_params));
	
	if ($params->get('popup') || in_array('moduleclass_sfx', $pvars)) {
		return '';
	}
	
	if (isset($GLOBALS['jcomments_params_readmore'])
	&& isset($GLOBALS['jcomments_row_readmore'])) {
		$params->set('readmore', $GLOBALS['jcomments_params_readmore']);
		$row->readmore = $GLOBALS['jcomments_row_readmore'];
	}

	require_once (JCOMMENTS_BASE . DS . 'jcomments.php');
	require_once (JCOMMENTS_HELPERS . DS . 'contentplugin.php');

	JCommentsContentPluginHelper::processForeignTags($row, false, false);
	
	if (JCommentsContentPluginHelper::isDisabled($row)) {
		return '';
	}

	if (($task == 'view')
	&& (JCommentsContentPluginHelper::checkCategory($row->catid)
		|| JCommentsContentPluginHelper::isEnabled($row))) {

		if (JCommentsContentPluginHelper::isLocked($row)) {
			$config = & JCommentsFactory::getConfig();
			$config->set('object_locked', 1);
		}
		return JComments::show($row->id, 'com_content', $row->title);
	} else if (($option == 'com_events') && ($task == 'view_detail')) {
		return JComments::show($row->id, 'com_events', $row->title);
	}
	return '';
}

function plgContentJCommentsLinksJ10( $published, &$row, &$params, $page = 0)
{
	global $mainframe, $task, $option, $Itemid, $my;
		
	// disable comments link in 3rd party components (except Events and AlphaContent)
	if ($option != 'com_content' && $option != 'com_frontpage' 
	&& $option != 'com_alphacontent' && $option != 'com_events') {
		return;
	}

	require_once (JCOMMENTS_HELPERS . DS . 'plugin.php');
	require_once (JCOMMENTS_HELPERS . DS . 'contentplugin.php');
	
	if (!isset($params) || $params == null) {
		$params = new mosParameters('');
	}

	$pvars = array_keys(get_object_vars($params->_params));
	if (!$published || $params->get('popup') || in_array('moduleclass_sfx', $pvars)) {
		JCommentsContentPluginHelper::processForeignTags($row, true);
		JCommentsContentPluginHelper::clear($row, true);
		return;
	}

	if ($option == 'com_frontpage') {
		$pluginParams = JCommentsPluginHelper::getParams('jcomments.content', 'content');
		if ((int)$pluginParams->get('show_frontpage', 1) == 0) {
			return;
		}
	}

	require_once (JCOMMENTS_BASE . DS . 'jcomments.php');

	if ($task != 'view') {
		// replace other comment systems tags to JComments equivalents like {jcomment on} 
		JCommentsContentPluginHelper::processForeignTags($row, false);           

		// show link to comments only
		$count = JComments::getCommentsCount($row->id, 'com_content');

		if ($row->access <= $my->gid) {
			$compat = $mainframe->getCfg('itemid_compat');

			if ($compat == null) {
				// Joomla 1.0.12 or below
				if ($Itemid && $Itemid != 99999999) {
					$_Itemid = $Itemid;
				} else {
					$_Itemid = $mainframe->getItemid($row->id);
				}
			} else if ((int) $compat > 0 && (int) $compat <= 11) {
				// Joomla 1.0.13 or higher and Joomla 1.0.11 compability
				$_Itemid = $mainframe->getItemid($row->id, 0, 0);
			} else {
				// Joomla 1.0.13 or higher and new Itemid algoritm
				$_Itemid = $Itemid;
			}

			$link = sefRelToAbs("index.php?option=com_content&amp;task=view&amp;id=$row->id&amp;Itemid=$_Itemid");
			$readmore_register = 0;
		} else {
			$link = sefRelToAbs('index.php?option=com_registration&amp;task=register');
			$readmore_register = 1;
		}
		
		$tmpl = & JCommentsFactory::getTemplate($row->id, 'com_content', false);
		$tmpl->load('tpl_links');
		
		$tmpl->addVar('tpl_links', 'comments-count', $count);
		$tmpl->addVar('tpl_links', 'comments_link_style', ($readmore_register ? -1 : $count));
		$tmpl->addVar('tpl_links', 'readmore_register', $readmore_register);
		$tmpl->addVar('tpl_links', 'link-comment', $link);
		$tmpl->addVar('tpl_links', 'link-readmore', $link);
		$tmpl->addVar('tpl_links', 'content-item', $row);
		
		if (($params->get('readmore') == 0) || (@$row->readmore == 0)) {
			$tmpl->addVar('tpl_links', 'readmore_link_hidden', 1);
		} else if (@$row->readmore > 0) {
			$tmpl->addVar('tpl_links', 'readmore_link_hidden', 0);
		}
		
		if (!JCommentsContentPluginHelper::checkCategory($row->catid)) {
			$tmpl->addVar('tpl_links', 'comments_link_hidden', 1);
		}

		if (JCommentsContentPluginHelper::isDisabled($row, true)) {
			$tmpl->addVar('tpl_links', 'comments_link_hidden', 1);
		} else if (JCommentsContentPluginHelper::isEnabled($row, true)) {
			$tmpl->addVar('tpl_links', 'comments_link_hidden', 0);
		}
		
		if ($readmore_register == 1 && $count == 0) {
			$tmpl->addVar('tpl_links', 'comments_link_hidden', 1);
		}

		if ($readmore_register == 1) {
			$readmore_text = JText::_('READMORE_REGISTER');
		} else {
			$readmore_text = JText::_('READMORE');
		}

		$tmpl->addVar('tpl_links', 'link-readmore-text', $readmore_text);
			
		JCommentsContentPluginHelper::clear($row, true);

		$row->text .= $tmpl->renderTemplate('tpl_links');

		$GLOBALS['jcomments_params_readmore'] = $params->get('readmore');
		$GLOBALS['jcomments_row_readmore'] = $row->readmore;

		$params->set('readmore', 0);
		$row->readmore = 0;
	} else {
		JCommentsContentPluginHelper::processForeignTags($row, true);
		JCommentsContentPluginHelper::clear($row, true);
	}
	return;
} 

function plgContentJCommentsViewJ15( &$row, &$params, $page = 0 )
{
	require_once (JCOMMENTS_HELPERS . DS . 'contentplugin.php');

	$application = &JFactory::getApplication('site');
	$view = JRequest::getCmd('view');

	// check whether plugin has been unpublished
	if (!JPluginHelper::isEnabled('content', 'jcomments.content') 
	|| ($view != 'article')
	|| $params->get('intro_only')
	|| $params->get('popup') 
	|| JRequest::getBool('fullview')
	|| JRequest::getVar('print')) {
		JCommentsContentPluginHelper::clear($row, true);
		return '';
	}

	$isEnabled = (isset($GLOBALS['JC_CONTENT_COMMENTS_ON']) && $GLOBALS['JC_CONTENT_COMMENTS_ON'] == true);
	$isDisabled = (isset($GLOBALS['JC_CONTENT_COMMENTS_OFF']) && $GLOBALS['JC_CONTENT_COMMENTS_OFF'] == true);

	// check for presence of {jcomments off} which is explicits disables this bot for the item
	if ($isDisabled) {
		return '';
	}

	require_once (JCOMMENTS_BASE . DS . 'jcomments.php');

	JCommentsContentPluginHelper::processForeignTags($row, false, false);

	if ($view == 'article') {
		if ($isEnabled || JCommentsContentPluginHelper::checkCategory($row->catid)) {
			JCommentsContentPluginHelper::clear($row, true);			

			if (isset($GLOBALS['JC_CONTENT_COMMENTS_LOCKED'])
			&& $GLOBALS['JC_CONTENT_COMMENTS_LOCKED'] == true) {
				$config = & JCommentsFactory::getConfig();
	        		$config->set('object_locked', 1);
			}
			return JComments::show($row->id, 'com_content', $row->title);
		}
	}
	return '';
}

function plgContentJCommentsLinksJ15( &$row, &$params, $page = 0)
{
	require_once (JCOMMENTS_HELPERS . DS . 'plugin.php');
	require_once (JCOMMENTS_HELPERS . DS . 'contentplugin.php');
	
	// check whether plugin has been unpublished
	if (!JPluginHelper::isEnabled('content', 'jcomments.content')) {
		JCommentsContentPluginHelper::clear($row, true);
		return;
	}

	$application = &JFactory::getApplication('site');

	$option = JRequest::getCmd('option');
	$view = JRequest::getCmd('view');
	
	if (!isset($row->id) || ($option != 'com_content' && $option != 'com_alphacontent')) {
		return;
	}
	
	if ($view == 'frontpage') {
		$pluginParams = JCommentsPluginHelper::getParams('jcomments.content', 'content');
		if ((int) $pluginParams->get('show_frontpage', 1) == 0) {
			return;
		}
	}

	if (!isset($params) || $params == null) {
		$params = new JParameter('');
	}
	
	require_once (JCOMMENTS_BASE . DS . 'jcomments.php');
	
	JCommentsContentPluginHelper::processForeignTags($row, false);
	
	$GLOBALS['JC_CONTENT_COMMENTS_ON'] = JCommentsContentPluginHelper::isEnabled($row, false);
	$GLOBALS['JC_CONTENT_COMMENTS_OFF'] = JCommentsContentPluginHelper::isDisabled($row, false);
	$GLOBALS['JC_CONTENT_COMMENTS_LOCKED'] = JCommentsContentPluginHelper::isLocked($row, false);
	
	if ($view != 'article') {
		// show link to comments only
		$count = JComments::getCommentsCount($row->id, 'com_content');
		
		$user = & JFactory::getUser();
		
		if ($row->access <= $user->get('aid', 0)) {
			$readmore_link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
			$readmore_register = 0;
		} else {
			$readmore_link = JRoute::_('index.php?option=com_user&task=register');
			$readmore_register = 1;
		}

		$link = $readmore_link;
			
		// load template for comments & readmore links
		$tmpl = & JCommentsFactory::getTemplate($row->id, 'com_content', false);
		$tmpl->load('tpl_links');
		
		$tmpl->addVar('tpl_links', 'comments-count', $count);
		$tmpl->addVar('tpl_links', 'comments_link_style', ($readmore_register ? -1 : $count));
		$tmpl->addVar('tpl_links', 'readmore_register', $readmore_register);
		$tmpl->addVar('tpl_links', 'link-comment', $link);
		$tmpl->addVar('tpl_links', 'link-readmore', $link);
		$tmpl->addVar('tpl_links', 'content-item', $row);
					
		if ((isset($row->params) && $row->params->get('show_readmore') == 0) 
		|| (@$row->readmore == 0)) {
			$tmpl->addVar('tpl_links', 'readmore_link_hidden', 1);
		} else if(@$row->readmore > 0) {
			$tmpl->addVar('tpl_links', 'readmore_link_hidden', 0);
		}

		if (!JCommentsContentPluginHelper::checkCategory($row->catid)) {
			$tmpl->addVar('tpl_links', 'comments_link_hidden', 1);
		}

		if ($GLOBALS['JC_CONTENT_COMMENTS_OFF']) {
			$tmpl->addVar('tpl_links', 'comments_link_hidden', 1);
		} else if ($GLOBALS['JC_CONTENT_COMMENTS_ON']) {
			$tmpl->addVar('tpl_links', 'comments_link_hidden', 0);
		}

		if ($readmore_register == 1 && $count == 0) {
			$tmpl->addVar('tpl_links', 'comments_link_hidden', 1);
		}

		if ($readmore_register == 1) {
			$readmore_text = JText::_('Register to read more...');
		} else if (isset($row->params) && $readmore = $row->params->get('readmore')) {
			$readmore_text = $readmore;
		} else {
			$readmore_text = JText::_('Read more...');
		}

		$tmpl->addVar('tpl_links', 'link-readmore-text', $readmore_text);

		JCommentsContentPluginHelper::clear($row, true);
		$row->text .= $tmpl->renderTemplate('tpl_links');
		$tmpl->freeTemplate('tpl_links');

		$row->readmore = 0;
		
		if (isset($row->params)) {
			$row->params->set('show_readmore', 0);
		}
		
		$row->readmore_link = '';
		$row->readmore_register = false;
	} else {
		JCommentsContentPluginHelper::clear($row, true);
	}
	return;
} 
?>