<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

// Header sidebar
$filmax_header_name = filmax_get_theme_option('header_widgets');
$filmax_header_present = !filmax_is_off($filmax_header_name) && is_active_sidebar($filmax_header_name);
if ($filmax_header_present) { 
	filmax_storage_set('current_sidebar', 'header');
	$filmax_header_wide = filmax_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($filmax_header_name) ) {
		dynamic_sidebar($filmax_header_name);
	}
	$filmax_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($filmax_widgets_output)) {
		$filmax_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $filmax_widgets_output);
		$filmax_need_columns = strpos($filmax_widgets_output, 'columns_wrap')===false;
		if ($filmax_need_columns) {
			$filmax_columns = max(0, (int) filmax_get_theme_option('header_columns'));
			if ($filmax_columns == 0) $filmax_columns = min(6, max(1, substr_count($filmax_widgets_output, '<aside ')));
			if ($filmax_columns > 1)
				$filmax_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($filmax_columns).' widget', $filmax_widgets_output);
			else
				$filmax_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($filmax_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$filmax_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($filmax_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'filmax_action_before_sidebar' );
				filmax_show_layout($filmax_widgets_output);
				do_action( 'filmax_action_after_sidebar' );
				if ($filmax_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$filmax_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>