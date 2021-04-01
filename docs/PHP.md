# Luna PHP

The theme PHP uses an object-oriented class based system and is centred around a single, global `$luna` theme object. This object should be the home of all custom theme functionality from template utility functions to WordPress hooks.

## File Structure

All Luna PHP code is housed within the `/inc` directory, with the obvious exception that is `functions.php` which acts as the theme bootstrapper.

```
| inc/
  | .config/
  | base/
  | hooks/
    | class-luna-back-end-hooks.php
    | class-luna-front-end-hooks.php
    | class-luna-hooks.php
    | class-luna-shortcodes.php
  | class-luna-cpts.php
  | class-luna-global-options.php
  | class-luna-gutenberg.php
  | class-luna-plugin-utils.php
  | class-luna-utils.php
  | class-luna.php
```

The main `Luna` class, which is instantiated as the global `$luna` object, is found at `/inc/class-luna.php` and is the foundation of the theme.

A number of other sub-classes are found alongside `Luna` in the root of the `/inc` directory. Each of these sub-classes server a specific purpose and are where a lot of custom PHP functionlaity should be added.

All sub-classes baked into the starter theme (and `Luna` itself) each have their own base parent class which contains core  functionality related to the class that inherits it. These base classes are found within `/inc/base`.

> IMPORTANT:<br>
> Custom code should never be added to `functions.php` its sole purpose is as a bootstrapper for the Luna theme. All PHP code should be placed in the `/inc` directory.

### Hooks

All WordPress custom filter and action hook callbacks should be added to the classes in the `/hooks` directory. These are anonomously instantiated within the `Luna_Base` class. These classes are split into a general hooks class, a back end hooks class and a front end hooks class. A shortcodes class is also available here for use.

The purpose of these classes is to try and keep the size of the sub-classes down to a reasonable size. Ideally no hooks will be added to the main `Luna` class or any of the sub-classes.

### Base

The `/base` directory contains theme functionality baked into the core of the theme, split out into a number of abstract classes. As mentioned above, these classes are all extended by the classes in the root of `/inc` directory.

Generally the base classes should not need to be touched and there are some custom Luna hooks to allow extension of some of the base functionality (detailed further down).

### Config

The `/.config` directory contains a number of configutration files which are required to set up the theme environment and instantiate the global `$luna` object. This generally can be ignored.

> IMPORTANT:<br>
> It's is highly discouraged to change any of the code found within `/.config`.


## Basic Usage

The primary purpose of the main `Luna` class is to be a grouping object the sub-classes which are instantiated as properties of the `$luna` object.

The parent class `Luna_Base` handles a lot of general theme set up such as enqueuing styles and scripts, adding custom theme support, instantitating the hook classes and other general customisations.

All theme code should be associated with the `$luna` object as it helps give context to the custom functionality, limits its visibility outside of the scope of the theme and negates the need for PHP namespacing.

### Sub-classes

There are a number of sub-classes baked into Luna, ready for use on projects. At the time of writing these are:

- `Luna_Cpts`
- `Luna_Global_Options`
- `Luna_Gutenberg`
- `Luna_Plugin_Utils`
- `Luna_Utils`

Custom miscellaneous functions can be added to `Luna` in the form of class methods if there is no other logical place to place it and you don't feel it constitutes it's own class.

However, creation of more sub-classes on a project-by-project basis is encouraged, if the developer feels there is a valid use case for it. These would not need base classes as they would be site specific but should be instantiated as properties of the `$luna` global theme object.

### Hooks

All general WordPress hooks that don't fit within one of the sub-classes should be added to a class in the `/inc/hooks` directory. This will help keep the file size of the sub-classes down to a reasonable size and should also help when finding and debugging hooks.

The vast majoroty of custom theme confiuration should be added to a hook callback. If you have add functionality to the theme which isn't within a hook callback, ask yourself whether there is a hook that could be used.

The hook classes baked into Luna at the time of writing are:

- `Luna_Back_End_Hooks`
- `Luna_Front_End_Hooks`
- `Luna_Hooks`
- `Luna_Shortcodes`

The names of these are pretty self-explanatory, with the main `Luna_Hooks` class acting as a home for hooks which are required for both the front and back end.

Similarly the the sub-classes, more custom hook classes can be created here on a project-by-project basis should the need arise.

All `add_action()`, `add_filter()` and `add_shortcode()` hooks should be defined in the `__construct()` method of the relevant class with the hook callback being a public method of the class.

**Usage:**
```php
public function __construct() {
  add_action( 'init', [ $this, 'my_init_hook_callback' ] );
}
```

```php
/**
 * 'init' hook callback
 */
public function my_init_hook_callback() {
  echo 'Hello, Moon!';
}
```

### Development helpers

Two procedural dumper functions, `dump()` and `dump_to_file()`, are available for use outside of the scope of the `$luna` object to aid with development. These are available within the `luna` PHP namespace for the sake of encapsualtion.

#### Dumper function

Dumps formatted data to the screen using the HTML <pre> element.

**Usage:**
```php
/**
 * @param mixed  $data   [required] The data to dump.
 * @param bool   $exit   [optional] Whether to exit the script after output.
 * @param string $styles [optional] Any inline styles to add to the <pre> element.
 */
\luna\dump( $data, $exit = false, $styles = '' );
```

#### Dump to file function

Dump formatted data to a file in the theme. This is useufl when debugging XMLHttpRequests.

**Usage:**
```php
/**
 * @param mixed  $data     [required] The data to dump.
 * @param string $filename [optional] A custom dump file filename.
 */
\luna\dump_to_file( $data, $filename = 'dump' );
```

### Luna Debug

A PHP constant `LUNA_DEBUG` is set during the theme configration process which determines whether the theme is being run within a 'development' environment where debugging is allowed.

This constant should be checked when attempting to output HTML or content that is only intended for development versions of the site (similar to `SCRIPT_DEBUG`).

The defined development environments are currently sites which include one of the following strings in their domain:

- `localhost`
- `luna`
- `.wpengine.com`

## Advanced Custom Fields

While the theme is intended to be used with Gutenberg, ACF still very much has a place in hearts!

ACF is used to define and handle options pages and occasionally used to build blocks (using ACF blocks), therefore aspects of ACF have been weaved into the theme where required.

### Local JSON

The theme utilises ACF's excellent Local JSON feature which saves all ACF fields and field groups as a JSON file in the theme (https://www.advancedcustomfields.com/resources/local-json/).

Local JSON allows theses fields to be saved in Luna and ready for use on all projects. It also has the added benefit of being able to be customised in the Custom Fields section in the CMS, something that isn't possible with fields defined in PHP. As such, it is not recommended to define ACF fields using hardcoded PHP.

With Local JSON, all fields are saved within the theme, not just those that come packaged with Luna. These JSON files are found at `/_cache/acf-fields` and are versioned in Bitbucket as part of the project allowing fields to be easily deployed along with the codebase.

These JSON files should be treated as the main "source of truth" for all ACF fields on the site, superseding fields saved in the database. ACF offers syncing functionality, allowing the database to be updated with any new or updated Local JSON fields defined in the theme. Developers should check this whenever they create or clone a new project or pull code from Bitbucket.

### Option pages

Both the `Luna_Base_Cpts` and `Luna_Base_Global_Options` base classes utilise ACF options pages. While ACF is required for these classes, checks are made to check ACF is installed before attempting to use ACF functionality ensuring the theme will still run even if ACF is inactive.

### ACF helpers

A number of helper hooks are found in `Luna_Base_Plugin_Utils` which attempt to prevent ACF from being deactivated plus display warnings if either ACF or ACF Pro aren't active.
