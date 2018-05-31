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
class mostrue extends mosDBTable
	{
		var $id = null;
		var $catid = null;
		var $imgtitle = null;
		var $imgauthor = null;
		var $imgtext = null;
		var $imgdate = null;
		var $imgcounter = null;
		var $imgvotes = null;
		var $imgvotesum = null;
		var $published = null;
		var $ordering = null;
		var $imgfilename = null;
		var $imgthumbname = null;
		var $imgoriginalname = null;
		var $checked_out = null;
		var $owner = null;
		var $approved = null;
		var $useruploaded = null;
		//5 добавленных полей
		var $field1 = null;
		var $field2 = null;
		var $field3 = null;
		var $field4 = null;
		var $field5 = null;
		var $metadesc = null;
		var $metakey = null;
		var $tags = null;

		function mostrue(&$db)
			{
				$this->mosDBTable('#__true', 'id', $db);
			}
		function dgMove($id, $catid)
			{
				global $database, $my;
				if(!(is_array($id)) || (count($id) < 1)) {
					echo "<script> alert('" . _SELECT_ITEM_MOVE . " ); window.history.go(-1);</script>\n";
					return false;
				}
				$ids = implode(',', $id);
				//Перемещаем файлы изображений
				$database->setQuery("SELECT catid, imgoriginalname, imgfilename, imgthumbname FROM #__true WHERE id IN ( $ids )");
		        $list = $database->loadObjectList();
				global $mosConfig_absolute_path;
				require_once (TRUE_ADMIN . "config.true.php");
				$ad_paththumbs = $ad_path.'/thumbs';
       			$ad_pathimages = $ad_path.'/pictures';
       			$ad_pathoriginals = $ad_path.'/originals';
				foreach($list as $img) {
		    		$orgimg1 = $mosConfig_absolute_path."/".$ad_pathoriginals."/".$img->catid."/".$img->imgoriginalname;
					$newimg1 = $mosConfig_absolute_path."/".$ad_pathoriginals."/".$catid."/".$img->imgoriginalname;
					$orgimg2 = $mosConfig_absolute_path."/".$ad_pathimages."/".$img->catid."/".$img->imgfilename;
					$newimg2 = $mosConfig_absolute_path."/".$ad_pathimages."/".$catid."/".$img->imgfilename;
					$orgimg3 = $mosConfig_absolute_path."/".$ad_paththumbs."/".$img->catid."/".$img->imgthumbname;
					$newimg3 = $mosConfig_absolute_path."/".$ad_paththumbs."/".$catid."/".$img->imgthumbname;
					rename($orgimg1, $newimg1);
					rename($orgimg2, $newimg2);
					rename($orgimg3, $newimg3);
				}
				//запрос на обновление строк картинок
				$database->setQuery("UPDATE #__true SET catid='$catid' WHERE id IN ( $ids )");

				if(!$database->query()) {
					echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
					return false;
				}
				return true;
			}
	}
class mosCatgs extends mosDBTable
	{
		var $cid = null;
		var $name = null;
		var $description = null;
		var $desc_full = null;
		var $parent = null;
		var $published = null;
		var $ordering = null;
		var $access = null;
		var $cmetadesc = null;
		var $cmetakey = null;
		var $menulink = null;
		var $menuselecttype = null;
		var $catimg = null;
		var $usercat = null;

		function mosCatgs(&$db)
			{
				$this->mosDBTable('#__true_catg', 'cid', $db);
			}

		function check()
			{
				$this->cid = intval($this->cid);
				return true;
			}
	}

?>
