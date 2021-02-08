<?php
/**
 * Luna core custom post type and taxonomy registration class.
 *
 * Contains methods and functionality required to register cpts and taxonomies within the theme.
 *
 * @package luna
 * @subpackage luna-core
 *
 * @todo CPT options page.
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
				'author',
				'page-attributes',
				'thumbnail',
				'revisions',
			]
		];
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
