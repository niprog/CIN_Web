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

if (isset($_GET['twg_rot'])) {
    $twg_rot = ($_GET['twg_rot'] >= 0 ? $_GET['twg_rot'] : -1);
    $twg_rot = $twg_rot >= 360 ? 0 : $twg_rot;
} else
    $twg_rot = -1;
// twg_album
if (isset($_GET['twg_album'])) {
    $twg_album = replace_plus(replaceInput($_GET['twg_album']));
    $twg_album = str_replace("\\'", "'", $twg_album);
    $twg_album = urldecode($twg_album); // the double decode is because of some servers where this is needed!
    $twg_album = restore_plus($twg_album);
    $album_url = $twg_album;
    $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
} else {
    $twg_album = false;
    $album_url = false;
}

include (dirname(__FILE__) . '/../mapping.php');

// image
if (isset($_GET['twg_show'])) {
    $image = $_GET['twg_show'];
    $pos = strpos(strtolower($image), "http://");
    if ($pos === false) {
        $image = ereg_replace("/", "", $image);
    }
    $image = str_replace("\\'", "'", $image);
    $image = replaceInput($image);
    $image_enc = htmlentities(urlencode($image), ENT_QUOTES, $charset);
} else
    $image = false;

if ($input_invalid) {
    printErrorInvalid();
    die();
}
// type
if (isset($_GET['twg_generate'])) {
    $twg_generate = true;
} else
    $twg_generate = false;
// type
if (isset($_GET['twg_type'])) {
    $type = $_GET['twg_type'];
    $type = replaceInput($type);
} else
    $type = false;
// randomnr
if (isset($_GET['twg_random'])) {
    $randomimage = $_GET['twg_random'];
    $randomimage = replaceInput($randomimage);
} else
    $randomimage = false;

if (isset($_GET['twg_random_display'])) {
    if (isset($_GET['twg_random'])) {
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
}

// randomimagesize
if (isset($_GET['twg_random_size'])) {
    $randomimagesize = $_GET['twg_random_size'];
    $randomimagesize = replaceInput($randomimagesize);
} else
    $randomimagesize = $thumb_pic_size;

if (isset($_GET['twg_random_subdir']) && $_GET['twg_random_subdir'] == 'true') {
    $twg_random_subdir = true;
} else
    $twg_random_subdir = false;

$dataXmlHttp = false;
$browserXmlHttp = false;
$menuXmlHttp = false;
$menuXmlAutohide = false;

if (isset($_GET['twg_xmlhttp'])) {
    if ($_GET['twg_xmlhttp'] == 'd') {
        $dataXmlHttp = true;
    }
    if ($_GET['twg_xmlhttp'] == 'r') {
        $browserXmlHttp = true;
    }
    if ($_GET['twg_xmlhttp'] == 'm') {
        $menuXmlHttp = true;
    }
    if ($_GET['twg_xmlhttp'] == 'h') {
        $menuXmlAutohide = true;
    }
}

if (isset($_GET['twg_precachexml'])) {
    $precachexml = true;
} else {
    $precachexml = false;
}

if (isset($_GET['twg_nojs'])) {
    $browserNoJS = true;
} else {
    $browserNoJS = false;
}
?>