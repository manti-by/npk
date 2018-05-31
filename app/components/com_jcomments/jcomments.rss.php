<?php
/**
 * JComments - Joomla Comment System
 *
 * Export comments to rss
 *
 * @version 2.0
 * @package jComments
 * @filename jcomments.rss.php
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JComments someplace in your code
 * and provide a link to http://www.joomlatune.ru
 **/

// ensure this file is being included by a parent file
(defined('_VALID_MOS') or defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

class JCommentsRSS
{
	function feedLastComments()
	{
		global $mainframe;

		$config = & JCommentsFactory::getConfig();

		if ($config->get('enable_rss') == '1') {
			require_once ($mainframe->getCfg('absolute_path') . DS . 'includes' . DS . 'feedcreator.class.php');

			$object_id = (int) JCommentsInput::getParam($_REQUEST, 'object_id', 0);
			$object_group = trim(strip_tags(JCommentsInput::getParam($_REQUEST, 'object_group', 'com_content')));
			$limit = (int) JCommentsInput::getParam($_REQUEST, 'limit', 100);

			// if no group or id specified - return 404
			if ($object_id == 0 || $object_group == '') {
				header('HTTP/1.0 404 Not Found');

				if (JCOMMENTS_JVERSION == '1.5') {
					JError::raiseError(404, JText::_("Resource Not Found"));
				} else {
					$_404_template = $mainframe->getCfg('absolute_path') . DS . 'templates' . DS . '404.php';
					if (is_file($_404_template)) {
						require_once ($_404_template);
					}
				}
				exit(404);
			}

			$feed_type = JCommentsInput::getParam($_GET, 'feed', 'RSS2.0');
			$feed_file = strtolower(str_replace('.', '', $feed_type));
			$feed_file = $mainframe->getCfg('cachepath') . DS . 'jcomments_' . $object_group . '_' . $object_id . '_' . $feed_type . '.xml';

			$rss = new UniversalFeedCreator();

			if ($mainframe->getCfg('caching')) {
				$rss->useCached($feed_type, $feed_file, $mainframe->getCfg('cachetime'));
			}

			$object_title = JCommentsObjectHelper::getTitle($object_id, $object_group);
			$object_link = JCommentsObjectHelper::getLink($object_id, $object_group);

			if (JCOMMENTS_JVERSION == '1.5') {
				$uri = & JFactory::getURI();
				$url = $uri->toString(array('scheme' , 'user' , 'pass' , 'host' , 'port'));
				$object_link = $url . $object_link;
			}

			$iso = explode('=', _ISO);
			$charset = strtolower($iso[1]);

			$rss->encoding = $charset;
			$rss->title = $object_title;
			$rss->link = $object_link;
			$rss->syndicationURL = $object_link;
			$rss->description = JText::_('COMMENTS_FOR') . ' ' . $rss->title;
			$rss->cssStyleSheet = NULL;

			$object_link = str_replace('amp;', '', $object_link);

			$db = & JCommentsFactory::getDBO();

			$query = "SELECT id, userid, name, username, date, UNIX_TIMESTAMP(date) as date_ts, comment "
					. "\nFROM #__jcomments "
					. "\nWHERE object_id = '" . $object_id . "'"
					. "\nAND object_group ='" . $object_group . "'"
					. (JCommentsMultilingual::isEnabled() ? "\nAND lang = '" . JCommentsMultilingual::getLanguage() . "'" : "")
					. "\nAND published = '1'"
					. "\nORDER BY date DESC"
					;
			$db->setQuery($query, 0, $limit);
			$rows = $db->loadObjectList();

			foreach ($rows as $row) {
				$comment = JCommentsText::cleanText($row->comment);
				$author = JComments::getCommentAuthorName($row);

				if ($comment != '') {
					$item = new FeedItem();
					$item->title = $author . ' ' . JText::_('WROTE');
					$item->link = $object_link . '#comment-' . $row->id;
					$item->description = $comment;
					$item->source = $object_link;
					$item->date = date('r', strtotime($row->date));
					$item->author = $author;
					$rss->addItem($item);
				}
			}
			$rss->saveFeed($feed_type, $feed_file, true);
			unset($rows, $rss);
			exit();
		}
	}

	function feedLastCommentsGlobal()
	{
		global $mainframe;

		$config = & JCommentsFactory::getConfig();

		if ($config->get('enable_rss') == '1') {
			require_once ($mainframe->getCfg('absolute_path') . DS . 'includes' . DS . 'feedcreator.class.php');

			$object_group = trim(strip_tags(JCommentsInput::getParam($_REQUEST, 'object_group', '')));
			$limit = (int) JCommentsInput::getParam($_GET, 'limit', 100);

			$feed_type = JCommentsInput::getParam($_GET, 'feed', 'RSS2.0');
			$feed_file = strtolower(str_replace('.', '', $feed_type));
			$feed_file = $mainframe->getCfg('cachepath') . DS . 'jcomments_' . $feed_type . '.xml';

			$rss = new UniversalFeedCreator();

			if ($mainframe->getCfg('caching')) {
				$rss->useCached($feed_type, $feed_file, $mainframe->getCfg('cachetime'));
			}

			$iso = explode('=', _ISO);

			$rss->encoding = strtolower($iso[1]);
			$rss->title = JText::_('HEADER');
			$rss->link = $mainframe->getCfg('live_site');
			$rss->syndicationURL = $mainframe->getCfg('live_site');
			$rss->description = JText::_('COMMENTS_FOR') . ' ' . $mainframe->getCfg('sitename');
			$rss->cssStyleSheet = NULL;

			if ($object_group != '') {
				$groups = explode(',', $object_group);
			} else {
				$groups = array();
			}

			$db = & JCommentsFactory::getDBO();

			$query = "SELECT id, object_id, object_group, userid, name, username, date, UNIX_TIMESTAMP(date) as date_ts, comment"
					. "\nFROM #__jcomments "
					. "\nWHERE published = '1'"
					. ((count($groups) > 0) ? "\n   AND (object_group = '" . implode("' OR object_group='", $groups) . "')" : '')
					. (JCommentsMultilingual::isEnabled() ? "\nAND lang = '" . JCommentsMultilingual::getLanguage() . "'" : "")
					. "\nORDER BY date DESC"
					;
			$db->setQuery($query, 0, $limit);
			$rows = $db->loadObjectList();

			$url = '';

			if (JCOMMENTS_JVERSION == '1.5') {
				$uri = & JFactory::getURI();
				$url = $uri->toString(array('scheme' , 'user' , 'pass' , 'host' , 'port'));
			}

			foreach ($rows as $row) {
				$comment = JCommentsText::cleanText($row->comment);
				$author = JComments::getCommentAuthorName($row);

				if ($comment != '') {
					$object_title = JCommentsObjectHelper::getTitle($row->object_id, $row->object_group);
					$object_link = JCommentsObjectHelper::getLink($row->object_id, $row->object_group);
					$object_link = str_replace('amp;', '', $object_link);

					if (JCOMMENTS_JVERSION == '1.5') {
						$object_link = $url . $object_link;
					}

					$item = new FeedItem();
					$item->title = $object_title;
					$item->link = $object_link . '#comment-' . $row->id;
					$item->description = $author . ' ' . JText::_('WROTE') . ' &quot;' . $comment . '&quot;';
					$item->source = $object_link;
					$item->date = date('r', strtotime($row->date));
					$item->author = $author;
					$rss->addItem($item);
				}
			}
			$rss->saveFeed($feed_type, $feed_file, true);
			unset($rows, $rss);
			exit();
		}
	}
}
?>