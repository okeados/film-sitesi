<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

if (filmax_sidebar_present()) {
	ob_start();
	$filmax_sidebar_name = filmax_get_theme_option('sidebar_widgets');
	filmax_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($filmax_sidebar_name) ) {
		dynamic_sidebar($filmax_sidebar_name);
	}
	$filmax_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($filmax_out)) {
		$filmax_sidebar_position = filmax_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($filmax_sidebar_position); ?> widget_area<?php if (!filmax_is_inherit(filmax_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(filmax_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'filmax_action_before_sidebar' );
				filmax_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $filmax_out));
				do_action( 'filmax_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>