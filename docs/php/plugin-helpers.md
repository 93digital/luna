# Luna plugin helpers

The `Luna_Plugin_Helpers` class is used to alter or update default plugin functionality via the use of hooks provided by plugins.

Plugins are nearly always needed to add extra features to a site, but often the functioanlity of some of these plugins may need to be tweaked in order for them to work seamlessly with the theme. This is where this class some in.

## Adding helpers

As mentioned above, all alterations to plugins, specifically those which are publicly available on the WordPress plugin directory and therefore likely to be updated, should be done via hooks made available by the plugin developer.

These hook declarations should be added to the `__constuct()` of the `Luna_Plugin_Helpers` class with each hook's callback being a mehtod of the class.

**Usage:**
```php
public function __construct() {
	add_action( 'acf/init', [ $this, 'acf_initialised' ] );\
}
```

```php
public function acf_initialised() {
	\luna\dump( 'Yay, ACF has been initialised.' );
}
```

### Why use helpers?

It is considered VERY bad practice to directly change plugin source code as you probably don't know what the full ramifiactions of the change. Plus the custom change will probably be deleted when the plugin is updated.

In short, we must NEVER directly update plugin code.

### What if not hooks are available?

Then we should consider whether using said plugin is the best tool for the job. Well developed plugins (and themes for that matter) should offer custom hooks at points where custom development may be required to extend functionality.

## Built-in helpers

A number of helpers have been added to the parent helper class `Luna_Base_Plugin_Helpers` which makes a few changes to some of the most used plugins like ACF and Yoast. A few of these key alterations are listed below.

### ACF

#### Prevent deativation

This uses the [`plugin_action_links_{$plugin_file}`](https://developer.wordpress.org/reference/hooks/plugin_action_links_plugin_file/) filter hook and removes the Deactivate links from both ACF and ACF Pro

#### Local JSON custom location

The location in the theme where Local JSON themes are updated using the [`acf/settings/save_json` and `acf/settings/load_json`](https://www.advancedcustomfields.com/resources/local-json/) filter hooks. This custom location is set to `/_cache/acf-fields`.

### Yoast

#### Move the metabox

The Yoast hook `wpseo_metabox_prio` is used to move the SEO metabox to the very bottom of all `wp-admin/post.php` screens below the Gutenberg editor and any custom fields in the main column.

#### Remove columns

All Yoast columns are removed from all wp-admin/edit.php screens using the [`manage_{$screen->id}_columns`](https://developer.wordpress.org/reference/hooks/manage_screen-id_columns/) hook. These columns are annoying, generally not needed and clutter the screen. (No, I don't like them!)


