<?php
/**
 * JComments - Joomla Comment System
 *
 * Core classes
 *
 * @version 2.0
 * @package JComments
 * @filename jcomments.class.php
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

ob_start();
// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

require_once (JCOMMENTS_BASE . DS . 'jcomments.legacy.php');
require_once (JCOMMENTS_HELPERS . DS . 'object.php');
ob_end_clean();

/**
 * Comments table
 *
 */
class JCommentsDB extends mosDBTable
{
	/** @var int Primary key */
	var $id = null;
	/** @var int */
	var $object_id = null;
	/** @var string */
	var $object_group = null;
	/** @var string */
	var $object_params = null;
	/** @var string */
	var $lang = null;
	/** @var int */
	var $userid = null;
	/** @var string */
	var $name = null;
	/** @var string */
	var $username = null;
	/** @var string */
	var $title = null;
	/** @var string */
	var $comment = null;
	/** @var string */
	var $email = null;
	/** @var string */
	var $homepage = null;
	/** @var datetime */
	var $date = null;
	/** @var string */
	var $ip = null;
	/** @var int */
	var $isgood = null;
	/** @var int */
	var $ispoor = null;
	/** @var boolean */
	var $published = null;
	/** @var boolean */
	var $subscribe = null;
	/** @var string */
	var $source = null;
	/** @var boolean */
	var $checked_out = 0;
	/** @var datetime */
	var $checked_out_time = 0;
	/** @var string */
	var $editor = '';

	/**
	* @param database A database connector object
	* @access public
	* @return void
	*/
	function JCommentsDB( &$db ) {
		$this->mosDBTable('#__jcomments', 'id', $db);
	}
}

class JCommentsBaseACL
{
	function check( $str )
	{
	        global $my;

		if (isset($str)) {

			if (!isset($my)) {
				$my = & JCommentsFactory::getUser();
			}

			$config = & JCommentsFactory::getConfig();
			$list = explode(',', $config->get($str));

			for ($i = 0, $n = count($list); $i < $n; $i++) {
				if (($my->id != 0) && ($my->usertype == $list[$i])) {
					return 1;
				} else if (($my->id == 0) && ($list[$i] == 'Unregistered')) {
					return 1;
				}
			}
		}
		return 0;
	}
}

class JCommentsACL extends JCommentsBaseACL
{
	var $canDelete		= 0;
	var $canDeleteOwn	= 0;
	var $canEdit		= 0;
	var $canEditOwn		= 0;
	var $canPublish		= 0;
	var $canViewIP		= 0;
	var $canViewEmail	= 0;
	var $canViewHomepage	= 0;
	var $canComment		= 0;
	var $canQuote		= 0;
	var $canReply		= 0;
	var $canVote		= 0;
	var $userID			= 0;
	var $userIP			= 0;

	function JCommentsACL() {
		global $my, $mainframe;

		if (!isset($my)) {
			$my = $mainframe->getUser();
		}
		
		$config = & JCommentsFactory::getConfig();

		$this->canDelete	= $this->check('can_delete');
		$this->canDeleteOwn	= $this->check('can_delete_own');
		$this->canEdit		= $this->check('can_edit');
		$this->canEditOwn	= $this->check('can_edit_own');
		$this->canPublish	= $this->check('can_publish');
		$this->canViewIP	= $this->check('can_view_ip');
		$this->canViewEmail	= $this->check('can_view_email');
		$this->canViewHomepage	= $this->check('can_view_homepage');
		$this->canComment	= $this->check('can_comment');
		$this->canVote		= $this->check('can_vote');
		$this->canQuote		= $this->canComment;
		$this->canReply		= intval($this->check('can_reply') && $config->get('template_view') == 'tree') ;

		$this->userID		= (int) $my->id;
		$this->userIP		= getenv('REMOTE_ADDR');
	}

	function getUserIP()
	{
		return $this->userIP;
	}

	function getUserId()
	{
		return $this->userID;
	}

	function isLocked($obj)
	{
		if (isset($obj) && ($obj!=null)) {
			return ($obj->checked_out && $obj->checked_out != $this->userID) ? 1 : 0;
		}
		return 0;
	}

	function canDelete($obj)
	{
		return (($this->canDelete || ($this->canDeleteOwn && ($obj->userid == $this->userID)))
			&& (!$this->isLocked($obj))) ? 1 : 0;
	}

	function canEdit($obj)
	{
		return (($this->canEdit || ($this->canEditOwn && ($obj->userid == $this->userID)))
			&& (!$this->isLocked($obj))) ? 1 : 0;
	}

	function canPublish($obj=null)
	{
		return ($this->canPublish && (!$this->isLocked($obj))) ? 1 : 0;
	}

	function canViewIP()
	{
		return $this->canViewIP;
	}

	function canViewEmail($obj=null)
	{
		if (is_null($obj)) {
			return ($this->canViewEmail) ? 1 : 0;
		} else {
			return ($this->canViewEmail&&($obj->email!='')) ? 1 : 0;
		}
	}

	function canViewHomepage($obj=null)
	{
		if (is_null($obj)) {
			return ($this->canViewHomepage) ? 1 : 0;
		} else {
			return ($this->canViewHomepage&&($obj->homepage!='')) ? 1 : 0;
		}
	}

	function canComment()
	{
		return $this->canComment;
	}

	function canQuote()
	{
		return $this->canQuote;
	}

	function canReply()
	{
		return $this->canReply;
	}

	function canVote($obj)
	{
		if ($this->userID) {
			return ($this->canVote && $obj->userid != $this->userID && !isset($obj->voted));
		} else {
			return ($this->canVote && $obj->ip != $this->userIP && !isset($obj->voted));
		}

	}

	function canModerate($obj) {
		return $this->canEdit($obj) || $this->canDelete($obj)
			|| $this->canPublish($obj) || $this->canViewIP($obj);
	}
}

function jc_compare($a, $b) {
	if (strlen($a) == strlen($b)) {
		return 0;
	}
	return (strlen($a) > strlen($b)) ? -1 : 1;
}

class JCommentsSmiles
{
	var $_smiles = array();

	function JCommentsSmiles()
	{
		global $mainframe;

		if (count($this->_smiles) == 0) {
			$config = & JCommentsFactory::getConfig();
	        	$list = (array) $config->get('smiles');
	        	uksort($list, 'jc_compare');
			foreach ($list as $sc=>$si)
			{
				$this->_smiles['code'][] = '#'.preg_quote( $sc, '#' ) . '#i' . JCOMMENTS_PCRE_UTF8;
				$this->_smiles['icon'][] = '<img src="' . $mainframe->getCfg( 'live_site' ) . '/components/com_jcomments/images/smiles/' . $si . '" border="0" alt="" />';
			}
		}
	}

	function get()
	{
		return $this->_smiles;
	}

	function replace($str)
	{
		if (count($this->_smiles) == 0) {
			return $str;
		}
		return preg_replace($this->_smiles['code'], $this->_smiles['icon'], $str);
	}

	function strip($str)
	{
		if (count($this->_smiles) == 0) {
			return $str;
		}
		return preg_replace($this->_smiles['code'], '', $str);
	}
}

/**
 * Base class
 * 
 */
class JCommentsPlugin
{
	/**
	 * Return the title of an object by given identifier.
	 *
	 * @abstract
	 * @access public 
	 * @param int $id A object identifier. 
	 * @return string Object title 
	 */
	function getObjectTitle( $id )
	{
		global $mainframe;
		return $mainframe->getCfg('sitename');
	}

	/**
	 * Return the URI to object by given identifier.
	 *
	 * @abstract 
	 * @access public 
	 * @param int $id A object identifier. 
	 * @return string URI of an object 
	 */
	function getObjectLink( $id )
	{
		global $mainframe;
		return $mainframe->getCfg('live_site');
	}

	/**
	 * Return identifier of the object owner.
	 *
	 * @abstract 
	 * @access public 
	 * @param int $id A object identifier. 
	 * @return int Identifier of the object owner, otherwise -1 
	 */
	function getObjectOwner( $id )
	{
		return -1;
	}

	function getCategories( $filter = '' )
	{
		return array();
	}

	function getItemid( $object_group )
	{
		static $cache;
		
		if (isset($cache)) {
			$cache = array();
		}
		
		$v = 'jc_' . $object_group . '_itemid';

		if (!isset($cache[$v])) {
			$dbo = & JCommentsFactory::getDBO();
			$dbo->setQuery("SELECT id FROM `#__menu` WHERE link LIKE '%" . $object_group . "%' AND published=1");
			$cache[$v] = (int) $dbo->loadResult();
		}
		return $cache[$v];
	}
}

class JCommentsPluginLoader
{
	/**
	 * Deprecated, use JCommentsObjectHelper::getTitle() instead.
	 * 
	 * @deprecated As of version 2.0.0
	 * @see  JCommentsObjectHelper::getTitle()
	 */
	function getObjectTitle( $object_id, $object_group = 'com_content' )
	{
		return JCommentsObjectHelper::getTitle($object_id, $object_group);
	}
	
	/**
	 * Deprecated, use JCommentsObjectHelper::getLink() instead.
	 * 
	 * @deprecated As of version 2.0.0
	 * @see  JCommentsObjectHelper::getLink()
	 */
	function getObjectLink( $object_id, $object_group = 'com_content')
	{
		return JCommentsObjectHelper::getLink($object_id, $object_group);
	}

	/**
	 * Deprecated, use JCommentsObjectHelper::getOwner() instead.
	 * 
	 * @deprecated As of version 2.0.0
	 * @see  JCommentsObjectHelper::getOwner()
	 * @return int
	 */
	function getObjectOwner( $object_id, $object_group = 'com_content' )
	{
		return JCommentsObjectHelper::getOwner($object_id, $object_group);
	}
}

class JCommentsText
{
	function replaceJavaScript( $text )
	{
		static $patterns, $replacements;

		ob_start();
		
		if (empty($patterns)) {
			$patterns[] = '/javascript/i';
			$replacements[] = 'j&#097;v&#097;script';
			$patterns[] = '/alert/i';
			$replacements[] = '&#097;lert';
			$patterns[] = '/about:/i';
			$replacements[] = '&#097;bout:';
			$patterns[] = '/onmouseover/i';
			$replacements[] = '&#111;nmouseover';
			$patterns[] = '/onmouseout/i';
			$replacements[] = '&#111;nmouseout';
			$patterns[] = '/onclick/i';
			$replacements[] = '&#111;nclick';
			$patterns[] = '/onload/i';
			$replacements[] = '&#111;nload';
			$patterns[] = '/onsubmit/i';
			$replacements[] = '&#111;nsubmit';
		}
		
		$text = preg_replace($patterns, $replacements, $text);
		
		ob_end_clean();

		return $text;
	}

	function replaceSpecial( $text )
	{
		static $patterns, $replacements;  
		ob_start();
		
		if (empty($patterns)) {
			$patterns = array();
			$replacements = array();
		
			$patterns[] = '#(<br\s?\/?\>){3,}#is';
			$replacements[] = '<br />';

			$patterns[] = '#(^|\D)1\/4#is';
			$replacements[] = '\\1&frac14;';
			$patterns[] = '#(^|\D)1\/2#is';
			$replacements[] = '\\1&frac12;';
			$patterns[] = '#(^|\D)3\/4#is';
			$replacements[] = '\\1&frac34;';
		
			$patterns[] = '#\(c\)#is';
			$replacements[] = '&copy;';
			$patterns[] = '#\(tm\)#is';
			$replacements[] = '&trade;';
			$patterns[] = '#\(r\)#is';
			$replacements[] = '&reg;';
			$patterns[] = '#\.{3,}#is';
			$replacements[] = '&hellip;';
			$patterns[] = '#(\d+)x(\d+)#is';
			$replacements[] = '$1&times;$2';
		
			$patterns[] = '#\+\/\-#is';
			$replacements[] = '&plusmn;';
			$patterns[] = '#\-{2}#is';
			$replacements[] = '&mdash;';
			$patterns[] = '#\\\\#is';
			$replacements[] = '&#92;';
		}
		
		$text = preg_replace($patterns, $replacements, $text);

		ob_end_clean();

		return $text;
	}

	function formatDate( $date = 'now', $format = null, $offset = null )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			if (empty($format)) {
				$format = JText::_('DATE_FORMAT_LC1');
			}
			return JHTML::_('date', $date, $format, $offset);
		}
		return mosFormatDate($date, $format, $offset);
	}

	function nl2br( $text )
	{
		$text = preg_replace(array('/\r/', '/^\n+/', '/\n+$/'), '', $text);
		$text = str_replace("\n", '<br />', $text);
		return $text;
	}

	function br2nl( $text )
	{
		return str_replace('<br />', "\n", $text);
	}

	function fixLongWords( $text, $maxlength )
	{
		$maxLength = (int) min(65535, $maxlength);

		if ($maxLength > 5) {
			ob_start();
			if (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
				$breaker = '<span style="margin: 0 -0.65ex 0 -1px;padding:0;"> </span>';
			} else {
				$breaker = '<span style="font-size:0px;padding:0;margin:0;"> </span>';
			}

			$plainText = $text;
			$plainText = preg_replace("#<img[^\>]+/>#isU", '', $plainText);
			$plainText = preg_replace("#<a.*?>(.*?)</a>#isU", '', $plainText);
			$plainText = preg_replace("#(^|\s|\>|\()((http://|https://|news://|ftp://|www.)\w+[^\s\[\]\<\>\"\'\)]+)#i", '', $plainText);

			$matches = array();
			$matchCount = preg_match_all("#([^\s<>'\"/\.\x133\x151\\-\?&%=\n\r\%]{".$maxLength."})#i" . JCOMMENTS_PCRE_UTF8, $plainText, $matches);
			for ($i = 0; $i < $matchCount; $i++) {
				$text = preg_replace("#(".preg_quote($matches[1][$i], '#').")#i" . JCOMMENTS_PCRE_UTF8, "\\1".$breaker, $text);
			}
			$text = preg_replace("#(".preg_quote($breaker, '#')."\s)#i" . JCOMMENTS_PCRE_UTF8, " ", $text);
			unset($matches);
			ob_end_clean();
		}
		return $text;
	}

	function countLinks( $text )
	{
		$matches = array();
		return preg_match_all(_JC_REGEXP_LINK, $text, $matches);
	}

	function clearLinks( $text )
	{
		return preg_replace(_JC_REGEXP_LINK, '', $text);
	}

	function url($s)
	{
		if (isset($s) && preg_match('/^((http|https|ftp):\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}((:[0-9]{1,5})?\/.*)?$/i' , $s)) {
			$url = preg_replace('|[^a-z0-9-~+_.?#=&;,/:]|i', '', $s);
			$url = str_replace(';//', '://', $url);
			if ($url != '') {
				$url = (!strstr($url, '://')) ? 'http://'.$url : $url;
				$url = preg_replace('/&([^#])(?![a-z]{2,8};)/', '&#038;$1', $url);
				return $url;
			}
		}
		return null;
	}

	function censor( $text )
	{
		ob_start();
		
		$config = & JCommentsFactory::getConfig();
		$badwords = $config->get('badwords');
		$replaceWord = $config->get('censor_replace_word', '***');
		
		if (!empty($badwords)) {
			for ($i = 0, $n = count($badwords); $i < $n; $i++) {
				$text = eregi_replace($badwords[$i], $replaceWord, $text);
			}
		}
		ob_end_clean();
		return $text;
	}

	/**
	* Cleans text of all formating and scripting code
	*/
	function cleanText( $text )
	{
		$bbcode = & JCommentsFactory::getBBCode();
		
		$text = $bbcode->filter($text, true);
		$text = str_replace('<br />', ' ', $text);
		$text = preg_replace('/(\s){2,}/i', '\\1', $text);
		$text = preg_replace("'<script[^>]*>.*?</script>'si", '', $text);
		$text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text);
		$text = preg_replace('/<!--.+?-->/', '', $text);
		$text = preg_replace('/{.+?}/', '', $text);
		$text = preg_replace('/&nbsp;/', ' ', $text);
		$text = preg_replace('/&amp;/', ' ', $text);
		$text = preg_replace('/&quot;/', ' ', $text);
		$text = strip_tags($text);
		$text = htmlspecialchars($text);
		$text = html_entity_decode($text);
		
		return $text;
	}

	function strlen( $str )
	{
		if (JCOMMENTS_ENCODING != 'utf-8') {
			return strlen($str);
		} else {
			return strlen(utf8_decode($str));
		}
	}

	function substr( $text, $length = 0 )
	{
		if (class_exists('JString')) {
			if ($length && JString::strlen($text) > $length) {
				$text = JString::substr($text, 0, $length) . '...';
			}
		} else {
			if ($length && strlen($text) > $length) {
				$text = substr($text, 0, $length) . '...';
			}
		}
		
		return $text;		
	}

	function isUTF8( $v )
	{
		for ($i = 0; $i < strlen($v); $i++) {
			if (ord($v[$i]) < 0x80) {
				$n = 0;
			} elseif ((ord($v[$i]) & 0xE0) == 0xC0) {
				$n = 1;
			} elseif ((ord($v[$i]) & 0xF0) == 0xE0) {
				$n = 2;
			} elseif ((ord($v[$i]) & 0xF0) == 0xF0) {
				$n = 3;
			} else {
				return false;
			}				
			
			for ($j = 0; $j < $n; $j++) {
				if ((++$i == strlen($v)) || ((ord($v[$i]) & 0xC0) != 0x80))
					return false;
			}
		}
		return true;
	}
}

class JCommentsBBCode
{
	var $_codes	= array();

	function JCommentsBBCode()
	{
		ob_start();
		$this->registerCode('b');
		$this->registerCode('i');
		$this->registerCode('u');
		$this->registerCode('s');
		$this->registerCode('url');
		$this->registerCode('img');
		$this->registerCode('list');
		$this->registerCode('hide');

		// simple hack: the quote tag is settuped via settings
		// so it already available if user has rights to post comment
		$acl = & JCommentsFactory::getACL();
		$this->_codes['quote'] = $acl->canQuote();
		ob_end_clean();
	}

	function registerCode($str)
	{
		$acl = & JCommentsFactory::getACL();
		$this->_codes[$str] = $acl->check('enable_bbcode_'.$str);
	}

	function getCodes()
	{
		return array_keys( $this->_codes );
	}

	function enabled()
	{
		static $enabled;

		if ($enabled == null) {
			foreach($this->_codes as $code=>$_enabled) {
				if ($_enabled == 1 && $code != 'quote') {
					$enabled = $_enabled;
					break;
				}
			}
		}
		return $enabled;
	}

	function canUse($str)
	{
		return $this->_codes[$str] ? 1 : 0;
	}

	function filter($str, $forceStrip = false)
	{
		global $my;

		ob_start();
		$patterns = array();
		$replacements = array();

		// disabled BBCodes
		$patterns[] = '/\[font=(.*?)\](.*?)\[\/font\]/i';
		$replacements[] = ' \\2';
		$patterns[] = '/\[size=(.*?)\](.*?)\[\/size\]/i';
		$replacements[] = ' \\2';
		$patterns[] = '/\[color=(.*?)\](.*?)\[\/color\]/i';
		$replacements[] = ' \\2';
		$patterns[] = '/\[email\](.*?)\[\/email\]/i';
		$replacements[] = ' \\1';
		$patterns[] = '/\[sup\](.*?)\[\/sup\]/i';
		$replacements[] = ' \\1';
		$patterns[] = '/\[sub\](.*?)\[\/sub\]/i';
		$replacements[] = ' \\1';
		$patterns[] = '/\[code\](.*?)\[\/code\]/i';
		$replacements[] = ' \\1';

		$patterns[] = "/\[img\](.*?)([\[\]]+)(.*?)\[\/img\]/iU";
		$replacements[] = '[img:error]';
//		$patterns[] = "/\[url\](.*?)([\[\]]+)(.*?)\[\/url\]/iU";
//		$replacements[] = '[url:error]';

		//empty tags
		foreach($this->_codes as $code=>$enabled) {
			$patterns[] = '/\['.$code.'\]\[\/'.$code.'\]/i';
			$replacements[] = '';
		}
		// B
		if (($this->canUse('b') == 0) || ($forceStrip)) {
			$patterns[] = '/\[b\](.*?)\[\/b\]/i';
			$replacements[] = '\\1';
		}

		// I
		if (($this->canUse('i') == 0) || ($forceStrip)) {
			$patterns[] = '/\[i\](.*?)\[\/i\]/i';
			$replacements[] = '\\1';
		}

		// U
		if (($this->canUse('u') == 0) || ($forceStrip)) {
			$patterns[] = '/\[u\](.*?)\[\/u\]/i';
			$replacements[] = '\\1';
		}

		// S
		if (($this->canUse('s') == 0) || ($forceStrip)) {
			$patterns[] = '/\[s\](.*?)\[\/s\]/i';
			$replacements[] = '\\1';
		}

		// URL
		if (($this->canUse('url') == 0) || ($forceStrip)) {
			$patterns[] = '/\[url\](.*?)\[\/url\]/i';
			$replacements[] = '\\1';
			$patterns[] = "/\[url=([^\s<\"\'\]]*?)\]([^\[]*?)\[\/url\]/iU";
			$replacements[] = '\\2: \\1';
		}

		// IMG
		if (($this->canUse('img') == 0) || ($forceStrip)) {
			$patterns[] = '/\[img\](.*?)\[\/img\]/i';
			$replacements[] = '\\1';
		}

		// HIDE
		if (($this->canUse('hide') == 0) || ($forceStrip)) {
			$patterns[] = '/\[hide\](.*?)\[\/hide\]/i';
			if ($my->id) {
				$replacements[] = '\\1';
			} else {
				$replacements[] = '';
			}
		}

		$str = preg_replace($patterns, $replacements, $str);

		// LIST
		if (($this->canUse('list') == 0) || ($forceStrip)) {
			$matches = array();
			$matchCount = preg_match_all("/\[list\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/list\]/is", $str, $matches);
			for ($i = 0; $i < $matchCount; $i++) {
				$textBefore = preg_quote($matches[2][$i]);
				$textAfter = preg_replace("#(<br\s?\/?\>)*\[\*\](<br\s?\/?\>)*#is", "<br />", $matches[2][$i]);
				$textAfter = preg_replace("#^<br />#is", "", $textAfter);
				$textAfter = preg_replace("#(<br\s?\/?\>)+#is", "<br />", $textAfter);
				$str = preg_replace("#\[list\](<br\s?\/?\>)*$textBefore(<br\s?\/?\>)*\[/list\]#si", "\n$textAfter\n", $str);
			}
			$matches = array();
			$matchCount = preg_match_all("/\[list=(a|A|i|I|1)\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/list\]/is", $str, $matches);
			for ($i = 0; $i < $matchCount; $i++) {
				$textBefore = preg_quote($matches[3][$i]);
				$textAfter = preg_replace("#(<br\s?\/?\>)*\[\*\](<br\s?\/?\>)*#is", "<br />", $matches[3][$i]);
				$textAfter = preg_replace("#^<br />#", "", $textAfter);
				$textAfter = preg_replace("#(<br\s?\/?\>)+#", "<br />", $textAfter);
				$str = preg_replace("#\[list=(a|A|i|I|1)\](<br\s?\/?\>)*$textBefore(<br\s?\/?\>)*\[/list\]#si", "\n$textAfter\n", $str);
			}
		}

		if ($forceStrip) {
			// QUOTE
			$quotePattern = "/\[quote\s?name=\"([^\"\'\<\>\(\)]+)+\"\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/quote\]/iU";
			$quoteReplace = ' ';
			while(preg_match($quotePattern, $str)) {
				$str = preg_replace($quotePattern, $quoteReplace, $str);
			}
			$quotePattern = "/\[quote[^\]]*?\](<br\s?\/?\>)*([^\[]+)(<br\s?\/?\>)*\[\/quote\]/iU";
			$quoteReplace = ' ';
			while(preg_match($quotePattern, $str)) {
				$str = preg_replace($quotePattern, $quoteReplace, $str);
			}

			$str = preg_replace('#\[\/?(b|i|u|s|sup|sub|url|img|list|quote|code|hide)\]#', '', $str);
		}

		$str = trim(preg_replace('/(\s){2,}/i', '\\1', $str));

		ob_end_clean();
		return $str;
	}


	function replace($str) {
		global $my;

		ob_start();
		
		$acl = & JCommentsFactory::getACL();

		$patterns = array();
		$replacements = array();

		// B
		$patterns[] = '/\[b\](.*?)\[\/b\]/i';
		$replacements[] = '<b>\\1</b>';

		// I
		$patterns[] = '/\[i\](.*?)\[\/i\]/i';
		$replacements[] = '<i>\\1</i>';

		// U
		$patterns[] = '/\[u\](.*?)\[\/u\]/i';
		$replacements[] = '<u>\\1</u>';

		// S
		$patterns[] = '/\[s\](.*?)\[\/s\]/i';
		$replacements[] = '<strike>\\1</strike>';

		// SUP
		$patterns[] = '/\[sup\](.*?)\[\/sup\]/i';
		$replacements[] = '<sup>\\1</sup>';

		// SUB
		$patterns[] = '/\[sub\](.*?)\[\/sub\]/i';
		$replacements[] = '<sub>\\1</sub>';

		// URL
		if ($acl->check('autolinkurls')) {
			$patterns[] = "/\[url\](http:\/\/)?([^\s<\"\']*?)\[\/url\]/i";
			$replacements[] = 'http://\\2';
			$patterns[] = "/\[url\](ftp:\/\/)?([^\s<\"\']*?)\[\/url\]/i";
			$replacements[] = 'ftp://\\2';
			$patterns[] = "/\[url=([^\s<\"\'\]]*?)\]([^\[]*?)\[\/url\]/iU";
			$replacements[] = '\\2: \\1';
		} else {
			$patterns[] = "/\[url\](http:\/\/)?([^\s<\"\']*?)\[\/url\]/i";
			$replacements[] = '<a href="http://\\2" rel="nofollow" target="_blank">\\2</a>';
			$patterns[] = "/\[url=([^\s\(\<\"\'\]]*?)\]([^\[]*?)\[\/url\]/iU";
			$replacements[] = '<a href="\\1" rel="nofollow" target="_blank">\\2</a>';
		}
		$patterns[] = "/\[url\](.*?)([^\s<>()\"\']*?)(.*?)\[\/url\]/i";
		$replacements[] = '[url:error]';

		// EMAIL
		$patterns[] = "/\[email\]([^\s\<\>\(\)\"\'\[\]]*?)\[\/email\]/i";
		$replacements[] = '\\1';

		// IMG
		$patterns[] = "/\[img\](http:\/\/)?([^\s\<\>\(\)\"\']*?)\[\/img\]/i";
		$replacements[] = '<img src="http://\\2" alt="" border="0" />';
		$patterns[] = "/\[img\](.*?)([^\s<>()\"\']*?)(.*?)\[\/img\]/i";
		$replacements[] = '[img:error]';

		// HIDE
		$patterns[] = '/\[hide\](.*?)\[\/hide\]/i';
		if ($my->id) {
			$replacements[] = '\\1';
		} else {
			$replacements[] = '<span class="hidden">'.JText::_('HIDDEN_TEXT').'</span>';
		}

		// CODE
		$patterns[] = "/\[code\](<br\s?\/?\>)*([^\[]+)(<br\s?\/?\>)*\[\/code\]/i";
		$replacements[] = '<span class="quote">'.JText::_('CODE').'</span><code>\\2</code>';

		$str = preg_replace($patterns, $replacements, $str);

		// QUOTE
		$quotePattern = "/\[quote\s?name=\"([^\"\'\<\>\(\)]+)+\"\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/quote\]/i";
		$quoteReplace = '<span class="quote">'.JText::_('QUOTE_PREFIX').' \\1'.JText::_('QUOTE_SUFFIX').'</span><blockquote>\\3</blockquote>';
		while(preg_match($quotePattern, $str)) {
			$str = preg_replace($quotePattern, $quoteReplace, $str);
		}
		$quotePattern = "/\[quote[^\]]*?\](<br\s?\/?\>)*([^\[]+)(<br\s?\/?\>)*\[\/quote\]/i";
		$quoteReplace = '<span class="quote">'.JText::_('QUOTE_SINGLE').'</span><blockquote>\\2</blockquote>';
		while(preg_match($quotePattern, $str)) {
			$str = preg_replace($quotePattern, $quoteReplace, $str);
		}

		// LIST
		$matches = array();
		$matchCount = preg_match_all("/\[list\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/list\]/is", $str, $matches);
		for ($i = 0; $i < $matchCount; $i++) {
			$textBefore = preg_quote($matches[2][$i]);
			$textAfter = preg_replace("#(<br\s?\/?\>)*\[\*\](<br\s?\/?\>)*#is", "</li>\n<li>", $matches[2][$i]);
			$textAfter = preg_replace("#^</?li>#", "", $textAfter);
			$textAfter = str_replace("\n</li>", "</li>", $textAfter."</li>");
			$str = preg_replace("#\[list\](<br\s?\/?\>)*$textBefore(<br\s?\/?\>)*\[/list\]#si", "\n<ul>$textAfter\n</ul>\n", $str);
		}
		$matches = array();
		$matchCount = preg_match_all("/\[list=(a|A|i|I|1)\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/list\]/is", $str, $matches);
		for ($i = 0; $i < $matchCount; $i++) {
			$textBefore = preg_quote($matches[3][$i]);
			$textAfter = preg_replace("#(<br\s?\/?\>)*\[\*\](<br\s?\/?\>)*#is", "</li>\n<li>", $matches[3][$i]);
			$textAfter = preg_replace("#^</?li>#", "", $textAfter);
			$textAfter = str_replace("\n</li>", "</li>", $textAfter."</li>");
			$str = preg_replace("#\[list=(a|A|i|I|1)\](<br\s?\/?\>)*$textBefore(<br\s?\/?\>)*\[/list\]#si", "\n<ol type=\\1>\n$textAfter\n</ol>\n", $str);
		}

		$str = preg_replace('#\[\/?(b|i|u|s|sup|sub|url|img|list|quote|code|hide)\]#', '', $str);
		unset($matches);
		ob_end_clean();
		return $str;
	}

	function removeQuotes( $text )
	{
		$text = preg_replace(array('#\n?\[quote.*?\].+?\[/quote\]\n?#is', '#\[/quote\]#'), '', $text);
		$text = preg_replace('#<br />+#is', '', $text);
		return $text;
	}

	function removeHidden( $text )
	{
		$text = preg_replace('#\[hide\](.*?)\[\/hide\]#is', '', $text);
		$text = preg_replace('#<br />+#is', '', $text);
		return $text;
	}
}

class JCommentsSecurity
{
	function notAuth()
	{
		header('HTTP/1.0 403 Forbidden');
		echo _NOT_AUTH;
		exit;
	}

	function badRequest()
	{
		if ((empty($_SERVER['HTTP_USER_AGENT']))
		|| (!$_SERVER['REQUEST_METHOD']=='POST')) {
			return 1;
		}
		return 0;
	}

	function checkFlood( $ip )
	{
		global $mainframe;

		$config = JCommentsFactory::getConfig();
		
		$floodInterval = $config->getInt('flood_time');

		if ($floodInterval > 0) {
			$dbo = & JCommentsFactory::getDBO();

			$comment_date = date( 'Y-m-d H:i:s', time() + $mainframe->getCfg( 'offset' ) * 60 * 60 );

			$query = "SELECT COUNT(*) "
				. "\nFROM #__jcomments "
				. "\nWHERE ip = '$ip' "
				. "\nAND '".$comment_date."' < DATE_ADD(date, INTERVAL " . $floodInterval . " SECOND)"
				. (($mainframe->getCfg('multilingual_support') == 1) ? "\nAND lang = '" . $mainframe->getCfg('lang') . "'" : "")
				;

			$dbo->setQuery($query);

			return ($dbo->loadResult() == 0) ? 0 : 1;
		}
		return 0;
	}

	function checkIsForbiddenUsername($str)
	{
		$config = & JCommentsFactory::getConfig();
		$names = $config->get('forbidden_names');

		if (!empty($names) && !empty($str) ) {
			$str = trim(strtolower($str));
			$forbidden_names = split(',', strtolower($names));
			foreach ($forbidden_names as $name) {
				if (trim($name) == $str) {
					return 1;
				}
			}
			unset($forbidden_names);
		}
		return 0;
	}

	function checkIsRegisteredUsername($str)
	{
		$config = & JCommentsFactory::getConfig();
		
		if ($config->getInt('enable_username_check') == 1) {
			$dbo = & JCommentsFactory::getDBO();

			$query = "SELECT COUNT(*) "
				."\nFROM #__users "
				."\nWHERE name = '$str' "
				."\nOR username = '$str'";
			$dbo->setQuery($query);
			return ($dbo->loadResult() == 0) ? 0 : 1;
		}
		return 0;
	}
}

/**
 * JComments Factory class
 */
class JCommentsFactory
{
	/**
	 * Returns a reference to the global {@link JCommentsSmiles} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @access public 
	 * @return object JCommentsSmiles
	 */
	function &getSmiles()
	{
		static $instance;
		
		if (!is_object($instance)) {
			$instance = new JCommentsSmiles();
		}
		return $instance;
	}

	/**
	 * Returns a reference to the global {@link JUser} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @access public 
	 * @return object JUser
	 */
	function &getUser( $id = null )
	{
		if (JCOMMENTS_JVERSION == '1.0') {
			if (!is_null($id)) {
				global $database;
				$user = new mosUser($database);
				$user->load($id);
			} else {
				global $mainframe;
				$user = $mainframe->getUser();
			}
		} else 
			if (JCOMMENTS_JVERSION == '1.5') {
				$user = & JFactory::getUser($id);
			}
		return $user;
	}

	/**
	 * Returns a reference to the global {@link JCommentsBBCode} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @access public 
	 * @return object JCommentsBBCode
	 */
	function &getBBCode()
	{
		static $instance;
		
		if (!is_object($instance)) {
			$instance = new JCommentsBBCode();
		}
		return $instance;
	}

	/**
	 * Returns a reference to the global {@link JCommentsCfg} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @access public 
	 * @return object JCommentsCfg
	 */
	function &getConfig($language='')
	{
		return JCommentsCfg::getInstance($language);
	}
	
	/**
	 * Returns a reference to the global {@link JoomlaTuneTemplateRender} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @access public 
	 * @return object JoomlaTuneTemplateRender
	 */
	function &getTemplate( $object_id = 0, $object_group = 'com_content', $needThisUrl = true )
	{
		global $Itemid, $mainframe;

		ob_start();
		
		$config = & JCommentsFactory::getConfig();

		$templateName = $config->get('template'); 
		
		if (empty($templateName)) {
			$templateName = 'default';
			$config->set('template', $templateName);
		}

		include_once (JCOMMENTS_LIBRARIES . DS . 'joomlatune' . DS . 'template.php');

		$loadFromDefaultLocation = true;

		if (JCOMMENTS_JVERSION == '1.5') {
			$templateDirectory =  $mainframe->getCfg('absolute_path') . DS . 'templates' . DS . $mainframe->getTemplate() . DS . 'jcomments' . DS . $templateName;
			$templateUrl =  JURI::root() . 'templates/' . $mainframe->getTemplate() . '/jcomments/' . $templateName;

			$loadFromDefaultLocation = !is_dir($templateDirectory);
		}

		if ($loadFromDefaultLocation) {
			$templateDirectory = JCOMMENTS_BASE . DS . 'tpl' . DS . $templateName;
			$templateUrl = $mainframe->getCfg('live_site') . '/components/com_jcomments/tpl/' . $templateName;
		}

		/**
		 * $tmpl JoomlaTuneTemplateRender
		 */
		$tmpl =& JoomlaTuneTemplateRender::getInstance();
		$tmpl->setRoot($templateDirectory);
		$tmpl->setBaseURI($templateUrl);
		$tmpl->addGlobalVar('siteurl', $mainframe->getCfg('live_site'));
		$tmpl->addGlobalVar('charset', strtolower(preg_replace('/charset=/', '', _ISO)));
		$tmpl->addGlobalVar('ajaxurl', JCommentsFactory::getLink('ajax', $object_id, $object_group));
		$tmpl->addGlobalVar('smilesurl', JCommentsFactory::getLink('smiles', $object_id, $object_group));
		$tmpl->addGlobalVar('rssurl', JCommentsFactory::getLink('rss', $object_id, $object_group));
		$tmpl->addGlobalVar('template', $templateName);
		$tmpl->addGlobalVar('itemid', $Itemid ? $Itemid : 1);

		$lang = $mainframe->getCfg('lang');

		if ($lang == 'russian' || $lang == 'ukrainian' || $lang == 'belarussian' || $lang == 'belorussian' ) {
			$tmpl->addGlobalVar('support', base64_decode('PGEgaHJlZj0iaHR0cDovL3d3dy5qb29tbGF0dW5lLnJ1IiB0aXRsZT0iSkNvbW1lbnRzIiB0YXJnZXQ9Il9ibGFuayI+SkNvbW1lbnRzPC9hPg=='));
		} else {
			$tmpl->addGlobalVar('support', base64_decode('PGEgaHJlZj0iaHR0cDovL3d3dy5qb29tbGF0dW5lLmNvbSIgdGl0bGU9IkpDb21tZW50cyIgdGFyZ2V0PSJfYmxhbmsiPkpDb21tZW50czwvYT4='));
		}

		$tmpl->addGlobalVar('comment-object_id', $object_id);
		$tmpl->addGlobalVar('comment-object_group', $object_group);

		if ($needThisUrl == true) {
			$tmpl->addGlobalVar('thisurl', JCommentsObjectHelper::getLink($object_id, $object_group));
		}

		ob_end_clean();

		return $tmpl;
	}

	/**
	 * Returns a reference to the global {@link JCommentsACL} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @access public 
	 * @return object JCommentsACL
	 */
	function &getACL()
	{
		static $instance;

		if (!is_object( $instance )) {
			$instance = new JCommentsACL();
		}
		return $instance;
	}

	function &getDBO()
	{
		static $instance;
		
		if (!is_object($instance)) {
			if (JCOMMENTS_JVERSION == '1.0') {
				global $database;
				$instance = $database;
			} elseif (JCOMMENTS_JVERSION == '1.5') {
				$instance = & JFactory::getDBO();
			}
		}
		return $instance;
	}

	/**
	 * Returns a reference to the global {@link JoomlaTuneAjaxResponse} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @access public 
	 * @return object JoomlaTuneAjaxResponse
	 */
	function &getAjaxResponse()
	{
		static $instance;
		
		if (!is_object($instance)) {
			$instance = new JoomlaTuneAjaxResponse(JCOMMENTS_ENCODING);
		}
		return $instance;
	}

	function getLink($type = 'ajax', $object_id = 0, $object_group='') {
		global $mainframe, $iso_client_lang;

		switch($type)
		{
			case 'rss':
				if (JCOMMENTS_JVERSION == '1.5') {
					return JURI::base() . 'index.php?option=com_jcomments&amp;task=rss&amp;object_id='.$object_id.'&amp;object_group='.$object_group.'&amp;tmpl=component';
				}
				return $mainframe->getCfg('live_site') . '/index2.php?option=com_jcomments&amp;task=rss&amp;object_id='.$object_id.'&amp;object_group='.$object_group.'&amp;no_html=1';
				break;

			case 'smiles':
				return $mainframe->getCfg('live_site') . '/components/com_jcomments/images/smiles';
				break;

			case 'captcha':
				$random = mt_rand(10000, 99999);

				if (JCOMMENTS_JVERSION == '1.5') {
					return JURI::base() . 'index.php?option=com_jcomments&amp;task=captcha&amp;tmpl=component&amp;ac=' . $random;
				}
				return $mainframe->getCfg('live_site') . '/index2.php?option=com_jcomments&amp;task=captcha&amp;no_html=1&amp;ac=' . $random;
				break;

			case 'ajax':
				$lang = '';

				// support additional param for multilingual sites
				if ($mainframe->getCfg('multilingual_support') == 1) {
					$lang .= '&lang=' . $iso_client_lang;
				}

				if (JCOMMENTS_JVERSION == '1.5') {
					return JURI::base() . 'index.php?option=com_jcomments&tmpl=component' . $lang;
				}

				if ($mainframe->isAdmin()) {
					// if JComments called from administrator's panel
					return $mainframe->getCfg('live_site') . '/administrator/index3.php?option=com_jcomments&no_html=1' . $lang;
				}

	                        $_Itemid = 1;

				if (!empty($_REQUEST['Itemid'])){
					$_Itemid = $_REQUEST['Itemid'];
				}

				$_Itemid = '&Itemid=' . $_Itemid;

				return $mainframe->getCfg('live_site') . '/index2.php?option=com_jcomments&no_html=1' . $lang . $_Itemid;
				break;

			case 'gzip':
				if (JCOMMENTS_JVERSION == '1.5') {
					return JURI::base() . 'index.php?option=com_jcomments&amp;tmpl=component&amp;task=gzip';
				}

				return $mainframe->getCfg('live_site') . '/index2.php?option=com_jcomments&amp;no_html=1&amp;task=gzip';
				break;

			default:
				return '';
				break;
		}
	}
}

class JCommentsCache
{
	/**
	* @return object A function cache object
	*/
	function getCache($group='')
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			return JFactory::getCache($group);
		}
		return mosCache::getCache($group);
	}

	/**
	* Cleans the cache
	*/
	function cleanCache( $group=false )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			$cache = & JFactory::getCache($group);
			$cache->clean($group);
		} else {
			mosCache::cleanCache($group);
		}
	}
}

class JCommentsInput
{
	function getParam( &$arr, $name, $def=null, $mask=0 )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			// Static input filters for specific settings
			static $noHtmlFilter = null;
			static $safeHtmlFilter = null;

			$var = JArrayHelper::getValue($arr, $name, $def, '');

			// If the no trim flag is not set, trim the variable
			if (!($mask & 1) && is_string($var)) {
				$var = trim($var);
			}

			// Now we handle input filtering
			if ($mask & 2) {
				// If the allow html flag is set, apply a safe html filter to the variable
				if (is_null($safeHtmlFilter)) {
					$safeHtmlFilter = & JFilterInput::getInstance(null, null, 1, 1);
				}
				$var = $safeHtmlFilter->clean($var, 'none');
			} elseif ($mask & 4) {
				// If the allow raw flag is set, do not modify the variable
				$var = $var;
			} else {
				// Since no allow flags were set, we will apply the most strict filter to the variable
				if (is_null($noHtmlFilter)) {
					$noHtmlFilter = & JFilterInput::getInstance(/* $tags, $attr, $tag_method, $attr_method, $xss_auto */);
				}
				$var = $noHtmlFilter->clean($var, 'none');
			}
			return $var;
		}
		return mosGetParam($arr, $name, $def, $mask);
	}
}

class JCommentsMail
{
	function send($from, $fromname, $recipient, $subject, $body, $mode=0, $cc=NULL, $bcc=NULL, $attachment=NULL, $replyto=NULL, $replytoname=NULL )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			return JUTility::sendMail($from, $fromname, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyto, $replytoname );
		}
		return mosMail($from, $fromname, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyto, $replytoname );
	}
}

function JCommentsRedirect( $url, $msg='' )
{
	if (JCOMMENTS_JVERSION == '1.5') {
		global $mainframe;
		$mainframe->redirect($url, $msg);
	}
	mosRedirect($url, $msg);
}

class JCommentsMultilingual
{
        function isEnabled()
        {
        	static $enabled;
        	
        	if (!isset($enabled)) {
        		global $mainframe;
        		$enabled = $mainframe->getCfg('multilingual_support') == 1; 
        	}
        	return $enabled;
        }

	function getLanguage()
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			$language = & JFactory::getLanguage();
			return $language->getTag();
		} else {
			global $mainframe;
			return $mainframe->getCfg('lang');
		}
	}

	function getDefaultLanguage()
	{
		static $defaultLanguage;
		
		if (!isset($defaultLanguage)) {
			global $mainframe;
			$defaultLanguage = ($mainframe->getCfg('defaultlang') ? $mainframe->getCfg('defaultlang') : '');
		}			
		return $defaultLanguage;
	}
}
?>