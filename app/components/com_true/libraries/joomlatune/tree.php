<?php
/**
 * Simple tree class
 *
 * @version 1.0
 * @package JoomlaTune.Framework
 * @filename tree.php
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 * @access public
 **/

// Check for double include
if (!defined('JOOMLATUNE_TREE')) {

	define('JOOMLATUNE_TREE', 1);

	class JoomlaTuneTree
	{
		var $children = array();

		/**
		 * A hack to support __construct() on PHP 4
		 *
		 * @access	public
		 * @return	object
		 */
		function JoomlaTuneTree()
		{
			$args = func_get_args();
			call_user_func_array(array(&$this, '__construct'), $args);
		}

		/**
		 * Class constructor
		 *
		 * @param	array	$items	array of all objects (objects must contain id and parent fields)
		 * @access	protected
		 * @return	object
		 */
		function __construct( $items )
		{
			$this->children = array();

			foreach ($items as $v)
			{
				$pt = $v->parent;
				$list = @$this->children[$pt] ? $this->children[$pt] : array();
				array_push( $list, $v );
				$this->children[$pt] = $list;
			}
		}

		/**
		 * Recursive building tree
		 *
		 * @access	protected
		 * @return	array
		 */
		function _buildTree( $id, $list = array(), $maxlevel=9999, $level=0, $number = '' )
		{
			if (@$this->children[$id] && $level <= $maxlevel) {
				if ($number != '') {
					$number .= '.';
				}

				$i = 1;

				foreach ($this->children[$id] as $v) {
					$id = $v->id;
					$list[$id] = $v;
					$list[$id]->level = $level;
					$list[$id]->number = $number . $i;
					$list[$id]->children = count( @$this->children[$id] );
					$list = $this->_buildTree( $id, $list, $maxlevel, $level+1, $list[$id]->number );
					$i++;
				}
			}
			return $list;
		}

		/**
		 * Recursive building descendants list
		 *
		 * @access	protected
		 * @return	array
		 */
		function _getDescendants($id, $list = array(), $maxlevel=9999, $level=0 )
		{
			if (@$this->children[$id] && $level <= $maxlevel) {
				foreach ($this->children[$id] as $v) {
					$id = $v->id;
					$list[] = $v->id;
					$list = $this->_getDescendants( $id, $list, $maxlevel, $level+1 );
				}
			}
			return $list;
		}


		/**
		 * Return objects tree
		 *
		 * @access	public
		 * @param	int	$node	node id (by default node id is 0 - root node)
		 * @return	array
		 */
		function get( $node = 0 )
		{
			return $this->_buildTree( $node );
		}

		/**
		 * Return children items for given node or empty array for empty children list
		 *
		 * @access	public
		 * @param	int	$node	node id (by default node id is 0 - root node)
		 * @return	array
		 */
		function children( $node = 0 )
		{
			return @$this->children[$node] ? $this->children[$node] : array();
		}

		/**
		 * Return array with descendants id for given node
		 *
		 * @access	public
		 * @param	int	$node	node id (by default node id is 0 - root node)
		 * @return	array
		 */
		function descendants( $node = 0 )
		{
			return $this->_getDescendants( $node );
		}
	}
} // end of double include check
?>