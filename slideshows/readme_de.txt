/*******************
  Copyright (c) 2004-2014 TinyWebGallery
  written by Michael Dempfle
  TWG version: 2.2
********************/

Readme - TinyWebgallery v2.2

Die komplette Anleitung findet ihr auf der Webseite
www.tinywebgallery.com

Systemvoraussetzungen
---------------------
Ihr braucht Webspache mit php >= 4.3.0 und gdlib > 2.0 und ein paar schöne Bilder oder Videos!
Optional: Flash 8 Plugin für den TWG Upload Flash.

Installation
------------
1. Auspacken des Archivs (habt ihr ja schon geschafft.)
2. Auf den Webserver kopieren.
3. Die Cache-Verzeichnisse (cache, counter, xml) mit allen Rechten versehen (chmod 777
   manche Server erlauben nur 755, je nach dem, wie php gestartet wird - das ist dann o.k.).
   Um den TWG Admin zu nutzen muss man noch der Datei admin/_config/.htusers.php Schreibrechte
   geben, um Passwörter ändern zu können!
   Die Einstellungen findet ihr bei allen FTP-Clients. how-to 1 zeigt, wie man TWG noch
   sicherer machen kann.
4. Startseite aufrufen (index.php).
   TWG Admin zum konfigurieren (admin/index.php).
   Beim Upload-Flash muss evtl. noch eine .htaccess Datei in das Verzeichnis des TWG Upload
   Flash enpackt werden. Dies befindet sich im Ordner admin/upload. Am einfachsten
   probiert man den Upload Flash einfach aus (Upload im TWGXplorer). Wenn die Datei benötigt 
   wird, gibt dieser eine Warnung aus! Bitte geht zum TWG Flash Uploaderbereich auf der Webseite
   für weitere Infos.

-  Bei Fehlermeldungen überprüft bitte zuerst, ob die Rechte gesetzt wurden.
   Auf der Webseite gibt es ein Forum, ein paar sehr nette how-tos und eine FAQ - wenn euch die 
   nicht weiterhelfen schickt einfach eine Email.
-  Wenn die Demogalerie funktioniert könnt ihr eure Bilder in das pictures Verzeichnis kopieren.
   Löscht am besten alle Dateien in diesem Ordner. Ich finde immer wieder Installationen,
   wo z.B. die folder.txt nur in einer Sprache angepasst wurde (das Beispiel hat eine deutsche
   und eine englische version von folder.txt!).
-  Wenn ihr die Galerie unterstützen wollte, gebt mir doch etwas Feedback, klickt auf
   die Werbung auf der Webseite oder bewertet die TWG (links sind auf der Webseite vorhanden).
   Wenn ihr das "powered by TWG" entfernen wollt oder die Galerie nicht zu privaten Zwecken nützt
   würde ich mich über eine kleine Spende per Paypal freuen (paypal ( a t ) mdempfle . de). 
-  Wenn mal alles läuft, geht bitte auf die Webseite und schaut euch die how-to's an. Es
   gibt jede Menge Möglichkeiten, die Galerie noch effektiver und besser zu nutzen. 
   
Konfiguration
-------------
Ihr könnt nun TWG nach euren Wünschen konfigurieren.
TWG Admin:
	In der Administration könnt ihr unter Configuration alle wichtigen Parameter von
	TWG einstellen. Viele der Parameter auf den verschiedenen Reitern haben noch 
	weitere detailiertere Einstellungen. Diese sind in der config.php oder auf der 
	Webseite beschrieben! Die zusätzlichen Parameter könnt ihr unter 'Additional'
	eintragen.
	Mit dem Color Manager könnt ihr die Farben von TWG einstellen. Wählt eine Farbe und 
	klickt auf die verschiedenen Bereiche auf der rechten Seite. Dann könnt ihr ein
	Style sheet erzeugen und dies auch speichern! Weitere Einstellungen müsst ihr manuell
	eintragen. Der Color Manager macht immer ein Backup und überschreibt immer das letzte 
	my_style.css. Der aktuelle Style kann nicht geladen werden!
	Ihr könnt auch transparent als Farbe wählen. Die Hintergrundbilder sind nur zur Demo
	enthalten. Bitte lest how-to 9. Dort wird beschrieben, wie man Hintergrundbilder definieren
	kann. 

Manuell:
	Alle Parameter sind entweder in der config.php oder fast alles, was mit Layout zu tun hat in der
	style.css (Schaut euch den Color Manager mal an - dort könnt ihr ein style sheet zusammenklicken
	und dann als my_style.css speichern!) - dort und auf der Webseite ist auch alles 
	nett beschrieben. 
	In der my_config.php habe ich die wichtigsten Einstellungen aus der config.php extrahiert.
	Hier solltet ihr anfangen TWG zu konfigurieren. Wenn ihr eine Einstellung noch weiter 
	konfigurieren wollt, schaut in der config.php nach!
	Einstellungen in der my_config.php überschreiben immer die Einstellungen in der config.php.
	Speichert eure Änderungen immer in der my_config.php bzw. my_style.css. Dann könnt ihr 
	später auch mit dem Installer ein einfaches update machen!
	Verfahrt ebenso mit der style.css und my_style.css. Das style sheet für die iframes ist im
	i_frame folder zu finden.

Im examples Verzeichnis finden sich  ein paar andere interessante Dateien wie z.B. die 
overview.htm, welche  alle 5 Sekunden ein anderes Zufallsbild auf einem Album anzeigt. 
Siehe examples/readme.txt. Per default ist auch ein Wasserzeichen eingestellt. Dieses könnt 
ihr im config oder im TWG Admin abstellen bz.w euer eigenes nehmen.

Wenn die Demogalerie funktioniert könnt ihr eure Bilder in das pictures Verzeichnis kopieren.
Löscht am besten alle Dateien in diesem Ordner. Ich finde immer wieder Installationen,
wo z.B. die folder.txt nur in einer Sprache angepasst wurde (das Beispiel hat eine deutsche
und eine englische version von folder.txt!)

Setzt das flag $cache_dir auf true nachdem ihr mit eurem Setup fertig seit!
Im TWG Admin ist das: Enable session caching of directorys and files 

Bitte beachten:
	Wenn ihr Änderungen bei der Bildergrössen an der config (my_config.php) macht, müsst ihr die 
	Bilder im cache-Verzeichnis löschen!
	UND LEST DIE how-to'S: Es gibt viele Sachen in TWG, die man einstellen kann, indem man die 
	entsprechenden Dateien in einem Verzeichnis benutzt. Z.B. Album Beschreibungen, Passwortgeschützte
	Albums, individuelle Styles und Hintergründe und noch vieles mehr. Eine kleine Übersicht ist
	how-to 17!

Registrierung
-------------
TWG kann für den privaten und kommerziellen Bereich kostenlos genutzt und modifiziert werden. 
Man kann aber TWG gegen eine geringe Gebühr registrieren, so dass Sie Ihre TWG-Version ohne 
den sonst üblichen Backlinkverweis und das "powered by TWG" unten auf der Seite bzw. der 
Werbung im Backend verwenden können. Bitte geht zur Webseite um euch zu registrieren!
Das Wasserzeichen, das auf den Bildern ist, ist nur zur Demonstation und kann
selbstverständlich verändert bzw. entfernt werden.
Wenn ihr TWG unterstützen wollt, könnt ihr selbstverständlich auch ohne Registrierung 
etwas per paypal oder Überweisung spenden! Vielen Dank!


Als Bonus erhalten registrierte User noch folgende Funktionen:
- Albumbeschreibungen - Diese sind in der DHTML Demo auf der 1. Übersichtsseite zu sehen. 
- Lightbox-Feature. Auf der Vorschauseite, der TopX und der Bilderseite kann man das Lightbox-Script 
  aktivieren, was eine schnelle Vorschau in einer Art Overlay zeigt. In der Demo DHTML sieht man in 
  den Ecken der Thumbs kleine Lupen, auf die man klicken kann und auf der Bilderseite wird das das 
  maximierte Bild ebenfalls mit dem Lightbox-Script angezeigt.
- Im TWG Admin gibt es unter Configuration die Möglichkeit, alle Cache-Bilder in voraus zu erzeugen.
- Eine Übersicht über alle Verzeichnisse im pictures Verzeichnis (mit Anzahl der Bilder, Grösse)
 
Erweiterter Support
------------------
Wenn ihr eine personalisierte Version der TWG  haben wollt oder spezielle 
Wünsche habt, könnt ihr euch gerne an mich persönlich wenden.
Kontaktiert mich per E-Mail wenn ich das für euch erledigen soll!

Administration
--------------
TWG hat nun auch ein nettes Backend, wo man seine Bilder verwalten kann, TWG konfigurieren,
Bilder hochladen, ein Stylesheet mit dem Color Manager generieren kann und noch einiges mehr. 

Direkte Url: admin/index.php

Für den ersten login:

login: admin
password: twg_admin

Das Passwort muss beim 1. Login geändert werden!
Mann kommt direkt oder über das Menü von TWG zur Administration.
Wenn der Link rot ist, ist noch das Default-Passwort eingestellt!
Der Link zur Administration kann mit dem Parameter 
$show_public_admin_link ein/ausgeblendet werden.

Viel Spaß,

Michael Dempfle (tinywebgallery ( a t ) mdempfle . de)

www.tinywebgallery.com
