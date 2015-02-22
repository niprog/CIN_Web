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

$enhanced_debug = false; // only set this to true if you have contacted me before and I told you to do so - it gives me more infos when xml problems occurs!
$mem_limit = return_kbytes(ini_get('memory_limit'));

if (!$input_invalid) {
    if (isset($twg_album)) {
        loadXMLFiles($twg_album);
    }
}

function get_twg_xml_data($xml_filename)
{
    if (!($parse_handle = @fopen($xml_filename, 'r'))) {
        return startErrorHandling($xml_filename, "read");
    }
    $xml_data = @fread($parse_handle, filesize($xml_filename));
    @fclose($parse_handle);

    if (get_magic_quotes_runtime() == 1) {
        $xml_data = stripslashes($xml_data);
    }
    // translation nneded für german umlaute &uuml; ... !!
    $e = array_flip(get_html_translation_table(HTML_ENTITIES));
    unset($e["&amp;"]);
    unset($e["&lt;"]);
    unset($e["&gt;"]);
    return strtr($xml_data, $e);
}

function fixXML($xml_data)
{
    $pos = strpos($xml_data, '</BESCHREIBUNG>');
    if ($pos === false) { // before 1.7
        $pos = strpos($xml_data, '</beschreibung>');
    }
    return substr($xml_data, 0, $pos + 15);
}

function readXMLFile($xml_filename, $nr)
{
    global $cache_dirs, $enhanced_debug, $mem_limit;

    if ($enhanced_debug) {
        debug("readXMLFile: Loading xml file: " . $xml_filename);
        if ($mem_limit) {
            debug("readXMLFile: Memory status: " . round(memory_get_usage() / 1024) . "k/" . $mem_limit . "k");
        }
    }
    if (!(isset($_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)]) && $cache_dirs)) {
        if ($enhanced_debug) {
            debug("readXMLFile: reading from hd: " . $xml_filename);
        }
        $retarray = array();
        $xml_parser_handle = xml_parser_create();
        $xml_data = get_twg_xml_data($xml_filename);
        if (rand(0, 9) == 5) { // we check xml files one in a while... 
            $xml_data = fixXML($xml_data);
        }
        if (0 == xml_parse_into_struct($xml_parser_handle, $xml_data, $retarray[0], $retarray[1])) {
            //
            // below here is some basic xml error handling if xml files seem to be bad
            // I do replace some chars in the xml that should not be there
            // I think this is a problem of php not syncronizing the writing of files properly.
            //
            $xml_data = get_twg_xml_data($xml_filename);
            // backup reading - everything until the last </BESCHREIBUNG>
            $xml_data = fixXML($xml_data);
            xml_parser_free($xml_parser_handle);
            $xml_parser_handle = xml_parser_create();
            if (0 == xml_parse_into_struct($xml_parser_handle, $xml_data, $retarray[0], $retarray[1])) {
                sleep(3); // we retry 2 times read failes - maybe the file was not completely written before
                $timestamp = date("YmdHis");
                $xml_data = get_twg_xml_data($xml_filename);
                $xml_data = str_replace(">>", ">", $xml_data); // we do a replace I have found that is bad >>
                $xml_data = fixXML($xml_data);
                xml_parser_free($xml_parser_handle);
                $xml_parser_handle = xml_parser_create();
                if (0 == xml_parse_into_struct($xml_parser_handle, $xml_data, $retarray[0], $retarray[1])) { // retry!
                    $out = sprintf('XML error %s: %s at line %d (%s was renamed to %s - please check this file if you want to restore your data)',
                        $nr, xml_error_string(xml_get_error_code($xml_parser_handle)),
                        xml_get_current_line_number($xml_parser_handle), $xml_filename, $xml_filename . '_' . $timestamp . '.bak');
                    debug($out . " - DATA:" . $xml_data);
                    xml_parser_free($xml_parser_handle);
                    @copy($xml_filename, $xml_filename . '_' . $timestamp . '.bak');
                    @unlink(realpath($xml_filename));
                    die();
                }
            }
            //
            // End error handling
            //
        }

        xml_parser_free($xml_parser_handle);

        if ($enhanced_debug) {
            if ($mem_limit) {
                debug("readXMLFile: Memory status after loading: " . round(memory_get_usage() / 1024) . "k/" . $mem_limit . "k");
            }
        }
        // now we check if we can store it in the session !
        if ($mem_limit && function_exists("memory_get_usage")) {
            $usage = round(memory_get_usage() / 1024);
            $left = $mem_limit - $usage;
            if (($usage / $mem_limit) < 0.8 && ($left > 25000)) { // want either 80% min 25MB free memory
                $_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)] = $retarray;
            } else {
                if ($enhanced_debug) {
                    debug("readXMLFile: Not enough memory (" . round($usage / $mem_limit, 2) * 100 . "% used.) for session caching left");
                }
            }
        } else {
            $_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)] = $retarray;
        }
        return $retarray;
    } else {
        if ($enhanced_debug) {
            debug("readXMLFile: reading from memory: " . $xml_filename);
        }
        return $_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)];
    }
}

function loadXMLFiles($album_url)
{
    global $basedir, $werte, $kwerte, $index, $kindex, $xmldir, $store_xml_in_picfolders;
    global $readonlycomment;
    if ($album_url) {
        $album_path = $basedir . "/" . $album_url;
    } else {
        $album_path = $basedir;
        $album_url = "";
    }

    if (!file_exists($album_path)) {
        if ($album_path != $basedir . "/test") {
            // debug("Check encoding " . $album_path);
        }
        return;
    }
    if (isset($_SESSION['werte'])) {
        $werte = $_SESSION['werte'];
        $index = $_SESSION['index'];
    }
    if (isset($_SESSION['kwerte'])) {
        $kwerte = $_SESSION['kwerte'];
        $kindex = $_SESSION['kindex'];
    }

    if ((!isset($_SESSION["actalbum"])) || ($_SESSION["actalbum"] != $album_url) || $werte == false || $werte == null) {
        $xml_dummy_string = '<' . "?xml version='1.0'?" . ">\n<BESCHREIBUNG>\n<BILD><NAME> </NAME><WERT> </WERT></BILD>\n</BESCHREIBUNG>";
        // load captions to session
        $ret_data = get_twg_xml_data_mig($album_url, "/_caption.xml", "_image_text.xml", $xml_dummy_string, "read caption");
        $_SESSION['werte'] = $ret_data['werte'];
        $_SESSION['index'] = $ret_data['index'];
        $werte = $_SESSION['werte'];
        $index = $_SESSION['index'];
        // load comments to session
        $ret_data = get_twg_xml_data_mig($album_url, "/_comment.xml", "_kommentar_text.xml", $xml_dummy_string, "read comment");
        $_SESSION['kwerte'] = $ret_data['werte'];
        $_SESSION['kindex'] = $ret_data['index'];
        $kwerte = $_SESSION['kwerte'];
        $kindex = $_SESSION['kindex'];
        // delete the xml folder if empty !
        if (file_exists($xmldir) && $store_xml_in_picfolders) {
            $keep = false;
            $handle = opendir($xmldir);

            while (false !== ($file = readdir($handle))) {
                $pos = strpos($file, "xml");
                if ($pos === false) {
                    // nicht gefunden...
                } else {
                    $keep = true;
                    break;
                }
            }
            closedir($handle);
            if (!$keep) {
                set_error_handler("on_error_no_output"); // we don t care if cleanup does not work
                @unlink($xmldir . "/index.htm");
                @rmdir($xmldir);
                set_error_handler("on_error");
                clearstatcache();
            }
        }
        $_SESSION["actalbum"] = $album_url;
    }
}

// get beschreibung for images
function getBeschreibung($image, $werte, $index)
{
    global $autodetect_filenames_as_captions;

    $i = 0;
    foreach (((array)($index["NAME"])) as $band) {
        if (urldecode($werte[$band]["value"]) == urldecode($image)) { // encoding has to be done twice to get a match ! - some
            return urldecode($werte[$index["WERT"][$i]]["value"]);
        } else {
            $i = $i + 1;
        }
    }

    if (!$autodetect_filenames_as_captions) {
        return "";
    }
    // we haven t found a valid name - therefore we return the filename without extension if we
    // have less than 4 numbers in it (no camera name)
    return getCaptionByFilename($image);
}

function getCaptionByFilename($image)
{
    global $autodetect_filenames_as_captions;
    global $autodetect_filenames_as_captions_number;
    global $remove_x_chars_from_filename, $charset;
    global $filesystem_encoding, $remove_extension;

    $image = urldecode($image);

    if ($remove_x_chars_from_filename > 0) {
        $cut = $remove_x_chars_from_filename + 4;
    } else {
        $cut = 4; // remove only the extension!
    }

    $name = removePrefix($image);
    $name = substr($name, $remove_x_chars_from_filename, strlen($name) - $cut);
    if (!(strpos($name, "/") === false)) { // fix for php 5.1.6! - but needed for remote images ;).
        $name = basename($name);
    }
    $countNum = 0;

    $result = count_chars($name, 0);

    for ($i = 0; $i < count($result); $i++) {
        if ($result[$i] != 0) {
            if (is_numeric(chr($i))) {
                $countNum += $result[$i];
            }
        }
    }

    if (isset($charset) && strtolower($charset) == "utf-8") {
        $name = ($filesystem_encoding == '') ? utf8_encode($name) : iconv($filesystem_encoding, 'UTF-8', $name);
    }
    if ($countNum > $autodetect_filenames_as_captions_number) {
        return "";
    } else {
        if (strpos($name, '___') && (strlen($name) > 25)) { // if it's really long AND it seems to be a livestream!
            $name = substr($name, 0, strpos($name, '___'));
        }        
        return $name;
    }
}

// get kommentare for images
function getKommentar($image, $twg_album, $kwerte, $kindex, $isiframe)
{
    global $login_edit, $install_dir, $lang_add_kommentar, $charset;
    global $show_enter_comment_at_bottom, $default_is_fullscreen, $lang_comments, $lang_height_comment;
    global $twg_standalone, $show_comments_in_layer, $show_number_of_comments, $enable_comments_only_registered;
    global $login_edit, $login_backend, $install_dir_view;

    $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
    $image_enc = htmlentities(urlencode($image), ENT_QUOTES, $charset);
    $kommentar = "";
    $i = 0;
    $hits = 0;

    $install_save = $install_dir;
    if ($isiframe) {
        $install_dir_com = "../";
        $install_dir = "../";
    } else {
        $install_dir_com = $install_dir_view;
    }

    if ($kindex == false) {
        $kwerte = $_SESSION['kwerte'];
        $kindex = $_SESSION['kindex'];
    }

    $ip = "";

    if (isset($kindex["NAME"])) {
        foreach ($kindex["NAME"] as $band) {
            if (isset($kwerte[$band]["value"])) {
                // echo debug($image . ":" . urldecode($kwerte[$band]["value"] ));
                if (urldecode($kwerte[$band]["value"]) == $image) {
                    $hits++;
                    $line = urldecode($kwerte[$kindex["WERT"][$i]]["value"]);
                    list ($datum, $name, $komment) = explode("=||=", $line);
                    $nameid = explode("-||-", $name);
                    $name = $nameid[0];
                    if (count($nameid) > 1) {
                        $ip = " - " . $nameid[1];
                    }
                    // fix for 1.2 !!
                    $pos = strpos($datum, ".");
                    if ($pos === false) {
                        $datum = date("j.n.Y G:i", $datum);
                    }
                    $name = replacesmilies($name);
                    $komment = replacesmilies($komment);
                    $kommentar .= " <span class='twg_bold'>" . $name . "</span>  <span class='twg_kommentar_date'>(" . $datum . $ip . ")</span>";

                    $allow_delete = $login_edit;
                    // delete for registered users - if $enable_comments_only_registered only the user or someone with full rights can delete
                    if ($enable_comments_only_registered) {
                        if ($login_backend) {
                            $allow_delete = true;
                        } else if ($allow_delete && isset($_SESSION["s_user"]) && ($name == $_SESSION["s_user"])) {
                            // we check if the login user is the same as the one who entered the comment.
                            $allow_delete = true;
                        } else {
                            $allow_delete = false; // different user or not someone with backend rights!
                        }
                    }
                    if ($allow_delete) {
                        $kommentar .= " <a href='" . getScriptName() . "?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . "&amp;twg_delcomment=" . urlencode($line) . $twg_standalone . "'><img align='top' src='" . $install_dir_com . "buttons/close.gif' width='7' height='7'></a>";
                    }
                    $kommentar .= "<br>" . $komment . "<br>&nbsp;<br>\n";
                }
            }
            $i++;
        }
    }

    $install_dir = $install_save; // not nice - change if time !
    if ($show_number_of_comments) {
        $com_counter = " (" . $hits . ")";
    } else {
        $com_counter = "";
    }
    $headerkommentar = "";

    if (!$show_comments_in_layer) {
        if ($show_enter_comment_at_bottom && !$default_is_fullscreen && (($enable_comments_only_registered && $login_edit) || !$enable_comments_only_registered)) {
            $headerkommentar = "<div class='twg_underlineb'>" . $lang_comments . $com_counter . "<a onclick='return twg_showSec(" . $lang_height_comment . ")' target='details' href='" . $install_dir_com . "i_frames/i_kommentar.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>";
            $headerkommentar .= '<img alt="" width=5   src="' . $install_dir_com . 'buttons/1x1.gif" ><img class="twg_sprites add_gif" alt="' . $lang_add_kommentar . '" title="' . $lang_add_kommentar . '"   src="' . $install_dir_com . 'buttons/1x1.gif" >';
            $headerkommentar .= "</a></div>";
        } else {
            if ($kommentar <> "") {
                $headerkommentar = "<div class='twg_underlineb'>" . $lang_comments . $com_counter . "</div>";
            }
        }
    }
    return sprintf("%10s", $hits) . $headerkommentar . $kommentar;
}

// get kommentare for images
function getKommentarCount($image, $twg_album, $kwerte, $kindex)
{
    global $install_dir;
    $i = 0;
    $counter = 0;

    if (!isset($_SESSION['kwerte'])) {
        return 0;
    }

    if ($kindex == false) {
        $kwerte = $_SESSION['kwerte'];
        $kindex = $_SESSION['kindex'];
    }
    if (isset($kindex["NAME"])) {
        foreach ($kindex["NAME"] as $band) {
            if (isset($kwerte[$band]["value"])) {
                if (urldecode($kwerte[$band]["value"]) == urldecode($image)) {
                    $counter++;
                }
            }
            $i++;
        }
    }
    return $counter;
}

// every entry of the $werte is stored. Each time it is checked
// if we already have this value - if yes we replace - if no we
// add at the end
function saveBeschreibung($titel, $twg_album, $image, $werte, $index)
{
    global $xmldir, $basedir, $store_xml_in_picfolders;
    $isnew = true;
    $xml_filename = get_xml_file_name($twg_album, "/_caption.xml", "_image_text.xml");
    // we reload because someone else has maybe modified the file!
    $_SESSION["actalbum"] = '_RELOAD_';
    unset($_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)]);
    loadXMLFiles($twg_album);

    $xml_file = fopen($xml_filename, 'w');
    fputs($xml_file, '<' . "?xml version='1.0'?" . "><BESCHREIBUNG>\n");

    $i = 0;
    if (isset($index["NAME"])) {
      foreach ($index["NAME"] as $band) {
          // $imageName = urldecode(urldecode($werte[$band]["value"]));
          $imageName = urldecode($werte[$band]["value"]);
          if (urlencode($imageName) == urlencode(urldecode($image))) {
              $oldtitel = urlencode($titel);
              $isnew = false;
          } else {
              $oldtitel = $werte[$index["WERT"][$i]]["value"];
          }
          $i = $i + 1;
          if (trim($imageName) != '' && $oldtitel != '') {
              $xml_string = "<BILD><NAME>" . urlencode($imageName) . "</NAME><WERT>" . $oldtitel . "</WERT></BILD>\n";
              fputs($xml_file, $xml_string);
          }
      }
    }

    if ($isnew && $image != "" && $titel != '') {
        $xml_string = "<BILD><NAME>" . urlencode($image) . "</NAME><WERT>" . urlencode($titel) . "</WERT></BILD>\n";
        fputs($xml_file, $xml_string);
    }

    fputs($xml_file, "</BESCHREIBUNG>");
    fclose($xml_file);
    clearstatcache();
    // we reload
    $_SESSION["actalbum"] = '_RELOAD_';
    unset($_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)]);
    loadXMLFiles($twg_album);
}

// every entry of the $kwerte is stored.
function saveKommentar($titel, $name, $twg_album, $image, $kwerte, $kindex, $image_orig)
{
    global $xmldir, $basedir, $store_xml_in_picfolders, $add_new_comments_on_top, $show_comments_ip;
    if ($kindex == false) {
        if (!isset($_SESSION['kwerte'])) {
            loadXMLFiles($twg_album);
        }
        if (!isset($_SESSION['kwerte'])) {
            debug("Error save comment: " . $titel . " : " . $name . " : " . $twg_album . " : " . $image);
        }
        $kwerte = $_SESSION['kwerte'];
        $kindex = $_SESSION['kindex'];
    }

    $xml_filename = get_xml_file_name($twg_album, "/_comment.xml", "_kommentar_text.xml");
    // we reload because someone else has maybe modified the file!
    $_SESSION["actalbum"] = '_RELOAD_';
    unset($_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)]);
    loadXMLFiles($twg_album);

    $now = time(); //  = date("j.n.Y G:i");
    if ($show_comments_ip) {
        $name .= "-||-" . $_SERVER['REMOTE_ADDR'];
    }
    $titel = $now . "=||=" . $name . "=||=" . $titel;
    $xml_file = fopen($xml_filename, 'w');
    fputs($xml_file, '<' . "?xml version='1.0'?" . "><BESCHREIBUNG>\n");

    if ($add_new_comments_on_top && $image != "") {
        // new comments on top !!
        $xml_string = "<BILD><NAME>" . urlencode($image) . "</NAME><WERT>" . urlencode($titel) . "</WERT></BILD>\n";
        fputs($xml_file, $xml_string);
    }
    $i = 0;
    if (isset($kindex["NAME"])) {
        foreach ($kindex["NAME"] as $band) {
            $imageName = $kwerte[$band]["value"];
            $oldtitel = $kwerte[$kindex["WERT"][$i]]["value"];
            $i = $i + 1;
            if (trim($imageName) != "") {
                $xml_string = "<BILD><NAME>" . $imageName . "</NAME><WERT>" . $oldtitel . "</WERT></BILD>\n";
                fputs($xml_file, $xml_string);
            }
        }
    }
    if (!$add_new_comments_on_top && $image != "") {
        // new comments on bottom !!
        $xml_string = "<BILD><NAME>" . urlencode($image) . "</NAME><WERT>" . urlencode($titel) . "</WERT></BILD>\n";
        fputs($xml_file, $xml_string);
    }

    fputs($xml_file, "</BESCHREIBUNG>");
    fclose($xml_file);
    clearstatcache();
    deleteThumb($twg_album, $image_orig);
    // we reload
    $_SESSION["actalbum"] = '_RELOAD_';
    unset($_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)]);
    loadXMLFiles($twg_album);
}

// every entry of the $kwerte is stored.
function deleteKommentar($komment, $twg_album, $image, $kwerte, $kindex)
{
    global $xmldir, $basedir, $store_xml_in_picfolders;

    if ($kindex == false) {
        $kwerte = $_SESSION['kwerte'];
        $kindex = $_SESSION['kindex'];
    }

    $xml_filename = get_xml_file_name($twg_album, "/_comment.xml", "_kommentar_text.xml");

    $xml_file = fopen($xml_filename, 'w');
    fputs($xml_file, '<' . "?xml version='1.0'?" . "><BESCHREIBUNG>\n");

    $i = 0;
    foreach ($kindex["NAME"] as $band) {
        $imageName = $kwerte[$band]["value"];
        $oldtitel = $kwerte[$kindex["WERT"][$i]]["value"];
        $i = $i + 1;
        // echo urldecode($oldtitel) . ' : ' . urldecode($komment);
        if (strcmp(trim(urldecode(urldecode($oldtitel))), trim(urldecode(urldecode($komment)))) != 0) { // wir schreiben alle ausser dem zu löschenden !!
            if (trim($imageName) != "") {
                $xml_string = "<BILD><NAME>" . $imageName . "</NAME><WERT>" . $oldtitel . "</WERT></BILD>\n";
                fputs($xml_file, $xml_string);
            }
        }
    }
    fputs($xml_file, '</BESCHREIBUNG>');
    fclose($xml_file);
    clearstatcache();
    deleteThumb($twg_album, $image);
    $_SESSION["actalbum"] = '_RELOAD_';
    unset($_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)]);
    loadXMLFiles($twg_album);
    // we reload
}

function deleteThumb($twg_album, $image)
{
    global $extension_thumb;
    $thumbimage = create_thumb_image($twg_album, $image);
    $thumb = dirname(__FILE__) . "/." . create_cache_file($thumbimage, $extension_thumb);
    if (file_exists($thumb)) {
        unlink($thumb);
        clearstatcache();
    }
}

function getDownloadCount($album_url, $image)
{
    return getCount($album_url, $image, "DOWNLOAD");
}

function getVotesCount($album_url, $image)
{
    return getCount($album_url, $image, "VOTES");
}

function getCount($album_url, $image, $type)
{
    global $xmldir, $lang_rating_vote, $enhanced_debug, $basedir, $store_xml_in_picfolders;

    $xml_filename = get_xml_file_name($album_url, "/_counter.xml", "_image_counter.xml");

    if ((!isset($_SESSION["twg_count_actalbum"])) || ($_SESSION["twg_count_actalbum"] != $album_url)) {
        $returncount = 1;

        if (!file_exists($xml_filename)) {
            return 0;
        } else {
            // we kill the caching because we need the current data
            unset($_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)]);
            $xml_data = readXMLFile($xml_filename, "3");
            $werte = $xml_data[0];
            $index = $xml_data[1];
        }
        $_SESSION["twg_count_actalbum"] = $album_url;
        $_SESSION["twg_count_werte"] = $werte;
        $_SESSION["twg_count_index"] = $index;
    } else {
        // load session variables
        $werte = $_SESSION["twg_count_werte"];
        $index = $_SESSION["twg_count_index"];
    }
    $i = 0;
    if (!$image) {
        return;
    } // we only cache
    foreach ($index["NAME"] as $band) {
        if (isset($werte[$band]["value"])) {
            $imageName = $werte[$band]["value"];
            if (urldecode($imageName) == $image) { // we have to decode because in the xml we encoded already
                if ($type == "DOWNLOAD") {
                    $count = $werte[$index["DOWNLOAD"][$i]]["value"];
                    return $count;
                } else {
                    $votes = $werte[$index["VOTES"][$i]]["value"];
                    $average = $werte[$index["AVERAGE"][$i]]["value"];
                    return trim(sprintf("%1.2f", $average)) . " (" . $votes . " " . $lang_rating_vote . ")";
                }
            }
            $i = $i + 1;
        } else {
            if ($enhanced_debug) {
                debug("getCount: Index not found in xml file '" . $xml_filename . "' - entry " . $i);
                debug(print_r($index, true));
                debug(print_r($werte, true));
            }
        }
    }
    // if not we return 0
    return 0;
}

function increaseImageCount($album_url, $image)
{
    return increaseCount($album_url, $image, "WERT", 1);
}

function increaseDownloadCount($album_url, $image)
{
    increaseCount($album_url, $image, "DOWNLOAD", 1);
}

function increaseVotesCount($album_url, $image, $rating)
{
    return increaseCount($album_url, $image, "VOTES", $rating);
}

function increaseCount($album_url, $image, $type, $count)
{
    global $xmldir, $basedir, $store_xml_in_picfolders;
    global $enhanced_debug;

    $top_count = array();

    $returncount = 1;
    $xml_dummy_string = '<' . "?xml version='1.0'?" . ">\n<BESCHREIBUNG><BILD><NAME>" . urlencode($image) . "</NAME><WERT>0</WERT><DOWNLOAD>0</DOWNLOAD><VOTES>0</VOTES><AVERAGE>0</AVERAGE></BILD>\n</BESCHREIBUNG>";

    $ret_data = get_twg_xml_data_mig($album_url, "/_counter.xml", "_image_counter.xml", $xml_dummy_string, "increaseCount", true);
    $werte = $ret_data['werte'];
    $index = $ret_data['index'];
    $xml_filename = $ret_data["xml_filename"];

    $reload = false;
    if (isset($_SESSION['lastimage' . $type])) {
        if ($_SESSION['lastimage' . $type] == ($album_url . $image)) { // we check if we have a reload ;).
            if ($type == "VOTES" || $type == "DOWNLOAD") {
                return false;
            }
            $reload = true;
        }
    }

    $isnew = true;
    $i = 0;

    $xml_file = fopen($xml_filename, 'w');
    if ($xml_file !== false) {
        fputs($xml_file, '<' . "?xml version='1.0'?" . "><BESCHREIBUNG>\n");

        $_SESSION['lastimage' . $type] = ($album_url . $image);

        foreach ($index["NAME"] as $band) {
            if (isset($werte[$band]["value"])) {
                $imageName = $werte[$band]["value"];
                if (isset($werte[$index["WERT"][$i]]["value"])) {
                    $oldcount = $werte[$index["WERT"][$i]]["value"];
                } else {
                    $oldcount = 0;
                }
                if (isset($werte[$index["DOWNLOAD"][$i]]["value"])) {
                    $olddownload = $werte[$index["DOWNLOAD"][$i]]["value"];
                } else {
                    $olddownload = 0;
                }
                if (isset($werte[$index["VOTES"][$i]]["value"])) {
                    $oldvotes = $werte[$index["VOTES"][$i]]["value"];
                } else {
                    $oldvotes = 0;
                }
                if (isset($werte[$index["VOTES"][$i]]["value"])) {
                    $oldaverage = $werte[$index["AVERAGE"][$i]]["value"];
                } else {
                    $oldaverage = 0;
                }

                if (urldecode($imageName) == $image) { // we have to decode because in the xml we encoded already
                    if ($reload) {
                        $newcount = $oldcount;
                        $newdownload = $olddownload;
                        $newvotes = $oldvotes;
                        $newaverage = $oldaverage;
                    } else {
                        if ($type == "WERT") {
                            $newcount = $oldcount + 1;
                            $newdownload = $olddownload;
                            $newvotes = $oldvotes;
                            $newaverage = $oldaverage;
                        } else if ($type == "DOWNLOAD") {
                            $newcount = $oldcount;
                            $newdownload = $olddownload + 1;
                            $newvotes = $oldvotes;
                            $newaverage = $oldaverage;
                        } else { // votes
                            $newcount = $oldcount;
                            $newdownload = $olddownload;
                            $newaverage = (($oldaverage * $oldvotes) + $count) / ($oldvotes + 1);
                            $newvotes = $oldvotes + 1;
                        }
                    }
                    $returncount = $newcount; // we only return the viewcounter - the rest is called seperately !
                    $isnew = false;
                } else {
                    $newcount = $oldcount;
                    $newdownload = $olddownload;
                    $newvotes = $oldvotes;
                    $newaverage = $oldaverage;
                }
                $i = $i + 1;
                $xml_string = "<BILD><NAME>" . $imageName . "</NAME><WERT>" . $newcount . "</WERT><DOWNLOAD>" . $newdownload . "</DOWNLOAD><VOTES>" . $newvotes . "</VOTES><AVERAGE>" . $newaverage . "</AVERAGE></BILD>\n";
                fputs($xml_file, $xml_string);
            } else {
                if ($enhanced_debug) {
                    debug("increaseCount: Index not found in xml file '" . $xml_filename . "' - entry " . $i);
                    debug(print_r($index, true));
                    debug(print_r($werte, true));
                }
            }
        }
        if ($isnew) {
            $newcount = 0;
            $newdownload = 0;
            $newvotes = 0;
            $newaverage = 0;
            if ($type == "WERT") {
                $newcount = 1;
            }
            if ($type == "DOWNLOAD") {
                $newdownload = 1;
            }
            if ($type == "RATE") {
                $newvotes = 1;
                $newaverage = $count;
            }
            $xml_string = "<BILD><NAME>" . urlencode($image) . "</NAME><WERT>" . $newcount . "</WERT><DOWNLOAD>" . $newdownload . "</DOWNLOAD><VOTES>" . $newvotes . "</VOTES><AVERAGE>" . $newaverage . "</AVERAGE></BILD>\n";
            fputs($xml_file, $xml_string);
        }

        fputs($xml_file, "</BESCHREIBUNG>");
        fclose($xml_file);
        clearstatcache();
    } else {
        debug('Please check the file: ' . $xml_filename . '. Seems php cannot read/write/create it properly. TWG tries to rename the file to ' . $xml_filename . '.bak');
        rename($xml_filename, $xml_filename . '.bak');
    }
    $_SESSION["twg_count_actalbum"] = $album_url;
    $_SESSION["twg_count_werte"] = $werte;
    $_SESSION["twg_count_index"] = $index;
    return $returncount;
}

function getTopXViews($dirs)
{
    return getTopX($dirs, 'WERT');
}

function getTopXDownloads($dirs)
{
    return getTopX($dirs, 'DOWNLOAD');
}

function getTopXAverage($dirs)
{
    return getTopX($dirs, 'AVERAGE');
}

function getTopXVotes($dirs)
{
    return getTopX($dirs, 'VOTES');
}

function getTopXViewsImage($dir, $nr = 0)
{
    global $autocreate_folder_image_recursive, $privatelogin, $basedir;
    if ($autocreate_folder_image_recursive) {
        if ($dir) {
            $dirs = get_view_dirs($basedir . "/" . $dir, $privatelogin);
        } else {
            $dirs = get_view_dirs($basedir, $privatelogin);
        }
        $top = getTopX($dirs, 'WERT');
        if (!$top || count($top) == 0) {
            // we try to use the first image from the first folder.
            if (isset($dirs[0])) {
                $first = get_first($dirs[0]);
                $idir = substr($dirs[0], (strlen($dir) + 1));
                if ($idir != "") {
                    $idir .= '/';
                }
                return ($first) ? $idir . $first : false;
            } else {
                return false;
            }
        }
        $image = urldecode(substr(strrchr($top[$nr], '='), 1));
        $idir = strstr($top[$nr], '=');
        $idir = urldecode(substr($idir, 1, strpos($idir, '&') - 1));
        if ($dir != "") {
            $idir = substr($idir, (strlen($dir) + 1));
        }
        if ($idir != "") {
            return $idir . "/" . $image;
        } else {
            return $image;
        }
    } else {
        $dirs = array();
        $dirs[] = $dir;
        $top = getTopX($dirs, 'WERT');
        if (!$top || count($top) == 0) {
            // default image is used.
            return false;
        }
        return urldecode(substr(strrchr($top[$nr], '='), 1));
    }
}

function getTopX($dirs, $type)
{
    global $cachedir, $xmldir, $install_dir, $install_dir_view, $twg_standalone;
    global $basedir, $store_xml_in_picfolders, $is_cache_call;
    global $enhanced_debug, $install_dir_save, $number_top10, $cache_dirs, $precache_main_top_x_limit;
    $min_value = -1;

    if (isset($install_dir_save)) {
        $install_dir = $install_dir_save;
    }

    $overlimit = false;
    if (isset($_SESSION["count_treec" . $install_dir . $basedir])) {
        $overlimit = $_SESSION["count_treec" . $install_dir . $basedir] > $precache_main_top_x_limit;
    }

    $doserialize = $cache_dirs && $overlimit;
    if ($doserialize) {
        $dirhash = sha1(implode("", $dirs));
        $cachename = $cachedir . "/_t_" . $type . "_" . $dirhash . $GLOBALS["standalone"] . ".tmp.php";
        if (file_exists($cachename)) {
            if ($is_cache_call) {
                return true;
            }
            $data = getFileContent($cachename, "");
            return unserialize($data);
        }
    }

    $topx = array();

    for ($ii = 0; $ii < count($dirs); $ii++) {
        $returncount = 1;

        $xml_filename = get_xml_file_name($dirs[$ii], "/_counter.xml", "_image_counter.xml");
        if (file_exists($xml_filename)) {
            $xml_data = readXMLFile($xml_filename, "5");
            $werte = $xml_data[0];
            $index = $xml_data[1];
            $i = 0;
            foreach ($index["NAME"] as $band) {
                if (isset($werte[$band]["value"])) {
                    $imageName = $werte[$band]["value"];
                    // echo  "<br><br>" . $imageName;
                    if (isset($index[$type])) {
                        if (isset($werte[$index[$type][$i]]["value"])) {
                            $counter = $werte[$index[$type][$i]]["value"];
                        } else {
                            if ($enhanced_debug) {
                                debug("getTopX: Index not found in xml file '" . $xml_filename . "' - entry " . $i . " - " . $type . " - " . $imageName);
                                debug(print_r($index, true));
                                debug(print_r($werte, true));
                            }
                            $counter = 0;
                        }
                    } else {
                        $counter = 0;
                    }
                    // echo "<br>" . urldecode($imageName) . ":" . $counter . "<br>";
                    $i++;

                    if ($counter != 0) {
                        if ($type == "AVERAGE") {
                            $counter = trim(sprintf("%1.2f", $counter));
                        }
                        // test if the image still exists!
                        $remote_image = twg_checkurl($basedir . "/" . $dirs[$ii]);
                        $ilist = get_image_list($dirs[$ii]);
                        if ($remote_image) {
                            $remote_image_exists = in_array(urldecode($imageName), get_image_list($dirs[$ii]));
                        } else {
                            $remote_image_exists = false;
                        }
                        if (file_exists($basedir . "/" . $dirs[$ii] . "/" . urldecode($imageName)) || $remote_image_exists) {
                            // the decode at the end is important - if you remove them images with hard filenames are not displayed :).
                            $compare = sprintf("%010s", $counter) . "_" . $install_dir_view . "image.php?twg_album=" . urlencode($dirs[$ii]) . "&amp;twg_type=thumb&amp;twg_show=" . $imageName . $twg_standalone;
                            if ($counter >= $min_value) {
                                $topx[] = $compare;
                                if (count($topx) > 100) { // we shrink the topx
                                    rsort($topx);
                                    reset($topx);
                                    $topx = array_slice($topx, 0, ($number_top10 + 10));
                                    $last_entry = array_pop($topx);
                                    $min_value = sprintf('%d', substr($last_entry, 0, 10)) + 0;
                                }
                            }
                        }
                    }
                } else {
                    if ($enhanced_debug) {
                        debug("getTopX: Error in xml file '" . $xml_filename . "' - entry " . $i);
                        debug(print_r($index, true));
                        debug(print_r($werte, true));
                    }
                }
            }
        }
    }
    rsort($topx);
    reset($topx);
    // we only transfer the topx + 10 for display filling
    $ret_val = array_slice($topx, 0, ($number_top10 + 10));
    // we serialize the data 
    if ($doserialize) {
        $ser_file = fopen($cachename, 'w');
        fputs($ser_file, serialize($ret_val));
        fclose($ser_file);
    }
    if ($is_cache_call) return false;
    return $ret_val;
}

function getLatestKomments($dirs)
{
    global $xmldir, $cache_dirs, $cachedir, $is_cache_call, $number_top10, $charset, $basedir;
    global $install_dir, $twg_standalone, $install_dir, $install_dir_save, $basedir, $store_xml_in_picfolders;
    global $precache_main_top_x_limit, $install_dir_view;

    $id = "";
    if (isset($install_dir_save)) {
        $install_dir = $install_dir_save;
    }

    if (!isset($_SESSION["count_treec" . $install_dir . $basedir])) {
        // if not set we cache because most of the time this is disabled for big galleries.
        $_SESSION["count_treec" . $install_dir . $basedir] = $precache_main_top_x_limit + 1;
    }
    $doserialize = $cache_dirs && ($_SESSION["count_treec" . $install_dir . $basedir] > $precache_main_top_x_limit);
    if ($doserialize) {
        $dirhash = sha1(implode("", $dirs));
        $cachename = $cachedir . "/_t_COM_" . $dirhash . $GLOBALS["standalone"] . ".tmp.php";
        if (file_exists($cachename)) {
            if ($is_cache_call) {
                return true;
            }
            $data = getFileContent($cachename, "");
            return unserialize($data);
        }
    }

    $type = "WERT";

    $topx = array();

    for ($ii = 0; $ii < count($dirs); $ii++) {
        $returncount = 1;
        $xml_filename = get_xml_file_name($dirs[$ii], "/_comment.xml", "_kommentar_text.xml");
        if (file_exists($xml_filename)) {
            $xml_data = readXMLFile($xml_filename, "6");
            $werte = $xml_data[0];
            $index = $xml_data[1];
            $i = 0;
            $map = array();
            if (isset($index["NAME"])) {
                foreach ($index["NAME"] as $band) {
                    $imageName = $werte[$band]["value"];
                    $line = urldecode($werte[$index["WERT"][$i]]["value"]);
                    $i++;
                    if (!(trim($line) == "")) {
                        list ($datum, $name, $komment) = explode("=||=", $line);
                        if (true) { // !isset($map[$imageName]) - if you add this every picture does only appear once!
                            $map[$imageName] = "set";
                            $name = replacesmilies($name);
                            $komment = replacesmilies($komment);
                            $pos = strpos($datum, ".");
                            if ($pos) {
                                $ttime = split("[.: ]", $datum);
                                $datum = strtotime($ttime[1] . "/" . $ttime[0] . "/" . $ttime[2] . " " . $ttime[3] . ":" . $ttime[4]); // default for old formats!
                            }
                            $line = $datum . "=||=" . ($name) . "=||=" . ($komment);
                            $line = html_entity_decode_fixed($line, ENT_COMPAT, $charset);
                            $remote_image = twg_checkurl($basedir . "/" . $dirs[$ii]);
                            if ($remote_image) {
                                $remote_image_exists = in_array(urldecode($imageName), get_image_list($dirs[$ii]));
                            } else {
                                $remote_image_exists = false;
                            }
                            if (file_exists($basedir . "/" . $dirs[$ii] . "/" . urldecode($imageName)) || $remote_image_exists) {
                                // the decode at the end is important - if you remove them images with hard filenames are not displayed :).
                                $compare = $line . "=||=" . $install_dir_view . "image.php?twg_album=" . urlencode($dirs[$ii]) . "&amp;twg_type=thumb&amp;twg_show=" . $imageName . $twg_standalone;
                                // echo $compare;
                                $topx[] = $compare;
                            }
                        }

                    }
                }
            }
        }
    }
    rsort($topx);
    reset($topx);
    $ret_val = array_slice($topx, 0, ($number_top10 + 10));
    if ($doserialize) {
        $ser_file = fopen($cachename, 'w');
        fputs($ser_file, serialize($ret_val));
        fclose($ser_file);
    }
    if ($is_cache_call) return false;
    return $ret_val;

}

function searchComments($dirs, $searchstring)
{
    global $xmldir;
    global $install_dir, $install_dir_view;
    global $twg_standalone;
    global $basedir;
    global $basedir, $store_xml_in_picfolders, $charset;

    $type = "WERT";

    $topx = array();
    if ($searchstring == "") {
        return $topx;
    }

    for ($ii = 0; $ii < count($dirs); $ii++) {
        $returncount = 1;

        $xml_filename = get_xml_file_name($dirs[$ii], "/_comment.xml", "_kommentar_text.xml");
        if (file_exists($xml_filename)) {
            $xml_data = readXMLFile($xml_filename, "7");
            $werte = $xml_data[0];
            $index = $xml_data[1];
            $i = 0;
            $map = array();
            foreach ($index["NAME"] as $band) {
                $imageName = $werte[$band]["value"];
                $line = urldecode($werte[$index["WERT"][$i]]["value"]);
                $i++;
                if (!(trim($line) == "")) {
                    list ($datum, $name, $komment) = explode("=||=", $line);
                    if (false) { // this is a easy extension of the comment search for a 2.nd parameter
                        $value2 = true; // do something real !
                    } else {
                        $value2 = true;
                    }
                    if (stristr(html_entity_decode_fixed($name, ENT_COMPAT, $charset), $searchstring) || (stristr(html_entity_decode($komment, ENT_COMPAT, $charset), $searchstring) && $value2)) {
                        $name = replacesmilies($name);
                        $komment = replacesmilies($komment);
                        $pos = strpos($datum, ".");
                        if ($pos) {
                            $ttime = split("[.: ]", $datum);
                            $datum = strtotime($ttime[1] . "/" . $ttime[0] . "/" . $ttime[2] . " " . $ttime[3] . ":" . $ttime[4]); // default for old formats!
                        }
                        $komment = html_entity_decode_fixed($komment, ENT_COMPAT, $charset);
                        if (isset($charset) && ($charset == "utf-8")) {
                            $line = $datum . "=||=" . $name . "=||=" . utf8_decode($komment); // fix für html chars im input
                        } else {
                            $line = $datum . "=||=" . $name . "=||=" . $komment;
                        }

                        $remote_image = twg_checkurl($basedir . "/" . $dirs[$ii]);
                        if ($remote_image) {
                            $remote_image_exists = in_array(urldecode($imageName), get_image_list($dirs[$ii]));
                        } else {
                            $remote_image_exists = false;
                        }
                        if (file_exists($basedir . "/" . $dirs[$ii] . "/" . urldecode($imageName)) || $remote_image_exists) {
                            // the decode at the end is important - if you remove them images with hard filenames are not displayed :).
                            $compare = $line . "=||=" . $install_dir_view . "image.php?twg_album=" . urlencode($dirs[$ii]) . "&amp;twg_type=thumb&amp;twg_show=" . $imageName . $twg_standalone;
                            // echo $compare;
                            $topx[] = $compare;
                        }
                    }
                }
            }
        }
    }
    rsort($topx);
    reset($topx);
    return $topx;
}

function searchCaption($dirs, $searchstring)
{
    global $xmldir, $charset;
    global $install_dir, $install_dir_view;
    global $twg_standalone;
    global $basedir, $store_xml_in_picfolders, $charset;

    $type = "WERT";

    $topx = array();
    if ($searchstring == "") {
        return $topx;
    }

    for ($ii = 0; $ii < count($dirs); $ii++) {
        $returncount = 1;
        $xml_filename = get_xml_file_name($dirs[$ii], "/_caption.xml", "_image_text.xml");
        if (file_exists($xml_filename)) {
            $xml_data = readXMLFile($xml_filename, "8");
            $werte = $xml_data[0];
            $index = $xml_data[1];
            $i = 0;
            $map = array();
            foreach ($index["NAME"] as $band) {
                $imageName = $werte[$band]["value"];
                $line = urldecode($werte[$index["WERT"][$i]]["value"]);
                $i++;
                if (!(trim($line) == "")) {
                    $datum = ""; // we want to have the same display for all results - therefore some dummys here!
                    $name = $line;
                    $comment = "";

                    if (!isset($map[$imageName])) {
                        $map[$imageName] = "set";

                        if (stristr(html_entity_decode_fixed($name, ENT_COMPAT, $charset), $searchstring)) {
                            $name = replacesmilies($name);
                            $komment = htmlentities($dirs[$ii], ENT_QUOTES, $charset);

                            $line = $datum . "=||=" . $name . "=||=" . $komment;

                            $remote_image = twg_checkurl($basedir . "/" . $dirs[$ii]);
                            if ($remote_image) {
                                $remote_image_exists = in_array(urldecode($imageName), get_image_list($dirs[$ii]));
                            } else {
                                $remote_image_exists = false;
                            }

                            if (file_exists($basedir . "/" . $dirs[$ii] . "/" . urldecode($imageName)) || $remote_image_exists) {
                                // the decode at the end is important - if you remove them images with hard filenames are not displayed :).
                                $compare = $line . "=||=" . $install_dir_view . "image.php?twg_album=" . urlencode($dirs[$ii]) . "&amp;twg_type=thumb&amp;twg_show=" . $imageName . $twg_standalone;
                                // echo $compare;
                                $topx[] = $compare;
                            }
                        }
                    }
                }
            }
        }
    }
    return $topx;
}

/** 
 *  Save the given caption. If no caption is given the image tags are read 
 *  and the caption is saved. 
 */ 
function saveCaption($album_url, $image, $caption = '')
{
    global $xmldir, $basedir, $store_xml_in_picfolders;
    global $iptc_fields_for_caption, $exif_field_for_caption, $charset;
    global $iptc_fields_for_caption_add, $iptc_fields_for_caption_add_style;
    global $filesystem_encoding, $iptc_encoding;

    $retValue = null;
    $xml_filename = get_xml_file_name($album_url, "/_caption.xml", "_image_text.xml");

    if (file_exists($xml_filename)) {
        $xml_data = readXMLFile($xml_filename, "saveCaption");
        $werte = $xml_data[0];
        $index = $xml_data[1];

        $i = 0;
        if (isset($index["NAME"])) {
            foreach ($index["NAME"] as $band) {
                if (isset($werte[$band]["value"])) {
                    $imageName = $werte[$band]["value"];
                    if (urldecode($imageName) == $image) { // we have to decode because in the xml we encoded already
                        $retValue = urldecode($werte[$index["WERT"][$i]]["value"]);
                    }
                    $i++;
                }
            }
        }
    } else {
        $xml_dummy_string = '<' . "?xml version='1.0'?" . ">\n<BESCHREIBUNG>\n<BILD><NAME> </NAME><WERT> </WERT></BILD>\n</BESCHREIBUNG>";
        $ret_data = get_twg_xml_data_mig($album_url, "/_caption.xml", "_image_text.xml", $xml_dummy_string, "read caption");
        $werte = $_SESSION['werte'] = $ret_data['werte'];
        $index = $_SESSION['index'] = $ret_data['index'];
    }
    $save = false;
    
    if ($caption == '') {
      // now we read the image tags !
      if (!isset($retValue)) {
          $retValue = get_iptc_data($album_url, $image, $iptc_fields_for_caption, true);
          if (isset($retValue) && $retValue != '') {
              $save = true;
          }
          // now we read the 2nd iptc tag!
          if (count($iptc_fields_for_caption_add) > 0) {
              $retValue2 = get_iptc_data($album_url, $image, $iptc_fields_for_caption_add, true);
              if (isset($retValue2) && $retValue2 != '') {
                  if ($save) {
                      // we join
                      $retValue .= sprintf($iptc_fields_for_caption_add_style, $retValue2);
                  } else {
                      $retValue = $retValue2;
                      $save = true;
                  }
              }
          }
          if ($save) {
              if ($charset == "utf-8") {
                  $retValue = ($iptc_encoding == 'utf-8') ? $retValue : utf8_encode($retValue);
              }
          }
        // end 2nd iptc tag
        // we read the exif data if no tags are found
        if (!$save) {
            $retValue = get_exif_data($album_url, $image, $exif_field_for_caption);
            if (isset($retValue)) {
                if ($charset == "utf-8") {
                    $retValue = utf8_encode($retValue);
                }
                $save = true;
            }
        }
      }
     
  
     
    } else {
       $save = true;
       $retValue = $caption;
       if ($charset == "utf-8") {
         $retValue = ($iptc_encoding == 'utf-8') ? $retValue : utf8_encode($retValue);
       }
    }
    
    if ($save) {
        saveBeschreibung($retValue, $album_url, $image, $werte, $index);
        return $retValue;
    }
    return getCaptionByFilename($image);
}

/*

TAGS

*/

function getTags($album_url, $image)
{
    global $xmldir, $basedir, $store_xml_in_picfolders, $charset;
    global $iptc_fields_for_imagetags, $iptc_fields_for_dirtags, $iptc_encoding;

    $retArray = array();
    $xml_filename = get_xml_file_name($album_url, "/_tags.xml", "_tags.xml");

    if (file_exists($xml_filename)) {
        $xml_data = readXMLFile($xml_filename, "getTags");
        $werte = $xml_data[0];
        $index = $xml_data[1];

        $i = 0;
        foreach ($index["NAME"] as $band) {
            if (isset($werte[$band]["value"])) {
                $imageName = $werte[$band]["value"];
                if (urldecode($imageName) == "dir") { // dir tag!
                    if (isset($werte[$index["WERT"][$i]]["value"])) {
                        $retArray["dir"] = urldecode($werte[$index["WERT"][$i]]["value"]);
                    }
                } else if (urldecode($imageName) == $image) { // we have to decode because in the xml we encoded already
                    if (isset($werte[$index["WERT"][$i]]["value"])) {
                        $retArray["image"] = urldecode($werte[$index["WERT"][$i]]["value"]);
                    }
                }
                $i++;
            }
        }
    }

    $save = false;
    $savedir = false;
    // now we read the image tags if nothing is found in the xml!
    if (!isset($retArray["dir"])) {
        $retArray["dir"] = get_iptc_data($album_url, $image, $iptc_fields_for_dirtags);
        if (isset($retArray["dir"])) $savedir = true;
    }
    if (!isset($retArray["image"])) {
        $retArray["image"] = get_iptc_data($album_url, $image, $iptc_fields_for_imagetags);
        if (isset($retArray["image"])) $save = true;
    }

    if ($save || $savedir) {
        // set correct encoding
        if ($charset == "utf-8") {
            if ($savedir) {
                $retArray["dir"] = ($iptc_encoding == 'utf-8') ? $retArray["dir"] : utf8_encode($retArray["dir"]);
            }
            if ($save) {
                $retArray["image"] = ($iptc_encoding == 'utf-8') ? $retArray["image"] : utf8_encode($retArray["image"]);
            }
        }
        saveTags($album_url, $image, $retArray["image"], $retArray["dir"]);
    }
    return $retArray;
}

function get_iptc_data($twg_album, $image, $iptc_array, $stOnly = false)
{
    global $basedir, $use_iptc_tags, $charset, $iptc_encoding;

    $keywords = null;
    if ($use_iptc_tags) {
        $remote_image = twg_checkurl($basedir . "/" . $twg_album);

        if ($remote_image) {
            $filename = getRemoteImagePath($remote_image, $image);
        } else {
            $filename = $basedir . "/" . $twg_album . "/" . $image;
        }
        set_error_handler("on_error_no_output"); // images with errors are ignored
        $oldsize = @getimagesize($filename, $info);
        set_error_handler("on_error");
        if (isset($info["APP13"])) {
            $iptc = iptcparse($info["APP13"]);
            if (is_array($iptc)) {
                foreach ($iptc_array as $key) {
                    if (isset($iptc[$key])) {
                        $keywordcount = count($iptc[$key]);
                        for ($i = 0; $i < $keywordcount; $i++) $keywords .= $iptc[$key][$i] . ",";
                        if ($stOnly) {
                            break;
                        }
                    }
                }
            }
        }
        if (isset($keywords)) {
            $keywords = substr($keywords, 0, -1);
        }
    }
    //if (isset($charset) && strtolower($charset) == "utf-8" && $iptc_encoding != 'utf-8') {
    //  $keywords = utf8_encode($keywords);
    //}
    return $keywords;
}

function get_exif_data($twg_album, $image, $exif_field)
{
    global $basedir, $use_iptc_tags;
    set_error_handler("on_error_no_output"); // 4.x gives depreciated errors here but if I change it it does only work with 5.x - therefore I don't show any errors here !
    include_once dirname(__FILE__) . "/exifReader.inc.php";
    set_error_handler("on_error");

    if ($use_iptc_tags && $exif_field != "") {
        $remote_image = twg_checkurl($basedir . "/" . $twg_album);
        if ($remote_image) {
            $filename = getRemoteImagePath($remote_image, $image);
        } else {
            $filename = $basedir . "/" . $twg_album . "/" . $image;
        }
        set_error_handler("on_error_no_output"); // images with errors are ignored
        $er = new phpExifReader($filename);
        $er->processFile();
        $exif_info = $er->getImageInfo();
        set_error_handler("on_error");
        // shows all tags in the debug file - use this to find out all possible keys
        // debug(print_r ($exif_info,true ));
        if (isset($exif_info[$exif_field])) {
            $value = trim($exif_info[$exif_field]);
            if ($value != "") {
                return $value;
            }
        }
    }
    return;
}

function saveTags($album_url, $image, $tags_image, $tags_dir)
{
    global $xmldir, $basedir, $store_xml_in_picfolders, $enhanced_debug, $charset;

    $v_array = array();

    $tags_image = trim_elements($tags_image);
    $tags_dir = trim_elements($tags_dir);

    $xml_dummy_string = '<' . "?xml version='1.0'?" . ">\n<BESCHREIBUNG><BILD><NAME> </NAME><WERT> </WERT></BILD>\n</BESCHREIBUNG>";

    $ret_data = get_twg_xml_data_mig($album_url, "/_tags.xml", "_tags.xml", $xml_dummy_string, "increaseCount", true);
    $werte = $ret_data['werte'];
    $index = $ret_data['index'];
    $xml_filename = $ret_data["xml_filename"];

    $xml_file = fopen($xml_filename, 'w');
    fputs($xml_file, '<' . "?xml version='1.0'?" . "><BESCHREIBUNG>\n");

    $i = 0;
    $isnew = true;
    // we add the directory tag
    $xml_string = "<BILD><NAME>dir</NAME><WERT>" . urlencode($tags_dir) . "</WERT></BILD>\n";
    fputs($xml_file, $xml_string);

    if ($tags_dir != "") {
        $v_array = countTags($v_array, $tags_dir, 5);
    }

    foreach ($index["NAME"] as $band) {
        $imageName = urldecode($werte[$band]["value"]);
        if ($imageName != "dir") {
            if (urlencode($imageName) == urlencode(urldecode($image))) {
                $oldtitel = urlencode($tags_image);
                $isnew = false;
            } else {
                $oldtitel = $werte[$index["WERT"][$i]]["value"];
            }
            if (trim($imageName) != "") {
                $v_array = countTags($v_array, urldecode($oldtitel), 1);
                $xml_string = "<BILD><NAME>" . urlencode($imageName) . "</NAME><WERT>" . $oldtitel . "</WERT></BILD>\n";
                fputs($xml_file, $xml_string);
            }
        }
        $i = $i + 1;
    }

    if ($isnew && $image != "") {
        if ($tags_image) {
            $v_array = countTags($v_array, $tags_image, 1);
            $xml_string = "<BILD><NAME>" . urlencode($image) . "</NAME><WERT>" . urlencode($tags_image) . "</WERT></BILD>\n";
            fputs($xml_file, $xml_string);
        }
    }

    fputs($xml_file, "</BESCHREIBUNG>");
    fclose($xml_file);
    clearstatcache();
    // debug("save:");
    // debug(print_r ($v_array,true));
    create_topx_xml($album_url, "_top_tag.xml", $v_array);
    // we reload the file from the hd - maybe it was modified by someone else! + topx are refreshed
    unset($_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)]);
    unset($_SESSION['xmlcache_xml' . $album_url . '_top_tagxml']);
    // we delete the session TT data because it is not up to date anymore.
    unset($_SESSION['TWG_TT']);
}

/**
 * Gets the xml filename - topx are treated differently!
 */
function get_xml_file_name($twg_album, $name1, $name2)
{
    global $basedir, $xmldir, $store_xml_in_picfolders, $autocreate_folder_id;

    if ($twg_album || $twg_album == "") {
        $album_path = $basedir . "/" . $twg_album;
    } else {
        $album_path = $basedir;
    }
    $twg_album_u = str_replace("/", "_", $twg_album);
    $xml_filename_old = "./" . $xmldir . "/" . $twg_album_u . $name2;

    if ($store_xml_in_picfolders && is_writable($album_path)) {
        $xml_filename = $album_path . $name1;
        if (file_exists($xml_filename_old)) {
            copy($xml_filename_old, $xml_filename);
            unlink($xml_filename_old);
            $xml_filename_old_top = "./" . $xmldir . "/" . $twg_album_u . "_top_tag.xml";
            if ($name1 == "/_tags.xml" && file_exists($xml_filename_old_top)) { // we copy the topx as well!
                $xml_filename_top = $album_path . "/_top_tag.xml";
                copy($xml_filename_old_top, $xml_filename_top);
                unlink($xml_filename_old_top);
            }
        }
    } else {
        // we check if there is a folder.id
        $fid = $album_path . '/folder.id';
        if (file_exists($fid)) {
            $prefix = './' . $xmldir . '/' . trim(file_get_contents($fid));
            $xml_filename = $prefix . ltrim($name2, '/');
        } else {
            if ($autocreate_folder_id && is_writable($album_path) && $twg_album_u != '') {
                file_put_contents($fid, $twg_album_u);
            }
            $xml_filename = $xml_filename_old;
        }
    }
    return $xml_filename;
}

function get_twg_xml_data_mig($album_url, $name1, $name2, $xml_dummy_string, $error_tag, $nocache = false)
{
    global $store_xml_in_picfolders, $xmldir, $basedir, $autocreate_folder_id;

    $returnArray = array();
    $album_path = $basedir . "/" . $album_url;
    $migration = false;
    if ($store_xml_in_picfolders && is_writeable($album_path)) {
        $xml_filename_new = $album_path . $name1;
        if (file_exists($xmldir)) { // we check for migration
            $xml_filename = $xmldir . "/" . str_replace("/", "_", $album_url) . $name2;
            if (file_exists($xml_filename)) {
                $migration = true;
            } else {
                $xml_filename = $xml_filename_new;
            }
        } else {
            $xml_filename = $xml_filename_new;
        }
    } else {
        $fid = $album_path . '/folder.id';
        if (file_exists($fid)) {
            // $xml_filename= $xml_filename_new = './' . $xmldir . '/' . trim(file_get_contents($fid)) . ltrim($name1 , '/');
            $prefix = './' . $xmldir . '/' . trim(file_get_contents($fid));
            $xml_filename = $xml_filename_new = $prefix . ltrim($name2, '/');

        } else {
            $album_url = str_replace("/", "_", $album_url);
            if ($autocreate_folder_id && is_writable($album_path) && $album_url != '') {
                file_put_contents($fid, $album_url);
            }
            $xml_filename = $xml_filename_new = $xmldir . "/" . $album_url . $name2;
        }
    }

    if (!file_exists($xml_filename)) {
        $xml_filename = $xml_filename_new;
        // we create an empty one
        set_error_handler("on_error_no_output"); // we do error handling below
        $xml_file = fopen($xml_filename, 'w');
        set_error_handler("on_error");
        if (!$xml_file) {
            return startErrorHandling($xml_filename, "created");
        }
        fputs($xml_file, $xml_dummy_string);
        fclose($xml_file);
    }

    if ($nocache) {
        // we kill the caching because we need the current data
        unset($_SESSION['xmlcache_' . remove_trailing_rel_path($xml_filename)]);
    }

    $xml_data = readXMLFile($xml_filename, $error_tag);
    $returnArray["xml_filename"] = $xml_filename_new;
    $returnArray['werte'] = $xml_data[0];
    $returnArray['index'] = $xml_data[1];

    if ($migration) {
        // we copy the file!
        copy($xml_filename, $xml_filename_new);
        // and delete the old one
        unlink($xml_filename);
    }
    return $returnArray;
}

/**
 * * Formats the tags how we need it!
 */
function trim_elements($str)
{
    return implode(",", array_unique(array_filter(array_map("trim", explode(",", $str)), "not_empty")));
}

function not_empty($var)
{
    return (strlen($var) > 0);
}

function countTags($v_array, $tags_str, $value)
{
    $tags_array = explode(",", $tags_str);
    foreach ($tags_array as $tag) {
        $tag = trim($tag);
        if (isset($v_array[$tag])) {
            $v_array[$tag] += $value;
        } else {
            $v_array[$tag] = $value;
        }
    }
    return $v_array;
}

function create_topx_xml($album, $file_prefix, $v_array)
{
    global $number_of_top_tags;
    global $xmldir, $basedir, $store_xml_in_picfolders;

    $t_array = array();
    $i = 0;

    arsort($v_array, SORT_NUMERIC);
    reset($v_array);
    foreach ($v_array as $tag => $counter) {
        $t_array[$tag] = $counter;
        if ($i++ >= $number_of_top_tags) {
            break;
        }
    }
    $v_array = $t_array;
    $xml_filename = get_xml_file_name($album, "/" . $file_prefix, $file_prefix);
    // we go one step higher!!
    // $album = substr($dir, 0, strrpos ($album, "/"));
    // we save the whole array!
    $xml_file = fopen($xml_filename, 'w');
    fputs($xml_file, '<' . "?xml version='1.0'?" . "><BESCHREIBUNG>\n");
    foreach ($v_array as $tag => $counter) {
        $xml_string = "<BILD><NAME>" . urlencode($tag) . "</NAME><WERT>" . $counter . "</WERT></BILD>\n";
        fputs($xml_file, $xml_string);
    }
    fputs($xml_file, "</BESCHREIBUNG>");
    fclose($xml_file);
    clearstatcache();
    if (function_exists('get_view_dirs')) { // This is not done during batch upload.
        create_top_tags($album);
    }
}

/*
We create an array of the topx tags!
*/
function create_top_tags($album_url)
{
    global $basedir, $number_of_top_tags, $privatelogin, $cache_dirs;
    $key = $privatelogin . '/' . $album_url;

    if ($cache_dirs && isset($_SESSION['TWG_TT']) && isset($_SESSION['TWG_TT'][$key])) {
        return $_SESSION['TWG_TT'][$key];
    }
    if ($album_url) {
        $dirs = get_view_dirs($basedir . "/" . $album_url, $privatelogin);
    } else {
        $dirs = get_view_dirs($basedir, $privatelogin);
    }

    $v_array = array();

    foreach ($dirs as $album) {
        $xml_filename = get_xml_file_name($album, "/_top_tag.xml", "_top_tag.xml");
        if (file_exists($xml_filename)) {
            $xml_data = readXMLFile($xml_filename, "create_top_tags");
            $werte = $xml_data[0];
            $index = $xml_data[1];
            $i = 0;
            if (isset($index["NAME"])) {
                foreach ($index["NAME"] as $band) {
                    $tag = $werte[$band]["value"];
                    $wert = $werte[$index["WERT"][$i]]["value"];
                    $v_array = countTags($v_array, $tag, $wert);
                    $i++;
                }
            }
        }
    }
    $t_array = array();
    arsort($v_array, SORT_NUMERIC);
    reset($v_array);
    foreach ($v_array as $tag => $counter) {
        $t_array[$tag] = $counter;
        if ($i++ >= $number_of_top_tags) {
            break;
        }
    }
    $v_array = $t_array;
    if ($cache_dirs) {
        if (!isset($_SESSION['TWG_TT'])) {
            $_SESSION['TWG_TT'] = array();
        }
        $_SESSION['TWG_TT'][$key] = $v_array;
    }
    // here we save it later to disk as well!
    return $v_array;
}

function search_tags($dirs, $searchstring, $exact = false)
{
    global $xmldir, $charset, $install_dir, $twg_standalone;
    global $basedir, $store_xml_in_picfolders, $charset;
    global $skip_thumbnail_page, $auto_skip_thumbnail_page, $numberofpics;
    global $install_dir_view;

    $numberpics = $numberofpics * 2 + 1;
    $auto_skip_thumbnail_page = true;

    $type = "WERT";

    $topx = array();
    $topxalb = array();

    if ($searchstring == "") {
        return $topx;
    }

    for ($ii = 0; $ii < count($dirs); $ii++) {
        $returncount = 1;
        $xml_filename = get_xml_file_name($dirs[$ii], "/_tags.xml", "_tags.xml");
        if (file_exists($xml_filename)) {
            $xml_data = readXMLFile($xml_filename, "searchTags");
            $werte = $xml_data[0];
            $index = $xml_data[1];
            $i = 0;
            $map = array();
            foreach ($index["NAME"] as $band) {
                $isdirtag = false;
                $imageName = $werte[$band]["value"];
                if (isset($werte[$index["WERT"][$i]]["value"])) { // dirtags can be empty!
                    $line = urldecode($werte[$index["WERT"][$i]]["value"]);
                } else {
                    $i++;
                    continue;
                }
                $i++;
                if (!(trim($line) == "")) {
                    $datum = ""; // we want to have the same display for all results - therefore some dummys here!
                    $name = $line;
                    $comment = "";

                    if ($exact) {
                        $tags_array = explode(",", html_entity_decode_fixed($name, ENT_COMPAT, $charset));
                        $res = in_array(html_entity_decode_fixed($searchstring, ENT_COMPAT, $charset), $tags_array);
                    } else {
                        $res = stristr(html_entity_decode_fixed($name, ENT_COMPAT, $charset), html_entity_decode_fixed($searchstring, ENT_COMPAT, $charset));
                    }

                    if ($res) {
                        if ($imageName == "dir") { // this is a dir tag - we show a link to the folder
                            $isdirtag = true;
                        }
                        $name = replacesmilies($name);
                        $name = str_replace(",", ", ", $name);
                        $komment = htmlentities($dirs[$ii], ENT_QUOTES, $charset);

                        $line = $datum . "=||=" . $name . "=||=" . $komment;

                        $remote_image = twg_checkurl($basedir . "/" . $dirs[$ii]);
                        if ($remote_image) {
                            $remote_image_exists = in_array(urldecode($imageName), get_image_list($dirs[$ii]));
                        } else {
                            $remote_image_exists = false;
                        }

                        if (file_exists($basedir . "/" . $dirs[$ii] . "/" . urldecode($imageName)) || $remote_image_exists || $isdirtag) {
                            // the decode at the end is important - if you remove them images with hard filenames are not displayed :).
                            if ($isdirtag) {
                                $addon = "";
                                if ($skip_thumbnail_page) {
                                    $addon = "&amp;twg_show=x";
                                } else if ($auto_skip_thumbnail_page) {
                                    $counter = get_image_count($dirs[$ii]);
                                    if ($counter <= $numberpics) {
                                        $addon = "&amp;twg_show=x";
                                    }
                                }
                                $compare = $line . "=||=" . $install_dir_view . "image.php?twg_album=" . urlencode($dirs[$ii]) . "&amp;twg_type=isalbum" . $twg_standalone . $addon;
                                $topxalb[] = $compare;
                            } else {
                                $compare = $line . "=||=" . $install_dir_view . "image.php?twg_album=" . urlencode($dirs[$ii]) . "&amp;twg_type=thumb&amp;twg_show=" . $imageName . $twg_standalone;
                                $topx[] = $compare;
                            }
                        }
                    }
                }
            }
        }
    }
    $topx = array_merge($topxalb, $topx);
    return $topx;
}

?>