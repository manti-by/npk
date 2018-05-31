<?php
/*
// "Breeze" Administrator Template for Joomla 1.0.x - Version 1.0
// Based on "Minted One-Point-Five" Administrator Template for Joomla 1.0.x & Mambo 4.6.x - Version 2.3 http://www.joomlaworks.gr
// License: http://www.gnu.org/copyleft/gpl.html
// Author: venz
// Copyright (c) 2008 venzdesign.com - http://www.venzdesign.com
// *** Last update: April 9th, 2008 ***
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Доступ закрыт' );

$tstart = mosProfiler::getmicrotime();

// Template API
require($mosConfig_absolute_path.'/administrator/templates/breeze/configuration.php');

ob_start("jw_minted");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $mosConfig_sitename; ?> | Панель управления</title>
<link rel="shortcut icon" href="<?php echo $mosConfig_live_site .'/favicon.ico';?>" />
<link rel="stylesheet" href="templates/breeze/css/template_css.css" type="text/css" />
<link rel="stylesheet" href="templates/breeze/css/theme.css" type="text/css" />
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/js/JSCookMenu_mini.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/administrator/includes/js/ThemeOffice/theme.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/js/joomla.javascript.js" type="text/javascript"></script>
<?php
{
	echo '<script type="text/javascript" src="templates/breeze/js/minted.php"></script>';
	
}


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
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name="Generator" content="Joomla! Lavra Edition - Система управления порталом" />
<script type="text/javascript" src="templates/minted_one-point-five/js/minted.php"></script>
</head>
<body class="<?php echo $option;?>">
<div id="minted">
  <div id="header"><div id="version">Панель управления&nbsp; <strong>RE 1.0.12</strong></div>
    <div id="hc">
      <div id="hl">
        <div id="hr">
          <div id="home"><a href="index2.php" title="На главную">&nbsp;</a></div>
        </div>
      </div>
    </div>
  </div>
  <div id="content_wrapper">
    <div class="menubar">
      <div class="mod_fullmenu">
        <?php mosLoadAdminModule( 'fullmenu' );?>
      </div>
      <div class="logout">
      	<a href="index2.php?option=logout">Выйти</a><?php echo $my->username;?>
      </div>
      <div class="mod_header">
      <a href="<?php echo $mosConfig_live_site; ?>/index.php" target="_blank" title="Предпросмотр сайта" style="margin-right:15px;"><img src="../includes/js/ThemeOffice/preview.png" border="0" align="middle"/>Просмотр</a>
        <?php mosLoadAdminModules( 'header', 2 );?>
      </div>

      <div class="clr"></div>
    </div>
    <div class="menubar">
      <table class="pathway_toolbar white">
        <tr>
          <td class="mod_pathway"><?php if ( $my->gid > 24 ) { mosLoadAdminModule( 'pathway' ); } ?></td>
          <td class="menudottedline" align="right">
		<?php mosLoadAdminModule( 'toolbar' );?>
	</td>
      </table>
      <div class="clr"></div>
    </div>
    <div id="inner">
     	<?php mosMainBody_Admin(); ?>
      <div class="clr"></div>
    </div>
  </div>
  <div class="footer">

			<?php
			if ( $mosConfig_debug ) {
				echo '<div class="smallgrey">';
				$tend = mosProfiler::getmicrotime();
				$totaltime = ($tend - $tstart);
				printf ("Страница сгененированна за %f секунд", $totaltime);
				echo '</div>';
			}
			?>
<div id="copy"><?php echo $mosConfig_sitename; ?><br />
  </div>
</div>

<?php mosLoadAdminModules( 'debug' );?>
</body>
</html>