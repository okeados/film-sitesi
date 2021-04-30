<?php
/**
 * Theme Options and override-options support
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.29
 */


// -----------------------------------------------------------------
// -- Override options
// -----------------------------------------------------------------

if ( !function_exists('filmax_init_override_options') ) {
	add_action( 'after_setup_theme', 'filmax_init_override_options' );
	function filmax_init_override_options() {
		if ( is_admin() ) {
			add_action('admin_enqueue_scripts',	'filmax_add_override_options_scripts');
			add_action('save_post',				'filmax_save_override_options');
			add_filter('trx_addons_filter_override_options',		'filmax_add_override_options');
		}
	}
}
	
// Load required styles and scripts for admin mode
if ( !function_exists( 'filmax_add_override_options_scripts' ) ) {
	//Handler of the add_action("admin_enqueue_scripts", 'filmax_add_override_options_scripts');
	function filmax_add_override_options_scripts() {
		// If current screen is 'Edit Page' - load font icons
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && filmax_allow_override_options(!empty($screen->post_type) ? $screen->post_type : $screen->id)) {
			wp_enqueue_style( 'fontello-embedded',  filmax_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'jquery-ui-accordion', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'filmax-options', filmax_get_file_url('theme-options/theme-options.js'), array('jquery'), null, true );
			wp_localize_script( 'filmax-options', 'filmax_dependencies', filmax_get_theme_dependencies() );
		}
	}
}


// Check if Override options is allow
if (!function_exists('filmax_allow_override_options')) {
	function filmax_allow_override_options($post_type) {
		return apply_filters('filmax_filter_allow_override_options', in_array($post_type, array('page', 'post')), $post_type);
	}
}

// Add override options
if (!function_exists('filmax_add_override_options')) {
	function filmax_add_override_options($boxes = array()) {
		global $post_type;
		if (filmax_allow_override_options($post_type)) {
			$boxes[] = array('id' => sprintf('filmax_override_options_%s', $post_type),
				'title' =>  esc_html__('Theme Options', 'filmax'),
				'callback' => 'filmax_show_override_options',
				'page' => $post_type,
				'context' => 'advanced',
				'priority' => 'default'
			);
		}
		return $boxes;
	}
}

// Callback function to show fields in override options
if (!function_exists('filmax_show_override_options')) {
	function filmax_show_override_options() {
		global $post, $post_type;
		if (filmax_allow_override_options($post_type)) {
			// Load saved options 
			$meta = get_post_meta($post->ID, 'filmax_options', true);
			$tabs_titles = $tabs_content = array();
			global $FILMAX_STORAGE;
			// Refresh linked data if this field is controller for the another (linked) field
			// Do this before show fields to refresh data in the $FILMAX_STORAGE
			foreach ($FILMAX_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
				if (!empty($v['linked'])) {
					$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
					if (!empty($v['val']) && !filmax_is_inherit($v['val']))
						filmax_refresh_linked_data($v['val'], $v['linked']);
				}
			}
			// Show fields
			foreach ($FILMAX_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
				if (empty($v['override']['section']))
					$v['override']['section'] = esc_html__('General', 'filmax');
				if (!isset($tabs_titles[$v['override']['section']])) {
					$tabs_titles[$v['override']['section']] = $v['override']['section'];
					$tabs_content[$v['override']['section']] = '';
				}
				$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
				$tabs_content[$v['override']['section']] .= filmax_options_show_field($k, $v, $post_type);
			}
			if (count($tabs_titles) > 0) {
				?>
				<div class="filmax_options filmax_override_options">
					<input type="hidden" name="override_options_post_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
					<input type="hidden" name="override_options_post_type" value="<?php echo esc_attr($post_type); ?>" />
					<div id="filmax_options_tabs" class="filmax_tabs">
						<ul><?php
							$cnt = 0;
							foreach ($tabs_titles as $k=>$v) {
								$cnt++;
								?><li><a href="#filmax_options_<?php echo esc_attr($cnt); ?>"><?php echo esc_html($v); ?></a></li><?php
							}
						?></ul>
						<?php
							$cnt = 0;
							foreach ($tabs_content as $k=>$v) {
								$cnt++;
								?>
								<div id="filmax_options_<?php echo esc_attr($cnt); ?>" class="filmax_tabs_section filmax_options_section">
									<?php filmax_show_layout($v); ?>
								</div>
								<?php
							}
						?>
					</div>
				</div>
				<?php		
			}
		}
	}
}


// Save data from override options
if (!function_exists('filmax_save_override_options')) {
	//Handler of the add_action('save_post', 'filmax_save_override_options');
	function filmax_save_override_options($post_id) {

		// verify nonce
		if ( !wp_verify_nonce( filmax_get_value_gp('override_options_post_nonce'), admin_url() ) )
			return $post_id;

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		$post_type = wp_kses_data(wp_unslash(isset($_POST['override_options_post_type']) ? $_POST['override_options_post_type'] : $_POST['post_type']));

		// check permissions
		$capability = 'page';
		$post_types = get_post_types( array( 'name' => $post_type), 'objects' );
		if (!empty($post_types) && is_array($post_types)) {
			foreach ($post_types  as $type) {
				$capability = $type->capability_type;
				break;
			}
		}
		if (!current_user_can('edit_'.($capability), $post_id)) {
			return $post_id;
		}

		// Save meta
		$meta = array();
		$options = filmax_storage_get('options');
		foreach ($options as $k=>$v) {
			// Skip not overriden options
			if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
			// Skip inherited options
			if (!empty($_POST['filmax_options_inherit_' . $k])) continue;
			// Get option value from POST
			$meta[$k] = isset($_POST['filmax_options_field_' . $k])
							? filmax_get_value_gp('filmax_options_field_' . $k)
							: ($v['type']=='checkbox' ? 0 : '');
		}
		update_post_meta($post_id, 'filmax_options', $meta);
		
		// Save separate meta options to search template pages
		if ($post_type=='page' && !empty($_POST['page_template']) && $_POST['page_template']=='blog.php') {
			update_post_meta($post_id, 'filmax_options_post_type', isset($meta['post_type']) ? $meta['post_type'] : 'post');
			update_post_meta($post_id, 'filmax_options_parent_cat', isset($meta['parent_cat']) ? $meta['parent_cat'] : 0);
		}
	}
}
?>