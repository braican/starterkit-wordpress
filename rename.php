<?php


class Starterkit_Rename{

    function __construct( $t ){

        $this->themename = $t;        

        // for theme names with multiple words, separated by dashes or spaces
        $this->safe_themename = strtolower( str_replace( array('-', ' '), '_', $this->themename ) );

        $this->replaceInConfig();

        $this->replaceInJs();

        $this->replaceInTheme();

        $this->renameDirectory();

    }


    /**
     * replace in the wp-config-sample
     */
    private function replaceInConfig(){
        // search/replace in the wp-config-sample
        $filename = "webroot/wp-config-sample.php";
        $file = file_get_contents($filename);
        file_put_contents($filename, preg_replace("/_s_theme/", $this->themename, $file));
        echo "wp-config-sample.php updated\n";
    }


    /**
     * replace in all the js files
     */
    private function replaceInJs(){

        foreach( glob("webroot/wp-content/themes/_s/js/*.js") as $filename ){
            $file = file_get_contents($filename);
            $file = preg_replace("/_s/", strtoupper($this->themename), $file);
            file_put_contents($filename, $file);
        }
        foreach( glob("webroot/wp-content/themes/_s/js/*/*.js") as $filename ){
            $file = file_get_contents($filename);
            $file = preg_replace("/_s/", strtoupper($this->themename), $file);
            file_put_contents($filename, $file);
        }

        echo "theme js updated\n";
    }


    /**
     * replace in all the rest of the files
     */
    private function replaceInTheme(){

        foreach( glob("webroot/wp-content/themes/_s/*.*") as $filename ){
            replaceInTemplates( $filename );
        }
        foreach( glob("webroot/wp-content/themes/_s/*/*.*") as $filename ){
            replaceInTemplates( $filename );
        }
    }


    private function renameDirectory(){
        rename("webroot/wp-content/themes/_s", "webroot/wp-content/themes/" . $this->themename);
    }


    /* --------------------------------------------
     * --util
     * -------------------------------------------- */


    /**
     * replace all instances within the given file
     *
     * @param $filename (string)
     *   - the name of the file to check
     */
    private function replaceInFile($filename){
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
}


if($argc != 2){
    echo "Usage: search-replace.php <themename>\n";
    exit;
}

new Starterkit_Rename( $argv[1] );


?>
