<?php
// Creates all the language strings that are included in javascript files!
echo '

function unescapeHTML(myhtml) {
    var div = document.createElement("div");
    div.innerHTML = myhtml;
    return div.childNodes[0] ? div.childNodes[0].nodeValue : "";
}

var errdef =  unescapeHTML("' . $GLOBALS["js_messages"]["errdef"] . '");
var text_save =  unescapeHTML("' . $GLOBALS["js_messages"]["text_save"] . '");
var admin_semicolon =  unescapeHTML("' . $GLOBALS["js_messages"]["admin_semicolon"] . '");
var admin_missing =  unescapeHTML("' . $GLOBALS["js_messages"]["admin_missing"] . '");
var admin_line_start =  unescapeHTML("' . $GLOBALS["js_messages"]["admin_line_start"] . '");
var admin_brackets =  unescapeHTML("' . $GLOBALS["js_messages"]["admin_brackets"] . '");
var admin_brackets2 =  unescapeHTML("' . $GLOBALS["js_messages"]["admin_brackets2"] . '");
var admin_bracketsx =  unescapeHTML("' . $GLOBALS["js_messages"]["admin_bracketsx"] . '");
var admin_anfzeichen =  unescapeHTML("' . $GLOBALS["js_messages"]["admin_anfzeichen"] . '");
var admin_number =  unescapeHTML("' . $GLOBALS["js_messages"]["admin_number"] . '");
var admin_0 =  unescapeHTML("' . $GLOBALS["js_messages"]["admin_0"] . '");
var admin_nurnum =  unescapeHTML("' . $GLOBALS["js_messages"]["admin_nurnum"] . '");
var picker_save =  unescapeHTML("' . $GLOBALS["js_messages"]["picker_save"] . '");
var picker_con =  unescapeHTML("' . $GLOBALS["js_messages"]["picker_con"] . '");
var no_error =  unescapeHTML("' . $GLOBALS["js_messages"]["no_error"] . '");
var error_copy =  unescapeHTML("' . $GLOBALS["js_messages"]["error_copy"] . '");
var error_open =  unescapeHTML("' . $GLOBALS["js_messages"]["error_open"] . '");
var error_store =  unescapeHTML("' . $GLOBALS["js_messages"]["error_store"] . '");
var error_close =  unescapeHTML("' . $GLOBALS["js_messages"]["error_close"] . '");
var error_def =  unescapeHTML("' . $GLOBALS["js_messages"]["error_def"] . '");
var button_show =  unescapeHTML("' . $GLOBALS["js_messages"]["button_show"] . '");
var button_trans =  unescapeHTML("' . $GLOBALS["js_messages"]["button_trans"] . '");
var showcells =  unescapeHTML("' . $GLOBALS["js_messages"]["showcells"] . '");
var hidecells =  unescapeHTML("' . $GLOBALS["js_messages"]["hidecells"] . '");
';
?>