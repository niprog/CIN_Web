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

$fokus = "";

include "i_basic.inc.php";
include "i_header.inc.php";
include "i_body_head.inc.php"; // body and closebutton

if ($show_optionen) {
if ($new_window_x == "auto" || $new_window_y == "auto" ) {
    $widthheight = 'width=" + screen.availWidth + ", height=" + screen.availHeight + "';
    $widthheight_r = 'newWindow.resizeTo(screen.availWidth,screen.availHeight);';
 } else {
    $widthheight = 'width=' . $new_window_x . ' ,height=' . $new_window_y;
    $widthheight_r = 'newWindow.resizeTo(' . $new_window_x . ','. $new_window_y . ');';
 }
 
// make some settings that should be done in the config.php but the user have not configured properly
if ($php_include) { $enable_maximized_view = false;  }
if (!$enable_maximized_view) { $default_is_fullscreen = false; }

?>
<script type="text/javaScript" src="../js/twg_xhconn.js"></script>
<script type="text/JavaScript">
<!--
function openNewWindow() {
 newWindow=window.open("<?php
echo "../index.php?twg_album=" . $album_enc . "&twg_show=" . $image_enc . "&twg_standalone=true";

?>","Webgalerie","<?php echo $widthheight; ?>,left=0,top=0,menubar=no, status=no, resize=yes");
<?php echo $widthheight_r; ?>
closeiframe();
}
function maxView() {
  parent.location = "<?php echo $twg_root; ?>" + location.search + "&twg_zoom=TRUE";
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
  closeiframe();
}

//-->
</script>

<center>
<table width="266" border="0" summary='' cellpadding='0' cellspacing='0'>
<?php 
 if ($enable_maximized_view) {
 
 echo '
  <tr>
    <td class="left">' . $lang_opionen_php_zoom . '</td>
    <td><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-mini" 
	onclick="javascript:maxView()" name="Submitmit" value="' .$lang_opionen_php_ok .'" 
	onmouseover="self.status=\'\'; return true" 
	onMouseOut="self.status=\'\'; return true" />
	</div></td>
  </tr>'; 
}


if ($disable_nav_sel) { // we disable by adding a comment - not nice but I'm too lasy now ;).
  echo "<!--";
}
?>
  <tr>
    <td class="left"><?php echo $lang_opionen_php_top_nav;

?></td>
    <td class="right"> 
        <select name="menu1" onchange="MM_jumpMenu('parent',this,0)">
<script type="text/javaScript"> 
document.write("<option value='<?php echo $twg_root; ?>" + location.search + "&amp;twg_smallnav=true' />");
</script>
<?php echo $lang_opionen_php_yes;

?></option>
          <script type="text/javaScript"> 
document.write("<option value='<?php echo $twg_root; ?>" + location.search + "&amp;twg_bignav=true' ");
</script><?php if ($twg_smallnav == 'FALSE') {
    echo " selected ";
} 

?>
><?php echo $lang_opionen_php_no; ?></option>
        </select>
</td>
</tr>
<?php
if ($disable_nav_sel) {
  echo "-->";
}
if ($disable_nav_big_sel) { // we disable by adding a comment - not nice but I'm too lasy now ;).
  echo "<!--";
}
?>
 <tr>
    <td class="left"><?php echo $lang_dhtml_navigation;

?></td>
    <td class="right"> 
        <select name="menu1" class="selectmiddle" onchange="if (!myConnB) { myConnB = new XHConn(); }  if (!myConnB) { alert('You are using a browser that does not support this feature!'); } else { MM_jumpMenu('parent',this,0); }">

<script type="text/javaScript"> 
document.write("<option value='<?php echo $twg_root; ?>" + location.search + "&amp;twg_nav_dhtml=true' />");
</script>
<?php echo 'Ajax';

?></option>
 <script type="text/javaScript"> 
document.write("<option value='<?php echo $twg_root; ?>" + location.search + "&amp;twg_nav_dhtml=flash' ");
</script><?php if ($default_big_navigation == 'FLASH') {
    echo " selected ";
} 

?>
>Flash</option>
          <script type="text/javaScript"> 
document.write("<option value='<?php echo $twg_root; ?>" + location.search + "&amp;twg_nav_html=true' ");
</script><?php if ($default_big_navigation == 'HTML') {
    echo " selected ";
} 

?>
><?php echo 'HTML';

?></option>
    <script type="text/javaScript"> 
				 document.write("<option value='<?php echo $twg_root; ?>" + location.search + "&amp;twg_side_html=true' ");
				 </script><?php if ($default_big_navigation == 'HTML_SIDE') {
				     echo " selected ";
				 } 
				 ?>
				 ><?php echo 'HTML' . "&nbsp;(v2)";
?></option>
        </select>
</td>
  </tr>  
<?php 
if ($disable_nav_big_sel) {
  echo "-->";
}

if ($show_new_window) {
echo '
  <tr>
    <td class="left">' . $lang_opionen_php_new_window . '</td>
    <td><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-mini"
	onclick="javascript:openNewWindow()" name="Submitmit" value="' .$lang_opionen_php_ok .'" 
	onmouseover="self.status=\'\'; return true" 
	onMouseOut="self.status=\'\'; return true" />
	</div></td>
  </tr>';
}
if ($show_slideshow) {  
echo '
  <tr>
    <td class="left">' . $lang_opionen_php_slideshowintervall .'</td>
    <td width="110"><div align="right">
      <select name="select" onchange="MM_jumpMenu(\'parent\',this,0);" class="checkbox">
	   <script type="text/javaScript"> 
				document.write("<option value=\'' . $twg_root . '" + location.search + "&amp;twg_slideshow_time=3\' ");
</script>';
if ($twg_slideshow_time == '3') {
    echo " selected ";
} 
echo '>3</option>       
          <script type="text/javaScript"> 
				document.write("<option value=\'' . $twg_root .'" + location.search + "&amp;twg_slideshow_time=5\' ");
</script>';
if ($twg_slideshow_time == '5') {
    echo " selected ";
} 
echo '>5</option>
          <script type="text/javaScript"> 
				document.write("<option value=\'' . $twg_root . '" + location.search + "&amp;twg_slideshow_time=10\' ");
</script>';
if ($twg_slideshow_time == '10') {
    echo " selected ";
} 
echo '>10</option>
          <script type="text/javaScript"> 
				document.write("<option value=\'' . $twg_root . '" + location.search + "&amp;twg_slideshow_time=20\' ");
</script>';
if ($twg_slideshow_time == '20') {
    echo " selected ";
} 

echo '>20</option>
          <script type="text/javaScript"> 
				document.write("<option value=\'' . $twg_root . '" + location.search + "&amp;twg_slideshow_time=30\' ");
</script>';
if ($twg_slideshow_time == '30') {
    echo " selected ";
} 
echo '>30</option>
          <script type="text/javaScript"> 
				document.write("<option value=\'' . $twg_root . '" + location.search + "&amp;twg_slideshow_time=60\' ");
</script>';
if ($twg_slideshow_time == '60') {
    echo " selected ";
} 
echo '>60 </option>
      </select>
    </div></td>
  </tr>';

 if ($responsive_detail_page && $responsive_detail_page_full_slideshow) {
       $twg_slide_type == 'FULL';   
       $show_optimized_slideshow = false;
       $show_normal_slideshow = false;
    } else {
       $show_normal_slideshow = true;
    }

echo '<tr>
    <td class="left" height="30">' . $lang_optionen_slideshow . '</td>
    <td><div align="right">
      <select class="selectbig" name="select2" onchange="MM_jumpMenu(\'parent\',this,0);">
';

if ($show_optimized_slideshow) {
echo '
<script type="text/javaScript"> 
				document.write("<option value=\'' . $twg_root . '" + location.search + "&amp;twg_slide_type=TRUE\' />");
</script>' . $lang_optionen_slideshow_optimized . '</option>';
}
if ($show_normal_slideshow) {
echo '
        <script type="text/javaScript"> 
				document.write("<option value=\''. $twg_root . '" + location.search + "&amp;twg_slide_type=FALSE\' ");
</script>';
if ($twg_slide_type == 'FALSE') {
    echo " selected ";
} 
echo '>' . $lang_optionen_slideshow_normal . '
</option>';
}
if ($show_maximized_slideshow) {
echo'
   <script type="text/javaScript"> 
				document.write("<option value=\'' . $twg_root . '" + location.search + "&amp;twg_slide_type=FULL\' ");
</script>'; 
if ($twg_slide_type == 'FULL') {
    echo " selected ";
} 

 echo '>' . $lang_optionen_slideshow_fullscreen . '</option>';
}
echo '
        </select>
    </div></td>
  </tr>';
}  

?>
</table>
</center>
</td></tr></table>
<?php 
} else {
  showInvalidAccess();
}
include "i_bottom.inc.php"; 
?>