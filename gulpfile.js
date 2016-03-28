
//
// npm packages
//
var gulp       = require('gulp-help')(require('gulp')),
    fs         = require('fs'),
    rename     = require('gulp-rename'),
    watch      = require('gulp-watch'),

    // inject
    inject     = require('gulp-inject-string'),

    // svg
    svgmin     = require('gulp-svgmin'),
    svgstore   = require('gulp-svgstore'),

    // concat/uglify
    concat     = require('gulp-concat'),
    uglify     = require('gulp-uglify'),
    
    // sass
    sass       = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps');

//
// local vars
//
var themeDir = 'webroot/wp-content/themes/sherman/';

//
// SETUP
//
var setup     = require( './setup.json' ),
    jsModules = setup.jsModules;


/* --------------------------------------------
 * --getters
 * -------------------------------------------- */

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


/* --------------------------------------------
 * --gulp
 * -------------------------------------------- */

/**
 * default - doesn't do anything
 * @TODO set up what the default task should do
 */
gulp.task('default', []);


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
    'uglify',
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
 * optimize svg
 */
gulp.task(
    'opt-svg',
    'Optimizes the svg files.',
    function(){
        gulp.src( themeDir + 'svg/*.svg' )
            .pipe(svgmin())
            .pipe(gulp.dest( themeDir + '/svg/build'));
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
    'sass',
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
    'build',
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
        var contentTypes = getContentTypes(),
            postTypesPhp = themeDir + 'inc/sk-post-types.php',
            types        = '';

        for( var i = 0; i < contentTypes.length; i++ ){
            var file        = './_arsenal/content-types/' + contentTypes[i] + '.php',
                fileContent = fs.readFileSync( file );

            types += fileContent + "\n\n";
        }

        gulp.src( postTypesPhp )
            .pipe( inject.replace('//sk_insert_types//', types ))
            .pipe( gulp.dest( themeDir + 'inc'));
    }
);
