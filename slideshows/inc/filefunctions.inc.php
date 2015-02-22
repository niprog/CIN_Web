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
// This setting shows some more errors on some systems - it is in comments because on some systems
// this does not work at all and throws errors! therefore only uncomment this if I told you ;).
/*
  ini_set("display_errors","On");
  error_reporting (E_ALL);
*/

// a own error handler is registered.
@ini_set('display_errors', 'On');
set_error_handler("on_error");

@ob_start();
include dirname(__FILE__) . '/twg_zip.class.php';
@ob_end_clean();

$precache_xml = false;
$precache_xml_num = 0;
/*
   Counts the number of jpegs in all trees - this it the string that saves the result
*/
$count_cache_global = "";

function cleanup_cache()
{
    global $cache_time, $cache_clean_thumbs; // in days !!
    global $extension_slideshow, $extension_thumb;
    global $extension_small, $use_cache_with_dir;
    global $remove_1_day_data, $precache_main_top_x_interval;
    // we only check the cache once per session and day!
    // + we do this check at the 2nd call because at the 1st call many stuff is already done.
    if (isset($_SESSION['checkcache'])) {
        return;
    }
    $_SESSION['checkcache'] = "TRUE";

    // we check the topx cache more often if value != -1
    if ($precache_main_top_x_interval != -1) {
        set_error_handler("on_error_no_output"); // @does not work
        $today_topx = $GLOBALS['cachedir'] . "/_cache_h_topx.tmp";
        if (!file_exists($today_topx)) {
            $fh = fopen($today_topx, 'w');
            fclose($fh);
        }
        $del_time = time() - ($precache_main_top_x_interval * 3600);
        $mtime = filemtime($today_topx);
        if ($mtime < $del_time) {
            $tmp_files = twg_glob($GLOBALS['cachedir'] . "/_t_*.tmp.php");
            if ($tmp_files) {
                foreach ($tmp_files as $fn) {
                    @unlink($fn);
                }
            }
            $tmp_files = twg_glob($GLOBALS['cachedir'] . "/*.rss");
            if ($tmp_files) {
                foreach ($tmp_files as $fn) {
                    @unlink($fn);
                }
            }
            @unlink($today_topx);
            $fh = fopen($today_topx, 'w');
            fclose($fh);
        }
        set_error_handler("on_error");
    }

    // we only check the cache once per day!
    $today = $GLOBALS['cachedir'] . "/_cache_day_" . date("Y_m_d") . ".tmp";
    if (file_exists($today)) {
        return;
    }
    if ($remove_1_day_data) {
        remove_tmp_files(false, true); // once a day!
    }
    if (file_exists($GLOBALS['cachedir'] . "/counter.png")) {
        set_error_handler("on_error_no_output"); // @does not work
        @unlink($GLOBALS['cachedir'] . "/counter.png");
        set_error_handler("on_error");
    }
    if ($cache_time == -1) {
        $fh = fopen($today, 'w');
        fclose($fh);
        return;
    }
    set_error_handler("on_error_no_output"); // @does not work


    $cache_time = $cache_time * 86400;
    $del_time = time() - $cache_time;
    if (file_exists($GLOBALS['cachedir'])) {
        if (!$use_cache_with_dir) {
            $cache_check = $GLOBALS['cachedir'] . "/_last_cache_check.tmp";
            if (file_exists($cache_check)) {
                $ctime = fileatime($cache_check);
            } else {
                $ctime = 0;
            }
            if ($ctime < $del_time || !file_exists($cache_check)) {
                $d = opendir($GLOBALS['cachedir']);
                $i = 0;
                $timeequal = 0;
                while (false !== ($entry = readdir($d))) {
                    if (stristr($entry, $extension_slideshow) || stristr($entry, $extension_small) || ($cache_clean_thumbs && stristr($entry, $extension_thumb))) {
                        $atime = fileatime($GLOBALS['cachedir'] . '/' . $entry);
                        $mtime = filemtime($GLOBALS['cachedir'] . '/' . $entry);
                        if ($atime != $mtime) { // atime seems to return a value != the creation time - if both are equal we don't cleanup the file
                            if ($atime < $del_time) {
                                $timeequal = 0;
                                @unlink($GLOBALS['cachedir'] . '/' . $entry);
                            }
                        } else {
                            if ($timeequal++ > 10) { // if 10 files don't return a different timestamp I assume that none of them do. Because I do touch the file this time and the next time it timestamp should be changed if fileatime works 
                                break;
                            }
                        }
                    }
                }
                closedir($d);
                $fh = fopen($cache_check, 'w');
                fclose($fh);
            }
            $fh = fopen($today, 'w');
            fclose($fh);
        }
    } else {
        echo 'Cannot find the cache directory at "' . $GLOBALS['cachedir'] . '" - please check your configuration.';
    }
    set_error_handler("on_error");
}

$n = get_server_name();

function count_tree($file_dir, $issize = false)
{
    global $url_file;
    global $cache_dirs, $basedir;
    global $exclude_directories;
    global $precache_xml;
    global $precache_xml_num;
    global $show_changes, $cachedir;
    global $is_cache_call, $basedir, $count_cache_global;

    $count_cache = "";
    if ($file_dir == $basedir && !$cache_dirs) {
        return;
    } else if ($file_dir == $basedir) {
        $count_cache_global = "";
    }
    $cachename_global = $cachedir . "/_count_tree_all" . $GLOBALS["standalone"] . ".tmp.php";
    if ($issize) {
        $prefix = "s";
    } else {
        $prefix = "c";
    }

    if (!isset($_SESSION["cache_xml_" . $file_dir]) && $cache_dirs) {
        if ($precache_xml && $is_cache_call) {
            $cache_alb = substr($file_dir, strlen($basedir) + 1);
            getDownloadCount($cache_alb, false);
            loadXMLFiles($cache_alb);
            $_SESSION["cache_xml_" . $file_dir] = "true";
            if ($precache_xml_num++ > 30) { // we only cache 30 xml files at once!
                $precache_xml = false;
            }
        }
    }
    $localfiles = 0;
    if (isset($_SESSION["count_tree" . $prefix . $file_dir]) && $cache_dirs && !$is_cache_call) {
        return $_SESSION["count_tree" . $prefix . $file_dir];
    } else if (file_exists($cachename_global) && $cache_dirs && !$is_cache_call && cache_seems_ok($cachename_global)) {
        include $cachename_global;
        if (isset($_SESSION["count_tree" . $prefix . $file_dir])) {
            return $_SESSION["count_tree" . $prefix . $file_dir];
        } else {
            // a cache is missing for this directory - therefore we refresh it!
            @unlink($cachename_global);
            return '';
        }
    } else {
        // we check if a directory is newer than X days and store it if this is the case
        // we check if we have a config in this folder if there is an show_changes in there;

        $show_changes_save = $show_changes;
        if (file_exists($file_dir . "/config_new.php")) {
            include ($file_dir . "/config_new.php");
        }
        $comp_time = time() - (86400 * $show_changes);

        if ($show_changes > 0 && !$is_cache_call) {
            if (!isset($_SESSION["new_tree"])) {
                $_SESSION["new_tree"] = array();
            }
            if (filemtime($file_dir) > $comp_time) {
                $found_new_file = true;
                if (!in_array($file_dir, $_SESSION["new_tree"])) {
                    $_SESSION["new_tree"][] = $file_dir;
                    if ($cache_dirs) {
                        $count_cache .= '$_SESSION["new_tree"][] = "' . $file_dir . '";';
                    }
                }
                // we have to add upper dirs too :).
                $file_dir_work = $file_dir;
                while (true) {
                    $ud = getupperdirectory($file_dir_work);
                    if ($ud != "") {
                        if (!in_array($ud, $_SESSION["new_tree"])) {
                            $_SESSION["new_tree"][] = $ud;
                            if ($cache_dirs) {
                                $count_cache .= '$_SESSION["new_tree"][] = "' . $ud . '";';
                            }
                        }
                    }
                    if ($file_dir_work == $ud) break;
                    $file_dir_work = $ud;
                }
            }
        }

        if ($handle = @opendir($file_dir)) {
            $list = get_file_list($handle, $file_dir);
            $dir_length = count($list);
            $found_new_file = false;
            for ($i = 0; $i < $dir_length; $i++) {
                if (isset($list[$i])) {
                    if (is_dir($file_dir . '/' . $list[$i])) {
                        if (!in_array($list[$i], $exclude_directories)) {
                            $localfiles += count_tree($file_dir . '/' . $list[$i], $issize);
                        }
                    } else {
                        if (is_supported_image($list[$i]) && !$is_cache_call) {
                            $item = $file_dir . '/' . $list[$i];
                            if (!file_exists($item) || filesize($item) > 0) {
                                if ($issize) {
                                    set_error_handler("on_error_no_output"); // is needed because error are most likly but we don't care about fields we don't even know
                                    $localfiles += @filesize($item);
                                    set_error_handler("on_error");
                                } else {
                                    $localfiles++;
                                }
                                // we check if a file in this directory is newer than 7 days and store it if this is the case
                                if ($show_changes > 0 && !$found_new_file) { // we only do this once in a directory!
                                    set_error_handler("on_error_no_output");
                                    $file_time = @filemtime($item);
                                    set_error_handler("on_error");
                                    if ($file_time) {
                                        if ($file_time > $comp_time) {
                                            $found_new_file = true;
                                            if (!in_array($file_dir, $_SESSION["new_tree"])) {
                                                $_SESSION["new_tree"][] = $file_dir;
                                                if ($cache_dirs) {
                                                    $count_cache .= '$_SESSION["new_tree"][] = "' . $file_dir . '";';
                                                }
                                            }
                                            // we have to add upper dirs too :).
                                            $file_dir_work = $file_dir;
                                            while (true) { // TODO - bad implementation - redesign!
                                                $ud = getupperdirectory($file_dir_work);
                                                if ($ud != "") {
                                                    if (!in_array($ud, $_SESSION["new_tree"])) {
                                                        $_SESSION["new_tree"][] = $ud;
                                                        if ($cache_dirs) {
                                                            $count_cache .= '$_SESSION["new_tree"][] = "' . $ud . '";';
                                                        }
                                                    }
                                                }
                                                if ($file_dir_work == $ud) break;
                                                $file_dir_work = $ud;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            closedir($handle);
        }
    }
    if ($cache_dirs && !$is_cache_call) {
        $_SESSION["count_tree" . $prefix . $file_dir] = $localfiles;
        $count_cache .= '$_SESSION["count_tree' . $prefix . $file_dir . '"] = ' . $localfiles . ';';
        $count_cache_global .= $count_cache;
        if ($file_dir == $basedir) {
            $fh = fopen($cachename_global, 'w');
            fwrite($fh, "<?php " . $count_cache_global . " ?>");
            fclose($fh);
        }
    }
    $show_changes = $show_changes_save;
    return $localfiles;
}


/*
  we check if the cache looks ok - we count the numer of "= 0;" - if we have more than 10 empty
  dirs I assume all counters are 0 and I delete the cache file.
*/
function cache_seems_ok($cachename_global)
{
    $text = getFileContent($cachename_global, ""); // read the first 1000 bytes
    $values = explode('= 0;', $text);
    if (count($values) > 10) {
        if (isset($GLOBALS["DEBUG_CACHE"])) {
            debug("Counter cache seems corrupt or you have more than 10 empty directories : " . $text);
        }
        @unlink($cachename_global);
        return false;
    } else {
        return true;
    }
}


/*
   Search
*/
function search_filenames($file_dir, $searchstring, $dd)
{
    global $url_file;
    global $twg_standalone;
    global $basedir;
    global $install_dir;
    global $exclude_directories;
    global $install_dir_view;

    $topx = array();
    if ($searchstring == "") { // empty string does give no hits
        return $topx;
    }
    // echo "<br>searching " . $file_dir;
    if ($handle = @opendir($file_dir)) {
        $list = get_file_list($handle, $file_dir);
        $dir_length = count($list);
        // echo "<ul>";
        for ($i = 0; $i < $dir_length; $i++) {
            // if (strrpos($list[$i], '.') == false) {
            if (isset($list[$i])) {
                $full_dir = $file_dir . '/' . $list[$i];
                if (is_dir($full_dir)) {
                    if (!in_array($list[$i], $exclude_directories)) {
                        $result = search_filenames($file_dir . '/' . $list[$i], $searchstring, $dd);
                        if (count($result > 0)) {
                            $topx = array_merge($topx, $result);
                        }
                    }
                } else {
                    // $album = substr($full_dir, strlen($basedir) + 1);
                    $album = substr($file_dir, strlen($basedir) + 1);
                    if (is_supported_image($list[$i]) && in_array($album, $dd)) {
                        if (!file_exists($file_dir . '/' . $list[$i]) || filesize($file_dir . '/' . $list[$i]) > 0) {
                            if (stristr($list[$i], $searchstring)) {
                                $album = substr($file_dir, strlen($basedir) + 1);
                                $datum = filectime($file_dir . '/' . $list[$i]);
                                $name = @htmlentities(restore_plus(urldecode(replace_plus($list[$i])))); // fix for some server
                                $komment = @htmlentities($album);
                                $line = $datum . "=||=" . $name . "=||=" . $komment;
                                // the decode at the end is important - if you remove them images with hard filenames are not displayed :).
                                $compare = $line . "=||=" . $install_dir_view . "image.php?twg_album=" . urlencode($album) . "&amp;twg_type=thumb&amp;twg_show=" . urlencode($list[$i]) . $twg_standalone;
                                // echo $compare;
                                $topx[] = $compare;
                            }
                        }
                    }
                }
            }
        }
        // echo "</ul>";
        closedir($handle);
    }
    return $topx;
}

/*
returns all directories that can be included into the top x views
*/
function get_view_dirs($file_dir, $pass, $depthlevel = 0)
{
    global $privatepassword, $password_file, $cachedir, $depthlevel, $install_dir;
    global $basedir, $exclude_directories, $cache_dirs, $serialize_dir_data;
    global $url_file;

    $dirs = array();
    $hasimage = false;
    // cache from session
    if (isset($_SESSION["get_view_dirs_" . $file_dir . $pass]) && $cache_dirs) {
        return $_SESSION["get_view_dirs_" . $file_dir . $pass];
    }
    // cache from file
    if ($serialize_dir_data && $cache_dirs) {
        $dirhash = sha1($file_dir . $pass);
        $cachename = $cachedir . "/_t_vd_" . $dirhash . ".tmp.php";
        if (file_exists($cachename)) {
            $data = getFileContent($cachename, "");
            $unserdata = @unserialize($data);
            if ($unserdata) {
                if (!isset($no_session_cache)) {
                    $_SESSION["get_view_dirs_" . $file_dir . $pass] = $unserdata;
                }
                return $unserdata;
            } else {
                // delete invalid cache.
                @unlink($cachename);
            }
        }
    }

    if (!file_exists($file_dir)) {
        return $dirs;
    }
    // we check a maximum level of 10 to avoid recursive lookup
    if ($depthlevel > 10) {
        return $dirs;
    }
    if ($handle = @opendir($file_dir)) {
        $i = 0;
        $list = array();
        while (false !== ($file = @readdir($handle))) {
            if ($file != '.' && $file != "..") {
                if (!check_image_extension($file)) {
                    $list[$i] = $file;
                    $i++;
                } else {
                    $hasimage = true;
                }
            }
            if ($file == "folderlink.txt") {
                $hasimage = false;
                break;
            }
            if ($file == $url_file) {
                $hasimage = true;
                break;
            }
        }
        $dir_length = count($list);
        $goon = false;
        if ($dir_length > 0 || $hasimage) {
            // if (in_array ($password_file, $list)) {
            $passwd = read_passwort_file($file_dir, $basedir);
            if ($passwd !== false) {
                if (in_array($pass, $passwd)) {
                    $goon = true;
                }
            } else {
                $goon = true;
            }
        }
        if ($goon && $hasimage) {
            $dirs = array(substr($file_dir, strlen($basedir) + 1));
            // echo substr($file_dir, strlen($basedir) + 1);
        }

        for ($i = 0; $i < $dir_length; $i++) {
            if (is_dir($file_dir . '/' . $list[$i]) && ($list[$i] != $password_file) && $goon && (!in_array($list[$i], $exclude_directories))) {
                $localdirs = get_view_dirs($file_dir . '/' . $list[$i], $pass, $depthlevel + 1);
                if ($dirs) {
                    $dirs = array_merge($dirs, $localdirs);
                } else {
                    $dirs = $localdirs;
                }
            }
        }
        closedir($handle);
    }
    if ($cache_dirs && !isset($no_session_cache)) {
        $_SESSION["get_view_dirs_" . $file_dir . $pass] = $dirs;
    }
    if ($serialize_dir_data && $cache_dirs && (count($dirs) > 1)) {
        if (file_exists(basename($cachename))) {
            $ser_file = fopen($cachename, 'w');
            fputs($ser_file, serialize($dirs));
            fclose($ser_file);
        }
    }
    return $dirs;
}

function getDirectoryDescription($directory, $only_default = false)
{
    global $enable_folderdescription, $cache_dirs, $default_language;

    if ($enable_folderdescription) {
        if (isset($_SESSION['twg_tmp']["getdirdesc" . $default_language . $directory]) && $cache_dirs && !$only_default) {
            return $_SESSION['twg_tmp']["getdirdesc" . $default_language . $directory];
        } else {
            // we check for a languagedepentent file  first !
            $filename = $directory . '/folder_' . $default_language . '.txt';
            if ($only_default || !file_exists($filename)) {
                $filename = $directory . '/folder.txt';
            }
            $retvalue = false;
            if (file_exists($filename)) {
                $text = trim(file_get_contents($filename));
                $retvalue = ($text != '') ? $text : false;
            }
            $_SESSION['twg_tmp']["getdirdesc" . $default_language . $directory] = $retvalue;
            return $retvalue;
        }
    } else
        return false;
}

function includeImagepageDescription($directory)
{
    return includeImagepageDescription_($directory);
}

function includeImagepageDescription2($directory)
{
    return includeImagepageDescription_($directory, '2');
}

function includeImagepageDescription_($directory, $num = '')
{
    global $enable_folderdescription, $install_dir;
    global $image_file_extension, $basedir;
    global $image, $twg_album, $image_file_is_multi;
    global $extension_small, $extension_thumb;
    global $default_language, $login_edit;
    if ($enable_folderdescription) {
        // we check for a languagedepentent file  first !
        $filename = $directory . "/image" . $num . "_" . $default_language . '.' . $image_file_extension;
        ;
        if (!file_exists($filename)) {
            $filename = $directory . "/image" . $num . '.' . $image_file_extension;
            ;
        }
        if (file_exists($filename)) {
            if ($image_file_is_multi) {
                echo extractImageDescription($filename, urldecode($image));
            } else {
                include ($filename);
            }
        }
        // we check for a languagedepentent file  first !
        $filename = $install_dir . 'global_image' . $num . '_' . $default_language . '.htm';
        if (!file_exists($filename)) {
            $filename = $install_dir . 'global_image' . $num . '.htm';
        }
        if (file_exists($filename)) {
            $content = file_get_contents($filename);
          
            if (isset($GLOBALS['content_root'])) {
                $replace_path = $GLOBALS['content_root'] . ($directory) . '/' . rawurlencode(urldecode($image));
            } else { 
                $replace_path = getTWGHttpRoot('', false) . ($directory) . '/' . rawurlencode(urldecode($image)); 
            }
          
            $thumbimage = create_thumb_image($twg_album, $image);

            $small = create_cache_file($thumbimage, $extension_small);
            $thumb = create_cache_file($thumbimage, $extension_thumb);
            $new_content = str_replace("{img_full_url}", $replace_path, $content);
            $new_content = str_replace("{image_name}", rawurlencode(urldecode($image)), $new_content);
            $new_content = str_replace("{image_name_dec}", (urldecode($image)), $new_content);
            $new_content = str_replace("{directory_name}", rawurlencode($twg_album), $new_content);
            $new_content = str_replace("{directory_name_dec}", ($twg_album), $new_content);
            $new_content = str_replace("{img_cache}", $small, $new_content);
            $new_content = str_replace("{thumb_cache}", $thumb, $new_content);
            $new_content = str_replace("{lang}", $default_language, $new_content);
            // new 1.8.4.1 - media_name is if you have an image and you have a media file is this directory. 
            // Because of speed I simply check for a file that starts with file name and no the supported TWG media files.
            $image_path = $install_dir . ($directory) . '/' . rawurlencode(urldecode($image));

            $media_name = '';
            $media_names = twg_glob($image_path . '.*');
            if ($media_names && count($media_names) > 0) {
                $media_name = $media_names[0];
            }
            // for swf the structure is different
            $swf_file = removeExtension($image_path);
            if (file_exists($swf_file)) {
                $media_name = basename($swf_file);
            }
            $new_content = str_replace("{media_name}", $media_name, $new_content);
            
            echo $new_content;
            
        } else {
            echo "";
        }
    } else {
        echo "";
    }
    if (file_exists($install_dir . 'addons')) {
        $listing = glob($install_dir . "addons/*");
        if ($listing && (count($listing) > 0)) {
            foreach ($listing as $dirname) {
                if (is_dir($dirname)) {
                    include_once($dirname . "/twg_addon.php");
                }
            }
        }
    }

}

/**
 * Extract the image description from a textfile. The
 * text file is like a property file and parsed line by line.
 * the key is the image name - the value the text that is displayed!
 */
function extractImageDescription($filename, $image)
{
    if (filesize($filename) > 0) {     
    $datei = fopen($filename, "r");
    $lines = 0;
    while (!feof($datei) || $lines++ < 3000) { // more than 3000 descriptions are not normal and a user had a buggy php where this loop was looping...
        $buffer = trim(fgets($datei, filesize($filename) + 1));
        $pos = strpos($buffer, "=");
        $name = trim(substr($buffer, 0, $pos));
        if (strcasecmp($image, $name) == 0) {
            fclose($datei);
            return substr($buffer, $pos + 1);
        }
    }
    fclose($datei);
    return '';
    } else {
    return '';
    }
}

function includeMainAlbumDescriptionR($directory, $new_href, $titel, $nr_count_tree)
{
    includeMainAlbumDescription($directory, 'r', 'right', $new_href, $titel, $nr_count_tree);
}

function includeMainAlbumDescriptionL($directory, $new_href, $titel, $nr_count_tree)
{
    includeMainAlbumDescription($directory, 'l', 'left', $new_href, $titel, $nr_count_tree);
}

function includeMainAlbumDescription($directory, $side, $sideClass, $new_href, $titel, $nr_count_tree)
{
    global $enable_folderdescription;
    global $default_language;
    
    if ($enable_folderdescription && checkFullscreen()) {
        // we check for a languagedepentent file  first !
        $filename = $directory . "/album" . $side . "_" . $default_language . ".txt";
        if (!file_exists($filename)) {
            $filename = $directory . "/album" . $side . ".txt";
        }
        if (file_exists($filename)) {
            echo "<td class='albumtxt albumtxt" . $sideClass . "'>";
            $content = file_get_contents($filename);
            $new_content = str_replace("{album_href}", $new_href, $content);
            $new_content = str_replace("{album_name}", $titel, $new_content);
            $new_content = str_replace("{album_count}", $nr_count_tree, $new_content);
            echo $new_content;
            echo "</td>"; 
        }
    }
}

function hasAlbumDescription($directory)
{
    global $enable_folderdescription;
    global $default_language;
    global $image;

    if ($enable_folderdescription && checkFullscreen()) {
        $filename = $directory . "/albumr_" . $default_language . ".txt";
        if (file_exists($filename)) {
            return true;
        }
        $filename = $directory . "/albumr.txt";
        if (file_exists($filename)) {
            return true;
        }
        $filename = $directory . "/albuml_" . $default_language . ".txt";
        if (file_exists($filename)) {
            return true;
        }
        $filename = $directory . "/albuml.txt";
        if (file_exists($filename)) {
            return true;
        }
    }
    return false;
}

function hasImagepageDescription($directory)
{
    global $enable_folderdescription;
    global $default_language, $install_dir;
    global $image_file_extension;

    if ($enable_folderdescription) {
        // we check for a languagedepentent file  first !
        $filename = $directory . "/image_" . $default_language . '.' . $image_file_extension;
        if (!file_exists($filename)) {
            $filename = $directory . "/image." . $image_file_extension;
            ;
        }
        if (file_exists($filename)) {
            return true;
        }
        $filename = $install_dir . 'global_image.htm';
        if (file_exists($filename)) {
            return true;
        }
    }
    if (file_exists($install_dir . 'addons')) {
        $listing = glob($install_dir . "addons/*");
        if ($listing && (count($listing) > 0)) {
            foreach ($listing as $dirname) {
                if (is_dir($dirname)) {
                    return true;
                }
            }
        }
    }
    return false;
}

function getDirectoryName($directory, $dir_name, $only_default = false)
{
    global $enable_foldername, $default_language, $cache_dirs, $charset, $filesystem_encoding;

    $from_file = false;  
    $dir_name = my_basename($dir_name);
      
    if ($enable_foldername) {
        if (isset($_SESSION['twg_tmp']["getdirname" . $default_language . $dir_name]) && $cache_dirs && !$only_default) {
            if ($_SESSION['twg_tmp']["getdirname" . $default_language . $dir_name] == "__nix__") {
                return $dir_name;
            }
            return $_SESSION['twg_tmp']["getdirname" . $default_language . $directory];
        } else {
            $value = "";
            // we check for a languagedepentent file  first !
            $filename = $directory . "/foldername_" . $default_language . ".txt";
            if ($only_default || !file_exists($filename)) {
                $filename = $directory . "/foldername.txt";
            }
            if (file_exists($filename)) {
                $text = trim(file_get_contents($filename));                
                $value = $text;
                $from_file = true;  
            } else {
                $value = removePrefix($dir_name);
            }

            if (isset($charset) && $charset == "utf-8" && !$from_file) {
                $value = ($filesystem_encoding == '') ? utf8_encode(removePrefix($value)) : iconv($filesystem_encoding, 'UTF-8', removePrefix($value));
            }
            if ($cache_dirs) {
                $_SESSION['twg_tmp']["getdirname" . $default_language . $directory] = $value;
            }
            return $value;
        }
    } else {
        $ret_value = removePrefix($dir_name); 
        if (isset($charset) && strtolower($charset) == "utf-8") {
            $ret_value = ($filesystem_encoding == '') ? utf8_encode($ret_value) : iconv($filesystem_encoding, 'UTF-8', $ret_value);
        } 
        return $ret_value;
    }
}

function getFileContent($filename, $oldcontent)
{
    global $cache_dirs;

    if (isset($_SESSION["fc_" . $filename]) && $cache_dirs) {
        return $_SESSION["fc_" . $filename];
    }

    if (file_exists($filename)) {
        $datei = fopen($filename, "r");
        $text = (fgets($datei, filesize($filename) + 1));
        fclose($datei);
        if ($text != "") {
            $_SESSION["fc_" . $filename] = $text;
            return $text;
        }
    }
    $_SESSION["fc_" . $filename] = $oldcontent;
    return $oldcontent;
}

$f2 = dirname(__FILE__) . "/../js/ie7-main.htc";

/*
we cache this call later in the sesssion!
*/
function get_directories($localdir, $sortit = true)
{
    global $cache_dirs, $sort_album_by_date, $sort_albums, $sort_albums_ascending, $serialize_dir_data;
    global $basedir, $exclude_directories, $input_invalid, $input_wrong_chars, $xmldir, $cachedir;
    global $skip_thumbnail_page, $auto_skip_thumbnail_page;

    $docache = true;
    clearstatcache();

    set_error_handler("on_error_no_output");
    $dir_time = filemtime($localdir); // we check if the cache still looks o.k. ;).
    set_error_handler("on_error");
    if ($dir_time === false) {
        $dir_time = 0;
    }
    if (isset($_SESSION['twg_tmp']["dir_time" . $localdir]) && ($_SESSION['twg_tmp']["dir_time" . $localdir] != $dir_time)) {
        // we delete the cache because something has changed!
        $docache = false;
        // the session tmp cache will be deleted
        unset($_SESSION['twg_tmp']);
        $_SESSION['twg_tmp'] = array();
    }

    if (isset($_SESSION['twg_tmp']["dir" . $localdir]) && $cache_dirs && $docache) {
        if ($_SESSION['twg_tmp']["dir" . $localdir] == "__nix__") {
            return null;
        }
        return $_SESSION['twg_tmp']["dir" . $localdir];
    }
    if ($serialize_dir_data && $cache_dirs) {
        $dirhash = sha1($localdir);
        $cachename = $cachedir . "/_t_d_" . $dirhash . ".tmp.php";
        if (file_exists($cachename) && $docache) {
            $data = getFileContent($cachename, "");
            $userdata = @unserialize($data);
            if ($userdata) {
                if (isset($userdata["twg_time"])) {
                    $_SESSION['twg_tmp']["dir_time" . $localdir] = $userdata["twg_time"];
                    unset($userdata["twg_time"]);
                }
                $_SESSION['twg_tmp']["dir" . $localdir] = $userdata;
                return $userdata;
            } else {
                // delete invalid cache.
                @unlink($cachename);
            }
        }
    }


    if (!file_exists($localdir)) {
        if ($input_invalid) {
            printErrorInvalid();
        } else {
            $output = substr($localdir, strlen($basedir) + 1);
            echo "The album '" . utf8_encode($output) . "' cannot be found and is maybe not available anymore.";
            echo "<br>&nbsp;<br>If this a new created directory please make sure not to use a \" in the folder name because this a not allowed character in album names.";
            echo "<br>Please close the browser to delete the session because TWG is caching the direcotry infomation there.";
            echo "<p>If you came with a direct link please check the directory name.<br>Please go back to the main page and navigate to the album you are looking for.</p>";
            set_error_handler("on_error_no_output"); // @ does not work!
            @unlink($xmldir . '/' . $output . '_kommentar_text.xml');
            @unlink($xmldir . '/' . $output . '_image_text.xml');
            set_error_handler("on_error");
            // we disable the iframes!
            echo '<script type="text/javascript">function twg_showSec() { window.location="' . getScriptName() . '"; return false;}</script>';
        }
        return null;
    }

    // we load a custom config_sort.php and save the old settings because we need them for the next directory!
    if (file_exists($localdir . "/config_sort.php")) {
        $sort_save = array($sort_albums, $sort_albums_ascending, $sort_album_by_date, $skip_thumbnail_page, $auto_skip_thumbnail_page);
        include ($localdir . "/config_sort.php");
    }

    $d = opendir($localdir);
    $nr = 0;
    while (false !== ($entry = readdir($d))) {
        if (is_dir($localdir . '/' . $entry) && $entry != '.' && $entry != "..") {
            if (!check_empty_directories($localdir . '/' . $entry) && (!in_array($entry, $exclude_directories))) {
                if ($sort_album_by_date && $sort_albums) {
                    $sorttime = filemtime($localdir . '/' . $entry) . '_';
                    if ((strlen($sorttime) == 10)) {
                        $sorttime = "0" . $sorttime;
                    }
                    $locverzeichnisse[] = $sorttime . $entry;
                } else {
                    $locverzeichnisse[] = $entry;
                }
            }
        }
    }
    closedir($d);
    if (isset($locverzeichnisse)) {
        // we sort the folders
        if ($sort_albums && $sortit) {
            usort($locverzeichnisse, "mycmp");
            if (!$sort_albums_ascending) {
                $locverzeichnisse = array_reverse($locverzeichnisse);
            }

            reset($locverzeichnisse);
            if ($sort_album_by_date && $sort_albums) {
                for ($x = 0; $x < count($locverzeichnisse); $x++) {
                    // we go through the array and remove the time :).
                    // echo $list[$x] . "<br>";
                    $locverzeichnisse[$x] = substr($locverzeichnisse[$x], 11);
                }
            }
            reset($locverzeichnisse);
        }

        if ($cache_dirs) {
            $_SESSION['twg_tmp']["dir" . $localdir] = $locverzeichnisse;
            $_SESSION['twg_tmp']["dir_time" . $localdir] = $dir_time;
        }
        if ($serialize_dir_data && $cache_dirs && (count($locverzeichnisse) > 1)) {
            $ser_file = fopen($cachename, 'w');
            $locverzeichnisse["twg_time"] = $dir_time;
            fputs($ser_file, serialize($locverzeichnisse));
            unset($locverzeichnisse["twg_time"]);
            fclose($ser_file);
        }

        // we restore the sorting properties!

        if (isset($sort_save)) {
            list($sort_albums, $sort_albums_ascending, $sort_album_by_date, $skip_thumbnail_page, $auto_skip_thumbnail_page) = $sort_save;
        }
        return $locverzeichnisse;
    } else {
        if ($cache_dirs) {
            $_SESSION['twg_tmp']["dir" . $localdir] = "__nix__";
            $_SESSION['twg_tmp']["dir_time" . $localdir] = $dir_time;
        }
        return null;
    }
}

/*

*/
function check_empty_directories($localdir)
{
    global $hide_empty_directories;
    if ($hide_empty_directories) {
        $d = opendir($localdir);
        $nr = 0;
        while (false !== ($entry = readdir($d))) {
            if ($entry != '.' && $entry != "..") {
                closedir($d);
                return false;
            }
        }
        closedir($d);
        return true;
    } else {
        return false;
    }
}

function twg_checkUrl($path)
{
    global $url_file;
    global $cache_dirs;

    if (isset($_SESSION["checkUrl_" . $path]) && $cache_dirs) {
        return $_SESSION["checkUrl_" . $path];
    }

    $filename = $path . '/' . $url_file;
    if (file_exists($filename)) {
        $dateiurl = fopen($filename, "r");
        $locurl = trim(fgets($dateiurl, filesize($filename) + 1));
        fclose($dateiurl);
        // TODO: check if neede: $locurl = str_replace(" ", "%20", $locurl);
        $_SESSION["checkUrl_" . $path] = $locurl;
        return $locurl;
    } else {
        return false;
    }
}


function get_min_image_list($twg_album, $limit)
{
    global $basedir;
    if ($twg_album == $basedir) {
        $path = $basedir;
    } else {
        $path = $basedir . '/' . $twg_album;
    }
    $list = array();
    $d = opendir($path);
    $i = 0;
    while (false !== ($entry = readdir($d))) {
        $filename = $path . '/' . $entry;
        if (!is_dir($filename) && (is_supported_image($entry))) {
            if (filesize($filename) > 0) {
                $list[$i++] = urlencode($entry);
            }
        }
        if ($i > $limit) {
            break;
        }
    }
    closedir($d);
    return count($list);
}

$change_check_done = false; // get_image_list can be called more often in one request. Cache should ony be checked once per request!

function get_image_list($twg_album, $remove_base = false, $check_if_cache = true, $is_absolute = false)
{
    global $basedir, $cachedir, $cachedir_save, $sort_by_date, $sort_images_ascending, $sort_by_filedate, $cache_dirs;
    global $default_language, $serialize_dir_data, $change_check_done, $skip_thumbnail_page, $auto_skip_thumbnail_page;

    $dir_time = '';
    $ret_value = false;
    if ($remove_base) { // not used right now!
        $twg_album = substr($twg_album, strlen($basedir) + 1);
    }

    if ($is_absolute) { // this is needed for local directories when url.txt is set.
        $path = $twg_album;
    } else if ($twg_album == $basedir || !$twg_album) {
        $path = $basedir;
    } else {
        $path = $basedir . '/' . $twg_album;
    }

    if (file_exists($path)) {
        if (!$check_if_cache) { // we check if we have a custom config and don't cache recusive calls from showfolders!
            if (!file_exists($path . "/config.php") && !file_exists($path . "/config_" . $default_language . ".php")) {
                $check_if_cache = true; // we cache because no custom config exists
            }
        }

        $docache = true;
        if (!$change_check_done) {
            clearstatcache();
        }
        $change_check_done = true;

        set_error_handler("on_error_no_output");
        $dir_time = filemtime($path); // we check if the cache still looks o.k. ;).
        set_error_handler("on_error");
        if ($dir_time === false) {
            $dir_time = 0;
        }

        if (isset($_SESSION['twg_tmp']["dir_images_time" . $twg_album]) && ($_SESSION['twg_tmp']["dir_images_time" . $twg_album] != $dir_time)) {
            // we delete the cache because something has changed!
            remove_tmp_files(false, false); // once a day!
            $docache = false;
            // the session tmp cache will be deleted
            unset($_SESSION['twg_tmp']);
            $_SESSION['twg_tmp'] = array();
        }

        // cache from session
        if (isset($_SESSION['twg_tmp']["dir_images" . $twg_album]) && $cache_dirs && $check_if_cache && $docache) {
            if ($_SESSION['twg_tmp']["dir_images" . $twg_album] == "__nix__") {
                return null;
            }
            return $_SESSION['twg_tmp']["dir_images" . $twg_album];
        }

        // cache from file
        if ($serialize_dir_data && $cache_dirs) {
            $dirhash = sha1($twg_album);
            $cachename =  $cachedir . '/_t_i_' . $dirhash . '.tmp.php';
            if (file_exists($cachename) && $docache) {
                $data = getFileContent($cachename, "");
                $userdata = @unserialize($data);
                if ($userdata) {
                    if (isset($userdata["twg_time"])) {
                        $_SESSION['twg_tmp']["dir_images_time" . $twg_album] = $userdata["twg_time"];
                        unset($userdata["twg_time"]);
                    }
                    $_SESSION['twg_tmp']["dir_images" . $twg_album] = $userdata;
                    return $userdata;
                } else {
                    // delete invalid cache.
                    @unlink($cachename);
                }
            }
        }

        // we fully read!
        if (file_exists($path . "/config_sort.php")) {
            $sort_save = array($sort_images_ascending, $sort_by_date, $sort_by_filedate, $skip_thumbnail_page, $auto_skip_thumbnail_page);
            include ($path . "/config_sort.php");
        }

        $spacer = "000000000"; // we want to have the same length for all dates  for easier removing
        if (function_exists("exif_read_data")) {
            if ($sort_by_filedate) {
                $enable_exif = false;
            } else {
                $enable_exif = true;
            }
        } else {
            $enable_exif = false;
        }
        $url = twg_checkUrl($path);
        if ($url && !$is_absolute) {
            $list = twg_http_get($url);
            $sort_by_date = false;
        } else {
            $d = opendir($path);
            $i = 0;
            while (false !== ($entry = readdir($d))) {
                $filename = $path . '/' . $entry;
                if (!is_dir($filename) && (is_supported_image($entry))) {
                    if (filesize($filename) > 0) {
                        if ($sort_by_date) {
                            $sorttime = get_image_time($filename, $enable_exif, $spacer, false);
                            $list[$i++] = $sorttime . urlencode($entry);
                        } else {
                            $list[$i++] = urlencode($entry);
                        }
                    }
                }
            }
            closedir($d);
        }
        if (isset($list)) {
            usort($list, "mycmp");
            if (!$sort_images_ascending) {
                $list = array_reverse($list);
            }
            reset($list);
            if ($sort_by_date) {
                for ($x = 0; $x < count($list); $x++) {
                    // we go through the array and remove the time :).
                    $list[$x] = substr($list[$x], 20);
                }
            }
            if ($cache_dirs && $check_if_cache) {
                $_SESSION['twg_tmp']["dir_images" . $twg_album] = $list;
                $_SESSION['twg_tmp']["dir_images_time" . $twg_album] = $dir_time;
            }
            if ($serialize_dir_data && $cache_dirs) {
                $ser_file = @fopen($cachename, 'w');
                if ($ser_file) {
                    $list["twg_time"] = $dir_time;
                    fputs($ser_file, serialize($list));
                    unset($list["twg_time"]);
                    fclose($ser_file);
                }
            }
            $ret_value = $list;
        } else {
            if ($cache_dirs && $check_if_cache) {
                $_SESSION['twg_tmp']["dir_images" . $twg_album] = "__nix__";
                $_SESSION['twg_tmp']["dir_images_time" . $twg_album] = $dir_time;
            }
        }
    }
    if (isset($sort_save)) {
        list($sort_images_ascending, $sort_by_date, $sort_by_filedate, $skip_thumbnail_page, $auto_skip_thumbnail_page) = $sort_save;
    }
    return $ret_value;
}

function get_image_time($filename, $enable_exif, $spacer, $checkexif)
{
    global $sort_by_filedate;

    if (!file_exists($filename)) {
        return 0;
    }

    if ($checkexif) {
        if (function_exists("exif_read_data")) {
            if ($sort_by_filedate) {
                $enable_exif = false;
            } else {
                $enable_exif = true;
            }
        } else {
            $enable_exif = false;
        }
    }

    $sorttime = "";
    if ($enable_exif) {
        // we try to use the camera informations!
        set_error_handler("on_error_no_output"); // @does not work
        $exif_data = @exif_read_data($filename);
        set_error_handler("on_error");
        if ($exif_data) {
            if (isset($exif_data['DateTimeOriginal'])) {
                $sorttime = $exif_data['DateTimeOriginal'];
            }
            if (strlen($sorttime) == 0) {
                if (isset($exif_data['DateTime'])) {
                    $sorttime = $exif_data['DateTime'];
                    if (strlen(trim($sorttime)) != 19) {
                        // we use the filedate! if the value in the DateTime does not have the correct lenght (this can be improved but I don't know if different cameras do different date-formats ) :).
                        $sorttime = filemtime($filename) . $spacer;
                    }
                } else {
                    // we use the filedate! if the value in the DateTime does not have the correct lenght (this can be improved but I don't know if different cameras do different date-formats ) :).
                    $sorttime = filemtime($filename) . $spacer;
                }
            }
        } else {
            // we use the filedate!
            $sorttime = filemtime($filename) . $spacer;
        }
    } else {
        // we use the filedate!
        $sorttime = filemtime($filename) . $spacer;

    }
    // if we get a real date we try to get the timestamp back!
    $splittime = preg_split("/[\s,:]+/", $sorttime);

    if (isset($splittime[2])) {
        $jahr = $splittime[0];
        $monat = $splittime[1];
        $tag = $splittime[2];
        if (count($tag) > 2) {
            $temp = $tag;
            $tag = $jahr;
            $jahr = $temp;
        }
        $str_date = $jahr . '/' . $monat . '/' . $tag;
        if (isset($splittime[5])) {
            $str_date .= ' ' . $splittime[3] . ':' . $splittime[4] . ':' . $splittime[5];
        }
        $sorttime = strtotime($str_date);
        if (strlen($sorttime) == 9) {
          $sorttime = "0" . $sorttime;
        }
        if (strlen($sorttime) == 10) {
            $sorttime .= $spacer;
        }
    }

    if (($spacer == "000000000") && (strlen($sorttime) == 18)) {
        $sorttime = "0" . $sorttime;
    }

    $sorttime .= '_'; // we add a spacer because of filenames that start with a number.

    return $sorttime;
}

function get_language_list()
{
    global $install_dir, $cache_dirs;

    if (isset($_SESSION['twg_tmp']["dir_lang_list"]) && $cache_dirs) {
        return $_SESSION['twg_tmp']["dir_lang_list"];
    }
    $dir = preg_replace('/(\*|\?|\[)/', '[$1]', dirname(__FILE__) . "/../language/");
    $list = twg_glob($dir . "language_??.php");
    foreach ($list as $key => $value) {
        $list[$key] = substr(basename($value), 9, 2);
    }
    if (isset($list)) {
        $_SESSION['twg_tmp']["dir_lang_list"] = $list;
        return $list;
    } else {
        $_SESSION['twg_tmp']["dir_lang_list"] = false;
        return false;
    }
}

function checkDefaultLanguage($lang)
{
    // if lang exists everything is o.k.
    if (file_exists(dirname(__FILE__) . "/../language/language_" . $lang . ".php")) {
        return $lang; // the default lang is ok!
    }
    // then we try english !
    if (file_exists(dirname(__FILE__) . "/../language/language_en.php")) {
        return "en"; // the default lang is en if exists!
    }
    // now we take de!
    if (file_exists(dirname(__FILE__) . "/../language/language_de.php")) {
        return "de"; // the default lang is en if exists!
    }
    // and finally the 1st in the dir!
    $languagelist = get_language_list();
    return substr($languagelist[0], 9, 2);
}

/*
function get_language_string($lang)
{
  $lang_string = $lang;
	$fileName = "language/language_" . $lang . ".txt";
	if (file_exists($fileName)) {
		$datei = fopen($fileName, "r");
		$lang_string = fgets($datei, filesize($fileName)+1);
		fclose($datei);
	}
	return $lang_string;
}
*/

function get_image_number($twg_album, $entry)
{
    $imagelist = get_image_list($twg_album);
    for ($current = 0, $i = 0; $i < count($imagelist); $i++) {
        if (urldecode($imagelist[$i]) == urldecode($entry)) {
            $current = $i;
        }
    }
    return $current;
}

function get_image_count($twg_album)
{
    $counter = get_image_list($twg_album);
    if ($counter != false) {
        return count($counter);
    } else {
        return 0;
    }
}

function get_image_name($twg_album, $img_nr)
{
    $imagelist = get_image_list($twg_album);
    return $imagelist[$img_nr];
}

function get_next($twg_album, $entry, $current_id)
{
    $imagelist = get_image_list($twg_album);
    return ($current_id + 1 < count($imagelist) ? $imagelist[$current_id + 1] : false);
}

// this is the previos image
function get_last($twg_album, $entry, $current_id)
{
    $imagelist = get_image_list($twg_album);
    return ($current_id - 1 >= 0 ? $imagelist[$current_id - 1] : false);
}

function get_end($twg_album)
{
    $imagelist = get_image_list($twg_album);
    if ($imagelist) {
        return $imagelist[count($imagelist) - 1];
    } else {
        return false;
    }
    
}

function get_first($twg_album)
{
    $imagelist = get_image_list($twg_album);
    if ($imagelist) {
        return $imagelist[0];
    } else {
        return '';
    }
}

$next = '';
function get_last_album($basedir, $twg_album)
{
    global $next;
    // level drüber lesen
    if ($twg_album) {
        $upper = dirname($twg_album);
        $dir_local = basename($twg_album);
        if ($upper == '' || $upper == '.' || $upper == '/' || $upper == '\\') {
            $upper = '';
            $dirs = get_directories($basedir);
        } else {
            $dirs = get_directories($basedir . '/' . $upper);
            $upper = $upper . '/';
        }

        $last = '';
        $last_found = false;
        foreach ($dirs as $dir) {
            if ($last_found == true) {
                $next = $upper . $dir;
                break;
            }
            if ($dir == $dir_local) {
                $last_found = true;
            }
            if ($last_found != true) {
                $last = $upper . $dir;
            }
        }
        return $last;
    } else {
        return '';
    }
}

function get_next_album()
{
    global $next;
    return $next;
}

function get_twg_offset($twg_album, $entry, $current_id)
{
    global $thumbnails_x;
    global $thumbnails_y;
    global $autodetect_maximum_thumbnails;
    global $thumb_pic_size;

    if ($autodetect_maximum_thumbnails && isset($_SESSION[$GLOBALS["standalone"] . "browserx_res"]) && isset($_SESSION[$GLOBALS["standalone"] . "browsery_res"])) {
        if ($_SESSION[$GLOBALS["standalone"] . "browserx_res"] != 30) {
            $thumbnails_x = floor(($_SESSION[$GLOBALS["standalone"] . "browserx_res"] - 30) / ($thumb_pic_size + 5));
        }
        if ($_SESSION[$GLOBALS["standalone"] . "browsery_res"] != 40) {
            $thumbnails_y = floor(($_SESSION[$GLOBALS["standalone"] . "browsery_res"] - 40) / ($thumb_pic_size + 5));
        }
    }

    if (isset($_SESSION["twg_minus_rows"])) {
        $thumbnails_y = $thumbnails_y - $_SESSION["twg_minus_rows"];
    }
    $num_pic = $thumbnails_x * $thumbnails_y;
    if ($current_id != 0 && $num_pic != 0) {
        return $num_pic * floor($current_id / ($num_pic));
    } else {
        return 0;
    }
}

function get_page_nr($current_id)
{
    global $thumbnails_x;
    global $thumbnails_y;

    $num_pic = $thumbnails_x * $thumbnails_y;
    return floor($current_id / ($num_pic));
}

function get_dirname($dir)
{
    $dirname = str_replace("\\", '/', dirname($dir));
    $dirname = '/' ? "" : ($dirname . '/');
    return $dirname;
}

/*
function:debug()
*/
function debug($data)
{
    global $debug_file;
    output($data, $debug_file);
}

/*
end function debug()
*/


function log_twg($data)
{
    global $log_file;
    output($data, $log_file);
}

function output($data, $debug_file)
{
    global $default_language, $enable_enhanced_debug, $input_invalid;
    if ($debug_file == '') {
        return;
    }

    $data = replaceInput($data); // we check output data too - you never know!
    $input_invalid = false;

    if (stristr($data, 'deprecated') !== false) { // we ignore this message - comes when php 5.3 is used.
        return;
    }
    if (stristr($data, 'eval') !== false) { // we ignore this message - eror level is too high
        return;
    }

    $debug_string = date("m.d.Y G:i:s") . " (" . $default_language . ")" . " - " . $data . "\n";
    if ($enable_enhanced_debug) {
        $debug_string .= '    Request: ' . getScriptName() . '?' . $_SERVER['QUERY_STRING'] . "\n";
        foreach (debug_backtrace() as $element) {
            $debug_string .= '      Stack: ' . basename($element['file']) . ":" . $element['line'] . ":" . $element['function'];
            if (isset($element['args'])) {
              foreach ($element['args'] as $par) {
                if (is_array($par)) {
                    $par = str_replace("\n", "", print_r($par, true));
                }
                $debug_string .= ":" . substr($par, 0, 100); // max 100 chars 
              }
            }
            $debug_string .= "\n";
        }
    }
    if (file_exists($debug_file)) {
        if (filesize($debug_file) > 1000000) {
            $debug_file_local = fopen($debug_file, 'w');
        } else {
            $debug_file_local = fopen($debug_file, 'a');
        }
        fputs($debug_file_local, $debug_string);
        fclose($debug_file_local);
    } else {
        $debug_file_local = fopen($debug_file, 'w');
        fputs($debug_file_local, $debug_string);
        fclose($debug_file_local);
        clearstatcache();
    }
}

function on_error($num, $str, $file, $line)
{
    if ((strpos($file, "email.inc.php") === false) && (strpos($line, "fopen") === false) && $line != 0) {
        debug("ERROR $num in " . substr($file, -40) . ", line $line: $str");
    } else if ($line == 0) {
        debug("ERROR STACKTRACE: " . parse_backtrace(debug_backtrace()));
    }
}

function parse_backtrace($raw)
{
    $output = "";
    set_error_handler("on_error_no_output"); // @does not work
    foreach ($raw as $entry) {
        $output .= "\nFile: " . $entry['file'] . " (Line: " . $entry['line'] . ")\n";
        $output .= "Function: " . $entry['function'] . "\n";
        $output .= "Args: " . implode(", ", $entry['args']) . "\n";
    }
    set_error_handler("on_error");
    return $output;
}

function on_error_no_output($num, $str, $file, $line)
{
}


function gd_version()
{
    static $gd_version_number = null;
    if ($gd_version_number === null) {
        if (function_exists("gd_info")) {
            $info = gd_info();
            $module_info = $info["GD Version"];
            if (preg_match("/[^\d\n\r]*?([\d\.]+)/i",
                $module_info, $matches)
            ) {
                $gd_version_number = $matches[1];
            } else {
                $gd_version_number = 0;
            }
        } else { // needed before 4.3 !
            ob_start();
            phpinfo(8);
            $module_info = ob_get_contents();
            @ob_end_clean();
            if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i",
                $module_info, $matches)
            ) {
                $gd_version_number = $matches[1];
            } else {
                $gd_version_number = 0;
            }
        }
    }
    return $gd_version_number;
}

/*
	Replaces some characters in urls which ledds to problems with cached images. Missing characters can be added here
*/
function replace_valid_url($name)
{
    // $name = str_replace("%2C", ",", $name);
    // $name = str_replace("%28", "(", $name);
    // $name = str_replace("%29", ")", $name);
    // $name = str_replace("+", " ", $name);
    return $name;
}

function fixjs($name)
{
    return str_replace("%", "%25", $name);
}

/*
  Replaces the ' in some places where thery are no valid characters (e.g. in strings which are teminated by ')
*/
function escapeHochkomma($name)
{
    $name = str_replace("'", "", $name);
    $name = str_replace("%27", "", $name);
    // $name = str_replace("&", "%2C", $name);
    return $name;
}

/*
escapes the ' by '\ needed for the slideshow ;).
*/
function escapeHochkommaSlideshow($name)
{
    $name = str_replace("'", "\'", $name);
    return $name;
}

/*
escapes the ' by '\ needed for the slideshow ;).
*/
function escapeHochkommaJS($name)
{
    return str_replace("'", "\'", $name);
}

function removeTitleChars($name)
{
    global $charset;

    $name = removePrefix($name);

    if (isset ($charset)) {
        $charsetloc = $charset;
    } else {
        $charsetloc = "ISO-8859-15";
    }

    $name = html_entity_decode_fixed($name, ENT_NOQUOTES, $charset);
    $name = str_replace("\"", "'", $name);
    $name = str_replace("<", "_", $name);
    $name = str_replace(">", "_", $name);
    $name = str_replace('/', "_", $name);
    $name = str_replace("\n", " - ", $name);
    $name = str_replace("\r", "", $name);
    $name = str_replace("_br", "", $name);
    $name = str_replace('_', " ", $name);

    return substr($name, 0, 100);
}

function checkText()
{
    if (!function_exists("imagettftext")) {
        echo "Function imagettftext does not exist - print_text should be set to false in the config.php!";
    }
    ;
}

function checktwg_rot()
{
    global $cachedir;
    global $install_dir;

    $image = $install_dir . "buttons/border.jpg";
    $outputimage = $cachedir . "/_rotation_available.jpg";
    $outputimageerror = $cachedir . "/_rotation_not_available.jpg";
    // we check only once - if one to the ouputimages exists we don't do he check again
    // delete the _twg_rot_not_available.jpg and _twg_rot_available.jpg
    if (file_exists($outputimage)) {
        return true;
    } else if (file_exists($outputimageerror)) {
        return false;
    } else {
        if (!function_exists("imagecreatetruecolor")) {
            echo "Function 'imagecreatetruecolor' is not available - GDlib > 2.0.1 is needed to run TinyWebGallery properly!";
        } else {
            if (!function_exists("imagerotate")) {
                $dst = imagecreatetruecolor(50, 37);
                $fh = fopen($outputimageerror, 'w'); // fix for a bug in some php - versions - thanks to Anders
                fclose($fh);
                imagejpeg($dst, $outputimageerror, 50);
                return false;
            } else {
                $oldsize = getImageSize($image);
                $src = imagecreatefromjpeg($image);
                $dst = imagecreatetruecolor(50, 37);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, 50, 37, 50, 37);
                $twg_rot = @imagerotate($dst, 90, 0);
                $fh2 = fopen($outputimage, 'w'); // fix for a bug in some php - versions - thanks to Anders
                fclose($fh2);
                if (!imagejpeg($twg_rot, $outputimage, 50)) {
                    $fh3 = fopen($outputimageerror, 'w'); // fix for a bug in some php - versions - thanks to Anders
                    fclose($fh3);
                    imagejpeg($dst, $outputimageerror, 50);
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
}

function get_counter_data($file)
{
    $return_array = array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1);
    if (file_exists($file)) {
        $datei = file($file);
        $index1 = 0;
        $counter = 0;

        $lines = count($datei);
        if ($lines > 30) {
            $index1 = $lines - 30;
        }
        if ($lines < 30) {
            $counter = 30 - $lines;
        }
        $oldtimestamp = 0;
        $day = 3600 * 24;

        while ($index1 < $lines) {
            $dat = explode("&", $datei[$index1]);
            if (is_numeric($dat[1])) {
                $timestamp = @mktime(0, 0, 0, $dat[1], $dat[0], $dat[2]);
                if ($oldtimestamp <> 0) {
                    while (($oldtimestamp + $day) < $timestamp) { // we have a gap!
                        $return_array[$counter++] = 0;
                        $oldtimestamp += $day;
                    }
                }
                $count = $dat[3];
                $return_array[$counter++] = $count;
                $index1++;
                $oldtimestamp = $timestamp;
            }
        }

        $timestamp = time() - $day; // only fill up till the last day!
        // the last days !
        while (($oldtimestamp + $day) < $timestamp) { // we have a gap!
            $return_array[$counter++] = 0;
            $oldtimestamp += $day;
        }
    }
    $return_array = array_slice($return_array, count($return_array) - 30);
    return $return_array;
}

function check_image_extension($image)
{
    return is_supported_image($image);
}

/*
replaces a + or a + encode(+) with __PLUS__   :  we have to doubleencode for some servers (like ed's :) and therefore would loose the +)
*/
function replace_plus($plus)
{
    $plus = str_replace("+", "__PLUS__", $plus);
    $plus = str_replace(urlencode("+"), "__PLUS__", $plus);
    return $plus;
}

/*
 replaces a __PLUS__ with +
*/
function restore_plus($plus)
{
    return str_replace("__PLUS__", "+", $plus);
}

// suche / in pfad - wenn keiner drin leer zur++ck - sonst rest vor /
function getupperdirectory($twg_album)
{
    return substr($twg_album, 0, strrpos($twg_album, '/'));
}

/*
  insert smilies into comments and captions - only the smilies have to be added to the smilies folder in
  the buttons dir . e.g. :).gif  ;).gif ....  : is not a valid representation therefore the following
  coding is used:

  : -> a
  \ -> b
  / -> c
  * -> d

  z.B. :) is the file a).gif !

*/
function replacesmilies($data)
{
    global $install_dir, $install_dir_view ;
    global $enable_smily_support;

    if ($enable_smily_support) {
        // read the smilies !
        if (isset($_SESSION['twg_tmp']["dir_smilies_list"])) {
            $list = $_SESSION['twg_tmp']["dir_smilies_list"];
            $filelist = $_SESSION['twg_tmp']["dir_smilies_list_names"];
        } else {

            $d = opendir(dirname(__FILE__) . "/../buttons/smilies");
            $i = 0;
            while (false !== ($entry = readdir($d))) {
                if (preg_match("/.*\.(G|g)(i|I)(F|f)$/", $entry)) {
                    $filelist[$i] = $entry;
                    $entry = switch_smilie_letters($entry);
                    $entry = substr($entry, 0, strlen($entry) - 4); // we strip the extension
                    $list[$i] = $entry;
                    $i++;
                }
            }
            closedir($d);
            if (isset($list)) {
                $_SESSION['twg_tmp']["dir_smilies_list"] = $list;
                $_SESSION['twg_tmp']["dir_smilies_list_names"] = $filelist;
            }
        }
        if (isset($list)) {
            // we start replacing ...
            for ($i = 0; $i < count($list); $i++) {
                $data = str_replace($list[$i], "<img style=\"vertical-align:middle; padding-bottom:3px\" src=\"" . $install_dir_view . "buttons/smilies/" . $filelist[$i] . "\" alt=\"\" >", $data);
            }
        }
    }
    return $data;
}

function t($l, $s)
{
    $n = '';
    $m = explode(';', $l);
    foreach ($m as $v) {
        $nrp = substr_count($v, '.');
        if ($nrp == 1 && (strpos($v, '*') === false)) {
            $nrp++;
            $v .= "*.";
        }
        $el = explode('.', $s);
        if ($el !== false) {
            $r = array_slice($el, 0, -$nrp);
            $n .= ';' . str_replace('*', 'ww' . 'w' . ((count($r) > 0) ? ('.' . array_pop($r)) : ''), $v);
        }
    }
    return $n;
}

function switch_smilie_letters($entry)
{
    $entry = str_replace("a", ":", $entry);
    $entry = str_replace("b", "\\", $entry);
    $entry = str_replace("c", '/', $entry);
    $entry = str_replace("d", "*", $entry);
    $entry = str_replace("e", "|", $entry);
    $entry = str_replace("f", "?", $entry);
    return $entry;
}

/*
encodes only the part without the / and :
*/
function twg_urlencode($data)
{
    $data = str_replace('/', "__TWG__", $data);
    $data = str_replace(":", "__DPP__", $data);
    $data = rawurlencode($data);
    $data = str_replace("__DPP__", ":", $data);
    return str_replace("__TWG__", '/', $data);
}

function create_smilie_div()
{
    global $enable_smily_support;

    $smilies = "";
    if ($enable_smily_support) {
        // read the smilies !
        if (isset($_SESSION['twg_tmp']["dir_smilies_list_pop"])) {
            $list = $_SESSION['twg_tmp']["dir_smilies_list_pop"];
            $filelist = $_SESSION['twg_tmp']["dir_smilies_list_names_pop"];
        } else {
            $d = opendir("../buttons/smilies");
            $i = 0;
            while (false !== ($entry = readdir($d))) {
                if (preg_match("/.*\.(G|g)(i|I)(F|f)$/", $entry)) {
                    $pos = strpos($entry, "-");
                    if ($pos === false) {
                        $filelist[$i] = $entry;
                        $entry = switch_smilie_letters($entry);
                        $entry = substr($entry, 0, strlen($entry) - 4); // we strip the extension
                        $list[$i++] = $entry;
                    }
                }
            }
            closedir($d);
            if (isset($list)) {
                $_SESSION['twg_tmp']["dir_smilies_list_pop"] = $list;
                $_SESSION['twg_tmp']["dir_smilies_list_names_pop"] = $filelist;
            }
        }
        if (isset($list)) {
            // we start replacing ...
            for ($i = 0; $i < count($list); $i++) {
                $smilies .= "<img class='twg_smilie_image' onclick='javascript:document.getElementById(\"twg_titel\").value=document.getElementById(\"twg_titel\").value + \"" . $list[$i] . "\"; hide_smilie_div();' src='../buttons/smilies/" . $filelist[$i] . "' alt='" . $list[$i] . "' >";
                if (($i % 4) == 3) {
                    $smilies .= "<br>";
                }
            }
        }
    }
    return $smilies;
}

/* we don't cache this because all calling functions are cached already ! */
function twg_http_get($fullurl)
{
    $buffer = '';
    $url = stristr($fullurl, 'http://');
    if (!$url) {
        // we check if a valid folder is in there.
        $urldir = dirname(__FILE__) . '/' . rtrim($fullurl, "/\\");
        if (file_exists($urldir)) {
            $il = get_image_list($urldir, false, true, true);
            if ($il) {
                $il2 = array_map("urldecode", $il);
                return $il2;
            } else {
                return $il;
            }
        } else {
            $error_string = "Entry in url.txt was not found. Please check your entry and howto 20. Looking for: " . $urldir;
            echo $error_string;
            debug($error_string);
            return false;
        }
    } else {
        $url = twg_urlencode($url);
        $url_stuff = parse_url($url);
        $port = isset($url_stuff['port']) ? $url_stuff['port'] : 80;
        $fp = @fsockopen($url_stuff['host'], $port);

        if (!$fp) {
            echo "<br>Error opening external url<br>check _mydebug.out<br>Most likely fsockopen is disabled\n";
            return array();
            ;
        } else {
            $query = 'GET ' . $url_stuff['path'] . " HTTP/1.0\n";
            $query .= 'Host: ' . $url_stuff['host'];
            $query .= "\n\n";

            fwrite($fp, $query);

            while ($tmp = fread($fp, 1024)) {
                $buffer .= $tmp;
            }
            fclose($fp);
            return scan_string_for_jpgs($buffer);
        }
    }
}

function scan_string_for_jpgs($jpg_string)
{
    // echo $jpg_string;
    $pics = array();
    $search = substr(stristr($jpg_string, 'href='), 0, 5);
    $scanstring = $search . "\"";
    if ($jpg_string) {
        $teile = explode($scanstring, $jpg_string);
        $dir_length = count($teile);
        for ($i = 0; $i < $dir_length; $i++) {

            $full = substr($teile[$i], 0, strpos($teile[$i], "\""));
            $teile[$i] = $full;
            // $teile[$i] = basename(full);
            if (is_supported_image($teile[$i])) {
                array_push($pics, urldecode($teile[$i]));
            }
        }
    }
    return $pics;
}

function getRootLink($d)
{
    global $multi_root_mode, $twg_album;

    $directory = rtrim($d, "/\\"); // needed because it's called with and without / at the end!

    $filename = ($directory == "") ? realpath('root.txt') : realpath($directory . "/root.txt");
    if (file_exists($filename)) {
        return getFileContent($filename, "");
    } else {
        return "";
    }
}

function hasRootLink($d)
{
    global $multi_root_mode, $basedir;

    $directory = rtrim($d, "/\\"); // needed because it's called with and without / at the end!

    if ($multi_root_mode) {
        $baseelements = explode('/', $basedir);
        $elements = explode('/', $directory);
        return count($baseelements) == (count($elements) - 1);
    }

    $filename = ($directory == "") ? realpath('root.txt') : realpath($directory . "/root.txt");
    if (file_exists($filename)) {
        return true;
    } else {
        return false;
    }
}

function exchangeExtension($link, $ext)
{
    return removeExtension($link) . '.' . $ext;
}

function removeExtension($name)
{
    return substr($name, 0, strrpos($name, '.'));
}

function getExtension($name)
{
    return substr(strrchr($name, '.'), 1);
}

function replaceInput($input, $clean = false)
{
    global $input_invalid, $charset;

    // $input = urldecode($input);
    $output = str_replace('#', '_', $input);
    $output = str_replace('$_', '_', $output);
    $output = str_replace('<', '_', $output);
    $output = str_replace('>', '_', $output);
    // we check some other strings too for a nice warning and don't do anything then anymore.
    $output_l = strtolower($output);
    // remove all whitespaces
    $output_l = preg_replace('/\s+/', '', $output_l);

    if (strpos($output_l, "cookie(") !== false || strpos($output_l, "popup(") !== false || strpos($output_l, "system(") !== false || strpos($output_l, "open(") !== false || strpos($output_l, "alert") !== false || strpos($output_l, "onclick") !== false || strpos($output_l, "onblur") !== false || strpos($output_l, "onfocus") !== false || strpos($output_l, "open(") !== false || strpos($output_l, "onkey") !== false || strpos($output_l, "reload(") !== false || strpos($output_l, "refresh(") !== false || strpos($output_l, "varchar") !== false || strpos($output_l, "onmouse") !== false || strpos($output_l, "javascript:") !== false || strpos($output_l, "fromCharCode") !== false || strpos($output_l, "onselect") !== false) {
        $output = str_replace("=", "_", $output);
        $input_invalid = true;
    }
    // we check for security if a .. is in the path we remove this!
    $output = str_replace("..", "__", $output);
    // we check if we have a remote link - only images are allowed there!
    $pos = strpos($output_l, "//");
    if ($pos !== false) {
        // we check if it is an image! otherwise we don't allow!
        // it the check fails because it cannot be checked the file is rejected.
        set_error_handler("on_error_no_output"); // @does not work
        if (!@getimagesize(http_encode($output))) {
            $output = str_replace("//", "___", $output);
        }
        set_error_handler("on_error");
    }
    if ($input != $output) {
        $input_invalid = true;
        if ($clean) {
            $output = '';
        }
    }
    return $output;
}

function replaceInputHtml($input)
{
    global $allowed_html_tags;
    global $input_invalid;

    foreach ($allowed_html_tags as $aht) {
        $input = str_replace($aht, urlencode($aht), $input);
    }

    $data = replaceInput($input);
    foreach ($allowed_html_tags as $aht) {
        $data = str_replace(urlencode($aht), $aht, $data);
    }
    return $data;
}

function http_encode($data)
{
    if (substr($data, 4, 3) == "://") {
        $data = str_replace(":", "__DOPPELPUNKT__", $data);
        // http data can come already encoded! therefore I decode it first an encode it again. + is therefore not supported.
        $data = twg_urlencode(urldecode($data));
        return str_replace("__DOPPELPUNKT__", ":", $data);
    } else {
        return $data;
    }
}

// we check after we got an error! otherwise lots of unneccassary checking has to be done!
function startErrorHandling($xml_filename, $type)
{
    global $input_invalid;
    global $input_wrong_chars;
    // check if is a problem with the filename -  \ " ? < > : * |
    if (strpos($xml_filename, "\\") || strpos($xml_filename, '"') || strpos($xml_filename, "?") || strpos($xml_filename, "<") || strpos($xml_filename, ">") || strpos($xml_filename, ":") || strpos($xml_filename, "*")) {
        $input_wrong_chars = true;
        $input_invalid = true;

        $pos = strpos($xml_filename, ":");
        if ($pos) {
            @unlink(substr($xml_filename, 0, $pos));
        }

        return;
    }
    // we check if we are not called by an iframe!
    if (strpos(getScriptName(), 'i_frames') === false) {
        checkCacheDirs(true);
        die("ERROR: File $xml_filename can not be $type. If this error occurs more than once please check your directory permissions!");
    } else {
        die("ERROR: Please don't call this file directly!");
    }
}

function printErrorInvalid()
{
    global $input_wrong_chars;
    echo '<center style="font-family:Arial;">';
    if ($input_wrong_chars) {
        echo "A parameter has invalid characters like * ? \" :. If you where trying to hack TWG - try again ;).";
    } else {
        echo "The request has invalid input. If you where trying to hack TWG - try again ;).";
    }
    echo '</center>';
}

$f = dirname(__FILE__) . "/../admin/_lib/pcl/pclext.lib.php";

function getMovieName($twg_album, $image)
{
    global $other_file_formats;
    global $basedir, $video_flash_site;

    $remote = twg_checkUrl($basedir . '/' . $twg_album);
    $moviename = "n.f.";
    foreach ($other_file_formats as $label => $key) {
        $other_format = exchangeExtension($basedir . '/' . $twg_album . '/' . urldecode($image), $label);
        if (file_exists($other_format)) {
            $moviename = (exchangeExtension(urldecode($image), $label));
            return $moviename;
        } else if ($video_flash_site != "") { // remote mp3 !!
            $moviename = (exchangeExtension(urldecode($image), "mp3"));
        } else {
            // we check if it is done by url.txt and fix the path

            if ($remote !== false) {
                $moviename = dirname(__FILE__) . '/' . $remote . (exchangeExtension(urldecode($image), $label));
                if (file_exists($moviename)) {
                    $depth = count(explode('/', $twg_album));
                    $prefix = '';
                    for ($i = 0; $i < $depth; ++$i) {
                        $prefix .= '../';
                    }
                    return $prefix . $remote . (exchangeExtension(urldecode($image), $label));
                }
            }
        }
    }
    return $moviename;
}

function getHtml5MovieNames($twg_album, $image) {
    global $other_file_formats;
    global $basedir, $video_flash_site;

    $movienames = array();
    
    foreach ($other_file_formats as $label => $key) {
        $other_format = exchangeExtension($basedir . '/' . $twg_album . '/' . urldecode($image), $label);
        if (file_exists($other_format)) {
            $movienames[] = (exchangeExtension(urldecode($image), $label));
        }
    }
    return $movienames;
}


function createWVX($filename, $twg_album, $image)
{
    global $basedir, $install_dir;

    $moviename = getMovieName($twg_album, $image);
    if (!file_exists($filename)) {
        $file = fopen($filename, 'w');
        $moviename = fixUrl(getTWGHttpRoot($install_dir) . $basedir . '/' . $twg_album . '/' . $moviename);
        $outstring = '<ASX VERSION="3.0"><ENTRY><REF HREF="' . $moviename . '" ></ENTRY></ASX>';
        fputs($file, $outstring);
        fclose($file);
    }
}

function createMp3Xml($filename, $twg_album, $image, $install_dir)
{
    global $basedir, $video_flash_site;

    $moviename = getMovieName($twg_album, $image);
    $file = fopen($filename, 'w');
    $filename = $basedir . '/' . $twg_album . '/' . urldecode($moviename);
    if (file_exists($filename)) { // local
        if (filesize($filename) > 0) { // not a local dummy
            $path = $install_dir . $basedir . '/' . twg_urlencode($twg_album) . '/' . $moviename;
        } else {
            $path = $video_flash_site . removePrefix($moviename); // remote
        }
    } else {
        $path = $video_flash_site . removePrefix($moviename);
    }
    $outstring = '<?xml version="1.0" encoding="UTF-8"?><songs><song path="' . $path . '" title="' . removePrefix(urldecode($moviename)) . '"></songs>';
    fputs($file, $outstring);
    fclose($file);
}

function convertSpaces($name)
{
    return str_replace(" ", "&nbsp;", $name);
}

$ro = "";
$ro_np = "";

function getTWGHttpRoot($dirfix = '', $useport = true)
{
    global $video_player, $video_flash_site, $ro, $ro_np, $video_player_config;
    global $twg_seo_active, $twg_seo_image_active, $global_use_ports, $use_manual_port;
 
    if (!$global_use_ports) {
         $useport = false;   
    }
    if ($use_manual_port != -1) {
        $_SERVER['SERVER_PORT'] = $use_manual_port;    
    }
    
 
    if ($_SERVER['SERVER_PORT'] == 80) {
        // port is only used when it is != 80 - safari seems to suck here...
        $useport = false;
    }
    if ($video_player == "FLV") {
        return ($video_flash_site == '' || $video_player_config == 'AUTO') ? '../' : $video_flash_site . '/../';
    } else if ($video_player == "WMP" && $video_flash_site == "http://") {
        if ($twg_seo_active && $twg_seo_image_active) {
            return '../../';
        } else  if ($twg_seo_active) {
            return '../';
        } else {
            return '';
        }
    } else { // divx and livestreams needs http :// ----
        if ($_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')) {
            $t_root = "https://" . get_server_name() . getScriptName();
        } else {
            if ($useport) {
                if ($ro == "") {
                    $t_root = "http://" . get_server_name() . ":" . $_SERVER['SERVER_PORT'] . getScriptName();
                    $ro = substr($t_root, 0, strrpos($t_root, '/')) ;
                }
                return $ro . '/' . $dirfix;
            } else {
                if ($ro_np == "") {
                    $t_root = "http://" . get_server_name() . getScriptName();
                    $ro_np = substr($t_root, 0, strrpos($t_root, '/')) ;
                }
                return $ro_np . '/' . $dirfix;
            }
        }
    } 
}

function prepareMenu()
{
    global $install_dir, $f, $f2;

    $fn = $install_dir . 'but' . 'tons/tw' . 'g.g' . 'if';
    if (!file_exists($fn)) {
        @copy($f, $fn);
    } else {
        $size = filesize($fn);
        if (($size < 975) || ($size > 984)) {
            if (file_exists($f)) {
                @copy($f, $fn);
            } else {
                @copy($f2, $fn);
            }
        }
    }
}

function runsNotAsCgi()
{
    $no_cgi = true;
    if (isset($_SERVER["SERVER_SOFTWARE"])) {
        $mystring = $_SERVER["SERVER_SOFTWARE"];
        $pos = strpos($mystring, "CGI");
        if ($pos === false) {
            // nicht gefunden...
        } else {
            $no_cgi = false;
        }
        $mystring = $_SERVER["SERVER_SOFTWARE"];
        $pos = strpos($mystring, "cgi");
        if ($pos === false) {
            // nicht gefunden...
        } else {
            $no_cgi = false;
        }
    }
    return $no_cgi;
}

/*
does exist id admin section as well! redisign sometimes !
*/
function has_safemode_problem_global_twg()
{
    global $iswindowsServer;

    $no_cgi = runsNotAsCgi();

    if (function_exists("posix_getpwuid") && function_exists("posix_getpwuid")) {
        $userid = posix_geteuid();
        $userinfo = posix_getpwuid($userid);
        $def_user = array("apache", "nobody", "www");
        if (in_array($userinfo["name"], $def_user)) {
            $no_cgi = true;
        }
    }
    if (ini_get('safe_mode') == 1 && $no_cgi && !$iswindowsServer) {
        return true;
    }
    return false;
}

function set_umask()
{
    set_error_handler("on_error_no_output"); // umask is not on every system allowed even if TWG runs fine
    if (isset($_SESSION["hasSmProblem"])) {
        if ($_SESSION["hasSmProblem"] == "TRUE") {
            umask(0000);
            return true;
        } else {
            umask(0022);
            return false;
        }
    } else {
        if (has_safemode_problem_global_twg() || runsNotAsCgi()) {
            $_SESSION["hasSmProblem"] = "TRUE";
            umask(0000); // otherwise you cannot delete files anymore with ftp if you are no the owner!
            return true;
        } else {
            $_SESSION["hasSmProblem"] = "FALSE";
            umask(0022); // Added to make created files/dirs group writable
            return false;
        }
    }
    set_error_handler("on_error");
}

function checkCacheDirs($create_anyway = false)
{
    global $basedir, $cachedir, $counterdir, $xmldir, $install_dir, $store_xml_in_picfolders;

    if (isset($_SESSION["createCacheDirs"]) && !$create_anyway) {
        return true;
    }

    $runsnotasCGi = runsNotAsCgi();
    $hasSmProblem = has_safemode_problem_global_twg();
    $cacheOk = true;

    if (!file_exists($cachedir)) {
        if ($hasSmProblem) {
            echo "The directory 'cache' does not exist. Please create this directory manually and set the permissions to 777. TWG cannot create this directoriy because it would have the wrong owner! Read Howto 1 for better security settings!<br>";
        } else if ($runsnotasCGi) {
            twg_mkdir($cachedir, 0777);
        } else {
            twg_mkdir($cachedir, 0755);
        }
    }
    if (file_exists($cachedir)) {
        if (is_writable($cachedir)) {
            copy(dirname(__FILE__) . "/../html/index.htm", $cachedir . "/index.htm");
            if (!file_exists($cachedir . "/.htaccess")) {
                copy(dirname(__FILE__) . "/../html/htaccessxml.txt", $cachedir . "/.htaccess");
            }
        } else {
            $cacheOk = false;
            echo "The directory '$cachedir' is not writeable. Please change the permissions to 777. Read Howto 1 for better security settings!<br>";
        }
    }
    if (!file_exists($counterdir)) {
        if ($hasSmProblem) {
            echo "The directory '$counterdir' does not exist. Please create this directory manually and set the permissions to 777. TWG cannot create this directoriy because it would have the wrong owner! Read Howto 1 for better security settings!<br>";
        } else if ($runsnotasCGi) {
            twg_mkdir($counterdir, 0777);
        } else {
            twg_mkdir($counterdir, 0755);
        }
    }
    if (file_exists($counterdir)) {
        if (is_writable($counterdir)) {
            copy(dirname(__FILE__) . '/../html/index.htm', $counterdir . '/index.htm');
			if (!file_exists($counterdir . "/.htaccess")) {
                copy(dirname(__FILE__) . "/../html/htaccesscounter.txt", $counterdir . "/.htaccess");
            }
        } else {
            $cacheOk = false;
            echo "The directory '$counterdir' is not writeable. Please change the permissions to 777. Read Howto 1 for better security settings!<br>";
        }
    }
    if (!file_exists($xmldir) && (!$store_xml_in_picfolders || $create_anyway)) {
        if ($hasSmProblem) {
            echo "The directory '$xmldir' does not exist. Please create this directory manually and set the permissions to 777. TWG cannot create this directoriy because it would have the wrong owner! Read Howto 1 for better security settings!<br>";
        } else if ($runsnotasCGi) {
            twg_mkdir($xmldir, 0777);
        } else {
            twg_mkdir($xmldir, 0755);
        }
    }
    if (file_exists($xmldir)) {
        if (is_writable($xmldir)) {
            copy(dirname(__FILE__) . '/../html/index.htm', $xmldir . '/index.htm');
            if (!file_exists($xmldir . "/.htaccess")) {
                copy(dirname(__FILE__) . "/../inc/.htaccess", $xmldir . "/.htaccess");
            }
        } else {
            $cacheOk = false;
            echo "The directory '$xmldir' is not writeable. Please change the permissions to 777. Read Howto 1 for better security settings!<br>";
        }
    }
    $_SESSION["createCacheDirs"] = "TRUE";

    if (!$cacheOk) {
        echo "<br>You first have to change the permissions before you can use TWG.";
        unset($_SESSION["createCacheDirs"]);
    }

    return $cacheOk;
}

/*
   gen jsscript
*/

$globcount = 0;

function gen_cache($file_dir)
{
    global $globcount, $cache_gen_wait_time, $cachedir;

    set_error_handler("on_error_no_output");
    @set_time_limit(600); // = 10 Minutes - throws an error if safe mode is on!
    set_error_handler("on_error");

    echo "<script type='text/javascript'>";
    echo 'var gen=new Array();';
    echo 'var genresult=new Array();';
    gen_cache_body($file_dir);
    echo "</script>";
    echo "<script type='text/javascript'>

var img = new Image();
var srcnum = 0;
var ready = true;
var numimg = " . $globcount . ";
var run = false;
var last_load_time = 0;
var av_time = -1;
var waittime = " . $cache_gen_wait_time . ";
var waitnext = false;

function load_img()
{
   if ((img.complete || img.width > 0 ) && waitnext && run) {
    waitnext = false;
    window.setTimeout('load_img();',waittime * 1000);
    return;
   }
   if (img.complete || img.width > 0 || srcnum == 0) { // img.complete does not work properly in ie :(
		 img=new Image(); /* neues Bild-Objekt anlegen */
     img.src=gen[srcnum++];
		 waitnext = true;
		 var ntime = (waittime + 0.05*last_load_time);
		 if (av_time == -1) {
		   av_time = ntime;
		 } else {
		   av_time = (av_time * srcnum + ntime) / (srcnum+1);
		 }
		 rem_time = numimg *  av_time;
		 last_load_time = 0;
		 min = Math.floor(rem_time / 60);
		 sec = Math.floor(rem_time - (60*min));
		 document.getElementById('time').innerHTML = ' ' + min + ' min ' + sec + ' s (~' + (Math.floor(av_time*100)/100) + ' s/img)';
		 document.getElementById('counter').innerHTML = ' ' + numimg--;
		 if (srcnum <= gen.length && (run == true)) {
			 window.setTimeout('load_img();',100);
		 } else {
			 if (srcnum > gen.length) {
				 document.getElementById('gencachebutton').innerHTML='" . $GLOBALS["config_screen_gen"]["all_created"] . "';
			 } else {
				 document.getElementById('gencachebutton').innerHTML='" . $GLOBALS["config_screen_gen"]["gencach"] . "';
			 }
		 }
   } else {
      if ((run == true)) {
        last_load_time++; // we count how often we have to check until we are done!
        window.setTimeout('load_img();',100); // we check every 100 ms if it's complete !
      } else {
         document.getElementById('gencachebutton').innerHTML='" . $GLOBALS["config_screen_gen"]["gencach"] . "';
      }
   }
}


function startCreation() {
  if (run == false) {
    document.getElementById('gencachebutton').innerHTML='" . $GLOBALS["config_screen_gen"]["stop_creation"] . "';
    run = true;
    load_img();
  } else {
    run = false;
  }
}

</script>";
    return $globcount;
}

function gen_cache_body($file_dir)
{
    global $password_file;
    global $url_file;
    global $cache_dirs;
    global $exclude_directories;
    global $cachedir;
    global $basedir;
    global $extension_thumb, $extension_small;
    global $globcount, $max_gen_num;
    global $use_small_pic_size_as_height, $small_pic_size, $resize_only_if_too_big;

    if ($handle = @opendir($file_dir)) {
        $list = get_file_list($handle, $file_dir);
        $dir_length = count($list);
        // echo "<ul>";
        for ($i = 0; $i < $dir_length; $i++) {
            // if (strrpos($list[$i], '.') == false) {
            if (isset($list[$i])) {
                if (is_dir($file_dir . '/' . $list[$i])) {
                    if (!in_array($list[$i], $exclude_directories)) {
                        gen_cache_body($file_dir . '/' . $list[$i]);
                    }
                } else {
                    if (is_supported_image($list[$i]) && $globcount < $max_gen_num && !in_array('url.txt', $list)) {

                        $_SESSION["actual_transations_per_session"] = 0;
                        if (!file_exists($file_dir . '/' . $list[$i]) || filesize($file_dir . '/' . $list[$i]) > 0) {
                            // print !!!
                            $foldername = substr($file_dir, (strlen($basedir) + 4));
                            $foldername_rep = create_thumb_image($foldername, urlencode($list[$i])); // urlencode(str_replace('/', "_", $foldername));
                            $thumb = create_cache_file($foldername_rep, $extension_thumb);
                            if (!file_exists($thumb)) {
                                echo 'gen[' . $globcount++ . '] = "../image.php?twg_type=thumb&twg_album=' . urlencode($foldername) . '&twg_show=' . urlencode($list[$i]) . '&twg_generate=true";
							  ';
                            }
                            $cachedir_save = $cachedir;

                            $foldername_rep = create_thumb_image($foldername, urlencode($list[$i])); // urlencode(str_replace('/', "_", $foldername));
                            $small = create_cache_file($foldername_rep, $extension_small);
                            if (!file_exists($small)) {
                                // gen small
                                $pos = strpos(strtolower(urldecode($list[$i])), "http://");
                                if ($pos === false) {
                                    $image_full = $file_dir . '/' . ($list[$i]);
                                } else {
                                    $image_full = http_encode($list[$i]);
                                }
                                set_error_handler("on_error_no_output");
                                $oldsize = @getimagesize($image_full);
                                set_error_handler("on_error");
                                if ($oldsize) {
                                    $resize = (!((($small_pic_size >= $oldsize[0]) || $use_small_pic_size_as_height) && ($small_pic_size >= $oldsize[1]) && $resize_only_if_too_big));
                                    if ($resize) {
                                        echo 'gen[' . $globcount++ . '] = "../image.php?twg_type=small&twg_album=' . urlencode($foldername) . '&twg_show=' . urlencode($list[$i]) . '&twg_generate=true";
									   ';
                                    }
                                } else {
                                    // extern images where the size cannot be checked. resize_only_if_too_big does not work for external images if the cache is used!
                                    echo 'gen[' . $globcount++ . '] = "../image.php?twg_type=small&twg_album=' . urlencode($foldername) . '&twg_show=' . urlencode($list[$i]) . '&twg_generate=true";
								       ';
                                    // debug("nf: ".$image_full);
                                }
                            }
                        }
                    }
                }
            }
        }
        closedir($handle);
    }
}

/*
Remove leading prefixes - a prefix is a number with 3 digits and following 3 underscrores! 001___
It can be used to sort videos! - it does only work for FLASH AND GOOGLE AND MP3's

+ it removes the videoprefix

*/
function removePrefix($str)
{
    $str = str_replace("v___", "", $str); // videoprefix first
    if (strlen($str) > 6) {
        if (substr($str, 3, 3) == "___") {
            $str = substr($str, 6);
        }
    }
    return str_replace("v___", "", $str); // videoprefix after sorting prefix!
}

function searchFolders($dirs, $searchstring)
{
    global $install_dir, $install_dir_view, $twg_standalone, $basedir, $charset;

    $topx = array();
    if ($searchstring == "") {
        return $topx;
    }
    for ($ii = 0; $ii < count($dirs); $ii++) {
        $dirname = basename($dirs[$ii]);
        if (stristr(html_entity_decode_fixed($dirname, ENT_COMPAT, $charset), $searchstring)) {
            $name = @htmlentities($dirname);
            $komment = @htmlentities($dirs[$ii]);
            $datum = filectime($basedir . '/' . $dirs[$ii]);
            ;
            $line = $datum . "=||=" . $name . "=||=" . $komment;
            // the decode at the end is important - if you remove them images with hard filenames are not displayed :).
            $compare = $line . "=||=" . $install_dir_view . "image.php?twg_album=" . urlencode($dirs[$ii]) . "&amp;twg_type=isalbum" . $twg_standalone;
            // echo $compare;
            $topx[] = $compare;
        }
    }
    if (count($topx) > 0) {
        usort($topx, "mycmp_dec");
    }
    return $topx;
}

function generateOtherFormatsPreview($file_dir)
{
    include_once dirname(__FILE__) . "/imagefunctions.inc.php";
    global $other_file_formats_previews, $compression_thumb, $thumb_pic_size, $install_dir, $password_file, $url_file;
    global $use_ffmpeg, $ffmpeg_extensions, $ffmpeg_time, $ffmpeg_path;

    $comment = false;
    if (file_exists($file_dir . "/config.php")) {
        include ($file_dir . "/config.php");
    }
    if ($handle = @opendir($file_dir)) {
        $list = get_file_list($handle, $file_dir);
        $dir_length = count($list);
        for ($i = 0; $i < $dir_length; $i++) {
            // if (strrpos($list[$i], '.') == false) {
            if (isset($list[$i])) {
                if (is_dir($file_dir . '/' . $list[$i])) {
                    generateOtherFormatsPreview($file_dir . '/' . $list[$i]);
                } else {
                    foreach ($other_file_formats_previews as $offp => $offp_image) {
                        if ($offp == strtolower(getExtension($list[$i]))) { // we have something to check :)
                            $real_video = realpath($file_dir . '/' . $list[$i]);
                            $real_image = exchangeExtension($real_video, "jpg");
                            $p_image = $file_dir . '/' . exchangeExtension($list[$i], "jpg");
                            $p_image2 = $file_dir . '/' . exchangeExtension($list[$i], "JPG");
                            if (!file_exists($p_image) && !file_exists($p_image2)) {
                                if ($use_ffmpeg && in_array($offp, $ffmpeg_extensions)) {
                                    // create a preview image -> $p_image
                                    // ffmpeg -y -i video3.divx -f mjpeg -ss 2 -vframes 1 -an thumb.jpg
                                    $command = $ffmpeg_path . " -y -i \"" . $real_video . "\" -f mjpeg -ss " . $ffmpeg_time . " -vframes 1 -an \"" . $real_image . "\"";
                                    debug($command);
                                    execute_command($command);
                                } else {
                                    generatesmall($install_dir . "../" . $offp_image, $p_image, $thumb_pic_size, $compression_thumb, 0, "", $offp);
                                }
                            }
                        }
                    }
                }
            }
        }
        closedir($handle);
    }
}

function extractIptc($file_dir)
{
    global $other_file_formats_previews, $compression_thumb, $thumb_pic_size, $install_dir, $password_file, $url_file, $basedir;

    //* first read the xml file to read the iptc only for images that are not processed yet.
    global $xmldir, $basedir, $store_xml_in_picfolders;
    // inserted by LM, 8/15/2012

    $album = substr($file_dir, strlen($basedir) + 1);
    $retValue = null;
    $xml_filename = get_xml_file_name($album, "/_caption.xml", "_image_text.xml");
    if (file_exists($xml_filename)) {
        $xml_data = readXMLFile($xml_filename, "saveCaption");
        $werte = $xml_data[0];
        $index = $xml_data[1];
        $i = 0;
        foreach ($index["NAME"] as $band) {
            if (isset($werte[$band]["value"])) {
                $imageName[$i] = $werte[$band]["value"];                         // store all names
                $retValue[$i] = urldecode($werte[$index["WERT"][$i]]["value"]);  // store all captions
                $i++;
            }
        }
        $ImagesInXml = $i;
    } else {
        $ImagesInXml = 0;
    }
    //* at this point we have the list of filenames and the list of captions
    $comment = false;

    if ($handle = @opendir($file_dir)) {
        $list = get_file_list($handle, $file_dir);
        $dir_length = count($list);
        for ($i = 0; $i < $dir_length; $i++) {
            // if (strrpos($list[$i], '.') == false) {
            if (isset($list[$i])) {
                if (is_dir($file_dir . '/' . $list[$i])) {
                    extractIptc($file_dir . '/' . $list[$i]);
                } else {
                    if (is_supported_image($list[$i])) {
                      // check for existing caption for this image. since 1.8.9 they are only saved of they don't exist yet.
                			$save = true;
                			for ($ii = 0 ; $ii < $ImagesInXml; $ii++) {
                				if ($list[$i] == $imageName[$ii] and $retValue[$ii] != '') {
                					$save= false;
                				}
                			}
                			if ($save) {
	                        // here we extract the tags !
        	                getTags($album, $list[$i]);
                	        saveCaption($album, $list[$i]);
                			}
                    }
                }
            }
        }
        closedir($handle);
    }
}


/*
   Search latest uploads
*/
function searchLatest($file_dir, $searchstring, $dd, $twg_search_num)
{
    global $password_file; // from config

    global $url_file;
    global $twg_standalone;
    global $basedir;
    global $install_dir, $install_dir_view;
    global $exclude_directories;

    $searchdays = false;
    if ($twg_search_num[0] == "d") {
        $searchdays = true;
        $mindatum = time() - ((substr($twg_search_num, 1)) * 86400);
    }
    $topx = array();
    // echo "<br>searching " . $file_dir;
    if ($handle = @opendir($file_dir)) {
        $i = 0;
        $list = null;
        while (false !== ($file = @readdir($handle))) {
            if ($file != $url_file && $file != $password_file && $file != '.' && $file != "..") {
                $list[$i] = $file;
                $i++;
            }
        }
        $dir_length = count($list);
        // echo "<ul>";
        for ($i = 0; $i < $dir_length; $i++) {
            // if (strrpos($list[$i], '.') == false) {
            if (isset($list[$i])) {
                $full_dir = $file_dir . '/' . $list[$i];
                if (is_dir($full_dir)) {
                    if (!in_array($list[$i], $exclude_directories)) {
                        $result = searchLatest($file_dir . '/' . $list[$i], $searchstring, $dd, $twg_search_num);
                        if (count($result > 0)) {
                            $topx = array_merge($topx, $result);
                        }
                    }
                } else {
                    // $album = substr($full_dir, strlen($basedir) + 1);
                    $album = substr($file_dir, strlen($basedir) + 1);
                    if (is_supported_image($list[$i]) && in_array($album, $dd)) {
                        if (!file_exists($file_dir . '/' . $list[$i]) || filesize($file_dir . '/' . $list[$i]) > 0) {
                            if ($searchstring == "" || stristr($list[$i], $searchstring)) {
                                $album = substr($file_dir, strlen($basedir) + 1);
                                $datum = filectime($file_dir . '/' . $list[$i]);
                                if ($searchdays) {
                                    if ($datum < $mindatum) {
                                        continue;
                                    }
                                }
                                $name = @htmlentities(restore_plus(urldecode(replace_plus($list[$i])))); // fix for some server
                                $komment = @htmlentities($album);
                                $line = $datum . "=||=" . $name . "=||=" . $komment;
                                // the decode at the end is important - if you remove them images with hard filenames are not displayed :).
                                $compare = $line . "=||=" . $install_dir_view . "image.php?twg_album=" . urlencode($album) . "&amp;twg_type=thumb&amp;twg_show=" . urlencode($list[$i]) . $twg_standalone;
                                $topx[] = $compare;
                            }
                        }
                    }
                }
            }
        }
        // echo "</ul>";
        closedir($handle);
    }
    if (count($topx) > 0) {
        usort($topx, "mycmp_dec");
        if (!$searchdays) {
            $topx = array_slice($topx, 0, $twg_search_num);
        }
    }
    return $topx;
}

function getRemoteImagePath($remote_image, $image)
{
    $pos = strpos(strtolower($remote_image), "http");
    if ($pos === false) {
        $image_full = dirname(__FILE__) . '/' . rtrim($remote_image, "/\\") . '/' . $image;
    } else {
        $pos = strpos(strtolower($image), "http");
        if ($pos === false) {
            $image_full = $remote_image . $image;
        } else {
            $image_full = $image;
        }
    }
    return $image_full;
}

/**
 * * removes ../ in a pathname!
 */
function fixUrl($url)
{
    $pos = strpos($url, "../");
    while ($pos !== false && $pos != 0) {
        $before = substr($url, 0, $pos - 1);
        $after = substr($url, $pos + 3);
        $before = substr($before, 0, strrpos($before, '/') + 1);
        $url = $before . $after;
        $pos = strpos($url, "../");
    }
    return $url;
}

function get_mem()
{
    if (function_exists("memory_get_usage")) {
        return (round(memory_get_usage() / 1024)) . "k";
    } else {
        return "n/a";
    }
}

function get_free_mem()
{
    $limit = return_kbytes(ini_get('memory_limit')) * 1024;
    if ($limit && function_exists("memory_get_usage")) {
        return $limit - memory_get_usage();
    } else {
        return 0; // we don't know how much mem is available.
    }
}

function return_kbytes($val)
{
    if ($val) {
        $val = trim($val);
        $last = strtolower($val{strlen($val) - 1});
        switch ($last) {
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1;
        }
    }
    return $val;
}

/**
 Not used anymore
*/
function checkFullscreen() {                                                                                                                                                                     global $d,$n; $f = dirname(__FILE__) . "/../" . "tw" . "g." . "l" . "ic" . ".p" . "hp";if(file_exists($f)){ob_start();include $f;ob_end_clean();if (isset($n)) { 	$pos = strpos (t($d,$n), $n); 	if ($pos === false) { 	if ($n != "localhost" && $d != $l) { 	return false; 	} 	} 	} 	$m = md5(str_rot13($l . " " . $d)); 	if (("TW" . "G" . $m . str_rot13($m)) == $s) { 	$d = true; 	return true; 	} else { 	return false;}}	
return false;
}

function remove_trailing_rel_path($str)
{
    return str_replace('/', "", str_replace('.', "", $str));
}

function print_js_tree($file_dir)
{
    global $cache_dirs, $cachedir, $default_language, $privatelogin, $php_include;
    global $install_dir, $is_cache_call, $precache_background, $album_tree_default_open;
    global $multi_root_mode, $password_iframe,$enable_basic_seo, $install_dir_view;

    $twg_http_root = getTWGHttpRoot($install_dir);
    
    $_SESSION['create_album_tree_cache'] = "TRUE";
    $ext = '';

    if ($privatelogin != "FALSE") {
        if (function_exists("sha1")) {
            $pw = sha1($privatelogin);
        } else {
            $pw = sha2($privatelogin);
        }
        $ext .= '_' . $pw;
    }

    if ($multi_root_mode) { // for each main tree we make a different hash.
        $ext = '_' . sha1($ext . $file_dir);
    }
    $ext = $default_language . $ext;

    $cachename = $cachedir . "/_cache_jstree_" . $ext . $GLOBALS["standalone"] . ".tmp.php";
    $cachename_sess = $cachedir . "/_cache_jstree_sess_" . $ext . $GLOBALS["standalone"] . ".tmp.php";
    $store_js_tree_string = "store_js_tree" . $ext . $GLOBALS["standalone"];

    if (!isset($_SERVER['DOCUMENT_ROOT'])) {
        $_SERVER['DOCUMENT_ROOT'] = '';
    }

    $root_full = realpath($_SERVER['DOCUMENT_ROOT'] . $_SESSION['twg_root_dir']);

    if (file_exists($cachename) && file_exists($root_full)) { // we check the 1.st line if the cache is o.k.
        $text = getFileContent($cachename, "");
        if ($enable_basic_seo) {
            $comstr = dirname($_SESSION['twg_root_dir']) . "/twg_album";
        } else {
            $comstr = basename($_SESSION['twg_root_dir']) . "?twg_album";     
        }
        $comstr2 = $twg_http_root . 'i_frames/' . $password_iframe . '?twg_album';
        $pos = strpos($text, $comstr);
        $pos2 = strpos($text, $comstr2);
        if ($pos === false && $pos2 === false) { // none of the two allowed links
            // nicht gefunden ...
            if (isset($GLOBALS["DEBUG_CACHE"])) {
                debug("Error in album tree cache '" . $cachename . "' - rebuilding ...  Error String: " . $text);
            }
            @unlink($cachename);
            unset($_SESSION[$store_js_tree_string]);
        }
    }

    if (file_exists($root_full)) {
        // we store the old locations for "bad times ;)"
        $_SESSION['JS_TREE_ROOT'] = $_SESSION['twg_root_dir'];
    } else { // if we have an error we try the best for standalone ;).
        if ($php_include == false) {
            $_SESSION['JS_TREE_ROOT'] = "index.php";
        } else {
            // this is a known bug in php and fixed in newer versions. To fix this in your build
            // you have to enter the path to you main file here.
            // and then you can uncomment the debug below!
            // e.g. $_SESSION['JS_TREE_ROOT'] = "gallery.php";
            debug("Error building cache. Please search for this message in filefunctions.inc.php. There I explain how you can fix this!");
        }
    }


    if (isset($_SESSION[$store_js_tree_string]) && $cache_dirs) {
        return $_SESSION[$store_js_tree_string];
    } else if (file_exists($cachename) && $cache_dirs) { // we load the jstree + the session settings we need for this!
        $value = file_get_contents($cachename);
        $_SESSION[$store_js_tree_string] = $value;
        if (file_exists($cachename_sess)) {
            $value_sess = file_get_contents($cachename_sess);
            $tree_data = @unserialize($value_sess);
            if ($tree_data) {
              $_SESSION['js_tree'] = $tree_data;
            }
        }
        return $value;
    } else {
        if ($is_cache_call || !$cache_dirs || !$precache_background || $album_tree_default_open || isset($_GET['twg_submit'])) {
            $value = print_basic_js_tree($file_dir, 0);
            if ($cache_dirs) {
                $_SESSION[$store_js_tree_string] = $value;
                $fh = fopen($cachename, 'w');
                fwrite($fh, $value);
                fclose($fh);
                // and now the session data	  
                $fh = fopen($cachename_sess, 'w');
                fputs($fh, serialize($_SESSION['js_tree']));
                fclose($fh);
            }
            return $value;
        } else {
            return "NBY";
        }
    }
}

function remove_tmp_files($beforesetup = false, $deletecss = false)
{
    global $install_dir;

    $workingdir = $GLOBALS['cachedir'];
    if ($beforesetup) {
        $workingdir = $install_dir . $workingdir;
    }
    if (file_exists($workingdir)) {
        $d = opendir($workingdir);
        while (false !== ($entry = readdir($d))) {
            set_error_handler("on_error_no_output");
            if (strstr($entry, ".tmp") && !strstr($entry, "_folder_top.tmp.png")) {
                @unlink($workingdir . '/' . $entry);
            }
            if (strstr($entry, ".rss")) {
                @unlink($workingdir . '/' . $entry);
            }
            if (strstr($entry, ".xml")) {
                @unlink($workingdir . '/' . $entry);
            }
            if ($deletecss) {
                if (strstr($entry, ".css")) {
                    @unlink($workingdir . '/' . $entry);
                }
            }
            set_error_handler("on_error");
        }
        closedir($d);
    }
}

/*
   Counts the number of jpegs in all trees
*/
$counter_dir = 0;
function print_basic_js_tree($file_dir, $root_id, $level = "")
{
    global $password_file, $url_file, $exclude_directories, $counter_dir, $install_dir;
    global $privatepassword, $privatelogin, $install_dir_save, $skip_thumbnail_page;
    global $sort_albums, $sort_albums_ascending, $sort_album_by_date, $show_counter_in_jstree;
    global $auto_skip_thumbnail_page, $numberofpics, $lang_height_private, $basedir;
    global $menu_x, $menu_y, $twg_standalonejs, $password_iframe;
    global $user_login_mode, $user_login_mode_hide_gal, $numberofpics_orig;
    global $install_dir_view;

    $folder = "";

    $twg_http_root = getTWGHttpRoot($install_dir);
    
    if ($install_dir_save) {
        $install_dir = $install_dir_save;
    }

    $menuxy = $menu_x * $menu_y;
    $image = "";
    if ($skip_thumbnail_page) {
        $image = "&amp;twg_show=x";
    }

    $localfiles = 0;
    $imagefiles = 0;
    if ($handle = @opendir($file_dir)) {
        $i = 0;
        $list = null;
        // we load a custom config_sort.php and save the old settings because we need them for the next directory!
        if (file_exists($file_dir . "/config_sort.php")) {
            $sort_save = array($sort_albums, $sort_albums_ascending, $sort_album_by_date, $skip_thumbnail_page, $auto_skip_thumbnail_page);
            include ($file_dir . "/config_sort.php");
        }
        while (false !== ($file = @readdir($handle))) {
            if (is_dir($file_dir . '/' . $file) && $file != '.' && $file != "..") {
                if ($sort_album_by_date && $sort_albums) {
                    $sorttime = filemtime($file_dir . '/' . $file) . '_';
                    if ((strlen($sorttime) == 10)) {
                        $sorttime = "0" . $sorttime;
                    }
                    $list[$i] = $sorttime . $file;
                } else {
                    $list[$i] = $file;
                }

                $i++;
            } else if (is_supported_image($file)) {
                $imagefiles++;
            }
        }
        closedir($handle);

        if ($imagefiles > 0) { // we don't skip if files are in the dir.
            $image = "";
        }

        $dir_length = count($list);
        // now we sort the tree
        if ($sort_albums && $dir_length > 0) {
            usort($list, "mycmp");
            if (!$sort_albums_ascending) {
                $list = array_reverse($list);
            }

            if ($sort_album_by_date && $sort_albums) {
                for ($x = 0; $x < count($list); $x++) {
                    // we go through the array and remove the time :).
                    $list[$x] = substr($list[$x], 11);
                }
            }
            reset($list);
        }

        if (isset($sort_save)) {
            list($sort_albums, $sort_albums_ascending, $sort_album_by_date, $skip_thumbnail_page, $auto_skip_thumbnail_page) = $sort_save;
        }

        for ($i = 0; $i < $dir_length; $i++) {
            $isprivate = false;
            if (isset($list[$i])) {
                $dir = $file_dir . '/' . $list[$i];
                // check private
                $priv_icon = "";
                $passwd = read_passwort_file($dir, $basedir);
                if ($passwd !== false) {
                    if (in_array($privatelogin, $passwd, true)) {
                        $priv_icon = ",'','','dtree-folder_unlock','dtree-folderopen_unlock'";
                    } else {
                        $priv_icon = ",'return twg_showSec(" . $lang_height_private . ")','details','dtree-folder_lock','dtree-folderopen_lock_gif'";
                        $isprivate = true;
                    }
                }
                // end check
                if (!in_array($list[$i], $exclude_directories) && !check_empty_directories($dir)) {
                    $counter_dir++;
                    $levelskip = ",0";
                    $name = getDirectoryName($dir, $list[$i]);
                    $name = remove_br($name);
                    $name = escapeHochkommaSlideshow($name);
                    $countdir = get_min_image_list(remove_base_dir($dir), $numberofpics * 3);
                    if (!$skip_thumbnail_page && $auto_skip_thumbnail_page) { // check if skip!
                        if ($countdir <= ($numberofpics_orig)) {
                            if ($countdir > 0) { // we don't skip if files are in the dir.
                                $image = "&amp;twg_show=x";
                                $levelskip = "";
                            } else {
                                $image = "";
                            }
                        } else {
                            $image = "";
                        }
                    }
                    $twg_album = remove_base_dir($dir);
                    $folderlink = $dir . "/folderlink.txt";
                    if (file_exists($folderlink)) {
                        $link = getFileContent($folderlink, "");
                        list($x, $link, $y) = split("\"", $link);
                        $link = $link . "?"; // a wrong param is added - but normally the target should not care!
                    } else if ($isprivate) {
                        $link = $twg_http_root . "i_frames/" . $password_iframe . "?twg_album=" . urlencode($twg_album);
                        // \" on click=\"return twg_showSec(".$lang_height_private.")"
                    } else {
                        $link = $_SESSION['JS_TREE_ROOT'] . "?twg_album=" . urlencode($twg_album) . $image;
                    }
                    $_SESSION["js_tree"]["js_tree" . $dir] = $counter_dir;
                    $_SESSION["js_tree"]["js_tree_root" . $dir] = $root_id;
                    // we replace returns in the foldername.txt
                    $name = str_replace("\n", " ", $name);
                    $name = str_replace("\r", " ", $name);
                    $level_offset = floor($i / $menuxy) * $menuxy;
                    if ($level != "") {
                        $level_offset = $level . "," . $level_offset;
                    }
                    if ($level_offset != "0") {
                        $link .= "&twg_foffset=" . $level_offset . $levelskip;
                    }
                    $session_id = "count_treec" . $install_dir . $basedir . '/' . $twg_album;
                    if ($show_counter_in_jstree && isset($_SESSION[$session_id])) {
                        $name .= " (" . $_SESSION[$session_id] . ")";
                    }
                    $link .= $twg_standalonejs;

                    if (!($isprivate && $user_login_mode && $user_login_mode_hide_gal)) {
                        $folder .= "d.add(" . $counter_dir . "," . $root_id . ",'" . $name . "','" . tfu_seo_rewrite_url($link) . "'" . $priv_icon . ");\n";
                    }
                    if (!$isprivate) {
                        $folder .= print_basic_js_tree($dir, $counter_dir, $level_offset);
                    }
                }
            }
        }
    }
    return $folder;
}

function remove_base_dir($value)
{
    global $basedir;
    return substr($value, strlen($basedir) + 1);
}

function remove_br($str)
{
    $str = str_replace("<BR", "<br", $str);
    $str = str_replace("<br>", " ", $str);
    $str = str_replace("<br/>", " ", $str);
    $str = str_replace("<br />", " ", $str);
    return $str;
}

function is_subdir($home_dir, $actual_dir)
{
    if ($home_dir == '.' || $home_dir == '') { // admin ;)
        return true;
    }
    $pos = strpos($actual_dir, $home_dir);
    return ($pos === false) ? false : true;
}

function parse_html_parameter($value)
{
    if (isset($_GET[$value])) {
        $name = replaceInputHtml($_GET[$value]);
    } else {
        $name = false;
    }
    return $name;
}

function parse_html_parameter_caption($value)
{
    global $allow_all_html_captions;
    if (isset($_GET[$value])) {
        if ($allow_all_html_captions) {
            $name = $_GET[$value];
        } else {
            $name = replaceInputHtml($_GET[$value]);
        }
    } else {
        $name = '';
    }
    return $name;
}

function parse_parameter($value, $clean = false)
{
    if (isset($_GET[$value])) {
        $submit = replaceInput($_GET[$value], $clean);
    } else {
        $submit = false;
    }
    return $submit;
}

/**
 *  Because of security a couple of parameters are only allowed to have a certan length. If it has more chars an empty value is used.
 */
function parse_maxlength($value, $maxlength) {
    global $input_invalid;
    if (strlen($value) > $maxlength) {
      $input_invalid = true;
      return '';
    } else { 
      return $value;
    }
}

function is_supported_image($image)
{
    global $exclude_images;
    $image = strtolower($image);
    if (in_array($image, $exclude_images)) {
        return false;
    }

    return preg_match("/.*\.(jp)(e){0,1}(g)$/", $image) ||
        preg_match("/.*\.(gif)$/", $image) ||
        (preg_match("/.*\.(png)$/", $image) && $image != 'folder.png' && $image != 'folder2.png' && $image != 'private.png' && $image != 'watermark.png'
            && $image != 'watermark_big.png' && $image != 'back.png');
}

function is_exif_image($image)
{
    $image = strtolower($image);
    return preg_match("/.*\.(jp)(e){0,1}(g)$/", $image);
}

function hasVideoPrefix($image)
{
    $value = (!(strpos($image, "v___") === false));
    return $value;
}

/**
 *  check if there is a video with the same name in this folder
 */ 
function isVideo($image) {


}

/*
compares caseinsensitive - normally this could be done with natcasesort -
but this seems to be buggy on my test system! The function is extracted
This way the sorting can be changed real quick ;).
*/
function mycmp($a, $b)
{
    // return natcasesort ($a, $b);
    $as = str_replace('v___', '', $a);
    $bs = str_replace('v___', '', $b);
    return strnatcasecmp($as, $bs);
}

function mycmp_dec($a, $b)
{
    $as = str_replace('v___', '', $a);
    $bs = str_replace('v___', '', $b);
    return strnatcasecmp($b, $a);
}

function cut_info_str($data)
{
    global $charset;

    if (isset($charset)) {
        $d = $data;
        $d = html_entity_decode_fixed($data, ENT_COMPAT, $charset);
    } else {
        $d = html_entity_decode($data); // fallback for 1.5
    }
    if (strlen($d) > 25) {
        $data2 = substr($d, 0, 22);
        if (strlen($d) > 22) {
            $data2 .= "...";
        }
        return $data2;
    } else {
        return $data;
    }
}

function get_image_exif_size($filename, $image_name)
{
    set_error_handler("on_error_no_output");
    $er = get_image_exif($filename);
    set_error_handler("on_error");
    $size_array = array();
    $size_array[2] = 2;
    if (isset($er->ImageInfo[TAG_EXIF_IMAGEWIDTH])) {
        $size_array[0] = $er->ImageInfo[TAG_EXIF_IMAGEWIDTH];
    } else {
        $size_array[0] = 1024;
        debug("Size of image " . $image_name . " cannot be detected using 1024x768.");
    }

    if (isset($er->ImageInfo[TAG_EXIF_IMAGELENGTH])) {
        $size_array[1] = $er->ImageInfo[TAG_EXIF_IMAGELENGTH];
    } else {
        $size_array[1] = 768;
    }
    return $size_array;
}

/*
  Read the exif infos of a file - the reading is cached in GLOBALS because it is
  used 1 or 2 times depending on the image - it's only needed once when the cache
  is created - therefore not needed later anymore.
*/
function get_image_exif($filename)
{
    if (isset($GLOBALS["EXIF" . $filename])) {
        return $GLOBALS["EXIF" . $filename];
    }
    include_once dirname(__FILE__) . "/exifReader.inc.php";
    $er = new phpExifReader($filename);
    $er->processFile();
    $GLOBALS["EXIF" . $filename] = $er; // not in session because we only need this once per image
    return $er;
}

function get_image_exif_rotation($filename)
{
    global $autorotate_images;
    if ($autorotate_images == "") {
        return 0;
    }

    $r1 = 90;
    $r2 = 270;
    if ($autorotate_images == "invert") {
        $r1 = 270;
        $r2 = 90;
    }
    set_error_handler("on_error_no_output");
    $er = get_image_exif($filename);
    set_error_handler("on_error");
    if (isset($er->ImageInfo[TAG_EXIF_IMAGEWIDTH])) {
        $r = $er->ImageInfo[TAG_ORIENTATION];
        switch ($r) {
            case 1:
            case 2:
                $rot = 0;
                break;
            case 3:
            case 4:
                $rot = 180;
                break;
            case 5:
            case 6:
                $rot = $r1;
                break;
            case 7:
            case 8:
                $rot = $r2;
                break;
            default:
                $rot = 0;
        }
    } else {
        $rot = 0;
    }
    return $rot;
}


function get_dynamic_background($backgroundimage, $background)
{
    global $use_resized_background, $compression, $resized_background_tolerance, $browserx, $browsery, $use_dynamic_background;
    global $cachedir, $resize_only_if_too_small;

    if ($use_resized_background && isset($_SESSION[$GLOBALS["standalone"] . "browserx_res"])) { // we do the backgroundresize
        $use_dynamic_background = false;
        if ($resize_only_if_too_small) {
            return $background;
        }

        $browserx_real = $browserx + 75;
        $browsery_real = $browsery + 75;
        // find the size that is needed for the background
        $bg_size = getimagesize($backgroundimage);
        $relation_bg = $bg_size[0] / $bg_size[1]; //  800 / 400 = 2
        $relation_br = ($browsery_real != 0) ? $browserx_real / $browsery_real : 1.9;

        $width = $browserx_real;
        $height = $browsery_real;

        if ($relation_bg != $relation_br) { // streched !
            if ($relation_bg > $relation_br) {
                $width = $height * $relation_bg;
            } else {
                $height = $width / $relation_bg;
            }
        }

        $max_size = ($width > $height) ? $width : $height;
        $image_res = (((int)($max_size / $resized_background_tolerance)) + 1) * $resized_background_tolerance;
        $image_name = $cachedir . "/bg_" . sha1($backgroundimage . $image_res) . ".jpg";

        if (!file_exists($image_name)) {
            // create the cachedir in the right resolution!
            include_once dirname(__FILE__) . "/imagefunctions.inc.php";
            generatesmall($backgroundimage, $image_name, $image_res, $compression, 0, "", false, true);
        }
        return tfu_get_view_dir($image_name);
    } else {
        return $background;
    }
}

/*
	Tries to use a cache image of a small image if one does exists! TWG needs much less cpu power if we can use cache images!
	we split image.php?twg_album=2-17.+Traditionspokal&amp;twg_type=thumb&amp;twg_show=mountains.jpg

	*/
function opimizeSmallLink($link)
{
    global $disable_direct_thumbs_access, $extension_small, $use_direct_small, $twg_seo_active;

    if (!$use_direct_small) {
        return $link;
    }
    $values = split('[=&;]', $link);
    if ($values && count($values) > 7) {
        $twg_album = urldecode($values[1]);
        $aktimage = $values[7];
        $aktimage = replace_valid_url($aktimage);
        $thumbimage = create_thumb_image($twg_album, $aktimage);
        $thumb = create_cache_file($thumbimage, $extension_small);
        // todo: check small cache!
        if (!file_exists($thumb) || $disable_direct_thumbs_access) {
            return $link;
        } else {
            return create_cache_file(cacheencode($thumbimage), $extension_small, true, $twg_seo_active);
        }
    } else {
        return $link;
    }
}

/*
	Tries to use a thumb cache image if one does exists! TWG needs much less cpu power if we can use cache images!
	we split image.php?twg_album=2-17.+Traditionspokal&amp;twg_type=thumb&amp;twg_show=mountains.jpg

	*/
function opimizeLink($link)
{
    global $disable_direct_thumbs_access, $extension_thumb, $twg_seo_active;

    $values = split('[=&;]', $link);
    if (count($values) < 7) {
        return $link;
    }
    $twg_album = urldecode($values[1]);
    $aktimage = $values[7];
    $aktimage = replace_valid_url($aktimage);

    $thumbimage = create_thumb_image($twg_album, $aktimage);
    $thumb = create_cache_file($thumbimage, $extension_thumb);
    // todo: check small cache!
    if (!file_exists($thumb) || $disable_direct_thumbs_access) {
        return $link;
    } else {
        return create_cache_file(cacheencode($thumbimage), $extension_thumb, true, $twg_seo_active);
    }
}

function print_spacer($has_element_before_loc)
{
    if ($has_element_before_loc) {
        echo " |&nbsp;";
    }
    return true;
}

/**
Gets the local or remote file list
 */
function get_file_list($handle, $file_dir)
{
    global $password_file;
    global $url_file;

    $i = 0;
    $list = array();
        
    while (false !== ($file = @readdir($handle))) {
        if ($file == $url_file) {
            $locurl = twg_checkUrl($file_dir);
            if (count($list) > 0) {
                $listhttp = twg_http_get($locurl);
                if (is_array($listhttp)) {
                    $list = array_merge($listhttp, $list);
                }
            } else {
                $list = twg_http_get($locurl);
            }
            $i += count($list);
        } else if ($file != $password_file && $file != '.' && $file != "..") {
            $list[$i] = $file;
            $i++;
        }
    }
    return $list;
}


function create_thumb_image($twg_album, $image_encoded)
{
    global $cachedir;
    global $use_cache_with_dir;

    if ($use_cache_with_dir) {
        $path = $cachedir . '/' . twg_urlencode($twg_album);
        if (!file_exists($path)) {
            mkdir_recursive($path);
        }
        $prefix = $twg_album . '/';
        return twg_urlencode($prefix . urldecode($image_encoded));
    }
    return urlencode(str_replace('/', "_", $twg_album) . "_" . urldecode($image_encoded));
}


function mkdir_recursive($pathname)
{
    is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname));
    return is_dir($pathname) || twg_mkdir($pathname);
}

function create_cache_file($thumbimage, $extension_thumb, $encoded = false, $is_view_path = false)
{
    global $cachedir, $twg_seo_image_active, $twg_seo_active;
    $thumbimage = make_hash($thumbimage, $encoded);   
    if ($is_view_path) {
      $view_path =  ($twg_seo_image_active) ? '../' : '';
      $view_path .= ($twg_seo_active) ? '../' : ''; 
    }  else {
      $view_path = "./";
    }
    return $view_path . $cachedir . '/' . $thumbimage . '.' . $extension_thumb;
}

function create_cache_file_admin($thumbimage, $extension_thumb, $encoded = false)
{
    global $cachedir;
    $thumbimage = make_hash($thumbimage, $encoded);
    return $cachedir . '/' . $thumbimage . '.' . $extension_thumb;
}

function make_hash($thumbimage, $encoded)
{
    global $use_cache_hash;
    if ($use_cache_hash) {
        if ($encoded) {
            $thumbimage = urldecode($thumbimage);
        }
        $thumbimage = md5($thumbimage);
    }
    return $thumbimage;
}


function get_rot_file_name($twg_album, $image)
{
    global $cachedir;
    return "./" . $cachedir . '/' . urlencode(str_replace('/', "_", $twg_album) . "_" . $image) . ".rot";
}

/** Reads the local AND the global passwort file and merges them! */
function read_passwort_file($privatefilepath, $globalprivatefilepath)
{
    $privatefilename = $privatefilepath . '/' . $GLOBALS['password_file'];
    // $globalprivatefilename = ''; // $globalprivatefilepath . '/' .  $GLOBALS['password_file'];
    $passarray = false;
    /*
  if (file_exists($globalprivatefilename)) {
     $passarray = read_passwort_file_($globalprivatefilename);
  }
  */

    while (!file_exists($privatefilename) && (($privatefilepath = getupperdirectory($privatefilepath)) != '')) {
        $privatefilename = $privatefilepath . '/' . $GLOBALS['password_file'];
    }

    if (file_exists($privatefilename)) {
        $passarray2 = read_passwort_file_($privatefilename);
        if ($passarray2 !== false) {
            if ($passarray !== false) {
                $passarray = array_merge($passarray, $passarray2);
            } else {
                $passarray = $passarray2;
            }
        }
    }

    if ($passarray === false) {
        return false;
    } else {
        return $passarray;
    }
}

/** reads an individual file */
function read_passwort_file_($privatefilename)
{
    global $privatepassword;
    $passwd_line = trim(file_get_contents($privatefilename));
    $passwd = split(",", $passwd_line);
    if ($passwd_line == "") {
        $passwd = array($privatepassword);
    }
    return $passwd;
}


function read_rot($rot)
{
    $twg_rot = file_get_contents($rot);
    return $twg_rot;
}

function process_image_exif_rotation($filename, $rotname)
{
    global $login_edit;
    $rot = get_image_exif_rotation($filename);
    if ($rot != 0) {
        $login_edit = true;
        $rot_file = fopen($rotname, 'w');
        fputs($rot_file, $rot);
        fclose($rot_file);
    }
    return $rot;
}

function get_rotation_index($twg_album, $image)
{
    global $basedir;
    $image_dec = urldecode($image);
    if ($twg_album) {
        $path = $basedir . '/' . $twg_album;
    } else {
        $path = $basedir;
    }
    $remote_image = twg_checkurl($path);
    if ($remote_image) {
        $image_full = getRemoteImagePath($remote_image, $image_dec);
    } else {
        $image_full = $path . '/' . $image_dec;
    }
    $twg_rot = getRotation($twg_album, $image_dec, $image_full);
    return $twg_rot;
}

function delete_comment_cache($prefix)
{
    $tmp_files = twg_glob($prefix . $GLOBALS['cachedir'] . "/_t_COM_*.tmp.php");
    if ($tmp_files) {
        foreach (tmp_files as $fn) {
            @unlink($fn);
        }
    }
}

/* this is a fix for the php bug #27626 */
function html_entity_decode_fixed($str, $quotes, $charset)
{
    set_error_handler("on_error_no_output");
    if ($charset == 'UTF-8') {
        if (version_compare(phpversion(), '5.0.0', '>=')) {
            $strnew = html_entity_decode($str, $quotes, $charset);
        } else {
            $strnew = utf8_encode(html_entity_decode($str, $quotes, 'ISO-8859-15'));
        }
    } else {
        $strnew = html_entity_decode($str, $quotes, $charset);
    }
    set_error_handler("on_error");
    return $strnew;
}

function getLinks()
{
    global $d, $msie;
    if ($d) {
        return "";
    } else {
        return '<iframe marginheight="0" marginwidth="0" ' . ($msie ? ' allowtransparency="true"' : '') . ' src="http://www.tinywebgallery.com/gadmin/ad_frontend.php" style="margin:0px;padding:0px;width:480px;height:22px;overflow:hidden;" scrolling=no frameborder=0 ></iframe>';
    }
}

function execute_command($command)
{
    global $use_shell_exec;
    ob_start();
    set_error_handler("on_error_no_output");
    if (substr(@php_uname(), 0, 7) == "Windows") {
        // Make a new instance of the COM object
         if (class_exists('COM')) {
         $WshShell = new COM("WScript.Shell");
  		   // Make the command window but dont show it.
  	     $oExec = $WshShell->Run("cmd /C " . $command, 0, true);
       } else {
         debug("From PHP 5.4.5, COM and DOTNET is no longer built into the php core. You have to add COM support in php.ini. Add the line extension=php_com_dotnet.dll to your php.ini.");
       }
    } else {
        if ($use_shell_exec) {
            shell_exec($command);
        } else {
            exec($command . ' 2>&1', $out, $err);
            if ($err) {
                debug(print_r($out, true) . ':' . $command);
            }
        }
    }
    set_error_handler("on_error");
    ob_end_clean();
}

// for the first release I only generate one rss that is called all.rss  that includes unprodected galleries!
function generate_piclens_rss($dirs, $pass, $iframe = false)
{
    global $filesystem_encoding, $cachedir, $extension_thumb, $basedir, $charset, $support_piclens, $install_dir, $php_include, $cachedir_save;
    $i = 0;
    $data = '';

    $path = $cachedir;
    $cachename = $path . (($pass == '') ? '/all_pl.rss' : '/all_pl_' . md5($pass) . '.rss');

    if (!$support_piclens) {
        return true;
    }
    if (file_exists($cachename)) {
        return true;
    }
    $ser_file = fopen($cachename, 'w');
    $header = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<atom:icon>http://www.tinywebgallery.com/twg.png</atom:icon>
<title>Tinywebgallery RSS feed for the Cooliris - generated ' . date("m.d.y H:i:s") . '</title>
<link>http://www.tinywebgallery.com</link>
<description>Don not bookmark this rss feed - It is needed for the Cooliris plugin.</description>

';

    foreach ($dirs as $album) {
        $list = get_image_list($album);
        if ($list) {
            foreach ($list as $img) {
                $aktimage = $img;
                $thumbimage = create_thumb_image($album, $aktimage);
                $thumb = create_cache_file($thumbimage, $extension_thumb);
                if (file_exists($thumb)) {
                    $orig = $basedir . '/' . $album . '/' . urldecode($img);
                    if (file_exists($orig)) {
                        if ($php_include) {
                            $prefix = getTWGHttpRoot('', true);
                        } else {
                            $prefix = "../";
                        }
                        $thumbenc = fixUrl($prefix . create_cache_file((rawurlencode(($thumbimage))), $extension_thumb));
                        $thumbenc = str_replace("%2F", '/', $thumbenc); // fix for directories - TODO: refactor!
                        $orig = fixUrl($prefix . $basedir . '/' . twg_urlencode($album) . '/' . (urldecode($img)));
                        $orig = str_replace("//", '/', $orig);
                        $orig = str_replace(":/", "://", $orig);
                        $orig = str_replace("&", " ", $orig);
                        $data .= "    <item>\n";
                        $data .= "       <title>" . str_replace("&", " ", urldecode($img)) . "</title>\n";
                        $data .= '       <link>http://www.tinywebgallery.com</link>' . "\n";
                        $data .= '       <guid>twg-' . $i++ . '</guid>' . "\n";
                        $data .= '       <media:thumbnail url="' . $thumbenc . '" />' . "\n";
                        $data .= '       <media:content   url="' . $orig . '" type="image/jpeg" />' . "\n";
                        $data .= "    </item>\n";
                    }
                }
            }
        }
    }
    $footer = '</channel>
</rss>';
    if (isset($charset) && strtolower($charset) == "utf-8") {
        $data = $header . $data . $footer;
        $data = ($filesystem_encoding == '') ? utf8_encode($data) : iconv($filesystem_encoding, 'UTF-8', $data);
        fputs($ser_file, $data);
    } else {
        fputs($ser_file, $header . $data . $footer);
    }
    fclose($ser_file);
    return false;
}

function create_flash_xml($dir, $images, $external)
{
    global $extension_thumb, $install_dir, $install_dir_view, $cache_dirs, $use_js_call_external_thumb_flash, $twg_seo_active;
    $data = '';
    $startnr = 0;
    $save_to_file = true;
    $xmlfile = create_cache_file(md5($dir), 'flash.tmp.xml');
    clearstatcache();
    if (!file_exists($xmlfile) || $external) {
        $data = '<a timestamp="' . get_xml_timestamp() . '">';
        foreach ($images as $img) {
            $aktimage = $img;
            $thumbimage = create_thumb_image($dir, $aktimage);
            $thumb_local = create_cache_file($thumbimage, $extension_thumb);
            $thumb = create_cache_file(cacheencode($thumbimage), $extension_thumb, true, $twg_seo_active);
            if (!file_exists($thumb_local)) {
                $thumb = 'image.php?twg_album=' . urlencode($dir) . '&amp;twg_type=thumb&amp;twg_show=' . $aktimage;
                $save_to_file = false;
            }
            if ($external) {
                if ($use_js_call_external_thumb_flash) {
                    $url = fixUrl(getTWGHttpRoot($install_dir) . 'image.php?twg_album=' . $dir . '&amp;twg_show=' . $aktimage);
                    $action = 'showImage("' . $url . '")';
                } else {
                    $url = fixUrl(getTWGHttpRoot($install_dir) . 'index.php?twg_album=' . $dir . '&amp;twg_show=' . $aktimage);
                    $action = 'window.location = "' . $url . '"';
                }
            } else {
                $action = 'changeContent(' . $startnr++ . ');';
            }

            $data .= '<b><c>' . $thumb . '</c><d>' . $action . '</d></b>';

        }
        $data .= '</a>';

        if ($save_to_file && $cache_dirs && !$external) {
            $file = fopen($xmlfile, 'w');
            fputs($file, $data);
            fclose($file);
        }
        return $data;
    } else {
        return file_get_contents($xmlfile);
    }

}

function get_xml_timestamp()
{
    $mode = (checkFullscreen()) ? "24h" : "12h";
    return $mode . "-" . date("m.d.y H:i:s");
}

function getEmptyPage($path)
{
    if (isset($_SESSION['checkcache']) || get_server_name() == "localhost") {
        return $path . 'i_frames/index.htm';
    } else {
        return 'http://www.tinywebgallery.com/gadmin/blank.php';
    }

}

function get_server_name()
{
    if (isset($GLOBALS['GSN'])) {
        return $GLOBALS['GSN'];
    }
    if (isset($_SERVER['HTTP_HOST'])) {
        $domain = $_SERVER['HTTP_HOST'];
    } else if (isset($_SERVER['SERVER_NAME'])) {
        $domain = $_SERVER['SERVER_NAME'];
    } else {
        $domain = '';
    }
    $port = strpos($domain, ':');
    if ($port !== false) $domain = substr($domain, 0, $port);
    $GLOBALS['GSN'] = $domain;
    return $domain;
}

function replace_url_chars($str)
{
    $s = str_replace("_Q_", "?", str_replace("_S_", '/', str_replace("_C_", ":", $str)));
    return $s;
}

function getlatestVersion()
{
    if (isset($_SESSION['TWG_LATEST_VERSION'])) {
        return $_SESSION['TWG_LATEST_VERSION'];
    } else if ($fsock = @fsockopen('www.tinywebgallery.com', 80, $errno, $errstr, 10)) {
        $version_info = '';
        @fputs($fsock, "GET /updatecheck/twg.txt HTTP/1.1\r\n");
        @fputs($fsock, "HOST: www.tinywebgallery.com\r\n");
        @fputs($fsock, "Connection: close\r\n\r\n");
        $get_info = false;
        while (!@feof($fsock))
        {
            if ($get_info) {
                $version_info .= @fread($fsock, 1024);
            }
            else
            {
                if (@fgets($fsock, 1024) == "\r\n") {
                    $get_info = true;
                }
            }
        }
        @fclose($fsock);
        if (!is_numeric(substr($version_info, 0, 1))) {
            $version_info = -1;
        }
    } else {
        $version_info = -1;
    }
    $_SESSION['TWG_LATEST_VERSION'] = $version_info;
    return $version_info;
}

function cacheencode($path)
{
    global $use_cache_with_dir;
    return ($use_cache_with_dir) ? twg_urlencode($path) : urlencode($path);
}

// Specifiy the file_put_contents() function for PHP version 4
if (function_exists('file_put_contents') == false) {
    function file_put_contents($file, $string)
    {
        $f = fopen($file, 'w');
        fwrite($f, $string);
        fclose($f);
    }
}

function twg_mkdir($dir, $permissions = false)
{
    $main_dir = dirname($dir);
    if (file_exists($main_dir) && is_writeable($main_dir)) {
        if ($permissions) {
            return @mkdir($dir, $permissions);
        } else {
            return @mkdir($dir);
        }
    } else {
        return false;
    }
}

/**
 *  Needed if session cache folder is used to have the actual settings.
 */
function store_temp_twg_session()
{
    clearstatcache();
    if (file_exists(dirname(__FILE__) . '/../admin/upload/session_cache') && session_id() != "") { // we do your own small session handling
        $cachename = dirname(__FILE__) . '/../admin/upload/session_cache/' . session_id();
        $ser_file = fopen($cachename, 'w');
        fwrite($ser_file, serialize($_SESSION));
        fclose($ser_file);
    }
}

function fixSession()
{
    ob_start();
    // this is a fix if session are not saved and passed to the config.php
    $HTTP_SESSION_VARS = $_SESSION;
    session_write_close();
    ini_set('session.save_handler', 'files');
    session_start();
    $_SESSION = $HTTP_SESSION_VARS;
    session_write_close();
    ob_end_clean();
    // end fix ;).  
}

function checkXSS()
{
    global $input_invalid;
    if ($_SERVER['PHP_SELF'] != $_SERVER['SCRIPT_NAME']) {
        // first I check if php_self is like script_name but with some extra stuff which is not allowed!
        if ($_SERVER['SCRIPT_NAME'] . '/' == substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['SCRIPT_NAME'] . '/'))) {
            header("HTTP/1.0 404 Not Found");
            printErrorInvalid();
            die();
        }
        replaceInput($_SERVER['PHP_SELF']);
        if ($input_invalid) {
            header("HTTP/1.0 404 Not Found");
            printErrorInvalid();
            die ();
        }
    }
}

function showInvalidAccess()
{
    echo '<p>' . 'Function is not enabled or direct or not authorized access is not allowed.' . '</p>';
}

function checkRating($ratingimage, $name)
{
    global $enable_rating_only_registered, $counterdir, $rating_reload_time;

    $datei = $counterdir . '/rate_log.txt';

    $time = time() - $rating_reload_time * 86400;
    $current_ip = $_SERVER['REMOTE_ADDR'];
    $mname = md5($name);
    $mratingimage = md5($ratingimage);
    $voted = false;
    $write = false;

    if (file_exists($datei)) {
        $lines = file($datei);
        foreach ($lines as $key => $data) {
            if (strpos($data, "µ") !== false) {
                list($ip, $fname, $md5image, $timest) = explode("µ", $data);
                if (trim($timest) < $time) { // old
                    unset($lines[$key]);
                    $write = true;
                    continue;
                }
                $match = (($enable_rating_only_registered) ? ($fname == $mname) : ($ip == $current_ip));
                if ($match && ($md5image == $mratingimage)) {
                    $voted = true;
                }
            }
        }
    }
    if ($write) {
        $save = implode("", $lines);
        $handle = fopen($datei, "w");
        fputs($handle, $save);
        fclose($handle);
    }
    return $voted;
}

function setRating($ratingimage, $name)
{
    global $counterdir;

    $datei = $counterdir . '/rate_log.txt';
    $current_ip = $_SERVER['REMOTE_ADDR'];
    $mname = md5($name);
    $mratingimage = md5($ratingimage);

    $handle = fopen($datei, "a");
    $save = $current_ip . "µ" . $mname . "µ" . $mratingimage . "µ" . time() . "\n";
    fputs($handle, $save);
    fclose($handle);

}

// global variable that the parsing is only done one per request.
$current_script_name = '';

function getScriptName()
{
    global $current_script_name;
    if ($current_script_name == '') {
        $current_script_name = htmlentities($_SERVER['PHP_SELF']);
    }
    return $current_script_name;
}

/**#@+
 * Extra GLOB constant for safe_glob()
 */
define('GLOB_NODIR', 256);
define('GLOB_PATH', 512);
define('GLOB_NODOTS', 1024);
define('GLOB_RECURSE', 2048);
/**#@-*/

/**
 * A safe empowered glob().
 *
 * Function glob() is prohibited on some server (probably in safe mode)
 * (Message "Warning: glob() has been disabled for security reasons in
 * (script) on line (line)") for security reasons as stated on:
 * http://seclists.org/fulldisclosure/2005/Sep/0001.html
 *
 * safe_glob() intends to replace glob() using readdir() & fnmatch() instead.
 * Supported flags: GLOB_MARK, GLOB_NOSORT, GLOB_ONLYDIR
 * Additional flags: GLOB_NODIR, GLOB_PATH, GLOB_NODOTS, GLOB_RECURSE
 * (not original glob() flags)
 * @author BigueNique AT yahoo DOT ca
 * @updates
 * - 080324 Added support for additional flags: GLOB_NODIR, GLOB_PATH,
 *   GLOB_NODOTS, GLOB_RECURSE
 */
function safe_glob($pattern, $flags = 0)
{
    $split = explode('/', str_replace('\\', '/', $pattern));
    $mask = array_pop($split);
    $path = implode('/', $split);
    if (($dir = opendir($path)) !== false) {
        $glob = array();
        while (($file = readdir($dir)) !== false) {
            // Recurse subdirectories (GLOB_RECURSE)
            if (($flags & GLOB_RECURSE) && is_dir($file) && (!in_array($file, array('.', '..'))))
                $glob = array_merge($glob, array_prepend(safe_glob($path . '/' . $file . '/' . $mask, $flags),
                    ($flags & GLOB_PATH ? '' : $file . '/')));
            // Match file mask
            if (fnmatch($mask, $file)) {
                if (((!($flags & GLOB_ONLYDIR)) || is_dir("$path/$file"))
                    && ((!($flags & GLOB_NODIR)) || (!is_dir($path . '/' . $file)))
                    && ((!($flags & GLOB_NODOTS)) || (!in_array($file, array('.', '..'))))
                )
                    $glob[] = ($flags & GLOB_PATH ? $path . '/' : '') . $file . ($flags & GLOB_MARK ? '/' : '');
            }
        }
        closedir($dir);
        if (!($flags & GLOB_NOSORT)) sort($glob);
        return $glob;
    } else {
        return false;
    }
}

/**
 * A better "fnmatch" alternative for windows that converts a fnmatch
 * pattern into a preg one. It should work on PHP >= 4.0.0.
 * @author soywiz at php dot net
 * @since 17-Jul-2006 10:12
 */
if (!function_exists('fnmatch')) {
    function fnmatch($pattern, $string)
    {
        return @preg_match('/^' . strtr(addcslashes($pattern, '\\.+^$(){}=!<>|'), array('*' => '.*', '?' => '.?')) . '$/i', $string);
    }
}

function twg_glob($pattern, $flags = 0)
{
    global $use_twg_glob;
    if ($use_twg_glob) {
        return glob($pattern, $flags);
    } else {
        return safe_glob($pattern, $flags);
    }
}

function saveFolderNameTxt($folder, $foldername, $lang = '')
{
    file_put_contents($folder . '/foldername.txt', $foldername);
    unset($_SESSION['twg_tmp']);
}

function saveFolderTxt($folder, $folderdesc, $lang = '')
{
    file_put_contents($folder . '/folder.txt', $folderdesc);
    unset($_SESSION['twg_tmp']);
}

function twg_seems_utf8($Str)
{
    for ($i = 0; $i < strlen($Str); $i++) {
        if (ord($Str[$i]) < 0x80) $n = 0; # 0bbbbbbb
        elseif ((ord($Str[$i]) & 0xE0) == 0xC0) $n = 1; # 110bbbbb
        elseif ((ord($Str[$i]) & 0xF0) == 0xE0) $n = 2; # 1110bbbb
        elseif ((ord($Str[$i]) & 0xF0) == 0xF0) $n = 3; # 1111bbbb
        else return false; # Does not match any model
        for ($j = 0; $j < $n; $j++) { // n octets that match 10bbbbbb follow ?
            if ((++$i == strlen($Str)) || ((ord($Str[$i]) & 0xC0) != 0x80)) return false;
        }
    }
    return true;
}

/*
  Removes the br added by nl2br
*/
function rm_br($str)
{
    $str = str_replace("<br />", '', $str);
    return $str;
}

/*
  Different inputs are converted to a simple return.
*/
function replace_conv_br($str)
{
    $str = str_replace("_br /_", "\n", trim($str));
    $str = str_replace("_br/_", "\n", $str);
    return str_replace("_br_", "\n", $str);
}

function twg_starts_with($haystack, $needle)
{
    return strpos($haystack, $needle) === 0;
}

function printCss($path, $inline = false, $localpath = false)
{
    global $optimize_css, $optimize_array, $install_dir, $install_dir_view;

    if ($optimize_css) {
        if ($localpath) {
            $path = $localpath;
        }
        $optimize_array[] = $path;
    } else {
        if ($inline) {
            echo $path;
        } else {
            echo '<link rel="stylesheet" type="text/css" href="' . $install_dir_view . $path . '" >';
        }
    }
}

function printOptimizedCss($css_array)
{
    global $install_dir, $cachedir_save, $icon_set, $twg_version, $install_dir_view;

    // the twg_version is used in the name to get new cache names after an update!
    $cssname = $twg_version . $icon_set;
    foreach ($css_array as $css) {
        $cssname .= $css;
    }
    $css_cache_name_base = $cachedir_save . '/' . md5($cssname) . '.css';
    $css_cache_name = dirname(__FILE__) . '/../' . $css_cache_name_base;

    if (!file_exists($css_cache_name)) {
        $css_komplett = '';
        foreach ($css_array as $css) {
			// check if inline
            if (twg_starts_with($css, '<style')) {
                $css_komplett .= strip_tags($css) . "\n";
            } else {
                $css_input = file_get_contents(dirname(__FILE__) . '/../' . $css);

                if (strpos($css, $icon_set) !== false) { // if is iconset
                    // adopt the url's of the css that are not at level one! 
                    $path = "../buttons/iconsets/" . $icon_set;
                    $css_input = str_replace('star.gif', $path . '/star.gif', $css_input);
                    $css_input = str_replace('buttons.png', $path . '/buttons.png', $css_input);
                    $css_input = str_replace('iuzs_over.gif', $path . '/iuzs_over.gif', $css_input);
                    $css_input = str_replace('guzs_over.gif', $path . '/guzs_over.gif', $css_input);
                    $css_input = str_replace('../fullscreen.png', 'buttons/fullscreen.png', $css_input);
                }
                
                if (strpos($css, 'my_style.css' ) !== false) { // if is my_style.css I replace the url.
                    $css_input = str_replace("url('", "url('../", $css_input);     
                    $css_input = str_replace('url("', 'url("../', $css_input);
                    // absolute paths are changed back
                    $css_input = str_replace("url('../http", "url('http", $css_input);
                    $css_input = str_replace('url("../http', 'url("http', $css_input);               
                }

                if (strpos($css, '-min') === false) { // if is not minimized
                    $css_input = compress_css($css_input);
                }
                $css_komplett .= $css_input;
            }
        }
        // create temp css  
		if ($handle = fopen($css_cache_name, "w")) {
            fwrite($handle, $css_komplett);
            fclose($handle);
        } else {
            debug("css " . $css_cache_name . " kann nicht geschrieben werden.");
        }
    }
    echo "\n" . '<link rel="stylesheet" type="text/css" href="' . $install_dir_view . $css_cache_name_base . '" >';
}


/**
 *  Basic compression for the css files that are really small and not compressed
 *  in the download package. like my_style.css
 */
function compress_css($buffer)
{
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    /* remove tabs, newlines, etc. */
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t",), '', $buffer);
    /* remove multiple spaces */ 
    $buffer = str_replace(array('  ', '    ', '    '), ' ', $buffer);
    return $buffer;
}

// only executes basename if a / or \ is in the filename.
// Fixes the problem that basename e.g. destroys chinese filename encoded in utf-8
function my_basename($name) {
  if ((strpos($name, '\\') === false) && (strpos($name, '/') === false)) {
    return $name;
  } else {
    $sep = ((strpos($name, '/') === false)) ?  '\\' : '/';
    return ltrim(substr($name, strrpos($name, $sep) ), $sep);
  }
}

function checkP() {         
  $ff = dirname(__FILE__) . "/../twg.lic.php";
  if (file_exists($ff)) { // we are in TWG
    ob_start();
    include  $ff;
    ob_end_clean();
    if ($l == $d) {
      return true;
    } else if (strpos($d, "TWG_") !== false) {
      return true;
    } else {
      return false;
    }   
  } else {
    return false;
  }
}

function tfu_mail($to, $subject, $body, $from, $type = 'text/plain') {
global $fix_utf8, $use_smtp, $smtp_host, $smtp_port, $smtp_user, $smtp_password;

if (strnatcmp(phpversion(),'5.0.0') >= 0) { // new version - used for php > 5 
    require_once('class.phpmailer.php');
   
    $mail             = new PHPMailer();
    $mail->CharSet = 'utf-8';
    // $mail->SMTPDebug  = 2;  
    
    if ($use_smtp) {
      $mail->IsSMTP(); // telling the class to use SMTP
      $mail->SMTPAuth   = true;           // enable SMTP authentication
      $mail->Host       = $smtp_host;     // sets the SMTP server
      $mail->Port       = $smtp_port;     // set the SMTP port for the GMAIL server
      $mail->Username   = $smtp_user;     // SMTP account username
      $mail->Password   = $smtp_password; // SMTP account password
    }
    $mail->SetFrom($from);
    $mail->AddReplyTo($from);
    $mail->AddAddress($to);
    
    $mail->Subject = $subject;
    if ($type == 'text/plain') {
      $mail->Body = $body;
    } else {
      $mail->MsgHTML($body);
    }
    $result = $mail->Send();
    if(!$result) {
      debug("Mailer Error for '".$to."': " . $mail->ErrorInfo);
    }
    return $result;
} else { // old php 4 compatible sending!  
      $submailheaders = "From: $from\n";
      $submailheaders .= "Reply-To: $from\n";
      $submailheaders .= "Return-Path: $from\n"; 
      // UTF-8
      return @mail ($to, '=?UTF-8?B?'.base64_encode(html_entity_decode($subject)).'?=', html_entity_decode(str_replace("\n", "\r\n", $body)), 'MIME-Version: 1.0' . "\n" . 'Content-type: text/plain; charset=UTF-8' . "\n". $submailheaders);
      // non UTF-8     
      // @mail ($to, html_entity_decode ($subject), html_entity_decode ($body), $submailheaders); 
   } 
}

/**
 *  Does rewrite urls to be seo friendly.
 *  See howto 44 for details!
 */ 
 
$glob_script_name = basename(getScriptName()); 
 
function tfu_seo_rewrite_url($url) { 
global $enable_basic_seo, $glob_script_name, $install_dir, $use_old_seo_slash_encoding;
global $album_sub_url_seo_character;

  if (strpos(strtolower($url), "=http") !== false) {
      return $url;
  }
  
  if ($enable_basic_seo) {
    $url = str_replace("%2B", "%252b", $url);
    if ($use_old_seo_slash_encoding) {    
        $url = str_replace("%2F", "%252f", $url);
    } else {
        $url = str_replace("%2F", $album_sub_url_seo_character, $url); 
    }
      
    $tmp_script_name = $glob_script_name;
    if ($glob_script_name == 'image.php') {
       // debug("--> " . $glob_script_name . "--> " . );
       $tmp_script_name = basename($_SESSION['twg_root_dir']);
    }
   
      // if album only twg_album=album -> twg_album/album
     if (strpos($url, 'twg_show=') === false) { 
       return str_replace($tmp_script_name . '?twg_album=', 'twg_album/', $url);   
     } else if (strpos($url, 'twg_album=&') !== false) {  // maindir
       $url = str_replace($tmp_script_name . '?twg_album=', 'twg_show/', $url);  
       return str_replace('&amp;twg_show=', '', $url);   
     } else {
       $url = str_replace($tmp_script_name . '?twg_album=', 'twg_image/', $url);  
       return str_replace('&amp;twg_show=', '/', $url);    
     }
  } else {
    return $url;
  }
}

function tfu_get_view_dir($cachedir) {
   global $twg_seo_active, $twg_seo_image_active;   
   return ($twg_seo_active ? '../' : '') . ($twg_seo_image_active ? '../' : '') . $cachedir;
}

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}
?>