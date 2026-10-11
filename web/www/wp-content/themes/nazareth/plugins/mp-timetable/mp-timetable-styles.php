<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'nazareth_mptt_get_css' ) ) {
	add_filter( 'nazareth_filter_get_css', 'nazareth_mptt_get_css', 10, 2 );
	function nazareth_mptt_get_css( $css, $args ) {

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			$vars         = $args['vars'];
			$css['vars'] .= <<<CSS

.post_type_mp-event .timeslot .timeslot-user .avatar,
.post_type_mp-column .event-user .avatar {
	-webkit-border-radius: {$vars['rad50']};
	    -ms-border-radius: {$vars['rad50']};
			border-radius: {$vars['rad50']};
}
CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS

/* Table */
.mptt-shortcode-wrapper .mptt-shortcode-table tr.mptt-shortcode-row th {
	color: {$colors['extra_dark']};
	background-color: {$colors['inverse_link']};
	border-color: {$colors['extra_bd_color']};
}
.mptt-shortcode-wrapper .mptt-shortcode-table tr[class*="mptt-shortcode-row-"] td {
	color: {$colors['alter_dark']};
	border-color: {$colors['bg_color']};
}
.mptt-shortcode-wrapper .mptt-shortcode-table tr[class*="mptt-shortcode-row-"]:nth-child(2n+1) > td,
.mptt-shortcode-wrapper .mptt-shortcode-table.mptt-theme-mode tbody tr:nth-child(2n+1) td.event {
	background-color: {$colors['alter_bg_color_04']};
}
.mptt-shortcode-wrapper .mptt-shortcode-table tr[class*="mptt-shortcode-row-"]:nth-child(2n) > td,
.mptt-shortcode-wrapper .mptt-shortcode-table.mptt-theme-mode tbody tr:nth-child(2n) td.event {
	background-color: {$colors['alter_bg_color_02']};
}
.mptt-shortcode-wrapper .mptt-shortcode-table tbody .mptt-event-container {
	outline-color: {$colors['alter_bd_color']};
}


/* Slots in the single event */
.post_type_mp-event .timeslot {
	background-color: {$colors['alter_bg_color']};
	border-color: {$colors['alter_bd_color']};
	color: {$colors['alter_text']};
}
.post_type_mp-event .timeslot .timeslot-link {
	color: {$colors['alter_link']};
}
.post_type_mp-event .timeslot:hover {
	background-color: {$colors['alter_bg_hover']};
	border-color: {$colors['alter_bd_hover']};
	color: {$colors['alter_dark']};
}
.post_type_mp-event .timeslot:hover .timeslot-link,
.post_type_mp-event .timeslot:hover .timeslot-link:hover {
	color: {$colors['alter_hover']};
}

/* Services Page */
/* Calendar */
.mptt-shortcode-wrapper table>tbody>tr:nth-child(2n+1) {
	background-color: {$colors['extra_link2']}!important;
}
.mptt-shortcode-wrapper table>tbody>tr:nth-child(2n+2) {
	background-color: {$colors['inverse_link']}!important;
}
.mptt-shortcode-wrapper .mptt-shortcode-table tr td,
.mptt-shortcode-wrapper .mptt-shortcode-table tr th {
	border-color: #e3dcd3!important;
}
.mptt-shortcode-wrapper .mptt-shortcode-table tbody .mptt-event-container:hover {
	background-color: {$colors['text_link']};
	outline-color: {$colors['alter_bd_hover']};
	background-color: {$colors['text_link']};
}
.mptt-shortcode-wrapper .mptt-shortcode-table tbody .mptt-event-container:hover .event-title,
.mptt-shortcode-wrapper .mptt-shortcode-table tbody .mptt-event-container:hover .timeslot {
	color: {$colors['inverse_text']};
}
.mptt-shortcode-wrapper .mptt-shortcode-table tbody .mptt-event-container .mptt-inner-event-content {
	background-color: {$colors['bg_color_0']};
}


CSS;
		}

		return $css;
	}
}

