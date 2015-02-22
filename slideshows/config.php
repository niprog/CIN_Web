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
/* Configuration file 2.2 - Please use line wrap to see the documentation of each parameter
or go to the website. The parameters are now nicely grouped
**********************************************************************
-----------------------     PLEASE NOTE       ------------------------
**********************************************************************
Don't make any changes here! Use the file my_config.php.
This makes it easier for migration to a new version and gives you a
better overview about your changes!
my_config.php overwrites the settings of this file. So many changes
you would make here are then not used!!!
**********************************************************************
----------------------------------------------------------------------
**********************************************************************
*/
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
/*
  	Section: Image settings
    Here you can set image sizes, number of images displayed on each page ...
*/
$menu_x = 4;                           // (Number) Number of albums which are shown in a row on the overview page.
$menu_y = 3;                           // (Number) Number of rows on the overview page.
$hide_overview_image_border = false;   // (true/false) Shows or hides the border around the images on the overview page
$autodetect_maximum_thumbnails=true;   // (true/false) twg tries to display as much thumbnails as possible without creating scrollbars - is turned off in low bandwidth mode!
  $thumbnails_x = 6;                   // (Number) Number of images in a row on the thumbnail page.
  $thumbnails_y = 4;                   // (Number) Number of images in a column on the thumbnail page.
  $thumb_cellpadding = 1;              // (Number) You can now change the padding of the thumbs on the thumbnail page - 0,0 is no space between thumbs
  $thumb_cellspacing = 1;              // (Number) You can now change the spacing of the thumbs on the thumbnail page - 0,0 is no space between thumbs
$number_top10 = ($thumbnails_x * ($thumbnails_y -2)) + 1; // (Number) Number of images that are shown in the top views page. The existing calculation (13) works nice with the existing layout; The last row of the top x is alwys filled - therefore more then number_top10 images can be shown!
$small_pic_size = 400;                 // (Number) max pic size - please read the description of $use_small_pic_size_as_height (at the end) before you set this!
	$resize_only_if_too_big=false;       // (true/false)  If images are equal or smaller they are not resized if true. You can save disk space if you set this to true and resize all pictures with an external program before uploading. watermarks are not generated on his images becasuse the are not touched at all! if you need them - please insert them by yourself because you wanted to keep the quality of the images.
	$use_small_pic_size_as_height=true;  // (true/false)  use small_pic_size as height! - the small pic size restricts the picture to a maximum height and width of small_pic_size - therefore vertical and horizontal images have the same maximum side length. If you set this switch to true the size is used as maximum height. vertical images are then smaller then horizontal - but when you watch the images the navigation does not jump to the bottom if a vertical image is coming - If you use this please decrease the picture size by ~1/3 to get the vertical images in the same size as before (and delete the cache!!). The cross fade slideshow does appear smaller because the horizontal images are here still as big as the vertical ones.
  	$maxXSize = 800;                   // (Number)  If you have panorama images you can restrict the maximum width of an image - $use_small_pic_size_as_height has to be true that this restriction is needed! A panorama is assumed if the width/height > 1.5!
$thumb_pic_size = 120;                 // (Number) The thumbnail size - check the $show_clipped_images description. If this is set true the thumbnails appear bigger
$strip_thumb_pic_size=100;             // (Number)  You can show the thumbs for the big navigation in a different size then on the thumbnail page! Does only work if clipped images are used.
$show_thumbs_as_text=false;            // (true/false) Shows the thumbstrip of the details page as text if true.
$menu_pic_size_x = 120;                // (Number) Width of the gallery overview pictures -  has to be dividable by 2 if using $show_colage=true; if $show_colage=false; please use the same scale as the pictures have to get the nicest results.
$menu_pic_size_y = 120;                // (Number) Height of the gallery overview pictures -  has to be dividable by 2 if using $show_colage=true; if $show_colage=false; please use the same scale as the pictures have to get the nicest results.
$compression = 80;                     // (Number) quality of the generated jpegs - best = 100 - but biggest size !! Don't use % here!
$compression_thumb = 85;               // (Number) new 1.3 - quality of the generated thumbnail jpegs - best = 100 - but biggest size !! I make them better quality because they are really small
$show_clipped_images=true;             // (true/false) Clipped images in the thumbnail view - all images will be shown as squares - if you change this - delete all thumbnails in the cache!!! The size of the images (x and y) will be $thumb_pic_size! remember - all thumbnails are squares then on the detail page you cannot see if a image is horizontal or vertical. remove all thumbnails from the cache folder after changing this!
$show_colage = true;                   // (true/false) Shows collage on the main page or the 1st image - you have to change the size of some preset images!
$use_random_image_for_folder=true;     // (true/false) If true a random image of this folder is picked for the collage or the image which is shown in a folder icon.
$show_languages_as_dropdown=true;      // (true/false) Show language flags or as a kind of dropdown
$folder_effect='fade';                 // (String) There are 3 effects for the main gallery view 'fade', 'gray' and  'change' (change the images with another from the directory on mouseover!) - if you don't want an effect use '' or 'none' - this effects looks best under ie - ff does some flickering in modus fade! - gray only works for ie (fade effect in ff as backup) - fade only for ie and ff - change for all browsers!
  $fading_level = 80;                  // (Number) This is the level a picure is blured - 99 is max visibility! (100 would be like 10 because it is added after a .: 0.100 = 0.10 ;) - If you want 100 simply don't use the fading effect.)
  $gray_fading_level = 80;             // (Number) gray is only available for ie - other browsers fade with this setting
  $fade_all=true;                      // (true/false) Normaly only the image over the mouse is changed - if you set this to true all images of the collage are changed.
  $use_random_image_for_change=true;   // (true/false) If true a random image from the folder is used for switching - if false the one from the colage is used
$other_file_formats=array('mp4' => 'buttons/wm_html5.png', 'avi' => 'buttons/wm_avi.png', 'mpg' => 'buttons/wm_mpg.png','mpeg' => 'buttons/wm_mpg.png', 'pdf' => 'buttons/wm_pdf.png', 'mp3' => 'buttons/wm_mp3.png',  'divx' => 'buttons/wm_divx.png', 'wmv' => 'buttons/wm_avi.png', 'wma' => 'buttons/wm_avi.png', 'flv' => 'buttons/wm_flv.png', 'mov' => 'buttons/wm_mov.png', 'youtube' => 'buttons/wm_html5.png', 'webm' => 'buttons/wm_html5.png', 'ogv' => 'buttons/wm_html5.png' ); // (Array) Other file formats that can be downloaded - the ist parameter is the extension, the 2nd is the watermark image - If you don't like a watermark please use the wm_none.png file. The downloads are direct downloads - if it does not work check if the directory or filename conain special characters. This setting is also used for the watermark images of videos.


  $show_other_formats_at_thumb=false;  // (true/false) Other formats are opend on the thumbs page in a new window if you set this to true!
  $watermark_position=5;               // (Number) You can define the location of the watermark with this setting (top:  1  2  3, middle: 4  5  6, bottom: 7  8  9
  $watermark_transparency=60;          // (Number) You can also set the transparency of your watermark. 0 is no transparency - 100 max; Try your logo with different settings to get best results
$skip_thumbnail_page = false;          // (true/false) Skip thumbnail page - if you set this to true, the thumbnail page is not displayed - be careful if you have subdirectories some levels cannot be displayed if a level before has pictures as well (like the demo) - the up button does always jump to the overview page!
$auto_skip_thumbnail_page=true;        // (true/false) If you set this to true the thumbnail page is only shown if you have more then numberpics (=images in the thumbsstrip in the directory). Why show an overview if all images are shown on the next page anyway ;) - false shows the thumbspage everytime. If the big navigation is not shown the thumbspage is shown allways.
$other_file_formats_previews = array('avi' => 'buttons/border.jpg', 'mpg' => 'buttons/border.jpg', 'mpeg' => 'buttons/border.jpg', 'pdf' => 'buttons/border.jpg', 'mp3' => 'buttons/border.jpg', 'divx' => 'buttons/border.jpg', 'wmv' => 'buttons/border.jpg', 'wma' => 'buttons/border.jpg', 'flv' => 'buttons/border.jpg','mp4' => 'buttons/border.jpg', 'mov' => 'buttons/border.jpg', 'webm' => 'buttons/border.jpg','ogv' => 'buttons/border.jpg'); // (Array) You can specify images that are used by the TWG Admin when generating preview images for other filetypes. You don't have to provide a preview image anymore - simply create a default!
$use_image_magic=false;                // (true/false) You can use image magick to create the files in the cache folder. This are the thumbnails and the small images. image magick creates a little better images than gd and uses less memory! You have to have image magick installed on your server. Check info.pp and the howto for details! You still need gd lib for the other image types!
  $image_magic_path='convert';         // (String) This is the path to the convert command of image magick. If it's not in the path you have to add the full path here!
$autorotate_images = '';               // (String) ('','normal','invert') TWG can autodetect the orientation of images if your camera set this. The problem is that TWG does not know how you hold your camera. if you like no autorotation use '', If you want normal rotation use 'normal', If the images are all rotated 180 Degrees use 'invert'. I have set 'invert' as default because I always hold my camera like this + 2 other camera is tested did the same ;).
/*
		Section: Sorting
        In this section you can customize the sorting features of TWG
		If you change something of the sorting:  the directory structure is cached - click on the bandwidth icon to refresh the cache.
*/
$sort_images_ascending = true;         // (true/false) true: sorts the images ascending; false: descending  (date and filename!)
  $sort_by_date = false;               // (true/false) sorts the images by name if set to false - if set to true it tries to read the image exif data first - if  this fails it uses the filetime to sort! - read the faq for the settings you need on your server to get exif data! if you have a lot of images in a dir setting this to true could slow down the gallery because the data is read every time  a directory is read
	  $sort_by_filedate=false;           // (true/false) uses the last modified file date and is not searching for exif data. If false is looks for exif data and uses the file time only if no exif data is available.
$sort_albums = true;                   // (true/false) sometimes sorting is not wanted - I cannot tell how the sorting will be - but maybe exactly how you like it (most of the time it is the order the directories are created!)
  $sort_albums_ascending = true;       // (true/false) true: sorts the albums ascending (if $sort_album_by_date true = newest first); false: descending () - directory struture is cached - close your browser once after changing this parameter!
    $sort_album_by_date=false;         // (true/false) enables sorting of folders by last modified date - directory structure is cached - close your browser once after changing this parameter!
/*
		Section: Directories
        Here you can adapt all the directories - normally there is no need to change something here
		Make sure to set the permissions correctly (if you want to include the index.php read the description behind $install_dir)
*/
$iframe_include=false;                 // (true/false) PLEASE READ HOWTO 2 before you change this! When you include your galerie in an iframe set this to true - if not included a different doctype is used that does better layouting for ie - if included the doctype has to ce changed to avoid the reserved right border for the scrollbar. ie does not show all hover effects anymore if you set this to true! !! OPERA does not create scrollbars if you someone uses Opera in IE mode! you have to define the used height in IE if you get scrollbars - see the option below!
  $iframe_height_ie='99%';             // (String) If the height of iframes are smaller then 500px ie does not display them right - you have to define the heigth for ie that is used - normally this is around 4-5 pixel less then the height you have defined in your iframe - best is to have the color of your site the same bottom row
$php_include=false;                    // (true/false) This has to be set to true if you include (with include ....) - see the settings below !!
  $install_dir = '';                   // (String) This is ONLY needed if you include (with include ....) twg with php into an existing php page and twg is in a subdirectory! you have to enter the path from your including page to the twg installation  e.g. 'TinyWebGallery/'. The / at the end is needed!
  /* additional parameters for php_include can be found in config_internal.php - section php_include */
$basedir = 'pictures';                 // (String) The directory where the directories with the images has to be copied. The path has to be relative no absolute paths are allowed here!
$cachedir = 'cache';                   // (String) The directory where all generated images are cached. This directory has to be made read- and writeable on the web server. The path has to be relative no absolute paths are allowed here!
$counterdir = 'counter';               // (String) The directory where all counter stuff is stored. This directory has to be made read- and writeable on the web server. The path has to be relative no absolute paths are allowed here!
$xmldir = 'xml';                       // (String) The directory where all image titles and comments is stored. This directory has to be made read- and writeable on the web server. The path has to be relative no absolute paths are allowed here!

/*
		In this section you can enable or disable main features of TWG there are 3 sections - global, overview page + thumbnail page, detail page
*/
/*
   Section: Global settings
*/
$default_language = 'en';              // (String) The gallery is started with this language if no language from the browser can be read. This language file has to exist!  To add a new language you have to translate one of the existing language file (e. g. language/language_de.php - the name of the needed flag is language/language_de.gif) and copy it in the language directory (+ the flag).
$privatepassword = 'test';             // (String) To protect a gallery with a password you have to create an empty file with the name 'private.txt' in the directory you want to protect. If you want to protect a gallery with a different password you have to enter the password in the 'private.txt' file.
  $enable_external_privategal_login=false; // (true/false) Enables/disables to login a private gallery with a password - the password has to be added as parameter twg_private_login=<password>. The password is the plain password! - when the administration is available I will add a kind of encryption.
  $encrypt_passwords=false;            // (true/false) Enable/disable encryption of passwords in private.txt! - if you change this to true you have to generate your passwords with the provided password.php. Sha256 is used for the encryption. TWG has a password.php (or the TWG Admin) where you can generate your passwords!
  $autogenerate_private_png = true;    // (true/false) true : password protected galleries shows the 1st image with a lock on it - false: only the lock is displayed! - if you want to use your own: use private.png - the generated  images are stored in the cache with the prefix pi_
$user_login_mode = false;              // (true/false) If you enable this mode then protected galleries can be unlocked by a username/password. And in the private.txt you store the user names that should get access. Read howto 12 for details.
$user_login_mode_hide_gal = false;     // (true/false) In user login mode unlocked galleries can be completely invisible if you set this parameter to true. They show up after a valid login. Read howto 12 for details.
$browser_title_prefix= 'CIN Gallery'; // (String) This is the title which is shown in the browser title - you may change this to the name of your gallery
$default_gallery_title='Welcome to the TinyWebGallery'; // (String) This is the default title shown on the main page if no real $lang_titel is specified in the language file. If you want to have different titles for a language please adapt the language files!
$metatags='';                          // (String) You can add the content of an individual metatag here. Separte the entries with an ',' . Makes your gallery better to find in the web - metatags are only generated if $php_include=false. If nothing is provided the default TWG metatags are used
$metadescription='';                   // (String) You can add the content of an individual metatag description here. Separte the entries with an ',' . Makes your gallery better to find in the web - metatags are only generated if $php_include=false If nothing is provided the default TWG metatag description is used!
$show_border='TRUE';                   // (String) By default there is a border around TWG. If you integrate TWG is most of the time looks nicer if the left,right and bottom border are removed. This value can be set with url parameters too (twg_withborder=true or twg_noborder=true). This setting is cached in the session. You have to close all browser to see the changes!. Valid values 'TRUE' and 'FALSE';
$show_login = true;                    // (true/false) enables/disables the login button in the right upper corner
$show_new_window = true;               // (true/false) enables/disables the 'new window' button in the right upper corner and in the options pane.
  $new_window_x='auto';                // (String) the size of the new window - this setting work nice for the actual settings - please change them if you change the image sizes
  $new_window_y='auto';                // (String) if you enter 'auto' at this point for both values it is resized to the maximum your screen can do ;)
$enable_counter=true;                  // (true/false) enable/disable the counter in the left lower corner
  $show_counter=true;                  // (true/false) show the counter - if not shown the counter is still counting!
    $show_today_counter = true;        // (true/false) show the counter of today or only the overall counter
  $enable_counter_details=true;        // (true/false) enable/disable the detail popup when you move over the user counter
    $enable_counter_details_by_mouseover=true; // (true/false) If true the counter history does popup by moving over the counter, If false is by clicking on the counter!
$show_help_link=true;                  // (true/false) Shows the help link
$show_translator=false;                // (true/false) shows/hides the name of the translator if he/she was specified in the language file.
$left_htm_width = 200;                 // (Number)  TWG does support a file called left.htm - works like header.htm - only at the left side - You can put your own navigation there without haveing the troube to integrate TWG to your layout.
$enable_frontend_upload = true;        // (true/false) You can enable/disable the upload in the frontend. You have to enable this AND create users in the backend that have the permission to upload in the frontend!
$use_login_short_menu = false;         // (true/false) If you are logged in you get a couple of more entries in the menu. To keep your layout the fixed menu items can be displayed shorter (!st letter and a . Info -> I.) if you set this to true.
$disable_right_click=false;            // (true/false)you can disable the righclick in the gallery to protect your images - but if people turn off Javascript they can still copy - only usefully for dau's
$support_piclens=false;                // (true/false) (now called cooliris) if true a rss for all unprotected images is created. After login to a protected gallery an extra rss for all files is created! rss files are created in the background. Therefore it is possible that the files is not present right after the one day cache was removed - simply wait a couple of requests! This feature is disabled in multi root mode. Keep the filenames and directories simple if you use this (no spaces or special characters). The plugin has problem with the encoding.
$hide_top=false;                       // (true/false) (true/false) Show/hide the whole top menu.
$show_breadcrumb = true;               // (true/false) You can disable the breadcrumb.
  $hide_middle_folders_in_breadcrumb=true; // (true/false) The breadcrub can get really long - therefore the middle folders can be replaced by an ...  if you set this to true.
$hide_bottom=false;                    // (true/false) Show/hide the whole bottom part ( counter, bandwidth button ...). This is only possible in the registered version because it removed the powered by TWG too.
$use_lytebox = true;                   // (true/false) You can switch between the original lightbox and the new lytebox. Lytebox has the following enhancements: iframe support, only 40 kb instead of 100 kb and it has the keyboard support I added to the original litebox. Lytebox is the new default. If you find any problem you can still switch to the old mode - but please tell me. If no one complains i'll remove the original lightbox in the next major version.
// Selfregistration - only usernames with [a-z,A-Z,0-9,- and _] are allowed - please note: You are responsible for the stuff your users upload!
$enable_selfregistration=false;        // (true/false) you can enable selfregistration here. In the login window then a link where you can register appears. Please read the howto about self registration!
  $enable_id_registration='';          // (String) If you enter an id here than this id is needed on the registration page to register.
  $self_registration_security_image=true;  // (true/false) You can enable/disable that users need to enter a security image.
  $self_registration_basedir=$basedir; // (String) The directory where the user folders are generated - $basedir = maindir - add e.g an upload dir with : $basedir . '/upload' - the dir upload has to exist!
  $self_registration_create_userdir = true; // (true/false) if true each user gets a folder below $self_registration_basedir. If false the $self_registration_basedir is the user directory.
  $self_registration_functions='3';    // (String) The default rights of an user - can be changed in the administration: possible values: '15','7','3','1' - 15 = manage dirs + edit files + upload + delete, 7 = edit files + upload + delete, 3 = upload + delete, 1 = upload only
  $self_registration_email='';         // (String) An e-mail is sent to this e-mail when an accout is created. an empty string does not send an e-mail.
  $self_registration_subject='A new user has registered.'; // (String) The subject of the registration e-mail
  $self_registration_text='%s has created a new accout.\nThe upload folder is: %s.\nIP: %s'; // (String) The body of the registration email %s are replaced with: user, upload folder, ip
/*
   Section: Overview + thumbnail page
*/
$show_number_of_pic = true;            // (true/false) show the number of images in a gallery in the overview.
$show_topx = true;                     // (true/false) Show the topx or hide it - make sure to have at least one of the topx options enabled!
	$show_topx_comments_details = true;  // (true/false) shows the latest comment next to the image - false - view like the other one !
  $topx_default='views';               // (String) 'views','comments','dl','votes','average';
$show_search=true;                     // (true/false) shows the search
  $preselect_caption_search=true;      // (true/false) Preselect the caption checkbox in the search window
  $preselect_comments_search=true;     // (true/false) Preselect the comments checkbox in the search window
  $preselect_filenames_search=true;    // (true/false) Preselect the file names checkbox in the search window
  $preselect_folders_search=true;      // (true/false) Preselect the folders checkbox in the search window
  $preselect_tags_search=true;         // (true/false) Preselect the tags checkbox in the search window
  $preselect_last_search=false;        // (true/false) Preselect the last upload checkbox in the search window - It should be false by default because the search does not combine good with the other ones
  $autojump_if_one_result=false;       // (true/false) If true the search jumps directly to he result if only one hit was found.
  $show_topx_search_details = true;    // (true/false) If you want a more detailed view for the search set this parameter to true - If you want more thumbnails and less text use false here! If you include TWG with php_include please use true here!
$show_public_admin_link=true;          // (true/false) enables disables the link to the admin area !
  $open_in_new_window=false;           // (true/false) you can define how the administration from the frontend is opened - true = new window, false = same window
$show_changes=-1;                      // (Number) you can highlight the galleries that are newer then x days. 0 does not show highlighting - e.g. 7 highlights galleries that  have a file date newer than 7 days. the highlight is shown recursive! if a file is changed in a dir normally der date of the dir is updated too! The style in style.css is 'highlight'. The icon is based on the date of the folder! If you copy new image to a folder and the time of the folder is not updated (this is system dependent) you can simply rename the folder twice to get a new date on this folder.
  $show_changes_type='image';          // (String) or 'highlight' - the type how to highligh new galleries
$show_tags = true;                     // (true/false) Show the top tags - the search for tags and the posiblility to enter tags at the detail page when logged in.
  $number_of_top_tags = 40;            // (Number) Number of maximum entries that are shown in the top tags iframe
  $number_of_top_tags_results = 20;    // (Number) Number of results that are shown in the search for a tag after selecting it in the top tags iframe
  $use_iptc_tags = true;               // (true/false) you can allow the reading of iptc data in general - if false the data from images are not read
  $iptc_fields_for_imagetags= array('2#025'); // (Array) IPTC offsets that are used for image tags - right now: keywords
  $iptc_fields_for_dirtags=array('2#020');  //  (Array) IPTC offsets that are used for album tags - right now: sub-categories
  $add_iptc_at_upload=true;            // (true/false) Extract the IPTC data (tags and caption) and stores it in the xml file during upload with the TWG upload flash - for html bakckup it is not implemented - you have to use the 'Exctact IPTC data' function in TWG Admin then.
$show_subdirs_first=true;              // (true/false) - if you have folders and pictures in one folder - this is the switch where you can decide which to show first! if you show folders first less thumbnails are shown! If pictures are shown first this is not the case because the row detection does not work the other way around.
$autocreate_folder_image = false;      // (true/false) You can automatically generate a topx folder.png. Once a day the topx views is checked and the most viewed image is used. if a folder.png exists no folder_top.png is generated. If a folder has no images the default folder image is used. See autocreate_folder_image_recursive for more picking the image recursive.
  $autocreate_folder_image_recursive = false; // (true/false) if true the most viewed image of the whole sutree is used - if false only the one of the actual folder. This need quite some time. If you want to speed up the gallery set this to false (but it's cached and only done once a day!). If no image is found the first one from the first sub folder is used.
$subfolders_only_once = true;         // (true/false) if you set this to true then directories that have folders and images AND the images have several pages then only on the 1st image page are the folders shown. The disadvantage is that TWG shows a full set of thumbnails that leads to a scroll bar. Right now this solution is not optimal but otherwise the whole section of the pager has to be completely rewritten. Feel free to do so and I'll be happy to merge this into the next build.
$paging_num  = 5;                      // (Number) The paging line is now optimized. Not all pages are displayed anymore if the number of pages are > paging_steps - the number you specify here are then number of pages that are shown before and after the current page (the page itself is included - 5 means 4 pages before, 4 after)
  $paging_steps = 10;                  // (Number) This are the steps that are used of you have many pages - there it one limit. If the number of pages is < 25 then paging_steps/2 is used! With more than 25 pages the steps are paging_steps. e.g. if you have 21 pages and you are on page one: 1 2 3 4 5 10 15 20 21 (the last page is always shown). Ifyou have e.g. 45 pages: 1 2 3 4 5 10 20 30 40 45
  $paging_use_style = true;            // (true/false) Does not use the twg_pag style if false. If false you should use a spacer_char.
  $spacer_char = '';                   // (String) The char displayed in the paging line - before 1.7 this was ' | '
$multi_root_mode=false;                // (true/false) This mode is especially for admins that want to have different independant albums in one gallery . It is like having a root.txt in every subfolder for the first level. - read howto 52 for details.
$multi_root_mode_login='';             // (String) With this parameter you can restrict the access in root mode - read howto 52 for details.
$multi_root_mode_permissions = '';     // ('','edit','upload') With this setting you can automatically login the user which is defined is the session parameter s_user - read howto 52 for details.

/*
   Section: Detail page
*/
$show_only_small_navigation = 'FALSE'; // ('TRUE','FALSE') 'TRUE' shows only the small navigation
  $big_nav_pos = 'bottom';             // (String) valid entries are 'top' and 'bottom' - Displayed the thumb strip above or below the main image
  $disable_nav_sel=false;              // (true/false) You can disable the option that someone can enable/disable the big navigation
	$default_big_navigation='DHTML';     // (String) There are 4 types of big Navigation - normal (value 'HTML'), dhtml (value 'DHTML'), flash (value 'FLASH') and htmlside ('HTML_SIDE')- the new HTML_SIDE version shows the thmbnails right and left next to the image! $numberofpics is the TOTAL number of images shown - 5 = 2 left, 2 right images -  The dhtml version does a lot of preloading - please do not use this if you have a lot of images in a directories or your expected users don't have fast connections 'HTML' = normal; 'DHTML' = dhtml version (much cooler :)). The flash  version is only "text free" in the registered version!
    $autodetect_noscoll=true;          // (true/false) if you have less then $numberofpics images you don't need to scroll at all - if you set this to true the thumbs below are static no mater which one you select (the actual thumb in not below the image anymore!)
    $use_nonscrolling_dhtml=false;     // (true/false) if you set this to true the dhtml thumbsbar is not scrolling anymore - it is simply moving when you click on an thumbs - it looks like the html solution but is much faster - The reason I implemented this is because if you use  $use_dynamic_background=true the scroller does work pretty bad - therefore if you set $use_dynamic_background to true automatically the option is set to true!
    /* additional parameters for default_big_navigation can be found in config_internal.php - section default_big_navigation */
  $numberofpics=5;                     // (Number) Number of pictures that are displayed in the thumbnail strip off the image page - only 3,5,7 and 9 are tested - more does not make sense I would say :) !! The number has to be uneven!
  $numberofpics_html_side = 9;         // (Number) If you switch to the html side mode another number of preview images sometimes make sense - 9 means 4 on each side
    /* additional parameters for the html side mode can be found in config_internal.php - section html_side */
  $show_slideshow=true;						     // (true/false) Enables / disables the slideshow functionality of TWG
  $show_optimized_slideshow=true;      // (true/false) Shows/hides the optimized slideshow option in the options menu - if true: $twg_slide_type should not be 'TRUE'!
  $show_maximized_slideshow=true;      // (true/false) Shows/hides the maximized slidshow option in the options menu - if true: $twg_slide_type should not be 'FULL'!
  $twg_slide_type = 'TRUE';            // (String) define the default slideshow type - 'TRUE' is the cross fade version, 'FALSE' the normal version, 'FULL' the maximized version!
  $twg_slideshow_time = '5';           // (String) Defines the default slideshowtime
$show_comments = true;                 // (true/false) enable comments and shows them below the pictures !!  - if you set this to false make sure that the $topx_default does not point to comments
  $show_comments_menue = true;         // (true/false) you can disable the entry in the menu - but still enter it at the bottom - see $show_enter_comment_at_bottom
  $show_enter_comment_at_bottom=false; // (true/false) shows the comment link additionally below the picture! - if you set this to true you should maybe $show_comments_in_layer set to false !
  $show_number_of_comments=true;       // (true/false) Show the number of entered comments next to the comment text
  $add_new_comments_on_top=true;       // (true/false) true shows the newest comments on top - false the newest on bottom!
  $enable_comments_only_registered = false; // (true/false)  You can enable the comments only for registered users. If you enable this the username is automatically set as username. You can integrate this into you existing framework (e.g. Joomla) by setting the s_user in the session!
  $show_comments_ip = false;           // (true/false) Everyone can add comments very easy - to avoid anonymous comments you can add the ip for a comment after the user name.
  $show_comments_in_layer=false;       // (true/false) Show the comments in a big layer instead below image - makes a nicer layout!
  	$height_of_comment_layer=250;      // new 1.3 - The additional height of the layer where the comments are shown.
$show_captions = true;                 // (true/false) you can hide the menu element to enter a caption
  $autodetect_filenames_as_captions=true; // (true/false) if true the filename is taken as caption if the filename contains less then $autodetect_filenames_as_captions_number numbers (e.g. Hello. jpg is o.k,  CIM12345.jpg is not). if false - filenames are not used;
    $remove_x_chars_from_filename=0;   // (Number)  If you use filenames as captions and want to use a prefix for sorting you can set the number of chars that are not displayed from the filename (e.g. if you set it to 3 '12_name' is displaded as 'name')
    $autodetect_filenames_as_captions_number=99;  // (Number) If you set $autodetect_filenames_as_captions = true you can set the number of numbers that are allowed  in a filename that it is used as caption. e.g. setting this to 3 means 3 numbers are allowed in a  filename to be used as a default caption - if a filename has 4 numbers it is not used as default. By default the number is now really high (99 is like: use it always) so that you have to reduce this number to not use camera names like CIM12345.jpg.
  $show_caption_on_thumbs = false;     // (true/false) you can show the caption under the filename - I don't recomend setting this to true - I hink it look ugly - you have this info as tooltip already! and the layout gets crashed very easy - automatic thumbs detectiondoes not work properly anymore if you set this to true!
  $iptc_fields_for_caption= array('2#120', '2#105','2#005'); //  (Array) IPTC offsets that are used for the caption when captions are extracted in TWG Admin or after the upload - it looks in the 1st field first - if nothing is found in the next ...
    $iptc_fields_for_caption_add = array(); //  (Array) IPTC offsets that are used to be ADDED to the caption when captions are extracted in TWG Admin or after the upload - this field is ADDED to the normal caption! e.g. you can add the city tags to the image
      $iptc_fields_for_caption_add_style=' (%s)'; // (String) This is the style how the 2nd IPTC field is added - the %s is the text that is found. You can e.g. use ' - %s' to add the 2nd field with a simple -
  $exif_field_for_caption= '';           // (String) Exif field that are used for the caption when captions are extracted in TWG Admin or after the upload. Only used if no IPTC data is found! By default this is empty because it is really slow. e.g. Image Description is often stored at 'imageDesc' - Please read howto 38 for more details.
$show_optionen = true;                 // (true/false) enables/disables the options button in the right upper corner on the details page
$enable_maximized_view=true;           // (true/false) = fullscreen modus - This modus is intended for people who want to show their images like in a slideshow but with manual navigation. The images are not cached in this modus because they can get very big! If php_include is true this modus is disabled because the detection dows not work properly!
  $default_is_fullscreen=false;        // (true/false) default is started in full screen - Should be false as default and only be set to true with the options
  $show_warning_message_at_maximized_view=false; // (true/false) enable/disable a JavaScript warning that tells the user that switching to the maximized view is quite slow ;).
	$show_caption_at_maximized_view=true; // (true/false) show the caption in full screen modus at the bottom
$show_count_views = true;              // (true/false) shows the views counter in the right corner in the details view - this is quite slow because it has to read and write the counterxml file every time. (This is still not multithreading safe - but good enough for the gallery!)
$enable_download = true;               // (true/false) enable download of original files
  $enable_download_counter=true;       // (true/false) Enables the counting of download of an image - $enable_direct_download has to be set to false
  $enable_direct_download=false;       // (true/false) does only work with $enable_download=true - you can select if the original images are linked directly or if a call  goes to a php page which returns the image. true:  shows the image in the browser and it's easy for someone to go to your image directory and browse even into protected folders - please don't use this if you have protected galleries false: shows a download window where you can save the image. This is much saver but people with slow connections have  sometimes problems downloading properly (reported by some users - therefore I added the direct download)  - please test on your system if the recommended 'false' setting work! Attention: if your filename does contains characters like äöü ... you get a 'you don't have permissions' warning on my windows system please don't use this characters if you using direct download - thanks
  $open_as_popup=true;                 // (true/false) true: opens the new window as popup - false: opens the new window as new browser 	- works for direct download as well - but be careful with the files and foldernames here - There is a php and Javascript mix - Don't usw special characters like äöü for album and folder names!
    $click_on_popup_dl_image = true;   // (true/false) you can enable that you download the image if you click on it in the popup - if false you close the popup
    $open_download_in_browser = false; // (true/false) Opens the original file as download or in the browser: true: in the browser; false as download - you have to set $ open_as_popup and open_download_in_new_window to false!
      $open_in_maximized_view=false;   // (true/false) opens the image in the maximized view as it can be done in the menu - $open_download_in_new_window and open_as_popup are ignored!
      $open_download_in_new_window=true; // (true/false) should be true if open in browser is true because the dhtml jumps back to the initial image and not to he last! is you use the lightbox this swtich is ignored
  $enable_download_as_zip=true;	    // (true/false) you can enable that whole dirs can be downloaded if a zip is provided - see the how-to
$show_rotation_buttons=true;           // (true/false) show the rotation buttons  ; true - shows them; false - hides them - if the rotation function cannot be detected by function_exists the rotation buttons are not shown at all!
$show_big_left_right_buttons=true;     // (true/false) shows the left - right buttons in the HTML navigation (they are only shown at the DHTML navigation if you use a background image and the static dhtml version is used!!)
$show_first_last_buttons=true;         // (true/false) shows the first and last buttons on the details page in the upper navigation
$enable_dir_description_on_image=false; // (true/false) shows/hides a directory description on the image page if existing. you can use the image.txt as well - see the how-to's!
$show_image_rating=true;               // (true/false) Enables the rating of images
  $show_rating_security_image=false;   // (true/false) enables an additional page where you have to enter a 4 digit security number that is shown on an image - used to prevent robots to vote!
  $image_rating_position='below_navigation'; // (String) Position of voting. Valid entries:  menu, over_image, below_navigation
  $enable_rating_only_registered = false; // (true/false) You can enable the rating only for registered users. You can integrate this into you existing framework (e.g. Joomla) by setting the s_user in the session!
$show_enhanced_file_infos=true;        // (true/false) Shows the 'Info' of an image in the menu
  $show_download_counter=true;         // (true/false) Shows the download counter in the info box.
  $show_exif_info=true;                // (true/false) Shows the 'Exif Info' of an image in the iframe
  $show_iptc_data=true;                // (true/false) Shows the available iptc data in the info panel - the tags that are displayed are defined in the language file ($ lang_iptc_info)! only existing ones are shown!
$image_txt_position='side';            // (String) top,bottom,side,image - if you use side you have to provide an image.txt AND an image2.txt - image.txt is used for the left, image2.txt for the right side nex to the image! - image.txt does a include of the whole text that is in the file - you can even use php in there! At all other .txt files only the first line is read! You should use a div with a fixed width for he sides! IE does someimes bad rendering if his is not the case! the difference between image and bottom is that with the image setting is is over the caption. bottom means tha it is below the caption.
  $image_file_extension = 'txt';       // (String) image.txt can be renamed to image.php - this can be useful because you can include php code in this file then and you can implement some logic to display some individual information for each file (in HTML and HTML_SIDE mode only - DHTML mode does not reload the page) - you can get the image name with the variable $image
    $image_file_is_multi = false;      // (true/false) if you set this to false the whole text in the image.txt or image.php is treated as one text block that is processed/included. If you set this to true then each line is parsed like a properties files and you can define one line for each image that is displayed! (like the caption but this is more powerfull because you can use full html code) - see howto 28 - the part of 1.6!
  $dynamic_image_txt=true;             // (true/false) image.txt, image.php and global_image.htm are executed by ajax if you set this to true. If you e.g. have music or something static per album you should set this to false
$center_cmotiongal_over_image=true;    // (true/false) enables/disables to center the cmotion gallery when you move the mouse over the big image
$show_wii_buttons=true;                // (true/false) You can show big control buttons for the wii - but you don't have to because the left right on the wii controll is supported too ;). try it ;). If you use small_pic_size = 400 then the image fit nicely on a tv!
$hide_topnavigation=false;             // (true/false) Show/hide the small navigation on the detail page.
$iframe_slideshow_fix=0;               // (Number) The iframes for the slideshow are calculated to fit most of the image ratios. If you have images where this preset is to small/big you can adjust this by setting this value.
$show_print_icon=false;                // (true/false) Show/hide the print icon. You can print the image that is currently shown without the whole gallery stuff.

/*
    Section: Video
    Here you can set the default settings for the embedded video support of TWG!
    Please read the howto 34 how to setup video support and use different settings for
    different folders!
*/
$show_videos=true;                     // (true/false) This setting is modified in the low settings mode - by default videos are disabled if low bandwith is detected
$video_autodetect = true;              // (true/false) This setting can be used for local video folders! If you don't provide a video.php and but set this to true TWG tries to find all local supported video files and plays them with the $video_php_x, $video_php_y;
$video_size_x=400;                     // (Number) The is the default width of the embedded video.
$video_size_y=320;                     // (Number) This is the default height of the embedded video.
$video_player='AUTO';                  // (String) 'AUTO' trieds to detect the video because of the extension of the first movie - only works for LOCAL videos! If you know your videos use: 'WMP' = windows media player, 'DIVX' = Divxplayer plugin for streaming divx, 'FLASH' = youtube flash player, 'GOOGLE' for video.google.com , 'MP3' for a flash mp3 player read the howto for video support!!!
  $video_autostart=true;               // (true/false) Enables the autostart of the videos
  $video_show_dl_link=false;           // (true/false) Show the download link below the video - should only be anabled if you have local videos - if you use FLASH or GOOGLE this has to be disabled
  $video_flash_site=''; // (String) The prefix of flash sites - tested is 'http://www.youtube.com/v/' and 'http://www.dailymotion.com/swf/' maybe other video sites work too - please tell me if you find another site that works! For Mp3 this has to be set to '' - For mp3 you can use an external url too. It will be added in front of the mp3 file name.
  $video_autostart_parameter='&autoplay=1'; // (String) This is the extension you have to add after the link to enable autoplay - his is different for youtube and dailymotion - please read the howto 34 for more details
  $linktowvx=false;                    // (true/false) You can link directly to the wmp media files if wmp is uses - true creates a playlist wvx file - false links directly!
  $loop_mp3=false;                     // (true/false) you can loop mp3s if you like
$mixed_video_image_content=false;      // (true/false) You can have one type of video and images in one folder! This only works in the HTML and HTML_SIDE mode - If you set this to true then DHTML mode is switched to HTML mode! Therefore I recommend to set this to true this ONLY in the video.php! if you set this to true you have too add v___ (3x _) at the front of the filename of the video - this prefix is removed when a caption is displayed! e.g. 123345.jpg -> v___123345.jpg - a sorting prefix goed BEFORE this 123345.jpg -> 123___v___123345.jpg
$use_ffmpeg=false;                     // (true/false) If you have ffmpeg installed you can extract thumbnails, convert videos ... Check info.php if it is availalble on your server and the howto about ffmpeg!
  $ffmpeg_extensions=array('flv','avi','divx','mpg','mpeg','wmv','mov','mp4','MOV'); // New 1.7 - This are the file externsions where ffmpeg is used to generate thumbnails and convert videos!
  $ffmpeg_time=1;                      // (Number)  When extracting a thumbnail from a video this is the time in seconds where the shnapshot is taken!
  $ffmpeg_path='ffmpeg';               // (Number)  The path to ffmpeg. If it's in the path you don't hve to change anything.
  $ffmpeg_generate_thumbs_at_upload=true; // (true/false) Automatically generate thumbnails when you upload a movie.
  $ffmpeg_convert_videos_at_upload=true;  // (true/false) Automatically generate a flv video when a movie is uploaded. Please note that the conversion can take quite some time. I only tested videos up to 70 MB! - This took ~ 45 sec. to generate a 20 MB flv movie.
   $ffmpeg_output_format = 'flv';         // ('mp4'/'flv') - TODO
   $ffmpeg_convert_command='-y -i "%s" -f flv -ar 22050 -ab 128k -qscale 4 "%s"';   // (String) This is the conversion command for ffmpeg for flv. Please read the ffmpeg documentation for details! On unix server you have to use ' instead of " for the file names. The given command gives good quality and big filesizes. if you increase the qscale parameter the quality gets less but the filesize much smaller! you can also use -sameq if is is supported! It should keep the quality of the original.
   $ffmpeg_convert_command_mp4='-i "%s" -vcodec libx264 -acodec aac -strict -2 "%s"';   // (String) This is the conversion command for ffmpeg for mp4. Please read the ffmpeg documentation for details! On unix server you have to use ' instead of " for the file names. The given command gives good quality and big filesizes. if you increase the qscale parameter the quality gets less but the filesize much smaller! you can also use -sameq if is is supported! It should keep the quality of the original.
     $ffmpeg_delete_src_after_convert=true;// (true/false) After the conversion the uploaded file is deleted if true. If false the original still exists but is not used because flv is the first one that is checked.
$autogenerate_video_php_at_upload=true;// (true/false) video.php can be generated automatically during upload if it does not exist. Check the following parameters for details!
  $video_php_autodetect_type=true;     // (true/false) when video.php is generated automatically TWG can either detect the type automatically during runtime or the 1st uploaded movie determines the type you should set this to false if you know the video type in advance for optimal size of the player and if only one type of movies are used. Set it to true if you have different types of videos in one folder. autodetection additionally allows to have videos and images in one folder!
  $video_php_autodetect_size=true;     // (true/false) When you upload a movie and the thumbnail is generated automatically the size of this image can be used as size for all movies. If false the video_php_x_default and video_php_y_default settings are used.
    $video_php_x_default=400;          // (Number) This is the default width of the movie - the player is added automatically
    $video_php_y_default=320;          // (Number) This is the default height of the movie - the player is added automatically
/*
   Section: Registered users
  This is a small section that is the bonus for registered users!
  You can configure the lightbox feature and the album exporerer you can see in demo 1.
  By default the lighbox is then activated on the thumbs but not on the main page!
*/
$activate_lightbox_thumb=true;         // (true/false) activates this feature on the thumbnail page.
  $activate_lightbox_thumb_full=false; // (true/false) if true the whole thumbnail activates the lighbox script. It's then not possible to get on the image page anymore. If false, there is a small zoom icon in the left upper corner of each thumbnail. If you click on this the lighbox image is shown.
  $use_original_on_thumbspage=false;   // (true/false) normally the detail image is used on the thumbpage for the lightbox - but you can use the original too if you like! Just set the parameter to true!
$activate_lightbox_topx=true;          // (true/false) activates this feature on the TopX page.
  $activate_lightbox_topx_full=false;  // (true/false) if true the whole thumbnail activates the lighbox script. It's then not possible to get on the detail page anymore. If false, there is a small zoom icon in the left upper corner of each thumbnail. If you click on this the lighbox image is shown.
  $use_original_on_topxpage=false;     // (true/false) normally the detail image is used on the topx for the lightbox - but you can use the original too if you like! Just set the parameter to true!
$activate_lightbox_image=false;        // (true/false) if true clicking on the detail images does not open the image in a new window or a popup but in the lightbox. Download has to be activated to use this feature + you cannot download the lighbox image with 'right click -> save image'.
$enable_album_tree = true;             // (true/false) You can display an explorer like album tree on the left side - this is a bonus feature for registered users :).
  $album_tree_default_open = false;    // (true/false) Shows/hides the tree when you open the gallery.
  $autoclose_tree = true;              // (true/false) You can make the tree autoclose by default if you click on it. Otherwise it stays open until you close it - you can change this behavior by the small marker in the right upper corner of the tree. Opera has a display bug here - therefore this is disabled - you have to close the tree manually!
  $album_tree_width = 250;             // (Number) The width of the album tree.
  $show_counter_in_jstree=true;        // (true/false) Shows the number of pictures in a folder in the js album tree (only available for reg. users because the album tree is only available there) . like $show_number_of_pic in the normal view. Does only work if the cache is on because otherwise the whole counting would be done twice.
$show_navigation_buttons_on_bottom=false; // (true/false) You can show the navigation Buttons at the bottom too - It is shown next to the TWG logo - I you are registered only the navigation is shown.
$flash_size = "100";                   // (String) This is the size of the flash. Right now only 100 (image 100x100) is supported! I will include different versions of this flash later on. I have planned to have a 80x80 version as well. Because many parameters need to be tuned it is not possible to have a dynamic version!
$flash_nav_reflection='on';            // (String) You can turn the reflection of the thumbnailflash on/off. valid entries: 'on', 'off'
$flash_nav_reflection_bg_color='FFFFFF'; // (String) This is the background color of the reflection. Set this to your background color if you turn reflection on
$flash_hide_scrollbar='false';         // (String) You can hide the scrollbar by setting this parameter to 'true'. Valid settings are 'true','false'. You should enable autoscrolling if you hide the scrollbar!
$flash_enable_autoscroll='false';      // (String) You can enable autoscrolling when you move the mouse to the left and to the right. Valid settings are 'true','false'.
$flash_border_color='';                // (String) You can add a 1 px border around the images in the flash. You have to specify the color in the format FFFFFF. Empty means no boarder! The boarder does not look 100% because it's rendered be the flash and this looses some quality.
/*
		Section: Watermark
        This section is responsible for the watermark stuff
*/
$print_text=false;                    // (true/false) you can print some text on the lower left corner to protect your images  or at least make it a little bit harder to copy it without doing anything :) if you change this setting please delete the cache folder - otherwise generated images are not changed.
$print_text_original=false;           // (true/false) does print the text on the original as well - $enable_direct_download has to be set to false!!!
	$font = dirname(__FILE__) . '/verdana.ttf'; // (String) This are the settings for the image text
	$fontsize=10;
	$fontsize_original=12;
	$text = 'powered by TinyWebGallery'; // The watermark text.
	$textcolor_R = 255;                 // be careful with changing the colors ! if the compression is low the text becomes unreadable
	$textcolor_G = 255;                 // pretty fast if it is a crazy color :)
	$textcolor_B = 255;
$print_watermark = true;              // (true/false) you can make a watermark on the images to protect your images or at least make it a little bit harder to copy it without doing anything :) if you change this setting please delete the cache folder - otherwise generated images are not changed. Please read the description of the parameters that belong to the watermark to get best results!
$print_watermark_original=false;      // (true/false) does print the watermark on the original as well - $enable_direct_download has to be set to false!!!
	$watermark_small =  'buttons/watermark_small.png'; // (String) this is the watermark that is used on the detail and slideshow images - can be jpg or png - png gives better results
	$watermark_big =    'buttons/watermark.png'; // (String) this is the watermark that is used on the download images - can be jpg or png - png gives better results. you can use a larger image here because the original images are most of the times much bigger
	$position= 7;                       // (Number) You can define the location of the watermark with this setting (top:  1  2  3, middle: 4  5  6, bottom: 7  8  9
	$transparency= 70;                   // (Number) You can also set the transparency of your logo. 0 is no transparency - 100 max; Try your logo with different settings to get best results. For 24 bit pngs with alphachannel please use 0 because then the alpha transparency is used!
	$t_x= 0;                            // (Number) The next two settings define the position of a transparent color in your watermark.
	$t_y= 0;                            // (Number) If your logo has e.g. a white border you can set the values to 0:0 and the border will be transparent. If you don't want a transparent color: set these values to -1!
/*
		Section: Skin Settings
		This are the settings to activate a skin - this are the default settings for the gallery.
		A skin does most of the time overwrite the next settings! A skin can also set non visual
		settings to - but it is not recommended to do this! Read the Skins how-to if you want to
		share your gallery layout with others.
*/
$skin='';                              // (String) As default no skin is used - in the download  are 'black','green','transparent','winter' and 'newyork'  . All other style settings are still valid (check how-to 9). Some of the skin have a background! Check the Skins how-to to create your own skin or look in the forum of TWG - there is a skins section. if you change the skin you have to delete the *.slide.jpg images in the cache folder!
$background_default_image='';          // (String) Normally you put the background in the stylesheet! but if you want to use a dynamic background the image has to be here - skins overwrite this setting if they have a background image - make sure if you use php include that the path include the install_dir!
$use_dynamic_background=true;          // (true/false) If you want a dynamic background that resizes with the browser size you have to set this to true and set a $background_default_image - skins overwrite this setting if they have a background image - this does slow down the motion gallery in FF and a litle bit in ie - for opera it is disabled because it is too slow! - please don't use this if you don't like that! IMPORTANT: if you use  $use_dynamic_background=true then the scrolling fhtml thumbstrip is not moving anymore but can be moved by clicking on the strip - it's then like the html solution!
  $use_resized_background = true;      // (true/false) There are two ways to use dynamic background - by resizing on the client in an extra div (false) or by resizing the background on the server (true). Resizing on the client is the old mode used before 1.5 where the image was exaclty resized to the browser but the problem was that the motions gallery was not working very good anymore and therefore I implemented the no scrolling cmotion option. Since 1.6 it is possible to get a resized background from the server where no restrictions to the cmotion gallery does exist - it only used a little bit more space in the cache ;). true should be default because this mode is optimized for speed and server load
    $resized_background_tolerance=100; // (true/false) the new use_resized_background mode is not generating backgrounds for every resolution. It is generating it in step of this setting. If e.g. your browser needs an image with 950 width then the next bigger avalable image is used (for resized_background_tolerance = 100 this would be 1000). The smaller the number is the better does the backround fit but the more space you need ;).
  $resize_only_if_too_small=false;     // (true/false) If you set this to true the image is not made smaller than the original its only made bigger - if false it is resized all the time!
$slideshow_backcolor_R = 255;          // (Number) For the slideshow are images created which are $small_pic_size x $small_pic_size
$slideshow_backcolor_G = 255;          // (Number) Therefore we need a background color that has to match the color in the style sheet (see the comment there)
$slideshow_backcolor_B = 255;          // (Number) Default is white - the values are the RGB values in decimals!
$comment_corner_size=5;                // (Number) When an image has a comment the right upper corner is make white by default. This value determines the size of this corner
	$comment_corner_backcolor_R = 255;   // (Number) This are the colors of the comment corner (RGB value in decimal)
	$comment_corner_backcolor_G = 255;
	$comment_corner_backcolor_B = 255;
$enable_drop_shadow=true;              // (true/false) You can enable/disable the default border of the image - there is a drop shadow defined in style.css -> div.twg_img-shadow - This looks very good if you have white backgrounds if not - don't use it ;)
$use_round_corners = false;            // (true/false) New 1.7.5 - You can use round borders for the gallery. Please read the howto how to use this because you have to set some style manually if you don't use the default skin! In the admin skin the needed css styles are set at the very end! This value is set to false if you set $show_border =='FALSE'!
$use_round_corners_size = 12;          // (Number) New 1.7.5 - The radius of the corners. 1-32 are fine. If you use corners > 32 the calculation take quite long and does not look good anymore...
$use_round_corners_border = 1;         // (Number) New 1.7.5 - The size of the border 1 or 2 are good values
$icon_set="default";                   // (String) New 1.7.5.1 - You can choose different icons sets. Some skins have their own icon set. You have to change this in the skin then!
$icon_set_mobile='mobile';             // (String) You can set a different icon set for mobile mode. Right now bigger icons are used.

/*
		Section: E-mail
        In this section you can customize/setup the email features of TWG
*/
$enable_email_sending=true;          // (true/false) You can enable/disable the sending of emails - The user can still register but no notification emails are sent. The admin side can still be used but no email are sent - set this to false if you are testing twg and you don't want to send any emails!
$show_email_notification = false;     // (true/false) enable/disables the end-user and the admin part if logged in :). The emails are stored in the counter/subscribers.xml (plain text file!)
  $encrypt_emails=false;              // (true/false) enable/disable encryption of emails! - if you change this your subscriber.xml file will become invalid! - you are not able to fix this file manually if you turn the encryption to true. if you set this to false make sure that the file can not be read from outside - set the xml directory to 770!
  $encrypt_emails_key='This is the encryption key used for emails in TWG - to make your emails really save please change this string with your random string like 2342dlkASdasDkw33jl2k4jl... - the longer the better.'; // new in 1.2 - this key is used to encrypt and decrypt the emails in the subscriber.xml - the longer the saver! - (please use 1-9, a-z or A-Z to make the algorithm work properly! - no e.g. +„+–+œ are allowed!) - internal the key is permuttated 2 times and added to this string to add additional security ;). If you change this string all existing emails cannot be used anymore!
  $youremail = 'test@test.com';       // (String) this email, will be the reply-to mail for the registration !!
  $default_subject = 'Gallery update!'; // (String) This is the default subject for the emails which can be send to the registered users.
  $default_text = "Hello,\nThere are new images available at the web gallery you registered.\nPlease go to %s"; // (String) The default email body. %s is a iternal variable to the main page of the gallery - If you want a different link please change it. If you use php_include you have to enter the right address here !!
  $email_bottomtext = 'sent by TinyWebGallery. If you want to change or delete your registration please go to %s'; // (String) Every email gets this footer. It makes it easier for your users to get back to your gallery. %s is an internal variable to the main page of the gallery - If you want a different link please change it. If you use php_include you have to enter the right address here !!
$admin_email = 'nick_south@hotmail.com';         // (String) Email address where the notifications are sent to. $enable_email_sending has to set to true to make this work!
  $send_notification_if_comment=true; // (true/false) if true a notification is sent every time a user enters a comment
    $notification_comment_subject="A new comment was entered at " . $browser_title_prefix; // (String) Subject of the comment notification email
    $notification_comment_text="A new comment was added for image\n%s"; // (String) Text for the comment notification email. %s is the link to the image the comment was entered.
  $send_notification_if_rating=true;  // (true/false) if true a notification is sent every time a user enters a rating
    $notification_rating_subject="A new rating was entered at " . $browser_title_prefix; // (String) Subject of the rating notification email
    $notification_rating_text="A new rating was added for image\n%s"; // (String) Text for the rating notification email. %s is the link to the image the rating was entered.
/*
 		Section: Bandwidth
        Here are set settings for the bandwidth and the settings!
*/
$test_client_connection = true;        // (true/false) you can enable/disable the connection test of TWG. $low_ ...  this settings are used if the parameter &lowbandwidth=true was provided once  &highbandwith=true uses the original settings. These settings are for users that have maybe only ISDN or a 56k modem. If you want to provide the same settings for all set this to false - then the bandwidth icon is not shown either!
$test_connection_background=true;      // (true/false) normally the speedtest is done before the 1st page is loaded to optimize it - but is does not look nice but all low settings are done properly - if you use the inline test the view of your gallery can change when the user clicks something because e.g. show_colage has a different value in low bandwidth mode ! - it's up too you ;).
  $show_bandwidth_icon=true;           // (true/false) you can hide the bandwidth icon if you like- true: shows it - false hides it (test is still done!)
	/* additional parameters for bandwidth can be found in config_internal.php - section bandwidth */
/*
    Section: Tips
    You can show the user some tips or help or additional info if you like at the bottom -
    Just enter them in the language file $lang_tips_overview, $lang_tips_thumb, $lang_tips_image as array
    The style is defined in style.css: .twg_user_help_td
*/
$disable_tips = false;                   // (true/false) enables to show a small tip on all pages
  $show_tips_overview=false;             // (true/false) enables to show a small tip on the overview page
    $show_tips_overview_once=true;       // (true/false) true: shows a tip only once per session
  $show_tips_thumb=true;                 // (true/false) enables to show a small tip on the thumbnail page
    $show_tips_thumb_once=true;          // (true/false) true: shows a tip only once per session
  $show_tips_image=true;                 // (true/false) enables to show a small tip on the image page
    $show_tips_image_once=true;          // (true/false) true: shows a tip only once per session
/*
    Section: TWG admin
    Some default settings for the TWG Admin!
*/
$admin_default_upload_method = 'flash'; // (String) You can set the default upload method of the admin. valid values: 'flash' or 'html'. html disables the menu items 'upload images' and 'File Split Applet'
  $admin_nr_uploads = 10;               // (Number) Defines the number of lines in the html upload form
$admin_default_simple_view = 'yes';     // (String) The default view of the TWGXploerer. valid values: 'yes' or 'no'
$admin_enable_split=true;               // (true/false) Enable/disable the file split capabilities of TWG to get around a upload limit. Please read the howto 42 about the split test before enabling file splitting.
  $admin_file_split_is_tested=false;    // (true/false) Spliting and merging big files is not supported by all servers. Therefore this is disabled by default. Please read the howto 42 about the split test before enabling file splitting.
$admin_allowed_file_extensions='all';   // (String) The allowed file extensions for the upload flash! jpg,jpeg,gif,png are allowed by default. 'all' allowes all types - this list is the supported files in the browse dropdown!
$admin_user_allowed_file_extensions='jpg,jpeg,gif,png,txt,avi,flv,mpg,mpeg,divx,pdf,wmv,mov,mp3,mp4'; // new 1.6 - The allowed file extensions for the upload flash in the frontend! forbidden is the same as for the backend. If you don't like this add them to the not allowed list
$admin_forbidden_file_extensions='';    // (String) The list of forbidden file extensions! - only usefull if you use 'all' and you want to skip some exensions!
$admin_hide_help_button='true';         // (String) Since TFU 2.5 it is possible to turn off the ? (no extra flash like before is needed anymore!) - the switch is triggered by the license file! See website of TFU for details. You need at least the registration without the ? to hide the ? on the flash. This is maybe interesting for admins who enable upload with the front end and want eben the flash anonymous.
$admin_enable_cmd_checks=true;          // (true/false) Disables/enables the checks of image magic and ffmpeg. On some systems system calls cause a fatal error!
// for registered users
$admin_user_edit_textfile_extensions = 'txt,css,php,htm,html'; // (String) This are the files that can be edited in the flash in the backend. But you can restrict is to single files as well by using the full name. e.g. foldername.txt. * is supported as wildcard! Only available for registered users.
$user_edit_textfile_extensions =       'txt,htm,html'; // (String) This are the files that can be edited in the flash of the users. But you can restrict is to single files as well by using the full name. e.g. foldername.txt. * is supported as wildcard! Only available for registered users.
$save_only_delta = 'on';                // new 1.8.x - ('on'/'off') This is the preselection for the "save only delta" checkbox in the administration
/*
  Section: Caching settings
*/
$cache_dirs = false;                     // (true/false) content of directories are cached in the session - you can disable this if you have lots of image updates or are testing TWG while uploading.
  $autoenable_cache=3;                   // (Number) Too many installs don't use the session cache $cache_dirs. If do now automatically turn on the cache after x requests! If you don't like this set this switch to -1.
  $use_cache_with_dir = false;           // (true/false) You can enable that the cache folder does not have a flat structure but the directory structure of your images folder. You have to check if TWG can create the needed directories! If not you cannot use this!
  $remove_1_day_data=true;               // (true/false) If your files don't change very often you can disable that the 1 day cache is removed - it's only cleared then if you click on the bandwidth icon and if you upload an image with the flash uploader if you set this to true
  $serialize_dir_data=true;              // (true/false) This is a very high level of caching you can enable. The directory structure including the images are serialized to the cache folder. After enabling this the files are updated in the interval given at precache_main_top_x_interval. TWG autmatically detects if new images are in a folder and refreshes the cache! normally you don't have to turn this of since 1.7.1!!!
  $precache_background=false;            // (true/false) TWG preloads the counter xml of the albums of the first page to speedup the following background tasks (starts 5 sec after 1st page starts to load!) - if you want to speed up the first page on a slow connection: set this to false!
    $precache_main_top_x=true;           // (true/false) Caches the TopX in tmp files in the cache folder. The cache is eitehr build during the first call or when the background process is started
      $precache_main_top_x_limit=2000;   // (Number) If your whole gallery has less then the given limit the cache files are NOT used because normally they can be generated fast enough on the fly. Over this limit the _topx_ cache files are used if present or they are generated!
      $precache_main_top_x_interval=4;   // (Number)  This is the time interval in hours the topx caches are deleted and new numbers are fetched - if you set -1 then the cache is connected to the one day caching - max value therefore is 24 ; This time is used for the autogeneration of top x folder images cecause it is linked to the topx
      $precache_topx_additional_dirs=''; // (String) By default only the main topx is precached. If you want to cache subdirs too please add this dirs here as comma seperated list. e.g. for the 2 folders 'davos' and '2007/vacation' the enty has to be: 'davos,2007/vacation'
    $precache_xml_data=false;            // (true/false) Preloads xml files that browsing through the folders is faster.
  $cache_time=42;                        // (Number)  Number of days until big images (big and slideshow images) files hat are not touched will be deleted from the cache. If you don't want cache cleanup use -1 here. Some OS return at this test  the last time where the file was touched the time when it was last modified. The no cache cleanup is done. Thumbnails are never deleted!
    $cache_clean_thumbs=false;            // (true/false) By default only big images and slideshow images are cleaned up. When you set this to true thumbnails are also cleaned up.

/*
	 Section: Internal settings
    	Internal settings - there is normally no need to change something here - but you can :).
*/
$password_file='private.txt';          // (String) You can set the password file here. On a unix system you can use e.g. '.htprivate' to secure the private file! .txt is added here because I have a htaccess file that
$exclude_directories=array('data.pxp','_vti_cnf', '.svn','CVS','thumbs','.thumbs'); // (Array) You can enter directories here that are ignored in TWG
$exclude_images=array();               // (Array) You can add images that are ignored by TWG. You have to define an array like $exclude_directories. Only use lower case because the check converts the file names to lower case.
$show_powered_by_twg_as_text=true;     // (true/false) you can change the TWG logo to a text - if you want to remove it you have to register!
$show_twg_logo_if_registered=false;    // (true/false) You can register and still show the TWG image if you like to support TWG
$store_xml_in_picfolders=false;        // (true/false) You can now store your xml files in the pictures folder - please read the howto 35 to use this feature!
$autocreate_folder_id=true;           // (true/false) Since 1.7.7 you can use a folder.id file which is the prefix for all xml files - You can now create this file automatically with the current directory in it. This enables you to move folders without loosing any xml data like comments or tags.
$allowed_html_tags = array('<b>', '</b>', '<u>', '</u>', '<i>', '</i>', '<p>', '</p>'); // (Array) allowed html tags in comments and titles !
$thumbnail_offset_y=0;                 // (Number) If you have e.g. ad's on the thumbnail page or a header.htm and footer.htm twg does not know this - you have to tell how much space this takes!
$generate_cache_at_upload=true;        // (true/false) you can generate the thumbs during upload - upload is slower but the cache already generated.
$use_shell_exec=true;                  // (true/false) You can decide if you use exec or shell exec to execute external commands. You have to check what your server needs - this switch does not affect windows servers - there a different solution is used.
$use_cache_hash=false;                 // (true/false) you can store the images in the cache md5 encoded - it's slower but you get shorter cache names, the cache is not readable anymore and you don't have non ansi chars in the file name anymore. This can be important for people with deep directory structures and long file names. If you have problems that images with special characters cannot be shown set this to true - I have removed $double_encode_urls in 1.7 because this is the more secure way if you have problems with encodings in the cache!
$enable_external_adremove = true;      // (true/false) TWG can remove ad's from websites like funpic.de. But the code of the layer ad change very often. If you have this switch on then a small js file is loaded from tinywebgallery.com that always contains the newest ad removal code. If you don't have any ad's on your webspace you can set this to false;
$move_error_images='';                 // (String) You can automatically move images that throw an error to the folder your provide here! Makes it easy to find corrupt images people upload. The problem can be too big images, or corrupt images. An empty folder disables this function!
$enable_enhanced_debug=false;          // (true/false) Sometimes the error message does not help and some more information like the request parameters are needed - please turn this on if I need more infos.
$autodetect_errors = false;            // (true/false) TWG does set a flag at the beginning of the script and removes it at the end. If this is not cleaned up the gallery has looked up and the temp files are cleaned up. This is an optional thing because it slows down the gallery a little but because the whole session is saved and reloaded for that.

/* additional parameters for internal can be found in config_internal.php - section internal */
// Section:  1.8.x - This new settings will be merged above in the next major version!
// Using full textsearch is the fastest way to find what you are looking for.
$show_album_name_on_thumb_page=true;     // new 1.7.7 - You can show the album name on the thumbnail page
$show_album_name_on_detail_page=false;   // new 1.7.7 - You can show the album name on the detail page like on the thumbnail page
$direct_folderpng = true;                // new 1.7.7.2 - You can directly link to the folder.png. This is a little bit faster but you cannot have spacial characters in your album names like öäü

$hide_empty_directories=false;           // new 1.8 - Set this to true of you want to hide empty directories.
$filesystem_encoding = "";               // new 1.8 - (String) If you are on a filesystem where you have special characters which are not in ISO-8859-1 you can specify your encoding here. Then I don't use utf8_encode for the encoding but iconv.

$big_thumbnail_strip=false;              // new 1.8.2 - (true/false) There are 2 thumbnail strips available - 100 and 120 px. Choose the one you like - It is optimal to use the same size as the thumbnail images.
$twg_slide_fx_type = 'fade';             // new 1.8.2 - (String) name of transition effect for the opimized and maximized slideshow (or comma separated names, ex: 'fade,scrollUp') - use 'all' for all effects - See http://jquery.malsup.com/cycle/browser.html for the 28 possible effects!!
$image_page_fade = 0.8;                  // new 1.8.2 - (Number 0 - 1 e.g. 0, 0.5, 1) The value how much the images are faded between a switch. 1 = no fade, 0 = full fade (from 100% to 0% to 100%), e.g. 0.5 (from 100% to 50% to 100%) - make sure to use a . for e.g. 0.5 and NOT 0,5!
$overlays_for_other_file_formats = true; // new 1.8.3 - (true/false) Show/hide the overlay icons for other file formats like videos.
$rating_reload_time = 5;                 // new 1.8.3 - (Number) Number of days how long you have to wait until you can rate an image from the same ip/user name again.
$use_js_call_external_thumb_flash = false; // new 1.8.3.1 - (true/false) true - The external thumb flash calls the Javascript showImage(url to image). Implement it on your site and do whatever you like; false - TWG is called like before.

$enable_frontend_edit=true;              // new 1.8.5 - (true/false) true - enable edit of folder.txt and foldername.txt in the frontend for users with upload rights.
$fix_ie_fade=false;                      // new 1.8.5 - (true/false) IE does not handle black properly during fading. 99% of the time this does not matter because you don't see this. But if you have black images and you see white dots you can set this to true to replace black. If you still see white dots you have to set $image_page_fade=1; It is not set to true by default because color are changed and this should not be default!

$show_rotation_buttons_login_only=false; // new 1.8.6 - (true/false) If true the rotation buttons are only shown for users that can permanent rotate images (edit and above). If false everyone can rotate (unregistered not permanent!). $show_rotation_buttons has to be true that the buttons are shown at all. 
$enable_language_selector=true;          // new 1.8.6 - (true/false) The selector is only shown if more than one language file is in the language folder. If you want to disable the selector directly please set this parameter to false.
$show_last_next_album = false;           // new 1.8.7 - (true/false) enables 2 new arrows in the small navigation to go to the next/last album. 

$optimize_css = true;                    // new 1.8.8 - (true/false) true: combines all css loaded in the header in a temp file in the cache folder; This style sheet is cached for one day and can be removed in the administration with the session cache or by clicking on the bandwidth icon; false: loads each file individually.

$enter_caption_at_upload='false';        // new 1.8.9 - ('true','false') If you have a professional license the desription mode of the flash can be activated. The 'description' is then used as caption for an image. Please note that if you enable this and if you don't have a professional license you get a description column where the size is shown.
$use_smtp = false;                       // New 1.8.9 - (true,false) false: use build in php mail, true: use smtp. Please provide the settings below. 
  $smtp_host = "<smtp host>";              // New 1.8.9 - (String) The smtp host. If you want to use ssl please use e.g. ssl://smtp.strato.de. See http://php.net/manual/en/transports.inet.php for available transport protocols. 
  $smtp_port = 465;                      // New 1.8.9 - (Number) The smtp port. 456 is the default for ssl!
  $smtp_user = "<user>";                 // New 1.8.9 - (String) The smtp user name
  $smtp_password = "<password>";         // New 1.8.9 - (String) The smtp password


$enable_basic_seo=false;                 // New 2.0 - (true/false) This setting enables basic seo support for the thumbnail and the detail page. Please read the updated howto 44! before you enable this!
$use_old_seo_slash_encoding=false;       // New 2.0.3 - (true/false) The old encoding was encoding / which was using fine for browsing. But spiders (google) did not use the encoded value like the browser did which leads to 404 when your site was crawled. Please check the howto 44 about restrictions for the folder name! Now _ is not allowed at the end of folders anymore!!  
    $album_sub_url_seo_character="~";    // New 2.0.3 - (String) This is the album seperator when SEO is used and $use_old_seo_slash_encoding=false; you need to use a character you don't have in an album name. So if you want to use _ no _ is allowed in album names. As default ~ is used which normally is not used as folders.   
$allow_iframe_include='true';            // New 2.0 - 'true', 'false', 'same'. This settings adds a header to twg which controls if a browser does allow the include of TWG into an iframe. 'true' - TWG can be included fron any domain, 'same' - TWG can only be included from the same domain, 'false' - TWG cannot be included. 
$enable_mobile_detection = true;         // New 2.0.4 - (true/false) Enable/disable the whole mobile detection 

// The responsive mode is only available for registered users.
$responsive_align_center = true;         // New 2.2 - (true/false) Define if the images on the main and thumbnail page are centered or left aligned in responsive mode.
$responsive_main_page = false;           // New 2.2 - (true/false) Enables a responsive main page. The table structure does than float. The $menu_x and $menu_y settings do than only define the number of albums shown on each page.   
  $responsive_main_page_padding_x = 40;    // New 2.2 - (number) The x padding of each album. Choose a value where all your descriptions do fit and the distance of your alumbs have the distance you like 
  $responsive_main_page_padding_y = 50;    // New 2.2 - (number) The y padding of each album. Choose a value where all your descriptions do fit and the distance of your alumbs have the distance you like. The given values are good for 2 lines of album names. 
$responsive_thumb_page = false;          // New 2.2 - (true/false) Enables a responsive thumbnail page. The table structure does than float. The x and y settings do than only define the number of thumbnails on each page. When autodetection is enabled TWG still tries to find the optomal number of thumbnails which are all displayed on one page without scrolling.   
$responsive_detail_page = false;         // New 2.2 - (true/false) Enables a responsive detail page. If you enable this images and html5 videos do scale. Elements like the thumnail strip and the folder description are hidden if they do not fit anymore. Be aware that for mobile devices the fullsceen mode for the detail page is default.
$responsive_detail_page_full_slideshow = false; // New 2.2 - (true/false) If set to true the maximized slideshow is used which scales to the size of the browser.

$support_transparent_gif = false;        // new 2.2 - (true/false) If set to true transpartnt gifs are shown properly. If set to false the quality is much better. Use image magic if you like transparent images + good quality.

$twg_version='2.2';                    // (String) version for the administration and the display :)
/* new 1.7 we include the configuration file with internal or very advanced settings ! */
include dirname(__FILE__) . '/config_internal.php';
/* new 1.4 we include your configuration file ! */
if (file_exists(dirname(__FILE__) . '/my_config.php') && !isset($main_config_only)) {
    include dirname(__FILE__) . '/my_config.php';
}
if ($install_dir != '') {
  $php_include = true;
}
// Height of the iframes
// This settings where moved to inc/loadconfig.inc.php because custom config files could overwrite
// settings that where used below. Please go to the bottom of this file if you want to change the height
// of a iframe
?>