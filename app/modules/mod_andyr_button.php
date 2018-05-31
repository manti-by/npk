<?php
/*******************************************************************************
*  11.09.2005
*  Модуль для CMS "Mambo"/"Joomla" - mod_AndyR_button  v.1.0
*
*  Модуль предназначен для построения системы толл-баров основанных
*  на графических изображениях и ссылках.Для построения системы
*  толл-баров используйте один установленный модуль путем создания
*  его копий для каждой требуемой кнопки толл-бара.
*
*  AndyR - mailto:andyr@mrezha.ru
*  Сайт поддержки пользователей  CMS "Mambo"/"Joomla"
*  - http://andyr.mrezha.ru
*
*  Форум поддержки пользователей CMS "Mambo"/"Joomla"
*  - http://andyr.mrezha.ru/smf
*
*******************************************************************************/
defined( '_VALID_MOS' ) or die( 'Прямой вызов этого файла не разрешается.' );
$image = $params->get( 'image' );
$text = $params->get( 'text' );
$link = $params->get( 'link' );
$title= $params->get( 'title' );
$border= $params->get( 'border' );
$align=$params->get( 'align' );
if ($border=='') {$border='0';} ;
$close_tag='';$br='';$imf_link='';$close_img_link='';
#echo '<hr class="fullline">';
if ($link<>''){$img_link="<a textdecoration=none title=\"$title\"  href=\"$link\">";$close_img_link='</a>';};
$s  = $img_link."<div align=><img border=0 src=".$mosConfig_live_site."/images/stories/icons/".$image."></div>".$close_img_link;
if ($text<>''){$st=$img_link.$text.$close_img_link;$br='<br>';}
?>
<table border="<?php echo "$border";?>" width="100%" style="border-collapse: collapse"><tr><td align="<?php echo $align; ?>""><?php echo $st.$br.$s.$close_tag; ?></td></tr></table>
