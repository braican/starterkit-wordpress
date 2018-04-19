//
// npm packages
//
const gulp = require('gulp-help')(require('gulp'));
const exit = require('gulp-exit');
const rename = require('gulp-rename');

// babel
const babelify = require('babelify');
const watchify = require('watchify');
const browserify = require('browserify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');

// concat/uglify
const uglify = require('gulp-uglify');

// sass
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');


//
// Config
//

const config = {};

config.sass = {
    errLogToConsole : true,
};


config.sourcemaps = {
    includeContent : false,
    sourceRoot     : 'src',
};

config.autoprefixer = {};

config.browserify = {
    debug : true,
};

config.babelify = {
    presets    : ['env'],
    sourceMaps : true,
};


//
// File system
//

const themeDir = 'webroot/wp-content/themes/sherman';

const files = {};

files.dist = `${themeDir}/static/dist`;

files.scss = {
    dir : `${themeDir}/static/scss`,
    src : `${themeDir}/static/scss/**/*.scss`,
};

files.js = {
    src : `${themeDir}/static/js/main.js`,
};


/* --------------------------------------------
 * --javascript
 * -------------------------------------------- */

function compile(watchIt) {
    const bundler = watchify(browserify(files.js.src, config.browserify)
        .transform(babelify, config.babelify));

    function rebundle() {
        return bundler
            .bundle()
            .on('error', function (err) {
                console.error(err);
                this.emit('end');
            })
            .pipe(source(files.dist))
            .pipe(buffer())
            .pipe(sourcemaps.init({ loadMaps : true }))
            .pipe(rename('production.js'))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(files.dist));
    }

    if (watchIt) {
        bundler.on('update', () => {
            console.log('--> rebundle...done'); // eslint-disable-line
            rebundle();
        });
        rebundle();
    } else {
        rebundle().pipe(exit());
    }
}

gulp.task('build', 'Build the Javascript and compile down to ES5', () => compile());

gulp.task('minify', 'Minify the compiled Javascript', ['build'], () => gulp.src(files.dist)
    .pipe(uglify())
    .pipe(rename({ extname : '.min.js' }))
    .pipe(gulp.dest(files.dist)));


/* --------------------------------------------
 * --sass
 * -------------------------------------------- */

gulp.task('styles', 'Compile that sass.', () =>
    gulp.src(files.scss.src)
        .pipe(sourcemaps.init())
        .pipe(sass(config.sass).on('error', sass.logError))
        .pipe(autoprefixer(config.autoprefixer).on('error', (err) => { console.log(err); })) // eslint-disable-line
        .pipe(sourcemaps.write('.', config.sourcemaps))
        .pipe(gulp.dest(files.dist)));


/* --------------------------------------------
 * --default
 * -------------------------------------------- */

gulp.task('default', 'Run the watch task', ['watch']);


gulp.task('watch', 'Watch the `javascript` and `styles` directories for changes', () => {
    compile(true);
    gulp.watch(files.scss.src, ['styles']);
});
