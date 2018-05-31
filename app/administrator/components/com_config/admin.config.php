<?php
/**
* @version $Id: admin.config.php 5950 2006-12-06 23:18:11Z facedancer $
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

if (!$acl->acl_check( 'administration', 'config', 'users', $my->usertype )) {
	mosRedirect( 'index2.php?', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'class' ) );
require_once( $mainframe->getPath( 'admin_html' ) );

switch ( $task ) {
	case 'apply':
	case 'save':
		saveconfig( $task );
		break;

	case 'cancel':
		mosRedirect( 'index2.php' );
		break;

	default:
		showconfig( $option );
		break;
}

/**
 * Show the configuration edit form
 * @param string The URL option
 */
function showconfig( $option) {
	global $database, $mosConfig_absolute_path, $mosConfig_editor;

	$row = new mosConfig();
	$row->bindGlobals();

	// compile list of the languages
	$langs 		= array();
	$menuitems 	= array();
	$lists 		= array();

// PRE-PROCESS SOME LISTS

	// -- Languages --

	if ($handle = opendir( $mosConfig_absolute_path . '/language/' )) {
		$i=0;
		while (false !== ($file = readdir( $handle ))) {
			if (!strcasecmp(substr($file,-4),".php") && $file != "." && $file != ".." && strcasecmp(substr($file,-11),".ignore.php")) {
				$langs[] = mosHTML::makeOption( substr($file,0,-4) );
			}
		}
	}

	// sort list of languages
	sort( $langs );
	reset( $langs );

	// -- Editors --

	// compile list of the editors
	$query = "SELECT element AS value, name AS text"
	. "\n FROM #__mambots"
	. "\n WHERE folder = 'editors'"
	. "\n AND published = 1"
	. "\n ORDER BY ordering, name"
	;
	$database->setQuery( $query );
	$edits = $database->loadObjectList();

	// -- Show/Hide --

	$show_hide = array(
		mosHTML::makeOption( 1, 'Скрыть' ),
		mosHTML::makeOption( 0, 'Показать' ),
	);

	$show_hide_r = array(
		mosHTML::makeOption( 0, 'Скрыть' ),
		mosHTML::makeOption( 1, 'Показать' ),
	);

	// -- menu items --

	$query = "SELECT id AS value, name AS text FROM #__menu"
	. "\n WHERE ( type='content_section' OR type='components' OR type='content_typed' )"
	. "\n AND published = 1"
	. "\n AND access = 0"
	. "\n ORDER BY name"
	;
	$database->setQuery( $query );
	$menuitems = array_merge( $menuitems, $database->loadObjectList() );


// SITE SETTINGS

	$lists['offline'] = mosHTML::yesnoRadioList( 'config_offline', 'class="inputbox"', $row->config_offline );

	if ( !$row->config_editor ) {
		$row->config_editor = '';
	}
	// build the html select list
	$lists['editor'] = mosHTML::selectList( $edits, 'config_editor', 'class="inputbox" size="1"', 'value', 'text', $row->config_editor );

	$listLimit = array(
		mosHTML::makeOption( 5, 5 ),
		mosHTML::makeOption( 10, 10 ),
		mosHTML::makeOption( 15, 15 ),
		mosHTML::makeOption( 20, 20 ),
		mosHTML::makeOption( 25, 25 ),
		mosHTML::makeOption( 30, 30 ),
		mosHTML::makeOption( 50, 50 ),
	);

	$lists['list_limit'] = mosHTML::selectList( $listLimit, 'config_list_limit', 'class="inputbox" size="1"', 'value', 'text', ( $row->config_list_limit ? $row->config_list_limit : 50 ) );

	$lists['frontend_login'] = mosHTML::yesnoRadioList( 'config_frontend_login', 'class="inputbox"', $row->config_frontend_login );

// DEBUG

	$lists['debug'] = mosHTML::yesnoRadioList( 'config_debug', 'class="inputbox"', $row->config_debug );

// DATABASE SETTINGS


// SERVER SETTINGS
	$lists['gzip'] = mosHTML::yesnoRadioList( 'config_gzip', 'class="inputbox"', $row->config_gzip );

	$session = array(
		mosHTML::makeOption( 0, 'Уровень секретности 3 - Умолчание и Высший' ),
		mosHTML::makeOption( 1, 'Уровень секретности 2 - Поддержка прокси IP' ),
		mosHTML::makeOption( 2, 'Уровень секретности 1 - Для обратной совместимости' )
	);

	$lists['session_type'] = mosHTML::selectList( $session, 'config_session_type', 'class="inputbox" size="1"', 'value', 'text', $row->config_session_type );

	$errors = array(
		mosHTML::makeOption( -1, 'Системное умолчание' ),
		mosHTML::makeOption( 0, 'Нет' ),
		mosHTML::makeOption( E_ERROR|E_WARNING|E_PARSE, 'Простой' ),
		mosHTML::makeOption( E_ALL , 'Максимальный' )
	);

	$lists['error_reporting'] = mosHTML::selectList( $errors, 'config_error_reporting', 'class="inputbox" size="1"', 'value', 'text', $row->config_error_reporting );

	$lists['admin_expired'] = mosHTML::yesnoRadioList( 'config_admin_expired', 'class="inputbox"', $row->config_admin_expired );

// LOCALE SETTINGS

	$lists['lang'] = mosHTML::selectList( $langs, 'config_lang', 'class="inputbox" size="1"', 'value', 'text', $row->config_lang );

	$timeoffset = array(
		mosHTML::makeOption( -12, '(UTC -12:00) Международная Западная линия смены даты'),
		mosHTML::makeOption( -11, '(UTC -11:00) Средняя Исландия, Самоа'),
		mosHTML::makeOption( -10, '(UTC -10:00) Гаваи'),
		mosHTML::makeOption( -9.5, '(UTC -09:30) Таиоха, Маркизовы острова'),
		mosHTML::makeOption( -9, '(UTC -09:00) Аляска'),
		mosHTML::makeOption( -8, '(UTC -08:00) Тихоокеанское время (США &amp; Канада)'),
		mosHTML::makeOption( -7, '(UTC -07:00) Горное время (США &amp; Канада)'),
		mosHTML::makeOption( -6, '(UTC -06:00) Центральное время (США &amp; Канада), Мехико'),
		mosHTML::makeOption( -5, '(UTC -05:00) Восточное время (США &amp; Канада), Богота, Лима'),
		mosHTML::makeOption( -4, '(UTC -04:00) Атлантическое время (Канада), Каракас'),
		mosHTML::makeOption( -3.5, '(UTC -03:30) Санта-Джонс, Ньюфаундленд и Лабрадор'),
		mosHTML::makeOption( -3, '(UTC -03:00) Бразилия, Буэнос Айрес, Джорджтаун'),
		mosHTML::makeOption( -2, '(UTC -02:00) Центральная Атлантика'),
		mosHTML::makeOption( -1, '(UTC -01:00 hour) Азоры'),
		mosHTML::makeOption( 0, '(UTC 00:00) Западная Европа, Лондон, Лиссабон, Касабланка'),
		mosHTML::makeOption( 1 , '(UTC +01:00 час) Берлин, Брюссель, Копенгаген, Мадоид, Париж'),
		mosHTML::makeOption( 2, '(UTC +02:00) Киев, Калининград, Южная Африка'),
		mosHTML::makeOption( 3, '(UTC +03:00) Москва, Питер, Багдад'),
		mosHTML::makeOption( 3.5, '(UTC +03:30) Тегеран'),
		mosHTML::makeOption( 4, '(UTC +04:00) Абу-Даби, Мускат, Баку, Тбилиси'),
		mosHTML::makeOption( 4.5, '(UTC +04:30) Кабул'),
		mosHTML::makeOption( 5, '(UTC +05:00) Екатеринбург, Исламабад, Карачи, Ташкент'),
		mosHTML::makeOption( 5.5, '(UTC +05:30) Бомбей, Калькутта, Мадрас, Нью Дели'),
		mosHTML::makeOption( 5.75, '(UTC +05:45) Катманду (Ох уж это Катманду...)'),
		mosHTML::makeOption( 6, '(UTC +06:00) Алматы, Дхака, Коломбо'),
		mosHTML::makeOption( 6.30, '(UTC +06:30) Йягон, Як цуп-цоп:)'),
		mosHTML::makeOption( 7, '(UTC +07:00) Бангкок, Ханой, Джакарта'),
		mosHTML::makeOption( 8, '(UTC +08:00) Пекин, Сингапур, Гонконг'),
		mosHTML::makeOption( 8.75, '(UTC +08:00) Австралия'),
		mosHTML::makeOption( 9, '(UTC +09:00) Токио, Сеул, Осака, Саппоро, Якутск'),
		mosHTML::makeOption( 9.5, '(UTC +09:30) Аделаида, Дарвин, Якутск'),
		mosHTML::makeOption( 10, '(UTC +10:00) Восточная Австралия, Гуам, Владивосток'),
		mosHTML::makeOption( 10.5, '(UTC +10:30) Остров Бога Хоу (Австралия)'),
		mosHTML::makeOption( 11, '(UTC +11:00) Магадан, Соломоновы острова, Новая Каледония'),
		mosHTML::makeOption( 11.30, '(UTC +11:30) Острова Норфолк'),
		mosHTML::makeOption( 12, '(UTC +12:00) Веллингтон, Фиджи, Камчатка'),
		mosHTML::makeOption( 12.75, '(UTC +12:45) Остров Чатхам'),
		mosHTML::makeOption( 13, '(UTC +13:00) Тонга'),
		mosHTML::makeOption( 14, '(UTC +14:00) Кирибатти'),
	);

	$lists['offset'] = mosHTML::selectList( $timeoffset, 'config_offset_user', 'class="inputbox" size="1"', 'value', 'text', $row->config_offset_user );

// MAIL SETTINGS

	$mailer = array(
		mosHTML::makeOption( 'mail', 'Функция mail в PHP' ),
		mosHTML::makeOption( 'sendmail', 'Sendmail' ),
		mosHTML::makeOption( 'smtp', 'SMTP сервер' )
	);
	$lists['mailer'] 	= mosHTML::selectList( $mailer, 'config_mailer', 'class="inputbox" size="1"', 'value', 'text', $row->config_mailer );

	$lists['smtpauth'] 	= mosHTML::yesnoRadioList( 'config_smtpauth', 'class="inputbox"', $row->config_smtpauth );


// CACHE SETTINGS

	$lists['caching'] 	= mosHTML::yesnoRadioList( 'config_caching', 'class="inputbox"', $row->config_caching );


// USER SETTINGS

	$lists['allowUserRegistration'] = mosHTML::yesnoRadioList( 'config_allowUserRegistration', 'class="inputbox"',	$row->config_allowUserRegistration );

	$lists['useractivation'] 		= mosHTML::yesnoRadioList( 'config_useractivation', 'class="inputbox"',	$row->config_useractivation );

	$lists['uniquemail'] 			= mosHTML::yesnoRadioList( 'config_uniquemail', 'class="inputbox"',	$row->config_uniquemail );

	$lists['shownoauth'] 			= mosHTML::yesnoRadioList( 'config_shownoauth', 'class="inputbox"', $row->config_shownoauth );

	$lists['frontend_userparams']	= mosHTML::yesnoRadioList( 'config_frontend_userparams', 'class="inputbox"', $row->config_frontend_userparams );

// META SETTINGS

	$lists['MetaAuthor']			= mosHTML::yesnoRadioList( 'config_MetaAuthor', 'class="inputbox"', $row->config_MetaAuthor );

	$lists['MetaTitle'] 			= mosHTML::yesnoRadioList( 'config_MetaTitle', 'class="inputbox"', $row->config_MetaTitle );


// STATISTICS SETTINGS

	$lists['log_searches'] 			= mosHTML::yesnoRadioList( 'config_enable_log_searches', 'class="inputbox"', $row->config_enable_log_searches );

	$lists['enable_stats'] 			= mosHTML::yesnoRadioList( 'config_enable_stats', 'class="inputbox"', $row->config_enable_stats );

	$lists['log_items']	 			= mosHTML::yesnoRadioList( 'config_enable_log_items', 'class="inputbox"', $row->config_enable_log_items );


// SEO SETTINGS

	$lists['sef'] 					= mosHTML::yesnoRadioList( 'config_sef', 'class="inputbox" onclick="javascript: if (document.adminForm.config_sef[1].checked) { alert(\'Не забудьте переименовать htaccess.txt в .htaccess\') }"', $row->config_sef );

	$lists['pagetitles'] 			= mosHTML::yesnoRadioList( 'config_pagetitles', 'class="inputbox"', $row->config_pagetitles );


// CONTENT SETTINGS

	$lists['link_titles'] 			= mosHTML::yesnoRadioList( 'config_link_titles', 'class="inputbox"', $row->config_link_titles );

	$lists['readmore'] 				= mosHTML::RadioList( $show_hide_r, 'config_readmore', 'class="inputbox"', $row->config_readmore, 'value', 'text' );

	$lists['vote'] 					= mosHTML::RadioList( $show_hide_r, 'config_vote', 'class="inputbox"', $row->config_vote, 'value', 'text' );



	$lists['hideAuthor'] 			= mosHTML::RadioList( $show_hide, 'config_hideAuthor', 'class="inputbox"', $row->config_hideAuthor, 'value', 'text' );

	$lists['hideCreateDate'] 		= mosHTML::RadioList( $show_hide, 'config_hideCreateDate', 'class="inputbox"', $row->config_hideCreateDate, 'value', 'text' );

	$lists['hideModifyDate'] 		= mosHTML::RadioList( $show_hide, 'config_hideModifyDate', 'class="inputbox"', $row->config_hideModifyDate, 'value', 'text' );

	$lists['hits'] 					= mosHTML::RadioList( $show_hide_r, 'config_hits', 'class="inputbox"', $row->config_hits, 'value', 'text' );

	if (is_writable( "$mosConfig_absolute_path/media/" )) {
		$lists['hidePdf'] 			= mosHTML::RadioList( $show_hide, 'config_hidePdf', 'class="inputbox"', $row->config_hidePdf, 'value', 'text' );
	} else {
		$lists['hidePdf'] 			= '<input type="hidden" name="config_hidePdf" value="1" /><strong>Скрыть</strong>';
	}

	$lists['hidePrint'] 			= mosHTML::RadioList( $show_hide, 'config_hidePrint', 'class="inputbox"', $row->config_hidePrint, 'value', 'text' );

	$lists['hideEmail'] 			= mosHTML::RadioList( $show_hide, 'config_hideEmail', 'class="inputbox"', $row->config_hideEmail, 'value', 'text' );

	$lists['icons'] 				= mosHTML::RadioList( $show_hide_r, 'config_icons', 'class="inputbox"', $row->config_icons, 'value', 'text' );

	$lists['back_button'] 			= mosHTML::RadioList( $show_hide_r, 'config_back_button', 'class="inputbox"', $row->config_back_button, 'value', 'text' );

	$lists['item_navigation'] 		= mosHTML::RadioList( $show_hide_r, 'config_item_navigation', 'class="inputbox"', $row->config_item_navigation, 'value', 'text' );

	$lists['multipage_toc'] 		= mosHTML::RadioList( $show_hide_r, 'config_multipage_toc', 'class="inputbox"', $row->config_multipage_toc, 'value', 'text' );

	$itemid_compat = array(
		mosHTML::makeOption( '11', 'Joomla! 1.0.11 или ниже' ),
		mosHTML::makeOption( '0', 'Joomla! 1.0.12 или более поздния версия' ),
	);
	$lists['itemid_compat'] 		= mosHTML::selectList( $itemid_compat, 'config_itemid_compat', 'class="inputbox" size="1"', 'value', 'text', $row->config_itemid_compat );

// SHOW EDIT FORM

	HTML_config::showconfig( $row, $lists, $option );
}

/**
 * Save the configuration
 */
function saveconfig( $task ) {
	global $database, $mosConfig_absolute_path, $mosConfig_password, $mosConfig_session_type;

	josSpoofCheck();

	$row = new mosConfig();
	if (!$row->bind( $_POST )) {
		mosRedirect( 'index2.php', $row->getError() );
	}

	// if Session Authentication Type changed, delete all old Frontend sessions only - which used old Authentication Type
	if ( $mosConfig_session_type != $row->config_session_type ) {
		$past = time();
		$query = "DELETE FROM #__session"
		. "\n WHERE time < " . $database->Quote( $past )
		. "\n AND ("
		. "\n ( guest = 1 AND userid = 0 ) OR ( guest = 0 AND gid > 0 )"
		. "\n )"
		;
		$database->setQuery( $query );
		$database->query();
	}

	$server_time 			= date( 'O' ) / 100;
	$offset 				= $_POST['config_offset_user'] - $server_time;
	$row->config_offset 	= $offset;

	//override any possible database password change
	$row->config_password 	= $mosConfig_password;

	// handling of special characters
	$row->config_sitename			= htmlspecialchars( $row->config_sitename, ENT_QUOTES );

	// handling of quotes (double and single) and amp characters
	// htmlspecialchars not used to preserve ability to insert other html characters
	$row->config_offline_message	= ampReplace( $row->config_offline_message );
	$row->config_offline_message	= str_replace( '"', '&quot;', $row->config_offline_message );
	$row->config_offline_message	= str_replace( "'", '&#039;', $row->config_offline_message );

	// handling of quotes (double and single) and amp characters
	// htmlspecialchars not used to preserve ability to insert other html characters
	$row->config_error_message		= ampReplace( $row->config_error_message );
	$row->config_error_message		= str_replace( '"', '&quot;', $row->config_error_message );
	$row->config_error_message		= str_replace( "'", '&#039;', $row->config_error_message );

	$config = "<?php \n";

	$RGEmulation = intval( mosGetParam( $_POST, 'rgemulation', 0 ) );
	$config .= "if(!defined('RG_EMULATION')) { define( 'RG_EMULATION', $RGEmulation ); }\n";

	$config .= $row->getVarText();
	$config .= "setlocale (LC_TIME, \$mosConfig_locale);\n";
	$config .= '?>';

	$fname = $mosConfig_absolute_path . '/configuration.php';

	$enable_write 	= intval( mosGetParam( $_POST, 'enable_write', 0 ) );
	$oldperms 		= fileperms($fname);
	if ( $enable_write ) {
		@chmod( $fname, $oldperms | 0222);
	}

	if ( $fp = fopen($fname, 'w') ) {
		fputs($fp, $config, strlen($config));
		fclose($fp);
		if ($enable_write) {
			@chmod($fname, $oldperms);
		} else {
			if (mosGetParam($_POST,'disable_write',0))
				@chmod($fname, $oldperms & 0777555);
		} // if

		$msg = 'Конфигурация была успешно обновлена';

		// apply file and directory permissions if requested by user
		$applyFilePerms = mosGetParam($_POST,'applyFilePerms',0) && $row->config_fileperms!='';
		$applyDirPerms = mosGetParam($_POST,'applyDirPerms',0) && $row->config_dirperms!='';
		if ($applyFilePerms || $applyDirPerms) {
			$mosrootfiles = array(
				'administrator',
				'cache',
				'components',
				'images',
				'language',
				'mambots',
				'media',
				'modules',
				'templates',
				'configuration.php'
			);
			$filemode = NULL;

			if ( $applyFilePerms ) {
				$filemode = octdec( $row->config_fileperms );
			}

			$dirmode = NULL;

			if ( $applyDirPerms ) {
				$dirmode = octdec( $row->config_dirperms );
			}

			foreach ($mosrootfiles as $file) {
				mosChmodRecursive( $mosConfig_absolute_path.'/'.$file, $filemode, $dirmode );
			}
		} // if

		switch ( $task ) {
			case 'apply':
				mosRedirect( 'index2.php?option=com_config&hidemainmenu=1', $msg );
				break;

			case 'save':
			default:
				mosRedirect( 'index2.php', $msg );
				break;
		}
	} else {
		if ($enable_write) {
			@chmod( $fname, $oldperms );
		}
		mosRedirect( 'index2.php', 'Обнаружена ошибка! Не могу открыть файл конфигурации на запись!' );
	}
}
?>