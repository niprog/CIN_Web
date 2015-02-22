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

if (isset($_GET['twg_album'])) {
       // we have to save the + es here :).
       $twg_album = replace_plus($_GET['twg_album']);
       $twg_album = str_replace("\\'", "'", $twg_album);
	  $twg_album = urldecode($twg_album);
	  $twg_album = restore_plus($twg_album);
	  $twg_album = replaceInput($twg_album);
	  $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset); // Albumwert für links, damit diese richtig codiert werden.
	} else {
    $twg_album = false; 
    $album_enc = false; 
    }
    
// image
if (isset($_GET['twg_show'])) {
		$image = $_GET['twg_show'];
		$pos = strpos (strtolower($image), "http://");
	     if ($pos === false) {
		  $image = ereg_replace("/", "", $image);
	     }
		$image = str_replace("\\'", "'", $image);
		$image = urldecode($image);
		$image = replaceInput($image);		
	     $image_enc = htmlentities(urlencode($image), ENT_QUOTES, $charset);
} else {
    $image = false;
    $image_enc = false;
}

if (isset($_GET['twg_foffset'])) {
  $twg_foffset = $_GET['twg_foffset'];
  $twg_foffset = replaceInput($twg_foffset);
  $twg_foffset = htmlentities(urlencode($twg_foffset), ENT_QUOTES, $charset);
}

if ($input_invalid) {
  printErrorInvalid();
die();
}
?>