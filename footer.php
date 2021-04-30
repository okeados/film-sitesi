<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

						// Widgets area inside page content
						filmax_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					filmax_create_widgets_area('widgets_below_page');

					$filmax_body_style = filmax_get_theme_option('body_style');
					if ($filmax_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$filmax_footer_type = filmax_get_theme_option("footer_type");
			if ($filmax_footer_type == 'custom' && !filmax_is_layouts_available())
				$filmax_footer_type = 'default';
			get_template_part( "templates/footer-{$filmax_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (filmax_is_on(filmax_get_theme_option('debug_mode')) && filmax_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(filmax_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>