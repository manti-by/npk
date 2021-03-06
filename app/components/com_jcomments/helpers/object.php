<?php
/**
 * JComments - Joomla Comment System
 * 
 * @version 2.0
 * @package JComments
 * @subpackage Helpers
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project, 
 * please make a reference to JComments someplace in your code 
 * and provide a link to http://www.joomlatune.ru
 **/

/**
 * JComments plugin Helper
 * 
 * @static
 * @package JComments
 * @subpackage Helpers
 */
class JCommentsObjectHelper
{
	/**
	 * Calls plugin for given object group and returns title for an object
	 *
	 * @static 
	 * @access private
	 * @param int $object_id
	 * @param string $object_group
	 * @param string $object_method
	 * @param mixed $default
	 * @return string
	 */
	function _getObjectVar( $object_id, $object_group, $object_method, $default = '' )
	{
		static $cache;
		
		if ($object_id != 0) {
			if (is_array($cache)) {
				$cache = array();
			}
			
			$cache_key = md5($object_group . '_' . $object_id . '_' . $object_method);
			
			if (isset($cache[$cache_key])) {
				return $cache[$cache_key];
			}
			
			ob_start();
			include_once (JCOMMENTS_BASE . DS . 'plugins' . DS . $object_group . '.plugin.php');
			ob_end_clean();
			
			$class = 'jc_' . $object_group;
			if (class_exists($class) && is_callable(array($class, $object_method))) {
				$object = call_user_func(array($class, $object_method), $object_id, 0);
				$cache[$cache_key] = $object;
				return $object;
			}
		}
		return $default;
	}
	
	/**
	 * Returns title for given object
	 *
	 * @static 
	 * @access public
	 * @param int $object_id
	 * @param string $object_group
	 * @return string
	 */
	function getTitle( $object_id, $object_group = 'com_content' )
	{
		return JCommentsObjectHelper::_getObjectVar($object_id, $object_group, 'getObjectTitle');
	}
	
	/**
	 * Returns URI for given object
	 *
	 * @static 
	 * @access public
	 * @param int $object_id
	 * @param string $object_group
	 * @return string
	 */
	function getLink( $object_id, $object_group = 'com_content' )
	{
		return JCommentsObjectHelper::_getObjectVar($object_id, $object_group, 'getObjectLink');
	}
	
	/**
	 * Returns identifier of user who is owner of an object
	 *
	 * @static 
	 * @access public
	 * @param int $object_id
	 * @param string $object_group
	 * @return string
	 */
	function getOwner( $object_id, $object_group = 'com_content' )
	{
		return JCommentsObjectHelper::_getObjectVar($object_id, $object_group, 'getObjectOwner', -1);
	}
}
?>