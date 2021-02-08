<?php
/**
 * Luna Core.
 * An abstract parent class for the main Luna theme object.
 * The general setup of the theme is done here.
 * 
 * The class along with others in the /core directory are essential hidden or background classes.
 * They shouldn't ever need to be changed or edited.
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
   * Base construct.
   * This is really a proper construct method as this abstract class does not get instantiated.
   * It should be called by any inheriting classes upon instantiation.
   */
  protected function __construct() {
		// Include the Composer autoloader.
		include_once get_template_directory() . '/vendor/autoload.php';

		$this->cpts = new Luna_Cpts();

		// Theme support and setup.
		add_action( 'after_theme_setup', [ $this, 'core_setup' ], 0 );

		// Enqueue default stylesheets.
		add_action( 'wp_enqueue_scripts', [ $this, 'core_styles' ], 0 );
		
		// Enqueue default scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'core_scripts' ], 0 );
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
	 *
	 * @todo add a do_action for localisation.
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

		// Register, localise the above data and enqueue.
		wp_register_script( 'luna-script', $script_src, [], filemtime( $script_path ), true );
		wp_localize_script( 'luna-script', 'luna', $data );
		wp_enqueue_script( 'luna-script' );

		// Comment reply styelsheet.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
