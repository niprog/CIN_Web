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

     The Original Code is fun_users.php, released on 2003-03-31.

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
	Administrative Functions

	Have Fun...

This file was modified by the TinyWebgallery project to work as backend for
TinyWebgallery.
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
function load_users() {
  // _QUIXPLORER_PATH.
  clearstatcache();
  if (file_exists(dirname(__FILE__) . "/../_config/.htusers.php")) {
    require dirname(__FILE__) . "/../_config/.htusers.php";
	} else {
	echo "<script type=\"text/javascript\">
	alert('". $GLOBALS["error_msg"]["users_file_missing"] ."');
	</script>";
	return;
	}
}
//------------------------------------------------------------------------------
function save_users() {
    $cnt=count($GLOBALS["users"]);
	if($cnt>0) sort($GLOBALS["users"]);
    // Make PHP-File
	$content='<?php
	/** ensure this file is being included by a parent file */
	defined( "_VALID_TWG" ) or die( "Direct Access to this location is not allowed." );
	$GLOBALS["users"]=array(';
	for($i=0;$i<$cnt;++$i) {
		$content.="\r\n\tarray(\"".$GLOBALS["users"][$i][0].'","'.
			$GLOBALS["users"][$i][1].'","'.$GLOBALS["users"][$i][2].'","'.$GLOBALS["users"][$i][3].'",'.
			$GLOBALS["users"][$i][4].',"'.$GLOBALS["users"][$i][5].'",'.$GLOBALS["users"][$i][6].','.
			$GLOBALS["users"][$i][7].'),';
	}
	$content.="\r\n); ?>";

	// Write to File
	$fp = fopen(dirname(__FILE__) . '/../_config/.htusers.php', "w");
	if($fp===false) return false;	// Error
	fputs($fp,$content);
	fclose($fp);

	return true;
}
//------------------------------------------------------------------------------
function find_user($user,$pass) {
	$cnt=count($GLOBALS["users"]);
	for($i=0;$i<$cnt;++$i) {
		if($user==$GLOBALS["users"][$i][0]) {
			if($pass==NULL || ($pass==$GLOBALS["users"][$i][1] &&
				$GLOBALS["users"][$i][7]))
			{
				return $GLOBALS["users"][$i];
			}
		}
	}
}
//------------------------------------------------------------------------------
function find_user_id($user,$pass) {
	$cnt=count($GLOBALS["users"]);
	for($i=0;$i<$cnt;++$i) {
		if($user==$GLOBALS["users"][$i][0]) {
			if($pass==NULL || ($pass==$GLOBALS["users"][$i][1] &&
				$GLOBALS["users"][$i][7]))
			{
				return $i;
			}
		}
	}
}
//------------------------------------------------------------------------------
function activate_user($user,$pass) {
	$data=find_user($user,$pass);	
     // no valid login
     if($data==NULL) return false;
     $GLOBALS["low_permissions"] = false;
     // Set Login
	$GLOBALS['__SESSION']["s_user"]	= $data[0];
	$GLOBALS['__SESSION']["s_pass"]	= $data[1];
	$GLOBALS["home_dir"]	= $GLOBALS["home_url"]	= "../" .  $data[2];
	$GLOBALS["show_hidden"]	= $data[4];
	// $GLOBALS["no_access"]	=   $data[5]; // not used anymore hidden files start with .
	
     $_SESSION["s_home_dir"] = $data[2];
     $_SESSION["upload_settings"] = $GLOBALS["upload_settings"] = (int) $data[3]; 
     $_SESSION["twg_permissions"] = $GLOBALS["permissions"]	= $data[6]; 
     $_SESSION["mywebgallerie_login"] = "ok";
     $_SESSION['TFU_USER'] = $user;
	 $_SESSION["TFU_HIDE_HIDDEN_FILES"] = $GLOBALS["show_hidden"];
    $backend=((($GLOBALS["permissions"]&04)==04) || (($GLOBALS["permissions"]&02)==02));
	if ($backend) {
	  return true;
	} else {
	  $GLOBALS["low_permissions"] = true;
	  return false;
	}
}
//------------------------------------------------------------------------------
function update_user($user,$new_data) {
	$data_id=find_user_id($user,NULL);
	$GLOBALS["users"][$data_id] = $new_data;
	return save_users();
}
//------------------------------------------------------------------------------
function add_user($data) {
	if(find_user($data[0],NULL)) return false;
	$GLOBALS["users"][]=$data;
	return save_users();
}
//------------------------------------------------------------------------------
function remove_user($user) {
  $data=find_user($user,NULL);
	if($data==NULL) return false;
	// Copy Valid Users
	$cnt=count($GLOBALS["users"]);
	for($i=0;$i<$cnt;++$i) {
		if($GLOBALS["users"][$i][0]!=$user) $save_users[]=$GLOBALS["users"][$i];
	}
	$GLOBALS["users"]=$save_users;
	return save_users();
}
//------------------------------------------------------------------------------
function isDefaultAdminPasswd() {
define ( "_QUIXPLORER_PATH", "./admin" );
load_users();
if(find_user("admin","df29098049ba5fbed1e599a4f7aca9d1")) return true;
   return false;
}
//------------------------------------------------------------------------------
?>