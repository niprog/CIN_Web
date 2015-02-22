<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
//------------------------------------------------------------------------------
// editable files:
$GLOBALS["editable_ext"]=array(
	"\.txt$|\.php$|\.php3$|\.php5$|\.phtml$|\.inc$|\.sql$|\.pl$",
	"\.htm$|\.html$|\.shtml$|\.dhtml$|\.xml$",
	"\.js$|\.css$|\.cgi$|\.cpp$|\.c$|\.cc$|\.cxx$|\.hpp$|\.h$",
	"\.pas$|\.p$|\.java$|\.py$|\.sh$\.tcl$|\.tk$"
);
//------------------------------------------------------------------------------
// image files:
$GLOBALS["images_ext"]="\.png$|\.bmp$|\.jpg$|\.jpeg$|\.gif$";
//------------------------------------------------------------------------------
// mime types: (description,image,extension)
$GLOBALS["super_mimes"]=array(
	// dir, file
	"dir"	=> array($GLOBALS["mimes"]["dir"],"dir_png"),
	"file"	=> array($GLOBALS["mimes"]["file"],"file_gif")
);
$GLOBALS["used_mime_types"]=array(
	// TWG stuff
	"foldertext"	=> array($GLOBALS["mimes"]["foldertext"],"txt_gif","\folder[_]?[a-z]{0,2}.txt$"),
	"foldername"	=> array($GLOBALS["mimes"]["foldername"],"txt_gif","\foldername[_]?[a-z]{0,2}.txt$"),
	"imagetext"	=> array($GLOBALS["mimes"]["imagetext"],"txt_gif","\image[_]?[a-z]{0,2}.txt$"),
	"privatepng"	=> array($GLOBALS["mimes"]["privatepng"],"image_gif","\private.png$"),
	"folderpng"	=> array($GLOBALS["mimes"]["folderpng"],"image_gif","\folder.png$"),
	"watermarktxt"	=> array($GLOBALS["mimes"]["watermarktxt"],"txt_gif","\watermark.txt$"),
	"watermarkpng"	=> array($GLOBALS["mimes"]["watermarkpng"],"image_gif","\watermark.png$"),
	"watermarkbigpng"	=> array($GLOBALS["mimes"]["watermarkbigpng"],"image_gif","\watermark_big.png$"),
	"linktxt"	=> array($GLOBALS["mimes"]["linktxt"],"txt_gif","\link.txt$"),
	"roottxt"	=> array($GLOBALS["mimes"]["roottxt"],"txt_gif","\root.txt$"),
	"urltxt"	=> array($GLOBALS["mimes"]["urltxt"],"txt_gif","\url.txt$"),
	"backpng"	=> array($GLOBALS["mimes"]["backpng"],"image_gif","\back.png$"),
	"style"	=> array($GLOBALS["mimes"]["style"],"css_gif","\style.css$"),
	"passwd"	=> array($GLOBALS["mimes"]["passwd"],"txt_gif","\private.txt$"),
	
	"caption"	=> array($GLOBALS["mimes"]["caption"],"txt_gif","\_caption.xml$"),
	"comment"	=> array($GLOBALS["mimes"]["comment"],"txt_gif","\_comment.xml$"),
	"counter"	=> array($GLOBALS["mimes"]["counter"],"txt_gif","\_counter.xml$"),
	"albumr"	=> array($GLOBALS["mimes"]["albumr"],"txt_gif","\albumr.txt$"),
	"albuml"	=> array($GLOBALS["mimes"]["albuml"],"txt_gif","\albuml.txt$"),
  // text
	"text"	=> array($GLOBALS["mimes"]["text"],"txt_gif","\.txt$"),
	
	// programming
	"php"	=> array($GLOBALS["mimes"]["php"],"php_gif","\.php$|\.php3$|\.phtml$|\.inc$"),
	"html"	=> array($GLOBALS["mimes"]["html"],"html_gif","\.htm$|\.html$|\.shtml$|\.dhtml$"),
	"js"	=> array($GLOBALS["mimes"]["js"],"js_gif","\.js$"),
	"css"	=> array($GLOBALS["mimes"]["css"],"css_gif","\.css$"),
	// images
	"gif"	=> array($GLOBALS["mimes"]["gif"],"image_gif","\.gif$"),
	"jpg"	=> array($GLOBALS["mimes"]["jpg"],"image_gif","\.jpg$|\.jpeg$"),
	"bmp"	=> array($GLOBALS["mimes"]["bmp"],"image_gif","\.bmp$"),
	"png"	=> array($GLOBALS["mimes"]["png"],"image_gif","\.png$"),
	
	// compressed
	"zip"	=> array($GLOBALS["mimes"]["zip"],"zip_gif","\.zip$"),
	"tar"	=> array($GLOBALS["mimes"]["tar"],"zip_gif","\.tar$"),
	"gzip"	=> array($GLOBALS["mimes"]["gzip"],"zip_gif","\.tgz$|\.gz$"),
	"bzip2"	=> array($GLOBALS["mimes"]["bzip2"],"zip_gif","\.bz2$"),
	"rar"	=> array($GLOBALS["mimes"]["rar"],"zip_gif","\.rar$"),
	// music
	"mp3"	=> array($GLOBALS["mimes"]["mp3"],"mp3_gif","\.mp3$"),
	// movie
	"mpg"	=> array($GLOBALS["mimes"]["mpg"],"video_gif","\.mpg$|\.mpeg$"),
	"mov"	=> array($GLOBALS["mimes"]["mov"],"video_gif","\.mov$"),
	"avi"	=> array($GLOBALS["mimes"]["avi"],"video_gif","\.avi$"),
	"flash"	=> array($GLOBALS["mimes"]["flash"],"flash_gif","\.swf$"),
	
	// Micosoft / Adobe
	"pdf"	=> array($GLOBALS["mimes"]["pdf"],"pdf_gif","\.pdf$")
);
//------------------------------------------------------------------------------
?>
