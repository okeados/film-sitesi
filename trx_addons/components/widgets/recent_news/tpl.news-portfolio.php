<?php
/**
 * The "Portfolio" template to show post's content
 *
 * Used in the widget Recent News.
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */
 
$widget_args = get_query_var('trx_addons_args_recent_news');
$style = $widget_args['style'];
$number = $widget_args['number'];
$count = $widget_args['count'];
$columns = $widget_args['columns'];
$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$animation = apply_filters('trx_addons_blog_animation', '');

$video = '';
$output_video ='';
if ($post_format == 'video') {
	$post_content = '';

    $video = filmax_get_post_video($post_content, false);
    if (empty($video))
    $video = filmax_get_post_iframe($post_content, false);


	if (!empty($video)) {
		$args = array(
			'link' => $video,               // Link to the video on Youtube or Vimeo
			'popup' => true,                // Open video in the popup window or insert instead cover image (default)
		);

		$args['id'] = 'sc_video_' . str_replace('.', '', mt_rand());
		$output_video = '<div id="' . esc_attr($args['id']) . '"'
			. ' class="trx_addons_video_player'
			. ' hover_play'
			. '"'
			. '>';

		$args['embed'] = $video;

		$output_video .= apply_filters('trx_addons_filter_video_mask',
			($args['popup']
				? '<a class="post_link trx_addons_popup_link" href="#' . esc_attr($args['id']) . '_popup">'.esc_html__('watch trailer','filmax').'</a>'
				: ''
			),
			$args);
		$output_video .= '</div>';

		// Add popup
		if (!empty($args['popup'])) {
			$output_video .= '<!-- .sc_popup --><div id="' . esc_attr($args['id']) . '_popup" class="sc_popup">'
				. '<div id="' . esc_attr($args['id']) . '_popup_player"'
				. ' class="trx_addons_video_player without_cover'
				. (!empty($args['class']) ? ' ' . esc_attr($args['class']) : '')
				. '"'
				. '>'
				. '<div class="video_embed video_frame">'
				. $args['embed']
				. '</div>'
				. '</div>'
				. '</div>';
		}
	}
}


if ($columns > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $columns)); ?>"><?php
}
?><article
	<?php post_class( 'post_item post_layout_'.esc_attr($style).' post_format_'.esc_attr($post_format) ); ?>
	<?php echo (!empty($animation) ? ' data-animation="'.esc_attr($animation).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}
	
	trx_addons_get_template_part('templates/tpl.featured.php',
								'trx_addons_args_featured',
								apply_filters('trx_addons_filter_args_featured', array(
												'post_info' => '<div class="post_info_hover">'
																. '<h5 class="post_title entry-title"><a href="'.esc_url(get_permalink()).'" rel="bookmark">'.wp_kses_post( get_the_title() ).'</a></h5>'
																. '<span class="post_categories_info">'.trx_addons_get_post_categories(' ').'</span>'
																. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
																		? '<div class="post_link_wrap">'
																		. (!empty($video) ? $output_video : '')
																		. '<a class="post_link" href="'.esc_url(get_permalink()).'">'.esc_html__('more information','filmax').'</a>'
																		. '</div>'
																		: '')
																. '</div>',
												'thumb_size' => filmax_get_thumb_size('height')
												), 'recent_news-portfolio')
							);
?>
</article><?php

if ($columns > 1) {
	?></div><?php
}
?>