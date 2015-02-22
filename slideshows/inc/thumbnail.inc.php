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
 
$Date: 2007-05-17 01:16:29 +0200 (Do, 17 Mai 2007) $
$Revision: 56 $
 **********************************************/

defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');
// This block is used a couple of times - because of perfomance issues it is used 3 times - belive it or not but the performance is ~ 20%
$ccount = getKommentarCount($imagelist[$imageid], $twg_album, $kwerte, $kindex);
$b = $beschreibung = getBeschreibung($imagelist[$imageid], $werte, $index);
if (($beschreibung <> " ") && ($beschreibung <> "")) {
    $beschreibunga = php_to_all_html_chars(escapeHochkomma($beschreibung));
    if ($show_number_of_comments && ($ccount > 0)) {
        $beschreibunga .= ' | ' . $lang_comments . ': ' . $ccount;
    }
    $titel = $beschreibung = 'title="' . $beschreibunga . '"';
    $beschreibung .= ' alt="' . $beschreibunga . '"';
} else if ($ccount > 0) {
    $beschreibunga = $lang_comments . ': ' . $ccount;
    $titel = $beschreibung = 'title="' . $beschreibunga . '"';
    $beschreibung .= ' alt="' . $beschreibunga . '"';
} else {
    $beschreibung = ' alt="" ';
    $titel = '';
}
$href = ' href="' . getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . $twg_standalone . '" ';

$twg_http_root = getTWGHttpRoot($install_dir);
if ($use_original_on_thumbspage) {
    $hreffull = ' href="' . $twg_http_root . 'image.php?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . '" ';
} else {
    $hreffull = ' href="' . $twg_http_root . 'image.php?twg_album=' . $album_enc . '&amp;twg_show=' . $aktimage . '&amp;twg_type=small" ';
}
// end of block

?>