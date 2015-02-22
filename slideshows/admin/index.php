<?php
/** ensure this file is being included by a parent file */

define( '_VALID_TWG', '42' );
// The TWGXplorer version number

$GLOBALS['tx_version'] = '1.0';
$GLOBALS['tx_home'] = 'http://www.tinywebgallery.com';
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is index.php, released on 2003-04-02.

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

	MODIFIED FOR TWG admin!

------------------------------------------------------------------------------*/
define ( "_QUIXPLORER_PATH", dirname(__FILE__) );
// define ( "_QUIXPLORER_URL", "http://localhost/TinyWebGallery/admin" );
define ( "_QUIXPLORER_URL", "." );

global $action;
//------------------------------------------------------------------------------
umask(0002); // Added to make created files/dirs group writable
//------------------------------------------------------------------------------
ob_start(); // cleaned in init!
require realpath((dirname(__FILE__) . "/../config.php")); 	// config from TWG
require_once  realpath(_QUIXPLORER_PATH . "/../inc/filefunctions.inc.php");	// config from TWG
if (isset($try_to_increase_memory_limit_to_32MB)) {
  if ($try_to_increase_memory_limit_to_32MB) {
    @ini_set('memory_limit', '32M');
  }
}
if (function_exists('date_default_timezone_set')) { // php 5.1.x
        if ($timezone != '') {
          @date_default_timezone_set($timezone);
        } else if (function_exists('date_default_timezone_get')) {
          set_error_handler('on_error_no_output');
          @date_default_timezone_set(@date_default_timezone_get());
          set_error_handler('on_error');
        } else {
          @date_default_timezone_set('Europe/Berlin');
        }
}

$install_dir = "";
include _QUIXPLORER_PATH . "/_include/init.php";	// Init
//------------------------------------------------------------------------------

// $item = mosGetParam( $_REQUEST, "item" );
$dir = $GLOBALS["dir"];
$item = $GLOBALS["item"];

$cachedir = '../' . $cachedir;

switch($action) {		// Execute action
//------------------------------------------------------------------------------
  // EDIT FILE
  case "edit":
	  require _QUIXPLORER_PATH . "/_include/fun_edit.php";
	  edit_file($dir, $item);
  break;
//------------------------------------------------------------------------------
  // DELETE FILE(S)/DIR(S)
  case "delete":
	  require _QUIXPLORER_PATH . "/_include/fun_del.php";
	  del_items($dir);
  break;
//------------------------------------------------------------------------------
  // COPY/MOVE FILE(S)/DIR(S)
  case "copy":	case "move":
	  require _QUIXPLORER_PATH ."/_include/fun_copy_move.php";
	  copy_move_items($dir);
  break;
  // RENAME FILE(S)/DIR(S)
  case "rename":
	  require _QUIXPLORER_PATH ."/_include/fun_rename.php";
	  rename_item($dir, $item);
  break;
//------------------------------------------------------------------------------
  // DOWNLOAD FILE
  case "download":
	  require _QUIXPLORER_PATH . "/_include/fun_down.php";
	  set_error_handler("on_error_no_output"); // @does not work here!
		@ob_end_clean(); // get rid of cached unwanted output
	  set_error_handler("on_error");
	  download_item($dir, $item);
	  ob_start(); // prevent unwanted output
	  exit;
  break;
//------------------------------------------------------------------------------
  // UPLOAD FILE(S)
  case "upload":
	  require _QUIXPLORER_PATH . "/_include/fun_up.php";
	  upload_items($dir);
  break;
//------------------------------------------------------------------------------
   // store css
	  case "storecss":
		  require _QUIXPLORER_PATH . "/_include/twg_storecss.php";
		  return;
  break;
//------------------------------------------------------------------------------
  // CREATE DIR/FILE
  case "mkitem":
	  require _QUIXPLORER_PATH ."/_include/fun_mkitem.php";
	  make_item($dir);
  break;
//------------------------------------------------------------------------------
  // CHMOD FILE/DIR
  case "chmod":
	  require _QUIXPLORER_PATH ."/_include/fun_chmod.php";
	  chmod_item($dir, $GLOBALS["item"]);
  break;
//------------------------------------------------------------------------------
  // SEARCH FOR FILE(S)/DIR(S)
  case "search":
	  require _QUIXPLORER_PATH ."/_include/fun_search.php";
	  search_items($dir);
  break;
//------------------------------------------------------------------------------
  // CREATE ARCHIVE
  case "arch":
	  require _QUIXPLORER_PATH . "/_include/fun_archive.php";
	  archive_items($dir);
  break;
//------------------------------------------------------------------------------
  // EXTRACT ARCHIVE
  case "extract":
	  require _QUIXPLORER_PATH . "/_include/fun_archive.php";
	  extract_item($dir, $item);
  break;
//------------------------------------------------------------------------------
  // USER-ADMINISTRATION
  case "admin":
	  require _QUIXPLORER_PATH . "/_include/fun_admin.php";
	  show_admin($dir);
  break;
//------------------------------------------------------------------------------
  // info
  case "info":
    show_menu();
	  require _QUIXPLORER_PATH . "/info.php";
  break;

//------------------------------------------------------------------------------
  // colorpicker
  case "colorpicker":
    show_menu();
	  require _QUIXPLORER_PATH . "/colorpicker.php";
  break;
//------------------------------------------------------------------------------
  // helper
  case "helper":
    if ($helper_action != "delsession") {
	    show_menu();
	  }
	  require _QUIXPLORER_PATH . "/helper.php";
  break;
//------------------------------------------------------------------------------
  // helper
  case "helper_gen":
	  require _QUIXPLORER_PATH . "/helper_gen.php";
	  exit();
  break;
//------------------------------------------------------------------------------
  // we show the split info
  case "split_info":
	  show_menu();
	  require _QUIXPLORER_PATH . "/_include/fun_split.php";
	  if ($GLOBALS["file_split_is_tested"]) {
			split_info();
		} else {
	    split_setup();
	  }
  break;
//------------------------------------------------------------------------------
  // we split files
  case "split":
	  show_menu();
	  require _QUIXPLORER_PATH . "/_include/fun_split.php";
	  split_files();
  break;
//------------------------------------------------------------------------------
  // main
  case "help":
	  show_menu();
	  require _QUIXPLORER_PATH . "/help.php";
  break;
//------------------------------------------------------------------------------
	// admin email
	case "email":
	    show_menu();
		  require _QUIXPLORER_PATH . "/email_admin.php";
  break;
//------------------------------------------------------------------------------

	// ajax
	case "ajax":
	    require _QUIXPLORER_PATH . "/_include/twg_ajax.php";
		  setAjaxParameters();
  break;


//------------------------------------------------------------------------------
  // DEFAULT: LIST FILES & DIRS
  case "list":
  default:
  $_SESSION['twg_admin_logged_in'] = "true";
  show_menu();
			echo '
		<script type="text/javascript">
			function showImageDiv() {}
			function hideImageDiv() {}
		</script>
		<script type="text/javascript" src="_js/opacity.js"></script>
		';
    require _QUIXPLORER_PATH . "/_include/fun_list.php";
    list_dir($GLOBALS["dir"]);
  // break;

	//  require _QUIXPLORER_PATH . "/main.php";
//------------------------------------------------------------------------------
}				// end switch-statement
//------------------------------------------------------------------------------

show_twg_footer();
show_footer();
close_tags();
//------------------------------------------------------------------------------
?>
