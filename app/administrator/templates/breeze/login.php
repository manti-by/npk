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

ob_start("jw_minted");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title><?php echo $mosConfig_sitename; ?> | Панель управления</title>
<style type="text/css">
@import url(templates/breeze/css/minted.php);
</style>
<script language="javascript" type="text/javascript">
<!--
function setFocus() {document.loginForm.usrname.select();document.loginForm.usrname.focus();}
-->
</script>
<![if !IE]>
<script type="text/javascript" src="templates/breeze/js/fat.js"></script>
<![endif]>


</head>
<body class="login" onload="setFocus();">
<div id="minted">
  <div id="header">
    <div id="hc">
      <div id="hl">
        <div id="hr">
          <div id="home"><a href="index.php" title="<?php echo $login_index; ?>">&nbsp;</a></div>
        </div>
      </div>
    </div>
  </div>
  <div id="content_wrapper">
    <div id="inner">
      <?php include_once($mosConfig_absolute_path.'/administrator/modules/mod_mosmsg.php'); ?>
<noscript>
Внимание! Javascript должен быть разрешен для нормального функционирования Панели управления
</noscript>
      <div class="login_credentials">
        <h1>Вход</h1>
        <form action="index.php" method="post" name="loginForm" id="loginForm">
          <label>Имя</label>
          <input name="usrname" type="text" class="inputbox" />
          <label>Пароль</label>
          <input name="pass" type="password" class="inputbox" />
          <div class="enter">
            <div class="enter_inner">
              <input type="submit" name="submit" value="Войти" />
            </div>       
          </div>
          <?php if ($_VERSION->PRODUCT=="Mambo") { ?>
          <input type="hidden" name="adminside" value="1" />
          <input type="hidden" name="option" value="login" />
          <?php } ?>
        </form>
        <div id="welcometext"><h3>Добро пожаловать!</h3> Используйте верные данные для входа в панель управления.</div>
        <div><a href="<?php echo $mosConfig_live_site; ?>/index.php" title="На главную сайта">Вернуться на главную сайта.</a></div>


      </div>
    </div>
  </div>
</div>
<div class="clr"></div>
	</div>
</div>
<div id="break"></div>
<div id="copy"><?php echo $mosConfig_sitename; ?><br />
  </div>
  </div>

</body>
</html>