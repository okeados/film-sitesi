<?php
/* WPBakery Page Builder support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('filmax_vc_theme_setup9')) {
	add_action( 'after_setup_theme', 'filmax_vc_theme_setup9', 9 );
	function filmax_vc_theme_setup9() {
		
		add_filter( 'filmax_filter_merge_styles',		'filmax_vc_merge_styles' );

		if (filmax_exists_visual_composer()) {
	
			// Add/Remove params in the standard VC shortcodes
			//-----------------------------------------------------
			add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,	'filmax_vc_add_params_classes', 10, 3 );
			add_filter( 'vc_iconpicker-type-fontawesome',	'filmax_vc_iconpicker_type_fontawesome' );
			
			// Color scheme
			$scheme = array(
				"param_name" => "scheme",
				"heading" => esc_html__("Color scheme", 'filmax'),
				"description" => wp_kses_data( __("Select color scheme to decorate this block", 'filmax') ),
				"group" => esc_html__('Colors', 'filmax'),
				"admin_label" => true,
				"value" => array_flip(filmax_get_list_schemes(true)),
				"type" => "dropdown"
			);
			$sc_list = apply_filters('filmax_filter_add_scheme_in_vc', array('vc_section', 'vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text'));
			foreach ($sc_list as $sc)
				vc_add_param($sc, $scheme);

			// Alter height and hide on mobile for Empty Space
			vc_add_param("vc_empty_space", array(
				"param_name" => "alter_height",
				"heading" => esc_html__("Alter height", 'filmax'),
				"description" => wp_kses_data( __("Select alternative height instead value from the field above", 'filmax') ),
				"admin_label" => true,
				"value" => array(
					esc_html__('Tiny', 'filmax') => 'tiny',
					esc_html__('Small', 'filmax') => 'small',
					esc_html__('Medium', 'filmax') => 'medium',
					esc_html__('Large', 'filmax') => 'large',
					esc_html__('Huge', 'filmax') => 'huge',
					esc_html__('From the value above', 'filmax') => 'none'
				),
				"type" => "dropdown"
			));
			
			// Add Narrow style to the Progress bars
			vc_add_param("vc_progress_bar", array(
				"param_name" => "narrow",
				"heading" => esc_html__("Narrow", 'filmax'),
				"description" => wp_kses_data( __("Use narrow style for the progress bar", 'filmax') ),
				"std" => 0,
				"value" => array(esc_html__("Narrow style", 'filmax') => "1" ),
				"type" => "checkbox"
			));
			
			// Add param 'Closeable' to the Message Box
			vc_add_param("vc_message", array(
				"param_name" => "closeable",
				"heading" => esc_html__("Closeable", 'filmax'),
				"description" => wp_kses_data( __("Add 'Close' button to the message box", 'filmax') ),
				"std" => 0,
				"value" => array(esc_html__("Closeable", 'filmax') => "1" ),
				"type" => "checkbox"
			));
		}
		if (is_admin()) {
			add_filter( 'filmax_filter_tgmpa_required_plugins', 'filmax_vc_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'filmax_vc_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('filmax_filter_tgmpa_required_plugins',	'filmax_vc_tgmpa_required_plugins');
	function filmax_vc_tgmpa_required_plugins($list=array()) {
		if (filmax_storage_isset('required_plugins', 'js_composer')) {
			$path = filmax_get_file_dir('plugins/js_composer/js_composer.zip');
			if (!empty($path) || filmax_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> filmax_storage_get_array('required_plugins', 'js_composer'),
					'slug' 		=> 'js_composer',
					'version'	=> '6.5.0',
					'source'	=> !empty($path) ? $path : 'upload://js_composer.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if WPBakery Page Builder installed and activated
if ( !function_exists( 'filmax_exists_visual_composer' ) ) {
	function filmax_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery Page Builder in frontend editor mode
if ( !function_exists( 'filmax_vc_is_frontend' ) ) {
	function filmax_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}
	
// Merge custom styles
if ( !function_exists( 'filmax_vc_merge_styles' ) ) {
	//Handler of the add_filter('filmax_filter_merge_styles', 'filmax_vc_merge_styles');
	function filmax_vc_merge_styles($list) {
		if (filmax_exists_visual_composer()) {
			$list[] = 'plugins/js_composer/_js_composer.scss';
		}
		return $list;
	}
}
	
// Add theme icons to the VC iconpicker list
if ( !function_exists( 'filmax_vc_iconpicker_type_fontawesome' ) ) {
	//Handler of the add_filter( 'vc_iconpicker-type-fontawesome',	'filmax_vc_iconpicker_type_fontawesome' );
	function filmax_vc_iconpicker_type_fontawesome($icons) {
		$list = filmax_get_list_icons();
		if (!is_array($list) || count($list) == 0) return $icons;
		$rez = array();
		foreach ($list as $icon)
			$rez[] = array($icon => str_replace('icon-', '', $icon));
		return array_merge( $icons, array(esc_html__('Theme Icons', 'filmax') => $rez) );
	}
}



// Shortcodes support
//------------------------------------------------------------------------

// Add params to the standard VC shortcodes
if ( !function_exists( 'filmax_vc_add_params_classes' ) ) {
	//Handler of the add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'filmax_vc_add_params_classes', 10, 3 );
	function filmax_vc_add_params_classes($classes, $sc, $atts) {
		// Add color scheme
		if (in_array($sc, apply_filters('filmax_filter_add_scheme_in_vc', array('vc_section', 'vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text')))) {
			if (!empty($atts['scheme']) && !filmax_is_inherit($atts['scheme']))
				$classes .= ($classes ? ' ' : '') . 'scheme_' . $atts['scheme'];
		}
		// Add other specific classes
		if (in_array($sc, array('vc_empty_space'))) {
			if (!empty($atts['alter_height']) && !filmax_is_off($atts['alter_height']))
				$classes .= ($classes ? ' ' : '') . 'height_' . $atts['alter_height'];
		} else if (in_array($sc, array('vc_progress_bar'))) {
			if (!empty($atts['narrow']) && (int) $atts['narrow']==1)
				$classes .= ($classes ? ' ' : '') . 'vc_progress_bar_narrow';
		} else if (in_array($sc, array('vc_message'))) {
			if (!empty($atts['closeable']) && (int) $atts['closeable']==1)
				$classes .= ($classes ? ' ' : '') . 'vc_message_box_closeable';
		}
		return $classes;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (filmax_exists_visual_composer()) { require_once FILMAX_THEME_DIR . 'plugins/js_composer/js_composer-styles.php'; }
?>