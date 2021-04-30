<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($filmax_columns).' post_format_'.esc_attr($filmax_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!filmax_is_off($filmax_animation) ? ' data-animation="'.esc_attr(filmax_get_animation_classes($filmax_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$filmax_image_hover = filmax_get_theme_option('image_hover');
	// Featured image
	filmax_show_post_featured(array(
		'thumb_size' => filmax_get_thumb_size(strpos(filmax_get_theme_option('body_style'), 'full')!==false || $filmax_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $filmax_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $filmax_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>