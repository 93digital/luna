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
	 * Default post type WP_Post_Type object.
	 * @var object
	 */
	public $post;

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
	 * Instantiation (via child class).
	 * Registers CPTs and taxonomies added within the child class.
   * Then grabs all the registered taxonomies and attaches them to their Luna cpt objects.
	 */
	protected function __construct() {
		// Register cpts and taxonomies.
		add_action( 'init', [ $this, 'register_cpts_and_taxonomies' ], 0 );

		// Unregister default post types and taxonomies (if required).
		add_action( 'init', [ $this, 'unregister_cpts_and_taxonomies' ], 1 );

		// Add a property containing a post type object for the default post type.
		add_action( 'init', [ $this, 'get_default_post_type_object' ], 2 );

    // Attach registered taxonomies to the relevant post type objects.
		add_action( 'init', [ $this, 'attach_taxonomies_to_post_types' ], 99 );

		// Add the default post type property to this cpt object and add an options page.
		add_action( 'acf/init', [ $this, 'register_cpt_options_pages' ] );

		// Add a notice to the top of the Blog page notifying admin of the custom Post Settings page.
		add_action( 'admin_notices', [ $this, 'add_blog_page_notice' ] );
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
	 * @param string       $taxonomy A taxonomy slug.
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
	 * Unregister any not required post types or taxonomies.
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
	 * 'init' action hook callback.
	 * Attach a post type object for the default post type, Posts, to the CPT object as a property.
	 */
	public function get_default_post_type_object() {
		$default_post_type = get_post_type_object( 'post' );
		if ( $default_post_type instanceof WP_Post_Type ) {
			// Add the WP_Post_Type object to the $post property.
			$this->post = $default_post_type;
		} else {
			// Remove the property if posts has been unset (it really shouldn't have been...!).
			unset( $this->post );
		}
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
	 * 'acf/init' action hook callback.
	 * Register ACF options pages for all registered CPTs that have an archive page.
	 * Also register an option page for the default post type.
	 *
	 * ACF or ACF Pro needs to be installed and active for this to work.
	 */
	public function register_cpt_options_pages() {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			// ACF not available.
			return false;
		}

		foreach ( get_object_vars( $this ) as $post_type => $val ) {
			if ( ! $val instanceof WP_Post_Type ) {
				// We only want post type properties.
				continue;
			}

			// If the CPT has an archive page or is the default post type then set up an options page.
			if ( ! empty( $this->{$post_type}->has_archive ) || $post_type === 'post' ) {
				$parent_slug = 'edit.php';
				if ( $post_type !== 'post' ) {
					// CPT parent slugs have a post_type arg.
					$parent_slug .= '?post_type=' . $post_type;
				}

				// Register the options page and append to the post type property.
				$this->{$post_type}->options_page = acf_add_options_page(
					[
						'post_id'     => $post_type . '-settings',
						'page_title'  => $this->{$post_type}->label . ' Settings',
						'parent_slug' => $parent_slug,
						'menu_slug'   => $post_type . '-settings',
					]
				);
			}
		}
	}
	
	/**
	 * 'admin_notices' action hook callback.
	 * Add a notice letting the WP user know about the custom Post Settings area.
	 */
	public function add_blog_page_notice() {
		global $pagenow;
		global $submenu;

		// Check if this is the Blog page.
		if (
			$pagenow !== 'post.php' ||
			empty( $_GET['post'] ) || // phpcs:ignore
			$_GET['post'] !== get_option( 'page_for_posts' ) // phpcs:ignore
		) {
			// This is not the Blog admin page.
			return;
		}

		// Also check if a custom options page has been set up for Posts.
		if ( ! in_array( 'post-settings', wp_list_pluck( $submenu['edit.php'], 2 ) ) ) {
			// The custom post settings page does not exist.
			return;
		}

		ob_start();
		?>
		<div class="notice notice-info">
			<p>
				<?php
				_e( // phpcs:ignore
					sprintf( 
						'Options for this page can be in the %sPost Settings options page%s',
						'<a href="' . esc_url( admin_url( 'edit.php?page=post-settings' ) ) . '"><strong>',
						'</strong></a>'
					),
					'luna'
				);
				?>
			</p>
		</div>
		<?php
		ob_get_flush();
	}

	/**
   * Luna wrapper for the core WordPress register_post_type() function.
	 * This essentially works in the same way as WordPress' register_post_type() function.
   * Some extra, bespoke 93digital functionality is layered on top within this method.
	 * Specifically custom default args and the creation of a CPT options page.
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
		$singular       = ucwords( str_replace( [ '-', '_' ], ' ', strtolower( $post_type ) ) );
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
	}

	/**
   * Luna wrapper for the core WordPress register_taxonomy() function.
	 * This essentially works in the same way as WordPress' register_taxonomy() function.
   * Some extra, bespoke 93digital functionality is layered on top within this method.
	 * Specifically custom default args.
	 * 
	 * @see https://developer.wordpress.org/reference/functions/register_post_type/
	 * 
	 * @param string       $taxonomy Custom taxonomy slug.
	 * @param array|string $object_type An array of multiple taxonomy slugs or a single slug string.
	 * @param array        $args Custom taxonomy args.
	 * 										 These will overwrite any matching arg in the $default_tax_args property.
	 */
	private function register_taxonomy( $taxonomy, $object_type, $args = [] ) {
		// Ensure the post type slug is properly slugified.
		$taxonomy = sanitize_title( $taxonomy );

		// Set some default labels.
		$singular       = ucwords( str_replace( [ '-', '_' ], ' ', strtolower( $taxonomy ) ) );
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
