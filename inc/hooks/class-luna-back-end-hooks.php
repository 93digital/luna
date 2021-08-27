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
		// Add mime types support.
		add_filter( 'upload_mimes', [ $this, 'mime_types' ] );
	}

	/**
	 * 'upload_mimes' filter hook callback
	 * Add custom mime types.
	 *
	 * @todo this needs review as ideally we do not want to allow SVGs to be uploaded to WP.
	 * It is a known security risk.
	 *
	 * @param array $mimes current mime types.
	 */
	public function mime_types( $mimes ) {
		// $mimes['svg']  = 'image/svg+xml';
		// $mimes['json'] = 'application/json';
		// $mimes['csv']  = 'text/csv';
		return $mimes;
	}
}
