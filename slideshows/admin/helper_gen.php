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

  $Date: 2007-04-13 23:10:24 +0200 (Fr, 13 Apr 2007) $
  $Revision: 52 $
**********************************************/

defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
  header("Content-Type: text/html; charset=" . $GLOBALS["charset"]); 
	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"";
	echo "\"http://www.w3.org/TR/REC-html40/loose.dtd\">\n";
	echo "<HTML lang=\"".$GLOBALS["language"]."\" dir=\"".$GLOBALS["text_dir"]."\">\n";
	echo "<HEAD>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$GLOBALS["charset"]."\">\n";
	echo "<title>".$GLOBALS["config_screen_gen"] ["title"]."</title>\n";
	echo "<script  src=\"_js/admin.js\"  type=\"text/javascript\"></script>\n";
	echo "<LINK href=\"_style/style.css\" rel=\"stylesheet\" type=\"text/css\">\n";
	echo "</HEAD>\n<BODY class='body_gen'>";    
 
clearstatcache();

if (isset($_GET['twg_show_create'])) {
?>
<table summary="" class="content">
<tr>
	<td class="item2">
<?php echo $GLOBALS["config_screen_gen"] ["generimag"]; ?>
	
	<br/>
	</td>
	<td class="itemright" align="left">
	<a class="buttonlink" href="index.php?action=helper_gen<?php echo "&amp;" . session_name() . "=" . session_id(); ?>" id="gencachebutton"><?php echo $GLOBALS["config_screen_gen"] ["check_creation"]; ?></a>
		</td>
	</tr>
</table>


<?php
} else {
$globcount = gen_cache("../". $basedir);
if ($cache_gen_wait_time < 1) { // this is how long it takes on my system ;)
  $cache_gen_wait_time = 1;
}
$globcount_time = $cache_gen_wait_time * $globcount; // we asume only the waiting time
?>
<table summary="" class="content">
<tr>
	<td class="item2">
<?php 
  echo $GLOBALS["config_screen_gen"] ["generimag"];
  echo $GLOBALS["config_screen_gen"] ["generimag2"];
 ?><span id='counter'><?php echo $globcount; ?></span><br/>
<?php echo $GLOBALS["config_screen_gen"] ["remtime"]; ?><span id='time'>~ <?php echo floor($globcount_time/60) .   $GLOBALS["config_screen_gen"] ["min"] . floor($globcount_time - (floor($globcount_time/60))*60) .  $GLOBALS["config_screen_gen"] ["s"]; ?></span>
	
	<br/>
	</td>
	<td class="itemright" align="left">
	<a class="buttonlink" href="javascript:startCreation();" id="gencachebutton"><?php echo $GLOBALS["config_screen_gen"] ["gencach"]; ?></a>
		</td>
	</tr>
</table>
<?php
}
?>

	</body></html>