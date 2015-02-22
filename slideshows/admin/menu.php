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
defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');
$menu_printed = false;

function show_menu()
{
	global $show_email_notification;
	global $menu_printed,$php_include;
	global $d, $twg_version;
	$admin = (($GLOBALS["permissions"]&4) == 4);
	$mod = (($GLOBALS["permissions"]&2) == 2);

	if (!$menu_printed) {
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-Type: text/html; charset=" . $GLOBALS["charset"]);

		if (!isset($_SESSION["MENU_STATUS"])) {
			$_SESSION["MENU_STATUS"] = "HIDE";
		}

		if ($_SESSION["MENU_STATUS"] == "HIDE") {
			$hidemenu = "none";
			$showmenu = "block";
		} else {
			$hidemenu = "block";
			$showmenu = "none";
		}

		echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"";
		echo "\"http://www.w3.org/TR/REC-html40/loose.dtd\">\n";
		echo "<HTML lang=\"" . $GLOBALS["language"] . "\" dir=\"" . $GLOBALS["text_dir"] . "\">\n";
		echo "<HEAD>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=" . $GLOBALS["charset"] . "\">\n";
		echo '<meta name="robots" content="noindex">';
    echo "<title>TWGXplorer - File management of the TinyWebGallery</title>\n";
		echo "<script type=\"text/javaScript\">";
	  include "_js/language.js.php";
	  echo "</script>\n";
	  
		echo "<script  src=\"_js/admin.js\"  type=\"text/javascript\"></script>\n";
		echo "<LINK href=\"_style/style.css\" rel=\"stylesheet\" type=\"text/css\">\n";
		echo "</HEAD>\n<BODY>";
		
		echo "<table summary=\"\" style='height:100%;' cellpadding=0 cellspacing=0>";
		echo "<tr><td class='leftsmallmenu' id='hidemenu' style='display:" . $hidemenu . "' height='100%'>";
		echo "<div class='leftsmallmenudiv'><a href=\"#\" onClick=\"showMenu(true);\">";
    echo '<div class="sprites menu_show_gif"></div>';
    echo "</a></div>";
		echo "</td>";
		echo "<td class='leftmenu' id='showmenu' style='display:" . $showmenu . "' height='100%'>";
		echo "<img border=\"0\" width=\"150\" height=\"0\" align=\"middle\" ";
		echo "src=\"" . _QUIXPLORER_URL . "/_img/_.gif\" alt=\"\"><div class='leftsmallmenudiv'><a href=\"#\" onClick=\"showMenu(false);\">";
    echo '<div class="sprites menu_hide_gif"></div>';
    echo "</a></div><br/>";	
    echo "<div class='menudiv'>";
    echo "<center><a href='http://www.tinywebgallery.com' target='_blank'><img border=0 src='_img/twg_logo.png'></a></center><br>";
		if ($GLOBALS["require_login"] && isset($GLOBALS['__SESSION']["s_user"])) echo $GLOBALS["menu_messages"] ["hello"] . " " . $GLOBALS['__SESSION']["s_user"] ;

		echo "<br/>&nbsp;<br/>";

		if ($GLOBALS["action"] != "helper" && $GLOBALS["action"] != "info" && $GLOBALS["action"] != "colorpicker" && $GLOBALS["action"] != "email" && $GLOBALS["action"] != "admin" && $GLOBALS["action"] != "help") {
			echo "<div class='leftmenudivtopsel'>";
		} else {
			echo "<div class='leftmenudivtop'>";
		}
		echo "<a class='leftmenulist' href=\"" . getScriptName() . "?action=list\" >" . $GLOBALS["menu_messages"]["twgxplorer"] . "</a></div>";
		// if ($GLOBALS["action"] == "list") {
		echo "<div class='leftmenusubdiv'>";
		echo "<a href='" . getScriptName() . "?action=list&amp;sview=yes'>" . $GLOBALS["menu_messages"] ["simplevw"] . "</a>";
		echo "<br/><a href='" . getScriptName() . "?action=list&amp;sview=no'>" . $GLOBALS["menu_messages"] ["normalvw"] . "</a>";
		if ($GLOBALS["default_upload_method"] == "flash") {
		  echo "<br/><a href='" . getScriptName() . "?action=upload&amp;sview=no&amp;menu=true'>" . $GLOBALS["menu_messages"] ["uploadima"] . "</a>";
		  if ($GLOBALS["enable_split"]) {
				echo "<br/><a href='" . getScriptName() . "?action=split_info&amp;sview=no&amp;menu=true'>" . $GLOBALS["menu_messages"] ["splitima"] . "</a>";
			}
		}
		// echo "<br/>&nbsp;&nbsp;&nbsp;Upload<br/>";
		echo "</div>";
		// }
		if ($GLOBALS["action"] == "helper") {
			echo "<div class='leftmenudivsel'>";
		} else {
			echo "<div class='leftmenudiv'>";
		}
		if ($admin) {
			echo "<a class='leftmenulist' href=\"" . getScriptName() . "?action=helper\" >" . $GLOBALS["menu_messages"]["helper"] . "</a>";
		} else {
			echo $GLOBALS["menu_messages"]["helper"];
		}
		echo "</div>";

		if ($admin) {
			echo "<div class='leftmenusubdiv'>";
			echo "<a href='" . getScriptName() . "?action=helper'>" . $GLOBALS["menu_messages"] ["configtwg"] . "</a><br/>";
			echo "<a href='" . getScriptName() . "?action=helper#gen'>" . $GLOBALS["menu_messages"] ["generatecach"] . "</a><br/>";
			if (b()) {
				echo "<a href='" . getScriptName() . "?action=helper#gen_preview'>" . $GLOBALS["menu_messages"] ["generateprev"] . "</a><br/>";
			}
				echo "<a href='" . getScriptName() . "?action=helper#gen_iptc'>" . $GLOBALS["menu_messages"] ["generateiptc"] . "</a><br/>";
			echo "<a href='" . getScriptName() . "?action=helper#clean'>" . $GLOBALS["menu_messages"] ["clncach"] . "</a><br/>";
			echo "<a href='" . getScriptName() . "?action=helper#pass'>" . $GLOBALS["menu_messages"] ["generatepassw"] . "</a><br/>";
			echo "<a href='" . getScriptName() . "?action=helper#debug'>" . $GLOBALS["menu_messages"] ["debugfile"] . "</a>";
			echo "</div>";
		}

		if ($GLOBALS["action"] == "info") {
			echo "<div class='leftmenudivsel'>";
		} else {
			echo "<div class='leftmenudiv'>";
		}
		if ($admin) {
			echo "<a class='leftmenulist' href=\"" . getScriptName() . "?action=info\">" . $GLOBALS["menu_messages"]["info"] . "</a>";
		} else {
			echo $GLOBALS["menu_messages"]["info"];
		}
		echo "</div>";

		if ($admin) {
			echo "<div class='leftmenusubdiv'>";
			if (b()) {
				echo "<a href='" . getScriptName() . "?action=info'>" . $GLOBALS["menu_messages"] ["foldovervw"] . "</a><br/>";
				echo "<a href='" . getScriptName() . "?action=info#check'>" . $GLOBALS["menu_messages"] ["installcheck"] . "</a>";
			} else {
				echo "<a href='" . getScriptName() . "?action=info'>" . $GLOBALS["menu_messages"] ["installlcheck"] . "</a>";
			}
			echo "<br/><a href='" . getScriptName() . "?action=info#permissions'>" . $GLOBALS["menu_messages"] ["permissions"] . "</a>";
			echo "<br/><a href='" . getScriptName() . "?action=info#settings'>" . $GLOBALS["menu_messages"] ["recomsett"] . "</a>";
			echo "<br/><a href='" . getScriptName() . "?action=info&amp;showphpinfo=true'>" . $GLOBALS["menu_messages"] ["showphpinfo"] . "</a>";

			echo "</div>";
		}

		if ($GLOBALS["action"] == "colorpicker") {
			echo "<div class='leftmenudivsel'>";
		} else {
			echo "<div class='leftmenudiv'>";
		}
		if ($admin) {
			echo "<a class='leftmenulist' href=\"" . getScriptName() . "?action=colorpicker\" >" . $GLOBALS["menu_messages"]["color"] . "</a>";
		} else {
			echo $GLOBALS["menu_messages"]["color"];
		}
		echo "</div>";

		if ($GLOBALS["action"] == "email") {
			echo "<div class='leftmenudivsel'>";
		} else {
			echo "<div class='leftmenudiv'>";
		}
		if ($admin) {
			echo "<a class='leftmenulist' href=\"" . getScriptName() . "?action=email\" >" . $GLOBALS["menu_messages"]["email"] . "</a>";
		} else {
			echo $GLOBALS["menu_messages"]["email"];
		}
		echo "</div>";

		if ($GLOBALS["action"] == "admin") {
			echo "<div class='leftmenudivsel'>";
		} else {
			echo "<div class='leftmenudiv'>";
		}
		if ($mod || $admin) {
			echo "<a class='leftmenulist' href=\"" . getScriptName() . "?action=admin\" >" . $GLOBALS["menu_messages"]["admin"] . "</a>";
		} else {
			echo $GLOBALS["menu_messages"]["admin"];
		}
		echo "</div>";
		if ($GLOBALS["action"] == "help") {
			echo "<div class='leftmenudivsel'>";
		} else {
			echo "<div class='leftmenudiv'>";
		}
		echo "<a class='leftmenulist' href=\"" . getScriptName() . "?action=help\" >" . $GLOBALS["menu_messages"]["help"] . "</a></div>";
		echo "<br/>";

		if (isset($_SESSION['twg_root_dir'])) {
			$twg_root = trim($_SESSION['twg_root_dir']);
		} else if ($php_include==false) {
		  $twg_root = '../index.php';
		} else {
			$twg_root = false;
		}
		$top = 'top';
		
    if (!b()) {
      $llang = ($GLOBALS["language"] == 'de') ? 'de' : 'en';
      echo "<div class='leftmenudiv".$top."'><a class='leftmenulist' target=\"_blank\" href=\"http://www.tinywebgallery.com/".$llang."/register_twg.php\" >" . $GLOBALS["menu_messages"] ["register"] . "</a></div>";
      $top = '';
    }
		if ($twg_root) {
			echo "<div class='leftmenudiv".$top."'><a class='leftmenulist' href=\"" . $twg_root . "\" >" . $GLOBALS["menu_messages"] ["backtotwg"] . "</a></div>";
			echo "<div class='leftmenudiv'><a class='leftmenulist' href=\"" . getScriptName() . "?action=logout\" >" . $GLOBALS["menu_messages"]["logout"] . "</a></div>";
		} else {
			echo "<div class='leftmenudiv".$top."'><a class='leftmenulist' href=\"" . getScriptName() . "?action=logout\" >" . $GLOBALS["menu_messages"]["logout"] . "</a></div>";
		}
		$menu_printed = true;
		echo "<br/>&nbsp;<br/>";
        
        		// we chow the version check
		    $vers = $twg_version;
        set_error_handler("on_error_no_output");
        $latest_version = getlatestVersion();	
        set_error_handler("on_error");
	if ($latest_version == -1) {
$version_description = '<span class="twg_nocheck"><p>' . _C_VERSION_NO . ' <a href="http://www.tinywebgallery.com" target="_blank">www.tinywebgallery.com</a> ' . _C_VERSION_NO2 . '<p></span>';
} else if (version_compare ($latest_version,$vers)== 1) {
$version_description = '<span class="twg_old"><p>' . _C_VERSION_OLD1 .  ' <a class="twg_nocheck" href="http://www.tinywebgallery.com" target="_blank">www.tinywebgallery.com</a>.</p><br><p>' . _C_VERSION_OLD3 . '<b>' . $latest_version.'</b>. '._C_VERSION_OLD4.'<b>' . $vers . '.</b></p><br><p>
'._C_VERSION_OLD5.' <a class="twg_nocheck" href="http://www.tinywebgallery.com/blog" target="_blank">'._C_VERSION_OLD6.'</a>.' . '</p></span>';
} else {
$version_description = '<span class="twg_current"><p>' . _C_VERSION_OK . '<p></span>';
}
echo $version_description; 		

        		
	
$fblang = ($GLOBALS["language"] == 'de') ? 'de_DE' : 'en_US';		
echo '		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/'.$fblang.'/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';

echo '<div style="padding:20px;" class="fb-like" data-href="http://www.facebook.com/tinywebgallery" data-send="false" data-layout="button_count" data-width="120" data-show-faces="false"></div>';				

	echo "</div>"; // closes the menu div!
		echo "</td><td class='rightcontent'>";
	}
}
