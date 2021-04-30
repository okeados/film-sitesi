<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('filmax_trx_updater_theme_setup9')) {
    add_action( 'after_setup_theme', 'filmax_trx_updater_theme_setup9', 9 );
    function filmax_trx_updater_theme_setup9() {
        if (is_admin()) {
            add_filter( 'filmax_filter_tgmpa_required_plugins',		'filmax_trx_updater_tgmpa_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'filmax_trx_updater_tgmpa_required_plugins' ) ) {
    function filmax_trx_updater_tgmpa_required_plugins($list=array()) {
        if (filmax_storage_isset('required_plugins', 'trx_updater')) {
            $list[] = array(
                'name' 		=> filmax_storage_get_array('required_plugins', 'trx_updater'),
                'slug' 		=> 'trx_updater',
                'version'   => '1.5.3',
                'source'	=> filmax_get_file_dir('plugins/trx_updater/trx_updater.zip'),
                'required' 	=> false
            );
        }
        return $list;
    }
}

// Check if ThemeREX Updater installed and activated
if ( !function_exists( 'filmax_exists_trx_updater' ) ) {
    function filmax_exists_trx_updater() {
        return defined('TRX_UPDATER_VERSION');
    }
}
?>