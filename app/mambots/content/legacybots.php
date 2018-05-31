<?php
defined( '_VALID_MOS' ) or die( 'Доступ запрещен' );
$_MAMBOTS->registerFunction( 'onPrepareContent', 'botLegacyBots' );
function botLegacyBots( $published, &$row, &$params, $page=0 ) {
	global $mosConfig_absolute_path;
	if ( !$published ) {
		return true;
	}
	$bots = mosReadDirectory( "$mosConfig_absolute_path/mambots", "\.php$" );
	sort( $bots );
	foreach ($bots as $bot) {
		require $mosConfig_absolute_path ."/mambots/$bot";
	}
}
?>