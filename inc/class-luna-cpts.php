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
final class Luna_Cpts extends Luna_Core_Cpts {
	/**
	 * Construct.
   * All CPTs and taxonomies registered here.
	 * Any de-registering of post types and taxonomies should also be done here (Hello, Tags).
	 *
	 * Remember internationalisation when registering labels!
	 */
	public function __construct() {
    // Instantiate the parent class (DO NOT REMOVE).
		parent::__construct();

		// Register cpts and taxonomies
		add_action( 'init', [ $this, 'register_cpts_and_taxonomies' ], 1 );

		// Unregister default post types and txonomies (if required).
		add_action( 'init', [ $this, 'unregister_cpts_and_taxonomies' ], 2 );

		/**
		 * Add any custom CPT and taxonomy related hooks here.
		 */

		// Attach registered taxonomies to the relevant post type objects (DO NOT REMOVE).
		add_action( 'init', [ $this, 'attach_taxonomies_to_post_types' ], 99 );
	}

	/**
	 * 'init' action hook callback.
	 * Registers all the theme custom post types and taxonomies.
	 */
	public function register_cpts_and_taxonomies() {
		/**
		 * @example Register post types.
		 */
		$this->books = $this->register_post_type( 'book' );
		$this->dvds = $this->register_post_type( 'dvd' );
		
		/**
		 * @example Register taxonomies.
		 */
		$this->register_taxonomy( 'genre', [ 'book', 'dvd' ] );
	}

	/**
	 * 'Init' action hook callback.
	 * Unregsiters any unrequired post types or taxonomies.
	 */
	public function unregister_cpts_and_taxonomies() {
		/**
		 * @example Unregsiter post tags for the default post type.
		 */
		unregister_taxonomy_for_object_type( 'post_tag', 'post' );
	}
}
