# Luna Global Options

The Global Option area in the CMS is set up in the `Luna_Global_Options` class (found in `/inc/class-luna-global-options.php`), via the inherited `parent::__construct()` method. 

The settings array returned from ACF when register Global Options is accessible via `$luna->global_options`.

## Sub-pages

The Global Options area consists of a list of sub-pages. A number of these are added by default, including:

- General
- Header
- Footer
- Social
- 404
- Search

The settings array for each of these are also added to the `$luna->global_options`.

The General sub-page has a number of default fields added to it which are usually required for all sites. These are set up using Local JSON with the field group's JSON file available within the starter theme.

### Add a sub-page 

More sub-pages can be added to the `__construct()` of `Luna_Global_Options` class using inherited functionality from the base class.

**Usage:**
```php
/**
 * @param string $title [required] The sub page title as a human-readable string.
 *
 * @return void This does not need to be assigned to a variable.
 *              The sub-page settings array will be added to $luna->global_options.
 */
$this->add_sub_page( $title );
```

### Getting field data

Unlike the previous starter theme Stella, fields are not actually added to the Global Options page as this just acts as a grouping object for the sub-pages mentioned above. In order using the `add_sub_page()` method sets the option slug to: `sanitize_title( $sub_page_title ) . '-options'`

The pre-set sub-page slugs are as follows:

| Sub-page title | Slug |
| ----------- | ----------- |
| General | `general-options` |
| Header | `header-options` |
| Footer | `footer-options` |
| Social | `social-options` |
| 404 | `404-options` |
| Search | `search-options` |

**Example:**

*Example for setting and getting a custom sub page. This assumes a field called "Mission Name" has been added to the sub-page in the CMS.*

```php
public function __construct() {
  ...

  $this->add_sub_page( 'Luna Mission' );

  ...
}
```

```php
$mission_name = get_field( 'mission_name', 'luna-mission-options' );
```

## Handling Global Options data

If possible, Global Options data which isn't used directly in a template or template part file should be processed within the Global Options class, including the use of hooks.

### Default options

The field data from the default fields in *Global Options > General* sub-page are handled within `Luna_Base_Global_Options`. This includes:

- Adding the [Civic Cookie Control](https://www.civicuk.com/cookie-control/documentation) options to the cookie consent widget (see `/js/src/cookie-control.js`)
- Enqueuing the Google Maps API script if an API key has been provided
- Embedding custom header, body and footer scripts into the theme
- Setting security headers

### Custom site options

If possible, it is encouraged to handle data saved in the Global Options area within `Luna_Global_Options`, similar to how the default fields are handled in the General sub page.
