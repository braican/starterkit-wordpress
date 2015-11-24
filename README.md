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



A database directory?
---------------------

I know there's some back and forth between whether putting a database dump into a git repo is a good idea or not, but since most WordPress database dumps are relatively small, I'm leaving this as a good solution for data in version control.

