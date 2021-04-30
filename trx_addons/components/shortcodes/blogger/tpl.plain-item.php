<?php
/**
 * The style "plain" of the Blogger
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4.3
 */

$args = get_query_var('trx_addons_args_sc_blogger');
if ($args['slider']) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}
$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$post_link = get_permalink();
$post_title = get_the_title();
?><div <?php post_class( 'sc_blogger_item post_format_'.esc_attr($post_format) ); ?>><?php
	// Post content
	?><div class="sc_blogger_item_content entry-content"><?php
		filmax_show_post_featured(array(
				'thumb_size' => apply_filters('filmax_filter_related_thumb_size', filmax_get_thumb_size( 'height' )),
				'post_info' => '<div class="post_header entry-header">'
					. '<h6 class="sc_blogger_item_title entry-title"><a href="'.esc_url($post_link).'">'.esc_html(get_the_title()).'</a></h6>'
					. '<div class="sc_blogger_post_categories">'.wp_kses(filmax_get_post_categories(', '), 'filmax_kses_content' ).'</div></div>',
				'hover' => 'simple',
				'singular' => false,
			)
		);
	?></div><!-- .entry-content --><?php
?></div><!-- .sc_blogger_item --><?php

if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}
?>