<div class="front_page_section front_page_section_contacts<?php
			$filmax_scheme = filmax_get_theme_option('front_page_contacts_scheme');
			if (!filmax_is_inherit($filmax_scheme)) echo ' scheme_'.esc_attr($filmax_scheme);
			echo ' front_page_section_paddings_'.esc_attr(filmax_get_theme_option('front_page_contacts_paddings'));
		?>"<?php
		$filmax_css = '';
		$filmax_bg_image = filmax_get_theme_option('front_page_contacts_bg_image');
		if (!empty($filmax_bg_image)) 
			$filmax_css .= 'background-image: url('.esc_url(filmax_get_attachment_url($filmax_bg_image)).');';
		if (!empty($filmax_css))
			echo ' style="' . esc_attr($filmax_css) . '"';
?>><?php
	// Add anchor
	$filmax_anchor_icon = filmax_get_theme_option('front_page_contacts_anchor_icon');	
	$filmax_anchor_text = filmax_get_theme_option('front_page_contacts_anchor_text');	
	if ((!empty($filmax_anchor_icon) || !empty($filmax_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_contacts"'
										. (!empty($filmax_anchor_icon) ? ' icon="'.esc_attr($filmax_anchor_icon).'"' : '')
										. (!empty($filmax_anchor_text) ? ' title="'.esc_attr($filmax_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_contacts_inner<?php
			if (filmax_get_theme_option('front_page_contacts_fullheight'))
				echo ' filmax-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$filmax_css = '';
			$filmax_bg_mask = filmax_get_theme_option('front_page_contacts_bg_mask');
			$filmax_bg_color = filmax_get_theme_option('front_page_contacts_bg_color');
			if (!empty($filmax_bg_color) && $filmax_bg_mask > 0)
				$filmax_css .= 'background-color: '.esc_attr($filmax_bg_mask==1
																	? $filmax_bg_color
																	: filmax_hex2rgba($filmax_bg_color, $filmax_bg_mask)
																).';';
			if (!empty($filmax_css))
				echo ' style="' . esc_attr($filmax_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$filmax_caption = filmax_get_theme_option('front_page_contacts_caption');
			$filmax_description = filmax_get_theme_option('front_page_contacts_description');
			if (!empty($filmax_caption) || !empty($filmax_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($filmax_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo !empty($filmax_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses($filmax_caption, 'filmax_kses_content' );
					?></h2><?php
				}
			
				// Description
				if (!empty($filmax_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo !empty($filmax_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses(wpautop($filmax_description), 'filmax_kses_content' );
					?></div><?php
				}
			}

			// Content (text)
			$filmax_content = filmax_get_theme_option('front_page_contacts_content');
			$filmax_layout = filmax_get_theme_option('front_page_contacts_layout');
			if ($filmax_layout == 'columns' && (!empty($filmax_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ((!empty($filmax_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo !empty($filmax_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses($filmax_content, 'filmax_kses_content' );
				?></div><?php
			}

			if ($filmax_layout == 'columns' && (!empty($filmax_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div><div class="column-2_3"><?php
			}
		
			// Shortcode output
			$filmax_sc = filmax_get_theme_option('front_page_contacts_shortcode');
			if (!empty($filmax_sc) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo !empty($filmax_sc) ? 'filled' : 'empty'; ?>"><?php
					filmax_show_layout(do_shortcode($filmax_sc));
				?></div><?php
			}

			if ($filmax_layout == 'columns' && (!empty($filmax_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>