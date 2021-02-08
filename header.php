<?php
/**
 * Luna header.
 * Contains the <head> and the opening <html>, <body> and <main> tags.
 *
 * @package luna
 */

/**
 * Favicons
 *
 * @todo replace with non-ACF functions.
 */
// $theme_color     = get_field( 'theme_color', 'global_options' );
// $favicon_16      = get_field( 'favicon_16', 'global_options' );
// $favicon_32      = get_field( 'favicon_32', 'global_options' );
// $favicon_default = get_field( 'favicon_default', 'global_options' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<link rel="profile" href="//gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php if ( $favicon_default ) : ?>
		<link rel="apple-touch-icon" href="<?php echo esc_url( $favicon_default ); ?>">
	<?php endif; ?>
	<?php if ( $favicon_32 ) : ?>
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( $favicon_32 ); ?>">
	<?php endif; ?>
	<?php if ( $favicon_32 ) : ?>
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( $favicon_16 ); ?>">
	<?php endif; ?>
	<?php if ( $theme_color ) : ?>
		<meta name="msapplication-TileColor" content="<?php echo esc_attr( $theme_color ); ?>">
		<meta name="theme-color" content="<?php echo esc_attr( $theme_color ); ?>">
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body id="body" <?php body_class(); ?> data-instant-intensity="viewport">
	<?php nine3_body_code(); ?>

	<a href="#main" class="skip-link"><?php esc_html_e( 'Skip to content', 'luna' ); ?></a>

	<header class="header" role="banner" id="header">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
			)
		);
		?>
	</header>

	<main class="main" role="main" id="main">
