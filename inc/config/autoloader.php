<?php
/**
 * Luna class autoloader.
 *
 * @package luna
 * @subpackage luna-config
 */

namespace luna;

/**
 * Autoloads all classes that reside in the theme's /inc directory.
 *
 * @param string $class Class name of an instantiated class (may include a namespace).
 */
function autoload( $class ) {
	/**
	 * Format the filename.
	 * 1. Remove any namespacing
	 * 2. Aet all chars to lowercase
	 * 3. Replace underscores with hypens
	 * 4. Prepend with 'class-'. All class files should start like this
	 */
	$filename = 'class-' . str_replace( '_', '-', strtolower( end( explode( '\\', $class ) ) ) ) . '.php';

	// Traverse through the /inc directory until the class is found or all files have been checked.
	find_class( get_template_directory() . '/inc/', $filename );
}
spl_autoload_register( '\luna\autoload' );

/**
 * This function traverses through a directory and looks for the passed filename.
 * Once found it will return true and halt anymore searching.
 *
 * @param string $dir The path of a directory to check.
 * @param string $filename
 */
function find_class( $dir, $filename ) {
	// Add a trailing slash to the directory for piping.
	$dir = trailingslashit( $dir );

	if ( file_exists( $dir . $filename ) ) {
		// Class file found in the passed directory.
		include_once $dir . $filename;
		return true;
	}

	// Iterate through sub-directories to look deeper for the file.
	foreach ( scandir( $dir ) as $sub_dir ) {
		if ( in_array( $sub_dir, [ '.', '..' ] ) ) {
			// Ignores the '.' and '..' Linux directories.
			continue;
		}

		if ( ! is_dir( $dir . $sub_dir ) || strpos( $sub_dir, '.' ) === 0 ) {
			// Ignores files and hidden directories (starting with a . ).
			continue;
		}

		// Attempt the find the class in the sub-directory. If found, the function will return true.
		if ( find_class( $dir . $sub_dir, $filename ) ) {
			return true;
		}
	}
}
