<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is fun_list.php, released on 2003-03-31.

     The Initial Developer of the Original Code is The QuiX project.

     Alternatively, the contents of this file may be used under the terms
     of the GNU General Public License Version 2 or later (the "GPL"), in
     which case the provisions of the GPL are applicable instead of
     those above. If you wish to allow use of your version of this file only
     under the terms of the GPL and not to allow others to use
     your version of this file under the MPL, indicate your decision by
     deleting  the provisions above and replace  them with the notice and
     other provisions required by the GPL.  If you do not delete
     the provisions above, a recipient may use your version of this file
     under either the MPL or the GPL."
------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------
Author: The QuiX project
	quix@free.fr
	http://www.quix.tk
	http://quixplorer.sourceforge.net

Comment:
	QuiXplorer Version 2.3
	Directory-Listing Functions

	Have Fun...

This file was modified by the TinyWebgallery project to work as backend for
TinyWebgallery.
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
// HELPER FUNCTIONS (USED BY MAIN FUNCTION 'list_dir', SEE BOTTOM)
/* This function is needed on some servers that throw a fatal error when calling posix_getgrgid */
function twg_getgrgid($id) {
  global $cachedir;
  $file = create_cache_file_admin("_getgrgid","tmp");
  if (file_exists($file)) {
    $my_group_info['name'] = "?";
    $my_group_info['gid'] = "?"; 
  } else {
    set_error_handler("on_error_no_output");
    $fh = @fopen($file, 'w');  fclose($fh);	
    $v =  @posix_getgrgid($id);
    set_error_handler("on_error");
    if ($v) {
      @unlink($file);  
    }
    return $v;
  }
}

/* This function is needed on some servers that throw a fatal error when calling posix_getpwuid */
function twg_getpwuid($id) {
  global $cachedir;
  $file = create_cache_file_admin("_getpwuid","tmp");
  if (file_exists($file)) {
    $my_group_info['name'] = "?";
    $my_group_info['uid'] = "?";  
  } else {
  set_error_handler("on_error_no_output");
  $fh = @fopen($file, 'w');  fclose($fh);	
  $v =  @posix_getpwuid($id);
  set_error_handler("on_error");
  if ($v) {
    @unlink($file);  
  }
  return $v;
  }
}

function make_list($_list1, $_list2) {		// make list of files
	$list = array();

	if($GLOBALS["srt"]=="yes") {
		$list1 = $_list1;
		$list2 = $_list2;
	} else {
		$list1 = $_list2;
		$list2 = $_list1;
	}

	if(is_array($list1)) {
		while (list($key, $val) = each($list1)) {
			$list[$key] = $val;
		}
	}

	if(is_array($list2)) {
		while (list($key, $val) = each($list2)) {
			$list[$key] = $val;
		}
	}

	return $list;
}
//------------------------------------------------------------------------------
function make_tables($dir, &$dir_list, &$file_list, &$tot_file_size, &$num_items)
{						// make table of files in dir
	// make tables & place results in reference-variables passed to function
	// also 'return' total filesize & total number of items
	$homedir = realpath($GLOBALS['home_dir']);
	$tot_file_size = $num_items = 0;
	// Open directory
	$handle = @opendir(get_abs_dir($dir));
	if($handle===false && $dir=="") {
	  $handle = @opendir($homedir . $GLOBALS['separator']);
	}

	if($handle===false)
	  show_error($dir.": ".$GLOBALS["error_msg"]["opendir"]);

	// Read directory
	while(($new_item = readdir($handle))!==false) {

		$abs_new_item = get_abs_item($dir, $new_item);
		if ($new_item == "." || $new_item == "..") continue;
		if(!file_exists($abs_new_item)) continue; //show_error($dir."/$abs_new_item: ".$GLOBALS["error_msg"]["readdir"])
        if(!get_show_item($dir, $new_item)) continue;
        $new_file_size = @filesize($abs_new_item);
		$tot_file_size += $new_file_size;
		$num_items++;

		if(get_is_dir($dir, $new_item)) {
			if($GLOBALS["order"]=="mod") {
				$dir_list[$new_item] =
					@filemtime($abs_new_item);
			} else {	// order == "size", "type" or "name"
				$dir_list[$new_item] = $new_item;
			}
		} else {
			if($GLOBALS["order"]=="size") {
				$file_list[$new_item] = $new_file_size;
			} elseif($GLOBALS["order"]=="mod") {
				$file_list[$new_item] =
					@filemtime($abs_new_item);
			} elseif($GLOBALS["order"]=="type") {
				$file_list[$new_item] =
					get_mime_type($dir, $new_item, "type");
			} else {	// order == "name"
				$file_list[$new_item] = $new_item;
			}
		}
	}
	closedir($handle);


	// sort
	if(is_array($dir_list)) {
		if($GLOBALS["order"]=="mod") {
			if($GLOBALS["srt"]=="yes") arsort($dir_list);
			else asort($dir_list);
		} else {	// order == "size", "type" or "name"
			if($GLOBALS["srt"]=="yes") ksort($dir_list);
			else krsort($dir_list);
		}
	}

	// sort
	if(is_array($file_list)) {
		if($GLOBALS["order"]=="mod") {
			if($GLOBALS["srt"]=="yes") arsort($file_list);
			else asort($file_list);
		} elseif($GLOBALS["order"]=="size" || $GLOBALS["order"]=="type") {
			if($GLOBALS["srt"]=="yes") asort($file_list);
			else arsort($file_list);
		} else {	// order == "name"
			if($GLOBALS["srt"]=="yes") ksort($file_list);
			else krsort($file_list);
		}
	}
}
//------------------------------------------------------------------------------
function print_table($dir, $list, $allow) {	// print table of files
	global $dir_up,$extension_thumb, $twg_hidden, $cachedir;
	if(!is_array($list)) return;
	if( $dir != "" || strstr( $dir, _QUIXPLORER_PATH ) ) {
	  echo "<tr class=\"rowdata\"><td>&nbsp;</td><td valign=\"baseline\"><a href=\"".make_html_link("list",$dir_up,NULL)."\">";
	  echo "<img border=\"0\ class='bsprites up_gif' align=\"middle\" src=\""._QUIXPLORER_URL."/_img/_.gif\" ";
	  echo "alt=\"".$GLOBALS["messages"]["uplink"]."\" title=\"".$GLOBALS["messages"]["uplink"]."\"/>&nbsp;&nbsp;..</a></td>\n";
	  echo "<td>&nbsp;</td>";
	  echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	  if( extension_loaded( "posix" ))
		echo "<td>&nbsp;</td>";
	  echo "</tr>";
	}
	$i = 0;
	$twg_hidden = 0;

	while(list($item,) = each($list)){
		// link to dir / file
		if ($dir != "") {
		  $test_item = $dir . "/" . $item;
		} else {
		  $test_item = $item;
		}

		if ($GLOBALS["sview"] == "yes" && in_array($test_item, $GLOBALS["hide_simple_view"])) {
		      $twg_hidden++;
		      continue;
		}
		$abs_item=get_abs_item($dir,$item);

		$is_writable = is_writable( $abs_item );
		$is_chmodable = is_chmodable( $abs_item );
		$is_readable = is_readable( $abs_item );
		$is_deletable = is_deletable( $abs_item );

		$file_info = @stat( $abs_item );

		$target="";
		//$extra="";
		//if(is_link($abs_item)) $extra=" -> ".@readlink($abs_item);
		if(@is_dir($abs_item)) {
			$link = make_html_link("list",get_rel_item($dir, $item),NULL);
		} else { //if(get_is_editable($dir,$item) || get_is_image($dir,$item)) {
			if (isset($GLOBALS["home_url"])) {
			  $link = $GLOBALS["home_url"]."/".get_rel_item($dir, $item);
			} else {
			  $link = "";
			}
			$target = "target=\"_blank\"";
		} //else $link = "";
		//echo "<tr class=\"rowdata\">"
		if ($i % 2 == 1) {
			$bgcolor = "#fafafa";
		} else {
			$bgcolor = "#f3f3f3";
		}

		echo '<tr onmouseover="showImageDiv(\'' . $i . '\');style.backgroundColor=\'#D8ECFF\';" onmouseout="hideImageDiv(\'' . $i . '\');style.backgroundColor=\''.$bgcolor.'\';" bgcolor=\'' . $bgcolor . '\'>';


		echo "<td><input type=\"checkbox\" id=\"item_$i\" name=\"selitems[]\" value=\"";
		echo htmlspecialchars($item)."\" onclick=\"javascript:Toggle(this);\"></td>\n";
	// Icon + Link
		echo "<td nowrap=\"nowrap\">";
      if($is_readable && ($link != "")) {
			echo"<a href=\"".$link."\" ".$target.">";
		}
		//else echo "<A>";
	
		echo '<img align="middle"  src="_img/_.gif" class="sprites '.get_mime_type($dir, $item, "img").'">&nbsp;';
    // echo "<img border=\"0\" width=\"16\" height=\"16\" ";
		// echo "align=\"middle\" src=\""._QUIXPLORER_URL."/_img/".get_mime_type($dir, $item, "img")."\" alt=\"\">&nbsp;";
		$s_item=$item;	if(strlen($s_item)>50) $s_item=substr($s_item,0,47)."...";
		$s_item = utf8_encode($s_item);
		echo htmlspecialchars($s_item, ENT_COMPAT , "UTF-8");
	if( $is_readable && ($link != "")) {
			echo "</a>";	// ...$extra...
		}
		echo "</td>\n";
	// Size
		echo "<td>".parse_file_size(get_file_size($dir,$item))."</td>\n";
	// type
		echo "<td>".get_mime_type($dir, $item, "type")."</td>\n";
	  if ($GLOBALS["tview"]!="yes") {
			// modified
			echo "<td>".parse_file_date(get_file_date($dir,$item))."</td>\n";
			// permissions
			echo "<td>";

			if($allow && $is_chmodable) {
				echo "<a href=\"".make_html_link("chmod",$dir,$item)."\" title=\"";
				echo $GLOBALS["messages"]["permlink"]."\">";
			}
			echo parse_file_type($dir,$item)
				.parse_file_perms(get_file_perms($dir,$item));
			if($allow && $is_chmodable ) {
				echo "</a>";
			}
			echo "</td>\n";
		} else {
		  // $pic = $dir . "/" . $item;

		  if (check_explorer_image_extension($item)) {
		  list($width, $height) = getimagesize($abs_item);

		  echo "<td><center>";
		  echo $width."x".$height;
		  echo "</center></td>";
		  } else {
		  echo "<td>&nbsp;</td>";
		  }
		  echo "<td>";
		  if (check_jpg_extension($item)) {
		    $picdir = get_twg_album($dir);
		    if ($picdir) {
            $thumbimage = create_thumb_image($picdir, urlencode($item));
            $thumb = "." . create_cache_file_admin($thumbimage,$extension_thumb);
				    if (file_exists($thumb)) {
				        $src_value = create_cache_file_admin(urlencode($thumbimage),$extension_thumb,true); 
					} else {
					  $src_value = "../image.php?twg_album=" . urlencode($picdir) . "&amp;twg_type=thumb&amp;twg_show=" . urlencode($item) ;
					}
					echo "<center><img id=\"img" . $i .  "\" alt=\"\" class=\"thumbimage\" src='" . $src_value ."' height='50' /></center>";
				} else {
				  echo "&nbsp;";
				}
		  } else {
		  	echo "&nbsp;";
			}
		  echo "</td>\n";



		}
		// Owner
		error_reporting( E_ALL );
		if( extension_loaded( "posix" )) {
			echo "<td>\n";
			ob_start();
			$user_info = twg_getpwuid( $file_info["uid"] );
			$group_info = twg_getgrgid($file_info["gid"] );
			ob_end_clean();
			echo $user_info["name"]. " (".$file_info["uid"].") /<br/>";
			echo $group_info["name"]. " (".$file_info["gid"].")";

			echo "</td>\n";
		}
		// actions
		echo "<td>\n<table summary=\"\"><tr>\n";

		// Rename
		// A file that could be deleted can also be renamed
		if($allow && $is_deletable) {
			echo "<td><a href=\"".make_html_link("rename",$dir,$item)."\">";
			echo "<img class='bsprites rename_gif' ";
			echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["renamelink"]."\" title=\"";
			echo $GLOBALS["messages"]["renamelink"]."\"></a></td>\n";
		}
		else {
			echo "<td><img class='bsprites rename__gif' ";
			echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["renamelink"]."\" title=\"";
			echo $GLOBALS["messages"]["renamelink"]."\"></td>\n";
		}

		// EDIT

		if(get_is_editable($dir, $item)) {

			if($allow && $is_writable) {
				echo "<td><a href=\"".make_html_link("edit",$dir,$item)."\">";
				echo "<img class='bsprites edit_gif' align=\"middle\" ";
				echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["editlink"]."\" title=\"";
				echo $GLOBALS["messages"]["editlink"]."\"></a></td>\n";
			}
			else {
				echo "<td><img class='bsprites edit__gif' ";
				echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["editlink"]."\" title=\"";
				echo $GLOBALS["messages"]["editlink"]."\"></td>\n";
			}
		} else {
			// Extract Link
			if( is_archive( $item ) ) {
			  echo "<td><a ";
			  echo "onclick=\"javascript: ClearAll(); getElementById('item_$i').checked = true; if( confirm('". ($GLOBALS["messages"]["extract_warning"]) ."') ) { document.selform.do_action.value='extract'; document.selform.submit(); } else {  getElementById('item_$i').checked = false; return false;}\" ";
			  echo "href=\"".make_html_link("extract",$dir,$item)."\" title=\"".$GLOBALS["messages"]["extractlink"]."\">";
			  echo "<img class='bsprites extract_gif' ";
			  echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["extractlink"];
			  echo "\" title=\"".$GLOBALS["messages"]["extractlink"]."\"></a></td>\n";
			}
			else {
			  echo "<td><img border=\"0\" width=\"16\" height=\"16\" align=\"middle\" ";
			  echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"\"></td>\n";
			}
		}
		// DOWNLOAD / Extract
		if(get_is_file($dir,$item)) {
			if($allow) {
				echo "<td><a href=\"".make_html_link("download",$dir,$item)."\" title=\"".$GLOBALS["messages"]["downlink"]."\">";
				echo "<img class='bsprites download_gif' ";
				echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["downlink"];
				echo "\" title=\"".$GLOBALS["messages"]["downlink"]."\"></a></td>\n";
			} else if(!$allow) {
				echo "<td><img class='bsprites download__gif' ";
				echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["downlink"];
				echo "\" title=\"".$GLOBALS["messages"]["downlink"]."\"></td>\n";
			}
		} else {
			echo "<td><img border=\"0\" width=\"16\" height=\"16\" align=\"middle\" ";
			echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"\"></td>\n";
		}
		// DELETE
		if(get_is_file($dir,$item) || get_is_dir($dir,$item) ) {
			if($allow && is_deletable(get_abs_item($dir, $item))) {
				if (get_is_file($dir,$item)) {
				  $confirm_msg = sprintf($GLOBALS["messages"]["confirm_delete_file"], escapeHochkomma ($item) );
				} else {
				  $confirm_msg = sprintf($GLOBALS["messages"]["confirm_delete_dir"], escapeHochkomma ($item) );
				}
				echo "<td><a name=\"link_item_$i\" href=\"#link_item_$i\" title=\"".$GLOBALS["messages"]["dellink"]."\"
				onclick=\"javascript: ClearAll(); getElementById('item_$i').checked = true; if( confirm('". $confirm_msg ."') ) { document.selform.do_action.value='delete'; document.selform.submit(); } else {  getElementById('item_$i').checked = false; return false;}\">";
				echo "<img class='bsprites delete_gif' ";
				echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["dellink"];
				echo "\" title=\"".$GLOBALS["messages"]["dellink"]."\"></a></td>\n";
			}
			else {
				echo "<td><img class='bsprites delete__gif' ";
				echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["dellink"];
				echo "\" title=\"".$GLOBALS["messages"]["dellink"]."\"></td>\n";
			}
		} else {
			echo "<td><img border=\"0\" width=\"16\" height=\"16\" align=\"middle\" ";
			echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"\"></td>\n";
		}
		echo "</tr></table>\n</td></tr>\n";
		$i++;
	}
	return $twg_hidden;

}
//------------------------------------------------------------------------------
// MAIN FUNCTION
function list_dir($dir) {			// list directory contents
	global $dir_up, $_VERSION, $cachedir;

 // $GLOBALS["tview"]="yes";  // we activate the thumbnail view !!


	?>
	<script type="text/javascript" language="Javascript" src="_js/overlib_mini.js"></script>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	<?php
	echo "<center>";
	$allow=($GLOBALS["permissions"]&02)==02; // min modify or admin!

	$has_safemode_problem = has_safemode_problem( $GLOBALS['home_dir'].'/'.$dir );

	$dir_up = dirname($dir);
	if($dir_up==".") $dir_up = "";

	if(!get_show_item($dir_up,basename($dir))) show_error($dir." : ".$GLOBALS["error_msg"]["accessdir"]);

	// make file & dir tables, & get total filesize & number of items
	make_tables($dir, $dir_list, $file_list, $tot_file_size, $num_items);


	$dirs = explode( "/", $dir );
	$implode = "";
	$dir_links = "<a href=\"".make_html_link( "list", "", null )."\">..</a>&nbsp;/&nbsp;";
	foreach( $dirs as $directory ) {
	  if( $directory != "" ) {
		$implode .= $directory."/";
		$dir_links .= "<a href=\"".make_html_link( "list", $implode, null )."\">" .utf8_encode($directory). "</a>&nbsp;/&nbsp;";
	  }
	}
	show_header($GLOBALS["messages"]["actdir"].": ".$dir_links, true);

	echo "</td>";
	echo "<td class=\"titlemiddle\">";
	echo "<img border=\"0\" width=\"16\" height=\"2\" align=\"middle\" ";
			  echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"\"><br/>";
	if ($GLOBALS["sview"]=="yes") {
	  echo "<a href=\"".make_html_link("list",$dir,NULL,NULL,NULL,NULL,NULL,"no")."\" class='menubutton' title='".$GLOBALS["messages"]["gonormalview"]."'>".$GLOBALS["messages"]["normalview"]."</a>";
	} else {
	  echo "<a href=\"".make_html_link("list",$dir,NULL,NULL,NULL,NULL,NULL,"yes")."\" class='menubutton' title='".$GLOBALS["messages"]["gosimpleview"]."'>".$GLOBALS["messages"]["simpleview"]."</a>";
	}
    echo "</td>";
	echo "<td class=\"titlemiddle\" style=\"text-align:left;width:36px;\">";
	echo "<img alt=\"\" ";
      writehelp("simple_view");
	echo " src=\"_img/help.gif\"></td>";
	echo "<td class=\"titleright\" style=\"width:80px;\">";

		if ($GLOBALS["tview"]=="yes") {
		echo "<a href=\"".make_html_link("list",$dir,NULL,NULL,NULL,NULL,"no")."\"><img src=\"_img/_.gif\" class=\"sprites directory_detailed_png\"></img></a>";
		} else {
		 echo "<img src=\"_img/_.gif\"  class=\"sprites directory_detailed_sel\"></img>";
		}
		echo "<img src=\"_img/_.gif\" alt=\"\" width=10>";
		if ($GLOBALS["tview"]=="no") {
		echo "<a href=\"".make_html_link("list",$dir,NULL,NULL,NULL,NULL,"yes")."\"><img src=\"_img/_.gif\" class=\"sprites directory_thumbnails_png\"></img></a>";
		} else {
		  echo "<img src=\"_img/_.gif\" class=\"sprites directory_thumbnails_sel\"></img>";
		}
	echo "<img src=\"_img/_.gif\" alt=\"\" width=5></td>";
	echo "</tr></tbody></table>\n\n";

		show_message();
	// Javascript functions:
	include _QUIXPLORER_PATH."/_include/javascript.php";

	// Sorting of items
	if($GLOBALS["srt"]=="yes") {
		$_srt = "no";	$_img = "&nbsp;<img class='bsprites arrowup_gif' src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"^\">";
	} else {
		$_srt = "yes";	$_img = "&nbsp;<img class='bsprites arrowdown_gif' src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"v\">";
	}

	// Toolbar
	echo "<br><table summary=\"\" width=\"95%\"><tr><td><table summary=\"\" ><tr>\n";

	// PARENT DIR
	echo "<td>";
	if( $dir != "" ) {
	  echo "<a href=\"".make_html_link("list",$dir_up,NULL)."\">";
	  echo "<img class='bsprites up_gif' src=\""._QUIXPLORER_URL."/_img/_.gif\" ";
	  echo "alt=\"".$GLOBALS["messages"]["uplink"]."\" title=\"".$GLOBALS["messages"]["uplink"]."\"></a>";
	}
	echo "</td>\n";
	// HOME DIR
	echo "<td><a href=\"".make_html_link("list",NULL,NULL)."\">";
	echo "<img class='bsprites home_gif' src=\""._QUIXPLORER_URL."/_img/_.gif\" ";
	echo "alt=\"".$GLOBALS["messages"]["homelink"]."\" title=\"".$GLOBALS["messages"]["homelink"]."\"></a></td>\n";
	// RELOAD
	echo "<td><a href=\"javascript:location.reload();\"><img class='bsprites refresh_gif' ";
	echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["reloadlink"];
	echo "\" title=\"".$GLOBALS["messages"]["reloadlink"]."\"></A></td>\n";
	// SEARCH
	echo "<td><a href=\"".make_html_link("search",$dir,NULL)."\">";
	echo "<img class='bsprites search_gif' src=\""._QUIXPLORER_URL."/_img/_.gif\" ";
	echo "alt=\"".$GLOBALS["messages"]["searchlink"]."\" title=\"".$GLOBALS["messages"]["searchlink"];
	echo "\"></a></td>\n";

	echo "<td>&nbsp;|&nbsp;</td>";

	if($allow) {
		// COPY
		echo "<td><a href=\"javascript:Copy();\"><img class='bsprites copy_gif' ";
		echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["copylink"];
		echo "\" title=\"".$GLOBALS["messages"]["copylink"]."\"></a></td>\n";
		// MOVE
		echo "<td><a href=\"javascript:Move();\"><img class='bsprites move_gif' ";
		echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["movelink"];
		echo "\" title=\"".$GLOBALS["messages"]["movelink"]."\"></A></td>\n";
		// DELETE
		echo "<td><a href=\"javascript:Delete();\"><img class='bsprites delete_gif' ";
		echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["dellink"];
		echo "\" title=\"".$GLOBALS["messages"]["dellink"]."\"></A></td>\n";
		// CHMOD
		echo "<td><a href=\"javascript:Chmod();\"><img class='bsprites chmod_gif' ";
		echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"chmod\" title=\"" . $GLOBALS['messages']['chmodlink'] . "\"></a></td>\n";
		// ARCHIVE
		if($GLOBALS["zip"]) {
			echo "<td><a href=\"javascript:Archive();\"><img class='bsprites archive_gif' ";
			echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["comprlink"];
			echo "\" title=\"".$GLOBALS["messages"]["comprlink"]."\"></A></td>\n";
		}
		// UPLOAD
		if(ini_get("file_uploads") && !$has_safemode_problem && is_writable($GLOBALS['home_dir'].'/'.$dir)) {
			echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><a href=\"".make_html_link("upload",$dir,NULL)."\">";
			echo "<img class='bsprites upload_gif' ";
			echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["uploadlink"];
			echo "\" title=\"".$GLOBALS["messages"]["uploadlink"]."\"></A></td>\n";
			echo "<td style='padding:0px;margin:0px;'><a href=\"".make_html_link("upload",$dir,NULL)."\">";
			echo $GLOBALS["messages"]["uploadlink"]. "</A></td>\n";
		} else {
		  echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<img class='bsprites upload__gif' ";
			echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["uploadlink"];
			echo "\" title=\"".$GLOBALS["messages"]["uploadlink"]."\"></td>\n";
			echo "<td style='padding:0px;margin:0px;color:#aaaaaa'>";
			echo $GLOBALS["messages"]["uploadlink"]. "</td>\n";
		}
	} else {
		// COPY
		echo "<td><img class='bsprites copy__gif' ";
		echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["copylink"]."\" title=\"";
		echo $GLOBALS["messages"]["copylink"]."\"></td>\n";
		// MOVE
		echo "<td><img class='bsprites move__gif' ";
		echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["movelink"]."\" title=\"";
		echo $GLOBALS["messages"]["movelink"]."\"></td>\n";
		// DELETE
		echo "<td><img class='bsprites delete__gif' ";
		echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["dellink"]."\" title=\"";
		echo $GLOBALS["messages"]["dellink"]."\"></td>\n";
		// UPLOAD
		echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
		echo "<img class='bsprites upload__gif' ";
		echo "src=\""._QUIXPLORER_URL."/_img/_.gif\" alt=\"".$GLOBALS["messages"]["uploadlink"];
		echo "\" title=\"".$GLOBALS["messages"]["uploadlink"]."\"></td>\n";
		echo "<td style='padding:0px;margin:0px;color:#aaaaaa'>";
		echo $GLOBALS["messages"]["uploadlink"]. "</td>\n";
	}

	// Logo
	echo "<td style=\"padding-left:10px;\">";
	//echo "<div style=\"margin-left:10px;float:right;\" width=\"305\" >";

	// check ie !!
	if (stristr($_SERVER["HTTP_USER_AGENT"], "MSIE")) {
	  $iefilter = "filter:alpha(opacity=10);";
	} else {
	  $iefilter = "";
	}

	//echo "<a href=\"".$GLOBALS['tx_home']."\" target=\"_blank\" title=\"TWGXplorer\"><img border=\"0\" id=\"jx_logo\" style=\"" . $iefilter . "-moz-opacity:.10;opacity:.10;\" onmouseover=\"opacity('jx_logo', 60, 99, 500);\" onmouseout=\"opacity('jx_logo', 100, 40, 500);\" ";
	//echo "src=\""._QUIXPLORER_URL."/_img/logo.gif\" align=\"right\" alt=\"" . $GLOBALS['messages']['logolink'] . "\"></a>";
	//echo "</div>";
	echo "<a href=\"".$GLOBALS['tx_home']."\" target=\"_blank\" title=\"TWGXplorer\">";
  echo '<img src="_img/_.gif" class="sprites logo_gif" id="jx_logo" onmouseover="opacity(\'jx_logo\', 70, 99, 500);" onmouseout="opacity(\'jx_logo\', 100, 70, 500);"></img>';
	echo "</a></td>\n";
	echo "</tr></table></td>\n";

	// Create File / Dir
  	if ($has_safemode_problem) {
		  echo "<td class=\"errorcolor\" style='padding:0;margin:0;text-align:right;'>Safemode restriction applies!";
		  echo "</td><td><img alt=\"\" ";
					writeSafemodeHelp();
			echo " style='vertical-align:top;' src=\"_img/help.gif\">";
		  echo "</td>";
		} else if (has_safemode_problem_global()) {
		  echo "<td class=\"errorcolor\" style='padding:0;margin:0;text-align:right;'>Safemode: ON";
		  echo "</td><td style='padding-right:10px;margin:0;text-align:left;'><img alt=\"\" ";
					writeSafemodeHelp();
			echo " src=\"_img/help.gif\">";
		  echo "</td>";
	}


	if($allow && !$has_safemode_problem && is_writable($GLOBALS['home_dir'].'/'.$dir)) {
		echo "<td align=\"right\"><form action=\"".make_link("mkitem",$dir,NULL)."\" method=\"post\"><table summary=\"\" >\n<tr><td>";
	  echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n"; 
  	echo "<select onchange=\"this.form.mkname.value=this.form.mktype.options[this.form.mktype.selectedIndex].id;\" name=\"mktype\"><option value=\"file\">".$GLOBALS["mimes"]["file"]."</option>";
		echo "<option value=\"dir\">".$GLOBALS["mimes"]["dir"]."</option>";
		foreach ($GLOBALS["messages"]["twgtypes"] as $key => $value) {
			    echo "<option id=\"$key\" value=\"file\">$value</option>\n";
    }
    echo "</select>\n";
		echo "<input id=\"mkname\" name=\"mkname\" type=\"text\" size=\"17\">";
		echo "<input type=\"submit\" value=\"".$GLOBALS["messages"]["btncreate"];
		echo "\"></td><td style='padding:0px;margin:0;text-align:left;'><img alt=\"\" ";
		writehowto(17);
		echo " src=\"_img/help.gif\"></td></tr></table></form></td>\n";
	}


	echo "</tr></table>\n";
	// End Toolbar

	// Begin Table + Form for checkboxes
	echo"<form name=\"selform\" method=\"post\" action=\"".make_link("post",$dir,null)."\">\n";
	 echo "<input type=\"hidden\" name=\"token\" value=\"". md5(session_id()) ."\">\n"; 
  echo "<input type=\"hidden\" name=\"do_action\"><input type=\"hidden\" name=\"first\" value=\"y\">\n";
	echo"<table cellpadding=0 cellspacing=0 summary=\"\"  width=\"98%\">";
	if( extension_loaded( "posix" )) {
	  $owner_info = '<td width="15%" class="header"><strong>' . $GLOBALS['messages']['miscowner'] . '</strong>&nbsp;';
		ob_start();
		$my_user_info =  twg_getpwuid( posix_geteuid() );
		$my_group_info = twg_getgrgid( posix_getegid() );
		ob_end_clean();
		$owner_info .= tooltip( addslashes( sprintf( $GLOBALS['messages']['miscownerdesc'],  $my_user_info['name'], $my_user_info['uid'], $my_group_info['name'], $my_group_info['gid'] ))); // new [mic]

	  	$owner_info .= "</td>\n";
	  	$colspan=8;
	}
	else {
	  $owner_info = "";
	  $colspan = 7;
	}

	// Table Header
	echo "<tr><td colspan=\"$colspan\"><hr/></td></tr><tr><td width=\"2%\" class=\"header\">\n";
	echo "<input type=\"checkbox\" name=\"toggleAllC\" onclick=\"javascript:ToggleAll(this);\"></td>\n";
	echo "<td width=\"22%\" class=\"header\"><b>\n";
	if($GLOBALS["order"]=="name") $new_srt = $_srt;	else $new_srt = "yes";
	echo "<a href=\"".make_html_link("list",$dir,NULL,"name",$new_srt)."\">".$GLOBALS["messages"]["nameheader"];
	if($GLOBALS["order"]=="name") echo $_img;
	echo "</a></b></td>\n<td width=\"9%\" class=\"header\"><B>";
	if($GLOBALS["order"]=="size") $new_srt = $_srt;	else $new_srt = "yes";
	echo "<a href=\"".make_html_link("list",$dir,NULL,"size",$new_srt)."\">".$GLOBALS["messages"]["sizeheader"];
	if($GLOBALS["order"]=="size") echo $_img;
	echo "</A></B></td>\n<td width=\"16%\" class=\"header\"><B>";
	if($GLOBALS["order"]=="type") $new_srt = $_srt;	else $new_srt = "yes";
	echo "<a href=\"".make_html_link("list",$dir,NULL,"type",$new_srt)."\">".$GLOBALS["messages"]["typeheader"];
	if($GLOBALS["order"]=="type") echo $_img;

	if ($GLOBALS["tview"]!="yes") {
	  echo "</a></b></td>\n<td width=\"12%\" class=\"header\"><B>";
	  if($GLOBALS["order"]=="mod") $new_srt = $_srt;	else $new_srt = "yes";
		echo "<a href=\"".make_html_link("list",$dir,NULL,"mod",$new_srt)."\">".$GLOBALS["messages"]["modifheader"];
		if($GLOBALS["order"]=="mod") echo $_img;
		echo "</a></b></td><td width=\"8%\" class=\"header\"><b>".$GLOBALS["messages"]["permheader"]."</b>\n";
	} else {
	     echo "</a></b></td><td width=\"10%\" class=\"header\"><b>".$GLOBALS["messages"]["resolution"]."</b>\n";
  	   echo "</td><td width=\"12%\" class=\"header\"><b>".$GLOBALS["messages"]["thumbnail"]."</b>\n";
	}
	echo "</td>";
	echo $owner_info;
	echo "<td width=\"6%\" class=\"header\"><b>".$GLOBALS["messages"]["actionheader"]."</b></td></tr>\n";
	echo "<tr><td colspan=\"$colspan\"><hr/></td></tr>\n";

	// make & print Table using lists
	$hidden = print_table($dir, make_list($dir_list, $file_list), $allow);

	// print number of items & total filesize
	echo "<tr><td colspan=\"$colspan\"><hr/></td></tr><tr>\n<td class=\"header\"></td>";
	echo "<td class=\"header\">".$num_items." ".$GLOBALS["messages"]["miscitems"]." ";
	if ($hidden > 0 ) {
	 echo "/ " . $hidden . $GLOBALS["messages"]["hidden"];
	}
	echo "(";
  set_error_handler("on_error_no_output");
  if(function_exists("disk_free_space")) {
		$size = @disk_free_space($GLOBALS['home_dir']. $GLOBALS['separator']);
		$free=parse_file_size($size);
	}
	elseif(function_exists("diskfreespace")) {
		$size = diskfreespace($GLOBALS['home_dir'] . $GLOBALS['separator']);
		$free=parse_file_size($size);
	}
	else $free = "?";
  set_error_handler("on_error");

	echo $GLOBALS["messages"]["miscfree"].": ".$free.")</td>\n";
	echo "<td class=\"header\">".parse_file_size($tot_file_size)."</td>\n";
	for($i=0;$i<($colspan-3);++$i) echo"<td class=\"header\"></td>";
	echo "</tr>\n<tr><td colspan=\"$colspan\"><hr/></td></tr></table></form>\n";
	echo "</center>";
	echo "<div id=\"details\" style=\"z-index: 10; visibility: hidden;	position: absolute; right: 100px; width:120px; height:120px; top:30px\"><img border=1 id=\"detailsimg\" alt=\"\"  src=\"_img/_.gif\"></div>";


?><script language="JavaScript1.2" type="text/javascript"><!--
	// Uncheck all items (to avoid problems with new items)
	ie4 = (document.all) ? true:false //required for Functions to work

	var ml = document.selform;
	var len = ml.elements.length;
	for(var i=0; i<len; ++i) {
		var e = ml.elements[i];
		if(e.name == "selitems[]" && e.checked == true) {
			e.checked=false;
		}
	}
	opacity('jx_logo', 10, 60, 2000);

	lastid = -1;
	currentid = -1;



	function showImageDiv(id) {
	   lastid = id;

	   	element = document.getElementById('img' + id);
		 		  	if (element) {
		 		  	    document.getElementById('detailsimg').src = element.src;
		 		  	    window.status=document.getElementById('detailsimg').width + " " + findPosX(element);
		 		  	    imgdiv = document.getElementById('details');
		 						imgdiv.style.top=(findPosY(element) - ((document.getElementById('detailsimg').height)/2)+ 25) + "px";
		 				    factor = document.getElementById('detailsimg').width / document.getElementById('detailsimg').height;

		 				    offset = 25 * factor;
		 				    imgdiv.style.left=(findPosX(element)- ((document.getElementById('detailsimg').width/2))+offset) + "px";
			}
	   window.setTimeout('displayImage(' + id + ')', 1000);
	}

	function displayImage(id) {
	if (id == lastid) {
	currentid = lastid;
	element = document.getElementById('img' + id);
		  	if (element) {
					  imgdiv.style.visibility = "visible";
					  opacity('details', 0, 100, 1);
			}
		}
	}



	function hideImageDiv(id) {
	// if (id != currentid) {
	lastid = -1;
	currentid = -1;
	opacity('details', 10, 0, 1);
	document.getElementById('detailsimg').src = "_img/_.gif";
			if (document.getElementById('details')) {
			  if (document.getElementById('details').style.visibility == "hidden") {
			    return false;
			  } else {
			    document.getElementById('details').style.visibility = "hidden";
			    return true;
			  }
			}
	// }
	return true;
	}

	function findPosX(obj)
	{
		var curleft = 0;
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
		var curtop = 0;
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
// -->
  </script>

<?php
}
//------------------------------------------------------------------------------
?>
