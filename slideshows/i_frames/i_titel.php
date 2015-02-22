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
	
// 3 save buttons?
$titel = parse_html_parameter_caption('twg_titel');
$titel = replace_conv_br($titel);
$foldername = parse_html_parameter_caption('twg_foldername');
$foldername = replace_conv_br($foldername);
$folderdesc = parse_html_parameter_caption('twg_folderdesc');
$folderdesc = replace_conv_br($folderdesc);
// 3 mod states! only 0 and 1 are allowed 1 is modified - rest not
$titel_mod =      parse_parameter('twg_titel_mod')  == '1';
$foldername_mod = parse_parameter('twg_foldername_mod') == '1' ;
$folderdesc_mod = parse_parameter('twg_folderdesc_mod') == '1';

$twg_main = parse_parameter('twg_main') == 'true';
$twg_thumb = parse_parameter('twg_thumb') == 'true';


if ($twg_main) {
  $enable_smily_support = false;
}

include "../inc/readxml.inc.php";

$fokus = "twg_titel";
include "i_header.inc.php";

echo '<script type="text/javascript" language="Javascript" src="../js/overlib_mini.js"></script>';

$titel = html_entity_decode($titel, ENT_QUOTES);
$titel = stripslashes(nl2br($titel));

$foldername = html_entity_decode($foldername, ENT_QUOTES);
$foldername = stripslashes(nl2br($foldername));

$folderdesc = html_entity_decode($folderdesc, ENT_QUOTES);
$folderdesc = stripslashes(nl2br($folderdesc));

$folder = $basedir . '/' . $twg_album;
$folderIsWriteable = is_writable($folder);

include "i_body_head.inc.php"; // body and closebutton

if ($login_edit) {
    if (!isset($_GET['twg_titel_page2'])) {
        if (!$twg_main && !$twg_thumb) {
          echo $lang_titel_php_titel;
          
          if ($show_iptc_data) {
          	// get the iptc data
            @getimagesize( $folder . '/' . $image, $info);	  
            if (isset($info["APP13"])) {
          		$iptc = iptcparse($info["APP13"]);
          		if (is_array($iptc)) {
          				$data = "";
          				$choices = explode(",", "2#105,2#005");
          				if ((count($choices) == 1) && isset($iptc[$key][0])) {
          					$data = $iptc[$key][0];
          				} else if (isset($iptc[$choices[0]][0])) {
          					$data = $iptc[$choices[0]][0];
          				} else if (isset($choices[1]) && isset($iptc[$choices[1]][0])) {
          					$data = $iptc[$choices[1]][0];
          				}
          				$data = trim($data);
                  if (isset($charset) && strtolower($charset) == "utf-8") {
          				  $data = ($filesystem_encoding == '') ? (($iptc_encoding == 'utf-8' ) ? $data : utf8_encode($data)) : iconv($filesystem_encoding, 'UTF-8', $data);
          				}
          				if ($data != "") {
          				  $data = replaceInputHtml($data);
          				  $data = str_replace('"', '\"', $data);
          				  echo '<script type="text/javascript">function setTitel() { document.getElementById("twg_titel").value = "' . $data .'"; document.getElementById("twg_titel_mod").value=1; }</script>';
          					echo '<a alt="'.$lang_edit_iptc_help.'" title="'.$lang_edit_iptc_help.'" href="#" onClick="setTitel()"> (IPTC)</a>';
          				}
          		}
          	}
          }          
        }
     } else {
     if ($titel_mod) {
       $_SESSION["actalbum"] = "LOAD NEW";
       loadXMLFiles($twg_album);
       saveBeschreibung($titel, $twg_album, $image, $werte, $index);
     } 
     if ($foldername_mod) {
       saveFolderNameTxt($folder, $foldername);
     }
     if ($folderdesc_mod) {
       saveFolderTxt($folder, $folderdesc);
     }
     
     if (isset($_GET["PHPSESSID"])) {
        $closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?PHPSESSID=" . $_GET["PHPSESSID"] . "&twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
         } else {
        $closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
         }
    echo $closescript;
    exit();
}

echo'
  <center><img alt="" src="../buttons/1x1.gif" width="1" height="2" /><table summary=""><tr><td>';
if ($enable_smily_support) {
    echo '
  <img alt="" onmouseover="javascript:show_smilie_div()" src="../buttons/smilie.gif" width="15" height="15" /></td><td><img alt="" src="../buttons/1x1.gif" width="1" height="15" /></td><td>';
     } else {
       echo '<!-- // --></td><td><img alt="" src="../buttons/1x1.gif" width="1" height="15" /></td><td>';
     }
     
// we load the old caption
$caption = htmlentities(rm_br(getBeschreibung( $image, $werte, $index)), ENT_QUOTES, $charset);   
$old_foldername = (rm_br(getDirectoryName($folder, $twg_album, true), ENT_QUOTES, $charset));
$old_folderdesc = (rm_br(getDirectoryDescription($folder, true), ENT_QUOTES, $charset));  

     
?>
  <input name="twg_titel_page2" type="hidden" value="true">
<?php
if (!$twg_main && !$twg_thumb && $show_captions) {
?>
  <input type="hidden" name="twg_titel_mod" id="twg_titel_mod" value="0"> 
  <textarea id="twg_titel" name="twg_titel" rows=3 style="width:240px;" type="text"  onchange="document.getElementById('twg_titel_mod').value=1;" ><?php echo $caption; ?></textarea></td></tr>
  <tr>
  <td>
<?php 
}
?><img alt="" src="../buttons/1x1.gif" width="1" height="1" /></td>
  <td><img alt="" src="../buttons/1x1.gif" width="1" height="1" /></td>
  <td><p style="margin-top:0px;">
<?php
if ($folderIsWriteable && $enable_frontend_edit) {  

if (!$twg_main) {
  echo '<span ' . '' . ' >' . $lang_edit_folder_name . '</span>:'; 
  echo writeHelp($lang_edit_folder_name_tooltip);
?>
 <input type="hidden" name="twg_foldername_mod" id="twg_foldername_mod" value="0"> 
 <input id="twg_titel" name="twg_foldername" type="text" value="<?php echo $old_foldername; ?>" style="width:240px;" onchange="document.getElementById('twg_foldername_mod').value=1;" />
</p>
<p>  
<?php 
}
echo '<span>' . $lang_edit_folder_description . '</span>:'; 
echo writeHelp($lang_edit_folder_description_tooltip);
?>
<input type="hidden" name="twg_folderdesc_mod" id="twg_folderdesc_mod" value="0"> 
 <textarea id="twg_titel" name="twg_folderdesc" type="text"  rows=4 style="width:240px;" onchange="document.getElementById('twg_folderdesc_mod').value=1;"><?php echo $old_folderdesc; ?></textarea></p><?php

}
?>

<p style="margin-bottom:0px;">
  <input class="btn btn-small" type="submit" name="twg_submit" value="<?php echo $lang_titel_php_save ?>"/>
</p>
  </td></tr>
  </table>
  </center>
</td></tr>
<?php
if (!$allow_all_html_captions) {
  echo '<tr><td class="html_tags">'. $lang_allowed_html_tags .'<br />';
  foreach ($allowed_html_tags as $value) {
    echo htmlentities($value, ENT_QUOTES, $charset) . "";
  }
  echo "</td></tr>";
}
?>
</table>
</form>
<?php
if ($enable_smily_support) {
    echo '
<div id="twg_smilie" class="twg_smiliediv"><table summary="" cellpadding="0" cellspacing="0"><tr><td class="twg_smilie">' . create_smilie_div() . '</td></tr></table></div>
<div id="twg_smilie_bord" class="twg_smiliedivborder" onmouseover="javascript:hide_smilie_div()" ></div>
';
     }



} else {
  showInvalidAccess();
}

function writeHelp($text) {
return " <img style=\"vertical-align:middle;\" alt=\"\" src=\"../admin/_img/help.gif\"  onmouseover=\"return overlib('" . $text . "', VAUTO,AUTOSTATUS,WIDTH, 210, BGCOLOR, '#666666',FGCOLOR, '#f5f5f5' );\" onmouseout=\"return nd();\" />";
}
/*
 ";
								
			echo " >";
*/
include "i_bottom.inc.php"; ?>