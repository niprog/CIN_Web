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

// language file - 2.2 - if you translate a language file where already some parts are translated: Please don't remove the former translator completely - insert him/her behind the lang_translator as a comment
$charset="utf-8";
$lang_translator = "&nbsp;";
$lang_optionen = "Optionen";
$lang_menu_titel = "Titel";
$lang_kommentar = "Kommentar";

$lang_back_link = "Home |"; // don't translate this - in other languages I show an nice home icon - only if you want to have your text here add this to your language file!
$lang_titel = "";
$lang_titel_no = "Es sind noch keine Bilder hochgeladen worden.";
$lang_select_gallery = "Bitte w&auml;hlen Sie eine Galerie aus.";
$lang_help = "Hilfe";
$lang_new_window = "Neues&nbsp;Fenster";
$lang_login = "Login";
$lang_logout = "Logout";
$lang_visitor = "Besucher:";
$lang_total = "Gesamt:";
$lang_today = "Heute:";
$lang_galleries = "Galerien";
$lang_picture = "Bild";
$lang_pictures = "Bilder";
$lang_of = "/";

$lang_overview = "Zur &Uuml;bersicht";
$lang_forward = "Vor";
$lang_back = "Zur&uuml;ck";
$lang_rotate_left = "Nach links drehen";
$lang_rotate_right = "Nach rechts drehen";
$lang_start_slideshow = "Start Slideshow";
$lang_stop_slideshow = "Stop Slideshow";
$lang_thumb_forward = "&gt;"; // = '>'
$lang_thumb_back="&lt;"; // = '<'
$lang_views = "x";

$lang_login_php_enter = "Bitte geben Sie das Passwort ein, um die<br />erweiterten Funktionen der Galerie freizuschalten:";
$lang_login_php_enter_again = "Falsches Passwort<br />Bitte erneut eingeben:";

$lang_kommenar_php_both_fields = "Bitte beide Felder ausf&uuml;llen.<br />";
$lang_kommenar_php_enter_name = "Bitte geben Sie einen Namen ein:";
$lang_kommenar_php_enter_comment = "Bitte geben Sie einen Kommentar ein:";
$lang_kommenar_php_name = "Name:";
$lang_kommenar_php_comment = "Kommentar:";
$lang_kommenar_php_speichern = "Speichern";

$lang_privatelogin_php_wrong_password = "Falsches Passwort<br />Bitte erneut eingeben:";
$lang_privatelogin_php_password = "Bitte geben Sie das Passwort f&uuml;r die Galerie<br />'%s' ein:";
$lang_privatelogin_php_login = "Login";

$lang_titel_php_titel = "Bitte geben Sie einen Titel ein:";
$lang_titel_php_save = "Speichern";

$lang_slideshowid_php_loading = "Slideshow wird geladen ...";

$lang_opionen_php_yes = "Ja";
$lang_opionen_php_no = "Nein";
$lang_opionen_php_new_window = "&Ouml;ffne Galerie in eigenem Fenster";
$lang_opionen_php_opt_slideshow = "Optimierte Slideshow";
$lang_opionen_php_slideshowintervall = "Slideshowintervall (sek.)";
$lang_opionen_php_ok = "OK";
$lang_opionen_php_top_nav = "Zeige nur obere Navigation";

$lang_back_topx = "zur&uuml;ck&nbsp;zur&nbsp;Top&nbsp;%s";
$lang_topx = "Top&nbsp;%s";
$lang_main_topx = "Zur&uuml;ck zur Hauptseite";
// new in 1.1
$lang_loading = "lade...";
$lang_dhtml_navigation = "Navigationsart";
$lang_optionen_slideshow = "Art der Slideshow";
$lang_optionen_slideshow_fullscreen = "Maximiert";
$lang_optionen_slideshow_optimized = "&Uuml;berblenden";
$lang_optionen_slideshow_normal = "Normal";
$lang_lowbandwidth = "TinyWebGallery ist f&uuml;r langsame Verbindungen optimiert.";
$lang_highbandwidth = "TinyWebGallery ist f&uuml;r schnelle Verbindungen optimiert.";
// new in 1.2
$lang_email_menu_user = "E-Mail Benachrichtigung";
$lang_email_menu_admin = "E-Mail verschicken";
// Sorrymessage for failed subscription
$lang_email_sorrysignmessage = "Tut mir leid, es gibt bereits einen Eintrag mit der Email %s";
// Sorrymessage for blank email
$lang_email_sorryblankmailmessage = "Bitte eine Emailadresse angeben";
// Sorrymessage for invalid emails
$lang_email_sorryoddmailmessage = "Tut mir leid, aber \"%s\" sieht nicht wie eine g&uuml;ltige Email aus.";
// Sorrymessage if someone entered your own mail
$lang_email_sorryownmailmessage = "Tut mir leid, aber ich m&ouml;chte nicht meine eigene Benachrichtigung bekommen!";
// Title of the newsletter, will be displayed in the subject field of the mailclient
$lang_email_subscribemail_subject = "Anmeldung zur E-Mail-Benachrichtigung.";
// Subscribemessage, will be shown when someone subscribes.
$lang_email_subscribemessage = "Vielen Dank, das du dich eingetragen hast. Eine Best&auml;tigungsemail ist unterwegs.";
// Subscribemail, will be sent when someone subscribes.
$lang_email_subscribemail = "Lieber TinyWebGallery-Benutzer.\n\nDu wurdest erfolgreich in den Galerieverteiler eingetragen.";
// Unsubscribemessage for deletion, will be followed by the email!
$lang_email_unsubscribemessage = "Die Email '%s' wurde aus dem Verteiler entfernt.";
// Unsubscribemessage for failed deletion, will be followed by the email!
$lang_email_failedunsubscriptionmessage = "Keinen Eintrag f&uuml;r die Email %s gefunden.";
// the welcometext
$lang_email_welcomemessage = "Sie k&ouml;nnen sich hier zur E-Mail-Benachrichtigung an-&nbsp;und&nbsp;abmelden.<br/>Sie werden dann vom Galerieverwalter informiert, wenn neue Bilder hochgeladen wurden.";
// email could not be sent.
$lang_email_error_send_mail = "Es konnte keine Best&auml;tigungsemail verschickt werden.<br/>Wahrscheinlich ist der Mailserver nicht korrekt eingerichtet. Bitte kontaktieren Sie den Galerieverwalter.";

$lang_email_add = "Anmelden";
$lang_email_remove = "Abmelden";
$lang_email_send = "Abschicken";

$lang_email_admin_welcomemessage_send = 'Hier k&ouml;nnen Sie alle registrierten Benutzer (%s) &uuml;ber &Auml;nderungen der Galerie informieren.';
$lang_email_admin_sorryoddsendermailmessage = "Die Absenderadresse %s sieht nicht wie eine g&uuml;ltige Email aus.";
$lang_email_admin_sendermail = "Absenderadresse (eure Email)";
$lang_email_admin_subject = "Betreff";
$lang_email_admin_message = "Nachricht";
$lang_email_admin_sendbutton = "Abschicken";
$lang_email_admin_sent = "Folgende Nachricht wurde verschickt:";
$lang_email_admin_from = "Von";
$lang_email_admin_notloggedin = "Sie sind nicht korrekt angemeldet. Bitte gehen Sie zur Hauptseite oder melden Sie sich f&uuml;r dieses Album an.";

$lang_visitor_30 = "30 Tage &Uuml;bersicht";

$lang_login_php_enter = "Bitte geben Sie das Passwort ein, um die<br />erweiterten Funktionen der Galerie freizuschalten:";
$lang_opionen_php_zoom = "Maximierte Ansicht";
$lang_administration = "Administration";
$lang_opionen_php_zoom_message = "Achtung: Die \'Maximierte Ansicht\' ist relativ langsam, da die Bilder auf dem Server erzeugt werden und nicht gecacht sind. Weiterhin sind diese Bilder meist deutlich gr&ouml;sser und deswegen dauert deren &Uuml;bertragung deutlich l&auml;nger.\\nVerwenden Sie diese Option bitte nur, wenn Sie &uuml;ber eine schnelle Internetverbindung verf&uuml;gen!";
$lang_first = "Erstes Bild";
$lang_last = "Letztes Bild";
$lang_no_session = "Session ist nicht verf&uuml;gbar. Der Login in private Galerien ist nicht m&ouml;glich.";
$lang_not_loggedin = "Sie sind nicht angemeldet.<br/>Bitte gehen Sie zur Hauptseite und geben Sie das Passwort f&uuml;r diese Galerie ein.<br/>Wenn diese Nachricht nach einer Anmeldung erscheint, m&uuml;ssen erst Cookies eingeschaltet werden!";
$lang_no_topx_images = "Es konnten keine Bilder f&uuml;r diese Ansicht gefunden werden.<br />Bilder aus gesch&uuml;tzten Galerien werden nur angezeigt, wenn man sich dort zun&auml;chst angemeldet hat.";

$lang_tips_overview = array('Tip: Gelb umrandete Galerien haben neuere Bilder.','Tip: Wenn ihr wissen wollt, was ihr mit der Galerie alles machen k&ouml;nnt, geht doch einfach kurz auf die Hilfe.','Mit l &ouml;ffnet man den login.','Mit s &ouml;ffnet man die Suche');
$lang_tips_thumb = array('Tip: Links oben kann man direkt zu allen dar&uuml;berliegenden Ebenen springen.','Tip: Die Top 13 auf dieser Seite zeigt nur die meistbesuchten Bilder dieses Verzeichnisses.','Mit l &ouml;ffnet man den login.','Mit s &ouml;ffnet man die Suche');
$lang_tips_image = array('Tip: Man kann um zum n&auml;chsten/letzten Bild zu kommen auch die links/rechts Pfeile der Tastatur benutzen.','Tip: Wenn ihr euch rechts oben anmeldet, k&ouml;nnt ihr z.B. Titel eingeben, Kommentare l&ouml;schen und Bilder permanent drehen.','Tip: Es k&ouml;nnen bei Kommentaren und Titel auch Smilies wie :) oder ;) eingegeben werden.','Tip: mit t &ouml;ffnet man die Titeleingabe, wenn man angemeldet ist','Tip: Mit K &ouml;ffent man die Kommentare', 'Tip: Mit i &ouml;ffnet man die Info', 'Tip: Mit o &ouml;ffnet man die Optionen','Mit l &ouml;ffnet man den login.');

// new 1.3
$lang_dl_as_zip1 = "Es ist m&ouml;glich, alle Bilder dieses Verzeichnisses in einem Archiv herunterzuladen.<br />M&ouml;chten Sie das ganze Verzeichnis herunterladen oder weiter zum Original des aktuellen Bildes?";
$lang_dl_as_zip2 = "Aktuelles Bild";
$lang_dl_as_zip3 = "Alle";
$lang_dl_as_zip4 = "In dieser Session nicht mehr nachfragen."; // we store this is the session

$lang_download_counter = "Downloads";
$lang_download_counter_short = "dl";
// not used in 1.3 yet!
$lang_email_subscribemail_2_subject = "Bitte best&auml;tigen Sie ihre Anmeldung an die TinyWebGallery";
$lang_email_subscribemail_2 = "Lieber TinyWebGallery-Benutzer:\n\nSie haben sich an einem Verteiler der TinyWebGallery angemeldet. Damit die Anmeldung g&uuml;ltig wird, m&uuml;ssen Sie diese best&auml;tigen. Bitte klicken Sie auf den nachfolgenen Link\n%s\num die Registrierung abzuschliessen.\n\nIhre TinyWebGallery";
// ---
$lang_rating = "Bewertung";
$lang_rating1 = "1";
$lang_rating2 = "2";
$lang_rating3 = "3";
$lang_rating4 = "4";
$lang_rating5 = "5";
$lang_rating_button = "Bewerten";
$lang_rating_text = "Hier k&ouml;nnen Sie das aktuelle Bild bewerten:";
$lang_rating_new="Neue Bewertung: ";
$lang_rating_vote="Stimmen";

$lang_rating_security="Bitte tragen Sie die 4 Zeichen<br />des Sicherheitsbildes ein [A-F,0-9]:";
$lang_rating_help="Klicken Sie auf das Bild,<br />wenn Sie es nicht erkennen k&ouml;nnen.";
$lang_rating_message1="Sie haben das Bild schon bewertet.";
$lang_rating_message2="Bitte schliessen Sie dieses Fenster. Die Anzeige der Bewertung wird nach der n&auml;chsten Aktion aktualisiert!";
$lang_rating_message3="Vielen Dank f&uuml;r die Bewertung.";
$lang_rating_message4="Sie haben leider einen falschen Code eingegeben.";
$lang_rating_send="Senden";

$lang_fileinfo="Info";
$lang_fileinfo_name = "Dateiname";
$lang_fileinfo_date = "Datum";
$lang_fileinfo_size = "Gr&ouml;sse";
$lang_fileinfo_resolution = "Aufl&ouml;sung";
$lang_fileinfo_views = "Anzeigen";
$lang_fileinfo_dl = "Downloads";
$lang_fileinfo_rating = "Bewertung";
$lang_fileinfo_not_available = " - (remote)";
$lang_exif_not_available = " - ";
// please check the constants in the file inc/exifReader.inc.php for exif entries you can try - not all are available on all cameras! sometimes the constants don't work - try to google for the real exif field name!
$lang_exif_info = array("Kameramodel" => "model", "Exif Datum" => "DateTime", "Brennweite" =>
"focalLength", "Blende" => "fnumber", " Belichtungszeit" => "exposureTime", "ISO" => "isoEquiv");

$lang_comments = "Kommentare";
$lang_last_comments="Neueste Kommentare";
$lang_show_kommentar="Kommentare lesen";
$lang_add_kommentar="Kommentar hinzuf&uuml;gen";
$lang_close_fullscreen="Zur&uuml;ck zur normalen Ansicht";

$lang_search_results="Suchergebnisse";
$lang_search_back="Zur&uuml;ck zu den Suchergebnissen";
$lang_search="Suche";
$lang_search_text="Bitte geben Sie Ihren Suchbegriff ein:";
$lang_search_button="Suchen";
$lang_search_where="Suchen in";
$lang_search_max="Treffer pro Seite";
$lang_search_all="Alle";
$lang_search_hits="Es wurden %s Treffer gefunden.";

// new 1.5
$lang_download="Download";
$lang_search_folders="Verzeichnisse";
$lang_search_latest="Neueste Uploads";
$lang_video_disabled="<center>Der interne Bandbreitentest hat festgestellt, das die aktuelle Verbindung sehr langsam ist.<br>Videos w&uuml;rden sehr lange brauchen, wenn diese embedded angezeigt werden.<br>Aus diesem Grund wurden Videos deaktiviert!</center>";
$lang_search_days = "Tage";

// new 1.6
$lang_open_all="Alle &ouml;ffnen";
$lang_close_all="Alle schliessen";
$lang_login_php_enter = "Bitte geben Sie Benutzername/Passwort ein,<br />um die erweiterten Funktionen zu nutzen:";
$lang_login_php_enter_again = "Falscher Benutzername/Passwort<br />Bitte erneut eingeben:";
$lang_username= "Benutzername";
$lang_password= "Passwort";
$lang_language= "Sprache TWG Admin";
$lang_menu_upload="Upload";
$lang_allowed_html_tags="Erlaubte Html Tags:";
$lang_menu_tags="Tags";
$lang_menu_top_tags="Top&nbsp;Tags";
$lang_tag_enter="Bitte geben Sie die Tags f&uuml;r dieses Bild und/oder das ganze Verzeichnis ein.<br/>Trennen Sie Tags mit einem Komma (,).";
$lang_tag_enter_image="Bild-Tags";
$lang_tag_enter_dir="Verzeichnis-Tags";
$lang_tag_enter_header="Top %s Tags";
$lang_no_tags="Keine Tags gefunden.<br/>Nur Tags von ungesch&uuml;tzten bzw. entsperrten Alben werden angezeigt.";
$lang_search_tags="Suche Tags";
$lang_iptc_info = array("Beschreibung" => "2#120", "Autor" => "2#122,2#080", "Copyright" => "2#116", "Quelle" => "2#115", "&Uuml;berschrift" => "2#105,2#005");

// new 1.7
$lang_refresh_album_cache="Bitte aktualisieren.<br>Der Albumcache ist noch nicht erzeugt.";
$lang_register_header="Registrierung";
$lang_register_req="Bitte alle Felder ausfüllen.";
$lang_register_error_user="Der Benutzname darf nur a-z,A-Z,0-9,- und _ enthalten.";
$lang_register_id="Registrierungs Id ist nicht gültig.";
$lang_register_security="Sicherheitsbild ist nicht gültig.";
$lang_register_inuse="Dieser Benutzername wird bereits benutzt<br>Bitte einen anderen auswählen.";
$lang_register_nouser="Der Benutzer konnte nicht erzeugt werden.</p><p>Bitte kontaktieren Sie den Administrator der Galerie.";
$lang_register_created="Das Benutzerkonto wurde erfolgreich angelegt.";
$lang_register_upload="Das Uploadverzeicnis ist:";
$lang_register_upload2="Man kann sich in diesem Verzeichnis rechts oben anmelden und dann seine Bilder mit dem TFU Flash Uploader verwalten indem man 'Upload' klickt.";
$lang_register_upload3="Viel Spaß.";
$lang_register_dir="Das Verzeichnis konnte nicht erzeugt werden.</p><p>Bitte kontaktieren Sie den Administrator der Galerie.";
$lang_register_intro="Bitte geben Sie einen Benutzernamen und ein Passwort an. Der Benutzername wird als Verzeichnisname für Ihr Album verwendet.";
$lang_register_askid="Bitte kontaktieren Sie den Galerieadministrator für die Registrierungs Id.";
$lang_register_regid="Registrierungs Id";
$lang_register_ip="IP:";
$lang_register_here="Registrieren";
$lang_register_security_image="Sicherheitsbild";
$lang_register_button="Registrieren";
$lang_print='Drucken';
$lang_root_mode_access='Direkter Zugang zur Galerie ist im multi root Modus nicht erlaubt.';
$lang_root_mode_login='Sie haben keine Berechtigung dieses Album anzuzeigen.';
$lang_mobile='Handymodus';

// new 1.8.x
$lang_right_message='Rechtsklick ist deaktiviert!';
$lang_edit_menu='Editieren';
$lang_edit_default = 'Standard';
$lang_edit_folder_name = 'Albumname';
$lang_edit_folder_name_tooltip = 'Der Albumname wird in der foldername.txt im Albumordner gespeichert.';  
$lang_edit_folder_description = 'Albumbeschreibung';
$lang_edit_folder_description_tooltip = 'Die Albumbeschreibung wird in der folder.txt im Albumordner gespeichert. Der Text wird auf der Hauptseite bzw. Vorschaubildseite gezeigt und kann auf der Detail&shy;seite aktivert werden, indem man $enable<wbr>_dir<wbr>_description<wbr>_on_<wbr>image setzt.';
$lang_edit_lang_all = 'Alle';
$lang_edit_iptc_help="Kopiert die IPTC Daten in das nachfolgende Textfeld.";
$lang_last_album='Letztes Album';
$lang_next_album='Nächstes Album';
//replacer - do not remove

// position of the language dropdown - please check if the settings match for your language!!
$lang_xpos_lang_dropdown=200; // this is only needed if you include twg and ie does not position the language dropdown correct because you include twg in several divs - in a fixed layout you can adjust this here - if you don't have a fix layout don't use the dropdown - use the normal setting!
?>