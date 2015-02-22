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
// commentS for this picture?
$ccount = 0;

if (isset($kwerte)) { // this is the case if we call this during upload!
    $ccount = getKommentarCount($image, $twg_album, $kwerte, $kindex);
}
if ($ccount > 0) {
    $comment = true;
} else {
    $comment = false;
}

if ($twg_album) {
    $path = $basedir . "/" . $twg_album;
} else {
    $path = $basedir;
    $twg_album = "";
}

$main_dir = $path; //  . "/..";

if ($image == "x") {
    // 1st image
    $image = urldecode(get_first($twg_album));
}

$imagepath = $path . "/" . $image;
// testbild!!
if ($image == "test") {
    $print_text_original = false;
    $print_watermark_original = false;
    $imagepath = "buttons/info_test.jpg";
}

if (file_exists("skins/" . $skin . ".php")) {
    include "skins/" . $skin . ".php";
}

$remote_image = twg_checkurl($path);
if (file_exists($imagepath) || $remote_image) {
    if ($remote_image) {
        $image_full = getRemoteImagePath($remote_image, $image);

    } else {
        $image_full = $path . "/" . $image;
    }
    $existing_rot = getRotation($twg_album, $image, $image_full);
    if ($print_memory_usage) debug("imagecreate.inc.php - mem - switch(" . $image . ") : " . get_mem());
    switch ($type) {
        case "small":
            $show_clipped_images_thumb = $show_clipped_images;
            $show_clipped_images = false;
            $thumbimage = create_thumb_image($twg_album, urlencode($image));
            $small = create_cache_file($thumbimage, $extension_small);
            if (!$remote_image) {
                $oldsize = @getimagesize($image_full);
                // for broken images we try to read the exif data!
                if ($oldsize[0] == 0) {
                    $oldsize = get_image_exif_size($image_full, $image);
                }
            } else {
                $oldsize[0] = 9000;
                $oldsize[1] = 9000;
            }

            // we don't resise when picture is smaller - if it is remote we do this all the time because of the caching!!! - but we twg_rot !!
            if ((($small_pic_size >= $oldsize[0]) || $use_small_pic_size_as_height) && ($small_pic_size >= $oldsize[1])
                && !file_exists($small) && $resize_only_if_too_big
            ) {
                if (($login_edit) && ($twg_rot >= 0)) {
                    $act_pic_size = ($oldsize[0] > $oldsize[1]) ? $oldsize[0] : $oldsize[1];
                    generatesmall($image_full, $small, $act_pic_size, $compression, $twg_rot, $main_dir);
                } else {
                    if ($existing_rot > 0) {
                        $twg_rot = $existing_rot;
                        $login_edit = true;
                        $act_pic_size = ($oldsize[0] > $oldsize[1]) ? $oldsize[0] : $oldsize[1];
                        generatesmall($image_full, $small, $act_pic_size, $compression, $twg_rot, $main_dir);
                    } else {
                        $small = $image_full;
                    }
                }
            } else if ((!file_exists($small)) || (($login_edit) && ($twg_rot >= 0))) {
                if ($twg_rot == -1 && $existing_rot > 0) {
                    $twg_rot = $existing_rot;
                    $login_edit = true;
                }
                generatesmall($image_full, $small, $small_pic_size, $compression, $twg_rot, $main_dir);
            }
            // we have to generate a turned thumbnail if login == true and delete the file in the twg_slideshow !!
            if (($login_edit) && ($twg_rot >= 0)) {
                $show_clipped_images = $show_clipped_images_thumb;
                $thumbimage = create_thumb_image($twg_album, urlencode($image));
                $thumb = create_cache_file($thumbimage, $extension_thumb);
                generatesmall($image_full, $thumb, $thumb_pic_size, $compression_thumb, $twg_rot, $main_dir);
                $smallslide = create_cache_file($thumbimage, $extension_slideshow);
                // $smallslide = replaceSonderzeichen25($smallslide);
                if (file_exists($smallslide)) {
                    unlink($smallslide);
                } else {
                    // debug($smallslide . ' not found when deleting thumbnail - image.php/214');
                }
                // we store a file with the imagename but the following extension r090, r180, r270
                // we need this for the fullscreen twg_slideshow do know if we have to twg_rot the original!
                $rot = get_rot_file_name($twg_album, $image);
                $rot_file = fopen($rot, 'w');
                fputs($rot_file, $twg_rot);
                fclose($rot_file);
                $show_clipped_images = false;
            }

            if ($print_memory_usage) debug("imagecreate.inc.php - mem - before put(" . $small . ") : " . get_mem());
            if (!$twg_generate) {
                if (($twg_rot > 0) && (!$login_edit)) {
                    puttwg_rot($small, $twg_rot);
                } else {
                    putimage($small);
                }
            }
            if ($print_memory_usage) debug("imagecreate.inc.php - mem - after put(" . $small . ") : " . get_mem());
            break;
        case "twg_slideshowgenerate":
            $show_clipped_images = false;
            // $twg_album = urldecode($twg_album);
            $image = urldecode($image);
            $numgenpic = 0;
            $imagelist = get_image_list($twg_album);

            $imagelistSize = count($imagelist);
            $image_nr = get_image_number($twg_album, $image);
            for ($i = 0; $i < $imagelistSize; $i++) {
                $thumbimage = create_thumb_image($twg_album, $imagelist[$image_nr]);
                $smallslide = create_cache_file($thumbimage, $extension_slideshow);
                $small_cache = create_cache_file($thumbimage, $extension_small);

                $smallslide = replaceSonderzeichen25($smallslide);
                if ($remote_image) {
                    $image_full = getRemoteImagePath($remote_image, urldecode($imagelist[$image_nr]));
                } else {
                    $image_full = $path . "/" . urldecode($imagelist[$image_nr]);
                }
                if (!file_exists($smallslide)) {
                    $twg_rot = $existing_rot;
                    generatetwg_slideshow($image_full, $smallslide, $small_pic_size, $compression, $small_cache, $twg_rot, $main_dir);
                    if ($numgenpic++ > 3) {
                        return;
                    }
                }
                if (++$image_nr >= $imagelistSize) {
                    $image_nr = 0;
                }
            }
            break;
        case "thumb":
            $thumbimage = create_thumb_image($twg_album, urlencode($image));
            $thumb = create_cache_file($thumbimage, $extension_thumb);
            if (file_exists($thumb)) {
                putimage($thumb);
            } else {

                if ($twg_rot == -1) {
                    $twg_rot = $existing_rot;
                }
                if (generatesmall($image_full, $thumb, $thumb_pic_size, $compression_thumb, $twg_rot, $main_dir))
                    if (!$twg_generate) {
                        putimage($thumb);
                    }
            }
            break;
        case "full": // fullscreen for slideshow - size is stored in the session ! // check for twg_rotd images !!
            $twg_rot = $existing_rot; // getRotation ($twg_album, $image);
            generatefull($image_full, $browserx - 25, $browsery - 40, $compression, $twg_rot, $main_dir);

            break;
        case "fullscreen": // fullscreen - size is stored in the session ! // check for twg_rotd images !!
            $twg_rot = $existing_rot; // getRotation ($twg_album, $image);
            generatefull($image_full, $browserx + 75, $browsery + 75, $compression - 5, $twg_rot, $path);
            break;
        default: // original image
            if ($enable_download || $image == "test") {
                $show_clipped_images = false;
                if ($image == "test") {
                    $image_full = "buttons/info_test.jpg";
                } else if ($enable_download_counter) {
                    increaseDownloadCount($twg_album, $image);
                }

                $twg_rot = $existing_rot; // getRotation ($twg_album, $image);
                $modifyheader = true;

                if ($type == "download") {
                    $open_download_in_browser = true;
                }

                if ($print_text_original || $print_watermark_original) {
                    putwatermarkimage($image_full, $path, $twg_rot);
                } else {
                    putimage($image_full, $twg_rot);
                }
            } else {
                echo "Download of this image is not allowed.";
            }
            break;
    }
} else {
    // This are old links to your site we do ignore!
    // debug("'" . $imagepath . "' does not exist");
}

?>