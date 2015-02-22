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

     The Original Code is fun_admin.php, released on 2003-03-31.

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
function admin($admin, $dir) {			// Change Password & Manage Users Form
	show_menu();
	// show_header($GLOBALS["messages"]["actadmin"]);
	
	show_message();
	// Javascript functions:
	include _QUIXPLORER_PATH . "/_include/js_admin.php";
	
	show_twg_header();

	// we add the TWG style ....
	echo '<div id="ctr" align="center">
	<div class="install round_borders">
	<div id="step">'.$GLOBALS["menu_messages"]["admin"].'</div>
	<div class="clr"></div>';
    
  echo $GLOBALS["error_msg"]["userfile"]; 
		
		if (file_exists( "_config/.htusers.php")) {
		  echo is_writable( "_config/.htusers.php" ) ? $GLOBALS["error_msg"]["admin_ok"] : $GLOBALS["error_msg"]["admin_not_writeable"];
		} else {
		  echo $GLOBALS["error_msg"]["admin_not_available"];
		}

	// Change Password
	echo "<FORM name=\"chpwd\" action=\"".make_link("admin",$dir,NULL)."\" method=\"post\">\n";
  echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n"; 
  echo "<input type=\"hidden\" name=\"action2\" value=\"chpwd\">\n";
	echo "<br/><TABLE summary=\"\"  width=\"650\"><tr><td colspan=\"2\"><h1>";
	echo $GLOBALS["messages"]["actchpwd"].":</h1></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscoldpass"].": </td><td align=\"right\">";
	echo "<input type=\"password\" name=\"oldpwd\" size=\"25\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscnewpass"].": </td><td align=\"right\">";
	echo "<input type=\"password\" name=\"newpwd1\" size=\"25\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscconfnewpass"].": </td><td align=\"right\">";
	echo "<input type=\"password\" name=\"newpwd2\" size=\"25\"></td></tr>\n";
	echo "<tr><td colspan=\"2\" align=\"right\"><input type=\"submit\" class=\"button\" value=\"".$GLOBALS["messages"]["btnchange"];
	echo "\" onClick=\"return check_pwd();\">\n</td></tr></TABLE></FORM>\n";
	
	// Edit / Add / Remove User
	if($admin) {
		echo "<FORM name=\"userform\" action=\"".make_link("admin",$dir,NULL)."\" method=\"post\">\n";
    echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n"; 
  	echo "<input type=\"hidden\" name=\"action2\" value=\"edituser\">\n";
		echo "<TABLE cellspacing=1 cellpadding=3 summary=\"\" width=\"650\"><tr><td colspan=\"7\" nowrap>";
		echo "<h1>".$GLOBALS["messages"]["actusers"].":</h1></td></tr>\n";
		echo "<tr><td colspan=\"7\">".$GLOBALS["messages"]["miscuseritems"]."</td></tr>\n";
		$cnt=count($GLOBALS["users"]);
		for($i=0;$i<$cnt;++$i) {
			// Username & Home dir:
			$user=$GLOBALS["users"][$i][0];	if(strlen($user)>15) $user=substr($user,0,12)."...";
			$home=$GLOBALS["users"][$i][2];	if(strlen($home)>30) $home=substr($home,0,27)."...";
			
			echo "<tr><td class=\"usertable\"  width=\"1%\"><input TYPE=\"radio\" name=\"user\" value=\"";
			echo $GLOBALS["users"][$i][0]."\"".(($i==0)?" checked":"")."></td>\n";
			echo "<td class=\"usertable\" width=\"17%\">".$user."</td><td class=\"usertable\" width=\"27%\">".$home."</td>\n";
			echo "<td class=\"usertable\" width=\"3%\">".($GLOBALS["users"][$i][4]?$GLOBALS["messages"]["miscyesno"][2]:
				$GLOBALS["messages"]["miscyesno"][3])."</td>\n";    
			echo "<td class=\"usertable\" width=\"20%\">".$GLOBALS["messages"]["miscpermnames"][array_search($GLOBALS["users"][$i][6], array(8,0,1,3,7))]."</td>\n";
			echo "<td class=\"usertable\" width=\"30%\">".$GLOBALS["messages"]["miscuploadnames"][array_search($GLOBALS["users"][$i][3], array('15','7','3','1'))]."</td>\n";
			echo "<td class=\"usertable\" width=\"3%\">".($GLOBALS["users"][$i][7]?$GLOBALS["messages"]["miscyesno"][2]:
				$GLOBALS["messages"]["miscyesno"][3])."</td></tr>\n";
		}
		echo "<tr><td colspan=\"6\" align=\"right\">";
		echo "<input type=\"button\" class=\"button\" value=\"".$GLOBALS["messages"]["btnadd"];
		echo "\" onClick=\"javascript:location='".make_html_link("admin",$dir,NULL)."&amp;action2=adduser';\">\n";
		echo "<input type=\"button\" class=\"button\" value=\"".$GLOBALS["messages"]["btnedit"];
		echo "\" onClick=\"javascript:Edit();\">\n";
		echo "<input type=\"button\" class=\"button\" value=\"".$GLOBALS["messages"]["btnremove"];
		echo "\" onClick=\"javascript:Delete();\">\n</td></tr></TABLE></FORM>\n";
	}

	echo "</div></div>";
	
?><script language="JavaScript1.2" type="text/javascript">
<!--
	if(document.chpwd) document.chpwd.oldpwd.focus();
// -->
</script><?php
}
//------------------------------------------------------------------------------
function changepwd($dir) {			// Change Password
	$pwd=md5(stripslashes($GLOBALS['__POST']["oldpwd"]));
	if($GLOBALS['__POST']["newpwd1"]!=$GLOBALS['__POST']["newpwd2"]) show_error($GLOBALS["error_msg"]["miscnopassmatch"]);
	
	$data=find_user($GLOBALS['__SESSION']["s_user"],$pwd);
	if($data==NULL) show_error($GLOBALS["error_msg"]["miscnouserpass"]);
	
	$data[1]=md5(stripslashes($GLOBALS['__POST']["newpwd1"]));
	if(!update_user($data[0],$data)) show_error($data[0].": ".$GLOBALS["error_msg"]["chpass"]);
	activate_user($data[0],NULL);
	
	
	$_SESSION["user_msg"]=$GLOBALS["messages"]["passchanged"];
	header("location: ".make_link("admin",$dir,NULL));
}
//------------------------------------------------------------------------------
function adduser($dir) {			// Add User
  global $basedir;

  if(isset($GLOBALS['__POST']["confirm"]) && $GLOBALS['__POST']["confirm"]=="true") {
		$user=stripslashes($GLOBALS['__POST']["user"]);
		if($user=="" || $GLOBALS['__POST']["home_dir"]=="") {
			show_error($GLOBALS["error_msg"]["miscfieldmissed"]);
		}
		if($GLOBALS['__POST']["pass1"]!=$GLOBALS['__POST']["pass2"]) show_error($GLOBALS["error_msg"]["miscnopassmatch"]);
		$data=find_user($user,NULL);
		if($data!=NULL) show_error($user.": ".$GLOBALS["error_msg"]["miscuserexist"]);
		// checks if a users has a | in the folder - this is only allowed for front end users.
		if (checkFolder($GLOBALS['__POST']["home_dir"],$GLOBALS['__POST']["permissions"])) {
		  show_error($GLOBALS["error_msg"]["multiplefolder"]);
		}
		if (!checkFolderContent($GLOBALS['__POST']["home_dir"])) {
       $GLOBALS['__POST']["home_dir"] = ".";
    }
		
		$data=array($user,md5(stripslashes($GLOBALS['__POST']["pass1"])),
			stripslashes($GLOBALS['__POST']["home_dir"]),stripslashes($GLOBALS['__POST']["upload_settings"]),
			$GLOBALS['__POST']["show_hidden"],stripslashes($GLOBALS['__POST']["no_access"]),
			$GLOBALS['__POST']["permissions"],$GLOBALS['__POST']["active"]);
			
		if(!add_user($data)) show_error($user.": ".$GLOBALS["error_msg"]["adduser"]);
		header("location: ".make_link("admin",$dir,NULL));
		return;
	}
	
	show_menu();
	show_header($GLOBALS["messages"]["actadmin"].": ".$GLOBALS["messages"]["miscadduser"]);
	echo'<script type="text/javascript" language="Javascript" src="_js/overlib_mini.js"></script>';
	
	// Javascript functions:
	include _QUIXPLORER_PATH . "/_include/js_admin2.php";
	
		// we add the TWG style ....
		echo '<div id="ctr" align="center">
		<div class="install round_borders">
		<div id="step">Add User</div>
		<div class="clr"></div>';
	
	show_user_help();
	
	echo "<form name=\"adduser\" action=\"".make_link("admin",$dir,NULL)."&amp;action2=adduser\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n"; 
  echo "<input type=\"hidden\" name=\"confirm\" value=\"true\"><br/><TABLE summary=\"\" width=\"450\">\n";
	
	echo "<tr><td>".$GLOBALS["messages"]["miscusername"].":</td>\n";
		echo "<td align=\"right\"><input type=\"text\" name=\"user\" size=\"30\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscpassword"].":</td>\n";
		echo "<td align=\"right\"><input type=\"password\" name=\"pass1\" size=\"30\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscconfpass"].":</td>\n";
		echo "<td align=\"right\"><input type=\"password\" name=\"pass2\" size=\"30\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["mischomedir"].":</td>\n";
		echo "<td align=\"right\"><input type=\"text\" name=\"home_dir\" size=\"30\" value=\"";
		echo basename($basedir) ."\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscshowhidden"].":</td>";
		echo "<td align=\"right\"><select name=\"show_hidden\">\n";
		echo "<option value=\"0\">".$GLOBALS["messages"]["miscyesno"][1]."</option>";
		echo "<option value=\"1\">".$GLOBALS["messages"]["miscyesno"][0]."</option>\n";
		echo "</select></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["mischidepattern"].":</td>\n";
		echo "<td align=\"right\">^.<input type=\"hidden\" name=\"no_access\" size=\"30\" value=\"^\\.ht\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscperms"].":</td><td align=\"right\"><select name=\"permissions\">\n";
		$permvalues = array(8,0,1,3,7);
		for($i=0;$i<count($GLOBALS["messages"]["miscpermnames"]);++$i) {
			echo "<option value=\"".$permvalues[$i]."\">";
			echo $GLOBALS["messages"]["miscpermnames"][$i]."</option>\n";
		}
		echo "</select></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscupload"].":";
  echo '&nbsp;<img alt="" ';
  writeHelp("rights");
  echo ' src="_img/help.gif">';
  echo "</td><td align=\"right\"><select name=\"upload_settings\">\n";	
		$uploadvalues = array("15","7","3","1");
			for($i=0;$i<count($GLOBALS["messages"]["miscuploadnames"]);++$i) {
			echo "<option value=\"".$uploadvalues[$i]."\">";
			echo $GLOBALS["messages"]["miscuploadnames"][$i]."</option>\n";
		}
		echo "</select></td></tr>\n";	
		
	echo "<tr><td>".$GLOBALS["messages"]["miscactive"].":</td>";
		echo "<td align=\"right\"><select name=\"active\">\n";
		echo "<option value=\"1\">".$GLOBALS["messages"]["miscyesno"][0]."</option>";
		echo "<option value=\"0\">".$GLOBALS["messages"]["miscyesno"][1]."</option>\n";
		echo "</select></td></tr>\n";
	echo "<tr><td colspan=\"2\" align=\"right\"><input type=\"submit\" class=\"button\" value=\"".$GLOBALS["messages"]["btnadd"];
		echo "\" onClick=\"return check_pwd();\">\n<input type=\"button\" class=\"button\"  value=\"";
		echo $GLOBALS["messages"]["btncancel"]."\" onClick=\"javascript:location='";
		echo make_html_link("admin",$dir,NULL)."';\"></td></tr></TABLE></FORM><br/>\n";
		
		echo "</div></div>";
?><script language="JavaScript1.2" type="text/javascript">
<!--
	if(document.adduser) document.adduser.user.focus();
// -->
</script><?php
}
//------------------------------------------------------------------------------
function edituser($dir) {			// Edit User
	
  $user=stripslashes($GLOBALS['__POST']["user"]);
	$data=find_user($user,NULL);
	if($data==NULL) show_error($user.": ".$GLOBALS["error_msg"]["miscnofinduser"]);
	if($self=($user==$GLOBALS['__SESSION']["s_user"])) $dir="";
	
	if(isset($GLOBALS['__POST']["confirm"]) && $GLOBALS['__POST']["confirm"]=="true") {
		$nuser=stripslashes($GLOBALS['__POST']["nuser"]);
		if($nuser=="" || $GLOBALS['__POST']["home_dir"]=="") {
			show_error($GLOBALS["error_msg"]["miscfieldmissed"]);
		}
		// checks if a users has a | in the folder - this is only allowed for front end users.
		if (checkFolder($GLOBALS['__POST']["home_dir"],$GLOBALS['__POST']["permissions"])) {
		  show_error($GLOBALS["error_msg"]["multiplefolder"]);
		}
		if (!checkFolderContent($GLOBALS['__POST']["home_dir"])) {
       $GLOBALS['__POST']["home_dir"] = ".";
    }
		if(isset($GLOBALS['__POST']["chpass"]) &&
			$GLOBALS['__POST']["chpass"]=="true")
		{
			if($GLOBALS['__POST']["pass1"]!=$GLOBALS['__POST']["pass2"]) show_error($GLOBALS["error_msg"]["miscnopassmatch"]);
			$pass=md5(stripslashes($GLOBALS['__POST']["pass1"]));
		} else $pass=$data[1];
		
		if($self) $GLOBALS['__POST']["active"]=1;
		
		$data=array($nuser,$pass,stripslashes($GLOBALS['__POST']["home_dir"]),
			stripslashes($GLOBALS['__POST']["upload_settings"]),$GLOBALS['__POST']["show_hidden"],
			stripslashes($GLOBALS['__POST']["no_access"]),$GLOBALS['__POST']["permissions"],$GLOBALS['__POST']["active"]);
			
		if(!update_user($user,$data)) show_error($user.": ".$GLOBALS["error_msg"]["saveuser"]);
		if($self) activate_user($nuser,NULL);
		
		header("location: ".make_link("admin",$dir,NULL));
		return;
	}
	
	show_menu();
	show_header($GLOBALS["messages"]["actadmin"].": ".sprintf($GLOBALS["messages"]["miscedituser"],$data[0]));
	echo'<script type="text/javascript" language="Javascript" src="_js/overlib_mini.js"></script>';

	// Javascript functions:
	include _QUIXPLORER_PATH . "/_include/js_admin3.php";
	
		// we add the TWG style ....
		echo '<div id="ctr" align="center">
		<div class="install round_borders">
		<div id="step">' . $GLOBALS["messages"]["edituser"] . '</div>
		<div class="clr"></div>
		';
		
		show_user_help();
	
	
	echo "<FORM name=\"edituser\" action=\"".make_link("admin",$dir,NULL)."&amp;action2=edituser\" method=\"post\">\n";
  echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n"; 
	echo "<input type=\"hidden\" name=\"confirm\" value=\"true\"><input type=\"hidden\" name=\"user\" value=\"".$data[0]."\">\n";
	echo "<br/><TABLE summary=\"\" width=\"450\">\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscusername"].":</td>\n";
		echo "<td align=\"right\"><input type=\"text\" name=\"nuser\" size=\"30\" value=\"";
		echo $data[0]."\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscconfpass"].":</td>\n";
		echo "<td align=\"right\"><input type=\"password\" name=\"pass1\" size=\"30\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscconfnewpass"].":</td>\n";
		echo "<td align=\"right\"><input type=\"password\" name=\"pass2\" size=\"30\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscchpass"].":</td>\n";
		echo "<td align=\"right\"><input type=\"checkbox\" name=\"chpass\" value=\"true\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["mischomedir"].":</td>\n";	
		echo "<td align=\"right\"><input type=\"text\" name=\"home_dir\" size=\"30\" value=\"";
		echo $data[2]."\"></td></tr>\n";
	// echo "<tr><td>".$GLOBALS["messages"]["mischomeurl"].":</td>\n";	
	//	echo "<td align=\"right\"><input type=\"text\" name=\"home_url\" size=\"30\" value=\"";
	//	echo $data[3]."\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscshowhidden"].":</td>";
		echo "<td align=\"right\"><select name=\"show_hidden\">\n";
		echo "<option value=\"0\">".$GLOBALS["messages"]["miscyesno"][1]."</option>";
		echo "<option value=\"1\"".($data[4]?" selected ":"").">";
		echo $GLOBALS["messages"]["miscyesno"][0]."</option>\n";
		echo "</select></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["mischidepattern"].":</td>\n";
		echo "<td align=\"right\">^.<input type=\"hidden\" name=\"no_access\" size=\"30\" value=\"";
		echo $data[5]."\"></td></tr>\n";
	echo "<tr><td>".$GLOBALS["messages"]["miscperms"].":</td><td align=\"right\"><select name=\"permissions\">\n";
		$permvalues = array(8,0,1,3,7);
		for($i=0;$i<count($GLOBALS["messages"]["miscpermnames"]);++$i) {
			echo "<option value=\"".$permvalues[$i]."\"".($permvalues[$i]==$data[6]?" selected ":"").">";
			echo $GLOBALS["messages"]["miscpermnames"][$i]."</option>\n";
		}
		echo "</select></td></tr>\n";
	
	echo "</td><td>";
    
	
	echo "<tr><td>".$GLOBALS["messages"]["miscupload"].":";
  echo '&nbsp;<img alt="" ';
  writeHelp("rights");
  echo ' src="_img/help.gif">';
  echo "</td><td align=\"right\"><select name=\"upload_settings\">\n";
	$uploadvalues = array("15","7","3","1");
		for($i=0;$i<count($GLOBALS["messages"]["miscuploadnames"]);++$i) {
				echo "<option value=\"".$uploadvalues[$i]."\"".($uploadvalues[$i]==$data[3]?" selected ":"").">";
				echo $GLOBALS["messages"]["miscuploadnames"][$i]."</option>\n";
			}
		echo "</select></td></tr>\n";	
		
	echo "<tr><td>".$GLOBALS["messages"]["miscactive"].":</td>";
		echo "<td align=\"right\"><select name=\"active\"".($self?" DISABLED ":"").">\n";
		echo "<option value=\"1\">".$GLOBALS["messages"]["miscyesno"][0]."</option>";
		echo "<option value=\"0\"".($data[7]?"":" selected ").">";
		echo $GLOBALS["messages"]["miscyesno"][1]."</option>\n";
		echo "</select></td></tr>\n";
	echo "<tr><td colspan=\"2\" align=\"right\"><input type=\"submit\" class=\"button\" value=\"".$GLOBALS["messages"]["btnsave"];
		echo "\" onclick=\"return check_pwd();\">\n<input type=\"button\" class=\"button\" value=\"";
		echo $GLOBALS["messages"]["btncancel"]."\" onClick=\"javascript:location='";
		echo make_html_link("admin",$dir,NULL)."';\"></td></tr></table></form><br/>\n";
		
		echo "</div></div>";
		
}
//------------------------------------------------------------------------------
function removeuser($dir) {			// Remove User
	$user=stripslashes($GLOBALS['__POST']["user"]);
	if($user==$GLOBALS['__SESSION']["s_user"]) show_error($GLOBALS["error_msg"]["miscselfremove"]);
	if(!remove_user($user)) show_error($user.": ".$GLOBALS["error_msg"]["deluser"]);
	
	header("location: ".make_link("admin",$dir,NULL));
}

function show_user_help() {
  echo "<div class=leftalign>";
  echo  $GLOBALS["messages"]["user_help_text"] . "<br><br>";
  echo "<ul>";
  echo "<li>".$GLOBALS["messages"]["user_help_1"]."</li>";
  echo "<li>".$GLOBALS["messages"]["user_help_2"]."</li>";
  echo "<li>".$GLOBALS["messages"]["user_help_3"]."</li>";
  echo "<li>".$GLOBALS["messages"]["user_help_4"]."</li>";
  echo "</ul>";
  echo "</div>";
}


//------------------------------------------------------------------------------
function show_admin($dir) {			// Execute Admin Action
	$pwd=(($GLOBALS["permissions"]&2)==2);
	$admin=(($GLOBALS["permissions"]&4)==4);
	
	if(!$GLOBALS["require_login"]) show_error($GLOBALS["error_msg"]["miscnofunc"]);
	if(!$pwd && !$admin) show_error($GLOBALS["error_msg"]["accessfunc"]);
	
	if(isset($GLOBALS['__GET']["action2"])) $action2 = $GLOBALS['__GET']["action2"];
	elseif(isset($GLOBALS['__POST']["action2"])) $action2 = $GLOBALS['__POST']["action2"];
	else $action2="";

   if ($GLOBALS['__GET']["action"] != 'admin' && $GLOBALS['__GET']["action"] != 'login' ) { 	
      if ($GLOBALS['__POST']) {
        $user=stripslashes($GLOBALS['__POST']["user"]);
    		if($user=="" || $GLOBALS['__POST']["home_dir"]=="") {
    			show_error($GLOBALS["error_msg"]["miscfieldmissed"]);
    		}
    		if($GLOBALS['__POST']["pass1"]!=$GLOBALS['__POST']["pass2"]) show_error($GLOBALS["error_msg"]["miscnopassmatch"]);
    		$data=find_user($user,NULL);
    		if($data!=NULL) show_error($user.": ".$GLOBALS["error_msg"]["miscuserexist"]);
    		// checks if a users has a | in the folder - this is only allowed for front end users.
    		if (checkFolder($GLOBALS['__POST']["home_dir"],$GLOBALS['__POST']["permissions"])) {
    		  show_error($GLOBALS["error_msg"]["multiplefolder"]);
    		}
    		if (!checkFolderContent($GLOBALS['__POST']["home_dir"])) {
           $GLOBALS['__POST']["home_dir"] = ".";
        }
      }
    }
    
    
	switch($action2) {
	case "chpwd":
		changepwd($dir);
	break;
	case "adduser":
		if(!$admin) show_error($GLOBALS["error_msg"]["accessfunc"]);
		adduser($dir);
	break;
	case "edituser":
		if(!$admin) show_error($GLOBALS["error_msg"]["accessfunc"]);
		edituser($dir);
	break;
	case "rmuser":
		if(!$admin) show_error($GLOBALS["error_msg"]["accessfunc"]);
		removeuser($dir);
	break;
	default:
		admin($admin,$dir);
	}
}

function get_display_text_perm($perm_id) {
return $GLOBALS["messages"]["miscpermnames"][array_search($perm_id, array(8,0,1,3,7))];
}

/**
*  Checks if a users has a | in the folder - this is only allowed for front end users.	
*/
function checkFolder($folder, $permissions) {
  $backend=($permissions&2)==2;
  $admin=  ($permissions&4)==4;
  if ($backend || $admin) {
      return  !(strpos($folder, "|") === false);
  } else {
      return false;
  } 
}

function checkFolderContent($folder) {
  if ($folder == "\\") {
    return false;
  }
  return true;
}

//------------------------------------------------------------------------------
?>
