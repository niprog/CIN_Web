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
"privatepassword" => "To protect a gallery with a password you have to create a empty file with the name \'private\' in the directory you want to protect. If you want to protect a gallery with a different password you have to enter the password in the \'private\' file.",
"browser_title_prefix" =>  "This is the title which is shown in the browser title - you may change this to the name of your gallery",
"default_gallery_title" => "This is the default title shown on the main page if no real lang_titel is specified in the language file. If you want to have different titles for a language please adapt the language files!",
"skin" => " As default the admin skin is used - in the download  are \'black\', \'green\', \'transparent\', \'winter\' and \'newyork\'  . All other style settings are still valid (check how-to 9). Some of the skin have a background! Check the Skins how-to to create your own skin or look in the forum of TWG - there is a skins section. if you change the skin you have to delete the *.slide.jpg images in the cache folder!",
"use_round_corners" => "Use round css corners. This is supported by all current browsers! There are additional settings in the config.php.",
"iframe_include" => "PLEASE READ HOWTO 2 before you change this! When you include your galerie in an iframe set this to true - if not included a different doctype is used that does better layouting for ie - if included the doctype has to be changed to avoid the reserved right border for the scrollbar. ie does not show all hover effects anymore if you set this to true!",
"iframe_height_ie"=>"If the height of iframes are smaller then 500px ie does not display them right - you have to define the heigt for ie that is used - normally this is around 4-5 pixel less then the height you have defined in your iframe",
"show_border" => "By default there is a border around TWG. If you integrate TWG is most of the time looks nicer if the left,right and bottom border are removed. This value can be set with url parameters too (twg_withborder=true or twg_noborder=true). This setting is cached in the session. You have to close all browser to see the changes!. Valid values \'TRUE\' and \'FALSE\',",
"cache_dirs" => "content of directories are cached in the session - you can disable this if you have lots of image updates or are testing TWG while uploading.",
"show_twg_logo_if_registered" => "You can register and still show the TWG image if you like to support TWG",
"enable_basic_seo" => "Enable SEO urls - See howto 44 for details",
// admin part
"admin_default_upload_method" => "new 1.6 - You can set the default upload method of the admin. valid values: \'flash\' or \'html\'. html disables the menu items \'upload images\' and \'File Split Applet\'",
"admin_enable_split" => "Enable/disable the file split capabilities of TWG to get around a upload limit. Please read the howto 42 about the split test before enabling file splitting.",
"admin_file_split_is_tested" => "Spliting and merging big files is not supported by all servers. Therefore this is disabled by default. Please read the howto 42 about the split test before enabling file splitting.",
// page 2
"menu_x" => "Number of albums which are shown in a row on the overview page.",
"menu_y" => "Number of albums which are shown in a column on the overview page.",
"autodetect_maximum_thumbnails" => "twg tries to display as much thumbnails as possible without creating scrollbars - is turned off in low bandwith mode!",
"thumbnails_x" => "Number of images in a row on the thumbnail page.",
"thumbnails_y" => "Number of images in a column on the thumbnail page.",
"number_top10" => "Number of images that are shown in the top views page - The existing calculation (13) works nice with the existing layout.",
"small_pic_size" => "max. size of the web images.",
"resize_only_if_too_big" => "If images are equal or smaller they are not resized if true. You can save disk space if you set this to true and resize all pictures with an external program before uploading",
"use_small_pic_size_as_height" => "The small pic size restricts the picture to a maximum height and width of small_pic_size - therefore vertical and horizontal images have the same maximum side length. If you set this switch to true the size is used as maximum height. vertical images are then smaller then horizontal - but when you watch the images the navigation does not jump to the bottom if a vertical image is coming - If you use this parameter please decrease the picture size by ~1/3 to get the horizontal images in the same size as before (and delete the cache!!).",
"thumb_pic_size" => "max. size of the thumbnails.",
"strip_thumb_pic_size" => "You can show the thumbs for the big navigation in a different size then on the thumbnail page! Does only work if clipped images are used. ",
"menu_pic_size_x" => "width of the gallery overview pictures - has to be dividable by 2.",
"menu_pic_size_y" => "height of the gallery overview pictures - has to be dividable by 2.",
"show_clipped_images" => "clipped images in the thumbnail view - all images will be shown as squares - if you change this - delete all thumbnails in the cache!!! The size of the images (x and y) will be \$thumb_pic_size! remember - all thumbnails are squares then on the detail page you cannot see if a image is horizontal or vertical.",
"show_colage" => "true: Shows a collage of the first four images, false: 1st image of directory is shown.",
"use_random_image_for_folder" => "if true a random image of this folder is picked for the collage or the image which is shown in a folder icon.",
"folder_effect" => "there are 3 effects for the main gallery view \'fade\', \'gray\' and  \'change\' (change the images with another from the directory on mouseover!) - if you don\'t want an effect use \'\' or \'none\' - this effects looks best under ie - ff does some flickering in modus fade! - gray only works for ie (fade effect in ff as backup) - fade only for ie and ff - change for all browsers!",
"auto_skip_thumbnail_page"=> "If you set this to true the thumbnail page is only shown if you have more then numberpics (=images in the thumbsstrip in the directory). Why show an overview if all images are shown on the next page anyway ;) - false shows the thumbspage everytime. If the big navigation is not shown the thumbspage is shown allways.",
// page 3
"show_only_small_navigation" =>  "Default if only the small navigation is shown. \'TRUE\' shows only the small navigation",
"default_big_navigation" => "There are two type of Big Navigation - normal (HTML ) and dhtml (DHTML) - The dhtml version does a lot of preloading - Please do not use this if your expected users don\'t have fast connections",
"numberofpics" => "Number of pictures that are displayed in the thumbnail strip off the image page.",
"big_nav_pos" => "You can define the position of the thumbnail strip - it is only top and bottom possible. this value is ignored if you use HTML_SIDE.",
"autodetect_noscoll" => "If you have less then $numberofpics images you don\'t need to scroll at all - if you set this to true the thumbs below are static no mater which one you select (the actual thumb in not below the image anymore!)",
"use_nonscrolling_dhtml"=> "If you set this to true the dhtml thumbsbar is not scrolling anymore - it is simply moving when you click on an thumbs - it looks like the html solution but is much faster - The reason I implemented thisis because if you use  $use_dynamic_background=true the scroller does work pretty bad - therefore if you set \$use_dynamic_background to true automatically the option is set to true!",
"show_comments" => "Enables comments (Enter, Display).",
"show_login" =>  "Enables/disables the login button in the right upper corner",
"show_optionen" =>  "Enables/disables the options button in the right upper corner on the details page",
"show_new_window" =>  "Enables/disables the \'new window\' button in the right upper corner and in the options pane.",
"enable_download" => "Enable download of original files. If you don\'t want that the people can download set this parameter to false.",
"show_image_rating" => "Enables the rating of images",
"show_search" => "Shows the search",
"show_topx" => "You can enable/disalbe the topx view - be sure to enable at least one of the topx things (views, downloads, rating, comments!)",
"show_tags" => "You can enable/disalbe tags. This enable/disable the top tags, the search and the entering/editing of tags!",  
"show_public_admin_link" => "enables disables the link to the admin area !",
"show_slideshow" => "Enables / disables the slideshow functionality of TWG",
"twg_slide_type" => "Defines the default slideshow type!",
"twg_slideshow_time" => "Defines the default slide show interval.",
"show_captions" =>  "you can hide the menu element to enter a caption.",
"show_counter" => "show the counter - if not shown the counter is still counting!",
"show_help_link" => "Shows the help link",
"show_enhanced_file_infos" => "Shows the \'Info\' of an image in the menu",
"show_rotation_buttons" => "show the rotation buttons on the details page, true - shows them, false - hides them. TWG does detect if the rotation function is available - if it is not available the rotation buttons are hidden.",
"show_bandwidth_icon" => "You can hide the bandwidth icon if you like- true: shows it - false hides it (test is still done!)",
"enable_album_tree" => "You can enable/disable the album tree on the left side. There are a couple of more options where you can show the tree by default. You can define the width of this tree with album_tree_width.", 
// page 4
"print_text" => "You can print some text on the lower left corner to protect your images or at least make it a little bit harder to copy it without doing anything :). If you change this setting please delete the cache folder - otherwise generated images are not changed. This function needs the FreeType library installed!",
"print_text_original" => "Prints the text on the download image! - \$enable_direct_download has to be set to false.",
"text" => "The text",
"print_watermark" => "You can make a watermark on the images to protect your images or at least make it a little bit harder to copy it without doing anything :) If you change this setting please delete the cache folder - otherwise generated images are not changed. Please read the description of the parameters that belong to the watermark to get best results!",
"print_watermark_original" => "Prints thewatermark on the download image! - \$enable_direct_download has to be set to false.",
"watermark_small" => "This is the watermark that is used on the detail and slideshow images - can be jpg or png - png gives better results.",
"watermark_big" => "This is the watermark that is used on the download images - can be jpg or png - png gives better results. You can use a larger image here because the original images are most of the times much bigger",
"position" => "You can define the location of the watermark with this setting. The numbers show the position of the image:<br>1 2 3<br>4 5 6<br>7 8 9",
// other help text!
"simple_view" => "You have 2 views available: Simple View and Normal view. The Simple View shows the files where you maybe want to make some changes by yourself like the config, style sheets, directories and files you have to change the permissions ... The Normal View shows all files!",
"rights" => "All functions means that all folder functions are available. Folders can then be created, renamed and deleted.",
"delete_cache" => "If you change this setting the image cache in the cache folder has to be deleted. You can do this on this page a little bit further down! If you are more experienced you can only delete the images that are affected (thumbnail or detail/slideshow images).",
// New 1.8
'icon_set' => 'You can choose different icons sets. Additional can be downloaed from the TWG website. Some skins have their own icon set. You have to change this in the skin then!',
"skip_thumbnail_page" => "If you set this to true, the thumbnail page is not displayed - be careful if you have subdirectories some levels cannot be displayed if a level before has pictures as well (like the demo)!",
"autorotate_images" => "TWG can autodetect the orientation of images if your camera set this. The problem is that TWG does not know how you hold your camera. Please try which setting works for you. Make sure to delete the cache and the rotation cache if you change this. I have to use \'invert\' because I always hold my camera like this way",
"sort_images_ascending" => "true: sorts the images ascending; false: descending (date and filename!)",
"sort_by_date" => "Sorts the images by name if set to false - if set to true it tries to read the image exif data first - if  this fails it uses the filetime to sort! - read the faq for the settings you need on your server to get exif data! if you have a lot of images in a dir setting this to true could slow down the gallery because the data is read every time  a directory is read.",
"sort_by_filedate" => "Uses the last modified file date and is not searching for exif data. If false is looks for exif data and uses the file time only if no exif data is available",
"sort_albums" => "Sometimes sorting is not wanted - I cannot tell how the sorting will be - but maybe exactly how you like it (most of the time it is the order the directories are created!)",
"sort_albums_ascending" => "true: sorts the albums ascending (if \$sort_album_by_date true = newest first); false: descending () - directory struture is cached - close your browser once after changing this parameter!",
"sort_album_by_date" => "Enables sorting of folders by last modified date - directory structure is cached - close your browser once after changing this parameter!",
'open_in_maximized_view' => 'opens the image in the maximized view as it can be done in the menu - open_download_in_new_window and open_as_popup are ignored!',
'disable_tips' => 'By default on all pages small tips are shown at the bottom how to use TWG. In the advanced config you can configures them seperately! This setting simply enable or disables all of them. The text of the tips can be set in the config. So feel free to modify them to your needs.'
);
?>
