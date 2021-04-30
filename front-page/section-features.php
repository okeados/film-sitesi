<div class="front_page_section front_page_section_features<?php
			$filmax_scheme = filmax_get_theme_option('front_page_features_scheme');
			if (!filmax_is_inherit($filmax_scheme)) echo ' scheme_'.esc_attr($filmax_scheme);
			echo ' front_page_section_paddings_'.esc_attr(filmax_get_theme_option('front_page_features_paddings'));
		?>"<?php
		$filmax_css = '';
		$filmax_bg_image = filmax_get_theme_option('front_page_features_bg_image');
		if (!empty($filmax_bg_image)) 
			$filmax_css .= 'background-image: url('.esc_url(filmax_get_attachment_url($filmax_bg_image)).');';
		if (!empty($filmax_css))
			echo ' style="' . esc_attr($filmax_css) . '"';
?>><?php
	// Add anchor
	$filmax_anchor_icon = filmax_get_theme_option('front_page_features_anchor_icon');	
	$filmax_anchor_text = filmax_get_theme_option('front_page_features_anchor_text');	
	if ((!empty($filmax_anchor_icon) || !empty($filmax_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_features"'
										. (!empty($filmax_anchor_icon) ? ' icon="'.esc_attr($filmax_anchor_icon).'"' : '')
										. (!empty($filmax_anchor_text) ? ' title="'.esc_attr($filmax_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_features_inner<?php
			if (filmax_get_theme_option('front_page_features_fullheight'))
				echo ' filmax-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$filmax_css = '';
			$filmax_bg_mask = filmax_get_theme_option('front_page_features_bg_mask');
			$filmax_bg_color = filmax_get_theme_option('front_page_features_bg_color');
			if (!empty($filmax_bg_color) && $filmax_bg_mask > 0)
				$filmax_css .= 'background-color: '.esc_attr($filmax_bg_mask==1
																	? $filmax_bg_color
																	: filmax_hex2rgba($filmax_bg_color, $filmax_bg_mask)
																).';';
			if (!empty($filmax_css))
				echo ' style="' . esc_attr($filmax_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_features_content_wrap content_wrap">
			<?php
			// Caption
			$filmax_caption = filmax_get_theme_option('front_page_features_caption');
			if (!empty($filmax_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_features_caption front_page_block_<?php echo !empty($filmax_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($filmax_caption, 'filmax_kses_content' ); ?></h2><?php
			}
		
			// Description (text)
			$filmax_description = filmax_get_theme_option('front_page_features_description');
			if (!empty($filmax_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_features_description front_page_block_<?php echo !empty($filmax_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($filmax_description), 'filmax_kses_content' ); ?></div><?php
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_features_output"><?php 
				if (is_active_sidebar('front_page_features_widgets')) {
					dynamic_sidebar( 'front_page_features_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!filmax_exists_trx_addons())
						filmax_customizer_need_trx_addons_message();
					else
						filmax_customizer_need_widgets_message('front_page_features_caption', 'ThemeREX Addons - Services');
				}
			?></div>
		</div>
	</div>
</div>