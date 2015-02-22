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

if ($twg_showprivatelogin || ($multi_root_mode && !$twg_album) || $root_mode_no_login) {
    $show_background_images = false;
}
// if don't use dynamic backgrounds  
if (!$use_dynamic_background) {
    $use_resized_background = false;
}

$bodyStyle = $use_ie_compability_mode ? 'twg' :  'twg-no-comp';

if (!$php_include) {
    if ($image != false && $default_is_fullscreen) {
        echo '<body onload="draginit();" class="twg_body_fullscreen">';
    } else {
        if ($show_background_images) {
            if ($twg_album) {
                $backgroundimage = $basedir . "/" . $twg_album . "/back.png";
            } else {
                $backgroundimage = $basedir . "/back.png";
            }
            if (file_exists($backgroundimage)) { // individual background image
                $background_tmp = $install_dir_view . 'image.php?twg_album=' . $album_enc . '&amp;twg_type=png&amp;twg_show=back.png';
                $background = get_dynamic_background($backgroundimage, $background_tmp);
                echo '<body class="'.$bodyStyle.'" style="background-image: url(' . $background . ') !important; background-attachment:fixed !important; background-color: transparent !important; ">';
                echo '<style>#twg_content_div { background-image: url(' . $background . ') !important; background-attachment:fixed !important; }</style>'; 
            } else {
                $backgroundimage = $cachedir . "/" . twg_urlencode(str_replace("/", "_", $twg_album)) . "_back.png"; // we link directly to the background - because of special characters like (+?$?!%&-;) this type of encoding is used here
                if (file_exists($backgroundimage)) { // individual background image
                    $background_tmp = $cachedir . "/" . twg_urlencode(twg_urlencode($twg_album)) . "_back.png";
                    $background = get_dynamic_background($backgroundimage, $background_tmp);
                    echo '<body class="'.$bodyStyle.'" style="background-image: url(' . $background . ') !important; background-attachment:fixed !important;background-color: transparent !important;">';
                    echo '<style>#twg_content_div { background-image: url(' . $background . ') !important; background-attachment:fixed !important; }</style>'; 
                } else if (file_exists($background_default_image)) { // individual background image
                    $background = get_dynamic_background($background_default_image, $background_default_image);
                    echo '<body class="'.$bodyStyle.'" style="background-image: url(' . $background . ') !important; background-attachment:fixed !important;background-color: transparent !important;">';
                    echo '<style>#twg_content_div { background-image: url(' . $background . ') !important; background-attachment:fixed !important; }</style>'; 
                } else {
                    echo '<body class="'.$bodyStyle.'">';
                    $use_dynamic_background = $use_resized_background = false;
                }
            }
        } else {
            echo '<body class="'.$bodyStyle.'" style="background-image:none !important;">';
            $use_dynamic_background = $use_resized_background = false;
        }
    }
}
if ($use_dynamic_background && !($use_resized_background && isset($_SESSION[$GLOBALS["standalone"] . "browserx_res"]))) { // if dynamic I add the left right buttons by default because otherwise the people might not recognize that more than x images are there
    $use_nonscrolling_dhtml = true;
    $show_big_left_right_buttons = true;
}

if ($use_nonscrolling_dhtml) {
    echo '
<script type="text/javascript">
if (window.disableScroll) {
  disableScroll();
}
</script>
';
}

if ((!$cache_dirs || ($cache_dirs && !isset($_SESSION['wait_icon']))) && file_exists($install_dir . 'buttons/loading.gif') && !$php_include) {
    $_SESSION['wait_icon'] = "TRUE";
    ?>
<script type="text/javascript">
    document.write("<div id='loader_id' style='width:100%;height:100%;text-align:center;position:absolute;z-index:100;'>");
    document.write("<table width='200' style='width:100%;height:100%;text-align:center;' cellspacing='0' cellpadding='0'><tr><td>");
    document.write("<img src='<?php echo $install_dir_view ?>buttons/loading.gif' width='32' height='32' \>");
    document.write("<\/td><\/tr><\/table>");
    document.write("<\/div>");
</script>
<?php
}
if (!$php_include) {
    echo '<center id="center-body">';
}
?>