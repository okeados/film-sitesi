<div class="front_page_section front_page_section_subscribe<?php
			$filmax_scheme = filmax_get_theme_option('front_page_subscribe_scheme');
			if (!filmax_is_inherit($filmax_scheme)) echo ' scheme_'.esc_attr($filmax_scheme);
			echo ' front_page_section_paddings_'.esc_attr(filmax_get_theme_option('front_page_subscribe_paddings'));
		?>"<?php
		$filmax_css = '';
		$filmax_bg_image = filmax_get_theme_option('front_page_subscribe_bg_image');
		if (!empty($filmax_bg_image)) 
			$filmax_css .= 'background-image: url('.esc_url(filmax_get_attachment_url($filmax_bg_image)).');';
		if (!empty($filmax_css))
			echo ' style="' . esc_attr($filmax_css) . '"';
?>><?php
	// Add anchor
	$filmax_anchor_icon = filmax_get_theme_option('front_page_subscribe_anchor_icon');	
	$filmax_anchor_text = filmax_get_theme_option('front_page_subscribe_anchor_text');	
	if ((!empty($filmax_anchor_icon) || !empty($filmax_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_subscribe"'
										. (!empty($filmax_anchor_icon) ? ' icon="'.esc_attr($filmax_anchor_icon).'"' : '')
										. (!empty($filmax_anchor_text) ? ' title="'.esc_attr($filmax_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_subscribe_inner<?php
			if (filmax_get_theme_option('front_page_subscribe_fullheight'))
				echo ' filmax-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$filmax_css = '';
			$filmax_bg_mask = filmax_get_theme_option('front_page_subscribe_bg_mask');
			$filmax_bg_color = filmax_get_theme_option('front_page_subscribe_bg_color');
			if (!empty($filmax_bg_color) && $filmax_bg_mask > 0)
				$filmax_css .= 'background-color: '.esc_attr($filmax_bg_mask==1
																	? $filmax_bg_color
																	: filmax_hex2rgba($filmax_bg_color, $filmax_bg_mask)
																).';';
			if (!empty($filmax_css))
				echo ' style="' . esc_attr($filmax_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_subscribe_content_wrap content_wrap">
			<?php
			// Caption
			$filmax_caption = filmax_get_theme_option('front_page_subscribe_caption');
			if (!empty($filmax_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_subscribe_caption front_page_block_<?php echo !empty($filmax_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($filmax_caption, 'filmax_kses_content' ); ?></h2><?php
			}
		
			// Description (text)
			$filmax_description = filmax_get_theme_option('front_page_subscribe_description');
			if (!empty($filmax_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_subscribe_description front_page_block_<?php echo !empty($filmax_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($filmax_description), 'filmax_kses_content' ); ?></div><?php
			}
			
			// Content
			$filmax_sc = filmax_get_theme_option('front_page_subscribe_shortcode');
			if (!empty($filmax_sc) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_output front_page_section_subscribe_output front_page_block_<?php echo !empty($filmax_sc) ? 'filled' : 'empty'; ?>"><?php
					filmax_show_layout(do_shortcode($filmax_sc));
				?></div><?php
			}
			?>
		</div>
	</div>
</div>