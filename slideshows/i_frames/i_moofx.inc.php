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

if (!isset($nomoofx)) {
?>
<script type="text/javaScript" src="../js/prototype.lite.js"></script>
<script type="text/javaScript">

var myeffectHeight;
function showMooDiv()
{
  myeffectHeight = new fx.Height('maindiv', {duration: 800});
  myeffectHeight.hide(); 
  document.getElementById("maindiv").style.visibility = "visible";
  document.getElementById("maindiv").style.display = "block"; 
  myeffectHeight.toggle();
  window.setTimeout("makeFocus('<?php echo $fokus; ?>')",1200);

}

function closediv()
{
  myeffectHeight = new fx.Opacity('maindiv', {duration: 500});
  myeffectHeight.toggle();
  window.setTimeout("closeiframe();",750);
}

</script>
<?php  }  ?>