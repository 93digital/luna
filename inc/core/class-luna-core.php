<?php
/**
 * Luna core.
 *
 * An abstract parent class for the main Luna theme object.
 * The general setup of the theme is done here.
 * 
 * The class along with others in the /core directory are essential hidden or background classes.
 * They shouldn't ever need to be changed or edited.
 * The prefix 'core_' is added to all core methods and props.
 *
 * @package luna
 * @subpackage luna-core
 */

/**
 * Luna Core abstract class.
 * Parent class to the main theme class Luna_Setup.
 */
abstract class Luna_Core {
	/**
	 * The luna PHP error handler class.
	 * @var object Luna_Core_Errors
	 */
	private $core_errors;

  /**
   * Base construct.
   * This is really a proper construct method as this abstract class does not get instantiated.
   * It should be called by any inheriting classes upon instantiation.
   */
  protected function __construct() {
		// Include the Composer autoloader.
		// include_once get_template_directory() . '/vendor/autoload.php';

		// Core classes.
		new Luna_Core_Acf_Utility();
		new Luna_Core_Errors();

		// Luna classes.
		$this->cpts       = new Luna_Cpts();
		$this->shortcodes = new Luna_Shortcodes();

		// Theme support and setup.
		add_action( 'after_setup_theme', [ $this, 'core_setup' ], 0 );

		// Enqueue default stylesheets.
		add_action( 'wp_enqueue_scripts', [ $this, 'core_styles' ], 0 );
		
		// Enqueue default scripts.
		add_action( 'wp_enqueue_scripts', [ &$this, 'core_scripts' ], 0 );

		// Remove the users REST API endpoints.
		add_filter( 'rest_endpoints', [ $this, 'core_remove_user_rest_api_endpoints' ] );

		// Add required security headers.
		add_action( 'send_headers', [ $this, 'core_add_security_headers' ], 0 );

		// Disable xmlrpc, it wont be needed and is a vulnerability.
		add_filter( 'xmlrpc_enabled', '__return_false' );
	}

  /**
   * 'after_theme_setup' action hook.
   * Add required theme support.
   */
  public function core_setup() {
    // Make theme available for translation.
    load_theme_textdomain( 'luna', get_template_directory() . '/languages' );
    
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Register nav menus.
    register_nav_menus(
      [
        'primary' => esc_html__( 'Primary Menu', 'luna' ),
      ]
    );

    // Switch default core markup for search form, comment form, and comment to output valid HTML5.
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
	 * Enqueue the core theme stylesheets.
	 */
	public function core_styles() {
		$style_src  = get_template_directory_uri() . '/style.css';
		$style_path = get_template_directory() . '/style.css';

		// A stylish enqueue.
		wp_enqueue_style( 'luna-style', $style_src, [], filemtime( $style_path ) );
	}

	/**
	 * Enqueue the core theme scripts.
	 */
	public function core_scripts() {
		$script_src  = get_template_directory_uri() . '/build/index.js';
		$script_path = get_template_directory() . '/build/index.js';

		// Localised data for use witin the JS.
		$data = [
			'homeUrl' => home_url(),
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'wp_rest' ),
		];

		// Allow for localised data to be modified.
		$data = apply_filters( 'luna_localize_script', $data );

		// Register, localise the above data and enqueue.
		wp_register_script( 'luna-script', $script_src, [], filemtime( __FILE__ ), true );
		wp_localize_script( 'luna-script', 'luna', $data );
		wp_enqueue_script( 'luna-script' );

		// Comment reply styelsheet.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * 'rest_endpoints' filter hook calback.
	 * Remove the users REST API endpoint which publicly reveals all WP user names.
	 * Not a vulnerability as such, but still a good idea to remove as it is not required.
	 *
	 * @param array $endpoints Default REST API endpoints.
	 * @return array $endpoints Updated REST API endpoints with the /users/ endpoints removed.
	 */
	public function core_remove_user_rest_api_endpoints( $endpoints ) {
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
	public function core_add_security_headers() {
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
}
