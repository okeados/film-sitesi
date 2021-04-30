<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.06
 */

$filmax_header_css = '';
$filmax_header_image = get_header_image();
$filmax_header_video = filmax_get_header_video();
if (!empty($filmax_header_image) && filmax_trx_addons_featured_image_override(is_singular() || filmax_storage_isset('blog_archive') || is_category())) {
	$filmax_header_image = filmax_get_current_mode_image($filmax_header_image);
}

$filmax_header_id = str_replace('header-custom-', '', filmax_get_theme_option("header_style"));
if ((int) $filmax_header_id == 0) {
	$filmax_header_id = filmax_get_post_id(array(
												'name' => $filmax_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$filmax_header_id = apply_filters('filmax_filter_get_translated_layout', $filmax_header_id);
}
$filmax_header_meta = get_post_meta($filmax_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($filmax_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($filmax_header_id)));
				echo !empty($filmax_header_image) || !empty($filmax_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($filmax_header_video!='') 
					echo ' with_bg_video';
				if ($filmax_header_image!='') 
					echo ' '.esc_attr(filmax_add_inline_css_class('background-image: url('.esc_url($filmax_header_image).');'));
				if (!empty($filmax_header_meta['margin']) != '') 
					echo ' '.esc_attr(filmax_add_inline_css_class('margin-bottom: '.esc_attr(filmax_prepare_css_value($filmax_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (filmax_is_on(filmax_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight filmax-full-height';
				if (!filmax_is_inherit(filmax_get_theme_option('header_scheme')))
					echo ' scheme_' . esc_attr(filmax_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($filmax_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('filmax_action_show_layout', $filmax_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>