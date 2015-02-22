<?php

/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );

$value = $GLOBALS['__POST']['value'];
$file = '../my_style.css';
if (file_exists($file)) {
  if (!copy($file, $file. '_' . date("ymd_His").'.bak')) {
    echo 'ERROR_COPY';
    return;
  }
}

$xml_file = fopen($file, 'w');
$xml_put = fwrite($xml_file, $value);
$xml_close=fclose($xml_file);

// we write the my_config again by removing the skin setting from this file
if ($skin != '') {
  $config_file = '../my_config.php'; 
  $handle = fopen ($config_file, 'rb');
  $contents = fread ($handle, filesize ($config_file));
  fclose ($handle);
  sleep(1);
  $contents = str_replace("\$skin=\"". $skin ."\"","\$skin=\"\"", $contents);
  // we write it again
  $fp = fopen ( $config_file, 'w' );
  fwrite ( $fp , $contents );
  fclose ( $fp );
  
  // we delete all slide images!
  $localcache = '../' . $cachedir;
  foreach(twg_glob($localcache . "/*" . $extension_slideshow) as $fn) {
    @unlink($fn);
	}
}
clearstatcache(); 

echo 'NO_ERROR';
return;
?>