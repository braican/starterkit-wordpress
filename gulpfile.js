
//
// npm packages
//
var gulp         = require('gulp-help')(require('gulp')),
    fs           = require('fs'),
    rename       = require('gulp-rename'),
    watch        = require('gulp-watch'),

    // inject
    inject       = require('gulp-inject-string'),

    // svg
    svgmin       = require('gulp-svgmin'),
    svgstore     = require('gulp-svgstore'),

    // concat/uglify
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglify'),
    
    // sass
    sass         = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps   = require('gulp-sourcemaps');





//
// Config
//


var config = {};

config.sass = {
    errLogToConsole : true
};


config.sourcemaps = {
    includeContent : false,
    sourceRoot     : 'src'
};

config.autoprefixer = {};


config.svgmin = {
    plugins:[
        {
            mergePaths: false
        },{
            convertShapeToPath: false
        },{
            convertPathData: false
        }
    ]
};





//
// File system
//

var themeDir = 'webroot/wp-content/themes/sherman/';

var files = {};

files.sass = {
    src   : themeDir + 'styles/sass/**/*.scss',
    build : themeDir + 'styles/build/'
};


files.js = {
    src   : [ themeDir + 'js/arsenal/*.js', themeDir + 'js/src/*.js' ],
    build : themeDir + 'js/build/'
};



files.svg = {
    src   : themeDir + 'svg/*.svg',
    build : themeDir + 'svg/build/'
};







//
// SETUP
//


var setup     = require( './setup.json' );





/* --------------------------------------------
 * --gulp
 * -------------------------------------------- */

/**
 * default - doesn't do anything
 * @TODO set up what the default task should do
 */
gulp.task( 'default', [] );


/**
 * concatenate javascripts
 */
gulp.task(
    'combine',
    'Concatenates all the javascripts from the arsenal, any plugin scripts, and the main js file',
    function(){
        return gulp.src( [
                    themeDir + 'js/arsenal/enabled/*.js',
                    themeDir + 'js/plugins.js',
                    themeDir + 'js/main.js'
                ] )
                .pipe( concat('production.js') )
                .pipe( gulp.dest( themeDir + 'js/build' ) );
    }
);


/**
 * minify the concatenated javascript file
 */
gulp.task(
    'opt-js',
    'Optimizes javascript by concatenating all the enabled arsenal scripts, the plugins, and the main js file, then minifying that file.',
    ['combine'],
    function(){
        return gulp.src( themeDir + 'js/build/production.js')
            .pipe(uglify())
            .pipe(rename({
                extname: '.min.js'
            }))
            .pipe(gulp.dest( themeDir + '/js/build' ));
    }
);






/**
 * svg store
 */
gulp.task(
    'svgstore',
    'Creates the svg sprite that can be loaded into the page via javascript.',
    function () {
        return gulp.src( themeDir + 'svg/icons/**/*.svg')
                .pipe(rename({prefix: 'icon--'}))
                .pipe( svgmin({
                    plugins:[{
                        mergePaths: false
                    },{
                        convertShapeToPath: false
                    },{
                        convertPathData: false
                    }]
                }) )
                .pipe(svgstore({
                    inlineSvg: true
                }))
                .pipe(gulp.dest( themeDir + 'svg/icons/build'));
    }
);



/**
 * compile sass
 */
gulp.task(
    'styles',
    'Compile that sass.',
    function(){
        gulp.src( themeDir + 'css/*.scss')
            .pipe(sourcemaps.init())
            .pipe(sass({
                errLogToConsole: true
            }).on('error', sass.logError))
            .pipe( sourcemaps.write('.', {
                includeContent: false, sourceRoot: 'src'
            }) )
            .pipe(gulp.dest( themeDir + 'css/build/' ));
    }
);

/**
 * watch the sass directory
 */
gulp.task(
    'watch',
    'Watch those sass files so we can compile it for you on the fly.',
    function(){
        gulp.watch( themeDir + 'css/*.scss' , ['sass']);
    }
);




/**
 * build from arsenal
 */
gulp.task(
    'build-arsenal',
    'Using the "setup.json" config file in the document root, write copy enabled arsenal files into the appropriate place within the theme.',
    function(){

        //
        // build the js
        //
        var activeJs = getActiveJSModules();

        for( var i = 0; i < activeJs.length; i++ ){

            var enabledpath   = themeDir + 'js/arsenal/' + activeJs[i] + '.js',
                availablePath = './_arsenal/js/' + activeJs[i] + '.js';

            try{
                fs.statSync(enabledpath);
            } catch( e ){
                console.log("copied " + enabledpath);
                gulp.src( availablePath )
                    .pipe( gulp.dest( themeDir + 'js/arsenal/' ));
            }
        }


        //
        // register the content types
        //
        var typeCode = getPostTypeCode();

        gulp.src( './_arsenal/_templates/post-types.php' )
            .pipe( inject.replace('//sk_insert_types//', typeCode ))
            .pipe( gulp.dest( themeDir + 'arsenal' ));
    }
);




/* ------------------------------------------
 *
 * --util
 *
 * ------------------------------------------ */




// -------------------
// GETTERS
//



/**
 * returns an array of javascript modules that should be included
 *  in this project, per setup.json
 *
 * @return array
 */
var getActiveJSModules = function(){
    var activeModules = [],
        modules       = setup.jsModules;

    for( module in modules){
        if( modules[module] === true ){
            activeModules.push( module );
        }
    }

    return activeModules;
}



/**
 * returns an array of content types that should be registered for
 *  this project, per the setup.json file
 *
 * @return array
 */
var getContentTypes = function(){
    var ct      = [],
        modules = setup.contentTypes;

    for( module in modules ){
        if( modules[module] === true ){
            ct.push(module);
        }
    }

    return ct;
}






// -------------------
// UTIL
//



/**
 * Concatenates the code from each of the active post types templates.
 *
 * @return string
 */
function getPostTypeCode(){
    
    var contentTypes = getContentTypes(),
        typeCode     = "";

    for( var i = 0; i < contentTypes.length; i++ ){
        var file = './_arsenal/post-types/' + contentTypes[i] + '.php';

        try{
            var fileContent = fs.readFileSync( file );
            typeCode += fileContent + "\n\n";
        } catch (e){
            console.error( "Warning: couldn't write " + e.path + "; please make sure that file exists." );
        }
    }

    return typeCode;
}