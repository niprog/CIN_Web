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

$make_link = ($enable_rating_only_registered && $login_edit) || ($enable_rating_only_registered && isset($_SESSION['s_user'])) || !$enable_rating_only_registered;
$rating = substr(getVotesCount($twg_album, urldecode($image)), 0, 4);
$rating = round($rating * 20);

echo '<center id="center-rating"><table class="twg" summary=""><tr><td class=twg_rating_text>' . $lang_rating . ': ';
echo '</td><td class=twg style="padding-left:5px">';
echo '

<div class="twg-inline-rating">

  <ul class="twg-rating">
    <li id="ratingcur" class="current-rating" style="width:' . $rating . '%;"></li>
';
if ($make_link) {
    $ratelink_new = "onclick='return twg_showSec(" . $lang_height_rating . ")' target='details' href='" . $install_dir_view . "i_frames/i_rate.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone;
    echo '
    <li><a id="ratinglink1" ' . $ratelink_new . '&amp;twg_vote=1\'  title=""  class="one"></a></li>
    <li><a id="ratinglink2" ' . $ratelink_new . '&amp;twg_vote=2\'  title=""  class="two"></a></li>
    <li><a id="ratinglink3" ' . $ratelink_new . '&amp;twg_vote=3\'  title=""  class="three"></a></li>
    <li><a id="ratinglink4" ' . $ratelink_new . '&amp;twg_vote=4\'  title=""  class="four"></a></li>
    <li><a id="ratinglink5" ' . $ratelink_new . '&amp;twg_vote=5\'  title=""  style="text-indent:0px;" class="five"></a><img src="'.$install_dir_view.'buttons/1x1.gif" width="125" height="0" alt=""></li>';
}
echo '
  </ul>
</div>

<div class="twg-clr"></div>
';
echo '</td></tr></table>';
echo '</center>';




?>