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

$relativepath = ""; // basedir changed!
include "../inc/checkprivate.inc.php";

$fokus = "twg_passwort";
include "i_header.inc.php";
$passwort = false;

if (isset($_GET['twg_passwort'])) {
    $passwort = replaceInput($_GET['twg_passwort'], true);
    $log_pw = anonymise_pw($passwort);
    if ($encrypt_passwords) {
    	if (function_exists("sha1") && $use_sha1_for_password) {
	      $passwort = sha1($passwort);
		} else {
		  $passwort = sha2($passwort);
 		}
    }
    if (in_array($passwort,$passwd)) {
        $_SESSION["privategallogin"] =  $passwort;
        // we generate the piclens.rss
        // $oldbase = $basedir;
        // $basedir = "../" .$basedir;
        $dd = get_view_dirs( $basedir ,$passwort);
        generate_piclens_rss($dd, $passwort, true);
        // $basedir = $oldbase; // we have to reset it because later on it is set again!
        log_twg("Correct password (IP: ".$_SERVER["REMOTE_ADDR"].") entered for: " . $twg_album . " : " . $log_pw);
    } else {
        log_twg("Wrong password (IP: ".$_SERVER["REMOTE_ADDR"].") entered for: " . $twg_album . " : " . $log_pw);
    }
}

$logout = false;
if (isset($_GET['twg_logout'])) {
    unset($_SESSION["privategallogin"]);
    $logout = true;
}

include "i_body_head.inc.php"; // body and closebutton

// we do the autoskipthumbs!
$imagelist = get_image_list($twg_album);
if ($auto_skip_thumbnail_page && $twg_smallnav == 'FALSE') {
	if (count($imagelist) <= $numberofpics) {
		$skip_thumbnail_page = true;
	}
}
$skip = "";
if ($skip_thumbnail_page && $twg_album != false) {
  $skip="&twg_show=x";
}

if ($twg_album == false) {
  echo "<script type=\"text/javascript\">
    hideSec('bt_close');
    </script>";
}
// the weired setTimeout is needed for Opera 9 - seems to be a bug there!
$closescript = "<script>window.setTimeout(\"closeiframe(); if (reload) { parent.location='" . urldecode($twg_root) ."' + location.search.substring(0,location.search.indexOf('twg_passwort')-1) +'" . $skip . "'; }\",100);</script>";
if ($logout) {
    echo $closescript;
} else if ($passwort == false) {
    $value =  sprintf($lang_privatelogin_php_password, getDirectoryName($basedir . "/" . $twg_album, $twg_album));
    echo str_replace("<br />''", "", $value);
} else if (!in_array($passwort,$passwd)) {
    echo $lang_privatelogin_php_wrong_password;
} else {
    echo $closescript;
}

?>
  <br /><img alt='' src='../buttons/1x1.gif' height='4' /><br /><input id="twg_passwort"  name="twg_passwort" type="password" style="vertical-align:middle;width:130px;"/>
  &nbsp;
  <input class="btn btn-small" type="submit" name="Submit" value="<?php echo $lang_privatelogin_php_login ?>" />
</td></tr></table>
</form>
<?php include "i_bottom.inc.php"; 

function anonymise_pw($pw) {
 if (strlen($pw) > 3) {
    return substr($pw, 0, 3) . "******";   
 } else {
    return $pw{0} . "*****";
 }
}


?>