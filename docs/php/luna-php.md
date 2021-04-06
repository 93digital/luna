# Luna PHP

The theme PHP uses an object-oriented, class based system and is centred around a single global `$luna` theme object.

## File Structure

All Luna PHP code is housed within the `/inc` directory, with the obvious exception of `functions.php` which acts as the theme bootstrapper.

```
├── inc/
│   ├── .config/
│   ├── base/
│   ├── hooks/
│   │   ├── class-luna-back-end-hooks.php
│   │   ├── class-luna-front-end-hooks.php
│   │   ├── class-luna-hooks.php
│   │   └── class-luna-shortcodes.php
│   ├── class-luna-cpts.php
│   ├── class-luna-global-options.php
│   ├── class-luna-gutenberg.php
│   ├── class-luna-plugin-utils.php
│   ├── class-luna-utils.php
│   └── class-luna.php
```

The main `Luna` class, of which the global `$luna` object is an instance of, is found in `class-luna.php` and is the foundation of the theme.

A number of other sub-class files are found alongside `class-luna.php` in the root of the `/inc` directory. Each of these sub-classes serve a specific purpose and are where the majority of custom PHP functionality for a project should be added.

All sub-classes baked into the starter theme (and `Luna` itself) each have their own base parent class which contains core functionality related to the class that inherits it. These base classes are found within `/inc/base`.

> ***Important:***<br>
> Custom code should never be added to `functions.php` its sole purpose is as a bootstrapper for the Luna theme. All PHP code should be placed in the `/inc` directory.

### /hooks

All WordPress hooks and their callbacks should be added to the classes in the `/hooks` directory. These classes are split into a general hooks class, a back end hooks class and a front end hooks class. A shortcodes class is also available here for use.

The purpose of these classes is to try and keep the size of the sub-classes down to a reasonable size. Ideally no hooks will be added to the main `Luna` class or any of the sub-classes.

### /base

The `/base` directory contains functionality baked into the core of the theme, split out into a number of abstract classes. As mentioned above, these classes are all extended by the classes in the root of `/inc` directory.

Generally the base classes should not need to be touched and there are some custom Luna hooks sprinkled throughout these base classes to allow some of the base functionality to be extended. These are detailed in *[luna-hooks.md](php/luna-hooks.md)*.

### /.config

The `/.config` directory contains a couple of configuration files which are required to set up the theme environment and instantiate the global `$luna` object. These files can generally be ignored and won't need to be changed.

> ***Important:***<br>
> It's is highly discouraged to change any of the code found within `/.config`.


## Basic Usage

The primary purpose of the main `Luna` class is to be a grouping object for the sub-classes, which are instantiated as properties of the `$luna` object.

The parent class `Luna_Base` handles a lot of general theme set up (such as enqueuing styles and scripts, custom theme support, instantiating hook classes etc.) via the `parent::__construct()` method call. This base class, along with all other base classes are *abstract* classes which means they cannot be instantiated on their own and can only provide inheritance to another class.

All theme code should be associated with the `$luna` object. This helps add context to custom theme functionality, limits visibility outside of the scope of the theme and negates the need for PHP namespaced which, while useful, can get a tad ugly at times.

### Sub-classes

The core sub-classes ready baked into Luna at the time of writing are:

- `Luna_Cpts`
- `Luna_Global_Options`
- `Luna_Gutenberg`
- `Luna_Plugin_Utils`
- `Luna_Utils`

Miscellaneous project functionality can be added to the `$luna` object by adding methods to the main `Luna` class if there is no other logical place for it.

However, creation of more sub-classes on a project-by-project basis is encouraged, if the developer feels there is a valid use case for it. These would not need base classes as they would be site specific but should be instantiated as properties of the `$luna` global theme object, similarly to the other sub-classes.

### Hooks

All general WordPress hooks should be added to a class in the `/inc/hooks` directory (unless you feel there is a reasonable argument for adding them to a sub-class). This will help keep the file size of the sub-classes down to a sensible size, and also help when trying to locate hooks when debugging.

The hook classes baked into Luna at the time of writing are:

- `Luna_Back_End_Hooks`
- `Luna_Front_End_Hooks`
- `Luna_Hooks`
- `Luna_Shortcodes`

The names of these are pretty self-explanatory, with the main `Luna_Hooks` class acting as a home for hooks which are required for both the front and back end.

Similarly the the sub-classes, more custom hook classes can be created here on a project-by-project basis should the need arise.

All `add_action()`, `add_filter()` and `add_shortcode()` hooks should be defined in the `__construct()` method of the relevant class with the hook callback being a public method of the class.

> *Note:*<br />
> The vast majority of custom theme configuration should be added to a hook callback. If you have add functionality to the theme which isn't within a hook callback, ask yourself whether there is a hook that could be used.

**Usage:**
```php
public function __construct() {
  add_action( 'init', [ $this, 'luna_greeting' ] );
}
```

```php
/**
 * 'init' hook callback
 */
public function luna_greeting() {
  echo 'Hello, Moon!';
}
```

### Development helpers

Two procedural dumper functions, `dump()` and `dump_to_file()`, are available for use outside of the scope of the `$luna` object to help with development and debugging. These are available within the `luna` PHP namespace for the sake of encapsulation.

#### Dumper function

Dumps formatted data to the screen using the HTML `<pre>` element.

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

Dump formatted data to a file in the theme, within the `/_dump` directory. This is useful when debugging XMLHttpRequests.

**Usage:**
```php
/**
 * @param mixed  $data     [required] The data to dump.
 * @param string $filename [optional] A custom dump file filename.
 */
\luna\dump_to_file( $data, $filename = 'dump' );
```

### Luna Debug

The `LUNA_DEBUG` PHP constant is set during the theme configuration process which determines whether the theme is being run within a 'development' environment, where debugging is allowed.

This constant should be checked when attempting handle functionality or output data that is only intended for development versions of the site (similar to `SCRIPT_DEBUG`).

The defined development environments are currently sites which include one of the following strings in their domain:

- `localhost`
- `luna`
- `.wpengine.com`

## Advanced Custom Fields

While the theme is very much geared towards custom Gutenberg development, ACF still very much has a place in hearts!

ACF is used to define and handle options pages and occasionally used to build blocks (using ACF blocks), therefore aspects of ACF have been weaved into the theme where required.

### Local JSON

The theme utilises ACF's excellent Local JSON feature which saves all ACF fields and field groups as a JSON file in the theme, explained in detail [here](https://www.advancedcustomfields.com/resources/local-json/). This is utilised to define a number of core Global Option fields which come baked in with Luna.

Local JSON also has the added benefit of being able to be customised in the Custom Fields section in the CMS, something that isn't possible with fields defined in PHP. As such, it is not recommended to define ACF fields using hardcoded PHP.

The JSON field group files are found at `/_cache/acf-fields` in the theme and are versioned in Bitbucket as part of the project source code, allowing fields to be easily deployed along with the codebase.

> ***Important:***<br />
> These JSON files should be treated as the main "source of truth" for all ACF fields on the site, superseding fields saved in the database.

> ACF offers syncing functionality, allowing the database to be updated with any new or updated Local JSON fields defined in the theme. Developers should check this whenever they create or clone a new project or pull code from Bitbucket.

### Option pages

Both the `Luna_Base_Global_Options` and `Luna_Base_Cpts` base classes utilise ACF options pages. While ACF is required for these classes, checks are made to ensure ACF is installed and active allowing the theme to still run even if ACF is inactive.

### ACF helpers

A number of helper hooks are found in `Luna_Base_Plugin_Utils` which attempt to prevent ACF from being deactivated plus display warnings if either ACF or ACF Pro aren't active.
