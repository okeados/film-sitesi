<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

$filmax_args = get_query_var('filmax_logo_args');

// Site logo
$filmax_logo_type   = isset($filmax_args['type']) ? $filmax_args['type'] : '';
$filmax_logo_image  = filmax_get_logo_image($filmax_logo_type);
$filmax_logo_text   = filmax_is_on(filmax_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$filmax_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($filmax_logo_image) || !empty($filmax_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($filmax_logo_image)) {
			if (empty($filmax_logo_type) && function_exists('the_custom_logo') && (int) $filmax_logo_image > 0) {
				the_custom_logo();
			} else {
				$filmax_attr = filmax_getimagesize($filmax_logo_image);
				echo '<img src="'.esc_url($filmax_logo_image).'" alt="'.esc_attr__('logo', 'filmax').'"'.(!empty($filmax_attr[3]) ? ' '.wp_kses_data($filmax_attr[3]) : '').'>';
			}
		} else {
			filmax_show_layout(filmax_prepare_macros($filmax_logo_text), '<span class="logo_text">', '</span>');
			filmax_show_layout(filmax_prepare_macros($filmax_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>