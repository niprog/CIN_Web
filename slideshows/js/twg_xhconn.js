/** XHConn - Simple XMLHTTP Interface - bfults@gmail.com - 2005-04-01        **
 ** Code licensed under Creative Commons Attribution-ShareAlike License      **
 ** http://creativecommons.org/licenses/by-sa/2.0/                           **/
var myConnB = null;

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
