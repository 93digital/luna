<?php
/**
 * Luna core error.
 *
 * A class to set custom error handlers for within the theme and any 93digital plugins.
 * These error handlers will only be used in development environments.
 *
 * @package luna
 * @subpackage luna-core
 */

/**
 * Luna core error class.
 */
class Luna_Core_Errors {
	/**
	 * Error number and error level key => value pair.
	 * The array contains the error levels we want to handle.
	 * @var array
	 */
	private $error_levels = [
		E_ERROR        => 'Error',
		E_WARNING      => 'Warning',
		E_NOTICE       => 'Notice',
		E_USER_ERROR   => 'Error',
		E_USER_WARNING => 'Warning',
		E_USER_NOTICE  => 'Notice',
	];

	/**
	 * Error colours.
	 * These colours will be used when outputting the custom error.
	 * @var array
	 */
	private $error_colours = [
		E_ERROR        => '#cc0000',
		E_WARNING      => '#eeaa00',
		E_NOTICE       => '#eeee00',
		E_USER_ERROR   => '#cc0000',
		E_USER_WARNING => '#eeaa00',
		E_USER_NOTICE  => '#eeee00',
	];

  /**
   * Instantiation.
   * Set the custom error handler. 
   */
  public function __construct() {
    set_error_handler( [ $this, 'error_handler' ] );
	}
	
	/**
	 * 'set_error_handler()' callback.
	 * Creates custom error handling and output for the error levels defined in the properties.
	 * Will only run for Luna or 93digital code.
	 *
	 * @param int    $error_num The error level number, each error level has a defined integer.
	 * @param string $error_string The error message.
	 * @param string $error_file   The file where the error occured.
	 * @param string $error_line   The line which the error occured on.
	 * @return bool False will be returned if the custom handler criteria is not met,
	 *              this then falls back to the default PHP handler for the error.
	 *
	 * @see https://www.php.net/manual/en/errorfunc.constants.php
	 */
	public function error_handler( $error_num, $error_string, $error_file, $error_line ) {
		if (
			stripos( $error_file, get_template_directory() ) === false &&
			stripos( $error_file, WP_PLUGIN_DIR . '/nine3-' ) === false
		) {
			// Catch only the errors in the theme or a nine3 plugin.
			return false;
		}

		if (
			! ( error_reporting() & $error_num ) ||
			! array_key_exists( $error_num, $this->error_levels )
		) {
			// Error code is not included in error_reporting or the custom handler levels.
			return false;
		}

		// Log the error in the debug log.
		error_log(
			print_r(
				"{$this->error_levels[ $error_num ]}: #{$error_line} in {$error_file}: {$error_string}",
				true
			)
		);

		if ( wp_doing_ajax() || ! defined( 'LUNA_DEBUG' ) || ! LUNA_DEBUG ) {
			// Use the default error handler if an ajax request or not in a dev environment.
			return false;
		}

		$wrapper_styles = [
			'position'   => 'fixed',
			'top'        => '0',
			'left'       => '0',
			'width'      => '100%',
			'height'     => '100%',
			'z-index'    => '9999999',
		];

		$background_styles = [
			'position'   => 'absolute',
			'width'      => '100%',
			'height'     => '100%',
			'background' => $this->error_colours[ $error_num ],
			'opacity'    => '0.5',
		];

		$message_styles = [
			'position'    => 'absolute',
			'top'         => '50%',
			'left'        => '2rem',
			'right'       => '2rem',
			'background'  => 'white',
			'border'      => '0.5rem solid ' . $this->error_colours[ $error_num ],
			'padding'     => '1rem',
			'font-family' => 'monospace',
			'font-size'   => '2rem',
			'line-height' => '1.3',
			'transform'   => 'translateY(-50%)',
		];

		// Output the error.
		ob_start();
		?>
		<div style="<?php echo esc_attr( $this->array_to_css( $wrapper_styles ) ); ?>">
			<div style="<?php echo esc_attr( $this->array_to_css( $background_styles ) ); ?>"></div>
			<div style="<?php echo esc_attr( $this->array_to_css( $message_styles ) ); ?>">
				<?php echo esc_html( $this->error_levels[ $error_num ] ); ?>: 
				<strong><?php echo esc_html( $error_string ); ?></strong> in 
				<strong><?php echo esc_html( $error_file ); ?> on line 
				<strong><?php echo esc_html( $error_line ); ?>
			</div>
		</div>
		<?php
		ob_get_flush();

		exit;
	}

	/**
	 * Utility function to convert an array to a CSS string.
	 *
	 * @param array $css_array CSS property and CSS value key => value pair.
	 * @return string $css_string A converted string of valid CSS.
	 */
	private function array_to_css( $css_array ) {
		$css_string = '';
		foreach ( $css_array as $prop => $value ) {
			$css_string .= "$prop:$value;";
		}

		return $css_string;
	}
}
