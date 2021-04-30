<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

$filmax_link = get_permalink();
$filmax_post_format = get_post_format();
$filmax_post_format = empty($filmax_post_format) ? 'standard' : str_replace('post-format-', '', $filmax_post_format);
$post_comments = get_comments_number();
?><div id="post-<?php the_ID(); ?>"
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($filmax_post_format) ); ?>><?php
	filmax_show_post_featured(array(
		'thumb_size' => apply_filters('filmax_filter_related_thumb_size', filmax_get_thumb_size( (int) filmax_get_theme_option('related_posts') == 1 ? 'huge' : 'square' )),
		'show_no_image' => filmax_get_theme_setting('allow_no_image'),
		'singular' => false,
		'post_info' => '<div class="post_header entry-header">'
							. '<div class="post_categories">'.wp_kses(filmax_get_post_categories(', '), 'filmax_kses_content' ).'</div>'
							. '<h6 class="post_title entry-title"><a href="'.esc_url($filmax_link).'">'.esc_html(get_the_title()).'</a></h6>'
							. (in_array(get_post_type(), array('post', 'attachment'))
									? '<span class="post_date"><a href="'.esc_url($filmax_link).'">'.esc_html__('on ','filmax').wp_kses_data(filmax_get_date()).'</a></span>'
									.'<a href="'.esc_url(get_comments_link()).'" class="post_counters_comments icon-comment-light"><span class="post_counters_number">'.esc_html($post_comments).'</span></a>'
							: '')
						. '</div>'
		)
	);
?></div>