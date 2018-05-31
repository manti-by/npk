<?php
/***************************************************\
**   True gallery - A Joomla! Gallery Component    **
**   Copyright (C) 2008  by JoomlaForum **
**   Version    : 2.0                              **
**   Homepage   : http://true.palpalych.ru              **
**   License    : Copyright, don't distribute      **
**   Based on   : AkoGallery -> PonyGallery -> DatsoGallery Datso gallery 1.6**
\***************************************************/
define('_VALID_MOS', 1);
require_once ('../../configuration.php');
require_once ($mosConfig_absolute_path . '/includes/joomla.php');
require_once ($mosConfig_absolute_path . '/includes/database.php');
if($mosConfig_db != "") {
	$database = new database($mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix);
}
$mainframe = new mosMainFrame($database, null, null);
$mainframe->initSession();
$my = $mainframe->getUser();
recordVote();

function recordVote() {
	global $database, $my;
	$id = intval(@$_GET['id']);
	$user_rating = intval(@$_GET['user_rating']);
	if(($user_rating >= 1) && ($user_rating <= 5)) {
		//параметры для идентификации записи
		$uip = $_SERVER['REMOTE_ADDR'];
		$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$browser = $_SERVER['HTTP_USER_AGENT'];
		//текущая дата для записи в бд
		$current_date = time();
		//если гость - то гость, если юзер - то его ID
		if($my->username) {
			$vip = "$uip$host$browser";
			$user = "$my->id";
		} else {
			$vip = "$uip$host$browser";
			$user = 'guest';
		}
		//пишем все в БД
		$query = "SELECT * FROM #__true_votes WHERE vpic = " . (int)$id;
		$database->setQuery($query);
		$votesdb = null;
		if(!($database->loadObject($votesdb))) {
			$query = "INSERT INTO #__true_votes ( vpic, vip, vote, user, date ) VALUES ( $id, '$vip', '$user_rating', '$user', '$current_date' )";
			$database->setQuery($query);
			$database->query() or die($database->stderr());
			$query = "UPDATE #__true SET imgvotes = imgvotes + 1, imgvotesum = imgvotesum + " . (int)$user_rating . " WHERE id = " . (int)$id;
			$database->setQuery($query);
			$database->query() or die($database->stderr());
		} else {
			if(!($votesdb->vpic == '$id' && $votesdb->vip == '$vip')) {
				$query = "INSERT INTO #__true_votes ( vpic, vip, vote, user, date ) VALUES ( $id, '$vip', '$user_rating', '$user', '$current_date' )";
				$database->setQuery($query);
				$database->query() or die($database->stderr());
				$query = "UPDATE #__true SET imgvotes = imgvotes + 1, imgvotesum = imgvotesum + " . (int)$user_rating . " WHERE id = " . (int)$id;
				$database->setQuery($query);
				$database->query() or die($database->stderr());
			} else {
				echo 0;
				exit();
			}
		}
		echo 1;
	}
}
?>
