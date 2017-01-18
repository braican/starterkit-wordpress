WordPress Starter Kit
=====================

A starter kit for WordPress builds from scratch. Includes WordPress core and a custom, completely barebones theme. As in, absolutely no styling and a very basic structure.

Theme based on [_s](https://github.com/Automattic/_s/).

Getting Started
---------------
1. Download this repo from the Downloads link on the left. Extract the contents and add all the files to your project. Don't forget to set up your local apache to point to the `webroot` directory.
1. Run `git init` to init the git repo, `git add -A` to add all the files, and `git commit -m "initial commit"` to add all the files. Once you've set up your remote repo, `git push` to that remote.
1. Run `npm install` to install gulp and get all that good stuff set up.
1. Create your database for this site, and copy your `wp-sample-config.php` file to `wp-config.php` and add the appropriate database credentials.
1. (OPTIONAL) If you're going to use any common components (for example, you're building a Tank Standard Issue site), open `setup.json`. This file contains json that allows you to opt into common javascript components and content types. Set the components you wish to use to `true` and save the file. Run `gulp build` to build theme files containing your selected components.
1. Navigate to the site (remember, you probably want to have added a subdomain in your virtual hosts in apache), and install WordPress.

Once you've set all this up, log into the site and do a couple things:
1. Change the theme under Appearance > Themes to the "Sherman" theme
1. Head over to the plugins page and activate "Advanced Custom Fields PRO" and "WP Migrate DB"


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

* Available javascript modules are located in the `_arsenal/js` directory. Use the `setup.json` file in the webroot to choose which of these modules (if any) you'll need for this project, and run the `gulp build-arsenal` command. This will place the activated modules inside the theme at `js/arsenal`.
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

#### `gulp opt-js`
Optimizes javascript by concatenating all the enabled arsenal scripts, the plugins, and the main js file, then minifying that file.

#### `gulp svgstore`
Creates the svg sprite for insertion into the page.

#### `gulp sass`
Compiles sass.

#### `gulp watch`
Watch the `css` directory within the theme to changes to any `.scss` files.

#### `gulp build-arsenal`
Using the `setup.json` file, populates the theme with the chosen build components, including javascript modules and WordPress content types.



WordPress Imports
-----------------
Inside the `_imports` directory, there are some `.json` files that can be imported into ACF to add common components.

#### `acf-page-blocks.json`
The Advanced Custom Fields setup for page blocks. Creates an additional Flexible Content field for pages that allows for the addition of secondary blocks onto that page. See the [custom page blocks](#custom-page-blocks) section below.



Custom Page Blocks
------------------
This theme uses Advanced Custom Fields to create a Flexible Content field for the "page" content type that allows the user to add additional content blocks onto that page. To set this functionality up: 

1. Enable the `Advanced Custom Fields Pro` plugin.
1. Import the `acf-page-blocks.json` file in the `_imports` directory.

Once you import the json file you will find a "Page Blocks" field group in the ACF admin section. This will include a Flexible Content field called `Page Blocks` that will start off with one layout, the "Simple Copy Block."

To add a new block, duplicate the `block.php` file inside the `blocks` directory in the theme, and rename the copied file to reflect the function of the block (include a leading `block-` in the filename). Back in the ACF admin and the "Page Blocks" field group, add a new layout and add the relevant fields for that layout. The "name" field for this layout should match the php file name (*without* the trailing `.php`). For example, if you created a block called `block-latest_blog_posts.php`, you would name the layout `latest_blog_posts`.

When you add a new layout, this block will be available in the "Page Blocks" field group on all pages.


Going Live
----------

In production, set the environment variable WP_ENV variable in apache to "production" to enqueue the production scripts and styles.

```sh
SetEnv WP_ENV "production"
```


A database directory?
---------------------

I know there's some back and forth between whether putting a database dump into a git repo is a good idea or not, but since most WordPress database dumps are relatively small, I'm leaving this as a good solution for data in version control.