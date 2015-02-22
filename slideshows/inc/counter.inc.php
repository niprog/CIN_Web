<?php
// ##############################################
// Written by Andreas Schädler 2004 v.1.0      #
// www.syriel.de                               #
// Dieser Script darf frei verwendet und       #
// verändert werden, solange dieser Hinweis    #
// erhalten bleibt.                            #
// #
// Bei Benutzung wäre eine kurze mail mit der  #
// URL nett. Natürlich werdet ihr dann verlinkt#
// admin@syriel.de                             #
// #
// Achtung: Ich gebe keine Installationshilfe! #
// zu 50% für TWG verändert :)                 #
// alle fontsachen raus, da diese alle vom     #
// stylesheet der aufrufeseite kommen          #
// ##############################################

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
$startmenge = "0"; //Ab welcher besucherzahl soll der counter zählen?
if (!isset($min)) {
    $min = 5; //Wie viele min. gilt ein besucher als ein Zugriff?
}

$fileuseronline = "/useronline.txt";
$fileip_data = "/ip_data.txt";
$fileuserlog = "/user_log.txt"; // this name is used in the image.php as well - change both to the same value if you change it here :) !!
$fileusertoday = "/user_today.txt";
$filecounter = "/counter.txt";
$filecounterb = "/counter_backup.txt";

$heutestyle = $lang_today; //Anzeige von Besucher Heute
if ($show_today_counter) {
    $gesamtstyle = $lang_visitor . "  " . $lang_total; //Anzeige von Besucher Gesamt
} else {
    $gesamtstyle = $lang_visitor . "&nbsp;";
}
$datei = $counterdir . $fileuseronline;

$time = time() - $min * 60;
$current_ip = $_SERVER['REMOTE_ADDR'];

if (file_exists($datei)) {
    $lines = file($datei);
    foreach ($lines as $key => $data) {
        if (strpos($data, "µ") !== false) {
            list($ip, $timest) = explode("µ", $data);
            if (trim($timest) < $time || trim($ip) == $current_ip) {
                unset($lines[$key]);
            }
        }
    }
}
$lines[] = $current_ip . "µ" . time() . "\n";
$save = implode("", $lines);
$handle = fopen($datei, "w");
fputs($handle, $save);
fclose($handle);
$user = count($lines);

$file = $counterdir . $fileip_data;
if (!file_exists($file)) {
    $handle = fopen($file, "w+");
    fclose($handle);
}

$duration = $min * 60;
$lines = file($file);
$ips = null;
foreach ($lines as $line) {
    @list($ip, $time) = @explode("µ", $line);
    if (isset($ip) && isset($time)) {
        if ($time > time() - $duration) {
            $ips[$ip] = trim($time);
        }
    }
}
$ip = $_SERVER['REMOTE_ADDR'];
if (@array_key_exists($ip, (array)$ips)) {
    if ($ips[$ip] > time() - $duration) {
        // TRUE
        $ips[$ip] = time();
        $was_here = true;
    }
} else {
    $ips[$ip] = time();
    $was_here = false;
}
if ($fp = @fopen($file, "w")) {
    foreach ($ips as $ip => $time) {
        @fputs($fp, $ip . "µ" . $time . "\n");
    }
    @fclose($fp);
}

$tag = date("d");
$monat = date("m");
$jahr = date("Y");
$date = getdate();
$zeit = time();

$file_today = $counterdir . $fileusertoday;
$neuer_tag_setzen = "n";
$count = "1";
if (!file_exists($file_today)) {
    $handle = fopen($file_today, "w+");
    $generatecounter = true;
    fclose($handle);
} else {
    $datei = file($file_today);
    $index1 = "0";
    while ($index1 < count($datei)) {
        $dat = explode("&", $datei[$index1]);
        if ($dat[0] < $tag or $dat[1] != $monat or $dat[2] != $jahr) {
            $neuer_tag_setzen = "j";
            $dateilog = fopen($counterdir . $fileuserlog, "a+");
            $generatecounter = true;
            if (is_numeric($dat[0])) {
                fputs($dateilog, "$dat[0]&$dat[1]&$dat[2]&$dat[3]&\n");
            }
            fclose($dateilog);
        } else {
            $neuer_tag_setzen = "n";
            if (!$was_here) {
                $count = $dat[3] + 1;
            } else {
                $count = $dat[3];
            }
        }
        $index1++;
    }
}

if ($neuer_tag_setzen == "j") {
    $datei = fopen($file_today, "w+");
    fputs($datei, "$tag&$monat&$jahr&1&");
    fclose($datei);
}

if ($neuer_tag_setzen == "n" && !$was_here) {
    if (is_numeric($tag)) {
        $datei = fopen($file_today, "w+");
        fputs($datei, "$tag&$monat&$jahr&$count&");
        fclose($datei);
    }
}

$dateiname = $counterdir . $filecounter;
$dateinameb = $counterdir . $filecounterb;
if (!$was_here) {
    $zaehler = (integer)0;
    if (file_exists($dateiname)) {
        // first we make a backup! if the counterfile is > 0! else we use the backup!
        if (filesize($dateiname) > 0) {
            copy($dateiname, $dateinameb);
        } else {
            // somethin seems wrong + we try to use the backup
            @unlink($dateiname);
            if (file_exists($dateinameb)) {
                copy($dateinameb, $dateiname);
            } else { // we make new file of the copy if the backup failed.
                $dateiw = fopen($dateiname, "w+");
                fwrite($dateiw, 1);
                fclose($dateiw);
            }
        }
        $dateir = fopen($dateiname, "r");
        $zaehler = (integer) fgets($dateir, 20);
        $closed = fclose($dateir);
    }

    $zaehler++;
    $dateiw = fopen($dateiname, "w+");
    fwrite($dateiw, $zaehler);
    fclose($dateiw);
    $total = $zaehler + $startmenge;
} else {
    $zaehler = file_get_contents($dateiname);
    $total = $zaehler + $startmenge;
}

if ($show_counter) {
    echo $gesamtstyle . $total . "&nbsp;";
    if ($show_today_counter) {
        echo $heutestyle . $count;
    }
}
// The variable $user would show the current online users.
?>