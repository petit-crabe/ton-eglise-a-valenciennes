<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

$nazareth_header_css   = '';
$nazareth_header_image = get_header_image();
$nazareth_header_video = nazareth_get_header_video();
if ( ! empty( $nazareth_header_image ) && nazareth_trx_addons_featured_image_override( is_singular() || nazareth_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$nazareth_header_image = nazareth_get_current_mode_image( $nazareth_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $nazareth_header_image ) || ! empty( $nazareth_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $nazareth_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $nazareth_header_image ) {
		echo ' ' . esc_attr( nazareth_add_inline_css_class( 'background-image: url(' . esc_url( $nazareth_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( nazareth_is_on( nazareth_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight nazareth-full-height';
	}
	if ( ! nazareth_is_inherit( nazareth_get_theme_option( 'header_scheme' ) ) ) {
		echo ' scheme_' . esc_attr( nazareth_get_theme_option( 'header_scheme' ) );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $nazareth_header_video ) ) {
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	if ( nazareth_get_theme_option( 'menu_style' ) == 'top' ) {
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'templates/header-navi' ) );
	}

	// Mobile header
	if ( nazareth_is_on( nazareth_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'templates/header-title' ) );

	// Header widgets area
	get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'templates/header-widgets' ) );

	// Display featured image in the header on the single posts
	// Comment next line to prevent show featured image in the header area
	// and display it in the post's content
	get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'templates/header-single' ) );

	?>
</header>
