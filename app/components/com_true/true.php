<?php
/***************************************************\
**   True gallery - A Joomla! Gallery Component    **
**   Copyright (C) 2008  by JoomlaForum **
**   Version    : 2.0                              **
**   Homepage   : http://true.palpalych.ru              **
**   License    : Copyright, don't distribute      **
**   Based on   : AkoGallery -> PonyGallery -> DatsoGallery Datso gallery 1.6**
\***************************************************/
//
defined('_VALID_MOS') or defined('_JEXEC') or die('Direct Access to this location is not allowed.');
//подключаем необходимые файлы legacy и административные
global $mainframe;
require_once ($mainframe->getCfg( 'absolute_path' ) . "/components/com_true/true.legacy.php");
require_once ($mainframe->getCfg( 'absolute_path' ) . "/components/com_true/libraries/joomlatune/legacy/input.php");
require_once ($mainframe->getCfg( 'absolute_path' ) . "/administrator/components/com_true/globals.true.php");
require ($mainframe->getCfg( 'absolute_path' ) . "/administrator/components/com_true/config.true.php");
require_once ($mainframe->getCfg( 'absolute_path' ) . "/administrator/components/com_true/class.true.php");
///
$uid 			= intval(mosGetParam($_REQUEST, 'uid', 0));
$op 			= intval(mosGetParam($_REQUEST, 'op', 0));
$id 			= intval(mosGetParam($_REQUEST, 'id', 0));
$catid 			= intval(mosGetParam($_REQUEST, 'catid', 0));
$cmtid 			= intval(mosGetParam($_REQUEST, 'cmtid', 0));
$imgvote 		= intval(mosGetParam($_REQUEST, 'imgvote', 0));
$startpage 		= intval(mosGetParam($_REQUEST, 'startpage', 0));
$cmtpic 		= intval(mosGetParam($_POST, 'cmtpic', 0));
$cmtpic 		= intval(mosGetParam($_REQUEST, 'cmtpic', ''));
$Itemid 		= intval(mosGetParam($_REQUEST, 'Itemid', ''));
$sstring 		= $database->getEscaped(trim(mosGetParam($_POST, 'sstring', '')));
$sstring 		= $database->getEscaped(trim(mosGetParam($_REQUEST, 'sstring', '')));
$imgtitle 		= $database->getEscaped(trim(mosGetParam($_POST, 'imgtitle', '')));
$imgtext 		= $database->getEscaped(trim(mosGetParam($_POST, 'imgtext', '')));
$cmtname 		= $database->getEscaped(trim(mosGetParam($_POST, 'cmtname', '')));
$cmttext 		= $database->getEscaped(trim(mosGetParam($_POST, 'cmttext', '')));
$thumbcreation 		= trim(mosGetParam($_POST, 'thumbcreation', ''));
$imgauthor 		= trim(mosGetParam($_POST, 'imgauthor', ''));
$imgoriginalname 	= trim(mosGetParam($_POST, 'imgoriginalname', ''));
$imgfilename 		= trim(mosGetParam($_POST, 'imgfilename', ''));
$imgthumbname 		= trim(mosGetParam($_POST, 'imgthumbname', ''));
$ordering 		= trim(mosGetParam($_POST, 'ordering', ''));
$sorting 		= trim(mosGetParam($_POST, 'sorting', ''));
$func 			= trim(mosGetParam($_POST, 'func', ''));
$func 			= trim(mosGetParam($_REQUEST, 'func', ''));
$sorting 		= trim(mosGetParam($_REQUEST, 'sorting', ''));
$org_screenshot 	= @$_FILES['org_screenshot']['tmp_name'];
$org_screenshot_name	= @$_FILES['org_screenshot']['name'];
$tgurl 			= "index.php?option=com_true&Itemid=$Itemid";
$gallerypath 		= $mainframe->getCfg('live_site') . "/components/com_true";
$gallerydir 		= $mainframe->getCfg('absolute_path') . "/components/com_true";
//наши новые пути
$originalpath 		= $mainframe->getCfg('live_site') . $ad_path . "/originals" . "/" . $catid ."/";
$picturepath 		= $mainframe->getCfg('live_site') . $ad_path . "/pictures" . "/" . $catid ."/";
$originaldir 		= $mainframe->getCfg( 'absolute_path' ) . $ad_path . "/originals" . "/" . $catid ."/";
$picturedir 		= $mainframe->getCfg( 'absolute_path' ) . $ad_path . "/pictures" . "/" . $catid ."/";
$originaldirwm 		= $mainframe->getCfg( 'absolute_path' ) . $ad_path . "/originals" . "/"; //оригинальный путь для работы ватермарков
$picturedirwm 		= $mainframe->getCfg( 'absolute_path' ) . $ad_path . "/pictures" . "/"; //оригинальный путь для работы ватермарков
$thumbnailpath 		= $mainframe->getCfg('live_site') . $ad_path . "/thumbs" . "/";
$thumbnailpath2 	= $mainframe->getCfg('live_site') . $ad_path . "/thumbs" . "/" . $catid ."/";
include_once ('libraries/joomlatune/tree.php');
///
$ad_paththumbs = $ad_path.'/thumbs';
$ad_pathimages = $ad_path.'/pictures';
$ad_pathoriginals = $ad_path.'/originals';
//Открытие полного фото из мини эскиза
$header = '';
/*типы JS эффектов в $ad_js_effect
# thickbox == 1
# highslide == 2
*/
if ($ad_mini_to_js && $ad_lightbox && $ad_js_effect == '1') {
	$header .= '<script type="text/javascript" src="'.$gallerypath.'/js/carusel/jquery.js"></script>';
	$header .= '<script type="text/javascript" src="'.$gallerypath.'/js/thickbox/thickbox-compressed.js"></script>';
	$header .= '<link rel="stylesheet" type="text/css" href="'.$gallerypath.'/js/thickbox/thickbox.css" />';
} else if ($ad_mini_to_js && $ad_lightbox && $ad_js_effect == '2') {
	$header .= '<script type="text/javascript" src="'.$gallerypath.'/js/highslide/highslide-full.js"></script>';
	$header .= '<link rel="stylesheet" type="text/css" href="'.$gallerypath.'/js/highslide/highslide.css" />';
	$header .= "<script type='text/javascript'>
					hs.showCredits = false;
					hs.graphicsDir = '$gallerypath/js/highslide/graphics/'
					hs.outlineType = 'rounded-white';
					hs.captionEval = 'this.thumb.alt';
					hs.loadingText = 'loading..';
					hs.registerOverlay(
				    {
				        thumbnailId: null,
				        overlayId: 'controlbar',
				        position: 'top right',
				        hideOnMouseOut: true,
				        opacity: 1
				    }
					);
					</script>";
}
//если разрешено первое поле - подгрузим скрипты календарика
if ($ad_field1 && ($func == 'editpic' || $func == 'showupload')) {
	$livesait = $mainframe->getCfg('live_site');
	$header .= "<script type=\"text/javascript\" src=\"$livesait/includes/js/calendar/calendar.js\"></script>\n";
	$header .= "<script type=\"text/javascript\" src=\"$livesait/includes/js/calendar/lang/calendar-en.js\"></script>\n";
	$header .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$livesait/includes/js/calendar/calendar-mos.css\" />\n";

}
$mainframe->addCustomHeadTag($header);
//
$query = "SELECT cid AS id, parent FROM #__true_catg";
$database->setQuery( $query );
$rows = $database->loadObjectList();
$all_tree = new JoomlaTuneTree( $rows );
if(@$func == 'wmark') {
	require_once ($gallerydir . "/sub_wm.php");
	exit;
}
//echo '<br />'; - Нахрен нада? CRYSIS
$mainframe->setPageTitle(JText::_('TG_GALLERY'));
$is_editor = (strtolower($my->usertype) == 'editor' || strtolower($my->usertype) == 'administrator' || strtolower($my->usertype) == 'super administrator');
$is_user = (strtolower($my->usertype) <> '');
//Шапка галереи
function GalleryHeader() {
		global $mainframe, $database, $catid, $Itemid, $id, $tgurl, $gid, $ad_pathway, $ad_comtitle, $ad_search,
		$ad_showpanel, $ad_userpannel, $ad_special, $ad_rating, $ad_lastadd, $ad_owners, $ad_cat_desc, $ad_lastcomment,
		$my, $gallerypath, $mainframe, $ad_mini_to_js, $ad_showcomment;
		$header = '<link href="'.$gallerypath.'/css/dg.css" rel="stylesheet" type="text/css" />';
		$mainframe->addCustomHeadTag($header);
		if($ad_comtitle)
		    echo '<div class="componentheading">'.JText::_('TG_GALLERY').'</div>';
		if ($ad_pathway) {
			if($catid <> "") {
				echo '<div class="tg_pathway">' . ShowCategoryPathLink($catid) . '</div>';
			} else if($id) {
				$database->setQuery("SELECT a.*, cc.name AS category  FROM #__true AS a, #__true_catg AS cc
				WHERE a.catid=cc.cid AND a.id=$id AND cc.access<='$gid'");
				$rows = $database->loadObjectList();
				$row = &$rows[0];
				echo '<div class="tg_pathway">' . ShowCategoryPathLink($row->catid) . '</div>';
			} 
		}
		if($ad_search) {
			echo '<div class="tg_search" valign="middle">
			<form action="'.sefRelToAbs($tgurl).'" name="searchgalform" target="_top" method="post">
			<input type="hidden" name="option" value="com_true" />
			<input type="hidden" name="Itemid" value="'.$Itemid.'" />
			<input type="hidden" name="func" value="special" />
			<input type="hidden" name="sorting" value="find" />';
			echo "<input type=\"text\" name=\"sstring\" class=\"inputbox\" onblur=\"if(this.value=='') this.value='';\" onfocus=\"if(this.value=='" . JText::_('TG_SEARCH'). "') this.value='';\" value='" . JText::_('TG_SEARCH') . "' /></form>";
			echo '</div><div class="tg_clear"></div> ';
		}
		if($ad_showpanel) {
			echo '<div class="dt_links">';
			if($my->username) {
				if($ad_userpannel) {
					echo "<a href='" . sefRelToAbs("$tgurl&func=userpannel") . "'><strong>" . JText::_('TG_USER_PANEL') . "</strong></a> | ";
				}
			}
			if($ad_special) {
				echo "<a href=\"" . sefRelToAbs("$tgurl&func=special") . "\">" . JText::_('TG_MOST_VIEWED') . "</a> | ";
			}
			if($ad_rating) {
				echo "<a href=\"" . sefRelToAbs("$tgurl&func=special&sorting=rating") . "\">" . JText::_('TG_TOP_RATED') . "</a> | ";
			}
			if($ad_lastadd) {
				echo "<a href=\"" . sefRelToAbs("$tgurl&func=special&sorting=lastadd") . "\">" . JText::_('TG_LAST_ADDED') . "</a> | ";
			}
			if($ad_lastcomment && $ad_showcomment == '1') {
				$comments = $mainframe->getCfg( 'absolute_path' ) . '/components/com_jcomments/jcomments.php';
				if(file_exists($comments)) {
				echo "<a href=\"" . sefRelToAbs("$tgurl&func=special&sorting=lastcomment") . "\">" . JText::_('TG_LAST_COMMENTED') . "</a> | ";
				} else {}
			}
			if($ad_owners) {
				echo "<a href=\"" . sefRelToAbs("$tgurl&func=special&sorting=owners") . "\">" . JText::_('TG_LAST_AUTHORS') . "</a>";
			}
			//echo $ad_showcomment;
			echo '</div>';
		}
	}
//Gallery footer & coopirayt
function GalleryFooter() {
	global $ad_cr, $ad_powered;
	if($ad_powered) {
		echo "<span class=\"dg_kopir\">\n";
		echo "<a href=\"http://crysis.spb.su\" title=\"Создание разработка сайтов верстка шаблонов Joomla\">CRYSIS Lab./[marco_manti]</a>";
 		echo "</span>\n";
	}
	return;
}
global $option;
switch (@$func) {
	case 'special':
		require ($gallerydir . '/sub_viewspecial.php');
		break;
	case 'detail':
		require ($gallerydir . '/sub_viewdetails.php');
		break;
	case 'vote':
		require ($gallerydir . '/sub_votepic.php');
		break;
	case 'editpic':
		if(!$my->username) {
			mosRedirect(sefRelToAbs("$tgurl", JText::_('TG_YOU_NOT_LOGED')));
			die();
		}
		GalleryHeader();
		editPic($uid, $option, $thumbnailpath);
		break;
	case 'savepic':
		if(!$my->username) {
			mosRedirect(sefRelToAbs("$tgurl", JText::_('TG_YOU_NOT_LOGED')));
			die();
		}
		savePic($option);
		break;
	case 'deletepic':
		if(!$my->username) {
			mosRedirect(sefRelToAbs("$tgurl", JText::_('TG_YOU_NOT_LOGED')));
			die();
		}
		deletePic($uid, $option);
		break;
	case 'addcatg':
		if(!$my->username) {
			mosRedirect(sefRelToAbs("$tgurl", JText::_('TG_YOU_NOT_LOGED')));
			die();
		}
		editCatg(0, $option);
		break;
	case 'viewcategory':
		GalleryHeader();
		$database->setQuery("SELECT count(cid) FROM #__true_catg WHERE cid = '$catid' AND access<='$gid'");
		$is_allowed = $database->loadResult();
		if($is_allowed < 1) {
			mosRedirect(sefRelToAbs($tgurl), JText::_('TG_NOT_ACCESS_THIS_DIRECTORY'));
			die();
		}
		echo dgCategories($catid, $Itemid);
		$database->setQuery("SELECT count(a.id)
		FROM #__true AS a
		JOIN #__true_catg AS c ON c.cid=a.catid
		WHERE a.published = '1'  AND a.catid = '$catid' AND a.approved = 1  AND c.access<='$gid' ");
		$count = $database->loadResult();
		$gesamtseiten = floor($count / $ad_perpage);
		$seitenrest = $count % $ad_perpage;
		if($seitenrest > 0) {
			$gesamtseiten++;
		}
		if(isset($startpage)) {
			if($startpage > $gesamtseiten) {
				$startpage = $gesamtseiten;
			} else
				if($startpage < 1) {
					$startpage = 1;
				}
		} else {
			$startpage = 1;
		}
		$start = ($startpage - 1) * $ad_perpage;
		$query = "SELECT * FROM #__true_catg WHERE cid = '" . $catid . "' ORDER BY ordering";
		$database->setQuery($query);
		$vcats = $database->loadObjectList();
		$vcat = &$vcats[0];
		$mainframe->setPageTitle($vcat->name);
		$mainframe->appendMetaTag( 'description', $vcat->cmetadesc ); //добавляем metadesc
		$mainframe->appendMetaTag( 'keywords', $vcat->cmetakey ); //добавляем metakey
		$cw = '';
		if($ad_perpage == '1') {
			$cw = '100%';
		} else if($ad_perpage == '2') {
			$cw = '50%';
		} else if($ad_perpage == '3') {
			$cw = '34%';
		} else if($ad_perpage == '4') {
			$cw = '25%';
		} else if($ad_perpage == '5') {
			$cw = '20%';
		}
		$colspan = $ad_perpage * 2;
		// писать названия чисел нада так CRYSIS!
		if($ad_picincat) {
			if( ($count % 10) == 1) {
				$cpics = JText::_('TG_COUNT_PIC_ONE');
			} else if(($count % 10) > 1 && (($count % 10) < 5)) {
				$cpics = JText::_('TG_COUNT_PIC_TWO_TO_FOUR');
			} else if(($count % 10) > 4) {
				$cpics = JText::_('TG_COUNT_PIC_MORE_THAN_FOUR');
			}
		}
		echo '<div class="dt_image_title">Галерея <b>'.$vcat->name.'</b> ('.$count.' '.@$cpics.')</div>';
		
		//добавляем описание категории при показе мини эскизов
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
		if ($ad_cat_desc) {
			//если полное описание отсутствует то в описание категории вставим вступительную часть
			if (!$vcat->desc_full) {
				$catdesc = $vcat->description;
			} else {
				$catdesc = $vcat->desc_full;
			}
			echo '<tr><td colspan="4"><div class="dg_desc">'.$catdesc.'</div></td></tr>';
		} else {}

		$database->setQuery("SELECT a.*, u.username AS owner
		FROM #__true AS a
		JOIN #__true_catg AS c ON c.cid=a.catid
		JOIN #__users AS u ON a.owner = u.id
		WHERE a.published = '1' AND a.catid = '$catid'  AND a.approved = 1  AND c.access<='$gid'
		ORDER BY a.ordering $ad_sortby LIMIT " . $start . "," . $ad_perpage);
		$rows = $database->loadObjectList();
		$rowcounter = 0;
		foreach ($rows as $row1) {
			if($rowcounter % $ad_cp == 0)
			echo "<tr class=\"sectiontableentry2\">\n";
			echo "<td  align=\"center\" valign=\"top\" style=\"border-bottom: 1px solid #CCC;\">\n";
			if($ad_showdetail)
				if($ad_showrating) {
					if($row1->imgvotes > 0) {
						$fimgvotesum = number_format($row1->imgvotesum / $row1->imgvotes, 2, ",", ".");
						$frating = "$fimgvotesum / $row1->imgvotes ";
					} else {
						$frating = JText::_('TG_NO_VOTES');
					}
				}
			if($ad_showcomment) {
				  $comments = $mainframe->getCfg( 'absolute_path' ) . '/components/com_jcomments/jcomments.php';
				  if (file_exists($comments)) {
				    require_once($comments);
				    $comments = JComments::getCommentsCount($row1->id, 'com_true');
				  }
			}
			$dghits = JText::_('TG_HITS');
			$dgvotes = JText::_('TG_RATING');
			$dgcomment = JText::_('TG_COMMENT1');
			$tle = jsspecialchars($row1->imgtitle);
			//Ссылка на полное изображение
			if ($ad_mini_to_js && $ad_js_effect == '2') {
				$jseffect = 'class="highslide"';
				$imghref = $originalpath.$row1->imgthumbname;
				$onclick = "onclick=\"return hs.expand(this, { captionText: '".$imgtitle."' })\"";
				$title = '';
			} else if ($ad_mini_to_js && $ad_js_effect == '1') {
   				$jseffect = 'class="thickbox"';
				$imghref = $originalpath.$row1->imgthumbname;
				$title = 'title="'.$tle.'"';
				$onclick = '';
			} else {
           		$jseffect = '';
           		$imghref = sefRelToAbs($tgurl.'&func=detail&catid='.$catid.'&id='.$row1->id);
           		$title = '';
           		$onclick = '';
			}
			if ($ad_showwatermark && $ad_mini_to_js) 
				$imghref = sefRelToAbs($tgurl.'&func=wmark&oid='.$row1->id);
   			//картинка мини эскиза
			$tpl_img_thumb = '<div align="center"><br /><a '.$jseffect.' '.$title.' '.$onclick.' href="'.$imghref.'"><img src="'.$thumbnailpath2.$row1->imgthumbname.'" class="dt2" alt="'.$tle.'" /></a><br />'.$tle.'</div>';
			//детали изображения в списке мини эскизов
			if ($ad_cat_img_detail) {
				$tpl_img_thumb_desc_start = '<div align="center" class="small">';
				$tpl_imgtitle = $tle.'<br />'; //заголовок изображения
				$tpl_ownerlink = '<a href="'.sefRelToAbs($tgurl.'&func=special&sorting=owner&op='.$row1->owner).'">'.$row1->owner.'</a><br />'; //ссылка на профиль автора
				if ($row1->field1) {
					$tpl_field1 = $row1->field1.'<br />'; //дополнительное поле 1
				} else {
					$tpl_field1 = '';
				}
				if ($ad_showcomment && file_exists($comments)) {
					$tpl_comments = JText::_('TG_COMMENT').' - '.$comments; //количество комментариев
				} else {
					$tpl_comments = '';
				}
				$tpl_img_thumb_desc_end = '</div>';
			}
			//подключаем шаблон для отображения содержимого ячейки, расчет и рисование ячеек идет выше
			include "components/com_true/tpl/category.php";
			echo '</td>';
			$rowcounter++;
		}
		if($rowcounter % $ad_cp <> 0) {
			for ($i = 1; $i <= ($ad_cp - ($rowcounter % $ad_cp)); $i++) {
				echo '<td valign="middle">&nbsp;</td>';
			}
		}
		echo "</tr>\n</table>\n";
		if($count > $ad_perpage) {
	    	echo "<div class=\"true_nav\">";
	    	echo JText::_('TG_PAGES') . ': ';
			$seiterueck = $startpage - 1;
			if ($seiterueck > 0)
				echo "<a href=\"".sefRelToAbs("$tgurl&func=viewcategory&catid=$catid&startpage=$seiterueck")."\">&lt;&nbsp;</a>";
			for ($i = 1; $i <= $gesamtseiten; $i++) {
				if ($i == $startpage) {
					echo "$i ";
				} else {
					echo "<a href=\"".sefRelToAbs("$tgurl&func=viewcategory&catid=$catid&startpage=$i")."\">$i</a> ";
				}
			}
			$seitevor = $startpage + 1;
			if ($seitevor <= $gesamtseiten) {
				echo "<a href=\"".sefRelToAbs("$tgurl&func=viewcategory&catid=$catid&startpage=$seitevor")."\">&nbsp;&gt;</a> ";
			}
		    echo "</div>";
		}
			break;
		case "showupload":
			if(!$my->username) {
				mosRedirect(sefRelToAbs("$tgurl"), JText::_('TG_YOU_NOT_LOGED'));
				die();
			}
			GalleryHeader();
			showUpload($option, @$batchul);
			break;
		case "uploadhandler":
			if(!$my->username) {
				mosRedirect(sefRelToAbs("$tgurl"), JText::_('TG_YOU_NOT_LOGED'));
				die();
			}
			require_once ($mainframe->getCfg( 'absolute_path' ) . "/administrator/components/com_true/globals.true.php");
			require_once ($mainframe->getCfg( 'absolute_path' ) . "/administrator/components/com_true/config.true.php");
			require_once ($mainframe->getCfg( 'absolute_path' ) . "/administrator/components/com_true/images.true.php");
			$ad_paththumbs = $ad_path.'/thumbs';
       		$ad_pathimages = $ad_path.'/pictures';
       		$ad_pathoriginals = $ad_path.'/originals';
			if(!$is_editor && ($_FILES["org_screenshot"]["size"] > $ad_maxfilesize)) {
				mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), JText::_('TG_SIX_ERR_ONE') . ' ' . $ad_maxfilesize . ' ' . JText::_('TG_SIX_ERR_TWO'));
				die();
			}
			$imagetype = array(1 => 'GIF', 2 => 'JPG', 3 => 'PNG');
			$imginfo = getimagesize($org_screenshot);
			$imginfo[2] = $imagetype[$imginfo[2]];
			if(!$imginfo[3]) {
				mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), JText::_('TG_IMAGEFILE_BAD'));
			} else if($imginfo[2] != 'GIF' && $imginfo[2] != 'JPG' && $imginfo[2] != 'PNG') {
				mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), JText::_('TG_INVALID_IMG_TYPE'));
			} else if($imginfo[0] < $ad_maxwidth || $imginfo[1] < $ad_maxheight) {
				mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), JText::_('TG_MIN_WH') . ' ' . $ad_maxwidth . 'x' . $ad_maxheight . ' ' . JText::_('TG_MIN_WH_TWO'));
				exit;
			}
			$org_screenshot_name = dgImgId($catid, $imginfo[2]);
			if($org_screenshot)
				if($ad_orgresize) {
					if(strlen($org_screenshot) > 0 && $org_screenshot != "none") {
						if($imginfo[0] > $ad_orgwidth || $imginfo[1] > $ad_orgheight) {
							dgImageCreate($org_screenshot, $mainframe->getCfg( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$org_screenshot_name", $ad_orgwidth, $ad_orgheight, $ad_thumbquality, "1");
						} else {
							copy($org_screenshot, $mainframe->getCfg( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$org_screenshot_name");
						}
					}
				}
			if(!$ad_orgresize) {
				if(strlen($org_screenshot) > 0 && $org_screenshot != "none") {
					copy($org_screenshot, $mainframe->getCfg( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$org_screenshot_name");
				}
			}
			if(strlen($org_screenshot) > 0 && $org_screenshot != "none") {
				if($imginfo[0] > $ad_maxwidth || $imginfo[1] > $ad_maxheight) {
					dgImageCreate($org_screenshot, $mainframe->getCfg( 'absolute_path' ) . $ad_pathimages . "/$catid/$org_screenshot_name", $ad_maxwidth, $ad_maxheight, $ad_thumbquality, "1");
				} else {
					copy($org_screenshot, $mainframe->getCfg( 'absolute_path' ) . $ad_pathimages . "/$catid/$org_screenshot_name");
				}
			}
			if($thumbcreation) {
				dgImageCreate($org_screenshot, $mainframe->getCfg( 'absolute_path' ) . $ad_paththumbs . "/$catid/$org_screenshot_name", $ad_thumbwidth, $ad_thumbheight, $ad_thumbquality, $ad_crsc);
			}

			$row = new mostrue($database);

			if(!$row->bind($_POST, "approved owner published ordering")) {
				echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>";
				exit();
			}
			$database->setQuery("SELECT ordering FROM #__true WHERE catid='" . $row->catid . "' ORDER BY ordering DESC LIMIT 1");
			$ordering1 = $database->loadResult();
			$ordering = $ordering1 + 1;
			$row->ordering = $ordering;
			$row->imgdate = mktime();
			$row->owner = $my->id;
			$row->published = 1;
			if($ad_approve) {
				$row->approved = 0;
			} else {
				$row->approved = 1;
			}
			if($row->owner == $is_editor) {
				$row->approved = 1;
			}
			$row->imgoriginalname = $org_screenshot_name;
			$row->imgfilename = $org_screenshot_name;
			$row->imgthumbname = $org_screenshot_name;
			if($row->owner == $is_editor) {
				$row->useruploaded = 0;
			} else {
				$row->useruploaded = 1;
			}
			if(!$row->store()) {
				echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>";
				exit();
			} else {
				require_once ($mainframe->getCfg( 'absolute_path' ) . "/components/com_messages/messages.class.php");
				$database->setQuery("SELECT id FROM #__users WHERE sendEmail = '1' ");
				$users = $database->loadResultArray();
				foreach ($users as $user_id) {
					$msg = new mosMessage($database);
					$msg->send($my->id, $user_id, JText::_('TG_NEW_PIC_SUBMITED'), sprintf(JText::_('TG_NEW_CONTENT_SUBMITED') . " %s " . JText::_('TG_TITLED') . " %s.", $my->username, $row->imgtitle));
				}
			}
			//пишем в счетчик
            $database->setQuery("SELECT MAX(id) FROM #__true");
            $last_id = $database->loadResult();
			$database->setQuery("INSERT INTO #__true_count(id, imgid, count) VALUES (NULL, '$last_id', '0')");
			$database->query();
			mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), JText::_('TG_PIC_SUCCESSFULLY_ADD'));
			break;
		case "userpannel":
			if(!$my->username) {
				mosRedirect(sefRelToAbs("$tgurl&func=showupload"), JText::_('TG_YOU_NOT_LOGED'));
				die();
			}
			GalleryHeader();
			userPannel();
			break;
		case "send2friend":
			$query = "SELECT id FROM #__menu WHERE link = 'index.php?option=com_true'";
			$database->setQuery($query);
			$rows = $database->loadObjectList();
			if(isset($rows[0]->id)) {
				$Itemid = $rows[0]->id;
			} else {
				$Itemid = "";
			}
			$send2friendname = mosGetParam($_POST, "send2friendname", '');
			$send2friendemail = mosGetParam($_POST, "send2friendemail", '');
			$from2friendname = mosGetParam($_POST, "from2friendname", '');
			$from2friendemail = mosGetParam($_POST, "from2friendemail", '');
			$id = intval(mosGetParam($_POST, "id", ''));
			$text = $from2friendname . " (" . $from2friendemail . ") " . JText::_('TG_INVITE_VIEW_PIC') . " \r \n";
			$text .= $mainframe->getCfg('live_site') . "/index.php?option=com_true&Itemid=$Itemid&func=detail&catid=$catid&id=$id \r \n";
			$subject = $mosConfig_sitename . ' - ' . JText::_('TG_RECCOMEND_PIC_FROM_FREND');
			mosMail($mosConfig_mailfrom, $mosConfig_fromname, $send2friendemail, $subject, $text);
			mosRedirect(sefRelToAbs("index.php?option=com_true&Itemid=$Itemid&func=detail&catid=$catid&id=$id"), JText::_('TG_MAIL_SENT'));
			break;
		default:
			GalleryHeader();
			echo dgCategories($catid, $Itemid);
			break;
}
GalleryFooter();
//Загрузка изображений пользователем
function showUpload($option)
	{
		global $my, $ad_userpannel, $database, $tgurl, $ad_field1, $ad_field2, $ad_field3, $ad_field4, $ad_field5,
		$ad_maxuserimage, $ad_category, $ad_maxwidth, $ad_maxheight, $ad_maxfilesize, $mainframe;
		if ($ad_userpannel) {
			$mainframe->setPageTitle(JText::_('TG_NEW_PICTURE'));
			$mainframe->AppendPathway(JText::_('TG_NEW_PICTURE'));
			$database->setQuery("SELECT count(*) FROM #__true WHERE owner = '$my->id'");
			$count_pic = $database->loadResult();
			if($count_pic >= $ad_maxuserimage) {
				mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), JText::_('TG_MAY_ADD_MAX_OFF') . ' ' . $ad_maxuserimage . ' ' . JText::_('TG_PICTURES'));
				die();
			}
			$clist = ShowDropDownCategoryList($ad_category, "catid", ' size="1"');
			echo "<script type=\"text/javascript\">\n";
			echo "function checkMe() {\n";
			echo "var form = document.adminForm;\n";
			echo "if (form.imgtitle.value == \"\") {\n";
			echo "alert('" . JText::_('TG_PIC_MUST_HAVE_TITLE') . "');\n";
			echo "return false;\n";
			echo "} else if (form.catid.value == \"0\") {\n";
			echo "alert('" . JText::_('TG_MUST_SELECT_CATEGORY') . "');\n";
			echo "return false;\n";
			echo "} else if (form.screenshot.value == \"\") {\n";
			echo "alert('" . JText::_('TG_MUST_HAVE_FNAME') . "');\n";
			echo "return false;\n";
			echo "} else { form.submit(); dgLoading(); }} </script>\n";
			echo "<script type=\"text/javascript\">\n";
			echo "var xmlhttp;\n";
			echo "try{xmlhttp = new XMLHttpRequest();}catch(e){\n";
			echo "try{xmlhttp = new ActiveXObject(\"Msxml2.XMLHTTP\");}catch(e){\n";
			echo "try{xmlhttp = new ActiveXObject(\"Microsoft.XMLHTTP\");}catch(e){}}}\n";
			echo "function dgLoading() {\n";
			echo "if(!xmlhttp)return alert(\"No Http Transport.\");\n";
			echo "xmlhttp.open(\"GET\",document.location.href,true);\n";
			echo "xmlhttp.onreadystatechange = function() {\n";
			echo "if (xmlhttp.readyState == 4) {\n";
			echo "document.getElementById(\"status\").innerHTML = '<img src=\"" . $mainframe->getCfg('live_site') . "/components/com_true/images/loading.gif\" border=\"0\" align=\"absmiddle\">'\n";
			echo "}}xmlhttp.send(null);}</script>";
			echo '
				<form action="'.sefRelToAbs($tgurl.'&func=uploadhandler').'" method="post" name="adminForm" enctype="multipart/form-data" onsubmit="checkform();">
				<table cellpadding="4" cellspacing="6" border="0" width="100%" class="sectiontableentry2">
				<tr class="sectiontableheader"><td colspan="3">'.JText::_('TG_NEW_PICTURE').'</td></tr>
				<tr>
					<td width="20%" align="right">'.JText::_('TG_TITLE').':</td>
					<td width="80%">
					<input class="inputbox" type="text" name="imgtitle" size="50" maxlength="100" value="" />
					<td valign="top">'.mosToolTip(JText::_('TG_SHOWUPLOAD_1')).'</td>
				</tr>
				<tr>
					<td valign="top" align="right">'.JText::_('TG_CATEGORY').':</td>
					<td>'.$clist.'</td>
					<td valign="top">'.mosToolTip(JText::_('TG_SHOWUPLOAD_2')).'</td>
				</tr>
				<tr>
					<td valign="top" align="right">'. JText::_('TG_DESCRIPTION') . ':</td>';
					echo '<td valign="top">';
					editorArea('editor1', str_replace('&', '&amp;', ''), 'imgtext', '500', '200', '70', '10');
					echo '</td>';
					//echo '<td><textarea class="inputbox" cols="38" rows="5" name="imgtext"></textarea></td> ';
					echo '<td valign="top">'.mosToolTip(JText::_('TG_SHOWUPLOAD_3')).'</td>
				</tr>';
				//Дополнительные поля показываются в зависимости от настроек админки вкладка ВИД
					if($ad_field1) {
					echo '<tr>
						<td valign = "top" align = "right">'.JText::_('TG_FIELD1').':</td>
						<td>
						<input class="inputbox" type="text" name="field1" id="field1" size="45" maxlength="100" value="" />
						<input type="reset" class="button" value="..." onClick="return showCalendar(\'field1\', \'y-mm-dd\');" />
						</td>
					</tr>';
					}
					if($ad_field2) {
					echo '<tr>
						<td valign = "top" align = "right">'.JText::_('TG_FIELD2').':</td>
						<td><input class="inputbox" type="text" name="field2" value="" size="50" maxlength="100" /></td>
					</tr>';
					}
					if($ad_field3) {
					echo '<tr>
						<td valign = "top" align = "right">'.JText::_('TG_FIELD3').':</td>
						<td><input class="inputbox" type="text" name="field3" value="" size="50" maxlength="100" /></td>
					</tr>';
					}
					if($ad_field4) {
					echo '<tr>
						<td valign = "top" align = "right">'.JText::_('TG_FIELD4').':</td>
						<td><input class="inputbox" type="text" name="field4" value="" size="50" maxlength="100" /></td>
					</tr>';
					}
					if($ad_field5) {
					echo '<tr>
						<td valign = "top" align = "right">'.JText::_('TG_FIELD5').':</td>
						<td><input class="inputbox" type="text" name="field5" value="" size="50" maxlength="100" /></td>
					</tr>';
					}
					echo '<tr>
						<td valign = "top" align = "right"></td>
						<td>'.JText::_('TG_TAGS').':<input class="inputbox" type="text" name="tags" value="" size="50" maxlength="100" /></td>
					</tr>';
					echo '<tr>
					<td valign="top" align="right"></td>
					<td>'. JText::_('TG_PICTURE') .':<br />
						<input class="inputbox" type="file" name="org_screenshot" />
						<span style="padding:0 6px;font-weight:400">'. JText::_('TG_TYPE') .':
							<span style="color:#669900;padding:0 6px">JPEG, JPG, PNG, GIF</span>
						</span>
					</td>
					<td valign="top">'. mosToolTip(JText::_('TG_SHOWUPLOAD_5') . $ad_maxwidth . ' x ' . $ad_maxheight . ' ' . JText::_('TG_MIN_WH_TWO') . JText::_('TG_SHOWUPLOAD_6') . format_filesize($ad_maxfilesize) . '<br />' . JText::_('TG_SHOWUPLOAD_7')) . '</td>
					</tr>
					<tr>
					<td colspan="3" align="center">
						<input type="hidden" name="screenshot" value="ON" checked />
						<input type="hidden" name="thumbcreation" value="ON" checked />
						<input type="hidden" name="owner" value="22"/>
						<div id="status">
							<input type="button" value='. JText::_('TG_UPLOAD') .' class="button" onclick="checkMe();" />
							<input type="button" value='. JText::_('TG_CANCEL_TB') .' class="button" onclick="javascript:history.go(-1);" />
						</div>
						<input type="hidden" name="id" value="" />
						<input type="hidden" name="option" value="'. $option .'" />
						<input type="hidden" name="imgauthor" value=""/>

						<input type="hidden" name="task" value=""/>
					</td>
				</tr>
			</table></form>';
		} else {
	    	echo JText::_('TG_NOT_USER_PANNEL');
		}
	}
//редактирование изображения пользователем
function editPic($uid, $option, $thumbnailpath)
	{
		global $my, $catid, $ad_userpannel, $ad_field1, $ad_field2, $ad_field3, $ad_field4, $ad_field5,
		$database, $ad_paththumbs, $ad_category, $tgurl, $ad_imgstyle, $mainframe;
		if ($ad_userpannel) {
			$mainframe->setPageTitle(JText::_('TG_NSDES'));
			$mainframe->AppendPathway(JText::_('TG_NSDES'));
			$row = new mostrue($database);
			$row->load($uid);
			if($row->owner != $my->id) {
				mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), JText::_('TG_NOT_ALOWED_EDIT_PIC'));
				die();
			}
			$clist = ShowDropDownCategoryList($row->catid, "catid", ' size="1"');
			echo "<script type=\"text/javascript\">\n";
			echo "function checkMe() {\n";
			echo "var form = document.adminForm;\n";
			echo "if (form.imgtitle.value == '') {\n";
			echo "alert('" . JText::_('TG_PIC_MUST_HAVE_TITLE') . "');\n";
			echo "return false;\n";
			echo "} else if (form.catid.value == '0') {\n";
			echo "alert('" . JText::_('TG_MUST_SELECT_CATEGORY') . "');\n";
			echo "return false;\n";
			echo "} else {\n";
			echo "form.submit();\n";
			echo "dgLoading();\n";
			echo "}\n";
			echo "}\n";
			echo "</script>\n";
			echo "<script type=\"text/javascript\">\n";
			echo "var xmlhttp;\n";
			echo "try{xmlhttp = new XMLHttpRequest();}catch(e){\n";
			echo "try{xmlhttp = new ActiveXObject(\"Msxml2.XMLHTTP\");}catch(e){\n";
			echo "try{xmlhttp = new ActiveXObject(\"Microsoft.XMLHTTP\");}catch(e){}}}\n";
			echo "function dgLoading() {\n";
			echo "if(!xmlhttp)return alert(\"No Http Transport.\");\n";
			echo "xmlhttp.open(\"GET\",document.location.href,true);\n";
			echo "xmlhttp.onreadystatechange = function() {\n";
			echo "if (xmlhttp.readyState == 4) {\n";
			echo "document.getElementById(\"status\").innerHTML = '<img src=\"" . $mainframe->getCfg('live_site') . "/components/com_true/images/loading.gif\" border=\"0\" align=\"absmiddle\">'\n";
			echo "}\n";
			echo "}\n";
			echo "xmlhttp.send(null);\n";
			echo "}\n";
			echo "</script>";
			echo "<table width='100%' cellpadding='4' cellspacing='0' border='0'>\n";
			echo "<tr class = 'sectiontableheader'>\n";
			echo "<td>\n " . JText::_('TG_NSDES') . " </td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			$thumbnailpath = $mainframe->getCfg('live_site') . $ad_paththumbs . "/" .$row->catid;
			echo '
			<form action="'.sefRelToAbs($tgurl.'&func=savepic').'" method="post" name="adminForm" enctype="multipart/form-data" onsubmit="checkform();">
			<input type="hidden" name="option" value="'.$option.'" />
			<table cellpadding="4" cellspacing="3" border="0" width="100%"  class="sectiontableentry2">
			<tr class="">
				<td width="20%" align="right">'.JText::_('TG_TITLE').':</td>
				<td width="80%"><input class="inputbox" type="text" name="imgtitle" size="51" maxlength="100" value="'.htmlspecialchars($row->imgtitle, ENT_QUOTES).'" /></td>
			</tr>
			<tr>
				<td valign="top" align="right">'.JText::_('TG_CATEGORY').':</td>
				<td>'.$clist.'</td>
			</tr>
			<tr>
				<td valign="top" align="right">'.JText::_('TG_DESCRIPTION').':</td>
				<td>';
				editorArea('editor1', str_replace('&', '&amp;', $row->imgtext), 'imgtext', '500', '200', '70', '10');
			echo '</td></tr>';
					//Дополнительные поля показываются в зависимости от настроек админки вкладка ВИД
					if($ad_field1) {
					echo '<tr>
						<td valign="top" align="right">'.JText::_('TG_FIELD1').':</td>
						<td><input class="inputbox" type="text" name="field1" id="field1" size="45" maxlength="100" value="'.htmlspecialchars($row->field1, ENT_QUOTES).'" />
		                <input type="reset" class="button" value="..." onClick="return showCalendar(\'field1\', \'y-mm-dd\');" />
						</td>
					</tr>';
					}
					if($ad_field2) {
					echo '<tr>
						<td valign="top" align="right">'.JText::_('TG_FIELD2').':</td>
						<td><input class="inputbox" type="text" name="field2" value="'.$row->field2.'" size="51" maxlength="100" /></td>
					</tr>';
					}
					if($ad_field3) {
					echo '<tr>
						<td valign="top" align="right">'.JText::_('TG_FIELD3').':</td>
						<td><input class="inputbox" type="text" name="field3" value="'.$row->field3.'" size="51" maxlength="100" /></td>
					</tr>';
					}
					if($ad_field4) {
					echo '<tr>
						<td valign="top" align ="right">'.JText::_('TG_FIELD4').':</td>
						<td><input class="inputbox" type="text" name="field4" value="'.$row->field4.'" size="51" maxlength="100" /></td>
					</tr>';
					}
					if($ad_field5) {
					echo '<tr>
						<td valign="top" align="right">'.JText::_('TG_FIELD5').':</td>
						<td><input class="inputbox" type="text" name="field5" value="'.$row->field5.'" size="51" maxlength="100" /></td>
					</tr>';
					}
					echo '<tr>
						<td valign="top" align="right"></td>
						<td>'.JText::_('TG_TAGS').':<input class="inputbox" type="text" name="tags" value="'.$row->tags.'" size="51" maxlength="100" /></td>
					</tr>';
			echo '<tr class="sectiontableentry2">
				<td valign = "top" align = "right">'.JText::_('TG_PICTURE').':</td>
				<td><img src="'.$thumbnailpath.'/'.$row->imgthumbname.'" name="imagelib" style="'.$ad_imgstyle.'" title="'.JText::_('TG_THUMB_PREVIEW').'" alt="" class="dt2" /></td>
				</tr>
				<tr class="sectiontableentry2">
					<td colspan="2" align="center">
						<div id="status"><input type="button" value="'.JText::_('TG_SAVE').'" class="button" onclick="checkMe();" />
						<input type="button" value="'.JText::_('TG_CANCEL_TB').'" class="button" onclick="javascript:history.go(-1);" /></div>
					</td>
				</tr>
				</table>
				<input type="hidden" name="id" value="'.$row->id.'" />
				<input type="hidden" name="oldcatid" value="'.$row->catid.'" />
				<input type="hidden" name="imgthumbname" value="'.$row->imgthumbname.'" />
				<input type="hidden" name="option" value="'.$option.'" />
				<input type="hidden" name="task" value="savepic" />
				</form>';
		} else {
	    	echo JText::_('TG_NOT_USER_PANNEL');
		}
	}
?>
	<script language="javascript" type="text/javascript">
	<!--
	function showThumb(title, name) {
	html = '<div style="width:100%;text-align:center;vertical-align:middle;"><img style="border:1px solid #fff; margin:20px" src='+name+' name="imagelib" alt="No Pics" />'+'<' + '/div>';
	return overlib(html, CAPTION, title)
	}
	-->
	</script>
   <?php
 //пользовательская панель на фронте
function userPannel()
	{
		global $database, $my, $ad_approve, $tgurl, $ad_paththumbs, $mainframe, $ad_userpannel;
	    if ($ad_userpannel) {
			$limit = trim(mosGetParam($_REQUEST, 'limit', 20));
			$limitstart = trim(mosGetParam($_REQUEST, 'limitstart', 0));
			$database->setQuery("SELECT count(*) FROM #__true WHERE owner='$my->id' ORDER BY ordering DESC");
			$count = $database->loadResult();
			require_once ("includes/pageNavigation.php");
			$pageNav = new mosPageNav($count, $limitstart, $limit);
			$mainframe->setPageTitle(JText::_('TG_USER_PANEL'));
			$mainframe->AppendPathway(JText::_('TG_USER_PANEL'));
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4">
				<tr class="sectiontableheader">
				<td width="40%" style="">'.JText::_('TG_PIC_NAME').'</td>
				<td width="5%">'.JText::_('TG_HITS').'</td>
				<td width="5%">'.JText::_('TG_COMMENT').'</td>
				<td width="55%">'.JText::_('TG_CATEGORY').'</td>
				<td colspan="3">'.JText::_('TG_ACTION').'</td>';
				if($ad_approve) {
					echo '<td>'.JText::_('TG_APPROWED').'</td>';
				}
			echo '</tr>';
			$database->setQuery("SELECT a.*, tc.count AS imgcounter
				FROM #__true AS a
				JOIN #__true_count as tc ON a.id = tc.imgid
				WHERE owner='$my->id' ORDER BY id DESC LIMIT $limitstart, $limit");
			$rows = $database->loadObjectList();
			$k = 0;
			if(count($rows)) {
				foreach ($rows as $row) {
					$k = 1 - $k;
					$kp = $k + 1;
					$imgprev = $mainframe->getCfg('live_site') . $ad_paththumbs . "/$row->imgthumbname";
					$thumbnailpath = $mainframe->getCfg('live_site') . $ad_paththumbs . "/" .$row->catid;
					$comments2 = $mainframe->getCfg( 'absolute_path' ) . '/components/com_jcomments/jcomments.php';
							if(file_exists($comments2)) {
								require_once ($comments2);
								$comments = JComments::getCommentsCount($row->id, 'com_true');
							} else {
								$comments = JText::_('TG_ALLOW_COMM_NO_JC');
							}
					echo '
					<tr class="sectiontableentry'.@$kp.'">
						<td align="center" valign="middle">
							<a href="'.sefRelToAbs($tgurl.'&func=detail&catid='.$row->catid.'&id='.$row->id).'" title="'.JText::_('TG_GO_TO_PIC').'">'.$row->imgtitle.'<br />
							<img class="dt2" src="'.$thumbnailpath.'/'.$row->imgthumbname.'" border="0" width="50%" />
							</a>
						</td>
						<td align="center" valign="middle">'.$row->imgcounter.'</td>
						<td align="center" valign="middle">'.$comments.'</td>
						<td valign="middle">'.ShowCategoryPath($row->catid).'</td>
						<td align="center" width="20" valign="middle">
							<a href="'.sefRelToAbs($tgurl.'&func=detail&catid='.$row->catid.'&id='.$row->id).'">
							<img src="components/com_true/images/true.png" width="16" height="16" border="0" title="'.JText::_('TG_GO_TO_PIC').'" /></a>
						</td>
						<td align="center" width="20" valign="middle">
							<a href="'.sefRelToAbs($tgurl.'&func=editpic&uid='.$row->id).'">
							<img src="images/M_images/edit.png" border="0" title="'.JText::_('TG_EDIT').'" /></a>
						</td>
						<td align="center" width="20" valign="middle">';
							echo "<img src='components/com_true/images/edit_trash.png' onClick=\"javascript:if(confirm('".JText::_('TG_SURE_DELETE_SELECT_ITEM')."')){location.href='".sefRelToAbs("$tgurl&func=deletepic&uid=$row->id")."';}\" style='cursor: pointer;'  />";
						echo '</td>';
						if($ad_approve) {
							if($row->approved) {
								$a_pic = "<a onmouseover=\"return overlib('" . JText::_('TG_PIC_APPROVED') . "');\" onmouseout=\"return nd();\">";
								$a_pic .= "<img src='components/com_true/images/tick.png' border='0' /></a>";
							} else {
								$a_pic = "<a onmouseover=\"return overlib('" . JText::_('TG_PIC_PENDING') . "');\" onmouseout=\"return nd();\">";
								$a_pic .= "<img src='components/com_true/images/publish_x.png' border='0' /></a>";
							}
							echo "<td align='center' width='20'>" . $a_pic . "</td>\n";
						}
					echo "</tr>\n";
				}
			} else {
				echo '<tr class="sectiontableentry'.@$kp.'">
				<td width="15" align="center" valign="middle">
					<div align="center"><img src="components/com_true/images/blank.gif" /></div>
				</td>
				<td colspan="5">'.JText::_('TG_NOT_HAVE_PIC').'</td>
				</tr>';
			}
			echo '<tr><td align="right" colspan="5">
			<input type="button" name="Button" value="'.JText::_('TG_NEW_PICTURE').'"';
			echo "onclick = \"javascript:location.href='" . sefRelToAbs("$tgurl&func=showupload") . "';\"";
			echo 'class="button" />';
			echo '</td></tr></table>
			<br /><div align="center">';
			echo $pageNav->writePagesLinks("$tgurl&func=userpannel");
			echo "<br />";
			echo $pageNav->writePagesCounter();
			echo "<br />";
			echo $pageNav->writeLimitBox("$tgurl&func=userpannel");
			echo "</div>";
	     } else {
	     	echo JText::_('TG_NOT_USER_PANNEL');
	     }
	}
//сохранение картинки пользователем
function savePic()
	{
		global $database, $ad_approve, $tgurl, $my, $is_editor, $mainframe, $ad_path;
		$row = new mostrue($database);
		if(!$row->bind($_POST, "approved owner published orgimagename imgfilename imgthumbname")) {
			echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
			exit();
		}
		$row->imgdate = mktime();
		$row->owner = $my->id;
		$row->published = 1;
		if($ad_approve) {
			$row->approved = 0;
		} else {
			$row->approved = 1;
		}
		if($row->owner == $is_editor) {
			$row->approved = 1;
		}
		if(!$row->store()) {
			echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
			exit();
		}
		//переносим файлы изображений
		$oldcatid = $_POST['oldcatid'];
		$imgthumbname = $_POST['imgthumbname'];
		$catid = $row->catid;
		$ad_paththumbs = $ad_path.'/thumbs/';
 		$ad_pathimages = $ad_path.'/pictures/';
  		$ad_pathoriginals = $ad_path.'/originals/';
		$orgimg1 = $mainframe->getCfg( 'absolute_path' ).$ad_pathoriginals.$oldcatid."/".$imgthumbname;
		$newimg1 = $mainframe->getCfg( 'absolute_path' ).$ad_pathoriginals.$catid."/".$imgthumbname;
		$orgimg2 = $mainframe->getCfg( 'absolute_path' ).$ad_pathimages.$oldcatid."/".$imgthumbname;
		$newimg2 = $mainframe->getCfg( 'absolute_path' ).$ad_pathimages.$catid."/".$imgthumbname;
		$orgimg3 = $mainframe->getCfg( 'absolute_path' ).$ad_paththumbs.$oldcatid."/".$imgthumbname;
		$newimg3 = $mainframe->getCfg( 'absolute_path' ).$ad_paththumbs.$catid."/".$imgthumbname;
		rename($orgimg1, $newimg1);
		rename($orgimg2, $newimg2);
		rename($orgimg3, $newimg3);
		//
		mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), $orgimg1);
	}
//удаление картинки пользователем
function deletePic($uid)
	{
		global $database, $my, $catid, $mainframe, $ad_path, $tgurl;
		$database->setQuery("SELECT owner FROM #__true WHERE id=" . intval($uid));
		$own = $database->loadResult();
		if($own != $my->id) {
			mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), JText::_('TG_NOT_ALOWED_DELETE_PIC'));
			die();
		}
		if($uid) {
			$row = new mostrue($database);
			$row->load($uid);
			$ad_paththumbs = $ad_path.'/thumbs';
 			$ad_pathimages = $ad_path.'/pictures';
  			$ad_pathoriginals = $ad_path.'/originals';
			if(unlink($mainframe->getCfg( 'absolute_path' ) . $ad_pathoriginals . "/$row->catid/$row->imgoriginalname"))
				if(unlink($mainframe->getCfg( 'absolute_path' ) . $ad_pathimages . "/$row->catid/$row->imgfilename"))
					if(unlink($mainframe->getCfg( 'absolute_path' ) . $ad_paththumbs . "/$row->catid/$row->imgthumbname")) {
						$database->setQuery("DELETE FROM #__true WHERE id=$uid");
						if(!$database->query()) {
							echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
						}
						$database->setQuery("DELETE FROM #__true_count WHERE imgid=$uid");
						if(!$database->query()) {
							echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
						}
					} else {
						die(JText::_('TG_NOT_DELETE_THMB_IMAGE_FILE'));
					}
		} else {
			die(JText::_('TG_FFFFFFF'));
		}
		mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), JText::_('TG_PIC_COMMENT_DELETED'));
	}
//построение выпадающего списка категорий
function ShowDropDownCategoryList($cat, $cname="cat", $extra=null, $flag=0)
	{
		global $database;
		//$cat = '10';
		$category = "<select name=\"$cname\" class=\"inputbox\" >";
		if($flag == 1)
			$add_category = true;
		$query = "select *, cid AS id  from #__true_catg ORDER BY ordering";
		$database->setQuery($query);
		$items = $database->loadObjectList();
		$children = array();
		foreach ($items as $v) {
			$pt = $v->parent;
			$list = @$children[$pt] ? $children[$pt] : array();
			array_push($list, $v);
			$children[$pt] = $list;
		}
		$array = mosTreeRecurse(0, '', array(), $children);
		$options[] = mosHTML::makeOption(0, JText::_('TG_SUBCAT_SELECT'));
		foreach ($array as $item) {
			$options[] = mosHTML::makeOption($item->id, $item->treename);
		}
		$category = mosHTML::selectList($options, $cname, 'class="inputbox"', 'value', 'text',  $cat);
		return $category;
	}
//получение списка категорий
function dgCategories($catid)
	{
		global $database, $my, $gid, $tgurl, $ad_imgstyle, $ad_ncsc, $thumbnailpath, $gallerypath,
		$ad_thumbwidth, $ad_thumbheight, $ad_catsperpage, $ad_showinformer;
		$limit = trim(mosGetParam($_REQUEST, 'limit', $ad_catsperpage));
		$limitstart = trim(mosGetParam($_REQUEST, 'limitstart', 0));
		$par = "SELECT count(cid) FROM #__true_catg as cid WHERE parent=$catid AND access<='" . $my->gid . "'";
		$database->setQuery($par);
		$total = $database->loadResult();
		require_once ("includes/pageNavigation.php");
		$pageNav = new mosPageNav($total, $limitstart, $limit);
		$query = "SELECT d.*
		FROM #__true_catg AS d
		WHERE d.parent=$catid AND access<='" . $my->gid . "'
		ORDER BY d.ordering DESC LIMIT " . $limitstart . ", " . $limit . " ";
		$database->setQuery($query);
		$rows = $database->loadObjectList();
		$num_rows = count($rows);
		$index = 0;
		if($ad_ncsc > $num_rows) {
			$ad_ncsc = $num_rows;
		} else {
			$ad_ncsc = $ad_ncsc;
		}
		if($ad_ncsc == '1') {
			$cw = '100%';
		} else if($ad_ncsc == '2') {
			$cw = '50%';
		} else if($ad_ncsc == '3') {
			$cw = '34%';
		} else if($ad_ncsc == '4') {
			$cw = '25%';
		} else if($ad_ncsc == '5') {
			$cw = '20%';
		}
		$colspan = $ad_ncsc * 2;
		$output = '<table cellspacing="6" cellpadding="0" border="0" width="680">';
		if(@$rows[0]->parent) {
			$output .= '<tr><td align="left" colspan="' . $colspan . '" class="sectiontableheader">' . JText::_('TG_SUBCATEGORIES') . '</td></tr>';
		}
		if($num_rows)
			for ($row_count = 0; $row_count < ($num_rows / $ad_ncsc); $row_count++) {
				$output .= '<tr class="sectiontableentry2">';
				for ($i = 0; $i < $ad_ncsc; $i++) {
					$cur_name = @$rows[$index];
					$output .= '<td align="center" valign="top">';
					if(@$cur_name->cid) {
						$output .= '<a href="' . sefRelToAbs("$tgurl&func=viewcategory&catid=$cur_name->cid") . '">';
					}
					//$n_t = GetThumbsInCats($cur_name->cid);
					if(!@$cur_name->cid) {
						$output .= '</td><td>&nbsp;</td>';
					} else {
						$catid = $cur_name->cid;
						//фиксированная картинка или рандом
						$curcatimg = $cur_name->catimg;
						if ($curcatimg == '0') {
							$where_catimg = 'ORDER BY rand()';
						} else {
							$where_catimg = "AND p.id = ".$curcatimg."";
						}
						$database->setQuery("SELECT *, c.access, c.cid as cid
							FROM #__true AS p
							JOIN #__true_catg AS c on c.cid=p.catid
							WHERE (catid = '$catid' or parent = '$catid') AND p.approved='1'
							AND c.access<= $my->gid
							AND p.approved='1' AND c.access<='" . $my->gid . "'
							$where_catimg LIMIT 1");
						$database->LoadObject($rowimg);
						//$count = count($rowimg);
                        if (GetNumberOfLinks($cur_name->cid) == JText::_('TG_NO_PICS')) {
                        	$output .= '<img src="components/com_true/images/blank.gif" style="' . $ad_imgstyle . '" class="dt2" title="' . JText::_('TG_OPEN_CAT') . '" alt="" /></a></td>';
							$output .= '<td class="sectiontableentry2" align="left" valign="top" width="' . $cw . '">';
                        } else {
							$output .= '<img src="' . $thumbnailpath . $rowimg->catid . "/" . $rowimg->imgthumbname . '" style="' . $ad_imgstyle . '" class="dt2" title="' . JText::_('TG_OPEN_CAT') . '" alt="" /></a></td>';
							$output .= '<td class="sectiontableentry2" align="left" valign="top" width="' . $cw . '">';
						}
					}
					$output .= '<a href="' . sefRelToAbs("$tgurl&func=viewcategory&catid=" . @$cur_name->cid . "") . '">';
					$output .= '<strong>' . @$cur_name->name . '</strong></a>';
					if(@$cur_name->name) {
						$output .= '<br /><span class="small">(' . GetNumberOfLinks($cur_name->cid) . ')';
						if($ad_showinformer) {
							$output .= '&nbsp;' . GetNewPics($cur_name->cid);
						}
						$output .= '</span>';
					}
					$output .= '<br />' . @$cur_name->description . '</td>';
					$index++;
				}
				$output .= '</tr>';
			}
		$output .= '</table>';
		if(@$rows[0]->parent) {
			$parcid = $rows[0]->parent;
			if($total > $ad_catsperpage) {
				$output .= "<div align='center'>";
				$output .= $pageNav->writePagesLinks("$tgurl&func=viewcategory&catid=$parcid");
				$output .= "</div>";
			}
		} elseif (@$rows[0]->cid) {
			if($total > $ad_catsperpage) {
				$output .= "<div align='center'>";
				$output .= $pageNav->writePagesLinks("$tgurl");
				$output .= "</div>";
			}
		}
		return $output;
	}
//Навигация
function ShowCategoryPathLink($cat)
	{
		global $database, $mainframe, $gid, $id, $tgurl, $gallerypath, $ad_pathway;
		$home = "<img src='$gallerypath/images/home.png' hspace=\"6\" border=\"0\" align=\"left\" alt=\"" . JText::_('TG_HOME') . "\" />" . JText::_('TG_HOME') . "</a>";
		$arrow = 'templates/' . $mainframe->getTemplate() . '/images/arrow.png';
		$abssait = $mainframe->getCfg('absolute_path');
		if (file_exists("$abssait/$arrow")) {
			$picarrow = '<img src="' . $mainframe->getCfg('live_site') . '/' . $arrow . '" hspace="4" alt="" />';
		} else {
			$arrow = '/images/M_images/arrow.png';
			if(file_exists($mainframe->getCfg( 'absolute_path' ) . $arrow)) {
				$picarrow = '<img src="' . $mainframe->getCfg('live_site') . '/images/M_images/arrow.png" hspace="4" alt="" />';
			} else {
				$picarrow = '&raquo;';
			}
		}
		$cat = intval($cat);
		$parent = 1000;
		while ($parent) {
			$database->setQuery(" SELECT * FROM #__true_catg WHERE cid=$cat AND published=1 AND access<='" . $gid . "' ");
			$rows = $database->loadObjectList();
			$row = &$rows[0];
			$name = $row->name;
			$parent = $row->parent;
			$query = "SELECT imgtitle FROM #__true WHERE catid = $cat AND id = $id";
			$database->setQuery($query);
			$pname = $database->loadResult();
			$name1 = $name;
			$name2 = "<a href='" . sefRelToAbs("$tgurl&func=viewcategory&catid=$cat") . "' class='pathway'>" . $name . "</a>";
			if(empty($path) && (!$id)) {
				$path = $name1;
			} else {
				$path = $name2 . $picarrow . @$path . $pname;
			}
			$cat = $parent;
		}
		if(!$ad_pathway) {
			$pathName = $home . $picarrow . $path;
		} else {
			$pathName = $mainframe->AppendPathway($path);
		}
		return $pathName;
	}
//Количество ссылок
function GetNumberOfLinks($cat)
	{
		global $database, $gid, $tgurl;
		global $all_tree;
		$queue = $all_tree->descendants( $cat );
		$queue[] = intval($cat);
		reset($queue);
		$query = "SELECT count(id) FROM #__true  WHERE ( 0!=0";
		while (list($key, $cat) = each($queue)) {
			$query .= " or catid = $cat";
		}
		$query = $query . " ) and published=1 and approved = 1";
		$database->setQuery($query);
		$result = $database->query();
		$val = mysqli_fetch_row($result);
		if($val[0] == 1) {
			$capics = JText::_('TG_COUNT_PIC_ONE');
		} else if($val[0] > 1 && ($val[0] < 5)) {
			$capics = JText::_('TG_COUNT_PIC_TWO_TO_FOUR');
		} else if($val[0] > 4) {
			$capics = JText::_('TG_COUNT_PIC_MORE_THAN_FOUR');
		} elseif($val[0] == 0) {
			$capics = JText::_('TG_NO_PICS');
		}
		if($val[0] == 0) {
			return $capics;
		} else {
			return $val[0] . ' ' . $capics;
			return $val;
			//return $output = '123';
		}
	}
//Путь к категории
function ShowCategoryPath($cat)
	{
		global $database, $gid, $tgurl;
		$cat = intval($cat);
		$parent = 1000;
		while ($parent) {
			$database->setQuery("SELECT * FROM #__true_catg WHERE cid=$cat AND access<='" . $gid . "' ");
			$rows = $database->loadObjectList();
			$row = &$rows[0];
			$parent = $row->parent;
			$name = $row->name;
			if(empty($path)) {
				$path = $name;
			} else {
				$path = $name . ' &raquo; ' . $path;
			}
			$cat = $parent;
		}
		return $path . " ";
	}
//получение превьюшки для категории
function GetThumbsInCats($cat)
	{
		global $database, $gid;
		global $all_tree;
		$queue = $all_tree->descendants( $cat );
		$queue[] = intval($cat);
		reset($queue);
		$query = "SELECT imgthumbname FROM #__true  WHERE ( 0!=0";
		while (list($key, $cat) = each($queue)) {
			$query .= " OR catid = $cat";
		}
		$query = $query . " ) AND published=1 AND approved = 1 ORDER BY rand() LIMIT 1";
		$database->setQuery($query);
		$result = $database->query();
		$thumb = mysql_fetch_row($result);
		return $thumb[0];
	}
//статус наличия обновлений в категории
function GetNewPics($cat)
	{
		global $database, $gid, $gallerypath, $ad_periods;
		global $all_tree;
		$queue = $all_tree->descendants( $cat );
		$queue[] = intval($cat);
		reset($queue);
		$query = "SELECT imgdate FROM #__true  WHERE ( 0!=0";
		while (list($key, $cat) = each($queue)) {
			$query .= " OR catid = $cat";
		}
		$query = $query . " ) AND published=1 AND approved = 1 ORDER BY imgdate DESC LIMIT 1";
		$database->setQuery($query);
		$result = $database->query();
		$newpics = mysql_fetch_row($result);
		$today = strtotime('now');
		$diff = intval(($today - $newpics[0]) / $ad_periods);
		if(!$diff) {
			return "<img src='$gallerypath/images/new.gif' width='16' height='11' align='top' border='0' hspace='6' alt='' />";
		} else {
			return false;
		}
	}
?>
