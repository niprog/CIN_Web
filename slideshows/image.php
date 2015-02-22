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

define('_VALID_TWG', '42');

// I check if there is at least one parameter!
if (count($_GET) == 0) {
    echo 'Parameters needed';
    exit;
}
ob_start();

// functions like getLast, getFirst, debug, gdversion  ...
include dirname(__FILE__) . '/inc/filefunctions.inc.php';
include dirname(__FILE__) . '/inc/startsession.inc.php';
require dirname(__FILE__) . '/config.php';
include dirname(__FILE__) . '/inc/imagefunctions.inc.php';
// needed to check if rotation was performed !!
include dirname(__FILE__) . '/inc/parserequestimage.inc.php';
include dirname(__FILE__) . '/inc/mysession.inc.php';

if ($print_memory_usage) debug("image.php - mem - start(" . $image . ") : " . get_mem());

checkXSS();

set_error_handler('on_error_no_output');
ini_set('gd.jpeg_ignore_warning', 1); // since php 5.1.3 this leads that corrupt jpgs are read much better!
set_error_handler('on_error');


$install_dir_save = $install_dir; // needed for rating buttons!
$install_dir = ''; // this file is not located somewhere else!
$modifyheader = false;
include dirname(__FILE__) . '/inc/loadconfig.inc.php';

/*
based on the code of Rainer Hungershausen - thanks for the good work.
*/

if (($image != false && $type != 'png') || $dataXmlHttp || $precachexml) {
    require dirname(__FILE__) . '/language/language_default.php';
    require dirname(__FILE__) . '/language/language_' . $default_language . '.php';
    include dirname(__FILE__) . '/inc/readxml.inc.php';
}

$twg_rot_available = checktwg_rot();
if (!$twg_rot_available) {
    $autorotate_images = '';
}

@ob_end_clean();

if ($dataXmlHttp || $browserXmlHttp || $browserNoJS || $precachexml || $menuXmlHttp || $menuXmlAutohide) {
     if ($debug_time) {
         $timestart = microtime();
         debug("start ajax: " . $dataXmlHttp ."-". $browserXmlHttp ."_". $browserNoJS ."x". $precachexml ."y".$menuXmlHttp);
     }
     include dirname(__FILE__) . '/inc/ajaxserver.inc.php';
     if ($debug_time) {
         $timeused = microtime() - $timestart;
         debug("end ajax: " . $timeused);
     }
    
   
} else if ($image != false && $type != 'png') {
    if (!isset($_SESSION['twg_admin_logged_in'])) {
        include dirname(__FILE__) . '/inc/checkprivate.inc.php';
    } else {
        $privategal = false;
    }
    // check if private
    if ($privategal && !in_array($privatelogin, $passwd)) {
        putimage(dirname(__FILE__) . '/buttons/lock.gif');
    } else {
        include dirname(__FILE__) . '/inc/imagecreate.inc.php';
    }
} else if ($type == 'counterimage') {
    $filename = $counterdir . '/user_log.txt';
    generatecounterimage($filename);
} else if ($type == 'png') {
    $filename = $basedir . '/' . $twg_album . '/' . $image;
    if (file_exists($filename)) {
        putpngimage($filename);
    }
} else if ($type == 'random' || $type == 'top') {
    include dirname(__FILE__) . '/inc/random.inc.php';
}
if ($print_memory_usage) debug("image.php - mem - finish(" . $image . ") : " . get_mem());


?>
