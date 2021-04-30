<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.10
 */

// Logo
if (filmax_is_on(filmax_get_theme_option('logo_in_footer'))) {
	$filmax_logo_image = '';
	if (filmax_is_on(filmax_get_theme_option('logo_retina_enabled')) && filmax_get_retina_multiplier() > 1)
		$filmax_logo_image = filmax_get_theme_option( 'logo_footer_retina' );
	if (empty($filmax_logo_image)) 
		$filmax_logo_image = filmax_get_theme_option( 'logo_footer' );
	$filmax_logo_text   = get_bloginfo( 'name' );
	if (!empty($filmax_logo_image) || !empty($filmax_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($filmax_logo_image)) {
					$filmax_attr = filmax_getimagesize($filmax_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($filmax_logo_image).'" class="logo_footer_image" alt="'.esc_attr__('logo', 'filmax').'"'.(!empty($filmax_attr[3]) ? ' ' . wp_kses_data($filmax_attr[3]) : '').'></a>' ;
				} else if (!empty($filmax_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($filmax_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>