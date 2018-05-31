<?php
/**
 * JComments - Joomla Comment System
 *
 * Backend uninstall handler
 *
 * @version 2.0
 * @package JComments
 * @subpackage Installer
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

// include legacy class
if (defined('JPATH_ROOT')) {
	include_once (JPATH_ROOT . DS . 'components' . DS . 'com_jcomments' . DS . 'jcomments.legacy.php');
	include_once (JPATH_ROOT . DS . 'components' . DS . 'com_jcomments' . DS . 'jcomments.class.php');
} else {
	global $mainframe;
	include_once ($mainframe->getCfg('absolute_path') . DS . 'components' . DS . 'com_jcomments' . DS . 'jcomments.legacy.php');
	include_once ($mainframe->getCfg('absolute_path') . DS . 'components' . DS . 'com_jcomments' . DS . 'jcomments.class.php');
}

include_once (dirname(__FILE__) . DS . 'install' . DS . 'helpers' . DS . 'installerhelper.php');

function com_uninstall()
{
	global $mainframe;

	$versionInfo = JCommentsInstallerHelper::getVersionInfo('jcomments');
?>
<style>
div#jc {
	width: 600px;
	margin: 0 auto;
}

.statuserr {
	color: red;
}

.statusok {
	color: green;
}

span.copyright {
	color: #777;
	display: block;
	margin-top: 12px;
}

div#element-box span.componentname {
	color: #FF9900;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}

div#element-box span.componentdate {
	color: #FF9900;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: normal;
}

div#element-box span.installheader {
	color: #FF9900;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
</style>

<div id="jc">

<div id="element-box">
<div class="t">
<div class="t">
<div class="t"></div>
</div>
</div>
<div class="m">

<table width="95%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="top" align="left">
		<td width="50px"><img
			src="http://www.joomlatune.com//images/banners/jcomments_logo.png"
			width="48" height="48" border="0" alt="" /></td>
		<td><span class="componentname">JComments <?php echo $versionInfo->releaseVersion; ?></span>
		<span class="componentdate">[<?php echo $versionInfo->releaseDate; ?>]</span><br />
		<span class="copyright">&copy; 2006-2008 smart (<a
			href="http://www.joomlatune.ru" target="_blank">JoomlaTune.ru</a> | <a
			href="http://www.joomlatune.com" target="_blank">JoomlaTune.com</a>). <?php echo JText::_('All rights reserved!');?><br />
		</span></td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<table width="95%" border="0" cellpadding="0" cellspacing="0">

		<tr valign="top" align="left">
			<td>&nbsp;</td>
			<td><span class="installheader"><?php echo JText::_('Uninstall log'); ?></span>
			</td>
		</tr>
		<tr valign="top" align="left">
			<td>&nbsp;</td>
			<td>
			<ul style="padding: 0 0 0 20px; marign: 0;">
<?php

	if (JCOMMENTS_JVERSION == '1.0') {
		$_MAMBOTS_PATH = $mainframe->getCfg('absolute_path') . DS . 'mambots';
		$_MAMBOTS_TABLE = '#__mambots';

		global $database;
		$db = $database;

	} else if (JCOMMENTS_JVERSION == '1.5') {
		$_MAMBOTS_PATH = JPATH_ROOT . DS . 'plugins';
		$_MAMBOTS_TABLE = '#__plugins';

		$db = &JFactory::getDBO();
	}

	$db->setQuery("DELETE FROM `" . $_MAMBOTS_TABLE . "` WHERE `element` = 'jcomments.content';");
	@$db->query();
	@unlink($_MAMBOTS_PATH . DS . 'content' . DS . 'jcomments.content.php');
	@unlink($_MAMBOTS_PATH . DS . 'content' . DS . 'jcomments.content.xml');

?>
			<li><?php echo JText::_('Uninstall content plugin'); ?>: <span
					style="color: green">OK</li>
<?php
	$db->setQuery("DELETE FROM `" . $_MAMBOTS_TABLE . "` WHERE `element` = 'jcomments.system';");
	@$db->query();
	@unlink($_MAMBOTS_PATH . DS . 'system' . DS . 'jcomments.system.php');
	@unlink($_MAMBOTS_PATH . DS . 'system' . DS . 'jcomments.system.xml');
?>
			<li><?php echo JText::_('Uninstall system plugin'); ?>: <span
					style="color: green">OK</li>
<?php
	$db->setQuery("DELETE FROM `" . $_MAMBOTS_TABLE . "` WHERE `element` = 'jcomments.search';");
	@$db->query();
	@unlink($_MAMBOTS_PATH . DS . 'search' . DS . 'jcomments.search.php');
	@unlink($_MAMBOTS_PATH . DS . 'search' . DS . 'jcomments.search.xml');
?>
			<li><?php echo JText::_('Uninstall search plugin'); ?>: <span
					style="color: green">OK</li>
<?php
	$db->setQuery("DELETE FROM `" . $_MAMBOTS_TABLE . "` WHERE `element` = 'jcommentson';");
	@$db->query();
	@unlink($_MAMBOTS_PATH . DS . 'editors-xtd' . DS . 'jcommentson.gif');
	@unlink($_MAMBOTS_PATH . DS . 'editors-xtd' . DS . 'jcommentson.php');
	@unlink($_MAMBOTS_PATH . DS . 'editors-xtd' . DS . 'jcommentson.xml');

	$db->setQuery("DELETE FROM `" . $_MAMBOTS_TABLE . "` WHERE `element` = 'jcommentsoff';");
	@$db->query();
	@unlink($_MAMBOTS_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.gif');
	@unlink($_MAMBOTS_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.php');
	@unlink($_MAMBOTS_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.xml');
?>
			<li><?php echo JText::_('Uninstall editors-xtd plugins'); ?>: <span
					style="color: green">OK</li>
<?php
	// Clean all caches for components with comments
	if ($mainframe->getCfg('caching') == 1) {
		$db->setQuery("SELECT DISTINCT(object_group) AS name FROM #__jcomments");
		$rows = $db->loadObjectList();

		foreach ($rows as $row) {
			JCommentsCache::cleanCache($row->name);
		}
		unset($rows);
?>
			<li><?php echo JText::_('Clean components cache'); ?>: <span
					style="color: green">OK</li>
<?php
	}
?>
			<li><span style="color: green"><b><?php echo JText::_('JComments uninstalled'); ?></b></span></li>
			</ul>
			</td>
		</tr>
	</table>

	</div>
	<div class="b">
	<div class="b">
	<div class="b"></div>
	</div>
	</div>
	</div>

	</div>
<?php
}
?>