/*******************
  Copyright (c) 2004-2014 TinyWebGallery
  written by Michael Dempfle
  TWG version: 2.2
********************/

Readme - TinyWebgallery v2.2


Merci de visiter le site web (rubrique installation) pour une documentation compl�te (en Anglais)

www.tinywebgallery.com

Ressources n�cessaires
-------------
php >= 4.3.0, gdlib > 2.0 et quelques belles photos.
Option : Plugin Flash 8  pour utiliser TWG Upload Flash.

Installation
------------
1. D�compresser l'archive dans un r�pertoire 
2. Copier TWG sur le serveur
3. Changer les permissions des r�pertoires cache, counter et xml en 777 ou 755 si votre serveur refuse le chmod 777
   Si vous voulez utiliser l'interface TWG admin vous devez permettre l'�criture dans le fichier "admin/_config/.htusers.php", 
   indispensable pour modifier les mots de passe 
   Pour modifier les chmod, utilisez les propri�t�s de votre client FTP
   Consultez HOW TO #1 pour mieux s�curiser ult�rieurement TWG
4. D�marrez l'install en lan�ant le fichier index.php.
   D�marrez TWG Admin en lan�ant le fichier admin/index.php.
   Pour pouvoir utiliser le Upload Flash, vous devez pr�alablement placer un ".htaccess" dans le r�pertoire admin/upload. 
   Le fichier est pr�sent dans le r�pertoire, au format zip.
   Il suffit de lancer l'upload et il demandera si vous voulez extraire le fichier. 
   Pour de plus amples informations, consultez la section TWG Flash Uploader du site internet.

-  Si vous rencontrez ds erreurs, v�rifiez les permissions des r�pertoires cache. Quelques informations int�ressantes (en Anglais) 
   se trouvent sur le forum, dans la FAQ.
   Si malgr� tout vous ne parvenez pas � lancer l'application, contactez moi par courriel (en anglais ou en en allemand) 
   ou pr�f�rentiellement via le forum.
-  Si la galerie d�mo fonctionne vous pouvez uploader vos propres photos dans le r�pertoire "pictures" (et �ventuellement supprimer celles de la d�mo).
   Effacez ou changez �galement tous les fichiers *.txt
   TWG g�n�re du cache Pensez � refermer votre navigateur pour le vider.
-  Il y a un flag nomm� "$cache_dirs" dans le fichier config.php - modifiez le sur "false" pendans votre phase de test 
   mais n'oubliez pas de le remettre a "true" une fois la configuration valid�e.
-  Si vous voulez aider TWG, merci de m'envoyer vos commentaires et remarques, cliquez sur les liens publicitaires du site,
   exprimez votre vote pour TWG (liens pr�sents) ou enregistrez votre application (voir ci-dessous).
-  Si vous voulez supprimer le "powered by TWG" merci de vous reporter au paragraphe enregistrement ci-dessous !
-  Si tout fonctionne normalement, consultez les HOW TO sur le site, il y a de tr�s nombreuses possibilit�s de rendre TWG 
   encore plus efficace et encore plus agr�able.
 

Configuration
-------------
Vous pouvez maintenant configurer TWG.

TWG Admin:

  Vous pouvez personnaliser l'essentiel de l'application depuis l'option 'Configuration' du TWG Admin.  
  La plupart de ces options peut �tre configur�e plus en d�tail : description dans config.php ou directement sur le site web.
  You can add this Parameters in the additional tab.
  Vous pouvez modifier les couleurs avec le Color Manager. Il suffit de s�lectionner une couleur puis de cliquer sur une zone de la section de droite. 
  Puis vous pouvez cr�er une feuille de style et la sauvegarder comme VOTRE feuille de style personnelle ! Le Color Manager fait automatiquement
  une copie de votre "my_style.css.
  Vous pouvez supprimer les anciens styles si vous n'en avez plus l'usage
  Please note that your current style cannot be loaded!
  "Transparent" c'est aussi une couleur ! 
  Les images de fond sont mises �� titre d'exempleThe background images are only for demonstration. 
  Consultez le HOW To n�9 pour savoir comment ajouter des fonds � TWG.

Manuel:

  TWG poss�de deux fichiers de configuration : "my_config.php" et "config.php". 
  "my_config.php" contient les param�tres essentiels (basiques) de l'application alors que c'est dans 
  "config.php" que vous trouverez tous les param�tres modifiables. 
  Si vous voulez affiner � l'extr�me vos param�trages, allez dans "config.php" et recherchez y chaque param�tre 
  que vous souhaitez modifier. Copiez les param�tres modifi�s dans le fichier "my_config.php". 
  Si vous souhaitez modifier les couleurs de TWG, utilisez Color Manager et enregistrez la feuille de style dans "my_style.css". 
  La plupart des styles modifiables se trouvent dans "style.css". Toutes les modifications doivent �tre enregistr�es dans "my_style.css".
  Si vous enregistrez vos modifications dans les fichiers my_* correspondants, cela facilitera vos mises � jour de l'application.
  Tous les param�tres sont �galement d�crits dans le site web !!
  
  Vous trouverez des fichiers int�ressants dans les dossiers d'exemple tels que comment ins�rer TWG, comment utiliser un g�n�rateur 
  al�atoire d'aper�u. Consultez le fichier "examples/readme.txt". 
  La configuration par d�faut inclut une "watermark" (surimpression pr�sente sur chaque photo). 
  Vous pouvez bien s�r d�sactiver cette fonctionnalit� ou ins�rer votre propre watermark.
  Ce param�tre se trouve dans TWG admin ou dans le fichier config.

  Si la galerie d�mo fonctionne convenablement, placez vos propres photos dans ce r�pertoire et supprimez les photos d�mo.
  N'oubliez pas de supprimer le "folder.txt" ou, au moins, renommez le !!

  Pensez � remettre "$cache_dir" sur true une fois achev�e la configuration !!
  Dans TWG admin c'est l'option : Enable session caching of directories and files

Note importante :

  Si vous apportez un changement de la taille des images dans la configuration (my_config.php), vous devez
  imp�rativement supprimer les fichiers contenus dans le r�pertoire cache !!
  
  ET LISEZ LES HOW-TO'S : il y a un tas de param�tres que vous pouvez configurer au moyen de fichiers plac�s dans un r�pertoire ad�quate,
  comme par exemple  directory description, protecting galleries, individual styles and backgrounds ... 
  How-to #17 vous donne un aper�u de ces possibilit�s !


Enregistrement - Suppression de "powered by TWG"
------------------------------------------------
TGW peut �tre utilis� et/ou modifi� dans le cadre d'un usage priv�, ou commercial
Vous devez enregistrer votre version (contribution modeste) si vous souhaitez supprimer la mention
 "powered by TWG" at the bottom, le lien  ainsi que l'insert publicitaire de bas de page.
Merci d'aller directement sur le site pour enregistrer votre version de TGW.
La "watermark" sur les images est pr�sente uniquement pour la d�mo et peut �tre soit supprim�e, soit modifi�e 
soit � partir de l'Admin, soit dans le fichier config.
Si vous voulez aider TWG, vous pouvez faire un don,  m�me sans vous enregistrer, soit via Paypal, soit par ch�que bancaire (en �uros seulement).
Par avance, merci.

En bonus vous disposez des fonctionnalit�s suivantes :
- Description d'Album. Voir exemple dans la d�mo DHTML.
- Lightbox-Feature. On the thumbnaill page, the TopX and the image page you can activate the Lightbox-Script. 
  It's like a quick view of he detail images in an overlay. 
  Voir comment �a marche dans la d�mo DHTML. 
  Sur la page de vignettes vous disposez de petites icones de zoom pour chaque vignette.
  On the detail page the maxmized image is shown with the Lightbox-Script too. 
- G�n�ration d'un cache images dans TWG Admin
- Un aper�u des dossiers d'images (tous les dossiers, nombre d'images, taille...)


Support personnalis�
--------------------
Si vous souhaitez une assistance personnalis�e (version sp�ciale ou demande particuli�re, 
merci de me contacter directement (en Allemand ou en Anglais)

Administration
--------------
TGW poss�de une interface d'administration pour g�rer les fichiers, configurer, mettre � jour, changer l'aspect, etc.
Url : "admin/index.php"

Pour votre premier log utilisez ces codes :

login: admin
password: twg_admin

Il vous sera demand� de changer le mot de passe lors de votre premier log !
Le lien vers l'administration restera en rouge tant que vous conserverez le mot de passe par d�faut
Pour cacher ce lien, faites cette modification :
$show_public_admin_link = false;


Have fun,

Michael Dempfle (tinywebgallery ( a t ) mdempfle . de)

www.tinywebgallery.com


