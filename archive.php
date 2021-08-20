<?php
/**
 * archive.php template.
 * The default template for custom post type archives.
 *
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package luna
 */

get_header();

$object = get_queried_object();
$label  = property_exists( $object, 'label' ) ? $object->label : $object->name;
?>

<h1><?php echo esc_html( $label ); ?></h1>

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
