<?php
/***************************************************\
**   True gallery - A Joomla! Gallery Component    **
**   Copyright (C) 2008  by JoomlaForum **
**   Version    : 2.0                              **
**   Homepage   : http://true.palpalych.ru              **
**   License    : Copyright, don't distribute      **
**   Based on   : AkoGallery -> PonyGallery -> DatsoGallery Datso gallery 1.6**
\***************************************************/

defined('_VALID_MOS') or defined('_JEXEC') or die('Direct Access to this location is not allowed.');

$ad_path 	= JTInput::getParam($_POST, 'ad_path', '');
//$ad_pathoriginals 	= JTInput::getParam($_POST, 'ad_pathoriginals', '');
//$ad_pathimages 		= JTInput::getParam($_POST, 'ad_pathimages', '');
//$ad_paththumbs 		= JTInput::getParam($_POST, 'ad_paththumbs', '');
$ad_protect 		= JTInput::getParam($_POST, 'ad_protect', '');
$ad_orgresize 		= JTInput::getParam($_POST, 'ad_orgresize', '');
$ad_orgwidth 		= JTInput::getParam($_POST, 'ad_orgwidth', '');
$ad_orgheight 		= JTInput::getParam($_POST, 'ad_orgheight', '');
$ad_thumbwidth 		= JTInput::getParam($_POST, 'ad_thumbwidth', '');
$ad_thumbheight 	= JTInput::getParam($_POST, 'ad_thumbheight', '');
$ad_crsc 		= JTInput::getParam($_POST, 'ad_crsc', '');
$ad_thumbquality 	= JTInput::getParam($_POST, 'ad_thumbquality', '');
$ad_showdetail 		= JTInput::getParam($_POST, 'ad_showdetail', '');
$ad_showrating 		= JTInput::getParam($_POST, 'ad_showrating', '');
$ad_showcomment 	= JTInput::getParam($_POST, 'ad_showcomment', '');
$ad_showpanel 		= JTInput::getParam($_POST, 'ad_showpanel', '');
$ad_userpannel 		= JTInput::getParam($_POST, 'ad_userpannel', '');
$ad_special 		= JTInput::getParam($_POST, 'ad_special', '');
$ad_rating 		= JTInput::getParam($_POST, 'ad_rating', '');
$ad_lastadd 		= JTInput::getParam($_POST, 'ad_lastadd', '');
$ad_lastcomment	 	= JTInput::getParam($_POST, 'ad_lastcomment', '');
$ad_owners 		= JTInput::getParam($_POST, 'ad_owners', '');
$ad_search 		= JTInput::getParam($_POST, 'ad_search', '');
$ad_pathway		= JTInput::getParam($_POST, 'ad_pathway', '');
$ad_comtitle 		= JTInput::getParam($_POST, 'ad_comtitle', '');
$ad_showsend2friend	= JTInput::getParam($_POST, 'ad_showsend2friend', '');
$ad_picincat 		= JTInput::getParam($_POST, 'ad_picincat', '');
$ad_powered 		= JTInput::getParam($_POST, 'ad_powered', '');
$ad_showwatermark	= JTInput::getParam($_POST, 'ad_showwatermark', '');
$ad_showdownload 	= JTInput::getParam($_POST, 'ad_showdownload', '');
$ad_downpub 		= JTInput::getParam($_POST, 'ad_downpub', '');
$ad_perpage 		= JTInput::getParam($_POST, 'ad_perpage', '');
$ad_catsperpage 	= JTInput::getParam($_POST, 'ad_catsperpage', '');
$ad_sortby 		= JTInput::getParam($_POST, 'ad_sortby', '');
$ad_toplist 		= JTInput::getParam($_POST, 'ad_toplist', '');
$ad_approve 		= JTInput::getParam($_POST, 'ad_approve', '');
$ad_maxuserimage 	= JTInput::getParam($_POST, 'ad_maxuserimage', '');
$ad_maxfilesize 	= JTInput::getParam($_POST, 'ad_maxfilesize', '');
$ad_maxwidth 		= JTInput::getParam($_POST, 'ad_maxwidth', '');
$ad_maxheight 		= JTInput::getParam($_POST, 'ad_maxheight', '');
$ad_category 		= JTInput::getParam($_POST, 'ad_category', '');
$ad_imgstyle 		= JTInput::getParam($_POST, 'ad_imgstyle', '');
$ad_ncsc 		= JTInput::getParam($_POST, 'ad_ncsc', '');
$ad_cr 			= JTInput::getParam($_POST, 'ad_cr', '');
$ad_showimgtext 	= JTInput::getParam($_POST, 'ad_showimgtext', '');
$ad_showfimgdate 	= JTInput::getParam($_POST, 'ad_showfimgdate', '');
$ad_showimgcounter 	= JTInput::getParam($_POST, 'ad_showimgcounter', '');
$ad_showfrating 	= JTInput::getParam($_POST, 'ad_showfrating', '');
$ad_showres 		= JTInput::getParam($_POST, 'ad_showres', '');
$ad_showfimgsize 	= JTInput::getParam($_POST, 'ad_showfimgsize', '');
$ad_showimgauthor 	= JTInput::getParam($_POST, 'ad_showimgauthor', '');
$ad_cp 			= JTInput::getParam($_POST, 'ad_cp', '');
$ad_lightbox 		= JTInput::getParam($_POST, 'ad_lightbox', '');
$ad_lightbox_fa 	= JTInput::getParam($_POST, 'ad_lightbox_fa', '');
$ad_showinformer 	= JTInput::getParam($_POST, 'ad_showinformer', '');
$ad_periods 		= JTInput::getParam($_POST, 'ad_periods', '');
$ad_js_effect 		= JTInput::getParam($_POST, 'ad_js_effect', '');
/////////////
$ad_cat_desc 		= JTInput::getParam($_POST, 'ad_cat_desc', '');
$ad_field1 		= JTInput::getParam($_POST, 'ad_field1', '');
$ad_field2 		= JTInput::getParam($_POST, 'ad_field2', '');
$ad_field3 		= JTInput::getParam($_POST, 'ad_field3', '');
$ad_field4 		= JTInput::getParam($_POST, 'ad_field4', '');
$ad_field5 		= JTInput::getParam($_POST, 'ad_field5', '');
//5 ????????
$ad_status1 		= JTInput::getParam($_POST, 'ad_status1', '');
$ad_status2 		= JTInput::getParam($_POST, 'ad_status2', '');
$ad_status3 		= JTInput::getParam($_POST, 'ad_status3', '');
$ad_status4 		= JTInput::getParam($_POST, 'ad_status4', '');
$ad_status5 		= JTInput::getParam($_POST, 'ad_status5', '');
$ad_cat_img_detail 	= JTInput::getParam($_POST, 'ad_cat_img_detail', '');
$ad_carusel 		= JTInput::getParam($_POST, 'ad_carusel', '');
//
$ad_mini_to_js 		= JTInput::getParam($_POST, 'ad_mini_to_js', '');
$id 			= JTInput::getParam($_REQUEST, 'id', '');
$cid 			= JTInput::getParam($_REQUEST, 'cid', '');
$catid 			= JTInput::getParam($_REQUEST, 'catid', '');
$approved 		= JTInput::getParam($_REQUEST, 'approoved', '');
$catimage 		= JTInput::getParam($_REQUEST, 'catimage', '');
$act 			= JTInput::getParam($_REQUEST, 'act', null);
$task 			= JTInput::getParam($_REQUEST, 'task', null);
$option 		= JTInput::getParam($_REQUEST, 'option', null);
$batchul 		= JTInput::getParam($_REQUEST, 'batchul', null);
$name 			= JTInput::getParam($_REQUEST, 'name', '');
$parent 		= JTInput::getParam($_REQUEST, 'parent', '');
$description 		= JTInput::getParam($_REQUEST, 'description', '');
$access 		= JTInput::getParam($_REQUEST, 'access', '');
$ordering 		= JTInput::getParam($_REQUEST, 'ordering', '');
$imgtitle 		= JTInput::getParam($_REQUEST, 'imgtitle', '');
$imgtext 		= JTInput::getParam($_REQUEST, 'imgtext', '');
$owner 			= JTInput::getParam($_REQUEST, 'owner', '');
$imgauthor 		= JTInput::getParam($_REQUEST, 'imgauthor', '');
$imgoriginalname 	= JTInput::getParam($_REQUEST, 'imgoriginalname', '');
$imgfilename 		= JTInput::getParam($_REQUEST, 'imgfilename', '');
$imgthumbname 		= JTInput::getParam($_REQUEST, 'imgthumbname', '');
$gentitle 		= JTInput::getParam($_POST, 'gentitle', '');
$gendesc 		= JTInput::getParam($_REQUEST, 'gendesc', '');
$photocred 		= JTInput::getParam($_REQUEST, 'photocred', '');
$ordering 		= JTInput::getParam($_POST, 'ordering', '');
$movepic 		= JTInput::getParam($_POST, 'catid', '');
$org_screenshot 	= @$_FILES['org_screenshot']['tmp_name'];
$org_screenshot_name	= @$_FILES['org_screenshot']['name'];
$thumbcreation 		= JTInput::getParam($_POST, 'thumbcreation', '');
$zippack 		= JTInput::getParam($_FILES, 'zippack', '');
$zippack_type		= @$_FILES['zippack']['type'];
$field1 		= JTInput::getParam($_REQUEST, 'field1 ', '');
$field2 		= JTInput::getParam($_REQUEST, 'field2 ', '');
$field3 		= JTInput::getParam($_REQUEST, 'field3 ', '');
$field4 		= JTInput::getParam($_REQUEST, 'field4 ', '');
$field5 		= JTInput::getParam($_REQUEST, 'field5 ', '');
$field1 		= JTInput::getParam($_POST, 'field1', '');
$field2 		= JTInput::getParam($_POST, 'field2', '');
$field3 		= JTInput::getParam($_POST, 'field3', '');
$field4 		= JTInput::getParam($_POST, 'field4', '');
$field5 		= JTInput::getParam($_POST, 'field5', '');
$metadesc 		= JTInput::getParam($_POST, 'metadesc', '');
$metakey 		= JTInput::getParam($_POST, 'metakey', '');
$ad_bbhtml 		= JTInput::getParam($_POST, 'ad_bbhtml', '');
$ad_toggle 		= JTInput::getParam($_POST, 'ad_toggle', '');


function format_filesize($tfilesize)
	{
		global $dgfilesize;
		$format = array(JText::_('TG_FILESIZE_BYTES'), JText::_('TG_FILESIZE_KB'), JText::_('TG_FILESIZE_MB'), JText::_('TG_FILESIZE_GB'));
		$i = 0;
		while ($tfilesize >= 1024) {
			$i++;
			$tfilesize = $tfilesize / 1024;
		}
		return number_format($tfilesize, ($i ? 2 : 0), ",", ".") . " " . $format[$i];
	}

function is_image($filename)
	{
		$ext = strtolower(strrchr($filename, "."));
		return ($ext == ".jpg" || $ext == ".jpeg" || $ext == ".png" || $ext == ".gif");
	}

function is_zip($filename)
	{
		$ext = strtolower(strrchr($filename, "."));
		return ($ext == ".zip");
	}
function dgImgId($catid, $imgext)
	{
		return substr(strtoupper(md5(uniqid(time()))), 5, 12) . '-' . $catid . '.' . strtolower($imgext);
	}

function jsspecialchars($s)
	{
		$r = str_replace(array('\\', '"', "'"), array('\\\\', '&quot;', "&#039;"), $s);
		return htmlspecialchars($r, ENT_QUOTES);
	}
?>