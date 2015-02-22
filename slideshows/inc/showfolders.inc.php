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

function show_folders($localdir, $twg_foffset, $twg_offset, $twg_album)
{
    global $menu_pic_size_x, $menu_pic_size_y, $menu_x, $show_number_of_pic, $cachedir;
    global $privatelogin, $privatepassword, $kwerte, $kindex, $lang_titel, $lang_titel_no;
    global $default_language, $basedir, $skip_thumbnail_page, $show_colage, $gray_fading_level;
    global $sort_albums_ascending, $extension_thumb, $menu_x, $menu_y, $lang_thumb_back, $lang_thumb_forward;
    global $install_dir, $twg_standalone, $twg_standalonejs, $lang_height_private;
    global $use_random_image_for_folder, $session_available, $lang_no_session, $sort_albums, $menu_pic_size_x;
    global $hidemenuborder, $resize_folder_gif, $folder_effect, $fading_level, $fade_all, $compression;
    global $twg_offset, $use_random_image_for_change, $disable_direct_thumbs_access, $auto_skip_thumbnail_page;
    global $numberofpics, $twg_smallnav, $msie, $show_clipped_images, $show_changes, $show_changes_type;
    global $compression, $autogenerate_private_png, $print_watermark, $watermark_small, $position, $transparency;
    global $spacer_char, $paging_num, $paging_steps, $paging_use_style, $show_subdirs_first;
    global $autocreate_folder_image, $precache_main_top_x_interval, $privatelogin, $password_iframe;
    global $user_login_mode, $user_login_mode_hide_gal, $direct_folderpng, $hide_overview_image_border;
    global $menu_cellspacing, $menu_cellpadding, $charset, $install_dir_view, $twg_seo_active;
    global $responsive_main_page, $responsive_main_page_padding_x, $responsive_main_page_padding_y;
    global $responsive_align_center, $basedir_view;

    // we need the local offset now
    $twg_foffset_array = explode(",", $twg_foffset);
    $twg_foffset_local = array_pop($twg_foffset_array);
    $twg_foffset_prefix = implode(",", $twg_foffset_array);
    if ($twg_foffset_prefix != '') {
        $twg_foffset_prefix .= ',';
    }
    $numofrows = 1;
    $verzeichnisse = get_directories($localdir);
    $nr_images_dir = get_image_count($twg_album);
    $nr = count($verzeichnisse);

    echo '<div class="folder_page">';

    if (($nr > 0 || $nr_images_dir > 0) && ($basedir == $localdir) && $twg_offset == 0) {
        if ($lang_titel != '') {
            printf("<span class='twg_title'>" . $lang_titel . "</span><br><br>");
        }
        $text = getDirectoryDescription($basedir);
        if ($text) {
            echo '<img height=5 width=1 alt=""  src="' . $install_dir_view . 'buttons/1x1.gif" ><br>';
            echo "<div class='twg_folderdescription'>" . $text . "</div><br>";
        }

    } else {
        if ($basedir == $localdir && $nr_images_dir == 0) { // we are already in a substructure  - no message here
            printf("<span class='twg_bold'>" . $lang_titel_no . "</span><br><br>");
            return 0;
        }
    }

    if ($nr == 0) { // we don't have subdirs - only images in the main folder!
        return 0;
    }

    $x = 0; // counts folders in a row
    $xx = 0; // counts actual folders
    $vis_folders = 0;
    if ($folder_effect == "fade") {
        if ($msie) {
            $iefilter = "filter:alpha(opacity=" . $fading_level . ");";
        } else {
            $iefilter = "";
        }
        $fade = " style='" . $iefilter . "opacity:0." . $fading_level . ";' onMouseover='if (window.makevisible) makevisible(this,0);' onMouseout='if (window.makevisible) makevisible(this,1)' ";
        if ($fade_all) {
            $fadeall = " style='" . $iefilter . "opacity:0." . $fading_level . ";' onMouseover='if (window.makevisibleAll) makevisibleAll(this,0)' onMouseout='if (window.makevisibleAll) makevisibleAll(this,1)' ";
        } else {
            $fadeall = $fade;
        }
    } else if ($folder_effect == "gray") {
        if ($msie) {
            $iefilter = "filter:gray();";
        } else {
            $iefilter = "";
        }

        $fade = " style='" . $iefilter . "opacity:0." . $gray_fading_level . ";' onMouseover='makegray(this,0)' onMouseout='makegray(this,1)' ";
        if ($fade_all) {
            $fadeall = " style='" . $iefilter . "opacity:0." . $gray_fading_level . ";' onMouseover='makegrayAll(this,0)' onMouseout='makegrayAll(this,1)' ";
        } else {
            $fadeall = $fade;
        }
    } else {
        $fade = $fadeall = '';
    }

    // because of a bug in IE the center has to be here and not be defined in the style sheet where it should be 
    echo '<center id="center-folders">';
    if (!$responsive_main_page) {
      echo '<table summary="" class="thumbnails" cellspacing="' . $menu_cellspacing . '" cellpadding="' . $menu_cellpadding . '">';
      echo '<tr>';
    }
    $menupage = $menu_x * $menu_y;

    $skip_thumbnail_page_orig = $skip_thumbnail_page;

    while (list ($key, $val) = each($verzeichnisse)) {
        if ($folder_effect == 'change') {
            $fade = $fadeall = '';
        }
        $xx++;

        // we check each twg_album if it is visible
        $twg_album = $val;
        if ($basedir != $localdir) {
            $twg_album = substr($localdir, strlen($basedir) + 1) . '/' . $twg_album;
        }
        $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
        $relativepath = '';
        $folderfilecache = false;
        include dirname(__FILE__) . '/checkprivate.inc.php';
        $privatecheck = $privategal && !in_array($privatelogin, $passwd);

        if ($user_login_mode && $user_login_mode_hide_gal && $privatecheck) {
            continue;
        }
        $vis_folders++;

        $hasAlbumDescription = hasAlbumDescription($basedir . '/' . $twg_album);


        if ($vis_folders > $twg_foffset_local && $vis_folders <= ($twg_foffset_local + $menupage)) {


            if ($show_number_of_pic) {
                $nr_count_tree = count_tree($basedir . '/' . $twg_album);
            } else {
                $nr_count_tree = '';
            }

            // the title is prepared
            $temp1 = explode('/', $twg_album);
            $temp2 = array_pop($temp1);
            $titel = htmlspecialchars($temp2);
            $titel = getDirectoryName($basedir . '/' . $twg_album, $titel);
            // we get the folder description if a album.txt exists


            if ($x++ == $menu_x) {
                if (!$responsive_main_page) { 
                   echo '</tr>';
                   echo '<tr>';
                }
                $numofrows++;
                $x = 1;
            }


            $imagelist = get_image_list($twg_album, false, false);
            // we do the autoskipthumbs!
            $skip_thumbnail_page = $skip_thumbnail_page_orig;
            if ($auto_skip_thumbnail_page && $twg_smallnav == 'FALSE') {
                if (count($imagelist) <= (($numberofpics * 2) + 1)) {
                    $subs = get_directories($localdir . '/' . $val);
                    $nrsubs = count($subs);
                    if ($nrsubs == 0) {
                        $skip_thumbnail_page = true;
                    }
                }
            }
            $folderfile = $basedir . '/' . $twg_album . '/folder.png';
            if (file_exists($folderfile)) {
                $folderfileexists = true;
                $borderwidth = '';
                $folderfile = 'folder.png';
                // $overflowstyle = "";
            } else {
                if ($autocreate_folder_image) {
                    $folderfile = $cachedir . '/_' . md5($twg_album . $privatelogin) . '_folder_top.tmp.png';
                    if (file_exists($folderfile)) {
                        // we check the time if it's over 1 day if yes we delete it
                        if ((time() - filemtime($folderfile)) >= $precache_main_top_x_interval * 3600) {
                            @unlink($folderfile);
                        }
                    }
                    clearstatcache();
                    if (!file_exists($folderfile)) { // too old or it does not exist!
                        // create folder_top.png
                        $no_session_cache = true;
                        $folder_top = getTopXViewsImage($twg_album);
                        $imagesrc = $basedir . "/" . $twg_album . "/" . urldecode($folder_top);
                        if ($folder_top && file_exists($imagesrc)) {
                            // we create the folderfile ....
                            // create the cache image in the right resolution!
                            include_once dirname(__FILE__) . "/imagefunctions.inc.php";
                            $print_watermark = false;
                            $print_text = false;
                            $show_clipped_images = true;
                            if (generatesmall($imagesrc, $folderfile, $menu_pic_size_x, $compression, 0, '')) {
                                $folderfileexists = true;
                                $folderfilecache = true;
                                $borderwidth = '';
                            } else { // image could not be generated. We use the default settings.
                                $folderfileexists = false;
                                $borderwidth = "width:" . $menu_pic_size_x . "px;";
                            }
                        } else {
                            $folderfileexists = false;
                            $borderwidth = "width:" . $menu_pic_size_x . "px;";
                        }
                    } else {
                        $folderfilecache = true;
                        $folderfileexists = true;
                        $borderwidth = '';
                    }
                } else {
                    $folderfileexists = false;
                    $borderwidth = "width:" . $menu_pic_size_x . "px;";
                }
                // $overflowstyle = " style='overflow:hidden;' ";
            }

            if ($privatecheck) {
                $privateimage = $basedir . "/" . $twg_album . "/private.png";
                if (file_exists($privateimage)) {
                    $borderwidth = '';
                    // $overflowstyle = "";
                } else {
                    $borderwidth = "width:" . $menu_pic_size_x . "px;";
                    // $overflowstyle = " style='overflow:hidden;' ";
                }
            }

            $menuborder = ($hide_overview_image_border) ? '0' : '1';
            // check new !
            if (isset($_SESSION['new_tree'])) {
                $new_galleries = $_SESSION['new_tree'];
            } else {
                $new_galleries = array();
            }

            if ($show_changes > 0 && $show_changes_type == "highlight" && in_array($basedir . "/" . $twg_album, $new_galleries)) {
                $newstyle = " highlight";
            } else {
                $newstyle = '';
            }
            
            if ($responsive_main_page) {
              $float_width = ($hasAlbumDescription) ? '' : 'width:' . ($menu_pic_size_x + $responsive_main_page_padding_x) . 'px;'; 
              $float_height =  'height:' . ($menu_pic_size_y + $responsive_main_page_padding_y ) . 'px;';
              $responsive_main_page_style = ' style="'.$float_width.$float_height.'"';
              $responsive_align_center_class = ($responsive_align_center) ? '' : ' mainnav-float-left';
 
              echo '<div class="mainnav-float'.$responsive_align_center_class.'" '. $responsive_main_page_style .'>';  
            } else {
              echo '<td class="mainnav">';
            }
            $new_link = '';
            $new_href = '#';
            $twg_foffset_link = '';
            if ($twg_foffset != '' && $twg_foffset != '0' && $twg_foffset != '0,0') { //
                $twg_foffset_link = '&amp;twg_foffset=' . $twg_foffset;
                if (!$skip_thumbnail_page) {
                    $twg_foffset_link .= ',0';
                }
            }
            if (!$privatecheck) {
                $folderlink = $basedir . '/' . $twg_album . '/folderlink.txt';
                if (file_exists($folderlink)) {
                    $folderlinkcontent = getFileContent($folderlink, '');
                    echo $folderlinkcontent;
                } else if ($skip_thumbnail_page) { // we jump direct to the details page - x ist not found - by default the 1st image is twg_shown
                    $new_href = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=x' . $twg_foffset_link . $twg_standalone;
                    $new_link = '<a href="' . tfu_seo_rewrite_url($new_href) . '">';
                } else {
                    $new_href = getScriptName() . '?twg_album=' . $album_enc . $twg_foffset_link . $twg_standalone;
                    $new_link = '<a href="' . tfu_seo_rewrite_url($new_href) . '">';
                }
            }


            if ($folderfileexists || $privatecheck) {
                echo "<center id='center-album-l'><table class='twg twg_folder_border " . $newstyle . "' summary='' border='" . $menuborder . "' cellspacing='0' cellpadding='0'><tr>";
                includeMainAlbumDescriptionL($basedir . "/" . $twg_album, $new_href, $titel, $nr_count_tree);
                echo '<td style="' . $borderwidth . 'max-width:100%" class="twg padding">';    
            } else {
                echo "<center id='center-album-2'><table class='twg twg_folder_border " . $newstyle . "' summary='' border='" . $menuborder . "' cellspacing='0' cellpadding='0'><tr>";
                includeMainAlbumDescriptionL($basedir . "/" . $twg_album, $new_href, $titel, $nr_count_tree);
                echo "<td class='twg padding' style='vertical-align:middle;" . $borderwidth . "max-width:100%'>";
            }
            // <div class='div1' " . $overflowstyle . ">
            echo '<center id="center-album-main">'; // center is needed - because thunderbird does otherwise not center !
            // wenn angemeldet - alles gut

            // NEW SYMBOL
            if ($show_changes > 0 && $show_changes_type == "image" && in_array($basedir . "/" . $twg_album, $new_galleries)) {
                echo "<div class='new_div'>" . $new_link . "<img height='32px' width='50px' class='twg_sprites new_gif' alt=''  src='" . $install_dir_view . "buttons/1x1.gif' >";
                if ($new_link != '') {
                    echo '</a>';
                }
                echo '</div>';
            }
            echo $new_link;
            // END NEW SYMBOL
            
            // if not logged in - we show the login iframe
            if (!$privatecheck) {
                if ($folderfileexists) {
                    $fadeold = $fade; // save settings
                    if ($folderfilecache) {
                        $folderfileindirect = $folderfile;
                    } else {
                        if ($direct_folderpng) {
                            $folderfileindirect = twg_urlencode($basedir_view . '/' . $twg_album . '/' . $folderfile);
                        } else {
                            $folderfileindirect = $install_dir_view . 'image.php?twg_album=' . $album_enc . '&amp;twg_type=png&amp;twg_show=' . $folderfile;
                        }
                    }
                    $folderfile2 = $basedir . "/" . $twg_album . "/folder2.png";
                    if (file_exists($folderfile2)) { // we replace the fade effect!
                        // the js src is needed because of the preloader to work properly!
                        if ($direct_folderpng) {
                            $folderfileindirect2js = twg_urlencode($basedir . '/' . $twg_album . '/folder2.png');
                        } else {
                            $folderfileindirect2js = $install_dir_view . 'image.php?twg_album=' . $album_enc . '&amp;twg_type=png&amp;twg_show=folder2.png';
                        }
                        $fade = "  onMouseout='this.src=\"" . $folderfileindirect . "\"' onmouseover='this.src=\"" . $folderfileindirect2js . "\"' ";
                        echo "<script type='text/javascript'> MM_preloadImages('" . $folderfileindirect2js . "');</script>";
                    }
                    if (!$resize_folder_gif) {
                        echo "<img " . $fade . " src='" . $folderfileindirect . "' alt='' >"; // width='" . $menu_pic_size_x . "' height='" . $menu_pic_size_y . "'
                    } else {
                        echo "<img " . $fade . " src='" . $folderfileindirect . "' alt='' width='" . $menu_pic_size_x . "' height='" . $menu_pic_size_y . "'>"; //
                    }
                    $fade = $fadeold; // restore
                } else if ($imagelist == false) {
                    if (!$resize_folder_gif) {
                        $pad = ($menu_pic_size_y / 2) - 23; // div before with pad only top!
                        // echo "<span style='cursor:pointer;text-align: center; vertical-align: middle;width:" . ($menu_pic_size_x) . "px;height:" . ($menu_pic_size_y) . "px;' >";
                        //echo $new_link; // fix ie;
                        //echo "<!-- ".$new_link." -->";
                        echo "<img class='folder-gif' width='57px' height='47px' style='margin-bottom:" . $pad . "px;margin-top:" . $pad . "px;' src='" . $install_dir_view . "buttons/ordner.gif' alt=''>";
                        //if ($new_link != "") { // fix ie
                        //  echo "</a>";
                        //}
                        // echo "</span>";
                    } else {
                        echo "<img class='folder-gif' " . $fade . " src='" . $install_dir_view . "buttons/ordner.gif' alt='' width='" . $menu_pic_size_x . "' height='" . $menu_pic_size_y . "'>";
                    }
                } else {
                    if ($show_colage) { // here we decide if we use 1 image or 4 for he galleryimage
                        $show_col = 4;
                        $show_dif = 2;
                    } else {
                        $show_col = 1;
                        $show_dif = 1;
                    }
                    if ($use_random_image_for_folder) {
                        srand((double)microtime() * 100000); // needed before 4.2 !
                        $nrrand = (count($imagelist) > 3) ? 4 : count($imagelist);
                        if (count($imagelist) == 1) {
                            $keylist = array(0);
                        } else {
                            $keylist = array_rand($imagelist, $nrrand);
                        }
                        if ($folder_effect == "change") {
                            if ($use_random_image_for_change) {
                                srand((double)microtime() * 11111 + 4); // needed before 4.2 !
                                $nrrand2 = (count($imagelist) > 3) ? 4 : count($imagelist);
                                if (count($imagelist) == 1) {
                                    $keylistchange = array(0);
                                } else {
                                    $keylistchange = array_rand($imagelist, $nrrand2);
                                }
                            } else {
                                $keylistchange = array_reverse($keylist);
                            }
                        }
                        // echo "vals" . count($imagelist) . ":" . $keylist[0] . $keylist[1] . $keylist[2] . $keylist[3];
                    } else {
                        $nrimages = count($imagelist);
                        $keylist = array(0, 1, 2, 3);
                        if ($folder_effect == "change") {
                            if ($use_random_image_for_change) {
                                srand((double)microtime() * 11111 + 4); // needed before 4.2 !
                                $nrrand = ($nrimages > 3) ? 4 : $nrimages;
                                if ($nrimages == 1) {
                                    $keylistchange = array(0);
                                } else {
                                    $keylistchange = array_rand($imagelist, $nrrand);
                                }
                            } else {
                                if ($nrimages > 3) {
                                    $keylistchange = array(3, 2, 1, 0);
                                } else if ($nrimages > 2) {
                                    $keylistchange = array(2, 0, 1, 0);
                                } else if ($nrimages > 1) {
                                    $keylistchange = array(1, 0, 0, 0);
                                } else {
                                    $keylistchange = array(0, 1, 2, 3);
                                }
                            }
                        }
                    }
                    // we twg_show a collage of 2x2 or 1 image depending on $show_colage
                    echo "<span class='nowrap'>";
                    for ($current = 0, $i = 0; $i < $show_col; $i++) {
                        if ($i >= count($imagelist)) {
                            printf("<img %s src='%sbuttons/1x1.gif' width='%d' height='%d' alt='' >", $fade, $install_dir_view, $menu_pic_size_x / $show_dif, $menu_pic_size_y / $show_dif);
                        } else {
                            $width = $menu_pic_size_x / $show_dif;
                            $height = $menu_pic_size_y / $show_dif;
                            $aktimage = replace_valid_url($imagelist[$keylist[$i]]);
                            $thumbimage = create_thumb_image($twg_album, $aktimage);
                            $thumb = create_cache_file($thumbimage, $extension_thumb);
                            if ($folder_effect == "change") {
                                $aktimagechange = $imagelist[$keylistchange[$i]];
                                $thumbimagechange = create_thumb_image($twg_album, $aktimagechange);
                                $thumbchange = create_cache_file(cacheencode($thumbimagechange), $extension_thumb, true, $twg_seo_active);
                            }

                            if (!file_exists($thumb) || $disable_direct_thumbs_access) {
                                $ccomment = '';
                                loadXMLFiles($twg_album);
                                $ccount = getKommentarCount($imagelist[$i], $twg_album, $kwerte, $kindex);
                                if ($ccount > 0) {
                                    $ccomment = "&amp;twg_comment=" . $ccount; // this is done to cut of the upper right corner to indicate a comment!
                                }

                                if ($folder_effect == "change") {
                                    $thumbchange = $install_dir_view . 'image.php?twg_album=' . $album_enc . '&amp;twg_type=thumb&amp;twg_show=' . $aktimagechange;
                                    $fadeall = "  onMouseout='MM_swapImgRestore()' onmouseover=\"MM_swapImage('id" . (($xx * 100) + $i) . "','','" . $thumbchange . "',1);\" ";
                                    $fade = $fadeall;
                                }

                                if ($show_colage) {
                                    printf("<img %s id=id%s src='%simage.php?twg_album=%s&amp;twg_type=thumb&amp;twg_show=%s%s' width='%d' height='%d' alt=''>", $fadeall, ($xx * 100) + $i, $install_dir_view, $album_enc, $imagelist[$keylist[$i]], $ccomment, $width, $height);
                                } else {
                                    if ($show_clipped_images) {
                                        printf("<img %s id=id%s src='%simage.php?twg_album=%s&amp;twg_type=thumb&amp;twg_show=%s%s' width='%d' height='%d' alt=''>", $fade, (($xx * 100) + $i), $install_dir_view, $album_enc, $imagelist[$keylist[$i]], $ccomment, $height, $height);
                                    } else {
                                        printf("<img %s id=id%s src='%simage.php?twg_album=%s&amp;twg_type=thumb&amp;twg_show=%s%s' alt=''>", $fade, (($xx * 100) + $i), $install_dir_view, $album_enc, $imagelist[$keylist[$i]], $ccomment);
                                    }
                                }
                            } else {
                                $thumb = create_cache_file(cacheencode($thumbimage), $extension_thumb, true, $twg_seo_active);
                                if ($folder_effect == "change") {
                                    $fadeall = "  onMouseout='MM_swapImgRestore()'
																			 onmouseover=\"MM_swapImage('id" . (($xx * 100) + $i) . "','','" . ($thumbchange) . "',1);\" ";
                                    $fade = $fadeall;
                                }

                                if ($show_colage) {
                                    printf("<img %s id=id%s src='%s' width='%d' height='%d' alt=''>", $fadeall, (($xx * 100) + $i), $thumb, $width, $height);
                                } else {
                                    if ($show_clipped_images) {
                                        printf("<img %s id=id%s src='%s'  width='%d' height='%d' alt=''>", $fade, (($xx * 100) + $i), $thumb, $height, $height);
                                    } else {
                                        printf("<img %s id=id%s src='%s'  alt=''>", $fade, (($xx * 100) + $i), $thumb);
                                    }
                                    // this version shrinks the image to the right size - is not used because browser does the sameif you leave out the width
                                    // printf("<img src='%s' id='pic%s' onload=\"ShrinkToFit('pic%s', '%s', '%s');\" alt='%s'>", $thumb, $xx, $xx, $width, $height, $twg_album);
                                }
                            }
                        }
                        if ($i == 1) {
                            echo "</span><br><span class='nowrap'>";
                        }
                    }
                    echo "</span>";
                }
                echo "</a>";
            } else {
                $privateimage = $basedir . "/" . $twg_album . '/private.png';
                $have_priv_image = file_exists($privateimage);
                if (!$have_priv_image && $autogenerate_private_png) {
                    // we generate one with the first and store this in the cache !
                    if (isset($imagelist[0])) {
                        $image1 = $basedir . "/" . $twg_album . "/" . urldecode($imagelist[0]);
                        $cacheimage = $cachedir . "/pi_" . sha1($twg_album) . ".jpg";
                        if (!file_exists($cacheimage)) {
                            // create the cache image in the right resolution!
                            include_once dirname(__FILE__) . "/imagefunctions.inc.php";
                            $print_watermark = true;
                            $watermark_small = "buttons/private.png";
                            $position = 5;
                            $transparency = 0;
                            $show_clipped_images = true;
                            generatesmall($image1, $cacheimage, $menu_pic_size_x, $compression, 0, '');
                        }
                    }

                }
                // we show the private picture
                if ($session_available) {
                    $priv_link = "<a onclick='return twg_showSec(" . $lang_height_private . ")'  target='details' href='" . $install_dir_view . "i_frames/" . $password_iframe . "?twg_album=" . $album_enc . $twg_foffset_link . $twg_standalone . "'>";
                } else {
                    $priv_link = "<a href=\"javascript:alert('" . $lang_no_session . "'); \">";
                }
                if (!$have_priv_image && (!$autogenerate_private_png || !isset($imagelist[0]))) {
                    echo "<div style='border:none;text-align: center; vertical-align: middle;width:" . ($menu_pic_size_x) . "px;height:" . ($menu_pic_size_y) . "px;' ><img style='width:1px;height:" . (($menu_pic_size_y / 2) + 30) . "px;'src='" . $install_dir_view . "buttons/1x1.gif' alt='' >";
                }

                echo $priv_link;

                if ($have_priv_image) {
                    if ($direct_folderpng) {
                        $privatefileindirect = twg_urlencode($privateimage);
                    } else {
                        $privatefileindirect = $install_dir_view . 'image.php?twg_album=' . $album_enc . '&amp;twg_type=png&amp;twg_show=private.png';
                    }
                    if (!$resize_folder_gif) {
                        echo "<img " . $fade . " src='" . $privatefileindirect . "' alt='' >";
                    } else {
                        echo "<img " . $fade . " src='" . $privatefileindirect . "' alt='' width='" . $menu_pic_size_x . "' height='" . $menu_pic_size_y . "'>";
                    }
                } else {
                    if ($autogenerate_private_png && isset($imagelist[0])) {
                        // echo "<img src='" . $install_dir . "buttons/private.gif' alt='' width='" . $menu_pic_size_x . "' height='" . $menu_pic_size_y . "' >";
                        echo "<img " . $fade . " src='" . $cacheimage . "' alt='' >";
                    } else {
                        echo "<img " . $fade . " width='64' height='64' src='" . $install_dir_view . "buttons/private.png' alt='' >";
                    }
                }
                echo "</a>";
                if (!$have_priv_image && (!$autogenerate_private_png || !isset($imagelist[0]))) {
                    echo '</div>';
                }
            }
            echo '</center></td>';
            // </div>
            includeMainAlbumDescriptionR($basedir . '/' . $twg_album, $new_href, $titel, $nr_count_tree);
            echo '</tr></table></center>';

            if (!$hasAlbumDescription) {
                $maxWidth = $menu_pic_size_x * 1.5; 
                echo '<div style="max-width:'.$maxWidth.'px" class="twg_center">';
                if (!$privatecheck) {
                    if (file_exists($folderlink)) {
                        echo $folderlinkcontent;
                    } else
                        echo $new_link;
                } else {
                    echo $priv_link;
                }
                printf("%s", $titel);
                if ($show_number_of_pic) {
                    printf(" (%d)", $nr_count_tree);
                }

                if ($privategal) {
                    if (in_array($privatelogin, $passwd)) {
                        printf("</a><a href='%s?twg_gal_logout=true%s'>", getScriptName(), $twg_standalone);
                        echo "<img class='twg_sprites unlock_gif twg_lock'  src='" . $install_dir_view . "buttons/1x1.gif' alt=''>";
                    } else {
                        echo "<img class='twg_sprites lock_gif twg_lock' src='" . $install_dir_view . "buttons/1x1.gif' alt='' >";
                    }
                }
                echo '</a></div>';
            } 
            
            if ($responsive_main_page) {
              echo '</div>';
            } else {
              echo '</td>';
            }
        }
    }
    if (!$responsive_main_page) {
      echo '</tr>';
      echo '</table>';
    }
    echo '</center>';
    //
    // pager line
    //
    $menuxy = $menu_x * $menu_y;
    $actpage = 0;
    $nr = $vis_folders;

    if ($basedir != $localdir) {
        $album_next = '&amp;twg_album=' . urlencode(substr($localdir, strlen($basedir) + 1));
        $album_next_js = '&twg_album=' . urlencode(substr($localdir, strlen($basedir) + 1));
    } else {
        $album_next = $album_next_js = '';
    }
    
    if ($nr > $menuxy) {
        if ($paging_use_style) {
            echo '<img class="twg_pag_spacer" height=8 width=1 alt=""  src="' . $install_dir_view . 'buttons/1x1.gif" ><br>';
            echo '<span class="twg_pag">';
        } else {
            echo '<br>';
        }
        
        if ($menuxy == 0 ) {
          $menuxy = 1;
        }
        $numpages = ceil($nr / $menuxy);
        if ($numpages <= $paging_steps) { // we show all
            $paging_num = $paging_steps;
        }
        if ($numpages <= 25) { // 10 Schritte
            $paging_steps = ceil($paging_steps / 2);
        }
        
        if ($twg_foffset_local > 0 && ($twg_foffset_local - $menuxy) < ($numpages * $menuxy)) {
            $twg_back_offset = $twg_foffset_prefix . ($twg_foffset_local - $menuxy);


            if ($twg_back_offset != '' && $twg_back_offset != '0' && $twg_back_offset != '0,0') { // 
                $twg_back_offset = '?twg_foffset=' . $twg_back_offset;
            } else {
                $twg_back_offset = '?';
            }
            $hreflast = getScriptName() . $twg_back_offset . $album_next;
            $hreflast_js = getScriptName() . $twg_back_offset . $album_next_js;
            echo '<script type="text/javascript"> function key_back() { location.href="' . $hreflast_js . $twg_standalonejs . '" } </script>';
            printf(" <a href='%s'>%s</a> ", $hreflast . $twg_standalone, $lang_thumb_back);
            echo $spacer_char;
        } else {
            echo ' <span class="inactive">' . $lang_thumb_back . '</span> ';
        }
       

        for ($i = 0; $i < $numpages; $i++) {
            $twg_foffset_ = $i * ($menuxy);
            $trenner = false;
            if ($twg_foffset_local >= $twg_foffset_ && $twg_foffset_local < $twg_foffset_ + $menuxy) {
                $actpage = $i;
                echo "<a class='sel twg_bold' onclick='return false;' href='#'>" . ($i + 1) . "</a>";
                $trenner = true;
            } else {
                if ((abs($twg_foffset_local - $twg_foffset_) < ($paging_num * $menuxy)) || ($i == $numpages - 1) || ($i == 0) || (($i % $paging_steps) == $paging_steps - 1)) {
                    $twg_act_foffset = $twg_foffset_prefix . $twg_foffset_;
                    if ($twg_act_foffset != '' && $twg_act_foffset != '0' && $twg_act_foffset != '0,0') { //
                        $twg_act_foffset = '?twg_foffset=' . $twg_act_foffset;
                    } else {
                        $twg_act_foffset = '?';
                    }

                    printf("<a href='%s%s%s%s'>%s</a>", getScriptName(), $twg_act_foffset, $album_next, $twg_standalone, $i + 1);
                    $trenner = true;
                }
            }
            if ($trenner && $actpage != $numpages - 1) {
                echo $spacer_char;
            }
        }
        $twg_next_offset = $twg_foffset_prefix . ($twg_foffset_local + $menuxy);
        if (($twg_foffset_local + $menuxy) < ($numpages * $menuxy)) {
            if ($twg_next_offset != '' && $twg_next_offset != '0' && $twg_next_offset != '0,0') { //
                $twg_next_offset = "?twg_foffset=" . $twg_next_offset;
            } else {
                $twg_next_offset = '?';
            }
            $hrefnext = getScriptName() . $twg_next_offset . $album_next;
            $hrefnext_js = getScriptName() . $twg_next_offset . $album_next_js;
            echo '<script type="text/javascript"> function key_foreward() { location.href="' . $hrefnext_js . $twg_standalonejs . '" } </script>';
            printf(" <a href='%s'>%s</a> ", $hrefnext . $twg_standalone, $lang_thumb_forward);
        } else {
            echo ' <span class="inactive">' . $lang_thumb_forward . '</span> ';
        }
        if ($paging_use_style) {
            echo '</span>';
            echo '<br><img height=8 width=1 alt=""  src="' . $install_dir_view . 'buttons/1x1.gif" >';

        }
    }
    if ($basedir != $localdir && $show_subdirs_first) {
        echo '<br>&nbsp;<br>';
    }
    echo '</div>';
    // we return how many rows we twg_show because this is subtracted from the number of images rows twg_show on the same page
    return $numofrows;
    
}

?>