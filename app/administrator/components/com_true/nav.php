<?php
$Toffice = $mainframe->getCfg( 'live_site' ).'/includes/js/ThemeOffice';

    $adminNav = '
    <div style="margin-bottom: 15px;">
    <img src="'.$Toffice.'/tgpics.png" alt="'.JText::_('TG_INSTALL_PIC').'" /><a href="index2.php?option=com_true&act=pictures">'.JText::_('TG_INSTALL_PIC').'</a>
	<img src="'.$Toffice.'/tgcategory.png" alt="'.JText::_('TG_INSTALL_CAT').'" /> <a href="index2.php?option=com_true&act=showcatg">'.JText::_('TG_INSTALL_CAT').'</a>
	<img src="'.$Toffice.'/tgupload.png" alt="'.JText::_('TG_INSTALL_U').'" /> <a href="index2.php?option=com_true&act=upload&hidemainmenu=1">'.JText::_('TG_INSTALL_U').'</a>
	<img src="'.$Toffice.'/tgzipupload.png" alt="'.JText::_('TG_INSTALL_BU').'" /> <a href="index2.php?option=com_true&act=batchupload&hidemainmenu=1">'.JText::_('TG_INSTALL_BU').'</a>
	<img src="'.$Toffice.'/tgimport.png" alt="'.JText::_('TG_INSTALL_BI').'" /> <a href="index2.php?option=com_true&act=batchimport&hidemainmenu=1">'.JText::_('TG_INSTALL_BI').'</a>
	<img src="'.$Toffice.'/tgconfig.png" alt="'.JText::_('TG_INSTALL_CONF').'" /> <a href="index2.php?option=com_true&act=settings&hidemainmenu=1">'.JText::_('TG_INSTALL_CONF').'</a>
	<img src="'.$Toffice.'/tgreset.png" alt="'.JText::_('TG_INSTALL_RV').'" /> <a href="index2.php?option=com_true&act=resetvotes">'.JText::_('TG_INSTALL_RV').'</a>
	<img src="'.$Toffice.'/tgrebuild.png" alt="'.JText::_('TG_INSTALL_RT').'" /> <a href="index2.php?option=com_true&act=rebuild">'.JText::_('TG_INSTALL_RT').'</a>
	<span class="small">(version - '.$tgver.')</span>
	</div>';
echo $adminNav;

?>