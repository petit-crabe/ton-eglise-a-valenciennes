<?php
/* Give (donation forms) support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nazareth_give_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nazareth_give_theme_setup9', 9 );
	function nazareth_give_theme_setup9() {

		add_filter( 'nazareth_filter_merge_styles', 'nazareth_give_merge_styles' );

		if ( is_admin() ) {
			add_filter( 'nazareth_filter_tgmpa_required_plugins', 'nazareth_give_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nazareth_give_tgmpa_required_plugins' ) ) {
	
	function nazareth_give_tgmpa_required_plugins( $list = array() ) {
		if ( nazareth_storage_isset( 'required_plugins', 'give' ) ) {
			$list[] = array(
				'name'     => nazareth_storage_get_array( 'required_plugins', 'give' ),
				'slug'     => 'give',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'nazareth_exists_give' ) ) {
	function nazareth_exists_give() {
		return class_exists( 'Give' );
	}
}

// Merge custom styles
if ( ! function_exists( 'nazareth_give_merge_styles' ) ) {
	
	function nazareth_give_merge_styles( $list ) {
		if ( nazareth_exists_give() ) {
			$list[] = 'plugins/give/_give.scss';
		}
		return $list;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( nazareth_exists_give() ) {
	require_once NAZARETH_THEME_DIR . 'plugins/give/give-styles.php'; }


// Donation Form Custom Output
if ( ! function_exists( 'nazareth_give_before_forms_widget' ) ) {
	add_action( 'give_before_forms_widget','nazareth_give_before_forms_widget', 10, 1 );
	function nazareth_give_before_forms_widget($form_id) {	
		echo '<div class="give-form-info-wrapper"><div class="give-form-img">';
		
			echo get_the_post_thumbnail( $form_id, 'give' );
		 
		echo '</div><div class="give-form-desc">';
	}
}


// Donation Form Custom Output
if ( ! function_exists( 'nazareth_give_after_forms_widget' ) ) {
	add_action( 'give_after_forms_widget','nazareth_give_after_forms_widget', 10, 1 );
	function nazareth_give_after_forms_widget($form_id) {	
		echo '</div></div>';
	}
}