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
 
$Date: 2009-06-17 22:57:10 +0200 (Mi                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            , 17 Jun 2009) $
$Revision: 73 $
 **********************************************/

defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');
// the div setting are dynamic ;). - therefore can't be done in the stylesheet !
require (dirname(__FILE__) . "/showfolders.inc.php");
require (dirname(__FILE__) . "/printtop10.inc.php");
require (dirname(__FILE__) . "/cmotiongallery.inc.php");
require (dirname(__FILE__) . "/fullscreencontrol.inc.php");
require (dirname(__FILE__) . "/imagefunctions.inc.php");

function print_big_navigation($twg_album, $album_enc, $image, $twg_rot, $current_id, $thumb_pic_size, $kwerte, $kindex, $dir)
{
    global $lang_comments, $lang_height_comment, $lang_twg_rot_left, $lang_twg_rot_right, $lang_back, $lang_forward;
    global $twg_rot_available, $top10, $show_big_left_right_buttons, $twg_showprivatelogin, $twg_smallnav;
    global $show_comments, $default_big_navigation, $small_pic_size, $install_dir, $twg_standalone, $basedir;
    global $login_edit, $twg_standalonejs, $show_rotation_buttons, $default_is_fullscreen, $use_nonscrolling_dhtml;
    global $show_clipped_images, $strip_thumb_pic_size, $use_nonscrolling_dhtml, $numberofpics, $autodetect_noscoll;
    global $icon_set, $install_dir_view;

    $nextimage = "";

    if ($show_clipped_images) {
        $thumb_pic_size = $strip_thumb_pic_size;
    }

    $show_left_right_js = ($autodetect_noscoll || $use_nonscrolling_dhtml) && (get_image_count($twg_album) > (($numberofpics * 2) + 1));
    if ($twg_smallnav == 'FALSE') {
        if ($twg_rot == -1) {
            if ($login_edit) {
                $twg_rot = get_rotation_index($twg_album, $image); // gets the actual rotation
            } else {
                $twg_rot = 0;
            }
        }
        $ccw = (($twg_rot - 90) >= 0) ? ($twg_rot - 90) : (270);
        $cw = $twg_rot + 90;

        print "<table summary='' class='twg_nav'><tr>";
        if ($last = get_last($twg_album, $image, $current_id)) {
            $back_a_href =  tfu_seo_rewrite_url(getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $last);
            $back_a = '<a href="' . $back_a_href . $twg_standalone . '"><img class="twg_buttons back_gif" src="' . $install_dir_view . 'buttons/1x1.gif" alt="' . $lang_back . '" title="' . $lang_back . '" id="back"></a>';
            if ($show_big_left_right_buttons) {
                if ($default_big_navigation == "HTML") {
                    echo '<td id="twg_backbutton">' . $back_a . '</td>' . "\n";
                } else if ($use_nonscrolling_dhtml && $show_left_right_js) {
                    $back_a = '<a onclick="showLast(); return false;"  href="#"><img class="twg_buttons back_gif" src="' . $install_dir_view . 'buttons/1x1.gif" alt="' . $lang_back . '" title="' . $lang_back . '" id="back"></a>';
                    echo '<td id="twg_backbutton"><span id="backbuttonbig">' . $back_a . '<span></td>' . "\n";
                }
            }
        } else if ($use_nonscrolling_dhtml && $show_left_right_js && ($default_big_navigation == "DHTML" || $default_big_navigation == "FLASH") && $show_big_left_right_buttons) {
            $back_a = '<a onclick="showLast(); return false;"  href="#"><img class="twg_buttons back_gif" src="' . $install_dir_view . 'buttons/1x1.gif" alt="' . $lang_back . '" title="' . $lang_back . '" id="back"></a>';
            echo '<td><span style="visibility: hidden;"" id="backbuttonbig">' . $back_a . '<span></td>', "\n";
        }

        $timestamp = "&amp;twg_zs=" . time();
        if ((gd_version() >= 2) && ($twg_rot_available) && $show_rotation_buttons) {
            $url = getScriptName() . '?twg_album='. $album_enc . '&amp;twg_show='.$image.'&amp;twg_rot=' . $ccw . $twg_standalone . $timestamp;             
            printf("<td><a id='twg_rotleft' rel='noindex,nofollow' href='%s'><img class=' twg_buttons iuzs_normal_gif' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='cw' width='64' height='64' ></a></td>\n", tfu_seo_rewrite_url($url) , $install_dir_view, $lang_twg_rot_left, $lang_twg_rot_left);
        }

        if ($default_big_navigation == "HTML") {
            $nextimage = print_next_last_pics($twg_album, $image, $thumb_pic_size);
        } else {
            echo '<td class=twg>';
            print_cmotion_gallery($twg_album, $image, $thumb_pic_size, $dir);
            echo '</td>';
        }

        if ((gd_version() >= 2) && ($twg_rot_available) && $show_rotation_buttons) {
            $url = getScriptName() . '?twg_album='. $album_enc . '&amp;twg_show='.$image.'&amp;twg_rot=' . $ccw . $twg_standalone . $timestamp; 
            
            printf("<td><a id='twg_rotright' rel='noindex,nofollow' href='%s'><img class='twg_buttons guzs_normal_gif' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='ccw' width='64' height='64' ></a></td>\n", tfu_seo_rewrite_url($url) , $install_dir_view, $lang_twg_rot_right, $lang_twg_rot_right);
        }

        if ($next = get_next($twg_album, $image, $current_id)) {
            $next_a_href =  getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $next . $twg_standalone;
            $next_a = '<a href="' . tfu_seo_rewrite_url($next_a_href) . '"><img class="twg_buttons next_gif" src="' . $install_dir_view . 'buttons/1x1.gif" alt="' . $lang_forward . '" title="' . $lang_forward . '" id="next"></a>';
            if ($show_big_left_right_buttons) {
                if ($default_big_navigation == "HTML") {
                    echo '<td id="twg_nextbutton">' . $next_a . '</td>' . "\n";
                } else if ($use_nonscrolling_dhtml && $show_left_right_js) {
                    $next_a = '<a onclick="showNext(); return false;" href=""><img class="twg_buttons next_gif" src="' . $install_dir_view . 'buttons/1x1.gif" alt="' . $lang_forward . '" title="' . $lang_forward . '" id="next"></a>';
                    echo '<td id="twg_nextbutton"><span id="nextbuttonbig">' . $next_a . '</a><span></td>' . "\n";
                }
            }
        } else if ($use_nonscrolling_dhtml && $show_left_right_js && $default_big_navigation == "DHTML" && $show_big_left_right_buttons) {
            $next_a = '<a onclick="showNext(); return false;" href=""><img class="twg_buttons next_gif" src="' . $install_dir_view . 'buttons/1x1.gif" alt="' . $lang_forward . '" title="' . $lang_forward . '" id="next"></a>';
            echo '<td><span style="visibility: hidden;" id="nextbuttonbig">' . $next_a . '</a><span></td>' . "\n";
        }
        print "</tr></table>";
    } else {

        // we don't show the dhtml but we generate all the javascript to support ajax mode!
        if ($default_big_navigation == "DHTML" || $default_big_navigation == "FLASH") {
            print_cmotion_gallery($twg_album, $image, $thumb_pic_size, $dir, false);
        }
        if ($default_is_fullscreen) {
            $type = "full";
        } else {
            $type = "small";
        }
        $next_i = get_next($twg_album, $image, $current_id);
        $nextimage = $install_dir_view . 'image.php?twg_album=' . $album_enc . '&twg_type=' . $type . '&twg_show=' . $next_i . '&twg_rot=' . $twg_rot;
    }
    // is extracted to be w3c conform!
    if ($nextimage <> "") {
        echo "<script type='text/javascript'>MM_preloadImages('" . $nextimage . "') </script>";
    }
}

function print_next_last_pics($twg_album, $entry, $thumb_pic_size, $side = "bottom")
{
    global $numberofpics, $kwerte, $kindex, $werte, $index, $extension_thumb;
    global $extension_small, $html_side_show_dividor, $install_dir, $twg_standalone, $twg_standalonejs;
    global $html_side_break, $html_side_space_optimization, $disable_direct_thumbs_access;
    global $show_clipped_images, $strip_thumb_pic_size, $show_html_side_left_only, $charset;
    global $twg_seo_active, $install_dir_view;

    $nextimage = "";

    $imagelist = get_image_list($twg_album);
    $act_nr = get_image_number($twg_album, $entry);
    $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
    $current = $act_nr;
    $total_num = count($imagelist);
    $htmlsize = "";
    if ($show_clipped_images) {
        $thumb_pic_size = $strip_thumb_pic_size;
        $htmlsize = " width=" . $strip_thumb_pic_size . " height=" . $strip_thumb_pic_size . " ";
    }

    $needDividor = false;
    $offsetleft = 0;
    $offsetright = 0;
    if ($side == "left") {
        if (($act_nr < $numberofpics) && $html_side_space_optimization) {
            $offsetleft = +$numberofpics - $act_nr;
            $offsetright = -$act_nr;
            $needDividor = true;
        } else if (($act_nr >= ($total_num - $numberofpics)) && $html_side_space_optimization) {
            $offsetleft = $total_num - $numberofpics - $act_nr - 1;
            $offsetright = $total_num - $act_nr - (2 * $numberofpics) - 2;
            $needDividor = true;
        } else {
            $offsetright = -$numberofpics - 1;
        }
    }
    if ($side == "right") {
        if (($act_nr < $numberofpics) && $html_side_space_optimization) { // we show some images already on the left side !
            $offsetleft = +$numberofpics + 1 + $numberofpics - $act_nr;
            $offsetright = $numberofpics - $act_nr;
            $needDividor = true;
        } else if (($act_nr >= ($total_num - $numberofpics)) && $html_side_space_optimization) {
            // echo "drüberrechts";
            $offsetleft = $total_num - $act_nr - 1;
            $offsetright = $total_num - $act_nr - ($numberofpics) - 1;
            $needDividor = true;
        } else {
            $offsetleft = +$numberofpics + 1;
        }
    }

    $printed = 0;

    $from = $current - $numberofpics + $offsetleft;
    $to = $current + $numberofpics + $offsetright;
    // 8 pictures fix!
    if ($side == "left" && $total_num == (2 * $numberofpics)) {
        $from = 0;
        $to = $numberofpics - 1;
    }
    if ($side == "right" && $total_num == (2 * $numberofpics)) {
        $from = $numberofpics;
        $to = (2 * $numberofpics) - 1;
    }
    // left only ;).
    if ($show_html_side_left_only && $side == "left") {
        $from = 0;
        $to = $numberofpics * 2;
        $needDividor = false;
    } else if ($show_html_side_left_only && $side == "right") {
        $from = $numberofpics + 1;
        $to = $numberofpics;
        $needDividor = false;
    }

    for ($i = $from; $i <= $to; $i++) {
        // echo "i:" . $i;
        if ($i < 0 || $i >= count($imagelist)) {
            printf("<td class='navicon' style='width:%spx; height:5px;'><img src='%sbuttons/1x1.gif' alt='' ></td>\n", $thumb_pic_size, $install_dir_view);
        } else {
            $aktimage = replace_valid_url($imagelist[$i]);
            $thumbimage = create_thumb_image($twg_album, $aktimage);
            $thumb = create_cache_file($thumbimage, $extension_thumb);
            // todo: check small cache!
            if (!file_exists($thumb) || $disable_direct_thumbs_access) {
                $src_value = $install_dir_view . "image.php?twg_album=" . $album_enc . "&amp;twg_type=thumb&amp;twg_show=" . $imagelist[$i];
                // echo $src_value . "<br>";
                $ccount = getKommentarCount($aktimage, $twg_album, $kwerte, $kindex);
                if ($ccount > 0) {
                    $src_value .= "&amp;twg_comment=" . $ccount; // this is done to cut of the upper right corner to indicate a comment!
                }
            } else {
                $src_value = create_cache_file(cacheencode($thumbimage), $extension_thumb, true, $twg_seo_active);
            }
            if (($i == $current) && ($side == "bottom")) {
                printf("<td class='twg'><div align='center'><img src='%sbuttons/hier_oben.gif' width='%s' height='7' alt='' ><br><img alt='' src='%s' %s><br><img src='%sbuttons/hier.gif' width='%s' height='7'  alt='' ></div></td>\n", $install_dir_view, $thumb_pic_size, $src_value, $htmlsize, $install_dir_view, $thumb_pic_size);
            } else if ($i == $current && ($total_num != (2 * $numberofpics)) && !$show_html_side_left_only) {
                $printed--;
            } else {
                $beschreibung = php_to_all_html_chars(escapeHochkomma(getBeschreibung($aktimage, $werte, $index)));
                // center is used because ie is ignoring css
                $myclass = "navicon";

                if ($side != "bottom") {
                    $myclass = "html_side_default";

                    if ($needDividor && $html_side_show_dividor) { // need dividor is only set in html_side mode
                        if (($i + 1) == $current && ($total_num != (2 * $numberofpics))) {
                            $myclass = "html_side_right";
                        } else if (($i - 1) == $current && $current == 0 && ($total_num != (2 * $numberofpics))) {
                            $myclass = "html_side_left";
                        }
                    }
                    if ($total_num == (2 * $numberofpics) && ($i == $current)) {
                        $myclass = "html_side_mark";
                    }
                }
                $beschreibung = urlencode($beschreibung);
                $href_center = getScriptName() . '?twg_album='.$album_enc.'&amp;twg_show=' .  $aktimage. $twg_standalone;
                printf("<td class='%s'  style='width:%s'><center id='center-index-image'><a href='%s'><img src='%s' alt='%s' title='%s' id='img%s' %s></a></center></td>\n", $myclass, $thumb_pic_size, tfu_seo_rewrite_url($href_center), $src_value, $beschreibung, $beschreibung, $i, $htmlsize);
                if (($i - 1) == $current) { // we preload the next big image if available
                    $nextimage = $install_dir_view . "image.php?twg_album=" . $album_enc . "&twg_type=small&twg_show=" . $imagelist[$i];
                }
            }
        }
        if ($side != "bottom") {
            if ((($printed % $html_side_break) == $html_side_break - 1) && ($i < $to)) {
                echo "</tr><tr>";
            }
            $printed++;
        }
    }
    return $nextimage;
}

function print_thumbnails($twg_album, $twg_offset, $werte, $index, $twg_foffset)
{
    global $thumbnails_x, $thumbnails_y, $kwerte, $kindex, $basedir;
    global $extension_thumb, $top10, $privatelogin;
    global $lang_thumb_forward, $lang_thumb_back, $install_dir, $use_original_on_thumbspage;
    global $twg_standalone, $twg_standalonejs, $autodetect_maximum_thumbnails;
    global $thumb_pic_size, $show_number_of_comments, $lang_comments, $disable_direct_thumbs_access;
    global $show_subdirs_first, $show_clipped_images, $thumb_pic_size, $other_file_formats, $show_other_formats_at_thumb;
    global $activate_lightbox_thumb, $activate_lightbox_thumb_full, $show_caption_on_thumbs;
    global $thumb_cellpadding, $thumb_cellspacing, $left_htm_width, $album_tree_width, $enable_album_tree;
    global $opera, $album_tree_default_open, $thumbnail_offset_y, $use_lytebox;
    global $spacer_char, $paging_num, $paging_steps, $paging_use_style, $subfolders_only_once, $show_album_name_on_thumb_page;
    global $thumb_cellpadding, $thumb_cellspacing, $charset, $video_player, $install_dir_view, $twg_seo_active;
    global $responsive_thumb_page, $responsive_align_center;

    if ($responsive_thumb_page) {
        $responsive_thumb_page_class = ' thumbpage-float' . (($responsive_align_center) ? '' : ' thumbpage-float-left');
        $thumb_type = 'div';
    } else {
        $responsive_thumb_page_class = '';
        $thumb_type = 'td';
    }
    


    if ($twg_album) { // !1st level
        $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
        $path = $basedir . "/" . $twg_album;
    } else {
        $album_enc = "";
        $path = $basedir;
    }
    $imagelist = get_image_list($twg_album);
    $imageid = ($twg_offset > 0 ? $twg_offset : 0);
    $minus_rows = 0;
    $offset_text = $thumbnail_offset_y;
                    
    $twg_http_root = getTWGHttpRoot($install_dir);
    if ($paging_use_style) {
        $offset_text += 10; // this mode needs ~ 10 pix more space
    }
    if ($twg_album) { // !1st level
        if ($show_album_name_on_thumb_page) {
            $temp1 = explode("/", $twg_album);
            $titel = array_pop($temp1);
            $titel = getDirectoryName($path, $titel);
            printf("<span class='twg_title'>%s</span><br>", $titel);
        }
        $text = getDirectoryDescription($path);
        if ($text) {
            $lines = ceil((strlen(strip_tags($text)) / 130));
            $offset_text += $lines * 20;
            echo '<img height=5 width=1 alt=""  src="' . $install_dir_view . 'buttons/1x1.gif" ><br>';
            echo "<div class='twg_folderdescription'>" . $text . "</div><br>";
        }
        echo "<br>";
    }
    // we do autowidthdetection here !
    if ($autodetect_maximum_thumbnails && isset($_SESSION[$GLOBALS["standalone"] . "browserx_res"]) && isset($_SESSION[$GLOBALS["standalone"] . "browsery_res"])) {
       
        // we check if left.htm and menu is shown and use less thumbs then! 200px each!
        $spacex = ($responsive_thumb_page)? 0 : 30;  
        
        if ($enable_album_tree && $album_tree_default_open) { // gallery tree shown
            $spacex += $album_tree_width;
        }
        $lefthtml = dirname(__FILE__) . "/../left.htm";
        if (file_exists($lefthtml)) { // left menu shown
            $spacex += $left_htm_width;
        }
        $fullwidth = $thumb_cellpadding + $thumb_cellspacing + $thumb_pic_size;
        $thumbnails_x = floor(($_SESSION[$GLOBALS["standalone"] . "browserx_res"] - $spacex) / $fullwidth);
        $thumbnails_y = floor(($_SESSION[$GLOBALS["standalone"] . "browsery_res"] - 60 - $offset_text) / $fullwidth);
    }
   
    if ($show_subdirs_first) {
        if ($subfolders_only_once && $twg_offset == 0) {
            $minus_rows = ceil(show_folders($path, $twg_foffset, $twg_offset, $twg_album) * 1.4);
        } else if (!$subfolders_only_once) {
            $minus_rows = ceil(show_folders($path, $twg_foffset, $twg_offset, $twg_album) * 1.4);
        }
        if ($minus_rows >= $thumbnails_y) {
            $minus_rows = $thumbnails_y - 1;
        }
    }

    $total = count($imagelist);
    if ((($thumbnails_y - $minus_rows) * $thumbnails_x) > $total) {   
        $thumbnails_y = ceil($total / $thumbnails_x) + $minus_rows;
    }

    $thumbnails_y_full = $thumbnails_y; 
    $thumbnails_y = $thumbnails_y - $minus_rows;
    if ($thumbnails_y < 1) {
        $thumbnails_y = 1;
    }
    if ($thumbnails_y_full < 1) {
        $thumbnails_y_full = 1;
    }
    if ($thumbnails_x < 1) {
        $thumbnails_x = 1;
    }

    $alignment = "";
    if ($show_caption_on_thumbs) {
        $alignment = " top";
    }

    // for the lightbox we create all images before in a hidden div
    if ($activate_lightbox_thumb && $use_lytebox) {
        $old_imageid = $imageid;
        echo '<div class="hiddendiv">';
        for ($imageid = 0; $imageid < $old_imageid; ++$imageid) {
            if (isset($imagelist[$imageid])) {
                $aktimage = replace_valid_url($imagelist[$imageid]);
                $ccount = getKommentarCount($imagelist[$imageid], $twg_album, $kwerte, $kindex);
                $b = $beschreibung = getBeschreibung($imagelist[$imageid], $werte, $index);
                if (($beschreibung <> " ") && ($beschreibung <> "")) {
                    $beschreibunga = php_to_all_html_chars(escapeHochkomma($beschreibung));
                    if ($show_number_of_comments && ($ccount > 0)) {
                        $beschreibunga .= ' | ' . $lang_comments . ': ' . $ccount;
                    }
                    $titel = $beschreibung = "title='" . $beschreibunga . "' ";
                    $beschreibung .= " alt='" . $beschreibunga . "' ";
                } else if ($ccount > 0) {
                    $beschreibunga = $lang_comments . ': ' . $ccount;
                    $titel = $beschreibung = " title='" . $beschreibunga . "' ";
                    $beschreibung .= " alt='" . $beschreibunga . "' ";
                } else {
                    $beschreibung = ' alt="" ';
                    $titel = '';
                }
                $href_src = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . $twg_standalone;
                $href = ' href="' . tfu_seo_rewrite_url($href_src) . '" ';
                if ($use_original_on_thumbspage) {
                    $hreffull = ' href="' . $twg_http_root . 'image.php?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . '" ';
                } else {
                    $hreffull = ' href="' . $twg_http_root . 'image.php?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . '&amp;twg_type=small" ';
                }
                // end of block
                printf("<a id='i%s' rel='lightbox[roadtrip]' %s %s> </a>", $imageid, $hreffull, $titel);
            }
        }
        echo '</div>';
        $imageid = $old_imageid;
    }
    if (isset($imagelist[0]) && $imagelist[0] != "") {
        if (!$responsive_thumb_page) {
          echo "<table summary='' class='thumbnails thumbnail_page' cellpadding='0' cellspacing='0'>\n";
          echo '<tr>'; 
        }
        for ($i = 0; $i < $thumbnails_y; $i++) {
            if (!$responsive_thumb_page) {
                echo '<tr>'; 
            }
            for ($j = 0; $j < $thumbnails_x; $j++) {
                if ($imageid >= $total || !isset($imagelist[$imageid])) {
                    if (!$responsive_thumb_page) {
                        printf("<td class='thumbnails_empty".$responsive_thumb_page_class."'>&nbsp;</td>");
                    }
                } else {

                    $aktimage = replace_valid_url($imagelist[$imageid]);
                    $thumbimage = create_thumb_image($twg_album, $aktimage);
                    $thumb = create_cache_file($thumbimage, $extension_thumb);
                    if ($show_clipped_images) {
                        $thumb_width = $thumb_pic_size;
                    }
                    if (!file_exists($thumb) || $disable_direct_thumbs_access) {
                        $src_value = $install_dir_view . "image.php?twg_album=" . $album_enc . "&amp;twg_type=thumb&amp;twg_show=" . $aktimage;
                        if ($show_clipped_images) {
                            $theight = " height='" . $thumb_pic_size . "' width='" . $thumb_pic_size . "' ";
                        } else {
                            $theight = "";
                            $thumb_width = "";
                        }
                    } else {
                        $src_value = create_cache_file(cacheencode($thumbimage), $extension_thumb, true, $twg_seo_active);
                        if ($show_clipped_images) {
                            $theight = " height='" . $thumb_pic_size . "' width='" . $thumb_pic_size . "' ";
                        } else {
                            $isize = getimagesize($thumb);
                            $thumb_width = $isize[0];
                            $theight = " height='" . $isize[1] . "' width='" . $isize[0] . "' ";
                        }
                    }
                    $ccount = getKommentarCount($imagelist[$imageid], $twg_album, $kwerte, $kindex);
                    $b = $beschreibung = getBeschreibung($imagelist[$imageid], $werte, $index);
                    if (($beschreibung <> " ") && ($beschreibung <> "")) {
                        $beschreibunga = php_to_all_html_chars(escapeHochkomma($beschreibung));
                        if ($show_number_of_comments && ($ccount > 0)) {
                            $beschreibunga .= ' | ' . $lang_comments . ': ' . $ccount;
                        }
                        $titel = $beschreibung = "title='" . $beschreibunga . "' ";
                        $beschreibung .= " alt='" . $beschreibunga . "' ";
                    } else if ($ccount > 0) {
                        $beschreibunga = $lang_comments . ': ' . $ccount;
                        $titel = $beschreibung = " title='" . $beschreibunga . "' ";
                        $beschreibung .= " alt='" . $beschreibunga . "' ";
                    } else {
                        $beschreibung = ' alt="" ';
                        $titel = '';
                    }
                    $href_src = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . $twg_standalone;
                    $href = ' href="' . tfu_seo_rewrite_url($href_src) . '" ';
                    // has to be set empty that getTWGHttpRoot returns the right value!
                    $video_player = '';
                    if ($use_original_on_thumbspage) {
                        $hreffull = ' href="' . $twg_http_root . 'image.php?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . '" ';
                    } else {
                        $hreffull = ' href="' . $twg_http_root . 'image.php?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . '&amp;twg_type=small" ';
                    }
                    // end of block

                    if ($show_other_formats_at_thumb) {
                        foreach ($other_file_formats as $label => $key) {
                            $other_format = exchangeExtension($path . "/" . urldecode($aktimage), $label);
                            if (file_exists($other_format)) {
                                $other_format = twg_urlencode($other_format);
                                $target = ' target="_blank" ';
                                $href = ' ' . $target . ' href="' . $install_dir_view . $other_format . '" ';
                            }
                        }
                    }

                    if ($show_caption_on_thumbs) {
                        $thumbtitel = "<tr><td class='thumb_text' style='width:" . $thumb_pic_size . "px'>" . $b . "</td></tr>";
                    } else {
                        $thumbtitel = "";
                    }
 
                    if ($activate_lightbox_thumb) {                   
                        if (!$activate_lightbox_thumb_full) {
                            printf("<".$thumb_type." class='thumbnails" .$responsive_thumb_page_class. $alignment . "' ><table summary='' class='thumbnails' cellpadding='%s' cellspacing='%s'><tr><td class='twg_unhoverThumbnail' onMouseOver=\"this.className='twg_hoverThumbnail'\" onMouseOut=\"this.className='twg_unhoverThumbnail'\"><center class='center-mag-glas'><div style='position: relative; width:" . $thumb_width . ";'><div class='twg_magglas twg_magglas_left'><a %s id='i%s' rel='lightbox[roadtrip]' %s ><img onMouseover='this.className=\"imagefull\";' onMouseout='this.className=\"imagealpha\";' class='imagealpha' src='%sbuttons/openlight.gif' width='18px' height='18px' alt=''></a></div><div><a %s><img class='img-thumbnail' src='%s' %s %s ></a></div></div></center></td></tr>%s</table></".$thumb_type.">", $thumb_cellpadding, $thumb_cellspacing, $titel, $imageid, $hreffull, $install_dir_view, tfu_seo_rewrite_url($href), $src_value, $beschreibung, $theight, $thumbtitel);
                        } else {
                            printf("<".$thumb_type." class='thumbnails" .$responsive_thumb_page_class. $alignment . "' ><table summary='' class='thumbnails' cellpadding='%s' cellspacing='%s'><tr><td class='twg_unhoverThumbnail' onMouseOver=\"this.className='twg_hoverThumbnail'\" onMouseOut=\"this.className='twg_unhoverThumbnail'\"><a id='i%s' rel='lightbox[roadtrip]' %s %s><img class='img-thumbnail' src='%s' %s %s ></a></td></tr>%s</table></".$thumb_type.">", $thumb_cellpadding, $thumb_cellspacing, $imageid, $hreffull, $titel, $src_value, $beschreibung, $theight, $thumbtitel);
                        }
                    } else {
                        printf("<".$thumb_type." class='thumbnails" .$responsive_thumb_page_class. $alignment . "' >
                                      <table summary='' class='thumbnails' cellpadding='%s' cellspacing='%s'><tr><td class='twg_unhoverThumbnail" . $alignment . "' onMouseOver=\"this.className='twg_hoverThumbnail'\" onMouseOut=\"this.className='twg_unhoverThumbnail'\"><a %s><img src='%s' %s %s ></a></td></tr>%s</table></".$thumb_type.">", $thumb_cellpadding, $thumb_cellspacing, tfu_seo_rewrite_url($href), $src_value, $beschreibung, $theight, $thumbtitel);
                    }
                    $imageid++;
                }
            }
            if (!$responsive_thumb_page) {
                echo '</tr>'; 
            }
        }
        if (!$responsive_thumb_page) {
          echo '</tr>';
          print "</table>\n";
        } else {
           echo '<br/>';
        }
    }

    // for the lightbox we create all images afterwards in a hidden div
    if ($activate_lightbox_thumb && $use_lytebox) {
        $old_imageid = $imageid;
        echo '<div class="hiddendiv">';
        for ($imageid = $imageid; $imageid < count($imagelist); ++$imageid) {
            if (isset($imagelist[$imageid])) {
                $aktimage = replace_valid_url($imagelist[$imageid]);
                $ccount = getKommentarCount($imagelist[$imageid], $twg_album, $kwerte, $kindex);
                $b = $beschreibung = getBeschreibung($imagelist[$imageid], $werte, $index);
                if (($beschreibung <> " ") && ($beschreibung <> "")) {
                    $beschreibunga = php_to_all_html_chars(escapeHochkomma($beschreibung));
                    if ($show_number_of_comments && ($ccount > 0)) {
                        $beschreibunga .= ' | ' . $lang_comments . ': ' . $ccount;
                    }
                    $titel = $beschreibung = "title='" . $beschreibunga . "' ";
                    $beschreibung .= " alt='" . $beschreibunga . "' ";
                } else if ($ccount > 0) {
                    $beschreibunga = $lang_comments . ': ' . $ccount;
                    $titel = $beschreibung = " title='" . $beschreibunga . "' ";
                    $beschreibung .= " alt='" . $beschreibunga . "' ";
                } else {
                    $beschreibung = ' alt="" ';
                    $titel = '';
                }
                $href_src = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . $twg_standalone;
                $href = ' href="' . tfu_seo_rewrite_url($href_src) . '" ';
                if ($use_original_on_thumbspage) {
                    $hreffull = ' href="' . $twg_http_root . 'image.php?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . '" ';
                } else {
                    $hreffull = ' href="' . $twg_http_root . 'image.php?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . '&amp;twg_type=small" ';
                }
                // end of block
                printf("<a id='i%s' rel='lightbox[roadtrip]' %s %s> </a>", $imageid, $hreffull, $titel);
            }
        }
        echo '</div>';
        
        
        $imageid = $old_imageid;
    }

    $_SESSION["twg_minus_rows"] = $minus_rows; // stored for offset needed in details page

   
    
    $thumbnails = $thumbnails_x * $thumbnails_y_full;
    $actpage = 0;
    // start 1 | 2 |3 ...
    $cimages = count($imagelist);
    
    $factor_pageing = $twg_offset / $thumbnails; 
   
    if ($twg_offset == 0) {
        $missing_images_page_one = $thumbnails_x * $minus_rows;
    } else {
        $missing_images_page_one = $thumbnails - (($factor_pageing - floor($factor_pageing)) * $thumbnails);
    }
     
    $showpaging = ($cimages  > $thumbnails-$missing_images_page_one) ;
    if ($paging_use_style && $showpaging) {
        echo '<img class="twg_pag_spacer" height=6 width=1 alt=""  src="' . $install_dir_view . 'buttons/1x1.gif" ><br>';
        echo "<div class='twg_pag'>";
    }
      
    if ($showpaging) {
          
        if ($twg_offset > 0) {
            $before_offset = $twg_offset - $thumbnails+ $missing_images_page_one;
            $my_offset = '';
            if ($twg_offset_ > 0) {
              $my_offset = '&amp;twg_offset=' . $before_offset;
              $my_offset_js = '&amp;twg_offset=' . $before_offset;
            }
            $hreflast = getScriptName() . '?twg_album=' . $album_enc . $my_offset . $twg_standalone;
            $hreflastjs = getScriptName() . '?twg_album=' . $album_enc . $my_offset_js . $twg_standalonejs;
            echo '<script type="text/javascript"> function key_back() { location.href="' . $hreflastjs . '" } </script>';
            printf("<a href='%s'>%s</a> ", tfu_seo_rewrite_url($hreflast), $lang_thumb_back);
            print $spacer_char;
        } else {
            echo " <span class='inactive'>" . $lang_thumb_back . "</span> ";
        }

        $numpages = ceil((count($imagelist)-$missing_images_page_one) / ($thumbnails)) + 1;
        
        if ($numpages <= $paging_steps) { // we show all
            $paging_num = $paging_steps;
        }
        if ($numpages <= 25) { // 10 Schritte
            $paging_steps = ceil($paging_steps / 2);
        }
        for ($i = 0; $i < $numpages; $i++) {
            $twg_offset_ = ($i * $thumbnails) - $missing_images_page_one;
            $trenner = false;
            if ($twg_offset >= $twg_offset_ && $twg_offset < $twg_offset_ + $thumbnails) {
                $actpage = $i;
                echo "<a class='sel twg_bold' onclick='return false;' href=''>" . ($i + 1) . "</a>";
                $trenner = true;
            } else {
                if ((abs($twg_offset - $twg_offset_) < ($paging_num * $thumbnails)) || ($i == $numpages - 1) || ($i == 0) || (($i % $paging_steps) == $paging_steps - 1)) {
                    $my_offset = '';
                    if ($twg_offset_ > 0) {
                      $my_offset = '&amp;twg_offset=' . ($twg_offset_);
                    }
                    $paging_href = getScriptName() . '?twg_album=' . $album_enc . $my_offset . $twg_standalone;
                    printf("<a href='%s'>%s</a>", tfu_seo_rewrite_url($paging_href) , $i + 1);
                    $trenner = true;
                }
            }
            if ($trenner && $actpage != $numpages - 1) {
                echo $spacer_char;
            }
        }
        if ($actpage != $numpages - 1) {
            $hrefnext = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_offset=' . ($twg_offset + $thumbnails- $missing_images_page_one) . $twg_standalone;
            $hrefnextjs = getScriptName() . '?twg_album=' . $album_enc . '&twg_offset=' . ($twg_offset + $thumbnails- $missing_images_page_one) . $twg_standalonejs;
            echo '<script type="text/javascript"> function key_foreward() { location.href="' . $hrefnextjs . '" } </script>';
            printf(" <a href='%s'>%s</a> ", tfu_seo_rewrite_url($hrefnext), $lang_thumb_forward);
        } else {
            echo " <span class='inactive'>" . $lang_thumb_forward . "</span> ";
        }
    }
    if ($paging_use_style && $showpaging) {
        echo "</div>";
    }
    // ende 1 | 2 |3 ...
    if (!$show_subdirs_first) {
        if (($subfolders_only_once && $twg_offset == 0) || !$subfolders_only_once) {
            show_folders($path, $twg_foffset, $twg_offset, $twg_album);
        }
    }

    $preload = "";

    for ($p = 0; $p < $thumbnails && ($imageid < $total); $p++) {
        if (isset($imagelist[$imageid])) {
            $aktimage = replace_valid_url($imagelist[$imageid]);
            $thumbimage = create_thumb_image($twg_album, $aktimage);
            $thumb = create_cache_file($thumbimage, $extension_thumb);
            $ccount = getKommentarCount($imagelist[$imageid], $twg_album, $kwerte, $kindex);
            if (!file_exists($thumb) || $disable_direct_thumbs_access) {
                $preload .= "'" . $install_dir_view . "image.php?twg_album=" . $album_enc . "&twg_type=thumb&twg_show=" . $aktimage . "'";
            } else {
                $preload .= "'" . create_cache_file(cacheencode($thumbimage), $extension_thumb, true, $twg_seo_active) . "'";
            }
            $preload .= "                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ,";
            $imageid++;
        }
    }
    if ($preload <> "") {
        $preload = substr($preload, 0, -1);
        echo "<script type='text/javascript'>window.setTimeout(\"MM_preloadImages(" . $preload . ")\"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   ,3000);</script>";
    }
    echo '</div>';
}

function print_album_tree($basedir)
{
    global $album_tree_width, $autoclose_tree, $album_tree_default_open;
    global $lang_galleries, $show_counter_in_jstree, $multi_root_mode;
    global $lang_open_all, $lang_close_all, $lang_refresh_album_cache;
    global $install_dir, $twg_album, $opera, $twg_root, $twg_standalonejs, $install_dir_view;

    $path = $basedir . "/" . $twg_album;
    $rootalbum = '';

    if ($multi_root_mode && $twg_album) {
        $elements = explode("/", $twg_album);
        $basedir = $basedir . '/' . $elements[0];
        $rootalbum = 'twg_album=' . urlencode($elements[0]);
    }

    if ($album_tree_default_open) {
        $display = "";
    } else {
        $display = "display:none;";
    }

    if ($autoclose_tree) {
        $icon = "autohideOn_png";
    } else {
        $icon = "autohideOff_png";
    }

    echo "
  <td class='twg_album_view' id='menu_td' style='width:" . ($album_tree_width) . "px;" . $display . "'>
  <div class='twg_album_view_div' id='tree_content' style='width:" . ($album_tree_width) . "px;'>";

    if (!$opera) {
        echo "<img class='twg_sprites " . $icon . "' src='" . $install_dir_view . "buttons/1x1.gif' width='14px' height='14px' id='hide_icon' alt='' onClick='javascript:autohide(\"" . $install_dir_view . "\");' style='float:right;margin-top:5px;margin-right:5px;cursor:pointer;'>";
    }

    echo "
	<script type='text/javascript' src='" . $install_dir_view . "dtree/dtree-min.js'></script>
	<br><span class='dtree dtree_header'><a href='javascript:d.openAll();'>" . $lang_open_all . "</a> | <a href='javascript:d.closeAll();'>" . $lang_close_all . "</a></span><br>&nbsp;<br>
  <script type='text/javascript'>
			d = new dTree('d'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              ,'" . $install_dir_view . "');
			d.config.inOrder=true;
			d.config.useStatusText=true;";

    $local_lang_galleries = $lang_galleries;
    if ($show_counter_in_jstree) {
        if (isset($_SESSION["count_treec" . $install_dir_view . $basedir])) {
            $local_lang_galleries = $lang_galleries . " (" . $_SESSION["count_treec" . $install_dir_view . $basedir] . ")";
        }
    }

    echo
        "d.add(0                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ,-1                                                                                                                                                                                                    ,'" . $local_lang_galleries . "','" . getScriptName() . "?" . $rootalbum . $twg_standalonejs . "');
			";
    $wwert = print_js_tree($basedir);

    // we select the right node
    if (isset($_SESSION["js_tree"]["js_tree" . $path])) {
        echo "d.setCookie('csd'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         , " . $_SESSION["js_tree"]["js_tree" . $path] . ");";
    } else {
        echo "d.setCookie('csd'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         , 0);";
    }
    if ($wwert != "NBY") {
        echo $wwert;
    }
    echo "document.write(d);";

    // we open the selected node
    if (isset($_SESSION["js_tree"]["js_tree_root" . $path])) {
        echo "d.openTo(" . $_SESSION["js_tree"]["js_tree_root" . $path] . "                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       , true);";
    }
    echo "</script>";
    if ($wwert == "NBY") {
        echo "<div class='dtree dtree_header album_view_cache'>" . $lang_refresh_album_cache . "</div>";
    }
    echo "</div></td>";
}

/*
  escapes the caption - <br> is not escapted !!  - for the tooltips only the 1st line is returned !
*/
function php_to_all_html_chars($data, $fortooltip = true)
{
    if ($fortooltip) {
        $data = str_replace("<br>", " - ", $data);
        $data = strip_tags($data);
        $data = str_replace("||", " - ", $data);
    }
    $data = str_replace("&", "&amp;", $data);
    $data = str_replace(" || ", "&nbsp;<br>&nbsp;", $data);
    $data = str_replace("||", "&nbsp;<br>&nbsp;", $data);
    return $data;
}

function fix_ie_height()
{
    global $iframe_include, $msie, $iframe_height_ie;

    $iheight = "";
    if ($iframe_include && $msie) {
        $iheight = "style='height:" . ($iframe_height_ie) . "'";
    }
    return $iheight;
}


function includeBottom($enable_external_html_include, $colspan)
{
    if ($enable_external_html_include) {

        $bottomhtml = dirname(__FILE__) . "/../bottom.htm";
        if (file_exists($bottomhtml)) {
            echo "<tr><td colspan=" . $colspan . " class='twg_bottomhtml'>";
            include ($bottomhtml);
            echo "</td></tr>";
        }
    }
}

function includeFooter($enable_external_html_include, $colspan)
{
    if ($enable_external_html_include) {
        $footerhtml = dirname(__FILE__) . "/../footer.htm";
        if (file_exists($footerhtml)) {
            echo "<tr><td colspan=" . $colspan . " class='twg_footerhtml'>";
            include ($footerhtml);
            echo "</td></tr>";
        }
    }
}

function includeTop($enable_external_html_include, $colspan)
{
    if ($enable_external_html_include) {
        $headertop = dirname(__FILE__) . '/../top.htm';
        if (file_exists($headertop)) {
            echo '<tr><td colspan=' . $colspan . ' class="twg_tophtml">';
            include ($headertop);
            echo '</td></tr>';
        }
    }
}

function includeHeader($enable_external_html_include, $colspan)
{
    if ($enable_external_html_include) {
        $headerhtml = dirname(__FILE__) . '/../header.htm';
        if (file_exists($headerhtml)) {
            echo '<tr><td colspan="' . $colspan . '" class="twg_headerhtml">';
            include ($headerhtml);
            echo '</td></tr>';
        }
    }
}

?>
