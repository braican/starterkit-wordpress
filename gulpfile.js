var gulp       = require('gulp'),
    svgmin     = require('gulp-svgmin'),
    concat     = require('gulp-concat'),
    uglify     = require('gulp-uglify'),
    rename     = require('gulp-rename'),
    sass       = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps');


var themeDir = 'webroot/wp-content/themes/_s/';

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

    gulp.watch( themeDir + 'css/*.scss' , ['styles']);

});

gulp.task('styles', function(){
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