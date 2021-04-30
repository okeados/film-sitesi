<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

$filmax_post_id    = get_the_ID();
$filmax_post_date  = filmax_get_date();
$filmax_post_title = get_the_title();
$filmax_post_link  = get_permalink();
$filmax_post_author_id   = get_the_author_meta('ID');
$filmax_post_author_name = get_the_author_meta('display_name');
$filmax_post_author_url  = get_author_posts_url($filmax_post_author_id, '');

$filmax_args = get_query_var('filmax_args_widgets_posts');
$filmax_show_date = isset($filmax_args['show_date']) ? (int) $filmax_args['show_date'] : 1;
$filmax_show_image = isset($filmax_args['show_image']) ? (int) $filmax_args['show_image'] : 1;
$filmax_show_author = isset($filmax_args['show_author']) ? (int) $filmax_args['show_author'] : 1;
$filmax_show_counters = isset($filmax_args['show_counters']) ? (int) $filmax_args['show_counters'] : 1;
$filmax_show_categories = isset($filmax_args['show_categories']) ? (int) $filmax_args['show_categories'] : 1;

$filmax_output = filmax_storage_get('filmax_output_widgets_posts');

$filmax_post_counters_output = '';
if ( $filmax_show_counters ) {
	$filmax_post_counters_output = '<span class="post_info_item post_info_counters">'
								. filmax_get_post_counters('comments')
							. '</span>';
}


$filmax_output .= '<article class="post_item with_thumb">';

if ($filmax_show_image) {
	$filmax_post_thumb = get_the_post_thumbnail($filmax_post_id, filmax_get_thumb_size('tiny'), array(
		'alt' => the_title_attribute( array( 'echo' => false ) )
	));
	if ($filmax_post_thumb) $filmax_output .= '<div class="post_thumb">' . ($filmax_post_link ? '<a href="' . esc_url($filmax_post_link) . '">' : '') . ($filmax_post_thumb) . ($filmax_post_link ? '</a>' : '') . '</div>';
}

$filmax_output .= '<div class="post_content">'
			. ($filmax_show_categories 
					? '<div class="post_categories">'
						. filmax_get_post_categories()
						. $filmax_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($filmax_post_link ? '<a href="' . esc_url($filmax_post_link) . '">' : '') . ($filmax_post_title) . ($filmax_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('filmax_filter_get_post_info', 
								'<div class="post_info">'
									. ($filmax_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($filmax_post_link ? '<a href="' . esc_url($filmax_post_link) . '" class="post_info_date">' : '')
											. esc_html__('on', 'filmax') . ' '
											. esc_html($filmax_post_date)
											. ($filmax_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($filmax_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'filmax') . ' ' 
											. ($filmax_post_link ? '<a href="' . esc_url($filmax_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($filmax_post_author_name) 
											. ($filmax_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$filmax_show_categories && $filmax_post_counters_output
										? $filmax_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
filmax_storage_set('filmax_output_widgets_posts', $filmax_output);
?>