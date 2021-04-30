<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage FILMAX
 * @since FILMAX 1.0.22
 */

if (!defined("FILMAX_THEME_FREE")) define("FILMAX_THEME_FREE", false);
if (!defined("FILMAX_THEME_FREE_WP")) define("FILMAX_THEME_FREE_WP", false);

// Theme storage
$FILMAX_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'filmax'),
			
			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'contact-form-7'				=> esc_html__('Contact Form 7', 'filmax'),
			'mailchimp-for-wp'				=> esc_html__('MailChimp for WP', 'filmax')
		),

		// List of plugins for the FREE version only
		//-----------------------------------------------------
		FILMAX_THEME_FREE 
			? array(
					// Recommended (supported) plugins for the FREE (lite) version
					)

		// List of plugins for the PREMIUM version only
		//-----------------------------------------------------
			: array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'essential-grid'			=> esc_html__('Essential Grid', 'filmax'),
					'js_composer'				=> esc_html__('WPBakery Page Builder', 'filmax'),
					'trx_updater'				=> esc_html__('ThemeREX Updater', 'filmax'),
					)
	),
	
	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> 'http://filmax.themerex.net',
	'theme_doc_url'		=> 'http://filmax.themerex.net/doc',
	'theme_download_url'=> 'https://themeforest.net/item/filmax-movie-magazine-wp-theme/21430771',

	'theme_support_url'	=> 'https://themerex.net/support/',								// ThemeREX

	'theme_video_url'	=> 'https://www.youtube.com/channel/UCnFisBimrK2aIE-hnY70kCA',	// ThemeREX

	// Responsive resolutions
	// Parameters to create css media query: min, max, 
	'responsive' => array(
						// By device
						'desktop'	=> array('min' => 1680),
						'notebook'	=> array('min' => 1280, 'max' => 1679),
						'tablet'	=> array('min' =>  768, 'max' => 1279),
						'mobile'	=> array('max' =>  767),
						// By size
						'xxl'		=> array('max' => 1679),
						'xl'		=> array('max' => 1439),
						'lg'		=> array('max' => 1279),
						'md'		=> array('max' => 1023),
						'sm'		=> array('max' =>  767),
						'sm_wp'		=> array('max' =>  600),
						'xs'		=> array('max' =>  479)
						)
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('filmax_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'filmax_customizer_theme_setup1', 1 );
	function filmax_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		filmax_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for the main and the child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes

			'customize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame

			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts

			'comment_maxlength'		=> 1000,		// Max length of the message from contact form

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'

			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:
													// vc (default) - standard VC icons selector (very slow and don't support images)
													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> false,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false,		// Allow upload not pre-packaged plugins via TGMPA
			
			'allow_no_image'		=> false		// Allow use image placeholder if no image present in the blog, related posts, post navigation, etc.
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// For example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		filmax_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Roboto',
				'family' => 'sans-serif',
				'styles' => '300,300italic,400,400italic,700,700italic'		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'	 => 'Roboto Condensed',
				'family' => 'sans-serif',
				'styles' => '300,300i,400,400i,700,700i'
				),
			array(
				'name'	 => 'Lora',
				'family' => 'serif',
				'styles' => '400,400i,700,700i'
				),
			// Font-face packed with theme
		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		filmax_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!

		filmax_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'filmax'),
				'description'		=> esc_html__('Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'filmax'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.568em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.9em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'filmax'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '2.313em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '0.975em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '-1.55px',
				'margin-top'		=> '2.4em',
				'margin-bottom'		=> '1.02em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'filmax'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '1.688em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.05em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '-1.15px',
				'margin-top'		=> '2em',
				'margin-bottom'		=> '0.74em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'filmax'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '1.500em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.05em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '-1px',
				'margin-top'		=> '1.75em',
				'margin-bottom'		=> '0.816em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'filmax'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '1.188em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.05em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '-0.8px',
				'margin-top'		=> '1.9em',
				'margin-bottom'		=> '1.2em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'filmax'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '1.063em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.15em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '-0.355px',
				'margin-top'		=> '1.8em',
				'margin-bottom'		=> '1.25em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'filmax'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '1em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.08em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '-0.33px',
				'margin-top'		=> '1.9em',
				'margin-bottom'		=> '1.02em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'filmax'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'filmax'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'filmax'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '13px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '18px',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'filmax'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'filmax'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '11px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '2.2px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'filmax'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'filmax'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '11px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'filmax'),
				'description'		=> esc_html__('Font settings of the main menu items', 'filmax'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0.75px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'filmax'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'filmax'),
				'font-family'		=> '"Roboto",sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'other' => array(
				'title'				=> esc_html__('Other', 'filmax'),
				'description'		=> esc_html__('Font settings of other items', 'filmax'),
				'font-family'		=> '"Lora",serif'
			)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		filmax_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'filmax'),
							'description'	=> esc_html__('Colors of the main content area', 'filmax')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'filmax'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'filmax')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'filmax'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'filmax')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'filmax'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'filmax')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'filmax'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'filmax')
							),
			)
		);
		filmax_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'filmax'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'filmax')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'filmax'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'filmax')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'filmax'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'filmax')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'filmax'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'filmax')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'filmax'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'filmax')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'filmax'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'filmax')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'filmax'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'filmax')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'filmax'),
							'description'	=> esc_html__('Color of the links inside this block', 'filmax')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'filmax'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'filmax')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'filmax'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'filmax')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'filmax'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'filmax')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'filmax'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'filmax')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'filmax'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'filmax')
							)
			)
		);
		filmax_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'filmax'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff',
					'bd_color'			=> '#e3e5eb', //ok
		
					// Text and links colors
					'text'				=> '#737373', //ok
					'text_light'		=> '#9c9c9c', //ok
					'text_dark'			=> '#1a1d24', //ok
					'text_link'			=> '#e0041d', //ok
					'text_hover'		=> '#bb081c', //ok
					'text_link2'		=> '#f8b350', //ok
					'text_hover2'		=> '#eca948', //ok
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#f2f2f2', //ok
					'alter_bg_hover'	=> '#ededed', //ok
					'alter_bd_color'	=> '#e3e5eb', //ok
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#6f6f6f', //ok
					'alter_light'		=> '#898989', //ok
					'alter_dark'		=> '#1a1d24', //ok
					'alter_link'		=> '#e0041d', //ok
					'alter_hover'		=> '#bb081c', //ok
					'alter_link2'		=> '#f8b350', //ok
					'alter_hover2'		=> '#eca948', //ok
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#1a1d24', //ok
					'extra_bg_hover'	=> '#28272e',
					'extra_bd_color'	=> '#343434', //ok
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#898989', //ok
					'extra_light'		=> '#afafaf', //ok
					'extra_dark'		=> '#a8a8a8', //ok
					'extra_link'		=> '#e0041d', //ok
					'extra_hover'		=> '#bb081c', //ok
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#ffffff', //ok
					'input_bg_hover'	=> '#ffffff', //ok
					'input_bd_color'	=> '#ededed', //ok
					'input_bd_hover'	=> '#1a1d24', //ok
					'input_text'		=> '#9c9c9c', //ok
					'input_light'		=> '#9c9c9c', //ok
					'input_dark'		=> '#0f1214', //ok
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#333333',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'filmax'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#1a1d24', //ok
					'bd_color'			=> '#474c50', //ok
		
					// Text and links colors
					'text'				=> '#a8a8a8', //ok
					'text_light'		=> '#8b8b8b', //ok
					'text_dark'			=> '#ffffff', //ok
					'text_link'			=> '#e0041d', //ok
					'text_hover'		=> '#bb081c', //ok
					'text_link2'		=> '#f8b350', //ok
					'text_hover2'		=> '#eca948', //ok
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#272a33', //ok
					'alter_bg_hover'	=> '#2b2e38', //ok
					'alter_bd_color'	=> '#2f333d', //ok
					'alter_bd_hover'	=> '#4a4a4a',
					'alter_text'		=> '#b8babb', //ok
					'alter_light'		=> '#909090', //ok
					'alter_dark'		=> '#ffffff', //ok
					'alter_link'		=> '#e0041d', //ok
					'alter_hover'		=> '#bb081c', //ok
					'alter_link2'		=> '#f8b350', //ok
					'alter_hover2'		=> '#eca948', //ok
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#ffffff', //ok
					'extra_bg_hover'	=> '#f3f5f7', //ok
					'extra_bd_color'	=> '#e5e5e5', //ok
					'extra_bd_hover'	=> '#4a4a4a',
					'extra_text'		=> '#737373', //ok
					'extra_light'		=> '#b7b7b7', //ok
					'extra_dark'		=> '#737373', //ok
					'extra_link'		=> '#e0041d', //ok
					'extra_hover'		=> '#bb081c', //ok
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#1a1d24', //ok
					'input_bg_hover'	=> '#1a1d24', //ok
					'input_bd_color'	=> '#33363c', //ok
					'input_bd_hover'	=> '#f4f4f4', //ok
					'input_text'		=> '#8b8b8b', //ok
					'input_light'		=> '#8b8b8b', //ok
					'input_dark'		=> '#f4f4f4', //ok
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#5f5f5f',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			)
		
		));
		
		// Simple schemes substitution
		filmax_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		filmax_storage_set('scheme_colors_add', array(
			'bg_color_0'		=> array('color' => 'bg_color',			'alpha' => 0),
			'bg_color_02'		=> array('color' => 'bg_color',			'alpha' => 0.2),
			'bg_color_07'		=> array('color' => 'bg_color',			'alpha' => 0.7),
			'bg_color_08'		=> array('color' => 'bg_color',			'alpha' => 0.8),
			'bg_color_09'		=> array('color' => 'bg_color',			'alpha' => 0.97),
			'alter_bg_color_07'	=> array('color' => 'alter_bg_color',	'alpha' => 0.7),
			'alter_bg_color_04'	=> array('color' => 'alter_bg_color',	'alpha' => 0.4),
			'alter_bg_color_02'	=> array('color' => 'alter_bg_color',	'alpha' => 0.2),
			'alter_bd_color_02'	=> array('color' => 'alter_bd_color',	'alpha' => 0.2),
			'alter_link_02'		=> array('color' => 'alter_link',		'alpha' => 0.2),
			'alter_link_07'		=> array('color' => 'alter_link',		'alpha' => 0.7),
			'extra_bg_color_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'extra_link_02'		=> array('color' => 'extra_link',		'alpha' => 0.2),
			'extra_link_07'		=> array('color' => 'extra_link',		'alpha' => 0.7),
			'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		filmax_storage_set('theme_thumbs', apply_filters('filmax_filter_add_thumb_sizes', array(
			'filmax-thumb-huge'		=> array(
												'size'	=> array(1170, 658, true),
												'title' => esc_html__( 'Huge image', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			'filmax-thumb-big' 		=> array(
												'size'	=> array( 760, 428, true),
												'title' => esc_html__( 'Large image', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-big'
												),

			'filmax-thumb-med' 		=> array(
												'size'	=> array( 370, 283, true), //370, 208
												'title' => esc_html__( 'Medium image', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

			'filmax-thumb-tiny' 		=> array(
												'size'	=> array(  97,  81, true),
												'title' => esc_html__( 'Small avatar', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),

			'filmax-thumb-masonry-big' => array(
												'size'	=> array( 760,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			'filmax-thumb-masonry'		=> array(
												'size'	=> array( 370,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												),

			// NEW
			'filmax-thumb-tiny-extra' 		=> array(
												'size'	=> array(  105,  105, true),
												'title' => esc_html__( 'Small square avatar', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-tiny-extra'
												),
			'filmax-thumb-small'		=> array(
												'size'	=> array( 449,   258, true),
												'title' => esc_html__( 'Small image', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-small'
												),
			'filmax-thumb-square'		=> array(
												'size'	=> array( 600,   600, true),
												'title' => esc_html__( 'Square image', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-square'
												),
			'filmax-thumb-height'		=> array(
												'size'	=> array( 485,   665, true),
												'title' => esc_html__( 'Height image', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-height'
												),
			'filmax-thumb-height-extra'		=> array(
												'size'	=> array( 485,   598, true),
												'title' => esc_html__( 'Height image', 'filmax' ),
												'subst'	=> 'trx_addons-thumb-height-extra'
												),
			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'filmax_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'filmax_importer_set_options', 9 );
	function filmax_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(filmax_get_protocol() . '://demofiles.themerex.net/filmax/');
			// Required plugins
			$options['required_plugins'] = array_keys(filmax_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('Filmax Demo', 'filmax');
			$options['files']['default']['domain_dev'] = '';		// Developers domain
			$options['files']['default']['domain_demo']= esc_url('http://filmax.themerex.net');		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// Banners
			$options['banners'] = array(
				array(
					'image' => filmax_get_file_url('theme-specific/theme-about/images/frontpage.png'),
					'title' => esc_html__('Front Page Builder', 'filmax'),
					'content' => wp_kses(__("Create your front page right in the WordPress Customizer. There's no need in WPBakery Page Builder, or any other builder. Simply enable/disable sections, fill them out with content, and customize to your liking.", 'filmax'), 'filmax_kses_content' ),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('Watch Video Introduction', 'filmax'),
					'duration' => 20
					),
				array(
					'image' => filmax_get_file_url('theme-specific/theme-about/images/layouts.png'),
					'title' => esc_html__('Layouts Builder', 'filmax'),
					'content' => wp_kses(__('Use Layouts Builder to create and customize header and footer styles for your website. With a flexible page builder interface and custom shortcodes, you can create as many header and footer layouts as you want with ease.', 'filmax'), 'filmax_kses_content' ),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('Learn More', 'filmax'),
					'duration' => 20
					),
				array(
					'image' => filmax_get_file_url('theme-specific/theme-about/images/documentation.png'),
					'title' => esc_html__('Read Full Documentation', 'filmax'),
					'content' => wp_kses(__('Need more details? Please check our full online documentation for detailed information on how to use Filmax.', 'filmax'), 'filmax_kses_content' ),
					'link_url' => esc_url(filmax_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online Documentation', 'filmax'),
					'duration' => 15
					),
				array(
					'image' => filmax_get_file_url('theme-specific/theme-about/images/video-tutorials.png'),
					'title' => esc_html__('Video Tutorials', 'filmax'),
					'content' => wp_kses(__('No time for reading documentation? Check out our video tutorials and learn how to customize Filmax in detail.', 'filmax'), 'filmax_kses_content' ),
					'link_url' => esc_url(filmax_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video Tutorials', 'filmax'),
					'duration' => 15
					),
				array(
					'image' => filmax_get_file_url('theme-specific/theme-about/images/studio.png'),
					'title' => esc_html__('Website Customization Studio', 'filmax'),
					'content' => wp_kses(__("Need a website fast? Order our custom service, and we'll build a website based on this theme for a very fair price. We can also implement additional functionality such as website translation, setting up WPML, and much more.", 'filmax'), 'filmax_kses_content' ),
					'link_url' => esc_url('https://themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall'),
					'link_caption' => esc_html__('Contact Us', 'filmax'),
					'duration' => 25
					)
				);
		}
		return $options;
	}
}




// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('filmax_create_theme_options')) {

	function filmax_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __('<b>Attention!</b> Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'filmax');

		filmax_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'filmax'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'filmax'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'filmax'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'filmax') ),
				"class" => "filmax_column-1_2 filmax_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'filmax'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'filmax') ),
				"class" => "filmax_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_zoom' => array(
				"title" => esc_html__('Logo zoom', 'filmax'),
				"desc" => wp_kses_data( __("Zoom the logo. 1 - original size. Maximum size of logo depends on the actual size of the picture", 'filmax') ),
				"std" => 1,
				"min" => 0.2,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => FILMAX_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'filmax') ),
				"class" => "filmax_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => FILMAX_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'filmax') ),
				"class" => "filmax_column-1_2 filmax_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'filmax') ),
				"class" => "filmax_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => FILMAX_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'filmax') ),
				"class" => "filmax_column-1_2 filmax_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'filmax') ),
				"class" => "filmax_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => FILMAX_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'filmax') ),
				"class" => "filmax_column-1_2 filmax_new_row",
				"std" => '',
				"type" => "hidden"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'filmax') ),
				"class" => "filmax_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => "hidden"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'filmax'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'filmax'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'filmax'),
				"desc" => wp_kses_data( __('Select width of the body content', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'filmax')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => filmax_get_list_body_styles(),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'filmax') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'filmax')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'filmax'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'filmax')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'filmax'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'filmax'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'filmax')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'filmax'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'filmax')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'filmax'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'filmax') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),


			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'filmax'),
				"desc" => '',
				"type" => FILMAX_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'filmax'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'filmax')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => FILMAX_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'filmax'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'filmax')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => FILMAX_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'filmax'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'filmax')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => FILMAX_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'filmax'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'filmax')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => FILMAX_THEME_FREE ? "hidden" : "select"
				),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'filmax'),
				"desc" => '',
				"type" => "info",
				),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'filmax'),
				"desc" => wp_kses_data( __('Specify the border radius of the form fields and buttons in pixels or other valid CSS units', 'filmax') ),
				"std" => 0,
				"type" => "hidden"
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'filmax'),
				"desc" => '',
				"type" => FILMAX_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'filmax'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'filmax') ),
				"std" => 0,
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'privacy_text' => array(
				"title" => esc_html__("Text with Privacy Policy link", 'filmax'),
				"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'filmax') ),
				"std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'filmax'), 'filmax_kses_content' ),
				"type"  => "text"
			),
		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'filmax'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'filmax'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'filmax'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'filmax')
				),
				"std" => 'default',
				"options" => filmax_get_list_header_footer_types(),
				"type" => FILMAX_THEME_FREE || !filmax_exists_trx_addons() ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'filmax'),
				"desc" => wp_kses( __("Select custom header from Layouts Builder", 'filmax'), 'filmax_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'filmax')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => FILMAX_THEME_FREE ? 'header-custom-sow-header-default' : 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'filmax'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'filmax')
				),
				"std" => 'default',
				"options" => array(),
				"type" => FILMAX_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'filmax'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'filmax')
				),
				"std" => 0,
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'filmax'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'filmax') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => FILMAX_THEME_FREE ? "hidden" : "slider"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwidth', 'filmax'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'filmax')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'filmax'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'filmax') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'filmax'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'filmax'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'filmax') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'filmax'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'filmax')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => filmax_get_list_range(0,6),
				"type" => "select"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'filmax'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'filmax') ),
				"type" => FILMAX_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'filmax'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'filmax')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'filmax'),
				),
				"type" => FILMAX_THEME_FREE || !filmax_exists_trx_addons() ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'filmax'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'filmax')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'filmax'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'filmax')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'filmax'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'filmax') ),
				"std" => 1,
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'filmax'),
				"desc" => '',
				"type" => FILMAX_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'filmax'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'filmax') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'filmax')
				),
				"std" => 0,
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'filmax'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'filmax') ),
				"priority" => 500,
				"dependency" => array(
					'header_type' => array('default')
				),
				"type" => FILMAX_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'filmax'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'filmax') ),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 0,
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'filmax'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'filmax') ),
				"std" => '',
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => FILMAX_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'filmax'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'filmax'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'filmax'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'filmax'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'filmax'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
				),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'filmax'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'filmax'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'filmax')
				),
				"std" => 'default',
				"options" => filmax_get_list_header_footer_types(),
				"type" => FILMAX_THEME_FREE || !filmax_exists_trx_addons() ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'filmax'),
				"desc" => wp_kses( __("Select custom footer from Layouts Builder", 'filmax'), 'filmax_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'filmax')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => FILMAX_THEME_FREE ? 'footer-custom-sow-footer-default' : 'footer-custom-footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'filmax'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'filmax')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'filmax'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'filmax')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => filmax_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwidth', 'filmax'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'filmax') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'filmax')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'filmax'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'filmax') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'filmax') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'filmax') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => FILMAX_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'filmax'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'filmax') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => !filmax_exists_trx_addons() ? "hidden" : "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'filmax'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'filmax') ),
				"translate" => true,
				"std" => esc_html__('Copyright &copy; {Y} by ThemeREX. All rights reserved.', 'filmax'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'filmax'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'filmax') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'filmax'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'filmax') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'filmax'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'filmax'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'filmax')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'filmax'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'filmax') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'filmax')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('excerpt')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'filmax'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'filmax') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'filmax'),
						'fullpost'	=> esc_html__('Full post',	'filmax')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'filmax'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'filmax') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 15,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'filmax'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'filmax') ),
					"std" => 2,
					"options" => filmax_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'filmax'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'filmax') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'filmax')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'filmax'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'filmax') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'filmax')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'filmax'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'filmax') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'filmax')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'filmax'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'filmax') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'filmax')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'filmax'),
						'links'	=> esc_html__("Older/Newest", 'filmax'),
						'more'	=> esc_html__("Load more", 'filmax'),
						'infinite' => esc_html__("Infinite scroll", 'filmax')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'filmax'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'filmax') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'filmax')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'filmax'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'filmax'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'filmax') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'filmax'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'filmax') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'filmax'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'filmax') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'filmax'),
					"desc" => '',
					"type" => FILMAX_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'filmax'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'filmax') ),
					"std" => 'hide',
					"options" => array(),
					"type" => FILMAX_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'filmax'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'filmax') ),
					"std" => 'hide',
					"options" => array(),
					"type" => FILMAX_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'filmax'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'filmax') ),
					"std" => 'hide',
					"options" => array(),
					"type" => FILMAX_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'filmax'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'filmax') ),
					"std" => 'hide',
					"options" => array(),
					"type" => FILMAX_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'filmax'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'filmax'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'filmax') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'filmax'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'filmax') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'filmax'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'filmax') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'filmax'),
						'columns' => esc_html__('Mini-cards',	'filmax')
					),
					"type" => "hidden"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'filmax'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'filmax') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'filmax')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => "none",
					"options" => array(),
					"type" => FILMAX_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'filmax'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Counters and Share Links are available only if plugin ThemeREX Addons is active", 'filmax') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'filmax') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'filmax')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=0',
					"options" => array(
						'categories' => esc_html__('Categories', 'filmax'),
						'date'		 => esc_html__('Post date', 'filmax'),
						'author'	 => esc_html__('Post author', 'filmax'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'filmax'),
						'share'		 => esc_html__('Share links', 'filmax'),
						'edit'		 => esc_html__('Edit link', 'filmax')
					),
					"type" => FILMAX_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Views, Likes and Comments', 'filmax'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'filmax') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'filmax')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'filmax'),
						'likes' => esc_html__('Likes', 'filmax'),
						'comments' => esc_html__('Comments', 'filmax')
					),
					"type" => FILMAX_THEME_FREE || !filmax_exists_trx_addons() ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'filmax'),
					"desc" => wp_kses_data( __('Settings of the single post', 'filmax') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'filmax'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'filmax') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'filmax')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'filmax'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'filmax') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'filmax'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'filmax') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'filmax'),
					"desc" => wp_kses_data( __("Meta parts for single posts. Counters and Share Links are available only if plugin ThemeREX Addons is active", 'filmax') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'filmax') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'filmax'),
						'date'		 => esc_html__('Post date', 'filmax'),
						'author'	 => esc_html__('Post author', 'filmax'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'filmax'),
						'share'		 => esc_html__('Share links', 'filmax'),
						'edit'		 => esc_html__('Edit link', 'filmax')
					),
					"type" => FILMAX_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Views, Likes and Comments', 'filmax'),
					"desc" => wp_kses_data( __("Likes and Views are available only if plugin ThemeREX Addons is active", 'filmax') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'filmax'),
						'likes' => esc_html__('Likes', 'filmax'),
						'comments' => esc_html__('Comments', 'filmax')
					),
					"type" => FILMAX_THEME_FREE || !filmax_exists_trx_addons() ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'filmax'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'filmax') ),
					"std" => 1,
					"type" => !filmax_exists_trx_addons() ? "hidden" : "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'filmax'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'filmax') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'filmax'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'filmax'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'filmax') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'filmax')
					),
					"std" => 1,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'filmax'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'filmax') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => filmax_get_list_range(1,9),
					"type" => FILMAX_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'filmax'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page (from 2 to 4)?', 'filmax') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => filmax_get_list_range(1,4),
					"type" => FILMAX_THEME_FREE ? "hidden" : "switch"
					),
				'related_style' => array(
					"title" => esc_html__('Related posts style', 'filmax'),
					"desc" => wp_kses_data( __('Select style of the related posts output', 'filmax') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 1,
					"options" => filmax_get_list_styles(1,2),
					"type" => FILMAX_THEME_FREE ? "hidden" : "switch"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'filmax'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'filmax'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'filmax') ),
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'filmax'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'filmax')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'filmax'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'filmax')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'filmax'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'filmax')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => FILMAX_THEME_FREE ? "hidden" : "switch"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'filmax'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'filmax')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'filmax'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'filmax')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'filmax'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'filmax') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'filmax'),
				"desc" => '',
				"std" => '$filmax_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'filmax'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'filmax') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'filmax')
				),
				"hidden" => true,
				"std" => '',
				"type" => FILMAX_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'filmax'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'filmax') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'filmax')
				),
				"hidden" => true,
				"std" => '',
				"type" => FILMAX_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'filmax'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'filmax'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'filmax') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'filmax') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'filmax'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'filmax') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'filmax') ),
				"class" => "filmax_column-1_3 filmax_new_row",
				"refresh" => false,
				"std" => '$filmax_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=filmax_get_theme_setting('max_load_fonts'); $i++) {
			if (filmax_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(__('Font %s', 'filmax'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'filmax'),
				"desc" => '',
				"class" => "filmax_column-1_3 filmax_new_row",
				"refresh" => false,
				"std" => '$filmax_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'filmax'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'filmax') )
							: '',
				"class" => "filmax_column-1_3",
				"refresh" => false,
				"std" => '$filmax_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'filmax'),
					'serif' => esc_html__('serif', 'filmax'),
					'sans-serif' => esc_html__('sans-serif', 'filmax'),
					'monospace' => esc_html__('monospace', 'filmax'),
					'cursive' => esc_html__('cursive', 'filmax'),
					'fantasy' => esc_html__('fantasy', 'filmax')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'filmax'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'filmax') )
								. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'filmax') )
							: '',
				"class" => "filmax_column-1_3",
				"refresh" => false,
				"std" => '$filmax_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = filmax_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(__('%s settings', 'filmax'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses_post( sprintf(__('Font settings of the "%s" tag.', 'filmax'), $tag) ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$load_order = 1;
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
					$load_order = 2;		// Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'filmax'),
						'100' => esc_html__('100 (Light)', 'filmax'), 
						'200' => esc_html__('200 (Light)', 'filmax'), 
						'300' => esc_html__('300 (Thin)',  'filmax'),
						'400' => esc_html__('400 (Normal)', 'filmax'),
						'500' => esc_html__('500 (Semibold)', 'filmax'),
						'600' => esc_html__('600 (Semibold)', 'filmax'),
						'700' => esc_html__('700 (Bold)', 'filmax'),
						'800' => esc_html__('800 (Black)', 'filmax'),
						'900' => esc_html__('900 (Black)', 'filmax')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'filmax'),
						'normal' => esc_html__('Normal', 'filmax'), 
						'italic' => esc_html__('Italic', 'filmax')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'filmax'),
						'none' => esc_html__('None', 'filmax'), 
						'underline' => esc_html__('Underline', 'filmax'),
						'overline' => esc_html__('Overline', 'filmax'),
						'line-through' => esc_html__('Line-through', 'filmax')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'filmax'),
						'none' => esc_html__('None', 'filmax'), 
						'uppercase' => esc_html__('Uppercase', 'filmax'),
						'lowercase' => esc_html__('Lowercase', 'filmax'),
						'capitalize' => esc_html__('Capitalize', 'filmax')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "filmax_column-1_5",
					"refresh" => false,
					"load_order" => $load_order,
					"std" => '$filmax_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		filmax_storage_set_array_before('options', 'panel_colors', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			filmax_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'filmax'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'filmax') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'filmax')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			filmax_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'filmax'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'filmax') ),
				"class" => "filmax_column-1_2 filmax_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}
	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('filmax_options_get_list_cpt_options')) {
	function filmax_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'filmax'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'filmax'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'filmax') ),
						"std" => 'inherit',
						"options" => filmax_get_list_header_footer_types(true),
						"type" => FILMAX_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'filmax'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'filmax'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => FILMAX_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'filmax'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'filmax'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => FILMAX_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'filmax'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'filmax') ),
						"std" => 0,
						"type" => FILMAX_THEME_FREE ? "hidden" : "checkbox"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'filmax'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'filmax'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'filmax'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'filmax'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'filmax'), $title) ),
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'filmax'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'filmax'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'filmax'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'filmax') ),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'filmax'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'filmax'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'filmax') ),
						"std" => 'inherit',
						"options" => filmax_get_list_header_footer_types(true),
						"type" => FILMAX_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'filmax'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'filmax') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => FILMAX_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'filmax'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'filmax') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'filmax'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'filmax') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 0,
						"options" => filmax_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwidth', 'filmax'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'filmax') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'filmax'),
						"desc" => '',
						"type" => FILMAX_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'filmax'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'filmax') ),
						"std" => 'hide',
						"options" => array(),
						"type" => FILMAX_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'filmax'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'filmax') ),
						"std" => 'hide',
						"options" => array(),
						"type" => FILMAX_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'filmax'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'filmax') ),
						"std" => 'hide',
						"options" => array(),
						"type" => FILMAX_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'filmax'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'filmax') ),
						"std" => 'hide',
						"options" => array(),
						"type" => FILMAX_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('filmax_options_get_list_choises')) {
	add_filter('filmax_filter_options_get_list_choises', 'filmax_options_get_list_choises', 10, 2);
	function filmax_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = filmax_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = filmax_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = filmax_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (strpos($id, '_scheme') > 0)
				$list = filmax_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = filmax_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = filmax_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = filmax_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = filmax_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = filmax_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = filmax_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = filmax_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = filmax_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = filmax_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = filmax_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = filmax_array_merge(array(0 => esc_html__('- Select category -', 'filmax')), filmax_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = filmax_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = filmax_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = filmax_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>