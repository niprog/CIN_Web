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

if ($responsive_detail_page) {
    echo '<style> img#defaultslide { max-width: 100%;height: auto;width: 100%; }</style>';   
}

echo '<center id="center-image-inc">';
$imagetext = hasImagepageDescription($basedir . "/" . $twg_album);

if ($activate_lightbox_image && !$default_is_fullscreen) {
    $open_in_maximized_view = false;
}

if ($login_edit && file_exists($install_dir . 'addons/photonotes/twg_addon.php')) {
    $enable_download = false;
}

if ($twg_slideshow == false) {
    if (!$default_is_fullscreen) {
        if ($twg_album && $show_album_name_on_detail_page) { // !1st level
            $path = ($twg_album) ? $basedir . "/" . $twg_album : $basedir;
            $temp1 = explode("/", $twg_album);
            $titel = array_pop($temp1);
            $titel = getDirectoryName($path, $titel);
            printf("<span class='twg_title'>%s</span><br>", $titel);
        }
        if ($enable_dir_description_on_image) {
            $foldertext = getDirectoryDescription($basedir . "/" . $twg_album);
            if ($foldertext) {
                echo '<img height=1 width=1 alt=""  src="' . $install_dir_view . 'buttons/1x1.gif" ><br>';
                echo "<div class='twg_folderdescription'>" . $foldertext . "</div><br>";
            }
        }
        if ($imagetext && $image_txt_position == "top") {
            echo '<img height=1 width=1 alt=""  src="' . $install_dir_view . 'buttons/1x1.gif" ><br>';
            echo "<div id='image_top' class='twg_folderdescription'>";
            includeImagepageDescription($basedir . "/" . $twg_album);
            echo "</div><br>";
        }
    }
    $beschreibung = getBeschreibung($image, $werte, $index);
    $beschreibungalt = "alt='' ";
    if (($beschreibung <> " ") && ($beschreibung <> "")) {
        $altbeschreibung = "title='" . escapeHochkomma($beschreibung) . "'";
        $altbeschreibung .= " alt='" . escapeHochkomma($beschreibung) . "'";
        echo '<script type="text/javascript">document.title = "' . $browser_title_prefix . ' - ' . removeTitleChars($beschreibung) . '";</script>';
    }


    if (!$default_is_fullscreen) {
        if (($image_rating_position == 'over_image') && $show_image_rating) {
            include dirname(__FILE__) . "/rating.inc.php";
        }

        // fix for mp3 player because it has to initialized before the big navigation!
        if ($video_player == "MP3") {
            createMp3Xml($cachedir . "/audiolist.xml", $twg_album, $image, "");
            if ($video_autostart) {
                $playerjs = $install_dir_view . "html/twg_player.swf?twg_autoplay=true&twg_playlist_path=" . $install_dir_view;
                $player = $install_dir_view . "html/twg_player.swf?twg_autoplay=true&amp;twg_playlist_path=" . $install_dir_view;
            } else {
                $playerjs = $install_dir_view . "html/twg_player.swf?twg_autoplay=false&twg_playlist_path=" . $install_dir_view;
                $player = $install_dir_view . "html/twg_player.swf?twg_autoplay=false&amp;twg_playlist_path=" . $install_dir_view;
            }
            if ($loop_mp3) {
                $playerjs .= "&twg_loop=true";
                $player .= "&amp;twg_loop=true";
            } else {
                $playerjs .= "&twg_loop=false";
                $player .= "&amp;twg_loop=false";
            }
        }
        // end of mp3 fix!

        if (!$top10 && $default_big_navigation != "HTML_SIDE" && $big_nav_pos == "top") {
            print_big_navigation($twg_album, $album_enc, $image, $twg_rot, $current_id, $thumb_pic_size, $kwerte, $kindex, $dir);
            echo "<br>";
        }

        if ($default_big_navigation == "HTML_SIDE" && !$top10) {
            echo "<table class='sidenavleft' cellspacing=0 cellpadding=0 summary=''><tr><td><div class='sidenavleft'><table class='sidenavleft' cellspacing=0 cellpadding=0 summary=''><tr>";
            print_next_last_pics($twg_album, $image, $thumb_pic_size, "left");
            echo "</tr></table></div></td><td class='sidenavmiddle'>";
        } else if ($imagetext && $image_txt_position == "side") {
            echo "<table cellspacing=0 cellpadding=0 summary=''><tr><td><table class='sidenavleft' cellspacing=0 cellpadding=0 summary=''><tr><td id='image_left'>";
            includeImagepageDescription($basedir . "/" . $twg_album);
            echo "</td></tr></table></td><td class='sidenavmiddle'>";
        }
    }
    $linkfilename = $basedir . "/" . $twg_album . "/link.txt";
    $videofolder = false;
    // we enable or disable the download of images or link to a location!
    if (file_exists($linkfilename)) { // link file exists !!!
        $dateilink = fopen($linkfilename, "r");
        $download1 = trim(fgets($dateilink, filesize($linkfilename) + 1));
        $download2 = "</a>";
        fclose($dateilink);
    } else if ($enable_download) {
        if ($open_download_in_new_window && !$video_dir) {
            $target = " target='_blank' ";
        } else {
            $target = "";
        }

        $zip_found = false;
        if ($enable_download_as_zip) {
            $zipfile = $basedir . "/" . $twg_album . "/" . str_replace("/", "_", $twg_album) . ".zip";
            $zipfile2 = $basedir . "/" . $twg_album . "/" . str_replace("/", "_", $twg_album) . ".txt";
            if ((file_exists($zipfile) || file_exists($zipfile2)) && $twg_download != 'single') { // && $twg_download != 'single') { // hard for dhtml !
                $target = "";
                $download1 = "<a class='twg_fullscreen' id='adefaultslide' onclick='return twg_showSec(" . $lang_height_dl_manager . ")' target='details' href='" . $install_dir_view . "i_frames/i_downloadmanager.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>";
                $download2 = "</a>";
                $zip_found = true;
            }
        }
        $other = false;
        if (!$zip_found) {

            $other_format = removeExtension( $basedir . "/" . $twg_album . "/" . urldecode($image));
            if (file_exists($other_format)) { // check for 123.swf.jpg -> 123.swf
                $other_format = twg_urlencode($other_format);
                $download1 = '<a class="twg_fullscreen" id="adefaultslide" ' . $target . ' href="' . $install_dir_view. $other_format . '">';
                $download2 = "</a>";
                $other = true;
            } else {
                foreach ($other_file_formats as $label => $key) {
                    $other_format = exchangeExtension($basedir . "/" . $twg_album . "/" . urldecode($image), $label);
                    if (file_exists($other_format)) {
                        if (filesize($other_format) > 0) {
                            $other_format = twg_urlencode($other_format);
                            $download1 = '<a class="twg_fullscreen" id="adefaultslide" ' . $target . ' href="' . $install_dir_view.$other_format . '">';
                            $download2 = "</a>";
                            $other = true;
                        } else if ($video_flash_site != "" && $video_player == "MP3") {
                            $other_format = $video_flash_site . removePrefix(exchangeExtension(urldecode($image), "mp3"));
                            $download1 = '<a class="twg_fullscreen" id="adefaultslide" ' . $target . ' href="' . $other_format . '">';
                            $download2 = "</a>";
                            $other = true;
                        }
                        break;
                    }
                }
            }
            if ($video_flash_site != "" && $video_player == "MP3") {
                $other_format = $video_flash_site . removePrefix(exchangeExtension(urldecode($image), "mp3"));
                $download1 = '<a class="twg_fullscreen" id="adefaultslide" ' . $target . ' href="' . $other_format . '">';
                $download2 = "</a>";
                $other = true;
            }

            if ($video_flash_site == "http://" && $video_player == "WMP") {
                $embedstring = $video_flash_site . urldecode(removeExtension(replace_url_chars(urldecode($image))));
                $download1 = '<a class="twg_fullscreen" id="adefaultslide" ' . $target . ' href="' . $other_format . '">';
                $download2 = "</a>";
                $other = true;
            }

            if ($other) {
                // everything already done
            } else if ($enable_direct_download) {

                $remote_image = twg_checkurl($basedir . "/" . $twg_album);
                if ($remote_image) {
                    $image_full = getRemoteImagePath($remote_image, $image);
                } else {
                    if ($twg_album) {
                        $image_full = $basedir . "/" . $twg_album . "/" . urldecode($image);
                    } else {
                        $image_full = $basedir . "/" . urldecode($image);
                    }
                    $image_full = twg_urlencode($image_full);
                }
                $image_full = getTWGHttpRoot($install_dir) . $image_full;

                // TODO: duplicate block see else - refactor if time!
                $onclick = "";
                if ($open_as_popup) {
                    $onclick = " onclick='javascript:return openImage(\"" . $install_dir . "\");' ";
                }
                if ($activate_lightbox_image && !$default_is_fullscreen && !$use_lytebox) {
                    $lb_image = " rel='lightbox' ";
                    if ($show_captions) {
                        $lb_image .= " title='" . replacesmilies(php_to_all_html_chars($beschreibung, false)) . "'";
                    }
                } else {
                    if ($activate_lightbox_image && $use_lytebox) {
                        // onclick is overwritten again!
                        $onclick = " onclick='return startLytebox(" . get_image_number($twg_album, $image) . ");' ";
                    }
                    $lb_image = "";
                }
                // end duplicate

                $download1 = '<a class="twg_fullscreen" ' . $onclick . ' ' . $lb_image . ' id="adefaultslide" ' . $target . ' href="' . $image_full . '">';
                $download2 = "</a>";
            } else {

                if ($open_in_maximized_view && !$default_is_fullscreen) {
                    $href = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $image_enc . '&amp;&twg_zoom=TRUE';
                    $open_as_popup = false;
                    $target = "";
                } else {
                    $href = getTWGHttpRoot($install_dir) . 'image.php?twg_album=' . $album_enc . '&amp;twg_show=' . $image_enc;
                    $hrefjs = getTWGHttpRoot($install_dir) . 'image.php?twg_album=' . $album_enc . '&twg_show=' . $image;
                }

                // TODO: duplicate block see else - refactor if time!
                $onclick = "";
                if ($open_as_popup) {
                    $onclick = " onclick='javascript:return openImage(\"" . $install_dir . "\");' ";
                }
                if ($activate_lightbox_image && !$default_is_fullscreen && !$use_lytebox) {
                    $lb_image = " rel='lightbox' ";
                    if ($show_captions) {
                        $lb_image .= " title='" . replacesmilies(php_to_all_html_chars($beschreibung, false)) . "'";
                    }
                } else {
                    if ($activate_lightbox_image && $use_lytebox) {
                        // onclick is overwritten again!
                        $onclick = " onclick='return startLytebox(" . get_image_number($twg_album, $image) . ");' ";
                    }
                    $lb_image = "";
                }
                // end duplicate
                $download1 = '<a ' . $lb_image . ' class="twg_fullscreen" ' . $onclick . ' id="adefaultslide" ' . $target . ' href="' . $href . '">';
                $download2 = "</a>";
            }
        }
    } else {
        $download1 = "";
        $download2 = "";
    }

    if ($default_is_fullscreen) {
        $type = "fullscreen";
    } else {
        $type = "small";
    }

    if ($center_cmotiongal_over_image && !$show_thumbs_as_text) {
        $jscenter = " onMouseOver='if (window.centerGalLater) centerGalLater();' ";
    } else {
        $jscenter = "";
    }

    if ($use_small_pic_size_as_height) { // fast way to get the height
        if ($responsive_detail_page) {
            $tdheight = '';
        } else if ($enable_drop_shadow) {
            $tdheight = "style='height:" . ($small_pic_size + 24) . "px;' ";
        } else {
            $tdheight = "style='height:" . ($small_pic_size + 6) . "px;' ";
        }
    } else {
        $aktimage = replace_valid_url($image);
        $thumbimage = create_thumb_image($twg_album, $aktimage);
        $small = create_cache_file($thumbimage, $extension_small);

        if ($default_big_navigation != "DHTML" && $default_big_navigation != "FLASH" && (file_exists($small) || $disable_direct_thumbs_access)) {
            // get size ....
            $smallsize = getimagesize($small);
            $pic_size_y = $smallsize[1];
            if ($enable_drop_shadow) {
                $tdheight = "style='height:" . ($pic_size_y + 24) . "px;' ";
            } else {
                $tdheight = "style='height:" . ($pic_size_y + 6) . "px;' ";
            }
        } else if ($show_captions) {
            $tdheight = "style='padding-bottom:5px;'";
        } else {
            $tdheight = '';
        }
    }

    if (!$default_is_fullscreen) {
        if ($video_dir && (!$mixed_video_image_content || ($mixed_video_image_content && hasVideoPrefix($image)))) {
            // if ($iswindows || $isMac || $video_player == "FLASH" || $video_player == "MP3" || $video_player == "GOOGLE") {
            include dirname(__FILE__) . "/videostreaming.inc.php";
            // }
        } else {
            if ($wii && $show_wii_buttons) {
                $wiiback = "<td class='align_left'><img id='wiibackbutton' class='wiibuttons align_left' onclick='key_back();' src='buttons/big_back.png'></td>";
                $wiivor = "<td  class='align_right'><img id='wiinextbutton' class='wiibuttons align_right' onclick='key_foreward();' src='buttons/big_forward.png'></td>";
            } else {
                $wiivor = "";
                $wiiback = "";
            }

            $image_src = $install_dir_view . 'image.php?twg_album=' . $album_enc . '&amp;twg_type=' . $type . '&amp;twg_show=' . $image_enc . '&amp;twg_rot=' . $twg_rot;

            if ($twg_rot == -1) {
                $image_src = opimizeSmallLink($image_src);
            }     
    
            if ($enable_drop_shadow) {
                printf("<table class='twg widthwii' summary='' border=0 cellpadding='0' cellspacing='0'><tr>%s<td %s class=twg><div class='twg_img-shadow' align='center'><table class='twg' summary='' border=1 cellpadding='0' cellspacing='4'><tr><td class=twg><div id='imagediv'>%s<img class='twg_imageview' id=defaultslide src='%s' %s %s >%s</div></td></tr></table></div></td>%s</tr></table>", $wiiback, $tdheight, $download1, $image_src, $beschreibungalt, $jscenter, $download2, $wiivor);
            } else {
                printf("<table class='twg widthwii' summary='' border=0 cellpadding='3' cellspacing='0'><tr>%s<td %s class=twg><div id='imagediv'>%s<img class='twg_imageview' id=defaultslide src='%s' %s %s >%s</div></td>%s</tr></table>", $wiiback, $tdheight, $download1, $image_src, $beschreibungalt, $jscenter, $download2, $wiivor);
            }
        }
        if ($default_big_navigation == "HTML_SIDE" && !$top10) {
            echo "</td><td><table class='sidenavright' cellspacing=0 cellpadding=0 summary=''><tr>";
            print_next_last_pics($twg_album, $image, $thumb_pic_size, "right");
            echo "</tr></table></td></tr></table>";
        } else if ($imagetext && $image_txt_position == "side") {
            echo "</td><td><table class='sidenavright' cellspacing=0 cellpadding=0 summary=''><tr><td id='image_right'>";
            includeImagepageDescription2($basedir . "/" . $twg_album);
            echo "</td></tr></table></td></tr></table>";
        }
        
        if ($responsive_detail_page) {
         $motion_width = ((($numberofpics * 2) + 1) * ($strip_thumb_pic_size + 5)) + 50;
         echo '<style>
         @media only screen and (max-width: '.($motion_width+40).'px) {
           .twg_nav { display: none; }
           .twg_folderdescription, .topnavright { display: none; } 
         }
         @media only screen and (max-width: '.($motion_width+400).'px) {
           .twg_folderdescription { padding-right: 20px; padding-left: 20px; }   
         }
         @media only screen and (max-width: '.($motion_width+150).'px) {
           #ccw, #cw { display: none; }
           .sidenavleft, .sidenavright { display: none; }   
         }
         </style>';
        }

        if ($imagetext && $image_txt_position == "image") {
            echo "<div id='image_bottom' class='twg_folderdescription'>";
            includeImagepageDescription($basedir . "/" . $twg_album);
            echo "</div>";
        }
        if ($show_captions) {
            echo '<div class="twg_Caption" id=CaptionBox>&nbsp;' . replacesmilies(php_to_all_html_chars($beschreibung, false)) . '&nbsp;</div>';
        }
    } else {   
        printf("<table class='twg' summary='' border=0 cellpadding='0' cellspacing='0'><tr><td onmousemove='javascript:setTimer(10);show_control_div();'>%s<img id=defaultslide src='%simage.php?twg_album=%s&amp;twg_show=%s&amp;twg_type=%s&amp;twg_rot=%s' %s %s >%s</td></tr></table>", $download1, $install_dir_view, $album_enc, $image_enc, $type, $twg_rot, $beschreibungalt, $jscenter, $download2);
    }
} else {
    $heightaddon = 20;
    if ($show_captions) {
        $heightaddon += 30;
    }
    
    if ($responsive_detail_page && $responsive_detail_page_full_slideshow) {
       $twg_slide_type == 'FULL';   
    }
    
    if ($twg_slide_type == 'TRUE') {
        if ($use_small_pic_size_as_height) {
            $width_ie = ceil($small_pic_size * $image_factor) + 24; // support borders up to 10px
        } else {
            $width_ie = $small_pic_size + 24; // support borders up to 10px
        }
        if ($width_ie > $browserx - 50 + $iframe_slideshow_fix) {
            $width_ie = $browserx - 50 + $iframe_slideshow_fix;
        }
        echo "<iframe id='slideframe'  allowtransparency='true' name='slideframe' src='" . $install_dir_view . "i_frames/i_slideshowjquery.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image . $twg_standalone . "' width='" . ($width_ie + $iframe_slideshow_fix) . "' height='" . ($small_pic_size + $heightaddon) . "' marginwidth='0' marginheight='0'  frameborder='0' scrolling='no' style='position: relative; visibility: hidden;' onload=\"jQuery('#slideframe').delay( 100 ).css('visibility','visible');\"></iframe>";
    } else if ($twg_slide_type == 'FALSE') {
        $width_ie = (($small_pic_size * 1.5) + 24); // support borders up to 10px

        if ($width_ie > $browserx) {
            $width_ie = $browserx;
            if ($msie) {
                $width_ie -= 50;
            }
        }
        echo "<iframe id='slideframe' allowtransparency='true' name='slideframe' src='" . $install_dir_view . "i_frames/i_slideshow.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image . $twg_standalone . "' width='" . ($width_ie + $iframe_slideshow_fix) . "' height='" . ($small_pic_size + $heightaddon) . "' marginwidth='0' marginheight='0'  frameborder='0' scrolling='no' style='position: relative; visibility: hidden;' onload=\"jQuery('#slideframe').delay( 100 ).css('visibility','visible');\"></iframe>";
    } else {
        echo "<iframe id='slideframe' allowtransparency='true' name='slideframe' src='" . $install_dir_view . "i_frames/i_slideshowjquery.php?twg_max=true&twg_album=" . $album_enc . "&amp;twg_show=" . $image . $twg_standalone . "' width='" . ($browserx + $iframe_slideshow_fix) . "' height='" . ($browsery) . "' marginwidth='0' marginheight='0'  frameborder='0' scrolling='no' style='position: relative; visibility: hidden;' onload=\"jQuery('#slideframe').delay( 100 ).css('visibility','visible');\"></iframe>";
        $show_tips_image = false;
    }
    
    if ($responsive_detail_page) {
         echo '<style>
         @media only screen and (max-width: 400px) {
           .topnavright { display: none; }  
         }
         </style>';
        }
    
    
    
}
if ($imagetext && $image_txt_position == "bottom") {
    echo '<img height=1 width=1 alt=""  src="' . $install_dir_view . 'buttons/1x1.gif" ><br>';
    echo "<div id='image_bottom' class='twg_folderdescription'>";
    includeImagepageDescription($basedir . "/" . $twg_album);
    echo "</div><br>";
}
echo '</center>'; // end image view
?>