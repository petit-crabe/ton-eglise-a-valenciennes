<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nazareth_gutenberg_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nazareth_gutenberg_theme_setup9', 9 );
	function nazareth_gutenberg_theme_setup9() {

		add_filter( 'nazareth_filter_merge_styles', 'nazareth_gutenberg_merge_styles' );
		add_filter( 'nazareth_filter_merge_styles_responsive', 'nazareth_gutenberg_merge_styles_responsive' );
		add_action( 'enqueue_block_editor_assets', 'nazareth_gutenberg_editor_scripts' );
		add_filter( 'nazareth_filter_localize_script_admin',	'nazareth_gutenberg_localize_script');
		if ( is_admin() ) {
			add_filter( 'nazareth_filter_tgmpa_required_plugins', 'nazareth_gutenberg_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nazareth_gutenberg_tgmpa_required_plugins' ) ) {
	
	function nazareth_gutenberg_tgmpa_required_plugins( $list = array() ) {
		if ( nazareth_storage_isset( 'required_plugins', 'gutenberg' ) ) {
			$list[] = array(
				'name'     => nazareth_storage_get_array( 'required_plugins', 'gutenberg' ),
				'slug'     => 'gutenberg',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if Gutenberg is installed and activated
if ( ! function_exists( 'nazareth_exists_gutenberg' ) ) {
	function nazareth_exists_gutenberg() {
		return function_exists( 'register_block_type' );
	}
}

// Return true if Gutenberg exists and current mode is preview
if ( ! function_exists( 'nazareth_gutenberg_is_preview' ) ) {
	function nazareth_gutenberg_is_preview() {
		return false;
	}
}

// Merge custom styles
if ( ! function_exists( 'nazareth_gutenberg_merge_styles' ) ) {
	
	function nazareth_gutenberg_merge_styles( $list ) {
		if ( nazareth_exists_gutenberg() ) {
			$list[] = 'plugins/gutenberg/_gutenberg.scss';
		}
		return $list;
	}
}

// Merge responsive styles
if ( ! function_exists( 'nazareth_gutenberg_merge_styles_responsive' ) ) {
	
	function nazareth_gutenberg_merge_styles_responsive( $list ) {
		if ( nazareth_exists_gutenberg() ) {
			$list[] = 'plugins/gutenberg/_gutenberg-responsive.scss';
		}
		return $list;
	}
}


// Load required styles and scripts for Gutenberg Editor mode
if ( ! function_exists( 'nazareth_gutenberg_editor_scripts' ) ) {
	
	function nazareth_gutenberg_editor_scripts() {
		nazareth_admin_scripts(true);
		nazareth_admin_localize_scripts();
		// Editor styles
		wp_enqueue_style( 'nazareth-gutenberg-preview', nazareth_get_file_url( 'plugins/gutenberg/gutenberg-preview.css' ), array(), null );
		// Editor scripts
		wp_enqueue_script( 'nazareth-gutenberg-preview', nazareth_get_file_url( 'plugins/gutenberg/gutenberg-preview.js' ), array( 'jquery' ), null, true );
	}
}

// Add plugin's specific variables to the scripts
if ( ! function_exists( 'nazareth_gutenberg_localize_script' ) ) {
	
	function nazareth_gutenberg_localize_script( $arr ) {
		$arr['color_scheme'] = nazareth_get_theme_option( 'color_scheme' );
		return $arr;
	}
}

// Save CSS with custom colors and fonts to the gutenberg-editor-style.css
if ( ! function_exists( 'nazareth_gutenberg_save_css' ) ) {
	add_action( 'nazareth_action_save_options', 'nazareth_gutenberg_save_css', 30 );
	add_action( 'trx_addons_action_save_options', 'nazareth_gutenberg_save_css', 30 );
	function nazareth_gutenberg_save_css() {

		$msg = '/* ' . esc_html__( "ATTENTION! This file was generated automatically! Don't change it!!!", 'nazareth' )
				. "\n----------------------------------------------------------------------- */\n";

		// Get main styles
		$css = nazareth_fgc( nazareth_get_file_dir( 'style.css' ) );

		// Append theme-vars styles
		$css .= nazareth_customizer_get_css(
			array(
				'colors' => nazareth_get_theme_setting( 'separate_schemes' ) ? false : null,
			)
		);
		
		// Append color schemes
		if ( nazareth_get_theme_setting( 'separate_schemes' ) ) {
			$schemes = nazareth_get_sorted_schemes();
			if ( is_array( $schemes ) ) {
				foreach ( $schemes as $scheme => $data ) {
					$css .= nazareth_customizer_get_css(
						array(
							'fonts'  => false,
							'colors' => $data['colors'],
							'scheme' => $scheme,
						)
					);
				}
			}
		}

		// Add context class to each selector
		if ( function_exists( 'trx_addons_css_add_context' ) ) {
			$css = trx_addons_css_add_context($css, '.edit-post-visual-editor');
		}

		// Save styles to the file
		nazareth_fpc( nazareth_get_file_dir( 'plugins/gutenberg/gutenberg-preview.css' ), $msg . $css );
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( nazareth_exists_gutenberg() ) {
	require_once NAZARETH_THEME_DIR . 'plugins/gutenberg/gutenberg-styles.php';
}
