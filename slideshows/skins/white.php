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

/* 
		Some visualisation stuff! 
		THIS IS NOT FOR SETTING THE BACKGROUND OF THE PAGE - check the my_style.css for this!
		Here you set colors which are used as background for genereated images. e.g. the slideshow
		where borders have to be added!

    If you have a background image the optimized slideshow background will have a plain color!
    please pick a color that fits best to your background or disable this slideshow type
*/
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );

$slideshow_backcolor_R = 241;  // for the slideshow are images created which are $small_pic_size x $small_pic_size
$slideshow_backcolor_G = 241;  // therefore we need a background color that has to match the color in the style sheet (see the comment there)
$slideshow_backcolor_B = 241;  // default is white - the values are the RGB values in decimals!
	$comment_corner_backcolor_R = 241; // new 1.2 this are the colors of the comment corner (RGB value in decimal)
	$comment_corner_backcolor_G = 241;
	$comment_corner_backcolor_B = 241;

$flash_nav_reflection_bg_color='FFFFFF';

$thumb_cellpadding = 0;   
$thumb_cellspacing = 6;  

?>