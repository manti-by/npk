<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( '������ ��������.' );
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is fun_down.php, released on 2003-01-25.

     The Initial Developer of the Original Code is The QuiX project.

     Alternatively, the contents of this file may be used under the terms
     of the GNU General Public License Version 2 or later (the "GPL"), in
     which case the provisions of the GPL are applicable instead of
     those above. If you wish to allow use of your version of this file only
     under the terms of the GPL and not to allow others to use
     your version of this file under the MPL, indicate your decision by
     deleting  the provisions above and replace  them with the notice and
     other provisions required by the GPL.  If you do not delete
     the provisions above, a recipient may use your version of this file
     under either the MPL or the GPL."
------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------
Author: The QuiX project
	quix@free.fr
	http://www.quix.tk
	http://quixplorer.sourceforge.net

Comment:
	QuiXplorer Version 2.3
	File-Download Functions
	
	Have Fun...
------------------------------------------------------------------------------*/
/**
 * Reads a file and sends them in chunks to the browser
 * This should overcome memory problems
 * http://www.php.net/manual/en/function.readfile.php#54295
 *
 * @since 1.4.1
 * @param string $filename
 * @param boolean $retbytes
 * @return mixed
 */
function readFileChunked($filename,$retbytes=true) {
	$chunksize = 1*(1024*1024); // how many bytes per chunk
	$buffer = '';
	$cnt =0;
	// $handle = fopen($filename, 'rb');
	$handle = fopen($filename, 'rb');
	if ($handle === false) {
		return false;
	}
	while (!feof($handle)) {
		$buffer = fread($handle, $chunksize);
		echo $buffer;
		sleep(1);
		ob_flush();
		flush();
		if ($retbytes) {
			$cnt += strlen($buffer);
		}
	}
	$status = fclose($handle);
	if ($retbytes && $status) {
		return $cnt; // return num. bytes delivered like readfile() does.
	}
	return $status;
}

//------------------------------------------------------------------------------
function download_item($dir, $item, $unlink=false) {		// download file
	global $action, $mosConfig_cache_path;
	// Security Fix:
	$item=basename($item);

	while( @ob_end_clean() );
    ob_start();
	
	if( jx_isFTPMode() ) {
		$abs_item = $dir.'/'.$item;
	}
	else {
		$abs_item = get_abs_item($dir,$item);
		if( !strstr( $abs_item, realpath($GLOBALS['home_dir']) ))
		  $abs_item = realpath($GLOBALS['home_dir']).$abs_item;
	}
	
	if(($GLOBALS["permissions"]&01)!=01) show_error($GLOBALS["error_msg"]["accessfunc"]);
	if(!jx_File::file_exists($abs_item)) show_error($item.": ".$GLOBALS["error_msg"]["fileexist"]);
	if(!get_show_item($dir, $item)) show_error($item.": ".$GLOBALS["error_msg"]["accessfile"]);

	if( jx_isFTPMode() ) {

		$abs_item = jx_ftp_make_local_copy( $abs_item );
		$unlink = true;
	}
	$browser=id_browser();
	header('Content-Type: '.(($browser=='IE' || $browser=='OPERA')?
		'application/octetstream':'application/octet-stream'));
	header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize(realpath($abs_item)));
    //header("Content-Encoding: none");
	if($browser=='IE') {
		header('Content-Disposition: attachment; filename="'.$item.'"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	} else {
		header('Content-Disposition: attachment; filename="'.$item.'"');
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
	}
	@set_time_limit( 0 );
	@readFileChunked($abs_item);
	
	if( $unlink==true ) {
	  	unlink( $abs_item );
	}
    ob_end_flush();
	exit;
}
//------------------------------------------------------------------------------
?>
