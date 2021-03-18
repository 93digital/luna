<?php
/**
 * Luna Base Global Options.
 *
 * Registers the Global Options area in the back end.
 * Contains methods to allow sub pages to Global Options to be added easily.
 *
 * @package luna
 * @subpackage luna-base
 */

/**
 * Luna Global Options class.
 */
abstract class Luna_Base_Global_Options {
	/**
	 * The Global Options page settings, as returned from acf_add_options_page().
	 * @var array
	 */
	protected $page_settings;

	/**
	 * An array of sub page settings, as returned from acf_add_options_sub_page().
	 * @var array
	 */
	protected $sub_page_settings = [];

	/**
	 * Construct.
   * Register the Global Options page and fields if ACF is available.
	 */
	protected function __construct() {
    if ( ! function_exists( 'get_field' ) ) {
      // ACF isn't active!
      return;
		}

		// Adds the Global Options settings page and menu items.
		add_action( 'acf/init', [ $this, 'base_global_options_pages' ], 0 );
	}

  /**
	 * 'acf/init' action hook callback.
	 * Initialise the Global Options settings page and any sub pages.
	 */
	public function base_global_options_pages() {
		// Main Global Options settings page and WP admin menu item.
		$this->page_settings = acf_add_options_page(
			[
				'page_title' => 'Global Options',
				'post_id'    => 'global_options',
				'capability' => 'manage_options',
				'position'   => 60,
			]
		);

		// General options sub page.
		$this->add_sub_page( 'General' );

		// Header options sub page.
		$this->add_sub_page( 'Header' );

		// Footer options sub page.
		$this->add_sub_page( 'Footer' );

		// Social options sub page.
		$this->add_sub_page( 'Social' );

		// 404 options sub page.
		$this->add_sub_page( '404' );

		// Search options sub page.
		$this->add_sub_page( 'Search' );
	}

	/**
	 * Add a sub-page to global options.
	 */
	protected function add_sub_page( $title ) {
		$slug = $luna->utilities->slugify( $title );
		if ( isset( $this->sub_page_settings[ $slug ] ) ) {
			trigger_error(
				'A Global Options sub page has already been registered for <strong>' . esc_html( $title ) . '</strong>',
				E_USER_WARNING
			);

			return;
		}

		$this->sub_page_settings[ $slug ] = acf_add_options_sub_page(
			[
				'page_title'  => $title,
				'post_id'     => $slug . '_options',
				'capability'  => 'manage_options',
				'parent_slug' => 'acf-options-global-options',
			]
		);
	}
}
