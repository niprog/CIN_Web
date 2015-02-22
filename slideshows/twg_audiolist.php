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

   $xmlfilename = "cache/audiolist.xml";
   
   header("Pragma: public");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Cache-Control: public"); 
   
   if (file_exists($xmlfilename)) {
      $fp = fopen($xmlfilename, "r");
	  	while ($content = fread($fp, 8192)){
	 		  print $content;
	 	  }
	    fclose($fp); 
	 }  
?>