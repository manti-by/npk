<?php

// Russian Language Module for joomlaXplorer (translated by Mikhail M. Pigulsky - mikhail@mikhail.pp.ru)
global $_VERSION;

$GLOBALS["charset"] = "windows-1251";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y.m.d H:i";
$GLOBALS["error_msg"] = array(
      // error
      "error"                  => "ОШИБКА(И)",
      "back"                  => "Вернуться",
      
      // root
      "home"                  => "Домашняя директория не существует! Проверьте настройки.",
      "abovehome"            => "Текущая директория не может находится выше домашнего каталога.",
      "targetabovehome"      => "Запрошенная директория не может находится выше домашнего каталога.",

      // exist
      "direxist"            => "Директория не существует",
      //"filedoesexist"      => "Такой файл уже существует",
      "fileexist"            => "Такого файла не существует",
      "itemdoesexist"            => "Такой объект уже существует",
      "itemexist"            => "Такого объекта существует",
      "targetexist"            => "Назначенной директории не существует",
      "targetdoesexist"      => "Назначенного объекта не существует",
      
      // open
      "opendir"            => "Невозможно открыть директорию",
      "readdir"            => "Невозможно прочитать директорию",

      // access
      "accessdir"            => "Вам запрещено заходить в данную директорию",
      "accessfile"            => "Вам запрещено использовать данный файл",
      "accessitem"            => "Вам запрещено использовать данный объект",
      "accessfunc"            => "Вам запрещено использовать данную функцию",
      "accesstarget"            => "Вам запрещено входить в заданную директорию",

      // actions
      "permread"            => "Ошибка в получении прав доступа",
      "permchange"            => "Ошибка в смене прав доступа",
      "openfile"            => "Провал в открытии файла",
      "savefile"            => "Провал в сохранении файла",
      "createfile"            => "Провал в создании файла",
      "createdir"            => "Провал в создании директории",
      "uploadfile"            => "Провал в загрузке файла",
      "copyitem"            => "Провал в копировании",
      "moveitem"            => "Провал в переименовании",
      "delitem"            => "Провал в удалении",
      "chpass"            => "Провал в смене пароля",
      "deluser"            => "Провал в удалении пользователя",
      "adduser"            => "Провал в удалении пользователя",
      "saveuser"            => "Провал в сохранении пользователя",
      "searchnothing"            => "Строка поиска не должна быть пустой",
      
      // misc
      "miscnofunc"            => "Функция недоступна",
      "miscfilesize"            => "Файл превышает максимальный размер",
      "miscfilepart"            => "Файл был загружен частично",
      "miscnoname"            => "Вы должны дать задать имя",
      "miscselitems"            => "Вы не выбрали объект(ы)",
      "miscdelitems"            => "Вы уверены, что хотите удалить \"+num+\" объект(а/ов)?",
      "miscdeluser"            => "Вы уверены, что хотите удалить пользователя '\"+user+\"'?",
      "miscnopassdiff"      => "Новый пароль не отличается от текущего",
      "miscnopassmatch"      => "Пароли не совпадают",
      "miscfieldmissed"      => "Вы пропустили важное поле",
      "miscnouserpass"      => "Имя пользователя или пароль не правильны",
      "miscselfremove"      => "Вы не можете удалить самого себя",
      "miscuserexist"            => "Такой пользователь уже существует",
      "miscnofinduser"      => "Невозможно найти пользователя",
	"extract_noarchive" => "Файл не является извлекаемым архивом.",
	"extract_unknowntype" => "Неизвестный тип архива"
);
$GLOBALS["messages"] = array(
      // links
      "permlink"            => "Поменять права доступа",
      "editlink"            => "Редактировать",
      "downlink"            => "Скачать",
      "uplink"            => "Наверх",
      "homelink"            => "Домой",
      "reloadlink"            => "Обновить",
      "copylink"            => "Копировать",
      "movelink"            => "Переместить",
      "dellink"            => "Удалить",
      "comprlink"            => "Архивировать",
      "adminlink"            => "Администрирование",
      "logoutlink"            => "Выйти",
      "uploadlink"            => "Закачать",
      "searchlink"            => "Поиск",
	"extractlink"	=> "Разархивировать",
	'chmodlink'		=> 'Сменить права (chmod)', // new mic
	'mossysinfolink'	=> $_VERSION->PRODUCT.' Системная информация ('.$_VERSION->PRODUCT.', Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Открыть сайт -joomlaXplorer- в новом окне', // new mic
      
      // list
      "nameheader"            => "Файл",
      "sizeheader"            => "Размер",
      "typeheader"            => "Тип",
      "modifheader"            => "Изменен",
      "permheader"            => "Права",
      "actionheader"            => "Действия",
      "pathheader"            => "Путь",
      
      // buttons
      "btncancel"            => "Отменить",
      "btnsave"            => "Сохранить",
      "btnchange"            => "Изменить",
      "btnreset"            => "Очистить",
      "btnclose"            => "Закрыть",
      "btncreate"            => "Создать",
      "btnsearch"            => "Поиск",
      "btnupload"            => "Закачать",
      "btncopy"            => "Копировать",
      "btnmove"            => "Переместить",
      "btnlogin"            => "Войти",
      "btnlogout"            => "Выйти",
      "btnadd"            => "Добавить",
      "btnedit"            => "Редактировать",
      "btnremove"            => "Удалить",
	
	// user messages, new in joomlaXplorer 1.3.0
	'renamelink'	=> 'Переименовать',
	'confirm_delete_file' => 'Вы уверены, что хотите удалить этотфайл? \\n%s',
	'success_delete_file' => 'Объект(ы) успешно удален(ы).',
	'success_rename_file' => 'Объект %s был успешно переименован в %s.',
	
      
      // actions
      "actdir"            => "Папка",
      "actperms"            => "Поменять права",
      "actedit"            => "Правит файл",
      "actsearchresults"      => "Результаты поиска",
      "actcopyitems"            => "Копировать объект(ы)",
      "actcopyfrom"            => "Копировать из /%s в /%s ",
      "actmoveitems"            => "Переместить объект(ы)",
      "actmovefrom"            => "Переместить из /%s в /%s ",
      "actlogin"            => "Войти",
      "actloginheader"      => "Войти, чтобы начать использовать QuiXplorer",
      "actadmin"            => "Администрирование",
      "actchpwd"            => "Сменить пароль",
      "actusers"            => "Пользователи",
      "actarchive"            => "Заархивировать объект(ы)",
      "actupload"            => "Закачать файл(ы)",
      
      // misc
      "miscitems"            => "Объект(а/ов)",
      "miscfree"            => "Свободно",
      "miscusername"            => "Пользователь",
      "miscpassword"            => "Пароль",
      "miscoldpass"            => "Старый пароль",
      "miscnewpass"            => "Новый пароль",
      "miscconfpass"            => "Подтвердите пароль",
      "miscconfnewpass"      => "Подтвердите новый пароль",
      "miscchpass"            => "Поменять пароль",
      "mischomedir"            => "Домашняя директория",
      "mischomeurl"            => "Домашний URL",
      "miscshowhidden"      => "Показывать спрятанные объекты",
      "mischidepattern"      => "Прятать файлы",
      "miscperms"            => "Права",
      "miscuseritems"            => "(имя, домашняя директория, показывать спрятанные объекты, права досутпа, активен)",
      "miscadduser"            => "добавить пользователя",
      "miscedituser"            => "редактировать пользователя '%s'",
      "miscactive"            => "Активен",
      "misclang"            => "Язык",
      "miscnoresult"            => "Нет результатов",
      "miscsubdirs"            => "Искать в поддиректориях",
      "miscpermnames"            => array("Только просмотр","Редактирование","Сменя пароля","Правка и смена пароля",
                              "Администратор"),
      "miscyesno"            => array("Да","Нет","Д","Н"),
      "miscchmod"            => array("Владелец", "Группа", "Интернет"),
	// from here all new by mic
	'miscowner'			=> 'Owner',
	'miscownerdesc'		=> '<strong>Описание:</strong><br />User (UID) /<br />Group (GID)<br />Текущие права:<br /><strong> %s ( %s ) </strong>/<br /><strong> %s ( %s )</strong>',

	// sysinfo (new by mic)
	'simamsysinfo'		=> $_VERSION->PRODUCT.' System Info',
	'sisysteminfo'		=> 'Системная информация',
	'sibuilton'			=> 'OS',
	'sidbversion'		=> 'Версия БД (MySQL)',
	'siphpversion'		=> 'PHP версия',
	'siphpupdate'		=> 'Информация: <span style="color: red;">Версия PHP, которую вы используете <strong>не</strong> актуальна!</span><br />Для гарантии полной функциональности '.$_VERSION->PRODUCT.' и всех добавлений,<br />вам требуется минимум<strong>PHP.Version 4.3</strong>!',
	'siwebserver'		=> 'WEB-сервер',
	'siwebsphpif'		=> 'WEB-сервер - PHP интерфейс',
	'simamboversion'	=> $_VERSION->PRODUCT.' версия',
	'siuseragent'		=> 'Версия броузера',
	'sirelevantsettings' => 'Important PHP Settings',
	'sisafemode'		=> 'Safe Mode',
	'sibasedir'			=> 'Open basedir',
	'sidisplayerrors'	=> 'PHP Errors',
	'sishortopentags'	=> 'Short Open Tags',
	'sifileuploads'		=> 'Datei Uploads',
	'simagicquotes'		=> 'Magic Quotes',
	'siregglobals'		=> 'Register Globals',
	'sioutputbuf'		=> 'Output Buffer',
	'sisesssavepath'	=> 'Session Savepath',
	'sisessautostart'	=> 'Session auto start',
	'sixmlenabled'		=> 'XML enabled',
	'sizlibenabled'		=> 'ZLIB enabled',
	'sidisabledfuncs'	=> 'Не разрешенные функции',
	'sieditor'			=> 'WYSIWYG редактор',
	'siconfigfile'		=> 'Файл конфигурации',
	'siphpinfo'			=> 'PHP Info',
	'siphpinformation'	=> 'PHP Information',
	'sipermissions'		=> 'Права',
	'sidirperms'		=> 'Права на папки',
	'sidirpermsmess'	=> 'Для обеспечения уверенного функционирования всех функция '.$_VERSION->PRODUCT.', следующие папки должны иметь права на запись [chmod 0777]',
	'sionoff'			=> array( 'Вкл', 'Откл' ),
	
	'extract_warning' => "Вы действительно хотите разархивировать этот файл? Здесь?\\nЭта операция перезапишет существующие файлы, будьте осторожны!",
	'extract_success' => "Разархивирование завершено успешно",
	'extract_failure' => "Разархивирование сорвано",
	
	'overwrite_files' => 'Перепзаписать существующие файлы?',
	"viewlink"		=> "Просмотр",
	"actview"		=> "Просмотр файла-источника",
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to fun_chmod.php file
	'recurse_subdirs'	=> 'С вложенными папками?',
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to footer.php file
	'check_version'	=> 'Проверка последней версии',
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to fun_rename.php file
	'rename_file'	=>	'Переименовать папку или файл...',
	'newname'		=>	'Новое имя',
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to fun_edit.php file
	'returndir'	=>	'Вернуться в каталог после записи?',
	'line'		=> 	'Строка',
	'column'	=>	'Колонка',
	'wordwrap'	=>	'Перенос: (только IE)',
	'copyfile'	=>	'Копировать файл с этим именем',
	
	// Bookmarks
	'quick_jump' => 'Быстрый переход на',
	'already_bookmarked' => 'Этот каталог уже в закладках',
	'bookmark_was_added' => 'Каталог добавлен в список закладок',
	'not_a_bookmark' => 'Каталога нет в закладках',
	'bookmark_was_removed' => 'Каталог удален из закладок',
	'bookmarkfile_not_writable' => "Немогу записать %s в закладки.\n Файл закладок '%s' \nне доступен на запись.",
	
	'lbl_add_bookmark' => 'Добавить выделенный каталог в закладки',
	'lbl_remove_bookmark' => 'Удалить закладку на этот каталог',
	
	'enter_alias_name' => 'Введите имя закладки для этой закладки',
	
	'normal_compression' => 'нормальное сжатие',
	'good_compression' => 'хорошее сжатие',
	'best_compression' => 'сильное сжатие',
	'no_compression' => 'без сжатия',
	
	'creating_archive' => 'Создание файла архива...',
	'processed_x_files' => 'Обработка файла. Завершено %s из %s',
	
	'ftp_login_lbl' => 'Введите данные для авторизации на сервере FTP',
	'ftp_login_name' => 'FTP - имя пользователя',
	'ftp_login_pass' => 'FTP - пароль',
	'ftp_hostname_port' => 'FTP - имя сервера и порт <br />(порт - опционально)',
	'ftp_login_check' => 'Проверка FTP- соединения...',
	'ftp_connection_failed' => "Не могу подключиться к FTP-серверу. \nПроверьте, запущен ли FTP-сервер.",
	'ftp_login_failed' => "Не удалось войти на FTP-сервер. Проверьте правильность имени и пароля и повторите попытку.",
		
	'switch_file_mode' => 'Текущий режим: <strong>%s</strong>. Вы можете переключиться в режим %s.',
	'symlink_target' => 'Место для символьной ссылки',
);
?>
