=== luna ===

Contributors: 93digital
Tags: Luna, 93digital, 93devs, starter-theme, boilerplate

Requires at least: 5.5
Tested up to: 5.6
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==
93Digital's development starter theme, the boilerplate for all our WordPress projects.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Frequently Asked Questions ==

== Changelog ==
0.1 - Luna starter theme rewritten, formally 'Stella'.
0.2 - Bulk of the documentation now written and some structural changes to the PHP code.
0.2.1 - Small update to Global Options and some documentation updates
0.2.2 - Bug fix to the get_field calls in the global options & civic cookie field data checked in the Luna Base. Also made an update to the docs.
0.2.3 - A few more small bug fixes picked up with the theme being used on a couple of production sites for the first time. Also added in the legacy pagination utility function and updated some of the documentation.
0.2.4 - One small bug fix - a typo in a variable name
1.0 - *OFFICIAL RELEASE* Updated some docs and a few last bug fixes before ticking over to v1.
1.0.1 - Small bug fix in the \luna\dump() helper function.
1.0.2 - Small bug fix to move a remove_menu_page() call into the correct hook callback.
1.0.3 - Small bug fix to not include the Composer autoloader when it doesn't exist (the current iteration of the theme does not contain a composer.json file).
1.0.4 - Small bug fix to escape search terms in a utils function
1.1.0 - Edited the name of the theme to '93digital Luna' due to a clash with another Luna theme which was public. A few other additions include the re-introduction of custom login error messages, setting admin columns for taxonomies by default, a fix to the global options class and some documentation updates.
1.1.1 - Added composer.json which contains the Terra package required for most new builds using the theme. Also made a small adjustment to is_debug_mode
1.1.2 - Added some default templates to the theme (index.php, archive.php, home.php, singular.php, search.php, 404.php). These should be retained for all projects.
1.1.3 - Added documentation relating the the templates added in the last iteration. Also added Terra instantiation into the base and a new hooks class for Terra.
1.1.4 - Added share links template part. Updated SCSS files that fix small bugs in the editor. Include base gutenberg block styles. Unregister Gutenberg blocks & update JS files. Add extra image size. Add picture function. Updated SVG icons.

== Credits ==
93digital Development Team
