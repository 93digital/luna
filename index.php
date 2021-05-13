<?php
if ( ! defined( 'ABSPATH' ) ) {
	// Oi, no peeking!
  exit;
}

get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();
		the_title();
		the_content();
		?>

		<?php
	endwhile;
endif;

get_footer();
