# Luna CPTs and taxonomies

All custom post types and taxonomies should be registered within the `Luna_Cpts` class (found in `/inc/class-luna-cpts.php`).

The parent `Luna_Base_Cpts` class contains functionality that register custom post types and taxonomies, automatically registers CPT archive option pages and adds the CPTs to the `$luna->cpts` object as properties. The base class also adds the default post type object to the `$luna->cpts` object and registers an option page for the default post type (under the Posts menu item).

## Built-in CPT and taxonomy functions

These post type and taxonomy functions are protected methods of the base class, intended for use in the `__construct()` method of the `Luna_Cpts` class.

### Register a CPT

**Usage:**
```php
/**
 * @param string $post_type [required] Custom post type slug.
 * @param array  $args      [optional] Custom post type args.
 *
 * @return void This does not need to be assigned to a variable.
 *              The WP_Post_Type object will automatically be added to the $luna->cpts object.
 */
$this->add_post_type( $post_type, $args = [] );
```

**Default args:**
```php
/**
 * Luna default post type args, set within the base class.
 * These override any core WordPress default args.
 */
private $default_cpt_args = [
  'has_archive'   => $plural, // derived from the passed $post_type slug.
  'labels'        => [
    'name'          => $plural, // derived from the passed $post_type slug.
    'singular_name' => $singular, // derived from the passed $post_type slug.
  ],
  'menu_icon'     => 'dashicons-portfolio',
  'menu_position' => 20,
  'public'        => true,
  'rewrite'       => [
    'with_front' => false,
  ],
  'show_in_rest'  => true,
  'supports'      => [
    'title',
    'editor',
    'page-attributes',
    'thumbnail',
    'revisions',
  ]
];
```

The list of WordPress default post type args can be seen [here](https://developer.wordpress.org/reference/functions/register_post_type/#parameter-detail-information).

### Register a taxonomy

**Usage:**
```php
/**
 * @param string       $taxonomy   [required] Custom taxonomy slug.
 * @param array|string $post_types [required] An array of post type slugs or a single slug string which the taxonomy should be associated.
 * @param array        $args       [optional] Custom taxonomy args.
 *
 * @return void This does not need to be assigned to a variable.
 *              The WP_Taxonomy object will automatically be added to each of the associated post type objects in $luna->cpts.
 */
$this->add_taxonomy( $taxonomy, $post_types, $args = [] );
```

**Default args:**
```php
/**
 * Luna default taxonomy args, set within the base class.
 * These override any core WordPress default args.
 *
 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
private $default_tax_args = [
  'hierarchical'      => true,
  'labels'            => [
    'name'          => $plural, // derived from the passed $taxonomy slug.
    'singular_name' => $singular, // derived from the passed $taxonomy slug.
  ],
  'rewrite'           => [
    'with_front' => false,
  ],
  'show_in_rest'      => true,
  'show_admin_column' => true,
];
```

The list of WordPress default taxonomy args can be seen [here](https://developer.wordpress.org/reference/functions/register_taxonomy/#additional-parameter-information).

### Unregister a taxonomy

**Usage:**
```php
/**
 * @param string       $taxonomy   [required] A taxonomy slug.
 * @param array|string $post_types [required] An array of post type slugs or a single slug string.
 *
 * @return void
 */
$this->remove_taxonomy( $taxonomy, $post_types );
```

## CPT settings page

A custom post type options page is added as a sub menu item under the post type's menu item if the `has_archive` has been set to true when registering the custom post type (which is the Luna default). This requires ACF to be activated.

### Option page slug

The page slug for each of these settings page will be in the format of `$post_type_slug . '-settings'`, e.g. `book-settings` for a registered custom post type called Books (notice the singular format for the slug).

### Default post type

For consistency, there is code within the `Luna_Base_Cpts` base class which automatically adds a settings page for Posts. So all settings for this default post type and the main Blog page will need to be set here. An admin notice is added to the Posts page (which still needs to be set in WordPress Settings) to prompt WordPress users to use the settings page.
