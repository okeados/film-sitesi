<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('filmax_wpml_get_css')) {
	add_filter('filmax_filter_get_css', 'filmax_wpml_get_css', 10, 4);
	function filmax_wpml_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

CSS;
		}

		return $css;
	}
}
?>