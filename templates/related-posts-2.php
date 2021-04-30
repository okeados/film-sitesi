<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

$filmax_link = get_permalink();
$filmax_post_format = get_post_format();
$filmax_post_format = empty($filmax_post_format) ? 'standard' : str_replace('post-format-', '', $filmax_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_2 post_format_'.esc_attr($filmax_post_format) ); ?>><?php
	filmax_show_post_featured(array(
		'thumb_size' => apply_filters('filmax_filter_related_thumb_size', filmax_get_thumb_size( (int) filmax_get_theme_option('related_posts') == 1 ? 'huge' : 'big' )),
		'show_no_image' => filmax_get_theme_setting('allow_no_image'),
		'singular' => false
		)
	);
	?><div class="post_header entry-header"><?php
		if ( in_array(get_post_type(), array( 'post', 'attachment' ) ) ) {
			?><span class="post_date"><a href="<?php echo esc_url($filmax_link); ?>"><?php echo wp_kses_data(filmax_get_date()); ?></a></span><?php
		}
		?>
		<h6 class="post_title entry-title"><a href="<?php echo esc_url($filmax_link); ?>"><?php the_title(); ?></a></h6>
	</div>
</div>