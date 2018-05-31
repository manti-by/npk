<?php
/**
 * JComments - Joomla Comment System
 *
 * Backend Installer
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

require_once (dirname(__FILE__) . DS . 'install' . DS . 'helpers' . DS . 'installerhelper.php');

class JCommentsInstaller
{
	function postInstall()
	{
		global $mainframe;

		$db = & JCommentsFactory::getDBO();

		$installer = new HTML_JCommentsInstaller();

		JCommentsInstallerHelper::setPermissions(JCOMMENTS_BASE . DS . 'tpl', '0666');

		// create database tables
		if (JCOMMENTS_JVERSION == '1.0') {
			$installSQL = dirname(__FILE__) . DS . 'install' . DS . 'sql' . DS . 'install.mysql.nonutf8.sql';
			JCommentsInstaller::executeSQL($installSQL);
		} else if (JCOMMENTS_JVERSION == '1.5') {
			$config = & JFactory::getConfig();
			if ($config->getValue('config.legacy')) {
				$installSQL = dirname(__FILE__) . DS . 'install' . DS . 'sql' . DS . 'install.mysql.utf8.sql';
				JCommentsInstaller::executeSQL($installSQL);

				require_once (JCOMMENTS_LIBRARIES . DS . 'joomlatune' . DS . 'filesystem.php');

				// path to languages directory
				$path = JCOMMENTS_BASE.DS.'languages';
				$jpath = JPATH_ROOT . DS . 'language';
				$languages = JoomlaTuneFS::readDirectory($path);

				if(!is_writable($jpath)) {
					@chmod($jpath, 0755);
				}

				foreach ($languages as $language) {
					if (preg_match("#[a-z]{2}\-[A-Z]{2}\.com_jcomments.ini#is", $language)) {
						$languageCode = substr($language, 0, 5);
						$languageDir = $jpath . DS . $languageCode;

						if (!is_dir($languageDir)) {
							if (!JFolder::create($languageDir)) {
								continue;
							}
						}

						if (is_dir($languageDir)) {
							@chmod($languageDir, 0755);
							$languageSrc = $path . DS . $language;
							$languageDest = $languageDir . DS . $language;

							if (!(@copy($languageSrc, $languageDest))) {
								$errorMessage = JText::sprintf('Unable to copy file %s to language folder. Please set write persmission to language folder (%s) and press the Refresh/Reload button of your browser.' , $language, $languageDir );
								$installer->addError($errorMessage);
								continue;
							}
						}
					}
				}
				unset($languages);

				$language = & JFactory::getLanguage();
				$language->load('com_jcomments', JPATH_SITE, null, true);
			}
		}

		$jxml10 = dirname(__FILE__) . DS . 'jcomments10.xml';
		$jxml15 = dirname(__FILE__) . DS . 'jcomments15.xml';
		$jxml = dirname(__FILE__) . DS . 'jcomments.xml';

		if (is_file($jxml10)) {
			@rename($jxml10, $jxml);
		} else if (is_file($jxml15)) {
			@rename($jxml15, $jxml);
		}
		unset($jxml10, $jxml15, $jxml);

		
		// small stuff for future update system
		$db->setQuery('SELECT version FROM `#__jcomments_version`');
		$version = $db->loadResult();
		
		if (empty($version)) {
			$versionInfo = JCommentsInstallerHelper::getVersionInfo('jcomments');
			$version = $versionInfo->releaseVersion;
			$currentDate = date('Y-m-d H:i:s');
			$query = "INSERT IGNORE INTO `#__jcomments_version` (`version`,`installed`) " . "VALUES ('$version', '$currentDate')";
			$db->setQuery($query);
			@$db->query();
		} else {
			$currentDate = date('Y-m-d H:i:s');
			$query = "UPDATE `#__jcomments_version` SET `version` = '$version', `updated` = '$currentDate')";
			$db->setQuery($query);
			@$db->query();
		}
		
		$_MAMBOTS_SRC_PATH = dirname(__FILE__) . DS . 'install' . DS . 'plugins';
		
		if (JCOMMENTS_JVERSION == '1.0') {
			$_MAMBOTS_NAME = 'mambots';
			$_MAMBOTS_DST_PATH = $mainframe->getCfg('absolute_path') . DS . 'mambots';
			$_MAMBOTS_TABLE = '#__mambots';
			$_MAMBOTS_SRC_EXT = 'x10';
		} else if (JCOMMENTS_JVERSION == '1.5') {
			$_MAMBOTS_NAME = 'plugins';
			$_MAMBOTS_DST_PATH = JPATH_ROOT . DS . 'plugins';
			$_MAMBOTS_TABLE = '#__plugins';
			$_MAMBOTS_SRC_EXT = 'x15';
		}

		if(!is_writable($_MAMBOTS_DST_PATH . DS)) {
			@chmod($_MAMBOTS_DST_PATH . DS, 0755);
		}

		if(!is_writable($_MAMBOTS_DST_PATH . DS . 'content' . DS)) {
			@chmod($_MAMBOTS_DST_PATH . DS . 'content' . DS, 0755);
		}

		if(!is_writable($_MAMBOTS_DST_PATH . DS . 'search' . DS)) {
			@chmod($_MAMBOTS_DST_PATH . DS . 'search' . DS, 0755);
		}


		// get info about max ordering value for mambots (plugins)
		$db->setQuery("SELECT folder, MAX(ordering) as maxid FROM `" . $_MAMBOTS_TABLE . "` GROUP BY `folder`;");
		$mambotsOrdering = @$db->loadObjectList('folder');
			
		// install JCommentsContentBot mambot for com_content
		$maxid = isset($mambotsOrdering['content']) ? intval($mambotsOrdering['content']->maxid) + 1 : 0;

		if (is_file($_MAMBOTS_DST_PATH . DS . 'content' . DS . 'jcomments.content.php')) {
			// remove old files
			$db->setQuery("DELETE FROM `" . $_MAMBOTS_TABLE . "` WHERE `element` = 'jcomments.content';");
			@$db->query();
			JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'content' . DS . 'jcomments.content.php');
			JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'content' . DS . 'jcomments.content.xml');
		}
	
		$res1 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'content' . DS . 'jcomments.content.php', $_MAMBOTS_DST_PATH . DS . 'content' . DS . 'jcomments.content.php');
		$res2 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'content' . DS . 'jcomments.content.' . $_MAMBOTS_SRC_EXT, $_MAMBOTS_DST_PATH . DS . 'content' . DS . 'jcomments.content.xml');
		$db->setQuery("INSERT INTO `" . $_MAMBOTS_TABLE . "` (`name`, `element`, `folder`, `access`, `ordering`, `published` ) VALUES ('Content - JComments', 'jcomments.content', 'content', 0, $maxid, 1 );");
		@$db->query();
		
		$result = $res1 && $res2;
		
		$installer->addMessage(JText::_('AI_INSTALL_CONTENTBOT'), $result);
		
		if (!$res1 || !$res2) {
			$installer->addWarning(JText::sprintf('AI_INSTALL_CONTENTBOT_WARNING', $_MAMBOTS_NAME));
		}
		
		if (is_file($_MAMBOTS_DST_PATH . DS . 'search' . DS . 'jcomments.search.php')) {
			// remove old files
			$db->setQuery("DELETE FROM `" . $_MAMBOTS_TABLE . "` WHERE `element` = 'jcomments.search';");
			@$db->query();
			JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'search' . DS . 'jcomments.search.php');
			JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'search' . DS . 'jcomments.search.xml');
		}
		
		// install search mambot for com_content comments
		$maxid = isset($mambotsOrdering['search']) ? intval($mambotsOrdering['search']->maxid) + 1 : 0;
		
		$res1 = $res2 = $res3 = false;
		$res1 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'search' . DS . 'jcomments.search.php', $_MAMBOTS_DST_PATH . DS . 'search' . DS . 'jcomments.search.php');
		$res2 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'search' . DS . 'jcomments.search.' . $_MAMBOTS_SRC_EXT, $_MAMBOTS_DST_PATH . DS . 'search' . DS . 'jcomments.search.xml');
		$db->setQuery("INSERT INTO `" . $_MAMBOTS_TABLE . "` (`name`, `element`, `folder`, `access`, `ordering`, `published` ) VALUES ('Search - JComments', 'jcomments.search', 'search', 0, $maxid, 1 );");
		$res3 = @$db->query();
		$result = $res1 && $res2 && $res3;
		
		$installer->addMessage(JText::_('AI_INSTALL_CONTENTSEARCHBOT'), $result);
		
		if (!$res1 || !$res2) {
			$installer->addWarning(JText::sprintf('AI_INSTALL_CONTENTSEARCHBOT_WARNING', $_MAMBOTS_NAME));
		}
			
		// install system mambot for embed css in page head
		if (is_dir($_MAMBOTS_DST_PATH . DS . 'system' . DS)) {

			if(!is_writable($_MAMBOTS_DST_PATH . DS . 'system' . DS)) {
				@chmod($_MAMBOTS_DST_PATH . DS . 'system' . DS, 0755);
			}
			
			if (is_file($_MAMBOTS_DST_PATH . DS . 'system' . DS . 'jcomments.system.php')) {
				// remove old files
				$db->setQuery("DELETE FROM `" . $_MAMBOTS_TABLE . "` WHERE `element` = 'jcomments.system';");
				@$db->query();
				JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'system' . DS . 'jcomments.system.php');
				JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'system' . DS . 'jcomments.system.xml');
			}
			
			$maxid = isset($mambotsOrdering['system']) ? intval($mambotsOrdering['system']->maxid) + 1 : 0;
			
			$res1 = $res2 = $res3 = false;
			$res1 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'system' . DS . 'jcomments.system.php', $_MAMBOTS_DST_PATH . DS . 'system' . DS . 'jcomments.system.php');
			$res2 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'system' . DS . 'jcomments.system.' . $_MAMBOTS_SRC_EXT, $_MAMBOTS_DST_PATH . DS . 'system' . DS . 'jcomments.system.xml');
			$db->setQuery("INSERT INTO `" . $_MAMBOTS_TABLE . "` (`name`, `element`, `folder`, `access`, `ordering`, `published` ) VALUES ('System - JComments', 'jcomments.system', 'system', 0, $maxid, 1 );");
			$res3 = @$db->query();
			$result = $res1 && $res2 && $res3;
			
			$installer->addMessage(JText::_('AI_INSTALL_SYSTEMBOT'), $result);
			
			if (!$res1 || !$res2) {
				$installer->addWarning(JText::sprintf('AI_INSTALL_SYSTEMBOT_WARNING', $_MAMBOTS_NAME));
			}
		}
			
		// install editor buttons
		if (is_dir($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS)) {
			if(!is_writable($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS)) {
				@chmod($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS, 0755);
			}
			// install JCommentsOn Button
			if (is_file($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentson.php')) {
				// remove old files
				$db->setQuery("DELETE FROM `" . $_MAMBOTS_TABLE . "` WHERE `element` = 'jcommentson';");
				@$db->query();
				JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentson.php');
				JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentson.xml');
				JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentson.gif');
			}
			
			$res1 = $res2 = $res3 = false;
			$res1 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'editors-xtd' . DS . 'jcommentson.php', $_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentson.php');
			$res2 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'editors-xtd' . DS . 'jcommentson.' . $_MAMBOTS_SRC_EXT, $_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentson.xml');
			$res3 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'editors-xtd' . DS . 'jcommentson.gif', $_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentson.gif');

			if (is_file($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentson.php')) {
				$db->setQuery("INSERT INTO `" . $_MAMBOTS_TABLE . "` (`name`, `element`, `folder`, `access`, `ordering`, `published`) VALUES ('Editor Button - JComments ON', 'jcommentson', 'editors-xtd', 0, 0, 1 );");
				$res4 = @$db->query();
			}
			//$result = $res1 && $res2 && $res3 && $res4;
			
			// install JCommentsOff Button
			if (is_file($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.php')) {
				// remove old files
				$db->setQuery("DELETE FROM `" . $_MAMBOTS_TABLE . "` WHERE `element` = 'jcommentsoff';");
				@$db->query();
				JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.php');
				JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.xml');
				JCommentsInstallerHelper::deleteFile($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.gif');
			}
			
			$res1 = $res2 = $res3 = false;
			$res1 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.php', $_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.php');
			$res2 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.' . $_MAMBOTS_SRC_EXT, $_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.xml');
			$res3 = JCommentsInstallerHelper::copyFile($_MAMBOTS_SRC_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.gif', $_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.gif');

			if (is_file($_MAMBOTS_DST_PATH . DS . 'editors-xtd' . DS . 'jcommentsoff.php')) {
				$db->setQuery("INSERT INTO `" . $_MAMBOTS_TABLE . "` (`name`, `element`, `folder`, `access`, `ordering`, `published`) VALUES ('Editor Button - JComments OFF', 'jcommentsoff', 'editors-xtd', 0, 0, 1 );");
				$res4 = @$db->query();
			}
			//$result = $res1 && $res2 && $res3 && $res4;
		}
			
		// Fix component menu icon
		if (JCOMMENTS_JVERSION == '1.0') {
			
			$menuiconpath = $mainframe->getCfg('absolute_path') . DS . 'includes' . DS . 'js' . DS . 'ThemeOffice';
			$adminIconsPath = '../administrator/components/com_jcomments/images';
			
			if (is_writable($menuiconpath)) {
				$currentIconsPath = dirname(__FILE__) . DS . 'images';
				
				ob_start();
				$res1 = $res2 = $res3 = $res4 = $res5 = false;
				$res1 = @copy($currentIconsPath . DS . 'jcomments16x16.png', $menuiconpath . DS . 'jcomments16x16.png');
				$res2 = @copy($currentIconsPath . DS . 'import16x16.png', $menuiconpath . DS . 'import16x16.png');
				$res3 = @copy($currentIconsPath . DS . 'settings16x16.png', $menuiconpath . DS . 'settings16x16.png');
				$res4 = @copy($currentIconsPath . DS . 'smiles16x16.png', $menuiconpath . DS . 'smiles16x16.png');
				$res5 = @copy($currentIconsPath . DS . 'edit16x16.png', $menuiconpath . DS . 'edit16x16.png');
				ob_end_clean();
				
				$result = $res1 && $res2 && $res3 && $res4 && $res5;
				
				if ($result && is_file($menuiconpath . DS . 'jcomments16x16.png')) {
					$adminIconsPath = 'js/ThemeOffice';
				}
			}
			
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/jcomments16x16.png' " . "\n WHERE admin_menu_link='option=com_jcomments'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/edit.png', name='" . JText::_('AI_MENU_COMMENTS') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=view'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/settings16x16.png', name='" . JText::_('AI_MENU_SETTINGS') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=settings'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/smiles16x16.png', name='" . JText::_('AI_MENU_SMILES') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=smiles'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/import16x16.png', name='" . JText::_('AI_MENU_IMPORT') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=import'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/jcomments16x16.png', name='" . JText::_('AI_MENU_ABOUT') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=about'");
			@$db->query();
			
			// clear Joostina administrative menu cache
			if (function_exists('js_menu_cache_clear')) {
				@js_menu_cache_clear();
			}
		} else {
			$db->setQuery("UPDATE #__components SET admin_menu_img='class:jcomments-logo' WHERE admin_menu_link='option=com_jcomments'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='class:jcomments-edit' WHERE admin_menu_link='option=com_jcomments&task=view'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='class:jcomments-settings' WHERE admin_menu_link='option=com_jcomments&task=settings'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='class:jcomments-smiles' WHERE admin_menu_link='option=com_jcomments&task=smiles'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='class:jcomments-import' WHERE admin_menu_link='option=com_jcomments&task=import'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='class:jcomments-logo' WHERE admin_menu_link='option=com_jcomments&task=about'");
			@$db->query();
		}
		
		$installer->addMessage(JText::_('AI_UPDATE_MENU_ICONS'), true);
		
		// auto upgrade old table structure
		$upgradeResult = JCommentsInstaller::upgradeStructure();
		if ($upgradeResult) {
			$installer->addMessage(JText::_('AI_UPGRADE_TABLES'), true);
		}
		
		// upgrade subscriptions to new comments
		$upgradeSubs = JCommentsInstaller::upgradeSubscriptions($version);
		if ($upgradeSubs) {
			$installer->addMessage(JText::_('Upgrade subscriptions'), true);
		}

		// collation synchonization (for MySQL 4.1.2 or higher)
		if (version_compare(preg_replace('~\-.+?$~', '', mysql_get_server_info()), '4.1.2') >= 0) {
			
			$db->setQuery("SELECT COUNT(*) FROM `#__jcomments`;");
			$cnt = $db->loadResult();
			
			// only if where are no comments
			if ($cnt == 0) {
				$collation = '';
				
				$db->setQuery("SHOW FULL COLUMNS FROM `#__content` LIKE 'title';");
				$rows = $db->loadObjectList();
				
				if (count($rows)) {
					$collation = $rows[0]->Collation;
				}
				
				if ($collation == '') {
					$row = null;
					$db->setQuery("SHOW VARIABLES LIKE 'collation_database';");
					
					if (JCOMMENTS_JVERSION == '1.5') {
						$config = &JFactory::getConfig();
						
						if ($config->getValue('config.legacy')) {
							$db->loadObject($row);
						} else {
							$row = $db->loadObject();
						}
					} else {
						$db->loadObject($row);
					}
					$collation = $row != null ? $row->Value : '';
				}
				
				// if collation not detemined - skip correction
				if ($collation != '') {
					$db->setQuery("SHOW FULL COLUMNS FROM `#__jcomments`;");
					$columns = $db->loadObjectList();
					
					$change_text = array();
					
					foreach ($columns as $column) {
						if (strpos($column->Type, 'text') !== false || strpos($column->Type, 'char') !== false) {
							$change_text[] = "CHANGE `" . $column->Field . "` `" . $column->Field . "` " . $column->Type . " COLLATE " . $collation . " NOT NULL DEFAULT ''";
						}
					}
					
					// change collation for #__jcomments
					$db->setQuery("ALTER TABLE `#__jcomments` " . implode(', ', $change_text) . ";");
					@$db->query();
					
					$db->setQuery("ALTER TABLE `#__jcomments` COLLATE " . $collation . ";");
					@$db->query();
					
					// change collation for #__jcomments_settings
					$db->setQuery("ALTER TABLE `#__jcomments_settings` CHANGE `value` `value` TEXT COLLATE " . $collation . " NOT NULL DEFAULT '';");
					@$db->query();
					
					$db->setQuery("ALTER TABLE `#__jcomments_settings` COLLATE " . $collation . ";");
					@$db->query();


					// change collation for #__jcomments_subscriptions
					$db->setQuery("SHOW FULL COLUMNS FROM `#__jcomments_subscriptions`;");
					$columns = $db->loadObjectList();
					
					$change_text = array();
					
					foreach ($columns as $column) {
						if (strpos($column->Type, 'text') !== false || strpos($column->Type, 'char') !== false) {
							$change_text[] = "CHANGE `" . $column->Field . "` `" . $column->Field . "` " . $column->Type . " COLLATE " . $collation . " NOT NULL DEFAULT ''";
						}
					}

					$db->setQuery("ALTER TABLE `#__jcomments_subscriptions` " . implode(', ', $change_text) . ";");
					@$db->query();
					
					$db->setQuery("ALTER TABLE `#__jcomments_subscriptions` COLLATE " . $collation . ";");
					@$db->query();
				}
			}
		}
		
		$db->setQuery("SELECT `name`, `value` FROM `#__jcomments_settings`");
		$paramsList = $db->loadObjectList('name');
		
		if (count($paramsList) == 0) {
			$defaultSettings = dirname(__FILE__) . DS . 'install' . DS . 'sql' . DS . 'settings.sql';
			JCommentsInstaller::executeSQL($defaultSettings);
		} else {
			JCommentsInstaller::checkParam($paramsList, 'message_locked', 'This content has been locked. You can no longer post any comment.');
			JCommentsInstaller::checkParam($paramsList, 'enable_mambots', '1');
			JCommentsInstaller::checkParam($paramsList, 'form_show', '1');
			JCommentsInstaller::checkParam($paramsList, 'display_author', 'name');
			JCommentsInstaller::checkParam($paramsList, 'can_vote', 'Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator');
			JCommentsInstaller::checkParam($paramsList, 'can_reply', 'Unregistered,Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator');
			JCommentsInstaller::checkParam($paramsList, 'enable_voting', '1');
			JCommentsInstaller::checkParam($paramsList, 'merge_time', '86400', true);
			JCommentsInstaller::checkParam($paramsList, 'gzip_js', '0');
			JCommentsInstaller::checkParam($paramsList, 'template_view', 'list', true);
		}
		
		unset($paramsList);
		
		$joomfish = $mainframe->getCfg('absolute_path') . DS . 'components' . DS . 'com_joomfish' . DS . 'joomfish.php';
		if (is_file($joomfish)) {
			JCommentsInstaller::upgradeLanguages();
		}

		// Update Artio JoomSEF configuration (add option to skip JComments urls)
		JCommentsInstaller::updateArtio();
		
		$installer->showInstallLog();
		
		JCommentsCache::cleanCache('com_jcomments');
		JCommentsCache::cleanCache('com_content');
	}

	function checkParam( $list, $param, $value, $required = false )
	{
		$dbo = & JCommentsFactory::getDBO();
		
		if (!isset($list[$param])) {
			$dbo->setQuery("INSERT INTO `#__jcomments_settings` VALUES ('', '', '$param', '$value');");
			@$dbo->query();
		} else if ($required && $list[$param]->value == '') {
			$dbo->setQuery("UPDATE `#__jcomments_settings` SET `value` = '$value' WHERE name = '$param';");
			@$dbo->query();
		}
	}

	function upgradeSubscriptions($version)
	{
		$dbo = & JCommentsFactory::getDBO();
		$dbo->setQuery("SELECT COUNT(*) FROM #__jcomments_subscriptions");
		$cnt = $dbo->loadResult();

		if ($cnt == 0) {
			$query = "INSERT INTO #__jcomments_subscriptions (`object_id`, `object_group`, `lang`, `userid`, `name`, `email`, `hash`, `published`)"
					. "\nSELECT DISTINCTROW `object_id`, `object_group`, `lang`, `userid`, `name`, `email`, md5(CONCAT(`object_id`,`object_group`,`email`)), 1"
					. "\nFROM #__jcomments"
					. "\nWHERE subscribe = 1"
					;
			$dbo->setQuery($query);
			$dbo->query();
			return true;
		} else {
			$query = 'UPDATE #__jcomments_subscriptions'
				. 'SET hash = MD5(CONCAT(CAST(object_id AS CHAR), object_group, CAST(userid AS CHAR), email, lang))';
			$dbo->query();
			return true;
		}
		return false;
	}
	
	function upgradeLanguages()
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			$languages = JLanguage::getKnownLanguages(JPATH_SITE);
			$dbo = & JCommentsFactory::getDBO();
			
			foreach ($languages as $language) {
				$backward = $language['backwardlang'];
				$tag = $language['tag'];
				
				if ($backward != '' && $tag != '') {
					$dbo->setQuery("UPDATE #__jcomments SET lang = '$tag' WHERE lang = '$backward'");
					$dbo->query();
				}
			}
		}
	}
	
	function upgradeStructure()
	{
		global $mainframe;
		
		$db = & JCommentsFactory::getDBO();
		
		// auto upgrade old table structure
		$db->setQuery("SHOW FIELDS FROM #__jcomments");
		$rows = $db->loadObjectList();
		$fields = array();
		
		foreach ($rows as $row) {
			$fields[] = strtolower($row->Field);
		}
		
		$flist = array_values($fields);
		$ures1 = $ures2 = $ures3 = $ures4 = false;
		
		if (!in_array('lang', $flist)) {
			$db->setQuery("ALTER TABLE `#__jcomments` ADD `lang` varchar(255) default '" . $mainframe->getCfg('lang') . "'; ");
			$ures1 = @$db->query();
		}
		if (!in_array('username', $flist)) {
			$db->setQuery("ALTER TABLE `#__jcomments` ADD `username` varchar(255) default NULL; ");
			$ures2 = @$db->query();
		}
		if (!in_array('subscribe', $flist)) {
			$db->setQuery("ALTER TABLE `#__jcomments` ADD `subscribe` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'; ");
			$ures3 = @$db->query();
			$db->setQuery("ALTER TABLE `#__jcomments` ADD INDEX `idx_subscribe`(`subscribe`); ");
			@$db->query();
		}
		if (!in_array('parent', $flist)) {
			$db->setQuery("ALTER TABLE `#__jcomments` ADD `parent` INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`; ");
			$ures4 = @$db->query();
		}
		if (!in_array('isgood', $flist)) {
			$db->setQuery("ALTER TABLE `#__jcomments` ADD `isgood` SMALLINT(5) UNSIGNED NOT NULL default '0' AFTER `date`; ");
			$ures4 = @$db->query();
		}
		if (!in_array('ispoor', $flist)) {
			$db->setQuery("ALTER TABLE `#__jcomments` ADD `ispoor` SMALLINT(5) UNSIGNED NOT NULL default '0' AFTER `isgood`; ");
			$ures4 = @$db->query();
		}
		unset($flist, $rows);
		
		// correction settings table structure
		$db->setQuery("SHOW FIELDS FROM #__jcomments_settings");
		$rows = $db->loadObjectList();
		$fields = array();
		
		foreach ($rows as $row) {
			$fields[] = strtolower($row->Field);
		}
		
		$flist = array_values($fields);
		
		if (!in_array('lang', $flist)) {
			$db->setQuery("ALTER TABLE `#__jcomments_settings` ADD `lang` VARCHAR(20) NOT NULL DEFAULT '' AFTER `component`; ");
			@$db->query();
			
			$db->setQuery("ALTER TABLE `#__jcomments_settings` DROP PRIMARY KEY;");
			@$db->query();
			
			$db->setQuery("ALTER TABLE `#__jcomments_settings` ADD PRIMARY KEY (`component`, `lang`, `name`);");
			@$db->query();
		}
		unset($flist, $rows);
		
		$db->setQuery("SHOW INDEX FROM #__jcomments");
		$indexes = $db->loadObjectList();
		$index_exists = false;
		
		foreach ($indexes as $index) {
			if ($index->Key_name == 'idx_object') {
				$index_exists = true;
				break;
			}
		}
		unset($indexes);
		
		if (!$index_exists) {
			$db->setQuery("ALTER TABLE #__jcomments ADD INDEX `idx_object` ( `object_id`, `object_group`, `published`, `date`);");
			@$db->query();
		}
		
		return ($ures1 || $ures2 || $ures3 || $ures4);
	}
	
	function updateArtio()
	{
	        global $mainframe;

		ob_start();

		$result = false;

		$artioSefPath = $mainframe->getCfg('absolute_path') . DS . 'administrator' . DS . 'components' . DS . 'com_sef';
		$artioSefCfg = $artioSefPath . DS . 'config.sef.php';
		$artioSefClass = $artioSefPath . DS . 'sef.class.php';

		if (!is_file($artioSefCfg)) {
			$artioSefCfg = $artioSefPath . DS . 'configuration.php';
			$artioSefClass = $artioSefPath . DS . 'classes' . DS . 'config.php';
		}

		if (is_file($artioSefCfg) && is_writable($artioSefCfg)) {
			global $sef_config_file;

			if (empty($sef_config_file)) {
				$sef_config_file = $artioSefCfg;
			}

			include_once($artioSefClass);

			if (class_exists('SEFConfig')) {
				$sefConfig = new SEFConfig();

				if (!in_array('com_jcomments', $sefConfig->skip)) {
					$sefConfig->skip[] = 'com_jcomments';
					$sefConfig->saveConfig(0, 1);
					$fn = dirname(__FILE__) . DS . 'configuration.php';
					if (is_file($fn)) {
						@rename($fn, $artioSefCfg);
					}
					$result = true;
				}
			}
		}

		$contents = ob_get_contents();
		ob_end_clean();

		return $result;
	}
	
	function systemInfo()
	{
		global $mainframe;
		
		$db = & JCommentsFactory::getDBO();
		
		$lists['mysql.version'] = mysql_get_server_info();
		
		// Charset & collation synchonization (for MySQL 4.1.2 or higher)
		if (version_compare(preg_replace('~\-.+?$~', '', mysql_get_server_info()), '4.1.2') >= 0) {
			$prefix = $mainframe->getCfg('dbprefix');
			
			$db->setQuery("SHOW FULL COLUMNS FROM `#__content` LIKE 'title';");
			$rows = $db->loadObjectList();
			$lists[$prefix . 'content.collation'] = count($rows) ? $rows[0]->Collation : '';
			
			$db->setQuery("SHOW FULL COLUMNS FROM `#__jcomments` LIKE 'comment';");
			$rows = $db->loadObjectList();
			$lists[$prefix . 'jcomments.collation'] = count($rows) ? $rows[0]->Collation : '';
			
			$row = null;
			$db->setQuery("SHOW VARIABLES LIKE 'collation_database';");
			
			if (JCOMMENTS_JVERSION == '1.5') {
				$config = &JFactory::getConfig();
				
				if ($config->getValue('config.legacy')) {
					$db->loadObject($row);
				} else {
					$row = $db->loadObject();
				}
			} else {
				$db->loadObject($row);
			}
			$lists['global.collation_database'] = $row != null ? $row->Value : '';
			
			$row = null;
			$db->setQuery("SELECT @@session.collation_database As Value;");
			if (JCOMMENTS_JVERSION == '1.5') {
				$config = &JFactory::getConfig();
				
				if ($config->getValue('config.legacy')) {
					$db->loadObject($row);
				} else {
					$row = $db->loadObject();
				}
			} else {
				$db->loadObject($row);
			}
			$lists['session.collation_database'] = $row != null ? $row->Value : '';
			
			$row = null;
			$db->setQuery("SHOW VARIABLES LIKE 'character_set_database';");
			if (JCOMMENTS_JVERSION == '1.5') {
				$config = &JFactory::getConfig();
				
				if ($config->getValue('config.legacy')) {
					$db->loadObject($row);
				} else {
					$row = $db->loadObject();
				}
			} else {
				$db->loadObject($row);
			}
			$lists['global.character_set_database'] = $row != null ? $row->Value : '';
			
			$row = null;
			$db->setQuery("SELECT @@session.character_set_database As Value;");
			if (JCOMMENTS_JVERSION == '1.5') {
				$config = &JFactory::getConfig();
				
				if ($config->getValue('config.legacy')) {
					$db->loadObject($row);
				} else {
					$row = $db->loadObject();
				}
			} else {
				$db->loadObject($row);
			}
			$lists['session.character_set_database'] = $row != null ? $row->Value : '';
		}
		
		$installer = new HTML_JCommentsInstaller();
		$installer->showSystemInfo($lists);
	}
	
	function executeSQL( $filename = '' )
	{
		if (is_file($filename)) {
			$buffer = file_get_contents($filename);
			
			if ($buffer === false) {
				return false;
			}
			
			$db = & JCommentsFactory::getDBO();
			
			$query_split = JCommentsInstaller::splitSql($buffer);
			foreach ($query_split as $command_line) {
				$command_line = trim($command_line);
				if ($command_line != '') {
					$db->setQuery($command_line);
					@$db->query();
				}
			}
		}
		return true;
	}
	
	/**
	 * Splits a string of queries into an array of individual queries
	 *
	 * @access public
	 * @param string The queries to split
	 * @return array queries
	 */
	function splitSql( $queries )
	{
		$start = 0;
		$open = false;
		$open_char = '';
		$end = strlen($queries);
		$query_split = array();
		for ($i = 0; $i < $end; $i++) {
			$current = substr($queries, $i, 1);
			if (($current == '"' || $current == '\'')) {
				$n = 2;
				while (substr($queries, $i - $n + 1, 1) == '\\' && $n < $i) {
					$n++;
				}
				if ($n % 2 == 0) {
					if ($open) {
						if ($current == $open_char) {
							$open = false;
							$open_char = '';
						}
					} else {
						$open = true;
						$open_char = $current;
					}
				}
			}
			if (($current == ';' && !$open) || $i == $end - 1) {
				$query_split[] = substr($queries, $start, ($i - $start + 1));
				$start = $i + 1;
			}
		}
		
		return $query_split;
	}
}

class HTML_JCommentsInstaller
{
	var $releaseDate = null;
	var $releaseVersion = '2.0';
	var $messages = array();
	var $warnings = array();
	var $errors = array();

	function HTML_JCommentsInstaller()
	{
		$versionInfo = JCommentsInstallerHelper::getVersionInfo('jcomments');
		$this->releaseDate = $versionInfo->releaseDate;
		$this->releaseVersion = $versionInfo->releaseVersion;
	}
	
	function addMessage( $message, $status = true )
	{
		$msg['text'] = $message;
		$msg['status'] = $status;
		$this->messages[] = $msg;
	}
	
	function addWarning( $message )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			$message = str_replace('/mambots/', '/plugins/', $message);
		}
		
		$msg['text'] = $message;
		$this->warnings[] = $msg;
	}

	function addError( $message ) {
		$msg['text'] = $message;
		$this->errors[] = $msg;
	}

	function showInstallLog()
	{
		global $mainframe;
?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	submitform( pressbutton );
}
</script>
<link rel="stylesheet"
	href="<?php echo $mainframe->getCfg( 'live_site' ); ?>/administrator/components/com_jcomments/images/style.css"
	type="text/css" />

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
			src="<?php echo $mainframe->getCfg( 'live_site' ); ?>/administrator/components/com_jcomments/images/jcomments48x48.png"
			border="0" alt="" /></td>
		<td><span class="componentname">JComments <?php echo $this->releaseVersion; ?></span>
		<span class="componentdate">[<?php echo $this->releaseDate; ?>]</span><br />
		<span class="copyright">&copy; 2006-<?php echo date('Y'); ?> smart (<a
			href="http://www.joomlatune.ru" target="_blank">JoomlaTune.ru</a> | <a
			href="http://www.joomlatune.com" target="_blank">JoomlaTune.com</a>). <?php echo JText::_('All rights reserved!');?><br />
		</span></td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

<?php
		if (count($this->errors)) {
?>
<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td><span class="installheader"><?php echo JText::_('Errors'); ?></span></td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>
		<ul style="padding: 0 0 0 20px; marign: 0;">
<?php
			foreach($this->errors as $error) {
?>
		<li style="padding: 0 0 5px;"><span style="color: red; font-size: 12px;"><?php echo $error['text']; ?></span></li>
<?php
			}
?>
		</ul>
		</td>
	</tr>
<?php
        	} else {
			if (count($this->messages)) {
?>

<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td><span class="installheader"><?php echo JText::_('AI_LOG'); ?></span>
		</td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>
		<ul style="padding: 0 0 0 20px; marign: 0;">
<?php
				foreach($this->messages as $message) {
					$status_class = $message['status'] ? 'ok' : 'err';
					$status_text  = $message['status'] ? JText::_('AI_OK') : JText::_('AI_ERROR');
?>
			<li><?php echo $message['text']; ?>: <span
				class="status<?php echo $status_class; ?>"><?php echo $status_text; ?></span></li>
<?php
				}
?>
			<li><span class="statusok"><b><?php echo JText::_('AI_INSTALLED'); ?></b></span></li>
		</ul>
		</td>
	</tr>
<?php
        		}
			if (count($this->warnings)) {
?>
<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td><span class="installheader"><?php echo JText::_('AI_WARNINGS'); ?></span></td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>
		<ul style="padding: 0 0 0 20px; marign: 0;">
<?php
				foreach($this->warnings as $warning) {
?>
		<li style="padding: 0 0 5px;"><?php echo $warning['text']; ?></li>
<?php
				}
?>
		</ul>
		</td>
	</tr>
<?php
        		}
?>
<tr valign="top" align="right">
		<td></td>
		<td align="center" style="text-align: right;">
		<div class="button-left">
		<div class="next"><a
			href="<?php echo $mainframe->getCfg( 'live_site' ); ?>/administrator/index2.php?option=com_jcomments&task=settings"><?php echo JText::_('AI_NEXT'); ?></a>
		</div>
		</div>
		</td>
</tr>
<?php
		}
?>

</table>

</div>
<div class="b">
<div class="b">
<div class="b"></div>
</div>
</div>
</div>

</div>

<form action="index2.php" method="post" name="adminForm"><input
	type="hidden" name="option" value="com_jcomments" /> <input
	type="hidden" name="task" value="" /></form>
<?php
	}


	function showSystemInfo( $lists )
	{
		global $mainframe;
?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	submitform( pressbutton );
}
</script>
<link rel="stylesheet"
	href="<?php echo $mainframe->getCfg( 'live_site' ); ?>/administrator/components/com_jcomments/images/style.css"
	type="text/css" />

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
			src="<?php echo $mainframe->getCfg( 'live_site' ); ?>/administrator/components/com_jcomments/images/jcomments48x48.png"
			border="0" alt="" /></td>
		<td><span class="componentname">JComments <?php echo $this->releaseVersion; ?></span>
		<span class="componentdate">[<?php echo $this->releaseDate; ?>]</span><br />
		<span class="copyright">&copy; 2006-<?php echo date('Y'); ?> smart (<a
			href="http://www.joomlatune.ru" target="_blank">JoomlaTune.ru</a> | <a
			href="http://www.joomlatune.com" target="_blank">JoomlaTune.com</a>). <?php echo JText::_('All rights reserved!');?><br />
		</span></td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td><span class="installheader">Database Info:</span></td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>
		<table width="95%" border="0" cellpadding="0" cellspacing="0">
<?php
			foreach($lists as $k=>$v) {
?>
			<tr>
				<td width="50%"><?php echo $k; ?></td>
				<td><?php echo $v; ?></td>
			</tr>
<?php
			}
?>
		</table>
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

<form action="index2.php" method="post" name="adminForm"><input
	type="hidden" name="option" value="com_jcomments" /> <input
	type="hidden" name="task" value="" /></form>
<?php
	}
}
?>