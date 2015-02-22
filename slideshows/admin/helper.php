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

defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');

/* this is very inefficient and will be rewritten soon */
function checkMainConfig($key, $value) {
$value = trim(strval($value));
$value = trim($value);
$main_config_only = "set";
include dirname(__FILE__) . "/../config.php";
// reads the main config line without the my_config
eval("\$kv = \$" . $key .";" );
$kv = trim(strval($kv));
return ($kv == $value);
}


function printOffset($offset) {
    if ($offset == 1) echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    if ($offset == 2) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}

function generateOption ($text, $value, $sel, $boolean = 2)
{
    if ($boolean != 2) {
        $select = ($sel == $boolean) ? " selected " : "";
    } else {
        $select = ($sel == $value) ? " selected " : "";
    }
    echo '<option value="' . $value . '" ' . $select . '>' . $text . '</option>';
}

function generateInput($header, $text, $var, $offset = 0) {
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
     
    echo '<tr><td class="itemconfig">';
    printOffset($offset);
    echo $header;
    generateCacheWarning($text);
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<input '.$class.' type="text" onblur="checkChars(this);" name="' . $text . '" value="' . $var . '" size=25>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateInputNumber($header, $text, $var, $offset = 0)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    printOffset($offset);
    echo $header;
    generateCacheWarning($text);
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<input type="text" '.$class.' onblur="checkNumber(this);" name="' . $text . '" value="' . $var . '" size=25>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateTrueFalse($header, $text, $var, $offset = 0)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    printOffset($offset);
    echo $header;
    generateCacheWarning($text);
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption($GLOBALS["config_messages"]["true"], "true", $var, 1);
    generateOption($GLOBALS["config_messages"]["false"], "false", $var, 0);
    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateTopBottom($header, $text, $var, $offset = 0)
{
   $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    printOffset($offset);
    echo $header;
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption($GLOBALS["config_messages"]["top"], "top", $var);
    generateOption($GLOBALS["config_messages"]["bottom"], "bottom", $var);
    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateFlashHtml($header, $text, $var, $offset = 0)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    printOffset($offset);
    echo $header;
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption("Flash", "flash", $var);
    generateOption("Html", "html", $var);
    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateSlideshowType($header, $text, $var)
{
$class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;"  class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    echo $header;
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption($GLOBALS["config_messages"]["optimized"], "TRUE", $var);
    generateOption($GLOBALS["config_messages"]["normal"], "FALSE", $var);
    generateOption($GLOBALS["config_messages"]["maximized"], "FULL", $var);
    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateSlideshowTime($header, $text, $var)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    echo $header;
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption("3 s", "3", $var);
    generateOption("5 s", "5", $var);
    generateOption("10 s", "10", $var);
    generateOption("20 s", "20", $var);
    generateOption("30 s", "30", $var);
    generateOption("60 s", "60", $var);

    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateNumberPics($header, $text, $var, $offset = 0)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
     printOffset($offset);
    echo $header;
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption("3", "3", $var);
    generateOption("5", "5", $var);
    generateOption("7", "7", $var);
    generateOption("9", "9", $var);
    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateSkin($header, $text, $var)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    echo $header;
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption($GLOBALS["config_messages"]["noskin"], '', $var);
    
    // we read all php files from the skin folder and display the name file name of the skin here.
    // if it is set in the language file, the text from the language file is used.  
    foreach (twg_glob("../skins/*.php") as $filename) {
      $name = basename ($filename,".php"); 
      if (isset($GLOBALS["config_messages"][$name])) {
        $display_text = $GLOBALS["config_messages"][$name];
      } else {        
        $display_text = ucwords(strtolower(str_replace('_',' ',$name))); 
      }
      generateOption($display_text, $name, $var);
    }
  

    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateIconset($header, $text, $var)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    echo $header;
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >'; 
    // we read all php files from the skin folder and display the name file name of the skin here.
    // if it is set in the language file, the text from the language file is used.  
    foreach (glob("../buttons/iconsets/*") as $dirname) {
      if (is_dir($dirname)) { 
      $name =  basename ($dirname); 
      if (isset($GLOBALS["config_messages"][$name])) {
        $display_text = $GLOBALS["config_messages"][$name];
      } else {        
        $display_text = ucwords(strtolower(str_replace('_',' ',$name))); 
      }
      generateOption($display_text, $name, $var);
      }
    }
  

    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}




function generateTrueFalseBig($header, $text, $var)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    echo $header;
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption($GLOBALS["config_messages"] ["true"], "TRUE", $var);
    generateOption($GLOBALS["config_messages"] ["false"], "FALSE", $var);
    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateFolderDrop($header, $text, $var)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    echo $header;
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption($GLOBALS["config_messages"] ["fade"], "fade", $var);
    generateOption($GLOBALS["config_messages"] ["grey"], "grey", $var);
    generateOption($GLOBALS["config_messages"] ["change"], "change", $var);
    generateOption($GLOBALS["config_messages"] ["none"], "none", $var);
    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateDefaultNavigation($header, $text, $var, $offset = 0)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
     printOffset($offset);
    echo $header;
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    
    generateOption("Flash", "FLASH", $var);
    generateOption("Ajax", "DHTML", $var);
    generateOption("HTML", "HTML", $var);
    generateOption($GLOBALS["config_messages"] ["htmlside"], "HTML_SIDE", $var);
    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generatePosition($header, $text, $var, $offset = 0)
{
    $class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    echo $header;
    generateCacheWarning($text);
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption($GLOBALS["config_messages"] ["topleft"], 1, $var);
    generateOption($GLOBALS["config_messages"] ["topcenter"], 2, $var);
    generateOption($GLOBALS["config_messages"] ["topright"], 3, $var);
    generateOption($GLOBALS["config_messages"] ["middleleft"], 4, $var);
    generateOption($GLOBALS["config_messages"] ["middlecenter"], 5, $var);
    generateOption($GLOBALS["config_messages"] ["middleright"], 6, $var);
    generateOption($GLOBALS["config_messages"] ["bottomleft"], 7, $var);
    generateOption($GLOBALS["config_messages"] ["bottomcenter"], 8, $var);
    generateOption($GLOBALS["config_messages"] ["bottomright"], 9, $var);
    echo '</select>';
    echo '</td></tr>';
}

function generateAutoRotate($header, $text, $var)
{
$class = (checkMainConfig($text,$var)) ? 'class="isdefault" ' : ' style="color:#0000ff;" class="notdefault" ';
    
    echo '<tr><td class="itemconfig">';
    echo $header;
    generateCacheWarning($text);
    echo '</td><td class="itemrightconfig" align="left">';
    echo '<select '.$class.' name="' . $text . '" >';
    generateOption($GLOBALS["config_form_block"]["autorotate_images_none"], "", $var);
    generateOption($GLOBALS["config_form_block"]["autorotate_images_normal"], "normal", $var);
    generateOption($GLOBALS["config_form_block"]["autorotate_images_invert"], "invert", $var);
    echo '</select>';
    generateHelp($text);
    echo '</td></tr>';
}

function generateHelp($id)
{
    echo "</td><td>";
    echo '&nbsp;<img alt="" ';
    writeHelp($id);
    echo '  src="_img/help.gif">';
}

function generateCacheWarning($id)
{
    if ($id == 'small_pic_size' || $id == 'resize_only_if_too_big' || 
    $id == 'use_small_pic_size_as_height' || $id == 'thumb_pic_size' || 
    $id == 'show_clipped_images' || $id == 'print_text' || $id == 'autorotate_images' ||
    $id == 'text' ||  $id == 'watermark_small' ||  $id == 'position') {
        echo '&nbsp;<img class="sprites warning_gif" style="margin-bottom:-3px;" alt="" ';
        writeHelp('delete_cache');
        echo ' src="_img/_.gif">';
        // echo '<div class="sprites warning_gif" style="float:right;"';
        // echo writeHelp('delete_cache');
        // echo '></div>';
        
        
    }
}

/**
 * * ensure this file is being included by a parent file
 */
defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');

$message = "";

if ($helper_action == "storemyconfig") {
    $message = storemyconfig();
    if ($message == 'OK' ) {
      $message = $GLOBALS["config_messages"] ["configsaved"];
    }
    $file = "../my_config.php";
    if (file_exists($file)) {
        include ($file);
    }
}

if ($helper_action == "deletemyconfig") {
    deletemyconfig();
    $message = $GLOBALS["config_messages"] ["configdeleted"];
    $file = "../config.php";
    if (file_exists($file)) {
        include ($file);
    }
}

if ($helper_action == "deldebugfile") {
    if (file_exists($debug_file)) {
        unlink($debug_file);
        $message = $GLOBALS["config_messages"] ["debugdeleted"];
    } else {
        $message = $GLOBALS["config_messages"] ["nodebugfound"];
    }
}

if ($helper_action == "delimagecache") {
    delete_image_cache();
    $message = $GLOBALS["config_messages"] ["cashdeleted"];
}

if ($helper_action == "delrotfile") {
    delete_rotation_cache();
    $message = $GLOBALS["config_messages"] ["rotationdeleted"];
}

if ($helper_action == "delsession") {
    invalidateSession();
    header("Location: " . make_link('logout', $dir, null));
    exit;
}

if ($helper_action == "genpreviews") {
    generateOtherFormatsPreview("../" . $basedir);
    delete_tmp_cache();
    $message = $GLOBALS["config_messages"] ["previmagegen"];
}

if ($helper_action == "readiptc") {
    $input_invalid = true;
    include ("../inc/readxml.inc.php");
    $xmldir = "../" . $xmldir;
    $basedir = "../" . $basedir;
    extractIptc($basedir);
    $message = $GLOBALS["config_messages"] ["readiptcmessage"];
}

?>
<script type="text/javascript" language="Javascript" src="_js/overlib_mini.js"></script>

<?php
  show_twg_header();
?>
<div id="ctr" align="center">
<div class="install round_borders">
<div id="step"><?php echo $GLOBALS["config_screen"] ["twgconfig"]; ?></div>
<div class="clr"></div>
<?php
if ($message != "") {
    echo "<span class='message'>" . $message . "</span>";
    echo "<div class='clr'></div></br>";
}
?>
<?php echo $GLOBALS["config_screen"] ["Onthispage"]; ?>

<h1><a name="config"></a>
<?php echo $GLOBALS["config_screen"] ["configtwg"]; ?></h1>
<div class="install-text">
<?php echo $GLOBALS["config_screen"] ["inthissection"]; ?><br>&nbsp;<br>
<?php echo $GLOBALS["config_screen"] ["pleasread"]; ?> <a class="aconfig" target="_blank"  href="http://www.tinywebgallery.com/en/faq.php">how-to's</a>
<?php echo $GLOBALS["config_screen"] ["becauseyou"]; ?>
<div class="ctr"></div>
</div>
<form name="config_form" action="index.php" method="post">
  <input type="hidden" name="token" value="<?php echo md5(session_id()); ?>"> 
	<input type="hidden" name="action" value="helper">
	<input type="hidden" name="twg_helper_action" value="storemyconfig">
<?php
$store_set = true;
if (file_exists("../my_config.php")) {
    if (is_writeable("../my_config.php")) {
        $store_set = false;
    }
} else {
    $store_set = false;
}

if ($store_set) {
    echo "<center><div class='error'>" .
	$GLOBALS["config_screen"] ["confignotwr"] ."</div></center>";
} else if (!testParentdir()) {
    echo "<center><div class='error'>" .
	$GLOBALS["config_screen"] ["mainfolnotwr"] ."</div></center>";
    $storeset = true;
}

?>
<div class="install-form">
<img src="_img/_.gif" alt="" height="7"><br/>
<div id="form1h" class="form-block-menu-sel" onClick="showform('form1')">
<?php echo $GLOBALS['config_form_block'] ["induvidual"]; ?></div>&nbsp;
<div id="form2h"  class="form-block-menu" onClick="showform('form2')">
<?php echo $GLOBALS['config_form_block'] ["image"]; ?></div>&nbsp;
<div id="form3h" class="form-block-menu" onClick="showform('form3')">
<?php echo $GLOBALS['config_form_block'] ["fuctionality"]; ?></div>&nbsp;
<div id="form4h" class="form-block-menu" onClick="showform('form4')">
<?php echo $GLOBALS['config_form_block'] ["watermark"]; ?></div>&nbsp;
<div id="form5h"  class="form-block-menu" onClick="showform('form5')">
<?php echo $GLOBALS['config_form_block'] ["additional"]; ?></div>
<br/><img src="_img/_.gif" alt="" height="6"><br/>
<div class="form-block" id="form1">
<table summary="" class="content">
 <colgroup>
    <col width="310">
    <col width="145">
    <col width="20">
  </colgroup>
<tr><td colspan=2 class="configheader">
<?php echo $GLOBALS['config_form_block'] ["indivisettings"]; ?></td></tr>
<tr><td colspan=2>
<?php echo $GLOBALS['config_form_block'] ["changepassw"]; ?><a class="aconfig" target="_blank"  href="http://www.tinywebgallery.com/en/configuration.php">
<?php echo $GLOBALS['config_form_block'] ["changepasswl"]; ?></a>
<?php echo $GLOBALS['config_form_block'] ["changepasswll"]; ?><br>&nbsp;</td></tr>
<?php
generateTrueFalse($GLOBALS['config_form_block'] ["enablesess"], "cache_dirs", $cache_dirs);
generateInput($GLOBALS['config_form_block'] ["protgalpassw"], "privatepassword", $privatepassword);
generateInput($GLOBALS['config_form_block'] ["broutitlperf"], "browser_title_prefix", $browser_title_prefix);
generateInput($GLOBALS['config_form_block'] ["defgaltit"], "default_gallery_title", $default_gallery_title);

$linklang = ($GLOBALS["language"] == 'de') ? 'de':'en';
$more = ' <small><a class="aconfig" target="_blank" href="'.$GLOBALS["twg_home_url"]. '/' . $linklang .'/addon_skins.php">' . $GLOBALS["config_form_block"]["link_more"] . '</a></small>';
generateSkin( $GLOBALS['config_form_block'] ["skin"] . ' ' . $more , "skin", $skin);

$more = ' <small><a class="aconfig" target="_blank" href="'.$GLOBALS["twg_home_url"]. '/' . $linklang .'/addon_icons.php">' . $GLOBALS["config_form_block"]["link_more"] . '</a></small>';
generateTrueFalse($GLOBALS['config_form_block'] ["use_round_corners"], "use_round_corners", $use_round_corners,1);
generateIconset($GLOBALS['config_form_block'] ["icon_set"] . ' ' . $more, "icon_set", $icon_set);
// generateTrueFalse($GLOBALS['config_form_block'] ["twgincl"], "iframe_include", $iframe_include);
generateInput($GLOBALS['config_form_block'] ["heiiframe"], "iframe_height_ie", $iframe_height_ie);
generateTrueFalseBig($GLOBALS['config_form_block'] ["shwbord"], "show_border", $show_border);
generateTrueFalse($GLOBALS['config_form_block'] ["shwtwglogo"], "show_twg_logo_if_registered", $show_twg_logo_if_registered);
generateTrueFalse($GLOBALS['config_form_block'] ["enablebasicseo"], "enable_basic_seo", $enable_basic_seo);
?>
<tr><td colspan=2 class="configheader"><br/>
<?php echo $GLOBALS['config_form_block'] ["adminsettings"]; ?><br/> <br/></td></tr>
<?php
generateFlashHtml($GLOBALS['config_form_block'] ["adminupload"], "admin_default_upload_method", $admin_default_upload_method);
generateTrueFalse($GLOBALS['config_form_block'] ["adminenablesplit"], "admin_enable_split", $admin_enable_split);
generateTrueFalse($GLOBALS['config_form_block'] ["adminchecksplit"], "admin_file_split_is_tested", $admin_file_split_is_tested,2);

?>
</table>
</div>
<div class="form-block" id="form2" style="display:none">
<noscript>
</div><div class="form-block" id="form2a">
</noscript>
<table summary="" class="content">
 <colgroup>
    <col width="310">
    <col width="145">
    <col width="20">
  </colgroup>
<tr><td colspan=2 class="configheader">
<?php echo $GLOBALS['config_form_block'] ["imagesett"]; ?></td></tr>
<tr><td colspan=2>
<?php echo $GLOBALS['config_form_block'] ["adjuimagdis"]; ?> <a class="aconfig" target="_blank"  href="http://www.tinywebgallery.com/en/configuration.php">
<?php echo $GLOBALS['config_form_block'] ["adjuimagdisl"]; ?></a>
<?php echo $GLOBALS['config_form_block'] ["adjuimagdisll"]; ?></td></tr>
<?php
generateInputNumber($GLOBALS['config_form_block'] ["columon"], "menu_x", $menu_x);
generateInputNumber($GLOBALS['config_form_block'] ["rowson"], "menu_y", $menu_y);
generateTrueFalse($GLOBALS['config_form_block'] ["autodetnu"], "autodetect_maximum_thumbnails", $autodetect_maximum_thumbnails);
generateInputNumber($GLOBALS['config_form_block'] ["thumbinrow"], "thumbnails_x", $thumbnails_x,1);
generateInputNumber($GLOBALS['config_form_block'] ["thumbincol"], "thumbnails_y", $thumbnails_y,1);
generateInputNumber($GLOBALS['config_form_block'] ["imageintop"], "number_top10", $number_top10);
generateInputNumber($GLOBALS['config_form_block'] ["sizewebima"], "small_pic_size", $small_pic_size);
generateTrueFalse($GLOBALS['config_form_block'] ["resizeima"], "resize_only_if_too_big", $resize_only_if_too_big, 1);
generateTrueFalse($GLOBALS['config_form_block'] ["usesizeofweb"], "use_small_pic_size_as_height", $use_small_pic_size_as_height, 1);
generateInputNumber($GLOBALS['config_form_block'] ["sizeofthumb"], "thumb_pic_size", $thumb_pic_size);
generateInputNumber($GLOBALS['config_form_block'] ["sizeofthumbdet"], "strip_thumb_pic_size", $strip_thumb_pic_size);
generateInputNumber($GLOBALS['config_form_block'] ["widthofgal"], "menu_pic_size_x", $menu_pic_size_x);
generateInputNumber($GLOBALS['config_form_block'] ["heightofgal"], "menu_pic_size_y", $menu_pic_size_y);
generateTrueFalse($GLOBALS['config_form_block'] ["clipthethumb"], "show_clipped_images", $show_clipped_images);
generateTrueFalse($GLOBALS['config_form_block'] ["showacol"], "show_colage", $show_colage);
generateTrueFalse($GLOBALS['config_form_block'] ["userandom"], "use_random_image_for_folder", $use_random_image_for_folder);
generateFolderDrop($GLOBALS['config_form_block'] ["foldereffect"], "folder_effect", $folder_effect);
generateTrueFalse($GLOBALS['config_form_block'] ["skip_thumbnail_page"], "skip_thumbnail_page", $skip_thumbnail_page);
generateTrueFalse($GLOBALS['config_form_block'] ["skipthumb"] . $numberofpics . $GLOBALS['config_form_block'] ["skipthumbpic"], "auto_skip_thumbnail_page", $auto_skip_thumbnail_page);
generateAutoRotate($GLOBALS['config_form_block'] ["autorotate_images"], "autorotate_images", $autorotate_images);
?>
</table>
</div>
<div class="form-block" id="form3" style="display:none">
<noscript>
</div><div class="form-block" id="form3a">
</noscript>
<table summary="" class="content">
 <colgroup>
    <col width="310">
    <col width="145">
    <col width="20">
  </colgroup>
<tr><td colspan=2 class="configheader">
<?php echo $GLOBALS['config_form_block'] ["endisablefunc"]; ?></td></tr>
<tr><td colspan=2>
<?php echo $GLOBALS['config_form_block'] ["youendisablefunc"]; ?><a class="aconfig" target="_blank"  href="http://www.tinywebgallery.com/en/configuration.php">
<?php echo $GLOBALS['config_form_block'] ["installpage"]; ?></a>
<?php echo $GLOBALS['config_form_block'] ["storethem"]; ?><br>&nbsp;<br></td></tr>
<?php
generateTrueFalseBig($GLOBALS['config_form_block'] ["hidebignav"], "show_only_small_navigation", $show_only_small_navigation);
generateDefaultNavigation ($GLOBALS['config_form_block'] ["defaubignav"], "default_big_navigation", $default_big_navigation,1);
generateTopBottom($GLOBALS['config_form_block'] ["big_nav_pos"], "big_nav_pos", $big_nav_pos,2);
generateNumberPics($GLOBALS['config_form_block'] ["numberofpics"], "numberofpics", $numberofpics,2);
generateTrueFalse($GLOBALS['config_form_block'] ["noscrolling"], "autodetect_noscoll", $autodetect_noscoll, 2);
generateTrueFalse($GLOBALS['config_form_block'] ["dhtmlworks"], "use_nonscrolling_dhtml", $use_nonscrolling_dhtml, 2);
generateTrueFalse($GLOBALS['config_form_block'] ["showcomment"], "show_comments", $show_comments);
generateTrueFalse($GLOBALS['config_form_block'] ["showlogin"], "show_login", $show_login);
generateTrueFalse($GLOBALS['config_form_block'] ["showoptions"], "show_optionen", $show_optionen);
generateTrueFalse($GLOBALS['config_form_block'] ["shownwewin"], "show_new_window", $show_new_window);
generateTrueFalse($GLOBALS['config_form_block'] ["enabledownl"], "enable_download", $enable_download);
generateTrueFalse($GLOBALS['config_form_block'] ["showimagerat"], "show_image_rating", $show_image_rating);
generateTrueFalse($GLOBALS['config_form_block'] ["showsearch"], "show_search", $show_search);
generateTrueFalse($GLOBALS['config_form_block'] ["show_topx"], "show_topx", $show_topx);
generateTrueFalse($GLOBALS['config_form_block'] ["show_tags"], "show_tags", $show_tags);
generateTrueFalse($GLOBALS['config_form_block'] ["showpublic"], "show_public_admin_link", $show_public_admin_link);
generateTrueFalse($GLOBALS['config_form_block'] ["showslidesh"], "show_slideshow", $show_slideshow);
generateSlideshowType($GLOBALS['config_form_block'] ["slideshowty"], "twg_slide_type", $twg_slide_type);
generateSlideshowTime($GLOBALS['config_form_block'] ["slideshowti"], "twg_slideshow_time", $twg_slideshow_time);
generateTrueFalse($GLOBALS['config_form_block'] ["showcapt"], "show_captions", $show_captions);
generateTrueFalse($GLOBALS['config_form_block'] ["showthecount"], "show_counter", $show_counter);
generateTrueFalse($GLOBALS['config_form_block'] ["showhelpl"], "show_help_link", $show_help_link);
generateTrueFalse($GLOBALS['config_form_block'] ["showtitleinf"], "show_enhanced_file_infos", $show_enhanced_file_infos);
generateTrueFalse($GLOBALS['config_form_block'] ["showrotbut"], "show_rotation_buttons", $show_rotation_buttons);
generateTrueFalse($GLOBALS['config_form_block'] ["showbandwico"], "show_bandwidth_icon", $show_bandwidth_icon);
generateTrueFalse($GLOBALS['config_form_block'] ["open_in_maximized_view"], "open_in_maximized_view", $open_in_maximized_view);
generateTrueFalse($GLOBALS['config_form_block'] ["disable_tips"], "disable_tips", $disable_tips);
if (b()) {
  generateTrueFalse($GLOBALS['config_form_block'] ["enable_album_tree"], "enable_album_tree", $enable_album_tree);
}
echo '<tr><td colspan=2 class="configheader"><br/>' . $GLOBALS['config_form_block'] ["sort_header"] . '<br/></td></tr>';
echo '<tr><td colspan="2" class="itemconfig">' . $GLOBALS['config_form_block'] ['sort_text'] . '<br>&nbsp;</td></tr>';

generateTrueFalse($GLOBALS['config_form_block'] ["sort_images_ascending"], "sort_images_ascending", $sort_images_ascending);
generateTrueFalse($GLOBALS['config_form_block'] ["sort_by_date"], "sort_by_date", $sort_by_date);
generateTrueFalse($GLOBALS['config_form_block'] ["sort_by_filedate"], "sort_by_filedate", $sort_by_filedate);
generateTrueFalse($GLOBALS['config_form_block'] ["sort_albums"], "sort_albums", $sort_albums);
generateTrueFalse($GLOBALS['config_form_block'] ["sort_albums_ascending"], "sort_albums_ascending", $sort_albums_ascending);
generateTrueFalse($GLOBALS["config_form_block"] ["sort_album_by_date"], "sort_album_by_date", $sort_album_by_date);
?>
</table>
</div>
<div class="form-block" id="form4" style="display:none">
<noscript>
</div><div class="form-block" id="form4a">
</noscript>
<table summary="" class="content">
 <colgroup>
    <col width="310">
    <col width="145">
    <col width="20">
  </colgroup>
<tr><td colspan=2 class="configheader">
<?php echo $GLOBALS['config_form_block'] ["watermarkset"]; ?></td></tr>
<tr><td colspan=2>
<?php echo $GLOBALS['config_form_block'] ["configwmset"]; ?><a class="aconfig" target="_blank"  href="http://www.tinywebgallery.com/en/configuration.php">
<?php echo $GLOBALS['config_form_block'] ["configwmsetl"]; ?></td></tr>
<?php
generateTrueFalse($GLOBALS['config_form_block'] ["printtextwm"], "print_text", $print_text);
generateTrueFalse($GLOBALS['config_form_block'] ["printtextwmo"], "print_text_original", $print_text_original);
generateInput($GLOBALS['config_form_block'] ["wmtext"], "text", $text, 1);
generateTrueFalse($GLOBALS['config_form_block'] ["prntimgwm"], "print_watermark", $print_watermark);
generateTrueFalse($GLOBALS['config_form_block'] ["prntimgwmo"], "print_watermark_original", $print_watermark_original);
generateInput($GLOBALS['config_form_block'] ["normwm"], "watermark_small", $watermark_small, 1);
generateInput($GLOBALS['config_form_block'] ["wmfororig"], "watermark_big", $watermark_big, 1);
generatePosition($GLOBALS['config_form_block'] ["posimawm"], "position", $position);

?>
</table>
</div>
<div class="form-block" id="form5" style="display:none">
<noscript>
</div><div class="form-block" id="form5a">
</noscript>
<table summary="" class="content">
 <colgroup>
    <col width="310">
    <col width="145">
    <col width="20">
  </colgroup>
<tr><td colspan=2 class="configheader">
<?php echo $GLOBALS['config_form_block'] ["additsett"]; ?></td></tr>
<tr><td colspan=2>
<?php echo $GLOBALS['config_form_block'] ["twgparamet"]; ?><a class="aconfig" target="_blank"  href="http://www.tinywebgallery.com/en/configuration.php">
<?php echo $GLOBALS['config_form_block'] ["twgparametl"]; ?></a>
<?php echo $GLOBALS['config_form_block'] ["twgparametll"]; ?>$newparam=true;
<?php echo $GLOBALS['config_form_block'] ["twgparametlll"]; ?> $newstring="12345";
<?php echo $GLOBALS['config_form_block'] ["twgparametllll"]; ?><br></td></tr>
<tr><td colspan=2>
<center>
<textarea name="additional" id="additional" style="width:497px;" rows="20">
<?php
if (isset($additional)) {
    $additional = str_replace(";$", ";\n$", stripcslashes($additional));
    echo str_replace("-NL-", "\n", stripcslashes($additional));
}

?>
</textarea>
</center>
</td></tr>
</table>
</div>
<?php
if (!$store_set) {
    ?>
<br>
<p><input name="button" type="button" onClick="if(checkData(document.getElementById('additional'))) { document.config_form.submit();};" class="button" value=" <?php echo $GLOBALS['config_form_block'] ["addsave"]; ?> ">

<noscript>
&nbsp; Please enable Javascript to enable saving of the configuration.
</noscript>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="buttonlink" onclick="return confirm('<?php echo $GLOBALS['config_form_block'] ["reallyreset"]; ?>');" href="index.php?action=helper&amp;twg_helper_action=deletemyconfig"><?php echo $GLOBALS['config_form_block'] ["resetconfig"]; ?></a></p> <br/>
&nbsp;&nbsp;<input type="checkbox" <?php if ($save_only_delta=="on") echo ' checked="checked" '; ?> name="save_only_delta"> <?php echo $GLOBALS['config_form_block'] ["savemod"]; ?>

<?php
}

?></div>
<div class="clr"></div>
</form>
<h1><a name="gen"></a>
<?php echo $GLOBALS["config_screen_main"] ["gentwgcache"]; ?></h1>
<div class="install-text">
<?php echo $GLOBALS["config_screen_main"] ["cachestep"]; ?>
<div class="ctr"></div>
</div>
<div class="install-form">
<div class="form-block">
<table summary="" class="content">
<tr>
	<td class="item2">
	<iframe src="index.php?twg_show_create=true&action=helper_gen<?php echo "&amp;" . session_name() . "=" . session_id(); ?>" frameborder=0 width=490 height=120></iframe>
</tr>
</table>
</div>
</div>
<div class="clr"></div>

<?php // generate the
if (b()) {

    ?>
<h1><a name="gen_preview"></a>
<?php echo $GLOBALS["config_screen_main"] ["generateprev"]; ?></h1>
<div class="install-text">
<img alt="" <?php writehowto(41); ?> align=right src="_img/help.gif">
<?php echo $GLOBALS["config_screen_main"] ["displfilefor"]; ?>
<div class="ctr"></div>
</div>
<div class="install-form">
<div class="form-block">
<table summary="" class="content">
<tr>
	<td class="item2">
<?php echo $GLOBALS["config_screen_main"] ["generatedimag"]; ?>
	</td>
	<td class="itemright" align="left">
	<a class="buttonlink" onclick="return confirm('<?php echo $GLOBALS["config_screen_main"] ["folderscontai"]; ?>');" href="index.php?action=helper&amp;twg_helper_action=genpreviews"><?php echo $GLOBALS["config_screen_main"] ["generateprevl"]; ?></a>
	</td>
</tr>
</table>
</div>
</div>
<div class="clr"></div>
<?php
}

?>


<h1><a name="gen_iptc"></a>
<?php echo $GLOBALS["config_screen_main"] ["generateiptc"]; ?></h1>
<div class="install-text">
<img alt="" <?php writehowto(38); ?> align=right src="_img/help.gif">
<?php echo $GLOBALS["config_screen_main"] ["iptcleft"]; ?>
<div class="ctr"></div>
</div>
<div class="install-form">
<div class="form-block">
<table summary="" class="content">
<tr>
	<td class="item2">
<?php echo $GLOBALS["config_screen_main"] ["iptctext"]; ?>
	</td>
	<td class="itemright" align="left">
	<a class="buttonlink" onclick="return confirm('<?php echo $GLOBALS["config_screen_main"] ["iptcjs"]; ?>');" href="index.php?action=helper&amp;twg_helper_action=readiptc"><?php echo $GLOBALS["config_screen_main"] ["iptcbutton"]; ?></a>
	</td>
</tr>
</table>
</div>
</div>
<div class="clr"></div>



<h1><a name="clean"></a>
<?php echo $GLOBALS["config_screen_main"] ["cleancache"]; ?></h1>
<div class="install-text">
<?php echo $GLOBALS["config_screen_main"] ["makeanychange"]; ?>
<div class="ctr"></div>
</div>
<div class="install-form">
<div class="form-block">
<table summary="" class="content">
<tr>
	<td class="item2">
<?php echo $GLOBALS["config_screen_main"] ["chananyfile"]; ?>
	</td>
	<td class="itemright" align="left">
	<a class="buttonlink" onclick="return confirm('<?php echo $GLOBALS["config_screen_main"] ["reallydelcac"]; ?>');" href="index.php?action=helper&amp;twg_helper_action=delimagecache"><?php echo $GLOBALS["config_screen_main"] ["delimacache"]; ?></a>
	</td>
</tr>
<tr>
	<td class="item2">
<?php echo $GLOBALS["config_screen_main"] ["ifimagerot"]; ?>
	</td>
	<td class="itemright" align="left">
	<a class="buttonlink" onclick="return confirm('<?php echo $GLOBALS["config_screen_main"] ["reallydelrot"]; ?>');" href="index.php?action=helper&amp;twg_helper_action=delrotfile"><?php echo $GLOBALS["config_screen_main"] ["delrotinf"]; ?></a>
	</td>
</tr>
<tr>
	<td class="item2">
<?php echo $GLOBALS["config_screen_main"] ["dirstruccas"]; ?>
	</td>
	<td class="itemright" align="left">
	<a class="buttonlink" onclick="return confirm('<?php echo $GLOBALS["config_screen_main"] ["reallydelses"]; ?>');" href="index.php?action=helper&amp;twg_helper_action=delsession"><?php echo $GLOBALS["config_screen_main"] ["delsescac"]; ?></a>
	</td>
</tr>
<!-- will be activated the next version
<tr>
	<td class="item2">
	Delete the three caches described above.<br/>&nbsp;
	</td>
	<td class="itemright" align="left">
	<a class="buttonlink" href="aaa">Delete All Caches</a>
	</td>
</tr>
-->
</table>
</div>
</div>
<div class="clr"></div>
<h1><a name="pass"></a><?php echo $GLOBALS["config_screen_main"] ["genencrpass"]; ?></h1>
<div class="install-text">
<img alt="" <?php writehowto(12);
?> align=right src="_img/help.gif"><?php echo $GLOBALS["config_screen_main"] ["usepasswprot"]; ?>
<div class="ctr"></div>
</div>
<div class="install-form">
<div class="form-block">
<table summary="" class="content">
<tr>
	<td class="item2">
	<br/>&nbsp;<br/><?php echo $GLOBALS["config_screen_main"] ["enterpassw"]; ?>
	</td>
	<td class="itemright" align="left">
	<form action="index.php#pass" method="post">
  <input type="hidden" name="token" value="<?php echo md5(session_id()); ?>"> 
	<input type="hidden" name="action" value="helper">
	<input type="hidden" name="twg_helper_action" value="genpass">
	<input name="password" type="text" size="15" maxlength="30"><br/>&nbsp;<br/>
	<input name="button" type="submit" class="button" value="<?php echo $GLOBALS["config_screen_main"] ["generate"]; ?>">
</form>
	</td>
</tr>
<tr>
	<td colspan=2>
<?php
if (isset($_POST['password'])) {
    echo "<br>";
    if (function_exists("sha1") && $use_sha1_for_password) {
        echo $GLOBALS["config_screen_main"] ["shahashval"] . $_POST['password'] . "': '" . sha1($_POST['password']) . "'";
    } else {
        if (!function_exists("sha1") && $use_sha1_for_password) {
            echo $GLOBALS["config_screen_main"] ["shahashvalde"];
        }
        echo "SHA256 hash value '" . $_POST['password'] . "': '" . sha2($_POST['password']) . "'";
    }
}

?>
	<br>&nbsp;<br>
	<?php echo $GLOBALS["config_screen_main"] ["copygenval"]; ?>
	</td>
</tr>

</table>
</div>
</div>
<div class="clr"></div>

<h1><a name="debug"></a><?php echo $GLOBALS["config_screen_main"] ["debugfile"]; ?></h1>
<div class="install-text">
<?php echo $GLOBALS["config_screen_main"] ["twgdocreat"]; ?>
<div class="ctr"></div>
</div>
<div class="install-form">
<div class="form-block">
<table summary="" class="content">
<tr>
	<td class="item2">
	<br/>
	<?php echo $GLOBALS["config_screen_main"] ["deldebugfile"]; ?><br/>&nbsp;<br/>&nbsp;<br/>
	</td>
	<td class="itemright" align="left">
	<br/>
	<a class="buttonlink" onclick="return confirm('<?php echo $GLOBALS["config_screen_main"] ["reallydeldefi"]; ?>');" href="index.php?action=helper&amp;twg_helper_action=deldebugfile"><?php echo $GLOBALS["config_screen_main"] ["delete"]; ?></a>
	</td>
</tr>
<tr><td colspan=2><center><textarea class="debugarea" rows=10>
<?php
if (file_exists($debug_file)) {
    include ($debug_file);
} else {
    echo $GLOBALS["config_screen_main"] ["nodefifou"];
}

?>
</textarea></center>
</td></tr>
</table>
</div>
</div>
<div class="clr"></div>
</div>
</div>