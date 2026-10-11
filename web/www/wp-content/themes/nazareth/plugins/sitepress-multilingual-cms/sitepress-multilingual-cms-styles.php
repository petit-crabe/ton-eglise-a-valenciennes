<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'nazareth_wpml_get_css' ) ) {
	add_filter( 'nazareth_filter_get_css', 'nazareth_wpml_get_css', 10, 2 );
	function nazareth_wpml_get_css( $css, $args ) {
		return $css;
	}
}

