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

// we make the encryption key a little bit longer :)
$encrypt_emails_key = $encrypt_emails_key . str_rot13($encrypt_emails_key) . strrev($encrypt_emails_key);
include "../inc/email.inc.php";

$fokus = "";
/*
	EasyLetter 1.2
	This script is part of Onlinetools
	http://www.onlinetools.org/tools/easyletter.php

	The original script does still exist in may parts but was changed heavily to get
	a part of TWG
*/
$vars = explode(",", "pw,send,subject,message,twg_email,action,sender");

foreach($vars as $v) {
    if ((isset($_GET[$v])) && ($_GET[$v] != "")) {
        $$v = replaceInput($_GET[$v]);
    } else {
        $$v = "";
    }
    if ((isset($_POST[$v])) && ($_POST[$v] != "")) {
        $$v = replaceInput($_POST[$v]);
    }
}


// Where is your newsletter located? (For deletion and confirmation (If this will ever be build :)) link)
$newsletterlocation = "http://localhost/easyletter.php";
// Name of the datafile
$filelocation = $counterdir . "/subscribers.xml";
// pattern for filtering out own emails // we don't do this
$pattern = "bar.bar";
$localmessage = "";

if (!file_exists($filelocation)) {
    $newfile = fopen($filelocation, "w+");
    fclose($newfile);
}
$newfile = fopen($filelocation, "r");
if (filesize($filelocation) != 0) {
    $content = fread($newfile, filesize($filelocation));
} else {
    $content = "";
}
fclose($newfile);
$content = stripslashes($content);
$out = "";
$lines = explode("%", $content);
$found = 0;
$offsetcode = 1;
$offsetencode = 0;;
foreach($lines as $l) {
    $l = decryptEmail($l, $offsetencode++);
    if ($l != $twg_email) {
        if ($l != "") {
            $out .= "%" . cryptEmail($l, $offsetcode++);  
        }       
    } else {
        $found = 1;
    }   
}
include "i_header.inc.php";
include "i_body_head.inc.php"; // body and closebutton

if ($show_email_notification) {
if ($action == "sign") {
    if ($found == 1 or $twg_email == "" or !checkmail($twg_email) or preg_match("/" . $pattern . "/", $twg_email)) {
        if ($twg_email == "") {
            $localmessage = $lang_email_sorryblankmailmessage;
        } else if ($found == 1) {
            $localmessage = sprintf($lang_email_sorrysignmessage, $twg_email);
        } else if (!checkmail($twg_email)) {
            $localmessage = sprintf($lang_email_sorryoddmailmessage, $twg_email);
        } else if (preg_match("/" . $pattern . "/", $twg_email)) {
            $localmessage = $lang_email_sorryownmailmessage;
        }
    } else {
        $newfile = fopen($filelocation, "a+");
        $emailenc = cryptEmail($twg_email, $offsetencode); // we cypt the email
        $add = "%" . $emailenc;
        fwrite($newfile, $add);
        fclose($newfile);
        if ($enable_email_sending) {              
            if (!@tfu_mail($twg_email, $lang_email_subscribemail_subject, $lang_email_subscribemail, $youremail)) {
                $localmessage = $lang_email_error_send_mail; 
            } else {
                $localmessage = $lang_email_subscribemessage;
            }
        } else {
            $localmessage = $lang_email_subscribemail;
        }
    }
}

if ($action == "delete") {
    if ($twg_email == "") {
        $localmessage = $lang_email_sorryblankmailmessage;
    } else if ($found == 1) {
        $newfile = fopen($filelocation, "w+");
        fwrite($newfile, $out);
        fclose($newfile);
        $newfile = fopen($filelocation, "r");
        $localmessage = sprintf($lang_email_unsubscribemessage, $twg_email);
    } else if ($found != 1) {
        $localmessage = sprintf($lang_email_failedunsubscriptionmessage, $twg_email);
    }
}
// print $welcomemessage;
if (!$action) {
    $localmessage = $lang_email_welcomemessage;
}

echo '
	<form action="' . getScriptName() . '" method="get">
	<input type="hidden" name="twg_lang" value="' . $default_language . '" />
	<table summary="" cellpadding="0" cellspacing="0" align="center">
	<tr><td class="messagecell">'
 . $localmessage . '
	</td></tr><tr><td class="centertable">
  <input type="text" name="twg_email" class="inputsmall" value="" style="width:240px" />
	</td></tr><tr><td class="centertable">
	<input type="radio" name="action" value="sign" checked="checked" />' . $lang_email_add . '
	<input type="radio" name="action" value="delete" />' . $lang_email_remove . '
	</td></tr><tr><td class="centertable">
	<input type="submit" value=" ' . $lang_email_send . '! " class="btn btn-small" />
	</td></tr></table>
	</form>
	';
print '</td></tr></table>';
} else {
  showInvalidAccess();
} 


function checkmail($string)
{
    $test1 = preg_match("/^[^\s()<>@,;:\"\/\[\]?=]+@\w[\w-]*(\.\w[\w-]*)*\.[a-z]{2,}$/i", $string);
    if ($test1) {
        return testEmailDomain($string);
    } else {
        return false;
    }
}


include "i_bottom.inc.php";
?>