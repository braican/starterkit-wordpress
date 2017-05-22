WordPress Starter Kit
=====================

A starter kit for WordPress builds from scratch. Includes WordPress core and a custom, completely barebones theme. As in, absolutely no styling and a very basic structure.

Theme based on [_s](https://github.com/Automattic/_s/).

Getting Started
---------------
1. Run `npm install` to install gulp and get all that good stuff set up.
1. Open `setup.json`. This file contains json that allows you to opt into common javascript components and content types. Set the components you wish to use to `true` and save the file. Run `gulp build` to build theme files containing your selected components.
1. Update the stylesheet header in `style.css` to reflect the proper information for your theme.
1. If you haven't created a database for this site, do that now.
1. Copy the `wp-sample-config.php` to `wp-config.php` and add the appropriate database credentials.
1. Install WordPress.
1. Upon logging in for the first time, change the theme under Appearance > Themes to the newly created theme, and enable the Advanced Custom Fields and ACF: Repeater plugins.


Setting up this project
-----------------------
1. Clone this repo.
1. Run `npm install` to install gulp and get all that good stuff set up.
1. Install the database, from wherever you can get it. Worse case, there is a `db` directory in here, use the most recent dump in there.
1. Create `wp-config.php` by copying the `wp-sample-config.php` and add the appropriate database credentials.


Namespacing
-----------
Functions are namespaced with the prefix `sk`.



The Javascript Structure
------------------------

The Javascript is organized in the following way (all file paths are relative to the theme path, unless otherwise noted):

* Available javascript modules are located in the project root in the `_arsenal/js` directory. Use the `setup.json` file in the webroot to choose which of these modules (if any) you'll need for this project, and run the `gulp build-arsenal` command. This will place the activated modules inside the theme at `js/arsenal`.
* All third-party plugins that stand alone from a standardized module pattern should go in the `js/src/plugins.js` file.
* All project-specific scripts and front-end code should go into the `js/src/main.js` file.
* Upon running the `gulp opt-js` task, `production.js` will be built, and a minified version will be placed into the `js/build` directory.


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

#### `gulp styles`
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





API Reference
-------------

### Getting fields

####**sk\_the\_field( $field, $args = array() )**
Helper function that enhances the ACF `the_field` function with some optional settings.

`$field` is the string indicating the ACF field to get.

`$args` is an associative array with the following options:

* `id` (int) : Post we're getting the field for.
* `before` (string) : HTML markup to appear before the field.
* `after` (string) : HTML markup to appear after the field.
* `filter` (string) : Any filter you'd like to apply to the field.
* `filter_args` (array) : An associative array that will pass the values to the given filter.
* `sub_field` (boolean) : Whether or not this field is a sub-field. Default is FALSE.
* `default` (mixed) : If the field is undefined, the default value of this function call.
* `return` (boolean) : If true, return the value of this field rather than echo it out. Default is FALSE
* `debug` (boolean) : Debug flag; offers the option to print out helpful debugging data.

If the `return` argument is true, this function returns a string containing the markup with the requested field.


####**sk\_get\_field( $field, $args = array() )**
Wrapper to call the `sk_the_field()` function with the `return` parameter set to TRUE.


####**sk\_the\_subfield( $field, $args = array() )**
Wrapper to call the `sk_the_field()` function with the `sub_field` parameter set to TRUE.


####**sk\_get\_subfield( $field, $args = array() )**
Wrapper to call the `sk_the_field()` function with the `sub_field` and `return` parameters set to TRUE.


####**sk\_block\_field( $field, $args = array() )**
Wrapper to display a field within a block. Since the page blocks utilizes an ACF repeater field, this is an alias of `sk_the_subfield()`.



### Rendering

####**sk\_the\_page\_blocks()**
Hooks into the ACF repeater field to render all the additional page blocks for a page. Calls tempaltes in the blocks/ directory





Theme Filters
-------------

There are a number of filters that can be used to handle values within the theme. The source for these filters can be found in `inc/filters.php`.


####**sk\_image\_markup**
Filter for handling an image object from the database and returning a valid img tag with the appropriate src from that image object. This filter can be passed an associative array with the following values:

* `img_size` (string) : The registered image size in WordPress


####**sk\_link\_email**
Renders an email address as a linked link.


####**sk\_sanitize\_svg**
Sanitize any values coming through the CMS that should be output as HTML and make sure that it's svg code.


####**sk\_youtube\_video\_embed**
Renders markup for a youtube video embed from a YouTube video ID.




Admin Filters
-------------

Within the theme directory, there are some admin filters in place in the `inc/admin.php` file that extend the administrative functionality. Check out that file to add WYSIWYG styles, add columns for custim fields to post types, adjust the administrative interface, and more.
