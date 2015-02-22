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

set_error_handler('on_error_no_output');
@session_start();
set_error_handler('on_error');

if (isset($_GET['twg_rot'])) {
    $get_twg_rot = replaceInput(parse_maxlength($_GET['twg_rot'], 3));
    $twg_rot = ($get_twg_rot > 0 ? $get_twg_rot : 0);
    $twg_rot = $twg_rot >= 360 ? 0 : $twg_rot;
} else
    $twg_rot = -1;
// twg_album
if (isset($_GET['twg_album'])) {
    // we have to save the + es here :).
    $twg_album = replace_plus($_GET['twg_album']);
    $twg_album = str_replace("\\'", "'", $twg_album);
    $twg_album = urldecode($twg_album); // the double decode is because of some servers where this is needed!
    $twg_album = restore_plus($twg_album);
    if ($enable_basic_seo && !$use_old_seo_slash_encoding) {
        $twg_album = str_replace($album_sub_url_seo_character, "/", $twg_album);   
    }
    $twg_album = replaceInput($twg_album);
    $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset); // Albumwert für links, damit diese richtig codiert werden.
} else if (isset($twg_album)) { // set if included in a index.php and the album is already given.
    $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset); // Albumwert für links, damit diese richtig codiert werden.
} else {
    $twg_album = false;
    $album_enc = false;
}

$album_param = '';
if ($twg_album) {
    $album_param = 'twg_album=' . htmlentities(urlencode($twg_album), ENT_QUOTES, $charset) . '&amp;';
}

include (dirname(__FILE__) . '/../mapping.php');

// image
if (isset($_GET['twg_show'])) {
    $image = $_GET['twg_show'];
    // we check for security if a .. is in the path we remove this!
    $pos = strpos(strtolower($image), "http://");
    if ($pos === false) {
        $image = ereg_replace("/", "", $image);
    }
    $image = str_replace("\\'", "'", $image);
    // we don't allow external images this way anymore! - I have to think of a better way!
    $image = replaceInput($image);
    $image_enc = htmlentities(urlencode($image), ENT_QUOTES, $charset);
} else {
    $image = false;
    $image_enc = false;
}

// twg_offset
if (isset($_GET['twg_offset']) && $_GET['twg_offset'] > 0) {
    $twg_offset = parse_maxlength($_GET['twg_offset'], 4);
    $twg_offset = replaceInput($twg_offset);
} else
    $twg_offset = 0;

// folder offset !  12,9 = 1st level offset 12, 2nd level offset 9
if (isset($_GET['twg_foffset']) && $_GET['twg_foffset'] != "0") {
    $twg_foffset = parse_maxlength($_GET['twg_foffset'], 30);
    $twg_foffset = replaceInput($twg_foffset);
    $_SESSION['twg_ses_foffset'] = $twg_foffset;
} else if (isset($_GET['twg_foffset']) && $_GET['twg_foffset'] == '0') {
    $_SESSION['twg_ses_foffset'] = '0';
    $twg_foffset = "0";
} else if ($twg_album) { // if we are in an album and no foffset is set then we are at 0,0
    $twg_foffset = '0,0';
} else {
    $twg_foffset = '0,0';
}


// twg_slideshow
if (isset($_GET['twg_slideshow'])) {
    $twg_slideshow = $_GET['twg_slideshow'];
    $twg_slideshow = parse_maxlength(replaceInput($twg_slideshow), 5);
    $twg_smallnav = 'TRUE';
    $show_comments = false;
    $show_count_views = false;
} else
    $twg_slideshow = false;

if (isset($_GET['twg_top10'])) {
    $top10_type = parse_maxlength($_GET['twg_top10'], 10);
    $top10_type = replaceInput($top10_type);
    $top10 = true;
} else {
    $top10 = false;
    $top10_type = false;
}

if (isset($_GET['twg_dir'])) {
    $dir = $_GET['twg_dir'];
    $dir = replaceInput($dir);
} else
    $dir = "next";

if (isset($_GET['twg_random_display'])) {
    if (isset($_SESSION['twg_random' . $_GET['twg_random']])) {
        $image = $_SESSION['twg_random' . $_GET['twg_random']];
        $image = replaceInput($image);
        $image_enc = htmlentities(urlencode($image), ENT_QUOTES, $charset);
    } else { // if external html page was open toooo long we jump to the first image
        $image = false;
        $image_enc = false;
    }
}

if (isset($_GET['twg_random'])) {
    if (isset($_SESSION['twg_random_album' . $_GET['twg_random']])) {
        $twg_album = $_SESSION['twg_random_album' . $_GET['twg_random']];
        $twg_album = replaceInput($twg_album);
        $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
    } else { // if external html page was open toooo long we jump to the first image
        $twg_album = false;
        $album_enc = false;
    }
}

if (isset($_GET['twg_search_term'])) {
    $twg_search_term = $_GET['twg_search_term'];
    $twg_search_term = replaceInput($twg_search_term);
} else
    $twg_search_term = " ";

if (isset($_GET['twg_search_filename'])) {
    $twg_search_filename = true;
} else
    $twg_search_filename = false;

if (isset($_GET['twg_search_caption'])) {
    $twg_search_caption = true;
} else
    $twg_search_caption = false;

if (isset($_GET['twg_search_comment'])) {
    $twg_search_comment = true;
} else
    $twg_search_comment = false;

if (isset($_GET['twg_search_folders'])) {
    $twg_search_folders = true;
} else
    $twg_search_folders = false;

if (isset($_GET['twg_search_tags'])) {
    $twg_search_tags = true;
} else
    $twg_search_tags = false;

if (isset($_GET['twg_search_latest'])) {
    $twg_search_latest = true;
    $twg_search_folders = false;
    $twg_search_comment = false;
    $twg_search_caption = false;
    $twg_search_filename = false;
    $twg_search_tags = false;
} else
    $twg_search_latest = false;

if (isset($_GET['twg_search_max'])) {
    $twg_search_max = $_GET['twg_search_max'];
    $twg_search_max = replaceInput($twg_search_max);
} else
    $twg_search_max = 50;

if (isset($_GET['twg_search_num'])) {
    $twg_search_num = $_GET['twg_search_num'];
    $twg_search_num = replaceInput($twg_search_num);
} else
    $twg_search_num = 50;

if (isset($_GET['twg_search_exact'])) {
    $twg_search_exact = true;
} else {
    $twg_search_exact = false;
}
?>