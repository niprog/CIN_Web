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
 
  $Date: 2007-03-23 14:05:50 +0100 (Fr, 23 Mrz 2007) $
  $Revision: 48 $
**********************************************/

define('_VALID_TWG', '42');
include "i_basic.inc.php";
include "../admin/_include/fun_users.php";
$action = "init";
if (isset($_GET['twg_action'])) {
   $action =  $_GET['twg_action']; 
}

$user = parse_parameter('twg_user', true);

if  (ereg('^[a-zA-Z0-9._-]*$', $user)) {
 $error_username = false;
} else {
 $error_username = true;
}

$passwort = parse_parameter('twg_passwort', true);
$regid = parse_parameter('twg_regid', true);
$c = parse_parameter('twg_c', true);

$fokus = "";

include "i_header.inc.php";
include "i_body_head.inc.php"; // body and closebutton

if ($enable_selfregistration) {
     if (isset($_GET["PHPSESSID"])) {
        $closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?PHPSESSID=" . $_GET["PHPSESSID"] . "&twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
     } else {
        $closescript = "<script>closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) . "?twg_album=" . $album_enc . "&twg_show=" . $image_enc . $twg_standalonejs . "'  }</script>";
     }
     echo "<strong>" . $lang_register_header . "</strong><br/>";

if ($action == "init") {
 showLogin();
} else if ($action == "register") {
  if ($user == "" || $passwort == "") {
    echo "<p class='pad error'>".$lang_register_req."</p>";
    showLogin();
  } else if ($error_username){ 
    echo "<p class='pad error'>".$lang_register_error_user."</p>";
    showLogin();
  } else if ($enable_id_registration && $enable_id_registration != $regid){ 
    echo "<p class='pad error'>".$lang_register_id."</p>";
    showLogin();
  } else if ($self_registration_security_image && strtolower ($c) != $_SESSION['twg_key']){   
     echo "<p class='pad error'>".$lang_register_security."</p>";
    showLogin();
  } else {
    $mydir = "../" . $self_registration_basedir . "/" . $user;
    if (file_exists($mydir) && $self_registration_create_userdir) { // does the dir exist ?
      echo "<p class='pad error'>".$lang_register_inuse."</p>";
      showLogin();
    } else {
      if ($self_registration_create_userdir) {
        mkdir ($mydir);    
      } else {
        $mydir = "../" . $self_registration_basedir;  
      } 
      // we check if the folder can be created!
      if (file_exists($mydir)) {
		  // we have to add the user now ...
		  load_users(); 

		  $data=array($user,md5($passwort),str_replace("../","",stripslashes($mydir)),$self_registration_functions,0,"^.ht",1,1);  			
		  if(!add_user($data)) {
			echo "<p class='pad error'>".$lang_register_nouser."</p>";
		  } else {
			echo "<p class='pad'>".$lang_register_created."</p>";
      if ($self_registration_create_userdir) {
        echo "<p class='pad'>".$lang_register_upload." " . $user . "</p>";
      } else if ($self_registration_basedir != $basedir) {
         substr($self_registration_basedir, strlen($basedir)); 
        echo "<p class='pad'>".$lang_register_upload." " . $self_registration_basedir . "</p>";
      }
			echo "<p class='pad' class='pad'>".$lang_register_upload2."</p>";
			echo "<p class='pad'>".$lang_register_upload3."</p>";
			remove_tmp_files();
			set_error_handler("on_error_no_output");
			$save_root = $_SESSION['twg_root_dir'];
      @session_destroy();
      $_SESSION = array(); 
			@session_start();
      @session_regenerate_id();
			flush();
			$_SESSION['twg_root_dir'] = $save_root;
			set_error_handler("on_error");
			if ($self_registration_email != "") {
			  $lang_email_register_subject=$self_registration_subject;
			  $lang_email_register_text=sprintf($self_registration_text,$user,$mydir,$_SERVER['REMOTE_ADDR']);
			  // UTF-8 e-mail
        tfu_mail($self_registration_email, $lang_email_register_subject, $lang_email_register_text, $self_registration_email);                 
      }
		  }
      } else {
        echo "<p class='pad error'>".$lang_register_dir."</p>"; 
      }
    } 
  }
}
echo "</form>";
} else {
  showInvalidAccess();
}
include "i_bottom.inc.php"; 


function showLogin() {
global $lang_username,$lang_password, $enable_id_registration, $self_registration_security_image,$lang_register_intro,$lang_register_askid;
global $lang_register_regid,$lang_register_ip,$lang_rating_security,$lang_register_button,$lang_register_security_image;

echo '
<p class="pad">'.$lang_register_intro;
if ($enable_id_registration != "") {
 echo "<br />" . $lang_register_askid;
}

echo '</p>
<p>'.  $lang_username .'<br />
<input class="login" id="twg_user" name="twg_user" type="text" style="width:130px" /><br />
'.  $lang_password . '<br />
<input  class="login"  id="twg_passwort" name="twg_passwort" type="password"  style="width:130px" /><br />';
if ($enable_id_registration != "") {
echo $lang_register_regid.'<br />
<input  class="login"  id="twg_regid" name="twg_regid" type="text"  style="width:130px"/><br />
';  
}

session_write_close();

if ($self_registration_security_image) {
echo '
    <style>img {  padding:2px; }</style>
    '.$lang_register_security_image.'<br />
    <a href="javascript:location.reload();"><img border="0" src="i_tacs.inc.php" alt="CAPTCHA IMAGE" /></a><br />'.$lang_rating_security.'<br />
	<input style="margin-top:3px;width:50px" type="text" id="twg_c" name="twg_c" /><br />
	';
}
echo '
</p>
<input type="hidden" name="twg_action" value="register" />
<input class="btn btn-small" type="submit" name="twg_submit" value="'.$lang_register_button.'" />
<br/><center>'.$lang_register_ip.' ' .$_SERVER['REMOTE_ADDR'] .'</center>';
}
?>