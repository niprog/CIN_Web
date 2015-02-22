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

// This file does right now only process 1 Ajay call. 
// from release to release I want to move the whole
// Ajax stuff from image.php to this file.

define( '_VALID_TWG', '42' );

include dirname(__FILE__) . '/inc/filefunctions.inc.php';
include dirname(__FILE__) . '/inc/startsession.inc.php';
require dirname(__FILE__) . '/config.php';
include dirname(__FILE__) . '/inc/mysession.inc.php';
require dirname(__FILE__) . '/inc/loadconfig.inc.php';

checkXSS();
// I check if there is at least one parameter!
if (count($_GET) == 0) {
 echo 'Parameters needed';
 exit;
}

// we return the xml file for the current folder of the session
if (isset($_GET['twg_flash_xml'])) {
  header('Cache-Control: cache, must-revalidate');
  header('Pragma: public');
  // get dir from Session
  if (isset($_SESSION['TWG_CURRENT_DIR']) || isset($_GET['twg_external_album'])) {
    $external = false;
    
    
    if (isset($_SESSION['TWG_CURRENT_DIR'])) {
      $twg_album = $_SESSION['TWG_CURRENT_DIR'];
    } else {
      $twg_album = replace_plus($_GET['twg_external_album']);
	    $twg_album = str_replace("\\'", "'", $twg_album);
	    $twg_album = urldecode($twg_album); // the double decode is because of some servers where this is needed!
	    $twg_album = restore_plus($twg_album);
	    $twg_album = replaceInput($twg_album);
	    
      if (startsWith($twg_album,'TWG_')) {
          $twg_album = substr($twg_album, 4); 
          $external = false;
      }else {
          $external = true;
      }
    }
    $images = get_image_list($twg_album);
    echo create_flash_xml($twg_album, $images, $external);
  } else {
    // please reload image!
    echo '<a><b><c>'.$install_dir.'buttons/reload.png</c><d></d></b></a>';
  }
}


?>
