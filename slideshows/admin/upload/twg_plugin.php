<?php

/**
 * depending on the action we reset the session cache of TWG
 */ 
function reset_twg_cache($action) {
// we include the session reset functionality
$twg_file = realpath(dirname(__FILE__) . '/../_include/twg_session.php');
if (file_exists($twg_file)) {
    include_once $twg_file;
    // simple actions
    if (($action == 'rename') || ($action == 'delete') || ($action == 'xdelete') || ($action == 'copymove')) {
       resetSessionCache();
       return;
     }
    // depending on an additional parameter
    if ($action == 'dir') {
      if (isset($_GET['createdir']) || isset($_GET['renamedir'])|| isset($_GET['deletedir'])) {
        resetSessionCache();
      }
    }
}
}

// to keep backward compability!
function process_upload_file($dir, $filename, $image) {
twg_plugin_process_upload_file($dir, $filename, $image);
}

function twg_plugin_process_upload_file($dir, $filename, $image) {
global $basedir, $xmldir, $cachedir, $watermark_small , $watermark_big, $show_clipped_images, $use_cache_with_dir;
global $cache_dirs;

$twg_config =  realpath(dirname(__FILE__) . '/../../config.php');
if (file_exists($twg_config)) {
  // @ob_start(); // we don't show any errors user made in the config twg
  include      realpath($twg_config);
  include_once realpath(dirname(__FILE__) . '/../_include/twg_session.php');
  // @ob_end_clean();
 // TWG STUFF
				$basedir = "../../" . $basedir;
				$xmldir = "../../" . $xmldir;
				$cachedir = "../../" . $cachedir;
				$cache_dirs = false;
        // now we add the iptc data to the xml files
        $isimage = is_supported_tfu_image($image, $filename);
				$pos = strpos($dir, $basedir);
				if ($pos !== false) { // we are in the picdir in a subdir and do stuff
					$album = substr($dir, $pos + strlen($basedir) + 1);
				} else {
					$album = "";
				}
				$cacheimage = create_thumb_image($album, $image);
				removeCacheTWG($cacheimage);
				
       	if ($isimage) {
					if ($add_iptc_at_upload) {
					    $input_invalid = false; 
						// not needed - we use the one from TFU
            include realpath(dirname(__FILE__) . "/../../inc/readxml.inc.php");
						if ($pos !== false) { // we are in the picdir in a subdir and do stuff
							getTags($album, $image);
							saveCaption($album, $image);
						}
					}
				}
        
        // save the description if available. Read the txt file and delete it after processing.
      
        if (file_exists($filename . '.txt')) {
            	if (!($isimage && $add_iptc_at_upload)) {
                $input_invalid = false;
                include realpath(dirname(__FILE__) . "/../../inc/readxml.inc.php");
              }
              $description = file_get_contents($filename . '.txt');
              saveCaption($album, $image, $description);  
              @unlink($filename . '.txt'); 
        }
       
        
				// generate thumbnails for videos if ffmpeg is available
				if ($use_ffmpeg && $ffmpeg_generate_thumbs_at_upload && is_supported_ffmpeg_movie($image)) {
				    generateOtherFormatsPreview($dir);
				     if ($autogenerate_video_php_at_upload) {
						  generateVideoPhp($dir, $image);
				     }
				}   
				// we generate a flv file with ffmpeg ;)
				if ($ffmpeg_convert_videos_at_upload && is_supported_ffmpeg_movie($image)) {
				    generateFLV($dir, $image);
				}                            
				if ($generate_cache_at_upload && $isimage) {
				    // we generate the cache dirs when uploading!
            $pos = strpos($dir, $basedir);
				    if ($pos !== false) { // we are in the picdir in a subdir and do stuff
              // settings to generate cache images properly!
              $twg_album = $album;
  					  $login_edit = $twg_enable_session_cache = $twg_disable_session_cache = false;
  					  $twg_rot = -1; $twg_generate=true; $opera = false;
  					  include realpath(dirname(__FILE__) . "/../../inc/loadconfig.inc.php");
  					  // include once is needed because maybe it is included in generateOtherFormatsPreview above
              include_once realpath(dirname(__FILE__) . "/../../inc/imagefunctions.inc.php");
  					  $watermark_small = realpath(dirname(__FILE__) . "/../../" . $watermark_small); 
  					  $basedir_save = $basedir;
  					  $type = "thumb"; // gen the thumb
              include realpath(dirname(__FILE__) . "/../../inc/imagecreate.inc.php");
  					  $basedir = $basedir_save;
  					  $show_clipped_images=false;
              $type = "small"; // gen the small
  					  include realpath(dirname(__FILE__) . "/../../inc/imagecreate.inc.php");			  
          }
        }
        resetSessionCache();
        remove_tmp_files($cachedir);
  }
}

?>