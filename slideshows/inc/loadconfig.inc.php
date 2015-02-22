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
 
$Date: 2007-02-16 09:17:41 +0100 (Fr, 16 Feb 2007) $
$Revision: 41 $
 **********************************************/

defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');

// loads all configs recusively!
$customconfig = false;

if ($twg_album) {
    $twg_album_parts = explode("/", $twg_album);
    $twg_temp_album = "";
    while ($twg_album_parts != NULL) {
        $twg_temp_album .= array_shift($twg_album_parts) . '/';
        $configphp = ($basedir . "/" . $twg_temp_album . "config.php");
        if (file_exists($configphp)) {
            include $configphp;
            $customconfig = true;
        }
        $configphp_lang = ($basedir . "/" . $twg_temp_album . "config_" . $default_language . ".php");
        if (file_exists($configphp_lang)) {
            include $configphp_lang;
            $customconfig = true;
        }
    }
} else {
    // we look for a custom config in the pictures folder which is NOT read recursive
    $configphp = ($basedir . '/config.php');
    if (file_exists($configphp)) {
        include $configphp;
        $customconfig = true;
    }
}
if ($customconfig) {
    // we check if we have a skin which overwrites something
    if (file_exists("skins/" . $skin . ".php")) {
        include  "skins/" . $skin . ".php";
    }
}

$video_dir = false;

if ($twg_album) {
    $videofilename = ($basedir . "/" . $twg_album . "/video.php");
} else {
    $videofilename = ($basedir . "/video.php");
}
$video_player_config = $video_player;

$video_php_exists = file_exists($videofilename);
// we check videostreaming
if ($video_php_exists || $video_autodetect) { // presettings for videosupport!
    $video_dir = true;
    if (file_exists($videofilename)) {
        include $videofilename;
    } else {
        $video_player = 'AUTO';
        $video_size_x = $video_size_x;
        $video_size_y = $video_size_y;
    }
    $video_player_config = $video_player;
    // now we check if it's auto and then check which type of stuff we have in there!
    if ($video_player == 'AUTO' || $video_player == 'auto') {
        $video_player_config = 'AUTO';
        // we check if we have a video for this image and set the player autodetection for FLV (flv), DIVX (divx), QT (mov), WMP 	(avi,mpg,mpeg, wmv)
        if ($image == "x") { // autoskip we have an x!
            $list = get_image_list($twg_album);
            if (count($list) > 0) {
                $image = urldecode($list[0]);
            }
        }

        $searchimage = removeExtension($basedir . '/' . $twg_album . '/' . $image);
        if (file_exists($searchimage . '.flv') || file_exists($searchimage . '.FLV')) {
            $video_player = 'FLV';
        } else if (file_exists($searchimage . '.mp4') || file_exists($searchimage . '.MP4')) {
            $video_player = 'HTML5'; 
        } else if (file_exists($searchimage . '.mov') || file_exists($searchimage . '.MOV')) {
            $video_player = 'QT';
        } else if (file_exists($searchimage . '.divx') || file_exists($searchimage . '.DIVX')) {
            $video_player = 'DIVX';
        } else if (file_exists($searchimage . '.avi') || file_exists($searchimage . '.AVI') || file_exists($searchimage . '.mpg')
            || file_exists($searchimage . '.MPG') || file_exists($searchimage . '.mpeg') || file_exists($searchimage . '.MPEG')
            || file_exists($searchimage . '.wmv') || file_exists($searchimage . '.WMV')
        ) {
            $video_player = 'WMP';
        } else { // no supported movie - it's an image and displayed like one!
            $video_dir = false;
        }
    }
}

if ($video_dir) {
    $show_rotation_buttons = false;
    $show_slideshow = false;
}

if ($mixed_video_image_content && $default_big_navigation == 'DHTML' || ($video_dir && $default_big_navigation == 'DHTML' && $video_player == 'AUTO')) {
    $default_big_navigation = 'HTML';
    $show_big_left_right_buttons = $show_first_last_at_autoswitch;
}

if ($twg_enable_session_cache) {
    $cache_dirs = true;
}
if ($twg_disable_session_cache) {
    $cache_dirs = false;
}

if (hasRootLink($basedir . '/' . $twg_album) && $twg_album != false && !$multi_root_mode) {
    $enable_album_tree = false;
}

/* Don't use round corners when these two settings are set! */
if ($default_is_fullscreen) {
    $use_round_corners = false;
}

if ($multi_root_mode) {
    $precache_background = false;
    $support_piclens = false;
}

if ($default_big_navigation == 'FLASH') {
    $use_nonscrolling_dhtml = false;
}

if (isset($twg_mobile) && $twg_mobile) {
    $icon_set = $icon_set_mobile;
}

if ($icon_set == 'mobile') {
    $show_print_icon = false;
}

if ($show_rotation_buttons && isset($login)) {
    if ($show_rotation_buttons_login_only && ($login == 'FALSE' || $login_edit != true)) {
        $show_rotation_buttons = false;
    }
}

if ($show_rotation_buttons_login_only && $show_rotation_buttons) {
    $show_rotation_buttons = $login_edit;
}


$password_iframe = ($user_login_mode) ? 'i_login.php' : 'i_privatelogin.php';

$numberofpics_orig = $numberofpics;

// height of the iframes - please check if the settings match for your language!!
// since 1.6 I use transparent iframes - therefore the heights are only the maximum are this is used.
$lang_height_comment = 280;
$lang_height_caption = 450;
$lang_height_login = 450;
$lang_height_private = 280;
$lang_height_options = 280;
if ($self_registration_security_image) {
    $lang_height_private += 90;
}
if (!$show_new_window) {
    $lang_height_options -= 30;
}
if (!$show_slideshow) {
    $lang_height_options -= 60;
}
if (!$enable_maximized_view) {
    $lang_height_options -= 30;
}
if ($disable_nav_sel) {
    $lang_height_options -= 30;
}
if ($disable_nav_big_sel) {
    $lang_height_options -= 30;
}
$lang_height_email_user = 280;
$lang_height_info = 220;
if (!$show_download_counter || !$enable_download_counter) {
    $lang_height_info -= 17;
}
if (!$show_count_views) {
    $lang_height_info -= 17;
}
if (!$show_image_rating) {
    $lang_height_info -= 17;
}
if ($show_exif_info) {
    $lang_height_info += (6 * 17);
}
if ($show_tags) {
    $lang_height_info += (4 * 12);
} // max 4 tags are planned!
if ($show_iptc_data) {
    $lang_height_info += (5 * 17);
}
$lang_height_rating = 280;
$lang_height_dl_manager = 280;
$lang_height_search = 280;
$lang_height_upload = 370;
$lang_height_tags_insert = 280;
$lang_height_tags_top = 280;

if ($cachedir != 'cache') {
    $optimize_css = false;
}
?>