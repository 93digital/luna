<?php
/**
 * Luna shortcodes.
 *
 * Custom theme shortcodes.
 * Although we live in a world of Gutenberg, shortcodes still have a place!
 *
 * @package luna
 */

/**
 * Luna shortcodes class.
 */
final class Luna_Shortcodes {
	/**
	 * Construct.
	 */
	public function __construct() {
    /**
		 * @example Add a shortcode.
		 */
		add_shortcode( 'luna-shortcode', [ $this, 'luna_shortcode_callback' ] );
	}

	/**
	 * 'luna-shortcode' shortcode callback.
	 * @example Outputs "Hello, Moon!".
	 *
	 * @param array $atts Shortcode attributes.
	 * @param array $content Shortcode content.
	 */
	public function luna_shortcode_callback( $atts = [], $content = '' ) {
		return "<strong>Hello, Moon!</strong>";
	}
}
