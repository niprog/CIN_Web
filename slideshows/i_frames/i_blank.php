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

$fokus = "";
include "i_header.inc.php";

include "i_body_head.inc.php"; // body and closebutton

     if (isset($_GET["PHPSESSID"])) {
        $closescript = "<script type=\"text/javascript\">closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?PHPSESSID=" . $_GET["PHPSESSID"] . "&twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
         } else {
        $closescript = "<script type=\"text/javascript\">closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
         }

?>
<div>111</div>
<div>222</div>
<div>333</div>

<?php include "i_bottom.inc.php"; ?>