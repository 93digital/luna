<?php
/**
 * Luna base Gutenberg theme settings.
 *
 * Theme specific Gutenberg settings and options.
 *
 * @package luna
 * @subpackage luna-base
 */

/**
 * Luna base Gutenberg class.
 */
abstract class Luna_Base_Gutenberg{
	/**
	 * Instantiation (via child class).
	 * Register base Gutenberg-specific scripts and settings.
	 */
	protected function __construct() {
		// Theme Support.
		add_action( 'after_setup_theme', [ $this, 'gutenberg_theme_setup' ] );

    // Register Luna Blocks.
    add_action( 'enqueue_block_editor_assets', [ $this, 'gutenberg_scripts' ] );
	}

	/**
	 * 'after_setup_theme' action hook callback.
	 * Add and remove some Gutenberg-related theme support.
	 */
	public function gutenberg_theme_setup() {
		add_theme_support( 'align-wide' );
		remove_theme_support( 'core-block-patterns' );
	}

  /**
   * 'enqueue_block_editor_assets' action hook callback.
   * Register Luna blocks scripts and styles.
   */
  public function gutenberg_scripts() {
    $script_asset_path = get_template_directory() . '/build/blocks.asset.php';

		// WP Scripts is required for the Gutenberg script file.
    if ( ! file_exists( $script_asset_path ) ) {
      trigger_error(
				'You need to run `npm start` or `npm run build` first.',
				E_USER_ERROR
			);
    }
    $script_asset = require $script_asset_path;

		/**
		 * 'luna_enqueue_blocks_script' filter hook.
		 * All custom blocks script enqueues for a site should be added via this filter hook.
		 * Any dependencies for the main theme script file must be added to $this->script_deps and returned.
		 *
		 * @param array $script_asset['dependencies'] Default script dependencies, set in WP Scripts.
		 * @return array $script_deps An updated array of script dependencies.
		 */
		$script_deps = apply_filters( 'luna_enqueue_blocks_script', $script_asset['dependencies'] );
  
    // Register Luna Blocks.
    wp_register_script(
      'luna-blocks',
      get_template_directory_uri() . '/build/blocks.js',
      $script_deps,
      $script_asset['version']
    );
  
    wp_register_style( 'luna-blocks', get_template_directory_uri() . '/build/blocks.css', [] );
    
    // Set Script Translations.
    wp_set_script_translations( 'luna-blocks', 'luna' );
  
    // Enqueue Luna Blocks.
    wp_enqueue_script( 'luna-blocks' );
    wp_enqueue_style( 'luna-blocks' );
  }
}
