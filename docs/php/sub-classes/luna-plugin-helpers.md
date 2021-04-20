# Luna plugin helpers

The `Luna_Plugin_Helpers` class (found in `/inc/class-luna-plugin-helpers.php`) is used to alter or modify default plugin functionality via the use of hooks provided by plugins.

Plugins are always required to add extra features to a site, but often the functionality of some of these plugins may need to be tweaked in order for them to work seamlessly with the theme. This is where this class some in.

## Adding helpers

As mentioned above, alterations to plugins should nearly always be done via hooks made available by the plugin developer (as long as the plugin developer offers some useful hooks for theme and other plugin developers to hook into!).

These hook declarations should be added to the `__construct()` method of the `Luna_Plugin_Helpers` class, with each hook's callback being a method of the class.

**Usage:**
```php
public function __construct() {
	add_action( 'acf/init', [ $this, 'acf_initialised' ] );
}
```

```php
public function acf_initialised() {
	\luna\dump( 'Yay, ACF has been initialised!' );
}
```

### Why use helpers?

It is considered **VERY** bad practice to directly change plugin source code as you probably don't know the full consequences of the change. Plus the custom change will probably be overwritten when the plugin is updated.

In short, we must **NEVER** directly update plugin code.

### What if no hooks are available in a certain plugin?

Then we should consider whether the plugin is the best tool for the job, considering it needs some modification. Well developed plugins (and themes for that matter) should offer custom hooks at points where custom development may be required to extend functionality.

## Built-in helpers

A number of helpers have been added to the parent helper class `Luna_Base_Plugin_Helpers` which makes a few changes to some of the most used plugins like ACF and Yoast. A few of these key alterations are listed below.

### ACF

#### Prevent deactivation

This uses the [`plugin_action_links_{$plugin_file}`](https://developer.wordpress.org/reference/hooks/plugin_action_links_plugin_file/) filter hook and removes the Deactivate links from both ACF and ACF Pro on the Plugins page.

#### Local JSON custom location

The location in the theme where Local JSON fields are saved and accessed is updated using the [`acf/settings/save_json` and `acf/settings/load_json`](https://www.advancedcustomfields.com/resources/local-json/) filter hooks. This custom location set within Luna is `/_cache/acf-fields`.

### Yoast

#### Move the metabox

The `wpseo_metabox_prio` Yoast hook is used to move the SEO metabox to the very bottom of all `wp-admin/post.php` screens, below the Gutenberg editor and any custom fields in the main column.

#### Remove columns

All Yoast columns are removed from all `wp-admin/edit.php `screens using the [`manage_{$screen->id}_columns`](https://developer.wordpress.org/reference/hooks/manage_screen-id_columns/) hook. These columns are annoying, generally not needed and clutter the screen. (No, I don't like them!)


