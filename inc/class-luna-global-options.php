<?php
/**
 * Luna Global Options.
 *
 * Register any custom Global Options sub-pages here using the $this->add_sub_page() method.
 * Any functionality that uses data from Global Options should be added to this class.
 *
 * @package luna
 */

/**
 * Luna Global Options class.
 */
final class Luna_Global_Options extends Luna_Base_Global_Options {
	/**
	 * Instantiation.
   * Register the Global Options page and fields via the parent class if ACF is available.
	 */
	public function __construct() {
    if ( ! function_exists( 'get_field' ) ) {
      // ACF is required for this class.
      return;
		}

		// Regisyer the base Global Options.
		parent::__construct();

		/**
		 * @example Register sub-page types.
		 */
		$this->add_sub_page( 'Test subpage' );
	}
}
