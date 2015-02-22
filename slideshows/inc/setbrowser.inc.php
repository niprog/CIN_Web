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

$msie = true;
$opera = false;
$wii = false;
$isns = false;
$safari = false;
$iswindowsServer = false;
$isMac = false;
$opera7 = false;
$twg_mobile = false;
$isIpad = false;
$isIphone = false;
$isTablet = false;
 
if (isset($_SERVER['HTTP_USER_AGENT'])) {

    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    $msie = strstr($ua, 'msie') || strstr($ua, 'trident');
    $opera = strstr($ua, 'opera');
    $isns = strstr($ua, 'mozilla') && (!(strstr($ua, 'compatible')));
    $safari = strstr($ua, 'safari');
    $wii = strstr($ua, 'wii');
    $iswindowsServer = stristr(PHP_OS, 'win');
    $iswindows = strstr($ua, 'win');
    $isMac = strstr($ua, 'mac');
    $opera7 = strstr($ua, 'opera/7');
    $isIpad = strstr($ua, 'ipad');
    $isIphone = strstr($ua, 'iphone');
   
    if (version_compare(phpversion(), '5.1.1', '>=')) {  
        require_once dirname(__FILE__) . '/Mobile_Detect.php';
        $detect = new Mobile_Detect;
        $twg_mobile = $detect->isMobile();
        $isTablet = $detect->isTablet();
        if ($msie) {
           $version = $detect->version('Trident');
           // if 10 oder > 
           if ($version && version_compare($version, '6.0') >= 0) {
              $use_ie_compability_mode=false;
        }
        }
        
    } else {           
        if ($msie) {
           $responsive_main_page = false;
           $responsive_thumb_page = false;
           $responsive_detail_page = false;
        }
        
        $isTablet = $isIpad;
        // we check if a mobile device is using TWG and we remove some stuff.
        $twg_mobile = $enable_mobile_detection && (strstr($ua, 'windows ce') || strstr($ua, 'iphone') || strstr($ua, 'symbian') || 
            strstr($ua, 'opera mini') || strstr($ua, 'up.browser') || strstr($ua, 'opera mobi') || 
            strstr($ua, 'blackberry') || strstr($ua, 'nokia') || strstr($ua, 'sonyericsson') || strstr($ua, 'android')); 
    }                              
}
?>