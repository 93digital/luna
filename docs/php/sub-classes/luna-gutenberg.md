# Luna Gutenberg

All Gutenberg related PHP including custom theme support, adding block categories and registering ACF blocks should be done in the `Luna_Gutenberg` class (found in `/inc/class-luna-gutenberg.php`).

The parent class `Luna_Base_Gutenberg` adds some general theme Gutenberg setup, including the enqueuing of Gutenberg-specific scripts.

## ACF blocks

Should the site require a large number of ACF blocks it would be advised to create a new sub-class, e.g. `Luna_Gutenberg_Acf_Blocks`. The instantiation of this new class should be done within the `__construct()` of `Luna` or `Luna_Gutenberg` and the class file should reside in the root of the `/inc` directory.

> *Note:*<br />
>Anytime ACF blocks are used, be sure to check that ACF is installed and active before using the register block function!

### Register ACF blocks

**Usage:**
```php
public function __construct() {
  // Register the theme's ACF blocks.
  add_action( 'acf/init', [ $this, 'register_acf_block_types' ] );
}
```

```php
function register_acf_block_types() {
  if ( ! function_exists( 'acf_register_block_type' ) ) {
    // ACF is required to register ACF blocks!
    return;
  }

  // Register a block.
  acf_register_block_type(
    [
      'name'            => 'luna-block',
      'title'           => __( 'Luna block', 'luna' ),
      'description'     => __( 'Luna block description.', 'luna' ),
      'render_template' => 'modules/m00-luna-block.php',
      'category'        => 'luna-blocks',
      'icon'            => 'align-center',
      'keywords'        => [ 'acf', 'luna' ],
      'supports'        => [
        'mode'     => false,
        'align'    => false,
        'multiple' => true,
      ],
    ]
  );
}
```
