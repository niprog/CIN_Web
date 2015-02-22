<?php
/*************************
Copyright (c) 2004-2014 TinyWebGallery
  written by Michael Dempfle
 
  This program is free software; you can redistribute it and/or modify 
  it under the terms of the TinyWebGallery license (based on the GNU  
  General Public License as published by the Free Software Foundation;  
  either version 2 of the License, or (at your option) any later version. 
  See license.txt for details.
 
  TWG version: 2.2
 
$Date: 2009-06-17 22:57:10 +0200 (Mi, 17 Jun 2009) $
$Revision: 73 $
 **********************************************/

defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');

include (dirname(__FILE__) . '/setbrowser.inc.php');
// we try to increase the memory limit that TWG works fine with jpg images up to 4MB file size
if ($try_to_increase_memory_limit_to_32MB) {
    @ini_set('memory_limit', '32M');
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

if (!isset($_SESSION['actual_transations_per_session'])) {
    $_SESSION['actual_transations_per_session'] = 0;
} else {
    $current_transactions = $_SESSION['actual_transations_per_session'];
    $_SESSION['actual_transations_per_session'] = $current_transactions + 1;
    if ($current_transactions >= $maximum_transactions_per_session) {
        if ($current_transactions == $maximum_transactions_per_session) {
            // debug('A user (or a robot) has reached the maximum limit of transactions (' . $maximum_transactions_per_session . ') in a session. You can set this limit in the config: \$maximum_transations_per_session. ID: ' . session_id());
        }
        die ('<br><br><center>You had too many transactions (' . $maximum_transactions_per_session . ') in this session.<br>This is a security feature too avoid that robots generate too much traffic with the gallery.<br>If you are a normal user please close your browser to get a new session.</center>');
    }
}

if (isset($_GET['twg_smallnav'])) {
    $_SESSION['twg_ses']['nav_small'] = 'TRUE';
}

if (isset($_GET['twg_bignav'])) {
    $_SESSION['twg_ses']['nav_small'] = 'FALSE';
}
// we set a dummy - twg_smallnav = false!
if (!isset($_SESSION['twg_ses']['nav_small'])) {
    $_SESSION['twg_ses']['nav_small'] = $show_only_small_navigation;
}

$twg_smallnav = $_SESSION['twg_ses']['nav_small'];
// border part
if (isset($_GET['twg_noborder'])) {
    $_SESSION['showborder'] = 'FALSE';
}

if (isset($_GET['twg_withborder'])) {
    $_SESSION['showborder'] = 'TRUE';
}
// we set a dummy - myborder = false!
if (!isset($_SESSION['showborder'])) {
    $_SESSION['showborder'] = $show_border;
}

if (!isset($_SESSION['actalbum'])) {
    $_SESSION['actalbum'] = 'LOAD NEW';
}
$myborder = $_SESSION['showborder'];
// login part
$login = 'FALSE';
$login_edit = false;
$login_upload = false;
$login_backend = false;
$login_only = false;

if (isset($_SESSION['mywebgallerie_login'])) {
    $login = 'TRUE';
}

if ($login == 'TRUE' && isset($twg_album)) { // now we check the level of login we have!
    $hds = $_SESSION['s_home_dir']; // home dirs of frontend users can have more than one folder seperated by |
    $perm = $_SESSION['twg_permissions'];
    $login_only = true;
    $login_backend = (($perm & 02) == 02);
    $hd_array = explode('|', $hds);
    if (($perm & 8) != 8) { // we have permissions to to something. 8  == login only.
        foreach ($hd_array as $hd) {
            $hd = trim($hd);
            if (is_subdir($hd, $basedir . '/' . $twg_album)) { // we are in the dir or a subdir !
                $login_edit = true; // we can edit if we are in a subdir
                $login_upload = (($perm & 01) == 01);
            }
        }
    }
}

$hiddenvals = '';
$twg_standalone = '';
$twg_standalonejs = '';
$GLOBALS['standalone'] = '';
// setup standalone gal!
if (isset($_GET['twg_standalone'])) {
    $GLOBALS['standalone'] = '_s';
    $twg_standalone = '&amp;twg_standalone=true';
    $twg_standalonejs = '&twg_standalone=true';
    $hiddenvals .= '<input name="twg_standalone" type="hidden" value="true">';
}

if ($twg_standalone != '') {
    $install_dir = '';
    $php_include = false;
    $myborder = 'TRUE';
    $show_border = 'TRUE';
    $disable_nav_sel = true;
}
// we add non-TWG variables to the links again !!
$twg_array = $ignore_parameter;
while (list ($key, $val) = each($_GET)) {
    if ((!in_array($key, $twg_array)) && ((substr($key, 0, 3) != 'twg') && ($key != session_name()))) {
        // new 1.8.3 - external parameters are checked as well.
        $key = replaceInput($key);
        $val = htmlentities(urlencode(parse_maxlength(replaceInput($val), 15)), ENT_QUOTES, $charset); // I only allow 15 chars max as external parameters. Normally this is only the id of a menu - therefore this should be more than enouth and to little for any xss attack.


        $twg_standalone .= '&amp;' . $key . '=' . $val;
        $twg_standalonejs .= '&' . $key . '=' . $val;
        $hiddenvals .= '<input name="' . $key . '" type="hidden" value="' . $val . '">';
    }
}
// getting the twg_slideshow time
if (isset($_GET['twg_slideshow_time'])) {
    $_SESSION['twg_ses']['twg_slideshow_time'] = replaceInput($_GET['twg_slideshow_time']);
}
if (isset($_SESSION['twg_ses']['twg_slideshow_time'])) {
    $twg_slideshow_time = $_SESSION['twg_ses']['twg_slideshow_time'];
}

if (isset($image) && $image == false) {
    unset($_SESSION['twg_zoom']);
}
// getting the twg_zoom
if (isset($_GET['twg_zoom'])) {
    $_SESSION['twg_zoom'] = replaceInput($_GET['twg_zoom']);
}
if (isset($_SESSION['twg_zoom'])) {
    if ($_SESSION['twg_zoom'] == 'TRUE') {
        $twg_smallnav = false;
        // $default_big_navigation = 'HTML';
        $default_is_fullscreen = true;
    } else {
        $default_is_fullscreen = false;
    }
}
// getting the twg_slideshowtype
if (isset($_GET['twg_slide_type'])) {
    $_SESSION['twg_ses']['twg_slide_type'] = replaceInput($_GET['twg_slide_type']);
}
if (isset($_SESSION['twg_ses']['twg_slide_type'])) {
    $twg_slide_type = $_SESSION['twg_ses']['twg_slide_type'];
}

if ($enable_external_privategal_login) {
    if (isset($_GET['twg_private_login'])) {
        $_SESSION['privategallogin'] = replaceInput($_GET['twg_private_login']);
    }
    if (isset($_POST['twg_private_login'])) {
        $_SESSION['privategallogin'] = replaceInput($_POST['twg_private_login']);
    }
}
// check if the user can view private galleries
$privatelogin = 'FALSE';
if (isset($_SESSION['privategallogin'])) {
    $privatelogin = $_SESSION['privategallogin'];
}

if (isset($_GET['twg_gal_logout'])) {
    $privatelogin = 'FALSE';
    unset($_SESSION['privategallogin']);
}
// check if the language is present - if not we keep the default - if yes we set the new one and store this in
// the session
if (!isset($_SESSION['twg_lang'])) {
    $_SESSION['twg_lang'] = $default_language;
}

if (isset($_GET['twg_lang'])) {
    $_SESSION['twg_lang'] = replaceInput(parse_maxlength($_GET['twg_lang'], 3));
    $_SESSION['admin_lang'] = replaceInput(parse_maxlength($_GET['twg_lang'], 3));
}

if (isset($_SESSION['twg_lang'])) {
    $default_language = $_SESSION['twg_lang'];
}

$default_language = checkDefaultLanguage($default_language);
$d = false;

// skin
if (isset($_GET['twg_skin'])) {
    $_SESSION['twg_skin'] = replaceInput(parse_maxlength($_GET['twg_skin'], 10));
}
if (isset($_SESSION['twg_skin'])) {
    $skin = $_SESSION['twg_skin'];
}

if (isset($twg_root)) {
    $_SESSION['twg_root_dir'] = trim($twg_root);
} else if (isset($_SESSION['twg_root_dir'])) {
    $twg_root = trim($_SESSION['twg_root_dir']);
} else if (!$php_include && basename(getScriptName()) == 'index.php') { // this is only backup if the session is invalidated
    $twg_root = getScriptName();
    $_SESSION['twg_root_dir'] = trim($twg_root);
} else { // this is only backup if the session is invalidated - we hope that the main files calles this value!
    if (getScriptName()) {
        $twg_root = getScriptName();
    } else {
        $twg_root = false; // we don't know what is right and hope it will be set in the next request properly!
    }
}

if (!isset($_SESSION['dhtml_nav'])) {
    $_SESSION['dhtml_nav'] = $default_big_navigation;
}
if (isset($_GET['twg_nav_dhtml'])) {
    if ($_GET['twg_nav_dhtml'] == 'flash') {
        $_SESSION['dhtml_nav'] = 'FLASH';
    } else {
        $_SESSION['dhtml_nav'] = 'DHTML';
    }
} else if (isset($_GET['twg_nav_html'])) {
    $_SESSION['dhtml_nav'] = 'HTML';
} else if (isset($_GET['twg_side_html'])) {
    $_SESSION['dhtml_nav'] = 'HTML_SIDE';
}
$default_big_navigation = $_SESSION['dhtml_nav'];

if (isset($_SESSION[$GLOBALS['standalone'] . 'browserx_res'])) {
    $browserx = $_SESSION[$GLOBALS['standalone'] . 'browserx_res'];
} else {
    $browserx = 930;
}

if (isset($_SESSION[$GLOBALS['standalone'] . 'browsery_res'])) {
    $browsery = $_SESSION[$GLOBALS['standalone'] . 'browsery_res'];
} else {
    $browsery = 500;
}

if (isset($_SESSION['fontscale'])) {
    $fontscale = $_SESSION['fontscale'];
} else {
    $fontscale = 1;
}

// getting the twg_zoom
$no_zoom_request_set = false;
if (isset($_GET['twg_zoom'])) {
    $_SESSION['twg_zoom'] = replaceInput($_GET['twg_zoom']);
    if ($_GET['twg_zoom'] == 'FALSE') {
        $no_zoom_request_set = true;
    }
}
if (isset($_SESSION['twg_zoom'])) {
    if ($_SESSION['twg_zoom'] == 'TRUE') {
        $twg_smallnav = false;
        $default_is_fullscreen = true;
    } else {
        $default_is_fullscreen = false;
    }
}

if (isset($_GET['twg_lowbandwidth'])) {
    $_SESSION['twg_lowbandwidth'] = 'TRUE';
}

if (isset($_GET['twg_highbandwidth'])) {
    if ($_GET['twg_highbandwidth'] == 'high') {
        $_SESSION['twg_lowbandwidth'] = 'HIGH';
    } else {
        $_SESSION['twg_lowbandwidth'] = 'FALSE';
    }
}

$test_connection = false;
// we set a dummy - lowbandwidth = false!
if (!isset($_SESSION['twg_lowbandwidth'])) {
    $test_connection = true;
    $lowbandwidth = 'FALSE';
} else {
    $lowbandwidth = $_SESSION['twg_lowbandwidth'];
}

$reset_cache = false;
if (isset($_SESSION['TWG_CALL_COUNTER'])) { // we set a flag at the beginning of index.php and at the end. If the end is not reached 3 times the cache is reseted because it maybe has a problem
    if ($_SESSION['TWG_CALL_COUNTER'] > 3) {
        $reset_cache = true;
    }
}

if ($reset_cache || (isset($_GET['twg_reset_bandwidth']) && !isset($_GET['twg_highbandwidth']) && !isset($_GET['twg_lowbandwidth']))) {
    $lowbandwidth = 'FALSE';
    $test_connection = true;
    set_error_handler('on_error_no_output');
    @session_destroy();
    @session_start();
    remove_tmp_files(true, true);
    if ($support_piclens) {
        $dd = get_view_dirs($basedir, '');
        generate_piclens_rss($dd, '');
    }

    set_error_handler('on_error');
    // after the reset we have to keep some stuff for the ajax calls
    $_SESSION['twg_root_dir'] = trim($twg_root);
}

if (isset($_SESSION['twg_download'])) { // we know what to do !
    $twg_download = $_SESSION['twg_download'];
} else {
    $twg_download = false;
}


if (isset($_SESSION['TWG_AUTOHIDE'])) {
    if ($_SESSION['TWG_AUTOHIDE'] == 'true') {
        $autoclose_tree = true;
        $album_tree_default_open = false;
    } else {
        $autoclose_tree = false;
    }
}
$_SESSION['TWG_AUTOHIDE'] = $autoclose_tree;

if (isset($_SESSION['TWG_MENU_STATUS'])) {
    if ($_SESSION['TWG_MENU_STATUS'] == 'show') {
        if ($autoclose_tree && !$opera) {
            $album_tree_default_open = false;
        } else {
            $album_tree_default_open = true;
            if ($opera) {
                $_SESSION['TWG_MENU_STATUS'] = 'hide';
            }
        }
    } else {
        $album_tree_default_open = false;
    }
}


// we enable caching for one session - used for debuging!
if (isset($_SESSION['twg_enable_session_cache'])) {
    unset($_SESSION['twg_disable_session_cache']);
    $twg_enable_session_cache = true;
} else if (isset($_GET['twg_enable_session_cache'])) {
    $twg_enable_session_cache = true;
    unset($_SESSION['twg_disable_session_cache']);
    $_SESSION['twg_enable_session_cache'] = true;
} else {
    $twg_enable_session_cache = false;
}

// disable the cache for uploader
$twg_disable_session_cache = false;
if (isset($_SESSION['twg_disable_session_cache'])) {
    $twg_disable_session_cache = true;
}

/* some calls only set something internally - we don't continue then! */
if (isset($_GET['twg_session'])) {
    exit(0);
}

if (!isset($_SESSION['js_tree'])) {
    $_SESSION['js_tree'] = array(); // we store all tree info only in one array!
}
set_umask();
?>