<?php
/**
 * singular.php template.
 * The default template for all single posts and pages.
 * This template was introduced in WP 4.3.
 * It is the fallback for both page.php and single.php.
 *
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package luna
 */

get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();
		the_content();
	endwhile;
endif;

get_footer();
