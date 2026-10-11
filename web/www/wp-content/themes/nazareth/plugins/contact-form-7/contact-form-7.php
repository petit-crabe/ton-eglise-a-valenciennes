<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nazareth_cf7_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nazareth_cf7_theme_setup9', 9 );
	function nazareth_cf7_theme_setup9() {

		add_filter( 'nazareth_filter_merge_scripts', 'nazareth_cf7_merge_scripts' );
		add_filter( 'nazareth_filter_merge_styles', 'nazareth_cf7_merge_styles' );

		if ( nazareth_exists_cf7() ) {
			add_action( 'wp_enqueue_scripts', 'nazareth_cf7_frontend_scripts', 1100 );
		}

		if ( is_admin() ) {
			add_filter( 'nazareth_filter_tgmpa_required_plugins', 'nazareth_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nazareth_cf7_tgmpa_required_plugins' ) ) {
	
	function nazareth_cf7_tgmpa_required_plugins( $list = array() ) {
		if ( nazareth_storage_isset( 'required_plugins', 'contact-form-7' ) ) {
			// CF7 plugin
			$list[] = array(
				'name'     => nazareth_storage_get_array( 'required_plugins', 'contact-form-7' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			);
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( ! function_exists( 'nazareth_exists_cf7' ) ) {
	function nazareth_exists_cf7() {
		return class_exists( 'WPCF7' );
	}
}

// Enqueue custom scripts
if ( ! function_exists( 'nazareth_cf7_frontend_scripts' ) ) {
	
	function nazareth_cf7_frontend_scripts() {
		if ( nazareth_exists_cf7() ) {
			if ( nazareth_is_on( nazareth_get_theme_option( 'debug_mode' ) ) ) {
				$nazareth_url = nazareth_get_file_url( 'plugins/contact-form-7/contact-form-7.js' );
				if ( '' != $nazareth_url ) {
					wp_enqueue_script( 'nazareth-cf7', $nazareth_url, array( 'jquery' ), null, true );
				}
			}
		}
	}
}

// Merge custom scripts
if ( ! function_exists( 'nazareth_cf7_merge_scripts' ) ) {
	
	function nazareth_cf7_merge_scripts( $list ) {
		if ( nazareth_exists_cf7() ) {
			$list[] = 'plugins/contact-form-7/contact-form-7.js';
		}
		return $list;
	}
}

// Merge custom styles
if ( ! function_exists( 'nazareth_cf7_merge_styles' ) ) {
	
	function nazareth_cf7_merge_styles( $list ) {
		if ( nazareth_exists_cf7() ) {
			$list[] = 'plugins/contact-form-7/_contact-form-7.scss';
		}
		return $list;
	}
}

