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

if (isset($_GET['twg_xmlhttp'])) {
    $_SESSION["twg_download"] = replaceInput($_GET['twg_xmlhttp']);
    return '';
}

$twg_download = parse_html_parameter('twg_download');
$fokus = "";
include "i_header.inc.php";

?>

<script type="text/javaScript" src="../js/twg_xhconn.js"></script>
<script type="text/javaScript">
function saveStatus(wert) {
	if (document.getElementById('storeses') && document.getElementById('storeses').checked==true ) {
		if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
		if (!myConnB) alert("XMLHTTP not available. Try a newer/better browser.");
		var fnWhenDone = function (oXML) { };
		myConnB.connect("<?php echo getScriptName(); ?>?twg_xmlhttp=" + wert, fnWhenDone);
	}
}
</script>
<?php

include "i_body_head.inc.php"; // body and closebutton

if ($open_download_in_new_window) {
    $open = "window.open(' ";
    $end = "');";
} else {
    $target = "parent.location.href='";
    $end = "'";
}

if ($enable_direct_download) {
    $link = $basedir . '/' . rawurlencode($twg_album) . '/' . rawurlencode ($image) ;
    // $download1 = sprintf("<a id='adefaultslide' %s href='%s/%s/%s'>", $target, $basedir, $twg_album, urldecode($image));
} else {
    $link = "../image.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc;
    $linkjs = "../image.php?twg_album=" . $album_enc . "&twg_show=" . $image_enc;
}

if ($twg_download) {
    if ($twg_download != "all") {
        echo '<script type="text/javaScript">';
        echo 'closeiframe();' . $open . $linkjs . $end;
        echo '</script>';
    }
}

echo $lang_dl_as_zip1;

echo '
    <center><table summary=""><tr><td colspan=2 class="centertable">
 <p>
		    <input class="btn btn-small" type="button" onclick="saveStatus(\'single\');window.setTimeout(\'closeiframe()\',3000);' . $open . $link . $end . '"   name="Submit" value="' . $lang_dl_as_zip2 . '" />';

$filename =  $basedir . '/' . $twg_album . '/' . str_replace("/", "_", $twg_album) . '.txt';
if (file_exists($filename)) {
    $linkzip = getFileContent($filename , "error reading link - check your filesettings !");
} else {
    $linkzip =  $basedir . '/' . $twg_album . '/' . (str_replace("/", "_", $twg_album)) . '.zip';
}

echo '  ';
echo '<input type="button" target="_parent" onclick="saveStatus(\'all\');self.location.href=\'' . $linkzip . '\';window.setTimeout(\'closeiframe()\',3000);" value="' . $lang_dl_as_zip3 . '" />
		  </p>
		    </td></tr><tr><td>';
if ($xml_http) {
    echo '<input type="checkbox" name="checkbox" id="storeses" value="checkbox" /></td><td>' . $lang_dl_as_zip4;
}
echo '</td></tr></table>';

?>
  </center>
</td></tr></table>
</form>
<?php include "i_bottom.inc.php";
?>
</body>
</html>