<?php
/**
 * The style "default" of the Blogger
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
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

$video = '';
$output_video ='';
if ($post_format == 'video') {
	$post_content = '';

    $video = filmax_get_post_video($post_content, false);
    if (empty($video))
    $video = filmax_get_post_iframe($post_content, false);


    if (!empty($video)) {
		$args2 = array(
			'link' => $video,               // Link to the video on Youtube or Vimeo
			'popup' => true,                // Open video in the popup window or insert instead cover image (default)
		);

		$args2['id'] = 'sc_video_' . str_replace('.', '', mt_rand());
		$output_video = '<div id="' . esc_attr($args2['id']) . '"'
			. ' class="trx_addons_video_player'
			. ' hover_play'
			. '"'
			. '>';

        $args2['embed'] = $video;
		$output_video .='<a class="post_link trx_addons_popup_link" href="#' . esc_attr($args2['id']) . '_popup"></a>';
		$output_video .= '</div>';

		// Add popup
		if (!empty($args2['popup'])) {
			$output_video .= '<!-- .sc_popup --><div id="' . esc_attr($args2['id']) . '_popup" class="sc_popup">'
				. '<div id="' . esc_attr($args2['id']) . '_popup_player"'
				. ' class="trx_addons_video_player without_cover'
				. (!empty($args2['class']) ? ' ' . esc_attr($args2['class']) : '')
				. '"'
				. '>'
				. '<div class="video_embed video_frame">'
				. $args2['embed']
				. '</div>'
				. '</div>'
				. '</div>';
		}
	}
}






?><div <?php post_class( 'sc_blogger_item post_format_'.esc_attr($post_format) ); ?>><?php

	// Featured image
	trx_addons_get_template_part('templates/tpl.featured.php',
									'trx_addons_args_featured',
									apply_filters('trx_addons_filter_args_featured', array(
														'class' => 'sc_blogger_item_featured',
														'hover' => 'simple',
														'post_info' =>
															( in_array( get_post_type(), array( 'post', 'attachment' ) )
																? '<div class="post_link_wrap_hover">'
																. (!empty($video) ? $output_video : '')
																. '<a class="post_link" href="'.esc_url(get_permalink()).'"></a>'
																. '</div>'
																: ''),
														'thumb_size' => filmax_get_thumb_size($args['columns'] > 3 ? 'height-extra' : 'square'),
														), 'blogger-default')
								);

	// Post content
	?><div class="sc_blogger_item_content entry-content"><?php

		// Post title
		if ( !in_array($post_format, array('link', 'aside', 'status', 'quote')) ) {
			?><div class="sc_blogger_item_header entry-header"><?php 
				// Post title
				the_title( sprintf( '<h5 class="sc_blogger_item_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
				// Post meta
				trx_addons_sc_show_post_meta('sc_blogger', apply_filters('trx_addons_filter_show_post_meta', array(
					'components' => 'categories'
					), 'sc_blogger_default', $args['columns'])
				);
			?></div><!-- .entry-header --><?php
		}		

		// Post content
		if (false && ( !isset($args['hide_excerpt']) || $args['hide_excerpt']==0 )) {
			?><div class="sc_blogger_item_excerpt">
				<div class="sc_blogger_item_excerpt_text">
					<?php
					$show_more = !in_array($post_format, array('link', 'aside', 'status', 'quote'));
					if (has_excerpt()) {
						the_excerpt();
					} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
						the_content( '' );
					} else if (!$show_more) {
						the_content();
					} else {
						the_excerpt();
					}
					?>
				</div>
				<?php
				// Post meta
				if (in_array($post_format, array('link', 'aside', 'status', 'quote'))) {
					trx_addons_sc_show_post_meta('sc_blogger', apply_filters('trx_addons_filter_show_post_meta', array(
						'components' => 'date'
						), 'sc_blogger_default', $args['columns'])
					);
				}
				// More button
				if ( $show_more ) {
					?><div class="sc_blogger_item_button sc_item_button"><a href="<?php echo esc_url($post_link); ?>" class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_button sc_button_simple', 'sc_blogger', $args)); ?>"><?php esc_html_e('Read more', 'filmax'); ?></a></div><?php
				}
			?></div><!-- .sc_blogger_item_excerpt --><?php
		}
		
	?></div><!-- .entry-content --><?php
	
?></div><!-- .sc_blogger_item --><?php

if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}
?>