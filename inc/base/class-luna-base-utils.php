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
	 * @param string $filepath The filename to convert.
	 * @return string $text Human readable string.
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
		$primary_term = ( is_array( $terms ) && count( $terms ) > 0 ) ? $terms[0] : false;

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
	 * @return string|bool Either a YouTube ID on success or false on failure.
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
	 * Return optimised image markup.
	 * This works in tandem with the npm LazyLoad image package which is integrated into the theme.
	 *
	 * @param int|string  $id_or_url The attachment ID or file URL for the image.
	 * @param string      $size The image size (defaults to 'large').
	 * @param string|bool $size_retina Optional image size (defaults to false).
	 * @param string      $css_class CSS class names for the <img> tag.
	 * @param bool        $echo Whether to echo the resulting <img> tag.
	 * @return string $image_elem The image element markup.
	 */
	public function image( $id_or_url, $size = 'large', $size_retina = false, $class = '', $echo = true ) {
		$atts = [];

		// Determine if and ID or URL has been passed.
		$url = is_int( $id_or_url ) ? wp_get_attachment_image_url( $id_or_url, $size ) : $id_or_url;
		if ( is_admin() ) {
			$atts['src'] = esc_url( $url );
		} else {
			$atts['data-src'] = esc_url( $url );
		}

		// Set the srcset if required.
		if ( $size_retina && is_int( $id_or_url ) ) {
			$url_retina          = wp_get_attachment_image_url( $id_or_url, $size_retina );
			$atts['data-srcset'] = $url . ' 1x, ' . $url_retina . ' 2x';
		}

		// Add other required image attributes.
		$atts['class'] = $class . ' lazy';
		$atts['alt']   = is_int( $id_or_url )
			? get_post_meta( $id_or_url, '_wp_attachment_image_alt', true )
			: '';
		
		// Create the image element and either return or echo it.
		$image_elem = '<img ' . $this->parse_atts_array( $atts ) . ' />';

		// Echo and return.
		if ( $echo ) {
			echo $image_elem; // phpcs:ignore
		}
		return $image_elem;
	}

	/**
	 * Check to see if youtube video.
	 *
	 * @param  string $url A URL to check.
	 * @return boolean Whether the URL is from YouTube.
	 */
	public function is_youtube_url( $url ) {
		return (bool) preg_match( '#^https?://(?:www\.)?youtube.com#', $url );
	}

	/**
	 * Pagination function for archive pages.
	 *
	 * @param bool $show_ends Whether to show links to the first and last page (where applicable).
	 */
	public function pagination( $show_ends = true ) {
		global $wp_query, $wp;
	
		$total_pages = $wp_query->max_num_pages;
		if ( $total_pages < 2 ) {
			return;
		}
	
		$current_page = max( 1, get_query_var( 'paged' ) );
	
		// Get any custom $_GET params from the url, these will be appended to page links further down.
		$custom_params = count( $_GET ) > 0 ? '?' . http_build_query( $_GET ) : '';
	
		// get the base url of the current archive/taxonomy/whatever page without any pagination queries.
		$base_url = explode( '?', get_pagenum_link( 1 ) )[0];
	
		// current category / taxonomy / archive url for first link.
		$first_page = $base_url . $custom_params;
		$last_page  = $base_url . 'page/' . $total_pages . $custom_params;
	
		$args = [
			'base'      => $base_url . '%_%' . $custom_params,
			'format'    => 'page/%#%',
			'current'   => $current_page,
			'total'     => $total_pages,
			'prev_text' => '<span class="nav-inline-dash">&lsaquo;</span>',
			'next_text' => '<span class="nav-inline-dash">&rsaquo;</span>',
		];

		get_template_part(
			'template-parts/pagination.php',
			[
				'args'         => $args,
				'show_ends'    => $show_ends,
				'current_page' => $current_page,
				'total_pages'  => $total_pages,
				'first_page'   => $first_page,
				'last_page'    => $last_page,
			]
		);
	}

	/**
	 * Parse an associative array into a HTML attributes string.
	 * @example $key="$value"
	 *
	 * @param array $atts An $att => $val key value pair associative array.
	 * @return array A string of HTML attributes.
	 */
	public function parse_atts_array( $atts ) {
		return implode( ' ',
			array_map(
				function( $att, $val ) {
					return $att . '="' . esc_attr( $val ) . '"';
				},
				array_keys( $atts ),
				$atts
			)
		);
	}

	/**
	 * Strips slashes and http:// or https:// from a url.
	 *
	 * @param string $url URL we want to strip.
	 * @return string $url A http stripped URL.
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
	 * Echo a summary of the searched query.
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
	public function strip_url_parameters( $url ) {
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
	 * Return an SVG as markup for an SVG placed in /assets/svg.
	 *
	 * @param string $icon The icon filename (without the file extension).
	 * @param string $title An optional SVG title.
	 * @param string $description An optional SVG description.
	 * @param bool   $echo Whether to echo the resulting SVG markup.
	 * @return string SVG markup.
	 */
	public function svg( $icon, $title = '', $description = '', $echo = true ) {
		// Set default atts.
		$atts = [
			'aria-hidden' => 'true',
			'class'       => 'svg-icon svg-icon--' . $icon,
			'role'        => 'img'
		];

		// Update the aria attributes if a title has been set.
		if ( $title ) {
			$unique_id = uniqid();
			unset( $atts['aria-hidden'] );
			$atts['aria-labelledby'] = 'title-' . $unique_id;

			// Update aria-labelledby if description has been set.
			if ( $description ) {
				$atts['aria-labelledby'] .= ' desc-' . $unique_id;
			}
		}

		// Parse the SVG atts into a string.
		$markup = '<svg ' . $this->parse_atts_array( $atts ) . '>';

		// Add title tag.
		if ( $title ) {
			$markup .= '<title id="title-' . $unique_id . '">' . esc_html__( $title, 'luna' ) . '</title>';

			// Add description tag.
			if ( $description ) {
				$markup .= '<desc id="desc-' . $unique_id . '">' . esc_html__( $description, 'luna' ) . '</desc>';
			}
		}

		/**
		 * Add use tag and the closing SVG tag.
		 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
		 *
		 * @see https://core.trac.wordpress.org/ticket/38387.
		 */
		$markup .= ' <use href="#' . esc_html( $icon ) . '" xlink:href="#' . esc_html( $icon ) . '"></use> ';
		$markup .= '</svg>';

		// Echo and return.
		if ( $echo ) {
			echo $markup; // phpcs:ignore
		}
		return $markup;
	}

  /**
	 * Truncate text to a certain character length.
	 *
	 * @param string $string The string to truncate.
	 * @param int    $length The character length of the truncated string.
	 * @return string $string Truncated string.
	 */
	public function truncate_text( $string, $length = 100 ) {
		if ( \strlen( $string ) > $length ) {
			$string = \substr( $string, 0, $length ) . '...';
		}

		return $string;
	}
}
