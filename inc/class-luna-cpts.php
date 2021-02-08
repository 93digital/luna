<?php
/**
 * Luna custom post type and taxonomy registration.
 *
 * All cpts and taxonomies should be registered in this class.
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
class Luna_Cpts extends Luna_Core_Cpts {
	/**
	 * Construct.
   * All CPTs and taxonomies registered here.
	 *
	 * Remember internationalisation when registering labels!
	 */
	public function __construct() {
    // Instantiate the parent class.
    parent::__construct();

    // EXAMPLE: 'Book' post type.
    // $book = $this->register_post_type()
  }
}
