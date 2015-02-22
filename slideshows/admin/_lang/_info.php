<?php
/*************************  
  Copyright (c) 2004-2014 TinyWebGallery
  written by Michael Dempfle
 
  This program is free software; you can redistribute it and/or modify 
  it under the terms of the TinyWebGallery license (based on the GNU  
  General Public License as published by the Free Software Foundation;  
  either version 2 of the License, or (at your option) any later version. 
  See license.txt for details.
 
  TWG Admin version: 2.2

  $Date: 2009-06-17 22:57:10 +0200 (Mi, 17 Jun 2009) $
  $Revision: 73 $
**********************************************/
function makeOption($lang, $description) {
  if (isset($GLOBALS["lang"])) {
    $deflang = $GLOBALS["lang"];
  } else {
    $deflang = $GLOBALS["default_language"];
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
      if (file_exists(dirname(__FILE__) .  "/".$lang_browser.".php")) {
        $deflang = $lang_browser;
      }
    }
  }
  
  if (file_exists( dirname(__FILE__) .  "/".$lang.".php")) {
	  echo "<OPTION ";
	  if ($deflang == $lang) { 
	    echo " selected ";
	  }
	  echo " value=\"".$lang."\">".$description."</OPTION>";
  }

}
makeOption("en","English");
makeOption("de","Deutsch");
makeOption("es","Espa&ntilde;ol");
makeOption("fr","Fran&ccedil;ais");
makeOption("nl","Nederlands");
makeOption("it","Italian");
makeOption("da","Danish");
?>