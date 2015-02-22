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
include_once "../inc/readxml.inc.php";

$fokus = "";
include "i_header.inc.php";
include "i_body_head.inc.php"; // body and closebutton

if ($show_tags) {
     if (isset($_GET["PHPSESSID"])) {
        $closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?PHPSESSID=" . $_GET["PHPSESSID"] . "&twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
         } else {
        $closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
         }

?>
<?php 
// we create the maximum !!
// find the top !
$tags = create_top_tags($twg_album);

if (count($tags) > 0) {
  printf($lang_tag_enter_header, $number_of_top_tags);
  echo "<br />&nbsp;<br />";
  $max = current($tags);
 // sort keys alphabetical !
    uksort($tags, "strcasecmp");
	  reset ($tags);
	  
  // we split in 3 sizes if less then 10 tags, 4 sizes if < 20, else 5 sizes
  $dividor = 3;
  if ($max >20) $dividor = 5;
  else if ($max >10)  $dividor = 4;

  foreach ($tags as $tag => $count) {
    $style = ceil( ((float)$count)/$max*$dividor); 
    echo "<span class='topx_style_pad topx_style_". $style ."'>";
    echo "<a target='_parent' href='" . $twg_root;
    echo "?twg_top10=search&amp;twg_search_exact=true&amp;twg_search_tags=1&amp;twg_search_max=".$number_of_top_tags_results."&amp;twg_search_term=".$tag."'>"; 
    echo urldecode($tag) . "</a><img src='../buttons/1x1.gif' width='1' height='".(11 + $style)."'/> </span>";
  }
} else {
echo "<br />".$lang_no_tags."<br />";
}
?>
<br />&nbsp;
<?php 
} else {
  showInvalidAccess();
}
include "i_bottom.inc.php"; 
?>