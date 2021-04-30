<?php
/**
 * Luna CPTs and taxonomies.
 *
 * All CPTs and taxonomies should be registered in this class.
 * Each registration should follow the pattern of already used.
 * 
 * @see https://developer.wordpress.org/reference/functions/register_post_type/
 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/
 *
 * @package luna
 */

/**
 * Luna CPT and taxonomy class.
 */
final class Luna_Cpts extends Luna_Base_Cpts {
	/**
	 * Instantiation.
   * All CPTs and taxonomies registered here.
	 * Any de-registering of post types and taxonomies should also be done here (Hello, Tags).
	 *
	 * Remember internationalisation when registering labels!
	 */
	public function __construct() {
		// Instantiate the parent class, this contains hooks for CPT and taxonomy registration.
		parent::__construct();

		/**
		 * @example Register post types.
		 */
		$this->add_post_type( 'book', [] );
		$this->add_post_type( 'dvd' );

		/**
		 * @example Register taxonomies.
		 */
		$this->add_taxonomy( 'genre', [ 'book', 'dvd' ] );

		/**
		 * @example Unregister taxonomies.
		 */
		$this->remove_taxonomy( 'post_tag', [ 'post' ] );
	}
}
