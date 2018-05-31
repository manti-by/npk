<?php
/**
* @version $Id: mod_fullmenu.php 9998 2008-02-07 11:36:41Z eddieajau $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Доступ запрещен' );

if (!defined( '_JOS_FULLMENU_MODULE' )) {
	/** ensure that functions are declared only once */
	define( '_JOS_FULLMENU_MODULE', 1 );

	/**
	* Full DHTML Admnistrator Menus
	* @package Joomla
	*/
	class mosFullAdminMenu {
		/**
		* Show the menu
		* @param string The current user type
		*/
		function show( $usertype='' ) {
			global $acl, $database;
			global $mosConfig_live_site, $mosConfig_enable_stats, $mosConfig_caching;

			// cache some acl checks
			$canConfig 			= $acl->acl_check( 'administration', 'config', 'users', $usertype );

			$manageTemplates 	= $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_templates' );
			$manageTrash 		= $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_trash' );
			$manageMenuMan 		= $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_menumanager' );
			$manageLanguages 	= $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_languages' );
			$installModules 	= $acl->acl_check( 'administration', 'install', 'users', $usertype, 'modules', 'all' );
			$editAllModules 	= $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'modules', 'all' );
			$installMambots 	= $acl->acl_check( 'administration', 'install', 'users', $usertype, 'mambots', 'all' );
			$editAllMambots 	= $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'mambots', 'all' );
			$installComponents 	= $acl->acl_check( 'administration', 'install', 'users', $usertype, 'components', 'all' );
			$editAllComponents 	= $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'components', 'all' );
			$canMassMail 		= $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_massmail' );
			$canManageUsers 	= $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_users' );

			$query = "SELECT a.id, a.title, a.name"
			. "\n FROM #__sections AS a"
			. "\n WHERE a.scope = 'content'"
			. "\n GROUP BY a.id"
			. "\n ORDER BY a.ordering"
			;
			$database->setQuery( $query );
			$sections = $database->loadObjectList();

			$menuTypes = mosAdminMenus::menutypes();
			?>
			<div id="myMenuID"></div>
			<script language="JavaScript" type="text/javascript">
			var myMenu =
			[
			<?php
		// Home Sub-Menu
	?>			[null,'Главная','index2.php',null,'Панель управления'],
				_cmSplit,
				<?php
		// Site Sub-Menu
	?>			[null,'Сайт',null,null,'Управление сайтом',
	<?php
				if ($canConfig) {
	?>				['<img src="../includes/js/ThemeOffice/config.png" />','Общие настройки','index2.php?option=com_config&hidemainmenu=1',null,'Общие настройки'],
	<?php
				}
				if ($manageLanguages) {
	?>				['<img src="../includes/js/ThemeOffice/language.png" />','Локализации',null,null,'Управление языками сайта',
	  					['<img src="../includes/js/ThemeOffice/language.png" />','Языки сайта','index2.php?option=com_languages',null,'Управление языками сайта'],
	   				],
	<?php
				}
	?>				['<img src="../includes/js/ThemeOffice/media.png" />','Медиа-менеджер','index2.php?option=com_media',null,'Управление медиа-файлами'],
						['<img src="../includes/js/ThemeOffice/preview.png" />', 'Предпросмотр', null, null, 'Предпросмотр',
						['<img src="../includes/js/ThemeOffice/preview.png" />','В новом окне','<?php echo $mosConfig_live_site; ?>/index.php','_blank','<?php echo $mosConfig_live_site; ?>'],
						['<img src="../includes/js/ThemeOffice/preview.png" />','В админке','index2.php?option=com_admin&task=preview',null,'<?php echo $mosConfig_live_site; ?>'],
						['<img src="../includes/js/ThemeOffice/preview.png" />','В админке с модулями','index2.php?option=com_admin&task=preview2',null,'<?php echo $mosConfig_live_site; ?>'],
					],
					['<img src="../includes/js/ThemeOffice/globe1.png" />', 'Статистика', null, null, 'Статистика сайта',
	<?php
				if ($mosConfig_enable_stats == 1) {
	?>					['<img src="../includes/js/ThemeOffice/globe4.png" />', 'Браузеры, OS, домены', 'index2.php?option=com_statistics', null, 'Браузеры, OS, домены'],
						['<img src="../includes/js/ThemeOffice/globe3.png" />', 'Статистика запросов страниц', 'index2.php?option=com_statistics&task=pageimp', null, 'Статистика просмотренных страниц'],
	<?php
				}
	?>					['<img src="../includes/js/ThemeOffice/search_text.png" />', 'Поисковые запросы', 'index2.php?option=com_statistics&task=searches', null, 'Что вводили в строке поиска']
					],
	<?php
				if ($manageTemplates) {
	?>				['<img src="../includes/js/ThemeOffice/template.png" />','Шаблоны',null,null,'Смена шаблонов сайта',
						['<img src="../includes/js/ThemeOffice/template.png" />','Шаблоны сайта','index2.php?option=com_templates',null,'Сменить шаблон сайта'],
						_cmSplit,
						['<img src="../includes/js/ThemeOffice/template.png" />','Шаблоны админки','index2.php?option=com_templates&client=admin',null,'Сменить шаблон админки'],
						_cmSplit,
						['<img src="../includes/js/ThemeOffice/template.png" />','Расположение модулей','index2.php?option=com_templates&task=positions',null,'Расположение модулей']
					],
	<?php
				}
				if ($manageTrash) {
	?>				['<img src="../includes/js/ThemeOffice/trash.png" />','Корзина','index2.php?option=com_trash',null,'Управление корзиной'],
	<?php
				}
				if ($canManageUsers || $canMassMail) {
	?>				['<img src="../includes/js/ThemeOffice/users.png" />','Пользователи','index2.php?option=com_users&task=view',null,'Управление пользователями'],
	<?php
					}
	?>			],
	<?php
		// Menu Sub-Menu
	?>			_cmSplit,
				[null,'Меню',null,null,'Управление меню',
	<?php
				if ($manageMenuMan) {
	?>				['<img src="../includes/js/ThemeOffice/menus.png" />','Менеджер меню','index2.php?option=com_menumanager',null,'Управление меню'],
					_cmSplit,
	<?php
				}
				foreach ( $menuTypes as $menuType ) {
	?>				['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $menuType;?>','index2.php?option=com_menus&menutype=<?php echo $menuType;?>',null,''],
	<?php
				}
	?>			],
				_cmSplit,
	<?php
		// Content Sub-Menu
	?>			[null,'Материалы',null,null,'Материалы',
	<?php
				if (count($sections) > 0) {
	?>				['<img src="../includes/js/ThemeOffice/edit.png" />','Материалы по разделам',null,null,'Управление материалами',
	<?php
					foreach ($sections as $section) {
						$txt = addslashes( $section->title ? $section->title : $section->name );
	?>					['<img src="../includes/js/ThemeOffice/document.png" />','<?php echo $txt;?>', null, null,'<?php echo $txt;?>',
							['<img src="../includes/js/ThemeOffice/edit.png" />', 'Материалы в --<?php echo $txt;?>--', 'index2.php?option=com_content&sectionid=<?php echo $section->id;?>',null,null],
							['<img src="../includes/js/ThemeOffice/backup.png" />', 'Архивы в --<?php echo $txt;?>--','index2.php?option=com_content&task=showarchive&sectionid=<?php echo $section->id;?>',null,null],
							['<img src="../includes/js/ThemeOffice/add_section.png" />', 'Категории в --<?php echo $txt;?>--', 'index2.php?option=com_categories&section=<?php echo $section->id;?>',null, null],
						],
	<?php
					} // foreach
	?>				],
					_cmSplit,
	<?php
				}
	?>
					['<img src="../includes/js/ThemeOffice/edit.png" />','Все материалы','index2.php?option=com_content&sectionid=0',null,'Управление всеми материалами'],
					['<img src="../includes/js/ThemeOffice/edit.png" />','Статичные материалы','index2.php?option=com_typedcontent',null,'Управление статичными материалами'],
					_cmSplit,
					['<img src="../includes/js/ThemeOffice/add_section.png" />','Разделы','index2.php?option=com_sections&scope=content',null,'Управление разделами'],
					['<img src="../includes/js/ThemeOffice/add_section.png" />','Категории','index2.php?option=com_categories&section=content',null,'Управление категориями'],
					_cmSplit,
					['<img src="../includes/js/ThemeOffice/home.png" />','Материалы на Главной','index2.php?option=com_frontpage',null,'Управление материалами на Главной странице'],
					['<img src="../includes/js/ThemeOffice/edit.png" />','Архивы','index2.php?option=com_content&task=showarchive&sectionid=0',null,'Управление материалами в архиве'],
	  				['<img src="../includes/js/ThemeOffice/globe3.png" />', 'Статистика запросов страниц', 'index2.php?option=com_statistics&task=pageimp', null, 'Статистика запросов страниц'],
				],
	<?php
		// Components Sub-Menu
		if ($installComponents | $editAllComponents) {
	?>			_cmSplit,
				[null,'Компоненты',null,null,'Управление компонентами',
	<?php
			$query = "SELECT *"
			. "\n FROM #__components"
			. "\n WHERE name != 'frontpage'"
			. "\n AND name != 'media manager'"
			. "\n ORDER BY ordering, name"
			;
			$database->setQuery( $query );
			$comps = $database->loadObjectList();	// component list
			$subs = array();	// sub menus
			// first pass to collect sub-menu items
			foreach ($comps as $row) {
				if ($row->parent) {
					if (!array_key_exists( $row->parent, $subs )) {
						$subs[$row->parent] = array();
					}
					$subs[$row->parent][] = $row;
				}
			}
			$topLevelLimit = 19; //You can get 19 top levels on a 800x600 Resolution
			$topLevelCount = 0;
			foreach ($comps as $row) {
				if ($editAllComponents | $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'components', $row->option )) {
					if ($row->parent == 0 && (trim( $row->admin_menu_link ) || array_key_exists( $row->id, $subs ))) {
						$topLevelCount++;
						if ($topLevelCount > $topLevelLimit) {
							continue;
						}
						$name = addslashes( $row->name );
						$alt = addslashes( $row->admin_menu_alt );
						$link = $row->admin_menu_link ? "'index2.php?$row->admin_menu_link'" : "null";
						echo "\t\t\t\t['<img src=\"../includes/$row->admin_menu_img\" />','$name',$link,null,'$alt'";
						if (array_key_exists( $row->id, $subs )) {
							foreach ($subs[$row->id] as $sub) {
								echo ",\n";
								$name = addslashes( $sub->name );
								$alt = addslashes( $sub->admin_menu_alt );
								$link = $sub->admin_menu_link ? "'index2.php?$sub->admin_menu_link'" : "null";
								echo "\t\t\t\t\t['<img src=\"../includes/$sub->admin_menu_img\" />','$name',$link,null,'$alt']";
							}
						}
						echo "\n\t\t\t\t],\n";
					}
				}
			}
			if ($topLevelLimit < $topLevelCount) {
				echo "\t\t\t\t['<img src=\"../includes/js/ThemeOffice/sections.png\" />','Еще компоненты...','index2.php?option=com_admin&task=listcomponents',null,'Еще компоненты...'],\n";
			}
	?>
				],
	<?php
		// Modules Sub-Menu
			if ($installModules | $editAllModules) {
	?>			_cmSplit,
				[null,'Модули',null,null,'Управление модулями',
	<?php
				if ($editAllModules) {
	?>				['<img src="../includes/js/ThemeOffice/module.png" />', 'Модули сайта', "index2.php?option=com_modules", null, 'Управление модулями сайта'],
					['<img src="../includes/js/ThemeOffice/module.png" />', 'Модули админки', "index2.php?option=com_modules&client=admin", null, 'Управление модулями админки'],
	<?php
				}
	?>			],
	<?php
			} // if ($installModules | $editAllModules)
		} // if $installComponents
		// Mambots Sub-Menu
		if ($installMambots | $editAllMambots) {
	?>			_cmSplit,
				[null,'Мамботы',null,null,'Управление Мамботами',
	<?php
			if ($editAllMambots) {
	?>				['<img src="../includes/js/ThemeOffice/module.png" />', 'Мамботы сайта', "index2.php?option=com_mambots", null, 'Управление мамботами сайта'],
	<?php
			}
	?>			],
	<?php
		}
	?>
	<?php
		// Installer Sub-Menu
		if ($installModules) {
	?>			_cmSplit,
				[null,'Установка',null,null,'Список инсталляторов',
	<?php
			if ($manageTemplates) {
	?>				['<img src="../includes/js/ThemeOffice/install.png" />','Шаблоны - сайта','index2.php?option=com_installer&element=template&client=',null,'Установить шаблон сайта'],
					['<img src="../includes/js/ThemeOffice/install.png" />','Шаблоны - админка','index2.php?option=com_installer&element=template&client=admin',null,'Установить шаблон админки'],
	<?php
			}
			if ($manageLanguages) {
	?>				['<img src="../includes/js/ThemeOffice/install.png" />','Локализации','index2.php?option=com_installer&element=language',null,'Установить локализацию'],
					_cmSplit,
	<?php
			}
	?>				['<img src="../includes/js/ThemeOffice/install.png" />', 'Компоненты','index2.php?option=com_installer&element=component',null,'Установить/Удалить копмонент'],
					['<img src="../includes/js/ThemeOffice/install.png" />', 'Модули', 'index2.php?option=com_installer&element=module', null, 'Установить/Удалить модуль'],
					['<img src="../includes/js/ThemeOffice/install.png" />', 'Мамботы', 'index2.php?option=com_installer&element=mambot', null, 'Установить/Удалить мамбот'],
				],
	<?php
		} // if ($installModules)
		// Messages Sub-Menu
		if ($canConfig) {
	?>			_cmSplit,
				[null,'Сообщения',null,null,'Управление сообщениями',
					['<img src="../includes/js/ThemeOffice/messaging_inbox.png" />','Входящие','index2.php?option=com_messages',null,'Личные сообщения'],
					['<img src="../includes/js/ThemeOffice/messaging_config.png" />','Конфигурация','index2.php?option=com_messages&task=config&hidemainmenu=1',null,'Конфигурация']
	  			],
			_cmSplit,
	  			[null,'Система',null,null,'System Management',
	  				['<img src="../includes/js/ThemeOffice/joomla_16x16.png" />', 'Проверка новой версии', 'http://andyr.mrezha.ru/index.php?option=com_content&task=view&id=26&Itemid=49', '_blank','Проверка новой версии'],
	  				['<img src="../includes/js/ThemeOffice/sysinfo.png" />', 'Системная информация', 'index2.php?option=com_admin&task=sysinfo', null,'Системная информация'],
	<?php
	  		if ($canConfig) {
	?>
					['<img src="../includes/js/ThemeOffice/checkin.png" />', 'Снятие блокировок', 'index2.php?option=com_checkin', null,'Снятие блокировок со всех объектов'],
	<?php
				if ($mosConfig_caching) {
	?>				['<img src="../includes/js/ThemeOffice/config.png" />','Очистка кэша','index2.php?option=com_admin&task=clean_cache',null,'Очистить содержимое кэша'],
					['<img src="../includes/js/ThemeOffice/config.png" />','Очистить все кэши','index2.php?option=com_admin&task=clean_all_cache',null,'Очистка всех кэшей'],
	<?php
				}
			}
	?>			],
	<?php
				}
	?>			_cmSplit,
	<?php
		// Help Sub-Menu
	?>			[null,'Справка','index2.php?option=com_admin&task=help',null,null]
			];
			cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
			</script>
	<?php
		}


	/**
	* Show an disbaled version of the menu, used in edit pages
	* @param string The current user type
	*/
		function showDisabled( $usertype='' ) {
			global $acl;

			$canConfig 			= $acl->acl_check( 'administration', 'config', 'users', $usertype );
			$installModules 	= $acl->acl_check( 'administration', 'install', 'users', $usertype, 'modules', 'all' );
			$editAllModules 	= $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'modules', 'all' );
			$installMambots 	= $acl->acl_check( 'administration', 'install', 'users', $usertype, 'mambots', 'all' );
			$editAllMambots 	= $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'mambots', 'all' );
			$installComponents 	= $acl->acl_check( 'administration', 'install', 'users', $usertype, 'components', 'all' );
			$editAllComponents 	= $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'components', 'all' );
			$canMassMail 		= $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_massmail' );
			$canManageUsers 	= $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_users' );

			$text = 'Меню неактивно на этой странице';
			?>
			<div id="myMenuID" class="inactive"></div>
			<script language="JavaScript" type="text/javascript">
			var myMenu =
			[
			<?php
		/* Home Sub-Menu */
			?>
				[null,'<?php echo 'Начало'; ?>',null,null,'<?php echo $text; ?>'],
				_cmSplit,
			<?php
		/* Site Sub-Menu */
			?>
				[null,'<?php echo 'Сайт'; ?>',null,null,'<?php echo $text; ?>'
				],
			<?php
		/* Menu Sub-Menu */
			?>
				_cmSplit,
				[null,'<?php echo 'Меню'; ?>',null,null,'<?php echo $text; ?>'
				],
				_cmSplit,
			<?php
		/* Content Sub-Menu */
			?>
				[null,'<?php echo 'Материалы'; ?>',null,null,'<?php echo $text; ?>'
				],
			<?php
		/* Components Sub-Menu */
				if ( $installComponents | $editAllComponents) {
					?>
					_cmSplit,
					[null,'<?php echo 'Компоненты'; ?>',null,null,'<?php echo $text; ?>'
					],
					<?php
				} // if $installComponents
				?>
			<?php
		/* Modules Sub-Menu */
				if ( $installModules | $editAllModules) {
					?>
					_cmSplit,
					[null,'<?php echo 'Модули'; ?>',null,null,'<?php echo $text; ?>'
					],
					<?php
				} // if ( $installModules | $editAllModules)
				?>
			<?php
		/* Mambots Sub-Menu */
				if ( $installMambots | $editAllMambots) {
					?>
					_cmSplit,
					[null,'<?php echo 'Мамботы'; ?>',null,null,'<?php echo $text; ?>'
					],
					<?php
				} // if ( $installMambots | $editAllMambots)
				?>


				<?php
		/* Installer Sub-Menu */
				if ( $installModules) {
					?>
					_cmSplit,
					[null,'<?php echo 'Установка'; ?>',null,null,'<?php echo $text; ?>'
						<?php
						?>
					],
					<?php
				} // if ( $installModules)
				?>
				<?php
		/* Messages Sub-Menu */
				if ( $canConfig) {
					?>
					_cmSplit,
					[null,'<?php echo 'Сообщения'; ?>',null,null,'<?php echo $text; ?>'
					],
					<?php
				}
				?>

				<?php
		/* System Sub-Menu */
				if ( $canConfig) {
					?>
					_cmSplit,
					[null,'<?php echo 'Система'; ?>',null,null,'<?php echo $text; ?>'
					],
					<?php
				}
				?>
				_cmSplit,
				<?php
		/* Help Sub-Menu */
				?>
				[null,'<?php echo 'Справка'; ?>',null,null,'<?php echo $text; ?>']
			];
			cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
			</script>
			<?php
		}
	}
}
$cache =& mosCache::getCache( 'mos_fullmenu' );

$hide = intval( mosGetParam( $_REQUEST, 'hidemainmenu', 0 ) );

if ( $hide ) {
	mosFullAdminMenu::showDisabled( $my->usertype );
} else {
	mosFullAdminMenu::show( $my->usertype );
}
?>
