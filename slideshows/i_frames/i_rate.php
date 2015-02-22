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
include "i_basic.inc.php";

$rating = '';



if (isset($_GET['twg_rating'])) {
    $rating = $_GET['twg_rating'];
    $rating = parse_maxlength(replaceInput($rating),5);
} else {
    $rating = false;
}

if (isset($_GET['twg_vote'])) {
    $vote = $_GET['twg_vote'];
    $vote = parse_maxlength(replaceInput($vote),5);
} else {
    $vote = 3;
}

if (isset($_GET['twg_rating_page2'])) {
    $page2 = true;
} else {
    $page2 = false;
}

if (isset($_GET['c'])) {
    $c = $_GET['c'];
    if (!isset($_SESSION['twg_key'])) {
        $c = false;
    }
} else {
    $c = false;
}
$name = "";
if ($enable_rating_only_registered) {
    $name = $_SESSION["s_user"];
}

include "../inc/readxml.inc.php";
$fokus = "";
include "i_header.inc.php";
include "i_body_head.inc.php"; // body and closebutton

if ($show_image_rating && (!$enable_rating_only_registered || $login_only)) {
echo '<link rel="stylesheet" href="../buttons/iconsets/'.$icon_set.'/style.css" type="text/css" media="screen"> ';

if (!$show_rating_security_image) { // we skip the security question
    $page2 = false;
    $c = "1";
    $_SESSION['twg_key'] = 1;
}

// only vote once per session for one image;
$ratingimage = $twg_album . $image;
$alreadyVoted = false;
if (isset($_SESSION['votedArray'])) {
  // we check the session
  $alreadyVoted = in_array( $ratingimage, $_SESSION['votedArray']);
} 
if (!$alreadyVoted) { // we check the harddisk
  $alreadyVoted = checkRating($ratingimage, $name);
}

if ($alreadyVoted) {
   echo "<br />";
   echo $lang_rating_message1 . "<br />&nbsp;<br />" . $lang_rating_message2 . "<br />&nbsp;<br />&nbsp;<br />" ;
   echo '</td></tr></table></form></body></html>';
    return;
} else if ($rating == false) {
    echo $lang_rating_text;
    echo '<input name="twg_rating_page2" type="hidden" value="true" />';
} else if ($page2) {
    echo $lang_rating_security . '
  <br />
  <img alt="" src="../buttons/1x1.gif" width="1" height="7" /><br />
	<center><table summary="" cellpadding=5><tr><td>
	<a href="javascript:location.reload();"><img border="0" src="i_tacs.inc.php" alt="CAPTCHA IMAGE" /></a></td><td>
	<input type="text" id="c" name="c" size="10" /><br /><img alt="" src="../buttons/1x1.gif" width="1" height="3" /><br />
	<input name="twg_rating" type="hidden" value="' . $rating . '" />
	<input class="btn btn-small" type="submit" name="check" value="' . $lang_rating_send . '" />
	</td></tr></table></center><span class=help>' . $lang_rating_help . '</span>';
    echo '</td></tr></table></form></body></html>';
    return;
} else {
    if ($c && $_SESSION['twg_key'] == strtolower($c)) {
        if (!increaseVotesCount($twg_album, $image, $rating) || $alreadyVoted) {
            echo "<br />";
            echo $lang_rating_message1 . "<br />&nbsp;<br />" . $lang_rating_message2 . "<br />&nbsp;<br />&nbsp;<br />" ;
        } else {
            $_SESSION['votedArray'][] = $ratingimage; // we save that we voted already
            setRating($ratingimage, $name);
            // send an email if set to true !
            if ($send_notification_if_rating) {
                if ($enable_email_sending) {
                   $link = "http://" . get_server_name() . ":" . $_SERVER['SERVER_PORT'] . urldecode($twg_root) . "?twg_album=" . $album_enc . "&twg_show=" . $image_enc;
                   // UTF-8 e-mail
                   tfu_mail($admin_email, $notification_rating_subject, sprintf($notification_rating_text, $link), $youremail);      
                }
            }

            $_SESSION["actalbum"] = "LOAD NEW";
            echo "<br />";
            // "<br />" . $lang_rating_new . getVotesCount($twg_album, $image) .
            echo $lang_rating_message3 . "<br />&nbsp;<br />" . $lang_rating_message2 . "<br />&nbsp;<br />&nbsp;<br />";
        }
    } else {
        echo $lang_rating_message4 . "<br />";
        echo '
									  <img alt="" src="../buttons/1x1.gif" width="1" height="7" /><br />
										<center><table cellpadding=5 summary=""><tr><td>
										<a href="javascript:location.reload();"><img border="0" src="i_tacs.inc.php" alt="CAPTCHA IMAGE" /></a></td><td>
										<input type="text" name="c" size="10" /><br /><img alt="" src="../buttons/1x1.gif" width="1" height="3" /><br />
										<input name="twg_rating" type="hidden" value="' . $rating . '">
										<input class="btn btn-small" type="submit" name="check" value="' . $lang_rating_send . '" />
	                  </form></td></tr></table></center><span class=help>' . $lang_rating_help . '</span>';
    }

    if (isset($_GET["PHPSESSID"])) {
        $closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?PHPSESSID=" . $_GET["PHPSESSID"] . "&twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
    } else {
        $closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
    }
    echo '</td></tr></table></form></body></html>';
    return;
}
echo'
  <center><img alt="" src="../buttons/1x1.gif" width="1" height="2" /><table summary="" ><tr><td  class="vote">';

?>
<table summary='' width="250px" cellpadding='0' cellspacing='0'>
<tr align="center"><td colspan=5  class="vote"><?php echo $lang_rating . ": " . getVotesCount($twg_album, $image);

?><br /><img alt='' src="../buttons/1x1.gif" width="5" height="10" /></td>

<tr class="vote" align="center"><td class="vote">
<div class="twg-inline-rating">
  <ul class="twg-rating">
    <li id="ratingcur" alt="1" title="1" class="current-rating" style="width:20%;"></li>
  </ul>&nbsp;<input name="twg_rating" type="radio" <?php if ($vote==1) echo ' checked="checked" '; ?> value="1" /><br />
    <ul class="twg-rating">
    <li id="ratingcur" alt="1" title="1" class="current-rating" style="width:40%;"></li>
  </ul>&nbsp;<input name="twg_rating" type="radio" <?php if ($vote==2) echo ' checked="checked" '; ?> value="2" /><br />
    <ul class="twg-rating">
    <li id="ratingcur" alt="1" title="1" class="current-rating" style="width:60%;"></li>
  </ul>&nbsp;<input name="twg_rating" type="radio" <?php if ($vote==3) echo ' checked="checked" '; ?> value="3" /><br />
  <ul class="twg-rating">
    <li id="ratingcur" alt="1" title="1" class="current-rating" style="width:80%;"></li>
  </ul>&nbsp;<input name="twg_rating" type="radio" <?php if ($vote==4) echo ' checked="checked" '; ?> value="4" /><br />
   <ul class="twg-rating">
    <li id="ratingcur" alt="1" title="1" class="current-rating" style="width:100%;"></li>
  </ul>&nbsp;<input name="twg_rating" type="radio" <?php if ($vote==5) echo ' checked="checked" '; ?> value="5" />
</div></td>

<td >&nbsp;<input class="btn btn-small" type="submit" name="twg_submit" value="<?php echo $lang_rating_button ?>"/><td>
</tr>
</table>
  </td></tr></table>
  </center>
</td></tr></table>
</form>
<?php 
} else {
  showInvalidAccess();
}
include "i_bottom.inc.php";
?>