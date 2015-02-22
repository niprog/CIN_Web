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
/* not tips for the topx yet - if this page has more stuff like rating ... this will come */


/* image view */
if ($image && $twg_album && !$top10) {
    print_tips($show_tips_image && (!($enable_dir_description_on_image && $default_is_fullscreen)),
        $show_tips_image_once, "twg_show_tips_image", $lang_tips_image[array_rand($lang_tips_image)]);
}
/* thumb view */
if (!$image && $twg_album && !$top10) {
    print_tips($show_tips_thumb, $show_tips_thumb_once, "twg_show_tips_thumb", $lang_tips_thumb[array_rand($lang_tips_thumb)]);
}
/* overview */
if (!$image && !$twg_album && !$top10) {
    print_tips($show_tips_overview, $show_tips_overview_once, "twg_show_tips_overview", $lang_tips_overview[array_rand($lang_tips_overview)]);
}

function print_tips($show_tips, $show_tips_once, $show_tips_once_ses, $tip)
{
    global $disable_tips;
    $show_help = true;
    if (!$disable_tips && $show_tips) {
        if ($show_tips_once) { // we check if we have shown it already in this session
            if (isset($_SESSION[$show_tips_once_ses])) {
                $show_help = false;
            } else {
                $_SESSION[$show_tips_once_ses] = "TRUE";
            }
        }
        if ($show_help) {
            echo '<tr>
							<td class="twg_user_help_td">
							' . $tip . '
							</td>
							</tr>
							';
        }
    }
}

?>