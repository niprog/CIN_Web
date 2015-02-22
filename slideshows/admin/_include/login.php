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

     The Original Code is login.php, released on 2003-03-31.

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
	User Authentication Functions

	Have Fun...

This file was modified by the TinyWebgallery project to work as backend for
TinyWebgallery.
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
require _QUIXPLORER_PATH."/_include/fun_users.php";
load_users();
//------------------------------------------------------------------------------
if(isset($_SESSION)) 			$GLOBALS['__SESSION']=&$_SESSION;
elseif(isset($HTTP_SESSION_VARS))	$GLOBALS['__SESSION']=&$HTTP_SESSION_VARS;
else {
  logout();
  exit;
}
//------------------------------------------------------------------------------
function checkAdminPass() {
  if(isset($GLOBALS['__SESSION']["s_user"])) {
    if ($GLOBALS['__SESSION']["s_user"] == "admin" && $GLOBALS['__SESSION']["s_pass"] == "df29098049ba5fbed1e599a4f7aca9d1") {
        $_SESSION["user_msg"] = $GLOBALS["messages"]["adminpass"];
        if ($GLOBALS["action"] != "info") {
          $GLOBALS["action"] = "admin";
        }
    }
  }
}

function login() {
 	global $my;
	if(isset($GLOBALS['__SESSION']["s_user"])) {
		if(!activate_user($GLOBALS['__SESSION']["s_user"],$GLOBALS['__SESSION']["s_pass"])) {
		  logout(true);
		  exit;
		}
	  checkAdminPass();
	} else {
		if(isset($GLOBALS['__POST']["p_pass"])) $p_pass=$GLOBALS['__POST']["p_pass"];
		else $p_pass="";
	  if(isset($GLOBALS['__POST']["p_user"])) {
			// Check Login
			if(!activate_user(stripslashes($GLOBALS['__POST']["p_user"]), md5(stripslashes($p_pass)))) {
				logout(true);
				exit;
			}
			checkAdminPass();
			log_twg("Login: (IP: ".$_SERVER["REMOTE_ADDR"].") " . $GLOBALS['__POST']["p_user"]);
	
			return;
	  } else {
			 echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"";
			 echo "\"http://www.w3.org/TR/REC-html40/loose.dtd\">\n";

			 echo "<html><head><title>TWG Administration</title>";
			echo "<LINK href=\"_style/style.css\" rel=\"stylesheet\" type=\"text/css\">\n";
	     echo "<script  src=\"_js/admin.js\"  type=\"text/javascript\"></script>\n";
			 echo "</head><body style='background: none'>";

			  // Ask for Login
				// we add the TWG style ....
				echo '<div id="ctr" align="center">
				<div class="install round_borders">
				<div id="step">' . $GLOBALS["messages"]["actlogin"] . '</div>
	      <div class="clr"></div>';

      $linklang = ($GLOBALS["language"] == 'de') ? 'de':'en';
      $more = ' <small><a target="_blank" class="aconfig" href="'.$GLOBALS["twg_home_url"]. '/' . $linklang .'/addon_lang.php">' . $GLOBALS["config_form_block"]["link_more"] . '</a></small>';

			echo "<form name=\"login\" action=\"" . make_link("login",null,null)."\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n"; 
      show_message();
			echo "<br><table summary=\"\" width=\"300\"><tr><td colspan=\"2\" nowrap><b>";
			echo $GLOBALS["messages"]["actloginheader"]."</b></td></tr>\n";
			echo "<tr><td>".$GLOBALS["messages"]["miscusername"].":</td><td align=\"right\">";
			echo "<input name=\"p_user\" type=\"text\" value=\"\" size=\"25\"></td></tr>\n";
			echo "<tr><td>".$GLOBALS["messages"]["miscpassword"].":</td><td align=\"right\">";
			echo "<input name=\"p_pass\" type=\"password\" size=\"25\"></td></tr>\n";
			echo "<tr><td>".$GLOBALS["messages"]["misclang"]. $more .":</td><td align=\"right\">";
			echo "<select name=\"lang\">\n";
			@include _QUIXPLORER_PATH."/_lang/_info.php";
		  echo "</select></td></tr>\n";

			echo "<tr><td colspan=\"2\" align=\"right\"><input type=\"submit\" value=\"";
			echo $GLOBALS["messages"]["btnlogin"]."\"></td></tr>\n</table></form><br>\n";			
			$_SESSION["TWG_SESSION_CHECK"] = "TWG_SESSION_CHECK";
          	set_error_handler("on_error_no_output");// @does not work
               @session_write_close();
               @session_start();
               set_error_handler("on_error");// @does not work
               echo isset($_SESSION["TWG_SESSION_CHECK"]) ? '' : '<font color="red">' . $GLOBALS["error_msg"]["nosession"] . '</font>';
               
               echo "
               </div></div>";
?><script language="JavaScript1.2" type="text/javascript">
<!--
	if(document.login) document.login.p_user.focus();
// -->
</script><?php
      $GLOBALS["action"] = "login";
      show_twg_footer();
			show_footer();
			close_tags();
			exit;
		}
	}
}
//------------------------------------------------------------------------------
function logout($message = true) {
	if ($message && isset($GLOBALS['__POST']["p_pass"])) {	  
	   log_twg("Wrong login: (IP: ".$_SERVER["REMOTE_ADDR"].") " . $GLOBALS['__POST']["p_user"] . "/" .str_repeat("*",strlen($GLOBALS['__POST']["p_pass"])));
	}
	
	if (isset($_SESSION['twg_root_dir'])) {
		$twg_root = trim($_SESSION['twg_root_dir']);
	} else {
		$twg_root = false;
	}
	$GLOBALS['__SESSION']=array();
	@session_destroy();
	@session_start();
     	
	if ($twg_root) {
	    $_SESSION['twg_root_dir'] = $twg_root;
	}
	
	if (isset($GLOBALS["low_permissions"])) {
	  $_SESSION["user_msg"]= $GLOBALS["messages"]["lowpermissions"];
	  header("location: ".$GLOBALS["script_name"]);
	} else if ($message) {
	  // $_SESSION["user_msg_counter"]="set";
	  $_SESSION["user_msg"]= $GLOBALS["messages"]["wronglogin"];
	  header("location: ".$GLOBALS["script_name"]);
	} else {
	  //if ($twg_root) {
	  //  header("location: ".$twg_root);
	  //} else {
	    header("location: ".$GLOBALS["script_name"]);
	  //}

	}
}
//------------------------------------------------------------------------------
?>
