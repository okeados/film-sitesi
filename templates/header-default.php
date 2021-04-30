<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

$filmax_header_css = '';
$filmax_header_image = get_header_image();
$filmax_header_video = filmax_get_header_video();
if (!empty($filmax_header_image) && filmax_trx_addons_featured_image_override(is_singular() || filmax_storage_isset('blog_archive') || is_category(), true)) {
	$filmax_header_image = filmax_get_current_mode_image($filmax_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($filmax_header_image) || !empty($filmax_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($filmax_header_video!='') echo ' with_bg_video';
					if ($filmax_header_image!='') echo ' '.esc_attr(filmax_add_inline_css_class('background-image: url('.esc_url($filmax_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (filmax_is_on(filmax_get_theme_option('header_fullheight'))) echo ' header_fullheight filmax-full-height';
					if (!filmax_is_inherit(filmax_get_theme_option('header_scheme')))
						echo ' scheme_' . esc_attr(filmax_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($filmax_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (filmax_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Mobile header
	if (filmax_is_on(filmax_get_theme_option("header_mobile_enabled"))) {
		get_template_part( 'templates/header-mobile' );
	}
	
	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );


?></header>