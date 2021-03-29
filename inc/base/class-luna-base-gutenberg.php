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

    if ( ! file_exists( $script_asset_path ) ) {
      throw new Error( 'You need to run `npm start` or `npm run build` first.' );
    }
    
    $script_asset = require( $script_asset_path );
  
    // Register Luna Blocks.
    wp_register_script(
      'luna-blocks',
      get_template_directory_uri() . '/build/blocks.js',
      $script_asset['dependencies'],
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
