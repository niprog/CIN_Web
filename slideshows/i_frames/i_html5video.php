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

define( '_VALID_TWG', '42' ); 
include "i_basic.inc.php";

$configphp = $basedir . "/" . $twg_album . "/config.php";
	if (file_exists($configphp)){
			include $configphp;
}
$configphp_lang = $basedir . "/" . $twg_album . "/config_".$default_language.".php";
if (file_exists($configphp_lang)){
  include $configphp_lang;
}

if ($twg_root == $install_dir . "../index.php") { // this is the default and wrong for the slideshow !
$twg_root = $install_dir . "index.php";
}


require '../language/language_default.php';
require '../language/language_' . $default_language . '.php';
if (isset($charset)) {
  header("Content-Type: text/html;charset=" . $charset);
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title></title>
    <!-- Load player theme -->
    <link rel="stylesheet" href="../css/projekktor-theme/projekktor.style.css" type="text/css" media="screen" />
    <script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../js/projekktor-1.3.09.min.js"></script>

<style>
html, body {height: 100%; width: 100%;}
</style>
</head>
<body>
    
    
    <?php
     $preview = getTWGHttpRoot() . twg_urlencode($basedir . "/" . $twg_album . "/" . utf8_encode($image));
     $movies = array_reverse (getHtml5MovieNames($twg_album, $image));
     // print_r($movies);
if ($twg_album) {
    $videofilename = ($basedir . "/" . $twg_album . "/video.php");
} else {
    $videofilename = ($basedir . "/video.php");
}


$autoplay = "";
if (isset($_GET['autostart'])) {
    $autoplay = "autoplay:true,";
}

// we check videostreaming
if (file_exists($videofilename)) { 
    include $videofilename;
} 
    //  $video_size_x = "100%";
    //  $video_size_y = "100%";
      
     echo '
         <span id=videoHtml5 style="width:100%;height:100%">
        
         <video id="player_a" '.$auto_param.' class="projekktor" controls style="width:100%;height:100%"
           width="100%" height="100%"
          poster="'. $preview . '">';
      
       foreach ($movies as $movie) {    
         $extension = getExtension($movie);
         if ($extension == 'ogv') { 
             $extension == 'ogg';   
         }
         if ($video_flash_site != "") {
             $moviePath = $video_flash_site . twg_urlencode(utf8_encode($movie));
         } else {
             $moviePath = getTWGHttpRoot() . twg_urlencode($basedir . "/" . $twg_album . "/" . utf8_encode($movie));
         }
         echo '<source src="'.$moviePath.'" type="video/'.$extension.'" />';
       }  
               
       echo '</video>   
        </span>';  
    ?>

    <script type="text/javascript">
    $(document).ready(function() {
        projekktor('#player_a', {
        <?php echo $autoplay; ?>
        playerFlashMP4: '../html/StrobeMediaPlayback.swf'
        }, function(player) {} // on ready 
        );
    });
    </script>  
</body>
</html>