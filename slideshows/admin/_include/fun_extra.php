<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is fun_extra.php, released on 2003-03-31.

     The Initial Developer of the Original Code is The QuiX project.

     Alternatively, the contents of this file may be used under the terms
     of the GNU General Public License Version 2 or later (the "GPL"), in
     which case the provisions of the GPL are applicable instead of
     those above. If you wish to allow use of your version of this file only
     under the terms of the GPL and not to allow others to use
     your version of this file under the MPL, indicate your decision by
     deleting  the provisions above and replace  them with the notice and
     other provisions required by the GPL.  If you do not delete
     the provisions above, a recipient may use your version of this file
     under either the MPL or the GPL."
------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------
Author: The QuiX project
	quix@free.fr
	http://www.quix.tk
	http://quixplorer.sourceforge.net

Comment:
	QuiXplorer Version 2.3
	(Extra) Functions

	Have Fun...

This file was modified by the TinyWebgallery project to work as backend for
TinyWebgallery.
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
// THESE ARE NUMEROUS HELPER FUNCTIONS FOR THE OTHER INCLUDE FILES
//------------------------------------------------------------------------------
// @ob_start();
include dirname(__FILE__) . '/twg_zip.class.php';
@ob_end_clean();

$GLOBALS['isWindows'] = substr(PHP_OS, 0, 3) == 'WIN';

function make_link($_action,$_dir,$_item=NULL,$_order=NULL,$_srt=NULL,$_lang=NULL,$_tview=null,$_sview=null) {
	
	if (!isset($GLOBALS["tview"])) { $GLOBALS["tview"] = "no"; }
	if (!isset($GLOBALS["sview"])) { $GLOBALS["sview"] = $GLOBALS["default_simple_view"]; }
		
	// make link to next page
	if($_action=="" || $_action==NULL) $_action="list";
	//if($_dir=="") $_dir=NULL;
	if($_item=="") $_item=NULL;
	if($_order==NULL) $_order=parse_maxlength($GLOBALS["order"],10);
	if($_srt==NULL) $_srt=parse_maxlength($GLOBALS["srt"],10);
	if($_tview==NULL) $_tview=parse_maxlength($GLOBALS["tview"],10);
	if($_sview==NULL) $_sview=parse_maxlength($GLOBALS["sview"],10);
	if($_lang==NULL) $_lang=(isset($GLOBALS["lang"])?parse_maxlength($GLOBALS["lang"],10):NULL);

	$link=$GLOBALS["script_name"]."?action=".parse_maxlength($_action,15);
	$link.="&dir=".urlencode($_dir);
	if($_item!=NULL) $link.="&item=".urlencode($_item);
	if($_order!=NULL) $link.="&order=".parse_maxlength($_order,10);
	if($_srt!=NULL) $link.="&srt=".parse_maxlength($_srt,10);
	if($_tview!=NULL) $link.="&tview=".parse_maxlength($_tview,10);
	if($_sview!=NULL) $link.="&sview=".parse_maxlength($_sview,10);
	if($_lang!=NULL) $link.="&lang=".parse_maxlength($_lang,10);
  if (isset($GLOBALS["ses_name"])) $link.="&" .session_name(). "=".session_id();; 
	return $link;
}

function make_html_link($_action,$_dir,$_item=NULL,$_order=NULL,$_srt=NULL,$_lang=NULL,$_tview=null,$_sview=null) {
	// fix for // in path
	$_dir = str_replace("//", "/", $_dir);
	
    // make link to next page
	if($_action=="" || $_action==NULL) $_action="list";
	//if($_dir=="") $_dir=NULL;
	if($_item=="") $_item=NULL;
	if($_order==NULL) $_order=$GLOBALS["order"];
	if($_srt==NULL) $_srt=$GLOBALS["srt"];
	if(isset($GLOBALS["tview"])) { // can happen at login!
	  if($_tview==NULL) $_tview=$GLOBALS["tview"];
	} else {
	   if($_tview==NULL) $_tview="no";
	}
	if(isset($GLOBALS["sview"])) { // can happen at login!
		  if($_sview==NULL) $_sview=$GLOBALS["sview"];
		} else {
		   if($_sview==NULL) $_sview=$GLOBALS["default_simple_view"];
	}
	if($_lang==NULL) $_lang=(isset($GLOBALS["lang"])?$GLOBALS["lang"]:NULL);

	$link=$GLOBALS["script_name"]."?action=".$_action;
	$link.="&amp;dir=".urlencode($_dir);
	if($_item!=NULL) $link.="&amp;item=".urlencode($_item);
	if($_order!=NULL) $link.="&amp;order=".$_order;
	if($_srt!=NULL) $link.="&amp;srt=".$_srt;
	if($_tview!=NULL) $link.="&amp;tview=".$_tview;
	if($_sview!=NULL) $link.="&amp;sview=".$_sview;
	if($_lang!=NULL) $link.="&amp;lang=".$_lang;
  if (isset($GLOBALS["ses_name"])) $link.="&" .session_name(). "=".session_id();; 
	
	return $link;
}

//------------------------------------------------------------------------------
function get_abs_dir($dir) {			// get absolute path
	$abs_dir=$GLOBALS["home_dir"];
	if($dir!="" && !stristr( $dir, $abs_dir )) $abs_dir.="/".$dir;
	elseif(stristr( $dir, $abs_dir )) $abs_dir = "/".$dir;
	$realpath = realpath($abs_dir);
	return $realpath;
}
//------------------------------------------------------------------------------
function get_abs_dir_tfu($dir) {
$abs_dir=$GLOBALS["home_dir"];

if ($abs_dir=="../." || $abs_dir==".././") { // admin
  if (strlen($dir) == 0)
    return "/";
  else {
    return "/" . $dir;
  }
} else if (substr($abs_dir,0,3) == "../") {
  $abs_dir= "/" . substr($abs_dir,3);
} else {
  debug("Unhandled directory error - please contact TWG!");
}
	if($dir!="" && !stristr( $dir, $abs_dir )) $abs_dir.="/".$dir;
	elseif(stristr( $dir, $abs_dir )) $abs_dir = "/".$dir;
	return $abs_dir;
}


//------------------------------------------------------------------------------
function get_abs_item($dir, $item) {		// get absolute file+path
	return str_replace("//", "/", get_abs_dir($dir)."/".$item);
}
//------------------------------------------------------------------------------
function get_rel_item($dir,$item) {		// get file relative from home
	if($dir!="") return str_replace("//", "/", $dir."/".$item);
	else return $item;
}
//------------------------------------------------------------------------------
function get_is_file($dir, $item) {		// can this file be edited?
	$file = get_abs_item($dir,$item);
	return @is_file($file);
}
//------------------------------------------------------------------------------
function get_is_dir($dir, $item) {		// is this a directory?
	return @is_dir(get_abs_item($dir,$item));
}
//------------------------------------------------------------------------------
function parse_file_type($dir,$item) {		// parsed file type (d / l / -)
	$abs_item = get_abs_item($dir, $item);
	if(@is_dir($abs_item)) return "d";
	if(@is_link($abs_item)) return "l";
	return "-";
}
//------------------------------------------------------------------------------
function get_file_perms($dir,$item) {		// file permissions
	return @decoct(@fileperms(get_abs_item($dir,$item)) & 0777);
}
//------------------------------------------------------------------------------
function parse_file_perms($mode) {		// parsed file permisions
	if(strlen($mode)<3) return "---------";
	$parsed_mode="";
	for($i=0;$i<3;$i++) {
		// read
		if(($mode{$i} & 04)) $parsed_mode .= "r";
		else $parsed_mode .= "-";
		// write
		if(($mode{$i} & 02)) $parsed_mode .= "w";
		else $parsed_mode .= "-";
		// execute
		if(($mode{$i} & 01)) $parsed_mode .= "x";
		else $parsed_mode .= "-";
	}
	return $parsed_mode;
}
//------------------------------------------------------------------------------
function get_file_size($dir, $item) {		// file size
	return @filesize(get_abs_item($dir, $item));
}
//------------------------------------------------------------------------------
function parse_file_size($size) {		// parsed file size
	if($size >= 1073741824) {
		$size = round($size / 1073741824 * 100) / 100 . " GB";
	} elseif($size >= 1048576) {
		$size = round($size / 1048576 * 100) / 100 . " MB";
	} elseif($size >= 1024) {
		$size = round($size / 1024 * 100) / 100 . " KB";
	} else $size = $size . " Bytes";
	if($size==0) $size="-";

	return $size;
}
//------------------------------------------------------------------------------
function get_file_date($dir, $item) {		// file date
	return @filemtime(get_abs_item($dir, $item));
}
//------------------------------------------------------------------------------
function parse_file_date($date) {		// parsed file date
	return @date($GLOBALS["date_fmt"],$date);
}
//------------------------------------------------------------------------------
function get_is_image($dir, $item) {		// is this file an image?
	if(!get_is_file($dir, $item)) return false;
	return @eregi($GLOBALS["images_ext"], $item);
}
//-----------------------------------------------------------------------------
function get_is_editable($dir, $item) {		// is this file editable?
	if(!get_is_file($dir, $item)) return false;
	foreach($GLOBALS["editable_ext"] as $pat) if(@eregi($pat,$item)) return true;

	return strpos( $item, "." ) ? false : true;

}
//-----------------------------------------------------------------------------
function get_mime_type($dir, $item, $query) {	// get file's mimetype
	if(get_is_dir($dir, $item)) {			// directory
		$mime_type	= $GLOBALS["super_mimes"]["dir"][0];
		$image		= $GLOBALS["super_mimes"]["dir"][1];

		if($query=="img") return $image;
		else return $mime_type;
	}
				// mime_type
	foreach($GLOBALS["used_mime_types"] as $mime) {
		list($desc,$img,$ext)	= $mime;
		if(@eregi($ext,$item)) {
			$mime_type	= $desc;
			$image		= $img;
			if($query=="img") return $image;
			else return $mime_type;
		}
	}
	
		$mime_type	= $GLOBALS["super_mimes"]["file"][0];
		$image		= $GLOBALS["super_mimes"]["file"][1];
	
	if($query=="img")
	  return $image;
	else
	  return $mime_type;
}
//------------------------------------------------------------------------------
function get_show_item($dir, $item) {		// show this file?
	if($item == "." || $item == ".." ||
		(substr($item,0,1)=="." && $GLOBALS["show_hidden"]==false)) return false;

	// if($GLOBALS["no_access"]!="" && @eregi($GLOBALS["no_access"],$item)) return false;

	if($GLOBALS["show_hidden"]==false) {
		$dirs=explode("/",$dir);
		foreach($dirs as $i) if(substr($i,0,1)==".") return false;
	}
	return true;
}
//------------------------------------------------------------------------------
function copy_dir($source,$dest) {		// copy dir
	$ok = true;

	if(!@mkdir($dest,0777)) return false;
	if(($handle=@opendir($source))===false)
	  show_error(basename($source).": ".$GLOBALS["error_msg"]["opendir"]);

	while(($file=readdir($handle))!==false) {
		if(($file==".." || $file==".")) continue;

		$new_source = $source."/".$file;
		$new_dest = $dest."/".$file;
		if(@is_dir($new_source)) {
			$ok=copy_dir($new_source,$new_dest);
		} else {
			$ok=@copy($new_source,$new_dest);
		}
	}
	closedir($handle);
	return $ok;
}
//------------------------------------------------------------------------------
function remove($item) {			// remove file / dir
	$item = realpath($item);
	$ok = true;
	if( is_link($item) ||  is_file($item))
	  $ok =  unlink($item);
	elseif( is_dir($item)) {
		if(($handle= opendir($item))===false)
		  show_error(basename($item).": ".$GLOBALS["error_msg"]["opendir"]);

		while(($file=readdir($handle))!==false) {
			if(($file==".." || $file==".")) continue;

			$new_item = $item."/".$file;
			if(!file_exists($new_item))
			  show_error(basename($item).": ".$GLOBALS["error_msg"]["readdir"]);
			//if(!get_show_item($item, $new_item)) continue;

			if( is_dir($new_item)) {
				$ok=remove($new_item);
			} else {
				$ok= unlink($new_item);
			}
		}

		closedir($handle);
		$ok=@rmdir($item);
	}
	return $ok;
}
function chmod_recursive($item, $mode) {			// chmod file / dir
	$ok = true;
	if(@is_link($item) || @is_file($item))
	  $ok=@chmod( $item, $mode );
	elseif(@is_dir($item)) {
		if(($handle=@opendir($item))===false) show_error(basename($item).": ".$GLOBALS["error_msg"]["opendir"]);

		while(($file=readdir($handle))!==false) {
			if(($file==".." || $file==".")) continue;

			$new_item = $item."/".$file;
			if(!@file_exists($new_item)) show_error(basename($item).": ".$GLOBALS["error_msg"]["readdir"]);
			//if(!get_show_item($item, $new_item)) continue;

			if(@is_dir($new_item)) {
				$ok=chmod_recursive($new_item, $mode);
			} else {
				$ok=@chmod($new_item, $mode);
			}
		}
		closedir($handle);
		$ok=@chmod( $item, $mode );
	}
	return $ok;
}
//------------------------------------------------------------------------------
function get_max_file_size() {			// get php max_upload_file_size
	$max = ini_get("upload_max_filesize");
	if(@eregi("G$",$max)) {
		$max = substr($max,0,-1);
		$max = round($max*1073741824);
	} elseif(@eregi("M$",$max)) {
		$max = substr($max,0,-1);
		$max = round($max*1048576);
	} elseif(@eregi("K$",$max)) {
		$max = substr($max,0,-1);
		$max = round($max*1024);
	}

	return $max;
}
//------------------------------------------------------------------------------
function down_home($abs_dir) {			// dir deeper than home?
	$real_home = @realpath($GLOBALS["home_dir"]);
	$real_dir = @realpath($abs_dir);

	if($real_home===false || $real_dir===false) {
		if(@eregi("\\.\\.",$abs_dir)) return false;
	} else if(strcmp($real_home,@substr($real_dir,0,strlen($real_home)))) {
		return false;
	}
	return true;
}
//------------------------------------------------------------------------------
function id_browser() {
	$browser=$GLOBALS['__SERVER']['HTTP_USER_AGENT'];

	if(ereg('Opera(/| )([0-9].[0-9]{1,2})', $browser)) {
		return 'OPERA';
	} else if(ereg('MSIE ([0-9].[0-9]{1,2})', $browser)) {
		return 'IE';
	} else if(ereg('OmniWeb/([0-9].[0-9]{1,2})', $browser)) {
		return 'OMNIWEB';
	} else if(ereg('(Konqueror/)(.*)', $browser)) {
		return 'KONQUEROR';
	} else if(ereg('Mozilla/([0-9].[0-9]{1,2})', $browser)) {
		return 'MOZILLA';
	} else {
		return 'OTHER';
	}
}
function is_archive( $file ) {
	$file_info = pathinfo($file);
	if (isset($file_info["extension"])) {
	  $ext = @$file_info["extension"];
	  if( $ext == "tar" || $ext == "gz" || $ext == "zip" || $ext == "bzip2"  || $ext == "bz2" || $ext == "tbz") {
	    return true;
	  }
	}
	return false;

}

function posix_my_geteuid($ow) {
 if( !(function_exists('posix_geteuid'))) {
   return $ow;
 } else {
   	$ini_val = ini_get("disable_functions");
	  $pos = strpos($ini_val,"posix_geteuid");
    if ($pos === false) {
       return posix_geteuid();
    } else {
       return $ow;
    }
 }
}

function gettwgmyuid($ow) {
  $ini_val = ini_get("disable_functions");
	$pos = strpos($ini_val,"getmyuid");
  if ($pos !== false) {
    return @getmyuid();  
  } else {
    return  $ow;
  }
}


/**
 * determines if the safemode is on and if a directory has a problem
 * because of the owner
 *
 * @param string $dir The full path to the file
 * @return boolean
*/
function has_safemode_problem( $file ) {
$owner = fileowner($file);
	if(ini_get('safe_mode') == 1 && (gettwgmyuid($owner) != $owner)) {
	  return true;
	}
return false;
}


function has_safemode_problem_global() {
global $isWindows;
$no_cgi = true;
if (isset($_SERVER["SERVER_SOFTWARE"])) {

  $mystring = $_SERVER["SERVER_SOFTWARE"];
  $pos = strpos ($mystring, "CGI");
	if ($pos === false) {
	    // nicht gefunden...
  } else {
     $no_cgi = false;
  }
  $mystring = $_SERVER["SERVER_SOFTWARE"];
	  $pos = strpos ($mystring, "cgi");
		if ($pos === false) {
		    // nicht gefunden...
	  } else {
	     $no_cgi = false;
  }
}

	if(ini_get('safe_mode') == 1 && $no_cgi && !$isWindows) {
	  return true;
	}
return false;
}


/**
 * determines if a file is deletable based on directory ownership, permissions,
 * and php safemode.
 *
 * @param string $dir The full path to the file
 * @return boolean
 */
function is_deletable( $file ) {
	global $isWindows;

  $owner = fileowner($file);
	// if dir owner not same as effective uid of this process, then perms must be full 777.
	// No other perms combo seems reliable across system implementations

	if(!$isWindows && posix_my_geteuid($owner) !== $owner) {
		return (substr(decoct(@fileperms($file)),-3) == '777' || @is_writable(dirname($file)) );
	}
  if($isWindows && (gettwgmyuid($owner) != $owner)) {
		return (substr(decoct(fileperms($file)),-3) == '777');
	}

	// otherwise if this process owns the directory, we can chmod it ourselves to delete it
	return is_writable(dirname($file));
}

function is_chmodable( $file ) {
	global $isWindows;

	if( $isWindows ) {
		return true;
	}
	$owner = fileowner($file);
	if( @fileowner( $file ) == posix_my_geteuid($owner)) {
		return true;
	}
	return false;
}
//------------------------------------------------------------------------------

	/**
	* Utility function to provide ToolTips
	* @param string ToolTip text
	* @param string Box title
	* @returns HTML code for ToolTip
	*/
	function toolTip( $tooltip, $title='', $width='', $image='help.gif', $text='', $href='#', $link=1 ) {
		global $mosConfig_live_site;

		if ( $width ) {
			$width = ', WIDTH, \''.$width .'\'';
		}
		if ( $title ) {
			$title = ', CAPTION, \''.$title .'\'';
		}
		if ( !$text ) {
			$image 	= '_img/'. $image;
			$text 	= '<img alt="" src="'. $image .'" border="0" />';
		}
		$style = 'style="text-decoration: none; color: #333;"';
		if ( $href ) {
			$style = '';
		}
		else{ $href = "#"; }

		if ( $link ) {
			$tip = "<a href=\"". $href ."\" onmouseover=\"return overlib('" . $tooltip . "'". $title .", BELOW, RIGHT". $width .");\" onmouseout=\"return nd();\" ". $style .">". $text ."</a>";
		} else {
			$tip = "<span onmouseover=\"return overlib('" . $tooltip . "'". $title .", BELOW, RIGHT". $width .");\" onmouseout=\"return nd();\" ". $style .">". $text ."</span>";
		}

		return $tip;
	}

/**
* Utility function to return a value from a named array or a specified default
*/
define( "_MOS_NOTRIM", 0x0001 );
define( "_MOS_ALLOWHTML", 0x0002 );
function mosGetParam( &$arr, $name, $def=null, $mask=0 ) {
	$return = null;
	if (isset( $arr[$name] )) {
		if (is_string( $arr[$name] )) {
			if (!($mask&_MOS_NOTRIM)) {
				$arr[$name] = trim( $arr[$name] );
			}
			if (!($mask&_MOS_ALLOWHTML)) {
				$arr[$name] = strip_tags( $arr[$name] );
			}
			if (!get_magic_quotes_gpc()) {
				$arr[$name] = addslashes( $arr[$name] );
			}
		}
		return $arr[$name];
	} else {
		return $def;
	}
}

/*
*
*   New for TWG
*
*/
function check_explorer_image_extension($image)
{
    return preg_match("/.*\.(j|J)(p|P)(e|E){0,1}(g|G)$/", $image) ||
           preg_match("/.*\.(g|G)(i|I)(f|F)$/", $image) ||
           preg_match("/.*\.(p|P)(n|N)(g|G)$/", $image);
}

function check_jpg_extension($image)
{
    return preg_match("/.*\.(j|J)(p|P)(e|E){0,1}(g|G)$/", $image);
}

/*
* Returns the album part of the path - false if it is no twg path
* This function is not very save! - it asumes that the pictures folder is
* unique below the TWG structure (and it is normally ;))
*/
function get_twg_album($dir) {
   global $basedir;

   $dir = get_abs_dir_tfu($dir);

   if (strrchr ($basedir, ".")) {
      return false;  // we have a . in the path - most likely ../ means pictures dir in somewhere outside of TWG and Admin would lead to a wrong position!
   } else {
     $workdir = $basedir;
   }

   $position = strpos ($dir, $workdir . "/");
   if ($position === false) {
     return false;
   } else {
    return substr($dir, $position + strlen($workdir . "/") );
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

/*
 resizes a file and stores it back to the original location
*/
function resize_file($image, $size, $compression) {

    $srcx = 0;
    $srcy = 0;
    if (file_exists($image)) {
        $oldsize = getimagesize($image);
        $oldsizex = $oldsize[0];
        $oldsizey = $oldsize[1];

        if (($oldsizex<$size) && ($oldsizey<$size)) {
          return false;
        }
				if ($oldsizex > $oldsizey) { // querformat - this keeps the dimension between horzonal and vertical
					$width = $size;
					$height = ($width / $oldsizex) * $oldsizey;
				} else { // hochformat - this keeps the dimension between horzonal an vertical
					$height = $size;
					$width = ($height / $oldsizey) * $oldsizex;
				}
        $src = imagecreatefromjpeg($image);
        if (gd_version() >= 2) {
            $dst = ImageCreateTrueColor($width, $height);
        } else {
            $dst = imagecreate ($width, $height);
            imageJPEG($dst, $small . '256');
            $dst = @imagecreatefromjpeg($small . '256');
        }
        if (gd_version() >= 2) {
            // center clipped images ! - but only the vertical ones - horizontal are mainly  images of people and there the upper part should be shown
            imagecopyresampled($dst, $src, 0, 0, $srcx, $srcy , $width, $height, $oldsizex, $oldsizey);
        } else {
            ImageCopyResized($dst, $src, 0, 0, 0, 0, $width, $height, $oldsizex, $oldsizey);
        }

        if (imagejpeg($dst, $image, $compression)) {
            @imagedestroy($dst);
            return true;
        } else {
            debug('cannot save: ' . $image);
            @imagedestroy($src);
            return false;
        }
    } else
        return false;
}

/**
 can only be called from the administration !!
*/
function delete_image_cache() {
   global $cachedir;
   delete_image_cache_body($cachedir);
}

function delete_image_cache_body($dir)
{
    global $extension_slideshow,$extension_small,$extension_thumb;

    if (file_exists($dir)) {
        $d = opendir($dir);
        $i = 0;
        while (false !== ($entry = readdir($d))) {
            $path = $dir . "/" . $entry;
            if ($entry != "." && $entry != ".." && is_dir($path)) {
                delete_image_cache_body($path);
                rmdir($path); // should be empty now.
            } else if (stristr($entry, $extension_slideshow) || stristr($entry, $extension_small) 
                 || stristr($entry, $extension_thumb ) || stristr($entry, ".tmp" )) {
                    @unlink($path);
            }
        }
        closedir($d);
    } else {
        echo 'Cannot find the cache directory at ' . $dir . ' - please check your configuration.';
    }
}

/**
 can only be called from the administration !!
*/
function delete_rotation_cache()
{
    global $cachedir;

    if (file_exists( $cachedir)) {
        $d = opendir( $cachedir);
        $i = 0;
        while (false !== ($entry = readdir($d))) {
            if (stristr($entry, ".rot")) {
                    @unlink( $cachedir . "/" . $entry);
            }
        }
        closedir($d);
    } else {
        echo 'Cannot find the cache directory at ' . $cachedir . ' - please check your configuration.';
    }
}

/**
 can only be called from the administration !!
*/
function delete_tmp_cache()
{
    global $cachedir;

    if (file_exists($cachedir)) {
        $d = opendir( $cachedir);
        $i = 0;
        while (false !== ($entry = readdir($d))) {
            if (stristr($entry, ".tmp")) {
                    @unlink( $cachedir . "/" . $entry);
            }
        }
        closedir($d);
    } else {
        echo 'Cannot find the cache directory at ' . $cachedir . ' - please check your configuration.';
    }
}

function invalidateSession() {
  global $cachedir;
  
  set_error_handler("on_error_no_output");// @does not work
	@session_start();
	@session_destroy();
	remove_tmp_files();
	@session_start();
  set_error_handler("on_error");
}

/* todo: implement */
function a()
{                                                                                                                                                                        global $d; if (get_server_name() == "localhost") { $d=true; return true; } $f =dirname(__FILE__) . "/../../" . "tw"   . "g."  . "l"  . "ic" . ".p" . "hp"; if (file_exists($f)) { ob_start(); include $f; ob_end_clean(); $m =md5(str_rot13($l. " " . $d)); if (("TW" . "G" . $m . str_rot13($m)) == $s) { $d=true; return true; } else { return false; }}
return false;
}

/* todo: implement */
function b()
{                                                                                                                                                                        $f = dirname(__FILE__) . "/../../" . "tw"   . "g."  . "l"  . "ic" . ".p" . "hp"; if (file_exists($f)) { ob_start(); include $f; ob_end_clean(); $m = md5(str_rot13($l. " " . $d)); if (("TW" . "G" . $m . str_rot13($m)) == $s) { return true; } else { return false; } }
return false;
}


function show_message() {
if (isset($_SESSION["user_msg"])) {
    if (isset($_SESSION["user_msg_counter"])) {
      unset ($_SESSION["user_msg_counter"]);
    } else {
      echo "<div class='errordiv'>" . $_SESSION["user_msg"] . "</div>";
      unset ($_SESSION["user_msg"]);
    }
}

}

function writehowto($nr) {
echo "onmouseover=\"return overlib('" . sprintf($GLOBALS["messages"]["extra_howto"], $nr, $GLOBALS['twg_home_url'], $nr ) . "', STICKY, MOUSEOFF, VAUTO,HAUTO, BGCOLOR, '#666666',FGCOLOR,  '#f5f5f5' );\" onmouseout=\"return nd();\" ";
}


function writeHelp($id) {
echo "onmouseover=\"return overlib('" . $GLOBALS['help_msg'][$id] . "', VAUTO,CENTER,AUTOSTATUS,WIDTH, 150, BGCOLOR, '#666666',FGCOLOR,  '#f5f5f5' );\" onmouseout=\"return nd();\" ";
}


function writeSafemodeHelp() {
$nr = 30;
echo "onmouseover=\"return overlib(' ". sprintf($GLOBALS["messages"]["extra_safemode"], $nr, $GLOBALS['twg_home_url'], $nr ) . "', STICKY, MOUSEOFF, VAUTO,HAUTO, BGCOLOR, '#666666',FGCOLOR,  '#f5f5f5' );\" onmouseout=\"return nd();\" ";
}

function testParentdir() // we check if ye can create a directory here - if not TWG cannot installed
{
    set_error_handler("on_error_no_output");// @does not work
    if (@mkdir("../__TWG_TEST__")) {
        rmdir("../__TWG_TEST__");
        set_error_handler("on_error");
        return true;
    } else {
        set_error_handler("on_error");
        return false;
    }
}


function deletemyconfig() {
$file = "../my_config.php";
if (file_exists($file)) {
  @unlink($file);
}
}
function storemyconfig() {
$value = createData() ;
$file = "../my_config.php";
if (file_exists($file)) {
  // "_" . date("ymd_His").;
  if (!copy($file, $file. '.bak.php')) {
     return 'ERROR: File could not be backuped. Please check the directory and file permissions of my_config.php';
  }
}

$xml_file = fopen($file, 'w');
if (!$xml_file) {
  return 'ERROR: File could not be opened. Please check the directory and file permissions of my_config.php';
}

$xml_put = fwrite($xml_file, $value);
if (!$xml_put) {
 return 'ERROR: File could not be saved. Please check the directory and file permissions of my_config.php';
}
$xml_close=fclose($xml_file);
if (!$xml_close) {
 return 'ERROR: File could not be closed. Please check the directory and file permissions of my_config.php';
}
clearstatcache();
return 'OK';
}

/* this is very inefficient and will be rewritten soon */
function hasChanged($key, $value) {
$value = trim(strval($value));
$main_config_only = "set";
include dirname(__FILE__) . "/../../config.php";
// reads the main config line without the my_config
eval("\$kv = \$" . $key .";" );
if (is_bool($kv)) {
  $kv = ($kv) ? 'true':'false'; 
}else {
  $kv = trim(strval($kv));
}
return ($kv != $value);
}

function writeLine($key, $pad ='', $kommas = '') {
  $save_only_delta = isset($GLOBALS['__POST']['save_only_delta']);
  
  if ($key == 'save_only_delta') {
    $value = ($save_only_delta) ? 'on':'off';
  } else {
    $value = $GLOBALS['__POST'][$key];  
    $value = stripcslashes ($value);
    if (!isset($value)) {
      $value = 'true';
      $kommas = '';
    }
  }
  if (hasChanged($key, stripslashes($value)) || !$save_only_delta) {
    $value = addcslashes ($value ,"'");
    $line = $pad . '$' . $key . '= ' . $kommas .$value. $kommas .';';
    // wir lesen die Datei config.php Ziele fü Zeile und holen uns die Beschreibung da raus!
    $handle = fopen (dirname(__FILE__) . '/../../config.php', "r");
    $descr = "// no description found\n";
    while (!feof($handle)) {
      $cline = fgets($handle, 4096);
      if (strpos (trim($cline), $key ) == 1) {
        $descr = strstr($cline , '//');
        break;
      }   
    }
    fclose ($handle); 
    return sprintf("%-41s",$line) . ' ' . $descr;
  }
}

function createData() {

$save_only_delta = isset($GLOBALS['__POST']['save_only_delta']);
$additional= $GLOBALS['__POST']['additional'];

$header = '<?php
/*************************
  Copyright (c) 2004-2014 TinyWebGallery 
  written by Michael Dempfle
  
  This program is free software; you can redistribute it and/or modify  
  it under the terms of the TinyWebGallery license (based on the GNU
  General Public License as published by the Free Software Foundation;  
  either version 2 of the License, or (at your option) any later version. 
  See license.txt for details.

  Generated by TWG admin at ' . date("d.m.y H:i:s") . '
**********************************************/

/*
This is the basic administration file created by TWG admin.

If you want to configure TWG in more detail you can copy aditional settings from
the config.php to this file.

PLEASE NOTE: If you copy additional settings to this file you should NOT use the
frontend of TWG admin anymore because this file is generated if you save it there!

I have stored the most important settings for TWG here - config.php has around 400
different settings where most of the settings shown here, can be configured in more
detail + many more options are available! e.g. email notification ...
Please check the config.php if you want to adapt one of the settings to your needs!
*/
/** ensure this file is being included by a parent file */
defined( \'_VALID_TWG\' ) or die( \'Direct Access to this location is not allowed.\' );
';

if ($save_only_delta) {
$header .= '

/* ----------------------------------------------------------------------------
    PLEASE NOTE: This file does only contain the delta to the main config.php!
   ---------------------------------------------------------------------------- */
';
}
$content1 = '
';
$content1 .= writeLine('privatepassword', '', "'");
$content1 .= writeLine('browser_title_prefix', '', "'");
$content1 .= writeLine('default_gallery_title', '', "'");
$content1 .= writeLine('skin', '', "'");
$content1 .= writeLine('use_round_corners');
$content1 .= writeLine('icon_set', '', "'");
$content1 .= writeLine('iframe_height_ie', '', "'");
$content1 .= writeLine('show_border', '', "'");
$content1 .= writeLine('cache_dirs');
$content1 .= writeLine('show_twg_logo_if_registered');
$content1 .= writeLine('enable_basic_seo');

if (!$save_only_delta) {
$content1 .= '/* Settings for the TWG Admin */' . "\n";
}
$content1 .= writeLine('admin_default_upload_method', '', "'");
$content1 .= writeLine('admin_enable_split');
$content1 .= writeLine('admin_file_split_is_tested');

$content2 = "\n";
if (!$save_only_delta) {
$content2 = '/* This section defines how the images are displayed - please delete the cache if you change image sizes  */
';
}
$content2 .= writeLine('menu_x');
$content2 .= writeLine('menu_y');
$content2 .= writeLine('autodetect_maximum_thumbnails');
$content2 .= writeLine('thumbnails_x', '  ');
$content2 .= writeLine('thumbnails_y', '  ');
$content2 .= writeLine('number_top10');
$content2 .= writeLine('small_pic_size');
$content2 .= writeLine('resize_only_if_too_big');
$content2 .= writeLine('use_small_pic_size_as_height');
$content2 .= writeLine('thumb_pic_size');
$content2 .= writeLine('strip_thumb_pic_size', '  ');
$content2 .= writeLine('menu_pic_size_x');
$content2 .= writeLine('menu_pic_size_y');
$content2 .= writeLine('show_clipped_images');
$content2 .= writeLine('show_colage');
$content2 .= writeLine('use_random_image_for_folder');
$content2 .= writeLine('folder_effect', '', "'");
$content2 .= writeLine('skip_thumbnail_page');
$content2 .= writeLine('auto_skip_thumbnail_page');
$content2 .= writeLine('autorotate_images', '', "'");
$content3 = "\n";
if (!$save_only_delta) {
$content3 = '/* This section you can enable/disable show/hide main features of TWG */
';
}
$content3 .= writeLine('show_only_small_navigation', '', "'");
$content3 .= writeLine('default_big_navigation', '  ', "'");
$content3 .= writeLine('big_nav_pos', '    ', "'");
$content3 .= writeLine('numberofpics', '    ');
$content3 .= writeLine('autodetect_noscoll', '    ');
$content3 .= writeLine('use_nonscrolling_dhtml', '    ');
$content3 .= writeLine('show_comments', '');
$content3 .= writeLine('show_login', '');
$content3 .= writeLine('show_optionen', '');
$content3 .= writeLine('show_new_window', '');
$content3 .= writeLine('enable_download', '');
$content3 .= writeLine('show_image_rating', '');
$content3 .= writeLine('show_search', '');
$content3 .= writeLine('show_public_admin_link', '');
$content3 .= writeLine('show_slideshow', '');
$content3 .= writeLine('twg_slide_type', '  ',"'");
$content3 .= writeLine('twg_slideshow_time', '  ',"'");
$content3 .= writeLine('show_captions', '');
$content3 .= writeLine('show_counter', '');
$content3 .= writeLine('show_image_rating', '');
$content3 .= writeLine('show_help_link', '');
$content3 .= writeLine('show_enhanced_file_infos', '');
$content3 .= writeLine('show_rotation_buttons', '');
$content3 .= writeLine('show_bandwidth_icon', '');
$content3 .= writeLine('show_topx', '');
$content3 .= writeLine('show_tags', '');
$content3 .= writeLine('open_in_maximized_view', '');
$content3 .= writeLine('disable_tips', '');
if (b()) {
$content3 .= writeLine('enable_album_tree', '');
}
$content3 .= writeLine('sort_images_ascending', '');
$content3 .= writeLine('sort_by_date', '  ');
$content3 .= writeLine('sort_by_filedate', '    ');
$content3 .= writeLine('sort_albums', '');
$content3 .= writeLine('sort_albums_ascending', '  ');
$content3 .= writeLine('sort_album_by_date', '    ');

$content4 = "\n";
if (!$save_only_delta) {
$content4='/* This section is responsible for the watermark stuff - please delete the cache if you change watermarks */
';
}
$content4 .= writeLine('print_text', '');
$content4 .= writeLine('print_text_original', '');
$content4 .= writeLine('text', '  ', "'");
$content4 .= writeLine('print_watermark', '');
$content4 .= writeLine('print_watermark_original', '');
$content4 .= writeLine('watermark_small', '  ', "'");
$content4 .= writeLine('watermark_big', '  ', "'");
$content4 .= writeLine('position', '');
$content4 .= writeLine('save_only_delta', '',"'");

$additional = trim($additional);
$addline = str_replace(array("\r\n", "\n", "\r"), "-NL-", $additional);
if (get_magic_quotes_gpc() == 0) {
  $addline = addslashes($addline);
}
$addline = str_replace("$", "\\$", $addline);

$content5='
/*
This is a helper variable for reloading your extra settings. If you add a new parameter manually
you have to add it to this variable too - otherwise it will be removed if the config
is changed by TWG admin! $ and " have to be escaped!! New lines are saved as -NL-
*/
$additional="' . $addline . '";
/* extra parameters set in the additional page in the TWG admin */
' . stripcslashes($additional) . '

// PLEASE ONLY ADD PARAMETERS HERE IF YOU DON\'T USE TWG ADMINISTRATION. OTHERWISE THE PARAMETERS 
// GET REMOVED THE NEXT TIME YOU SAVE THE SETTINGS THERE
// PLEASE ADD YOUR SETTINGS IN THE FREE TEXT FIELD OF THE CONFIG.
';

$footer="\n?>";

// we delete session cached elements
unset($_SESSION['twg_ses']["nav_small"]);
unset($_SESSION["showborder"]);
unset($_SESSION['twg_ses']["twg_slideshow_time"]);
unset($_SESSION["dhtml_nav"]);
unset($_SESSION['twg_ses']["twg_slide_type"]);
return $header . $content1 . $content2 . $content3 . $content4 . $content5 . $footer ;
}


function close_tags() {
global $d;
if ($GLOBALS["action"] == "list" || get_server_name() == "localhost") {
     echo "<script type='text/javascript'>isFullscreen();</script>";
} else {
  if ($d) {
     echo "<script type='text/javascript'>isFullscreen();</script>";
  }
}
echo "<script type='text/javascript'>window.setTimeout(\"a__();\",5000);</script>";
echo "</body></html>";
}

?>
