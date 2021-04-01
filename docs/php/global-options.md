# Luna Global Options

Global Options is set up using the `Luna_Global_Options` class (via the `Luna_Base_Global_Options` parent class) and its settings array added to the `$luna->global_options` object as a property.

## Sub-pages

The Global Options section consists of a number of sub-pages. A number of these are added by default, including:

- General
- Header
- Footer
- Social
- 404
- Search

These are also added to the `$luna->global_options` as array elements of a sub-page settings array.

The General sub-page has a number of default fields added to it which are generally required for all sites. These are set up using Local JSON with the field group's JSON file baked into Luna.

### Add a sub-page 

More sub-pages can be added to the `__construct()` of `Luna_Global_Options` class using inherited functionality from the base class.

**Usage:**
```php
/**
 * @param string $title [reqruired] The sub page title as a human-readable string.
 *
 * @return void This does not need to be assigned to a variable.
 *              The sub-page settings array will be added to $luna->global_options.
 */
$this->add_sub_page( $title );
```

## Handling Global Options data

### Default options

The field data from the default fields in Global Options > General sub-page are handled within `Luna_Base_Global_Options`. This includes:

- Adding the Civic Cookie Control options to the cookie consent widget (see `/js/src/cookie-control.js`)
- Enqueuing the Google Maps API script if an API key has been provided
- Embedding custom header, body and footer scripts into the theme
- Setting security headers

### Custom site options

If possible, any handling of any custom sub-page field data should be done within `Luna_Global_Options`, similar to how the default fields are handled in the General sub page.
