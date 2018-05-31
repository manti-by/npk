<?php
/**
 * JoomlaTuneString
 *
 * @package JoomlaTune.Framework
 * @subpackage String
 * @author Dmitry M. Litvinov
 * @copyright 2008
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 * @version $Id$
 * @access public
 * @static
 */
if (!defined('JOOMLATUNE_STRING')) {

	define('JOOMLATUNE_STRING', 1);

	class JoomlaTuneString
	{
		/**
     * Returns an array of strings, each of which is a substring of string formed by splitting
     * it on boundaries formed by the string delimiter.
     *
     * @access public
     * @param string $delimiter
     * @param string $string
     * @param int $limit
     * @return array
     * @static
     */
		function split( $delimiter, $string, $limit )
		{
			return explode( $delimiter, $string, $limit );
		}

		/**
     * Returns length of the string on success, and 0 if the string is empty.
     *
     * @access public
     * @param string $string
     * @return int
     * @static
     */
		function length( $string )
		{
			return strlen( $string );
		}

		/**
     * Returns string with whitespace stripped from the beginning and end of str
     *
     * @access public
     * @param string $string
     * @return string
     * @static
     */
		function trim( $string )
		{
			return trim( $string );
		}

		function strtoupper( $string )
		{
			return strtoupper( $string );
		}
	}
}
?>