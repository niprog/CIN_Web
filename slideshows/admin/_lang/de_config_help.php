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
$GLOBALS["help_msg"] = array(
// page 1
"privatepassword" => "Um eine Galerie mit einem Passwort zu sch&uuml;tzen, muss eine leere Datei mit dem Namen \'private\' mit in dem Verzeichnis der Bilder erzeugt werden. Wenn eine Galerie mit einem anderen Passwort gesch&uuml;zt werden soll, muss in die \'private\' Datei das gew&uuml;nschte Passwort eingetragen werden. Siehe how-to\'s wegen Verschl&uuml;sselung usw. ",
"browser_title_prefix" =>  "Hier kann man den Titel angeben, der oben im Browser angezeigt werden soll. Zus&auml;tzlich werden auf den Bilderseiten die Bildunterschriften angef&uuml;gt",
"default_gallery_title" => "Dies ist die Default-&Uuml;berschrift die auf der Hauptseite angezeigt wird wenn keine Titel in der Sprachdatei vorhanden ist. Wenn verschiedene Titel in verschiedenen Sprachen gew&uuml;nscht werden, m&uuml;ssen diese in den Sprachdateien im \'language\' Verzeichnis eingetragen werden!",
"skin" => "Als Default wird der Admin Skin benutzt - im Download sind folgende Skins vorhanden:  \'black\',\'green\',\'transparent\',\'winter\' und \'newyork\'. Alle anderen M&ouml;glichkeiten Syles zu setzten sind weiterhin g&uuml;ltig (siehe how-to 9). Einige der Skins haben einen Hintergrund! Schaut ins Skins-how-to um einen eigenen Skin zu erstellen oder schaut ins Forum -> Skins ob dort ein Skin exitiert, der euch gef&auml;llt! Wenn Ihr den Skin &auml;ndert, l&ouml;scht alle *.slide.jpg Bilder im Cache Verzeichnis!",
"use_round_corners" => "Benutze runde css Ecken. Dies wird von allen aktuellen Browsern unterstützt! Es gibt noch weitere Einstellungen für runde Ecken in der config.php.",
"iframe_include" => "Lest bitte howto 2 bevor ihr dies ändert! Wenn die Galerie in einem Iframe eingebunden wird, kann man hier true einstellen. Bei false wird ein anderer Doctype verwendet, welcher ein etwas besseres Layout beim IE erzeugt! Man verhindert so den Rand auf der rechten Seite, die der IE für den Scrollbalken reserviert. IE zeigt dann nicht mehr alle Hovereffeke!",
"iframe_height_ie"=>"Ist die H&ouml;he von iframes kleiner als 500px, stellt der IE sie nicht korrekt dar. Man muss die H&ouml;he die der IE benutzen soll speziell definieren - normalerweise ist dies ungef&auml;hr 4-5 Pixel weniger als die H&ouml;he, mit der die iframes selbst definiert sind.",
"show_border" => "Default ist ein Rand um die Galerie. Man kann diesen jedoch auch abschalten z.B. wenn man TWG integriert! Der wert wird in der Session gecacht und Änderungen sind erst nach schliessen aller Browserfenster sichtbar. Kann auch per URL ge&auml;ndert werden (twg_withborder=true or twg_noborder=true). G&uuml;ltige Werte \'TRUE\' und \'FALSE\'.",
"cache_dirs" => "Inhalt von Verzeichnissen wird gecacht - Das kann hier abgeschaltet werden, solange man TWG einrichtet oder uploads schnell testen will.",
"show_twg_logo_if_registered" => "Man kann sich registrieren und trotzdem das Logo anzeigen, wenn man nur die zusätzlichen Features haben will, aber TWG trotzdem unterstützen will.",
"enable_basic_seo" => "SEO urls aktivieren - Siehe howto 44 für Details.",
// admin part
"admin_default_upload_method" => "Man kann die die normale Upload Methode vom TWG Admin setzen. Gültige Werte: \'flash\' oder \'html\'. html deaktiviert die Menüeinträge \'Upload Bilder\' und \'File Split Applet\'",
"admin_enable_split" => "Aktiviert/Deaktiviert die splitting Möglichkeiten von TWG um das Upload Limit des Servers zu umgehen. Bitte lest Howto 42 um zu testen, ob Filesplitting auf diesem Server möglich ist.",
"admin_file_split_is_tested" => "Teilen und wieder zusammenfügen von grossen Dateien wird nicht von allen Servern unterstützt. Deswegen ist es zunächst nicht aktiviert. Bitte lest Howto 42 um zu testen, ob Filesplitting auf diesem Server möglich ist.",
// page 2
"menu_x" => "Anzahl der Galerien, die nebeneinander auf der &Uuml;bersichtseite gezeigt werden.",
"menu_y" => "Anzahl der Galerien, die untereinander auf der &Uuml;bersichtseite gezeigt werden.",
"autodetect_maximum_thumbnails" => "TWG versucht bei \'true\' so viele Vorschaubilder wie m&ouml;glich anzuzeigen. Es wird die Browsergr&ouml;sse an den Server geschickt und aufgrund der Gr&ouml;sse die Einstellungen angepasst. Im \'low bandwith mode\' is dies abgeschaltet!",
"thumbnails_x" => "Anzahl der Bilder nebeneinander auf der Thumbnailseite.",
"thumbnails_y" => "Anzahl der Bilder untereinander auf der Thumbnailseite.",
"number_top10" => "Anzahl der Bilder, die auf der Top X Seite gezeigt werden. Die vorhandene Berechnung (13) passt gut zum aktuellen Layout.",
"small_pic_size" => "Bildgr&ouml;sse der Web-Bilder.",
"resize_only_if_too_big" => "Wenn man diesen Parameter auf true setzt, werden Bilder nur angepasst, wenn diese zu groß sind. Man kann so Plattenplatz sparen, wenn man die Bilder vorher auf die richtige Gr&ouml;sse bringt. Beim Fullscreen-Modus sind die Bilder dann nat&uuml;rlich unscharf.",
"use_small_pic_size_as_height" => "Die Gr&ouml;sse der Detailbilder ist normalerweise so, das ein Bild so heruntergerechnet wird, das die l&auml;ngste Seite der maximalen Gr&ouml;sse entspricht. Dadurch sind vertikale Bilder nat&uuml;rlich h&ouml;her, als horizontale. Wenn dieser Parameter auf \'true\' gesetzt wird, wird dies Bildgr&ouml;sse als maximale H&ouml;he verwendet. Vertikale Bilder sind dann nur noch so hoch, wie Horizontale. Beim Betrachten der Bilder hat diese den Vorteil, das die Navigation nicht mehr nach unten springt, wenn ein vertikales Bild kommt. Wenn diese Einstellung verwendet wird, sollte die Bildgr&ouml;sse um 1/3 verkleinert werden, damit die horizontalen Bilder die gleiche Gr&ouml;sse haben wie vorher. Der Cache muss hier ebenfalls gel&ouml;scht werden.",
"thumb_pic_size" => "Bildgr&ouml;sse der Vorschaubilder.",
"strip_thumb_pic_size" => "Man kann die Thumbnails im Thumbstrip in einer anderen Grösse darstellen als auf der Vorschaubildseite. Funktioniert nur, wenn clipped images aktiv ist!",
"menu_pic_size_x" => "Breite der Galerie&uuml;bersichtsbilder (muss durch 2 teilbar sein).",
"menu_pic_size_y" => "H&ouml;he der Galerie&uuml;bersichtsbilder (muss durch 2 teilbar sein).",
"show_clipped_images" => "Alle Vorschaubilder zeigen quadratische Ausschnitte des Orignalbilds - Wenn dies ge&auml;ndert wird, muss der Cache gel&ouml;scht werden. Die Gr&ouml;sse der Bilder (x and y) ist \$thumb_pic_size!",
"show_colage" => "true: Zeigt eine Collage der ersten 4 Bilder, bei false wird das 1. Bild angezeigt.",
"use_random_image_for_folder" => "Wenn \'true\' wird ein Zufallsbild (oder 4 bei Collage) auf der &Uuml;bersichtsseite f&uuml;r ein Verzeichnis verwendet. Bei \'false\' das 1. bzw. die ersten 4.",
"folder_effect" => "Es gibt nun 3 Effekte für die Galerieübersicht: \'fade\', \'gray\' und  \'change\' (Tauscht ein Bild gegen ein anderes Bild aus dem Verzeichnis wenn man mit der Maus drübergeht!) - Wenn ihr keinen Effekt haben wollt verwendet \'\' oder \'none\' - Die Effekte sehen unter ie am besten aus - FireFox flickert leicht beim Modus fade! - gray geht nur beim IE (fade Effect im FF als Backup) - fade gibt es nur für  ie und ff - change geht für alle Browser!",
"auto_skip_thumbnail_page"=> "Wenn man diese Option auf true setzt, wird die Thumbnail-Seite nur angezeigt, wenn mehr als numberpics Bilder in einem Verzeichnis sind (=Anzahl der Bilder im Thumbstrip auf der ImageSeite). Denn warum soll man eine Übersicht zeigen, wenn eh alle Bilder auf der nächsten Seite angezeigt wird. Wenn der Thumbsstrip ausgeblendet wird, wird die Thumbspage auf jeden Fall angezeigt!",
// page 3
"show_only_small_navigation" =>  "Default ob nur die kleine Navigation angezeigt werden soll. \'TRUE\' zeigt nur die kleine Navigation. \'FALSE\' zeigt die grosse Navigation. Kann auch per URL ge&auml;ndert werden.",
"default_big_navigation" => "Es gibt 2 Arten der grossen Navigation - Normal (HTML ) und dhtml (DHTML) - Die dhtml Version cached sehr viel. Bitte verwenden Sie diesen Modus nicht, wenn sie Benutzer mit &uuml;berwiegend schlechten Verbindungen erwarten.",
"numberofpics" => "Anzahl der Bilder, die im Thumbnailstrip angezeigt werden.",
"big_nav_pos" => "Hier kann die Position des Thumbstrips definiert werden - nur \'top\' und \'bottom\' ist m&ouml;glich. Tieser Werd wird ignoriert, wenn HTML_SIDE verwendet wird.",
"autodetect_noscoll" => "Wenn man weniger als $numberofpics Bilder in einem Verzeichnis hat, muss man nicht mehr scrollen - Wenn man diese Option auf true setzt, scrollen die Thumbs nicht mehr sondern sind statisch egal welches Bild man auswählt (Das aktuelle Thumb ist jedoch dann nicht mehr unterhalb des grossen Bildes)",
"use_nonscrolling_dhtml"=> "Wenn man dies auf true setzt, dann scrollt die cmotion gallery nicht mehr. Sie bewegt sich, indem man einfach auf die Thumbs klickt. Das sieht wie die html Lösung aus, ist aber deutlich schneller! Der Grund, warum ich das implemeniert habe ist, das wenn man  \$use_dynamic_background auf true setzt funktioniert die cmotion gallery nur sehr schlecht - drum wird wenn man \$use_dynamic_background auf true setzt diese Option auch automatisch auf true!",
"show_comments" => "Aktiviert die Kommentaroptionen (Eingabe, Anzeige).",
"show_login" =>  "Aktiviert/deaktiviert den Login in der linken oberen Ecke.",
"show_optionen" =>  "Aktiviert/deaktiviert die Optionen auf der Detailseite in der linken oberen Ecke.",
"show_new_window" =>  "Aktiviert/deaktiviert den \'Neues Fenster\' Link in der linken oberen Ecke und in den Optionen.",
"enable_download" => "Ein/ausschalten des Downloads von originalen Dateien. Wenn Sie nicht wollen, das die originalen Dateien heruntergeladen werden, muss dieserParameter auf false gesetzt werden.",
"show_image_rating" => "Schaltet das Bewerten von Bildern ein.",
"show_search" => "Zeigt die Suche.",
"show_topx" => "Zeigt Topx - macht sicher das mindestens einer der Z&auml;hler aktiv ist (views, downloads, rating oder comments)",
"show_tags" => "Hier kann man TAGs ein- und ausschalten. Dies aktiviert/deaktiviert die Top-TAGs, die Suche und sas eingeben/editierenvon TAGs!",  
"show_public_admin_link" => "Man kann den Menüpunkt zum TWG Admin ein/ausblenden.",
"show_slideshow" => "Schaltet die Slideshowoptionen von TWG ein/aus.",
"twg_slide_type" => "Legt den Slideshow-Typ fest.",
"twg_slideshow_time" => "(String z.B. \'10\') Definiert das Slideshowinterval in Sekunden.",
"show_captions" =>  "Man kann den Menüpunkt zum Eingeben von Bildunterschriften ein/ausblenden.",
"show_counter" => "Zeigt den Besucherz&auml;hler an - wenn er nicht angezeigt wird, wird weiter gez&auml;hlt!",
"show_help_link" => "Zeigt den Hilfelink.",
"show_enhanced_file_infos" => "Zeigt erweiterte Informationen &uuml;ber ein Bild im Men&uuml;.",
"show_rotation_buttons" => "Zeigt die Buttons zum drehen der Bilder; true - zeigt sie; false - versteckt sie. Wenn die rotate Funktion nicht vorhanden ist, werden die Buttons automatisch ausgeblendet!",
"show_bandwidth_icon" => "Blendet das Bandbreiten-Icon aus, wenn man mag - \'true\': zeigt es - \'false\' blendet es aus (Bandbreitentest wird trotzdem ausgeführt!)",
"enable_album_tree" => "Ein- und Ausschalten den Album-Tree an der linken Seite. Es gibt ein paar mehr Optionen, um den Tree zu konfigurieren. Mit album_tree_width kann man die Breite festlegen!", 
// page 4
"print_text" => "Auf die grossen Bilder kann ein Text in der linken unteren Ecke eingebunden werden um seine Bilder zu markieren. Wenn diese Einstellung ver&auml;ndert wird, m&uuml;ssen die grossen Bilder im Cache gel&ouml;scht werden. Es wird die FreeType Bibliothek ben&ouml;tigt (info.php aufrufen und im Bereich GD &uuml;berpr&uuml;fen)!",
"print_text_original" => "Das Wasserzeichen (Text oder Bild - siehe unten) wird auf das Originalbild beim herunterladen gemacht - \$enable_direct_download muss dabei auf \'false\' gesetzt werden.",
"text" => "Der Text",
"print_watermark" => "Auf die großen Bilder kann ein Wasserzeichen eingeblendet werden um seine Bilder zu markieren. Wenn diese Einstellung ver&auml;ndert wird, m&uuml;ssen die grossen Bilder im Cache gel&ouml;scht werden. Bitte lest die Beschreibungen der Parameter f&uuml;r das Wasserzeichen, um optimale Ergebnisse zu bekommen!",
"print_watermark_original" => "Blendet das grosse Wasserzeichen auf dem Original ein - \$enable_direct_download muss auf \'false\' gesetzt sein!",
"watermark_small" => "Diese Bild wird f&uuml;r die Detailbilder und die Slideshows verwendet. Es kann jpg oder png verwendet werden. Mit png bekommt man meist bessere Ergebnisse!",
"watermark_big" => "Dieses Bild wird auf den heruntergeladenen Bildern verwendet (jpg oder png). Hier k&ouml;nnen gr&ouml;ssere Wasserzeichen verwendet werden, da die Originale ja meist deutlich gr&ouml;sser sind.",
"position" => "Hier wird die Position des Wasserzeichens festgelegt. Die Nummern zeigen die Position auf dem Bild:<br> 1 2 3<br>4 5 6<br>7 8 9",
// other help text!
"simple_view" => "Es sind 2 Ansichten verf&uuml;gbar: \'Simple View\' und \'Normal View\'. Simple View zeigt die files, an denen eventuelle &Auml;nderungen selbst vorgenommen werden k&ouml;nnen, wie z.B. config, style sheets, directories und files bei denen die Zugriffsrechte ge&auml;ndert werden m&uuml;ssten. ... Normal View zeigt alle files!",
"rights" => "Alle Funktionen bedeutet, dass auch alle Ordnerfunktionen verfügbar sind. D.h. dass Ordner erzeugt, gelöscht und umbenannt werden können.",
"delete_cache" => "Wenn man diese Einstellung ändert, muss der Bildercache im cache Verzeichnis gelöscht werden. Man kann dies weiter unten auf der Seite machen.<br>Erfahrene Benutzer brauchen nur die Bilder löschen, welche betroffen sind (Vorschau oder Detail/Slideshowbilder).",
// New 1.8
'icon_set' => 'Es können verschiedene Icon-Sets ausgewählt werden. Weitere sind auf der TWG Webseite verfügbar. Einige Skins haben Ihr eigenes Icon-Set gesetzt. Diese müssen dann im Skin gesetzt werden!',
"skip_thumbnail_page" => "Wenn man das aktiviert wird die Seite mit Vorschaubildern nicht angezeigt. Wenn man in Verzeichnissen weitere Unterverzeichnisse UND Bilder hat kann man die Unterverzeichnisse dann nicht mehr auswählen.",
"autorotate_images" => "TWG kann gedrehte Bilder automatisch erkennen, wenn die Kamera dies setzt. Das Problem ist, das TWG nicht weiss, wie die Kamera gehalten wird. Deswegen sollte man testen, ob Normal oder Invertieren die richtgie Orientierung ist. Nach einer Änderung muss der Cache und der Rotation-Cache gelöscht werden. Ich halte die Kamera immer so, dass Invertieren gesetzt sein muss.",
"sort_images_ascending" => "Ja: sortiert die Bilder aufsteigend. Nein: Absteigend (Datum und Dateinamen!)",
"sort_by_date" => "Sortiert die Bilder nach Namen, wenn Nein eingestellt ist. Bei Ja wird zuerst versucht das exif Datum zu ermitteln. Wenn dies fehlschlägt wird die Dateizeit genommen. Bei sehr vielen kann die Verwendung des exif Datums die Galerie verlangsamen, weil die Ermittlung sehr langsam ist.",
"sort_by_filedate" => "Ja: Verwendet das Dateidatum für die Sortierung. Nein: Zurst wird das exif Datum verwendet. Wenn dies nicht verfügbar ist, wird das Dateidatum verwendet.",
"sort_albums" => "Manchmal wird keine Sortierung gewünscht. Man kann dann nicht voraussagen, wie dir Reihenfolge sein wird (meistens ist es die Reihenfolge, in der die Verzeichnisse erzeugt wurden!).",
"sort_albums_ascending" => "Ja: Sortiert die Albums aufsteigend (Wenn nach Datum sortieren auf Ja steht: Neueste zuerst)  Nein: Absteigend - Die Verzeichnisstruktur wird gecacht. Evtl. wird diese Änderung erst nach einem Refresh des Caches sichtbar!",
"sort_album_by_date" => "Sortiert Ordner nach Datum - Die Verzeichnisstruktur wird gecacht. Evtl. wird diese Änderung erst nach einem Refresh des Caches sichtbar!",
'open_in_maximized_view' => 'Öffnet das Bild in der maximierten Ansicht wie man es auch über das Menü machen kann. Öffnen als Popup bzw. in einem neuen Fenster wird ignoriert!',
'disable_tips' => 'Standardmäßig werden kleine Tips unten bei der TWG angezeigt. Hier kann man alle auf einmal abschalten. In den erweiterten Einstellungen kann man diese auch seperat konfigurieren. Die Texte der Tips kann man in der Konfiguration ändern. Somit kann man sich diese nach seinen Wünschen anpassen.'
);
?>
