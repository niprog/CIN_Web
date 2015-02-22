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

if ($multi_root_mode && $multi_root_mode_login != '' && $twg_album) {
    // we check if we are in the right directory

    if (!isset($_SESSION[$multi_root_mode_login]) && $multi_root_mode_permissions == '') {
        $root_mode_no_login = true;
    } else if ($multi_root_mode_permissions == '') {
        $elements = explode("/", $twg_album);
        $root_mode_no_login = $_SESSION[$multi_root_mode_login] != $elements[0];
    } else if ($multi_root_mode_permissions == 'upload' || $multi_root_mode_permissions == 'edit') {
        // we enable the upload
        $elements = explode("/", $twg_album);
        if ($_SESSION[$multi_root_mode_login] == $elements[0]) {
            $_SESSION['s_home_dir'] = $elements[0]; // home dirs of frontend users can have more than one folder seperated by |
            $_SESSION['twg_permissions'] = 0;
            $_SESSION['mywebgallerie_login'] = 'true';
            if (is_subdir($elements[0], $basedir . '/' . $twg_album)) { // we are in the dir or a subdir !
                $login_edit = true; // we can edit if we are in a subdir
                if ($multi_root_mode_permissions == 'upload') {
                    $_SESSION['twg_permissions'] = 1;
                    $login_upload = true;
                }
            }
        }
    } else {
        die('Wrong setting in multi_root_mode_permissions');
    }
}
?>