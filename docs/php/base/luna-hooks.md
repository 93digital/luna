# Luna hooks

There are a number of custom hooks baked into some of the base classes of Luna. These all start with the prefix of `luna_` and are listed below.

## luna_localize_script

Filters the list of core localised variables for the main theme script.

**Usage:**
```php
/**
 * 'luna_localize_script' filter hook.
 * Allows custom localised data to be added to the luna JavaScript object.
 *
 * @param array $data The default localised data.
 * @return array A filtered localised data array.
 */
apply_filters( 'luna_localize_script', $data );
```

**Example:**
```php
public function __construct() {
  ...

  add_filter( 'luna_localize_script', [ $this, 'localise_custom_data' ] );

  ...
}
```

```php
/**
 * 'luna_localize_script' filter hook callback.
 * Add some custom data to be localised.
 *
 * @param array $data The default localised data.
 * @return array $data An updated data array.
 */
public function localise_custom_data( $data ) {
  $data['foo'] = 'bar';
  return $data;
}
```

```javascript
console.log( luna.foo ); // Outputs 'bar'!
```

## luna_enqueue_script

Filers the list of script dependencies for the main theme script, `/build/index.js`.

This filter hook should be used to enqueue any custom scripts that need to be dependencies of the main theme script.

**Usage:**
```php
/**
 * 'luna_enqueue_script' filter hook.
 * Filter script dependency handles. Allows custom handles to be added as dependencies.
 *
 * @param array $script_deps Default script dependencies.
 * @return array An updated array possibly containing additional script dependencies.
 */
apply_filters( 'luna_enqueue_script', $script_deps );
```

**Example:**
```php
public function __construct() {
  ...

  add_filter( 'luna_enqueue_script', [ $this, 'enqueue_custom_script' ] );

  ...
}
```

```php
/**
 * 'luna_enqueue_script' filter hook callback.
 * Enqueue a script and return its handle as a dependency of the main theme script.
 *
 * @param array $deps List of default script dependencies.
 * @return array List of dependencies with our custom script handle added.
 */
public function enqueue_custom_script( $deps ) {
  $handle = 'foobar-script';

  // Enqueue the foobar script!
  wp_enqueue_script(
    $handle,
    'https://foo.bar/foobar.js',
  );

  // Add the script's handle as a dependency.
  $deps[] = $handle;

  // Return the dependencies, 'foobar-script' will now be a dependency of /build/index.js.
  return $deps;
}
```

## luna_enqueue_blocks_script

Filers the list of script dependencies for the Gutenberg blocks script, `/build/blocks.js`. Similar to `luna_enqueue_script`.

This filter hook should be used to enqueue any custom blocks scripts that need to be dependencies of the Gutenberg blocks script.

**Usage:**
```php
/**
 * 'luna_enqueue_blocks_script' filter hook.
 * Filter blocks script dependency handles. Allows custom handles to be added as dependencies.
 *
 * @param array $script_deps Default blocks script dependencies.
 * @return array An updated array possibly containing additional script dependencies.
 */
apply_filters( 'luna_enqueue_blocks_script', $script_deps );
```

**Example:**
```php
public function __construct() {
  ...

  add_filter( 'luna_enqueue_blocks_script', [ $this, 'enqueue_custom_blocks_script' ] );

  ...
}
```

```php
/**
 * 'luna_enqueue_blocks_script' filter hook callback.
 * Enqueue a custom script and return its handle as a dependency of the blocks script.
 *
 * @param array $deps List of blocks script dependencies.
 * @return array List of dependencies with our custom script handle added.
 */
public function enqueue_custom_blocks_script( $deps ) {
  $handle = 'foo-bar-blocks';

  // Enqueue the foo bar blocks script!
  wp_enqueue_script(
    $handle,
    'https://foo.bar/blocks.js',
  );

  // Add the script's handle as a dependency.
  $deps[] = $handle;

  // Return the dependencies.
  return $deps;
}
```

## luna_enqueue_style

Filters the main theme stylesheet `style.css` dependencies.

This allows for custom stylesheets to be enqueued which are dependencies of the main stylesheet.

**Usage:**
```php
/**
 * 'luna_enqueue_style' filter hook.
 * Filter the list of stylesheet dependencies. Allows custom stylesheets to be enqueued and set as a dependency of style.css
 *
 * @param array $style_deps Default stylesheet dependencies.
 * @return array An updated array of stylesheet dependencies.
 */
apply_filters( 'luna_enqueue_style', $style_deps );
```

**Example:**
```php
public function __construct() {
  ...

  add_filter( 'luna_enqueue_style', [ $this, 'enqueue_custom_stylesheet' ] );

  ...
}
```

```php
/**
 * 'luna_enqueue_style' filter hook callback.
 * Enqueue a custom stylesheet as a dependency of style.css.
 *
 * @param array $deps Default stylesheet dependencies.
 * @return array List of dependencies with our custom script handle added.
 */
public function enqueue_custom_stylesheet( $deps ) {
  $style_handle = 'stylish-foo-bar';

  // Enqueue out stylish foo bar.
  wp_enqueue_style(
    $style_handle,
    `https://foo.bar/stylish.css`
  );

  // Add the stylesheet's handle as a dependency.
  $deps[] = $style_handle;

  // Return the dependencies.
  return $deps;
}
```

## luna_enqueue_admin_style

Filters the admin stylesheet `style-editor.css` dependencies. Similar to `luna_enqueue_style`.

This allows for custom stylesheets to be enqueued which are dependencies of the admin stylesheet.

**Usage:**
```php
/**
 * 'luna_enqueue_admin_style' filter hook.
 * Filter the list of stylesheet dependencies. Allows custom stylesheets to be enqueued and set as a dependency of style-editor.css.
 *
 * @param array $style_deps Default stylesheet dependencies.
 * @return array An updated array of stylesheet dependencies.
 */
apply_filters( 'luna_enqueue_admin_style', $style_deps );
```

**Example:**
```php
public function __construct() {
  ...

  add_filter( 'luna_enqueue_admin_style', [ $this, 'enqueue_custom_admin_stylesheet' ] );

  ...
}
```

```php
/**
 * 'luna_enqueue_admin_style' filter hook callback.
 * Enqueue a custom stylesheet as a dependency of style-editor.css.
 *
 * @param array $deps Default stylesheet dependencies.
 * @return array List of dependencies with our custom script handle added.
 */
public function enqueue_custom_admin_stylesheet( $deps ) {
  $style_handle = 'stylish-admin-foo-bar';

  // Enqueue out stylish foo bar.
  wp_enqueue_style(
    $style_handle,
    `https://foo.bar/stylish-admin.css`
  );

  // Add the stylesheet's handle as a dependency.
  $deps[] = $style_handle;

  // Return the dependencies.
  return $deps;
}
```

## luna_no_defer

Filters the list of non-deferred JavaScript files.

By default all JS files in the theme will be deferred, with the exception of the main JS file (`/build/index.js`), dependencies of the main script file and jQuery. This is to help improve page load performance.

This hook allow scripts which don't fall into the default exceptions to not be deferred.

**Usage:**
```php
/**
 * 'luna_no_defer' filter hook.
 * Filter script non-deferred script handles. Allow custom handles to be added to the list of handles which aren't deferred.
 *
 * @param array $handles Default script handles which aren't deferred.
 * @return array Updated array of script handles which won't be deferred.
 */
apply_filters( 'luna_no_defer', $handles );
```

**Example:**
```php
public function __construct() {
  ...

  add_filter( 'luna_no_defer', [ $this, 'custom_script_no_defer' ] );

  ...
}
```

```php
/**
 * 'luna_no_defer' filter hook callback.
 * Prevent an enqueued custom script from being deferred.
 *
 * @param array $handles Default list of script handles which won't be deferred.
 * @return array $handles Updated list including the custom script handle.
 */
public function custom_script_no_defer( $handles ) {
  $handles[] = 'foobar-script';
  return 'foobar-script';
}
```

## luna_gform_fields

Filters an array of ACF field names which will automatically have a list of Gravity Forms added.

Ideally these fields should be select (dropdown) fields. The dropdown options will then be populated with a list of all the available forms on the site.

**Usages:**
```php
/**
 * 'luna_gform_fields' filter hook.
 * Filter the gform dropdown fields.
 * Allows custom fields to be defined which will be populated with a list of forms from GF.
 *
 * @param array $gform_fields Default gravity form fields (basically just 'gravity_form')
 * @return array Updated list of fields.
 */
apply_filters( 'luna_gform_fields', $gform_fields );
```

**Example:**
```php
public function __construct() {
  ...

  add_filter( 'luna_gform_fields', [ $this, 'add_gform_fields' ] );

  ...
}
```

```php
/**
 * 'luna_gform_fields' filter hook callback.
 * Add the gform dropdown to an ACF block field.
 *
 * @param array $fields Current list of gform dropdown fields.
 * @return array Updated list of gform dropdown fields.
 */
public function add_gform_fields( $fields ) {
  $fields[] = 'm00-form-selector';
  return $fields;
}
```
