<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.10
 */


// Socials
if ( filmax_is_on(filmax_get_theme_option('socials_in_footer')) && ($filmax_output = filmax_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php filmax_show_layout($filmax_output); ?>
		</div>
	</div>
	<?php
}
?>