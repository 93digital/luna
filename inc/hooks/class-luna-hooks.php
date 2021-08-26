<?php
/**
 * Luna general hooks class.
 * 
 * All hooks required for both the front and back end should be added to this class.
 *
 * @package luna
 * @subpackage luna-hooks
 */

/**
 * Luna hooks class.
 */
final class Luna_Hooks {
	/**
	 * Add all general hooks here.
	 * Each hook's callback should be a public method of this class.
	 */
	public function __construct() {
		// Register menus.
		add_action( 'after_setup_theme', [ $this, 'register_nav_menus' ] );

		// Replace excerpt end string output.
		add_filter( 'excerpt_more', [ $this, 'custom_excerpt_more' ] );
	}

	/**
	 * 'after_setup_theme' action hook callback.
	 * Register all the theme menus.
	 */
	public function register_nav_menus() {
		// Register nav menus.
		register_nav_menus(
			[
				'primary' => esc_html__( 'Primary Menu', 'luna' ),
			]
		);
	}

	/**
	 * Replaces the return 'read more' excerpt cut off.
	 */
	public function custom_excerpt_more() {
    return '...';
	}
}
