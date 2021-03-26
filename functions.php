<?php
/**
 * Luna - The new starter theme developed by 93digital.
 * We are over the moon with it XD
 *
 * This functions.php file MUST remain empty.
 * All them functionality should be added to the relevant classes in /inc.
 *
 * @package luna
 */

require_once 'inc/_config/class-luna-bootstrapper.php';
new Luna_Bootstrapper();

/**
 * @todo move.
 */
require get_template_directory() . '/inc/gutenberg/gutenberg.php';
