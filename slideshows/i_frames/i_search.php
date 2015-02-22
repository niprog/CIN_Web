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

$fokus = "twg_search_term";
include "i_header.inc.php";
$issearch = true;
include "i_body_head.inc.php"; // body and closebutton

if ($show_search) {
?>

<script type="text/javascript">
function desel_others() {
document.getElementById('c0').checked=false;
document.getElementById('c1').checked=false;
document.getElementById('c2').checked=false;
document.getElementById('c3').checked=false;
document.getElementById('c4').checked=false;
}
</script>
 
<?php
echo '<input type="hidden" name="twg_top10" value="search" />';

echo $lang_search_text;
?>
  <br /><img alt='' src='../buttons/1x1.gif' height='4' /><br /><input type="text" id="twg_search_term" name="twg_search_term" style="vertical-align:middle;width:130px;"/>
  &nbsp;
  <input class="btn btn-small" type="submit" name="twg_submit" value="<?php echo $lang_search ?>" />
</td></tr>
<tr>
<td class="leftsearchsi">
<?php echo $lang_search_where; ?>
</td>
</tr>
<tr>
<td>
<center>
<table summary="" width="100%"  border="0" cellspacing="0" cellpadding="0">
<?php 
if ($show_captions) { 
?>
  <tr>   
    <td class='leftsearchbox'><input id="c0"  type="checkbox" <?php if ($preselect_caption_search) { echo ' checked="checked" '; } ?> name="twg_search_caption" value="1"/>
      </td><td class="leftsearch"><?php echo $lang_menu_titel; ?></td>
  </tr> 
<?php 
}
if ($show_comments) { 
?>
  <tr> 
    <td class="leftsearchbox"><input id="c1" type="checkbox" <?php if ($preselect_comments_search) { echo ' checked="checked" '; } ?> name="twg_search_comment" value="1"/>
</td><td class="leftsearch"><?php echo $lang_comments; ?></td>
  </tr>
<?php 
}
?>  
  <tr>
    <td class="leftsearchbox"><input id="c2" type="checkbox" <?php if ($preselect_filenames_search) { echo ' checked="checked" '; } ?> name="twg_search_filename" value="1"/>
</td><td class="leftsearch"><?php echo $lang_fileinfo_name; ?></td>
  </tr>
   <tr>
	    <td class="leftsearchbox"><input id="c3" type="checkbox" <?php if ($preselect_folders_search) { echo ' checked="checked" '; } ?> name="twg_search_folders" value="1"/>
	</td><td class="leftsearch"><?php echo $lang_search_folders; ?></td>
  </tr>
<?php 
if ($show_tags) { 
?>  
   <tr>
	<td class="leftsearchbox"><input id="c4" type="checkbox" <?php if ($preselect_tags_search) { echo ' checked="checked" '; } ?> name="twg_search_tags" value="1"/>
		</td><td class="leftsearch"><?php echo $lang_search_tags; ?></td>
  </tr>
<?php 
}
?>  
  
    <tr>
		<td class="leftsearchbox"><input id="c5" onclick="desel_others();" type="checkbox" <?php if ($preselect_last_search) { echo ' checked="checked" '; } ?> name="twg_search_latest" value="1"/>
		</td><td class="leftsearch"><?php echo $lang_search_latest; ?>&nbsp;
		 <select style="width:90px" name="twg_search_num">
			 <option value="10">10</option>
			 <option value="20">20</option>
			 <option value="50">50</option>
			 <option value="50">100</option>
			 <option value="d7">7 <?php echo $lang_search_days; ?></option>
			 <option selected="selected" value="d14">14 <?php echo $lang_search_days; ?></option>
			 <option value="d30">30 <?php echo $lang_search_days; ?></option>
			 <option value="d60">60 <?php echo $lang_search_days; ?></option>
			 <option value="d90">90 <?php echo $lang_search_days; ?></option>
	 </select>
		</td>
  </tr>
  
  
  
</table>
</center>
</td>
</tr>
 <tr>
	<td class="leftsearchsi">
	<img alt='' src='../buttons/1x1.gif' height='8' /><br />
	<?php echo $lang_search_max; ?>
	 <select name="twg_search_max">
	 <option value="10">10</option>
	 <option selected="selected" value="20">20</option>
	 <option value="50">50</option>
	 <option value="10000"><?php echo $lang_search_all; ?></option>
	 </select>
	</td>
</tr>
</table>
</form>
<?php
} else {
  showInvalidAccess();
}
include "i_bottom.inc.php"; 
?>