// TWG version 1.9
<!-- default keysettings ! are overritten most of the time ! -->
function centerGalLater() { }
function key_foreward() { }
function key_back() { }
function key_up() { }
function setTimer(time) { }
function setPos(xx) {} // dummy if bignav is not visible!
var openpopuplink = "";

// some 
var twg_settings = new Array();
twg_settings[0] = new Object();
var twg_addon_callbacks = new Array();
var myConnB = null;

// var myeffectHeight;

window.onload = function()
{
  if (window.fillup) {
  	fillup();
  } 
  set_tree_height();
  // myeffectHeight = new fx.Height('detailsdiv', {duration: 400});
  
  if (window.hide_twg)
    // we position a couple of times because I don't know if funpic changes the timeouts once in a while ;).
    hide_twg(1);
    window.setTimeout("hide_twg(2);",1000);
    window.setTimeout("hide_twg(10);",10000); 
    window.setTimeout("hide_twg(13);",12000);
}


<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=(arguments ? arguments : MM_preloadImages.arguments); for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image();d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

var scalling = 1;

function setScalling() {
if ((document.createElement) && (document.createTextNode))
	{
		document.writeln('<div id="emsTest" style="position:absolute; left:200px; top:200px; visibility:hidden; font-family:arial,helvetica,sans-serif">A&nbsp;<br />A&nbsp;<br />A&nbsp;<br />A&nbsp;<br />A&nbsp;<br /></div>');
		var h=9999;
		if (document.getElementById('emsTest').clientHeight) h=parseInt(document.getElementById('emsTest').clientHeight);
		else if (document.getElementById('emsTest').offsetHeight) h=parseInt(document.getElementById('emsTest').offsetHeight);
		if (h == 9999) {
		   scalling = 1;
		} else {
		  if (h > 100) scalling = ((h - 100)/200) + 1;
		  if (scalling >= 1.3) {
		    scalling = scalling * 1.12;
		  }
    }
	}
}

function send_Browser_resolution(included, path, sa) {
if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
if (!myConnB) return; // if this is not available we use 490 as max. height and 930 as max. width;
var fnWhenDoneR = function (oXML) {};

var y = 0, x = 0;

	if( typeof( window.innerWidth ) == 'number' ) {
		x = window.innerWidth; y = window.innerHeight;
	} else if( document.documentElement && ( document.documentElement.clientWidth ||document.documentElement.clientHeight ) ) {
		x = document.documentElement.clientWidth; y = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		x = document.body.clientWidth; y = document.body.clientHeight;
	}

if (included == 'yes') {
  // xx = findPosX(document.getElementById("cornerpixel")) -  findPosX(document.getElementById("counterpixel")) + 20;
  // yy = findPosY(document.getElementById("counterpixel")) - findPosY(document.getElementById("cornerpixel")) +20;
  x = document.getElementById('content_table').offsetWidth+40;
	y = document.getElementById('content_table').offsetHeight;
}

var orientation = window.orientation;
if (sa == "") {
myConnB.connect( path + "image.php?twg_browserx=" + Math.round(x) + "&twg_browsery=" + Math.round(y) + "&twg_orientation="+orientation+"&fontscale=" + scalling + "&twg_xmlhttp=r", fnWhenDoneR);
} else {
myConnB.connect( path + "image.php?twg_standalone=true&twg_browserx=" + Math.round(x) + "&twg_browsery=" + Math.round(y) + "&twg_orientation="+orientation+ "&fontscale=" + scalling + "&twg_xmlhttp=r", fnWhenDoneR);
}
a__();
return Math.round(x) + "" + Math.round(y);
}

function pre_cache_xml_js(path,sa) {
if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
if (!myConnB) return; // if this is not available we use 490 as max. height and 930 as max. width;
var fnWhenDoneP = function (oXML) {};
if (sa == "") {
  myConnB.connect( path + "image.php?twg_precachexml=true", fnWhenDoneP);
}else {
  myConnB.connect( path + "image.php?twg_precachexml=true&twg_standalone=true", fnWhenDoneP);  
}
}

function send_stat(ref) {
jsinfo = "http://www.tinywebgallery.com/stat/stat.php?ref=" + ref;
try { 
  var script = document.createElementNS('http://www.w3.org/1999/xhtml','script');
  script.setAttribute('type', 'text/javascript');
  script.setAttribute('src', jsinfo);
  document.getElementsByTagName('body')[0].appendChild(script);
} catch(e) {
  str = "<script type=\"text/javascript\" src=\""+jsinfo+"\"></script>"
  document.write(str+""); }
}

function ShrinkToFit(id, width, height)
{
  var OriginalWidth = 0, OriginalHeight = 0;
  var bild = document.getElementById(id);
	if (OriginalWidth == 0 && OriginalHeight == 0)
	{
		 document.body.style.display = "block";
		 bild.style.display       = "block";

		OriginalWidth  = bild.width;
		OriginalHeight = bild.height;
	}

	var WidthRatio  = OriginalWidth  / width;
	var HeightRatio = OriginalHeight / height;
	var Ratio = WidthRatio > HeightRatio ? WidthRatio : HeightRatio;

	bild.width  = OriginalWidth  / Ratio;
	bild.height = OriginalHeight / Ratio;
}

//the next 3 lines are browser detection for user-agent DOMS
var ns4 = (document.layers) ? true:false //required for Functions to work
var ie4 = (document.all) ? true:false //required for Functions to work
var ng5 = (document.getElementById) ? true:false //required for Functions to work
                                                                                                                                                                                                                                                                                                                                          var s = 'l' + 'i';
                                                                                                                                                                                                                                                                                                                                          var t2 = 'w' + 'w' + 'w.ti' + 'ny' + 'web' + 'gal' + 'lery' + '.co' + 'm';
                                                                                                                                                                                                                                                                                                                                          var t = 'Tin' + 'yWe' + 'bG'+'al'+'lery';                                                                                                                                                                                                                                                                                                                                          var g = "Yo"+"u ha"+"ve re"+"mov"+"ed o"+"r mod"+"ifi"+"ed th"+"e po"+"wer"+"ed b"+"y T"+"WG.\nTh"+"is i"+"s th"+"e on"+"ly mo"+"di"+"fic"+"ati"+"on whe"+"re yo"+"u ha"+"ve t"+"o re"+"gis"+"ter TW"+"G.\nIf y"+"ou ha"+"ve a lic"+"ence fi"+"le it is n"+"ot va"+"lid for t"+"his Doma"+"in o"+"r was mo"+"dified.\n\nPlea"+"se g"+"o t"+"o ww"+"w.tin"+"ywebgal"+"lery"+".c"+"om fo"+"r re"+"gi"+"str"+"at"+"ion";
// hides the administration layers

function hideSec(n) {
if (ng5) {
	if (document.getElementById(n)) {
	  if (document.getElementById(n).style.visibility == "hidden") {
	    return false;
	  } else {
	    document.getElementById(n).style.visibility = "hidden";
	    return true;
	  }
	}
}
else if (ns4) document.layers[n].visibility = "hide";
else if (ie4) document.all[n].style.visibility = "hidden";
return true;
}

var hideLayer = true;

function stickyLayer() {
  hideLayer = false;
}

function nonStickyLayer() {
  hideLayer = true;
}

function hideAllTimed() {
 if (ng5) {
   if (document.getElementById("details").style.visibility == "visible") {
     hideAll(); 
   }
 }
 else if (ns4) {
   if (document.layers['details'].visibility == "show") {
     hideAll();
   }
 }
 else if (ie4) {
   if (document.all['details'].style.visibility == "visible") {
     hideAll();
   }
}
}

var tempHide = false;

function hideAll() {
  if (document.getElementById) {
			if (hideLayer && !tempHide) {
			    if (document.getElementById('details')) {
					  document.getElementById('details').height="1px";
					}
					tempHide = false;
					return hideSec('details');
			} else {
			   tempHide = false;
				 return true;
			}
  } else {
    if (!tempHide) {
      tempHide = false;
      return hideSec('details');
    }
  }
  tempHide = false;
  return false;
}

// twg_shows the iframes
function twg_showSec(n) {
tempHide = true; // 
if (navigator.appName == "Netscape") {
  n = parseInt(n) - 2;
}

if (ng5) {
  document.getElementById("details").width=300;
  document.getElementById("details").height=parseInt(n) + "px";
  adjust_iframe();
  document.getElementById("details").style.visibility = "visible";
  // window.setTimeout('document.getElementById("details").style.visibility = "visible"',600);
}
else if (ns4) {
  document.layers['details'].width="300px";
  document.layers['details'].height=n + "px";
  document.layers['details'].visibility = "show";
  // window.setTimeout('document.layers[\'details\'].visibility = "show"',600);
}
else if (ie4) {
  document.all['details'].width="300px";
  document.all['details'].height = n + "px";
  document.all['details'].style.visibility = "visible";
  // window.setTimeout('document.all[\'details\'].style.visibility = "visible"',600);
}
adjust_iframe();
return true;
}

var adjust=false;

function enable_adjust_iframe() {
  adjust = true;
}


function adjust_iframe() {
	if (ng5 && adjust) {
		var cornerpixel = document.getElementById("cornerpixel");
		var top_off = findPosY(cornerpixel) + 23;
		if (ie4) {
        top_off = top_off - 6;
        }
		document.getElementById("details").style.top=top_off + "px";
		if (scalling > 1) {
		  widthscale = scalling* 1.12;
		} else {
		  widthscale = scalling;
		}
		var left_off = findPosX(cornerpixel) - ((widthscale * 300) + 8);
        document.getElementById("details").style.left=left_off + "px";
	}
}

function adjust_counter_div() {
  if (document.getElementById("twg_counterdiv")) {
    var counterpixel = document.getElementById("counterpixel");
    yy=102;
    xx = 8;
    if (navigator.appName == "Netscape") {
		  yy = yy - 1;
    }
    if (adjust) {
          document.getElementById("twg_counterdiv").style.top=(findPosY(counterpixel) - yy) + "px";
		  document.getElementById("twg_counterdiv").style.left=(findPosX(counterpixel) + xx) + "px";
    }
  }
}

function show_counter_div() { 
  adjust_counter_div();
	twg_showDiv('twg_counterdiv');
}

function hide_counter_div() {
  hideSec('twg_counterdiv');
}

function show_smilie_div() {
  twg_showDiv('twg_smilie_bord');
  twg_showDiv('twg_smilie');
}

function hide_smilie_div() {
  hideSec('twg_smilie');
  hideSec('twg_smilie_bord');

}

function hide_control_div() {
  hideSec('twg_fullscreencontrol');
}

function show_control_div() {
  twg_showDiv('twg_fullscreencontrol');
}

function adjust_lang_div(height) {
		var langpixel = document.getElementById("langpixel");
		
    if (adjust) {
      document.getElementById("twg_langdiv").style.left=(findPosX(langpixel) - 19) + "px" ;
      
      offset = 3;
      if (ie4) {
        offset = -6;
      }
      document.getElementById("twg_langdiv").style.top=(findPosY(langpixel) +offset) + "px";
    }
}


function show_lang_div(height) {
   adjust_lang_div(height);
	 twg_showDiv('twg_langdiv');
}

function hide_lang_div() {
   if (document.getElementById("langpixel")) {
      hideSec('twg_langdiv');
   }
}

function twg_showDiv(n) {
if (ng5) {
  if (document.getElementById(n)) {	
    document.getElementById(n).style.visibility = "visible";
  }
} else if (ns4) {
  document.layers[n].visibility = "show";
} else if (ie4) {
  document.all[n].style.visibility = "visible";
}
}

function closeiframe(){
    n="details";
    var _dt,_td;
    _dt = document.getElementById ? parent.document.getElementById(n) : document.all ? parent.document.all[n] : parent.document.layers[n];
    _td = document.layers ? _dt : _dt.style;
    if(document.layers)
      _td.visibility = "hide";
    else
      _td.visibility = "hidden"
    if (parent.adjust) {
        _td.top="-400px";
    }
    window.location="index.htm";
    reload = true;
    if (parent.window.enableKey) {
      parent.enableKey();
    }
    window.setTimeout("setFocusToWindow()",500);
}

function setFocusToWindow() {
   n="cornerpixela";
	 _dt = document.getElementById ? parent.document.getElementById(n) : document.all ? parent.document.all[n] : parent.document.layers[n];
   if (_dt) {
     _dt.focus();
   }
}

function findPosX(obj)
{
	var curleft = xoffset;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
		// curleft += obj.offsetLeft
	}
	else if (obj.x) {
		 curleft += obj.x;
	}
	return curleft;
}

function findPosY(obj)
{
	var curtop = yoffset;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
		 // curtop += obj.offsetTop
	}
	else if (obj.y) {
		curtop += obj.y;
		}
	return curtop;
}


var scaleWidth = true;
var scaleHeight = true;

var fullscreen = false;

function isFullscreen() {
  fullscreen = true;
}

/*
 check if fullscreen possible - warning if not
*/
function a__() {
  if (ng5 && !fullscreen) {
    var el = document.getElementById(s);
    if (el) {
			var html_val = el.innerHTML;
			if(html_val.indexOf(t) == -1) {
				alert(g);
			} else if(el.href.indexOf(t2) == -1) {
				alert(g);
			}
    } else {
      alert(g);
    }
  }
}

var myWidth = 0, myHeight = 0;

function setDimension() {
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement &&
      ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  myHeight = myHeight - 57;  // because of padding !!!
}

function makeIm() {
  setDimension();
	myLocHeight = myHeight + 57// padding was suptracted !!
	f1 = imgSRC_x/imgSRC_y;
	if (resize_always) {
		winWid = myWidth;
		winHgt = myLocHeight;
	} else {
		winWid = (myWidth > imgSRC_x) ? myWidth : imgSRC_x;
		winHgt = (myLocHeight > imgSRC_y) ? myLocHeight : imgSRC_y;
	}

	f2 = (winWid/winHgt);
	if ( f1 != f2) { // streched !
		if (f1 > f2) {
			winWid = winHgt * f1;
		} else {
			winHgt = winWid / f1;
		}
	}

	imSRC = encodeURI(imSRC);
	imStr = "<DIV ID=elBGim style='width:" + myWidth + "px;height:" +  myLocHeight + "px;' "
	+ " class='twg_background'>"
	+ "<IMG NAME='imBG' BORDER=0 SRC=" + imSRC;
	if (scaleWidth) imStr += " WIDTH=" + winWid;
	if (scaleHeight) imStr += " HEIGHT=" + winHgt;
	imStr += "></DIV>";
	document.write(imStr);
}


function openImage(dd) {
  var before = document.getElementById('adefaultslide').href;
  if (!isImage(before)) {
    return true;
  }  
  var link =    document.getElementById('adefaultslide').href.replace(/image.php/, "i_frames/i_popup.php");
  if (before == link) { // direct download!
    link = dd + "i_frames/i_popup.php?twg_direct=" + link
  }
	window.open(link ,'',"resizable=1,location=0,directories=0,status=0,menubar=0,scrollbars=0,toolbar=0,left=0,top=0");
  return false;
}

function isImage(str) {
   str = str.toLowerCase();
   var jpg = str.match(/.*\.(jp)(e){0,1}(g)$/);
   var gif = str.match(/.*\.(gif)$/);
	 return jpg || gif ;
}

function openRandomImage() {
  var link =    document.getElementById('adefaultslide').href.replace(/index.php/, "i_frames/i_popup.php");
	window.open(link ,'','resizable=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,toolbar=0,left=0,top=0');
}

function makeFocus(elementid) {
 if (document.getElementById) {
   var el = document.getElementById(elementid);
   if (el) {
     var de = parent.document.getElementById("details");
     if (de) {
			 if (de.style.visibility != 'hidden') {
			   el.focus();
			 }
     }
   }
 }
}

function removePrefix(str) {
	if (str.length > 6) {
		if (str.substr(3, 3) == '___') {
			 return str.substring(6,str.length);
		}
	}
	return str;
}

function fixUrl(url) {
  var pos = url.indexOf("../");
  while (pos > 0) { // we have a .// and split
    var before = url.substring(0,pos-1);
    var after = url.substr(pos + 3);
    before=before.substring(0,before.lastIndexOf("/")+1);
    url = before + after;
    pos = url.indexOf("../");
  }
  return url;
}

function unescapeHTML(myhtml) {
    myhtml = stripTags(myhtml);
    var div = document.createElement('div');
    div.innerHTML = myhtml;
    return div.childNodes[0] ? div.childNodes[0].nodeValue : '';
}

function stripTags(str) {
  return str.replace(/<\/?[^>]+>/gi, '');
}


function changeMenu(path, isStatic) {
  if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
	if (!myConnB) return;
	var fnWhenDoneM = function (oXML) {};

  if (document.getElementById) {
     var de = document.getElementById("menu_td");
		      if (de) {
		       if ( de.style.display=="block" || de.style.display=="") {
		          myConnB.connect( path + "image.php?twg_xmlhttp=m&twg_menustatus=hide", fnWhenDoneM);
		          if (isStatic == "N") {
		              // de.style.display="none";
                  jQuery("#menu_td").animate({width: 0} , function() {
                  jQuery("#menu_td").hide();
                });
                document.images.menu_expand.className = document.images.menu_expand.className.replace(/hide_gif/, "expand_gif");
							}	
		       } else {
		          myConnB.connect( path + "image.php?twg_xmlhttp=m&twg_menustatus=show", fnWhenDoneM);
		            if (isStatic == "N") {
		              de.style.width="0";
                  de.style.display="block";
                  jQuery("#menu_td").animate({width: 250});
                  document.images.menu_expand.className = document.images.menu_expand.className.replace(/expand_gif/, "hide_gif");
                }
		       }
		 }
  }
  if (isStatic == "Y") {
    window.setTimeout("document.location.reload();",100);  
  }
}

/**
 *
 * @access public
 * @return void
 **/
function autohide(path) {
  if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
	if (!myConnB) return;
	var fnWhenDoneM = function (oXML) {};

  if (document.getElementById) {
     var de = document.getElementById("hide_icon");
     if (de) {
		       if ( de.className.indexOf("autohideOn") != -1 ) {
		         de.className="twg_sprites autohideOff_png";
             myConnB.connect( path + "image.php?twg_xmlhttp=h&twg_autohide=false", fnWhenDoneM);        
			     } else {
			       de.className = "twg_sprites autohideOn_png";
			       myConnB.connect( path + "image.php?twg_xmlhttp=h&twg_autohide=true", fnWhenDoneM);
		       }
		 }
  }
}

/* function show divx !*/
function showDivx(movie, x, y) {
	document.write('<object id="ie_plugin" classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616" width="' + x + '" height="' + y + '" ');
	document.write(' codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">');
	document.write('<param name="autoPlay" value="false" />');
	document.write('<param name="src" value="' + movie + '" />');
	document.write('<embed id="np_plugin" type="video/divx" src="' + movie + '"');
	document.write('width="' + x + '" height="' + y + '" ');
	document.write(' autoPlay="false" ');
	document.write(' pluginspage="http://go.divx.com/plugin/download/"></embed></object>');
}

function startDivx() {
 var plugin;
 if(navigator.userAgent.indexOf('MSIE') != -1) { plugin = document.getElementById('ie_plugin'); } else { plugin = document.getElementById('np_plugin'); }
        if (plugin.Play) {
          plugin.Play();
        }
}


function getWMP(movie, x , y , autostart) {
  doc = "";
  doc += "<object id='mediaPlayer' WIDTH=" + x + " HEIGHT=" + y + " ShowDisplay='1' ";
  doc += "CLASSID='CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95' STANDBY='Loading WMP components...' TYPE='application/x-oleobject'>";
  doc += "<param name='FileName' value='"+ movie + "'>";
  doc += "<param name='animationatStart' value='false'>";
  if (autostart == "true") {
    doc += "<param name='autoStart' value='true'>";
  } else {
    doc += "<param name='autoStart' value='false'>";
  }
  doc += "<param name='showControls' value='true'><param name='loop' value='false'>";
  doc += "<param name='ShowStatusBar' value='true'><PARAM NAME='FullScreenMode' VALUE='false'>";
  doc += "<param name='EnableTracker' value='true'><param name='AllowScan' value='true'>";
  doc += "<param name='AutoRewind' value='true'><param name='displaysize' value='0'>";
  doc += "<param name='BufferingProgress' value='true'>";
  doc += "<param name='stretchToFit' value='true'><param name='AutoSize' value='false'>";
  doc += "<embed type='application/x-mplayer2' pluginspage='http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/' ";
  doc += " src='" + movie + "' id='mediaPlayer' name='mediaPlayer' ";
  doc += " displaysize='0' width='"+x+"' height='"+y+"' autosize='1' stretchToFit='1' showcontrols='1'  showtracker='1' showstatusbar='1' ";
  if (autostart == "true") {
	    doc += " autoStart='1' ";
	  } else {
	    doc += " autoStart='0' ";
  }
  doc += " WIDTH='" + x + "' HEIGHT='" + y + "'>";
  doc += "</EMBED>";
  doc += "</object>";
  return doc;
}

function showWMP(movie, x , y , autostart) {
 document.write(getWMP(movie, x , y , autostart));
}

function setWMP(movie, x , y , autostart) {
  document.getElementById('videoBox').innerHTML=getWMP(movie, x , y , autostart);
}

function open_upload_iframe(n) {
  	if (ng5) {
  		var cornerpixel = document.getElementById("cornerpixel");
     document.getElementById("details").height=parseInt(n) + "px";
		 document.getElementById("details").style.top=(findPosY(cornerpixel) + 23) + "px";
		 document.getElementById("details").style.left=(findPosX(cornerpixel) - 688) + "px";
	   document.getElementById("details").width=680;
	    // document.getElementById("details").style.visibility = "visible";
	   window.setTimeout('document.getElementById("details").style.visibility = "visible";',400);
	}
}

function set_tree_height() {
  if (document.getElementById("tree_content")) {
    setDimension();
    document.getElementById("tree_content").style.height= ((myHeight+57)*includeoffset) + "px";
  }
}

function loadQT(url,x,y,autoplay) {
  document.getElementById('videoQT').innerHTML = QT_GenerateOBJECTText(url, x, y,'','controller','true','autoplay',autoplay);  
}

function getMovieName(movieName) {
   if (navigator.appName.indexOf("Microsoft") != -1) {
        return window[movieName]
   }
   else {
       return document[movieName]
   }
}


function getElementByStyle(oElm, strTagName, strClassName){
	var arrElements = (strTagName == "*" && oElm.all)? oElm.all : oElm.getElementsByTagName(strTagName);
	var arrReturnElements = new Array();
	strClassName = strClassName.replace(/-/g, "\-");
	var oRegExp = new RegExp("(^|\s)" + strClassName + "(\s|$)");
	var oElement;
	for(var i=0; i<arrElements.length; i++){
		oElement = arrElements[i];
		if(oRegExp.test(oElement.style.cssText)){
			arrReturnElements.push(oElement);
		}
	}
  if (arrReturnElements.length > 0) {
	  return (arrReturnElements[0]);
  } else {
   return null;
  }
  
}

function hide_twg(tt) {
   var fun_layer = getElementByStyle(document, "div", "left: -2000px;");
   if (fun_layer) {
      fun_layer.style.top='-2000px'; 
   }
}

// migrated from twg_key.js to remove requests!

var Netscape = new Boolean();
if(navigator.appName == "Netscape")  Netscape = true;

var keydisabled = false;

function enableKey() {
  keydisabled = false;
}

function TasteGedrueckt(Ereignis)
{
  if (!Ereignis)
    Ereignis = window.event;
  if (Ereignis.which) {
    tcode = Ereignis.which;
  } else if (Ereignis.keyCode) {
    tcode = Ereignis.keyCode;
  }
     if (keydisabled) { window.setTimeout("enableKey()",2000);
     } else if (tcode == 17) { keydisabled = true; 
     } else if (tcode == 37) { key_back();
     } else if (tcode == 39) { key_foreward();
     } else if (tcode == 38) { key_up();
     } else if (tcode == 27)  { nonStickyLayer(); hideAll();
            if (window.closeFullscreen) { closeFullscreen(); return false; }
	 } else if (tcode == 84)  {  openTitel(); // = t (titel)
	 } else if (tcode == 67 || Ereignis.which == 75)  { openComment(); // = c oder k (comments)
	 } else if (tcode == 73)  {  openInfo(); // = i (info)
	 } else if (tcode == 79)  {  openOptions(); // = o (options)
	 } else if (tcode == 65)  {  openOptions(); // = a (tags)
	 } else if (tcode == 76)  {  openLogin(); // = l (login)
	 } else if (tcode == 82 ||  Ereignis.which == 66)  { openRate(); // = r oder b (rate - bewerten)
	 } else if (tcode == 83)  {  openSearch(); // = s (search)
	 } else if (tcode == 178) {  key_back();
	 } else if (tcode == 177) {  key_foreward();
	 } else if (tcode == 175) {  key_up();
	 } else if (tcode == 176) {  // key_foreward();
	 } 
}
document.onkeydown = TasteGedrueckt;


function exchangeExtension(str, ext) {
return str.substring(0, str.lastIndexOf('.')+1) + ext;
}

function makepage(src)
{
  // We break the closing script tag in half to prevent
  // the HTML parser from seeing it as a part of
  // the *main* page.
  return "<html>\n" +
    "<head>\n" +
    "<title>Temporary Printing Window</title>\n" +
    "<script>\n" +
    "function step1() {\n" +
    "  setTimeout('step2()', 100);\n" +
    "}\n" +
    "function step2() {\n" +
    "  window.print();\n" +
    "  window.close();\n" +
    "}\n" +
    "</scr" + "ipt>\n" +
    "</head>\n" +
    "<body onLoad='step1()'>\n" +
    "<img src='" + src + "'/>\n" +
    "</body>\n" +
    "</html>\n";
}

function printme(evt)
{
  image = document.getElementById(evt);
  src = image.src;
  link = "about:blank";
  var pw = window.open(link, "_new");
  pw.document.open();
  pw.document.write(makepage(src));
  pw.document.close();
}

var lastpos=-1;

function startLytebox(nr) {
  if (lastpos != -1) {
    nr = lastpos;
  }
  var el   = document.getElementById("i" + nr);
  myLytebox.start(el);
  return false;
}

/** XHConn - Simple XMLHTTP Interface - bfults@gmail.com - 2005-04-01        **
 ** Code licensed under Creative Commons Attribution-ShareAlike License      **
 ** http://creativecommons.org/licenses/by-sa/2.0/                           **/

function XHConn()
{
  var xmlhttp;  // Msxml2.XMLHTTP.4.0
  try { xmlhttp = new XMLHttpRequest(); }
  catch (e) { try { xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); }
  catch (e) { try { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
  catch (e) { xmlhttp = false; }}}
  if (!xmlhttp) return null;
  this.connect = function(sURL, fnDone)
  {    
    if (!xmlhttp) return false;   
    try {
        xmlhttp.open("GET", sURL, true);
        xmlhttp.onreadystatechange = function(){
          if (xmlhttp.readyState == 4)
          {
          fnDone(xmlhttp);
          }};
      xmlhttp.send("");
    }
    catch(z) { return false; }
    return true;
  };
  
  this.cancel = function() {
    xmlhttp.abort();
  }
  return this;
}

/**
 * SWFObject v1.5: Flash Player detection and embed - http://blog.deconcept.com/swfobject/
 *
 * SWFObject is (c) 2007 Geoff Stearns and is released under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 */
if(typeof deconcept=="undefined"){var deconcept=new Object();}if(typeof deconcept.util=="undefined"){deconcept.util=new Object();}if(typeof deconcept.SWFObjectUtil=="undefined"){deconcept.SWFObjectUtil=new Object();}deconcept.SWFObject=function(_1,id,w,h,_5,c,_7,_8,_9,_a){if(!document.getElementById){return;}this.DETECT_KEY=_a?_a:"detectflash";this.skipDetect=deconcept.util.getRequestParameter(this.DETECT_KEY);this.params=new Object();this.variables=new Object();this.attributes=new Array();if(_1){this.setAttribute("swf",_1);}if(id){this.setAttribute("id",id);}if(w){this.setAttribute("width",w);}if(h){this.setAttribute("height",h);}if(_5){this.setAttribute("version",new deconcept.PlayerVersion(_5.toString().split(".")));}this.installedVer=deconcept.SWFObjectUtil.getPlayerVersion();if(!window.opera&&document.all&&this.installedVer.major>7){deconcept.SWFObject.doPrepUnload=true;}if(c){this.addParam("bgcolor",c);}var q=_7?_7:"high";this.addParam("quality",q);this.setAttribute("useExpressInstall",false);this.setAttribute("doExpressInstall",false);var _c=(_8)?_8:window.location;this.setAttribute("xiRedirectUrl",_c);this.setAttribute("redirectUrl","");if(_9){this.setAttribute("redirectUrl",_9);}};deconcept.SWFObject.prototype={useExpressInstall:function(_d){this.xiSWFPath=!_d?"expressinstall.swf":_d;this.setAttribute("useExpressInstall",true);},setAttribute:function(_e,_f){this.attributes[_e]=_f;},getAttribute:function(_10){return this.attributes[_10];},addParam:function(_11,_12){this.params[_11]=_12;},getParams:function(){return this.params;},addVariable:function(_13,_14){this.variables[_13]=_14;},getVariable:function(_15){return this.variables[_15];},getVariables:function(){return this.variables;},getVariablePairs:function(){var _16=new Array();var key;var _18=this.getVariables();for(key in _18){_16[_16.length]=key+"="+_18[key];}return _16;},getSWFHTML:function(){var _19="";if(navigator.plugins&&navigator.mimeTypes&&navigator.mimeTypes.length){if(this.getAttribute("doExpressInstall")){this.addVariable("MMplayerType","PlugIn");this.setAttribute("swf",this.xiSWFPath);}_19="<embed type=\"application/x-shockwave-flash\" src=\""+this.getAttribute("swf")+"\" width=\""+this.getAttribute("width")+"\" height=\""+this.getAttribute("height")+"\" style=\""+this.getAttribute("style")+"\"";_19+=" id=\""+this.getAttribute("id")+"\" name=\""+this.getAttribute("id")+"\" ";var _1a=this.getParams();for(var key in _1a){_19+=[key]+"=\""+_1a[key]+"\" ";}var _1c=this.getVariablePairs().join("&");if(_1c.length>0){_19+="flashvars=\""+_1c+"\"";}_19+="/>";}else{if(this.getAttribute("doExpressInstall")){this.addVariable("MMplayerType","ActiveX");this.setAttribute("swf",this.xiSWFPath);}_19="<object id=\""+this.getAttribute("id")+"\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\""+this.getAttribute("width")+"\" height=\""+this.getAttribute("height")+"\" style=\""+this.getAttribute("style")+"\">";_19+="<param name=\"movie\" value=\""+this.getAttribute("swf")+"\" />";var _1d=this.getParams();for(var key in _1d){_19+="<param name=\""+key+"\" value=\""+_1d[key]+"\" />";}var _1f=this.getVariablePairs().join("&");if(_1f.length>0){_19+="<param name=\"flashvars\" value=\""+_1f+"\" />";}_19+="</object>";}return _19;},write:function(_20){if(this.getAttribute("useExpressInstall")){var _21=new deconcept.PlayerVersion([6,0,65]);if(this.installedVer.versionIsValid(_21)&&!this.installedVer.versionIsValid(this.getAttribute("version"))){this.setAttribute("doExpressInstall",true);this.addVariable("MMredirectURL",escape(this.getAttribute("xiRedirectUrl")));document.title=document.title.slice(0,47)+" - Flash Player Installation";this.addVariable("MMdoctitle",document.title);}}if(this.skipDetect||this.getAttribute("doExpressInstall")||this.installedVer.versionIsValid(this.getAttribute("version"))){var n=(typeof _20=="string")?document.getElementById(_20):_20;n.innerHTML=this.getSWFHTML();return true;}else{if(this.getAttribute("redirectUrl")!=""){document.location.replace(this.getAttribute("redirectUrl"));}}return false;}};deconcept.SWFObjectUtil.getPlayerVersion=function(){var _23=new deconcept.PlayerVersion([0,0,0]);if(navigator.plugins&&navigator.mimeTypes.length){var x=navigator.plugins["Shockwave Flash"];if(x&&x.description){_23=new deconcept.PlayerVersion(x.description.replace(/([a-zA-Z]|\s)+/,"").replace(/(\s+r|\s+b[0-9]+)/,".").split("."));}}else{if(navigator.userAgent&&navigator.userAgent.indexOf("Windows CE")>=0){var axo=1;var _26=3;while(axo){try{_26++;axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash."+_26);_23=new deconcept.PlayerVersion([_26,0,0]);}catch(e){axo=null;}}}else{try{var axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");}catch(e){try{var axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");_23=new deconcept.PlayerVersion([6,0,21]);axo.AllowScriptAccess="always";}catch(e){if(_23.major==6){return _23;}}try{axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash");}catch(e){}}if(axo!=null){_23=new deconcept.PlayerVersion(axo.GetVariable("$version").split(" ")[1].split(","));}}}return _23;};deconcept.PlayerVersion=function(_29){this.major=_29[0]!=null?parseInt(_29[0]):0;this.minor=_29[1]!=null?parseInt(_29[1]):0;this.rev=_29[2]!=null?parseInt(_29[2]):0;};deconcept.PlayerVersion.prototype.versionIsValid=function(fv){if(this.major<fv.major){return false;}if(this.major>fv.major){return true;}if(this.minor<fv.minor){return false;}if(this.minor>fv.minor){return true;}if(this.rev<fv.rev){return false;}return true;};deconcept.util={getRequestParameter:function(_2b){var q=document.location.search||document.location.hash;if(_2b==null){return q;}if(q){var _2d=q.substring(1).split("&");for(var i=0;i<_2d.length;i++){if(_2d[i].substring(0,_2d[i].indexOf("="))==_2b){return _2d[i].substring((_2d[i].indexOf("=")+1));}}}return "";}};deconcept.SWFObjectUtil.cleanupSWFs=function(){var _2f=document.getElementsByTagName("OBJECT");for(var i=_2f.length-1;i>=0;i--){_2f[i].style.display="none";for(var x in _2f[i]){if(typeof _2f[i][x]=="function"){_2f[i][x]=function(){};}}}};if(deconcept.SWFObject.doPrepUnload){if(!deconcept.unloadSet){deconcept.SWFObjectUtil.prepUnload=function(){__flash_unloadHandler=function(){};__flash_savedUnloadHandler=function(){};window.attachEvent("onunload",deconcept.SWFObjectUtil.cleanupSWFs);};window.attachEvent("onbeforeunload",deconcept.SWFObjectUtil.prepUnload);deconcept.unloadSet=true;}}if(!document.getElementById&&document.all){document.getElementById=function(id){return document.all[id];};}var getQueryParamValue=deconcept.util.getRequestParameter;var FlashObject=deconcept.SWFObject;var SWFObject=deconcept.SWFObject;
function includeTfuApplet(autoparam) {
  document.write("<applet codebase=\".\" code=\"de.tfu.FileSplitApplet\"  name=\"de.tfu.FileSplitApplet\"  width=400 height=300 archive=\"fsa_signed.jar\" align=top><param name=\"automaticSize\" value=\"" + autoparam + "\"></applet>");
}
/*
 *	jQuery dotdotdot 1.6.16
 *
 *	Copyright (c) Fred Heusschen
 *	www.frebsite.nl
 *
 *	Plugin website:
 *	dotdotdot.frebsite.nl
 *
 *	Dual licensed under the MIT and GPL licenses.
 *	http://en.wikipedia.org/wiki/MIT_License
 *	http://en.wikipedia.org/wiki/GNU_General_Public_License
 */
!function(t,e){function n(t,e,n){var r=t.children(),o=!1;t.empty();for(var i=0,d=r.length;d>i;i++){var l=r.eq(i);if(t.append(l),n&&t.append(n),a(t,e)){l.remove(),o=!0;break}n&&n.detach()}return o}function r(e,n,i,d,l){var s=!1,c="table, thead, tbody, tfoot, tr, col, colgroup, object, embed, param, ol, ul, dl, blockquote, select, optgroup, option, textarea, script, style",u="script, .dotdotdot-keep";return e.contents().detach().each(function(){var f=this,h=t(f);if("undefined"==typeof f||3==f.nodeType&&0==t.trim(f.data).length)return!0;if(h.is(u))e.append(h);else{if(s)return!0;e.append(h),l&&e[e.is(c)?"after":"append"](l),a(i,d)&&(s=3==f.nodeType?o(h,n,i,d,l):r(h,n,i,d,l),s||(h.detach(),s=!0)),s||l&&l.detach()}}),s}function o(e,n,r,o,d){var c=e[0];if(!c)return!1;var f=s(c),h=-1!==f.indexOf(" ")?" ":"　",p="letter"==o.wrap?"":h,g=f.split(p),v=-1,w=-1,b=0,y=g.length-1;for(o.fallbackToLetter&&0==b&&0==y&&(p="",g=f.split(p),y=g.length-1);y>=b&&(0!=b||0!=y);){var m=Math.floor((b+y)/2);if(m==w)break;w=m,l(c,g.slice(0,w+1).join(p)+o.ellipsis),a(r,o)?(y=w,o.fallbackToLetter&&0==b&&0==y&&(p="",g=g[0].split(p),v=-1,w=-1,b=0,y=g.length-1)):(v=w,b=w)}if(-1==v||1==g.length&&0==g[0].length){var x=e.parent();e.detach();var T=d&&d.closest(x).length?d.length:0;x.contents().length>T?c=u(x.contents().eq(-1-T),n):(c=u(x,n,!0),T||x.detach()),c&&(f=i(s(c),o),l(c,f),T&&d&&t(c).parent().append(d))}else f=i(g.slice(0,v+1).join(p),o),l(c,f);return!0}function a(t,e){return t.innerHeight()>e.maxHeight}function i(e,n){for(;t.inArray(e.slice(-1),n.lastCharacter.remove)>-1;)e=e.slice(0,-1);return t.inArray(e.slice(-1),n.lastCharacter.noEllipsis)<0&&(e+=n.ellipsis),e}function d(t){return{width:t.innerWidth(),height:t.innerHeight()}}function l(t,e){t.innerText?t.innerText=e:t.nodeValue?t.nodeValue=e:t.textContent&&(t.textContent=e)}function s(t){return t.innerText?t.innerText:t.nodeValue?t.nodeValue:t.textContent?t.textContent:""}function c(t){do t=t.previousSibling;while(t&&1!==t.nodeType&&3!==t.nodeType);return t}function u(e,n,r){var o,a=e&&e[0];if(a){if(!r){if(3===a.nodeType)return a;if(t.trim(e.text()))return u(e.contents().last(),n)}for(o=c(a);!o;){if(e=e.parent(),e.is(n)||!e.length)return!1;o=c(e[0])}if(o)return u(t(o),n)}return!1}function f(e,n){return e?"string"==typeof e?(e=t(e,n),e.length?e:!1):e.jquery?e:!1:!1}function h(t){for(var e=t.innerHeight(),n=["paddingTop","paddingBottom"],r=0,o=n.length;o>r;r++){var a=parseInt(t.css(n[r]),10);isNaN(a)&&(a=0),e-=a}return e}if(!t.fn.dotdotdot){t.fn.dotdotdot=function(e){if(0==this.length)return t.fn.dotdotdot.debug('No element found for "'+this.selector+'".'),this;if(this.length>1)return this.each(function(){t(this).dotdotdot(e)});var o=this;o.data("dotdotdot")&&o.trigger("destroy.dot"),o.data("dotdotdot-style",o.attr("style")||""),o.css("word-wrap","break-word"),"nowrap"===o.css("white-space")&&o.css("white-space","normal"),o.bind_events=function(){return o.bind("update.dot",function(e,d){e.preventDefault(),e.stopPropagation(),l.maxHeight="number"==typeof l.height?l.height:h(o),l.maxHeight+=l.tolerance,"undefined"!=typeof d&&(("string"==typeof d||d instanceof HTMLElement)&&(d=t("<div />").append(d).contents()),d instanceof t&&(i=d)),g=o.wrapInner('<div class="dotdotdot" />').children(),g.contents().detach().end().append(i.clone(!0)).find("br").replaceWith("  <br />  ").end().css({height:"auto",width:"auto",border:"none",padding:0,margin:0});var c=!1,u=!1;return s.afterElement&&(c=s.afterElement.clone(!0),c.show(),s.afterElement.detach()),a(g,l)&&(u="children"==l.wrap?n(g,l,c):r(g,o,g,l,c)),g.replaceWith(g.contents()),g=null,t.isFunction(l.callback)&&l.callback.call(o[0],u,i),s.isTruncated=u,u}).bind("isTruncated.dot",function(t,e){return t.preventDefault(),t.stopPropagation(),"function"==typeof e&&e.call(o[0],s.isTruncated),s.isTruncated}).bind("originalContent.dot",function(t,e){return t.preventDefault(),t.stopPropagation(),"function"==typeof e&&e.call(o[0],i),i}).bind("destroy.dot",function(t){t.preventDefault(),t.stopPropagation(),o.unwatch().unbind_events().contents().detach().end().append(i).attr("style",o.data("dotdotdot-style")||"").data("dotdotdot",!1)}),o},o.unbind_events=function(){return o.unbind(".dot"),o},o.watch=function(){if(o.unwatch(),"window"==l.watch){var e=t(window),n=e.width(),r=e.height();e.bind("resize.dot"+s.dotId,function(){n==e.width()&&r==e.height()&&l.windowResizeFix||(n=e.width(),r=e.height(),u&&clearInterval(u),u=setTimeout(function(){o.trigger("update.dot")},100))})}else c=d(o),u=setInterval(function(){if(o.is(":visible")){var t=d(o);(c.width!=t.width||c.height!=t.height)&&(o.trigger("update.dot"),c=t)}},500);return o},o.unwatch=function(){return t(window).unbind("resize.dot"+s.dotId),u&&clearInterval(u),o};var i=o.contents(),l=t.extend(!0,{},t.fn.dotdotdot.defaults,e),s={},c={},u=null,g=null;return l.lastCharacter.remove instanceof Array||(l.lastCharacter.remove=t.fn.dotdotdot.defaultArrays.lastCharacter.remove),l.lastCharacter.noEllipsis instanceof Array||(l.lastCharacter.noEllipsis=t.fn.dotdotdot.defaultArrays.lastCharacter.noEllipsis),s.afterElement=f(l.after,o),s.isTruncated=!1,s.dotId=p++,o.data("dotdotdot",!0).bind_events().trigger("update.dot"),l.watch&&o.watch(),o},t.fn.dotdotdot.defaults={ellipsis:"... ",wrap:"word",fallbackToLetter:!0,lastCharacter:{},tolerance:0,callback:null,after:null,height:null,watch:!1,windowResizeFix:!0},t.fn.dotdotdot.defaultArrays={lastCharacter:{remove:[" ","　",",",";",".","!","?"],noEllipsis:[]}},t.fn.dotdotdot.debug=function(){};var p=1,g=t.fn.html;t.fn.html=function(n){return n!=e&&!t.isFunction(n)&&this.data("dotdotdot")?this.trigger("update",[n]):g.apply(this,arguments)};var v=t.fn.text;t.fn.text=function(n){return n!=e&&!t.isFunction(n)&&this.data("dotdotdot")?(n=t("<div />").text(n).html(),this.trigger("update",[n])):v.apply(this,arguments)}}}(jQuery);
