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

if (isset($_GET['twg_delcomment'])) {
    if ($login_edit || $login_backend) {
        $allow_delete = true;
        $twg_delcomment = $_GET['twg_delcomment'];
        $twg_delcomment = stripslashes($twg_delcomment);
        // check the login
        if ($enable_comments_only_registered && !$login_backend) {
            $delcom = explode("=||=", $twg_delcomment);
            if ((!isset($_SESSION["s_user"]) || ($delcom[1] != $_SESSION["s_user"]))) {
                $allow_delete = false;
            }
        }
        if ($allow_delete) {
            deleteKommentar($twg_delcomment, $twg_album, $image, $kwerte, $kindex);
            delete_comment_cache("");
        } else {
            tfu_debug("Someone tried to delete a comment without the needed permissions.");
        }
    }
}
?>