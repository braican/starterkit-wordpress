
//
// npm packages
//
var gulp       = require('gulp'),
    fs         = require('fs'),
    rename     = require('gulp-rename'),
    watch      = require('gulp-watch'),

    // svg
    svgmin     = require('gulp-svgmin'),
    svgmin     = require('gulp-svgstore'),

    // concat/uglify
    concat     = require('gulp-concat'),
    uglify     = require('gulp-uglify'),
    
    // sass
    sass       = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps');

//
// local vars
//
var themeDir = 'webroot/wp-content/themes/_s/';

//
// SETUP
//
var setup     = require( './setup.json' ),
    jsModules = setup.jsModules;


/* --------------------------------------------
 * --util
 * -------------------------------------------- */

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



/* --------------------------------------------
 * --gulp
 * -------------------------------------------- */

gulp.task('default', function() {

    // -- svgmin (minify svg)
    gulp.src( themeDir + 'svg/*.svg' )
        .pipe(svgmin())
        .pipe(gulp.dest( themeDir + '/svg/build'));
        

    // -- concat js
    gulp.src( [themeDir + 'js/plugins.js', themeDir + 'js/main.js'])
        .pipe(concat('production.js'))
        .pipe(gulp.dest( themeDir + 'js/build' ));


    // -- ugilfy
    gulp.src( themeDir + 'js/build/production.js')
        .pipe(uglify())
        .pipe(rename({
            extname: '.min.js'
        }))
        .pipe(gulp.dest( themeDir + '/js/build' ));

});

//
// svg store
//
gulp.task('svgstore', function () {
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
});

//
// compile sass
//
gulp.task('sass', function(){
    gulp.src( themeDir + 'css/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            errLogToConsole: true
        }).on('error', sass.logError))
        .pipe( sourcemaps.write('.', {
            includeContent: false, sourceRoot: 'src'
        }) )
        .pipe(gulp.dest( themeDir + 'css/build/' ));
});

//
// watch the sass directory
//
gulp.task('watch', function(){
    gulp.watch( themeDir + 'css/*.scss' , ['sass']);
});


//
// build from arsenal
//
gulp.task('build-scripts', function(){

    var activeJs = getActiveJSModules();

    for( var i = 0; i < activeJs.length ; i++ ){

        var enabledpath   = themeDir + 'js/arsenal/enabled/' + activeJs[i] + '.js',
            availablePath = themeDir + 'js/arsenal/available/' + activeJs[i] + '.js';

        try{
            fs.statSync(enabledpath);
        } catch( e ){
            console.log(e);
            gulp.src( availablePath )
                .pipe( gulp.dest( themeDir + 'js/arsenal/enabled/' ));
        }
    }
});
