# Luna templates

## Default templates

The following default templates are included in the Luna boilerplate theme, with some basic code to get you started. These are:

- `404.php`
- `archive.php`
- `home.php`
- `index.php`
- `search.php`
- `singular.php`

You'll notice that all the main templates before `index.php` in the <a href="https://developer.wordpress.org/files/2014/10/Screenshot-2019-01-23-00.20.04.png" target="_blank">template hierarchy diagram</a> are included. This is intentional so that index.php should never really be used, as we believe it is too much of a generalised template for bespoke theme development.

Please ensure that the above templates are kept as you develop with Luna.

More default templates (e.g. `taxonomy.php`, `archive-$posttype.php` etc. ) can be added as needed.

## Custom templates

Any custom templates should be placed in the root of the theme and be appended with `template-` in the filename.

If you are developing with Gutenberg blocks (either React-based or ACF), which this theme is geared towards, it is less likely that custom templates will be required.

## Template parts

### Default template parts

Default template parts, such as `header.php`, `footer.php` and `sidebar.php`, and custom variants of these such as `header-landing-page.php` should all reside in the root of the theme.

Using built in functions like `get_header()` is recommended when trying to include these into templates. These built in functions also will not work if these files are in a sub-directory.

### Custom template parts

Usage of custom template parts is highly encouraged. It reduces both the file sizes and lengths of templates and also reduces redundancy.

All custom template parts should be saved in the `/template-parts` directory, relative to the root of the theme.

