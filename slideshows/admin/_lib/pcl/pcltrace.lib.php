<?php
// --------------------------------------------------------------------------------
// PhpConcept Library (PCL) Trace 1.0
// --------------------------------------------------------------------------------
// License GNU/GPL - Vincent Blavet - Janvier 2001
// http://www.phpconcept.net & http://phpconcept.free.fr
// --------------------------------------------------------------------------------
// Fran�ais :
//	La description de l'usage de la librairie PCL Trace 1.0 n'est pas encore
//	disponible. Celle-ci n'est pour le moment distribu�e qu'avec l'application
//	et la librairie PhpZip.
//	Une version ind�pendante sera bientot disponible sur http://www.phpconcept.net
//
// English :
//	The PCL Trace 1.0 library description is not available yet. This library is
//	released only with PhpZip application and library.
//	An independant release will be soon available on http://www.phpconcept.net
//
//  ALL COMMENTS ARE REMOVED TO MAKE THIS LIBRATY SMALLER PLEASE GO TO THE 
//  ORIGINAL FILE IF YOU NEED THIS !
defined('_VALID_TWG') or die('Restricted access');
if (!defined("PCLTRACE_LIB")){
  define("PCLTRACE_LIB", 1);
  $g_pcl_trace_version = "1.0";
  $g_pcl_trace_mode = "memory";
  $g_pcl_trace_filename = "trace.txt";
  $g_pcl_trace_name = array();
  $g_pcl_trace_index = 0;
  $g_pcl_trace_level = 1;
  function TrOn($p_level = 1, $p_mode = "memory", $p_filename = "trace.txt")
  {
    global $g_pcl_trace_level;
    global $g_pcl_trace_mode;
    global $g_pcl_trace_filename;
    global $g_pcl_trace_name;
    global $g_pcl_trace_index;
    global $g_pcl_trace_entries;
    $g_pcl_trace_level = $p_level;
    switch ($p_mode){
    case "normal" :
    case "memory" :
    case "log" :
      $g_pcl_trace_mode = $p_mode;
      break;
    default :
      $g_pcl_trace_mode = "logged";
    }
    $g_pcl_trace_filename = $p_filename;
  }
  function IsTrOn()
  {
    global $g_pcl_trace_level;

    return($g_pcl_trace_level);
  }
  function TrOff()
  {
    global $g_pcl_trace_level;
    global $g_pcl_trace_mode;
    global $g_pcl_trace_filename;
    global $g_pcl_trace_name;
    global $g_pcl_trace_index;
    $g_pcl_trace_mode = "memory";
    unset($g_pcl_trace_entries);
    unset($g_pcl_trace_name);
    unset($g_pcl_trace_index);
    $g_pcl_trace_level = 0;
  }
  function TrFctStart($p_file, $p_line, $p_name, $p_param = "", $p_message = "")
  {
    global $g_pcl_trace_level;
    global $g_pcl_trace_mode;
    global $g_pcl_trace_filename;
    global $g_pcl_trace_name;
    global $g_pcl_trace_index;
    global $g_pcl_trace_entries;
    if ($g_pcl_trace_level < 1)
      return;
    if (!isset($g_pcl_trace_name))
      $g_pcl_trace_name = $p_name;
    else
      $g_pcl_trace_name .= "," . $p_name;
    $i = sizeof($g_pcl_trace_entries);
    $g_pcl_trace_entries[$i]["name"] = $p_name;
    $g_pcl_trace_entries[$i]["param"] = $p_param;
    $g_pcl_trace_entries[$i]["message"] = "";
    $g_pcl_trace_entries[$i]["file"] = $p_file;
    $g_pcl_trace_entries[$i]["line"] = $p_line;
    $g_pcl_trace_entries[$i]["index"] = $g_pcl_trace_index;
    $g_pcl_trace_entries[$i]["type"] = "1"; // means start of function
    
    if ($p_message != ""){
      $i = sizeof($g_pcl_trace_entries);
      $g_pcl_trace_entries[$i]["name"] = "";
      $g_pcl_trace_entries[$i]["param"] = "";
      $g_pcl_trace_entries[$i]["message"] = $p_message;
      $g_pcl_trace_entries[$i]["file"] = $p_file;
      $g_pcl_trace_entries[$i]["line"] = $p_line;
      $g_pcl_trace_entries[$i]["index"] = $g_pcl_trace_index;
      $g_pcl_trace_entries[$i]["type"] = "3"; // means message
    }
    PclTraceAction($g_pcl_trace_entries[$i]);
    $g_pcl_trace_index++;
  }
  function TrFctEnd($p_file, $p_line, $p_return = 1, $p_message = "")
  {
    global $g_pcl_trace_level;
    global $g_pcl_trace_mode;
    global $g_pcl_trace_filename;
    global $g_pcl_trace_name;
    global $g_pcl_trace_index;
    global $g_pcl_trace_entries;
    if ($g_pcl_trace_level < 1)
      return;
    if (!($v_name = strrchr($g_pcl_trace_name, ","))){
      $v_name = $g_pcl_trace_name;
      $g_pcl_trace_name = "";
    }else{
      $g_pcl_trace_name = substr($g_pcl_trace_name, 0, strlen($g_pcl_trace_name) - strlen($v_name));
      $v_name = substr($v_name, - strlen($v_name) + 1);
    }
    $g_pcl_trace_index--;
    if ($p_message != ""){
      $i = sizeof($g_pcl_trace_entries);
      $g_pcl_trace_entries[$i]["name"] = "";
      $g_pcl_trace_entries[$i]["param"] = "";
      $g_pcl_trace_entries[$i]["message"] = $p_message;
      $g_pcl_trace_entries[$i]["file"] = $p_file;
      $g_pcl_trace_entries[$i]["line"] = $p_line;
      $g_pcl_trace_entries[$i]["index"] = $g_pcl_trace_index;
      $g_pcl_trace_entries[$i]["type"] = "3"; // means message
    }
    $i = sizeof($g_pcl_trace_entries);
    $g_pcl_trace_entries[$i]["name"] = $v_name;
    $g_pcl_trace_entries[$i]["param"] = $p_return;
    $g_pcl_trace_entries[$i]["message"] = "";
    $g_pcl_trace_entries[$i]["file"] = $p_file;
    $g_pcl_trace_entries[$i]["line"] = $p_line;
    $g_pcl_trace_entries[$i]["index"] = $g_pcl_trace_index;
    $g_pcl_trace_entries[$i]["type"] = "2"; // means end of function
    
    PclTraceAction($g_pcl_trace_entries[$i]);
  }
  function TrFctMessage($p_file, $p_line, $p_level, $p_message = "")
  {
    global $g_pcl_trace_level;
    global $g_pcl_trace_mode;
    global $g_pcl_trace_filename;
    global $g_pcl_trace_name;
    global $g_pcl_trace_index;
    global $g_pcl_trace_entries;
    if ($g_pcl_trace_level < $p_level)
      return;
    $i = sizeof($g_pcl_trace_entries);
    $g_pcl_trace_entries[$i]["name"] = "";
    $g_pcl_trace_entries[$i]["param"] = "";
    $g_pcl_trace_entries[$i]["message"] = $p_message;
    $g_pcl_trace_entries[$i]["file"] = $p_file;
    $g_pcl_trace_entries[$i]["line"] = $p_line;
    $g_pcl_trace_entries[$i]["index"] = $g_pcl_trace_index;
    $g_pcl_trace_entries[$i]["type"] = "3"; // means message of function
    
    PclTraceAction($g_pcl_trace_entries[$i]);
  }
  function TrMessage($p_file, $p_line, $p_level, $p_message = "")
  {
    global $g_pcl_trace_level;
    global $g_pcl_trace_mode;
    global $g_pcl_trace_filename;
    global $g_pcl_trace_name;
    global $g_pcl_trace_index;
    global $g_pcl_trace_entries;
    if ($g_pcl_trace_level < $p_level)
      return;
    $i = sizeof($g_pcl_trace_entries);
    $g_pcl_trace_entries[$i]["name"] = "";
    $g_pcl_trace_entries[$i]["param"] = "";
    $g_pcl_trace_entries[$i]["message"] = $p_message;
    $g_pcl_trace_entries[$i]["file"] = $p_file;
    $g_pcl_trace_entries[$i]["line"] = $p_line;
    $g_pcl_trace_entries[$i]["index"] = $g_pcl_trace_index;
    $g_pcl_trace_entries[$i]["type"] = "4"; // means simple message
    
    PclTraceAction($g_pcl_trace_entries[$i]);
  }
  function TrDisplay()
  {
    global $g_pcl_trace_level;
    global $g_pcl_trace_mode;
    global $g_pcl_trace_filename;
    global $g_pcl_trace_name;
    global $g_pcl_trace_index;
    global $g_pcl_trace_entries;
    if (($g_pcl_trace_level <= 0) || ($g_pcl_trace_mode != "memory"))
      return;

    $v_font = "\"Verdana, Arial, Helvetica, sans-serif\"";
    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr bgcolor=#0000CC>";
    echo "<td bgcolor=#0000CC width=1>";
    echo "</td>";
    echo "<td><div align=center><font size=3 color=#FFFFFF face=$v_font>Trace</font></div></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td bgcolor=#0000CC width=1>";
    echo "</td>";
    echo "<td>";
    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    $v_again = 0;
    for ($i = 0; $i < sizeof($g_pcl_trace_entries); $i++){
      echo "<tr>";
      echo "<td><table width=100% border=0 cellspacing=0 cellpadding=0><tr>";
      $n = ($g_pcl_trace_entries[$i]["index"] + 1) * 10;
      echo "<td width=" . $n . "><table width=100% border=0 cellspacing=0 cellpadding=0><tr>";

      for ($j = 0; $j <= $g_pcl_trace_entries[$i]["index"]; $j++){
        if ($j == $g_pcl_trace_entries[$i]["index"]){
          if (($g_pcl_trace_entries[$i]["type"] == 1) || ($g_pcl_trace_entries[$i]["type"] == 2))
            echo "<td width=10><div align=center><font size=2 face=$v_font>+</font></div></td>";
        }else
          echo "<td width=10><div align=center><font size=2 face=$v_font>|</font></div></td>";
      }
      echo "</tr></table></td>";

      echo "<td width=2></td>";
      switch ($g_pcl_trace_entries[$i]["type"]){
      case 1:
        echo "<td><font size=2 face=$v_font>" . $g_pcl_trace_entries[$i]["name"] . "(" . $g_pcl_trace_entries[$i]["param"] . ")</font></td>";
        break;
      case 2:
        echo "<td><font size=2 face=$v_font>" . $g_pcl_trace_entries[$i]["name"] . "()=" . $g_pcl_trace_entries[$i]["param"] . "</font></td>";
        break;
      case 3:
      case 4:
        echo "<td><table width=100% border=0 cellspacing=0 cellpadding=0><td width=20></td><td>";
        echo "<font size=2 face=$v_font>" . $g_pcl_trace_entries[$i]["message"] . "</font>";
        echo "</td></table></td>";
        break;
      default:
        echo "<td><font size=2 face=$v_font>" . $g_pcl_trace_entries[$i]["name"] . "(" . $g_pcl_trace_entries[$i]["param"] . ")</font></td>";
      }
      echo "</tr></table></td>";
      echo "<td width=5></td>";
      echo "<td><font size=1 face=$v_font>" . basename($g_pcl_trace_entries[$i]["file"]) . "</font></td>";
      echo "<td width=5></td>";
      echo "<td><font size=1 face=$v_font>" . $g_pcl_trace_entries[$i]["line"] . "</font></td>";
      echo "</tr>";
    }
    echo "</table>";
    echo "</td>";
    echo "<td bgcolor=#0000CC width=1>";
    echo "</td>";
    echo "</tr>";
    echo "<tr bgcolor=#0000CC>";
    echo "<td bgcolor=#0000CC width=1>";
    echo "</td>";
    echo "<td><div align=center><font color=#FFFFFF face=$v_font>&nbsp</font></div></td>";
    echo "</tr>";
    echo "</table>";
  }
  function PclTraceAction($p_entry)
  {
    global $g_pcl_trace_level;
    global $g_pcl_trace_mode;
    global $g_pcl_trace_filename;
    global $g_pcl_trace_name;
    global $g_pcl_trace_index;
    global $g_pcl_trace_entries;

    if ($g_pcl_trace_mode == "normal"){
      for ($i = 0; $i < $p_entry["index"]; $i++)
      echo "---";
      if ($p_entry["type"] == 1)
        echo "<b>" . $p_entry["name"] . "</b>(" . $p_entry["param"] . ") : " . $p_entry["message"] . " [" . $p_entry["file"] . ", " . $p_entry["line"] . "]<br>";
      else if ($p_entry["type"] == 2)
        echo "<b>" . $p_entry["name"] . "</b>()=" . $p_entry["param"] . " : " . $p_entry["message"] . " [" . $p_entry["file"] . ", " . $p_entry["line"] . "]<br>";
      else
        echo $p_entry["message"] . " [" . $p_entry["file"] . ", " . $p_entry["line"] . "]<br>";
    }
  }
}

?>