<?php
/*************************
  Copyright (c) 2004-2014 TinyWebGallery
  written by Michael Dempfle
 
  This program is free software; you can redistribute it and/or modify 
  it under the terms of the TinyWebGallery license (based on the GNU  
  General Public License as published by the Free Software Foundation;  
  either version 2 of the License, or (at your option) any later version. 
  See license.txt for details.
 
  TWG Admin version: 2.2

  $Date: 2009-06-17 22:57:10 +0200 (Mi, 17 Jun 2009) $
  $Revision: 73 $
**********************************************/

/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );

show_twg_header();
?>
<script type="text/javaScript" src="_js/picker.js"></script>
<div id="ctr" align="center">
<div class="colorpicker round_borders">
<div id="step">
<?php echo $GLOBALS["color_messages"] ["colmanager"]; ?></div>
<div class="clr"></div>
<DIV id="palette">
<div id="picker">
<SCRIPT  type="text/javaScript" LANGUAGE = "JavaScript">
<!--
ini()
zeigen_pal()
// -->
</SCRIPT>
<script type="text/javascript" language="Javascript" src="_js/overlib_mini.js"></script>

<SCRIPT  type="text/javaScript" LANGUAGE = "JavaScript">
<!--
zeigen_form()
// -->
</SCRIPT>
</div>
</div>
<table summary=""><tr>
  <td style="padding-left:20px;padding-right:20px;">
<?php echo $GLOBALS["color_messages"] ["thecolmanager"]; ?><img alt=""<?php writehowto(9); ?> align=right src="_img/help.gif"><?php echo $GLOBALS["color_messages"] ["fontsize"]; ?>
</td></tr></table>
	<div id="canvas">
		<div style="display: none;" id="codeView">
		  <div id="CSSCode" onclick="changeVoid();"><center><textarea cols="75" rows="24" id="cssarea">empty</textarea></center></div>
			<input onclick="document.getElementById('CSSCode').focus();document.getElementById('cssarea').select();" value="<?php echo $GLOBALS["color_messages"] ["selectcss"]; ?>"  class="button"  type="button">
				 <input  class="button" id="backPage" onclick="changeVoid(); goBackPage(); return false;" value="<?php echo $GLOBALS["color_messages"] ["backtopl"]; ?>" type="button">
				 <?php
					 if ((!file_exists ( "../my_style.css") || is_writable( "../my_style.css")) && testParentdir()) {
					 ?>
					 <input  class="button" id="backPage" onclick="changeVoid(); storeCss('<?php echo md5(session_id()); ?>'); return false;" value="<?php echo $GLOBALS["color_messages"] ["savestyle"]; ?>" type="button">
					 <?php
					 } else {
						 if (!testParentdir()) {
							 echo "&nbsp;&nbsp;<div class='error'>" . $GLOBALS["color_messages"] ["mainfolntwr"] . "</div>";
							} else {
							 echo "&nbsp;&nbsp;<div class='error'>" . $GLOBALS["color_messages"] ["stylecssntwr"] . "</div>";
						 }
					 }
				 ?>
		</div>
		<div style="display: block;" id="pageWidth">
		    <div id="sideleft"  onclick="changeBackgroundColor(this); return false;">&nbsp;</div>
		    <div id="sideright" onclick="changeBackgroundColor(this); return false;">&nbsp;</div>
		    <div id="topleft" onclick="changeBackgroundColor(this); return false;" ><img alt="" src="pic/schwarz.gif" height="5"><br/><a id="toplefttext" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["text"]; ?></a>   <a id="topleftlink" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["link"]; ?></a>   <a id="toplefthover" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["hover"]; ?></a></div>
		    <div id="topmiddle" onclick="changeBackgroundColor(this); return false;">&nbsp;</div>
		    <div id="topright" onclick="changeBackgroundColor(this); return false;"><img alt="" src="pic/schwarz.gif" height="5"><br/><a id="toprighttext" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["text"]; ?></a>   <a id="toprightlink" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["link"]; ?></a>   <a id="toprighthover" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["hover"]; ?></a></div>
		    <div id="content" onclick="changeBackgroundColor(this); return false;"><center><img alt="" src="pic/schwarz.gif" height="10"><br/><b><a id="contentheader" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["header"]; ?></a></b><br/>
		    <img alt="" src="pic/schwarz.gif" height="10"><br/><a id="contentfolder.txt" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["foldertxt"]; ?></a><br/><img alt="" src="pic/schwarz.gif" height="6"><br/><a id="topxactive" href="#" onclick="changeColor(this)"><b><?php echo $GLOBALS["color_messages"] ["topxact"]; ?></b></a>&nbsp;&nbsp;<a id="topxinactive" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["topxinact"]; ?></a><br/>
		       <img alt="" src="pic/schwarz.gif" height="70"><br/><a id="contenttext" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["text"]; ?></a>   <a id="contentlink" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["link"]; ?></a>   <a id="contenthover" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["hover"]; ?></a><br/>
		       <img alt="" src="pic/schwarz.gif" height="100"><br/><a id="contentcaption" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["caption"]; ?></a><br/>
		       <img alt="" src="pic/schwarz.gif" height="12"><br/><a id="contenttips" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["tips"]; ?></a></center>
		       </div>
		    <div id="bottomleft" onclick="changeBackgroundColor(this); return false;"><img alt="" src="pic/schwarz.gif" height="5"><br/><a id="bottomlefttext" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["text"]; ?></a>   <a id="bottomleftlink" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["link"]; ?></a>   <a id="bottomlefthover" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["hover"]; ?></a></div>
				<div id="bottommiddle" onclick="changeBackgroundColor(this); return false;"><img alt="" src="pic/schwarz.gif" height="5"><br/><a id="bottommiddletext" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["text"]; ?></a>   <a id="bottommiddlelink" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["link"]; ?></a>   <a id="bottommiddlehover" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["hover"]; ?></a></div>
		    <div id="bottomright" onclick="changeBackgroundColor(this); return false;"><img alt="" src="pic/schwarz.gif" height="5"><br/><a id="bottomrighttext" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["text"]; ?></a>   <a id="bottomrightlink" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["link"]; ?></a>   <a id="bottomrighthover" href="#" onclick="changeColor(this)"><?php echo $GLOBALS["color_messages"] ["hover"]; ?></a></div>

<!-- END pageWidth -->
<!-- buttons -->
   <div id="pagebuttons">
   <center>
			<select class="select" onchange="changeBgImage(this.selectedIndex);">
			<?php
			// DO NOT EXTRACT THE OPTIONS TO THE LANGUAGE FILE
			// The strings are used internally and changing them would break the code!
			?>
			<option>Back 1</option>
			<option>Back 2</option>
			<option>Back 3</option>
			<option>Back 4</option>
			<option>Back 5</option>
			</select>&nbsp;&nbsp;<select id="bstyle" class="select" onchange="changeBorderStyle();">
			<option value="Border: none">none</option>
			<option value="Border: 1px solid">1px solid</option>
			<option value="Border: 1px ridge">1px ridge</option>
			<option value="Border: 2px solid">2px solid</option>
			<option value="Border: 2px ridge">2px ridge</option>
			<option value="Border: 2px groove">2px groove</option>
			<option value="Border: 2px outset">2px outset</option>
			<option value="Border: 3px ridge">3px ridge</option>
			<option value="Border: 3px groove">3px groove</option>
			</select>&nbsp;<div id="bordercolor" onclick="changeBackgroundColor(this);changeBorderStyle()"><img alt="" src="pic/schwarz.gif" height="20" width="20"></div>&nbsp;&nbsp;&nbsp;<input onclick="location.reload();" class="button" type="button" value="<?php echo $GLOBALS["color_messages"] ["reset"]; ?>">&nbsp;&nbsp;<input id="button_cells" onclick="changeBorder();" class="button" type="button" style="width:90px;" value="<?php echo $GLOBALS["color_messages"] ["showcells"]; ?>">&nbsp;&nbsp;<input onclick="changeVoid(); generateCSS(); return false;" class="button"  type="button" style="width:70px;" value="<?php echo $GLOBALS["color_messages"] ["showcss"]; ?>">
	 </center>
		</div>
		</div>
<!-- END pageWidth -->
	</div>
</div></div>
<SCRIPT  type="text/javaScript" LANGUAGE = "JavaScript">
<!--
document.forms[0].elements[9].checked = "1"
document.getElementById("bstyle").selectedIndex = 5;
// -->
</SCRIPT>
