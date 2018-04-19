# WordPress Starter Kit

A starter kit for WordPress builds from scratch. Includes WordPress core and a very barebones theme based on [_s](https://github.com/Automattic/_s/).

This site is also set up to run with Docker and Ups Dock. Running the install script will build the the Docker containers, install necessary packages, install [WP-CLI](https://wp-cli.org/), and then install WordPress and configure your `wp-config.php` to hit the right database. It will also enable the ACF Pro and WP Migrate DB plugins.

Quick links:
* [Docker commands](#docker-commands)
* [Gulp tasks](#gulp-tasks)
* [API reference](#api-reference)



## Getting set up
1. Make sure [Ups Dock](https://github.com/Upstatement/ups-dock) is installed and up and running.
1. Download and extract this repo.
1. Run `npm install` to install gulp and get all that good stuff set up for theming.
1. Copy `.env.sample` to `.env` and update to reflect your theme values.
1. In the theme directory, update `style.css` to reflect your theme values.
1. From the root directory, run `./bin/install.sh`.

Once compiled, you should be able to access your WordPress installation via `ups.dock` using the subdomain you set up.



## The Javascript Structure
The Javascript for this projects utilizes Babel to utilize ES6 syntax, as well as some Browserify goodness to enable Javascript modules. There are some starting modules in the `webroot/wp-content/themes/sherman/js/arsenal` directory; to enable any of these modules, import them into the javascript file that you're going to use the module in.



## Custom Page Blocks
This theme uses Advanced Custom Fields to create a Flexible Content field for the "page" content type that allows the user to add additional content blocks onto that page. To set this functionality up, simply import the `acf-page-blocks.json` file in the `_imports` directory.

Once you import the json file you will find a "Page Blocks" field group in the ACF admin section. This will include a Flexible Content field called `Page Blocks` that will start off with one layout, the "Simple Copy Block."

To add a new block, duplicate the `block.php` file inside the `blocks` directory in the theme, and rename the copied file to reflect the function of the block (include a leading `block-` in the filename). Back in the ACF admin and the "Page Blocks" field group, add a new layout and add the relevant fields for that layout. The "name" field for this layout should match the php file name (*without* the trailing `.php`). For example, if you created a block called `block-latest_blog_posts.php`, you would name the layout `latest_blog_posts`.

When you add a new layout, this block will be available in the "Page Blocks" field group on all pages.



## WordPress Imports
Inside the `_imports` directory, there are some `.json` files that can be imported into ACF to add common components.

#### `acf-page-blocks.json`
The Advanced Custom Fields setup for page blocks. Creates an additional Flexible Content field for pages that allows for the addition of secondary blocks onto that page. See the [custom page blocks](#custom-page-blocks) section below.



## Admin Filters
Within the theme directory, there are some admin filters in place in the `lib/admin` directory that extend the administrative functionality. Check out the files in that directory to add WYSIWYG styles, add columns for custim fields to post types, adjust the administrative interface, and more.



## A database directory?
The `.gitignore` ignores the `db/` directory, but the Docker container mounts this so that any db dump tha is added to this directory can be accessed by the WP CLI.



## Docker commands

To start the container, run `docker-compose up -d`.

To stop the container, run `docker-compose stop`.

To run a command with WP CLI, run `docker-compose exec wordpress wp [command]`.

To SSH into the container, run `docker-compose exec wordpress /bin/bash`.

To import a database, run `./bin/import.sh [path_to_db]`.



## Gulp Tasks
Gulp is used to maintain and complete a number of tasks for the site, including compiling sass and babelifying the javascript. You can use `gulp help` to get an overview of the tasks present in this project, or use the reference below.

#### `gulp`
Runs the watcher.

#### `gulp help`
List all the tasks defined in the gulpfile, and see a description of what they do.

#### `gulp build`
Builds the Javascript using the ES6 modules and running all the files through Babel to get us down to ES5.

#### `gulp minify`
Minify the compiled Javascript.

#### `gulp styles`
Compiles sass.

#### `gulp watch`
Watch the sass and Javascripts within the theme for changes, and then run the appropriate compiler.



## API Reference

### Getting fields

#### `sk_the_field( $field, $args = array() )`

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

#### `sk_get_field( $field, $args = array() )`
Wrapper to call the `sk_the_field()` function with the `return` parameter set to TRUE.

#### `sk_the_subfield( $field, $args = array() )`
Wrapper to call the `sk_the_field()` function with the `sub_field` parameter set to TRUE.

#### `sk_get_subfield( $field, $args = array() )`
Wrapper to call the `sk_the_field()` function with the `sub_field` and `return` parameters set to TRUE.

#### `sk_block_field( $field, $args = array() )`
Wrapper to display a field within a block. Since the page blocks utilizes an ACF repeater field, this is an alias of `sk_the_subfield()`.


### Rendering

#### `sk_the_page_blocks()`
Hooks into the ACF repeater field to render all the additional page blocks for a page. Calls tempaltes in the blocks/ directory



## Theme Filters
There are a number of filters that can be used to handle values within the theme. The source for these filters can be found in `inc/filters.php`.

#### `sk_image_markup`
Filter for handling an image object from the database and returning a valid img tag with the appropriate src from that image object. This filter can be passed an associative array with the following values:

* `img_size` (string) : The registered image size in WordPress

#### `sk_link_email`
Renders an email address as a linked link.

#### `sk_sanitize_svg`
Sanitize any values coming through the CMS that should be output as HTML and make sure that it's svg code.

#### `sk_youtube_video_embed`
Renders markup for a youtube video embed from a YouTube video ID.
