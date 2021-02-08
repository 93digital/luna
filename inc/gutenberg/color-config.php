<?php
/**
 * Color settings for the Gutenberg editor.
 *
 * @package luna
 */

namespace Luna\Gutenberg\Colors;

// Theme Support.
add_theme_support( 'disable-custom-colors' );
add_theme_support( 'disable-custom-gradients' );

/**
 * Set custom color options for the editor.
 */
function gutenberg_editor_colors() {
	// Custom solid colors.
	add_theme_support(
		'editor-color-palette',
		[
			[
				'name'  => __( 'Black', 'luna' ),
				'slug'  => 'black',
				'color' => '#000000',
			],
			[
				'name'  => __( 'White', 'luna' ),
				'slug'  => 'white',
				'color' => '#FFFFFF',
			],
		]
	);
	// Custom gradients.
	add_theme_support(
    'editor-gradient-presets',
    [
      [
        'name'     => __( 'Gradient One', 'luna' ),
        'slug'     => 'gradient-1',
        'gradient' => 'linear-gradient(135deg, #00FFFF 0%, #FF1493 100%)'
      ],
		]
  );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\gutenberg_editor_colors' );
