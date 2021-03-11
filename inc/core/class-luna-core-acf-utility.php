<?php
/**
 * Luna core ACF utility class.
 * The theme relies on ACF to provide blocks, custom fields and option pages.
 * This class adds some custom utility functionality to improve ACF and keep it running smoothly.
 * 
 * @package luna
 * @subpackage luna-core
 */

/**
 * ACF utility class.
 * Ensures ACF is kept up and running.
 */
class Luna_Core_Acf_Utility {
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
	 * Instantiation.
	 * Define utility hooks.
	 */
	public function __construct() {
		// Remove the 'disable' plugin link for ACF and ACF Pro.
		add_filter( 'plugin_action_links_' . $this->acf_path, [ $this, 'remove_acf_disable_link' ], 0, 1 );
		add_filter( 'plugin_action_links_' . $this->acf_pro_path, [ $this, 'remove_acf_disable_link' ], 0, 1 );

		// Display a warning message if either version of ACF is deactivated!
		add_action( 'admin_notices', [ $this, 'acf_deactivated_warning' ], 0 );
	}

	/**
	 * 'plugin_action_links_$plugin_path' filter hook callback.
	 * Removes the 'deactivate' link from the ACF and ACF Pro plugin.
	 *
	 * @param array $actions A list of the available action links for the plugin.
	 * @return array $actions The updated actions list with the 'deativate' link removed.
	 */
	public function remove_acf_disable_link( $actions ) {
		if ( ! isset( $actions['deactivate'] ) ) {
			// Do nothing if no deactivate is present.
			return $actions;
		}

		unset( $actions['deactivate'] );
    return $actions;
	}

	/**
	 * 'admin_notices' action hook callback.
	 * 
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
}
