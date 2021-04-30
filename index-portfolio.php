<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0
 */

filmax_storage_set('blog_archive', true);

get_header();
filmax_mod_pagination();
if (have_posts()) {

	filmax_show_layout(get_query_var('blog_archive_start'));

	$filmax_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$filmax_sticky_out = filmax_get_theme_option('sticky_style')=='columns' 
							&& is_array($filmax_stickies) && count($filmax_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$filmax_cat = filmax_get_theme_option('parent_cat');
	$filmax_post_type = filmax_get_theme_option('post_type');
	$filmax_taxonomy = filmax_get_post_type_taxonomy($filmax_post_type);
	$filmax_show_filters = filmax_get_theme_option('show_filters');
	$filmax_tabs = array();
	if (!filmax_is_off($filmax_show_filters)) {
		$filmax_args = array(
			'type'			=> $filmax_post_type,
			'child_of'		=> $filmax_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'number'		=> '',
			'taxonomy'		=> $filmax_taxonomy,
			'pad_counts'	=> false
		);
		$filmax_portfolio_list = get_terms($filmax_args);
		if (is_array($filmax_portfolio_list) && count($filmax_portfolio_list) > 0) {
			$filmax_tabs[$filmax_cat] = esc_html__('All', 'filmax');
			foreach ($filmax_portfolio_list as $filmax_term) {
				if (isset($filmax_term->term_id)) $filmax_tabs[$filmax_term->term_id] = $filmax_term->name;
			}
		}
	}
	if (count($filmax_tabs) > 0) {
		$filmax_portfolio_filters_ajax = true;
		$filmax_portfolio_filters_active = $filmax_cat;
		$filmax_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters filmax_tabs filmax_tabs_ajax">
			<ul class="portfolio_titles filmax_tabs_titles">
				<?php
				foreach ($filmax_tabs as $filmax_id=>$filmax_title) {
					?><li><a href="<?php echo esc_url(filmax_get_hash_link(sprintf('#%s_%s_content', $filmax_portfolio_filters_id, $filmax_id))); ?>" data-tab="<?php echo esc_attr($filmax_id); ?>"><?php echo esc_html($filmax_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$filmax_ppp = filmax_get_theme_option('posts_per_page');
			if (filmax_is_inherit($filmax_ppp)) $filmax_ppp = '';
			foreach ($filmax_tabs as $filmax_id=>$filmax_title) {
				$filmax_portfolio_need_content = $filmax_id==$filmax_portfolio_filters_active || !$filmax_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $filmax_portfolio_filters_id, $filmax_id)); ?>"
					class="portfolio_content filmax_tabs_content"
					data-blog-template="<?php echo esc_attr(filmax_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(filmax_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($filmax_ppp); ?>"
					data-post-type="<?php echo esc_attr($filmax_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($filmax_taxonomy); ?>"
					data-cat="<?php echo esc_attr($filmax_id); ?>"
					data-parent-cat="<?php echo esc_attr($filmax_cat); ?>"
					data-need-content="<?php echo (false===$filmax_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($filmax_portfolio_need_content) 
						filmax_show_portfolio_posts(array(
							'cat' => $filmax_id,
							'parent_cat' => $filmax_cat,
							'taxonomy' => $filmax_taxonomy,
							'post_type' => $filmax_post_type,
							'page' => 1,
							'sticky' => $filmax_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		filmax_show_portfolio_posts(array(
			'cat' => $filmax_cat,
			'parent_cat' => $filmax_cat,
			'taxonomy' => $filmax_taxonomy,
			'post_type' => $filmax_post_type,
			'page' => 1,
			'sticky' => $filmax_sticky_out
			)
		);
	}

	filmax_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>