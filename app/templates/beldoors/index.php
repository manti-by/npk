<?php
  defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );
  $iso = split( '=', _ISO );echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <?php mosShowHead(); ?>
  <?php if ( $my->id ) {initEditor();} ?>
  
  <meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
  <?php
    $templ = $mosConfig_live_site."/templates/".$cur_template;
    require("mysplitcssmenu.php");
    echo "<link rel=\"stylesheet\" href=\"$templ/css/template_css.css\" type=\"text/css\"/>" ;
    echo "<link rel=\"shortcut icon\" href=\"$templ/favicon.ico\" />" ;
  ?>

<!--[if IE 6.0000]>
  <?php echo "<link rel=\"stylesheet\" href=\"$templ/css/ie6.css\" type=\"text/css\"/>" ;?>
<![endif]-->
    <meta name='yandex-verification' content='4cf6d8d5971987c5' />
    <meta name="google-site-verification" content="Zfk4SlqpaMeHtE9S7i6-iXKfoB_fIiudzJGq7z-yNy8" />
</head>

<body>
<!--LiveInternet counter--><script type="text/javascript"><!--
new Image().src = "//counter.yadro.ru/hit?r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,80))+
";"+Math.random();//--></script><!--/LiveInternet-->

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td class="topimage">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="mainbody" align="center">
    
      <table border="0" cellpadding="0" cellspacing="0" class="maintable">
        <tr>
          <td colspan="2" height="210">
          </td>
        </tr>
      
      <!--pathway & left/right modules-->
        <tr>
            <td class="pathway"><?php mosPathway(); ?></td>
            <td rowspan="2" class="rightmod" width="200"><?php mosLoadModules ( 'right' ); ?></td>
        </tr>
        
      <!--top modules-->
        <?php if (mosCountModules('top')) { ?>
        <tr>
            <td colspan="2"><?php mosLoadModules ( 'top' ); ?></td></tr>
        <?php }?>
        
      <!--mainbody-->
        <tr>
            <td class="content" width="680"><div class="content-wrapper"><?php mosMainBody(); ?></div></td>
        </tr>
        
      <!--bottom modules-->
        <?php if (mosCountModules('bottom')) { ?>
        <tr>
            <td colspan="2"><?php mosLoadModules ( 'bottom' ); ?></td></tr>
        <?php }?>
        
      </table>
      
    </td>
  </tr>
  <tr height="115">
      <td class="footer" colspan="3">
          <span style='float:right'>
            <!--LiveInternet logo-->
                <a href="http://www.liveinternet.ru/click"
                target="_blank"><img src="//counter.yadro.ru/logo?44.5"
                title="LiveInternet"
                alt="" border="0" width="31" height="31"/></a>
            <!--/LiveInternet-->
          </span>
          211440, г.Новополоцк, улица Янки Купалы д.12, тел/факс (8 0214) 75-47-57, моб. (8 029) 121-36-01, НП-Комплекс &copy; 2009.<br>
          <a href="http://manti.by">Разработка и дизайн</a> Александр Чайка a.k.a. Manti&reg; 2006-2014. Вопросы по работе сайта: <a href="mailto:manti.by@gmail.com">manti.by@gmail.com</a><br>
          <div class="banner">
              <?php 
                  if (mosCountModules('banner')) {
                      mosLoadComponent( "banners");
                  }
              ?>
         </div>
    </td>
  </tr>
</table>
</td></tr>
</table>
</body>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26454412-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</html>
