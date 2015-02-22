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

function printStyleSheet() {
  global $default_language;
  echo '<link rel="stylesheet" type="text/css" href="iframe.css" />';
  /* if you need language dependant style sheets ...
  $cssname = "../language/language_" . $default_language . "_iframe.css";
  if (file_exists($cssname)) {
    echo '<link rel="stylesheet" type="text/css" href="' . $cssname . '" />';
  }
  */
}
?>