<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

$filmax_post_format = get_post_format();
$filmax_post_format = empty($filmax_post_format) ? 'standard' : str_replace('post-format-', '', $filmax_post_format);
$filmax_animation = filmax_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt first_big post_format_'.esc_attr($filmax_post_format) ); ?>
	<?php echo (!filmax_is_off($filmax_animation) ? ' data-animation="'.esc_attr(filmax_get_animation_classes($filmax_animation)).'"' : ''); ?>
	><?php
	// Post meta
	$info = '';
	$filmax_components = filmax_array_get_keys_by_value(filmax_get_theme_option('meta_parts'));
	if (!empty($filmax_components))
		$info = filmax_show_post_meta(apply_filters('filmax_filter_post_meta_args', array(
				'components' => $filmax_components,
				'counters' => '',
				'seo' => false,
				'echo' => false
			), 'excerpt', 1)
		);

	// Post meta second
	$info2 = '';
	$filmax_components = filmax_array_get_keys_by_value(filmax_get_theme_option('meta_parts'));
	$filmax_counters = filmax_array_get_keys_by_value(filmax_get_theme_option('counters'));
	if (!empty($filmax_components))
		$info2 = filmax_show_post_meta(apply_filters('filmax_filter_post_meta_args', array(
				'components' => $filmax_components,
				'counters' => $filmax_counters,
				'seo' => false,
				'echo' => false
			), 'excerpt', 1)
		);

	// Featured image
	filmax_show_post_featured(array(
		'hover' => 'simple',
		'thumb_bg' => true,
		'thumb_size' => filmax_get_thumb_size( strpos(filmax_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ),
		'post_info' => '<div class="post_header entry-header">'.$info.'<h2 class="post_title entry-title"><a href="'.esc_url( get_permalink() ).'">'.wp_kses_post( get_the_title() ).'</a></h2>'.$info2.'</div>'
	));
	?>
</article>