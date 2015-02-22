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
// German Language Module for TWG Admin
global $_VERSION;
global $password_file;
global $url_file;

$GLOBALS["charset"] = "utf-8"; // use "iso-8859-1" to be 1.5 compatible
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "d.m.Y H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "Fehler",
	"back"			=> "Zur&uuml;ck",

	// root
	"home"			=> "Das Home-Verzeichnis existiert nicht, kontrolliere deine Einstellungen.",
 	"homeroot" => "Das Home-Verzeichnis kann nicht erreicht werden. Einige Systeme erlauben es nicht, dass TWG Admin auf das Hauptverzeichnis zugreift. Dieses System scheint dieses Problem zu haben. Bitte installiert TWG in ein Unterverzeichnis, wenn ihr TWG Admin benutzen wollt.",
 	"abovehome"		=> "Das aktuelle Verzeichnis darf nicht h&ouml;her liegen als das Home-Verzeichnis.",
	"targetabovehome"	=> "Das Zielverzeichnis darf nicht h&ouml;her liegen als das Home-Verzeichnis.",

	// exist
	"direxist"		=> "Dieses Verzeichnis existiert nicht.",
	"filedoesexist"	=> "Diese Datei existiert bereits.",
	"fileexist"		=> "Diese Datei existiert nicht.",
	"itemdoesexist"		=> "Dieses Objekt existiert bereits.",
	"itemexist"		=> "Dieses Objekt existiert nicht.",
	"targetexist"		=> "Das Zielverzeichnis existiert nicht.",
	"targetdoesexist"	=> "Das Zielobjekt existiert bereits.",

	// open
	"opendir"		=> "Kann Verzeichnis nicht &ouml;ffnen.",
	"readdir"		=> "Kann Verzeichnis nicht lesen",

	// access
	"accessdir"		=> "Zugriff auf dieses Verzeichnis verweigert.",
	"accessfile"		=> "Zugriff auf diese Datei verweigert.",
	"accessitem"		=> "Zugriff auf dieses Objekt verweigert.",
	"accessfunc"		=> "Zugriff auf diese Funktion verweigert.",
	"accesstarget"		=> "Zugriff auf das Zielverzeichnis verweigert.",

	// actions
	"permread"		=> "Rechte lesen fehlgeschlagen.",
	"permchange"	=> "Rechte &auml;ndern fehlgeschlagen.",
	"openfile"		=> "Datei &ouml;ffnen fehlgeschlagen.",
	"savefile"		=> "Datei speichern fehlgeschlagen.",
	"createfile"	=> "Datei anlegen fehlgeschlagen.",
	"createdir"		=> "Verzeichnis anlegen fehlgeschlagen.",
	"uploadfile"	=> "Datei hochladen fehlgeschlagen.",
  "isuploadfile"  => "Kontrolle des Hochladens der Datei fehlgeschlagen .",
  "missingtemp"   => "Tempor&auml;res Verzeichnis fehlt.",
	"copyitem"		=> "Kopieren fehlgeschlagen.",
	"moveitem"		=> "Verschieben fehlgeschlagen.",
	"delitem"		=> "L&ouml;schen fehlgeschlagen.",
	"chpass"		=> "Passwort &auml;ndern fehlgeschlagen.",
	"deluser"		=> "Benutzer l&ouml;schen fehlgeschlagen.",
	"adduser"		=> "Benutzer hinzuf&uuml;gen fehlgeschlagen.",
	"saveuser"		=> "Benutzer speichern fehlgeschlagen.",
	"searchnothing"		=> "Schon mal was gefunden, wenn man nicht wusste wonach man suchst?",

	// misc - Javascript!
	"miscnofunc"		=> "Funktion nicht vorhanden.",
	"miscfilesize"		=> "Datei ist größer als die maximale Größe.",
	"miscfilepart"		=> "Datei wurde nur zum Teil hochgeladen.",
	"miscnoname"		=> "Man muss einen Namen eintragen",
	"miscselitems"		=> "Du hast keine Objekt(e) ausgewählt.",
	"miscdelitems"		=> "Sollen die \"+num+\" markierten Objekt(e) gelöscht werden?",
	"miscdeluser"		=> "Soll der Benutzer '\"+user+\"' gelöscht werden?",
	"miscnopassdiff"	=> "Das neue und das heutige Passwort sind nicht verschieden.",
	"miscnopassmatch"	=> "Passwörter sind nicht gleich.",
	"miscfieldmissed"	=> "Du hast vergessen ein wichtiges Eingabefeld auszufüllen",
	"miscnouserpass"	=> "Benutzer oder Passwort unbekannt.",
	"miscselfremove"	=> "Man kann sich selbst nicht löschen.",
	"miscuserexist"		=> "Der Benutzer existiert bereits.",
	"miscnofinduser"	=> "Kann Benutzer nicht finden.",
	"extract_noarchive" => "Dieses Datei ist leider kein Archiv.",
	"extract_unknowntype" => "unbekannter Archivtyp!",

// TWG extensions
  "error_savemode" => "Der Safemode ist auf diesem System aktiviert.</b><br>Falls ein Fehler nicht genauer erl&auml;utert wird, ist dies meist der Grund warum dieser Fehler kommt.",
  "error_debug_empty" => "Bitte &uuml;berpr&uuml;fe die Debug-Datei. Sie sollte leer sein, wenn TWG optimal l&auml;uft",
  "userfile" => "Benutzerdatei ist ",
  "admin_ok" => "<b><font color='green'>beschreibbar</font></b> - Man kann Benutzer verwalten und deren Passw&ouml;rter &auml;ndern.",
  "admin_not_writeable" => "<b><font color='red'>nicht beschreibbar</font></b> - bitte &uuml;berpr&uuml;fe die Info-Seite.",
  "admin_not_available" => "<b><font color='red'>nicht verf&uuml;gbar</font></b> - bitte &uuml;berpr&uuml;fe die Info-Seite.",
  "users_file_missing" => "Die Benutzerdatei \"admin/_config/.htusers.php\" existiert nicht.\\n Falls man ein Update mit Dateien vom Installer durchgef&uuml;hrt hat, \\nwurden wohl nicht alle Dateien aus dem Verzeichnis\\ninstall_twg.zip kopiert. Man findet die ben&ouml;tigten Dateien \\nin diesem Ordner. Bitte kopiere mindestens die Benutzer-Datei \\nin den Admin-Ordner!",
  "rename_not" => "Umbennen von '%s' nach '%s' fehlgeschlagen",
  "multiplefolder" => "Sie haben beim Verzeichnis einen | eingegeben. Dies ist das Trennzeichen, um mehrere Verzeichnisse anzugeben. Diese ist nur bei Benutzern mit Frontendrechten erlaubt.",
  "error_twglic" => "Die Lizenzdatei für TWG - twg.lic.php besteht nicht aus genau 5 Zeilen.\\nBitte entferne leere Zeilen vor und nach dem <?php und nach dem ?>.\\nAnsonsten wird TWG nicht richtig funktionieren!",
  "nosession" => "Es scheint, dass die Session nicht funktioniert. Das bedeutet, dass man gleich nach dem Anmelden wieder abgemeldet wird. Bitte kontaktiert euren Hoster um die php Installation zu &uuml;berpr&uuml;fen. Bei einem eigenen Server sollte man die session.save_path Variable &uuml;berpr&uuml;fen und Howto 53 der TWG FAQ lesen."
);

$GLOBALS["messages"] = array(
	// links
	"simpleview"	=> "Einfache Ansicht",
  "normalview"	=> "Normale Ansicht",
  "gonormalview" => "Gehe zur normalen Ansicht, die alle Dateien zeigt.",
  "gosimpleview"  => "Gehe zur einfachen Ansicht, die nur wichtige Dateien Zeigt.",
  "hidden"		=> " versteckt ",
	"permlink"		=> "Rechte &auml;ndern",
	"editlink"		=> "Bearbeiten",
	"downlink"		=> "Herunterladen",
	"uplink"		=> "H&ouml;her",
	"homelink"		=> "Home",
	"reloadlink"		=> "Aktualisieren",
	"copylink"		=> "Kopieren",
	"movelink"		=> "Verschieben",
	"dellink"		=> "L&ouml;schen",
	"comprlink"		=> "Archivieren",
	"adminlink"		=> "Administration",
	"logoutlink"		=> "Abmelden",
	"uploadlink"		=> "Hochladen",
	"searchlink"		=> "Suchen",
	"extractlink"	=> "Entpacken",
	'chmodlink'		=> 'Rechte (chmod) &auml;ndern (Verzeichnis)se)/Datei(en))', // new mic
 'logolink' => '&ouml;ffne die TWG Webseite (neues Fenster)', // new mic
	// list
	"nameheader"		=> "Name",
	"sizeheader"		=> "Gr&ouml;&szlig;e",
	"typeheader"		=> "Typ",
	"modifheader"		=> "Ge&auml;ndert",
	"permheader"		=> "Rechte",
	"actionheader"		=> "Aktionen",
	"pathheader"		=> "Pfad",

	// buttons
	"btncancel"		=> "Abbrechen",
	"btnback"		=> "Zur&uuml;ck",
	"btnsave"		=> "Speichern",
	"btnchange"		=> "&Auml;ndern",
	"btnreset"		=> "Zur&uuml;cksetzen",
	"btnclose"		=> "Schlie&szlig;en",
	"btncreate"		=> "Anlegen",
	"btnsearch"		=> "Suchen",
	"btnupload"		=> "Hochladen",
	"btncopy"		=> "Kopieren",
	"btnmove"		=> "Verschieben",
	"btnlogin"		=> "Anmelden",
	"btnlogout"		=> "Abmelden",
	"btnadd"		=> "Hinzuf&uuml;gen",
	"btnedit"		=> "&Auml;ndern",
	"btnremove"		=> "L&ouml;schen",

	// user messages, new in joomlaXplorer 1.3.0
	'renamelink'	=> 'Umbenennen',
	'confirm_delete_file' => 'Sicher, dass die Datei gel&ouml;scht werden soll? \\n%s',
 'confirm_delete_dir' => 'Sicher, dass das Verzeichnis \\n%s? gel&ouml;scht werden soll?\\nAlle Inhalte werden gel&ouml;scht.',
	'success_delete_file' => 'Die Datei(en) bzw. Verzeichnis(se) wurden gel&ouml;scht.',
	'success_rename_file' => 'Das Verzeichnis / die Datei %s wurde erfolgreich in %s unbenannt.',
 'success_upload_file' => '%s Datei(en) erfolgreich hochgeladen.',

	// actions
	"actdir"		=> "Verzeichnis",
	"actperms"		=> "Rechte &auml;ndern",
	"actedit"		=> "Datei bearbeiten",
	"actsearchresults"	=> "Suchergebnisse",
	"actcopyitems"		=> "Objekt(e) kopieren",
	"actcopyfrom"		=> "Kopiere von /%s nach /%s ",
	"actmoveitems"		=> "Objekt(e) verschieben",
	"actmovefrom"		=> "Versetze von /%s nach /%s ",
	"actlogin"		=> "Willkommen in der TWG-Administration",
	"actloginheader"	=> "Melde dich an, um die TWG-Administration zu benutzen",
	"actadmin"		=> "Administration",
	"actchpwd"		=> "Passwort &auml;ndern",
	"actusers"		=> "Benutzer",
	"actarchive"		=> "Objekt(e) archivieren",
	"actupload"		=> "Datei(en) hochladen",

	// misc
	"miscitems"		=> "Objekt(e)",
	"miscfree"		=> "Freier Speicher",
	"miscusername"		=> "Benutzername",
	"miscpassword"		=> "Passwort",
	"miscoldpass"		=> "Altes Passwort",
	"miscnewpass"		=> "Neues Passwort",
	"miscconfpass"		=> "Best&auml;tige Passwort",
	"miscconfnewpass"	=> "Best&auml;tige neues Passwort",
	"miscchpass"		=> "&Auml;ndere Passwort",
	"mischomedir"		=> "Home-Verzeichnis<br>(Für Frontend-Benutzer können mehrere Verzeichnisse durch | getrennt angegeben werden)",
	"mischomeurl"		=> "Home URL",
	"miscshowhidden"	=> "Versteckte Objekte anzeigen",
	"mischidepattern"	=> "Filtermuster",
	"miscperms"		=> "Rechte",
 "miscupload" => "Einstellungen TWG Flash Uploader",
	"miscuseritems"		=> "(Name, Home-Verzeichnis, versteckte Objekte anzeigen, Rechte, aktiviert)",
	"miscadduser"		=> "Benutzer hinzuf&uuml;gen",
	"miscedituser"		=> "Benutzer '%s' &auml;ndern",
	"miscactive"		=> "Aktiviert",
	"misclang"		=> "Sprache",
	"miscnoresult"		=> "Suche ergebnislos.",
	"miscsubdirs"		=> "Suche in Unterverzeichnisse",
 "miscpermnames" => array("Nur Frontend Login","Frontend Editieren", "Frontend Upload","Backend &auml;ndern", "Administrator"),
 "miscuploadnames" => array("Alle Funktionen", "Datei upload, ändern, l&ouml;schen", "Datei Upload + Datei l&ouml;schen", "Nur Datei Upload"),
 "miscyesno" => array("Ja","Nein","J","N"),
 "miscchmod" => array("Besitzer", "Gruppe", "Jeder"),

	'miscowner'			=> 'Besitzer',
	'miscownerdesc'		=> '<strong>Erkl&auml;rung:</strong><br>Benutzer (UID) /<br>Gruppe (GID)<br>Aktuelle Besitzerrechte:<br><strong> %s ( %s ) </strong>/<br><strong> %s ( %s )</strong>', // new mic

	'extract_warning' => "Soll diese Datei wirklich entpackt werden? Hier?\\nBeim Entpacken werden evtl. vorhandene Dateien &uuml;berschrieben!",
	'extract_success' => "Das Entpacken des Archivs war erfolgreich.",
	'extract_failure' => "Das Entpacken des Archivs ist fehlgeschlagen.",

 // TWG extensions !!
 'twgtypes' => array(
 "folder.txt" => "TWG Ordner-Beschreibung",
 "folder_xx.txt" => "TWG Ordner-Beschreibung (Sprache)",
 "foldername.txt" => "TWG Album-Name",
 "foldername_xx.txt" => "TWG Album-Name (Sprache)",
 "image.txt" => "TWG Bild-Beschreibung",
 "image_xx.txt" => "TWG Bild-Beschreibung (Sprache)",
 "watermark.txt" => "TWG Wasserzeichen-Text",
 "link.txt" => "TWG externe Link-Adresse",
 "root.txt" => "TWG Link zum Stammverzeichnis",
 $url_file => "TWG URL f&uuml;r externe Bilder",
 "style.css" => "TWG Stylesheet",
 $password_file => "TWG Passwort-Datei",
 "albumr.txt" => "TWG Album-Beschreibung rechts",
 "albumr_xx.txt" => "TWG Album-Beschreibung rechts (Sprache)",
 "albuml.txt" => "TWG Album-Beschreibung links",
 "albuml_xx.txt" => "TWG Album-Beschreibung links (Sprache)"),

 "thumbnail" => "Vorschaubild",
 "resolution" => "Aufl&ouml;sung",
 "passchanged" => "Passwort ge&auml;ndert",
 "filesaved" => "Die Datei %s wurde gespeichert.",
 "adminpass" => "Bitte das Admin Passwort &auml;ndern.",
 "movewarning" => "Wenn man einen Ordner, der Bilder enth&auml;lt kopiert/verschiebt/umbenennt, dann werden die xml Daten nicht mit verschoben oder umbenannt. Dies muss man manuell machen!<br />Wenn man \$autocreate_folder_id = true; setzt wird die Datei folder.id erzeugt, welche dann einen Ordner eindeutig identifiziert und man muss dann nur beim Kopieren die folder.id löschen und die xml Dateien duplizieren wenn gewünscht.",
 "messageperm" => "Rechte wurden ge&auml;ndert.",
 "wronglogin" => "Benutzername oder Passwort ist falsch.",
 "lowpermissions" => "Du hast keine Berechtigung den Admin Bereich zu betreten.<br/>Du darfst aber die Funktionen nutzen, die nach dem Login auf der Hauptseite aktiv werden.",
 "edituser" => "Benutzer bearbeiten",
 "user_help_text" =>  "Man kann Benutzern verschiedene Rechte geben. Bitte beachte, dass die Rechte immer von dem Heim-Verzeichnis des Benutzers ausgehen. Als Standard sollte dieses im pictures Ordner liegen.",
 "user_help_1" => "Frontend bearbeiten = Man kann sich im Frontend anmeldung um &Uuml;berschriften oder Tags zu bearbeiten, Kommentare zu l&ouml;schen, oder um Bilder permanent zu drehen.",
 "user_help_2" => "Frontend Upload = Man kann sich im Frontend anmeldung und Bilder innerhalb des Heim-Verzeichnisses mithilfe des Flash-Uploaders hochladen.",
 "user_help_3" => "Backend ändern = Man kann Dateien im Heim-Verzeichnis mit dem TWGXplorer hochladen und editieren.",
 "user_help_4" => "Administrator = Vollzugriff auf alle Bereiche des TWG Backend (Adminbereich). Verwende . als Ordner für das Hauptverzeichnis.",
 "edit_return" => "Nach dem Speichern zur&uuml;ck zum Verzeichnis?",
 "up_not_detected" => "Maximale Dateigr&ouml;&szlig;e f&uuml;r den Upload nicht erkannt.",
 "up_flash" => "Der TWG Flash Uploader ben&ouml;tigt Flash 8! Falls der Uploader nicht funktioniert, klicke %shier%s um zum alten HTML Upload Formular zu gelangen.",
 "up_quality" => " Qualit&auml;t",
 "up_max" => "Maximale H&ouml;he/Breite des Bildes",
 "up_max_size" => "Maximal erlaubte Dateigr&ouml;&szlig;e f&uuml;r den Upload:  ",
 "up_html" => "Dies ist das normale HTML Formular. Um zum Flash Uploader zu gelangen, klicke %shier.",
 "rename_new" => "Neuer Name:",
 "rename_header" => "Ordner oder Datei umbenennen...",
 "extra_howto" => "Bitte lies das HowTo %s f&uuml;r weitere Infos.<br>Klicke <a target=\'help\' href=\'%s/en/faq.php#h%s\'><b>hier</b></a> um zu ihnen zu gelangen.",
 "extra_safemode" => "Safemode ist auf deinem System aktiviert. Bitte lies die HowTos %s f&uuml;r weitere Informationen &uuml;ber die Probleme, die mit dieser Einstellung einhergehen.<br>Klicke <a target=\'help\' href=\'%s/en/faq.php#h%s\'><b>hier</b></a> um zu ihnen zu gelangen.",
 );

$GLOBALS["menu_messages"] = array(
"help" => "&Uuml;ber/Hilfe",
"twgxplorer" => "TWGXplorer",
"info" => "Info",
"color" => "Farben Manager",
"email" => "Admin E-Mail",
"helper" => "Konfiguration",
"admin" => "Benutzerverwaltung",
"logout" => "Abmelden",

"hello" => "Hallo",
"simplevw" => "Einfache Ansicht",
"normalvw" => "Normale Ansicht",
"uploadima" => "Bilder hochladen",
"splitima" => "Dateien splitten",
"configtwg" => "TWG konfigurieren",
"generatecach" => "Cache erstellen",
"generateprev" => "Vorschau erstellen",
"generateiptc" => "IPTC Daten auslesen",
"clncach" => "Cache leeren",
"generatepassw" => "Passw&ouml;rter erstellen",
"debugfile" => "Fehlerdatei",
"foldovervw" => "Verzeichnis&uuml;bersicht",
"installcheck" =>  "Installationscheck",
"installlcheck" => "Installationscheck",
"permissions" => "Berechtigungen",
"recomsett" => "Empfohlene &nbsp;&nbsp;Einstellungen",
"showphpinfo" => "Zeige phpinfo",
"backtotwg" => "Zur&uuml;ck zur TWG",
"register" => "Registrieren"
);

// twg configuration screen!
$GLOBALS["config_messages"] = array(
"passchanged" => "Passwort erfolgreich ge&auml;ndert",

"noskin" => "Kein Skin",
"admin" => "Admin",
"black" => "Schwarz",
"green" => "Gr&uuml;n",
"newyork" => "New York",
"transparant" => "Transparent",
"winter" => "Winter",
"roundcorners" => "Runde Ecken",
"white" => "Weiss",

"true" => "Ja",
"false" => "Nein",

"optimized" => "Optimiert",
"normal" => "Normal",
"maximized" => "Maximiert",

"fade" => "&Uuml;berblenden",
"grey" => "Grauverlauf",
"change" => "Bildwechsel",
"none" => "Kein Effekt",

"top" => "oben",
"bottom" => "unten",

"htmlside" => "HTML Seite",
"topleft" => "oben-links",
"topcenter" => "oben-mitte",
"topright" => "oben-rechts",
"middleleft" => "mitte-links",
"middlecenter" => "mitte-mitte",
"middleright" => "mitte-rechts",
"bottomleft" => "unten-links",
"bottomcenter" => "unten-mitte",
"bottomright" => "unten-rechts",

"configsaved" => "my_config.php gespeichert.",
"configdeleted" => "my_config.php gel&ouml;scht.",
"debugdeleted" => "Fehlerdatei gel&ouml;scht.",
"nodebugfound" => "Keine Fehlerdatei gefunden.",
"cashdeleted" => "Zwischenspeicher (Cache) gel&ouml;scht.",
"rotationdeleted" => "Rotationsinfo gel&ouml;scht.",
"sessiondeleted" => "Session gel&ouml;scht.",
"previmagegen" => "Vorschaubilder erzeugt. Bitte &uuml;berpr&uuml;fe ob die Dateien auch wirklich da sind. Falls nicht, &uuml;berpr&uuml;fe die Ordnerberechtigung!",
"readiptcmessage" => "IPTC Informationen wurden erfolgreich gelesen und in einer XML-Datei gespeichert."
);

$GLOBALS["config_screen"] = array(
"twgconfig" => "TWG Konfiguration",
"Onthispage" => "Auf dieser Seite findet man einige Funktionen um TWG zu konfigurieren. F&uuml;r mehr Einstellungsm&ouml;glichkeiten bearbeite bitte die config.php. Lies dir vorher die Beschreibung der einzelnen Parameter (entweder in der config.php oder auf der Webseite) durch und sieh dir die HowTos an, um TWG optimal an deine Bed&uuml;rfnisse anzupassen.",
"inthissection" => "In diesem Bereich kann man die Hauptfunktionen von TWG einstellen. Alle &Auml;nderungen die man hier vornimmt, werden in der Datei my_config.php gespeichert.
TWG hat zus&auml;tzlich eine umfangreiche Einstellungsdatei: config.php.
Such dir extra Einstellungen aus der config.php und kopiere diese in den Reiter \"Erweitert\".<br>Alle Einstellungen, die in der my_config.php gemacht werden, &uuml;berschreiben die config.php!",
"configtwg" => "Konfiguriere TWG",
"pleasread" => "Bitte lies auch die",
"becauseyou" => "weil man viele zus&auml;tzliche Einstellungen mit Dateien machen kann, welche man einfach in einen Ordner legt (z.B. folder.txt)!<p><br>Einstellungen, welche vom Standard abweichen sind <span style='color:#0000ff'>blau</span> markiert.</p>",
"confignotwr" => "my_config.php ist nicht beschreibbar. Weitere Details gibt es unter dem Menüpunkt 'Info'.",
"mainfolnotwr" => "Der TWG Hauptordner ist nicht beschreibbar. Weitere Details gibt es unter dem Menüpunkt 'Info'.",
);

$GLOBALS["config_form_block"] = array(
"induvidual" => "Pers&ouml;nlich",
"image" => "Bild",
"fuctionality" => "Allg. Funktionen",
"watermark" => "Wasserzeichen",
"additional" => "Erweitert",
"indivisettings" => "Pers&ouml;nliche Einstellungen",
"changepassw" => "Man sollte das Passwort &auml;ndern, welches auf dieser Seite angezeigt wird. Man kann viele weitere Einstellungen vornehmen. Diese sind in der config.php, oder auf der",
"changepasswl" => "Installationsseite der TWG",
"changepasswll" => " beschrieben. Trage diese Einstellungen in den Reiter \"Erweitert\" ein.",
"protgalpassw" => "Passwort f&uuml;r gesch&uuml;tzte Galerien",
"broutitlperf" => "Titelleistentext",
"defgaltit" => "Titel der TWG",
"skin" => "Skin",
"twgincl" => "Ist TWG in einem IFrame eingebettet?",
"heiiframe" => "H&ouml;he des IFrames f&uuml;r den IE",
"shwbord" => "Zeigt den Rahmen an (links, rechts, unten)?",
"enablesess" => "Sessioncache f&uuml;r Verzeichnisse und Dateien.<br><b>Unbedingt nach dem 1. Setup aktivieren!</b>",
"shwtwglogo" => "Zeigt das TWG Logo trotz Registrierung an",
"enablebasicseo" => "Aktiviere SEO Urls",
"adminsettings" => "TWG Admin Einstellungen",
"adminupload" => "Standart Upload-Methode",
"adminenablesplit" => "Unterst&uuml;tzung f&uuml;r gesplittete Dateien aktivieren",
"adminchecksplit" => "Gesplittete Dateien sind auf diesem Server <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;getestet",

"imagesett" => "Bild Einstellungen",
"adjuimagdis" => "Man kann hier einstellen, wie Bilder in TWG angezeigt werden. Bitte nach dem &Auml;ndern von Einstellungen unbedingt den Cache l&ouml;schen (siehe unten)! Es ist m&ouml;glich, in der config.php oder auf der ",
"adjuimagdisl" => "Installations-Webseite.",
"adjuimagdisll" => "weitere zus&auml;tzliche Einstellungen vorzunehmen. Diese sollten dann in dem 'Erweitert' Tab gespeichert werden. <br>&nbsp;",
"columon" => "Spalten auf der &Uuml;bersichtsseite",
"rowson" => "Zeilen auf der &Uuml;bersichtsseite",
"autodetnu" => "Automatische Erkennung der Anzahl von Vorschaubildern?",
"thumbinrow" => "Anzahl Vorschaubilder in einer Zeile",
"thumbincol" => "Anzahl Vorschaubilder in einer Spalte",
"imageintop" => "Anzahl der Bilder der Top X",
"sizewebima" => "Gr&ouml;&szlig;e der Web-Bilder",
"resizeima" => "Bilder nur &auml;ndern, wenn sie zu gross <br>&nbsp;&nbsp;&nbsp;&nbsp;sind?",
"usesizeofweb" => "Vertikale und horizontale Bilder auf die <br>&nbsp;&nbsp;&nbsp;&nbsp;gleiche H&ouml;he verkleinern?",
"sizeofthumb" => "Gr&ouml;&szlig;e der Vorschaubilder",
"sizeofthumbdet" => "Gr&ouml;&szlig;e der Vorschaubilder auf der Detail-Seite",
"widthofgal" => "Breite der Bilder auf der &Uuml;bersichtsseite",
"heightofgal" => "H&ouml;he der Bilder auf der &Uuml;bersichtsseite",
"clipthethumb" => "Vorschaubilder zuschneiden?",
"showacol" => "Eine Collage mehrerer Bilder auf der &Uuml;bersichtsseite zeigen?",
"userandom" => "Zufallsbilder auf der &Uuml;bersichtsseite verwenden?",
"foldereffect" => "Effekte f&uuml;r die Ordner",
"skipthumb" => "Vorschaubilderseite ausblenden, wenn nicht n&ouml;tig (<= ",
"skipthumbpic" => " Bilder)",

"endisablefunc" => "TWG Funktionen Ein-/Ausschalten",
"youendisablefunc" => "Die meisten Funktionen der TWG k&ouml;nnen hier ein- oder ausgeschaltet werden.
 Es ist m&ouml;glich, in der config.php oder auf der ",
"installpage" => "Installations-Webseite",
"storethem" => "weitere zus&auml;tzliche Einstellungen vorzunehmen. Diese sollten dann in dem 'Erweitert' Tab gespeichert werden.",
"hidebignav" => "Gro&szlig;e Navigationselemente verstecken?",
"defaubignav" => "Voreinstellung f&uuml;r gro&szlig;e Navigation",
"numberofpics" => "Bilder in der gro&szlig;en Navigation",
"noscrolling" => "Kein Scrolling, wenn alle<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vorschaubilder sichtbar sind",
"dhtmlworks" => "AJAX arbeitet wie die HTML-L&ouml;sung",
"showcomment" => "Kommentare anzeigen?",
"showlogin" => "Login-Button anzeigen?",
"showoptions" => "Optionen anzeigen?",
"shownwewin" => "Neues Fenster anzeigen?",
"enabledownl" => "Download anzeigen?",
"showimagerat" => "Bildbewertungen zeigen?",
"showsearch" => "Suche zeigen?",
"showpublic" => "Administrationslink zeigen?",
"showslidesh" => "Diashow anzeigen?",
"slideshowty" => "&nbsp;&nbsp;&nbsp;Voreingestellter Diashow Typ",
"slideshowti" => "&nbsp;&nbsp;&nbsp;Voreinstellung Zeitintervall",
"showcapt" => "Bildunterschriften zeigen?",
"showthecount" => "Z&auml;hler zeigen?",
"showhelpl" => "Link zur Hilfe zeigen?",
"showtitleinf" => "Dateiinformationen zeigen?",
"showrotbut" => "Drehen-Buttons anzeigen?",
"showbandwico" => "Bandbreite-Icon anzeigen?",
"show_topx" => "Top X anzeigen?",
"show_tags" => "Tags anzeigen?",
"enable_album_tree" => "Verzeichnisbaum des Albums anzeigen?",
"big_nav_pos" => "Position",

"watermarkset" => "Einstellungen f&uuml;r Wasserzeichen",
"configwmset" => "Die Konfiguration der Wasserzeichen erfolgt hier. Bitte nach dem &Auml;ndern von Einstellungen unbedingt den Cache l&ouml;schen (siehe unten)!<br/>Es ist m&ouml;glich, in der config.php oder auf der ",
"configwmsetl" => "Installations-Webseite</a>weitere zus&auml;tzliche Einstellungen vorzunehmen. Diese sollten dann in dem 'Erweitert' Tab gespeichert werden. <br>&nbsp;",
"printtextwm" => "Textwasserzeichen verwenden?",
"printtextwmo" => "Textwasserzeichen auf Original verwenden?",
"wmtext" => "Text f&uuml;r Wasserzeichen",
"prntimgwm" => "Bildwasserzeichen verwenden?",
"prntimgwmo" => "Bildwasserzeichen auf Original verwenden?",
"normwm" => "Normales Wasserzeichen",
"wmfororig" => "Wasserzeichen f&uuml;r Originale",
"posimawm" => "Position des Wasserzeichen-Bildes",
"additsett" => "Weitere Einstellungen!",
"twgparamet" => " TWG hat mehr als 400 Parameter, mit denen nahezu alles eingestellt werden kann. Diese Parameter werden auf der ",
"twgparametl" => "Installations-Webseite",
"twgparametll" => " und in der config.php beschrieben (die Datei kann im TWGXplorer ge&ouml;ffnet werden).<p>F&uuml;r &Auml;nderungen an diesen Parametern muss dieser einfach in dieses Textfeld kopiert und entsprechend geändert werden.</p>Der eingetragene Code muss g&uuml;ltiger php-Code sein! TWG Admin pr&uuml;ft diesen Code so gut wie m&ouml;glich. <br/>Ein Beispiel f&uuml;r true/false Parameter ist: ",
"twgparametlll" => "<br/>Ein Beispiel f&uuml;r einen String ist: ",
"twgparametllll" => "<br/>Wenn nicht klar ist, welche Art von Parametern verwendet werden sollte, bitte auf der Webseite nachlesen - die unterschiedlichen Arten werden dort beschrieben!<br>&nbsp;",
"addsave" => "Speichern",
"reallyreset" => "Die Konfiguration wirklich auf die Voreinstellung zur&uuml;cksetzen? (= my_config.php l&ouml;schen)?",
"resetconfig" => "Konfiguration zur&uuml;cksetzen",
// New 1.8
"savemod" => "Nur ge&auml;nderte Einstellungen in der my_config.php speichern",
'icon_set' => 'Icon set',
'autorotate_images' => 'Autorotate verwenden?', 
'autorotate_images_none' => 'Nein',
'autorotate_images_normal' => 'Normal',
'autorotate_images_invert' => 'Invertiert',
'skip_thumbnail_page' => 'Thumbnailseite &uuml;berspringen?', 
'sort_header' => 'Sortierung',
'sort_text' => 'Im nächsten Abschnitt kann man die Sortierung von Bildern und Albums festlegen. Aufsteigend bedeutet, dass A zuerst kommt und für Datums, dass die Neuesten zuerst kommen!<br>Wenn man die Sortierung ändert muss der <a class="aconfig" href="#clean">Sessioncache</a> gelöscht werden!',
'sort_images_ascending' => 'Bilder aufsteigend sortieren?',
'sort_by_date' => 'Bilder nach Datum sortieren?',
'sort_by_filedate' => 'Bilder nach Dateidatum sortieren?',
'sort_albums' => 'Ordner sortieren?',
'sort_albums_ascending' => 'Ordner aufsteigend sortieren?',
'sort_album_by_date' => 'Ordner nach Datum sortieren?',
'open_in_maximized_view' => 'Bilder maximiert öffnen?',
'disable_tips' => 'Alle Tips deaktivieren?',
'link_more' => '(mehr)',
'use_round_corners' => 'Runde Ecken verwenden'
);

$GLOBALS["config_screen_main"] = array(
"gentwgcache" => "TWG Cache erzeugen",
"cachestep" => "Normalerweise wird der Cache bei Bedarf erstellt. Soll der gesamte Cache auf einmal erzeugt werden, nimmt das zwar gegebenenfalls einige Zeit in Anspruch, beschleunigt andererseits die Darstellung f&uuml;r den ersten Besucher!<br/>Auf der rechten Seite wird der Code zum Generieren des Caches erzeugt was bei gro&szlig;en Galerien bis zu 2 Minuten dauert. Es werden immer maximal 5000 Bilder auf einmal erzeugt. Evtl. muss man das ganze mehrfach starten.",
"generateprev" => "Vorschaubilder f&uuml;r andere Dateiformate erstellen",
"displfilefor" => "Um andere Dateiformate als JPG anzuzeigen, m&uuml;ssen Sie Vorschaubilder erzeugen, die in der Galerie angezeigt werden. TWG kann Vorschaubilder (Icons) f&uuml;r bestimmte Dateitypen erstellen. Diese Icons werden mit dem Parameter \$other_file_formats_previews definiert.",
"generatedimag" => " Die erzeugten Bilder werden in dem Verzeichnis gespeichert, das die anderen Dateiformate enth&auml;lt. Bitte sicherstellen, dass f&uuml;r diese Verzeichniss Schreibrechte bestehen.<br>Wenn Sie eigene Vorschaubilder hochgeladen haben, werden diese von TWG nicht &uuml;berschrieben.&nbsp;",
"folderscontai" => "F&uuml;r das Verzeichnis, das die urspr&uuml;nglichen Dateiformate enth&auml;lt, m&uuml;ssen Schreibrechte existieren! Mit dem Generieren beginnen?",
"generateprevl" => "Vorschaubilder erstellen",

"generateiptc" => "Auslesen der IPTC-Daten aus den Bildern",
"iptcleft" => "TWG kann die IPTC-Daten aus den Bildern extrahieren und diese automatisch zur XML-Datei hinzuf&uuml;gen. Es werden drei unterschiedliche Arten von Daten gelesen: Captions, Tags und Verzeichnis-Tags. F&uuml;r Verzeichnis-Tags werden die Unterkategorien der IPTC-Informationen verwendet.",
"iptctext" => "Bitte im Howto nachlesen, wie die IPTC-Daten in XML-Dateien transferiert werden. Wenn die Bilder mit dem Flash Uploader hochgeladen wurden, wurden die Tags bereits ausgelesen!",
"iptcjs" => "IPTC-Daten (Tags, Captions) aller Bilder auslesen und in XML-Dateien speichern?",
"iptcbutton" => "IPTC-Daten auslesen",

"cleancache" => "Cache l&ouml;schen",
"makeanychange" => "Wenn man &Auml;nderungen an Dateigr&ouml;&szlig;en in der Konfiguration macht oder z.B. Bilder per FTP &uuml;berschreibt dann muss der Cache gel&ouml;scht werden. Bitte l&ouml;scht den entsprechenden Cache auf der rechten Seite!",
"chananyfile" => " Wenn man Bildergr&ouml;&szlig;en &auml;ndert bzw. Wasserzeichen an-/ausschaltet muss der Bildercache gel&ouml;scht werden.<br>&nbsp;",
"reallydelcac" => "Den Bildercache wirklich l&ouml;schen?",
"delimacache" => "Bildercache l&ouml;schen",
"ifimagerot" => " Wenn Bilder dauerhaft rotiert wurden, gen&uuml;gt es nicht nur den Bildercache zu l&ouml;schen - Sie m&uuml;ssen ebenfalls die *.rot-Dateien im Cache l&ouml;schen!<br>&nbsp;",
"reallydelrot" => "Rotationsinfo wirklich l&ouml;schen?",
"delrotinf" => "Rotationsinfo l&ouml;schen",
"dirstruccas" => " Die Verzeichnisstruktur wird im Session Cache gespeichert. Wenn Sie neue Bilder hochladen und diese dann nicht zu sehen sind, muss dieser Cache gel&ouml;scht werden - Die Session wird dann ebenfalls beendet und man wird von der TWG-Administration abgemeldet!<br/>&nbsp;",
"reallydelses" => "Die Session wirklich l&ouml;schen?\\nAnschliessend ist man abgemeldet!",
"delsescac" => "Session Cache l&ouml;schen",
"genencrpass" => "Verschl&uuml;sseltes Passwort erzeugen",
"usepasswprot" => " Wenn du passwortgesch&uuml;tzte Galerien verwendest, solltest du sie auch verschl&uuml;sselt speichern! Bitte in der Konfigurationsdatei den Parameter \$encrypt_passwords auf 'true' &auml;ndern, um die Verschl&uuml;sselung einzuschalten.<br>&nbsp;<p>Die folgenden Zeichen sind nicht erlaubt: '..','://', '<', '>', '('.</p>",
"enterpassw" => "Passwort eingeben und 'Erzeugen' dr&uuml;cken:",
"generate" => "Erzeugen",
"shahashval" => "SHA1 Hashwert f&uuml;r '",
"shahashvalde" => "SHA1-Algorithmus existiert nicht - benutze stattdessen internen SHA256-Algorithmus!<br>",
"copygenval" => "Kopiere den generierten Wert entweder in die config.php -> \$privatepassword oder in eine der Passwortdateien. Wenn du f&uuml;r eine Galerie mehr als ein Passwort benutzen willst, mustt du die einzelnen Passw&ouml;rter mit einem Komma trennen, also wie<br/>388ad1c312a388ad1127f2258fa8d5ee,a17fed27eaa8388ad1c388ad1c3126ac320",
"debugfile" => "Debug-Datei",
"twgdocreat" => "TWG erzeugt eine Debug-Datei, in die alle Warnungen und Fehlermeldung ausgegeben werden. &Uuml;berpr&uuml;fe bei Fehlfunktionen von TWG deshalb zuerst die Debug-Datei. Die Debug-Datei wird erst angelegt, wenn ein Fehler aufgetreten ist!", 
"deldebugfile" => "Debug-Datei l&ouml;schen",
"reallydeldefi" => "Debug-Datei wirklich l&ouml;schen?",
"nodefifou" => "Keine Debug-Datei gefunden",
"delete" => "L&ouml;schen"
);

$GLOBALS["config_screen_gen"] = array(
"title" => "TWGXplorer - Dateimanager der TinyWebGallery",
"generimag" => "Generiert die Bilder des Cacheverzeichnisses.<br/>Der Generator wartet nach jedem Bild $cache_gen_wait_time s, um die Serverlast nicht zu hoch werden zu lassen.",
"generimag2" => "<br/>&nbsp;<br/>Noch nicht generierte Cachebilder: ",
"remtime" => " Verbleibende Zeit: ",
"min" => " min ",
"s" => " s",
"gencach" => "Erzeuge Cachebilder",
"all_created" => "Alle Bilder erzeugt",
"stop_creation" => "Stoppe Generierung",
"stop_creation" => "Stoppe Generierung",
"check_creation" => "Prüfe Cache Status"
);

// twg info screen!
$GLOBALS["info_messages"] = array(
"writeble" => "beschreibbar",
"unwriteble" => "schreibgesch&uuml;tzt",
"notfound" => "nicht gefunden",
"allsubdirwrt" => "Alle Verzeichnisse sind beschreibbar",
"foldersabove" => "Die o.g. Verzeichnisse sind schreibgesch&uuml;tzt.<br>Bitte die Zugriffsrechte korrigieren - andernfalls werden die XML Dateien im ",
"folder" => " Verzeichnis",
"albums" => "Alben",
"images" => "Anzahl Bilder",
"size" => "Gr&ouml;&szlig;e",
"twgfolder" => "TWG Installationsverzeichnis",
"imrotate" => "Die Funktion imagerotate wurde nicht gefunden - ",
"diablerotbutt" => " wurde erzeugt. Dies deaktiviert die Funktionalität.",
"back" => "zur&uuml;ck",
"checkagain" => "Erneut pr&uuml;fen",
"showphpinfo" => "PHP Info anzeigen",
"twgimafoldov" => "TWG Bilderverzeichnis:",
"thistablegif" => "Nachfolgende Auflistung zeigt eine &Uuml;bersicht aller Bilder, sowie den belegten Speicherplatz.",
"pleasenote" => "Bitte beachten:",
"numberofima" => "Die Anzahl der Bilder und der belegte Speicherplatz ist &uuml;ber die Session gecacht und wird erst nach dem Schlie&szlig;en des Browsers aktualisiert!",
"legend" => "Legende:",
"protectgal" => "gesch&uuml;tzte Galerie ",
"protectgalw" => "gesch&uuml;tzte Galerie mit ",
"protectfolim" => "gesch&uuml;tztes Albumbild",
"folderdiscr" => "Verzeichnis Beschreibung ",
"foldernm" => "Albumname ",
"folderima" => "Albumbild ",
"imagetext" => "Bildbeschreibung ",
"albumdiscr" => "Albumbeschreibung ",
"backrimage" => "Hintergrundbild ",
"stylesheet" => "Style Sheet ",
"configfile" => "Konfigurationsdatei ",
"charhavelang" => "<b>Fett</b> bedeutet, dass eine sprachabh&auml;ngige Variante existiert.",
"twginstalchck" => "TWG Installationscheck ",
"highlitred" => "Alle Eintr&auml;ge mit rotem Status erfordern Anpassungen, da TWG ansonsten evtl. nicht korrekt funktioniert.<br>Der Status orange beschreibt, dass einige Funktionen nicht korrekt getestet werden konnten und diese Funktionen somit nicht verf&uuml;gbar sind. Bitte alle Eintr&auml;ge mit ? pr&uuml;fen und das Problem beheben! Bitte diese Funktion dann in der Datei config.php deaktivieren! Die Datei config.php wird bei der &Uuml;berpr&uuml;fung nicht ver&auml;ndert!",
"no" => "nein",
"yes" => "ja",
"availeble" => "vorhanden",
"unavaileble" => "nicht vorhanden",
"phpversion" => "PHP Version >= 4.3.0",
"xmlsupport" => "XML Unterst&uuml;tzung",
"gdlibsupport" => "gd_lib Unterst&uuml;tzung",
"gdlib" => "gd_lib >= 2.0",
"gdversion" => "gd_lib Version",
"imagecreate" => "imagecreatetruecolor",
"gdlibntinst" => "gd_lib ist nicht korrekt installiert - TWG ist nicht funktionsf&auml;hig!",
"memlimit" => "Speicherlimit",
"memlimitnotd" => "Speicherlimit kann nicht ausgelesen werden",
"verygood" => "Sehr gut",
"okbutdontula" => "Ok, aber f&uuml;r gro&szlig;e Bilder ungeeignet",
"onlyusesmall" => "Nur f&uuml;r kleine Bilder geeignet",
"nolimit" => "kein Limit",
"unavailebleim" => "Nicht verf&uuml;gbar (imagettftext konnte nicht gefunden werden)",
"unavailebleurl" => "Nicht verf&uuml;gbar (allow_url_fopen = off)",
"testfailed" => "Test fehlgeschlagen - Cache Verzeichnis &uuml;berpr&uuml;fen",
"rotateavail" => "Funktion imagerotate vorhanden",
"textwaterm" => "Text Wasserzeichen ",
"remotejpgsupp" => "Remote jpg Unterst&uuml;tzung ",
"fileuploads" => "Parameter file_uploads ",
"uplmaxfilesize" => "upload_max_filesize",
"maxfilsntdet" => "Parameter upload_max_filesize konnte nicht ausgelesen werden",
"session" => "Session",
"javascript" => "Javascript",
"dirfilpermiss" => "Verzeichnis- und Dateiberechtigungen:",
"maxresolution" => "Maximale Aufl&ouml;sung",
"notavaileble" => "nicht verf&uuml;gbar",
"resizeimages" => " - Bilder verkleinern > ",
"notset" => "nicht gesetzt",
"mostfeatjava" => "Die meisten Funktionen sind von Javascript abh&auml;ngig",
"inordertofunc" => "Damit TWG korrekt funktioniert, ist Schreibzugriff auf einzelne Dateien und Verzeichnisse notwendig. Bei Verzeichnissen, die \"schreibgesch&uuml;tzt\" sind, m&uuml;ssen die Zugriffsrechte ge&auml;ndert werden, damit TWG darauf schreiben kann. Bitte schaut ",
"onthewebsite" => " auf der Webseite f&uuml;r gute Sicherheitseinstellungen nach!",
"thehtusers" => "Die .htusers.php sollte beschreibbar sein - andernfalls k&ouml;nnen Passw&ouml;rter nicht ge&auml;ndert  und keine Benutzer hinzugef&uuml;gt werden. TWG Explorer ist nicht aktiv bis das Passwort des admin Benutzers ge&auml;ndert wurde - bitte &auml;ndert die Rechte mit einem FTP-Programm!",
"thepictdir" => "Das Bilderverzeichnis wird benutzt, um die XML Dateien zu speichern (Parameter \$store_xml_in_picfolders=true). Weiterhin k&ouml;nnen Bilder auch mit dem TWG Explorer hochgeladen und verwaltet werden. Bilder k&ouml;nnen mit der Datei .htaccess gesch&uuml;tzt werden (siehe Beispielverzeichnis)",
"statusoftwg" => "Status des TWG Installationsverzeichnis. Wenn das Verzeichnis schreibgesch&uuml;tzt ist, kann die Konfiguration wahrscheinlich nicht gespeichert werden. Bitte überprüfe die nachfoldernden Dateien. Bitte ändere die Zugriffsrechte wenn die Konfiguration nicht gespeichert werden kann.",
"theconfigdoesnt" => "Die Datei config.php braucht nicht beschreibbar sein!<br>Zur einfacheren Aktualisierung sollte die individuelle Konfiguration in der Datei my_config.php gespeichert werden.",
"mystylehstobewr" => "Die Datei my_style.css sollte beschreibbar sein wenn das Style Sheet mit Hilfe des Color Managers gespeichert werden soll!",
"animage" => "Ein Foto wird unten angezeigt. Wenn nicht, k&ouml;nnen Fotos nicht <br>korrekt geladen werden! Mehr Details sind in der debug Datei zu finden!",
"errorloima" => "Fehler beim Laden des Fotos!",
"recommsett" => "Empfohlene Einstellungen:",
"thesesett" => "Diese PHP-Einstellungen sind notwendig damit die volle Funktionalit&auml;t und maximale Kompatibilit&auml;t erreicht wird.",
"howevertwg" => "TWG wird trotzdem funktionieren auch wenn die Einstellungen nicht den empfohlenen Werten entsprechen",
"directive" => "Apache Webserver Befehl",
"recommended" => "Empfehlung",
"actual" => "gesetzter Wert",
// Die n&auml;chsten 7 Zeilen nicht &uuml;bersetzen
"displayerrors" => "Display Errors",
"savemode" => "Safe Mode",
"fileuploads" => "File Uploads",
"magicquotesgpc" => "Magic Quotes GPC",
"magicquotesrun" => "Magic Quotes Runtime",
"registerglobals" => "Register Globals",
"outputbuff" => "Output Buffering",
"sessionauto" => "Session auto start"
);

// twg color screen!
$GLOBALS["color_messages"] = array(
"colmanager" => "Farbenmanager",
"thecolmanager" => "Mit dem Farbenmanager kann man alle wichtigen Farben von TWG einstellen und die RGB-Werte f&uuml;r die Stylesheets ermittlen. Man kann auch eine Farbe (auch transparent) ausw&auml;hlen und auf der rechten Seite das Layout einfach zusammenklicken.<br/>Das erzeugte Stylesheet kann als Skin oder als my_style.css verwendet werden. Man kann die Einstellungen direkt als my_style.css speichern (Zuerst das Stylesheet anzeigen lassen!). Das vorhandene my_style.css wird &uuml;berschrieben! ",
"fontsize" => " Schriftgr&ouml;&szlig;en kann man direkt im css vor dem Speichern eintragen! Achtung: Die aktuelle  my_style.css kann nicht geladen werden. Die Farben der iframes sind in der i_frame/iframe.css zu finden",
"selectcss" => "Markiere css",
"backtopl" => "Zur&uuml;ck zum Seitenlayout",
"savestyle" => "Speichere Styles als my_style.css",
"mainfolntwr" => "Das TWG Hauptverzeichnis ist nicht beschreibbar! Weitere Details gibt es unter dem Menüpunkt 'Info'.",
"stylecssntwr" => "my_style.ccs ist nicht beschreibbar! Weitere Details gibt es unter dem Menüpunkt 'Info'.",
"text" => "Text",
"link" => "Link",
"hover" => "Hover",
"header" => "Header",
"foldertxt" => "folder.txt",
"topxact" => "TopX Aktiv",
"topxinact" => "TopX Inaktiv",
"caption" => "Titel",
"tips" => "Tipps",
"reset" => "Zur&uuml;cksetzen",
"showcells" => "Zeige Zellen",
"hidecells" => "Verstecken",
"showcss" => "Zeige css",
);

// twg email screen!
$GLOBALS["email_messages"] = array(
"youcaninfm" => "Man kann hier alle registrierten Benutzer (%s) &uuml;ber &Auml;nderungen der Galerie benachrichtigen.",
"sorry" => "Fehler! Die eingegebene Absender Adresse \"%s\" sieht aus als w&auml;re sie ung&uuml;ltig.",
"senderadres" => "Absender (Ihre E-Mail Adresse)",
"subject" => "Betreff",
"massage" => "Nachricht",
"send" => "absenden",
"massagesend" => "Folgende Nachricht wurde gesendet:",
"from" => "von",
"notloggedin" => "Du bist nicht eingeloggt. Bitte gehe zur Hauptseite zur&uuml;ck und log Dich ein.",
"yes" => "ja",
"no" => "nein",
"sendnotifi" => "Benachrichtigungs-Mail senden",
"pleasenote"	=> "Please note:",
"noemailssend" => "\$enable_email_sending = Fehler -> der Debug Modus ist eingeschaltet - es wurde keine echte E-Mail versandt!</p>",
"usercantreg" => "\$show_email_notification = Fehler -> Man kann sich hier nicht als Benutzer registrieren!</p>",
"click" => "Klick ",
"here" => "hier ",
"listof" => " f&uuml;r die Liste der Abonnenten",
"subscribers" => " Abonnenten:",
"from" => "Von:",
"replyto" => "Antwort an:",
"emailsendfalse" => "\$enable_email_sending ist aus - es wurde keine echte E-Mail versandt.",
"error-of" => " von ",
"error-send" => " e-mails konnten nicht versendet werden. Bitte prüfen Sie die Logdatei."
);

// twg about/help screen!
$GLOBALS["main_messages"] = array(
"welcometotwg" => "Willkommen bei der TWG Administration",
"entrytext" => "Der Administrationsbereich unterst&uuml;tzt die Einstellungen im Backend. Daf&uuml;r sind ein paar Funktionen eingebaut, die die Verwendung von TWG einfacher machen.<br/>&nbsp;<center><p><b>F&uuml;r weitere Hilfe bitte auf der Webseite nachsehen! Auf <a href='http://www.tinywebgallery.com'>www.tinywebgallery.com</a> sind Kurzanleitungen <a href='http://www.tinywebgallery.com/en/faq.php' >how-to's</a> und ein <a href='http://www.tinywebgallery.com/en/forum.php' >Anwenderforum</a> zu finden.</b><br/>Der Administrationsbereich ist in die folgenden Bereiche unterteilt  (nicht alle sind f&uuml;r alle Benutzer zug&auml;nglich!):</center>",
"xplorertext" => "Der TWGXplorer ist ein Dateimanager, der die Verwaltung von TWG ohne ein FTP-Programm erm&ouml;licht. Hier hat  man (abh&auml;ngig von den Benutzerrechten) viele M&ouml;glichkeiten, die Bilder und auch TWG selbst zu verwalten. Die Hauptfunktionen sind rechts aufgefhrt.",
"xploreritems" => "<li>Bilder hochladen und skalieren</li><li>Bilder l&ouml;schen/umbenennen/verschieben/</li><li>Textdateien wie folder.txt oder sogar config.php erstellen und bearbeiten</li><li>Benutzerrechte &auml;ndern</li><li>Erstellen/Auslesen von Archiven</li><li>Ansicht als Liste oder Vorschaubilder (Thumbnails)</li>",
"info" => "Info",
"infotext" => "Zeigt einige Informationen &uuml;ber die TWG Installation, wie den Installationscheck. Zeigt Rechte von Verzeichnissen und Dateien und die notwendigen Einstellungen f&uuml;r TWG - bitte zuerst hier nachsehen, wenn die Installation nicht richtig zu funktionieren scheint.",
"color" => "Farbmanager (Nur Administrator)",
"colortext" => "Nettes Programm um ein sch&ouml;nes Style Sheet f&uuml;r TWG zu entwickeln - einfach eine Farbe aussuchen und auf die Vorschau klicken, um die Wirkung zu testen. Anschlie&szlig;end ein Style Sheet anlegen und als my_style.css sichern. In den Kurzanleitungen 'how-tos' auf der website ist die Verwaltung von Styles und Skins beschrieben.",
"email" => "Administrator email (Nur Administrator)",
"emailtext" => "Email an alle registrierten Benutzer schreiben.",
"helper" => "Einstellungen (Nur Administrator)",
"helpertext" => "Hier k&ouml;nnen die Einstellungen an den Hauptfunktionen von TWG ver&auml;ndert werden.  Ausserdem gibt es vereinfachte Bedienfunktionen f&uuml;r TWG, wie Speicher l&ouml;schen, Passw&ouml;rter anlegen und das Auslesen der Debug-Datei.",
"user" => "Benutzerverwaltung",
"usertext" => "Benutzer des Backends verwalten. Benutzer anlegen und Zugang zu bestimmten Bereich erlauben (meistens vermutlich das Bildverzeichnis)."
);

// Messages in the javascript parts
// \n has to be written as \\n because it's uses in Javascript! \ has always be escaped again! don't use &uuml; or something like this here!
$GLOBALS["js_messages"] = array(
"errdef" => "\\nDas Speichern ist nicht m&ouml;glich, solange kein g&uuml;ltiger PHP-Code eingegeben wurde!",
"text_save" => "Die &Auml;nderungen werden in der Datei my_config.php gespeichert.\\nDies wird die bestehenden Einstellungen &uuml;berschreiben.\\nDeine alten Einstellungen werden in der my_config.php.bak.php gespeichert.\\nM&ouml;chtest Du fortfahren?",
"admin_semicolon" => "Ein Semikolon fehlt in Zeile ",
"admin_missing" => "= fehlt in Zeile ",
"admin_line_start" => "Jede Zeile muss mit einem Parameter beginnen (\$...)\\nBitte &uuml;berpr&uuml;fe die Zeile: ",
"admin_brackets" => "Die Klammer wurden nicht geschlossen in Zeile: ",
"admin_brackets2" => "Nicht geschlossene Elemente in Zeile: ",
"admin_bracketsx" => "Nicht geschlossene Klammer in Zeile: ",
"admin_anfzeichen" => "Man kann Backslash \\\" oder \\\' in diesem Feld nicht benutzen.\\nWenn die Einstellungen so gespeichert werden, kann die Konfiguartion zerst&ouml;rt werden! Bitte benutzt einen String ohne dieses Zeichen oder speichert die Einstellung manuell in der Konfiguration.",
"admin_number" => "Bitte gib in diesem Feld eine Zahl ein. Wenn man dieses Feld leer l&auml;sst, wird TWG nicht einwandfrei funktionieren.",
"admin_0" => "0 ist keine g&uuml;ltige Eingabe in diesem Feld. Bitte korrigiere Deine Eingabe.",
"admin_nurnum" => "In diesem Feld sind nur Zahlen erlaubt.\\nWenn man die Einstellungen so speichert, kann die Konfiguartion zerst&ouml;rt werden!",
"picker_save" => "M&ouml;chtest Du dieses Layout wirklich speichern?\\nDie bestehende my_style.css wird unter \\nmy_style.css_&lt;timestamp&gt;.bak gespeichert.\\nMan solltet die Sicherungsdatei l&ouml;schen, wenn das endg&uuml;ltige Layout feststeht.\\nAchtung: Falls ein Skin ausgew&auml;hlt war, wurde diese Einstellung entfernt, da sonst die Einstellungen in my_style.css wieder &uuml;berschrieben werden!",
"picker_con" => "Die Verbindung konnte nicht hergestellt werden.\\nSichere das Layout manuell unter my_style.css",
"no_error" => "Das Layout wurde als my_style.css gesichert.\\nEine Sicherungskopie des alten Layouts wurde erstellt!\\nMan kann sein neues Layout &uuml;berpr&uuml;fen, indem man die Galerie in einem neuen Fenster &ouml;ffnet!",
"error_copy" => "Das alte Layout konnte nicht kopiert werden.\\nDein neues Layout wurde nicht gespeichert.\\n&Uuml;berpr&uuml;fe bitte die Berechtigungen des TWG-Verzeichnis.",
"error_open" => "Die Datei my_style.css konnte nicht ge&ouml;ffnet werden.\\nDein neues Layout wurde nicht gespeichert.\\n&Uuml;berpr&uuml;fe bitte die Berechtigungen des TWG-Verzeichnis.",
"error_store" => "Die Datei my_style.css konnte nicht gespeichert werden.\\nDein neues Layout wurde nicht gespeichert.\\n&Uuml;berpr&uuml;fe bitte die Berechtigungen des TWG-Verzeichnis.",
"error_close" => "Die Datei my_style.css konnte nicht geschlossen werden.\\nH&ouml;chstwahrscheinlich wurde die Datei my_style.css gespeichert.\\n&Uuml;berpr&uuml;fe bitte, ob das neue Layout aktiv ist.",
"error_def" => "Fehler",
"button_show" => "Zeigen",
"button_trans" => "Transparent",
"showcells" => "Zeige Zellen",
"hidecells" => "Verstecken"
);

$GLOBALS["fsa_messages"] = array(
// do not translate the next line
"title" => "TFU File Split Applet",
"split_description" => "Bitte w&auml;hlt die Dateien, die ihr splitten wollt aus und w&auml;hlt die Gr&ouml;&szlig;e der einzelnen Teile. Die automatische Auswahl zeigt das aktuelle Upload-Limit dieses Servers. Bitte ladet immer alle Teile einer Datei auf einmal mit dem TWG Upload Flash hoch, da diese sonst nicht korrekt zusammengesetzt werden k&ouml;nnen.",
"help_text1" => "Das TFU File Split Applet ist ein kleines Javaapplet mit dem man Dateien - welche wegen dem Upload Limit des Servers nicht direkt hochladen kann - teilen und diese St&uuml;cke zur&uuml;ck auf die Festplatte speichern kann. Diese Teile kann man dann mit dem Flash uploader hochladen, welcher diese St&uuml;cke wieder zusammensetzt. Man ben&ouml;tigt ein installiertes Java >= 1.4 um diese Applet benutzen zu k&ouml;nnen. Das Applet ben&ouml;tigt Schreib/Leserechte auf der lokalen Festplatte um die Dateien einlesen und die einzelnen Teile wieder schreiben zu k&ouml;nnen. Dies ist nur mit einem signierten Applet m&ouml;glich. Beim &Ouml;ffnen des Applets bekommt ihr folgene Warnung:",
// do not translate the next line
"help_warning" => "The application's digital signature is invalid. Do you want to run the application?",
"help_text2" => "Diese Meldung erscheint, weil dieses Applet <b>selfsigned</b> (selbst signiert) ist. Wenn ihr &uuml;berpr&uuml;fen wollt, dass dies das originale Applet ist, welches von der TinyWebGallery Webseite kommt, dann klickt bitte %shier%s f&uuml;r eine Beschreibung, wie die Signatur verifiziert werden kann.",
"help_limit" => "Das Upload Limit auf diesem Server ist:",
"help_open" => "&Ouml;ffne das TFU File Split Applet",
"help_time" => "(Das &Ouml;ffnen des Applets dauert etwas, das zuerst Java geladen werden muss.)",
"split_setup" => "Auf diesem Server wurde noch nicht getestet, ob Dateien, die gr&ouml;&szlig;er als das Upload limit sind verarbeitet werden k&ouml;nnen.<br/>&nbsp;<br/>Deswegen ist die Unterst&uuml;tzung f&uuml;r gesplittete Dateien nicht freigeschaltet.<br/>Um diese Funktion komplett abzuschalten, muss man  '" . $GLOBALS["config_form_block"]["adminenablesplit"] ."' (admin_enable_split) auf false setzen.<br>&nbsp;<br>Um diese Funktion zu aktivieren sollte man die Anleitung in howto 42 lesen.<br>&nbsp;<br>F&uuml;r erfahrene Anwender: Setzt '" . $GLOBALS["config_form_block"]["adminenablesplit"] ."' (admin_enable_split) und '" . $GLOBALS["config_form_block"]["adminchecksplit"] ."' (admin_file_split_is_tested) auf true. Der Test selbst ist sehr einfach: Splitet eine Datei, die gr&ouml;&szlig;er als das Uploadlimit des Servers ist, Ladet die Teile hoch und ladet die zusammengef&uuml;gte Datei mit dem TWGXplorer oder FTP herunter (wenn m&ouml;glich!) und &uuml;berpr&uuml;ft, ob die Datei o.k. ist."
);

// new 1.7.7
define("_C_VERSION_NO","TWG kann nicht überprüfen, ob eine neue Version verfügbar ist. Bitte gehen sie regelmäßig zu");
define("_C_VERSION_NO2","um zu überprüfen, ob es wichtige Updates gibt.");
define("_C_VERSION_OLD1","Updates sind verfügbar. Bitte gehen Sie zu");
define("_C_VERSION_OLD3","Aktuelle Version: ");
define("_C_VERSION_OLD4","Ihre Version: ");
define("_C_VERSION_OLD5","News über TWG erhalten Sie im RSS feed des");
define("_C_VERSION_OLD6","TWG-Blogs");
define("_C_VERSION_OK","Ihre Installation ist aktuell. Es gibt keine Updates für Ihre Version von TWG.");
?>