<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.10
 */

// Footer sidebar
$filmax_footer_name = filmax_get_theme_option('footer_widgets');
$filmax_footer_present = !filmax_is_off($filmax_footer_name) && is_active_sidebar($filmax_footer_name);
if ($filmax_footer_present) { 
	filmax_storage_set('current_sidebar', 'footer');
	$filmax_footer_wide = filmax_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($filmax_footer_name) ) {
		dynamic_sidebar($filmax_footer_name);
	}
	$filmax_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($filmax_out)) {
		$filmax_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $filmax_out);
		$filmax_need_columns = true;	//or check: strpos($filmax_out, 'columns_wrap')===false;
		if ($filmax_need_columns) {
			$filmax_columns = max(0, (int) filmax_get_theme_option('footer_columns'));
			if ($filmax_columns == 0) $filmax_columns = min(4, max(1, substr_count($filmax_out, '<aside ')));
			if ($filmax_columns > 1)
				$filmax_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($filmax_columns).' widget', $filmax_out);
			else
				$filmax_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($filmax_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$filmax_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($filmax_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'filmax_action_before_sidebar' );
				filmax_show_layout($filmax_out);
				do_action( 'filmax_action_after_sidebar' );
				if ($filmax_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$filmax_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>