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

All sub-class baked into the starter theme (and `Luna` itself) each have their own base parent class which contains core  functionality related to the class that inherits it. These base classes are found within `/inc/base`.

It is encouraged to create more sub-classes if there is a specific use case where a seperate class would be the logical approach than 'shoe-horning' functionlaity in one of the existing classes. This will also help keep each PHP file below 500 lines. These would not need base classes as they would be site specific but should be instantiated as properties of the `$luna` global theme object.

> IMPORTANT:<br>
> Custom code should never be added to `functions.php` its sole purpose is as a bootstrapper for the Luna theme. All PHP code should be placed in the `/inc` directory.

### Hooks

All WordPress custom filter and action hook callbacks should be added to the classes in the `/hooks` directory. These are anonomously instantiated within the `Luna_Base` class. These classes are split into a general hooks class, a back end hooks class and a front end hooks class. A shortcodes class is also available here for use.

The purpose of these classes is to try and keep the size of the sub-classes down to a reasonable size. Ideally no hooks will be added to the main `Luna` class or any of the sub-classes.

### Base

The `/base` directory contains core theme functionality, split out into a number of abstract classes. As mentioned above, these classes are all extended by the classes in the root of `/inc` directory.

Generally the base classes should not need to be touched and there are some custom hooks (detailed further down) to allow extension of some of the base functionality.

However, sometimes it is inevitable that core functionality may need to be tweaked. If you feel a core file needs updating within a site, always consider if there is another way of undertaking the change before making a change to a base class as you may risk unintentially altering core functionality.

### Config

The `/.config` directory contains a number of configutration files which are required to set up the theme environment and instantiate the global `$luna` object. This generally can be ignored.

> IMPORTANT:<br>
> It's is highly discouraged to change any of the code found within `/.config`.


## Usage

### Main Luna class

The primary purpose of the `Luna` class is to be a grouping object for a number of sub-classes which are instantiated as properties of Luna. Custom project code should be placed in these classes. At the time of writing the sub classes include:

- `Luna_Cpts`
- `Luna_Global_Options`
- `Luna_Plugin_Utils`
- `Luna_Utils`

`Luna` also calls it's parent construct which handles a lot of theme setup which is generally required for all sites.

Custom miscellaneous can be added to `Luna` in the form of class methods if there is no other logical place to place it and you don't feel it constitutes it's own class.

### Luna sub-classes

#### Luna CPTS


### Luna hooks

All `add_action()`, `add_filter()` and `add_shortcode()` hooks should be defined in the `__construct()` method of the relevant class with the hook callback being a public method of the class.

**Example:**
```php
public function __construct() {
  add_action( 'init', [ $this, 'my_init_hook_callback' ] );
}

/**
 * 'init' hook callback
 */
public function my_init_hook_callback() {
  echo 'Hello, Moon!';
}
```
