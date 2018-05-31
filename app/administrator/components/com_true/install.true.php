<?php
/***************************************************\
 **   True gallery - A Joomla! Gallery Component    **
 **   Copyright (C) 2008  by JoomlaForum **
 **   Version    : 2.0                              **
 **   Homepage   : http://true.palpalych.ru              **
 **   License    : Copyright, don't distribute      **
 **   Based on   : AkoGallery -> PonyGallery -> DatsoGallery Datso gallery 1.6**
 ***************************************************/

defined('_VALID_MOS') or defined('_JEXEC') or die('Direct Access to this location is not allowed.');

function com_install()
{

	if (!defined('DS')) {
		define('DS', DIRECTORY_SEPARATOR);
	}

	$path = str_replace('administrator' . DS, '', dirname(__FILE__));
	global $database, $mainframe, $mosConfig_absolute_path;
    //Пишем в базу конфиг, если первая установка
	    $database->setQuery ("SELECT ad_path FROM #__true_config");
	    $test_path = $database->loadResult();
	    if (!$test_path) {
		    $database->setQuery("INSERT INTO `#__true_config` VALUES ('/images/trueimg', 0, 0, 800, 800, 120, 120, 0, 80, 1,
		    0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 0, 0, 0, 0, 20, 6, 'DESC', 20, 0, 200, 120000000, 440, 440,
		    6, 0, 2, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 2, 1, 0, 0, 0, 0, 0, 0, 5, 15, 30, 50, 100, 1, 0, 1, 0, '')");
			$database->query();
		} else {}
		//пишем данные в файл конфиг
		//вытаскиваем данные из базы (старые или новые)
		$database->setQuery("SELECT * FROM #__true_config");
		$list = $database->query();
		//массив из всех элементов таблицы
		list($ad_path,
		$ad_protect, $ad_orgresize, $ad_orgwidth, $ad_orgheight, $ad_thumbwidth,
		$ad_thumbheight, $ad_crsc, $ad_thumbquality,
		$ad_showdetail, $ad_showrating, $ad_showcomment, $ad_pathway, $ad_showpanel,
		$ad_userpannel, $ad_special, $ad_rating, $ad_lastadd, $ad_owners, $ad_lastcomment,
		$ad_showinformer, $ad_periods, $ad_search, $ad_comtitle, $ad_showsend2friend,
		$ad_picincat, $ad_powered, $ad_showwatermark, $ad_showdownload, $ad_downpub, $ad_perpage,
		$ad_catsperpage, $ad_sortby, $ad_toplist, $ad_approve,
		$ad_maxuserimage, $ad_maxfilesize, $ad_maxwidth, $ad_maxheight, $ad_category, $ad_imgstyle, $ad_ncsc,
		$ad_showimgtext, $ad_showfimgdate, $ad_showimgcounter, $ad_showfrating, $ad_showres,
		$ad_showfimgsize, $ad_showimgauthor, $ad_cp, $ad_lightbox, $ad_lightbox_fa,
		$ad_js_effect, $ad_cat_desc,
		$ad_field1, $ad_field2, $ad_field3,
		$ad_field4, $ad_field5, $ad_mini_to_js, $ad_status1,
		$ad_status2, $ad_status3, $ad_status4, $ad_status5, $ad_cat_img_detail,
		$ad_carusel, $ad_bbhtml, $ad_toggle) = mysql_fetch_row($list);
		//формируем из них конфиг
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
		$config .= "\$ad_category = \"$ad_category\";\n";
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
		//пишем их в файл конфигурации
		$configfile = $mosConfig_absolute_path.'/administrator/components/com_true/config.true.php';
		@chmod ( $configfile, 0644 );
		if ($fp = fopen ( "$configfile", "w" )) {
			fputs ( $fp, $config, strlen ( $config ) );
			fclose ( $fp );
		}
	//подключаем прослойку для 1.5
	require_once ($path . DS . 'true.legacy.php');
	require_once (TRUE_LEGACY . DS . 'connector.php');
	JTConnector::connect(TRUE_LEGACY);
	//echo $path; exit();
    	//
	$mosConfig_absolute_path = $mainframe->getCfg('absolute_path');
	require_once ($mosConfig_absolute_path . "/components/com_true/true.legacy.php");
	require_once ($mosConfig_absolute_path . "/components/com_true/libraries/joomlatune/legacy/input.php");
	require_once ($mosConfig_absolute_path . "/administrator/components/com_true/globals.true.php");
	require ($mosConfig_absolute_path . "/administrator/components/com_true/config.true.php");
	require_once ($mosConfig_absolute_path . "/administrator/components/com_true/class.true.php");
	echo '<table width="60%" border="0" class="adminform">\n<tr>
		<td align="left"><img src="components/com_true/images/true.jpg"><br />
		<font class="small">&copy; 2008 by TrueGallery Team<br />www.true.palpalych.ru/<br />
		Validating and optimized by PaLyCH <br/>www.palpalych.ru</font><p/></td></tr>
		<tr><td style="background-color:"#ECECFF;" colspan="2">
		<code>' . JText::_('TG_INSTALL_PROCESS') . '<br /><br />';
	$iconpath = $mosConfig_absolute_path . '/includes/js/ThemeOffice';
	if (!is_writable($iconpath)) {
		echo '<font color="red">' . JText::_('TG_INSTALL_ERROR') . ':</font> ' . JText::_('TG_COPY_TO_1') . '
			1. true.png<br />
			2. tgpics.png<br />
			3. tgcategory.png<br />
			4. tgupload.png<br />
			5. tgzipupload.png<br />
			6. tgimport.png<br />
			7. tgconfig.png<br />
			8. tgreset.png<br />
			9. tgrebuild.png<br />
			<br />' . JText::_('TG_COPY_TO_2') . '<br /><font color="green">'.$iconpath.'</font><br /><br />';
	}
	$database->setQuery("SELECT id FROM #__components WHERE name='true'");
	$id = $database->loadResult();
	if (!is_file($iconpath . '/true.png')) {
		@copy($mosConfig_absolute_path . '/components/com_true/images/true.png', $iconpath . '/true.png');
	}
	$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/true.png', name='True Gallery' WHERE id='$id'");
	$result[1] = $database->query();
	if (!is_file($iconpath . '/tgpics.png')) {
		@copy($mosConfig_absolute_path . '/components/com_true/images/tgpics.png', $iconpath . '/tgpics.png');
	}
	$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/tgpics.png', name = '" . JText::_('TG_INSTALL_PIC') . "' WHERE parent='$id' AND name='Pictures'");
	$result[2] = $database->query();
	if (!is_file($iconpath . '/tgcategory.png')) {
		@copy($mosConfig_absolute_path . '/components/com_true/images/tgcategory.png', $iconpath . '/tgcategory.png');
	}
	$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/tgcategory.png', name = '" . JText::_('TG_INSTALL_CAT') . "' WHERE parent='$id' AND name='Categories'");
	$result[3] = $database->query();
	if (!is_file($iconpath . '/tgupload.png')) {
		@copy($mosConfig_absolute_path . '/components/com_true/images/tgupload.png', $iconpath . '/tgupload.png');
	}
	$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/tgupload.png', name = '" . JText::_('TG_INSTALL_U') . "' WHERE parent='$id' AND name='Normal Upload'");
	$result[5] = $database->query();
	if (!is_file($iconpath . '/tgzipupload.png')) {
		@copy($mosConfig_absolute_path . '/components/com_true/images/tgzipupload.png', $iconpath . '/tgzipupload.png');
	}
	$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/tgzipupload.png', name = '" . JText::_('TG_INSTALL_BU') . "' WHERE parent='$id' AND name='Batch Upload'");
	$result[6] = $database->query();
	if (!is_file($iconpath . '/tgimport.png')) {
		@copy($mosConfig_absolute_path . '/components/com_true/images/tgimport.png', $iconpath . '/tgimport.png');
	}
	$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/tgimport.png', name = '" . JText::_('TG_INSTALL_BI') . "' WHERE parent='$id' AND name='Batch Import'");
	$result[7] = $database->query();
	if (!is_file($iconpath . '/tgconfig.png')) {
		@copy($mosConfig_absolute_path . '/components/com_true/images/tgconfig.png', $iconpath . '/tgconfig.png');
	}
	$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/tgconfig.png', name = '" . JText::_('TG_INSTALL_CONF') . "' WHERE parent='$id' AND name='Configuration'");
	$result[8] = $database->query();
	if (!is_file($iconpath . '/tgreset.png')) {
		@copy($mosConfig_absolute_path . '/components/com_true/images/tgreset.png', $iconpath . '/tgreset.png');
	}
	$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/tgreset.png', name = '" . JText::_('TG_INSTALL_RV') . "' WHERE parent='$id' AND name='Reset Votes'");
	$result[9] = $database->query();
	if (!is_file($iconpath . '/tgrebuild.png')) {
		@copy($mosConfig_absolute_path . '/components/com_true/images/tgrebuild.png', $iconpath . '/tgrebuild.png');
	}
	$database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/tgrebuild.png', name = '" . JText::_('TG_INSTALL_RT') . "' WHERE parent='$id' AND name='Thumb Rebuild'");
	$result[10] = $database->query();
	$database->setQuery("UPDATE #__components SET admin_menu_link='option=categories&section=com_true' WHERE admin_menu_link='option=com_true&act=categories'");
	foreach ($result as $i => $res) {
		if ($res) {
			echo "<font color='green'>" . JText::_('TG_INSTALL_FINISHED') . ":</font> " . JText::_('TG_INSTALL_FINISHED_A') . " $i " . JText::_('TG_INSTALL_FINISHED_B') . "<br />";
		} else {
			echo "<font color='red'>" . JText::_('TG_INSTALL_ERROR') . "</font> " . JText::_('TG_INSTALL_ERROR_A') . " $i " . JText::_('TG_INSTALL_ERROR_B') . "<br />";
		}
	}
	//проверяем и создаем media для batch import
	if (chmod($mosConfig_absolute_path."/media", 0755))
		echo '<font color="green">' . JText::_('TG_INSTALL_FINISHED') . ':</font> ' . JText::_('TG_INSTALL_FINISHED_C') . '<br />';
	//проверяем и создаем каталог Images/trueimg
	if (!is_dir($mosConfig_absolute_path.$ad_path)) {
		@mkdir($mosConfig_absolute_path.$ad_path, 0755);
		@mkdir($mosConfig_absolute_path.$ad_path."/originals", 0755) && @fopen($mosConfig_absolute_path.$ad_path."/originals/index.html", "a");
		if (chmod($mosConfig_absolute_path.$ad_path."/originals", 0755))
			echo '<font color="green">' . JText::_('TG_DIR_OR') . ':</font> <br />';
		@mkdir($mosConfig_absolute_path.$ad_path."/pictures", 0755) && @fopen($mosConfig_absolute_path.$ad_path."/pictures/index.html", "a");
		if (chmod($mosConfig_absolute_path.$ad_path."/pictures", 0755))
			echo '<font color="green">' . JText::_('TG_DIR_PC') . ':</font> <br />';
		@mkdir($mosConfig_absolute_path.$ad_path."/thumbs", 0755) && @fopen($mosConfig_absolute_path.$ad_path."/thumbs/index.html", "a");
		if (chmod($mosConfig_absolute_path.$ad_path."/thumbs", 0755))
			echo '<font color="green">' . JText::_('TG_DIR_TH') . ':</font> <br />';
	} else {
		echo '<font color="green">'.JText::_('TG_DIR_EXISTS').'</font>';
	}
	echo '<font color="green">' . JText::_('TG_INSTALL_FINISHED') . ':</font> ' . JText::_('TG_INSTALL_FINISHED_D') . '<br />
	<font color="green">' . JText::_('TG_INSTALL_FINISHED') . ':</font> ' . JText::_('TG_INSTALL_FINISHED_E') . '<br />
	</code></td></tr></table>';
}
?>
