<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

$filmax_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$filmax_post_format = get_post_format();
$filmax_post_format = empty($filmax_post_format) ? 'standard' : str_replace('post-format-', '', $filmax_post_format);
$filmax_animation = filmax_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($filmax_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($filmax_post_format) ); ?>
	<?php echo (!filmax_is_off($filmax_animation) ? ' data-animation="'.esc_attr(filmax_get_animation_classes($filmax_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	filmax_show_post_featured(array(
		'thumb_size' => filmax_get_thumb_size($filmax_columns==1 ? 'big' : ($filmax_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($filmax_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			filmax_show_post_meta(apply_filters('filmax_filter_post_meta_args', array(), 'sticky', $filmax_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>