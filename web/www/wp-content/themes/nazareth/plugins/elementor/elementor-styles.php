<?php
// Add plugin-specific vars to the custom CSS
if ( ! function_exists( 'nazareth_elm_add_theme_vars' ) ) {
	add_filter( 'nazareth_filter_add_theme_vars', 'nazareth_elm_add_theme_vars', 10, 2 );
	function nazareth_elm_add_theme_vars( $rez, $vars ) {
		foreach ( array( 10, 20, 30, 40, 60 ) as $m ) {
			if ( substr( $vars['page'], 0, 2 ) != '{{' ) {
				$rez[ "page{$m}" ]    = ( $vars['page'] + $m ) . 'px';
				$rez[ "content{$m}" ] = ( $vars['page'] - $vars['gap'] - $vars['sidebar'] + $m ) . 'px';
			} else {
				$rez[ "page{$m}" ]    = "{{ data.page{$m} }}";
				$rez[ "content{$m}" ] = "{{ data.content{$m} }}";
			}
		}
		return $rez;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'nazareth_elm_get_css' ) ) {
	add_filter( 'nazareth_filter_get_css', 'nazareth_elm_get_css', 10, 2 );
	function nazareth_elm_get_css( $css, $args ) {

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			extract( $args['vars'] );
			$css['vars'] .= <<<CSS
/* Narrow: 5px */
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow {
	width: $page10; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow {
	width: $content10; 
}

/* Default: 10px */
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default {
	width: $page20;
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default {
	width: $content20;
}

/* Extended: 15px */
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended {
	width: $page30; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended {
	width: $content30; 
}

/* Wide: 20px */
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide {
	width: $page40; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide {
	width: $content40; 
}

/* Wider: 30px */
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider {
	width: $page60; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider {
	width: $content60; 
}

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS

/* Shape above and below rows */
.elementor-shape .elementor-shape-fill {
	fill: {$colors['bg_color']};
}

/* Divider */
.elementor-divider-separator {
	border-color: {$colors['inverse_bd_color']};
}


/* --- */ 
.elementor-custom-embed-play {
	border-color: {$colors['inverse_link_02']};
}
.elementor-custom-embed-play:hover i:before {
	color: {$colors['text_hover']};
}

/* Tabs */
.elementor-widget-tabs .elementor-tabs-wrapper {
	background-color: {$colors['inverse_text']};

} 
.elementor-widget-tabs .elementor-tab-desktop-title a { 
	color: {$colors['inverse_dark']};
}
.elementor-widget-tabs .elementor-tab-desktop-title:hover { 
	background-color: {$colors['text_link']};
}
.elementor-tab-title.elementor-tab-mobile-title { 
	color: {$colors['inverse_dark']};
	border-color: {$colors['bd_color']};
}
.elementor-widget-tabs .elementor-tab-desktop-title.elementor-active,
.elementor-widget-tabs .elementor-tab-title.elementor-tab-mobile-title.elementor-active { 
	background-color: {$colors['text_hover']}!important;
	color: {$colors['inverse_text']};
}
.elementor-widget-tabs .elementor-tab-desktop-title.elementor-active a,
.elementor-widget-tabs .elementor-tab-title.elementor-tab-mobile-title.elementor-active a { 
	color: {$colors['inverse_text']};
}
/* Accordion */
.elementor-accordion .elementor-tab-title {
	background-color: {$colors['extra_link2']};
	color: {$colors['inverse_dark']};
}
.elementor-accordion .elementor-tab-title .elementor-accordion-icon i:before,
.elementor-accordion .elementor-tab-title a {
	color: {$colors['inverse_dark']};
}
.elementor-accordion .elementor-tab-title:hover a {
	color: {$colors['text_link']};
}
.elementor-accordion .elementor-tab-title:hover .elementor-accordion-icon i:before {
	color: {$colors['text_link']};
}

CSS;
		}

		return $css;
	}
}

