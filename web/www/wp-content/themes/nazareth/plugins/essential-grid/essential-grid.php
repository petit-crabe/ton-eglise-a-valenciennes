<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nazareth_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nazareth_essential_grid_theme_setup9', 9 );
	function nazareth_essential_grid_theme_setup9() {

		add_filter( 'nazareth_filter_merge_styles', 'nazareth_essential_grid_merge_styles' );

		if ( is_admin() ) {
			add_filter( 'nazareth_filter_tgmpa_required_plugins', 'nazareth_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nazareth_essential_grid_tgmpa_required_plugins' ) ) {
	
	function nazareth_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( nazareth_storage_isset( 'required_plugins', 'essential-grid' ) && nazareth_is_theme_activated() ) {
			$path = nazareth_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || nazareth_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => nazareth_storage_get_array( 'required_plugins', 'essential-grid' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'nazareth_exists_essential_grid' ) ) {
	function nazareth_exists_essential_grid() {
		return defined( 'EG_PLUGIN_PATH' );
	}
}

// Merge custom styles
if ( ! function_exists( 'nazareth_essential_grid_merge_styles' ) ) {
	
	function nazareth_essential_grid_merge_styles( $list ) {
		if ( nazareth_exists_essential_grid() ) {
			$list[] = 'plugins/essential-grid/_essential-grid.scss';
		}
		return $list;
	}
}

