<?php
/**
 * Theme bootstrapper class.
 * Initialises all required Luna-based classes.
 *
 * @package luna
 * @subpackage luna-config
 */

/**
 * Do you even bootstrap, bro?
 */
final class Luna_bootstrapper {
	/**
   * Checks if the class has already been instantiated.
   * @var bool
   */
  private static $is_instantiated = false;

	/**
	 * Run the bootstrapper!
	 */
	public function __construct() {
		// Has the theme bootstrapper already been run?
		if ( self::$is_instantiated ) {
			// The bootstrapper should only be run ONCE!
			trigger_error(
				'<strong>Luna_bootstrapper</strong> can only be instantiated ONCE!',
				E_USER_ERROR
			);
		}
		self::$is_instantiated = true;

		/**
		 * Luna debug.
		 * This constant is used to check if the site is being run in development mode.
		 * It is generally used when debugging, as we don't want any debug output on production.
		 * @var bool
		 */
		define( 'LUNA_DEBUG', $this->is_debug_mode() );

		/**
		 * Required files.
		 */
		// Include the Composer autoloader.
		@include_once get_template_directory() . '/vendor/autoload.php'; // phpcs:ignore
		
		// Require misc helper functions script.
		require_once get_template_directory() . '/inc/helpers.php';

		/**
		 * Luna class system.
		 */
		// Luna autoloader.
		spl_autoload_register( [ $this, 'luna_autoloader' ] );
		
		// Config classes.
		new Luna_Config_Plugin_Utilities();
		new Luna_Config_Errors();

		// Instantiate the main Luna theme object.
		$GLOBALS['luna'] = new Luna();
		global $luna;
	}

	/**
	 * Checks whether the site is running in a local environment.
	 * Checks for localhost in the URL to decide this.
	 * Also will not be set when working directly in the starter theme.
	 *
	 * @return bool Whether the site is in 'debug mode'.
	 */
	private function is_debug_mode() {
		return stripos( home_url(), 'localhost' ) && stripos( home_url(), 'luna' );
	}

	/**
	 * Autoloads all classes that reside in the theme's /inc directory.
	 *
	 * @param string $class Class name of an instantiated class (may include a namespace).
	 */
	private function luna_autoloader( $class ) {
		/**
		 * Format the filename.
		 * 1. Remove any namespacing by exploding into an array with a \ delimiter.
		 * 2. Aet all chars to lowercase.
		 * 3. Replace underscores with hypens.
		 * 4. Prepend with 'class-'. All class files should start like this.
		 */
		$classname_array = explode( '\\', $class );
		$filename        = 'class-' . str_replace( '_', '-', strtolower( end( $classname_array ) ) ) . '.php';

		// Traverse through the /inc directory until the class is found or all files have been checked.
		$this->luna_find_class( get_template_directory() . '/inc/', $filename );
	}

	/**
	 * This function traverses through a directory and looks for the passed filename.
	 * Once found it will return true and halt anymore searching.
	 *
	 * @param string $dir The path of a directory to check.
	 * @param string $filename
	 */
	private function luna_find_class( $dir, $filename ) {
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
			if ( $this->luna_find_class( $dir . $sub_dir, $filename ) ) {
				return true;
			}
		}
	}
}
