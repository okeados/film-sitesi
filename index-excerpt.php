<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

filmax_storage_set('blog_archive', true);

get_header();
filmax_mod_pagination();
if (have_posts()) {

	filmax_show_layout(get_query_var('blog_archive_start'));

	?><div class="posts_container"><?php
	
	$filmax_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$filmax_sticky_out = filmax_get_theme_option('sticky_style')=='columns' 
							&& is_array($filmax_stickies) && count($filmax_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($filmax_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}

		// Big post
		if (
			has_post_thumbnail()
			&& !in_array(get_post_format(), array('link', 'aside', 'status', 'quote', 'audio', 'video', 'gallery'))
			&& !is_sticky()
			&& filmax_get_theme_option('first_post_large')
			&& !is_paged()
			&& !in_array(filmax_get_theme_option('body_style'), array('fullwide', 'fullscreen')))
		{
			the_post();
			get_template_part( 'content', 'big' );
		}


	while ( have_posts() ) { the_post(); 
		if ($filmax_sticky_out && !is_sticky()) {
			$filmax_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $filmax_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($filmax_sticky_out) {
		$filmax_sticky_out = false;
		?></div><?php
	}
	
	?></div><?php

	filmax_show_pagination();

	filmax_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>