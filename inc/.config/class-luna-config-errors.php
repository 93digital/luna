<?php
/**
 * Luna error handler.
 *
 * A class to set custom error handlers for within the theme and any 93digital plugins.
 * These error handlers will only be used in development environments.
 *
 * @package luna
 * @subpackage luna-config
 */

/**
 * Luna error class.
 * 
 * Only handles errors defined in the $non_fatal_error_types & $fatal_error_types properties.
 * Also only handles errors for Luna or 93digital plugin code.
 *
 * @see https://www.php.net/manual/en/errorfunc.constants.php
 */
class Luna_Config_Errors {
	/**
	 * The array contains the non-fatal error types we want to handle.
	 * Error constant (int) and error types 'key' => 'value' pair.
	 * @var array
	 */
	private $non_fatal_error_types = [
		E_WARNING      => 'Warning',
		E_NOTICE       => 'Notice',
		E_USER_WARNING => 'Warning',
		E_USER_NOTICE  => 'Notice',
	];

	/**
	 * The array contains the fatal error types we want to handle.
	 * Error constant (int) and error types 'key' => 'value' pair.
	 * @var array
	 */
	private $fatal_error_types = [
		E_ERROR      => 'Fatal error',
		E_PARSE      => 'Parse error',
		E_USER_ERROR => 'Fatal error',
	];

	/**
	 * Error base colours.
	 * The keys for these colours match an error type.
	 * These colours will be used when outputting the custom error.
	 *
	 * Exception handlers (for fatal errors) always return code 0, so set red for this.
	 * @var array
	 */
	private $error_colours = [
		E_ERROR        => '#cc0000',
		E_WARNING      => '#eeaa00',
		E_PARSE        => '#cc0000',
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
		// Handles non-fatal errors (notices, warnings etc.).
		set_error_handler( [ $this, 'error_handler' ] );

		// Displays the custom error message on fatal errors.
		register_shutdown_function( [ $this, 'shutdown_handler' ] );
	}

	/**
	 * 'register_shutdown_function()' callback.
	 * Output a custom message for fatal errors.
	 */
	public function shutdown_handler() {
		/**
		 * @var array
		 * @param int    'type' The error type number.
		 * @param string 'message' The error message.
		 * @param string 'file' The file where the error occurred.
		 * @param string 'line' The line which the error occurred on.
		 */
		$error = error_get_last();
		if ( ! is_array( $error ) || ( is_array( $error ) && ! $this->is_nine3_error( $error['file'] ) ) ) {
			// Catch only the errors in the theme or a nine3 plugin.
			return;
		}

		if (
			! ( error_reporting() & $error['type'] ) ||
			! array_key_exists( $error['type'], $this->fatal_error_types )
		) {
			// Error code is not included in error_reporting or the custom handler's error types.
			return false;
		}

		$error_type = $this->fatal_error_types[ $error['type'] ];

		// Log the error in the debug log.
		$this->log_error( $error_type, $error['message'], $error['file'], $error['line'] );

		if ( wp_doing_ajax() || ! defined( 'LUNA_DEBUG' ) || ! LUNA_DEBUG ) {
			// Use the default error handler if an ajax request or not in a dev environment.
			return;
		}

		// Display the error and exit.
		$this->display_error( $error_type, $error['message'], $error['file'], $error['line'], $error['type'] );
	}
	
	/**
	 * 'set_error_handler()' callback.
	 * Add a custom error handler and output for non-fatal errors
	 *
	 * @param int    $error_num The error type number.
	 * @param string $error_string The error message.
	 * @param string $error_file The file where the error occurred.
	 * @param string $error_line The line which the error occurred on.
	 * @return bool False will be returned if the custom handler criteria is not met,
	 *              this then causes PHP to fall back to the default error handler.
	 */
	public function error_handler( $error_num, $error_string, $error_file, $error_line ) {
		if ( ! $this->is_nine3_error( $error_file )	) {
			// Catch only the errors in the theme or a nine3 plugin.
			return false;
		}

		if (
			! ( error_reporting() & $error_num ) ||
			! array_key_exists( $error_num, $this->non_fatal_error_types )
		) {
			// Error code is not included in error_reporting or the custom handler's error types.
			return false;
		}

		$error_type = $this->non_fatal_error_types[ $error_num ];

		// Log the error in the debug log.
		$this->log_error( $error_type, $error_string, $error_file, $error_line );

		if ( wp_doing_ajax() || ! defined( 'LUNA_DEBUG' ) || ! LUNA_DEBUG ) {
			// Use the default error handler if an ajax request or not in a dev environment.
			return false;
		}

		// Display the error and exit.
		$this->display_error( $error_type, $error_string, $error_file, $error_line, $error_num, true );
	}

	/**
	 * Add an error to the error log file.
	 * This should be wp-content/debug.log in a WordPress installation.
	 *
	 * @param string $error_type The error type (already converted from the error number).
	 * @param string $error_string The error message.
	 * @param string $error_file The error file path
	 * @param string $error_line The line in the file where the error occurred.
	 */
	private function log_error( $error_type, $error_line, $error_file, $error_string ) {
		error_log(
			print_r(
				"{$error_type}: #{$error_line} in {$error_file}: {$error_string}",
				true
			)
		);
	}

	/**
	 * Output a custom error message and exit (optional).
	 *
	 * @param string $error_type The error type (already converted from the error number).
	 * @param string $error_string The error message.
	 * @param string $error_file The error file path
	 * @param string $error_line The line in the file where the error occurred.
	 * @param int    $error_num  The error types constant value.  
	 * @param bool   $exit Whether or not to halt the script following the output.
	 */
	private function display_error(
		$error_type, $error_string, $error_file, $error_line, $error_num, $exit = false
	) {
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
			'font-size'   => '1.5rem',
			'line-height' => '1.3',
			'transform'   => 'translateY(-50%)',
			'max-height'  => '90%',
    	'overflow'    => 'auto',
		];

		$image_styles = [
			'position'   => 'absolute',
			'top'        => '0',
			'left'       => '50%',
			'max-width'  => '500px',
			'max-height' => '300px',
			'transform'  => 'translateX(-50%)'
		];

		$image_file = 'error';
		if ( $error_type === 'Warning' ) {
			$image_file = 'warning';
		} elseif ( $error_type === 'Notice' ) {
			$image_file = 'notice';
		}

		// Output the error.
		ob_start();
		?>
		<div style="<?php echo esc_attr( $this->array_to_css( $wrapper_styles ) ); ?>">
			<div style="<?php echo esc_attr( $this->array_to_css( $background_styles ) ); ?>"></div>
			<img
				src="<?php echo esc_attr( get_template_directory_uri() . '/assets/images/' . $image_file . '.gif' ); ?>"
				style="<?php echo esc_attr( $this->array_to_css( $image_styles ) ); ?>" />
			<div style="<?php echo esc_attr( $this->array_to_css( $message_styles ) ); ?>">
				<?php echo esc_html( $error_type ); ?>:
				<strong><?php echo nl2br( esc_html( $error_string ) ); ?></strong><br /><br />
				in <strong><?php echo esc_html( $error_file ); ?></strong> on line 
				<strong><?php echo esc_html( $error_line ); ?></strong>
			</div>
		</div>
		<?php
		ob_get_flush();

		if ( $exit ) {
			exit;
		}
	}

	/**
	 * Checks if the passed file should be handled as a nine3 error.
	 *
	 * @param string $error_file Filepath of the file where an error occured.
	 * @return bool Whether the file should be handled by the class.
	 */
	private function is_nine3_error( $error_file ) {
		return (
			stripos( $error_file, get_template_directory() ) !== false ||
			stripos( $error_file, WP_PLUGIN_DIR . '/nine3-' ) !== false
		);
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
