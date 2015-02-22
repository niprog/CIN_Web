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
 
  
  original: 
	  taCs.php - 'the acronym CAPTCHA sucks' - by pete higgins
		a random scalable CAPTCHA image generator, version 0.1.1
		changelog: 0.1.1 added more useful comments
		
  modified by TinyWegGallery - uses random sizes of images now
  
  $Date: 2009-06-17 22:57:10 +0200 (Mi, 17 Jun 2009) $
  $Revision: 73 $
**********************************************/

define( '_VALID_TWG', '42' ); 

define('C_WIDTH',130);    // output width
define('C_HEIGHT',50);     // output height
define('C_CHARS',4);        // number of chars to use
define('C_SPACING',25);     // letter spacing
define('C_BORDER',true);    // border the image?
define('C_GRID',true);        // use a grid overlay?
if (C_GRID) {
  define('GRID_SPACE_ADJ',rand(2,12)); // spacing increment
  define('GRID_SPACEX',4);           // x spacing for grid
  define('GRID_SPACEY',4);         // y spacing for grid
  }
define('MIN_TRANS',75);            // minimun alpha for chars
define('MAX_TRANS',90);         // max alpha for chars
define('SAVE_FILE',false);         // debugging, save output files?

// read from ./images/bgs/, first layer underneat
$nrbg = rand(1,3);
if ($nrbg == 1) {
  $backgrounds = array("bg-1_1.png","bg-1_2.png");
} else if ($nrbg == 2) {
  $backgrounds = array("bg-1_2.png","bg-1_3.png");
} else {
  $backgrounds = array("bg-1_3.png","bg-1_1.png");
}

define('CHEAT',false); // for debugging, shows plaintext letters too
// end config type stuff

// use sessions to hide the 'key' from the user
session_start();

// GD 2.0 making some images WIDTH x HEIGHT
//   and set some color allocations
//
$mycol = rand(240,240);
$im = imagecreatetruecolor(C_WIDTH,C_HEIGHT);
$bor = imagecolorallocate($im,150,150,150);
$bg = imagecolorallocate($im,$mycol,$mycol,$mycol);
$li = imagecolorallocate($im,50,50,50);

imagefilledrectangle($im,0,0,C_WIDTH,C_HEIGHT,$bg);

// background images
//
foreach ($backgrounds as $bgi) {
    // open each, copy to new image resized
    $tmpImg = imagecreatefrompng('../buttons/tacs/bgs/'.$bgi);
    imagecopyresized($im,$tmpImg,0,0,0,0,C_WIDTH,C_HEIGHT,imagesx($tmpImg),imagesy($tmpImg));     
    // don't forget to free the memory.
    imagedestroy($tmpImg);
}

// the captcha letters
//
$nx = 15; $str='';
// reads the dir ./images/chars/ and finds image files, or dies.
if (!$chars = getcatchars()) { die; }  

// each char
for ($i=0; $i<C_CHARS; $i++) {
    // pick random from list of files
    $l = rand(0,sizeof($chars)-1);  
    // load the char image
    $tmpImg = imagecreatefrompng('../buttons/tacs/chars/'.$chars[$l]);
    // add the char part of the filename (first letter)
    // a1.png && a2.png == variations of a and b3.png = b
    $percent = rand(6,8) / 10;
    imagecolortransparent($tmpImg, imagecolorat($tmpImg, 0, 0));
    // Get new dimensions
    $width = imagesx($tmpImg);
    $height = imagesy($tmpImg);
		$new_width = $width  * $percent;
		$new_height = $height * $percent;
		
		
		// Resample
		$image_p = imagecreatetruecolor($new_width, $new_height);
		imagefilledrectangle($image_p,0,0,$new_width,$new_height,$bg);
 
    imagecolortransparent($image_p, imagecolorat($image_p, 0, 0));
    
		imagecopyresampled($image_p, $tmpImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    $str .= $chars[$l]{0};
    // randomly place this char vertically
    $ny = rand(1,17);
    // then copy to im, goto next x position, and free the memory.
    
    imagecopymerge($im,$image_p, $nx,$ny, 0,0, $new_width, $new_height , rand(MIN_TRANS,MAX_TRANS));
    $nx += C_SPACING;
    imagedestroy($tmpImg);
}

// our 'key' is the string of chars we just made.
$_SESSION['twg_key'] = $str;

if (C_GRID) {  /* grid overlay */

// not yet
$x=GRID_SPACEX;
$y=GRID_SPACEY;

// make a new 'grid' image
$imgr = imagecreatetruecolor(C_WIDTH,C_HEIGHT);
$bo = imagecolorallocate($imgr,0,0,0);
$bg = imagecolorallocate($imgr,255,255,255);
imagefilledrectangle($imgr,0,0,C_WIDTH,C_HEIGHT,$bg);

// place a line until the edge of file
while ($x <= C_WIDTH) {
        imageline($imgr, $x, 0, $x, C_HEIGHT, $bo);
    $x+=GRID_SPACEX+GRID_SPACE_ADJ;
     }
// again
while ($y <= C_HEIGHT) {
    imageline($imgr, 0, $y, C_WIDTH,$y, $bo);
    $y+=GRID_SPACEY+GRID_SPACE_ADJ;
}    

// copy 'grid' image on top of the captcha image
imagecopymerge($im,$imgr, 0,0, 0,0,imagesx($imgr),imagesy($imgr),15);
// free the memory (it's important, really)
imagedestroy($imgr);

if (C_BORDER) {
imagerectangle($im,0,0,C_WIDTH-1,C_HEIGHT-1,$bor);
}

}

// did you want to cheat?
if (CHEAT) {
    imagestring($im, 5, 5, 5, strtoupper($str), $bo);
}

/* show the resulting image */
header("Content-type: image/png ");
imagepng($im);

/* free the last little image in memory, the captcha one */
imagedestroy($im);
    

function getcatchars() {

$path = '../buttons/tacs/chars';

if (is_dir($path)) {
if($handle = opendir($path)){
  while(false !== ($file = readdir($handle))){
    // only .png files, and hidden files. needs be case-insensative tho
    if(!preg_match("/^\./", $file) && preg_match("/.*\.png/",$file)){
      if(is_dir($path."/".$file)){
      $dirs[] = $file;
      }else{ $files[] = $file;
      }
    }
  }
closedir($handle);
}

}

if (isset($files) && is_array($files)) {
return $files;
} else {
return 0;
}

}
?>