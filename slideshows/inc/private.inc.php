<?php
if ($twg_showprivatelogin || ($multi_root_mode && !$twg_album) || $root_mode_no_login) {
    $style = '';
    if (file_exists($basedir . '/private.png')) {
        $style = 'style="background-image:url(' . $basedir . '/private.png); background-repeat:no-repeat;opacity: 1;" ';
    }
    echo '
   <div class="private" ' . $style . '>&nbsp;</div>';
}
?>