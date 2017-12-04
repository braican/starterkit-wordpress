//
// npm packages
//
const gulp = require('gulp-help')(require('gulp'));
const exit = require('gulp-exit');
const rename = require('gulp-rename');
const fs = require('fs');

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

// inject (for the arsenal)
const inject = require('gulp-inject-string');


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

files.sass = {
    dir   : `${themeDir}/styles`,
    src   : `${themeDir}/styles/sass/**/*.scss`,
    build : `${themeDir}/styles/build`,
};

files.js = {
    src   : `${themeDir}/js/src/main.js`,
    build : `${themeDir}/js/build`,
};

//
// SETUP
//

const setup = require('./setup.json');


/* ------------------------------------------
 * --util
 * ------------------------------------------ */


/**
 * returns an array of content types that should be registered for
 *  this project, per the setup.json file
 *
 * @return array
 */
function getContentTypes() {
    const ct = [];
    const modules = setup.contentTypes;

    Object.keys.forEach((module) => {
        if (modules[module] === true) {
            ct.push(module);
        }
    });

    return ct;
}


/**
 * Concatenates the code from each of the active post types templates.
 *
 * @return string
 */
function getPostTypeCode() {
    const contentTypes = getContentTypes();
    let typeCode = '';

    for (let i = 0; i < contentTypes.length; i += 1) {
        const file = `./_arsenal/post-types/${contentTypes[i]}.php`;

        try {
            const fileContent = fs.readFileSync(file);
            typeCode += `${fileContent}\n\n`;
        } catch (e) {
            console.error(`Warning: couldn't write ${e.path}; please make sure that file exists.`);
        }
    }

    return typeCode;
}


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
            .pipe(source(files.js.build))
            .pipe(buffer())
            .pipe(sourcemaps.init({ loadMaps : true }))
            .pipe(rename('production.js'))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(files.js.build));
    }

    if (watchIt) {
        bundler.on('update', () => {
            console.log('--> rebundle...done');
            rebundle();
        });
        rebundle();
    } else {
        rebundle().pipe(exit());
    }
}

gulp.task('build', 'Build the Javascript and compile down to ES5', () => compile());

gulp.task('minify', 'Minify the compiled Javascript', ['build'], () => gulp.src(files.js.build)
    .pipe(uglify())
    .pipe(rename({ extname : '.min.js' }))
    .pipe(gulp.dest(files.js.build)));


/* --------------------------------------------
 * --sass
 * -------------------------------------------- */

gulp.task('styles', 'Compile that sass.', () => {
    gulp.src(files.sass.src)
        .pipe(sourcemaps.init())
        .pipe(sass(config.sass).on('error', sass.logError))
        .pipe(autoprefixer(config.autoprefixer).on('error', (err) => { console.log(err); }))
        .pipe(sourcemaps.write('.', config.sourcemaps))
        .pipe(gulp.dest(files.sass.build))
});


/* --------------------------------------------
 * --arsenal
 * --------------------------------------------*/

/**
 * build from arsenal
 */
const buildArsenalHelp = 'Using the "setup.json" config file in the document root, write copy enabled arsenal files into the appropriate place within the theme.';
gulp.task('build-arsenal', buildArsenalHelp, () => {
    //
    // register the content types
    //
    const typeCode = getPostTypeCode();

    gulp.src('./_arsenal/_templates/post-types.php')
        .pipe(inject.replace('//sk_insert_types//', typeCode))
        .pipe(gulp.dest(`${themeDir}/arsenal`));
});


/* --------------------------------------------
 * --default
 * -------------------------------------------- */

gulp.task('default', 'Run the watch task', ['watch']);


gulp.task('watch', 'Watch the `javascript` and `styles` directories for changes', () => {
    compile(true);
    gulp.watch(files.sass.src, ['styles']);
});
