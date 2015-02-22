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

     The Original Code is fun_edit.php, released on 2003-03-31.

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
	File-Edit Functions
	
	Have Fun...
	
This file was modified by the TinyWebgallery project to work as backend for 
TinyWebgallery.
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
function savefile($file_name) {			// save edited file
	if( get_magic_quotes_gpc() ) {
		$code = stripslashes($GLOBALS['__POST']["code"]);
	}
	else {
		$code = $GLOBALS['__POST']["code"];
	}
	  
	$fp = @fopen($file_name, "w");
	if($fp===false) {
		show_error(basename($file_name).": ".$GLOBALS["error_msg"]["savefile"]);
	}
	// $code = utf8_encode($code);
	fputs($fp, $code);
	@fclose($fp);
}
//------------------------------------------------------------------------------
function edit_file($dir, $item) {		// edit file
	if(($GLOBALS["permissions"]&01)!=01) 
	  show_error($GLOBALS["error_msg"]["accessfunc"]);
	if(!get_is_file($dir, $item)) 
	  show_error($item.": ".$GLOBALS["error_msg"]["fileexist"]);
	if(!get_show_item($dir, $item)) 
	  show_error($item.": ".$GLOBALS["error_msg"]["accessfile"]);
	
	$fname = get_abs_item($dir, $item);
	
	if(isset($GLOBALS['__POST']["dosave"]) && $GLOBALS['__POST']["dosave"]=="yes") {
		// Save / Save As
		$item=basename(stripslashes($GLOBALS['__POST']["fname"]));
		$fname2=get_abs_item($dir, $item);
		if(!isset($item) || $item=="") 
		  show_error($GLOBALS["error_msg"]["miscnoname"]);
		if($fname!=$fname2 && @file_exists($fname2)) 
		  show_error($item.": ".$GLOBALS["error_msg"]["itemdoesexist"]);
		savefile($fname2);
		$fname=$fname2;
		if( !empty( $GLOBALS['__POST']['return_to_dir'])) {
			$_SESSION["user_msg"]= sprintf($GLOBALS["messages"]["filesaved"], $item);
	    header("Location: ".make_link("list",$dir,NULL));
	}
	}
	
	// open file
	$fp = @fopen($fname, "r");
	if($fp===false) show_error($item.": ".$GLOBALS["error_msg"]["openfile"]);
	
	// header
	$s_item=get_rel_item($dir,$item);	if(strlen($s_item)>50) $s_item="...".substr($s_item,-47);
	show_menu();
	show_header($GLOBALS["messages"]["actedit"].": /".$s_item);
	
	// Wordwrap (works only in IE)
?><script language="JavaScript1.2" type="text/javascript">
<!--
	function chwrap() {
		if(document.editfrm.wrap.checked) {
			document.editfrm.code.wrap="soft";
		} else {
			document.editfrm.code.wrap="off";
		}
	}
// -->
</script><?php

	echo '<div id="ctr" align="center">
	<div class="install round_borders">
	<div class="clr"></div>';
	// Form
	echo "<br/><form name=\"editfrm\" method=\"post\" action=\"".make_link("edit",$dir,$item)."\">\n";
	echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n"; 
 
	echo "
<table summary=''>
	<tr>
		<td><input type=\"submit\" value=\"".$GLOBALS["messages"]["btnsave"]."\" /></td>
		<td><input type=\"reset\" value=\"".$GLOBALS["messages"]["btnreset"]."\" /></td>
		<td><input type=\"button\" value=\"".$GLOBALS["messages"]["btnclose"]."\" onclick=\"javascript:location='". make_link("list",$dir,NULL)."';\" /></td>
	</tr>
	<tr>
		<td colspan=\"3\">
			<input type=\"checkbox\" value=\"1\" checked name=\"return_to_dir\" id=\"return_to_dir\" />
			<label for=\"return_to_dir\">" . $GLOBALS["messages"]["edit_return"] . "</label>
		</td>
	</tr>
</table>";
		
	echo "<input type=\"hidden\" name=\"dosave\" value=\"yes\" />\n";
	echo "<textarea name=\"code\" rows=\"25\" cols=\"120\" wrap=\"off\">";
	// Show File In TextArea
	$buffer="";
	while(!feof ($fp)) {
		$buffer .= fgets($fp, 4096);
	}
	@fclose($fp);
	if( get_magic_quotes_runtime()) {
		$buffer = stripslashes( $buffer );
	}
	// echo htmlspecialchars($buffer, ENT_COMPAT , "UTF-8");
	echo htmlspecialchars($buffer);
	echo "</textarea><br/>";
	
	echo "
<table summary=''>
	<tr>
		<td align=\"right\"><label for=\"wrap\">Wordwrap: (IE only)</label></td>
		<td><input type=\"checkbox\" id=\"wrap\" name=\"wrap\" onclick=\"javascript:chwrap();\" value=\"1\"></td>
		
	</tr>
	<tr>
		<td align=\"right\"><label for=\"fname\">Copy file into this filename</label></td>
		<td><input type=\"text\" name=\"fname\" value=\"".$item."\" size=\"40\" /></td>
	</tr>
</table>
<br/>";
	
	echo "
</form>
</div></div>
<br/>\n";
	
?><script language="JavaScript1.2" type="text/javascript">
<!--
	if(document.editfrm) document.editfrm.code.focus();
// -->
</script><?php
}
//------------------------------------------------------------------------------
?>
