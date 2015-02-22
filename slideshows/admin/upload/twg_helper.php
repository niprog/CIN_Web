<?php
/* 
Duplicate from filefunctions.inc.php - but I don't want to include this whole file! 
*/
defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');

function twg_checkUrl($path)
{
	global $url_file;
	global $cache_dirs;

	if (isset($_SESSION["checkUrl_" . $path]) && $cache_dirs) {
		return $_SESSION["checkUrl_" . $path];
	}

	if (file_exists($path . "/" . $url_file)) {
		$dateiurl = fopen($path . "/" . $url_file, "r");
		$locurl = trim(fgets($dateiurl, 100));
		fclose($dateiurl);
		$locurl = str_replace(" ", "%20", $locurl);
		$_SESSION["checkUrl_" . $path] = $locurl;
		return $locurl;
	} else {
		return false;
	}
}

function removePrefix($str)
{
	if (strlen($str) > 6) {
		if (substr($str, 3, 3) == "___") {
			$str = substr($str, 6);
		}
	}	
	return str_replace("v___","",$str); // videoprefix
}


function remove_trailing_rel_path($str)
{
	return str_replace("/", "", str_replace(".", "", $str));
}

/* dummy for uploader */
function hasRootLink($directory)
{
	return false;
}

function remove_tmp_files($dir)
{
	if (file_exists($dir)) {
		$d = opendir($dir);
		while (false !== ($entry = readdir($d))) {
			if (strstr($entry, ".tmp")) {
				@unlink($dir . "/" . $entry);
			}
		}
		closedir($d);
	}
}

function http_encode($data)
{
	if (substr($data, 4, 3) == "://") {
		$data = str_replace(":", "__DOPPELPUNKT__", $data);
		$data = twg_urlencode($data);
		return str_replace("__DOPPELPUNKT__", ":", $data);
	} else {
		return $data;
	}
}

function exchangeExtension($link, $ext)
{
	return tfu_removeExtension($link) . "." . $ext;
}

function is_supported_ffmpeg_movie($image)
{
    global $ffmpeg_extensions;
    
	$image = strtolower ($image);
	$offp = getExtension($image);
	return in_array($offp,$ffmpeg_extensions);
}

function generateOtherFormatsPreview($file_dir)
{
	include_once dirname(__FILE__) . "/../../inc/imagefunctions.inc.php";
	global $other_file_formats_previews, $compression_thumb, $thumb_pic_size, $install_dir, $password_file, $url_file;
    global $use_ffmpeg, $ffmpeg_extensions, $ffmpeg_time, $ffmpeg_path;

	$comment = false;
	if (file_exists($file_dir . "/config.php")) {
		include ($file_dir . "/config.php");
	}
	if ($handle = @opendir($file_dir)) {
		
		$list = get_file_list($handle, $file_dir);
		$dir_length = count($list);
		for($i = 0;$i < $dir_length;$i++) {
			// if (strrpos($list[$i], ".") == false) {
			if (isset($list[$i])) {
				if (is_dir($file_dir . "/" . $list[$i])) {
					generateOtherFormatsPreview($file_dir . "/" . $list[$i]);
				} else {
				    foreach ($other_file_formats_previews as $offp => $offp_image) {
						if ($offp == strtolower(getExtension($list[$i]))) { // we have something to check :)
							$real_video = realpath($file_dir . "/" . $list[$i]);
							$real_image = exchangeExtension($real_video, "jpg");
							$p_image = $file_dir . "/" . exchangeExtension($list[$i], "jpg");
							$p_image2 = $file_dir . "/" . exchangeExtension($list[$i], "JPG");

                            
							if (!file_exists($p_image) && !file_exists($p_image2)) {
								if ($use_ffmpeg && in_array($offp,$ffmpeg_extensions)) {
								  // create a preview image -> $p_image
								  // ffmpeg -y -i video3.divx -f mjpeg -ss 2 -vframes 1 -an thumb.jpg
								  $command = $ffmpeg_path . " -y -i \"" .  $real_video . "\" -f mjpeg -ss ".$ffmpeg_time." -vframes 1 -an \"" . $real_image . "\""; 
                  execute_command ($command);			  
								} else {	
								generatesmall($install_dir . "../" . $offp_image, $p_image, $thumb_pic_size, $compression_thumb, 0, "", $offp);
							    }
							}
						}
					}
				}
			}
		}
		closedir($handle);
	}
}  
  
/**
 Gets the local or remote file list
*/
function get_file_list($handle, $file_dir) {
    global $password_file;
	
    $i = 0;
	$list = array();
	while (false !== ($file = @readdir($handle))) {
		if ($file != $password_file && $file != "." && $file != "..") {
			$list[$i] = $file;
			$i++;
		}
	}
	return $list;
}

function generateVideoPhp($dir, $image) {
  global  $ffmpeg_convert_videos_at_upload, $video_php_x_default, $video_php_y_default, $video_php_autodetect_size; 
  global  $ffmpeg_generate_thumbs_at_upload, $video_php_autodetect_type, $ffmpeg_output_format;

  // check if exists - if not check extension and generate a default video.php.
  $file = $dir . "/video.php";
  if (!file_exists($file)) {
     if ($video_php_autodetect_size && $ffmpeg_generate_thumbs_at_upload) {
        $image_new = exchangeExtension($dir . "/" . $image, "jpg");  
        if (file_exists($image_new)) { // try autodetection
          $size = getImageSize($image_new);
          $video_php_x_default = $size[0];
          $video_php_y_default = $size[1];
        }
     }
    
     if ($video_php_autodetect_type) {
         $type = "AUTO";
	     $video_php_y_default += 20;
     } else if ($ffmpeg_convert_videos_at_upload) {
	     if ($ffmpeg_output_format == 'flv') {
         $type = "FLV";
       } else {
         $type = "HTML5";
       }
	     $video_php_y_default += 20;
     } else {
		 $extension = strtolower(getExtension($image));
		 if ($extension == "divx") {
		   $type = "DIVX"; 
		   $video_php_y_default += 20;
		 } else if ($extension == "mov") {
		   $type = "QT";
		   $video_php_y_default += 15;
		 } else if ($extension == "flv") {
		   $type = "FLV";
		   $video_php_y_default += 20;
		 } if ($extension == "mp4") {
		   $type = "HTML5";
		   $video_php_y_default += 20;
		 } else { 
		   $type = "WMP";
		   $video_php_y_default += 70; // biggest player ...
		 }
     }
     $value = '<?php
$video_size_x='.$video_php_x_default.';
$video_size_y='.$video_php_y_default.';
$video_player="'.$type.'";
$show_rotation_buttons=false;
$video_show_dl_link=false;
$default_big_navigation="HTML";
?>';
     $xml_file = fopen($file, 'w');
	 fwrite($xml_file, $value);
	 fclose($xml_file);
   }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
function generateFLV($dir, $image) {
 global $ffmpeg_extensions, $use_ffmpeg, $ffmpeg_path, $ffmpeg_convert_command, $ffmpeg_delete_src_after_convert;
 global $ffmpeg_output_format,  $ffmpeg_convert_command_mp4; 
 $offp = getExtension($image);
 if ($use_ffmpeg && in_array($offp,$ffmpeg_extensions)) {
 	  $srcvideo = realpath($dir . '/' . $image);
	  $destvideo =  exchangeExtension($srcvideo, $ffmpeg_output_format);
	  if ($ffmpeg_output_format == 'mp4') {
        $ffmpeg_convert_command = $ffmpeg_convert_command_mp4;    
    }
    if (strtolower($srcvideo) !=  strtolower($destvideo)) {
      $command = $ffmpeg_path . " " .  sprintf($ffmpeg_convert_command, $srcvideo, $destvideo);
      execute_command ($command);
  		if ($ffmpeg_delete_src_after_convert && file_exists($destvideo) && filesize($destvideo) > 0 ) {
  		  @unlink($srcvideo);
  		}
  		if (file_exists($destvideo) && filesize($destvideo) == 0) {
        @unlink($destvideo);
        tfu_debug('Video ' . $dir . '/' . $image . ' cannot be converted by ffmpeg. Command: ' . $command);
      } else if (!file_exists($destvideo)) {
        tfu_debug('Video ' . $dir . '/' . $image . ' cannot be converted by ffmpeg. Command: ' . $command);
      }
		}
	}
}

function get_rot_file_name($twg_album,$image) {
  global $cachedir;
  return "./" . $cachedir . "/" . urlencode(str_replace("/", "_", $twg_album) . "_" . $image) . ".rot";
}

function process_image_exif_rotation($filename, $rotname) {
  global $login_edit,$twg_rot;
  $rot = get_image_exif_rotation($filename);
  if ($rot != 0) {
     $login_edit = true;
     $rot_file = fopen($rotname, 'w');
	 fputs($rot_file, $rot);
	 fclose($rot_file);
  }
  return $rot;
}

function get_image_exif($filename) {
    if (isset($GLOBALS["EXIF".$filename])) {
      return $GLOBALS["EXIF".$filename];
    }
  	include_once dirname(__FILE__) . "/../../inc/exifReader.inc.php";
  	$er = new phpExifReader($filename);
  	$er->processFile();
	$GLOBALS["EXIF".$filename] = $er; // not in session because we only need this once per image
	return $er;
}

function get_image_exif_rotation($filename)
{
  global $autorotate_images;
  if ($autorotate_images == "") {
    return 0;
  }

  $r1 = 90;
  $r2 = 270;
  if ($autorotate_images=="invert") {
       $r1 = 270;
       $r2 = 90;
  }
  set_error_handler("on_error_no_output");
  $er = get_image_exif($filename);
  set_error_handler("on_error");
  if (isset($er->ImageInfo[TAG_EXIF_IMAGEWIDTH])) {
  		$r = $er->ImageInfo[TAG_ORIENTATION];
		switch($r) {
			case 1:
			case 2: $rot = 0;
			break;
			case 3:
			case 4: $rot = 180;
			break;
			case 5:
			case 6: $rot = $r1;
			break;
			case 7:
			case 8: $rot = $r2;
			break;
			default: $rot = 0;
		}
  	} else {
  		$rot = 0;
	}
  return $rot;
}

function create_thumb_image($twg_album, $image_encoded) {
  global $cachedir;
  global $use_cache_with_dir;
  
  if ($use_cache_with_dir) {
    $path = $cachedir . '/' . twg_urlencode($twg_album);
    if (!file_exists($path)) {
      mkdir_recursive ($path);
    }
    $prefix = $twg_album . '/';
    return twg_urlencode($prefix . urldecode($image_encoded));
  }
    return urlencode(str_replace('/', "_", $twg_album) . "_" . urldecode($image_encoded));
}


function mkdir_recursive($pathname)
{
    is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname));
    return is_dir($pathname) || @mkdir($pathname);
}

function create_cache_file($thumbimage,$extension_thumb, $encoded=false) {
  global $cachedir;
  $thumbimage = make_hash($thumbimage,$encoded);
  
  return $cachedir . '/' . $thumbimage . '.' . $extension_thumb;
  // return "./" . $cachedir . '/' . $thumbimage . '.' . $extension_thumb;
}

function make_hash($thumbimage,$encoded) {
  global $use_cache_hash;
  if ($use_cache_hash) {
        if ($encoded) {
           $thumbimage = urldecode($thumbimage); 
        }
        $thumbimage = md5($thumbimage);
  }
  return $thumbimage;
}

function getFileContent($filename, $oldcontent)
{
	global $cache_dirs;

	if (isset($_SESSION["fc_" . $filename]) && $cache_dirs) {
		return $_SESSION["fc_" . $filename];
	}

	if (file_exists($filename)) {
		$datei = fopen($filename, "r");
		$text =(fgets($datei, filesize ($filename)+1));
		fclose($datei);
		if ($text != "") {
			$_SESSION["fc_" . $filename] = $text;
			return $text;
		}
	}
	$_SESSION["fc_" . $filename] = $oldcontent;
	return $oldcontent;
}

function checktwg_rot()
{
	global $cachedir;
	global $install_dir;

	$image = dirname(__FILE__) . "/../../buttons/border.jpg";
	$outputimage = $cachedir . "/_rotation_available.jpg";
	$outputimageerror = $cachedir . "/_rotation_not_available.jpg";
	// we check only once - if one to the ouputimages exists we don't do he check again
	// delete the _twg_rot_not_available.jpg and _twg_rot_available.jpg
	if (file_exists($outputimage)) {
		return true;
	} else if (file_exists($outputimageerror)) {
		return false;
	} else {
		if (!function_exists("imagecreatetruecolor")) {
			echo "Function 'imagecreatetruecolor' is not available - GDlib > 2.0.1 is needed to run TinyWebGallery properly!";
		} else {
			if (!function_exists("imagerotate")) {
				$dst = imagecreatetruecolor(50, 37);
				$fh = fopen($outputimageerror, 'w'); // fix for a bug in some php - versions - thanks to Anders
				fclose($fh);
				imagejpeg($dst, $outputimageerror, 50);
				return false;
			} else {
				$oldsize = getImageSize($image);
				$src = imagecreatefromjpeg($image);
				$dst = imagecreatetruecolor(50, 37);
				imagecopyresampled($dst, $src, 0, 0, 0, 0, 50, 37, 50, 37);
				$twg_rot = @imagerotate($dst, 90, 0);
				$fh2 = fopen($outputimage, 'w'); // fix for a bug in some php - versions - thanks to Anders
				fclose($fh2);
				if (!imagejpeg($twg_rot, $outputimage, 50)) {
					$fh3 = fopen($outputimageerror, 'w'); // fix for a bug in some php - versions - thanks to Anders
					fclose($fh3);
					imagejpeg($dst, $outputimageerror, 50);
					return false;
				} else {
					return true;
				}
			}
		}
	}
}

function read_rot($rot) {
  $rot_file = fopen($rot, 'r');
  $twg_rot = fgets($rot_file, 30);
  fclose($rot_file);
  return $twg_rot;
}

function removeCacheTWG($filename)
{
  global $extension_slideshow, $extension_thumb, $extension_small;

		$cachename = create_cache_file($filename,$extension_slideshow);
        if (file_exists($cachename)) {
			@unlink($cachename);
		}	
		$cachename = create_cache_file($filename, $extension_thumb);
		if (file_exists($cachename)) {
			@unlink($cachename);
		}
		$cachename = create_cache_file($filename, $extension_small);
		if (file_exists($cachename)) {
			@unlink($cachename);
		}
}

function startErrorHandling($xml_filename,$type) {
  tfu_debug ("Cannot find : " . $xml_filename . ':' . $type );
}

function get_free_mem()
{
    $limit = ini_get('memory_limit') ;
	if ($limit && function_exists("memory_get_usage")) {
		return $limit - memory_get_usage();
	} else {
		return 0; // we don't know how much mem is available.
	}
}

function twg_urlencode($data)
{
	$data = str_replace('/', "__TWG__", $data);
	$data = str_replace(":", "__DPP__", $data);
	$data = rawurlencode ($data);
	$data = str_replace("__DPP__", ":", $data);
	return str_replace("__TWG__", '/', $data);
}

function get_image_exif_size($filename, $image_name)
{
	set_error_handler("on_error_no_output");
	$er = get_image_exif($filename);
  set_error_handler("on_error");
	$size_array = array();
	$size_array[2] = 2;
	if (isset($er->ImageInfo[TAG_EXIF_IMAGEWIDTH])) {
		$size_array[0] = $er->ImageInfo[TAG_EXIF_IMAGEWIDTH];
	} else {
		$size_array[0] = 1024;
		tfu_debug("Size of image " . $image_name . " cannot be detected using 1024x768.");
	}

	if (isset($er->ImageInfo[TAG_EXIF_IMAGELENGTH])) {
		$size_array[1] = $er->ImageInfo[TAG_EXIF_IMAGELENGTH];
	} else {
		$size_array[1] = 768;
	}
	return $size_array;
}

/*
  In TFU debug was renamed to tfu_debug. But in TWG we still need debug
*/
function debug($str) { 
  tfu_debug($str); 
} 

/*
  In TFU removeExtension was renamed to tfu_removeExtension. But in TWG we still need removeExtension
*/
function removeExtension($name) {
    return tfu_removeExtension($name);
}

?>