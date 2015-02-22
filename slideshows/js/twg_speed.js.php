<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javaScript">
connectionSpeed = 0;

function computeConnectionSpeed( start, fileSize ) {
	// This function returns the speed in kbps of the user's connection,
	// based upon the loading of a single image.  It is called via onload
	// by the image drawn by drawCSImageTag() and is not meant to be called
	// in any other way.  You shouldn't ever need to call it explicitly.

	end = (new Date()).getTime();
	speed = (Math.floor((((fileSize * 8) / ((end - start) / 1000)) / 1024) * 10) / 10);
	
	
		newurl = "<?php echo getScriptName();
	
	?>" + location.search;
		if (newurl == "<?php echo getScriptName();
	
	?>") {
		   newurl += "?";
		} else {
		   newurl += "&";
		}
		if (speed) {
			if (speed < <?php echo $bandwidth_limit;
	
	?>) {
	      // we set the limit a couple of time because sometimes it does not work!
		    setLow(); 
		    window.setTimeout("setLow()", 1000);
		    return;
		   }
		  
		   		if (speed > <?php echo $bandwidth_limit_high; ?>) {
			 		  setVeryHigh(); 
			 		  window.setTimeout("setVeryHigh()", 1000);   
		        return;
		     }   
		}
		    setHigh();
		    window.setTimeout("setHigh()", 1000);	    	
}
  
function setLow() {
  if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
	if (!myConnB) return; // if this is not available we use 490 as max. height and 930 as max. width;
  var fnWhenDoneR = function (oXML) {};
   myConnB.connect(newurl + "twg_lowbandwidth=true&twg_session=true", fnWhenDoneR ); 		
}

function setHigh() {
  if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
	if (!myConnB) return; // if this is not available we use 490 as max. height and 930 as max. width;
  var fnWhenDoneR = function (oXML) {};
  myConnB.connect( newurl + "twg_highbandwidth=true&twg_session=true", fnWhenDoneR);
}

function setVeryHigh() {
  if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
	if (!myConnB) return; // if this is not available we use 490 as max. height and 930 as max. width;
  var fnWhenDoneR = function (oXML) {};
  myConnB.connect( newurl + "twg_highbandwidth=high&twg_session=true", fnWhenDoneR);
}

function drawCSImageTag( fileLocation, fileSize, imgTagProperties ) {
	start = (new Date()).getTime();
	var loc = fileLocation + '?t=' + escape(start);
	// Append the Start time to the image url to ensure the image is not in disk cache.
	var imageTag = '<i'+'mg s'+'rc="' + loc + '" ' + imgTagProperties + ' onload="connectionSpeed=computeConnectionSpeed(' + start + ',' + fileSize + ');">';
  document.write('<div style="visibility:hidden; position:absolute; z-index:3;">'+ imageTag +'<\/div>');
	return;
}

function startSpeedTest() {
  drawCSImageTag( '<?php echo $install_dir_view ?>buttons/speed.jpg',                        // Image filename
                  15000,                                  	  // Image size
                  'border=1 height=200 alt="test"');   // <img> tag attributes
}
startSpeedTest();
</script>