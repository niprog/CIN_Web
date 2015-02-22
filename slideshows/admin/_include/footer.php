<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is footer.php, released on 2003-01-25.

     The Initial Developer of the Original Code is The QuiX project.

     Alternatively, the contents of this file may be used under the terms
     of the GNU General Public License Version 2 or later (the "GPL"), in
     which case the provisions of the GPL are applicable instead of
     those above. If you wish to allow use of your version of this file only
     under the terms of the GPL and not to allow others to use
     your version of this file under the MPL, indicate your decision by
     deleting  the provisions above and replace  them with the notice and
     other provisions required by the GPL.  If you do not delete
     the provisions above, a recipient may use your version of this file
     under either the MPL or the GPL."
------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------
Author: The QuiX project
	quix@free.fr
	http://www.quix.tk
	http://quixplorer.sourceforge.net

Comment:
	QuiXplorer Version 2.3
	Footer File

	Have Fun...

This file was modified by the TinyWebgallery project to work as backend for
TinyWebgallery.
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
/*

This function does show a small add from google to support TWG.
You are not allowed to remove this code - If you don't like this
please contact me if you like an add free backend!

        //
		    // This script is completely free for private AND commercial use as long as
		    // the ad's in the backend is not removed!
		    // If you want to remove it you have to register TWG
		    //
		    // Please go to the web site http://www.tinywebgallery.com for more details.
		    //    - Thank you!
        //

*/
function show_footer() {			// footer for html-page
global $d;
global $menu_printed;

  echo "<center><br>";

 if (get_server_name() != "localhost") {
		 if (!$d) { // if you have a licence file you can turn the ad's off by changing this to false!
		    echo "&nbsp;<iframe src='http://www.tinywebgallery.com/gadmin/ad_leaderboard151.htm' style='width:740px;height:110px;overflow:hidden;' scrolling=no frameborder=0 id='g'></iframe><span id='h'>&nbsp;</span>";
        echo "<br>&nbsp;";
     }
	}
	echo "</center>";


  if ($menu_printed) {
    echo "</td></tr></table>";
  }
}
//------------------------------------------------------------------------------
function show_twg_footer() {			// footer for html-page

  echo '
  <div class="ctr">
		TWG Admin ' . $GLOBALS["twg_admin_version"] . ' - <a href="' . $GLOBALS["twg_home_url"] . '" target="_blank">Copyright (c) 2004-2014 TinyWebGallery</a>.
  ';

   if ($GLOBALS["action"] == "list") {
		echo "<br><small>TWGXplorer is based on joomlaXplorer 1.2</small>";
   }
   echo '</div>';

}


/*

This function does show a small add from google to support TWG.
You are not allowed to remove this code - If you don't like this
please contact me if you like an add free backend!

*/
function show_twg_header() {
global $d;
global $debug_file;

if (file_exists($debug_file)) {
  if (filesize($debug_file) > 10000) {
    echo "<center><br/><span class=error>". $GLOBALS["error_msg"]["error_debug_empty"] ."</span></center>";
  }
}

if (get_server_name() != "localhost") {
  echo'<br><div class="ctr">';
  if (!$d) { // if you have a licence file you can turn the ad's off by changing this to false!
		 echo "<iframe marginheight='0' marginwidth='0'  src='http://www.tinywebgallery.com/gadmin/ad_link.htm' style='margin:0px;padding:0px;width:740px;height:15px;overflow:hidden;' scrolling=no frameborder=0 ></iframe>";
  }
  echo '</div>';
}
}
?>