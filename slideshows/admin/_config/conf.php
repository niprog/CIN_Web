<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );

//------------------------------------------------------------------------------
// Configuration Variables
	// login to use TWG backend: (true/false)
	$GLOBALS["require_login"] = true;

	// the filename of the TWG backend: (you rarely need to change this)
	if($_SERVER['SERVER_PORT'] == 443 ) {
		$GLOBALS["script_name"] = "https://".$GLOBALS['__SERVER']['HTTP_HOST'].getScriptName();
	}
	else {
		$GLOBALS["script_name"] = "http://".$GLOBALS['__SERVER']['HTTP_HOST'].getScriptName();
	}
	
	// allow Zip, Tar, TGz -> Only (experimental) Zip-support
	if( function_exists("gzcompress")) {
	  $GLOBALS["zip"] = true;
	}
	else {
	  $GLOBALS["zip"] = false;
	}

//------------------------------------------------------------------------------
// Global User Variables (used when $require_login==false) - not used in TWG !
	$GLOBALS["separator"] = "/";
	$GLOBALS["home_dir"] = ".";
	$GLOBALS["show_hidden"] = true; // show hidden files in QuiXplorer: (hide files starting with '.', as in Linux/UNIX)
	$GLOBALS["no_access"] = "^\."; // filenames not allowed to access: (uses PCRE regex syntax)
	$GLOBALS["permissions"] = 7;
	$GLOBALS["default_language"] = "en"; // The default language of the admin - you can only pick available ones!

	// array of file sizes you want to provide for your users - for uploading originals please use
	// a very lare number number e.g.  "10000" => "Original" - the example below has 1024, 800 and 500 as max size!
	// if it is removed you get the default selection box!
	// $GLOBALS["uploadsizes"] = array ( "1024" => "1024" , "800" => "800", "500" => "500"  );

  $GLOBALS["twg_home_url"] = "http://www.tinywebgallery.com";
  $GLOBALS["twg_admin_version"] = $twg_version;
	// quality of upload if you resize - if you remove this you get a selection box in html mode - flash has default of 80!
	$GLOBALS["uploadquality"] = 80;
	
	$GLOBALS["default_upload_method"] = $admin_default_upload_method; // values: "flash" or "html"
	$GLOBALS["nr_uploads"] = $admin_nr_uploads;
	$GLOBALS["default_simple_view"] = $admin_default_simple_view; // values: "yes" or "no"
	$GLOBALS["hide_simple_view"] = array ( "admin/_include", "admin/_img", "admin/_lang","admin/_js",
	"admin/_lib","admin/_style", "admin/pic", "admin/readme", "admin/upload",
	"admin/colorpicker.php","admin/email_admin.php","admin/help.php","admin/helper.php","admin/helper_gen.php",
	"admin/index.html","admin/info.php", "admin/menu.php", "admin/readme.txt",
	"admin/_config/.htaccess","admin/_config/index.html", "admin/index.html","admin/_config/mimes.php",
	"buttons", "examples", "html","i_frames","inc","joomla-mambo","dtree",
	"js", "language", "language_extra", "lightbox", "skins", "uninstall",
	"favicon.ico", "image.php", "index.htm", "license.txt","verdana.ttf", "version.txt"
	);
	$GLOBALS["enable_split"] = $admin_enable_split;
	$GLOBALS["file_split_is_tested"] = $admin_file_split_is_tested;
  $GLOBALS["allowed_file_extensions"] =  $admin_allowed_file_extensions;
  $GLOBALS["forbidden_file_extensions"] =  $admin_forbidden_file_extensions;
  
//------------------------------------------------------------------------------
/* NOTE:
	Users can be defined by using the Admin-section,
	or in the file "_config/.htusers.php".
	For more information about PCRE Regex Syntax,
	go to http://www.php.net/pcre.pattern.syntax
*/
//------------------------------------------------------------------------------
?>
