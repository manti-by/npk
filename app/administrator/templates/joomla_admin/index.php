<?php
/**
* @version $Id: index.php 9908 2008-01-06 22:57:38Z eddieajau $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Доступ запрещен' );

$tstart = mosProfiler::getmicrotime();
// needed to seperate the ISO number from the language file constant _ISO
$iso = explode( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $mosConfig_sitename; ?> - Админка</title>
<link rel="stylesheet" href="templates/joomla_admin/css/template_css.css" type="text/css" />
<link rel="stylesheet" href="templates/joomla_admin/css/theme.css" type="text/css" />
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/js/JSCookMenu_mini.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/administrator/includes/js/ThemeOffice/theme.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/js/joomla.javascript.js" type="text/javascript"></script>
<?php
include_once( $mosConfig_absolute_path . '/editor/editor.php' );
initEditor();

// Workaround to include custom head tags from components
if (isset( $mainframe->_head['custom'] ))
{
	$head = array();
	foreach ($mainframe->_head['custom'] as $html) {
		$head[] = $html;
	}
	echo implode( "\n", $head ) . "\n";
}
?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<meta name="Generator" content="Joomla! Lavra Edition - Система управления порталом" />
<link rel="shortcut icon" href="<?php echo $mosConfig_live_site .'/favicon.ico';?>" />
</head>
<body onload="MM_preloadImages('images/help_f2.png','images/archive_f2.png','images/back_f2.png','images/cancel_f2.png','images/delete_f2.png','images/edit_f2.png','images/new_f2.png','images/preview_f2.png','images/publish_f2.png','images/save_f2.png','images/unarchive_f2.png','images/unpublish_f2.png','images/upload_f2.png')">

<div id="wrapper">
	<div id="header">
			<div id="joomla"><a href="index2.php"><img border="0" src="templates/joomla_admin/images/header_text.png" alt="Joomla! Lavra Edition" /></a></div>
	</div>
</div>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menubackgr" style="padding-left:5px;">
		<?php mosLoadAdminModule( 'fullmenu' );?>
	</td>
	<td class="menubackgr" align="right">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><a title="Пердпросмотр сайта" href="<?php echo $mosConfig_live_site;?>" target="_blank"><img src="../includes/js/ThemeOffice/preview.png" border="0"/></a></td>
		<td width="6">&nbsp;</td>
		<td><a title="Пердпросмотр сайта" href="<?php echo $mosConfig_live_site;?>" target="_blank">Предпросмотр</a></td>
	</tr>
</table>  </td>
	<td class="menubackgr" align="right">
		<div id="wrapper1">
			<?php mosLoadAdminModules( 'header', 2 );?>
		</div>
	</td>
	<td class="menubackgr" align="right" style="padding-right:5px;">
		<a href="index2.php?option=logout" style="color: #333333; font-weight: bold">
			Выйти</a>
		<strong><?php echo $my->username;?></strong>
	</td>
</tr>
</table>

<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">
		<?php mosLoadAdminModule( 'pathway' );?>
	</td>
	<td class="menudottedline" align="right">
		<?php mosLoadAdminModule( 'toolbar' );?>
	</td>
</tr>
</table>

<br />
<?php mosLoadAdminModule( 'mosmsg' );?>

<div align="center" class="centermain">
	<div class="main">
		<?php mosMainBody_Admin(); ?>
	</div>
</div>

<div align="center" class="footer">
	<table width="99%" border="0">
	<tr>
		<td align="center">
<table cellpadding="6">
	<tr>
		<td align="right">
			<a title="Официальный форум поддержки версий `Joomla! Lavra Edition`" href="http://joomla-support.ru/forum131.html"><img border="0" src="templates/joomla_admin/images/joomru.gif" /></a>
		</td>
		<td align="center"><a title="Дистрибутив разработан братией Свято-Троице-Сергиевой  Лавры" href="http://andyr.mrezha.ru/pay" target="_blank">Joomla! 1.0.15 Lavra Edition 2008
				<br/>
				Разработано братией Свято-Троице-Сергиевой Лавры &copy; 2008</a>
		</td>
		<td align="left">
			<a title="Официальный форум поддержки версий `Joomla! Lavra Edition`" href="http://joomlaforum.ru/index.php/board,120.0.html"><img border="0" src="templates/joomla_admin/images/joomlaforum.gif" /></a>
		</td>
	</tr>
</table>
				
			<?php
			if ( $mosConfig_debug ) {
				echo '<div class="smallgrey">';
				$tend = mosProfiler::getmicrotime();
				$totaltime = ($tend - $tstart);
				printf ("Страница сгенерирована за %f секунд", $totaltime);
				echo '</div>';
			}
			?>
		</td>
	</tr>
	</table>
</div>

<?php mosLoadAdminModules( 'debug' );?>
</body>
</html>
