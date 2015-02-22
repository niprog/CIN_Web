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
/* not tips for the topx yet - if this page has more stuff like rating ... this will come */
function include_htm($filename, $styleclass, $local = false)
{
    global $basedir, $twg_album, $default_language;
    if ($local) {
        $path = dirname(__FILE__) . "/../" . $basedir . "/" . $twg_album . "/";
    } else {
        $path = dirname(__FILE__) . "/../";
    }

    $html = $path . $filename . "_" . $default_language . ".htm";
    if (file_exists($html)) {
        echo "<tr><td class='" . $styleclass . "'>";
        include ($html);
        echo "</td></tr>";
        return true;
    } else {
        $html = $path . $filename . ".htm";
        if (file_exists($html)) {
            echo "<tr><td class='" . $styleclass . "'>";
            include ($html);
            echo "</td></tr>";
            return true;
        }
    }
    return false;
}

if ($enable_external_html_include) {
    /* image view */
    if ($image && !$top10) {
        include_htm("image", "twg_imagehtml");
    }

    /* thumb view */
    if (!$image && $twg_album && !$top10) {
        if (!include_htm("thumb", "twg_thumbhtml", true)) {
            include_htm("thumb", "twg_thumbhtml");
        }
    }

    /* overview */
    if (!$image && !$twg_album && !$top10) {
        include_htm("overview", "twg_overviewhtml");
    }

    /* topx */
    if ($top10) {
        include_htm("topx", "twg_overviewhtml");
    }


}
?>