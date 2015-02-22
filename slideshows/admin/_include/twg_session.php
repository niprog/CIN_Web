<?php

/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );

/*
* This are the variables I want to kepp after the upload!
*/
function resetSessionCache(){
	$session_vars = array('twg_ses','myborder','dhtml_nav',
's_user','s_pass','twg_latestlocation','actalbum','mywebgallerie_login','s_home_dir'
,'twg_permissions','twg_zoom','privategallogin','twg_lang','twg_root','twg_root_dir','browserx_res','_sbrowserx_res'
,'browsery_res','_sbrowsery_res','fontscale','twg_lowbandwidth','twg_XMLHTTP','1st_call','twg_download'
,'twg_nojs','TWG_AUTOHIDE','MENU_STATUS','tfu_upload_dir','TFU_LOGIN'
,'TFU_ROOT_DIR','TFU_DIR','TFU_BROWSE_FOLDER','TFU_CREATE_FOLDER','TFU_DELETE_FOLDER'
,'TFU_SORT_FILES_BY_DATE','user_msg','user_msg_counter','autoview','TFU_SORT_FILES_BY_DATE'
,'TFU_LAST_UPLOADS','checkcache','createCacheDirs','twg_ses_foffset','TFU_SPLIT_EXTENSION'
,'admin_lang','TFU_HIDE_DIRECTORY_IN_TITLE','upload_settings'
,'TFU_RN','TFU_NOT_EMAIL','TFU_NOT_EMAIL_FROM','TFU_NOT_EMAIL_SUBJECT','TFU_NOT_EMAIL_TEXT'
,'TFU_SPLIT_EXTENSION','TFU_USER','TFU_USE_IMAGE_MAGIC','TFU_IMAGE_MAGIC_PATH','TFU_KEEP_FILE_EXTENSION'
,'TFU_CHECK_SERVER_FILE_EXTENSIONS','TFU_FORBIDDEN_VIEW_FILE_EXTENSIONS','TFU_ALLOWED_VIEW_FILE_EXTENSIONS'
,'TFU_FORBIDDEN_FILE_EXTENSIONS','TFU_ALLOWED_FILE_EXTENSIONS','TFU_MAX_FILE_SIZE','TFU_SHOW_DELETE'
,'TFU_ENABLE_FILE_COPYMOVE','TFU_ENABLE_FOLDER_COPYMOVE','TFU_INFO','TFU_ENABLE_FILE_DOWNLOAD'
,'TFU_ENABLE_FOLDER_RENAME','TFU_ENABLE_FILE_RENAME', 'TFU_UPLOAD_REMAINING', 'xmlcache_xml_image_textxml', 'TFU_ENABLE_FOLDER_COPYMOVE');
		
	$session_store = array();

    foreach($session_vars as $keep){
		if (isset($_SESSION[$keep])) {
			$session_store[$keep] = $_SESSION[$keep];
		}
	}
	
	$_SESSION = array();
    foreach($session_store as $restore => $val){
		$_SESSION[$restore] = $val;
    }
}

?>