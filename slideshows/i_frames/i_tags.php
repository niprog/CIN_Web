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

$tag_image = parse_html_parameter('twg_tag_image');
$tag_dir = parse_html_parameter('twg_tag_dir');
$submit = parse_parameter('twg_submit');

$tag_image = stripslashes(nl2br($tag_image));
$tag_dir = stripslashes(nl2br($tag_dir));


include "../inc/readxml.inc.php";

$fokus = "twg_name";
include "i_header.inc.php";	
include "i_body_head.inc.php"; // body and closebutton

if ($show_tags && $login_edit) {
if (!$submit) {
	echo $lang_tag_enter;

	$tags = getTags ($twg_album, $image);
	if (count($tags)) {
	  $tag_image = $tags["image"];
	  $tag_dir = $tags["dir"];
	}
} else {
	saveTags($twg_album, $image,$tag_image, $tag_dir);
	if (isset($_GET["PHPSESSID"])) {
		$closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?PHPSESSID=" . $_GET["PHPSESSID"] . "&twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
	} else {
		$closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
	}
	echo $closescript;
}
$tag_image = htmlentities( urldecode($tag_image), ENT_QUOTES, $charset);
$tag_dir = htmlentities( urldecode($tag_dir), ENT_QUOTES, $charset);
?>

<center>
  <img alt='' src="../buttons/1x1.gif" width="6" height="6" /><br />
  <?php echo $lang_tag_enter_image ?><br />
  <input type="text" id="twg_tag_image" name="twg_tag_image" style="width:240px" value="<?php echo $tag_image; ?>" />
  <br /><img alt='' src="../buttons/1x1.gif" width="6" height="6" /><br />
  <?php echo $lang_tag_enter_dir ?><br />
  <input type="text" id="twg_tag_dir" name="twg_tag_dir" style="width:240px" value="<?php echo $tag_dir; ?>" />
  <br /><img alt='' src="../buttons/1x1.gif" width="6" height="6" /><br />
  <input class="btn btn-small" type="submit" name="twg_submit" value="<?php echo $lang_kommenar_php_speichern ?>" />
</center>
</form>
<?php 
} else {
  showInvalidAccess();
}
include "i_bottom.inc.php";
?>