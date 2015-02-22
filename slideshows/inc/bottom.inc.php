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
if ($default_language == 'de') {
    $df = 'de';
} else {
    $df = 'en';
}
if (!$hide_bottom) {
    echo '<tr><td colspan="3" class="twg_bottom">
		<table summary="" class="twg_bottom" width="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td class="bottomtablesideleft "';


    if ($enable_counter) {
        if ($enable_counter_details) {
            if ($enable_counter_details_by_mouseover) {
                echo "onmouseover";
            } else {
                echo "onclick";
            }
            echo '="javascript:show_counter_div(); return false;" onmouseout="javascript:hide_counter_div()">';
        } else {
            echo '>';
        }
        include dirname(__FILE__) . "/../inc/counter.inc.php";
    }

    echo '</td>';

    // This script is completely free for private AND commercial use as long as
    // the visible copyright notice ('powered by TWG') is not removed!
    // If you want to remove the copyright notice you have to register TWG.
    //
    // Please go to the web site http://www.tinywebgallery.com and go to the download
    // section for more details.
    // - Thank you!
    //
    echo '<td class="bottomtable">';
    if (!$d || $show_twg_logo_if_registered) {
        $t_image = create_cache_file(get_server_name(), "sav");
        clearstatcache();
        if (!file_exists($t_image)) {
            echo "<script type='text/javascript'>send_stat(escape('" . get_server_name() . getScriptName() . "'));</script>";
            $fh = fopen($t_image, 'w');
            fclose($fh);
        }
     
        $alink = '<a id="li" target="_blank" href="' . $webpath . '">';
        if ($show_powered_by_twg_as_text) {
            echo $alink;
            echo '<span class="text">Photo Gallery&nbsp;powered&nbsp;by&nbsp;TinyWebGallery&nbsp;' . $CurrentVer . '</span>';
            echo '<img id="byimg" height="15" width="56" alt="powered&nbsp;by&nbsp;TinyWebGallery ' . $CurrentVer . '" title="powered&nbsp;by&nbsp;TinyWebGallery ' . $CurrentVer . '" src="' . $install_dir_view . 'buttons/twg.gif">';
            echo "</a>";
            if ($show_translator && $lang_translator != "&nbsp;") {
                echo "<small>" . convertSpaces($lang_translator) . "</small>";
            }
        } else {
            if ($show_translator && $lang_translator != "&nbsp;") {
                echo "</td><td class='bottomtable' style='width:" . ((strlen($lang_translator) * 5) + 58) . "px;text-align:right'>";
            }
            echo $alink;
            echo '<img height="15" width="56" alt="powered&nbsp;by&nbsp;TinyWebGallery ' . $CurrentVer . '" title="powered&nbsp;by&nbsp;TinyWebGallery ' . $CurrentVer . '" src="' . $install_dir_view . 'buttons/twg.gif">';
            echo '</a>';
            if ($show_translator && $lang_translator != "&nbsp;") {
                echo "</td><td class='bottomtable' style='white-space:nowrap;text-align:left'><small><span style=\"white-space: nowrap;\">" . convertSpaces($lang_translator) . "</span></small></td><td>";
            }
        }
    } else {
        echo "&nbsp;"; // if you are registered you can enter some text here or show the bottom navigation buttons
        if (isset($show_navigation_buttons_on_bottom) && $show_navigation_buttons_on_bottom && ($image != false)) {
            include dirname(__FILE__) . "/topnavigation_buttons.inc.php";
        } else {
           echo "<style>td.bottomtableside, td.bottomtablesideleft { width: auto; }</style>";
        }
        echo "&nbsp;";
    }


    echo '</td>
		<td class="bottomtableside">';

    if (!$cache_dirs) {
        if (!$hoverjs) {
            echo '<script type="text/javascript" src="' . $install_dir_view . 'js/overlib_mini.js"><!-- overLIB (c) Erik Bosrup --></script>';
        }

        echo '<a href="' . tfu_seo_rewrite_url($twg_root . '?' . $album_param . 'twg_enable_session_cache=true' . $twg_standalone) . '" onmouseover="return overlib(\'The internal caching of TWG is disabled. This is fine if you are setting up the gallery. But if you are done with that please set the parameter $cache_dirs in the my_config.php to true for best performance. If you using TWG admin please set <i>Enable session caching of directorys and files</i> to true.<br>Please read howto 43 if you want to know how caching works in TWG.<br>Click to enable the caching for this session. \', HAUTO, VAUTO);" onmouseout="return nd();">';
        echo '<span class="twg_nocache">No Cache!</span>';
        echo '</a>';
        if (($test_client_connection && $show_bandwidth_icon && !$input_invalid) || $show_help_link) {
            echo '&nbsp;|&nbsp;';
        }
    }
    echo '<noscript><span class="twg_nojs">JavaScript</span><img height="0" width="0" src="' . $install_dir_view . 'image.php?twg_nojs=true" alt="" >&nbsp;|&nbsp;</noscript>';

    if ($test_client_connection && $show_bandwidth_icon && !$input_invalid) {
        echo '<a rel="nofollow"  href="' . tfu_seo_rewrite_url($twg_root . '?' . $album_param . 'twg_reset_bandwidth=true' . $twg_standalone) . '">';
        if (isset($_SESSION["twg_lowbandwidth"])) {
            if ($twg_mobile) {
                if (!isset($lang_mobile)) { // todo replace in 1.7.8
                    $lang_mobile = "Mobile mode";
                }
                echo '<img class="twg_sprites mbw_gif" alt="' . $lang_mobile . '" title="' . $lang_mobile . '" src="' . $install_dir_view . 'buttons/1x1.gif" >';
            } else if ($lowbandwidth == "TRUE") {
                echo '<img class="twg_sprites lbw_gif" alt="' . $lang_lowbandwidth . '" title="' . $lang_lowbandwidth . '" src="' . $install_dir_view . 'buttons/1x1.gif" >';
            } else if ($lowbandwidth == "HIGH") {
                echo '<img class="twg_sprites vhbw_gif" height="7px" width="16px" alt="' . $lang_highbandwidth . '" title="' . $lang_highbandwidth . '" src="' . $install_dir_view . 'buttons/1x1.gif" >';
            } else {
                echo '<img class="twg_sprites hbw_gif" height="7px" width="16px" alt="' . $lang_highbandwidth . '" title="' . $lang_highbandwidth . '" src="' . $install_dir_view . 'buttons/1x1.gif" >';
            }
        } else {
            echo '<img class="twg_sprites nbw_gif"  alt="" title="" src="' . $install_dir_view . 'buttons/1x1.gif" >';
        }
        echo '</a>';
    }
    if ($show_help_link) {
        if ($test_client_connection && $show_bandwidth_icon && !$input_invalid) {
            echo "&nbsp;|&nbsp;";
        }
        if ($default_language == 'de') {
            $df = 'de';
        } else {
            $df = 'en';
        }
        echo '<a target="_blank" href="' . $webpath . '/' . $df . '/userhelp.php">' . $lang_help . '</a>';
    }
    echo '
		</td>
		</tr>
		</table>
		</td>';
    echo '</tr>';
}
if ($myborder != 'TRUE') {
    includeBottom($enable_external_html_include, $colspan);
}
echo '</table>';

if ($myborder == 'TRUE') {
    echo "
		</td>
		<td class='sideframe'>";
    if ($enable_album_tree) {
        echo "<img align='left' alt='' style='border:none;padding:0;margin:0;'  height='1' width='20' src='" . $install_dir_view . "buttons/1x1.gif' >";
    }
    echo '</td>';

    echo '</tr>';
    includeBottom($enable_external_html_include, $colspan);
    if (!$leftinclude) {
        includeFooter($enable_external_html_include, $colspan);
    }
    echo "
		</table>";
}
$righthtml = dirname(__FILE__) . '/../right.htm';
if ($leftinclude && file_exists($righthtml)) {
    echo '</td><td class="twg_righthtml" style="width:' . $right_htm_width . 'px;">';
    include $righthtml;
}
?>