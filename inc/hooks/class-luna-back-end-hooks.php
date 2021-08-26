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
		// add_action( 'admin_notices', [ $this, 'example_back_end_hook' ] );
		add_action( 'acf/init', [ $this, 'google_maps_api' ] );

		// Add mime types support.
		add_filter( 'upload_mimes', [ $this, 'mime_types' ] );
	}

	/**
	 * 'admin_notices' action hook callback.
	 * @example A hook callback. Outputs a dump of the $luna object.
	 */
	public function example_back_end_hook() {
		global $luna;
		\luna\dump( get_class( $luna ) );
	}

	/**
	 * 'acf/init' action hook callback.
	 * ACF Register Google API key.
	 */
	public function google_maps_api() {
		$api_key = get_field( 'google_maps_api_key', 'general-options' );

		if ( $api_key ) :
			acf_update_setting( 'google_api_key', $api_key );
		endif;
	}

	/**
	 * 'upload_mimes' filter hook callback
	 * Add custom mime types.
	 *
	 * @param array $mimes current mime types.
	 */
	public function mime_types( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['json'] = 'application/json';
		$mimes['csv']  = 'text/csv';
		return $mimes;
	}
}
