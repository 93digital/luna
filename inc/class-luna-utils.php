<?php
/**
 * Luna Utilities.
 *
 * Any utility or theme helper functions should be added here as methods.
 * The parent class contains some useful utils which are often needed on most WP sites.
 *
 * @package luna
 */

/**
 * Luna Utils class.
 * No __construct here as this class should just contains re-usable methods.
 * To keep things tidy, please aim to keep all methods alphabetised (the base class is!).
 */
final class Luna_Utils extends Luna_Base_Utils {
	/**
	 * @example util function.
	 */
	public function echo_hello_moon() {
		echo 'Hello, Moon!';
	}
}
