<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.10
 */

?>
<footer class="footer_wrap footer_default<?php
				if (!filmax_is_inherit(filmax_get_theme_option('footer_scheme')))
					echo ' scheme_' . esc_attr(filmax_get_theme_option('footer_scheme'));
				?>">
	<?php

	// Footer widgets area
	get_template_part( 'templates/footer-widgets' );

	// Logo
	get_template_part( 'templates/footer-logo' );

	// Socials
	get_template_part( 'templates/footer-socials' );

	// Copyright area
	get_template_part( 'templates/footer-copyright' );
	
	?>
</footer><!-- /.footer_wrap -->
