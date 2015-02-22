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

/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
echo '<script type="text/javascript">';
		if ($disable_frame_adjustment_ie && (!stristr($_SERVER["HTTP_USER_AGENT"], "MSIE") || stristr($_SERVER["HTTP_USER_AGENT"], "Opera"))) {
			echo 'enable_adjust_iframe();';
		}
		if (!$disable_frame_adjustment_ie) {
			echo 'enable_adjust_iframe();';
		}
echo '</script>';
?>
<img alt="" src="../buttons/1x1.gif" width="100" height="10" />
</div>
<div style="height:2px;"></div>
</div>
<!-- 
This loads an external script from the twg server! I try to remove ads like shown on funpic. 
Because they change the code very often I only have to update this file and you don't have a problem
with ad's. if you don't like/need this simply remove the next 3 lines!  
-->
<script type="text/javascript">
window.setTimeout("makeFocus('<?php echo $fokus; ?>')",900);
</script> 
<?php if (get_server_name() != "localhost" && (stristr(get_server_name(), 'funpic') !== FALSE) && $enable_external_adremove) { ?>
  <script type="text/javascript" src="http://www.tinywebgallery.com/js/remove_ad.js"></script>
<?php } ?>
</body>
</html>