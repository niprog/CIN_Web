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
include "i_basic.inc.php";
// the next wo are for a direct call of the random image!
if (isset($_GET['twg_random'])) {
    if (isset($_SESSION['twg_random' . $_GET['twg_random']])) {
        $image = replaceInput($_SESSION['twg_random' . $_GET['twg_random']]);
        $image_enc = htmlentities(urlencode($image), ENT_QUOTES, $charset);
    } else { // if external html page was open toooo long we jump to the first image
        $image = "x";
        $image_enc = "x";
    }
}

if (isset($_GET['twg_random'])) {
    if (isset($_SESSION['twg_random_album' . $_GET['twg_random']])) {
        $twg_album = replaceInput($_SESSION['twg_random_album' . $_GET['twg_random']]);
        $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
    } else { // if external html page was open toooo long we jump to the first image
        $twg_album = false;
        $album_enc = false;
    }
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $image;
?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../css/style-min.css" >
<script type="text/javascript">
var myWidth = 0, myHeight = 0;
var OriginalWidth = 0, OriginalHeight = 0;
var bild;



function fitWindow(id)
{
 
  bild = document.getElementById(id);
	if (OriginalWidth == 0 && OriginalHeight == 0)
	{
		 document.body.style.display = "block";
		 bild.style.display       = "block";
 		 OriginalWidth  = bild.width;
		 OriginalHeight = bild.height;
	}
	if (((screen.width-180)>bild.width) && ((screen.height-100)>bild.height)) {
    if (window.outerWidth) {  // newer browsers
       getInnerWidth();
       offsetx =  window.outerWidth - myWidth;
	     offsety = window.outerHeight - myHeight;	       
    } else {  // IE < 9 need 2 resize.
       window.resizeTo(bild.width + 20 , bild.height + 62);
       getInnerWidth();
       offsetx = bild.width + 20 - myWidth;
	     offsety = bild.height + 62 - myHeight;	     
    }
    window.resizeTo(bild.width + offsetx, bild.height + offsety);
    document.title=document.title + "  " + OriginalWidth  + "x" + OriginalHeight + " (100%)";
	} else { // pic is larger than screen
	  factor = bild.width/bild.height;
	  factorscreen = screen.width/screen.height;

    var  offsetx = 0;
    var  offsety = 0;
    if (window.outerWidth) {  // newer browsers - we check the border
       getInnerWidth();
       offsetx =  window.outerWidth - myWidth;
	     offsety = window.outerHeight - myHeight;	
    }
    
	  if (factor > factorscreen) {
	    // width of screen!
	    x = screen.width-40+offsetx;
      y = ((screen.width-40)/factor)+offsety;
      window.resizeTo(x,y);	   
	  } else {
	    // height of screen!
      x =  ((screen.height-120)*factor)+offsetx ;
      y =  screen.height-120+offsety;
      window.resizeTo( x, y);
	  }

    if (window.outerWidth) {
      myWidth = x - offsetx;
      myHeight =  y - offsety;
    } else {
      getInnerWidth();
    } 

	  if (Math.abs(((myWidth / myHeight) - factor)*100) < 20) {
		  bild.width=myHeight*factor;
		  bild.height=myHeight;
		  percent = Math.round((bild.width / OriginalWidth) * 100);
		  document.title=document.title + "  " + OriginalWidth  + "x" + OriginalHeight + " (" + percent + "%)";
		  pos = (screen.width-myWidth)/2 - (offsetx/2);
	    window.moveTo(pos ,0);
    } else { // Opera or settings that don't allow to resize the browser !
	    newFactor = myWidth / myHeight;
	    if (newFactor > factor) { // height is restricting
	      bild.width=myHeight*factor;
	      bild.height=myHeight;
	    } else {  // width is restricting !
	      bild.width=myWidth;
	      bild.height=myWidth/factor;
	    }
	  }
	}
}

function getInnerWidth() {
    if( typeof( this.window.innerHeight ) == 'number' ) {
		//Non-IE
		myWidth =  window.innerWidth;
		myHeight = window.innerHeight;
	} else if( document.documentElement &&
			( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		myWidth = document.documentElement.clientWidth;
		myHeight = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
		myWidth = document.body.clientWidth;
		myHeight = document.body.clientHeight;
	}
}

</script>
</head>
<body class="twg_body_popup" onload="javascript:fitWindow('popimage');"><?php

if (isset($_GET["twg_direct"])) {
    $href = $_GET["twg_direct"];
    $href = htmlentities(urldecode($href), ENT_QUOTES, $charset);
    // $href = urldecode($href);
} else {
    $href = sprintf("../image.php?twg_album=%s&amp;twg_show=%s", $album_enc, $image_enc);
}

if ($click_on_popup_dl_image) {
    $click = "";
} else {
    $click = "onclick='self.close();') ";
}

echo "<div style='z-index:1191'>";
if (!isset($_GET["twg_direct"])) {
  echo "<a href='" . $href . "'>";
}
echo "<img style='border:none' alt='' " . $click . " id='popimage' src='" . $href . "'>";
if (!isset($_GET["twg_direct"])) {
  echo "</a>";
}
echo "</div>";

?></body>
</html>