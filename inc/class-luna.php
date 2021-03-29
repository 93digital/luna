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
	 * A Luna_Plugin_Utils object.
	 * @var object
	 */
	public $plugin_utils;

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
		$this->plugin_utils   = new Luna_Plugin_Utils();
		$this->utils          = new Luna_Utils();
	}
}
