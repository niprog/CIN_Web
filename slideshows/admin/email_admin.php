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

$encrypt_emails_key = $encrypt_emails_key . str_rot13($encrypt_emails_key) . strrev($encrypt_emails_key);
$twg_album=false;
include_once "../inc/startsession.inc.php";
include_once "../inc/mysession.inc.php";
include "../inc/email.inc.php";

$d=a(); // overwritten in mysession!
// TODO check the login !!!!
/*
	EasyLetter 1.2
	This script is part of Onlinetools
	http://www.onlinetools.org/tools/easyletter.php

	The original script does still exist in many parts but was changed heavily to get
	a part of TWG
*/
$vars = explode(",", "pw,send,subject,message,email,myaction,sender");
foreach($vars as $v) {
    if ((isset($_GET[$v])) && ($_GET[$v] != "")) {
        $$v = $_GET[$v];
    } else {
        $$v = "";
    }
    if ((isset($_POST[$v])) && ($_POST[$v] != "")) {
        $$v = $_POST[$v];
    }
}

$lang_email_admin_welcomemessage_send = $GLOBALS["email_messages"] ["youcaninfm"];
$lang_email_admin_sorryoddsendermailmessage = $GLOBALS["email_messages"] ["sorry"];
$lang_email_admin_sendermail = $GLOBALS["email_messages"] ["senderadres"];
$lang_email_admin_subject = $GLOBALS["email_messages"] ["subject"];
$lang_email_admin_message = $GLOBALS["email_messages"] ["massage"];
$lang_email_admin_sendbutton = $GLOBALS["email_messages"] ["send"];
$lang_email_admin_sent = $GLOBALS["email_messages"] ["massagesend"];
$lang_email_admin_from = $GLOBALS["email_messages"] ["from"];
$lang_email_admin_notloggedin = $GLOBALS["email_messages"] ["notloggedin"];


if (!$sender) {
  $sender = $youremail;
}

if (!$subject) {
  $subject = $default_subject;
}

if ($twg_root == $install_dir . "../index.php") {
   $twg_root = substr(getScriptName(),0,strlen(getScriptName()) - 15) . "index.php";
}

if (!$message) {
  $message = sprintf($default_text, "http://" . get_server_name() . ":"  . $_SERVER['SERVER_PORT'] . $twg_root);
  // $message = $default_text;
}

// Name of the datafile
$filelocation = "../" . $counterdir . "/subscribers.xml";
// Title of the newsletter, will be displayed in the FROM field of the mailclient

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

show_twg_header();
?>
<div id="ctr" align="center">
<div class="install round_borders">
<div id="step"><?php echo $GLOBALS["email_messages"] ["sendnotifi"]; ?></div>
<div class="clr"></div>
<center>
<table summary='' style="width: 100%;" cellpadding='0' cellspacing='0'>
<tr><td class=tablesend>
<?php

if ($send == $GLOBALS["email_messages"] ["yes"]) {
  if ($sender == "" or !checkmail($sender)) {
      $send = $GLOBALS["email_messages"] ["no"];
      printf ($lang_email_admin_sorryoddsendermailmessage, $sender);
  }
}

if (!$send) {
    $nr_email = count(explode("%", $content));
    printf ($lang_email_admin_welcomemessage_send,($nr_email-1)) ;

     if (!$enable_email_sending || !$show_email_notification ) {
    echo "<br>&nbsp;<br>" . $GLOBALS["email_messages"] ["pleasenote"] . "<br>";
    }
    if (!$enable_email_sending) {
     echo "<p>" . $GLOBALS["email_messages"] ["noemailssend"];
    }
    if (!$show_email_notification ) {
		     echo "<p>" . $GLOBALS["email_messages"] ["usercantreg"];
    }
}

 if ($send != "yes") {
    print '</td></tr><tr><td class=tablesend>';
    print'<form action="' .  getScriptName() . '" method="post"><input type="hidden" name="twg_lang" value="' . $default_language . '" />
    <input type="hidden" name="send" value="yes" /><input type="hidden" name="myaction" value="send" /><input type="hidden" name="action" value="email" /><br>
	    ' . $lang_email_admin_sendermail . ':<br>
		<input type="text" class="wideinput" name="sender" value="' . $sender . '" /><br><br>
		' . $lang_email_admin_subject . ':<br>
		<input type="text" class="widearea" name="subject" value="' . $subject . '" /><br><br>
		' . $lang_email_admin_message . ':<br>
		<textarea rows="7" class="widearea"  name="message">' . $message . '</textarea>&#160;
		<br><br>
		<input type="submit" class="button" value="' . $lang_email_admin_sendbutton . '" />';
  	echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n"; 
		echo '</form>';
		$lines = explode("%", $content);

		echo "<br/>" . $GLOBALS["email_messages"] ["click"] . "<a href = '#' onclick='document.getElementById(\"divsub\").style.display=\"block\";'><b>" . $GLOBALS["email_messages"] ["here"] . "</b></a>" . $GLOBALS["email_messages"] ["listof"] . "<br>";
		echo "<div id='divsub' style='display:none'>";
		echo "<br><u>" . (count($lines)-1) . $GLOBALS["email_messages"] ["subscribers"] . "</u><br>";
		$offset = 0;
		foreach ($lines as $l) {
				$l = decryptEmail($l,$offset++) ;// decrypt email
				if ($l != "") {
						echo $l . "<br/>";
				}
    }
    echo "</div>";
}

if ($send == "yes") {
    $end = "\r\n\r\n -- \r\n" . sprintf($email_bottomtext, "http://" . get_server_name()  .  ":"  . $_SERVER['SERVER_PORT'] . $twg_root);
  //   $end = "test";
   //  $end = stripslashes($end);
    $htmlend = "<span class=\"small\">--<br/>" . sprintf($email_bottomtext, "http://" . get_server_name() . ":"  . $_SERVER['SERVER_PORT']   . $twg_root) . "</span>";
    $message = "" . stripslashes($message);
    $subject = stripslashes($subject);
    $lines = explode("%", $content);
    $offset = 0;
    $errors = 0;
    foreach ($lines as $l) {
        $l = decryptEmail($l,$offset++) ;// decrypt email
        if ($l != "") {
          if ($enable_email_sending) {
             // UTF-8 e-mail
            $result = tfu_mail($l, $subject, $message . $end, $sender);  
            if (!$result) {
              $errors++;
            }              
          }
        }
    }
    $message  = nl2br($message);
    if (!$enable_email_sending) {
        print $GLOBALS["email_messages"] ["emailsendfalse"] . "<br/>&nbsp;<br/>";
    }
    print "<b>" . $lang_email_admin_sent . "</b><br/>&nbsp;<br/>";
    print "<table summary='' cellpadding='0' cellspacing='0'><tr><td>";
    print "<b>" . $lang_email_admin_from .":</b> ". $sender . "<br/>";
    print "<b>$lang_email_admin_subject:</b> $subject\n";
    print "<br/><b>$lang_email_admin_message:</b><br>$message<br/>$htmlend";
		print "<br/></td></tr></table>";
		/*
		echo "<br><u>" . (count($lines)-1) . " Subscribers:</u><br>";
				foreach ($lines as $l) {
						$l = decryptEmail($l,$offset++) ;// decrypt email
						if ($l != "") {
								echo $l . "<br/>";
						}
    }
    */
    if ($errors > 0 && isset($GLOBALS["email_messages"] ["error-of"])) {
      echo '<div class="errordiv">';
      echo  $errors . $GLOBALS["email_messages"] ["error-of"] . count($lines) . $GLOBALS["email_messages"] ["error-send"];
      echo '</div>';     
    }
}
print '</td></tr></table>';
echo "</center></div></div>";

function checkmail($string)
{
    return preg_match("/^[^\s()<>@,;:\"\/\[\]?=]+@\w[\w-]*(\.\w[\w-]*)*\.[a-z]{2,}$/i", $string);
}

?>
