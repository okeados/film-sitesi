<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$filmax_content = '';
$filmax_blog_archive_mask = '%%CONTENT%%';
$filmax_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $filmax_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($filmax_content = apply_filters('the_content', get_the_content())) != '') {
		if (($filmax_pos = strpos($filmax_content, $filmax_blog_archive_mask)) !== false) {
			$filmax_content = preg_replace('/(\<p\>\s*)?'.$filmax_blog_archive_mask.'(\s*\<\/p\>)/i', $filmax_blog_archive_subst, $filmax_content);
		} else
			$filmax_content .= $filmax_blog_archive_subst;
		$filmax_content = explode($filmax_blog_archive_mask, $filmax_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) filmax_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$filmax_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$filmax_args = filmax_query_add_posts_and_cats($filmax_args, '', filmax_get_theme_option('post_type'), filmax_get_theme_option('parent_cat'));
$filmax_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($filmax_page_number > 1) {
	$filmax_args['paged'] = $filmax_page_number;
	$filmax_args['ignore_sticky_posts'] = true;
}
$filmax_ppp = filmax_get_theme_option('posts_per_page');
if ((int) $filmax_ppp != 0)
	$filmax_args['posts_per_page'] = (int) $filmax_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($filmax_args);


// Add internal query vars in the new query!
if (is_array($filmax_content) && count($filmax_content) == 2) {
	set_query_var('blog_archive_start', $filmax_content[0]);
	set_query_var('blog_archive_end', $filmax_content[1]);
}

get_template_part('index');
?>