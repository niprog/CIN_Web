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
include_once "../admin/_include/fun_users.php";

$passwort_ok = false;

$user = parse_parameter('twg_user');
$passwort = parse_parameter('twg_passwort');
$language = parse_parameter('twg_admin_lang');

if ($user && $passwort) {
  clearstatcache();
  load_users();
  $ok = activate_user($user, md5($passwort));
  if ($ok || $GLOBALS["low_permissions"] == true) {
  	  $_SESSION["mywebgallerie_login"] = "ok";
  	  $_SESSION["twg_permissions"] = $GLOBALS["permissions"];
      $_SESSION["s_user"] = $user;
      $_SESSION["s_pass"] = md5($passwort);
      $_SESSION["admin_lang"] = $language;
      $passwort_ok = true;
      log_twg("Login: (IP: ".$_SERVER["REMOTE_ADDR"].") " . $user);
      if ($user_login_mode) {
          $_SESSION["privategallogin"] =  $user; 
      }
  }
}

$logout = false;
if (isset($_GET['twg_logout'])) {
    unset($_SESSION['mywebgallerie_login']);
    unset($_SESSION['twg_permissions']);
    unset($_SESSION['s_user']);
    unset($_SESSION['s_pass']);
    unset($_SESSION['s_home_dir']); // set in fun_users.php 
    unset($_SESSION['admin_lang']);
    unset($_SESSION['upload_settings']);
    if ($user_login_mode) {
      // we logout from the current folder as well
      $privatelogin = 'FALSE';
	    unset($_SESSION['privategallogin']);
    }
    $logout = true;
}

$GLOBALS["lang"] = $default_language;
$fokus = "twg_user";
include "i_header.inc.php";
include "i_body_head.inc.php"; // body and closebutton
if ($show_login) {
// the weired setTimeout is needed for Opera 9 - seems to be a bug there!
if (!$logout) {
	$closescript = "<script>window.setTimeout(\"closeiframe(); if (reload) {  parent.location='" . urldecode($twg_root) ."' + location.search.substring(0,location.search.indexOf('twg_submit')-1);  } \",100);</script>";
  // $closescript = "<script>window.setTimeout(\"closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) ."?twg_album=" . $album_enc  . "&twg_show=" . $image_enc . $twg_standalonejs . "'} \",100);</script>";
} else {
if ($multi_root_mode) {
     $subfolders = explode("/", $twg_album);
	$closescript = "<script>window.setTimeout(\"closeiframe(); if (reload) {  parent.location='" . urldecode($twg_root) . "?twg_album=" . urlencode($subfolders[0])  . "';  } \",100);</script>";
} else {
	$closescript = "<script>window.setTimeout(\"closeiframe(); if (reload) {  parent.location='" . urldecode($twg_root) . "';  } \",100);</script>";
}

}
if ($logout) {
    echo $closescript;
} else if ($passwort == false) {
    echo $lang_login_php_enter;
} else if (!$passwort_ok) {
    echo $lang_login_php_enter_again;
    log_twg("Wrong login: (IP: ".$_SERVER["REMOTE_ADDR"].") " .$user . "/" .str_repeat("*",strlen($passwort)));   
} else {
   echo $closescript;
}

?>
<br /><img alt='' src='../buttons/1x1.gif' height='4' width='1' /><br />
<?php echo $lang_username; ?><br />
<input class="login" id="twg_user" name="twg_user" type="text" style="width:130px;" /><br />
<?php echo $lang_password; ?><br />
<input  class="login"  id="twg_passwort" name="twg_passwort" type="password" style="width:130px;" /><br />
<?php 
if (!file_exists("../admin/_lang/" .$default_language . ".php" )) {
echo $lang_language; 
echo '<br />';
echo '<select class="selectbig" name="twg_admin_lang">';
include "../admin/_lang/_info.php";
echo  '</select><br />';
} else {
echo '<input id="twg_admin_lang" name="twg_admin_lang" type="hidden" value="'.$default_language.'"/>';
}
?> 
<img alt='' src='../buttons/1x1.gif' height='4' /><br />
  <input class="btn btn-small" type="submit" name="twg_submit" value="<?php echo
$lang_privatelogin_php_login ?>" />
</td></tr></table>
</form>
<?php 
if ($enable_selfregistration) {
  echo "<p><a href='i_register.php?twg_album=".$album_enc."'>".$lang_register_here."</a></p>";
}
} else {
  showInvalidAccess();
}
include "i_bottom.inc.php"; 
?>