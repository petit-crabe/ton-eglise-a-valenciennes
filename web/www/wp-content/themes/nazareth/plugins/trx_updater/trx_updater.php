<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nazareth_trx_updater_theme_setup9' ) ) {
    add_action( 'after_setup_theme', 'nazareth_trx_updater_theme_setup9', 9 );
    function nazareth_trx_updater_theme_setup9() {

        if ( is_admin() ) {
            add_filter( 'nazareth_filter_tgmpa_required_plugins', 'nazareth_trx_updater_tgmpa_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nazareth_trx_updater_tgmpa_required_plugins' ) ) {
    //Handler of the add_filter('nazareth_filter_tgmpa_required_plugins', 'nazareth_trx_updater_tgmpa_required_plugins');
    function nazareth_trx_updater_tgmpa_required_plugins( $list = array() ) {
        if ( nazareth_storage_isset( 'required_plugins', 'trx_updater' ) ) {
            $path = nazareth_get_plugin_source_path( 'plugins/trx_updater/trx_updater.zip' );
            if ( ! empty( $path ) || nazareth_get_theme_setting( 'tgmpa_upload' ) ) {
                $list[] = array(
                    'name'     => nazareth_storage_get_array( 'required_plugins', 'trx_updater' ),
                    'slug'     => 'trx_updater',
                    'source'   => ! empty( $path ) ? $path : 'upload://trx_updater.zip',
                    'required' => false,
                );
            }
        }
        return $list;
    }
}



// Check if trx_updater installed and activated
if ( ! function_exists( 'nazareth_exists_trx_updater' ) ) {
    function nazareth_exists_trx_updater() {
        return defined( 'TRX_UPDATER_VERSION' );
    }
}