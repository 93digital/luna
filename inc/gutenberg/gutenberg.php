<?php
/**
 * Gutenberg Themeing options and function.
 *
 * @package luna
 */

namespace Luna\Gutenberg;

// ACF Register Blocks.
require get_template_directory() . '/inc/gutenberg/acf-blocks.php';

// Font settings for the Gutenberg editor.
require get_template_directory() . '/inc/gutenberg/font-config.php';

// Color settings for the Gutenberg editor.
require get_template_directory() . '/inc/gutenberg/color-config.php';

// Theme Support.
add_theme_support( 'align-wide' );
remove_theme_support( 'core-block-patterns' );

/**
 * Register Luna Block Category.
 *
 * @param array $categories our block categories.
 */
function register_block_category( $categories ) {
	return array_merge(
		$categories,
		[
			[
				'slug'  => 'luna-blocks',
				'title' => __( 'Luna Blocks', 'luna' ),
			],
		]
	);
}
add_filter( 'block_categories', __NAMESPACE__ . '\register_block_category', 10, 2 );

/**
 * Register Luna Blocks.
 */
function enqueue_gutenberg_scripts() {
	$script_asset_path = get_template_directory() . '/build/blocks.asset.php';

	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error( 'You need to run `npm start` or `npm run build` first.' );
	}
	
	$script_asset = require( $script_asset_path );

	// Register Luna Blocks.
	wp_register_script(
		'luna-blocks',
		get_template_directory_uri() . '/build/blocks.js',
		$script_asset['dependencies'],
		$script_asset['version']
	);

	wp_register_style( 'luna-blocks', get_template_directory_uri() . '/build/blocks.css', [] );
	
	// Set Script Translations.
	wp_set_script_translations( 'luna-blocks', 'luna' );

	// Enqueue Luna Blocks.
	wp_enqueue_script( 'luna-blocks' );
	wp_enqueue_style( 'luna-blocks' );
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_gutenberg_scripts' );
