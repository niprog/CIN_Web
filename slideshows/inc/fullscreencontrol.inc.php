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

function createFullscreenControl($twg_album, $image)
{
    global $lang_loading;
    global $install_dir, $install_dir_view;
    global $twg_standalonejs;
    global $lang_stop_slideshow;
    global $lang_start_slideshow;
    global $browser_title_prefix;
    global $show_caption_at_maximized_view;
    global $twg_slideshow_time;
    global $lang_of, $charset;
    global $lang_picture, $enable_download;
    global $browserx, $browsery, $icon_set;

    $imagelist = get_image_list($twg_album);
    $act_nr = get_image_number($twg_album, $image);
    $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
    for ($current = 0, $i = 0; $i < count($imagelist); $i++) {
        if (urldecode($imagelist[$i]) == urldecode($image)) {
            $current = $i;
        }
    }

    $upper_level_alb = getupperdirectory($twg_album);
    if ($upper_level_alb) {
        $upper_leveljs = getScriptName() . "?twg_album=" . urlencode($upper_level_alb) . $twg_standalonejs;
    } else {
        $upper_leveljs = getScriptName() . "?" . $twg_standalonejs;
    }

    if (isset($_SESSION['twg_ses_foffset'])) {
        // 1 Level weg !
        $current_path = explode(",", $_SESSION['twg_ses_foffset']);
        array_pop($current_path);
        $level = implode(",", $current_path);
        if ($_SESSION['twg_ses_foffset'] != '0' && $_SESSION['twg_ses_foffset'] != '' && $_SESSION['twg_ses_foffset'] != '0,0') { //
            $upper_leveljs .= "&twg_foffset=" . $level;
        }
    }

    // now we create the Array with the imagesources we have to replace!
    echo '<script type="text/javascript">';
    echo 'var thumbs=new Array();';
    $sum = 0;
    for ($i = 0; $i < count($imagelist); $i++) {
        echo "thumbs[" . $i . "] = 'twg_album=" . $album_enc . "&twg_show=" . $imagelist[$i] . $twg_standalonejs . "';\n";
    }

    echo '</script>';
    // we insert the script here because otherwise the function os not known sometimes
    echo '<script type="text/javascript">
var lastpos = ' . $current . ';
var endpos = ' . count($imagelist) . ';
var actpos = 0;
var ready = true;

var xy = "0";
var reload = 0;
var img = new Array();
var pospreloaded = 0;

function load_img(srcnum, type)
{
   if (img!=0)
     delete img; /* altes Bild entsorgen */
   if (img[srcnum]) {
      // nothing right now
   } else {
     img[srcnum]=new Image(); /* neues Bild-Objekt anlegen */
     img[srcnum].src="' . $install_dir_view . 'image.php?" + thumbs[srcnum] + type + "&id=" + xy;
   }
}

function changeContent(pos) {
	if (ready != true) {
	  return;
	}
	reload=0;
	nextpos = lastpos + pos;
	if ((nextpos >= endpos) && (slideshow == true)) {
		nextpos = 0;
	}
	changeContentWait(nextpos);
}

var newData = "old";
var loadedData = false;
var resizereload = 2;

function load_data(pos) {
if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
if (!myConnB) alert("XMLHTTP not available. Try a newer/better browser.");
var fnWhenDone = function (oXML) { newData = oXML.responseText; loadedData = true; };
myConnB.connect("' . $install_dir_view . 'image.php?id="+ xy +"&" + thumbs[pos] + "&twg_xmlhttp=d", fnWhenDone);
}


function changeContentWaitLast() {
   changeContentWait(actpos);
}

function changeContentWait(poss) {
 pos=parseInt(poss);
 var oldxy = xy;
  	   
 if (pos < 0) {
    lastpos = 0;
    if (pos < -90000) {
      pos=lastpos;
    } else {
      return;
    }
   } else if (pos >= endpos) {
    lastpos = endpos-1;
    if (pos > 90000) {
	       pos=lastpos;
	     } else {
	       return;
    }
 }

 actpos = pos;
 ready = false;

 var box = document.getElementById("twg_contol_text");
    if (reload == 0) {
      if (xy != oldxy && xy != "0") { // browser resolution changed!
         xy = send_Browser_resolution("no", "' . $install_dir_view . '","' . $GLOBALS["standalone"] . '");
         resizereload = 0;	    
	  }
	  if (resizereload++ < 2) {   
	     img = new Array();	
      }
      load_img(pos, "&twg_type=fullscreen");
      load_data(pos);
    }
    box.innerHTML = "' . $lang_loading . '";

    reload++;
    if (pos==0) {
			 document.getElementById("backbutton").style.visibility = "hidden";
		} else {
				document.getElementById("backbutton").style.visibility = "";
		}
		if (pos >= endpos-1) {
				document.getElementById("nextbutton").style.visibility = "hidden";
		} else {
				document.getElementById("nextbutton").style.visibility = "";
		}

     if (img[actpos].complete && loadedData) {
          var dataArray = newData.split("|___|");
          var newCaption = dataArray[0];
          document.images.defaultslide.src=img[actpos].src;
          box.innerHTML = "' . $lang_picture . ' " + (pos+1) + " ' . $lang_of . ' " + (endpos) ;';
    if ($show_caption_at_maximized_view) {
        echo 'document.getElementById("twg_fullscreencaption").innerHTML = newCaption;
            document.title = "' . $browser_title_prefix . ' - " + newCaption;';
    }
    echo 'if (lastpos<pos) {
            load_img(pos+1, "&twg_type=fullscreen");
          } else {
            load_img(pos-1, "&twg_type=fullscreen");
          }
          lastpos = pos;
          // linkexchange
          ';
    if ($enable_download) {
        echo 'if (document.getElementById("adefaultslide")) { document.getElementById("adefaultslide").href="' . $install_dir_view . 'image.php?id=" + xy + "&" + thumbs[pos]; }';
    }
    echo 'ready=true;
          loadedData = false;
          setTimer(4);

    } else {
      if (reload==50) { // 10 sekunden - reload
        window.location = "' . getScriptName() . '?" + thumbs[actpos] + "' . $twg_standalonejs . '";
      }
      window.setTimeout("changeContentWaitLast()",200);
      return;
    }
}

var slideshow=false;

function startSlideshow() {
  newHtml = "<img class=\"fs_sprites menu_stop_full_gif twg_hand\" id=\"slideshowbutton\" alt=\"' . $lang_stop_slideshow . '\" title=\"' . $lang_stop_slideshow . '\" onclick=\"javascript:stopSlideshow();\" src=\"' . $install_dir_view . 'buttons/1x1.gif\" >";
  document.getElementById("slideshowarea").innerHTML = newHtml;
  slideshow=true;
  runSlideshow();
}


function runSlideshow() {
  if (slideshow != false) {
      changeContent(1);
  		window.setTimeout("runSlideshow()",' . ($twg_slideshow_time * 1000) . ');
  }
}

function stopSlideshow() {
  newHtml = "<img class=\"fs_sprites menu_start_full_gif twg_hand\" id=\"slideshowbutton\" alt=\"' . $lang_start_slideshow . '\" title=\"' . $lang_start_slideshow . '\" onclick=\"javascript:startSlideshow();\" src=\"' . $install_dir_view . 'buttons/1x1.gif\" >";
	document.getElementById("slideshowarea").innerHTML = newHtml;
  changeContent(0);
  slideshow=false;
}

function key_back() {
  changeContent(-1);
  setTimer(3);
  show_control_div();
}

function key_foreward() {
  changeContent(1);
  setTimer(3);
  show_control_div();
}

function key_up() {
   location.href=\'' . $upper_leveljs . '\';
}

var timer = 10;
function closeControl() {
	if (timer-- < 0) {
		hide_control_div();
	}
window.setTimeout("closeControl()",500);
}

function setTimer(time) {
  timer=time;
}

closeControl();
load_img(lastpos+1, "&twg_type=fullscreen");

function closeFullscreen() {
  loc = "' . getScriptName() . '?" + thumbs[lastpos] +  "&twg_zoom=FALSE' . $twg_standalonejs . '";
  window.location = loc;
  return false;
  ';

    echo '}</script>';
}

?>