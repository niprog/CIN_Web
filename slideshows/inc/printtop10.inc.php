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

function print_top_10($twg_album, $top10_type)
{
    global $thumbnails_x, $thumbnails_y, $kwerte, $kindex, $werte, $index;
    global $basedir, $extension_thumb, $top10, $privatelogin, $thumb_pic_size;

    global $lang_thumb_forward, $lang_thumb_back, $number_top10, $lang_views, $lang_topx;
    global $install_dir, $lang_no_topx_images, $twg_standalone;
    global $twg_standalonejs, $lang_fileinfo_views, $lang_fileinfo_dl, $lang_fileinfo_rating;
    global $lang_rating_vote, $lang_last_comments, $show_count_views, $enable_download_counter;
    global $show_download_counter, $show_image_rating, $show_comments, $topx_default, $show_topx_comments_details;
    global $enable_download, $charset;
    // for Search
    global $lang_search_results, $twg_search_term, $twg_search_filename;
    global $twg_search_caption, $twg_search_comment, $twg_search_folders, $twg_search_tags, $twg_search_max;
    global $lang_search_hits, $lang_search_hits_limit;
    global $twg_offset, $show_clipped_images, $show_topx_search_details, $autodetect_maximum_thumbnails;
    global $show_clipped_images, $twg_search_latest, $twg_search_max, $use_original_on_topxpage;
    global $activate_lightbox_topx, $activate_lightbox_topx_full, $autojump_if_one_result, $twg_search_num;
    global $install_dir_view, $twg_search_exact;

    $activate_lightbox_topx_tmp = $activate_lightbox_topx;

    $twg_http_root = getTWGHttpRoot($install_dir);
    $ip = "";

    $album_enc = $twg_album;
    $album_dec = urldecode($twg_album);

    if ($autodetect_maximum_thumbnails && isset($_SESSION[$GLOBALS["standalone"] . "browserx_res"]) /* && ($top10_type == "search") */) {
        $thumbnails_x = floor(($_SESSION[$GLOBALS["standalone"] . "browserx_res"] - 30) / ($thumb_pic_size + 30));
        if ($thumbnails_x < 1) {
            $thumbnails_x = 1;
        }
    }
    $thumbnails_y = ceil(($number_top10 - 1) / $thumbnails_x) + 2;
    $showcharacters = ceil($thumb_pic_size / 7) - 2;
    echo '<div class="topx">';
    // start header
    if ($top10_type == "search") {
        echo "<span class='twg_title'>" . $lang_search_results . "</span><br>&nbsp;<br>";
    } else {
        $show_spacer = false;
        echo "<span class='twg_title'>" . sprintf($lang_topx, $number_top10) . "</span><br>";
        echo "<img src='" . $install_dir_view . "buttons/1x1.gif' width='200' height='3' alt='' ><br>";
        $hrefstart = $twg_http_root . "image.php?twg_album=";
        echo "<span class='twg_topx_sel'>";
        // views
        if ($show_count_views) {
            if ($top10_type == "views") {
                echo "<span class='twg_topx_selected'>" . $lang_fileinfo_views . "</span>";
            } else {
                echo "<a href='" . getScriptName() . "?twg_album=" . $twg_album . "&amp;twg_top10=views" . $twg_standalone . "'>" . $lang_fileinfo_views . "</a>";
            }
            $show_spacer = true;
        }
        // download
        if ($enable_download_counter && $show_download_counter && $enable_download) {
            $show_spacer = print_spacer($show_spacer);
            if ($top10_type == "dl") {
                echo "<span class='twg_topx_selected'>" . $lang_fileinfo_dl . "</span>";
            } else {
                echo "<a href='" . getScriptName() . "?twg_album=" . $twg_album . "&amp;twg_top10=dl" . $twg_standalone . "'>" . $lang_fileinfo_dl . "</a>";
            }
        }
        // rating
        if ($show_image_rating) {
            $show_spacer = print_spacer($show_spacer);
            if ($top10_type == "average") {
                echo "<span class='twg_topx_selected'>" . $lang_fileinfo_rating . "</span>";
            } else {
                echo "<a href='" . getScriptName() . "?twg_album=" . $twg_album . "&amp;twg_top10=average" . $twg_standalone . "'>" . $lang_fileinfo_rating . "</a>";
            }
            echo " | ";
            if ($top10_type == "votes") {
                echo "<span class='twg_topx_selected'>" . $lang_rating_vote . "</span>";
            } else {
                echo "<a href='" . getScriptName() . "?twg_album=" . $twg_album . "&amp;twg_top10=votes" . $twg_standalone . "'>" . $lang_rating_vote . "</a>";
            }
        }
        // comments
        if ($show_comments) {
            $show_spacer = print_spacer($show_spacer);
            if ($top10_type == "comments") {
                echo "<span class='twg_topx_selected'>" . $lang_last_comments . "</span>";
            } else {
                echo "<a href='" . getScriptName() . "?twg_album=" . $twg_album . "&amp;twg_top10=comments" . $twg_standalone . "'>" . $lang_last_comments . "</a>";
            }
        }
        echo "</span><br><br>";
    }
    // - end header

    // start get data
    $minus_rows = 2;
    if ($twg_album != false) {
        $dd = get_view_dirs($basedir . "/" . $album_dec, $privatelogin);
    } else {
        $dd = get_view_dirs($basedir, $privatelogin);
    }

    $offset = 10;

    if ($top10_type == "dl") {
        $imagelist = getTopXDownloads($dd);
        $lang_views = "";
    } else if ($top10_type == "average") {
        $imagelist = getTopXAverage($dd);
        $lang_views = "";
    } else if ($top10_type == "votes") {
        $imagelist = getTopXVotes($dd);
        $lang_views = "";
    } else if ($top10_type == "comments") {
        $imagelist = getLatestKomments($dd);
        // $imagelist = searchCaption($dd,"a");
        $lang_views = "";
    } else if ($top10_type == "search") {
        $imagelist = Array();
        if ($twg_search_tags) {
            $resultlist = search_tags($dd, $twg_search_term, $twg_search_exact);
            if ($resultlist) {
                $imagelist = array_merge($imagelist, $resultlist);
            }
        }
        if ($twg_search_folders) {
            $resultlist = searchFolders($dd, $twg_search_term);
            if ($resultlist) {
                $imagelist = array_merge($imagelist, $resultlist);
            }
        }
        if ($twg_search_latest) {
            $resultlist = searchLatest($basedir, $twg_search_term, $dd, $twg_search_num);
            if ($resultlist) {
                $imagelist = array_merge($imagelist, $resultlist);
            }
        }
        if ($twg_search_caption) {
            $resultlist = searchCaption($dd, $twg_search_term);
            if ($resultlist) {
                $imagelist = array_merge($imagelist, $resultlist);
            }
        }
        if ($twg_search_comment) {
            $resultlist = searchComments($dd, $twg_search_term);
            if ($resultlist) {
                $imagelist = array_merge($imagelist, $resultlist);
            }
        }
        if ($twg_search_filename) {
            $resultlist = search_filenames($basedir, $twg_search_term, $dd);
            if ($resultlist) {
                $imagelist = array_merge($imagelist, $resultlist);
            }
        }
        if (count($imagelist) == 0) {
            $imagelist = false;
        } else {
            $nrimages = count($imagelist);
            $imagelist = array_slice($imagelist, $twg_offset, $twg_search_max);
        }
        $lang_views = "";
    } else {
        $imagelist = getTopXViews($dd);
    }
    // end get data

    $imageid = 0;

    if ($imagelist) {
        // start show first image bigger when topx
        if ($top10_type != "search") {
            $imageid = 1;
            // we twg_show nr 1 bigger
            if ($top10_type == "comments") {
                list ($cdatum, $cname, $ccomment, $clink) = explode("=||=", $imagelist[0]);
                $nameid = explode("-||-", $cname);
                $cname = $nameid[0];
                if (count($nameid) > 1) {
                    $ip = " - " . $nameid[1];
                }
                $imagelist[0] = sprintf("%010s", $cdatum) . "_" . $clink;
            }
            $src_value = str_replace("type=thumb", "type=small", $imagelist[0]);
            // the href value has to be encoded differently because the image is sent to
            // the index.php and not the image.php
            $href_image = substr($imagelist[0], 11);
            if ($use_original_on_topxpage) {
                $src_value_small = str_replace("type=thumb", "type=original", $href_image);
            } else {
                $src_value_small = str_replace("type=thumb", "type=small", $href_image);
            }
            $src_value_small = $twg_http_root . $src_value_small;
            $src_value_opt = opimizeSmallLink(substr($src_value, $offset + 1));

            $href_value = str_replace( $install_dir_view . 'image.php', getScriptName(), $href_image);
            $pos = strrpos($href_value, "=");
            $posimage = substr($href_value, $pos + 5);
            $href_value = str_replace(urlencode($posimage), $posimage, $href_value) . "&amp;twg_top10=" . $top10_type;
            // remove  type for index
            $href_value = str_replace('&amp;twg_type=thumb', '', $href_value);
            $href_value = tfu_seo_rewrite_url($href_value);

            $beschreibung = " alt='' title='' ";
            echo "<table summary='' class='thumbnails' cellpadding='1' cellspacing='1' onMouseOver='ShrinkToFit(\"topx1\", 1000, " . $thumb_pic_size * (1.5) . ")'>";
            echo "<tr><td class='thumbnails' onMouseOver=\"this.className='twg_hoverThumbnail'\" onMouseOut=\"this.className='twg_unhoverThumbnail'\">";

            if ($activate_lightbox_topx) {
                if (!$activate_lightbox_topx_full) {
                    echo "<div class='twg_magglas'><a href='" . $src_value_small . "' rel='lightbox[roadtrip]' " . $beschreibung . " ><img onMouseover='this.className=\"imagefull\";' onMouseout='this.className=\"imagealpha\";' class='imagealpha' src='" . $install_dir_view . "buttons/openlight.gif' width='18px' height='18px' alt=''></a></div>";
                    echo "<a href='" . $href_value . "'><img " . $beschreibung . " src='" . $src_value_opt . "' id='topx1' height='" . $thumb_pic_size * (1.5) . "' ></a>";
                } else {
                    echo "<a rel='lightbox[topx]' href='" . $src_value_small . "'><img " . $beschreibung . " src='" . substr($src_value, $offset + 1) . "' id='topx1' height='" . $thumb_pic_size * (1.5) . "' ></a>";
                }
            } else {
                echo "<a href='" . $href_value . "'><img " . $beschreibung . " src='" . $src_value_opt . "' id='topx1' height='" . $thumb_pic_size * (1.5) . "' ></a>";
            }
            echo "</td></tr></table>";

            echo '<span class="twg_caption">';
            if (($top10_type == "comments") && ($show_topx_comments_details)) {
                if ($cdatum != "") {
                    $image_date = "  <span class='twg_kommentar_date'>(" . date("j.n.Y G:i", $cdatum) . $ip . ")</span>";
                } else {
                    $image_date = "";
                }
                echo "<span class='twg_bold'>" . $cname . "</span>" . $image_date . "<br>" . $ccomment;
            } else {
                if ($top10_type == "comments") {
                    echo date("j.n.Y G:i", $cdatum . $ip);
                } else if ($top10_type == "average") {
                    echo sprintf('%3.2f', substr($src_value, 0, $offset));
                } else {
                    echo sprintf('%d', substr($src_value, 0, $offset));
                }
                echo $lang_views;
            }
            echo '</span>';
            echo '<br>&nbsp;<br>';
            // end show first image bigger when topx
        } else {
            if ($nrimages == 1) {
                if ($top10_type == "search" && $autojump_if_one_result) {
                    list ($cdatum, $cname, $ccomment, $clink) = explode("=||=", $imagelist[0]);
                    $nameid = explode("-||-", $cname);
                    $cname = $nameid[0];
                    if (count($nameid) > 1) {
                        $ip = " - " . $nameid[1];
                    }
                    $imagelist[0] = sprintf("%010s", $cdatum) . "_" . $clink;
                    $href_value = substr(str_replace( $install_dir_view . 'image.php', getScriptName(), $imagelist[0]), 11);
                    $href_value = str_replace("&amp;", "&", $href_value);
                    echo "<script>
              document.location='" . $href_value . "';
              </script>";
                    exit;
                }
            }
            echo sprintf($lang_search_hits, $nrimages);
            if ($nrimages > $twg_search_max) {
                // we show 1 | 2 | 3 ...
                echo "<br>";
                // add the parameters !!
                $actpage = 0;

                $s1 = $twg_search_term ? "twg_search_term=" . $twg_search_term : "";
                $s2 = $twg_search_caption ? "twg_search_caption=" . $twg_search_caption : "";
                $s3 = $twg_search_comment ? "twg_search_comment=" . $twg_search_comment : "";
                $s4 = $twg_search_filename ? "twg_search_filename=" . $twg_search_filename : "";
                $s5 = $twg_search_folders ? "twg_search_folders=" . $twg_search_folders : "";
                $s6 = $twg_search_tags ? "twg_search_tags=" . $twg_search_tags : "";
                $s7 = $twg_search_max ? "twg_search_max=" . $twg_search_max : "";
                $s8 = $twg_search_num ? "twg_search_num=" . $twg_search_num : "";
                $s9 = $twg_search_latest ? "twg_search_latest=" . $twg_search_latest : "";

                $twg_standalone .= "&amp;twg_top10=search&amp;" . $s1 . "&amp;" . $s2 . "&amp;" . $s3 . "&amp;" . $s4 . "&amp;" . $s5 . "&amp;" . $s6 . "&amp;" . $s7 . "&amp;" . $s8 . "&amp;" . $s9;
                $twg_standalonejs .= "&twg_top10=search&" . $s1 . "&" . $s2 . "&" . $s3 . "&" . $s4 . "&" . $s5 . "&" . $s6 . "&" . $s7 . "&" . $s8 . "&" . $s9;

                if ($twg_offset > 0) {
                    $hreflast = sprintf("%s?twg_album=%s&amp;twg_offset=%s%s", getScriptName(), $album_enc, $twg_offset - $twg_search_max, $twg_standalone);
                    $hreflastjs = sprintf("%s?twg_album=%s&twg_offset=%s%s", getScriptName(), $album_enc, $twg_offset - $twg_search_max, $twg_standalonejs);
                    echo '<script type="text/javascript"> function key_back() { location.href="' . $hreflastjs . '" } </script>';
                    printf(" <a href='%s'>%s</a>", $hreflast, $lang_thumb_back);
                }
                print " |";
                $numpages = ceil($nrimages / $twg_search_max);
                for ($i = 0; $i < $numpages; $i++) {
                    $twg_offset_ = $i * ($twg_search_max);
                    if ($twg_offset == $twg_offset_) {
                        $actpage = $i;
                        echo "<span class='twg_bold'>";
                    }
                    printf(" <a href='%s?twg_album=%s&amp;twg_offset=%s%s'>%s</a>", getScriptName(), $album_enc, $twg_offset_, $twg_standalone, $i + 1);
                    if ($twg_offset == $twg_offset_) {
                        echo "</span>";
                    }
                    echo " | ";
                }
                if ($actpage != $numpages - 1) {
                    $hrefnext = sprintf("%s?twg_album=%s&amp;twg_offset=%s%s", getScriptName(), $album_enc, $twg_offset + $twg_search_max, $twg_standalone);
                    $hrefnextjs = sprintf("%s?twg_album=%s&twg_offset=%s%s", getScriptName(), $album_enc, $twg_offset + $twg_search_max, $twg_standalonejs);
                    echo '<script type="text/javascript"> function key_foreward() { location.href="' . $hrefnextjs . '" } </script>';
                    printf(" <a href='%s'>%s</a>", $hrefnext, $lang_thumb_forward);
                }
            }
            echo "<br>&nbsp;<br>";
        }

        if (($top10_type == "comments") && ($show_topx_comments_details)) {
            $thumbnails_x = 2;
            $thumbnails_y = ceil((count($imagelist) - 1) / 2);
            if ($thumbnails_y > (($number_top10 - 1) / 2)) {
                $thumbnails_y = ceil(($number_top10 - 1) / 2);
            }
            $minus_rows = 0;
        }

        if ($top10_type == "search") {
            if ($show_topx_search_details) {
                $thumbnails_y = ceil(count($imagelist) / 2);
                // max detection here !!
                $thumbnails_x = 2;
            } else {
                $thumbnails_y = ceil(count($imagelist) / $thumbnails_x);
            }
            $minus_rows = 0;
        }
        // we show the remaining pictures
        if ((($top10_type == "comments") && ($show_topx_comments_details)) || ($top10_type == "search")) {
            if ($show_topx_search_details || (($top10_type == "comments") && ($show_topx_comments_details))) {
                $extraheight = "style='height:" . ($thumbnails_y * ($thumb_pic_size)) . "px;'";
            } else {
                $extraheight = "style='height:" . ($thumbnails_y * ($thumb_pic_size + 55)) . "px;'";
                ;
            }
            echo "<table summary='' class='thumbnails_top10' " . $extraheight . " cellpadding='0' cellspacing='0'>\n";
        } else {
            echo "<table summary='' style='border:4px #777777;'  class='thumbnails' cellpadding='0' cellspacing='0'>\n";
        }

        for ($i = 0; $i < $thumbnails_y - $minus_rows; $i++) {
            print "<tr>";
            for ($j = 0; $j < $thumbnails_x; $j++) {
                if (($imageid >= count($imagelist)) /* || ($imageid >= $number_top10 && $top10_type != "search") */) { // we fill the last line to get a nice layout
                    printf("<td class=twg></td>"); // class='left_top10'
                } else {
                    if (($top10_type == "comments") || ($top10_type == "search")) {
                        list ($cdatum, $cname, $ccomment, $clink) = explode("=||=", $imagelist[$imageid]);
                        $nameid = explode("-||-", $cname);
                        $cname = $nameid[0];
                        if (count($nameid) > 1) {
                            $ip = " - " . $nameid[1];
                        }
                        $imagelist[$imageid] = sprintf("%010s", $cdatum) . "_" . $clink;
                        if (($top10_type == "search")) {
                            // we check and replace foldername.txt !
                            $ccomment = html_entity_decode_fixed(getDirectoryName($basedir . "/" . $ccomment, $ccomment), ENT_NOQUOTES, $charset);
                        }
                    }

                    $src_value = $imagelist[$imageid];
                    // the href value has to be encoded differently because the image is sent to
                    // the index.php and not the image.php
                    if ($use_original_on_topxpage) {
                        $src_value_small = substr(str_replace("type=thumb", "type=original", $src_value), 11);
                    } else {
                        $src_value_small = substr(str_replace("type=thumb", "type=small", $src_value), 11);
                    }
                    $src_value_small = $twg_http_root . $src_value_small;
                    $href_value = substr(str_replace( $install_dir_view . "image.php", getScriptName(), $imagelist[$imageid]), 11);
                    $pos = strrpos($href_value, "=");
                    $posimage = substr($href_value, $pos + 5);
                    if (strpos($src_value, "isalbum")) {
                        $href_value = str_replace(urlencode($posimage), $posimage, $href_value);
                    } else {
                        $href_value = str_replace(urlencode($posimage), $posimage, $href_value) . "&amp;twg_top10=" . $top10_type;
                    }
                    // remove  type for index
                    $href_value = str_replace('&amp;twg_type=thumb', '', $href_value);
                    $href_value = tfu_seo_rewrite_url($href_value);
                    $beschreibung = " alt='' title='' ";
                    if ((($top10_type == "comments") && ($show_topx_comments_details)) || (($top10_type == "search") && ($show_topx_search_details))) {
                        if ($cdatum != "") {
                            $image_date = "  <span class='twg_kommentar_date'>(" . date("j.n.Y G:i", $cdatum) . $ip . ")</span>";
                        } else {
                            $image_date = "";
                        }
                        $count_str = "<span class='twg_bold'>" . $cname . "</span>" . $image_date . "<br>" . $ccomment;
                    } else if ($top10_type == "comments") {
                        $count_str = date("j.n.Y G:i", $cdatum . $ip);
                    } else if ($top10_type == "average") {
                        $count_str = sprintf('%3.2f', substr($src_value, 0, $offset));
                    } else if ($top10_type == "search") {
                        if ($cdatum != "") {
                            $image_date = "  <span class='twg_kommentar_date'>(" . date("j.n.Y G:i", $cdatum) . $ip . ")</span><br>";
                            $spacer = "";
                        } else {
                            $image_date = "";
                            $spacer = "<br>&nbsp;";
                        }

                        $strip_name = optimize_strip($cname, $showcharacters);
                        $strip_comment = optimize_strip($ccomment, $showcharacters);

                        $count_str = $image_date . "<span class='twg_bold'>" . $strip_name . "</span>" . "<br>" . $strip_comment . $spacer;
                    } else {
                        $count_str = sprintf('%d', substr($src_value, 0, $offset));
                    }

                    if ($show_clipped_images) {
                        $theight = " height='" . $thumb_pic_size . "' width='" . $thumb_pic_size . "' ";
                    } else {
                        $theight = "";
                    }

                    if ((($top10_type == "comments") && ($show_topx_comments_details)) || (($top10_type == "search") && $show_topx_search_details)) {
                        if ($show_clipped_images) {
                            $defineheight = "width:" . ($thumb_pic_size + 2) . "px; height:" . ($thumb_pic_size + 4) . "px;";
                        } else {
                            $defineheight = "width:" . ($thumb_pic_size + 2) . "px;";
                        }

                        if (strpos($src_value, "isalbum")) {
                            $src_value_image = $install_dir_view . "buttons/ordner.gif";
                            $activate_lightbox_topx = false;
                            $half = $thumb_pic_size / 2;
                            $leftpad = $half - 27;
                            $rightpad = $half - 28;
                            $toppad = $half - 23;
                            $bottompad = $half - 24;
                            $theight = " style='padding-top:" . $toppad . "px;padding-bottom:" . $bottompad . "px;padding-left:" . $leftpad . "px;padding-right:" . $rightpad . "px;' ";
                        } else {
                            $src_value_image = substr($src_value, 11);
                            $activate_lightbox_topx = $activate_lightbox_topx_tmp;
                        }

                        $src_value_image = opimizeLink($src_value_image);
                        echo "<td class='left_top10'>
		                     <table summary='' class='thumbnails_top10' cellpadding='1' cellspacing='1'><tr><td style='text-align:center;" . $defineheight . "' class='thumbnails_top10' onMouseOver=\"this.className='twg_hoverThumbnail'\" onMouseOut=\"this.className='twg_unhoverThumbnail'\">";
                        if ($activate_lightbox_topx) {
                            if (!$activate_lightbox_topx_full) {
                                echo "<div class='twg_magglas'><a href='" . $src_value_small . "' rel='lightbox[roadtrip]' " . $beschreibung . " ><img onMouseover='this.className=\"imagefull\";' onMouseout='this.className=\"imagealpha\";' class='imagealpha' src='" . $install_dir_view . "buttons/openlight.gif' width='18px' height='18px' alt=''></a></div>";
                                echo "<a href='" . $href_value . "'><img " . $beschreibung . $theight . " src='" . $src_value_image . "'  ></a>";
                            } else {
                                echo "<a rel='lightbox[topx]' href='" . $src_value_small . "'><img " . $beschreibung . $theight . " src='" . $src_value_image . "'  ></a>";
                            }
                        } else {
                            echo "<a href='" . $href_value . "'><img " . $beschreibung . $theight . " src='" . $src_value_image . "'  ></a>";
                        }
                        echo '</td><td class="thumbnails_top10" ><span class="twg_caption">' . $count_str . '</span></td></tr></table></td>';
                    } else {
                        $extrastyle = "style='vertical-align:top;'";
                        echo "<td class='thumbnails' " . $extrastyle . ">
		                     <table summary='' class='thumbnails' cellpadding='1' cellspacing='1'><tr><td class='thumbnails' onMouseOver=\"this.className='twg_hoverThumbnail'\" onMouseOut=\"this.className='twg_unhoverThumbnail'\">";

                        if (strpos($src_value, "isalbum")) {
                            $activate_lightbox_topx = false;
                        } else {
                            $activate_lightbox_topx = $activate_lightbox_topx_tmp;
                        }

                        if ($activate_lightbox_topx) {
                            $src_value_image = opimizeLink(substr($src_value, 11));
                            if (!$activate_lightbox_topx_full) {
                                echo "<div class='twg_magglas'><a href='" . $src_value_small . "' rel='lightbox[roadtrip]' " . $beschreibung . " ><img onMouseover='this.className=\"imagefull\";' onMouseout='this.className=\"imagealpha\";' class='imagealpha' src='" . $install_dir_view . "buttons/openlight.gif' width='18px' height='18px' alt=''></a></div>";
                                echo "<a href='" . $href_value . "'><img " . $beschreibung . $theight . " src='" . $src_value_image . "'  ></a>";
                            } else {
                                echo "<a rel='lightbox[topx]' href='" . $src_value_small . "'><img " . $beschreibung . $theight . " src='" . $src_value_image . "'  ></a>";
                            }
                        } else {
                            if (strpos($src_value, "isalbum")) {
                                $src_value_image = $install_dir_view . "buttons/ordner.gif";
                                $half = $thumb_pic_size / 2;
                                $leftpad = $half - 27;
                                $rightpad = $half - 28;
                                $toppad = $half - 23;
                                $bottompad = $half - 24;
                                $theight = " width='57px' height='47px' style='padding-top:" . $toppad . "px;padding-bottom:" . $bottompad . "px;padding-left:" . $leftpad . "px;padding-right:" . $rightpad . "px;' ";
                            } else {
                                $src_value_image = substr($src_value, 11);
                            }
                            $src_value_image = opimizeLink($src_value_image);
                            echo "<a href='" . $href_value . "'><img " . $beschreibung . $theight . " src='" . $src_value_image . "'  ></a>";
                        }
                        echo '</td></tr></table><span class="twg_caption">' . $count_str . $lang_views . '</span></td>';
                    }
                }
                $imageid++;
            }
            print "</tr>\n";
        }
        if ($top10_type == "search") {
            // echo "<tr><td style='height:" . $thumb_pic_size . "px;'>&nbsp;</td><td>&nbsp;</td></tr>";
        }
        print "</table>\n";
    } else { // if we on't have anything we twg_show an empty image :)
        echo "<img src='" . $install_dir_view . "buttons/1x1.gif' width='200' height='100' alt='' ><br>";
        echo '<span class="no_topx_images">' . $lang_no_topx_images . "</span>";
    }
    echo '</div>';
}

/*
  truncated a string to a certain length - if a blank or _ or .  comes in the next 3 characters the cut is done later!
  baad function - I have to reimplement this ;)
*/
function optimize_strip($value, $showcharacters)
{
    global $charset;

    if (isset ($charset)) {
        $charsetloc = $charset;
    } else {
        $charsetloc = "ISO-8859-15";
    }
    $extra_limit = 3;
    set_error_handler("on_error_no_output"); // is needed because error are most likly but we don't care about fields we don't even know
    $stripped_value = html_entity_decode_fixed(str_replace("<br>", " - ", strip_tags($value, "<br>")), ENT_NOQUOTES, $charsetloc);
    set_error_handler("on_error");
    // length greater then the extra bonus!
    if (strlen($stripped_value) < $showcharacters + $extra_limit) {
        $showcharacters += $extra_limit;
    } else {
        $pos = strpos($stripped_value, " ", $showcharacters - 2);
        if ($pos === false) {
            $pos = strpos($stripped_value, ".", $showcharacters - 2);
            if ($pos === false) {
                $pos = strpos($stripped_value, "_", $showcharacters - 2);
                if ($pos === false) {
                } else {
                    if ($pos < $showcharacters + $extra_limit) {
                        $showcharacters = $pos;
                    }
                }
            } else {
                if ($pos < $showcharacters + $extra_limit) {
                    $showcharacters = $pos;
                }
            }
        } else {
            if ($pos < $showcharacters + $extra_limit) {
                $showcharacters = $pos;
            }
        }
    }
    return htmlentities(substr($stripped_value, 0, $showcharacters), ENT_NOQUOTES, $charsetloc);
}

?>