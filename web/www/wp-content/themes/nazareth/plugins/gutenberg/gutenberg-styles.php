<?php
// Add plugin-specific vars to the custom CSS
if ( ! function_exists( 'nazareth_gutenberg_add_theme_vars' ) ) {
	add_filter( 'nazareth_filter_add_theme_vars', 'nazareth_gutenberg_add_theme_vars', 10, 2 );
	function nazareth_gutenberg_add_theme_vars( $rez, $vars ) {
		return $rez;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'nazareth_gutenberg_get_css' ) ) {
	add_filter( 'nazareth_filter_get_css', 'nazareth_gutenberg_get_css', 10, 2 );
	function nazareth_gutenberg_get_css( $css, $args ) {

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			extract( $args['vars'] );
			$css['vars'] .= <<<CSS
CSS;
		}

		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts                   = $args['fonts'];
			$fonts['p_font-family!'] = str_replace(';', ' !important;', $fonts['p_font-family']);
			$css['fonts']           .= <<<CSS
.editor-block-list__block {
	{$fonts['p_font-family!']}
	{$fonts['p_font-size']}
	{$fonts['p_font-weight']}
	{$fonts['p_font-style']}
	{$fonts['p_line-height']}
	{$fonts['p_text-decoration']}
	{$fonts['p_text-transform']}
	{$fonts['p_letter-spacing']}
}

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS
.scheme_self.editor-block-list__layout {
	color: {$colors['text']};
	background-color: {$colors['bg_color']};
}
.scheme_self.editor-block-list__layout p {
	color: {$colors['text']};
}

CSS;
		}

		return $css;
	}
}

