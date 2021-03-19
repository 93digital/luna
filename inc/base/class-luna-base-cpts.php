<?php
/**
 * Luna base CPTs and taxonomies.
 *
 * Contains functionality required to register cpts and taxonomies within the theme.
 * The child class should construct this parent class and use the following methods:
 * - add_post_type()
 * - add_taxonomy()
 * - remove_taxonomy()
 *
 * @package luna
 * @subpackage luna-base
 */

/**
 * Luna Base CPT and taxonomy base methods.
 */
abstract class Luna_Base_Cpts {
	/**
	 * Array of post types (including args) to register.
	 * The array keys will be post type slugs.
	 * The array values will be the post type args.
	 *
	 * This property is unset after registering the custom post types.
	 * @var array
	 */
	private $cpt_list = [];

	/**
	 * Array of taxonomies (including args and object type) to register.
	 * The array keys will be the taxonomy slugs.
	 * The array values will be a nested array containing these keys:
	 * - args [array]
	 * - object_type [array|string]
	 *
	 * This property is unset after registering the custom taxonomies.
	 * @var array
	 */
	private $tax_list = [];

	/**
	 * Array of taxonomies to unregister.
	 * The array keys will be taxonomy slugs.
	 * The array values will be either a object type string or an array of object types.
	 *
	 * This property is unset after unregistering the listed taxonomies.
	 * @var array
	 */
	private $tax_remove_list = [];

	/**
	 * Luna default post type args.
	 * These overwrite the default WordPress args but can be overwritten by individual post types.
	 * @var array
	 */
	private $default_cpt_args = [
		'menu_icon'     => 'dashicons-portfolio',
		'menu_position' => 20,
		'public'        => true,
		'rewrite'       => [
			'with_front'  => false,
		],
		'show_in_rest'  => true,
		'supports'      => [
			'title',
			'editor',
			'page-attributes',
			'thumbnail',
			'revisions',
		]
	];

	/**
	 * Luna default taxonomy args.
	 * These overwrite the default WordPress args but can be overwritten by individual taxonomies.
	 * @var array
	 */
	private $default_tax_args = [
		'hierarchical' => true,
		'rewrite'      => [
			'with_front' => false,
		],
		'show_in_rest' => true,
	];

	/**
	 * Abstract construct. Only available to inheriting class.
   * Grabs all the registered taxonomies and attached them to their Luna cpt objects.
	 * This is just done as a helper.
	 */
	protected function __construct() {
		// Register cpts and taxonomies.
		add_action( 'init', [ $this, 'register_cpts_and_taxonomies' ], 0 );

		// Unregister default post types and txonomies (if required).
		add_action( 'init', [ $this, 'unregister_cpts_and_taxonomies' ], 1 );

    // Attach registered taxonomies to the relevant post type objects.
		add_action( 'init', [ $this, 'attach_taxonomies_to_post_types' ], 99 );
  }

	/**
	 * Add a new post type to list of custom post types to register.
	 * This method does not need to be called within a hook callback.
	 *
	 * @param string $post_type Custom post type slug.
	 * @param array  $args Custom post type args.
	 */
	protected function add_post_type( $post_type, $args = [] ) {
		$this->cpt_list[ $post_type ] = $args;
	}

	/**
	 * Add a new taxonomy to the list of custom taxonomies to register.
	 * This method does not need to be called within a hook callback.
	 *
	 * @param string       $taxonomy Custom taxonomy slug.
	 * @param array|string $object_type An array of multiple cpt slugs or a single slug string.
	 * @param array        $args Custom taxonomy args.
	 */
	protected function add_taxonomy( $taxonomy, $object_type, $args = [] ) {
		$this->tax_list[ $taxonomy ] = [
			'object_type' => $object_type,
			'args'        => $args,
		];
	}

	/**
	 * Add a taxonomy to the list of taxonomies to unregister.
	 * This method does not need to be called within a hook callback.
	 *
	 * @param string $taxonomy A taxonomy slug.
	 * @param string|array $object_type A single object type or a list as an array.
	 */
	protected function remove_taxonomy( $taxonomy, $object_type ) {
		$this->tax_remove_list[ $taxonomy ] = $object_type;
	}

	/**
	 * 'init' action hook callback.
	 * Register all the declared theme custom post types and taxonomies.
	 */
	public function register_cpts_and_taxonomies() {
		// Register the post types first. Each CPT will be a new class property.
		foreach ( $this->cpt_list as $post_type => $args ) {
			$this->register_post_type( $post_type, $args );
		}

		// Now register the custom taxonomies.
		foreach ( $this->tax_list as $taxonomy => $settings ) {
			// Unpack the settings ($object_type and $args).
			extract( $settings );
			$this->register_taxonomy( $taxonomy, $object_type, $args );
		}

		// Remove the cpt and tax list and default args properties as they are no longer needed.
		unset( $this->cpt_list );
		unset( $this->tax_list );
		unset( $this->default_cpt_args );
		unset( $this->default_tax_args );
	}

	/**
	 * 'init' action hook callback.
	 * Unregsiters any unrequired post types or taxonomies.
	 */
	public function unregister_cpts_and_taxonomies() {
		foreach ( $this->tax_remove_list as $tax => $object_type ) {
			if ( is_array( $object_type ) ) {
				foreach ( $object_type as $type ) {
					unregister_taxonomy_for_object_type( $tax, $type );
				}
			} else {
				unregister_taxonomy_for_object_type( $tax, $object_type );
			}
		}

		// Remove the tax removal list as it is no longer needed.
		unset( $this->tax_remove_list );
	}

  /**
   * Luna wrapper for the core WordPress register_post_type() function.
	 * This essentially works in the same way as WordPress' register_post_type() function.
   * Some extra, bespoke 93digtial functionality is layered on top within this method.
	 * Specifically custom default args and the creation of a CPT options page.
	 *
	 * There are some default args added here which override the WordPress default args:
	 * @var string has_archive   A plurlised slug of the passed post type (instead of false).
	 * @var string labels        An array automatically generated singular and plural labels.
	 * @var string menu_icon     The portfolio icon (instead of the pin).
	 * @var int    menu_position Set to 20, just below pages (instead of the bottom of the menu).
	 * @var array  rewrite       'with_front' set to false (instead of true).
	 * @var bool   show_in_rest  Set to true for Gutenberg (instead of false).
	 * @var array  supports      Added 'page-attributes', 'thumbnail' and 'revisions' to the default.
	 *                           (default is 'title' and 'editor').
   *
   * @see https://developer.wordpress.org/reference/functions/register_post_type/
	 *
	 * @param string $post_type Custom post type slug.
	 * @param array  $args Custom post type args.
	 *               These will overwrite any matching arg in the $default_cpt_args property.
   */
 	private function register_post_type( $post_type, $args = [] ) {
		// Ensure the post type slug is properly slugified.
		$post_type = sanitize_title( $post_type );

		// Set some default labels.
		$singular       = ucfirst( str_replace( [ '-', '_' ], ' ', strtolower( $post_type ) ) );
		$plural         = $this->pluralise( $singular );
		$default_labels = [
			'name'          => _x( $plural, 'Post type general name', 'luna' ),
			'singular_name' => _x( $singular, 'Post type singular name', 'luna' ),
		];

		// Merge the default args, default labels and custom args.
		$args = array_merge(
			$this->default_cpt_args,
			[
				'has_archive'   => $this->pluralise( $post_type ),
				'labels'        => $default_labels,
			],
			$args
		);

		// Register!
		$this->{$post_type} = register_post_type( $post_type, $args );

		// If the post type has an archive page then set up an options page (if ACF is active).
		if ( $args['has_archive'] !== false ) {
			// Set the returned options page settings array as a custom param of the WP_Post_Type class.
			$this->{$post_type}->options_page = $this->register_cpt_options_page( $post_type, $plural );
		}
	}

	/**
   * Luna wrapper for the core WordPress register_taxonomy() function.
	 * This essentially works in the same way as WordPress' register_taxonomy() function.
   * Some extra, bespoke 93digtial functionality is layered on top within this method.
	 * Specifically custom default args.
	 *
	 * There are some default args added here which override the WordPress default args:
	 * @var
	 * 
	 * @see https://developer.wordpress.org/reference/functions/register_post_type/
	 * 
	 * @param string       $taxonomy Custom taxonomy slug.
	 * @param array|string $object_type An array of multiple taxonomy slugs or a single slug string.
	 * @param array        $args Custom taxonomy args. See the above list for a list of defaults.
	 * @return $tax        A WP_Taxonomy object on success, WP_Error on failure.
	 */
	private function register_taxonomy( $taxonomy, $object_type, $args = [] ) {
		// Ensure the post type slug is properly slugified.
		$taxonomy = sanitize_title( $taxonomy );

		// Set some default labels.
		$singular       = ucfirst( str_replace( [ '-', '_' ], ' ', strtolower( $taxonomy ) ) );
		$plural         = $this->pluralise( $singular );
		$default_labels = [
			'name'          => _x( $plural, 'taxonomy general name', 'luna' ),
			'singular_name' => _x( $singular, 'taxonomy singular name', 'luna' ),
		];

		// Merge the default args, default labels and custom args.
		$args = array_merge(
			$this->default_tax_args,
			[
				'labels' => $default_labels,
			],
			$args
		);

		// Register!
		register_taxonomy( $taxonomy, $object_type, $args );
	}

	/**
	 * Register an ACF options page for a custom post type.
	 * This options page can be used to set archive page information for the CPT.
	 *
	 * ACF or ACF Pro needs to be installed and active for this to work.
	 *
	 * @param string $post_type The register custom post type slug.
	 * @param string $plural The post type plural label.
	 * @return array The option page settings.
	 */
	private function register_cpt_options_page( $post_type, $plural ) {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			// ACF not available.
			return false;
		}

		// Regsiter the post type settings and return the settings array.
		return acf_add_options_page(
			[
				'post_id'     => 'cpt-' . $post_type,
				'page_title'  => $plural . ' Settings',
				'parent_slug' => 'edit.php?post_type=' . $post_type,
				'menu_slug'   => 'cpt-' . $post_type,
			]
		);
	}

	/**
	 * Attaches WP_Taxonomy objects to each defined post type property of the child class.
	 * This makes each CPTs taxonomy instantly available as part of the $luna object.
	 */
	public function attach_taxonomies_to_post_types() {
		foreach ( get_object_vars( $this ) as $prop => $val ) {
			if ( ! $val instanceof WP_Post_Type ) {
				// We only want post type properties.
				continue;
			}

			$this->{$prop}->taxonomies = get_object_taxonomies( $this->{$prop}->name, 'objects' );
		}
	}	

	/**
	 * Helper function to generate the plural version of a string.
	 * Will either add an 's' on the end or replace a trailing 'y' with 'ies'.
	 *
	 * @param string $string A string to "pluralise".
	 * @return string A plural version of the passed string.
	 */
	private function pluralise( $string ) {
		return substr( $string, -1 ) === 'y' ? substr( $string, 0, -1 ) . 'ies' : $string . 's';
	}
}
