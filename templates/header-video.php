<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.14
 */
$filmax_header_video = filmax_get_header_video();
$filmax_embed_video = '';
if (!empty($filmax_header_video) && !filmax_is_from_uploads($filmax_header_video)) {
	if (filmax_is_youtube_url($filmax_header_video) && preg_match('/[=\/]([^=\/]*)$/', $filmax_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$filmax_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($filmax_header_video) . '[/embed]' ));
			$filmax_embed_video = filmax_make_video_autoplay($filmax_embed_video);
		} else {
			$filmax_header_video = str_replace('/watch?v=', '/embed/', $filmax_header_video);
			$filmax_header_video = filmax_add_to_url($filmax_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$filmax_embed_video = '<iframe src="' . esc_url($filmax_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php filmax_show_layout($filmax_embed_video); ?></div><?php
	}
}
?>