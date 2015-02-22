<?php

$hideLeftDummy = ($twg_mobile &&  !$twg_mobile_show_breadcrumb && !$twg_mobile_show_menu_items);

// this is to center all images on the top
if ($show_slideshow && !$hideLeftDummy) {
    printf("<img src='%sbuttons/1x1.gif' width='31' height='1' alt='' >&nbsp;&nbsp;", $install_dir_view);
}
if ($show_print_icon) {
    printf("<img src='%sbuttons/1x1.gif' width='31' height='1' alt='' >&nbsp;&nbsp;", $install_dir_view);
}
if ($show_last_next_album && $show_up_button) {
    $last_album = get_last_album($basedir, $twg_album);
    if ($last_album != '') {
        $button = $install_dir_view . 'buttons/ordner_small_last.png';
        $icon_set_button = $install_dir_view . 'buttons/iconsets/' . $icon_set . '/ordner_small_last.png';
        if (file_exists($icon_set_button)) {
            $button = $icon_set_button;
        }
        $hreffirsta = getScriptName() . '?twg_album=' . urlencode($last_album) . '&amp;twg_show=x' . $twg_standalone;
        printf("<a href='%s'><img class='twg_buttons menu_left_gif'  height='24px' width='22px'  src='%s' alt='%s' title='%s' id='topfirst'></a>", tfu_seo_rewrite_url($hreffirsta), $button, $lang_last_album, $lang_last_album);
    } else {
        printf("<img src='%sbuttons/1x1.gif' width='22' height='1' alt='' >&nbsp;&nbsp;", $install_dir_view);
    }
}

if ($show_first_last_buttons) {
    // 1st button
    $hreffirst = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=x' . $twg_standalone;
    printf("<a href='%s'><img class='twg_buttons menu_first_gif'  height='24px' width='22px'  src='%sbuttons/1x1.gif' alt='%s' title='%s' id='topfirst'></a>", tfu_seo_rewrite_url($hreffirst), $install_dir_view, $lang_first, $lang_first);
}
if ($default_big_navigation != "DHTML" && $default_big_navigation != "FLASH") { // || $twg_smallnav == "TRUE"
    if ($last = get_last($twg_album, $image, $current_id)) {
        $hreflast = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $last . $twg_standalone;
        $hreflastjs = getScriptName() . '?twg_album=' . $album_enc . '&twg_show=' . $last . $twg_standalonejs;
        printf("<a href='%s'><img class='twg_buttons menu_left_gif'  height='24px' width='22px' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='topback'  ></a>", tfu_seo_rewrite_url($hreflast), $install_dir_view, $lang_back, $lang_back);
        echo '<script type="text/javascript">';
        echo 'function key_back()     { location.href="' . $hreflastjs . '" } ';
        echo '</script>';
    } else {
        printf("<img src='%sbuttons/1x1.gif' alt='' width='24' height='1' >", $install_dir_view);
    }
} else { // dhtml solution !!
    printf("<span id='backbutton'><a href=\"javascript:key_back();\"><img  height='24px' width='22px' class='twg_buttons menu_left_gif' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='topback' ></a></span>", $install_dir_view, $lang_back, $lang_back);
    echo '<script type="text/javascript">';
    echo 'function key_back()    { if ((lastpos >0) && ready) { location.href="javascript:changeContent(lastpos - 1); setPos(thumbstwg_offset[lastpos]);" }} ';
    echo '</script>';
    if (!get_last($twg_album, $image, $current_id)) {
        echo '<script type="text/javascript">';
        echo 'document.getElementById("backbutton").style.visibility = "hidden";';
        echo '</script>';
    }
    ;
}
// the overview
if ($show_up_button) { // if you want to remove the up button set this to false!
    $twg_offset = get_twg_offset($twg_album, $image, $current_id);
    if ($skip_thumbnail_page) {
        $jump_album = urlencode(getupperdirectory($twg_album));
    } else {
        $jump_album = $album_enc;
    }
    $foffset = $foffsetjs = '';
    if (isset($_SESSION['twg_ses_foffset'])) {
        if ($_SESSION['twg_ses_foffset'] != '') { //  && $_SESSION['twg_ses_foffset'] != '0' && $_SESSION['twg_ses_foffset'] != '0,0'
            $foffset = "&amp;twg_foffset=" . $_SESSION['twg_ses_foffset'];
            $foffsetjs = "&twg_foffset=" . $_SESSION['twg_ses_foffset'];
        }
    } else {
        $foffset = $foffsetjs = "";
    }


    $twg_offset_str = $twg_offset_str_js = '';
    if ($twg_offset != '0') {
        $twg_offset_str = '&amp;twg_offset=' . $twg_offset;
        $twg_offset_str_js = '&twg_offset=' . $twg_offset;
    }
    $jump_album_param = ($jump_album != '') ? ('twg_album='. $jump_album) : '';    
    $param_total = $jump_album_param .$twg_offset_str . $foffset .$twg_standalone;
    $url = getScriptName() . (($param_total != '') ? '?' . $param_total : '');
    $url =  str_replace('?&amp;', '?', $url);     
        
    printf("<a href='%s'><img class='twg_buttons menu_up_gif' height='24px' width='22px' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='topthumb' ></a>", tfu_seo_rewrite_url($url), $install_dir_view, $lang_overview, $lang_overview);
    printf("<script type='text/javascript'> function key_up() { location.href='%s?twg_album=%s%s%s%s'; } </script>", getScriptName(), $jump_album, $twg_offset_str_js, $foffsetjs, $twg_standalonejs);
}
if ($default_big_navigation != "DHTML" && $default_big_navigation != "FLASH") { // || $twg_smallnav == "TRUE"
    if ($next_i = get_next($twg_album, $image, $current_id)) {
        $hrefnext = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $next_i . $twg_standalone;
        $hrefnextjs = getScriptName() . '?twg_album=' . $album_enc . '&twg_show=' . $next_i . $twg_standalonejs;
        printf("<a href='%s'><img class='twg_buttons menu_right_gif'  height='24px' width='22px' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='topnext' ></a>", tfu_seo_rewrite_url($hrefnext), $install_dir_view, $lang_forward, $lang_forward);
        echo '<script type="text/javascript">';
        echo 'function key_foreward()     { location.href="' . $hrefnextjs . '" } ';
        echo '</script>';
    } else {
        printf("<img src='%sbuttons/1x1.gif' alt='' width='24' height='1' >", $install_dir_view);
    }
} else { // dhtml solution!
    printf("<span id='nextbutton'><a href=\"javascript:key_foreward(); \"><img  height='24px' width='22px'  class='twg_buttons menu_right_gif' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='topnext' ></a></span>", $install_dir_view, $lang_forward, $lang_forward);
    echo '<script type="text/javascript">';
    echo 'function key_foreward()     { if (lastpos <(thumbs.length-1) && ready) { location.href="javascript:changeContent(lastpos + 1); setPos(thumbstwg_offset[lastpos]);" } else if (lastpos <(thumbs.length) && ready) { location.href="javascript:changeContent(lastpos + 1);" } } ';
    echo '</script>';
    if (!get_next($twg_album, $image, $current_id)) {
        echo '<script type="text/javascript">';
        echo 'document.getElementById("nextbutton").style.visibility = "hidden";';
        echo '</script>';
    }
    ;
}
if ($show_first_last_buttons) {
    // last button
    $end = get_end($twg_album);
    $hrefend = getScriptName() . '?twg_album=' . $album_enc . '&amp;twg_show=' . $end . $twg_standalone;
    printf("<a href='%s' ><img class='twg_buttons menu_last_gif'  height='24px' width='22px' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='topend' ></a>", tfu_seo_rewrite_url($hrefend), $install_dir_view, $lang_last, $lang_last);
}
if ($show_last_next_album && $show_up_button) {
    $next_album = get_next_album();
    if ($next_album != '') {
        $button = $install_dir_view . 'buttons/ordner_small_next.png';
        $icon_set_button = $install_dir_view . 'buttons/iconsets/' . $icon_set . '/ordner_small_next.png';
        if (file_exists($icon_set_button)) {
            $button = $icon_set_button;
        }
        $hreffirsta = getScriptName() . '?twg_album=' . urlencode($next_album) . '&amp;twg_show=x' . $twg_standalone;
        printf("<a href='%s'><img class='twg_buttons menu_right_gif' src='%s'  height='24px' width='22px' alt='%s' title='%s' id='topfirst'></a>", tfu_seo_rewrite_url($hreffirsta), $button, $lang_next_album, $lang_next_album);
    } else {
        printf("<img src='%sbuttons/1x1.gif' width='22' height='1' alt='' >&nbsp;&nbsp;", $install_dir_view);
    }
}
if ($show_slideshow) {
    if ($twg_slideshow) {
        // the slidestop=true is only needed to find this link with javascript and be able to excange this
        // dynamically -> if a user stop the slidtwg_show we can jump to the actual twg_shown picture !!
        $sl_stop_href =  getScriptName() . '?twg_album='.$album_enc.'&amp;twg_show='.$image_enc .$twg_standalone;
        printf("&nbsp;&nbsp;<a id='stop_slideshow' href='%s'><img  height='24px' width='31px' class='twg_buttons menu_stop_gif' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='stop_slideshow_img'></a>",  tfu_seo_rewrite_url($sl_stop_href), $install_dir_view, $lang_stop_slideshow, $lang_stop_slideshow);
    } else {
       $sl_href =  getScriptName() . '?twg_album='.$album_enc.'&amp;twg_show='.$image_enc.'&amp;twg_slideshow=true' .$twg_standalone;
        printf("&nbsp;&nbsp;<a id='start_slideshow' href='%s'><img  height='24px' width='31px' class='twg_buttons menu_start_gif' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='slideshow'  ></a>", tfu_seo_rewrite_url($sl_href), $install_dir_view, $lang_start_slideshow, $lang_start_slideshow);
    }
}
if ($show_print_icon) {
    printf("<a  onfocus='blur();' onClick='printme(\"defaultslide\"); return false' href='#print'><img  height='24px' width='22px' class='twg_buttons print_gif' src='%sbuttons/1x1.gif' alt='%s' title='%s' id='print' ></a>", $install_dir_view, $lang_print, $lang_print);
}
?>