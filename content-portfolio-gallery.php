<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

$filmax_blog_style = explode('_', filmax_get_theme_option('blog_style'));
$filmax_columns = empty($filmax_blog_style[1]) ? 2 : max(2, $filmax_blog_style[1]);
$filmax_post_format = get_post_format();
$filmax_post_format = empty($filmax_post_format) ? 'standard' : str_replace('post-format-', '', $filmax_post_format);
$filmax_animation = filmax_get_theme_option('blog_animation');
$filmax_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($filmax_columns).' post_format_'.esc_attr($filmax_post_format) ); ?>
	<?php echo (!filmax_is_off($filmax_animation) ? ' data-animation="'.esc_attr(filmax_get_animation_classes($filmax_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($filmax_image[1]) && !empty($filmax_image[2])) echo intval($filmax_image[1]) .'x' . intval($filmax_image[2]); ?>"
	data-src="<?php if (!empty($filmax_image[0])) echo esc_url($filmax_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$filmax_image_hover = 'icon';
	if (in_array($filmax_image_hover, array('icons', 'zoom'))) $filmax_image_hover = 'dots';
	$filmax_components = filmax_array_get_keys_by_value(filmax_get_theme_option('meta_parts'));
	$filmax_counters = filmax_array_get_keys_by_value(filmax_get_theme_option('counters'));
	filmax_show_post_featured(array(
		'hover' => $filmax_image_hover,
		'thumb_size' => filmax_get_thumb_size( strpos(filmax_get_theme_option('body_style'), 'full')!==false || $filmax_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($filmax_components)
										? filmax_show_post_meta(apply_filters('filmax_filter_post_meta_args', array(
											'components' => $filmax_components,
											'counters' => $filmax_counters,
											'seo' => false,
											'echo' => false
											), $filmax_blog_style[0], $filmax_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'filmax') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>