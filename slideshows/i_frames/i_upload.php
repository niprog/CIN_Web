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

$fokus = "";
$nomoofx = true;
include "i_header.inc.php";

?>
<body>
<div id="maindiv"  class="maindiv">
<div id="innerdiv" class="innerdiv">
<?php
 if (!$login_upload) {
   echo $lang_email_admin_notloggedin;
   return;
 }

$_SESSION["TFU_LOGIN"] = true;
$_SESSION["TFU_LOGIN_FRONTEND"] = true; // to use the settings for the frontend and not for the backend!
if ($twg_album) {
  $_SESSION["tfu_upload_dir"] = '../' . $basedir ."/". $twg_album;
} else {
  $_SESSION["tfu_upload_dir"] = '../' . $basedir;
}

$default_language .= "&session_id=" . session_id(); 
store_temp_twg_session();
session_write_close();
?>
<table summary='' style="width: 100%; height:100%" cellpadding='0' cellspacing='0'><tr><td class="closebutton">
<img name="imageField" alt='' onclick="closeiframe(); parent.location.reload(); " align="right" src="../buttons/close.gif" width="12" height="12" border="0" />
</td></tr><tr><td>
<center>
<script type="text/javascript" src="../js/swfobject.js"></script>
	<div id="flashcontent"><div class="noflash">TWG Flash Uploader requires at least Flash 8.<br />Please update your browser.</div></div>
	<script type="text/javascript">
	   function debugError(errorString) { }
    
	   var so = new SWFObject("../admin/upload/tfu_3.2.swf?base=../admin/upload/&lang=<?php echo $default_language; ?>", "mymovie", "650", "340", "8", "#ffffff");
     so.addParam("scale","noScale");
     so.addParam("allowfullscreen","true");
     so.addParam("allowfullscreen","true");
     <?php
     if ($enter_caption_at_upload == 'true') {
       echo 'so.addVariable("tfu_description_mode","true");';
     }
     ?>
     so.write("flashcontent");
	</script>
	<noscript>
	No flash because this view is normally only accessible with Javascript enabled!
	</noscript>
</center>
</td></tr></table><img alt='' src='../buttons/1x1.gif' height='10' /></div>
<div style="height:1px;"><div>
</div>
</body>
</html>