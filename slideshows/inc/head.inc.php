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

defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');

$optimize_array = array();

if (!$php_include) {
    if ($allow_iframe_include == 'false') {
         header("X-Frame-Options: DENY");
    } else if ($allow_iframe_include == 'same') {
         header("X-Frame-Options: SAMEORIGIN");
    }
   
    
    header('P3P: CP="ADMa PSAa PSDa IVAa CONi OUR IND ONL COM NAV INT DEM CNT STA PRE DSP OTI COR"');
    
    $ie_height_iframe_fix = $msie && $iframe_include && ($twg_standalone == "");
    
    if ($ie_height_iframe_fix) {
        // I actually tried all doctypes - IE sucks with all in an iframe!  // "http://www.w3.org/TR/html4/strict.dtd"
        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
        // $use_round_corners = false;
    } else {
        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
    } 
    echo '
<html>
';
}

?>
<!--
Powered by TinyWebGallery 2.2
Please go to http://www.tinywebgallery.com for the latest version.

Please don't remove this header if you use TWG or a modified version of it!

Copyright (c) 2004-2014 TinyWebGallery written by Michael Dempfle

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
-->
<?php

if (!$php_include) {
    echo '
<head>
';
}

if (file_exists($install_dir . 'head_start_addon.php')) {
    include ($install_dir . 'head_start_addon.php');
}

?>
<?php
if (!$php_include) {

    if ($top10_type) {
        $browser_title_prefix .= " - " . $top10_type;
    }

    if ($image && !$input_invalid) {
        // this is the basic one - it is later improved when the title is read - but for robots a goot title has to exist
        $image_title = removeTitleChars(removeExtension($image)); 
        if ($filesystem_encoding == '') {
           $image_title =  utf8_encode($image_title);
        } 
        echo '<title>' . $browser_title_prefix . ' - ' . $image_title . '</title>';
    } else if ($twg_album && !$input_invalid) {
        $image_title = removeTitleChars($twg_album);
        if ($filesystem_encoding == '') {
           $image_title =  utf8_encode($image_title);
        } 
        echo '<title>' . $browser_title_prefix . ' - ' . $image_title . '</title>';
    } else {
        echo '<title>' . $browser_title_prefix . '</title>';
    }   
    echo '
<meta name="viewport" content="width=device-width,initial-scale=1.0" >
<meta name="author" content="Michael Dempfle" >
<meta name="DC.Identifier" content="http://www.tinywebgallery.com" >
<!-- Use IE7 mode -->
';
    if ($use_ie_compability_mode) {
        echo '
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<meta http-equiv="X-UA-Compatible" content="IE=8">';
    }
   
    $image_meta = htmlspecialchars(utf8_decode($image), ENT_QUOTES);
    $album_meta = htmlspecialchars(utf8_decode($twg_album), ENT_QUOTES);

    if (!$input_invalid) {
        if ($metatags == "" && !$twg_album) { // if no metatags are provided and we have no image we use default
            $meta = trim($image_meta . ',' . $album_meta, " ,");
            echo'<meta name="keywords" content="' . $meta . ',TinyWebGallery, twg, photo album, gallery, image gallery, galerie" >';
        } else {
            $meta = trim($image_meta . ',' . $album_meta . ',' . $metatags, " ,");
            echo '<meta name="keywords" content="' . $meta . '" >';
        }
    }
    
    if ($metadescription == '' && !$image && !$twg_album) { // if no metatags are provided we use default
        if ($default_language != 'de') {
            echo '<meta name="description" lang="en" content="TinyWebGallery is a free php/xml based photo album / gallery that is very easy to install, extremely user friendly and has many unique features. | '.$default_language.'">';
        } else {
            echo '<meta name="description" lang="de" content="TinyWebGallery ist eine freie php/xml Galerie, die einfach zu installieren, extrem benutzerfreundlich ist und viele einzigartige Features hat.">';
        }
    } else if ($metadescription == '' && $image && $twg_album) {
        if ($default_language != 'de') {
            echo '<meta name="description" lang="en" content="This image is in the folder ' . $album_meta . ' and has the name ' . $image_meta . '" >';
        } else {
            echo '<meta name="description" lang="de" content="Dieses Bild ist im Ordner ' . $album_meta . ' und hat den Namen ' . $image_meta . '" >';
        }
    } else if ($metadescription == '' && !$image) {
        if ($default_language != 'de') {
            echo '<meta name="description" lang="en" content="This is the thumbnail page of  the folder ' . $album_meta . '." >';
        } else {
            echo '<meta name="description" lang="de" content="Dies ist die Übersichtsseite des Ordners ' . $album_meta . '." >';
        }
    } else { // There is a meta description set
        $meta = trim($image_meta . ',' . $album_meta, " ,");
        echo '
  <meta name="description" content="' . $metadescription . " - " . $meta . '" >';
    }

  if (!isset($_GET['twg_lang'])) {    
    echo '<meta name="robots" content="index,follow,all">';
  } else {
    echo '<meta name="robots" content="noindex,nofollow">';
  }

}
if (isset($charset)) {
    echo '<META http-equiv="Content-Type" content="text/html; charset=' . $charset . '">';
}

if ($support_piclens && !$image) {
    $plfile = ($privatelogin == "FALSE") ? $cachedir . "/all_pl.rss" : $cachedir . "/all_pl_" . md5($privatelogin) . ".rss";
    if (file_exists($plfile)) {
        echo '
    <link rel="alternate" href="' . $install_dir_view . $plfile . '" type="application/rss+xml" title="" id="gallery" />';
    }
}

?>

<?php
printCss('<style type="text/css">#div1{height:' . $menu_pic_size_y . 'px;width:' . $menu_pic_size_x . 'px;text-align:center;}</style>', true);
printCss('css/style-min.css');
printCss('css/style_mobile-min.css');
printCss('language/language_flags-min.css');
if ($msie) {
    printCss('css/style_ie-min.css');
}
if ($wii) {
    printCss('css/style_wii.css');
}

if (file_exists($install_dir . 'buttons/iconsets/' . $icon_set . '/style.css')) {
    printCss('buttons/iconsets/' . $icon_set . '/style.css');
}

?>
<link rel="shortcut icon" href="<?php echo $install_dir_view ?>favicon.ico" type="image/ico">
<link rel="icon" href="<?php echo $install_dir_view ?>favicon.ico">
<?php
if ($activate_lightbox_topx || $activate_lightbox_thumb || ($activate_lightbox_image && $enable_download)) {

    if ($use_lytebox) {
        printCss('lightbox/lytebox-min.css');
    } else {
        printCss('lightbox/css/lightbox-min.css');
        if ($msie) {
            printCss('lightbox/css/lightbox_ie-min.css');
        }
    }
}

// this stylesheet adds the border to the image gallery
if ($myborder == 'TRUE' && !$default_is_fullscreen) {
   printCss('css/framestyle-min.css');
}
// this stylesheet if for language dependant stylesheet for different font sizes!
/*
$cssname = $install_dir . "language/language_" . $default_language . "_style.css";
if (file_exists($cssname)) {
  echo '<link rel="stylesheet" type="text/css" href="' . $cssname . '" >';
}
*/

if (file_exists($install_dir . 'skins/' . $skin . '.css')) {
    printCss('skins/' . $skin . '.css');
}

// additional stylesheet if no border is displayed!
if ($show_border != 'TRUE' && file_exists($install_dir . "skins/" . $skin . "_noborder.css")) {
    printCss('skins/' . $skin . '_noborder.css');
}

if ($show_border != 'TRUE') {
 $use_round_corners = false;
}

// if ($use_round_corners && file_exists($install_dir . "skins/" . $skin . "_round.css")) {
//    printCss('skins/' . $skin . '_round.css');
// }

if (file_exists($install_dir . 'my_style.css')) {
    printCss('my_style.css');
}
if ($msie && file_exists($install_dir . "my_style_ie.css")) {
    printCss('my_style_ie.css');
}

if ($d && $enable_album_tree) {
    printCss('dtree/dtree-min.css');
}

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        if (!$d) { $responsive_main_page = $responsive_thumb_page = $responsive_detail_page = false; }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
if (!$php_include) {
    if ($ie_height_iframe_fix) {
        printCss('<style type="text/css">td.twg_info {height: 89%;}</style>', true);
    }
}

if (!$default_is_fullscreen) {
    $custstylesheet = $install_dir . $basedir_save . "/" . $twg_album . "/style.css";
    if (file_exists($custstylesheet)) { // individual css
        printCss($basedir_save . '/' . twg_urlencode($twg_album) . '/style.css', false, $basedir_save . '/' . $twg_album . '/style.css');
    }
} else {
    if (file_exists($install_dir . "fullscreen.css")) {
        printCss('fullscreen.css');
    }
}

if (!$show_counter || !$enable_counter_details) {
    printCss('<style type="text/css">td.bottomtablesideleft { cursor: auto; } </style>', true);
}


$isImageview = $image != false && ($default_big_navigation != "HTML") && ($twg_smallnav == 'FALSE') && !$twg_slideshow;

$roundcorner_css = '<style type="text/css">';
    if ($use_round_corners) {
        //echo '<script type="text/javascript">
        //var myBorder = RUZEE.ShadedBorder.create({ corner:' . $use_round_corners_size . ', border:' . $use_round_corners_border . ' });
        //myBorder.render("twg_content_div");
        //</script>';
       $roundcorner_css .= '#twg_content_div {
         -moz-border-radius: '.$use_round_corners_size.'px;
         border-radius: '.$use_round_corners_size.'px;
         border-width: '.$use_round_corners_border.'px;
       }'; 
       $roundcorner_css .= '#twg_info {
        border: none;
        padding-right:'.(2*$use_round_corners_border).'px;
        padding-bottom:'.(2*$use_round_corners_border).'px;
       }';  
    } else {
       $roundcorner_css .= '#twg_content_div{border: none;}'; 
    }
    $roundcorner_css .= '</style>';

   printCss($roundcorner_css, true);

// now all the css are combined and printed!
if ($optimize_css) {
    printOptimizedCss($optimize_array);
}

if ($video_player == 'HTML5') {
   // echo '<link rel="stylesheet" type="text/css" href="' . $install_dir_view . './css/video-js.min.css" >';
   echo '<link rel="stylesheet" type="text/css" href="' . $install_dir_view . './css/projekktor-theme/projekktor.style.css" >';
}


?>   
<script type="text/javaScript" src="<?php echo $install_dir_view ?>./js/jquery-1.11.1.min.js"></script>
<script type="text/javaScript">
    var $ = jQuery.noConflict();
</script>
<script type="text/javaScript" src="<?php echo $install_dir_view ?>./js/twg_image-min.js"></script>
<?php
if ($isImageview) {
    echo '
<script type="text/javascript" src="' . $install_dir_view . 'js/twg_motiongallery-min.js">
/***********************************************
* CMotion Image Gallery- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
***********************************************/
</script>
';
}

if ($twg_mobile || $isTablet) {
echo '<script type="text/javaScript" src="' . $install_dir_view . './js/jquery.touchSwipe.min.js"></script>';
} 

// Include video for html5
if ($video_player == 'HTML5') { 
/*
echo '
<script src="'. $install_dir_view . './js/video.js"></script>
<script>
  videojs.options.flash.swf = "'. $install_dir_view . './html/video-js.swf"
</script>';
*/
echo '<script src="'. $install_dir_view . './js/projekktor-1.3.09.min.js"></script>';
}

if ($isIphone || $isIpad) {
?>
<script type="text/javascript">
(function(doc) {

	var addEvent = 'addEventListener',
	    type = 'gesturestart',
	    qsa = 'querySelectorAll',
	    scales = [1, 1],
	    meta = qsa in doc ? doc[qsa]('meta[name=viewport]') : [];

	function fix() {
		meta.content = 'width=device-width,minimum-scale=' + scales[0] + ',maximum-scale=' + scales[1];
		doc.removeEventListener(type, fix, true);
	}

	if ((meta = meta[meta.length - 1]) && addEvent in doc) {
		fix();
		scales = [.25, 1.6];
		doc[addEvent](type, fix, true);
	}

}(document));
</script>
<?php
}

if (checkFullscreen()) {
    echo "<script type='text/javascript'>isFullscreen();</script>";
}

if ($test_connection && $test_client_connection) {
    if ($test_connection_background) {
        include dirname(__FILE__) . "/../js/twg_speed.js.php";
    }
}

// height is defined earlier because in twg.js this height is needed	
if ($show_comments_in_layer) {
    $lang_height_comment += $height_of_comment_layer;
}


// we add a canonical URL
if (!empty($image) && !empty($twg_album)) {
        $can_image = $image_enc;
        if ($image_enc == 'x') {
           $can_image = get_first($twg_album);
        }
        $fullurl = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $can_image;
        $fullurl = tfu_seo_rewrite_url($fullurl);
        echo '<link rel="canonical" href="' . $fullurl . '">';
} else if (empty($image) && !empty($twg_album)) {
        $fullurl = getScriptName() . '?twg_album=' . $album_enc;
        $fullurl = tfu_seo_rewrite_url($fullurl);
        echo '<link rel="canonical" href="' . $fullurl . '">';
} else if (!isset($_GET['twg_lang'])) {
        $fullurl = tfu_seo_rewrite_url(getScriptName());
        echo '<link rel="canonical" href="' . $fullurl . '">';
}

if (file_exists($install_dir . 'head_addon.php')) {
    include ($install_dir . 'head_addon.php');
}

echo '<link rel="prefetch" href="http://www.tinywebgallery.com/index2.php">';


if (!$php_include) {
    echo '
</head>
';
} else {
    $show_background_images = false;
}
// we flush the header that css and js can be loaded already.
flush();

?>