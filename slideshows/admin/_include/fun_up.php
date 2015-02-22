<?php

defined('_VALID_TWG') or die('Direct Access to this location is not allowed.');
function upload_items($dir)
{
  global $basedir, $enter_caption_at_upload;
  // include("_lib/exifWriter.inc");
  if (!isset($GLOBALS["nr_uploads"])) {
    $GLOBALS["nr_uploads"] = 10;
  }
  if (!isset($GLOBALS["default_upload_method"])) {
	  $GLOBALS["default_upload_method"] = "flash"; // other value is html
	}


	// if menu we make default to a picture
  if (isset($GLOBALS['__GET']["menu"]) && ($GLOBALS["home_dir"] == "../." || $GLOBALS["home_dir"] == ".././")) {
	  $dir =  $basedir;
	}
	
  $tfu_dir = get_abs_dir_tfu($dir);
  $_SESSION["tfu_upload_dir"] = $tfu_dir;
  $_SESSION["TFU_LOGIN"] = "true"; // login for uploader !! 
  unset($_SESSION["TFU_LOGIN_FRONTEND"]); // no frontend settings
  fixSession();
  // important to get a update of the session variables if the session workaround is used.
  store_temp_twg_session();

  global $small_pic_size;
  $okup = 0;

  if(($GLOBALS["permissions"]&01) != 01) show_error($GLOBALS["error_msg"]["accessfunc"]);
  if(isset($GLOBALS['__POST']["confirm"]) && $GLOBALS['__POST']["confirm"] == "true"){
    $cnt = count($GLOBALS['__FILES']['userfile']['name']);
    $err = false;
    $err_avaliable = isset($GLOBALS['__FILES']['userfile']['error']);
    $_SESSION["lastuploadsize"] = $GLOBALS["twgsize"];
    for($i = 0;$i < $cnt;$i++){
      $errors[$i] = null;
      $tmp = $GLOBALS['__FILES']['userfile']['tmp_name'][$i];
      $items[$i] = stripslashes($GLOBALS['__FILES']['userfile']['name'][$i]);
      if($err_avaliable) $up_err = $GLOBALS['__FILES']['userfile']['error'][$i];
      else $up_err = (file_exists($tmp)?0:4);
      $abs = get_abs_item($dir, $items[$i]);

      if($items[$i] == "" || $up_err == 4) continue;
      if($up_err == 1 || $up_err == 2){
        $errors[$i] = $GLOBALS["error_msg"]["miscfilesize"];
        $err = true;
        continue;
      }
      if($up_err == 3){
        $errors[$i] = $GLOBALS["error_msg"]["miscfilepart"];
        $err = true;
        continue;
      }
      if($up_err == 6){
        $errors[$i] = $GLOBALS["error_msg"]["missingtemp"];
        $err = true;
        continue;
      }
      if(!@is_uploaded_file($tmp)){
        $errors[$i] = $GLOBALS["error_msg"]["isuploadfile"];
        $err = true;
        continue;
      }
      if(@file_exists($abs)){
        $errors[$i] = $GLOBALS["error_msg"]["itemdoesexist"];
        $err = true;
        continue;
      }
      if (preg_match("/.*\.(j|J)(p|P)(e|E){0,1}(g|G)$/", $items[$i])){
        resize_file($tmp, $GLOBALS["twgsize"], $GLOBALS["twgquality"]);
      }
      if(function_exists("move_uploaded_file")){
        $ok = @move_uploaded_file($tmp, $abs);
      }else{
        $ok = @copy($tmp, $abs);
        @unlink($tmp); // try to delete...
      }

      if($ok === false){
        $errors[$i] = $GLOBALS["error_msg"]["uploadfile"];
        $err = true;
        continue;
      }else{
        if(is_chmodable($abs)){
          @chmod($abs, 0755);
        }
      }
      $okup++;
    }

    if($err){ // there were errors
      $err_msg = "";
      for($i = 0;$i < $cnt;$i++){
        if($errors[$i] == null) continue;
        $err_msg .= $items[$i] . " : " . $errors[$i] . "<BR>\n";
      }
      show_error($err_msg);
    }
    $_SESSION["user_msg"] = sprintf($GLOBALS['messages']['success_upload_file'], $okup);
    header("Location: " . make_link("list", $dir, null));
    return;
  }

  show_menu();
  show_header($GLOBALS["messages"]["actupload"], true);
  if (isset($_SESSION["lastuploadsize"])){
    $defaultsize = $_SESSION["lastuploadsize"];
  }else{
    $defaultsize = "not set";
  }
  echo " to: '" . $dir . "'";
  echo "</td><td class=\"title\" align=\"right\">";
  echo $GLOBALS['messages']["up_max_size"];
  $limit = return_bytes(ini_get('upload_max_filesize'));
  if (!$limit){
    echo '<b><font color="orange">' . $GLOBALS["messages"]["up_not_detected"] .'</font></b>';
  }else{
    echo '<b>' . ini_get('upload_max_filesize') . '</b>';
  }

  if  ($GLOBALS["default_upload_method"] == "flash") {
    $showFlash = "block";
    $showHtml = "none";
  } else {
    $showFlash = "none";
    $showHtml = "block";
  }

  echo "<img src=\"_img/_.gif\" alt=\"\"width=5></td>";
  echo "</tr></tbody></table>\n\n";
  echo '<div id="ctr" align="center">
				<div class="install round_borders">
	<div class="clr"></div><br/>';
  echo "<div id='swf_form' style='display:" . $showFlash . ";'>";

  $ses_path="session_id=" . session_id(); 

  echo '
  <script type="text/javascript" src="../js/swfobject.js"></script>
	<div id="flashcontent"></div>
	<script type="text/javascript">
	   function debugError(errorString) { }
	   
	   var so = new SWFObject("upload/tfu_3.2.swf?base=upload/&lang='.$GLOBALS["lang"]."&".$ses_path.'", "mymovie", "650", "340", "8", "#ffffff");
	   so.addParam("scale","noScale");
     so.addParam("allowfullscreen","true");
     ';  
     if ($enter_caption_at_upload == 'true') {
       echo 'so.addVariable("tfu_description_mode","true");';
     }
     echo '
     so.write("flashcontent");
	</script>
	<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="650" height="340"  align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="movie" value="upload/tfu_3.2.swf?base=upload/&lang='.$GLOBALS["lang"]."&amp;".$ses_path.'" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><param name="scale" value="noScale" /><param name="allowfullscreen" value="true" /><embed src="upload/tfu_3.2.swf?base=upload/&lang='.$GLOBALS["lang"]."&amp;".$ses_path.'" quality="high" bgcolor="#ffffff" width="650" height="340" align="middle" allowScriptAccess="sameDomain" scale="noScale" allowfullscreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>
';
   echo "<br/>&nbsp;<br/>";

  echo "
  <input type=\"button\" value=\"" . $GLOBALS["messages"]["btnback"];
  echo "\" onClick=\"javascript:location='" . make_link("list", $dir, null) . "';\">\n
  ";
  echo "<br/>&nbsp;<br/>" . sprintf($GLOBALS["messages"]["up_flash"],"<b><a onClick=\"javascript:document.getElementById('html_form').style.display='block'; document.getElementById('swf_form').style.display='none';\" href='#'>", "</a></b>" );
  echo "</div>";
  echo "<div id='html_form' style='display:".$showHtml.";'>";
  echo "<br><form enctype=\"multipart/form-data\" action=\"" . make_link("upload", $dir, null);
  echo "\" method=\"post\">\n";
  echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n"; 
  echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"";
  echo get_max_file_size() . "\"><input type=\"hidden\" name=\"confirm\" value=\"true\"><TABLE summary=''>\n";
  for($i = 0;$i < $GLOBALS["nr_uploads"];$i++){
    echo "<tr><td nowrap colspan=2 align=\"center\">";
    echo "<input name=\"userfile[]\" type=\"file\" size=\"40\"></td></tr>\n";
  }
  echo "<tr><td colspan=2>&nbsp;</td>";
  echo "<tr><td align=\"right\">";
  echo $GLOBALS["messages"]["up_max"];
  echo "</td><td align=\"right\">";
  echo "<select name=\"twgsize\">";
  if (!isset($GLOBALS["uploadsizes"])){
    $GLOBALS["uploadsizes"] = array("100000" => "Original", "1400" => "1400", "1280" => "1280",
      "1024" => "1024", "800" => "800", "640" => "640", ($small_pic_size . "") => "TWG (" . $small_pic_size . ")"
      );
  }

  foreach ($GLOBALS["uploadsizes"] as $value => $text){
    if ($value == $defaultsize){
      echo "<option selected value=" . $value . ">" . $text . "</option>";
    }else{
      echo "<option value=" . $value . ">" . $text . "</option>";
    }
  }
  echo "</select>";
  if (!isset($GLOBALS["uploadquality"])){
    echo "</td></tr><tr><td align=\"right\">";
    echo $GLOBALS["messages"]["up_quality"];
    echo "</td><td align=\"right\">";
    echo "<select name=\"twgquality\">";
    echo "<option value=100>100</option>";
    echo "<option value=95>95</option>";
    echo "<option value=90>90</option>";
    echo "<option value=85>85</option>";
    echo "<option selected value=80>80</option>";
    echo "<option value=75>75</option>";
    echo "<option value=70>70</option>";
    echo "<option value=60>60</option>";
    echo "<option value=50>50</option>";
  }else{
    echo "<input type=\"hidden\" name=\"twgquality\" value=\"" . $GLOBALS["uploadquality"] . "\">";
  }
  echo "</td></tr></table>";
  echo "<table summary=''><tr><td><input type=\"submit\" value=\"" . $GLOBALS["messages"]["btnupload"];
  echo "\"></td>\n<td><input type=\"button\" value=\"" . $GLOBALS["messages"]["btnback"];
  echo "\" onClick=\"javascript:location='" . make_link("list", $dir, null) . "';\">\n</td></tr></table></form>";
  echo "<br/>&nbsp;<br/>" . sprintf($GLOBALS["messages"]["up_html"], "<b><a onClick=\"javascript:document.getElementById('html_form').style.display='none';document.getElementById('swf_form').style.display='block';\" href='#'>") . "</a></b>.";
  echo "</div>";
  echo "<br></div></div>\n";
  // echo "<script type='text/javascript'>setFocus();</script>";
  return;
}

?>
