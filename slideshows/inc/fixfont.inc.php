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

$lang_height_comment = ceil($fontscale * $lang_height_comment);
$lang_height_caption = ceil($fontscale * $lang_height_caption);
$lang_height_login = ceil($fontscale * $lang_height_login);
$lang_height_private = ceil($fontscale * $lang_height_private);
$lang_height_options = ceil($fontscale * $lang_height_options);
$lang_height_email_user = ceil($fontscale * $lang_height_email_user);
$lang_height_info = ceil($fontscale * $lang_height_info);
$lang_height_rating = ceil($fontscale * $lang_height_rating);
$lang_height_dl_manager = ceil($fontscale * $lang_height_dl_manager);
$lang_height_search = ceil($fontscale * $lang_height_search);

if ($fontscale > 1) {
    $detailswidth = ceil($fontscale * 1.1 * $detailswidth);
}

?>