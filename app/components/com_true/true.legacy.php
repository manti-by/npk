<?php
/**
 *Truegallery - Joomla gallery Component
 *
 * Legacy
 *
 * @version 1.1
 * @package Truegallery
 * @filename true.legacy.php
 * @author Dmitry (Mitrich) Smirnov (mitrich@joomlaportal.ru)
 * @copyright (C) 2006-2008 by Dmitry (Mitrich) Smirnov (http://mitrichlab.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project, 
 * please make a reference to Truegallery someplace in your code 
 * and provide a link to http://mitrichlab.ru
 **/

// ensure this file is being included by a parent file
(defined ( '_VALID_MOS' ) or defined ( '_JEXEC' )) or die ( 'Direct Access to this location is not allowed.' );

if (! defined ( 'DS' )) {
	define ( 'DS', DIRECTORY_SEPARATOR );
}

if (! defined ( 'JOOMLA_JVERSION' )) {
	if (defined ( '_JEXEC' ) && class_exists ( 'JApplication' )) {
		
		if (! defined ( '_ISO' )) {
			define ( '_ISO', 'charset=utf-8' );
		}
		
		$config = &JFactory::getConfig ();
		
		define ( 'JOOMLA_JVERSION', '1.5' );
		define ( 'TRUE_ADMIN', JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_true' . DS );
		define ( 'TRUE_BASE', JPATH_ROOT . DS . 'components' . DS . 'com_true' . DS );
		define ( 'TRUE_HELPERS', JPATH_ROOT . DS . 'components' . DS . 'com_true' . DS . 'helpers' . DS );
		define ( 'TRUE_LEGACY', JPATH_ROOT . DS . 'components' . DS . 'com_true' . DS . 'libraries' . DS . 'joomlatune' . DS . 'legacy' . DS );
		define ( 'TRUE_LIBRARIES', JPATH_ROOT . DS . 'components' . DS . 'com_true' . DS . 'libraries' . DS );
		define ( 'TRUE_INDEX2', $mainframe->getCfg ( 'live_site' ) . '/administrator/index2.php?option=com_true' );
		
		if (! $config->getValue ( 'config.legacy' )) {
			$config->setValue ( 'config.live_site', substr_replace ( JURI::root (), '', - 1, 1 ) );
			$config->setValue ( 'config.absolute_path', JPATH_SITE );
			$config->setValue ( 'config.cachepath', JPATH_BASE . DS . 'cache' );
			
			$lang = & JFactory::getLanguage ();
			$config->setValue ( 'config.lang', $lang->getBackwardLang () );
			
			if (! class_exists ( 'mosDBTable' )) {
				class mosDBTable extends JTable {
					function mosDBTable($table, $key, &$db) {
						parent::__construct ( $table, $key, $db );
					}
				}
			}
		} else {
			$config->setValue ( 'config.cachepath', JPATH_BASE . DS . 'cache' );
		}
		
		$language = & JFactory::getLanguage ();
		$language->load ( 'com_true', JPATH_ROOT );
	
	} else {
		
		global $mosConfig_absolute_path, $mosConfig_lang, $mainframe;
		define ( 'JOOMLA_JVERSION', '1.0' );
		define ( 'TRUE_ADMIN', $mainframe->getCfg ( 'absolute_path' ) . DS . 'administrator' . DS . 'components' . DS . 'com_true' . DS );
		define ( 'TRUE_BASE', $mainframe->getCfg ( 'absolute_path' ) . DS . 'components' . DS . 'com_true' . DS );
		define ( 'TRUE_HELPERS', $mainframe->getCfg ( 'absolute_path' ) . DS . 'components' . DS . 'com_true' . DS . 'helpers' . DS );
		define ( 'TRUE_LEGACY', $mainframe->getCfg ( 'absolute_path' ) . DS . 'components' . DS . 'com_true' . DS . 'libraries' . DS . 'joomlatune' . DS . 'legacy' . DS );
		define ( 'TRUE_LIBRARIES', $mainframe->getCfg ( 'absolute_path' ) . DS . 'components' . DS . 'com_true' . DS . 'libraries' . DS );
		define ( 'TRUE_INDEX2', $mainframe->getCfg ( 'live_site' ) . '/administrator/index2.php?option=com_true' );
		
		require_once (TRUE_LIBRARIES . 'joomlatune' . DS . 'localization' . DS . 'string.php');
		require_once (TRUE_LIBRARIES . 'joomlatune' . DS . 'localization' . DS . 'language.php');
		
		$lang = $mosConfig_lang;
		
		if (! is_file ( TRUE_BASE . 'languages' . DS . $lang . '.ini' )) {
			$lang = 'english';
		}
		
		$language = &JoomlaTuneLanguage::getInstance ();
		$language->setRoot ( TRUE_BASE . 'languages' );
		$language->load ( $lang );
		
		$joomfish = $mosConfig_absolute_path . DS . 'components' . DS . 'com_joomfish' . DS . 'joomfish.php';
		
		
			
			// small hack for JoomFish 1.8.2+ on Joomla 1.0.x
			if (is_file ( $joomfish )) {
				
				include_once ($mosConfig_absolute_path . DS . 'administrator' . DS . 'components' . DS . 'com_joomfish' . DS . 'joomfish.class.php');
				include_once ($mosConfig_absolute_path . DS . 'administrator' . DS . 'components' . DS . 'com_joomfish' . DS . 'libraries' . DS . 'joomla' . DS . 'language.php');
				
				if (class_exists ( 'JLanguageHelper' )) {
					if (isset ( $mainframe ) && $mainframe->isAdmin ()) {
						$jfm = new JoomFishManager ( $mosConfig_absolute_path . DS . 'administrator' . DS . 'components' . DS . 'com_joomfish' );
						$adminLang = strtolower ( $jfm->getCfg ( 'componentAdminLang' ) );
						$lng = & JLanguageHelper::getLanguage ( $adminLang );
					} else {
						$lng = & JLanguageHelper::getLanguage ();
					
					}
					
					if (is_array ( $lng->_strings ) && is_array ( $language->languages [$lang] )) {
						$lng->_strings = array_merge ( $lng->_strings, $language->languages [$lang] );
					}
				}
			} else {
			    if ( !class_exists ( 'JText' )) {
			        			class JText {
				function _($text, $jsSafe = false) {
					$lang = & JoomlaTuneLanguage::getInstance ();
					return $lang->_ ( $text, $jsSafe );
				}
				
				function sprintf($string) {
					$lang = & JoomlaTuneLanguage::getInstance ();
					$args = func_get_args ();
					if (count ( $args ) > 0) {
						$args [0] = $lang->_ ( $args [0] );
						return call_user_func_array ( 'sprintf', $args );
					}
					return '';
				}
			}
			    }
			    
				if (class_exists ( 'JLanguageHelper' )) {
					// small hack for JoomFish 1.8.2+ on Joomla 1.0.x
					$lng = & JLanguageHelper::getLanguage ();
					if (is_array ( $lng->_strings ) && is_array ( $language->languages [$lang] )) {
						$lng->_strings = array_merge ( $lng->_strings, $language->languages [$lang] );
					}
				}
			}
		}
	}


/*


if (!defined( 'DS' )) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

if (!defined('TRUE_BASE')) {
	DEFINE( 'TRUE_BASE', dirname(__FILE__));
}

if (!defined('TRUE_LIBRARIES')) {
	DEFINE( 'TRUE_LIBRARIES', dirname(__FILE__).DS.'libraries');
}

if (!defined('JOOMLA_JVERSION')) {
	if (defined( '_JEXEC') && class_exists('JApplication')) {
		define( 'JOOMLA_JVERSION', '1.5' ); 
		define( 'TRUE_ADMIN', JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jcomments' );

		if(!defined('_ISO')) {
			define('_ISO','charset=utf-8');
		}

		$config = &JFactory::getConfig();

		if(!$config->getValue('config.legacy')) {
			$config->setValue('config.live_site', substr_replace(JURI::root(), '', -1, 1));
			$config->setValue('config.absolute_path', JPATH_SITE);
			$config->setValue('config.cachepath', JPATH_BASE.DS.'cache');

			$lang =& JFactory::getLanguage();
			$config->setValue('config.lang', $lang->getBackwardLang());

			if(!class_exists('mosDBTable')) {
				class mosDBTable extends JTable
				{
					function mosDBTable($table, $key, &$db)
					{
						parent::__construct( $table, $key, $db );
					}
				}
			}
		} else {
			$config->setValue('config.cachepath', JPATH_BASE.DS.'cache');
		}

		$language =& JFactory::getLanguage();
		$language->load('com_jcomments', JPATH_SITE );
	} else {	
		global $mosConfig_absolute_path, $mosConfig_lang, $mainframe;
		define( 'JOOMLA_JVERSION', '1.0' ); 
		define( 'TRUE_ADMIN', $mosConfig_absolute_path.DS.'administrator'.DS.'components'.DS.'com_true'.DS );
        define('TRUE_HELPERS',      $mainframe->getCfg('absolute_path').DS.'components'.DS.'com_true'.DS.'helpers'.DS );
        define('TRUE_LEGACY',       $mainframe->getCfg('absolute_path').DS.'components'.DS.'com_true'.DS.'libraries'.DS.'joomlatune'.DS.'legacy'.DS );
		define('TRUE_INDEX2',       $mainframe->getCfg('live_site').'/administrator/index2.php?option=com_true' );
        
		require_once( TRUE_LIBRARIES.DS.'joomlatune'.DS.'localization'.DS.'string.php' );
		require_once( TRUE_LIBRARIES.DS.'joomlatune'.DS.'localization'.DS.'language.php' );

		$lang = $mosConfig_lang;

		if (!is_file( TRUE_BASE.DS.'languages'.DS.$lang.'.ini')) {
			$lang = 'english';
		}

		$language = &JoomlaTuneLanguage::getInstance();
		$language->setRoot( TRUE_BASE . DS . 'languages' );
		$language->load( $lang );

		$joomfish = $mosConfig_absolute_path . DS . 'components' . DS . 'com_joomfish' . DS . 'joomfish.php';

		if(!class_exists('JText')) {

			// small hack for JoomFish 1.8.2+ on Joomla 1.0.x
			if (is_file($joomfish)) {
				include_once( $mosConfig_absolute_path . DS . 'administrator' . DS . 'components' . DS . 'com_joomfish' . DS . 'joomfish.class.php');
				include_once( $mosConfig_absolute_path . DS . 'administrator' . DS . 'components' . DS . 'com_joomfish' . DS . 'libraries' .  DS . 'joomla' . DS . 'language.php' );
	
				if(class_exists('JLanguageHelper')) {
					if (isset($mainframe) && $mainframe->isAdmin()) {
						$jfm = new JoomFishManager( $mosConfig_absolute_path . DS . 'administrator' . DS . 'components' . DS . 'com_joomfish' );
						$adminLang = strtolower( $jfm->getCfg( 'componentAdminLang' ) );
						$lng =& JLanguageHelper::getLanguage($adminLang);
					} else {
						$lng =& JLanguageHelper::getLanguage();
					}
					
					if (is_array($lng->_strings) && is_array($language->languages[$lang])) {
						$lng->_strings = array_merge( $lng->_strings, $language->languages[$lang]);
					}
				}
			} else {
				class JText
				{
					function _( $text, $jsSafe = false )
					{
						$lang =& JoomlaTuneLanguage::getInstance();
						return $lang->_( $text, $jsSafe );
					}

					function sprintf($string)
					{
						$lang =& JoomlaTuneLanguage::getInstance();
						$args = func_get_args();
						if (count($args) > 0) {
							$args[0] = $lang->_($args[0]);
							return call_user_func_array('sprintf', $args);
						}
						return '';
					}
				}
			}
		} else {
			if(class_exists('JLanguageHelper')) {
				// small hack for JoomFish 1.8.2+ on Joomla 1.0.x
				$lng =& JLanguageHelper::getLanguage();
				if (is_array($lng->_strings) && is_array($language->languages[$lang])) {
					$lng->_strings = array_merge( $lng->_strings, $language->languages[$lang]);
				}
			}
		}
	}
}
*/
?>