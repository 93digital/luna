<?php
/**
 * Luna.
 * The main theme object class.
 * Extends the base setup class which contains core theme functionality.
 *
 * Use this class to define theme sub-classes (so they are part of the $luna object).
 *
 * @package luna
 */

/**
 * Luna class.
 */
final class Luna extends Luna_Base {
	/**
	 * A Luna_Cpts object.
	 * @var object
	 */
	public $cpts;

	/**
	 * A Luna_Global_Options object.
	 * @var object
	 */
	public $global_options;

	/**
	 * A Luna_Gutenberg object.
	 * @var object
	 */
	public $gutenberg;

	/**
	 * A Luna_Plugin_Helpers object.
	 * @var object
	 */
	public $plugin_helpers;

	/**
	 * A Luna_Utils object.
	 * @var object
	 */
	public $utils;

	/**
	 * Instantiation.
	 * Call the base theme setup and instantiate the sub-classes.
	 */
	public function __construct() {
		// Base theme setup.
		parent::__construct();

		/**
		 * Instantiate sub classes.
		 */
		$this->cpts           = new Luna_Cpts();
		$this->global_options = new Luna_Global_Options();
		$this->gutenberg      = new Luna_Gutenberg();
		$this->plugin_helpers = new Luna_Plugin_Helpers();
		$this->utils          = new Luna_Utils();

		/**
		 * Instantiate composer packages.
		 *
		 * If a package is not required for a project:
		 * - Remove the class_exists if statement block (inc. instantiation)
		 * - Remove the package from composer.json
		 * - Run `composer update` to remove the source files
		 *
		 * (Terra is instantiated within the core of the theme).
		 */
		if ( class_exists( 'Nine3_Workable_Api' ) && function_exists( 'get_field' ) ) {
			$this->workable_api = new Nine3_Workable_Api(
				get_field( 'workable_subdomain', 'workable-api-options' ),
				get_field( 'workable_access_token', 'workable-api-options' )
			);
		}
	}
}
