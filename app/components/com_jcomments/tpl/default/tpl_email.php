<?php
// ensure this file is being included by a parent file
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');
/*
*
* E-mail templates (administrator and subscribers notifications )
*
* Шаблоны писем-уведомлений (администратору и подписчикам) 
*
* В настоящее время шаблон используется при формировании писем-уведомлений.
* Если в переменной notification-type задано 'admin', результатом будет
* подготовленный текст письма администратору. Если указать 'subscription',
* то будет сформирован заголовок и тест письма для подписчиков
*
* Функцию render желательно не изменять, она на внешний вид никак не влияет 
* и выполняет больше системную функцию, нежели визуальную.
*
* Непосредственно шаблоны писем находятся в функциях:
*
* - getAdminNotificationMessage
* - getSubscriberNotificationMessage
*
*/
class jtt_tpl_email extends JoomlaTuneTemplate
{
	function render() 
	{
		$comment = $this->getVar('comment');
		
		if (isset($comment)) {
			$type = $this->getVar('notification-type');

			switch($type)
			{
				case 'admin':
					$subject = $this->getAdminNotificationSubject();
					$message = $this->getAdminNotificationMessage($comment);
					break;

				case 'subscription':
					$subject = $this->getSubscriberNotificationSubject();
					$message = $this->getSubscriberNotificationMessage($comment);
					break;
			}

			if ( isset( $subject ) && isset( $message ) ) {
				// Important! This variables used from JComments class
				// for sending notification emails
				$this->setVar( 'subject', $subject );
				$this->setVar( 'message', $message );
			}
		}
	}

	function getAdminNotificationSubject()
	{
		$object_title = $this->getVar('comment-object_title');

		if ($this->getVar('comment-isnew', 0) == 1) {
			return JText::_('NOTIFICATION_SUBJECT_NEW') . ': ' . $object_title;
		} else {
			return JText::_('NOTIFICATION_SUBJECT_UPDATED') . ': ' . $object_title;
		}
	}

	function getAdminNotificationMessage( &$comment )
	{
		$object_title = $this->getVar('comment-object_title');
		$object_link =  $this->getVar('comment-object_link');

		ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta content="text/html; charset=<?php echo $this->getVar('charset'); ?>" http-equiv="content-type" />
  <meta name="Generator" content="JComments" />
</head>
<html>
<body>
<?php echo JText::_('NOTIFICATION_COMMENT_TITLE'); ?>: <?php echo $object_title; ?><br />
<?php echo JText::_('NOTIFICATION_COMMENT_LINK'); ?>: <a href="<?php echo $object_link ?>#comment-<?php echo $comment->id; ?>" target="_blank"><?php echo $object_link ?></a><br />
<?php echo JText::_('NOTIFICATION_COMMENT_DATE'); ?>: <?php echo $comment->date; ?><br />
<?php echo JText::_('NOTIFICATION_COMMENT_NAME'); ?>: <?php echo $comment->name; ?><br />
<?php echo JText::_('NOTIFICATION_COMMENT_EMAIL'); ?>: <?php echo $comment->email; ?><br />
<?php echo JText::_('NOTIFICATION_COMMENT_TEXT'); ?>: <?php echo $comment->comment; ?><br />
</body>
</html>
<?php
		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	function getSubscriberNotificationSubject()
	{
		$object_title = $this->getVar('comment-object_title');

		if ($this->getVar('comment-isnew', 0) == 1) {
			return JText::_('NOTIFICATION_SUBJECT_NEW') . ': ' . $object_title;
		} else {
			return JText::_('NOTIFICATION_SUBJECT_UPDATED') . ': ' . $object_title;
		}
	}

	function getSubscriberNotificationMessage( &$comment )
	{
		$object_title = $this->getVar('comment-object_title');
		$object_link =  $this->getVar('comment-object_link');
		$hash =  $this->getVar('hash');

		$link = '<a href="' . $object_link . '" target="_blank">' . $object_title . '</a>';
		$unsubscribeMessage = JText::sprintf('NOTIFICATION_COMMENT_UNSUBSCRIBE', $link);
		$unsubscribeLink = JoomlaTuneRoute::_('index.php?option=com_jcomments&task=unsubscribe&hash=' . $hash);

		ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta content="text/html; charset=<?php echo $this->getVar('charset'); ?>" http-equiv="content-type" />
  <meta name="Generator" content="JComments" />
</head>
<html>
<body>
<p style="font: normal 1em Verdana, Arial, Sans-Serif;"><?php echo $comment->author; ?> <a href="<?php echo $object_link; ?>#comment-<?php echo $comment->id; ?>"><?php echo JText::_('WROTE'); ?></a></p>
<div style="margin: 0 20px 10px 20px; padding: 0 0 0 10px; font: normal 1em Verdana, Arial, Sans-Serif;"><?php echo $comment->comment; ?></div>
<p style="border-top: 1px solid #ccc; margin: 10px 0 0 0; color: #555;"><?php echo $unsubscribeMessage; ?>:<br /><a href="<?php echo $unsubscribeLink; ?>" target="_blank"><?php echo JText::_('Unsubscribe');?></a></p>
</body>
</html>
<?php
		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}
}
?>