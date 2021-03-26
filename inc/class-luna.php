<?php
/**
 * Luna.
 * The main theme object class.
 *
 * Extends the base setup class which contains core theme functionality.
 * All utility functionality should be added as methods to this class.
 *
 * @package luna
 */

/**
 * Luna class.
 */
final class Luna extends Luna_Base {
	/**
	 * A Luna_Cpts object.
	 * @var object
	 */
	public $cpts;

	/**
	 * A Luna_Global_Options object.
	 * @var object
	 */
	public $global_options;

	/**
	 * Construct.
	 * This should only be used to call the parent's construct
	 * and instantiate any custom classes as part of the main luna object.
	 */
	public function __construct() {
		// Base theme setup.
		parent::__construct();

		require get_template_directory() . '/inc/gutenberg/gutenberg.php';

		/**
		 * Instantiate sub classes.
		 */
		$this->cpts           = new Luna_Cpts();
		$this->global_options = new Luna_Global_Options();
	}

	/**
	 * Truncate text to a certian character length.
	 *
	 * @param string $string The string to truncate (if required).
	 * @param int    $length The character length of the truncated string.
	 *
	 * @return string $string Truncated string.
	 */
	public function truncate_text( $string, $length = 100 ) {
		if ( \strlen( $string ) > $length ) {
			$string = \substr( $string, 0, $length ) . '...';
		}

		return $string;
	}

	/**
	 * Create human readable string out of a filename.
	 * Removes the filepath (if any), file extension (if any)
	 * and replaces '-' and '_' with spaces.
	 *
	 * @param string $filepath The filename to parse.
	 * @return string $text Human readbale string.
	 */
	public function filename2text( $filepath ) {
		$filepath_parts = explode( '/', $filepath );
		$filename       = explode( '.', end( $filepath_parts ) )[0];
		$text           = ucfirst( strtolower( str_replace( [ '_', '-' ], ' ', $filename ) ) );

		return $text;
	}

	/**
	 * Removes all URL parameters from a string.
	 *
	 * @param string $url URL to remove parameters from.
	 * @return string $url URL with parameters removed.
	 */
	public function strip_url_parameters( string &$url ) {
		// order of elements here is important, we want to check for a ? first.
		$str_pos = [
			'question-mark' => strpos( $url, '?' ),
			'ampersand'     => strpos( $url, '&' ),
		];

		// remove the URL parameters (if any are present in the URL string).
		foreach ( $str_pos as $pos ) {
			if ( $pos !== false ) {
				$url = substr( $url, 0, $pos );
				break;
			}
		}

		return $url;
	}
}
