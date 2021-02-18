<?php
require get_template_directory() . '/inc/gutenberg/gutenberg.php';

function setup() {
  add_image_size( 'mobile', 375 );
  add_image_size( 'tablet', 768 );
}
add_action( 'after_setup_theme', 'setup' );

function custom_image_sizes( $sizes ) {
  $new_sizes = [
    'mobile' => __( 'Mobile', 'luna' ),
    'tablet' => __( 'Tablet', 'luna' ),
  ];
  return array_merge( $sizes, $new_sizes );
}
add_filter( 'image_size_names_choose', 'custom_image_sizes' );

function frontend_scripts() {
  $script_asset_path = get_template_directory() . '/build/index.asset.php';

	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error( 'You need to run `npm start` or `npm run build` first.' );
	}

  wp_enqueue_style( 'luna-style', get_template_directory_uri() . '/style.css', [] );
	
	$script_asset = require( $script_asset_path );
  wp_register_script(
		'luna-scripts',
		get_template_directory_uri() . '/build/index.js',
		$script_asset['dependencies'],
		$script_asset['version'],
    true
	);
  wp_enqueue_script( 'luna-scripts' );
}

add_action( 'wp_enqueue_scripts', 'frontend_scripts' );
