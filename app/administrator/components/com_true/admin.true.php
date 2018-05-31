<?php
/***************************************************\
 **   True gallery - A Joomla! Gallery Component    **
 **   Copyright (C) 2008  by JoomlaForum **
 **   Version    : 2.0.0.1                             **
 **   Homepage   : http://true.palpalych.ru              **
 **   License    : Copyright, don't distribute      **
 **   Based on   : AkoGallery -> PonyGallery -> DatsoGallery Datso gallery 1.6**
 * LAST UPDATED 05.10.2008-21:34 MSK
 ***************************************************/
defined ( '_VALID_MOS' ) or defined ( '_JEXEC' ) or die ( 'Direct Access to this location is not allowed.' );
$tgver = "2.0.2.0011 Beta";

if (! defined ( 'DS' )) {
	define ( 'DS', DIRECTORY_SEPARATOR );
}

$path = str_replace ( 'administrator' . DS, '', dirname ( __FILE__ ) );
//подключаем прослойку для 1.5
require_once ($path . DS . 'true.legacy.php');
require_once (TRUE_LEGACY . DS . 'connector.php');

JTConnector::connect ( TRUE_LEGACY );

require_once (TRUE_ADMIN . 'class.true.php');
require_once (TRUE_ADMIN . 'globals.true.php');
require_once (TRUE_ADMIN . 'images.true.php');
require_once (TRUE_ADMIN . 'admin.true.html.php');
require_once (TRUE_ADMIN . 'nav.php');

$option = JTInput::getParam ( $_REQUEST, 'option' );
$task = JTInput::getParam ( $_REQUEST, 'task' );
$act = JTInput::getParam ( $_REQUEST, 'act' );

//mosCommonHTML::loadOverlib();
JTLibConnect::overLibConnect ();
switch ($act) {
	case "showcatg" :
		$task = "showcatg";
		break;
	case "upload" :
		$task = "upload";
		break;
	case "batchupload" :
		$task = "batchupload";
		break;
	case "batchimport" :
		$task = "batchimport";
		break;
	case "settings" :
		$task = "settings";
		break;
	case "resetvotes" :
		$task = "resetvotes";
		break;
	case "rebuild" :
		$task = "rebuild";
		break;
}
switch ($task) {
	case "publish" :
		publishPicture ( $id, 1, $option );
		break;
	case "unpublish" :
		publishPicture ( $id, 0, $option );
		break;
	case 'movepic' :
		movePic ( $id );
		break;
	case 'movepicres' :
		movePicResult ( $id );
		break;
	case "new" :
		showUpload ( $option );
		break;
	case "edit" :
		editPicture ( $option, $id [0] );
		break;
	case "remove" :
		removePicture ( $id, $option );
		break;
	case "save" :
		savePicture ( $option );
		break;
	case "upload" :
		showUpload ( $option );
		break;
	case "batchupload" :
		showBatchUpload ( $option );
		break;
	case "batchimport" :
		showBatchImport ( $option );
		break;
	case "resetvotes" :
		showVotes ( $option );
		break;
	case "reset" :
		resetVotes ( $option );
		break;
	case "rebuild" :
		showDGrebuild ( $option );
		break;
	case "startdgrebuild" :
		startDGrebuild ( $option );
		break;
	case 'uploadhandler' :
		require_once (TRUE_ADMIN . 'config.true.php');
		///
		$ad_paththumbs = $ad_path.'/thumbs';
       	$ad_pathimages = $ad_path.'/pictures';
       	$ad_pathoriginals = $ad_path.'/originals';
       	////
		$imagetype = array (1 => 'GIF', 2 => 'JPG', 3 => 'PNG' );
		$imginfo = getimagesize ( $org_screenshot );
		if ($imginfo [0] = 0) {
			JTRedirect::_ ( TRUE_INDEX2.'&act=upload', _DG_FILENAME_BAD_UPLOAD );
			exit ();
		}
		$imginfo [2] = $imagetype [$imginfo [2]];
		if ($imginfo [2] != 'GIF' && $imginfo [2] != 'JPG' && $imginfo [2] != 'PNG') {
			JTRedirect::_ ( TRUE_INDEX2.'&act=upload', _DG_FILENAME_BAD );
			exit ();
		}
		$org_screenshot_name = dgImgId ( $catid, $imginfo [2] );
		if ($org_screenshot)
			if ($ad_orgresize) {
				if (strlen ( $org_screenshot_name ) > 0 and $org_screenshot_name != "none") {
					$img_info = getimagesize ( $org_screenshot );
					if ($img_info [0] > $ad_orgwidth or $img_info [1] > $ad_orgheight) {
						dgImageCreate ( $org_screenshot, $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$org_screenshot_name", $ad_orgwidth, $ad_orgheight, $ad_thumbquality, "1" );
					} else {
						copy ( $org_screenshot, $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$org_screenshot_name" );
						chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals.'/'.$catid.'/'.$org_screenshot_name, 0644);
					}
				}
			}
		if (! $ad_orgresize) {
			if (strlen ( $org_screenshot ) > 0 and $org_screenshot != "none") {
				copy ( $org_screenshot, $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$org_screenshot_name" );
				chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals.'/'.$catid.'/'.$org_screenshot_name, 0644);
			}
		}
		//средний эскиз
		if ($imginfo [0] > $ad_maxwidth or $imginfo [1] > $ad_maxheight) {
			dgImageCreate ( $org_screenshot, $mainframe->getCfg ( 'absolute_path' ) . $ad_pathimages . "/$catid/$org_screenshot_name", $ad_maxwidth, $ad_maxheight, $ad_thumbquality, "1" );
		} else {
			copy ( $org_screenshot, $mainframe->getCfg ( 'absolute_path' ) . $ad_pathimages . "/$catid/$org_screenshot_name" );
			chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_pathimages.'/'.$catid.'/'.$org_screenshot_name, 0644);
		}
		//превьюшки
		if ($thumbcreation)
			dgImageCreate ( $org_screenshot, $mainframe->getCfg ( 'absolute_path' ) . $ad_paththumbs . "/$catid/$org_screenshot_name", $ad_thumbwidth, $ad_thumbheight, $ad_thumbquality, $ad_crsc );
            chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_paththumbs . '/'.$catid.'/'.$org_screenshot_name, 0644);
		$db = & JTDB::getDBO ();

		$imgdate = mktime ();
		$db->setQuery ( "SELECT ordering FROM #__true WHERE catid=$catid ORDER BY ordering DESC LIMIT 1" );
		$ordering1 = $db->loadResult ();
		$ordering = $ordering1 + 1;
		$db->setQuery ( "INSERT INTO #__true(id, catid, imgtitle, imgauthor, imgtext, imgdate, ordering, imgvotes, imgvotesum,
		published, imgfilename, imgthumbname, imgoriginalname, checked_out, owner, approved,
		field1, field2, field3, field4, field5, metadesc, metakey, tags)
		VALUES (NULL, '$catid', '$imgtitle', '$imgauthor', '$imgtext', '$imgdate', '$ordering', '0', '0', '1',
		'$org_screenshot_name', '$org_screenshot_name', '$org_screenshot_name', '0', '$my->id', 1,
		'$field1', '$field2', '$field3', '$field4', '$field5', '', '', '$tags')" );
		if (! $db->query ()) {
			echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
			exit ();
		}
		//пишем в счетчик
		$last_id = $db->insertid ();
		$db->setQuery ( "INSERT INTO #__true_count(id, imgid, count) VALUES (NULL, '$last_id', '0')" );
		$db->query ();
		///
		JTRedirect::_ ( TRUE_INDEX2.'&act=pictures' );
		break;

	case "batchuploadhandler" :
		$temp_dir = 'media';
		require_once (TRUE_ADMIN . "config.true.php");
		///
		$ad_paththumbs = $ad_path.'/thumbs';
       	$ad_pathimages = $ad_path.'/pictures';
       	$ad_pathoriginals = $ad_path.'/originals';
       	////
		require_once ($mainframe->getCfg ( 'absolute_path' ) . "/administrator/includes/pcl/pclzip.lib.php");
		//if ($zippack_type !== 'application/zip'){
		//JTRedirect::_( "TRUE_INDEX2.'&act=pictures", "FILE IS NOT A ZIP PACKAGE" );
		//} else {
		$zipfile = new PclZip ( $_FILES ['zippack'] ['tmp_name'] );
		$ziplist = $zipfile->listContent ();
		$zipfile->extract ( $p_path = $mainframe->getCfg ( 'absolute_path' ) . '/' . $temp_dir );
		for($i = 0; $i < sizeof ( $ziplist ); $i ++) {
			$origfilename = $ziplist [$i] ['filename'];
			$imagetype = array (1 => 'GIF', 2 => 'JPG', 3 => 'PNG' );
			$imginfo = getimagesize ( $mainframe->getCfg ( 'absolute_path' ) . "/$temp_dir/$origfilename" );
			if ($imginfo [0] = 0) {
				JTRedirect::_ ( TRUE_INDEX2.'&act=upload', _DG_FILENAME_BAD_UPLOAD );
				exit ();
			}			
			$imginfo [2] = $imagetype [$imginfo [2]];
			$compacttitle = strtolower ( str_replace ( ' ', '', $gentitle ) );
			$newfilename = dgImgId ( $catid, $imginfo [2] );
			if ($ad_orgresize) {
				$img_info = getimagesize ( $mainframe->getCfg ( 'absolute_path' ) . "/$temp_dir/$origfilename" );
				if ($img_info [0] > $ad_orgwidth || $img_info [1] > $origfilename) {
					dgImageCreate ( $mainframe->getCfg ( 'absolute_path' ) . "/$temp_dir/$origfilename", $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$newfilename", $ad_orgwidth, $ad_orgheight, $ad_thumbquality, "1" );
				} else {
					copy ( $mainframe->getCfg ( 'absolute_path' ) . "/$temp_dir/$origfilename", $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$newfilename" );
					chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . '/'.$catid.'/'.$newfilename, 0644);
				}
			}
			if (! $ad_orgresize) {
				copy ( $mainframe->getCfg ( 'absolute_path' ) . "/$temp_dir/$origfilename", $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$newfilename" );
				chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . '/'.$catid.'/'.$newfilename, 0644);
			}
			dgImageCreate ( $mainframe->getCfg ( 'absolute_path' ) . "/$temp_dir/$origfilename", $mainframe->getCfg ( 'absolute_path' ) . $ad_pathimages . "/$catid/$newfilename", $ad_maxwidth, $ad_maxheight, $ad_thumbquality, "1" );
			dgImageCreate ( $mainframe->getCfg ( 'absolute_path' ) . "/$temp_dir/$origfilename", $mainframe->getCfg ( 'absolute_path' ) . $ad_paththumbs . "/$catid/$newfilename", $ad_thumbwidth, $ad_thumbheight, $ad_thumbquality, $ad_crsc );
			chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_pathimages . '/'.$catid.'/'.$newfilename, 0644);
			chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_paththumbs . '/'.$catid.'/'.$newfilename, 0644);
			unlink ( $p_path = $mainframe->getCfg ( 'absolute_path' ) . "/$temp_dir/$origfilename" );

			$db = & JTDB::getDBO ();

			$batchtime = mktime ();
			$db->setQuery ( "select ordering from #__true where catid=$catid order by ordering desc limit 1" );
			$ordering1 = $db->loadResult ();
			$ordering = $ordering1 + 1;
			$db->setQuery ( "INSERT INTO #__true(id, catid, imgtitle, imgauthor, imgtext, imgdate, ordering, imgvotes, imgvotesum,
			published, imgfilename, imgthumbname, imgoriginalname, checked_out, owner, approved, field1,
			field2, field3, field4, field5, metadesc, metakey, tags)
			VALUES (NULL, '$catid', '$gentitle $i', '$photocred', '$gendesc', '$batchtime', '$ordering', '0', '0', '1',
			'$newfilename', '$newfilename', '$newfilename', '0', '$my->id', 1, '$field1', '$field2', '$field3',
			'$field4', '$field5', '', '', '$tags')" );
			if (! $db->query ()) {
				echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
				exit ();
			}
			//пишем в счетчик
			$last_id = $db->insertid ();
			$db->setQuery ( "INSERT INTO #__true_count(id, imgid, count) VALUES (NULL, '$last_id', '0')" );
			$db->query ();
		}
		$picsadded = count ( $ziplist );
		JTRedirect::_ ( TRUE_INDEX2.'&act=pictures', JText::_ ( 'TG_ADDED_IMAGES' ) . $picsadded );
		//}
		break;
	case "batchimporthandler" :
		$dir = $mainframe->getCfg ( 'absolute_path' ) . '/media';
		$filelist = array ();
		require_once (TRUE_ADMIN . "config.true.php");
		///
		$ad_paththumbs = $ad_path.'/thumbs';
       	$ad_pathimages = $ad_path.'/pictures';
       	$ad_pathoriginals = $ad_path.'/originals';
       	////
		require_once ($mainframe->getCfg ( 'absolute_path' ) . "/administrator/includes/pcl/pclzip.lib.php");
		if (class_exists ( "PclZip" )) {
			$directory_zip = opendir ( $dir );
			while ( $file_name = readdir ( $directory_zip ) ) {
				$ext = strtolower ( substr ( $file_name, - 4 ) );
				if ($ext == ".zip") {
					$archive = new PclZip ( $dir . "/$file_name" );
					if (@$archive->extract ( PCLZIP_OPT_PATH, $dir ) == true) {
						unlink ( $dir . "/$file_name" );
					}
				}
			}
			closedir ( $directory_zip );
		}
		$compacttitle = strtolower ( str_replace ( ' ', '', $gentitle ) );
		if ($directory_zip = opendir ( $dir )) {
			$i = 0;
			while ( $file = readdir ( $directory_zip ) ) {
				if ($file != "." && $file != ".." && (strcasecmp ( $file, "index.html" ) != 0)) {
					$i ++;
					$origfilename = $file;
					$imagetype = array (1 => 'GIF', 2 => 'JPG', 3 => 'PNG' );
					$imginfo = getimagesize ( $dir . "/$origfilename" );
					if ($imginfo [0] = 0) {
						JTRedirect::_ ( TRUE_INDEX2.'&act=upload', _DG_FILENAME_BAD_UPLOAD );
						exit ();
					}			
					$imginfo [2] = $imagetype [$imginfo [2]];
					$newfilename = dgImgId ( $catid, $imginfo [2] );
					if ($ad_orgresize) {
						$img_info = getimagesize ( $dir . "/$origfilename" );
						if ($img_info [0] > $ad_orgwidth or $img_info [1] > $origfilename) {
							dgImageCreate ( $dir . "/$origfilename", $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$newfilename", $ad_orgwidth, $ad_orgheight, $ad_thumbquality, "1" );
						} else {
							copy ( $dir . "/$origfilename", $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$newfilename" );
						    chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . '/'.$catid.'/'.$newfilename, 0644);
						}
					}
					if (! $ad_orgresize) {
						copy ( $dir . "/$origfilename", $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . "/$catid/$newfilename" );
					}
					dgImageCreate ( $dir . "/$origfilename", $mainframe->getCfg ( 'absolute_path' ) . $ad_pathimages . "/$catid/$newfilename", $ad_maxwidth, $ad_maxheight, $ad_thumbquality, "1" );
					dgImageCreate ( $dir . "/$origfilename", $mainframe->getCfg ( 'absolute_path' ) . $ad_paththumbs . "/$catid/$newfilename", $ad_thumbwidth, $ad_thumbheight, $ad_thumbquality, $ad_crsc );
					chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_pathimages . '/'.$catid.'/'.$newfilename, 0644);
					chmod($mainframe->getCfg ( 'absolute_path' ) . $ad_paththumbs . '/'.$catid.'/'.$newfilename, 0644);
					unlink ( $dir . "/$origfilename" );

					$db = & JTDB::getDBO ();

					$batchtime = mktime ();
					$db->setQuery ( "SELECT ordering FROM #__true WHERE catid=$catid ORDER BY ordering DESC LIMIT 1" );
					$ordering1 = $db->loadResult ();
					$ordering = $ordering1 + 1;
					$db->setQuery ( "INSERT INTO #__true(id, catid, imgtitle, imgauthor, imgtext, imgdate, ordering, imgvotes, imgvotesum,
					published, imgfilename, imgthumbname, imgoriginalname, checked_out, owner, approved, field1,
					field2, field3, field4, field5, metadesc, metakey, tags)
					VALUES (NULL, '$catid', '$gentitle $i', '$photocred', '$gendesc', '$batchtime', '$ordering', '0', '0', '1',
					'$newfilename', '$newfilename', '$newfilename', '0', '$my->id', 1, '$field1', '$field2', '$field3',
					'$field4', '$field5', '', '', '$tags')" );
					if (! $db->query ()) {
						echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
						exit ();
					}
					//пишем в счетчик
					$last_id = $db->insertid ();
					$db->setQuery ( "INSERT INTO #__true_count(id, imgid, count) VALUES (NULL, '$last_id', '0')" );
					$db->query ();
				}
			}
		}
		closedir ( $directory_zip );
		JTRedirect::_ ( TRUE_INDEX2.'&act=pictures' );
		break;
	case "settings" :
		showConfig ( $option );
		break;
	case "savesettings" :
		saveConfig ( $option, $ad_path, $ad_protect, $ad_thumbwidth, $ad_thumbheight,
		$ad_thumbquality, $ad_showdetail, $ad_showrating, $ad_showcomment, $ad_comtitle, $ad_showpanel, $ad_userpannel,
		$ad_special, $ad_crsc, $ad_rating, $ad_lastadd, $ad_owners, $ad_lastcomment, $ad_search, $ad_showsend2friend,
		$ad_picincat, $ad_showwatermark, $ad_catsperpage, $ad_showdownload, $ad_downpub, $ad_perpage, $ad_sortby,
		$ad_toplist, $ad_js_effect, $ad_lightbox_fa, $ad_showinformer, $ad_periods, $ad_approve, $ad_pathway,
		$ad_powered, $ad_maxuserimage, $ad_maxfilesize, $ad_maxwidth, $ad_maxheight, $ad_category, $ad_imgstyle,
		$ad_ncsc, $ad_showimgtext, $ad_showfimgdate, $ad_showimgcounter, $ad_showfrating, $ad_showres,
		$ad_showfimgsize, $ad_showimgauthor, $ad_cp, $ad_lightbox, $ad_orgresize, $ad_orgwidth, $ad_orgheight,
		$ad_cat_desc, $ad_field1, $ad_field2, $ad_field3, $ad_field4, $ad_field5, $ad_mini_to_js, $ad_status1,
		$ad_status2, $ad_status3, $ad_status4, $ad_status5, $ad_cat_img_detail, $ad_carusel, $ad_bbhtml, $ad_toggle );
		break;
	case "newcatg" :
		editCatg ( 0, $option );
		break;
	case "editcatg" :
		editCatg ( $cid [0], $option, $catid );
		break;
	case "showcatg" :
		viewCatg ( $option );
		break;
	case "savecatg" :
		saveCatg ( $option, $task );
		break;
	case "removecatg" :
		removeCatg ( $cid, $option );
		break;
	case "publishcatg" :
		publishCatg ( $cid, 1, $option );
		break;
	case "unpublishcatg" :
		publishCatg ( $cid, 0, $option );
		break;
	case "approvepic" :
		approvePicture ( $id, 1, $option );
		break;
	case "rejectpic" :
		approvePicture ( $id, 0, $option );
		break;
	case "orderup" :
		orderPic ( $id [0], 1, $option );
		break;
	case "orderdown" :
		orderPic ( $id [0], - 1, $option );
		break;
	case "saveorder" :
		saveOrder ( $id );
		break;
	case "cancelcatg" :
		cancelCatg ( $option );
		break;
	case "orderupcatg" :
		orderCatg ( $cid [0], - 1, $option );
		break;
	case "orderdowncatg" :
		orderCatg ( $cid [0], 1, $option );
		break;
	case "cancel" :
		JTRedirect::_ ( 'index2.php?option='.$option );
		break;
	default :
		showPictures ( $option );
		break;
}
// Функция показа картинок
function showPictures($option)
	{
		global $mainframe, $group;

		$db = & JTDB::getDBO ();

		$catid = $mainframe->getUserStateFromRequest ( "catid{$option}", 'catid', 0 );
		$search = $mainframe->getUserStateFromRequest ( "search{$option}", 'search', '' );
		$search = $db->getEscaped ( trim ( strtolower ( $search ) ) );
		$sort = $mainframe->getUserStateFromRequest ( "sort{$option}", 'sort', 0 );
		$sorder = $mainframe->getUserStateFromRequest ( "sorder{$option}", 'sorder', 0 );
		$limit = $mainframe->getUserStateFromRequest ( 'viewlistlimit', 'limit', 10 );
		$limitstart = $mainframe->getUserStateFromRequest ( "view{$option}limitstart", 'limitstart', 0 );
		$where = array ();
		if ($catid > 0) {
			$where [] = "catid='$catid'";
		}
		if ($sort == 1) {
			$where [] = "approved = 0";
		}
		if ($sort == 2) {
			$where [] = "approved = 1";
		}
		if ($sort == 3) {
			$where [] = "useruploaded = 1";
		}
		if ($sort == 4) {
			$where [] = "useruploaded = 0";
		}
		if ($sorder == 0) {
			$sortorder = "a.catid asc, a.ordering desc, imgdate desc, imgtitle asc";
		}
		if ($sorder == 1) {
			$sortorder = "a.catid asc, a.ordering asc, imgdate desc, imgtitle asc";
		}
		if ($search) {
			$where [] = "LOWER(imgtitle) LIKE '%$search%' OR lower(imgtext) LIKE '%$search%'";
			$group = "GROUP BY id";
		}
		$db->setQuery ( "SELECT count(*) FROM #__true AS a " . (count ( $where ) ? ' WHERE ' . implode ( ' AND ', $where ) : '') );
		$total = $db->loadResult ();
		echo $db->getErrorMsg ();
		if ($limit > $total) {
			$limitstart = 0;
		}
		$where [] = 'a.catid = cc.cid';
		$picincat = count ( $where ) ? ' where ' . implode ( ' and ', $where ) : '';
		$db->setQuery ( "SELECT a.*, cc.name AS category, tc.count AS imgcounter, u.username AS owner
		FROM #__true AS a, #__true_count AS tc, #__true_catg AS cc, #__users AS u $picincat
		AND a.id = tc.imgid AND a.owner = u.id $group
		ORDER BY $sortorder limit $limitstart, $limit" );
		$rows = $db->loadObjectList ();
		if ($db->getErrorNum ()) {
			echo $db->stderr ();
			return false;
		}
		$clist = ShowDropDownCategoryList ( $catid, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"' );
		$s_options [] = mosHTML::makeOption ( JText::_ ( 'TG_SHOW_ALL_PICT' ), 0 );
		$s_options [] = mosHTML::makeOption ( "1", JText::_ ( 'TG_NOT_APPROVED' ) );
		$s_options [] = mosHTML::makeOption ( "2", JText::_ ( 'TG_APPROVED' ) );
		$s_options [] = mosHTML::makeOption ( "3", JText::_ ( 'TG_USER_UPLOAD_PIC' ) );
		$s_options [] = mosHTML::makeOption ( "4", JText::_ ( 'TG_ADMIN_UPLOAD_PIC' ) );
		$slist = mosHTML::selectList ( $s_options, 'sort', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $sort );
		require_once ($mainframe->getCfg ( 'absolute_path' ) . "/administrator/includes/pageNavigation.php");
		$pageNav = new mosPageNav ( $total, $limitstart, $limit );
		HTML_true::showPictures ( $option, $rows, $clist, $slist, $search, $pageNav );
	}
// порядок картинок
function orderPic($uid, $inc, $option)
	{
		$db = & JTDB::getDBO ();

		$db->setQuery ( "SELECT catid FROM #__true WHERE id=$uid" );
		$piccatid = $db->loadResult ();
		$db->setQuery ( "SELECT ordering, id FROM #__true WHERE id=$uid" );
		$result = $db->query ();
		$id1 = mysql_result ( $result, 0, 'id' );
		$ordering1 = mysql_result ( $result, 0, 'ordering' );
		if ($inc == 1) {
			$db->setQuery ( "SELECT ordering, id FROM #__true WHERE catid=$piccatid and ordering > $ordering1 ORDER BY ordering LIMIT 1" );
		} else {
			$db->setQuery ( "SELECT ordering, id FROM #__true WHERE catid=$piccatid and ordering < $ordering1 ORDER BY ordering DESC LIMIT 1" );
		}
		$result = $db->query ();
		$ordering2 = mysql_result ( $result, 0, 'ordering' );
		$id2 = mysql_result ( $result, 0, 'id' );
		$db->setQuery ( "UPDATE #__true SET ordering=$ordering1 WHERE id=$id2" );
		$result = $db->query ();
		$db->setQuery ( "UPDATE #__true SET ordering=$ordering2 WHERE id=$id1" );
		$result = $db->query ();
		JTRedirect::_ ( TRUE_INDEX2 );
	}
// Функция сохранения порядка картинок
function saveOrder(&$cid)
	{
		$db = & JTDB::getDBO ();

		$total = count ( $cid );
		$order = josGetArrayInts ( 'order' );
		for($i = 0; $i < $total; $i ++) {
			$query = "UPDATE #__true SET ordering = " . ( int ) $order [$i] . " WHERE id = " . ( int ) $cid [$i];
			$db->setQuery ( $query );
			if (! $db->query ()) {
				echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
				exit ();
			}
			$row = new mostrue ( $db );
			$row->load ( $cid [$i] );
			$row->updateOrder ( ' ' );
		}
		JTRedirect::_ ( TRUE_INDEX2, JText::_ ( 'TG_ORDERING_OK' ) );
	}
//Функция удаления картинок
function removePicture($cid, $option)
	{

		global $mainframe, $ad_path;
		require_once (TRUE_ADMIN . "config.true.php");
		$db = & JTDB::getDBO ();

		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			echo "<script> alert('" . JText::_ ( 'TG_SELECT_ITEM_TO_DELETE' ) . "'); window.history.go(-1);</script>\n";
			exit ();
		}
		if (count ( $cid )) {
			for($i = 0; $i < count ( $cid ); $i ++) {
				$db->setQuery ( "SELECT id, imgfilename, imgthumbname, imgoriginalname, catid FROM #__true WHERE id = $cid[$i]" );
				if ($db->query ()) {
					$rows = $db->loadObjectList ();
					$row = $rows [0];
					$catid = $row->catid;
					$ad_paththumbs = $ad_path.'/thumbs/';
 					$ad_pathimages = $ad_path.'/pictures/';
  					$ad_pathoriginals = $ad_path.'/originals/';
					if (removeFile ( $row->imgfilename, $mainframe->getCfg ( 'absolute_path' ) . $ad_pathimages, $catid )) {
						if (removeFile ( $row->imgthumbname, $mainframe->getCfg ( 'absolute_path' ) . $ad_paththumbs, $catid )) {
							if (! removeFile ( $row->imgoriginalname, $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals, $catid )) {
							}
						} else {
							//die(JText::_('TG_NOT_DELETE_THMB_IMAGE_FILE);
						}
					} else {
						//die(JText::_('TG_FFFFFFF);
					}
				} else {
					echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
				}
			}
			$cids = implode ( ',', $cid );
			$db->setQuery ( "DELETE from #__true where id IN ($cids)" );
			if (! $db->query ()) {
				echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
			}
			$db->setQuery ( "DELETE from #__true_count where imgid IN ($cids)" );
			if (! $db->query ()) {
				echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
			}
		}
		$txtmsg = 'good';
		JTRedirect::_ ( "index2.php?option=$option", $ad_path );
	}
//Функция публикации картинок
function publishPicture($cid = null, $publish = 1, $option)
	{
		$db = & JTDB::getDBO ();

		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			$action = $publish ? 'publish' : 'unpublish';
			echo "<script> alert('" . JText::_ ( 'TG_SELECT_AN_ITEM' ) . " $action'); window.history.go(-1);</script>\n";
			exit ();
		}
		$cids = implode ( ',', $cid );
		$db->setQuery ( "UPDATE #__true SET published='$publish' WHERE id IN ($cids)" );
		if (! $db->query ()) {
			echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
			exit ();
		}
		JTRedirect::_ ( "index2.php?option=$option" );
	}
// Утверждение картинок
function approvePicture($cid = null, $approve = 1, $option)
	{
		$db = & JTDB::getDBO ();

		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			$action = $approve ? 'approve' : 'reject';
			echo "<script> alert('" . JText::_ ( 'TG_SELECT_AN_ITEM' ) . " $action'); window.history.go(-1);</script>\n";
			exit ();
		}
		$cids = implode ( ',', $cid );
		$db->setQuery ( "UPDATE #__true SET approved='$approve' WHERE id IN ($cids)" );
		if (! $db->query ()) {
			echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
			exit ();
		}
		JTRedirect::_ ( "index2.php?option=$option" );
	}
//Редактирование картинок
function editPicture($option, $uid)
	{
		global $mainframe, $ad_thumbwidth, $ad_thumbheight, $ad_imgstyle, $ad_path;
		$db = & JTDB::getDBO ();
       	$ad_paththumbs = $ad_path.'/thumbs';
       	$ad_pathimages = $ad_path.'/pictures';
       	$ad_pathoriginals = $ad_path.'/originals';
	    $abspath = $mainframe->getCfg( 'absolute_path' );
		require_once (TRUE_ADMIN . "config.true.php");
		$row = new mostrue ( $db );
		$row->load ( $uid );
		$clist = ShowDropDownCategoryListImg ( $row->catid, "catid", ' size="1"' );
		$imgFiles = mosReadDirectory ( "$abspath.$ad_pathimages" );
		$images = array (mosHTML::makeOption ( '', JText::_ ( 'TG_SELECT_MED_PIC' ) ) );
		foreach ( $imgFiles as $file ) {
			if (eregi ( "jpeg|gif|jpg|png", $file )) {
				$images [] = mosHTML::makeOption ( $file );
			}
		}

		$imagelist = mosHTML::selectList ( $images, 'imgfilename', "class=\"inputbox\" size=\"1\"" . " onchange=\"javascript:if (document.forms[0].imgfilename.options[selectedIndex].value!='') {document.imagelib3.src='..$ad_pathimages/' + document.forms[0].imgfilename.options[selectedIndex].value} else {document.imagelib3.src='../images/M_images/blank.png'}\"", 'value', 'text', $row->imgfilename );
		$thuFiles = mosReadDirectory ( "$abspath.$ad_paththumbs" );
		$thumbs = array (mosHTML::makeOption ( '', JText::_ ( 'TG_SELECT_THUMB_PIC' ) ) );
		foreach ( $thuFiles as $tfile ) {
			if (eregi ( "jpeg|gif|jpg|png", $tfile )) {
				$thumbs [] = mosHTML::makeOption ( $tfile );
			}
		}
		$thumblist = mosHTML::selectList ( $thumbs, 'imgthumbname', "class=\"inputbox\" size=\"1\"" . " onchange=\"javascript:if (document.forms[0].imgthumbname.options[selectedIndex].value!='') {document.imagelib2.src='..$ad_paththumbs/' + document.forms[0].imgthumbname.options[selectedIndex].value} else {document.imagelib2.src='../images/M_images/blank.png'}\"", 'value', 'text', $row->imgthumbname );
		$orgFiles = mosReadDirectory ( "$abspath.$ad_pathoriginals" );
		$originals = array (mosHTML::makeOption ( '', JText::_ ( 'TG_SELECT_ORG_PIC' ) ) );
		foreach ( $orgFiles as $ofile ) {
			if (eregi ( "jpeg|gif|jpg|png", $ofile )) {
				$originals [] = mosHTML::makeOption ( $ofile );
			}
		}
		$originallist = mosHTML::selectList ( $originals, 'imgoriginalname', "class=\"inputbox\" size=\"1\"" . " onchange=\"javascript:if (document.forms[0].imgoriginalname.options[selectedIndex].value!='') {document.imagelib.src='..$ad_pathoriginals/' + document.forms[0].imgoriginalname.options[selectedIndex].value} else {document.imagelib.src='../images/M_images/blank.png'}\"", 'value', 'text', $row->imgoriginalname );
		if (! $uid)
			$row->published = 0;
		HTML_true::editPicture ( $option, $row, $clist, $originallist, $imagelist, $thumblist,
		$ad_pathoriginals, $ad_pathimages, $ad_paththumbs, $ad_path, $ad_thumbwidth, $ad_thumbheight, $ad_imgstyle );
	}
//Сохранение картинок
function savePicture($option)
	{
		global $catid, $mainframe;
		$db = & JTDB::getDBO ();
       	require_once (TRUE_ADMIN . "config.true.php");
		$row = new mostrue ( $db );
		if (! $row->bind ( $_POST )) {
			echo "<script> alert('" . $row->getError () . "'); window.history.go(-1); </script>\n";
			exit ();
		}
		$row->imgdate = mktime ();
		$db->setQuery ( "SELECT ordering FROM #__true WHERE catid=$catid ORDER BY ordering DESC LIMIT 1" );
		$ordering1 = $db->loadResult ();
		$row->ordering = $ordering1 + 1;
		if (! $row->store ()) {
			echo "<script> alert('" . $row->getError () . "'); window.history.go(-1); </script>\n";
			exit ();
		}
		//перемещаем физически файлы
		$oldcatid = $_POST ['oldcatid'];
		$paththumbs = $ad_path.'/thumbs';
  		$pathimages = $ad_path.'/pictures';
  		$pathoriginals = $ad_path.'/originals';
		$orgimg1 = $mainframe->getCfg ( 'absolute_path' ) . '/'.$pathoriginals.'/' . $oldcatid . "/" . $row->imgthumbname;
		$newimg1 = $mainframe->getCfg ( 'absolute_path' ) . '/'.$pathoriginals.'/' . $catid . "/" . $row->imgthumbname;
		$orgimg2 = $mainframe->getCfg ( 'absolute_path' ) . '/'.$pathimages.'/' . $oldcatid . "/" . $row->imgthumbname;
		$newimg2 = $mainframe->getCfg ( 'absolute_path' ) . '/'.$pathimages.'/' . $catid . "/" . $row->imgthumbname;
		$orgimg3 = $mainframe->getCfg ( 'absolute_path' ) . '/'.$ad_paththumbs.'/' . $oldcatid . "/" . $row->imgthumbname;
		$newimg3 = $mainframe->getCfg ( 'absolute_path' ) . '/'.$ad_paththumbs.'/'. $catid."/" . $row->imgthumbname;
		rename ( $orgimg1, $newimg1 );
		rename ( $orgimg2, $newimg2 );
		rename ( $orgimg3, $newimg3 );
		//
		$msg = 'good';
		JTRedirect::_ ( 'index2.php?option=' . $option . '&mosmsg=' . $msg );
	}
//Функция показа нормальной загрузки
function showUpload($option)
	{
		global $my, $mainframe;
		$db = & JTDB::getDBO ();

		require_once (TRUE_ADMIN . "config.true.php");
		$clist = ShowDropDownCategoryList ( 0, 'catid', ' class="inputbox" size="1" style="width:228;"' );
		echo "<script type=\"text/javascript\">\n";
		echo "function BatchFormCheck(theForm) {\n";
		echo "var form = document.adminForm;\n";
		echo "if (form.imgtitle.value == \"\") {\n";
		echo "alert('" . JText::_ ( 'TG_PIC_MUST_HAVE_TITLE' ) . "');\n";
		echo "return false;\n";
		echo "} else if (form.catid.value == \"0\") {\n";
		echo "alert('" . JText::_ ( 'TG_MUST_SELECT_CATEGORY' ) . "');\n";
		echo "return false;\n";
		echo "} else if (form.org_screenshot.value == \"\") {\n";
		echo "alert('" . JText::_ ( 'TG_MUST_HAVE_FNAME' ) . "');\n";
		echo "return false;\n";
		echo "} else {\n";
		echo "form.submit();\n";
		echo "dgLoading();\n";
		echo "}}</script>\n";
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
		echo "document.getElementById(\"status\").innerHTML = '<img src=\"" . $mainframe->getCfg ( 'live_site' ) . "/components/com_true/images/loading.gif\" border=\"0\" align=\"absmiddle\">'\n";
		echo "}}\n";
		echo "xmlhttp.send(null);\n";
		echo "}</script>\n";
		echo "<table class=\"adminheading\"><tr>\n";
		echo "<th class=\"mediamanager\">" . JText::_ ( 'TG_NORMAL_UPLOAD_TITLE' ) . "</th>\n";
		echo "</tr></table>\n";
		$imgauthor = $imgtext = $imgtitle = '';
		global $mainframe;
		?>
		<link rel="stylesheet" type="text/css" media="all"
		href="<?php
		echo $mainframe->getCfg ( 'live_site' );
		?>/includes/js/calendar/calendar-mos.css"
		title="green" />
		<script type="text/javascript"
		src="<?php
		echo $mainframe->getCfg ( 'live_site' );
		?>/includes/js/calendar/calendar.js"></script>
		<script type="text/javascript"
		src="<?php
		echo $mainframe->getCfg ( 'live_site' );
		?>/includes/js/calendar/lang/calendar-en.js"></script>
		<?php
		echo "<form action='index2.php?task=uploadhandler' method='post' name='adminForm' enctype='multipart/form-data' onSubmit=\"return BatchFormCheck(this)\">";
		echo "<table class=\"adminform\" width=\"100%\" border=\"0\">\n";
		echo "<tr><th><b>" . JText::_ ( 'TG_UPLOAD_NEW_PIC' ) . "</b></th></tr>\n";
		echo "<tr><td>\n<table width=\"100%\" border=\"0\">";
		echo "<tr><td width=\"20%\" valign=\"top\" align=\"right\"><b>" . JText::_ ( 'TG_PICTURE' ) . ":</b></td>\n";
		echo "<td><input class=\"inputbox\" size=\"34\" type=\"file\" name=\"org_screenshot\" /> " . mosToolTip ( JText::_ ( 'TG_MAX_FILESIZE_1' ) . ": <strong>" . ini_get ( 'upload_max_filesize' ) . "</strong>" . JText::_ ( 'TG_MAX_FILESIZE_2' ) ) . "";
		echo "</td></tr>\n";
		echo "<tr>";
		echo "<td align=\"right\"> <b>" . JText::_ ( 'TG_TITLE' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"imgtitle\" size=\"34\" maxlength=\"100\" value='" . htmlspecialchars ( $imgtitle, ENT_QUOTES ) . "' />";
		echo "</td></tr>\n";
        echo "<tr><td valign=\"top\" align=\"right\"><b>" . JText::_ ( 'TG_CATEGORY' ) . ":</b></td>\n<td>\n";
		echo $clist . '' . mosToolTip ( JText::_ ( 'TG_ALLOWED_CAT' ) );
		echo "</td></tr>\n";
		//
		if ($ad_field1) {
		echo "<tr>";
		echo "<td align=\"right\"> <b>" . JText::_ ( 'TG_FIELD1' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field1\" id=\"field1\" size=\"34\" maxlength=\"100\" value='' />";
		?><input type="reset" class="button" value="..."
		onClick="return showCalendar('field1', 'y-mm-dd');"><?php
		echo "</td></tr>\n";
		} else {}
		if ($ad_field2) {
		echo "<tr>";
		echo "<td align=\"right\"> <b>" . JText::_ ( 'TG_FIELD2' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field2\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		if ($ad_field3) {
		echo "<tr>";
		echo "<td align=\"right\"> <b>" . JText::_ ( 'TG_FIELD3' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field3\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		if ($ad_field4) {
		echo "<tr>";
		echo "<td align=\"right\"> <b>" . JText::_ ( 'TG_FIELD4' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field4\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		if ($ad_field3) {
		echo "<tr><td align=\"right\"> <b>" . JText::_ ( 'TG_FIELD5' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field5\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		//
		echo "<tr><td valign=\"top\" align=\"right\"><b>" . JText::_ ( 'TG_DESCRIPTION' ) . ":</b></td>\n";
		echo "<td>\n<textarea class=\"inputbox\" cols=\"25\" rows=\"7\" name=\"imgtext\">";
		echo htmlspecialchars ( $imgtext, ENT_QUOTES );
		echo "</textarea> " . mosToolTip ( JText::_ ( 'TG_OPT' ) ) . "</td></tr>\n";
		echo "<tr><td valign=\"top\" align=\"right\"><b>" . JText::_ ( 'TG_AUTHOR_OWNER' ) . ":</b></td>\n";
		echo "<td><input class=\"inputbox\" type=\"text\" name=\"imgauthor\" value='" . $imgauthor . "' size=\"34\" maxlength=\"100\" /> " . mosToolTip ( JText::_ ( 'TG_OPT' ) ) . "</td></tr>\n";
		echo "<tr><td align=\"right\"> <b>" . JText::_ ( 'TG_TAGS' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"tags\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		echo "<tr><td></td>";
		echo "<td>\n";
		echo "<input type=\"hidden\" name=\"option\" value='$option' />";
		echo "<input type=\"hidden\" name=\"approved\" value='1' />";
		echo "<input type=\"hidden\" name=\"owner\" value='$my->username' />";
		echo "<input type=\"hidden\" name=\"screenshot\" value=\"ON\" checked />";
		echo "<input type=\"hidden\" name=\"thumbcreation\" value=\"ON\" checked /><br />";
		echo "<div id=\"status\"><input type=\"submit\" value=\"" . JText::_ ( 'TG_UPLOAD' ) . "\" class=\"button\" /></div>";
		echo "</td></tr></table></td></tr></table></form>\n";
	}
// Показ пакетной загрузки
function showBatchUpload($option)
	{
		global $mainframe;
		$db = & JTDB::getDBO ();
        require_once (TRUE_ADMIN . "config.true.php");
		?>
		<link rel="stylesheet" type="text/css" media="all"
		href="<?php
		echo $mainframe->getCfg ( 'live_site' );
		?>/includes/js/calendar/calendar-mos.css"
		title="green" />
		<script type="text/javascript"
		src="<?php
		echo $mainframe->getCfg ( 'live_site' );
		?>/includes/js/calendar/calendar.js"></script>
		<script type="text/javascript"
		src="<?php
		echo $mainframe->getCfg ( 'live_site' );
		?>/includes/js/calendar/lang/calendar-en.js"></script>
		<?php
		echo "<script type=\"text/javascript\">\n";
		echo "function BatchFormCheck(theForm) {\n";
		echo "if (theForm.zippack.value == '') {\n";
		echo "alert('" . JText::_ ( 'TG_ZIP_NOT_SELECTED' ) . "');\n";
		echo "return false;\n";
		echo "} else if (theForm.catid.value == '0') {\n";
		echo "alert('" . JText::_ ( 'TG_ONE_ERR' ) . "');\n";
		echo "return false;\n";
		echo "} else if (theForm.gentitle.value == '') {\n";
		echo "alert('" . JText::_ ( 'TG_TWO_ERR' ) . "');\n";
		echo "return false;\n";
		echo "} else {dgLoading();}}</script>\n";
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
		echo "document.getElementById(\"status\").innerHTML = '<img src=\"" . $mainframe->getCfg ( 'live_site' ) . "/components/com_true/images/loading.gif\" border=\"0\" align=\"absmiddle\">'\n";
		echo "}}xmlhttp.send(null);}</script>\n";
		echo "<table class=\"adminheading\"><tr>\n";
		echo "<th class=\"mediamanager\">" . JText::_ ( 'TG_BATCH_UPLOAD_TITLE' ) . "</th></tr></table>\n";
		echo '<form action="'.TRUE_INDEX2.'&task=batchuploadhandler" method="post" name="adminForm" enctype="multipart/form-data" onSubmit="return BatchFormCheck(this)">';
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"4\" cellspacing=\"2\" class=\"adminform\">";
		echo "<tr><th>" . JText::_ ( 'TG_UPLOAD_ZIP' ) . "</th></tr>\n";
		echo "<tr><td align=\"center\" valign=\"top\">";
		echo "<table border=\"0\">";
		echo "<tr>";
		echo "<td align=\"right\" width=\"20%\"><b>" . JText::_ ( 'TG_IMAGE_PACK_FIL' ) . "</b></td>";
		echo "<td><input type=\"file\" size=\"34\" name=\"zippack\"  />" . mosToolTip ( JText::_ ( 'TG_MAX_FILESIZE_1' ) . ": <strong>" . ini_get ( 'upload_max_filesize' ) . "</strong>" . JText::_ ( 'TG_MAX_FILESIZE_2' ) );
		echo "<input type=\"hidden\" name=\"option\" value='$option' /></td></tr>";
		echo "</td></tr><tr>";
		echo "<td align=\"right\"><b>" . JText::_ ( 'TG_GENERIC_TITLE' ) . ":</b></td><td><input type=\"text\" name=\"gentitle\" size=\"34\" maxlength=\"256\"> " . mosToolTip ( JText::_ ( 'TG_GENERIC_TITLE_BU_I' ) ) . "</td>";
		echo "</tr>";
		echo "<tr><td align=\"right\"><b>" . JText::_ ( 'TG_CAT_PHOTO_ASS' ) . ":</b></td>";
		echo "<td>";
		$catid = $mainframe->getUserStateFromRequest ( "catid{$option}", 'catid', 0 );
		$categories [] = mosHTML::makeOption ( '0', JText::_ ( 'TG_SELECT_CAT' ) );
		$db->setQuery ( "SELECT id AS value, title AS text FROM #__categories" . " WHERE section='com_true' ORDER BY ordering" );
		$categories = array_merge ( $categories, $db->loadObjectList () );
		$clist = mosHTML::selectList ( $categories, 'catid', 'class="inputbox" size="1" style="width:228;"', 'value', 'text', $catid );
		$clist = ShowDropDownCategoryList ( 0, 'catid', ' class="inputbox" size="1" style="width:228;"' );
		echo $clist . '' . mosToolTip ( JText::_ ( 'TG_ALLOWED_CAT' ) );

		//
		if ($ad_field1) {
		echo "<tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_FIELD1' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field1\" id=\"field1\" size=\"34\" maxlength=\"100\" value='' />";
		?><input type="reset" class="button" value="..."
		onClick="return showCalendar('field1', 'y-mm-dd');"><?php
		echo "</td></tr>\n";
		} else {}
		if ($ad_field2) {
		echo "<tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_FIELD2' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field2\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		if ($ad_field3) {
		echo "<tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_FIELD3' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field3\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		if ($ad_field4) {
		echo "<tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_FIELD4' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field4\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		if ($ad_field5) {
		echo "<tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_FIELD5' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field5\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		//
		echo "<tr>";
		echo "<td valign=\"top\"><b>" . JText::_ ( 'TG_GENERIC_DESC' ) . ":</b></td>";
		echo "<td><textarea class=\"inputbox\" cols=\"25\" rows=\"7\" name=\"gendesc\">";
		//echo htmlspecialchars($imgtext, ENT_QUOTES);
		echo "</textarea> " . mosToolTip ( JText::_ ( 'TG_OPT' ) ) . "</td></tr><tr>";
		echo "<td align=\"right\"><b>" . JText::_ ( 'TG_AUTHOR' ) . ":</b></td><td><input type=\"text\" name=\"photocred\" size=\"34\" maxlength=\"256\"> " . mosToolTip ( JText::_ ( 'TG_OPT' ) ) . "</td></tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_TAGS' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"tags\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		echo "<tr><td>&nbsp;</td>";
		echo "<td colspan=\"2\" align=\"center\">";
		echo "<div id=\"status\">";
		echo "<input type='submit' value='" . JText::_ ( 'TG_UPLOAD' ) . "' class=\"button\" /></div></td></tr></table></td></tr></table></form>";
	}
// Показ пакетного импорта
function showBatchImport($option)
	{
		global $mainframe;
		$db = & JTDB::getDBO ();
        require_once (TRUE_ADMIN . "config.true.php");
		echo "<script type=\"text/javascript\">\n";
		echo "function BatchFormCheck(theForm) {\n";
		echo "if (theForm.catid.value == '0') {\n";
		echo "alert('" . JText::_ ( 'TG_ONE_ERR' ) . "');\n";
		echo "return false;\n";
		echo "} else if (theForm.gentitle.value == '') {\n";
		echo "alert('" . JText::_ ( 'TG_TWO_ERR' ) . "');\n";
		echo "return false;\n";
		echo "} else {dgLoading();}}</script>\n";
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
		echo "document.getElementById(\"status\").innerHTML = '<img src=\"" . $mainframe->getCfg ( 'live_site' ) . "/components/com_true/images/loading.gif\" border=\"0\" align=\"absmiddle\">'\n";
		echo "}}xmlhttp.send(null);}</script>\n";
		echo "<table class=\"adminheading\"><tr>\n";
		echo "<th class='mediamanager'>" . JText::_ ( 'TG_INSTALL_BI' ) . "</th></tr></table>\n";
		echo "<table class=\"adminform\" border=\"0\"><tr><th>" . JText::_ ( 'TG_IMPORT_ZIP' ) . "</th></tr></table>\n";
		echo "<form action='index2.php?task=batchimporthandler' method='post' name='adminForm' enctype='multipart/form-data' onSubmit=\"return BatchFormCheck(this)\">";
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"4\" cellspacing=\"2\" class=\"adminform\">";
		echo "<tr align=\"center\" valign=\"middle\"><td align=\"center\" valign=\"top\">";
		echo "<input type=\"hidden\" name=\"option\" value='$option' />";
		echo "<table border=\"0\" width=\"100%\">";
		echo "<tr><td align=\"right\"><strong>" . JText::_ ( 'TG_GENERIC_TITLE' ) . ":</strong></td>";
		echo "<td><input type=\"text\" name=\"gentitle\" size=\"34\" maxlength=\"256\" /> " . mosToolTip ( JText::_ ( 'TG_GENERIC_TITLE_BI_I' ) ) . "</td>";
		echo "</tr>";
		echo "<tr><td width=\"20%\" align=\"right\"><strong>" . JText::_ ( 'TG_CAT_PHOTO_ASS' ) . ":</strong></td><td>";
		$catid = $mainframe->getUserStateFromRequest ( "catid{$option}", 'catid', 0 );
		$categories [] = mosHTML::makeOption ( '0', JText::_ ( 'TG_SELECT_CAT' ) );
		$db->setQuery ( "SELECT id AS value, title AS text FROM #__categories" . "\nWHERE section='com_true' ORDER BY ordering" );
		$categories = array_merge ( $categories, $db->loadObjectList () );
		$clist = mosHTML::selectList ( $categories, 'catid', 'class="inputbox" size="1" style="width:228;"', 'value', 'text', $catid );
		$clist = ShowDropDownCategoryList ( 0, 'catid', ' class="inputbox" size="1" style="width:228;"' );
		echo $clist . '' . mosToolTip ( JText::_ ( 'TG_ALLOWED_CAT' ) ) . "</td></tr>";
				//
		if ($ad_field1) {
		echo "<tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_FIELD1' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field1\" id=\"field1\" size=\"34\" maxlength=\"100\" value='' />";
		?><input type="reset" class="button" value="..."
		onClick="return showCalendar('field1', 'y-mm-dd');"><?php
		echo "</td></tr>\n";
		} else {}
		if ($ad_field2) {
		echo "<tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_FIELD2' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field2\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		if ($ad_field3) {
		echo "<tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_FIELD3' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field3\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		if ($ad_field4) {
		echo "<tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_FIELD4' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field4\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		if ($ad_field5) {
		echo "<tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_FIELD5' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"field5\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		} else {}
		//
		echo "<tr><td align='right'><b>" . JText::_ ( 'TG_GENERIC_DESC' ) . ":</b></td>";
		echo "<td><textarea class='inputbox' cols='25' rows='5' name='gendesc'>";
		//echo htmlspecialchars($imgtext, ENT_QUOTES);
		echo "</textarea> " . mosToolTip ( JText::_ ( 'TG_OPT' ) ) . "</td></tr><tr>";
		echo "<td align='right'><b>" . JText::_ ( 'TG_AUTHOR' ) . ":</b></td><td><input type=\"text\" name=\"photocred\" size=\"34\" maxlength=\"256\"> " . mosToolTip ( JText::_ ( 'TG_OPT' ) ) . "</td></tr>";
		echo "<td  align=\"right\"><b>" . JText::_ ( 'TG_TAGS' ) . ":</b></td>\n";
		echo "<td>\n<input class=\"inputbox\" type=\"text\" name=\"tags\" size=\"34\" maxlength=\"100\" value='' />";
		echo "</td></tr>\n";
		echo "<tr><td></td>";
		echo "<td colspan='2' align='center'><br><div id='status'><input type='submit' value='" . JText::_ ( 'TG_ZIP_IMPORT' ) . "' class='button' /></div></td></form></tr></table></td></tr></table>";
	}
// Настройки
function showConfig($option)
	{
		global $mainframe, $tgver;
		$tabs = new mosTabs(0);
		require (TRUE_ADMIN . "config.true.php");
		$arr_ad_category = explode ( ",", $ad_category );
		$clist = testCat ( $arr_ad_category, "ad_category[]", $extras = "multiple  size=\"6\"", $levellimit = "4" );
		echo "<script type=\"text/javascript\">
		function submitbutton(pressbutton) {\n
		var form = document.adminForm;\n
		if (pressbutton == 'cancel') { submitform( pressbutton );return;}\n
		if (form.ad_path.value == \"\"){alert( JText::_('TG_FIVE_ERR );\n
		} else {submitform( pressbutton );}}</script>\n";
		echo "<form action=\"index2.php\" method=\"post\" name=\"adminForm\">\n";
		echo "<script src=\"includes/js/overlib_mini.js\" type=\"text/javascript\"></script>\n";
		echo "<table class=\"adminheading\" border=\"0\"><tr>\n";
		echo "<th class=\"config\">" . JText::_ ( 'TG_CONFIG_true' ) . "</th></tr></table>\n";
		$yesno [] = mosHTML::makeOption ( '0', JText::_ ( 'TG_NO' ) );
		$yesno [] = mosHTML::makeOption ( '1', JText::_ ( 'TG_YES' ) );
		if ($ad_protect) {
			dgProtect ( $ad_path."/originals" );
		} else {
			dgUnprotect ( $ad_path."/originals" );
		}
		if (file_exists ( $mainframe->getCfg ( 'absolute_path' ) . $ad_path."/originals" . "/.htaccess" )) {
			$img = "<span onmouseover=\"return overlib('" . JText::_ ( 'TG_PROTECT_YES' ) . "');\" onmouseout=\"return nd();\">";
			$img .= "<img src=\"../components/com_true/images/lock.png\" /></span>";
		} else {
			$img = "<span onmouseover=\"return overlib('" . JText::_ ( 'TG_PROTECT_NO' ) . "');\" onmouseout=\"return nd();\">";
			$img .= "<img src=\"../components/com_true/images/lock_open.png\" /></span>";
		}
		$tabs->startPane ( "settings" );
		//Вкладка  "Директории"JText::_('TG_CNF_HOST
			$tabs->startTab ( JText::_ ( 'TG_DIRS' ), "page2" );
			echo "<table class=\"adminform\"><tr><th colspan=\"5\">" . JText::_ ( 'TG_DIRS2' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_PARENT_CAT' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo '<input type="text" name="ad_path" value="'.$ad_path.'" size="20"></td>';
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_PARENT_CAT' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_ORG_PIC_PATH' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">". $mainframe->getCfg ( 'live_site' ).$ad_path."/originals</td>\n";
			echo "<td width=\"3%\" align=\"left\">\n";
			writDir ( $ad_path."/originals" );
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_ORG_PIC_PATH_I' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_MED_PIC_PATH' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">".$mainframe->getCfg ( 'live_site' ).$ad_path."/pictures</td>\n";
			echo "<td width=\"3%\" align=\"left\">\n";
			writDir ( $ad_path."/pictures" );
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_MED_PIC_PATH_I' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_THUMB_PIC_PATH' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">".$mainframe->getCfg ( 'live_site' ).$ad_path."/thumbs</td>\n";
			echo "<td width=\"3%\" align=\"left\">\n";
			writDir ( $ad_path."/thumbs" );
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_THUMB_PIC_PATH_I' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr>\n";
			/*echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_PROTECT_ORIGINALS' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_protect = mosHTML::selectList ( $yesno, 'ad_protect', 'class=\"inputbox\"', 'value', 'text', $ad_protect );
			echo $yn_ad_protect;
			echo "</td><td width=\"3%\" align=\"left\">" . $img . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_PROTECT_ORIGINALS_I' ) ) . "</td><td></td></tr>\n";*/
			echo "</table>\n";
			$tabs->endTab ();
		//Вкладка  "Обработка"
			$tabs->startTab ( JText::_ ( 'TG_PROCESSING' ), "page3" );
			echo "<table class=\"adminform\"><tr><th colspan=\"4\">" . JText::_ ( 'TG_PROCESSING2' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_THUMBNAIL_CREATOR' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			if (function_exists ( "gd_info" )) {
				$info = gd_info ();
				$version = $info ["GD Version"];
				if (strpos ( $version, '2.' ) !== false) {
					$thumbcreator = 'gd2';
				} else {
					$thumbcreator = 'gd1';
				}
			} else {
				echo "<strong><font color='#FF0000' style='text-decoration:blink'>" . JText::_ ( 'TG_GDIMAGE_NOT' ) . "</font></strong>";
			}
			if ($thumbcreator)
				echo "<strong>GD Version: <font color='#008000'>" . $version . "</font></strong></td>";
			echo "<td align=\"left\" valign=\"top\"></font>" . mosToolTip ( JText::_ ( 'TG_CHOOS_IMA_PEOCES_TH' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_ALLOW_ORGRESIZE' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_orgresize = mosHTML::selectList ( $yesno, 'ad_orgresize', 'class=\"inputbox\"', 'value', 'text', $ad_orgresize );
			echo $yn_ad_orgresize;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_ALLOW_ORGRESIZE_I' ) ) . "</td><td></td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_ORGWIDTH' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_orgwidth\" value=" . $ad_orgwidth . " size=\"5\">&nbsp;<b>px</b></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_ORGWIDTH_I' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
			echo "</tr><tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_ORGHIGHT' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_orgheight\" value=" . $ad_orgheight . " size=\"5\">&nbsp;<b>px</b></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_ORGHIGHT_I' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_MAX_WIDTH' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_maxwidth\" value=" . $ad_maxwidth . " size=\"5\">&nbsp;<b>px</b></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_MAX_WIDTH_IMAGE' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_MAX_HIGHT' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_maxheight\" value=" . $ad_maxheight . " size=\"5\">&nbsp;<b>px</b></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_MAX_HIGHT_IMAGE' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_THUMBNAIL_WIDTH' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_thumbwidth\" value=" . $ad_thumbwidth . " size=\"5\">&nbsp;<b>px</b></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_WIDTH_THUMBNAIL_CREAT' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_THUMBNAIL_HEIGHT' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_thumbheight\" value=" . $ad_thumbheight . " size=\"5\">&nbsp;<b>px</b></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_HEIGHT_THUMBNAIL_CREAT' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SKETCHING_METHOD' ) . "</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$crsc [] = mosHTML::makeOption ( '0', JText::_ ( 'TG_CROP_METHOD' ) );
			$crsc [] = mosHTML::makeOption ( '1', JText::_ ( 'TG_SCALE_METHOD' ) );
			$cs_ad_crsc = mosHTML::selectList ( $crsc, 'ad_crsc', 'class="inputbox"', 'value', 'text', $ad_crsc );
			echo $cs_ad_crsc;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SKETCHING_METHOD_I' ) ) . "</td><td></td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_THUMBNAIL_QUALIT' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_thumbquality\" value=" . $ad_thumbquality . " size=\"5\">&nbsp;<b>%</b></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_THUMBNAIL_QUALIT_I' ) ) . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">&nbsp;</td></tr></table>\n";
			$tabs->endTab ();
		//Вкладка  "Вид"
			$tabs->startTab ( JText::_ ( 'TG_VIEW' ), "page4" );
			echo "<table class=\"adminform\"><tr><th colspan=\"3\">" . JText::_ ( 'TG_VIEW_DETAILS' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_DETAILS' ) . "</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$yn_ad_showdetail = mosHTML::selectList ( $yesno, 'ad_showdetail', 'class="inputbox"', 'value', 'text', $ad_showdetail );
			echo $yn_ad_showdetail;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_DETAILS_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_DESCRIPTION' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_showimgtext = mosHTML::selectList ( $yesno, 'ad_showimgtext', 'class=\"inputbox\"', 'value', 'text', $ad_showimgtext );
			echo $yn_ad_showimgtext;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_DESCRIPTION_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_DATE_ADD' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_showfimgdate = mosHTML::selectList ( $yesno, 'ad_showfimgdate', 'class=\"inputbox\"', 'value', 'text', $ad_showfimgdate );
			echo $yn_ad_showfimgdate;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_DATE_ADD_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_HITS' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_showimgcounter = mosHTML::selectList ( $yesno, 'ad_showimgcounter', 'class=\"inputbox\"', 'value', 'text', $ad_showimgcounter );
			echo $yn_ad_showimgcounter;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_HITS_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_RATING' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_showfrating = mosHTML::selectList ( $yesno, 'ad_showfrating', 'class=\"inputbox\"', 'value', 'text', $ad_showfrating );
			echo $yn_ad_showfrating;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_RATING_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SIZE' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_showres = mosHTML::selectList ( $yesno, 'ad_showres', 'class=\"inputbox\"', 'value', 'text', $ad_showres );
			echo $yn_ad_showres;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SIZE_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_FILESIZE' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_showfimgsize = mosHTML::selectList ( $yesno, 'ad_showfimgsize', 'class=\"inputbox\"', 'value', 'text', $ad_showfimgsize );
			echo $yn_ad_showfimgsize;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_FILESIZE_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_AUTHOR_OWNER' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_showimgauthor = mosHTML::selectList ( $yesno, 'ad_showimgauthor', 'class=\"inputbox\"', 'value', 'text', $ad_showimgauthor );
			echo $yn_ad_showimgauthor;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_AUTHOR_OWNER_I' ) ) . "</td></tr>\n";
			//5 дополнительных полей описания изображения
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_FIELD1' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_field1 = mosHTML::selectList ( $yesno, 'ad_field1', 'class=\"inputbox\"', 'value', 'text', $ad_field1 );
			echo $yn_ad_field1;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_FIELD1_1' ) ) . "</td></tr>\n";
			//
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_FIELD2' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_field2 = mosHTML::selectList ( $yesno, 'ad_field2', 'class=\"inputbox\"', 'value', 'text', $ad_field2 );
			echo $yn_ad_field2;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_FIELD1_2' ) ) . "</td></tr>\n";
			//
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_FIELD3' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_field3 = mosHTML::selectList ( $yesno, 'ad_field3', 'class=\"inputbox\"', 'value', 'text', $ad_field3 );
			echo $yn_ad_field3;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_FIELD1_3' ) ) . "</td></tr>\n";
			//
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_FIELD4' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_field4 = mosHTML::selectList ( $yesno, 'ad_field4', 'class=\"inputbox\"', 'value', 'text', $ad_field4 );
			echo $yn_ad_field4;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_FIELD1_4' ) ) . "</td></tr>\n";
			//
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_FIELD5' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			$yn_ad_field5 = mosHTML::selectList ( $yesno, 'ad_field5', 'class=\"inputbox\"', 'value', 'text', $ad_field5 );
			echo $yn_ad_field5;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_FIELD1_5' ) ) . "</td></tr>\n";
			/////////
			echo "<tr><th colspan=\"3\">" . JText::_ ( 'TG_VIEW_NAV_PANEL' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_PANEL' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_showpanel = mosHTML::selectList ( $yesno, 'ad_showpanel', 'class="inputbox"', 'value', 'text', $ad_showpanel );
			echo $yn_ad_showpanel;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_PANEL_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_USERPANEL' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_userpannel = mosHTML::selectList ( $yesno, 'ad_userpannel', 'class="inputbox"', 'value', 'text', $ad_userpannel );
			echo $yn_ad_userpannel;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_USERPANEL_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_SPECIALPANEL' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_special = mosHTML::selectList ( $yesno, 'ad_special', 'class="inputbox"', 'value', 'text', $ad_special );
			echo $yn_ad_special;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_SPECIALPANEL_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_RATINGPANEL' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_rating = mosHTML::selectList ( $yesno, 'ad_rating', 'class="inputbox"', 'value', 'text', $ad_rating );
			echo $yn_ad_rating;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_RATINGPANEL_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_NEWPANEL' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_lastadd = mosHTML::selectList ( $yesno, 'ad_lastadd', 'class="inputbox"', 'value', 'text', $ad_lastadd );
			echo $yn_ad_lastadd;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_NEWPANEL_I' ) ) . "</td></tr>\n";
			//добавляем показ авторов
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_OWNERS' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_owners = mosHTML::selectList ( $yesno, 'ad_owners', 'class="inputbox"', 'value', 'text', $ad_owners );
			echo $yn_ad_owners;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_OWNERS_I' ) ) . "</td></tr>\n";
			///
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_LASTCOMMENTPANEL' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_lastcomment = mosHTML::selectList ( $yesno, 'ad_lastcomment', 'class="inputbox"', 'value', 'text', $ad_lastcomment );
			echo $yn_ad_lastcomment;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_LASTCOMMENTPANEL_I' ) ) . "</td></tr>\n";
			echo "<tr><th colspan=\"3\">" . JText::_ ( 'TG_VIEW_OPTIONAL' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_TITLE_COM' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_comtitle = mosHTML::selectList ( $yesno, 'ad_comtitle', 'class="inputbox"', 'value', 'text', $ad_comtitle );
			echo $yn_ad_comtitle;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_TITLE_COM_I' ) ) . "</td></tr>\n";
			///Показывать ли описание категории в разделе мини эскизов
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_CAT_DESC' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_cat_desc = mosHTML::selectList ( $yesno, 'ad_cat_desc', 'class="inputbox"', 'value', 'text', $ad_cat_desc );
			echo $yn_ad_cat_desc;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_CAT_DESC_I' ) ) . "</td></tr>\n";
			///
			///Показывать подробности изображения в списке мини эскизов
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_CAT_IMG_DETAILS' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_cat_img_detail = mosHTML::selectList ( $yesno, 'ad_cat_img_detail', 'class="inputbox"', 'value', 'text', $ad_cat_img_detail );
			echo $yn_ad_cat_img_detail;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_CAT_IMG_DETAILS_I' ) ) . "</td></tr>\n";
			///
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_POWERED' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_powered = mosHTML::selectList ( $yesno, 'ad_powered', 'class="inputbox"', 'value', 'text', $ad_powered );
			echo $yn_ad_powered;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_POWERED_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_PICINCAT' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_picincat = mosHTML::selectList ( $yesno, 'ad_picincat', 'class="inputbox"', 'value', 'text', $ad_picincat );
			echo $yn_ad_picincat;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_PICINCAT_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_COLUMNS_IN_SUBCAT' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_ncsc\" value=\"" . $ad_ncsc . "\" size=\"5\"></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_COLUMNS_IN_SUBCAT_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\"   >\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_COLUMNS_IN_SUBCAT_TH' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_cp\" value=\"" . $ad_cp . "\" size=\"5\"></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_COLUMNS_IN_SUBCAT_TH_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_CATS_PERPAGE' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_catsperpage\" value=\"" . $ad_catsperpage . "\" size=\"5\"></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_CATS_PERPAGE_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_DISPLAY_PIC' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_perpage\" value=\"" . $ad_perpage . "\" size=\"5\"></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_DISPLAY_PIC_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SORTBY' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$sortby [] = mosHTML::makeOption ( 'ASC', JText::_ ( 'TG_SORTBYASC' ) );
			$sortby [] = mosHTML::makeOption ( 'DESC', JText::_ ( 'TG_SORTBYDESC' ) );
			$sb_ad_sortby = mosHTML::selectList ( $sortby, 'ad_sortby', 'class="inputbox"', 'value', 'text', $ad_sortby );
			echo $sb_ad_sortby;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SORTBY_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_DISPLAY_TOP' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_toplist\" value=\"" . $ad_toplist . "\" size=\"5\"></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_DISPLAY_TOP_I' ) ) . "</td></tr>\n</table>\n";
			$tabs->endTab ();
		//Вкладка "Загрузка"
			$tabs->startTab ( JText::_ ( 'TG_UPBYUSER' ), "page5" );
			echo "<table class=\"adminform\"><tr><th colspan=\"3\">" . JText::_ ( 'TG_USER_UPLOAD_SETTING' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_ADMIN_APPRO_NEEDED' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_approve = mosHTML::selectList ( $yesno, 'ad_approve', 'class="inputbox"', 'value', 'text', $ad_approve );
			echo $yn_ad_approve;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_USER_UPLOAD_NEDD_APPROVAL' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_MAX_NR_IMAGES' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_maxuserimage\" value=\"" . $ad_maxuserimage . "\" size=\"5\"></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_MAX_ALLOWED_PICS' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_MAX_SIZE_IMAGE' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">\n";
			echo "<input type=\"text\" name=\"ad_maxfilesize\" value=\"" . $ad_maxfilesize . "\" size=\"5\"></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_MAX_ALLOWED_FILESIZE' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_ALLOWED_CAT' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">" . $clist . "</td>\n";
			echo "<td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_ALLOWED_CAT_I' ) ) . "</td></tr>\n";
			//5 статусов юзверей по кол-ву загруженных изображений
			echo "<tr><th colspan=\"3\">" . JText::_ ( 'TG_USER_STATUS' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_STATUS1' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\"><input type=\"text\" name=\"ad_status1\" value=\"" . $ad_status1 . "\" size=\"5\">\n";
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_STATUS_I' ) ) . "</td></tr>\n";
			//
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_STATUS2' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\"><input type=\"text\" name=\"ad_status2\" value=\"" . $ad_status2 . "\" size=\"5\">\n";
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_STATUS_I' ) ) . "</td></tr>\n";
			//
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_STATUS3' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\"><input type=\"text\" name=\"ad_status3\" value=\"" . $ad_status3 . "\" size=\"5\">\n";
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_STATUS_I' ) ) . "</td></tr>\n";
			//
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_STATUS4' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\"><input type=\"text\" name=\"ad_status4\" value=\"" . $ad_status4 . "\" size=\"5\">\n";
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_STATUS_I' ) ) . "</td></tr>\n";
			//
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_STATUS5' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\"><input type=\"text\" name=\"ad_status5\" value=\"" . $ad_status5 . "\" size=\"5\">\n";
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_STATUS_I' ) ) . "</td></tr>\n";
			////////////////////////
			echo "</table>";
			$tabs->endTab ();
		//Вкладка "Рейтинг"
			$tabs->startTab ( JText::_ ( 'TG_RATE' ), "page6" );
			echo "<table class=\"adminform\"><tr><th colspan=\"3\">" . JText::_ ( 'TG_RATE_SETTING' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_ALLOW_RATING' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$yn_ad_showrating = mosHTML::selectList ( $yesno, 'ad_showrating', 'class="inputbox"', 'value', 'text', $ad_showrating );
			echo $yn_ad_showrating;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_ALLOW_RATING_I' ) ) . "</td></tr></table>";
			$tabs->endTab ();
		//Вкладка "Комментарии" - вырезана ибо нефиг
		//Вкладка "Опции"
			$tabs->startTab ( JText::_ ( 'TG_OPTION' ), "page7" );
			echo "<table class=\"adminform\"><tr><th colspan=\"3\">" . JText::_ ( 'TG_OPTION2' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_ALLOW_COMM' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_showcomment = mosHTML::selectList ( $yesno, 'ad_showcomment', 'class="inputbox"', 'value', 'text', $ad_showcomment );
			echo $yn_ad_showcomment;
			$comments = $mainframe->getCfg ( 'absolute_path' ) . '/components/com_jcomments/jcomments.php';
			if (file_exists ( $comments )) {
				echo JText::_ ( 'TG_ALLOW_COMM_JC' );
			} else {
				echo JText::_ ( 'TG_ALLOW_COMM_NO_JC' );
			}
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_ALLOW_COMM_I' ) ) . "</td></tr>\n";
			/*добавляем выбор типа JS эффекта
			# thickbox == 1
			# highslide == 2
			*/
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_JS_TYPE' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$js_effect [] = mosHTML::makeOption ( '1', JText::_ ( 'TG_JS_SL' ) );
			$js_effect [] = mosHTML::makeOption ( '2', JText::_ ( 'TG_JS_HJ' ) );
			$sb_ad_js_effect = mosHTML::selectList ( $js_effect, 'ad_js_effect', 'class="inputbox"', 'value', 'text', $ad_js_effect );
			echo $sb_ad_js_effect;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_JS_TYPE_I' ) ) . "</td></tr>\n";
			////
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_USE_LIGHTBOX' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$yn_ad_lightbox = mosHTML::selectList ( $yesno, 'ad_lightbox', 'class="inputbox"', 'value', 'text', $ad_lightbox );
			echo $yn_ad_lightbox;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_USE_LIGHTBOX_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_LIGHTBOX_FOR_ALL' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$yn_ad_lightbox_fa = mosHTML::selectList ( $yesno, 'ad_lightbox_fa', 'class="inputbox"', 'value', 'text', $ad_lightbox_fa );
			echo $yn_ad_lightbox_fa;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_LIGHTBOX_FOR_ALL_I' ) ) . "</td></tr>\n";
			/// Развертка из мини эскиза
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_MINI_TO_JS' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$yn_mini_to_js = mosHTML::selectList ( $yesno, 'ad_mini_to_js', 'class="inputbox"', 'value', 'text', $ad_mini_to_js );
			echo $yn_mini_to_js;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_MINI_TO_JS_I' ) ) . "</td></tr>\n";
			//Карусель
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_CARUSEL' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$yn_ad_carusel = mosHTML::selectList ( $yesno, 'ad_carusel', 'class="inputbox"', 'value', 'text', $ad_carusel );
			echo $yn_ad_carusel;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_CARUSEL_I' ) ) . "</td></tr>\n";
			//Сворачинание
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_TOGGLE' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$yn_ad_toggle = mosHTML::selectList ( $yesno, 'ad_toggle', 'class="inputbox"', 'value', 'text', $ad_toggle );
			echo $yn_ad_toggle;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_TOGGLE_1' ) ) . "</td></tr>\n";
			//
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_USE_WATERMARK' ) . "</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$yn_ad_showwatermark = mosHTML::selectList ( $yesno, 'ad_showwatermark', 'class="inputbox"', 'value', 'text', $ad_showwatermark );
			echo $yn_ad_showwatermark;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_USE_WATERMARK_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_SEARCH' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_search = mosHTML::selectList ( $yesno, 'ad_search', 'class="inputbox"', 'value', 'text', $ad_search );
			echo $yn_ad_search;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_SEARCH_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_USE_PATHWAY' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_pathway = mosHTML::selectList ( $yesno, 'ad_pathway', 'class="inputbox"', 'value', 'text', $ad_pathway );
			echo $yn_ad_pathway;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_USE_PATHWAY_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_SEND2FRIEND' ) . "</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_showsend2friend = mosHTML::selectList ( $yesno, 'ad_showsend2friend', 'class="inputbox"', 'value', 'text', $ad_showsend2friend );
			echo $yn_ad_showsend2friend;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_SEND2FRIEND_I' ) ) . "</td></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_SHOW_INFORMER' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_showinformer = mosHTML::selectList ( $yesno, 'ad_showinformer', 'class="inputbox"', 'value', 'text', $ad_showinformer );
			echo $yn_ad_showinformer;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_SHOW_INFORMER_I' ) ) . "</td></tr>\n";
			// Коды для форума и сайта
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_BB_HTML' ) . ":</strong></td>\n";
			echo "<td align=\"left\" valign=\"top\">";
			$yn_ad_bbhtml = mosHTML::selectList ( $yesno, 'ad_bbhtml', 'class="inputbox"', 'value', 'text', $ad_bbhtml );
			echo $yn_ad_bbhtml;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_BB_HTML_I' ) ) . "</td></tr>\n";
			//
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\"><strong>" . JText::_ ( 'TG_LIST_OF_PERIODS' ) . ":</strong></td>\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">";
			$periods [] = mosHTML::makeOption ( '1', JText::_ ( 'TG_PS_SECOND' ) );
			$periods [] = mosHTML::makeOption ( '60', JText::_ ( 'TG_PS_MINUTE' ) );
			$periods [] = mosHTML::makeOption ( '3600', JText::_ ( 'TG_PS_HOUR' ) );
			$periods [] = mosHTML::makeOption ( '86400', JText::_ ( 'TG_PS_DAY' ) );
			$periods [] = mosHTML::makeOption ( '604800', JText::_ ( 'TG_PS_WEEK' ) );
			$periods [] = mosHTML::makeOption ( '2629744', JText::_ ( 'TG_PS_MONTH' ) );
			$periods [] = mosHTML::makeOption ( '31556926', JText::_ ( 'TG_PS_YEAR' ) );
			$ps_ad_periods = mosHTML::selectList ( $periods, 'ad_periods', 'class="inputbox"', 'value', 'text', $ad_periods );
			echo $ps_ad_periods;
			echo "</td><td align=\"left\" valign=\"top\">" . mosToolTip ( JText::_ ( 'TG_LIST_OF_PERIODS_I' ) ) . "</td></tr></table>\n";
			$tabs->endTab ();
		//Вкладка "Язык"
			$tabs->startTab ( JText::_ ( 'TG_LANG' ), "page8" );
			echo showLanguage ( $option );
			$tabs->endTab ();
		//Вкладка "Версия"
			$tabs->startTab ( JText::_ ( 'TG_VERSION' ), "page8" );
			echo "<table class=\"adminform\"><tr><th colspan=\"3\">" . JText::_ ( 'TG_VERSION_INFO1' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"15%\" align=\"left\" valign=\"top\">\n";
			echo "<a href=\"http://true.palpalych.ru\" target=\"_blank\"><img src=\"administrator/components/com_true/images/true.jpg\"
		    alt=\"\" title=\"True Gallery Box\" width=\"401\" height=\"200\" align=\"middle\" border=\"0\" hspace=\"5\" vspace=\"5\" /></a></td>\n";
			echo "<td width=\"25%\" align=\"left\" valign=\"top\">";
			echo "<p><strong><font color='#A3A3A3'>" . JText::_ ( 'TG_VERSION_INFO' ) . "</font> <font color='#88C44D'>" . $tgver . "</font></strong></p>";
			echo "<ul>";
			echo "<li><a href='http://true.palpalych.ru'>" . JText::_ ( 'TG_CHECK_VERSION' ) . "</a></li>";
			echo "<li><a href='http://true.palpalych.ru/'>" . JText::_ ( 'TG_CHECK_MODS_AND_PGS' ) . "</a></li>";
			echo "</ul>";
			echo "<td align=\"left\" valign=\"top\"></td></tr></table>";
			$tabs->endTab ();
			//Вкладка  "Настройки хостинга"
			$tabs->startTab ( JText::_ ( 'TG_CNF_HOST' ), "page1" );
			echo "<table class=\"adminform\"><tr><th colspan=\"5\">" . JText::_ ( 'TG_CNF_HOST' ) . "</th></tr>\n";
			echo "<tr align=\"left\" valign=\"middle\">\n";
			echo "<td width=\"20%\" align=\"left\" valign=\"top\">\n";
			echo '<div style="margin: 8px;color:red;">' . JText::_ ( 'TG_PER_MEM' ) . '  = ' . ini_get ( 'memory_limit' ) . '</div>';
			echo '<div style="margin: 8px;color:green;">' . JText::_ ( 'TG_PER_MEM_OBJ' ) . '</div>';
			echo '<div style="margin: 8px;color:red;">' . JText::_ ( 'TG_PER_MSI' ) . ' = ' . ini_get ( 'upload_max_filesize' ) . '</div>';
			echo '<div style="margin: 8px;color:green;">' . JText::_ ( 'TG_PER_MSI_OBJ' ) . '</div>';
			echo '<div style="margin: 8px;color:red;">' . JText::_ ( 'TG_PER_MTI' ) . ' = ' . ini_get ( 'max_execution_time' ) . '</div>';
			echo '<div style="margin: 8px;color:green;">' . JText::_ ( 'TG_PER_MTI_OBJ' ) . '</div>';
			if (ini_get ( 'max_execution_time' ) < 60) {
				echo '<font color="red">' . JText::_ ( 'TG_PER_MTI_UP' ) . '</font><br/>';
			}
			echo "</td></tr></table>\n";
			$tabs->endTab ();
			$tabs->endPane ();
			echo "<input type='hidden' name='option' value='$option' />";
			echo "<input type='hidden' name='act' value='' />\n";
			echo "</form>\n";
	}
// Функция созоанения натсроек
function saveConfig($option, $ad_path, $ad_protect, $ad_thumbwidth, $ad_thumbheight,
	$ad_thumbquality, $ad_showdetail, $ad_showrating, $ad_showcomment, $ad_comtitle, $ad_showpanel,
	$ad_userpannel, $ad_special, $ad_crsc, $ad_rating, $ad_lastadd, $ad_owners, $ad_lastcomment, $ad_search,
	$ad_showsend2friend, $ad_picincat, $ad_showwatermark, $ad_catsperpage, $ad_showdownload, $ad_downpub, $ad_perpage,
	$ad_sortby, $ad_toplist, $ad_js_effect, $ad_lightbox_fa, $ad_showinformer, $ad_periods, $ad_approve, $ad_pathway,
	$ad_powered, $ad_maxuserimage, $ad_maxfilesize, $ad_maxwidth, $ad_maxheight, $ad_category, $ad_imgstyle, $ad_ncsc,
	$ad_showimgtext, $ad_showfimgdate, $ad_showimgcounter, $ad_showfrating, $ad_showres, $ad_showfimgsize, $ad_showimgauthor,
	$ad_cp, $ad_lightbox, $ad_orgresize, $ad_orgwidth, $ad_orgheight, $ad_cat_desc, $ad_field1, $ad_field2, $ad_field3,
	$ad_field4, $ad_field5, $ad_mini_to_js, $ad_status1, $ad_status2, $ad_status3, $ad_status4, $ad_status5, $ad_cat_img_detail,
	$ad_carusel, $ad_bbhtml, $ad_toggle)
	{
		global $tgver, $mainframe;
		$configfile = "components/com_true/config.true.php";
		@chmod ( $configfile, 0766 );
		$permission = is_writable ( $configfile );
		if (! $permission) {
			$mosmsg = JText::_ ( 'TG_CONFIG_NO_WRITE' );
			JTRedirect::_ ( "index2.php?option=$option&act=config", $mosmsg );
			break;
		}
		$ad_category2 = implode ( ",", $ad_category );
		//временный параметр для LANG
		$ad_lang = '';
		$config = "<?php\n";
		$config .= "defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );\n";
		$config .= "\$ad_path = \"$ad_path\";\n";
		$config .= "\$ad_protect = \"$ad_protect\";\n";
		$config .= "\$ad_orgresize = \"$ad_orgresize\";\n";
		$config .= "\$ad_orgwidth = \"$ad_orgwidth\";\n";
		$config .= "\$ad_orgheight = \"$ad_orgheight\";\n";
		$config .= "\$ad_thumbwidth = \"$ad_thumbwidth\";\n";
		$config .= "\$ad_thumbheight = \"$ad_thumbheight\";\n";
		$config .= "\$ad_crsc = \"$ad_crsc\";\n";
		$config .= "\$ad_thumbquality = \"$ad_thumbquality\";\n";
		$config .= "\$ad_showdetail = \"$ad_showdetail\";\n";
		$config .= "\$ad_showrating = \"$ad_showrating\";\n";
		$config .= "\$ad_showcomment = \"$ad_showcomment\";\n";
		$config .= "\$ad_pathway = \"$ad_pathway\";\n";
		$config .= "\$ad_showpanel = \"$ad_showpanel\";\n";
		$config .= "\$ad_userpannel = \"$ad_userpannel\";\n";
		$config .= "\$ad_special = \"$ad_special\";\n";
		$config .= "\$ad_rating = \"$ad_rating\";\n";
		$config .= "\$ad_lastadd = \"$ad_lastadd\";\n";
		$config .= "\$ad_owners = \"$ad_owners\";\n";
		$config .= "\$ad_lastcomment = \"$ad_lastcomment\";\n";
		$config .= "\$ad_showinformer = \"$ad_showinformer\";\n";
		$config .= "\$ad_periods = \"$ad_periods\";\n";
		$config .= "\$ad_search = \"$ad_search\";\n";
		$config .= "\$ad_comtitle = \"$ad_comtitle\";\n";
		$config .= "\$ad_showsend2friend = \"$ad_showsend2friend\";\n";
		$config .= "\$ad_picincat = \"$ad_picincat\";\n";
		$config .= "\$ad_powered = \"$ad_powered\";\n";
		$config .= "\$ad_showwatermark = \"$ad_showwatermark\";\n";
		$config .= "\$ad_showdownload = \"$ad_showdownload\";\n";
		$config .= "\$ad_downpub = \"$ad_downpub\";\n";
		$config .= "\$ad_perpage = \"$ad_perpage\";\n";
		$config .= "\$ad_catsperpage = \"$ad_catsperpage\";\n";
		$config .= "\$ad_sortby = \"$ad_sortby\";\n";
		$config .= "\$ad_toplist = \"$ad_toplist\";\n";
		$config .= "\$ad_approve = \"$ad_approve\";\n";
		$config .= "\$ad_maxuserimage = \"$ad_maxuserimage\";\n";
		$config .= "\$ad_maxfilesize = \"$ad_maxfilesize\";\n";
		$config .= "\$ad_maxwidth = \"$ad_maxwidth\";\n";
		$config .= "\$ad_maxheight = \"$ad_maxheight\";\n";
		$config .= "\$ad_category = \"$ad_category2\";\n";
		$config .= "\$ad_imgstyle = \"$ad_imgstyle\";\n";
		$config .= "\$ad_ncsc = \"$ad_ncsc\";\n";
		$config .= "\$ad_showimgtext = \"$ad_showimgtext\";\n";
		$config .= "\$ad_showfimgdate = \"$ad_showfimgdate\";\n";
		$config .= "\$ad_showimgcounter = \"$ad_showimgcounter\";\n";
		$config .= "\$ad_showfrating = \"$ad_showfrating\";\n";
		$config .= "\$ad_showres = \"$ad_showres\";\n";
		$config .= "\$ad_showfimgsize = \"$ad_showfimgsize\";\n";
		$config .= "\$ad_showimgauthor = \"$ad_showimgauthor\";\n";
		$config .= "\$ad_cp = \"$ad_cp\";\n";
		$config .= "\$ad_lightbox = \"$ad_lightbox\";\n";
		$config .= "\$ad_lightbox_fa = \"$ad_lightbox_fa\";\n";
		$config .= "\$ad_js_effect = \"$ad_js_effect\";\n";
		$config .= "\$ad_cat_desc = \"$ad_cat_desc\";\n";
		$config .= "\$ad_field1 = \"$ad_field1\";\n";
		$config .= "\$ad_field2 = \"$ad_field2\";\n";
		$config .= "\$ad_field3 = \"$ad_field3\";\n";
		$config .= "\$ad_field4 = \"$ad_field4\";\n";
		$config .= "\$ad_field5 = \"$ad_field5\";\n";
		$config .= "\$ad_mini_to_js = \"$ad_mini_to_js\";\n";
		$config .= "\$ad_status1 = \"$ad_status1\";\n";
		$config .= "\$ad_status2 = \"$ad_status2\";\n";
		$config .= "\$ad_status3 = \"$ad_status3\";\n";
		$config .= "\$ad_status4 = \"$ad_status4\";\n";
		$config .= "\$ad_status5 = \"$ad_status5\";\n";
		$config .= "\$ad_cat_img_detail = \"$ad_cat_img_detail\";\n";
		$config .= "\$ad_carusel = \"$ad_carusel\";\n";
		$config .= "\$ad_bbhtml = \"$ad_bbhtml\";\n";
		$config .= "\$ad_toggle = \"$ad_toggle\";\n";
		$config .= "\$ad_lang = \"$ad_lang\";\n";
		$config .= "?>";
		if ($fp = fopen ( "$configfile", "w" )) {
			fputs ( $fp, $config, strlen ( $config ) );
			fclose ( $fp );
		}
		//пишем конфиг в базу
		$db = & JTDB::getDBO ();
		//переименовываем корневую директорию, если админ изменил название
		$db->setQuery ("SELECT ad_path FROM #__true_config ");
		$old_ad_path = $db->loadResult();
		if ($old_ad_path != $ad_path) {
			rename($mainframe->getCfg('absolute_path').$old_ad_path, $mainframe->getCfg('absolute_path').$ad_path);
		} else {}

        $db->setQuery ( "UPDATE #__true_config SET
		ad_path = '$ad_path',
		ad_protect = '$ad_protect',
		ad_orgresize = '$ad_orgresize',
		ad_orgwidth = '$ad_orgwidth',
		ad_orgheight = '$ad_orgheight',
		ad_thumbwidth = '$ad_thumbwidth',
		ad_thumbheight = '$ad_thumbheight',
		ad_crsc = '$ad_crsc',
		ad_thumbquality = '$ad_thumbquality',
		ad_showdetail = '$ad_showdetail',
		ad_showrating = '$ad_showrating',
		ad_showcomment = '$ad_showcomment',
		ad_pathway = '$ad_pathway',
		ad_showpanel = '$ad_showpanel',
		ad_userpannel = '$ad_userpannel',
		ad_special = '$ad_special',
		ad_rating = '$ad_rating',
		ad_lastadd = '$ad_lastadd',
		ad_owners = '$ad_owners',
		ad_lastcomment = '$ad_lastcomment',
		ad_showinformer = '$ad_showinformer',
		ad_periods = '$ad_periods',
		ad_search = '$ad_search',
		ad_comtitle = '$ad_comtitle',
		ad_showsend2friend = '$ad_showsend2friend',
		ad_picincat = '$ad_picincat',
		ad_powered = '$ad_powered',
		ad_showwatermark = '$ad_showwatermark',
		ad_showdownload = '$ad_showdownload',
		ad_downpub = '$ad_downpub',
		ad_perpage = '$ad_perpage',
		ad_catsperpage = '$ad_catsperpage',
		ad_sortby = '$ad_sortby',
		ad_toplist = '$ad_toplist',
		ad_approve = '$ad_approve',
		ad_maxuserimage = '$ad_maxuserimage',
		ad_maxfilesize = '$ad_maxfilesize',
		ad_maxwidth = '$ad_maxwidth',
		ad_maxheight = '$ad_maxheight',
		ad_category = '$ad_category2',
		ad_imgstyle = '$ad_imgstyle',
		ad_ncsc = '$ad_ncsc',
		ad_showimgtext = '$ad_showimgtext',
		ad_showfimgdate = '$ad_showfimgdate',
		ad_showimgcounter = '$ad_showimgcounter',
		ad_showfrating = '$ad_showfrating',
		ad_showres = '$ad_showres',
		ad_showfimgsize = '$ad_showfimgsize',
		ad_showimgauthor = '$ad_showimgauthor',
		ad_cp = '$ad_cp',
		ad_lightbox = '$ad_lightbox',
		ad_lightbox_fa = '$ad_lightbox_fa',
		ad_js_effect = '$ad_js_effect',
		ad_cat_desc = '$ad_cat_desc',
		ad_field1 = '$ad_field1',
		ad_field2 = '$ad_field2',
		ad_field3 = '$ad_field3',
		ad_field4 = '$ad_field4',
		ad_field5 = '$ad_field5',
		ad_mini_to_js = '$ad_mini_to_js',
		ad_status1 = '$ad_status1',
		ad_status2 = '$ad_status2',
		ad_status3 = '$ad_status3',
		ad_status4 = '$ad_status4',
		ad_status5 = '$ad_status5',
		ad_cat_img_detail = '$ad_cat_img_detail',
		ad_carusel = '$ad_carusel',
		ad_bbhtml = '$ad_bbhtml',
		ad_toggle = '$ad_toggle'
        " );
		$db->query ();
		JTRedirect::_ ( "index2.php?option=$option&task=settings", JText::_ ( 'TG_SETT_SAVED') );
	}
//Показ категорий
function viewCatg($option)
	{
		global $mainframe;
		$db = & JTDB::getDBO ();

		// узнаем "стартовую" категорию для показа
		$catid = $mainframe->getUserStateFromRequest ( "rcid{$option}", 'rcid', 0 );
		$limit = $mainframe->getUserStateFromRequest ( "viewlistlimit", 'limit', 10 );
		$limitstart = $mainframe->getUserStateFromRequest ( "view{$option}limitstart", 'limitstart', 0 );
		$search = $mainframe->getUserStateFromRequest ( "search{$option}", 'search', '' );
		$search = $db->getEscaped ( trim ( strtolower ( $search ) ) );
		$where = "";
		if ($search) {
			$where = " WHERE a.name LIKE '%$search%' OR a.description LIKE '%$search%'";
		}
		// прописываем ее в условие для отбора
		if ($catid > 0)
			$where ? $where .= "cid='$catid'" : $where = " WHERE cid=$catid";
		$query = "SELECT count(*) FROM #__true_catg AS a $where ";
		$db->setQuery ( $query );
		$total = $db->loadResult ();
		$lists ['cats'] = ShowDropDownCategoryList ( $catid, 'rcid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"' );
		require_once ($mainframe->getCfg ( 'absolute_path' ) . "/administrator/includes/pageNavigation.php");
		$pageNav = new mosPageNav ( $total, $limitstart, $limit );
		HTML_true::showCatOverview ( $option, $total, $catid, $lists, $pageNav, $search );
	}
//Редактирование категорий
function editCatg($uid, $option) 
	{
		global $my;
		$db = & JTDB::getDBO ();

		//$cat = $uid;
		$row = new mosCatgs ( $db );
		$row->load ( $uid );
		$orders = mosGetOrderingList ( "SELECT ordering AS value, name AS text FROM #__true_catg ORDER BY ordering DESC" );
		$orderlist = mosHTML::selectList ( $orders, 'ordering', 'class="inputbox"', 'value', 'text', intval ( $row->ordering ) );
		if ($uid == 0) {
			$row->menulink = 0;
		}
		$menulink = mosHTML::yesnoRadioList('menulink','class="inputbox"', $row->menulink);
		if ($uid == 0) {
			$row->published = 1;
		}
		$publist = mosHTML::yesnoRadioList ( 'published', 'class="inputbox"', $row->published );
		$db->setQuery ( "SELECT id AS value, name AS text FROM #__groups ORDER BY id" );
		$groups = $db->loadObjectList ();
		$glist = mosHTML::selectList ( $groups, 'access', 'class="inputbox"', 'value', 'text', intval ( $row->access ) );
		//листинг типов меню
        $query = "SELECT params FROM #__modules WHERE module = 'mod_mainmenu'";
		$db->setQuery( $query );
		$menus = $db->loadObjectList();
		$total = count( $menus );
		$menuselect = array();
		for( $i = 0; $i < $total; $i++ ) {
			$params = mosParseParams( $menus[$i]->params );
			$menuselect[$i]->value 	= $params->menutype;
			$menuselect[$i]->text 	= $params->menutype;
		}
		// sort array of objects
		SortArrayObjects( $menuselect, 'text', 1 );
		$mgroups = mosHTML::selectList( $menuselect, 'menuselecttype', 'class="inputbox" size="1" ', 'value', 'text', $row->menuselecttype );
		//список родительских\дочерних категорий
		$Lists ["catgs"] = ShowDropDownCategoryList ( $row->parent, "parent", "dests" );
		HTML_true::editCatg ( $row, $publist, $menulink, $option, $glist, $Lists, $mgroups, $orderlist );
	}
//Сохранений категорий
function saveCatg($option, $task)
	{
		global $my, $mainframe;
		$db = & JTDB::getDBO ();

		$row = new mosCatgs ( $db );
		if (! $row->bind ( $_POST )) {
			echo "<script> alert('" . $row->getError () . "'); window.history.go(-1); </script>\n";
			exit ();
		}
		mosMakeHtmlSafe ( $row->name );
		if ($row->parent == $row->cid) {
			JTRedirect::_ ( "index2.php?option=$option&task=showcatg", JText::_ ( 'TG_SUBCAT_SELECT_ERROR' ) );
		}
		if (! $row->check ()) {
			echo "<script> alert('" . $row->getError () . "'); window.history.go(-1); </script>\n";
			exit ();
		}
		if (! $row->store ()) {
			echo "<script> alert('" . $row->getError () . "'); window.history.go(-1); </script>\n";
			exit ();
		}
		$row->checkin ();
		$row->updateOrder ( "" );
		//создаем дополнительные подкаталоги с именем ID категории
		require_once (TRUE_ADMIN . "config.true.php");
		$ad_paththumbs = $ad_path.'/thumbs';
  		$ad_pathimages = $ad_path.'/pictures';
  		$ad_pathoriginals = $ad_path.'/originals';
		@mkdir ( $mainframe->getCfg ( 'absolute_path' ) . '/' . $ad_pathoriginals . '/' . $row->cid, 0755 );
		if (! chmod ( $mainframe->getCfg ( 'absolute_path' ) . '/' . $ad_pathoriginals . '/' . $row->cid, 0755 ) ) {
			echo "<script> alert('" . $row->getError () . "'); window.history.go(-1); </script>\n";
			exit ();
			}
		@mkdir ( $mainframe->getCfg ( 'absolute_path' ) . '/' . $ad_pathimages . '/' . $row->cid, 0755 );
		if (! chmod ( $mainframe->getCfg ( 'absolute_path' ) . '/' . $ad_pathimages . '/' . $row->cid, 0755 ) ) {
			echo "<script> alert('" . $row->getError () . "'); window.history.go(-1); </script>\n";
			exit ();
			}
		@mkdir ( $mainframe->getCfg ( 'absolute_path' ) . '/' . $ad_paththumbs . '/' . $row->cid, 0755 );
		if (! chmod ( $mainframe->getCfg ( 'absolute_path' ) . '/' . $ad_paththumbs . '/' . $row->cid, 0755 )) {
			echo "<script> alert('" . $row->getError () . "'); window.history.go(-1); </script>\n";
			exit ();
			}
		//
		$menu_link_item = 'index.php?option=com_true&func=viewcategory&catid='.$row->cid.'';
		$db->setQuery("SELECT link FROM #__menu WHERE link ='$menu_link_item'");
		$current_menu_link = $db->loadResult();
	    if ($current_menu_link!=$menu_link_item && $row->menulink == '1') {
				$db->setQuery("INSERT INTO #__menu (id, menutype, name, link, type, published, parent, componentid, sublevel, ordering,
				checked_out, checked_out_time, pollid, browserNav, access, utaccess, params )
				VALUES (NULL, '$row->menuselecttype', '$row->name', '$menu_link_item', 'components', '1', '0', '45', '0', '', '0',
				'0000-00-00 00:00:00', '0', '0', '0', '0', '' )");
				$db->query ();
		} else if ($current_menu_link==$menu_link_item && $row->menulink == '0') {
				$db->setQuery("DELETE FROM #__menu WHERE link ='$menu_link_item'");
				$db->query ();
				$db->setQuery("UPDATE #__true_catg SET menuselect = '' WHERE cid = '$row->cid'");
				$db->query ();
		} else {}

		JTRedirect::_ ( "index2.php?option=$option&task=showcatg" );
	}
//Публикация категорий
function publishCatg($cid = null, $publish = 1, $option)
	{
		global $my;

		$db = & JTDB::getDBO ();

		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			$action = $publish ? 'publish' : 'unpublish';
			echo "<script> alert('" . JText::_ ( 'TG_SELECT_AN_ITEM' ) . " $action'); window.history.go(-1);</script>\n";
			exit ();
		}
		$cids = implode ( ',', $cid );
		$db->setQuery ( "UPDATE #__true_catg SET published='$publish' WHERE cid IN ($cids)" );
		if (! $db->query ()) {
			echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
			exit ();
		}
		if (count ( $cid ) == 1) {
			$row = new mosCatgs ( $db );
			$row->checkin ( $cid [0] );
		}
		JTRedirect::_ ( "index2.php?option=$option&task=showcatg" );
	}
//Удаление категорий
function removeCatg($cid, $option)
	{
		global $mainframe;
		$db = & JTDB::getDBO ();

		if (count ( $cid )) {
			$cids = implode ( ',', $cid );
			foreach ( $cid as $cc ) {
				$db->setQuery ( "DELETE FROM #__true_catg WHERE cid=$cc" );
				$db->query ();
				echo $db->getErrorMsg ();
				//удаляем наш подкаталог
				require_once (TRUE_ADMIN . "config.true.php");
				$ad_paththumbs = $ad_path.'/thumbs/';
  				$ad_pathimages = $ad_path.'/pictures/';
  				$ad_pathoriginals = $ad_path.'/originals/';
				$rmcat1 = $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . $cc;
				$rmcat2 = $mainframe->getCfg ( 'absolute_path' ) . $ad_pathimages . $cc;
				$rmcat3 = $mainframe->getCfg ( 'absolute_path' ) . $ad_paththumbs . $cc;
				rmdir ( $rmcat1 );
				rmdir ( $rmcat2 );
				rmdir ( $rmcat3 );
			}
		}
		JTRedirect::_ ( "index2.php?option=$option&task=showcatg", $error );
	}
//Отмена категорий (не ясно)
function cancelCatg($option)
	{
		$db = & JTDB::getDBO ();

		$row = new mosCatgs ( $db );
		$row->bind ( $_POST );
		$row->checkin ();
		JTRedirect::_ ( TRUE_INDEX2 . '&task=showcatg' );
	}
//Путь к катеогрии (бред какой-то)
// boston тут приложился
function ShowCategoryPath($cat)
	{
		global $gid, $tgurl;
		$db = & JTDB::getDBO ();

		$cat = intval ( $cat );
		if ($cat < 1)
			return;
		$parent = 100;
		while ( $parent ) {
			$db->setQuery ( "SELECT * FROM #__true_catg WHERE cid='$cat'" );
			$row = $db->loadAssocList ();
			//print_r($row);
			$parent = $row [0] ['parent'];
			$name = $row [0] ['name'];
			if (empty ( $path )) {
				$path = $name;
			} else {
				$path = $name . ' &raquo; ' . $path;
			}
			$cat = $parent;
		}
		return $path . " ";
	}
//Выпадающий список катеогрий
function ShowDropDownCategoryList($cat, $cname = "cat", $extra = null, $flag = 0)
	{
		$db = & JTDB::getDBO ();

		//$cat = '10';
		$category = "<select name=\"$cname\" class=\"inputbox\" >";
		if ($flag == 1)
			$add_category = true;
		$query = "select *, cid AS id  from #__true_catg ORDER BY ordering";
		$db->setQuery ( $query );
		$items = $db->loadObjectList ();
		$children = array ();
		foreach ( $items as $v ) {
			$pt = $v->parent;
			$list = @$children [$pt] ? $children [$pt] : array ();
			array_push ( $list, $v );
			$children [$pt] = $list;
		}
		$array = mosTreeRecurse ( 0, '', array (), $children );
		$options [] = mosHTML::makeOption ( 0, JText::_ ( 'TG_SUBCAT_SELECT' ) );
		foreach ( $array as $item ) {
			$options [] = mosHTML::makeOption ( $item->id, $item->treename );
		}
		$db->setQuery ( "SELECT parent FROM #__true_catg WHERE cid = '$cat'" );
		$parent_id = $db->loadResult ();
		$db->setQuery ( "SELECT cid FROM #__true_catg WHERE cid = '$parent_id'" );
		$parent_id = $db->loadResult ();
		//$parent_id = $cid;
		if (empty($extra)) {
			$extra = 'class="inputbox"';
		}
		$category = mosHTML::selectList ( $options, $cname, $extra, 'value', 'text', $cat );
		return $category;
	}
function ShowDropDownCategoryListImg($cat, $cname = "cat", $extra = null, $flag = 0)
	{
		$db = & JTDB::getDBO ();

		//$cat = '10';
		$category = "<select name=\"$cname\" class=\"inputbox\" >";
		if ($flag == 1)
			$add_category = true;
		$query = "SELECT *, cid AS id  FROM #__true_catg ORDER BY ordering";
		$db->setQuery ( $query );
		$items = $db->loadObjectList ();
		$children = array ();
		foreach ( $items as $v ) {
			$pt = $v->parent;
			$list = @$children [$pt] ? $children [$pt] : array ();
			array_push ( $list, $v );
			$children [$pt] = $list;
		}
		$array = mosTreeRecurse ( 0, '', array (), $children );
		$options [] = mosHTML::makeOption ( 0, JText::_ ( 'TG_SUBCAT_SELECT' ) );
		foreach ( $array as $item ) {
			$options [] = mosHTML::makeOption ( $item->id, $item->treename );
		}
		$category = mosHTML::selectList ( $options, $cname, 'class="inputbox"', 'value', 'text', $cat );
		return $category;
	}
//Порядок категорий
function orderCatg($uid, $inc, $option)
	{
		$db = & JTDB::getDBO ();

		$fp = new mosCatgs ( $db );
		$fp->load ( $uid );
		$fp->move ( $inc );
		JTRedirect::_ ( TRUE_INDEX2 . '&task=showcatg' );
	}
//Показ голосов
function showVotes($option)
	{
		echo "<script type=\"text/javascript\">\n";
		echo "function confirmSubmit() { \n";
		echo "var agree=confirm('" . JText::_ ( 'TG_SURE_RESET_VOTES' ) . "');\n";
		echo "if (agree) return true ;\n";
		echo "else return false ; } </script>";
		echo "<table class=\"adminheading\"><tr>\n";
		echo "<th class='trash'>" . JText::_ ( 'TG_RESET_VOTES_TITLE' ) . "</th></tr></table>";
		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>\n";
		echo '<td style="text-align:center;border:1px solid #ccc;width:400px;padding:40px;margin:0 auto; background:#F7F7F7">
		<form action="index2.php?task=reset" name="adminForm" method="post"><p>' . JText::_ ( 'TG_RESET_VOTES_DESCRIPTION' ) . '</p>
		<input type="hidden" name="option" value="' . $option . '" />
		<p><img src="./images/trash.png" alt="" /></p>
		<br /><input type="submit" name="reset" value="' . JText::_ ( 'TG_RESET' ) . '" onclick="return confirmSubmit()" />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="' . JText::_ ( 'TG_CANCEL_TB' ) . '" onclick="javascript:history.go(-1);" />
		</form>
		</td></tr></table>';
	}
//Удаление голосов
function resetVotes($option)
	{
		$db = & JTDB::getDBO ();

		$db->setQuery ( "DELETE FROM #__true_votes" );
		if (! $db->query ()) {
			echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
		}
		$db->setQuery ( "UPDATE #__true SET imgvotes='0', imgvotesum='0'" );
		if (! $db->query ()) {
			echo "<script> alert('" . $db->getErrorMsg () . "'); window.history.go(-1); </script>\n";
		}
		JTRedirect::_ ( TRUE_INDEX2 . '&act=pictures', JText::_ ( 'TG_RESET_FINISHED' ) );
	}
//Тестовая категория
function testCat($cat, $cname, $extras = "", $levellimit = "4")
	{
		$db = & JTDB::getDBO ();

		$db->setQuery ( "SELECT cid AS id, parent, name FROM #__true_catg ORDER BY ordering" );
		$items = $db->loadObjectList ();
		$children = array ();
		foreach ( $items as $v ) {
			$pt = $v->parent;
			$list = @$children [$pt] ? $children [$pt] : array ();
			array_push ( $list, $v );
			$children [$pt] = $list;
		}
		$list = catTreeRecurse ( 0, '', array (), $children );
		$items = array ();
		$items [] = mosHTML::makeOption ( '', ' ' );
		foreach ( $list as $item ) {
			$items [] = mosHTML::makeOption ( $item->id, $item->treename );
		}
		asort ( $items );
		$parlist = selectList2 ( $items, $cname, 'class="inputbox" ' . $extras, 'value', 'text', $cat );
		return $parlist;
	}
//Что-то с деревом категорий (рекурсия что ли?)
function catTreeRecurse($id, $indent = "&nbsp;&nbsp;&nbsp;", $list, &$children, $maxlevel = 9999, $level = 0, $seperator = " » ")
	{
		if (@$children [$id] && $level <= $maxlevel) {
			foreach ( $children [$id] as $v ) {
				$id = $v->id;
				$txt = $v->name;
				$pt = $v->parent;
				$list [$id] = $v;
				$list [$id]->treename = "$indent$txt";
				$list [$id]->children = count ( @$children [$id] );
				$list = catTreeRecurse ( $id, "$indent$txt$seperator", $list, $children, $maxlevel, $level + 1 );
			}
		}
		return $list;
	}
//Показ пересоздания мини-эскизов
function showDGrebuild($option)
	{
		global $mainframe;
		$db = & JTDB::getDBO ();

		require_once (TRUE_ADMIN . "config.true.php");
		///
		$ad_paththumbs = $ad_path.'/thumbs';
       	$ad_pathimages = $ad_path.'/pictures';
       	$ad_pathoriginals = $ad_path.'/originals';
       	////
		$db->setQuery ( "SELECT catid, imgthumbname FROM #__true ORDER BY ordering LIMIT 1" );
		$rows = $db->LoadObjectList ();
		$list = $rows[0];
		echo $list->catid;
		$thumb = $list->imgthumbname;
		$imgprev = $mainframe->getCfg ( 'live_site' ) . $ad_paththumbs . '/' . $list->catid . '/' . $list->imgthumbname;
		echo "<table class=\"adminheading\"><tr>\n";
		echo "<th style='background: url(components/com_true/images/rebuild.png) no-repeat left'>" . JText::_ ( 'TG_THUMB_REBUILD_TITLE' ) . "</th>\n";
		echo "</tr></table>";
		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0' class='adminform'>\n";
		echo "<tr><th colspan=\"2\">" . JText::_ ( 'TG_THUMB_REBUILD_INFO' ) . "</th></tr>";
		echo "<tr><td width='20%'><div align='center' class='clr'>";
		echo "<img src='$imgprev' style='" . $ad_imgstyle . "' alt='' /></div></td>\n";
		echo "<td width='80%'>";
		echo "<form action='index2.php?task=startdgrebuild' name='adminForm' method='post'>\n";
		echo "<fieldset><legend>" . JText::_ ( 'TG_THUMB_REBUILD_TITLE' ) . "</legend>\n";
		echo JText::_ ( 'TG_THUMB_REBUILD_DESCRIPTION' );
		echo "<strong>" . JText::_ ( 'TG_THUMBS_IS' ) . "&nbsp;&nbsp;</strong>";
		$clist = ShowDropDownCategoryList ( $list->catid, 'catid', 'class="inputbox" size="1"' );
		echo is_writable ( $mainframe->getCfg ( 'absolute_path' ) . $ad_paththumbs . "/" . $list->catid . "/" . $thumb ) ? '<b><font color="green"> ' . JText::_ ( 'TG_WRITEABLE' ) . '</font></b><br /><br />' . $clist . '' : '<b><font color="red"> ' . JText::_ ( 'TG_UNWRITEABLE' ) . '</font></b><br /><br />';
		echo "<input type='hidden' name='option' value='$option' />";
		echo "<input type='submit' name='startdgrebuild' value='" . JText::_ ( 'TG_BEGIN' ) . "' class='button' />";
		echo "</fieldset></form></td></tr></table>";
	}
//Функция пересоздания мини-эскизов
function startDGrebuild($option)
	{
		global $mainframe, $catid;
		$db = & JTDB::getDBO ();
        		require_once (TRUE_ADMIN . "config.true.php");
		///
		$ad_paththumbs = $ad_path.'/thumbs';
       	$ad_pathimages = $ad_path.'/pictures';
       	$ad_pathoriginals = $ad_path.'/originals';
		require_once (TRUE_ADMIN . "config.true.php");
		require_once (TRUE_ADMIN . "images.true.php");

		$orgls = $mainframe->getCfg ( 'absolute_path' ) . $ad_pathoriginals . '/' . $catid . '/';
		$thmbs = $mainframe->getCfg ( 'absolute_path' ) . $ad_paththumbs . '/' . $catid . '/';
		$db->setQuery ( "SELECT * FROM #__true WHERE catid=$catid" );
		$pics = $db->loadObjectList ();
		if ($pics [0] != "") {
			foreach ( $pics as $pic ) {
				dgImageCreate ( $orgls . $pic->imgoriginalname, $thmbs . $pic->imgthumbname, $ad_thumbwidth, $ad_thumbheight, $ad_thumbquality, $ad_crsc );
			}
		}
		JTRedirect::_ ( "index2.php?option=$option&act=rebuild", JText::_ ( 'TG_THUMB_REBUILD_END' ) );
	}
//Что-то выбирает, какой-то список
function selectList2(&$arr, $tag_name, $tag_attribs, $key, $text, $selected)
	{
		reset ( $arr );
		$html = "\n<select name=\"$tag_name\" $tag_attribs>";
		for($i = 0, $n = count ( $arr ); $i < $n; $i ++) {
			$k = $arr [$i]->$key;
			$t = $arr [$i]->$text;
			$id = @$arr [$i]->id;
			$extra = '';
			$extra .= $id ? " id=\"" . $arr [$i]->id . "\"" : '';
			if (is_array ( $selected )) {
				foreach ( $selected as $obj ) {
					$k2 = $obj;
					if ($k == $k2) {
						$extra .= " selected=\"selected\"";
						break;
					}
				}
			} else {
				$extra .= ($k == $selected ? " selected=\"selected\"" : '');
			}
			$html .= "\n\t<option value=\"" . $k . "\"$extra>" . $t . "</option>";
		}
		$html .= "\n</select>\n";
		return $html;
	}
//Получает то ли число ссылок то нумерованные списки (снова фигня)
function GetNumberOfLinks($cat)
	{
		$db = & JTDB::getDBO ();

		$queue [] = intval ( $cat );
		while ( list ( $key, $cat ) = each ( $queue ) ) {
			$db->setQuery ( "SELECT cid FROM #__true_catg WHERE parent=$cat AND published=1" );
			$result = $db->query ();
			$total = mysql_num_rows ( $result );
			$j = 0;
			while ( $j < $total ) {
				$val = mysql_fetch_row ( $result );
				$queue [] = $val [0];
				$j ++;
			}
		}
		reset ( $queue );
		$query = "SELECT count(*) FROM #__true  WHERE ( 0!=0";
		while ( list ( $key, $cat ) = each ( $queue ) ) {
			$query .= " or catid = $cat";
		}
		$query = $query . " ) AND published=1 AND approved = 1";
		$db->setQuery ( $query );
		$result = $db->query ();
		$val = mysql_fetch_row ( $result );
		return $val [0];
	}
//Показ редактирования языкового файла
function showLanguage($option)
	{
		global $language;

		$current_lang = $language->getLanguage ();

		if (file_exists ( TRUE_BASE . 'languages' . DS . $language->getLanguage () . '.ini' )) {
			$file = TRUE_BASE . 'languages' . DS . $language->getLanguage () . '.ini';
		} else {
			$file = TRUE_BASE . 'languages' . DS . 'english.ini';
		}

		echo showSource ( $file, $option );
	}
//Сохранений языкового файла
function saveLanguage($option)
	{
		global $language;

		$file = JTInput::getParam ( $_POST, 'file', '' );
		$filecontent = JTInput::getParam ( $_POST, 'filecontent', '', 4 );

		if (! $filecontent) {
			JTRedirect::_ ( "index2.php?option=$option&act=settings", JText::_ ( 'TG_LANG_EMPTY' ) );
		}
		if (file_exists ( TRUE_BASE . 'languages' . DS . $language->getLanguage () . '.ini' )) {
			$file = TRUE_BASE . 'languages' . DS . $language->getLanguage () . '.ini';
		} else {
			$file = TRUE_BASE . 'languages' . DS . 'english.ini';
		}
		$enable_write = JTInput::getParam ( $_POST, 'enable_write', 0 );
		$oldperms = fileperms ( $file );
		if ($enable_write)
			@chmod ( $file, $oldperms | 0222 );
		clearstatcache ();
		if (is_writable ( $file ) == false) {
			JTRedirect::_ ( "index2.php?option=$option&act=settings", JText::_ ( 'TG_LANG_IS_NOT_WRITEABLE' ) );
		}
		if ($fp = fopen ( $file, "w" )) {
			fputs ( $fp, stripslashes ( $filecontent ) );
			fclose ( $fp );
			if ($enable_write) {
				@chmod ( $file, $oldperms );
			} else {
				if (mosGetParam ( $_POST, 'disable_write', 0 ))
					@chmod ( $file, $oldperms & 0755 );
			}
			JTRedirect::_ ( "index2.php?option=$option&act=settings", JText::_ ( 'TG_LANG_SAVED' ) );
		} else {
			if ($enable_write)
				@chmod ( $file, $oldperms );
			JTRedirect::_ ( "index2.php?option=$option", JText::_ ( 'TG_LANG_IS_NOT_WRITEABLE' ) );
		}
	}
//Редактирование содержимого языка
function showSource($file, $option)
	{
		global $language;

		$curent_lang = $language->getLanguage ();

		$f = fopen ( $file, "r" );
		$content = fread ( $f, filesize ( $file ) );
		$content = htmlspecialchars ( $content );

		echo "<form action='index2.php' name='adminForm' method='post'>\n";
		echo "<table cellpadding='4' cellspacing='0' border='0' width='100%' class='adminform'><tr>\n";
		/*echo "<th colspan='4'>";
		echo JText::_ ( 'TG_LANG_FILE' ) . $curent_lang . ".ini " . JText::_ ( 'TG_LANG_IS' ) . " :";
		echo is_writable ( $file ) ? '<font color="green"> ' . JText::_ ( 'TG_WRITEABLE' ) . '</font>' : '<font color="red"> ' . JText::_ ( 'TG_UNWRITEABLE' ) . '</font>';
		echo "</th>\n";*/
		echo "<tr><td><textarea cols='160' rows='30' name='filecontent' readonly>" . $content . "</textarea></td></tr>";
		echo "<tr><td>";
		/*if (mosIsChmodable ( $file )) {
			if (is_writable ( $file )) {
				echo "<input type=\"checkbox\" id=\"disable_write\" name=\"disable_write\" value=\"1\"/>\n";
				echo "<label for=\"disable_write\"><b>" . JText::_ ( 'TG_MAKE_UNWRITEABLE' ) . "</b></label>";
			} else {
				echo "<input type=\"checkbox\" id=\"enable_write\" name=\"enable_write\" value=\"1\"/>\n";
				echo "<label for=\"enable_write\"><b>" . JText::_ ( 'TG_OVERRRIDE_UNWRITEABLE' ) . "</b></label>";
			}
		}*/
		echo "</td></tr></table>\n";
		echo "<input type='hidden' name='file' value='$file' />\n";
		echo "<input type='hidden' name='option' value='$option' />";
		echo "<input type='hidden' name='task' value='' /></form>\n";
	}
//Перемещение картинок
function movePic($id)
	{
		global $mainframe;

		$db = & JTDB::getDBO ();

		$catid = $mainframe->getUserStateFromRequest ( "catid", 'catid', 0 );
		$ids = implode ( ',', $id );
		$db->setQuery ( "SELECT * FROM #__true WHERE id IN ( " . $ids . " ) ORDER BY id" );
		$rows = $db->loadObjectList ();
		$options = array (mosHTML::makeOption ( '1', '_true_SELECT_CAT' ) );
		$lists ['catgs'] = ShowDropDownCategoryList ( $catid, 'catid', 'class="inputbox" size="1" ' );
		HTML_true::movePic ( $id, $lists, $rows );
	}
//Результат перемещения картинок
function movePicResult($id)
	{
		global $movepic, $my, $mainframe, $ad_paththumbs;

		$db = & JTDB::getDBO ();

		if (! $movepic || $movepic == 0) {
			echo "<script> alert('" . JText::_ ( 'TG_MUST_SELECT_CATEGORY' ) . "'); window.history.go(-1);</script>\n";
			exit ();
		} else {
			$pic = new mostrue ( $db );
			$pic->dgMove ( $id, $movepic );
			$ids = implode ( ',', $id );
			$imgthumbname = implode ( ',', $imgthumbname1 );
			$total = count ( $id );
			$cat = new mosCatgs ( $db );
			$cat->load ( $movepic );
			$msg = $total . JText::_ ( 'TG_TOTAL_PICS_MOVED' ) . $cat->name;
			JTRedirect::_ ( TRUE_INDEX2 . '&task=pictures&mosmsg=' . $msg );
		}
	}
//Пишет директорию
function writDir($folder, $relative = 1)
	{
		$writeable = "<span onmouseover=\"return overlib('" . JText::_ ( 'TG_DIR_IS_WRITEABLE' ) . "');\" onmouseout=\"return nd();\"><img src=\"../images/tick.png\" /></span>";
		$unwriteable = "<span onmouseover=\"return overlib('" . JText::_ ( 'TG_DIR_IS_UNWRITEABLE' ) . "');\" onmouseout=\"return nd();\"><img src=\"../images/publish_x.png\" /></span>";
		if ($relative) {
			echo is_writable ( "../$folder" ) ? $writeable : $unwriteable;
		} else {
			echo is_writable ( "$folder" ) ? $writeable : $unwriteable;
		}
	}
//Установка защиты картинок через .htaccess
function dgProtect($dirtoprotect)
	{
		global $mainframe;
		require_once (TRUE_ADMIN . "config.true.php");
		$htaccess = "Order Deny,Allow\nDeny from All";
		$wf = fopen ( $mainframe->getCfg ( 'absolute_path' ) . $dirtoprotect . "/.htaccess", "w+" );
		if (! fwrite ( $wf, $htaccess ))
			;
		fclose ( $wf );
	}
//Удаление защиты
function dgUnprotect($dirtounprotect)
	{
		global $mainframe;
		require_once (TRUE_ADMIN . 'config.true.php');
		if (file_exists ( $mainframe->getCfg ( 'absolute_path' ) . $dirtounprotect . "/.htaccess" )) {
			unlink ( $mainframe->getCfg ( 'absolute_path' ) . $dirtounprotect . "/.htaccess" );
		}
	}
?>
