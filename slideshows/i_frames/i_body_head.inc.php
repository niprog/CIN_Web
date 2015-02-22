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

defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
?>
<body>
<div id="maindiv"  class="maindivhide">
<div id="innerdiv" class="innerdiv">

<?php
if (isset($issearch)) {
  echo '<form action="'. $twg_root . '" target="_parent" method="get">';
} else {
  echo '<form action="'. getScriptName() .'" method="get">';
}

if (isset($twg_album)) {
    echo '<input name="twg_album" type="hidden" value="' . twg_urlencode($twg_album) . '"/>';
}
if (isset($image)) {
    echo '<input name="twg_show" type="hidden" value="' . twg_urlencode($image) . '"/>';
}
if (isset($twg_foffset)) {
    echo '<input name="twg_foffset" type="hidden" value="' . ($twg_foffset) . '"/>';
}
echo $hiddenvals;

?>
<input name="twg_submit" type="hidden" value="true"/>
<table summary='' style="width: 100%" cellpadding='0' cellspacing='0'>
<tr>
<td class="closebutton">
<img id="bt_close" name="bt_close" alt='' onclick="closediv()" align="right" src="../buttons/close.gif" width="12" height="12" border="0" />
</td>
</tr>
<tr><td class="pad">