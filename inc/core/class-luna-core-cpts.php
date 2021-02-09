<?php
/**
 * Luna core custom post type and taxonomy registration class.
 *
 * Contains methods and functionality required to register cpts and taxonomies within the theme.
 *
 * @package luna
 * @subpackage luna-core
 *
 * @todo weave in taxonomies.
 */

/**
 * Luna Core CPT and taxonomy class.
 */
abstract class Luna_Core_Cpts {
  /**
   * Checks if the class has already been instantiated.
   * @var bool
   */
  private $is_instantiated = false;

	/**
	 * Construct.
   * All CPTs and taxonomies registered here.
	 */
	protected function __construct() {
    // Check if the CPT class has already been instantiated.
    if ( self::$is_instantiated ) {
      // CPTs and taxonmies should only be registered ONCE!
      trigger_error(
        'The Custom Post Type and Taxonomy class <strong>Luna_Cpts()</strong> has already been instantiated.',
        E_USER_ERROR
      );
    }

    self::$is_instantiated = true;
  }

  /**
   * This essentially works in the same way as WordPress' register_post_type() function.
   * Some extra, bespoke 93digtial functionality is layered on top within this method.
	 *
	 * There are some default args added here which override the WordPress default args:
	 * @var string menu_icon     The portfolio icon (instead of the pin).
	 * @var string has_archive   A plurlised slug of the passed post type (instead of false).
	 * @var int    menu_position Set to 20, just below pages (instead of the bottom of the menu).
	 * @var array  rewrite       'with_front' set to false (instead of true).
	 * @var bool   show_in_rest  Set to true for Gutenberg (instead of false).
	 * @var array  supports      Added 'page-attributes', 'thumbnail' and 'revisions' to the default.
	 *                           (default is 'title' and 'editor').
   *
   * @see https://developer.wordpress.org/reference/functions/register_post_type/
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
			'menu_icon'     => 'dashicons-portfolio',
			'has_archive'   => $this->pluarlise( $post_type ),
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

		$cpt = register_post_type(
			$post_type,
			array_merge(
				$default_args,
				$args
			)
		);

		// If the post type has an archive page set up an options page (if ACF is active).
		if ( $args['has_archive'] !== false ) {
			// Set the returned options page settings array as a custom param of the WP_Post_Type class.
			$cpt->options_page = $this->register_cpt_options_page( $post_type, $plural );
		}

		return $cpt;
	}

	/**
	 * Register an ACF options page for a custom post type.
	 * This options page can be used to set archive page information for the CPT.
	 *
	 * ACF Pro needs to be installed and active for this to work.
	 *
	 * @param string $post_type The register custom post type slug.
	 * @param string $plural The post type plural label.
	 * @return array The option page settings.
	 */
	protected function register_cpt_options_page( $post_type, $plural ) {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			trigger_error(
				'ACF options page registration for ' . $plural . ' failed. ACF is not active.',
				E_USER_WARNING
			);
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
