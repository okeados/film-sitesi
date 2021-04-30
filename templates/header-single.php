<?php
/**
 * The template to display the featured image in the single post
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

if ( get_query_var('filmax_header_image')=='' && is_singular() && has_post_thumbnail() && in_array(get_post_type(), array('post', 'page')) )  {
	$filmax_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if (!empty($filmax_src[0])) {
		filmax_sc_layouts_showed('featured', true);
		?><div class="sc_layouts_featured with_image without_content <?php echo esc_attr(filmax_add_inline_css_class('background-image:url('.esc_url($filmax_src[0]).');')); ?>"></div><?php
	}
}
?>