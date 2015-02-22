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
// English Language Module for TWG Admin v1.7.8 
global $_VERSION;
global $password_file;
global $url_file;

$GLOBALS["charset"] = "utf-8";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "d-m-Y H:i";
$GLOBALS["error_msg"] = array(
 // error
 "error" => "ERROR(S)",
 "back" => "Go Back",

 // root
 "home" => "The home directory doesn't exist, check your settings.<br>If you have installed TWG to the root directory please move it to a subdirectory because some systems do not allow TWG Admin to access this directory.",
 "homeroot" => "The home directory can't be accessed. Some systems do not allow to access the root directory with TWG Admin. It looks like this is the case with your installation. Please install TWG to a subdirectory if you want to use TWG Admin.",
 "abovehome" => "The current directory may not be above the home directory.",
 "targetabovehome" => "The target directory may not be above the home directory.",

 // exist
 "direxist" => "This directory doesn't exist.",
 //"filedoesexist" => "This file already exists.",
 "fileexist" => "This file doesn't exist.",
 "itemdoesexist" => "This item already exists.",
 "itemexist" => "This item doesn't exist.",
 "targetexist" => "The target directory doesn't exist.",
 "targetdoesexist" => "The target item already exists.",

 // open
 "opendir" => "Unable to open directory.",
 "readdir" => "Unable to read directory.",

 // access
 "accessdir" => "You are not allowed to access this directory.",
 "accessfile" => "You are not allowed to access this file.",
 "accessitem" => "You are not allowed to access this item.",
 "accessfunc" => "You are not allowed to use this function.",
 "accesstarget" => "You are not allowed to access the target directory.",

 // actions
 "permread" => "Getting permissions failed.",
 "permchange" => "Permission-change failed.",
 "openfile" => "File opening failed.",
 "savefile" => "File saving failed.",
 "createfile" => "File creation failed.",
 "createdir" => "Directory creation failed.",
 "uploadfile" => "File upload failed.",
 "isuploadfile" => "File upload check failed.",
 "missingtemp" => "Missing a temporary folder",
 "copyitem" => "Copying failed.",
 "moveitem" => "Moving failed.",
 "delitem" => "Deleting failed.",
 "chpass" => "Changing password failed.",
 "deluser" => "Removing user failed.",
 "adduser" => "Adding user failed.",
 "saveuser" => "Saving user failed.",
 "searchnothing" => "You must supply something to search for.",

 // misc
 "miscnofunc" => "Function unavailable.",
 "miscfilesize" => "File exceeds maximum size.",
 "miscfilepart" => "File was only partially uploaded.",
 "miscnoname" => "You must supply a name.",
 "miscselitems" => "You haven't selected any item(s).",
 "miscdelitems" => "Are you sure you want to delete these \"+num+\" item(s)?",
 "miscdeluser" => "Are you sure you want to delete user '\"+user+\"'?",
 "miscnopassdiff" => "New password doesn't differ from current.",
 "miscnopassmatch" => "Passwords don't match.",
 "miscfieldmissed" => "You missed an important field.",
 "miscnouserpass" => "Username or password incorrect.",
 "miscselfremove" => "You can't remove yourself.",
 "miscuserexist" => "User already exists.",
 "miscnofinduser" => "Can't find user.",
 "extract_noarchive" => "The File is no extractable Archive.",
 "extract_unknowntype" => "Unknown Archive Type",
 
  // TWG extensions
  "error_savemode" => "Safemode is enabled on your system.</b><br>If the error message is not specifiy most likely this is the reason why you got this error.",
  "error_debug_empty" => "Please check the debug file! It should be empty if TWG runs optimal!",
  "userfile" => "User file is ",
  "admin_ok" => "<b><font color='green'>writeable</font></b> - You can change passwords and manage the users.",
  "admin_not_writeable" => "<b><font color='red'>Unwriteable</font></b> - please check the 'Info' menu item.",
  "admin_not_available" => "<b><font color='red'>not available</font></b> - please check the 'Info' menu item.",
  "users_file_missing" => "The user file \"admin/_config/.htusers.php\" is missing.\\nIf you have done an update with the files from the installer\\nyou have not copied the filed from the full directory of the\\ninstall_twg.zip. You find the files that are missing for a full\\ninstall in this directory. Please copy at least the user file to\\nthe admin folder!",
  "rename_not" => "Could not rename '%s' to '%s",
  "multiplefolder" => "You have entered a | in your folders. This character is used to give a user more then one folder he can work in. This is only possible for users with frond end rights.",
  "error_twglic" => "Your license file twg.lic.php does not have exact 5 lines.\\nPlease remove the empty lines before the <?php and after the ?>.\\nOtherwise TWG does not work properly!",
  "nosession" => "It seems that the session does not work. You will get logged out right after the login. Please contact your hoster to check the php installation. If you have your own server please check the session.save_path variable and read howto 53 of the TWG FAQ."
);

$GLOBALS["messages"] = array(
 // links
 "simpleview"	=> "Simple view",
 "normalview"	=> "Normal view",
 "gonormalview" => "Go to the normal view that shows all files",
 "gosimpleview"  => "Go to the simple view that shows only important files.",
 "hidden"		=> " hidden ",
 "permlink" => "Change Permissions",
 "editlink" => "Edit",
 "downlink" => "Download",
 "uplink" => "Up",
 "homelink" => "Home",
 "reloadlink" => "Reload",
 "copylink" => "Copy",
 "movelink" => "Move",
 "dellink" => "Delete",
 "comprlink" => "Archive",
 "adminlink" => "Admin",
 "logoutlink" => "Logout",
 "uploadlink" => "<b>Upload</b>",
 "searchlink" => "Search",
 "extractlink" => "Extract Archive",
 'chmodlink' => 'Change (chmod) Rights (Folder/File(s))', // new mic
 'logolink' => 'Go to the TWG Website (new window)', // new mic
  // list
 "nameheader" => "Name",
 "sizeheader" => "Size",
 "typeheader" => "Type",
 "modifheader" => "Modified",
 "permheader" => "Perms",
 "actionheader" => "Actions",
 "pathheader" => "Path",

 // buttons
 "btncancel" => "Cancel",
 "btnback" => "Back",
 "btnsave" => "Save",
 "btnchange" => "Change",
 "btnreset" => "Reset",
 "btnclose" => "Close",
 "btncreate" => "Create",
 "btnsearch" => "Search",
 "btnupload" => "Upload",
 "btncopy" => "Copy",
 "btnmove" => "Move",
 "btnlogin" => "Login",
 "btnlogout" => "Logout",
 "btnadd" => "Add",
 "btnedit" => "Edit",
 "btnremove" => "Remove",

 // user messages, new in joomlaXplorer 1.3.0
 'renamelink' => 'Rename',
 'confirm_delete_file' => 'Are you sure you want to delete this file? \\n%s',
 'confirm_delete_dir' => 'Are you sure you want to delete the directory\\n%s?\\nAll content of this directory will be deleted!',
 'success_delete_file' => 'Item(s) successfully deleted.',
 'success_rename_file' => 'The directory/file %s was successfully renamed to %s.',
 'success_upload_file' => '%s Item(s) successfully uploaded.',

 // actions
 "actdir" => "Directory",
 "actperms" => "Change permissions",
 "actedit" => "Edit file",
 "actsearchresults" => "Search results",
 "actcopyitems" => "Copy item(s)",
 "actcopyfrom" => "Copy from /%s to /%s ",
 "actmoveitems" => "Move item(s)",
 "actmovefrom" => "Move from /%s to /%s ",
 "actlogin" => "Welcome to the TWG Administration",
 "actloginheader" => "Login to use the TWG administration",
 "actadmin" => "Administration",
 "actchpwd" => "Change password",
 "actusers" => "Users",
 "actarchive" => "Archive item(s)",
 "actupload" => "Upload file(s)",

 // misc
 "miscitems" => "Item(s)",
 "miscfree" => "Free",
 "miscusername" => "Username",
 "miscpassword" => "Password",
 "miscoldpass" => "Old password",
 "miscnewpass" => "New password",
 "miscconfpass" => "Confirm password",
 "miscconfnewpass" => "Confirm new password",
 "miscchpass" => "Change password",
 "mischomedir" => "Home directory<br>(For front end users you can specify multiple folders. Use | as seperator)",
 "mischomeurl" => "Home URL",
 "miscshowhidden" => "Show hidden items",
 "mischidepattern" => "Hide pattern",
 "miscperms" => "Permissions",
 "miscupload" => "TWG Flash Uploader settings",
 "miscuseritems" => "(name, home directory, show hidden items, permissions, uploadpermissions ,active)",
 "miscadduser" => "add user",
 "miscedituser" => "edit user '%s'",
 "miscactive" => "Active",
 "misclang" => "Language",
 "miscnoresult" => "No results available.",
 "miscsubdirs" => "Search subdirectories",
 "miscpermnames" => array("Only Frontend Login","Frontend Edit", "Frontend Upload","Backend Modify", "Administrator"),
 "miscuploadnames" => array("All Functions", "File Upload, Edit, Delete", "File Upload + Delete","File Upload Only"),
 "miscyesno" => array("Yes","No","Y","N"),
 "miscchmod" => array("Owner", "Group", "Public"),

 'miscowner' => "Owner",
 'miscownerdesc' => '<strong>Description:</strong><br>User (UID) /<br>Group (GID)<br>Current rights:<br><strong> %s ( %s ) </strong>/<br><strong> %s ( %s )</strong>',

 'extract_warning' => "Do you really want to extract this file? Here?\\nThis will overwrite existing files when not used carefully!",
 'extract_success' => "Extraction was successful",
 'extract_failure' => "Extraction failed",

 // TWG extensions !!
 'twgtypes' => array(
 "folder.txt" => "TWG folder description",
 "folder_xx.txt" => "TWG folder description (lang)",
 "foldername.txt" => "TWG album name",
 "foldername_xx.txt" => "TWG album name (lang)",
 "image.txt" => "TWG image description",
 "image_xx.txt" => "TWG image description (lang)",
 "watermark.txt" => "TWG watermark text",
 "link.txt" => "TWG external link target",
 "root.txt" => "TWG home link",
 $url_file => "TWG URL for external images",
 "style.css" => "TWG style sheet",
 $password_file => "TWG password file",
 "albumr.txt" => "TWG album description right",
 "albumr_xx.txt" => "TWG album description right (lang)",
 "albuml.txt" => "TWG album description left",
 "albuml_xx.txt" => "TWG album description left (lang)"),

 "thumbnail" => "Thumbnail",
 "resolution" => "Resolution",
 "passchanged" => "Password changed",
 "filesaved" => "The file %s was saved.",
 "adminpass" => "Please change the admin password.",
 "movewarning" => "If you copy/move/rename a folder with pictures the xml files in the xml folder are not copied or renamed. You have to do this manually!<br />If you set \$autocreate_folder_id = true; the file folder.id is created which does identify a folder and you only have to delete the folder.id when you copy a folder and duplicate the xml files if you like.",
 "messageperm" => "Rights changed.",
 "wronglogin" => "Username or password wrong.",
 "lowpermissions" => "You don't have permission to log into the backend.<br/>You can use the actions available after the frontend login.",
 "edituser" => "Edit User",
 "user_help_text" =>  "You can give the users different rights. Please note that the rights are always depending on the home directory of the user. The default should be the pictures directory!",
 "user_help_1" => "Frontend Edit = Login at the frontend to enter captions, tags, delete comments and rotate images permanently.",
 "user_help_2" => "Frontend Upload = Login at the frontend to upload files below the home directory with the Flash Uploader.",
 "user_help_3" => "Backend Modify = Upload and modify files with the TWGXplorer below the home directory.",
 "user_help_4" => "Administrator = Full access to all areas of TWG Admin. Use . in the 'Home directory' for the main TWG directory!",
 "edit_return" => "Return to directory after saving?",
 "up_not_detected" => "Upload max filesize not detected.",
 "up_flash" => "The TWG Flash Uploader requires Flash 8! If the uploader does not work click %shere%s to get to the old html upload form.",
 "up_quality" => " Quality",
 "up_max" => "Maximum height/width of JPG's",
 "up_max_size" => "Maximum allowed size for uploaded files:  ",
 "up_html" => "This is the normal HTML upload form. To go to the new TWG Flash Uploder please click %shere.",
 "rename_new" => "New Name:",
 "rename_header" => "Rename a directory or file...",
 "extra_howto" => "Please read how-to %s for more information.<br>Click <a target=\'help\' href=\'%s/en/faq.php#h%s\'><b>here</b></a> to get there.",
 "extra_safemode" => "Safemode is enabled on your system. Please read how-to %s for more information and the restrictions that comes with this setting.<br>Click <a target=\'help\' href=\'%s/en/faq.php#h%s\'><b>here</b></a> to get there.",
 );

// twg menu screen! - still the old menu !!!! -> has to be change to the new one!
$GLOBALS["menu_messages"] = array(
"help" => "About/Help",
"twgxplorer" => "TWGXplorer",
"info" => "Info",
"color" => "Color Manager",
"email" => "Admin E-Mail",
"helper" => "Configuration",
"admin" => "User Administration",
"logout" => "Logout",

"hello" => "Hello",
"simplevw" => "Simple View",
"normalvw" => "Normal View",
"uploadima" => "Upload Images",
"splitima" => "Split Files",
"configtwg" => "Configure TWG",
"generatecach" => "Generate Cache",
"generateprev" => "Generate Previews",
"generateiptc" => "Extract IPTC data",
"clncach" => "Clean Cache",
"generatepassw" => "Generate Passwords",
"debugfile" => "Debug File",
"foldovervw" => "Folder Overview",
"installcheck" => "Installation Check",
"installlcheck" => "Installation Check",
"permissions" => "Permissions",
"recomsett" => "Recommended &nbsp;&nbsp;Settings",
"showphpinfo" => "Show php info",
"backtotwg" => "Back to TWG",
"register" => "Register for free"
);

// twg configuration screen!
$GLOBALS["config_messages"] = array(
"passchanged" => "Password changed",

"noskin" => "No skin",
"admin" => "Admin",
"black" => "Black",
"green" => "Green",
"newyork" => "New York",
"transparant" => "Transparent",
"winter" => "Winter",
"roundcorners" => "Round corners",
"white" => "White",

"true" => "true",
"false" => "false",

"optimized" => "Optimized",
"normal" => "Normal",
"maximized" => "Maximized",

"fade" => "Fade",
"grey" => "Grey",
"change" => "Change",
"none" => "None",

"top" => "Top",
"bottom" => "Bottom",

"htmlside" => "HTML SIDE",
"topleft" => "top-left",
"topcenter" => "top-center",
"topright" => "top-right",
"middleleft" => "middle-left",
"middlecenter" => "middle-center",
"middleright" => "middle-right",
"bottomleft" => "bottom-left",
"bottomcenter" => "bottom-center",
"bottomright" => "bottom-right",

"configsaved" => "my_config.php saved.",
"configdeleted" => "my_config.php deleted.",
"debugdeleted" => "Debug file deleted.",
"nodebugfound" => "No debug file found.",
"cashdeleted" => "Cache files deleted.",
"rotationdeleted" => "Rotation files deleted.",
"sessiondeleted" => "Session deleted.",
"previmagegen" => "Preview images generated. Please check if the files are there. If not please check the permissions of the folders!",
"readiptcmessage" => "IPTC data was sucessfully extracted from the images and added to the xml files."
);

$GLOBALS["config_screen"] = array(
"twgconfig" => "TWG Configuration",
"Onthispage" => "On this page you find some functions of configure TWG. To configure TWG in more detail please edit the config.php. Please read the description of the parameters (in the config.php or on the website) and check the how-to's to configure TWG optimal for your needs.",
"inthissection" => "In this section you can configure the main functions of TWG. All settings you make here are stored in the file my_config.php.
TWG has a big configuration file called config.php.
Look for the settings you want to change in the config.php and store your extra settings on the additional tab.<br>All settings stored in my_config.php overwrite the settings of config.php!",
"configtwg" => "Configure TWG",
"pleasread" => "Please read the",
"becauseyou" => "because you can do a lot of extra configurations by storing e.g. a folder.txt in a folder!<p><br>Settings that are different from the default are marked <span style='color:#0000ff'>blue</span>!</p>",
"confignotwr" => "my_config.php is not writeable! Check the 'Info' menu item.",
"mainfolnotwr" => "The TWG main folder is not writeable. Check the 'Info' menu item.",
);

$GLOBALS["config_form_block"] = array(
"induvidual" => "Individual",
"image" => "Image",
"fuctionality" => "Functionality",
"watermark" => "Watermark",
"additional" => "Additional",
"indivisettings" => "Individual settings",
"changepassw" => "You should change the passwords displayed on this page.
 You can adjust additional settings like described in the config.php or the",
"changepasswl" => "install page of the website",
"changepasswll" => ". Store them on the additional tab.",
"protgalpassw" => "Protected galleries password",
"broutitlperf" => "Browser title prefix",
"defgaltit" => "Default Gallery Title",
"skin" => "Skin",
"twgincl" => "Is TWG included in an iframe? (see ?)",
"heiiframe" => "Height of iframe for ie (see ?)",
"shwbord" => "Show the border (left, right, bottom)?",
"enablesess" => "Enable session caching of directories and files.<br><b>Should be enabled after the setup is done</b>!",
"shwtwglogo" => "Show TWG logo when registered",
"enablebasicseo" => "Enable SEO urls",
"adminsettings" => "TWG Admin settings",
"adminupload" => "Default upload method",
"adminenablesplit" => "Enable support for splitted files",
"adminchecksplit" => "File split was tested on the server",

"imagesett" => "Image settings",
"adjuimagdis" => "You can adjust how images are displayed in TWG. If you make any changes on this tab you have to clean the cache (see below)!
 You can adjust additional settings like described in the config.php or the",
"adjuimagdisl" => "install page of the website",
"adjuimagdisll" => "Store them on the additional tab.<br>&nbsp;",
"columon" => "Columns on the overview page",
"rowson" => "Rows on the overview page",
"autodetnu" => "Autodetect the number of thumbnails?",
"thumbinrow" => "Number of thumbnails in a row",
"thumbincol" => "Number of thumbnails in a column",
"imageintop" => "Number of images in  the top X",
"sizewebima" => "Size of the web images",
"resizeima" => "Resize images only if they are too big?",
"usesizeofweb" => "Resize horizonal and vertical images to <br>&nbsp;&nbsp;&nbsp;&nbsp;the same height?",
"sizeofthumb" => "Size of the thumbnails", 
"sizeofthumbdet" => "Size of the thumbnails on the detail page",
"widthofgal" => "Width of the gallery overview pictures",
"heightofgal" => "Height of the gallery overview pictures",
"clipthethumb" => "Clip the thumbnails?", 
"showacol" => "Show a collage on the overview?",
"userandom" => "Use random images for the overview?",
"foldereffect" => "Folder effect",
"skipthumb" => "Skip thumb page if not needed (<= ",
"skipthumbpic" => " pics)",

"endisablefunc" => "Enable/disable functions of TWG",
"youendisablefunc" => "You can enable and disable main functions of TWG here. You can adjust additional settings like described in the config.php or the ",
"installpage" => "install page of the website.",
"storethem" => "Store them on the additional tab.",
"hidebignav" => "Hide big navigation?",
"defaubignav" => "Default big navigation",
"numberofpics" => "Pics in the thumbstrip",
"noscrolling" => "No scrolling when all thumbs are shown",
"dhtmlworks" => "DHML works like the html solution",
"showcomment" => "Show comments?",
"showlogin" => "Show login?",
"showoptions" => "Show options?",
"shownwewin" => "Show new window?",
"enabledownl" => "Enable download/popup?",
"showimagerat" => "Show image rating?",
"showsearch" => "Show search?",
"showpublic" => "Show public admin link?",
"showslidesh" => "Show slideshow?",
"slideshowty" => "&nbsp;&nbsp;&nbsp;Default slideshow type",
"slideshowti" => "&nbsp;&nbsp;&nbsp;Default slideshow time",
"showcapt" => "Show captions?",
"showthecount" => "Show the counter?",
"showhelpl" => "Show the help link?",
"showtitleinf" => "Show the file info?",
"showrotbut" => "Show rotation buttons?",
"showbandwico" => "Show bandwidth icon?",
"show_topx" => "Show top X?",
"show_tags" => "Show tags?",
"enable_album_tree" => "Show the album tree?",
"big_nav_pos" => "Position of navigation",

"watermarkset" => "Watermark settings",
"configwmset" => "You can configure the watermark settings here. If you make any changes on this tab you have to clean the cache (see below)!<br/>You can adjust additional settings like described in the config.php or the ",
"configwmsetl" => "install page of the website</a>. Store them on the additional tab.<br>&nbsp;",
"printtextwm" => "Print text watermark?",
"printtextwmo" => "Print text watermark on original?",
"wmtext" => "Watermark text",
"prntimgwm" => "Print image watermark?",
"prntimgwmo" => "Print image watermark on original?",
"normwm" => "Normal watermark",
"wmfororig" => "Watermark for originals",
"posimawm" => "Position of image watermark",
"additsett" => "Additional settings!",
"twgparamet" => " TWG has over 230 parameters where you can configure almost everything. The parameters are described on the ",
"twgparametl" => "install page of the website",
"twgparametll" => " and in the config.php (you can open the file in the TWGXplorer!). If you want to change a parameter just copy the new settings in the textarea below. The code below has to be valid php code! TWG admin is checking this code es good as possible.<br/>An example for a true/false parameter is: ",
"twgparametlll" => "<br>An example for a string is:",
"twgparametllll" => "<br>If you are not sure what type you have to use look at the website - the types are shown there!<br>&nbsp;",
"addsave" => "Save",
"reallyreset" => "Really reset the configuration to the default (= deleting my_config.php)?",
"resetconfig" => "Reset Configuration",

// New 1.8
'savemod' => 'Save only modified values to my_config.php',
'icon_set' => 'Icon set',
'autorotate_images' => 'Enable autorotate?', 
'autorotate_images_none' => 'No',
'autorotate_images_normal' => 'Normal',
'autorotate_images_invert' => 'Invert',
'skip_thumbnail_page' => 'Skip thumbnail page?', 
'sort_header' => 'Sorting',
'sort_text' => 'In the next section you can define how images and albums are sorted. Ascending means A is first and for dates this mean newest is first!<br>If you change the sorting you have to delete the <a class="aconfig" href="#clean">session cache</a>!',
'sort_images_ascending' => 'Sort images ascending?',
'sort_by_date' => 'Sort images by date?',
'sort_by_filedate' => 'Sort images by file date?',
'sort_albums' => 'Sort albums?',
'sort_albums_ascending' => 'Sort albums ascending?',
'sort_album_by_date' => 'Sort albums by date?',
'open_in_maximized_view' => 'Open images maximized?',
'disable_tips' => 'Disable all tips?',
'link_more' => '(more)',
'use_round_corners' => 'Use round corners'
);

$GLOBALS["config_screen_main"] = array(
"gentwgcache" => "Generate TWG Cache",
"cachestep" => "Normally the cache is generated step by step. If you generate the whole cache this will takes some time now but will speedup the gallery for the first users!<br/>On the right side the code for generation is created. This may take up to 2 minutes! A maximum of 5000 images are created at once! You might have to start it again!",
"generateprev" => "Generate preview images for other file formats",
"displfilefor" => "To display fileformats other than jpg you have to provide preview images that are displayed in the gallery. TWG can create default images with a logo of the filetype for you. The default images are defined in \$other_file_formats_previews.",
"generatedimag" => " The generated images are stored in the directory of the other file format. Make sure that this folders are writeable for php.<br>If you provide your own previews TWG will not overwrite this.&nbsp;",
"folderscontai" => "The folders that contains the original filetypes have to be writeable! Start generation?",
"generateprevl" => "Generate Previews",
"generateiptc" => "Extract IPTC data from images",
"iptcleft" => "TWG can extract IPTC data from images and automatically add this data to the xml file. There are 3 type of data that are read here: captions, tags and folder tags. For folder tags the sub catagories section of IPTC is used!",
"iptctext" => "Please read the howto if you want to know exactly know how IPTC data is mapped to the xml files. The tags are already read if you upload your files with the Flash Uploader!",
"iptcjs" => "Extract IPTC data (tags, captions) from all images and store it in the xml files?",
"iptcbutton" => "Extract IPTC Data",
"cleancache" => "Clean Cache",
"makeanychange" => "If you make any changes of the file size in config.php or upload new images with FTP some caches need to be refreshed. Please select the caches you want to refresh on the right side!",
"chananyfile" => " If you change any file sizes or add/remove watermarks in TWG the images in the cache directory have to be deleted.<br>&nbsp;",
"reallydelcac" => "Really delete the image cache files?",
"delimacache" => "Delete Image Cache",
"ifimagerot" => " If images are rotated permanently deleting the image cache is not enough - you have to delete the .rot files in the cache too!<br>&nbsp;",
"reallydelrot" => "Really delete the rotation info files?",
"delrotinf" => "Delete Rotation Info",
"dirstruccas" => " The directory structures is cached in the session. If you upload new images and the images are not shown right away - This is the cache to delete - The session is invalidated here - this means you are logged out of the administration too!<br/>&nbsp;",
"reallydelses" => "Really delete the Session?\\nYou are logged out after this!",
"delsescac" => "Delete Session Cache",
"genencrpass" => "Generate Encrypted Password",
"usepasswprot" => " If you use password protected galleries you should store them encrypted! Please set \$encrypt_passwords=true; to the config to enable encryption.<br>&nbsp;<p>The following chars are not allowed: '..','://', '<', '>', '('.</p>",
"enterpassw" => "Enter password and press generate:",
"generate" => "Generate",
"shahashval" => "SHA1 hash value for '",
"shahashvalde" => "SHA1 does not exist - using interneal SHA256 instead!<br>",
"copygenval" => "Copy the generated value to your config.php -> \$privatepassword or into one of your password files. If you want to use more than one password for a gallery please seperate the password with a ',' like<br/>388ad1c312a388ad1127f2258fa8d5ee,a17fed27eaa8388ad1c388ad1c3126ac320",
"debugfile" => "Debug file",
"twgdocreat" => "TWG does create a debug file where all warnings and errors that are thrown are logged. Please check the log below first if TWG does not function properly anymore. The debug file is only created if an error happens!",
"deldebugfile" => "Delete the debug file",
"reallydeldefi" => "Really delete the debug file?",
"nodefifou" => "No debug file found",
"delete" => "Delete",
);

$GLOBALS["config_screen_gen"] = array(
"title" => "TWGXplorer - File management of the TinyWebGallery",
"generimag" => "Generates the images in the cache dir.<br/>The generator waits $cache_gen_wait_time s after each image because the server load gets very high otherwise.",
"generimag2" => "<br/>&nbsp;<br/>Not yet generated cache images:  ",
"remtime" => " Remaining time: ",
"min" => " min ",
"s" => " s",
"gencach" => "Generate Cache images",
"all_created" => "All images generated",
"stop_creation" => "Stop generation",
"check_creation" => "Check cache status"
);

// twg info screen!
$GLOBALS["info_messages"] = array(
"writeble" => "Writeable",
"unwriteble" => "Unwriteable",
"notfound" => "Not found",
"allsubdirwrt" => "All sub directories are writable",
"foldersabove" => "The folders above are not writable.<br>Please fix this - otherwise xml files are saved to the ",
"folder" => " folder",
"albums" => "Albums",
"images" => "# Images",
"size" => "Size",
"twgfolder" => "TWG folder",
"imrotate" => "The function imagerotate is not found with function_exists - the file ",
"diablerotbutt" => " is created, which disables the rotation buttons.",
"back" => "back",
"checkagain" => "Check Again",
"showphpinfo" => "Show php info",
"twgimafoldov" => "TWG image folders overview:",
"thistablegif" => "This table gives you an overview of your pictures and the size you are using!",
"pleasenote" => "PLEASE NOTE:",
"numberofima" => "The number of images and the size is cached in the session and not updated as long as you don't close the browser!",
"legend" => "Legend:",
"protectgal" => "protected gallery ",
"protectgalw" => "protected gallery with ",
"protectfolim" => "protected folder image",
"folderdiscr" => "Folder description ",
"foldernm" => "Foldername ",
"folderima" => "Folder image ",
"imagetext" => "Image text ",
"albumdiscr" => "Album description ",
"backrimage" => "Background image ",
"stylesheet" => "Style sheet ",
"configfile" => "Config file ",
"charhavelang" => "<b>bold</b> characters have a language dependant variant of the detected file unless listed differently.",
"twginstalchck" => "TWG installation check for TWG ",
"highlitred" => "If any of these items are highlighted in red then please take actions to correct them. Failure to do so could lead to your TWG installation not functioning correctly.<br>Orange means that some functions tests failed and this feature is not available. Please check the ? to solve the problem! Please disable the function in the config.php! The config.php is not modified by this check!",
"no" => "No",
"yes" => "Yes",
"availeble" => "Available",
"unavaileble" => "Unavaileble",
"phpversion" => "PHP version >= 4.3.0",
"xmlsupport" => "XML support",
"gdlibsupport" => "GD lib support",
"gdlib" => "GD lib >= 2.0",
"gdversion" => "gd_version",
"imagecreate" => "imagecreatetruecolor",
"gdlibntinst" => "GDlib is not installed properly - TWG does not work!",
"memlimit" => "Memory limit",
"memlimitnotd" => "Memory limit not detected",
"verygood" => "Very Good",
"okbutdontula" => "O.k. but don\'t use large images",
"onlyusesmall" => "Only use small images",
"nolimit" => "No limit",
"unavailebleim" => "Unavaileble (imagettftext not found)",
"unavailebleurl" => "Unavailable (allow_url_fopen = off)",
"testfailed" => "Test failed - Check cache dir",
"rotateavail" => "Rotate available",
"textwaterm" => "Text watermark ",
"remotejpgsupp" => "Remote jpg support ",
"fileuploads" => "File uploads ",
"uplmaxfilesize" => "Upload max filesize",
"maxfilsntdet" => "Upload max filesize not detected",
"session" => "Session",
"javascript" => "Javascript",
"dirfilpermiss" => "Directory and File Permissions:",
"maxresolution" => "Max resolution",
"notavaileble" => "Not available",
"resizeimages" => " - Resize images > ",
"notset" => "Not set",
"mostfeatjava" => "Most features of TWG are disabled without Javascript",
"inordertofunc" => "In order for TWG to function correctly it needs to be able to access or write to certain files or directories. If you see \"Unwriteable\" you need to change the permissions on the file or directory to allow TWG to write to it. Please check ",
"onthewebsite" => " on the web site for good security settings!",
"thehtusers" => "The .htusers.php has to be writable because otherwise you cannot change any password or add users. TWGXplorer is not active until the password of the admin has changed - please change this permission with an FTP programme!",
"thepictdir" => "The pictures directory is used to store the xml files if \$store_xml_in_picfolders is true. Furthermore you can upload and manage your images with TWGXplorer. On the other hand you have to protect your images e.g. with a .htaccess file (see examples dir)",
"statusoftwg" => "Status of TWG main directory. If this is red you maybe can not save the config with the configuration and the Color Manager. Check the settings below. Change the permissions of the main folder if you cannot save the configuration.",
"theconfigdoesnt" => "The config.php doesn't has to be writeable!<br>Please store your configuration in the my_config.php. This makes it easier for you to update and see your settings.",
"mystylehstobewr" => "The my_style.css has to be writeable if you want to store the style sheet with the Color Manager!",
"animage" => "An image has to be shown below. If not, images cannot be <br>loaded properly! Please check the debug file for more details!",
"errorloima" => "Error loading image!",
"recommsett" => "Recommended settings:",
"thesesett" => "These settings are recommended for PHP in order to ensure full compatibility with TWG.",
"howevertwg" => "However, TWG will still operate if your settings do not quite match the recommended",
"directive" => "Directive",
"recommended" => "Recommended",
"actual" => "Actual",
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
"colmanager" => "Color Manager",
"thecolmanager" => "The color manger should help you to configure the colors of TWG as good as possible. You can use the Color Picker to find the RGB values you need for the configuration files. You can also select a color and click an element on the right side and make a nice layout.<br/>The created style sheet should be stored as skin or my_style.css as a template. You can also store the settings with the &quot;save css&quot; (you have to show the css first!). It will overwrite your my_style.css! If you want to change ",
"fontsize" => "font sizes you can do this in the css view before saving! Please note: You can't load the current my_style.css.<br>If you want to change the color of the iframes please edit the i_frame/iframe.css ",
"selectcss" => "Select css",
"backtopl" => "Back to the page layout",
"savestyle" => "Save style as my_style.css",
"mainfolntwr" => "The TWG main folder is not writeable. Check the 'Info' menu item.",
"stylecssntwr" => "my_style.ccs not writeable! Check the 'Info' menu item.",
"text" => "text",
"link" => "link",
"hover" => "hover",
"header" => "Header",
"foldertxt" => "folder.txt",
"topxact" => "TopX Active",
"topxinact" => "TopX Inactive",
"caption" => "Caption",
"tips" => "Tips",
"reset" => "Reset",
"showcells" => "Show cells",
"hidecells" => "Hide",
"showcss" => "Show css",
);

// twg email screen!
$GLOBALS["email_messages"] = array(
"youcaninfm" => "Here you can inform all registered users (%s) about changes of the gallery.",
"sorry" => "Sorry, the sender email \"%s\" you entered does not look like a valid email address.",
"senderadres" => "Sender address (your email)",
"subject" => "Subject",
"massage" => "Message",
"send" => "Send",
"massagesend" => "The following message was sent:",
"from" => "From",
"notloggedin" => "You are not logged in. Please go to the main page and log in properly.",
"yes" => "yes",
"no" => "no",
"sendnotifi" => "Send Notification E-Mail",
"pleasenote"	=> "Please note:",
"noemailssend" => "\$enable_email_sending = false -> Debug modus is on - no real e-mails are sent!</p>",
"usercantreg" => "\$show_email_notification = false -> User can't register on the frontend!</p>",
"click" => "Click ",
"here" => "here ",
"listof" => " for the list of subscribers",
"subscribers" => " subscribers:",
"from" => "From:",
"replyto" => "Reply-to:",
"emailsendfalse" => "\$enable_email_sending is false - no real email was sent.",
"error-of" => " of ",
"error-send" => " e-mails could not be sent. Please check the log file."
);

// twg about/help screen!
$GLOBALS["main_messages"] = array(
"welcometotwg" => "Welcome to the TWG administration",
"entrytext" => "The administration area should help you to solve some backend tasks. Therefore I implemented some utilites that should help you to use TWG better and easier.<br/>&nbsp;<center><p><br><b>If you want to support TWG - please click on one of the ad's once in a while - Thank you.</b><br/><br/><b>Please go to the website for more help! On <a href='http://www.tinywebgallery.com'>www.tinywebgallery.com</a> you will find the <a href='http://www.tinywebgallery.com/en/faq.php' >how-to's</a> and the <a href='http://www.tinywebgallery.com/en/forum.php' >forum</a>.</b><br/><br/>You have the following areas in the administration (not all are accessible for all users!):</center>",
"xplorertext" => "The TWGXplorer is a file browser that should help you to manage TWG without a FTP programm. You can (depending on your rights) perform a lot of operations to manage your pictures and even TWG. The main features are listed on the right.",
"xploreritems" => "<li>Upload and resize images</li><li>Delete/rename/move/copy images</li><li>Create and edit text files like folder.txt or even config.php</li><li>Change Permissions</li><li>Create/Extract archives</li><li>List and thumbnail view</li>",
"info" => "Info",
"infotext" => "Shows some info about your TWG installation like an installation check. It shows some directory and file permissions and  recommended settings for TWG - Please check this first if your installation does not seem to work properly.",
"color" => "Color Manager (Administrator only)",
"colortext" => "Pretty nice tool to create a nice style sheet for TWG - select a color and click on the preview to see how it looks. Then create a style sheet and save it as my_style.css. Please check the how-tos on the website how to manage styles or skins.",
"email" => "Admin email (Administrator only)",
"emailtext" => "You can write an email too all registered users.",
"helper" => "Configuration (Administrator only)",
"helpertext" => "Here you can configure the main functions of TWG. There are also some utilities to help you working with TWG like cleaning caches, generating passwords and checking the debug file.",
"user" => "User Administration",
"usertext" => "You can manage the users of the backend here. Create users and give them access to certain areas (mainly the pictures directory I would say)."
);

// Messages in the javascript parts
// \n has to be written as \\n because it's uses in Javascript! \ has always be escaped again! don't use &uuml; or something like this here!
$GLOBALS["js_messages"] = array(
"errdef" => "\\nYou cannot save until you have entered valid php code!",
"text_save" => "Your settings will be saved as my_config.php.\\nThis will overwrite the existing settings.\\nYou old settings are stored as my_config.php.bak.php.\\nDo you want to continue?",
"admin_semicolon" => "Semicolon is missing at line ",
"admin_missing" => "= is missing at line ",
"admin_line_start" => "Every line has to start with a parameter (\$...)\\nPlease check this line: ",
"admin_brackets" => "Brackets not closed in line: ",
"admin_brackets2" => "Unclosed elements in line: ",
"admin_bracketsx" => "Unclosed brackets in line: ",
"admin_anfzeichen" => "You cannot use backslash \\\" or \\\' in this field.\\nIf you save the config like this you can destroy your configuration! Please use a string without back slash or enter the parameter manually to the config",
"admin_number" => "Please enter a number in this field. If you leave it empty TWG does not work properly.",
"admin_0" => "0 is not valid in this field. Please correct your input",
"admin_nurnum" => "Only numbers are valid in this field.\\nIf you save the config like this you can destroy your configuration!",
"picker_save" => "Do you really want to save this style sheet?\\nYour existing my_style.css will be stored as \\nmy_style.css_&lt;timestamp&gt;.bak.\\nYou should delete the backups when you have found your layout!\\nPlease note: If you have selected a skin the setting for the skin will be removed because settings of a skin overwrite the settings you make in my_style.css!",
"picker_con" => "Connection could not be initialized.\\nPlease store the style sheet manually as my_style.css",
"no_error" => "The style sheet was saved as my_style.css.\\nA backup of your old style sheet was made!\\nYou can check your new colors by opening the gallery in a new window!",
"error_copy" => "Could not copy the old style sheet.\\nYour new style sheet was not saved.\\nPlease check the permissions of your TWG directory.",
"error_open" => "Could not open my_style.css.\\nYour new style sheet was not saved.\\nPlease check the permissions of your TWG directory.",
"error_store" => "Could not write to my_style.css.\\nYour new style sheet was not saved.\\nPlease check the permissions of your TWG directory.",
"error_close" => "Could not close my_style.css.\\nMost likely the my_style.css was written.\\nPlease check if the new stylesheet is active.",
"error_def" => "error",
"button_show" => "Show",
"button_trans" => "Transparent",
"showcells" => "Show cells",
"hidecells" => "Hide cells",
);

$GLOBALS["fsa_messages"] = array(
// do not translate the next line
"title" => "TFU File Split Applet",
"split_description" => "Please select the files you want to split and select the file size of the parts. The automatic selection shows the current upload limit of this server. Please do always upload all parts of one file in one upload with the TWG Upload Flash because otherwise they cannot be merged.",
"help_text1" => "The TFU file split applet is a small Java applet where you can split your files - which are too big to upload directly to the server because of the php upload limit -  into smaller pieces and store it back on your hard disk. You can then upload these pieces with TFU and they are merged in the backend. You need an installed Java >= 1.4 installed to use this applet. The applet needs access to your hard disk to read/write the files. This is only possible with a signed applet. If you open the applet you get a warning:",
// do not translate the next line
"help_warning" => "The application's digital signature is invalid. Do you want to run the application?",
"help_text2" => "This is because this is a <b>selfsigned</b> applet. If you want to verify that this is the original applet that comes from the TinyWebGallery website click %shere%s for instructions how to verify the signature.",
"help_limit" => "The upload limit on this server is",
"help_open" => "Open the TFU File Split Applet",
"help_time" => "(Opening the applet takes some time because Java has to be loaded first.)",
"split_setup" => "The file split capability of this server has not been tested yet. This has to be done to make sure that files bigger than the upload limit can be processed.<br/>&nbsp;<br/>Therefore the support for splitting files and uploading parts is disabled.<br/>If you don't like to enable this feature please set 'Enable support for splitted files' (admin_enable_split) to false.<br>&nbsp;<br>If you want to enable this featurs please read howto 42 for a step by step instruction how to enable this.<br>&nbsp;<br>For experienced users: set 'Enable support for splitted files' (admin_enable_split) and 'File split was tested on the server' (admin_file_split_is_tested) to true. The test is quite simple: Split a file bigger than your file upload limit, upload the parts and download (if possible) the merged file with e.g. the TWGXplorer or FTP - then check if the file is o.k."
);

// new 1.7.7
define("_C_VERSION_NO","TWG cannot check if there is a newer version available. Please go to");
define("_C_VERSION_NO2","once in a while and check if there are any important updates.");
define("_C_VERSION_OLD1","Updates are available for TWG. Please visit");
define("_C_VERSION_OLD3","Latest version: ");
define("_C_VERSION_OLD4","Your version: ");
define("_C_VERSION_OLD5","For the latest information on updates to TWG, why not subscribe to the RSS feed of our");
define("_C_VERSION_OLD6","blog");
define("_C_VERSION_OK","Your installation is up to date, no updates are available for your version of TWG.");
?>