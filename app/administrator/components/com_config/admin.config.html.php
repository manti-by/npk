<?php
/**
* @version $Id: admin.config.html.php 6070 2006-12-20 02:09:09Z robs $
* @package Joomla
* @subpackage Config
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Доступ запрещен' );

/**
* @package Joomla
* @subpackage Config
*/
class HTML_config {

	function showconfig( &$row, &$lists, $option) {
		global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_session_type, $mainframe;

		$tabs = new mosTabs(0);
		?>
		<script type="text/javascript">
		<!--
		function saveFilePerms() {
			var f = document.adminForm;
			if (f.filePermsMode0.checked)
				f.config_fileperms.value = '';
			else {
				var perms = 0;
				if (f.filePermsUserRead.checked) perms += 400;
				if (f.filePermsUserWrite.checked) perms += 200;
				if (f.filePermsUserExecute.checked) perms += 100;
				if (f.filePermsGroupRead.checked) perms += 40;
				if (f.filePermsGroupWrite.checked) perms += 20;
				if (f.filePermsGroupExecute.checked) perms += 10;
				if (f.filePermsWorldRead.checked) perms += 4;
				if (f.filePermsWorldWrite.checked) perms += 2;
				if (f.filePermsWorldExecute.checked) perms += 1;
				f.config_fileperms.value = '0'+''+perms;
			}
		}
		function changeFilePermsMode(mode) {
			if(document.getElementById) {
				switch (mode) {
					case 0:
						document.getElementById('filePermsValue').style.display = 'none';
						document.getElementById('filePermsTooltip').style.display = '';
						document.getElementById('filePermsFlags').style.display = 'none';
						break;
					default:
						document.getElementById('filePermsValue').style.display = '';
						document.getElementById('filePermsTooltip').style.display = 'none';
						document.getElementById('filePermsFlags').style.display = '';
				} // switch
			} // if
			saveFilePerms();
		}
		function saveDirPerms() {
			var f = document.adminForm;
			if (f.dirPermsMode0.checked)
				f.config_dirperms.value = '';
			else {
				var perms = 0;
				if (f.dirPermsUserRead.checked) perms += 400;
				if (f.dirPermsUserWrite.checked) perms += 200;
				if (f.dirPermsUserSearch.checked) perms += 100;
				if (f.dirPermsGroupRead.checked) perms += 40;
				if (f.dirPermsGroupWrite.checked) perms += 20;
				if (f.dirPermsGroupSearch.checked) perms += 10;
				if (f.dirPermsWorldRead.checked) perms += 4;
				if (f.dirPermsWorldWrite.checked) perms += 2;
				if (f.dirPermsWorldSearch.checked) perms += 1;
				f.config_dirperms.value = '0'+''+perms;
			}
		}
		function changeDirPermsMode(mode) 	{
			if(document.getElementById) {
				switch (mode) {
					case 0:
						document.getElementById('dirPermsValue').style.display = 'none';
						document.getElementById('dirPermsTooltip').style.display = '';
						document.getElementById('dirPermsFlags').style.display = 'none';
						break;
					default:
						document.getElementById('dirPermsValue').style.display = '';
						document.getElementById('dirPermsTooltip').style.display = 'none';
						document.getElementById('dirPermsFlags').style.display = '';
				} // switch
			} // if
			saveDirPerms();
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;

			// do field validation
			if (form.config_session_type.value != <?php echo $row->config_session_type; ?> ){
				if ( confirm('Вы уверены, что хотите изменить `Метод аутентификации сессии`? \n\n Это действие удалит все существующие сеансы. \n\n') ) {
					submitform( pressbutton );
				} else {
					return;
				}
			} else {
				submitform( pressbutton );
			}
		}
		//-->
		</script>
		<form action="index2.php" method="post" name="adminForm">
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="250"><table class="adminheading"><tr><th nowrap="nowrap" class="config">Общие установки</th></tr></table></td>
			<td width="270">
				<span class="componentheading">configuration.php is :
				<?php echo is_writable( '../configuration.php' ) ? '<b><font color="green"> доступен на запись</font></b>' : '<b><font color="red"> недоступен на запись</font></b>' ?>
				</span>
			</td>
			<?php
			if (mosIsChmodable('../configuration.php')) {
				if (is_writable('../configuration.php')) {
					?>
					<td>
						<input type="checkbox" id="disable_write" name="disable_write" value="1"/>
						<label for="disable_write">Защитить от записи после сохранения установок</label>
					</td>
					<?php
				} else {
					?>
					<td>
						<input type="checkbox" id="enable_write" name="enable_write" value="1"/>
						<label for="enable_write">Снять защиту от записи для сохранения установок</label>
					</td>
				<?php
				} // if
			} // if
			?>
		</tr>
		</table>
			<?php
		$tabs->startPane("configPane");
		$tabs->startTab("Сайт","site-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Сайт отключен:</td>
				<td><?php echo $lists['offline']; ?></td>
			</tr>
			<tr>
				<td valign="top">Сообщение, если сайт отключен вами:</td>
				<td><textarea class="text_area" cols="60" rows="2" style="width:500px; height:40px" name="config_offline_message"><?php echo $row->config_offline_message; ?></textarea><?php
					$tip = 'Сообщение, которое будет показало посетителям, если сайт отключен вами, например при техобслуживании';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td valign="top">Сообщение при системной ошибке:</td>
				<td><textarea class="text_area" cols="60" rows="2" style="width:500px; height:40px" name="config_error_message"><?php echo $row->config_error_message; ?></textarea><?php
					$tip = 'Сообщение, которое будет показало посетителям при ошибке подключения к БД';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Имя сайта:</td>
				<td><input class="text_area" type="text" name="config_sitename" size="50" value="<?php echo $row->config_sitename; ?>"/><font color="silver"> Лучше без кавычек...</font></td>
			</tr>
			<tr>
				<td>Показ неавторизованных ссылок:</td>
				<td><?php echo $lists['shownoauth']; ?><?php
					$tip = 'Если ДА, покажет ссылки на контент для класса Registered, если вы еще не авторизовались. Пользователю надо будет авторизоваться для доступа к этому контенту.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Разрешить регистрацию пользователей:</td>
				<td><?php echo $lists['allowUserRegistration']; ?><?php
					$tip = 'Если ДА, пользователи могут регистрироваться сами';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Использовать активацию аккаунтов:</td>
				<td><?php echo $lists['useractivation']; ?>
				<?php
					$tip = 'Если ДА, пользователю будет выслано письмо со ссылкой, по которой пройдет активация.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Требовать уникальный e-mail:</td>
				<td><?php echo $lists['uniquemail']; ?><?php
					$tip = 'Если ДА, требуется уникальный e-mail на каждую учетную запись';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Логин с сайта:</td>
				<td>
					<?php echo $lists['frontend_login']; ?>
					<?php
					$tip = 'Если `Нет`, запрещает страницу логина на сайте пока она не слинкована с пунктом меню. Также запрещает регистрацию пользователей (с морды сайта)';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Параметры пользователя:</td>
				<td>
					<?php echo $lists['frontend_userparams']; ?>
					<?php
					$tip = 'Если `Нет`, запрещает открытие параметров пользователей на сайте (с морды сайта)';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Режим отладки:</td>
				<td>
					<?php echo $lists['debug']; ?>
					<?php
					$tip = 'Если ДА, то показывает диагностическую информацию и SQL запросы';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Визуальный редактор:</td>
				<td><?php echo $lists['editor']; ?></td>
			</tr>
			<tr>
				<td>Длина списков:</td>
				<td>
					<?php echo $lists['list_limit']; ?>
					<?php
					$tip = 'Устанавливает умолчание для длины списков в админке';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Иконка сайта:</td>
				<td>
				<input class="text_area" type="text" name="config_favicon" size="20" value="<?php echo $row->config_favicon; ?>"/>
				<?php
				$tip = 'Если оставить пустым или файл не будет найден, будет использовано favicon.ico В КОРНЕ САЙТА!!! Я ее туда перенес! Так надо!';
				echo mosToolTip( $tip, 'Иконка -favicon.ico-' );
				?>			
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Локаль","Locale-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Язык:</td>
				<td><?php echo $lists['lang']; ?></td>
			</tr>
			<tr>
				<td width="185">Временная зона:</td>
				<td>
				<?php echo $lists['offset']; ?>
				<?php
				$tip = "Текущие дата/время отображаются как: " . mosCurrentDate(_DATE_FORMAT_LC2);
				echo mosToolTip($tip, 'Локаль');
				?>
				</td>
			</tr>
			<tr>
				<td width="185">Временная зона сервера:</td>
				<td>
				<input class="text_area" type="text" name="config_offset" size="15" value="<?php echo $row->config_offset; ?>" disabled="disabled"/>
				</td>
			</tr>
			<tr>
				<td width="185">Локаль:</td>
				<td>
				<input class="text_area" type="text" name="config_locale" size="15" value="<?php echo $row->config_locale; ?>"/>
				<font color=silver> для "Windows" локаль равна "ru", для хостинга пробуйте "ru_RU.CP1251"</font></td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Материалы","content-page");
			?>
			<table class="adminform">
			<tr>
				<td colspan="3">* Эти параметры управляют выводом элементов содержимого*<br/><br/></td>
			</tr>
			<tr>
				<td width="200">Заголовки как ссылки:</td>
				<td width="100"><?php echo $lists['link_titles']; ?></td>
				<td><?php
					$tip = 'Если ДА, заголовки материала будут являться ссылками на материал';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td width="200">Ссылка -Еще-:</td>
				<td width="150"><?php echo $lists['readmore']; ?></td>
				<td><?php
					$tip = 'Если стоит -Показать-, ссылка -Еще- будет показана при обрезке материала';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Рейтинг/Голосование:</td>
				<td><?php echo $lists['vote']; ?></td>
				<td><?php
					$tip = 'Если стоит -Показать-, система голосования будет включена для материалов';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Имя автора:</td>
				<td><?php echo $lists['hideAuthor']; ?></td>
				<td><?php
					$tip = 'Если стоит -Показать-, Будет показано имя автора материала.  Эта глобальная установка может быть переопределена в других местах.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Дата и время создания:</td>
				<td><?php echo $lists['hideCreateDate']; ?></td>
				<td><?php
					$tip = 'Если стоит -Показать-, будет показана дата и время создания материала. Эта глобальная установка может быть переопределена в других местах.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Дата и время изменения:</td>
				<td><?php echo $lists['hideModifyDate']; ?></td>
				<td><?php
					$tip = 'Если стоит -Показать-, будет показана дата и время изменения материала. Эта глобальная установка может быть переопределена в других местах.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Хиты:</td>
				<td><?php echo $lists['hits']; ?></td>
				<td><?php
					$tip = 'Если стоит -Показать-, будет показан счетчик обращений к каждому материалу.  Эта глобальная установка может быть переопределена в других местах.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Спрятать иконку PDF:</td>
				<td><?php echo $lists['hidePdf']; ?></td>
				<?php
				if (!is_writable( "$mosConfig_absolute_path/media/" )) {
					echo "<td align=\"left\">";
					echo mosToolTip('Опция недоступна если папка /media не доступна для записи');
					echo "</td>";
				} else {
					?>
					<td>&nbsp;</td>
					<?php
				}
				?>
			</tr>
			<tr>
				<td>Спрятать иконку Печати:</td>
				<td><?php echo $lists['hidePrint']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Спрятать иконку Email:</td>
				<td><?php echo $lists['hideEmail']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Отображать иконки:</td>
				<td><?php echo $lists['icons']; ?></td>
				<td><?php echo mosToolTip('Печать, PDF и Email показывать иконками или текстом'); ?></td>
			</tr>
			<tr>
				<td>Таблица содержания для многостраничных материалов:</td>
				<td><?php echo $lists['multipage_toc']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Кнопка -Назад-:</td>
				<td><?php echo $lists['back_button']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Навигация по содержимому:</td>
				<td><?php echo $lists['item_navigation']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Режим совместимости версий:</td>
				<td><?php echo $lists['itemid_compat']; ?></td>
				<td>&nbsp;</td>
			</tr>
			</table>
			<input type="hidden" name="config_multilingual_support" value="<?php echo $row->config_multilingual_support?>">
			<?php
		$tabs->endTab();
		$tabs->startTab("База данных","db-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">MySQL - имя хоста:</td>
				<td><input class="text_area" type="text" name="config_host" size="25" value="<?php echo $row->config_host; ?>"/></td>
			</tr>
			<tr>
				<td>MySQL - имя пользователя:</td>
				<td><input class="text_area" type="text" name="config_user" size="25" value="<?php echo $row->config_user; ?>"/></td>
			</tr>
			<tr>
				<td>MySQL - база данных:</td>
				<td><input class="text_area" type="text" name="config_db" size="25" value="<?php echo $row->config_db; ?>"/></td>
			</tr>
			<tr>
				<td>MySQL - префикс таблиц:</td>
				<td>
				<input class="text_area" type="text" name="config_dbprefix" size="10" value="<?php echo $row->config_dbprefix; ?>"/>
				&nbsp;<?php echo mosWarning('!! НЕ ИЗМЕНЯЙТЕ, ЕСЛИ У ВАС УЖЕ ЕСТЬ РАБОЧАЯ БАЗА ДАННЫХ. В ПРОТИВНОМ СЛУЧАЕ, ВЫ МОЖЕТЕ ПОТЕРЯТЬ К НЕЙ ДОСТУП !!'); ?>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Сервер","server-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Абсолютный путь:</td>
				<td width="450"><strong><?php echo $row->config_absolute_path; ?></strong></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>URL:</td>
				<td><strong><?php echo $row->config_live_site; ?></strong></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Секретное слово:</td>
				<td><strong><?php echo $row->config_secret; ?></strong></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>GZIP компрессия страниц:</td>
				<td>
				<?php echo $lists['gzip']; ?>
				<?php echo mosToolTip('Поддержка сжатия страниц перед отправкой (если доступно).'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Время жизни сессии:</td>
				<td>
				<input class="text_area" type="text" name="config_lifetime" size="10" value="<?php echo $row->config_lifetime; ?>"/>
				&nbsp;секунд&nbsp;
				<?php echo mosToolTip('Время автоотключения при  неактивности пользователя'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Время жизни сессии Админа:</td>
				<td>
				<input class="text_area" type="text" name="config_session_life_admin" size="10" value="<?php echo $row->config_session_life_admin; ?>"/>
				&nbsp;секунд&nbsp;
				<?php echo mosWarning('Автоотключение после этого времени неактивности <strong>admin/backend</strong> пользователя. Чем выше значение, тем ниже безопасность!'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Помнить просроченную страницу Админа:</td>
				<td>
				<?php echo $lists['admin_expired']; ?>
				<?php echo mosToolTip('Если сессия истекает в течение 10 минут со времени выхода, Выбудете перенаправлены  после входа на страницу, на которуя пытались (дальше - фиг понял что...)'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Метод авторизации сессии:</td>
				<td>
				<?php echo $lists['session_type']; ?>
				&nbsp;&nbsp;
				<?php echo mosWarning('Не изменяйте, если Вы не знаете параметров этого пункта!<br /><br /> Если у Вас есть пользователи использующие AOL или прокси-серверы, используйте - Уровень секретности 2 -' ); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Сообщения об ошибках:</td>
				<td><?php echo $lists['error_reporting']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>HELP - сервер:</td>
				<td><input class="text_area" type="text" name="config_helpurl" size="50" value="<?php echo $row->config_helpurl; ?>"/>&nbsp;&nbsp;
      <br/>Если поле не заполнено, то файлы справки будут браться из папки <span style="color: green; white-space: nowrap"><strong>http://ваш_сайт/help/</strong></span>
      <br/>Для подключения к интернет-серверу справки введите:<strong>
	  <br/><strong><a href="http://help.joomla.org" title="On-Line сервер помощи">http://help.joomla.org</a></strong> - полная алглийская версия справки
	  <br/><br/>
		</td>
			</tr>
			<tr>
				<?php
				$mode = 0;
				$flags = 0644;
				if ($row->config_fileperms!='') {
					$mode = 1;
					$flags = octdec($row->config_fileperms);
				} // if
				?>
				<td valign="top">Создание файлов:</td>
				<td>
					<fieldset><legend> Режим доступа к файлам </legend>
						<table cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td><input type="radio" id="filePermsMode0" name="filePermsMode" value="0" onclick="changeFilePermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
								<td><label for="filePermsMode0">Не менять CHMOD для новых файлов (использовать умолчание сервера)</label></td>
							</tr>
							<tr>
								<td><input type="radio" id="filePermsMode1" name="filePermsMode" value="1" onclick="changeFilePermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
								<td>
									<label for="filePermsMode1">Установить CHMOD для новых файлов</label>
									<span id="filePermsValue"<?php if (!$mode) echo ' style="display:none"'; ?>>
									to:	<input class="text_area" type="text" readonly="readonly" name="config_fileperms" size="4" value="<?php echo $row->config_fileperms; ?>"/>
									</span>
									<span id="filePermsTooltip"<?php if ($mode) echo ' style="display:none"'; ?>>
									&nbsp;<?php echo mosToolTip('Выберите этот пункт для установки CHMOD новых файлов'); ?>
									</span>
								</td>
							</tr>
							<tr id="filePermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
								<td>&nbsp;</td>
								<td>
									<table cellpadding="0" cellspacing="1" border="0">
										<tr>
											<td style="padding:0px">User:</td>
											<td style="padding:0px"><input type="checkbox" id="filePermsUserRead" name="filePermsUserRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsUserRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsUserWrite" name="filePermsUserWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsUserWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsUserExecute" name="filePermsUserExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="3"><label for="filePermsUserExecute">execute</label></td>
										</tr>
										<tr>
											<td style="padding:0px">Group:</td>
											<td style="padding:0px"><input type="checkbox" id="filePermsGroupRead" name="filePermsGroupRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsGroupRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsGroupWrite" name="filePermsGroupWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsGroupWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsGroupExecute" name="filePermsGroupExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" width="70"><label for="filePermsGroupExecute">execute</label></td>
											<td><input type="checkbox" id="applyFilePerms" name="applyFilePerms" value="1"/></td>
											<td nowrap="nowrap">
												<label for="applyFilePerms">
													Применить к существующим файлам
													&nbsp;<?php
													echo mosWarning(
														'Изменения коснутся <em>aвсех существующих файлов</em> на сайте.<br/>'.
													'<b>ИСПОЛЬЗУЙТЕ ЭТУ ОПЦИЮ С ОСТОРОЖНОСТЬЮ!</b>'
													);?>
												</label>
											</td>
										</tr>
										<tr>
											<td style="padding:0px">World:</td>
											<td style="padding:0px"><input type="checkbox" id="filePermsWorldRead" name="filePermsWorldRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsWorldRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsWorldWrite" name="filePermsWorldWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsWorldWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsWorldExecute" name="filePermsWorldExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="4"><label for="filePermsWorldExecute">execute</label></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<?php
				$mode = 0;
				$flags = 0755;
				if ($row->config_dirperms!='') {
					$mode = 1;
					$flags = octdec($row->config_dirperms);
				} // if
				?>
				<td valign="top">Создание каталогов:</td>
				<td>
					<fieldset><legend>Режим доступа к каталогам</legend>
						<table cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td><input type="radio" id="dirPermsMode0" name="dirPermsMode" value="0" onclick="changeDirPermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
								<td><label for="dirPermsMode0">Не менять режим CHMOD для новых каталогов (использовать умолчание сервера)</label></td>
							</tr>
							<tr>
								<td><input type="radio" id="dirPermsMode1" name="dirPermsMode" value="1" onclick="changeDirPermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
								<td>
									<label for="dirPermsMode1">Установить CHMOD для новых каталогов</label>
									<span id="dirPermsValue"<?php if (!$mode) echo ' style="display:none"'; ?>>
									to: <input class="text_area" type="text" readonly="readonly" name="config_dirperms" size="4" value="<?php echo $row->config_dirperms; ?>"/>
									</span>
									<span id="dirPermsTooltip"<?php if ($mode) echo ' style="display:none"'; ?>>
									&nbsp;<?php echo mosToolTip('Выберите этот пункт для установки CHMOD новых каталогов'); ?>
									</span>
								</td>
							</tr>
							<tr id="dirPermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
								<td>&nbsp;</td>
								<td>
									<table cellpadding="1" cellspacing="0" border="0">
										<tr>
											<td style="padding:0px">User:</td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsUserRead" name="dirPermsUserRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsUserRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsUserWrite" name="dirPermsUserWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsUserWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsUserSearch" name="dirPermsUserSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="3"><label for="dirPermsUserSearch">search</label></td>
										</tr>
										<tr>
											<td style="padding:0px">Group:</td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsGroupRead" name="dirPermsGroupRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsGroupRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsGroupWrite" name="dirPermsGroupWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsGroupWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsGroupSearch" name="dirPermsGroupSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" width="70"><label for="dirPermsGroupSearch">search</label></td>
											<td><input type="checkbox" id="applyDirPerms" name="applyDirPerms" value="1"/></td>
											<td nowrap="nowrap">
												<label for="applyDirPerms">
													Применить к существующим каталогам
													&nbsp;<?php
													echo mosWarning(
														'Checking here will apply the permission flags to <em>all existing directories</em> of the site.<br/>'.
														'<b>INAPPROPRIATE USAGE OF THIS OPTION MAY RENDER THE SITE INOPERATIVE!</b>'
													);?>
												</label>
											</td>
										</tr>
										<tr>
											<td style="padding:0px">World:</td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsWorldRead" name="dirPermsWorldRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsWorldRead">read</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsWorldWrite" name="dirPermsWorldWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsWorldWrite">write</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsWorldSearch" name="dirPermsWorldSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="3"><label for="dirPermsWorldSearch">search</label></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
				<td>&nbsp;</td>
			  </tr>
			<tr>
				<?php
				$rgmode = 0;
				if( defined( 'RG_EMULATION' ) ) {
					$rgmode = RG_EMULATION;
				}
				?>
				<td valign="top">Эмуляция режима `Register Globals`:</td>
				<td>
					<fieldset><legend>Эмуляция режима `Register Globals`</legend>
						<table cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td><input type="radio" id="rgemulation" name="rgemulation" value="0"<?php if (!$rgmode) echo ' checked="checked"'; ?>/></td>
								<td><label for="rgemulation">OFF - большая защищенность, но меньшая совместимость</label></td>
							</tr>
							<tr>
								<td><input type="radio" id="rgemulation" name="rgemulation" value="1"<?php if ($rgmode) echo ' checked="checked"'; ?>/></td>
								<td><label for="rgemulation">ON - большая совместимость, но меньшая защищенность</label></td>
							</tr>
							</tr>
						</table>
					</fieldset>
				</td>
				<td>&nbsp;</td>
			</tr>

			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Метаданные","metadata-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185" valign="top">Описание флага Meta для сайта:</td>
				<td><textarea class="text_area" cols="50" rows="3" style="width:500px; height:50px" name="config_MetaDesc"><?php echo $row->config_MetaDesc; ?></textarea></td>
			</tr>
			<tr>
				<td valign="top">Описание флага Meta Keywords:</td>
				<td><textarea class="text_area" cols="50" rows="3" style="width:500px; height:50px" name="config_MetaKeys"><?php echo $row->config_MetaKeys; ?></textarea></td>
			</tr>
			<tr>
				<td valign="top">Показывать Title Meta Tag:</td>
				<td>
				<?php echo $lists['MetaTitle']; ?>
				&nbsp;&nbsp;&nbsp;
				<?php echo mosToolTip('Включать в заголовок сайта -meta- содержимое -meta- тэгов материалов'); ?>
				</td>
			  	</tr>
			<tr>
				<td valign="top">Показывать Author Meta Tag:</td>
				<td>
				<?php echo $lists['MetaAuthor']; ?>
				&nbsp;&nbsp;&nbsp;
				<?php echo mosToolTip('Включать в заголовок сайта -meta- содержимое -meta- тэгов материалов'); ?>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Почта","mail-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Способ отправки почты:</td>
				<td><?php echo $lists['mailer']; ?></td>
			</tr>
			<tr>
				<td>E-Mail -от кого-:</td>
				<td><input class="text_area" type="text" name="config_mailfrom" size="50" value="<?php echo $row->config_mailfrom; ?>"/></td>
			</tr>
			<tr>
				<td>От -имя-:</td>
				<td><input class="text_area" type="text" name="config_fromname" size="50" value="<?php echo $row->config_fromname; ?>"/></td>
			</tr>
			<tr>
				<td>Путь к Sendmail:</td>
				<td><input class="text_area" type="text" name="config_sendmail" size="50" value="<?php echo $row->config_sendmail; ?>"/></td>
			</tr>
			<tr>
				<td>SMTP авторизация:</td>
				<td><?php echo $lists['smtpauth']; ?></td>
			</tr>
			<tr>
				<td>SMTP пользователь:</td>
				<td><input class="text_area" type="text" name="config_smtpuser" size="50" value="<?php echo $row->config_smtpuser; ?>"/></td>
			</tr>
			<tr>
				<td>SMTP пароль:</td>
				<td><input class="text_area" type="text" name="config_smtppass" size="50" value="<?php echo $row->config_smtppass; ?>"/></td>
			</tr>
			<tr>
				<td>SMTP хост:</td>
				<td><input class="text_area" type="text" name="config_smtphost" size="50" value="<?php echo $row->config_smtphost; ?>"/></td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Кэш","cache-page");
			?>
			<table class="adminform" border="0">
			<?php
			if (is_writeable($row->config_cachepath)) {
				?>
				<tr>
					<td width="185">Кэширование:</td>
					<td width="500"><?php echo $lists['caching']; ?></td>
					<td>&nbsp;</td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td>Папка кэша:</td>
				<td>
				<input class="text_area" type="text" name="config_cachepath" size="50" value="<?php echo $row->config_cachepath; ?>"/>
				<?php
				if (is_writeable($row->config_cachepath)) {
					echo mosToolTip('Текущая папка кэша <b>Доступна для записи</b>');
				} else {
					echo mosWarning('Текущая папка кэша <b>НЕ ДОСТУПНА ДЛЯ ЗАПИСИ</b> - смените режим доступа на CHMOD755 перед включением кэша');
				}
				?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Время жизни кэша:</td>
				<td><input class="text_area" type="text" name="config_cachetime" size="5" value="<?php echo $row->config_cachetime; ?>"/> секунд</td>
				<td>&nbsp;</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Статистика","stats-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Статистика:</td>
				<td width="100"><?php echo $lists['enable_stats']; ?></td>
				<td><?php echo mostooltip('Включить/выключить сбор статистики сайта'); ?></td>
			</tr>
			<tr>
				<td>Вести статистику запросов по дате:</td>
				<td><?php echo $lists['log_items']; ?></td>
				<td><span class="error"><?php echo mosWarning('ВНИМАНИЕ : В этом режиме записываются большие объемы данных!'); ?></span></td>
			</tr>
			<tr>
				<td>Статистика поисковых запросов:</td>
				<td><?php echo $lists['log_searches']; ?></td>
				<td>&nbsp;</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("SEO","seo-page");
			?>
			<table class="adminform">
			<tr>
				<td width="300"><strong>Оптимизация для поисковых систем</strong></td>
				<td width="100">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Дружественные ссылки (SEF URLs):</td>
				<td><?php echo $lists['sef']; ?>&nbsp;</td>
				<td><span class="error"><?php echo mosWarning('Только для Apache! Переименуйте htaccess.txt в .htaccess перед активацией'); ?></span></td>
			</tr>
			<tr>
				<td>Динамические заголовки страниц:</td>
				<td><?php echo $lists['pagetitles']; ?></td>
				<td><?php echo mosToolTip('Динамическое изменение заголовков страниц в зависимости от просматриваемого материала'); ?></td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->endPane();

		// show security setting check
		josSecurityCheck();
		?>

		<input type="hidden" name="option" value="<?php echo $option; ?>"/>
		<input type="hidden" name="config_absolute_path" value="<?php echo $row->config_absolute_path; ?>"/>
		<input type="hidden" name="config_live_site" value="<?php echo $row->config_live_site; ?>"/>
		<input type="hidden" name="config_secret" value="<?php echo $row->config_secret; ?>"/>
	  	<input type="hidden" name="task" value=""/>
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<script  type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}

}
?>