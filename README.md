WordPress Starter Kit
=====================

A starter kit for WordPress builds from scratch. Includes WordPress core and a custom, completely barebones theme. As in, absolutely no styling and a very basic structure.

Theme based on [_s](https://github.com/Automattic/_s/).

Getting Started
---------------
1. Run `npm install` to install gulp and get all that good stuff set up.
1. Open `setup.json` and choose the javascript modules you'll want to use in this project (you can always adjust this later). Then run `gulp build-scripts` to copy the appropriate scripts into the working directory.
1. Update the stylesheet header in `style.css` to reflect the proper information.
1. If you haven't created a database for this site, do that now.
1. Copy the `wp-sample-config.php` and add the appropriate database credentials.
1. Install WordPress.
1. Upon logging in for the first time, change the theme under Appearance > Themes to the newly created theme.


Setting up this project
-----------------------
1. Clone this repo.
1. Run `npm install` to install gulp and get all that good stuff set up.
1. Install the database, from wherever you can get it. Worse case, there is a `db` directory in here, use the most recent dump in there.
1. Create `wp-config.php` by copying the `wp-sample-config.php` and add the appropriate database credentials.


API Reference
-------------
The wiki of this repo contains documentation for this theme's functions.


Namespacing
-----------
Functions are namespaced with the prefix `sk`.


The Javascript Structure
------------------------

The Javascript is organized in the following way (all file paths are relative to the theme path, unless otherwise noted):

* Individual modules are located inside the `js/arsenal` directory. The templated scripts are located in the `js/arsenal/available` subdirectory; *these should not be edited inside an individual project*. Use the `setup.json` file (located in the project root) to choose which of these modules you'll need for this project, and the `gulp build-scripts` command to copy the appropriate modules into the working directory. This will build a `js/arsenal/enabled` directory, which will contain all project-specific js modules. Modules inside the `js/arsenal/enabled` directory can be edited where appropriate for the project.
* All third-party plugins that stand alone from a standardized module pattern should go in the `js/plugins.js` file.
* All project-specific scripts and front-end code should go into the `js/main.js` file.
* Upon running the `gulp opt-js` task, a `js/production.js` file will be built, and a minified version will be placed into the `js/build` directory.


Gulp Tasks
----------

Gulp is used to maintain and complete a number of tasks for the site, including compiling sass, optimizing svgs, and more. You can use `gulp help` to get an overview of the tasks present in this project, or use the reference below.

#### `gulp`
Runs the default task, which is nothing at the moment.

#### `gulp help`
List all the tasks defined in the gulpfile, and see a description of what they do.

#### `gulp combine`
Concatenates all the javascripts from the arsenal, any plugin scripts, and the main js file

#### `gulp uglify`
Optimizes javascript by concatenating all the enabled arsenal scripts, the plugins, and the main js file, then minifying that file.

#### `gulp opt-svg`
Optimizes svgs.

#### `gulp svgstore`
Creates the svg sprite for insertion into the page.

#### `gulp sass`
Compiles sass.

#### `gulp watch`
Watch the `css` directory within the theme to changes to any `.scss` files.

#### `gulp build`
Using the `setup.json` file, builds the `js` directory within the theme with the appropriate js scripts.


WordPress Imports
-----------------
Inside the `_imports` directory, there are some `.xml` files that can be imported into the WordPress installation to add common components.

#### `acf--page-blocks.xml`
The Advanced Custom Fields setup for page blocks. Creates an additional field for pages that allows for the addition of modules onto that page. See the [custom page blocks](#custom-page-blocks) section below.

Upon importing these fields

#### `acf--location-fields.xml`
Fields for the Location content type.


Custom Page Blocks
------------------
This theme uses Advanced Custom Fields to create a field for the "page" content type that allows the user to add additional modules, or content blocks, onto that page. To set this functionality up: 

1. Install the `Advanced Custom Fields` and `Advanced Custom Fields: Repeater Field` plugins.
1. Import the `acf--page-blocks.xml` file in the `_imports` directory.

Once you import the xml file you will find a "Page Blocks" field group in the ACF admin section. This will include a repeater field called `Additional Page Blocks` containing two sub-fields:

#### `Block Module`
An html select element containing all of the available block modules that can be included on a page

#### `Block Title`
A title for this block. Depending on the theme implementation, this value can be used in the theme as a heading for this block.

To add a new module to the page blocks, duplicate the `module.php` file inside the `modules` directory in the theme, and rename the copied file to reflect the function of the module (include a leading `module-` in the filename). Back in the ACF admin, find the "Block Module" subfield in the "Page Blocks" field group and create a new choice using the module file name (*without* the trailing `.php`) and a label for the module. For example, if you created a module called `module-latest-blog-posts.php`, you would add the following to the "Choices" field:

`module-latest-blog-posts : Latest Blog Posts`

When you add a new block to a page, this module will be available in the "Block Module" dropdown.


Going Live
----------

In production, set the environment variable WP_ENV variable in apache to "production" to enqueue the production scripts and styles.

```sh
SetEnv WP_ENV "production"
```


A database directory?
---------------------

I know there's some back and forth between whether putting a database dump into a git repo is a good idea or not, but since most WordPress database dumps are relatively small, I'm leaving this as a good solution for data in version control.

