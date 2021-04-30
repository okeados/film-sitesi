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
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($filmax_post_format) ); ?>
	<?php echo (!filmax_is_off($filmax_animation) ? ' data-animation="'.esc_attr(filmax_get_animation_classes($filmax_animation)).'"' : ''); ?>
	><?php
	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}
	// Featured image
	filmax_show_post_featured(array( 'thumb_size' => filmax_get_thumb_size( strpos(filmax_get_theme_option('body_style'), 'full')!==false ? 'med' : 'med' ) ));

	?><div class="go_wrap"><?php

	// Title and post meta
	if (get_the_title() != '') {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			$filmax_components = filmax_array_get_keys_by_value(filmax_get_theme_option('meta_parts'));
			if (!empty($filmax_components))
				filmax_show_post_meta(apply_filters('filmax_filter_post_meta_args', array(
						'components' => $filmax_components,
						'counters' => '',
						'seo' => false
					), 'excerpt', 1)
			);

			do_action('filmax_action_before_post_title');
			// Post title
			the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (filmax_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'filmax' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'filmax' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$filmax_show_learn_more = false;

			// Post content area
			?><div class="post_content_inner"><?php
				if (has_excerpt()) {
					the_excerpt();
				} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
					the_content( '' );
				} else if (in_array($filmax_post_format, array('link', 'aside', 'status'))) {
					the_content();
				} else if ($filmax_post_format == 'quote') {
					if (($quote = filmax_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
						filmax_show_layout(wpautop($quote));
					else
						the_excerpt();
				} else if (substr(get_the_content(), 0, 1)!='[') {
					the_excerpt();
				}
			?></div><?php
			// More button
			if ( $filmax_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'filmax'); ?></a></p><?php
			}
		}



		do_action('filmax_action_before_post_meta');
		// Post meta
		$filmax_components = filmax_array_get_keys_by_value(filmax_get_theme_option('meta_parts'));
		$filmax_counters = filmax_array_get_keys_by_value(filmax_get_theme_option('counters'));
		if (!empty($filmax_components))
			filmax_show_post_meta(apply_filters('filmax_filter_post_meta_args', array(
					'components' => $filmax_components,
					'counters' => $filmax_counters,
					'seo' => false
				), 'excerpt', 1)
			);



	?></div><!-- .entry-content -->
	</div>
</article>