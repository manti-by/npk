<?php

// Russian Language Module for joomlaXplorer (translated by Mikhail M. Pigulsky - mikhail@mikhail.pp.ru)
global $_VERSION;

$GLOBALS["charset"] = "windows-1251";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y.m.d H:i";
$GLOBALS["error_msg"] = array(
      // error
      "error"                  => "������(�)",
      "back"                  => "���������",
      
      // root
      "home"                  => "�������� ���������� �� ����������! ��������� ���������.",
      "abovehome"            => "������� ���������� �� ����� ��������� ���� ��������� ��������.",
      "targetabovehome"      => "����������� ���������� �� ����� ��������� ���� ��������� ��������.",

      // exist
      "direxist"            => "���������� �� ����������",
      //"filedoesexist"      => "����� ���� ��� ����������",
      "fileexist"            => "������ ����� �� ����������",
      "itemdoesexist"            => "����� ������ ��� ����������",
      "itemexist"            => "������ ������� ����������",
      "targetexist"            => "����������� ���������� �� ����������",
      "targetdoesexist"      => "������������ ������� �� ����������",
      
      // open
      "opendir"            => "���������� ������� ����������",
      "readdir"            => "���������� ��������� ����������",

      // access
      "accessdir"            => "��� ��������� �������� � ������ ����������",
      "accessfile"            => "��� ��������� ������������ ������ ����",
      "accessitem"            => "��� ��������� ������������ ������ ������",
      "accessfunc"            => "��� ��������� ������������ ������ �������",
      "accesstarget"            => "��� ��������� ������� � �������� ����������",

      // actions
      "permread"            => "������ � ��������� ���� �������",
      "permchange"            => "������ � ����� ���� �������",
      "openfile"            => "������ � �������� �����",
      "savefile"            => "������ � ���������� �����",
      "createfile"            => "������ � �������� �����",
      "createdir"            => "������ � �������� ����������",
      "uploadfile"            => "������ � �������� �����",
      "copyitem"            => "������ � �����������",
      "moveitem"            => "������ � ��������������",
      "delitem"            => "������ � ��������",
      "chpass"            => "������ � ����� ������",
      "deluser"            => "������ � �������� ������������",
      "adduser"            => "������ � �������� ������������",
      "saveuser"            => "������ � ���������� ������������",
      "searchnothing"            => "������ ������ �� ������ ���� ������",
      
      // misc
      "miscnofunc"            => "������� ����������",
      "miscfilesize"            => "���� ��������� ������������ ������",
      "miscfilepart"            => "���� ��� �������� ��������",
      "miscnoname"            => "�� ������ ���� ������ ���",
      "miscselitems"            => "�� �� ������� ������(�)",
      "miscdelitems"            => "�� �������, ��� ������ ������� \"+num+\" ������(�/��)?",
      "miscdeluser"            => "�� �������, ��� ������ ������� ������������ '\"+user+\"'?",
      "miscnopassdiff"      => "����� ������ �� ���������� �� ��������",
      "miscnopassmatch"      => "������ �� ���������",
      "miscfieldmissed"      => "�� ���������� ������ ����",
      "miscnouserpass"      => "��� ������������ ��� ������ �� ���������",
      "miscselfremove"      => "�� �� ������ ������� ������ ����",
      "miscuserexist"            => "����� ������������ ��� ����������",
      "miscnofinduser"      => "���������� ����� ������������",
	"extract_noarchive" => "���� �� �������� ����������� �������.",
	"extract_unknowntype" => "����������� ��� ������"
);
$GLOBALS["messages"] = array(
      // links
      "permlink"            => "�������� ����� �������",
      "editlink"            => "�������������",
      "downlink"            => "�������",
      "uplink"            => "������",
      "homelink"            => "�����",
      "reloadlink"            => "��������",
      "copylink"            => "����������",
      "movelink"            => "�����������",
      "dellink"            => "�������",
      "comprlink"            => "������������",
      "adminlink"            => "�����������������",
      "logoutlink"            => "�����",
      "uploadlink"            => "��������",
      "searchlink"            => "�����",
	"extractlink"	=> "���������������",
	'chmodlink'		=> '������� ����� (chmod)', // new mic
	'mossysinfolink'	=> $_VERSION->PRODUCT.' ��������� ���������� ('.$_VERSION->PRODUCT.', Server, PHP, mySQL)', // new mic
	'logolink'		=> '������� ���� -joomlaXplorer- � ����� ����', // new mic
      
      // list
      "nameheader"            => "����",
      "sizeheader"            => "������",
      "typeheader"            => "���",
      "modifheader"            => "�������",
      "permheader"            => "�����",
      "actionheader"            => "��������",
      "pathheader"            => "����",
      
      // buttons
      "btncancel"            => "��������",
      "btnsave"            => "���������",
      "btnchange"            => "��������",
      "btnreset"            => "��������",
      "btnclose"            => "�������",
      "btncreate"            => "�������",
      "btnsearch"            => "�����",
      "btnupload"            => "��������",
      "btncopy"            => "����������",
      "btnmove"            => "�����������",
      "btnlogin"            => "�����",
      "btnlogout"            => "�����",
      "btnadd"            => "��������",
      "btnedit"            => "�������������",
      "btnremove"            => "�������",
	
	// user messages, new in joomlaXplorer 1.3.0
	'renamelink'	=> '�������������',
	'confirm_delete_file' => '�� �������, ��� ������ ������� ��������? \\n%s',
	'success_delete_file' => '������(�) ������� ������(�).',
	'success_rename_file' => '������ %s ��� ������� ������������ � %s.',
	
      
      // actions
      "actdir"            => "�����",
      "actperms"            => "�������� �����",
      "actedit"            => "������ ����",
      "actsearchresults"      => "���������� ������",
      "actcopyitems"            => "���������� ������(�)",
      "actcopyfrom"            => "���������� �� /%s � /%s ",
      "actmoveitems"            => "����������� ������(�)",
      "actmovefrom"            => "����������� �� /%s � /%s ",
      "actlogin"            => "�����",
      "actloginheader"      => "�����, ����� ������ ������������ QuiXplorer",
      "actadmin"            => "�����������������",
      "actchpwd"            => "������� ������",
      "actusers"            => "������������",
      "actarchive"            => "�������������� ������(�)",
      "actupload"            => "�������� ����(�)",
      
      // misc
      "miscitems"            => "������(�/��)",
      "miscfree"            => "��������",
      "miscusername"            => "������������",
      "miscpassword"            => "������",
      "miscoldpass"            => "������ ������",
      "miscnewpass"            => "����� ������",
      "miscconfpass"            => "����������� ������",
      "miscconfnewpass"      => "����������� ����� ������",
      "miscchpass"            => "�������� ������",
      "mischomedir"            => "�������� ����������",
      "mischomeurl"            => "�������� URL",
      "miscshowhidden"      => "���������� ���������� �������",
      "mischidepattern"      => "������� �����",
      "miscperms"            => "�����",
      "miscuseritems"            => "(���, �������� ����������, ���������� ���������� �������, ����� �������, �������)",
      "miscadduser"            => "�������� ������������",
      "miscedituser"            => "������������� ������������ '%s'",
      "miscactive"            => "�������",
      "misclang"            => "����",
      "miscnoresult"            => "��� �����������",
      "miscsubdirs"            => "������ � ��������������",
      "miscpermnames"            => array("������ ��������","��������������","����� ������","������ � ����� ������",
                              "�������������"),
      "miscyesno"            => array("��","���","�","�"),
      "miscchmod"            => array("��������", "������", "��������"),
	// from here all new by mic
	'miscowner'			=> 'Owner',
	'miscownerdesc'		=> '<strong>��������:</strong><br />User (UID) /<br />Group (GID)<br />������� �����:<br /><strong> %s ( %s ) </strong>/<br /><strong> %s ( %s )</strong>',

	// sysinfo (new by mic)
	'simamsysinfo'		=> $_VERSION->PRODUCT.' System Info',
	'sisysteminfo'		=> '��������� ����������',
	'sibuilton'			=> 'OS',
	'sidbversion'		=> '������ �� (MySQL)',
	'siphpversion'		=> 'PHP ������',
	'siphpupdate'		=> '����������: <span style="color: red;">������ PHP, ������� �� ����������� <strong>��</strong> ���������!</span><br />��� �������� ������ ���������������� '.$_VERSION->PRODUCT.' � ���� ����������,<br />��� ��������� �������<strong>PHP.Version 4.3</strong>!',
	'siwebserver'		=> 'WEB-������',
	'siwebsphpif'		=> 'WEB-������ - PHP ���������',
	'simamboversion'	=> $_VERSION->PRODUCT.' ������',
	'siuseragent'		=> '������ ��������',
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
	'sidisabledfuncs'	=> '�� ����������� �������',
	'sieditor'			=> 'WYSIWYG ��������',
	'siconfigfile'		=> '���� ������������',
	'siphpinfo'			=> 'PHP Info',
	'siphpinformation'	=> 'PHP Information',
	'sipermissions'		=> '�����',
	'sidirperms'		=> '����� �� �����',
	'sidirpermsmess'	=> '��� ����������� ���������� ���������������� ���� ������� '.$_VERSION->PRODUCT.', ��������� ����� ������ ����� ����� �� ������ [chmod 0777]',
	'sionoff'			=> array( '���', '����' ),
	
	'extract_warning' => "�� ������������� ������ ��������������� ���� ����? �����?\\n��� �������� ����������� ������������ �����, ������ ���������!",
	'extract_success' => "���������������� ��������� �������",
	'extract_failure' => "���������������� �������",
	
	'overwrite_files' => '������������� ������������ �����?',
	"viewlink"		=> "��������",
	"actview"		=> "�������� �����-���������",
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to fun_chmod.php file
	'recurse_subdirs'	=> '� ���������� �������?',
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to footer.php file
	'check_version'	=> '�������� ��������� ������',
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to fun_rename.php file
	'rename_file'	=>	'������������� ����� ��� ����...',
	'newname'		=>	'����� ���',
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to fun_edit.php file
	'returndir'	=>	'��������� � ������� ����� ������?',
	'line'		=> 	'������',
	'column'	=>	'�������',
	'wordwrap'	=>	'�������: (������ IE)',
	'copyfile'	=>	'���������� ���� � ���� ������',
	
	// Bookmarks
	'quick_jump' => '������� ������� ��',
	'already_bookmarked' => '���� ������� ��� � ���������',
	'bookmark_was_added' => '������� �������� � ������ ��������',
	'not_a_bookmark' => '�������� ��� � ���������',
	'bookmark_was_removed' => '������� ������ �� ��������',
	'bookmarkfile_not_writable' => "������ �������� %s � ��������.\n ���� �������� '%s' \n�� �������� �� ������.",
	
	'lbl_add_bookmark' => '�������� ���������� ������� � ��������',
	'lbl_remove_bookmark' => '������� �������� �� ���� �������',
	
	'enter_alias_name' => '������� ��� �������� ��� ���� ��������',
	
	'normal_compression' => '���������� ������',
	'good_compression' => '������� ������',
	'best_compression' => '������� ������',
	'no_compression' => '��� ������',
	
	'creating_archive' => '�������� ����� ������...',
	'processed_x_files' => '��������� �����. ��������� %s �� %s',
	
	'ftp_login_lbl' => '������� ������ ��� ����������� �� ������� FTP',
	'ftp_login_name' => 'FTP - ��� ������������',
	'ftp_login_pass' => 'FTP - ������',
	'ftp_hostname_port' => 'FTP - ��� ������� � ���� <br />(���� - �����������)',
	'ftp_login_check' => '�������� FTP- ����������...',
	'ftp_connection_failed' => "�� ���� ������������ � FTP-�������. \n���������, ������� �� FTP-������.",
	'ftp_login_failed' => "�� ������� ����� �� FTP-������. ��������� ������������ ����� � ������ � ��������� �������.",
		
	'switch_file_mode' => '������� �����: <strong>%s</strong>. �� ������ ������������� � ����� %s.',
	'symlink_target' => '����� ��� ���������� ������',
);
?>
