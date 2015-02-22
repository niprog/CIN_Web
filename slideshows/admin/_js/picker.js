function ini()
{
  info = null;
  hexfeld = new Array(6)

  // grayscale addon !!
  wert = new Array(18)
	wert[0]="00"
	wert[1]="11"
	wert[2]="22"
	wert[3]="33"
	wert[4]="44"
	wert[5]="55"
	wert[6]="66"
	wert[7]="77"
	wert[8]="88"
	wert[9]="99"
	wert[10]="AA"
	wert[11]="BB"
	wert[12]="CC"
	wert[13]="DD"
	wert[14]="EE"
	wert[15]="FF"
	wert[16]="F6"
	wert[17]="FA"
}

function status_mehr_weniger(mw,f)
{
   if (mw == 0) mwf = "weniger ";
   else mwf = "mehr ";
   if (f == 0) mwf = mwf + "rot";
   if (f == 1) mwf = mwf + "gruen";
   if (f == 2) mwf = mwf + "blau";
   window.status = mwf;
   setTimeout("statusaus()",50000);
}

function statusein(ks,ls,ms)
{
   farb = "" + wert[ks] + wert[ls] + wert[ms];
   window.status = farb;
   setTimeout("statusaus()",10000);
}

function statusaus()
{
   window.status="";
}


function wechsel1()
{
   farb = "#" + document.forms[0].elements[8].value;
   document.getElementById("preview").style.backgroundColor=farb

}

function wechsel(kw,lw,mw)
{
   loeschen();
   document.forms[0].elements[8].value = "" + wert[kw] + wert[lw] + wert[mw];
   wechsel1();
   document.forms[0].elements[9].checked = "1"
   rechnen1();
}

function hex_wert()
{
   document.forms[0].elements[0].value = hexfeld[0] * 16 + hexfeld[1]
   document.forms[0].elements[1].value = hexfeld[2] * 16 + hexfeld[3]
   document.forms[0].elements[2].value = hexfeld[4] * 16 + hexfeld[5]
}

function wert_proz()
{
   var wert = 0;
   var proz = 0.0;
   wert = document.forms[0].elements[0].value;
   if (wert != 0) proz = Math.round(wert*100/255); else proz = 0;
   document.forms[0].elements[4].value = proz;
   wert = document.forms[0].elements[1].value;
   if (wert != 0) proz = Math.round(wert*100/255); else proz = 0;
   document.forms[0].elements[5].value = proz;
   wert = document.forms[0].elements[2].value;
   if (wert != 0) proz = Math.round(wert*100/255); else proz = 0;
   document.forms[0].elements[6].value = proz;
}

function proz_wert()
{
   var wert = 0;
   var proz = 0.0;
   proz = document.forms[0].elements[4].value;
   wert = Math.round(proz*255/100);
   document.forms[0].elements[0].value = wert;
   proz = document.forms[0].elements[5].value;
   wert = Math.round(proz*255/100);
   document.forms[0].elements[1].value = wert;
   proz = document.forms[0].elements[6].value;
   wert = Math.round(proz*255/100);
   document.forms[0].elements[2].value = wert;
}

function wert_hex1(zwa)
{
   var zwb = "";
   if (zwa == 10) zwb = "A"
   else if (zwa == 11) zwb = "B"
   else if (zwa == 12) zwb = "C"
   else if (zwa == 13) zwb = "D"
   else if (zwa == 14) zwb = "E"
   else if (zwa == 15) zwb = "F"
   else zwb = "" + zwa;
   return(zwb);
}

function wert_hex()
{
   var zw1 = Math.floor(document.forms[0].elements[0].value/16);
   var zw2 = document.forms[0].elements[0].value - (zw1 * 16);
   var zw3 = wert_hex1(zw1);
   var zw4 = wert_hex1(zw2);
   document.forms[0].elements[8].value = "" + zw3 + zw4;
   zw1 = Math.floor(document.forms[0].elements[1].value/16);
   zw2 = document.forms[0].elements[1].value - (zw1 * 16);
   zw3 = wert_hex1(zw1);
   zw4 = wert_hex1(zw2);
   document.forms[0].elements[8].value = document.forms[0].elements[8].value + zw3 + zw4;
   zw1 = Math.floor(document.forms[0].elements[2].value/16);
   zw2 = document.forms[0].elements[2].value - (zw1 * 16);
   zw3 = wert_hex1(zw1);
   zw4 = wert_hex1(zw2);
   document.forms[0].elements[8].value = document.forms[0].elements[8].value + zw3 + zw4;
}

function pruef_wert()
{
   for (var i=0; i<3; i++)
   {
      var werte = parseInt(document.forms[0].elements[i].value)
      if (isNaN(werte))
      {
         alert('Eingaben von 0 bis 255 erlaubt!');
         return(false);
      }
      else
     if ((werte < 0) || (werte > 255))
     {
        alert('Eingaben von 0 bis 255 erlaubt!');
        return(false);
     }
     document.forms[0].elements[i].value = werte
   }
   return(true);
}

function pruef_proz(w)
{
   for (var i=4; i<7; i++)
   {
      var proze = parseInt(document.forms[0].elements[i].value)
      if (isNaN(proze))
      {
         if (w == 0) alert('Eingaben von 0 bis 100 erlaubt!');
         else alert('Ausgangswert bestimmen!');
         return(false);
      }
      if ((proze < 0) || (proze > 100))
      {
         alert('Eingaben von 0 bis 100 erlaubt!');
         return(false);
      }
      else
         document.forms[0].elements[i].value = proze
      }
   return(true);
}

function pruef_hex()
{
   if (document.forms[0].elements[8].value.length < 5)
   {
      alert('Hex-Code hat weniger als 6 Zeichen!');
      return(false);
   }
   for (var i=0; i<6; i++)
   {
      hexfeld[i] = parseInt(document.forms[0].elements[8].value.substring(i,i+1) , 16);
      if (isNaN(hexfeld[i]))
      {
         alert('nur 0,1,2,3,4,5,6,7,8,9,A,a,B,b,C,c,D,d,E,e,F,f erlaubt!');
         return(false);
      }
   }
   return(true);
}

function rechnen1()
{
   if (document.F.auswahl[0].checked)
   {
      if (pruef_wert())
      {
         wert_proz();
         wert_hex();
      }
      else return(false);
   }
   else
      if (document.F.auswahl[1].checked)
      {
         if (pruef_proz(0))
         {
            proz_wert();
            wert_hex();
         }
         else return(false);
     }
     else
     {
        if (pruef_hex())
        {
           hex_wert();
           wert_proz();
        }
        else return(false);
     }
   return(true);
}

function rechnen()
{
   if (rechnen1())
   wechsel1();
}

function mehr_Farbe(rgb)
{
   var wertmw = parseInt(document.forms[0].elements[rgb].value)
   if (wertmw < 100) wertmw++;
      document.forms[0].elements[rgb].value = wertmw
   if (pruef_proz(1))
   {
      proz_wert();
      wert_hex();
      wechsel1();
   }
}

function weniger_Farbe(rgb)
{
   var wertmw = parseInt(document.forms[0].elements[rgb].value)
   if (wertmw > 0) wertmw--;
      document.forms[0].elements[rgb].value = wertmw
   if (pruef_proz(1))
   {
      proz_wert();
      wert_hex();
      wechsel1();
   }
}

function loeschen()
{
   for (var i=0; i<3; i++)
      document.forms[0].elements[i].value = "";
   for (i=4; i<7; i++)
      document.forms[0].elements[i].value = "";
   document.forms[0].elements[8].value = "";
}

function zeigen_pal()
{
   var Kette = '';
	Kette += '<TABLE BORDER="1" CELLSPACING="0" CELLPADDING="3" width=200 BGCOLOR="#FFFFFF"><TR><TD>';
   Kette += '<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">';
   for (var i=0; i<18; i++)
   {
      Kette += '<TR>';
      for (var j=0; j<13; j++)
      {
         if (i < 6)
            if (j < 6) k = 5;
				else k = 4;
         if ((i > 5) && (i < 12))
            if (j < 6) k = 2;
            else k = 3;
         if (i > 11)
            if (j < 6) k = 1;
            else k = 0;
         if (i < 6) l = 5 - i;
         if ((i > 5) && (i < 12)) l = i - 6;
         if (i > 11) l = 17 - i;
         if (j < 6) m = j;
         else m = 11 - j;

         if (j==12) { // grayscale!
           k  = l = m =  17-i;
           farb = "" + wert[k] + wert[l] + wert[m];
         } else {
           k *= 3;
           l *=3;
           m *=3;
           farb = "" + wert[k] + wert[l] + wert[m];
         }
         Kette += '<TD BGCOLOR="#' + farb + '">';
         Kette += '<A HREF="JavaScript:wechsel(' + k + ',' + l + ',' + m + ');" ';
			   Kette += 'onmouseover = "statusein(' + k + ',' + l + ',' + m + ');return(true);">';
         Kette += '<IMG SRC="pic/schwarz.gif" WIDTH=15 HEIGHT=18 BORDER=0 ALT=""></A></TD>';
      }
      Kette += '</TR>';
   }
   Kette += '</TABLE>';
	Kette += '</TD></TR></TABLE>';
	document.writeln(Kette);
   Kette = null;
}

function zeigen_form()
{
   var Kette = '';
	Kette += '<DIV id="resform"><FORM NAME="F">';
	Kette += '<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="5"><TR><TD>';
   Kette += '<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="1">';
   Kette += '<tr><td colspan=5><IMG SRC="pic/schwarz.gif" WIDTH=228 HEIGHT=0 BORDER=0 ALT=""></td></tr>'
   Kette += '<TR>';
   Kette += '<tr><td colspan=5><center><div id="preview">&nbsp;</div></center></td></tr>'
   Kette += '<TR>';
   Kette += '<TD>&nbsp;</TD>';
   Kette += '<TD ALIGN="CENTER" BGCOLOR="#FF0000">';
   Kette += '<A HREF="JavaScript:mehr_Farbe(4)" onmouseover = "status_mehr_weniger(1,0);return(true);">';
   Kette += '<IMG SRC="pic/oben.gif" WIDTH=15 HEIGHT=14 HSPACE=1 VSPACE=0 BORDER=0 ALT=""></A>';
   Kette += '<A HREF="JavaScript:weniger_Farbe(4)" onmouseover = "status_mehr_weniger(0,0);return(true);">';
   Kette += '<IMG SRC="pic/unten.gif" WIDTH=15 HEIGHT=14 HSPACE=1 VSPACE=0 BORDER=0 ALT=""></A>';
   Kette += '</TD>';
   Kette += '<TD ALIGN="CENTER" BGCOLOR="#00FF00">';
   Kette += '<A HREF="JavaScript:mehr_Farbe(5)" onmouseover = "status_mehr_weniger(1,1);return(true);">';
   Kette += '<IMG SRC="pic/oben.gif" WIDTH=15 HEIGHT=14 HSPACE=1 VSPACE=0 BORDER=0 ALT=""></A>';
   Kette += '<A HREF="JavaScript:weniger_Farbe(5)" onmouseover = "status_mehr_weniger(0,1);return(true);">';
   Kette += '<IMG SRC="pic/unten.gif" WIDTH=15 HEIGHT=14 HSPACE=1 VSPACE=0 BORDER=0 ALT=""></A>';
   Kette += '</TD>';
   Kette += '<TD ALIGN="CENTER" BGCOLOR="#0000FF">';
   Kette += '<A HREF="JavaScript:mehr_Farbe(6)" onmouseover = "status_mehr_weniger(1,2);return(true);">';
   Kette += '<IMG SRC="pic/oben.gif" WIDTH=15 HEIGHT=14 HSPACE=1 VSPACE=0 BORDER=0 ALT=""></A>';
   Kette += '<A HREF="JavaScript:weniger_Farbe(6)" onmouseover = "status_mehr_weniger(0,2);return(true);">';
   Kette += '<IMG SRC="pic/unten.gif" WIDTH=15 HEIGHT=14 HSPACE=1 VSPACE=0 BORDER=0 ALT=""></A>';
   Kette += '</TD>';
	 Kette += '<TD>&nbsp;</TD>';
   Kette += '</TR>';
   Kette += '<TR>';
   Kette += '<TD><FONT SIZE="2">RGB :</FONT></TD>';
   Kette += '<TD ALIGN="Center"><INPUT NAME="wert" TYPE="TEXT" SIZE="3" MAXLENGTH=3></TD>';
   Kette += '<TD ALIGN="Center"><INPUT NAME="wert" TYPE="TEXT" SIZE="3" MAXLENGTH=3></TD>';
   Kette += '<TD ALIGN="Center"><INPUT NAME="wert" TYPE="TEXT" SIZE="3" MAXLENGTH=3></TD>';
   Kette += '<TD ALIGN=CENTER><INPUT NAME="auswahl" TYPE="RADIO"></TD>';
   Kette += '</TR>';
   Kette += '<TR>';
   Kette += '<TD><FONT SIZE="2">RGB % :</FONT></TD>';
   Kette += '<TD ALIGN="Center"><INPUT NAME="proz" TYPE="TEXT" SIZE="3" MAXLENGTH=3></TD>';
   Kette += '<TD ALIGN="Center"><INPUT NAME="proz" TYPE="TEXT" SIZE="3" MAXLENGTH=3></TD>';
   Kette += '<TD ALIGN="Center"><INPUT NAME="proz" TYPE="TEXT" SIZE="3" MAXLENGTH=3></TD>';
   Kette += '<TD ALIGN=CENTER><INPUT NAME="auswahl" TYPE="RADIO"></TD>';
   Kette += '</TR>';
   Kette += '<TR>';
   Kette += '<TD><FONT SIZE="2">HEXA :</FONT></TD>';
   Kette += '<TD ALIGN=CENTER COLSPAN=3><INPUT id="hex" NAME="hex" TYPE="TEXT" SIZE="9" MAXLENGTH=6></TD>';
   Kette += '<TD ALIGN=CENTER><INPUT NAME="auswahl" TYPE="RADIO"></TD>';
   Kette += '</TR>';
   Kette += '<TR><TD COLSPAN="5" ALIGN="CENTER">';
   Kette += '<INPUT TYPE="BUTTON" METHOD="POST" VALUE="'+button_show+'" onclick="rechnen()">';
   Kette += '&nbsp;&nbsp;&nbsp;';
   Kette += '<INPUT TYPE="BUTTON" METHOD="POST" VALUE="'+button_trans+'" onclick="loeschen()">';
   Kette += '</TD></TR>';
   Kette += '</TABLE>';
	 Kette += '</TD></TR></TABLE>';
   Kette += '</FORM></DIV>';
   document.writeln(Kette);
   Kette = null;
}

var colorChoice = "#FF9900";
var clickCheck = "";

function changeColor(theElement)
{
	if (clickCheck == "")
	{
		clickCheck = "stop";
		theElement.style.color = document.getElementById("preview").style.backgroundColor;
		setTimeout("clickCheck = '';", 100);
	}
}




function changeBackgroundColor(theElement)
{
	if (clickCheck == "")
	{
		clickCheck = "stop";
		
		if ((theElement.id == "sideleft") || (theElement.id == "sideright")) {
		   if (theElement.id == "sideleft") {
		     theElement2 = document.getElementById("sideright");
		   } else {
		      theElement2 = document.getElementById("sideleft");
		   }
		   if (document.getElementById("hex").value == "") {
					theElement2.style.backgroundColor = "transparent";
			 } else {
					theElement2.style.backgroundColor = document.getElementById("preview").style.backgroundColor;
		   }
		}
		
		
		if (document.getElementById("hex").value == "") {
		  theElement.style.backgroundColor = "transparent";
		} else {
		  theElement.style.backgroundColor = document.getElementById("preview").style.backgroundColor;
		}
		setTimeout("clickCheck = '';", 100);
	}
}


function changeVoid()
{
	if (clickCheck == "")
	{
		clickCheck = "stop";
		
		setTimeout("clickCheck = '';", 100);
	}
}


function convertRGBToHex(theColor)
{

	var theRed = "";
	var theGreen = "";
	var theBlue = "";
	
	if (theColor.charAt(0) == "#") {
	  return theColor;
	}
	
	if (theColor.charAt(0) == "t") {
		  return theColor;
	}
	
	
	theColor = theColor.replace(/rgb\(/, "");
	theRed = parseInt(theColor).toString(16).toUpperCase();
		
	theColor = theColor.replace(/.*?,/, "");
	theGreen = parseInt(theColor).toString(16).toUpperCase();
		
	theColor = theColor.replace(/.*?,/, "");
	theBlue = parseInt(theColor).toString(16).toUpperCase();
	
	return "#" + addTrailingZero(theRed) + addTrailingZero(theGreen) + addTrailingZero(theBlue);	
}

function addTrailingZero(color) {
 
  return (color.length==1) ? "0" + color : color;  
}


function generateCSS()
{

  var defaultBgColor="#eeeeee";
  var defaultTextColor="#000000";
  var defaultLinkColor="#000000";
  var defaultHoverColor="#444444";
  var defaultbodyColor="#ffffff";
  
	var theCodeView = document.getElementById("codeView");
	var thePageView = document.getElementById("pageWidth");
	var theCodeField = document.getElementById("CSSCode");
	var theCodearea = document.getElementById("CSSarea");
	
	var sideleftBG = document.getElementById("sideleft").style.backgroundColor;
	if (sideleftBG == "") {	sideleftBG = defaultBgColor;	} else	{	sideleftBG = convertRGBToHex(sideleftBG);}	
	
	// top left cell
	var topleftBG = document.getElementById("topleft").style.backgroundColor;
	if (topleftBG == "") {	topleftBG = defaultBgColor;	} else	{	topleftBG = convertRGBToHex(topleftBG);}	
	
	var toplefttext = document.getElementById("toplefttext").style.color;
	if (toplefttext == "") {	toplefttext = defaultTextColor;	} else	{	toplefttext = convertRGBToHex(toplefttext);}	
	var topleftlink = document.getElementById("topleftlink").style.color;
	if (topleftlink == "") {	topleftlink = defaultLinkColor;	} else	{	topleftlink = convertRGBToHex(topleftlink);}	
	var toplefthover = document.getElementById("toplefthover").style.color;
	if (toplefthover == "") {	toplefthover = defaultHoverColor;	} else	{	toplefthover = convertRGBToHex(toplefthover);}	
	
	// top middle cell
	var topmiddleBG = document.getElementById("topmiddle").style.backgroundColor;
	if (topmiddleBG == "") {	topmiddleBG = defaultBgColor;	} else	{	topmiddleBG = convertRGBToHex(topmiddleBG);}	
	
	// top right cell
	var toprightBG = document.getElementById("topright").style.backgroundColor;
	if (toprightBG == "") {	toprightBG = defaultBgColor;	} else	{	toprightBG = convertRGBToHex(toprightBG);}	
	
	var toprighttext = document.getElementById("toprighttext").style.color;
	if (toprighttext == "") {	toprighttext = defaultTextColor;	} else	{	toprighttext = convertRGBToHex(toprighttext);}	
	var toprightlink = document.getElementById("toprightlink").style.color;
	if (toprightlink == "") {	toprightlink = defaultLinkColor;	} else	{	toprightlink = convertRGBToHex(toprightlink);}	
	var toprighthover = document.getElementById("toprighthover").style.color;
	if (toprighthover == "") {	toprighthover = defaultHoverColor;	} else	{	toprighthover = convertRGBToHex(toprighthover);}	
	
  // content
	var contentBG = document.getElementById("content").style.backgroundColor;
  if (contentBG == "") {	contentBG = defaultbodyColor;	} else	{	contentBG = convertRGBToHex(contentBG);}
 
  // border 
  var borderwidth = document.getElementById("content").style.borderBottomWidth;
	if (borderwidth == "") {	borderwidth = "2px";	}
  var borderstyle = document.getElementById("content").style.borderBottomStyle;
	if (borderstyle == "") {	borderstyle = "solid";	}
  var bordercolor = document.getElementById("content").style.borderBottomColor;
	if (bordercolor == "") {	bordercolor = "#555555";	} else	{	bordercolor = convertRGBToHex(bordercolor);}	
	
	// if no color is set we use the default color 
  var contenttext = document.getElementById("contenttext").style.color;
	if (contenttext == "") {	contenttext = defaultTextColor;	} else	{	contenttext = convertRGBToHex(contenttext);}	
	var contentlink = document.getElementById("contentlink").style.color;
	if (contentlink == "") {	contentlink = defaultLinkColor;	} else	{	contentlink = convertRGBToHex(contentlink);}	 	
	var contenthover = document.getElementById("contenthover").style.color;
	if (contenthover == "") {	contenthover = defaultHoverColor;	} else	{	contenthover = convertRGBToHex(contenthover);}		 	
 	var contentheader = document.getElementById("contentheader").style.color;
	if (contentheader == "") {	contentheader = defaultTextColor;	} else	{	contentheader = convertRGBToHex(contentheader);}	
	var contentfolder = document.getElementById("contentfolder.txt").style.color;
	if (contentfolder == "") {	contentfolder = defaultTextColor;	} else	{	contentfolder = convertRGBToHex(contentfolder);}	
	var contentcaption = document.getElementById("contentcaption").style.color;
	if (contentcaption == "") {	contentcaption = defaultTextColor;	} else	{	contentcaption = convertRGBToHex(contentcaption);}	
	var contenttips = document.getElementById("contenttips").style.color;
  if (contenttips == "") {	contenttips = defaultTextColor;	} else	{	contenttips = convertRGBToHex(contenttips);}		
	var contentopxa = document.getElementById("topxactive").style.color;
	if (contentopxa == "") {	contentopxa = defaultTextColor;	} else	{	contentopxa = convertRGBToHex(contentopxa);}	
	var contentopxb = document.getElementById("topxinactive").style.color;
	if (contentopxb == "") {	contentopxb = defaultTextColor;	} else	{	contentopxb = convertRGBToHex(contentopxb);}	
	
  // bottom left
	var bottomleftBG = document.getElementById("bottomleft").style.backgroundColor;
  if (bottomleftBG == "") {	bottomleftBG = defaultBgColor;	} else	{	bottomleftBG = convertRGBToHex(bottomleftBG);}	
	
 	var bottomlefttext = document.getElementById("bottomlefttext").style.color;
 	if (bottomlefttext == "") {	bottomlefttext = defaultTextColor;	} else	{	bottomlefttext = convertRGBToHex(bottomlefttext);}	
 	var bottomleftlink = document.getElementById("bottomleftlink").style.color;
 	if (bottomleftlink == "") {	bottomleftlink = defaultLinkColor;	} else	{	bottomleftlink = convertRGBToHex(bottomleftlink);}	
 	var bottomlefthover = document.getElementById("bottomlefthover").style.color;
 	if (bottomlefthover == "") {	bottomlefthover = defaultHoverColor;	} else	{	bottomlefthover = convertRGBToHex(bottomlefthover);}	

	// bottom middle
  var bottommiddleBG = document.getElementById("bottommiddle").style.backgroundColor;
   if (bottommiddleBG == "") {	bottommiddleBG = defaultBgColor;	} else	{	bottommiddleBG = convertRGBToHex(bottommiddleBG);}	
	
		var bottommiddletext = document.getElementById("bottommiddletext").style.color;
	 	if (bottommiddletext == "") {	bottommiddletext = defaultTextColor;	} else	{	bottommiddletext = convertRGBToHex(bottommiddletext);}	
	 	var bottommiddlelink = document.getElementById("bottommiddlelink").style.color;
	 	if (bottommiddlelink == "") {	bottommiddlelink = defaultLinkColor;	} else	{	bottommiddlelink = convertRGBToHex(bottommiddlelink);}	
	 	var bottommiddlehover = document.getElementById("bottommiddlehover").style.color;
	 	if (bottommiddlehover == "") {	bottommiddlehover = defaultHoverColor;	} else	{	bottommiddlehover = convertRGBToHex(bottommiddlehover);}	

	// bottom right
	var bottomrightBG = document.getElementById("bottomright").style.backgroundColor;
	  if (bottomrightBG == "") {	bottomrightBG = defaultBgColor;	} else	{	bottomrightBG = convertRGBToHex(bottomrightBG);}	
	
		var bottomrighttext = document.getElementById("bottomrighttext").style.color;
		if (bottomrighttext == "") {	bottomrighttext = defaultTextColor;	} else	{	bottomrighttext = convertRGBToHex(bottomrighttext);}	
		var bottomrightlink = document.getElementById("bottomrightlink").style.color;
		if (bottomrightlink == "") {	bottomrightlink = defaultLinkColor;	} else	{	bottomrightlink = convertRGBToHex(bottomrightlink);}	
		var bottomrighthover = document.getElementById("bottomrighthover").style.color;
		if (bottomrighthover == "") {	bottomrighthover = defaultHoverColor;	} else	{	bottomrighthover = convertRGBToHex(bottomrighthover);}	
	
	var codeString = "";
	

	// body 
	codeString += "body.twg {\n";
	codeString += "  background-color: " + contentBG + "\;\n"
	codeString += "  color: " + contenttext + "\;";
	codeString += "\n}\n";
	codeString += "a:link {   color: " + contentlink + "\; }\n";
	codeString += "a:visited {   color: " + contentlink + "\; }\n";
	codeString += "a:hover {   color: " + contenthover + "\; }\n";

	// main table
	codeString += "table.twg {\n";
	// codeString += "  background-color: " + contentBG + "\;\n"
	codeString += "  color: " + contenttext + "\;";
	codeString += "\n}\n";
		
	if (contentBG != "transparent") {
	  codeString += "\n/* If you use an background image this hover settings could create ugly borders! Delete them if you don't like them */";
	  codeString += "\ntd.navicon a img{	border: 1px solid " + contentBG + ";	}";
		codeString += "\ntd.html_side_default a img{	border: 1px solid " + contentBG + "; }	";
		codeString += "\ntd.html_side_left a img{ border: 1px solid " + contentBG + "; } ";
		codeString += "\ntd.html_side_right a img{ border: 1px solid " + contentBG + "; } \n";	  
	}
	
		
	// sides
	codeString += "\ntd.sideframe {\n";
	codeString += "  background-color: " + sideleftBG + "\;"
	codeString += "\n}\n";
	
  // content if no round corners are used.
  codeString += "\ntd.twg_info, #twg_content_div {\n";
	codeString += "  border: " + borderwidth + " " + borderstyle + " " + bordercolor + "\;";
	codeString += "\n}\n";

  // content - background for the part in the corners
	codeString += "\ntd.twg_info {\n";
	codeString += "  background-color: " + sideleftBG + "\;"
  codeString += "\n}\n";

  // content - background for the inter parts if a corner exists.
	codeString += "\n#twg_content_div {\n";
	codeString += "  background-color: " + contentBG + "\;"
  codeString += "\n}\n";

	// header
	codeString += "\n.twg_title {\n";
	codeString += "  color: " + contentheader + "\;"
	codeString += "\n}\n";
	
	// .twg_folderdescription
	codeString += "\n.twg_folderdescription {\n";
	codeString += "  color: " + contentfolder + "\;"
	codeString += "\n}\n";
		
	// caption
	codeString += "\n.twg_Caption {\n";
	codeString += "  color: " + contentcaption + "\;"
	codeString += "\n}\n";
	
	// tips
	codeString += "\n.twg_user_help_td {\n";
	codeString += "  color: " + contenttips + "\;"
	codeString += "\n}\n";
	
	// topx
  codeString += "\n.twg_topx_selected {\n";
	codeString += "  color: " + contentopxa + "\;"
	codeString += "\n}\n";
  codeString += "\n.twg_topx_sel {\n";
	codeString += "  color: " + contenttext + "\;"
	codeString += "\n}\n";
  codeString += ".twg_topx_sel a:link {   color: " + contentopxb + "\; }\n";
	codeString += ".twg_topx_sel a:visited {   color: " + contentopxb + "\; }\n";
	codeString += ".twg_topx_sel a:hover {   color: " + contenthover + "\; }\n";
	
	// topleft!
	codeString += "\ntd.topnavleft {\n";
	codeString += "  background-color: " + topleftBG + "\;\n"
	codeString += "  color: " + toplefttext + "\;";
	codeString += "\n}\n";
	codeString += "td.topnavleft a:link {   color: " + topleftlink + "\; }\n";
	codeString += "td.topnavleft a:visited {   color: " + topleftlink + "\; }\n";
	codeString += "td.topnavleft a:hover {   color: " + toplefthover + "\; }\n";

  // top middle
	codeString += "\ntd.topnav {\n";
	codeString += "  background-color: " + topmiddleBG + "\;"
	codeString += "\n}\n";
	
  // topright!
	codeString += "\ntd.topnavright {\n";
	codeString += "  background-color: " + toprightBG + "\;\n"
	codeString += "  color: " + toprighttext + "\;";
	codeString += "\n}\n";
	codeString += "td.topnavright a:link {   color: " + toprightlink + "\; }\n";
	codeString += "td.topnavright a:visited {   color: " + toprightlink + "\; }\n";
	codeString += "td.topnavright a:hover {   color: " + toprighthover + "\; }\n";
	
	// bottomleft!
	codeString += "\ntd.bottomtablesideleft {\n";
	codeString += "  background-color: " + bottomleftBG + "\;\n"
	codeString += "  color: " + bottomlefttext + "\;";
	codeString += "\n}\n";
	codeString += "td.bottomtablesideleft a:link {   color: " + bottomleftlink + "\; }\n";
	codeString += "td.bottomtablesideleft a:visited {   color: " + bottomleftlink + "\; }\n";
	codeString += "td.bottomtablesideleft a:hover {   color: " + bottomlefthover + "\; }\n";

	// bottom middle
	codeString += "\ntd.bottomtable {\n";
	codeString += "  background-color: " + bottommiddleBG + "\;"
	codeString += "\n}\n";
	
	// bottom - this cell holds the three bottom tables - only visible if the bottom rows are too small!
	codeString += "\ntd.twg_bottom {\n";
	codeString += "  background-color: " + bottommiddleBG + "\;"
	codeString += "\n}\n";
	
	// twg_counterpixel this is a small line needed to measure some stuff in twg - is located between the main content and the bottom rows
	codeString += "\ntd.twg_counterpixel {\n";
	codeString += "  background-color: " + bottommiddleBG + "\;"
	codeString += "\n}\n";

	// bottomright!
	codeString += "\ntd.bottomtableside {\n";
	codeString += "  background-color: " + bottomrightBG + "\;\n"
	codeString += "  color: " + bottomrighttext + "\;";
	codeString += "\n}\n";
	codeString += "td.bottomtableside a:link {   color: " + bottomrightlink + "\; }\n";
	codeString += "td.bottomtableside a:visited {   color: " + bottomrightlink + "\; }\n";
	codeString += "td.bottomtableside a:hover {   color: " + bottomrighthover + "\; }\n";
	
	// theCodeField.innerHTML = codeString;
	document.getElementById("cssarea").value = codeString;
	
	thePageView.style.display = "none";	
	theCodeView.style.display = "block";
	
	return true;
}

function goBackPage()
{
	var theCodeView = document.getElementById("codeView");
	var thePageView = document.getElementById("pageWidth");

	theCodeView.style.display = "none";	
	thePageView.style.display = "block";
	
	return true;
}

var border=false;

function changeBorder() {
  if (border) {
  document.getElementById("sideleft").style.borderStyle="none";
  document.getElementById("sideright").style.borderStyle="none";
  document.getElementById("topleft").style.borderStyle="none";
  document.getElementById("topmiddle").style.borderStyle="none";
  document.getElementById("topright").style.borderStyle="none";
  document.getElementById("bottomleft").style.borderStyle="none";
	document.getElementById("bottommiddle").style.borderStyle="none";
	document.getElementById("bottomright").style.borderStyle="none";
	document.getElementById("button_cells").value=showcells;
  border = false;
  } else {
  document.getElementById("sideleft").style.borderWidth="1px";
  document.getElementById("sideright").style.borderWidth="1px";
  document.getElementById("topleft").style.borderWidth="1px";
	document.getElementById("topmiddle").style.borderWidth="1px";
	document.getElementById("topright").style.borderWidth="1px";
	document.getElementById("bottomleft").style.borderWidth="1px";
  document.getElementById("bottommiddle").style.borderWidth="1px";
	document.getElementById("bottomright").style.borderWidth="1px";
	document.getElementById("sideleft").style.borderStyle="dotted";
	document.getElementById("sideright").style.borderStyle="dotted";
	document.getElementById("topleft").style.borderStyle="dotted";
	document.getElementById("topmiddle").style.borderStyle="dotted";
	document.getElementById("topright").style.borderStyle="dotted";
	document.getElementById("bottomleft").style.borderStyle="dotted";
	document.getElementById("bottommiddle").style.borderStyle="dotted";
	document.getElementById("bottomright").style.borderStyle="dotted";
	document.getElementById("button_cells").value=hidecells;
  border = true;
  }
  
}

function changeBgImage(value) {
value++;
var picture = "pic/bg" + value + ".jpg";
document.getElementById("pageWidth").style.backgroundImage= "url(" + picture + ")";
}

function changeBorderStyle() {
value = document.getElementById("bstyle").selectedIndex;

var bordercolor = document.getElementById("bordercolor").style.backgroundColor;
  if (bordercolor == "") {	bordercolor = "#555555";	} else	{	bordercolor = convertRGBToHex(bordercolor);}
document.getElementById("content").style.borderColor=bordercolor;

switch (value) {
  case 0:
    mystyle = "none"; mywidth = "0px"; break;
  case 1:
    mystyle = "solid"; mywidth = "1px"; break;
  case 3:
    mystyle = "ridge"; mywidth = "1px"; break;
  case 4:
    mystyle = "solid"; mywidth = "2px"; break;
  case 6:
	  mystyle = "ridge"; mywidth = "2px"; break;
	case 7:
    mystyle = "groove"; mywidth = "2px"; break;
  case 8:
    mystyle = "outset"; mywidth = "2px"; break;
  case 9:
	  mystyle = "ridge"; mywidth = "3px"; break;
	case 10:
    mystyle = "groove"; mywidth = "3px"; break;
  default:
    mystyle = "solid"; mywidth = "1px"; break;
}

document.getElementById("content").style.borderStyle=mystyle;
document.getElementById("content").style.borderWidth=mywidth;
}

var myConnB;

function storeCss(token) {

if (confirm(picker_save)) {
	var wert = document.getElementById('cssarea').value;
	if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
		if (!myConnB) { 
			alert(picker_con);
			return;
		}
	var fnWhenDoneC = function (coXML) { result(coXML.responseText); };
	myConnB.connect( "index.php" , fnWhenDoneC, "token="+token+"&action=storecss&value=" + wert);
	}
}

function result(result) {
  switch (result) {
    case 'NO_ERROR': 
      alert(no_error);
      break;
    case 'ERROR_COPY':
      alert(error_copy);
      break;
    case 'ERROR_OPEN':
		  alert(error_open);
      break;
    case 'ERROR_STORE':
			alert(error_store);
      break;
    case 'ERROR_CLOSE':
			alert(error_close);
      break;
    default: 
      alert(error_def);
      break;
  }
}






