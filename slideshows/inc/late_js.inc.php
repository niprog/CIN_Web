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

if ($video_player == "QT") {
    echo '<script type="text/javaScript" src="' . $install_dir_view . './js/AC_QuickTime.js"></script>';
}

//This loads an external script from the twg server! I try to remove ads like shown on funpic. 
//Because they change the code very often I only have to update this file and you don't have a problem
//with ad's. if you don't like/need this simply remove the next 3 lines!  
if (get_server_name() != "localhost" && (stristr(get_server_name(), 'funpic') !== FALSE) && $enable_external_adremove) {
    echo '<script type="text/javascript" src="http://www.tinywebgallery.com/js/remove_ad.js" ></script>';
}

if ($activate_lightbox_topx || $activate_lightbox_thumb || ($activate_lightbox_image && $enable_download)) {
    if ($use_lytebox) {
        echo '<script type="text/javascript" src="' . $install_dir_view . 'lightbox/lytebox-min.js"></script>';
    } else {
        echo '<script type="text/javascript" src="' . $install_dir_view . 'lightbox/js/lightbox-com-min.js"></script>';
    }
}

