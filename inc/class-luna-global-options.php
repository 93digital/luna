<?php
/**
 * Luna Global Options.
 *
 * Register any custom Global Options sub-pages here using the add_sub_page() method.
 *
 * @package luna
 */

/**
 * Luna Global Options class.
 */
final class Luna_Global_Options extends Luna_Base_Global_Options {
	/**
	 * Construct.
   * Register the Global Options page and fields if ACF is available.
	 */
	public function __construct() {
    if ( ! function_exists( 'get_field' ) ) {
      // ACF isn't active.
      return;
		}

		// Instantiate the base Global Options.
		parent::__construct();

		/**
		 * @example Register sub-page types.
		 */
		$this->add_sub_page( 'Test subpage' );
	}
}
