<?php
/**
 * * ensure this file is being included by a parent file
 */
defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is init.php, released on 2003-03-31.

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
	Main File

	Have Fun...

This file was modified by the TinyWebgallery project to work as backend for
TinyWebgallery.
------------------------------------------------------------------------------*/
// ------------------------------------------------------------------------------
 set_error_handler("on_error_no_output");// @does not work
 @session_start();
 set_error_handler("on_error");

function check_post($postarray) {  
  foreach ($postarray as $key => $maxlength) {   
    if (isset($GLOBALS['__POST'][$key])) {
      $GLOBALS['__POST'][$key] = parse_maxlength(replaceInput($GLOBALS['__POST'][$key]),$maxlength);
    }
  }
}

global $input_invalid;
$input_invalid = false;

// Vars
if (isset($_SERVER)) {
    $GLOBALS['__GET'] = &$_GET;
    $GLOBALS['__POST'] = &$_POST;
    $GLOBALS['__SERVER'] = &$_SERVER;
    $GLOBALS['__FILES'] = &$_FILES;
} elseif (isset($HTTP_SERVER_VARS)) {
    $GLOBALS['__GET'] = &$HTTP_GET_VARS;
    $GLOBALS['__POST'] = &$HTTP_POST_VARS;
    $GLOBALS['__SERVER'] = &$HTTP_SERVER_VARS;
    $GLOBALS['__FILES'] = &$HTTP_POST_FILES;
} else {
    die("<strong>ERROR: Your PHP version is too old</strong><br/>" . "You need at least PHP 4.0.0 to run TWGXplorer; preferably PHP 4.4.1 or higher.");
}

// check token for posts!
if (!empty($GLOBALS['__POST'])) {   // post !
  if (!isset($GLOBALS['__POST']['token'])) {
     $input_invalid = true;
  } else {
     // check if the token is o.k.
     if  ($GLOBALS['__POST']['token'] != md5(session_id())) {
       $input_invalid = true;
     }
  }
}

// check input
if (isset($GLOBALS['__GET']["sview"])) {
  $GLOBALS['__GET']["sview"] = parse_maxlength(replaceInput($GLOBALS['__GET']["sview"]),5);
}
if (isset($GLOBALS['__GET']["tview"])) {
  $GLOBALS['__GET']["tview"] = parse_maxlength(replaceInput($GLOBALS['__GET']["tview"]),5);
}

// post parameter that are checked!

$postarray = array("sview" => 5, "tview"=> 5, "user"=> 30, "nuser"=> 30, "pass1"=> 30,"pass2"=> 30, "oldpwd"=> 30, 
                   "newpwd1"=> 30, "newpwd2"=> 30, "home_dir" => 1000, "upload_settings" => 2, "show_hidden" => 1,
                   "no_access" => 20, "permissions" => 5, "active" => 1);
check_post($postarray);

if (!empty($GLOBALS['__POST']["selitems"])) {
	$cnt=count($GLOBALS['__POST']["selitems"]);
  for($i=0;$i<$cnt;++$i) {
		replaceInput($GLOBALS['__POST']["selitems"][$i]);
	}
}


// ------------------------------------------------------------------------------
// Get Action
if (isset($GLOBALS['__GET']["action"])) $GLOBALS["action"] = parse_maxlength(replaceInput($GLOBALS['__GET']["action"]),15);
else $GLOBALS["action"] = "list";
if (isset($GLOBALS['__POST']["action"])) {
    $GLOBALS["action"] = parse_maxlength(replaceInput($GLOBALS['__POST']["action"]),15);
}

if ($GLOBALS["action"] == "post") {
    if (isset($GLOBALS['__GET']["do_action"]))
        $GLOBALS["action"] = parse_maxlength(replaceInput($GLOBALS['__GET']["do_action"]),15);
    elseif (isset($GLOBALS['__POST']["do_action"]))
        $GLOBALS["action"] = parse_maxlength(replaceInput($GLOBALS['__POST']["do_action"]),15);
}

if ($GLOBALS["action"] == "") $GLOBALS["action"] = "list";
$GLOBALS["action"] = stripslashes($GLOBALS["action"]);
// Default Dir
if (isset($GLOBALS['__GET']["dir"]))
    $GLOBALS["dir"] = replaceInput(stripslashes($GLOBALS['__GET']["dir"]));
else
    $GLOBALS["dir"] = "";
if ($GLOBALS["dir"] == ".")
    $GLOBALS["dir"] == "";
// Get Item
if (isset($GLOBALS['__GET']["item"]))
    $GLOBALS["item"] = replaceInput(stripslashes($GLOBALS['__GET']["item"]));
else
    $GLOBALS["item"] = "";
// Get Sort
if (isset($GLOBALS['__GET']["order"]))
    $GLOBALS["order"] = parse_maxlength(stripslashes(replaceInput($GLOBALS['__GET']["order"])),5);
else
    $GLOBALS["order"] = "name";
if ($GLOBALS["order"] == "")
    $GLOBALS["order"] == "name";
// Get Sortorder (yes==up)
if (isset($GLOBALS['__GET']["srt"]))
    $GLOBALS["srt"] = parse_maxlength(stripslashes(replaceInput($GLOBALS['__GET']["srt"])),5);
else
    $GLOBALS["srt"] = "yes";
if ($GLOBALS["srt"] == "")
    $GLOBALS["srt"] == "yes";
// Get Language
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
  $lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
  if (file_exists(dirname(__FILE__) .  "/../_lang/".$lang_browser.".php")) {
    $GLOBALS["default_language"] = $lang_browser;
  }
}

if (isset($GLOBALS['__GET']["lang"]))  $GLOBALS["lang"] = $GLOBALS["language"] = $_SESSION["admin_lang"] =  basename(parse_maxlength(replaceInput($GLOBALS['__GET']["lang"]),3));
elseif (isset($GLOBALS['__POST']["lang"])) $GLOBALS["lang"] = $GLOBALS["language"] = $_SESSION["admin_lang"] =  basename(parse_maxlength(replaceInput($GLOBALS['__POST']["lang"]),3));
else if (isset($_SESSION["admin_lang"])) $GLOBALS["lang"] = $GLOBALS["language"] = $_SESSION["admin_lang"];  
else $GLOBALS["language"] = $GLOBALS["default_language"];

// get upload parameters
if (isset($GLOBALS['__GET']["twgsize"]))
    $GLOBALS["twgsize"] = parse_maxlength(replaceInput($GLOBALS['__GET']["twgsize"]),10);
elseif (isset($GLOBALS['__POST']["twgsize"]))
    $GLOBALS["twgsize"] = parse_maxlength(replaceInput($GLOBALS['__POST']["twgsize"]),10);
else $GLOBALS["twgsize"] = "10000";


// get upload parameters
if (isset($GLOBALS['__GET'][session_name()]))
    $GLOBALS["ses_name"] = $GLOBALS['__GET'][session_name()];
elseif (isset($GLOBALS['__POST'][session_name()]))
    $GLOBALS["ses_name"] = $GLOBALS['__POST'][session_name()];

// optional helper action for some pages
if (isset($_GET['twg_helper_action'])) {
$helper_action = $_GET['twg_helper_action'];
} else if (isset($_POST['twg_helper_action'])) {
$helper_action = $_POST['twg_helper_action'];
} else  {
$helper_action = "none";
}


// ------------------------------------------------------------------------------
// Necessary files
require _QUIXPLORER_PATH . "/_config/conf.php";

if (file_exists(_QUIXPLORER_PATH . "/_lang/" . $GLOBALS["language"] . ".php"))
    require _QUIXPLORER_PATH . "/_lang/" . $GLOBALS["language"] . ".php";
else if (file_exists(_QUIXPLORER_PATH . "/_lang/" . $GLOBALS["default_language"] . ".php"))
    require _QUIXPLORER_PATH . "/_lang/" . $GLOBALS["default_language"] . ".php";
else
    require _QUIXPLORER_PATH . "/_lang/en.php";

if (file_exists(_QUIXPLORER_PATH . "/_lang/" . $GLOBALS["language"] . "_mimes.php"))
    require _QUIXPLORER_PATH . "/_lang/" . $GLOBALS["language"] . "_mimes.php";
else
    require _QUIXPLORER_PATH . "/_lang/".$GLOBALS["default_language"]."_mimes.php";

if (file_exists(_QUIXPLORER_PATH . "/_lang/". $GLOBALS["language"] ."_config_help.php"))
    require _QUIXPLORER_PATH . "/_lang/". $GLOBALS["language"] ."_config_help.php";
else
    require _QUIXPLORER_PATH . "/_lang/". $GLOBALS["default_language"] ."_config_help.php";

if ($input_invalid) {
  printErrorInvalid();
  die();
}


require _QUIXPLORER_PATH . "/_config/mimes.php";
require _QUIXPLORER_PATH . "/_include/fun_extra.php";
require _QUIXPLORER_PATH . "/_include/header.php";
require _QUIXPLORER_PATH . "/_include/footer.php";
require _QUIXPLORER_PATH . "/_include/error.php";
require _QUIXPLORER_PATH . "/menu.php";


$d=a();

set_error_handler("on_error_no_output");// @does not work
@ob_end_clean(); // get rid of cached unwanted output
set_error_handler("on_error");
// ------------------------------------------------------------------------------

// below are 2 examples to execute admin commands from outside without a login
// please adopt the parameters to your needs.

// If you want that iptc data can be called you have to enable the following lines.
// If you want a little bit more protection add a parameter only you know!
// if ($action=="helper" && $helper_action=='readiptc') {
//   $GLOBALS["require_login"] = false;
// } 

// If you want that the cache can be cleared from outsinde you have to enable the following lines.
// If you want a little bit more protection add a parameter only you know!
// if ($action=="helper" && $helper_action=='delimagecache') {
//   $GLOBALS["require_login"] = false;
// } 


if ($GLOBALS["require_login"]) { // LOGIN
    require "./_include/login.php";
    if ($GLOBALS["action"] == "logout") {
        // $GLOBALS["tview"] = "no";
        logout(false);
        exit;
    } else {
        login();
        if ($GLOBALS["action"] == "login") {
            show_menu();
        }
    }
}
// -- after login because homedir is needed!
// Get view
if (isset($GLOBALS['__GET']["tview"])) {
    if (!isset($_SESSION["autoview"])) { // admin
        $hd = (strpos ($GLOBALS["home_dir"], "pictures") > 0);
        if (($GLOBALS["dir"] == "pictures") || $hd) {
            $GLOBALS["tview"] = "yes";
            $_SESSION["autoview"] = "yes";
        } else {
            $GLOBALS["tview"] = stripslashes($GLOBALS['__GET']["tview"]);
        }
    } else {
        $GLOBALS["tview"] = stripslashes($GLOBALS['__GET']["tview"]);
    }
} else {
    if (!isset($_SESSION["autoview"])) { // user
        $hd = (strpos ($GLOBALS["home_dir"], "pictures") > 0);
        if (($GLOBALS["dir"] == "pictures") || $hd) {
            $GLOBALS["tview"] = "yes";
            $_SESSION["autoview"] = "yes";
        } else {
            $GLOBALS["tview"] = "no";
        }
    } else {
        $GLOBALS["tview"] = "no";
    }
}
if (!isset($GLOBALS["tview"])) {
  $GLOBALS["tview"] = "no";
}

// get simple view parameters
if (isset($GLOBALS['__GET']["sview"]))
    $GLOBALS["sview"] =  $GLOBALS['__GET']["sview"];
elseif (isset($GLOBALS['__POST']["sview"]))
    $GLOBALS["sview"] = $GLOBALS['__POST']["sview"];
else $GLOBALS["sview"] = $GLOBALS["default_simple_view"];

if (isset($GLOBALS['__GET']["twgquality"]))
    $GLOBALS["twgquality"] = $GLOBALS["twgquality"] = $GLOBALS['__GET']["twgquality"];
elseif (isset($GLOBALS['__POST']["twgquality"]))
    $GLOBALS["twgquality"] = $GLOBALS["twgquality"] = $GLOBALS['__POST']["twgquality"];
else $GLOBALS["twgquality"] = $GLOBALS["uploadquality"];


// ------------------------------------------------------------------------------
$abs_dir = get_abs_dir($GLOBALS["dir"]);
if (!file_exists($GLOBALS["home_dir"])) {
    if (!file_exists($GLOBALS["home_dir"] . $GLOBALS["separator"])) {
        if ($GLOBALS["require_login"]) {
            $extra = "<a href=\"" . make_link("logout", null, null) . "\">" . $GLOBALS["messages"]["btnlogout"] . "</A>";
        } else $extra = null;
        if (getScriptName() == "/admin/index.php") {
          show_error($GLOBALS["error_msg"]["homeroot"] , $extra);
        } else {
          show_error($GLOBALS["error_msg"]["home"] . " (" . $GLOBALS["home_dir"] . ")", $extra);
        }
    }
}
if (!down_home($abs_dir)) show_error($GLOBALS["dir"] . " : " . $GLOBALS["error_msg"]["abovehome"]);
if (!is_dir($abs_dir))
    if (!is_dir($abs_dir . $GLOBALS["separator"]))
        show_error($abs_dir . " : " . $GLOBALS["error_msg"]["direxist"]);
    // ------------------------------------------------------------------------------
?>