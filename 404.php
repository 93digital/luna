<?php
/**
 * 404.php template.
 * The default template for displaying 404 pages (not found).
 *
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package luna
 */

get_header();
?>

<h1><?php esc_html_e( '404: Page not found.', 'luna' ); ?></h1>

<?php get_footer();
