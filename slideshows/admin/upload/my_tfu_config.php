<?php
/**
 * Copyright (c) 2004-2012 TinyWebGallery
 * written by Michael Dempfle
 * 
 *  This is the config file where all the TFU stuff from the wrapper is set.
 *  
 *  The commented settings cannot be set by the backend - if you want to set them you 
 *  have to uncomment it an set it    
 * 
 *   Have fun using TWG
 */
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );

@ob_start(); // we don't show any errors user made in the config twg
include realpath(dirname(__FILE__) . '/../../config.php'); // twg config!
include_once dirname(__FILE__) . "/twg_helper.php"; 
@ob_end_clean();

if (isset($_SESSION['TFU_LOGIN']) && (isset($_SESSION['tfu_upload_dir'])) && isset($_POST['twg_rn'])) { // set in TWG Admin!
   $login = 'true';
} else {
   $login = 'false';  
}
if (isset($_SESSION['tfu_upload_dir'])) {
    // we get the current user - should be in the session!
      $user = $_SESSION['s_user'];
      $folder = $_SESSION['tfu_upload_dir'];
      if ($folder == '') {
       $folder = '.';
     }
    
    $setting_del = 'false';
    $setting_dir = 'false';
    $setting_edit = 'false';
    
    if (isset($_SESSION['upload_settings'])) {
      if($_SESSION['upload_settings'] > 0) {
    		if  ((($_SESSION['upload_settings']&2)==2)) {
    			$setting_del = 'true';
    		}
    		 if  ((($_SESSION['upload_settings']&4)==4)) {
    				$setting_edit = 'true';
    		}
    		 if  ((($_SESSION['upload_settings']&8)==8)) {
    				$setting_dir = 'true';
    		}
      }
    }
 
    $hide_hidden_files = false;
    if (isset($_SESSION["TFU_HIDE_HIDDEN_FILES"]) && $_SESSION["TFU_HIDE_HIDDEN_FILES"] == 0) {
       $hide_hidden_files = true;
    }
    
    /*
        TFU CONFIGURATION
    */
    
    $resize_data = "100000,1400,1280,1024,800,640," . $small_pic_size;
    $resize_label = "Original,1400,1280,1024,800,640,TWG (" . $small_pic_size . ")";
    $show_delete=$setting_del;             // Shows the delete button
    $enable_folder_creation=$setting_dir;  // Show the menu item to create folders
    $enable_folder_deletion=$setting_dir;  // Show the menu item to delete folders - this works recursive!
    $enable_folder_rename=$setting_dir;    // Show the menu item to rename folders
    $enable_file_rename=$setting_dir;      // Show the menu item to rename files
    $enable_folder_move=$setting_dir;                // New 2.6 - Show the menu item to move folders 
    $enable_file_copymove=$setting_dir;              // New 2.6 - Show the menu item to move and copy files
    $base_dir = $install_path;    // this is the base dir of the other files - tfu_read_Dir, tfu_file and the lang folder. since 2.6 there are no seperate settings for tfu_readDir and tfu_file anymore because it's actually not needed.
    $split_extension = ($admin_enable_split && $admin_file_split_is_tested) ? "part" : "FALSE"; 	
    $hide_help_button=$admin_hide_help_button;                  // since TFU 2.5 it is possible to turn off the ? (no extra flash like before is needed anymore!) - it is triggered now by the license file! personal licenses, source code licenses and licenses that contain a TWG_NO_ABOUT in the domain (=license for €20) enable that this switch is read - possible settings are "true" and "false" 
    $forbidden_file_extensions=$admin_forbidden_file_extensions; // Forbidden file extensions! - only usefull if you use "all" and you want to skip some exensions!
    if ($setting_edit == "true") {
        $preview_textfile_extensions = "out,log,php"; // This are the files that are previewed in the flash as textfiles. Right now I only have "save" extensions. But you can have any extension here. If you don't use a . this settings are extensions. But you can restrict is to single files as well by using the full name. e.g. foldername.txt. * is supported as wildcard! Only available for registered users.
        $edit_textfile_extensions = $admin_user_edit_textfile_extensions; // This are the files that can be edited in the flash in the backend. But you can restrict is to single files as well by using the full name. e.g. foldername.txt. * is supported as wildcard! Only available for registered users.
        $enable_file_creation = 'true';      // New 2.14 - Show the menu item to create files - only available for registered users.
        $enable_file_creation_extensions = 'edit'; // New 2.14 - (edit,txt,all) You can define which files can be created. '
    }  else {
        $preview_textfile_extensions = '';
        $edit_textfile_extensions = '';
        $enable_file_creation = 'false';
    }  

    $check_image_magic = $admin_enable_cmd_checks;
              
    // here we set the delta for the frontend
    if (isset($_SESSION["TFU_LOGIN_FRONTEND"])) {
      $allowed_file_extensions = $admin_user_allowed_file_extensions; // Allowed file extensions! jpg,jpeg,gif,png are allowed by default. "all" allowes all types - this list is the supported files in the browse dropdown!
      if ($setting_edit == "true") {
        $edit_textfile_extensions = $user_edit_textfile_extensions; // This are the files that can be edited in the flash in the backend. But you can restrict is to single files as well by using the full name. e.g. foldername.txt. * is supported as wildcard! Only available for registered users
        $enable_file_creation = 'true'; 
        if ($setting_dir == 'true') {
          $enable_file_creation_extensions = 'edit'; 
        } else {
          $enable_file_creation_extensions = 'txt'; 
        }
      }
      $truncate_dir_in_title = 'true';
    } else { // settings for the admin
      $folder = '../..' . $folder;
      $allowed_file_extensions = $admin_allowed_file_extensions; // Allowed file extensions! jpg,jpeg,gif,png are allowed by default. "all" allowes all types - this list is the supported files in the browse dropdown!
      if ($setting_edit == "true") {
        $edit_textfile_extensions = $admin_user_edit_textfile_extensions; // This are the files that can be edited in the flash in the backend. But you can restrict is to single files as well by using the full name. e.g. foldername.txt. * is supported as wildcard! Only available for registered users.
      }
       if ($setting_dir == 'true') {
          $enable_file_creation_extensions = 'all'; 
        } else {
          $enable_file_creation_extensions = 'edit'; 
        }
    }
    
    $exclude_directories[] = 'folder.id';
    $has_post_processing = 'true'; // Because we generate thumbs and detail images by default and maybe convert images.
    
    // new 1.8.9
    $description_mode = $enter_caption_at_upload; 
    $description_mode_show_default = 'false';
    
    
    // new 2.0 
    $fix_utf8 = $filesystem_encoding;
    $zip_folder = $folder; // has to be set again!  

    // new TWG 2.0 - I keep the session cache folder by default because many users do not find this setting
    // and it does not really hurt if needed.
    $keep_internal_session_handling = true;
} 
?>