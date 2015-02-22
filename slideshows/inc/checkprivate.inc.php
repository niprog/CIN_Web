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
// check if it is a private gallery
$privategal = false;
$passwd = array();

if (!isset($relativepath)) {
    $relativepath = '';
}

$privatefilename = $globalprivatefilename = $relativepath . $basedir;
if ($twg_album) {
    $privatefilename = $relativepath . $basedir . "/" . $twg_album;
}
//if (file_exists($privatefilename)) {

$passwd = read_passwort_file($privatefilename, $globalprivatefilename);
if ($passwd !== false) {
    $privategal = true;
} else {
    unset ($passwd);
}
// }

?>