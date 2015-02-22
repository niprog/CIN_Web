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

include "../inc/readxml.inc.php";

$img_nr = get_image_number($twg_album, $image_enc);
$img_total = count(get_image_list($twg_album));
$img_nr++;
$display_nr = $img_nr;
if ($img_nr >= $img_total) {
    $img_nr = 0;
} 
$img_next = get_image_name($twg_album, $img_nr);

require '../language/language_default.php';
require '../language/language_' . $default_language . '.php';
if (isset($charset)) {
  	header("Content-Type: text/html;charset=" . $charset);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TinyWebGallery</title>
<meta name="author" content="mid" />
<?php
if (isset($charset)) {
    echo '<META http-equiv="Content-Type" content="text/html; charset=' . $charset . '"/>';  
}
?>
<?php
echo "<meta http-equiv='refresh' content='" . $twg_slideshow_time . "; URL=" . getScriptName() . "?twg_album=" . $album_enc . "&amp;twg_show=" . $img_next . $twg_standalone . "&amp;twg_root=" . $twg_root . "' />";
?>

<link rel="stylesheet" type="text/css" href="../css/style-min.css" />
<?php 
if (file_exists("../my_style.css")) {
  echo '<link rel="stylesheet" type="text/css" href="../my_style.css" />';
}
?>
<script type="text/javaScript" src="../js/twg_image-min.js"></script>
<style  type="text/css">
body.twg {
background-color:transparent;
}
</style>
</head>
<body class="twg">
<?php
if ($input_invalid) {
printErrorInvalid();
echo "</body></html>";
die();
}
?>
<center>
<script type="text/javaScript"> 
if (document.getElementById && parent.document.getElementById("imagecounter")) { 
  parent.document.getElementById("imagecounter").innerHTML = "<?php echo $display_nr;?>";
} else { 
  document.write('<?php echo '<span class="twg_Caption">' . ($display_nr) . "/" . $img_total . "<\/span><br \/>";  ?>'); 
}
</script>
<noscript>
<?php echo '<span class="twg_Caption">' . ($display_nr) . "/" . $img_total . "</span><br />";  ?>
</noscript>

<?php
$aktimage = $image;

// $aktimage = replace_valid_url($aktimage);
$actPicturejs = $twg_root . "?twg_album=" . $album_enc . "&twg_show=" . $image_enc  . $twg_standalonejs . "&twg_root=" . $twg_root;

$thumbimage = create_thumb_image($twg_album, urlencode($aktimage));
$small = create_cache_file($thumbimage,$extension_small);
$thumbimagenext = create_thumb_image($twg_album, $img_next);
// $thumbimagenext = urlencode($replaced_album . "_" . urldecode($img_next));
$small_next = create_cache_file(cacheencode($thumbimagenext),$extension_small, true, $twg_seo_active);

if (!file_exists($small) || $disable_direct_thumbs_access) {
    $src_value = "../image.php?twg_album=" . $album_enc . "&amp;twg_type=small&amp;twg_rot=0&amp;twg_show=" . $image_enc;
    $widthheight = "";
} else {
    $oldsize = getimagesize($small);
    $src_value = create_cache_file(cacheencode($thumbimage),$extension_small, true, $twg_seo_active);
    // we set the size of the image because we know it :) - looks nicer at the twg_slideshow
    if ($use_small_pic_size_as_height) { // 
				$widht_ie = ceil($small_pic_size * 1.35) + 10;
		} else {
				$widht_ie = $small_pic_size + 10;
		} 
    if ($oldsize[0] > $widht_ie) { // it's too wide ... we let the browser scale the image ;).
      $widthheight = "width='" . $widht_ie . "'"; 
    } else {
      $widthheight = "width='" . $oldsize[0] . "' height='" . $oldsize[1] . "' ";
    }
} 

$install_dir = "../";
printf("<img class='imageview' src='%s' alt='twg_slideshow' %s />",  $src_value, $widthheight);

if ($show_captions) {
$cap = replacesmilies(getBeschreibung($image, $werte, $index));
$cap = str_replace("||", "&nbsp;<br />&nbsp;", $cap);
$cap = str_replace("\r", "&nbsp;<br />&nbsp;", $cap);
$cap = str_replace("\"", "&quot;", $cap);
$cap = str_replace("\n", "", $cap);

echo '<br /><span class="twg_Caption">&nbsp;' . $cap . '</span>&nbsp;';
}
if (!file_exists($small_next)) {
    $small_next = "../image.php?twg_album=" . $album_enc . "&twg_type=small&twg_rot=0&twg_show=" . $img_next;
} 
?>
</center>
<script type="text/javaScript">     
if (document.getElementById) {
   if  (parent.document.getElementById("stop_slideshow")) {
     parent.document.getElementById("stop_slideshow").href = "<?php echo $actPicturejs; ?>";
   } else {
     window.location = "index.htm"; 
   }
}    
// it preloads the image on the nxt page - should be in the browser cache than ;)
MM_preloadImages('<?php echo $small_next;
?>');
</script>
</body>
</html>