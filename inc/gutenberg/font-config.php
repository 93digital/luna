<?php
/**
 * Font settings for the Gutenberg editor.
 *
 * @package luna
 */

namespace Luna\Gutenber\FontConfig;

// Enabling this removes the custom option however there is a bug.
// It still displays in the dropdown, uncomment once bug is fixed.
// add_theme_support( 'disable-custom-font-sizes' );

/**
 * Set custom font options for the editor.
 */
function gutenberg_editor_fonts() {
	add_theme_support(
		'editor-font-sizes',
		[
			[
				'name' => __( 'Small', 'luna' ),
				'size' => 14,
				'slug' => 'small'
			],
			[
				'name' => __( 'Regular', 'luna' ),
				'size' => 16,
				'slug' => 'regular'
			],
			[
				'name' => __( 'Large', 'luna' ),
				'size' => 32,
				'slug' => 'large'
			]
		]
	);
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\gutenberg_editor_fonts' );
