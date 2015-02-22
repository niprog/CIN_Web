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

function set_attachment_header($image, $modifyheader, $image_type)
{
    global $enable_ie_filename_fix, $msie;
    global $open_download_in_browser;

    $filename = basename($image);
    if ($image_type == 3) { // .png
        $filename = exchangeExtension($filename, "png");
    } else if ($image_type == 1) { // .gif
        $filename = exchangeExtension($filename, "gif");
    }
    if (!$open_download_in_browser && $modifyheader) {
        header("Content-Disposition: attachment; filename=\"" . urldecode($filename) . "\";\n");
    } else {
        header("Content-Disposition: filename=\"" . urldecode($filename) . "\";\n");
    }

    // fix for ie - forces to reload
    if ($enable_ie_filename_fix && $msie) {
        header("Cache-Control: must-revalidate");
    }
}

function putimage($image, $twg_rot = 0)
{
    global $modifyheader;
    $oldsize = getImageSize(http_encode($image));
    // for broken images we set jpeg!
    if ($oldsize[0] == 0) {
        $oldsize[2] = 2;
    }
    set_image_header($oldsize[2]);
    set_attachment_header($image, $modifyheader, $oldsize[2]);
    if (substr($image, 4, 3) != "://") { // not supported by external images
        header("Content-Length: " . filesize($image));
    }

    if ($twg_rot > 0) {
        puttwg_rot(http_encode($image), $twg_rot);
    } else {
        $fp = fopen(http_encode($image), "rb");
        while ($content = fread($fp, 8192)) {
            print $content;
        }
        fclose($fp);
    }
}

function putpngimage($image)
{
    // set Documet Type
    $oldsize = getImageSize($image);
    // for broken images we set png!
    if ($oldsize[0] == 0) {
        $oldsize[2] = 3;
    }
    set_image_header($oldsize[2]); // done because it could be renamed jpgs too!
    if (substr($image, 4, 3) != "://") {
        header("Content-Length: " . filesize($image));
    }
    $fp = fopen($image, "rb");
    while ($content = fread($fp, 8192)) {
        print $content;
    }
    fclose($fp);
}

function putwatermarkimage($image, $dir, $twg_rot)
{
    global $font, $fontsize_original, $text, $textcolor_R, $textcolor_G, $textcolor_B, $position, $modifyheader;
    global $watermark_big, $open_download_in_browser, $print_watermark_original, $print_text_original;

    $oldsize = getImageSize($image);
    // for broken images we try to read the exif data!
    if ($oldsize[0] == 0) {
        $oldsize = get_image_exif_size($image, $image);
    }
    $image_type = $oldsize[2];

    set_image_header($image_type);
    set_attachment_header($image, $modifyheader, $image_type);
    // header("Content-Length: ".filesize($image));

    $dst = loadImage($image, $image_type);

    if (($twg_rot > 0)) {
        $dst = imagerotate($dst, $twg_rot, 0);
    }

    if ($print_text_original && function_exists("imagettftext")) {
        $color = imagecolorclosest($dst, $textcolor_R, $textcolor_G, $textcolor_B);
        if ($image_type != 2) { // antialising only for jpgs
            $color = -$color;
        }
        $text = getFileContent($dir . "/watermark.txt", $text);
        if (function_exists("imagettftext")) {
            imagettftext($dst, $fontsize_original, 0, 7, $oldsize[1] - 7, $color, $font, $text);
        }
    }
    if ($print_watermark_original) {
        if (file_exists($dir . "/watermark_big.png")) {
            $watermark_big = $dir . "/watermark_big.png";
        }
        watermark($dst, $watermark_big, $oldsize[0], $oldsize[1], $oldsize[2], $position);
    }

    store_image($dst, null, $image_type, 100);
}

function puttwg_rot($image, $angle)
{
    global $compression;
    $oldsize = getImageSize($image);
    // for broken images we set jpeg!
    if ($oldsize[0] == 0) {
        $oldsize = get_image_exif_size($image, $image);
    }
    $image_type = $oldsize[2];
    set_image_header($image_type);
    $src = loadImage($image, $image_type);
    $dst = imagecreatetruecolor($oldsize[0], $oldsize[1]);
    keepTransparency($image_type, $src, $dst, $oldsize[0], $oldsize[1]);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $oldsize[0], $oldsize[1], $oldsize[0], $oldsize[1]);
    $twg_rot = imagerotate($dst, $angle, 0);
    $result = store_image($twg_rot, null, $image_type, $compression);
    if (!$result) {
        store_image($dst, null, $image_type, $compression);
    } else {
        imagedestroy($dst);
    }
}

function generatesmall($image, $small, $size, $compression, $twg_rot, $dir, $otherwatermark = false, $isbackground = false)
{
    global $text, $textcolor_R, $textcolor_G, $textcolor_B, $use_small_pic_size_as_height;
    global $small_pic_size, $thumb_pic_size, $comment_corner_size, $comment_corner_backcolor_R;
    global $comment_corner_backcolor_G, $comment_corner_backcolor_B, $print_watermark;
    global $watermark_small, $maxXSize, $position, $watermark_position, $other_file_formats;
    global $transparency, $watermark_transparency, $print_memory_usage, $install_dir, $mixed_video_image_content;
    global $use_image_magic, $image_magic_path, $overlays_for_other_file_formats, $video_player;
    global $login_edit, $comment, $small_pic_size, $print_text, $font, $fontsize, $show_clipped_images;
    global $image_factor, $fix_ie_fade;

    $show_clipped_images_local = $show_clipped_images;

    if ($isbackground) {
        $show_clipped_images_local = $print_text = $print_watermark = false;
    }

    if ($print_memory_usage) debug("generatesmall - mem - start(" . $small . ") : " . get_mem());
    $srcx = 0; //  for clipped images to center them!
    $srcy = 0;
    if (file_exists($image) || substr($image, 4, 3) == "://") {
        $oldsize = getimagesize(http_encode($image));
        if ($oldsize[0] == 0) {
            $oldsize = get_image_exif_size($image, $image);
        }
        $oldsizex = $oldsize[0];
        $oldsizey = $oldsize[1];
        $image_type = $oldsize[2];

        if (!$show_clipped_images_local) {
            if ($oldsizex > $oldsizey) { // querformat
                if (($use_small_pic_size_as_height) && ($size == $small_pic_size)) { // horizontals are bigger then verticals images
                    if (($twg_rot == 90 || $twg_rot == 270) && ($login_edit)) {
                        $width = $size;
                        $height = ($width / $oldsizex) * $oldsizey;
                    } else {
                        $height = $size;
                        $width = $height / $oldsizey * $oldsizex;
                        if ($width > $maxXSize && (($oldsizex / $oldsizey) > $image_factor)) { // we fix images which are too wide! (factor 1.8 ~ 16:9!)
                            $width = $maxXSize;
                            $height = ($width / $oldsizex) * $oldsizey;
                        }
                    }
                } else { // this keeps the dimension between horzonal and vertical
                    $width = $size;
                    $height = ($width / $oldsizex) * $oldsizey;
                }
            } else { // hochformat
                if (($use_small_pic_size_as_height) && ($size == $small_pic_size)) { // horizontals are bigger then verticals images
                    if (($twg_rot == 90 || $twg_rot == 270) && ($login_edit)) {
                        $height = ($size * $oldsizey) / $oldsizex;
                        $width = $size;
                    } else {
                        $height = $size;
                        $width = ($height / $oldsizey) * $oldsizex;
                    }
                } else { // this keeps the dimension between horzonal an vertical
                    $height = $size;
                    $width = ($height / $oldsizey) * $oldsizex;
                }
            }
        } else {
            $width = $size;
            $height = $size;
            $quer = false;
            if ($oldsizex > $oldsizey) { // querformat
                $quer = true;
                $srcx = ($oldsizex - $oldsizey) / 2;
                $oldsizex = $oldsizey;
            } else {
                // $srcy =  ($oldsizey - $oldsizex) / 2;
                $oldsizey = $oldsizex;
            }
        }
        $width = round($width);
        $height = round($height);

        if ($print_memory_usage) debug("generatesmall - mem - before loading src(" . $small . ") : " . get_mem());
        $save_image = true;
        if ($use_image_magic) {
            // convert -geometry 60x80 image.gif out.gif  $width x $height
            $fh = fopen($small, 'w'); // fix for a but in some php - versions - thanks to Anders
            fclose($fh);
            $resize = $width . "x" . $height;
            $cl = "";
            if ($show_clipped_images_local) {
                $cl = " -gravity center -crop " . $size . "x" . $size . "+0+0 "; // I remove repage - seems not to work on all systems!
                if ($quer) { // querformat
                    $resize = "x" . $height;
                } else {
                    $resize = $width . "x";
                }
            }
            
            $pos = strpos(strtolower($image), "http");
            $realpath_image = ($pos === false) ? realpath($image): $image; 
           
            $command = $image_magic_path . " \"" . $realpath_image . "\" -quality " . $compression . " -resize " . $resize . $cl . " \"" . realpath($small) . "\"";
            execute_command($command);
            $save_image = false;
            if ($print_memory_usage) debug("generatesmall - mem - after image magic (" . $small . ") : " . get_mem());

            // we check if image magic was working properly
            if (file_exists($small) && (filesize($small) > 0)) {
                $dst = loadImage($small, 2);
            } else {
                if (file_exists($small)) {
                    unlink($small);
                }
                debug("Image magick failed: " . $command);
                $dst = loadImage($install_dir . "buttons/notvalidmagic.gif", 1);
                $use_image_magic = false;
                $save_image = true;
            }
            // we load the dest image for further processing!
        } else {
            $memory = ($oldsizex * $oldsizey * 6) + 2000000; // mem usage and we add 2MB for processing
            try_to_increase_mem($memory);
            $free_memory = get_free_mem();
            if ($memory > $free_memory && $free_memory > 0) { // memory problem
                debug("File '" . $image . "' is too big - it uses ~ " . floor($memory / 1024) . " KB. The free memory is " . floor($free_memory / 1024) . " KB. Check the info for the maximum resolution! Please resize the image with an external tool or increase the php memory! If you have autocreate_folder_image=true please turn this off.");
                move_problem_image($image);
                return false;
            } else {
                $src = loadImage($image, $image_type);
            }

            if (!$src) { // if image is not valid!
                if (!move_problem_image($image)) {
                    $dst = loadImage($install_dir . "buttons/notvalid.gif", 1);
                    $srcx = 0;
                    $srcy = 0;
                    $oldsizex = 280;
                    $oldsizey = 160;
                } else {
                    return false;
                }
            }

            if ($print_memory_usage) debug("generatesmall - mem - after loading src(" . $small . ") : " . get_mem());
            $dst = ImageCreateTrueColor($width, $height);
            keepTransparency($image_type, $src, $dst, $width, $height);
            if ($print_memory_usage) debug("generatesmall - mem - before imagecopyresampled (" . $small . ") : " . get_mem());
            // center clipped images ! - but only the vertical ones - horizontal are mainly  images of people and there the upper part should be shown
            if ($width == $oldsizex && $height == $oldsizey) {
                // we only resize if really needed!
                imagedestroy($dst);
                $dst = $src;
            } else {
                imagecopyresampled($dst, $src, 0, 0, $srcx, $srcy, $width, $height, $oldsizex, $oldsizey);
                imagedestroy($src);
            }
            if ($print_memory_usage) debug("generatesmall - mem - after imagecopyresampled (" . $small . ") : " . get_mem());
        }
        if (true) {
            if ($comment && ($size == $thumb_pic_size)) {
                // set up array of points for polygon
                $values = array($width - $comment_corner_size, 0, $width, 0, $width, $comment_corner_size);
                $white = imagecolorclosest($dst, $comment_corner_backcolor_R, $comment_corner_backcolor_G, $comment_corner_backcolor_B);
                // draw a polygon
                imagefilledpolygon($dst, $values, 3, $white);
                $save_image = true;
            }

            if ($print_memory_usage) debug("generatesmall - mem - after mark comment (" . $small . ") : " . get_mem());

            if (($twg_rot > 0) && ($login_edit)) {
                $dst = imagerotate($dst, $twg_rot, 0);
                $save_image = true;
            }

            if ($print_memory_usage) debug("generatesmall - mem - after rotate (" . $small . ") : " . get_mem());

            if (($size == $small_pic_size) && $print_text) {
                if (function_exists("imagettftext")) {
                    $text = getFileContent($dir . "/watermark.txt", $text);
                    $color = imagecolorclosest($dst, $textcolor_R, $textcolor_G, $textcolor_B);
                    if ($image_type != 2) { // antialising only for jpgs
                        $color = -$color;
                    }
                    if ($twg_rot == 90 || $twg_rot == 270) {
                        imagettftext($dst, $fontsize, 0, 7, $width - 7, $color, $font, $text);
                    } else {
                        imagettftext($dst, $fontsize, 0, 7, $height - 7, $color, $font, $text);
                    }
                    $save_image = true;
                }
            }

            if ($print_memory_usage) debug("generatesmall - mem - after textwatermark (" . $small . ") : " . get_mem());

            if (($size == $small_pic_size || ($watermark_small == "buttons/private.png")) && $print_watermark) {
                if ($watermark_small == "buttons/private.png") {
                   $transparency = 0;
                } else if (file_exists($dir . "/watermark.png")) {
                    $watermark_small = $dir . "/watermark.png";
                }
                if ($twg_rot == 90 || $twg_rot == 270) {
                    watermark($dst, $watermark_small, $height, $width, $oldsize[2], $position);
                } else {
                    watermark($dst, $watermark_small, $width, $height, $oldsize[2], $position);
                }
                $save_image = true;
            }

            if ($print_memory_usage) debug("generatesmall - mem - after image watermark (" . $small . ") : " . get_mem());
            // we serach for an other file format!
            if ($overlays_for_other_file_formats) {
                foreach ($other_file_formats as $label => $key) {
                    $other_format = exchangeExtension($image, $label);
                    $other_format2 = removeExtension($image);
                    if (!$isbackground && (file_exists($other_format) || file_exists($other_format2) || ($otherwatermark == $label))) {
                        $transparency = $watermark_transparency;
                        if ($otherwatermark) {
                            $key = "../" . $key;
                        }
                        watermark($dst, $key, $width, $height, $oldsize[2], $watermark_position);
                        $save_image = true;
                        break;
                    }
                }
                // youtube - FLASH videos
                if (($video_player == 'FLASH') && file_exists($dir . '/video.php')) {
                    if (!$mixed_video_image_content || strpos('v___', $image) !== false) {
                        $key = $other_file_formats['youtube'];
                        if ($otherwatermark) {
                            $key = "../" . $key;
                        }
                        watermark($dst, $key, $width, $height, $oldsize[2], $watermark_position);
                        $save_image = true;
                    }
                }
            }

            if ($print_memory_usage) debug("generatesmall - mem - after other format watermark (" . $small . ") : " . get_mem());
        }
        if ($save_image) {
            if (!$use_image_magic) {
                $fh = fopen($small, 'w'); // fix for a but in some php - versions - thanks to Anders
                fclose($fh);
            }

            // IE does not handle jquery fadeTo properly for black. Therefore I replace black with
            // a dark grey if $fix_ie_fade is set
            if ($fix_ie_fade) {
                imagetruecolortopalette($dst, false, 16700000);
                $index = imagecolorclosest($dst, 0, 0, 0); // get black COlor
                imagecolorset($dst, $index, 1, 1, 1); // SET NEW COLOR
                $index = imagecolorclosest($dst, 1, 0, 0); // get black COlor
                imagecolorset($dst, $index, 1, 1, 1); // SET NEW COLOR
                $index = imagecolorclosest($dst, 0, 1, 0); // get black COlor
                imagecolorset($dst, $index, 1, 1, 1); // SET NEW COLOR
                $index = imagecolorclosest($dst, 0, 0, 1); // get black COlor
                imagecolorset($dst, $index, 1, 1, 1); // SET NEW COLOR
                $index = imagecolorclosest($dst, 1, 0, 1); // get black COlor
                imagecolorset($dst, $index, 1, 1, 1); // SET NEW COLOR
                $index = imagecolorclosest($dst, 0, 1, 1); // get black COlor
                imagecolorset($dst, $index, 1, 1, 1); // SET NEW COLOR
                $index = imagecolorclosest($dst, 1, 1, 0); // get black COlor
                imagecolorset($dst, $index, 1, 1, 1); // SET NEW COLOR
            }

            $result = store_image($dst, $small, $image_type, $compression);
            if ($result) {
                if ($print_memory_usage) debug("generatesmall - mem - after saving (" . $small . ") : " . get_mem());
            } else {
                debug('cannot save: ' . $small);
            }
        } else {
            $result = true; // already saved
        }
        return $result;
    } else
        return false;
}

function generatefull($image, $sizex, $sizey, $compression, $twg_rot, $dir, $filename = false)
{
    global $print_text, $font, $fontsize, $text, $textcolor_R, $textcolor_G, $position;
    global $textcolor_B, $print_watermark, $watermark_small; // $browserx, $browsery;
    global $enable_random_image_caching, $thumb_pic_size;

    if (file_exists($image) || substr($image, 4, 3) == "://") {
        $oldsize = getimagesize(http_encode($image));
        if ($oldsize[0] == 0) {
            $oldsize = get_image_exif_size($image, $image);
        }
        $oldsizex = $oldsize[0];
        $oldsizey = $oldsize[1];
        $image_type = $oldsize[2];

        if (($twg_rot != 0) && ($twg_rot != 180)) { // quer
            $tempsize = $sizex;
            $sizex = $sizey;
            $sizey = $tempsize;
        }
        $height = $sizey;
        $width = ($height / $oldsizey) * $oldsizex;
        if ($width > $sizex) {
            $width = $sizex;
            $height = ($width / $oldsizex) * $oldsizey;
        }

        $memory = ($oldsizex * $oldsizey * 6) + 2000000; // mem usage and we add 2MB for processing
        try_to_increase_mem($memory);

        $src = loadImage($image, $image_type);
        $dst = ImageCreateTrueColor($width, $height);
        keepTransparency($image_type, $src, $dst, $width, $height);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $oldsizex, $oldsizey);
        imagedestroy($src);

        if ($twg_rot > 0) {
            $dst = imagerotate($dst, $twg_rot, 0);
        }
        if ($print_text && ($sizex > 300)) {
            if (function_exists("imagettftext")) {
                $text = getFileContent($dir . "/watermark.txt", $text);
                $color = imagecolorclosest($dst, $textcolor_R, $textcolor_G, $textcolor_B);
                if ($image_type != 2) { // antialising only for jpgs
                    $color = -$color;
                }
                if ($twg_rot == 90 || $twg_rot == 270) {
                    imagettftext($dst, $fontsize, 0, 7, $width - 7, $color, $font, $text);
                } else {
                    imagettftext($dst, $fontsize, 0, 7, $height - 7, $color, $font, $text);
                }
            }
        }

        if ($print_watermark && ($sizex > 300)) {
            // todo - look for a local small watermark
            if (file_exists($dir . "/watermark.png")) {
                $watermark_small = $dir . "/watermark.png";
            }
            if ($twg_rot == 90 || $twg_rot == 270) {
                watermark($dst, $watermark_small, $height, $width, $oldsize[2], $position);
            } else {
                watermark($dst, $watermark_small, $width, $height, $oldsize[2], $position);
            }
        }
        // set Documet Type
        set_image_header($image_type);
        // we cache the random image
        if ($filename && $enable_random_image_caching && ($sizex != $thumb_pic_size)) {
            $result = store_image($dst, $filename, $image_type, $compression, false);
        }


        $result = store_image($dst, null, $image_type, $compression);
        if (!$result) {
            debug('cannot send: ' . $image);
        }
        return $result;
    } else
        return false;
}

/*
Generates the images for the random function
*/
function generaterandom($image, $size, $compression, $twg_rot, $dir, $filename)
{
    return generatefull($image, $size, $size, $compression, $twg_rot, $dir, $filename);
}


/*
TODO: not used anymore because of the new slideshow - if the new sildeshow works fine I'll remove this in the next build
*/
function generatetwg_slideshow($image, $small, $size, $compression, $small_cache, $twg_rot, $dir)
{
    global $small_pic_size;
    global $slideshow_backcolor_R;
    global $slideshow_backcolor_G;
    global $slideshow_backcolor_B;
    global $print_text;
    global $font;
    global $fontsize;
    global $text;
    global $textcolor_R;
    global $textcolor_G;
    global $textcolor_B;
    global $use_small_pic_size_as_height;
    global $resize_only_if_too_big;

    $resize = true;

    if (file_exists($small_cache)) {
        $image = $small_cache;
    } else {
        // we generate the small one first - is needed sometimes anyway :).
        if ($compression < 90) {
            $compression += 5;
        }
        // we check if the size is ok - if the image is too small ...
        $oldsize = getimagesize($image);
        if ($oldsize[0] == 0) {
            $oldsize = get_image_exif_size($image, $image);
        }
        $resize = (!((($small_pic_size >= $oldsize[0]) || $use_small_pic_size_as_height) && ($small_pic_size >= $oldsize[1]) && $resize_only_if_too_big));
        if ($resize) {
            generatesmall($image, $small_cache, $size, $compression, $twg_rot, $dir);
            $image = $small_cache;
        }
    }
    $maxwidth = ceil($small_pic_size * 1.35); // this is the maximum width we show !! the factor has to be changed in the twg_slide_typetwg_show as well!!
    if (file_exists($image) || substr($image, 4, 3) == "://") {
        $oldsize = getimagesize($image);
        if ($oldsize[0] == 0) {
            $oldsize = get_image_exif_size($image, $image);
        }
        if ($use_small_pic_size_as_height) {
            $pic_size_x = $maxwidth;
        } else {
            $pic_size_x = $small_pic_size;
        }
        $pic_size_y = $small_pic_size;
        if ($oldsize[0] > $oldsize[1]) { // querformat
            if ($use_small_pic_size_as_height) {
                if ($resize_only_if_too_big) {
                    if ($oldsize[0] <= $small_pic_size) {
                        $width = $oldsize[0];
                        $height = $oldsize[1];
                    } else {
                        if (($oldsize[0] / $oldsize[1]) <= 1.35) { // normal image where the width will fit into ou height!
                            $width = ($size / $oldsize[1]) * $oldsize[0];
                            $height = $size;
                        } else { // panorama
                            $width = $maxwidth;
                            $height = ($maxwidth / $oldsize[0]) * $oldsize[1];
                        }
                    }
                } else if (($oldsize[0] / $oldsize[1]) <= 1.35) { // normal image where the width will fit into ou height!
                    $width = ($size / $oldsize[1]) * $oldsize[0];
                    $height = $size;
                } else { // panorama
                    $width = $maxwidth;
                    $height = ($maxwidth / $oldsize[0]) * $oldsize[1];
                }
            } else if ($resize_only_if_too_big) {
                // we check if we have to resize at all!
                if (($oldsize[0] <= $small_pic_size) && ($oldsize[1] <= $small_pic_size)) {
                    $width = $oldsize[0];
                    $height = $oldsize[1];
                } else {
                    $width = $size;
                    $height = ($width / $oldsize[0]) * $oldsize[1];
                }
            } else {
                $width = $size;
                $height = ($width / $oldsize[0]) * $oldsize[1];
            }
        } else if ($resize_only_if_too_big) {
            // we check if we have to resize at all!
            if (($oldsize[0] <= $small_pic_size) && ($oldsize[1] <= $small_pic_size)) {
                $width = $oldsize[0];
                $height = $oldsize[1];
            } else {
                $height = $size;
                $width = ($height / $oldsize[1]) * $oldsize[0];
            }
        } else {
            $height = $size;
            $width = ($height / $oldsize[1]) * $oldsize[0];
        }

        $topleft_x = ($pic_size_x - $width) / 2;
        $topleft_y = ($pic_size_y - $height) / 2;

        $memory = ($oldsize[0] * $oldsize[1] * 6) + 2000000; // mem usage and we add 2MB for processing
        try_to_increase_mem($memory);

        $image_type = $oldsize[2];
        $src = loadImage($image, $image_type);
        $dst = ImageCreateTrueColor($pic_size_x, $pic_size_y);
        keepTransparency($image_type, $src, $dst, $pic_size_x, $pic_size_y);
        $near_white = imageColorClosest($dst, $slideshow_backcolor_R, $slideshow_backcolor_G, $slideshow_backcolor_B);
        imagefilledrectangle($dst, 0, 0, $pic_size_x, $pic_size_y, $near_white);
        imagecopyresampled($dst, $src, $topleft_x, $topleft_y, 0, 0, $width, $height, $oldsize[0], $oldsize[1]);
        imagedestroy($src);
        $near_black = imageColorClosest($dst, 0, 0, 0);
        imagerectangle($dst, $topleft_x, $topleft_y, $topleft_x + $width - 1, $topleft_y + $height - 1, $near_black);

        $fh = fopen($small, 'w');
        fclose($fh);

        return store_image($dst, $small, $image_type, $compression);
    } else
        return false;
}

// optimize the small ones as well !!
function replaceSonderzeichen25($name)
{
    // $name = str_replace("%25", "%", $name);
    // $name = str_replace("%2B", "+", $name);
    return $name;
}

function watermark($dst, $watermark, $width, $heigth, $info, $position)
{
    // Michael Müller, 05.03.2004 17:05, www.php4u.net
    // Positionen:
    // 1 oben links
    // 2 oben mittig
    // 3 oben rechts
    // 4 Mitte links
    // 5 Mitte
    // 6 Mitte rechts
    // 7 unten links
    // 8 unten mittig
    // 9 unten rechts
    // erlaubt sind png und jpeg
    global $transparency;
    global $t_x;
    global $t_y;
    global $install_dir;

    $watermark = $install_dir . $watermark;

    $infos_img[0] = $width;
    $infos_img[1] = $heigth;
    $infos_img[2] = $info;

    if ($position < 1 || $position > 9) {
        debug("Wrong position of the watermark - no watermark is rendered on the image!");
        return false;
    }
    if (!file_exists($watermark)) {
        debug("Watermark " . $watermark . " not found - no watermark is rendered on the image!");
        return false;
    }
    $infos_wat = getimagesize($watermark);
    if (!in_array($infos_img[2], array(1, 2, 3)) || !in_array($infos_wat[2], array(1, 2, 3))) {
        debug("Wrong type of the watermark  - no watermark is rendered on the image!");
        return false;
    }
    if ($infos_img[0] < $infos_wat[0] || $infos_img[1] < $infos_wat[1]) {
        debug("watermark is too big  - no watermark is rendered on the image!!");
        return false;
    }
    if ($infos_wat[0] < $t_x || $infos_wat[1] < $t_y) {
        debug("watermark is too big  - no watermark is rendered on the image!");
        return false;
    }
    $transparency = 100 - $transparency;
    if ($transparency < 0 || $transparency > 100) {
        debug("transparency is out of range - image is not created!");
        return false;
    }
    // Position x
    switch (($position - 1) % 3) {
        case 0:
            $pos_x = 0;
            break;
        case 1:
            $pos_x = round(($infos_img[0] - $infos_wat[0]) / 2, 0);
            break;
        case 2:
            $pos_x = $infos_img[0] - $infos_wat[0];
            break;
    }
    // Position y
    switch (floor(($position - 1) / 3)) {
        case 0:
            $pos_y = 0;
            break;
        case 1:
            $pos_y = round(($infos_img[1] - $infos_wat[1]) / 2, 0);
            break;
        case 2:
            $pos_y = $infos_img[1] - $infos_wat[1];
            break;
    }
    $img_image = $dst;

    $img_watermark = loadImage($watermark, $infos_wat[2]);
    imagealphablending($img_image, true);
    imagealphablending($img_watermark, true);
    if ($t_x != -1) {
        imagecolortransparent($img_watermark, imagecolorat($img_watermark, $t_x, $t_y));
    }
    if ($transparency == 100) {
       imagecopy($img_image, $img_watermark, $pos_x, $pos_y, 0, 0, $infos_wat[0], $infos_wat[1]);
    } else {
       imagecopymerge($img_image, $img_watermark, $pos_x, $pos_y, 0, 0, $infos_wat[0], $infos_wat[1], $transparency);
    }
    return $img_image;
}

function generatecounterimage($filename)
{
    global $comment_corner_size;
    global $cachedir;

    $counter_array = get_counter_data($filename); // returns 30 values (0 if none available!)
    $width = 138;
    $height = 70;

    $dst = ImageCreateTrueColor($width, $height);

    $white = imagecolorclosest($dst, 255, 255, 255);
    $bar_color1 = imagecolorclosest($dst, 140, 140, 140);
    $bar_color2 = imagecolorclosest($dst, 190, 190, 190);

    $linecolor = imagecolorclosest($dst, 0, 0, 0);

    imagefill($dst, 0, 0, imagecolortransparent($dst, $white));
    // draw the lines :)
    $maxvalue = 1;
    $max_height = 58;
    imageline($dst, 3, 67, 132, 67, $linecolor);
    imageline($dst, 5, 5, 5, 70, $linecolor);
    imageline($dst, 3, 67 - $max_height, 7, 67 - $max_height, $linecolor);

    $counter_length = count($counter_array);
    for ($i = 0; $i < $counter_length; $i++) {
        $y = $counter_array[$i];
        if ($y > $maxvalue) {
            $maxvalue = $y;
        }
    }
    imagestring($dst, 1, 8, 0, $maxvalue, $linecolor);

    $factor = ($max_height - 3) / $maxvalue;
    $x = 8;

    $tag_counter = date("w") + 4;
    // echo "<ul>";
    for ($i = 0; $i < $counter_length; $i++) {
        if ($counter_array[$i] > -1) {
            $y = floor(64 - ($counter_array[$i] * $factor));
            imagefilledrectangle($dst, $x, $y, $x + 1, 64, $bar_color2);
            imagefilledrectangle($dst, $x + 2, $y, $x + 2, 64, $bar_color1);
        }
        if (($tag_counter++ % 7) == 0) {
            imageline($dst, $x - 1, 66, $x - 1, 68, $linecolor);
        }
        $x += 4;
    }
    // set Documet Type
    $fh = fopen($cachedir . "/counter.png", 'w'); // fix for a but in some php - versions - thanks to Anders
    fclose($fh);
    header("Content-type: image/png");
    if (imagepng($dst, $cachedir . "/counter.png")) {
        imagedestroy($dst);
        return true;
    } else {
        debug('cannot return');
        return false;
    }
}

function getimagesize_remote($image_url)
{
    $handle = fopen($image_url, "rb");
    $contents = "";
    if ($handle) {
        do {
            $count += 1;
            $data = fread($handle, 8192);
            if (strlen($data) == 0) {
                break;
            }
            $contents .= $data;
        } while (true);
    } else {
        return false;
    }
    fclose($handle);

    $im = ImageCreateFromString($contents);
    if (!$im) {
        return false;
    }
    $gis[0] = ImageSX($im);
    $gis[1] = ImageSY($im);
    // array member 3 is used below to keep with current getimagesize standards
    $gis[3] = "width={$gis[0]} height={$gis[1]}";
    ImageDestroy($im);
    return $gis;
}

function getRotation($twg_album, $image, $image_full)
{
    global $login_edit, $twg_rot_available;

    $twg_rot_available = checktwg_rot();
    if ($twg_rot_available) {
        $rot = get_rot_file_name($twg_album, $image);
        if (file_exists($rot)) {
            $twg_rot = read_rot($rot);
            return $twg_rot;
        } else {
            return process_image_exif_rotation($image_full, $rot);
        }
    } else {
        return 0;
    }
}

function loadImage($image, $image_type)
{ // image needs ~ twice the memory of the image!
    set_error_handler("on_error_no_output");
    if ($image_type == 3) { // PNG
        $src = @imagecreatefrompng(http_encode($image));
    } else if ($image_type == 1) {
        $src = @imagecreatefromgif(http_encode($image));
    } else if ($image_type == 2) { // valid jpeg
        $src = @imagecreatefromjpeg(http_encode($image));
    } else { // invalid jpeg
        $src = @imagecreatefromjpeg(http_encode($image)); // we try to open an invalid file!
    }
    set_error_handler("on_error");
    if (!$src) {
        debug('\'' . $image . '\' could not loaded properly. Please check if the file is corrupt.');
    }
    return $src;
}

function set_image_header($image_type)
{
    if ($image_type == 3) { // PNG
        header("Content-type: image/png");
    } else if ($image_type == 1) {
        header("Content-type: image/gif");
    } else {
        header("Content-type: image/jpeg");
    }
}

function store_image($im, $name, $image_type, $compression, $close = true)
{
    if ($image_type == 3) { // PNG
        if ($name != '') {
            $result = imagepng($im, $name);
        } else {
            $result = imagepng($im);
        }
    } else if ($image_type == 1) { // GIF
        if ($name != '') {
            $result = imagegif($im, $name);
        } else {
            $result = imagegif($im);
        }
    } else {
        $result = imagejpeg($im, $name, $compression);
    }
    if ($result && $close) {
        close_image($im);
    }
    return $result;
}

function close_image($im)
{
    imagedestroy($im);
}

/*
  true - image is moved; false - image stays make error image!
*/
function move_problem_image($image)
{
    global $move_error_images;
    if ($move_error_images != "") {
        $error_imagename = $move_error_images . "/" . basename($image);
        return rename($image, $error_imagename);
    } else {
        return false;
    }
}

function keepTransparency($image_type, &$src, &$dst, $width, $height)
{
    global $support_transparent_gif;

    if ($image_type == 3) { // PNG - support with transparency
        imagealphablending($dst, false);
        imageSaveAlpha($dst, true);
    }

    if ($image_type == 1) { // GIF - support with transparency
        if ($support_transparent_gif) {
          $dst = ImageCreate($width, $height);
        } else {
          $dst = ImageCreatetruecolor($width, $height);
        }
        
        $colorTransparent = imagecolortransparent($src);
        imagepalettecopy($dst, $src);
        imagefill($dst, 0, 0, $colorTransparent);
        imagecolortransparent($dst, $colorTransparent);
    }
}


function try_to_increase_mem($memory)
{
    if (function_exists("memory_get_usage")) {
        $InUse = memory_get_usage();
        if ($memory > (return_kbytes(ini_get('memory_limit')) * 1024) - $InUse) {
            @ini_set('memory_limit', $memory + $InUse + 3000000); // 3 MB saftey
        }
    }
}

?>