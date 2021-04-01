# Luna CPTs and taxonomies

All custom post types and taxonomies should be registered within `Luna_Cpts`. The parent class `Luna_Base_Cpts` contains all the functionality requried to register custom post types and taxonomies, automatically register CPT option pages and add the CPTs to the `$luna->cpts` object as properties.

The base class also adds the default post type object to the `$luna->cpts` object and registers an option page for the default post type (under the Posts menu item).

## Built-in CPT and taxonomy functions

These post type and taxonomy functions are protected methods of the base class, intended to be used in the `__construct()` of `Luna_Cpts` class.

### Register a CPT

**Usage:**
```php
/**
 * @param string $post_type [required] Custom post type slug.
 * @param array  $args      [optional] Custom post type args.
 *
 * @return void This does not need to be assigned to a variable.
 *              The WP_Post_Type object will be added to the $luna->cpts object.
 */
$this->add_post_type( $post_type, $args = [] );
```

**Default args:**
```php
/**
 * Luna default post type args, set within the base class.
 * These override any core WordPress default args.
 * @see https://developer.wordpress.org/reference/functions/register_post_type/
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
    'with_front'  => false,
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

#### CPT settings

A post type settings page is added as a sub menu item under the post type menu item if the `has_archive` page is set to true (which is the default). This requires ACF to be activated.

### Register a taxonomy

**Usage:**
```php
/**
 * @param string       $taxonomy   [required] Custom taxonomy slug.
 * @param array|string $post_types [required] An array of post type slugs or a single slug string which the taxonomy should be associated.
 * @param array        $args       [optional] Custom taxonomy args.
 *
 * @return void This does not need to be assigned to a variable.
 *              The WP_Taxonomy object will be added to each of the associated post type objects in $luna->cpts.
 */
$this->add_taxonomy( $taxonomy, $post_types, $args = [] );
```

**Default args:**
```php
/**
 * Luna default taxonomy args, set within the base class.
 * These override any core WordPress default args.
 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
private $default_tax_args = [
  'hierarchical' => true,
  'labels'        => [
    'name'          => $plural, // derived from the passed $taxonomy slug.
    'singular_name' => $singular, // derived from the passed $taxonomy slug.
  ],
  'rewrite'      => [
    'with_front' => false,
  ],
  'show_in_rest' => true,
];

```

### Unregister a taxonomy

**Usage:**
```php
/**
 * @param string       $taxonomy   [required] A taxonomy slug.
 * @param array|string $post_types [reqruied] An array of post type slugs or a single slug string.
 *
 * @return void
 */
$this->remove_taxonomy( $taxonomy, $post_types );
```
