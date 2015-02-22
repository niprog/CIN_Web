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
// start of top row
function writeRootLink($dir) // prints a home button if the root.txt is not empty
{
    global $lang_back_link, $install_dir, $icon_set, $install_dir_view;
    if (hasRootLink($dir)) {
        $rootlink = getRootLink($dir);
        if (substr($rootlink, 0, 7) == "http://") { // new home dir!
            echo "<a target='_top' href='";
            echo $rootlink;
            echo "' >";
            if (!isset($lang_back_link)) {
                echo "<img class='twg_buttons menu_home_gif' style='vertical-align: middle;' alt='' src='" . $install_dir_view . "buttons/1x1.gif'>&nbsp;|";
            } else {
                echo $lang_back_link;
            }
            echo "</a>";
            echo "  ";
        }
        return true;
    }
    return false;
}

$has_element_before = false;
if ($input_invalid) {
    echo '<td class="topnavleft' . ($hide_top ? ' hide' : '') . '">&nbsp;</td><td colspan=2 class="topnavright' . ($hide_top ? ' hide' : '') . '" nowrap>&nbsp;</td>';
} else {
    // we create the language section
    $languagedata = '';
    $languagediv = '';
    $languagelist = get_language_list();
    if (!$session_available) {
        $languagelist = Array($default_language);
    }
    if (count($languagelist) > 1 && $enable_language_selector) {
        if ($show_languages_as_dropdown) {
            $languagedata = "<img width='16' height='10' class='lang_sprites lang_" . $default_language . " twg_lock' title='" . $lang_text_array[$default_language] . "'  alt='" . $lang_text_array[$default_language] . "' src='" . $install_dir_view . "buttons/1x1.gif' onclick='javascript:show_lang_div(10);'><img id='langpixel' alt='' border='1' class='twg_lock' width='1' height='1' src='" . $install_dir_view . "buttons/1x1.gif'><img width='1' height='1' alt='' class='twg_sprites select_gif twg_lock' src='" . $install_dir_view . "buttons/1x1.gif' onclick='javascript:show_lang_div(10); return true;'>";
            $languagediv .= '<div id="twg_langdiv" class="twg_langdiv" style="right:' . ($lang_xpos_lang_dropdown) . 'px;">';
            $languagediv .= '<table class="twg" summary="" align="center" width="22" border="0" cellspacing="1" cellpadding="1">';
        }
        for ($current = 0, $i = 0; $i < count($languagelist); ++$i) {
            $lang = $languagelist[$i];
            if ($show_languages_as_dropdown) {
                $languagediv .= '<tr onMouseOver="this.className=\'twg_hoverflag\'" onMouseOut="this.className=\'twg_unhoverflag\'">';
                $languagediv .= "<td width='18' align='center'><a rel='noindex,nofollow' href='" . tfu_seo_rewrite_url(getScriptName() . "?" . $album_param . "twg_lang=" . $lang . $twg_standalone) . "'  ><img width='16' height='10' class='lang_sprites lang_" . $lang . "' title='" . $lang_text_array[$lang] . "'  alt='" . $lang_text_array[$lang] . "' src='" . $install_dir_view . "buttons/1x1.gif' ></a></td>";
                $languagediv .= '</tr>';
                //
                // $languagediv .= '<div class="lang_sprites lang_ar"></div>';
            } else {
                $languagedata .= "<a rel='noindex,nofollow' href='" . tfu_seo_rewrite_url(getScriptName() . "?" . $album_param . "twg_lang=" . $lang . $twg_standalone) . "'  ><img width='16' height='10' class='lang_sprites lang_" . $lang . " twg_lock' title='" . $lang_text_array[$lang] . "'  alt='" . $lang_text_array[$lang] . "' src='" . $install_dir_view . "buttons/1x1.gif' ></a>&nbsp;";
            }
        }
        if ($show_languages_as_dropdown) {
            $languagediv .= '</table>';
            $languagediv .= '</div>';
        }
    }
    if (count($languagelist) > 1 && $enable_language_selector) {
        $has_element_before = true;
    } else {
        $has_element_before = false;
    }
    // end of language section preparation
    // if (($image == false && $twg_album == false) || ($twg_album != false && hasRootLink($basedir . "/" . $twg_album))) { // we are in the main view !! - this part does not work 100% yet
    if ($image == false && $twg_album == false) { // we are in the main view !!
        echo '<td class="topnavleft' . ($hide_top ? ' hide' : '') . '">';
        echo '<div class="higher_div">';
        if ($show_breadcrumb) {
            if (!$top10) {
                $printRoot = writeRootLink($install_dir);
                if (!$printRoot) {
                    writeRootLink($basedir);
                }
                echo $lang_select_gallery;
            } else {
                echo "<a href='" . getScriptName() . "?" . $twg_standalone . "'>" . $lang_main_topx . "</a>";
            }
        } else {
            echo ""; // &nbsp;
        }
        echo '</div>';
        echo '</td>';
        echo '<td colspan=2 class="topnavright' . ($hide_top ? ' hide' : '') . '" nowrap>';

        echo $languagediv;
        echo '<div class="higher_div">';
        // print language section
        echo $languagedata;

        if ($show_tags) {
            $has_element_before = print_spacer($has_element_before);
            echo "<a onclick='return twg_showSec(" . $lang_height_tags_top . ")' id='i_top_tags' target='details' href='" . $install_dir_view . "i_frames/i_top_tags.php?" . $twg_standalone . "'>" . $lang_menu_top_tags . "</a>";
        }

        if ($show_topx) {
            $has_element_before = print_spacer($has_element_before);
            echo "<a href='" . getScriptName() . "?twg_top10=" . $topx_default . $twg_standalone . "'>" . sprintf($lang_topx, $number_top10) . "</a>";
        }

        if ($show_search) {
            $has_element_before = print_spacer($has_element_before);
            $tooltip = "";
            if ($use_login_short_menu && $login_edit) {
                $tooltip = " title='" . $lang_search . "' ";
                $lang_search = substr($lang_search, 0, 1) . ".";
            }
            // seo - to avoid i_search.php?
            $twg_standalone_search = '';
            if ($twg_standalone != '') {
                $twg_standalone_search = '?' .  $twg_standalone;
            }
            
            echo "<a " . $tooltip . " onclick='return twg_showSec(" . $lang_height_search . ")' id='i_search' target='details' href='" . $install_dir_view . "i_frames/i_search.php" . $twg_standalone_search . "'>" . $lang_search . "</a>";
        }
        if ($show_email_notification) {
            $has_element_before = print_spacer($has_element_before);
            echo "<a onclick='return twg_showSec(" . $lang_height_email_user . ")' id='i_email' target='details' href='" . $install_dir_view . "i_frames/i_email_user.php?twg_lang=" . $default_language . "'>$lang_email_menu_user</a>";
        }
        if ($show_new_window) {
            $has_element_before = print_spacer($has_element_before);
            $tooltip = "";
            if ($use_login_short_menu && $login_edit) {
                $tooltip = " title='" . $lang_new_window . "' ";
                $lang_new_window = substr($lang_new_window, 0, 1) . ".";
            }
            echo "<a " . $tooltip . " href='javascript:openNewWindow();'>" . $lang_new_window . "</a>";
        }
        $adminfile = realpath(dirname(__FILE__) . "/../admin/index.php");
        if ($login_backend && $enable_frontend_edit) {

            if (is_writable(dirname(__FILE__) . "/../" . $basedir)) {
                $has_element_before = print_spacer($has_element_before);
                echo "<a onclick='nonStickyLayer();return twg_showSec(" . $lang_height_caption . ")' id='i_caption' target='details' href='" . $install_dir_view . "i_frames/i_titel.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "&amp;twg_main=true'>$lang_edit_menu</a>";
            }
        }
        if (file_exists($adminfile)) {
            if ($login_upload && $enable_frontend_upload) {
                $has_element_before = print_spacer($has_element_before);
                echo "<a onclick='open_upload_iframe(" . $lang_height_upload . ")' id='i_upload' target='details' href='" . $install_dir_view . "i_frames/i_upload.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>$lang_menu_upload</a>";
            }
            if ($show_public_admin_link && $login_backend) {
                $has_element_before = print_spacer($has_element_before);
                if (file_exists(realpath(dirname(__FILE__) . "/../admin/_include/fun_users.php"))) {
                    include realpath(dirname(__FILE__) . "/../admin/_include/fun_users.php");
                    $mouse = "";
                    if (isDefaultAdminPasswd()) {
                        echo '<script type="text/javascript" src="' . $install_dir_view . 'js/overlib_mini.js"><!-- overLIB (c) Erik Bosrup --></script>';
                        $hoverjs = true;
                        $mouse = ' onmouseover="return overlib(\'The TWG administration has still the default password.<br>Everyone can access your gallery if you do not change it!\', HAUTO, VAUTO);" onmouseout="return nd();" ';
                    }
                    if ($open_in_new_window) {
                        $target = ' target="_blank" ';
                    } else {
                        $target = '';
                    }
                    echo "<a " . $mouse . $target . " href='" . $install_dir . "admin/index.php'>";
                    if ($hoverjs) {
                        echo '<span class="twg_nocache">' . $lang_administration . '!</span>';
                    } else {
                        echo $lang_administration;
                    }
                    echo "</a>";
                }
            }
        }
    }
    //
    //
    // we are in the thumbnail view !!
    //
    //
    else if ($image == false && $twg_album != false) {
        $imagelist = get_image_list($twg_album);
        $skip_thumbnail_page_dummy = true; // dummyset for the include!
        include dirname(__FILE__) . "/navpath.inc.php";
        if ($show_breadcrumb) {
            if ($imagelist) {
                if ($skip_thumbnail_page_dummy) {
                    echo " > ";
                }
                $nr_images = count($imagelist);
                echo $nr_images . "&nbsp;" . (($nr_images == 1) ? $lang_picture : $lang_pictures);
            } else {
                // not sure if I want to display text here ;)
                // echo "Galerie&nbsp;ausw&auml;hlen";
            }
        }
        echo '</div>';
        echo "</td>";
        echo '<td class="topnav' . $thumbclass_middle . ($hide_top ? ' hide' : '') . '" nowrap>';
        echo '<div class="higher_div">';
        if (!$top10) {
            $upper_level_alb = getupperdirectory($twg_album);
            if ($upper_level_alb) {
                $upper_level = getScriptName() . '?twg_album=' . urlencode($upper_level_alb) . $twg_standalone;
                $upper_leveljs = getScriptName() . '?twg_album=' . urlencode($upper_level_alb) . $twg_standalonejs;
            } else {
                $upper_level = getScriptName() . '?' . $twg_standalone;
                $upper_leveljs = getScriptName() . '?' . $twg_standalonejs ;
            }
        } else {
            $upper_level = getScriptName() . "?twg_album=" . $album_enc . $twg_standalone;
            $upper_leveljs = getScriptName() . "?twg_album=" . $album_enc . $twg_standalonejs;
        }

        //  last/next album is connected to the up button - otherwise the root stuff would not work anymore
        if ($show_up_button) {
            if ($show_last_next_album && !$top10) {
                $last_album = get_last_album($basedir, $twg_album);
                if ($last_album != '') {
                    $hreffirsta = getScriptName() . '?twg_album=' . urlencode($last_album) . $twg_standalone;
                    printf("<a href='%s'><img class='twg_buttons menu_left_gif' src='%sbuttons/ordner_small_last.png' alt='%s' title='%s' id='topfirst'></a>", tfu_seo_rewrite_url($hreffirsta), $install_dir_view, $lang_last_album, $lang_last_album);
                } else {
                    printf("<img src='%sbuttons/1x1.gif' width='22' height='1' alt='' >&nbsp;&nbsp;", $install_dir_view);
                }
            }

            if (isset($_SESSION['twg_ses_foffset'])) {
                // 1 Level weg !
                $current_path = explode(",", $_SESSION['twg_ses_foffset']);
                array_pop($current_path);
                $level = implode(",", $current_path);
                if ($_SESSION['twg_ses_foffset'] != '0' && $_SESSION['twg_ses_foffset'] != '' && $_SESSION['twg_ses_foffset'] != '0,0') { //
                    $upper_level .= "&amp;twg_foffset=" . $level;
                    $upper_leveljs .= "&twg_foffset=" . $level;
                }
            }
            $upper_level =  str_replace('?twg_album=&amp;', '?', $upper_level);  
            $upper_level =  str_replace('?&amp;', '?', $upper_level);   
            
            
            
            printf("<a href='%s'><img class='twg_buttons menu_up_gif' src='%sbuttons/1x1.gif' height='24px' width='22px' alt='%s' title='%s' id='topthumb' ></a>", tfu_seo_rewrite_url($upper_level), $install_dir_view, $lang_overview, $lang_overview);
            printf("<script type='text/javascript'> function key_up() { location.href='%s'; } </script>", $upper_leveljs);
            if ($show_last_next_album) {
                $next_album = get_next_album();
                if ($next_album != '') {
                    $hreffirsta = getScriptName() . '?twg_album=' . urlencode($next_album) . $twg_standalone;
                    printf("<a href='%s'><img class='twg_buttons menu_right_gif'  height='24px' width='22px' src='%sbuttons/ordner_small_next.png' alt='%s' title='%s' id='topfirst'></a>", tfu_seo_rewrite_url($hreffirsta), $install_dir_view, $lang_next_album, $lang_next_album);
                } else {
                    printf("<img src='%sbuttons/1x1.gif' width='22' height='1' alt='' >&nbsp;&nbsp;", $install_dir_view);
                }
            }
        }
        echo '</div>';
        echo '</td>';
        echo '<td class="topnavright '. $thumbclass . ($hide_top ? ' hide' : '') . '" align="right">';
        echo $languagediv;
        echo '<div class="higher_div">';
        // print language section
        echo $languagedata;
        if ($show_tags) {
            $has_element_before = print_spacer($has_element_before);
            echo "<a onclick='return twg_showSec(" . $lang_height_tags_top . ")' id='i_top_tags' target='details' href='" . $install_dir_view . "i_frames/i_top_tags.php?twg_album=" . $album_enc . $twg_standalone . "'>" . $lang_menu_top_tags . "</a>";
        }
        if ($show_topx) { // only twg_show the top x when the view count is enabled
            $has_element_before = print_spacer($has_element_before);
            echo "<a href='" . getScriptName() . "?twg_album=" . $album_enc . "&amp;twg_top10=" . $topx_default . $twg_standalone . "'>" . sprintf($lang_topx, $number_top10) . "</a>";
        }
        if ($show_search) {
            $has_element_before = print_spacer($has_element_before);
            echo "<a  rel='noindex,nofollow' onclick='return twg_showSec(" . $lang_height_search . ")' id='i_search' target='details' href='" . $install_dir_view . "i_frames/i_search.php?twg_album=" . $album_enc . $twg_standalone . "'>" . $lang_search . "</a>";
        }
        if ($show_new_window) {
            $has_element_before = print_spacer($has_element_before);
            echo "<a rel='noindex,nofollow' href='javascript:openNewWindow();'>" . $lang_new_window . "</a>";
        }

        if ($login_upload && $enable_frontend_upload) {
            $has_element_before = print_spacer($has_element_before);
            echo "<a onclick='nonStickyLayer();open_upload_iframe(" . $lang_height_upload . ")' id='i_upload' target='details' href='" . $install_dir_view . "i_frames/i_upload.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>$lang_menu_upload</a>";
        }
         if ($login_backend && $enable_frontend_edit) {
            if (is_writable(dirname(__FILE__) . "/../" . $basedir . '/' . $twg_album )) {
                $has_element_before = print_spacer($has_element_before);
                echo "<a onclick='nonStickyLayer();return twg_showSec(" . $lang_height_caption . ")' id='i_caption' target='details' href='" . $install_dir_view . "i_frames/i_titel.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "&amp;twg_thumb=true'>$lang_edit_menu</a>";
            }
        }
    }
    //
    //
    // we are in the image view
    //
    //
    else if ($image != false) {
        $has_element_before = false;
        // $image_enc = urlencode($image);
        $current_id = get_image_number($twg_album, $image_enc);
        $imagelist = get_image_list($twg_album);
        // we do the autoskipthumbs!
        if ($auto_skip_thumbnail_page && $twg_smallnav == 'FALSE') {
            if (count($imagelist) <= (($numberofpics * 2) + 1)) {
                $skip_thumbnail_page = true;
            }
        }
        if ($imagelist) {
            $image = $imagelist[$current_id];  
        } else {
            $image = '';
        }
        $image_enc = $image;
        $skip_thumbnail_page_dummy = $skip_thumbnail_page;
        include dirname(__FILE__) . "/navpath.inc.php";
        if ($show_breadcrumb) {
            if ($image) {
                if ($skip_thumbnail_page_dummy) {
                    echo " > ";
                }
                echo $lang_picture . "&nbsp;<span id='imagecounter'>" . ($current_id + 1) . "</span>&nbsp;" . $lang_of . "&nbsp;" . count($imagelist);
                if ($show_count_views) {
                    echo '&nbsp;(<span id="viewcounter">' . increaseImageCount($twg_album, urldecode($image)) . '</span>' . $lang_views . ')';
                }
            }
        }
        echo '</div>';
        echo '</td><td class="topnav' . ($hide_top || $hide_topnavigation ? ' hide' : '') . '" nowrap>';
        echo '<div class="higher_div">';
        if (!$top10) {
            include dirname(__FILE__) . "/topnavigation_buttons.inc.php";
        } else {
            if ($top10_type == "search") {
                $lang_back_topx = $lang_search_back;
            }
            echo "<a href='javascript:history.back()'>" . sprintf($lang_back_topx, $number_top10) . "</a>";
        }
        echo '</div>';
        echo '</td>';
        echo '<td class="topnavright ' . $thumbclass . ($hide_top ? ' hide' : '') . '">';
        echo '<div class="higher_div">';
        if ($show_image_rating && $image_rating_position == "menu" && $image_enc != '') {
            $has_element_before = true;
            $tooltip = "";
            if ($use_login_short_menu && $login_edit) {
                $tooltip = " title='" . $lang_rating . "' ";
                $lang_rating = substr($lang_rating, 0, 1) . ".";
            }
            echo "<a " . $tooltip . " onclick='nonStickyLayer();return twg_showSec(" . $lang_height_rating . ")' target='details' id='i_rate' href='" . $install_dir_view . "i_frames/i_rate.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>$lang_rating</a>";
        }
        if ($show_enhanced_file_infos && $image_enc != '') {
            $has_element_before = print_spacer($has_element_before);
            $tooltip = "";
            if ($use_login_short_menu && $login_edit) {
                $tooltip = " title='" . $lang_fileinfo . "' ";
                $lang_fileinfo = substr($lang_fileinfo, 0, 1) . ".";
            }
            echo "<a " . $tooltip . " onclick='stickyLayer();return twg_showSec(" . $lang_height_info . ");' target='details' id='i_info' href='" . $install_dir_view . "i_frames/i_info.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>$lang_fileinfo</a>";
        }

        // comments can be set that they can only be entered by registered users ...
        if ($show_comments && $image_enc != '' && $show_comments_menue && (($enable_comments_only_registered && $login_edit) || ($enable_comments_only_registered && isset($_SESSION['s_user'])) || !$enable_comments_only_registered)) {
            $has_element_before = print_spacer($has_element_before);
            if ($show_number_of_comments) {
                $com_counter = " (<span id='commentcount'>" . getKommentarCount($image, $twg_album, $kwerte, $kindex) . "</span>)";
            } else {
                $com_counter = "";
            }
            $tooltip = "";
            if ($use_login_short_menu && $login_edit && !$enable_comments_only_registered) {
                $tooltip = " title='" . $lang_comments . "' ";
                $lang_comments_s = substr($lang_comments, 0, 1) . ".";
            } else {
                $lang_comments_s = $lang_comments;
            }
            echo "<a " . $tooltip . " onclick='nonStickyLayer();return twg_showSec(" . $lang_height_comment . ")' target='details' id='i_comment' href='" . $install_dir_view . "i_frames/i_kommentar.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>" . $lang_comments_s . $com_counter . "</a>";
        }
        if ($show_optionen && $image_enc != '') {
            $has_element_before = print_spacer($has_element_before);
            $tooltip = "";
            if ($use_login_short_menu && $login_edit) {
                $tooltip = " title='" . $lang_optionen . "' ";
                $lang_optionen = substr($lang_optionen, 0, 1) . ".";
            }
            echo "<a " . $tooltip . " onclick='nonStickyLayer();return twg_showSec(" . $lang_height_options . ")' id='i_options' target='details' href='" . $install_dir_view . "i_frames/i_optionen.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>" . $lang_optionen . "</a>";
        }
        if ($login_upload && $enable_frontend_upload) {
            $has_element_before = print_spacer($has_element_before);
            echo "<a onclick='nonStickyLayer();open_upload_iframe(" . $lang_height_upload . ")' id='i_upload' target='details' href='" . $install_dir_view . "i_frames/i_upload.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>$lang_menu_upload</a>";
        }
        if ($login_edit && $show_tags) {
            $has_element_before = print_spacer($has_element_before);
            echo "<a onclick='nonStickyLayer();return twg_showSec(" . $lang_height_tags_insert . ")' id='i_tags' target='details' href='" . $install_dir_view . "i_frames/i_tags.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>$lang_menu_tags</a>";
        }
        if ($login_edit && ($show_captions || $enable_frontend_edit)) {
            $has_element_before = print_spacer($has_element_before);
            echo "<a onclick='nonStickyLayer();return twg_showSec(" . $lang_height_caption . ")' id='i_caption' target='details' href='" . $install_dir_view . "i_frames/i_titel.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>$lang_edit_menu</a>";
        }
    } else {
        // wrong input - we do nothing right now.
    }
    if (!isset($image_enc)) {
        $image_enc = "";
    }
    if (!isset($album_enc)) {
        $album_enc = "";
    }
    // twg_shows login/logout
    if ($show_login) {
        $has_element_before = print_spacer($has_element_before);
        if ($login == 'TRUE') {
            echo "<a target='details' id='logoutlink' href='" . $install_dir_view . "i_frames/i_login.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . "&amp;twg_logout=true" . $twg_standalone . "'>$lang_logout</a>";
        } else {
            echo "<a onclick='nonStickyLayer();return twg_showSec(" . $lang_height_login . ")' id='loginlink' target='details' href='" . $install_dir_view . "i_frames/i_login.php?twg_album=" . $album_enc . "&amp;twg_show=" . $image_enc . $twg_standalone . "'>$lang_login</a>";
        }
    }

    // include menu extension
    $menuhtml = dirname(__FILE__) . "/../menu_" . $default_language . ".htm";
    if (file_exists($menuhtml)) {
        include ($menuhtml);
    } else {
        $menuhtml = dirname(__FILE__) . "/../menu.htm";
        if (file_exists($menuhtml)) {
            include ($menuhtml);
        }
    }
    // this is a pixel need to focus and to measure the inner screen area for all browsers properly!
    if (!$hide_top) {
        echo '<a id="cornerpixela" style="text-decoration:none;font-size:0px;" href="about:blank"><img height=0 width=0 alt="" id="cornerpixel"  src="' . $install_dir_view . 'buttons/1x1.gif" ></a>';
    }
    echo '</div>';
    echo '</td>';
    if ($hide_top) {
        echo '<td class="topnavright" style="height:0px"><a id="cornerpixela" style="text-decoration:none;font-size:0px;" href="about:blank"><img height=0 width=0 alt="" id="cornerpixel"  src="' . $install_dir_view . 'buttons/1x1.gif" ></a></td>';
    }
}
?>