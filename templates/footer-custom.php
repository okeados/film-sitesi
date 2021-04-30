<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.10
 */

$filmax_footer_id = str_replace('footer-custom-', '', filmax_get_theme_option("footer_style"));
if ((int) $filmax_footer_id == 0) {
	$filmax_footer_id = filmax_get_post_id(array(
												'name' => $filmax_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$filmax_footer_id = apply_filters('filmax_filter_get_translated_layout', $filmax_footer_id);
}
$filmax_footer_meta = get_post_meta($filmax_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($filmax_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($filmax_footer_id))); 
						if (!empty($filmax_footer_meta['margin']) != '') 
							echo ' '.esc_attr(filmax_add_inline_css_class('margin-top: '.filmax_prepare_css_value($filmax_footer_meta['margin']).';'));
						if (!filmax_is_inherit(filmax_get_theme_option('footer_scheme')))
							echo ' scheme_' . esc_attr(filmax_get_theme_option('footer_scheme'));
						?>">
	<?php
    // Custom footer's layout
    do_action('filmax_action_show_layout', $filmax_footer_id);
	?>
</footer><!-- /.footer_wrap -->
