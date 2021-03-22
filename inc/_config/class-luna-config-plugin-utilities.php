<?php
/**
 * Luna config plugin utilities class.
 * Uses plugin hooks to alter/update/extend some aspects of our most used plugins.
 *
 * Plugins include:
 * - ACF
 * - Gravity Forms
 * - Yoast
 *
 * @package luna
 * @subpackage luna-config
 */

/**
 * Plugin utilities class.
 */
class Luna_Config_Plugin_Utilities {
	/**
	 * ACF Pro path.
	 * @var string
	 */
	private $acf_pro_path = 'advanced-custom-fields-pro/acf.php';

	/**
	 * ACF path (the free one).
	 * @var string
	 */
	private $acf_path = 'advanced-custom-fields/acf.php';

	/**
	 * Define plugin hooks on instantiation.
	 */
	public function __construct() {
		/**
		 * ACF hooks.
		 */
		// Remove the 'disable' plugin link for ACF and ACF Pro.
		add_filter( 'plugin_action_links_' . $this->acf_path, [ $this, 'acf_remove_disable_link' ], 0, 1 );
		add_filter( 'plugin_action_links_' . $this->acf_pro_path, [ $this, 'acf_remove_disable_link' ], 0, 1 );

		// Display a warning message if either version of ACF is deactivated!
		add_action( 'admin_notices', [ $this, 'acf_deactivated_warning' ], 0 );

		// Add a custom save location for ACF Local JSON files.
		add_filter( 'acf/settings/save_json', [ $this, 'acf_json_save_location' ] );

		// Add a custom load location for ACF Local JSON files.
		add_filter( 'acf/settings/load_json', [ $this, 'acf_json_load_location' ] );

		// Add a dropdown list of Gravity Forms for ACF fields named 'gravity_form'
		add_filter( 'acf/load_field/name=gravity_form', [ $this, 'acf_gravity_forms_dropdown' ] );

		/**
		 * Gravity Forms hooks.
		 */
		// Add custom classes to some Gravity Form inputs.
		add_filter( 'gform_field_css_class', [ $this, 'gravity_forms_custom_input_classes' ], 10, 3 );

		// Remove the default ugly Gravity Forms spinner.
		add_filter( 'gform_ajax_spinner_url', 'gravity_forms_replace_spinner', 10, 2 );

		// Disable tabindex on all Gravity Forms.
		add_filter( 'gform_tabindex', '__return_false' );

		/**
		 * Yoast hooks.
		 */
		// Move the Yoast SEO metabox to the bottom of post.php admin pages.
		add_filter( 'wpseo_metabox_prio', [ $this, 'yoast_metabox_priority' ] );

		// Remove Yoast coluns from all edit.php admin pages.
		add_filter( 'manage_edit-post_columns', [ $this, 'yoast_remove_columns' ], 99 );
		add_filter( 'manage_edit-page_columns', [ $this, 'yoast_remove_columns' ], 99 );
	}

	/**
	 * 'plugin_action_links_$plugin_path' filter hook callback.
	 * Removes the 'deactivate' link from the ACF and ACF Pro plugin as the theme relies on ACF.
	 *
	 * @param array $actions A list of the available action links for the plugin.
	 * @return array $actions The updated actions list with the 'deativate' link removed.
	 */
	public function acf_remove_disable_link( $actions ) {
		if ( ! isset( $actions['deactivate'] ) ) {
			// Do nothing if no deactivate is present.
			return $actions;
		}

		unset( $actions['deactivate'] );
    return $actions;
	}

	/**
	 * 'admin_notices' action hook callback.
	 * Display a high priority warning admin notice warning if ACF or ACF Pro is not installed.
	 */
	public function acf_deactivated_warning() {
		if ( is_plugin_active( $this->acf_path ) || is_plugin_active( $this->acf_pro_path ) ) {
			// ACF is active so warning is not needed.
			return;
		}

		// Populates a list of all active and inactive plugins.
		$all_plugins = get_plugins();

		ob_start();
		?>
		<div class="notice notice-error">
			<p>
				<strong><?php esc_html_e( 'WARNING!', 'luna' ); ?></strong>
			</p>
			<p>
				<?php esc_html_e( 'Advanced Custom Fields is not active', 'luna' ); ?>.<br />
				<?php esc_html_e( 'It is required for the site to function properly', 'luna' ); ?>.
			</p>
			<p>
				<?php
				if (
					array_key_exists( $this->acf_path, $all_plugins ) ||
					array_key_exists( $this->acf_pro_path, $all_plugins )
				) :
					// One of the ACF plugins is installed and inactive so output a link to the Plugins page. 
					?>
					<a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>">
						<strong><?php esc_html_e( 'Please activate ACF or ACF Pro via this link', 'luna' ); ?></strong>
					</a>
					<?php
				else :
					// ACF needs to be downloaded and installed so create a plugin search link.
					?>
					<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=advanced%20custom%20fields&tab=search&type=term' ) ); ?>">
						<strong><?php echo esc_html_e( 'Please download ACF from this page', 'luna' ); ?></strong><br />
					</a>
					<?php echo esc_html_e( 'Or contact a developer for further assistance', 'luna' ); ?>.
					<?php
				endif;
				?>
			</p>
		</div>
		<?php
		ob_get_flush();
	}

	/**
	 * 'acf/settings/save_json' filter hook callback.
	 * ACF Local JSON.
	 * Set a custom save location for all Local JSON fields.
	 *
	 * @see https://www.advancedcustomfields.com/resources/local-json/
	 *
	 * @param string $path The default Local JSON save path.
	 * @return string The custom Local JSON path for the theme.
	 */
	public function acf_json_save_location( $path ) {
		return get_template_directory() . '/inc/_cache/acf';
	}

	/**
	 * 'acf/settings/load_json' filter hook callback.
	 * ACF Local JSON.
	 * Add a custom load location for Local JSON fields.
	 *
	 * @see https://www.advancedcustomfields.com/resources/local-json/
	 *
	 * @param array $paths The default Local JSON load paths.
	 * @return string Updated list of load paths including custom theme path.
	 */
	public function acf_json_load_location( $paths ) {
		$paths[] = get_template_directory() . '/inc/_cache/acf';

		return $paths;
	}

	/**
	 * 'acf/load_field/name=gravity_form' filter hook callback
	 * Dynamically populate the ACF select fields named "gravity_form"
	 * with all the available Gravity Forms on the site.
	 *
	 * @see https://www.advancedcustomfields.com/resources/acf-load_field/
	 *
	 * @param array $field The ACF field array (contains the field setting).
	 * @return array $field The updated ACF field array.
	 */
	public function acf_gravity_forms_dropdown( $field ) {
		if ( ! class_exists( 'GFAPI' ) ) {
			// No Gravity Form API class available. The plugin probably isn't active.
			return $field;
		}

		$forms = GFAPI::get_forms( true );
		foreach ( $forms as $form ) {
			$field['choices'][ $form['id'] ] = apply_filters( 'the_title', $form['title'] );
		}

		return $field;
	}

	/**
	 * 'gform_field_css_class' filter hook callback.
	 * Add unique classes to GF field containers.
	 *
	 * @param string $classes Default field classes.
	 * @param object $field Default field object.
	 * @param object $form Form object.
	 * @return string $classes Updated field classes
	 */
	public function gravity_forms_custom_input_classes( $classes, $field, $form ) {
		if ( $field->type === 'select' ) {
			$classes .= ' gfield_select';
		}
		if ( $field->type === 'checkbox' ) {
			$classes .= ' gfield_checkbox';
		}
		if ( $field->type === 'radio' ) {
			$classes .= ' gfield_radio';
		}

		return $classes;
	}

	/**
	 * 'gform_ajax_spinner_url' filter hook callback.
	 * Replace the horrible pixelated GF spinner with a transparent image.
	 * The spinner element is then styled and animated.
	 *
	 * @param string $image_src The default spinner image URL.
	 * @param array  $form A Gravity Froms form array.
	 * @return string A 1px by 1px transparent PNG!
	 */
	public function gravity_forms_replace_spinner( $image_src, $form ) {
		return trailingslashit( get_template_directory_uri() ) . 'assets/images/pixel.png';
	}

	/**
	 * 'wpseo_metabox_prio' filter hook callback.
	 * WP SEO (Yoast) has a warped sense of self importance and gives its metaboxes high priority!
	 * This moves towards the bottom, below any custom meta boxes that may have been added.
	 *
	 * @return string An updated metabox priority.
	 */
	public function yoast_metabox_priority() {
		return 'low';
	}

	/**
	 * 'manage_edit-post_columns' filter hook callback.
	 * 'manage_edit-page_columns' filter hook callback.
	 * Yoast adds loads of bulky, uneeded columns to edit.php pages in the admin area!
	 * These look ugly and clutter the page, especially when custom columns are added.
	 * This function removes all the Yoast columns.
	 *
	 * @param array $columns Defualt list of post columns.
	 * @return array $columns Updated list of post
	 */
	public function yoast_remove_columns( $columns ) {
		// Silly Yoast with all its silly columns.
		unset( $columns['wpseo-score'] );
		unset( $columns['wpseo-score-readability'] );
		unset( $columns['wpseo-title'] );
		unset( $columns['wpseo-metadesc'] );
		unset( $columns['wpseo-focuskw'] );
		unset( $columns['wpseo-links'] );
		unset( $columns['wpseo-linked'] );

		return $columns;
	}
}
