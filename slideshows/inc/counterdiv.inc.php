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

if ($generatecounter || (!file_exists($cachedir . '/counter.png'))) {
    $counterimage = $install_dir_view . 'image.php?twg_type=counterimage';
    echo "<script type='text/javascript'> MM_preloadImages('" . $counterimage . "');</script>";
    $enable_counter_details = false; // when the history image is created it cannot be displayed
}
echo '
		<script type="text/javascript">';

/*
if ($disable_frame_adjustment_ie && (!$msie || $opera)) {
	echo 'enable_adjust_iframe();';
}
*/

$i_offset = '';
if (!$disable_frame_adjustment_ie) {
    echo 'enable_adjust_iframe();';
} else {
    $i_offset = ($php_include) ? '' : ' style="bottom:30px;"';
}
echo '</script>';
if ($enable_counter_details && file_exists($cachedir . '/counter.png')) {
    $counter_view = tfu_get_view_dir($cachedir);
    echo '
		<div id="twg_counterdiv"' . $i_offset . '><table class="twg" summary=""><tr><td
		class="twg_counterdivtext"><img style="padding:0;margin:0;" src="' . $counter_view . '/counter.png" alt="" height="70" width="138"></td></tr><tr><td
		class="twg_counterdivtext">' . $lang_visitor_30 . '</td></tr></table></div>';
}

?>