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
$pic = "";
$path = "";
$id = 0;
$mid = intval(mosGetParam($_REQUEST, 'mid', 0));
$oid = intval(mosGetParam($_REQUEST, 'oid', 0));

global $database;
$database->setQuery("select catid from #__true where id = $mid ");
$catid = $database->loadResult();
$database->setQuery("select catid from #__true where id = $oid ");
$catido = $database->loadResult();

if($mid) {
	$pic = "imgfilename";
	$path = $picturedirwm.$catid.'/';
	$id  = $mid;

} else
	if($oid) {
		$pic = "imgoriginalname";
		$path = $originaldirwm.$catido.'/';
		$id = $oid;
	}
if($id) {
	$database->setQuery("select c.access " . " from #__true_catg as c " . " left join #__true as a on a.catid = c.cid " . " where a.id = $id ");
	$c_access = $database->loadResult();
	if($gid < $c_access) {
		exit;
	} else {
		$database->setQuery("select a.$pic " . " from #__true as a " . " where a.id = $id ");
		$pic = $database->loadResult();
		$pic = $path . $pic;
	}
	$img_info = getimagesize($pic);
	if(!$img_info) {
		exit;
	} else {
		$watermark = $gallerydir . '/watermark.png';
		$watermark = imagecreatefrompng($watermark);
		$watermark_width = imagesx($watermark);
		$watermark_height = imagesy($watermark);
		$image = imagecreatetruecolor($watermark_width, $watermark_height);

        if (strstr($pic, '.png')) {
            $image = imagecreatefrompng($pic);
        } else {
            $image = imagecreatefromjpeg($pic);
        }

		$size = getimagesize($pic);
		$dest_x = $size[0] - $watermark_width - 5;
		$dest_y = $size[1] - $watermark_height - 5;
		imagecopyresampled($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		header('content-type: image/jpeg');
		imagejpeg($image, '', $dest_qual = 95);
		imagedestroy($image);
		imagedestroy($watermark);
	}
}
?>