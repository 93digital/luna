<?php
/**
 * Luna.
 * The main theme object class.
 *
 * Extends the core setup class which contains base theme functionality required for all sites.
 * ...All general project code goes here (similar to extras.php).
 *
 * @package luna
 *
 * @todo disable unused areas of the CMS (widget etc).
 * @todo svg icons
 * @todo custom caching utility
 * @todo fallback for get_field()
 * @todo gmap stuff?
 * @todo gutenberg stuff?
 * @todo count instantiations
 */

/**
 * Luna class.
 */
final class Luna extends Luna_Core {
	/**
	 * Construct.
	 */
	public function __construct() {
		// Core setup.
		parent::__construct();

		// General theme setup.
		
		// 1. Enqueues
		// 2. Hooks
		// 3. Shortcodes
		// 4. Utility functions
		//   a. Front end
		//   b. Back end
		// 5. Gutenberg?
		// 6. ACF?
		// 7. Post Types & Taxonomies
		// 8. Global Options
		// 9. Custom caching functionality
	}
}
