
<?php

if($argc != 2){
    echo "Usage: search-replace.php themename\n";
    exit;
}

$themename = $argv[1];

// search/replace in the wp-config-sample
$filename = "webroot/wp-config-sample.php";
$file = file_get_contents($filename);
file_put_contents($filename, preg_replace("/_s_theme/", $themename, $file));
echo "wp-config-sample.php updated\n";

// search/replace in the theme js
$filename = "webroot/wp-content/themes/_s/js/main.js";
$file = file_get_contents($filename);
$file = preg_replace("/_s/", strtoupper($themename), $file);
file_put_contents($filename, $file);
echo "theme js updated\n";

// search/replace in the theme template files
foreach( glob("webroot/wp-content/themes/_s/*.*") as $filename ){
    replaceInTemplates($filename, $themename);
}
foreach( glob("webroot/wp-content/themes/_s/*/*.*") as $filename ){
    replaceInTemplates($filename, $themename);
}

rename("webroot/wp-content/themes/_s", "webroot/wp-content/themes/" . $themename);

/**
 * replaceInTemplates
 * @param string $filename  : the path of the file to search/replace in
 * @param string $themename : the new name of the theme
 *
 * do the search and replace on the given file
 */
function replaceInTemplates($filename, $themename){
    $file = file_get_contents($filename);
    
    $file = preg_replace("/_s_script-/", $themename . "-", $file);
    $file = preg_replace("/'_s'/", "'" . $themename . "'", $file);
    $file = preg_replace("/_s_/", $themename . "_", $file);
    $file = preg_replace("/\._s/", "." . $themename, $file);
    $file = preg_replace("/ _s/", " " . ucfirst($themename), $file);
    $file = preg_replace("/_s-/", " " . $themename . "-", $file);
    $file = preg_replace("/Text Domain: _s/", "Text Domain: " . $themename, $file);

    file_put_contents($filename, $file);
    echo "theme templates updated\n";
}


?>
