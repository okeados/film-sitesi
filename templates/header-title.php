<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

// Page (category, tag, archive, author) title

if ( filmax_need_page_title() ) {
	filmax_sc_layouts_showed('title', true);
	filmax_sc_layouts_showed('postmeta', false);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( false && is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								filmax_show_post_meta(apply_filters('filmax_filter_post_meta_args', array(
									'components' => filmax_array_get_keys_by_value(filmax_get_theme_option('meta_parts')),
									'counters' => filmax_array_get_keys_by_value(filmax_get_theme_option('counters')),
									'seo' => filmax_is_on(filmax_get_theme_option('seo_snippets'))
									), 'header', 1)
								);
							?></div><?php
						}
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$filmax_blog_title = filmax_get_blog_title();
							$filmax_blog_title_text = $filmax_blog_title_class = $filmax_blog_title_link = $filmax_blog_title_link_text = '';
							if (is_array($filmax_blog_title)) {
								$filmax_blog_title_text = $filmax_blog_title['text'];
								$filmax_blog_title_class = !empty($filmax_blog_title['class']) ? ' '.$filmax_blog_title['class'] : '';
								$filmax_blog_title_link = !empty($filmax_blog_title['link']) ? $filmax_blog_title['link'] : '';
								$filmax_blog_title_link_text = !empty($filmax_blog_title['link_text']) ? $filmax_blog_title['link_text'] : '';
							} else
								$filmax_blog_title_text = $filmax_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($filmax_blog_title_class); ?>"><?php
								$filmax_top_icon = filmax_get_category_icon();
								if (!empty($filmax_top_icon)) {
									$filmax_attr = filmax_getimagesize($filmax_top_icon);
									?><img src="<?php echo esc_url($filmax_top_icon); ?>" alt="'.esc_attr__('icon', 'filmax').'" <?php if (!empty($filmax_attr[3])) filmax_show_layout($filmax_attr[3]);?>><?php
								}
								echo wp_kses_post($filmax_blog_title_text);
							?></h1>
							<?php
							if (!empty($filmax_blog_title_link) && !empty($filmax_blog_title_link_text)) {
								?><a href="<?php echo esc_url($filmax_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($filmax_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'filmax_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>