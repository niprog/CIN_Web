<?php
/*
This config files has all the parameters that are really intern or for people
who want to tweak and optimize TWG to the last point. I made this file because
config.php was getting too messy for the 'normal' user.

The settings in this file are NOT on the homepage explained - they are only
described here in this file!

The section name is always the name of the setting of the main feature.
*/
/*  
  Section 'menu_x'
*/ 
  $menu_cellspacing = 2;                 // cellspacing of the menu table
  $menu_cellpadding = 2;                 // cellpadding of the menu table
/*
  Section 'php_include'
*/
  $ignore_parameter  = array('file','Submit');  // new 1.2 - Some parameters are not wanted to be added to all twg links - (e.g. cmsphp - file parameter) - make an array with the parameters here !
	$disable_frame_adjustment_ie=false;  // new 1.3 - ie has a bug in i_frame adjustment! - if you integrate twg and the i_frames are all right in ff but totally rearranged in ie set this to true!
    $iframe_xoffset = 0;               // new 1.5.3 - if you are using php include AND divs for your layout it is possible that the iframes are not where they should be - you can define the x offset of the iframes here!
    $iframe_yoffset = 0;               // new 1.5.3 - if you are using php include AND divs for your layout it is possible that the iframes are not where they should be - you can define the y offset of the iframes here!
/* Section 'default_big_navigation' */
      $show_first_last_at_autoswitch=true; // New 1.6 - If nonscrolling thumbs strip is used you can specify if the first last buttons are shown automatically to indicate that is is possible to scroll. When a dynamic background is used this makes sense because the switch is done automatically by TWG and then the arrows are shown too if set to true!
/* Section 'html_side' */
    $disable_nav_big_sel=false;        // new 1.4 - You can disable the selection of another big navigation - especially if you have a layout that would be killed by another navigation!
    $html_side_break=2;                // new 1.4 - This is for HTML_SIDE only. you can specifiy how many images are in one row. if you show e.g. 4 images on ech side you can set this to 2 which shows an 2x2 block - if you set this to 1 you have all thumbs in one column
    $html_side_space_optimization=true;// new 1.4 - if you set this to true and select the 1st image still images are shown on the left side - if false no images would be on the left side if the 1st is selected - same for the end! if you have numberofpics_html_side - 1  images a special treatment is used - the images are static and you can always selct one of the numberofpics_html_side - 1 thumbnails.
      $html_side_show_dividor=true;    // new 1.4 - if html_side_space_optimization is true and you e.g. click on the 2nd image the 1st thumbnail is shown and after wards the 3rd 4th and 5th on the left side - the dividor is added between the thumb of image 1 and 3 the show the user where the image belong in the order. If set to false this dividor is not shown.
      $show_html_side_left_only=false; // new 1.5.3 - if you want to have a static number of thumbs on the left side and none of the right of the image you can set this to true - numberofpics_html_side is used and HTML_SIDE - if you like to show more thumbnails increase numberofpics_html_side and modify the style div.sidenavleft
/* Section 'bandwidth' */
  $bandwidth_limit=30;                 // this is the boundary for low bandwidth 30 = kbit/s
	$bandwidth_limit_high=3000;          // new 1.5 - This is only the limit where the smily at the green icon is shown :) - no different settings - just a smily in the bandwidth icon - if you have DSL 16000 or a T1 line ... - friend of mine wanted this ...
	$low_show_colage = false;
	$low_count_views = false;
	$low_cmotion_gallery_limit_ie=20;
	$low_cmotion_gallery_limit_firefox=10;
	$low_compression = 75;               // be carefull with the compression parameter - if someone with low bandwidth calls the gallery first the images are generated with lower quality this will be then for all users - the maximized slideshow images are NOT cached - therefore its good to change this parameter later on to a lower value (or call the gallery first by yourself on a fast line)
	$low_thumbnails_x = $thumbnails_x-1;
	$low_thumbnails_y = $thumbnails_y-1;
	$low_number_top10 =  ($low_thumbnails_x * ($low_thumbnails_y -2)) + 1;
	$low_show_big_left_right_buttons=false;
	$low_enable_maximized_view=false;    // this is too heavy for a low bandwidth
	$low_default_is_fullscreen=false;    // has to be set too because otherwise lowbandwidth starts in full screen
  $low_show_only_small_navigation='TRUE'; // or 'FALSE' the next two settings are normally set by an url parameter - this parameter is overwritten in lowbandwidth mode
	$low_twg_slide_type='FALSE';         // or 'TRUE' or 'FULL'
	$low_default_big_navigation='HTML';  // normally not shown in this modus - but the user can still enable the big navigation - and than this is the default
	$low_show_background_images=false;   // new 1.3 - This disables the background images back.png, if present
  $low_folder_effect='';               // new 1.4 - you can select a different folder effect for low bandwidth or disable it!
  $low_activate_lightbox_thumb=false;  // new 1.5 low settings for the lightbox script
	$low_activate_lightbox_thumb_full=false;
  $low_activate_lightbox_image=false;
  $low_video_autostart=false;
  $low_show_videos=true;               // new 1.5 - enable/disable embedded video in low bandwidth mode! - if javascript is disabled the low settings are used!
   // new 1.7.7 - the settings for the mobile mode!
   $twg_mobile_show_breadcrumb = false;
   $twg_mobile_show_menu_items = false;
   $twg_mobile_show_rating = false;
   $twg_mobile_show_comments = false;
   $twg_mobile_show_counter=false;
   $twg_mobile_show_big_navigation = false;
   $twg_mobile_use_maximized_view = true; // This is automatically disabled for folders with a video.php.
   $twg_mobile_menu_x = 2; 
   $twg_mobile_menu_y = 3;
   $twg_mobile_thumbnails_x = 3;
   $twg_mobile_thumbnails_y = 6; // scrolling is easyer than paging on a mobile device.
   $twg_mobile_responsive_main_page = true;
   $twg_mobile_responsive_thumb_page = true;
   $twg_mobile_responsive_detail_page = true; // look at $twg_mobile_use_maximized_view. If you have this to true the detail page is normally not shown. 
   $twg_mobile_max_description_height = 100;  // Defines the max-height the folder description can have. If the window gets smaller the folderdescription text does get more height and if this limit is reached the text is cut off and ... are shown.
    
/* Section 'internal' */
$debug_file = dirname(__FILE__) . '/' . $counterdir . '/_mydebug.out'; // new 1.1 - this is your debug file - if any error happen at TWG - they are written there! some installations don't allow writing this file to the main directory! Please write this file to a writeable directory then. If you want to disable debuging you have to set the file to '';
$log_file = dirname(__FILE__) . '/' . $counterdir . '/_twg.log'; // new 1.6 - this is the logging file - right now only logins and wrong logins to the TWG Admin are logged.
$cmotion_gallery_limit_ie=40;            // new 1.1 - this is the max number of images that are shown in one cmotion gallery. At the end there will be a small arrow to go o the next x images :) IE does nice background loading and therefore the number of images can be much larger (after 5 images the cmotiongallery works!)  firefox does not with this script (if someone can solve this - die developer of the script couldn't :()  all images have to be loaded in the beginning (20x4k=80k - with ISDN ~ 10 sek - that's the maximum I would wait!) - better see optimizer settings
$cmotion_gallery_limit_firefox=20;
$enable_optimize_cmotion_gallery_limit_ie=false; // enable IE optimization for the cmotion gallery - if sometimes the preview images below the big images do not appear - set this value to false - cmotion_gallery_limit_ff is used then for firefox as well!
$extension_slideshow = 'slide.jpg';      // extensions of the images
$extension_thumb = 'thumb.jpg';
$extension_small = 'small.jpg';
$test_email_by_checking_url=false;       // new 1.2 - twg can test entered emails by trying the corresponding email domain - e.g. test@test.com would be tested by opening a connection to www.test.com - if this fails the email is not valid. This is not a 100% test because there are a few email servers that don't have a Http server running! If you set this to true these users have to enter a different email - if you are not online (test against wwww.google.de fails!) this test is skipped.
$enable_folderdescription=true;          // new 1.2 - if you don't use this turn it off - makes the gallery a little bit faster :) - this setting is for foldername.txt AND image.txt
$enable_foldername=true;                 // new 1.2 - if you don't use this turn it off - makes the gallery a little bit faster :) - see how-to's if you don't know what this is :)
$enable_external_html_include=true;      // new 1.2 - Enables disables usage of: header/footer/overview/thumb and image.htm ! - if you don't use this turn it off - makes the gallery a little bit faster :) -see how-tow's if you don't know what this is :)
$enable_smily_support=true;              // new 1.2 -  :) , ;) and :( are shown as smiles - adapt the size of the smiles if you change the font size ! - read the how-to about smilies !!
$url_file = 'url.txt';                   // new 1.3 - you can place your images on an extern http - on the local server are only some working images! This only works of fsocksopen is available. Please check the how-to!
$show_background_images=true;            // new 1.3 - you can enable/disable the including of the background images - turn this of if you don't want to use background images!
$min=10;                                 // new 1.3c - after how many minutes does a user count as a new user - 5 means that if he does not do anything for 5 minutes the counter is increased
$resize_folder_gif = false;              // new 1.3c - if you exchange the original buttons/ordner.gif and the gif is too big it is not resized by default and this looks bad in ie or ff - set this swtich to true - the gif is resized to the menu size of the others! this works too for the folder.gif and the private.gif!
$use_sha1_for_password=true;             //new 1.2 - you can use SHA1 or SHA256 to generate the hash values of the passwords. true = SHA1, false=SHA256. If SHA1 is not available on your system (php <4.3) the internal SHA256 is used! TWG has a password.php where you can generate your passwords!
$try_to_increase_memory_limit_to_32MB = false; // new 1.4 - TWG can try to increase the memory limit to 32MB - but this is most of the time disabled by security reasons - if you have problems with the memory you can try to set this to true. if you find errors in the debug file because of this - use false here ....
$disable_enhanced_keybord_navigation = false; // new 1.4.1 - If you include TWG into a page and you have other input fields you should disable the enhanced keyborad navigation for t=title, c = comments ...
$enable_random_image_caching=true;       // new 1.4.2 - You can enable caching of random images - if you have enough space  and the thumbsize is not the random size you can urn his to true - shows he random images much faster if they are already generated.
$timezone='';                            // new 1.4.3 - for all date calls a timezone has o be set since 5.1.x - if you need exact times - enter your timezone - see http://www.dynamicwebpages.de/php/timezones.php
$enable_ie_filename_fix=true;            // new 1.6 - shows the right file name in ie when you use 'save as..' - but you loose a little bit of the browser caching - shown pictures are loaded from the server again - decide what you want - save as or a faster gallery! I have set this to true because the difference is very little because I do preloading anyway.
$allow_all_html_captions=false;          // new 1.6 - You can allow to enter everything for captions! All html - simply everything! - This is false be default to protect your gallery! if true scripts could be executed on your server if someone has the right to enter captions - only set this to true if you trust ALL of your users that are allowed to enter captions!!!
$cache_gen_wait_time=0.5;                // new 1.6 - time in s. This is the time the generator of the cache waits until it processes the next image - don't kill your server ;). should not be below 0.1
$max_gen_num=10000;                      // new 1.6 - Number of cache images that are generated by the admin. If the number is too big the scripts runs too long and the max_execution_time is not enough. I set this time internally to 10 min but this does sometimes not work. Then you have to change max_execution_time in the php.ini or decreate this value to a number your server can handle.
$disable_direct_thumbs_access=false;     // new 1.4.1 - if you use private folders and really want to protect your images 100% you have to set this switch to true! then ALL images are loaded over the image.php and no thumbs are directly linked anymore - it is then possible to protect your cache as well. The optimized slideshow is then disabled because it does only work with the cache! Please note that this will slow down your server a lot! Only use this for small galleries or a huge server!
$use_direct_small=true;                  // new 1.6.1 - Use the small images directly from the cache  - if you have problems with displaying images with some file names turn this off!
$show_flv_player_below_iframe=false;     // new 1.7 - If you set this to true the fullscreen does not work anymore, if false the iframes are shown below the flash. Decide by yourself what you like ;).
$debug_time = false;                     // new 1.7.1 - this is only for internal optimization. I measure the time how long the script uses to generate one page - I want to optimize this time and therefore I track it!
$cachedir_save = $cachedir;              // $cachedir is mofidied in php include. On some places the not modivied variable is needed.
$maximum_transactions_per_session=20000; // new 1.5.0.2 - you can limit the number of transactions per session - this limit was implemented becasue if a bad robot cycles through your gallery you will gets lots of trafic. please note - each image that is shown is one transaction too! A change from one page to another is ~ 10 (when the cache images are generated - otherwiese each image is another hit - if you disable direct cache access each page needs up to 50 hits!)  10000 is ~ 1000 pages until you get a warning to closes the browser and restart it! This limit should normally ony be reached by a robot! The setting is connected to max_gen_num becaouse this is the biggest number of transactions that is done by TWG
$use_twg_glob=false;                     // new 1.8.4 - glob and safe mode is not working properly on some systems. If you don't get the language dropdown set this to true. The icons sets are still not read because the other function does not support directories only.
$image_factor=1.8;                       // new 1.8.5 - this is the factor of the images used for the iframes of the slideshow. If you have smaller images you can redurce this value and still have the full display. This should be used if you want to integrate TWG into a very small we page.
$iptc_encoding = '';                     // new 1.8.5 - if you have utf-8 iptc tags you can use $iptc_encoding = 'utf-8'; here. otherwise all entries are utf-8 encoded.
$print_memory_usage=false;               // new 1.8.5 - shows the memory when a image is created. before this was competely internal but now it can also be used to look for bootlenecks during image generation!
$config_twg_root = '';                   // new 1.8.5.2 - If the session is not working properly the $config_twg_root variable can be set to enable at least the slideshows. Set this variable to the full path of your main file (if you use php include e.g. /gallery/gallery.php). Only use this if e.g. the slideshow does not return to the normal page
$use_ie_compability_mode=true;           // new 1.8.6.x - You can disable the compability mode for ie. By default this is on to support all ie versions. If you include TWG in an iframe you might want to turn this of the have the same mode as the outer page. Please check with all the browsers you want to support what is best for you.  
$global_use_ports = true;                // new 2.0.6 - You can disable that ports are added to the url if != port 80. Somittimes this is needed if you are behind a proxy that does the port mapping!  
$use_manual_port = -1;                   // new 2.2- You can set a manual port at the places where absolute urls are generated. If your gallery is inside a network with e.g. port 80 but outside only reachable with 8080 you can enter 8080 here. But be aware that internaly 8080 is also added.

$twg_version_internal='2.2';           // new 1.2 - version for the administration and the display :) - see how-tow's if you don't know what this is :)

// minimum top x is 5 !
if ($number_top10 < 5) $number_top10 = 5;
if ($low_number_top10 < 5) $low_number_top10 = 5;

?>