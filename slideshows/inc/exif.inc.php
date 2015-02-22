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

function show_exif_info($filename)
{
    global $lang_exif_info;
    global $lang_exif_not_available;

    set_error_handler("on_error_no_output"); // is needed because error are most likly but we don't care about fields we don't even know
    $er = new phpExifReader($filename);
    $er->processFile();
    $exif_info = $er->getImageInfo();
    set_error_handler("on_error");
    // odd behaviour patches here
    if (!isset($exif_info['fnumber'])) {
        if (isset($exif_info['aperture'])) {
            $exif_info['fnumber'] = "f/" . round($exif_info['aperture'], 1);
        }
    }
    if (!isset($exif_info['exposureTime'])) {
        if (isset($er->ImageInfo[TAG_SHUTTERSPEED]) && $er->ImageInfo[TAG_SHUTTERSPEED] != 0) {
            $exif_info['exposureTime'] = round($er->ImageInfo[TAG_SHUTTERSPEED], 3) . " s (1/" . (int)(1 / $er->ImageInfo['TAG_SHUTTERSPEED']) . ")";
        }
    } else {
        $exifsplit = split("\(", $exif_info['exposureTime']);
        if (isset($exifsplit[2])) {
            $exif_info['exposureTime'] = $exifsplit[0] . " (" . $exifsplit[2];
        } else {
            $exif_info['exposureTime'] = $exifsplit[0] . " (" . $exifsplit[1];
        }
    }

    if (isset($exif_info['focalLength'])) {
        $exif_info['focalLength'] = round(substr($exif_info['focalLength'], 0, strpos($exif_info['focalLength'], '(')), 1) . " mm";
    }

    if (function_exists("exif_read_data") && is_exif_image($filename)) {
        $gps_array = gps_exif($filename);
        if (isset($gps_array["GPSVersion"])) {
            echo "<tr class='gray'><td class='fileinfoleftbottom'>GPS</td><td class='fileinforightbottom'>";
            create_gps_url($gps_array);
            echo "</td></tr>";
        }
    }

    // print all to get the offsets
    // debug(print_r ($exif_info,true ));

    foreach ($lang_exif_info as $label => $key) {
        if (!isset($exif_info[$key])) {
            $data = $lang_exif_not_available;
        } else {
            if (($exif_info[$key] != "0") && trim($exif_info[$key]) != "") {
                $data = $exif_info[$key];
            } else {
                $data = $lang_exif_not_available;
            }
        }
        print "<tr class='gray'><td class='fileinfoleftbottom'>$label</td><td class='fileinforightbottom'>" . cut_info_str(trim($data)) . "</td></tr>";
    }
}


function ConvertFractionToDecimal($fraction)
{
    $result = "";
    if (isset($fraction)) {
        eval ("\$result = 1.0*$fraction;");
    }
    return $result;
}

function ExifConvertDegMinSecToDD($deg, $min, $sec)
{
    $dec_min = ($min * 60.0 + $sec) / 60.0;
    $result = ($deg * 60.0 + $dec_min) / 60.0;
    return $result;
}

function gps_exif($filename)
{
    $exif_data = array();

    set_error_handler("on_error_no_output"); // is needed because error are most likly but we don't care about fields we don't even know
    $rawexif = @exif_read_data($filename, 0, true);
    set_error_handler("on_error");
    // GPS Stuff
    if (isset($rawexif['GPS']['GPSLongitude']) && isset($rawexif['GPS']['GPSLatitude'])) {
        // It is used a a flag that TWG has written and modified some stuff.
        $exif_data['GPSVersion'] = 'TWG';

        $deg = ConvertFractionToDecimal($rawexif['GPS']['GPSLatitude'][0]);
        $min = ConvertFractionToDecimal($rawexif['GPS']['GPSLatitude'][1]);
        $sec = ConvertFractionToDecimal($rawexif['GPS']['GPSLatitude'][2]);
        $exif_data['GPSLatitude'] = ExifConvertDegMinSecToDD($deg, $min, $sec);
        $exif_data['GPSLatitudeRef'] = $rawexif['GPS']['GPSLatitudeRef'];

        $deg = ConvertFractionToDecimal($rawexif['GPS']['GPSLongitude'][0]);
        $min = ConvertFractionToDecimal($rawexif['GPS']['GPSLongitude'][1]);
        $sec = ConvertFractionToDecimal($rawexif['GPS']['GPSLongitude'][2]);
        $exif_data['GPSLongitude'] = ExifConvertDegMinSecToDD($deg, $min, $sec);
        $exif_data['GPSLongitudeRef'] = $rawexif['GPS']['GPSLongitudeRef'];
    }
    return $exif_data;
}

function create_gps_url($exif)
{
    global $default_language;
    if (isset($exif['GPSVersion'])) {
        echo "<a href=\"http://maps.google.com/maps?q=";
        echo $exif['GPSLatitudeRef'];
        echo $exif['GPSLatitude'];
        echo ",+";
        echo $exif['GPSLongitudeRef'];
        echo $exif['GPSLongitude'];
        echo "&spn=0.0,0.0&t=h&hl=" . $default_language . "\" target=\"_blank\">Google Maps</a>";
    }
}

?>