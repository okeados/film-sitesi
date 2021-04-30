<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('filmax_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'filmax_cf7_theme_setup9', 9 );
	function filmax_cf7_theme_setup9() {
		
		add_filter( 'filmax_filter_merge_styles',							'filmax_cf7_merge_styles' );

		if (is_admin()) {
			add_filter( 'filmax_filter_tgmpa_required_plugins',			'filmax_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'filmax_cf7_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('filmax_filter_tgmpa_required_plugins',	'filmax_cf7_tgmpa_required_plugins');
	function filmax_cf7_tgmpa_required_plugins($list=array()) {
		if (filmax_storage_isset('required_plugins', 'contact-form-7')) {
			// CF7 plugin
			$list[] = array(
					'name' 		=> filmax_storage_get_array('required_plugins', 'contact-form-7'),
					'slug' 		=> 'contact-form-7',
					'version'	=> '5.1.3',
					'required' 	=> false
			);
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( !function_exists( 'filmax_exists_cf7' ) ) {
	function filmax_exists_cf7() {
		return class_exists('WPCF7');
	}
}
	
// Merge custom styles
if ( !function_exists( 'filmax_cf7_merge_styles' ) ) {
	//Handler of the add_filter('filmax_filter_merge_styles', 'filmax_cf7_merge_styles');
	function filmax_cf7_merge_styles($list) {
		if (filmax_exists_cf7()) {
			$list[] = 'plugins/contact-form-7/_contact-form-7.scss';
		}
		return $list;
	}
}
?>