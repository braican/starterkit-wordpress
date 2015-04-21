
<?php

if($argc != 2){
    echo "Usage: search-replace.php themename\n";
    exit;
}

$themename = $argv[1];

// for theme names with multiple words, separated by dashes or spaces
$safe_themename = str_replace( array('-', ' '), '_', $themename);

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
    replaceInTemplates();
}
foreach( glob("webroot/wp-content/themes/_s/*/*.*") as $filename ){
    replaceInTemplates();
}

rename("webroot/wp-content/themes/_s", "webroot/wp-content/themes/" . $themename);

/**
 * replaceInTemplates
 *
 * do the search and replace on the given file
 */
function replaceInTemplates(){

    global $themename;
    global $safe_themename;
    global $filename;
    

    $file = file_get_contents($filename);
    
    // replace the script tags
    $file = preg_replace("/_s_script-/", $themename . "-", $file);

    // replace the domain for translations
    $file = preg_replace("/'_s'/", "'" . $themename . "'", $file);

    // function names
    $file = preg_replace("/_s_/", $safe_themename . "_", $file);

    // replace classes
    $file = preg_replace("/\._s/", "." . $themename, $file);

    // package name
    $file = preg_replace("/ _s/", " " . ucfirst($themename), $file);

    // right now, only the classes in the html
    $file = preg_replace("/_s-/", " " . $themename . "-", $file);

    // text domain information
    $file = preg_replace("/Text Domain: _s/", "Text Domain: " . $themename, $file);

    file_put_contents($filename, $file);
    echo "theme templates updated\n";
}


?>
