<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap<?php
				if (!filmax_is_inherit(filmax_get_theme_option('copyright_scheme')))
					echo ' scheme_' . esc_attr(filmax_get_theme_option('copyright_scheme'));
 				?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$filmax_copyright = filmax_prepare_macros(filmax_get_theme_option('copyright'));
				if (!empty($filmax_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $filmax_copyright, $filmax_matches)) {
						$filmax_copyright = str_replace($filmax_matches[1], date_i18n(str_replace(array('{', '}'), '', $filmax_matches[1])), $filmax_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($filmax_copyright));
				}
			?></div>
		</div>
	</div>
</div>
