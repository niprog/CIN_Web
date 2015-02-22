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

defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
ob_start();
$iframe_base = $basedir;

// we load the config's - should be extracted to another file!
$configphp = $basedir . "/" . $twg_album . "/config.php";
if (file_exists($configphp)){
     $basedir = $basedir_save;
     include $configphp;
     $basedir = $iframe_base;
} 
$configphp_lang = $basedir . "/" . $twg_album . "/config_".$default_language.".php";
if (file_exists($configphp_lang)){
     $basedir = $basedir_save;
     include $configphp_lang;
     $basedir = $iframe_base;
}

require '../language/language_default.php';
require '../language/language_' . $default_language . '.php';
@ob_end_clean();
if (isset($charset)) {
 	header("Content-Type: text/html;charset=" . $charset);
} 	
echo '<?xml version="1.0" ?>';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TinyWebGallery</title>
<meta name="ROBOTS" content="NOINDEX">
<meta name="author" content="www.tinywebgallery.com" />
<?php
if (isset($charset)) {
 	echo '<meta http-equiv="Content-Type" content="text/html; charset=' . $charset . '" />';
  }
// include "i_extra.inc.php";
// printStyleSheet();
?>
<link rel="stylesheet" type="text/css" href="iframe-min.css" />
<script type="text/javaScript">reload = false;</script>
<script type="text/javaScript" src="../js/twg_image-min.js"></script>
<?php 
include "i_key.inc.php";
include "i_moofx.inc.php";
?>
</head>