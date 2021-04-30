<?php
$filmax_args = array_merge(array(
								'style' => 'normal',
								'class' => '',
								'ajax' => false
								), (array) get_query_var('filmax_search_args'));
?><div class="search_wrap search_style_<?php
								echo esc_attr($filmax_args['style']) 
									. (!empty($filmax_args['class']) ? ' '.esc_attr($filmax_args['class']) : '');
?>">
	<div class="search_form_wrap">
		<form role="search" method="get" class="search_form" action="<?php echo esc_url(home_url('/')); ?>">
			<input type="text" class="search_field" placeholder="<?php esc_attr_e('Search', 'filmax'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
			<button type="submit" class="search_submit icon-search"></button>
		</form>
	</div>
</div>