WordPress Starter Kit
=====================

A starter kit for WordPress builds from scratch. Includes WordPress core and a custom, completely barebones theme. As in, absolutely no styling and a very basic structure.

Theme based on [_s](https://github.com/Automattic/_s/).

Getting Started
---------------
1. Run the `rename.php` script: `php rename.php YOURTHEMENAME`.
1. Copy the `wp-sample-config.php` and add the appropriate database credentials.
1. Update the stylesheet header in `style.css` to reflect the proper information.
1. Run `npm install` to install gulp and get all that good stuff set up.
1. Install WordPress.
1. Upon logging in for the first time, change the theme under Appearance > Themes to the newly created theme.
1. Open `setup.json` and choose the javascript modules you'll want to use in this project (you can always adjust this later). Then run `gulp build-scripts` to copy the appropriate modules into the working directory.


The Javascript Structure
------------------------

The Javascript is organized in the following way:

* Individual modules are located inside the `arsenal` directory. The templated scripts are located in the `available` subdirectory; *these should not be edited inside an individual project*. Use the `setup.json` file to choose which of these modules you'll need for this project, and the `gulp build-scripts` command to copy the appropriate modules into the working directory, inside an `enabled` directory. Modules inside the `enabled` directory can be edited where appropriate for the project.
* All third-party plugins that stand alone from a standardized module pattern should go in the `plugins.js` file inside the `js` directory.
* All project-specific scripts and front-end code should go into the `main.js` file inside the `js` directory.
* Upon running the `gulp opt-js` task, a `production.js` file will be built, and a minified version will be placed into the `build` directory within the `js` directory.


Gulp Tasks
----------

Gulp is used to maintain and complete a number of tasks for the site, including compiling sass, optimizing svgs, and more.

* `gulp` - will run the default task, which will optimize the javascript and svgs.
* `gulp opt-js` - concatenates all the javascript (see above) and minifies it, placing a `production.min.js` file into `js/build` within the theme directory.
* `gulp opt-svg` - optimizes svgs.
* `gulp svgstore` - creates the svg sprite for insertion into the page.
* `gulp sass` - compile sass.
* `gulp watch` - watch the `css` directory within the theme to changes to any `.scss` files.
* `gulp build-scripts` - using the `setup.json` file, builds the `js` directory within the theme with the appropriate js modules.


Going Live
----------

In production, set the environment variable WP_ENV variable in apache to "production" to enqueue the production scripts and styles.

```sh
SetEnv WP_ENV "production"
```


A database directory?
---------------------

I know there's some back and forth between whether putting a database dump into a git repo is a good idea or not, but since most WordPress database dumps are relatively small, I'm leaving this as a good solution for data in version control.

