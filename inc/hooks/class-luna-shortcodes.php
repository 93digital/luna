<?php
/**
 * Luna shortcodes hooks.
 *
 * Custom theme shortcodes to go here.
 * Although we live in a world of Gutenberg, shortcodes still have a place!
 *
 * @package luna
 * @subpackage luna-hooks
 */

/**
 * Luna shortcodes class.
 */
final class Luna_Shortcodes {
	/**
	 * Construct.
	 * Add all add_shortcode() hooks here.
	 * Each shortcode callback should be a method of this class.
	 */
	public function __construct() {
    /**
		 * @example Add a shortcode.
		 */
		add_shortcode( 'example-luna-shortcode', [ $this, 'exmaple_luna_shortcode_callback' ] );
	}

	/**
	 * 'luna-shortcode' shortcode callback.
	 * @example Outputs "Hello, Moon!".
	 *
	 * @param array $atts Shortcode attributes.
	 * @param array $content Shortcode content.
	 */
	public function exmaple_luna_shortcode_callback( $atts = [], $content = '' ) {
		return "<strong>Hello, Moon!</strong>";
	}
}
