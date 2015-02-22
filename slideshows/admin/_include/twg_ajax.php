<?php

/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );

function setAjaxParameters() {
  if(isset($GLOBALS['__POST']['menustatus'])) {  
     if ($GLOBALS['__POST']['menustatus'] == 'true') {
       $_SESSION['MENU_STATUS'] = 'HIDE';
     } else {
       $_SESSION['MENU_STATUS'] = 'SHOW';
     }
  }
}
?>