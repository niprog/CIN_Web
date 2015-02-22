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
if ($twg_slideshow == false) {
    echo "<tr><td id='bottom_row' class='navbar'>";
    if (!$twg_showprivatelogin) {
        if ($image != false) { // imageview bottom navigation
            if (!$top10 && $default_big_navigation != "HTML_SIDE" && $big_nav_pos != "top") {
                print_big_navigation($twg_album, $album_enc, $image, $twg_rot, $current_id, $thumb_pic_size, $kwerte, $kindex, $dir);
            }

            if (($image_rating_position == "below_navigation") && $show_image_rating) {
                include dirname(__FILE__) . "/../inc/rating.inc.php";
            }

            // here we create the lightbox dummy - most of the stuff is already cached like the image list.
            // for the lightbox we create all images before in a hidden div
            if ($activate_lightbox_image && $use_lytebox && !$video_dir) {
                $imagelist = get_image_list($twg_album);
                $nr_images = count($imagelist);
                $use_original_on_thumbspage = true; // on the image page we always want the original.
                echo '<div class="hidd endiv">';
                for ($imageid = 0; $imageid < $nr_images; ++$imageid) {
                    $aktimage = replace_valid_url($imagelist[$imageid]);
                    include 'thumbnail.inc.php';
                    printf("<a id='i%s' rel='lightbox[roadtrip]' %s %s> </a>", $imageid, $hreffull, $titel);
                }
                echo '</div>';
            }
            // twg_shows comments
            if ($show_comments && !$default_is_fullscreen) {
                if (!$show_comments_in_layer) {
                    $comment_data = substr(getKommentar(urldecode($image), $twg_album, $kwerte, $kindex, false), 10);
                    echo "<center id='center-bottomnav'><table class='twg' summary='' style='max-width:" . $small_pic_size . "px;'>";
                    echo "<tr><td id='kommentartd' class='twg_kommentar' >";
                    echo $comment_data;
                    echo "</td></tr></table></center>";
                } else {
                    if ($show_enter_comment_at_bottom && (($enable_comments_only_registered && $login_edit) || ($enable_comments_only_registered && isset($_SESSION["s_user"])) || !$enable_comments_only_registered)) {
                        if ($show_number_of_comments) {
                            $com_count = " (<span id='kommentarnumber'>" . getKommentarCount($image, $twg_album, $kwerte, $kindex) . "</span>)";
                        } else {
                            $com_count = "";
                        }
                        // $lang_height_comment += $height_of_comment_layer;
                        $headerkommentar = "<div class='twg_underlineb'><a id='kommentarenter' onclick='return twg_showSec(" . $lang_height_comment . ")' target='details' href='" . $install_dir_view . "i_frames/i_kommentar.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image . $twg_standalone . "'>" . $lang_show_kommentar . $com_count;
                        $headerkommentar .= '<img alt="" width=5   src="' . $install_dir_view . 'buttons/1x1.gif" ><img class="twg_sprites add_gif" alt="' . $lang_add_kommentar . '" title="' . $lang_add_kommentar . '"  src="' . $install_dir_view . 'buttons/1x1.gif" >';
                        $headerkommentar .= "</a></div>";
                        echo $headerkommentar;
                    }
                }
            }
        }
    }
    echo "</td></tr>";
}

/* include the extra html pages */
include (dirname(__FILE__) . "/../inc/html.inc.php");

/* include the tips */
include (dirname(__FILE__) . "/../inc/tips.inc.php");

?>