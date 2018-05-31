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
if(@$_REQUEST['is_editor']) {
	print "<script>document.location.href='../../index.php'</script>";
	exit();
}
GalleryHeader();
global $mainframe;
$livesait = $mainframe->getCfg('live_site');
$imagetoolbar = "<meta http-equiv=\"imagetoolbar\" content=\"no\" />\n";
$mainframe->addCustomHeadTag($imagetoolbar);
$header1 = '';
$header2 = '';
$header3 = '';
$header4 = '';
$header5 = '';
/*типы JS эффектов в $ad_js_effect
# thickbox == 1
# highslide == 2
*/
if (($ad_lightbox == '1' && $ad_js_effect == '1') || $ad_carusel ) {
	$header .= "<script type=\"text/javascript\" src=\"$livesait/components/com_true/js/carusel/jquery.js\"></script>\n";
} else {}
if ($ad_lightbox == '1' && $ad_js_effect == '1') {
	$header .= "<script type=\"text/javascript\" src=\"$gallerypath/js/thickbox/thickbox-compressed.js\"></script>\n";
	$header .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$gallerypath/js/thickbox/thickbox.css\" />\n";
} else if ($ad_lightbox == '1' && $ad_js_effect == '2') {
	$header .= "<script type=\"text/javascript\" src=\"$gallerypath/js/highslide/highslide-full.js\"></script>\n";
	$header .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$gallerypath/js/highslide/highslide.css\" />\n";
	$header .= "<script type='text/javascript'>
					hs.showCredits = false;
					hs.graphicsDir = '/components/com_true/js/highslide/graphics/';
					hs.outlineType = 'rounded-white';
					hs.captionEval = 'this.thumb.alt';
					hs.loadingText = '«агружаем...';
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

} else if ($ad_lightbox == '0') {
	$standart_popup  = "<script type=\"text/javascript\" src=\"$gallerypath/js/sub_window.js\"></script>\n";
    $mainframe->addCustomHeadTag( $standart_popup );
}
if ($ad_carusel) {
	$header .= "<script type=\"text/javascript\" src=\"$livesait/components/com_true/js/carusel/jcarousellite.js\"></script>\n";
	$header .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$livesait/components/com_true/js/carusel/jquery.jcarousel.css\" />\n";
	$header .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$livesait/components/com_true/js/carusel/skin.css\" />\n";
}
if ($ad_carusel && $ad_toggle) {
	$header .= "<script type=\"text/javascript\" src=\"$gallerypath/js/toggle/toggle_pack.js\"></script>\n";
	$header .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$gallerypath/js/toggle/toggle.css\" />\n";
	$header .= "<script type=\"text/javascript\">
		$(document).ready(function(){
    	$('div.toggler-c').toggleElements(
        { fxAnimation:'slide', fxSpeed:'slow', className:'toggler' } );
    	$('ul.toggler-c').toggleElements();
		});
	</script>";
} else if ( !$ad_carusel && $ad_toggle) {
	$header .= "<script type=\"text/javascript\" src=\"$gallerypath/js/toggle/toggle_pack.js\"></script>\n";
	$header .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$gallerypath/js/toggle/toggle.css\" />\n";
	$header .= "<script type=\"text/javascript\" src=\"$livesait/components/com_true/js/carusel/jquery.js\"></script>\n";
}

$mainframe->addCustomHeadTag($header);
$database->setQuery("SELECT c.access AS caccess, c.name
	FROM #__true_catg AS c
	JOIN #__true AS a ON a.catid = c.cid
	WHERE a.id = $id ");
$database->LoadObject($row);
$c_access = $row->caccess;
$c_name = $row->name; // название категории дл€ титла

if($gid < $c_access) {
	mosRedirect(sefRelToAbs("$tgurl"), JText::_('TG_NOT_ALLOWED_VIEW_PIC'));
}

$database->setQuery("SELECT a.id, a.catid, a.imgtitle, a.imgauthor, a.imgtext, a.imgdate, tc.count,
	a.imgvotes, a.imgvotesum, a.published, a.imgoriginalname, a.imgfilename, a.imgthumbname, u.username AS owner
	FROM #__true AS a
	JOIN #__users AS u ON u.id = a.owner
	JOIN #__true_count AS tc ON a.id = tc.imgid
	WHERE a.id = $id ");
$list = $database->query();
if(count($database->loadObjectList()) < 1) {
	mosRedirect(sefRelToAbs("$tgurl&func=userpannel"), JText::_('TG_PICSLAD'));
}
list($id, $catid, $imgtitle, $imgauthor, $imgtext, $imgdate, $imgcounter, $imgvotes, $imgvotesum, $published, $imgoriginalname, $imgfilename, $imgthumbname, $imgowner) = mysqli_fetch_row($list);
$id_cache = array();
$query = "SELECT * FROM #__true WHERE catid = $catid AND published = '1' AND approved = 1 ORDER BY ordering $ad_sortby";
$database->setQuery($query);
$rows = $database->loadObjectList();
if(count($rows)) {
	foreach ($rows as $row1) {
		$id_cache[] = $row1->id;
		$ft_cache[] = jsspecialchars($row1->imgtitle);
		$wm = $mainframe->getCfg('live_site') . "/" . $tgurl . "&func=wmark";
		if(!$ad_showwatermark) {
			$fn_cache[] = $picturepath . $row1->imgfilename;
		} else {
			$fn_cache[] = $wm . "&mid=" . $row1->id;
		}
	}
}
$wm = str_replace("&", "&", $wm) . "&";
$act_key = array_search($id, $id_cache);
if($ad_sortby == "ASC") {
	$nid = (isset($id_cache[$act_key + 1])) ? $id_cache[$act_key + 1] : 0;
	$pid = (isset($id_cache[$act_key - 1])) ? $id_cache[$act_key - 1] : 0;
} else {
	$nid = (isset($id_cache[$act_key - 1])) ? $id_cache[$act_key - 1] : 0;
	$pid = (isset($id_cache[$act_key + 1])) ? $id_cache[$act_key + 1] : 0;
}
unset($id_cache);
$query = "SELECT * FROM #__true where id = $id";
$database->setQuery($query);
$rows = $database->loadObjectList();
$row = &$rows[0];
$mainframe->setPageTitle($c_name.' - '.$row->imgtitle);  //добавл€ем в титл страницы название категории
$mainframe->appendMetaTag( 'description', $row->metadesc ); //добавл€ем metadesc
$mainframe->appendMetaTag( 'keywords', $row->metakey ); //добавл€ем metakey
$imgcounter++;
// ѕодробности изображени€
if ($ad_toggle == '1') {
	$tpl_toggle_start = '<div class="toggler-c" title="'.JText::_('TG_TOGGLE_TPL').'">';
	$tpl_toggle_end = '</div>';
} else {
	$tpl_toggle_start = '';
	$tpl_toggle_end = '';
}
//счетчика однака
$database->setQuery("UPDATE #__true_count SET count = $imgcounter WHERE imgid = $id");
$database->query();
//пишем нормальные услови€ дл€ вывода по различным параметрам
//добавл€ем ватермарк и от этого пишем адрес изображений
if ($ad_showwatermark) {
	$imgsrc = $wm.'mid='.$id;
	$imghref = $wm.'oid='.$id;
}  else {
	$imgsrc = $picturepath.$imgfilename;
}
//если эффект - то эффект, иначе грузим просто в попапе
if ($ad_lightbox) {
	if ($ad_js_effect == '1') {
		$jseffect = 'class="thickbox"';
		$jseffect_hj = '';
		$imghref = $originalpath.$imgoriginalname;
		$onclick = '';
	} else {
		$jseffect = 'class="highslide"';
		$jseffect_hj = "onclick=\"return hs.expand(this, { captionText: '".strtr($imgtitle,'"',' ')."' })\"";
		$imghref = $originalpath.$imgoriginalname;
		$onclick = '';
	}
} else {
	$jseffect = '';
	$imghref = 'javascript: void(0);';
	$onclick = "onclick=\"return popup('$originalpath$imgoriginalname', '" . jsspecialchars($imgtitle) . "')\"";
}
if ($ad_lightbox && $ad_showwatermark) {
	$imghref = $wm.'oid='.$id;
}
// Ќазвание картинки
//Ќавигаци€  туда-сюда
	if($pid > 0) {
		$prev_image = '<a href="'.sefRelToAbs("$tgurl&func=detail&catid=$catid&id=$pid").'#top_tg" class="true_prev">&nbsp;</a>';
	} else {
		$prev_image = '';
	}
	if($nid > 0) {
		$next_image = '<a href="'.sefRelToAbs("$tgurl&func=detail&catid=$catid&id=$nid").'#top_tg" class="true_next">&nbsp;</a>';
	} else {
		$next_image = '';
	}
//формируем картинку дл€ среднего эскиза
	if($my->username || ($ad_lightbox_fa > 0)) {
		$mediumimg = '<span><a href="'.$imghref.'" '.$jseffect.' '.$onclick.'  title="'.jsspecialchars($imgtitle).'"><img src="'.$imgsrc.'" alt="'.$imgtitle.'" /></a></span>';
	} else {
		$mediumimg = '<img src='.$imgsrc.' class="dt2" alt="'.$imgtitle.'" />';
	}

//статус пользовател€
global $ad_status1;
$database->setQuery("select id from #__users where username = '$imgowner'");
$op = $database->loadResult();
$database->setQuery("SELECT count(id) FROM #__true WHERE owner = '$op' AND published = 1 AND approved = 1");
$count_pic = $database->loadResult();
if ($count_pic < $ad_status1) {
	$status = JText::_('TG_STATUS1');
} else if ($count_pic >= $ad_status1 && $count_pic < $ad_status2) {
	$status = JText::_('TG_STATUS2');
} else if ($count_pic >= $ad_status2 && $count_pic < $ad_status3) {
	$status = JText::_('TG_STATUS3');
} else if ($count_pic >= $ad_status3 && $count_pic < $ad_status4) {
	$status = JText::_('TG_STATUS4');
} else if ($count_pic >= $ad_status4 && $count_pic < $ad_status5) {
	$status = JText::_('TG_STATUS4');
} else if ($count_pic >= $ad_status5) {
	$status = JText::_('TG_STATUS5');
}
// омментарии
if($ad_showcomment)
	{
		$comments = $mainframe->getCfg( 'absolute_path' ) . '/components/com_jcomments/jcomments.php';
		if(file_exists($comments)) {
			require_once ($comments);
	    	$showcomments =  JComments::showComments($id, 'com_true', $imgtitle);
		} else { $showcomments = ''; }
	} else { $showcomments = ''; }

//если авторизованный пользователь - автор изображени€. то дадим ссылку сразу на редактирование
if ($my->id == $row->owner) {
	$tpl_owner = '<a href="'.sefRelToAbs($tgurl.'&func=editpic&uid='.$row->id).'" class="tg_edit">&nbsp;<img src="images/M_images/edit.png" style="vertical-align:bottom;"></a>'; // только иконка редактировани€
} else {
	$tpl_owner = '';
}
//ƒетали изображени€
if($ad_showdetail)
	{
		$fimgdate = strftime("%d.%m.%Y %H:%M", $imgdate);
		$mosConfig_absolute_path = $mainframe->getCfg( 'absolute_path' );
		$imgsize = filesize("$mosConfig_absolute_path$ad_path/originals/$catid/$imgoriginalname");
		$tgfilesize = format_filesize($imgsize);
		$size_pic[0] = "";
		$size_pic[1] = "";
		$size_pic = @getimagesize("$mosConfig_absolute_path$ad_path/originals/$catid/$imgoriginalname");
		$x = "x";
		$res = "$size_pic[0] $x $size_pic[1]";
		if($imgvotes > 0) {
			$fimgvotesum = number_format($imgvotesum / $imgvotes, 2, ",", ".");
			$frating = "$fimgvotesum ($imgvotes " . JText::_('TG_VOTES') . ")";
		} else {
			$frating = JText::_('TG_NO_VOTES');
		}
		if($ad_showimgtext) {
			if($imgtext) {
				$tpl_imgtext = $row->imgtext;
			} else {
				$tpl_imgtext = ''; }
		}
		if($ad_showfimgdate) {
			$tpl_date = $fimgdate;
		} else {
			$tpl_date = ''; }
		if($ad_showimgcounter) {
			$tpl_count = $imgcounter;
		} else {
			$tpl_count = ''; }
		if($ad_showres) {
			$tpl_size = $res;
		} else {
			$tpl_size = ''; }
		if($ad_showfimgsize) {
			$tpl_filesize = $tgfilesize;
		} else { $tpl_filesize = ''; }
		if($ad_showimgauthor) {
			if($imgauthor == null) {
				$tpl_author = '<a href="'.sefRelToAbs($tgurl.'&func=special&sorting=owner&op='.$op).'"><strong>'.$imgowner.'</strong></a> ('.$status.' - '.$count_pic.')';
			} else {
				$tpl_author = '<a href="'.sefRelToAbs($tgurl.'&func=special&sorting=owner&op='.$op).'"><strong>'.$imgauthor.'</strong></a>';
			}
		} else {$tpl_author = ''; }
		if($ad_field1) {
	    		$tpl_field1 = $row->field1;
		} else {
			$tpl_field1 = ''; }
		if($ad_field2) {
	    		$tpl_field2 = $row->field2;
		} else {
			$tpl_field2 = ''; }
		if($ad_field3) {
	    		$tpl_field3 = $row->field3;
		}  else {
			$tpl_field3 = ''; }
		if($ad_field4) {
	    		$tpl_field4 = $row->field4;
		} else {
			$tpl_field4 = ''; }
		if($ad_field5) {
	    		$tpl_field5 = $row->field5;
		} else {
			$tpl_field5 = ''; }
		if($ad_showrating) {
			if($imgvotes > 0) {
				$star_rating = number_format($imgvotesum / $imgvotes, 2) * 25;
			} else {
				$star_rating = "0";
			}
			$database->setQuery('SELECT * FROM #__true WHERE id=' . (int)$id);
			$database->loadObject($vote);
			if($vote->imgvotes != 0)
			$result = number_format(intval($vote->imgvotesum) / intval($vote->imgvotes), 2) * 20;
			$imgvotesum = intval($vote->imgvotesum);
			$imgvotes = intval($vote->imgvotes);
			$tips = "<script type=\"text/javascript\" src=\"" . $mainframe->getCfg('live_site') . "/components/com_true/js/vote.php\"></script>\n";
			$tips .= "<script type='text/javascript'>\n";
			$tips .= "var live_site = '" . $mainframe->getCfg('live_site') . "';\n";
			$tips .= "var tgvote_lang = new Array();\n";
			$tips .= "tgvote_lang['UPDATING'] = '" . JText::_('TGVOTE_UPDATING') . "';\n";
			$tips .= "tgvote_lang['THANKS'] = '" . JText::_('TGVOTE_THANKS') . "';\n";
			$tips .= "tgvote_lang['ALREADY_VOTE'] = '" . JText::_('TGVOTE_ALREADY_VOTE') . "';\n";
			$tips .= "tgvote_lang['VOTES'] = '" . JText::_('TGVOTE_VOTES') . "';\n";
			$tips .= "</script>\n";
			$mainframe->addCustomHeadTag($tips);
			//автор не может голосовать за свои изображени€
			if ($row->owner == $my->id) {
				$tpl_votes_start = '';
				$tpl_votes_medium = '';
				$tpl_votes_end = '';
			} else {
				$tpl_votes_start = "
				<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
				<tr><td>
				<div class=\"tgvote-inline\">
				<ul class=\"tgvote-star\">
				<li id=\"rating" . $id . "\" class=\"current\" style=\"width:" . @$result . "%\"></li>
				<li><a href=\"javascript:void(0)\" onclick=\"javascript:tgVote(" . $id . ",1," . $imgvotesum . "," . $imgvotes . ");\" title=\"1 " . JText::_('TGVOTE_STAR1') . " 5\" class=\"one-star\">1</a></li>
				<li><a href=\"javascript:void(0)\" onclick=\"javascript:tgVote(" . $id . ",2," . $imgvotesum . "," . $imgvotes . ");\" title=\"2 " . JText::_('TGVOTE_STAR234') . " 5\" class=\"two-stars\">2</a></li>
				<li><a href=\"javascript:void(0)\" onclick=\"javascript:tgVote(" . $id . ",3," . $imgvotesum . "," . $imgvotes . ");\" title=\"3 " . JText::_('TGVOTE_STAR234') . " 5\" class=\"three-stars\">3</a></li>
				<li><a href=\"javascript:void(0)\" onclick=\"javascript:tgVote(" . $id . ",4," . $imgvotesum . "," . $imgvotes . ");\" title=\"4 " . JText::_('TGVOTE_STAR234') . " 5\" class=\"four-stars\">4</a></li>
				<li><a href=\"javascript:void(0)\" onclick=\"javascript:tgVote(" . $id . ",5," . $imgvotesum . "," . $imgvotes . ");\" title=\"5 " . JText::_('TGVOTE_STAR5') . " 5\" class=\"five-stars\">5</a></li>
				</ul>\n</div>
				</td>\n
				<td width=\"100%\">
				<div id=\"tgvote" . $id . "\">&nbsp;&nbsp;";
				if($imgvotes > 0) {
					$tpl_votes_medium = "(" . JText::_('TGVOTE_VOTES') . $imgvotes . ")";
				} else {
					$tpl_votes_medium = "(" . JText::_('TGVOTE_NO_VOTES') . ")";
				}
				$tpl_votes_end = "</div>\n</td>\n</tr>\n</table>\n";
			}
		} else {
			$tpl_votes_start = '';
			$tpl_votes_medium = '';
			$tpl_votes_end = '';
		}
	if($ad_showsend2friend) {
		echo "<br/>\n";
		echo "<script type=\"text/javascript\">\n";
		echo "  function validatesend2friend(){\n";
		echo "    if ((document.send2friend.send2friendname.value=='') || (document.send2friend.send2friendemail.value=='')){\n";
		echo "      alert(\"" . JText::_('TG_ENTER_NAME_EMAIL') . "\");\n";
		echo "      return false;\n } else {";
		echo "      document.send2friend.action = 'index.php';\n";
		echo "      document.send2friend.submit();\n";
		echo "    }}</script>\n";
		if($my->username) {
			$sql = $database->setQuery("SELECT name, email FROM #__users WHERE id='$my->id'");
			$s2y = $database->loadObjectList();
			$tpl_tell_friend = '<form method="post" name="send2friend" action="'.sefRelToAbs($tgurl.'&func=detail&catid='.$catid.'&id='.$id).'">
			<input type="hidden" name="option" value="com_true" />
			<input type="hidden" name="func" value="send2friend" />
			<input type="hidden" name="from2friendname" value="'.$s2y[0]->name.'" />
			<input type="hidden" name="from2friendemail" value="'. $s2y[0]->email .'" />
			<input type="hidden" name="catid" value="'.$catid.'/" />
			<input type="hidden" name="id" value="'.$id.'" />
			<table width="100%" border="0" cellspacing="0" cellpadding="3" style="margin-left: 10px;">
			<tr>
				<td class="sectiontableheader" colspan="2">'.JText::_('TG_SEND_FRIEND') . '</td>
			</tr>
			<tr class="sectiontableentry1">
				<td width="30%" valign="top"><strong>' . JText::_('TG_YOUR_NAME') . ':</strong></td>
				<td valign="top">' . $s2y[0]->name . '</td>
			</tr>
			<tr class="sectiontableentry2">
				<td valign="top"><strong>' . JText::_('TG_YOUR_MAIL') . ':</strong></td>
				<td valign="top">' . $s2y[0]->email . '</td>
			</tr>
			<tr class="sectiontableentry1">
				<td valign="top"><strong>' . JText::_('TG_FRIENDS_NAME') . ':</strong></td><td valign="top">
				<input type="text" name="send2friendname" size="15" class="inputbox" /></td>
			</tr>
			<tr class="sectiontableentry2">
				<td valign="top"><strong>' . JText::_('TG_FRIENDS_MAIL') . ':</strong></td><td valign="top">
				<input type="text" name="send2friendemail" size="15" class="inputbox" /></td>
			</tr>
			<tr class="sectiontableentry1">
				<td colspan="2" valign="top">
				<input type="button" name="send" value="' . JText::_('TG_SEND') . '" class="button" onclick="validatesend2friend()" /></td>
			</tr>
			</table></form>';
		} else {
			$tpl_tell_friend = JText::_('TG_NOT_LOGIN_TELLTOFRIEND');
		}

	} else {
		$tpl_tell_friend = '';
	}
	//ƒобавл€ем две формы с HTML && BB кодами
	if ($ad_bbhtml) {
		$imghref = sefRelToAbs($tgurl.'&func=detail&catid='.$catid.'&id='.$row->id);
		$bbcode = '[URL='.$imghref.'][IMG]'.$imgsrc.'[/img][/URL]';
		$htmlcode = "<a href='".$imghref."'><img src='".$imgsrc."' /></a>";
		$tpl_code = '<form name="html_code" action="">
		<input onfocus="this.select();" name="text" value="'.$bbcode.'" style="width: 250px; margin:3px 0;" readonly /> - '.JText::_('TG_BB_CODE').' <br/>
		<input onfocus="this.select();" name="text" value="'.$htmlcode.'" style="width: 250px; margin:3px 0;" readonly /> - '.JText::_('TG_HTML_CODE').'
		</form>';
	} else { $tpl_code = ''; }
	//рисуем дополнительные изображени€ в виде карусели
	if ($ad_carusel) {
		//выт€гиваем общее кол-во
		$database->setQuery("SELECT count(id) AS count FROM #__true WHERE catid = '$row->catid' AND published = '1' AND approved = 1 ");
		$count_pic = $database->loadResult();
		$count_pic1 = round($count_pic/2);
		//выт€гиваем текущую позицию картинки
		$database->setQuery("SELECT count(id) as count FROM #__true WHERE id < '$row->id' AND catid = '$row->catid' AND published = '1' AND approved = 1 ");
		$count_before = $database->loadResult();
		$header5 .= "<script type=\"text/javascript\">
				jQuery(document).ready(function() {
				jQuery('#mycarousel').jcarousel({
				scroll: 2,
				start: $count_before
				});
				});
				</script>";
		$mainframe->addCustomHeadTag($header5);
		$tpl_carusel="<table align=\"center\"><tr><td><ul id=\"mycarousel\" class=\"jcarousel-skin-tango\">";
		$database->setQuery("SELECT * FROM #__true WHERE catid = '$row->catid' AND published = '1' AND approved = 1 ORDER BY imgdate LIMIT 20 ");
		$rows = $database->loadObjectList();
		foreach($rows as $rows1) {
			$tpl_carusel .= "<li class=\"jcarousel\"><a href=\"".sefRelToAbs("$tgurl&func=detail&catid=$rows1->catid&id=$rows1->id")."\"><img src=\"".$thumbnailpath2.$rows1->imgthumbname."\" class=\"dt2\" alt=\"\" height=\"".$ad_thumbheight."\" /></a></li>";
		}
		$tpl_carusel .="</ul></td></tr></table>";
	} else {$tpl_carusel='';}
	} else {
		$tpl_author = '';
		$tpl_count = '';
		$tpl_votes_start = '';
		$tpl_votes_medium = '';
		$tpl_votes_end = '';
		$tpl_carusel = '';
		$tpl_code = '';
		$tpl_tell_friend = '';
	}

include "components/com_true/tpl/viewdetails.php";?>
