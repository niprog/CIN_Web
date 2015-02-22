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

$use_small_pic_size_as_height = false;
if ($twg_album) {
    // we split the albums and pick an random one ... dividor = |
    $teile = explode("|", $twg_album);
    $key = array_rand($teile);
    $twg_album = $teile[$key];
}
if ($type != "top") {
    if ($twg_random_subdir) { // we get all view dirs for this folder!
        if ($twg_album) {
            $subdirs = get_view_dirs($basedir . "/" . $twg_album, $privatelogin);
        } else {
            $subdirs = get_view_dirs($basedir, $privatelogin);
        }
        $key = array_rand($subdirs);
        if (isset($subdirs[$key])) {
            $twg_album = $subdirs[$key];
        } else {
            $twg_album = false;
        }
    }
}
if ($twg_album) {
    if (!file_exists($basedir . "/" . $twg_album)) {
        $path = "buttons/noalbum.jpg";
        return generaterandom($path, $randomimagesize, $compression, $twg_rot, $basedir . "/" . $twg_album, "");
    }
}
// check if private - if yes return the private.gif!
$privatefilename = $basedir . "/" . $twg_album . "/" . $password_file;
if (file_exists($privatefilename) && !$twg_random_subdir) {
    $path = "buttons/private.png";
    return generaterandom($path, $randomimagesize, $compression, $twg_rot, $basedir . "/" . $twg_album, "");
}

// now we have an album - if topx we check if we have a stored topx_views file - if yes we use it - if no random!  
$topimage = false;
if ($type == "top") {
    include_once dirname(__FILE__) . "/readxml.inc.php";
    $autocreate_folder_image_recursive = true;
    if ($twg_album == $randomimage) { // makes it possible to the the 1st from the given folder!
        $topimage = getTopXViewsImage($twg_album, 0);
    } else {
        $topimage = getTopXViewsImage($twg_album, $randomimage - 1);
    }
}

if ($topimage) { // we have the most viewed image - or the number you gave me ... 
    $image = urlencode($topimage);
    // now we have to split in album and image
    $dirlist = explode("/", $topimage);
    $image = urlencode(array_pop($dirlist));
    if ($twg_album) {
        $twg_album = $twg_album . "/" . implode("/", $dirlist);
    } else {
        $twg_album = implode("/", $dirlist);
    }
} else { // random image ! 
    if (isset($_SESSION['rand' . $twg_album . $key])) {
        $imagelist = $_SESSION['rand' . $twg_album . $key];
    } else {
        $imagelist = get_image_list($twg_album);
    }
    if (!$imagelist) {
        $path = "buttons/noalbum.jpg";
        return generaterandom($path, $randomimagesize, $compression, $twg_rot, $basedir . "/" . $twg_album, "");
    }
    $randkey = array_rand($imagelist);
    $image = $imagelist[$randkey];
    // delete this key and push back to session - if empty delete session key
    unset($imagelist[$randkey]);
    if (count($imagelist) == 0) {
        unset($_SESSION['rand' . $twg_album . $key]);
    } else {
        $_SESSION['rand' . $twg_album . $key] = $imagelist;
    }
}

// storing this image in the session !!
$_SESSION['twg_random' . $randomimage] = urldecode($image);
// and the album because we can have multiple sinc 1.3
$_SESSION['twg_random_album' . $randomimage] = $twg_album;
$remote_image = twg_checkurl($basedir . "/" . $twg_album);
if ($remote_image) {
    $path = $remote_image . twg_urlencode(urldecode($image));
    $path = getRemoteImagePath($remote_image, urldecode($image));
} else {
    $path = $basedir . "/" . $twg_album . "/" . urldecode($image);
}

$thumbimage = create_thumb_image($twg_album, $image);
$thumb = create_cache_file($thumbimage, $extension_thumb);
$thumbsizefile = create_cache_file($thumbimage, $randomimagesize . "." . $extension_thumb);

if (file_exists($thumb) && ($randomimagesize == $thumb_pic_size)) {
    putimage($thumb);
} else if (file_exists($thumbsizefile)) {
    putimage($thumbsizefile);
} else {
    $rot = get_rot_file_name($twg_album, urldecode($image));
    if (file_exists($rot)) {
        $twg_rot = read_rot($rot);
    } else {
        if ($twg_rot_available) {
            $twg_rot = process_image_exif_rotation($path, $rot);
        } else {
            $twg_rot = 0;
        }
    }
    generaterandom($path, $randomimagesize, $compression, $twg_rot, $basedir . "/" . $twg_album, $thumbsizefile);
}

?>