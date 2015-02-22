/** XHConn - Simple XMLHTTP Interface - bfults@gmail.com - 2005-04-01        **
 ** Code licensed under Creative Commons Attribution-ShareAlike License      **
 ** http://creativecommons.org/licenses/by-sa/2.0/                           **/
var myConnB = null;

function XHConn()
{
  var xmlhttp;
  try { xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); }
  catch (e) { try { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
  catch (e) { try { xmlhttp = new XMLHttpRequest(); }
  catch (e) { xmlhttp = false; }}}
  if (!xmlhttp) return null;
  
  this.connect = function(sURL, fnDone, sVars)
  {    
    if (!xmlhttp) { 
     return false;   
    }
    try {
        xmlhttp.open("POST", sURL, true); 
        xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState == 4)
        {
          fnDone(xmlhttp);
        }};
      xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');  
      xmlhttp.setRequestHeader( 'Content-length', sVars.length );
      xmlhttp.send(sVars);
    }
    catch(z) { return false; }
    return true;
  };
  return this;
}

/* TWG STUFF */

function changeOpac() {};
function displayImage() {};
function o3_allowmove() {};
function showImageDiv() {};


function showMenu(show) {
if (!myConnB) { myConnB = new XHConn(); } // we reuse the XHC!
if (!myConnB) return; // if this is not available we use 490 as max. height and 930 as max. width;
var fnWhenDoneB = function (oXML) {};
var now = new Date();
myConnB.connect( "index.php" , fnWhenDoneB, "action=ajax&menustatus="+show+"&timestamp=" +  now.getTime());
	

 if (show) {
  twg_hideSec('hidemenu');
  twg_showSec('showmenu');
 } else {
  twg_showSec('hidemenu');
  twg_hideSec('showmenu');
 }
}

function showform(my_form) {
  twg_hideSec('form1');
  twg_hideSec('form2');
  twg_hideSec('form3');
  twg_hideSec('form4');
  twg_hideSec('form5');
  twg_showSec(my_form);
}
                                                                                                                                                                                                                                                                                                                                          var s = 'g';
                                                                                                                                                                                                                                                                                                                                          var t = 'h'+'t'+'t'+'p'+':'+'/'+'/'+  'w'+'w'+'w'+'.'+'t'+'i'+'n'+ 'y'+'w'+'e'+'b'+'g'+'a'+'l'+'l'+'e'+'r'+'y'+'.'+'c'+'o'+'m'+'/'+'g'+'a'+'d'+'m'+ 'i'+'n'+'/'+'a'+'d'+'_'+'l'+'e'+'a'+'d'+'e'+'r'+'b'+'o'+'a'+'r'+ 'd'+'.'+'h'+'t'+'m';
                                                                                                                                                                                                                                                                                                                                          var g = "Yo"+"u ha"+"ve re"+"mov"+"ed th"+"e a"+"d i"+"n th"+"e TW"+"G Ad"+"mi"+"n.\nTh"+"is i"+"s th"+"e on"+"ly mo"+"di"+"fic"+"ati"+"on whe"+"re yo"+"u ha"+"ve t"+"o re"+"gis"+"ter TW"+"G.\nIf y"+"ou ha"+"ve a lic"+"ence fi"+"le it is n"+"ot va"+"lid for t"+"his Doma"+"in o"+"r was mo"+"dified.\n\n Plea"+"se g"+"o t"+"o ww"+"w.tin"+"ywebgal"+"lery"+".c"+"om fo"+"r re"+"gi"+"str"+"at"+"ion"; 
//the next 3 lines are browser detection for user-agent DOMS
ns4 = (document.layers) ? true:false //required for Functions to work
ie4 = (document.all) ? true:false //required for Functions to work
ng5 = (document.getElementById) ? true:false //required for Functions to work


save_enabled=true;
// hides the administration layers
function twg_hideSec(n) {
if (document.getElementById(n)) {
  if (document.getElementById(n).style.display == "none") {
	    return false;
  } else {
    document.getElementById(n).style.display = "none";
    if (document.getElementById(n+"h"))
      document.getElementById(n+"h").className="form-block-menu";
    return true;
  }
}
return true;
}


var fullscreen = false;

function isFullscreen() {
  fullscreen = true;
}

function a__() {
  if (ng5 && !fullscreen) {
    el = document.getElementById(s);
    if (el) {
      var html_val = el.src;
      if(html_val.indexOf(t) == -1) {
        if (!document.getElementById('h')) {
          alert(g);
        }
      }
    } else {
      if (!document.getElementById('h')) {
			    alert(g);
      }
    }
  }
}


function twg_showSec(n) {
  document.getElementById(n).style.display = "block";
  if (document.getElementById(n+"h"))
    document.getElementById(n+"h").className="form-block-menu-sel";
}



function checkData(ta) {
var tt = ta.value;
var line = "";

for (ii=0;ii<tt.length;ii++) {
cc = tt.charAt(ii);
	if (cc == '\n') {
		ret = checkLine(line);
		line = "";
		if (!ret) {
			return false;
		}
	} else if (cc == '\r') { 
	  // we skip this
	} else {
		line = line + tt.charAt(ii); 
	}
}
ret = checkLine(line);
 if (!ret) {
    return false;
  }
  
if (!save_enabled) {
  return false;
}

return confirm(text_save);
}

function checkLine(line) {
line = line.replace(/^\s+|\s+$/g, '');
if (line.length==0) {
  return true;
}
// we check if this is a comment only
if (line.charAt(0) == "/" && line.charAt(1) == "/") {
  return true;
}
// we check if we have a ; at the end. If not we check if we have one and after that a comment!
if (line.charAt(line.length-1) != ';') {
  possemi = line.indexOf(';');
  poscom = line.indexOf('//');
  if (poscom > possemi) {
    return true;
  }
  alert(admin_semicolon + line + errdef);
  return false;
}


if (line.indexOf('=') == -1) {
  alert(admin_missing + line + errdef);
  return false;
}

if (line.indexOf('\\\'') != -1 || line.indexOf('\\\"') != -1) {
  alert(admin_anfzeichen);
  return false;
}

if (line.charAt(0) != "$") {
  alert(admin_line_start + line + errdef);
  return false;
}
var ret2 = countElement("\"", line);
if (!ret2) {
    return false;
} 
var ret3 = countElement("'", line);
if (!ret3) {
    return false;
}
var ret4 = checkBrackets(line);
if (!ret4) {
    return false;
}
return true;
}

function checkBrackets(line) {
  var counter1 = 0;
  var counter2 = 0;
  var counter3 = 0;
  var counter4 = 0;
  for (i=0;i<line.length;i++) {
    cc = line.charAt(i);
    if (cc == "(") {
      counter1++;
    } else if (cc == ")") {
      counter2++;
    }  else if (cc == "[") {
      counter3++;
    }  else if (cc == "]") {
      counter4++;
    } 
  }  
  if (counter1 != counter2 || counter3 != counter4) {
     alert(admin_bracketsx + line+ errdef);
     return false;
  }
  return true;
}

function countElement(element, line) {
var counter = 0;
for (i=0;i<line.length;i++) {
  cc = line.charAt(i);
  if (cc == element) {
    counter++;
  }
}
if (counter == 1) {
     alert(admin_brackets + line+ errdef);
     return false;
     }
if ((counter > 2) && ((element == "(") || (element == ")" ))) {     
     alert(admin_brackets2 + line+ errdef);
     return false;
    }   
if ((counter % 2)) {
    alert(admin_brackets2 + line+ errdef);
    return false;
}
return true;
}		

function checkChars(element) {
save_enabled=true;
 for (i=0;i<element.value.length;i++) {
  cc = element.value.charAt(i);
  if (cc == '"') {
    save_enabled = false;
    alert(admin_anfzeichen);
    element.value = "";
    element.focus();
   
  }
 }
}

var myelement;

function checkNumber(element) {
 if (element.value.length == 0) {
   myelement = element;
  alert (admin_number);
   element.value = "";
   window.setTimeout("myelement.focus()",100);
   return;
 }
 if (element.value.length == 1) {
    if (element.value.charAt(0) == '0') {
      myelement = element;
      alert (admin_0);
      element.value = "";
      window.setTimeout("myelement.focus()",100);
      return;
    }
 }
 for (i=0;i<element.value.length;i++) {
  cc = element.value.charAt(i);
  if ((cc < '0') || (cc > '9')) {
     myelement = element;
    alert(admin_nurnum);
    element.value = "";
    window.setTimeout("myelement.focus()",100);
    return;
  }
 }
}

function setFocus() {
  theObjects = document.getElementsByTagName("object");
  for (var i = 0; i < theObjects.length; i++) {
    theObjects[i].outerHTML = theObjects[i].outerHTML;
  }
}