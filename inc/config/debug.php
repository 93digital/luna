<?php
/**
 * Luna debugging.
 *
 * @package luna
 * @subpackage luna-config
 */

namespace luna;

/**
 * This constant is used to check if the site is being run in development mode.
 * It is generally used when debugging, as we don't want any debug output on production.
 * @var bool
 */
define( 'LUNA_DEBUG', is_debug_mode() );

/**
 * Checks whether the site is running in a local environment.
 * Checks for localhost in the URL to decide this.
 * Also will not be set when working directly in the starter theme.
 *
 * @return bool Whether the site is in 'debug mode'.
 */
function is_debug_mode() {
	return stripos( home_url(), 'localhost' ) && ! stripos( home_url(), 'luna' );
}
