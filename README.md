WordPress Starter Kit
=====================

A starter kit for WordPress builds from scratch. Includes WordPress core and a custom, completely barebones theme. As in, absolutely no styling and a very basic structure.

Theme based on [_s](https://github.com/Automattic/_s/).

Getting Started
---------------
1. Run the `rename.php` script: `php rename.php YOURTHEMENAME`.
2. Copy the `wp-sample-config.php` and add the appropriate database credentials.
3. Update the stylesheet header in `style.css` to reflect the proper information.
4. Install WordPress.

Manual Installation
-------------------

If the rename script doesn't work, you may have to do the search/replace manually. In place of #1 above:

1. Rename the theme to your theme's name.
2. Rename the `WP_DEFAULT_THEME` variable in `wp-sample-config.php` to your theme's name.
3. In main.js, do a search/replace for `_s` to change the namespace to your theme's name.
4. Run the following search and replaces: **IMPORTANT: Make sure you are running the following search and replace steps inside the theme directory, and NOT all of WordPress core.**
 * Search for `'_s'` (inside single quotations) to capture the text domain (replace with `'themename'`).
 * Search for `_s_` to capture all the function names (replace with `themename_`).
 * Search for `Text Domain: _s` in style.css (replace with `Text Domain: themename`).
 * Search for <code>&nbsp;_s</code> (with a space before it) to capture DocBlocks (replace with <code>&nbsp;Themename</code>).
 * Search for `_s-` to capture prefixed handles (replace with `themename-`).


A database directory?
---------------------

I know there's some back and forth between whether putting a database dump into a git repo is a good idea or not, but since most WordPress database dumps are relatively small, I'm leaving this as a good solution for data in version control.

