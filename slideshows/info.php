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
require "config.php";

$php_include=false;       
$install_dir = "";

@session_start();
if ($try_to_increase_memory_limit_to_32MB) {
  @ini_set('memory_limit', '32M');
}

/**
 * A small helper function !
 */
function return_kbytes($val)
{
    $val = trim($val);
    if (strlen($val) == 0) {
        return 0;
    }
    $last = strtolower($val{strlen($val)-1});
    switch ($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1;
    }
    return $val;
}

/**
 * get maximum upload size
 */
function getMaximumUploadSize()
{
    $upload_max = return_kbytes(ini_get('upload_max_filesize'));
    $post_max = return_kbytes(ini_get('post_max_size'));
    return $upload_max < $post_max ? $upload_max : $post_max;
}

if (function_exists('date_default_timezone_set')) { // php 5.1.x
        if ($timezone != '') {
          @date_default_timezone_set($timezone);
        } else if (function_exists('date_default_timezone_get')) {
          ob_start();
          @date_default_timezone_set(@date_default_timezone_get());
          ob_end_clean();
        } else {
          @date_default_timezone_set('Europe/Berlin');
        }
}


$showphpinfo = false;;

function get_server_name() {
  $domain = $_SERVER['HTTP_HOST'];
  $port = strpos($domain, ':');
  if ( $port !== false ) $domain = substr($domain, 0, $port); 
  return $domain;
}


function execute_command ($command) {
  global $use_shell_exec, $admin_enable_cmd_checks;
  
  $hasCom = true;
  
  ob_start();
  if ($admin_enable_cmd_checks) {
    if (substr(@php_uname(), 0, 7) == "Windows"){
           // shell_exec($command); // - opens a window! therefore I don't use it
           // Make a new instance of the COM object
    		    if (!class_exists('COM')) {
               $WshShell = new COM("WScript.Shell");
      		     // Make the command window but dont show it.
      	       $oExec = $WshShell->Run("cmd /C " . $command, 0, true);
            } else {
             $hasCom = false;
              } 
    } else {
        if ($use_shell_exec) {
            shell_exec($command);
         } else {
    	      exec($command . " > /dev/null");
         }   
    }	
  }
  ob_end_clean();
  
  if (!$hasCom) {
  echo "From PHP 5.4.5, COM and DOTNET is no longer built into the php core. You have to add COM support in php.ini. Add the line extension=php_com_dotnet.dll to your php.ini.<br />";
           
  }
}

function get_php_setting($val) {
	$r =  (ini_get($val) == '1' ? 1 : 0);
	return $r ? 'ON' : 'OFF';
}

function get_php_setting_val($val) {
	$r =  ini_get($val);
	return $r;
}

function return_bytes($val) {
    if ($val) {
      $val = trim($val);
      $last = strtolower($val{strlen($val)-1});
      switch($last) {
        case 'm':
          $val *= 1024;
        case 'k':
          $val *= 1024;
      }
    }
    return $val;
}

function writableTree( $folder ) {
global $xmldir;
echo '<tr>';
	echo '<td class="item">' . $folder;
	echo '/'; 
	echo '</td>';
	echo '<td align="left">'; 
	if (print_tree("../" . $folder) == 0) {
	echo '<b><font color="green">All sub directories are writable</font></b>';
	} else {
	 echo "<b><font color='red'><br>Not all sub directories are writable.<br>Please go to the TWG Admin -> Info for more details!</font></b>";
	}
	echo '</tr>';
}

/* 
   Counts the number of jpegs in all trees
*/
function print_tree($file_dir)
{
  global $password_file;
  global $url_file;
  global $exclude_directories;

  $localfiles = 0;
    if ($handle = @opendir($file_dir)){
      $i = 0;
      $list = null;
      while (false !== ($file = @readdir($handle))){
        if ($file != "." && $file != ".."){
          $list[$i] = $file;
          $i++;
        }
      }
      $dir_length = count($list); 
      for($i = 0;$i < $dir_length;$i++){ 
        if (isset($list[$i])){
          if (is_dir($file_dir . "/" . $list[$i])){
            if (!in_array($list[$i], $exclude_directories)){
              if (!is_writeable($file_dir . "/" . $list[$i])) {
							  $localfiles++;
							}
              $localfiles += print_tree($file_dir . "/" . $list[$i]);           
            }
          }
        }
      } 
      closedir($handle);
    }
    return $localfiles;
}



function writableCell( $folder ) {
	echo '<tr>';
	echo '<td class="item">' . $folder . '/</td>';
	echo '<td align="left">';
	if (file_exists($folder)) {
	  echo is_writable( $folder ) ? '<b><font color="green">Writeable</font></b>' : '<b><font color="red">Unwriteable</font></b>' . '</td>';
	} else {
	  echo '<b><font color="red">Not found</font></b>';
	}
	echo '</tr>';
}

function gd_version()
{
    static $gd_version_number = null;
    if ($gd_version_number === null) {
   	   if (function_exists("gd_info")) {
         $info = gd_info();
         $module_info = $info["GD Version"];
         if (preg_match("/[^\d\n\r]*?([\d\.]+)/i",
                $module_info, $matches)) {
            $gd_version_number = $matches[1];
         } else {
              $gd_version_number = 0;
         } 
       } else { // needed before 4.3 !
          ob_start();
          phpinfo(8);
          $module_info = ob_get_contents();
          @ob_end_clean();
          if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i",
                  $module_info, $matches)) {
              $gd_version_number = $matches[1];
          } else {
              $gd_version_number = 0;
          } 
       }  
    } 
    return $gd_version_number;
}


function check_rotation()
{
    global $cachedir, $install_dir;
    $image = $install_dir . "buttons/border.jpg";
	$outputimage = $cachedir . "/_rotation_available.jpg";
    $outputimageerror = $cachedir . "/_rotation_not_available.jpg"; 
    
    if (file_exists($outputimage)) {
    unlink($outputimage);
    }
    if (file_exists($outputimageerror)) {
      unlink($outputimageerror);
    }
		if (!function_exists("imagerotate")) {
				if (function_exists("imagecreatetruecolor")) {
					 $dst = imagecreatetruecolor(50, 37);
					 $fh=fopen($outputimageerror,'w'); // fix for a but in some php - versions - thanks to Anders
				   fclose($fh); 
					 imagejpeg($dst, $outputimageerror, 50);
				}
				return false;
		} else {
				$oldsize = getImageSize($image);
				$src = imagecreatefromjpeg($image);
				$dst = imagecreatetruecolor(50, 37);
				imagecopyresampled($dst, $src, 0, 0, 0, 0, 50, 37, 50, 37);
				$twg_rot = imagerotate($dst, 90, 0);
				$fh2=fopen($outputimage,'w'); // fix for a but in some php - versions - thanks to Anders
				   fclose($fh2); 
				if (!imagejpeg($twg_rot, $outputimage, 50)) {
				    $fh3=fopen($outputimageerror,'w'); // fix for a but in some php - versions - thanks to Anders
				    fclose($fh3); 
						imagejpeg($dst, $outputimageerror, 50);
						return false;
				} else {
						return true;
				} 
		} 
} 


/*
  We check if we can create a image with image magick
*/
function check_image_magic() {
  global $cachedir, $install_dir,$image_magic_path;
    $inputimage = "buttons/info_test.jpg";
    $outputimageerror = $cachedir . "/_image_magick_test.jpg"; 
    
    $outputcachetest = $cachedir . "/_image_magick_test.tmp.php";   
    if (file_exists($outputcachetest)) { // we only check once!
      return false;
    } else {
      $fh=fopen($outputcachetest,'w'); // fix for a but in some php - versions - thanks to Anders
      fclose($fh); 
    }
 
   if (file_exists($outputimageerror)) {
      @unlink($outputimageerror);
    }
   $fh=fopen($outputimageerror,'w'); // fix for a but in some php - versions - thanks to Anders
	 fclose($fh); 
    
	$command = $image_magic_path. " \"" .  realpath($inputimage) . "\" -quality 80 -resize 120x81  \"" . realpath($outputimageerror) . "\""; 
	 execute_command($command);   	
   if (file_exists($outputcachetest)) {
      @unlink($outputcachetest);
  }
	return (file_exists($outputimageerror) && (filesize($outputimageerror) > 0));

}

/*
  We check if we can extract the 1st image of the ffmpeg_test.avi
*/
function check_ffmpeg() {
   global $cachedir, $install_dir,$ffmpeg_path;
   
   $inputimage = "html/ffmpeg_test.avi";
   $outputimageerror = $cachedir . "/_ffmpeg_test.jpg"; 
   
    $outputcachetest = $cachedir . "/_ffmpeg_test.tmp.php";   
    if (file_exists($outputcachetest)) { // we only check once!
      return false;
    } else {
      $fh=fopen($outputcachetest,'w'); // fix for a but in some php - versions - thanks to Anders
      fclose($fh); 
    }
   
   if (file_exists($outputimageerror)) {
         @unlink($outputimageerror);
       }
   $fh=fopen($outputimageerror,'w'); // fix for a but in some php - versions - thanks to Anders
   fclose($fh); 
   $command = $ffmpeg_path . " -y -i \"" .  realpath($inputimage) . "\" -f mjpeg -ss 0 -vframes 1 -an \"" . realpath($outputimageerror) . "\""; 
	    execute_command($command); 
   	  if (file_exists($outputcachetest)) {
      @unlink($outputcachetest);
  }
	return (file_exists($outputimageerror) && (filesize($outputimageerror) > 0));
}

function check_ffmpeg_convert() {
   global $cachedir, $install_dir,$ffmpeg_path,$ffmpeg_convert_command;
   
   $inputimage = "html/ffmpeg_test.avi";
   $outputimageerror = $cachedir . "/_ffmpeg_test.flv"; 
   $outputcachetest = $cachedir . "/_ffmpeg_test_flv.tmp.php";   
    if (file_exists($outputcachetest)) { // we only check once!
      return false;
    } else {
      $fh=fopen($outputcachetest,'w'); // fix for a but in some php - versions - thanks to Anders
      fclose($fh); 
    }
    
   if (file_exists($outputimageerror)) {
         @unlink($outputimageerror);
       }
   $fh=fopen($outputimageerror,'w'); // fix for a but in some php - versions - thanks to Anders
   fclose($fh); 
  
   $command = $ffmpeg_path . " " .  sprintf($ffmpeg_convert_command, realpath($inputimage), realpath($outputimageerror));
   execute_command($command); 
   if (file_exists($outputcachetest)) {
      @unlink($outputcachetest);
   }
	return (file_exists($outputimageerror) && (filesize($outputimageerror) > 0));
}

function show_ffmpeg_video() {
 global $cachedir, $install_dir,$ffmpeg_path,$ffmpeg_convert_command, $install_dir;
  
    $flashtext = '<div id="flashcontent"><div class="noflash">The flash requires at least Flash 6.<br>Please get it <b><a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&promoid=BIOW" target="_blank">here<\/a><\/b>.<\/div><\/div>';
    $movie = $install_dir . "html/mediaplayer.swf?";
		$video_size_x = 30; 
		$video_size_y = 30; 
		$file = "file=../" . $cachedir . "/_ffmpeg_test.flv";
		$auto_param = "autostart=true&icons=false&controlbar=false&repeat=always";
		
		echo '
		<script type="text/javaScript" src="js/swfobject.js"></script>
		<script type="text/javascript">
			 document.write(\'' . $flashtext . '\');
			 var so = new SWFObject("' . $movie . $file . '", "VideoPlayback", "' . $video_size_x . '", "' . $video_size_y . '", "6");
			 so.addParam("FlashVars","' . $auto_param . '");
			 so.addParam("scale","noScale");
			 so.write("flashcontent");
	  </script>';
		// noscript way
		$auto_param = str_replace("&" , "&amp;" , $auto_param); // to make it w3c conform!		
		echo '
		<noscript>	
	<embed style="width:' . $video_size_x . 'px; height:' . $video_size_y . 'px;" id="VideoPlayback" align="middle"
	type="application/x-shockwave-flash" src="' . $movie . $file . '" allowScriptAccess="sameDomain"
	quality="best" bgcolor="#ffffff" scale="noScale" wmode="window" salign="TL"
	FlashVars="showfsbutton=false&amp;playerMode=embedded&amp;fullscreenpage=html/fullscreen.html' . $auto_param . '"></embed>
	</noscript>';
}

if ($showphpinfo) {
echo '<center><p>';
echo "<style>.button { border : solid 1px #cccccc; background: #E9ECEF; color : #666666; font-weight : bold; font-size : 11px; padding: 4px;
}</style>";
 echo '<input type="button" class="button" value="back" onclick="history.back();" />';
 echo '<br>';
 echo phpinfo();
 echo '</p></center>';
 return;
}


echo "<?xml version=\"1.0\" encoding=\"utf-8\"?".">";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TinyWebGallery - Installation check!</title>
<script type="text/javascript">
reload = 1;
function doReload() {
  if (reload == 1) {
    window.location.reload();
  }
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="favicon.ico" >

<style type="text/css">

body {
	margin: 0px;
	padding: 0px;
	color : #333;
	background-color : #FFF;
	font-size : 11px;
	font-family : Arial, Helvetica, sans-serif;
}

#stepbar {
	background-color: #F1F1F1;
	width: 170px !important;
	width: 170px;
	height: 400px;
	font-size: 11px;
	float: left;
	text-align: left;
}

#step {
	font-size: 30px;
	font-weight: bold;
	text-align: left;
	color: #666666;
	padding: 10px 0px 20px 80px;
	white-space: nowrap;
	position: relative;
	float: left;
}

#right {
  float: right;
  width: 555px !important;
  width: 545px;
  border-left: 1px solid #cccccc;
  padding-left: 10px;

}

#break {
	height: 20px;
}

.licensetext {
  text-align: left;
}

.noflash {
  padding:10px;
  margin:10px;
  border: 1px solid #555555;
  background-color: #eeeeee;
  text-align:center;
  width:230px;
}

.noflash a:hover {
text-decoration : none;
}

.license {
  padding: 0px;
  width: 530px;
  height: 300px;
}

.license-form {
  float: left;
}

.install {
	margin-left: auto;
	margin-right: auto;
	margin-top: 3em;
	margin-bottom: 3em;
	padding: 10px;
	border: 1px solid #cccccc;
	width: 750px;
	background: #F1F1F1;
}
	
.install h1, .install h2  {
	font-size: 15px;
	font-weight: bold;
 	color: #c64934;
	padding: 10px 10px 4px 0px;
 	text-align: left;
	border-bottom: 1px solid #c64934;
	margin-bottom: 10px;

}

.install-form {
  position: relative;
	text-align: left;
	float: right;
	width: 69%;
}

.install-text {
  position: relative;
	text-align: left;
	width: 30%;
	float: left;
}

.form-block {
	border: 1px solid #cccccc;
	background: #E9ECEF;
	padding-top: 5px;
	padding-left: 5px;
	padding-bottom: 5px;
	padding-right: 5px;
}

.left {
  position: relative;
	text-align: left;
	float: left;
	width: 50%;
}

.right {
  position: relative;
	text-align: left;
	float: right;
	width: 50%;
}

.far-right {
  position: relative;
	text-align: right;
	float: right;
}

.far-left {
  position: relative; 
	text-align: left;
	float: left;
}

.clr {
    clear:both;
    }

.ctr {
	text-align: center;
}

.button { border : solid 1px #cccccc; background: #E9ECEF; color : #666666; font-weight : bold; font-size : 11px; padding: 4px; }
table.content { width: 90%; }
table.content td { color : #333333; font-size: 11px; vertical-align:top; }
td.item { width:150px; }
table.content2 { width: 90%; }
table.content2 td { color : #333333; font-size: 11px; }
.toggle { font-weight: bold; }
/*  old stuff */
a { color: #C64934; text-decoration: none; }
a:hover { color : #30569D; text-decoration : underline; }
a:active { color : #FF9900; text-decoration : underline; }
.inputbox { color: blue; font-family: Arial, Helvetica, sans-serif; z-index: -3; font-size: 11px; }
.small { color : #333; font-size : 10px; }
.error { color : #cc0000; font-size : 12px; font-weight : bold; padding-top: 10px; padding-bottom: 10px; }
select.options, input.options { font-size: 8pt; border: 1px solid #999; }
form { margin: 0px 0px 0px 0px; }
.dottedline { border-bottom: 1px solid #333; }
.installheader { color : #FFF; font-size : 24px; }
textarea { color : #0000dd; font-family : Arial; font-size : 11px; border: 1px; }

</style>
</head>
<body onLoad="javascript:doReload();">

<div id="ctr" align="center">
<div class="install round_borders">

<div>

<div id="step">TWG info</div>
<div class="far-right">
	<input type="button" class="button" value="Check Again" onclick="window.location=window.location" />
</div><div class="clr"></div>
This check gives a basic check of your installation - Please go to the administration for a more detailed view of this page.

<h3>Please delete this file after installation when everything works fine!</h3>

<h1>TWG installation check for TWG <?php echo $twg_version; ?></h1>
<div class="install-text">
If any of these items are highlighted
in red then please take actions to correct them. Failure to do so
could lead to your TWG installation not functioning
correctly.<br>Yellow means that some functions tests failed and this feature is not available. 
Please go to the info in the administration to get more information to solve the problem! Please don't use red features in the config.php! The config.php is not modified by this check!
<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">

<table class="content">
<tr>
	<td class="item">
	PHP version >= 4.3.0
	</td>
	<td align="left">
	<?php echo phpversion() < '4.3' ? '<b><font color="red">No</font></b>' : '<b><font color="green">Yes</font></b>'; echo " (" . phpversion() . ")"; ?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - XML support
	</td>
	<td align="left">
	<?php echo extension_loaded('xml') ? '<b><font color="green">Available</font></b>' : '<b><font color="red">Unavailable</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - GD lib support
	</td>
	<td align="left">
	<?php echo extension_loaded('gd') ? '<b><font color="green">Available</font></b>' : '<b><font color="red">Unavailable</font></b>';?>
	</td>
</tr>
<tr>
	<td class="item">
	&nbsp; - GD lib >= 2.0
	</td>
	<td align="left">
	<?php echo gd_version() < '2.0' ? '<b><font color="red">No</font></b>' : '<b><font color="green">Yes</font></b>'; echo " (" . gd_version() . ")"; ?>
	</td>
</tr>
<tr>
	<td class="item">
	&nbsp; - imagecreatetruecolor
	</td>
	<td align="left">
	<?php echo (!function_exists("imagecreatetruecolor")) ? '<b><font color="red">GDlib is not installed properly - TWG does not work!</font></b>' : '<b><font color="green">Available</font></b>'; ?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - Memory limit
	</td>
	<td align="left">
	<?php 
	$limit = return_bytes(ini_get('memory_limit'));
	
	if (!$limit) {
	  echo  '<b><font color="orange">Memory limit not detected</font></b>';
	} else {
	if ($limit > 48000000) {
	  echo '<b><font color="green">Very Good</font></b>';
	} else if($limit > 30000000) {
	  echo  '<b><font color="orange">O.k. but don\'t use large images</font></b>';
	} else {
	  echo  '<b><font color="red">Only use small images</font></b>';
	}
  echo " (" . ini_get('memory_limit') . ")"; 
  }
  ?>
	</td>
</tr>
<tr>
	<td class="item">
	&nbsp; - Max resolution
	</td>
	<td align="left">
	<?php 
		if (!$limit) {
		  echo  '<b><font color="green">No limit</font></b>';
	  } else {
	    // internal memory is subtracted 3 MB for normal use. 6 MB if automatic folder image creation is used 
	    $intmem = $autocreate_folder_image ? 3000000 : 6000000;
	    $xy = ($limit-$intmem) / 6.6;
	    $x = floor( sqrt ($xy / 0.75));
	    $y = floor( sqrt($xy / 1.33));
	    
      if ($limit > 48000000) {
	      echo "<b><font color='green'>~ " . $x . " x " . $y . "</font></b>"; 
      } else if($limit > 30000000) {
        echo "<b><font color='orange'>~ " . $x . " x " . $y . "</font></b>"; 
      } else {
        echo "<b><font color='red'>~ " . $x . " x " . $y . "</font></b>"; 
      }   
	  }
	?>	
	</td>
</tr>

<tr>
	<td>
	&nbsp; - Rotate available
	</td>
	<td align="left">
	
	<?php 
	if (file_exists($cachedir) && is_writable( $cachedir )) {
	  echo check_rotation() ? '<b><font color="green">Available</font></b>' : '<b><font color="red">Unavailable</font></b>';
	}else {
	   echo '<b><font color="red">Test failed - Check cache dir</font></b>'; 
	}
	?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - Text watermark 
	</td>
	<td align="left">
	<?php echo (function_exists("imagettftext")) ? '<b><font color="green">Available</font></b>' : '<b><font color="orange">Unavailable (imagettftext not found)</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - Remote jpg support 
	</td>
	<td align="left">
	&nbsp;
	</td>
</tr>
<tr>
	<td>
	 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;fsockopen (<a href="http://www.tinywebgallery.com/en/faq.php#h20" target="_blank">howto</a>)
	</td>
	<td align="left">
      <?php
      if(function_exists('fsockopen')) {
      echo '<b><font color="green">Available</font></b>';
      }
      else {
      echo '<b><font color="red">Not available</font></b>';
      }
      ?>
	</td>
</tr>
<tr>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;allow_url_fopen 
	</td>
	<td align="left">
	<?php echo (get_php_setting('allow_url_fopen') == 'ON') ? '<b><font color="green">Available</font></b>' : '<b><font color="orange">Unavailable (allow_url_fopen = off)</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - File uploads 
	</td>
	<td align="left">
	<?php echo (get_php_setting('file_uploads') == 'ON') ? '<b><font color="green">Available</font></b>' : '<b><font color="orange">Unavailable</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp; - Upload max filesize
	</td>
	<td align="left">
	<?php 
	$limit = getMaximumUploadSize();
	if (!$limit) {
	  echo  '<b><font color="orange">Upload max filesize not detected</font></b>';
	} else {
	if ($limit > 4000) {
			echo '<b><font color="green">' . ini_get('upload_max_filesize') . '</font></b>';
	} else {
	  echo  '<b><font color="orange">' . ini_get('upload_max_filesize') . ' - Resize images > ' . ini_get('upload_max_filesize') . '</font></b>';
	}
  }
  ?> (<a href="http://www.tinywebgallery.com/en/tfu/tfu_faq_4.php" target="_blank">howto</a>)
	</td>
</tr>

<tr>
	<td class="item">
	Session
	</td>
	<td align="left">
	<?php 
	$_SESSION["TWG_SESSION_CHECK"] = "TWG_SESSION_CHECK";
	@session_write_close();
     @session_start();
     echo isset($_SESSION["TWG_SESSION_CHECK"]) ? '<b><font color="green">Available</font></b>' : '<b><font color="red">Not available</font></b>';?>
	</td>
</tr>
<tr>
	<td class="item">
	&nbsp; - session.save_path
	</td>
	<td align="left">
	<?php
	if (isset($_SESSION["TWG_SESSION_CHECK"])) {
       echo '<b><font color="green">Working</font></b>';
     } else {
       echo (($sp=ini_get('session.save_path'))?$sp:'<font color="red"><b>Not set</b></font>');
     }
     ?>
	</td>
</tr>

<tr>
	<td>
	Javascript
	</td>
	<td align="left">
	<script type="text/javaScript">
	document.write('<b><font color="green">Available<\/font><\/b>');
	</script>
	<noscript><b><font color="red">Most features of TWG are disabled without Javascript</font></b></noscript>
	</td>
</tr>
<tr>
	<td class="item">
	 Image Magick Support
	</td>
	<td align="left">
		<?php echo check_image_magic() ? '<b><font color="green">Available</font></b>' : '<b><font color="red">Not available</font></b>';?>
	</td>
</tr>
<tr>
	<td class="item">
	 ffmpeg Support
	</td>
	<td align="left">
		<?php echo check_ffmpeg() ? '<b><font color="green">Available</font></b>' : '<b><font color="red">Not available</font></b>';?>
	</td>
</tr>
<tr>
	<td class="item">
	 ffmpeg video convert
	</td>
	<td align="left">
		<?php echo check_ffmpeg_convert() ? '<b><font color="green">Available</font></b>' : '<b><font color="red">Not available</font></b>';?>
	    <?php
	    if (check_ffmpeg_convert()) {
	      echo "<table><tr><td width=190>A couple of changing smilies have to be shown on the right if the auto conversion to flv works.</td><td style='padding-left:5px;'>";
	      show_ffmpeg_video();
	      echo "</td></tr></table>";
	    }
	    ?>
	</td>
</tr>
<tr>
<td>
	&nbsp;
	</td>
	<td>
		
	</td>
</tr>
<tr>
	<td class="item">
	Server name
	</td>
	<td align="left">
	<b><?php echo get_server_name()  ?></b>
	</td>
</tr>
<tr>
	<td class="item">
	User agent
	</td>
	<td align="left">
	<b><?php echo (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "not set");  ?></b>
	</td>
</tr>
</table>
</div>
</div>
<div class="clr"></div>
<h2>Directory and File Permissions:</h2>
<div class="install-text">
In order for TWG to function
correctly it needs to be able to access or write to certain files
or directories. If you see "Unwriteable" you need to change the
permissions on the file or directory to allow TWG
to write to it. Please check <a href="http://www.tinywebgallery.com/en/faq.php#h1">how-to 1</a> on the web site for good security settings!
<div class="clr">&nbsp;&nbsp;</div>
<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">

<table class="content">
<?php
writableCell( $cachedir);
writableCell( $counterdir);
if (!$store_xml_in_picfolders) {
writableCell( $xmldir);
} else {
writableTree( $basedir);
}

echo '<tr>';
echo '<td colspan=2 class="item">An image has to be shown below. If not, images cannot be <br>loaded properly! Please check the debug file for more details!</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="item">&nbsp;</td>';
echo '<td class="left"><font color="red"><b><img alt="Error loading image!" src="image.php?twg_album=test&twg_show=test"></b></font></td>';
echo '</tr>';

?>
</table>
</div>
<div class="clr"></div>
</div>
<div class="clr"></div>
</div>
<div class="clr"></div>
<h2>Recommended settings:</h2>
<div class="install-text">
These settings are recommended for PHP in order to ensure full
compatibility with TWG.
<br>
However, TWG will still operate if your settings do not quite match the recommended
<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">

<table class="content">
<tr>
	<td class="toggle">
	Directive
	</td>
	<td class="toggle">
	Recommended
	</td>
	<td class="toggle">
	Actual
	</td>
</tr>
<?php
$php_recommended_settings = array(array ('Safe Mode','safe_mode','OFF'),
array ('Display Errors','display_errors','ON'),
array ('File Uploads','file_uploads','ON'),
array ('Magic Quotes GPC','magic_quotes_gpc','ON'),
array ('Magic Quotes Runtime','magic_quotes_runtime','OFF'),
array ('Register Globals','register_globals','ON/OFF'),
array ('Output Buffering','output_buffering','OFF'),
array ('Session auto start','session.auto_start','OFF'),
);

foreach ($php_recommended_settings as $phprec) {
?>
<tr>
	<td class="item"><?php echo $phprec[0]; ?>:</td>
	<td class="toggle"><?php echo $phprec[2]; ?>:</td>
	<td>
	<?php
	if (strpos($phprec[2],get_php_setting($phprec[1])) === false) {
	?>
		<font color="red"><b>
	<?php
	} else {
	?>
		<font color="green"><b>
	<?php
	}
	echo get_php_setting($phprec[1]);
	?>
	</b></font>
	<td>
</tr>
<?php
}
?>
</table>
</div>
</div>
<div class="clr"></div>
</div>
</div>

<div class="ctr">
	<a href="http://www.tinywebgallery.com" target="_blank">Copyright (c) 2004-2014 TinyWebGallery</a>
</div>
<script type="text/javascript">
reload = 0;
</script>
</body>
</html>