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

echo '<script type="text/javaScript" src="' . $install_dir_view . './js/twg_mydrag.js"></script>';

$current_id = get_image_number($twg_album, $image_enc);
$image_count = get_image_count($twg_album);

increaseImageCount($twg_album, $image); // we don't show this value - but we increase !
$bildtext = $lang_picture . ' ' . ($current_id + 1) . ' ' . $lang_of . ' ' . $image_count;
$twg_offset = get_twg_offset($twg_album, $image, $current_id);

echo '<div onmouseover="javascript:setTimer(400);" onmousedown=dragstart(this); onmouseout="javascript:setTimer(10);"  class="twg_fullscreencontrol" ' . (($twg_mobile || $isIpad) ? ' style="width:280px;"' : '') . ' id="twg_fullscreencontrol">';

if (!$twg_mobile && !$isIpad) {
    echo '<table class="twg_centertable" summary="" cellpadding="0" width=100% cellspacing="0"><tr><td class=twg><img id="closebutton" class="twg_hand" onclick="javascript:closeFullscreen();" alt="' . $lang_close_fullscreen . '" title="' . $lang_close_fullscreen . '"  onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'closebutton\',\'\',\'' . $install_dir_view . 'buttons/close_over.gif\',1)"  align=right src="' . $install_dir_view . 'buttons/close.gif" >';
}
echo '<img alt=""  width=5 height=5 src="' . $install_dir_view . 'buttons/1x1.gif" ><br>';
echo '<div id="twg_contol_text" class="twg_contol_text">' . $bildtext . '</div></td></tr><tr><td class=twg>';
if ($show_first_last_buttons) {
    echo '<a href="#"><img class="fs_sprites menu_first_full_gif twg_hand" id="firstbutton" alt="' . $lang_first . '"  title="' . $lang_first . '"  src="' . $install_dir_view . 'buttons/1x1.gif" onclick="javascript:changeContent(-100000); return false;" ></a>&nbsp;';
}
echo '<a href="#"><img ';
if ($current_id == 0) {
    echo ' style="visibility:hidden;" ';
}
echo ' class="fs_sprites menu_left_full_gif twg_hand" id="backbutton" alt="' . $lang_back . '" title="' . $lang_back . '" src="' . $install_dir_view . 'buttons/1x1.gif" onclick="javascript:changeContent(-1); return false;" ></a>&nbsp;';
echo '<a href="#"><img ';
if ($current_id == ($image_count - 1)) {
    echo ' style="visibility:hidden;" ';
}
echo ' class="fs_sprites menu_right_full_gif twg_hand" id="nextbutton" alt="' . $lang_forward . '" title="' . $lang_forward . '" src="' . $install_dir_view . 'buttons/1x1.gif" onclick="javascript:changeContent(1);return false;" ></a>&nbsp;';
if ($show_first_last_buttons) {
    echo '<a href="#"><img class="fs_sprites menu_last_full_gif twg_hand" id="lastbutton" alt="' . $lang_last . '" title="' . $lang_last . '" src="' . $install_dir_view . 'buttons/1x1.gif" onclick="javascript:changeContent(100000);return false;" ></a>&nbsp;';
}
if ($show_slideshow) {
    echo '<img alt=""  width=5 src="' . $install_dir_view . 'buttons/1x1.gif" >';
    echo '<span id="slideshowarea"><a href="#"><img class="fs_sprites menu_start_full_gif twg_hand" id="slideshowbutton" alt="' . $lang_start_slideshow . '" title="' . $lang_start_slideshow . '" onclick="javascript:startSlideshow(); return false;" src="' . $install_dir_view . 'buttons/1x1.gif" ></a></span>';
}
if ($twg_mobile || $isIpad) {
    echo '<img alt=""  width=10 src="' . $install_dir_view . 'buttons/1x1.gif" >';
    echo '<span id="slideshowarea"><a href="#"><img class="fs_sprites menu_close_full_gif twg_hand" id="slideshowbutton" alt="' . $lang_close_fullscreen . '" title="' . $lang_close_fullscreen . '" onclick="javascript:closeFullscreen(); return false;" src="' . $install_dir_view . 'buttons/1x1.gif" ></a></span>';
}

echo '</td></tr></table></div>';
// echo '<script type="text/javascript">SET_DHTML("twg_fullscreencontrol"); </script>';
if ($show_caption_at_maximized_view) {
    echo '<div id="twg_fullscreencaption" class="twg_fullscreencaption">' . getBeschreibung($image, $werte, $index) . '</div>';
}

?>