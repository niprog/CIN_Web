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

defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');

$flashtext = '<div id="flashcontent"><div class="noflash">The flash requires at least Flash 6.<br>Please get it <b><a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&promoid=BIOW" target="_blank">here<\/a><\/b>.<\/div><\/div>';

if ($responsive_detail_page && $video_player == "HTML5") {
$res_style = ' style = "width:100%; max-width: ' . $video_size_x . 'px;"';
} else {
$res_style = '';
}

echo "<table " . $res_style . $jscenter . "  summary='' border='0' cellpadding='0' align='center'><tr><td>";
if ($show_videos) {
    if ($video_player == "WMP") {
        echo "<span id='videoBox'>";
        $embedstring = $basedir . "/" . $twg_album . "/" . $image . ".wvx";
        // we create the playlist ... should work like a stream but without streaming server!
        if ($video_flash_site == "http://" || $video_flash_site == "mms://") {
            $embedstring = $video_flash_site . urldecode(removeExtension(replace_url_chars($image)));
        } else if ($linktowvx) {
            createWVX($embedstring, $twg_album, $image);
            $embedstring = fixUrl(getTWGHttpRoot() . $basedir . "/" . $twg_album . "/" . $image . ".wvx");
        } else {
            $embedstring = fixUrl(getTWGHttpRoot() . $basedir . "/" . $twg_album . "/" . getMovieName($twg_album, $image));
        }
        if ($video_autostart) {
            $as = "true";
        } else {
            $as = "false";
        }
        echo '<script type="text/javascript">';
        echo 'showWMP("' . $embedstring . '",' . $video_size_x . ',' . $video_size_y . ',"' . $as . '");';
        echo '</script>';
        echo "<noscript>";
        echo "<div class='noFlash'>Please enable Javascript to make the Windows Media Player plugin work properly!</div>";
        echo "</noscript>";
        //
        //  divx
        //
    } else if ($video_player == "DIVX") {
        $movie = fixUrl(getTWGHttpRoot() . twg_urlencode($basedir . "/" . $twg_album . "/" . getMovieName($twg_album, $image)));
        echo "<span id=videoDivx>";
        echo '<script type="text/javascript">';
        echo 'showDivx("' . $movie . '", ' . $video_size_x . ',' . $video_size_y . ');';
        if ($video_autostart) {
            // we press play with javascript !
            echo "window.setTimeout('startDivx()',500);";
        }
        echo '</script>';
        echo "<noscript>";
        echo '<object id="ie_plugin" classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616" width="' . $video_size_x . '" height="' . $video_size_y . '" ';
        echo ' codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">';
        if (!$video_autostart) {
            echo '<param name="autoPlay" value="false" >';
        }
        echo '
		<param name="src" value="' . $movie . '" >
			<embed id="np_plugin" type="video/divx" src="' . $movie . '"
			width="' . $video_size_x . '" height="' . $video_size_y . '" ';
        if (!$video_autostart) {
            echo ' autoPlay="false" ';
        }
        echo ' pluginspage="http://go.divx.com/plugin/download/">
	</embed>
	</object>';
        echo "</noscript>";
        //
        // flash
        //
    } else if ($video_player == "FLASH") {
        echo "<span id=videoFlash>"; // vaFm47lsL2g
        $movie = $video_flash_site . twg_urlencode(removePrefix(removeExtension(urldecode($image), "")));
        $moviejs = $video_flash_site . urldecode(removePrefix(removeExtension($image, "")));
        if ($video_autostart) {
            $movie .= htmlentities($video_autostart_parameter, ENT_QUOTES, $charset);
            $moviejs .= $video_autostart_parameter;
        }
        // swfobjects!
        echo '
				<script type="text/javascript">
					 document.write(\'' . $flashtext . '\');
					 var so = new SWFObject("' . $moviejs . '", "ie_plugin", "' . $video_size_x . '", "' . $video_size_y . '", "8");
					 so.addParam("wmode","transparent");
					 so.addParam("allowFullscreen","true");
					 so.write("flashcontent");
			  </script>';
        // noscript way
        echo '<noscript><object id="ie_plugin"  width="' . $video_size_x . '" height="' . $video_size_y . '"><param name="movie" value="' . $movie . '">
	<embed id="np_plugin" src="' . $movie . '" type="application/x-shockwave-flash" width="' . $video_size_x . '"
	height="' . $video_size_y . '"></embed></object></noscript>';
   
    //
    // iframe - new by e.g. yourtube
    //  
    } else if ($video_player == "IFRAME") {
       echo "<span id=videoIframe>"; // vaFm47lsL2g
        $movie = $video_flash_site . twg_urlencode(removePrefix(removeExtension(urldecode($image), "")));
        if ($video_autostart) {
            $movie .= htmlentities($video_autostart_parameter, ENT_QUOTES, $charset);
        }
        echo '
            <iframe width="' . $video_size_x . '" height="' . $video_size_y . '" 
            src="' . $movie . '" style="border: none" allowfullscreen></iframe>
        ';
        //
        // Google
        //
    } else if ($video_player == "GOOGLE") {
        $movie = $video_flash_site . twg_urlencode(removePrefix(removeExtension($image, "")));
        $auto_param = "";
        if ($video_autostart) {
            $auto_param = "&autoPlay=true";
        }
        echo "<span id=videoGoogle>";
        // swfobjects!
        echo '
		<script type="text/javascript">
			 document.write(\'' . $flashtext . '\');
			 var so = new SWFObject("' . $movie . '", "VideoPlayback", "' . $video_size_x . '", "' . $video_size_y . '", "8");
			 so.addParam("scale","noScale");
			 so.addParam("wmode","transparent");
			 so.addParam("allowFullscreen","true");
			 so.addParam("salign","TL");
			 so.addParam("FlashVars","playerMode=embedded' . $auto_param . '");
			 so.write("flashcontent");
	  </script>';
        // noscript way
        $auto_param = str_replace("&", "&amp;", $auto_param); // to make it w3c conform!
        echo '
		<noscript>
	<embed style="width:' . $video_size_x . 'px; height:' . $video_size_y . 'px;" id="VideoPlayback" align="middle"
	type="application/x-shockwave-flash" src="' . $movie . '" allowScriptAccess="sameDomain"
	quality="best" bgcolor="#ffffff" scale="noScale" wmode="transparent" salign="TL"
	FlashVars="playerMode=embedded' . $auto_param . '"></embed>
	</noscript>
	';
        //
        //  mp3
        //
    } else if ($video_player == "MP3") {
        // creation of $player is is in image.inc.php!
        if (!file_exists($install_dir . 'twg_audiolist.php')) {
            echo "<center><p>The file 'twg_audiolist.php' was not found!.<br>If you use php include you have to manually configure the mp3 player<br>Please read howto 34 how to do this!</p></center>";
        }
        echo '<div class="mp3top" ></div>';
        echo "<span id='videoMP3'>";
        // swfobjects!
        echo '
		  <script type="text/javascript">
		     document.write(\'' . $flashtext . '\');
	       var so = new SWFObject("' . $playerjs . '", "movie", "380", "100", "6");
	       so.addParam("wmode", "transparent");
			   so.write("flashcontent");
	    </script>';
        // the noscript part!
        echo '<noscript><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" id="fsmp3playerv15" width="380" height="100" align="middle">
			<param name="movie" value="' . $player . '" ><param name="quality" value="high" ><PARAM NAME=wmode VALUE=transparent><embed src="' . $player . '" quality="high" wmode="transparent" width="380" height="100" name="fsmp3playerv15" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" >
			</object></noscript>';
    } else if ($video_player == "FLV") {
        if (!isset($video_flv_buffer)) { // new variable and therefore not set be older implementations.
            $video_flv_buffer = 2;
        }
        if (!isset($video_flv_stretching)) { // new variable and therefore not set be older implementations.
            $video_flv_stretching = "uniform";
        }

        $video_autostart_str = ($video_autostart) ? "true" : "false";
        $movie = $install_dir_view . "html/mediaplayer.swf";
        $filedir = substr($basedir, strlen($install_dir));
        $url = twg_urlencode(fixUrl(getTWGHttpRoot() . $filedir . "/" . $twg_album . "/" . getMovieName($twg_album, $image)));
        $video_player = "DIVX"; // need to switch to DIVX because then getTWGHttpRoot returns the full url with is needed that the image is displayed properly if autostart is off.
        $preview = (fixUrl(getTWGHttpRoot() . $filedir . "/" . $twg_album . "/" . $image));
        $video_player = "FLV";
        echo "<span id=videoFLV>";
        echo '
		<script type="text/javascript">
			 document.write(\'' . $flashtext . '\');
			 var so = new SWFObject("' . $movie . '", "VideoPlayback", "' . $video_size_x . '", "' . $video_size_y . '", "8");
			 so.addParam("allowfullscreen","true");
       so.addParam("allowscriptaccess","sameDomain"); 
       so.addVariable("type", "video");
       so.addVariable("file","' . $url . '"); 
       so.addVariable("image","' . $preview . '");
       so.addVariable("autostart","' . $video_autostart_str . '");
       so.addVariable("bufferlength","' . $video_flv_buffer . '");
       so.addVariable("stretching", "' . $video_flv_stretching . '");
    ';
        if ($show_flv_player_below_iframe) {
            echo 'so.addParam("wmode","transparent");';
        } else {
            echo 'so.addParam("wmode","opaque");';
        }
        echo'
			  setTimeout("so.write(\'flashcontent\');",1);
	  </script>';
        // noscript way - the parameters need to be connected
        $file = "?file=" . $url;
        $auto_param = "&amp;autostart=" . $video_autostart_str;
        $auto_param .= "&amp;bufferlength=" . $video_flv_buffer;
        $auto_param .= "&amp;image=html/" . $preview;
        echo '
		<noscript>	
	<embed style="width:' . $video_size_x . 'px; height:' . $video_size_y . 'px;" id="VideoPlayback" align="middle"
	   type="application/x-shockwave-flash" src="' . $movie . $file . '" allowScriptAccess="sameDomain"
	   quality="best" bgcolor="#ffffff" scale="noScale" wmode="window" salign="TL"
	   FlashVars="showfsbutton=true&amp;playerMode=embedded&amp;fullscreenpage=html/fullscreen.html' . $auto_param . '"></embed>
	  </noscript>
	';
    } else if ($video_player == "FLV3") { // old Player that works from Flash 6 on!
        $movie = $install_dir . "html/mediaplayer3.swf?";

        $filedir = substr($basedir, strlen($install_dir));
        $file = "file=" . twg_urlencode(fixUrl(getTWGHttpRoot() . $filedir . "/" . $twg_album . "/" . getMovieName($twg_album, $image)));
        $auto_param = ($video_autostart) ? "autostart=true" : "autostart=false";

        echo "<span id=videoFLV>";
        // swfobjects!
        echo '
		<script type="text/javascript">
			 document.write(\'' . $flashtext . '\');
			 var so = new SWFObject("' . $movie . $file . '", "VideoPlayback", "' . $video_size_x . '", "' . $video_size_y . '", "6");
			 so.addParam("FlashVars","' . $auto_param . '&height=' . $video_size_y . '&width=' . $video_size_x . '");
       so.addParam("allowfullscreen","true");
       so.addParam("overstretch","true");';
        if ($show_flv_player_below_iframe) {
            echo 'so.addParam("wmode","transparent");';
        }
        echo'
			 setTimeout("so.write(\'flashcontent\');",1);
	  </script>';
        // noscript way
        $auto_param = str_replace("&", "&amp;", $auto_param); // to make it w3c conform!
        echo '
		<noscript>	
	<embed style="width:' . $video_size_x . 'px; height:' . $video_size_y . 'px;" id="VideoPlayback" align="middle"
	type="application/x-shockwave-flash" src="' . $movie . $file . '" allowScriptAccess="sameDomain"
	quality="best" bgcolor="#ffffff" scale="noScale" wmode="window" salign="TL"
	FlashVars="showfsbutton=true&amp;playerMode=embedded&amp;fullscreenpage=html/fullscreen.html' . $auto_param . '"></embed>
	</noscript>
	';
    } else if ($video_player == "QT") {
        $movie = getTWGHttpRoot() . twg_urlencode($basedir . "/" . $twg_album . "/" . getMovieName($twg_album, $image));
        if ($video_autostart) {
            $auto_param = "true";
        } else {
            $auto_param = "false";
        }
        echo "<span id=videoQT>";
        echo '<script type="text/javascript">';
        echo "QT_WriteOBJECT('" . $movie . "', '" . $video_size_x . "', '" . $video_size_y . "','','class','transparent','controller','true','autoplay','" . $auto_param . "');";
        // echo 'showDivx("' . $movie . '", ' . $video_size_x . ',' . $video_size_y . ');';
        echo '</script>';
        echo '<noscript><br><span class="noflash">Please activate Javascript. The Quicktime plugin does not work otherwise.</span><br>&nbsp;<br></noscript>';
   
   
     } else if ($video_player == "HTML5") {
        if ($video_autostart) {
            $auto_param = "&amp;autostart=true";
        } else {
            $auto_param = "";
        }
        $ratio = (floor ($video_size_y / $video_size_x * 10000)) / 100;
        if ($responsive_detail_page) {
          echo '<style>';
          echo '.video-container { position: relative; padding-bottom: '.$ratio.'%; padding-top: 0px; height: 0; overflow: hidden; } .video-container iframe, .video-container object, .video-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }'; 
          echo '</style>';
        }
        echo '<div id=videoHtml5 class="video-container">';
        if ($responsive_detail_page) {
          echo '<iframe src="'.$install_dir_view . 'i_frames/i_html5video.php?twg_album=' . $album_enc . $auto_param . "&amp;twg_show=" . $image_enc . '" frameborder=0 allowfullscreen transparency="true"></iframe>';
        } else {
          echo '<iframe width=' . $video_size_x . ' height=' . $video_size_y . ' src="'.$install_dir_view . 'i_frames/i_html5video.php?twg_album=' . $album_enc . $auto_param . "&amp;twg_show=" . $image_enc . '" frameborder=0 allowfullscreen transparency="true"></iframe>';
        } 
        echo '</div>';
  
    } else {
        echo "<span>";
        echo "Wrong entry '" . $video_player . "' in config - check \$video_player";
    }
    echo "</span>";
} else {
    echo $lang_video_disabled;
}
echo "</td></tr></table>";

if ($enable_download && $video_show_dl_link && ($video_player != "GOOGLE")) {
    echo "<center id='center-download-link'><div class='dllink'>" . $download1 . $lang_download . $download2 . "</div></center>";
}

?>