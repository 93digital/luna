<?php
/**
 * Luna Base (ba-dum-tss!).
 *
 * An abstract parent class for the main Luna theme object.
 * The general setup of the theme is done here.
 * 
 * The class and others in the /base directory set up some basic theme requirements.
 * They usually shouldn't need to be changed or edited.
 * The prefix 'base_' is added to all base methods and props.
 *
 * @package luna
 * @subpackage luna-base
 */

/**
 * Luna Base abstract class.
 * Parent class to the main theme class Luna_Setup.
 */
abstract class Luna_Base {
	/**
	 * The main script dependencies.
	 * This is required to be a property as it used by multiple class methods.
	 */
	private $script_deps = [];

  /**
   * Construct
   * It should be called by any inheriting classes upon instantiation.
   */
  protected function __construct() {
		/**
		 * Instantiate Hook classes.
		 */
		new Luna_Hooks();
		new Luna_Shortcodes();
		if ( is_admin() ) {
			new Luna_Back_End_Hooks();
		}
		if ( ! is_admin() || wp_doing_ajax() ) {
			new Luna_Front_End_Hooks();
		}

		/**
		 * Base theme hooks.
		 */
		// Theme support and setup.
		add_action( 'after_setup_theme', [ $this, 'base_theme_setup' ], 0 );

		// Adds custom images sizes to Gutenberg.
		add_filter( 'image_size_names_choose', [ $this, 'base_custom_image_sizes' ] );
		
		// Enqueue default scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'base_scripts' ], 0 );

		// Enqueue default stylesheets.
		add_action( 'wp_enqueue_scripts', [ $this, 'base_styles' ], 0 );

		// Enqueue custom admin styles.
		add_action( 'admin_enqueue_scripts', [ $this, 'base_admin_styles' ], 0 );

		// Remove the users REST API endpoints.
		add_filter( 'rest_endpoints', [ $this, 'base_remove_user_rest_api_endpoints' ] );

		// Add required security headers to the front end.
		add_action( 'send_headers', [ $this, 'base_add_security_headers' ], 0 );

		// Defer all external scripts.
		add_filter( 'script_loader_tag', [ $this, 'base_set_defer_attribute' ], 10, 3 );

		// Disable author archive and single pages.
		add_action( 'template_redirect', [ $this, 'base_disbale_author_pages' ] );

		// Remove comments for pages and posts.
		add_action( 'admin_init', [ $this, 'base_remove_comment_support' ] );
		add_filter( 'manage_edit-post_columns', [ $this, 'base_remove_comment_columns' ] );

		// Disable emojis.
		add_action( 'init', [ $this, 'base_disable_wp_emojicons' ] );

		// Disable xmlrpc, it wont be needed and is a vulnerability.
		add_filter( 'xmlrpc_enabled', '__return_false' );
	}

  /**
   * 'after_setup_theme' action hook.
   * Add required theme support.
   */
  public function base_theme_setup() {
    // Make theme available for translation.
    load_theme_textdomain( 'luna', get_template_directory() . '/languages' );
    
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

		// Allow excerpts the be added to pages, used for search results etc.
		add_post_type_support( 'page', 'excerpt' );

		// Add custom image sizes.
		add_image_size( 'mobile', 375 );
  	add_image_size( 'tablet', 768 );

    // Switch default markup for search form, comment form, and comment to output valid HTML5.
    add_theme_support(
      'html5',
      [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
      ]
    );

    // Gutenberg styling.
    add_theme_support( 'editor-styles' );
    add_editor_style( 'style-editor.css' );
	}

	/**
	 * 'image_size_names_choose' filter hook callback.
	 * Add custom image sizes to Gutenberg.
	 *
	 * @param array $sizes Default image sizes.
	 * @return array Updates image sizes.
	 */
	public function base_custom_image_sizes( $sizes ) {
		$new_sizes = [
			'mobile' => __( 'Mobile', 'luna' ),
			'tablet' => __( 'Tablet', 'luna' ),
		];
		return array_merge( $sizes, $new_sizes );
	}

	/**
	 * 'wp_enqueue_scripts' action hook callback.
	 * Enqueue the main theme scripts.
	 */
	public function base_scripts() {
		$script_src        = get_template_directory_uri() . '/build/index.js';
		$script_path       = get_template_directory() . '/build/index.js';
		$script_asset_path = get_template_directory() . '/build/index.asset.php';

		if ( ! file_exists( $script_asset_path ) ) {
			throw new Error( 'You need to run `npm run watch` or `npm run build` first.' );
		}
		$script_asset = require $script_asset_path;

		// Localised data for use witin the JS.
		$data = [
			'homeUrl' => home_url(),
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'wp_rest' ),
		];

		/**
		 * 'luna_localize_script' filter hook.
		 * Allows custom localised data to be added to the luna JavaScript object.
		 *
		 * @param array $data The default localised data.
		 * @return array $data An updated data array containing custom data alonside the default data.
		 */
		$data = apply_filters( 'luna_localize_script', $data );

		// Dependencies for the main theme script file.
		$this->script_deps = $script_asset['dependencies'];

		/**
		 * 'luna_register_script' filter hook.
		 * All custom scripts for a site should be added via this filter hook.
		 * Any dependencies for the main theme script file must be added to $this->script_deps and returned.
		 *
		 * @param array $this->script_deps Default script dependenies.
		 * @return array $this->script_depts An updated array of script dependencies.
		 */
		$this->script_deps = apply_filters( 'luna_register_script', $this->script_deps );

		// Add Civic remote script if required.
		if ( $data['civic']['licenseKey'] ) {
			// The Civic remote script is only required if a license key has been added.
			wp_enqueue_script(
				'cookie-control',
				'https://cc.cdn.civiccomputing.com/9/cookieControl-9.x.min.js',
				[],
				false,
				true
			);
			$this->script_deps[] = 'cookie-control';
		}

		// Register, localise the above data and enqueue.
		wp_register_script(
			'luna-script',
			$script_src,
			$this->script_deps,
			$script_asset['version'],
			true
		);
		wp_localize_script( 'luna-script', 'luna', $data );
		wp_enqueue_script( 'luna-script' );

		// Comment reply styelsheet.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * 'wp_enqueue_scripts' action hook callback.
	 * Enqueue the main theme stylesheets.
	 */
	public function base_styles() {
		$style_src  = get_template_directory_uri() . '/style.css';
		$style_path = get_template_directory() . '/style.css';

		// Dependencies for the main theme stylesheet.
		$style_deps = [];

		/**
		 * 'luna_register_style' filter hook.
		 * All custom stylesheets for a site should be added via this filter hook.
		 * Any dependencies for the main theme stylesheet must be added to $style_deps and returned.
		 *
		 * @param array $style_deps Default stylesheet dependenies.
		 * @return array $style_deps An updated array of stylesheet dependencies.
		 */
		$style_deps = apply_filters( 'luna_register_style', $style_deps );

		// A stylish enqueue.
		wp_enqueue_style(
			'luna-style',
			$style_src,
			$style_deps,
			@filemtime( $style_path ) // phpcs:ignore
		);
	}

	/**
	 * 'admin_enqueue_scripts' action hook callback.
	 * Enqueue the main admin stylesheets..
	 */
	public function base_admin_styles() {
		$admin_style_src  = get_template_directory_uri() . '/style-admin.css';
		$admin_style_path = get_template_directory() . '/style-admin.css';

		if ( ! file_exists( $admin_style_path ) ) {
			// Admin styleseheet missing.
			return;
		}

		// A stylish enqueue.
		wp_enqueue_style( 'luna-admin-style', $admin_style_src, [], filemtime( $admin_style_path ) ); // phpcs:ignore
	}

	/**
	 * 'rest_endpoints' filter hook calback.
	 * Remove the users REST API endpoint which publicly reveals all WP user names.
	 * Not a vulnerability as such, but still a good idea to remove as it is not required.
	 *
	 * @param array $endpoints Default REST API endpoints.
	 * @return array $endpoints Updated REST API endpoints with the /users/ endpoints removed.
	 */
	public function base_remove_user_rest_api_endpoints( $endpoints ) {
		if ( is_user_logged_in() ) {
			// Do not remove endpoints for logged in users.
			return $endpoints;
		}

		if ( isset( $endpoints['/wp/v2/users'] ) ) {
			unset( $endpoints['/wp/v2/users'] );
		}
		if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
			unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}

		return $endpoints;
	}

	/**
	 * 'security_headers' action hook callback.
	 * Add default Luna security headers to the site.
	 * These should all be added to every site and will be reqruied 99% of the time.
	 */
	public function base_add_security_headers() {
		if ( is_admin() ) {
			// This can cause issues in the admin area.
			return;
		}

		// HSTS Security Header.
		header( 'Strict-Transport-Security: max-age=31536000;' );
		// X-Frame-Options Security Header.
		header( 'X-Frame-Options: SAMEORIGIN' );
		// X-XSS-Protection Security Header.
		header( 'X-XSS-Protection: 1; mode=block' );
		// X-Content-Type-Options Security Header.
		header( 'X-Content-Type-Options: nosniff' );
		// Referrer Policy Security Header.
		header( 'Referrer-Policy: no-referrer' );
	}

	/**
	 * Add defer attribute to all the external JS files (that are not loaded by from the theme).
	 * Plugins like GF use inline JS when enabling ajax feature and so we cannot defer jQuery.
	 *
	 * @param string $tag Default HTML script tag.
	 * @param string $handle The script handle.
	 * @param string $src The script source.
	 * @return string The updated HTML sctipt tag.
	 */
	public function base_set_defer_attribute( $tag, $handle, $src ) {
		if ( is_admin() ) {
			// Only for the front end.
			return $tag;
		}

		if ( in_array( $handle, $this->script_deps ) ) {
			// Do not defer any dependencies of the main theme script.
			return $tag;
		}

		if ( stripos( $src, 'jquery' ) !== false ) {
			// Do not defer jQuery.
			return $tag;
		}

		// Pop a defer attribute into the tag and return.
		return str_replace( ' src', ' defer src', $tag );
	}

	/**
	 * 'template_redirect' action hook callback.
	 * Disable the author pages by triggering a 404.
	 */
	public function base_disbale_author_pages() {
		if ( is_author() ) {
			global $wp_query;
    	$wp_query->set_404();
		}
	}

	/**
	 * 'admin_init' acton hook callback.
	 * WP comments are often not required in site builds.
	 * This removes the meta box from pages and posts and also removes the Comments menu item.
	 */
	public function base_remove_comment_support() {
		remove_post_type_support( 'post', 'comments' );
		remove_post_type_support( 'page', 'comments' );

		remove_menu_page( 'edit-comments.php' );
	}

	/**
	 * 'manage_edit-post_columns' filter hook callback.
	 * Remove the comments columns from the Posts edit.php page.
	 * 
	 * @param $columns Default columns.
	 * @return $columns Updated columns with comment removed.
	 */
	public function base_remove_comment_columns( $columns ) {
		unset( $columns['comments'] );
		return $columns;
	}

	/**
	 * 'init' action hook callback.
	 * Disbale generally unneeded emoji actions and scripts.
	 */
	public function base_disable_wp_emojicons() {
		// Remove all actions related to emojis.
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		// Remove not needed scripts.
		wp_deregister_script( 'wp-embed' );
	}
}
