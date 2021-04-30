<?php
/**
 * The template to show mobile header
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.39
 */

// Additional info
if (filmax_is_off(filmax_get_theme_option('header_mobile_hide_info')) && ($filmax_info=filmax_get_theme_option('header_mobile_additional_info'))!='') {
	?><div class="top_panel_mobile_info sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_delimiter sc_layouts_hide_on_desktop sc_layouts_hide_on_notebook sc_layouts_hide_on_tablet">
		<div class="content_wrap">
			<div class="columns_wrap">
				<div class="sc_layouts_column sc_layouts_column_align_center sc_layouts_column_icons_position_left column-1_1"><?php
					?><div class="sc_layouts_item"><?php
						filmax_show_layout($filmax_info);
					?></div><!-- /.sc_layouts_item -->
				</div><!-- /.sc_layouts_column -->
			</div><!-- /.columns_wrap -->
		</div><!-- /.content_wrap -->
	</div><!-- /.sc_layouts_row --><?php
}

// Logo, menu and buttons
?><div class="top_panel_mobile_navi sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_delimiter sc_layouts_row_fixed sc_layouts_row_fixed_always sc_layouts_hide_on_desktop sc_layouts_hide_on_notebook sc_layouts_hide_on_tablet">
	<div class="content_wrap">
		<div class="columns_wrap columns_fluid">
			<div class="sc_layouts_column sc_layouts_column_align_left sc_layouts_column_icons_position_left sc_layouts_column_fluid column-1_3"><?php
				// Logo
				if (filmax_is_off(filmax_get_theme_option('header_mobile_hide_logo'))) {
					?><div class="sc_layouts_item"><?php
						set_query_var('filmax_logo_args', array('type' => 'mobile_header'));
						get_template_part( 'templates/header-logo' );
						set_query_var('filmax_logo_args', array());
					?></div><?php
				}
			?></div><?php
			
			// Attention! Don't place any spaces between columns!
			?><div class="sc_layouts_column sc_layouts_column_align_right sc_layouts_column_icons_position_left sc_layouts_column_fluid  column-2_3"><?php
				if (filmax_exists_trx_addons()) {
					// Display login/logout
					if (filmax_is_off(filmax_get_theme_option('header_mobile_hide_login'))) {
						ob_start();
						do_action('filmax_action_login', array('text_login' => false, 'text_logout' => false));
						$filmax_action_output = ob_get_contents();
						ob_end_clean();
						if (!empty($filmax_action_output)) {
							?><div class="sc_layouts_item sc_layouts_menu sc_layouts_menu_default"><?php
								filmax_show_layout($filmax_action_output);
							?></div><?php
						}
					}
					// Display cart button
					if (filmax_is_off(filmax_get_theme_option('header_mobile_hide_cart'))) {
						ob_start();
						do_action('filmax_action_cart');
						$filmax_action_output = ob_get_contents();
						ob_end_clean();
						if (!empty($filmax_action_output)) {
							?><div class="sc_layouts_item"><?php
								filmax_show_layout($filmax_action_output);
							?></div><?php
						}
					}
					// Display search field
					if (filmax_is_off(filmax_get_theme_option('header_mobile_hide_search'))) {
						ob_start();
						do_action('filmax_action_search', 'fullscreen', 'header_mobile_search', false);
						$filmax_action_output = ob_get_contents();
						ob_end_clean();
						if (!empty($filmax_action_output)) {
							?><div class="sc_layouts_item"><?php
								filmax_show_layout($filmax_action_output);
							?></div><?php
						}
					}
				}

				// Mobile menu button
				?><div class="sc_layouts_item">
					<div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
						<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
							<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
						</a>
					</div>
				</div>
			</div><!-- /.sc_layouts_column -->
		</div><!-- /.columns_wrap -->
	</div><!-- /.content_wrap -->
</div><!-- /.sc_layouts_row --><?php
