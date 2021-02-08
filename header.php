<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package stella
 */

$acf_installed = class_exists( 'ACF' );

/**
 *  Favicons
 */
$theme_color     = $acf_installed ? get_field( 'theme_color', 'global_options' ) : false;
$favicon_16      = $acf_installed ? wp_get_attachment_image_url( get_field( 'favicon_16', 'global_options' ), 'full' ) : false;
$favicon_32      = $acf_installed ? wp_get_attachment_image_url( get_field( 'favicon_32', 'global_options' ), 'full' ) : false;
$favicon_default = $acf_installed ? wp_get_attachment_image_url( get_field( 'favicon_default', 'global_options' ), 'full' ) : false;

/**
 * Accessibility options
 */
$focus_settings = $acf_installed ? get_field( 'focus_settings', 'global_options' ) : 'accessible';
$focus_class    = empty( $focus_settings ) ? 'remove-focus' : '';

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>


<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<link rel="profile" href="//gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php if ( $favicon_default ) { ?>
	<link rel="apple-touch-icon" href="<?php echo esc_url( $favicon_default ); ?>">
<?php } ?>
<?php if ( $favicon_32 ) { ?>
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( $favicon_32 ); ?>">
<?php } ?>
<?php if ( $favicon_16 ) { ?>
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( $favicon_16 ); ?>">
<?php } ?>
<?php if ( $theme_color ) : ?>
	<meta name="msapplication-TileColor" content="<?php echo esc_attr( $theme_color ); ?>">
	<meta name="theme-color" content="<?php echo esc_attr( $theme_color ); ?>">
<?php endif; ?>


<?php wp_head(); ?>
</head>

<body id="body" <?php body_class( $focus_class ); ?>>

  <a href="#main" class="skip-link"><?php esc_html_e( 'Skip to content', 'luna' ); ?></a>

  <?php get_template_part( 'global-elements', 'g01' ); ?>

  <main class="main" role="main" id="main">