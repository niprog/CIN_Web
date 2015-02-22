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
include "i_basic.inc.php";

global $kwerte ;
global $kindex ;

$titel = parse_html_parameter('twg_titel');
$titel = replace_conv_br($titel);
$name = parse_html_parameter('twg_name');
$name = replace_conv_br($name);
$submit = parse_parameter('twg_submit');

$titel = stripslashes(nl2br($titel));
$name = stripslashes(nl2br($name));

include "../inc/readxml.inc.php";

if ($enable_comments_only_registered) {
    $name = $_SESSION["s_user"];
}

// delete kommentare
if (isset($_GET['twg_delcomment'])) {
    if ($login <> "TRUE") {
        echo $lang_email_admin_notloggedin;
        return;
    }
    $twg_delcomment = $_GET['twg_delcomment'];
    $twg_delcomment = stripslashes($twg_delcomment);
    deleteKommentar($twg_delcomment, $twg_album , $image , $kwerte , $kindex);
    delete_comment_cache("../");
}

$fokus = "twg_name";
include "i_header.inc.php";
include "i_body_head.inc.php"; // body and closebutton

if ( $show_comments && (!$enable_comments_only_registered || $login_only) ) {

loadXMLFiles($twg_album);

if (($name == false) && ($titel == false) && $submit) {
    echo $lang_kommenar_php_both_fields;
} else if ($name == false && $submit) {
    echo $lang_kommenar_php_enter_name;
} else if ($titel == false) {
    echo $lang_kommenar_php_enter_comment;
} else {
    if (!isset($_SESSION['LAST_COMMENT']) || (isset($_SESSION['LAST_COMMENT']) && $_SESSION['LAST_COMMENT'] != ($name . $titel))) {
        $_SESSION["actalbum"] = "LOAD NEW";
        loadXMLFiles($twg_album);
        saveKommentar($titel, $name, $twg_album, $image, $kwerte, $kindex, $image);
        $_SESSION['LAST_COMMENT'] = $name . $titel;  
        delete_comment_cache("../");
        // send an email if set to true !
        if ($send_notification_if_comment) {
            $submailheaders = "From: $youremail\n";
            $submailheaders .= "Reply-To: $youremail\n";
            if ($enable_email_sending) {
               $link = "http://" . get_server_name() . ":"  . $_SERVER['SERVER_PORT'] . urldecode($twg_root) ."?twg_album=" . $album_enc  . "&twg_show=" . $image_enc;
               // UTF-8 e-mail
               tfu_mail($admin_email, $notification_comment_subject, sprintf($notification_comment_text, $link), $youremail);      
            }
        }
    }
    if (isset($_GET["PHPSESSID"])) {
        $closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) ."?PHPSESSID=" . $_GET["PHPSESSID"] . "&twg_album=" . $album_enc  . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
    } else {
        $closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) ."?twg_album=" . $album_enc  . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
    }
    echo $closescript;
}

$name_enc = htmlentities(rm_br($name), ENT_QUOTES, $charset);
$titel_enc = htmlentities(rm_br($titel), ENT_QUOTES, $charset);

?>
<br /><img alt='' src="../buttons/1x1.gif" width="6" height="6" /><br />
<?php echo $lang_kommenar_php_name ?><br /><input id="twg_name" <?php if ($enable_comments_only_registered) { echo "disabled=disabled"; } ?> name="twg_name" type="text" value="<?php echo $name_enc ?>"  style="margin-left:22px;width:240px;" />
<br /><img alt='' src="../buttons/1x1.gif" width="6" height="6" /><br /><?php echo $lang_kommenar_php_comment ?><center>
    <table  summary='' border=0 cellpadding='0' cellspacing='0'>
    <tr><td class='tdcomment'><?php
                if ($enable_smily_support) {
                    echo'<img alt="" onmouseover="javascript:show_smilie_div()" src="../buttons/smilie.gif" width="15" height="15" />';
                } else {
                    echo'<img alt="" src="../buttons/1x1.gif" width="15" height="15" />';
                }
                echo '<img alt="" src="../buttons/1x1.gif" width="6" height="6" /></td><td class="tdcomment">';
                ?><textarea id="twg_titel" name="twg_titel" style="width:240px;" rows="5"><?php echo $titel_enc ?></textarea></td></tr></table></center>
<img alt='' src="../buttons/1x1.gif" width="6" height="6" /><br />
<input class="btn btn-small" type="submit" name="twg_submit" value="<?php echo $lang_kommenar_php_speichern ?>" />
</td></tr>
<tr><td class="html_tags"><?php echo $lang_allowed_html_tags ?><br />
        <?php
        foreach ($allowed_html_tags as $value) {
            echo htmlentities($value, ENT_QUOTES, $charset) . "";
        }
        if ($show_comments_ip) {
            echo '<br />'.$lang_register_ip.' ' .$_SERVER['REMOTE_ADDR'];
        }
        ?>
</td></tr>
</table>
</form>
<?php
if ($enable_smily_support) {
    echo '
<div id="twg_smilie" class="twg_smiliedivcomment"><table summary="" cellpadding="0" cellspacing="0"><tr><td class="twg_smilie">'. create_smilie_div() . '</td></tr></table></div>

<div id="twg_smilie_bord" class="twg_smiliedivbordercomment" onmouseover="javascript:hide_smilie_div()" ></div>

';
}

if ($show_comments_in_layer) {
    $comment_data_raw =  getKommentar($image, $twg_album, $kwerte, $kindex, true);
    $comment_data = substr($comment_data_raw,10);
    $comment_count = sprintf("%d", substr($comment_data_raw,0,10));

    echo "<div class='com_div' style='height:".$height_of_comment_layer."px;'>";
    echo "<br /><div class='twg_underlineb'>" . $lang_comments . " (" . $comment_count .  ")" .  "</div><br />";
    echo "<center><table summary=''>";
    echo "<tr><td id='kommentartd' class='twg_kommentar'><img alt='' src='../buttons/1x1.gif' width='240' height='1' /><br />";
    echo $comment_data;
    echo "</td></tr></table></center>";
    echo "</div>";
}
?>
<?php 
} else {
  showInvalidAccess();
}
include "i_bottom.inc.php"; 
?>