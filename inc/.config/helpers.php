<?php
/**
 * Luna helper functions.
 *
 * @package luna
 * @subpackage luna-config
 */

namespace luna;

/**
 * Data dumper.
 * Outputs a formatted data dump to the screen.
 *
 * @param mixed  $data The data to dump.
 * @param bool   $exit Whether to exit the script after output.
 * @param string $styles Any inline styles to add to the <pre></pre> element, needs to be valid CSS.
 */
function dump( $data, $exit = false, $styles = '' ) {
	if ( ! defined( 'LUNA_DEBUG' ) || ! LUNA_DEBUG ) {
		// Only dump data if Luna debug is on.
		return;
	}

	echo '<pre style="' . esc_attr( $styles ) . '">';
	var_dump( $data ); // phpcs:ignore
	echo '</pre>';

	if ( $exit ) {
		die;
	}
}

/**
 * File data dumper.
 * Writes a dump of data to a file in the /_dump relative to the theme root.
 * This can be very useful when debuggin PHP called asynchronously. 
 *
 * @param mixed  $data The data to dump.
 * @param string $filename A custom dump file filename.
 */
function dump_to_file( $data, $filename = 'dump' ) {
	$dump_dir = get_template_directory() . '/_dump/';

	// Create the /_dump directory if it doesn't exist
	if ( ! is_dir( $dump_dir ) ) {
		mkdir( $dump_dir );
	}

	// Open a filestream for writing.
	$file = fopen( get_stylesheet_directory() . '/_dump/_' . $filename, 'w' ); // phpcs:ignore

	// Take a dump...
	ob_start();
	var_dump( $data ); // phpcs:ignore
	$dump = ob_get_clean();

	// Put that dump in the file...
	fwrite( $file, $dump ); // phpcs:ignore
	fclose( $file ); // phpcs:ignore
}
