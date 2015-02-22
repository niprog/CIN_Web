<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
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
	
This file was modified by the TinyWebgallery project to work as backend for 
TinyWebgallery.
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
function download_item($dir, $item, $unlink=false) {		// download file
	global $action;
	// Security Fix:
	$item=basename($item);
	
	$abs_item = get_abs_item($dir,$item);
	
	// echo "bb" . $abs_item;
	
	if(($GLOBALS["permissions"]&01)!=01) show_error($GLOBALS["error_msg"]["accessfunc"]);
	if(!is_file($abs_item)) show_error($dir . "/" . $item.": ".$GLOBALS["error_msg"]["fileexist"]);	
	if(!get_show_item($dir, $item)) show_error($item.": ".$GLOBALS["error_msg"]["accessfile"]);
	
	if( !strstr( $abs_item, realpath($GLOBALS['home_dir']) ))
	  $abs_item = realpath($GLOBALS['home_dir']).$abs_item;

	
	$browser=id_browser();
	header('Content-Type: '.(($browser=='IE' || $browser=='OPERA')?
		'application/octetstream':'application/octet-stream'));
	header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize($abs_item));
	if($browser=='IE') {
		header('Content-Disposition: attachment; filename="'.$item.'"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	} else {
		header('Content-Disposition: attachment; filename="'.$item.'"');
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
	}
	// @readfile($abs_item);
	$fp = @fopen($abs_item, "rb");
	
	while ($content = @fread($fp, 8192))
	{
	  print $content;
	} 
  @fclose($fp);
    
	if( $unlink==true ) {
	  unlink(realpath($abs_item));
	}
	exit;
}
//------------------------------------------------------------------------------
?>
