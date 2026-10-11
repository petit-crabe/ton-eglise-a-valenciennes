<?php
/* MP Timetable support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nazareth_mptt_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nazareth_mptt_theme_setup9', 9 );
	function nazareth_mptt_theme_setup9() {

		add_filter( 'nazareth_filter_merge_styles', 'nazareth_mptt_merge_styles' );
		add_filter( 'nazareth_filter_merge_styles_responsive', 'nazareth_mptt_merge_styles_responsive' );

		if ( is_admin() ) {
			add_filter( 'nazareth_filter_tgmpa_required_plugins', 'nazareth_mptt_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nazareth_mptt_tgmpa_required_plugins' ) ) {
	
	function nazareth_mptt_tgmpa_required_plugins( $list = array() ) {
		if ( nazareth_storage_isset( 'required_plugins', 'mp-timetable' ) ) {
			$list[] = array(
				'name'     => nazareth_storage_get_array( 'required_plugins', 'mp-timetable' ),
				'slug'     => 'mp-timetable',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin is installed and activated
if ( ! function_exists( 'nazareth_exists_mp_timetable' ) ) {
	function nazareth_exists_mptt() {
		return class_exists( 'Mp_Time_Table' );
	}
}

// Merge custom styles
if ( ! function_exists( 'nazareth_mptt_merge_styles' ) ) {
	
	function nazareth_mptt_merge_styles( $list ) {
		if ( nazareth_exists_mptt() ) {
			$list[] = 'plugins/mp-timetable/_mp-timetable.scss';
		}
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'nazareth_mptt_merge_styles_responsive' ) ) {
	
	function nazareth_mptt_merge_styles_responsive( $list ) {
		if ( nazareth_exists_mptt() ) {
			$list[] = 'plugins/mp-timetable/_mp-timetable-responsive.scss';
		}
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( nazareth_exists_mptt() ) {
	require_once NAZARETH_THEME_DIR . 'plugins/mp-timetable/mp-timetable-styles.php'; }

