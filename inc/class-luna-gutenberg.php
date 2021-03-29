<?php
/**
 * Luna Gutenberg theme settings.
 *
 * All custom theme Guteneberg-related functionality should be added to this class.
 * ACF blocks should also be registered here.
 * The parent class contains some functionality that is typically always needed.
 *
 * @package luna
 */

/**
 * Luna Gutenberg class.
 */
final class Luna_Gutenberg extends Luna_Base_Gutenberg {
  /**
   * Instantiation.
   * Call the parent's construct which regsiters scripts and sets a few options.
   */
  public function __construct() {
    // Instantiate base Gutenberg functionality.
    parent::__construct();

		/**
		 * @example custom theme setup for editor fonts.
		 */
		add_action( 'after_setup_theme', [ $this, 'gutenberg_editor_fonts' ] );

		/**
		 * @example custom theme setup for editor colours.
		 */
		add_action( 'after_setup_theme', [ $this, 'gutenberg_editor_colours' ] );

		/**
		 * @example add a custom block category.
		 */
		add_filter( 'block_categories', [ $this, 'register_block_category' ], 10, 2 );

		// All ACF-related functionality should be placed AFTER this check.
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			// ACF is required.
			return;
		}

		/**
		 * @example register and ACF block.
		 */
		add_action( 'acf/init', [ $this, 'register_acf_block_types' ] );
  }

	/**
	 * 'after_setup_theme' action hook callback.
	 * @example Add custom font sizes.
	 */
	public function gutenberg_editor_fonts() {
		// Disable custom font sizes.
		add_theme_support( 'disable-custom-font-sizes' );

		// Set custom font size options.
		add_theme_support(
			'editor-font-sizes',
			[
				[
					'name' => __( 'Small', 'luna' ),
					'size' => 14,
					'slug' => 'small'
				],
				[
					'name' => __( 'Regular', 'luna' ),
					'size' => 16,
					'slug' => 'regular'
				],
				[
					'name' => __( 'Large', 'luna' ),
					'size' => 32,
					'slug' => 'large'
				]
			]
		);

		// Disable some colour options.
		add_theme_support( 'disable-custom-colors' );
		add_theme_support( 'disable-custom-gradients' );
	}

	/**
	 * 'after_setup_theme' action hook callback.
	 * @example Add custom colour options.
	 */
	public function gutenberg_editor_colours() {
		// Custom solid colours.
		add_theme_support(
			'editor-color-palette',
			[
				[
					'name'  => __( 'Black', 'luna' ),
					'slug'  => 'black',
					'color' => '#000000',
				],
				[
					'name'  => __( 'White', 'luna' ),
					'slug'  => 'white',
					'color' => '#FFFFFF',
				],
			]
		);

		// Custom gradients.
		add_theme_support(
			'editor-gradient-presets',
			[
				[
					'name'     => __( 'Gradient One', 'luna' ),
					'slug'     => 'gradient-1',
					'gradient' => 'linear-gradient(135deg, #00FFFF 0%, #FF1493 100%)'
				],
			]
		);
	}

	/**
	 * 'block_categories' filter hook callback.
	 * @example Register Luna Block Category.
	 *
	 * @param array $categories Default block categories.
	 * @return array Update block categories.
	 */
	public function register_block_category( $categories ) {
		return array_merge(
			$categories,
			[
				[
					'slug'  => 'luna-blocks',
					'title' => __( 'Luna Blocks', 'luna' ),
				],
			]
		);
	}

	/**
	 * 'acf/init' action hook callback.
	 * Register custom ACF Blocks.
	 *
	 * @see https://www.advancedcustomfields.com/resources/acf_register_block_type/
	 */
	function register_acf_block_types() {
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			// ACF is required to register ACF blocks!
			return;
		}

		/**
		 * @example
		 */
		acf_register_block_type(
			[
				'name'            => 'luna-block',
				'title'           => __( 'Luna block', 'luna' ),
				'description'     => __( 'Luna block description.', 'luna' ),
				'render_template' => 'modules/m00-luna-block.php',
				'category'        => 'luna-blocks',
				'icon'            => 'align-center',
				'keywords'        => [ 'acf', 'luna' ],
				'supports'        => [
					'mode'     => false,
					'align'    => false,
					'multiple' => true,
				],
			]
		);
	}
}
