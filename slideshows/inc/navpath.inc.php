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

$show_up_button = false;

$thumbclass = '';
$thumbclass_middle = '';
if ($image == false && $twg_album) {
    $thumbclass = ' thumb-header'; 
    $thumbclass_middle = ' thumb-header-middle';  
}

echo '<td class="topnavleft' . $thumbclass . ($hide_top ? ' hide' : '') . '">';
echo "<div class='higher_div'>";
$printHome = writeRootLink($install_dir);
if (!$printHome) {
    if (!$twg_album) {
        $printHome = writeRootLink($basedir);
    }
}

$twg_foffset_arr = explode(",", $twg_foffset);
$printRoot = true;
$show_up_button = true;

$fullpath = "";

if ($twg_album) {
    $path = explode("/", $twg_album);
    $nr_count = count($path);
    $actpath = "";
    reset($path);
    for ($nr_act_count = 0; $nr_act_count < $nr_count; $nr_act_count++) {
        $element = array_pop($path);
        // echo ":" . $element . ":";
        if ($nr_act_count == 0 && $skip_thumbnail_page_dummy) {
            $dirname = $basedir . "/" . $twg_album;
            $val = remove_br(getDirectoryName($dirname, $element));
            $fullpath .= $val;
            if (hasRootLink($dirname)) {
                if (!$printHome) {
                    writeRootLink($dirname);
                }
                $printRoot = false;
                if (!$top10) {
                    $show_up_button = false;
                }
            }
        } else {
            if ($nr_act_count < $nr_count - 1) {
                $actpath = implode("/", $path) . "/" . $element;
            } else {
                $actpath = $element;
            }
            $has_root_link = hasRootLink($basedir . "/" . $actpath);
            if ($printRoot) {
                $show_up_button = true;
                $rem_path = implode(",", array_slice($twg_foffset_arr, 0, $nr_count - $nr_act_count + 1));
                $val = remove_br(getDirectoryName($basedir . "/" . $actpath, $element));
                if ($rem_path != "" && $rem_path != '0' && $rem_path != '0,0') { //
                    $fof = "&amp;twg_foffset=" . $rem_path;
                } else {
                    $fof = '';
                }
                $breadc_href = getScriptName() . "?twg_album=" . urlencode($actpath) . $fof . $twg_standalone;
                $cpath = "<span class='twg_bold'><a href='" . tfu_seo_rewrite_url($breadc_href) . "'";
                if ($hide_middle_folders_in_breadcrumb && $nr_count > $nr_act_count && !$has_root_link && $nr_act_count >= 1) {
                    $cpath .= "title=\"" . $val . "\"" . ">...";
                } else {
                    $cpath .= ">" . $val;
                }
                $cpath .= '</a></span> > ';
                $fullpath = $cpath . $fullpath;
            }
            if ($has_root_link) {
                if (!$printHome) {
                    writeRootLink($basedir . "/" . $actpath);
                }
                $printRoot = false;
            }
        }
    }
}

if ($show_breadcrumb) {
    if ($printRoot) {
        echo "<a href='" . getScriptName();

        if ($twg_foffset_arr[0] != 0) {
            echo "?twg_foffset=" . $twg_foffset_arr[0];
        }
        if ($twg_standalone != '') {
            echo '?';
        }
        echo $twg_standalone . "'  >";
        echo "<span class='twg_bold'>" . $lang_galleries . "</span></a>";
        if ($twg_album || $image) {
            echo " > ";
        }
    }
    echo $fullpath;
} else {
    echo ""; // &nbsp;
}
?>