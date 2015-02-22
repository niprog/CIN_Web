<?php
/**
 This file provides a mapping of album_names! If you e.g move albums
 into a subfolder and you have posted this link somewhere this would
 lead to a dead link. The mapping below pervent this.

 You have to manually add entries to this file. The first entry is the
 old album - the 2nd the new album name. You can use an twg_album_id as
 well if you want to use an unique id!

 an example for 3 albums is:

 $GLOBALS["album_mapping"]=array(
 	"123"	=> "456",
	"myold"	=> "2007/myold",
	"holiday"	=> "vacation",
	);

Make sure to store the xml files in the image folders before you move/rename
any folder - otherwise your comments, captions ... are lost.

*/

$GLOBALS["album_mapping"]=array(
	"test_twg"	=> "test_twg_old");


/**
 This is the part that exchanges the twg_album and an optional twg_album_id parameter!
*/

if (isset($GLOBALS["album_mapping"][$twg_album])) {
  $twg_album = replaceInput($GLOBALS["album_mapping"][$twg_album]);
  $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
}
if (isset($_GET['twg_album_id'])) {
    $aid = $_GET['twg_album_id'];
    if (isset($GLOBALS["album_mapping"][$aid])) {
	  $twg_album = replaceInput($GLOBALS["album_mapping"][$aid]);
       $album_enc = htmlentities(urlencode($twg_album), ENT_QUOTES, $charset);
  }
}
</script>