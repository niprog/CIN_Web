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

function print_cmotion_gallery($twg_album, $entry, $thumb_pic_size, $dir, $show_strip = true)
{
    global $numberofpics; // the number of pics on each side which are loaded for ie - ff needs all!
    global $cachedir, $basedir, $kwerte, $kindex, $werte, $index, $extension_thumb;
    global $extension_small, $show_count_views, $default_language, $login_edit;
    global $cmotion_gallery_limit_ie, $cmotion_gallery_limit_firefox, $lang_forward;
    global $lang_back, $enable_download, $thumb_pic_size, $lang_loading, $twg_rot_available;
    global $enable_direct_download, $enable_optimize_cmotion_gallery_limit_ie, $install_dir;
    global $show_optionen, $show_comments, $show_login, $browser_title_prefix, $twg_standalone;
    global $twg_standalonejs, $show_rotation_buttons, $show_enter_comment_at_bottom;
    global $show_enhanced_file_infos, $show_image_rating, $s, $show_comments_in_layer;
    global $image_rating_position, $show_number_of_comments, $enable_download_as_zip;
    global $show_comments_menue, $disable_direct_thumbs_access, $show_captions, $show_clipped_images;
    global $video_size_x, $video_size_y, $video_player, $video_autostart, $video_flash_site, $video_autostart_parameter;
    global $autodetect_noscoll, $use_nonscrolling_dhtml, $strip_thumb_pic_size;
    global $playerjs, $show_tags; // not a nice solution! This is set in the videostreaming.inc.php!
    global $msie, $safari, $opera, $isns, $use_resized_background, $open_in_maximized_view, $show_thumbs_as_text;
    global $show_flv_player_below_iframe, $default_big_navigation, $flash_nav_reflection, $flash_nav_reflection_bg_color;
    global $flash_hide_scrollbar, $flash_enable_autoscroll, $flash_border_color, $icon_set, $twg_download, $dynamic_image_txt;
    global $video_flv_buffer, $big_thumbnail_strip, $image_page_fade, $charset, $video_flv_stretching;
    global $install_dir_view, $twg_seo_active, $responsive_detail_page;

    if ($show_clipped_images) {
        $thumb_pic_size = $strip_thumb_pic_size;
    }

    $preloadrange = 4;
    $cmotionoverlap = 4;

    if ($msie && $enable_optimize_cmotion_gallery_limit_ie && !$opera) {
        $cmotion_gallery_limit = $cmotion_gallery_limit_ie;
    } else {
        $preloadrange = 1000; // dummy value to load all pictures of this set!
        $cmotion_gallery_limit = $cmotion_gallery_limit_firefox;
    }

    if (!$show_strip || $show_thumbs_as_text) {
        $preloadrange = 10000; // dummy value to load all pictures of this set!
        $cmotion_gallery_limit = $preloadrange;
    }


    $space = 8;
    $imagelist = get_image_list($twg_album);

    if (count($imagelist) < $cmotion_gallery_limit) { // show all images if we are below the limit.
        $cmotionoverlap = $cmotion_gallery_limit;
    }

    $act_nr = get_image_number($twg_album, $entry);
    $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
    $imgtwg_offset = 0;
    for ($current = 0, $i = 0; $i < count($imagelist); $i++) {
        if (urldecode($imagelist[$i]) == urldecode($entry)) {
            $current = $i;
        }
    }
    // we calculate the pre and posts
    if ($dir == "next") {
        $startgal = $act_nr - $cmotionoverlap;
        $stopgal = $startgal + $cmotion_gallery_limit;
    } else {
        $startgal = $act_nr - $cmotion_gallery_limit + $cmotionoverlap;
        $stopgal = $act_nr + $cmotionoverlap;
    }

    if (($startgal < 0 && $dir == "next") || ($startgal < 2 && $dir == "back")) { // for downwardsfix
        $startgal = 0;
        $stopgal = $cmotion_gallery_limit;
    }
    // for upward I don't want to have more than 2 images for the next galerie and the rest than backwards);
    if ($dir == "next" && $stopgal > (count($imagelist) - 2)) {
        $stopgal = count($imagelist);
        $startgal = $stopgal - $cmotion_gallery_limit;
        if ($startgal < 0) $startgal = 0;
    }

    $displayFlash = false;
    if ($default_big_navigation == "FLASH" && $show_strip) {
        $show_strip = false;
        $displayFlash = true;
        $cmotion_gallery_limit = 10000;
        $startgal = 0;
        $stopgal = 10000;
        $_SESSION['TWG_CURRENT_DIR'] = $twg_album;
        $xmlfile = $install_dir . create_cache_file(md5($twg_album), 'flash.tmp.xml');
        $xmlfile_view = $install_dir_view . create_cache_file(md5($twg_album), 'flash.tmp.xml');
                
        $flashxml = file_exists($xmlfile) ? '&twg_data=' . $xmlfile_view : '&twg_init=' . $xmlfile_view;
        $flash_border_color_data = ($flash_border_color != '') ? '&twg_border_color=' . $flash_border_color : '';
        // we include the flash!

        echo '<span id="stripcontent"><span class="noflash">The flash requires at least Flash 8.<br>Please get it <b><a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&amp;promoid=BIOW" target="_blank">here</a></b>.</span></span>';
        echo '<script type="text/javascript">';
		echo '
		var curr_pos = ' . ($act_nr + 1) . ';	
		if (location.hash != "" ) {
          var pos = location.hash.substring(1);
          if (!isNaN(pos)) {
		    curr_pos = parseInt(pos) + 1;
		  }
		}';
		
        if ($big_thumbnail_strip) {
            $motion_width = 550;
            echo 'var fl = new SWFObject("' . $install_dir_view . 'html/strip120.swf?twg_shadow=' . $flash_nav_reflection . '&twg_background=' . $flash_nav_reflection_bg_color . '&twg_current=" + curr_pos + "&twg_status=' . checkFullscreen() . '&twg_hide_scrollbar=' . $flash_hide_scrollbar . '&twg_enable_autoscroll=' . $flash_enable_autoscroll . '&twg_path=' . $install_dir_view . $flashxml . $flash_border_color_data . '&twg_license_part=' . substr($s, 0, 32) . '&twg_external_album=TWG_' . $album_enc .'", "myMovie", "550", "153", "8");';
        } else {
            $motion_width = 440;
            echo 'var fl = new SWFObject("' . $install_dir_view . 'html/strip100.swf?twg_shadow=' . $flash_nav_reflection . '&twg_background=' . $flash_nav_reflection_bg_color . '&twg_current=" + curr_pos + "&twg_status=' . checkFullscreen() . '&twg_hide_scrollbar=' . $flash_hide_scrollbar . '&twg_enable_autoscroll=' . $flash_enable_autoscroll . '&twg_path=' . $install_dir_view . $flashxml . $flash_border_color_data . '&twg_license_part=' . substr($s, 0, 32) . '&twg_external_album=TWG_' . $album_enc. '", "myMovie", "440", "135", "8");';
        }
        echo 'fl.addParam("wmode","transparent");';
        echo 'fl.addParam("allowScriptAccess","always");';
        echo 'fl.write("stripcontent");';
        echo '</script>';
        
         if ($responsive_detail_page) {
           echo '<style>
           @media only screen and (max-width: '.($motion_width+40).'px) {
             #stripcontent { display: none; }
             .twg_folderdescription, .topnavright {  display: none; } 
           }
           @media only screen and (max-width: '.($motion_width+400).'px) {
             .twg_folderdescription { padding-right: 20px; padding-left: 20px; }  
           }
           @media only screen and (max-width: '.($motion_width+150).'px) {
             #ccw, #cw { display: none; } 
             .sidenavleft, .sidenavright { display: none; }  
           }
           </style>';
        }  
    }

    $num_twg_shown_images = $stopgal - $startgal;
    if ($show_strip) {
        echo "<td class=twg>";

        // Modified Code for XHTML Doctypes in Firefox
        $motion_width = (((($numberofpics * 2 + 1) * $thumb_pic_size + ($numberofpics * 2) * $space)) + 2);
        if ($msie) { // For IE    
            echo '<div id="motioncontainer" style="position:relative;z-index:15;width:' . $motion_width . 'px;height:' . ($thumb_pic_size + 2) . 'px;overflow:hidden;">
<div id="motiongallery" style="position:absolute;z-index:16;left:0;top:0;white-space: nowrap;vertical-align: middle;">';
        }
        else { // For FF
            echo '<div id="motioncontainer" style="position:relative;z-index:15;width:' . $motion_width . 'px;height:' . ($thumb_pic_size + 2) . 'px;overflow:hidden;">
<div id="motiongallery" style="position:absolute;z-index:16;left:0;top:0;white-space: nowrap;vertical-align: middle;"><span id="trueContainer" style="white-space: nowrap;">';
        }
        if ($responsive_detail_page) {
         echo '<style>
         @media only screen and (max-width: '.($motion_width+40).'px) {
           #motioncontainer { display: none; }
           .twg_folderdescription, .topnavright { display: none; } 
         }
         @media only screen and (max-width: '.($motion_width+400).'px) {
           .twg_folderdescription { padding-right: 20px; padding-left: 20px; }   
         }
         @media only screen and (max-width: '.($motion_width+150).'px) {
           #ccw, #cw { display: none; }
           .sidenavleft, .sidenavright { display: none; }   
         }
         </style>';
        }
        

        $thumbimage = create_thumb_image($twg_album, $imagelist[0]);
        $thumb = create_cache_file($thumbimage, $extension_thumb);
        if (file_exists($thumb) && !$disable_direct_thumbs_access && !$show_clipped_images) {
            $size1st = getimagesize($thumb);
            $size1stX = $size1st[0];
        } else {
            $size1stX = $thumb_pic_size;
        }

        $twg_offset1st = floor(($thumb_pic_size - $size1stX) / 2);
        // echo $twg_offset1st;
        // $imgtwg_offset = -$twg_offset1st; // we have to add the starting twg_offset!
        echo '<img src="' . $install_dir_view . 'buttons/1x1.gif" alt="" align="middle" width=' . ($twg_offset1st + ($numberofpics * $space) + ($numberofpics * $thumb_pic_size) - 30) . ' height=' . $thumb_pic_size . ' >';
        if ($startgal > 0) {
            $hreflast = getScriptName() . "?twg_album=" . $album_enc . "&amp;twg_show=" . $imagelist[$startgal - 1] . '&amp;twg_dir=back' . $twg_standalone;
            $hreflastjs = getScriptName() . "?twg_album=" . $album_enc . "&twg_show=" . $imagelist[$startgal - 1] . '&twg_dir=back'. $twg_standalonejs;

            printf("<a href='%s'><img class='twg_buttons menu_left_gif' style='border: 0px;' src='%sbuttons/1x1.gif' alt='%s' align='middle' title='%s' width='22' ></a>", tfu_seo_rewrite_url($hreflast), $install_dir_view, $lang_back, $lang_back);
        } else {
            echo '<img src="' . $install_dir_view . 'buttons/1x1.gif" alt="" width=22 height=1 >';
            $hreflast = "#";
            $hreflastjs = "#";
        }
        echo '<img src="' . $install_dir_view . 'buttons/1x1.gif" alt="" width=6 height=1 >';

        for ($i = $startgal; (($i < count($imagelist)) && ($i < $stopgal)); $i++) {
            $thumbimage = create_thumb_image($twg_album, $imagelist[$i]);
            $thumb = create_cache_file($thumbimage, $extension_thumb);
            $thumbexists = false;
            if (file_exists($thumb)) {
                $thumbexists = true;
            }
            if ($thumbexists && !$disable_direct_thumbs_access && !$show_clipped_images) {
                $size = getimagesize($thumb);
                $sizeX = $size[0];
                $sizeY = $size[1];
            } else {
                $sizeX = $thumb_pic_size;
                $sizeY = $thumb_pic_size;
            }
            // here we calculate the point how much we have to jump the cmotion gallery forward
            if ($i < $current) {
                $imgtwg_offset += $sizeX + $space;
            }
            if ($i == $current) { // the last image!
                // echo floor((120 - $sizeX) /2);
                $imgtwg_offset += floor(($sizeX / 2) - ($size1stX / 2));
            }
            // echo $imgtwg_offset;
            loadXMLFiles($twg_album);
            $beschreibung = getBeschreibung($imagelist[$i], $werte, $index);
            $beschreibungtext = $beschreibung;
            if (($beschreibung <> " ") && ($beschreibung <> "")) {
                $beschreibunga = php_to_all_html_chars(escapeHochkomma($beschreibung));
                $beschreibung = "title='" . $beschreibunga . "'";
                $beschreibung .= " alt='" . $beschreibunga . "'";
            } else {
                $beschreibung = " alt='' ";
            }

            if (($i > ($act_nr - $preloadrange)) && ($i < ($act_nr + $preloadrange))) {
                if ($thumbexists && !$disable_direct_thumbs_access) {
                    // TODO: check if encode is needed !!!!!
                    $src = create_cache_file(cacheencode($thumbimage), $extension_thumb, true, $twg_seo_active);
                } else {
                    $ccomment = "";
                    $ccount = getKommentarCount($imagelist[$i], $twg_album, $kwerte, $kindex);
                    if ($ccount > 0) {
                        $ccomment = "&twg_comment=" . $ccount; // this is done to cut of the upper right corner to indicate a comment!
                    }
                    $src = $install_dir_view . 'image.php?twg_album=' . $album_enc . '&amp;twg_type=thumb&amp;twg_show=' . $imagelist[$i] . $ccomment;
                }

                if ($show_clipped_images) {
                    $html_size = ' width=' . $sizeX . ' height=' . $sizeY . ' ';
                } else {
                    $html_size = "";
                }

                if ($show_thumbs_as_text) {
                    echo '<a onFocus="if(this.blur)this.blur()" href="javascript:void(' . $i . ')" onclick="javascript:changeContent(\'' . $i . '\');return false;">' . $beschreibungtext . '</a>';
                    if (($i < count($imagelist) - 1) && ($i < $stopgal - 1)) {
                        echo ' | ';
                    }
                } else {
                    echo '<a onFocus="if(this.blur)this.blur()" href="javascript:void(' . $i . ')" onclick="javascript:changeContent(\'' . $i . '\');return false;"><img align="middle" name="name' . $i . '" ' . $beschreibung . $html_size . ' src="' . $src . '" border=1 ></a><img src="' . $install_dir_view . 'buttons/1x1.gif" alt="" align="middle" width=6 height=1 >';
                }
            } else {
                echo '<a onFocus="if(this.blur)this.blur()" href="javascript:void(' . $i . ')" onclick="javascript:changeContent(\'' . $i . '\');return false;" ><img src="' . $install_dir . 'buttons/1x1.gif" alt="" name=name' . $i . ' ' . $beschreibung . ' align="middle" width=' . $sizeX . ' height=' . $sizeY . ' ></a><img src="' . $install_dir_view . 'buttons/1x1.gif" alt="" align="middle" width=6 height=1 >';
            }
        } // for
        // now we create the Array with the imagesources we have to replace!
    } // end if ($show_strip) {
    echo '<script type="text/javascript">';
    echo 'var imagenames=new Array();';
    echo 'var thumbs=new Array();';
    echo 'var small=new Array();';
    echo 'var thumbstwg_offset=new Array();';
    $sum = 0;
    for ($i = $startgal; (($i < count($imagelist)) && ($i < $stopgal)); $i++) {
        $ccomment = "";
        loadXMLFiles($twg_album);
        $ccount = getKommentarCount($imagelist[$i], $twg_album, $kwerte, $kindex);
        if ($ccount > 0) {
            $ccomment = "&twg_comment=" . $ccount; // this is done to cut of the upper right corner to indicate a comment!
        }
        echo "thumbs[" . $i . "] = 'twg_album=" . $album_enc . $ccomment . $twg_standalonejs . "&twg_show=" . $imagelist[$i] . "';\n";

        $thumbimage = create_thumb_image($twg_album, $imagelist[$i]);
        $thumb = create_cache_file($thumbimage, $extension_small);

        if (file_exists($thumb)) {
            echo "small[" . $i . "] = encodeURI('" . $install_dir_view . $thumb . "');\n";
        }

        if ($video_player == "FLASH" || $video_player == "GOOGLE") {
            echo "imagenames[" . $i . "] = '" . str_replace("'", "\'", str_replace("_S_", "/", removeExtension(urldecode($imagelist[$i])))) . "';\n";
        } else if ($video_player == "WMP" && $video_flash_site != "http://") {
            echo "imagenames[" . $i . "] = '" . str_replace("'", "\'", getMovieName($twg_album, urldecode($imagelist[$i]))) . "';\n";
        } else if ($video_player == "WMP" && $video_flash_site == "http://") {
            echo "imagenames[" . $i . "] = '" . str_replace("'", "\'", urldecode(removeExtension(replace_url_chars($imagelist[$i])))) . "';\n";
        } else if ($video_player == "HTML5") {
            echo "imagenames[" . $i . "] = '" . str_replace("'", "\'", $imagelist[$i]) . "';\n";
        } else {
            echo "imagenames[" . $i . "] = '" . str_replace("'", "\'", urldecode(removeExtension(replace_url_chars($imagelist[$i])))) . "';\n";
        }
        $thumb = create_cache_file($thumbimage, $extension_thumb);
        if (file_exists($thumb) && !$disable_direct_thumbs_access && !$show_clipped_images) {
            $size = getimagesize($thumb);
            $sizeX = $size[0];
        } else {
            $sizeX = $thumb_pic_size;
        }
        if ($show_strip) {
            $twg_offset = floor(($sizeX / 2) - ($size1stX / 2));
            echo "thumbstwg_offset[" . $i . "] = " . ($sum + $twg_offset) . ";\n"; // 1st sum has to be the startpoint!!!
            $sum = $sum + $sizeX + $space;
        }
    }

    echo '</script>';
    // we insert the script here because otherwise the function os not known sometimes
    echo '<script type="text/javascript">

// set in twg_image.js for lightbox
lastpos = ' . $current . ';
var image_fade = ' . $image_page_fade . ';
var image_fade_orig = ' . $image_page_fade . ';
var reload = 0;
var img;
var newData = "not set";
var loadedData = false;
var ready = true;
var hashinit = false;
var oldName = "'.removeExtension($entry).'";

function load_img(srcnum, type)
{
   img=new Image(); /* neues Bild-Objekt anlegen */
   if (small[srcnum] != null) {
     img.src = small[srcnum];
   } else {
     img.src="' . $install_dir_view . 'image.php?" + thumbs[srcnum] + type; // + "&id=" + lastpos; /* Bild laden lassen */
   }
}

function pre_load_img(srcnum, type) {
  if (srcnum >= 0 && srcnum < ' . count($imagelist) . ') {
     if (small[srcnum] != null) {
       MM_preloadImages( small[srcnum] );
     } else if (thumbs[srcnum] != null) {
       MM_preloadImages("' . $install_dir_view . 'image.php?" + thumbs[srcnum] + type );
     }
   }
}

pre_load_img(' . ($current + 1) . ', "&twg_type=small");

var  myConn = null;   
function load_data(pos) {
  if (!myConn) { myConn = new XHConn(); } // we reuse the XHC!
  if (!myConn) alert("XMLHTTP not available. Try a newer/better browser.");
  var fnWhenDone = function (oXML) { newData = oXML.responseText; loadedData = true;};
  myConn.connect("' . $install_dir_view . 'image.php?" + thumbs[pos] + "&twg_xmlhttp=d", fnWhenDone);
}

function startPostLoadImages() {
';
    if ($show_strip) {
        for ($i = $startgal; (($i < count($imagelist)) && ($i < $stopgal)); $i++) {
            $thumbimage = create_thumb_image($twg_album, $imagelist[$i]);
            $thumb = create_cache_file($thumbimage, $extension_thumb);
            if (($i <= ($act_nr - $preloadrange)) || ($i >= ($act_nr + $preloadrange))) {
                if (file_exists($thumb) && !$disable_direct_thumbs_access) {
                    echo "document.images.name" . $i . ".src = '" . create_cache_file(cacheencode($thumbimage), $extension_thumb, true, $twg_seo_active) . "';\n";
                } else {
                    $ccomment = "";
                    $ccount = getKommentarCount($imagelist[$i], $twg_album, $kwerte, $kindex);
                    if ($ccount > 0) {
                        $ccomment = "&twg_comment=" . $ccount; // this is done to cut of the upper right corner to indicate a comment!
                    }
                    echo "document.images.name" . $i . ".src = '" . $install_dir_view . "image.php?twg_album=" . $album_enc . "&amp;twg_type=thumb&amp;twg_show=" . $imagelist[$i] . $ccomment . "';\n";
                }
            }
        }
    }
    echo '}';
    echo'
function startpreLoadImages() { ';
    if ($show_strip) {
        echo 'MM_preloadImages(';
        for ($i = $stopgal; (($i < count($imagelist)) && ($i < $stopgal + $cmotion_gallery_limit)); $i++) {
            $thumbimage = create_thumb_image($twg_album, $imagelist[$i]);
            $thumb = create_cache_file($thumbimage, $extension_thumb);
            if (file_exists($thumb) && !$disable_direct_thumbs_access) {
                echo "'" . create_cache_file(cacheencode($thumbimage), $extension_thumb, true, $twg_seo_active) . "',";
            } else {
                $ccomment = "";
                $ccount = getKommentarCount($imagelist[$i], $twg_album, $kwerte, $kindex);
                if ($ccount > 0) {
                    $ccomment = "&twg_comment=" . $ccount; // this is done to cut of the upper right corner to indicate a comment!
                }
                echo "'" . $install_dir_view . "image.php?twg_album=" . $album_enc . "&twg_type=thumb&twg_show=" . $imagelist[$i] . $ccomment . "',";
            }
        }
        echo "'');";
    }
    echo "
}";

    echo'
var centerStart = 0;
function centerGal() {
';
    if ($show_strip) {
        echo '
	 if (centerStart++ == 0) {
			window.setTimeout("startPostLoadImages()",2000);';
echo 'window.setTimeout("startpreLoadImages()",4000);
			window.setTimeout("centerGalLater()",200);

	 }';
    }
    echo '
}

var centerpos = ' . ($imgtwg_offset + 2) . ';

function centerGalLater() {
';
    if ($default_big_navigation == "FLASH" && $displayFlash) {
        echo '
  if (lastpos) {
    mov = getMovieName("myMovie"); 
    if (mov && mov.callSetPosition) {
      mov.callSetPosition(lastpos+1)
    } 
  }
  ';
    }
    if ($show_strip) {
        echo '
			if (window.isLoaded) {
			if (!isLoaded()) { // not initialized yet!
				window.setTimeout("centerGalLater()",500);
			}
			var mm = getMovement();
			enableMovement();
			}
			setPos(centerpos);
			if (window.disableMovement) {
				if (!mm) {
					disableMovement();
				}
			}';
    }
    echo '
}

</script>
';
    if ($show_strip) {
        $thumbimage = str_replace("/", "_", $twg_album) . "_" . $imagelist[count($imagelist) - 1];
        $thumb = create_cache_file($thumbimage, $extension_thumb);

        if (file_exists($thumb) && !$disable_direct_thumbs_access && !$show_clipped_images) {
            $size1st = getimagesize($thumb);
            $size1stX = $size1st[0];
        } else {
            $size1stX = $thumb_pic_size;
        }
        // firefox add 2 pixel per image because it dows not calculate
        $firefox_fix = 0;
        if ($isns) {
            $firefox_fix = 2 * ($num_twg_shown_images - 1);
        }
        echo '<img src="' . $install_dir_view . 'buttons/1x1.gif" alt="" align=middle width=6 height=1>';
        if ($stopgal < count($imagelist)) {
            $hrefnext = getScriptName() . "?twg_album=" . $album_enc . "&amp;twg_show=" . $imagelist[$stopgal] . "&amp;twg_dir=next" . $twg_standalone;
            $hrefnextjs = getScriptName() . "?twg_album=" . $album_enc . "&twg_show=" . $imagelist[$stopgal] . "&twg_dir=next" . $twg_standalonejs;
            printf("<a href='%s'><img class='twg_buttons menu_right_gif' style='border: 0px;' src='%sbuttons/1x1.gif' alt='%s' align='middle' title='%s' width='22' ></a>", tfu_seo_rewrite_url($hrefnext), $install_dir_view, $lang_forward, $lang_forward);
        } else {
            echo '<img src="' . $install_dir_view . 'buttons/1x1.gif" width=22 height=1 alt="" >';
            $hrefnext = "#";
            $hrefnextjs = "#";
        }
        if (!$show_thumbs_as_text) {
            echo '<img id="lastimage" align=middle src="' . $install_dir_view . 'buttons/1x1.gif" alt="" width=' . ((($thumb_pic_size - $size1stX) / 2) + ($thumb_pic_size * $numberofpics) - (39 - ($numberofpics * 8)) + $firefox_fix) . ' height=1 >';
        }
        echo '</span>';
        echo '</div></div>';
    }
    // thin function is need after all the others because we need some content from the php function before!
    echo '<script type="text/javascript">

var lastTimeout = "";
function changeContent(pos) { 
    ';
    if ($default_big_navigation == "FLASH" && $displayFlash) {
       echo '    
         if (!hashinit) {
            var mov = getMovieName("myMovie");
            if (mov && mov.callSetPosition) {
              mov.callSetPosition(pos+1);
            }
          }
          ';
    }
    if (!$autodetect_noscoll) {
        echo '
	 centerpos = thumbstwg_offset[parseInt(pos)];
	';
    } else {
        echo '
	if (thumbstwg_offset.length > ' . (($numberofpics * 2) + 1) . ') {
	  centerpos = thumbstwg_offset[parseInt(pos)];
	}
	';
    }
    echo '
	reload=0;
	var retvalue = changeContentWait(pos);
	
  if (retvalue == 0 || !hashinit) {
    return;
  } else {
    return retvalue;
  }	
}

function changeContentWaitLast() {
   return changeContentWait(lastpos);
}

function showNext() {
   if (lastpos < ' . count($imagelist) . ') {
     changeContent(lastpos+1);
   }
}

function showLast() {
  if (lastpos > 0) {
    changeContent(lastpos-1);
  }
}

function changeContentWait(poss) {
 var pos=parseInt(poss);
 var changeinfo = hideAll();
 if (pos >= ' . count($imagelist) . ') { return -1; } ';
    if ($show_strip) {
        echo '
   if (pos < ' . $startgal . ') {  window.location="' . $hreflastjs . '"; return; }
   if ( pos > ' . ($stopgal - 1) . ') {  window.location="' . $hrefnextjs . '"; return;  }
  ';
    }
    
    if (false) { // TODO check why $use_resized_background
        echo '
if (isScrollDisabled()) {
  location.reload(); return -1;
};
';
    }

    echo '
 ready = false;
 lastpos = pos;
 var box = document.getElementById("CaptionBox");
 if (reload == 0) {
    load_data(pos);
    ';
    echo 'load_img(pos, "&twg_type=small");
 } else if (reload==5) {';
    if ($show_captions) {
        echo ' if (box) { box.innerHTML = "&nbsp;' . $lang_loading . '&nbsp;"; } ';
    }
    echo '
 }
 reload++;
 ';
    echo '
 if ((img.complete) && loadedData) {
   location.hash = pos;
  
    var dataArray = newData.split("|___|");
    var newCaption = dataArray[0];
   	var newComment = dataArray[1];
   	var newView =    dataArray[2];
  	var newDirect =  dataArray[3];
	  var newRating =  dataArray[4];
	  var newLeft =    dataArray[5];
	  var newRight =   dataArray[6];
	
    var new_x = img.width;
    var new_y = img.height;
    if (document.images.defaultslide) {
        if (image_fade != 1) {
          $(\'#defaultslide\').fadeTo(\'fast\', image_fade , function() {
            document.images.defaultslide.src=img.src;
            $(\'#defaultslide\').fadeTo(\'normal\', 1, function() {            
               $(\'#defaultslide\').removeAttr("style");
             } );  
          } );
        } else {
          document.images.defaultslide.src=img.src;
          $("#defaultslide").show(); 
          image_fade = image_fade_orig; 
        }               
';        

    if ($safari) { // otherwise the images do not scale
        echo'
	   document.images.defaultslide.width = new_x;
	   document.images.defaultslide.height = new_y;
   ';
    }
    echo '
    }
    
    // we test if we have correct values to change otherwise we return!
    if (typeof newComment == "undefined") {
      return -1;
    }
    
    if (document.getElementById("adefaultslide")) {
     ';

    $linkfilename = $basedir . "/" . $twg_album . "/link.txt";
    if (file_exists($linkfilename)) { // link file exists !!!
        // we don't change the link - if is fine because it links to another website !
    } else if ($enable_download) {
        $zipfile = $basedir . "/" . $twg_album . "/" . str_replace("/", "_", $twg_album) . ".zip";
        if ($enable_download_as_zip && file_exists($zipfile) && $twg_download != 'single') {
            echo '  document.getElementById("adefaultslide").href = "' . getTWGHttpRoot($install_dir) . 'i_frames/i_downloadmanager.php?" + thumbs[pos];';
        } else { // if ($enable_direct_download) - done in image.php!
            echo 'if (newDirect != "false") { ';
            $dl_root = ($video_player == 'FLV') ? '' : getTWGHttpRoot($install_dir);
            echo '  document.getElementById("adefaultslide").href = "' . $dl_root . '" + newDirect;';
            echo '} else {';
            if ($open_in_maximized_view) {
                echo '  document.getElementById("adefaultslide").href = "' . getTWGHttpRoot($install_dir) . 'index.php?" + thumbs[pos] + "&twg_zoom=TRUE";';
            } else {
                echo '  document.getElementById("adefaultslide").href = "' . getTWGHttpRoot($install_dir) . 'image.php?" + thumbs[pos];';
            }
            echo '} ';
        }
    }
    echo "}
    ";
    //
    // Windows media Player!
    //
    // create the new playlist or load the new video!!
    if ($video_player == "WMP") {
        echo "
      if (document.getElementById('videoBox')) { ";
        if ($video_flash_site != "http://" || $video_flash_site != "mms://") {
            $prefix = escapeHochkommaSlideshow(fixUrl(getTWGHttpRoot($install_dir) . $basedir . "/" . $twg_album . "/"));
        } else {
            $prefix = $video_flash_site;
        }
        if ($video_autostart) {
            $as = "true";
        } else {
            $as = "false";
        }
        echo "setWMP('" . $prefix . "' + imagenames[pos]," . $video_size_x . "," . $video_size_y . ",'" . $as . "' );";
        echo "}";
    }
    //
    // Divx player
    //
    else if ($video_player == "DIVX") {
        echo "
      if (document.getElementById('videoDivx')) {
        prefix =  '" . getTWGHttpRoot($install_dir) . "';
        url= newDirect;
        url= prefix + url;
        url = fixUrl(url);
        
        var plugin; if(navigator.userAgent.indexOf('MSIE') != -1) { plugin = document.getElementById('ie_plugin'); } else { plugin = document.getElementById('np_plugin'); }
        plugin.Open(url);
      } ";
        if ($video_autostart) {
            echo " plugin.Play();";
        }

    }
    //
    //  Quicktime player
    //
    else if ($video_player == "QT") {
        if ($video_autostart) {
            $auto_param = "true";
        } else {
            $auto_param = "false";
        }
        echo "
      if (document.getElementById('videoQT')) {
        prefix =  '" . getTWGHttpRoot($install_dir) . "';
        url= newDirect;
        url= prefix + url;
        url = fixUrl(url);     
        loadQT(url , '" . $video_size_x . "', '" . $video_size_y . "', '" . $auto_param . "');
     } ";

        //
        // Flash player
        //
    } else if ($video_player == "FLASH") {
        $ad = "";
        if ($video_autostart) {
            $ad = $video_autostart_parameter;
        }
        echo "
      if (document.getElementById('videoFlash')) {
        url= '" . $video_flash_site . "' + removePrefix(imagenames[pos]) + '" . $ad . "';";
        echo '
					var so = new SWFObject(url, "ie_plugin", "' . $video_size_x . '", "' . $video_size_y . '", "6");
					so.addParam("wmode","transparent");
					so.addParam("allowFullscreen","true");
					so.write("flashcontent");
        ';
        echo '}';
    }
     //
     // IFRAME
     //
     else if ($video_player == "IFRAME") {
        $ad = "";
        if ($video_autostart) {
            $ad = $video_autostart_parameter;
        }
        echo '
      if (document.getElementById("videoIframe")) {
          var url= "' . $video_flash_site . '" + removePrefix(imagenames[pos]) + "' . $ad . '";
          var iframe_content =  "<iframe width=' . $video_size_x . ' height=' . $video_size_y . ' src=\"" + url + "\" frameborder=0 allowfullscreen></iframe>";
          $("#videoIframe").html(iframe_content);
        }';
     }
    //
    // Google
    //
    else if ($video_player == "GOOGLE") {
        echo "
      if (document.getElementById('videoGoogle')) { ";
        $auto_param = "";
        if ($video_autostart) {
            $auto_param = "&autoPlay=true";
        }
        echo "
        url= '" . $video_flash_site . "' + removePrefix(imagenames[pos]);";
        echo '
						var so = new SWFObject(url, "VideoPlayback", "' . $video_size_x . '", "' . $video_size_y . '", "6");
						so.addParam("scale","noScale");
						so.addParam("wmode","transparent");
						so.addParam("salign","TL");
						so.addParam("allowFullscreen","true");
						so.addParam("FlashVars","playerMode=embedded' . $auto_param . '");
						so.write("flashcontent");
        ';
        echo '}';
    }
    //
    // mp3
    //
    else if ($video_player == "MP3") {
        echo "
      if (document.getElementById('videoMP3')) {
         var so = new SWFObject('" . $playerjs . "', 'movie', '380', '100', '6');
				 so.addParam('wmode', 'transparent');
				 so.write('videoMP3');
      }
    ";
        //
        // FLV-Player
        //
    } else if ($video_player == "FLV") {
        if (!isset($video_flv_buffer)) { // new variable and therefore not set be older implementations.
            $video_flv_buffer = 2;
        }
        if (!isset($video_flv_stretching)) { // new variable and therefore not set be older implementations.
            $video_flv_stretching = "uniform";
        }
        $video_autostart_str = ($video_autostart) ? "true" : "false";
        $player = $install_dir_view . "html/mediaplayer.swf";
        // we add the preview image
        $video_player = "DIVX";
        $image_root = getTWGHttpRoot($install_dir);
        $video_player = "FLV";
        echo "
	      if (document.getElementById('videoFLV')) {
	         prefix =  '" . getTWGHttpRoot($install_dir) . "';
	         imgprefix =  '" . $image_root . "';
             url= newDirect;
             imageurl = imgprefix + exchangeExtension(url,'jpg'); // only flv and mp4 are supported - therefore I simply replace the extension with .jpg 
             url= fixUrl(prefix + url);
             preview = fixUrl(imageurl);   
       ";
        echo '
	     var so = new SWFObject("' . $player . '", "ie_plugin", "' . $video_size_x . '", "' . $video_size_y . '", "6");
			 so.addParam("allowfullscreen","true");
       so.addParam("allowscriptaccess","sameDomain"); 
       so.addVariable("type", "video");
       so.addVariable("file",url); 
       so.addVariable("image",preview);
       so.addVariable("autostart","' . $video_autostart_str . '");
       so.addVariable("bufferlength","' . $video_flv_buffer . '");
       so.addVariable("stretching", "' . $video_flv_stretching . '");
    ';
        if ($show_flv_player_below_iframe) {
            echo 'so.addParam("wmode","transparent");';
        } else {
            echo 'so.addParam("wmode","opaque");';
        }
        echo '
          so.write("flashcontent");
				  }';
        //
        // HTML5 Videos
        //
    } else if ($video_player == "HTML5") {
         $auto_param = ($video_autostart) ? '&autostart=true' : '';
        echo '
      if (document.getElementById(\'videoHtml5\')) {
          var url= "' . $install_dir_view . 'i_frames/i_html5video.php?twg_album=' . $album_enc . $auto_param.'&twg_show=" + imagenames[pos];
          var iframe_content =  "<iframe width=' . $video_size_x . ' height=' . $video_size_y . ' src=" + url + " frameborder=0 allowfullscreen transparency=\"true\"></iframe>";
          jQuery("#videoHtml5").html(iframe_content);
      }
    ';
        //
        // FLV-Player
        //
    } else if ($video_player == "FLV3") {
        $movie = $install_dir . "html/mediaplayer3.swf?file=";
        $auto_param = ($video_autostart) ? "&autostart=true" : "&autostart=false";
        echo "
	      if (document.getElementById('videoFLV')) {
	         prefix =  '" . getTWGHttpRoot($install_dir) . "';
				   url= newDirect;
				   url= prefix + url;
           url = '" . $movie . "' + fixUrl(url);";
        echo '
				var so = new SWFObject(url, "ie_plugin", "' . $video_size_x . '", "' . $video_size_y . '", "6");
			  so.addParam("FlashVars","' . $auto_param . '&height=' . $video_size_y . '&width=' . $video_size_x . '");
         so.addParam("allowfullscreen","true");
         so.addParam("overstretch","true");';
        if ($show_flv_player_below_iframe) {
            echo 'so.addParam("wmode","transparent");';
        }
        echo '
				  so.write("flashcontent");
	        }';
    }

    if ($show_captions) {
        echo 'if (newCaption == null ) { newCaption = ""; }';
        echo 'if (box) { box.innerHTML = "&nbsp;" + newCaption + "&nbsp;"; }';
        echo 'if (document.getElementById("adefaultslide")) document.getElementById("adefaultslide").title=newCaption;';
    }
    echo ' if (document.getElementById("imagecounter")) document.getElementById("imagecounter").innerHTML = (parseInt(pos) + 1);';

    if ($show_count_views) {
        echo ' if (document.getElementById("viewcounter")) document.getElementById("viewcounter").innerHTML = newView;';
    }
    echo' if (document.getElementById("start_slideshow")) document.getElementById("start_slideshow").href = "' . getScriptName() . '?" + thumbs[pos] +  "&twg_slideshow=true' . $twg_standalonejs . '";';

    if ($show_comments) {
        // fix for some languages - dont know why this return is in front!
        echo 'if (escape(newComment).substring(0,6) == "%0D%0A") {
                newComment = newComment.substring(2, newComment.length);
                }
                var numComments = newComment.substring(1,10);
                ';

        echo 'if (newComment.length==10){
                var newComments = "";
              } else { 
		            var newComments = newComment.substring(10, newComment.length-1);
		      }';
        echo 'if (newComments.length == 1) { newComments = "" } ' . "\n";
        if (!$show_comments_in_layer) {
            echo 'if (document.getElementById("kommentartd")) document.getElementById("kommentartd").innerHTML = newComments;';
        } else {
            if ($show_enter_comment_at_bottom) {
                echo' document.getElementById("kommentarenter").href = "' . $install_dir_view . 'i_frames/i_kommentar.php?" + thumbs[pos] +  "' . $twg_standalonejs . '";' . "\n";
                // the number of the comments !
                if ($show_number_of_comments) {
                    echo 'document.getElementById("kommentarnumber").innerHTML = numComments.replace(/\s*/, "") ;' . "\n";
                }
            }
        }
        if ($show_comments_menue) {
            echo 'if  (document.getElementById("commentcount")) document.getElementById("commentcount").innerHTML = numComments.replace(/\s*/, "") ;';
            echo' if  (document.getElementById("i_comment")) document.getElementById("i_comment").href = "' . $install_dir_view . 'i_frames/i_kommentar.php?" + thumbs[pos] +  "' . $twg_standalonejs . '";';
        }
    }
    if ($show_enhanced_file_infos) {
        echo' document.getElementById("i_info").href = "' . $install_dir_view . 'i_frames/i_info.php?" + thumbs[pos] +  "' . $twg_standalonejs . '";';
        echo' if (changeinfo) parent["details"].location.href = "' . $install_dir_view . 'i_frames/i_info.php?" + thumbs[pos] +  "' . $twg_standalonejs . '";';
    }
    if ($show_image_rating) {
        // echo' document.getElementById("i_rate").href = "' . $install_dir . 'i_frames/i_rate.php?" + thumbs[pos] +  "' . $twg_standalonejs . '";';
        // new rating
        echo' if (document.getElementById("ratinglink1")) document.getElementById("ratinglink1").href = "' . $install_dir_view . 'i_frames/i_rate.php?" + thumbs[pos] +  "' . $twg_standalonejs . '&twg_vote=1";';
        echo' if (document.getElementById("ratinglink2")) document.getElementById("ratinglink2").href = "' . $install_dir_view . 'i_frames/i_rate.php?" + thumbs[pos] +  "' . $twg_standalonejs . '&twg_vote=2";';
        echo' if (document.getElementById("ratinglink3")) document.getElementById("ratinglink3").href = "' . $install_dir_view . 'i_frames/i_rate.php?" + thumbs[pos] +  "' . $twg_standalonejs . '&twg_vote=3";';
        echo' if (document.getElementById("ratinglink4")) document.getElementById("ratinglink4").href = "' . $install_dir_view . 'i_frames/i_rate.php?" + thumbs[pos] +  "' . $twg_standalonejs . '&twg_vote=4";';
        echo' if (document.getElementById("ratinglink5")) document.getElementById("ratinglink5").href = "' . $install_dir_view . 'i_frames/i_rate.php?" + thumbs[pos] +  "' . $twg_standalonejs . '&twg_vote=5";';
    }

    if ($show_tags && $show_login && $login_edit) {
        echo' document.getElementById("i_tags").href = "' . $install_dir_view . 'i_frames/i_tags.php?" + thumbs[pos] +  "' . $twg_standalonejs . '";';
    }

    if ($show_image_rating && ($image_rating_position != "menu")) {
        // echo 'if (document.getElementById("img_rating")) document.getElementById("img_rating").innerHTML = newRating;';
        echo' if (document.getElementById("ratingcur")) document.getElementById("ratingcur").style.width=newRating + "%"; ';

    }
    if ($show_optionen) {
        echo' if (document.getElementById("i_options")) document.getElementById("i_options").href = "' . $install_dir_view . 'i_frames/i_optionen.php?" + thumbs[pos] +  "' . $twg_standalonejs . '";';
    }
    if ($twg_rot_available && $show_rotation_buttons && ($show_strip || $displayFlash)) {

        // $ccw = (($twg_rot-90) >= 0) ? ($twg_rot-90) : (360-90);
        // $cw = $twg_rot + 90;
        $timestamp = "&twg_zs=" . time();
        echo 'document.getElementById("twg_rotleft").href = "' . getScriptName() . '?" + thumbs[pos] +  "&twg_rot=90' . $twg_standalonejs . $timestamp . '";
			  document.getElementById("twg_rotright").href = "' . getScriptName() . '?" + thumbs[pos] +  "&twg_rot=270' . $twg_standalonejs . $timestamp . '";';
    }
    if ($login_edit) {
        echo 'if (document.getElementById("i_caption")) document.getElementById("i_caption").href = "' . $install_dir_view . 'i_frames/i_titel.php?" + thumbs[pos] +  "' . $twg_standalonejs . '";
		      if (document.getElementById("logoutlink")) document.getElementById("logoutlink").href = "' . $install_dir_view . 'i_frames/i_login.php?" + thumbs[pos] +  "&twg_logout=true' . $twg_standalone . '";
              ';
    } else {
        echo 'if (document.getElementById("loginlink")) document.getElementById("loginlink").href = "' . $install_dir_view . 'i_frames/i_login.php?" + thumbs[pos] +  "' . $twg_standalonejs . '";';
    }
    echo 'reload=0;	';
    if ($dynamic_image_txt) {
        echo '
	    if (document.getElementById("image_top")) document.getElementById("image_top").innerHTML = newLeft;
	    if (document.getElementById("image_left")) document.getElementById("image_left").innerHTML = newLeft;
	    if (document.getElementById("image_right")) document.getElementById("image_right").innerHTML = newRight;
	    if (document.getElementById("image_bottom")) document.getElementById("image_bottom").innerHTML = newLeft;
	    
	    for(var i=0; i<twg_addon_callbacks.length; i++) {
				eval(twg_addon_callbacks[i]);
		  }
	 ';
    }
    echo '
      newCaption = unescapeHTML(newCaption);
      if (newCaption == "") {
      newCaption = imagenames[pos];
      }
      document.title = "' . $browser_title_prefix . ' - " + newCaption.replace(/\&nbsp;<br\>\&nbsp;/, " - ");
      if (pos==0) {
         if (document.getElementById("wiibackbutton")) document.getElementById("wiibackbutton").style.visibility = "hidden";
         if (document.getElementById("backbuttonbig")) document.getElementById("backbuttonbig").style.visibility = "hidden";
         document.getElementById("backbutton").style.visibility = "hidden";
      } else {
         if (document.getElementById("wiibackbutton")) document.getElementById("wiibackbutton").style.visibility = "visible";
         if (document.getElementById("backbuttonbig")) document.getElementById("backbuttonbig").style.visibility = "visible";
         document.getElementById("backbutton").style.visibility = "visible";
      }
      if (pos >= ' . (count($imagelist) - 1) . ') {
			    if (document.getElementById("wiinextbutton")) document.getElementById("wiinextbutton").style.visibility = "hidden";
          if (document.getElementById("nextbuttonbig")) document.getElementById("nextbuttonbig").style.visibility = "hidden";
          document.getElementById("nextbutton").style.visibility = "hidden";
			     } else {
					 if (pos > ' . ($stopgal - 1) . ') {';
    if ($show_strip) {
        echo '
							 window.location="' . $hrefnextjs . '"; return 0;
							 ';
    }
    echo '
						} else {
				    	 if (document.getElementById("wiinextbutton")) document.getElementById("wiinextbutton").style.visibility = "visible";
               document.getElementById("nextbutton").style.visibility = "visible";
               if (document.getElementById("nextbuttonbig")) document.getElementById("nextbuttonbig").style.visibility = "visible";
            }
      }';
    if ($use_nonscrolling_dhtml) {
        echo 'if (window.centerGalLater) centerGalLater()';
    }
    echo '

      // we load the next and last  image!
      pre_load_img(pos+1, "&twg_type=small");
      pre_load_img(pos-1, "&twg_type=small");

     ';
    if ($use_nonscrolling_dhtml) {
        echo 'pre_load_img(pos+2, "&twg_type=small");
            pre_load_img(pos-2, "&twg_type=small");
      ';
    }
    echo '
		  loadedData = false;
	    ready = true;
   } else {
      if (reload>200) { // 20 sekunden!
        reload = 0;
        window.location = "' . getScriptName() . '?" + thumbs[pos] + "' . $twg_standalonejs . '";
      }
      window.setTimeout("changeContentWaitLast()",100);
      return 0;
   }
   return 0
}

';

    if ($autodetect_noscoll && $show_strip) {
        echo '
if (thumbstwg_offset.length <= ' . (($numberofpics * 2) + 1) . ') {
  index = ((thumbstwg_offset.length-1)/2);
	if (index < 0) index = 0;
  centerpos = (thumbstwg_offset[Math.ceil(index)] + thumbstwg_offset[Math.floor(index)])/2;
  disableMovement();
}
';
    }
    if ($show_strip) {
        echo '
      window.setTimeout("centerGal()",200); ';
      }
      echo '
      // $(document).ready(function() {
        if (location.hash != "" ) {
          pos = location.hash.substring(1);
          if (!isNaN(pos)) {
            // hide original image!
            image_fade = 1;
            $("#defaultslide").hide();
            hashinit = true;
            if (changeContent(pos) == -1) {
                // image not changed - show old one 
                $("#defaultslide").show();
            } 
            hashinit = false;  
          }
        }  
      // });
      ';
      echo '</script>';
}
?>