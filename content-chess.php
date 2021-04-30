<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

$filmax_blog_style = explode('_', filmax_get_theme_option('blog_style'));
$filmax_columns = empty($filmax_blog_style[1]) ? 1 : max(1, $filmax_blog_style[1]);
$filmax_expanded = !filmax_sidebar_present() && filmax_is_on(filmax_get_theme_option('expand_content'));
$filmax_post_format = get_post_format();
$filmax_post_format = empty($filmax_post_format) ? 'standard' : str_replace('post-format-', '', $filmax_post_format);
$filmax_animation = filmax_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($filmax_columns).' post_format_'.esc_attr($filmax_post_format) ); ?>
	<?php echo (!filmax_is_off($filmax_animation) ? ' data-animation="'.esc_attr(filmax_get_animation_classes($filmax_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($filmax_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode( '[trx_sc_anchor id="post_' . esc_attr( get_the_ID() ) . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '" icon="' . esc_attr( filmax_get_post_icon() ) . '"]' );
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	filmax_show_post_featured( array(
											'class' => $filmax_columns == 1 ? 'filmax-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => filmax_get_thumb_size(
																	strpos(filmax_get_theme_option('body_style'), 'full')!==false
																		? ( $filmax_columns > 1 ? 'huge' : 'original' )
																		: (	$filmax_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('filmax_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('filmax_action_before_post_meta'); 

			// Post meta
			$filmax_components = filmax_array_get_keys_by_value(filmax_get_theme_option('meta_parts'));
			$filmax_counters = filmax_array_get_keys_by_value(filmax_get_theme_option('counters'));
			$filmax_post_meta = empty($filmax_components) 
										? '' 
										: filmax_show_post_meta(apply_filters('filmax_filter_post_meta_args', array(
												'components' => $filmax_components,
												'counters' => $filmax_counters,
												'seo' => false,
												'echo' => false
												), $filmax_blog_style[0], $filmax_columns)
											);
			filmax_show_layout($filmax_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$filmax_show_learn_more = !in_array($filmax_post_format, array('link', 'aside', 'status', 'quote'));
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
				?>
			</div>
			<?php
			// Post meta
			if (in_array($filmax_post_format, array('link', 'aside', 'status', 'quote'))) {
				filmax_show_layout($filmax_post_meta);
			}
			// More button
			if ( $filmax_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'filmax'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>