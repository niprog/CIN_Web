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
 
  $Date: 2007-02-02 11:11:13 +0100 (Fr, 02 Feb 2007) $
  $Revision: 39 $
**********************************************/

defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );

$charset='UTF-8'; // default charset.

include_once '../inc/filefunctions.inc.php';
checkXSS();
include_once '../inc/startsession.inc.php';
ob_start();
include '../config.php';
ob_end_clean();

// needed if in the custom config is a variable that changes this!
$basedir_save = $basedir;

$xmldir = '../' . $xmldir;
$basedir = '../' . $basedir;
$cachedir = '../' . $cachedir;
$counterdir = '../' . $counterdir;
$install_dir_save = $install_dir;
$install_dir = '../'. $install_dir;
       
include 'i_parserequest.inc.php';
include '../inc/mysession.inc.php';
include '../inc/setspecials.inc.php';

if ($input_invalid) {
  printErrorInvalid();
  die();
}
  
// is the session is not working properly the $config_twg_root variable can be 
// set to enable at least the slideshows
if (isset($config_twg_root) && $config_twg_root != '') {
    $twg_root = $config_twg_root;
}

?>