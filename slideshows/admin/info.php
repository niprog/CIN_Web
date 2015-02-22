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

defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );

$GLOBALS["standalone"] = "";
if (isset($_GET['showphpinfo'])) {
$showphpinfo = true;
} else {
$showphpinfo = false;;
}

$is_cache_call=false;


/**
 * get maximum upload size
 */
function getMaximumUploadSize()
{
    $upload_max = return_kbytes(ini_get('upload_max_filesize'));
    $post_max = return_kbytes(ini_get('post_max_size'));
    return $upload_max < $post_max ? $upload_max : $post_max;
}

function writableCell( $folder, $isfile = false, $color = "red" ) {
	
    echo '<tr>';
	echo '<td class="item">' . $folder;
	if (!$isfile) {
	  echo '/';
	}
	echo '</td>';
	echo '<td align="left">';
	if (file_exists( "../" . $folder)) {
	  echo is_writable( "../" .$folder ) ? '<b><font color="green">' . $GLOBALS["info_messages"] ["writeble"] . '</font></b>' : '<b><font color="'.$color.'">' . $GLOBALS["info_messages"] ["unwriteble"] . '</font></b>' . '</td>';
	} else {
	  echo '<b><font color="red">' . $GLOBALS["info_messages"] ["notfound"] . '</font></b>';
	}
	echo '</tr>';
}

function writableTree( $folder ) {
global $xmldir;
echo '<tr>';
	echo '<td class="item">' . $folder;
	echo '/';
	echo '</td>';
	echo '<td align="left">';
	if (print_tree("../" . $folder) == 0) {
	echo '<b><font color="green">' . $GLOBALS["info_messages"] ["allsubdirwrt"] . '</font></b>';
	} else {
	 echo "<b><font color='red'><br>" . $GLOBALS["info_messages"] ["foldersabove"] . "'" . $xmldir . "'" . $GLOBALS["info_messages"] ["folder"] . "</font></b>";
	}
	echo '</tr>';
}


function writePicOverview( $folder ) {
global $xmldir, $cache_dirs;

  $cache_dirs = true;
  echo '<tr>';
  echo '<td style="text-align:center;"><b>' . $GLOBALS["info_messages"] ["albums"] . '</b></td>';
  echo '<td style="text-align:right;padding-right:10px;"><b>' . $GLOBALS["info_messages"] ["images"] . '</b></td>';
  echo '<td style="text-align:right;padding-right:10px;"><b>' . $GLOBALS["info_messages"] ["size"] . '</b></td>';
  echo '<td style="text-align:center;padding-right:2px;padding-left:2px;"><b>P</b></td>';
  echo '<td style="text-align:center;padding-right:2px;padding-left:2px;"><b>F</b></td>';
  echo '<td style="text-align:center;padding-right:2px;padding-left:2px;"><b>N</b></td>';

  echo '<td style="text-align:center;padding-right:2px;padding-left:2px;"><b>FI</b></td>';
  echo '<td style="text-align:center;padding-right:2px;padding-left:2px;"><b>I</b></td>';
  echo '<td style="text-align:center;padding-right:2px;padding-left:2px;"><b>A</b></td>';
  echo '<td style="text-align:center;padding-right:2px;padding-left:2px;"><b>B</b></td>';
  echo '<td style="text-align:center;padding-right:2px;padding-left:2px;"><b>S</b></td>';
  echo '<td style="text-align:center;padding-right:2px;padding-left:2px;"><b>C</b></td>';
  echo '</tr>';

	echo '<tr>';
	echo '<td>' . $folder . '</td>';
	echo '<td style="text-align:right;padding-right:10px;">';
	echo count_tree("../" . $folder) . '</td>';
	echo '<td style="text-align:right;padding-right:10px;">';
	$num = count_tree("../" . $folder, true);
  echo number_format($num/1000,0) . ' KB';
  echo '</td>';

	checkAdditionalFiles("../" . $folder);

  echo '</tr>';

	print_tree("../" . $folder , true , 5);
}

function checkAdditionalFiles($folder) {
 global $image_file_extension, $password_file;

  	echo '<td class=ctr>'; // private
      if (file_exists( $folder . "/" . $password_file)) {
        if (file_exists( $folder . "/private.png")) {
	      echo "<b>P</b>";
	    } else {
	      echo "P";
	    }
	  } else {
	    echo "&nbsp;";
	  }
		echo '</td>';

			echo '<td class=ctr>';
		  if (file_exists( $folder . "/folder.txt")) {
			  if (!hasLanguageDepFiles($folder, "folder", "txt")) {
			    echo "F";
			  } else {
			    echo "<b>F</b>";
			  }
			}
		echo '</td>';
			echo '<td class=ctr>';
				  if (file_exists( $folder . "/foldername.txt")) {
					  if (!hasLanguageDepFiles($folder, "foldername", "txt")) {
					    echo "N";
					  } else {
					    echo "<b>N</b>";
					  }
					}
		echo '</td>';


			echo '<td class=ctr>';
		  if (file_exists( $folder . "/folder.png")) {
			  echo "FI";
			}
		echo '</td>';
			echo '<td class=ctr>';
		  if (file_exists( $folder . "/image." . $image_file_extension) ||
		      file_exists( $folder . "/image2." . $image_file_extension)) {
			    if (!hasLanguageDepFiles($folder, "image", $image_file_extension) &&
			        !hasLanguageDepFiles($folder, "image2", $image_file_extension)) {
										    echo "I";
										  } else {
										    echo "<b>I</b>";
					  }

			}
			echo '</td>';
						echo '<td class=ctr>';
					  if (file_exists( $folder . "/albumr.txt") ||
					      file_exists( $folder . "/albuml.txt")) {
						    if (!hasLanguageDepFiles($folder, "albumr", "txt") &&
						        !hasLanguageDepFiles($folder, "albuml", "txt")) {
													    echo "A";
													  } else {
													    echo "<b>A</b>";
								  }

						}
		echo '</td>';
			echo '<td class=ctr>';
		  if (file_exists( $folder . "/back.png")) {
			  echo "B";
			}
		echo '</td>';
			echo '<td class=ctr>';
		  if (file_exists( $folder . "/style.css")) {
			  echo "S";
			}
		echo '</td>';
			echo '<td class=ctr>';
		  if (file_exists( $folder . "/config.php") || file_exists( $folder . "/video.php")) {
			  echo "C";
			}
		echo '</td>';
}


function hasLanguageDepFiles($directory, $prefix, $extension)
{
	$found = false;
	if ($handle = @opendir($directory)){
		while (false !== ($file = @readdir($handle))){
			if ($file != "." && $file != ".."){
			  $regex = "/" . $prefix . "_[a-zA-Z]{2}\." . $extension . "$/";
			  if (preg_match($regex, $file)) {
					$found=true;
				}
			}
		}
	  closedir($handle);
	}
	return $found;
}

/*
   Counts the number of jpegs in all trees
*/
function print_tree($file_dir, $fullinfo = false, $deep=0)
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
              // for($b = 0;$b < $deep;$b++){ echo "&nbsp;"; }
							if (!$fullinfo) {
							if (!is_writeable($file_dir . "/" . $list[$i])) {
							  echo '<b><font color="red">';
							  echo $file_dir . "/" . $list[$i];
							  echo '</font></b><br>';
							  $localfiles++;
							}
							} else {
							echo '<tr>';
	            echo '<td align="left">';
							  for($b = 0;$b < $deep;$b++){ echo "&nbsp;"; }
							  echo htmlentities(limit_length($list[$i],20));
							  echo '</td>';
							  echo '<td style="text-align:right;padding-right:10px;">';
							  echo count_tree($file_dir . "/" . $list[$i]);
                echo '</td>';
							  echo '<td style="text-align:right;padding-right:10px;">';
							  $num = count_tree($file_dir . "/" . $list[$i], true);
							   if ($num == 0) {
								    echo "remote";
								  } else {
								    echo number_format($num/1000,0) . ' KB';
                }

							  echo '</td>';
							 	checkAdditionalFiles($file_dir . "/" . $list[$i]);
							  echo '</tr>';

							}
              $localfiles += print_tree($file_dir . "/" . $list[$i], $fullinfo,$deep + 5);
            }
          }
        }
      }
      closedir($handle);
    }
    return $localfiles;
}

function limit_length($str, $len) {
if (strlen($str) <= $len) {
return $str;
} else {
  return substr($str, 0, $len) . "...";
}
}


function writeParent() {
	echo '<tr>';
	echo '<td class="item">' . $GLOBALS["info_messages"] ["twgfolder"] . '</td>';
	echo '<td align="left">';
  echo testParentdir() ? '<b><font color="green">' . $GLOBALS["info_messages"] ["writeble"] . '</font></b>' : '<b><font color="red">' . $GLOBALS["info_messages"] ["unwriteble"] . '</font></b>' . '</td>';
  echo '</tr>';
}

function check_rotation()
{
    global $cachedir;
    global $install_dir;

    $c_dir = $cachedir;
    $image = "../" . $install_dir . "buttons/border.jpg";
	  $outputimage = $c_dir . "/_rotation_available.jpg";
    $outputimageerror = $c_dir . "/_rotation_not_available.jpg";
    // we check only once - if one to the ouputimages exists we don't do he check again
    // delete the _twg_rot_not_available.jpg and _twg_rot_available.jpg
    if (file_exists($outputimage)) {
    unlink($outputimage);
    }
    if (file_exists($outputimageerror)) {
      unlink($outputimageerror);
    }
		if (!function_exists("imagerotate")) {
				echo '<br>' . $GLOBALS["info_messages"] ["imrotate"] . $outputimageerror .  $GLOBALS["info_messages"] ["diablerotbutt"] . '<br>';
				if (function_exists("imagecreatetruecolor")) {
					 $dst = imagecreatetruecolor(50, 37);
					 imagejpeg($dst, $outputimageerror, 50);
				}
				return false;
		} else {
				$oldsize = getImageSize($image);
				$src = imagecreatefromjpeg($image);
				$dst = imagecreatetruecolor(50, 37);
				imagecopyresampled($dst, $src, 0, 0, 0, 0, 50, 37, 50, 37);
				$twg_rot = imagerotate($dst, 90, 0);
				if (!imagejpeg($twg_rot, $outputimage, 50)) {
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
  global $cachedir, $install_dir,$image_magic_path,$admin_enable_cmd_checks;
    $inputimage = "../buttons/info_test.jpg";
    $outputimageerror =  $cachedir . "/_image_magick_test.jpg"; 
 
    if (file_exists($outputimageerror)) {
      @unlink($outputimageerror);
    }
     $fh=fopen($outputimageerror,'w'); // fix for a but in some php - versions - thanks to Anders
	 fclose($fh); 
    
	$command = $image_magic_path. " \"" .  realpath($inputimage) . "\" -quality 80 -resize 120x81  \"" . realpath($outputimageerror) . "\""; 
  if ($admin_enable_cmd_checks) {
    execute_command ($command);
  }
	return (file_exists($outputimageerror) && (filesize($outputimageerror) > 0));

}

/*
  We check if we can extract the 1st image of the ffmpeg_test.avi
*/
function check_ffmpeg() {
   global $cachedir, $install_dir,$ffmpeg_path,$admin_enable_cmd_checks;
   
   $inputimage = "../html/ffmpeg_test.avi";
   $outputimageerror = $cachedir . "/_ffmpeg_test.jpg"; 
   
   if (file_exists($outputimageerror)) {
         @unlink($outputimageerror);
       }
   $fh=fopen($outputimageerror,'w'); // fix for a but in some php - versions - thanks to Anders
   fclose($fh); 
   $command = $ffmpeg_path . " -y -i \"" .  realpath($inputimage) . "\" -f mjpeg -ss 0 -vframes 1 -an \"" . realpath($outputimageerror) . "\""; 
   if ($admin_enable_cmd_checks) {
     execute_command ($command);
   }
	return (file_exists($outputimageerror) && (filesize($outputimageerror) > 0));
}

function check_ffmpeg_convert() {
   global $cachedir, $install_dir,$ffmpeg_path,$ffmpeg_convert_command,$admin_enable_cmd_checks;
   
   $inputimage = "../html/ffmpeg_test.avi";
   $outputimageerror = $cachedir . "/_ffmpeg_test.flv"; 
   
   if (file_exists($outputimageerror)) {
         @unlink($outputimageerror);
       }
   $fh=fopen($outputimageerror,'w'); // fix for a but in some php - versions - thanks to Anders
   fclose($fh); 
   
   $command = $ffmpeg_path . " " .  sprintf($ffmpeg_convert_command, realpath($inputimage), realpath($outputimageerror));
   if ($admin_enable_cmd_checks) { 
     execute_command ($command);
   }
	return (file_exists($outputimageerror) && (filesize($outputimageerror) > 0));
}

function show_ffmpeg_video() {
 global $cachedir, $install_dir,$ffmpeg_path,$ffmpeg_convert_command;
  
     $flashtext = '<div id="flashcontent"><div class="noflash">The flash requires at least Flash 6.<br>Please get it <b><a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&promoid=BIOW" target="_blank">here<\/a><\/b>.<\/div><\/div>';

        $movie = "../html/mediaplayer.swf?";
		$video_size_x = 30; 
		$video_size_y = 50; 
		$file = "file=" . $cachedir . "/_ffmpeg_test.flv";
			$auto_param = "autostart=true&icons=false&controlbar=false&repeat=always";
		
		echo '
		<script type="text/javaScript" src="../js/swfobject.js"></script>
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
 echo '<br>';
 echo '<div style="width:900px;overflow:hidden;padding-top:10px;">';
 echo phpinfo();
 echo '</div><br/>';
 echo '</p></center>';
 return;
}

?>
<?php
show_twg_header();
?>
<div id="ctr" align="center">
<div class="install round_borders">
<div>
<div id="step">TWG Info</div>
<div class="far-right">
	<input type="button" class="button" value="<?php echo $GLOBALS["info_messages"] ["checkagain"]; ?>" onclick="window.location='index.php?action=info'" />
	<input type="button" class="button" value="<?php echo $GLOBALS["info_messages"] ["showphpinfo"]; ?>" onclick="window.location='index.php?action=info&showphpinfo=true'" />
</div><div class="clr"></div>

<h1><?php echo $GLOBALS["info_messages"] ["twgimafoldov"]; ?></h1>
<div class="install-text">
<?php echo $GLOBALS["info_messages"] ["thistablegif"]; ?><br>&nbsp;<br>
<b><?php echo $GLOBALS["info_messages"] ["pleasenote"]; ?></b><br>
<?php echo $GLOBALS["info_messages"] ["numberofima"]; ?>
<div class="ctr"></div>
<br/>
<?php echo $GLOBALS["info_messages"] ["legend"]; ?>
<br/>&nbsp;</br>
<ul>
<li>P = <?php echo $GLOBALS["info_messages"] ["protectgal"]; ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(private.txt)</li>
<li><b>P</b> = <?php echo $GLOBALS["info_messages"] ["protectgalw"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $GLOBALS["info_messages"] ["protectfolim"]; ?></li>
<li>F = <?php echo $GLOBALS["info_messages"] ["folderdiscr"]; ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(folder.txt)</li>
<li>N = <?php echo $GLOBALS["info_messages"] ["foldernm"]; ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(foldername.txt)</li>
<li>FI = <?php echo $GLOBALS["info_messages"] ["folderima"]; ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(folder.png)</li>
<li>I = <?php echo $GLOBALS["info_messages"] ["imagetext"]; ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(image.txt/php)</li>
<li>A = <?php echo $GLOBALS["info_messages"] ["albumdiscr"]; ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(albuml/r.txt)</li>
<li>B = <?php echo $GLOBALS["info_messages"] ["backrimage"]; ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(back.png)</li>
<li>S = <?php echo $GLOBALS["info_messages"] ["stylesheet"]; ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(style.css)</li>
<li>C = <?php echo $GLOBALS["info_messages"] ["configfile"]; ?><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(config.php or video.php)</li>
</ul>
<br/>&nbsp;</br>
<?php echo $GLOBALS["info_messages"] ["charhavelang"]; ?>

</div>

<div class="install-form">
<div class="form-block">

<table summary="" class="content">
<?php
writePicOverview($basedir);
?>
</table>
</div>
</div>
<div class="clr"></div>

<h1><a name="check"></a><?php echo $GLOBALS["info_messages"] ["twginstalchck"]; echo $twg_version; ?></h1>
<div class="install-text">
<?php echo $GLOBALS["info_messages"] ["highlitred"]; ?>
<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">

<table summary="" class="content">
<tr>
	<td class="item">
	<?php echo $GLOBALS["info_messages"] ["phpversion"]; ?>
	</td>
	<td align="left">
	<?php echo phpversion() < '4.3' ? '<b><font color="red">' . $GLOBALS["info_messages"] ["no"] . '</font></b>' : '<b><font color="green">' . $GLOBALS["info_messages"] ["yes"] . '</font></b>'; echo " (" . phpversion() . ")"; ?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - <?php echo $GLOBALS["info_messages"] ["xmlsupport"]; ?>
	</td>
	<td align="left">
	<?php echo extension_loaded('xml') ? '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>' : '<b><font color="red">' . $GLOBALS["info_messages"] ["unavaileble"] . '</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - <?php echo $GLOBALS["info_messages"] ["gdlibsupport"]; ?>
	</td>
	<td align="left">
	<?php echo extension_loaded('gd') ? '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>' : '<b><font color="red">' . $GLOBALS["info_messages"] ["unavaileble"] . '</font></b>';?>
	</td>
</tr>
<tr>
	<td class="item">
	&nbsp; - <?php echo $GLOBALS["info_messages"] ["gdlib"]; ?>
	</td>
	<td align="left">
	<?php echo gd_version() < '2.0' ? '<b><font color="red">' . $GLOBALS["info_messages"] ["no"] . '</font></b>' : '<b><font color="green">' . $GLOBALS["info_messages"] ["yes"] . '</font></b>'; echo " (" . gd_version() . ")"; ?>
	</td>
</tr>
<tr>
	<td class="item">
	&nbsp; - <?php echo $GLOBALS["info_messages"] ["imagecreate"]; ?>
	</td>
	<td align="left">
	<?php echo (!function_exists("imagecreatetruecolor")) ? '<b><font color="red">' . $GLOBALS["info_messages"] ["gdlibntinst"] . '</font></b>' : '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>'; ?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - <?php echo $GLOBALS["info_messages"] ["memlimit"]; ?>
	</td>
	<td align="left">
	<?php
	$limit = return_bytes(ini_get('memory_limit'));
	if (!$limit) {
	  echo  '<b><font color="#FF9900">' . $GLOBALS["info_messages"] ["memlimitnotd"] . '</font></b>';
	} else {
	if ($limit > 48000000) {
			echo '<b><font color="green">' . $GLOBALS["info_messages"] ["verygood"] . '</font></b>';
	} else if($limit > 30000000) {
	  echo  '<b><font color="orange">' . $GLOBALS["info_messages"] ["okbutdontula"] . '</font></b>';
	} else {
	  echo  '<b><font color="red">' . $GLOBALS["info_messages"] ["onlyusesmall"] . '</font></b>';
	}
  echo " (" . ini_get('memory_limit') . ")";
  }
  ?>
	</td>
</tr>
<tr>
	<td class="item">
	&nbsp; - <?php echo $GLOBALS["info_messages"] ["maxresolution"]; ?>
	</td>
	<td align="left">
	<?php
		if (!$limit) {
		  echo  '<b><font color="green">' . $GLOBALS["info_messages"] ["nolimit"] . '</font></b>';
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
	&nbsp; - <?php echo $GLOBALS["info_messages"] ["rotateavail"]; ?>
	</td>
	<td align="left">

	<?php
	if (file_exists( $cachedir) && is_writable( $cachedir )) {
	  echo check_rotation() ? '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>' : '<b><font color="red">' . $GLOBALS["info_messages"] ["unavaileble"] . '</font></b>';
	}else {
	   echo '<b><font color="red">' . $GLOBALS["info_messages"] ["testfailed"] . '</font></b>';
	}
	?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - <?php echo $GLOBALS["info_messages"] ["textwaterm"]; ?>
	</td>
	<td align="left">
	<?php echo (function_exists("imagettftext")) ? '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>' : '<b><font color="orange">' . $GLOBALS["info_messages"] ["unavailebleim"] . ' </font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - <?php echo $GLOBALS["info_messages"] ["remotejpgsupp"]; ?>
	</td>
	<td align="left">
	<?php echo (get_php_setting('allow_url_fopen') == 'ON') ? '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>' : '<b><font color="orange">' . $GLOBALS["info_messages"] ["unavailebleurl"] . '</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp; - <?php echo $GLOBALS["info_messages"] ["fileuploads"]; ?>
	</td>
	<td align="left">
	<?php echo (get_php_setting('file_uploads') == 'ON') ? '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>' : '<b><font color="orange">' . $GLOBALS["info_messages"] ["unavaileble"] . '</font></b>';?>
	</td>
</tr>
<tr>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp; - <?php echo $GLOBALS["info_messages"] ["uplmaxfilesize"]; ?>
	</td>
	<td align="left">
	<?php
	$limit = getMaximumUploadSize();
	if (!$limit) {
	  echo  '<b><font color="orange">' . $GLOBALS["info_messages"] ["maxfilsntdet"] . '</font></b>';
	} else {
	if ($limit > 4000) {
		echo '<b><font color="green">' . ini_get('upload_max_filesize') . '</font></b>';
	} else {
	  echo  '<b><font color="orange">' . ini_get('upload_max_filesize') . $GLOBALS["info_messages"] ["resizeimages"] . ini_get('upload_max_filesize') . '</font></b>';
	}
  }
  ?> (<a href="http://www.tinywebgallery.com/en/tfu/tfu_faq_4.php" target="_blank">howto</a>)
	</td>
</tr>

<tr>
	<td class="item">
	<?php echo $GLOBALS["info_messages"] ["session"]; ?>
	</td>
	<td align="left">
	<?php 	
     $_SESSION["TWG_SESSION_CHECK"] = "TWG_SESSION_CHECK";
	set_error_handler('on_error_no_output');
     @session_write_close();
     @session_start();
     set_error_handler('on_error');
     echo isset($_SESSION["TWG_SESSION_CHECK"]) ? '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>' : '<b><font color="red">' . $GLOBALS["info_messages"] ["notavaileble"] . '</font></b>';?>
	</td>
</tr>
<tr>
	<td class="item">
	&nbsp; - session.save_path
	</td>
	<td align="left">
	<?php echo (($sp=ini_get('session.save_path'))?$sp:'<font color="red"><b>' . $GLOBALS["info_messages"] ["notavaileble"] . '</b></font>'); ?>
	</td>
</tr>

<?php
// errors here are not written to the log because they are displayed on the page.
set_error_handler('on_error_no_output');
?>
<tr>
	<td>
	<?php echo $GLOBALS["info_messages"] ["javascript"]; ?>
	</td>
	<td align="left">
	<script type="text/javascript">
	document.write('<b><font color="green"><?php echo $GLOBALS["info_messages"] ["availeble"]; ?><\/font><\/b>');
	</script>
	<noscript><b><font color="red"><?php echo $GLOBALS["info_messages"] ["mostfeatjava"]; ?></font></b></noscript>
	</td>
</tr>
<tr>
	<td>
	fsockopen (<a href="http://www.tinywebgallery.com/en/faq.php#h20" target="_blank">howto</a>)
	</td>
	<td align="left">
      <?php
      if(function_exists('fsockopen')) {
      echo '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>';
      }
      else {
      echo '<b><font color="red">' . $GLOBALS["info_messages"] ["notavaileble"] . '</font></b>';
      }
      ?>
	</td>
</tr>
<tr>
	<td class="item">
	 Image Magick Support
	</td>
	<td align="left">
		<?php echo check_image_magic() ? '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>' : '<b><font color="red">' . $GLOBALS["info_messages"] ["notavaileble"] . '</font></b>';?>
	</td>
</tr>
<tr>
	<td class="item">
	 ffmpeg Support
	</td>
	<td align="left">
		<?php echo check_ffmpeg() ? '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>' : '<b><font color="red">' . $GLOBALS["info_messages"] ["notavaileble"] . '</font></b>';?>
	</td>
</tr>
<tr>
	<td class="item">
	 ffmpeg video convert
	</td>
	<td align="left">
		<?php echo check_ffmpeg_convert() ? '<b><font color="green">' . $GLOBALS["info_messages"] ["availeble"] . '</font></b>' : '<b><font color="red">' . $GLOBALS["info_messages"] ["notavaileble"] . '</font></b>';?>
	    <?php
	    if (check_ffmpeg_convert()) {
	      echo "<table><tr><td width=190>A couple of changing smilies have to be shown on the right if the auto conversion to flv works.</td><td style='padding-left:5px;'>";
	      show_ffmpeg_video();
	      echo "</td></tr></table>";
	    }
	    ?>
	</td>
</tr>
<?php
set_error_handler('on_error');
?>
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
</table>
</div>
</div>
<div class="clr"></div>
<h1><a name="permissions"></a><?php echo $GLOBALS["info_messages"] ["dirfilpermiss"]; ?></h1>
<div class="install-text">
<?php echo $GLOBALS["info_messages"] ["inordertofunc"]; ?><a href="http://www.tinywebgallery.com/en/faq.php#h1">how-to 1</a><?php echo $GLOBALS["info_messages"] ["onthewebsite"]; ?>
<div class="clr">&nbsp;&nbsp;</div>
<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">

<table  summary="" class="content">
<?php
writableCell( $cachedir_save);
writableCell( $counterdir);
if (!$store_xml_in_picfolders) {
  writableCell( $xmldir);
}
echo '<tr>';
echo '<td align="left" colspan="2" style="padding-top:10px;">';
echo $GLOBALS["info_messages"] ["thehtusers"];
echo "</tr>";
writableCell( "admin/_config/.htusers.php", true);

if ($store_xml_in_picfolders) {
  echo '<tr>';
  echo '<td align="left" colspan="2" style="padding-top:10px;">';
  echo $GLOBALS["info_messages"] ["thepictdir"];
  echo "</tr>";
  writableTree( $basedir);
}

echo '<tr>';
echo '<td align="left" colspan="2" style="padding-top:10px;">';
echo $GLOBALS["info_messages"] ["statusoftwg"];
echo "</tr>";
writeParent();
echo '<tr>';
echo '<td align="left" colspan="2" style="padding-top:10px;">';
echo $GLOBALS["info_messages"] ["theconfigdoesnt"];
echo "</tr>";
writableCell( "config.php", true, "black");
writableCell( "my_config.php", true);
echo '<tr>';
echo '<td align="left" colspan="2" style="padding-top:10px;">';
echo $GLOBALS["info_messages"] ["mystylehstobewr"];
echo "</tr>";
writableCell( "my_style.css", true);
echo '<tr>';
echo '<td colspan=2 class="item" style="padding-top:10px;">'. $GLOBALS["info_messages"] ["animage"] . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="item">&nbsp;</td>';
echo '<td class="left"><font color="red"><b><img alt="' . $GLOBALS["info_messages"] ["errorloima"] . '" src="../image.php?twg_album=test&amp;twg_show=test"></b></font></td>';
echo '</tr>';

/*
if administration exists !!
echo '<tr>';
echo '<td colspan=2 class="item">The ' . $uploaddir . ' folder has only to be writeable if the web interface is used for upload!</td>';
echo '</tr>';
writableCell( $uploaddir);
*/
?>
</table>
</div>
<div class="clr"></div>
</div>
<div class="clr"></div>
</div>
<div class="clr"></div>
<h1><a name="settings"></a><?php echo $GLOBALS["info_messages"] ["recommsett"]; ?></h1>
<div class="install-text">
<?php echo $GLOBALS["info_messages"] ["thesesett"]; ?>
<br>
<?php echo $GLOBALS["info_messages"] ["howevertwg"]; ?>
<div class="ctr"></div>
</div>

<div class="install-form">
<div class="form-block">

<table  summary="" class="content">
<tr>
	<td class="toggle">
	<?php echo $GLOBALS["info_messages"] ["directive"]; ?>
	</td>
	<td class="toggle">
	<?php echo $GLOBALS["info_messages"] ["recommended"]; ?>
	</td>
	<td class="toggle">
	<?php echo $GLOBALS["info_messages"] ["actual"]; ?>
	</td>
</tr>
<?php
$php_recommended_settings = array(array ($GLOBALS["info_messages"] ["savemode"],'safe_mode',"OFF"),
array ($GLOBALS["info_messages"] ["displayerrors"],'display_errors',"ON"),
array ($GLOBALS["info_messages"] ["fileuploads"],'file_uploads',"ON"),
array ($GLOBALS["info_messages"] ["magicquotesgpc"],'magic_quotes_gpc',"ON"),
array ($GLOBALS["info_messages"] ["magicquotesrun"],'magic_quotes_runtime',"OFF"),
array ($GLOBALS["info_messages"] ["registerglobals"],'register_globals',"ON/OFF"),
array ($GLOBALS["info_messages"] ["outputbuff"],'output_buffering',"OFF"),
array ($GLOBALS["info_messages"] ["sessionauto"],'session.auto_start',"OFF"),
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