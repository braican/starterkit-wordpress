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

* individual modules are located inside the `arsenal` directory. The templated scripts are located in the `available` subdirectory; *these should not be edited inside an individual project*. Use the `setup.json` file to choose which of these modules you'll need for this project, and the `gulp build-scripts` command to copy the appropriate modules into the working directory, inside an `enabled` directory. Modules inside the `enabled` directory can be edited where appropriate for the project.
* all third-party plugins that stand alone from a standardized module pattern should go in the `plugins.js` file inside the `js` directory.
* all project-specific scripts and front-end code should go into the `main.js` file inside the `js` directory.
* upon running



A database directory?
---------------------

I know there's some back and forth between whether putting a database dump into a git repo is a good idea or not, but since most WordPress database dumps are relatively small, I'm leaving this as a good solution for data in version control.

