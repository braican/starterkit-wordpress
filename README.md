WordPress Starter Kit
=====================

A starter kit for WordPress builds from scratch. Includes WordPress core and a custom, completely barebones theme. As in, absolutely no styling and a very basic structure.

Theme based on [_s](https://github.com/Automattic/_s/).

Getting Started
---------------
1. Rename the theme to your theme's name
2. In main.js, do a search/replace for `_s` to change the namespace to your theme's name
3. Search for `'_s'` (inside single quotations) to capture the text domain (replace with `'themename'`).
4. Search for `_s_` to capture all the function names (replace with `themename`).
5. Search for `Text Domain: _s` in style.css (replace with `Text Domain: themename`).
6. Search for <code>&nbsp;_s</code> (with a space before it) to capture DocBlocks (replace with <code>&nbsp;Themename</code>).
7. Search for `_s-` to capture prefixed handles (replace with `themename-`).

OR

1. Search for: '_s' and replace with: 'megatherium'
2. Search for: _s_ and replace with: megatherium_
3. Search for: Text Domain: _s and replace with: Text Domain: megatherium in style.css.
4. Search for:  _s and replace with:  Megatherium
5. Search for: _s- and replace with: megatherium-

Then, update the stylesheet header in `style.css` and the links in `footer.php` with your own information.


a database directory?
---------------------

I know there's some back and forth between whether putting a database dump into a git repo is a good idea or not, but since most WordPress database dumps are relatively small, I'm leaving this as a good solution for data in version control.

So place database dumps here.

