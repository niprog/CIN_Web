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

define('_VALID_TWG', '42');
// functions like getLast, getFirst, debug, gdversion has to be before parserequests !
// moved here because now errors in config.php are shown in the debug file !
$timestart = microtime();

ob_start();

include_once dirname(__FILE__) . '/inc/filefunctions.inc.php';
include_once dirname(__FILE__) . '/language/language_text.php';
include_once dirname(__FILE__) . '/inc/startsession.inc.php';
require (dirname(__FILE__) . '/config.php');

checkXSS();

if ('2.2' != $twg_version) {
    die('You are using a config.php that does not belong to this version.<br>If you want to upgrade from an older version of TWG please copy your changes form the old config.php to the file my_config.php.');
}
if ('2.2' != $twg_version_internal) {
    die('You are using a config_internal.php that does not belong to this version.<br>If you want to upgrade from an older version of TWG please copy your changes form the old config.php to the file my_config.php.');
}

if ($autodetect_errors && !$php_include) {
    if (isset($_SESSION['TWG_CALL_COUNTER'])) { // increase the call counter
        $_SESSION['TWG_CALL_COUNTER'] = $_SESSION['TWG_CALL_COUNTER'] + 1;
    } else {
        $_SESSION['TWG_CALL_COUNTER'] = 0;
    }

    set_error_handler("on_error_no_output"); // this is needed because the session is already started if this include is used by index.php - at all other places here is the initialization of the session!
    // the session has to be closed and reopend because othewite the session is not written if the counter fails.
    @session_write_close();
    @session_start();
    set_error_handler("on_error");
}

// autenables the session cache of TWG because too many users don't turn it on and TWG is much slower than it should be
if ($autoenable_cache >= 0) {
    if (isset($_SESSION['TWG_REQUEST_COUNTER'])) {
        $_SESSION['TWG_REQUEST_COUNTER'] = $_SESSION['TWG_REQUEST_COUNTER'] + 1;
    } else {
        $_SESSION['TWG_REQUEST_COUNTER'] = 0;
    }
    if ($_SESSION['TWG_REQUEST_COUNTER'] > $autoenable_cache) {
        $_SESSION['twg_enable_session_cache'] = true;
    }
}

if (file_exists(dirname(__FILE__) . '/skins/' . $skin . '.php')) {
    include dirname(__FILE__) . '/skins/' . $skin . '.php';
}

if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if (file_exists(dirname(__FILE__) . '/language/language_' . $lang_browser . '.php')) {
        $default_language = $lang_browser;
    }
}

$twg_root = getScriptName(); // needed in some i_frames !! we store this later in the session for the other frames !
// read the request parameters
include dirname(__FILE__) . '/inc/parserequest.inc.php';

// some intro settings
$detailswidth = 300;
$hoverjs = false;
$is_cache_call = false;
$CurrentVer = $twg_version;
$webpath = 'http://www.tinywebgallery.com'; // don't modify this - this can only be done if you register ;)
                                 
/* set some session variables */
include (dirname(__FILE__) . '/inc/mysession.inc.php');

$basedir_save = $basedir;
$basedir = $install_dir . $basedir;

include dirname(__FILE__) . '/inc/loadconfig.inc.php';
include dirname(__FILE__) . '/inc/setspecials.inc.php';

// now we set the path's it has to be done after the session include because there the install dir can be set to '' if standalone!
// some paths need seo fixes.
$cachedir = $install_dir . $cachedir;
$counterdir = $install_dir . $counterdir;
$xmldir = $install_dir . $xmldir;

// the install dir can change on the view for seo. therefore this is a new setting.
$install_dir_view = $install_dir;
$basedir_view = $basedir;
$twg_seo_active = false;
$twg_seo_image_active = false;
if ($enable_basic_seo && isset($_SERVER['REQUEST_URI'])) {
     $redirect_url = $_SERVER['REQUEST_URI'];
     if (strpos($redirect_url, '/twg_image/') !== false) { // imageview
      $twg_seo_active = $twg_seo_image_active = true;     
      $install_dir_view = '../../' . $install_dir_view; 
      $basedir_view = '../../' . $basedir_view;   
    } else if ($top10) {
      
    } else if (strpos($redirect_url, '/twg_album/') !== false   || 
         strpos($redirect_url, '/twg_show/') !== false  ) {// thumbnailview - or top 10 view
      $twg_seo_active = true;
      $install_dir_view = '../' . $install_dir_view;
      $basedir_view = '../' . $basedir_view;   
    } 
}

@ob_end_clean();

if ($test_connection && $test_client_connection) { // speedtest!
    if (!$test_connection_background) {
        include (dirname(__FILE__) . '/inc/speed.inc.php');
        return;
    }
}

ob_start();

if (!checkFullscreen()) {
    $activate_lightbox_thumb = $activate_lightbox_thumb_full = $activate_lightbox_image = $activate_lightbox_topx = $activate_lightbox_topx_full = $enable_album_tree = false;
    $fullscreen_active = true;    
} else if (!checkP()) {
    $enable_basic_seo = false;
}     
// make some settings that should be done in the config.php but the user have not configured properly
if ($php_include) {
    $use_dynamic_background = false;
    $enable_maximized_view = false;
    $open_in_maximized_view = false;
}

if (!$enable_maximized_view) {
    $default_is_fullscreen = false;
}


if (!checkCacheDirs()) { // checks if all cache dir are here and set the right umask
    return;
}

require dirname(__FILE__) . '/language/language_default.php';
require dirname(__FILE__) . '/language/language_' . $default_language . '.php';
include dirname(__FILE__) . '/inc/fixfont.inc.php';
// we set the default title to $default_gallery_title if no one is set
if ($lang_titel == '') {
    $lang_titel = $default_gallery_title;
}

// first we build the cache tree if needed.
if ($show_number_of_pic || $show_changes > 0 || $show_counter_in_jstree) {
    count_tree($basedir);
}

$relativepath = '';
include dirname(__FILE__) . '/inc/checkprivate.inc.php';
cleanup_cache();
$twg_rot_available = checktwg_rot();
if (!$twg_rot_available) {
    $autorotate_images = '';
}
// check private login
$twg_showprivatelogin = false;

if (($privategal == true) && (!in_array(trim($privatelogin), $passwd))) { // we want to have a login :)
    $twg_showprivatelogin = true;
}

include dirname(__FILE__) . '/inc/readxml.inc.php';
// delete comment
include dirname(__FILE__) . '/inc/delcomment.inc.php';
// important check if we already have to show fullscreen
$default_is_fullscreen = ($image != false && $default_is_fullscreen && !$no_zoom_request_set);

$root_mode_no_login = false;
include dirname(__FILE__) . '/inc/multiroot.inc.php';

if ($twg_showprivatelogin || ($multi_root_mode && !$twg_album) || $root_mode_no_login) {
    $use_round_corners = false;
}
$generatecounter = false;

if (isset($charset) && !$php_include) {
    header('Content-Type: text/html;charset=' . $charset);
}
// we check if the album exists and/or the input is invalid.
// A nice 404 is sent then and for an invalid image the first of the folder is displayed.
$path = ($twg_album) ? $basedir . '/' . $twg_album : $basedir;
$pathimage = ($image && $image != 'x') ? $path . '/' . $image : $path;
if ($input_invalid || !file_exists($path) || !file_exists($pathimage)) {
    header('HTTP/1.1 404 Not Found');
}

include dirname(__FILE__) . '/inc/index.inc.php';
@ob_end_clean(); // from now we do output
include dirname(__FILE__) . '/inc/head.inc.php'; // prints all from <html> to </head>

if ($default_big_navigation == 'HTML_SIDE') {
    $numberofpics = $numberofpics_html_side;
}
$numberofpics = floor(($numberofpics - 1) / 2);

include dirname(__FILE__) . '/inc/bodytag.inc.php'; // prints <body ...>
include dirname(__FILE__) . '/inc/private.inc.php';
include dirname(__FILE__) . '/js/twg.js.php';

if ($use_dynamic_background && $show_background_images && !$default_is_fullscreen) {
    echo '
<!-- if dyn -->
<!-- compliance patch for microsoft browsers -->
<!--[if lt IE 9]>
<script src="' . $install_dir . './js/IE9.js" type="text/javascript"></script>
<![endif]-->
<script type="text/javascript">';

    if ($twg_album) {
        $backgroundimage = $basedir . '/' . $twg_album . '/back.png';
    } else {
        $backgroundimage = $basedir . '/back.png';
    }
    if (!file_exists($backgroundimage)) { // individual background image
        $backgroundimage = $background_default_image;
    }

    if ($backgroundimage != '') {
        $backsize = @getimagesize($backgroundimage);
        echo '
	imSRC = "' . $install_dir_view . $backgroundimage . '";
	imgSRC_x = ' . $backsize[0] . ';
	imgSRC_y = ' . $backsize[1] . ';
  MM_preloadImages(imSRC);
	';
        if ($resize_only_if_too_small) {
            echo 'resize_always=false;';
        } else {
            echo 'resize_always=true;';
        }
    }
    echo '
	</script>
	<div id="bodydiv" class="twg_bodydiv">';
}
?>
<script type="text/javascript">
    var resizetimestamp = (new Date().getTime());
</script>
<?php
if ($disable_frame_adjustment_ie) {
    $starty = '40';
} else {
    $starty = '-400';
}

//
?>

<iframe id='details' name='details' src='<?php echo getEmptyPage($install_dir_view); ?>' width='<?php echo $detailswidth;
?>' height='1' marginwidth='0' frameborder='0' <?php echo $msie ? ' allowtransparency="true"' : ''; ?> marginheight='0'
        scrolling='auto' style='z-index: 150;position: absolute; right: 36px; top: <?php echo $starty;
?>px;'></iframe>
<script type='text/javascript'>
    hideAll();
    // opens the gallery in a new window
    function openNewWindow() {
        // alert(screen.width + 'x' + screen.height + ' : ' + screen.availWidth + 'x' + screen.availHeight);
        newWindow = window.open('<?php
        if ($new_window_x == 'auto' || $new_window_y == 'auto') {
            $widthheight = 'width=\' + screen.availWidth + \',height=\' + screen.availHeight + \'';
            $widthheight_r = 'newWindow.resizeTo(screen.availWidth,screen.availHeight);';
        } else {
            $widthheight = 'width=' . $new_window_x . ',height=' . $new_window_y;
            $widthheight_r = 'newWindow.resizeTo(' . $new_window_x . ',' . $new_window_y . ');';
        }

        echo $install_dir . 'index.php?twg_album=' . $album_enc . '&twg_standalone=true';

        ?>', 'Webgalerie', '<?php echo $widthheight;

        ?>,left=0,top=0,menubar=no,scrollbars=yes,status=no,resizable=yes');
    <?php echo $widthheight_r; ?>
    }
</script>

<?php

prepareMenu();
$leftinclude = false;
$inner_table = false;

if ($input_invalid) {
    $enable_album_tree = false;
}

// used for footerhtml as well!
if ($enable_album_tree) {
    $colspan = 4;
    $outerspan = 3; // no left and right.htm but maybe borders
    if ($album_tree_default_open) {
        $but_image = 'hide_gif';
    } else {
        $but_image = 'expand_gif';
    }
} else {
    $colspan = 3;
    $outerspan = 2; // no left and right.htm but maybe borders
}

if (file_exists(dirname(__FILE__) . '/right.htm')) {
    $outerspan++;
}


if ($enable_external_html_include && !$default_is_fullscreen) {
    $lefthtml = dirname(__FILE__) . '/left.htm';
    if (file_exists($lefthtml)) {
        $outerspan++;
        echo '<table summary="main table" cellpadding="0" cellspacing="0" class="twg_main" ' . fix_ie_height() . '>';
        includeHeader($enable_external_html_include, $outerspan);
        echo '<tr><td class="twg_lefthtml" style="width:' . $left_htm_width . 'px;">';
        include ($lefthtml);
        echo '</td><td class="twg_100_prozent_height">';
        $leftinclude = $inner_table = true;

    }
}

if ($enable_album_tree && $myborder != 'TRUE') {
    if (!$leftinclude) {
        echo '<table summary="main table" ' . fix_ie_height() . ' cellpadding="0" cellspacing="0" class="twg_main">';
        includeHeader($enable_external_html_include, $colspan);
        echo '<tr>';
    }
    print_album_tree($basedir);
    // if (!$leftinclude) {
    //     echo '<td class='twg_100_prozent_height'>'; //
    //} else {
    echo '<td class="twg_100_prozent">';
    // }
    $leftinclude = $inner_table = true; // close the table at the end!
}

if ($myborder == 'TRUE' && !$default_is_fullscreen) {
    echo '<table class="twg_main" ' . fix_ie_height() . 'summary="main table" cellpadding="0" cellspacing="0">';
    if (!$leftinclude) {
        includeHeader($enable_external_html_include, $colspan);
    }
    includeTop($enable_external_html_include, $colspan);
    echo '<tr>';
    if ($enable_album_tree) {
        print_album_tree($basedir);
    }
    echo '<td class="sideframe">';

    if ($enable_album_tree) {
        if (!$opera) {
            $static = 'N';
        } else {
            $static = 'Y';
        }
        echo '<img class="expandbutton twg_sprites ' . $but_image . '" onclick="javascript:changeMenu(\'' . $install_dir_view . '\',\'' . $static . '\');" id="menu_expand" width="20px" height="63px" alt="" src="' . $install_dir_view . 'buttons/1x1.gif" >';
        $widthfix = 'width:100%;';
    } else {
        $widthfix = '';
    }
    echo '</td><td valign="top" style="height:100%;' . $widthfix . '">';
    $inner_table = true;
}

if ($inner_table) {
    $isinner = '';
} else {
    $isinner = fix_ie_height();
}


echo '<table id="content_table" class="twg twg_100_prozent" ' . $isinner . ' summary="" cellpadding="0" cellspacing="0" border="0">';
if ($myborder != 'TRUE') {
    includeTop($enable_external_html_include, $colspan);
}
// start of small top navigation
if (!$default_is_fullscreen) {
    echo '<tr id="top_row" class="twg_tr">';
    include (dirname(__FILE__) . '/inc/topnavigation.inc.php');
    echo '</tr>';
}
// end of small top navigation
?>

<tr>
    <?php


    if (!$default_is_fullscreen) {
        echo '<td colspan="3" id="twg_info" class="twg_info">';
    } else {
        echo '<td colspan="3">';
        echo '<script type="text/javascript">isFullscreen();</script>';
    }

    echo '<div id="twg_content_div" class="twg_100_prozent twg_imagetablediv">';
    if ($myborder != 'TRUE' && !$default_is_fullscreen) {
        if ($enable_album_tree) {
            if (!$opera) {
                $static = 'N';
            } else {
                $static = 'Y';
            }
            // align is needed here - not possible in the style because IE sucks!
            echo '<div class="twg_exp"><img align="left" onclick="javascript:changeMenu(\'' . $install_dir_view . '\',\'' . $static . '\');" width="20px" height="63px" id="menu_expand" alt="" class="twg_img_hide_inner twg_sprites ' . $but_image . '" src="' . $install_dir_view . 'buttons/1x1.gif" ></div>';
        }
    }



    echo '<table class="twg twg_100_prozent" summary="" border="0" cellpadding="0" cellspacing="0">
<tr onmouseover="if (window.hide_lang_div) hide_lang_div();" >';
    if (!$default_is_fullscreen) {
        echo '<td onclick="hideAllTimed();" class="twg_image">';
    } else {
        echo '<td onmousemove="javascript:setTimer(10);show_control_div();">';
    }
    echo '<center id="center-main"><div id="twg-main-div">';

// start of image section
    if ($input_invalid) {
        printErrorInvalid();
    } else if ($twg_showprivatelogin) {
        echo '<div style="position:absolute; margin-left: -' . ($detailswidth / 2) . ';left: 50%;z-index:250">';
        echo '<iframe style="z-index:251;" id="log" name="log" src="' . $install_dir_view . 'i_frames/' . $password_iframe . '?twg_album=' . $album_enc . $twg_standalone . '" width="' . $detailswidth
            . '"  marginwidth="0" height="300" frameborder="0" ' . ($msie ? ' allowtransparency="true"' : '') . ' marginheight="0" scrolling="auto"></iframe></div>';
        $input_invalid = true;
    } else if ($multi_root_mode && !$twg_album) {
        echo '<div style="position:absolute; margin-left: -' . ($detailswidth / 2) . ';left: 50%;z-index:250">';
        echo isset($lang_root_mode_access) ? $lang_root_mode_access : 'Main access is not allowed in root mode.';
        echo '</div>';
        $input_invalid = true;
    } else if ($root_mode_no_login) {
        echo '<div style="position:absolute; margin-left: -' . ($detailswidth / 2) . ';left: 50%;z-index:250">';
        echo isset($lang_root_mode_login) ? $lang_root_mode_login : 'You don\'t have access to this album.';
        echo '</div>';
        $input_invalid = true;
    } else if ($image != false) { // imageview
        include (dirname(__FILE__) . '/inc/image.inc.php');
    } else if ($top10) {
        print_top_10($album_enc, $top10_type);
    } else if ($twg_album != false) { // thumbnailview - or top 10 view
        print_thumbnails($twg_album, $twg_offset, $werte, $index, $twg_foffset);
    } else { // main view!
        print_thumbnails(false, $twg_offset, $werte, $index, $twg_foffset);
    }
    echo '<div></center></td></tr>';
// <!-- end of image part -->
// <!-- navbar bottom -->

    if (!$default_is_fullscreen && (!$input_invalid)) {
        include dirname(__FILE__) . '/inc/bottomnav.inc.php';
    }

    echo '</table></div></td></tr>';

// don't ever remove this it is used for some measurement stuff
    echo '<tr><td colspan="3" class="twg_counterpixel" style="text-align:left;height:1px;">';
    echo '<img height="1" width="1" alt="" align="top" id="counterpixel"  src="' . $install_dir_view . 'buttons/1x1.gif" >';
    echo '</td></tr>';
    if (!$default_is_fullscreen) {
        include dirname(__FILE__) . '/inc/bottom.inc.php';

    } else {
        echo '</table>';
    }

    if ($leftinclude) {
        echo '</td></tr>';
        includeFooter($enable_external_html_include, $outerspan);
        echo '</table>';
    }

// we are through most of the code - lets load the javascripts that can be loaded here
    include dirname(__FILE__) . '/inc/late_js.inc.php';
    if ($use_dynamic_background && $show_background_images && !$default_is_fullscreen) {
        echo '</div>';
        if ($backgroundimage != '') { // we make this later because then it it loaded afterwards!
            echo '<script type="text/javascript">';
            echo 'makeIm();';
            echo '</script>';
        }
    }
    echo '<script type="text/javascript">hideSec("loader_id");</script>';
    echo '<script type="text/javascript">';

    $do_timeout = true;
    $do_resolution = true;

    if ($precache_background && !$image && $do_timeout) {
        echo 'window.setTimeout("pre_cache_xml_js(\'' . $install_dir_view . '\',\'' . $GLOBALS['standalone'] . '\')",3000);';
    }

    if ($do_resolution) {
        echo 'setScalling();';
        
        
        echo 'function setBrowserSize() {';
        if ($php_include) {
            echo 'window.setTimeout("send_Browser_resolution(\'yes\', \'' . $install_dir_view . '\',\'' . $GLOBALS['standalone'] . '\')",1000);';
        } else {
            echo 'window.setTimeout("send_Browser_resolution(\'no\', \'' . $install_dir_view  .  '\',\'' . $GLOBALS['standalone'] . '\')",1000);';
        }
        echo '}
            setBrowserSize();
            jQuery( window ).resize(function() {
               setBrowserSize();
            }); 
         ';
    }
    echo '</script>';

    if (!$default_is_fullscreen) {
        if (!$input_invalid) {
            include dirname(__FILE__) . '/inc/counterdiv.inc.php';
        }
    } else {
        include dirname(__FILE__) . '/inc/fullscreen.inc.php';
        createFullscreenControl($twg_album, $image);
    }
    if ($activate_lightbox_topx || $activate_lightbox_thumb || ($activate_lightbox_image && $enable_download)) {
        if ($use_lytebox) {
            echo '<script type="text/javascript">window.setTimeout("initLytebox();",300);</script>';
        } else {
            echo '<script type="text/javascript">window.setTimeout("initLightbox();",300);</script>';
        }
    }
    
    if (!$php_include) {
        echo '</center>';
        echo '</body></html>';
    } else {
        // we unset my error handler to track errors which are not TWG related.
        set_error_handler("on_error_no_output");
    }

    unset($_SESSION['TWG_CALL_COUNTER']);

    if ($support_piclens && (!$precache_main_top_x || !$cache_dirs)) {
        $dd = get_view_dirs($basedir, '');
        generate_piclens_rss($dd, '');
    }
    if ($debug_time) {
        $timeused = microtime() - $timestart;
        if ($image != false) { // imageview
            debug('Execution time image : ' . $timeused);
        } else if ($top10) { // - top 10 view
            debug('Execution time topx  : ' . $timeused);
        } else if ($twg_album != false) { // thumbnailview
            debug('Execution time thumb : ' . $timeused);
        } else { // main view!
            debug('Execution time main  : ' . $timeused);
        }

    }
    ?>
