<?php
/**
 * Luna Base Global Options.
 *
 * Registers the Global Options area in the back end.
 * Contains methods to allow sub-pages to Global Options to be added easily.
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
	public $page_settings;

	/**
	 * An array of sub-page settings, as returned from acf_add_options_sub_page().
	 * @var array
	 */
	public $sub_page_settings = [];

	/**
	 * Array of sub-page titles (strings) to register.
	 *
	 * This property is unset after registering the sub pages.
	 * @var array
	 */
	private $sub_pages = [];

	/**
	 * Construct.
   * Register the Global Options page and fields if ACF is available.
	 */
	protected function __construct() {
    if ( ! function_exists( 'get_field' ) ) {
      // ACF isn't active!
      return;
		}

		// Adds the main Global Options settings page.
		add_action( 'acf/init', [ $this, 'register_global_options_pages' ] );

		// Add useful sub pages.
		$this->add_sub_page( 'General' );
		$this->add_sub_page( 'Header' );
		$this->add_sub_page( 'Footer' );
		$this->add_sub_page( 'Social' );
		$this->add_sub_page( '404' );
		$this->add_sub_page( 'Search' );

		// Localise data from the Civic global options so they can be inserted into the JS.
		add_filter( 'luna_localize_script', [ $this, 'fetch_and_localise_civic_data' ] );

		// Add any custom header scripts.

		// Add any custom body scripts.

		// Add any custom footer scripts.

		/**
		 * @todo the above hooks.
		 * @todo integrate GMaps API key
		 * @todo intgerate CIvic bits
		 */
	}

	/**
	 * Add a new sub-page to the list of sub-pages to register.
	 *
	 * @see self::register_global_options_pages()
	 *
	 * @param string $title The sub page title as a human-readable string.
	 */
	protected function add_sub_page( $title ) {
		$this->sub_pages[] = $title;
	}

  /**
	 * 'acf/init' action hook callback.
	 * Initialise the Global Options settings page and any sub-pages.
	 */
	public function register_global_options_pages() {
		// Register Global Options area and menu item.
		$this->page_settings = acf_add_options_page(
			[
				'page_title' => 'Global Options',
				'post_id'    => 'global_options',
				'capability' => 'manage_options',
				'position'   => 60,
			]
		);

		// Register each declared sub-page.
		foreach ( $this->sub_pages as $sub_page_title ) {
			$sub_page_slug = sanitize_title( $sub_page_title );

			// Prevent the a sub-page with the same slug being registered twice.
			if ( isset( $this->sub_page_settings[ $sub_page_slug ] ) ) {
				trigger_error(
					'A Global Options sub-page has already been registered for <strong>' . esc_html( $title ) . '</strong>',
					E_USER_NOTICE
				);

				continue;
			}

			// Register Global Options sub-page and sub-menu item.s
			$this->sub_page_settings[ $sub_page_slug ] = acf_add_options_sub_page(
				[
					'page_title'  => $sub_page_title,
					'post_id'     => $sub_page_slug . '_options',
					'capability'  => 'manage_options',
					'parent_slug' => 'acf-options-global-options',
				]
			);
		}

		// Remove the sub pages list property as it is no longer needed.
		unset( $this->sub_pages );
	}

	/**
	 * 'luna_localize_script' action hook callback.
	 * Fetch custom Civic Cookie data from Global Options, including:
	 * @var string $license_key
	 * @var string $product ('COMMUNITY', 'PRO' or 'PRO_MULTISITE')
	 * @var array $cookies_info (group field)
	 *   @var string 'label'
	 *   @var array 'cookies' (e.g. '_ga')
	 *   @var string 'code'
	 *
	 * @param array $data The default localised theme data.
	 * @return array $data Updated localised data.
	 */
	public function fetch_and_localise_civic_data( $data ) {
		if ( ! function_exists( 'get_field' ) ) {
      // ACF isn't active!
      return;
		}

		$license_key = get_field( 'civic_license_key', 'general_options' );
		if ( ! $license_key ) {
			// Do not append anything if not license key has been entered.
			return $data;
		}

		// Create a Civic array that will be localised for use in JS.
		$civic = [
			'licenseKey'      => $license_key,
			'productType'     => get_field( 'civic_product_type', 'general_options' ),
			'googleAnalytics' => get_field( 'google_analytics_id', 'general_options' ),
		];

		/**
		 * @todo
		 * - privacy policy description
		 * - privacy policy link
		 * - privacy policy link text
		 * - update date (how can we get this?)
		 * - marketing cookies description
		 * - text bits
		 */

		// Add the new Civic object and return it.
		$data['civic'] = $civic;
		return $data;
	}
}
