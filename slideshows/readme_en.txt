/*******************
  Copyright (c) 2004-2014 TinyWebGallery
  written by Michael Dempfle
  TWG version: 2.2
********************/

Readme - TinyWebgallery v2.2

Please go to the web site (Installation) for the full English documentation!

www.tinywebgallery.com

What you need
-------------
php >= 4.3.0, gdlib > 2.0 and some nice pictures.
Optional: Flash 8 Plugin to use the TWG Upload Flash.

Installation
------------
1. Extract the archive to a directory
2. Copy TWG to your web server.
3. Change the permissions of cache, counter, xml to 777 (chmod 777 - some server do
   not allow this depending how php is running - please use 755 then!). 
   If you want to use the TWG Admin you have to make the file admin/_config/.htusers.php 
   writeable to be able to change passwords!
   You should be able to find chmod somewhere in your FTP client. 
   Check how-to 1 to make TWG more secure later!
4. Start TWG by calling index.php.
   Start TWG Admin by calling admin/index.php.
   To use the Upload Flash you maybe have to copy a .htaccess file to the directory of the
   upload flash (admin/upload). The file is stored in a zip in this directory. Simply try
   the Upload Flash (Use Upload in the TWGXplorer). It will tell you if you need to extract 
   the .htaccess file. Please go to the TWG Flash Uploader section of the  website for more
   support.

-  If you get any errors - please check the permissions of the cache folders.
   On the web page is a forum a FAQ and a couple of nice how-to's - check them.
   If TWG still does not work just contact me (forum or email).
-  If the demo gallery works you can copy your images into the pictures directory.
   (And delete mine ;) - delete/change the folder*.txt too!)
   TWG does lots of caching. Please close your browser to refresh the cache.
   There is a flag called $cache_dirs in the config.php - set this to false during
   testing - make sure to set this back to true when TWG is running because of best
-  If you want to support TWG please give feedback, click on some ad's on the website,
   vote for TWG (links are on the website) or register TWG.
   If you want to remove the "powered by TWG" please read below!
-  If everything is running please go to the website and read the how-to's. 
   There are many possibilities, to use TWG better and more effective. 

Configuration
-------------
Now you can configure TWG.
TWG Admin:
  You can set all important parameters under 'Configuration' in the TWG Admin.
  Most of the options there can be even be configured in more detail. The 
  description can be found in the config.php or on the website. You can add this
  Parameters in the additional tab.
  You can change the colors of TWG with the Color Manager. Simply select a color
  and click on on of the areas on the right side. Then you can create a style sheet
  and save it as your new style! The Color Manager does always a backup of your my_style.css.
  You should delete old styles if you don't need them anymore. Please note that your current
  style cannot be loaded!
  Transparent is a color too! The background images are only for demonstration. Please read
  how-to 9 how to add backgrounds to TWG.

Manuel:
  TWG has two config files. my_config.php and config.php. my_config.php has the main settings 
  for TWG and config.php has all possible parameters. If you want to config TWG in more detail 
  go to the config.php and look for the settings you want to change. Store the new settings in 
  the my_config.php. 
  If you want to change the colors of TWG you can use the Color Manager and store the style sheet 
  in my_style.css. Most style settings can be found in the style.css you can set. Store changes 
  in my_style.css.
  If You store your settings in the my_* files it makes it easier to update TWG! All parameters
  are described on the website too!
  
You can find some interesting files in the examples folder (like how to include TWG, a random 
image generator in overview.htm ...). See the examples/readme.txt. As default there is a 
watermark shown as example. You can of course disable watermarks or use your own. You find
this settings in the TWG Admin or in the config file!

If the demo gallery does work please copy your images to this folder and delete mine :).
Please make sure to delete the folder.txt to (or at least change it.). 

Please set $cache_dir to true after you are done with the setup!
In TWG admin this is : Enable session caching of directories and files

Please note:
  If you make any changes at file sizes in the config (my_config.php) you have to delete the images
  in the cache directory.
  AND READ THE HOW-TO'S: There are many things you can configure with files you put in a folder
  like - directory description, protecting galleries, individual styles and backgrounds ... 
  How-to 17 gives a quick overview of the possibilities!

Registration - Removing "powered by TWG"
----------------------------------------
TWG can be used for free and modified for private and commercial usage. You can register
TWG for a small fee if you want to remove the "powered by TWG" at the bottom, the back link 
and the ad's in the backend. Please go to the web site to register TWG.
The watermark on the images is only for demonstration and can be removed or modified in the config
or the TWG Admin.
If you want to support TWG you can of course donate without registration via paypal
or bank transfer (bank transfer in EU only). Thank you.

As bonus you get the following features too:
- Album description - You can see an example on the overview page of the DHTML demo.
- Lightbox-Feature. On the thumbnaill page, the TopX and the image page you can activate the Lightbox-Script. 
  It's like a quick view of he detail images in an overlay. 
  Please go o the DHTML demo to see it in a working example. 
  On the thumbnail page you have small zoom icons on every thumb. 
  On the detail page the maxmized image is shown with the Lightbox-Script too. 
- Generation of all cache images in the TWG Admin
- An overview over the pictures folder (all folders, number of images, size)

Extended Support
------------------
If you would like a personalized version of TWG or you have special wishes to extend TWG 
fell free to contact me if should do this for you! 

Administration
--------------
TWG does now have a nice backend for managing files, config TWG, uploading, color manager ...

Url:  admin/index.php

For the first login use

login: admin
password: twg_admin

You are asked to change this password at the first login!
The administration link is shown in the menu and is red if you
have the default password! You can hide the link by setting
$show_public_admin_link = false;

Have fun,

Michael Dempfle (tinywebgallery ( a t ) mdempfle . de)

www.tinywebgallery.com
