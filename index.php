<?php
/**
 * index.php template.
 * This is the default template and is required in every theme.
 * However, it should not be possible for any type of page to fallback to this.
 * Templates should exists for all page types (as they do in the Luna boilerplate).
 *
 * N.B. For the Blog (default post type) archive page please use the home.php template.
 *
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package luna
 */

global $wp;

// Log a warning and redirect to Homepage if this template is used.
error_log(
	'WARNING: index.php template used for the following page: ' . home_url( $wp->request )
);
wp_safe_redirect( home_url(), 302 );
exit;

