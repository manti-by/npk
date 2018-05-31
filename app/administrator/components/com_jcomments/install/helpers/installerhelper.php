<?php
/**
 * JComments - Joomla Comment System
 *
 * Service functions for JComments Installer
 *
 * @static
 * @version 2.0
 * @package JComments
 * @subpackage Installer
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project, 
 * please make a reference to JComments someplace in your code 
 * and provide a link to http://www.joomlatune.ru
 **/

class JCommentsInstallerHelper
{
	/**
	 * Returns component's version info from .xml file
	 *
	 * @return object Object with two fields: releaseVersion and releaseDate 
	 */
	function getVersionInfo()
	{
		static $versionInfo;
		global $mainframe;
		
		if (!isset($versionInfo)) {
			
			$versionInfo = new StdClass();
			$versionInfo->releaseVersion = 'x.x.x.x';
			$versionInfo->releaseDate = date('Y');
			
			if (JCOMMENTS_JVERSION == '1.0') {
				require_once ($mainframe->getCfg('absolute_path') . DS . 'includes' . DS . 'domit' . DS . 'xml_domit_lite_include.php');
			} else if (JCOMMENTS_JVERSION == '1.5') {
				jimport('domit.xml_domit_lite_include');
			}
			
			$xmlDoc = new DOMIT_Lite_Document();
			$xmlDoc->resolveErrors(false);
			
			$file = JCOMMENTS_ADMIN . DS . 'jcomments.xml';
			
			if (!is_file($file)) {
				$file = JCOMMENTS_ADMIN . DS . 'jcomments10.xml';
				
				if (!is_file($file)) {
					$file = JCOMMENTS_ADMIN . DS . 'jcomments15.xml';
					
					if (!is_file($file)) {
						$file = JCOMMENTS_ADMIN . DS . 'manifest.xml';
					}
				}
			}
			
			if (is_file($file)) {
				if ($xmlDoc->loadXML($file, false, true)) {
					$root = &$xmlDoc->documentElement;
					if (($root->getTagName() == 'mosinstall' || $root->getTagName() == 'install') && ($root->getAttribute("type") == "component")) {
						$element = &$root->getElementsByPath('creationDate', 1);
						$versionInfo->releaseDate = $element ? $element->getText() : date('Y');
						$element = &$root->getElementsByPath('version', 1);
						$versionInfo->releaseVersion = $element ? $element->getText() : '';
					}
				}
			}
		}
		
		return $versionInfo;
	}
	
	/**
	 * Chmods files and directories recursivly to given permissions
	 *
	 * @param	string	$path		Root path to begin changing mode [without trailing slash]
	 * @param	string	$filemode	Octal representation of the value to change file mode to [null = no change]
	 * @param	string	$foldermode	Octal representation of the value to change folder mode to [null = no change]
	 * @return	boolean	True if successful [one fail means the whole operation failed]
	 */
	function setPermissions( $path, $filemode = '0644', $foldermode = '0755' )
	{
		// Initialize return value
		$ret = true;
		
		if (is_dir($path)) {
			$dh = opendir($path);
			while (($file = readdir($dh)) !== false) {
				if ($file != '.' && $file != '..') {
					$fullpath = $path . '/' . $file;
					if (is_dir($fullpath)) {
						if (!JCommentsInstallerHelper::setPermissions($fullpath, $filemode, $foldermode)) {
							$ret = false;
						}
					} else {
						if (isset($filemode)) {
							if (!@ chmod($fullpath, octdec($filemode))) {
								$ret = false;
							}
						}
					}
				}
			}
			closedir($dh);
			if (isset($foldermode)) {
				if (!@ chmod($path, octdec($foldermode))) {
					$ret = false;
				}
			}
		} else {
			if (isset($filemode)) {
				$ret = @ chmod($path, octdec($filemode));
			}
		}
		return $ret;
	}

	function deleteFile( $file )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			jimport('joomla.filesystem.file');
			return JFile::delete($file);
		} else {
			@unlink($file);
		}
		return true;
	}

	function copyFile( $src, $dst )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			jimport('joomla.filesystem.file');
			return JFile::copy($src, $dst);
		} else {
			return @copy($src, $dst);
		}
	}
}
?>