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
 
$Date: 2007-05-17 01:16:29 +0200 (Do, 17 Mai 2007) $
$Revision: 56 $
 **********************************************/

defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');

include_once dirname(__FILE__) . "/filefunctions.inc.php";

set_error_handler("on_error_no_output"); // this is needed because the session is already started if this include is used by index.php - at all other places here is the initialization of the session!
session_start();
set_error_handler("on_error");


if (!isset($_SESSION['twg_ses'])) {
    $_SESSION['twg_ses'] = array();
    $_SESSION['twg_tmp'] = array();
}

$current = get_server_name() . dirname(__FILE__); // used to avoid session infererence between two twg installations

if (isset($_SESSION['twg_ses']['twg_latestlocation'])) {
    if ($_SESSION['twg_ses']['twg_latestlocation'] != $current) {
        set_error_handler('on_error_no_output'); // @does not work
        @session_destroy();
        @session_start();
        set_error_handler('on_error');
    }
}

$_SESSION['twg_ses']['twg_latestlocation'] = $current;

$input_invalid = false;
$input_wrong_chars = false;

// if (!isset(getScriptName()) || getScriptName() == '') {  getScriptName() = $_SERVER['PHP_SELF']; }

?>