<?php

defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');
function split_files()
{
 
  echo '<div id="ctr" align="center">
				<div class="install round_borders">
				<div id="step">'.$GLOBALS["fsa_messages"]["title"].'</div>
	<div class="clr"></div><br/>';
 
  echo '<p style="width:90%">'.$GLOBALS["fsa_messages"]["split_description"].'</p><br/>';
  echo '
  <applet codebase="upload"
	        code="de.tfu.FileSplitApplet"
	        name="de.tfu.FileSplitApplet"
	        width=400
	        height=300
	        archive="fsa_signed.jar"
	        background=#ffffff
	        align=top>
		<param name="automaticSize" value="';		
echo return_kbytes(ini_get('upload_max_filesize'));		
echo '">
   </applet>
';
   echo "<br/>&nbsp;<br/>";

   echo "
   <input type=\"button\" value=\"" . $GLOBALS["messages"]["btnback"];
   echo "\" onClick=\"javascript:location='" . make_link("list", null, null) . "';\">\n
  ";
   
  echo "<br></div></div>\n";
}

function split_info()
{
 
  echo '<div id="ctr" align="center">
				<div class="install round_borders">
	<div class="clr"></div>';
 
  echo '
  <div id="step">'.$GLOBALS["fsa_messages"]["title"].'</div>
  <div class="clr"></div>
  <br/>
 <p style="width:90%">'.$GLOBALS["fsa_messages"]["help_text1"].'</p>
	<br/>
	<p><b>"'.$GLOBALS["fsa_messages"]["help_warning"].'"</b></p>
	<br/>
<p>'. sprintf($GLOBALS["fsa_messages"]["help_text2"], '<a target="_blank" href="http://www.tinywebgallery.com/tfufsa.htm"><b>', '</b></a>') . '</p>
<br/>
<p>'.$GLOBALS["fsa_messages"]["help_limit"].': ';
   $limit = return_bytes(ini_get('upload_max_filesize'));
  if (!$limit){
    echo '<b><font color="orange">' . $GLOBALS["messages"]["up_not_detected"] .'</font></b>';
  }else{
    echo '<b>' . ini_get('upload_max_filesize') . '</b>';
  }
echo '.</p>
<br/>
<center>
<div class="noflash" style="width:200px"><a href="' . getScriptName() . '?action=split&amp;sview=no&amp;menu=true">'.$GLOBALS["fsa_messages"]["help_open"].'</a></div>
</center>
';
   echo "<small>". $GLOBALS["fsa_messages"]["help_time"]."</small><br/>&nbsp;<br/>
";

   echo "
   <input type=\"button\" value=\"" . $GLOBALS["messages"]["btnback"];
   echo "\" onClick=\"javascript:location='" . make_link("list", null, null) . "';\">\n
  ";
   
  echo "<br></div></div>\n";
}


function split_setup()
{
 
  echo '<div id="ctr" align="center">
				<div class="install round_borders">
				<div id="step">'.$GLOBALS["fsa_messages"]["title"].'</div>
	<div class="clr"></div><br/>';
 
  echo '<p style="width:90%">'.$GLOBALS["fsa_messages"]["split_setup"].'</p>';
  echo "<br/>&nbsp;<br/>";

   echo "
   <input type=\"button\" value=\"" . $GLOBALS["messages"]["btnback"];
   echo "\" onClick=\"javascript:location='" . make_link("list", null, null) . "';\">\n
  ";
   
  echo "<br></div></div>\n";
}





?>
