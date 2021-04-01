<?php
/**
 * Luna Config.
 * A theme bootstrapper class.
 * Initialises all required Luna-based classes.
 *
 * @package luna
 * @subpackage luna-config
 */

/**
 * Do you even bootstrap, bro?
 */
final class Luna_config {
	/**
	 * Will contain a single instance of the class.
	 * @var object Luna_Config
	 */
	private static $instance;

	/**
	 * Creates or fetches an instance of the config class.
	 * Uses the singleton pattern to ensure only one instance is created.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Run theme configuration!
	 * This can only be done via the get_instance method to ensure only one instance is created.
	 */
	private function __construct() {
		/**
		 * Luna debug.
		 * This constant is used to check if the site is being run in development mode.
		 * It is generally used when debugging, as we don't want any debug output on production.
		 * @var bool
		 */
		define( 'LUNA_DEBUG', $this->is_debug_mode() );

		/**
		 * Required files and classes.
		 */
		$config_path = get_template_directory() . '/inc/.config';

		// Require config helper functions script (contains data dumpers etc.).
		require_once $config_path . '/helpers.php';

		// Config classes.
		include_once $config_path . '/class-luna-config-errors.php';
		new Luna_Config_Errors();

		// Include the Composer autoloader.
		@include_once get_template_directory() . '/vendor/autoload.php'; // phpcs:ignore

		/**
		 * Luna autoloader.
		 */
		spl_autoload_register( [ $this, 'luna_autoloader' ] );

		// Instantiate the main Luna theme object.
		$GLOBALS['luna'] = new Luna();
		global $luna;
	}

	/**
	 * Checks whether the site is running in an environment where debugging is allowed.
	 * These environments are:
	 * - localhost
	 * - sites using the '.wpengine.com' domain
	 * - Any environment running the base starter theme (domain containing 'luna').
	 *
	 * @return bool Whether the site is in 'debug mode'.
	 */
	private function is_debug_mode() {
		return stripos( home_url(), 'localhost' )
			|| stripos( home_url(), 'luna' )
			|| stripos( home_url(), '.wpengine.com' );
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
