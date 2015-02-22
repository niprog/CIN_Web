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

if ($video_php_exists || $video_dir) {
    $default_is_fullscreen = $twg_mobile_use_maximized_view = false;    
}

if ($lowbandwidth == "TRUE") {
    $show_colage = $low_show_colage;
    $show_count_views = $low_count_views;
    $cmotion_gallery_limit_ie = $low_cmotion_gallery_limit_ie;
    $cmotion_gallery_limit_firefox = $low_cmotion_gallery_limit_firefox;
    $compression = $low_compression;
    $thumbnails_x = $low_thumbnails_x;
    $thumbnails_y = $low_thumbnails_y;
    $show_background_images = $low_show_background_images;
    $enable_maximized_view = $low_enable_maximized_view;
    $default_is_fullscreen = $low_default_is_fullscreen;
    $number_top10 = $low_number_top10;
    $low_show_big_left_right_buttons = $low_show_big_left_right_buttons;
    $autodetect_maximum_thumbnails = false;
    $folder_effect = $low_folder_effect;
    $activate_lightbox_thumb = $low_activate_lightbox_thumb;
    $activate_lightbox_thumb_full = $low_activate_lightbox_thumb_full;
    $activate_lightbox_image = $low_activate_lightbox_image;
    if (isset($_GET['twg_lowbandwidth'])) { // seting for th 1.st time - can be later changed by the user !
        $twg_smallnav = $low_show_only_small_navigation;
        $twg_slide_type = $low_twg_slide_type;
        $default_big_navigation = $low_default_big_navigation;
        $_SESSION['twg_ses']['nav_small'] = $twg_smallnav;
        $_SESSION['twg_ses']['twg_slide_type'] = $low_twg_slide_type;
        $_SESSION['dhtml_nav'] = $default_big_navigation;
    }
}

if ($twg_mobile) { // for mobile phones we add some additional settings. Space is the problem - therefore we remove some stuff
    $menu_x = $twg_mobile_menu_x;
    $menu_y =  $twg_mobile_menu_y;
    $thumbnails_x = $twg_mobile_thumbnails_x;
    $thumbnails_y = $twg_mobile_thumbnails_y;
    $show_breadcrumb = $twg_mobile_show_breadcrumb;
    $show_search = $show_enhanced_file_infos = $show_help_link = $show_login = $show_optionen = $show_tags = $show_new_window = $twg_mobile_show_menu_items;
    $album_tree_default_open != $twg_mobile_show_menu_items;
    $show_image_rating = $twg_mobile_show_rating;
    $show_comments = $twg_mobile_show_comments;
    $show_counter = $twg_mobile_show_counter;
    $twg_smallnav = ($twg_mobile_show_big_navigation) ? 'FALSE' : 'TRUE';
    $default_is_fullscreen = $open_in_maximized_view = $enable_maximized_view = $twg_mobile_use_maximized_view;
    if ($twg_mobile_use_maximized_view) {
        $use_round_corners = false;
    }
    $enable_download = false; // needed to activate swipe !
    $activate_lightbox_image = $activate_lightbox_thumb = !$twg_mobile_use_maximized_view;

    $responsive_main_page = $twg_mobile_responsive_main_page;
    $responsive_thumb_page = $twg_mobile_responsive_thumb_page;
    $responsive_detail_page = $twg_mobile_responsive_detail_page;
    
    if (!$isTablet && $responsive_thumb_page) {
      $autodetect_maximum_thumbnails = false;
    }
    

}

if (($isIpad || $isIphone) && $default_big_navigation == 'FLASH') {
    $default_big_navigation = 'DHTML';
}

if (isset($twg_slideshow) && $twg_slideshow) {
    $default_is_fullscreen = false;
    // album exporer is not shown.
    $album_tree_default_open = false;
}

// we check if the session is available! if not we disable login, options, private login, language selection and include is not possible
if (session_id()) {
    $session_available = true;
} else {
    $session_available = false;
    $show_login = false;
    $show_optionen = false;
    $privatelogin = "";
}
// restrictions for Opera 7.x - xmlhttp is not available there


if ($opera7) {
    $default_big_navigation = "HTML";
    $twg_slide_type = "FALSE";
    $xml_http = false;
    $enable_maximized_view = false;
    $default_is_fullscreen = false;
    $show_optimized_slideshow = false;
} else {
    $xml_http = true;
}

if (isset($_SESSION['twg_nojs'])) { // no jacascript - we turn off lots of stuff
    $default_big_navigation = "HTML";
    $twg_slide_type = "FALSE";
    $xml_http = false;
    $enable_maximized_view = false;
    $default_is_fullscreen = false;
    $show_comments = false;
    $show_login = false;
    $show_optionen = false;
    $show_image_rating = false;
    $show_search = false;
    $show_tags = false;
    $show_new_window = false;
    $enable_counter_details = false;
    $show_enhanced_file_infos = false;
    $show_email_notification = false;
    $center_cmotiongal_over_image = false;
    $show_languages_as_dropdown = false;
    $activate_lightbox_thumb = false;
    $activate_lightbox_thumb_full = false;
    $activate_lightbox_image = false;
    if ($topx_default == "comments") {
        $topx_default = "views";
    }
    $show_videos = $low_show_videos;
    $enable_album_tree = false;
}
// disables some function that does not work anymore!
if ($disable_direct_thumbs_access) {
    $show_optimized_slideshow = false; // new 1.3 - Shows/hides the optimized slideshow option in the options menu - if true: $twg_slide_type should not be 'TRUE'!
    if ($twg_slide_type == 'TRUE') {
        $twg_slide_type = 'FALSE';
    }
}

if ($wii) {
    $show_only_small_navigation = 'TRUE';
    $twg_smallnav = 'TRUE';
    $image_rating_position = 'menu';
    $show_captions = false;
    $enable_drop_shadow = false;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
}

?>