<?php
/**
 * Luna Base Utilities.
 *
 * Contains a number of useful theme utility functions required for most projects.
 *
 * @package luna
 * @subpackage luna-base
 */

/**
 * Luna Base Utils class.
 * No __construct() here as this class should just contains public utility methods.
 * All methods are alphabetised.
 */
abstract class Luna_Base_Utils {
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
	 * Get a list of taxonomy terms for a post and return just the 'primary' term.
	 * 'Primary' category/taxonomy terms are a feature of Yoast, not built in to the core.
	 *
	 * @see https://stackoverflow.com/questions/43114986
	 *      /get-primary-category-if-more-than-one-is-selected/43259774
	 *
	 * @param int    $post_id ID of the post we need the primary term for.
	 * @param string $taxonomy Slug of the taxonomy of the primary term.
	 * @return object $term A WP_Term object of the primary term.
	 */
	public function get_the_primary_term( $post_id, $taxonomy ) {
		$terms           = get_the_terms( $post_id, $taxonomy );
		$primary_term_id = get_post_meta( $post_id, '_yoast_wpseo_primary_' . $taxonomy, true );

		// set a default value if there is no matching primary term.
		$primary_term = ( count( $terms ) > 0 ) ? $terms[0] : false;

			if ( is_array( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( $term->term_id == $primary_term_id ) {
						$primary_term = $term;
						break;
					}
				}
			}

		return $primary_term;
	}

	/**
	 * Get YouTube ID from URL.
	 *
	 * @param string $url video url.
	 */
	public function get_youtube_id( $url ) {		
		$pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

		// Checks if it matches a pattern and returns the value
		if ( preg_match( $pattern, $url, $match ) ) {
			return $match[1];
		}
		
		// if no match return false.
		return false;
	}

	/**
	 * Check to see if youtube video.
	 *
	 * @param  string $url video link.
	 * @return boolean
	 */
	public function is_youtube_url( $url ) {
		return (bool) preg_match( '#^https?://(?:www\.)?youtube.com#', $url );
	}

	/**
	 * Strips slashes and http:// or https:// from a url.
	 *
	 * @param strong $url url we want to strip
	 */
	public function remove_http( $url ) {
		$disallowed = [ 'http://', 'https://' ];
		foreach( $disallowed as $d ) {
			if ( strpos( $url, $d ) === 0 ) {
				return str_replace( $d, '', $url );
			}
		}
		return $url;
	}

	/**
	 * Displays a summary of the searched query.
	 *
	 * @param string $template output template.
	 */
	public function search_query_summary( $template = 'Showing %1$s - %2$s of %3$s' ) {
		global $wp_query;

		$query = $wp_query->query_vars;
		$terms = implode( ', ', $query['search_terms'] );
		$page  = array_key_exists( 'paged', $query ) && $query['paged'] ? $query['paged'] : 1;

		$page_total = (
			$query['posts_per_page'] < $wp_query->found_posts
			? $query['posts_per_page']
			: $wp_query->found_posts
		);

		$current = ( $page - 1 ) * $page_total + 1;
		$total   = $wp_query->found_posts;
		if ( ( $page_total * $page ) < $wp_query->found_posts ) {
			$total = ( $page_total * $page );
		}

		if ( $wp_query->found_posts === 0 ) {
			$template = 'Showing %3$s for "%4$s"';
		}

		echo '<div class="search-results__count">';
		echo sprintf( $template, $current, $total, $wp_query->found_posts, $terms ); // phpcs:ignore
		echo '</div>';
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
}
