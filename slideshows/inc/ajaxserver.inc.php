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
require dirname(__FILE__) . '/../language/language_default.php';
require dirname(__FILE__) . '/../language/language_' . $default_language . '.php';

set_error_handler("on_error_no_output"); // this is needed for the bulgarian language file - seems to be stored with an error I cannot fix on my system.
if (isset($charset)) {
    header("Content-Type: text/plain; charset=" . $charset);
}
set_error_handler("on_error");

if ($twg_album) {
    $path = $basedir . "/" . $twg_album;
} else {
    $path = $basedir;
    $album_enc = "";
    $twg_album = "";
}
$spacer = "|___|";
if ($dataXmlHttp) {
    $returnVal = "";
    // we create the playlist ... should work like a stream but without streaming server!
    if ($video_dir && $linktowvx) {
        if ($video_player == "WMP" && $video_flash_site != "http://" && $linktowvx) {
            $embedstring = $path . "/" . $image . ".wvx";
            createWVX($embedstring, $twg_album, $image);
        }
    }
    if ($video_player == "MP3") {
        createMp3Xml($cachedir . "/audiolist.xml", $twg_album, $image, $install_dir_save);
    }
    $install_dir = $install_dir_save;
    // beschreibung
    // encoding on some server do not work with  - have to check this!
    $data = replacesmilies(getBeschreibung(urlencode($image), $werte, $index)); // the encode is a fix right now - has to be made nice sometimes !!
    $data1 = str_replace("||", "&nbsp;<br>&nbsp;", $data);
    $returnVal .= $data1 . $spacer;
    // comment!
    $comment_xmlhttp = str_replace("image.php", "index.php", getKommentar($image, $twg_album, $kwerte, $kindex, false));
    $install_dir = '';
    $returnVal .= $comment_xmlhttp . $spacer;
    // viewcounter
    $counter = "";
    if ($show_count_views) {
        $counter = increaseImageCount($twg_album, $image);
    }
    $returnVal .= $counter . $spacer;
    // direct
    $direct = "";
    if ($enable_download || $video_player == 'DIVX' || $video_player == 'FLV' || $video_player == 'QT') {
        $isset = false;
        $remote = twg_checkUrl($path);
        foreach ($other_file_formats as $label => $key) {
            $other_format = exchangeExtension($path . "/" . $image, $label);
            if (file_exists($other_format)) {
                if (filesize($other_format) > 0) {
                    $direct = twg_urlencode($other_format);
                } else if ($video_flash_site != "" && $video_player == "MP3") {
                    $direct = $video_flash_site . removePrefix(exchangeExtension(urldecode($image), "mp3"));
                }
                $isset = true;
            } else if ($remote) {
                // we have to check remote as well.
                $moviename = dirname(__FILE__) . '/' . $remote . (exchangeExtension(urldecode($image), $label));
                if (file_exists($moviename)) {
                    $depth = count(explode('/', $twg_album)) + 1;
                    $prefix = '';
                    for ($i = 0; $i < $depth; ++$i) {
                        $prefix .= '../';
                    }
                    $direct = fixUrl($path . '/' . $prefix . $remote) . (exchangeExtension(urldecode($image), $label));
                    $isset = true;
                }
            }
        }

        if (!$isset) {
            $other_format = removeExtension($path . "/" . $image);
            if (file_exists($other_format)) {
                $direct = twg_urlencode($other_format);
                $isset = true;
            }
        }

        if (!$isset) {
            if ($video_flash_site != "" && $video_player == "MP3") {
                $direct = $video_flash_site . removePrefix(exchangeExtension(urldecode($image), "mp3"));
                $isset = true;
            }
        }
        if (!$isset) {
            if ($video_flash_site == "http://" && $video_player == "WMP") {
                $direct = $video_flash_site . urldecode(removeExtension(replace_url_chars(urldecode($image))));
                $isset = true;
            }
        }

        if (!$isset) {
            if ($enable_direct_download) {
                $direct = $path . "/" . $image;
            } else {
                $direct = "false";
            }
        }
    }
    $returnVal .= $direct . $spacer;

    // rating
    $rating = "";
    if ($show_image_rating && ($image_rating_position != "menu")) {
        $rating = substr(getVotesCount($twg_album, $image), 0, 4);
        $rating = round($rating * 20);
    }
    if ($dynamic_image_txt) {
        $imagetext = hasImagepageDescription($path);
        if ($imagetext) {
            echo $returnVal . $rating . $spacer;
            includeImagepageDescription($path);
            echo $spacer;
            includeImagepageDescription2($path);
        } else {
            echo $returnVal . $rating . $spacer . $spacer;
        }
    } else {
        echo $returnVal . $rating . $spacer . $spacer;
    }
} else if ($browserNoJS) {
    $_SESSION['twg_nojs'] = 'TRUE';
    echo " ";
    return;
} else if ($browserXmlHttp) { // browserhttp
    // set the resolution of the browser in the session !!
    if (isset($_GET["twg_browserx"])) {
        if (!is_array($_GET["twg_browserx"])) {
          $_SESSION[$GLOBALS["standalone"] . "browserx_res"] = $_GET["twg_browserx"] - 75;
        }
        if (!is_array($_GET["twg_browsery"])) {
          $_SESSION[$GLOBALS["standalone"] . "browsery_res"] = $_GET["twg_browsery"] - 75;
        }
        if (isset($_GET["fontscale"])) {
            if (!is_array($_GET["fontscale"])) {
                $_SESSION["fontscale"] = $_GET["fontscale"];
            }
        }
    }
    $_SESSION["twg_XMLHTTP"] = "TRUE";
    echo " ";
} else if ($precachexml) {
    // $install_dir = $install_dir_save;
    $is_cache_call = true;
    $enable_smily_support = false; // we don't need to replace something in a cache call.
    if (isset($_SESSION['create_album_tree_cache'])) {
        $treebase = $basedir;
        if ($multi_root_mode && $twg_album) {
            $elements = explode("/", $twg_album, 1);
            $treebase = $basedir . '/' . $elements[0];
        }
        print_js_tree($treebase);
    }
    $createcache = true;
    if (isset($_SESSION["count_treec" . $install_dir . $basedir])) {
        $createcache = $_SESSION["count_treec" . $install_dir . $basedir] > $precache_main_top_x_limit;
    }
    $dd = get_view_dirs($basedir, "");
    if (generate_piclens_rss($dd, "")) {
        if ($cache_dirs && $precache_main_top_x && $createcache) { // we check if all caches are build!
            if (getTopXViews($dd))
                if (getLatestKomments($dd))
                    if (getTopXDownloads($dd))
                        if (getTopXVotes($dd))
                            if (getTopXAverage($dd)) {
                                if ($precache_topx_additional_dirs != "") {
                                    $ddirs = explode(",", $precache_topx_additional_dirs);
                                    foreach ($ddirs as $cachedd) {
                                        $checkdir = $basedir . "/" . $cachedd;
                                        if (file_exists($checkdir)) {
                                            $dd = get_view_dirs($checkdir, "");
                                            if (!getTopXViews($dd)) {
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
        }
    }
    if ($precache_xml_data) {
        $precache_xml = true;
        count_tree($basedir);
    }
} else if ($menuXmlHttp) {
    // store the menu decicion!
    $_SESSION["TWG_MENU_STATUS"] = $_GET["twg_menustatus"];
} else if ($menuXmlAutohide) {
    // store the menu decicion!
    $_SESSION["TWG_AUTOHIDE"] = $_GET["twg_autohide"];
} else {
}
?>