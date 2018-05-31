<?php
/**
 * JTHelpers - JoomlaTune Helpers
 *
 * Database legacy helper
 *
 * @version 1.0
 * @package JTHelpers
 * @filename route.php
 * @author Sergey M. Litvinov (smart@joomlatune.ru) & Dmitriy V. Smirnov (mitrich@joomlaportal.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JoomlaTune someplace in your code
 * and provide a link to http://www.joomlatune.ru
 **/

// ensure this file is being included by a parent file
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');
class JTDB {

    var $version = '1.0';

    function &getDBO() {
        static $instance;

        if (!is_object( $instance ))
        {
            if (JOOMLA_JVERSION == '1.0') {
                global $database;
                $instance = $database;
            } else if (JOOMLA_JVERSION == '1.5') {
                $instance =& JFactory::getDBO();
            }
        }
        return $instance;
    }
}
?>