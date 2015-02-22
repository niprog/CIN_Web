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
// I check if there is at least one parameter!
if (count($_GET) == 0) { echo 'Parameters needed'; exit; }

include "i_basic.inc.php";
set_error_handler("on_error_no_output"); // 4.x gives depreciated errors here but if I change it it does only work with 5.x - therefore I don't show any errors here !
include "../inc/exif.inc.php";
include "../inc/exifReader.inc.php";
set_error_handler("on_error");

$skinphp = $basedir . "/" . $twg_album . "/config.php";
if (file_exists($skinphp)) {
	include $skinphp;
}
$configphp_lang = $basedir . "/" . $twg_album . "/config_".$default_language.".php";
			if (file_exists($configphp_lang)){
			    include $configphp_lang;
}

if (!isset($show_exif_info)) {
	$show_exif_info = true;
}

include "../inc/readxml.inc.php";

$remote_image = twg_checkurl($basedir . "/" . $twg_album);

if ($remote_image) {
	$filename = getRemoteImagePath($remote_image, $image);
} else {
	$filename = $basedir . "/" . $twg_album . "/" . $image;
}
// we check if it is an other fileformat!
$isOther = false;
foreach($other_file_formats as $label => $key) {
	$other_format = exchangeExtension($filename, $label);
	if (file_exists($other_format)) {
		$isOther = exchangeExtension($image, $label);
		$filename = $isOther = $other_format;
	}
}

$other_format = removeExtension($filename);
if (file_exists($other_format)) {
	$filename = $isOther = $other_format;
}

$fokus = "";
include "i_header.inc.php";
include "i_body_head.inc.php"; // body and closebutton

if ($show_enhanced_file_infos) {
?>
<center>
<table summary=''  style="width: 80%; height:90px" cellpadding='0' cellspacing='0'>
<tr class="gray"><td class="fileinfoleft"><?php echo $lang_fileinfo_views;

?></td><td class="fileinforight"><?php echo increaseImageCount($twg_album, $image) ?></td></tr>

<?php
if ($show_download_counter && $enable_download_counter) {
	echo '
<tr><td class="fileinfoleftbottom">' . $lang_fileinfo_dl . '</td><td class="fileinforightbottom">' . getDownloadCount($twg_album, $image) . '</td></tr>
';
}

if ($show_image_rating) {
	echo '<tr class="gray"><td class="fileinfoleftbottom">' . $lang_fileinfo_rating . '</td><td class="fileinforightbottom">' . getVotesCount($twg_album, $image) . '</td></tr>';
}

if ($isOther) {
	$image = $isOther;
	if (strrchr ($image, "/")) {
		$image = substr (strrchr ($image, "/"), 1);
	}
	$image = removePrefix($image);
}

?>
<tr><td class="fileinfoleftbottom"><?php echo $lang_fileinfo_name;

?></td><td class="fileinforightbottom"><?php 
echo htmlentities(cut_info_str(utf8_encode($image)), ENT_QUOTES, $charset);
?></td></tr>
<tr class="gray"><td class="fileinfoleftbottom"><?php echo $lang_fileinfo_date;

?></td><td class="fileinforightbottom"><?php
if (!$remote_image) {
  $dt = get_image_time($filename, true , "" , true);
	echo date ("j.n.Y", intval(substr($dt,0,-1)));
} else {
	echo $lang_fileinfo_not_available;
}

?></td></tr>
<tr><td class="fileinfoleftbottom"><?php echo $lang_fileinfo_size;

?></td><td class="fileinforightbottom"><?php
if (!$remote_image) {
	if (file_exists($filename)) {
	  $size = filesize($filename) / 1000;
	} else {
	  $size = 0;
	}
	if ($size > 0) {
		echo sprintf("%01.0f KB", $size);
	} else {
		echo $lang_exif_not_available;
	}
} else {
	echo $lang_fileinfo_not_available;
}

?></td></tr>
<tr class="gray"><td class="fileinfoleftbottom"><?php echo $lang_fileinfo_resolution;

?></td><td class="fileinforightbottom"><?php
set_error_handler("on_error_no_output"); // @does not work here! - needed for e.g. mp3's ...
$oldsize = @getimagesize($filename, $info);	
set_error_handler("on_error");
if ($oldsize) {
	echo $oldsize[0] . " x " . $oldsize[1];
} else {
	echo $lang_exif_not_available;
}

?></td></tr>
<?php

if ($show_tags) {
	$res = getTags($twg_album , $image);
	if (isset($res["image"])) {	
	  $tag_image = str_replace (",","<br />", htmlentities($res["image"], ENT_QUOTES, $charset)) . "&nbsp;";
	} else {
	  $tag_image ="&nbsp;";
	}
	if (isset($res["dir"])) {
	  $tag_dir = str_replace (",","<br />",htmlentities(($res["dir"]), ENT_QUOTES, $charset)) ."&nbsp;";
	} else {
		$tag_dir ="&nbsp;";
	}
	
	print "<tr class='gray'><td class='fileinfoleftbottom'>$lang_tag_enter_image</td><td class='fileinforightbottom'>" . $tag_image . "</td></tr>";
	print "<tr class='gray'><td class='fileinfoleftbottom'>$lang_tag_enter_dir</td><td class='fileinforightbottom'>" . $tag_dir . "</td></tr>";
}
// print the iptc data!
if ($show_iptc_data) {
	if (isset($info["APP13"])) {
		$iptc = iptcparse($info["APP13"]);
		if (is_array($iptc)) {
			foreach($lang_iptc_info as $label => $key) {
				$data = "";
				$choices = explode(",", $key);
				if ((count($choices) == 1) && isset($iptc[$key][0])) {
					$data = $iptc[$key][0];
				} else if (isset($iptc[$choices[0]][0])) {
					$data = $iptc[$choices[0]][0];
				} else if (isset($choices[1]) && isset($iptc[$choices[1]][0])) {
					$data = $iptc[$choices[1]][0];
				}
				$data = trim($data);
        if (isset($charset) && strtolower($charset) == "utf-8") {
				  $data = ($iptc_encoding == 'utf-8' ) ? $data : utf8_encode($data);
				}
				if ($data != "") {
					$data = cut_info_str($data);
					print "<tr class='gray'><td class='fileinfoleftbottom'>$label</td><td class='fileinforightbottom'>" . $data . "</td></tr>";
				}
			}
		}
	}
}
// exif info !
if ($show_exif_info) {
	if (substr($filename, 4, 3) != "://") {
		show_exif_info($filename);
	 }
   else {
		foreach($lang_exif_info as $label => $key) {
			$data = $lang_fileinfo_not_available;
			print "<tr class='gray'><td class='fileinfoleftbottom'>$label</td><td class='fileinforightbottom'>" . trim($data) . "</td></tr>";
		}
	}
}

if ($_SERVER['SERVER_PORT'] == 443) {
				$t_root = "https://" . get_server_name();
			} else {
				$t_root = "http://" . get_server_name();
				if ($_SERVER['SERVER_PORT'] != 80) {
          $t_root .= ":" . $_SERVER['SERVER_PORT'];
        }
			}

     $url = $t_root . $twg_root ."?twg_album=" . $album_enc  . "&amp;twg_show=" . $image_enc . $twg_standalone;


	$thumbimage = create_thumb_image($twg_album, $image_enc);
	$thumb = create_cache_file($thumbimage,$extension_thumb);
  // todo: check small cache!
	if (!file_exists($thumb) || $disable_direct_thumbs_access) {
      $img = $t_root . dirname($twg_root) .  "/" . $install_dir . "image.php?twg_album=" . $album_enc  . "&amp;twg_show=" . $image_enc .  "&amp;twg_type=thumb";
	} else { 	
	    $cachedir = $cachedir_save;   
	    $img = $t_root . dirname($twg_root) .  "/" . $install_dir_save . create_cache_file(cacheencode($thumbimage),$extension_thumb, $twg_seo_active);
	}
set_error_handler("on_error_no_output");
?>

<tr class="gray"><td class="fileinfoleftbottom">BBCode</td><td class="fileinforightbottom"><input style="border:none;" type="text" value="[url=<?php echo $url; ?>][img]<?php echo $img; ?>[/img][/url]" size=22/></td></tr>
<tr class="gray"><td class="fileinfoleftbottom">Link</td><td class="fileinforightbottom"><input style="border:none;" type="text" value="<a href='<?php echo $url; ?>' target='_blank'><img src='<?php echo $img; ?>' border='0' alt='<?php echo str_replace("'","",htmlentities(cut_info_str(getBeschreibung($image, $_SESSION['werte'], $_SESSION['index'])), ENT_QUOTES, $charset)); ?>' /></a>" size=22/></td></tr>

</table>
</center>
</td></tr></table>
<?php 
set_error_handler("on_error");
} else {
  showInvalidAccess();
}
include "i_bottom.inc.php";

?>