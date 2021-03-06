<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package luna
 */

/**
 * Favicons
 */
$theme_color     = get_field( 'theme_color', 'global_options' );
$favicon_16      = get_field( 'favicon_16', 'global_options' );
$favicon_32      = get_field( 'favicon_32', 'global_options' );
$favicon_default = get_field( 'favicon_default', 'global_options' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--
Why, hello! Thanks for taking a look at our code.
This site was designed and built by...

    .d8888b.   .d8888b.       888 d8b          d8b 888             888
   d88P  Y88b d88P  Y88b      888 Y8P          Y8P 888             888
   888    888      .d88P      888                  888             888
   Y88b. d888     8888"   .d88888 888  .d88b.  888 888888  8888b.  888
    "Y888P888      "Y8b. d88" 888 888 d88P"88b 888 888        "88b 888
          888 888    888 888  888 888 888  888 888 888    .d888888 888
   Y88b  d88P Y88b  d88P Y88b 888 888 Y88b 888 888 Y88b.  888  888 888
    "Y8888P"   "Y8888P"   "Y88888 888  "Y88888 888  "Y888 "Y888888 888
                                           888
                                      Y8b d88P
                                       "Y88P"

For more info, visit 93digital.co.uk.
-->
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
