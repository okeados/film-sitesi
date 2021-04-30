<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js scheme_<?php
										 // Class scheme_xxx need in the <html> as context for the <body>!
										 echo esc_attr(filmax_get_theme_option('color_scheme'));
										 ?>">
<head>
	<?php wp_head(); ?>
</head>

<body <?php	body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php do_action( 'filmax_action_before_body' ); ?>

	<div class="body_wrap">

		<div class="page_wrap"><?php
			
			// Desktop header
			$filmax_header_type = filmax_get_theme_option("header_type");
			if ($filmax_header_type == 'custom' && !filmax_is_layouts_available())
				$filmax_header_type = 'default';
			get_template_part( "templates/header-{$filmax_header_type}");

			// Side menu
			if (in_array(filmax_get_theme_option('menu_style'), array('left', 'right'))) {
				get_template_part( 'templates/header-navi-side' );
			}
			
			// Mobile menu
			get_template_part( 'templates/header-navi-mobile');
			?>

			<div class="page_content_wrap">

				<?php if (filmax_get_theme_option('body_style') != 'fullscreen') { ?>
				<div class="content_wrap">
				<?php } ?>

					<?php
					// Widgets area above page content
					filmax_create_widgets_area('widgets_above_page');
					?>				

					<div class="content">
						<?php
						// Widgets area inside page content
						filmax_create_widgets_area('widgets_above_content');
						?>				
