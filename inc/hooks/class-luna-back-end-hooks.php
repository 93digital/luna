<?php
/**
 * Luna back end only hooks.
 *
 * All hooks required for the admin area (or AJAX only calls) should be added to this class.
 *
 * @package luna
 * @subpackage luna-hooks
 */

/**
 * Luna back end hooks class.
 */
final class Luna_Back_End_Hooks {
	/**
	 * Add all back-end  hooks here.
	 * Each hook's callback should be a public method of this class.
	 */
	public function __construct() {
		/**
		 * @example Add a hook.
		 */
		add_action( 'admin_notices', [ $this, 'example_back_end_hook' ] );
	}

	/**
	 * 'admin_notices' action hook callback.
	 * @example A hook callback. Outputs a dump of the $luna object.
	 */
	public function example_back_end_hook() {
		global $luna;
		\luna\dump( $luna );
	}
}
