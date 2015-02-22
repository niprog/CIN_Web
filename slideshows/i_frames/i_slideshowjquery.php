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

define( '_VALID_TWG', '42' ); 
include "i_basic.inc.php";


$configphp = $basedir . "/" . $twg_album . "/config.php";
	if (file_exists($configphp)){
			include $configphp;
}
$configphp_lang = $basedir . "/" . $twg_album . "/config_".$default_language.".php";
if (file_exists($configphp_lang)){
  include $configphp_lang;
}

if ($twg_root == $install_dir . "../index.php") { // this is the default and wrong for the slideshow !
$twg_root = $install_dir . "index.php";
}

$email = ""; // only needed here ?

include "../inc/readxml.inc.php";

$image_list = get_image_list($twg_album);
$img_nr = get_image_number($twg_album, $image_enc);
$img_total = count($image_list);

require '../language/language_default.php';
require '../language/language_' . $default_language . '.php';
if (isset($charset)) {
  header("Content-Type: text/html;charset=" . $charset);
}

if (isset($_GET['twg_max'])) {
  $small_pic_size = $browsery-40;
  $use_small_pic_size_as_height = true;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>TinyWebGallery</title>
<?php
if (isset($charset)) {
  echo '<META http-equiv="Content-Type" content="text/html; charset=' . $charset . '">
  ';  
}
?>
<script type="text/javaScript"> 
// Set the twg_slideshow speed (in milliseconds)
var twg_slideshowSpeed = <?php echo ($twg_slideshow_time * 1000) ?>;

var Caption = new Array(); // don't change this
var PictureName = new Array(); // don't change this
var fadeimages=new Array()

<?php

$full_image1='';
$img_divs = '';
$install_dir = "../"; // for smilies !
for ($i = 0; $i < $img_total; ++$i) {
    $act_image = $image_list[$i];
    //$cacheimage =  urlencode(urlencode(str_replace("/", "_", $twg_album) . "_" . urldecode($act_image))) ;
    $cacheimage = create_thumb_image($twg_album, $act_image);
    $small = create_cache_file($cacheimage,$extension_small);
    if (isset($_GET['twg_max'])) {
      $fimage = "../image.php?twg_album=" . $album_enc . "&twg_type=full&twg_rot=0&twg_show=" . ($act_image);
    } else if (!file_exists($small) || $disable_direct_thumbs_access) {
      $fimage = "../image.php?twg_album=" . $album_enc . "&twg_type=small&twg_rot=0&twg_show=" . ($act_image);
    } else {
      $fimage = './' . twg_urlencode(create_cache_file($cacheimage,$extension_small));
    }
    echo "fadeimages[" . $i . "] = '" . $fimage . "';\n";
    $cap = escapeHochkommaSlideshow(replacesmilies((getBeschreibung($act_image , $werte , $index))));
    $cap = str_replace("||", "&nbsp;<br />&nbsp;", $cap);
    $cap = str_replace("\r", "&nbsp;<br />&nbsp;", $cap);
    $cap = str_replace("\"", "&quot;", $cap);
    $cap = str_replace("\n", "", $cap);

    echo "Caption[" . $i . "] = '" . $cap . "';\n";
    echo "PictureName[" . $i . "] = '" . $twg_root . "?twg_album=" . $album_enc . "&twg_show=" . $act_image . $twg_standalonejs . "';\n";
    if ($img_nr == $i) {
      $full_image1= $fimage;
      $img_divs .= '<div><img alt="" id="'.$i.'" src="'. './' . twg_urlencode(create_cache_file($cacheimage,$extension_small)) .'"></div>' . "\n";
    } else if ($i == 0 || $i == $img_nr+1) {
      $img_divs .= '<div><img alt="" id="'.$i.'" src="'.$fimage.'"></div>' . "\n";
    } else {
      $img_divs .= '<div><img alt="" id="'.$i.'" src="../buttons/1x1.gif" ></div>' . "\n";
    }  
} 
?>

var curimageindex=<?php echo $img_nr; ?>;
var nextimageindex=(curimageindex<fadeimages.length-1)? curimageindex+1 : 0;
var nrimages = fadeimages.length;
var img=0; 

<?php
 $twg_slideshow_width =  ($use_small_pic_size_as_height) ? ceil($small_pic_size * $image_factor) : $small_pic_size; 
 if (isset($_GET['twg_max'])) {
   $twg_slideshow_width = $browserx - 50+$iframe_slideshow_fix; 
 }
 if ($twg_slideshow_width > $browserx - 50+$iframe_slideshow_fix) {
   $twg_slideshow_width = $browserx - 50 +$iframe_slideshow_fix;
 }
 $twg_slideshow_width += 14; // border
 
 
?>
var twg_slideshow_height='<?php echo ($small_pic_size); ?>px' //SET IMAGE HEIGHT

// -------------------

</script>
<style type="text/css">
img { border: none }
#slideshow_jq { text-align:center; display:none; margin-left: 20px auto; margin-right: 20px auto; margin-top: 5px; margin-bottom: 5px; width: <?php echo ($twg_slideshow_width+24); ?>px; height: <?php echo ($small_pic_size+12); ?>px; overflow:hidden;}
#slideshow_jq div { width: <?php echo ($twg_slideshow_width+24); ?>px; height: <?php echo ($small_pic_size+12); ?>px; }

</style>
<!-- include jQuery library -->
<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
<!-- include Cycle plugin -->
<script type="text/javascript" src="../js/jquery.cycle.all.min.js"></script>
<!--  initialize the slideshow when the DOM is ready -->
<script type="text/javascript">
$(document).ready(function() {
    <?php if ($full_image1 != '') { ?>
      $('#<?php echo $img_nr; ?>').attr('src', '<?php echo $full_image1;  ?>');
    <?php } ?> 
    $('#slideshow_jq').cycle({
        fx: '<?php echo $twg_slide_fx_type; ?>', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
        timeout: <?php echo ($twg_slideshow_time * 1000) ?>, 
        startingSlide: curimageindex,
        before:   onBefore,
        cleartypeNoBg:  true,
        after: onAfter
	});
});

  /**
   * we start the load of the the overnext image because the next one is hardcoded. 
   * Dynamic loading does not work because the the centering does not work.   
   */    
  function onBefore(curr, next, opts) { 
    var curimageindex = parseInt($("img", next)[0].id);
    var n2 = curimageindex + 1;
    if (n2 >= nrimages) { n2 = 0; }    
    if (document.getElementById(n2).src.indexOf('1x1.gif') != -1 ) {
      document.getElementById(n2).src =  fadeimages[n2];   
    }
    setCaption(curimageindex); 
  }
   function onAfter(curr, next, opts) { 
    // document.getElementById('slideshow_jq').display="block"; 
    $('#slideshow_jq').css('display', 'block');
  }
  
  function setCaption(curimageindex) {
    if (document.getElementById) {
	 if (document.getElementById("CaptionBox")) {
	   document.getElementById("CaptionBox").innerHTML = Caption[curimageindex];
	 }
    }
	// if (document.getElementById) document.getElementById("NumberBox").innerHTML= (curimageindex + 1) + "/" + nrimages; 
    if (document.getElementById && parent.document.getElementById("imagecounter")) { parent.document.getElementById("imagecounter").innerHTML = curimageindex + 1; }
    if (document.getElementById) {
	   if  (parent.document.getElementById("stop_slideshow")) {
	     parent.document.getElementById("stop_slideshow").href = PictureName[curimageindex];
	   }
    }  
  }
</script>

<link rel="stylesheet" type="text/css" href="../css/style-min.css">
<?php 
if (file_exists("../my_style.css")) {
  echo '<link rel="stylesheet" type="text/css" href="../my_style.css">';
}
?>

<style type="text/css">
body.twg {
background-color:transparent;
margin: 0 px;
}
</style>
</head>
<body onload="jQuery('body.twg').css('visibility','visible');" style="visibility: hidden;" class="twg">
<?php 
if ($input_invalid) {
printErrorInvalid();
echo "</body></html>";
die();
}
?>
<center>
<table summary="" width="100%" height="100%" border=0 cellpadding=2 cellspacing=0> 
  <tr>
    <td width="100%" style="vertical-align: middle;" height=<?php echo $small_pic_size ?>>
    <div id="slideshow_jq">
	     <?php echo $img_divs; ?>
     </div>
    </td>
  </tr>
<?php
  if ($show_captions) {
    echo "
      <tr>
        <td id=CaptionBox class=twg_Caption align=center>" . $lang_slideshowid_php_loading . "</td>
      </tr>
  ";
  }
?>
</table>
</center>
</body>
</html>