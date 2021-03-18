<?php
/**
 * Luna base CPTs and taxonomies.
 *
 * Contains methods and functionality required to register cpts and taxonomies within the theme.
 *
 * @package luna
 * @subpackage luna-base
 */

/**
 * Luna Base CPT and taxonomy base methods.
 */
abstract class Luna_Base_Cpts {
	/**
	 * Abstract construct. Only available to inheriting class.
   * Grabs all the registered taxonomies and attached them to their Luna cpt objects.
	 * This is just done as a helper.
	 */
	protected function __construct() {
    // Attach registered taxonomies to the relevant post type objects (DO NOT REMOVE).
		add_action( 'init', [ $this, 'attach_taxonomies_to_post_types' ], 99 );
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
	 * @param array  $args Custom post type args. See the above list for a list of defaults.
	 * @return object $cpt A WP_Post_Type object on success, WP_Error on failure.
   */
  protected function register_post_type( $post_type, $args = [] ) {
		// Set some default labels.
		$singular       = ucfirst( str_replace( [ '-', '_' ], ' ', strtolower( $post_type ) ) );
		$plural         = $this->pluralise( $singular );
		$default_labels = [
			'name'          => _x( $plural, 'Post type general name', 'luna' ),
			'singular_name' => _x( $singular, 'Post type singular name', 'luna' ),
		];

		// Luna-specific default post type args.
    $default_args = [
			'has_archive'   => $this->pluralise( $post_type ),
			'labels'        => $default_labels,
			'menu_icon'     => 'dashicons-portfolio',
			'menu_position' => 20,
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

		$args = array_merge(
			$default_args,
			$args
		);
		$cpt = register_post_type( $post_type, $args );

		// If the post type has an archive page set up an options page (if ACF is active).
		if ( $args['has_archive'] !== false ) {
			// Set the returned options page settings array as a custom param of the WP_Post_Type class.
			$cpt->options_page = $this->register_cpt_options_page( $post_type, $plural );
		}

		return $cpt;
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
	protected function register_taxonomy( $taxonomy, $object_type, $args = [] ) {
		// Set some default labels.
		$singular       = ucfirst( str_replace( [ '-', '_' ], ' ', strtolower( $taxonomy ) ) );
		$plural         = $this->pluralise( $singular );
		$default_labels = [
			'name'          => _x( $plural, 'taxonomy general name', 'luna' ),
			'singular_name' => _x( $singular, 'taxonomy singular name', 'luna' ),
		];

		// Luna-specific default post type args.
		$default_args = [
			'hierarchical' => true,
			'rewrite'      => [
				'with_front' => false,
			],
			'show_in_rest' => true,
		];

		$tax = register_taxonomy(
			$taxonomy,
			$object_type,
			array_merge(
				$default_args,
				$args
			)
		);
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
	protected function register_cpt_options_page( $post_type, $plural ) {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return false;
		}

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
