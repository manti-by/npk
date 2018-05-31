<?php
/***************************************************\
**   True gallery - A Joomla! Gallery Component    **
**   Copyright (C) 2008  by JoomlaForum **
**   Version    : 2.0                              **
**   Homepage   : http://true.palpalych.ru              **
**   License    : Copyright, don't distribute      **
**   Based on   : AkoGallery -> PonyGallery -> DatsoGallery Datso gallery 1.6**
\***************************************************/


defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
require_once ($mainframe->getCfg( 'absolute_path' ) . "/administrator/components/com_true/config.true.php");
global $database, $tgurl, $gid, $mainframe;
GalleryHeader();
//данные для постраничной навигации
require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/pageNavigation.php' );
$limit = intval( mosGetParam( $_REQUEST, 'limit', $ad_toplist ) );
$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
$page_nav_links ='';
//END данные для постраничной навигации
switch (@$sorting)
	{
		case 'find':
				$searchstring = trim(strtolower($sstring));
				$database->setQuery("SELECT *
				FROM #__true as a
				JOIN #__true_catg AS ca ON a.catid=ca.cid
				WHERE (( a.imgtitle like '%$searchstring%' ) or ( a.imgtext like '%$searchstring%' ))
				AND a.published=1 AND a.approved=1 AND ca.published=1 AND ca.access<=$gid
				ORDER BY id DESC ");
				$tl_title = JText::_('TG_SEARCH_RESULTS') . " $sstring ";
				$pw_title = JText::_('TG_SEARCH_RESULTS') . " $sstring ";
			break;
		case 'lastcomment':
				$database->setQuery("SELECT  a.*, a.catid AS cid, tc.count AS imgcounter
				FROM #__true AS a
				INNER JOIN #__true_catg AS ca ON a.catid = ca.cid
				JOIN #__jcomments AS cc ON a.id = cc.object_id
				LEFT JOIN #__true_count AS tc ON a.id = tc.imgid
				WHERE a.published=1 AND a.approved=1
				AND cc.object_group='com_true' AND cc.published=1 AND ca.published=1 AND ca.access<=$gid
				AND cc.id=(SELECT MAX(jc.id) FROM #__jcomments AS jc WHERE a.id = jc.object_id)
				ORDER BY cc.id DESC  LIMIT $ad_toplist ");
				$tl_title = " $ad_toplist " . JText::_('TG_LAST_COMMENT_PIC');
				$pw_title = JText::_('TG_LAST_COMMENTED');
			break;
		case 'lastadd':
				//считаем общее количество и сразу же имя автора
				$database->setQuery("select count(*) AS count from #__true as d");
				$database->LoadObject($row);
				$total = $row->count;
				$pageNav = new mosPageNav( $total, $limitstart, $limit );
				$database->setQuery("SELECT a.*, ca.*, tc.count AS imgcounter
				FROM #__true AS a
				JOIN #__true_catg AS ca ON a.catid=ca.cid
				LEFT JOIN #__true_count AS tc ON a.id = tc.imgid
				WHERE a.published=1 and a.approved=1 AND ca.published=1 AND ca.access<=$gid
				ORDER BY a.id desc LIMIT $limitstart, $limit");
				$tl_title = " $ad_toplist " . JText::_('TG_NEW_PIC');
				$pw_title = JText::_('TG_LAST_ADDED');
				$link = "index.php?option=com_true&func=special&sorting=lastadd&Itemid=$Itemid";
				/*if ($page_nav_links) {
					$page_nav_links =  $pageNav->writePagesLinks( $link );
				} else {
					$page_nav_links ='';}*/
				$page_nav_links =  $pageNav->writePagesLinks( $link );
			break;
		case 'rating':
				$database->setQuery("select count(*) AS count from #__true as d");
				$database->LoadObject($row);
				$total = $row->count;
				$pageNav = new mosPageNav( $total, $limitstart, $limit );
				$database->setQuery("SELECT a.*, ca.*,imgvotesum/imgvotes AS rating, tc.count as imgcounter
				FROM #__true AS a
				JOIN #__true_catg AS ca ON a.catid = ca.cid
				LEFT JOIN #__true_count AS tc ON a.id = tc.imgid
				WHERE a.imgvotes>0 AND a.published=1 AND a.approved=1 AND ca.published=1 AND ca.access<=$gid
				ORDER BY rating DESC LIMIT $limitstart, $limit");
				$tl_title = " $ad_toplist " . JText::_('TG_BEST_RATED_PIC');
				$pw_title = JText::_('TG_TOP_RATED');
				$link = "index.php?option=com_true&func=special&sorting=rating&Itemid=$Itemid";
				/*if ($page_nav_links) {
					$page_nav_links =  $pageNav->writePagesLinks( $link );
				} else {
					$page_nav_links ='';}*/
				$page_nav_links =  $pageNav->writePagesLinks( $link );
		break;
		case 'owner':
				//считаем общее количество и сразу же имя автора
				$database->setQuery("SELECT u.username AS owner, count(*) AS count
				FROM #__true AS a
				JOIN #__users AS u ON a.owner = u.id
				WHERE u.id = $op GROUP BY u.username ");
				$database->LoadObject($row);
				$total = $row->count;
				$imgowner = $row->owner;
				$pageNav = new mosPageNav( $total, $limitstart, $limit );
				$database->setQuery("SELECT a.*, a.catid as cid, tc.count as imgcounter
				FROM #__true AS a
				JOIN #__users AS u ON u.id = a.owner
				LEFT JOIN #__true_count AS tc ON a.id = tc.imgid
				WHERE a.published=1 AND a.approved=1 AND u.id = $op
				ORDER BY a.id DESC LIMIT $limitstart, $limit");
				$tl_title = " $total " .JText::_('TG_NEW_PIC')." ".JText::_('TG_FROM_USER')." $imgowner";
			 	$pw_title = " $total " .JText::_('TG_NEW_PIC')." ".JText::_('TG_FROM_USER')." $imgowner";
				$link = "index.php?option=com_true&func=special&sorting=owner&op=$op&Itemid=$Itemid";
				/*if ($page_nav_links) {
					$page_nav_links =  $pageNav->writePagesLinks( $link );
				} else {
					$page_nav_links ='';}*/
				$page_nav_links =  $pageNav->writePagesLinks( $link );
		break;
		case 'owners':
				//формируем список авторов с количеством фотографий и делаем их ссылками на списки
				$database->setQuery("SELECT a.*, u.id AS uid, u.username AS owner, count(*) AS count
				from #__true AS a
				JOIN #__users AS u ON u.id = a.owner
				where a.published = 1 and a.approved = 1
				group by a.owner order by a.owner ");
				$list = $database->loadObjectList();
				$tl_title = JText::_('TG_LAST_AUTHORS');
				$pw_title = JText::_('TG_LAST_AUTHORS');
		break;
		default:
				//считаем общее количество и сразу же имя автора
				$database->setQuery("SELECT count(id) AS count FROM #__true AS d");
				$database->LoadObject($row);
				$total = $row->count;
				$pageNav = new mosPageNav( $total, $limitstart, $limit );
				///
				$database->setQuery("SELECT a.*, ca.*, tc.count AS imgcounter, u.username as owner
				FROM #__true AS a
				JOIN #__true_catg AS ca ON a.catid = ca.cid
				JOIN #__true_count AS tc ON a.id = tc.imgid
				JOIN #__users AS u ON a.owner = u.id
				WHERE a.published=1 AND a.approved=1 AND ca.published=1 AND tc.count > '0' AND ca.access<=$gid
				ORDER BY tc.count DESC LIMIT $limitstart, $limit");
				$tl_title = " $ad_toplist " . JText::_('TG_MOST_VIEWED_PIC');
				$pw_title = JText::_('TG_MOST_VIEWED');
				$link = "index.php?option=com_true&func=special&Itemid=$Itemid";
				/*if ($page_nav_links) {
					$page_nav_links =  $pageNav->writePagesLinks( $link );
				} else {
					$page_nav_links ='';}*/
				$page_nav_links =  $pageNav->writePagesLinks( $link );
			break;
	}
$rows = $database->loadObjectList();
$mainframe->setPageTitle($pw_title);
$mainframe->AppendPathway($pw_title);
echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="dg_special">
	<tr class="sectiontableheader"><td colspan="5">'.$tl_title.'</td>';
$rowcounter = 0;
if (@$sorting == 'owners') {
	echo '</tr><tr><td colspan="4" width="50%">';
	$letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
	foreach ($letter as $l) {
		echo '<h3>'.$l.'</h3>';
		foreach($list as $user) {
	      		$linkowner = sefRelToAbs($tgurl.'&func=special&sorting=owner&op='.$user->uid);
		      	$firstletter = strtoupper(substr($user->owner, 0, 1));
		      	if ($l == $firstletter) {
			      	echo "<ul class=\"dg_owner\">";
			      	echo '<li><a href="'.$linkowner.'">'.$user->owner.'</a> ('.$user->count.')</li>';
			      	echo "</ul>";
		      	}
		}
	}
	echo '</td>';
  	echo '<td valign="top">';
  	$letter2 = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Э','Ю','Я' );
	foreach ($letter2 as $l2) {
	  	echo '<h3>'.$l2.'</h3>';
	  	foreach($list as $user) {
	      		$linkowner = sefRelToAbs($tgurl.'&func=special&sorting=owner&op='.$user->uid);
		      	$firstletter = strtoupper(substr($user->owner, 0, 1));
		      	if ($l2 == $firstletter) {
			      	echo "<ul class=\"dg_owner\">";
			      	echo '<li><a href="'.$linkowner.'">'.$user->owner.'</a> ('.$user->count.')</li>';
			      	echo "</ul>";
		      	}
		}
	 }
  	echo '</td>';
} else {
if(count($rows)) {
	for ($rowcounter = 0; $rowcounter < count($rows); $rowcounter++) {
		$row1 = $rows[$rowcounter];
		echo '</tr><tr>
		<td width="25%" align="center">';
			$link = sefRelToAbs($tgurl.'&func=detail&catid='.$row1->catid.'&id='.$row1->id);//ссылка на средний эскиз
			$linkimg = $thumbnailpath.$row1->cid.'/'.$row1->imgthumbname; //путь к мини эскизу
		//оформляем вывод
		echo '<a href="'.$link.'"><img src="'.$linkimg.'" class="dt2" alt="" /></a>';
		echo '</td><td width="25%" valign="top"><a href="'.$link.'"><strong>'.$row1->imgtitle.'</strong></a>';
		if($ad_showdetail)
			echo "<br />" . JText::_('TG_HITS') . " : $row1->imgcounter ";
		if($ad_showrating) {
			if($row1->imgvotes > 0) {
				$fimgvotesum = number_format($row1->imgvotesum / $row1->imgvotes, 2, ",", ".");
				$frating = "$fimgvotesum / $row1->imgvotes";
			} else {
				$frating = "" . JText::_('TGVOTE_NO_VOTES') . "";
			}
			echo "<br />" . JText::_('TG_RATING') . ": $frating";
		}
		if($ad_showcomment) {
			$comments2 = $mainframe->getCfg( 'absolute_path' ) . '/components/com_jcomments/jcomments.php';
			if(file_exists($comments2)) {
				require_once ($comments2);
				$comments = JComments::getCommentsCount($row1->id, 'com_true');
			} else { $comments = ''; }
			echo "<br />" . JText::_('TG_COMMENTS') . ": $comments";
		} else {}
		echo "</td>";
		$rowcounter++;
		if($rowcounter < count($rows)) {
			$row2 = $rows[$rowcounter];
			echo '<td width="25%" align="center">';
			$link = sefRelToAbs($tgurl.'&func=detail&catid='.$row2->catid.'&id='.$row2->id);//ссылка на средний эскиз
			$linkimg = $thumbnailpath.$row2->cid.'/'.$row2->imgthumbname; //путь к мини эскизу
			echo '<a href="'.$link.'"><img src="'.$linkimg.'" class="dt2" alt="" /></a>';
			echo '</td><td width="25%" valign="top"><a href="'.$link.'"><strong>'.$row2->imgtitle.'</strong></a>';
			if($ad_showdetail)
				echo "<br />" . JText::_('TG_HITS') . ": $row2->imgcounter ";
			if($ad_showrating) {
				if($row2->imgvotes > 0) {
					$fimgvotesum = number_format($row2->imgvotesum / $row2->imgvotes, 2, ",", ".");
					$frating = "$fimgvotesum / $row2->imgvotes";
				} else {
					$frating = "" . JText::_('TGVOTE_NO_VOTES') . "";
				}
				echo "<br />" . JText::_('TG_RATING') . ": $frating";
			}
			if($ad_showcomment) {
						$comments2 = $mainframe->getCfg( 'absolute_path' ) . '/components/com_jcomments/jcomments.php';
						if(file_exists($comments2)) {
							require_once ($comments2);
							$comments = JComments::getCommentsCount($row2->id, 'com_true');
						}

				echo "<br />" . JText::_('TG_COMMENTS') . ": $comments";
			} else { }
			echo "</td>";
		}
	}

	if ($page_nav_links) {
		echo '</tr><tr><td colspan="4" width="100%" align="center" style="padding-top: 20px;">'.$page_nav_links.'</td>';
	}
}
else {
	echo '</tr><tr><td colspan="4">'.JText::_('TG_NOSPECIAL').'</td>';
	}
}
echo "</tr></table>";
?>
