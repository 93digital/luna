<?php
/**
 * Luna front end only hooks.
 *
 * All hooks required for only the front end (not the admin area) should be added to this class.
 * Hooks required for the front end and AJAX calls should be added to the genernal hooks class.
 *
 * @package luna
 * @subpackage luna-hooks
 */

/**
 * Luna front end hooks class.
 */
final class Luna_Front_End_Hooks {
  /**
   * Add all front-end hooks here.
	 * Each hook's callback should be a public method of this class.
	 */
	public function __construct() {
		/**
		 * @example Add a hook.
		 */
		add_action( 'template_redirect', [ $this, 'example_front_end_hook' ] );
	}

	/**
	 * 'template_redirect' action hook callback.
	 * @example A hook callback. Outputs a dump of the $luna object.
	 */
	public function example_front_end_hook() {
		global $luna;
		\luna\dump( $luna );
	}
}
