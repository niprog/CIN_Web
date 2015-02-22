<?php
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is fun_rename.php, released on 2005-11-07.

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
	Rename Dir/File Functions
	
	Have Fun...
	
This file was modified by the TinyWebgallery project to work as backend for 
TinyWebgallery.
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
function rename_item($dir, $item) {		// rename directory or file
	global $autocreate_folder_id;
	if(($GLOBALS["permissions"]&01)!=01) {
		show_error($GLOBALS["error_msg"]["accessfunc"]);
	}
	
	
	if(isset($GLOBALS['__POST']["confirm"]) && $GLOBALS['__POST']["confirm"]=="true") {
		
		$newitemname=$GLOBALS['__POST']["newitemname"];
		$newitemname=trim(basename(stripslashes($newitemname)));
		
		if($newitemname=='' ) {
			show_error($GLOBALS["error_msg"]["miscnoname"]);
		}
		
		$abs_old = get_abs_item($dir,$item);
		$abs_new = get_abs_item($dir,$newitemname);
		
		if(@file_exists($abs_new)) {
			show_error($newitemname.": ".$GLOBALS["error_msg"]["itemdoesexist"]);
		}
		$perms_old = fileperms( $abs_old );
		
		$ok=rename( $abs_old, $abs_new );
		if (is_chmodable( $abs_new )) {
		   chmod( $abs_new, $perms_old );
		}
		
		if($ok===false) {
			show_error(sprintf($GLOBALS["error_msg"]["rename_not"], $item, $newitemname));
		}
		
		$msg = sprintf( $GLOBALS['messages']['success_rename_file'], $item, $newitemname );
    $_SESSION["user_msg"]=$msg;
    header("Location: ".make_link("list",$dir,NULL));
	}
	show_menu();
	show_header($GLOBALS["messages"]["rename_header"]);

echo '<form method="post" action="';
echo make_link("rename",$dir,$item) . "\">\n";
echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n";  
echo '<div id="ctr" align="center">
	<div class="install round_borders">
	<div class="clr"></div>';
  if (!$autocreate_folder_id) {
      echo $GLOBALS["messages"]["movewarning"] ."<br>";
  }
	// Form
	echo "<br>\n";
	echo "<input type=\"hidden\" name=\"confirm\" value=\"true\" />\n";	
	echo "<input type=\"hidden\" name=\"item\" value=\"".stripslashes($GLOBALS['__GET']["item"])."\" />\n";

	// Submit / Cancel
	echo "<table summary=''>\n<tr><td colspan=\"2\">\n";
	echo "<label for=\"newitemname\">".$GLOBALS["messages"]["rename_new"]."</label>&nbsp;&nbsp;&nbsp;<input name=\"newitemname\" id=\"newitemname\" type=\"text\" size=\"60\" value=\"".stripslashes($_GET['item'])."\" /><br><br><br></td></tr>\n";
	echo "<tr><td>\n<input type=\"submit\" value=\"".$GLOBALS["messages"]["btnchange"];
	echo "\"></td>\n<td><input type=\"button\" value=\"".$GLOBALS["messages"]["btncancel"];
	echo "\" onclick=\"javascript:location='".make_link("list",$dir,NULL)."';\">\n</td></tr></table><br></div></div></form>\n";
}
//------------------------------------------------------------------------------
?>
