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

defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
?>
<?php
show_twg_header();
?>
<div id="ctr" align="center"></div>
<div class="install round_borders">
<div id="step"><?php
  echo $GLOBALS["main_messages"]["welcometotwg"];
?></div>
<div class="clr"></div>

<?php
echo $GLOBALS["main_messages"]["entrytext"];
?>
	<!-- Facebook like button -->	  
  <br/>
  <p>	 
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
 <div class="fb-like-box" data-href="http://www.facebook.com/tinywebgallery" data-width="750" data-border-color="lightgrey" data-show-faces="false" data-stream="true" data-header="false"></div>
	</p>
	<br/>
	<!-- end Facebook like button -->	

<h1>TWGXplorer</h1>
<div class="install-text">
<?php
  echo $GLOBALS["main_messages"]["xplorertext"];
?>
<div class="ctr"></div>
</div>
<div class="install-form">
<div class="form-block">
<table summary="" class="content">
<tr>
	<td >
<ul>
<?php
  echo $GLOBALS["main_messages"]["xploreritems"];
?>
</ul>
</td>
</tr>
</table>
</div>
</div>
<div class="clr"></div>
<h1><?php
  echo $GLOBALS["main_messages"]["info"];
?></h1>
<div class="install-full">
<?php
  echo $GLOBALS["main_messages"]["infotext"];
?>
<div class="ctr"></div>
</div>
<div class="clr"></div>
<h1><?php
  echo $GLOBALS["main_messages"]["helper"];
?></h1>
<div class="install-full">
<?php
  echo $GLOBALS["main_messages"]["helpertext"];
?>
<div class="ctr"></div>
</div>
<div class="clr"></div>
<h1><?php
  echo $GLOBALS["main_messages"]["color"];
?></h1>
<div class="install-full">
<?php
  echo $GLOBALS["main_messages"]["colortext"];
?>
</div>
<div class="clr"></div>
<h1><?php
  echo $GLOBALS["main_messages"]["email"];
?></h1>
<div class="install-full">
<?php
  echo $GLOBALS["main_messages"]["emailtext"];
?>
</div>
<div class="clr"></div>
<h1><?php
  echo $GLOBALS["main_messages"]["user"];
?></h1>
<div class="install-full">
<?php
  echo $GLOBALS["main_messages"]["usertext"];
?>
</div>
<div class="clr"></div>
</div>