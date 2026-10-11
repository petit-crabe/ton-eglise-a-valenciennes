<?php
/**
 * The Front Page template file.
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( nazareth_is_on( nazareth_get_theme_option( 'front_page_enabled' ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$nazareth_sections = nazareth_array_get_keys_by_value( nazareth_get_theme_option( 'front_page_sections' ), 1, false );
		if ( is_array( $nazareth_sections ) ) {
			foreach ( $nazareth_sections as $nazareth_section ) {
				get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'front-page/section', $nazareth_section ), $nazareth_section );
			}
		}

		// Else if this page is blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'blog' ) );

		// Else - display native page content
	} else {
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'page' ) );
	}

	// Else get index template to show posts
} else {
	get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'index' ) );
}

get_footer();
