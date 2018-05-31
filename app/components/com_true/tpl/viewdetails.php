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
?>

<a name="top_tg"></a>
<div class="dt_image_title">

	<?php if ($tpl_author) { ?>
		<span class="tg_author">
		<strong><?php echo JText::_('TG_AUTHOR');?> : </strong><?php echo $tpl_author." | </span>"; } ?>
	<!-- Количество просмотров изображения  -->
	<?php if($tpl_count) { ?>
		<span class="tg_author">
		<strong><?php echo JText::_('TG_HITS'); ?> : </strong><?php echo $tpl_count."</span>"; }?>
</div>

<!-- Рейтинг для изображения -->
	<?php if ($tpl_votes_start) { ?>
		<div style="margin: 5px 15px;">
			<?php echo $tpl_votes_start.$tpl_votes_medium.$tpl_votes_end; ?>
    	</div>
	<?php } ?>

<table width="680" border="0" cellspacing="0" cellpadding="4" style="border-bottom: 1px dotted #AAA; padding-bottom: 5px; margin-bottom: 10px;">

<!-- Изображение с кнопкой редактирования для автора-->
	<tr>
	    <!-- Навигация туда -->
		<td align="right" class="dt6" width="20"><?php echo $prev_image; ?></td>
		
		<td align="center" class="tg_image">
			<!-- картинка для среднего эскиза -->
				<?php echo $mediumimg; ?>
		</td>
		<!-- Навигация сюда -->
		<td align="left" class="dt5" width="20"><?php echo $next_image; ?></td>
	</tr>
	
<!-- рисуем дополнительные изображения в виде карусели -->
    <?php if ($tpl_carusel) { ?>
    <tr>
        <td align="center" colspan="3">
            <?php echo $tpl_carusel; ?>
        </td>
    </tr>
    <?php } ?>
</table>
<!-- начало дива для сворачивания подробностей-->

	<!-- Детали изображения  -->
	<?php if($ad_showdetail) { ?>
		<div class="dt_image_title"><strong><?php echo $imgtitle; ?></strong></div>

	<table width="100%" border="0" cellspacing="0" cellpadding="4" style="margin: 5px 15px;">

   	<!-- Описание изображения  -->
    	<?php if($tpl_imgtext) { ?>
    		<tr class="sectiontableentry1">
			 <td colspan="2" valign="middle" style="padding-right: 30px;"><?php echo $tpl_imgtext; ?><br></td>
        	</tr>

  	<!-- Дата создания изображения  -->
	<?php } if($tpl_date) { ?>
    		<tr class="sectiontableentry2">
        		<td width="20%" valign="middle"><strong><?php echo JText::_('TG_DATE_ADD'); ?> : </strong></td>
			<td valign="middle"><?php echo $tpl_date; ?></td>
		</tr>

  	<!-- Размер изображения  -->
	<?php } if ($tpl_size) {?>
		<tr class="sectiontableentry1">
        		<td width="20%" valign="middle"><strong><?php echo JText::_('TG_SIZE'); ?> : </strong></td>
			<td valign="middle"> <?php echo $tpl_size; ?></td>
		</tr>

  	<!-- Размер файла изображения  -->
	<?php } if ($tpl_filesize) { ?>
		<tr class="sectiontableentry2">
        		<td width="20%" valign="top"><strong><?php echo JText::_('TG_FILESIZE'); ?> : </strong></td>
			<td valign="middle"><?php echo $tpl_filesize; ?></td>
		</tr>

  	<!-- Поле №1-->
	<?php } if ($tpl_field1) {?>
		<tr class="sectiontableentry1">
        		<td width="20%" valign="top"><strong><?php echo JText::_('TG_FIELD1'); ?> : </strong></td>
			<td valign="middle"><?php echo $tpl_field1; ?></td>
		</tr>

  	<!-- Поле №2-->
	<?php } if ($tpl_field2) { ?>
		<tr class="sectiontableentry2">
        	<td width="20%" valign="top"><strong><?php echo JText::_('TG_FIELD2'); ?> : </strong></td>
			<td valign="middle"><?php echo $tpl_field2; ?></td>
		</tr>

  	<!-- Поле №3-->
	<?php } if ($tpl_field3) { ?>
		<tr class="sectiontableentry1">
        	<td width="20%" valign="top"><strong><?php echo JText::_('TG_FIELD3'); ?> : </strong></td>
			<td valign="middle"><?php echo $tpl_field3; ?></td>
		</tr>

  	<!-- Поле №4-->
	<?php } if ($tpl_field4) { ?>
		<tr class="sectiontableentry2">
        	<td width="20%" valign="top"><strong><?php echo JText::_('TG_FIELD4'); ?> : </strong></td>
			<td valign="middle"><?php echo $tpl_field4; ?></td>
		</tr>

  	<!-- Поле №5-->
	<?php } if ($tpl_field5) { ?>
		<tr class="sectiontableentry1">
        	<td width="20%" valign="top"><strong><?php echo JText::_('TG_FIELD5'); ?> : </strong></td>
			<td valign="middle"><?php echo $tpl_field5; ?></td>
		</tr>
	<?php } ?>
	</table>
	<?php } ?>
	<?php if ($tpl_code) { ?>
		<div class="dt_image_title"><?php echo JText::_('TG_BB_HTML'); ?></div>
		<div style="margin: 5px 15px;"><?php echo $tpl_code; ?></div>
	<?php } ?>
	<!-- -->
	<?php echo $tpl_tell_friend; ?>
	<!-- блок комментариев -->
	<?php echo $showcomments; ?>

<!-- конец дива для сворачивания подробностей-->
<?php echo $tpl_toggle_end; ?>
<?php
?>