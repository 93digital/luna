<?php
/**
 * home.php template.
 * The default template for the Blog (default post type) archive.
 * Please do not use index.php for this.
 *
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package luna
 */

get_header();
?>

<h1><?php esc_html_e( 'Blog', 'luna' ); ?></h1>

<?php
if ( have_posts() ) :
  while ( have_posts() ) : the_post();
		?>
		<a href="<?php the_permalink(); ?>"><?php the_title( '<h2>', '</h2>' ); ?></a>
		<?php the_excerpt(); ?>
		<a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'luna' ); ?></a>
		<hr />
		<?php
	endwhile;
endif;

get_footer();
